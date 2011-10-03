<div class="action-bar clear">
	<div class="action-menu helper-right">
		<button>Actions</button>
		<ul>
			<li><?php echo HTML::anchor('admin/users/add/', __('Add user'))?></li>
			<li><?php echo HTML::anchor('admin/groups/add/', __('Add group'))?></li>
			<li><?php echo HTML::anchor('admin/roles', __('Edit roles'))?></li>
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
    <?php foreach($users as $user){?>
    <tr>
      <td><?php echo $user->id;?></td>
      <td>
        <?php echo HTML::anchor('admin/users/edit/'.$user->id, $user->username)?>
      </td>
      <td><?php echo $user->date?></td>
    </tr>
    <?php }?> 
  </tbody>
  <tfoot>
    <tr>
      <td colspan="4">
        <div style="float:right"><?php /* echo $user_links*/?></div>
        Showing <?php echo $users->count()?> of <?php echo $total?> tags
      </td> 
    </tr>   
  </tfoot>   
</table>

<fieldset id="users-information" class="users-information ui-helper-hidden last">
	Showing <span id="total-users"></span> users and groups
</fieldset>
