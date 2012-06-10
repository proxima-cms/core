(function(){

	var

		$loadText    = $('#loading span').hide(),
		$loading     = $('#loading'),
		$signin      = $('#signin'),
		$installForm = $('#install-form form'),
		$fields      = $('#username,#email,#password,#password_confirm'),
		$options     = $('#options'),

		focus_fields = (function(){
			var hasFocus = false;
			$fields.each(function(key, elem){
				var $field = $(elem);
				if ( !hasFocus && ( $.trim(this.value) === '' || $field.hasClass('error-field') )){
					this.focus();
					hasFocus = true;
					return false;
				}
			});
			return arguments.callee;
		})(),

		showErrors = function(errors){

			$fields.each(function(){

				var 
					$controlGroup = $(this).parents('.control-group'),
					$controls = $controlGroup.find('.controls'),
					$errorMsg = $controls.find('.help-inline')
				;

				if (errors[this.id]) {

					if (!$errorMsg.length){
						$errorMsg = $('<span class="help-inline" />').appendTo($controls);
					}

					$errorMsg
					.hide()
					.html(errors[this.id])
					.fadeIn();

					$controlGroup.addClass('error');
				} else {
					$errorMsg.remove();
					$controlGroup.removeClass('error');
				}
			});

			focus_fields();
		},

		showSuccessMsg = function(errors) {

			var $success = $(errors.success).hide();

			$('#bg').slideUp(500, function(){
				$('#bg').after($success).remove();
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
			console.debug(arguments);
			alert(jqXHR.status + ': ' + errorThrown + "\n" + jqXHR.responseText + "\n\nPlease try again.");
		},

		formSubmit = (function(){

			var timer = null;

			$installForm.submit(function(e){
				e.preventDefault();

				$loadText.hide();
				clearTimeout(timer);
				timer = window.setTimeout(function(){
					//$loadText.fadeIn();
				}, 1500);

				// Remove error messages
				$('.error .help-inline').remove();
				$('.error').removeClass('error');

				$loading.fadeIn();
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
		})(),

		uninstall = (function(){
			$('#uninstall').click(function(){
				return confirm("Are you sure you want to uninstall Proxima CMS?\n\nYou will lose all data!");
			});
		})(),

		options = (function(){
			$('#options-toggle').click(function(e){
				e.preventDefault();
				$options.toggle(300);
			});
		})();
	;
})();
