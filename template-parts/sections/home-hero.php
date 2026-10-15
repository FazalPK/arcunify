<?php
/**
 * Homepage hero. The arc visual links the five services to one core:
 * the "ArcUnify" idea of one operating layer across the business.
 *
 * Node positions sit on a 240-unit arc centred at (300, 400) in a 600×460 box,
 * at 165°, 127.5°, 90°, 52.5° and 15°. Pills are HTML links placed by percentage.
 *
 * @package ArcUnify
 */

$services = array_values( arcunify_services() );
$nodes    = array(
	array( 68.2, 337.9 ),
	array( 153.9, 209.6 ),
	array( 300, 160 ),
	array( 446.1, 209.6 ),
	array( 531.8, 337.9 ),
);
?>
<section class="au-hero" data-theme="dark" aria-labelledby="au-hero-title">
	<div class="au-container au-hero__grid">
		<div class="au-hero__copy">
			<?php if ( arcunify_mod( 'hero_kicker' ) ) : ?>
				<p class="au-kicker au-hero__kicker"><?php echo esc_html( arcunify_mod( 'hero_kicker' ) ); ?></p>
			<?php endif; ?>
			<h1 class="au-hero__title" id="au-hero-title"><?php echo arcunify_keep_together( arcunify_mod( 'hero_title' ) ); // phpcs:ignore -- escaped inside. ?></h1>
			<?php if ( arcunify_mod( 'hero_lead' ) ) : ?>
				<p class="au-hero__lead"><?php echo esc_html( arcunify_mod( 'hero_lead' ) ); ?></p>
			<?php endif; ?>
			<div class="au-actions">
				<?php echo arcunify_button( arcunify_mod( 'hero_cta1_label' ), arcunify_mod( 'hero_cta1_url' ), 'primary' ); // phpcs:ignore ?>
				<?php echo arcunify_button( arcunify_mod( 'hero_cta2_label' ), arcunify_mod( 'hero_cta2_url' ), 'ghost', array( 'icon' => '' ) ); // phpcs:ignore ?>
			</div>
		</div>

		<nav class="au-arc" aria-label="<?php esc_attr_e( 'Our services', 'arcunify' ); ?>">
			<svg class="au-arc__lines" viewBox="0 0 600 460" aria-hidden="true" focusable="false">
				<defs>
					<linearGradient id="au-arc-stroke" x1="0" y1="0" x2="1" y2="0">
						<stop offset="0" stop-color="#1F63E0" stop-opacity=".35"/>
						<stop offset=".5" stop-color="#3FD0FF"/>
						<stop offset="1" stop-color="#1F63E0" stop-opacity=".35"/>
					</linearGradient>
					<linearGradient id="au-arc-horizon" x1="0" y1="0" x2="1" y2="0">
						<stop offset="0" stop-color="#3FD0FF" stop-opacity="0"/>
						<stop offset=".5" stop-color="#3FD0FF" stop-opacity=".45"/>
						<stop offset="1" stop-color="#3FD0FF" stop-opacity="0"/>
					</linearGradient>
					<radialGradient id="au-arc-glow" cx=".5" cy=".5" r=".5">
						<stop offset="0" stop-color="#1F63E0" stop-opacity=".32"/>
						<stop offset="1" stop-color="#1F63E0" stop-opacity="0"/>
					</radialGradient>
				</defs>
				<circle cx="300" cy="400" r="190" fill="url(#au-arc-glow)"/>
				<path class="au-arc__guide" d="M0 400 A300 300 0 0 1 600 400"/>
				<path class="au-arc__guide" d="M130 400 A170 170 0 0 1 470 400"/>
				<?php foreach ( $nodes as $i => $n ) : ?>
					<line class="au-arc__spoke" style="--i:<?php echo (int) $i; ?>" x1="300" y1="400" x2="<?php echo esc_attr( $n[0] ); ?>" y2="<?php echo esc_attr( $n[1] ); ?>" pathLength="1"/>
				<?php endforeach; ?>
				<path id="au-arc-main" class="au-arc__main" d="M60 400 A240 240 0 0 1 540 400" pathLength="1"/>
				<line x1="0" y1="400" x2="600" y2="400" stroke="url(#au-arc-horizon)" stroke-width="1"/>
				<circle class="au-arc__ring" cx="300" cy="400" r="44"/>
				<circle class="au-arc__ring" cx="300" cy="400" r="24"/>
				<circle class="au-arc__core" cx="300" cy="400" r="7"/>
				<circle class="au-arc__pulse" r="3.5">
					<animateMotion dur="7s" begin="1.6s" repeatCount="indefinite" rotate="auto">
						<mpath href="#au-arc-main"/>
					</animateMotion>
				</circle>
			</svg>
			<ul class="au-arc__nodes">
				<?php foreach ( $services as $i => $service ) : ?>
					<?php
					if ( ! isset( $nodes[ $i ] ) ) {
						break;
					}
					$left = round( $nodes[ $i ][0] / 600 * 100, 3 );
					$top  = round( $nodes[ $i ][1] / 460 * 100, 3 );
					?>
					<li class="au-arc__node" style="--x:<?php echo esc_attr( $left ); ?>%;--y:<?php echo esc_attr( $top ); ?>%;--i:<?php echo (int) $i; ?>">
						<a href="<?php echo esc_url( arcunify_service_url( $service ) ); ?>">
							<?php echo arcunify_icon( $service['icon'] ); // phpcs:ignore ?>
							<span class="au-arc__short" aria-hidden="true"><?php echo esc_html( $service['short'] ); ?></span>
							<span class="screen-reader-text"><?php echo esc_html( $service['name'] ); ?></span>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</nav>
	</div>
</section>
