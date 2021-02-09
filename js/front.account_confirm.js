function do_submit(flg, owner_id)
{
	if( flg == 1 ) {
		$('#frm_account_confirm').prop('action', SITE_URL + 'application/account/' + owner_id);
	}
	else {
		$('#frm_account_confirm').prop('action', SITE_URL + 'application/account_complete');
	}

	$('#frm_account_confirm').submit();
}