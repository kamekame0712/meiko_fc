<?php $this->load->view('inc/_head', array('TITLE' => SITE_NAME)); ?>

<body>
	<div id="wrapper">
		<?php $this->load->view('inc/header', array('MENU' => FALSE)); ?>

		<div class="container">
			<p class="lead-title">パスワードの再発行</p>

			<div class="text-right">
				<a href="<?= site_url('') ?>" class="btn btn-sm btn-secondary">ログイン画面に戻る</a>
			</div>

			<?php echo form_open('forgot/reissue'); ?>
				<div class="col-md-8 offset-md-2">
					<p class="favor">ご登録時のメールアドレスを入力して【再発行】ボタンをクリックしてください。</p>
				</div>

				<div class="form-group row mt-5">
					<div class="col-md-2 offset-md-3">メールアドレス</div>
					<div class="col-md-4">
						<?php echo form_input(array(
							'name'	=> 'email',
							'value'	=> '',
							'class'	=> 'form-control entry-input'
						)); ?>
					</div>
				</div> <!-- end of .form-group row -->

				<div class="text-center">
					<?php echo form_submit(array(
						'name'	=> 'btn-submit',
						'class'	=> 'btn btn-success',
						'value'	=> '　再発行　'
					)); ?>
				</div>
			<?php echo form_close(); ?>
		</div> <!-- end of .container -->

		<?php $this->load->view('inc/_foot'); ?>
		<?php $this->load->view('inc/footer'); ?>
	</div> <!-- end of #wrapper -->

</body>
</html>
