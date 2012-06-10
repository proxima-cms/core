<div class="row-fluid">

	<div class="span3">
		<div class="well sidebar-nav">
			<ul class="nav nav-list">
				<li class="nav-header">Actions</li>
				<li><?php echo HTML::anchor(Route::get('admin/assets-folders')
					->uri(array(
						'controller'=> 'folders',
						'action' => 'add'
					)), __('Add folder'))?>
				</li>
			</ul>
	  </div><!--/.well -->
	</div>

	<div class="span9">
		<div class="page-header">
			<h1>Asset folders</h1>
		</div>

		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Name</th>
					<th>Date</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($items as $folder){?>
				<tr>
					<td>
						<?php echo Form::checkbox('folder-'.$folder->id, '1', FALSE); ?>
						<?php echo HTML::anchor(Route::get('admin/assets-folders')->uri(array('action' => 'edit', 'id' => $folder->id)), $folder->name)?>
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
	</div>
</div>
