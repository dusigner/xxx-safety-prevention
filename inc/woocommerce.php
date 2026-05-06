<?php
/**
 * WooCommerce integrations.
 *
 * @package XXX_Safety_Prevention
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function xxx_safety_woocommerce_support_customizations() {
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
	add_action( 'woocommerce_before_main_content', 'xxx_safety_wrapper_start', 10 );
	add_action( 'woocommerce_before_main_content', 'xxx_safety_wc_section_intro', 15 );
	add_action( 'woocommerce_after_main_content', 'xxx_safety_wrapper_end', 10 );
}
add_action( 'wp', 'xxx_safety_woocommerce_support_customizations' );

function xxx_safety_wrapper_start() {
	echo '<main id="primary" class="site-main site-main-shop"><div class="container">';
}

function xxx_safety_wrapper_end() {
	echo '</div></main>';
}

function xxx_safety_wc_section_intro() {
	if ( is_product() ) {
		return;
	}

	$title = '';
	if ( is_cart() ) {
		$title = esc_html__( 'Carrinho', 'xxx-safety-prevention' );
	} elseif ( is_checkout() ) {
		$title = esc_html__( 'Finalizar Compra', 'xxx-safety-prevention' );
	} elseif ( is_account_page() ) {
		$title = esc_html__( 'Minha Conta', 'xxx-safety-prevention' );
	}

	if ( ! $title ) {
		return;
	}

	echo '<header class="woocommerce-products-header">';
	echo '<p class="eyebrow">' . esc_html__( 'WooCommerce Premium', 'xxx-safety-prevention' ) . '</p>';
	echo '<h1 class="woocommerce-products-header__title page-title">' . esc_html( $title ) . '</h1>';
	echo '</header>';
}

function xxx_safety_wc_add_to_cart_text( $text ) {
	if ( is_shop() || is_product_taxonomy() ) {
		return esc_html__( 'Comprar agora', 'xxx-safety-prevention' );
	}

	return $text;
}
add_filter( 'woocommerce_product_add_to_cart_text', 'xxx_safety_wc_add_to_cart_text' );

function xxx_safety_wc_sale_badge() {
	return '<span class="onsale">Oferta</span>';
}
add_filter( 'woocommerce_sale_flash', 'xxx_safety_wc_sale_badge' );

function xxx_safety_wc_products_per_row() {
	return wp_is_mobile() ? 2 : 3;
}
add_filter( 'loop_shop_columns', 'xxx_safety_wc_products_per_row' );

function xxx_safety_wc_single_product_extras() {
	if ( ! is_product() ) {
		return;
	}
	$whatsapp = preg_replace( '/\D+/', '', xxx_safety_get_theme_mod( 'whatsapp_number', '' ) );
	?>
	<section class="xxx-wc-quote card xxx-animate xxx-fade-up">
		<h3><?php esc_html_e( 'Solicitar orçamento técnico', 'xxx-safety-prevention' ); ?></h3>
		<p><?php esc_html_e( 'Este produto pode ser dimensionado por risco de ocupação e exigência normativa.', 'xxx-safety-prevention' ); ?></p>
		<div class="hero-cta">
			<a class="btn" href="<?php echo esc_url( xxx_safety_get_theme_mod( 'main_cta_link', '#contato' ) ); ?>"><?php esc_html_e( 'Abrir formulário de orçamento', 'xxx-safety-prevention' ); ?></a>
			<?php if ( $whatsapp ) : ?>
				<a class="btn btn-outline" href="<?php echo esc_url( 'https://wa.me/' . $whatsapp ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Falar no WhatsApp', 'xxx-safety-prevention' ); ?></a>
			<?php endif; ?>
		</div>
		<ul class="check-list">
			<li><?php esc_html_e( 'Atendimento especializado para empresas, condomínios e operações industriais.', 'xxx-safety-prevention' ); ?></li>
			<li><?php esc_html_e( 'Indicado para: áreas administrativas, técnicas e comerciais com exigência de conformidade.', 'xxx-safety-prevention' ); ?></li>
			<li><?php esc_html_e( 'Também ajudamos com instalação, recarga e manutenção periódica.', 'xxx-safety-prevention' ); ?></li>
		</ul>
	</section>
	<?php
}
add_action( 'woocommerce_after_single_product_summary', 'xxx_safety_wc_single_product_extras', 25 );
