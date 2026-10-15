<?php
/**
 * Why Choose ArcUnify (existing 8 items) as a two-column ledger.
 *
 * @package ArcUnify
 */

$c           = ! empty( $args['content'] ) ? $args['content'] : arcunify_home_content()['why'];
$theme       = ! empty( $args['theme'] ) ? $args['theme'] : 'light';
$show_claims = (bool) arcunify_mod( 'show_why_claims' );
?>
<section class="au-section au-why au-why--<?php echo esc_attr( $theme ); ?>" data-theme="<?php echo esc_attr( $theme ); ?>" aria-labelledby="au-why-title">
	<div class="au-container">
		<?php
		arcunify_section_header(
			array(
				'kicker' => $c['kicker'],
				'title'  => $c['title'],
				'lead'   => $c['lead'],
				'id'     => 'au-why-title',
				'layout' => 'split',
			)
		);
		?>
		<ul class="au-ledger">
			<?php foreach ( $c['items'] as $item ) : ?>
				<li class="au-ledger__row">
					<h3 class="au-ledger__title"><?php echo esc_html( $item[0] ); ?></h3>
					<?php if ( $show_claims && ! empty( $item[1] ) ) : ?>
						<p class="au-ledger__claim"><?php echo esc_html( $item[1] ); ?></p>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
