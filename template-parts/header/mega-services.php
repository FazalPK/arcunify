<?php
/**
 * Desktop Services mega panel, grouped by outcome.
 *
 * @package ArcUnify
 */

$panel_id = isset( $args['id'] ) ? $args['id'] : 'au-mega-services';
$services = arcunify_services();
$groups   = arcunify_service_groups();
$phone    = arcunify_mod( 'phone' );
?>
<div class="au-mega" id="<?php echo esc_attr( $panel_id ); ?>">
	<div class="au-container au-mega__inner">
		<div class="au-mega__groups">
			<?php foreach ( $groups as $group_key => $group_label ) : ?>
				<?php
				$in_group = array_filter(
					$services,
					static function ( $s ) use ( $group_key ) {
						return $s['group'] === $group_key;
					}
				);
				if ( ! $in_group ) {
					continue;
				}
				?>
				<div class="au-mega__group">
					<p class="au-mega__heading"><?php echo esc_html( $group_label ); ?></p>
					<ul>
						<?php foreach ( $in_group as $service ) : ?>
							<li>
								<a class="au-mega__link" href="<?php echo esc_url( arcunify_service_url( $service ) ); ?>">
									<span class="au-mega__icon"><?php echo arcunify_icon( $service['icon'] ); // phpcs:ignore ?></span>
									<span class="au-mega__text">
										<span class="au-mega__name"><?php echo esc_html( $service['name'] ); ?></span>
										<span class="au-mega__desc"><?php echo esc_html( $service['desc'] ); ?></span>
									</span>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endforeach; ?>
		</div>
		<div class="au-mega__aside">
			<p class="au-mega__aside-title"><?php esc_html_e( 'Flexible IT Plans For Every Business', 'arcunify' ); ?></p>
			<ul class="au-mega__aside-links">
				<li><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>"><span><?php esc_html_e( 'All services', 'arcunify' ); ?></span><?php echo arcunify_icon( 'arrow-right' ); // phpcs:ignore ?></a></li>
				<?php if ( arcunify_mod( 'show_pricing' ) ) : ?>
					<li><a href="<?php echo esc_url( home_url( '/#pricing' ) ); ?>"><span><?php esc_html_e( 'Pricing plans', 'arcunify' ); ?></span><?php echo arcunify_icon( 'arrow-right' ); // phpcs:ignore ?></a></li>
				<?php endif; ?>
			</ul>
			<?php if ( $phone ) : ?>
				<a class="au-mega__phone" href="<?php echo esc_attr( arcunify_tel( $phone ) ); ?>"><?php echo arcunify_icon( 'phone' ); // phpcs:ignore ?><span><?php echo esc_html( $phone ); ?></span></a>
			<?php endif; ?>
		</div>
	</div>
</div>
