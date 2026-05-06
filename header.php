<?php
/**
 * Header template.
 *
 * @package XXX_Safety_Prevention
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cart_count   = function_exists( 'WC' ) && WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
$cart_url     = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : '#';
$checkout_url = function_exists( 'wc_get_checkout_url' ) ? wc_get_checkout_url() : '#';
$account_url  = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : wp_login_url();
$logout_url  = function_exists( 'wc_logout_url' ) ? wc_logout_url() : wp_logout_url( home_url( '/' ) );
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
<header class="site-header xxx-site-header" id="site-header" data-premium-header>
	<div class="container header-inner xxx-header-inner">
		<div class="site-branding xxx-header-brand">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-title"><?php bloginfo( 'name' ); ?></a>
			<?php endif; ?>
		</div>

		<nav class="main-navigation xxx-main-navigation" aria-label="<?php esc_attr_e( 'Menu Principal', 'xxx-safety-prevention' ); ?>">
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

		<div class="header-actions xxx-header-actions">
			<?php if ( is_user_logged_in() ) : ?>
				<div class="xxx-account-menu">
					<button class="xxx-header-icon xxx-account-link" type="button" aria-label="<?php esc_attr_e( 'Abrir opções da conta', 'xxx-safety-prevention' ); ?>" aria-controls="xxx-account-dropdown" aria-expanded="false" data-account-toggle>
						<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 21a8 8 0 0 0-16 0"/><circle cx="12" cy="7" r="4"/></svg>
					</button>
					<div class="xxx-account-dropdown" id="xxx-account-dropdown" aria-hidden="true" data-account-dropdown>
						<a href="<?php echo esc_url( $account_url ); ?>">
							<span><?php esc_html_e( 'Minha Conta', 'xxx-safety-prevention' ); ?></span>
							<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 18l6-6-6-6"/></svg>
						</a>
						<a class="xxx-account-dropdown__logout" href="<?php echo esc_url( $logout_url ); ?>">
							<span><?php esc_html_e( 'Sair / Logout', 'xxx-safety-prevention' ); ?></span>
							<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/><path d="M13 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h8"/></svg>
						</a>
					</div>
				</div>
			<?php else : ?>
				<a class="xxx-header-icon xxx-account-link" href="<?php echo esc_url( $account_url ); ?>" aria-label="<?php esc_attr_e( 'Entrar ou criar conta', 'xxx-safety-prevention' ); ?>">
					<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 21a8 8 0 0 0-16 0"/><circle cx="12" cy="7" r="4"/></svg>
				</a>
			<?php endif; ?>

			<?php if ( function_exists( 'WC' ) ) : ?>
				<button class="xxx-header-icon xxx-cart-toggle" type="button" aria-controls="xxx-mini-cart-panel" aria-expanded="false" data-cart-toggle>
					<span class="screen-reader-text"><?php esc_html_e( 'Abrir carrinho', 'xxx-safety-prevention' ); ?></span>
					<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 8h14l-1.5 9h-11z"/><path d="M6 8L5 4H2"/><circle cx="9" cy="20" r="1.5"/><circle cx="17" cy="20" r="1.5"/></svg>
					<span class="xxx-header-cart-fragment">
						<span class="xxx-cart-count <?php echo $cart_count ? 'has-items' : ''; ?>" data-cart-count><?php echo esc_html( $cart_count ); ?></span>
					</span>
				</button>
			<?php endif; ?>

			<button class="mobile-menu-toggle xxx-mobile-toggle" type="button" aria-controls="xxx-mobile-drawer" aria-expanded="false" aria-label="<?php esc_attr_e( 'Abrir menu', 'xxx-safety-prevention' ); ?>" data-menu-toggle>
				<span></span><span></span><span></span>
			</button>
		</div>
	</div>
</header>

<div class="xxx-site-overlay" data-site-overlay hidden></div>

<aside class="xxx-mini-cart" id="xxx-mini-cart-panel" aria-hidden="true" aria-label="<?php esc_attr_e( 'Carrinho de compras', 'xxx-safety-prevention' ); ?>" data-mini-cart>
	<div class="xxx-mini-cart__panel">
		<header>
			<div>
				<span><?php esc_html_e( 'Carrinho', 'xxx-safety-prevention' ); ?></span>
				<h2><?php esc_html_e( 'Seu pedido', 'xxx-safety-prevention' ); ?></h2>
			</div>
			<button class="xxx-drawer-close" type="button" aria-label="<?php esc_attr_e( 'Fechar carrinho', 'xxx-safety-prevention' ); ?>" data-cart-close>
				<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M18 6L6 18"/><path d="M6 6l12 12"/></svg>
			</button>
		</header>
		<div class="xxx-mini-cart-fragment">
			<?php if ( function_exists( 'woocommerce_mini_cart' ) ) : ?>
				<?php woocommerce_mini_cart(); ?>
			<?php endif; ?>
		</div>
		<footer>
			<a class="xxx-mini-cart__button xxx-mini-cart__button--ghost" href="<?php echo esc_url( $cart_url ); ?>"><?php esc_html_e( 'Ver carrinho', 'xxx-safety-prevention' ); ?></a>
			<a class="xxx-mini-cart__button" href="<?php echo esc_url( $checkout_url ); ?>"><?php esc_html_e( 'Finalizar compra', 'xxx-safety-prevention' ); ?></a>
		</footer>
	</div>
</aside>

<aside class="xxx-mobile-drawer" id="xxx-mobile-drawer" aria-hidden="true" data-mobile-drawer>
	<div class="xxx-mobile-drawer__panel">
		<header>
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-title"><?php bloginfo( 'name' ); ?></a>
			<?php endif; ?>
			<button class="xxx-drawer-close" type="button" aria-label="<?php esc_attr_e( 'Fechar menu', 'xxx-safety-prevention' ); ?>" data-menu-close>
				<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M18 6L6 18"/><path d="M6 6l12 12"/></svg>
			</button>
		</header>
		<nav class="xxx-mobile-navigation" aria-label="<?php esc_attr_e( 'Menu mobile', 'xxx-safety-prevention' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'menu_id'        => 'mobile-primary-menu',
					'fallback_cb'    => false,
				)
			);
			?>
		</nav>
		<div class="xxx-mobile-drawer__actions">
			<a href="<?php echo esc_url( $account_url ); ?>">
				<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 21a8 8 0 0 0-16 0"/><circle cx="12" cy="7" r="4"/></svg>
				<?php esc_html_e( 'Minha conta', 'xxx-safety-prevention' ); ?>
			</a>
			<?php if ( is_user_logged_in() ) : ?>
				<a href="<?php echo esc_url( $logout_url ); ?>">
					<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/><path d="M13 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h8"/></svg>
					<?php esc_html_e( 'Sair / Logout', 'xxx-safety-prevention' ); ?>
				</a>
			<?php endif; ?>
			<?php if ( function_exists( 'WC' ) ) : ?>
				<button type="button" data-cart-toggle>
					<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 8h14l-1.5 9h-11z"/><path d="M6 8L5 4H2"/><circle cx="9" cy="20" r="1.5"/><circle cx="17" cy="20" r="1.5"/></svg>
					<?php esc_html_e( 'Carrinho', 'xxx-safety-prevention' ); ?>
				</button>
			<?php endif; ?>
		</div>
	</div>
</aside>
