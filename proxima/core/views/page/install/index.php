<?php if ($migration === NULL) {?>

<div class="row-fluid">
	<div class="span7" style="margin:auto;float:none;">
			
		<?php echo View::factory('admin/page/fragments/messages') ?>

		<?php if (Proxima::$is_installed){?>
				
	<div class="page-header">
				<h1>Warning</h1>
						</div>
	

			<p>
				You need to disable this installer to continue.
			</p>
			<div class="form-actions" style="padding-top:.4em;padding-bottom:.6em">
				<a href="<?php echo URL::site(Route::get('install')->uri(array('action' => 'disable'))).'?return_to='.Request::current()->query('return_to');?>" class="btn tick">
					<span></span>
					Disable installer
				</a>
				&nbsp;&nbsp;
				<a href="<?php echo URL::site(Route::get('install')->uri(array('action' => 'uninstall')));?>" class="btn uninstall" id="uninstall">
					<span></span>
					Uninstall CMS
				</a>
			</div>

		<?php } else {?>

			<div id="install-form">
	
				<div class="page-header">
					<h1>
						<?php echo HTML::anchor('install/tests', __('Tests'), array('style' => 'float:right;font-size:.6em;margin-top:4px;')); ?>
						Install Proxima CMS
					</h1>
				</div>

				<?php echo Form::open(NULL, array('data-errors' => count($errors), 'class' => 'form-horizontal'))?>

					<fieldset>

						<?php if ($migration === NULL) {?>

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

							<div class="control-group">
								<label class="control-label">Install options</label>
								<div class="controls">
									<label class="checkbox">
										<?php echo Form::checkbox('demo_pages'); ?>
										<?php echo __('Install demo pages'); ?>
									</label>
								</div>
							</div>

							<div class="form-actions">
								<button type="submit" id="signin" class="btn btn-primary">
									<span></span>
									Install
								</button>

								<span id="loading">
									<?php echo HTML::image(Proxima::media('img/admin/ajax_loader_small.gif')); ?>
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
