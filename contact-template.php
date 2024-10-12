<?php
/*
	Template Name: Contact template
*/
?>

<?php get_header() ?>
<div class="container">
	<div class="row">
		<div class="contacts-page col-12 mb-5">
			<?php custom_breadcrumbs(); ?>
			<h1 class="section-title mb-3 h3"><span><?php the_title() ?></span></h1>
			<div class="contacts-page__wrapper">
				<div class="contacts-page__text">
					<p><?php the_field('text_contacts'); ?></p>
				</div>
				<?php if ( have_rows('our_contacts') ) : ?>

				<ul>
					<?php
			while ( have_rows('our_contacts') ) : the_row();
			$get_phone = get_sub_field('phone');
			$get_icon = get_sub_field('icon');
			?>
					<li>
						<a href="tel:<?php echo $get_phone; ?>">
							<i class="fa-solid fa-phone-volume"></i>
							<?php echo $get_phone; ?>
						</a>
					</li>
					<?php endwhile;?>
				</ul>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>


<?php get_footer() ?>