<?php
/**
 * Existing ArcUnify content, copied verbatim from the live site (audit of 2026-10-03).
 *
 * This file is the source of truth for copy that is not yet owner-editable.
 * Do not reword business copy here; change it only with client sign-off.
 * Every array is filterable so a child theme or plugin can override it.
 *
 * Fields marked "verify" are rendered only when a value is entered in the Customizer.
 *
 * @package ArcUnify
 */

defined( 'ABSPATH' ) || exit;

/**
 * The five services. Order matches the existing homepage.
 *
 * - desc, bullets: existing "Our Solutions" / "What We Serve" copy.
 * - group: navigation grouping (Manage / Secure / Connect / Scale).
 * - result_*: existing "Result" blocks. Stat values are blank until verified.
 * - Network Infrastructure has no "Our Solutions" bullets on the live site,
 *   so its bullets are its own existing page Use Cases.
 *
 * @return array
 */
function arcunify_services() {
	$services = array(
		'managed-it'   => array(
			'name'         => __( 'Managed IT Services', 'arcunify' ),
			'short'        => __( 'Managed IT', 'arcunify' ),
			'path'         => '/managed-it-services/',
			'icon'         => 'server-cog',
			'group'        => 'manage',
			'desc'         => __( 'End-to-end IT management with proactive monitoring, expert support, and predictable monthly costs.', 'arcunify' ),
			'bullets'      => array(
				__( '24/7 monitoring and help desk support', 'arcunify' ),
				__( 'Proactive maintenance and patch management', 'arcunify' ),
				__( 'Predictable fixed monthly pricing', 'arcunify' ),
			),
			'result_title' => __( 'Less downtime, more productivity', 'arcunify' ),
			'result_line'  => __( '24/7 monitoring and help desk support', 'arcunify' ),
			'stat_label'   => __( 'Businesses supported', 'arcunify' ),
			'stat_suffix'  => '+',
		),
		'voip'         => array(
			'name'         => __( 'VoIP & Unified Communications', 'arcunify' ),
			'short'        => __( 'VoIP & UC', 'arcunify' ),
			'path'         => '/voip-unified-communications/',
			'icon'         => 'phone-call',
			'group'        => 'connect',
			'desc'         => __( 'Connect your team anywhere with crystal-clear calls, video conferencing, and collaboration tools built for modern work.', 'arcunify' ),
			'bullets'      => array(
				__( 'HD voice, video, and team messaging', 'arcunify' ),
				__( 'Voicemail-to-email and auto attendants', 'arcunify' ),
				__( 'Mobile apps for remote and hybrid teams', 'arcunify' ),
			),
			'result_title' => __( 'Seamless business communication', 'arcunify' ),
			'result_line'  => __( 'HD voice, video, and messaging in one platform', 'arcunify' ),
			'stat_label'   => __( 'Savings vs traditional phone systems', 'arcunify' ),
			'stat_suffix'  => '%',
		),
		'cybersecurity' => array(
			'name'         => __( 'Cybersecurity Solutions', 'arcunify' ),
			'short'        => __( 'Cybersecurity', 'arcunify' ),
			'path'         => '/cybersecurity-solutions/',
			'icon'         => 'shield-check',
			'group'        => 'secure',
			'desc'         => __( 'Protect your data, devices, and people with zero-trust security, endpoint protection, and compliance support.', 'arcunify' ),
			'bullets'      => array(
				__( '24/7 threat detection and response', 'arcunify' ),
				__( 'Endpoint protection and multi-factor authentication', 'arcunify' ),
				__( 'Compliance support for HIPAA, GDPR, and PCI-DSS', 'arcunify' ),
			),
			'result_title' => __( '24/7 threat detection and response', 'arcunify' ),
			'result_line'  => __( 'Multi-layered defense against modern threats', 'arcunify' ),
			'stat_label'   => __( 'Faster incident response', 'arcunify' ),
			'stat_suffix'  => '%',
		),
		'cloud'        => array(
			'name'         => __( 'Cloud & Data Solutions', 'arcunify' ),
			'short'        => __( 'Cloud & Data', 'arcunify' ),
			'path'         => '/cloud-and-data-solutions/',
			'icon'         => 'cloud',
			'group'        => 'scale',
			'desc'         => __( 'Migrate, manage, and scale in the cloud while turning your data into insights that drive growth.', 'arcunify' ),
			'bullets'      => array(
				__( 'Secure cloud migration and management', 'arcunify' ),
				__( 'Analytics and business intelligence', 'arcunify' ),
			),
			'result_title' => __( 'Faster, smarter business decisions', 'arcunify' ),
			'result_line'  => __( 'Cloud migration and analytics expertise', 'arcunify' ),
			'stat_label'   => __( 'Reduction in infrastructure costs', 'arcunify' ),
			'stat_suffix'  => '%',
		),
		'network'      => array(
			'name'         => __( 'Network Infrastructure', 'arcunify' ),
			'short'        => __( 'Network', 'arcunify' ),
			'path'         => '/network-infrastructure/',
			'icon'         => 'network',
			'group'        => 'connect',
			'desc'         => __( 'Design, deployment, and support for fast, secure networks that scale with your business.', 'arcunify' ),
			'bullets'      => array(
				__( 'Structured cabling systems', 'arcunify' ),
				__( 'LAN/WAN design and deployment', 'arcunify' ),
				__( 'Secure high-speed Wi-Fi solutions', 'arcunify' ),
				__( 'Switches, routers, and firewalls', 'arcunify' ),
			),
			'result_title' => __( 'Built for speed, security, and uptime', 'arcunify' ),
			'result_line'  => __( 'Structured cabling, Wi-Fi, and enterprise firewalls', 'arcunify' ),
			'stat_label'   => __( 'Network uptime guarantee', 'arcunify' ),
			'stat_suffix'  => '%',
		),
	);

	return apply_filters( 'arcunify_services', $services );
}

/**
 * Navigation groups for the Services mega-menu.
 * Labels come from the existing promise: "secure, connected, and ready to scale".
 *
 * @return array
 */
function arcunify_service_groups() {
	return apply_filters(
		'arcunify_service_groups',
		array(
			'manage'  => __( 'Manage', 'arcunify' ),
			'secure'  => __( 'Secure', 'arcunify' ),
			'connect' => __( 'Connect', 'arcunify' ),
			'scale'   => __( 'Scale', 'arcunify' ),
		)
	);
}

/**
 * Homepage copy that is not (yet) a Customizer field.
 *
 * @return array
 */
function arcunify_home_content() {
	$content = array(
		'about'    => array(
			'kicker'        => __( 'About us', 'arcunify' ),
			'title'         => __( 'Your Trusted Partner For Secure, Connected IT.', 'arcunify' ),
			'intro'         => __( 'ArcUnify is a managed IT services provider helping modern businesses stay secure, connected, and ready for the future.', 'arcunify' ),
			'sub_title'     => __( 'Scalable IT solutions designed for long-term growth', 'arcunify' ),
			'body'          => __( 'By combining proactive IT management, cybersecurity expertise, and cloud engineering, we deliver solutions that keep your systems running, your data protected, and your teams connected.', 'arcunify' ),
			'note_title'    => __( 'Proactive support that prevents problems before they start', 'arcunify' ),
			'results_title' => __( 'Measurable Results', 'arcunify' ),
			'results_body'  => __( 'We focus on uptime, performance, and ROI you can clearly track.', 'arcunify' ),
		),
		'services' => array(
			'kicker' => __( 'What We Serve', 'arcunify' ),
			'title'  => __( 'IT Solutions Built For Modern Business', 'arcunify' ),
			'lead'   => __( 'Our solutions are designed to improve efficiency, reduce costs, and keep your business secure, connected, and ready for the future.', 'arcunify' ),
			'link'   => __( 'Explore Our Solutions', 'arcunify' ),
		),
		'outcomes' => array(
			'kicker' => __( 'Our Solutions', 'arcunify' ),
			'title'  => __( 'Real IT Solutions In Action.', 'arcunify' ),
			'label'  => __( 'Result', 'arcunify' ),
			'link'   => __( 'Get Started', 'arcunify' ),
		),
		'why'      => array(
			'kicker' => __( 'Why Choose ArcUnify', 'arcunify' ),
			'title'  => __( 'IT Solutions Designed For Real-World Business Success', 'arcunify' ),
			'lead'   => __( 'Our solutions are built to perform under real conditions, scale with your growth, and adapt as technology evolves.', 'arcunify' ),
			// Title => existing claim line (claims need verification, see audit doc).
			'items'  => array(
				array( __( '24/7 Support & Monitoring', 'arcunify' ), __( '24/7 expert support availability', 'arcunify' ) ),
				array( __( 'Business-First Approach', 'arcunify' ), __( '100% aligned with your goals', 'arcunify' ) ),
				array( __( 'End-to-End IT Management', 'arcunify' ), __( '99.99% uptime guarantee', 'arcunify' ) ),
				array( __( 'Cybersecurity-First Mindset', 'arcunify' ), __( '24/7 threat detection and response', 'arcunify' ) ),
				array( __( 'Transparent & Measurable Results', 'arcunify' ), __( '100% transparent fixed pricing', 'arcunify' ) ),
				array( __( 'Scalable, Future-Ready Design', 'arcunify' ), __( '1,000+ users supported with ease', 'arcunify' ) ),
				array( __( 'Long-Term Partnership Mindset', 'arcunify' ), __( '98% client retention rate', 'arcunify' ) ),
				array( __( 'Seamless System Integration', 'arcunify' ), __( '100+ tools and platforms integrated', 'arcunify' ) ),
			),
		),
		// Existing 4-step process from the Contact page.
		'process'  => array(
			'title'      => __( 'A Clear Process. Real Results.', 'arcunify' ),
			'lead'       => __( 'At ArcUnify, we follow a structured framework to ensure every IT solution is practical, scalable, and measurable.', 'arcunify' ),
			'list_title' => __( 'What Happens Here:', 'arcunify' ),
			'steps'      => array(
				array(
					'label' => __( 'Step 01', 'arcunify' ),
					'title' => __( 'Consultation & Assessment', 'arcunify' ),
					'desc'  => __( 'We start by understanding your business goals, challenges, and current infrastructure to identify the right IT solutions.', 'arcunify' ),
					'items' => array( __( 'Business needs analysis', 'arcunify' ), __( 'IT infrastructure assessment', 'arcunify' ), __( 'Tailored proposal and roadmap', 'arcunify' ) ),
				),
				array(
					'label' => __( 'Step 02', 'arcunify' ),
					'title' => __( 'Solution Design', 'arcunify' ),
					'desc'  => __( 'Our team designs a custom solution tailored to your workflows, security requirements, and budget.', 'arcunify' ),
					'items' => array( __( 'Architecture and network planning', 'arcunify' ), __( 'Security and compliance strategy', 'arcunify' ), __( 'Scalable solution design', 'arcunify' ) ),
				),
				array(
					'label' => __( 'Step 03', 'arcunify' ),
					'title' => __( 'Implementation', 'arcunify' ),
					'desc'  => __( 'We deploy and configure your systems with minimal disruption to your daily operations.', 'arcunify' ),
					'items' => array( __( 'Seamless setup and migration', 'arcunify' ), __( 'System and VoIP integration', 'arcunify' ), __( 'Performance testing and validation', 'arcunify' ) ),
				),
				array(
					'label' => __( 'Step 04', 'arcunify' ),
					'title' => __( 'Support & Growth', 'arcunify' ),
					'desc'  => __( 'After launch, we monitor, maintain, and continuously optimize your systems for long-term success.', 'arcunify' ),
					'items' => array( __( '24/7 monitoring and help desk', 'arcunify' ), __( 'Proactive maintenance and updates', 'arcunify' ), __( 'Continuous improvement and scaling', 'arcunify' ) ),
				),
			),
		),
		'pricing'  => array(
			'kicker'        => __( 'Pricing Plans', 'arcunify' ),
			'title'         => __( 'Flexible IT Plans For Every Business', 'arcunify' ),
			'lead'          => __( 'Our service plans are designed to help businesses start, scale, and fully manage their IT with expert support and predictable monthly costs.', 'arcunify' ),
			'included'      => __( "What's included?", 'arcunify' ),
			'popular_label' => __( 'Most Popular', 'arcunify' ),
		),
		'testimonials' => array(
			'kicker' => __( 'Testimonials', 'arcunify' ),
			'title'  => __( 'Trusted By Forward-Thinking Companies', 'arcunify' ),
		),
		'cta'      => array(
			'title' => __( 'Ready To Transform Your Business IT?', 'arcunify' ),
			'lead'  => __( "Let's build secure, future-ready IT solutions that help your business stay connected and ahead of the competition.", 'arcunify' ),
		),
		'footer'   => array(
			'about' => __( 'ArcUnify is a managed IT services provider helping modern businesses stay secure, connected, and ready for the future.', 'arcunify' ),
		),
	);

	return apply_filters( 'arcunify_home_content', $content );
}
