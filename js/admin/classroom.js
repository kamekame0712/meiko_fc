var flg_tbl_show;
var wk_classroom_id;

jQuery( function($) {
	flg_tbl_show = false;
	wk_classroom_id = '';

	do_bootgrid();

	if( result == 'ok' ) {
		show_success_notification('処理が完了しました。');
	}
	else if( result == 'err1' ) {
		show_error_notification('データベースエラーが発生しました。');
	}
	else if( result == 'err2' ) {
		show_error_notification('対象の教室が見つかりません。');
	}
});

function clear_conditions()
{
	$('#classroom_name').val('');
	$('#owner_name').val('');
	$('#corpo_name').val('');
	$('#smile_code').val('');
	$('#pref').val('');
	$('#tel').val('');

	do_search();
}

function do_search()
{
	if( flg_tbl_show == false ) {
		do_bootgrid();
	}
	else {
		$('#tbl_classroom').bootgrid('reload');
	}
}

function do_bootgrid()
{
	$('#tbl_classroom').bootgrid({
		ajax: true,
		url: SITE_URL + 'admin/classroom/get_bootgrid',
		formatters: {
			'col_proc': function(column, row) {
				return '<a href="' + SITE_URL + 'admin/classroom/modify/' + row.classroom_id + '">'
					 + '<i class="fas fa-pencil-alt"></i>&nbsp;修正</a>&nbsp;&nbsp;&nbsp;'
					 + '<a href="javascript:void(0);" onclick="del_classroom(' + row.classroom_id + ',\'' + row.name + '\')">'
					 + '<i class="far fa-trash-alt"></i>&nbsp;削除</a>';
		   }
		},
		rowCount: [20, 30, 50, -1],
		requestHandler: function(request) {
			request['classroom_name'] = $('#classroom_name').val();
			request['owner_name'] = $('#owner_name').val();
			request['corpo_name'] = $('#corpo_name').val();
			request['smile_code'] = $('#smile_code').val();
			request['pref'] = $('#pref').val();
			request['tel'] = $('#tel').val();

			return request;
		}
	})
	.on('loaded.rs.jquery.bootgrid', function(e) {
		flg_tbl_show = true;
		$('.search').css('display', 'none');
	});
}

function del_classroom(classroom_id, classroom_name)
{
	wk_classroom_id = classroom_id;
	$('#dlg_classroom_name').val(classroom_name);
	$('#modal_classroom').modal();
}

function do_submit()
{
	$.ajax({
		url: SITE_URL + 'admin/classroom/ajax_del',
		type:'post',
		cache:false,
		data: {
			classroom_id: wk_classroom_id
		}
	})
	.done( function(ret, textStatus, jqXHR) {
		if( ret['status'] ) {
			$('#modal_classroom').modal('hide');
			$('#tbl_classroom').bootgrid('reload');
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
