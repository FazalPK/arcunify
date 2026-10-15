<?php
/**
 * Managed IT: operations console. Rows use the service's existing wording; no data.
 *
 * @package ArcUnify
 */

$rows = array(
	array( 'headset', __( 'Monitoring & help desk', 'arcunify' ), 'M0 10 L14 8 L28 12 L42 4 L56 9 L70 6 L84 10' ),
	array( 'server', __( 'Network & server management', 'arcunify' ), 'M0 8 L14 10 L28 5 L42 9 L56 7 L70 11 L84 6' ),
	array( 'refresh-cw', __( 'Patch management', 'arcunify' ), 'M0 11 L14 9 L28 9 L42 6 L56 8 L70 5 L84 7' ),
	array( 'hard-drive', __( 'Backup & disaster recovery', 'arcunify' ), 'M0 7 L14 7 L28 10 L42 8 L56 4 L70 8 L84 9' ),
	array( 'users', __( 'Co-managed IT', 'arcunify' ), 'M0 9 L14 6 L28 8 L42 11 L56 6 L70 9 L84 8' ),
);
?>
<svg class="au-v au-v--managed" viewBox="0 0 560 440" role="img" aria-label="<?php esc_attr_e( 'Managed IT services: monitoring, management, patching, backup and co-managed support', 'arcunify' ); ?>">
	<rect x="20" y="20" width="520" height="400" rx="14" class="au-v__panel"/>
	<line x1="20" y1="64" x2="540" y2="64" class="au-v__rule"/>
	<circle cx="46" cy="42" r="5" class="au-v__dot"/><circle cx="64" cy="42" r="5" class="au-v__dot"/><circle cx="82" cy="42" r="5" class="au-v__dot"/>
	<g class="au-v__live"><circle cx="452" cy="42" r="4" class="au-v__ok au-v__blink"/><text x="464" y="42" class="au-v__meta" dominant-baseline="middle">24/7</text></g>
	<?php foreach ( $rows as $i => $row ) : ?>
		<?php $y = 92 + $i * 64; ?>
		<g class="au-v__row" style="--i:<?php echo (int) $i; ?>">
			<rect x="40" y="<?php echo (int) $y; ?>" width="480" height="48" rx="8" class="au-v__rowbg"/>
			<?php echo arcunify_svg_icon( $row[0], 56, $y + 14, 20 ); // phpcs:ignore ?>
			<text x="90" y="<?php echo (int) ( $y + 24 ); ?>" class="au-v__label" dominant-baseline="middle"><?php echo esc_html( $row[1] ); ?></text>
			<path d="<?php echo esc_attr( $row[2] ); ?>" transform="translate(394 <?php echo (int) ( $y + 16 ); ?>)" class="au-v__spark" pathLength="1"/>
			<circle cx="500" cy="<?php echo (int) ( $y + 24 ); ?>" r="4" class="au-v__ok"/>
		</g>
	<?php endforeach; ?>
</svg>
