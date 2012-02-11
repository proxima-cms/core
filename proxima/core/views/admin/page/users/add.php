<?php echo $breadcrumbs?>

<?php echo Form::open()?>
	<fieldset>
		<legend>Account</legend>
		<div class="field">
			<?php echo
				Form::label('username', __('Username'), NULL, $errors),
				Form::input('username',	$user->username, NULL, $errors)
			?>
		</div>
		<div class="field">
			<?php echo
				Form::label('email', __('Email'), NULL, $errors),
				Form::input('email', $user->email, array('type' => 'email'), $errors)
			?>
		</div>
		<div class="field">
			<?php echo
				Form::label('password', __('New password'), NULL, $errors),
				Form::password('password', NULL, NULL, $errors)
			?>
		</div>
		<div class="field">
			<?php echo
				Form::label('password_confirm', __('Confirm password'), NULL, $errors),
				Form::password('password_confirm', NULL, NULL, $errors)
			?>
		</div>
	</fieldset>
	<div class="field">
		<?php echo
			Form::label('lang', 'Language', NULL, $errors),
			Form::select('lang', $langs, $user->lang, NULL, $errors)
		?>
	</div>
	<fieldset>
		<legend>Roles</legend>
		<div class="field">
			<?php foreach($roles as $role){?>
			<div class="checkbox">
				<?php
				echo
					Form::checkbox('roles[]', $role->id, in_array($role->id, $user_roles), array('id' => 'role-'.$role->id)),
					Form::label('role-'.$role->id, $role->name)
				?>
			</div>
			<?php }?>
		</div>
	</fieldset>
	<fieldset>
		<legend>Groups</legend>
		<div class="field">
			<?php echo
				Form::label('groups', __('Groups'))
			?>
			<?php foreach($groups as $group){?>
			<div class="checkbox">
				<?php echo
					Form::checkbox('groups[]', $group->id, in_array($group->id, $user_groups), array('id' => 'group-'.$group->id)),
					Form::label('group-'.$group->id, $group->name)
				?>
			</div>
			<?php }?>
		</div>
	</fieldset>
	<?php echo Form::button('save', 'Save', array('class' => 'ui-button save'))?>
<?php echo Form::close()?>

