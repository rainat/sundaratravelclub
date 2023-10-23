<?php

namespace Cuberaksi\WooCommerce;

class Cuberaksi_Woo_Approval_Admin
{
	static $instance;

	public function __construct()
	{
		$this->init();
	}

	public static function get_instance(): Cuberaksi_Woo_Approval_Admin
	{

		if (null !== self::$instance) {
			return self::$instance;
		}

		self::$instance = new Cuberaksi_Woo_Approval_Admin();
		return self::$instance;
	}

	function init()
	{
		add_action('init', [$this, 'register_custom_order_status']);
		add_action('woocommerce_new_order', [$this, 'change_order_status_to_pending_approval']);
	}

	// Register a custom order status
	function register_custom_order_status()
	{
		register_post_status('wc-pending-admin-approval', array(
			'label'                     => 'Pending Admin Approval',
			'public'                    => true,
			'exclude_from_search'       => false,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'label_count'               => _n_noop('Pending Admin Approval <span class="count">(%s)</span>', 'Pending Admin Approval <span class="count">(%s)</span>'),
		));
	}

	// Change order status to "Pending Admin Approval" when the order is created.
	function change_order_status_to_pending_approval($order_id)
	{
		$order = wc_get_order($order_id);
		$new_status = 'wc-pending-admin-approval'; // Custom status slug
		$order->set_status($new_status);
		$order->save();
	}
}

// $approval_0989 = Cuberaksi_Woo_Approval_Admin::get_instance();
