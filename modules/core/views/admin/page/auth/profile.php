<?php echo Form::open()?>
	<fieldset>
		<legend>Profile</legend>
		<div class="field">
			<?php echo 
				Form::label('username', 'Username', NULL, $errors),
				Form::input('username', Request::current()->post('username') ?: $user->username, array('class' => 'test'), $errors)
			?>
		</div>
		<div class="field">
			<?php echo 
				Form::label('email', 'Email', NULL, $errors),
				Form::input('email', Request::current()->post('email') ?: $user->email, array('type' => 'email'), $errors)
			?>
		</div>
		<div class="field">
			<?php echo 
				Form::label('password', 'New password', NULL, $errors),
				Form::password('password', NULL, NULL, $errors)
			?>
		</div>
		<div class="field">
			<?php echo 
				Form::label('password_confirm', 'Confirm password', NULL, $errors),
				Form::password('password_confirm', NULL, NULL, $errors)
			?>
		</div>
	<?php echo Form::button('save', 'Update', array('class' => 'ui-button save'))?>
	</fieldset>
<?php echo Form::close()?>
