/*
 *
 * @filename : admin.controllers.js
 * @developer : badsyntax.co
 *
 */
(function(window, $, Admin){
	
	if (!Admin) return;
	
	var cons = Admin.cons;
	
	Admin.controller.pages = {
		
		action_index: function(){

			Admin.model.page.getTree('#page-tree');
		},
		
		action_add: function(){
		},
		
		action_edit: function(){
			var $visible_to = $('#visible_to');

			$('#visible_to_forever').change(function(){
				if (this.checked) {
					$visible_to.val('');
				} else {
					$visible_to.datepicker('setDate', new Date());
				}
			});

			$('#update-uri').click(function(e){
				e.preventDefault();

				$.ajax({
					'method': 'GET',
					'url': this.href + '&title=' + $('#title').val(),
					'success': function(data){
						$('#uri').val(data);
					}
				});
			});
		}
	};
	
	Admin.controller.wysiwyg = {
	
		action_index: function(){
			
			// load and initiate wysiwyg
			require([Admin.config.paths.tinymce, Admin.config.paths.tinymce_init], function() {

			});
		}
	};

	Admin.controller.users = {
	
		action_index: function(){
			
		},
		
		action_add: function(){
			
			Admin.model.group.getTree('#groups-tree', function(){
				$('#groups-tree ul:first').tree({
					checkbox: true,
					checkboxName: 'groups'
				});
			});
		}
	};
	
	Admin.controller.groups = {
	
		action_index: function(){
			
			Admin.model.group.getTree('#groups-tree');
		},
		
		action_add: function(){
			
			Admin.util.validate({
				redirect_url: '/admin/groups'
			});
		},
		
		action_edit: function(){
			
			Admin.util.validate({
				redirect_url: window.location.toString()
			});
		}
	};
	
	Admin.controller.roles = {
	
		action_add: function(){
			
			Admin.util.validate({
				redirect_url: '/admin/roles'
			});
		},
		
		action_edit: function(){
			
			Admin.util.validate({
				redirect_url: window.location.toString()
			});
		}
	};
	
		
})(this, this.jQuery, this.Admin);
