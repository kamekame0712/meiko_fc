jQuery( function($) {
	$('[name="classroom_number[]"]').each( function(index, element) {
		var len = $(this).val().length;
		var num = ('000' + $(this).data('num')).slice(-3);

		if( len == 4 ) {
			$.ajax({
				url: SITE_URL + 'application/ajax_get_classroom',
				type:'post',
				cache:false,
				async: false,
				data: {
					classroom_number: $(this).val()
				}
			})
			.done( function(ret, textStatus, jqXHR) {
				if( ret['status'] ) {
					$('#classroom_name' + num).html(ret['classroom_name']);
				}
				else {
					swal(ret['err_msg']);
				}
			});
		}
	});
});

$(document).on('keyup', '#zip1, #zip2', function() {
	AjaxZip3.zip2addr('zip1', 'zip2', 'pref', 'addr1');
});

$(document).on('keyup', '[name="classroom_number[]"]', function() {
	var len = $(this).val().length;
	var num = ('000' + $(this).data('num')).slice(-3);

	if( len == 4 ) {
		$.ajax({
			url: SITE_URL + 'application/ajax_get_classroom',
			type:'post',
			cache:false,
			async: false,
			data: {
				classroom_number: $(this).val()
			}
		})
		.done( function(ret, textStatus, jqXHR) {
			if( ret['status'] ) {
				$('#classroom_name' + num).html(ret['classroom_name']);
			}
			else {
				swal(ret['err_msg']);
			}
		});
	}
});

function add_classroom()
{
	var len = $('#classroom_list > tbody').children().length;
	var num = ('000' + len.toString()).slice(-3);
	var html = function() {/*
<tr>
<td>
<input type="text" name="classroom_number[]" value="" data-num="ZZZ" class="form-control entry-input">
</td>
<td id="classroom_nameXXX"></td>
</tr>
	*/}.toString().split("\n").slice(1,-1).join("\n").replace('ZZZ', len).replace('XXX', num);

	$('#classroom_list > tbody').append(html);
}
