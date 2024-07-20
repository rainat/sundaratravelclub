<?php

/**
 * Customer paid booking email.
 *
 * @var YITH_WCBK_Booking $booking        The booking.
 * @var string            $email_heading  The heading.
 * @var WC_Email          $email          The email.
 * @var bool              $sent_to_admin  Is this sent to admin?
 * @var bool              $plain_text     Is this plain?
 * @var string            $custom_message The email message including booking details through {booking_details} placeholder.
 *
 * @package YITH\Booking
 */

defined('ABSPATH') || exit;
?>

 <?php do_action('woocommerce_email_header', $email_heading, $email);
    ?>

<?php
// $custom_message = " From Sundara Paid Booking new";
ob_start();
$GLOBALS["use_html_content_type"] = TRUE;
viwec_render_email_template(2619);


$message = ob_get_clean();

// $message = str_replace('http://cuber_reset_password_url', $reset_link, $message);
// $message = str_replace('{cuber_user_login}', $user_login, $message);
echo $message;
// echo wp_kses_post(wpautop(wptexturize($message))); 
?>

<?php
do_action('woocommerce_email_footer', $email);
