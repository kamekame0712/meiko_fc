jQuery( function($) {
	if( $('#tel01').val() == '' || $('#tel02').val() == '' || $('#tel03').val() == '' ) {
		$('#required_item1').hide();
		$('#required_item2').hide();
	}
	else {
		$('#required_item1').show();

		if( $('#contact_name').val() == '' || $('#email').val() == '' || $('#password_hidden').val() == '' ) {
			$('#required_item2').hide();
		}
		else {
			$('#required_item2').show();
		}
	}
});

$(document).on('keyup', '#tel01, #tel02, #tel03', function() {
	if( $('#tel01').val() != '' && $('#tel02').val() != '' && $('#tel03').val() != '' ) {
		$('#required_item1').slideDown();

		if( $('#contact_name').val() == '' || $('#email').val() == '' || $('#password_hidden').val() == '' ) {
			$('#required_item2').slideUp();
		}
		else {
			$('#required_item2').slideDown();
		}
	}
	else {
		$('#required_item2').slideUp();
		$('#required_item1').slideUp();
	}
});

$(document).on('keyup', '#contact_name, #email, #password_hidden', function() {
	if( $('#contact_name').val() != '' && $('#email').val() != '' && $('#password_hidden').val() != '' ) {
		$('#required_item2').slideDown();
	}
	else {
		$('#required_item2').slideUp();
	}
});

$('#apply_credit').change( function() {
	if( $(this).prop('checked') ) {
		$('#register_credit').slideDown();
	}
	else {
		$('#register_credit').slideUp();
	}
});

