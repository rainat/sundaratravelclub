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

<?php do_action('woocommerce_email_header', $email_heading, $email); ?>

<?php
include 'shortcode.php';
echo wp_kses_post(wpautop(wptexturize($custom_message))); ?>

<?php
do_action('woocommerce_email_footer', $email);
