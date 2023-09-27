<?php

namespace Cuberaksi\Shortcode\Calendar;

class Shortcode_Price
{
	static $instance;

	public function __construct()
	{
		$this->init_shortcode();
	}

	public static function get_instance(): Shortcode_Price
	{

		if (null !== self::$instance) {
			return self::$instance;
		}

		self::$instance = new Shortcode_Price();
		return self::$instance;
	}

	function init_shortcode()
	{
		add_shortcode('product_price', [$this, 'shortcode']);
	}

	function shortcode($atts = [], $content = null, $shortcode = '')
	{
		global $post;

		// extract(shortcode_atts([
		// 	'id' => '1650'
		// ],$atts,$shortcode));

		
		$product = wc_get_product($post->ID);
		$price='';
		if ($product) $price = $product->get_price_html();
		
		
		ob_start();
		
		echo "<div style='text-align:center'>{$price}</div>		
		";

		return ob_get_clean();
	}
}


$trip_price = Shortcode_Price::get_instance();
