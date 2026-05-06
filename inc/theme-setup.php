<?php
/**
 * Theme setup and core supports.
 *
 * @package XXX_Safety_Prevention
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'xxx_safety_setup' ) ) {
	/**
	 * Configuração inicial do tema.
	 */
	function xxx_safety_setup() {
		load_theme_textdomain( 'xxx-safety-prevention', get_template_directory() . '/languages' );

		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'customize-selective-refresh-widgets' );
		add_theme_support(
			'html5',
			array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
		);
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 120,
				'width'       => 240,
				'flex-height' => true,
				'flex-width'  => true,
			)
		);

		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

		register_nav_menus(
			array(
				'primary' => esc_html__( 'Menu Principal', 'xxx-safety-prevention' ),
				'footer'  => esc_html__( 'Menu Rodapé', 'xxx-safety-prevention' ),
			)
		);
	}
}
add_action( 'after_setup_theme', 'xxx_safety_setup' );

/**
 * Sidebar principal.
 */
function xxx_safety_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar Principal', 'xxx-safety-prevention' ),
			'id'            => 'sidebar-1',
			'before_widget' => '<section id="%1$s" class="widget card %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'xxx_safety_widgets_init' );
