(function(data){

	var path = data.CORPATH + 'component/media/js/admin/views/';

	data.scripts.push(
		path + 'index.js',
		path + 'edit.js',
		path + 'add.js'
	);

	require(data.scripts, function(_, Backbone, App, IndexView, EditView, AddView){

		var Components = Backbone.Router.extend({
			routes: {
				'admin/components': 'index',
				'admin/components/edit/:id': 'edit',
				'admin/components/add': 'add',
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
			(new App).route(Components);
		});
	});

})(this.AppData);
