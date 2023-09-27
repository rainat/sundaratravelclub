<?php
if (! defined('ABSPATH')) {
    exit;
}

return apply_filters(
    'wc_xendit_cc_settings',
    array(
        'channel_name' => array(
            'title'       => esc_html(__('Payment Channel Name', 'woocommerce-xendit')),
            'type'        => 'text',
            'description' => wp_kses(__('Your payment channel name will be changed into <strong><span class="channel-name-format"></span></strong>', 'woocommerce-xendit'), ['strong'=>[], 'span'=>['class'=>true]]),
            'placeholder' => 'Credit Card (Xendit)',
        ),
        'payment_description' => array(
            'title'       => esc_html(__('Payment Description', 'woocommerce-xendit')),
            'type'        => 'textarea',
            'css'         => 'width: 400px;',
            'description' => wp_kses(__('Change your payment description for <strong><span class="channel-name-format"></span></strong>', 'woocommerce-xendit'), ['strong'=>[], 'span'=>['class'=>true]]),
            'placeholder' => esc_html(__('Pay with your credit card via Xendit', 'woocommerce-xendit')),
        ),
        'statement_descriptor' => array(
            'title'       => __('Statement Descriptor', 'woocommerce-xendit'),
            'type'        => 'text',
            'description' => esc_html(__('Extra information about a charge. This will appear on your customer’s credit card statement', 'woocommerce-xendit')),
            'default'     => '',
            'desc_tip'    => true,
        ),
    )
);
