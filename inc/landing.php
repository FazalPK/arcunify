<?php
/**
 * Landing pages converted from Elementor.
 *
 * - arcunify_landing_map(): slug => template. Applied whether or not
 *   "Use the new designs" is ticked, because these pages no longer need Elementor.
 * - The consultation form keeps its original look and fields. Each enquiry is
 *   saved under Enquiries and emailed, like the contact form (inc/contact-form.php).
 *   The page URL, including any gclid/UTM parameters, is stored with it.
 * - A successful send pushes `arcunify_lead` to the GTM dataLayer.
 *
 * @package ArcUnify
 */

defined( 'ABSPATH' ) || exit;

/**
 * @return array slug => template file.
 */
function arcunify_landing_map() {
	$map = array(
		'voip-communication' => 'page-templates/landing-voip.php',
	);
	if ( isset( $_GET['elementor-preview'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
		return array(); // Elementor's editor keeps its own canvas.
	}
	return apply_filters( 'arcunify_landing_map', $map );
}

/**
 * Is the current request a landing template?
 *
 * @return bool
 */
function arcunify_is_landing_view() {
	if ( ! is_singular( 'page' ) ) {
		return false;
	}
	return 0 === strpos( arcunify_native_template_for( get_queried_object_id() ), 'page-templates/landing-' );
}

/**
 * Landing form fields: name => [ label, required ].
 *
 * @return array
 */
function arcunify_landing_fields() {
	return array(
		'name'      => array( __( 'Full name', 'arcunify' ), true ),
		'email'     => array( __( 'Business email', 'arcunify' ), true ),
		'phone'     => array( __( 'Phone', 'arcunify' ), true ),
		'company'   => array( __( 'Company', 'arcunify' ), false ),
		'employees' => array( __( 'Number of employees', 'arcunify' ), false ),
		'message'   => array( __( 'Communication needs', 'arcunify' ), false ),
	);
}

/**
 * Handle a landing form submission.
 */
function arcunify_handle_landing() {
	$back = wp_get_referer() ? wp_get_referer() : home_url( '/' );
	$back = remove_query_arg( array( 'sent', 'form_error' ), $back );

	$go = static function ( $arg, $value ) use ( $back ) {
		wp_safe_redirect( add_query_arg( $arg, $value, $back ) . '#consultation' );
		exit;
	};

	if ( ! isset( $_POST['au_contact_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['au_contact_nonce'] ), 'au_landing' ) ) {
		$go( 'form_error', 'expired' );
	}

	// Honeypot and fill-time checks: bots get a silent "success".
	$started = absint( $_POST['au_ts'] ?? 0 );
	if ( ! empty( $_POST['au_website'] ) || ( $started && ( time() - $started ) < 3 ) ) {
		$go( 'sent', '1' );
	}

	// Rate limit: 5 enquiries per hour per IP (shared with the contact form).
	$ip_key = 'au_rl_' . md5( (string) ( $_SERVER['REMOTE_ADDR'] ?? '' ) ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
	$count  = (int) get_transient( $ip_key );
	if ( $count >= 5 ) {
		$go( 'form_error', 'limit' );
	}

	$data = array();
	foreach ( arcunify_landing_fields() as $key => $field ) {
		$raw          = wp_unslash( $_POST[ 'au_' . $key ] ?? '' ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
		$data[ $key ] = 'message' === $key ? sanitize_textarea_field( $raw ) : sanitize_text_field( $raw );
		if ( $field[1] && '' === trim( $data[ $key ] ) ) {
			$go( 'form_error', 'missing' );
		}
	}
	if ( ! is_email( $data['email'] ) ) {
		$go( 'form_error', 'email' );
	}

	set_transient( $ip_key, $count + 1, HOUR_IN_SECONDS );

	$page  = get_the_title( url_to_postid( $back ) );
	$lines = array();
	foreach ( arcunify_landing_fields() as $key => $field ) {
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
	$subject = sprintf( /* translators: 1: name, 2: page title. */ __( 'New enquiry from %1$s (%2$s)', 'arcunify' ), $data['name'], $page ? $page : __( 'landing page', 'arcunify' ) );
	wp_mail( $to, $subject, $body, array( 'Reply-To: ' . $data['name'] . ' <' . $data['email'] . '>' ) );

	$go( 'sent', '1' );
}
add_action( 'admin_post_arcunify_landing', 'arcunify_handle_landing' );
add_action( 'admin_post_nopriv_arcunify_landing', 'arcunify_handle_landing' );

/**
 * Print the consultation box (heading, intro, status message and form).
 * Markup and classes match the original Elementor version.
 */
function arcunify_render_landing_form() {
	$sent   = isset( $_GET['sent'] ); // phpcs:ignore WordPress.Security.NonceVerification
	$error  = sanitize_key( $_GET['form_error'] ?? '' ); // phpcs:ignore WordPress.Security.NonceVerification
	$errors = array(
		'missing' => __( 'Please fill in your name, email and phone number.', 'arcunify' ),
		'email'   => __( 'Please enter a valid email address.', 'arcunify' ),
		'expired' => __( 'The form expired. Please send it again.', 'arcunify' ),
		'limit'   => __( 'Too many requests from this connection. Please call or email us instead.', 'arcunify' ),
	);
	?>
<div class="form" id="consultation"><h3>Get Your Free Consultation</h3><p>Tell us about your communication needs and we'll help identify the right VoIP solution for your business.</p>
	<?php if ( $sent ) : ?>
<p class="au-lp-notice au-lp-notice--ok" role="status"><strong><?php esc_html_e( 'Thank you, your request has been sent.', 'arcunify' ); ?></strong> <?php esc_html_e( 'A member of our team will contact you.', 'arcunify' ); ?></p>
<script>window.dataLayer=window.dataLayer||[];window.dataLayer.push({event:'arcunify_lead',form:'<?php echo esc_js( get_post_field( 'post_name', get_queried_object_id() ) ); ?>'});</script>
	<?php else : ?>
		<?php if ( isset( $errors[ $error ] ) ) : ?>
<p class="au-lp-notice au-lp-notice--error" role="alert"><?php echo esc_html( $errors[ $error ] ); ?></p>
		<?php endif; ?>
<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
<input type="hidden" name="action" value="arcunify_landing"><input type="hidden" name="au_ts" value="<?php echo esc_attr( time() ); ?>"><?php wp_nonce_field( 'au_landing', 'au_contact_nonce', false ); ?>
<div class="au-lp-hp" aria-hidden="true"><input type="text" name="au_website" tabindex="-1" autocomplete="off"></div>
<input class="field" type="text" name="au_name" placeholder="Full Name" autocomplete="name" aria-label="Full Name" required><input class="field" type="email" name="au_email" placeholder="Business Email" autocomplete="email" aria-label="Business Email" required><input class="field" type="tel" name="au_phone" placeholder="Phone Number" autocomplete="tel" aria-label="Phone Number" required><input class="field" type="text" name="au_company" placeholder="Company Name" autocomplete="organization" aria-label="Company Name">
<select class="field" name="au_employees" aria-label="Number of Employees"><option value="">Number of Employees</option><option>1–10</option><option>11–25</option><option>26–50</option><option>51–100</option><option>100+</option></select>
<textarea class="field" name="au_message" rows="3" placeholder="Tell us about your communication needs" aria-label="Tell us about your communication needs"></textarea>
<button type="submit">Request My Free Consultation</button><div class="note">No obligation. A member of our team will contact you.</div></form>
	<?php endif; ?>
</div>
	<?php
}
