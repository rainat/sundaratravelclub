<?php

namespace Cuberaksi\Shortcode\Booking;

class Shortcode_Booking
{
	static $instance;

	public function __construct()
	{
		$this->init_shortcode();
	}

	public static function get_instance(): Shortcode_Booking
	{

		if (null !== self::$instance) {
			return self::$instance;
		}

		self::$instance = new Shortcode_Booking();
		return self::$instance;
	}

	function init_shortcode()
	{
		add_shortcode('amelia_step_book', [$this, 'shortcode']);
	}

	function shortcode($atts = [], $content = null, $shortcode = '')
	{
		global $post;
		$meta = get_post_meta($post->ID,'_amelia_cuberaksi',true);
		
		ob_start();
		
		if ($meta) { 
			// echo $service;
			$service = json_decode($meta,true)['service_id'];
			echo "[ameliastepbooking service=$service]"; 
			
		} else echo 'No service available..';

		
		
		return ob_get_clean();
	}
}


$bookings = new Shortcode_Booking();
// Shortcode_Booking::get_instance();
