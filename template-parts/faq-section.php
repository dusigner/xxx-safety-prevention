<?php
/**
 * FAQ section.
 *
 * @package XXX_Safety_Prevention
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$items = ! empty( $args['items'] ) && is_array( $args['items'] ) ? $args['items'] : array();
if ( empty( $items ) ) {
	return;
}
?>
<section class="faq-list xxx-animate xxx-fade-up">
	<?php foreach ( $items as $item ) : ?>
		<details>
			<summary><?php echo esc_html( $item['q'] ); ?></summary>
			<p><?php echo esc_html( $item['a'] ); ?></p>
		</details>
	<?php endforeach; ?>
</section>
