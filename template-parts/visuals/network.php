<?php
/**
 * Network Infrastructure: blueprint topology (firewall → switching → Wi-Fi / LAN / WAN).
 *
 * @package ArcUnify
 */
?>
<svg class="au-v au-v--network" viewBox="0 0 560 440" role="img" aria-label="<?php esc_attr_e( 'Network topology: firewall, switches and routers, Wi-Fi, LAN and WAN', 'arcunify' ); ?>">
	<defs>
		<pattern id="au-net-grid" width="24" height="24" patternUnits="userSpaceOnUse"><path d="M24 0H0V24" class="au-v__grid"/></pattern>
	</defs>
	<rect x="20" y="20" width="520" height="400" rx="14" class="au-v__panel"/>
	<rect x="21" y="21" width="518" height="398" rx="13" fill="url(#au-net-grid)"/>
	<path d="M280 98 V 168" class="au-v__cable" pathLength="1"/>
	<path d="M280 236 V 268 H 120 V 300 M280 268 V 300 M280 268 H 440 V 300" class="au-v__cable" pathLength="1"/>
	<circle r="3.5" class="au-v__packet"><animateMotion dur="2.4s" repeatCount="indefinite" path="M280 98 V 168"/></circle>
	<circle r="3.5" class="au-v__packet"><animateMotion dur="2.8s" begin=".6s" repeatCount="indefinite" path="M280 236 V 268 H 120 V 300"/></circle>
	<circle r="3.5" class="au-v__packet"><animateMotion dur="2.8s" begin="1.4s" repeatCount="indefinite" path="M280 236 V 268 H 440 V 300"/></circle>
	<?php
	echo arcunify_svg_node( 280, 76, 'shield', __( 'Firewall', 'arcunify' ), 'right' ); // phpcs:ignore
	echo arcunify_svg_node( 280, 202, 'network', __( 'Switches & routers', 'arcunify' ), 'right' ); // phpcs:ignore
	echo arcunify_svg_node( 120, 322, 'wifi', __( 'Wi-Fi', 'arcunify' ) ); // phpcs:ignore
	echo arcunify_svg_node( 280, 322, 'laptop', __( 'LAN', 'arcunify' ) ); // phpcs:ignore
	echo arcunify_svg_node( 440, 322, 'building-2', __( 'WAN', 'arcunify' ) ); // phpcs:ignore
	?>
</svg>
