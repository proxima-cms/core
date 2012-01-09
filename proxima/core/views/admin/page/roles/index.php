<div class="action-bar clear">
	<div class="action-menu helper-right">
		<button>Actions</button>
		<ul>
			<li><?php echo HTML::anchor('admin/roles/add/', __('Add role'))?></li>
		</ul>
	</div>

	<?php echo $breadcrumbs?>
</div>

<table>
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
