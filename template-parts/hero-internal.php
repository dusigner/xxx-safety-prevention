<?php
/**
 * Internal hero.
 *
 * @package XXX_Safety_Prevention
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args       = wp_parse_args(
	$args,
	array(
		'title'      => get_the_title(),
		'subtitle'   => '',
		'background' => '',
	)
);
$hero_style = $args['background'] ? ' style="background-image:url(' . esc_url( $args['background'] ) . ');"' : '';
?>
<section class="inner-hero section-sm"<?php echo $hero_style; ?>>
	<div class="container xxx-animate xxx-fade-up">
		<p class="eyebrow"><?php esc_html_e( 'Segurança & Prevenção', 'xxx-safety-prevention' ); ?></p>
		<h1><?php echo esc_html( $args['title'] ); ?></h1>
		<?php if ( ! empty( $args['subtitle'] ) ) : ?>
			<p><?php echo esc_html( $args['subtitle'] ); ?></p>
		<?php endif; ?>
		<?php xxx_safety_breadcrumb(); ?>
	</div>
</section>
