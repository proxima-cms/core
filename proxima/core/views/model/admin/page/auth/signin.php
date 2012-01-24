<div class="section signin">
		<?php echo Form::open()?>
			<fieldset>

				<?php echo Form::hidden('return_to', Arr::get($_REQUEST, 'return_to', 'admin'))?>

				<div class="field">
					<?php echo
						Form::label('username', 'Username', NULL, $errors),
						Form::input('username', @$_REQUEST['username'], NULL, $errors)
					?>
				</div>
				<div class="field">
					<?php echo
						Form::label('password', 'Password', NULL, $errors),
						Form::password('password', NULL, NULL, $errors)
					?>
				</div>
				<div class="field checkbox">
					<?php echo
						Form::checkbox('remember', 1, TRUE, array('id' => 'remember')),
						Form::label('remember', 'Remember me')
					?>
				</div>

				<button class="btn signin" type="submit" style="float:left;margin-right:1em;">
					<span></span>
					Sign in
				</button>

				<span style="float:right;margin-top:.9em;font-size:.9em">

				<?php echo HTML::anchor('/admin/auth/reset', __('Reset password'));?>
				|
				<?php echo HTML::anchor('/admin/auth/signup', __('Sign up'));?>
				</span>

			</fieldset>
		<?php echo Form::close()?>

</div>
