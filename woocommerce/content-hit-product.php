<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<div <?php wc_product_class( 'product-card-item', $product ); ?>>
	<div class="product-card">
		<div class="custom-ajax-loader">
			<img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon/ripple.svg" alt="">
		</div>
		<?php
	/**
	 * Hook: woocommerce_before_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item' );
	?>
		<div class="product-thumb">
			<a href="<?php echo $product->get_permalink(); ?>">
				<?php

	/**
	 * Hook: woocommerce_before_shop_loop_item_title.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item_title' );
	?>
			</a>
		</div>
		<!--./product-thumb-->
		<div class="product-details">
			<?php

	/**
	 * Hook: woocommerce_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_product_title - 10
	 */
	do_action( 'woocommerce_shop_loop_item_title' );
	?>
			<div class="product-excerpt"><?php the_content(''); ?></div>

			<!-- attribute output -->
			<?php

			global $product;

			$attribute = $product->get_attribute( 'quantity' );

			if ( ! empty( $attribute ) ) {
				echo '<div class="sushishop-product-attribute-wrapper">';
				
				echo '<div class="sushishop-product-attribute-icon"><img src="'.get_template_directory_uri() . '/assets/images/icon/sushi-roll.png'.'" alt="Sushi icon"></div>'; // Замените иконку на свою

				echo '<div class="sushishop-product-attribute-value">' . esc_html( $attribute ) . '</div>';
				
				echo '</div>';
			}

			?>

			<div class="product-bottom-details">

				<?php

				echo '<div class="sushishop-product-rating">';
				woocommerce_template_loop_rating();
				$rating_cnt = $product->get_rating_count();
				echo '<div class="sushishop-rating-count"> <small>(' . $rating_cnt . ')</small> </div>';
				echo '</div>';
			

	/**
	 * Hook: woocommerce_after_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_rating - 5
	 * @hooked woocommerce_template_loop_price - 10
	 */
	do_action( 'woocommerce_after_shop_loop_item_title' );
	

	/**
	 * Hook: woocommerce_after_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_close - 5
	 * @hooked woocommerce_template_loop_add_to_cart - 10
	 */
	do_action( 'woocommerce_after_shop_loop_item' );
	?>
			</div>
			<!--./product-bottom-details-->
		</div>
		<!--./product-details-->
	</div>
	<!--./product-card-->
</div>
<!--./col-lg-3 col-md-4 col-sm-6 mb-3-->