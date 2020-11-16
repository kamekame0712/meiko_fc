jQuery( function($) {
	if( $('#flg_hide').val() == '1' ) {
		$('#hide_conditions').html('<i class="fas fa-angle-double-up"></i>&nbsp;検索条件を隠す');
		$('#product_conditions').show();
	}
	else {
		$('#hide_conditions').html('<i class="fas fa-angle-double-down"></i>&nbsp;検索条件を表示する');
		$('#product_conditions').hide();
	}
});

$('#all_elementary').change( function() {
	$('[name="grade_e[]"]').prop('checked', $(this).prop('checked'));
});

$('#all_junior').change( function() {
	$('[name="grade_j[]"]').prop('checked', $(this).prop('checked'));
});

$('#all_high').change( function() {
	$('[name="grade_h[]"]').prop('checked', $(this).prop('checked'));
});

$('[name="td-checkable"]').click( function() {
	var chk_target = $('#se_' + $(this).data('pcid'));

	if( chk_target.prop('checked') ) {
		chk_target.prop('checked', false);
	}
	else {
		chk_target.prop('checked', true);
	}

	chk_target.trigger('change');
});

function hide_conditions()
{
	if( $('#product_conditions').css('display') == 'none' ) {
		$('#hide_conditions').html('<i class="fas fa-angle-double-up"></i>&nbsp;検索条件を隠す');
		$('#product_conditions').slideDown();
		$('#flg_hide').val('1');
	}
	else {
		$('#hide_conditions').html('<i class="fas fa-angle-double-down"></i>&nbsp;検索条件を表示する');
		$('#product_conditions').slideUp();
		$('#flg_hide').val('2');
	}
}

function reset_conditions()
{
	$('#cond_keyword').val('');
	$('input[type="checkbox"]').prop('checked', false);
	$('#recommend').prop('checked', true);
}

function search_link($page)
{
	$('#frm_choose_product').prop('action', SITE_URL + 'order/choose_product/' + $page).submit();
}

function choose(product_id)
{
	if( !window.opener || window.opener.closed ) {
		swal('親ウィンドウが存在しないか閉じられています。');
	}
	else {
		window.opener.$('#frm_order').prop('action', SITE_URL + 'order').append($('<input/>', {'type': 'hidden', 'name': 'product_id', 'value': product_id})).submit();
	}
}