<?php
/**
 * Front page template.
 *
 * @package XXX_Safety_Prevention
 */

get_header();
$main_cta_text = xxx_safety_get_theme_mod( 'main_cta_text', __( 'Solicitar Orçamento', 'xxx-safety-prevention' ) );
$main_cta_link = xxx_safety_get_theme_mod( 'main_cta_link', '#contato' );
$hero_image    = xxx_safety_get_theme_mod( 'hero_image', get_template_directory_uri() . '/screenshot.png' );
$highlight     = xxx_safety_get_theme_mod( 'hero_highlight', __( 'Atendimento para empresas, condomínios e comércios', 'xxx-safety-prevention' ) );
?>
<main id="primary" class="site-main front-page">
	<section class="hero section">
		<div class="container hero-grid">
			<div class="hero-copy">
				<span class="badge"><?php esc_html_e( 'Especialistas em Segurança Contra Incêndio', 'xxx-safety-prevention' ); ?></span>
				<h1><?php esc_html_e( 'Estrutura premium para proteger patrimônio, pessoas e continuidade operacional.', 'xxx-safety-prevention' ); ?></h1>
				<p><?php esc_html_e( 'Projetos técnicos, regularização AVCB, manutenção recorrente e fornecimento de equipamentos certificados para operações corporativas.', 'xxx-safety-prevention' ); ?></p>
				<p class="hero-highlight"><?php echo esc_html( $highlight ); ?></p>
				<div class="hero-cta">
					<a href="<?php echo esc_url( $main_cta_link ); ?>" class="btn"><?php echo esc_html( $main_cta_text ); ?></a>
					<a href="<?php echo esc_url( home_url( '/loja' ) ); ?>" class="btn btn-outline"><?php esc_html_e( 'Comprar Equipamentos', 'xxx-safety-prevention' ); ?></a>
				</div>
				<ul class="hero-points">
					<li><?php esc_html_e( 'Equipe técnica própria', 'xxx-safety-prevention' ); ?></li>
					<li><?php esc_html_e( 'Atendimento emergencial e programado', 'xxx-safety-prevention' ); ?></li>
					<li><?php esc_html_e( 'Cronograma e documentação auditável', 'xxx-safety-prevention' ); ?></li>
				</ul>
			</div>
			<div class="hero-media card">
				<img src="<?php echo esc_url( $hero_image ); ?>" alt="<?php esc_attr_e( 'Equipe técnica de combate a incêndio em inspeção preventiva', 'xxx-safety-prevention' ); ?>" loading="lazy" />
			</div>
		</div>
	</section>

	<?php if ( xxx_safety_get_theme_mod( 'show_brands', true ) ) : ?>
	<section class="section section-sm">
		<div class="container">
			<div class="section-head center">
				<p class="eyebrow">Selos e conformidade</p>
			</div>
			<div class="trust-row">
				<span>AVCB</span><span>ABNT NBR</span><span>NR-23</span><span>Plano de Brigada</span><span>Manutenção Certificada</span>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<?php if ( xxx_safety_get_theme_mod( 'show_services', true ) ) : ?>
	<section class="section services">
		<div class="container">
			<div class="section-head">
				<p class="eyebrow">Soluções completas</p>
				<h2>Serviços com padrão corporativo</h2>
			</div>
			<div class="card-grid cols-3">
				<article class="card service-card"><span class="service-icon">🧯</span><h3>Extintores</h3><p>Fornecimento, dimensionamento e instalação técnica por risco da ocupação.</p><a href="#contato">Solicitar avaliação</a></article>
				<article class="card service-card"><span class="service-icon">📑</span><h3>AVCB & Consultoria</h3><p>Diagnóstico, plano de adequação, documentação e acompanhamento de vistoria.</p><a href="#contato">Falar com consultor</a></article>
				<article class="card service-card"><span class="service-icon">🛠️</span><h3>Manutenção Programada</h3><p>Inspeção e recarga com controle de validade e histórico de intervenções.</p><a href="#contato">Agendar manutenção</a></article>
				<article class="card service-card"><span class="service-icon">🚨</span><h3>Equipamentos de Combate</h3><p>Mangueiras, sinalização, iluminação e acessórios para operação segura.</p><a href="#contato">Ver linha completa</a></article>
				<article class="card service-card"><span class="service-icon">🎓</span><h3>Treinamentos</h3><p>Capacitação de brigada e protocolos para resposta rápida em emergências.</p><a href="#contato">Solicitar proposta</a></article>
				<article class="card service-card"><span class="service-icon">📅</span><h3>Contratos Anuais</h3><p>Rotina previsível para empresas e condomínios sem risco de vencimentos.</p><a href="#contato">Montar plano anual</a></article>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<section class="section">
		<div class="container split card about-highlight">
			<div>
				<p class="eyebrow">Quem somos</p>
				<h2>Empresa consolidada no mercado de prevenção e combate a incêndio</h2>
				<p>Unimos atendimento consultivo, execução técnica e visão de negócio para proteger operações críticas sem interromper a produtividade.</p>
				<ul class="check-list">
					<li>Equipe com experiência em ambientes corporativos e condominiais.</li>
					<li>Planejamento com SLA e cronograma por unidade.</li>
					<li>Suporte pós-serviço com lembretes preventivos.</li>
				</ul>
			</div>
			<ul class="stats-grid">
				<li><strong>1.250+</strong><span>operações atendidas</span></li>
				<li><strong>17 anos</strong><span>de atuação no setor</span></li>
				<li><strong>98%</strong><span>renovação de contratos</span></li>
			</ul>
		</div>
	</section>

	<section class="section">
		<div class="container">
			<div class="section-head">
				<p class="eyebrow">Metodologia</p>
				<h2>Processo de atendimento em 4 etapas</h2>
			</div>
			<ol class="steps-grid">
				<li><h3>Diagnóstico</h3><p>Levantamento técnico, análise de riscos e necessidades por ambiente.</p></li>
				<li><h3>Orçamento</h3><p>Escopo claro com cronograma, investimento e prioridades de execução.</p></li>
				<li><h3>Execução</h3><p>Implantação com equipe qualificada e materiais homologados.</p></li>
				<li><h3>Laudo/Suporte</h3><p>Entrega documental, orientações e acompanhamento contínuo.</p></li>
			</ol>
		</div>
	</section>

	<?php if ( class_exists( 'WooCommerce' ) && xxx_safety_get_theme_mod( 'show_products', true ) ) : ?>
	<section class="section products">
		<div class="container">
			<div class="section-head section-head--between"><h2>Vitrine de Produtos</h2><a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">Ver catálogo completo</a></div>
			<p class="section-subtitle"><?php esc_html_e( 'Produtos certificados com especificação técnica e apoio para escolha do item certo.', 'xxx-safety-prevention' ); ?></p>
			<?php echo do_shortcode( '[products limit="6" columns="3" orderby="popularity"]' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
	</section>
	<?php endif; ?>

	<section class="section avcb-highlight">
		<div class="container card split">
			<div>
				<p class="eyebrow">AVCB sem complexidade</p>
				<h2>Consultoria e regularização com condução técnica do início ao fim.</h2>
				<p>Reduza riscos de multa, interdição e retrabalho documental com acompanhamento especializado.</p>
			</div>
			<a class="btn" href="<?php echo esc_url( $main_cta_link ); ?>">Solicitar diagnóstico técnico</a>
		</div>
	</section>

	<?php if ( xxx_safety_get_theme_mod( 'show_testimonials', true ) ) : ?>
	<section class="section">
		<div class="container">
			<div class="section-head"><p class="eyebrow">Prova social</p><h2>Depoimentos de clientes</h2></div>
			<div class="card-grid cols-3">
				<blockquote class="card testimonial-card"><p>“Padronizamos 14 unidades da rede com cronograma impecável e zero retrabalho.”</p><cite><strong>Patrícia Nogueira</strong><span>Diretora Operacional · Rede de Lojas</span></cite></blockquote>
				<blockquote class="card testimonial-card"><p>“A condução do AVCB foi clara, técnica e dentro do prazo acordado.”</p><cite><strong>Fernanda Alves</strong><span>Gerente Administrativa · Indústria</span></cite></blockquote>
				<blockquote class="card testimonial-card"><p>“Excelente organização da manutenção preventiva. Hoje temos previsibilidade total.”</p><cite><strong>Ricardo Menezes</strong><span>Síndico · Condomínio Comercial</span></cite></blockquote>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<?php if ( xxx_safety_get_theme_mod( 'show_faq', true ) ) : ?>
	<section class="section">
		<div class="container">
			<div class="section-head"><p class="eyebrow">Dúvidas frequentes</p><h2>Perguntas que recebemos no atendimento comercial</h2></div>
			<div class="faq-list">
				<details><summary>Quando devo realizar manutenção dos extintores?</summary><p>A periodicidade depende do tipo de equipamento e ambiente. Recomendamos calendário técnico com alertas automáticos para não haver vencimentos.</p></details>
				<details><summary>Vocês atendem contratos para múltiplas unidades?</summary><p>Sim. Atendemos redes e grupos empresariais com planejamento por filial e relatórios centralizados para o gestor responsável.</p></details>
				<details><summary>Também fazem regularização completa de AVCB?</summary><p>Sim. Atuamos desde diagnóstico inicial e adequações até acompanhamento de vistoria e orientação pós-emissão.</p></details>
				<details><summary>Posso comprar produtos com suporte técnico?</summary><p>Sim. A loja WooCommerce está integrada com equipe comercial para orientação de compra conforme classe de risco e aplicação.</p></details>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<?php xxx_safety_bottom_cta(); ?>
</main>
<?php get_footer();
