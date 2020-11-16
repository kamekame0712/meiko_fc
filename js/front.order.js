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

function do_submit()
{
	var q = 0;
	var flg_product = false;
	$('input[name^="num_"]').each( function(index, element) {
		flg_product = true;
		q += parseInt($(element).val());
	});

	if( flg_product == false ) {
		swal('商品を選択してください。');
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

	$('#frm_order').prop('action', SITE_URL + 'order/confirm').submit();
	return true;
}