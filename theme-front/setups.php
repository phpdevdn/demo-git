<?php
if (!is_admin()) {
	show_admin_bar(false);
}
remove_action('wp_head', 'rel_canonical');
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' ); 
add_action( 'after_setup_theme',function(){
	add_theme_support( 
		'post-thumbnails',
		[
			'post','page','member'
		]
	);
	set_post_thumbnail_size( 768, 768, false );
	//
	add_theme_support( 
		'post-formats', array(
		'aside', 'image', 'video', 'quote', 
		'link', 'gallery', 'status', 'audio', 'chat'
	) );
	add_theme_support( 
		'html5', [
			'search-form','comment-form','comment-list',
			'gallery','caption',
		]);
});		
add_action( 'pre_get_posts',function($query){
  if (!is_admin() && $query->is_main_query()){
    if(is_home()){
      	$query->set('posts_per_page', 10);
    }elseif(is_category() || is_archive() || is_tag() || is_search() ){
      	$query->set('posts_per_page', 10);
    }else{
    	$query->set('posts_per_page', 10);	
    }
  }	
});
add_filter( 'the_content_more_link',function($link){
	$link = preg_replace( '|#more-[0-9]+|', '', $link );
	return $link;	
});
add_filter( 'excerpt_length',function(){return 50;}, 999 );
add_filter( 'excerpt_more', function(){ return '...';},999);