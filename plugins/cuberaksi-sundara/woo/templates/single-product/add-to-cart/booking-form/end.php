<?php

/**
 * Booking form end template.
 *
 * @var WC_Product_Booking $product
 *
 * @package YITH\Booking\Templates
 */

defined('YITH_WCBK') || exit;
global $post;
$title = $post->post_title;
?>
<style>

	#detail-people::after{
    font-family: 'Font Awesome 5 Free';
    content: "\f007";
    font-weight: 400;
    position: absolute;
    padding: 9px;
    padding-top: 0;
    font-size: small;
}
</style>
<div class="flex flex-col w-full px-0 gap-2 items-start my-3">
	<div class="mt-2 font-bold text-left">Details</div>
	<div class="flex justify-between w-full  md:text-xs">
		<div class="ml-3"><?= $title; ?></div>
		
		<div id="detail-people"></div>
		<div id="detail-price" class="mr-2"></div>
		
		

	</div>
	<div class="flex justify-between w-full  md:text-xs">

			<div class="ml-3" id="detail-cost" ></div>
			<div id="detail-cost-price" class="mr-2"></div>
		
	</div>
	<div class="flex justify-between w-full">
		<div class="font-bold">TOTAL</div>
		<div id="detail-total" class="font-bold mr-2"></div>


	</div>
	<div class="flex justify-end w-full">
		<div class="itaxfee">Includes taxes and fees</div>
	</div>
</div>
</div>
