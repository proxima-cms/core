<div class="row-fluid">

	<div class="span3">
		<div class="well sidebar-nav">
			<ul class="nav nav-list">
				<li class="nav-header">Actions</li>
				<li><?php echo HTML::anchor(
						Route::get('admin')
							->uri(array(
								'controller' => 'pages/types', 
								'action' => 'add'
							)), __('Add page type'));?>
				</li>
			</ul>
	  </div><!--/.well -->
	</div>

	<div class="span9">
		<div class="page-header">
			<h1>Page types</h1>
		</div>

		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Template</th>
					<th>Date</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($items as $page_type){?>
				<tr>
					<td><?php echo $page_type->id;?></td>
					<td>
						<?php echo HTML::anchor('admin/pages/types/edit/'.$page_type->id, $page_type->name)?>
					</td>
					<td><?php echo $page_type->template?></td>
					<td><?php echo $page_type->friendly_date?></td>
				</tr>
				<?php }?> 
			</tbody>
			<tfoot>
				<tr>
					<td colspan="4">
						<div style="float:right"><?php echo $pagination->render()?></div>
						Showing <?php echo $items->count()?> of <?php echo $total?> page types
					</td> 
				</tr>   
			</tfoot>   
		</table>
	</div>
</div>
