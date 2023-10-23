<?php

namespace Cuberaksi\Shortcode\USD;

class Shortcode_USD
{
	static $instance;

	public function __construct()
	{
		$this->init_shortcode();
	}

	public static function get_instance()
	{

		if (null !== self::$instance) {
			return self::$instance;
		}

		self::$instance = new Shortcode_USD();
		return self::$instance;
	}

	function init_shortcode()
	{
		add_shortcode('usd_idr', [$this, 'shortcode']);
	}

	function shortcode($atts = [], $content = null, $shortcode = '')
	{
			
		require_once CUBERAKSI_XENDIT_BASE_DIR . 'woo/helper.php';

		ob_start();
		
		echo CUBERAKSI_XENDIT_USD_IDR();

		return ob_get_clean();
	}
}


$usd_idr = Shortcode_USD::get_instance();
