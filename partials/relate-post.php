<?php 
	$post_id = get_the_ID();
	$tax_name = 'tax_name';
	//
	$args = [
		'taxonomy' => $tax_name,
		'object_ids' => $post_id,
		'childless' => true,
		'fields' => 'ids'
	];
	$cats = get_terms($args);
	//
	$args=array(
		'post__not_in' => array($post->ID),
		'posts_per_page'=>5,
		'ignore_sticky_posts'=>1,
	);
	if(!empty($cats)){
		$args['tax_query'] = [
			[
	            'taxonomy' => $tax_name,
	            'field'    => 'term_id',
	            'terms'    => $cats,
			]
		];
	}
	$my_query = new WP_Query($args);
?>
<div class="bl relate">
    <h3 class="bl_tit">Relate posts</h3>
	<?php if( $my_query->have_posts() ): ?>
	<ul class="bl_ct relate-ct">
		<?php
			while($my_query->have_posts()):$my_query->the_post();	
		?>
		<li>
			<h4 class="relate-item-tit"><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h4>
		</li>
		<?php endwhile; ?>
	</ul>
	<?php endif;wp_reset_postdata(); ?>
</div>