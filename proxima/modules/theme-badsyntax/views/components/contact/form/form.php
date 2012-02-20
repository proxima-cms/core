<?php echo Form::open()?>

	<fieldset>

		<div class="field">
			<?php echo
				Form::label('name', 'Name', NULL, $errors) .
				Form::input('name', Request::current()->post('name'), NULL, $errors)?>
		</div>

		<div class="field">
			<?php echo
				Form::label('email', 'Email', NULL, $errors) .
				Form::input('email', Request::current()->post('email'), array('type' => 'email'), $errors)
			?>
		</div>

		<div class="field">
			<?php echo
				Form::label('message', 'Message', NULL, $errors) .
				Form::textarea('message', Request::current()->post('message'), NULL, TRUE, $errors)
			?>
		</div>

		<?php echo Form::submit('submit', 'Submit', array('class' => 'button'))?>

	</fieldset>

<?php echo Form::close()?>
