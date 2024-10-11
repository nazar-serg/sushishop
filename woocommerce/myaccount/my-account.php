<?php
defined( 'ABSPATH' ) || exit;

/**
 * My Account navigation.
 *
 * @since 2.6.0
 */
?>
<?php do_action( 'woocommerce_before_main_content' ); ?>


<div class="col-12 mb-3">
	<div>
		<div class="row">
			<div class="col-lg-3">
				<?php do_action( 'woocommerce_account_navigation' ); ?>
			</div>
			<div class="col-lg-9">
				<div class="woocommerce-MyAccount-content">
					<?php
		do_action( 'woocommerce_account_content' );
	?>
				</div>
			</div>
		</div>

	</div>
</div>


<?php do_action( 'woocommerce_after_main_content' ); ?>