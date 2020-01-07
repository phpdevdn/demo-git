<?php 
add_filter( 'login_headerurl',function(){return home_url('/');}, 10, 1 );
add_action( 'login_enqueue_scripts',function(){
$url = 	OL_THEME_URL;
$out=<<<HEREDOC
	<style type='text/css'> 
	body.login div#login h1 a {
	background-image: url({$url}/images/logo-header.png);  
	padding-bottom: 30px; 
	} 
	</style>	
HEREDOC;
echo $out;	
return true;	
},999 );