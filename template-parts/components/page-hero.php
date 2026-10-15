<?php
/**
 * Inner page hero. Args: kicker, title (H1), lead, actions (bool), visual (variant), variant.
 *
 * @package ArcUnify
 */

$args = wp_parse_args(
	$args,
	array(
		'kicker'  => '',
		'title'   => get_the_title(),
		'lead'    => '',
		'actions' => array(),
		'visual'  => '',
		'variant' => '',
	)
);
$has_visual = $args['visual'] && locate_template( 'template-parts/visuals/' . $args['visual'] . '.php' );
?>
<section class="au-phero<?php echo $has_visual ? ' au-phero--visual' : ''; ?><?php echo $args['variant'] ? ' au-phero--' . esc_attr( $args['variant'] ) : ''; ?>" data-theme="dark" aria-labelledby="au-page-title">
	<div class="au-container au-phero__grid">
		<div class="au-phero__copy">
			<?php get_template_part( 'template-parts/components/breadcrumb' ); ?>
			<?php if ( $args['kicker'] ) : ?>
				<p class="au-kicker"><?php echo esc_html( $args['kicker'] ); ?></p>
			<?php endif; ?>
			<h1 class="au-phero__title<?php echo mb_strlen( $args['title'] ) > 48 ? ' au-phero__title--long' : ''; ?>" id="au-page-title"><?php echo arcunify_keep_together( $args['title'] ); // phpcs:ignore -- escaped inside. ?></h1>
			<?php if ( $args['lead'] ) : ?>
				<p class="au-phero__lead"><?php echo esc_html( $args['lead'] ); ?></p>
			<?php endif; ?>
			<?php if ( $args['actions'] ) : ?>
				<div class="au-actions">
					<?php
					foreach ( $args['actions'] as $i => $action ) {
						echo arcunify_button( $action[0], $action[1], 0 === $i ? 'primary' : 'ghost', array( 'icon' => 0 === $i ? 'arrow-right' : ( $action[2] ?? '' ) ) ); // phpcs:ignore
					}
					?>
				</div>
			<?php endif; ?>
		</div>
		<?php if ( $has_visual ) : ?>
			<div class="au-phero__visual">
				<?php get_template_part( 'template-parts/visuals/' . $args['visual'] ); ?>
			</div>
		<?php endif; ?>
	</div>
</section>
