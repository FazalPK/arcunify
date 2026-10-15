<?php
/**
 * Existing copy for inner pages, verbatim from the live site (audit 2026-10-03,
 * confirmed "as is" by the client). Filterable; change only with sign-off.
 *
 * @package ArcUnify
 */

defined( 'ABSPATH' ) || exit;

/**
 * Service page copy, keyed like arcunify_services().
 *
 * @return array
 */
function arcunify_service_pages() {
	$pages = array(
		'managed-it'    => array(
			'variant'     => 'managed',
			'tagline'     => __( 'Proactive, round-the-clock IT management that keeps your business running', 'arcunify' ),
			'intro_title' => __( 'Complete IT Management For Growing Businesses', 'arcunify' ),
			'intro'       => __( 'Transform your IT with end-to-end managed services. We handle monitoring, maintenance, security, and support, so you can focus on growth without disruptions.', 'arcunify' ),
			'use_cases'   => array(
				__( '24/7 monitoring and help desk support', 'arcunify' ),
				__( 'Network and server management', 'arcunify' ),
				__( 'Data backup and disaster recovery', 'arcunify' ),
				__( 'Co-managed IT for internal teams', 'arcunify' ),
			),
			'why_title'   => __( 'Why Businesses Trust ArcUnify With Their IT', 'arcunify' ),
			'why_lead'    => __( 'Our managed services are built to prevent problems, control costs, and scale with your growth.', 'arcunify' ),
			'why'         => array(
				array( __( '24/7 Monitoring & Support', 'arcunify' ), __( '24/7 help desk, every day of the year', 'arcunify' ) ),
				array( __( 'Proactive Incident Management', 'arcunify' ), __( '100% visibility into your IT health', 'arcunify' ) ),
				array( __( 'Cybersecurity-First Approach', 'arcunify' ), __( '24/7 threat detection and response', 'arcunify' ) ),
				array( __( 'Predictable Fixed Costs', 'arcunify' ), __( '0 hidden fees or surprise bills', 'arcunify' ) ),
				array( __( 'Scalable IT Solutions', 'arcunify' ), __( '1,000+ users supported with ease', 'arcunify' ) ),
				array( __( 'Co-Managed IT Support', 'arcunify' ), __( '100% flexible support for internal teams', 'arcunify' ) ),
				array( __( 'Backup & Disaster Recovery', 'arcunify' ), __( '99.99% data protection reliability', 'arcunify' ) ),
				array( __( 'Strategic IT Consulting', 'arcunify' ), __( '1 trusted partner for all your IT', 'arcunify' ) ),
			),
			'cta_title'   => __( 'Ready To Transform Your IT Operations?', 'arcunify' ),
			'cta_lead'    => __( 'Let ArcUnify handle your technology so you can focus on growing your business without disruptions.', 'arcunify' ),
		),
		'voip'          => array(
			'variant'     => 'voice',
			'tagline'     => __( 'Connect smarter with cloud calling, video, and collaboration in one platform', 'arcunify' ),
			'intro_title' => __( 'Smarter Communication For Modern Teams', 'arcunify' ),
			'intro'       => __( 'Revolutionize the way your team connects with crystal-clear VoIP calling, video conferencing, and seamless collaboration, all from one powerful cloud platform.', 'arcunify' ),
			'use_cases'   => array(
				__( 'Remote and hybrid team communication', 'arcunify' ),
				__( 'Customer support and call centers', 'arcunify' ),
				__( 'Sales teams and outbound calling', 'arcunify' ),
				__( 'Healthcare and professional services', 'arcunify' ),
			),
			'why_title'   => __( 'What Makes VoIP & UC A Game-Changer For Your Business', 'arcunify' ),
			'why_lead'    => __( 'Our platform brings voice, video, and messaging together so your team stays connected anywhere.', 'arcunify' ),
			'why'         => array(
				array( __( 'Cost-Effective Communication', 'arcunify' ), __( '60% savings vs traditional phone lines', 'arcunify' ) ),
				array( __( 'HD Voice & Video Calling', 'arcunify' ), __( '100% crystal-clear call quality', 'arcunify' ) ),
				array( __( 'Work From Anywhere', 'arcunify' ), __( '100% access on any device, anywhere', 'arcunify' ) ),
				array( __( 'All-In-One Platform', 'arcunify' ), __( '1 hub for voice, video, and messaging', 'arcunify' ) ),
				array( __( 'Voicemail-To-Email', 'arcunify' ), __( '0 missed messages, ever', 'arcunify' ) ),
				array( __( 'Intelligent Call Routing', 'arcunify' ), __( '24/7 auto attendants for every call', 'arcunify' ) ),
				array( __( 'Built For Reliability', 'arcunify' ), __( '99.99% uptime with redundant servers', 'arcunify' ) ),
				array( __( 'Pay-As-You-Grow Pricing', 'arcunify' ), __( '100% scalable as your team grows', 'arcunify' ) ),
			),
			'cta_title'   => __( 'Ready To Upgrade Your Business Communication?', 'arcunify' ),
			'cta_lead'    => __( 'Bring voice, video, and collaboration together in one platform that keeps your team in sync.', 'arcunify' ),
		),
		'cybersecurity' => array(
			'variant'     => 'security',
			'tagline'     => __( 'Stay one step ahead of hackers with multi-layered, proactive protection', 'arcunify' ),
			'intro_title' => __( 'Smart Cybersecurity Built For Modern Businesses', 'arcunify' ),
			'intro'       => __( 'Detect, prevent, and respond to cyber threats before they disrupt your operations with advanced firewalls, endpoint protection, and 24/7 monitoring.', 'arcunify' ),
			'use_cases'   => array(
				__( 'Threat detection and incident response', 'arcunify' ),
				__( 'Endpoint and email protection', 'arcunify' ),
				__( 'Compliance with HIPAA, GDPR, and PCI-DSS', 'arcunify' ),
				__( 'Security awareness training', 'arcunify' ),
			),
			'why_title'   => __( 'Why We Lead The Way In Cyber Defense', 'arcunify' ),
			'why_lead'    => __( 'Our security is built to protect under real conditions, adapt to new threats, and keep you compliant.', 'arcunify' ),
			'why'         => array(
				array( __( 'Certified Security Experts', 'arcunify' ), __( '24/7 security operations coverage', 'arcunify' ) ),
				array( __( 'Multi-Layered Defense', 'arcunify' ), __( '360° protection across your stack', 'arcunify' ) ),
				array( __( 'Advanced Threat Detection', 'arcunify' ), __( '70% faster incident response', 'arcunify' ) ),
				array( __( 'Endpoint Protection', 'arcunify' ), __( '100% coverage for every device', 'arcunify' ) ),
				array( __( 'Access Control & MFA', 'arcunify' ), __( '0 tolerance for unauthorized access', 'arcunify' ) ),
				array( __( 'Data Encryption & DLP', 'arcunify' ), __( '100% data protected in transit and at rest', 'arcunify' ) ),
				array( __( 'Compliance & Governance', 'arcunify' ), __( '100% support for HIPAA, GDPR, PCI-DSS', 'arcunify' ) ),
				array( __( 'Rapid Incident Response', 'arcunify' ), __( '24/7 response team on standby', 'arcunify' ) ),
			),
			'cta_title'   => __( 'Ready To Secure Your Business?', 'arcunify' ),
			'cta_lead'    => __( 'Protect your data, your people, and your reputation with security that never sleeps.', 'arcunify' ),
		),
		'cloud'         => array(
			'variant'     => 'cloud',
			'tagline'     => __( 'Powering smarter decisions through scalable cloud and data intelligence', 'arcunify' ),
			'intro_title' => __( 'Scalable, Secure, And Intelligent Cloud Technologies', 'arcunify' ),
			'intro'       => __( 'Streamline operations, enhance security, and unlock powerful business insights with end-to-end cloud migration, management, and data analytics.', 'arcunify' ),
			'use_cases'   => array(
				__( 'Cloud migration and modernization', 'arcunify' ),
				__( 'Hybrid and multi-cloud management', 'arcunify' ),
				__( 'Data integration and warehousing', 'arcunify' ),
				__( 'Analytics, BI, and machine learning', 'arcunify' ),
			),
			'why_title'   => __( 'Why Businesses Build Their Cloud With ArcUnify', 'arcunify' ),
			'why_lead'    => __( 'Our cloud and data solutions are built to scale on demand, stay secure, and turn information into advantage.', 'arcunify' ),
			'why'         => array(
				array( __( 'Fast Cloud Deployment', 'arcunify' ), __( '50% faster deployment timelines', 'arcunify' ) ),
				array( __( 'Enterprise-Grade Security', 'arcunify' ), __( '100% compliance-ready infrastructure', 'arcunify' ) ),
				array( __( 'Certified Cloud Architects', 'arcunify' ), __( '100% certified experts on every project', 'arcunify' ) ),
				array( __( 'Pay For What You Use', 'arcunify' ), __( '40% reduction in infrastructure costs', 'arcunify' ) ),
				array( __( 'Hybrid & Multi-Cloud Ready', 'arcunify' ), __( '1 strategy across every cloud', 'arcunify' ) ),
				array( __( 'Data Integration & Warehousing', 'arcunify' ), __( '1 unified platform for all your data', 'arcunify' ) ),
				array( __( 'Analytics & BI Dashboards', 'arcunify' ), __( '2x faster strategic insights', 'arcunify' ) ),
				array( __( '24/7 Cloud Monitoring', 'arcunify' ), __( '24/7 performance monitoring and support', 'arcunify' ) ),
			),
			'cta_title'   => __( 'Ready To Unlock The Power Of The Cloud?', 'arcunify' ),
			'cta_lead'    => __( 'Modernize your business, empower your team, and turn your data into a competitive advantage.', 'arcunify' ),
		),
		'network'       => array(
			'variant'     => 'network',
			'tagline'     => __( 'Fast, secure, and reliable networks engineered for performance', 'arcunify' ),
			'intro_title' => __( 'The Backbone Of Every Modern Business', 'arcunify' ),
			'intro'       => __( 'From structured cabling and Wi-Fi to firewalls and cloud integration, we design and deploy scalable networks built for performance, security, and uptime.', 'arcunify' ),
			'use_cases'   => array(
				__( 'Structured cabling systems', 'arcunify' ),
				__( 'LAN/WAN design and deployment', 'arcunify' ),
				__( 'Secure high-speed Wi-Fi solutions', 'arcunify' ),
				__( 'Switches, routers, and firewalls', 'arcunify' ),
			),
			'why_title'   => __( 'The Advantages Of Partnering With ArcUnify', 'arcunify' ),
			'why_lead'    => __( 'Our networks are engineered to maximize uptime, support growth, and stay ready for what comes next.', 'arcunify' ),
			'why'         => array(
				array( __( 'Scalable Network Designs', 'arcunify' ), __( '100% built to grow with your business', 'arcunify' ) ),
				array( __( 'High Availability', 'arcunify' ), __( '99.99% uptime with redundant configurations', 'arcunify' ) ),
				array( __( 'Future-Ready Infrastructure', 'arcunify' ), __( '100% ready for IoT, cloud, and VoIP', 'arcunify' ) ),
				array( __( 'End-To-End Support', 'arcunify' ), __( '24/7 monitoring and maintenance', 'arcunify' ) ),
				array( __( 'Enterprise-Grade Hardware', 'arcunify' ), __( '100% trusted switches, routers, firewalls', 'arcunify' ) ),
				array( __( 'Integrated Network Security', 'arcunify' ), __( '24/7 threat monitoring with VPNs', 'arcunify' ) ),
				array( __( 'On-Site & Remote Support', 'arcunify' ), __( '2 support options for every location', 'arcunify' ) ),
				array( __( 'Flexible Maintenance Contracts', 'arcunify' ), __( '100% priority support included', 'arcunify' ) ),
			),
			'cta_title'   => __( 'Ready To Build A Stronger Network?', 'arcunify' ),
			'cta_lead'    => __( 'Build the fast, secure, and reliable foundation your business runs on, designed to grow with you.', 'arcunify' ),
		),
	);

	return apply_filters( 'arcunify_service_pages', $pages );
}

/**
 * Shared labels used on every service page (existing wording).
 *
 * @return array
 */
function arcunify_service_labels() {
	return array(
		'get_started' => __( 'Get started', 'arcunify' ),
		'use_cases'   => __( 'Use Cases', 'arcunify' ),
		'why_kicker'  => __( 'Why Choose ArcUnify', 'arcunify' ),
		'others'      => __( 'Explore Our Solutions', 'arcunify' ),
	);
}

/**
 * About, Services hub and Contact page copy.
 *
 * @return array
 */
function arcunify_page_content() {
	$content = array(
		'about'    => array(
			'kicker'        => __( 'About us', 'arcunify' ),
			'h1'            => __( 'Empowering your business through reliable, secure, and scalable IT solutions', 'arcunify' ),
			'title'         => __( 'Empowering Businesses Through Reliable IT Solutions.', 'arcunify' ),
			'intro'         => __( 'ArcUnify is a managed IT services provider dedicated to helping modern businesses operate securely, efficiently, and confidently.', 'arcunify' ),
			'sub_title'     => __( 'Experienced professionals who take the complexity out of IT', 'arcunify' ),
			'body'          => __( 'Our team of IT professionals, network engineers, cybersecurity experts, and client success managers brings decades of combined experience. We tailor every solution to meet your specific needs, goals, and budget.', 'arcunify' ),
			'note_title'    => __( 'Proactive support that prevents problems before they start', 'arcunify' ),
			'results_title' => __( 'Measurable Results', 'arcunify' ),
			'results_body'  => __( 'We focus on uptime, performance, and ROI you can clearly track.', 'arcunify' ),
			'values_kicker' => __( 'Core Values', 'arcunify' ),
			'values_title'  => __( 'Turning Technology Into Real Business Impact', 'arcunify' ),
			'values_lead'   => __( 'We deliver reliable, secure, and scalable IT systems designed to solve real business problems, improve efficiency, and create sustainable growth.', 'arcunify' ),
			'mission_title' => __( 'Our Mission', 'arcunify' ),
			'mission'       => __( 'To deliver reliable, secure, and scalable IT solutions that drive growth and innovation for our clients.', 'arcunify' ),
			'vision_title'  => __( 'Our Vision', 'arcunify' ),
			'vision'        => __( 'To be the most trusted managed IT partner, known for client success and technical excellence.', 'arcunify' ),
			'mission_image' => '/wp-content/uploads/2026/06/team-looking-4P6W6TV.jpg',
			'vision_image'  => '/wp-content/uploads/2026/06/modern-office-dur-X47AN3V.jpg',
			'team_kicker'   => __( 'Expert Team', 'arcunify' ),
			'team_title'    => __( 'The People Behind Your Technology', 'arcunify' ),
			'team_lead'     => __( "We don't just manage technology, we deliver IT systems that perform in real operations.", 'arcunify' ),
			'team'          => array(
				array( 'Daniel Reed', __( 'Chief Technology Officer', 'arcunify' ) ),
				array( 'Maya Chen', __( 'Head of Network Engineering', 'arcunify' ) ),
				array( 'Alex Foster', __( 'Cybersecurity Lead', 'arcunify' ) ),
				array( 'Sofia Martinez', __( 'Client Success Manager', 'arcunify' ) ),
			),
		),
		'services' => array(
			'kicker' => __( 'Our Services', 'arcunify' ),
			'h1'     => __( 'Complete IT solutions designed to keep your business secure, connected, and growing', 'arcunify' ),
		),
		'contact'  => array(
			'kicker'       => __( 'Contact us', 'arcunify' ),
			'h1'           => __( "Let's talk about keeping your business secure, connected, and growing", 'arcunify' ),
			'panel_kicker' => __( 'Get In Touch', 'arcunify' ),
			'panel_title'  => __( "Let's Talk About Your IT Needs", 'arcunify' ),
			'panel_lead'   => __( 'Reach out for a free consultation and our team will respond within one business day.', 'arcunify' ),
			'faq_kicker'   => __( 'FAQS', 'arcunify' ),
			'faq_title'    => __( 'Frequently Asked Questions', 'arcunify' ),
			'faq'          => array(
				array( __( 'What types of businesses can benefit from managed IT services?', 'arcunify' ), __( 'Businesses of every size and industry, including finance, healthcare, education, retail, and manufacturing. Our solutions scale from 10 to 1,000+ users.', 'arcunify' ) ),
				array( __( 'Do we need an internal IT team to work with you?', 'arcunify' ), __( 'No. We offer full IT outsourcing, or we can work alongside your internal team in a co-managed model to fill gaps like 24/7 monitoring or cybersecurity.', 'arcunify' ) ),
				array( __( 'How quickly can we get started?', 'arcunify' ), __( 'Getting started is easy: schedule a free consultation, receive a tailored assessment and proposal, then onboard with minimal disruption, often within a few weeks.', 'arcunify' ) ),
				array( __( 'Can your solutions integrate with our existing systems?', 'arcunify' ), __( 'Yes. Our solutions integrate with the tools you already use, including Microsoft 365, Google Workspace, CRM platforms, and other business applications.', 'arcunify' ) ),
				array( __( 'How do you ensure data security and compliance?', 'arcunify' ), __( 'We implement enterprise-grade security including firewalls, endpoint protection, multi-factor authentication, encryption, and regular audits, with compliance support for HIPAA, GDPR, and SOC 2.', 'arcunify' ) ),
				array( __( 'Do you provide ongoing support after setup?', 'arcunify' ), __( 'Yes. Our team provides 24/7/365 monitoring, proactive maintenance, and help desk support to keep your systems running smoothly as your business grows.', 'arcunify' ) ),
			),
			'call_kicker'  => __( 'Schedule a free 30-minute consultation with our IT experts.', 'arcunify' ),
			'call_title'   => __( 'Prefer A Quick Call?', 'arcunify' ),
			'call_button'  => __( 'Book A Consultation', 'arcunify' ),
		),
	);
	return apply_filters( 'arcunify_page_content', $content );
}

/**
 * Testimonials as published on the live site. Seeded once into the
 * Testimonials post type (see inc/testimonials.php); edit them there afterwards.
 * service '' = homepage / Services page set.
 *
 * @return array [ name, role, quote, service ]
 */
function arcunify_seed_testimonials() {
	return array(
		array( 'Sarah Mitchell', 'Operations Manager', 'Switching to ArcUnify’s managed IT services cut our downtime to nearly zero. Their team catches issues before we even notice them.', '' ),
		array( 'David Chen', 'Office Director', 'The VoIP migration was completely seamless. Call quality improved and our phone costs dropped significantly within the first quarter.', '' ),
		array( 'Maria Lopez', 'IT Director', 'Our security posture is stronger than ever, and compliance is no longer a headache.', '' ),
		array( 'James Carter', 'CEO', 'ArcUnify delivered a cloud migration perfectly aligned with our growth strategy. We scaled faster and improved customer experience.', '' ),

		array( 'Sarah Mitchell', 'Operations Manager', 'Switching to ArcUnify’s managed IT services cut our downtime to nearly zero. Their team catches issues before we even notice them.', 'managed-it' ),
		array( 'David Chen', 'Finance Director', 'The fixed monthly pricing finally made our IT budget predictable. No more surprise repair bills.', 'managed-it' ),
		array( 'Maria Lopez', 'IT Manager', 'They work seamlessly alongside our internal IT team and fill every gap.', 'managed-it' ),
		array( 'James Carter', 'CEO', 'Onboarding was smooth and the 24/7 help desk has been a game changer for our staff across two locations.', 'managed-it' ),

		array( 'David Chen', 'Office Director', 'The VoIP migration was completely seamless. Call quality improved and our phone costs dropped significantly within the first quarter.', 'voip' ),
		array( 'Sarah Mitchell', 'Operations Manager', 'Our remote team finally feels like one office. Calls, video, and chat all live in a single app.', 'voip' ),
		array( 'Maria Lopez', 'Sales Manager', 'Voicemail-to-email alone has saved our sales team hours every week.', 'voip' ),
		array( 'James Carter', 'Customer Support Lead', 'Auto attendants route every call to the right person. Our customers noticed the difference immediately.', 'voip' ),

		array( 'Maria Lopez', 'IT Director', 'Our security posture is stronger than ever, and compliance is no longer a headache.', 'cybersecurity' ),
		array( 'Sarah Mitchell', 'Operations Manager', 'Their team blocked a phishing campaign that would have cost us dearly. The employee training has paid for itself.', 'cybersecurity' ),
		array( 'James Carter', 'CEO', 'The incident response plan gave our board real confidence. We finally sleep at night.', 'cybersecurity' ),
		array( 'David Chen', 'Managing Partner', 'Enterprise-level protection at a price our mid-sized firm could actually afford.', 'cybersecurity' ),

		array( 'Sarah Mitchelle', 'Operations Manager', 'ArcUnify delivered a cloud migration perfectly aligned with our growth strategy. We scaled faster and improved customer experience.', 'cloud' ),
		array( 'David Chen', 'Office Director', 'Our marketing decisions are now data-driven and far more effective.', 'cloud' ),
		array( 'Maria Lopez', 'IT Director', 'Moving to the cloud cut our infrastructure costs and eliminated our server maintenance headaches.', 'cloud' ),
		array( 'James Carter', 'CEO', 'The BI dashboards give our leadership real-time visibility we never had before.', 'cloud' ),

		array( 'Sarah Mitchell', 'Operations Manager', 'The new structured cabling and Wi-Fi transformed our office. Dead zones are gone and everything just works.', 'network' ),
		array( 'David Chen', 'Office Director', 'They upgraded our entire network with zero downtime during business hours. Impressive execution.', 'network' ),
		array( 'Maria Lopez', 'IT Director', 'Our multi-site network finally runs as one. Performance and security improved across every location.', 'network' ),
		array( 'James Carter', 'CEO', 'From design to installation to ongoing support, they handled everything end to end.', 'network' ),
	);
}
