<?php
/**
 * Process: existing 4 steps from the Contact page.
 *
 * @package ArcUnify
 */

$c = arcunify_home_content()['process'];
?>
<section class="au-section au-process" data-theme="paper" aria-labelledby="au-process-title">
	<div class="au-container">
		<?php
		arcunify_section_header(
			array(
				'title'  => $c['title'],
				'lead'   => $c['lead'],
				'id'     => 'au-process-title',
				'layout' => 'split',
			)
		);
		?>
		<ol class="au-steps" data-reveal>
			<?php foreach ( $c['steps'] as $i => $step ) : ?>
				<li class="au-step" style="--i:<?php echo (int) $i; ?>">
					<span class="au-step__dot" aria-hidden="true"></span>
					<p class="au-step__label"><?php echo esc_html( $step['label'] ); ?></p>
					<h3 class="au-step__title"><?php echo esc_html( $step['title'] ); ?></h3>
					<p class="au-step__desc"><?php echo esc_html( $step['desc'] ); ?></p>
					<p class="au-step__list-title"><?php echo esc_html( $c['list_title'] ); ?></p>
					<ul class="au-checks au-checks--sm">
						<?php foreach ( $step['items'] as $li ) : ?>
							<li><?php echo arcunify_icon( 'check' ); // phpcs:ignore ?><span><?php echo esc_html( $li ); ?></span></li>
						<?php endforeach; ?>
					</ul>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>
