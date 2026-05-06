<?php
/**
 * Front page template.
 *
 * @package XXX_Safety_Prevention
 */

get_header();

$main_cta_text = xxx_safety_get_theme_mod( 'main_cta_text', __( 'Solicitar orçamento agora', 'xxx-safety-prevention' ) );
$main_cta_link = xxx_safety_get_theme_mod( 'main_cta_link', '#contato' );
$whatsapp      = preg_replace( '/\D+/', '', xxx_safety_get_theme_mod( 'whatsapp_number', '' ) );
$whatsapp_link = $whatsapp ? 'https://wa.me/' . $whatsapp . '?text=' . rawurlencode( 'Olá, quero solicitar um orçamento para segurança contra incêndio.' ) : '#contato';
$hero_image    = xxx_safety_get_theme_mod( 'hero_image', get_template_directory_uri() . '/assets/images/fire-extinguisher-hero.png' );
$phone         = xxx_safety_get_theme_mod( 'phone', '(11) 3478-2200' );
$email         = xxx_safety_get_theme_mod( 'email', 'contato@empresa.com.br' );

$image_base = get_template_directory_uri() . '/assets/images/';
$visuals    = array(
	'extinguisher' => $image_base . 'fire-extinguisher-hero.png',
	'maintenance'  => 'https://images.unsplash.com/photo-1504917595217-d4dc5ebe6122?auto=format&fit=crop&w=1100&q=82',
	'inspection'   => 'https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=1100&q=82',
	'signage'      => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=1000&q=82',
	'hydrant'      => 'https://images.unsplash.com/photo-1516937941344-00b4e0337589?auto=format&fit=crop&w=1000&q=82',
	'company'      => 'https://images.unsplash.com/photo-1497366811353-6870744d04b2?auto=format&fit=crop&w=1300&q=82',
);

$hero_badges = array(
	__( 'Atendimento 24h', 'xxx-safety-prevention' ),
	__( 'Recarga certificada', 'xxx-safety-prevention' ),
	__( 'Normas técnicas', 'xxx-safety-prevention' ),
	__( 'Orçamento rápido', 'xxx-safety-prevention' ),
);

$trust_items = array(
	array( 'value' => '15+', 'label' => __( 'anos de experiência aplicada', 'xxx-safety-prevention' ) ),
	array( 'value' => '24h', 'label' => __( 'resposta para demandas urgentes', 'xxx-safety-prevention' ) ),
	array( 'value' => 'INMETRO', 'label' => __( 'equipamentos e recargas certificadas', 'xxx-safety-prevention' ) ),
	array( 'value' => 'ABNT', 'label' => __( 'orientação por normas técnicas', 'xxx-safety-prevention' ) ),
);

$services = array(
	array( 'title' => __( 'Recarga de extintores', 'xxx-safety-prevention' ), 'text' => __( 'Recarga, teste, lacre, validade e rastreabilidade para manter sua operação pronta para fiscalização e emergência.', 'xxx-safety-prevention' ), 'image' => $visuals['extinguisher'] ),
	array( 'title' => __( 'Manutenção preventiva', 'xxx-safety-prevention' ), 'text' => __( 'Inspeções programadas, correções e relatórios para evitar equipamentos vencidos, falhas e retrabalho.', 'xxx-safety-prevention' ), 'image' => $visuals['maintenance'] ),
	array( 'title' => __( 'Venda de extintores', 'xxx-safety-prevention' ), 'text' => __( 'Extintores ABC, CO2 e modelos adequados ao risco do ambiente, com orientação técnica para compra correta.', 'xxx-safety-prevention' ), 'image' => $visuals['inspection'] ),
	array( 'title' => __( 'Mangueiras e hidrantes', 'xxx-safety-prevention' ), 'text' => __( 'Mangueiras, abrigos, adaptadores, esguichos e componentes para sistemas de combate bem dimensionados.', 'xxx-safety-prevention' ), 'image' => $visuals['hydrant'] ),
	array( 'title' => __( 'Projetos técnicos', 'xxx-safety-prevention' ), 'text' => __( 'Levantamento de riscos, plano de adequação e condução técnica para ambientes comerciais e corporativos.', 'xxx-safety-prevention' ), 'image' => $visuals['company'] ),
	array( 'title' => __( 'Sinalização de emergência', 'xxx-safety-prevention' ), 'text' => __( 'Rotas de fuga, placas, iluminação e sinalização para orientar pessoas com clareza em situações críticas.', 'xxx-safety-prevention' ), 'image' => $visuals['signage'] ),
);

$products = array(
	array( 'title' => __( 'Extintores ABC', 'xxx-safety-prevention' ), 'label' => __( 'Uso amplo', 'xxx-safety-prevention' ), 'text' => __( 'Para classes A, B e C, com orientação de capacidade, instalação e validade.', 'xxx-safety-prevention' ), 'image' => $visuals['extinguisher'] ),
	array( 'title' => __( 'Extintores CO2', 'xxx-safety-prevention' ), 'label' => __( 'Áreas elétricas', 'xxx-safety-prevention' ), 'text' => __( 'Indicados para painéis, salas técnicas e ambientes com equipamentos sensíveis.', 'xxx-safety-prevention' ), 'image' => $visuals['inspection'] ),
	array( 'title' => __( 'Placas de sinalização', 'xxx-safety-prevention' ), 'label' => __( 'Rotas seguras', 'xxx-safety-prevention' ), 'text' => __( 'Sinalização fotoluminescente para equipamentos, saídas e evacuação.', 'xxx-safety-prevention' ), 'image' => $visuals['signage'] ),
	array( 'title' => __( 'Mangueiras de incêndio', 'xxx-safety-prevention' ), 'label' => __( 'Hidrantes', 'xxx-safety-prevention' ), 'text' => __( 'Mangueiras e acessórios para sistemas de combate em empresas e condomínios.', 'xxx-safety-prevention' ), 'image' => $visuals['hydrant'] ),
);

$steps = array(
	array( 'title' => __( 'Solicitação', 'xxx-safety-prevention' ), 'text' => __( 'Você envia a necessidade, prazo e tipo de imóvel para entendermos a urgência.', 'xxx-safety-prevention' ) ),
	array( 'title' => __( 'Avaliação técnica', 'xxx-safety-prevention' ), 'text' => __( 'Analisamos riscos, equipamentos, validade, rotas, sinalização e prioridades.', 'xxx-safety-prevention' ) ),
	array( 'title' => __( 'Execução', 'xxx-safety-prevention' ), 'text' => __( 'A equipe realiza instalação, recarga, manutenção ou fornecimento com processo claro.', 'xxx-safety-prevention' ) ),
	array( 'title' => __( 'Entrega e orientação', 'xxx-safety-prevention' ), 'text' => __( 'Você recebe documentação, recomendações e apoio para manter a prevenção em dia.', 'xxx-safety-prevention' ) ),
);

$reasons = array(
	array( 'title' => __( 'Diagnóstico antes da venda', 'xxx-safety-prevention' ), 'text' => __( 'Indicamos o que faz sentido para o risco do ambiente, sem empurrar soluções genéricas.', 'xxx-safety-prevention' ) ),
	array( 'title' => __( 'Conformidade documentada', 'xxx-safety-prevention' ), 'text' => __( 'Serviços orientados por normas técnicas, controle de validade e informações úteis para auditorias.', 'xxx-safety-prevention' ) ),
	array( 'title' => __( 'Execução com previsibilidade', 'xxx-safety-prevention' ), 'text' => __( 'Escopo claro, prazo combinado e rotina pensada para não interromper a operação do cliente.', 'xxx-safety-prevention' ) ),
	array( 'title' => __( 'Resposta comercial ágil', 'xxx-safety-prevention' ), 'text' => __( 'Atendimento direto para orçamento, emergência, manutenção corretiva ou plano preventivo.', 'xxx-safety-prevention' ) ),
);

$segments = array(
	array( 'title' => __( 'Empresas', 'xxx-safety-prevention' ), 'text' => __( 'Ambientes administrativos, lojas, escritórios e operações com fluxo diário.', 'xxx-safety-prevention' ) ),
	array( 'title' => __( 'Condomínios', 'xxx-safety-prevention' ), 'text' => __( 'Rotina preventiva para áreas comuns, garagens, halls e casas de máquinas.', 'xxx-safety-prevention' ) ),
	array( 'title' => __( 'Comércios', 'xxx-safety-prevention' ), 'text' => __( 'Equipamentos, sinalização e manutenção para atendimento ao público com segurança.', 'xxx-safety-prevention' ) ),
);

$testimonials = array(
	array( 'quote' => __( 'A equipe trouxe clareza técnica, resolveu a manutenção e deixou o controle de validade muito mais organizado.', 'xxx-safety-prevention' ), 'name' => __( 'Patrícia Nogueira', 'xxx-safety-prevention' ), 'role' => __( 'Gestora administrativa', 'xxx-safety-prevention' ) ),
	array( 'quote' => __( 'Precisávamos agir rápido sem paralisar o condomínio. O atendimento foi direto, profissional e muito seguro.', 'xxx-safety-prevention' ), 'name' => __( 'Ricardo Menezes', 'xxx-safety-prevention' ), 'role' => __( 'Síndico profissional', 'xxx-safety-prevention' ) ),
	array( 'quote' => __( 'O orçamento veio claro, com orientação do que era obrigatório e do que poderia ser planejado em etapas.', 'xxx-safety-prevention' ), 'name' => __( 'Fernanda Alves', 'xxx-safety-prevention' ), 'role' => __( 'Operações de varejo', 'xxx-safety-prevention' ) ),
);

$quote_shortcode = xxx_safety_get_theme_mod( 'quote_form_shortcode', '' );
if ( ! $quote_shortcode ) {
	$quote_shortcode = xxx_safety_get_theme_mod( 'contact_form_shortcode', '' );
}
?>
<main id="primary" class="site-main front-page cinematic-home">
	<section class="hero premium-hero hero-cinematic" id="inicio" aria-labelledby="hero-title">
		<div class="hero-industrial" aria-hidden="true"></div>
		<div class="hero-fire" aria-hidden="true"></div>
		<div class="hero-smoke hero-smoke--one" aria-hidden="true"></div>
		<div class="hero-smoke hero-smoke--two" aria-hidden="true"></div>
		<div class="hero-particles" aria-hidden="true"></div>
		<div class="container hero-grid">
			<div class="hero-copy">
				<span class="eyebrow hero-eyebrow"><?php esc_html_e( 'Prevenção, combate e conformidade contra incêndio', 'xxx-safety-prevention' ); ?></span>
				<h1 id="hero-title"><?php esc_html_e( 'Extintores e segurança contra incêndio para operações que não podem falhar.', 'xxx-safety-prevention' ); ?></h1>
				<p class="hero-lead"><?php esc_html_e( 'Instalação, manutenção, recarga certificada, venda de equipamentos e projetos técnicos com atendimento rápido para empresas, condomínios e comércios.', 'xxx-safety-prevention' ); ?></p>
				<div class="hero-badge-grid" aria-label="<?php esc_attr_e( 'Diferenciais principais', 'xxx-safety-prevention' ); ?>">
					<?php foreach ( $hero_badges as $badge ) : ?>
						<span><?php echo esc_html( $badge ); ?></span>
					<?php endforeach; ?>
				</div>
				<div class="hero-cta">
					<a href="<?php echo esc_url( $main_cta_link ); ?>" class="btn btn-primary"><?php echo esc_html( $main_cta_text ); ?></a>
					<a href="<?php echo esc_url( $whatsapp_link ); ?>" class="btn btn-whatsapp" target="<?php echo $whatsapp ? '_blank' : '_self'; ?>" rel="<?php echo $whatsapp ? 'noopener noreferrer' : ''; ?>"><?php esc_html_e( 'Falar no WhatsApp', 'xxx-safety-prevention' ); ?></a>
				</div>
				<div class="hero-metrics" aria-label="<?php esc_attr_e( 'Indicadores de confiança', 'xxx-safety-prevention' ); ?>">
					<div><strong class="js-count" data-count="15">15</strong><span><?php esc_html_e( 'anos de experiência', 'xxx-safety-prevention' ); ?></span></div>
					<div><strong class="js-count" data-count="24">24</strong><span><?php esc_html_e( 'horas de resposta', 'xxx-safety-prevention' ); ?></span></div>
					<div><strong class="js-count" data-count="100">100</strong><span><?php esc_html_e( '% foco em segurança', 'xxx-safety-prevention' ); ?></span></div>
				</div>
			</div>
			<div class="hero-visual-stack">
				<div class="hero-light" aria-hidden="true"></div>
				<figure class="hero-media card">
					<img src="<?php echo esc_url( $hero_image ); ?>" alt="<?php esc_attr_e( 'Extintor de incêndio em destaque com iluminação dramática', 'xxx-safety-prevention' ); ?>" width="536" height="790" fetchpriority="high" decoding="async" />
				</figure>
				<div class="hero-floating-card hero-floating-card--top">
					<strong><?php esc_html_e( 'Resposta rápida', 'xxx-safety-prevention' ); ?></strong>
					<span><?php esc_html_e( 'orçamento técnico com prioridade', 'xxx-safety-prevention' ); ?></span>
				</div>
				<div class="hero-floating-card hero-floating-card--bottom">
					<strong><?php esc_html_e( 'Pronto para vistoria', 'xxx-safety-prevention' ); ?></strong>
					<span><?php esc_html_e( 'recarga, validade e orientação', 'xxx-safety-prevention' ); ?></span>
				</div>
			</div>
		</div>
	</section>

	<?php if ( xxx_safety_get_theme_mod( 'show_brands', true ) ) : ?>
	<section class="trust-strip trust-strip--cinematic" aria-label="<?php esc_attr_e( 'Diferenciais de confiança', 'xxx-safety-prevention' ); ?>">
		<div class="container trust-grid">
			<?php foreach ( $trust_items as $item ) : ?>
				<div class="trust-item">
					<strong><?php echo esc_html( $item['value'] ); ?></strong>
					<span><?php echo esc_html( $item['label'] ); ?></span>
				</div>
			<?php endforeach; ?>
		</div>
	</section>
	<?php endif; ?>

	<section class="section visual-story">
		<div class="container story-grid">
			<div class="story-copy xxx-animate">
				<p class="eyebrow"><?php esc_html_e( 'Primeiro, segurança. Depois, tranquilidade.', 'xxx-safety-prevention' ); ?></p>
				<h2><?php esc_html_e( 'Prevenção contra incêndio exige técnica, rotina e equipamentos no prazo certo.', 'xxx-safety-prevention' ); ?></h2>
				<p><?php esc_html_e( 'Uma operação segura não depende de improviso. Ela depende de inspeção, manutenção correta, sinalização clara e uma equipe que saiba orientar o cliente antes da urgência virar problema.', 'xxx-safety-prevention' ); ?></p>
			</div>
			<div class="story-collage">
				<figure class="image-card image-card--large xxx-animate">
					<img src="<?php echo esc_url( $visuals['maintenance'] ); ?>" alt="<?php esc_attr_e( 'Técnico realizando manutenção preventiva em ambiente profissional', 'xxx-safety-prevention' ); ?>" loading="lazy" decoding="async" />
					<figcaption><?php esc_html_e( 'Manutenção técnica programada', 'xxx-safety-prevention' ); ?></figcaption>
				</figure>
				<figure class="image-card image-card--small xxx-animate">
					<img src="<?php echo esc_url( $visuals['signage'] ); ?>" alt="<?php esc_attr_e( 'Sinalização de emergência em área de circulação', 'xxx-safety-prevention' ); ?>" loading="lazy" decoding="async" />
					<figcaption><?php esc_html_e( 'Rotas e sinalização', 'xxx-safety-prevention' ); ?></figcaption>
				</figure>
			</div>
		</div>
	</section>

	<?php if ( xxx_safety_get_theme_mod( 'show_services', true ) ) : ?>
	<section class="section services services-cinematic" id="servicos">
		<div class="container">
			<div class="section-head section-head--wide xxx-animate">
				<p class="eyebrow"><?php esc_html_e( 'Serviços principais', 'xxx-safety-prevention' ); ?></p>
				<h2><?php esc_html_e( 'Da recarga do extintor ao plano preventivo completo.', 'xxx-safety-prevention' ); ?></h2>
				<p><?php esc_html_e( 'Soluções técnicas para manter sua empresa regularizada, protegida e preparada para agir com segurança.', 'xxx-safety-prevention' ); ?></p>
			</div>
			<div class="service-showcase-grid">
				<?php foreach ( $services as $index => $service ) : ?>
					<article class="service-cinema-card xxx-animate">
						<figure>
							<img src="<?php echo esc_url( $service['image'] ); ?>" alt="<?php echo esc_attr( $service['title'] ); ?>" loading="lazy" decoding="async" />
						</figure>
						<div>
							<span><?php echo esc_html( str_pad( (string) ( $index + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
							<h3><?php echo esc_html( $service['title'] ); ?></h3>
							<p><?php echo esc_html( $service['text'] ); ?></p>
							<a href="<?php echo esc_url( $main_cta_link ); ?>"><?php esc_html_e( 'Solicitar avaliação', 'xxx-safety-prevention' ); ?></a>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<?php if ( xxx_safety_get_theme_mod( 'show_products', true ) ) : ?>
	<section class="section product-section" id="produtos">
		<div class="container">
			<div class="section-head section-head--between xxx-animate">
				<div>
					<p class="eyebrow"><?php esc_html_e( 'Produtos em destaque', 'xxx-safety-prevention' ); ?></p>
					<h2><?php esc_html_e( 'Equipamentos corretos reduzem risco e aumentam confiança.', 'xxx-safety-prevention' ); ?></h2>
				</div>
				<?php if ( class_exists( 'WooCommerce' ) ) : ?>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn btn-outline"><?php esc_html_e( 'Ver catálogo', 'xxx-safety-prevention' ); ?></a>
				<?php endif; ?>
			</div>
			<div class="product-cards">
				<?php foreach ( $products as $product ) : ?>
					<article class="product-cinema-card xxx-animate">
						<img src="<?php echo esc_url( $product['image'] ); ?>" alt="<?php echo esc_attr( $product['title'] ); ?>" loading="lazy" decoding="async" />
						<div>
							<span><?php echo esc_html( $product['label'] ); ?></span>
							<h3><?php echo esc_html( $product['title'] ); ?></h3>
							<p><?php echo esc_html( $product['text'] ); ?></p>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<section class="section process-section process-cinematic">
		<div class="container">
			<div class="process-layout">
				<div class="section-head xxx-animate">
					<p class="eyebrow"><?php esc_html_e( 'Processo simples', 'xxx-safety-prevention' ); ?></p>
					<h2><?php esc_html_e( 'Você entende o que precisa ser feito antes de aprovar o orçamento.', 'xxx-safety-prevention' ); ?></h2>
					<p><?php esc_html_e( 'Sem linguagem confusa, sem escopo solto. A Proteção Fire organiza o atendimento para você decidir com segurança.', 'xxx-safety-prevention' ); ?></p>
					<a href="<?php echo esc_url( $main_cta_link ); ?>" class="btn"><?php esc_html_e( 'Iniciar orçamento', 'xxx-safety-prevention' ); ?></a>
				</div>
				<ol class="timeline-steps">
					<?php foreach ( $steps as $step ) : ?>
						<li class="xxx-animate">
							<h3><?php echo esc_html( $step['title'] ); ?></h3>
							<p><?php echo esc_html( $step['text'] ); ?></p>
						</li>
					<?php endforeach; ?>
				</ol>
			</div>
		</div>
	</section>

	<section class="section segment-section segment-cinematic">
		<div class="container segment-layout">
			<figure class="image-card segment-image xxx-animate">
				<img src="<?php echo esc_url( $visuals['company'] ); ?>" alt="<?php esc_attr_e( 'Ambiente corporativo atendido por soluções de prevenção contra incêndio', 'xxx-safety-prevention' ); ?>" loading="lazy" decoding="async" />
			</figure>
			<div class="segment-content xxx-animate">
				<p class="eyebrow"><?php esc_html_e( 'Para empresas, condomínios e comércios', 'xxx-safety-prevention' ); ?></p>
				<h2><?php esc_html_e( 'Atendimento para ambientes onde segurança, prazo e conformidade importam.', 'xxx-safety-prevention' ); ?></h2>
				<div class="segment-cards">
					<?php foreach ( $segments as $segment ) : ?>
						<article>
							<h3><?php echo esc_html( $segment['title'] ); ?></h3>
							<p><?php echo esc_html( $segment['text'] ); ?></p>
						</article>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</section>

	<section class="section why-section why-cinematic">
		<div class="container">
			<div class="section-head center xxx-animate">
				<p class="eyebrow"><?php esc_html_e( 'Por que escolher a Proteção Fire?', 'xxx-safety-prevention' ); ?></p>
				<h2><?php esc_html_e( 'Uma decisão técnica que passa confiança para gestores, moradores e clientes.', 'xxx-safety-prevention' ); ?></h2>
			</div>
			<div class="reason-grid">
				<?php foreach ( $reasons as $reason ) : ?>
					<article class="reason-card xxx-animate">
						<h3><?php echo esc_html( $reason['title'] ); ?></h3>
						<p><?php echo esc_html( $reason['text'] ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php if ( xxx_safety_get_theme_mod( 'show_testimonials', true ) ) : ?>
	<section class="section testimonials-section testimonials-cinematic">
		<div class="container">
			<div class="section-head xxx-animate">
				<p class="eyebrow"><?php esc_html_e( 'Prova de confiança', 'xxx-safety-prevention' ); ?></p>
				<h2><?php esc_html_e( 'Clientes sentem a diferença quando o atendimento é técnico e transparente.', 'xxx-safety-prevention' ); ?></h2>
			</div>
			<div class="testimonial-layout">
				<?php foreach ( $testimonials as $testimonial ) : ?>
					<blockquote class="testimonial-card xxx-animate">
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

	<section class="section final-cta">
		<div class="container final-cta-panel xxx-animate">
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Orçamento rápido', 'xxx-safety-prevention' ); ?></p>
				<h2><?php esc_html_e( 'Regularize, mantenha e proteja sua operação com quem entende de prevenção.', 'xxx-safety-prevention' ); ?></h2>
				<p><?php esc_html_e( 'Envie sua solicitação agora. Nossa equipe orienta o melhor caminho para manutenção, recarga, compra, instalação ou projeto técnico.', 'xxx-safety-prevention' ); ?></p>
			</div>
			<div class="cta-actions">
				<a class="btn" href="<?php echo esc_url( $main_cta_link ); ?>"><?php echo esc_html( $main_cta_text ); ?></a>
				<a class="btn btn-outline" href="<?php echo esc_url( $whatsapp_link ); ?>" target="<?php echo $whatsapp ? '_blank' : '_self'; ?>" rel="<?php echo $whatsapp ? 'noopener noreferrer' : ''; ?>"><?php esc_html_e( 'WhatsApp', 'xxx-safety-prevention' ); ?></a>
			</div>
		</div>
	</section>

	<section class="section quote-section quote-cinematic" id="contato">
		<div class="container quote-grid">
			<div class="quote-copy xxx-animate">
				<p class="eyebrow"><?php esc_html_e( 'Solicite um orçamento', 'xxx-safety-prevention' ); ?></p>
				<h2><?php esc_html_e( 'Conte o cenário. Nós indicamos o próximo passo com clareza.', 'xxx-safety-prevention' ); ?></h2>
				<p><?php esc_html_e( 'Preencha o formulário para manutenção, recarga, compra de extintores, sinalização, mangueiras, hidrantes, inspeção preventiva ou atendimento recorrente.', 'xxx-safety-prevention' ); ?></p>
				<ul class="contact-list">
					<?php if ( $phone ) : ?><li><span><?php esc_html_e( 'Telefone', 'xxx-safety-prevention' ); ?></span><strong><?php echo esc_html( $phone ); ?></strong></li><?php endif; ?>
					<?php if ( $whatsapp ) : ?><li><span><?php esc_html_e( 'WhatsApp', 'xxx-safety-prevention' ); ?></span><strong><?php echo esc_html( '+' . $whatsapp ); ?></strong></li><?php endif; ?>
					<?php if ( $email ) : ?><li><span><?php esc_html_e( 'E-mail', 'xxx-safety-prevention' ); ?></span><strong><?php echo esc_html( $email ); ?></strong></li><?php endif; ?>
				</ul>
			</div>
			<div class="quote-form-card card js-lead-form xxx-animate" data-form-type="quote">
				<?php if ( $quote_shortcode ) : ?>
					<?php echo do_shortcode( $quote_shortcode ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<?php else : ?>
					<form class="fallback-quote-form" action="#contato" method="post">
						<label><?php esc_html_e( 'Nome', 'xxx-safety-prevention' ); ?><input type="text" name="nome" autocomplete="name" required></label>
						<label><?php esc_html_e( 'Telefone/WhatsApp', 'xxx-safety-prevention' ); ?><input type="tel" name="telefone" autocomplete="tel" required></label>
						<label><?php esc_html_e( 'Serviço desejado', 'xxx-safety-prevention' ); ?><select name="servico" required><option value=""><?php esc_html_e( 'Selecione', 'xxx-safety-prevention' ); ?></option><option><?php esc_html_e( 'Recarga de extintores', 'xxx-safety-prevention' ); ?></option><option><?php esc_html_e( 'Manutenção preventiva', 'xxx-safety-prevention' ); ?></option><option><?php esc_html_e( 'Venda de equipamentos', 'xxx-safety-prevention' ); ?></option><option><?php esc_html_e( 'Projeto técnico', 'xxx-safety-prevention' ); ?></option></select></label>
						<label><?php esc_html_e( 'Mensagem', 'xxx-safety-prevention' ); ?><textarea name="mensagem" rows="5" required></textarea></label>
						<button class="btn" type="submit"><?php esc_html_e( 'Enviar solicitação', 'xxx-safety-prevention' ); ?></button>
					</form>
				<?php endif; ?>
			</div>
		</div>
	</section>
</main>
<?php get_footer();
