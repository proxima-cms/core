(function(data){

	var path = data.CORPATH + 'assets/media/js/admin/views/';

	data.scripts.push(
		path + 'index.js',
		path + 'edit.js',
		path + 'upload.js'
	);

	require(data.scripts, function(_, Backbone, App, IndexView, EditView, UploadView){

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

})(this.AppData);
