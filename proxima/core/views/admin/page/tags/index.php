
<div class="row-fluid">

	<div class="span3">
		<?php echo View::factory('admin/page/tags/sidebar');?>
	</div>

	<div class="span9">
		<div class="page-header">
			<h1>Tags</h1>
		</div>

		<table class="table table-bordered table-striped">
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
	</div>
</div>
