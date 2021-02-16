function register_smile_code(classroom_id)
{
	var smile_code1, smile_code2, smile_code3;

	if( $('#smile_code1_' + classroom_id).length ) {
		smile_code1 = $('#smile_code1_' + classroom_id).val();
	}
	else {
		smile_code1 = '';
	}

	if( $('#smile_code2_' + classroom_id).length ) {
		smile_code2 = $('#smile_code2_' + classroom_id).val();
	}
	else {
		smile_code2 = '';
	}

	if( $('#smile_code3_' + classroom_id).length ) {
		smile_code3 = $('#smile_code3_' + classroom_id).val();
	}
	else {
		smile_code3 = '';
	}

	$.ajax({
		url: SITE_URL + 'admin/owner/ajax_register_smile_code',
		type:'post',
		cache:false,
		data: {
			classroom_id: classroom_id,
			smile_code1: smile_code1,
			smile_code2: smile_code2,
			smile_code3: smile_code3
		}
	})
	.done( function(ret, textStatus, jqXHR) {
		if( ret['status'] ) {
			show_success_notification('処理が完了しました。');
		}
		else {
			show_error_notification(ret['err_msg']);
		}
	})
	.fail( function(data, textStatus, errorThrown) {
		show_error_notification(textStatus);
	});

}
