<?php get_header(); ?>
<section class="wrap">
	<div class="container">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'content', 'single' ); ?>
		<?php endwhile; ?>		
	</div>
</section>
<?php get_footer(); ?>