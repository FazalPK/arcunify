<?php
/**
 * Breadcrumb: Home / Parent / Current.
 *
 * @package ArcUnify
 */

if ( is_front_page() ) {
	return;
}
$crumbs = array( array( __( 'Home', 'arcunify' ), home_url( '/' ) ) );
foreach ( array_reverse( get_post_ancestors( get_the_ID() ) ) as $ancestor ) {
	$crumbs[] = array( get_the_title( $ancestor ), get_permalink( $ancestor ) );
}
?>
<nav class="au-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'arcunify' ); ?>">
	<ol>
		<?php foreach ( $crumbs as $crumb ) : ?>
			<li><a href="<?php echo esc_url( $crumb[1] ); ?>"><?php echo esc_html( $crumb[0] ); ?></a></li>
		<?php endforeach; ?>
		<li><span aria-current="page"><?php echo esc_html( get_the_title() ); ?></span></li>
	</ol>
</nav>
