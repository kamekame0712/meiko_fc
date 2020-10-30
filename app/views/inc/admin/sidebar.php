<?php
	$active_manage = '';

	switch( $current ) {
		case 'manage':		$active_manage = 'class="active"';	break;
	}
?>

<div class="main-sidebar sidebar-style-2">
	<aside id="sidebar-wrapper">
		<div class="sidebar-brand">
			<a href="<?= site_url('admin') ?>"><?= SITE_NAME ?></a>
		</div>
		<div class="sidebar-brand sidebar-brand-sm">
			<a href="<?= site_url('admin') ?>">明光FC</a>
		</div>

		<ul class="sidebar-menu">
			<li class="menu-header">その他</li>
			<li <?= $active_manage ?>><a class="nav-link" href="<?= site_url('admin/manage') ?>"><i class="fas fa-user-tie"></i><span>管理者管理</span></a></li>
		</ul>
	</aside>
</div>
