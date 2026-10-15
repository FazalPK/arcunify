<?php
/**
 * Testimonials: verified entries only. Section is omitted when none exist.
 *
 * @package ArcUnify
 */

$service_key = isset( $args['service'] ) ? $args['service'] : '';
$items       = arcunify_get_testimonials( $service_key, 6 );
if ( ! $items ) {
	return;
}
$c = arcunify_home_content()['testimonials'];
?>
<section class="au-section au-testimonials" data-theme="dark" aria-labelledby="au-testimonials-title">
	<div class="au-container">
		<?php
		arcunify_section_header(
			array(
				'kicker' => $c['kicker'],
				'title'  => $c['title'],
				'id'     => 'au-testimonials-title',
			)
		);
		?>
		<div class="au-quotes" tabindex="0" aria-label="<?php esc_attr_e( 'Testimonials, scroll horizontally', 'arcunify' ); ?>">
			<?php foreach ( $items as $item ) : ?>
				<?php get_template_part( 'template-parts/components/testimonial', null, array( 'post' => $item ) ); ?>
			<?php endforeach; ?>
		</div>
	</div>
</section>
