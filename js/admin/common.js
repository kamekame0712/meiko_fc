function password_change()
{
	$.ajax({
		url: SITE_URL + 'admin/index/ajax_password_change',
		type:'post',
		cache:false,
		data: {
			old_pass: $('#old_pass').val(),
			new_pass: $('#new_pass').val()
		}
	})
	.done( function(ret, textStatus, jqXHR) {
		if( ret['status'] ) {
			$('#modal_title').html('お知らせ');
			$('#modal_body').html('パスワードを変更しました。');
			$('#modal_pass_change').modal('hide');
			$('#modal_act').hide();
			$('#modal_message_box').modal();
		}
		else {
			$('#modal_title').html('エラー');
			$('#modal_body').html(ret['err_msg']);
			$('#modal_pass_change').modal('hide');
			$('#modal_act').hide();
			$('#modal_message_box').modal();
		}
	})
	.fail( function(data, textStatus, errorThrown) {
		$('#modal_title').html('エラー');
		$('#modal_body').html(textStatus);
		$('#modal_pass_change').modal('hide');
		$('#modal_act').hide();
		$('#modal_message_box').modal();
	});
}

function show_error_notification(msg)
{
	$.notify({
		icon: 'warning',
		message: msg
	},{
		type: 'danger',
		delay: 5000,
		timer: 500,
		offset: {
		  x: 0,
		  y: 50
		},
		placement: {
		  from: 'top',
		  align: 'center'
		},
		z_index: 1100
	});
}

function show_success_notification(msg)
{
	$.notify({
		icon: 'info',
		message: msg
	},{
		type: 'success',
		delay: 3000,
		timer: 500,
		offset: {
		  x: 0,
		  y: 50
		},
		placement: {
		  from: 'top',
		  align: 'center'
		},
		z_index: 1100
	});
}

function show_loading()
{
	const HTML = `
		<div class="loading" id="loading">
			<img src="${SITE_URL}img/admin/loading.gif" alt="loading...">
			<p id="loading_comment"></p>
		</div>
	`;
	$('body').append(HTML);
}

function remove_loading()
{
	$('#loading').remove();
}