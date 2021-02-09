jQuery( function($) {
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

$(document).on('keyup', '#bill_zip1, #bill_zip2', function() {
	AjaxZip3.zip2addr('bill_zip1', 'bill_zip2', 'bill_pref', 'bill_addr1');
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

function get_owner_data(owner_id)
{
	$.ajax({
		url: SITE_URL + 'application/ajax_get_owner',
		type:'post',
		cache:false,
		data: {
			owner_id: owner_id
		}
	})
	.done( function(ret, textStatus, jqXHR) {
		if( ret['status'] ) {
			$('#zip1').val(ret['owner_data']['zip1']);
			$('#zip2').val(ret['owner_data']['zip2']);
			$('#pref').val(ret['owner_data']['pref']);
			$('#addr1').val(ret['owner_data']['addr1']);
			$('#addr2').val(ret['owner_data']['addr2']);
			$('#tel1').val(ret['owner_data']['tel1']);
			$('#tel2').val(ret['owner_data']['tel2']);
			$('#tel3').val(ret['owner_data']['tel3']);
			$('#fax1').val(ret['owner_data']['fax1']);
			$('#fax2').val(ret['owner_data']['fax2']);
			$('#fax3').val(ret['owner_data']['fax3']);

			if( $('#corporation1').prop('checked') ) {
				$('#corpo_name').val(ret['owner_data']['corpo_name']);
				$('#executive').val(ret['owner_data']['owner_name']);
			}
			else {
				$('#corpo_name').val(ret['owner_data']['owner_name']);
				$('#executive').val('');
			}
		}
		else {
			swal(ret['err_msg']);
		}
	});
}
