(function(data){

	define([
		'underscore',
		'backbone',
	], function(_, Backbone){

		var EditView = Backbone.View.extend({
			el: $('body'),
			$visibleTo: $('#visible_to'),
			events: {
				'change #visible_to_forever':  'visibleTo',
				'click #update-uri': 'updateURI',
				'click #body': 'initWysiwyg'
			},
			initialize: function(){
				if ($.trim($('#body').html()) === '') {
					$('#body').append('<p>(<em>Click here to enter content.</em>)</p>');
				}   
			},
			visibleTo: function(e){
				if (e.target.checked) {
					this.$visible_to.val('');
				} else {
					this.$visible_to.datepicker('setDate', new Date());
				}   
			},
			updateURI: function(e){
				e.preventDefault();

				$.ajax({
					'method': 'GET',
					'url': e.target.href + '&title=' + $('#title').val(),
					'success': function(data){
						$('#uri').val(data);
					}   
				}); 
			},
			initWysiwyg: function(e){ 
				$(e.currentTarget).tinymce(window.tinymce_config);
			}
		});

		return EditView;
	});

})(this.AppData);
