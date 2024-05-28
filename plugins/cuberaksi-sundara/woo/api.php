<?php

namespace Cuberaksi\WooCommerce;

use DateTime;

class Cuberaksi_Api
{
	static $instance;

	public static function get_instance()
	{

		if (null !== self::$instance) {
			return self::$instance;
		}

		self::$instance = new Cuberaksi_Api();
		return self::$instance;
	}

	public function __construct()
	{
		$this->init_api();
		$this->init_ajax();
	}

	function init_ajax()
	{
		add_action('wp_ajax_noprivs_user_profile', [$this, 'ajax_get_profile_nopriv']);
		add_action('wp_ajax_user_profile', [$this, 'ajax_get_profile']);
		add_action('wp_ajax_noprivs_user_profile_post', [$this, 'ajax_post_profile_noprivs']);
		add_action('wp_ajax_user_profile_post', [$this, 'user_profile_post']);
		add_action('wp_ajax_bookings', [$this, 'ajax_get_bookings']);
		add_action('wp_ajax_noprivs_bookings', [$this, 'ajax_get_bookings_nopriv']);
		add_action('wp_enqueue_scripts', function () {
			wp_localize_script('jquery', 'sundara', array('ajaxurl' => admin_url('admin-ajax.php')));
		});
	}

	function init_api()
	{

		add_action('init', function () {
			header("Access-Control-Allow-Origin: *");
		});

		add_action('rest_api_init', function () {
			register_rest_route('sundara/v1', '/bookings', array(
				'methods' => 'GET',
				'callback' => [$this, 'api_get_bookings'],
				'permission_callback' => '__return_true',
				// 'permission_callback' => function () {
				// return current_user_can('edit_others_posts');
				// }

			));
		});
	}

	function api_get_bookings()
	{
		wp_set_current_user(62);
		$this->ajax_get_bookings();
	}

	function ajax_get_bookings()
	{

		if (!is_user_logged_in()) {
			wp_send_json_error(['msg' => 'must logged in']);
		}

		global $wpdb;
		$user = wp_get_current_user();
		$userid = $user->ID;
		$status_sql = '';
		$body_request = json_decode(stripslashes($_POST['data']),true);
		$status_request = $body_request['status'];
		switch ($status_request) {
			case 'All':
				$status_sql = '';
				break;
			case 'Unpaid':
				$status_sql = "AND p.post_status = 'bk-unpaid' ";
			break;
			case 'Completed':
				$status_sql = "AND p.post_status = 'bk-completed' ";
			break;
			case 'Cancelled':
				$status_sql = "AND p.post_status = 'bk-cancelled' ";
			break;
			case 'Confirmed':
				$status_sql = "AND p.post_status = 'bk-confirmed' ";
			break;
			case 'Rejected':
				$status_sql = "AND p.post_status = 'bk-unconfirmed' ";
			break;
			default:
			$status_sql = '';
		} 
		

		$sql = $wpdb->prepare(
			"SELECT p.ID,p.post_title,p.post_type,p.post_author,p.post_status,
		(SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id=p.ID AND meta_key='_from') as _from ,
		(SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id=p.ID AND meta_key='_to') as _to,
		(SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id=p.ID AND meta_key='_persons') as persons,
		(SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id=p.ID AND meta_key='_product_id') as product_id,
		(SELECT post_status FROM {$wpdb->prefix}posts WHERE ID=product_id ) as product_status,
		(SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id=product_id AND meta_key='_thumbnail_id') as thumbnail_id,
		(SELECT guid FROM {$wpdb->prefix}posts WHERE ID=thumbnail_id) as thumbnail_src,
		(SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id=product_id AND meta_key='_price') as price
		from {$wpdb->prefix}posts p
			
		where p.post_type='yith_booking' AND p.post_author=%d {$status_sql}
		having product_status != 'trash'
		
		",
			$userid
		);

		$temp = $wpdb->get_results($sql, ARRAY_A);
		$results = [];
		if (!is_wp_error($temp)) {
			foreach ($temp as $row) {
				$section = $status_request;
				$status = '';
				if ($row['post_status'] === 'bk-completed') { 
					$section = 'Completed';
					$status = "Completed";
				}
				// if ($row['bk-paid']) {
				// 	$section = 'Completed';
				// 	// $status = 'Paid';
				// }
				if ($row['post_status'] === 'bk-unpaid') {
					$section = 'Unpaid';
					$status = 'Unpaid';
				}
				if ($row['post_status'] === 'bk-confirmed') {
					$section = 'Confirmed';
					$status = 'Confirmed';
				}
				if ($row['post_status'] === 'bk-unconfirmed') {
					$section = 'Rejected';
					$status = 'Rejected';
				}
				if ($row['post_status'] === 'bk-cancelled') {
					$section = 'Cancelled';
					$status = 'Cancelled';
				}

				//Past 
				// $comingsoon = is_commingsoon(date_create(), date_create(date('Y-m-d', $row['_to'])));
				// $comingsoon = date_create()->getTimestamp() < $row['_to'];
				// if (!$comingsoon) $section = 'Past';
				// $product = wc_get_product($row['product_id']);

				if ($row['product_status'] !== 'trash')
					$results[] = [
						'id' => $row['ID'],
						'url' => get_permalink($row['product_id']),
						'author' => $row['post_author'],
						'title' =>  $row['post_title'],
						'image' => $row['thumbnail_src'],
						'from' =>  date('d M Y', $row['_from']),
						'to' => date('d M Y', $row['_to']),
						'persons' =>  $row['persons'] ? $row['persons'] : '-',
						'price' => "$ " . number_format($row['price']),
						'section' => $status_request ,
						'status' => $status
					];
			}
			return wp_send_json($results);
		} else {
			return wp_send_json_error(['error']);
		}
	}

	function ajax_get_bookings_nopriv()
	{
		echo "You must log in";
		die();
	}

	//ajax
	function ajax_get_profile_nopriv()
	{
		echo "You must log in";
		die();
	}

	function ajax_get_profile()
	{
		if (!is_user_logged_in()) {
			wp_send_json_error(['msg' => 'must logged in']);
		}
		$user = wp_get_current_user();
		$userid = $user->ID;
		// get_user_meta($userid,$field,true);
		if (isset($_POST['updating'])) {
			$body =  json_decode(stripslashes($_POST['data']), true);
			$results = [];
			foreach ($body as $el => $value) {
				$results[] = update_user_meta($userid, $el, $value);
			}
			if (isset($_FILES['file']['tmp_name'])) {
				$results[] = $_FILES['file'];
				$upload_dir   = wp_upload_dir();
				$profile_img_dir = $upload_dir['basedir'] . '/userprofile';
				$profile_img_url = $upload_dir['baseurl'] . '/userprofile';
				if (!file_exists($profile_img_dir)) {
					wp_mkdir_p($profile_img_dir);
				}
				$tmp_name = explode('/', $_FILES['file']['tmp_name']);
				$ext = explode('/', $_FILES['file']['type']);
				$ext = $ext[count($ext) - 1];
				$filename = '/' . $userid . '-' . $tmp_name[count($tmp_name) - 1] . $ext;
				move_uploaded_file($_FILES['file']['tmp_name'], $profile_img_dir . $filename);

				update_user_meta($userid, 'profile_photo', $profile_img_url . $filename);
			}


			// $results[] = $body;

			wp_send_json($results, 200);
		} else {
			$data = [
				'first_name' =>  get_user_meta($userid, 'first_name', true),
				'last_name' =>  get_user_meta($userid, 'last_name', true),
				'billing_country' =>  get_user_meta($userid, 'billing_country', true),
				'billing_phone' => get_user_meta($userid, 'billing_phone', true),
				'billing_city' => get_user_meta($userid, 'billing_city', true),
				'billing_email' =>  get_user_meta($userid, 'billing_email', true),
				'billing_address_1' => get_user_meta($userid, 'billing_address_1', true),
				'profile_photo' => get_user_meta($userid, 'profile_photo', true),
			];

			wp_send_json($data, 200);
		}
	}

	function user_profile_post_noprivs()
	{
		echo "You must log in";
		die();
	}
	function user_profile_post()
	{

		if (!is_user_logged_in()) {
			wp_send_json_error(['msg' => 'must logged in']);
		}
		$user = wp_get_current_user();
		$userid = $user->ID;
		$results = [];
		// get_user_meta($userid,$field,true);
		if (isset($_POST['updating'])) {
			$body =  json_decode(stripslashes($_POST['data']), true);

			foreach ($body as $el => $value) {
				$results[] = update_user_meta($userid, $el, $value);
			}



			if (isset($_FILES['file']['tmp_name'])) {

				$upload_dir   = wp_upload_dir();
				$profile_img_dir = $upload_dir['basedir'] . '/userprofile';
				$profile_img_url = $upload_dir['baseurl'] . '/userprofile';
				if (!file_exists($profile_img_dir)) {
					wp_mkdir_p($profile_img_dir);
				}

				$filename = '/' . $userid . '-' . $_FILES['file']['name'];
				$results[] = move_uploaded_file($_FILES['file']['tmp_name'], $profile_img_dir . $filename);

				$results[] = update_user_meta($userid, 'profile_photo', $profile_img_url . $filename);
			}


			$results[] = $_FILES['file'];

			wp_send_json($results, 200);
		}
	}
}

Cuberaksi_Api::get_instance();
