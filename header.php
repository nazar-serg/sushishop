<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div class="wrapper">

		<header class="header">
			<div class="header-top py-1">
				<div class="container">
					<div class="row">
						<div class="col-sm-6 col-12">
							<div class="header-top-info">
								<?php
								if (have_rows('link_info_top_bar', 'option')): ?>
								<ul class="link-list">
									<?php while(have_rows('link_info_top_bar', 'option')): the_row();
									$icon = get_sub_field('icon');
									$link = get_sub_field('link');
									?>
									<li>
										<a href="<?php echo $link['url']; ?>">
											<i class="<?php echo $icon; ?>"></i>
											<span><?php echo $link['title']; ?></span>
										</a>
									</li>
									<?php endwhile; ?>
								</ul>
								<?php endif; ?>

							</div>
						</div>
						<div class="col-sm-6 col-12">
							<div class="header-top-account d-flex justify-content-end">
								<div class="btn-group me-2">
									<?php 
									$link_account = get_field('account_link', 'option');
									if( $link_account ): 
										$link_url = $link_account['url'];
										$link_title = $link_account['title'];
										$link_target = $link_account['target'] ? $link['target'] : '_self';
										?>
									<a href="<?php echo esc_url( $link_url ); ?>"
										target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
									<?php endif; ?>
								</div>
							</div>
							<!-- ./header-top-account -->
						</div>
					</div>
				</div>
			</div>
			<!-- ./header-top -->

			<div class="header-middle bg-white py-4">
				<div class="container">
					<div class="row align-items-center">

						<div class="col-md-2 col-sm-4">
							<div class="header-logo">
								<?php
								if ( function_exists( 'the_custom_logo' ) ) {
									the_custom_logo();
								}
							?>
							</div>
						</div>
						<div class="col-md-4 col-sm-8 header-center-contact">
							<div class="header-time">
								<?php
									$header_phone = get_field('center_header_time', 'option');
									if ($header_phone): ?>
								<div>
									<i class="<?php echo $header_phone['icon']; ?>"></i>
									<span><?php echo $header_phone['text']; ?></span>
								</div>
								<?php endif; ?>
							</div>

							<div class="header-phone">
								<?php
									$header_phone = get_field('center_header_phone', 'option');
									if ($header_phone): ?>
								<div>
									<a href="<?php echo $header_phone['text']; ?>">
										<i class="<?php echo $header_phone['icon']; ?>"></i>
										<span><?php echo $header_phone['text']; ?></span>
									</a>
								</div>
								<?php endif; ?>
							</div>
						</div>

						<div class="col-md-6 col-12 mt-2 mt-md-0">
							<?php aws_get_search_form( true ); ?>
						</div>

					</div>
				</div>

			</div>
			<!-- ./header-middle -->
		</header>

		<div class="header-bottom sticky-top" id="header-nav">
			<nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
				<div class="container">
					<button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
						data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-expanded="false"
						aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="offcanvas offcanvas-start" id="offcanvasNavbar" tabindex="-1"
						aria-labelledby="offcanvasNavbarLabel">
						<div class="offcanvas-header">
							<h5 class="offcanvas-title" id="offcanvasNavbarLabel">Catalog</h5>
							<button type="button" class="btn-close" data-bs-dismiss="offcanvas"
								aria-label="Close"></button>
						</div>
						<div class="offcanvas-body">
							<?php
							wp_nav_menu(array(
								'theme_location' => 'header-menu',
								'container' => null,
								'menu_class' => 'navbar-nav',
								'walker' => new Sushishop_Header_Menu(),
							));
							?>
						</div>
					</div>

					<?php if (! is_cart()): ?>
					<div class="info-product">
						<button class="btn p-1" id="cart-open" type="button" data-bs-toggle="offcanvas"
							data-bs-target="#offcanvasCart" aria-controls="offcanvasCart">
							<i class="fa-solid fa-cart-shopping"></i>
							<span class="badge text-bg-warning cart-badge bg-warning rounded-circle">
								<?php echo WC()->cart->get_cart_contents_count(); ?>
							</span>
						</button>
					</div>
					<?php endif; ?>

				</div>
			</nav>
		</div>

		<!-- ./header-bottom -->
		<?php if (! is_cart()): ?>
		<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCart" aria-labelledby="offcanvasCartLabel">
			<div class="offcanvas-header">
				<h5 class="offcanvas-title" id="offcanvasCartLabel"><?php _e('Кошик', 'sushishop'); ?></h5>
				<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
			</div>
			<div class="offcanvas-body">
				<?php woocommerce_mini_cart(); ?>
			</div>
		</div>
		<?php endif; ?>