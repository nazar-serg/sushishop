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


// custom shortcode for hit products
add_shortcode( 'sushishop_hit_products', 'sushishop_hit_products' );
function sushishop_hit_products( $atts ){
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

	return '
	<div class="woocommerce featured-products-list">
		<div class="owl-carousel owl-theme owl-carousel-full">
			' . ob_get_clean() . '
		</div>
		<div class="custom-nav-hit-product">
			<div class="owl-nav prev"></div>
            <div class="owl-nav next"></div>
		</div>
	</div>';
}

add_filter('woocommerce_add_to_cart_fragments', function( $fragments ) {
	$fragments['span.cart-badge'] = '<span class="badge text-bg-warning cart-badge bg-warning rounded-circle">'
								. WC()->cart->get_cart_contents_count() . 
'</span>';

return $fragments;

});

// Изменяем символ валюты на грн
add_filter( 'woocommerce_currency_symbol', 'change_currency_symbol_to_uah', 10, 2 );

function change_currency_symbol_to_uah( $currency_symbol, $currency ) {
    if ( $currency === 'UAH' ) {
        $currency_symbol = 'грн.';
    }
    return $currency_symbol;
}

//Breadcrumbs
add_filter('woocommerce_breadcrumb_defaults', function() {
	return array(
		'delimiter'   => '',
		'wrap_before' => '<div class="col-12"><nav class="breadcrumbs"><ul>',
		'wrap_after'  => '</ul></nav></div>',
		'before'      => '<li>',
		'after'       => '</li>',
		'home'        => __( 'Home', 'sushishop' ),
	);
});

//Image category
function sushishop_get_shop_thumb() {
	$html = '';
	if ( is_product_category() ){
	    global $wp_query;
	    $cat = $wp_query->get_queried_object();
	    $thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
	    $image = wp_get_attachment_url( $thumbnail_id );
	    if ( $image ) {
		    $html .= '<img src="' . $image . '" alt="' . $cat->name . '" class="img-thumbnail"/>';
		}
	}

	return $html;
}

//add title after content - page category
remove_action('woocommerce_shop_loop_header', 'woocommerce_product_taxonomy_archive_header', 10);
add_action('woocommerce_shop_loop_header', function() {
    if (is_product_category() || is_shop()) {

        $category_title = woocommerce_page_title(false);

        echo '<h1 class="woocommerce-products-header__title page-title section-title h3"><span>' . esc_html($category_title) . '</span></h1>';
    }
}, 10);


//add description after content - page category
remove_action('woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10);
add_action('woocommerce_after_shop_loop', function() {

    if (is_product_category() || is_shop()) { ?>

<div class="desc-category">
	<?php echo woocommerce_taxonomy_archive_description(); ?>
</div>

<?php
    }
	
}, 10);

//remove all_notices
remove_action('woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10);

//single product
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);

add_filter( 'woocommerce_sale_flash', function( $html, $post, $product ) {
	if ( is_product() ) {
        $html = '<span class="onsale">Знижка</span>';
    }

    return $html;
}, 10, 3 );

//remove upsell and related products
//remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

// Убираем вкладки и выводим описание и отзывы
add_filter('woocommerce_product_tabs', 'custom_remove_product_tabs_layout', 98);

function custom_remove_product_tabs_layout($tabs) {
    return array();
}

// Вывод описания и отзывов в виде блоков
add_action('woocommerce_after_single_product_summary', 'custom_display_product_description_and_reviews', 5);

function custom_display_product_description_and_reviews() {
    global $post;
	global $product;
	if(!empty(get_the_content())) {
		echo '<div class="custom-product-description">';
		echo '<h2 class="section-title"><span>' . __('Опис', 'sushishop') . ' ' . __($product->name) . '</span></h2>';
		the_content();
		echo '</div>';
	}

	echo '<div class="custom-product-comments">';
	echo '<h2 class="section-title"><span>' . __('Відгуки', 'woocommerce') . '</span></h2>';
    comments_template();
	echo '</div>';
}