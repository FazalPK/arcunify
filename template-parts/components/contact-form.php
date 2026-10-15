<?php
/**
 * Built-in contact form.
 *
 * @package ArcUnify
 */

$sent   = isset( $_GET['sent'] ); // phpcs:ignore WordPress.Security.NonceVerification
$error  = sanitize_key( $_GET['form_error'] ?? '' ); // phpcs:ignore WordPress.Security.NonceVerification
$errors = array(
	'missing' => __( 'Please fill in your name, email and message.', 'arcunify' ),
	'email'   => __( 'Please enter a valid email address.', 'arcunify' ),
	'expired' => __( 'The form expired. Please send it again.', 'arcunify' ),
	'limit'   => __( 'Too many messages from this connection. Please email or call us instead.', 'arcunify' ),
);
?>
<?php if ( $sent ) : ?>
	<div class="au-form__notice au-form__notice--ok" role="status" tabindex="-1">
		<?php echo arcunify_icon( 'circle-check' ); // phpcs:ignore ?>
		<p><strong><?php esc_html_e( 'Message sent.', 'arcunify' ); ?></strong> <?php esc_html_e( 'Our team will respond within one business day.', 'arcunify' ); ?></p>
	</div>
<?php else : ?>
	<?php if ( isset( $errors[ $error ] ) ) : ?>
		<div class="au-form__notice au-form__notice--error" role="alert">
			<?php echo arcunify_icon( 'circle-alert' ); // phpcs:ignore ?>
			<p><?php echo esc_html( $errors[ $error ] ); ?></p>
		</div>
	<?php endif; ?>
	<form class="au-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" novalidate data-au-form>
		<input type="hidden" name="action" value="arcunify_contact">
		<input type="hidden" name="au_ts" value="<?php echo esc_attr( time() ); ?>">
		<?php wp_nonce_field( 'au_contact', 'au_contact_nonce' ); ?>
		<div class="au-form__hp" aria-hidden="true">
			<label for="au_website"><?php esc_html_e( 'Website', 'arcunify' ); ?></label>
			<input type="text" id="au_website" name="au_website" tabindex="-1" autocomplete="off">
		</div>
		<div class="au-form__grid">
			<?php foreach ( arcunify_form_fields() as $key => $field ) : ?>
				<?php
				list( $label, $type, $required, $autocomplete ) = $field;
				$id    = 'au_' . $key;
				$wide  = in_array( $type, array( 'textarea', 'select' ), true ) ? ' au-field--wide' : '';
				$req   = $required ? ' required aria-required="true"' : '';
				?>
				<div class="au-field<?php echo esc_attr( $wide ); ?>">
					<label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $label ); ?><?php echo $required ? ' <span class="au-field__req" aria-hidden="true">*</span>' : ' <span class="au-field__opt">' . esc_html__( '(optional)', 'arcunify' ) . '</span>'; // phpcs:ignore ?></label>
					<?php if ( 'textarea' === $type ) : ?>
						<textarea id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $id ); ?>" rows="5"<?php echo $req; // phpcs:ignore ?>></textarea>
					<?php elseif ( 'select' === $type ) : ?>
						<select id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $id ); ?>">
							<option value=""><?php esc_html_e( 'Not sure yet', 'arcunify' ); ?></option>
							<?php foreach ( arcunify_services() as $skey => $service ) : ?>
								<option value="<?php echo esc_attr( $skey ); ?>"><?php echo esc_html( $service['name'] ); ?></option>
							<?php endforeach; ?>
						</select>
					<?php else : ?>
						<input type="<?php echo esc_attr( $type ); ?>" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $id ); ?>" autocomplete="<?php echo esc_attr( $autocomplete ); ?>"<?php echo $req; // phpcs:ignore ?>>
					<?php endif; ?>
					<p class="au-field__error" id="<?php echo esc_attr( $id ); ?>-error" hidden></p>
				</div>
			<?php endforeach; ?>
		</div>
		<button class="au-btn au-btn--primary au-btn--block" type="submit"><span><?php echo esc_html( arcunify_mod( 'hero_cta1_label' ) ); ?></span><?php echo arcunify_icon( 'send', 'au-btn__icon' ); // phpcs:ignore ?></button>
		<?php if ( get_privacy_policy_url() ) : ?>
			<p class="au-form__privacy"><?php echo wp_kses_post( sprintf( /* translators: %s: privacy policy link. */ __( 'We use your details only to reply to your enquiry. See our %s.', 'arcunify' ), get_the_privacy_policy_link() ) ); ?></p>
		<?php endif; ?>
	</form>
<?php endif; ?>
