<div class="ol_images <?php echo $option['class'] ?>">
	<div class="actions">
		<button type="button" class="button button-primary but-image">Thêm image</button>
	</div>
	<ul class="image-bl">
		<?php foreach($values as $image): ?>
			<li class="item">
				<input type="hidden" name="<?php echo $name ?>[]" value="<?php echo $image; ?>">
				<?php echo wp_get_attachment_image( $image, 'thumbnail', false,['class'=>'img-ite']); ?>
				<span class="del-ite"><span class="dashicons dashicons-no"></span></span>
			</li>    					
		<?php endforeach; ?>
	</ul>
</div>