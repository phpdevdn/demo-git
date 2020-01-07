<?php 
	$value = get_search_query();
 ?>
<form class="search_fr form" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
	<div class="search_el">
		<input type="text" name="s" 
			value="<?php echo $value; ?>"
			placeholder="Search"
		>
		<button type="submit" class="btn" >Search</button>
	</div>	
</form>