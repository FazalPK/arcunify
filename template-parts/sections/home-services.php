<?php
/**
 * Services grid (existing "What We Serve" header + "Our Solutions" bullets).
 *
 * @package ArcUnify
 */

$c       = arcunify_home_content()['services'];
$exclude = isset( $args['exclude'] ) ? $args['exclude'] : '';
if ( ! empty( $args['content'] ) ) {
	$c = array_merge( $c, $args['content'] );
}
?>
<section class="au-section au-services" data-theme="paper" id="services" aria-labelledby="au-services-title">
	<div class="au-container">
		<?php
		arcunify_section_header(
			array(
				'kicker' => $c['kicker'],
				'title'  => $c['title'],
				'lead'   => $c['lead'],
				'id'     => 'au-services-title',
				'layout' => 'split',
			)
		);
		?>
		<div class="au-services__grid<?php echo $exclude ? ' au-services__grid--four' : ''; ?>">
			<?php foreach ( arcunify_services() as $key => $service ) : ?>
				<?php
				if ( $key === $exclude ) {
					continue;
				}
				?>
				<?php get_template_part( 'template-parts/components/service-card', null, array( 'service' => $service, 'link_label' => $c['link'] ) ); ?>
			<?php endforeach; ?>
		</div>
	</div>
</section>
