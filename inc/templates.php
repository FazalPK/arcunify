<?php
/**
 * Native page templates and the slug map that applies them automatically.
 *
 * Order of precedence for a page:
 * 1. A template chosen in the page's own Template setting (WordPress default).
 * 2. If "Use the new designs" is on: the slug map below.
 * 3. page.php (Elementor content inside the theme header/footer).
 *
 * @package ArcUnify
 */

defined( 'ABSPATH' ) || exit;

/**
 * @return array slug => template file.
 */
function arcunify_template_map() {
	$map = array(
		'services'   => 'page-templates/services-hub.php',
		'about-us'   => 'page-templates/about.php',
		'contact-us' => 'page-templates/contact.php',
	);
	foreach ( arcunify_services() as $service ) {
		$map[ trim( $service['path'], '/' ) ] = 'page-templates/service.php';
	}
	return apply_filters( 'arcunify_template_map', $map );
}

/**
 * Native template for a page, or ''.
 *
 * @param int $post_id Page ID.
 * @return string
 */
function arcunify_native_template_for( $post_id ) {
	if ( ! $post_id || 'page' !== get_post_type( $post_id ) ) {
		return '';
	}
	$assigned = get_page_template_slug( $post_id );
	if ( $assigned && 0 === strpos( $assigned, 'page-templates/' ) ) {
		return $assigned;
	}
	if ( $assigned && 'default' !== $assigned ) {
		return ''; // Another explicit template (e.g. Elementor Canvas) wins.
	}
	if ( ! arcunify_mod( 'native_pages' ) ) {
		return '';
	}
	$map  = arcunify_template_map();
	$slug = get_post_field( 'post_name', $post_id );
	return isset( $map[ $slug ] ) ? $map[ $slug ] : '';
}

/**
 * Apply the map.
 *
 * @param string $template Template path.
 * @return string
 */
function arcunify_template_include( $template ) {
	if ( is_singular( 'page' ) && ! is_front_page() ) {
		$native = arcunify_native_template_for( get_queried_object_id() );
		if ( $native ) {
			$located = locate_template( $native );
			if ( $located ) {
				return $located;
			}
		}
	}
	return $template;
}
add_filter( 'template_include', 'arcunify_template_include', 20 );

/**
 * Elementor's preview/editor must keep using its own canvas for these pages.
 */
add_filter(
	'arcunify_template_map',
	static function ( $map ) {
		return ( isset( $_GET['elementor-preview'] ) ) ? array() : $map; // phpcs:ignore WordPress.Security.NonceVerification
	}
);

/**
 * Page meta box: which service a page using the Service template describes.
 */
function arcunify_page_service_meta_box() {
	add_meta_box( 'au_page_service', __( 'ArcUnify service', 'arcunify' ), 'arcunify_page_service_meta_box_html', 'page', 'side', 'low' );
}
add_action( 'add_meta_boxes', 'arcunify_page_service_meta_box' );

/**
 * @param WP_Post $post Page.
 */
function arcunify_page_service_meta_box_html( $post ) {
	wp_nonce_field( 'au_page_service', 'au_page_service_nonce' );
	$current = get_post_meta( $post->ID, '_au_service', true );
	echo '<p>' . esc_html__( 'Used by the "ArcUnify: Service" template. Leave on Automatic to match by page slug.', 'arcunify' ) . '</p>';
	echo '<select class="widefat" name="au_page_service"><option value="">' . esc_html__( 'Automatic', 'arcunify' ) . '</option>';
	foreach ( arcunify_services() as $key => $service ) {
		printf( '<option value="%s" %s>%s</option>', esc_attr( $key ), selected( $current, $key, false ), esc_html( $service['name'] ) );
	}
	echo '</select>';
}

/**
 * @param int $post_id Page ID.
 */
function arcunify_page_service_save( $post_id ) {
	if ( ! isset( $_POST['au_page_service_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['au_page_service_nonce'] ), 'au_page_service' ) || ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}
	$value = sanitize_key( wp_unslash( $_POST['au_page_service'] ?? '' ) );
	update_post_meta( $post_id, '_au_service', array_key_exists( $value, arcunify_services() ) ? $value : '' );
}
add_action( 'save_post_page', 'arcunify_page_service_save' );
