<?php 
register_nav_menus([
	'primary' => __( 'Primary Menu')
]);
//functions
function theme_front_menu($name){
	$args = array(
		'theme_location' => $name,
		'container' => '',
		'menu_class' => 'menu-lst',
		'menu_id' => 'main_menu',
		'fallback_cb' => 'wp_page_menu',
		'items_wrap' => '<ul id = "%1$s" class = "%2$s">%3$s</ul>',
		'echo' => false
	); 
	$out = wp_nav_menu($args);
	echo $out;
	return;
}
