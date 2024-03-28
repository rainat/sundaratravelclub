<?php
namespace Cuberaksi\WooCommerce;
trait singleton {
	static $instance = null;
	static public function get_instance() {
		if (Self::$instance === null) {
			Self::$instance = new Self();
		}

		return Self::$instance;
	}
}