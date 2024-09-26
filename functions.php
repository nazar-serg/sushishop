<?php
//Woocommerce
add_action( 'after_setup_theme', function() {
    add_theme_support('woocommerce');
    add_theme_support( 'title-tag' );
    add_theme_support('custom-logo');
});

//Styles
function sushishop_theme_enqueue_styles() {
    wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js');
	wp_enqueue_script( 'jquery' );
    wp_enqueue_script('sushishop-main-js', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery'), '1.0.0', true);
    wp_enqueue_style('sushishop-main-css', get_template_directory_uri() . '/assets/css/main.css', array(), '1.0.0', 'all');
}
add_action('wp_enqueue_scripts', 'sushishop_theme_enqueue_styles');

require_once get_template_directory() . '/incs/woocommerce-hooks.php';