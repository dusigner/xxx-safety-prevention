<?php
/**
 * Quote CTA.
 *
 * @package XXX_Safety_Prevention
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$text = xxx_safety_get_theme_mod( 'quote_cta_text', 'Solicitar orçamento técnico' );
$link = xxx_safety_get_theme_mod( 'main_cta_link', '#contato' );
?>
<section class="quote-inline card xxx-animate xxx-fade-up">
	<h3><?php echo esc_html( $text ); ?></h3>
	<p><?php esc_html_e( 'Receba retorno comercial com escopo recomendado para o seu cenário.', 'xxx-safety-prevention' ); ?></p>
	<a class="btn" href="<?php echo esc_url( $link ); ?>"><?php esc_html_e( 'Iniciar atendimento', 'xxx-safety-prevention' ); ?></a>
</section>
