<div>
	<div class="section tests">
	</div>
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
						<a style="float:right;font-size:.6em;margin-top:4px;" href="#">Tests</a>
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
		<script>
		(function(){
			var
				// Elements
				$loadText    = $('#loading span').hide(),
				$loading     = $('#loading'),
				$signin      = $('#signin'),
				$installForm = $('#install-form'),
				$fields      = $('#username,#email,#password,#password_confirm'),

				// Actions
				focus_fields = (function(){
					var hasFocus = false;
					$fields.each(function(key, elem){
						var $field = $(elem);
						if ($field.hasClass('error-field')) {
							$field.blur(function(){
								if ($.trim(this.value) !== '') {
									$field
									.removeClass('error-field')
									.prev()
									.find('.label-error')
									.remove();
								}
							});
						}
						if ( !hasFocus && ( $.trim(this.value) === '' || $field.hasClass('error-field') )){
							this.focus();
							hasFocus = true;
						}
					});
					return arguments.callee;
				})(),

				showErrors = function(errors){
					$fields.each(function(){

						var $label = $('label[for="' + this.id + '"]'),
								$label_error = $label.find('.label-error');

						if (errors[this.id]) {

							if (!$label_error.length){
								$label_error = $('<span class="label-error" />').appendTo($label);
							}

							$label_error
							.hide()
							.html(errors[this.id])
							.show();

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

					$installForm.slideUp(500, function(){
						$(this).after($success);;
						$success.slideDown(500);
					});
				},

				postSuccess = function(errors) {

					$loadText.hide();
					$signin.removeAttr('disabled');
					$loading.hide();

					// No errors, successful submit
					if (errors.success !== undefined) {

						showSuccessMsg.call(this, errors);

					// Validation errors found
					} else {
						showErrors.call(this, errors);
					}
				},

				postError = function(jqXHR, textStatus, errorThrown){
					$loadText.hide();
					$signin.removeAttr('disabled');
					$loading.hide();
					alert(jqXHR.status + ': ' + errorThrown + "\n\nPlease try again.");
				},

				formSubmit = (function(){

					$installForm.submit(function(e){
						e.preventDefault();

						window.setTimeout(function(){
							$loadText.fadeIn();;
						}, 1500);

						// Remove error messages
						$('.label-error').remove();
						$('.error-field').removeClass('error-field');

						$loading.show();
						$signin.attr('disabled', 'disabled');
						$fields.blur();

						$.ajax({
							type:     'POST',
							url:      this.action,
							data:     $(this).serialize(),
							dataType: 'json',
							success:  postSuccess,
							error:    postError
						});
					});
				})()
			;
		})();
		</script>
	</div>
</div>
