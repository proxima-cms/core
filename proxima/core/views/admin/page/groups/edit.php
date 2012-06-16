
<div class="row-fluid">

  <div class="span3">
    <div class="well sidebar-nav">
      <ul class="nav nav-list">
        <li class="nav-header">Actions</li>
        <li><?php echo HTML::anchor(
            Route::get('admin')
              ->uri(array(
                'controller' => 'groups',
								'action' => 'delete'
              )), __('Delete group'));?>
        </li>
        <li><?php echo HTML::anchor(
            Route::get('admin')
              ->uri(array(
                'controller' => 'groups',
              )), __('Manage groups'));?>
        </li>
      </ul>
    </div><!--/.well -->
  </div>

  <div class="span9">

    <div class="page-header">
      <h1>Add group</h1>
    </div>

		<?php echo Form::open(NULL, array('class' => 'form-horizontal'))?>
			<fieldset>

				<?php echo Form::control_group(array(
					'label' => __('Parent group'),
					'name' => 'parent_id',
					'type' => 'select',
					'options' => $groups,
					'value' => $group->parent_id
				), $errors);?>
				
				<?php echo Form::control_group(array(
					'label' => __('Name'),
					'name' => 'name',
					'type' => 'input',
					'value' => $group->name
				), $errors);?>

				<div class="form-actions">
					<?php echo Form::button('save', 'Save', array('type' => 'submit', 'class' => 'btn btn-primary'))?>
				</div>
			</fieldset>
		<?php echo Form::close()?>

		<!-- USERS IN THIS GROUP -->
		<fieldset>
			<legend>Users in this group</legend>
			<br />
			<?php echo $users; ?>
		</fieldset>

		<!-- ADD USER TO THIS GROUP -->
		<?php echo Form::open(
			Route::get('admin')
			->uri(array(
				'controller' => 'groups',
				'action' => 'adduser'
			)) . '?return_to=' . Request::current()->uri(), array('class' => 'form-horizontal') );
		?>
		<?php echo Form::hidden('group_id', $group->id);?>
		<fieldset>
			<legend><?php echo __('Add new user to this group'); ?></legend>
			<?php echo Form::control_group(array(
				'label' => __('User'),
				'name' => 'user_id',
				'type' => 'select',
				'options' => $users_select,
				'value' => 0
			), $errors);?>
			<div class="form-actions">
				<?php echo Form::button('save-newuser', __('Add user'), array('type' => 'submit', 'class' => 'btn btn-primary'))?>
			</div>
		</fieldset>
		<?php echo Form::close(); ?>
	</div>
</div>

