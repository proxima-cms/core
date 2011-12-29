(function($){

	$(function(){

		/* MODELS */

		var PageModel = Backbone.Model.extend({
			url : function() {
				return 'pages'
			},
			getTree: function(callback){
				$.ajax({
					type: 'HTML',
					url: 'pages/tree',
					success: callback
				});
			}
		});

		/* COLLECTIONS */

		var PageCollection = Backbone.Collection.extend({
			model: new PageModel
		});

		/* VIEWS */

		var IndexView = Backbone.View.extend({
			el: $('body'),
			$pageTree: $('#page-tree'),
			initialize: function(){

				var self = this;

				this.collection = new PageCollection;

				this.collection.model.getTree(function(data){
					self.$pageTree.html(data).parent().ui();
				});
			}
		});

		var EditView = Backbone.View.extend({
			el: $('body'),
			$visibleTo: $('#visible_to'),
			events: {
				'change #visible_to_forever':  'visibleTo',
				'click #update-uri': 'updateURI',
				'click #body': 'initWysiwyg'
			},
			initialize: function(){
				if ($.trim($('#body').html()) === '') {
					$('#body').append('<p>(<em>Click here to enter content.</em>)</p>');
				}   
			},
			visibleTo: function(e){
				if (e.target.checked) {
					this.$visible_to.val('');
				} else {
					this.$visible_to.datepicker('setDate', new Date());
				}   
			},
			updateURI: function(e){
				e.preventDefault();

				$.ajax({
					'method': 'GET',
					'url': e.target.href + '&title=' + $('#title').val(),
					'success': function(data){
						$('#uri').val(data);
					}   
				}); 
			},
			initWysiwyg: function(e){ 
				$(e.currentTarget).tinymce(window.tinymce_config);
			}
		});

		var AddView = Backbone.View.extend({
		initialize: function(){

		}
		});

		var Routes = Backbone.Router.extend({
			routes: {
				'admin/pages': 'index',
				'admin/pages/edit/:id': 'edit',
				'admin/pages/add': 'add',
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

		window.AppRoutes = Routes;

	});

})(this.jQuery);
