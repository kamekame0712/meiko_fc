var menu_open = false;

// メニュー開く
$('#menu_top').click( function() {
	if( $('#menu_dropdown').css('display') == 'none' ) {
		$('#menu_dropdown').slideDown('fast', function() {
			menu_open = true;
		});
	}
	else {
		$('#menu_dropdown').slideUp('fast');
	}
});

// メニュー閉じる
$('html,body').click( function() {
	if( menu_open == true ) {
		$('#menu_dropdown').slideUp('fast', function() {
			menu_open = false;
		});
	}
});

// 説明文閉じる
$('[name="instruction"] a').click( function() {
	$(this).closest('[name="instruction"]').slideUp();
});

function change_flg_instruction(classroom_id, flg_instruction)
{
	$.ajax({
		url: SITE_URL + 'index/ajax_change_flg_instruction',
		type:'post',
		cache:false,
		data: {
			classroom_id: classroom_id,
			flg_instruction: flg_instruction
		}
	})
	.done( function(ret, textStatus, jqXHR) {
		location.reload();
	});
}