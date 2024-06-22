<?php

/**
 * Custom Addition
 **/

namespace Cuberaksi\WooCommerce;

use Kucrut\Vite;


// require_once CUBERAKSI_SUNDARA_BASE_DIR . 'woo/amelia_data.php';
require_once CUBERAKSI_SUNDARA_BASE_DIR . 'vendor/autoload.php';
require_once CUBERAKSI_SUNDARA_BASE_DIR . 'woo/vite.php';
// use Cuberaksi\Amelia\Service\Amelia_Data;
global $tmpjson;

class Cuberaksi_Custom
{
	static $instance;
	protected $exchange_api;
	protected $exchange_api_key;
	public $currency;

	public function __construct()
	{
		// delete_transient('currency_rate_');
		// delete_transient('currency_rate');

		$this->init();
		$this->currency = 'USD';
		// delete_transient('currency_rate_');
	}

	public static function get_instance(): Cuberaksi_Custom
	{

		if (null !== self::$instance) {
			return self::$instance;
		}

		self::$instance = new Cuberaksi_Custom();
		return self::$instance;
	}

	function register_reviews_widget($widgets_manager)
	{

		// require_once(CUBERAKSI_SUNDARA_BASE_DIR . 'woo/elementor-reviews.php');


		// $widgets_manager->register(new \Cuberaksi_Reviews());
	}


	function init()
	{
		$this->init_checkout();
		$this->override_checkout();
		$this->override_billing_city();
		$this->smooth_scroll();

		$this->custom_customer_panel_content();
		// $this->add_custom_fields();
		$this->enqueue_scripts();
		add_action('save_post', [$this, 'save_update_custom_time']);
		$this->currency_api();
		// add_action('pre_current_active_plugins', [$this, 'hide_klaviyo']);
		$this->init_custom_payment_channel();

		$this->init_people_grup_two();

		add_action('elementor/widgets/register', [$this, 'register_reviews_widget']);

		// add_action('plugins_loaded',function(){
		// 	include_once(CUBERAKSI_SUNDARA_BASE_DIR . "paypal/paypal.php");
		// 	new \WC_Custom_PayPal_Preauth_Gateway();
		// });

	}

	function override_billing_city()
	{
		// function awcfe_city_dropdown_field( $fields ) {
		add_filter('woocommerce_checkout_fields', function ($fields) {

			// Copy from here

			/**
			 * Change the checkout city field to a dropdown field.
			 */

			//   fetch('https://countriesnow.space/api/v0.1/countries/cities',{
			// 		body:JSON.stringify({country: negoro}),
			// 		headers:{
			// 			'Content-Type': 'application/json'
			// 		}
			// 	}).then((res)=>res.json()).then((res)=>{
			$city_args = wp_parse_args(array(
				'type' => 'select',
				'options' => array(
					'birmingham' => 'Birmingham',
					// 'cambridge' => 'Cambridge',
					// 'leicester'   => 'Leicester',
					// 'liverpool' => 'Liverpool',
					// 'london'    => 'London',
					// 'manchester'  => 'Manchester',
				),
				'input_class' => array(
					'wc-enhanced-select',
				)
			), $fields['shipping']['shipping_city']);

			$fields['shipping']['shipping_city'] = $city_args;
			$fields['billing']['billing_city'] = $city_args; // Also change for billing field



			return $fields;
		});




		// 	// $state_args = wp_parse_args( array(
		// 	// 	'placeholder' => 'select a region',
		// 	// 	'input_class' => array(
		// 	// 		'wc-enhanced-select',
		// 	// 	)
		// 	// ), $fields['billing']['billing_state'] );

		// 	// $fields['billing']['billing_state'] = $state_args;

		// 	wc_enqueue_js( "
		// 	jQuery( ':input.wc-enhanced-select' ).filter( ':not(.enhanced)' ).each( function() {
		// 		var select2_args = { minimumResultsForSearch: 5 };
		// 		jQuery( this ).select2( select2_args ).addClass( 'enhanced' );
		// 	});" );

		// 	return $fields;

		// }
		// add_filter( 'woocommerce_checkout_fields', 'awcfe_city_dropdown_field', 999999, 1 );
	}

	function currency_api()
	{
	}

	function init_custom_payment_channel()
	{
		add_filter('woocommerce_available_payment_gateways', function ($gateways) {
			// file_put_contents('gtwy.txt',json_encode($gateways,JSON_PRETTY_PRINT));
			if (is_admin()) {
				return $gateways;
			}

			// if( is_wc_endpoint_url( 'order-pay' ) ) { // Pay for order page

			// 	$order = wc_get_order( wc_get_order_id_by_order_key( $_GET[ 'key' ] ) );
			// 	$country = $order->get_billing_country();

			// } else { // Cart page

			// 	$country = WC()->customer->get_billing_country();

			// }

			// if ( 'MC' === $country ) {
			// 	if ( isset( $gateways[ 'paypal' ] ) ) {
			// 		unset( $gateways[ 'paypal' ] );
			// 	}
			// }

			return $gateways;
		});
	}

	function hide_klaviyo()
	{

		global $wp_list_table;
		$hidearr = array('klaviyo/klaviyo.php');
		$myplugins = $wp_list_table->items;
		foreach ($myplugins as $key => $val) {
			if (in_array($key, $hidearr)) {
				unset($wp_list_table->items[$key]);
			}
		}
	}

	function enqueue_scripts()
	{
		add_action('wp_enqueue_scripts', function () {
			wp_enqueue_style('cb-xd-globals', CUBERAKSI_SUNDARA_BASE_URL . 'woo/assets/css/global.css', [], CUBERAKSI_SUNDARA_VERSION);
			// wp_enqueue_style('child-style-sundara', "https://sundaratravelclub.com/wp-content/themes/sundara-theme/style.css", [], CUBERAKSI_SUNDARA_VERSION);

			// wp_enqueue_script('jquery-lazy','https://cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.11/jquery.lazy.min.js',['jquery']);
			// wp_enqueue_script('jquery-lazy-custom', CUBERAKSI_SUNDARA_BASE_URL . 'woo/assets/js/global.js', ['jquery'], '-' . CUBERAKSI_SUNDARA_VERSION);
			wp_enqueue_script('jq-lazyimg', CUBERAKSI_SUNDARA_BASE_URL . 'woo/assets/js/lazyimg.js', ['jquery'], '-' . CUBERAKSI_SUNDARA_VERSION, true);
			wp_enqueue_script('jq-tipy1', 'https://unpkg.com/@popperjs/core@2', ['jq-lazyimg'], '-' . CUBERAKSI_SUNDARA_VERSION, true);
			wp_enqueue_script('jq-tipy2', 'https://unpkg.com/tippy.js@6', ['jq-lazyimg'], '-' . CUBERAKSI_SUNDARA_VERSION, true);


			wp_enqueue_script('jq-cookie', "https://cdn.jsdelivr.net/npm/js-cookie@3.0.5/dist/js.cookie.min.js", ['jquery']);

			wp_enqueue_script('myaccount', CUBERAKSI_SUNDARA_BASE_URL . 'woo/assets/js/myaccount.js', [], CUBERAKSI_SUNDARA_VERSION);
			wp_enqueue_style('cube-loader', CUBERAKSI_SUNDARA_BASE_URL . 'woo/assets/css/preloader.css', [], CUBERAKSI_SUNDARA_VERSION);
		});

		add_action('admin_enqueue_scripts', function () {
			wp_enqueue_style('cb-xd-globals', CUBERAKSI_SUNDARA_BASE_URL . 'woo/assets/css/global.css');
		});
	}

	function add_custom_fields()
	{
		// The code for displaying WooCommerce Product Custom Fields
		add_action('woocommerce_product_options_general_product_data', [$this, 'add_product_data']);

		// Following code Saves  WooCommerce Product Custom Fields
		add_action('woocommerce_process_product_meta', [$this, 'save_product_data']);
	}

	function add_product_data()
	{
		global $woocommerce, $post;
		echo '<div class="product_custom_field">';
		// Custom Product Text Field
		woocommerce_wp_text_input(
			array(
				'id' => 'duration_text_field',
				'placeholder' => 'Duration Trip',
				'label' => __('Duration Trip', 'woocommerce'),
				'desc_tip' => 'true',
			)
		);
		//Custom Product Number Field
		woocommerce_wp_text_input(
			array(
				'id' => 'max_people_number_field',
				'placeholder' => 'Maximum People',
				'label' => __('Maximum People', 'woocommerce'),
				'type' => 'number',
				'custom_attributes' => array(
					'step' => 'any',
					'min' => '1',
				),
			)
		);

		echo '</div>';
	}

	function save_update_custom_time($post_id)
	{
		if (isset($_POST['from-time'])) {
			global $post;
			update_post_meta($post_id, '_from_time', $_POST['from-time']);
		}
	}

	function save_product_data($post_id)
	{
		// Custom Product Text Field
		$woocommerce_duration = $_POST['duration_text_field'];
		if (!empty($woocommerce_duration)) {
			update_post_meta($post_id, 'duration_text_field', esc_attr($woocommerce_duration));
		}

		// Custom Product Number Field
		$woocommerce_max_people = $_POST['max_people_number_field'];
		if (!empty($woocommerce_max_people)) {
			update_post_meta($post_id, 'max_people_number_field', esc_attr($woocommerce_max_people));
		}
	}

	function init_checkout()
	{
		// Hook in
		add_filter('woocommerce_checkout_fields', [$this, 'override_checkout_fields']);
		add_filter('wp_nav_menu_items', [$this, 'add_login_logout_menu'], 10, 2);
		// Our hooked in function - $fields is passed via the filter!
		add_filter('woocommerce_order_button_text', function () {
			return 'Procced to payment';
		});

		if (!is_admin()) {

			add_filter('woocommerce_currency', [$this, 'change_woocommerce_currency']);

			add_filter('woocommerce_product_get_price', [$this, 'change_price_regular_member'], 10, 2);

			add_filter('woocommerce_get_price_html', [$this, 'change_price_regular_html'], 10, 2);

			//force indonesia currency
			// if (!isset($_COOKIE['__currency__cb'])) {
			// 	setcookie('__currency__cb', 'IDR', CUBERAKSI_SUNDARA_VERSION + (86400 * 30), "/");
			// 	$_COOKIE['__currency__cb'] = 'IDR';
			// }

			//delete indonesia curr
			if (!isset($_GET['currency'])) {
				if (isset($_COOKIE['__currency__cb'])) {
					unset($_COOKIE['__currency__cb']);
					setcookie('__currency__cb', '', time() - 3600, '/');
				}
			}

			if (isset($_COOKIE['__currency__cb'])) {
				if ($_COOKIE['__currency__cb'] === 'THB') {
					setcookie('__currency__cb', 'USD', time() + (86400 * 30), "/");
				}
			}

			if (isset($_GET['currency'])) {

				if (in_array($_GET['currency'], array('USD', 'IDR'))) {

					setcookie('__currency__cb', $_GET['currency'], time() + (86400 * 30), "/");

					$_COOKIE['__currency__cb'] = $_GET['currency'];
				}
			}
		}

		// add_filter('yith_wcbk_booking_product_get_price',[$this,'change_price_regular_member'], 10, 2);

		// add_filter('woocommerce_product_get_regular_price',[$this,'change_price_regular_member'], 10, 2);
		// add_filter('woocommerce_product_get_sale_price',[$this,'change_price_regular_member'], 10, 2);
		// add_filter('woocommerce_available_payment_gateways', [$this, 'change_available_payment_gateways']);

		add_action('yith_wcbk_booking_form_end', function ($product) {
			// $bookings = yith_wcbk_booking_helper()->get_bookings_by_user(wp_get_current_user()->ID);
			// $obj_b64 = base64_encode(print_r($product, true)) . " #toto# ";
			// error_log($obj_b64, 3, CUBERAKSI_SUNDARA_BASE_DIR . "woo/logs.txt");
			// $user_id = wp_get_current_user()->ID;
			// $booking_id = $product->get_id();
			// $session_id = random_bytes(3);
			// update_option("user$user_id", json_encode(['session_id' => $session_id, 'user_id' => $user_id, 'product_id' => $booking_id, 'session_book' => true]));

		});
	}

	function init_people_grup_two()
	{
		// add_action('admin_enqueue_scripts', function () {
		// 	wp_enqueue_script('cuber-people', CUBERAKSI_SUNDARA_BASE_URL . "woo/people.js", ['jquery'], CUBERAKSI_SUNDARA_VERSION, true);
		// 	global $post;
		// 	$people = get_post_meta($post->ID, '_cuber_people_two', true);
		// 	if ($people)
		// 		wp_add_inline_script('cuber-people', "const cuber_people_two='$people';", 'before');
		// });

		add_action('woocommerce_cart_calculate_fees', function () {
			// WC()->cart->add_fee('Extra people fee',1000);

		});

		add_action('save_post', function ($post_id, $post, $update) {
			// update_post_meta($post_id, '_cuber_booking_min_persons', $_POST['_yith_booking_min_persons']);
			// $base_cost_with30percent = $_POST['_yith_booking_block_cost'] * 0.3;
			// update_post_meta($post_id, '_cuber_booking_30_percent_extra', $base_cost_with30percent);

			if (isset($_POST['_cuber_people_two'])) {
				if ($_POST['_cuber_people_two'] === 'yes')
					update_post_meta($post_id, '_cuber_people_two', 'active');
				// 


			}
		}, 10, 3);
	}

	function change_price_regular_member($price, $product_id)
	{
		// if (is_admin()) return $price;
		if (isset($_COOKIE['__currency__cb'])) {
			if ($_COOKIE['__currency__cb'] === 'USD') {
				return $price;
			}
		}

		// return $price * get_current_currency_to_idr();
		return $price;
	}

	function change_price_regular_html($price, $product_id)
	{
		$formatted_price = $price;

		$price = preg_replace('/[^0-9]/', '', wp_strip_all_tags($price));

		// if ((isset($_COOKIE['__currency__cb'])))
		// 	if ($_COOKIE['__currency__cb'] === 'THB')
		// 		$price = substr($price, 4);

		if ((isset($_COOKIE['__currency__cb']))) {
			if ($_COOKIE['__currency__cb'] === 'USD') {
				$price = substr($price, 2);
			}
		}

		//no cookie then usd assume
		if ((!isset($_COOKIE['__currency__cb']))) {
			$price = substr($price, 2);
		}

		// $curr = get_current_currency_to_idr();
		$curr = 1;
		// if (is_admin()) $curr = 1;
		if (isset($_COOKIE['__currency__cb'])) {
			if ($_COOKIE['__currency__cb'] === 'USD') {
				$curr = 1;
			}
		}

		$total = $price * $curr;
		// console_log([$price,$curr,$formatted_price]);

		$symbols = '$';
		if (isset($_COOKIE['__currency__cb'])) {
			switch ($_COOKIE['__currency__cb']) {
				case 'USD':
					$symbols = '$ ';
					break;
				case 'IDR':
					$symbols = 'Rp ';
					break;
					// case 'THB':
					// 	$symbols = '฿ ';
					// 	break;
				default:
					// code...
					break;
			}
		}

		$amount = new \NumberFormatter('en_US', \NumberFormatter::DECIMAL);
		$amount->setAttribute(\NumberFormatter::MAX_FRACTION_DIGITS, 0);

		$formatted_price = $amount->format($total);

		// if (is_admin()) {
		// 	$symbols = '$';
		// 	$formatted_price = $price;
		// }

		return "<span class='woocommerce-Price-amount amount'><bdi><span class='woocommerce-Price-currencySymbol'>$symbols</span>$formatted_price</bdi></span>";

		// <bdi><span class="woocommerce-Price-currencySymbol">Rp</span>4,300</bdi>
	}

	// function save_update_service($post_id)
	// {

	// 	if (get_post_type($post_id) === 'product') {

	// 		$service = [];
	// 		$var = get_post_meta($post_id, '_amelia_service_product', true);
	// 		$amelia_data_obj = new Amelia_Data();
	// 		$product = wc_get_product($post_id);
	// 		$updated['price'] = $product->get_price();
	// 		$updated['name'] = $product->get_title();
	// 		$updated['description'] = $product->get_title();
	// 		$updated['product_id'] = $post_id;

	// 		if ($var) {
	// 			// service exist

	// 			$amelia_data_obj->update_service($post_id, $updated);
	// 		} else {
	// 			//update table amelia service
	// 			$amelia_data_obj->update_service($post_id, $updated);
	// 		}
	// 	}

	// 	return;
	// }

	function change_woocommerce_currency($currency)
	{

		// global $wp;
		// global $post;

		// $current_currency = $currency;

		// if (isset($_GET['wc-ajax'])) {

		// 	if ($_GET['wc-ajax'] === 'checkout')
		// 		$current_currency = 'IDR';
		// }

		// return $current_currency;

		// if (is_admin()) return 'USD';

		// if (isset($_GET['currency'])) {

		// 	if (in_array($_GET['currency'], array('USD', 'IDR', 'THB'))) {

		// 		return $_GET['currency'];
		// 	}
		// }
		if (isset($_COOKIE['__currency__cb'])) {
			return $_COOKIE['__currency__cb'];
		}

		// return 'IDR';
		return $currency;
	}

	function change_available_payment_gateways($available_gateways)
	{
		if (is_checkout()) {
		}
		return $available_gateways;
	}

	function custom_customer_panel_content()
	{
		add_action('init', function () {
			// if (!is_admin()) {

			// 	add_filter('woocommerce_currency', [$this, 'change_woocommerce_currency']);

			// 	add_filter('woocommerce_product_get_price', [$this, 'change_price_regular_member'], 10, 2);

			// 	add_filter('woocommerce_get_price_html', [$this, 'change_price_regular_html'], 10, 2);

			// 	if (isset($_GET['currency'])) {

			// 		if (in_array($_GET['currency'], array('USD', 'IDR', 'THB'))) {

			// 			setcookie('__currency__cb', $_GET['currency'], time() + (86400 * 30), "/");
			// 		}
			// 	}

			// }



		});




		add_action('template_redirect', function ($template) {
			global $post;
			// console_log(['post'=>$post]);

			if (str_contains($_SERVER['REQUEST_URI'], '/logoutme')) {
				if (is_user_logged_in()) wp_logout();
				wp_redirect('/');
			}


			if ($post->post_name === 'checkout') {
				if (!is_user_logged_in()) {
					// echo "Login First";
				}
				if (is_checkout()) {
					$cart = WC()->cart->get_cart();
					$count = count($cart);
					if ($count > 1) {
						$i = 1;
						foreach ($cart as $cart_item_key => $cart_item) {
							if ($i < $count)
								WC()->cart->remove_cart_item($cart_item_key);
							$i++;
						}
					}
				}
			}
			return $template;
		});
		add_action('template_include', function ($template) {

			$request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : false;
			// console_log(['#1', $request_uri]);

			if (($request_uri === '/cube') || ($request_uri === '/cube\/')) {
				console_log(['#2', $request_uri]);
				wp_redirect(admin_url());
			}



			global $post;
			if (isset($post->post_name)) {
				// error_log(wp_upload_dir(),3,.);
				// echo wp_upload_dir();
				if ($post->post_name === 'my-account') {
					// wp_enqueue_script('woo-cuberaksi-cpanel', CUBERAKSI_SUNDARA_BASE_URL . 'woo/customer11b.js', array('jquery'), CUBERAKSI_SUNDARA_VERSION);
					// wp_enqueue_style('woo-cuberaksi-cpanel', CUBERAKSI_SUNDARA_BASE_URL . 'woo/assets/css/customer-panel.css', [], CUBERAKSI_SUNDARA_VERSION);

					if (!is_user_logged_in()) {
						wp_redirect('/login');
					}
				}

				if ($post->post_name === 'please-login') {
					if (!is_admin()) {

						if (is_user_logged_in()) {
							// wp_redirect('/');
						}
						wp_redirect('/');
					}
				}

				if (is_shop()) {
					wp_redirect(home_url());
				}

				if (str_contains($_SERVER['REQUEST_URI'], '/login/?resetpass=complete')) {

					wp_redirect('/my-account');
				}

				if ($post->post_name === 'login') {
					if (is_user_logged_in()) {
						if (!is_admin())
							wp_redirect('/my-account');
					}
				}

				if ($post->post_name === 'my-account') {
					// header('Location: ' . $_SERVER['HTTP_REFERER']);
					// wp_redirect(home_url() . '/my-account');
					$current_url = "//" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
					// console_log(['msg' => $_SERVER['REQUEST_URI']]);
					if (str_contains($_SERVER['REQUEST_URI'], '/my-account/lost-password')) {
						wp_redirect('/lost-password');
					}






					if (str_contains($_SERVER['REQUEST_URI'], '?confirm=yes')) {
						add_action('wp_footer', function () {

							if (is_user_logged_in()) {

?><script>
									jQuery(document).ready(($) => {
										const interval = setInterval(() => {
											if (elementorProFrontend.modules.popup) {

												elementorProFrontend.modules.popup.showPopup({
													id: 6717
												});

												$('#woo-msg-notice').html($('#woo-msg-notice').html().replace("{{message_notice}}", 'Request booking confirm email sent.'))
												clearInterval(interval);



											}
										}, 100)
									})
								</script>;
			<?php
							}

							return; //return nothing by default and do not show the popup.
						}, 10, 5);
					}
				}
			}

			if (is_checkout()) {

				wp_enqueue_script('checkoutme', CUBERAKSI_SUNDARA_BASE_URL . 'woo/assets/js/checkout.js', ['jquery'], CUBERAKSI_SUNDARA_VERSION);

				wp_enqueue_style('accpage-css', CUBERAKSI_SUNDARA_BASE_URL . "woo/templates/myaccount/dist/main.css", [], CUBERAKSI_SUNDARA_VERSION);
				wp_enqueue_script_module('accpage-js', CUBERAKSI_SUNDARA_BASE_URL . "woo/templates/myaccount/dist/index.js", [], CUBERAKSI_SUNDARA_VERSION, true);
				wp_enqueue_script_module('accpagewc-js', CUBERAKSI_SUNDARA_BASE_URL . "woo/templates/myaccount/dist/wc.js", [], CUBERAKSI_SUNDARA_VERSION, true);


				// Vite\enqueue_asset(
				// 	CUBERAKSI_SUNDARA_BASE_DIR . "woo/templates/myaccount/dist",
				// 	'src/main.tsx',
				// 	[
				// 		'dependencies' => ['react', 'react-dom'],
				// 		'handle' => 'vite-for-wp-react',
				// 		'in-footer' => true,

				// 	]
				// );
			}

			if (is_product()) {

				add_action('wp_enqueue_scripts', function () {

					global $post;
					$product_id = $post->ID;

					$terms = get_the_terms($post->ID, 'product_cat');
					foreach ($terms as $term) {
						$product_cat = $term->name;
						break;
					}

					$timeline = \get_field('timeline_off');

					$json = json_encode(['timeline_off' => $timeline]);
					$json_product = json_encode(['is_user_logged_in' => is_user_logged_in(), 'cat' => $product_cat, 'ID' => $product_id]);
					$tmp = ['d1' => false, 'd2' => false, 'd3' => false, 'd4' => false, 'd5' => false, 'd6' => false, 'd7' => false];
					$day_content = [];
					for ($i = 1; $i <= 12; $i++) {
						// $day_content[] = ['content' => get_field("day_$i", $product_id)];
						if (get_field("day_$i", $product_id) !== '') {
							$tmp["d$i"] = true;
						}
					}

					$day_content_json = json_encode($day_content);
					$json_TL_Arr = json_encode($tmp);

					//update galleries 
					require_once "timeline_galleries.php";
					$json_galleries = json_encode(get_timeline_galleries($product_id));

					// global js
					wp_enqueue_script('jquery-lazy-custom', CUBERAKSI_SUNDARA_BASE_URL . 'woo/assets/js/global.js?' . CUBERAKSI_SUNDARA_VERSION, ['jquery']);

					wp_enqueue_script('yith-custom-form', CUBERAKSI_SUNDARA_BASE_URL . 'woo/assets/js/yith-custom-form.js?' . CUBERAKSI_SUNDARA_VERSION, ['jquery']);

					wp_enqueue_script('splidejs', 'https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js');

					wp_enqueue_style('splidejscss', 'https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/themes/splide-skyblue.min.css');

					// wp_enqueue_script('timelinegal-slick','https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js',['jquery']);
					// wp_enqueue_script('timelinegal-fslightbox','https://cdnjs.cloudflare.com/ajax/libs/fslightbox/3.0.9/index.min.js');
					// wp_enqueue_style('timelinegal-slick-css','https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css');
					// wp_enqueue_style('timelinegal-slick-css-theme','https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css');

					$peopletwo = get_post_meta($product_id, '_cuber_people_two', true);

					$product_yith = yith_wcbk_get_booking_product($product_id);
					$min_persons = $product_yith->get_minimum_number_of_people();

					$product_price =  get_post_meta($product_id, '_yith_booking_extra_costs', true)['10059']['cost'];

					if (!$product_price) $product_price = 0;

					wp_enqueue_script('timelinegal', CUBERAKSI_SUNDARA_BASE_URL . 'woo/assets/js/timelinegal.js?' . CUBERAKSI_SUNDARA_VERSION, ['jquery']);
					// wp_enqueue_script('jquery-lazy-custom');
					// wp_enqueue_script('sa2','https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js');
					// wp_enqueue_style('sa2css','https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css');
					$inclusions = false;
					$noninclusions = false;
					if (get_field('inclusions', $product_id)) {
						$inclusions = true;
					}

					if (get_field('non_inclusions', $product_id)) {
						$noninclusions = true;
					}

					wp_add_inline_script('jquery-lazy-custom', "const timelineObj=$json; const productme=$json_product; const timelineArr=$json_TL_Arr; const dayContent=$day_content_json;const peopletwo='$peopletwo'; const extra_cost_people={min_persons:$min_persons,product_price:$product_price}; const inclusions=[$inclusions,$noninclusions]", 'before');

					wp_add_inline_script('timelinegal', "const galleries=$json_galleries", 'before');


					wp_enqueue_style('timeline-custom-css', CUBERAKSI_SUNDARA_BASE_URL . 'woo/assets/js/gal.css', [], CUBERAKSI_SUNDARA_VERSION);

					wp_enqueue_script('tailwindcss', 'https://cdn.tailwindcss.com');
					// wp_enqueue_script('unocss', 'https://cdn.jsdelivr.net/npm/@unocss/runtime');
					if (is_user_logged_in()) {
						// $bookings = yith_wcbk_booking_helper()->get_bookings_by_user(wp_get_current_user()->ID);

						// $user_id = wp_get_current_user()->ID;
						// $temp = get_option("user$user_id");
						// $json = json_encode(["before", "user$user_id", $temp]);
						// wp_add_inline_script('jquery-lazy-custom', "console.log($json); ", 'before');
						// if ($temp !== false) {
						// 	$json = json_encode(["after", "user$user_id", $temp]);
						// 	wp_add_inline_script('jquery-lazy-custom', "console.log($json); ", 'before');
						// 	delete_option("user$user_id");
						// 	wp_redirect("/my-account/bookings");
						// }

						// wp_redirect("/my-account/view-booking/$transient");

						// wp_add_inline_script('jquery-lazy-custom', "console.log('$transient'); ", 'before');

					}
				});
			}

			// wp_enqueue_script('amelbr', CUBERAKSI_SUNDARA_BASE_URL . 'woo/ameliabr.js', ['jquery']);

			return $template;
		});
	}

	function add_login_logout_menu($items, $args)
	{
		ob_start();
		if (\is_user_logged_in()) {
			?>
			<style>
				.mr-2 {
					margin-right: 0.4rem;
				}
			</style>

			<?php
			// $url_target = "/order-first";
			// if (is_user_logged_in() && defined('AMELIA_VERSION')) {
			// 	$user = wp_get_current_user();
			// 	global $wpdb;
			// 	$var = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}amelia_users WHERE status='visible' AND type='customer' AND email='{$user->user_email}' ");
			// 	if ($var > 0) {
			// 		$url_target = "/my-account";
			// 	}
			// }

			$url_target = "#";
			if (is_user_logged_in()) {
				$url_target = "/my-account";
			}
			$url_logout = get_permalink();
			global $post;
			if ($post->post_name === 'thank-you-order') {
				$url_logout = '/';
			}
			?>

			<li class="menu-item "><a role="button" style="margin:10px;padding:10px" class="elementor-button elementor-button-link elementor-size-sm pad10 btn-panel" href="<?= $url_target ?>"><i class="fa fa-user mr-2"></i>My Account</a></li>
			<li class="menu-item "> <a role="button" class="elementor-button elementor-button-link elementor-size-sm pad10 btn-logout" style="margin:10px;padding:10px" href="<?php echo \wp_logout_url($url_logout); ?>"><i class="fa fa-sign-out mr-2" aria-hidden="true"></i>Log Out</a></li>
<?php
		} else {
			$redirect_to = $_SERVER['REQUEST_URI'];
			// $redirect_to='';
			echo \do_shortcode("[google_login redirect_to='$redirect_to']");

			//echo '<a role="button" class="elementor-button elementor-button-link elementor-size-sm" href="<?php echo \wp_login_url(\get_permalink()); ">Log In</a>';

		}
		// wp_loginout('index.php');
		$loginoutlink = ob_get_contents();
		ob_end_clean();
		$items .= $loginoutlink;
		return $items;
	}

	function override_checkout_fields($fields)
	{

		unset($fields['billing']['billing_company']);
		unset($fields['billing']['billing_address_1']);
		unset($fields['billing']['billing_address_2']);
		// unset($fields['billing']['billing_city']);
		unset($fields['billing']['billing_state']);
		unset($fields['billing']['billing_postcode']);

		$fields['billing']['message'] = array(
			'label' => __('Message', 'woocommerce'), // Add custom field label
			'placeholder' => _x('Message', 'placeholder', 'woocommerce'), // Add custom field placeholder
			'required' => false, // if field is required or not
			'clear' => false, // add clear or not
			'type' => 'text', // add field type
			'class' => array('billing-message'), // add class name
		);

		$fields['billing']['billing_phone']['required'] = true;
		// console_log($fields);




		return $fields;
	}


	function smooth_scroll()
	{
	}

	function override_checkout()
	{
		add_filter('woocommerce_locate_template', [$this, 'intercept_wc_template'], 12, 3);
		add_filter('wc_get_template', [$this, 'intercept_wc_get_template'], 12, 5);
	}

	/**
	 * Filter the cart template path to use cart.php in this plugin instead of the one in WooCommerce.
	 *
	 * @param string $template      Default template file path.
	 * @param string $template_name Template file slug.
	 * @param string $template_path Template file name.
	 *
	 * @return string The new Template file path.
	 */
	function intercept_wc_template($template, $template_name, $template_path)
	{

		$template_directory = trailingslashit(CUBERAKSI_SUNDARA_BASE_DIR) . 'woo/templates/';

		$path = $template_directory . $template_name;

		$template_target = file_exists($path) ? $path : $template;
		if (str_contains($template_name, 'email')) $template_target = $template;

		// // if (str_contains($template_name, 'booking-form'))
		// // 	console_log(['wc_template' => $template_name]);
		// wp_remote_post('https://webhook.site/436c6dec-4da8-41a2-a131-90c12f147a74',['body' => ['template' => $template, 'template_name' => $template_name],'sslverify' => false]);
		// wp_remote_get('https://webhook.site/436c6dec-4da8-41a2-a131-90c12f147a74');
		return $template_target;
	}

	function intercept_wc_get_template($template, $template_name, $args, $template_path, $default_path)
	{

		$template_directory = trailingslashit(CUBERAKSI_SUNDARA_BASE_DIR) . 'woo/templates/';
		$path = $template_directory . $template_name;

		// console_log([$template, $template_name, $args, $template_path, $default_path]);
		// if (str_contains($template_name, 'booking-form'))
		// 	console_log(['wc_get_template' => $template_name]);

		return file_exists($path) ? $path : $template;
		// return $template;
	}
}

$custom_cuberaksi = Cuberaksi_Custom::get_instance();

$shortcode_arr = ['calendar', 'trip_fields', 'price', 'map', 'yithbooking', 'product_feature', 'my_account'];

foreach ($shortcode_arr as $key => $value) {
	// code...
	// echo $value;
	require_once CUBERAKSI_SUNDARA_BASE_DIR . "shortcode/{$value}.php";
}

require_once CUBERAKSI_SUNDARA_BASE_DIR . "woo/helper.php";
require_once CUBERAKSI_SUNDARA_BASE_DIR . "acf-quickedit-fields/index.php";
// require_once CUBERAKSI_SUNDARA_BASE_DIR . "navz-photo-gallery/navz-photo-gallery.php";

require_once CUBERAKSI_SUNDARA_BASE_DIR . "acf/acf.php";

// 
// require_once CUBERAKSI_SUNDARA_BASE_DIR . "acf-repeater/acf-repeater.php";

require_once CUBERAKSI_SUNDARA_BASE_DIR . "woo/posttype.php";
require_once CUBERAKSI_SUNDARA_BASE_DIR . "woo/api.php";


require_once CUBERAKSI_SUNDARA_BASE_DIR . "woo/dynamic-tags.php";

require_once CUBERAKSI_SUNDARA_BASE_DIR . "woo/admin/admin.php";
require_once CUBERAKSI_SUNDARA_BASE_DIR . "woo/toaster.php";

// require_once CUBERAKSI_SUNDARA_BASE_DIR . 'shortcode/ameliabooking.php';
// require_once CUBERAKSI_SUNDARA_BASE_DIR . 'woo/approval.php';

//require_once CUBERAKSI_SUNDARA_BASE_DIR . 'shortcode/amelia_booking.php';
//test/
/**
 * Programmatically logs a user in
 *
 * @param string $username
 * @return bool True if the login was successful; false if it wasn't
 */
function programmatic_login($username)
{

	if (\is_user_logged_in()) {
		wp_logout();
	}
	add_filter('authenticate', 'allow_programmatic_login', 10, 3); // hook in earlier than other callbacks to short-circuit them
	$user = wp_signon(array('user_login' => $username));
	remove_filter('authenticate', 'allow_programmatic_login', 10, 3);

	if (is_a($user, 'WP_User')) {
		wp_set_current_user($user->ID, $user->user_login);

		if (is_user_logged_in()) {
			return true;
		}
	}

	return false;
}

/**
 * An 'authenticate' filter callback that authenticates the user using only the username.
 *
 * To avoid potential security vulnerabilities, this should only be used in the context of a programmatic login,
 * and unhooked immediately after it fires.
 *
 * @param WP_User $user
 * @param string $username
 * @param string $password
 * @return bool|WP_User a WP_User object if the username matched an existing user, or false if it didn't
 */
function allow_programmatic_login($user, $username, $password)
{
	return get_user_by('login', $username);
}

function console_log($obj)
{
	$json = json_encode($obj);
	echo "<script>console.log($json)</script>";
}
