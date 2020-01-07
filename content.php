<?php
	$id = get_the_ID(); 
	$title = get_the_title();
	$link = get_the_permalink();
	$excerpt = get_the_excerpt();
 ?>
<article class="item post">	
		<h3 class="item_tit post_tit">
			<a href="<?php echo $link; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a>
		</h3>		
 		<div class="item_con post_ct">
			<?php 
				if(has_post_thumbnail()){
					the_post_thumbnail($id,'medium',['class'=>'post-thumbnail']);
		 		} 
	 		?>
			<?php echo $excerpt; ?>
			<div class="more">
				<a class="more-lnk" href="<?php echo $link; ?>">read more</a>
			</div>
 		</div>											
</article>		