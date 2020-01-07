<?php 
	if(!isset($results)){
		return false;
	}
 ?>
<div class="tablenav bottom">
	<div class="tablenav-pages">
		<div class="tablenav-pages">
				<?php 
					$big = 999999999;
					$args = [
						'total' => $results->total,
						'current' => $results->current,
						'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format' => '?paged=%#%',
						'type' => 'list',
					];
					echo paginate_links($args);
				?>
		</div>
	</div> 
</div>	