<?php
/**
 * Testimonial. Args: post (WP_Post).
 *
 * @package ArcUnify
 */

$post_obj = $args['post'];
$role     = get_post_meta( $post_obj->ID, '_au_role', true );
$company  = get_post_meta( $post_obj->ID, '_au_company', true );
$meta     = implode( ', ', array_filter( array( $role, $company ) ) );
$rating   = get_post_meta( $post_obj->ID, '_au_rating', true );
?>
<figure class="au-quote">
	<?php if ( $rating ) : ?>
		<p class="au-quote__rating"><?php echo arcunify_icon( 'star', 'au-quote__star' ); // phpcs:ignore ?>
			<?php /* translators: %s: rating. */ echo esc_html( sprintf( __( 'Rated %s/5', 'arcunify' ), $rating ) ); ?></p>
	<?php endif; ?>
	<blockquote class="au-quote__text"><?php echo wp_kses_post( wpautop( $post_obj->post_content ) ); ?></blockquote>
	<figcaption class="au-quote__by">
		<?php if ( has_post_thumbnail( $post_obj ) ) : ?>
			<?php echo get_the_post_thumbnail( $post_obj, 'thumbnail', array( 'class' => 'au-quote__avatar', 'alt' => '' ) ); ?>
		<?php endif; ?>
		<span>
			<span class="au-quote__name"><?php echo esc_html( get_the_title( $post_obj ) ); ?></span>
			<?php if ( $meta ) : ?>
				<span class="au-quote__meta"><?php echo esc_html( $meta ); ?></span>
			<?php endif; ?>
		</span>
	</figcaption>
</figure>
