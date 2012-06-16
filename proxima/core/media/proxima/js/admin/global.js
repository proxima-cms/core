$(function(){

	(function tabs() {

		var tabs = $('.tabs, .tabs-left'),
			tab_a_selector = '.nav-tabs a';
		
		tabs.find( tab_a_selector ).click(function(e){
			
			e.preventDefault();
			
			$(this).tab('show');

			var state = {},
				// Get the id of this tab widget.
				id = $(this).closest( '.tabs,.tabs-left' ).attr( 'id' ),
				// Get the index of this tab.
				idx = $(this).parent().prevAll().length;

			
			// Set the state!
			state[ id ] = idx;
			console.debug(state);
			$.bbq.pushState( state );

			if (idx === 2) {
				tinyMCE.init(window.tinymce_config);
			}
		});
		
		$(window)
		.on( 'hashchange', function(e) {
			tabs.each(function(){
				var idx = $.bbq.getState( this.id, true ) || 0;
				$(this).find( tab_a_selector ).eq( idx ).triggerHandler( 'click' );
			});
		})
		.trigger( 'hashchange' ); 
	})();

	(function datepicker() {
		$('.datepicker').datepicker({
			dateFormat: 'yy-mm-dd',
		}).each(function(){
			var $icon =  $('<button class="btn" type="button"><i class="icon-calendar"></i></button>').on('click', function(){
				$icon.prev().focus();
			});
			$(this).wrap('<div class="input-append"></div>').after($icon);
		});
	})();

	(function tablescroller() {
		 $('.assetmanager .table').tableScroll({
		 	height: 430,
			containerClass: 'table table-bordered table-striped tablescroll',
			width: '100%',
			flush: true
		});
	})();


});
