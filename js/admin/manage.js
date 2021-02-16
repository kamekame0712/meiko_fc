var flg_proc;
var wk_admin_id;

jQuery( function($) {
	flg_proc = 0;
	wk_admin_id = '';

	$('#tbl_manage').bootgrid({
		ajax: true,
		url: SITE_URL + 'admin/manage/get_bootgrid',
		formatters: {
			'col_proc': function(column, row) {
				return '<a href="javascript:void(0);" onclick="mod_manage(' + row.admin_id + ',\'' + row.name + '\',\'' + row.email + '\')">'
					 + '<i class="fas fa-pencil-alt"></i>&nbsp;修正</a>&nbsp;&nbsp;&nbsp;'
					 + '<a href="javascript:void(0);" onclick="del_manage(' + row.admin_id + ',\'' + row.name + '\',\'' + row.email + '\')">'
					 + '<i class="far fa-trash-alt"></i>&nbsp;削除</a>&nbsp;&nbsp;&nbsp;'
					 + '<a href="javascript:void(0);" onclick="reset_password(' + row.admin_id + ')">'
					 + '<i class="fas fa-unlock-alt"></i>&nbsp;パスワードリセット</a>';
			},
		},
		rowCount: [15, 30, 50, -1],
		labels: {
			search: '管理者名で検索'
		}
	});
});

function add_manage()
{
	flg_proc = 1;
	$('#name').val('').prop('disabled', false);
	$('#email').val('').prop('disabled', false);
	$('#modal_manage_title').html('新規追加');
	$('#btn_submit').html('新規追加');
	$('#modal_manage').modal();
}

function mod_manage(admin_id, manage_name, email)
{
	flg_proc = 2;
	wk_admin_id = admin_id;
	$('#name').val(manage_name).prop('disabled', false);
	$('#email').val(email).prop('disabled', false);
	$('#modal_manage_title').html('修正');
	$('#btn_submit').html('修正');
	$('#modal_manage').modal();
}

function del_manage(admin_id, manage_name, email)
{
	flg_proc = 3;
	wk_admin_id = admin_id;
	$('#name').val(manage_name).prop('disabled', true);
	$('#email').val(email).prop('disabled', true);
	$('#modal_manage_title').html('削除');
	$('#btn_submit').html('削除');
	$('#modal_manage').modal();
}

function do_submit()
{
	var ajax_url = '';
	var ajax_data = {};

	switch( flg_proc ) {
		case 1: // 新規追加
			ajax_url = SITE_URL + 'admin/manage/ajax_add';
			ajax_data = {
				name: $('#name').val(),
				email: $('#email').val()
			};
			break;

		case 2: // 更新
			ajax_url = SITE_URL + 'admin/manage/ajax_mod';
			ajax_data = {
				admin_id: wk_admin_id,
				name: $('#name').val(),
				email: $('#email').val()
			};
			break;

		case 3: // 削除
			ajax_url = SITE_URL + 'admin/manage/ajax_del';
			ajax_data = {
				admin_id: wk_admin_id
			};
			break;

		default:
			show_error_notification('処理が完了できませんでした。');
			return false;
	}

	$.ajax({
		url: ajax_url,
		type:'post',
		cache:false,
		data: ajax_data
	})
	.done( function(ret, textStatus, jqXHR) {
		if( ret['status'] ) {
			$('#modal_manage').modal('hide');
			$('#tbl_manage').bootgrid('reload');
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

// パスワードリセット
function reset_password(admin_id)
{
	wk_admin_id = admin_id;

	$('#modal_title').html('確認');
	$('#modal_body').html('本当にパスワードをリセットしますか？<br>新しいパスワードは管理者へメールでお知らせします。');
	$('#modal_act').html('実行');
	$('#modal_act').html('リセット').show();
	$('#modal_message_box').modal('show');
}

// ダイアログの実行クリック
function act()
{
	$.ajax({
		url: SITE_URL + 'admin/manage/ajax_reset_password',type:'post',cache:false,
		data: {
			admin_id: wk_admin_id
		}
	})
	.done( function(ret, textStatus, jqXHR) {
		if( ret['status'] ) {
			$('#modal_message_box').modal('hide');
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
