<?php
/**
 * Contact info card.
 *
 * @package XXX_Safety_Prevention
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<aside class="card contact-info xxx-animate xxx-reveal xxx-delay-1">
	<h3><?php esc_html_e( 'Canais de atendimento', 'xxx-safety-prevention' ); ?></h3>
	<ul>
		<li><strong>WhatsApp:</strong> <?php echo esc_html( xxx_safety_get_theme_mod( 'whatsapp_number', '' ) ); ?></li>
		<li><strong><?php esc_html_e( 'Telefone:', 'xxx-safety-prevention' ); ?></strong> <?php echo esc_html( xxx_safety_get_theme_mod( 'phone', '' ) ); ?></li>
		<li><strong><?php esc_html_e( 'E-mail:', 'xxx-safety-prevention' ); ?></strong> <?php echo esc_html( xxx_safety_get_theme_mod( 'email', '' ) ); ?></li>
		<li><strong><?php esc_html_e( 'Endereço:', 'xxx-safety-prevention' ); ?></strong> <?php echo esc_html( xxx_safety_get_theme_mod( 'address', '' ) ); ?></li>
	</ul>
	<p><strong><?php esc_html_e( 'Horário:', 'xxx-safety-prevention' ); ?></strong> <?php esc_html_e( 'Seg a Sex · 08h às 18h', 'xxx-safety-prevention' ); ?></p>
	<p><?php esc_html_e( 'Atendimento corporativo para empresas, condomínios e comércios.', 'xxx-safety-prevention' ); ?></p>
</aside>
