<div class="grid-50 clear">

	<div class="unit first">
		<?php echo Form::open()?>
			<fieldset>

				<?php echo Form::hidden('return_to', $return_to)?>

				<p><a href="<?php echo URL::site('user/signup')?>">Sign up</a> for a new account.</p>

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

				<?php echo Form::submit('signin', 'Sign in', array('class' => 'button', 'style' => 'float:left;margin-right:1em'))?>
					
				<?php echo HTML::anchor('/admin/auth/resetpass', 'Forgot username or password?', array('style' => 'float: left;margin-top:.8em;font-size:.8em'));?>

			</fieldset> 
		<?php echo Form::close()?>
	</div>
</div>
