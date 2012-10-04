<div class="page-header">
	<h1>Add user</h1>
</div>
<div class="row-fluid">

  <div class="span3">
		<div class="well sidebar-nav">
			<ul class="nav nav-list">
				<li class="nav-header">Actions</li>
				<li><?php echo HTML::anchor(
						Route::get('admin')
							->uri(array(
								'controller' => 'users', 
							)), __('Manage users'));?>
				</li>
			</ul>
	  </div><!--/.well -->
  </div>

  <div class="span9">

		<?php echo Form::open(NULL, array('class' => 'form-horizontal'))?>
			<fieldset>
				<legend>Account</legend>
				<div class="control-group<?php echo Form::error_css('username', $errors);?>">
					<?php echo Form::label('username', __('Username'), array('class' => 'control-label'), $errors);?>
					<div class="controls">
						<?php echo Form::input('username',	$user->username, NULL, $errors) . Form::error_msg('username', $errors);?>
					</div>
				</div>
				<div class="control-group<?php echo Form::error_css('email', $errors)?>">
					<?php echo Form::label('email', __('Email'), array('class' => 'control-label'), $errors);?>
					<div class="controls">
						<?php echo Form::input('email', $user->email, array('type' => 'email'), $errors) . Form::error_msg('email', $errors) ?>
					</div>
				</div>
				<div class="control-group<?php echo Form::error_css('password', $errors);?>">
					<?php echo Form::label('password', __('New password'), array('class' => 'control-label'), $errors); ?>
					<div class="controls">
						<?php echo Form::password('password', NULL, NULL, $errors) . Form::error_msg('password', $errors); ?>
					</div>
				</div>
				<div class="control-group<?php echo Form::error_css('password_confirm', $errors);?>">
					<?php echo Form::label('password_confirm', __('Confirm password'), array('class' => 'control-label'), $errors); ?>
					<div class="controls">
						<?php echo Form::password('password_confirm', NULL, NULL, $errors) . Form::error_msg('password_confirm', $errors) ?>
					</div>
				</div>
			</fieldset>
			<div class="control-group<?php echo Form::error_css('lang', $errors);?>">
				<?php echo Form::label('lang', 'Language', array('class' => 'control-label'), $errors); ?>
				<div class="controls">
					<?php echo Form::select('lang', $langs, $user->lang, NULL, $errors) . Form::error_msg('lang', $errors) ?>
			</div>
			<fieldset>
				<legend>Roles</legend>
				<div class="control-group">
					<div class="controls">
					<?php foreach($roles as $role){?>
					<label class="checkbox">
						<?php
						echo
							Form::checkbox('roles[]', $role->id, in_array($role->id, $user_roles), array('id' => 'role-'.$role->id)),
							$role->name
						?>
					</label>
					<?php }?>
				</div>
			</fieldset>
			<fieldset>
				<legend>Groups</legend>
				<div class="controls">
					<?php foreach($groups as $group){?>
					<label class="checkbox">
						<?php echo
							Form::checkbox('groups[]', $group->id, in_array($group->id, $user_groups), array('id' => 'group-'.$group->id)),
							Form::label('group-'.$group->id, $group->name)
						?>
					</label>
					<?php }?>
				</div>
			</fieldset>
			<div class="form-actions">
				<?php echo Form::button('save', 'Save', array('class' => 'btn btn-primary'))?>
			</div>
		<?php echo Form::close()?>
	</div>
</div>
