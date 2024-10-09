<?php

defined( 'ABSPATH' ) || exit;

global $product;
?>
<div class="col-12">
	<?php do_action( 'woocommerce_before_single_product' ); ?>
</div>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'col-12 product-content-wrapper', $product ); ?>>

	<div class="row">
		<div class="col-md-5 col-lg-6 mb-3">
			<?php
			$attachment_ids = $product->get_gallery_image_ids();
			$main_image_url = wp_get_attachment_url($product->get_image_id());
			?>
			<div class="product-image-wrapper">
				<?php do_action( 'woocommerce_before_single_product_summary' ); ?>
			</div>
		</div>

		<div class="col-md-7 col-lg-6 mb-3">
			<?php
        woocommerce_template_single_title();
		woocommerce_template_single_rating();
		global $product;

		$attribute_quantity = $product->get_attribute( 'quantity' );

		if ( ! empty( $attribute_quantity ) ) {
			echo '<div class="sushishop-product-attribute-wrapper sushishop-single-product-attribute-wrapper">';
			echo '<div class="sushishop-product-attribute-text">' . esc_html('Кількість:', 'sushishop') . '</div>';
			
			echo '<div class="sushishop-product-attribute-icon"><img src="'.get_template_directory_uri() . '/assets/images/icon/sushi-roll.png'.'" alt="Sushi icon"></div>';

			echo '<div class="sushishop-product-attribute-value">' . esc_html( $attribute_quantity ) . '</div>';
			
			echo '</div>';
		}
		
		if ( have_rows('ingredients') ): ?>
			<div class="attr-ingredients-products">
				<div class="attr-ingredients-products__title"><?php _e('Інгредієнти:', 'sushishop'); ?></div>
				<ul>
					<?php
			while( have_rows('ingredients')): the_row();
			$sub_text = get_sub_field('text');
			$sub_image = get_sub_field('image');
		?>
					<li>
						<img src="<?php echo $sub_image; ?>" alt="<?php echo $sub_text; ?>">
						<p><?php echo $sub_text; ?></p>
					</li>

					<?php endwhile; ?>
				</ul>
			</div>
			<?php
			endif;
			?>

			<?php
        woocommerce_template_single_price();
		woocommerce_template_single_add_to_cart();

		$attribute_weight = $product->get_attribute( 'weight' );

		if ( ! empty( $attribute_weight ) ) {
			echo '<div class="sushishop-product-attribute-wrapper sushishop-single-product-attribute-wrapper attr-weight">';
			echo '<div class="sushishop-product-attribute-text">' . esc_html('Вага:', 'sushishop') . '</div>';
			echo '<div class="sushishop-product-attribute-value">' . esc_html( $attribute_weight ) . '</div>';
			echo '</div>';
		}
        ?>
		</div>
	</div>

	<?php
	/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
	do_action( 'woocommerce_after_single_product_summary' );
	?>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>