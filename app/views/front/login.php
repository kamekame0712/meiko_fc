<?php $this->load->view('inc/_head', array('TITLE' => 'ログイン/' . SITE_NAME)); ?>

<body>
	<div id="wrapper">
		<?php $this->load->view('inc/header'); ?>

		<div class="container">
			<?php echo form_open('login/do_login'); ?>
				<div class="login">
					<p class="title">ログイン</p>

					<?php echo form_input(array(
						'name'	=> 'email',
						'value'	=> set_value('email', ''),
						'class'	=> 'input-item',
						'placeholder'	=> 'メールアドレス'
					)); ?>
					<?= form_error('email') ?>
					<i class="fa fa-envelope"></i>

					<?php echo form_input(array(
						'name'	=> 'password',
						'type'	=> 'password',
						'class'	=> 'input-item',
						'placeholder'	=> 'パスワード'
					)); ?>
					<?= form_error('password') ?>
					<i class="fa fa-key"></i>

					<p class="mt-5 comment">まだ登録がお済みでない方は<a href="<?= site_url('entry') ?>">こちら</a></p>
					<p class="mb-2 comment">パスワードをお忘れの方は<a href="#">こちら</a></p>

					<?php echo form_submit(array(
						'name'	=> 'btn-submit',
						'value'	=> 'ログイン',
						'class'	=> 'btn-submit'
					)); ?>
				</div> <!-- end of login-box -->
			<?php echo form_close(); ?>
		</div> <!-- end of container -->

		<?php $this->load->view('inc/_foot'); ?>
		<?php $this->load->view('inc/footer'); ?>
	</div> <!-- end of #wrapper -->

</body>
</html>
