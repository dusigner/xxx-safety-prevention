<?php
/**
 * Contact Form 7 compatibility helpers.
 *
 * @package XXX_Safety_Prevention
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Check if Contact Form 7 is active.
 *
 * @return bool
 */
function xxx_safety_is_cf7_active() {
	return defined( 'WPCF7_VERSION' ) || class_exists( 'WPCF7' );
}

/**
 * Render a form shortcode with fallback.
 *
 * @param string $mod_name Theme mod key suffix.
 * @param string $fallback_text Fallback text.
 * @param string $form_type Form type for dataset.
 */
function xxx_safety_render_form_block( $mod_name, $fallback_text, $form_type = 'general' ) {
	$shortcode = trim( (string) xxx_safety_get_theme_mod( $mod_name, '' ) );
	?>
	<div class="xxx-form-shell card js-lead-form" data-form-type="<?php echo esc_attr( $form_type ); ?>" data-source-page="<?php echo esc_attr( get_queried_object_id() ? get_post_field( 'post_name', get_queried_object_id() ) : 'global' ); ?>">
		<?php if ( xxx_safety_is_cf7_active() && ! empty( $shortcode ) ) : ?>
			<?php echo do_shortcode( $shortcode ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		<?php else : ?>
			<div class="xxx-form-fallback">
				<p><?php echo esc_html( $fallback_text ); ?></p>
				<?php if ( is_admin() ) : ?>
					<p><?php esc_html_e( 'Ative o Contact Form 7 e configure os shortcodes no Customizer.', 'xxx-safety-prevention' ); ?></p>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
	<?php
}

/**
 * Add admin notice when CF7 is not active.
 */
function xxx_safety_cf7_admin_notice() {
	if ( ! current_user_can( 'manage_options' ) || xxx_safety_is_cf7_active() ) {
		return;
	}

	echo '<div class="notice notice-info"><p>';
	echo esc_html__( 'XXX Safety Prevention: Para capturar leads com visual premium, instale/ative o plugin Contact Form 7 e adicione os shortcodes no Customizer.', 'xxx-safety-prevention' );
	echo '</p></div>';
}
add_action( 'admin_notices', 'xxx_safety_cf7_admin_notice' );
