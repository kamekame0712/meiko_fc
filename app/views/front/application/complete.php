<?php $this->load->view('inc/_head', array('TITLE' => SITE_NAME)); ?>

<body>
	<div id="wrapper">
		<?php $this->load->view('inc/header', array('MENU' => FALSE)); ?>

		<div class="container">
			<p class="lead-title">ご利用申込み 完了</p>

			<div class="thanks-box">
				<?php if( !$ERROR ): ?>
					<h2>ご登録ありがとうございました</h2>
					<p>
						運営教室様にログイン・ご購入していただける様になりましたら、
						ご入力いただきましたメールアドレス宛てに登録完了メッセージをお送りいたします。<br>
						なお、手続きには２～５営業日いただいておりますので、ご了承ください。<br>
					</p>

					<div class="text-center mt-5">
						<a href="<?= site_url('') ?>">ログインページへ</a>
					</div>
				<?php else: ?>
					<h2>エラーが発生しました</h2>

					<p>
						登録時にエラーが発生しました。<br>
						申し訳ございませんが、しばらく時間を空け、再度登録をお願いします。<br>
						エラーが続くようであればお手数ですが、中央教育研究所株式会社までご連絡をお願いします。
					</p>

					<div class="error-contact">
						<h3>お問い合わせ先</h3>
						中央教育研究所株式会社<br>
						TEL：082-227-3999（平日10:00～18:00）
					</div>

					<div class="text-center mt-5">
						<a href="<?= site_url('application') ?>">登録ページTOPに戻る</a>
					</div>
				<?php endif; ?>
			</div>



		</div> <!-- end of .container -->

		<?php $this->load->view('inc/_foot'); ?>
		<?php $this->load->view('inc/footer'); ?>
	</div> <!-- end of #wrapper -->

	<script src="<?= base_url('js/front.application_confirm.js') ?>?var=<?= CACHES_CLEAR_VERSION ?>"></script>
</body>
</html>
