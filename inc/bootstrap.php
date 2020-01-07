<?php 	
if(!defined('OLTHEME_PATH')){
	define('OLTHEME_PATH',__DIR__ . '/src');
}
if(!defined('OLTHEME_TEMPLATE')){
	define('OLTHEME_TEMPLATE',__DIR__ . '/src/template');
}
if(!defined('OLTHEME_ASSET')){
	define('OLTHEME_ASSET',OL_THEME_URL . '/inc/asset');
}
require(__DIR__ . '/vendor/autoload.php'); 	 
//
if(is_admin()){
	new OlTheme\Pages\Setting;
	new OlTheme\Pages\SubscriberPage;
}
//custom-post
$member = new OlTheme\Post\MemberPost;
$member_cate = new OlTheme\Taxs\MemberCate;