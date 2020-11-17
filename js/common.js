var menu_open = false;

jQuery( function($) {

	$('#menu_top').click( function() {
		if( $('#menu_dropdown').css('display') == 'none' ) {
			$('#menu_dropdown').slideDown('fast', function() {
				menu_open = true;
			});
		}
		else {
			$('#menu_dropdown').slideUp('fast');
		}
	});

	$('html,body').click( function() {
		if( menu_open == true ) {
			$('#menu_dropdown').slideUp('fast', function() {
				menu_open = false;
			});
		}
	});

});
