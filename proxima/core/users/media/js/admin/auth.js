/*
 *
 * @filename : admin.controllers.js
 * @developer : badsyntax.co
 *
 */
(function(window, $, Admin){
	
	if (!Admin) return;
	
	var cons = Admin.cons;
	
	Admin.controller.auth = {
		
		action_signin: function(){

			var username = $('#username');
			var password = $('#password');

			if (!username.val()){
				username.focus();
			} else if (!password.val()) {
				password.focus();
			}

		}
	
	};
		
})(this, this.jQuery, this.Admin);
