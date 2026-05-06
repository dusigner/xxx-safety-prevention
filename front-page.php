<?php
/**
 * Front page template.
 *
 * @package XXX_Safety_Prevention
 */

get_header();

$main_cta_text = xxx_safety_get_theme_mod( 'main_cta_text', __( 'Solicitar orçamento', 'xxx-safety-prevention' ) );
$main_cta_link = xxx_safety_get_theme_mod( 'main_cta_link', '#contato' );
$whatsapp      = preg_replace( '/\D+/', '', xxx_safety_get_theme_mod( 'whatsapp_number', '' ) );
$whatsapp_link = $whatsapp ? 'https://wa.me/' . $whatsapp . '?text=' . rawurlencode( 'Olá, gostaria de solicitar um orçamento de segurança contra incêndio.' ) : '#contato';
$hero_image    = xxx_safety_get_theme_mod( 'hero_image', get_template_directory_uri() . '/assets/images/fire-extinguisher-hero.png' );
$highlight     = xxx_safety_get_theme_mod( 'hero_highlight', __( 'Atendimento para empresas, condomínios, comércios e indústrias', 'xxx-safety-prevention' ) );
$phone         = xxx_safety_get_theme_mod( 'phone', '(11) 3478-2200' );
$email         = xxx_safety_get_theme_mod( 'email', 'contato@empresa.com.br' );

$trust_items = array(
	array( 'value' => __( 'INMETRO', 'xxx-safety-prevention' ), 'label' => __( 'Equipamentos certificados', 'xxx-safety-prevention' ) ),
	array( 'value' => __( '24h', 'xxx-safety-prevention' ), 'label' => __( 'Atendimento rápido', 'xxx-safety-prevention' ) ),
	array( 'value' => __( 'Equipe técnica', 'xxx-safety-prevention' ), 'label' => __( 'Instalação e manutenção', 'xxx-safety-prevention' ) ),
	array( 'value' => __( 'Orçamento ágil', 'xxx-safety-prevention' ), 'label' => __( 'Diagnóstico consultivo', 'xxx-safety-prevention' ) ),
);

$services = array(
	array( 'kicker' => '01', 'title' => __( 'Recarga de extintores', 'xxx-safety-prevention' ), 'text' => __( 'Recarga certificada, controle de validade e rastreabilidade para manter sua operação em conformidade.', 'xxx-safety-prevention' ) ),
	array( 'kicker' => '02', 'title' => __( 'Manutenção preventiva', 'xxx-safety-prevention' ), 'text' => __( 'Inspeções programadas, testes, substituições e relatórios para reduzir riscos e evitar vencimentos.', 'xxx-safety-prevention' ) ),
	array( 'kicker' => '03', 'title' => __( 'Venda de extintores', 'xxx-safety-prevention' ), 'text' => __( 'Dimensionamento e fornecimento de extintores ABC, CO2 e modelos adequados ao risco do ambiente.', 'xxx-safety-prevention' ) ),
	array( 'kicker' => '04', 'title' => __( 'Mangueiras e hidrantes', 'xxx-safety-prevention' ), 'text' => __( 'Equipamentos de combate, abrigos, acessórios e suporte técnico para redes de hidrantes.', 'xxx-safety-prevention' ) ),
	array( 'kicker' => '05', 'title' => __( 'Projetos técnicos', 'xxx-safety-prevention' ), 'text' => __( 'Levantamento, plano de adequação e orientação técnica para prevenção e regularização contra incêndio.', 'xxx-safety-prevention' ) ),
	array( 'kicker' => '06', 'title' => __( 'Sinalização de emergência', 'xxx-safety-prevention' ), 'text' => __( 'Placas, rotas de fuga, iluminação e itens de sinalização para evacuação clara e segura.', 'xxx-safety-prevention' ) ),
);

$products = array(
	array( 'title' => __( 'Extintores ABC', 'xxx-safety-prevention' ), 'text' => __( 'Versáteis para classes A, B e C, com orientação para capacidade e posicionamento.', 'xxx-safety-prevention' ) ),
	array( 'title' => __( 'Extintores CO2', 'xxx-safety-prevention' ), 'text' => __( 'Indicados para áreas elétricas, salas técnicas, painéis e ambientes com equipamentos sensíveis.', 'xxx-safety-prevention' ) ),
	array( 'title' => __( 'Placas de sinalização', 'xxx-safety-prevention' ), 'text' => __( 'Sinalização fotoluminescente para orientar rotas, equipamentos e saídas de emergência.', 'xxx-safety-prevention' ) ),
	array( 'title' => __( 'Mangueiras de incêndio', 'xxx-safety-prevention' ), 'text' => __( 'Mangueiras, esguichos, adaptadores e acessórios para sistemas de hidrantes.', 'xxx-safety-prevention' ) ),
);

$reasons = array(
	array( 'title' => __( 'Experiência aplicada', 'xxx-safety-prevention' ), 'text' => __( 'Atendimento técnico para diferentes portes de operação, com rotina pensada para quem precisa decidir rápido.', 'xxx-safety-prevention' ) ),
	array( 'title' => __( 'Normas técnicas', 'xxx-safety-prevention' ), 'text' => __( 'Serviços orientados por boas práticas, normas aplicáveis e documentação clara para auditorias e vistorias.', 'xxx-safety-prevention' ) ),
	array( 'title' => __( 'Segurança real', 'xxx-safety-prevention' ), 'text' => __( 'Mais do que vender equipamentos: avaliamos riscos, prioridades e impactos para proteger pessoas e patrimônio.', 'xxx-safety-prevention' ) ),
	array( 'title' => __( 'Atendimento consultivo', 'xxx-safety-prevention' ), 'text' => __( 'Você recebe orientação objetiva, escopo transparente e recomendação adequada ao seu tipo de ambiente.', 'xxx-safety-prevention' ) ),
);

$steps = array(
	array( 'title' => __( 'Solicitação', 'xxx-safety-prevention' ), 'text' => __( 'Você envia sua necessidade e nossa equipe entende o tipo de imóvel, prazo e urgência.', 'xxx-safety-prevention' ) ),
	array( 'title' => __( 'Avaliação técnica', 'xxx-safety-prevention' ), 'text' => __( 'Mapeamos equipamentos, riscos, validade, rotas e pontos que exigem adequação.', 'xxx-safety-prevention' ) ),
	array( 'title' => __( 'Execução', 'xxx-safety-prevention' ), 'text' => __( 'Realizamos instalação, manutenção, recarga ou fornecimento com equipe especializada.', 'xxx-safety-prevention' ) ),
	array( 'title' => __( 'Entrega', 'xxx-safety-prevention' ), 'text' => __( 'Finalizamos com orientação, documentação e suporte para manter tudo em dia.', 'xxx-safety-prevention' ) ),
);

$segments = array(
	__( 'Empresas', 'xxx-safety-prevention' ),
	__( 'Condomínios', 'xxx-safety-prevention' ),
	__( 'Comércios', 'xxx-safety-prevention' ),
	__( 'Indústrias', 'xxx-safety-prevention' ),
	__( 'Galpões', 'xxx-safety-prevention' ),
	__( 'Escritórios', 'xxx-safety-prevention' ),
);

$testimonials = array(
	array( 'quote' => __( 'A equipe foi objetiva desde o primeiro contato. Recebemos avaliação, orçamento e execução dentro do prazo combinado.', 'xxx-safety-prevention' ), 'name' => __( 'Patrícia Nogueira', 'xxx-safety-prevention' ), 'role' => __( 'Gestora administrativa', 'xxx-safety-prevention' ) ),
	array( 'quote' => __( 'A manutenção preventiva ficou muito mais organizada. Hoje temos controle de validade e suporte sempre que precisamos.', 'xxx-safety-prevention' ), 'name' => __( 'Ricardo Menezes', 'xxx-safety-prevention' ), 'role' => __( 'Síndico profissional', 'xxx-safety-prevention' ) ),
	array( 'quote' => __( 'Precisávamos adequar a loja sem interromper a operação. O atendimento foi técnico, claro e muito cuidadoso.', 'xxx-safety-prevention' ), 'name' => __( 'Fernanda Alves', 'xxx-safety-prevention' ), 'role' => __( 'Operações de varejo', 'xxx-safety-prevention' ) ),
);

$quote_shortcode = xxx_safety_get_theme_mod( 'quote_form_shortcode', '' );
if ( ! $quote_shortcode ) {
	$quote_shortcode = xxx_safety_get_theme_mod( 'contact_form_shortcode', '' );
}
?>
<main id="primary" class="site-main front-page">
	<section class="hero premium-hero" id="inicio" aria-labelledby="hero-title">
		<div class="hero-fire" aria-hidden="true"></div>
		<div class="hero-smoke" aria-hidden="true"></div>
		<div class="container hero-grid">
			<div class="hero-copy">
				<span class="eyebrow hero-eyebrow"><?php esc_html_e( 'Segurança contra incêndio com resposta rápida', 'xxx-safety-prevention' ); ?></span>
				<h1 id="hero-title"><?php esc_html_e( 'Proteção Fire: extintores, manutenção e prevenção com padrão técnico.', 'xxx-safety-prevention' ); ?></h1>
				<p class="hero-lead"><?php esc_html_e( 'Instalação, recarga, venda de equipamentos, sinalização e projetos contra incêndio para empresas que precisam de conformidade, agilidade e confiança desde o primeiro atendimento.', 'xxx-safety-prevention' ); ?></p>
				<p class="hero-highlight"><?php echo esc_html( $highlight ); ?></p>
				<div class="hero-cta">
					<a href="<?php echo esc_url( $main_cta_link ); ?>" class="btn btn-primary"><?php echo esc_html( $main_cta_text ); ?></a>
					<a href="#servicos" class="btn btn-outline"><?php esc_html_e( 'Ver serviços', 'xxx-safety-prevention' ); ?></a>
					<a href="<?php echo esc_url( $whatsapp_link ); ?>" class="btn btn-whatsapp" target="<?php echo $whatsapp ? '_blank' : '_self'; ?>" rel="<?php echo $whatsapp ? 'noopener noreferrer' : ''; ?>"><?php esc_html_e( 'Falar no WhatsApp', 'xxx-safety-prevention' ); ?></a>
				</div>
				<div class="hero-metrics" aria-label="<?php esc_attr_e( 'Indicadores de confiança', 'xxx-safety-prevention' ); ?>">
					<div><strong class="js-count" data-count="15">15</strong><span><?php esc_html_e( 'anos de experiência', 'xxx-safety-prevention' ); ?></span></div>
					<div><strong class="js-count" data-count="24">24</strong><span><?php esc_html_e( 'horas de atendimento', 'xxx-safety-prevention' ); ?></span></div>
					<div><strong class="js-count" data-count="100">100</strong><span><?php esc_html_e( '% foco em conformidade', 'xxx-safety-prevention' ); ?></span></div>
				</div>
			</div>
			<div class="hero-media-wrap">
				<div class="hero-media card">
					<img src="<?php echo esc_url( $hero_image ); ?>" alt="<?php esc_attr_e( 'Extintor de incêndio em destaque com iluminação dramática', 'xxx-safety-prevention' ); ?>" width="536" height="790" fetchpriority="high" decoding="async" />
					<div class="hero-badge hero-badge--top"><?php esc_html_e( 'Equipamentos certificados', 'xxx-safety-prevention' ); ?></div>
					<div class="hero-badge hero-badge--bottom"><?php esc_html_e( 'Atendimento técnico 24h', 'xxx-safety-prevention' ); ?></div>
				</div>
			</div>
		</div>
	</section>

	<?php if ( xxx_safety_get_theme_mod( 'show_brands', true ) ) : ?>
	<section class="trust-strip" aria-label="<?php esc_attr_e( 'Diferenciais de confiança', 'xxx-safety-prevention' ); ?>">
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

	<?php if ( xxx_safety_get_theme_mod( 'show_services', true ) ) : ?>
	<section class="section services" id="servicos">
		<div class="container">
			<div class="section-head section-head--wide xxx-animate">
				<p class="eyebrow"><?php esc_html_e( 'Serviços principais', 'xxx-safety-prevention' ); ?></p>
				<h2><?php esc_html_e( 'Tudo que sua operação precisa para prevenir, combater e documentar riscos.', 'xxx-safety-prevention' ); ?></h2>
				<p><?php esc_html_e( 'Uma equipe técnica para resolver desde a troca de um extintor vencido até a adequação completa de ambientes corporativos.', 'xxx-safety-prevention' ); ?></p>
			</div>
			<div class="card-grid cols-3">
				<?php foreach ( $services as $service ) : ?>
					<article class="card service-card xxx-animate">
						<span class="card-kicker"><?php echo esc_html( $service['kicker'] ); ?></span>
						<h3><?php echo esc_html( $service['title'] ); ?></h3>
						<p><?php echo esc_html( $service['text'] ); ?></p>
						<a href="<?php echo esc_url( $main_cta_link ); ?>"><?php esc_html_e( 'Solicitar avaliação', 'xxx-safety-prevention' ); ?></a>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<?php if ( xxx_safety_get_theme_mod( 'show_products', true ) ) : ?>
	<section class="section products-showcase" id="produtos">
		<div class="container split split--products">
			<div class="section-head xxx-animate">
				<p class="eyebrow"><?php esc_html_e( 'Produtos em destaque', 'xxx-safety-prevention' ); ?></p>
				<h2><?php esc_html_e( 'Equipamentos certos para o risco certo.', 'xxx-safety-prevention' ); ?></h2>
				<p><?php esc_html_e( 'A escolha incorreta de equipamentos pode comprometer a segurança e gerar retrabalho. Nossa equipe orienta a compra com base no ambiente, aplicação e exigências técnicas.', 'xxx-safety-prevention' ); ?></p>
				<?php if ( class_exists( 'WooCommerce' ) ) : ?>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="text-link"><?php esc_html_e( 'Ver catálogo completo', 'xxx-safety-prevention' ); ?></a>
				<?php endif; ?>
			</div>
			<div class="product-grid">
				<?php foreach ( $products as $product ) : ?>
					<article class="product-card xxx-animate">
						<h3><?php echo esc_html( $product['title'] ); ?></h3>
						<p><?php echo esc_html( $product['text'] ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<section class="section why-section">
		<div class="container">
			<div class="section-head center xxx-animate">
				<p class="eyebrow"><?php esc_html_e( 'Por que escolher a Proteção Fire?', 'xxx-safety-prevention' ); ?></p>
				<h2><?php esc_html_e( 'Confiança se constrói com técnica, clareza e presença no momento certo.', 'xxx-safety-prevention' ); ?></h2>
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

	<section class="section process-section">
		<div class="container">
			<div class="section-head section-head--between xxx-animate">
				<div>
					<p class="eyebrow"><?php esc_html_e( 'Processo de atendimento', 'xxx-safety-prevention' ); ?></p>
					<h2><?php esc_html_e( 'Do pedido ao serviço entregue, com previsibilidade.', 'xxx-safety-prevention' ); ?></h2>
				</div>
				<a href="<?php echo esc_url( $main_cta_link ); ?>" class="btn btn-outline"><?php esc_html_e( 'Iniciar agora', 'xxx-safety-prevention' ); ?></a>
			</div>
			<ol class="steps-grid">
				<?php foreach ( $steps as $step ) : ?>
					<li class="xxx-animate">
						<h3><?php echo esc_html( $step['title'] ); ?></h3>
						<p><?php echo esc_html( $step['text'] ); ?></p>
					</li>
				<?php endforeach; ?>
			</ol>
		</div>
	</section>

	<section class="section segment-section">
		<div class="container segment-panel xxx-animate">
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Para empresas, condomínios e comércios', 'xxx-safety-prevention' ); ?></p>
				<h2><?php esc_html_e( 'Soluções para quem precisa manter pessoas, patrimônio e operação protegidos.', 'xxx-safety-prevention' ); ?></h2>
				<p><?php esc_html_e( 'Atendemos ambientes com grande circulação, múltiplas unidades, rotinas condominiais e operações que não podem ficar expostas a falhas de prevenção.', 'xxx-safety-prevention' ); ?></p>
			</div>
			<div class="segment-tags">
				<?php foreach ( $segments as $segment ) : ?>
					<span><?php echo esc_html( $segment ); ?></span>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php if ( xxx_safety_get_theme_mod( 'show_testimonials', true ) ) : ?>
	<section class="section testimonials-section">
		<div class="container">
			<div class="section-head xxx-animate">
				<p class="eyebrow"><?php esc_html_e( 'Depoimentos', 'xxx-safety-prevention' ); ?></p>
				<h2><?php esc_html_e( 'Clientes valorizam clareza, prazo e execução bem feita.', 'xxx-safety-prevention' ); ?></h2>
			</div>
			<div class="card-grid cols-3">
				<?php foreach ( $testimonials as $testimonial ) : ?>
					<blockquote class="card testimonial-card xxx-animate">
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

	<section class="section cta-band cta-band--premium">
		<div class="container cta-band__inner xxx-animate">
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Orçamento rápido', 'xxx-safety-prevention' ); ?></p>
				<h2><?php esc_html_e( 'Sua segurança contra incêndio pode começar hoje.', 'xxx-safety-prevention' ); ?></h2>
				<p><?php esc_html_e( 'Envie sua solicitação e receba orientação técnica para comprar, instalar, manter ou regularizar seus equipamentos.', 'xxx-safety-prevention' ); ?></p>
			</div>
			<div class="cta-actions">
				<a class="btn" href="<?php echo esc_url( $main_cta_link ); ?>"><?php echo esc_html( $main_cta_text ); ?></a>
				<a class="btn btn-outline" href="<?php echo esc_url( $whatsapp_link ); ?>" target="<?php echo $whatsapp ? '_blank' : '_self'; ?>" rel="<?php echo $whatsapp ? 'noopener noreferrer' : ''; ?>"><?php esc_html_e( 'WhatsApp', 'xxx-safety-prevention' ); ?></a>
			</div>
		</div>
	</section>

	<section class="section quote-section" id="contato">
		<div class="container quote-grid">
			<div class="quote-copy xxx-animate">
				<p class="eyebrow"><?php esc_html_e( 'Solicite um orçamento', 'xxx-safety-prevention' ); ?></p>
				<h2><?php esc_html_e( 'Conte o que você precisa. A Proteção Fire orienta o próximo passo.', 'xxx-safety-prevention' ); ?></h2>
				<p><?php esc_html_e( 'Use o formulário para manutenção, recarga, compra de extintores, sinalização, mangueiras, projetos técnicos ou atendimento recorrente.', 'xxx-safety-prevention' ); ?></p>
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
