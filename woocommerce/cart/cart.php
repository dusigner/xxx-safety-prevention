<?php
/**
 * Premium cart template.
 *
 * @package XXX_Safety_Prevention
 * @version 7.9.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' );
?>

<section class="xxx-cart-page" data-premium-cart>
	<div class="xxx-cart-atmosphere" aria-hidden="true">
		<span></span>
		<span></span>
		<span></span>
	</div>

	<header class="xxx-cart-hero xxx-cart-animate">
		<div>
			<p class="xxx-cart-eyebrow"><?php esc_html_e( 'Carrinho seguro', 'xxx-safety-prevention' ); ?></p>
			<h1><?php esc_html_e( 'Revise seu pedido com precisão técnica.', 'xxx-safety-prevention' ); ?></h1>
		</div>
		<p><?php esc_html_e( 'Confira quantidades, entrega e totais antes de seguir para uma compra protegida pelo fluxo nativo do WooCommerce.', 'xxx-safety-prevention' ); ?></p>
	</header>

	<?php wc_print_notices(); ?>

	<?php if ( WC()->cart && ! WC()->cart->is_empty() ) : ?>
		<div class="xxx-cart-layout">
			<form class="woocommerce-cart-form xxx-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
				<?php do_action( 'woocommerce_before_cart_table' ); ?>

				<div class="xxx-cart-items" aria-label="<?php esc_attr_e( 'Produtos no carrinho', 'xxx-safety-prevention' ); ?>">
					<div class="xxx-cart-section-heading xxx-cart-animate">
						<div>
							<span><?php esc_html_e( 'Produtos selecionados', 'xxx-safety-prevention' ); ?></span>
							<h2><?php esc_html_e( 'Itens do pedido', 'xxx-safety-prevention' ); ?></h2>
						</div>
						<strong><?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?></strong>
					</div>

					<?php do_action( 'woocommerce_before_cart_contents' ); ?>

					<?php
					foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
						$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
						$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

						if ( ! $_product || ! $_product->exists() || $cart_item['quantity'] <= 0 || ! apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
							continue;
						}

						$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
						$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
						?>
						<article class="xxx-cart-item xxx-cart-animate <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>" data-cart-item>
							<div class="xxx-cart-item__media">
								<?php
								$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image( 'woocommerce_thumbnail', array( 'loading' => 'lazy', 'decoding' => 'async' ) ), $cart_item, $cart_item_key );

								if ( ! $product_permalink ) {
									echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								} else {
									printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								}
								?>
							</div>

							<div class="xxx-cart-item__body">
								<div class="xxx-cart-item__main">
									<div>
										<?php
										if ( ! $product_permalink ) {
											echo '<h3>' . wp_kses_post( $product_name ) . '</h3>';
										} else {
											echo '<h3><a href="' . esc_url( $product_permalink ) . '">' . wp_kses_post( $product_name ) . '</a></h3>';
										}

										do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

										echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

										if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
											echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Disponível por encomenda', 'xxx-safety-prevention' ) . '</p>', $product_id ) );
										}
										?>
									</div>

									<?php
									echo apply_filters(
										'woocommerce_cart_item_remove_link',
										sprintf(
											'<a href="%s" class="xxx-cart-item__remove remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"><span aria-hidden="true">&times;</span>%s</a>',
											esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
											esc_attr( sprintf( __( 'Remover %s do carrinho', 'xxx-safety-prevention' ), wp_strip_all_tags( $product_name ) ) ),
											esc_attr( $product_id ),
											esc_attr( $_product->get_sku() ),
											esc_html__( 'Remover', 'xxx-safety-prevention' )
										),
										$cart_item_key
									); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									?>
								</div>

								<div class="xxx-cart-item__meta">
									<div>
										<span><?php esc_html_e( 'Preço unitário', 'xxx-safety-prevention' ); ?></span>
										<strong><?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
									</div>

									<div>
										<span><?php esc_html_e( 'Quantidade', 'xxx-safety-prevention' ); ?></span>
										<div class="xxx-cart-quantity" data-cart-quantity>
											<button type="button" data-cart-qty-minus aria-label="<?php esc_attr_e( 'Diminuir quantidade', 'xxx-safety-prevention' ); ?>">-</button>
											<?php
											if ( $_product->is_sold_individually() ) {
												$min_quantity = 1;
												$max_quantity = 1;
											} else {
												$min_quantity = 0;
												$max_quantity = $_product->get_max_purchase_quantity();
											}

											$product_quantity = woocommerce_quantity_input(
												array(
													'input_name'   => "cart[{$cart_item_key}][qty]",
													'input_value'  => $cart_item['quantity'],
													'max_value'    => $max_quantity,
													'min_value'    => $min_quantity,
													'product_name' => $product_name,
												),
												$_product,
												false
											);

											echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
											?>
											<button type="button" data-cart-qty-plus aria-label="<?php esc_attr_e( 'Aumentar quantidade', 'xxx-safety-prevention' ); ?>">+</button>
										</div>
									</div>

									<div class="xxx-cart-item__subtotal">
										<span><?php esc_html_e( 'Subtotal', 'xxx-safety-prevention' ); ?></span>
										<strong><?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
									</div>
								</div>
							</div>
						</article>
						<?php
					}
					?>

					<?php do_action( 'woocommerce_cart_contents' ); ?>

					<div class="xxx-cart-actions xxx-cart-animate">
						<?php if ( wc_coupons_enabled() ) : ?>
							<div class="coupon xxx-cart-coupon">
								<label for="coupon_code" class="screen-reader-text"><?php esc_html_e( 'Cupom:', 'xxx-safety-prevention' ); ?></label>
								<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Código de cupom', 'xxx-safety-prevention' ); ?>" />
								<button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Aplicar cupom', 'xxx-safety-prevention' ); ?>"><?php esc_html_e( 'Aplicar', 'xxx-safety-prevention' ); ?></button>
								<?php do_action( 'woocommerce_cart_coupon' ); ?>
							</div>
						<?php endif; ?>

						<button type="submit" class="button xxx-cart-update" name="update_cart" value="<?php esc_attr_e( 'Atualizar carrinho', 'xxx-safety-prevention' ); ?>"><?php esc_html_e( 'Atualizar carrinho', 'xxx-safety-prevention' ); ?></button>

						<?php do_action( 'woocommerce_cart_actions' ); ?>
						<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
					</div>

					<?php do_action( 'woocommerce_after_cart_contents' ); ?>
				</div>

				<?php do_action( 'woocommerce_after_cart_table' ); ?>
			</form>

			<aside class="xxx-cart-summary xxx-cart-animate">
				<div class="xxx-cart-summary__inner">
					<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>
					<div class="cart-collaterals">
						<?php do_action( 'woocommerce_cart_collaterals' ); ?>
					</div>

					<div class="xxx-cart-trust" aria-label="<?php esc_attr_e( 'Informações de confiança', 'xxx-safety-prevention' ); ?>">
						<div>
							<?php echo xxx_safety_wc_icon( 'shield' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							<span><?php esc_html_e( 'Compra segura', 'xxx-safety-prevention' ); ?></span>
						</div>
						<div>
							<?php echo xxx_safety_wc_icon( 'check' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							<span><?php esc_html_e( 'SSL protegido', 'xxx-safety-prevention' ); ?></span>
						</div>
						<div>
							<?php echo xxx_safety_wc_icon( 'truck' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							<span><?php esc_html_e( 'Entrega calculada', 'xxx-safety-prevention' ); ?></span>
						</div>
						<div>
							<?php echo xxx_safety_wc_icon( 'headset' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							<span><?php esc_html_e( 'Suporte técnico', 'xxx-safety-prevention' ); ?></span>
						</div>
					</div>
				</div>
			</aside>
		</div>

	<?php else : ?>
		<?php wc_get_template( 'cart/cart-empty.php' ); ?>
	<?php endif; ?>
</section>

<?php do_action( 'woocommerce_after_cart' ); ?>
