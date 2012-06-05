
$(function(){

	var tabs = $('.tabs'),
		tab_a_selector = '.nav-tabs a';
	
	tabs.find( tab_a_selector ).click(function(e){
		
		e.preventDefault();
		
		$(this).tab('show');

		var state = {},
			// Get the id of this tab widget.
			id = $(this).closest( '.tabs' ).attr( 'id' ),
			// Get the index of this tab.
			idx = $(this).parent().prevAll().length;
		
		// Set the state!
		state[ id ] = idx;
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


});

