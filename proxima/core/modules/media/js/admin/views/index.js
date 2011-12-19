(function(data){

	define([
		'underscore',
		'backbone'
	], function(_, Backbone){

		var IndexView = Backbone.View.extend({
			el: $('body'),
			initialize: function(){

			}
		});

		return IndexView;
	});

})(this.AppData);
