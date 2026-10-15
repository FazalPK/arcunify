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
 * Cache-busting version: file mtime in development, theme version otherwise.
 *
 * @param string $rel Path relative to the theme.
 * @return string
 */
function arcunify_asset_ver( $rel ) {
	$path = ARCUNIFY_DIR . '/' . $rel;
	return ( defined( 'WP_DEBUG' ) && WP_DEBUG && file_exists( $path ) ) ? (string) filemtime( $path ) : ARCUNIFY_VERSION;
}

/**
 * Enqueue front-end assets.
 */
function arcunify_enqueue_assets() {
	wp_enqueue_style( 'arcunify', ARCUNIFY_URI . '/assets/css/theme.css', array(), arcunify_asset_ver( 'assets/css/theme.css' ) );

	if ( arcunify_is_native_view() ) {
		wp_enqueue_style( 'arcunify-sections', ARCUNIFY_URI . '/assets/css/sections.css', array( 'arcunify' ), arcunify_asset_ver( 'assets/css/sections.css' ) );
	}

	wp_enqueue_script(
		'arcunify',
		ARCUNIFY_URI . '/assets/js/theme.js',
		array(),
		arcunify_asset_ver( 'assets/js/theme.js' ),
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);
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
