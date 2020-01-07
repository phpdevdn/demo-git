<?php 
	use OlTheme\Helpers\OlForm;	
	$subscribers = $results->data;
 ?>
<section class="olwrap">
	<div class="olcontain">
		<div class="olfilters">
			<form method="get" class="olform">
				<input type="hidden" name="page" 
					value="<?php echo $this->_page_name ?>_index"
					>
				<div class="flex al_item-ct">
					<div class="flex_col-3">
						<?php OlForm::text('name',$this->request->query('name')) ?>
					</div>
					<div class="flex_col-2">
						<p class="pl15">
							<button type="submit" class="button button-primary">
								Filter
							</button>
						</p>
					</div>
				</div>						
			</form>
		</div>
		<table class="wp-list-table widefat fixed striped">
			<thead>
				<tr>
					<th>Name</th>
					<th>Email</th>
					<th>Date</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($subscribers as $sub): ?>
					<?php 						
						$link_edit = $this->getLink(['action'=>'edit','id'=>$sub->id]);
						$link_delete = $this->getLink(['action'=>'delete','id'=>$sub->id]);
					 ?>				
					<tr>
						<td><?php echo $sub->name ?></td>
						<td><?php echo $sub->email ?></td>
						<td><?php echo $sub->created_at ?></td>
						<td>
							<a href="<?php echo $link_edit ?>" class="button">Edit</a>
							<a href="<?php echo $link_delete ?>" 
								class="button"
								onclick="return confirm('Are you sure you want to delete this item?');"
								>Delete</a>
						</td>					
					</tr>
				<?php endforeach ?>
			</tbody>	
		</table>
		<?php $this->view('partials/pagination',compact('results')) ?>		
	</div>
</section>