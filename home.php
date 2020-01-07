<?php get_header(); ?>
<section class="wrap archive">
	<div class="container">
		<div class="bl_con posts">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<?php get_template_part('content'); ?>
			<?php endwhile; ?>
					<?php get_template_part('meta','pagination') ?>
			<?php else: ?>
				<?php get_template_part('content','none') ?>
			<?php endif; ?>		
		</div>		
	</div>
</section>
<?php get_footer(); ?>