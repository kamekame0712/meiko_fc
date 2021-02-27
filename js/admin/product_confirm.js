function do_submit(flg, kind, product_id)
{
	if( flg == 1 ) {
		if( kind == 'add' ) {
			$('#frm_product_confirm').prop('action', SITE_URL + 'admin/product/add');
		}
		else {
			$('#frm_product_confirm').prop('action', SITE_URL + 'admin/product/modify/' + product_id);
		}
	}
	else {
		$('#frm_product_confirm').prop('action', SITE_URL + 'admin/product/complete');
	}

	$('#frm_product_confirm').submit();
}
