function reorder(order_id)
{
	$.ajax({
		url: SITE_URL + 'history/ajax_check_reorder',
		type:'post',
		cache:false,
		data: {
			order_id: order_id
		}
	})
	.done( function(ret, textStatus, jqXHR) {
		if( ret['status'] == '1' ) {
			location.href = SITE_URL + "history/reorder/" + order_id;
		}
		else if( ret['status'] == '2' ) {
			swal({
				text: ret['err_msg'].replace('___', "\r\n") + "\r\n\r\n" + '発注される場合は発注内容をご確認ください。',
				buttons: ['キャンセル', '発注する'],
				dangerMode: true
			}).then((willDelete) => {
				if( willDelete ) {
					location.href = SITE_URL + "history/reorder/" + order_id;
				}
			});
		}
		else {
			swal(ret['err_msg']);
		}
	})
	.fail( function(data, textStatus, errorThrown) {
		swal(textStatus);
	});
}
