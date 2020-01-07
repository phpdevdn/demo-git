<?php get_header(); ?>
<section class="wrap archive">
	<div class="container">
		<header class="bl_hd archive_hd">
			<?php
				the_archive_title( '<h2>', '</h2>' );
				the_archive_description( '<p class="desc">', '</p>' );
			?>		
		</header>
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
<?php get_footer() ?>