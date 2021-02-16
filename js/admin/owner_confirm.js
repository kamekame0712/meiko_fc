function do_submit(flg, kind, owner_id)
{
	if( flg == 1 ) {
		if( kind == 'add' ) {
			$('#frm_owner_confirm').prop('action', SITE_URL + 'admin/owner/add');
		}
		else {
			$('#frm_owner_confirm').prop('action', SITE_URL + 'admin/owner/modify/' + owner_id);
		}
	}
	else {
		$('#frm_owner_confirm').prop('action', SITE_URL + 'admin/owner/complete');
	}

	$('#frm_owner_confirm').submit();
}
