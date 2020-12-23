<div class="container">
	<div class="header">
		<img src="<?= base_url('img/common/chuoh_logo.png') ?>" class="header-logo" alt="CHUOHロゴ">
		<h1 class="site-title-small">明光義塾フランチャイズ教室様専用</h1>
		<h1 class="site-title-large">教材発注システム</h1>

		<?php if( $MENU == TRUE && !empty($this->session->userdata('classroom_name')) ): ?>
			<div class="for-pc">
				<div class="menu-box">
					ようこそ<span><?= $this->session->userdata('classroom_name') ?></span>&nbsp;様<br>
					<div class="menu" id="menu_top">
						メニュー<i class="fas fa-caret-down"></i>
					</div>

					<div class="menu-dropdown" id="menu_dropdown">
						<ul>
							<li><a href="<?= site_url('order') ?>">発注処理</a></li>
							<li><a href="<?= site_url('history') ?>">発注履歴</a></li>
							<li><a href="<?= site_url('modify') ?>">登録情報変更</a></li>
							<li class="divide">&nbsp;</li>
							<li><a href="<?= site_url('index/logout') ?>">ログアウト</a></li>
						</ul>
					</div>
				</div>
			</div>

		<?php endif; ?>
	</div>
</div>

<hr class="header-bottom">