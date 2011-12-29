(function(data){

	define([
		'underscore',
		'backbone',
	], function(_, Backbone){

		var EditView = Backbone.View.extend({
			el: $('body'),
			events: {
			},
			initialize: function(){
			}
		});

		return EditView;
	});

})(this.AppData);
