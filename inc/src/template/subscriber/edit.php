<?php 
use OlTheme\Helpers\OlForm;
$link_update = $this->getLink(['action'=>'update','id'=>$subscriber->id]);
?>
<section class="olwrap">
	<div class="olcontain">
		<form method="post" action="<?php echo $link_update ?>" class="olform">
			<?php 
				OlForm::text(
					'name',
					$subscriber->name,
					'Name',
					['required']
				);
			?>
			<?php 
				OlForm::email(
					'email',
					$subscriber->email,
					'Email',
					['required']
				);
			?>
			<p class="al_rt">
				<?php submit_button('Save'); ?>
			</p>			
		</form>
	</div>
</section>