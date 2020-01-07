<?php 
add_action('wp_enqueue_scripts',function(){
	wp_enqueue_style('olcss_common',OL_THEME_ASSET.'/css/common.css', [], APP_VERSION, 'all' );
	wp_enqueue_style('olcss',OL_THEME_ASSET.'/css/style.css', [], APP_VERSION, 'all' );
	//script
	wp_deregister_script( 'jquery' );
	wp_enqueue_script('jquery',OL_THEME_ASSET.'/js/jquery.js',[],false,false);	
	wp_enqueue_script('oljs_lib',OL_THEME_ASSET.'/js/lib.js',[],APP_VERSION,true);	
	wp_enqueue_script('oljs',OL_THEME_ASSET.'/js/main.js',[],APP_VERSION,true);	
});