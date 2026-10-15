<?php
/**
 * Footer.
 *
 * @package ArcUnify
 */

$content  = arcunify_home_content();
$phone    = arcunify_mod( 'phone' );
$email    = arcunify_mod( 'email' );
$address  = arcunify_mod( 'address' );
$support  = arcunify_mod( 'support_line' );
$socials  = arcunify_social_links();
$services = arcunify_services();
?>
<footer class="au-footer" data-theme="dark">
	<div class="au-container">
		<div class="au-footer__grid">
			<div class="au-footer__brand">
				<div class="au-brand">
					<?php if ( has_custom_logo() ) : ?>
						<?php the_custom_logo(); ?>
					<?php else : ?>
						<a class="au-brand__text" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></a>
					<?php endif; ?>
				</div>
				<p class="au-footer__about"><?php echo esc_html( $content['footer']['about'] ); ?></p>
				<?php if ( $socials ) : ?>
					<ul class="au-footer__social">
						<?php foreach ( $socials as $label => $social ) : ?>
							<li><a href="<?php echo esc_url( $social[0] ); ?>" rel="noopener" target="_blank"><span class="screen-reader-text"><?php echo esc_html( $label ); ?></span><?php echo arcunify_icon( $social[1] ); // phpcs:ignore ?></a></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>

			<nav class="au-footer__col" aria-labelledby="au-footer-services">
				<h2 class="au-footer__title" id="au-footer-services"><?php esc_html_e( 'Services', 'arcunify' ); ?></h2>
				<ul>
					<?php foreach ( $services as $service ) : ?>
						<li><a href="<?php echo esc_url( arcunify_service_url( $service ) ); ?>"><?php echo esc_html( $service['name'] ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</nav>

			<nav class="au-footer__col" aria-labelledby="au-footer-company">
				<h2 class="au-footer__title" id="au-footer-company"><?php esc_html_e( 'Company', 'arcunify' ); ?></h2>
				<?php
				if ( has_nav_menu( 'footer' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'footer',
							'container'      => false,
							'depth'          => 1,
						)
					);
				} else {
					echo '<ul>';
					printf( '<li><a href="%s">%s</a></li>', esc_url( home_url( '/about-us/' ) ), esc_html__( 'About Us', 'arcunify' ) );
					printf( '<li><a href="%s">%s</a></li>', esc_url( home_url( '/services/' ) ), esc_html__( 'Services', 'arcunify' ) );
					printf( '<li><a href="%s">%s</a></li>', esc_url( home_url( '/contact-us/' ) ), esc_html__( 'Contact Us', 'arcunify' ) );
					echo '</ul>';
				}
				?>
			</nav>

			<div class="au-footer__col au-footer__contact">
				<h2 class="au-footer__title"><?php esc_html_e( 'Contact', 'arcunify' ); ?></h2>
				<ul>
					<?php if ( $email ) : ?>
						<li><?php echo arcunify_icon( 'mail' ); // phpcs:ignore ?><a href="mailto:<?php echo esc_attr( antispambot( $email ) ); ?>"><?php echo esc_html( antispambot( $email ) ); ?></a></li>
					<?php endif; ?>
					<?php if ( $phone ) : ?>
						<li><?php echo arcunify_icon( 'phone' ); // phpcs:ignore ?><a href="<?php echo esc_attr( arcunify_tel( $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></li>
					<?php endif; ?>
					<?php if ( $support ) : ?>
						<li><?php echo arcunify_icon( 'headset' ); // phpcs:ignore ?><span><?php echo esc_html( $support ); ?></span></li>
					<?php endif; ?>
					<?php if ( $address ) : ?>
						<li><?php echo arcunify_icon( 'map-pin' ); // phpcs:ignore ?><address><?php echo nl2br( esc_html( $address ) ); // phpcs:ignore ?></address></li>
					<?php endif; ?>
				</ul>
			</div>
		</div>

		<div class="au-footer__bottom">
			<p>&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ); ?>. <?php esc_html_e( 'All rights reserved.', 'arcunify' ); ?></p>
			<?php
			if ( has_nav_menu( 'legal' ) ) {
				wp_nav_menu(
					array(
						'theme_location' => 'legal',
						'container'      => 'nav',
						'container_aria_label' => __( 'Legal', 'arcunify' ),
						'menu_class'     => 'au-footer__legal',
						'depth'          => 1,
					)
				);
			} elseif ( get_privacy_policy_url() ) {
				echo '<nav aria-label="' . esc_attr__( 'Legal', 'arcunify' ) . '"><ul class="au-footer__legal"><li>' . get_the_privacy_policy_link() . '</li></ul></nav>'; // phpcs:ignore
			}
			?>
		</div>
	</div>
</footer>
