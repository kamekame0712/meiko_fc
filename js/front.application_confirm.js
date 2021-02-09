function do_submit(flg)
{
	if( flg == 1 ) {
		$('#frm_application_confirm').prop('action', SITE_URL + 'application');
	}
	else {
		$('#frm_application_confirm').prop('action', SITE_URL + 'application/complete');
	}

	$('#frm_application_confirm').submit();
}