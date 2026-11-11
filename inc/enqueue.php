<?php
/**
 * Fonts, styles and scripts.
 *
 * CSS sources live in assets/css/src and are concatenated into
 * assets/css/theme.css and assets/css/home.css by build.sh.
 *
 * @package ArcUnify
 */

defined( 'ABSPATH' ) || exit;

/**
 * Cache-busting version: the file's modified time, so browsers fetch a file again as
 * soon as a deploy changes it. Falls back to the theme version.
 *
 * @param string $rel Path relative to the theme.
 * @return string
 */
function arcunify_asset_ver( $rel ) {
	$path = ARCUNIFY_DIR . '/' . $rel;
	return file_exists( $path ) ? (string) filemtime( $path ) : ARCUNIFY_VERSION;
}

/**
 * Enqueue front-end assets.
 */
function arcunify_enqueue_assets() {
	$landing = arcunify_landing_template();
	$script  = array(
		'in_footer' => true,
		'strategy'  => 'defer',
	);

	// The Managed IT landing page carries its own complete stylesheet and script.
	if ( 'page-templates/landing-managed.php' === $landing ) {
		wp_enqueue_style( 'arcunify-landing-managed', ARCUNIFY_URI . '/assets/css/landing-managed.css', array(), arcunify_asset_ver( 'assets/css/landing-managed.css' ) );
		wp_enqueue_script( 'arcunify-landing', ARCUNIFY_URI . '/assets/js/landing.js', array(), arcunify_asset_ver( 'assets/js/landing.js' ), $script );
		return;
	}

	wp_enqueue_style( 'arcunify', ARCUNIFY_URI . '/assets/css/theme.css', array(), arcunify_asset_ver( 'assets/css/theme.css' ) );

	if ( 'page-templates/landing-voip.php' === $landing ) {
		wp_enqueue_style( 'arcunify-landing-voip', ARCUNIFY_URI . '/assets/css/landing-voip.css', array( 'arcunify' ), arcunify_asset_ver( 'assets/css/landing-voip.css' ) );
	} elseif ( arcunify_is_native_view() ) {
		wp_enqueue_style( 'arcunify-sections', ARCUNIFY_URI . '/assets/css/sections.css', array( 'arcunify' ), arcunify_asset_ver( 'assets/css/sections.css' ) );
	}

	wp_enqueue_script( 'arcunify', ARCUNIFY_URI . '/assets/js/theme.js', array(), arcunify_asset_ver( 'assets/js/theme.js' ), $script );
}
add_action( 'wp_enqueue_scripts', 'arcunify_enqueue_assets', 20 );

/**
 * Preload the single variable font file and flag JS support before paint.
 */
function arcunify_head_early() {
	printf(
		'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
		esc_url( ARCUNIFY_URI . '/assets/fonts/plus-jakarta-sans-latin-wght-normal.woff2' )
	);
	wp_print_inline_script_tag( "document.documentElement.classList.add('js');" );
	echo '<meta name="theme-color" content="#05060A">' . "\n";
}
add_action( 'wp_head', 'arcunify_head_early', 2 );
