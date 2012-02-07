(function(data){

	var viewPath = data.CORPATH + 'tags/media/js/admin/views/';

	data.scripts.push(
		viewPath + 'index.js',
		viewPath + 'edit.js',
		viewPath + 'add.js'
	);

	require(data.scripts, function(_, Backbone, App, IndexView, EditView, AddView){

		var Tags = Backbone.Router.extend({
			routes: {
				'admin/tags': 'index',
				'admin/tags/edit/:id': 'edit',
				'admin/tags/add': 'add',
			},
			index: function(){
				new IndexView;
			},
			edit: function(id){
				new EditView;
			},
			add: function(id){
				new AddView;
			}
		});

		$(function(){
			(new App).route(Tags);
		});
	});

})(this.AppData);
