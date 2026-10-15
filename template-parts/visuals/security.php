<?php
/**
 * Cybersecurity: layered defence rings around a protected core.
 *
 * @package ArcUnify
 */

$nodes = array(
	array( 280, 60, 'laptop', __( 'Endpoint', 'arcunify' ), 'right' ),
	array( 448, 172, 'mail', __( 'Email', 'arcunify' ), 'below' ),
	array( 392, 360, 'fingerprint', __( 'MFA', 'arcunify' ), 'right' ),
	array( 168, 360, 'shield', __( 'Firewall', 'arcunify' ), 'left' ),
	array( 112, 172, 'circle-check', __( 'Compliance', 'arcunify' ), 'below' ),
);
?>
<svg class="au-v au-v--security" viewBox="0 0 560 440" role="img" aria-label="<?php esc_attr_e( 'Multi-layered cybersecurity: endpoint, email, MFA, firewall and compliance protection around your business', 'arcunify' ); ?>">
	<defs>
		<radialGradient id="au-sec-glow"><stop offset="0" stop-color="#3FD0FF" stop-opacity=".28"/><stop offset="1" stop-color="#3FD0FF" stop-opacity="0"/></radialGradient>
		<linearGradient id="au-sec-sweep" x1="0" y1="0" x2="1" y2="0"><stop offset="0" stop-color="#3FD0FF" stop-opacity="0"/><stop offset="1" stop-color="#3FD0FF" stop-opacity=".35"/></linearGradient>
	</defs>
	<circle cx="280" cy="220" r="170" fill="url(#au-sec-glow)"/>
	<circle cx="280" cy="220" r="170" class="au-v__ring"/>
	<circle cx="280" cy="220" r="118" class="au-v__ring au-v__ring--dash"/>
	<circle cx="280" cy="220" r="66" class="au-v__ring"/>
	<g class="au-v__sweep"><path d="M280 220 L280 50 A170 170 0 0 1 427 135 Z" fill="url(#au-sec-sweep)"/></g>
	<?php foreach ( $nodes as $n ) : ?>
		<line x1="280" y1="220" x2="<?php echo (int) $n[0]; ?>" y2="<?php echo (int) $n[1]; ?>" class="au-v__link"/>
	<?php endforeach; ?>
	<circle cx="280" cy="220" r="40" class="au-v__core"/>
	<?php echo arcunify_svg_icon( 'shield-check', 262, 202, 36 ); // phpcs:ignore ?>
	<?php
	foreach ( $nodes as $n ) {
		echo arcunify_svg_node( $n[0], $n[1], $n[2], $n[3], $n[4] ); // phpcs:ignore
	}
	?>
</svg>
