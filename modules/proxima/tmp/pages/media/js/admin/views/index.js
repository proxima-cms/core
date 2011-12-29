(function(data){

	var path = this.AppData.CORPATH + 'pages/media/js/admin/';

	define([
		'underscore',
		'backbone',
		path + 'collections/pages.js',
	], function(_, Backbone, Pages){

		var IndexView = Backbone.View.extend({
			el: $('body'),
			$pageTree: $('#page-tree'),
			initialize: function(){

				var self = this;

				this.collection = new Pages;

				this.collection.model.getTree(function(data){
					self.$pageTree.html(data).parent().ui();
				});
			}
		});

		return IndexView;
	});

})(this.AppData);
