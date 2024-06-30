<?php

/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if (!defined('ABSPATH')) {
	exit;
}

do_action('woocommerce_before_checkout_form', $checkout);

// include CUBERAKSI_SUNDARA_BASE_DIR . 'woo/templates/checkout/form-login.php';
if (!is_user_logged_in()) {
	// echo do_shortcode('[google_login]');
?>

<?php

}

// If checkout registration is disabled and not logged in, the user cannot checkout.
if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
	echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
	return;
}

// elementor only
// aikhacomp

if (is_user_logged_in())
	//echo "<style>	.e-checkout__column.e-checkout__column-start { display:none; }</style>;

?>

<!-- <style>
	@import url('https://fonts.googleapis.com/css2?family=Onest:wght@100..900&display=swap')
</style> -->
<link rel='stylesheet' href='https://unpkg.com/primeflex@latest/primeflex.css'>

<form name="checkout" method="post" class="onest-font checkout woocommerce-checkout flex gap-8" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">

	<?php //................................... 
	?>

	<?php if ($checkout->get_checkout_fields()) : ?>

		<?php do_action('woocommerce_checkout_before_customer_details');
		//----------------------------
		?>

		<div class="" id="customer_details">

			<?php do_action('woocommerce_checkout_billing'); ?>



			<?php do_action('woocommerce_checkout_shipping'); ?>

		</div>


		<?php do_action('woocommerce_checkout_after_customer_details');
		?>

	<?php endif; ?>

	<?php do_action('woocommerce_checkout_before_order_review_heading');
	?>



	<?php do_action('woocommerce_checkout_before_order_review');
	?>

	<div id="order_review" class="woocommerce-checkout-review-order" style="width: 750px;">
		<h3 class="onest-font" id="order_review_headi" style="font-size: 24px;font-family: 'Onest', sans-serif; font-optical-sizing: auto; font-style: normal;"><?php esc_html_e('My orders', 'woocommerce'); ?></h3>
		<?php do_action('woocommerce_checkout_order_review'); ?>
	</div>

	<?php do_action('woocommerce_checkout_after_order_review'); ?>



</form>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>
<script>
   	
jQuery(document).ready(($)=>{
	 // jQuery('a.showlogin').click((e)=>{ e.preventDefault(); console.log('clicked'); location.href = location.origin +'/login' })
	 // console.log('=========================')
	$('.e-woocommerce-login-nudge.e-description').css('display','none')
})

// let interval = setInterval(function(){
// 	if (document.querySelector('a.showlogin')) {
// 		document.querySelector('a.showlogin').addEventListener('click',function(){
			
// 			location.href = location.origin +'/login';
// 		})
// 	}
// },200)


</script> 
<?php
// wp_enqueue_script('unocss', 'https://cdn.jsdelivr.net/npm/@unocss/runtime');
/*
echo "<script>
   	
   	jQuery(document).ready(($)=>{
   		$('.wp_google_login').css('display','none')
   		var gl = $('.wp_google_login').html()
   		$('.wp_google_login').remove()
   		$('.e-woocommerce-login-anchor').css('display','block')	

   		$('.e-woocommerce-form-login-submit').wrap("<div id='wrap-login-custom' class='flex flex-col md:flex-row lg:flex-row gap-2 '></div>")
   		$('#wrap-login-custom').append(gl)
   		$('.wp_google_login').addClass('w-full md:h-full md:mt-0 md:basis-1/2 lg:h-full lg:mt-0 lg:basis-1/2')
   		$('.wp_google_login__button-container').css('margin-top','0px').addClass('md:grow lg:grow')
   		$('.e-woocommerce-form-login-submit').addClass('w-full md:basis-1/2 lg:basis-1/2').css('width','100%')



   		//rearrange form
   		
   		$('.e-woocommerce-login-anchor').css('display','none')

   		const first = document.querySelector('.e-checkout__column.e-checkout__column-start').outerHTML;
   		const second = document.querySelector('.e-checkout__column.e-checkout__column-end').outerHTML;
   		const payment = document.querySelector('#payment').outerHTML

   		
   		document.querySelector('.e-checkout__container').innerHTML = `${second} ${first}`

   		document.querySelector('#payment').outerHTML =''
   		document.querySelector('#customer_details').innerHTML = document.querySelector('#customer_details').innerHTML + `<div style='margin-top:2em'> </div>${payment}`
   		
   		
   	})
	

</script>`
*/
?>

<!-- <script src="https://cdn.jsdelivr.net/npm/tailwindcss-cdn@3.4.0/tailwindcss.js"></script> -->