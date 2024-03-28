<?php

namespace Cuberaksi\Shortcode\ProductFeature;

class Shortcode_ProductFeature
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

		self::$instance = new Shortcode_ProductFeature();
		return self::$instance;
	}

	function init_shortcode()
	{
		add_shortcode('product_feature', [$this, 'shortcode']);
		add_shortcode('custom_yith_booking_form', [$this, 'custom_yith_booking_form']);
	}

	function custom_yith_booking_form($atts = [], $content = null, $shortcode = '')
	{
		global $post;
		$product_id = $post->ID;
		ob_start();

		if (function_exists('is_product')) {
			if (is_product()) {
?>
				
				

<?php
			}
		}

		return ob_get_clean();
	}

	function shortcode($atts = [], $content = null, $shortcode = '')
	{
		global $post;

		ob_start();
		$posts = get_posts(array(
			'posts_per_page'    => -1,
			'post_type'     => 'product_features',
			'meta_key'      => 'feature_product_id',
			'meta_value'    => $post->ID
		));

		if (function_exists('is_product')) {
			if (is_product()) {
				if ($posts) {
					$feature_id = $posts[0]->ID;
					echo do_shortcode("[elementor-template id='$feature_id']");
				}
			}
		}

		return ob_get_clean();
	}
}

$product_feature = Shortcode_ProductFeature::get_instance();
