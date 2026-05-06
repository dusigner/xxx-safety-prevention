<?php
/**
 * Front page template.
 *
 * @package XXX_Safety_Prevention
 */

get_header();

if ( ! function_exists( 'xxx_safety_home_asset_url' ) ) {
	/**
	 * Return a theme image URL for Home assets.
	 *
	 * @param string $filename File name inside assets/images.
	 * @return string
	 */
	function xxx_safety_home_asset_url( $filename ) {
		return get_template_directory_uri() . '/assets/images/' . ltrim( $filename, '/' );
	}
}

if ( ! function_exists( 'xxx_safety_home_image_url' ) ) {
	/**
	 * Keep old external demo/customizer URLs from breaking production.
	 *
	 * @param string $url      Candidate image URL.
	 * @param string $fallback Local fallback URL.
	 * @return string
	 */
	function xxx_safety_home_image_url( $url, $fallback ) {
		$url  = trim( (string) $url );
		$host = $url ? wp_parse_url( $url, PHP_URL_HOST ) : '';

		if ( ! $url || ! $host ) {
			return $fallback;
		}

		foreach ( array( 'unsplash.com', 'pexels.com', 'pixabay.com' ) as $fragile_host ) {
			if ( false !== strpos( strtolower( $host ), $fragile_host ) ) {
				return $fallback;
			}
		}

		return $url;
	}
}

$main_cta_text = xxx_safety_get_theme_mod( 'main_cta_text', __( 'Solicitar orçamento agora', 'xxx-safety-prevention' ) );
$main_cta_link = xxx_safety_get_theme_mod( 'main_cta_link', '#contato' );
$whatsapp      = preg_replace( '/\D+/', '', xxx_safety_get_theme_mod( 'whatsapp_number', '' ) );
$whatsapp_link = $whatsapp ? 'https://wa.me/' . $whatsapp . '?text=' . rawurlencode( 'Olá, quero solicitar um orçamento para segurança contra incêndio.' ) : '#contato';
$image_fallback = xxx_safety_home_asset_url( 'fire-extinguisher-hero.png' );
$hero_image    = xxx_safety_home_image_url( xxx_safety_get_theme_mod( 'hero_image', '' ), $image_fallback );
$phone         = xxx_safety_get_theme_mod( 'phone', '(11) 3478-2200' );
$email         = xxx_safety_get_theme_mod( 'email', 'contato@empresa.com.br' );

$visuals = array(
	'hero'        => array( 'url' => $hero_image, 'width' => 536, 'height' => 790 ),
	'fallback'    => array( 'url' => $image_fallback, 'width' => 536, 'height' => 790 ),
	'maintenance' => array( 'url' => xxx_safety_home_asset_url( 'fire-service-maintenance.jpg' ), 'width' => 1280, 'height' => 914 ),
	'inspection'  => array( 'url' => xxx_safety_home_asset_url( 'fire-office-extinguisher.jpg' ), 'width' => 1280, 'height' => 1707 ),
	'signage'     => array( 'url' => xxx_safety_home_asset_url( 'fire-emergency-signage.jpg' ), 'width' => 1280, 'height' => 1707 ),
	'hydrant'     => array( 'url' => xxx_safety_home_asset_url( 'fire-hose-equipment.jpg' ), 'width' => 1280, 'height' => 853 ),
	'building'    => array( 'url' => xxx_safety_home_asset_url( 'fire-commercial-building.jpg' ), 'width' => 1280, 'height' => 960 ),
);

$trust_items = array(
	array( 'value' => '24h', 'label' => __( 'resposta comercial e emergencial', 'xxx-safety-prevention' ) ),
	array( 'value' => 'INMETRO', 'label' => __( 'recargas e equipamentos certificados', 'xxx-safety-prevention' ) ),
	array( 'value' => 'NBR', 'label' => __( 'orientação por normas técnicas', 'xxx-safety-prevention' ) ),
	array( 'value' => '15+', 'label' => __( 'anos de experiência no setor', 'xxx-safety-prevention' ) ),
);

$services = array(
	array( 'title' => __( 'Recarga de extintores', 'xxx-safety-prevention' ), 'text' => __( 'Controle de validade, lacre, teste e recarga para manter equipamentos prontos para uso e fiscalização.', 'xxx-safety-prevention' ), 'image' => $visuals['hero'] ),
	array( 'title' => __( 'Manutenção preventiva', 'xxx-safety-prevention' ), 'text' => __( 'Inspeções programadas para identificar falhas antes que elas comprometam a segurança da operação.', 'xxx-safety-prevention' ), 'image' => $visuals['maintenance'] ),
	array( 'title' => __( 'Venda e instalação', 'xxx-safety-prevention' ), 'text' => __( 'Extintores ABC, CO2, sinalização, suportes e equipamentos definidos conforme o risco do ambiente.', 'xxx-safety-prevention' ), 'image' => $visuals['inspection'] ),
	array( 'title' => __( 'Hidrantes e mangueiras', 'xxx-safety-prevention' ), 'text' => __( 'Mangueiras, abrigos, adaptadores e componentes para sistemas de combate bem dimensionados.', 'xxx-safety-prevention' ), 'image' => $visuals['hydrant'] ),
);

$products = array(
	array( 'title' => __( 'Extintores ABC', 'xxx-safety-prevention' ), 'meta' => __( 'Uso amplo em ambientes comerciais', 'xxx-safety-prevention' ) ),
	array( 'title' => __( 'Extintores CO2', 'xxx-safety-prevention' ), 'meta' => __( 'Salas técnicas e áreas elétricas', 'xxx-safety-prevention' ) ),
	array( 'title' => __( 'Placas fotoluminescentes', 'xxx-safety-prevention' ), 'meta' => __( 'Rotas de fuga e identificação', 'xxx-safety-prevention' ) ),
	array( 'title' => __( 'Mangueiras e acessórios', 'xxx-safety-prevention' ), 'meta' => __( 'Hidrantes, abrigos e conexões', 'xxx-safety-prevention' ) ),
);

$steps = array(
	array( 'title' => __( 'Solicitar', 'xxx-safety-prevention' ), 'text' => __( 'Você envia o cenário, urgência e tipo de imóvel.', 'xxx-safety-prevention' ) ),
	array( 'title' => __( 'Avaliar', 'xxx-safety-prevention' ), 'text' => __( 'Mapeamos riscos, equipamentos, validade e sinalização.', 'xxx-safety-prevention' ) ),
	array( 'title' => __( 'Executar', 'xxx-safety-prevention' ), 'text' => __( 'Realizamos recarga, manutenção, instalação ou fornecimento.', 'xxx-safety-prevention' ) ),
	array( 'title' => __( 'Entregar', 'xxx-safety-prevention' ), 'text' => __( 'Orientamos a continuidade preventiva e documentação.', 'xxx-safety-prevention' ) ),
);

$reasons = array(
	array( 'value' => '01', 'title' => __( 'Diagnóstico técnico', 'xxx-safety-prevention' ), 'text' => __( 'A recomendação nasce do risco do ambiente, não de um pacote genérico.', 'xxx-safety-prevention' ) ),
	array( 'value' => '02', 'title' => __( 'Conformidade clara', 'xxx-safety-prevention' ), 'text' => __( 'Serviço orientado por normas técnicas, validade e documentação objetiva.', 'xxx-safety-prevention' ) ),
	array( 'value' => '03', 'title' => __( 'Execução previsível', 'xxx-safety-prevention' ), 'text' => __( 'Escopo, prazo e prioridade definidos antes de iniciar o atendimento.', 'xxx-safety-prevention' ) ),
);

$testimonials = array(
	array( 'quote' => __( 'A equipe trouxe clareza técnica e resolveu a manutenção sem interromper nossa rotina.', 'xxx-safety-prevention' ), 'name' => __( 'Patrícia Nogueira', 'xxx-safety-prevention' ), 'role' => __( 'Gestora administrativa', 'xxx-safety-prevention' ) ),
	array( 'quote' => __( 'O orçamento veio objetivo, com prioridades reais e orientação para manter tudo em dia.', 'xxx-safety-prevention' ), 'name' => __( 'Ricardo Menezes', 'xxx-safety-prevention' ), 'role' => __( 'Síndico profissional', 'xxx-safety-prevention' ) ),
	array( 'quote' => __( 'Atendimento rápido, técnico e cuidadoso. Passou confiança desde a primeira conversa.', 'xxx-safety-prevention' ), 'name' => __( 'Fernanda Alves', 'xxx-safety-prevention' ), 'role' => __( 'Operações de varejo', 'xxx-safety-prevention' ) ),
);

$quote_shortcode = xxx_safety_get_theme_mod( 'quote_form_shortcode', '' );
if ( ! $quote_shortcode ) {
	$quote_shortcode = xxx_safety_get_theme_mod( 'contact_form_shortcode', '' );
}
?>
<main id="primary" class="site-main fire-home fire-home--stable">
	<section class="fire-hero" id="inicio" aria-labelledby="hero-title">
		<div class="fire-hero__texture" aria-hidden="true"></div>
		<div class="fire-hero__glow" aria-hidden="true"></div>
		<div class="fire-hero__smoke fire-hero__smoke--a" aria-hidden="true"></div>
		<div class="fire-hero__smoke fire-hero__smoke--b" aria-hidden="true"></div>
		<div class="fire-hero__sparks" aria-hidden="true"></div>
		<div class="container fire-hero__grid">
			<div class="fire-hero__copy">
				<p class="fire-kicker"><?php esc_html_e( 'PROTEÇÃO CONTRA INCÊNDIO', 'xxx-safety-prevention' ); ?></p>
				<h1 id="hero-title"><?php esc_html_e( 'Segurança técnica para empresas que não podem operar no improviso.', 'xxx-safety-prevention' ); ?></h1>
				<p class="fire-hero__lead"><?php esc_html_e( 'Extintores, recarga certificada, manutenção preventiva, sinalização e equipamentos de combate com atendimento rápido e orientação clara para conformidade.', 'xxx-safety-prevention' ); ?></p>
				<div class="fire-hero__actions">
					<a class="fire-btn fire-btn--primary" href="<?php echo esc_url( $main_cta_link ); ?>"><?php echo esc_html( $main_cta_text ); ?></a>
					<a class="fire-btn fire-btn--ghost" href="<?php echo esc_url( $whatsapp_link ); ?>" target="<?php echo $whatsapp ? '_blank' : '_self'; ?>" rel="<?php echo $whatsapp ? 'noopener noreferrer' : ''; ?>"><?php esc_html_e( 'Falar no WhatsApp', 'xxx-safety-prevention' ); ?></a>
				</div>
				<div class="fire-hero__badges">
					<span><?php esc_html_e( 'Atendimento 24h', 'xxx-safety-prevention' ); ?></span>
					<span><?php esc_html_e( 'Recarga certificada', 'xxx-safety-prevention' ); ?></span>
					<span><?php esc_html_e( 'Normas técnicas', 'xxx-safety-prevention' ); ?></span>
				</div>
			</div>
			<div class="fire-hero__visual">
				<div class="fire-hero__halo" aria-hidden="true"></div>
				<img src="<?php echo esc_url( $visuals['hero']['url'] ); ?>" alt="<?php esc_attr_e( 'Extintor de incêndio em destaque com luz dramática', 'xxx-safety-prevention' ); ?>" width="<?php echo esc_attr( $visuals['hero']['width'] ); ?>" height="<?php echo esc_attr( $visuals['hero']['height'] ); ?>" fetchpriority="high" decoding="async" data-img-fallback="<?php echo esc_url( $image_fallback ); ?>" />
				<div class="fire-hero__seal">
					<strong><?php esc_html_e( 'INMETRO', 'xxx-safety-prevention' ); ?></strong>
					<span><?php esc_html_e( 'equipamentos e recargas certificadas', 'xxx-safety-prevention' ); ?></span>
				</div>
			</div>
			<div class="fire-hero__metrics" aria-label="<?php esc_attr_e( 'Indicadores de confiança', 'xxx-safety-prevention' ); ?>">
				<div><strong class="js-count" data-count="15">15</strong><span><?php esc_html_e( 'anos de experiência', 'xxx-safety-prevention' ); ?></span></div>
				<div><strong class="js-count" data-count="24">24</strong><span><?php esc_html_e( 'horas de atendimento', 'xxx-safety-prevention' ); ?></span></div>
				<div><strong class="js-count" data-count="100">100</strong><span><?php esc_html_e( '% foco em conformidade', 'xxx-safety-prevention' ); ?></span></div>
			</div>
		</div>
	</section>

	<section class="fire-trust" aria-label="<?php esc_attr_e( 'Diferenciais de confiança', 'xxx-safety-prevention' ); ?>">
		<div class="container fire-trust__grid">
			<?php foreach ( $trust_items as $item ) : ?>
				<div>
					<strong><?php echo esc_html( $item['value'] ); ?></strong>
					<span><?php echo esc_html( $item['label'] ); ?></span>
				</div>
			<?php endforeach; ?>
		</div>
	</section>

	<?php if ( xxx_safety_get_theme_mod( 'show_services', true ) ) : ?>
	<section class="fire-section fire-services" id="servicos">
		<div class="container">
			<div class="fire-section__head xxx-animate">
				<p class="fire-kicker"><?php esc_html_e( 'SERVIÇOS ESSENCIAIS', 'xxx-safety-prevention' ); ?></p>
				<h2><?php esc_html_e( 'Prevenção séria começa com equipamentos certos e manutenção no prazo.', 'xxx-safety-prevention' ); ?></h2>
			</div>
			<div class="fire-services__grid">
				<?php foreach ( $services as $index => $service ) : ?>
					<?php $service_image = $service['image']; ?>
					<article class="fire-service xxx-animate">
						<figure>
							<img src="<?php echo esc_url( $service_image['url'] ); ?>" alt="<?php echo esc_attr( $service['title'] ); ?>" width="<?php echo esc_attr( $service_image['width'] ); ?>" height="<?php echo esc_attr( $service_image['height'] ); ?>" loading="lazy" decoding="async" data-img-fallback="<?php echo esc_url( $image_fallback ); ?>" />
						</figure>
						<div>
							<span><?php echo esc_html( str_pad( (string) ( $index + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
							<h3><?php echo esc_html( $service['title'] ); ?></h3>
							<p><?php echo esc_html( $service['text'] ); ?></p>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<?php if ( xxx_safety_get_theme_mod( 'show_products', true ) ) : ?>
	<section class="fire-section fire-products" id="produtos">
		<div class="container fire-products__layout">
			<div class="fire-products__image xxx-animate">
				<img src="<?php echo esc_url( $visuals['signage']['url'] ); ?>" alt="<?php esc_attr_e( 'Sinalização e equipamentos de emergência em ambiente profissional', 'xxx-safety-prevention' ); ?>" width="<?php echo esc_attr( $visuals['signage']['width'] ); ?>" height="<?php echo esc_attr( $visuals['signage']['height'] ); ?>" loading="lazy" decoding="async" data-img-fallback="<?php echo esc_url( $image_fallback ); ?>" />
			</div>
			<div class="fire-products__content">
				<div class="fire-section__head xxx-animate">
					<p class="fire-kicker"><?php esc_html_e( 'PRODUTOS CERTIFICADOS', 'xxx-safety-prevention' ); ?></p>
					<h2><?php esc_html_e( 'Cada ambiente exige uma resposta técnica diferente.', 'xxx-safety-prevention' ); ?></h2>
					<p><?php esc_html_e( 'Orientamos a escolha de extintores, sinalização, mangueiras e acessórios para reduzir risco e evitar compras inadequadas.', 'xxx-safety-prevention' ); ?></p>
				</div>
				<div class="fire-product-list">
					<?php foreach ( $products as $product ) : ?>
						<article class="xxx-animate">
							<h3><?php echo esc_html( $product['title'] ); ?></h3>
							<span><?php echo esc_html( $product['meta'] ); ?></span>
						</article>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<section class="fire-section fire-process">
		<div class="container">
			<div class="fire-section__head fire-section__head--center xxx-animate">
				<p class="fire-kicker"><?php esc_html_e( 'PROCESSO DE ATENDIMENTO', 'xxx-safety-prevention' ); ?></p>
				<h2><?php esc_html_e( 'Do orçamento à entrega, sem ruído e sem surpresa.', 'xxx-safety-prevention' ); ?></h2>
			</div>
			<ol class="fire-process__steps">
				<?php foreach ( $steps as $step ) : ?>
					<li class="xxx-animate">
						<h3><?php echo esc_html( $step['title'] ); ?></h3>
						<p><?php echo esc_html( $step['text'] ); ?></p>
					</li>
				<?php endforeach; ?>
			</ol>
		</div>
	</section>

	<section class="fire-section fire-segments">
		<div class="container fire-segments__layout">
			<div class="fire-segments__copy xxx-animate">
				<p class="fire-kicker"><?php esc_html_e( 'EMPRESAS, CONDOMÍNIOS E COMÉRCIOS', 'xxx-safety-prevention' ); ?></p>
				<h2><?php esc_html_e( 'Projetado para lugares onde pessoas circulam e a operação precisa continuar.', 'xxx-safety-prevention' ); ?></h2>
				<p><?php esc_html_e( 'Atendemos lojas, escritórios, condomínios, galpões e áreas comuns com foco em proteção de vidas, patrimônio e continuidade operacional.', 'xxx-safety-prevention' ); ?></p>
			</div>
			<figure class="fire-segments__image xxx-animate">
				<img src="<?php echo esc_url( $visuals['building']['url'] ); ?>" alt="<?php esc_attr_e( 'Ambiente comercial atendido por plano de prevenção contra incêndio', 'xxx-safety-prevention' ); ?>" width="<?php echo esc_attr( $visuals['building']['width'] ); ?>" height="<?php echo esc_attr( $visuals['building']['height'] ); ?>" loading="lazy" decoding="async" data-img-fallback="<?php echo esc_url( $image_fallback ); ?>" />
			</figure>
		</div>
	</section>

	<section class="fire-section fire-why">
		<div class="container">
			<div class="fire-section__head xxx-animate">
				<p class="fire-kicker"><?php esc_html_e( 'POR QUE ESCOLHER', 'xxx-safety-prevention' ); ?></p>
				<h2><?php esc_html_e( 'A diferença está na orientação antes, durante e depois do serviço.', 'xxx-safety-prevention' ); ?></h2>
			</div>
			<div class="fire-why__grid">
				<?php foreach ( $reasons as $reason ) : ?>
					<article class="xxx-animate">
						<span><?php echo esc_html( $reason['value'] ); ?></span>
						<h3><?php echo esc_html( $reason['title'] ); ?></h3>
						<p><?php echo esc_html( $reason['text'] ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php if ( xxx_safety_get_theme_mod( 'show_testimonials', true ) ) : ?>
	<section class="fire-section fire-testimonials">
		<div class="container">
			<div class="fire-section__head fire-section__head--center xxx-animate">
				<p class="fire-kicker"><?php esc_html_e( 'DEPOIMENTOS', 'xxx-safety-prevention' ); ?></p>
				<h2><?php esc_html_e( 'Confiança aparece quando o cliente entende exatamente o que está sendo feito.', 'xxx-safety-prevention' ); ?></h2>
			</div>
			<div class="fire-testimonials__grid">
				<?php foreach ( $testimonials as $testimonial ) : ?>
					<blockquote class="xxx-animate">
						<p>“<?php echo esc_html( $testimonial['quote'] ); ?>”</p>
						<cite>
							<strong><?php echo esc_html( $testimonial['name'] ); ?></strong>
							<span><?php echo esc_html( $testimonial['role'] ); ?></span>
						</cite>
					</blockquote>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<section class="fire-section fire-contact" id="contato">
		<div class="container fire-contact__grid">
			<div class="fire-contact__copy xxx-animate">
				<p class="fire-kicker"><?php esc_html_e( 'ORÇAMENTO TÉCNICO', 'xxx-safety-prevention' ); ?></p>
				<h2><?php esc_html_e( 'Sua prevenção contra incêndio pode começar agora.', 'xxx-safety-prevention' ); ?></h2>
				<p><?php esc_html_e( 'Envie sua necessidade e receba orientação para recarga, manutenção, compra, sinalização, hidrantes ou adequação técnica.', 'xxx-safety-prevention' ); ?></p>
				<ul>
					<?php if ( $phone ) : ?><li><span><?php esc_html_e( 'Telefone', 'xxx-safety-prevention' ); ?></span><?php echo esc_html( $phone ); ?></li><?php endif; ?>
					<?php if ( $whatsapp ) : ?><li><span><?php esc_html_e( 'WhatsApp', 'xxx-safety-prevention' ); ?></span><?php echo esc_html( '+' . $whatsapp ); ?></li><?php endif; ?>
					<?php if ( $email ) : ?><li><span><?php esc_html_e( 'E-mail', 'xxx-safety-prevention' ); ?></span><?php echo esc_html( $email ); ?></li><?php endif; ?>
				</ul>
			</div>
			<div class="fire-contact__form js-lead-form xxx-animate" data-form-type="quote">
				<?php if ( $quote_shortcode ) : ?>
					<?php echo do_shortcode( $quote_shortcode ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<?php else : ?>
					<form class="fallback-quote-form" action="#contato" method="post">
						<label><?php esc_html_e( 'Nome', 'xxx-safety-prevention' ); ?><input type="text" name="nome" autocomplete="name" required></label>
						<label><?php esc_html_e( 'Telefone/WhatsApp', 'xxx-safety-prevention' ); ?><input type="tel" name="telefone" autocomplete="tel" required></label>
						<label><?php esc_html_e( 'Serviço desejado', 'xxx-safety-prevention' ); ?><select name="servico" required><option value=""><?php esc_html_e( 'Selecione', 'xxx-safety-prevention' ); ?></option><option><?php esc_html_e( 'Recarga de extintores', 'xxx-safety-prevention' ); ?></option><option><?php esc_html_e( 'Manutenção preventiva', 'xxx-safety-prevention' ); ?></option><option><?php esc_html_e( 'Venda de equipamentos', 'xxx-safety-prevention' ); ?></option><option><?php esc_html_e( 'Projeto técnico', 'xxx-safety-prevention' ); ?></option></select></label>
						<label><?php esc_html_e( 'Mensagem', 'xxx-safety-prevention' ); ?><textarea name="mensagem" rows="5" required></textarea></label>
						<button class="fire-btn fire-btn--primary" type="submit"><?php esc_html_e( 'Enviar solicitação', 'xxx-safety-prevention' ); ?></button>
					</form>
				<?php endif; ?>
			</div>
		</div>
	</section>
</main>
<?php get_footer();
