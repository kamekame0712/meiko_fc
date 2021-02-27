var flg_tbl_show;
var wk_product_id;

jQuery( function($) {
	flg_tbl_show = false;
	wk_product_id = '';

	do_bootgrid();

	if( result == 'ok' ) {
		show_success_notification('処理が完了しました。');
	}
	else if( result == 'err1' ) {
		show_error_notification('データベースエラーが発生しました。');
	}
	else if( result == 'err2' ) {
		show_error_notification('対象の教材が見つかりません。');
	}
});

function clear_conditions()
{
	$('#product_name').val('');
	$('#smile_code_from').val('');
	$('#smile_code_to').val('');
	$('#publisher').val('');
	$('#flg_market1').prop('checked', true);
	$('#flg_market2').prop('checked', true);
	$('#flg_sales1').prop('checked', true);
	$('#flg_sales2').prop('checked', true);
	$('#flg_sales3').prop('checked', true);
}

function do_search()
{
	if( flg_tbl_show == false ) {
		do_bootgrid();
	}
	else {
		$('#tbl_product').bootgrid('reload');
	}
}

function do_bootgrid()
{
	$('#tbl_product').bootgrid({
		ajax: true,
		url: SITE_URL + 'admin/product/get_bootgrid',
		formatters: {
			'col_proc': function(column, row) {
				return '<a href="' + SITE_URL + 'admin/product/modify/' + row.product_id + '">'
					 + '<i class="fas fa-pencil-alt"></i>&nbsp;修正</a>&nbsp;&nbsp;&nbsp;'
					 + '<a href="javascript:void(0);" onclick="del_product(' + row.product_id + ',\'' + row.name + '\')">'
					 + '<i class="far fa-trash-alt"></i>&nbsp;削除</a>';
		   }
		},
		rowCount: [20, 30, 50, -1],
		requestHandler: function(request) {
			var flg_market = [];
			$('[name="flg_market[]"]:checked').each( function() {
				flg_market.push(this.value);
			});

			var flg_sales = [];
			$('[name="flg_sales[]"]:checked').each( function() {
				flg_sales.push(this.value);
			});

			request['product_name'] = $('#product_name').val();
			request['smile_code_from'] = $('#smile_code_from').val();
			request['smile_code_to'] = $('#smile_code_to').val();
			request['publisher'] = $('#publisher').val();
			request['flg_market'] = flg_market;
			request['flg_sales'] = flg_sales;

			return request;
		}
	})
	.on('loaded.rs.jquery.bootgrid', function(e) {
		flg_tbl_show = true;
		$('.search').css('display', 'none');
	});
}

function product_dl()
{
	var flg_market = [];
	$('[name="flg_market[]"]:checked').each( function() {
		flg_market.push(this.value);
	});

	var flg_sales = [];
	$('[name="flg_sales[]"]:checked').each( function() {
		flg_sales.push(this.value);
	});

	$('<form/>', {'action': SITE_URL + 'admin/product/dl', 'method': 'post'})
	.append($('<input/>', {'type': 'hidden', 'name': 'product_name', 'value': $('#product_name').val()}))
	.append($('<input/>', {'type': 'hidden', 'name': 'smile_code_from', 'value': $('#smile_code_from').val()}))
	.append($('<input/>', {'type': 'hidden', 'name': 'smile_code_to', 'value': $('#smile_code_to').val()}))
	.append($('<input/>', {'type': 'hidden', 'name': 'publisher', 'value': $('#publisher').val()}))
	.append($('<input/>', {'type': 'hidden', 'name': 'flg_market', 'value': flg_market.join(',')}))
	.append($('<input/>', {'type': 'hidden', 'name': 'flg_sales', 'value': flg_sales.join(',')}))
	.appendTo(document.body)
	.submit();
}

function product_ul()
{










}

function del_product(product_id, product_name)
{
	wk_product_id = product_id;
	$('#dlg_product_name').val(product_name);
	$('#modal_product').modal();
}

function do_submit()
{
	$.ajax({
		url: SITE_URL + 'admin/product/ajax_del',
		type:'post',
		cache:false,
		data: {
			product_id: wk_product_id
		}
	})
	.done( function(ret, textStatus, jqXHR) {
		if( ret['status'] ) {
			$('#modal_product').modal('hide');
			$('#tbl_product').bootgrid('reload');
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
