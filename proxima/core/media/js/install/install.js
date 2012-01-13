(function(){
	var

		$loadText    = $('#loading span').hide(),
		$loading     = $('#loading'),
		$signin      = $('#signin'),
		$installForm = $('#install-form form'),
		$fields      = $('#username,#email,#password,#password_confirm'),

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
					.fadeIn();

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

			$('#install').slideUp(500, function(){
				$('#install').after($success).remove();
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

			var timer = null;

			$installForm.submit(function(e){
				e.preventDefault();

				$loadText.hide();
				clearTimeout(timer);
				timer = window.setTimeout(function(){
					//$loadText.fadeIn();
				}, 1500);

				// Remove error messages
				$('.label-error').remove();
				$('.error-field').removeClass('error-field');

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
		})()
	;
})();