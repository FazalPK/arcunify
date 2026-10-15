<?php
/**
 * Fallback template (blog index, archives, search).
 *
 * @package ArcUnify
 */

get_header();
?>
<main id="content" class="au-main">
	<header class="au-page-hero" data-theme="dark">
		<div class="au-container">
			<h1 class="au-page-hero__title">
				<?php
				if ( is_search() ) {
					/* translators: %s: search query. */
					printf( esc_html__( 'Search results for "%s"', 'arcunify' ), esc_html( get_search_query() ) );
				} elseif ( is_archive() ) {
					echo esc_html( wp_strip_all_tags( get_the_archive_title() ) );
				} else {
					echo esc_html( get_the_title( get_option( 'page_for_posts' ) ) ? get_the_title( get_option( 'page_for_posts' ) ) : __( 'Latest posts', 'arcunify' ) );
				}
				?>
			</h1>
		</div>
	</header>
	<div class="au-section" data-theme="light">
		<div class="au-container">
			<?php if ( have_posts() ) : ?>
				<div class="au-posts">
					<?php
					while ( have_posts() ) :
						the_post();
						?>
						<article <?php post_class( 'au-post-card' ); ?>>
							<h2 class="au-h3"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<p class="au-post-card__meta"><?php echo esc_html( get_the_date() ); ?></p>
							<?php the_excerpt(); ?>
						</article>
					<?php endwhile; ?>
				</div>
				<?php the_posts_pagination(); ?>
			<?php else : ?>
				<p><?php esc_html_e( 'Nothing found.', 'arcunify' ); ?></p>
			<?php endif; ?>
		</div>
	</div>
</main>
<?php
get_footer();
