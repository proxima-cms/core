define([
	'underscore',
	'backbone'
], function(_, Backbone){

	var Page = Backbone.Model.extend({
		url : function() {
			return 'pages'
		},
		getTree: function(callback){
			$.ajax({
				type: 'HTML',
				url: 'pages/tree',
				success: callback
			});
		}
	});

	return new Page;
});
