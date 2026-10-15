<?php
/**
 * Default page.
 *
 * Elementor-built pages render their content full width between the theme
 * header and footer (migration path). Other pages get the native layout.
 *
 * @package ArcUnify
 */

get_header();

while ( have_posts() ) :
	the_post();

	if ( arcunify_is_elementor_page() ) :
		?>
		<main id="content" class="au-main au-elementor">
			<?php the_content(); ?>
		</main>
		<?php
	else :
		?>
		<main id="content" class="au-main">
			<header class="au-page-hero" data-theme="dark">
				<div class="au-container">
					<?php get_template_part( 'template-parts/components/breadcrumb' ); ?>
					<h1 class="au-page-hero__title"><?php the_title(); ?></h1>
				</div>
			</header>
			<div class="au-section" data-theme="light">
				<div class="au-container au-prose">
					<?php
					the_content();
					wp_link_pages();
					?>
				</div>
			</div>
		</main>
		<?php
	endif;
endwhile;

get_footer();
