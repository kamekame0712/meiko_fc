var subwin_product;
function choose_product()
{
	if( subwin_product === void 0 ) {
		$('#frm_order').prop('action', SITE_URL + 'order').submit();
		subwin_product = window.open(SITE_URL + 'order/choose_product', 'window_choose_product', 'width=1024, height=800, menubar=no, toolbar=no, scrollbars=yes');
	}
	else {
		if( subwin_product.closed ) {
			$('#frm_order').prop('action', SITE_URL + 'order').submit();
			subwin_product = window.open(SITE_URL + 'order/choose_product', 'window_choose_product', 'width=1024, height=800, menubar=no, toolbar=no, scrollbars=yes');
		}
		else {
			swal('ウィンドウはすでに開かれています。');
		}
	}
}

$('input[name^="num_"]').change( function() {
	$.ajax({
		url: SITE_URL + 'order/ajax_change_quantity',
		type:'post',
		cache:false,
		data: {
			product_id: $(this).data('id'),
			quantity: $(this).val()
		}
	})
	.done( function(ret, textStatus, jqXHR) {
		if( ret['status'] ) {
			$('#frm_order').prop('action', SITE_URL + 'order').submit();
		}
		else {
			swal('数量変更に失敗しました。').then( function(val) {
				$('#frm_order').prop('action', SITE_URL + 'order').submit();
			});
		}
	})
	.fail( function(data, textStatus, errorThrown) {
		swal(textStatus).then( function(val) {
			$('#frm_order').prop('action', SITE_URL + 'order').submit();
		});
	});
});

$('input[name="payment_method"]').change( function() {
	if( $('input[name="payment_method"]:checked').val() == '2' ) {
		$('#credit').slideDown();
	}
	else {
		$('#credit').slideUp();
	}
});

function change_card(flg)
{
	if( flg == 1 ) {
		$('#registered').slideUp('normal', function(){
			$('#newly').slideDown();
		});
	}
	else {
		$('#newly').slideUp('normal', function(){
			$('#registered').slideDown();
		});
	}
}

function do_submit()
{
	var q = 0;
	var flg_product = false;
	$('input[name^="num_"]').each( function(index, element) {
		flg_product = true;
		q += parseInt($(element).val());
	});

	if( flg_product == false ) {
		swal('教材を選択してください。');
		return false;
	}

	if( q == 0 ) {
		swal('数量の合計が0冊です。');
		return false;
	}

	if( $('#pm1').prop('checked') == false && $('#pm2').prop('checked') == false && $('#pm3').prop('checked') == false ) {
		swal('お支払方法を選択してください。');
		return false;
	}

	if( $('#pm2').prop('checked') ) {
		if( $('#registered').css('display') == 'block' ) {
			var card_no = '';

			$('input[name="registered_card"]').each(function(index, element) {
				if( $(element).prop('checked') ) {
					card_no = $(element).data('cardno');
				}
			});

			if( card_no == '' ) {
				swal('お支払に使用するカードを選択してください。');
				return false;
			}
			else {
				$('#gmo_maskedCardNo').val(card_no);
				$('#card_type').val('1');
				$('#frm_order').prop('action', SITE_URL + 'order/confirm').submit();
			}
		}
		else {
			if( $('#number').val() == '' ) {
				swal('カード番号は必須です。');
				return false;
			}

			if( $('#security_code').val() == '' ) {
				swal('セキュリティコードは必須です。');
				return false;
			}

			if( $('#holder').val() == '' ) {
				swal('名義人名は必須です。');
				return false;
			}

			Multipayment.init('tshop00022859');
			Multipayment.getToken({
				cardno: $('#number').val(),
				expire: $('#limit_y').val() + $('#limit_m').val(),
				securitycode: $('#security_code').val(),
				holdername : $('#holder').val()
			},callback_gmo);
		}
	}
	else {
		$('#frm_order').prop('action', SITE_URL + 'order/confirm').submit();
	}
	return true;
}

function callback_gmo(response)
{
	var resultCode = response.resultCode;

	if( resultCode == '000' ) {
		// カード情報はPOSTさせない
		$('#number').val('');
		$('#limit_y').val('');
		$('#limit_m').val('');
		$('#security_code').val('');
//		$('#holder').val('');

		$('#gmo_token').val(response.tokenObject.token);
		$('#gmo_maskedCardNo').val(response.tokenObject.maskedCardNo);
		$('#card_type').val('2');
		$('#frm_order').prop('action', SITE_URL + 'order/confirm').submit();
	}
	else if( resultCode == '100' || resultCode == '101' || resultCode == '102' ) {
		swal('カード番号に誤りがあります。');
	}
	else if( resultCode == '110' || resultCode == '111' || resultCode == '112' || resultCode == '113' ) {
		swal('有効期限に誤りがあります。');
	}
	else if( resultCode == '121' || resultCode == '122' ) {
		swal('セキュリティコードに誤りがあります。');
	}
	else if( resultCode == '131' || resultCode == '132' ) {
		swal('名義人名に誤りがあります。');
	}
	else {
		swal('クレジット決済時にエラーが発生しました。');
	}
}
