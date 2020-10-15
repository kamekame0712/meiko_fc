$('#apply_credit').change( function() {
	if( $(this).prop('checked') ) {
		$('#register_credit').slideDown();
	}
	else {
		$('#register_credit').slideUp();
	}
});

