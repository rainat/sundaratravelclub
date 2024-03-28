<?php
/*
Plugin Name: Cuberaksi - Sundara - Woocommerce custom
Plugin URI: http://cuberaksi.com
Description: Custom woo for sundaratravelclub
Version: 0.0.1
Author: Custom by Cuberaksi
Author URI: http://cuberaksi.com
*/

if (!defined('ABSPATH')) {
    exit;
}

if (!defined('CUBERAKSI_SUNDARA_BASE_NAME')) define('CUBERAKSI_SUNDARA_BASE_NAME', plugin_basename(__DIR__));
if (!defined('CUBERAKSI_SUNDARA_BASE_DIR')) define('CUBERAKSI_SUNDARA_BASE_DIR', plugin_dir_path(__FILE__));
if (!defined('CUBERAKSI_SUNDARA_BASE_URL')) define('CUBERAKSI_SUNDARA_BASE_URL', plugin_dir_url(__FILE__));

require_once CUBERAKSI_SUNDARA_BASE_DIR . "google/login-with-google.php";
require_once CUBERAKSI_SUNDARA_BASE_DIR . "woo/custom.php";
require_once CUBERAKSI_SUNDARA_BASE_DIR . "disable-cart/disable-cart-page-for-woocommerce.php";
require_once CUBERAKSI_SUNDARA_BASE_DIR . "paypal/init.php";
// require_once CUBERAKSI_SUNDARA_BASE_DIR . "klaviyo/klaviyo.php";





