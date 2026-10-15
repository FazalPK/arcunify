<?php
/**
 * Positioning / About (existing copy).
 *
 * @package ArcUnify
 */

$c = ! empty( $args['content'] ) ? $args['content'] : arcunify_home_content()['about'];
?>
<section class="au-section au-about" data-theme="light" aria-labelledby="au-about-title">
	<div class="au-container">
		<div class="au-about__grid">
			<div class="au-about__head">
				<p class="au-kicker"><?php echo esc_html( $c['kicker'] ); ?></p>
				<h2 class="au-h2 au-about__title" id="au-about-title"><?php echo esc_html( $c['title'] ); ?></h2>
			</div>
			<div class="au-about__body">
				<p class="au-lead au-about__intro"><?php echo esc_html( $c['intro'] ); ?></p>
				<h3 class="au-h3"><?php echo esc_html( $c['sub_title'] ); ?></h3>
				<p><?php echo esc_html( $c['body'] ); ?></p>
			</div>
		</div>
		<div class="au-about__notes">
			<div class="au-about__note">
				<?php echo arcunify_icon( 'activity', 'au-about__icon' ); // phpcs:ignore ?>
				<h3 class="au-h3"><?php echo esc_html( $c['note_title'] ); ?></h3>
			</div>
			<div class="au-about__note">
				<?php echo arcunify_icon( 'chart-line', 'au-about__icon' ); // phpcs:ignore ?>
				<div>
					<h3 class="au-h3"><?php echo esc_html( $c['results_title'] ); ?></h3>
					<p><?php echo esc_html( $c['results_body'] ); ?></p>
				</div>
			</div>
		</div>
	</div>
</section>
