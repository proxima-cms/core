<div>
	<?php echo Form::open()?>
		<fieldset>
			<?php if (Core::$is_installed){?>
				<p>
					It appears that the Proxima CMS is already installed. Would you like to
					<?php echo HTML::anchor(Route::get('install')->uri(array('action' => 'uninstall')), 'uninstall');?>?
				</p>

			<?php } else {?>

				<h1 style="display:block">Install Proxima CMS</h1>

				<?php if ($migration === NULL) {?>

					<h2>Admin account details</h2>
					<div class="field">
						<?php echo
							Form::label('username', 'Username', NULL, $errors),
							Form::input('username', $user['username'], NULL, $errors)
						?>
					</div>
					<div class="field">
						<?php echo
							Form::label('email', 'Email', NULL, $errors),
							Form::input('email', $user['email'], NULL, $errors)
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
							Form::label('password_confirm', 'Password confirm', NULL, $errors),
							Form::password('password_confirm', NULL, NULL, $errors)
						?>
					</div>

					<br />
					<?php echo Form::submit('signin', 'Install!', array('class' => 'ui-button default'))?>

				<?php } else { ?>

					<?php echo nl2br($migration); ?>

					<p>
						Proxima CMS is now installed! You can now
						<?php echo HTML::anchor(Route::get('admin')->uri(array('controller' => 'auth', 'action' => 'signin')), 'Sign in >>'); ?>
					</p>

				<?php }?>

			<?php }?>

		</fieldset>
	<?php echo Form::close()?>
</div>
