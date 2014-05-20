<?php

/**
* Enqueue styles
*/

function my_styles() {
	wp_register_style('style', get_template_directory_uri() . '/style.css', '1.2');
 	wp_enqueue_style( 'style' );
 	//Google web fonts
	wp_register_style('googleFonts', 'http://fonts.googleapis.com/css?family=Noto+Sans:400,700');
	wp_enqueue_style( 'googleFonts');
}

add_action('wp_enqueue_scripts', 'my_styles');

?>