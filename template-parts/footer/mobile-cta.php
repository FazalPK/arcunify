<?php
/**
 * Mobile sticky consultation bar (shown after the first screen on small viewports).
 *
 * @package ArcUnify
 */

$phone = arcunify_mod( 'phone' );
$label = arcunify_mod( 'cta_label' );
if ( ! $label ) {
	return;
}
?>
<div class="au-mobile-cta" data-au-mobile-cta>
	<?php echo arcunify_button( $label, arcunify_mod( 'cta_url' ), 'primary', array( 'class' => 'au-mobile-cta__btn' ) ); // phpcs:ignore ?>
	<?php if ( $phone ) : ?>
		<a class="au-mobile-cta__call" href="<?php echo esc_attr( arcunify_tel( $phone ) ); ?>"><span class="screen-reader-text"><?php echo esc_html( sprintf( /* translators: %s phone */ __( 'Call %s', 'arcunify' ), $phone ) ); ?></span><?php echo arcunify_icon( 'phone' ); // phpcs:ignore ?></a>
	<?php endif; ?>
</div>
