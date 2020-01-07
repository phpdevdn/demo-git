<?php 
function theme_front_image_data($id_img){
	$url_img=wp_get_attachment_image_src( $id_img,'full');
	return array('url'=>$url_img[0]);
}
function theme_front_image_lazy_asset($img,$screen=['pc','sm','xs'], $return=false){
	$img_url = OL_THEME_ASSET . '/images';
	$img_if = pathinfo($img);
	$dirname  = ($img_if['dirname'] == '/' || $img_if['dirname'] == '\\') ? '':$img_if['dirname'];
	$pc_img = $img;
	$output = '';
	$output .= ' data-pcimg="'.$img_url.$pc_img.'"';
	if(in_array('sm', $screen)){
		$sm_img = $dirname.'/'.$img_if['filename'].'-sm.'.$img_if['extension'];
		$output .= ' data-smimg="'.$img_url.$sm_img.'"';
	}
	if(in_array('xs', $screen)){
		$xs_img = $dirname.'/'.$img_if['filename'].'-xs.'.$img_if['extension'];
		$output .= ' data-xsimg="'.$img_url.$xs_img.'"';			
	}
	if($return){ return $output; }
	echo $output;
	return true;
}
function theme_front_image_lazy_image($id_img,$sizes=null,$return= false){
	if(empty($id_img)){ return false;}
	if(empty($sizes)){
		$sizes = array('full','large','medium');
	}
	$url_img=wp_get_attachment_image_src( $id_img,$sizes[0]);
	if(empty($url_img)){ return false;}
	$url_sm=wp_get_attachment_image_src( $id_img,$sizes[1]);
	$url_xs=wp_get_attachment_image_src( $id_img,$sizes[2]);
	$html = 'data-pcimg="'.$url_img[0].'" data-smimg="'.$url_sm[0].'" data-xsimg="'.$url_xs[0].'" ';
	if(count($sizes) > 3){
		$url_large=wp_get_attachment_image_src( $id_img,$sizes[3]);
		$html .= 'data-largeimg="'.$url_large[0].'" ';
	}
	if($return){ return $html;}
	echo $html;
	return true;
}		
function theme_front_image_lazy_thumbnail($id,$size='full'){
	$id_img=get_post_thumbnail_id($id);
	if(empty($id_img)){return false;}
	$url_img=wp_get_attachment_image_src( $id_img,$size);
	if(empty($url_img)){ return false;}
	$html = 'data-pcimg="'.$url_img[0].'"';
	echo $html;
	return true;
}