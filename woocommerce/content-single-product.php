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
				<img src="<?php echo $main_image_url; ?>" class="product-image"
					alt="<?php echo $product->get_title(); ?>">
			</div>
		</div>

		<div class="col-md-7 col-lg-6 mb-3">
			<?php
        woocommerce_template_single_title();
        woocommerce_template_single_price();
		woocommerce_template_single_add_to_cart();
        ?>
		</div>
	</div>

	<div class="summary entry-summary">
		<?php
		/**
		 * Hook: woocommerce_single_product_summary.
		 *
		 * @hooked woocommerce_template_single_title - 5
		 * @hooked woocommerce_template_single_rating - 10
		 * @hooked woocommerce_template_single_price - 10
		 * @hooked woocommerce_template_single_excerpt - 20
		 * @hooked woocommerce_template_single_add_to_cart - 30
		 * @hooked woocommerce_template_single_meta - 40
		 * @hooked woocommerce_template_single_sharing - 50
		 * @hooked WC_Structured_Data::generate_product_data() - 60
		 */
		//do_action( 'woocommerce_single_product_summary' );
		?>
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