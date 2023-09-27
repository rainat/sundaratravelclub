<?php

namespace Cuberaksi\Shortcode\Calendar;

class Shortcode_Trip
{
	static $instance;

	public function __construct()
	{
		$this->init_shortcode();
	}

	public static function get_instance(): Shortcode_Trip
	{

		if (null !== self::$instance) {
			return self::$instance;
		}

		self::$instance = new Shortcode_Trip();
		return self::$instance;
	}

	function init_shortcode()
	{
		add_shortcode('trip_fields', [$this, 'shortcode']);
	}

	function shortcode($atts = [], $content = null, $shortcode = '')
	{
		global $post;

		// extract(shortcode_atts([
		// 	'id' => '1650'
		// ],$atts,$shortcode));

		wp_enqueue_style('shortcode_fields',CUBERAKSI_XENDIT_BASE_URL . 'woo/assets/css/style.css',[],'1c');
		
		$product = wc_get_product($post->ID);
		
		$product_meta_duration = $product->get_meta('duration_text_field');
		$product_meta_max = $product->get_meta('max_people_number_field',true);
		
		$view_logo['duration'] = true;
		$view_logo['max_people'] = true;

		if (!$product_meta_duration) { 
			$product_meta_duration = '-'; 
			$view_logo['duration'] = false;
		}
		if (!$product_meta_max) { 
			$product_meta_max = '-'; 
			$view_logo['max_people'] = false;
		}
		// exit;
		$time = CUBERAKSI_XENDIT_BASE_URL . 'woo/assets/images/time.svg';
		$user = CUBERAKSI_XENDIT_BASE_URL . 'woo/assets/images/user.svg';
		
		$is_single_page_product = false;
		$margin_zero = '';

		ob_start();
		if (function_exists('is_product')) {
			if (is_product()) {
				$is_single_page_product = true;
				$margin_zero = "m-zero";
			}	
		}
		


		echo $view_logo['duration'] ? "	
		<div id='trip-duration' class='{$margin_zero}'><img id='trip-duration-time'  src='{$time}'/><span>{$product_meta_duration}</span></div>" : "";
		echo $view_logo['max_people'] ? "<div class='{$margin_zero}' id='trip-user' ><img id='trip-duration-user' src='{$user}'/><span>{$product_meta_max} person</span></div>" : "";

		return ob_get_clean();
	}
}


$trip_fields = Shortcode_Trip::get_instance();
