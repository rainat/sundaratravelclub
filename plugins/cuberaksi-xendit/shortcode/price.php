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
		$thumbnail ='';
		if ($product) {
			$price = $product->get_price_html();
			$img_url = wp_get_attachment_image_url($product->get_image_id());
			$thumbnail = "<img src='$img_url' width='30'/>";
		}
		
		
		ob_start();
		?><style>.flex{display: flex;flex-direction: row; gap:1rem;align-items: center; }</style>
		<?php echo "<div id='price-bottom' class='flex gap-4' style='text-align:center'>{$thumbnail}{$price}</div>		
		";

		return ob_get_clean();
	}
}


$trip_price = Shortcode_Price::get_instance();
