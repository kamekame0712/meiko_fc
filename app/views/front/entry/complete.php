<?php $this->load->view('inc/_head', array('TITLE' => SITE_NAME)); ?>

<body>
	<div id="wrapper">
		<?php $this->load->view('inc/header', array('MENU' => FALSE)); ?>

		<div class="container">
			<?php if( $COMMIT ): ?>
				<p class="lead-title">登録完了</p>
				ご登録ありがとうございます。<br>
				ご登録いただいたメールアドレス・パスワードでログインしていただけます。

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
