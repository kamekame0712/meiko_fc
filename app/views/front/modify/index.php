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

			<?php if( get_instruction() ): ?>
				<div class="row justify-content-center">
					<div class="col-md-9">
						<div class="instruction" name="instruction">
							<h1>
								注意事項
								<a href="javascript:void();"><i class="fas fa-window-close"></i></a>
							</h1>

							<section>
								<ul>
									<li>
										変更できる項目は『メールアドレス』と『パスワード』のみです。<br>
									</li>
									<li>
										パスワードは変更する場合のみ入力してください。<br>
										※変更しない場合は空欄のままにしておいてください。
									</li>
								</ul>
							</section>

							<div class="instruction-footer">
								※この注意事項は【メニュー】より常に非表示にすることができます。
							</div>
						</div> <!-- end of .instruction -->
					</div>
				</div> <!-- end of .row -->
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
				</table>

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
