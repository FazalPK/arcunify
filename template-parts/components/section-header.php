<?php
/**
 * Section header: kicker, heading, lead.
 *
 * Args: kicker, title, lead, id (heading id for aria-labelledby), layout (stack|split), align.
 *
 * @package ArcUnify
 */

$args   = wp_parse_args(
	$args,
	array(
		'kicker' => '',
		'title'  => '',
		'lead'   => '',
		'id'     => '',
		'layout' => 'stack',
	)
);
$layout = 'split' === $args['layout'] ? 'au-sh au-sh--split' : 'au-sh';
?>
<div class="<?php echo esc_attr( $layout ); ?>">
	<div class="au-sh__main">
		<?php if ( $args['kicker'] ) : ?>
			<p class="au-kicker"><?php echo esc_html( $args['kicker'] ); ?></p>
		<?php endif; ?>
		<h2 class="au-h2"<?php echo $args['id'] ? ' id="' . esc_attr( $args['id'] ) . '"' : ''; ?>><?php echo esc_html( $args['title'] ); ?></h2>
	</div>
	<?php if ( $args['lead'] ) : ?>
		<p class="au-lead au-sh__lead"><?php echo esc_html( $args['lead'] ); ?></p>
	<?php endif; ?>
</div>
