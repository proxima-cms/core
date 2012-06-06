
<div class="row-fluid">

  <div class="span3">
    <div class="well sidebar-nav">
      <ul class="nav nav-list">
        <li class="nav-header">Actions</li>
        <li><?php echo HTML::anchor(
            Route::get('admin')
              ->uri(array(
                'controller' => 'roles',
								'action' => 'add'
              )), __('Add role'));?>
        </li>
      </ul>
    </div><!--/.well -->
  </div>

  <div class="span9">

    <div class="page-header">
      <h1>Roles</h1>
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
				<?php foreach($items as $role){?>
				<tr>
					<td><?php echo $role->id;?></td>
					<td>
						<?php echo HTML::anchor(
							Route::get('admin')
								->uri(array(
									'controller' => 'roles',
									'action' => 'edit',
									'id' => $role->id
								)), $role->name);
						?>
					</td>
					<td><?php echo $role->friendly_date?></td>
				</tr>
				<?php }?> 
			</tbody>
			<tfoot>
				<tr>
					<td colspan="4">
						<div style="float:right"></div>
						Showing <?php echo $items->count()?> of <?php echo $total?> roles
					</td> 
				</tr>   
			</tfoot>   
		</table>

		<fieldset id="users-information" class="users-information ui-helper-hidden last">
			Showing <span id="total-users"></span> users and roles
		</fieldset>
	</div>
</div>
