function do_submit(flg, kind, classroom_id)
{
	if( flg == 1 ) {
		if( kind == 'add' ) {
			$('#frm_classroom_confirm').prop('action', SITE_URL + 'admin/classroom/add');
		}
		else {
			$('#frm_classroom_confirm').prop('action', SITE_URL + 'admin/classroom/modify/' + classroom_id);
		}
	}
	else {
		$('#frm_classroom_confirm').prop('action', SITE_URL + 'admin/classroom/complete');
	}

	$('#frm_classroom_confirm').submit();
}
