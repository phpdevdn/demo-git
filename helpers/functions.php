<?php
function ol_include($file,array $data=[]){
	extract($data);
	include($file);
	return;
}
function ol_clear_super_cache(){
	if(!function_exists('wp_cache_clean_cache')){
		return false;
	}
	global $file_prefix;
	wp_cache_clean_cache($file_prefix);
	return;
}
function ol_get_src_iframe($iframe){
	if(empty($iframe)){ return null;}
	$iframe = trim($iframe);
	if(!preg_match('/^<iframe/', $iframe)){ return null;}
	$check = preg_match('/src=\"([^"]+)\"/', $iframe,$src);
	return $check ? $src[1] : null;
} 
