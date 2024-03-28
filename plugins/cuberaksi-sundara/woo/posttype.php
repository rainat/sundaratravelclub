<?php

/**
 * Custom Addition
 **/

namespace Cuberaksi\WooCommerce;
require_once CUBERAKSI_SUNDARA_BASE_DIR . "woo/singleton.php";

class PostType {
	use singleton;

	public function __construct() {
		add_action('init', [$this, 'register_post_type']);
	}

	function register_post_type() {

		/**
		 * Post Type:
		 */

		$labels = [
			"name" => esc_html__("Product Feature", "cuberaksi-xendit"),
			"singular_name" => esc_html__("Product Feature", "cuberaksi-xendit"),
			// "add_new " => esc_html__("Add New Product Features", "cuberaksi-xendit"),
			// "add_new_item" => esc_html__("Add New Product Feature", "cuberaksi-xendit"),
			// "edit_item" => esc_html__("Edit Product Feature", "cuberaksi-xendit"),
			// "new_item" => esc_html__("Add New Product Feature", "cuberaksi-xendit"),
			// "view_item" => esc_html__("View Product Feature", "cuberaksi-xendit"),
			// "view_items" => esc_html__("View Product Features", "cuberaksi-xendit"),
			// "search_items" => esc_html__("Search Product Feature", "cuberaksi-xendit"),
			// "all_items" => esc_html__("All Product Feature", "cuberaksi-xendit"),
		];

		$args = [
			"label" => esc_html__("Product Feature", "cuberaksi-xendit"),
			"labels" => $labels,
			"description" => "Product Feature Extension Cuberaksi Woocommerce",
			"public" => true,
			"publicly_queryable" => true,
			"show_ui" => true,
			"show_in_rest" => false,
			"has_archive" => false,
			"show_in_menu" => true,
			"show_in_nav_menus" => true,
			"exclude_from_search" => true,
			"capability_type" => "post",
			"map_meta_cap" => true,
			"hierarchical" => false,
			"can_export" => true,
			"supports" => ["title", "editor"],
			"show_in_graphql" => false,
			"menu_icon" => 'dashicons-screenoptions',
			"menu_position" => 6,
		];

		register_post_type("product_features", $args);
	}
}

$post_type_instance = PostType::get_instance();