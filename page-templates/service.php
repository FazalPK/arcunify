<?php
/**
 * Template Name: ArcUnify: Service
 *
 * One template for all five services. Copy comes from inc/content-pages.php;
 * the service is matched by page slug or the "ArcUnify service" box.
 *
 * @package ArcUnify
 */

$key      = arcunify_service_key_for( get_queried_object_id() );
$services = arcunify_services();
$pages    = arcunify_service_pages();
$labels   = arcunify_service_labels();

if ( ! $key || ! isset( $pages[ $key ] ) ) {
	get_template_part( 'page' ); // Unknown service: fall back to the page's own content.
	return;
}

$service = $services[ $key ];
$page    = $pages[ $key ];
$variant = $page['variant'];

get_header();
?>
<main id="content" class="au-main au-service-page au-service-page--<?php echo esc_attr( $variant ); ?>">
	<?php
	get_template_part(
		'template-parts/components/page-hero',
		null,
		array(
			'kicker'  => $service['short'],
			'title'   => get_the_title(),
			'lead'    => $page['tagline'],
			'actions' => array(
				array( $labels['get_started'], arcunify_mod( 'cta_url' ) ),
			),
			'visual'  => $variant,
			'variant' => $variant,
		)
	);
	?>

	<section class="au-section au-overview" data-theme="light" aria-labelledby="au-overview-title">
		<div class="au-container au-overview__grid">
			<div class="au-overview__copy">
				<p class="au-kicker"><?php echo esc_html( $service['name'] ); ?></p>
				<h2 class="au-h2" id="au-overview-title"><?php echo esc_html( $page['intro_title'] ); ?></h2>
				<p class="au-lead"><?php echo esc_html( $page['intro'] ); ?></p>
				<?php echo arcunify_button( $labels['get_started'], arcunify_mod( 'cta_url' ), 'primary' ); // phpcs:ignore ?>
			</div>
			<div class="au-usecases">
				<h3 class="au-usecases__title"><?php echo esc_html( $labels['use_cases'] ); ?></h3>
				<ul class="au-usecases__list">
					<?php foreach ( $page['use_cases'] as $use_case ) : ?>
						<li><?php echo arcunify_icon( 'check' ); // phpcs:ignore ?><span><?php echo esc_html( $use_case ); ?></span></li>
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
			'theme'   => 'security' === $variant ? 'dark' : 'paper',
			'content' => array(
				'kicker' => $labels['why_kicker'],
				'title'  => $page['why_title'],
				'lead'   => $page['why_lead'],
				'items'  => $page['why'],
			),
		)
	);
	get_template_part( 'template-parts/sections/home-proof' );
	get_template_part( 'template-parts/sections/home-process' );
	get_template_part( 'template-parts/sections/home-pricing' );
	get_template_part( 'template-parts/sections/home-testimonials', null, array( 'service' => $key ) );
	get_template_part(
		'template-parts/sections/home-services',
		null,
		array(
			'exclude' => $key,
			'content' => array(
				'kicker' => '',
				'title'  => $labels['others'],
				'lead'   => '',
			),
		)
	);
	get_template_part(
		'template-parts/sections/cta',
		null,
		array(
			'title' => $page['cta_title'],
			'lead'  => $page['cta_lead'],
		)
	);
	?>
</main>
<?php
get_footer();
