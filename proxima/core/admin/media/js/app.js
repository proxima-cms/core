(function($){

	var App = function(){

		$('body').ui();

		return this;
	};

	App.prototype = {
		route: function(Router){

			if (Router === undefined) {
				throw new Error('App error: router not defined.');
			}

			var router = new Router;

			Backbone.history.start({ pushState: true });
		}
	};

	window.App = App;

})(this.jQuery);
