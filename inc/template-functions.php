<?php
/**
 * Template helpers.
 *
 * @package XXX_Safety_Prevention
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function xxx_safety_body_classes( $classes ) {
	if ( is_front_page() ) {
		$classes[] = 'is-premium-home';
	}

	if ( ! xxx_safety_get_theme_mod( 'enable_animations', true ) ) {
		$classes[] = 'xxx-reduced-motion';
	}

	return $classes;
}
add_filter( 'body_class', 'xxx_safety_body_classes' );

function xxx_safety_inline_css_vars() {
	$primary = xxx_safety_get_theme_mod( 'primary_color', '#ff6a00' );
	if ( ! $primary ) {
		return;
	}

	$css = ':root{--color-primary:' . esc_attr( $primary ) . ';}';
	wp_add_inline_style( 'xxx-safety-main', $css );
}
add_action( 'wp_enqueue_scripts', 'xxx_safety_inline_css_vars', 20 );

function xxx_safety_inner_hero( $title ) {
	$background = xxx_safety_get_theme_mod( 'internal_hero_default', '' );
	$subtitle   = esc_html__( 'Projetos e soluções com padrão técnico para operações corporativas.', 'xxx-safety-prevention' );

	if ( is_page() ) {
		$slug_map = array(
			'sobre'                => esc_html__( 'Conheça nossa estrutura, metodologia e diferenciais técnicos.', 'xxx-safety-prevention' ),
			'servicos'             => esc_html__( 'Do diagnóstico ao suporte contínuo, com execução especializada.', 'xxx-safety-prevention' ),
			'produtos'             => esc_html__( 'Equipamentos certificados com orientação de aplicação.', 'xxx-safety-prevention' ),
			'contato'              => esc_html__( 'Atendimento consultivo para empresas, condomínios e comércios.', 'xxx-safety-prevention' ),
			'extintores'           => esc_html__( 'Dimensionamento e fornecimento adequado ao risco da operação.', 'xxx-safety-prevention' ),
			'avcb-consultoria'     => esc_html__( 'Condução técnica da regularização com foco em prazo e conformidade.', 'xxx-safety-prevention' ),
			'recarga-manutencao'   => esc_html__( 'Controle de validade e manutenção preventiva com rastreabilidade.', 'xxx-safety-prevention' ),
			'treinamentos'         => esc_html__( 'Capacitação prática para brigada e equipes operacionais.', 'xxx-safety-prevention' ),
			'sinalizacao-emergencia' => esc_html__( 'Projeto e instalação de sinalização para evacuação segura.', 'xxx-safety-prevention' ),
		);
		$slug     = get_post_field( 'post_name', get_the_ID() );
		$subtitle = isset( $slug_map[ $slug ] ) ? $slug_map[ $slug ] : $subtitle;
	}

	get_template_part(
		'template-parts/hero-internal',
		null,
		array(
			'title'      => $title,
			'subtitle'   => $subtitle,
			'background' => $background,
		)
	);
}

function xxx_safety_breadcrumb() {
	$home_label = esc_html__( 'Início', 'xxx-safety-prevention' );
	echo '<nav class="breadcrumb" aria-label="Breadcrumb">';
	echo '<a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html( $home_label ) . '</a>';

	if ( is_page() || is_single() || is_product() ) {
		echo '<span aria-hidden="true">/</span><span>' . esc_html( get_the_title() ) . '</span>';
	} elseif ( is_archive() ) {
		echo '<span aria-hidden="true">/</span><span>' . esc_html( get_the_archive_title() ) . '</span>';
	}

	echo '</nav>';
}

function xxx_safety_bottom_cta() {
	$cta_text = xxx_safety_get_theme_mod( 'main_cta_text', 'Solicitar Orçamento' );
	$cta_link = xxx_safety_get_theme_mod( 'main_cta_link', '#contato' );
	?>
	<section class="section cta-band xxx-animate xxx-fade-up">
		<div class="container cta-band__inner">
			<div>
				<h2><?php esc_html_e( 'Precisa regularizar sua operação com segurança total?', 'xxx-safety-prevention' ); ?></h2>
				<p><?php esc_html_e( 'Fale com nossa equipe técnica e receba um plano de ação com prazo e investimento claros.', 'xxx-safety-prevention' ); ?></p>
			</div>
			<a class="btn" href="<?php echo esc_url( $cta_link ); ?>"><?php echo esc_html( $cta_text ); ?></a>
		</div>
	</section>
	<?php
}

function xxx_safety_cookie_consent_banner() {
	if ( ! xxx_safety_get_theme_mod( 'enable_cookie_consent', true ) ) {
		return;
	}
	?>
	<div class="xxx-cookie-consent" data-cookie-consent hidden>
		<div class="xxx-cookie-consent__inner" role="dialog" aria-live="polite" aria-label="<?php esc_attr_e( 'Preferências de cookies', 'xxx-safety-prevention' ); ?>">
			<div class="xxx-cookie-consent__copy">
				<p class="xxx-cookie-consent__title"><?php esc_html_e( 'Privacidade e cookies', 'xxx-safety-prevention' ); ?></p>
				<p>
					<?php esc_html_e( 'Usamos cookies necessários para o funcionamento do site e, com seu consentimento, cookies analíticos para entender o uso das páginas e melhorar a experiência. Você pode aceitar ou recusar os cookies analíticos.', 'xxx-safety-prevention' ); ?>
					<a href="<?php echo esc_url( home_url( '/politica-de-privacidade/' ) ); ?>"><?php esc_html_e( 'Política de Privacidade', 'xxx-safety-prevention' ); ?></a>.
				</p>
			</div>
			<div class="xxx-cookie-consent__actions">
				<button type="button" class="xxx-cookie-consent__button xxx-cookie-consent__button--ghost" data-cookie-decline><?php esc_html_e( 'Recusar analíticos', 'xxx-safety-prevention' ); ?></button>
				<button type="button" class="xxx-cookie-consent__button" data-cookie-accept><?php esc_html_e( 'Aceitar analíticos', 'xxx-safety-prevention' ); ?></button>
			</div>
		</div>
	</div>
	<?php
}
add_action( 'wp_footer', 'xxx_safety_cookie_consent_banner', 20 );
