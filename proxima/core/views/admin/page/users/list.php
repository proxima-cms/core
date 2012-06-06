<?php if (!count($items)) {?>

	<p><em>No users.</em></p>

<?php } else {?>

	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>Username</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($items as $user){?>
			<tr>
				<td>
					<?php echo HTML::anchor('admin/users/edit/'.$user->id, $user->username)?>
				</td>
			</tr>
			<?php }?> 
		</tbody>
		<tfoot>
			<tr>
				<td colspan="4">
					<div style="float:right"></div>
					Showing <?php echo $items->count()?> users
				</td> 
			</tr>   
		</tfoot>   
	</table>

	<fieldset id="users-information" class="users-information ui-helper-hidden last">
		Showing <span id="total-users"></span> users and groups
	</fieldset>

<?php } ?>
