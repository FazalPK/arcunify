<?php
/**
 * Testimonials (Testimonials menu in WP admin).
 *
 * Title = client name, content = quote. Only entries with "Verified" ticked
 * are ever shown on the site; the section disappears when there are none.
 *
 * @package ArcUnify
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register the post type.
 */
function arcunify_register_testimonials() {
	register_post_type(
		'au_testimonial',
		array(
			'labels'          => array(
				'name'          => __( 'Testimonials', 'arcunify' ),
				'singular_name' => __( 'Testimonial', 'arcunify' ),
				'add_new_item'  => __( 'Add testimonial', 'arcunify' ),
				'edit_item'     => __( 'Edit testimonial', 'arcunify' ),
			),
			'public'          => false,
			'show_ui'         => true,
			'show_in_rest'    => false,
			'menu_icon'       => 'dashicons-format-quote',
			'menu_position'   => 25,
			'supports'        => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
			'capability_type' => 'post',
		)
	);
}
add_action( 'init', 'arcunify_register_testimonials' );

/**
 * Change the title placeholder.
 *
 * @param string  $text Placeholder.
 * @param WP_Post $post Post.
 * @return string
 */
function arcunify_testimonial_title_placeholder( $text, $post ) {
	return 'au_testimonial' === $post->post_type ? __( 'Client name', 'arcunify' ) : $text;
}
add_filter( 'enter_title_here', 'arcunify_testimonial_title_placeholder', 10, 2 );

/**
 * Meta box.
 */
function arcunify_testimonial_meta_box() {
	add_meta_box( 'au_testimonial_meta', __( 'Testimonial details', 'arcunify' ), 'arcunify_testimonial_meta_box_html', 'au_testimonial', 'side', 'high' );
}
add_action( 'add_meta_boxes', 'arcunify_testimonial_meta_box' );

/**
 * @param WP_Post $post Post.
 */
function arcunify_testimonial_meta_box_html( $post ) {
	wp_nonce_field( 'au_testimonial_save', 'au_testimonial_nonce' );
	$role     = get_post_meta( $post->ID, '_au_role', true );
	$company  = get_post_meta( $post->ID, '_au_company', true );
	$service  = get_post_meta( $post->ID, '_au_service', true );
	$verified = get_post_meta( $post->ID, '_au_verified', true );
	$rating   = get_post_meta( $post->ID, '_au_rating', true );
	?>
	<p><label for="au_role"><?php esc_html_e( 'Role', 'arcunify' ); ?></label><br>
		<input class="widefat" id="au_role" name="au_role" value="<?php echo esc_attr( $role ); ?>"></p>
	<p><label for="au_company"><?php esc_html_e( 'Company', 'arcunify' ); ?></label><br>
		<input class="widefat" id="au_company" name="au_company" value="<?php echo esc_attr( $company ); ?>"></p>
	<p><label for="au_service"><?php esc_html_e( 'Service', 'arcunify' ); ?></label><br>
		<select class="widefat" id="au_service" name="au_service">
			<option value=""><?php esc_html_e( 'General (homepage)', 'arcunify' ); ?></option>
			<?php foreach ( arcunify_services() as $slug => $s ) : ?>
				<option value="<?php echo esc_attr( $slug ); ?>" <?php selected( $service, $slug ); ?>><?php echo esc_html( $s['name'] ); ?></option>
			<?php endforeach; ?>
		</select></p>
	<p><label for="au_rating"><?php esc_html_e( 'Rating shown (e.g. 4.9, blank to hide)', 'arcunify' ); ?></label><br>
		<input class="widefat" id="au_rating" name="au_rating" value="<?php echo esc_attr( $rating ); ?>"></p>
	<p><label><input type="checkbox" name="au_verified" value="1" <?php checked( $verified, '1' ); ?>>
		<?php esc_html_e( 'Verified: real client, permission to publish', 'arcunify' ); ?></label></p>
	<?php
}

/**
 * Save meta.
 *
 * @param int $post_id Post ID.
 */
function arcunify_testimonial_save( $post_id ) {
	if ( ! isset( $_POST['au_testimonial_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['au_testimonial_nonce'] ), 'au_testimonial_save' ) ) {
		return;
	}
	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	update_post_meta( $post_id, '_au_role', sanitize_text_field( wp_unslash( $_POST['au_role'] ?? '' ) ) );
	update_post_meta( $post_id, '_au_company', sanitize_text_field( wp_unslash( $_POST['au_company'] ?? '' ) ) );
	$service = sanitize_key( wp_unslash( $_POST['au_service'] ?? '' ) );
	update_post_meta( $post_id, '_au_service', array_key_exists( $service, arcunify_services() ) ? $service : '' );
	update_post_meta( $post_id, '_au_verified', empty( $_POST['au_verified'] ) ? '0' : '1' );
	$rating = preg_replace( '/[^0-9.]/', '', (string) wp_unslash( $_POST['au_rating'] ?? '' ) );
	update_post_meta( $post_id, '_au_rating', $rating );
}
add_action( 'save_post_au_testimonial', 'arcunify_testimonial_save' );

/**
 * Verified testimonials for a service ('' = the general homepage set).
 * Falls back to any verified testimonials when the set is empty.
 *
 * @param string $service Service key, or '' for the general set.
 * @param int    $limit   Max items.
 * @return WP_Post[]
 */
function arcunify_get_testimonials( $service = '', $limit = 6 ) {
	$items = arcunify_query_testimonials( $service, $limit );
	if ( ! $items ) {
		$items = arcunify_query_testimonials( null, $limit );
	}
	return $items;
}

/**
 * @param string|null $service Service key, '' for general, null for any.
 * @param int         $limit   Max items.
 * @return WP_Post[]
 */
function arcunify_query_testimonials( $service, $limit ) {
	$meta = array(
		array(
			'key'   => '_au_verified',
			'value' => '1',
		),
	);
	if ( null !== $service ) {
		$meta[] = array(
			'key'   => '_au_service',
			'value' => $service,
		);
	}
	return get_posts(
		array(
			'post_type'      => 'au_testimonial',
			'posts_per_page' => $limit,
			'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
			'meta_query'     => $meta, // phpcs:ignore WordPress.DB.SlowDBQuery
			'no_found_rows'  => true,
		)
	);
}

/**
 * Seed the live site's testimonials once, on theme activation, if none exist.
 * Confirmed by the client as published "as is".
 */
function arcunify_seed_testimonials_once() {
	if ( get_option( 'arcunify_testimonials_seeded' ) ) {
		return;
	}
	$existing = get_posts(
		array(
			'post_type'      => 'au_testimonial',
			'post_status'    => 'any',
			'posts_per_page' => 1,
			'fields'         => 'ids',
		)
	);
	if ( ! $existing ) {
		$order = 0;
		foreach ( arcunify_seed_testimonials() as $row ) {
			list( $name, $role, $quote, $service ) = $row;
			$id = wp_insert_post(
				array(
					'post_type'    => 'au_testimonial',
					'post_status'  => 'publish',
					'post_title'   => $name,
					'post_content' => $quote,
					'menu_order'   => $order++,
				)
			);
			if ( $id && ! is_wp_error( $id ) ) {
				update_post_meta( $id, '_au_role', $role );
				update_post_meta( $id, '_au_company', '' );
				update_post_meta( $id, '_au_service', $service );
				update_post_meta( $id, '_au_verified', '1' );
				update_post_meta( $id, '_au_rating', '4.9' );
			}
		}
	}
	update_option( 'arcunify_testimonials_seeded', 1, false );
}
add_action( 'after_switch_theme', 'arcunify_seed_testimonials_once' );

/**
 * Admin list columns: service and verified status at a glance.
 *
 * @param array $cols Columns.
 * @return array
 */
function arcunify_testimonial_columns( $cols ) {
	$cols['au_role']     = __( 'Role', 'arcunify' );
	$cols['au_service']  = __( 'Shown on', 'arcunify' );
	$cols['au_verified'] = __( 'Verified', 'arcunify' );
	return $cols;
}
add_filter( 'manage_au_testimonial_posts_columns', 'arcunify_testimonial_columns' );

/**
 * @param string $col     Column.
 * @param int    $post_id Post ID.
 */
function arcunify_testimonial_column_values( $col, $post_id ) {
	if ( 'au_role' === $col ) {
		echo esc_html( get_post_meta( $post_id, '_au_role', true ) );
	} elseif ( 'au_service' === $col ) {
		$key      = get_post_meta( $post_id, '_au_service', true );
		$services = arcunify_services();
		echo esc_html( $key && isset( $services[ $key ] ) ? $services[ $key ]['name'] : __( 'Homepage / Services', 'arcunify' ) );
	} elseif ( 'au_verified' === $col ) {
		echo get_post_meta( $post_id, '_au_verified', true ) ? '&#10003;' : '&mdash;';
	}
}
add_action( 'manage_au_testimonial_posts_custom_column', 'arcunify_testimonial_column_values', 10, 2 );
