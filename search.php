<?php 
	get_header(); 
	$search_key = get_search_query();
?>
<section class="wrap archive">
	<div class="container">
		<header class="bl_hd archive-hd">
			<p class="title">
				<span>search result for :</span> 
				<span><?php echo $search_key ?></span>
			</p>		
		</header>
		<div class="bl_ct posts">
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