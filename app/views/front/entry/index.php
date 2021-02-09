<?php $this->load->view('inc/_head', array('TITLE' => SITE_NAME)); ?>

<body>
	<div id="wrapper">
		<?php $this->load->view('inc/header', array('MENU' => FALSE)); ?>

		<div class="container">
			<p class="lead-title">お客様情報登録</p>

			<div class="text-right">
				<a href="<?= site_url('') ?>" class="btn btn-sm btn-secondary">ログイン画面に戻る</a>
			</div>

			<?php echo form_open('entry/confirm', array('id' => 'frm_entry')); ?>
				<div class="col-md-8 offset-md-2">
					<p class="favor">１．教室コードを入力してください。</p>
				</div>

				<div class="form-group row">
					<div class="col-md-2 offset-md-3">教室コード</div>
					<div class="col-md-4">
						<?php echo form_input(array(
							'name'	=> 'classroom_number',
							'id'	=> 'classroom_number',
							'value'	=> set_value('classroom_number', ''),
							'class'	=> 'form-control entry-input',
							'placeholder'	=> '0000'
						)); ?>
						<?php echo form_error('classroom_number'); ?>
					</div>
				</div> <!-- end of .form-group row -->

				<div class="form-group row" id="classroom_name" style="display:none;">
					<div class="col-md-2 offset-md-3">教室名</div>
					<div class="col-md-4">
						<span class="registered-classroom-name" id="show_classroom_name"><?= !empty($CNAME) ? $CNAME : '' ?></span>
					</div>
				</div> <!-- end of .form-group row -->

				<div id="required_item" class="mt-5" style="display:none;">
					<div class="col-md-8 offset-md-2">
						<p class="favor">２．登録に必要な項目を入力してください。</p>
					</div>

					<div class="form-group row">
						<div class="col-md-2 offset-md-3">メールアドレス</div>
						<div class="col-md-4">
							<?php echo form_input(array(
								'name'	=> 'email',
								'id'	=> 'email',
								'value'	=> set_value('email', ''),
								'class'	=> 'form-control entry-input',
								'placeholder'	=> 'info@chuoh-kyouiku.co.jp'
							)); ?>
							<?php echo form_error('email'); ?>
						</div>
					</div> <!-- end of .form-group row -->

					<div class="form-group row">
						<div class="col-md-2 offset-md-3">パスワード</div>
						<div class="col-md-4">
							<?php echo form_input(array(
								'name'	=> 'password_hidden',
								'id'	=> 'password_hidden',
								'value'	=> set_value('password_hidden', ''),
								'type'	=> 'password',
								'class'	=> 'form-control entry-input'
							)); ?>

							<?php echo form_input(array(
								'name'	=> 'password_show',
								'id'	=> 'password_show',
								'value'	=> set_value('password_show', ''),
								'class'	=> 'form-control entry-input',
								'style'	=> 'display:none;'
							)); ?>
							<?php echo form_error('password_show'); ?>
						</div>
						<div class="col-md-3">
							<?php echo form_checkbox(array(
								'name'	=> 'chk_pw',
								'id'	=> 'chk_pw',
								'checked'	=> FALSE
							)); ?>
							<?php echo form_label('パスワードを表示する', 'chk_pw'); ?>
						</div>
					</div> <!-- end of .form-group row -->

					<div class="form-group row">
						<div class="col-md-7 offset-md-5">
							※パスワードは8文字以上を指定してください。<br>
							※ここで登録したメールアドレスとパスワードでログインを行います。
						</div>
					</div> <!-- end of .form-group row -->

					<div class="text-center my-5">
						<?php echo form_submit(array(
							'name'	=> 'btn_submit',
							'class'	=> 'btn btn-success mt-5',
							'value'	=> '　確認　'
						)); ?>
					</div>
				</div> <!-- end of #required_item -->
			<?php echo form_close(); ?>
		</div> <!-- end of .container -->

		<?php $this->load->view('inc/_foot'); ?>
		<?php $this->load->view('inc/footer'); ?>
	</div> <!-- end of #wrapper -->

	<script src="<?= base_url('js/front.entry.js') ?>?var=<?= CACHES_CLEAR_VERSION ?>"></script>
</body>
</html>
