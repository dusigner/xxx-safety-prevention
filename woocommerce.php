<?php
/**
 * WooCommerce fallback template.
 *
 * @package XXX_Safety_Prevention
 */

get_header();
?>
<main id="primary" class="site-main site-main-shop">
	<div class="container">
		<?php woocommerce_content(); ?>
	</div>
</main>
<?php
get_footer();
