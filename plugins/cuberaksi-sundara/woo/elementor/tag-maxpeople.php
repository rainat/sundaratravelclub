<?php

/**
 * Elementor Dynamic Tag - ACF maxpeople
 *
 * Elementor dynamic tag that returns an ACF maximum people.
 *
 * @since 1.0.0 extends \Elementor\Core\DynamicTags\Tag
 */
class Elementor_Dynamic_Tag_ACF_Maxpeople extends \Elementor\Core\DynamicTags\Tag
{

	/**
	 * Get dynamic tag name.
	 *
	 * Retrieve the name of the ACF maxpeople tag.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Dynamic tag name.
	 */
	public function get_name()
	{
		return 'acf-maxpeople';
	}

	/**
	 * Get dynamic tag title.
	 *
	 * Returns the title of the ACF maxpeople tag.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Dynamic tag title.
	 */
	public function get_title()
	{
		return esc_html__('ACF Maximum People', 'elementor-acf-maxpeople-dynamic-tag');
	}

	/**
	 * Get dynamic tag groups.
	 *
	 * Retrieve the list of groups the ACF maxpeople tag belongs to.
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
	 * Retrieve the list of categories the ACF maxpeople tag belongs to.
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
	 * Add input fields to allow the user to customize the ACF maxpeople tag settings.
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
				'label' => esc_html__('Fields', 'elementor-acf-maxpeople-dynamic-tag'),
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

		$value = get_field('max_people');
		$infinitesvg = CUBERAKSI_SUNDARA_BASE_URL . "woo/assets/images/infinite.svg";
		if (!$value)
			$value = "∞";


		echo $value;
	}
}
