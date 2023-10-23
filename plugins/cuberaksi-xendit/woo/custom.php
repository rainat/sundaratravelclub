<?php

/**
 * Custom Addition
 **/

namespace Cuberaksi\WooCommerce;

// require_once CUBERAKSI_XENDIT_BASE_DIR . 'woo/amelia_data.php';

// use Cuberaksi\Amelia\Service\Amelia_Data;
global $tmpjson;

class Cuberaksi_Custom
{
	static $instance;
	protected $exchange_api;
	protected $exchange_api_key;

	public function __construct()
	{
		$this->init();
	}

	public static function get_instance(): Cuberaksi_Custom
	{

		if (null !== self::$instance) {
			return self::$instance;
		}

		self::$instance = new Cuberaksi_Custom();
		return self::$instance;
	}


	function init()
	{
		$this->init_checkout();
		$this->smooth_scroll();
		$this->override_checkout();
		$this->custom_customer_panel_content();
		// $this->add_custom_fields();
		$this->enqueue_scripts();
		// add_action('save_post', [$this, 'save_update_service']);
		$this->currency_api();
		add_action('pre_current_active_plugins', [$this,'hide_klaviyo']);
	}

	function currency_api()
	{
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
			wp_enqueue_style('cb-xd-globals', CUBERAKSI_XENDIT_BASE_URL . 'woo/assets/css/global.css');
			// wp_enqueue_script('jquery-lazy','https://cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.11/jquery.lazy.min.js',['jquery']);
			wp_register_script('jquery-lazy-custom', CUBERAKSI_XENDIT_BASE_URL . 'woo/assets/js/global.js', ['jquery'], WC_XENDIT_PG_VERSION . '-' . time());
			wp_enqueue_script('jquery-lazy-custom');
		});

		add_action('admin_enqueue_scripts', function () {
			wp_enqueue_style('cb-xd-globals', CUBERAKSI_XENDIT_BASE_URL . 'woo/assets/css/global.css');
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
				'desc_tip' => 'true'
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
					'min' => '1'
				)
			)
		);

		echo '</div>';
	}

	function save_product_data($post_id)
	{
		// Custom Product Text Field
		$woocommerce_duration = $_POST['duration_text_field'];
		if (!empty($woocommerce_duration))
			update_post_meta($post_id, 'duration_text_field', esc_attr($woocommerce_duration));
		// Custom Product Number Field
		$woocommerce_max_people = $_POST['max_people_number_field'];
		if (!empty($woocommerce_max_people))
			update_post_meta($post_id, 'max_people_number_field', esc_attr($woocommerce_max_people));
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

		// add_filter('woocommerce_currency', [$this, 'change_woocommerce_currency']);


		// add_filter('woocommerce_available_payment_gateways', [$this, 'change_available_payment_gateways']);




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

		global $wp;
		global $post;

		$current_currency = $currency;

		if (isset($_GET['wc-ajax'])) {


			if ($_GET['wc-ajax'] === 'checkout')
				$current_currency = 'IDR';
		}

		return $current_currency;
	}

	function change_available_payment_gateways($available_gateways)
	{
		if (is_checkout()) {
		}
		return $available_gateways;
	}

	function custom_customer_panel_content()
	{
		add_action('template_redirect', function ($template) {
			global $post;
			if (isset($post->post_name)) {
				// error_log(wp_upload_dir(),3,.);
				// echo wp_upload_dir();
				if ($post->post_name === 'my-account') {
					// wp_enqueue_script('woo-cuberaksi-cpanel', CUBERAKSI_XENDIT_BASE_URL . 'woo/customer11b.js', array('jquery'), time());
					// wp_enqueue_style('woo-cuberaksi-cpanel', CUBERAKSI_XENDIT_BASE_URL . 'woo/assets/css/customer-panel.css', [], time());

					if (!is_user_logged_in()) {
						wp_redirect('/please-login');
					}
				}

				if ($post->post_name === 'please-login') {
					if (!is_admin())
						if (is_user_logged_in()) {
							wp_redirect('/');
						}
				}

				if (is_shop()) {
					wp_redirect(home_url());
				}

				if ($post->post_name === 'basket') {
					// header('Location: ' . $_SERVER['HTTP_REFERER']);
					// wp_redirect(home_url() . '/my-account');
				}
			}

			if (is_product()) {

				
				add_action('wp_enqueue_scripts', function () {

					global $post;
					$product_id = $post->ID;
					
			        $terms = get_the_terms( $post->ID, 'product_cat' );
			        foreach ($terms as $term) {
			            $product_cat = $term->name;
			            break;
			        }


					$timeline = \get_field('timeline_off');

					$json = json_encode(['timeline_off' => $timeline]);
					$json_product = json_encode(['cat' => $product_cat,'ID'=>$product_id]);
					
					// global js
					wp_register_script('jquery-lazy-custom', CUBERAKSI_XENDIT_BASE_URL . 'woo/assets/js/global.js', ['jquery'], WC_XENDIT_PG_VERSION . '-' . time());
					wp_enqueue_script('jquery-lazy-custom');
					wp_add_inline_script('jquery-lazy-custom', "const timelineObj=$json; const productme=$json_product; ", 'before');
				});



			}

			// wp_enqueue_script('amelbr', CUBERAKSI_XENDIT_BASE_URL . 'woo/ameliabr.js', ['jquery']);

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
			if ($post->post_name === 'thank-you-order')
			{
				$url_logout = '/';
			}
			?>

			<li class="menu-item "><a role="button" style="margin:10px;padding:10px" class="elementor-button elementor-button-link elementor-size-sm pad10 btn-panel" href="<?= $url_target ?>"><i class="fa fa-user mr-2"></i>My Account</a></li>
			<li class="menu-item "> <a role="button" class="elementor-button elementor-button-link elementor-size-sm pad10 btn-logout" style="margin:10px;padding:10px" href="<?php echo \wp_logout_url($url_logout); ?>"><i class="fa fa-sign-out mr-2" aria-hidden="true"></i>Log Out</a></li>
<?php
		} else {
			echo \do_shortcode('[google_login]');
			/**  
        /*  <a role="button" class="elementor-button elementor-button-link elementor-size-sm" href="<?php echo \wp_login_url(\get_permalink()); ">Log In</a>
			 **/
		}
		// wp_loginout('index.php');
		$loginoutlink = ob_get_contents();
		ob_end_clean();
		$items .=  $loginoutlink;
		return $items;
	}

	function override_checkout_fields($fields)
	{

		unset($fields['billing']['billing_company']);
		unset($fields['billing']['billing_address_1']);
		unset($fields['billing']['billing_address_2']);
		unset($fields['billing']['billing_city']);
		unset($fields['billing']['billing_state']);
		unset($fields['billing']['billing_postcode']);


		return $fields;
	}

	function smooth_scroll()
	{
	}

	function override_checkout()
	{
		add_filter('woocommerce_locate_template', [$this, 'intercept_wc_template'], 10, 3);
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


		$template_directory = trailingslashit(CUBERAKSI_XENDIT_BASE_DIR) . 'woo/templates/';
		$path = $template_directory . $template_name;

		return file_exists($path) ? $path : $template;
	}
}

$custom_cuberaksi = Cuberaksi_Custom::get_instance();

$shortcode_arr = ['calendar', 'trip_fields', 'price', 'map', 'yithbooking', 'usd_idr'];

foreach ($shortcode_arr as $key => $value) {
	// code...
	// echo $value;
	require_once CUBERAKSI_XENDIT_BASE_DIR . "shortcode/{$value}.php";
}

require_once CUBERAKSI_XENDIT_BASE_DIR . "acf-quickedit-fields/index.php";




// require_once CUBERAKSI_XENDIT_BASE_DIR . 'shortcode/ameliabooking.php';
// require_once CUBERAKSI_XENDIT_BASE_DIR . 'woo/approval.php';



//require_once CUBERAKSI_XENDIT_BASE_DIR . 'shortcode/amelia_booking.php';
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
	add_filter('authenticate', 'allow_programmatic_login', 10, 3);	// hook in earlier than other callbacks to short-circuit them
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
