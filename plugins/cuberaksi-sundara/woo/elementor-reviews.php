<?php

// require_once "elementor-reviewbase.php";

class Cuberaksi_Reviews extends \ElementorPro\Modules\Carousel\Widgets\Reviews {

	public function get_name() {
		return 'reviews_cuber';
	}

	public function get_title() {
		return esc_html__( 'Reviews cuberaksi', 'elementor-pro' );
	}

	public function get_icon() {
		return 'eicon-review';
	}

	public function get_keywords() {
		return [ 'reviews', 'social', 'rating', 'testimonial', 'carousel' ];
	}

	public function get_group_name() {
		return 'carousel';
	}
}
