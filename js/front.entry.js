var old_number;

jQuery( function($) {
	old_number = '';

	if( $('#classroom_number').val() != '' ) {
		$('#required_item1').show();
		$('#btn_confirm').show();
	}

	if( $('#flg_parent').val() == '1' ) {
		$('#required_item2').show();
	}

	if( $('#apply_account').prop('checked') ) {
		$('#register_account').show();
	}

	if( $('#corporation1').prop('checked') || $('#corporation2').prop('checked') ) {
		$('#corporation_detail').show();
	}

	if( $('#payment_method1').prop('checked') || $('#payment_method2').prop('checked') ) {
		$('#transfer').show();
	}

});

$(document).on('keyup', '#corporation_zip1, #corporation_zip2', function() {
	AjaxZip3.zip2addr('corporation_zip1', 'corporation_zip2', 'corporation_pref', 'corporation_addr1', 'corporation_addr1');
});

$(document).on('keypress', 'input', function(e) {
	if( e.which == 13 ) {
		return false;
	}
});

$(document).on('keyup', '#classroom_number', function() {
	if( old_number != $(this).val() ) {
		$('#classroom_id').val('');
		$('#classroom_name').val('');
		$('#show_classroom_name').html('');
		$('#flg_parent').val('9');

		$('#registered').hide();
		$('#required_item1').hide();
		$('#required_item2').hide();
		$('#btn_confirm').hide();

		$.ajax({
			url: SITE_URL + 'entry/ajax_get_classroom',
			type:'post',
			cache:false,
			data: {
				classroom_number: $('#classroom_number').val()
			}
		})
		.done( function(ret, textStatus, jqXHR) {
			if( ret['flg_registered'] == true ) {
				$('#registered').slideDown();
			}
			else {
				if( ret['status'] ) {
					$('#classroom_id').val(ret['classroom_id']);
					$('#classroom_name').val(ret['classroom_name']);
					$('#show_classroom_name').html(ret['classroom_name']);

					$('#required_item1').slideDown();

					if( ret['flg_parent'] == true ) {
						$('#required_item2').slideDown();
						$('#flg_parent').val('1');
					}

					$('#btn_confirm').slideDown();
				}
			}
		});
	}
	old_number = $(this).val();
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

$('#apply_account').change( function() {
	if( $(this).prop('checked') ) {
		$('#register_account').slideDown();
	}
	else {
		$('#corporation_detail').slideUp();
		$('#register_account').slideUp('normal', function() {
			$('[name="payment_method"').prop('checked', false);
			$('[name="corporation"').prop('checked', false);
		});
	}
});

$('[name="corporation"').change( function() {
	if( $('#corporation1').prop('checked') ) {
		$('#corporation_detail').slideUp('normal', function() {
			$('#cd_corporation_name').html('法人名');
			$('#corporation_name').prop('placeholder', '中央教育研究所株式会社');
			$('#cd_corporation_address').html('法人住所');
			$('#cd_corporation_tel').html('代表電話番号');
			$('#transfer_name').prop('placeholder', '中央教育研究所株式会社');
			$('[name="payment_method"]').prop('checked', false);
			$('#executive').show();
			$('#transfer').hide();
			$('#corporation_detail').slideDown();
		});
	}
	else {
		$('#corporation_detail').slideUp('normal', function() {
			$('#cd_corporation_name').html('代表者名');
			$('#corporation_name').prop('placeholder', '中央花子');
			$('#cd_corporation_address').html('代表者自宅住所');
			$('#cd_corporation_tel').html('代表者電話番号');
			$('#transfer_name').prop('placeholder', '中央花子');
			$('[name="payment_method"]').prop('checked', false);
			$('#executive').hide();
			$('#transfer').hide();
			$('#corporation_detail').slideDown();
		});
	}
});

$('[name="payment_method"').change( function() {
	if( $('#payment_method1').prop('checked') ) {
		$('#transfer').slideDown();
	}
	else {
		$('#transfer').slideUp();
	}
});

$('#frm_entry').submit( function() {
	if( $('#classroom_number').val() == '' ) {
		swal('教室コード は必須です。');
		return false;
	}

	if( $('#email').val() == '' ) {
		swal('メールアドレス は必須です。');
		return false;
	}

	if( $('#password_hidden').val() == '' ) {
		swal('パスワード は必須です。');
		return false;
	}

	if( $('#password_hidden').val().length < 8 ) {
		swal('パスワード は8文字以上を指定してください。');
		return false;
	}

	if( $('#required_item2').css('display') == 'block' && $('#apply_account').prop('checked') ) {
		if( $('#corporation1').prop('checked') == false && $('#corporation2').prop('checked') == false ) {
			swal('事業形態 を選択してください。');
			return false;	
		}

		if( $('#corporation1').prop('checked') ) {
			if( $('#corporation_name').val() == '' ) {
				swal('法人名 は必須です。');
				return false;
			}

			if( $('#corporation_zip1').val() == '' || $('#corporation_zip2').val() == '' ) {
				swal('法人住所（郵便番号） は必須です。');
				return false;
			}

			if( $('#corporation_pref').val() == '' ) {
				swal('法人住所（都道府県） を選択してください。');
				return false;
			}

			if( $('#corporation_addr1').val() == '' || $('#corporation_addr2').val() == '' ) {
				swal('法人住所 は必須です。');
				return false;
			}

			if( $('#corporation_tel01').val() == '' || $('#corporation_tel02').val() == '' || $('#corporation_tel03').val() == '' ) {
				swal('代表電話番号 は必須です。');
				return false;
			}

			if( $('#corporation_executive').val() == '' ) {
				swal('代表者名 は必須です。');
				return false;
			}
		}
		else {
			if( $('#corporation_name').val() == '' ) {
				swal('代表者名 は必須です。');
				return false;
			}

			if( $('#corporation_zip1').val() == '' || $('#corporation_zip2').val() == '' ) {
				swal('代表者自宅住所（郵便番号） は必須です。');
				return false;
			}

			if( $('#corporation_pref').val() == '' ) {
				swal('代表者自宅住所（都道府県） を選択してください。');
				return false;
			}

			if( $('#corporation_addr1').val() == '' || $('#corporation_addr2').val() == '' ) {
				swal('代表者自宅住所 は必須です。');
				return false;
			}

			if( $('#corporation_tel01').val() == '' || $('#corporation_tel02').val() == '' || $('#corporation_tel03').val() == '' ) {
				swal('代表者電話番号 は必須です。');
				return false;
			}			
		}

		if( $('#payment_method1').prop('checked') == false && $('#payment_method2').prop('checked') == false ) {
			swal('お支払い方法 を選択してください。');
			return false;
		}

		if( $('#payment_method1').prop('checked') && $('#transfer_name').val() == '' ) {
			swal('お振込み名義 は必須です。');
			return false;
		}
	}

	// メールアドレスチェック
	var check_email = false;
	var err_msg = '';
	$.ajax({
		url: SITE_URL + 'entry/ajax_check_email',
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