<div class="olwrap">
	<?php if($this->message): ?>
		<p class="olstatus"><?php echo $this->message; ?></p>
	<?php endif; ?>	
	<form method="post" class="olform">
		<input type="hidden" name="action" value="seed_data">
		<?php submit_button('create table'); ?>
	</form>
</div>