<?php
/**
 * Page template.
 *
 * @package XXX_Safety_Prevention
 */

get_header();
xxx_safety_inner_hero( get_the_title() );
$slug       = get_post_field( 'post_name', get_the_ID() );
$is_contact = 'contato' === $slug;
?>
<main id="primary" class="site-main">
	<div class="container section">
		<?php if ( $is_contact ) : ?>
			<section class="contact-page-grid">
				<div class="contact-form-main xxx-animate xxx-fade-up">
					<?php xxx_safety_render_form_block( 'contact_form_shortcode', __( 'Configure o shortcode do formulário de contato no Customizer para exibir aqui.', 'xxx-safety-prevention' ), 'contact' ); ?>
					<?php get_template_part( 'template-parts/cta-quote' ); ?>
				</div>
				<?php get_template_part( 'template-parts/contact-info' ); ?>
			</section>
			<?php $map_url = xxx_safety_get_theme_mod( 'map_embed_url', '' ); ?>
			<?php if ( ! empty( $map_url ) ) : ?>
				<div class="map-wrap card xxx-animate xxx-fade-up">
					<iframe src="<?php echo esc_url( $map_url ); ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Mapa de atendimento"></iframe>
				</div>
			<?php endif; ?>
			<?php
			get_template_part(
				'template-parts/faq-section',
				null,
				array(
					'items' => array(
						array( 'q' => 'Vocês atendem urgência?', 'a' => 'Sim, com triagem técnica para priorização imediata.' ),
						array( 'q' => 'Atendem múltiplas unidades?', 'a' => 'Sim, com cronograma por filial e gestão centralizada.' ),
					),
				)
			);
			?>
		<?php endif; ?>

		<?php while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'page-content card xxx-animate xxx-fade-up' ); ?>>
				<?php the_content(); ?>
			</article>
		<?php endwhile; ?>

		<section class="card-grid cols-3 benefits-grid">
			<?php
			$benefits = array(
				array( 'title' => 'Atendimento consultivo', 'text' => 'Mapeamos o contexto técnico antes de propor qualquer escopo.' ),
				array( 'title' => 'Execução com SLA', 'text' => 'Cronograma definido com previsibilidade para gestores.' ),
				array( 'title' => 'Documentação organizada', 'text' => 'Registros claros para auditorias e conformidade interna.' ),
			);
			foreach ( $benefits as $benefit ) {
				get_template_part( 'template-parts/service-card', null, $benefit );
			}
			?>
		</section>
	</div>
	<?php xxx_safety_bottom_cta(); ?>
</main>
<?php get_footer();
