<?php

namespace Cuberaksi\Shortcode\Map;

class Shortcode_Map
{
	static $instance;

	public function __construct()
	{
		$this->init_shortcode();
	}

	public static function get_instance(): Shortcode_Map
	{

		if (null !== self::$instance) {
			return self::$instance;
		}

		self::$instance = new Shortcode_Map();
		return self::$instance;
	}

	function init_shortcode()
	{
		add_shortcode('map_embed', [$this, 'shortcode']);
	}

	function shortcode($atts = [], $content = null, $shortcode = '')
	{
		global $post;

		// extract(shortcode_atts([
		// 	'id' => '1650'
		// ],$atts,$shortcode));

		
		$map = get_field('map',$post->ID,false);
		$location = get_field('location',$post->ID,false);
			
		
		ob_start();
		
		if ( $location)	
			echo "<h2><span style='font-weight:400;'>Location</span></h2><p><span>$location</span></p><br>";
		if ($map)
			echo $map;

		return ob_get_clean();
	}
}


$embed_map = Shortcode_Map::get_instance();
