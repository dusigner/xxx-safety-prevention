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

	wp_enqueue_style( 'xxx-safety-fonts', 'https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap', array(), null );
	wp_enqueue_style( 'xxx-safety-main', get_template_directory_uri() . '/assets/css/main.css', array( 'xxx-safety-fonts' ), $theme_version );
	wp_enqueue_style( 'xxx-safety-style', get_stylesheet_uri(), array( 'xxx-safety-main' ), $theme_version );

	wp_enqueue_script( 'xxx-safety-main', get_template_directory_uri() . '/assets/js/main.js', array(), $theme_version, true );
	wp_localize_script(
		'xxx-safety-main',
		'xxxSafetyData',
		array(
			'whatsapp' => xxx_safety_get_theme_mod( 'whatsapp_number', '' ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'xxx_safety_scripts' );
