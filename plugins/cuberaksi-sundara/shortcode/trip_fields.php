<?php

namespace Cuberaksi\Shortcode\Tripfields;

class Shortcode_Trip
{
	static $instance;

	public function __construct()
	{
		$this->init_shortcode();
	}

	public static function get_instance(): Shortcode_Trip
	{

		if (null !== self::$instance) {
			return self::$instance;
		}

		self::$instance = new Shortcode_Trip();
		return self::$instance;
	}

	function init_shortcode()
	{
		add_shortcode('trip_fields', [$this, 'shortcode']);
		add_shortcode('product_tooltip', [$this, 'shortcode_product_tooltip']);
		add_shortcode('cuber_timelines', [$this, 'shortcode_cuber_timeline']);
		add_shortcode('cuber_summary_timelines', [$this, 'shortcode_cuber_summary_timeline']);
	}

	function shortcode_product_tooltip($atts = [], $content = null, $shortcode = '')
	{
		global $post;
		$product = wc_get_product($post->ID);
		$product_tool_tip = $product ?  \get_field('product_tool_tip') : false;
		$json = json_encode(['msg' => $product_tool_tip]);
		ob_start();
		echo "<span productid='{$post->ID}' tip='$json'></span>";
		return ob_get_clean();
	}

	function shortcode_cuber_timeline($atts = [], $content = null, $shortcode = '')
	{

		function render_day_content($content, $index)
		{
			
			echo "<div class='container right'>
		        <div class='day-title'>Day $index</div>
		        <div class='content'>
		          $content          
		        </div>
		      </div>";
		}

		global $post;
		$product_id = $post->ID;
		$days = [];
		for ($i = 1; $i <= 12; $i++) {
			$days[] = get_field("day_$i", $product_id);
		}

		ob_start();
		echo "<div class='timeline onest-font-400' data-gol='itenary'>";
		$count = 1;
		foreach ($days as $day) {
			if ($day) render_day_content($day, $count);
			$count++;
		}


		echo '</div>';

		return ob_get_clean();
	}

	function shortcode_cuber_summary_timeline($atts = [], $content = null, $shortcode = '')
	{

		function render_container_info($data)
		{
			return
				"<div class='ht-addinfo'>
    <div class='ht-addinfo__col ht-addinfo__img'><img src='{$data['icon']}' width='20'></div> <div class='ht-addinfo__col ht-addinfo__desc'>
        <p class='ht-addinfo__title'>{$data['description']}</p><p class='ht-addinfo__text'></p>
</div></div>";
		}

		function render_day_content_summary($content, $index)
		{
			// print_r($content);
			$lists = '';
			foreach ($content['content'] as $list) {
				$lists = $lists . render_container_info($list);
			}

			echo "<div class='container right'>
		        <div class='day-title'>Day $index</div>
		        <div class='content'>
		          $lists
		        </div>
		      </div>";
		}

		global $post;

		$posts = get_posts(array(
			'posts_per_page'    => -1,
			'post_type'     => 'product_summary',
			'meta_key'      => 'product',
			'meta_value'    => $post->ID
		));

		$days = [];
		$summary_id = '';
		if (function_exists('is_product')) {
			if (is_product()) {
				if ($posts) {
					$summary_id = $posts[0]->ID;
					$days = get_field("day", $summary_id);
				}
			}
		}



		ob_start();
		echo "<div class='timeline onest-font-400' data-gol='summary'>";
		$count = 1;
		foreach ($days as $day) {
			if ($day) render_day_content_summary($day, $count);
			$count++;
		}


		echo '</div>';

		return ob_get_clean();
	}

	function shortcode($atts = [], $content = null, $shortcode = '')
	{
		global $post;

		// extract(shortcode_atts([
		// 	'id' => '1650'
		// ],$atts,$shortcode));

		// wp_enqueue_style('shortcode_fields', CUBERAKSI_SUNDARA_BASE_URL . 'woo/assets/css/style.css', [], time());

		$product = wc_get_product($post->ID);

		$product_meta_duration = $product ?  \get_field('duration_trip') : false;
		$product_meta_max = $product ? \get_field('max_people') : false;
		$product_price = $product ? $product->get_price_html() : false;
		$product_info =  $product ? \get_field('info') : false;
		$product_pdf = $product ? \get_field('pdf_download', $post->ID) : false;
		$product_quoted = $product ? \get_field('product_quote', $post->ID) : false;
		$meeting_point = $product ? \get_field('meeting_point', $post->ID) : false;

		$view_logo['duration'] = true;
		$view_logo['max_people'] = true;
		$view_logo['price'] = true;
		$view_logo['info'] = true;
		$view_logo['pdf_download'] = true;
		$view_logo['product_quoted'] = true;
		$view_logo['meeting_point'] = true;

		if (!$product_meta_duration) {
			$product_meta_duration = '-';
			$view_logo['duration'] = false;
		}
		if (!$product_meta_max) {
			$product_meta_max = '-';
			$view_logo['max_people'] = false;
		}
		if (!$product_info) {
			$product_info = '';
			$view_logo['info'] = false;
		}

		if (!$product_price) {
			$view_logo['price'] = false;
			$product_price = '';
		}

		if ((!$product_pdf) || (!is_single())) {
			$view_logo['pdf_download'] = false;
		}

		if ((!$product_quoted) || (!is_single())) {
			$view_logo['product_quoted'] = false;
		}

		if ((!$meeting_point)) {
			$view_logo['meeting_point'] = false;
		}

		if (is_product()) {
			$view_logo['price'] = false;
			$product_price = '';
		}
		// exit;
		$time = CUBERAKSI_SUNDARA_BASE_URL . 'woo/assets/images/time.svg';
		$user = CUBERAKSI_SUNDARA_BASE_URL . 'woo/assets/images/user.svg';
		$info = CUBERAKSI_SUNDARA_BASE_URL . 'woo/assets/images/calendar.svg';

		$is_single_page_product = false;
		$margin_zero = '';

		ob_start();
		if (function_exists('is_product')) {
			if (is_product()) {
				$is_single_page_product = true;
				$margin_zero = "m-zero";
			}
		}


		echo $view_logo['product_quoted'] ? "	
		<div id='product-quoted' class='{$margin_zero} text-italic'><span>{$product_quoted}</span></div>" : '';

		echo $view_logo['meeting_point'] ? "<div id='trip-duration' class='{$margin_zero} '><svg style='padding:0.11rem' fill='#000000' height='20px' width='20px' version='1.1' id='Layer_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' 
	 viewBox='0 0 368.666 368.666' xml:space='preserve'>
<g id='XMLID_2_'>
	<g>
		<g>
			<path d='M184.333,0C102.01,0,35.036,66.974,35.036,149.297c0,33.969,11.132,65.96,32.193,92.515
				c27.27,34.383,106.572,116.021,109.934,119.479l7.169,7.375l7.17-7.374c3.364-3.46,82.69-85.116,109.964-119.51
				c21.042-26.534,32.164-58.514,32.164-92.485C333.63,66.974,266.656,0,184.333,0z M285.795,229.355
				c-21.956,27.687-80.92,89.278-101.462,110.581c-20.54-21.302-79.483-82.875-101.434-110.552
				c-18.228-22.984-27.863-50.677-27.863-80.087C55.036,78.002,113.038,20,184.333,20c71.294,0,129.297,58.002,129.296,129.297
				C313.629,178.709,304.004,206.393,285.795,229.355z'/>
			<path d='M184.333,59.265c-48.73,0-88.374,39.644-88.374,88.374c0,48.73,39.645,88.374,88.374,88.374s88.374-39.645,88.374-88.374
				S233.063,59.265,184.333,59.265z M184.333,216.013c-37.702,0-68.374-30.673-68.374-68.374c0-37.702,30.673-68.374,68.374-68.374
				s68.373,30.673,68.374,68.374C252.707,185.341,222.035,216.013,184.333,216.013z'/>
		</g>
	</g>
</g>
</svg><span>{$meeting_point}</span></div>" : "";


		echo $view_logo['duration'] ? "	
		<div id='trip-duration' class='{$margin_zero} '><img class='lazy' id='trip-duration-time'  data-src='{$time}'/><span>{$product_meta_duration}</span></div>" : "";

		echo $view_logo['max_people'] ? "<div class='{$margin_zero}' id='trip-user' ><img class='lazy' id='trip-duration-user' data-src='{$user}'/><span>{$product_meta_max} person</span></div>" : "";

		echo $view_logo['info'] ? "<div class='{$margin_zero}' id='trip-user' ><img class='lazy' id='trip-duration-user' data-src='{$info}'/><span>{$product_info}</span></div>" : "";

		echo $view_logo['price'] ? "<div class='sc-product-price'>$product_price</div>" : "";

		echo $view_logo['pdf_download'] ? "<div class='{$margin_zero}' id='trip-user' >" . do_shortcode('[elementor-template id="7874"]') . "</div>" : "";


		return ob_get_clean();
	}
}


$trip_fields = Shortcode_Trip::get_instance();
