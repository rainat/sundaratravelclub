<?php

/**
 * Widget booking form template.
 *
 * @var WC_Product_Booking $product the booking product
 *
 * @package YITH\Booking\Templates
 */

defined('YITH_WCBK') || exit;
?>

<div class="yith-wcbk-mobile-fixed-form__mouse-trap"></div>
<span class="yith-wcbk-mobile-fixed-form__close"><?php yith_wcbk_print_svg('no'); ?></span>

<div id="product-<?php echo esc_attr($product->get_id()); ?>" data-productid="<?php echo esc_attr($product->get_id()); ?>" class="clone-yith-form product type-product yith-booking yith-wcbk-widget-booking-form">
	<?php
	/**
	 * DO_ACTION: yith_wcbk_widget_booking_form_head.
	 * Used to output price and rating before the booking add-to-cart form in the widget.
	 *
	 * @hooked woocommerce_template_single_price - 10
	 * @hooked woocommerce_template_single_rating - 20
	 */
	?><?php
		do_action('yith_wcbk_widget_booking_form_head');
		//custom with price and button booknow
		$book_now_button_caption = $product->is_confirmation_required() ? "REQUEST TO RESERVE" : "RESERVE NOW";
		?>
	<button class="button" id='mobile-book-now'><?php echo $book_now_button_caption; ?></button>
	<style>
		.itaxfee {
			font-size: 14px;
			color: #bfb198;
		}
	</style>
	<script>
		// setInterval(function(){
		// 	 if (jQuery('.itaxfee').length<=0)
		// 	jQuery('.yith_wcbk_booking_product_form_widget p.price').append('<div class="itaxfee">Includes taxes and fees</div>')	
		// },100)
	</script>
	<?php
	/**
	 * DO_ACTION: yith_wcbk_widget_booking_form_before_add_to_cart_form
	 * Hook to output something before the booking add-to-cart form in the widget.
	 */
	do_action('yith_wcbk_widget_booking_form_before_add_to_cart_form');

	/**
	 * DO_ACTION: yith_wcbk_booking_add_to_cart_form
	 * Hook to output the add-to-cart form for the bookable product.
	 *
	 * @hooked \YITH_WCBK_Frontend::print_add_to_cart_template - 10
	 */
	do_action('yith_wcbk_booking_add_to_cart_form');

	/**
	 * DO_ACTION: yith_wcbk_widget_booking_form_after_add_to_cart_form
	 * Hook to output something after the booking add-to-cart form in the widget.
	 */
	do_action('yith_wcbk_widget_booking_form_after_add_to_cart_form');
	?>
</div>