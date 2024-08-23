<?php

function cuber_trim_html_whitespace($html)
{
    return preg_replace('~>\\s+<~m', '><', $html);
}
/**
 * @snippet          Add custom placeholders to WooCommerce email subject and body
 *
 * @author           WP Authors
 *
 * @compatible       WooCommerce 3.2+
 *
 * @param [string]   $string
 * @param [object]   $email
 *
 * @return string
 */
function cuber_filter_email_format_string($string, $email)
{
    // Get WC_Order object from email
    // $order = wc_get_order($email->object);
    $details = '';

    $yith_booking = yith_get_booking($email->object->get_id());

    if ($yith_booking) {
        wc_get_logger()->debug('yith booking ok');

        $from = date('d M Y', $yith_booking->get_from());
        $to = date('d M Y', $yith_booking->get_to());
        $persons = $yith_booking->get_persons();
        $item = $yith_booking->get_order_item();
        $id = $yith_booking->get_order_id();
        $yith_product = yith_wcbk_get_booking_product($item->get_product_id());
        $img = get_the_post_thumbnail_url($item->get_product_id());
        $duration = $yith_product->get_duration();
        $total = wc_price($yith_booking->get_sold_price());
        $title = $yith_product->get_title();
        $details = "<table width='100%' border='0' cellpadding='0' cellspacing='0' style='margin-top:32px;border-top: 1px solid #F4F0E8;'>
        <tbody><tr>
<td width='33%' style='padding-top:24px;border:none;'><img src='$img' width='150'></td>
        <td width='67%' style='padding:20px;padding-top:24px;border:none' >
            <p style='font-weight:bold;font-size:16px;margin-top:0;line-height:1.5'>$title</p>
            <p style='font-size:14px;line-height:1.5;'>Trip ID: $id</p>
            <p style='font-size:14px;line-height:1.5;'>From: $from - $to</p>
            <p style='font-size:14px;line-height:1.5;'>Duration: $duration days</p>
            <p style='font-size:14px;line-height:1.5;'>Person: $persons</p>
            <p style='font-size:14px;line-height:1.5;font-weight:bold;'>Total: $total</p>
        </td>
        </tr>
        </tbody>
        </table>";
    } else {
        wc_get_logger()->debug('yith booking not ok');
    }

    $details = preg_replace('~>\\s+<~m', '><', $details);

    $new_placeholders = [
        '{button_goto_my_account}' => '<div style="width:100%"><a href="https://sundaratravelclub.com/my-account" target="_blank" style="margin:auto;border-radius:5px;background-color:#beb299;width:170px; border:0 hidden;color:#ffffff !important;font-weight:400;display:block;text-decoration:none;text-transform:none;text-align: center;max-width: 100%;background-color:#beb299;line-height:40px;height:40px"><span style="color: white;font-weight:bold">Go to my account</span></a></div>',

        '{button_goto_my_accountss}' => '<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse;"><tbody><tr><td valign="top" style=""><table class="html_button" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate;"><tbody><tr><td valign="top" dir="ltr" style="font-size: 15px;width:530px;font-size:15px;font-weight:400;color:#ffffff;line-height:40px;text-align:center;padding:20px 0px 30px;"><table align="center" width="170px" height="40" class="viwec-button-responsive" border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:separate;width: 170px;
                       background-color: #beb299;
                       border-radius: 5px;">
            <tbody><tr><td class="viwec-mobile-button-padding" align="center" valign="middle" role="presentation" height="40" style="border-radius:5px;background-color:#beb299;width:170px; border:0 hidden; ;"><a href="https://sundaratravelclub.com/my-account" target="_blank" style="color:#ffffff !important;font-weight:400;display:block;text-decoration:none;text-transform:none;margin:0;text-align: center;max-width: 100%;background-color:#beb299;line-height:40px;height:40px"><span style="color: white;font-weight:bold">Go to my account</span></a></td>
            </tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table>',

        '{cuber_booking_details}' => $details,

        '{cuber_airport_details}' => "<table width='100%' border='0' cellpadding='0' cellspacing='0' style='margin-top:8px;'>
        <tbody><tr><td td width='100%' style='padding:20px;background: #F6F6F7;' >
            <p style='font-weight:600;font-size:14px;'>Flight Number :</p>
            <p style='font-weight:600;font-size:14px;'>Departur :</p>
            <p style='font-weight:600;font-size:14px;'>Arrival :</p>
            
        </td>
        </tr>
        </tbody>
        </table>",
    ];

    return str_replace(array_keys($new_placeholders), array_values($new_placeholders), $string);
    // return $string;
}

add_filter('woocommerce_email_format_string', 'cuber_filter_email_format_string', 20, 2);
add_filter('woocommerce_locate_template', 'cuber_intercept_wc_template', 12, 3);
add_filter('wc_get_template', 'cuber_intercept_wc_get_template', 12, 5);

/**
 * Filter the cart template path to use cart.php in this plugin instead of the one in WooCommerce.
 *
 * @param string $template      default template file path
 * @param string $template_name template file slug
 * @param string $template_path template file name
 *
 * @return string the new Template file path
 */
function cuber_intercept_wc_template($template, $template_name, $template_path)
{
    $template_directory = trailingslashit(CUBERAKSI_SUNDARA_BASE_DIR).'woo/templates/';
    $path = $template_directory.$template_name;
    // if (str_contains($template_name, 'email')) {
    //     $path = '/maybenone';
    // }

    // if (str_contains($template_name, 'customer-completed-booking.php') || str_contains($template_name, 'customer-paid-booking.php') || str_contains($template_name, 'customer-confirmed-booking.php') || str_contains($template_name, 'email-order-items.php')) {
    //     $path = $template_directory . $template_name;
    // }

    return file_exists($path) ? $path : $template;
}

function cuber_intercept_wc_get_template($template, $template_name, $args, $template_path, $default_path)
{
    // wp_remote_post('https://webhook.site/fe8110f1-0708-4a98-a9b3-0897815bb6a0',[
    //     'headers' => [ 'Content-Type' => 'application/json'],
    //     'body' => wp_json_encode([ 'template' => $template, 'template_name' => $template_name])
    // ]);

    $template_directory = trailingslashit(CUBERAKSI_SUNDARA_BASE_DIR).'woo/templates/';
    $path = $template_directory.$template_name;
    if (str_contains($template_name, 'email')) {
        // $path = '/maybenone';

        // $wc_logger = wc_get_logger();
        // $wc_logger->debug($template_name.' => '.$template);
    }

    // if (str_contains($template_name, 'customer-completed-booking.php') || str_contains($template_name, 'customer-paid-booking.php') || str_contains($template_name, 'customer-confirmed-booking.php') || str_contains($template_name, 'email-order-items.php')) {
    //     $path = $template_directory . $template_name;
    // }

    return file_exists($path) ? $path : $template;
    // return $template;
}

// trigger on-hold no send email
// add_filter('woocommerce_email_classes', function ($emails) {
//     if (isset($emails['WC_Email_Customer_On_Hold_Order'])) {
//         // $emails['WC_Email_Customer_On_Hold_Order'] = include 'templates/emails/class/class-wc-email-none.php';
//         unset($emails['WC_Email_Customer_On_Hold_Order']);
//     }

//     return $emails;
// }, 100, 1);

add_action('woocommerce_email', 'unhook_on_hold_emails');

function unhook_on_hold_emails($email_class)
{
    remove_action('woocommerce_order_status_pending_to_on-hold_notification', [$email_class->emails['WC_Email_Customer_On_Hold_Order'], 'trigger']);
    remove_action('woocommerce_order_status_failed_to_on-hold_notification', [$email_class->emails['WC_Email_Customer_On_Hold_Order'], 'trigger']);
    remove_action('woocommerce_order_status_cancelled_to_on-hold_notification', [$email_class->emails['WC_Email_Customer_On_Hold_Order'], 'trigger']);
}

add_filter('retrieve_password_message', function ($message, $key, $user_login) {
    $site_name = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
    $reset_link = "sundaratravelclub.com/resetpass?key=$key&login=".rawurlencode($user_login);

    // Create new message
    // $message = __( 'Someoness has requested a password reset for the following account:' . $user_login, 'text_domain' ) . "\n";
    // $message .= sprintf(__('admin: %s'), get_option('admin_email')) . "\n";
    // $message .= sprintf( __( 'Site Name: %s' ), network_home_url( '/' ) ) . "\n";
    // $message .= sprintf( __( 'Username: %s', 'text_domain' ), $user_login ) . "\n";
    // $message .= __( 'If this was a mistake, just ignore this email and nothing will happen.', 'text_domain' ) . "\n";
    // $message .= __( 'To reset your password, visit the following address:', 'text_domain' ) . "\n";
    // $message .= $reset_link . "\n";

    ob_start();
    $GLOBALS['use_html_content_type'] = true;
    viwec_render_email_template(16770);
    $message = ob_get_clean();
    $user = get_user_by('login', $user_login);

    $placeholders = [
        '[user_login]' => $user->user_login,
        '[display_name]' => $user->first_name,
        '[reset_password_url]' => $reset_link,
    ];
    $message = str_replace('[user_login]', $user_login, $message);
    $message = str_replace('[display_name]', $user->display_name, $message);
    $message = str_replace('[reset_password_url]', $reset_link, $message);

    // $message .= $reset_link . "\n";
    // $message .= get_post_meta( 2625, 'viwec_email_structure', true );

    return $message;
}, 20, 3);

add_filter('wp_mail_content_type', function () {
    return 'text/html';
    if ($GLOBALS['use_html_content_type']) {
        return 'text/html';
    } else {
        return 'text/plain';
    }
});

add_filter('wp_mail_from', function ($original_email_address) {
    return get_option('admin_email');
});

// Change the From name.
add_filter('wp_mail_from_name', function ($original_email_from) {
    return get_option('blogname');
});
