var flg_tbl_show;
var wk_order_id;
var dropping;

jQuery( function($) {
	flg_tbl_show = false;
	wk_order_id = '';
	dropping = false;

	$("#regist_time_from, #regist_time_to").datepicker({
		dateFormat: 'yy-mm-dd'
	});

	do_bootgrid();

	if( result == 'ok' ) {
		show_success_notification('処理が完了しました。');
	}
	else if( result == 'mail_err1' ) {
		show_error_notification('メール送信に失敗しました。');
	}
	else if( result == 'mail_err2' ) {
		show_error_notification('データベースエラーが発生しました。<br>メールは送信されていません。');
	}
});

function clear_conditions()
{
	$('#order_id_from').val('');
	$('#order_id_to').val('');
	$('#classroom_name').val('');
	$('#smile_code').val('');
	$('#order_status').val('0');
	$('#payment_method1').prop('checked', true);
	$('#payment_method2').prop('checked', true);
	$('#payment_method3').prop('checked', true);
	$('#regist_time_from').val('');
	$('#regist_time_to').val('');
}

function do_search()
{
	if( flg_tbl_show == false ) {
		do_bootgrid();
	}
	else {
		$('#tbl_order').bootgrid('reload');
	}
}

function do_bootgrid()
{
	$('#tbl_order').bootgrid({
		ajax: true,
		url: SITE_URL + 'admin/order/get_bootgrid',
		formatters: {
			'col_checkbox': function(column, row) {
				return '<input type="checkbox" name="chk_target[]" value="' + row.order_id + '">';
			},
			'col_proc': function(column, row) {
				return '<a href="' + SITE_URL + 'admin/order/detail/' + row.order_id + '"><i class="fas fa-info"></i>&nbsp;詳細</a>&nbsp;&nbsp;&nbsp;' +
					   '<a href="' + SITE_URL + 'admin/order/send_mail/' + row.order_id + '"><i class="far fa-envelope"></i>&nbsp;メール送信</a>';
		   }
		},
		rowCount: [20, 30, 50, -1],
		requestHandler: function(request) {
			request['order_id_from'] = $('#order_id_from').val();
			request['order_id_to'] = $('#order_id_to').val();
			request['classroom_name'] = $('#classroom_name').val();
			request['smile_code'] = $('#smile_code').val();
			request['order_status'] = $('#order_status').val();
			request['payment_method1'] = $('#payment_method1').prop('checked') ? 1 : 0;
			request['payment_method2'] = $('#payment_method2').prop('checked') ? 1 : 0;
			request['payment_method3'] = $('#payment_method3').prop('checked') ? 1 : 0;
			request['regist_time_from'] = $('#regist_time_from').val();
			request['regist_time_to'] = $('#regist_time_to').val();

			return request;
		}
	})
	.on('loaded.rs.jquery.bootgrid', function(e) {
		flg_tbl_show = true;
		$('.search').css('display', 'none');
	});
}

function check_all()
{
	$('[name="chk_target[]"]').each( function() {
		$(this).prop('checked', true);
	});
}

function uncheck_all()
{
	$('[name="chk_target[]"]').each( function() {
		$(this).prop('checked', false);
	});
}

function dl_order(kind)
{
	var order_ids = [];
	var flg_exists = false;
	$('[name="chk_target[]"]:checked').each( function() {
		order_ids.push(this.value);
		flg_exists = true;
	});

	if( !flg_exists ) {
		show_error_notification('対象の受注にチェックを付けてください。');
		return;
	}

	var url = '';
	if( kind == 1 ) {
		url = SITE_URL + 'admin/order/dl_smile';
	}
	else {
		url = SITE_URL + 'admin/order/dl_pdf';
	}

	$('<form/>', {'action': url, 'method': 'post'})
		.append($('<input/>', {'type': 'hidden', 'name': 'order_ids', 'value': order_ids.join(',')}))
		.appendTo(document.body)
		.submit();
}

function change_status()
{
	var order_ids = [];
	var flg_exists = false;
	$('[name="chk_target[]"]:checked').each( function() {
		order_ids.push(this.value);
		flg_exists = true;
	});

	if( dropping == false ) {
		if( $('#status_list').css('display') == 'none' ) {
			if( !flg_exists ) {
				show_error_notification('対象の受注にチェックを付けてください。');
				return;
			}
			else {
				dropping = true;
				$('#status_list').slideDown('', function() {
					dropping = false;
				});
			}
		}
		else {
			dropping = true;
			$('#status_list').slideUp('', function() {
				dropping = false;
			});
		}
	}
}

$('#status_list > li').click( function() {
	var order_ids = [];
	var flg_exists = false;
	$('[name="chk_target[]"]:checked').each( function() {
		order_ids.push(this.value);
		flg_exists = true;
	});

	if( !flg_exists ) {
		show_error_notification('対象の受注にチェックを付けてください。');
		return;
	}
	else {
		$.ajax({
			url: SITE_URL + 'admin/order/ajax_change_status',
			type:'post',
			cache:false,
			data: {
				order_ids: order_ids.join(','),
				order_status: $(this).data('status')
			}
		})
		.done( function(ret, textStatus, jqXHR) {
			if( ret['status'] ) {
				$('#tbl_order').bootgrid('reload');
				show_success_notification('処理が完了しました。');
			}
			else {
				show_error_notification(ret['err_msg']);
			}
		})
		.fail( function(data, textStatus, errorThrown) {
			show_error_notification(textStatus);
		})
		.always( function(data, textStatus) {
			dropping = true;
			$('#status_list').slideUp('', function() {
				dropping = false;
			});
		});
	}
});


function cancel_order(order_id, regist_time, classroom_name, total_cost)
{
	wk_order_id = order_id;
	$('#modal_classroom').val(classroom_name);
	$('#modal_regist_time').val(regist_time);
	$('#modal_total_cost').val(total_cost);

	$('#modal_order').modal();
}

function do_submit()
{
	$.ajax({
		url: SITE_URL + 'admin/order/ajax_cancel',
		type:'post',
		cache:false,
		data: {
			order_id: wk_order_id
		}
	})
	.done( function(ret, textStatus, jqXHR) {
		if( ret['status'] ) {
			$('#modal_order').modal('hide');
			$('#tbl_order').bootgrid('reload');
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
