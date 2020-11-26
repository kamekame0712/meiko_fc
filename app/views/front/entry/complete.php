<?php $this->load->view('inc/_head', array('TITLE' => SITE_NAME)); ?>

<body>
	<div id="wrapper">
		<?php $this->load->view('inc/header', array('MENU' => FALSE)); ?>

		<div class="container">
			<?php if( $COMMIT ): ?>
				<p class="lead-title">登録完了</p>
				ご登録ありがとうございます。<br>
				ご登録いただいたメールアドレス・パスワードでログインしていただけます。<br>
				社内手続き及び、代表教室様の設定によっては教材を発注していただけるようになるまでお時間を頂くことがあります。

				<?php if( $PARENT == '1' ): ?>
					<div class="for-parent">
						<h2>代表教室様</h2>
						ログイン後、支払方法の設定をお願いします。<br>
						なお、『掛け』でのお取引を合わせてご登録いただいた場合でも、社内手続き完了までは『掛け』でのお取引ができません。<br>
						ご理解、ご了承のほどよろしくお願いします。
					</div>
				<?php endif; ?>

				<div class="text-center mt-5">
					<a href="<?= site_url('') ?>" class="btn btn-success">　ログイン画面へ　</a>
				</div>
			<?php else: ?>
				<p class="lead-title">登録エラー</p>
				登録時にエラーが発生しました。<br>
				申し訳ございませんが、しばらく時間を空け、再度登録をお願いします。<br>
				エラーが続くようであればお手数ですが、中央教育研究所株式会社までご連絡をお願いします。

				<div class="error-contact">
					<h3>お問い合わせ先</h3>
					中央教育研究所株式会社<br>
					TEL：082-227-3999（平日10:00～18:00）
				</div>

				<div class="text-center mt-5">
					<a href="<?= site_url('entry') ?>" class="btn btn-success">　登録画面へ　</a>
				</div>
			<?php endif; ?>
		</div> <!-- end of .container -->
		
		<?php $this->load->view('inc/_foot'); ?>
		<?php $this->load->view('inc/footer'); ?>
	</div> <!-- end of #wrapper -->
</body>
</html>
