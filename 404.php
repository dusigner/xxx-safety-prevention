<?php
/**
 * 404 template.
 *
 * @package XXX_Safety_Prevention
 */

get_header();
xxx_safety_inner_hero( __( 'Página não encontrada', 'xxx-safety-prevention' ) );
?>
<main id="primary" class="site-main">
	<section class="section">
		<div class="container narrow card center xxx-animate xxx-fade-up">
			<h2><?php esc_html_e( 'Erro 404', 'xxx-safety-prevention' ); ?></h2>
			<p><?php esc_html_e( 'Não encontramos esta URL. Explore nossos serviços e solicite atendimento técnico.', 'xxx-safety-prevention' ); ?></p>
			<a class="btn" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Voltar para a home', 'xxx-safety-prevention' ); ?></a>
		</div>
	</section>
	<?php xxx_safety_bottom_cta(); ?>
</main>
<?php get_footer();
