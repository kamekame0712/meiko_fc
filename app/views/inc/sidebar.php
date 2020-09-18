<?php
	$active_publisher = $active_product = $active_manage = '';
	$active_proc = 'class="nav-item dropdown"';
	$active_sei_upload = $active_sei_smile = $active_sei_sending =
	$active_sei_demand = $active_sei_send_list = $active_sei_order = $active_sei_stock = '';

	switch( $current ) {
		case 'publisher':	$active_publisher = 'class="active"';	break;
		case 'product':		$active_product = 'class="active"';	break;
		case 'manage':		$active_manage = 'class="active"';	break;

		case 'sei_upload':	$active_proc = 'class="nav-item dropdown active"';
							$active_sei_upload = 'class="active"';				break;
		case 'sei_smile':	$active_proc = 'class="nav-item dropdown active"';
							$active_sei_smile = 'class="active"';				break;
		case 'sei_sending':	$active_proc = 'class="nav-item dropdown active"';
							$active_sei_sending = 'class="active"';				break;
		case 'sei_demand':	$active_proc = 'class="nav-item dropdown active"';
							$active_sei_demand = 'class="active"';				break;
		case 'sei_list':	$active_proc = 'class="nav-item dropdown active"';
							$active_sei_send_list = 'class="active"';			break;
		case 'sei_order':	$active_proc = 'class="nav-item dropdown active"';
							$active_sei_order = 'class="active"';				break;
		case 'sei_stock':	$active_proc = 'class="nav-item dropdown active"';
							$active_sei_stock = 'class="active"';				break;
	}
?>

<div class="main-sidebar sidebar-style-2">
	<aside id="sidebar-wrapper">
		<div class="sidebar-brand">
			<a href="<?= site_url('') ?>"><?= SITE_NAME ?></a>
		</div>
		<div class="sidebar-brand sidebar-brand-sm">
			<a href="<?= site_url('') ?>">大手塾</a>
		</div>

		<ul class="sidebar-menu">
			<li class="menu-header">各塾処理</li>
			<li <?= $active_proc ?>>
				<a href="#" class="nav-link has-dropdown" data-toggle="dropdown">成<span>学社</span></a>
				<ul class="dropdown-menu">
					<li <?= $active_sei_upload ?>><a class="nav-link" href="<?= site_url('seigaku/upload_data') ?>">受取データUL</a></li>
					<li <?= $active_sei_smile ?>><a class="nav-link" href="<?= site_url('seigaku/smile') ?>">SMILEデータDL</a></li>
					<li <?= $active_sei_sending ?>><a class="nav-link" href="<?= site_url('seigaku/sending') ?>">送付状況レポートDL</a></li>
					<li <?= $active_sei_demand ?>><a class="nav-link" href="<?= site_url('seigaku/demand') ?>">請求明細データDL</a></li>
					<li <?= $active_sei_send_list ?>><a class="nav-link" href="<?= site_url('seigaku/send_list') ?>">教材送付リストDL</a></li>
					<li <?= $active_sei_order ?>><a class="nav-link" href="<?= site_url('seigaku/order') ?>">受注データ確認</a></li>
					<li <?= $active_sei_stock ?>><a class="nav-link" href="<?= site_url('seigaku/stock') ?>">在庫管理</a></li>
				</ul>
			</li>

			<li class="menu-header">全体</li>
			<li <?= $active_publisher ?>><a class="nav-link" href="<?= site_url('publisher') ?>"><i class="fas fa-print"></i><span>出版社管理</span></a></li>
			<li <?= $active_product ?>><a class="nav-link" href="<?= site_url('product') ?>"><i class="fas fa-book"></i><span>テキスト管理</span></a></li>

			<li class="menu-header">その他</li>
			<li <?= $active_manage ?>><a class="nav-link" href="<?= site_url('manage') ?>"><i class="fas fa-user-tie"></i><span>管理者管理</span></a></li>
		</ul>
	</aside>
</div>
