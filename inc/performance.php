<?php
/**
 * Front-end clean-up. Conservative: nothing here changes content or SEO output.
 *
 * @package ArcUnify
 */

defined( 'ABSPATH' ) || exit;

// Emoji detection script and styles (~16KB) are not needed with system emoji.
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

// Head noise.
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wp_generator' );

/**
 * Drop block-library CSS on the native homepage, which uses no blocks.
 */
function arcunify_trim_block_css() {
	if ( arcunify_is_native_home() ) {
		wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_style( 'wp-block-library-theme' );
		wp_dequeue_style( 'global-styles' );
		wp_dequeue_style( 'classic-theme-styles' );
	}
}
add_action( 'wp_enqueue_scripts', 'arcunify_trim_block_css', 100 );

/**
 * Lazy-load and async-decode content images by default (WP core handles most).
 *
 * @param array $attr Attributes.
 * @return array
 */
function arcunify_image_attrs( $attr ) {
	if ( empty( $attr['decoding'] ) ) {
		$attr['decoding'] = 'async';
	}
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'arcunify_image_attrs' );
