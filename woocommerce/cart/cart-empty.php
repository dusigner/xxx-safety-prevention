<?php
/**
 * Premium empty cart template.
 *
 * @package XXX_Safety_Prevention
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_cart_is_empty' );

if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
	<section class="xxx-cart-empty xxx-cart-animate">
		<div class="xxx-cart-empty__icon" aria-hidden="true">
			<?php echo xxx_safety_wc_icon( 'shield' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
		<p class="xxx-cart-eyebrow"><?php esc_html_e( 'Carrinho vazio', 'xxx-safety-prevention' ); ?></p>
		<h2><?php esc_html_e( 'Seu pedido ainda não começou.', 'xxx-safety-prevention' ); ?></h2>
		<p><?php esc_html_e( 'Explore os produtos de prevenção contra incêndio e monte uma compra segura para sua empresa, condomínio ou comércio.', 'xxx-safety-prevention' ); ?></p>
		<a class="button wc-backward" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>"><?php esc_html_e( 'Ver produtos', 'xxx-safety-prevention' ); ?></a>
	</section>
<?php endif; ?>
