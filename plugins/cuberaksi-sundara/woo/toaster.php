<?php
add_action('wp_enqueue_scripts',function(){
	wp_enqueue_script('jq-toaster','https://cdn.jsdelivr.net/npm/jquery-toast-plugin@1.3.2/dist/jquery.toast.min.js',['jquery'],false,true);
	wp_enqueue_style('jq-toaster',CUBERAKSI_SUNDARA_BASE_URL . "woo/assets/css/toast.css");
});