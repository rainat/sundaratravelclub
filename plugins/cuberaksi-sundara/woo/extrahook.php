<?php

add_filter('wc_get_template', function ($template, $template_name, $args, $template_path, $default_path) {
    $template_directory = trailingslashit(CUBERAKSI_SUNDARA_BASE_DIR).'templates/';
    $path = $template_directory.$template_name;
    // error_log('wc_get_template: '.$path.PHP_EOL, 3, 'ooo.log');

    return file_exists($path) ? $path : $template;
}, 12, 5);

add_filter('woocommerce_locate_template', function ($template, $template_name, $template_path) {
    $template_directory = trailingslashit(CUBERAKSI_SUNDARA_BASE_DIR).'templates/';
    $path = $template_directory.$template_name;
    // error_log("woocommerce_locate_template: $template $template_name $template_path".$path.PHP_EOL, 3, 'ooo.log');

    return file_exists($path) ? $path : $template;
}, 12, 3);

function render_element_extra_checkboxs_field($name, array $field)
{
    // ob_start();
    ?>
    <p class='form-row extra-quiz' style='margin-bottom:5px;'>
        
       <span> <?php
       echo $field['label'];
    if ($field['required']) {
        echo '<abbr class="required" title="required">*</abbr>';
    }?></span>
       

           <?php
           echo "<span class='woocommerce-input-wrapper'>";
    $i = 0;
    $status = [];
    foreach ($field['groups'] as $check) {
        ++$i;
        $var = $name.'_'.$i;
        $checked = $i == 1 ? 'checked' : '';
        echo "<div><input $checked type='{$check['type']}' onclick='changediet($var);' class='input-text' id='$var' /><label style='margin-left:5px;' for='$var'>{$check['label']}</label></div>";
        $status[$var] = ['status' => false, 'value' => $check['label']];
    }

    $status = wp_json_encode($status);

    echo "</span><input type='hidden' name='$name' id='extradiet' value='None'/>";
    echo "<script>
    
    let status = JSON.parse('$status')
    let idName = '$name'

    function changediet(e){
         
        if (e.checked) {
            status[e.getAttribute('id')].status = true
        } else {
            status[e.getAttribute('id')].status = false
        }

        let val = []
        Object.keys(status).map((a)=>{ if (status[a].status) val.push(status[a].value);  })
        document.getElementById('extradiet').value = val.join(', ')
    }
    </script>";

    ?>
      
       </p>
    <?php
    // return ob_get_clean();
}

function render_element_extra_input_field($name, array $field)
{
    // ob_start();
    $required = $field['required'] ? 'required' : '';
    ?>
    <p class='form-row extra-quiz'>
        
       <label for='<?php echo $name; ?>'><?php
       echo $field['label'];
    if ($field['required']) {
        echo '<abbr class="required" title="required">*</abbr>';
    }?></label>
       <span class='woocommerce-input-wrapper'>

           <?php

        echo "<input $required type='{$field['type']}' class='input-text' {$field['required']} placeholder='{$field['placeholder']}' name='$name' id='$name' />";

    ?>
       </span>
       </p>
    <?php
    // return ob_get_clean();
}
global $extra_fields;
$extra_fields = [
    'extra_mailing_address' => [
        'label' => 'Mailing Address',
        'type' => 'text',
        'placeholder' => 'Your answer',
        'required' => true,
    ],
    'extra_date_birth' => [
        'label' => 'Date of Birth',
        'type' => 'date',
        'placeholder' => 'Your answer',
        'required' => true,
    ],

    'extra_dietary' => [
        'group_checkbox' => true,
        'label' => 'Any special dietary restrictions?',
        'required' => true,
        'groups' => [
            [
                'label' => 'None',
                'type' => 'checkbox',
                'value' => 'none',
            ],
            [
                'label' => 'Vegetarian',
                'type' => 'checkbox',
                'value' => 'vegetarian',
            ],
            [
                'label' => 'Vegan',
                'type' => 'checkbox',
                'value' => 'vegan',
            ],
            [
                'label' => 'Dairy-free',
                'type' => 'checkbox',
                'value' => 'dairy-free',
            ],
            [
                'label' => 'Gluten-free',
                'type' => 'checkbox',
                'value' => 'gluten-free',
            ],
            [
                'label' => 'Nut allergy',
                'type' => 'checkbox',
                'value' => 'nut-allergy',
            ],
            [
                'label' => 'Shelfish allergy',
                'type' => 'checkbox',
                'value' => 'shelfish-allergy',
            ],
            [
                'label' => 'Other',
                'type' => 'checkbox',
                'value' => 'other',
            ],
        ],
    ],

    'extra_medical_issue' => [
        'label' => 'Any medical issue that we need to be aware of?',
        'type' => 'text',
        'placeholder' => 'Your answer',
        'required' => false],
    'extra_emergency_contact_name' => [
        'label' => 'Emergency Contact Name',
        'type' => 'text',
        'placeholder' => 'Your answer',
        'required' => true],
    'extra_emergency_contact_email' => [
        'label' => 'Emergency Contact Email',
        'type' => 'email',
        'placeholder' => 'Your answer',
        'required' => true],
    'extra_hear_from' => [
        'label' => 'How did you hear about this trip',
        'type' => 'text',
        'placeholder' => 'Your answer',
        'required' => false],
    'extra_anything_else' => [
        'label' => 'Anything else we need to know?',
        'type' => 'text',
        'placeholder' => 'Your answer',
        'required' => false],
];

function render_extra_fields()
{
    ob_start();
    ?>
    
       <div class='woocommerce-billing-fields'>
           
       <?php global $extra_fields;
    foreach ($extra_fields as $field => $value) {
        if (!isset($value['group_checkbox'])) {
            render_element_extra_input_field($field, $value);
        } else {
            render_element_extra_checkboxs_field($field, $value);
        }
    } ?>
         
        </div>
    
    <?php
    return ob_get_clean();
}

add_action('woocommerce_after_checkout_billing_form', function () {
    // error_log('woocommerce_checkout_billing: '.PHP_EOL, 3, 'ooo.log');
    ob_start();
    ?>
        <div style="margin:auto;width:98%;margin-top:50px;padding-bottom:30px;border-top:1px solid gray;"></div>
    
    <?php

    echo render_extra_fields();
    echo ob_get_clean();
});

add_action('woocommerce_checkout_order_processed', function ($order_id, $posted_data, $order) {
    global $extra_fields;
    // wc_get_logger()->debug(wp_json_encode($extra_fields));
    wc_get_logger()->debug(wp_json_encode($_POST));
    foreach ($extra_fields as $field => $value) {
        if (isset($_POST[$field])) {
            // wc_get_logger()->debug($field.' --> '.$_POST[$field]);
            $order->update_meta_data('_cuber_'.$field, $_POST[$field]);
            $order->save();
        }
    }
}, 12, 3);

function cuber_insert_into_array_after_key(array $source_array, string $key, array $new_element)
{
    if (array_key_exists($key, $source_array)) {
        $position = array_search($key, array_keys($source_array)) + 1;
    } else {
        $position = count($source_array);
    }
    $before = array_slice($source_array, 0, $position, true);
    $after = array_slice($source_array, $position, null, true);

    return array_merge($before, $new_element, $after);
}

add_filter('manage_edit-shop_order_columns', function ($columns) {
    $columns = cuber_insert_into_array_after_key(
        $columns,
        'order_date', // Inject our columns after the "order_date" column
        [
            'extra_info' => 'Extra Info',
            // You can add more custom columns in here...
            // ...
        ]
    );

    return $columns;
}, 25, 1);

add_action('manage_shop_order_posts_custom_column', function ($column_name, $order_or_order_id) {
    $order = $order_or_order_id instanceof WC_Order ? $order_or_order_id : wc_get_order($order_or_order_id);
    $id = $order->get_id();
    switch ($column_name) {
        case 'extra_info':
            echo "<button class='button extra-info-button' data-extra='$id'>Extra Info</button>";
            break;

        default:
            // Unhandled custom column.
            break;
    }
}, 20, 2);

add_filter('manage_woocommerce_page_wc-orders_columns', function ($columns) {
    $columns = cuber_insert_into_array_after_key(
        $columns,
        'order_date', // Inject our columns after the "order_date" column
        [
            'extra_info' => 'Extra Info',
            // You can add more custom columns in here...
            // ...
        ]
    );

    return $columns;
}, 25, 1);

add_action('manage_woocommerce_page_wc-orders_custom_column', function ($column_name, $order_or_order_id) {
    $order = $order_or_order_id instanceof WC_Order ? $order_or_order_id : wc_get_order($order_or_order_id);
    $id = $order->get_id();
    switch ($column_name) {
        case 'extra_info':
            echo "<button class='button extra-info-button' data-extra='$id'>Extra Info</button>";
            break;

        default:
            // Unhandled custom column.
            break;
    }
}, 22, 2);

function cuber_validate_extra_fields($value, $type = 'text', $is_pattern = ['required' => false])
{
    $return = true;

    if ($is_pattern['required']) {
        switch ($type) {
            case 'text':
                $return = (strlen($value) > 0);
                break;

            case 'email':
                $return = is_email($value);
                break;

            case 'date':
                $return = strlen($value) > 0;
                break;
        }
    }

    return $return;
}

add_action('woocommerce_after_checkout_validation', function ($data, $errors) {
    global $extra_fields;

    // Do your data processing here and in case of an
    // error add it to the errors array like:
    foreach ($extra_fields as $field_name => $field) {
        wc_get_logger()->debug($field_name.': '.$_POST[$field_name]);
        if (isset($_POST[$field_name])) {
            if (!cuber_validate_extra_fields($_POST[$field_name], $field['type'], ['required' => $field['required']])) {
                switch ($field['type']) {
                    case 'email':
                        $errors->add('validation', __('<b>'.$field['label'].'</b> invalid email'));
                        break;
                    default:
                        $errors->add('validation', __('<b>'.$field['label'].'</b> is required field'));
                }
            }
        }
    }
}, 10, 2);

add_action('admin_enqueue_scripts', function () {
    wp_enqueue_script('sw2', 'https://cdn.jsdelivr.net/npm/sweetalert2@11');
    wp_enqueue_script('jquery');
    wp_enqueue_script('extra-info', CUBERAKSI_SUNDARA_BASE_URL.'woo/assets/js/extra.js', ['jquery']);
});
