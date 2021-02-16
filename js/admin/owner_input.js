jQuery( function($) {
	if( $('#payment_method1').prop('checked') ) {
		$('#account_box').show();
	}
	else {
		$('#account_box').hide();
	}

	if( $('#corporation1').prop('checked') || $('#corporation2').prop('checked') ) {
		$('#corporation_detail').show();
	}

	if( $('#bill_to1').prop('checked') ) {
		$('#bill-other').hide();
	}

	if( $('#bill_to2').prop('checked') ) {
		$('#bill-other').show();
	}

	if( $('#settlement_method1').prop('checked') ) {
		$('#transfer').show();
		$('#debit').hide();
	}

	if( $('#settlement_method2').prop('checked') ) {
		$('#transfer').hide();
		$('#debit').show();
	}
});

$(document).on('keyup', '#zip1, #zip2', function() {
	AjaxZip3.zip2addr('zip1', 'zip2', 'pref', 'addr1');
});

$(document).on('keyup', '#account_zip1, #account_zip2', function() {
	AjaxZip3.zip2addr('account_zip1', 'account_zip2', 'account_pref', 'account_addr1');
});

$(document).on('keyup', '#bill_zip1, #bill_zip2', function() {
	AjaxZip3.zip2addr('bill_zip1', 'bill_zip2', 'bill_pref', 'bill_addr1');
});

$('#payment_method1').change( function() {
	if( $(this).prop('checked') ) {
		$('#account_box').show();
	}
	else {
		$('#account_box').hide();
	}
});

$('[name="corporation"').change( function() {
	if( $('#corporation1').prop('checked') ) {
		$('#corporation_detail').slideUp('normal', function() {
			$('#cd_corporation_name').html('法人名');
			$('#corpo_name').prop('placeholder', '中央教育研究所株式会社');
			$('#cd_zip').html('法人郵便番号');
			$('#cd_address').html('法人住所');
			$('#cd_tel').html('代表電話番号');
			$('#transfer_name').prop('placeholder', '中央教育研究所株式会社');
			$('[name="settlement_method"]').prop('checked', false);
			$('#executive_box').show();
		});
	}
	else {
		$('#corporation_detail').slideUp('normal', function() {
			$('#cd_corporation_name').html('代表者名');
			$('#corpo_name').prop('placeholder', '山田 太郎');
			$('#cd_zip').html('代表者自宅郵便番号');
			$('#cd_address').html('代表者自宅住所');
			$('#cd_tel').html('代表者電話番号');
			$('#transfer_name').prop('placeholder', '山田 太郎');
			$('[name="settlement_method"]').prop('checked', false);
			$('#executive_box').hide();
		});
	}

	$('#bill-other').hide();
	$('#transfer').hide();
	$('#debit').hide();
	$('#corporation_detail').slideDown();
});

$('[name="bill_to"').change( function() {
	if( $('#bill_to1').prop('checked') ) {
		$('#bill-other').slideUp();
	}
	else {
		$('#bill-other').slideDown();
	}
});

$('[name="settlement_method"').change( function() {
	if( $('#settlement_method1').prop('checked') ) {
		$('#debit').slideUp('', function() {
			$('#transfer').slideDown();
		});
	}
	else {
		$('#transfer').slideUp('', function() {
			$('#debit').slideDown();
		});
	}
});

function remove_classroom(classroom_id)
{
	$('#hidden_' + classroom_id).remove();
	$('#li_' + classroom_id).remove();
}

function search_classroom()
{
	if( $('#cond_classroom').val() == '' ) {
		show_error_notification('検索する教室名を入力してください。');
	}
	else {
		$.ajax({
			url: SITE_URL + 'admin/owner/ajax_search_classroom',
			type:'post',
			cache:false,
			data: {
				'classroom_name': $('#cond_classroom').val()
			}
		})
		.done( function(ret, textStatus, jqXHR) {
			if( ret['status'] ) {
				$('#select_classroom option').remove();
				$('#select_classroom').append('<option value=\'\'>選択してください</option>');

				var option;
				var selected;
				$.each(ret['classroom'], function(index, val) {
					option = $('<option>')
						.val(index)
						.text(val);
					$('#select_classroom').append(option);
				});
			}
			else {
				show_error_notification(ret['err_msg']);
			}
		})
		.fail( function(data, textStatus, errorThrown) {
			show_error_notification(textStatus);
		});
	}
}

function do_submit()
{
	var classroom_id = $('#select_classroom option:selected').val();
	var classroom_name = $('#select_classroom option:selected').text();

	if( classroom_id == '' ) {
		show_error_notification('教室名を選択してください。');
	}
	else {
		$('#classroom_list').append('<input type="hidden" name="classroom_ids[]" value="' + classroom_id + '" id="hidden_' + classroom_id + '">');
		$('#classroom_list').append('<li id="li_' + classroom_id + '">' + classroom_name + '<button name="btn_remove_classroom" type="button" class="btn btn-sm btn-warning" onclick="remove_classroom(\'' + classroom_id + '\')"><i class="fas fa-minus"></i>&nbsp;削除</button></li>');
	}
}
