$('#frm_modify').submit( function() {
	if( $('#email').val() == '' ) {
		swal('メールアドレス は必須です。');
		return false;
	}

	if( $('#password').val() != '' ) {
		if( $('#password').val().length < 8 ) {
			swal('パスワード は8文字以上を指定してください。');
			return false;
		}
	}

	// メールアドレスチェック
	var check_email = false;
	var err_msg = '';
	$.ajax({
		url: SITE_URL + 'modify/ajax_check_email',
		type:'post',
		cache:false,
		async: false,
		data: {
			email: $('#email').val()
		}
	})
	.done( function(ret, textStatus, jqXHR) {
		if( ret['status'] ) {
			check_email = true;
		}
		else {
			err_msg = ret['err_msg'];
			check_email = false;
		}
	});

	if( check_email ) {
		return true;
	}
	else {
		swal(err_msg);
		return false;
	}

	return false;
});
