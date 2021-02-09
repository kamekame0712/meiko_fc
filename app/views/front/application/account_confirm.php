<?php $this->load->view('inc/_head', array('TITLE' => SITE_NAME)); ?>

<body>
	<div id="wrapper">
		<?php $this->load->view('inc/header', array('MENU' => FALSE)); ?>

		<div class="container">
			<p class="lead-title">掛け取り引き申請 確認</p>

			<table class="confirm-table">
				<?php if( $PDATA['corporation'] == 1 ): ?>
					<tr>
						<th>事業形態</th>
						<td>法人</td>
					</tr>

					<tr>
						<th>法人名</th>
						<td><?= $PDATA['corpo_name'] ?></td>
					</tr>

					<tr>
						<th>代表者名</th>
						<td><?= $PDATA['executive'] ?></td>
					</tr>

					<tr>
						<th>法人住所</th>
						<td>
							〒<?= $PDATA['zip1'] ?>-<?= $PDATA['zip2'] ?><br>
							<?= $CONF['pref'][$PDATA['pref']] ?><?= $PDATA['addr1'] ?><?= $PDATA['addr2'] ?>
						</td>
					</tr>

					<tr>
						<th>代表電話番号</th>
						<td><?= $PDATA['tel1'] ?>-<?= $PDATA['tel2'] ?>-<?= $PDATA['tel3'] ?></td>
					</tr>
				<?php else: ?>
					<tr>
						<th>事業形態</th>
						<td>非法人</td>
					</tr>

					<tr>
						<th>代表者名</th>
						<td><?= $PDATA['corpo_name'] ?></td>
					</tr>

					<tr>
						<th>代表者自宅住所</th>
						<td>
							〒<?= $PDATA['zip1'] ?>-<?= $PDATA['zip2'] ?><br>
							<?= $CONF['pref'][$PDATA['pref']] ?><?= $PDATA['addr1'] ?><?= $PDATA['addr2'] ?>
						</td>
					</tr>

					<tr>
						<th>代表者電話番号</th>
						<td><?= $PDATA['tel1'] ?>-<?= $PDATA['tel2'] ?>-<?= $PDATA['tel3'] ?></td>
					</tr>
				<?php endif; ?>

				<?php if( !empty($PDATA['fax1']) &&  !empty($PDATA['fax2']) &&  !empty($PDATA['fax3']) ): ?>
					<tr>
						<th>FAX番号</th>
						<td><?= $PDATA['fax1'] ?>-<?= $PDATA['fax2'] ?>-<?= $PDATA['fax3'] ?></td>
					</tr>
				<?php endif; ?>

				<tr>
					<th>ご請求先</th>
					<td><?= $PDATA['bill_to'] == '1' ? '上記と同じ' : '上記とは別' ?></td>
				</tr>

				<?php if( $PDATA['bill_to'] == '2' ): ?>
					<tr>
						<th>ご請求先名</th>
						<td><?= $PDATA['bill_name'] ?></td>
					</tr>

					<tr>
						<th>ご請求先住所</th>
						<td>
							〒<?= $PDATA['bill_zip1'] ?>-<?= $PDATA['bill_zip2'] ?><br>
							<?= $CONF['pref'][$PDATA['bill_pref']] ?><?= $PDATA['bill_addr1'] ?><?= $PDATA['bill_addr2'] ?>
						</td>
					</tr>

					<tr>
						<th>ご請求先電話番号</th>
						<td><?= $PDATA['bill_tel1'] ?>-<?= $PDATA['bill_tel2'] ?>-<?= $PDATA['bill_tel3'] ?></td>
					</tr>

					<?php if( !empty($PDATA['bill_note']) ): ?>
						<tr>
							<th>備考</th>
							<td><?= nl2br($PDATA['bill_note']) ?></td>
						</tr>
					<?php endif; ?>
				<?php endif; ?>

				<tr>
					<th>決済方法</th>
					<td>
						<?php
							if( $PDATA['settlement_method'] == '1' ) {
								$settlement = '振込（お振込み名義：' . $PDATA['transfer_name'] . '）';
							}
							else {
								$settlement = '口座引落（金融機関名：' . $PDATA['bank_name'] . '）';
							}
						?>
						<?= $settlement ?>
					</td>
				</tr>
			</table>

			<?php echo form_open('application/account_complete', array('id' => 'frm_account_confirm')); ?>
				<div class="text-center my-5">
					<?php echo form_hidden($PDATA); ?>

					<?php echo form_button(array(
						'name'		=> 'btn_back',
						'class'		=> 'btn btn-secondary',
						'content'	=> '　戻る　',
						'onclick'	=> 'do_submit(1, ' . $PDATA['owner_id'] . ');'
					)); ?>&nbsp;&nbsp;&nbsp;

					<?php echo form_button(array(
						'name'		=> 'btn_submit',
						'class'		=> 'btn btn-success',
						'content'	=> '　登録　',
						'onclick'	=> 'do_submit(2, 0);'
					)); ?>
				</div>
			<?php echo form_close(); ?>
		</div> <!-- end of .container -->

		<?php $this->load->view('inc/_foot'); ?>
		<?php $this->load->view('inc/footer'); ?>
	</div> <!-- end of #wrapper -->

	<script src="<?= base_url('js/front.account_confirm.js') ?>?var=<?= CACHES_CLEAR_VERSION ?>"></script>
</body>
</html>
