<?php $this->load->view('inc/_head', array('TITLE' => SITE_NAME)); ?>

<body>
	<div id="wrapper">
		<?php $this->load->view('inc/header', array('MENU' => TRUE)); ?>

		<div class="container">
			<ul class="breadcrumb-list">
				<li>発注内容の選択</li>
				<li>発注内容の確認</li>
				<li class="current">完了</li>
			</ul>

			<p class="lead-title">発注完了</p>

			<h1 class="complete-title">ご注文ありがとうございました。</h1>
			<p class="complete-message">ご注文の確認メールを送信しております。ご確認ください。</p>

			<?php if( $CARD_ERROR ): ?>
				<div class="card-error-box">
					<h2>クレジットカード登録時にエラーが発生しました。</h2>
					クレジットカード決済は正しく行われております。<br>
					次回ご注文時、クレジットカード情報を再度ご入力いただき、登録をお願いします。
				</div>
			<?php endif; ?>

			<div class="not-receive-box">
				<h2>確認メールが届かない場合</h2>
				<p>
					確認メールはご登録のメールアドレスに自動送信しておりますが、メールの特性上、遅延、未着となる場合があります。<br />
					その際はお手数ですが、お電話にてお問合せください。
					<div class="contact-box">
						<p>お問い合わせ先</p>
						中央教育研究所株式会社<br>
						TEL：082-227-3999（平日10:00～18:00）
					</div>
					また、以下の点もご確認ください。
				</p>

				<dl>
					<dt><i class="fas fa-exclamation-circle"></i>メール受信拒否設定をしていませんか？</dt>
					<dd>
						[meiko-fc@kyouzai.info]からのメールが受信できるようにご設定ください。
					</dd>

					<dt><i class="fas fa-exclamation-circle"></i>迷惑メールやゴミ箱に振り分けられていませんか？</dt>
					<dd>
						お使いのセキュリティソフトやメールソフトによっては迷惑メールやゴミ箱に振り分けられている可能性があります。ご確認ください。
					</dd>

					<dt><i class="fas fa-exclamation-circle"></i>登録されたメールアドレスに間違いはありませんか？</dt>
					<dd>
						登録されたメールアドレスは「<?= $EMAIL ?>」です。
					</dd>
				</dl>
			</div>

			<div class="text-center mt-5 mb-5">
				<a href="<?= site_url('order') ?>" class="btn btn-success">TOPに戻る</a>
			</div>
		</div> <!-- end of .container -->
		
		<?php $this->load->view('inc/_foot'); ?>
		<?php $this->load->view('inc/footer'); ?>
	</div> <!-- end of #wrapper -->
</body>
</html>
