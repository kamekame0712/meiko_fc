<?php $this->load->view('inc/_head', array('TITLE' => SITE_NAME)); ?>

<body>
	<div id="wrapper">
		<?php $this->load->view('inc/header', array('MENU' => FALSE)); ?>

		<div class="container">
			<p class="lead-title">パスワードの再発行</p>

			<div class="text-right">
				<a href="<?= site_url('') ?>" class="btn btn-sm btn-secondary">ログイン画面に戻る</a>
			</div>

			<?php if( $ERR_MSG == '' ): ?>
				<div class="col-md-8 offset-md-2">
					<p class="favor">パスワードを再発行しました。</p>
					新しいパスワードはメールでお知らせしております。<br>
					ご確認ください。
				</div>
			<?php else: ?>
				<div class="col-md-8 offset-md-2">
					<p class="favor">エラーが発生しました。</p>
					<?= $ERR_MSG ?><br><br>
					お手数ですが、もう一度再発行の手続きを行ってください。
				</div>
			<?php endif; ?>
		</div> <!-- end of .container -->

		<?php $this->load->view('inc/_foot'); ?>
		<?php $this->load->view('inc/footer'); ?>
	</div> <!-- end of #wrapper -->

</body>
</html>
