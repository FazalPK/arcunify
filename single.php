<?php
/**
 * Single post.
 *
 * @package ArcUnify
 */

get_header();

while ( have_posts() ) :
	the_post();
	if ( arcunify_is_elementor_page() ) :
		?>
		<main id="content" class="au-main au-elementor"><?php the_content(); ?></main>
		<?php
	else :
		?>
		<main id="content" class="au-main">
			<header class="au-page-hero" data-theme="dark">
				<div class="au-container">
					<p class="au-kicker"><?php echo esc_html( get_the_date() ); ?></p>
					<h1 class="au-page-hero__title"><?php the_title(); ?></h1>
				</div>
			</header>
			<div class="au-section" data-theme="light">
				<article <?php post_class( 'au-container au-prose' ); ?>>
					<?php the_content(); ?>
				</article>
			</div>
		</main>
		<?php
	endif;
endwhile;

get_footer();
