<?php
//Woocommerce
add_action( 'after_setup_theme', function() {
    load_theme_textdomain( 'sushishop', get_template_directory() . '/languages' );
    add_theme_support( 'woocommerce' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'custom-logo' );
    add_theme_support( 'wc-product-gallery-lightbox' );
     
    register_nav_menus(
        array(
            'header-menu' => __( 'Header menu', 'sushishop' ),
            'footer-menu' => __( 'Footer menu', 'sushishop' ),
            'footer-menu-info' => __( 'Footer menu info', 'sushishop' ),
        )
        );
});

//Styles
function sushishop_theme_enqueue_styles() {
    wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js');
	wp_enqueue_script( 'jquery' );
    wp_enqueue_script('sushishop-main-js', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery'), '1.0.1', true);
    wp_enqueue_style('fonts', 'https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');
    wp_enqueue_style('sushishop-main-css', get_template_directory_uri() . '/assets/css/main.css', array(), '1.0.0', 'all');
}
add_action('wp_enqueue_scripts', 'sushishop_theme_enqueue_styles');

// Search only products
// function filter_search_only_products($query) {
//     if (!is_admin() && $query->is_main_query() && $query->is_search()) {
//         $query->set('post_type', 'product');
//     }
// }
// add_action('pre_get_posts', 'filter_search_only_products');

//add sidebar
add_action( 'widgets_init', function() {

    register_sidebar( array(
        'name'          => __('Custom Sidebar', 'sushishop'),
        'id'            => 'sidebar-1',
        'description'   => __('This is a custom sidebar.', 'sushishop'),
        'before_widget' => '<div class="widget custom-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
} );

//Incs files
require_once get_template_directory() . '/incs/woocommerce-hooks.php';
require_once get_template_directory() . '/incs/class-sushishop-header-menu.php';