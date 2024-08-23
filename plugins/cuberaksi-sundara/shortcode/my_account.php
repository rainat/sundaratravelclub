<?php

namespace Cuberaksi\Shortcode;

use Kucrut\Vite;

class Shortcode_My_Account
{
    public static $instance;

    public function __construct()
    {
        $this->init_shortcode();
    }

    public static function get_instance(): Shortcode_My_Account
    {
        if (null !== self::$instance) {
            return self::$instance;
        }

        self::$instance = new Shortcode_My_Account();

        return self::$instance;
    }

    public function init_shortcode()
    {
        add_shortcode('my_account_page', [$this, 'shortcode']);
        // add_shortcode('taxes', [$this, 'shortcode_taxes']);
    }

    public function shortcode($atts = [], $content = null, $shortcode = '')
    {
        // 	$vite_dev = false;
        // 	if (is_vite_dev()) {
        // 		$vite_dev = true;
        // 		render_vite_dev_assets();
        // 	} else {
        wp_enqueue_style('accpage-css', CUBERAKSI_SUNDARA_BASE_URL.'woo/templates/myaccount/dist/main.css', [], time());
        wp_enqueue_script_module('accpage-js', CUBERAKSI_SUNDARA_BASE_URL.'woo/templates/myaccount/dist/index.js', [], time(), true);
        $logout = '?logoutme=yes';
        echo "<script>myaccountobj = { url_logout: '$logout', resetpassword: '/resetpass' } </script>";
        // Vite\enqueue_asset(
        // 	CUBERAKSI_SUNDARA_BASE_DIR . "woo/templates/myaccount/dist",
        // 	'src/main.tsx',
        // 	[
        // 		'dependencies' => ['react', 'react-dom'],
        // 		'handle' => 'vite-for-wp-react',
        // 		'in-footer' => true,
        // 	]
        // );

        // }

        ob_start();

        echo "<div id='myaccountpage'></div>";

        // if ($vite_dev) {
        // 	printf('<script type="module" src="%s/src/main.tsx"></script>', CUBERAKSI_SUNDARA_BASE_URL . "woo/templates/myaccount/react");
        // }

        return ob_get_clean();
        // return '';
    }
}

Shortcode_My_Account::get_instance();
