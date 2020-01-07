<div class="ol_images <?php echo $option['class'] ?>">
	<div class="actions">
		<button type="button" class="button button-primary but-image">Thêm image</button>
	</div>
	<ul class="image-bl">
		<?php foreach($values as $val): ?>
			<li class="item">
				<input type="hidden" name="<?php echo $name ?>[image][]" value="<?php echo $val['image']; ?>">
				<?php echo wp_get_attachment_image( $val['image'], 'thumbnail', false,['class'=>'img-ite']); ?>
				<input type="text" name="<?php echo $name ?>[text][]" value="<?php echo $val['text'] ?>">
				<span class="del-ite"><span class="dashicons dashicons-no"></span></span>
			</li>    					
		<?php endforeach; ?>
	</ul>
</div>