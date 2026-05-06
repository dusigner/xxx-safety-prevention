<?php
/**
 * Service card item.
 *
 * @package XXX_Safety_Prevention
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = wp_parse_args(
	$args,
	array(
		'title' => '',
		'text'  => '',
	)
);
?>
<article class="card service-card xxx-animate xxx-reveal">
	<h3><?php echo esc_html( $args['title'] ); ?></h3>
	<p><?php echo esc_html( $args['text'] ); ?></p>
</article>
