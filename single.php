<?php
/**
 * Single post template.
 *
 * @package XXX_Safety_Prevention
 */

get_header();
xxx_safety_inner_hero( get_the_title() );
?>
<main id="primary" class="site-main">
	<div class="container content-grid section">
		<section>
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-content card xxx-animate xxx-fade-up' ); ?>>
					<?php the_content(); ?>
				</article>
			<?php endwhile; ?>
		</section>
		<?php get_sidebar(); ?>
	</div>
	<?php xxx_safety_bottom_cta(); ?>
</main>
<?php get_footer();
