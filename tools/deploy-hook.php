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
 * - Downloads that exact commit as a zip from GitHub (public repo, no token needed).
 * - Copies changed files into wp-content/themes/arcunify. Never deletes server files.
 * - Logs every run to au-deploy.log next to the config file (not web-readable).
 *
 * Requires PHP 7.4+, ZipArchive, and outbound HTTPS (curl or allow_url_fopen).
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

function au_download( $url, $dest ) {
	if ( function_exists( 'curl_init' ) ) {
		$fh = fopen( $dest, 'wb' );
		$ch = curl_init( $url );
		curl_setopt_array(
			$ch,
			array(
				CURLOPT_FILE           => $fh,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_USERAGENT      => 'arcunify-deploy-hook',
				CURLOPT_TIMEOUT        => 120,
				CURLOPT_FAILONERROR    => true,
			)
		);
		$ok    = curl_exec( $ch );
		$error = curl_error( $ch );
		curl_close( $ch );
		fclose( $fh );
		if ( ! $ok ) {
			throw new RuntimeException( 'Download failed: ' . $error );
		}
		return;
	}
	$context = stream_context_create( array( 'http' => array( 'user_agent' => 'arcunify-deploy-hook', 'timeout' => 120 ) ) );
	$data    = @file_get_contents( $url, false, $context );
	if ( false === $data || false === file_put_contents( $dest, $data ) ) {
		throw new RuntimeException( 'Download failed (no curl; allow_url_fopen may be off).' );
	}
}

function au_is_excluded( $relative ) {
	$first = explode( '/', $relative, 2 )[0];
	return in_array( $first, AU_EXCLUDE, true ) || in_array( $relative, AU_EXCLUDE, true );
}

function au_rmdir( $dir ) {
	if ( ! is_dir( $dir ) ) {
		return;
	}
	$items = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $dir, FilesystemIterator::SKIP_DOTS ), RecursiveIteratorIterator::CHILD_FIRST );
	foreach ( $items as $item ) {
		$item->isDir() ? @rmdir( $item->getPathname() ) : @unlink( $item->getPathname() );
	}
	@rmdir( $dir );
}

/**
 * Copy changed files from $src into the theme. Returns the list of updated paths.
 */
function au_sync( $src ) {
	$changed = array();
	$items   = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $src, FilesystemIterator::SKIP_DOTS ), RecursiveIteratorIterator::SELF_FIRST );
	foreach ( $items as $item ) {
		$relative = str_replace( '\\', '/', substr( $item->getPathname(), strlen( $src ) + 1 ) );
		if ( au_is_excluded( $relative ) ) {
			continue;
		}
		$target = AU_THEME_DIR . '/' . $relative;
		if ( $item->isDir() ) {
			if ( ! is_dir( $target ) && ! mkdir( $target, 0755, true ) ) {
				throw new RuntimeException( "Cannot create folder $relative" );
			}
			continue;
		}
		if ( is_file( $target ) && md5_file( $target ) === md5_file( $item->getPathname() ) ) {
			continue;
		}
		$tmp = $target . '.au-tmp';
		if ( ! copy( $item->getPathname(), $tmp ) || ! rename( $tmp, $target ) ) {
			@unlink( $tmp );
			throw new RuntimeException( "Cannot write $relative" );
		}
		@chmod( $target, 0644 );
		if ( function_exists( 'opcache_invalidate' ) && '.php' === substr( $relative, -4 ) ) {
			@opcache_invalidate( $target, true );
		}
		$changed[] = $relative;
	}
	return $changed;
}

function au_deploy( $sha ) {
	if ( ! class_exists( 'ZipArchive' ) ) {
		throw new RuntimeException( 'PHP ZipArchive is not available.' );
	}
	if ( ! is_dir( AU_THEME_DIR ) ) {
		throw new RuntimeException( 'Theme folder not found: ' . AU_THEME_DIR );
	}

	$work = sys_get_temp_dir() . '/au-deploy-' . $sha;
	$zip  = $work . '.zip';
	au_rmdir( $work );

	try {
		au_download( 'https://codeload.github.com/' . AU_REPO . '/zip/' . $sha, $zip );

		$archive = new ZipArchive();
		if ( true !== $archive->open( $zip ) ) {
			throw new RuntimeException( 'Downloaded file is not a valid zip.' );
		}
		for ( $i = 0; $i < $archive->numFiles; $i++ ) {
			$name = $archive->getNameIndex( $i );
			if ( false !== strpos( $name, '..' ) || '/' === $name[0] ) {
				throw new RuntimeException( "Unsafe path in zip: $name" );
			}
		}
		$archive->extractTo( $work );
		$archive->close();

		// GitHub zips contain one top folder, e.g. arcunify-<sha>/.
		$roots = glob( $work . '/*', GLOB_ONLYDIR );
		if ( 1 !== count( $roots ) || ! is_file( $roots[0] . '/style.css' ) ) {
			throw new RuntimeException( 'Unexpected zip layout (no style.css at the top).' );
		}

		return au_sync( $roots[0] );
	} finally {
		au_rmdir( $work );
		@unlink( $zip );
	}
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
	au_log( 'PING ok' );
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
