<?php
/**
 * Admin View: Dashboard - Finish Setup
 *
 * @package WooCommerce\Admin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div>
	<div>Step <?php esc_html( $current_index ); ?> of <?php esc_html( $total_number_of_steps ); ?></div>
	<div><?php esc_html( $description ); ?></div>
	<button class='btn btn-primary'><?php esc_html( $button_text ); ?></button>
</div>
