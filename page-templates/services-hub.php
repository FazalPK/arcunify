<?php
/**
 * Template Name: ArcUnify: Services overview
 *
 * @package ArcUnify
 */

$c = arcunify_page_content()['services'];
get_header();
?>
<main id="content" class="au-main au-services-page">
	<?php
	get_template_part(
		'template-parts/components/page-hero',
		null,
		array(
			'kicker'  => $c['kicker'],
			'title'   => $c['h1'],
			'actions' => array(
				array( arcunify_mod( 'hero_cta1_label' ), arcunify_mod( 'hero_cta1_url' ) ),
			),
			'variant' => 'hub',
		)
	);
	get_template_part( 'template-parts/sections/home-services' );
	get_template_part( 'template-parts/sections/home-outcomes' );
	get_template_part( 'template-parts/sections/home-why' );
	get_template_part( 'template-parts/sections/home-process' );
	get_template_part( 'template-parts/sections/home-testimonials' );
	get_template_part( 'template-parts/sections/cta' );
	?>
</main>
<?php
get_footer();
