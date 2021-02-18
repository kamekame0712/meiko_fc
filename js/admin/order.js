var flg_tbl_show;

jQuery( function($) {
	flg_tbl_show = false;

	$("#regist_time_from, #regist_time_to").datepicker({
		dateFormat: 'yy-mm-dd'
	});
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
		$('#tbl_order').bootgrid({
			ajax: true,
			url: SITE_URL + 'admin/order/get_bootgrid',
			formatters: {
				'col_checkbox': function(column, row) {
					return '<input type="checkbox" name="chk_target[]" value="' + row.order_id + '">';
				},
				'col_proc': function(column, row) {
					return '<a href="' + SITE_URL + 'admin/order/detail/' + row.order_id + '">'
					+ '<i class="fas fa-info"></i>&nbsp;詳細</a>&nbsp;&nbsp;&nbsp;'
					+ '<a href="javascript:void(0);" onclick="del_order(' + row.order_id + ',\'' + row.regist_time + '\',\'' + row.classroom_name + '\',\'' + row.total_cost + ')">'
					+ '<i class="far fa-trash-alt"></i>&nbsp;削除</a>';
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
			$('#search_result').show();
		});
	}
	else {
		$('#tbl_order').bootgrid('reload');
	}
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
	$('[name="chk_target[]"]:checked').each( function() {
		order_ids.push(this.value);
	});

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