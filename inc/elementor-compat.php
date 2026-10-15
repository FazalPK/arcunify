<?php
/**
 * Elementor compatibility during migration.
 *
 * - Pages built with Elementor render full-width inside the theme header/footer
 *   (see page.php). Their content and data are untouched.
 * - The theme does not register Elementor Pro Theme Builder locations, so an
 *   Elementor header/footer template can never print a second header.
 * - On native templates, the Elementor Kit body class is removed so global
 *   Kit typography/colours don't leak into theme sections.
 *
 * @package ArcUnify
 */

defined( 'ABSPATH' ) || exit;

/**
 * Is the given post built with Elementor?
 *
 * @param int $post_id Post ID.
 * @return bool
 */
function arcunify_is_elementor_page( $post_id = 0 ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	if ( ! $post_id || ! did_action( 'elementor/loaded' ) ) {
		return false;
	}
	$document = \Elementor\Plugin::$instance->documents->get( $post_id );
	return $document && $document->is_built_with_elementor();
}

/**
 * Remove Elementor Kit class where the theme owns the layout.
 *
 * @param array $classes Body classes.
 * @return array
 */
function arcunify_strip_kit_class( $classes ) {
	if ( ! arcunify_is_native_view() ) {
		return $classes;
	}
	return array_values(
		array_filter(
			$classes,
			static function ( $c ) {
				return 0 !== strpos( $c, 'elementor-kit-' );
			}
		)
	);
}
add_filter( 'body_class', 'arcunify_strip_kit_class', 99 );

/**
 * Elementor's "Hello" style page title is not needed: themes own the title.
 */
add_filter( 'hello_elementor_page_title', '__return_false' );
