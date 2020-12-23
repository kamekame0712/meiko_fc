<?php $this->load->view('inc/_head', array('TITLE' => SITE_NAME)); ?>

<body>
	<div id="wrapper">
		<?php $this->load->view('inc/header', array('MENU' => TRUE)); ?>

		<div class="container">
			<?php if( $ERRMSG != '' ): ?>
				<?php if( $ERRMSG == 'OK' ): ?>
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						処理が完了しました。
						<button type="button" class="close" data-dismiss="alert" aria-label="閉じる">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<?php else: ?>
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<?= $ERRMSG ?>
						<button type="button" class="close" data-dismiss="alert" aria-label="閉じる">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<?php endif; ?>
			<?php endif; ?>

			<?php echo form_open('modify/complete', array('id' => 'frm_modify')); ?>
				<p class="lead-title">登録情報変更</p>

				<table class="confirm-table">
					<tr>
						<th>教室名</th>
						<td><?= isset($DATA['name']) ? $DATA['name'] : '&nbsp;' ?></td>
					</tr>

					<tr>
						<th>メールアドレス</th>
						<td>
							<?php echo form_input(array(
								'name'	=> 'email',
								'id'	=> 'email',
								'value'	=> set_value('email', ( !empty($DATA['email']) ? $DATA['email'] : '' )),
								'class'	=> 'form-control entry-input'
							)); ?>
						</td>
					</tr>

					<tr>
						<th>パスワード</th>
						<td>
							<?php echo form_input(array(
								'name'	=> 'password',
								'id'	=> 'password',
								'value'	=> '',
								'class'	=> 'form-control entry-input'
							)); ?>
							<p class="attention">※パスワードは変更する場合のみ入力してください。</p>
							（変更する場合は8文字以上を指定してください。）
						</td>
					</tr>

					<?php if( $DATA['classroom_id'] == $DATA['parent_id'] ): ?>
						<tr>
							<th>『掛け』取引情報</th>
							<td>
								こちらでは『掛け』取引に関する情報の変更、申込等は行えません。<br>
								中央教育研究所株式会社に直接ご連絡ください。
							</td>
						</tr>
					<?php endif; ?>
				</table>

				<?php if( $DATA['classroom_id'] == $DATA['parent_id'] ): ?>
					<p class="lead-title mt-5">支払方法設定</p>

				<?php endif; ?>

				<div class="text-center mt-5">
					<?php echo form_submit(array(
						'name'	=> 'btn_submit',
						'class'	=> 'btn btn-success',
						'value'	=> '　更新　'
					)); ?>
				</div>
			<?php echo form_close(); ?>
		</div> <!-- end of .container -->

		<?php $this->load->view('inc/_foot'); ?>
		<?php $this->load->view('inc/footer'); ?>
	</div> <!-- end of #wrapper -->

	<script src="<?= base_url('js/front.modify.js') ?>?var=<?= CACHES_CLEAR_VERSION ?>"></script>
</body>
</html>
