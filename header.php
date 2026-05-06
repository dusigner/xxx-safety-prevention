<?php
/**
 * Header template.
 *
 * @package XXX_Safety_Prevention
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cta_text = xxx_safety_get_theme_mod( 'main_cta_text', __( 'Solicitar Orçamento', 'xxx-safety-prevention' ) );
$cta_link = xxx_safety_get_theme_mod( 'main_cta_link', '#contato' );
$whatsapp = preg_replace( '/\D+/', '', xxx_safety_get_theme_mod( 'whatsapp_number', '' ) );
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Pular para o conteúdo', 'xxx-safety-prevention' ); ?></a>
<header class="site-header" id="site-header">
	<div class="container header-inner">
		<div class="site-branding">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-title"><?php bloginfo( 'name' ); ?></a>
			<?php endif; ?>
		</div>

		<button class="mobile-menu-toggle" aria-controls="primary-menu" aria-expanded="false" aria-label="<?php esc_attr_e( 'Abrir menu', 'xxx-safety-prevention' ); ?>">
			<span></span><span></span><span></span>
		</button>

		<nav class="main-navigation" aria-label="<?php esc_attr_e( 'Menu Principal', 'xxx-safety-prevention' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'menu_id'        => 'primary-menu',
					'fallback_cb'    => false,
				)
			);
			?>
		</nav>
		<div class="header-actions">
			<?php if ( ! empty( $whatsapp ) ) : ?>
				<a class="icon-btn" href="<?php echo esc_url( 'https://wa.me/' . $whatsapp ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Atendimento via WhatsApp', 'xxx-safety-prevention' ); ?>">WA</a>
			<?php endif; ?>
			<a class="btn btn-header" href="<?php echo esc_url( $cta_link ); ?>"><?php echo esc_html( $cta_text ); ?></a>
		</div>
	</div>
</header>
