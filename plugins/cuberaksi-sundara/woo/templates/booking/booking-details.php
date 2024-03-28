<?php

/**
 * Booking Details Template
 *
 * Shows booking details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/booking/booking-details.php.
 *
 * @var YITH_WCBK_Booking $booking The booking.
 *
 * @package YITH\Booking\Templates
 */

defined('YITH_WCBK') || exit;

$order_id        = apply_filters('yith_wcbk_booking_details_order_id', $booking->get_order_id(), $booking);
$the_order       = !!$order_id ? wc_get_order($order_id) : false;
$override_props  = array(
	'order_id' => $order_id,
	'order'    => $the_order,
);
$data_to_display = $booking->get_booking_data_to_display('frontend', $override_props);
$the_product = wc_get_product($booking->get_product_id());
$img_id = $the_product->get_image();
// $img_url = wp_get_attachment_image_src( $img_id);
// echo json_encode((array)$booking);
$duration = $booking->get_duration();
$price = $the_product->get_price();
$amount = $duration * $price;
?>

<h2><?php esc_html_e('Booking Details', 'yith-booking-for-woocommerce'); ?></h2>

<table class="shop_table booking_details">
	<tr>

		<td colspan="2" > <?=$img_id;?></td>
	</tr>
	<tr>
		<th scope="row">Amount</th>
		<td><?php echo '$' . number_format($amount,0);?></td>
	</tr>
	<?php foreach ($data_to_display as $data_key => $data) : ?>
		<?php
		$data_label = $data['label'] ?? '';
		$data_value = $data['display'] ?? '';
		?>
		<?php if ($data_value) : ?>
			<tr>
				<th scope="row"><?php echo esc_html($data_label); ?></th>
				<td><?php echo wp_kses_post($data_value); ?> </td>
			</tr>
		<?php endif; ?>
	<?php endforeach; ?>
</table>

<?php
/**
 * DO_ACTION: yith_wcbk_booking_details_after_booking_table
 * Hook to output something in the booking details template after the booking table.
 *
 * @param YITH_WCBK_Booking $booking The booking.
 */
do_action('yith_wcbk_booking_details_after_booking_table', $booking);
?>