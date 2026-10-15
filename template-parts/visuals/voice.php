<?php
/**
 * VoIP & UC: a voice waveform routed by the auto attendant to every channel.
 *
 * @package ArcUnify
 */

$branches = array(
	array( 70, 'headset', __( 'HD voice', 'arcunify' ) ),
	array( 150, 'video', __( 'Video', 'arcunify' ) ),
	array( 230, 'message-square', __( 'Team messaging', 'arcunify' ) ),
	array( 310, 'voicemail', __( 'Voicemail-to-email', 'arcunify' ) ),
	array( 390, 'smartphone', __( 'Mobile apps', 'arcunify' ) ),
);
$bars = array( 10, 22, 38, 26, 54, 34, 70, 44, 28, 58, 36, 20, 42, 16, 8 );
?>
<svg class="au-v au-v--voice" viewBox="0 0 560 440" role="img" aria-label="<?php esc_attr_e( 'Calls routed by auto attendants to HD voice, video, team messaging, voicemail-to-email and mobile apps', 'arcunify' ); ?>">
	<rect x="20" y="20" width="520" height="400" rx="14" class="au-v__panel"/>
	<g class="au-v__wave">
		<?php foreach ( $bars as $i => $h ) : ?>
			<rect x="<?php echo (int) ( 44 + $i * 8 ); ?>" y="<?php echo (int) ( 230 - $h / 2 ); ?>" width="4" height="<?php echo (int) $h; ?>" rx="2" style="--i:<?php echo (int) $i; ?>"/>
		<?php endforeach; ?>
	</g>
	<path d="M168 230 H 222" class="au-v__flow" pathLength="1"/>
	<?php foreach ( $branches as $b ) : ?>
		<path d="M290 230 C 318 230, 318 <?php echo (int) $b[0]; ?>, 348 <?php echo (int) $b[0]; ?>" class="au-v__flow au-v__flow--soft" pathLength="1"/>
	<?php endforeach; ?>
	<g class="au-v__hub">
		<rect x="222" y="196" width="68" height="68" rx="16" class="au-v__tile au-v__tile--hub"/>
		<?php echo arcunify_svg_icon( 'phone-call', 240, 214, 32 ); // phpcs:ignore ?>
		<text x="256" y="292" text-anchor="middle" class="au-v__label"><?php esc_html_e( 'Auto attendant', 'arcunify' ); ?></text>
	</g>
	<?php foreach ( $branches as $b ) : ?>
		<?php echo arcunify_svg_node( 370, $b[0], $b[1], $b[2], 'right' ); // phpcs:ignore ?>
	<?php endforeach; ?>
</svg>
