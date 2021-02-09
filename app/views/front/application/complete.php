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
						データ登録時にエラーが発生しました。<br>
						大変申し訳ございませんが、しばらく時間を空け、再度登録をお願いします。<br><br>
						エラーが繰り返される場合、お手数ですが弊社までご連絡いただきますよう、お願いいたします。<br>
						　　TEL：082-227-3999
					</p>

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
