<?php
/**
 * Theme supports, menus, image sizes.
 *
 * @package ArcUnify
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register theme features.
 */
function arcunify_setup() {
	load_theme_textdomain( 'arcunify', ARCUNIFY_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 64,
			'width'       => 240,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	register_nav_menus(
		array(
			'primary' => __( 'Header navigation', 'arcunify' ),
			'footer'  => __( 'Footer: Company links', 'arcunify' ),
			'legal'   => __( 'Footer: Legal links', 'arcunify' ),
		)
	);

	add_image_size( 'arcunify-card', 720, 480, true );
	add_image_size( 'arcunify-wide', 1440, 810, true );
}
add_action( 'after_setup_theme', 'arcunify_setup' );

/**
 * Content width for embeds.
 */
function arcunify_content_width() {
	$GLOBALS['content_width'] = 760;
}
add_action( 'after_setup_theme', 'arcunify_content_width', 0 );

/**
 * Body classes: header style per page.
 *
 * @param array $classes Classes.
 * @return array
 */
function arcunify_body_classes( $classes ) {
	$classes[] = arcunify_is_native_home() ? 'au-header-overlay' : 'au-header-solid';
	return $classes;
}
add_filter( 'body_class', 'arcunify_body_classes' );

/**
 * Print the icon sprite once, at the top of <body>.
 */
function arcunify_print_icon_sprite() {
	$file = ARCUNIFY_DIR . '/assets/images/icons.svg';
	if ( is_readable( $file ) ) {
		echo file_get_contents( $file ); // phpcs:ignore WordPress.Security.EscapeOutput,WordPress.WP.AlternativeFunctions -- Theme-owned static SVG.
	}
}
add_action( 'wp_body_open', 'arcunify_print_icon_sprite', 5 );
