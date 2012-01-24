<?php if (!$message_sent){?>

	<?php echo Form::open()?>
		<fieldset>

			<div class="field">
				<?php echo
					Form::label('email', 'Enter your email:', NULL, $errors),
					Form::input('email', $user->email, NULL, $errors)
				?>
			</div>

			<?php echo Form::submit('resetpass', 'Reset password', array('class' => 'ui-button default'))?>

		</fieldset>
	<?php echo Form::close()?>

<?php } else { ?>

	<p>
	 A password reset link has been sent to your email.
	</p>

	<?php echo HTML::anchor(Route::get('admin')->uri(array('controller' => 'auth', 'action' => 'signin')), __('Sign in'), array('class' => 'btn')); ?>

<?php }?>
