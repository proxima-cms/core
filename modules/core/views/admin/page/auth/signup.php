<?php echo Form::open()?>
	<fieldset>
		<div class="field">
			<?php echo 
				Form::label('username', 'Username', NULL, $errors),
				Form::input('username', $user->username, NULL, $errors)
			?>
		</div>
		<div class="field">
			<?php echo 
				Form::label('email', 'Email', NULL, $errors),
				Form::input('email', $user->email, array('type' => 'email'), NULL, $errors)
			?>
		</div>
		<div class="field">
			<?php echo
				Form::label('password', 'Password', NULL, $errors),
				Form::password('password', NULL, NULL, $errors)
			?>
		</div>
		<div class="field">
			<?php echo
				Form::label('password_confirm', 'Confirm password', NULL, $errors),
				Form::password('password_confirm', NULL, NULL, $errors)
			?>
		</div>

		<?php echo Form::submit('signup', 'Sign up', array('class' => 'button'))?>

	</fieldset>
<?php echo Form::close()?>
