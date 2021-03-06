function do_submit(flg, order_id)
{
	if( flg == 1 ) {
		$('#frm_send_mail').prop('action', SITE_URL + 'admin/order/send_mail/' + order_id);
	}
	else {
		$('#frm_send_mail').prop('action', SITE_URL + 'admin/order/mail_complete');
	}

	$('#frm_send_mail').submit();
}
