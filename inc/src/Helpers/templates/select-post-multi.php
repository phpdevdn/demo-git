<?php 
$posts = [];
if(!empty($value)){
	$args = [
		'posts_per_page' => count($value),
		'post_type' => ['post','hl_project'],
		'orderby'=>'post__in',
		'include'=>$value,
	];
	$posts = get_posts($args);
	wp_reset_postdata();	
}	
 ?>
<div class="ol-sel_post-wr <?php echo 'ol-sel_'.$type.'-multi'; ?>">
	<div class="ol-sel_post-results">
		<?php foreach($posts as $ite): ?>
			<div class="item">
				<input type="hidden" name="<?php echo $name; ?>[]" value="<?php echo $ite->ID ?>">
				<p class="item-txt"><?php echo $ite->post_title; ?></p>
				<span class="item-del"><span class="dashicons dashicons-no"></span></span>
			</div>			
		<?php endforeach; ?>	
	</div>
	<div class="ol-sel_post-act">
		<button type="button" class="button button-primary ol-sel_post-add">Thêm</button>
	</div>
</div>