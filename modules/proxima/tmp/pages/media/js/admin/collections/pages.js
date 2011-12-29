(function(data){

	var path = data.CORPATH + 'pages/media/js/admin/';

	define([
		'underscore',
		'backbone',
		path + 'models/page.js'
	], function(_, Backbone, Page){

		var pageCollection = Backbone.Collection.extend({
			model: Page
		});

		return pageCollection;
	});

})(this.AppData);
