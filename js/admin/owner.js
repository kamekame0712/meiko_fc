var wk_owner_id;

jQuery( function($) {
	wk_owner_id = '';

	$('#tbl_owner').bootgrid({
		ajax: true,
		url: SITE_URL + 'admin/owner/get_bootgrid',
		formatters: {
			'col_proc': function(column, row) {
				return '<a href="' + SITE_URL + 'admin/owner/detail/' + row.owner_id + '">'
					 + '<i class="fas fa-info"></i>&nbsp;詳細</a>&nbsp;&nbsp;'
					 + '<a href="' + SITE_URL + 'admin/owner/modify/' + row.owner_id + '">'
					 + '<i class="fas fa-pencil-alt"></i>&nbsp;修正</a>&nbsp;&nbsp;'
					 + '<a href="javascript:void(0);" onclick="del_owner(' + row.owner_id + ',\'' + row.owner_name + '\',\'' + row.corpo_name + '\')">'
					 + '<i class="far fa-trash-alt"></i>&nbsp;削除</a>';
			},
			'flg_complete_proc': function(column, row) {
				if( row['flg_complete'] == '1' ) {
					return '<a href="' + SITE_URL + 'admin/owner/register/' + row.owner_id + '" class="btn btn-sm btn-danger" style="display:block;margin:0;">登録</a>';
				}
				else {
					return '登録済';
				}
			}
		},
		rowCount: [15, 30, 50, -1],
		labels: {
			search: 'オーナー名、法人名で検索'
		}
	});

	if( result == 'ok' ) {
		show_success_notification('処理が完了しました。');
	}
	else if( result == 'err1' ) {
		show_error_notification('オーナー情報がありません。');
	}
	else if( result == 'err2' ) {
		show_error_notification('すでに登録が完了しています。');
	}
	else if( result == 'err3' ) {
		show_error_notification('データベースエラーが発生しました。');
	}
});

function del_owner(owner_id, owner_name, corpo_name)
{
	wk_owner_id = owner_id;
	$('#owner_name').val(owner_name);
	$('#corpo_name').val(corpo_name);
	$('#modal_owner').modal();
}

function do_submit()
{
	$.ajax({
		url: SITE_URL + 'admin/owner/ajax_del',
		type:'post',
		cache:false,
		data: {
			owner_id: wk_owner_id
		}
	})
	.done( function(ret, textStatus, jqXHR) {
		if( ret['status'] ) {
			$('#modal_owner').modal('hide');
			$('#tbl_owner').bootgrid('reload');
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
