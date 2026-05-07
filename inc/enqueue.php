<?php
/**
 * Enqueue scripts and styles.
 *
 * @package XXX_Safety_Prevention
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registra assets.
 */
function xxx_safety_scripts() {
	$theme_version = wp_get_theme()->get( 'Version' );
	$script_deps   = array();
	$style_deps    = array( 'xxx-safety-main' );
	$main_css_path = get_template_directory() . '/assets/css/main.css';
	$header_css_path = get_template_directory() . '/assets/css/header.css';
	$home_css_path = get_template_directory() . '/assets/css/front-page.css';
	$archive_css_path = get_template_directory() . '/assets/css/product-archive.css';
	$product_css_path = get_template_directory() . '/assets/css/single-product.css';
	$cart_css_path = get_template_directory() . '/assets/css/cart.css';
	$checkout_css_path = get_template_directory() . '/assets/css/checkout.css';
	$main_js_path  = get_template_directory() . '/assets/js/main.js';
	$header_js_path = get_template_directory() . '/assets/js/header.js';
	$archive_js_path = get_template_directory() . '/assets/js/product-archive.js';
	$product_js_path = get_template_directory() . '/assets/js/single-product.js';
	$cart_js_path = get_template_directory() . '/assets/js/cart.js';
	$checkout_js_path = get_template_directory() . '/assets/js/checkout.js';
	$style_path    = get_stylesheet_directory() . '/style.css';
	$main_css_ver  = file_exists( $main_css_path ) ? (string) filemtime( $main_css_path ) : $theme_version;
	$header_css_ver = file_exists( $header_css_path ) ? (string) filemtime( $header_css_path ) : $theme_version;
	$home_css_ver  = file_exists( $home_css_path ) ? (string) filemtime( $home_css_path ) : $theme_version;
	$archive_css_ver = file_exists( $archive_css_path ) ? (string) filemtime( $archive_css_path ) : $theme_version;
	$product_css_ver = file_exists( $product_css_path ) ? (string) filemtime( $product_css_path ) : $theme_version;
	$cart_css_ver = file_exists( $cart_css_path ) ? (string) filemtime( $cart_css_path ) : $theme_version;
	$checkout_css_ver = file_exists( $checkout_css_path ) ? (string) filemtime( $checkout_css_path ) : $theme_version;
	$main_js_ver   = file_exists( $main_js_path ) ? (string) filemtime( $main_js_path ) : $theme_version;
	$header_js_ver = file_exists( $header_js_path ) ? (string) filemtime( $header_js_path ) : $theme_version;
	$archive_js_ver = file_exists( $archive_js_path ) ? (string) filemtime( $archive_js_path ) : $theme_version;
	$product_js_ver = file_exists( $product_js_path ) ? (string) filemtime( $product_js_path ) : $theme_version;
	$cart_js_ver = file_exists( $cart_js_path ) ? (string) filemtime( $cart_js_path ) : $theme_version;
	$checkout_js_ver = file_exists( $checkout_js_path ) ? (string) filemtime( $checkout_js_path ) : $theme_version;
	$style_ver     = file_exists( $style_path ) ? (string) filemtime( $style_path ) : $theme_version;
	$is_product    = function_exists( 'is_product' ) && is_product();
	$is_product_archive = function_exists( 'is_shop' ) && ( is_shop() || ( function_exists( 'is_product_taxonomy' ) && is_product_taxonomy() ) );
	$is_cart       = function_exists( 'is_cart' ) && is_cart();
	$is_checkout   = function_exists( 'is_checkout' ) && is_checkout() && ( ! function_exists( 'is_order_received_page' ) || ! is_order_received_page() );

	wp_enqueue_style( 'xxx-safety-fonts', 'https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&family=Noto+Serif:wght@300;400;500;600;700&display=swap', array(), null );
	wp_enqueue_style( 'xxx-safety-main', get_template_directory_uri() . '/assets/css/main.css', array( 'xxx-safety-fonts' ), $main_css_ver );
	if ( is_front_page() ) {
		wp_enqueue_style( 'xxx-safety-front-page', get_template_directory_uri() . '/assets/css/front-page.css', array( 'xxx-safety-main' ), $home_css_ver );
		$style_deps = array( 'xxx-safety-front-page' );
	}
	if ( $is_product_archive ) {
		wp_enqueue_style( 'xxx-safety-product-archive', get_template_directory_uri() . '/assets/css/product-archive.css', array( 'xxx-safety-main' ), $archive_css_ver );
		$style_deps = array( 'xxx-safety-product-archive' );
	}
	if ( $is_product ) {
		wp_enqueue_style( 'xxx-safety-single-product', get_template_directory_uri() . '/assets/css/single-product.css', array( 'xxx-safety-main' ), $product_css_ver );
		$style_deps = array( 'xxx-safety-single-product' );
	}
	if ( $is_cart ) {
		wp_enqueue_style( 'xxx-safety-cart', get_template_directory_uri() . '/assets/css/cart.css', array( 'xxx-safety-main' ), $cart_css_ver );
		$style_deps = array( 'xxx-safety-cart' );
	}
	if ( $is_checkout ) {
		wp_enqueue_style( 'xxx-safety-checkout', get_template_directory_uri() . '/assets/css/checkout.css', array( 'xxx-safety-main' ), $checkout_css_ver );
		$style_deps = array( 'xxx-safety-checkout' );
	}
	wp_enqueue_style( 'xxx-safety-header', get_template_directory_uri() . '/assets/css/header.css', $style_deps, $header_css_ver );
	$style_deps = array( 'xxx-safety-header' );
	wp_enqueue_style( 'xxx-safety-style', get_stylesheet_uri(), $style_deps, $style_ver );

	if ( xxx_safety_get_theme_mod( 'enable_animations', true ) ) {
		wp_enqueue_script( 'gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js', array(), '3.12.5', true );
		wp_enqueue_script( 'gsap-scrolltrigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js', array( 'gsap' ), '3.12.5', true );
		$script_deps = array( 'gsap', 'gsap-scrolltrigger' );
	}

	wp_enqueue_script( 'xxx-safety-main', get_template_directory_uri() . '/assets/js/main.js', $script_deps, $main_js_ver, true );
	$header_script_deps = array_merge( array( 'xxx-safety-main' ), $script_deps );
	if ( function_exists( 'WC' ) ) {
		wp_enqueue_script( 'wc-cart-fragments' );
		$header_script_deps[] = 'wc-cart-fragments';
	}
	wp_enqueue_script( 'xxx-safety-header', get_template_directory_uri() . '/assets/js/header.js', $header_script_deps, $header_js_ver, true );
	if ( $is_product_archive ) {
		wp_enqueue_script( 'xxx-safety-product-archive', get_template_directory_uri() . '/assets/js/product-archive.js', array_merge( array( 'xxx-safety-main' ), $script_deps ), $archive_js_ver, true );
	}
	if ( $is_product ) {
		wp_enqueue_script( 'xxx-safety-single-product', get_template_directory_uri() . '/assets/js/single-product.js', array_merge( array( 'xxx-safety-main' ), $script_deps ), $product_js_ver, true );
	}
	if ( $is_cart ) {
		wp_enqueue_script( 'xxx-safety-cart', get_template_directory_uri() . '/assets/js/cart.js', array_merge( array( 'xxx-safety-main', 'xxx-safety-header' ), $script_deps ), $cart_js_ver, true );
	}
	if ( $is_checkout ) {
		wp_enqueue_script( 'xxx-safety-checkout', get_template_directory_uri() . '/assets/js/checkout.js', array_merge( array( 'xxx-safety-main', 'xxx-safety-header' ), $script_deps ), $checkout_js_ver, true );
	}
	wp_localize_script(
		'xxx-safety-main',
		'xxxSafetyData',
		array(
			'whatsapp' => xxx_safety_get_theme_mod( 'whatsapp_number', '' ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'xxx_safety_scripts' );
