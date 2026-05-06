<?php
/**
 * WooCommerce fallback template.
 *
 * @package XXX_Safety_Prevention
 */

defined( 'ABSPATH' ) || exit;

if ( function_exists( 'is_shop' ) && ( is_shop() || ( function_exists( 'is_product_taxonomy' ) && is_product_taxonomy() ) ) ) {
	wc_get_template( 'archive-product.php' );
	return;
}

get_header();
?>
<main id="primary" class="site-main site-main-shop">
	<div class="container">
		<?php woocommerce_content(); ?>
	</div>
</main>
<?php
get_footer();
