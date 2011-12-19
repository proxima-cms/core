this.AppData.scripts.push(
	this.AppData.CORPATH + 'assets/media/js/admin/views/assets/index.js',
	this.AppData.CORPATH + 'assets/media/js/admin/views/assets/edit.js',
	this.AppData.CORPATH + 'assets/media/js/admin/views/assets/upload.js'
);

require(this.AppData.scripts, function($, _, Backbone, App, IndexView, EditView, UploadView){

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

	$(function(){
		(new App).route(assets);
	});
});
