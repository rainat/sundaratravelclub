<?php

/**
 * Custom Addition
 **/

class Cuberaksi_Custom
{
	static $instance;

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
	}

	function init_checkout()
	{
		// Hook in 
		add_filter('woocommerce_checkout_fields', [$this, 'override_checkout_fields']);
		add_filter('wp_nav_menu_items', [$this, 'add_login_logout_menu'], 10, 2);
		// Our hooked in function - $fields is passed via the filter! 
		add_filter('woocommerce_order_button_text', function(){ return 'Procced to payment';});
		

	}

	function custom_customer_panel_content()
	{
		add_action( 'template_redirect', function ($template){
			global $post;
			if ( isset($post->post_name) )
			if ( $post->post_name === 'customer') {
				wp_enqueue_script('woo-cuberaksi',CUBERAKSI_MIDTRANS_BASE_URL . 'woo/customer11.js',array('jquery') );
			}

			wp_enqueue_script('amelbr',CUBERAKSI_MIDTRANS_BASE_URL . 'woo/ameliabr.js',['jquery']);
			
			return $template;
		} );
	}

	function add_login_logout_menu($items, $args)
	{
		ob_start();
		if (\is_user_logged_in()) {
?>
			<style>.mr-2{margin-right: 0.4rem;}</style>
			<li class="menu-item "> <a role="button" class="elementor-button elementor-button-link elementor-size-sm pad10 btn-logout" style="margin:10px;padding:10px" href="<?php echo \wp_logout_url(\get_permalink()); ?>"><i class="fa fa-sign-out mr-2" aria-hidden="true"></i>Log Out</a></li>
			<?php
			$url_target = "/order-first";
			if (is_user_logged_in() && defined('AMELIA_VERSION')) {
				$user = wp_get_current_user();
				global $wpdb;
				$var = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}amelia_users WHERE status='visible' AND type='customer' AND email='{$user->user_email}' ");
				if ($var > 0) {
					$url_target = "/customer";
				}
			}

			?>

			<li class="menu-item "><a role="button" style="margin:10px;padding:10px" class="elementor-button elementor-button-link elementor-size-sm pad10 btn-panel" href="<?= $url_target ?>"><i class="fa fa-user mr-2"></i>My Account</a></li>
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


		$template_directory = trailingslashit(CUBERAKSI_MIDTRANS_BASE_DIR) . 'woo/templates/';
		$path = $template_directory . $template_name;

		return file_exists($path) ? $path : $template;
	}
}

$custom_cuberaksi = Cuberaksi_Custom::get_instance();


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
