<?php if ($migration === NULL) {?>

	<div class="container">
		<div class="row">
			<div class="span7 offset2 section tests">
				<?php if (Proxima::$is_installed){?>
					<h1>Warning</h1>
					<p>
						You need to disable this installer to continue.
					</p>
					<hr />
					<a href="<?php echo URL::site(Route::get('install')->uri(array('action' => 'disable'))).'?return_to='.Request::current()->query('return_to');?>" class="btn btn-primary">
						Disable installer
					</a>
					&nbsp;&nbsp;
					<a href="<?php echo URL::site(Route::get('install')->uri(array('action' => 'uninstall')));?>" class="btn" id="uninstall" style="float:right">
						Uninstall CMS
					</a>
				<?php } else {?>
					<h1>
						Install
					</h1>
					<?php echo Form::open(NULL, array('data-errors' => count($errors), 'class' => 'form-horizontal'))?>
						<?php echo Message::render(new View('install/message/basic')); ?>
						<legend>Admin account</legend>
						<fieldset>
						

							<?php echo Form::control_group(array(
								'name' => 'username',
								'label' => __('Username'),
								'type' => 'input',
								'value' => $user['username'] ?: 'admin'
							), $errors);?>
							<?php echo Form::control_group(array(
								'name' => 'email',
								'label' => __('Email'),
								'type' => 'input',
								'value' => $user['email'] ?: 'willis.rh@gmail.com'
							), $errors);?>
							<?php echo Form::control_group(array(
								'name' => 'password',
								'label' => __('Password'),
								'type' => 'password',
							), $errors);?>
							<?php echo Form::control_group(array(
								'name' => 'password_confirm',
								'label' => __('Confirm password'),
								'type' => 'password',
							), $errors);?>
						</fieldset>
						<legend>Install options</legend>
						<fieldset>
							<div class="control-group">
								<div class="controls">
									<label class="checkbox">
										<?php echo Form::checkbox('demo_pages'); ?>
										<?php echo __('Install demo pages'); ?>
									</label>
								</div>
							</div>
							<div class="form-actions">
								<button type="submit" id="signin" class="btn btn-large">
									<span></span>
									Install
								</button>

						<?php echo HTML::anchor('install/tests', __('View tests'), array('style' => 'margin-top:4px;margin-left:10px')); ?>

							</div>
						</fieldset>
					<?php echo Form::close()?>
				<?php }?>
			</div>
		</div>
	</div>

<?php  } else { ?>
	<?php echo View::factory('page/install/success', array('migration' => $migration)); ?>
<?php } ?>