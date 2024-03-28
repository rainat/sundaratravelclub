<?php

namespace Cuberaksi\Shortcode\Booking;

class Shortcode_YITH_Booking_Form
{
	static $instance;

	public function __construct()
	{
		$this->init_shortcode();
	}

	public static function get_instance(): Shortcode_YITH_Booking_Form
	{

		if (null !== self::$instance) {
			return self::$instance;
		}

		self::$instance = new Shortcode_YITH_Booking_Form();
		return self::$instance;
	}

	function init_shortcode()
	{
		add_shortcode('yith_booking_form', [$this, 'shortcode']);
	}

	function shortcode($atts = [], $content = null, $shortcode = '')
	{
		extract( shortcode_atts(
			array(
				'type'   => 'YITH_WCBK_Product_Form_Widget'
			),
			$atts
		));

		


		global $wp_widget_factory;

		$widget_name = 'YITH_WCBK_Product_Form_Widget';
		
		if (class_exists( $widget_name ))
		{
			// register_widget( $widget_name);
		} 
				
		$args = array( //optional markup:
					'before_widget' => '<div class="">',
					'after_widget'  => '</div>',
					'before_title'  => '<div class="widget-title">',
					'after_title'   => '</div>',
		);
		

		
		// if (!is_a($wp_widget_factory->widgets[$widget_name], 'WP_Widget')):
		// 	$wp_class = 'YITH_WCBK_Product_Form_Widget';
			
		// 	if (!is_a($wp_widget_factory->widgets[$wp_class], 'WP_Widget')):
		// 		return '<p>'.sprintf(__("%s: Widget class not found. Make sure this widget exists and the class name is correct"),'<strong>'.$class.'</strong>').'</p>';
		// 	else:
		// 		$class = $wp_class;
		// 	endif;
		// endif;
		
		ob_start();
		
		// if (is_object($wp_widget_factory->widgets['YITH_WCBK_Product_Form_Widget'])) {
		// 	$wp_widget_factory->widgets['YITH_WCBK_Product_Form_Widget']->widget(array( //optional markup:
		// 		'before_widget' => '<div class="">',
		// 		'after_widget'  => '</div>',
		// 		'before_title'  => '<div class="widget-title">',
		// 		'after_title'   => '</div>',
		// 	),[]);
		// }

		the_widget('YITH_WCBK_Product_Form_Widget',[],$args);
		
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
}


$bookings = Shortcode_YITH_Booking_Form::get_instance();
// Shortcode_Booking::get_instance();
