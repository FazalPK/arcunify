<?php
/**
 * Clients: logo, contact name and role for real ArcUnify clients.
 *
 * Logos live in assets/images/clients/. An entry without a logo shows the
 * company name as a wordmark.
 *
 * @package ArcUnify
 */

$au_clients = array(
	array( 'countax.jpg', 'Countax Services Inc.', 'Mr Adeeb Siddiqui', 'GM' ),
	array( 'travel-guide.jpg', 'Travel Guide', 'Mr Fawad Palli', 'CEO' ),
	array( '', 'CIF', 'Dr Shoaib Hussain', 'Physician' ),
	array( 'westend-travel.jpg', 'Westend Travel Inc.', 'Mr Athar Mohamed', 'Head' ),
);
?>
<section class="au-section au-clients" data-theme="paper" aria-labelledby="au-clients-title">
	<div class="au-container">
		<?php
		arcunify_section_header(
			array(
				'kicker' => __( 'Our clients', 'arcunify' ),
				'title'  => __( 'Trusted by local businesses', 'arcunify' ),
				'id'     => 'au-clients-title',
			)
		);
		?>
		<ul class="au-clients__list">
			<?php foreach ( $au_clients as $au_client ) : ?>
				<li class="au-client">
					<div class="au-client__logo">
						<?php if ( $au_client[0] ) : ?>
							<img src="<?php echo esc_url( ARCUNIFY_URI . '/assets/images/clients/' . $au_client[0] ); ?>" alt="<?php echo esc_attr( $au_client[1] ); ?>" loading="lazy" decoding="async">
						<?php else : ?>
							<span class="au-client__wordmark"><?php echo esc_html( $au_client[1] ); ?></span>
						<?php endif; ?>
					</div>
					<strong class="au-client__name"><?php echo esc_html( $au_client[2] ); ?></strong>
					<span class="au-client__role"><?php echo esc_html( $au_client[3] . ', ' . $au_client[1] ); ?></span>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
