define([
	'underscore',
	'backbone', 
	'ui'
], function(_, Backbone){

	var App = function(){

		$('body').ui();

		return this;
	};

	App.prototype = {
		route: function(Router){

			var router = new Router;

			Backbone.history.start({ pushState: true });
		}
	};

	return App;
});
