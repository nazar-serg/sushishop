<?php get_header(); ?>

<?php
do_action( 'woocommerce_before_main_content' );
?>

<?php 
	$content_class = is_search() ? 'col-12' : 'col-lg-9 col-md-8';
?>

<?php if ( !is_search() ): ?>
<div class="col-lg-3 col-md-4">
	<?php do_action( 'woocommerce_sidebar' ); ?>
</div><!-- ./col-lg-3 col-md-4-->
<?php endif; ?>

<div class="<?php echo $content_class; ?>">
	<?php
				do_action( 'woocommerce_shop_loop_header' );

				if ( woocommerce_product_loop() ) { ?>

	<div class="d-flex justify-content-between mb-3">
		<?php do_action( 'woocommerce_before_shop_loop' ); ?>
	</div>

	<?php

					woocommerce_product_loop_start();

					if ( wc_get_loop_prop( 'total' ) ) {
						while ( have_posts() ) {
							the_post();

							do_action( 'woocommerce_shop_loop' );

							wc_get_template_part( 'content', 'product' );
						}
					}

					woocommerce_product_loop_end();

					do_action( 'woocommerce_after_shop_loop' );
				} else {
			
					do_action( 'woocommerce_no_products_found' );
				}
			?>

</div><!-- ./col-lg-9 col-md-8-->
<?php
do_action( 'woocommerce_after_main_content' );
?>

<?php get_footer(); ?>