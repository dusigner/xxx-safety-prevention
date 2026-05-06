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

	wp_enqueue_style( 'xxx-safety-fonts', 'https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&family=Noto+Serif:wght@300;400;500;600;700&display=swap', array(), null );
	wp_enqueue_style( 'xxx-safety-main', get_template_directory_uri() . '/assets/css/main.css', array( 'xxx-safety-fonts' ), $theme_version );
	if ( is_front_page() ) {
		wp_enqueue_style( 'xxx-safety-front-page', get_template_directory_uri() . '/assets/css/front-page.css', array( 'xxx-safety-main' ), $theme_version );
		$style_deps = array( 'xxx-safety-front-page' );
	}
	wp_enqueue_style( 'xxx-safety-style', get_stylesheet_uri(), $style_deps, $theme_version );

	if ( is_front_page() && xxx_safety_get_theme_mod( 'enable_animations', true ) ) {
		wp_enqueue_script( 'gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js', array(), '3.12.5', true );
		wp_enqueue_script( 'gsap-scrolltrigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js', array( 'gsap' ), '3.12.5', true );
		$script_deps = array( 'gsap', 'gsap-scrolltrigger' );
	}

	wp_enqueue_script( 'xxx-safety-main', get_template_directory_uri() . '/assets/js/main.js', $script_deps, $theme_version, true );
	wp_localize_script(
		'xxx-safety-main',
		'xxxSafetyData',
		array(
			'whatsapp' => xxx_safety_get_theme_mod( 'whatsapp_number', '' ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'xxx_safety_scripts' );
