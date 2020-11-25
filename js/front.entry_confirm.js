function do_submit(url)
{
	$('#frm_confirm').prop('action', SITE_URL + url).submit();
}