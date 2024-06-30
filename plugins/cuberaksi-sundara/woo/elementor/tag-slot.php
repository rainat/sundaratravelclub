<?php

/**
 * Elementor Dynamic Tag - ACF Slot
 *
 * Elementor dynamic tag that returns an ACF Slot.
 *
 * @since 1.0.0 extends \Elementor\Core\DynamicTags\Tag
 */
class Elementor_Dynamic_Tag_ACF_Slot extends \Elementor\Core\DynamicTags\Tag
{

	/**
	 * Get dynamic tag name.
	 *
	 * Retrieve the name of the ACF slot tag.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Dynamic tag name.
	 */
	public function get_name()
	{
		return 'acf-slot';
	}

	/**
	 * Get dynamic tag title.
	 *
	 * Returns the title of the ACF slot tag.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Dynamic tag title.
	 */
	public function get_title()
	{
		return esc_html__('ACF Slot', 'elementor-acf-slot-dynamic-tag');
	}

	/**
	 * Get dynamic tag groups.
	 *
	 * Retrieve the list of groups the ACF slot tag belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Dynamic tag groups.
	 */
	public function get_group()
	{
		return ['cuberaksi'];
	}

	/**
	 * Get dynamic tag categories.
	 *
	 * Retrieve the list of categories the ACF slot tag belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Dynamic tag categories.
	 */
	public function get_categories()
	{
		return [\Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY];
	}

	/**
	 * Register dynamic tag controls.
	 *
	 * Add input fields to allow the user to customize the ACF slot tag settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @return void
	 */
	protected function register_controls()
	{
		$this->add_control(
			'fields',
			[
				'label' => esc_html__('Fields', 'elementor-acf-slot-dynamic-tag'),
				'type' => 'text',
			]
		);
	}

	/**
	 * Render tag output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function render()
	{
		$fields = $this->get_settings('fields');
		// $sum = 0;
		// $count = 0;
		// $value = 0;

		// Make sure that ACF if installed and activated
		if (!function_exists('get_field')) {
			echo 0;
			return;
		}



		// if (0 !== $count) {
		// 	$value = $sum / $count;
		// }

		//$value = '';
		//$sold_out = get_field('sold_out_admin');

		// if ($sold_out) {
		// 	echo "0 Slots Remain";
		// }	

		// global $wpdb;
		// global $post;

		// $sql = $wpdb->prepare(
		// 	"SELECT p.ID,p.post_title,p.post_type,p.post_author,p.post_status,
		// (SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id=p.ID AND meta_key='_from') as _from ,
		// (SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id=p.ID AND meta_key='_to') as _to,
		// (SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id=p.ID AND meta_key='_persons') as persons,
		// (SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id=p.ID AND meta_key='_product_id') as product_id,
		// (SELECT post_status FROM {$wpdb->prefix}posts WHERE ID=product_id ) as product_status,
		// (SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id=product_id AND meta_key='_thumbnail_id') as thumbnail_id,
		// (SELECT guid FROM {$wpdb->prefix}posts WHERE ID=thumbnail_id) as thumbnail_src,
		// (SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id=product_id AND meta_key='_price') as price
		// from {$wpdb->prefix}posts p

		// where p.post_type='yith_booking' AND product_id=%d AND p.post_status = 'bk-completed'
		// having product_status != 'trash'

		// ",
		// 	$post->ID
		// );

		// $temp = $wpdb->get_results($sql, ARRAY_A);
		// $results = [];
		// if (!is_wp_error($temp)) {
		// }


		// if ($fields == 'title') {

		// 	$notyet = false;

		// 	if ($temp) {
		// 		$exp = explode('.', $temp);
		// 		$date1 = date_create("{$exp[2]}-{$exp[1]}-{$exp[0]}");
		// 		$date2 = date_create();

		// 		// $diff = date_diff($date1, $date2);
		// 		// $invert = $diff->invert;
		// 		// $between = $invert ? -$diff->days : $diff->days;

		// 		// if ($between >= 0) $notyet = false;
		// 		// if ($between < 0) $notyet = true;

		// 		$notyet = is_commingsoon($date1, $date2);
		// 	}

		// 	if ($notyet)
		// 		$value = 'COMING SOON';
		// }

		// if ($fields == 'date') {
		// 	$value = $temp;
		// 	if ($temp) {
		// 		$exp = explode('.', $temp);
		// 		$date1 = date_create("{$exp[2]}-{$exp[1]}-{$exp[0]}");
		// 		$date2 = date_create();

		// 		if (!is_commingsoon($date1, $date2)) $value = '';
		// 	}
		// }



		$value = '';
		$sold_out = get_field('_sold_out_admin');
		$slot_count = get_field('_slot_count');

		if ($sold_out == 'On') $value = "SOLD OUT";
		else {

			if (!$slot_count && $slot_count != '0') $value = "∞";
			else $value = $slot_count;
		}


		if ($fields == 'desc') {
			if ($value != 'SOLD OUT') $value = 'SLOTS LEFT'; else $value = '';
		} else {
			if ($value == 'SOLD OUT') $value = 'SOLD OUT';
		}

		if ($fields == 'sold-out-class'){
			$value = $sold_out == 'On' ?  'slots-box slot-sold-out-on' : 'slots-box';
		}



		echo $value;
	}
}
