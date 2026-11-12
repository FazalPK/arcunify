<?php
/**
 * Proof strip: counters. Renders only verified, owner-entered values.
 *
 * @package ArcUnify
 */

$counters = array();
if ( arcunify_mod( 'show_counters' ) ) {
	$defs = array(
		array( 'counter1_value', __( 'Tech Experts', 'arcunify' ), '+' ),
		array( 'counter2_value', __( 'Client Satisfaction', 'arcunify' ), '%' ),
		array( 'counter3_value', __( 'Industries Served', 'arcunify' ), '+' ),
	);
	foreach ( $defs as $def ) {
		$value = trim( (string) arcunify_mod( $def[0] ) );
		if ( '' !== $value ) {
			$counters[] = array( $value . $def[2], $def[1] );
		}
	}
}

if ( ! $counters ) {
	return;
}
?>
<section class="au-proof" data-theme="dark" aria-label="<?php esc_attr_e( 'At a glance', 'arcunify' ); ?>">
	<div class="au-container au-proof__inner">
		<dl class="au-proof__stats">
			<?php foreach ( $counters as $counter ) : ?>
				<div class="au-stat">
					<dt class="au-stat__label"><?php echo esc_html( $counter[1] ); ?></dt>
					<dd class="au-stat__value"><?php echo esc_html( $counter[0] ); ?></dd>
				</div>
			<?php endforeach; ?>
		</dl>
	</div>
</section>
