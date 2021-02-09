<?php $this->load->view('inc/_head', array('TITLE' => SITE_NAME)); ?>

<body>
	<div id="wrapper">
		<?php $this->load->view('inc/header', array('MENU' => FALSE)); ?>

		<div class="container">
			<p class="lead-title">登録内容の確認</p>

			<div class="col-md-8 offset-md-2">
				<p class="favor">登録内容に間違いがなければ【登録】をクリックし、登録を完了させてください。</p>
			</div>

			<table class="confirm-table">
				<tr>
					<th>教室名（教室コード）</th>
					<td><?= isset($CNAME) ? $CNAME : '&nbsp;' ?>（<?= $PDATA['classroom_number'] ?>）</td>
				</tr>

				<tr>
					<th>メールアドレス</th>
					<td><?= isset($PDATA['email']) ? $PDATA['email'] : '&nbsp;' ?></td>
				</tr>

				<tr>
					<?php
						$password = '';
						$wk_password = isset($PDATA['password_hidden']) ? $PDATA['password_hidden'] : '';

						if( $wk_password != '' ) {
							for( $i = 0; $i < strlen($wk_password) - 3; $i++ ) {
								$password .= '*';
							}
							$password .= substr($wk_password, strlen($wk_password) - 3);
						}
					?>
					<th>パスワード</th>
					<td><?= $password ?></td>
				</tr>
			</table>

			<div class="text-center mt-5">
				<?php echo form_open('entry/complete', array('id' => 'frm_confirm')); ?>
					<?php echo form_hidden($PDATA); ?>

					<?php echo form_button(array(
						'name'		=> 'btn-back',
						'class'		=> 'btn btn-secondary',
						'content'	=> '　戻る　',
						'onclick'	=> 'do_submit(\'' . 'entry/index' . '\')'
					)); ?>&nbsp;&nbsp;

					<?php echo form_button(array(
						'name'		=> 'btn_submit',
						'class'		=> 'btn btn-success',
						'content'	=> '　登録　',
						'onclick'	=> 'do_submit(\'' . 'entry/complete' . '\')'
					)); ?>
				<?php echo form_close(); ?>
			</div>
		</div> <!-- end of .container -->

		<?php $this->load->view('inc/_foot'); ?>
		<?php $this->load->view('inc/footer'); ?>
	</div> <!-- end of #wrapper -->

	<script src="<?= base_url('js/front.entry_confirm.js') ?>?var=<?= CACHES_CLEAR_VERSION ?>"></script>
</body>
</html>
