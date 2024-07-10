<?php 
	 add_action( 'wp_enqueue_scripts', 'sundara_theme_enqueue_styles' );
	 function sundara_theme_enqueue_styles() {
 		  wp_enqueue_style( 'child-style-astra-sundara', get_stylesheet_directory_uri() . '/style.css',[],time() ); 
 		   wp_enqueue_script( 'child-script-astra-sundara', get_stylesheet_directory_uri() . '/sundara.js',['jquery'],time(),true ); 
 		  }

 	 	add_action( 'wp_body_open', function(){
 		?>
 		<div class="preloaderz">
	<img src="https://sundaratravelclub.com/wp-content/uploads/2024/06/logo-sundara-preload.svg" alt="sundara logo">
</div>
 		<?php
 	} );  
 ?>