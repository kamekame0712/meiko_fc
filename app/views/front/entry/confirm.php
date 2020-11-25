<?php $this->load->view('inc/_head', array('TITLE' => SITE_NAME)); ?>

<body>
	<div id="wrapper">
		<?php $this->load->view('inc/header', array('MENU' => FALSE)); ?>

		<div class="container">
			<p class="lead-title">登録内容の確認</p>

			<div class="col-md-8 offset-md-2">
				<p class="favor">登録内容に間違いがなければ【登録】をクリックし、登録を完了させてください。</p>
			</div>

			<table class="register-confirm">
				<tr>
					<th>教室名（教室コード）</th>
					<td><?= isset($PDATA['classroom_name']) ? $PDATA['classroom_name'] : '&nbsp;' ?>（<?= $PDATA['classroom_number'] ?>）</td>
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

				<?php if( $PDATA['flg_parent'] == '1' ): ?>
					<tr>
						<th>『掛け』でのお取引</th>
						<td><?= ( isset($PDATA['apply_account']) && $PDATA['apply_account'] == '1' ) ? '登録を希望する' : '登録を希望しない' ?></td>
					</tr>

					<?php if( isset($PDATA['apply_account']) && $PDATA['apply_account'] == '1' ): ?>
						<?php if( $PDATA['corporation'] == '1' ): ?>
							<tr>
								<th>事業形態</th>
								<td>法人</td>
							</tr>

							<tr>
								<th>法人名</th>
								<td><?= $PDATA['corporation_name'] ?></td>
							</tr>

							<tr>
								<th>法人住所</th>
								<td>
									〒<?= $PDATA['corporation_zip1'] ?>-<?= $PDATA['corporation_zip1'] ?><br>
									<?= $CONF['pref'][$PDATA['corporation_pref']] ?><?= $PDATA['corporation_addr1'] ?><?= $PDATA['corporation_addr2'] ?>
								</td>
							</tr>

							<tr>
								<th>代表電話番号</th>
								<td><?= $PDATA['corporation_tel01'] ?>-<?= $PDATA['corporation_tel02'] ?>-<?= $PDATA['corporation_tel03'] ?></td>
							</tr>

							<tr>
								<th>代表者名</th>
								<td><?= $PDATA['corporation_executive'] ?></td>
							</tr>
						<?php else: ?>
							<tr>
								<th>事業形態</th>
								<td>非法人</td>
							</tr>

							<tr>
								<th>代表者名</th>
								<td><?= $PDATA['corporation_name'] ?></td>
							</tr>

							<tr>
								<th>代表者自宅住所</th>
								<td>
									〒<?= $PDATA['corporation_zip1'] ?>-<?= $PDATA['corporation_zip1'] ?><br>
									<?= $CONF['pref'][$PDATA['corporation_pref']] ?><?= $PDATA['corporation_addr1'] ?><?= $PDATA['corporation_addr2'] ?>
								</td>
							</tr>

							<tr>
								<th>代表者電話番号</th>
								<td><?= $PDATA['corporation_tel01'] ?>-<?= $PDATA['corporation_tel02'] ?>-<?= $PDATA['corporation_tel03'] ?></td>
							</tr>
						<?php endif; ?>

						<tr>
							<th>お支払い方法</th>
							<td><?= ( isset($PDATA['payment_method']) && $PDATA['payment_method'] == '1' ) ? '振込（月末締め、翌月末払い）' : '口座引落（２０日締め、翌月１３日引落）' ?></td>
						</tr>

						<?php if( isset($PDATA['payment_method']) && $PDATA['payment_method'] == '1' ): ?>
							<tr>
								<th>お振込み名義</th>
								<td><?= $PDATA['transfer_name'] ?></td>
							</tr>
						<?php endif; ?>
					<?php endif; ?>
				<?php endif; ?>
			</table>

			<div class="text-center my-5">
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
