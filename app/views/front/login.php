<?php $this->load->view('inc/_head', array('TITLE' => 'ログイン/' . SITE_NAME)); ?>

<body>
	<div id="wrapper">
		<?php $this->load->view('inc/header', array('MENU' => FALSE)); ?>

		<div class="container">
			<div class="for-pc">
				<?php echo form_open('index/do_login'); ?>
					<div class="login">
						<p class="title">ログイン</p>

						<?php echo form_input(array(
							'name'	=> 'email',
							'value'	=> set_value('email', ''),
							'class'	=> 'input-item',
							'placeholder'	=> 'メールアドレス'
						)); ?>
						<i class="fa fa-envelope"></i>

						<?php echo form_input(array(
							'name'	=> 'password',
							'type'	=> 'password',
							'class'	=> 'input-item',
							'placeholder'	=> 'パスワード'
						)); ?>
						<i class="fa fa-key"></i>

						<?php echo validation_errors(); ?>

						<p class="mt-5 comment">まだ登録がお済みでない方は<a href="<?= site_url('entry') ?>">こちら</a></p>
						<p class="mb-2 comment">パスワードをお忘れの方は<a href="<?= site_url('forgot') ?>">こちら</a></p>

						<?php echo form_submit(array(
							'name'	=> 'btn-submit',
							'value'	=> 'ログイン',
							'class'	=> 'btn-submit'
						)); ?>
					</div> <!-- end of login-box -->
				<?php echo form_close(); ?>

				<div class="attention-box" style="margin-top:100px;">
					<h3>始めてご利用される方は<span class="attention-msg">メールアドレスとパスワードの登録</span>をお願いします。</h3>
					ご登録いただいたメールアドレスとパスワードはログインに使用していただきます。<br>
					また、ご注文いただいた内容の確認の為、ご登録いただいたメールアドレス宛てにメールをお送りします。<br><br>
					まだ登録がお済みでない方は<a href="<?= site_url('entry') ?>">こちら</a>からお願いします。
				</div>
			</div>

			<div class="for-sp">
				当サイトはスマホ・タブレットに対応しておりません。<br>
				申し訳ございませんが、PCでのアクセスをお願いします。
			</div>
		</div> <!-- end of container -->

		<?php $this->load->view('inc/_foot'); ?>
		<?php $this->load->view('inc/footer'); ?>
	</div> <!-- end of #wrapper -->

</body>
</html>
