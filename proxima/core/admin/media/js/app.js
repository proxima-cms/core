define([
	'order!jquery',
	'order!underscore',
	'order!backbone',
	'order!ui',
], function($, _, Backbone){

	var initialize = function(){
		// Load in the controller router script
	}

	return {
		initialize: initialize,
		route: function(Router){

			var router = new Router;

			Backbone.history.start({ pushState: true });

			$('body').ui();
		}
	};
});
