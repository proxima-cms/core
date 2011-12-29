<div class="action-bar clear">
	<div class="action-menu helper-right">
		<button>Actions</button>
		<ul>
			<li><?php echo HTML::anchor('admin/components/add', __('Add component'))?></li>
			<li><?php echo HTML::anchor('admin/components', __('Delete components'), array('id' => 'delete-components'))?></li>
		</ul>
	</div>
	<?php echo $breadcrumbs?>
</div>

<table>
	<thead>
		<tr>
			<th>
				<label for="tag-all">
					<?php echo Form::checkbox('components-all', '1', FALSE); ?>
					Name
				</label>
			</th>
			<th>Date</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($items as $component){?>
		<tr>
			<td>
				<?php echo Form::checkbox('tag-'.$component->id, '1', FALSE); ?>
				<?php echo HTML::anchor('admin/components/edit/'.$component->id, $component->name)?>
			</td>
			<td><?php echo $component->date?></td>
		</tr>
		<?php }?> 
	</tbody>
	<tfoot>
		<tr>
			<td colspan="2">
				<div style="float:right"><?php echo $pagination->render()?></div>
				Showing <?php echo $items->count()?> of <?php echo $total?> components
			</td> 
		</tr>   
	</tfoot>   
</table>
