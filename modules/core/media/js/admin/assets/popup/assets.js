(function(window, $){

	$(function(){
		
		/*
		// Stop the loader spinner
		Admin.util.ajax.loader(cons.END, loader);
		
		// Show the messages
		$('#messages').children().length 
			&& $('#messages').show();

		// Show loading spinner on anchors click (fake an ajax request)
		$('#page-links').find('a').click(function(event){
			Admin.util.ajax.loader(cons.BEGIN, loader);
		});
		$('#browse').find('th a').click(function(event){
			Admin.util.ajax.loader(cons.BEGIN, loader);
		});
		//Admin.util.dialog.alert('Attention', $('#messages').html());	
		*/

		var loader = window.parent.$('.ui-dialog.ui-dialog-tinymce .ui-dialog-titlebar .ajax-loader');

		var Tabs = {

			el: $('#content > .tabs'),
			
			create: function(url, id, title, callback) {
				
				title = title || 'Tab';

				if (!$('#'+id).length){
					// Create a new tab
					this.el.tabs('add', '#' + id, title);
				}

				this.el.tabs("select" , id);

				//Admin.util.ajax.loader(cons.BEGIN, loader);

				// Load the tab content
				$('#' + id)
				.html('<p>Loading content...</p>')
				.load(url, function(){
					$(this).ui();
					//Admin.util.ajax.loader(cons.END, loader);
					callback.call();
				});
			}
		};

		var Asset = {
			
			allowedExt: {
				image: [ 'png', 'jpg', 'jpeg', 'gif' ]
			},
			
			insert: function(path, content, type, description) {
				
				var self = this,
					win = tinyMCEPopup.getWindowArg("window"),
					ext = path.split('.').pop().toLowerCase();

				function insertIntoDialog() {

					var fieldId = tinyMCEPopup.getWindowArg('input');

					win.document.getElementById(fieldId).value = path;

					// are we an image browser?
					if (typeof(win.ImageDialog) != "undefined") {

						if ($.inArray(ext, self.allowedExt['image']) === -1) {
							Admin.util.dialog.alert('Attention', 'Please select an image to insert.');
							return;
						}
						
						// Update the description field
						win.document.getElementById('alt').value = description;

						// we are, so update image dimensions...
						(win.ImageDialog.getImageData) && win.ImageDialog.getImageData();

						// ... and preview if necessary
						(win.ImageDialog.showPreviewImage) && win.ImageDialog.showPreviewImage(path);
					}

					// close popup window
					tinyMCEPopup.close();				
				}

				function insertIntoWysiwyg() {

					if (type != 'image'){
						var ed = tinyMCEPopup.editor, 
							el = ed.selection.getNode();

						tinyMCEPopup.restoreSelection();

						// Fixes crash in Safari
						(tinymce.isWebKit) && ed.getWin().focus();
				
						ed.execCommand('mceInsertContent', false, content);
						ed.undoManager.add();

						// close popup window
						tinyMCEPopup.close();
					} else {		
						var ed = tinyMCEPopup.editor,
							el = ed.selection.getNode(),
							args = {
								src : path,
								alt : ''
							};

						tinyMCEPopup.restoreSelection();

						// Fixes crash in Safari
						(tinymce.isWebKit) && ed.getWin().focus();

						if (el && el.nodeName == 'IMG') {
							// update the selected image
							ed.dom.setAttribs(el, args);
						} else {
							// insert a new image
							ed.execCommand('mceInsertContent', false, '<img id="__mce_tmp" />', {skip_undo : 1});
							ed.dom.setAttribs('__mce_tmp', args);
							ed.dom.setAttrib('__mce_tmp', 'id', '');
							ed.undoManager.add();
						}

						// close popup window
						tinyMCEPopup.close();
					}
				}

				function insert() {
					(win)
					? insertIntoDialog()
					: insertIntoWysiwyg();
				}

				if (type === 'image') {

					//Admin.util.ajax.loader(cons.BEGIN, loader);

					$('<img />')
					.load(insert)
					.error(function(){
						//Admin.util.ajax.loader(cons.END, loader);
						alert('There was an error loading the image. Please try again.');
					})
					.attr('src', path);

				} else insert.call();
			}
		};


		var IndexView = Backbone.View.extend({
			el: $('#browse'),
			events: {
				'change #folders': 'changeFolder',
				'click a.asset': 'preview'
			},
			initialize: function(){
				$('table').tableScroll({
					height: 350, 
					width: 'auto'
				});					
			// Add tabs event handlers	
			$('#content > .tabs').bind('tabsshow', function(event, ui) {  

				// Tab name
				var tab = $.trim($(ui.tab).text()).toLowerCase();

				// If selecting the 'browse' tab then show the pagination links, else hide them
				$('#page-links')[ tab === 'browse' ? 'show' : 'hide' ]();

				if ($('#upload-asset').data('button')){
					// Ensure the upload button is enabled
					$('#upload-asset').button('enable');
				}

				//switch(tab){
				//	case 'upload': Routes.upload(); break;
				//}	
			})
			.tabs({
				tabTemplate: '<li><a href="#{href}">#{label}</a> <span class="ui-icon ui-icon-close">Remove Tab</span></li>'
			})
			.find("span.ui-icon-close")
			.live("click", function(){
				var index = $('li', $('#content > .tabs')).index( $(this).parent() );
				$('#content > .tabs').tabs('remove', index);
			});
			},
			preview: function(e) {

				e.preventDefault();

				var anchor = $(e.target), 
					id = anchor.data('id');

				Tabs.create(e.target.href, 'preview-' + id, 'Preview', function(){		
					new ViewView({
						id: id,
						el: $('#preview-' + id),
						mimetype: anchor.data('mimetype'),
						filename: anchor.data('filename')
					});
				});	
			},
			changeFolder: function(e){
				var uri = _.template($('#folder-uri-template').html(), { folder: e.target.value });
				window.location = uri;
			}
		});

		var UploadView = Backbone.View.extend({
			initialize: function(){

				$('#upload-form')
				.unbind('submit')
				.bind('submit', function(event){
					Admin.util.ajax.loader(cons.BEGIN, loader);
					$('#upload-asset').button('disable');
				});

				return;
				$('#asset').uploadify({
					uploade: '/modules/admin/media/flash/uploadify.swf',
					script: '/admin/assets/upload',
					cancelImg: '/modules/admin/media/img/uploadify-cancel.png',
					auto: true,
					debug: true,
					fileDataName: 'asset'
				});  	
			}
		});

		var ResizeView = Backbone.View.extend({

			initialize: function(param){

				this.param = param;
		
				function getImageDimensions(width, height, percent){			
				
					var w = (width / 100) * percent,
						h = (height / 100) * ( (w / width) * 100 );		
						
					return {
						width: Math.round(w),
						height: Math.round(h)
					};
				}
		
				function init(){
					
					//Admin.util.ajax.loader(cons.END, loader);

					var image = $(this), 
						id = image.data('id'),
						tab = $('#resize-' + id),
						width = this.width, 
						height = this.height,
						d = getImageDimensions(width, height, 50),
						elem = {
							wrapper:	tab.find('.resize-image-wrapper'),
							loader:		tab.find('.resize-image-loading'),
							slider:		tab.find('.resize-slider'),
							resizeWidth:	tab.find('.resize-image-dimension-width'),
							resizeHeight:	tab.find('.resize-image-dimension-height'),
							widthMax:	tab.find('.resize-image-width-max'),
							contents:	tab.find('.resize-image-contents'),
							insertResized:	$('#resize-' + id).find('.button-resize-insert')
						};

					this.width = d.width;
					elem.resizeWidth.html(d.width);
					elem.resizeHeight.html(d.height);

					elem.loader.hide();			
					elem.widthMax.html(width + 'px');			
					elem.contents.show();										
					elem.wrapper
						.find('img')
						.remove()
						.end()
						.append(this);

					elem.slider.slider({
						value: 50,
						slide: function(event, ui) {	
							d = getImageDimensions(width, height, ui.value);														
							elem.resizeWidth.html(d.width);
							elem.resizeHeight.html(d.height);
							image.attr('width', d.width)
						}
					});

					elem.insertResized.click(function(e){
						e.preventDefault();
						//Admin.util.ajax.loader(cons.BEGIN, loader);
						elem.insertResized.after(' Generating image...');
						$.get('/admin/assets/get_image_url/' + id + '/' + d.width + '/' + d.height, function(data){				
							Asset.insert($.trim(data), null, 'image');
						})
					});
				}

				// Ensure the image is loaded before building the resize container
				//Admin.util.ajax.loader(cons.BEGIN, loader);
				$('<img />', {
					id: 'resize-image-' + param.id,
					'data-id': param.id
				})
				.load(init)
				.error(function(){			
					alert('There was an error loading the image.');
				})
				.attr('src', param.url);
			}	
		});

		var ViewView = Backbone.View.extend({
			events: {
				'click .insert-asset': 'insertAsset',
				'click .resize-asset': 'resizeAsset'
			},
			insertAsset: function(e){

				e.preventDefault();

				var self = this, mimetype = this.param.mimetype.split('/');
				
				if (mimetype[0] == 'image') {
					
					var width = Number($.trim($('#preview-' + this.param.id).find('.asset-width').text())),
						height = Number($.trim($('#preview-' + this.param.id).find('.asset-height').text()));
						
					function insert(){
						$.get('/admin/assets/get_url/' + self.param.id, function(data){
							var url = $.trim(data);
							Asset.insert(url, null, mimetype[0]);
						});
					}
					
					if (width > 1000 || height > 1000) {
						tinyMCEPopup.editor.windowManager.confirm('The image is larger than 1000 x 1000px, are you sure you want to insert it at this size?', function(s){
							if (s) { insert(); }
						});
					} else insert();
					
				} else {
					$.get('/admin/assets/get_url/' + this.param.id, function(url){
						$.get('/admin/assets/get_download_html/' + self.param.id, function(content){
							Asset.insert($.trim(url), $.trim(content), mimetype[0]);
						});
					});
				}
			},

			resizeAsset: function(e) {
				var self = this;
				e.preventDefault();
				$.get('/admin/assets/get_url/' + this.param.id, function(data){
					var url = $.trim(data);
					if (url) {
						Tabs.create('/admin/assets/popup/resize/' + self.param.id, 'resize-' + self.param.id, 'Resize', function(){
							new ResizeView({id: self.param.id || 0, url: url});	
						});
					}				
				});				
			},
				
			initialize: function(param){

				this.param = param;

				if (!param.id || !param.filename || !param.mimetype) return;
						
				var win, self = this, 
					mimetype = param.mimetype.split('/');						
				
				//(!$('#preview-' + param.id + ' .thumb img')[0].complete) &&
				//	Admin.util.ajax.loader(cons.BEGIN, loader);
							
				$('#preview-' + param.id)
					// Popup lightbox
					//.find('.popup-ui-lightbox')
					//.lightbox({
					//	win: window.parent,
					//	loader_start: function(){
					//		Admin.util.ajax.loader(cons.BEGIN, loader);
					//	},
					//	loader_end: function(){
					//		Admin.util.ajax.loader(cons.END, loader);
					//	}
					//})
					//.end()
			}
		});

		var Routes = Backbone.Router.extend({
			routes: {
				'admin/assets/popup': 'index',
				'admin/assets/popup?*params': 'index',
				'admin/assets/popup/upload': 'upload',
			},
			index: function(){
				new IndexView;
			},
			upload: function(){
				new UploadView;
			},
			view: function(){
				new ViewView;
			},
			resize: function(){
				new ResizeView;
			}
		});

		window.AppRoutes = Routes;
	});
		
})(this, this.jQuery);
