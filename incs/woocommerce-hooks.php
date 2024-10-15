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
		'home'        => __( 'Головна', 'sushishop' ),
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
	echo '<h2 class="section-title"><span>' . __('Reviews', 'woocommerce') . '</span></h2>';
    comments_template();
	echo '</div>';
}

/**
 * remove fields in checkout page
 */
add_filter('woocommerce_checkout_fields', 'custom_override_checkout_fields');

function custom_override_checkout_fields($fields) {
    // Удаляем ненужные поля
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_email']);
    unset($fields['billing']['billing_last_name']);
    unset($fields['billing']['billing_city']);
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_state']);
    unset($fields['billing']['billing_address_2']);

	
    $fields['billing']['billing_address_1']['required'] = false;
    $fields['billing']['billing_country']['required'] = false;
    
    return $fields;
}

//add our class for button(checkout page)
add_filter('woocommerce_order_button_html', function($button) {
	$btn = str_replace('button alt', 'button alt btn w-100', $button);
	return $btn;
});

//update text for field address_1
add_filter( 'woocommerce_default_address_fields' , 'override_default_address_fields' );
function override_default_address_fields( $address_fields ) {
	
    $address_fields['address_1']['label'] = __('Адреса доставки ', 'woocommerce');

    return $address_fields;
}

// Remove the "Downloads" section from the Personal Account menu
add_filter( 'woocommerce_account_menu_items', 'remove_downloads_from_my_account', 999 );

function remove_downloads_from_my_account( $items ) {
	
    unset( $items['downloads'] );
    return $items;
}


function custom_breadcrumbs() {
    // Начало контейнера
    echo '<ul class="breadcrumbs page-breadcrumbs">';
    
    if (!is_home()) {
        echo '<li><a href="' . home_url() . '">Головна</a></li>';
        if (is_category() || is_single()) {
            echo '<li>';
            the_category(' </li><li> ');
            if (is_single()) {
                echo '</li><li>';
                the_title();
                echo '</li>';
            }
        } elseif (is_page()) {
            echo '<li>';
            echo the_title();
            echo '</li>';
        }
    }
    
    echo '</ul>';
}


// Добавляем радиокнопки на страницу checkout(Дополнительные параметры: Время доставки, Не звонить по телефону для подтверждения заказа)
add_action( 'woocommerce_after_order_notes', 'custom_delivery_options' );

function custom_delivery_options( $checkout ) {
    echo '<div id="custom_delivery_options"><h3>' . __('Додаткові параметри замовлення') . '</h3>';
    
    woocommerce_form_field( 'delivery_option', array(
        'type'    => 'radio',
        'class'   => array('form-row-wide'),
        'label'   => __('Виберіть час доставки'),
        'options' => array(
            'soon'     => 'Найближчим часом (до 90 хв.)',
            'preorder' => 'Замовлення (більше 90 хв.)',
        ),
    ), $checkout->get_value( 'delivery_option' ) );

	  // Добавляем чекбокс
	  woocommerce_form_field( 'no_call_confirmation', array(
        'type'    => 'checkbox',
        'class'   => array('form-row-wide'),
        'label'   => __('Не телефонувати для підтвердження замовлення'),
        'required' => false,
    ), $checkout->get_value( 'no_call_confirmation' ));
    
    echo '</div>';
}

// Сохраняем выбранную опцию в заказе
add_action( 'woocommerce_checkout_create_order', 'save_delivery_option_in_order_meta', 20, 2 );
function save_delivery_option_in_order_meta( $order, $data ) {
    if ( isset( $_POST['delivery_option'] ) ) {
        $order->update_meta_data( 'delivery_option', sanitize_text_field( $_POST['delivery_option'] ) );
    }
}

// Отображение в админке
add_action( 'woocommerce_admin_order_data_after_billing_address', 'display_delivery_option_in_admin_order', 10, 1 );
function display_delivery_option_in_admin_order( $order ){
    $delivery_option = $order->get_meta( 'delivery_option' );
    if( $delivery_option ) {
        echo '<p><strong>Варіант доставки:</strong> ' . ($delivery_option == 'soon' ? 'Найближчим часом (до 90 хв.)' : 'Найближчим часом (до 90 хв.)') . '</p>';
    }
}

// Добавляем информацию в письмо
add_filter( 'woocommerce_email_order_meta_fields', 'add_delivery_option_to_order_email', 10, 3 );
function add_delivery_option_to_order_email( $fields, $sent_to_admin, $order ) {
    $delivery_option = $order->get_meta( 'delivery_option' );
    if( $delivery_option ) {
        $fields['delivery_option'] = array(
            'label' => 'Варіант доставки',
            'value' => $delivery_option == 'soon' ? 'Найближчим часом (до 90 хв.)' : 'Замовлення (більше 90 хв.)'
        );
    }
    return $fields;
}

add_action( 'woocommerce_checkout_update_order_meta', 'save_no_call_checkbox_value' );

function save_no_call_checkbox_value( $order_id ) {
    if ( isset( $_POST['no_call_confirmation'] ) )
        update_post_meta( $order_id, 'no_call_confirmation', esc_attr( $_POST['no_call_confirmation'] ) );
}

// Добавляем в админку
add_action( 'woocommerce_admin_order_data_after_billing_address', 'display_no_call_order_meta', 10, 1 );
function display_no_call_order_meta($order){
    $no_call = get_post_meta( $order->get_id(), 'no_call_confirmation', true );
    if ( $no_call ) {
        echo '<p><strong>' . __('Не телефонувати для підтвердження замовлення:') . '</strong> ' . __('Да') . '</p>';
    }
}

// Добавляем в email
add_action( 'woocommerce_email_after_order_table', 'email_no_call_order_meta', 10, 4 );
function email_no_call_order_meta( $order, $sent_to_admin, $plain_text, $email ) {
    $no_call = get_post_meta( $order->get_id(), 'no_call_confirmation', true );
    if ( $no_call ) {
        echo '<p><strong>' . __('Не телефонувати для підтвердження замовлення:') . '</strong> ' . __('Да') . '</p>';
    }
}