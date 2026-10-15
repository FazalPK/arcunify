<?php
/**
 * 404.
 *
 * @package ArcUnify
 */

get_header();
?>
<main id="content" class="au-main">
	<section class="au-page-hero au-404" data-theme="dark" aria-labelledby="au-404-title">
		<div class="au-container">
			<p class="au-kicker"><?php esc_html_e( 'Error 404', 'arcunify' ); ?></p>
			<h1 class="au-page-hero__title" id="au-404-title"><?php esc_html_e( 'This page could not be found', 'arcunify' ); ?></h1>
			<p class="au-lead"><?php esc_html_e( 'The link may be out of date. Choose a service below or contact us.', 'arcunify' ); ?></p>
			<ul class="au-404__links">
				<?php foreach ( arcunify_services() as $service ) : ?>
					<li><a href="<?php echo esc_url( arcunify_service_url( $service ) ); ?>"><?php echo arcunify_icon( $service['icon'] ); // phpcs:ignore ?><span><?php echo esc_html( $service['name'] ); ?></span></a></li>
				<?php endforeach; ?>
			</ul>
			<div class="au-actions">
				<?php echo arcunify_button( __( 'Back to home', 'arcunify' ), '/', 'ghost', array( 'icon' => '' ) ); // phpcs:ignore ?>
				<?php echo arcunify_button( arcunify_mod( 'cta_label' ), arcunify_mod( 'cta_url' ), 'primary' ); // phpcs:ignore ?>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();
