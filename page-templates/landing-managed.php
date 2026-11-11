<?php
/**
 * Template Name: ArcUnify: Managed IT Landing
 *
 * Google Ads landing page for /managed-it-service/, moved into the theme from the
 * "ArcUnify Landing Pages (Google Ads)" plugin v1.1.1. Markup is the plugin's output,
 * unchanged; it has its own slim header and footer and loads assets/css/landing-managed.css
 * and assets/js/landing.js instead of the theme's. The form, enquiry log, gclid/UTM capture
 * and GTM events live in inc/landing.php and assets/js/landing.js.
 *
 * @package ArcUnify
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="au-skip" href="#content"><?php esc_html_e( 'Skip to content', 'arcunify' ); ?></a>
<header class="au-header au-lp-header" data-theme="dark" data-au-header>
	<div class="au-header__bar">
		<div class="au-container au-header__inner">
			<div class="au-brand">
				<img width="181" height="184" src="https://arcunify.com/wp-content/uploads/2026/10/cropped-f97dbcdf-d4f8-4001-a6c1-96b2b1a75fa7_removalai_preview.png" class="custom-logo" alt="arcunify" fetchpriority="high" decoding="async" />			</div>
			<div class="au-header__actions">
									<a class="au-lp-call" href="tel:+14162516545">
						<svg class="au-icon " aria-hidden="true" focusable="false"><use href="#i-phone"></use></svg>						<span class="au-lp-call__text"><span class="au-lp-call__label">24/7 help desk, every day of the year</span><span class="au-lp-call__num">+1 416 251 6545</span></span>
					</a>
								<a class="au-btn au-btn--primary au-header__cta" href="#lp-form"><span>Get a Free Consultation</span><svg class="au-icon au-btn__icon" aria-hidden="true" focusable="false"><use href="#i-arrow-right"></use></svg></a>			</div>
		</div>
	</div>
</header>
<main id="content" class="au-main au-lp au-lp--managed">

	<section class="au-lp-hero" data-theme="dark" aria-labelledby="au-lp-title">
		<div class="au-container au-lp-hero__grid">
			<div class="au-lp-hero__copy">
				<p class="au-kicker">Managed IT Services</p>
				<h1 class="au-lp-hero__title" id="au-lp-title">Complete IT Management For Growing Businesses</h1>
				<p class="au-lp-hero__lead">Transform your IT with end-to-end managed services. We handle monitoring, maintenance, security, and support, so you can focus on growth without disruptions.</p>
				<ul class="au-lp-hero__points">
											<li><svg class="au-icon " aria-hidden="true" focusable="false"><use href="#i-check"></use></svg><span>24/7 monitoring and help desk support</span></li>
											<li><svg class="au-icon " aria-hidden="true" focusable="false"><use href="#i-check"></use></svg><span>Network and server management</span></li>
											<li><svg class="au-icon " aria-hidden="true" focusable="false"><use href="#i-check"></use></svg><span>Data backup and disaster recovery</span></li>
											<li><svg class="au-icon " aria-hidden="true" focusable="false"><use href="#i-check"></use></svg><span>Co-managed IT for internal teams</span></li>
									</ul>
									<a class="au-lp-hero__call" href="tel:+14162516545">
						<svg class="au-icon " aria-hidden="true" focusable="false"><use href="#i-phone"></use></svg>						<span><span class="au-lp-hero__call-label">Prefer A Quick Call?</span> <strong>+1 416 251 6545</strong></span>
					</a>
																		<figure class="au-lp-hero__quote">
						<blockquote>&ldquo;Switching to ArcUnify’s managed IT services cut our downtime to nearly zero. Their team catches issues before we even notice them.&rdquo;</blockquote>
						<figcaption>
															<span class="au-lp-hero__stars" aria-label="Rated 4.9 out of 5"><svg class="au-icon au-quote__star" aria-hidden="true" focusable="false"><use href="#i-star"></use></svg><svg class="au-icon au-quote__star" aria-hidden="true" focusable="false"><use href="#i-star"></use></svg><svg class="au-icon au-quote__star" aria-hidden="true" focusable="false"><use href="#i-star"></use></svg><svg class="au-icon au-quote__star" aria-hidden="true" focusable="false"><use href="#i-star"></use></svg><svg class="au-icon au-quote__star" aria-hidden="true" focusable="false"><use href="#i-star"></use></svg></span>
														<span>Sarah Mitchell, Operations Manager</span>
						</figcaption>
					</figure>
							</div>

			<div class="au-lp-form" id="lp-form">
				<h2 class="au-lp-form__title">Get a Free Consultation</h2>
				<p class="au-lp-form__lead">Reach out for a free consultation and our team will respond within one business day.</p>
<?php arcunify_render_lp_form( 'managed-it' ); ?>
									<p class="au-lp-form__alt">Prefer A Quick Call? <a href="tel:+14162516545">+1 416 251 6545</a></p>
							</div>
		</div>
	</section>

	<section class="au-proof" data-theme="dark" aria-label="At a glance">
	<div class="au-container au-proof__inner">
							<div class="au-logos">
								<ul class="au-logos__list">
											<li><img width="47" height="51" src="https://arcunify.com/wp-content/uploads/2026/06/Vector-8.png" class="au-logos__img" alt="" loading="lazy" decoding="async" /></li>
											<li><img width="57" height="41" src="https://arcunify.com/wp-content/uploads/2026/06/Vector-7.png" class="au-logos__img" alt="" loading="lazy" decoding="async" /></li>
											<li><img width="78" height="34" src="https://arcunify.com/wp-content/uploads/2026/06/Vector-6.png" class="au-logos__img" alt="" loading="lazy" decoding="async" /></li>
											<li><img width="51" height="50" src="https://arcunify.com/wp-content/uploads/2026/06/Vector-5.png" class="au-logos__img" alt="" loading="lazy" decoding="async" /></li>
											<li><img width="53" height="53" src="https://arcunify.com/wp-content/uploads/2026/06/Vector-4.png" class="au-logos__img" alt="" loading="lazy" decoding="async" /></li>
											<li><img width="38" height="38" src="https://arcunify.com/wp-content/uploads/2026/06/Vector-3.png" class="au-logos__img" alt="" loading="lazy" decoding="async" /></li>
											<li><img width="70" height="32" src="https://arcunify.com/wp-content/uploads/2026/06/Vector-2.png" class="au-logos__img" alt="" loading="lazy" decoding="async" /></li>
											<li><img width="51" height="51" src="https://arcunify.com/wp-content/uploads/2026/06/Vector-1.png" class="au-logos__img" alt="" loading="lazy" decoding="async" /></li>
											<li><img width="59" height="58" src="https://arcunify.com/wp-content/uploads/2026/06/Vector.png" class="au-logos__img" alt="" loading="lazy" decoding="async" /></li>
									</ul>
			</div>
			</div>
</section>
<section class="au-section au-why au-why--paper" data-theme="paper" aria-labelledby="au-why-title">
	<div class="au-container">
		<div class="au-sh au-sh--split">
	<div class="au-sh__main">
					<p class="au-kicker">Why Choose ArcUnify</p>
				<h2 class="au-h2" id="au-why-title">Why Businesses Trust ArcUnify With Their IT</h2>
	</div>
			<p class="au-lead au-sh__lead">Our managed services are built to prevent problems, control costs, and scale with your growth.</p>
	</div>
		<ul class="au-ledger">
							<li class="au-ledger__row">
					<h3 class="au-ledger__title">24/7 Monitoring &amp; Support</h3>
											<p class="au-ledger__claim">24/7 help desk, every day of the year</p>
									</li>
							<li class="au-ledger__row">
					<h3 class="au-ledger__title">Proactive Incident Management</h3>
											<p class="au-ledger__claim">100% visibility into your IT health</p>
									</li>
							<li class="au-ledger__row">
					<h3 class="au-ledger__title">Cybersecurity-First Approach</h3>
											<p class="au-ledger__claim">24/7 threat detection and response</p>
									</li>
							<li class="au-ledger__row">
					<h3 class="au-ledger__title">Predictable Fixed Costs</h3>
											<p class="au-ledger__claim">0 hidden fees or surprise bills</p>
									</li>
							<li class="au-ledger__row">
					<h3 class="au-ledger__title">Scalable IT Solutions</h3>
											<p class="au-ledger__claim">1,000+ users supported with ease</p>
									</li>
							<li class="au-ledger__row">
					<h3 class="au-ledger__title">Co-Managed IT Support</h3>
											<p class="au-ledger__claim">100% flexible support for internal teams</p>
									</li>
							<li class="au-ledger__row">
					<h3 class="au-ledger__title">Backup &amp; Disaster Recovery</h3>
											<p class="au-ledger__claim">99.99% data protection reliability</p>
									</li>
							<li class="au-ledger__row">
					<h3 class="au-ledger__title">Strategic IT Consulting</h3>
											<p class="au-ledger__claim">1 trusted partner for all your IT</p>
									</li>
					</ul>
		<div class="au-section-actions au-section-actions--start"><a class="au-btn au-btn--primary " href="#lp-form"><span>Get a Free Consultation</span><svg class="au-icon au-btn__icon" aria-hidden="true" focusable="false"><use href="#i-arrow-right"></use></svg></a><a class="au-btn au-btn--ghost " href="tel:+14162516545"><span>+1 416 251 6545</span><svg class="au-icon au-btn__icon" aria-hidden="true" focusable="false"><use href="#i-phone"></use></svg></a></div>	</div>
</section>
<section class="au-section au-pricing" data-theme="light" id="pricing" aria-labelledby="au-pricing-title">
	<div class="au-container">
		<div class="au-sh au-sh--split">
	<div class="au-sh__main">
					<p class="au-kicker">Pricing Plans</p>
				<h2 class="au-h2" id="au-pricing-title">Flexible IT Plans For Every Business</h2>
	</div>
			<p class="au-lead au-sh__lead">Our service plans are designed to help businesses start, scale, and fully manage their IT with expert support and predictable monthly costs.</p>
	</div>
		<div class="au-plans">
											<article class="au-plan is-featured" aria-labelledby="au-plan-1">
					<div class="au-plan__head">
						<h3 class="au-plan__name" id="au-plan-1">Essential IT</h3>
													<span class="au-badge">Most Popular</span>
											</div>
					<p class="au-plan__price"><span class="au-plan__amount">$499</span> <span class="au-plan__period">/month</span></p>
					<p class="au-plan__blurb">Best for small businesses that need reliable IT support and security.</p>
					<a class="au-btn au-btn--primary au-btn--block" href="#lp-form"><span>Get Started</span><span class="screen-reader-text"> : Essential IT</span><svg class="au-icon au-btn__icon" aria-hidden="true" focusable="false"><use href="#i-arrow-right"></use></svg></a>																<p class="au-plan__included">What&#039;s included?</p>
						<ul class="au-checks">
															<li><svg class="au-icon " aria-hidden="true" focusable="false"><use href="#i-check"></use></svg><span>24/7 help desk support</span></li>
															<li><svg class="au-icon " aria-hidden="true" focusable="false"><use href="#i-check"></use></svg><span>Proactive monitoring and maintenance</span></li>
															<li><svg class="au-icon " aria-hidden="true" focusable="false"><use href="#i-check"></use></svg><span>Patch management and updates</span></li>
															<li><svg class="au-icon " aria-hidden="true" focusable="false"><use href="#i-check"></use></svg><span>Antivirus and endpoint protection</span></li>
													</ul>
									</article>
											<article class="au-plan" aria-labelledby="au-plan-2">
					<div class="au-plan__head">
						<h3 class="au-plan__name" id="au-plan-2">Business IT</h3>
											</div>
					<p class="au-plan__price"><span class="au-plan__amount">$999</span> <span class="au-plan__period">/month</span></p>
					<p class="au-plan__blurb">Perfect for growing companies that need complete IT management and security.</p>
					<a class="au-btn au-btn--ghost au-btn--block" href="#lp-form"><span>Get Started</span><span class="screen-reader-text"> : Business IT</span><svg class="au-icon au-btn__icon" aria-hidden="true" focusable="false"><use href="#i-arrow-right"></use></svg></a>																<p class="au-plan__included">What&#039;s included?</p>
						<ul class="au-checks">
															<li><svg class="au-icon " aria-hidden="true" focusable="false"><use href="#i-check"></use></svg><span>Everything in Essential IT</span></li>
															<li><svg class="au-icon " aria-hidden="true" focusable="false"><use href="#i-check"></use></svg><span>Advanced cybersecurity and MFA</span></li>
															<li><svg class="au-icon " aria-hidden="true" focusable="false"><use href="#i-check"></use></svg><span>Cloud backup and disaster recovery</span></li>
															<li><svg class="au-icon " aria-hidden="true" focusable="false"><use href="#i-check"></use></svg><span>Strategic IT consulting and planning</span></li>
													</ul>
									</article>
			
							<article class="au-plan au-plan--enterprise" data-theme="dark" aria-labelledby="au-plan-3">
					<svg class="au-icon au-plan__mark" aria-hidden="true" focusable="false"><use href="#i-building-2"></use></svg>					<h3 class="au-plan__name" id="au-plan-3">Enterprise</h3>
					<p class="au-plan__blurb">Custom IT, security, and cloud solutions for large organizations and complex operations.</p>
					<a class="au-btn au-btn--primary au-btn--block" href="#lp-form"><span>Contact Sales</span><svg class="au-icon au-btn__icon" aria-hidden="true" focusable="false"><use href="#i-arrow-right"></use></svg></a>				</article>
					</div>
	</div>
</section>
<section class="au-section au-process" data-theme="paper" aria-labelledby="au-process-title">
	<div class="au-container">
		<div class="au-sh au-sh--split">
	<div class="au-sh__main">
				<h2 class="au-h2" id="au-process-title">A Clear Process. Real Results.</h2>
	</div>
			<p class="au-lead au-sh__lead">At ArcUnify, we follow a structured framework to ensure every IT solution is practical, scalable, and measurable.</p>
	</div>
		<ol class="au-steps" data-reveal>
							<li class="au-step" style="--i:0">
					<span class="au-step__dot" aria-hidden="true"></span>
					<p class="au-step__label">Step 01</p>
					<h3 class="au-step__title">Consultation &amp; Assessment</h3>
					<p class="au-step__desc">We start by understanding your business goals, challenges, and current infrastructure to identify the right IT solutions.</p>
					<p class="au-step__list-title">What Happens Here:</p>
					<ul class="au-checks au-checks--sm">
													<li><svg class="au-icon " aria-hidden="true" focusable="false"><use href="#i-check"></use></svg><span>Business needs analysis</span></li>
													<li><svg class="au-icon " aria-hidden="true" focusable="false"><use href="#i-check"></use></svg><span>IT infrastructure assessment</span></li>
													<li><svg class="au-icon " aria-hidden="true" focusable="false"><use href="#i-check"></use></svg><span>Tailored proposal and roadmap</span></li>
											</ul>
				</li>
							<li class="au-step" style="--i:1">
					<span class="au-step__dot" aria-hidden="true"></span>
					<p class="au-step__label">Step 02</p>
					<h3 class="au-step__title">Solution Design</h3>
					<p class="au-step__desc">Our team designs a custom solution tailored to your workflows, security requirements, and budget.</p>
					<p class="au-step__list-title">What Happens Here:</p>
					<ul class="au-checks au-checks--sm">
													<li><svg class="au-icon " aria-hidden="true" focusable="false"><use href="#i-check"></use></svg><span>Architecture and network planning</span></li>
													<li><svg class="au-icon " aria-hidden="true" focusable="false"><use href="#i-check"></use></svg><span>Security and compliance strategy</span></li>
													<li><svg class="au-icon " aria-hidden="true" focusable="false"><use href="#i-check"></use></svg><span>Scalable solution design</span></li>
											</ul>
				</li>
							<li class="au-step" style="--i:2">
					<span class="au-step__dot" aria-hidden="true"></span>
					<p class="au-step__label">Step 03</p>
					<h3 class="au-step__title">Implementation</h3>
					<p class="au-step__desc">We deploy and configure your systems with minimal disruption to your daily operations.</p>
					<p class="au-step__list-title">What Happens Here:</p>
					<ul class="au-checks au-checks--sm">
													<li><svg class="au-icon " aria-hidden="true" focusable="false"><use href="#i-check"></use></svg><span>Seamless setup and migration</span></li>
													<li><svg class="au-icon " aria-hidden="true" focusable="false"><use href="#i-check"></use></svg><span>System and VoIP integration</span></li>
													<li><svg class="au-icon " aria-hidden="true" focusable="false"><use href="#i-check"></use></svg><span>Performance testing and validation</span></li>
											</ul>
				</li>
							<li class="au-step" style="--i:3">
					<span class="au-step__dot" aria-hidden="true"></span>
					<p class="au-step__label">Step 04</p>
					<h3 class="au-step__title">Support &amp; Growth</h3>
					<p class="au-step__desc">After launch, we monitor, maintain, and continuously optimize your systems for long-term success.</p>
					<p class="au-step__list-title">What Happens Here:</p>
					<ul class="au-checks au-checks--sm">
													<li><svg class="au-icon " aria-hidden="true" focusable="false"><use href="#i-check"></use></svg><span>24/7 monitoring and help desk</span></li>
													<li><svg class="au-icon " aria-hidden="true" focusable="false"><use href="#i-check"></use></svg><span>Proactive maintenance and updates</span></li>
													<li><svg class="au-icon " aria-hidden="true" focusable="false"><use href="#i-check"></use></svg><span>Continuous improvement and scaling</span></li>
											</ul>
				</li>
					</ol>
		<div class="au-section-actions au-section-actions--start"><a class="au-btn au-btn--primary " href="#lp-form"><span>Get started</span><svg class="au-icon au-btn__icon" aria-hidden="true" focusable="false"><use href="#i-arrow-right"></use></svg></a><a class="au-btn au-btn--ghost " href="tel:+14162516545"><span>+1 416 251 6545</span><svg class="au-icon au-btn__icon" aria-hidden="true" focusable="false"><use href="#i-phone"></use></svg></a></div>	</div>
</section>

	<section class="au-callout au-lp-band" data-theme="dark" aria-labelledby="au-lp-call-title">
		<div class="au-container au-callout__inner">
			<div>
				<h2 class="au-h2" id="au-lp-call-title">Prefer A Quick Call?</h2>
				<p class="au-lead">Schedule a free 30-minute consultation with our IT experts.</p>
			</div>
			<div class="au-section-actions au-section-actions--start"><a class="au-btn au-btn--primary " href="#lp-form"><span>Book A Consultation</span><svg class="au-icon au-btn__icon" aria-hidden="true" focusable="false"><use href="#i-arrow-right"></use></svg></a><a class="au-btn au-btn--ghost " href="tel:+14162516545"><span>+1 416 251 6545</span><svg class="au-icon au-btn__icon" aria-hidden="true" focusable="false"><use href="#i-phone"></use></svg></a></div>		</div>
	</section>

	<section class="au-section au-testimonials" data-theme="dark" aria-labelledby="au-testimonials-title">
	<div class="au-container">
		<div class="au-sh">
	<div class="au-sh__main">
					<p class="au-kicker">Testimonials</p>
				<h2 class="au-h2" id="au-testimonials-title">Trusted By Forward-Thinking Companies</h2>
	</div>
	</div>
		<div class="au-quotes" tabindex="0" aria-label="Testimonials, scroll horizontally">
							<figure class="au-quote">
			<p class="au-quote__rating"><svg class="au-icon au-quote__star" aria-hidden="true" focusable="false"><use href="#i-star"></use></svg>			Rated 4.9/5</p>
		<blockquote class="au-quote__text"><p>Switching to ArcUnify’s managed IT services cut our downtime to nearly zero. Their team catches issues before we even notice them.</p></blockquote>
	<figcaption class="au-quote__by">
		<span>
			<span class="au-quote__name">Sarah Mitchell</span>
							<span class="au-quote__meta">Operations Manager</span>
					</span>
	</figcaption>
</figure>
							<figure class="au-quote">
			<p class="au-quote__rating"><svg class="au-icon au-quote__star" aria-hidden="true" focusable="false"><use href="#i-star"></use></svg>			Rated 4.9/5</p>
		<blockquote class="au-quote__text"><p>The fixed monthly pricing finally made our IT budget predictable. No more surprise repair bills.</p></blockquote>
	<figcaption class="au-quote__by">
		<span>
			<span class="au-quote__name">David Chen</span>
							<span class="au-quote__meta">Finance Director</span>
					</span>
	</figcaption>
</figure>
							<figure class="au-quote">
			<p class="au-quote__rating"><svg class="au-icon au-quote__star" aria-hidden="true" focusable="false"><use href="#i-star"></use></svg>			Rated 4.9/5</p>
		<blockquote class="au-quote__text"><p>They work seamlessly alongside our internal IT team and fill every gap.</p></blockquote>
	<figcaption class="au-quote__by">
		<span>
			<span class="au-quote__name">Maria Lopez</span>
							<span class="au-quote__meta">IT Manager</span>
					</span>
	</figcaption>
</figure>
							<figure class="au-quote">
			<p class="au-quote__rating"><svg class="au-icon au-quote__star" aria-hidden="true" focusable="false"><use href="#i-star"></use></svg>			Rated 4.9/5</p>
		<blockquote class="au-quote__text"><p>Onboarding was smooth and the 24/7 help desk has been a game changer for our staff across two locations.</p></blockquote>
	<figcaption class="au-quote__by">
		<span>
			<span class="au-quote__name">James Carter</span>
							<span class="au-quote__meta">CEO</span>
					</span>
	</figcaption>
</figure>
					</div>
		<div class="au-section-actions au-section-actions--start"><a class="au-btn au-btn--primary " href="#lp-form"><span>Get a Free Consultation</span><svg class="au-icon au-btn__icon" aria-hidden="true" focusable="false"><use href="#i-arrow-right"></use></svg></a><a class="au-btn au-btn--ghost " href="tel:+14162516545"><span>+1 416 251 6545</span><svg class="au-icon au-btn__icon" aria-hidden="true" focusable="false"><use href="#i-phone"></use></svg></a></div>	</div>
</section>

			<section class="au-section au-faq" data-theme="light" aria-labelledby="au-faq-title">
			<div class="au-container au-faq__grid">
				<div>
					<p class="au-kicker">FAQS</p>
					<h2 class="au-h2" id="au-faq-title">Frequently Asked Questions</h2>
				</div>
				<div class="au-faq__list">
											<details class="au-faq__item" open>
							<summary><span>What types of businesses can benefit from managed IT services?</span><svg class="au-icon au-faq__chev" aria-hidden="true" focusable="false"><use href="#i-chevron-down"></use></svg></summary>
							<p>Businesses of every size and industry, including finance, healthcare, education, retail, and manufacturing. Our solutions scale from 10 to 1,000+ users.</p>
						</details>
											<details class="au-faq__item">
							<summary><span>Do we need an internal IT team to work with you?</span><svg class="au-icon au-faq__chev" aria-hidden="true" focusable="false"><use href="#i-chevron-down"></use></svg></summary>
							<p>No. We offer full IT outsourcing, or we can work alongside your internal team in a co-managed model to fill gaps like 24/7 monitoring or cybersecurity.</p>
						</details>
											<details class="au-faq__item">
							<summary><span>How quickly can we get started?</span><svg class="au-icon au-faq__chev" aria-hidden="true" focusable="false"><use href="#i-chevron-down"></use></svg></summary>
							<p>Getting started is easy: schedule a free consultation, receive a tailored assessment and proposal, then onboard with minimal disruption, often within a few weeks.</p>
						</details>
											<details class="au-faq__item">
							<summary><span>Can your solutions integrate with our existing systems?</span><svg class="au-icon au-faq__chev" aria-hidden="true" focusable="false"><use href="#i-chevron-down"></use></svg></summary>
							<p>Yes. Our solutions integrate with the tools you already use, including Microsoft 365, Google Workspace, CRM platforms, and other business applications.</p>
						</details>
											<details class="au-faq__item">
							<summary><span>How do you ensure data security and compliance?</span><svg class="au-icon au-faq__chev" aria-hidden="true" focusable="false"><use href="#i-chevron-down"></use></svg></summary>
							<p>We implement enterprise-grade security including firewalls, endpoint protection, multi-factor authentication, encryption, and regular audits, with compliance support for HIPAA, GDPR, and SOC 2.</p>
						</details>
											<details class="au-faq__item">
							<summary><span>Do you provide ongoing support after setup?</span><svg class="au-icon au-faq__chev" aria-hidden="true" focusable="false"><use href="#i-chevron-down"></use></svg></summary>
							<p>Yes. Our team provides 24/7/365 monitoring, proactive maintenance, and help desk support to keep your systems running smoothly as your business grows.</p>
						</details>
										<div class="au-section-actions au-section-actions--start"><a class="au-btn au-btn--primary " href="#lp-form"><span>Get a Free Consultation</span><svg class="au-icon au-btn__icon" aria-hidden="true" focusable="false"><use href="#i-arrow-right"></use></svg></a><a class="au-btn au-btn--ghost " href="tel:+14162516545"><span>+1 416 251 6545</span><svg class="au-icon au-btn__icon" aria-hidden="true" focusable="false"><use href="#i-phone"></use></svg></a></div>				</div>
			</div>
		</section>
	
	<section class="au-cta" data-theme="dark" aria-labelledby="au-cta-title">
		<div class="au-container au-cta__inner">
			<div class="au-cta__copy">
				<h2 class="au-h2 au-cta__title" id="au-cta-title">Ready To Transform Your IT Operations?</h2>
				<p class="au-lead">Let ArcUnify handle your technology so you can focus on growing your business without disruptions.</p>
				<div class="au-actions">
					<a class="au-btn au-btn--primary " href="#lp-form"><span>Get a Free Consultation</span><svg class="au-icon au-btn__icon" aria-hidden="true" focusable="false"><use href="#i-arrow-right"></use></svg></a>											<a class="au-btn au-btn--ghost " href="tel:+14162516545"><span>+1 416 251 6545</span><svg class="au-icon au-btn__icon" aria-hidden="true" focusable="false"><use href="#i-phone"></use></svg></a>									</div>
			</div>
		</div>
	</section>
</main>
<footer class="au-footer au-lp-footer" data-theme="dark">
	<div class="au-container au-footer__bottom">
		<p>&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> arcunify. 350 Rutherford Rd S, Brampton, ON L6W 3M2</p>
		<ul class="au-footer__legal">
						<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Main website</a></li>
		</ul>
	</div>
</footer>
<div class="au-mobile-cta" data-au-mobile-cta>
	<a class="au-btn au-btn--primary au-mobile-cta__btn" href="#lp-form"><span>Get a Free Consultation</span><svg class="au-icon au-btn__icon" aria-hidden="true" focusable="false"><use href="#i-arrow-right"></use></svg></a>			<a class="au-mobile-cta__call" href="tel:+14162516545"><span class="screen-reader-text">Call +1 416 251 6545</span><svg class="au-icon " aria-hidden="true" focusable="false"><use href="#i-phone"></use></svg></a>
	</div>
<?php wp_footer(); ?>
</body>
</html>
