/*
 *
 * @filename : admin.controllers.js
 * @developer : badsyntax.co
 *
 */
(function(window, $, Admin){
	
	if (!Admin) return;
	
	var cons = Admin.cons;
	
	Admin.controller.tags = {
		
		action_index: function(){
			
			$('#delete-tags').click(function(e){

				e.preventDefault();

				var tags = $('input[type=checkbox][name^=tag]:checked');

				if (!tags.length) {

					alert('Please select some tags to delete.');

				} else {

					var url = '/admin/tags/delete/' + $.map(tags, function(elem){
						return elem.id.replace(/^tag-/, '');
					}).join(',');

					window.location = url;
				}
			});
		}
	
	};
		
})(this, this.jQuery, this.Admin);
