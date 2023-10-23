<?php

/**
 * Plugin Name:          Sg Order Approval for Woocommerce
 * Plugin URI:           https://wordpress.org/plugins/order-approval-woocommerce/
 * Description:          WooCommerce Order Approval plugin allowing shop owners to approve or reject all the orders placed by customers before payment processed.
 * Version:              2.0.13
 * Author:               Sevengits
 * Author URI:           https://sevengits.com/
 * License:              GPL-2.0+
 * License URI:          http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:          order-approval-woocommerce
 * Domain Path:          /languages
 * WC requires at least: 3.7
 * WC tested up to:      7.5
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
if (!defined('SG_ORDER_APPROVAL_WOOCOMMERCE_PRO_VERSION'))
	define('SG_ORDER_APPROVAL_WOOCOMMERCE_PRO_VERSION', '2.0.13');

if (!defined('SG_BASE_ORDER'))
	define('SG_BASE_ORDER', plugin_basename(__FILE__));

if (!defined('SG_PLUGIN_PATH_ORDER'))
	define('SG_PLUGIN_PATH_ORDER', plugin_dir_path(__FILE__));


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-sg-order-approval-woocommerce-pro-activator.php
 */
function activate_sg_order_approval_woocommerce_pro()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-sg-order-approval-woocommerce-pro-activator.php';
	Sg_Order_Approval_Woocommerce_Pro_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-sg-order-approval-woocommerce-pro-deactivator.php
 */
function deactivate_sg_order_approval_woocommerce_pro()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-sg-order-approval-woocommerce-pro-deactivator.php';
	Sg_Order_Approval_Woocommerce_Pro_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_sg_order_approval_woocommerce_pro');
register_deactivation_hook(__FILE__, 'deactivate_sg_order_approval_woocommerce_pro');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-sg-order-approval-woocommerce-pro.php';
/**
 * Plugin Deactivation Survey
 */
require plugin_dir_path(__FILE__) . 'plugin-deactivation-survey/deactivate-feedback-form.php';
/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_sg_order_approval_woocommerce_pro()
{

	$plugin = new Sg_Order_Approval_Woocommerce_Pro();
	$plugin->run();
}
run_sg_order_approval_woocommerce_pro();

add_filter('sgits_deactivate_feedback_form_plugins', function ($plugins) {
	$plugins[] = (object)array(
		'slug'		=> 'order-approval-woocommerce',
		'version'	=> SG_ORDER_APPROVAL_WOOCOMMERCE_PRO_VERSION
	);
	return $plugins;
});
