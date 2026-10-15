<?php
/**
 * ArcUnify theme bootstrap.
 *
 * Each concern lives in its own file under /inc. Keep this file a loader only.
 *
 * @package ArcUnify
 */

defined( 'ABSPATH' ) || exit;

define( 'ARCUNIFY_VERSION', '1.1.0' );
define( 'ARCUNIFY_DIR', get_template_directory() );
define( 'ARCUNIFY_URI', get_template_directory_uri() );

$arcunify_includes = array(
	'content',          // Existing ArcUnify copy (single source of truth).
	'content-pages',    // Existing inner-page copy, testimonials, team.
	'helpers',          // Template helpers: icons, URLs, buttons, settings.
	'theme-setup',      // Theme supports, menus, image sizes.
	'customizer',       // Owner-editable settings.
	'enqueue',          // Fonts, CSS, JS.
	'nav-walker',       // Desktop + mobile navigation markup.
	'testimonials',     // Testimonial post type (verified-only output).
	'performance',      // Front-end clean-up.
	'elementor-compat', // Rendering existing Elementor pages safely.
	'tracking',         // Google Tag Manager (preserved from the current site).
	'templates',        // Maps core pages to native templates.
	'contact-form',     // Built-in enquiry form (or a form plugin shortcode).
	'schema',           // Organization, FAQPage, BreadcrumbList JSON-LD.
);

foreach ( $arcunify_includes as $arcunify_file ) {
	require_once ARCUNIFY_DIR . '/inc/' . $arcunify_file . '.php';
}
unset( $arcunify_includes, $arcunify_file );
