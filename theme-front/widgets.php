<?php 
add_action( 'widgets_init',function(){
	register_sidebar([
		'name'          => __( 'Widget Area'),
		'id'            => 'sidebar_main',
		'class'			=>'sidebar',
		'description'   => __( 'Add widgets here to appear in your sidebar.'),
		'before_widget' => '<div id="%1$s" class="wid %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="wid-tit">',
		'after_title'   => '</h3>',
	]);	
});