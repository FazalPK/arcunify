<?php
/**
 * Template Name: ArcUnify: About
 *
 * @package ArcUnify
 */

$c = arcunify_page_content()['about'];
get_header();
?>
<main id="content" class="au-main au-about-page">
	<?php
	get_template_part(
		'template-parts/components/page-hero',
		null,
		array(
			'kicker'  => $c['kicker'],
			'title'   => $c['h1'],
			'actions' => array(
				array( arcunify_mod( 'hero_cta1_label' ), arcunify_mod( 'hero_cta1_url' ) ),
				array( arcunify_mod( 'hero_cta2_label' ), arcunify_mod( 'hero_cta2_url' ) ),
			),
			'variant' => 'about',
		)
	);
	get_template_part( 'template-parts/sections/home-about', null, array( 'content' => $c ) );
	get_template_part( 'template-parts/sections/home-proof' );
	?>

	<section class="au-section au-values" data-theme="paper" aria-labelledby="au-values-title">
		<div class="au-container">
			<?php
			arcunify_section_header(
				array(
					'kicker' => $c['values_kicker'],
					'title'  => $c['values_title'],
					'lead'   => $c['values_lead'],
					'id'     => 'au-values-title',
					'layout' => 'split',
				)
			);
			?>
			<div class="au-values__grid">
				<?php
				$blocks = array(
					array( $c['mission_title'], $c['mission'], $c['mission_image'] ),
					array( $c['vision_title'], $c['vision'], $c['vision_image'] ),
				);
				foreach ( $blocks as $block ) :
					?>
					<article class="au-value">
						<div class="au-value__media"><?php echo arcunify_site_image( $block[2], '', 'large' ); // phpcs:ignore ?></div>
						<div class="au-value__body">
							<h3 class="au-h3"><?php echo esc_html( $block[0] ); ?></h3>
							<p><?php echo esc_html( $block[1] ); ?></p>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php get_template_part( 'template-parts/sections/home-why' ); ?>

	<section class="au-section au-team" data-theme="light" aria-labelledby="au-team-title">
		<div class="au-container">
			<?php
			arcunify_section_header(
				array(
					'kicker' => $c['team_kicker'],
					'title'  => $c['team_title'],
					'lead'   => $c['team_lead'],
					'id'     => 'au-team-title',
					'layout' => 'split',
				)
			);
			?>
			<ul class="au-team__grid">
				<?php foreach ( $c['team'] as $member ) : ?>
					<?php
					$initials = implode(
						'',
						array_map(
							static function ( $part ) {
								return mb_substr( $part, 0, 1 );
							},
							array_slice( explode( ' ', $member[0] ), 0, 2 )
						)
					);
					?>
					<li class="au-member">
						<span class="au-member__mono" aria-hidden="true"><?php echo esc_html( $initials ); ?></span>
						<h3 class="au-member__name"><?php echo esc_html( $member[0] ); ?></h3>
						<p class="au-member__role"><?php echo esc_html( $member[1] ); ?></p>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<?php
	get_template_part( 'template-parts/sections/home-services' );
	get_template_part( 'template-parts/sections/cta' );
	?>
</main>
<?php
get_footer();
