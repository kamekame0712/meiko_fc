jQuery( function($) {
	if( $('#classroom_number').val() != '' ) {
		$('#classroom_name').show();
		$('#required_item').show();
	}
});

$(document).on('keyup', '#classroom_number', function() {
	if( $(this).val().length == 4 ) {
		$.ajax({
			url: SITE_URL + 'entry/ajax_get_classroom',
			type:'post',
			cache:false,
			data: {
				classroom_number: $('#classroom_number').val()
			}
		})
		.done( function(ret, textStatus, jqXHR) {
			$('#show_classroom_name').html(ret['classroom_name']);

			if( ret['status'] ) {
				$('#classroom_name').slideDown();
				$('#required_item').slideDown();
			}
			else {
				swal(ret['err_msg']);
				$('#required_item').hide();
				if( ret['classroom_name'] != '' ) {
					$('#classroom_name').slideDown();
				}
				else {
					$('#classroom_name').hide();
				}
			}
		});
	}
});

$(document).on('keyup change', '#password_hidden', function() {
	$('#password_show').val($(this).val());
});

$(document).on('keyup change', '#password_show', function() {
	$('#password_hidden').val($(this).val());
});

$('#chk_pw').change( function() {
	if( $(this).prop('checked') ) {
		$('#password_hidden').hide();
		$('#password_show').show();
	}
	else {
		$('#password_show').hide();
		$('#password_hidden').show();
	}
});
