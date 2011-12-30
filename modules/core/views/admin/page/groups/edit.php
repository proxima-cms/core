<div class="action-bar clear">
	<div class="action-menu helper-right">
		<button>Actions</button>
		<ul>
			<li><?php echo HTML::anchor('admin/groups/delete/'.$group->id, __('Delete group'))?></li>
		</ul>
	</div>

	<?php echo $breadcrumbs?>
</div>

<!-- GROUP -->
<?php echo Form::open()?>
	<fieldset>
		<legend>User Group</legend>

		<div class="field">
			<?php echo 
				Form::label('parent_id', __('Parent group'), NULL, $errors),
				Form::select('parent_id', $groups, $group->parent_id, NULL, $errors)
			?>
		</div>
		<div class="field">
			<?php echo 
				Form::label('name', __('Name'), NULL, $errors),
				Form::input('name', $group->name, NULL, $errors)
			?>
		</div>

		<?php echo Form::button('save', 'Save', array('type' => 'submit', 'class' => 'ui-button save'))?>
	</fieldset>
<?php echo Form::close()?>

<!-- USERS IN THIS GROUP -->
<fieldset>
	<legend>Users in this group</legend>
	<?php echo $users; ?>
</fieldset>

<!-- ADD USER TO THIS GROUP -->
<?php echo Form::open(
	Route::get('admin')
	->uri(array(
		'controller' => 'groups',
		'action' => 'adduser'
	)) . '?return_to=' . Request::current()->uri() );
?>
<?php echo Form::hidden('group_id', $group->id);?>
<fieldset>
	<legend><?php echo __('Add new user to this group'); ?></legend>
	<div class="field">
		<?php echo 
			Form::label('user_id', __('User'), NULL, $errors),
			Form::select('user_id', $users_select, 0, NULL, $errors)
		?>
	</div>
	<?php echo Form::button('save-newuser', __('Add user'), array('type' => 'submit', 'class' => 'ui-button save'))?>
</fieldset>
<?php echo Form::close(); ?>
