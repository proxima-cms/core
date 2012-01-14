// auth.js

$(function(){

	$('input').each(function(key, elem){
		if ( $.trim(this.value) === '' || $(this).hasClass('error-field') ){
			this.focus();
			return false;
		}
	});

	if ($('#messages').find('li').length){
		$('#messages').fadeIn();
	}

});