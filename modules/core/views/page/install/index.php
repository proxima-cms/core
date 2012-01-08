<div id="install">
	<div id="content">
		<div class="section install">

		<?php echo Form::open(NULL, array('id' => 'install-form', 'data-errors' => count($errors)))?>
			<fieldset>
				<?php if (Core::$is_installed){?>
					<br />
					<p>
						It appears that the Proxima CMS is already installed.
					</p>
					<p>
						Note!! You should remove this installer for public sites.
					</p>
					<p>
						Would you like to
						<?php echo HTML::anchor(Route::get('install')->uri(array('action' => 'uninstall')), 'uninstall');?>?
					</p>

				<?php } else {?>

					<h1>
						<?php echo HTML::anchor('install/tests', __('Tests'), array('style' => 'float:right;font-size:.6em;margin-top:4px;')); ?>
						Install Proxima CMS
					</h1>

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

						<div style="padding-top:.5em">
							<?php echo Form::submit('signin', 'Install', array('class' => 'ui-button default'))?>

							<span id="loading">
								<?php echo HTML::image(Core::path('media/img/admin/ajax_loader_small.gif')); ?>
								<span>
									Please wait...
								</span>
							</span>
						</div>

					<?php } else { ?>

						<?php echo nl2br($migration); ?>

						<p>
							Proxima CMS is now installed! You can now
							<?php echo HTML::anchor('admin/auth/signin', 'Sign in >>'); ?>
						</p>

					<?php }?>

				<?php }?>

				</fieldset>
			<?php echo Form::close()?>
		</div>
	</div>
</div>
