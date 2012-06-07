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

		<div class="page-header">
			<h1>Edit user</h1>
		</div>

		<div id="edituser" class="tabbable tabs-left"> <!-- Only required for left/right tabs -->
			<ul class="nav nav-tabs">
				<li class="active"><a href="#edit" data-toggle="tab">Edit user</a></li>
				<li><a href="#permissions" data-toggle="tab">User permissions</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="edit">

					<?php echo Form::open(NULL, array('class' => 'form-horizontal'))?>
						<fieldset>

							<?php echo Form::control_group(array(
								'name' => 'username',
								'type' => 'input',
								'label' => __('Username'),
								'value' => $user->username,
								), $errors);?>
							
							<?php echo Form::control_group(array(
								'name' => 'email',
								'type' => 'input',
								'label' => __('Email'),
								'value' => $user->email,
								), $errors);?>
							
							<?php echo Form::control_group(array(
								'name' => 'password',
								'type' => 'password',
								'label' => __('New password'),
								), $errors);?>
							
							<?php echo Form::control_group(array(
								'name' => 'password_confirm',
								'type' => 'password',
								'label' => __('Confirm password'),
								), $errors);?>
							
							<?php echo Form::control_group(array(
								'name' => 'lang',
								'type' => 'select',
								'label' => __('Language'),
								'options' => $langs,
								'value' => $user->lang,
								), $errors);?>

							<div class="control-group">
								<?php echo Form::label('roles', __('Roles'), array('class' => 'control-label')); ?>
								<div class="controls">
									<?php foreach($roles as $role){?>
										<label class="checkbox">
											<?php echo
												Form::checkbox('roles[]', $role->id, in_array($role->id, $user_roles), array('id' => 'role-'.$role->id)),
												$role->name
											?>
										</label>
									<?php }?>
								</div>
							</div>
							
							<div class="control-group">
								<?php echo Form::label('groups', __('Groups'), array('class' => 'control-label')); ?>
								<div class="controls">
									<?php foreach($groups as $group){?>
										<label class="checkbox">
											<?php echo
												Form::checkbox('groups[]', $role->id, in_array($group->id, $user_groups), array('id' => 'role-'.$group->id)),
												$group->name
											?>
										</label>
									<?php }?>
								</div>
							</div>

							<div class="form-actions">
								<?php echo Form::button('save', 'Update', array('class' => 'btn btn-primary'))?>
							</div>
						</fieldset>
					<?php echo Form::close()?>
				</div>
				<div class="tab-pane" id="permissions">
						<p>No permissions are saved for this user.</p>
				</div>
			</div>
		</div>
	</div>
</div>
