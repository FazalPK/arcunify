<?php
/**
 * Homepage.
 *
 * Renders the native theme homepage. Set Customize → ArcUnify → Homepage →
 * "Existing Home page content" to fall back to the Home page (Elementor) instead.
 *
 * @package ArcUnify
 */

if ( ! arcunify_is_native_home() ) {
	get_template_part( 'page' );
	return;
}

get_header();
?>
<main id="content" class="au-main au-home">
	<?php
	get_template_part( 'template-parts/sections/home-hero' );
	get_template_part( 'template-parts/sections/home-proof' );
	get_template_part( 'template-parts/sections/home-about' );
	get_template_part( 'template-parts/sections/home-services' );
	get_template_part( 'template-parts/sections/home-outcomes' );
	get_template_part( 'template-parts/sections/home-why' );
	get_template_part( 'template-parts/sections/home-process' );
	get_template_part( 'template-parts/sections/home-pricing' );
	get_template_part( 'template-parts/sections/home-testimonials' );
	get_template_part( 'template-parts/sections/cta' );
	?>
</main>
<?php
get_footer();
