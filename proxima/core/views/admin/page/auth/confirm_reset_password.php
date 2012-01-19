<?php echo Form::open()?>
	<fieldset>

		<?php echo Form::hidden('auth_token', $token)?>

		<div class="field">
			<?php echo
				Form::label('password', 'Enter a new password', NULL, $errors),
				Form::password('password', NULL, NULL, $errors)
			?>
		</div>
		<div class="field">
			<?php echo
				Form::label('password_confirm', 'Confirm password', NULL, $errors),
				Form::password('password_confirm', NULL, NULL, $errors)
			?>
		</div>

		<?php echo Form::submit('save', 'Save', array('class' => 'btn'))?>
	</fieldset>
<?php echo Form::close()?>
