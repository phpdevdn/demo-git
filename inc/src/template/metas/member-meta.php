<?php 
	use OlTheme\Helpers\OlForm;
	$ip_hot_name = 'member_hot';
	$ip_hot_value = get_post_meta( $post->ID,$ip_hot_name, true );
 ?>
<div class="olwrap">
	<input type="hidden" name="<?php echo $this->input_identify; ?>" value="1">
	<?php OLForm::checkbox(
			$ip_hot_name,
			$ip_hot_value,
			['label'=>'Is hot member']
		) ?>
</div>