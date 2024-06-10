<?php
add_action('admin_menu', 'custom_menu');

add_filter("script_loader_tag", "add_module_to_my_script", 10, 3);
function add_module_to_my_script($tag, $handle, $src)
{
    if ("admin-slotjs" === $handle) {
        $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
    }

    return $tag;
}

add_action('admin_enqueue_scripts',function(){
    
    if (isset($_GET['page'])) 
       if (str_contains($_GET['page'],'menu_slug_slots')) {
        echo "<script>console.log('masuk menu slot assets...')</script>";
        wp_enqueue_script('admin-slotjs',CUBERAKSI_SUNDARA_BASE_URL . "woo/admin/template/dist/admin.js",[],CUBERAKSI_SUNDARA_VERSION);
        wp_enqueue_style('admin-slotcss',CUBERAKSI_SUNDARA_BASE_URL . "woo/admin/template/dist/admin.css",[],CUBERAKSI_SUNDARA_VERSION);
       }
    
    
});



function custom_menu() { 
    add_menu_page( 
        'Page Title', 
        'Slots', 
        'edit_posts', 
        'menu_slug_slots', 
        'page_callback_function_admin_slot', 
        'dashicons-media-spreadsheet',
        5 
       );
  }


  function page_callback_function_admin_slot()
  {
   
    echo "<script>console.log('entering..')</script>";
    echo "<div id='app'></div>";
  }