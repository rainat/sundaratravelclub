<?php

/**
 * Customer paid booking email.
 *
 * @var YITH_WCBK_Booking $booking        the booking
 * @var string            $email_heading  the heading
 * @var WC_Email          $email          the email
 * @var bool              $sent_to_admin  Is this sent to admin?
 * @var bool              $plain_text     Is this plain?
 * @var string            $custom_message the email message including booking details through {booking_details} placeholder
 */
defined('ABSPATH') || exit;
?>

 <?php do_action('woocommerce_email_header', $email_heading, $email);
?>

<?php
// $custom_message = " From Sundara Paid Booking new";
// ob_start();
// $GLOBALS['use_html_content_type'] = true;
// viwec_render_email_template(2619);

// $message = ob_get_clean();

// $message = str_replace('http://cuber_reset_password_url', $reset_link, $message);
// $message = str_replace('{cuber_user_login}', $user_login, $message);
// echo $message;
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
    echo $yith_product->get_duration();

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
    echo yith_get_booking($id)->get_from().' - '.yith_get_booking($id)->get_to();

    $output = ob_get_clean();

    return $output;
});

$custom_message = do_shortcode(wp_unslash($custom_message));
echo wp_kses_post(wpautop(wptexturize($custom_message)));
?>

<?php
do_action('woocommerce_email_footer', $email);
