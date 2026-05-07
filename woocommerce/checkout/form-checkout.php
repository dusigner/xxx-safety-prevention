<?php
/**
 * Premium checkout form.
 *
 * @package XXX_Safety_Prevention
 * @version 9.4.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_checkout_form', $checkout );

if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'Você precisa estar logado para finalizar a compra.', 'xxx-safety-prevention' ) ) );
	return;
}
?>

<section class="xxx-checkout-page" data-premium-checkout>
	<div class="xxx-checkout-atmosphere" aria-hidden="true">
		<span></span>
		<span></span>
		<span></span>
	</div>

	<header class="xxx-checkout-hero xxx-checkout-animate">
		<div>
			<p class="xxx-checkout-eyebrow"><?php esc_html_e( 'Checkout seguro', 'xxx-safety-prevention' ); ?></p>
			<h1><?php esc_html_e( 'Finalize sua compra com segurança.', 'xxx-safety-prevention' ); ?></h1>
		</div>
		<p><?php esc_html_e( 'Informe seus dados, confira entrega e pagamento, e conclua o pedido pelo fluxo protegido do WooCommerce.', 'xxx-safety-prevention' ); ?></p>
	</header>

	<form name="checkout" method="post" class="checkout woocommerce-checkout xxx-checkout-form" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
		<div class="xxx-checkout-layout">
			<div class="xxx-checkout-main">
				<?php if ( $checkout->get_checkout_fields() ) : ?>
					<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

					<section class="xxx-checkout-card xxx-checkout-animate" id="customer_details">
						<div class="xxx-checkout-card__header">
							<span><?php esc_html_e( 'Identificação', 'xxx-safety-prevention' ); ?></span>
							<h2><?php esc_html_e( 'Dados do cliente e entrega', 'xxx-safety-prevention' ); ?></h2>
						</div>

						<div class="xxx-checkout-fields">
							<div class="xxx-checkout-billing">
								<?php do_action( 'woocommerce_checkout_billing' ); ?>
							</div>

							<div class="xxx-checkout-shipping">
								<?php do_action( 'woocommerce_checkout_shipping' ); ?>
							</div>
						</div>
					</section>

					<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
				<?php endif; ?>

				<section class="xxx-checkout-card xxx-checkout-card--payment xxx-checkout-animate">
					<div class="xxx-checkout-card__header">
						<span><?php esc_html_e( 'Pagamento', 'xxx-safety-prevention' ); ?></span>
						<h2><?php esc_html_e( 'Método de pagamento', 'xxx-safety-prevention' ); ?></h2>
					</div>
					<?php woocommerce_checkout_payment(); ?>
				</section>
			</div>

			<aside class="xxx-checkout-summary xxx-checkout-animate">
				<div class="xxx-checkout-summary__inner">
					<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
					<header class="xxx-checkout-summary__header">
						<span><?php esc_html_e( 'Resumo do pedido', 'xxx-safety-prevention' ); ?></span>
						<h2 id="order_review_heading"><?php esc_html_e( 'Sua compra', 'xxx-safety-prevention' ); ?></h2>
					</header>
					<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
					<div id="order_review" class="woocommerce-checkout-review-order">
						<?php woocommerce_order_review(); ?>
					</div>
					<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

					<div class="xxx-checkout-trust" aria-label="<?php esc_attr_e( 'Informações de confiança', 'xxx-safety-prevention' ); ?>">
						<div><?php echo xxx_safety_wc_icon( 'shield' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span><?php esc_html_e( 'Compra segura', 'xxx-safety-prevention' ); ?></span></div>
						<div><?php echo xxx_safety_wc_icon( 'check' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span><?php esc_html_e( 'SSL ativo', 'xxx-safety-prevention' ); ?></span></div>
						<div><?php echo xxx_safety_wc_icon( 'award' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span><?php esc_html_e( 'Garantia', 'xxx-safety-prevention' ); ?></span></div>
						<div><?php echo xxx_safety_wc_icon( 'headset' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span><?php esc_html_e( 'Suporte técnico', 'xxx-safety-prevention' ); ?></span></div>
					</div>
				</div>
			</aside>
		</div>
	</form>
</section>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
