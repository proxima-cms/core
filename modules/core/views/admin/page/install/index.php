<div>
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

					<span id="loading" style="display:none">
						<?php echo HTML::image(Core::path('media/img/admin/ajax_loader_small.gif')); ?>
						<span>
							<!--
							Please wait...
							-->
						</span>
					</span>

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
	<script>
	(function(){
		var
			focus_fields = (function(){
				$('#username,#email,#password,#password_confirm').each(function(){
					if (this.value === '' || this.className === 'error-field'){
						this.focus();
						return false;
					}
				});
				return arguments.callee;
			})(),
			showErrors = function(errors){
				$('#username,#email,#password,#password_confirm').each(function(){

					var $label = $('label[for="' + this.id + '"]'),
							$label_error = $label.find('.label-error');

					if (errors[this.id]) {

						if (!$label_error.length){
							$label_error = $('<span class="label-error" />').appendTo($label);
						}

						$label_error
						.hide()
						.html(errors[this.id])
						.fadeIn(100);

						$(this).addClass('error-field');

					} else {
						$label_error.remove();
						$(this).removeClass('error-field');
					}
				});

				focus_fields();
			},
			showSuccessMsg = function(errors) {

				var $success = $(errors.success).hide();

				$('#install-form').slideUp(500, function(){
					$(this).after($success);;
					$success.slideDown(500);
				});
			},
			postSuccess = function(errors) {

				$('#signin').removeAttr('disabled');
				$('#loading').hide();

				// No errors, successful submit
				if (errors.success !== undefined) {

					showSuccessMsg.call(this, errors);

				// Validation errors found
				} else {
					showErrors.call(this, errors);
				}
			},
			formSubmit = (function(){
				$('#install-form').submit(function(e){
					e.preventDefault();

					$.ajax({
						type:     'POST',
						url:      this.action,
						data:     $(this).serialize(),
						dataType: 'json',
						success:  postSuccess
					});

					$('#loading').show();
					$('#signin').attr('disabled', 'disabled');
				});
			})()
		;
	})();
	</script>
</div>
