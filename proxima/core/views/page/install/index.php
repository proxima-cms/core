<?php if ($migration === NULL) {?>

<div id="bg">

	<div id="content">

		<?php if (Core::$is_installed){?>

			<p id="results" class="fail">Warning</p>
			<p>
				<strong style="font-size:1.1em">You need to disable this installer to continue.</strong>
			</p>
			<div id="options" style="padding-top:.4em;padding-bottom:.6em">
				<a href="<?php echo URL::site(Route::get('install')->uri(array('action' => 'disable')));?>" class="btn tick">
					<span></span>
					Disable installer
				</a>
				&nbsp;&nbsp;
				<a href="<?php echo URL::site(Route::get('install')->uri(array('action' => 'uninstall')));?>" class="btn uninstall" id="uninstall">
					<span></span>
					Uninstall
				</a>
			</div>

		<?php } else {?>

			<div id="install-form">

				<?php echo Form::open(NULL, array('data-errors' => count($errors)))?>
				<fieldset>

						<h1>
							<?php echo HTML::anchor('install/tests', __('Tests'), array('style' => 'float:right;font-size:.6em;margin-top:4px;')); ?>
							Install Proxima CMS
						</h1>

						<?php if ($migration === NULL) {?>

							<h2>Enter the admin account details:</h2>
							<div class="field">
								<?php echo
									Form::label('username', 'Username', NULL, $errors),
									Form::input('username', $user['username'] ?: 'admin', NULL, $errors)
								?>
							</div>
							<div class="field">
								<?php echo
									Form::label('email', 'Email', NULL, $errors),
									Form::input('email', $user['email'] ?: 'test@test.com', NULL, $errors)
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
								<button type="submit" id="signin" class="btn install">
									<span></span>
									Install
								</button>


								<span id="loading">
									<?php echo HTML::image(Core::media('img/admin/ajax_loader_small.gif')); ?>
									<span>
										Please wait...
									</span>
								</span>
							</div>

						<?php }  ?>

					</fieldset>
					<?php echo Form::close()?>
				</div>
			<?php }?>

	</div>
</div>
		<?php  } else { ?>
			<?php echo View::factory('page/install/success', array('migration' => $migration)); ?>
		<?php } ?>
