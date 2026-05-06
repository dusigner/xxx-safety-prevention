<?php
/**
 * Main index file.
 *
 * @package XXX_Safety_Prevention
 */

get_header();
xxx_safety_inner_hero( __( 'Blog', 'xxx-safety-prevention' ) );
?>
<main id="primary" class="site-main">
	<div class="container content-grid section">
		<section>
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card card' ); ?>>
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<?php the_excerpt(); ?>
				</article>
			<?php endwhile; the_posts_pagination(); else : ?>
				<p><?php esc_html_e( 'Nenhum conteúdo encontrado.', 'xxx-safety-prevention' ); ?></p>
			<?php endif; ?>
		</section>
		<?php get_sidebar(); ?>
	</div>
	<?php xxx_safety_bottom_cta(); ?>
</main>
<?php get_footer();
