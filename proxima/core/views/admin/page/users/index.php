<div class="row-fluid">

	<div class="span3">
		<div class="well sidebar-nav">
			<ul class="nav nav-list">
				<li class="nav-header">Actions</li>
				<li><?php echo HTML::anchor(
						Route::get('admin')
							->uri(array(
								'controller' => 'users',
								'action' => 'add'
							)), __('Add user'));?>
				</li>
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
			<h1>Users</h1>
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
				<?php foreach($items as $user){?>
				<tr>
					<td><?php echo $user->id;?></td>
					<td>
						<?php echo HTML::anchor('admin/users/edit/'.$user->id, $user->username)?>
					</td>
					<td><?php echo $user->friendly_date?></td>
				</tr>
				<?php }?> 
			</tbody>
			<tfoot>
				<tr>
					<td colspan="3">
						Showing <?php echo $items->count()?> of <?php echo $total?> users
					</td> 
				</tr>		
			</tfoot>	 
		</table>
	</div>
</div>
