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

	if ( function_exists( 'is_product' ) && is_product() ) {
		remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
		remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
		remove_action( 'woocommerce_after_single_product_summary', 'xxx_safety_wc_single_product_extras', 25 );
	}
}
add_action( 'wp', 'xxx_safety_woocommerce_support_customizations' );

function xxx_safety_wrapper_start() {
	echo '<main id="primary" class="site-main site-main-shop"><div class="container">';
}

function xxx_safety_wrapper_end() {
	echo '</div></main>';
}

function xxx_safety_wc_section_intro() {
	if ( function_exists( 'is_product' ) && is_product() ) {
		return;
	}

	$title = '';
	if ( function_exists( 'is_cart' ) && is_cart() ) {
		$title = esc_html__( 'Carrinho', 'xxx-safety-prevention' );
	} elseif ( function_exists( 'is_checkout' ) && is_checkout() ) {
		$title = esc_html__( 'Finalizar Compra', 'xxx-safety-prevention' );
	} elseif ( function_exists( 'is_account_page' ) && is_account_page() ) {
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
	if ( function_exists( 'is_shop' ) && ( is_shop() || ( function_exists( 'is_product_taxonomy' ) && is_product_taxonomy() ) ) ) {
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
	if ( ! function_exists( 'is_product' ) || ! is_product() ) {
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

function xxx_safety_wc_body_classes( $classes ) {
	if ( function_exists( 'is_product' ) && is_product() ) {
		$classes[] = 'is-premium-product';
	}

	return $classes;
}
add_filter( 'body_class', 'xxx_safety_wc_body_classes' );

function xxx_safety_wc_icon( $icon ) {
	$icons = array(
		'shield'  => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3l7 3v5c0 4.6-2.9 8.7-7 10-4.1-1.3-7-5.4-7-10V6l7-3z"/><path d="M9.2 12.1l1.9 1.9 3.9-4.2"/></svg>',
		'truck'   => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 6h11v9H3z"/><path d="M14 9h4l3 3v3h-7z"/><circle cx="7" cy="18" r="2"/><circle cx="18" cy="18" r="2"/></svg>',
		'award'   => '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8" r="5"/><path d="M9 13l-1 8 4-2 4 2-1-8"/></svg>',
		'headset' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 13a8 8 0 0 1 16 0v4a3 3 0 0 1-3 3h-2"/><path d="M4 13v4h4v-5H5a1 1 0 0 0-1 1z"/><path d="M20 13v4h-4v-5h3a1 1 0 0 1 1 1z"/><path d="M13 20h2"/></svg>',
		'check'   => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 6L9 17l-5-5"/></svg>',
	);

	return $icons[ $icon ] ?? $icons['check'];
}

function xxx_safety_wc_product_asset_url( $filename ) {
	return get_template_directory_uri() . '/assets/images/' . ltrim( $filename, '/' );
}

function xxx_safety_wc_product_fallback_image( $product ) {
	$search = strtolower( remove_accents( $product->get_name() . ' ' . wp_strip_all_tags( wc_get_product_category_list( $product->get_id(), ' ' ) ) ) );
	$file   = 'product-1.jpg';

	if ( false !== strpos( $search, 'co2' ) ) {
		$file = 'product-2.jpg';
	} elseif ( false !== strpos( $search, 'agua' ) ) {
		$file = 'product-3.jpg';
	} elseif ( false !== strpos( $search, 'espuma' ) ) {
		$file = 'product-4.jpg';
	}

	return array(
		'url'    => xxx_safety_wc_product_asset_url( $file ),
		'width'  => 832,
		'height' => 1248,
		'alt'    => $product->get_name(),
	);
}

function xxx_safety_wc_get_product_gallery_items( $product ) {
	$image_ids = array();
	$image_id  = $product->get_image_id();

	if ( $image_id ) {
		$image_ids[] = $image_id;
	}

	foreach ( $product->get_gallery_image_ids() as $gallery_id ) {
		if ( $gallery_id && ! in_array( $gallery_id, $image_ids, true ) ) {
			$image_ids[] = $gallery_id;
		}
	}

	$items = array();
	foreach ( $image_ids as $index => $attachment_id ) {
		$full = wp_get_attachment_image_src( $attachment_id, 'full' );
		if ( ! $full ) {
			continue;
		}

		$items[] = array(
			'id'      => $attachment_id,
			'url'     => $full[0],
			'width'   => $full[1],
			'height'  => $full[2],
			'alt'     => get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ?: $product->get_name(),
			'srcset'  => wp_get_attachment_image_srcset( $attachment_id, 'full' ),
			'sizes'   => wp_get_attachment_image_sizes( $attachment_id, 'full' ),
			'primary' => 0 === $index,
		);
	}

	if ( empty( $items ) ) {
		$items[] = array_merge( xxx_safety_wc_product_fallback_image( $product ), array( 'primary' => true ) );
	}

	return $items;
}

function xxx_safety_wc_render_product_gallery( $product ) {
	$items = xxx_safety_wc_get_product_gallery_items( $product );
	?>
	<div class="xxx-product-gallery" data-product-gallery>
		<div class="xxx-product-gallery__viewport">
			<?php foreach ( $items as $index => $item ) : ?>
				<figure class="xxx-product-gallery__panel <?php echo 0 === $index ? 'is-active' : ''; ?>" data-product-gallery-panel="<?php echo esc_attr( $index ); ?>">
					<a href="<?php echo esc_url( $item['url'] ); ?>" target="_blank" rel="noopener">
						<img
							src="<?php echo esc_url( $item['url'] ); ?>"
							<?php if ( ! empty( $item['srcset'] ) ) : ?>
								srcset="<?php echo esc_attr( $item['srcset'] ); ?>"
							<?php endif; ?>
							<?php if ( ! empty( $item['sizes'] ) ) : ?>
								sizes="<?php echo esc_attr( $item['sizes'] ); ?>"
							<?php endif; ?>
							alt="<?php echo esc_attr( $item['alt'] ); ?>"
							width="<?php echo esc_attr( $item['width'] ); ?>"
							height="<?php echo esc_attr( $item['height'] ); ?>"
							<?php echo 0 === $index ? 'fetchpriority="high"' : 'loading="lazy"'; ?>
							decoding="async"
						/>
					</a>
				</figure>
			<?php endforeach; ?>
			<div class="xxx-product-gallery__glow" aria-hidden="true"></div>
			<div class="xxx-product-gallery__floor" aria-hidden="true"></div>
		</div>

		<?php if ( count( $items ) > 1 ) : ?>
			<div class="xxx-product-gallery__thumbs" aria-label="<?php esc_attr_e( 'Galeria do produto', 'xxx-safety-prevention' ); ?>">
				<?php foreach ( $items as $index => $item ) : ?>
					<button class="<?php echo 0 === $index ? 'is-active' : ''; ?>" type="button" data-product-gallery-thumb="<?php echo esc_attr( $index ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Ver imagem %d', 'xxx-safety-prevention' ), $index + 1 ) ); ?>">
						<img src="<?php echo esc_url( $item['url'] ); ?>" alt="" width="96" height="120" loading="lazy" decoding="async" />
					</button>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
	<?php
}

function xxx_safety_wc_get_product_specifications( $product ) {
	$specs = array();

	if ( $product->get_sku() ) {
		$specs[] = array( __( 'SKU', 'xxx-safety-prevention' ), $product->get_sku() );
	}

	$categories = wp_strip_all_tags( wc_get_product_category_list( $product->get_id(), ', ' ) );
	if ( $categories ) {
		$specs[] = array( __( 'Categoria', 'xxx-safety-prevention' ), $categories );
	}

	$specs[] = array( __( 'Disponibilidade', 'xxx-safety-prevention' ), wp_strip_all_tags( wc_get_stock_html( $product ) ) ?: $product->get_stock_status() );

	if ( $product->has_weight() ) {
		$specs[] = array( __( 'Peso', 'xxx-safety-prevention' ), wc_format_weight( $product->get_weight() ) );
	}

	if ( $product->has_dimensions() ) {
		$specs[] = array( __( 'Dimensões', 'xxx-safety-prevention' ), wc_format_dimensions( $product->get_dimensions( false ) ) );
	}

	foreach ( $product->get_attributes() as $attribute ) {
		if ( ! $attribute->get_visible() ) {
			continue;
		}

		$name = wc_attribute_label( $attribute->get_name() );
		if ( $attribute->is_taxonomy() ) {
			$values = wc_get_product_terms( $product->get_id(), $attribute->get_name(), array( 'fields' => 'names' ) );
		} else {
			$values = $attribute->get_options();
		}

		if ( ! empty( $values ) ) {
			$specs[] = array( $name, implode( ', ', array_map( 'wp_strip_all_tags', $values ) ) );
		}
	}

	return apply_filters( 'xxx_safety_product_specifications', $specs, $product );
}

function xxx_safety_wc_find_spec_value( $specs, $needles ) {
	foreach ( $specs as $spec ) {
		$label = strtolower( remove_accents( $spec[0] ) );
		foreach ( $needles as $needle ) {
			if ( false !== strpos( $label, $needle ) ) {
				return $spec[1];
			}
		}
	}

	return '';
}

function xxx_safety_wc_render_product_trust( $product ) {
	$specs         = xxx_safety_wc_get_product_specifications( $product );
	$certification = xxx_safety_wc_find_spec_value( $specs, array( 'certificacao', 'certificado', 'norma', 'inmetro' ) );
	$warranty      = xxx_safety_wc_find_spec_value( $specs, array( 'garantia' ) );
	$whatsapp      = preg_replace( '/\D+/', '', xxx_safety_get_theme_mod( 'whatsapp_number', '' ) );

	$items = apply_filters(
		'xxx_safety_product_trust_items',
		array(
			array( 'icon' => 'shield', 'label' => __( 'Certificação', 'xxx-safety-prevention' ), 'value' => $certification ?: __( 'Ver especificações', 'xxx-safety-prevention' ) ),
			array( 'icon' => 'truck', 'label' => __( 'Entrega', 'xxx-safety-prevention' ), 'value' => $product->needs_shipping() ? __( 'Calculada no checkout', 'xxx-safety-prevention' ) : __( 'Produto sem frete físico', 'xxx-safety-prevention' ) ),
			array( 'icon' => 'award', 'label' => __( 'Garantia', 'xxx-safety-prevention' ), 'value' => $warranty ?: __( 'Condições no atendimento', 'xxx-safety-prevention' ) ),
			array( 'icon' => 'headset', 'label' => __( 'Suporte', 'xxx-safety-prevention' ), 'value' => $whatsapp ? __( 'Orientação técnica via WhatsApp', 'xxx-safety-prevention' ) : __( 'Orientação técnica', 'xxx-safety-prevention' ) ),
		),
		$product,
		$specs
	);
	?>
	<div class="xxx-product-trust">
		<?php foreach ( $items as $item ) : ?>
			<div class="xxx-product-trust__item">
				<span class="xxx-product-icon"><?php echo xxx_safety_wc_icon( $item['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
				<span><?php echo esc_html( $item['label'] ); ?></span>
				<strong><?php echo esc_html( $item['value'] ); ?></strong>
			</div>
		<?php endforeach; ?>
	</div>
	<?php
}

function xxx_safety_wc_render_product_highlights( $product ) {
	$items = array();

	if ( $product->is_in_stock() ) {
		$items[] = array( __( 'Disponível', 'xxx-safety-prevention' ), wp_strip_all_tags( wc_get_stock_html( $product ) ) ?: __( 'Em estoque', 'xxx-safety-prevention' ) );
	}

	if ( $product->is_purchasable() ) {
		$items[] = array( __( 'Compra segura', 'xxx-safety-prevention' ), __( 'Fluxo nativo do WooCommerce', 'xxx-safety-prevention' ) );
	}

	if ( $product->get_average_rating() ) {
		$items[] = array( __( 'Avaliação média', 'xxx-safety-prevention' ), wc_format_decimal( $product->get_average_rating(), 1 ) . ' / 5' );
	}

	$categories = wp_strip_all_tags( wc_get_product_category_list( $product->get_id(), ', ' ) );
	if ( $categories ) {
		$items[] = array( __( 'Linha', 'xxx-safety-prevention' ), $categories );
	}

	$items = apply_filters( 'xxx_safety_product_highlights', array_slice( $items, 0, 4 ), $product );

	if ( empty( $items ) ) {
		return;
	}
	?>
	<section class="xxx-product-differentials xxx-product-animate" aria-label="<?php esc_attr_e( 'Diferenciais do produto', 'xxx-safety-prevention' ); ?>">
		<?php foreach ( $items as $item ) : ?>
			<article>
				<span><?php echo esc_html( $item[0] ); ?></span>
				<strong><?php echo esc_html( $item[1] ); ?></strong>
			</article>
		<?php endforeach; ?>
	</section>
	<?php
}

function xxx_safety_wc_get_product_faqs( $product ) {
	$custom = get_post_meta( $product->get_id(), '_xxx_product_faqs', true );
	$faqs   = array();

	if ( is_array( $custom ) ) {
		$faqs = $custom;
	} elseif ( is_string( $custom ) && $custom ) {
		$decoded = json_decode( $custom, true );
		if ( is_array( $decoded ) ) {
			$faqs = $decoded;
		}
	}

	if ( empty( $faqs ) ) {
		$faqs = array(
			array(
				'question' => __( 'Este produto pode ser comprado online?', 'xxx-safety-prevention' ),
				'answer'   => $product->is_purchasable() ? __( 'Sim. Use o botão de compra para seguir pelo checkout do WooCommerce com preço, quantidade e dados do pedido.', 'xxx-safety-prevention' ) : __( 'Este produto exige atendimento comercial antes da compra.', 'xxx-safety-prevention' ),
			),
			array(
				'question' => __( 'O frete aparece automaticamente?', 'xxx-safety-prevention' ),
				'answer'   => $product->needs_shipping() ? __( 'Produtos físicos usam as regras de entrega configuradas no WooCommerce e podem ter cálculo no checkout.', 'xxx-safety-prevention' ) : __( 'Este item não exige cálculo de frete físico.', 'xxx-safety-prevention' ),
			),
			array(
				'question' => __( 'Onde vejo as informações técnicas?', 'xxx-safety-prevention' ),
				'answer'   => __( 'As informações cadastradas no WooCommerce aparecem na seção de especificações desta página.', 'xxx-safety-prevention' ),
			),
		);
	}

	return apply_filters( 'xxx_safety_product_faqs', $faqs, $product );
}

function xxx_safety_wc_render_product_panels( $product ) {
	$description = apply_filters( 'the_content', $product->get_description() );
	$specs       = xxx_safety_wc_get_product_specifications( $product );
	$faqs        = xxx_safety_wc_get_product_faqs( $product );
	?>
	<section class="xxx-product-panels xxx-product-animate" data-product-accordions>
		<?php if ( $description ) : ?>
			<details class="xxx-product-panel" open>
				<summary><?php esc_html_e( 'Descrição completa', 'xxx-safety-prevention' ); ?></summary>
				<div class="xxx-product-panel__content entry-content"><?php echo wp_kses_post( $description ); ?></div>
			</details>
		<?php endif; ?>

		<?php if ( ! empty( $specs ) ) : ?>
			<details class="xxx-product-panel">
				<summary><?php esc_html_e( 'Especificações técnicas', 'xxx-safety-prevention' ); ?></summary>
				<div class="xxx-product-panel__content">
					<table class="xxx-product-specs">
						<tbody>
							<?php foreach ( $specs as $spec ) : ?>
								<tr>
									<th><?php echo esc_html( $spec[0] ); ?></th>
									<td><?php echo esc_html( $spec[1] ); ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</details>
		<?php endif; ?>

		<details class="xxx-product-panel">
			<summary><?php esc_html_e( 'Avaliações', 'xxx-safety-prevention' ); ?></summary>
			<div class="xxx-product-panel__content xxx-product-reviews">
				<?php comments_template(); ?>
			</div>
		</details>

		<?php if ( ! empty( $faqs ) ) : ?>
			<details class="xxx-product-panel">
				<summary><?php esc_html_e( 'Perguntas frequentes', 'xxx-safety-prevention' ); ?></summary>
				<div class="xxx-product-panel__content">
					<div class="xxx-product-faqs">
						<?php foreach ( $faqs as $faq ) : ?>
							<details>
								<summary><?php echo esc_html( $faq['question'] ?? '' ); ?></summary>
								<p><?php echo esc_html( $faq['answer'] ?? '' ); ?></p>
							</details>
						<?php endforeach; ?>
					</div>
				</div>
			</details>
		<?php endif; ?>
	</section>
	<?php
}

function xxx_safety_wc_render_mobile_purchase_bar( $product ) {
	if ( ! $product->is_purchasable() ) {
		return;
	}
	?>
	<div class="xxx-product-mobile-buy" data-mobile-buy>
		<div>
			<span><?php esc_html_e( 'Comprar produto', 'xxx-safety-prevention' ); ?></span>
			<strong><?php echo wp_kses_post( $product->get_price_html() ); ?></strong>
		</div>
		<a href="#xxx-product-purchase"><?php esc_html_e( 'Comprar', 'xxx-safety-prevention' ); ?></a>
	</div>
	<?php
}

function xxx_safety_wc_render_related_products() {
	ob_start();
	woocommerce_output_related_products();
	$related = trim( ob_get_clean() );

	if ( ! $related ) {
		return;
	}
	?>
	<section class="xxx-product-related xxx-product-animate">
		<?php echo $related; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</section>
	<?php
}
