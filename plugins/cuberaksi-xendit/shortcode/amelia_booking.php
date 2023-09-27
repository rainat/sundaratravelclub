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
		add_shortcode('amelia_bookings', [$this, 'shortcode']);
	}

	function shortcode($atts = [], $content = null, $shortcode = '')
	{
		// wp_enqueue_style('w3css', CUBERAKSI_XENDIT_BASE_URL . 'woo/assets/w3.css');
		wp_enqueue_script('ameliapopup', CUBERAKSI_XENDIT_BASE_URL . 'woo/assets/js/dialog.js', ['jquery']);
		// do_shortcode('[ameliastepbooking]')
		ob_start();
?>
		<style>
			#id-booking-popup{
				display:none;
				position: fixed;
				top:0;
				margin:20px;
				width:100%;
				z-index: 9999;
			}
			</style>
		<div id="id-booking-popup" class="w3-modal">
				<span onclick="document.getElementById('id-booking-popup').style.display='none'">&times;</span>
					<?php echo do_shortcode('[ameliastepbooking]'); ?>
				
			
		</div>
<?php

		return ob_get_clean();
	}
}


$bookings = Shortcode_Booking::get_instance();
