<?php

/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined('ABSPATH') || exit;
?>
<!-- <link rel='stylesheet' href='https://unpkg.com/primeflex@latest/primeflex.css'> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/@unocss/runtime"></script> -->
<!-- <script src="https://cdn.tailwindcss.com"></script> -->

<?php
do_action('woocommerce_review_order_before_cart_contents');
//modify cart data
// global $woocommerce;
// $woocommerce->cart->cart_contents['line_subtotal'] = 200000;
// WC()->cart->
// console_log($cart_item);
// $woocommerce->cart->set_session();   // when in ajax calls, saves it.
// console_log(WC()->cart->get_cart_contents());
foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
	$_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);

	if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key)) {
?>

		<?php
		$image = wp_get_attachment_image_src(get_post_thumbnail_id($_product->get_id()), ['50', '50']);
		$title = wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key)) . '&nbsp;';
		//echo apply_filters('woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf('&times;&nbsp;%s', $cart_item['quantity']) . '</strong>', $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
		$from = date('M d, Y', $cart_item['yith_booking_data']['from']);
		$to = date('M d, Y', $cart_item['yith_booking_data']['to']);
		$persons = $cart_item['yith_booking_data']['persons'];
		// $cart_item['line_subtotal'] = 5000;
		// $cart_item['line_total'] = 5000;
		$price = $cart_item['line_subtotal'];
		// console_log($price);
		// console_log($cart_item);

		?>

		<?php echo "<cuberaksi-booking image='$image[0]' title='$title' from='$from' to='$to' persons='$persons' price='$price'></cuberaksi-booking>"; ?>





		<?php //echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
		?>


<?php
	}
}

do_action('woocommerce_review_order_after_cart_contents');
?>


<!-- <div class="flex flex-row justify-content-end gap-8 mb-2">
	<div class="text-right text-lg"><?php esc_html_e('Subtotal', 'woocommerce'); ?></div>
	<div class="text-right w-1 text-lg text-black"><?php wc_cart_totals_subtotal_html(); ?></div>
</div> -->


<?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>

	<?php wc_cart_totals_coupon_label($coupon); ?>< <?php wc_cart_totals_coupon_html($coupon); ?> </tr>
	<?php endforeach; ?>

	<?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>

		<?php do_action('woocommerce_review_order_before_shipping'); ?>

		<?php wc_cart_totals_shipping_html(); ?>

		<?php do_action('woocommerce_review_order_after_shipping'); ?>

	<?php endif; ?>

	<?php foreach (WC()->cart->get_fees() as $fee) : ?>

		<?php echo esc_html($fee->name); ?>
		<?php wc_cart_totals_fee_html($fee); ?>

	<?php endforeach; ?>

	<?php if (wc_tax_enabled() && !WC()->cart->display_prices_including_tax()) : ?>
		<?php if ('itemized' === get_option('woocommerce_tax_total_display')) : ?>
			<?php foreach (WC()->cart->get_tax_totals() as $code => $tax) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited 
			?>
				<div class="flex flex-row justify-content-end gap-8 mb-2">
					<div class="text-right text-lg"><?php echo esc_html($tax->label); ?></div>
					<div class="text-right w-1 text-lg text-black"><?php echo wp_kses_post($tax->formatted_amount); ?></div>
				</div>

			<?php endforeach; ?>
		<?php else : ?>
			<!-- <div class="flex flex-row justify-content-end gap-8 mb-2">
				<div class="text-right text-lg"><?php echo esc_html(WC()->countries->tax_or_vat()); ?></div>
				<div class="text-right w-1 text-lg text-black"><?php wc_cart_totals_taxes_total_html(); ?></div>
			</div>
 -->
		<?php endif; ?>
	<?php endif; ?>

	<?php do_action('woocommerce_review_order_before_order_total'); ?>

	<div class="flex flex-row justify-content-end gap-8 mb-2">
		<div class="text-right text-lg text-black"><?php esc_html_e('Grand Total', 'woocommerce'); ?></div>
		<div class="text-right  w-1 text-xl " style="color:#A87C51"><?php wc_cart_totals_order_total_html(); ?></div>

	</div>
	<div class="w-full text-right text-sm text-gray-900">Include taxes and fees</div>
	<div class="flex w-full bordered border-gray border-b-2 mb-4"></div>

	<?php do_action('woocommerce_review_order_after_order_total'); ?>



	<?php
	if (class_exists("\\Elementor\\Plugin")) {
		$post_ID = '9712';
		$pluginElementor = \Elementor\Plugin::instance();
		$contentElementor = $pluginElementor->frontend->get_builder_content($post_ID, false);
		// ob_start();
		echo "<div class='priceinfo123'>";
		echo $contentElementor;
		echo "</div>";
		// echo ob_get_clean();
	}

	// echo "<script>jQuery(jQuery('.priceinfo123')[1]).css('display','block')</script>";
	?>