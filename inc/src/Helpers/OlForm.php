<?php
namespace OlTheme\Helpers; 
class OlForm{
	static public function selectPostMulti($type,array $value=[],$name='posts',array $atr=[])
	{
		$option = [
		];
		$option = array_merge($option,$atr);
		ob_start();
		$temp = 'select-post-multi.php';
		include(__DIR__ . "/templates/{$temp}");
		$out = ob_get_clean();
		echo $out;
	}
	static public function selectPost($type,$name,$value='',$title='',$attr=array()){
		$def = array(
			'placeholder'=>''
		);
		$attr = array_merge($def,$attr);
		$ip_id = sanitize_title($name);
		$out = self::ip_open();
		$out .='<div class="olsel-'.$type.'">';
		$out .= '<span class="result">'.$title.'</span>';
		$out .= '<span class="ol-add dashicons dashicons-plus"></span>';
		$out .= '<span class="ol-del"><span class="dashicons dashicons-no-alt"></span></span>';
		$out .= '<input type="hidden" class="ol-sv" name="'.$name.'" value="'.$value.'"/>';
		$out .= '</div>';	
		$out .= self::ip_close();	
		echo $out;
		return '';		
	}	
	static public function imageMulti($name='images', array $values=[],$atr=[]){
		$option = [
			'class' => 'ol-multi-img',
			'input' => false
		];
		$option = array_merge($option,$atr);
		ob_start();
		$temp = $option['input'] ? 'multiple-input.php' : 'multiple-image.php';
		include(__DIR__ . "/templates/{$temp}");
		$out = ob_get_clean();
		echo $out;
	}
	static public function imageId($name,$value='',$label='',$attr=array()){
		$def = array(
			'placeholder'=>''
		);
		$attr = array_merge($def,$attr);
		$ip_id = sanitize_title($name);
		$out = self::ip_open();
		$out .= self::label($label,$ip_id);
		$out .='<div class="ol-add-image ol-img">';
		$out .= '<input type="hidden" name="'.$name.'" value="'.$value.'" data-type="id" class="inp-sv">';
		$img_url= '';
		if(!empty($value)){
			$img_dt = ol_image_data($value,'thumbnail');
			$img_url = $img_dt['url'];
		}
		$out .= '<img src="'.$img_url.'" class="image">';
		$out .= '<span class="add-img"></span>';
		$out .= '<span class="del-img"><span class="dashicons dashicons-no-alt"></span></span>';
		$out .='</div>';	
		$out .= self::ip_close();	
		echo $out;
		return '';		
	}	
	static public function tinySimple($name,$value='',$atr=[]){
		$args = array( 
			'media_buttons'=> false,
			'editor_height'=> 100,
			'textarea_rows'=>5,
			'quicktags' => array( 'buttons' => 'strong,em,del,ul,ol,li,close' )
		);
		$args = array_merge($args,$atr);
		wp_editor( $value,$name, $args );		
	}
	static public function textarea($name,$value='',$label='',$attr=array()){
		$def = array(
			'placeholder'=>''
		);
		$attr = array_merge($def,$attr);
		$ip_id = sanitize_title($name);
		$out = self::ip_open();
		$out .= self::label($label,$ip_id);
		$out .='<textarea name="'.$name.'" id="'.$ip_id.'" class="fr-area" placeholder="'.$attr['placeholder'].'">'.$value.'</textarea>';	
		$out .= self::ip_close();	
		echo $out;
		return '';
	}
	static public function number($name,$value='',$label='',$attr=array()){
		$def = array(
			'placeholder'=>''
		);
		$attr = array_merge($def,$attr);
		$out = '';
		$ip_id = sanitize_title($name);
		$out .= self::ip_open();
		$out .= self::label($label,$ip_id);
		$out .= '<input type="number" class="fr-num" name="'.$name.'" value="'.$value.'" placeholder="'.$attr['placeholder'].'" id="'.$ip_id.'">';
		$out .= self::ip_close();
		echo $out;
		return '';
	}
	static public function select($name,$value='',$opts=array(),$label='',$attr=array()){
		$def = array(
			'placeholder'=>''
		);
		$attr = array_merge($def,$attr);
		$out = '';
		$ip_id = sanitize_title($name);
		$out .= self::ip_open();
		$out .= self::label($label,$ip_id);
		$out .= '<select name="'.$name.'" class="fr-sel full">';
		$out .= '<option value="">---Select option---</option>';
		foreach($opts as $key=>$opt){
			$is_sel = ($key == $value) ? ' selected' : '';
			$out .= '<option value="'.$key.'"'.$is_sel.'>'.$opt.'</option>';
		}
		$out .= '</select>';
		$out .= self::ip_close();
		echo $out;
		return '';
	}
	static public function text($name,$value='',$label='',$attr=array()){
		$def = array(
			'placeholder'=>''
		);
		$attr = array_merge($def,$attr);
		$out = '';
		$ip_id = sanitize_title($name);
		$out .= self::ip_open();
		$out .= self::label($label,$ip_id);
		$out .= '<input type="text" class="fr-txt" name="'.$name.'" value="'.$value.'" placeholder="'.$attr['placeholder'].'" id="'.$ip_id.'">';
		$out .= self::ip_close();
		echo $out;
		return '';
	}

	static public function email($name,$value='',$label='',$attr=array()){
		$def = array(
			'placeholder'=>''
		);		
		$out = '';
		$ip_id = sanitize_title($name);
		$out .= self::ip_open();
		$out .= self::label($label,$ip_id);
		$out .= '<input type="email" class="fr-txt" name="'.$name.'" value="'.$value.'" placeholder="'.$attr['placeholder'].'" id="'.$ip_id.'">';
		$out .= self::ip_close();
		echo $out;
		return '';
	}
	public static function checkbox($name,$is_check,$att=[]){
		$def = [
			'type'=>'checkbox',
			'name'=>$name,
			'class'=>'',
			'value'=>1,
			'label'=>''
		];
		$att = array_merge($def,$att);		
		$check = $is_check ? 'checked' : '';
		$out = self::ip_open();
		$out .= "<label class='lb_checkbox'>";
		$out .= "<input type=\"checkbox\" 
					name=\"{$name}\" 
					value=\"{$att['value']}\" 
					class=\"{$att['class']}\" 
					{$check}
					>";
		$out .= "<span>{$att['label']}</span>";			
		$out .= "</label>";
		$out .= self::ip_close();
		echo $out;
		return;
	}
	public static function submit($name = 'Save')
	{
		return "<button type='submit' class='button button-primary'>{$name}</button>";
	}
	static public function label($label,$name=''){
		$out = '<label for="'.$name.'" class="fr-lb">'.$label.'</label>';
		return $out;
	}
	static public function ip_open(){
		$out = '<div class="fr-row">';
		return $out;
	}
	static public function ip_close(){
		$out = '</div>';
		return $out;
	}

}