<?php
/**
 * Owner-editable settings (Appearance → Customize → ArcUnify).
 *
 * One schema drives registration, sanitisation and defaults, so adding a field
 * is one line. Values are read with arcunify_mod( 'key' ).
 *
 * Proof fields (counters, logos, service stats) default to empty/off: they render
 * only after ArcUnify supplies verified values.
 *
 * @package ArcUnify
 */

defined( 'ABSPATH' ) || exit;

/**
 * Settings schema: key => [ section, type, label, default, description? ].
 *
 * @return array
 */
function arcunify_settings_schema() {
	static $schema = null;
	if ( null !== $schema ) {
		return $schema;
	}

	$schema = array(
		// Contact & header.
		'phone'          => array( 'au_contact', 'text', __( 'Phone', 'arcunify' ), '+1 416 251 6545' ),
		'email'          => array( 'au_contact', 'email', __( 'Email', 'arcunify' ), 'info@arcunify.com' ),
		'address'        => array( 'au_contact', 'textarea', __( 'Address', 'arcunify' ), '350 Rutherford Rd S, Brampton, ON L6W 3M2' ),
		'support_line'   => array( 'au_contact', 'text', __( 'Support line', 'arcunify' ), '24/7 help desk, every day of the year' ),
		'show_utility'   => array( 'au_contact', 'checkbox', __( 'Show contact bar above the header', 'arcunify' ), true ),
		'cta_label'      => array( 'au_contact', 'text', __( 'Header button label', 'arcunify' ), 'Get a Free Consultation' ),
		'cta_url'        => array( 'au_contact', 'url', __( 'Header button link', 'arcunify' ), '/contact-us/' ),
		'social_linkedin'  => array( 'au_contact', 'url', __( 'LinkedIn URL', 'arcunify' ), '' ),
		'social_facebook'  => array( 'au_contact', 'url', __( 'Facebook URL', 'arcunify' ), '' ),
		'social_x'         => array( 'au_contact', 'url', __( 'X (Twitter) URL', 'arcunify' ), '' ),
		'social_instagram' => array( 'au_contact', 'url', __( 'Instagram URL', 'arcunify' ), '' ),
		'social_youtube'   => array( 'au_contact', 'url', __( 'YouTube URL', 'arcunify' ), '' ),

		// Homepage hero.
		'home_source'    => array( 'au_home', 'select', __( 'Homepage content', 'arcunify' ), 'theme', __( 'Use the new theme homepage, or the Home page\'s existing (Elementor) content.', 'arcunify' ) ),
		'hero_kicker'    => array( 'au_home', 'text', __( 'Hero small heading', 'arcunify' ), 'Future-Ready IT Solutions' ),
		'hero_title'     => array( 'au_home', 'text', __( 'Hero headline (H1)', 'arcunify' ), 'Managed IT, Cloud & Cybersecurity' ),
		'hero_lead'      => array( 'au_home', 'textarea', __( 'Hero text', 'arcunify' ), 'ArcUnify helps businesses stay secure, connected, and ready to scale. From managed IT services and VoIP communications to cybersecurity and cloud solutions, we deliver the technology backbone your business runs on.' ),
		'hero_cta1_label' => array( 'au_home', 'text', __( 'Primary button label', 'arcunify' ), 'Get a Free Consultation' ),
		'hero_cta1_url'   => array( 'au_home', 'url', __( 'Primary button link', 'arcunify' ), '/contact-us/' ),
		'hero_cta2_label' => array( 'au_home', 'text', __( 'Secondary button label', 'arcunify' ), 'Explore Our Solutions' ),
		'hero_cta2_url'   => array( 'au_home', 'url', __( 'Secondary button link', 'arcunify' ), '/services/' ),
		'show_why_claims' => array( 'au_home', 'checkbox', __( 'Show "Why Choose ArcUnify" claim lines (e.g. 99.99% uptime guarantee)', 'arcunify' ), true, __( 'Turn off if these claims are not yet verified.', 'arcunify' ) ),

		// Proof: hidden until verified.
		'show_counters'  => array( 'au_proof', 'checkbox', __( 'Show counters', 'arcunify' ), true, __( 'Each counter shows only when it has a number.', 'arcunify' ) ),
		'counter1_value' => array( 'au_proof', 'text', __( 'Tech Experts (number)', 'arcunify' ), '' ),
		'counter2_value' => array( 'au_proof', 'text', __( 'Client Satisfaction (number, %)', 'arcunify' ), '' ),
		'counter3_value' => array( 'au_proof', 'text', __( 'Industries Served (number)', 'arcunify' ), '' ),
		'show_logos'     => array( 'au_proof', 'checkbox', __( 'Show logo strip', 'arcunify' ), true, __( 'Logo slots below take priority; otherwise the image paths list is used. Set alt text on each image in the Media Library.', 'arcunify' ) ),
		'logo_paths'     => array( 'au_proof', 'textarea', __( 'Logo image paths (one per line)', 'arcunify' ), "/wp-content/uploads/2026/06/Vector-8.png\n/wp-content/uploads/2026/06/Vector-7.png\n/wp-content/uploads/2026/06/Vector-6.png\n/wp-content/uploads/2026/06/Vector-5.png\n/wp-content/uploads/2026/06/Vector-4.png\n/wp-content/uploads/2026/06/Vector-3.png\n/wp-content/uploads/2026/06/Vector-2.png\n/wp-content/uploads/2026/06/Vector-1.png\n/wp-content/uploads/2026/06/Vector.png", __( 'The logos currently on the live site. Used when no Logo slot is set.', 'arcunify' ) ),
		'logos_label'    => array( 'au_proof', 'text', __( 'Logo strip caption (optional)', 'arcunify' ), '' ),
	);

	for ( $i = 1; $i <= 8; $i++ ) {
		/* translators: %d: logo number. */
		$schema[ 'logo' . $i ] = array( 'au_proof', 'image', sprintf( __( 'Logo %d', 'arcunify' ), $i ), 0 );
	}

	// Prefilled where the live site states the same figure in its own copy.
	$stat_defaults = array(
		'voip'          => '60',
		'cybersecurity' => '70',
		'cloud'         => '40',
		'network'       => '99.99',
	);
	foreach ( arcunify_services() as $slug => $service ) {
		$schema[ 'stat_' . $slug ] = array(
			'au_proof',
			'text',
			/* translators: 1: stat label, 2: service name. */
			sprintf( __( '%1$s (%2$s)', 'arcunify' ), $service['stat_label'], $service['short'] ),
			isset( $stat_defaults[ $slug ] ) ? $stat_defaults[ $slug ] : '',
			__( 'Number only. Leave blank to hide.', 'arcunify' ),
		);
	}

	// Pricing (existing plans).
	$schema += array(
		'show_pricing'   => array( 'au_pricing', 'checkbox', __( 'Show pricing section', 'arcunify' ), true ),
		'plan1_name'     => array( 'au_pricing', 'text', __( 'Plan 1 name', 'arcunify' ), 'Essential IT' ),
		'plan1_price'    => array( 'au_pricing', 'text', __( 'Plan 1 price', 'arcunify' ), '$499' ),
		'plan1_period'   => array( 'au_pricing', 'text', __( 'Plan 1 period', 'arcunify' ), '/month' ),
		'plan1_blurb'    => array( 'au_pricing', 'textarea', __( 'Plan 1 description', 'arcunify' ), 'Best for small businesses that need reliable IT support and security.' ),
		'plan1_features' => array( 'au_pricing', 'textarea', __( 'Plan 1 features (one per line)', 'arcunify' ), "24/7 help desk support\nProactive monitoring and maintenance\nPatch management and updates\nAntivirus and endpoint protection" ),
		'plan1_popular'  => array( 'au_pricing', 'checkbox', __( 'Plan 1: show "Most Popular"', 'arcunify' ), true ),
		'plan2_name'     => array( 'au_pricing', 'text', __( 'Plan 2 name', 'arcunify' ), 'Business IT' ),
		'plan2_price'    => array( 'au_pricing', 'text', __( 'Plan 2 price', 'arcunify' ), '$999' ),
		'plan2_period'   => array( 'au_pricing', 'text', __( 'Plan 2 period', 'arcunify' ), '/month' ),
		'plan2_blurb'    => array( 'au_pricing', 'textarea', __( 'Plan 2 description', 'arcunify' ), 'Perfect for growing companies that need complete IT management and security.' ),
		'plan2_features' => array( 'au_pricing', 'textarea', __( 'Plan 2 features (one per line)', 'arcunify' ), "Everything in Essential IT\nAdvanced cybersecurity and MFA\nCloud backup and disaster recovery\nStrategic IT consulting and planning" ),
		'plan2_popular'  => array( 'au_pricing', 'checkbox', __( 'Plan 2: show "Most Popular"', 'arcunify' ), false ),
		'plan_cta_label' => array( 'au_pricing', 'text', __( 'Plan button label', 'arcunify' ), 'Get Started' ),
		'plan_cta_url'   => array( 'au_pricing', 'url', __( 'Plan button link', 'arcunify' ), '/contact-us/' ),
		'plan3_name'     => array( 'au_pricing', 'text', __( 'Enterprise name', 'arcunify' ), 'Enterprise' ),
		'plan3_blurb'    => array( 'au_pricing', 'textarea', __( 'Enterprise description', 'arcunify' ), 'Custom IT, security, and cloud solutions for large organizations and complex operations.' ),
		'plan3_cta_label' => array( 'au_pricing', 'text', __( 'Enterprise button label', 'arcunify' ), 'Contact Sales' ),

		// Pages & forms.
		'native_pages'   => array( 'au_pages', 'checkbox', __( 'Use the new designs for Services, the five service pages, About and Contact', 'arcunify' ), true, __( 'Untick to show those pages\' existing Elementor content inside the new header and footer. A template chosen in a page\'s own settings always wins.', 'arcunify' ) ),
		'form_recipient' => array( 'au_pages', 'email', __( 'Contact form: send enquiries to', 'arcunify' ), 'info@arcunify.com' ),
		'form_shortcode' => array( 'au_pages', 'text', __( 'Contact form: plugin shortcode (optional)', 'arcunify' ), '', __( 'e.g. [contact-form-7 id="123"]. Replaces the built-in form.', 'arcunify' ) ),
		'show_map'       => array( 'au_pages', 'checkbox', __( 'Contact page: show map', 'arcunify' ), true ),
		'output_schema'  => array( 'au_advanced', 'checkbox', __( 'Output structured data (Organization, FAQ, breadcrumbs)', 'arcunify' ), true, __( 'Untick if an SEO plugin already outputs Organization schema.', 'arcunify' ) ),

		// Advanced.
		'gtm_id'         => array( 'au_advanced', 'text', __( 'Google Tag Manager container ID', 'arcunify' ), 'GTM-KRNHXWK2', __( 'Preserved from the current site. Clear this if a plugin (e.g. Site Kit) already outputs GTM, to avoid double tracking.', 'arcunify' ) ),
	);

	return $schema;
}

/**
 * Register panel, sections and controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function arcunify_customize_register( $wp_customize ) {
	$wp_customize->add_panel(
		'arcunify',
		array(
			'title'    => __( 'ArcUnify', 'arcunify' ),
			'priority' => 30,
		)
	);

	$sections = array(
		'au_contact'  => __( 'Contact & header', 'arcunify' ),
		'au_home'     => __( 'Homepage', 'arcunify' ),
		'au_proof'    => __( 'Proof: counters, logos, stats', 'arcunify' ),
		'au_pricing'  => __( 'Pricing plans', 'arcunify' ),
		'au_pages'    => __( 'Pages & contact form', 'arcunify' ),
		'au_advanced' => __( 'Advanced', 'arcunify' ),
	);
	foreach ( $sections as $id => $title ) {
		$wp_customize->add_section( $id, array( 'title' => $title, 'panel' => 'arcunify' ) );
	}

	foreach ( arcunify_settings_schema() as $key => $field ) {
		list( $section, $type, $label, $default ) = $field;
		$description = isset( $field[4] ) ? $field[4] : '';
		$setting     = 'au_' . $key;

		$wp_customize->add_setting(
			$setting,
			array(
				'default'           => $default,
				'sanitize_callback' => arcunify_sanitizer_for( $type ),
				'transport'         => 'refresh',
			)
		);

		$args = array(
			'section'     => $section,
			'label'       => $label,
			'description' => $description,
		);

		if ( 'image' === $type ) {
			$args['mime_type'] = 'image';
			$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, $setting, $args ) );
			continue;
		}

		if ( 'select' === $type && 'home_source' === $key ) {
			$args['choices'] = array(
				'theme' => __( 'New theme homepage', 'arcunify' ),
				'page'  => __( 'Existing Home page content', 'arcunify' ),
			);
		}

		$args['type'] = in_array( $type, array( 'email', 'url' ), true ) ? 'text' : $type;
		$wp_customize->add_control( $setting, $args );
	}
}
add_action( 'customize_register', 'arcunify_customize_register' );

/**
 * Pick a sanitiser per field type.
 *
 * @param string $type Field type.
 * @return callable
 */
function arcunify_sanitizer_for( $type ) {
	switch ( $type ) {
		case 'checkbox':
			return 'arcunify_sanitize_checkbox';
		case 'email':
			return 'sanitize_email';
		case 'url':
			return 'arcunify_sanitize_url';
		case 'textarea':
			return 'sanitize_textarea_field';
		case 'image':
			return 'absint';
		case 'select':
			return 'sanitize_key';
		default:
			return 'sanitize_text_field';
	}
}

/**
 * @param mixed $value Raw value.
 * @return bool
 */
function arcunify_sanitize_checkbox( $value ) {
	return (bool) $value;
}

/**
 * Accept absolute URLs and site-relative paths like /contact-us/ or /#pricing.
 *
 * @param string $value Raw value.
 * @return string
 */
function arcunify_sanitize_url( $value ) {
	$value = trim( (string) $value );
	if ( '' === $value ) {
		return '';
	}
	if ( 0 === strpos( $value, '/' ) || 0 === strpos( $value, '#' ) ) {
		return sanitize_text_field( $value );
	}
	return esc_url_raw( $value );
}
