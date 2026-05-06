<?php
/**
 * Footer template.
 *
 * @package XXX_Safety_Prevention
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$whatsapp = preg_replace( '/\D+/', '', xxx_safety_get_theme_mod( 'whatsapp_number', '' ) );
$email    = xxx_safety_get_theme_mod( 'email', '' );
$phone    = xxx_safety_get_theme_mod( 'phone', '' );
?>
<footer class="site-footer" id="contato">
	<div class="container footer-grid">
		<div>
			<h3><?php bloginfo( 'name' ); ?></h3>
			<p><?php echo esc_html( xxx_safety_get_theme_mod( 'address', 'São Paulo - SP' ) ); ?></p>
			<?php if ( $phone ) : ?><p><?php echo esc_html( $phone ); ?></p><?php endif; ?>
			<?php if ( $email ) : ?><p><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></p><?php endif; ?>
		</div>
		<div>
			<h4><?php esc_html_e( 'Navegação', 'xxx-safety-prevention' ); ?></h4>
			<?php wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'fallback_cb' => false ) ); ?>
		</div>
		<div>
			<h4><?php esc_html_e( 'Atendimento Rápido', 'xxx-safety-prevention' ); ?></h4>
			<p><?php esc_html_e( 'Equipe técnica pronta para diagnosticar e orientar sua empresa.', 'xxx-safety-prevention' ); ?></p>
			<?php if ( ! empty( $whatsapp ) ) : ?>
				<a class="btn" href="<?php echo esc_url( 'https://wa.me/' . $whatsapp ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'WhatsApp Comercial', 'xxx-safety-prevention' ); ?></a>
			<?php endif; ?>
		</div>
	</div>
	<div class="footer-bottom"><p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>.</p></div>
</footer>

<?php if ( ! empty( $whatsapp ) && xxx_safety_get_theme_mod( 'enable_whatsapp_float', true ) ) : ?>
	<a href="<?php echo esc_url( 'https://wa.me/' . $whatsapp ); ?>" class="whatsapp-float" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp">
		<span>WhatsApp</span>
	</a>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
