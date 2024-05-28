<?php

/**
 * Elementor Dynamic Tag - ACF duration
 *
 * Elementor dynamic tag that returns an ACF duration.
 *
 * @since 1.0.0 extends \Elementor\Core\DynamicTags\Tag
 */
class Elementor_Dynamic_Tag_ACF_Duration extends \Elementor\Core\DynamicTags\Tag
{

	/**
	 * Get dynamic tag name.
	 *
	 * Retrieve the name of the ACF duration tag.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Dynamic tag name.
	 */
	public function get_name()
	{
		return 'acf-duration';
	}

	/**
	 * Get dynamic tag title.
	 *
	 * Returns the title of the ACF duration tag.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Dynamic tag title.
	 */
	public function get_title()
	{
		return esc_html__('ACF Duration', 'elementor-acf-duration-dynamic-tag');
	}

	/**
	 * Get dynamic tag groups.
	 *
	 * Retrieve the list of groups the ACF duration tag belongs to.
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
	 * Retrieve the list of categories the ACF duration tag belongs to.
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
	 * Add input fields to allow the user to customize the ACF duration tag settings.
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
				'label' => esc_html__('Fields', 'elementor-acf-duration-dynamic-tag'),
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

		// foreach (explode(',', $fields) as $index => $field_name) {
		// 	$field = get_field($field_name);
		// 	if ((int) $field > 0) {
		// 		$sum += (int) $field;
		// 		$count++;
		// 	}
		// }

		// if (0 !== $count) {
		// 	$value = $sum / $count;
		// }

		$value = '';

		$arr = explode('|', get_field('duration_trip'));
		if (count($arr) == 2) {
			$days = $arr[0];
			$nights = $arr[1];

			if ($fields == 'day') {
				$value = strtoupper($days);
			}

			if ($fields == 'night') {
				$value = strtoupper($nights);
			}
		}




		echo $value;
	}
}
