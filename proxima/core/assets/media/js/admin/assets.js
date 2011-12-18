define([
	'order!jquery',
	'order!underscore',
	'order!backbone',
	'order!app',
	'order!views/assets/index',
	'order!views/assets/edit',
	'order!views/assets/upload'
], function($, _, Backbone, App, IndexView, EditView, UploadView){

	var assets = Backbone.Router.extend({
		routes: {
			'admin/assets': 'index',
			'admin/assets/edit/:id': 'edit',
			'admin/assets/upload': 'upload',
		},
		index: function(){
			new IndexView;
		},
		edit: function(id){
			new EditView;
		},
		upload: function(){
			new UploadView;
		}
	});

	App.route(assets);
});
