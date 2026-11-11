<?php
/**
 * GitHub webhook receiver: deploys the ArcUnify theme on every push to main.
 *
 * Install
 * 1. Upload this file to the WordPress root (the folder with wp-config.php),
 *    e.g. as au-deploy.php.
 * 2. Upload au-deploy-config.php one level ABOVE the WordPress root
 *    (e.g. /home/teksetda/au-deploy-config.php). It holds the secret.
 * 3. GitHub repo → Settings → Webhooks → Add webhook:
 *    Payload URL  https://arcunify.com/au-deploy.php
 *    Content type application/json
 *    Secret       the same secret as in au-deploy-config.php
 *    Events       Just the push event
 *
 * What it does on a push to main
 * - Verifies GitHub's HMAC signature (X-Hub-Signature-256); anything else gets 403.
 * - Downloads that exact commit as a .tar.gz from GitHub (public repo, no token needed)
 *   and reads it in memory. Needs only zlib, not ZipArchive.
 * - Writes changed files into wp-content/themes/arcunify. Never deletes server files.
 * - Logs every run to au-deploy.log next to the config file (not web-readable).
 *   A GitHub "ping" logs what this server supports.
 *
 * Requires PHP 7.4+, zlib (gzdecode), and outbound HTTPS (curl or allow_url_fopen).
 */

// ---------------------------------------------------------------------------
// Settings
// ---------------------------------------------------------------------------

const AU_REPO      = 'FazalPK/arcunify';
const AU_BRANCH    = 'main';
const AU_THEME_DIR = __DIR__ . '/wp-content/themes/arcunify';
const AU_PRIVATE   = __DIR__ . '/..'; // Holds the config and the log; outside the web root.

// Repo paths that are never copied to the server.
const AU_EXCLUDE = array(
	'.git',
	'.github',
	'.gitignore',
	'.gitattributes',
	'.vscode',
	'tools',
	'README.md',
	'deploy.ps1',
	'build.sh',
	'arcunify-conversation-export.md',
);

// ---------------------------------------------------------------------------

function au_respond( $code, $message ) {
	http_response_code( $code );
	header( 'Content-Type: text/plain; charset=utf-8' );
	echo $message;
}

function au_log( $line ) {
	@file_put_contents( AU_PRIVATE . '/au-deploy.log', gmdate( 'Y-m-d H:i:s' ) . ' UTC  ' . $line . "\n", FILE_APPEND | LOCK_EX );
}

/**
 * What this server can do, for the ping log line.
 */
function au_capabilities() {
	$yes = static function ( $ok ) {
		return $ok ? 'yes' : 'NO';
	};
	return sprintf(
		'php=%s curl=%s url_fopen=%s zlib=%s theme_dir=%s writable=%s',
		PHP_VERSION,
		$yes( function_exists( 'curl_init' ) ),
		$yes( (bool) ini_get( 'allow_url_fopen' ) ),
		$yes( function_exists( 'gzdecode' ) ),
		$yes( is_dir( AU_THEME_DIR ) ),
		$yes( is_writable( AU_THEME_DIR ) )
	);
}

/**
 * GET a URL and return the body. Throws unless the response is HTTP 200.
 */
function au_http_get( $url ) {
	if ( function_exists( 'curl_init' ) ) {
		$ch = curl_init( $url );
		curl_setopt_array(
			$ch,
			array(
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_MAXREDIRS      => 5,
				CURLOPT_USERAGENT      => 'arcunify-deploy-hook',
				CURLOPT_CONNECTTIMEOUT => 20,
				CURLOPT_TIMEOUT        => 120,
			)
		);
		$body   = curl_exec( $ch );
		$status = (int) curl_getinfo( $ch, CURLINFO_RESPONSE_CODE );
		$error  = curl_error( $ch );
		curl_close( $ch );
		if ( false === $body || 200 !== $status ) {
			throw new RuntimeException( "Download failed (HTTP $status) $error" );
		}
		return $body;
	}
	if ( ! ini_get( 'allow_url_fopen' ) ) {
		throw new RuntimeException( 'Download failed: neither curl nor allow_url_fopen is available.' );
	}
	$context = stream_context_create(
		array(
			'http' => array(
				'user_agent'    => 'arcunify-deploy-hook',
				'timeout'       => 120,
				'ignore_errors' => true,
			),
		)
	);
	$body   = @file_get_contents( $url, false, $context );
	$status = 0;
	foreach ( (array) ( $http_response_header ?? array() ) as $header ) {
		if ( preg_match( '#^HTTP/\S+\s+(\d{3})#', $header, $m ) ) {
			$status = (int) $m[1]; // The last status line wins (after redirects).
		}
	}
	if ( false === $body || 200 !== $status ) {
		throw new RuntimeException( "Download failed (HTTP $status)" );
	}
	return $body;
}

/**
 * Parse a POSIX/pax tar archive held in memory.
 *
 * @return array path => file contents (regular files only).
 */
function au_untar( $tar ) {
	$files  = array();
	$length = strlen( $tar );
	$offset = 0;
	$pax    = array(); // Per-entry pax header (applies to the next entry only).
	$global = array(); // Global pax header (applies to all following entries).

	while ( $offset + 512 <= $length ) {
		$header = substr( $tar, $offset, 512 );
		if ( "\0" === $header[0] && '' === trim( $header, "\0" ) ) {
			break; // End-of-archive marker.
		}

		// Header checksum: sum of all bytes with the checksum field read as spaces.
		$stored = au_octal( substr( $header, 148, 8 ) );
		$sum    = 0;
		$check  = substr_replace( $header, '        ', 148, 8 );
		for ( $i = 0; $i < 512; $i++ ) {
			$sum += ord( $check[ $i ] );
		}
		if ( $sum !== $stored ) {
			throw new RuntimeException( 'Archive is corrupt (bad tar header checksum).' );
		}

		$name   = rtrim( substr( $header, 0, 100 ), "\0" );
		$prefix = rtrim( substr( $header, 345, 155 ), "\0" );
		$size   = au_octal( substr( $header, 124, 12 ) );
		$type   = $header[156];
		$data   = substr( $tar, $offset + 512, $size );
		$offset += 512 + (int) ( ceil( $size / 512 ) * 512 );

		if ( 'x' === $type || 'g' === $type ) {
			$records = au_pax_records( $data );
			if ( 'g' === $type ) {
				$global = array_merge( $global, $records );
			} else {
				$pax = $records;
			}
			continue;
		}

		$path = $pax['path'] ?? ( '' !== $prefix ? $prefix . '/' . $name : $name );
		$pax  = array();

		if ( '0' === $type || "\0" === $type ) {
			$files[ $path ] = $data;
		}
		// Directories ('5') are created as needed; links and other types are ignored.
	}
	return $files;
}

/**
 * Read a tar numeric field (octal ASCII, space/NUL padded).
 */
function au_octal( $field ) {
	$field = trim( $field, " \0" );
	if ( ! preg_match( '/^[0-7]+$/', $field ) ) {
		throw new RuntimeException( 'Archive is corrupt (bad tar header).' );
	}
	return octdec( $field );
}

/**
 * Parse pax extended header records ("<len> key=value\n").
 */
function au_pax_records( $data ) {
	$records = array();
	$pos     = 0;
	while ( $pos < strlen( $data ) && preg_match( '/\G(\d+) ([^=]+)=/', $data, $m, 0, $pos ) ) {
		$len  = (int) $m[1];
		$head = strlen( $m[0] );
		if ( $len < $head + 1 ) {
			break;
		}
		$records[ $m[2] ] = substr( $data, $pos + $head, $len - $head - 1 );
		$pos             += $len;
	}
	return $records;
}

function au_is_excluded( $relative ) {
	$first = explode( '/', $relative, 2 )[0];
	return in_array( $first, AU_EXCLUDE, true ) || in_array( $relative, AU_EXCLUDE, true );
}

/**
 * Download a commit and write changed files into the theme.
 *
 * @return array Paths that were updated.
 */
function au_deploy( $sha ) {
	if ( ! function_exists( 'gzdecode' ) ) {
		throw new RuntimeException( 'PHP zlib (gzdecode) is not available.' );
	}
	if ( ! is_dir( AU_THEME_DIR ) ) {
		throw new RuntimeException( 'Theme folder not found: ' . AU_THEME_DIR );
	}

	$gz  = au_http_get( 'https://codeload.github.com/' . AU_REPO . '/tar.gz/' . $sha );
	$tar = gzdecode( $gz );
	unset( $gz );
	if ( false === $tar ) {
		throw new RuntimeException( 'Download is not a valid .tar.gz.' );
	}
	$entries = au_untar( $tar );
	unset( $tar );

	// GitHub archives contain one top folder, e.g. arcunify-<sha>/. Strip it.
	$files = array();
	foreach ( $entries as $path => $contents ) {
		$parts = explode( '/', $path, 2 );
		if ( 2 === count( $parts ) && '' !== $parts[1] ) {
			$files[ $parts[1] ] = $contents;
		}
	}
	if ( ! isset( $files['style.css'] ) ) {
		throw new RuntimeException( 'Unexpected archive layout (no style.css at the top).' );
	}

	$changed = array();
	$failed  = array();
	foreach ( $files as $relative => $contents ) {
		if ( au_is_excluded( $relative ) ) {
			continue;
		}
		$segments = explode( '/', $relative );
		if ( in_array( '..', $segments, true ) || in_array( '', $segments, true ) || false !== strpos( $relative, '\\' ) ) {
			$failed[] = "$relative (unsafe path)";
			continue;
		}
		$target = AU_THEME_DIR . '/' . $relative;
		if ( is_file( $target ) && md5_file( $target ) === md5( $contents ) ) {
			continue;
		}
		$dir = dirname( $target );
		if ( ! is_dir( $dir ) && ! mkdir( $dir, 0755, true ) ) {
			$failed[] = "$relative (cannot create folder)";
			continue;
		}
		$tmp = $target . '.au-tmp';
		if ( false === file_put_contents( $tmp, $contents ) || ! rename( $tmp, $target ) ) {
			@unlink( $tmp );
			$failed[] = "$relative (cannot write)";
			continue;
		}
		@chmod( $target, 0644 );
		if ( function_exists( 'opcache_invalidate' ) && '.php' === substr( $relative, -4 ) ) {
			@opcache_invalidate( $target, true );
		}
		$changed[] = $relative;
	}

	if ( $failed ) {
		throw new RuntimeException( count( $failed ) . ' file(s) not written: ' . implode( ', ', $failed ) . ( $changed ? ' | written: ' . implode( ', ', $changed ) : '' ) );
	}
	return $changed;
}

// ---------------------------------------------------------------------------
// Request handling
// ---------------------------------------------------------------------------

if ( 'POST' !== ( $_SERVER['REQUEST_METHOD'] ?? '' ) ) {
	au_respond( 405, 'Method not allowed' );
	exit;
}

$config = @include AU_PRIVATE . '/au-deploy-config.php';
$secret = is_array( $config ) ? (string) ( $config['secret'] ?? '' ) : '';
if ( strlen( $secret ) < 32 ) {
	au_log( 'ERROR config missing or secret shorter than 32 characters' );
	au_respond( 500, 'Not configured' );
	exit;
}

$body      = file_get_contents( 'php://input' );
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '';
if ( ! hash_equals( 'sha256=' . hash_hmac( 'sha256', $body, $secret ), $signature ) ) {
	au_log( 'REJECTED bad signature from ' . ( $_SERVER['REMOTE_ADDR'] ?? '?' ) );
	au_respond( 403, 'Forbidden' );
	exit;
}

$event   = $_SERVER['HTTP_X_GITHUB_EVENT'] ?? '';
$payload = json_decode( $body, true );

if ( 'ping' === $event ) {
	au_log( 'PING ok  ' . au_capabilities() );
	au_respond( 200, 'pong' );
	exit;
}
if ( 'push' !== $event || ! is_array( $payload ) ) {
	au_respond( 202, 'Ignored event' );
	exit;
}
if ( ( $payload['ref'] ?? '' ) !== 'refs/heads/' . AU_BRANCH || ( $payload['repository']['full_name'] ?? '' ) !== AU_REPO ) {
	au_respond( 202, 'Ignored: not ' . AU_BRANCH );
	exit;
}

$sha = (string) ( $payload['after'] ?? '' );
if ( ! preg_match( '/^[0-9a-f]{40}$/', $sha ) || ! empty( $payload['deleted'] ) ) {
	au_respond( 202, 'Ignored: no commit' );
	exit;
}

// Answer GitHub now (it times out after 10 seconds), then deploy.
au_respond( 202, 'Deploying ' . substr( $sha, 0, 7 ) );
if ( function_exists( 'litespeed_finish_request' ) ) {
	litespeed_finish_request(); // Namecheap runs LiteSpeed.
} elseif ( function_exists( 'fastcgi_finish_request' ) ) {
	fastcgi_finish_request();
}
ignore_user_abort( true );
set_time_limit( 300 );

$lock = fopen( AU_PRIVATE . '/au-deploy.lock', 'c' );
if ( ! $lock || ! flock( $lock, LOCK_EX ) ) {
	au_log( 'ERROR cannot get deploy lock' );
	exit;
}

try {
	$changed = au_deploy( $sha );
	au_log( sprintf( 'DEPLOYED %s by %s: %d file(s)%s', substr( $sha, 0, 7 ), $payload['pusher']['name'] ?? '?', count( $changed ), $changed ? ' — ' . implode( ', ', $changed ) : '' ) );
} catch ( Throwable $e ) {
	au_log( 'FAILED ' . substr( $sha, 0, 7 ) . ': ' . $e->getMessage() );
} finally {
	flock( $lock, LOCK_UN );
	fclose( $lock );
}
