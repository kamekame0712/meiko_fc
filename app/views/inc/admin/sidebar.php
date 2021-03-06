<?php
	$active_order = $active_classroom = $active_product = $active_manage = '';
	$active_owner = 'class="position-relative"';

	switch( $current ) {
		case 'order':		$active_order = 'class="active"';		break;
		case 'owner':		$active_owner = 'class="active position-relative"';		break;
		case 'classroom':	$active_classroom = 'class="active"';	break;
		case 'product':		$active_product = 'class="active"';		break;
		case 'manage':		$active_manage = 'class="active"';		break;
	}
?>

<div class="main-sidebar sidebar-style-2">
	<aside id="sidebar-wrapper">
		<div class="sidebar-brand">
			<a href="<?= site_url('admin') ?>">明光義塾受注管理</a>
		</div>
		<div class="sidebar-brand sidebar-brand-sm">
			<a href="<?= site_url('admin') ?>">明光</a>
		</div>

		<ul class="sidebar-menu">
			<li class="menu-header">受注処理</li>
			<li <?= $active_order ?>><a class="nav-link" href="<?= site_url('admin/order') ?>"><i class="fas fa-dolly-flatbed"></i><span>受注管理</span></a></li>

			<li class="menu-header">マスター関連</li>
			<li <?= $active_owner ?>>
				<a class="nav-link" href="<?= site_url('admin/owner') ?>">
					<i class="fas fa-building"></i>
					<span>オーナー管理</span>
				</a>

				<?php if( get_not_register_owner() != 0 ): ?>
					<span class="side-menu-badge"><span class="num"><?= get_not_register_owner() ?></span></span>
				<?php endif; ?>
			</li>
			<li <?= $active_classroom ?>><a class="nav-link" href="<?= site_url('admin/classroom') ?>"><i class="fas fa-school"></i><span>教室管理</span></a></li>
			<li <?= $active_product ?>><a class="nav-link" href="<?= site_url('admin/product') ?>"><i class="fas fa-book"></i><span>教材管理</span></a></li>

			<li class="menu-header">その他</li>
			<li <?= $active_manage ?>><a class="nav-link" href="<?= site_url('admin/manage') ?>"><i class="fas fa-user-tie"></i><span>管理者管理</span></a></li>
		</ul>
	</aside>
</div>
