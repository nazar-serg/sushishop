<?php get_header(); ?>
<main class="main">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="hero">
					<h1 class="hero__title">
						<?php the_field('hero_title'); ?>
					</h1>
					<div class="hero__text">
						<p><?php the_field('hero_text'); ?></p>
					</div>
					<div class="hero__btn">
						<?php 
						$hero_link = get_field('hero_link');
						if( $hero_link ): 
							$link_url = $hero_link['url'];
							$link_title = $hero_link['title'];
							$link_target = $hero_link['target'] ? $hero_link['target'] : '_self';
							?>
						<a class="button" href="<?php echo esc_url( $link_url ); ?>"
							target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>

	</div>

	<div class="popular-menu">
		<div class="popular-menu__body">
			<?php
			if (have_rows('popular_menu_list')): ?>
			<ul class="popular-menu__list">
				<?php while(have_rows('popular_menu_list')): the_row();
				$image = get_sub_field('image');
				$text = get_sub_field('text');
				$link = get_sub_field('link');
				?>
				<li data-aos="fade-up" data-aos-duration="3000" class="popular-menu__item">
					<img src="<?php echo $image; ?>" alt="Popular menu">
					<div class="popular-menu__content">
						<div class="popular-menu__text">
							<p><?php echo $text; ?></p>
						</div>
						<div class="popular-menu__btn">
							<a class="button" href="<?php echo $link['url']; ?>">
								<i class="<?php echo $icon; ?>"></i>
								<span><?php echo $link['title']; ?></span>
							</a>
						</div>
					</div>
				</li>
				<?php endwhile; ?>
			</ul>
			<?php endif; ?>
		</div>
	</div>

	<section class="advantages">
		<div class="container">
			<div class="row mb-5">
				<div class="col-12">
					<h2 class="section-title">
						<span><?php the_field('our_advantages_title'); ?></span>
					</h2>
				</div>
			</div>
			<?php
			if (have_rows('our_advantages_list')): ?>
			<div class="row advantages__list">
				<?php while(have_rows('our_advantages_list')): the_row();
				$icon = get_sub_field('icon');
				$text = get_sub_field('text');
				$title = get_sub_field('title');
				?>
				<div class="col-lg-3 col-sm-6">
					<div class=" advantages__item d-flex align-items-center gap-3 h-100">
						<div class="advantages__icon">
							<i class="<?php echo $icon; ?>"></i>
						</div>
						<div class="advantages__content">
							<div class="advantages__item-title">
								<h3><?php echo $title; ?></h3>
							</div>
							<div class="advantages__item-text">
								<p><?php echo $text; ?></p>
							</div>
						</div>
					</div>
				</div>
				<?php endwhile; ?>
			</div>
			<?php endif; ?>
	</section>

	<section class=" featured-products">
		<div class="container">
			<div class="row mb-5">
				<div class="col-12">
					<h2 class="section-title">
						<span><?php the_field('hot_sale_title'); ?></span>
					</h2>
				</div>
			</div>

			<?php echo do_shortcode('[sushishop_recent_products limit=12]'); ?>

		</div>
	</section>

	<section class="about-us" id="about">
		<div class="container fluid">
			<div class="row mb-5">
				<div class="col-12">
					<h2 class="section-title">
						<span>About Us</span>
					</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Impedit velit illo, ex magni
						odio rem ab a saepe nihil assumenda illum reiciendis quae nemo fuga porro omnis.
						Nesciunt, nostrum at?</p>
					<p>Laboriosam, esse dolore incidunt voluptas ea enim quasi laudantium quod ipsum asperiores,
						labore, similique cum accusamus optio perspiciatis et cumque pariatur est sapiente
						dolorem repudiandae libero nulla nesciunt rem! Magnam!</p>
					<p>Voluptatem, maiores dicta? Quod enim temporibus sapiente quisquam optio sed fuga, facilis
						iusto animi qui, vitae voluptate inventore eveniet nulla eius soluta et magnam eligendi
						a veniam tenetur laborum saepe.</p>
				</div>
			</div>
		</div>
	</section>

	<iframe id="map"
		src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2407.1070529675467!2d2.3478712780714384!3d48.85881153486507!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66e1ee52239cb%3A0x2cacf4239af49ccb!2zMTggUnVlIFNhaW50LURlbmlzLCA3NTAwMSBQYXJpcywg0KTRgNCw0L3RhtC40Y8!5e0!3m2!1sru!2sua!4v1683972127217!5m2!1sru!2sua"
		width="100%" height="450" style="border:0; display: block;" allowfullscreen="" loading="lazy"
		referrerpolicy="no-referrer-when-downgrade"></iframe>

</main>
<?php get_footer(); ?>