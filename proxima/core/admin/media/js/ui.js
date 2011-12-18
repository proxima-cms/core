define([
	'order!jquery',
	'order!libs/jquery-ui/build/dist/jquery-ui-1.9pre/ui/jquery-ui',
	'order!libs/jquery-ui-selectmenu/jquery.ui.selectmenu',
	'order!libs/jquery-tree/js/jquery.tree'
], function($, _, Backbone){

	var ui = function(selector){
	
		var elem = $(selector);

		// Messages
		elem.find('#messages').children().length 
		
			&& $('#messages')
				.bind('show', function(){
					$(this)
					.fadeIn('fast')
					.effect("highlight", {}, 1000);			
				})
				.trigger('show');

		// Selectmenu
		elem.find('select')
			.selectmenu({
				transferClasses: true
			});

		// Save Button
		elem.find('.ui-button.save')
			.button({
				icons: { primary: "ui-icon-disk" }
			});
			
		// Lightbox
		//elem.find('.ui-lightbox').lightbox();

		// Default Button
		elem.find('.ui-button.default').button();
		
		function openmenu(menu, btn){
			
			if (menu.is(":visible")) {
				menu.hide();
				return false;
			}
			menu
				.menu("deactivate")
				.css({top:0, left:0})
				.show();
				
			var width = menu.width(), 
				splitwidth = (btn.width() + btn.prev().width()) - 3;
			
			(menu.width() < splitwidth) && menu.width(splitwidth);

			menu.position({
				my: "right top",
				at: "right bottom",
				of: btn[0]
			});
			
			setTimeout(function(){
				$(document).one("click", function() {
					menu.hide();
					btn.removeClass('ui-state-active').unbind('mouseleave.admin.button');
				});
			});
		}
		
		// Split button
		elem
			.find('.ui-buttonset')
			.buttonset()
			.find('button:first')
			.button()
			.bind('redirect', function(){
			
				var url = $(this).data('url');
				
				if (url){
					window.location = url;
				}
			})
			.click(function(){
				$(this).trigger('redirect');
			})
			.next()
				.button({
					text: false,
					icons: {
						primary: "ui-icon-triangle-1-s"
					}
				})
				.click(function(event) {
					
					var btn = this;

					$(this)
						.trigger('mousedown.button')
						.bind('mouseleave.admin.button', function(){
							$(this).addClass('ui-state-active');
						});

					openmenu($(this).parent().next(), $(this));
				})
				.parent()
				.next()
					.menu({
						select: function(event, ui) {
							$(this).hide();
							if (ui.item) { window.location = ui.item.find('a').attr('href'); }
						},
						input: $(this)
					}).hide();
				
		// Button Menu
		elem.find('.action-menu button').button({
			icons: {
				primary: "ui-icon-gear",
				secondary: "ui-icon-triangle-1-s"
			}
		})
		.each(function() {
			// Create the menu
			$(this).next().menu({
				selected: function(e, ui){
					// Load the href
					var uri = ui.item.find('a:first')[0].href;
					if (uri) { window.location = uri; }
				}
			}).hide();
		})
		.click(function(event) {
			var btn = this;
			$(this)
				.trigger('mousedown.button')
				.bind('mouseleave.admin.button', function(){
					$(this).addClass('ui-state-active');
				});
	
			openmenu($(this).next(), $(this));			
			return false;
		});

		// Tabs
		elem.find('.tabs').tabs({
			show: function(event, ui) { 
				
				//window.location.hash = ui.tab.hash;
			}
		});
	
		// Datepicker	
		elem.find('.datepicker').datepicker({
			showOn: "both",
			buttonImage: "/modules/admin/media/img/calendar.png",
			buttonImageOnly: true,
			dateFormat: 'yy-mm-dd'
		});

		// Tree node expand/collapse
		function setTreeCookie(event){

			var id = $(this).data('id'), 
				name = (Admin.config.route.controller + '/' + Admin.config.route.action),
				ids = Admin.util.cookie.get(name);
			
			if (!id) return;

			ids = (ids) ? ids.split(',') : [];
			
			if (event.type == 'expand') {

				if ( $.inArray( id.toString(), ids ) !== -1 ){
					return;
				}
				
				ids.push(id.toString());				
							
			} else if (event.type == 'collapse') {
			
				for (var i in ids) {					
					( ids[i] == id ) && ids.splice( i, 1 );
				}
			}
			Admin.util.cookie.set(name, ids.join(','));
		}
	
		elem.find('.ui-tree ul:first').tree({
			onExpand: setTreeCookie,
			onCollapse: setTreeCookie
		})
		// expand the open tree nodes
		.find('.tree-open').trigger('expand', [0]);
	};

	$.fn.ui = function(){
		return this.each(function(){
			ui(this);
		})
	};

});
