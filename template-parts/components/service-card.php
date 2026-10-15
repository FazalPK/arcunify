<?php
/**
 * Service card. Args: service (array), link_label, show_desc (bool).
 *
 * @package ArcUnify
 */

$service = $args['service'];
$groups  = arcunify_service_groups();
$label   = isset( $args['link_label'] ) ? $args['link_label'] : __( 'Explore Our Solutions', 'arcunify' );
?>
<article class="au-service">
	<div class="au-service__top">
		<span class="au-service__icon"><?php echo arcunify_icon( $service['icon'] ); // phpcs:ignore ?></span>
		<span class="au-service__group"><?php echo esc_html( $groups[ $service['group'] ] ?? '' ); ?></span>
	</div>
	<h3 class="au-service__title"><?php echo esc_html( $service['name'] ); ?></h3>
	<?php if ( ! empty( $args['show_desc'] ) ) : ?>
		<p class="au-service__desc"><?php echo esc_html( $service['desc'] ); ?></p>
	<?php endif; ?>
	<?php if ( ! empty( $service['bullets'] ) ) : ?>
		<ul class="au-checks">
			<?php foreach ( $service['bullets'] as $bullet ) : ?>
				<li><?php echo arcunify_icon( 'check' ); // phpcs:ignore ?><span><?php echo esc_html( $bullet ); ?></span></li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
	<a class="au-service__link au-stretched" href="<?php echo esc_url( arcunify_service_url( $service ) ); ?>">
		<span><?php echo esc_html( $label ); ?></span><span class="screen-reader-text">: <?php echo esc_html( $service['name'] ); ?></span><?php echo arcunify_icon( 'arrow-right' ); // phpcs:ignore ?>
	</a>
</article>
