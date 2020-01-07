<?php
$per_page = 10;
$post_type = 'post';
$args = array(
	'post_type' => $post_type,
	'post_status' =>'publish',
	'posts_per_page' =>$per_page
);
$query = new WP_Query( $args );
$qr_str = http_build_query($args); 
$qr_max = $query->max_num_pages;
//
$id_atr = 'olpop-posts'; 
?>
<div id="<?php echo $id_atr; ?>" class="olpop-post">
	<div class="olpop-overlay"></div>
	<div id="<?php echo $id_atr . '-ct'; ?>" class="olpop-post-ct">
		<ul class="olpop-tab">
			<li>
				<a href="<?php echo "#{$id_atr}-list"; ?>" class="olpop-lnk active">Post</a>
			</li>						
			<li>
				<a href="<?php echo "#{$id_atr}-search"; ?>" class="olpop-sea olpop-lnk">Search</a>
			</li>
		</ul>
		<div id="<?php echo "{$id_atr}-list"; ?>" class="olpop-tab-ct active">
			<div class="lst-posts">
			<?php while($query->have_posts()):
				$query->the_post(); 
				$title = wp_trim_words(get_the_title(),5,'...');
			?>
				<div class="ite-post" 
					data-id="<?php echo get_the_ID(); ?>"
					data-title = "<?php echo $title; ?>"
				>
					<p><?php echo $title; ?></p>
				</div>
			<?php endwhile;wp_reset_postdata(); ?>	
			</div>
			<div class="ft">
				<?php if($qr_max > 1): ?>
				<button type="button" 
					class="button olpop-more"
					data-action="getOlPost"
					data-current="1"
					data-total="<?php echo $qr_max ?>"
					data-query="<?php echo $qr_str ?>"
					>
					More
				</button>
				<?php endif; ?>
				<button type="button" class="button olpop-close">Close</button>
			</div>			
		</div>			
		<div id="<?php echo "{$id_atr}-search"; ?>" class="olpop-tab-ct">
			<div class="fr-sea">
				<input type="text" class="olip-txt olpop-key">
				<span class="oltbn olpop-find" data-query="<?php echo $qr_str; ?>" data-action="searchOlPost">
					<span class="dashicons dashicons-search"></span>
				</span>
			</div>
			<div class="lst-posts">
			</div>	
			<div class="ft">
				<button type="button" class="button olbtn olpop-close">Close</button>
			</div>			
		</div>
	</div>
</div>	