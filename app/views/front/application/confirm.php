<?php $this->load->view('inc/_head', array('TITLE' => SITE_NAME)); ?>

<body>
	<div id="wrapper">
		<?php $this->load->view('inc/header', array('MENU' => FALSE)); ?>

		<div class="container">
			<p class="lead-title">ご利用申込み 確認</p>

			<table class="confirm-table">
				<tr>
					<th>オーナー名</th>
					<td><?= $PDATA['owner_name'] ?></td>
				</tr>

				<?php if( !empty($PDATA['corpo_name']) ): ?>
					<tr>
						<th>法人名</th>
						<td><?= $PDATA['corpo_name'] ?></td>
					</tr>
				<?php endif; ?>

				<tr>
					<th>住所</th>
					<td>
						〒<?= $PDATA['zip1'] ?>-<?= $PDATA['zip2'] ?><br>
						<?= $CONF['pref'][$PDATA['pref']] ?><?= $PDATA['addr1'] ?><?= $PDATA['addr2'] ?>
					</td>
				</tr>

				<tr>
					<th>電話番号</th>
					<td><?= $PDATA['tel1'] ?>-<?= $PDATA['tel2'] ?>-<?= $PDATA['tel3'] ?></td>
				</tr>

				<?php if( !empty($PDATA['fax1']) &&  !empty($PDATA['fax2']) &&  !empty($PDATA['fax3']) ): ?>
					<tr>
						<th>FAX番号</th>
						<td><?= $PDATA['fax1'] ?>-<?= $PDATA['fax2'] ?>-<?= $PDATA['fax3'] ?></td>
					</tr>
				<?php endif; ?>

				<tr>
					<th>メールアドレス</th>
					<td><?= $PDATA['email'] ?></td>
				</tr>

				<tr>
					<th>運営教室</th>
					<td>
						<?php if( !empty($CDATA) ): ?>
							<?php foreach( $CDATA as $val ): ?>
								<?= $val['name'] ?>（<?= $val['classroom_number'] ?>）<br>
							<?php endforeach; ?>
							<span class="classroom-total-num">全<?= count($CDATA) ?>教室</span>
						<?php else: ?>
							&nbsp;
						<?php endif; ?>
					</td>
				</tr>

				<tr>
					<th>お支払方法</th>
					<td>
						<?php
							$payment_method = array();
							if( !empty($PDATA['payment_method1']) ) {
								$payment_method[] = '買掛';
							}
							if( !empty($PDATA['payment_method2']) ) {
								$payment_method[] = 'クレジットカード';
							}
							if( !empty($PDATA['payment_method3']) ) {
								$payment_method[] = '代金引換';
							}
						?>

						<?= implode(',', $payment_method) ?>
						<?php if( !empty($PDATA['payment_method1']) ): ?>
							<p class="account-attention">買掛取り引きをご希望の方は引き続き、買掛取り引きの申請をお願いします。</p>
						<?php endif; ?>
					</td>
				</tr>
			</table>

			<?php echo form_open('application/complete', array('id' => 'frm_application_confirm')); ?>
				<div class="text-center my-5">
					<?php echo form_hidden($PDATA); ?>

					<?php echo form_button(array(
						'name'		=> 'btn_back',
						'class'		=> 'btn btn-secondary',
						'content'	=> '　戻る　',
						'onclick'	=> 'do_submit(1);'
					)); ?>&nbsp;&nbsp;&nbsp;

					<?php echo form_button(array(
						'name'		=> 'btn_submit',
						'class'		=> 'btn btn-success',
						'content'	=> !empty($PDATA['payment_method1']) ? '登録して買掛取引の申請へ進む' : '　登録　',
						'onclick'	=> 'do_submit(2);'
					)); ?>
				</div>
			<?php echo form_close(); ?>
		</div> <!-- end of .container -->

		<?php $this->load->view('inc/_foot'); ?>
		<?php $this->load->view('inc/footer'); ?>
	</div> <!-- end of #wrapper -->

	<script src="<?= base_url('js/front.application_confirm.js') ?>?var=<?= CACHES_CLEAR_VERSION ?>"></script>
</body>
</html>
