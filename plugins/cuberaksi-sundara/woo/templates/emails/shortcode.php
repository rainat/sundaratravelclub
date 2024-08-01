<?php

add_shortcode('product_image', function ($atts = [], $content = null, $shortcode = '') {
    extract(shortcode_atts(
        [
            'id' => '',
        ],
        $atts
    ));

    ob_start();

    $product_id = yith_get_booking($id)->get_product_id();
    $img = get_the_post_thumbnail_url($product_id);
    echo "<img style='margin-bottom:15px;' src='$img'>";

    $output = ob_get_clean();

    return $output;
});

add_shortcode('duration', function ($atts = [], $content = null, $shortcode = '') {
    extract(shortcode_atts(
        [
            'id' => '',
        ],
        $atts
    ));

    ob_start();

    $product_id = yith_get_booking($id)->get_product_id();
    $yith_product = yith_wcbk_get_booking_product($product_id);
    echo $yith_product->get_duration().' days';

    $output = ob_get_clean();

    return $output;
});

add_shortcode('booking_persons', function ($atts = [], $content = null, $shortcode = '') {
    extract(shortcode_atts(
        [
            'id' => '',
        ],
        $atts
    ));

    ob_start();

    $product_id = yith_get_booking($id)->get_product_id();
    $yith_product = yith_wcbk_get_booking_product($product_id);
    echo yith_get_booking($id)->get_persons().' persons';

    $output = ob_get_clean();

    return $output;
});

add_shortcode('booking_date', function ($atts = [], $content = null, $shortcode = '') {
    extract(shortcode_atts(
        [
            'id' => '',
        ],
        $atts
    ));

    ob_start();

    $product_id = yith_get_booking($id)->get_product_id();
    $yith_product = yith_wcbk_get_booking_product($product_id);
    echo date('F d, Y', yith_get_booking($id)->get_from()).' - '.date('F d, Y', yith_get_booking($id)->get_to());

    $output = ob_get_clean();

    return $output;
});

$custom_message = do_shortcode(wp_unslash($custom_message));
