/*
 *
 * @filename : admin.js
 * @developer : badsyntax.co
 *
 */
(function(window, $, Admin){
	
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
			
			if ($.trim($('#body').html()) === '') {
				$('#body').append('<p>(<em>No data</em>)</p>').one('click', function(){
					$('#body').html('');
				});
			}

			$('#body').click(function(){
				console.debug(window.tinymce_config);
				$(this).tinymce(window.tinymce_config);
			});
		}
	};
	
})(this, this.jQuery, this.Admin);
