<?php
/**
 * Pricing (existing plans, editable in Customize → ArcUnify → Pricing plans).
 *
 * @package ArcUnify
 */

if ( ! arcunify_mod( 'show_pricing' ) ) {
	return;
}

$c         = arcunify_home_content()['pricing'];
$cta_label = arcunify_mod( 'plan_cta_label' );
$cta_url   = arcunify_mod( 'plan_cta_url' );
?>
<section class="au-section au-pricing" data-theme="light" id="pricing" aria-labelledby="au-pricing-title">
	<div class="au-container">
		<?php
		arcunify_section_header(
			array(
				'kicker' => $c['kicker'],
				'title'  => $c['title'],
				'lead'   => $c['lead'],
				'id'     => 'au-pricing-title',
				'layout' => 'split',
			)
		);
		?>
		<div class="au-plans">
			<?php for ( $n = 1; $n <= 2; $n++ ) : ?>
				<?php
				$name = arcunify_mod( "plan{$n}_name" );
				if ( ! $name ) {
					continue;
				}
				$popular = (bool) arcunify_mod( "plan{$n}_popular" );
				$heading = 'au-plan-' . $n;
				?>
				<article class="au-plan<?php echo $popular ? ' is-featured' : ''; ?>" aria-labelledby="<?php echo esc_attr( $heading ); ?>">
					<div class="au-plan__head">
						<h3 class="au-plan__name" id="<?php echo esc_attr( $heading ); ?>"><?php echo esc_html( $name ); ?></h3>
						<?php if ( $popular ) : ?>
							<span class="au-badge"><?php echo esc_html( $c['popular_label'] ); ?></span>
						<?php endif; ?>
					</div>
					<p class="au-plan__price"><span class="au-plan__amount"><?php echo esc_html( arcunify_mod( "plan{$n}_price" ) ); ?></span> <span class="au-plan__period"><?php echo esc_html( arcunify_mod( "plan{$n}_period" ) ); ?></span></p>
					<p class="au-plan__blurb"><?php echo esc_html( arcunify_mod( "plan{$n}_blurb" ) ); ?></p>
					<?php echo arcunify_button( $cta_label, $cta_url, $popular ? 'primary' : 'ghost', array( 'class' => 'au-btn--block', 'sr' => ': ' . $name ) ); // phpcs:ignore ?>
					<?php $features = arcunify_lines( arcunify_mod( "plan{$n}_features" ) ); ?>
					<?php if ( $features ) : ?>
						<p class="au-plan__included"><?php echo esc_html( $c['included'] ); ?></p>
						<ul class="au-checks">
							<?php foreach ( $features as $feature ) : ?>
								<li><?php echo arcunify_icon( 'check' ); // phpcs:ignore ?><span><?php echo esc_html( $feature ); ?></span></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</article>
			<?php endfor; ?>

			<?php if ( arcunify_mod( 'plan3_name' ) ) : ?>
				<article class="au-plan au-plan--enterprise" data-theme="dark" aria-labelledby="au-plan-3">
					<?php echo arcunify_icon( 'building-2', 'au-plan__mark' ); // phpcs:ignore ?>
					<h3 class="au-plan__name" id="au-plan-3"><?php echo esc_html( arcunify_mod( 'plan3_name' ) ); ?></h3>
					<p class="au-plan__blurb"><?php echo esc_html( arcunify_mod( 'plan3_blurb' ) ); ?></p>
					<?php echo arcunify_button( arcunify_mod( 'plan3_cta_label' ), $cta_url, 'primary', array( 'class' => 'au-btn--block' ) ); // phpcs:ignore ?>
				</article>
			<?php endif; ?>
		</div>
	</div>
</section>
