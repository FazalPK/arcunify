<?php
/**
 * Closing call to action (shared). Args: title, lead (optional overrides).
 *
 * @package ArcUnify
 */

$c     = arcunify_home_content()['cta'];
$title = ! empty( $args['title'] ) ? $args['title'] : $c['title'];
$lead  = ! empty( $args['lead'] ) ? $args['lead'] : $c['lead'];
?>
<section class="au-cta" data-theme="dark" aria-labelledby="au-cta-title">
	<div class="au-container au-cta__inner">
		<div class="au-cta__copy">
			<h2 class="au-h2 au-cta__title" id="au-cta-title"><?php echo esc_html( $title ); ?></h2>
			<p class="au-lead"><?php echo esc_html( $lead ); ?></p>
			<div class="au-actions">
				<?php echo arcunify_button( arcunify_mod( 'hero_cta1_label' ), arcunify_mod( 'hero_cta1_url' ), 'primary' ); // phpcs:ignore ?>
				<?php echo arcunify_button( arcunify_mod( 'hero_cta2_label' ), arcunify_mod( 'hero_cta2_url' ), 'ghost', array( 'icon' => '' ) ); // phpcs:ignore ?>
			</div>
		</div>
		<svg class="au-cta__arc" viewBox="0 0 600 300" aria-hidden="true" focusable="false">
			<path d="M60 300 A240 240 0 0 1 540 300" fill="none" stroke="url(#au-cta-stroke)" stroke-width="1.5"/>
			<path d="M0 300 A300 300 0 0 1 600 300" fill="none" stroke="currentColor" stroke-opacity=".12" stroke-dasharray="2 6"/>
			<defs>
				<linearGradient id="au-cta-stroke" x1="0" x2="1">
					<stop offset="0" stop-color="#1F63E0" stop-opacity=".2"/>
					<stop offset=".5" stop-color="#3FD0FF"/>
					<stop offset="1" stop-color="#1F63E0" stop-opacity=".2"/>
				</linearGradient>
			</defs>
			<g fill="#05060A" stroke="#3FD0FF" stroke-width="1.5">
				<circle cx="68.2" cy="237.9" r="5"/><circle cx="153.9" cy="109.6" r="5"/><circle cx="300" cy="60" r="5"/><circle cx="446.1" cy="109.6" r="5"/><circle cx="531.8" cy="237.9" r="5"/>
			</g>
		</svg>
	</div>
</section>
