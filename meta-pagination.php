<div class="pagination">
	<?php 
		$args = array(
			'format' => 'page/%#%',
			'prev_text'          => '<i class="fa fa-angle-left"></i>',
			'next_text'          => '<i class="fa fa-angle-right"></i>',
			'type'               => 'list',
			);
		echo paginate_links( $args );
	?>
</div>