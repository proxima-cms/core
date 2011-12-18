define([
	'order!jquery',
	'order!underscore',
	'order!backbone',
	'order!ui'
], function($, _, Backbone){

	var initialize = function(){
		$('body').ui();
	}

	return {
		initialize: initialize,
		route: function(Router){

			var router = new Router;

			Backbone.history.start({ pushState: true });
		}
	};
});
