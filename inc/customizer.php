<?php
/**
 * Customizer settings.
 *
 * @package XXX_Safety_Prevention
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function xxx_safety_get_theme_mod( $name, $default = '' ) {
	return get_theme_mod( 'xxx_safety_' . $name, $default );
}

function xxx_safety_sanitize_checkbox( $value ) {
	return (bool) $value;
}

function xxx_safety_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'xxx_safety_contact_section',
		array(
			'title'    => esc_html__( 'Contato e CTA', 'xxx-safety-prevention' ),
			'priority' => 30,
		)
	);

	$wp_customize->add_section(
		'xxx_safety_home_section',
		array(
			'title'    => esc_html__( 'Home Premium', 'xxx-safety-prevention' ),
			'priority' => 31,
		)
	);

	$wp_customize->add_section(
		'xxx_safety_forms_section',
		array(
			'title'    => esc_html__( 'Formulários e Leads', 'xxx-safety-prevention' ),
			'priority' => 32,
		)
	);

	$wp_customize->add_section(
		'xxx_safety_internal_pages',
		array(
			'title'    => esc_html__( 'Páginas Internas', 'xxx-safety-prevention' ),
			'priority' => 33,
		)
	);

	$wp_customize->add_section(
		'xxx_safety_privacy_section',
		array(
			'title'    => esc_html__( 'Privacidade e LGPD', 'xxx-safety-prevention' ),
			'priority' => 34,
		)
	);

	$contact_fields = array(
		'whatsapp_number' => array( 'Telefone/WhatsApp', '5511999999999', 'sanitize_text_field' ),
		'phone'           => array( 'Telefone Comercial', '(11) 3478-2200', 'sanitize_text_field' ),
		'email'           => array( 'E-mail', 'contato@empresa.com.br', 'sanitize_email' ),
		'address'         => array( 'Endereço', 'São Paulo - SP', 'sanitize_text_field' ),
		'main_cta_text'   => array( 'Texto do CTA principal', 'Solicitar Orçamento', 'sanitize_text_field' ),
		'main_cta_link'   => array( 'Link do CTA principal', '#contato', 'esc_url_raw' ),
		'social_links'    => array( 'Redes sociais (URLs separadas por vírgula)', 'https://instagram.com,https://facebook.com', 'sanitize_text_field' ),
	);

	foreach ( $contact_fields as $key => $field ) {
		$wp_customize->add_setting(
			'xxx_safety_' . $key,
			array(
				'default'           => $field[1],
				'sanitize_callback' => $field[2],
			)
		);

		$wp_customize->add_control(
			'xxx_safety_' . $key,
			array(
				'label'   => esc_html__( $field[0], 'xxx-safety-prevention' ),
				'section' => 'xxx_safety_contact_section',
				'type'    => 'text',
			)
		);
	}

	$wp_customize->add_setting(
		'xxx_safety_map_embed_url',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'xxx_safety_map_embed_url',
		array(
			'label'       => esc_html__( 'URL do mapa/embed', 'xxx-safety-prevention' ),
			'description' => esc_html__( 'Cole uma URL de embed segura (Google Maps ou similar).', 'xxx-safety-prevention' ),
			'section'     => 'xxx_safety_contact_section',
		)
	);

	$wp_customize->add_setting(
		'xxx_safety_hero_highlight',
		array(
			'default'           => 'Atendimento para empresas, condomínios e comércios',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'xxx_safety_hero_highlight',
		array(
			'label'   => esc_html__( 'Destaque do Hero', 'xxx-safety-prevention' ),
			'section' => 'xxx_safety_home_section',
		)
	);

	$wp_customize->add_setting(
		'xxx_safety_hero_image',
		array(
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'xxx_safety_hero_image',
			array(
				'label'   => esc_html__( 'Imagem Hero', 'xxx-safety-prevention' ),
				'section' => 'xxx_safety_home_section',
			)
		)
	);

	foreach ( array( 'brands', 'services', 'testimonials', 'faq', 'products' ) as $section_key ) {
		$wp_customize->add_setting(
			'xxx_safety_show_' . $section_key,
			array(
				'default'           => true,
				'sanitize_callback' => 'xxx_safety_sanitize_checkbox',
			)
		);
		$wp_customize->add_control(
			'xxx_safety_show_' . $section_key,
			array(
				'label'   => sprintf( 'Exibir seção: %s', ucfirst( $section_key ) ),
				'section' => 'xxx_safety_home_section',
				'type'    => 'checkbox',
			)
		);
	}

	$wp_customize->add_setting(
		'xxx_safety_quote_form_shortcode',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'xxx_safety_quote_form_shortcode',
		array(
			'label'   => esc_html__( 'Shortcode formulário de orçamento', 'xxx-safety-prevention' ),
			'section' => 'xxx_safety_forms_section',
		)
	);

	$form_controls = array(
		'contact_form_shortcode'     => 'Shortcode formulário de contato',
		'avcb_form_shortcode'        => 'Shortcode formulário de AVCB',
		'maintenance_form_shortcode' => 'Shortcode formulário de manutenção',
	);

	foreach ( $form_controls as $key => $label ) {
		$wp_customize->add_setting(
			'xxx_safety_' . $key,
			array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'xxx_safety_' . $key,
			array(
				'label'   => esc_html__( $label, 'xxx-safety-prevention' ),
				'section' => 'xxx_safety_forms_section',
			)
		);
	}

	$wp_customize->add_setting(
		'xxx_safety_internal_hero_default',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'xxx_safety_internal_hero_default',
			array(
				'label'   => esc_html__( 'Imagem padrão hero interno', 'xxx-safety-prevention' ),
				'section' => 'xxx_safety_internal_pages',
			)
		)
	);

	$wp_customize->add_setting(
		'xxx_safety_enable_animations',
		array(
			'default'           => true,
			'sanitize_callback' => 'xxx_safety_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'xxx_safety_enable_animations',
		array(
			'label'   => esc_html__( 'Ativar animações sutis', 'xxx-safety-prevention' ),
			'section' => 'xxx_safety_internal_pages',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'xxx_safety_enable_whatsapp_float',
		array(
			'default'           => true,
			'sanitize_callback' => 'xxx_safety_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'xxx_safety_enable_whatsapp_float',
		array(
			'label'   => esc_html__( 'Ativar botão flutuante do WhatsApp', 'xxx-safety-prevention' ),
			'section' => 'xxx_safety_contact_section',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'xxx_safety_enable_cookie_consent',
		array(
			'default'           => true,
			'sanitize_callback' => 'xxx_safety_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'xxx_safety_enable_cookie_consent',
		array(
			'label'   => esc_html__( 'Ativar banner de consentimento de cookies', 'xxx-safety-prevention' ),
			'section' => 'xxx_safety_privacy_section',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'xxx_safety_google_analytics_id',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'xxx_safety_google_analytics_id',
		array(
			'label'       => esc_html__( 'ID do Google Analytics 4', 'xxx-safety-prevention' ),
			'description' => esc_html__( 'Exemplo: G-XXXXXXXXXX. O script só será carregado após o aceite de cookies analíticos.', 'xxx-safety-prevention' ),
			'section'     => 'xxx_safety_privacy_section',
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'xxx_safety_quote_cta_text',
		array(
			'default'           => 'Solicitar orçamento técnico',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'xxx_safety_quote_cta_text',
		array(
			'label'   => esc_html__( 'Texto do CTA de orçamento', 'xxx-safety-prevention' ),
			'section' => 'xxx_safety_forms_section',
		)
	);

	$wp_customize->add_setting(
		'xxx_safety_primary_color',
		array(
			'default'           => '#ff6a00',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'xxx_safety_primary_color',
			array(
				'label'   => esc_html__( 'Cor principal', 'xxx-safety-prevention' ),
				'section' => 'xxx_safety_home_section',
			)
		)
	);
}
add_action( 'customize_register', 'xxx_safety_customize_register' );
