var subwin_product;
function choose_product()
{
	if( subwin_product === void 0 ) {
		subwin_product = window.open(SITE_URL + 'order/choose_product', 'window_choose_product', 'width=900, height=800, menubar=no, toolbar=no, scrollbars=yes');
	}
	else {
		if( subwin_product.closed ) {
			subwin_product = window.open(SITE_URL + 'order/choose_product', 'window_choose_product', 'width=900, height=800, menubar=no, toolbar=no, scrollbars=yes');
		}
		else {
			alert('ウィンドウはすでに開かれています。');
		}
	}
}
