<?php
/**
 * Cloud & Data: migration → hybrid/multi-cloud → warehousing → analytics.
 *
 * @package ArcUnify
 */
?>
<svg class="au-v au-v--cloud" viewBox="0 0 560 440" role="img" aria-label="<?php esc_attr_e( 'Cloud and data flow: cloud migration, hybrid and multi-cloud management, data warehousing, analytics and BI', 'arcunify' ); ?>">
	<rect x="20" y="20" width="520" height="400" rx="14" class="au-v__panel"/>
	<path d="M110 140 C 170 140, 190 110, 238 110" class="au-v__flow" pathLength="1"/>
	<path d="M322 110 C 370 110, 390 140, 450 140" class="au-v__flow" pathLength="1"/>
	<path d="M450 196 C 450 260, 380 300, 302 316" class="au-v__flow" pathLength="1"/>
	<path d="M110 196 C 110 260, 180 300, 258 316" class="au-v__flow au-v__flow--soft" pathLength="1"/>
	<circle r="4" class="au-v__packet"><animateMotion dur="3.2s" repeatCount="indefinite" path="M110 140 C 170 140, 190 110, 238 110"/></circle>
	<circle r="4" class="au-v__packet"><animateMotion dur="3.2s" begin="1s" repeatCount="indefinite" path="M322 110 C 370 110, 390 140, 450 140"/></circle>
	<circle r="4" class="au-v__packet"><animateMotion dur="3.6s" begin="2s" repeatCount="indefinite" path="M450 196 C 450 260, 380 300, 302 316"/></circle>
	<g class="au-v__hub">
		<rect x="230" y="70" width="100" height="80" rx="16" class="au-v__tile au-v__tile--hub"/>
		<?php echo arcunify_svg_icon( 'cloud', 262, 88, 36 ); // phpcs:ignore ?>
		<text x="280" y="176" text-anchor="middle" class="au-v__label"><?php esc_html_e( 'Hybrid & multi-cloud', 'arcunify' ); ?></text>
	</g>
	<?php
	echo arcunify_svg_node( 110, 140, 'refresh-cw', __( 'Cloud migration', 'arcunify' ) ); // phpcs:ignore
	echo arcunify_svg_node( 450, 140, 'database', __( 'Data warehousing', 'arcunify' ) ); // phpcs:ignore
	echo arcunify_svg_node( 280, 330, 'chart-column', __( 'Analytics & BI', 'arcunify' ) ); // phpcs:ignore
	?>
</svg>
