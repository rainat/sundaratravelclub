<?php

namespace Cuberaksi\Shortcode\Calendar;

class Shortcode_GCalendar
{
	static $instance;

	public function __construct()
	{
		$this->init_shortcode();
	}

	public static function get_instance(): Shortcode_GCalendar
	{

		if (null !== self::$instance) {
			return self::$instance;
		}

		self::$instance = new Shortcode_GCalendar();
		return self::$instance;
	}

	function init_shortcode()
	{
		add_shortcode('google-calendar', [$this, 'shortcode']);
	}

	function shortcode($atts = [], $content = null, $shortcode = '')
	{
		extract(shortcode_atts([
			'id' => '1650'
		],$atts,$shortcode));

		
		
		$product = wc_get_product($id);

		$datetime = new \DateTime($product->get_date_modified());
		$timezone = new \DateTimeZone('Asia/Jakarta');
		$datetime->setTimezone($timezone);
		
		$product_data = $product->get_data();

		$text = $product->get_title();
		$details = $product->get_short_description();
		$location = 'Bali';


		// echo '<pre>'. print_r( $product_data, true ) . '</pre>';

		// exit;

		$data = array(
			'dates' => $datetime->format('Z'),
			'details' => $details,
			'location' => $location,
			'text' => $text
		);

		ob_start();
		echo "	
		<a rel='noopener' target='_blank' href='https://calendar.google.com/calendar/render?action=TEMPLATE&dates={$data['dates']}&details={$data['details']}&location={$data['location']}&text={$data['text']}' class='cta btn-yellow' style='background-color: #F4D66C; font-size: 18px; font-family: Helvetica, Arial, sans-serif; font-weight:bold; text-decoration: none; padding: 14px 20px; color: #1D2025; border-radius: 5px; display:inline-block; mso-padding-alt:0; box-shadow:0 3px 6px rgba(0,0,0,.2);'><span style='mso-text-raise:15pt;'>Add to your Google Calendar</span></a>			
		";

		return ob_get_clean();
	}
}


$gcal = Shortcode_GCalendar::get_instance();
