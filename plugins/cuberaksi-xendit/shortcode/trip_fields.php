<?php

namespace Cuberaksi\Shortcode\Tripfields;

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

		wp_enqueue_style('shortcode_fields',CUBERAKSI_XENDIT_BASE_URL . 'woo/assets/css/style.css',[],time());
		
		$product = wc_get_product($post->ID);
		
		$product_meta_duration = $product ?  \get_field('duration_trip') : false;
		$product_meta_max = $product ? \get_field('max_people') : false;
		$product_price = $product ? $product->get_price_html() : false;
		
		$view_logo['duration'] = true;
		$view_logo['max_people'] = true;
		$view_logo['price'] = true;

		if (!$product_meta_duration) { 
			$product_meta_duration = '-'; 
			$view_logo['duration'] = false;
		}
		if (!$product_meta_max) { 
			$product_meta_max = '-'; 
			$view_logo['max_people'] = false;
		}

		if (!$product_price)  {
			$view_logo['price'] = false;
			$product_price = '';
		}

		if (is_product()) {
			$view_logo['price'] = false;
			$product_price = '';
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
		<div id='trip-duration' class='{$margin_zero}'><img class='lazy' id='trip-duration-time'  data-src='{$time}'/><span>{$product_meta_duration}</span></div>" : "";
		echo $view_logo['max_people'] ? "<div class='{$margin_zero}' id='trip-user' ><img class='lazy' id='trip-duration-user' data-src='{$user}'/><span>{$product_meta_max} person</span></div>" : "";
		echo $view_logo['price'] ? "<div class='sc-product-price'>$product_price</div>" : "";

		return ob_get_clean();
	}
}


$trip_fields = Shortcode_Trip::get_instance();
