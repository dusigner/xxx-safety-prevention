<?php
/**
 * Premium cart totals.
 *
 * @package XXX_Safety_Prevention
 * @version 2.3.6
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="cart_totals <?php echo ( WC()->customer->has_calculated_shipping() ) ? 'calculated_shipping' : ''; ?>">
	<header class="xxx-cart-totals__header">
		<span><?php esc_html_e( 'Resumo do pedido', 'xxx-safety-prevention' ); ?></span>
		<h2><?php esc_html_e( 'Total da compra', 'xxx-safety-prevention' ); ?></h2>
	</header>

	<?php do_action( 'woocommerce_before_cart_totals' ); ?>

	<div class="xxx-cart-totals__rows">
		<div class="cart-subtotal xxx-cart-total-row">
			<span><?php esc_html_e( 'Subtotal', 'xxx-safety-prevention' ); ?></span>
			<strong data-title="<?php esc_attr_e( 'Subtotal', 'xxx-safety-prevention' ); ?>"><?php wc_cart_totals_subtotal_html(); ?></strong>
		</div>

		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<div class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?> xxx-cart-total-row">
				<span><?php wc_cart_totals_coupon_label( $coupon ); ?></span>
				<strong data-title="<?php echo esc_attr( wc_cart_totals_coupon_label( $coupon, false ) ); ?>"><?php wc_cart_totals_coupon_html( $coupon ); ?></strong>
			</div>
		<?php endforeach; ?>

		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
			<div class="xxx-cart-shipping-row">
				<?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>
				<span><?php esc_html_e( 'Entrega', 'xxx-safety-prevention' ); ?></span>
				<div data-title="<?php esc_attr_e( 'Entrega', 'xxx-safety-prevention' ); ?>"><?php wc_cart_totals_shipping_html(); ?></div>
				<?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>
			</div>
		<?php elseif ( WC()->cart->needs_shipping() && 'yes' === get_option( 'woocommerce_enable_shipping_calc' ) ) : ?>
			<div class="xxx-cart-shipping-row">
				<span><?php esc_html_e( 'Entrega', 'xxx-safety-prevention' ); ?></span>
				<div data-title="<?php esc_attr_e( 'Entrega', 'xxx-safety-prevention' ); ?>"><?php woocommerce_shipping_calculator(); ?></div>
			</div>
		<?php endif; ?>

		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<div class="fee xxx-cart-total-row">
				<span><?php echo esc_html( $fee->name ); ?></span>
				<strong data-title="<?php echo esc_attr( $fee->name ); ?>"><?php wc_cart_totals_fee_html( $fee ); ?></strong>
			</div>
		<?php endforeach; ?>

		<?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
			<?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
				<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
					<div class="tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?> xxx-cart-total-row">
						<span><?php echo esc_html( $tax->label ); ?></span>
						<strong data-title="<?php echo esc_attr( $tax->label ); ?>"><?php echo wp_kses_post( $tax->formatted_amount ); ?></strong>
					</div>
				<?php endforeach; ?>
			<?php else : ?>
				<div class="tax-total xxx-cart-total-row">
					<span><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></span>
					<strong data-title="<?php echo esc_attr( WC()->countries->tax_or_vat() ); ?>"><?php wc_cart_totals_taxes_total_html(); ?></strong>
				</div>
			<?php endif; ?>
		<?php endif; ?>

		<?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

		<div class="order-total xxx-cart-total-row xxx-cart-total-row--grand">
			<span><?php esc_html_e( 'Total', 'xxx-safety-prevention' ); ?></span>
			<strong data-title="<?php esc_attr_e( 'Total', 'xxx-safety-prevention' ); ?>"><?php wc_cart_totals_order_total_html(); ?></strong>
		</div>

		<?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>
	</div>

	<div class="wc-proceed-to-checkout">
		<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
	</div>

	<?php do_action( 'woocommerce_after_cart_totals' ); ?>
</div>
