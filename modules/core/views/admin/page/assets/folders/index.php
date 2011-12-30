<div class="action-bar clear">
	<div class="action-menu helper-right">
		<button>Actions</button>
		<ul>
			<li><?php echo HTML::anchor('admin/assets/folders/add', __('Add folder'))?></li>
			<li><?php echo HTML::anchor('admin/assets/folders/delete', __('Delete folders'), array('id' => 'delete-folders'))?></li>
		</ul>
	</div>
	<?php echo $breadcrumbs?>
</div>

<table>
	<thead>
		<tr>
			<th>
				<label for="folders-all">
					<?php echo Form::checkbox('folders-all', '1', FALSE); ?>
					Name
				</label>
			</th>
			<th>Date</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($items as $folder){?>
		<tr>
			<td>
				<?php echo Form::checkbox('folder-'.$folder->id, '1', FALSE); ?>
				<?php echo HTML::anchor('admin/assets/folders/edit/'.$folder->id, $folder->name)?>
			</td>
			<td><?php echo $folder->friendly_date?></td>
		</tr>
		<?php }?> 
	</tbody>
	<tfoot>
		<tr>
			<td colspan="2">
				<div style="float:right"><?php echo $pagination->render()?></div>
				Showing <?php echo $items->count()?> of <?php echo $total?> Folders
			</td> 
		</tr>   
	</tfoot>   
</table>
