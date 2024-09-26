<?php get_header(); ?>
<?php if ( have_posts() ) : ?>
<!-- Start the loop -->
<?php while ( have_posts() ) : the_post(); ?>
<!-- Display the post content -->
<h2><?php the_title(); ?></h2>
<?php endwhile; ?>
<!-- End of the loop -->
<?php else : ?>
<p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>
<?php get_footer(); ?>