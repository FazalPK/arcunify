<?php
/**
 * Template Name: ArcUnify: Service
 *
 * One template for all five services. Copy comes from inc/content-pages.php;
 * the service is matched by page slug or the "ArcUnify service" box.
 *
 * Page templates run in the global scope, so every variable here is prefixed.
 * Plain names like $page and $pages are WordPress globals that get_header()
 * resets (setup_postdata), which used to blank most of this page.
 *
 * @package ArcUnify
 */

$au_key      = arcunify_service_key_for( get_queried_object_id() );
$au_services = arcunify_services();
$au_pages    = arcunify_service_pages();
$au_labels   = arcunify_service_labels();

if ( ! $au_key || ! isset( $au_pages[ $au_key ] ) ) {
	get_template_part( 'page' ); // Unknown service: fall back to the page's own content.
	return;
}

$au_service = $au_services[ $au_key ];
$au_page    = $au_pages[ $au_key ];
$au_variant = $au_page['variant'];

get_header();
?>
<main id="content" class="au-main au-service-page au-service-page--<?php echo esc_attr( $au_variant ); ?>">
	<?php
	get_template_part(
		'template-parts/components/page-hero',
		null,
		array(
			'kicker'  => $au_service['short'],
			'title'   => get_the_title(),
			'lead'    => $au_page['tagline'],
			'actions' => array(
				array( $au_labels['get_started'], arcunify_mod( 'cta_url' ) ),
			),
			'visual'  => $au_variant,
			'variant' => $au_variant,
		)
	);
	?>

	<section class="au-section au-overview" data-theme="light" aria-labelledby="au-overview-title">
		<div class="au-container au-overview__grid">
			<div class="au-overview__copy">
				<p class="au-kicker"><?php echo esc_html( $au_service['name'] ); ?></p>
				<h2 class="au-h2" id="au-overview-title"><?php echo esc_html( $au_page['intro_title'] ); ?></h2>
				<p class="au-lead"><?php echo esc_html( $au_page['intro'] ); ?></p>
				<?php echo arcunify_button( $au_labels['get_started'], arcunify_mod( 'cta_url' ), 'primary' ); // phpcs:ignore ?>
			</div>
			<div class="au-usecases">
				<h3 class="au-usecases__title"><?php echo esc_html( $au_labels['use_cases'] ); ?></h3>
				<ul class="au-usecases__list">
					<?php foreach ( $au_page['use_cases'] as $au_use_case ) : ?>
						<li><?php echo arcunify_icon( 'check' ); // phpcs:ignore ?><span><?php echo esc_html( $au_use_case ); ?></span></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</section>

	<?php
	get_template_part(
		'template-parts/sections/home-why',
		null,
		array(
			'theme'   => 'security' === $au_variant ? 'dark' : 'paper',
			'content' => array(
				'kicker' => $au_labels['why_kicker'],
				'title'  => $au_page['why_title'],
				'lead'   => $au_page['why_lead'],
				'items'  => $au_page['why'],
			),
		)
	);
	get_template_part( 'template-parts/sections/home-proof' );
	get_template_part( 'template-parts/sections/home-process' );
	get_template_part( 'template-parts/sections/home-pricing' );
	get_template_part( 'template-parts/sections/home-testimonials', null, array( 'service' => $au_key ) );
	get_template_part(
		'template-parts/sections/home-services',
		null,
		array(
			'exclude' => $au_key,
			'content' => array(
				'kicker' => '',
				'title'  => $au_labels['others'],
				'lead'   => '',
			),
		)
	);
	get_template_part(
		'template-parts/sections/cta',
		null,
		array(
			'title' => $au_page['cta_title'],
			'lead'  => $au_page['cta_lead'],
		)
	);
	?>
</main>
<?php
get_footer();
