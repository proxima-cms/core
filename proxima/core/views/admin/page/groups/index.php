<div class="row-fluid">

  <div class="span3">
    <div class="well sidebar-nav">
      <ul class="nav nav-list">
        <li class="nav-header">Actions</li>
        <li><?php echo HTML::anchor(
            Route::get('admin')
              ->uri(array(
                'controller' => 'groups',
                'action' => 'add'
              )), __('Add group'));?>
        </li>
      </ul>
    </div><!--/.well -->
  </div>

  <div class="span9">
    <div class="page-header">
      <h1>Groups</h1>
    </div>

		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Date</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($items as $group){?>
				<tr>
					<td><?php echo $group->id;?></td>
					<td>
						<?php echo HTML::anchor('admin/groups/edit/'.$group->id, $group->name)?>
					</td>
					<td><?php echo $group->friendly_date?></td>
				</tr>
				<?php }?> 
			</tbody>
			<tfoot>
				<tr>
					<td colspan="4">
						<div style="float:right"></div>
						Showing <?php echo $items->count()?> of <?php echo $total?> groups
					</td> 
				</tr>   
			</tfoot>   
		</table>
	</div>
</div>
