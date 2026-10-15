<?php
/**
 * Proof strip: counters and logos. Renders only verified, owner-entered values.
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

$logos = array(); // Rendered <img> HTML.
if ( arcunify_mod( 'show_logos' ) ) {
	for ( $i = 1; $i <= 8; $i++ ) {
		$id = (int) arcunify_mod( 'logo' . $i );
		if ( $id && wp_attachment_is_image( $id ) ) {
			$logos[] = wp_get_attachment_image( $id, 'medium', false, array( 'loading' => 'lazy', 'class' => 'au-logos__img' ) );
		}
	}
	if ( ! $logos ) {
		foreach ( arcunify_lines( arcunify_mod( 'logo_paths' ) ) as $path ) {
			$logos[] = arcunify_site_image( $path, '', 'medium', array( 'class' => 'au-logos__img' ) );
		}
	}
}

if ( ! $counters && ! $logos ) {
	return;
}
?>
<section class="au-proof" data-theme="dark" aria-label="<?php esc_attr_e( 'At a glance', 'arcunify' ); ?>">
	<div class="au-container au-proof__inner">
		<?php if ( $counters ) : ?>
			<dl class="au-proof__stats">
				<?php foreach ( $counters as $counter ) : ?>
					<div class="au-stat">
						<dt class="au-stat__label"><?php echo esc_html( $counter[1] ); ?></dt>
						<dd class="au-stat__value"><?php echo esc_html( $counter[0] ); ?></dd>
					</div>
				<?php endforeach; ?>
			</dl>
		<?php endif; ?>
		<?php if ( $logos ) : ?>
			<div class="au-logos">
				<?php if ( arcunify_mod( 'logos_label' ) ) : ?>
					<p class="au-logos__label"><?php echo esc_html( arcunify_mod( 'logos_label' ) ); ?></p>
				<?php endif; ?>
				<ul class="au-logos__list">
					<?php foreach ( $logos as $logo_html ) : ?>
						<li><?php echo $logo_html; // phpcs:ignore -- built by wp_get_attachment_image / arcunify_site_image. ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>
	</div>
</section>
