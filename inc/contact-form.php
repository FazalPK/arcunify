<?php
/**
 * Contact enquiries.
 *
 * The live site has no form, so the theme ships a lightweight one:
 * - nonce + honeypot + minimum fill time + per-IP rate limit (no third-party CAPTCHA)
 * - every enquiry is stored under Enquiries in WP admin, so nothing is lost if email fails
 * - email goes to Customize → ArcUnify → Pages & contact form (default info@arcunify.com)
 * To use a form plugin instead, paste its shortcode in that same panel.
 *
 * Email delivery depends on the server; an SMTP plugin (e.g. WP Mail SMTP) is recommended.
 *
 * @package ArcUnify
 */

defined( 'ABSPATH' ) || exit;

/**
 * Private post type that keeps a copy of each enquiry.
 */
function arcunify_register_enquiries() {
	register_post_type(
		'au_enquiry',
		array(
			'labels'          => array(
				'name'          => __( 'Enquiries', 'arcunify' ),
				'singular_name' => __( 'Enquiry', 'arcunify' ),
			),
			'public'          => false,
			'show_ui'         => true,
			'show_in_rest'    => false,
			'menu_icon'       => 'dashicons-email-alt',
			'menu_position'   => 26,
			'supports'        => array( 'title', 'editor' ),
			'capability_type' => 'post',
			'capabilities'    => array( 'create_posts' => 'do_not_allow' ),
			'map_meta_cap'    => true,
		)
	);
}
add_action( 'init', 'arcunify_register_enquiries' );

/**
 * Form fields: name => [ label, type, required, autocomplete ].
 *
 * @return array
 */
function arcunify_form_fields() {
	return array(
		'name'    => array( __( 'Full name', 'arcunify' ), 'text', true, 'name' ),
		'email'   => array( __( 'Work email', 'arcunify' ), 'email', true, 'email' ),
		'phone'   => array( __( 'Phone', 'arcunify' ), 'tel', false, 'tel' ),
		'company' => array( __( 'Company', 'arcunify' ), 'text', false, 'organization' ),
		'service' => array( __( 'Service of interest', 'arcunify' ), 'select', false, 'off' ),
		'message' => array( __( 'How can we help?', 'arcunify' ), 'textarea', true, 'off' ),
	);
}

/**
 * Handle a submission (logged-in and anonymous).
 */
function arcunify_handle_contact() {
	$back = wp_get_referer() ? wp_get_referer() : home_url( '/contact-us/' );
	$back = remove_query_arg( array( 'sent', 'form_error' ), $back );

	$fail = static function ( $code ) use ( $back ) {
		wp_safe_redirect( add_query_arg( 'form_error', $code, $back ) . '#contact-form' );
		exit;
	};

	if ( ! isset( $_POST['au_contact_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['au_contact_nonce'] ), 'au_contact' ) ) {
		$fail( 'expired' );
	}

	// Honeypot and fill-time checks: bots get a silent "success".
	$started = absint( $_POST['au_ts'] ?? 0 );
	if ( ! empty( $_POST['au_website'] ) || ( $started && ( time() - $started ) < 3 ) ) {
		wp_safe_redirect( add_query_arg( 'sent', '1', $back ) . '#contact-form' );
		exit;
	}

	// Rate limit: 5 enquiries per hour per IP.
	$ip_key = 'au_rl_' . md5( (string) ( $_SERVER['REMOTE_ADDR'] ?? '' ) ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
	$count  = (int) get_transient( $ip_key );
	if ( $count >= 5 ) {
		$fail( 'limit' );
	}

	$data = array();
	foreach ( arcunify_form_fields() as $key => $field ) {
		$raw          = wp_unslash( $_POST[ 'au_' . $key ] ?? '' ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
		$data[ $key ] = 'textarea' === $field[1] ? sanitize_textarea_field( $raw ) : sanitize_text_field( $raw );
		if ( $field[2] && '' === trim( $data[ $key ] ) ) {
			$fail( 'missing' );
		}
	}
	if ( ! is_email( $data['email'] ) ) {
		$fail( 'email' );
	}
	$services        = arcunify_services();
	$data['service'] = isset( $services[ $data['service'] ] ) ? $services[ $data['service'] ]['name'] : '';

	set_transient( $ip_key, $count + 1, HOUR_IN_SECONDS );

	$lines = array();
	foreach ( arcunify_form_fields() as $key => $field ) {
		if ( '' !== $data[ $key ] ) {
			$lines[] = $field[0] . ': ' . $data[ $key ];
		}
	}
	$lines[] = __( 'Page', 'arcunify' ) . ': ' . esc_url_raw( $back );
	$body    = implode( "\n", $lines );

	wp_insert_post(
		array(
			'post_type'    => 'au_enquiry',
			'post_status'  => 'private',
			'post_title'   => sprintf( '%s — %s', $data['name'], $data['company'] ? $data['company'] : $data['email'] ),
			'post_content' => $body,
		)
	);

	$to      = arcunify_mod( 'form_recipient' ) ? arcunify_mod( 'form_recipient' ) : get_option( 'admin_email' );
	$subject = sprintf( /* translators: %s: name. */ __( 'New enquiry from %s', 'arcunify' ), $data['name'] );
	wp_mail( $to, $subject, $body, array( 'Reply-To: ' . $data['name'] . ' <' . $data['email'] . '>' ) );

	wp_safe_redirect( add_query_arg( 'sent', '1', $back ) . '#contact-form' );
	exit;
}
add_action( 'admin_post_arcunify_contact', 'arcunify_handle_contact' );
add_action( 'admin_post_nopriv_arcunify_contact', 'arcunify_handle_contact' );

/**
 * Render the form (or the configured plugin shortcode).
 */
function arcunify_render_contact_form() {
	$shortcode = trim( (string) arcunify_mod( 'form_shortcode' ) );
	if ( $shortcode ) {
		echo '<div class="au-form au-form--plugin">' . do_shortcode( $shortcode ) . '</div>'; // phpcs:ignore
		return;
	}
	get_template_part( 'template-parts/components/contact-form' );
}
