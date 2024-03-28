<?php
/**
 * Booking product add to cart template.
 *
 * @var WC_Product_Booking $product
 *
 * @package YITH\Booking\Templates
 */

defined('YITH_WCBK') || exit;
global $product;

if (!$product->is_purchasable()) {
	return;
}

if (!apply_filters('yith_wcbk_show_booking_form', true)) {
	return;
}

$form_action = !$product->is_confirmation_required() ? 'add-to-cart' : 'booking-request-confirmation';
$add_to_cart_classes = array('yith-wcbk-add-to-cart-button', 'single_add_to_cart_button', 'button', 'alt');

if ($product->is_confirmation_required()) {
	$add_to_cart_classes[] = 'yith-wcbk-add-to-cart-button--confirmation-required';
}
$add_to_cart_classes = implode(' ', array_filter($add_to_cart_classes));

?>
<?php do_action('woocommerce_before_add_to_cart_form');?>

<form class="cart" method="post" enctype='multipart/form-data'>

	<input type="hidden" name="<?php echo esc_attr($form_action); ?>" value="<?php echo esc_attr($product->get_id()); ?>"/>

	<?php
/**
 * DO_ACTION: yith_wcbk_before_booking_form
 * Hook to output something before the booking form.
 */
do_action('yith_wcbk_before_booking_form');

/**
 * DO_ACTION: yith_wcbk_booking_form_start
 * Hook to output something at the start of the booking form.
 *
 * @hooked yith_wcbk_booking_form_start - 10
 *
 * @param WC_Product_Booking $product The bookable product.
 */
do_action('yith_wcbk_booking_form_start', $product);

/**
 * DO_ACTION: yith_wcbk_booking_form_meta
 * Used to output meta in the booking form.
 *
 * @hooked yith_wcbk_booking_form_meta - 10
 *
 * @param WC_Product_Booking $product The bookable product.
 */
do_action('yith_wcbk_booking_form_meta', $product);

/**
 * DO_ACTION: yith_wcbk_booking_form_content
 * Used to output the booking form content and fields.
 *
 * @hooked yith_wcbk_booking_form_dates - 10
 *
 * @param WC_Product_Booking $product The bookable product.
 */
do_action('yith_wcbk_booking_form_content', $product);

/**
 * DO_ACTION: yith_wcbk_booking_form_content
 * Used to output the message in the booking form.
 *
 * @hooked yith_wcbk_booking_form_message - 10
 *
 * @param WC_Product_Booking $product The bookable product.
 */
do_action('yith_wcbk_booking_form_message', $product);

/**
 * DO_ACTION: yith_wcbk_booking_form_end
 * Hook to output something at the end of the booking form.
 *
 * @hooked yith_wcbk_booking_form_end - 10
 *
 * @param WC_Product_Booking $product The bookable product.
 */
do_action('yith_wcbk_booking_form_end', $product);
?>

	<?php do_action('woocommerce_before_add_to_cart_button');?>

	<?php
/**
 * DO_ACTION: yith_wcbk_booking_before_add_to_cart_button
 * Hook to output something before the add-to-cart button in the booking form.
 */
do_action('yith_wcbk_booking_before_add_to_cart_button');

//check if admin confirm require
$caption_button = 'Reserve Now';
if (yith_wcbk_is_booking_product($product->get_id())) {
	/**
	 * The booking product.
	 *
	 * @var WC_Product_Booking $product
	 */

	if ($product && ($product->is_confirmation_required())) {
		$caption_button = 'Check Availability';
	}
}
?>
	<div class="flex flex-col gap-2" id="wrap-login-book">
		<? /* aikhacode enable sementara */ ?>
		 <button id="submit-bookable" type="submit" class="<?php echo esc_attr($add_to_cart_classes); ?>"
	 	<?php echo "disabled";?>><?php echo $caption_button; //echo esc_html( $product->single_add_to_cart_text() );  ?></button>
	 	<? /* aikhacode enable sementara */ ?>
<?php
	/* aikhacode disable sementara 
	/* <?php if (is_user_logged_in()): ?>
	 <button id="submit-bookable" type="submit" class="<?php echo esc_attr($add_to_cart_classes); ?>"
	 	disabled><?php echo $caption_button; //echo esc_html( $product->single_add_to_cart_text() );  ?></button>
	 <?php endif;?>
	 <?php if (!is_user_logged_in()): ?>
	 <style>
	 	#wrap-login-book > .wp_google_login{
	 		width:100%;
	 	}
	 	#wrap-login-book .wp_google_login__button-container{
	 		margin-top:0!important;
	 	}

	 </style>

	 <?php echo do_shortcode("[google_login custom_btn_text='Login to proceed']"); ?>

	 <?php endif;?>
	*/ 
?>
	</div>

	<?php
/**
 * DO_ACTION: yith_wcbk_booking_after_add_to_cart_button
 * Hook to output something after the add-to-cart button in the booking form.
 */
do_action('yith_wcbk_booking_after_add_to_cart_button');
?>

	<?php do_action('woocommerce_after_add_to_cart_button');?>
</form>

<?php do_action('woocommerce_after_add_to_cart_form');?>
