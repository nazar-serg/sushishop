<?php

//https://woocommerce.com/document/disable-the-default-stylesheet/
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

//Карточка продукта
remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
//remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
add_action('woocommerce_shop_loop_item_title', function() {
	global $product;
	echo '<h4><a href="'. $product->get_permalink() .'">' . $product->get_title() . '</a></h4>';
});

remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);

add_filter('woocommerce_product_get_rating_html', function($html, $rating, $count) {
		$html = '';
		/* translators: %s: rating */
		$label = sprintf( __( 'Rated %s out of 5', 'woocommerce' ), $rating );
		$html  = '<div class="star-rating" role="img" aria-label="' . esc_attr( $label ) . '">' . wc_get_star_rating_html( $rating, $count ) . '</div>';
		return $html;
	}, 10, 3);

// Изменение текста кнопки "Add to Cart" на страницах архива товаров
add_filter( 'woocommerce_product_add_to_cart_text', 'custom_add_to_cart_button_text' );
add_filter( 'woocommerce_product_single_add_to_cart_text', 'custom_add_to_cart_button_text' );

function custom_add_to_cart_button_text() {
    return __( 'Замовити', 'your-textdomain' );
}

add_filter( 'woocommerce_loop_add_to_cart_link', 'custom_add_to_cart_button_wrapper', 10, 2 );
function custom_add_to_cart_button_wrapper( $button, $product ) {
    // Создаем обертку для кнопки с классом
    $button = '<div class="sushishop-product-button">' . $button . '</div>';
    
    return $button;
}


// custom shortcode
add_shortcode( 'sushishop_recent_products', 'sushishop_recent_products' );
function sushishop_recent_products( $atts ){
	global $woocommerce_loop, $woocommerce;

	extract( shortcode_atts( array(
		'limit' => '12',
		'orderby' => 'date',
		'order' => 'DESC',
	), $atts ) );

	$args = array(
		'post_status' => 'publish',
		'post_type' => 'product',
		'orderby' => $orderby,
		'order' => $order,
		'posts_per_page' => $limit,
		'tax_query'      => array(
		array(
			'taxonomy' => 'product_visibility',
			'field'    => 'name',
			'terms'    => 'featured',
			'operator' => 'IN',
		),
	),
	);

	ob_start();

	$products = new WP_Query( $args );

	if ( $products->have_posts() ) : ?>

<?php while ( $products->have_posts() ) : $products->the_post(); ?>

<?php wc_get_template_part( 'content', 'hit-product' ); ?>

<?php endwhile; // end of the loop. ?>

<?php endif;

	wp_reset_postdata();

	return '<div class="woocommerce"><div class="owl-carousel owl-theme owl-carousel-full">' . ob_get_clean() . '</div></div>';
}