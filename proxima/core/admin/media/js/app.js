(function($){

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

	window.App = App;

})(this.jQuery);
