<?php $this->load->view('inc/_head', array('TITLE' => SITE_NAME)); ?>

<body>
	<div id="wrapper">
		<?php $this->load->view('inc/header', array('MENU' => FALSE)); ?>

		<div class="container">
			<p class="lead-title">パスワードの再発行</p>

			<div class="text-right">
				<a href="<?= site_url('') ?>" class="btn btn-sm btn-secondary">ログイン画面に戻る</a>
			</div>

			<?php if( $EXISTS ): ?>
				<div class="col-md-8 offset-md-2">
					<p class="favor">パスワードの再発行メールを送信しました。</p>
					メール本文中にパスワードの再発行を行うURLを記載しております。<br>
					内容をご確認の上、パスワードの再発行をお願いします。
				</div>
			<?php else: ?>
				<div class="col-md-8 offset-md-2">
					<p class="favor">登録されていないメールアドレスです。</p>
					ご登録のメールアドレスをご確認の上、再度お手続きをお願いします。
				</div>
			<?php endif; ?>
		</div> <!-- end of .container -->

		<?php $this->load->view('inc/_foot'); ?>
		<?php $this->load->view('inc/footer'); ?>
	</div> <!-- end of #wrapper -->

</body>
</html>
