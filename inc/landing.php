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
	// /managed-it-service/ is still drawn by the "ArcUnify Landing Pages" plugin while it is
	// active; the theme copy takes over as soon as the plugin is deactivated.
	// ?au_preview=1 shows the theme copy while the plugin is still on.
	if ( ! arcunify_landing_plugin_active() || isset( $_GET['au_preview'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
		$map['managed-it-service'] = 'page-templates/landing-managed.php';
	}
	if ( isset( $_GET['elementor-preview'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
		return array(); // Elementor's editor keeps its own canvas.
	}
	return apply_filters( 'arcunify_landing_map', $map );
}

/**
 * Is the "ArcUnify Landing Pages (Google Ads)" plugin active?
 *
 * @return bool
 */
function arcunify_landing_plugin_active() {
	$active = (array) get_option( 'active_plugins', array() );
	if ( is_multisite() ) {
		$active = array_merge( $active, array_keys( (array) get_site_option( 'active_sitewide_plugins', array() ) ) );
	}
	foreach ( $active as $plugin ) {
		// file_exists: a plugin folder deleted by FTP stays listed as active until WordPress notices.
		if ( 0 === strpos( (string) $plugin, 'arcunify-landing/' ) && file_exists( WP_PLUGIN_DIR . '/' . $plugin ) ) {
			return true;
		}
	}
	return false;
}

/**
 * Ad landing pages stay out of search results (the plugin set noindex, follow too).
 *
 * @param array $robots Robots directives.
 * @return array
 */
function arcunify_landing_robots( $robots ) {
	if ( 'page-templates/landing-managed.php' === arcunify_landing_template() && function_exists( 'wp_robots_no_robots' ) ) {
		return wp_robots_no_robots( $robots );
	}
	return $robots;
}
add_filter( 'wp_robots', 'arcunify_landing_robots' );

/**
 * Landing template for the current request, or ''.
 *
 * @return string Template path relative to the theme.
 */
function arcunify_landing_template() {
	if ( ! is_singular( 'page' ) || is_front_page() ) {
		return '';
	}
	$template = arcunify_native_template_for( get_queried_object_id() );
	return 0 === strpos( $template, 'page-templates/landing-' ) ? $template : '';
}

/**
 * Is the current request a landing template?
 *
 * @return bool
 */
function arcunify_is_landing_view() {
	return '' !== arcunify_landing_template();
}

/**
 * Landing templates get the last word, after any plugin that also filters templates.
 *
 * @param string $template Template path.
 * @return string
 */
function arcunify_landing_template_include( $template ) {
	$landing = arcunify_landing_template();
	if ( $landing ) {
		$located = locate_template( $landing );
		if ( $located ) {
			return $located;
		}
	}
	return $template;
}
add_filter( 'template_include', 'arcunify_landing_template_include', PHP_INT_MAX );

/**
 * The Managed IT landing script keys off body.au-landing (form scrolling, phone-click events).
 *
 * @param array $classes Body classes.
 * @return array
 */
function arcunify_landing_body_class( $classes ) {
	if ( 'page-templates/landing-managed.php' === arcunify_landing_template() && ! in_array( 'au-landing', $classes, true ) ) {
		$classes[] = 'au-landing';
	}
	return $classes;
}
add_filter( 'body_class', 'arcunify_landing_body_class' );

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
 * Checks shared by the landing forms: nonce, honeypot, fill time and rate limit.
 * Redirects through $go and exits on failure; bots get a silent "success".
 *
 * @param string   $nonce_action Nonce action of the form.
 * @param callable $go           function( array $args ): redirect back with query args and exit.
 * @return string Rate-limit transient key, to bump once the enquiry is saved.
 */
function arcunify_lp_guard( $nonce_action, $go ) {
	if ( ! isset( $_POST['au_contact_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['au_contact_nonce'] ), $nonce_action ) ) {
		$go( array( 'form_error' => 'expired' ) );
	}

	$started = absint( $_POST['au_ts'] ?? 0 );
	if ( ! empty( $_POST['au_website'] ) || ( $started && ( time() - $started ) < 3 ) ) {
		$go( array( 'sent' => '1' ) );
	}

	// Rate limit: 5 enquiries per hour per IP (shared with the contact form).
	$ip_key = 'au_rl_' . md5( (string) ( $_SERVER['REMOTE_ADDR'] ?? '' ) ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
	if ( (int) get_transient( $ip_key ) >= 5 ) {
		$go( array( 'form_error' => 'limit' ) );
	}
	return $ip_key;
}

/**
 * Read and validate posted fields. Exits through $go when a required field is
 * empty or the email is invalid.
 *
 * @param array    $fields name => [ label, required ].
 * @param callable $go     Redirect callback.
 * @return array name => sanitized value.
 */
function arcunify_lp_fields_from_post( $fields, $go ) {
	$data = array();
	foreach ( $fields as $key => $field ) {
		$raw          = wp_unslash( $_POST[ 'au_' . $key ] ?? '' ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
		$data[ $key ] = 'message' === $key ? sanitize_textarea_field( $raw ) : sanitize_text_field( $raw );
		if ( $field[1] && '' === trim( $data[ $key ] ) ) {
			$go( array( 'form_error' => 'missing' ) );
		}
	}
	if ( ! is_email( $data['email'] ) ) {
		$go( array( 'form_error' => 'email' ) );
	}
	return $data;
}

/**
 * Save an enquiry under Enquiries, email it and count it against the rate limit.
 *
 * @param array  $data   Field values (needs name, email, company).
 * @param array  $lines  Body lines.
 * @param string $page   Page title for the email subject.
 * @param string $ip_key Rate-limit key from arcunify_lp_guard().
 * @return int Enquiry ID (0 if it could not be stored).
 */
function arcunify_lp_save( $data, $lines, $page, $ip_key ) {
	set_transient( $ip_key, (int) get_transient( $ip_key ) + 1, HOUR_IN_SECONDS );

	$body = implode( "\n", $lines );
	$id   = wp_insert_post(
		array(
			'post_type'    => 'au_enquiry',
			'post_status'  => 'private',
			'post_title'   => sprintf( '%s — %s', $data['name'], ! empty( $data['company'] ) ? $data['company'] : $data['email'] ),
			'post_content' => $body,
		)
	);

	$to      = arcunify_mod( 'form_recipient' ) ? arcunify_mod( 'form_recipient' ) : get_option( 'admin_email' );
	$subject = sprintf( /* translators: 1: name, 2: page title. */ __( 'New enquiry from %1$s (%2$s)', 'arcunify' ), $data['name'], $page ? $page : __( 'landing page', 'arcunify' ) );
	wp_mail( $to, $subject, $body, array( 'Reply-To: ' . $data['name'] . ' <' . $data['email'] . '>' ) );

	return is_wp_error( $id ) ? 0 : (int) $id;
}

/**
 * Handle the VoIP landing form.
 */
function arcunify_handle_landing() {
	$back = wp_get_referer() ? wp_get_referer() : home_url( '/' );
	$back = remove_query_arg( array( 'sent', 'form_error' ), $back );

	$go = static function ( $args ) use ( $back ) {
		wp_safe_redirect( add_query_arg( $args, $back ) . '#consultation' );
		exit;
	};

	$ip_key = arcunify_lp_guard( 'au_landing', $go );
	$data   = arcunify_lp_fields_from_post( arcunify_landing_fields(), $go );

	$lines = array();
	foreach ( arcunify_landing_fields() as $key => $field ) {
		if ( '' !== $data[ $key ] ) {
			$lines[] = $field[0] . ': ' . $data[ $key ];
		}
	}
	$lines[] = __( 'Page', 'arcunify' ) . ': ' . esc_url_raw( $back );

	arcunify_lp_save( $data, $lines, get_the_title( url_to_postid( $back ) ), $ip_key );
	$go( array( 'sent' => '1' ) );
}
add_action( 'admin_post_arcunify_landing', 'arcunify_handle_landing' );
add_action( 'admin_post_nopriv_arcunify_landing', 'arcunify_handle_landing' );

/**
 * Managed IT landing form fields: name => [ label, required ].
 *
 * @return array
 */
function arcunify_lp_contact_fields() {
	return array(
		'name'    => array( __( 'Full name', 'arcunify' ), true ),
		'email'   => array( __( 'Work email', 'arcunify' ), true ),
		'phone'   => array( __( 'Phone', 'arcunify' ), false ),
		'company' => array( __( 'Company', 'arcunify' ), false ),
		'message' => array( __( 'How can we help?', 'arcunify' ), false ),
	);
}

/**
 * Ad attribution sent by assets/js/landing.js (latest gclid/UTMs, kept 90 days).
 *
 * @return array key => value, whitelisted and sanitized.
 */
function arcunify_lp_attribution_from_post() {
	$raw  = isset( $_POST['au_attr'] ) && is_string( $_POST['au_attr'] ) ? json_decode( wp_unslash( $_POST['au_attr'] ), true ) : null; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
	$keys = array( 'gclid', 'gbraid', 'wbraid', 'utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content', 'landing' );
	$attr = array();
	if ( is_array( $raw ) ) {
		foreach ( $keys as $key ) {
			if ( isset( $raw[ $key ] ) && is_scalar( $raw[ $key ] ) && '' !== (string) $raw[ $key ] ) {
				$value        = function_exists( 'mb_substr' ) ? mb_substr( (string) $raw[ $key ], 0, 300, 'UTF-8' ) : substr( (string) $raw[ $key ], 0, 300 );
				$attr[ $key ] = 'landing' === $key ? esc_url_raw( $value ) : sanitize_text_field( $value );
			}
		}
	}
	return array_filter( $attr, 'strlen' );
}

/**
 * Handle the Managed IT landing form (replaces the plugin's aul_contact handler).
 */
function arcunify_handle_lp_contact() {
	$back = wp_get_referer() ? wp_get_referer() : home_url( '/' );
	$back = remove_query_arg( array( 'sent', 'form_error', 'lead' ), $back );

	$go = static function ( $args ) use ( $back ) {
		wp_safe_redirect( add_query_arg( $args, $back ) . '#lp-form' );
		exit;
	};

	$ip_key = arcunify_lp_guard( 'au_lp_contact', $go );
	$data   = arcunify_lp_fields_from_post( arcunify_lp_contact_fields(), $go );

	$services = arcunify_services();
	$service  = sanitize_key( wp_unslash( $_POST['au_service'] ?? '' ) );
	$page_id  = absint( $_POST['au_page'] ?? 0 );
	$page     = $page_id && 'page' === get_post_type( $page_id ) ? get_the_title( $page_id ) : get_the_title( url_to_postid( $back ) );
	$attr     = arcunify_lp_attribution_from_post();

	$lines = array();
	foreach ( arcunify_lp_contact_fields() as $key => $field ) {
		if ( '' !== $data[ $key ] ) {
			$lines[] = $field[0] . ': ' . $data[ $key ];
		}
	}
	if ( isset( $services[ $service ] ) ) {
		$lines[] = __( 'Service', 'arcunify' ) . ': ' . $services[ $service ]['name'];
	}
	$lines[] = __( 'Page', 'arcunify' ) . ': ' . esc_url_raw( $back );
	foreach ( $attr as $key => $value ) {
		$lines[] = $key . ': ' . $value;
	}

	$id = arcunify_lp_save( $data, $lines, $page, $ip_key );
	if ( $id ) {
		update_post_meta( $id, '_au_form', 'landing' );
		update_post_meta( $id, '_au_page', $page_id );
		update_post_meta( $id, '_au_service', isset( $services[ $service ] ) ? $service : '' );
		if ( $attr ) {
			update_post_meta( $id, '_au_attr', $attr );
		}
	}
	$go( array( 'sent' => '1', 'lead' => (string) $id ) );
}
add_action( 'admin_post_arcunify_lp_contact', 'arcunify_handle_lp_contact' );
add_action( 'admin_post_nopriv_arcunify_lp_contact', 'arcunify_handle_lp_contact' );

// A plugin form still open in a visitor's browser when the plugin is switched off posts
// "aul_contact": answer it (as "form expired", so they resend) instead of an error page.
if ( ! arcunify_landing_plugin_active() ) {
	add_action( 'admin_post_aul_contact', 'arcunify_handle_lp_contact' );
	add_action( 'admin_post_nopriv_aul_contact', 'arcunify_handle_lp_contact' );
}

/**
 * Print the Managed IT landing form, or its success / error notice.
 * Markup matches the plugin's form so the page looks the same.
 *
 * @param string $service Service key from arcunify_services().
 */
function arcunify_render_lp_form( $service ) {
	$sent   = isset( $_GET['sent'] ); // phpcs:ignore WordPress.Security.NonceVerification
	$lead   = absint( $_GET['lead'] ?? 0 ); // phpcs:ignore WordPress.Security.NonceVerification
	$error  = sanitize_key( $_GET['form_error'] ?? '' ); // phpcs:ignore WordPress.Security.NonceVerification
	$errors = array(
		'missing' => __( 'Please fill in your name and email.', 'arcunify' ),
		'email'   => __( 'Please enter a valid email address.', 'arcunify' ),
		'expired' => __( 'The form expired. Please send it again.', 'arcunify' ),
		'limit'   => __( 'Too many messages from this connection. Please email or call us instead.', 'arcunify' ),
	);

	if ( $sent ) {
		?>
		<div class="au-form__notice au-form__notice--ok" role="status" tabindex="-1" data-au-lead="<?php echo esc_attr( $lead ); ?>" data-au-form-context="landing">
		<?php echo arcunify_icon( 'circle-check' ); // phpcs:ignore ?>		<p><strong><?php esc_html_e( 'Message sent.', 'arcunify' ); ?></strong> <?php esc_html_e( 'Our team will respond within one business day.', 'arcunify' ); ?></p>
	</div>
		<?php
		return;
	}
	if ( isset( $errors[ $error ] ) ) {
		?>
		<div class="au-form__notice au-form__notice--error" role="alert">
			<?php echo arcunify_icon( 'circle-alert' ); // phpcs:ignore ?>			<p><?php echo esc_html( $errors[ $error ] ); ?></p>
		</div>
		<?php
	}
	?>
		<form class="au-form au-form--landing" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" novalidate data-au-form="landing">
		<input type="hidden" name="action" value="arcunify_lp_contact">
		<input type="hidden" name="au_form" value="landing">
		<input type="hidden" name="au_page" value="<?php echo esc_attr( get_queried_object_id() ); ?>">
		<input type="hidden" name="au_service" value="<?php echo esc_attr( $service ); ?>">
		<input type="hidden" name="au_attr" value="" data-au-attr>
		<input type="hidden" name="au_ts" value="<?php echo esc_attr( time() ); ?>">
		<?php wp_nonce_field( 'au_lp_contact', 'au_contact_nonce' ); ?>
		<div class="au-form__hp" aria-hidden="true">
			<label for="au_website"><?php esc_html_e( 'Website', 'arcunify' ); ?></label>
			<input type="text" id="au_website" name="au_website" tabindex="-1" autocomplete="off">
		</div>
		<div class="au-form__grid">
			<?php
			$types = array(
				'name'    => array( 'text', 'name' ),
				'email'   => array( 'email', 'email' ),
				'phone'   => array( 'tel', 'tel' ),
				'company' => array( 'text', 'organization' ),
			);
			foreach ( arcunify_lp_contact_fields() as $key => $field ) :
				$id   = 'au_' . $key;
				$wide = 'message' === $key ? ' au-field--wide' : '';
				?>
				<div class="au-field<?php echo esc_attr( $wide ); ?>">
					<label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $field[0] ); ?> <?php echo $field[1] ? '<span class="au-field__req" aria-hidden="true">*</span>' : '<span class="au-field__opt">' . esc_html__( '(optional)', 'arcunify' ) . '</span>'; // phpcs:ignore ?></label>
					<?php if ( 'message' === $key ) : ?>
						<textarea id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $id ); ?>" rows="3"></textarea>
					<?php else : ?>
						<input type="<?php echo esc_attr( $types[ $key ][0] ); ?>" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $id ); ?>" autocomplete="<?php echo esc_attr( $types[ $key ][1] ); ?>"<?php echo $field[1] ? ' required aria-required="true"' : ''; ?>>
					<?php endif; ?>
					<p class="au-field__error" id="<?php echo esc_attr( $id ); ?>-error" hidden></p>
				</div>
			<?php endforeach; ?>
		</div>
		<button class="au-btn au-btn--primary au-btn--block" type="submit"><span><?php esc_html_e( 'Get a Free Consultation', 'arcunify' ); ?></span><?php echo arcunify_icon( 'send', 'au-btn__icon' ); // phpcs:ignore ?></button>
		</form>
	<?php
}

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
