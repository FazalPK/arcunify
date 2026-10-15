<?php
/**
 * Template Name: ArcUnify: Contact
 *
 * @package ArcUnify
 */

$c       = arcunify_page_content()['contact'];
$phone   = arcunify_mod( 'phone' );
$email   = arcunify_mod( 'email' );
$address = arcunify_mod( 'address' );
$support = arcunify_mod( 'support_line' );
get_header();
?>
<main id="content" class="au-main au-contact-page">
	<?php
	get_template_part(
		'template-parts/components/page-hero',
		null,
		array(
			'kicker'  => $c['kicker'],
			'title'   => $c['h1'],
			'variant' => 'contact',
		)
	);
	?>

	<section class="au-section au-contact" data-theme="paper" aria-labelledby="au-contact-title">
		<div class="au-container au-contact__grid">
			<div class="au-contact__info">
				<p class="au-kicker"><?php echo esc_html( $c['panel_kicker'] ); ?></p>
				<h2 class="au-h2" id="au-contact-title"><?php echo esc_html( $c['panel_title'] ); ?></h2>
				<p class="au-lead"><?php echo esc_html( $c['panel_lead'] ); ?></p>
				<dl class="au-contact__list">
					<?php if ( $email ) : ?>
						<div><dt><?php echo arcunify_icon( 'mail' ); // phpcs:ignore ?><?php esc_html_e( 'Email', 'arcunify' ); ?></dt><dd><a href="mailto:<?php echo esc_attr( antispambot( $email ) ); ?>"><?php echo esc_html( antispambot( $email ) ); ?></a></dd></div>
					<?php endif; ?>
					<?php if ( $phone ) : ?>
						<div><dt><?php echo arcunify_icon( 'phone' ); // phpcs:ignore ?><?php esc_html_e( 'Phone', 'arcunify' ); ?></dt><dd><a href="<?php echo esc_attr( arcunify_tel( $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></dd></div>
					<?php endif; ?>
					<?php if ( $support ) : ?>
						<div><dt><?php echo arcunify_icon( 'headset' ); // phpcs:ignore ?><?php esc_html_e( 'Support', 'arcunify' ); ?></dt><dd><?php echo esc_html( $support ); ?></dd></div>
					<?php endif; ?>
					<?php if ( $address ) : ?>
						<div><dt><?php echo arcunify_icon( 'map-pin' ); // phpcs:ignore ?><?php esc_html_e( 'Office', 'arcunify' ); ?></dt><dd><address><?php echo nl2br( esc_html( $address ) ); // phpcs:ignore ?></address></dd></div>
					<?php endif; ?>
				</dl>
			</div>
			<div class="au-contact__form" id="contact-form">
				<?php arcunify_render_contact_form(); ?>
			</div>
		</div>
	</section>

	<?php if ( arcunify_mod( 'show_map' ) && $address ) : ?>
		<section class="au-map" aria-label="<?php esc_attr_e( 'Map', 'arcunify' ); ?>">
			<iframe title="<?php echo esc_attr( sprintf( /* translators: %s: address */ __( 'Map: %s', 'arcunify' ), $address ) ); ?>" src="<?php echo esc_url( 'https://maps.google.com/maps?q=' . rawurlencode( $address ) . '&t=m&z=15&output=embed&iwloc=near' ); ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
		</section>
	<?php endif; ?>

	<section class="au-section au-faq" data-theme="light" aria-labelledby="au-faq-title">
		<div class="au-container au-faq__grid">
			<div>
				<p class="au-kicker"><?php echo esc_html( $c['faq_kicker'] ); ?></p>
				<h2 class="au-h2" id="au-faq-title"><?php echo esc_html( $c['faq_title'] ); ?></h2>
			</div>
			<div class="au-faq__list">
				<?php foreach ( $c['faq'] as $i => $qa ) : ?>
					<details class="au-faq__item"<?php echo 0 === $i ? ' open' : ''; ?>>
						<summary><span><?php echo esc_html( $qa[0] ); ?></span><?php echo arcunify_icon( 'chevron-down', 'au-faq__chev' ); // phpcs:ignore ?></summary>
						<p><?php echo esc_html( $qa[1] ); ?></p>
					</details>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php get_template_part( 'template-parts/sections/home-process' ); ?>

	<section class="au-callout" data-theme="dark" aria-labelledby="au-call-title">
		<div class="au-container au-callout__inner">
			<div>
				<h2 class="au-h2" id="au-call-title"><?php echo esc_html( $c['call_title'] ); ?></h2>
				<p class="au-lead"><?php echo esc_html( $c['call_kicker'] ); ?></p>
			</div>
			<div class="au-actions">
				<?php echo arcunify_button( $c['call_button'], '#contact-form', 'primary' ); // phpcs:ignore ?>
				<?php if ( $phone ) : ?>
					<?php echo arcunify_button( $phone, arcunify_tel( $phone ), 'ghost', array( 'icon' => 'phone' ) ); // phpcs:ignore ?>
				<?php endif; ?>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();
