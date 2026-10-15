<?php
/**
 * Outcomes per service (existing "Result" blocks) as accessible tabs.
 * Without JS every panel is shown in sequence.
 *
 * @package ArcUnify
 */

$c        = arcunify_home_content()['outcomes'];
$services = arcunify_services();
$first    = true;
?>
<section class="au-section au-outcomes" data-theme="dark" aria-labelledby="au-outcomes-title">
	<div class="au-container">
		<?php
		arcunify_section_header(
			array(
				'kicker' => $c['kicker'],
				'title'  => $c['title'],
				'id'     => 'au-outcomes-title',
			)
		);
		?>
		<div class="au-tabs" data-au-tabs>
			<div class="au-tabs__list" role="tablist" aria-label="<?php esc_attr_e( 'Services', 'arcunify' ); ?>">
				<?php foreach ( $services as $slug => $service ) : ?>
					<button class="au-tabs__tab" type="button" role="tab" id="au-tab-<?php echo esc_attr( $slug ); ?>" aria-controls="au-panel-<?php echo esc_attr( $slug ); ?>" aria-selected="<?php echo $first ? 'true' : 'false'; ?>" tabindex="<?php echo $first ? '0' : '-1'; ?>">
						<?php echo arcunify_icon( $service['icon'] ); // phpcs:ignore ?>
						<span><?php echo esc_html( $service['name'] ); ?></span>
					</button>
					<?php $first = false; ?>
				<?php endforeach; ?>
			</div>

			<div class="au-tabs__panels">
				<?php foreach ( $services as $slug => $service ) : ?>
					<?php $stat = trim( (string) arcunify_mod( 'stat_' . $slug ) ); ?>
					<div class="au-tabs__panel" role="tabpanel" id="au-panel-<?php echo esc_attr( $slug ); ?>" aria-labelledby="au-tab-<?php echo esc_attr( $slug ); ?>" tabindex="0">
						<div class="au-outcome">
							<div class="au-outcome__main">
								<p class="au-kicker"><?php echo esc_html( $c['label'] ); ?></p>
								<h3 class="au-outcome__title"><?php echo esc_html( $service['result_title'] ); ?></h3>
								<p class="au-outcome__line"><?php echo esc_html( $service['result_line'] ); ?></p>
							</div>
							<div class="au-outcome__side">
								<?php if ( '' !== $stat ) : ?>
									<p class="au-outcome__stat"><span class="au-outcome__num"><?php echo esc_html( $stat . $service['stat_suffix'] ); ?></span><span class="au-outcome__statlabel"><?php echo esc_html( $service['stat_label'] ); ?></span></p>
								<?php endif; ?>
								<h4 class="au-outcome__name"><?php echo esc_html( $service['name'] ); ?></h4>
								<p class="au-outcome__desc"><?php echo esc_html( $service['desc'] ); ?></p>
								<?php echo arcunify_button( $c['link'], arcunify_service_url( $service ), 'primary', array( 'sr' => ': ' . $service['name'] ) ); // phpcs:ignore ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
