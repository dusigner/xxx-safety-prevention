<?php
/**
 * Product archive override.
 *
 * @package XXX_Safety_Prevention
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

do_action( 'woocommerce_before_main_content' );

$total_products = wc_get_loop_prop( 'total' );
$categories     = get_terms(
	array(
		'taxonomy'   => 'product_cat',
		'hide_empty' => true,
		'number'     => 6,
	)
);
$category_count = wp_count_terms(
	array(
		'taxonomy'   => 'product_cat',
		'hide_empty' => true,
	)
);
?>
<div class="xxx-shop-page">
	<div class="xxx-shop-ambient xxx-shop-ambient--one" aria-hidden="true"></div>
	<div class="xxx-shop-ambient xxx-shop-ambient--two" aria-hidden="true"></div>

	<header class="woocommerce-products-header xxx-shop-hero xxx-shop-animate">
		<div class="xxx-shop-hero__copy">
			<p class="xxx-shop-kicker"><?php esc_html_e( 'Catálogo técnico', 'xxx-safety-prevention' ); ?></p>
			<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
				<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
			<?php endif; ?>
			<p><?php esc_html_e( 'Equipamentos para prevenção, combate inicial e conformidade contra incêndio, com compra simples e suporte especializado para empresas, condomínios e comércios.', 'xxx-safety-prevention' ); ?></p>
			<div class="xxx-shop-hero__actions">
				<a class="btn" href="#xxx-shop-products"><?php esc_html_e( 'Ver produtos', 'xxx-safety-prevention' ); ?></a>
				<a class="btn btn-outline" href="<?php echo esc_url( xxx_safety_get_theme_mod( 'main_cta_link', '#contato' ) ); ?>"><?php esc_html_e( 'Solicitar orientação', 'xxx-safety-prevention' ); ?></a>
			</div>
		</div>

		<div class="xxx-shop-hero__panel" aria-label="<?php esc_attr_e( 'Indicadores da loja', 'xxx-safety-prevention' ); ?>">
			<div>
				<span><?php esc_html_e( 'Produtos', 'xxx-safety-prevention' ); ?></span>
				<strong><?php echo esc_html( $total_products ?: wp_count_posts( 'product' )->publish ); ?></strong>
			</div>
			<div>
				<span><?php esc_html_e( 'Categorias', 'xxx-safety-prevention' ); ?></span>
				<strong><?php echo esc_html( is_wp_error( $category_count ) ? '0' : $category_count ); ?></strong>
			</div>
			<div>
				<span><?php esc_html_e( 'Compra', 'xxx-safety-prevention' ); ?></span>
				<strong><?php esc_html_e( 'Segura', 'xxx-safety-prevention' ); ?></strong>
			</div>
			<div>
				<span><?php esc_html_e( 'Suporte', 'xxx-safety-prevention' ); ?></span>
				<strong><?php esc_html_e( 'Técnico', 'xxx-safety-prevention' ); ?></strong>
			</div>
		</div>
	</header>

	<?php if ( ! is_wp_error( $categories ) && ! empty( $categories ) ) : ?>
		<nav class="xxx-shop-categories xxx-shop-animate" aria-label="<?php esc_attr_e( 'Categorias de produtos', 'xxx-safety-prevention' ); ?>">
			<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"><?php esc_html_e( 'Todos', 'xxx-safety-prevention' ); ?></a>
			<?php foreach ( $categories as $category ) : ?>
				<a href="<?php echo esc_url( get_term_link( $category ) ); ?>"><?php echo esc_html( $category->name ); ?></a>
			<?php endforeach; ?>
		</nav>
	<?php endif; ?>

	<section class="xxx-shop-products xxx-shop-animate" id="xxx-shop-products" aria-label="<?php esc_attr_e( 'Lista de produtos', 'xxx-safety-prevention' ); ?>">
<?php
if ( woocommerce_product_loop() ) {
	do_action( 'woocommerce_before_shop_loop' );
	woocommerce_product_loop_start();

	if ( wc_get_loop_prop( 'total' ) ) {
		while ( have_posts() ) {
			the_post();
			do_action( 'woocommerce_shop_loop' );
			wc_get_template_part( 'content', 'product' );
		}
	}

	woocommerce_product_loop_end();
	do_action( 'woocommerce_after_shop_loop' );
} else {
	do_action( 'woocommerce_no_products_found' );
}
?>
	</section>
</div>
<?php

do_action( 'woocommerce_after_main_content' );
get_footer( 'shop' );
