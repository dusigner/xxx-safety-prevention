<?php
/**
 * Theme bootstrap file.
 *
 * @package XXX_Safety_Prevention
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$xxx_includes = array(
	'inc/theme-setup.php',
	'inc/enqueue.php',
	'inc/customizer.php',
	'inc/contact-form-7.php',
	'inc/template-functions.php',
	'inc/woocommerce.php',
	'inc/demo-importer.php',
);

foreach ( $xxx_includes as $xxx_file ) {
	$xxx_path = get_template_directory() . '/' . $xxx_file;
	if ( file_exists( $xxx_path ) ) {
		require_once $xxx_path;
	}
}
