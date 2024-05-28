<?php

// namespace Cuberaksi\WooCommerce;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
/**
 * synamic tags
 **/

// add_filter('acf/load_field/name=duration_trip', function ($field) {});

// if (!did_action('elementor/loaded')) {


// 	return;
// }

//\Elementor\Core\DynamicTags\
// use \Elementor\Core\DynamicTags\Tag;
// require 'singleton.php';

class Cuberaksi_Register_Dynamic_Tags
{
	// use singleton;
	static $instance = null;
	static public function get_instance()
	{
		if (Self::$instance === null) {
			Self::$instance = new Self();
		}

		return Self::$instance;
	}

	function __construct()
	{
		$this->init();
	}


	/**
	 * Register New Dynamic Tag Group.
	 *
	 * Register new site group for site-related tags.
	 *
	 * @since 1.0.0
	 * @param \Elementor\Core\DynamicTags\Manager $dynamic_tags_manager Elementor dynamic tags manager.
	 * @return void
	 */
	function register_site_dynamic_tag_group($dynamic_tags_manager)
	{

		$dynamic_tags_manager->register_group(
			'cuberaksi',
			[
				'title' => esc_html__('Cuberaksi', 'elementor-acf-duration-dynamic-tag')
			]
		);
	}

	/**
	 * Register ACF duration Dynamic Tag.
	 *
	 * Include dynamic tag file and register tag class.
	 *
	 * @since 1.0.0
	 * @param \Elementor\Core\DynamicTags\Manager $dynamic_tags_manager Elementor dynamic tags manager.
	 * @return void
	 */
	function register_acf_duration_dynamic_tag($dynamic_tags_manager)
	{
		require_once "elementor/tag-duration.php";
		require_once "elementor/tag-comingsoon.php";
		require_once "elementor/tag-maxpeople.php";
		$dynamic_tags_manager->register(new Elementor_Dynamic_Tag_ACF_Duration);
		$dynamic_tags_manager->register(new Elementor_Dynamic_Tag_ACF_Comingsoon);
		$dynamic_tags_manager->register(new Elementor_Dynamic_Tag_ACF_Maxpeople);
	}

	function init()
	{

		add_action('plugins_loaded', function () {
			add_action('elementor/dynamic_tags/register', [$this, 'register_site_dynamic_tag_group']);
			add_action('elementor/dynamic_tags/register', [$this, 'register_acf_duration_dynamic_tag']);
		});
	}
}



Cuberaksi_Register_Dynamic_Tags::get_instance();
