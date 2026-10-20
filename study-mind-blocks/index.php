<?php get_header(); ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<article <?php post_class(); ?>>
		<?php if ( ! is_front_page() ) : ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php endif; ?>
		<?php the_content(); ?>
	</article>
<?php endwhile; endif; ?>
<?php get_footer(); ?>