<div class="action-bar clear">
	<div class="action-menu helper-right">
		<button>Actions</button>
		<ul>
			<li><?php echo HTML::anchor(
					Route::get('admin')
						->uri(array(
							'controller' => 'tags', 
							'action' => 'add'
						)), __('Add tag'));?>
			<li><?php echo HTML::anchor(
					Route::get('admin')
						->uri(array(
							'controller' => 'tags', 
							'action' => 'delete'
						)), __('Delete tags'), array('id' => 'delete-tags'))?>
			</li>
		</ul>
	</div>
	<?php echo $breadcrumbs?>
</div>

<table>
	<thead>
		<tr>
			<th>
				<label for="tag-all">
					<?php echo Form::checkbox('tag-all', '1', FALSE); ?>
					Name
				</label>
			</th>
			<th>Date</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($items as $tag){?>
		<tr>
			<td>
				<?php echo Form::checkbox('tag-'.$tag->id, '1', FALSE); ?>
				<?php echo HTML::anchor(
					Route::get('admin')
						->uri(array(
							'controller' => 'tags', 
							'action' => 'edit',
							'id' => $tag->id
						)), $tag->name)?>
			</td>
			<td><?php echo $tag->friendly_date; ?></td>
		</tr>
		<?php }?> 
	</tbody>
	<tfoot>
		<tr>
			<td colspan="2">
				<div style="float:right"><?php echo $pagination->render()?></div>
				Showing <?php echo $items->count()?> of <?php echo $total?> tags
			</td> 
		</tr>   
	</tfoot>   
</table>