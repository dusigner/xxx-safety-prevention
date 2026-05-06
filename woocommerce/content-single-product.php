<?php
/**
 * Premium single product content.
 *
 * @package XXX_Safety_Prevention
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product instanceof WC_Product ) {
	$product = wc_get_product( get_the_ID() );
}

do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	return;
}

$shop_url   = wc_get_page_permalink( 'shop' );
$categories = wp_strip_all_tags( wc_get_product_category_list( $product->get_id(), ', ' ) );
$sku        = $product->get_sku();
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'xxx-product-page', $product ); ?>>
	<div class="xxx-product-ambient xxx-product-ambient--one" aria-hidden="true"></div>
	<div class="xxx-product-ambient xxx-product-ambient--two" aria-hidden="true"></div>

	<div class="xxx-product-shell">
		<aside class="xxx-product-media-column">
			<div class="xxx-product-media-sticky xxx-product-animate">
				<a class="xxx-product-back" href="<?php echo esc_url( $shop_url ); ?>">
					<span aria-hidden="true">←</span>
					<?php esc_html_e( 'Voltar', 'xxx-safety-prevention' ); ?>
				</a>

				<?php woocommerce_show_product_sale_flash(); ?>
				<?php xxx_safety_wc_render_product_gallery( $product ); ?>
				<?php do_action( 'woocommerce_before_single_product_summary' ); ?>
			</div>
		</aside>

		<section class="xxx-product-info-column">
			<header class="xxx-product-hero-copy xxx-product-animate">
				<p class="xxx-product-kicker">
					<?php echo esc_html( $categories ?: __( 'Produto WooCommerce', 'xxx-safety-prevention' ) ); ?>
					<span>•</span>
					<?php echo esc_html( $sku ? sprintf( __( 'SKU %s', 'xxx-safety-prevention' ), $sku ) : sprintf( __( 'ID %d', 'xxx-safety-prevention' ), $product->get_id() ) ); ?>
				</p>
			</header>

			<div class="xxx-product-summary-card xxx-product-animate" id="xxx-product-purchase">
				<?php do_action( 'woocommerce_single_product_summary' ); ?>
				<?php xxx_safety_wc_render_product_trust( $product ); ?>
			</div>

			<?php xxx_safety_wc_render_product_highlights( $product ); ?>
			<?php xxx_safety_wc_render_product_panels( $product ); ?>

			<?php do_action( 'woocommerce_after_single_product_summary' ); ?>
			<?php xxx_safety_wc_render_related_products(); ?>
		</section>
	</div>

	<?php xxx_safety_wc_render_mobile_purchase_bar( $product ); ?>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
