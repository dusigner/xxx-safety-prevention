<?php
/**
 * Demo content importer.
 *
 * @package XXX_Safety_Prevention
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Caminho do arquivo JSON de conteúdo demo.
 *
 * @return string
 */
function xxx_demo_content_json_path() {
	return trailingslashit( get_template_directory() ) . 'assets/demo-content/content.json';
}

/**
 * Gera conteúdo HTML de FAQ baseado no array.
 *
 * @param array $faq_items Itens FAQ.
 * @return string
 */
function xxx_demo_build_faq_html( $faq_items ) {
	if ( empty( $faq_items ) || ! is_array( $faq_items ) ) {
		return '';
	}

	$html  = '<h2>Perguntas Frequentes</h2>';
	$html .= '<div class="faq-items">';

	foreach ( $faq_items as $faq ) {
		$question = isset( $faq['pergunta'] ) ? sanitize_text_field( $faq['pergunta'] ) : '';
		$answer   = isset( $faq['resposta'] ) ? wp_kses_post( $faq['resposta'] ) : '';

		if ( '' === $question && '' === $answer ) {
			continue;
		}

		$html .= '<h3>' . esc_html( $question ) . '</h3>';
		$html .= '<p>' . wp_kses_post( $answer ) . '</p>';
	}

	$html .= '</div>';

	return $html;
}

/**
 * Gera conteúdo HTML de depoimentos baseado no array.
 *
 * @param array $testimonials Depoimentos.
 * @return string
 */
function xxx_demo_build_testimonials_html( $testimonials ) {
	if ( empty( $testimonials ) || ! is_array( $testimonials ) ) {
		return '';
	}

	$html  = '<h2>Depoimentos</h2>';
	$html .= '<div class="testimonials-items">';

	foreach ( $testimonials as $testimonial ) {
		$name    = isset( $testimonial['nome'] ) ? sanitize_text_field( $testimonial['nome'] ) : '';
		$type    = isset( $testimonial['tipo_cliente'] ) ? sanitize_text_field( $testimonial['tipo_cliente'] ) : '';
		$comment = isset( $testimonial['comentario'] ) ? wp_kses_post( $testimonial['comentario'] ) : '';

		if ( '' === $name && '' === $comment ) {
			continue;
		}

		$html .= '<blockquote>';
		$html .= '<p>' . wp_kses_post( $comment ) . '</p>';
		$html .= '<cite>' . esc_html( trim( $name . ( $type ? ' — ' . $type : '' ) ) ) . '</cite>';
		$html .= '</blockquote>';
	}

	$html .= '</div>';

	return $html;
}

/**
 * Cria ou atualiza post por slug.
 *
 * @param array $args Dados do post.
 * @return array
 */
function xxx_demo_upsert_post_by_slug( $args ) {
	$defaults = array(
		'post_type'    => 'page',
		'post_status'  => 'publish',
		'post_title'   => '',
		'post_name'    => '',
		'post_content' => '',
	);

	$data = wp_parse_args( $args, $defaults );

	$data['post_title']   = sanitize_text_field( $data['post_title'] );
	$data['post_name']    = sanitize_title( $data['post_name'] );
	$data['post_content'] = wp_kses_post( $data['post_content'] );

	if ( '' === $data['post_name'] ) {
		$data['post_name'] = sanitize_title( $data['post_title'] );
	}

	$existing = get_page_by_path( $data['post_name'], OBJECT, $data['post_type'] );

	if ( $existing && ! empty( $existing->ID ) ) {
		$data['ID'] = (int) $existing->ID;
		$post_id    = wp_update_post( wp_slash( $data ), true );
		$action     = 'updated';
	} else {
		$post_id = wp_insert_post( wp_slash( $data ), true );
		$action  = 'created';
	}

	if ( is_wp_error( $post_id ) ) {
		return array(
			'success' => false,
			'action'  => 'error',
			'id'      => 0,
			'message' => $post_id->get_error_message(),
		);
	}

	return array(
		'success' => true,
		'action'  => $action,
		'id'      => (int) $post_id,
		'message' => '',
	);
}

/**
 * Sideload de imagem demo com cache por URL.
 *
 * @param string $image_url URL da imagem.
 * @param string $image_alt Alt da imagem.
 * @return int
 */
function xxx_demo_import_image( $image_url, $image_alt = '' ) {
	$image_url = esc_url_raw( $image_url );
	if ( empty( $image_url ) ) {
		return 0;
	}

	$existing = get_posts(
		array(
			'post_type'      => 'attachment',
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'meta_key'       => '_xxx_demo_image_source',
			'meta_value'     => $image_url,
		)
	);
	if ( ! empty( $existing[0] ) ) {
		return (int) $existing[0];
	}

	if ( ! function_exists( 'media_sideload_image' ) ) {
		require_once ABSPATH . 'wp-admin/includes/media.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/image.php';
	}

	if ( ! function_exists( 'media_sideload_image' ) ) {
		return 0;
	}

	$attachment_id = media_sideload_image( $image_url, 0, null, 'id' );
	if ( is_wp_error( $attachment_id ) ) {
		return 0;
	}

	update_post_meta( $attachment_id, '_xxx_demo_image_source', $image_url );
	update_post_meta( $attachment_id, '_xxx_demo_image', '1' );

	if ( ! empty( $image_alt ) ) {
		update_post_meta( $attachment_id, '_wp_attachment_image_alt', sanitize_text_field( $image_alt ) );
	}

	return (int) $attachment_id;
}

/**
 * Cria ou atualiza produtos WooCommerce.
 *
 * @param array $products Produtos.
 * @param array $report   Relatório.
 * @return array
 */
function xxx_demo_import_products( $products, $report ) {
	if ( empty( $products ) || ! is_array( $products ) ) {
		return $report;
	}

	foreach ( $products as $product ) {
		$name         = isset( $product['nome'] ) ? sanitize_text_field( $product['nome'] ) : '';
		$slug         = sanitize_title( $name );
		$short_desc   = isset( $product['descricao_curta'] ) ? wp_kses_post( $product['descricao_curta'] ) : '';
		$long_desc    = isset( $product['descricao_longa'] ) ? wp_kses_post( $product['descricao_longa'] ) : '';
		$benefits     = isset( $product['beneficios'] ) && is_array( $product['beneficios'] ) ? array_map( 'sanitize_text_field', $product['beneficios'] ) : array();
		$application  = isset( $product['aplicacao'] ) ? sanitize_text_field( $product['aplicacao'] ) : '';
		$category     = 'Equipamentos de Segurança';
		$category_slug = 'equipamentos-seguranca';
		$price        = '199.90';

		if ( false !== stripos( $name, 'CO2' ) ) {
			$category      = 'Extintores CO2';
			$category_slug = 'extintores-co2';
			$price         = '289.90';
		} elseif ( false !== stripos( $name, 'ABC' ) ) {
			$category      = 'Extintores ABC';
			$category_slug = 'extintores-abc';
			$price         = '229.90';
		} elseif ( false !== stripos( $name, 'Mangueira' ) ) {
			$category      = 'Mangueiras de Incêndio';
			$category_slug = 'mangueiras-incendio';
			$price         = '349.90';
		} elseif ( false !== stripos( $name, 'Placas' ) ) {
			$category      = 'Sinalização';
			$category_slug = 'sinalizacao';
			$price         = '39.90';
		}

		wp_insert_term(
			$category,
			'product_cat',
			array(
				'slug' => $category_slug,
			)
		);

		$existing = get_page_by_path( $slug, OBJECT, 'product' );
		$product_id = $existing ? (int) $existing->ID : 0;

		$product_data = array(
			'post_type'    => 'product',
			'post_status'  => 'publish',
			'post_title'   => $name,
			'post_name'    => $slug,
			'post_content' => trim( $long_desc . "\n\n" . ( ! empty( $benefits ) ? '<h3>Benefícios</h3><ul><li>' . implode( '</li><li>', array_map( 'esc_html', $benefits ) ) . '</li></ul>' : '' ) . "\n\n" . ( $application ? '<p><strong>Aplicação:</strong> ' . esc_html( $application ) . '</p>' : '' ) ),
			'post_excerpt' => $short_desc,
		);

		if ( $product_id > 0 ) {
			$product_data['ID'] = $product_id;
			$result             = wp_update_post( wp_slash( $product_data ), true );
			$report['products_updated']++;
		} else {
			$result = wp_insert_post( wp_slash( $product_data ), true );
			$report['products_created']++;
		}

		if ( is_wp_error( $result ) ) {
			$report['errors'][] = sprintf( 'Produto "%s": %s', $name, $result->get_error_message() );
			continue;
		}

		$product_id = (int) $result;

		wp_set_object_terms( $product_id, $category_slug, 'product_cat', false );
		update_post_meta( $product_id, '_regular_price', $price );
		update_post_meta( $product_id, '_price', $price );
		update_post_meta( $product_id, '_stock_status', 'instock' );

		if ( ! has_post_thumbnail( $product_id ) ) {
			update_post_meta( $product_id, '_xxx_placeholder_image', '1' );
		}
	}

	return $report;
}

/**
 * Importa conteúdo demo do tema.
 *
 * @return array
 */
function xxx_import_demo_content() {
	$report = array(
		'pages_created'       => 0,
		'pages_updated'       => 0,
		'products_created'    => 0,
		'products_updated'    => 0,
		'faq_created'         => 0,
		'faq_updated'         => 0,
		'testimonials_created'=> 0,
		'testimonials_updated'=> 0,
		'warnings'            => array(),
		'errors'              => array(),
	);

	$json_path = xxx_demo_content_json_path();

	if ( ! file_exists( $json_path ) || ! is_readable( $json_path ) ) {
		$report['errors'][] = 'Arquivo JSON não encontrado ou sem permissão de leitura.';
		return $report;
	}

	$raw_data = file_get_contents( $json_path );
	if ( false === $raw_data ) {
		$report['errors'][] = 'Falha ao ler o arquivo JSON.';
		return $report;
	}

	$data = json_decode( $raw_data, true );
	if ( JSON_ERROR_NONE !== json_last_error() || ! is_array( $data ) ) {
		$report['errors'][] = 'JSON inválido: ' . json_last_error_msg();
		return $report;
	}

	if ( ! empty( $data['contato'] ) && is_array( $data['contato'] ) ) {
		$contact = $data['contato'];
		set_theme_mod( 'xxx_safety_phone', sanitize_text_field( $contact['telefone'] ?? '' ) );
		set_theme_mod( 'xxx_safety_whatsapp_number', sanitize_text_field( $contact['whatsapp'] ?? '' ) );
		set_theme_mod( 'xxx_safety_email', sanitize_email( $contact['email'] ?? '' ) );
		set_theme_mod( 'xxx_safety_address', sanitize_text_field( $contact['endereco'] ?? '' ) );
	}

	if ( ! empty( $data['home'] ) && is_array( $data['home'] ) ) {
		set_theme_mod( 'xxx_safety_hero_highlight', sanitize_text_field( $data['home']['subheadline'] ?? '' ) );
		set_theme_mod( 'xxx_safety_main_cta_text', sanitize_text_field( $data['home']['cta_principal'] ?? 'Solicitar Orçamento' ) );
		set_theme_mod( 'xxx_safety_hero_image', esc_url_raw( $data['home']['hero_image'] ?? '' ) );
	}

	$home_content = '';
	if ( ! empty( $data['home'] ) && is_array( $data['home'] ) ) {
		$home = $data['home'];

		$home_content .= '<h1>' . esc_html( $home['hero_headline'] ?? '' ) . '</h1>';
		$home_content .= '<p><strong>' . esc_html( $home['subheadline'] ?? '' ) . '</strong></p>';
		$home_content .= '<p>' . wp_kses_post( $home['institucional_curto'] ?? '' ) . '</p>';
		$home_content .= '<h2>Nossos Serviços</h2>';

		if ( ! empty( $home['servicos_resumo'] ) && is_array( $home['servicos_resumo'] ) ) {
			$home_content .= '<ul>';
			foreach ( $home['servicos_resumo'] as $item ) {
				$name = sanitize_text_field( $item['nome'] ?? '' );
				$desc = sanitize_text_field( $item['descricao'] ?? '' );
				$home_content .= '<li><strong>' . esc_html( $name ) . ':</strong> ' . esc_html( $desc ) . '</li>';
			}
			$home_content .= '</ul>';
		}

		if ( ! empty( $home['porque_escolher'] ) && is_array( $home['porque_escolher'] ) ) {
			$home_content .= '<h2>Por que escolher a XXX Extintores</h2><ul>';
			foreach ( $home['porque_escolher'] as $reason ) {
				$home_content .= '<li>' . esc_html( sanitize_text_field( $reason ) ) . '</li>';
			}
			$home_content .= '</ul>';
		}
	}

	$services_content = '';
	if ( ! empty( $data['servicos'] ) && is_array( $data['servicos'] ) ) {
		foreach ( $data['servicos'] as $service ) {
			$title = sanitize_text_field( $service['titulo'] ?? '' );
			$desc  = wp_kses_post( $service['descricao'] ?? '' );
			$cta   = sanitize_text_field( $service['cta'] ?? '' );

			$services_content .= '<h2>' . esc_html( $title ) . '</h2>';
			$services_content .= '<p>' . $desc . '</p>';

			if ( ! empty( $service['beneficios'] ) && is_array( $service['beneficios'] ) ) {
				$services_content .= '<h3>Benefícios</h3><ul>';
				foreach ( $service['beneficios'] as $benefit ) {
					$services_content .= '<li>' . esc_html( sanitize_text_field( $benefit ) ) . '</li>';
				}
				$services_content .= '</ul>';
			}

			if ( ! empty( $service['quando_precisa'] ) && is_array( $service['quando_precisa'] ) ) {
				$services_content .= '<h3>Quando você precisa</h3><ul>';
				foreach ( $service['quando_precisa'] as $need ) {
					$services_content .= '<li>' . esc_html( sanitize_text_field( $need ) ) . '</li>';
				}
				$services_content .= '</ul>';
			}

			if ( $cta ) {
				$services_content .= '<p><strong>CTA:</strong> ' . esc_html( $cta ) . '</p>';
			}
		}
	}

	$products_content = '';
	if ( ! empty( $data['woocommerce']['shop_intro'] ) ) {
		$products_content .= '<p>' . esc_html( sanitize_text_field( $data['woocommerce']['shop_intro'] ) ) . '</p>';
	}

	if ( ! empty( $data['woocommerce']['produtos'] ) && is_array( $data['woocommerce']['produtos'] ) ) {
		foreach ( $data['woocommerce']['produtos'] as $product ) {
			$name        = sanitize_text_field( $product['nome'] ?? '' );
			$short_desc  = sanitize_text_field( $product['descricao_curta'] ?? '' );
			$products_content .= '<h2>' . esc_html( $name ) . '</h2><p>' . esc_html( $short_desc ) . '</p>';
		}
	}

	$contact_content = '';
	if ( ! empty( $data['contato'] ) && is_array( $data['contato'] ) ) {
		$contact = $data['contato'];
		$contact_content .= '<p>' . esc_html( sanitize_text_field( $contact['texto'] ?? '' ) ) . '</p>';
		$contact_content .= '<p><strong>' . esc_html( sanitize_text_field( $contact['frase_incentivo'] ?? '' ) ) . '</strong></p>';
		$contact_content .= '<ul>';
		$contact_content .= '<li><strong>Telefone:</strong> ' . esc_html( sanitize_text_field( $contact['telefone'] ?? '' ) ) . '</li>';
		$contact_content .= '<li><strong>WhatsApp:</strong> ' . esc_html( sanitize_text_field( $contact['whatsapp'] ?? '' ) ) . '</li>';
		$contact_content .= '<li><strong>Endereço:</strong> ' . esc_html( sanitize_text_field( $contact['endereco'] ?? '' ) ) . '</li>';
		$contact_content .= '<li><strong>E-mail:</strong> ' . esc_html( sanitize_email( $contact['email'] ?? '' ) ) . '</li>';
		$contact_content .= '</ul>';
	}

	$pages_to_import = array(
		'home'     => array( 'title' => 'Home', 'content' => $home_content, 'image_url' => $data['home']['hero_image'] ?? '', 'image_alt' => $data['home']['image_alt'] ?? '' ),
		'sobre'    => array( 'title' => 'Sobre', 'content' => '', 'image_url' => $data['page_media']['sobre']['hero_image'] ?? '', 'image_alt' => $data['page_media']['sobre']['image_alt'] ?? '' ),
		'servicos' => array( 'title' => 'Serviços', 'content' => $services_content, 'image_url' => $data['page_media']['servicos']['hero_image'] ?? '', 'image_alt' => $data['page_media']['servicos']['image_alt'] ?? '' ),
		'produtos' => array( 'title' => 'Produtos', 'content' => $products_content, 'image_url' => '', 'image_alt' => '' ),
		'contato'  => array( 'title' => 'Contato', 'content' => $contact_content, 'image_url' => $data['page_media']['contato']['hero_image'] ?? '', 'image_alt' => $data['page_media']['contato']['image_alt'] ?? '' ),
	);

	if ( ! empty( $data['sobre'] ) && is_array( $data['sobre'] ) ) {
		$about_content = '';
		$about_content .= '<h2>História da empresa</h2>';
		if ( ! empty( $data['sobre']['historia'] ) && is_array( $data['sobre']['historia'] ) ) {
			foreach ( $data['sobre']['historia'] as $paragraph ) {
				$about_content .= '<p>' . esc_html( sanitize_text_field( $paragraph ) ) . '</p>';
			}
		}
		$about_content .= '<h2>Missão</h2><p>' . esc_html( sanitize_text_field( $data['sobre']['missao'] ?? '' ) ) . '</p>';
		$about_content .= '<h2>Visão</h2><p>' . esc_html( sanitize_text_field( $data['sobre']['visao'] ?? '' ) ) . '</p>';
		$about_content .= '<h2>Valores</h2><ul>';
		if ( ! empty( $data['sobre']['valores'] ) && is_array( $data['sobre']['valores'] ) ) {
			foreach ( $data['sobre']['valores'] as $value ) {
				$about_content .= '<li>' . esc_html( sanitize_text_field( $value ) ) . '</li>';
			}
		}
		$about_content .= '</ul>';

		$pages_to_import['sobre']['content'] = $about_content;
	}

	$page_ids = array();

	foreach ( $pages_to_import as $slug => $page ) {
		$result = xxx_demo_upsert_post_by_slug(
			array(
				'post_type'    => 'page',
				'post_title'   => $page['title'],
				'post_name'    => $slug,
				'post_content' => $page['content'],
			)
		);

		if ( ! $result['success'] ) {
			$report['errors'][] = sprintf( 'Página "%s": %s', $page['title'], $result['message'] );
			continue;
		}

		$page_ids[ $slug ] = $result['id'];
		if ( 'created' === $result['action'] ) {
			$report['pages_created']++;
		} else {
			$report['pages_updated']++;
		}

		if ( ! empty( $page['image_url'] ) ) {
			$attachment_id = xxx_demo_import_image( $page['image_url'], $page['image_alt'] ?? '' );
			if ( $attachment_id > 0 ) {
				set_post_thumbnail( $result['id'], $attachment_id );
			} else {
				$report['warnings'][] = sprintf( 'Imagem não importada para página "%s".', $page['title'] );
			}
		}
	}

	if ( ! empty( $page_ids['home'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', (int) $page_ids['home'] );
	}

	$has_woocommerce = class_exists( 'WooCommerce' );

	if ( $has_woocommerce ) {
		if ( ! empty( $page_ids['produtos'] ) ) {
			update_option( 'woocommerce_shop_page_id', (int) $page_ids['produtos'] );
		}

		if ( ! empty( $data['woocommerce']['produtos'] ) && is_array( $data['woocommerce']['produtos'] ) ) {
			$report = xxx_demo_import_products( $data['woocommerce']['produtos'], $report );
		}
	} else {
		$report['warnings'][] = 'WooCommerce não está ativo. Produtos demo não foram importados.';
	}

	if ( post_type_exists( 'faq' ) && ! empty( $data['faq'] ) && is_array( $data['faq'] ) ) {
		foreach ( $data['faq'] as $faq ) {
			$title   = sanitize_text_field( $faq['pergunta'] ?? '' );
			$content = wp_kses_post( $faq['resposta'] ?? '' );
			$result  = xxx_demo_upsert_post_by_slug(
				array(
					'post_type'    => 'faq',
					'post_title'   => $title,
					'post_name'    => sanitize_title( $title ),
					'post_content' => $content,
				)
			);
			if ( $result['success'] ) {
				if ( 'created' === $result['action'] ) {
					$report['faq_created']++;
				} else {
					$report['faq_updated']++;
				}
			}
		}
	} elseif ( ! empty( $data['faq'] ) ) {
		$faq_page = xxx_demo_upsert_post_by_slug(
			array(
				'post_type'    => 'page',
				'post_title'   => 'FAQ',
				'post_name'    => 'faq',
				'post_content' => xxx_demo_build_faq_html( $data['faq'] ),
			)
		);
		if ( $faq_page['success'] ) {
			if ( 'created' === $faq_page['action'] ) {
				$report['pages_created']++;
			} else {
				$report['pages_updated']++;
			}
		}
	}

	if ( post_type_exists( 'depoimento' ) && ! empty( $data['depoimentos'] ) && is_array( $data['depoimentos'] ) ) {
		foreach ( $data['depoimentos'] as $testimonial ) {
			$name    = sanitize_text_field( $testimonial['nome'] ?? '' );
			$type    = sanitize_text_field( $testimonial['tipo_cliente'] ?? '' );
			$content = wp_kses_post( $testimonial['comentario'] ?? '' );

			$result = xxx_demo_upsert_post_by_slug(
				array(
					'post_type'    => 'depoimento',
					'post_title'   => $name,
					'post_name'    => sanitize_title( $name ),
					'post_content' => $content,
				)
			);

			if ( $result['success'] ) {
				update_post_meta( $result['id'], 'tipo_cliente', $type );
				if ( 'created' === $result['action'] ) {
					$report['testimonials_created']++;
				} else {
					$report['testimonials_updated']++;
				}
			}
		}
	} elseif ( ! empty( $data['depoimentos'] ) ) {
		$depo_page = xxx_demo_upsert_post_by_slug(
			array(
				'post_type'    => 'page',
				'post_title'   => 'Depoimentos',
				'post_name'    => 'depoimentos',
				'post_content' => xxx_demo_build_testimonials_html( $data['depoimentos'] ),
			)
		);
		if ( $depo_page['success'] ) {
			if ( 'created' === $depo_page['action'] ) {
				$report['pages_created']++;
			} else {
				$report['pages_updated']++;
			}
		}
	}

	return $report;
}

/**
 * Registra página de importação no admin.
 */
function xxx_demo_importer_admin_menu() {
	add_theme_page(
		__( 'Importar Conteúdo Demo', 'xxx-safety-prevention' ),
		__( 'Importar Conteúdo Demo', 'xxx-safety-prevention' ),
		'manage_options',
		'xxx-demo-importer',
		'xxx_demo_importer_admin_page'
	);
}
add_action( 'admin_menu', 'xxx_demo_importer_admin_menu' );

/**
 * Processa importação no admin.
 */
function xxx_demo_importer_handle_action() {
	if ( ! is_admin() ) {
		return;
	}

	if ( ! isset( $_POST['xxx_demo_import_action'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
		return;
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Você não tem permissão para executar esta ação.', 'xxx-safety-prevention' ) );
	}

	check_admin_referer( 'xxx_demo_import_nonce_action', 'xxx_demo_import_nonce' );

	$report = xxx_import_demo_content();

	set_transient( 'xxx_demo_import_report_' . get_current_user_id(), $report, MINUTE_IN_SECONDS * 5 );

	wp_safe_redirect(
		add_query_arg(
			array(
				'page'      => 'xxx-demo-importer',
				'imported'  => '1',
			),
			admin_url( 'themes.php' )
		)
	);
	exit;
}
add_action( 'admin_init', 'xxx_demo_importer_handle_action' );

/**
 * Renderiza tela do importador.
 */
function xxx_demo_importer_admin_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$report = get_transient( 'xxx_demo_import_report_' . get_current_user_id() );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Importar Conteúdo Demo', 'xxx-safety-prevention' ); ?></h1>
		<p><?php esc_html_e( 'Use este importador para criar/atualizar as páginas e produtos de exemplo do tema.', 'xxx-safety-prevention' ); ?></p>

		<?php if ( class_exists( 'WooCommerce' ) ) : ?>
			<p><strong><?php esc_html_e( 'WooCommerce ativo:', 'xxx-safety-prevention' ); ?></strong> <?php esc_html_e( 'sim', 'xxx-safety-prevention' ); ?></p>
		<?php else : ?>
			<div class="notice notice-warning"><p><?php esc_html_e( 'WooCommerce não está ativo. Os produtos não serão importados.', 'xxx-safety-prevention' ); ?></p></div>
		<?php endif; ?>

		<form method="post" action="">
			<?php wp_nonce_field( 'xxx_demo_import_nonce_action', 'xxx_demo_import_nonce' ); ?>
			<input type="hidden" name="xxx_demo_import_action" value="1" />
			<?php submit_button( __( 'Importar Conteúdo Demo', 'xxx-safety-prevention' ) ); ?>
		</form>

		<?php if ( isset( $_GET['imported'] ) && $report && is_array( $report ) ) : // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>
			<div class="notice notice-success" style="margin-top:16px;padding:12px 16px;">
				<p><strong><?php esc_html_e( 'Importação concluída.', 'xxx-safety-prevention' ); ?></strong></p>
				<ul style="list-style:disc;padding-left:18px;">
					<li><?php echo esc_html( sprintf( 'Páginas criadas: %d', (int) $report['pages_created'] ) ); ?></li>
					<li><?php echo esc_html( sprintf( 'Páginas atualizadas: %d', (int) $report['pages_updated'] ) ); ?></li>
					<li><?php echo esc_html( sprintf( 'Produtos criados: %d', (int) $report['products_created'] ) ); ?></li>
					<li><?php echo esc_html( sprintf( 'Produtos atualizados: %d', (int) $report['products_updated'] ) ); ?></li>
				</ul>
			</div>

			<?php if ( ! empty( $report['warnings'] ) ) : ?>
				<div class="notice notice-warning"><p><?php echo esc_html( implode( ' | ', array_map( 'sanitize_text_field', $report['warnings'] ) ) ); ?></p></div>
			<?php endif; ?>

			<?php if ( ! empty( $report['errors'] ) ) : ?>
				<div class="notice notice-error"><p><?php echo esc_html( implode( ' | ', array_map( 'sanitize_text_field', $report['errors'] ) ) ); ?></p></div>
			<?php endif; ?>
		<?php endif; ?>
	</div>
	<?php
}
