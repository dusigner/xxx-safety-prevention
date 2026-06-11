<?php
/**
 * SEO metadata and structured data helpers.
 *
 * @package XXX_Safety_Prevention
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function xxx_safety_seo_has_plugin() {
	return defined( 'AIOSEO_VERSION' )
		|| defined( 'WPSEO_VERSION' )
		|| defined( 'RANK_MATH_VERSION' )
		|| defined( 'SEOPRESS_VERSION' )
		|| class_exists( 'AIOSEO\\Plugin\\AIOSEO' )
		|| class_exists( 'WPSEO_Frontend' )
		|| class_exists( 'RankMath' )
		|| class_exists( 'SEOPress' );
}

function xxx_safety_seo_clean_text( $text, $limit = 160 ) {
	$text = trim( preg_replace( '/\s+/', ' ', wp_strip_all_tags( (string) $text ) ) );

	if ( '' === $text ) {
		return '';
	}

	return function_exists( 'mb_strimwidth' ) ? mb_strimwidth( $text, 0, $limit, '...' ) : substr( $text, 0, $limit );
}

function xxx_safety_seo_description() {
	if ( function_exists( 'is_product' ) && is_product() ) {
		$product = wc_get_product( get_the_ID() );
		if ( $product ) {
			$description = xxx_safety_seo_clean_text( $product->get_short_description() ?: $product->get_description() );
			if ( $description ) {
				return $description;
			}
		}
	}

	if ( is_singular() ) {
		$post = get_post();
		if ( $post ) {
			$description = xxx_safety_seo_clean_text( has_excerpt( $post ) ? get_the_excerpt( $post ) : $post->post_content );
			if ( $description ) {
				return $description;
			}
		}
	}

	if ( is_archive() ) {
		$description = xxx_safety_seo_clean_text( get_the_archive_description() );
		if ( $description ) {
			return $description;
		}
	}

	return xxx_safety_seo_clean_text( get_bloginfo( 'description' ), 160 );
}

function xxx_safety_seo_image_url() {
	if ( is_singular() && has_post_thumbnail() ) {
		$image = get_the_post_thumbnail_url( get_the_ID(), 'full' );
		if ( $image ) {
			return $image;
		}
	}

	if ( function_exists( 'is_product' ) && is_product() ) {
		$product = wc_get_product( get_the_ID() );
		if ( $product && $product->get_image_id() ) {
			$image = wp_get_attachment_image_url( $product->get_image_id(), 'full' );
			if ( $image ) {
				return $image;
			}
		}
	}

	$logo_id = get_theme_mod( 'custom_logo' );
	return $logo_id ? wp_get_attachment_image_url( $logo_id, 'full' ) : '';
}

function xxx_safety_seo_canonical_url() {
	if ( is_front_page() || is_home() ) {
		return home_url( '/' );
	}

	if ( is_singular() ) {
		return get_permalink();
	}

	if ( function_exists( 'is_shop' ) && is_shop() && function_exists( 'wc_get_page_permalink' ) ) {
		return wc_get_page_permalink( 'shop' );
	}

	if ( is_category() || is_tag() || is_tax() ) {
		$term = get_queried_object();
		return $term && ! is_wp_error( $term ) ? get_term_link( $term ) : '';
	}

	if ( is_post_type_archive() ) {
		return get_post_type_archive_link( get_query_var( 'post_type' ) );
	}

	return get_pagenum_link();
}

function xxx_safety_seo_title() {
	return wp_get_document_title();
}

function xxx_safety_seo_disable_core_canonical() {
	if ( ! xxx_safety_seo_has_plugin() ) {
		remove_action( 'wp_head', 'rel_canonical' );
		remove_action( 'wp_head', 'wp_robots', 1 );
	}
}
add_action( 'wp', 'xxx_safety_seo_disable_core_canonical' );

function xxx_safety_seo_output_meta() {
	if ( xxx_safety_seo_has_plugin() ) {
		return;
	}

	$description = xxx_safety_seo_description();
	$canonical   = xxx_safety_seo_canonical_url();
	$image       = xxx_safety_seo_image_url();
	$title       = xxx_safety_seo_title();
	$url         = $canonical ?: home_url( add_query_arg( array(), $GLOBALS['wp']->request ?? '' ) );
	$type        = ( function_exists( 'is_product' ) && is_product() ) ? 'product' : ( is_singular() ? 'article' : 'website' );

	if ( is_search() || is_404() || ( function_exists( 'is_cart' ) && is_cart() ) || ( function_exists( 'is_checkout' ) && is_checkout() ) || ( function_exists( 'is_account_page' ) && is_account_page() ) ) {
		echo "\n" . '<meta name="robots" content="noindex, follow, max-image-preview:large">' . "\n";
	} else {
		echo "\n" . '<meta name="robots" content="index, follow, max-image-preview:large">' . "\n";
	}

	if ( $description ) {
		echo '<meta name="description" content="' . esc_attr( $description ) . '">' . "\n";
	}

	if ( $canonical && ! is_404() ) {
		echo '<link rel="canonical" href="' . esc_url( $canonical ) . '">' . "\n";
	}

	echo '<meta property="og:locale" content="' . esc_attr( str_replace( '-', '_', get_locale() ) ) . '">' . "\n";
	echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '">' . "\n";
	echo '<meta property="og:type" content="' . esc_attr( $type ) . '">' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
	if ( $description ) {
		echo '<meta property="og:description" content="' . esc_attr( $description ) . '">' . "\n";
	}
	echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
	if ( $image ) {
		echo '<meta property="og:image" content="' . esc_url( $image ) . '">' . "\n";
		echo '<meta name="twitter:image" content="' . esc_url( $image ) . '">' . "\n";
	}
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
	echo '<meta name="twitter:title" content="' . esc_attr( $title ) . '">' . "\n";
	if ( $description ) {
		echo '<meta name="twitter:description" content="' . esc_attr( $description ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'xxx_safety_seo_output_meta', 2 );

function xxx_safety_seo_organization_schema() {
	$logo_id = get_theme_mod( 'custom_logo' );
	$logo    = $logo_id ? wp_get_attachment_image_url( $logo_id, 'full' ) : '';
	$same_as = array_filter( array_map( 'trim', explode( ',', xxx_safety_get_theme_mod( 'social_links', '' ) ) ) );
	$schema  = array(
		'@type'     => array( 'LocalBusiness', 'Store' ),
		'@id'       => home_url( '/#organization' ),
		'name'      => get_bloginfo( 'name' ),
		'url'       => home_url( '/' ),
		'telephone' => xxx_safety_get_theme_mod( 'phone', '' ),
			'email'     => xxx_safety_get_theme_mod( 'email', '' ),
			'address'   => array(
				'@type'         => 'PostalAddress',
				'streetAddress' => xxx_safety_get_theme_mod( 'address', '' ),
				'addressCountry' => 'BR',
			),
	);

	if ( $logo ) {
		$schema['logo']  = array( '@type' => 'ImageObject', 'url' => $logo );
		$schema['image'] = $logo;
	}

	if ( $same_as ) {
		$schema['sameAs'] = array_values( array_map( 'esc_url_raw', $same_as ) );
	}

	return $schema;
}

function xxx_safety_seo_breadcrumb_schema() {
	$items = array(
		array(
			'@type'    => 'ListItem',
			'position' => 1,
			'name'     => __( 'Início', 'xxx-safety-prevention' ),
			'item'     => home_url( '/' ),
		),
	);

	if ( function_exists( 'is_product' ) && is_product() ) {
		$terms = get_the_terms( get_the_ID(), 'product_cat' );
		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			$term    = reset( $terms );
			$items[] = array(
				'@type'    => 'ListItem',
				'position' => count( $items ) + 1,
				'name'     => $term->name,
				'item'     => get_term_link( $term ),
			);
		}
	}

	if ( is_singular() ) {
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => count( $items ) + 1,
			'name'     => get_the_title(),
			'item'     => get_permalink(),
		);
	} elseif ( is_archive() ) {
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => count( $items ) + 1,
			'name'     => wp_strip_all_tags( get_the_archive_title() ),
			'item'     => xxx_safety_seo_canonical_url(),
		);
	}

	return array(
		'@type'           => 'BreadcrumbList',
		'@id'             => xxx_safety_seo_canonical_url() . '#breadcrumb',
		'itemListElement' => $items,
	);
}

function xxx_safety_seo_output_schema() {
	if ( xxx_safety_seo_has_plugin() || is_404() || is_search() ) {
		return;
	}

	$canonical   = xxx_safety_seo_canonical_url();
	$description = xxx_safety_seo_description();
	$image       = xxx_safety_seo_image_url();
	$graph       = array(
		xxx_safety_seo_organization_schema(),
		array(
			'@type'       => 'WebSite',
			'@id'         => home_url( '/#website' ),
			'url'         => home_url( '/' ),
			'name'        => get_bloginfo( 'name' ),
			'inLanguage'  => str_replace( '_', '-', get_locale() ),
			'publisher'   => array( '@id' => home_url( '/#organization' ) ),
			'potentialAction' => array(
				'@type'       => 'SearchAction',
				'target'      => home_url( '/?s={search_term_string}' ),
				'query-input' => 'required name=search_term_string',
			),
		),
		xxx_safety_seo_breadcrumb_schema(),
		array(
			'@type'       => 'WebPage',
			'@id'         => $canonical . '#webpage',
			'url'         => $canonical,
			'name'        => xxx_safety_seo_title(),
			'description' => $description,
			'inLanguage'  => str_replace( '_', '-', get_locale() ),
			'isPartOf'    => array( '@id' => home_url( '/#website' ) ),
			'breadcrumb'  => array( '@id' => $canonical . '#breadcrumb' ),
		),
	);

	if ( $image ) {
		$graph[3]['primaryImageOfPage'] = array( '@type' => 'ImageObject', 'url' => $image );
	}

	echo "\n" . '<script type="application/ld+json" class="xxx-safety-schema">' . wp_json_encode( array( '@context' => 'https://schema.org', '@graph' => $graph ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_head', 'xxx_safety_seo_output_schema', 30 );

function xxx_safety_seo_product_schema( $markup, $product ) {
	if ( ! $product instanceof WC_Product ) {
		return $markup;
	}

	$markup['@id'] = get_permalink( $product->get_id() ) . '#product';

	if ( $product->get_sku() ) {
		$markup['sku'] = $product->get_sku();
		$markup['mpn'] = $product->get_sku();
	}

	$terms = get_the_terms( $product->get_id(), 'product_cat' );
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		$markup['category'] = implode( ' > ', wp_list_pluck( $terms, 'name' ) );
	}

	$brand = get_bloginfo( 'name' );
	if ( $brand ) {
		$markup['brand'] = array(
			'@type' => 'Brand',
			'name'  => $brand,
		);
	}

	return $markup;
}
add_filter( 'woocommerce_structured_data_product', 'xxx_safety_seo_product_schema', 10, 2 );
