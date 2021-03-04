<div class="container">
	<div class="header">
		<a href="<?= site_url('order') ?>">
			<img src="<?= base_url('img/common/chuoh_logo.png') ?>" class="header-logo" alt="CHUOHロゴ">
		</a>
		<h1 class="site-title-small">明光義塾教室様専用</h1>
		<h1 class="site-title-large">教材発注システム</h1>
		<a href="<?= site_url('img/common/manual.pdf') ?>" download="manual.pdf" class="manual-download">
			<img src="<?= base_url('img/common/icon_pdf.png') ?>" alt="PDFダウンロード">
			<p>マニュアル<br>ダウンロード</p>
		</a>

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
							<?php if( get_instruction() ): ?>
								<li><a href="javascript:void(0);" onclick="change_flg_instruction('<?= $this->session->userdata('classroom_id') ?>', '2');">注意事項を表示しない</a></li>
							<?php else: ?>
								<li><a href="javascript:void(0);" onclick="change_flg_instruction('<?= $this->session->userdata('classroom_id') ?>', '1');">注意事項を表示する</a></li>
							<?php endif; ?>
							<li class="divide">&nbsp;</li>
							<li><a href="<?= site_url('help/privacy') ?>">プライバシーポリシー</a></li>
							<li><a href="<?= site_url('help/tradelaw') ?>">特定商取引法に基づく表記</a></li>
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