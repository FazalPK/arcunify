<?php
/**
 * Header: contact bar, logo, navigation, consultation button, mobile menu.
 *
 * @package ArcUnify
 */

$phone   = arcunify_mod( 'phone' );
$email   = arcunify_mod( 'email' );
$support = arcunify_mod( 'support_line' );
?>
<header class="au-header" data-theme="dark" data-au-header>
	<?php if ( arcunify_mod( 'show_utility' ) ) : ?>
		<div class="au-utility">
			<div class="au-container au-utility__inner">
				<?php if ( $support ) : ?>
					<p class="au-utility__note"><?php echo arcunify_icon( 'headset' ); // phpcs:ignore ?><span><?php echo esc_html( $support ); ?></span></p>
				<?php endif; ?>
				<ul class="au-utility__links">
					<?php if ( $phone ) : ?>
						<li><a href="<?php echo esc_attr( arcunify_tel( $phone ) ); ?>"><?php echo arcunify_icon( 'phone' ); // phpcs:ignore ?><span><?php echo esc_html( $phone ); ?></span></a></li>
					<?php endif; ?>
					<?php if ( $email ) : ?>
						<li><a href="mailto:<?php echo esc_attr( antispambot( $email ) ); ?>"><?php echo arcunify_icon( 'mail' ); // phpcs:ignore ?><span><?php echo esc_html( antispambot( $email ) ); ?></span></a></li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	<?php endif; ?>

	<div class="au-header__bar">
		<div class="au-container au-header__inner">
			<div class="au-brand">
				<?php if ( has_custom_logo() ) : ?>
					<?php the_custom_logo(); ?>
				<?php else : ?>
					<a class="au-brand__text" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></a>
				<?php endif; ?>
			</div>

			<nav class="au-nav au-nav--desktop" aria-label="<?php esc_attr_e( 'Main', 'arcunify' ); ?>" data-au-nav>
				<?php arcunify_primary_nav( 'desktop' ); ?>
			</nav>

			<div class="au-header__actions">
				<?php echo arcunify_button( arcunify_mod( 'cta_label' ), arcunify_mod( 'cta_url' ), 'primary', array( 'class' => 'au-header__cta' ) ); // phpcs:ignore ?>
				<button class="au-menu-toggle" type="button" aria-expanded="false" aria-controls="au-mobile-menu" data-au-menu-toggle>
					<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'arcunify' ); ?></span>
					<?php echo arcunify_icon( 'menu', 'au-menu-toggle__open' ); // phpcs:ignore ?>
					<?php echo arcunify_icon( 'x', 'au-menu-toggle__close' ); // phpcs:ignore ?>
				</button>
			</div>
		</div>
	</div>

	<div class="au-mobile" id="au-mobile-menu" hidden data-au-mobile>
		<nav class="au-nav au-nav--mobile" aria-label="<?php esc_attr_e( 'Main', 'arcunify' ); ?>" data-au-nav>
			<?php arcunify_primary_nav( 'mobile' ); ?>
		</nav>
		<div class="au-mobile__footer">
			<?php echo arcunify_button( arcunify_mod( 'cta_label' ), arcunify_mod( 'cta_url' ), 'primary', array( 'class' => 'au-btn--block' ) ); // phpcs:ignore ?>
			<?php if ( $phone ) : ?>
				<a class="au-mobile__contact" href="<?php echo esc_attr( arcunify_tel( $phone ) ); ?>"><?php echo arcunify_icon( 'phone' ); // phpcs:ignore ?><span><?php echo esc_html( $phone ); ?></span></a>
			<?php endif; ?>
			<?php if ( $support ) : ?>
				<p class="au-mobile__note"><?php echo esc_html( $support ); ?></p>
			<?php endif; ?>
		</div>
	</div>
</header>
