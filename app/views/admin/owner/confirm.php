<?php $this->load->view('inc/admin/_head', array('TITLE' => 'オーナー管理 | ' . SITE_NAME)); ?>

<body>
	<div id="app">
		<div class="main-wrapper main-wrapper-1">
			<?php $this->load->view('inc/admin/header'); ?>
			<?php $this->load->view('inc/admin/sidebar', array('current' => 'owner')); ?>

			<div class="main-content">
				<section class="section">
					<div class="section-header">
						<h1>オーナー管理 <?= $PDATA['kind'] == 'add' ? '新規追加' : '修正' ?> 確認</h1>
					</div>

					<div class="section-body">
						<div class="row">
							<div class="col-4">
								<div class="card card-primary">
									<div class="card-header">
										<h4>オーナー情報</h4>
									</div>
									<div class="card-body">
										<dl class="owner-confirm">
											<dt>オーナー名</dt>
											<dd><?= $PDATA['owner_name'] ?></dd>

											<dt>法人名</dt>
											<?php if( !empty($PDATA['corpo_name']) ): ?>
												<dd><?= $PDATA['corpo_name'] ?></dd>
											<?php else: ?>
												<dd>（入力なし）</dd>
											<?php endif; ?>

											<dt>郵便番号</dt>
											<dd><?= $PDATA['zip1'] ?>-<?= $PDATA['zip2'] ?></dd>

											<dt>住所</dt>
											<dd><?= $CONF['pref'][$PDATA['pref']] ?><?= $PDATA['addr1'] ?><?= $PDATA['addr2'] ?></dd>

											<dt>電話番号</dt>
											<dd><?= $PDATA['tel1'] ?>-<?= $PDATA['tel2'] ?>-<?= $PDATA['tel3'] ?></dd>

											<dt>FAX番号</dt>
											<?php if( !empty($PDATA['fax1']) && !empty($PDATA['fax2']) && !empty($PDATA['fax3']) ): ?>
												<dd><?= $PDATA['fax1'] ?>-<?= $PDATA['fax2'] ?>-<?= $PDATA['fax3'] ?></dd>
											<?php else: ?>
												<dd>（入力なし）</dd>
											<?php endif; ?>

											<dt>メールアドレス</dt>
											<dd><?= $PDATA['email'] ?></dd>

											<dt>お支払方法</dt>
											<dd><?= $PAYMENT ?></dd>
										</dl>
									</div>
								</div> <!-- end of .card -->
							</div>

							<?php if( !empty($PDATA['payment_method1']) && $PDATA['payment_method1'] == '1' ): ?>
								<div class="col-4">
									<div class="card card-primary">
										<div class="card-header">
											<h4>買掛情報</h4>
										</div>
										<div class="card-body">
											<dl class="owner-confirm">
												<dt>事業形態</dt>
												<dd><?= $PDATA['corporation'] == '1' ? '法人' : '非法人' ?></dd>

												<dt><?= $PDATA['corporation'] == '1' ? '法人名' : '代表者名' ?></dt>
												<dd><?= $PDATA['account_corpo_name'] ?></dd>

												<?php if( $PDATA['corporation'] == '1' ): ?>
													<dt>代表者名</dt>
													<dd><?= $PDATA['account_executive'] ?></dd>
												<?php endif; ?>

												<dt><?= $PDATA['corporation'] == '1' ? '法人郵便番号' : '代表者自宅郵便番号' ?></dt>
												<dd><?= $PDATA['account_zip1'] ?>-<?= $PDATA['account_zip2'] ?></dd>

												<dt><?= $PDATA['corporation'] == '1' ? '法人住所' : '代表者自宅住所' ?></dt>
												<dd><?= $CONF['pref'][$PDATA['account_pref']] ?><?= $PDATA['account_addr1'] ?><?= $PDATA['account_addr2'] ?></dd>

												<dt><?= $PDATA['corporation'] == '1' ? '代表電話番号' : '代表者電話番号' ?></dt>
												<dd><?= $PDATA['account_tel1'] ?>-<?= $PDATA['account_tel2'] ?>-<?= $PDATA['account_tel3'] ?></dd>

												<dt>FAX番号</dt>
												<?php if( !empty($PDATA['account_fax1']) && !empty($PDATA['account_fax2']) && !empty($PDATA['account_fax3']) ): ?>
													<dd><?= $PDATA['account_fax1'] ?>-<?= $PDATA['account_fax2'] ?>-<?= $PDATA['account_fax3'] ?></dd>
												<?php else: ?>
													<dd>（入力なし）</dd>
												<?php endif; ?>

												<dt>ご請求先</dt>
												<dd><?= $PDATA['bill_to'] == '1' ? '上記と同じ' : '上記とは別' ?></dd>

												<?php if( $PDATA['bill_to'] == '2' ): ?>
													<dt>ご請求先名</dt>
													<dd><?= $PDATA['bill_name'] ?></dd>

													<dt>ご請求先郵便番号</dt>
													<dd><?= $PDATA['bill_zip1'] ?>-<?= $PDATA['bill_zip2'] ?></dd>

													<dt>ご請求先住所</dt>
													<dd><?= $CONF['pref'][$PDATA['bill_pref']] ?><?= $PDATA['bill_addr1'] ?><?= $PDATA['bill_addr2'] ?></dd>

													<dt>ご請求先電話番号</dt>
													<dd><?= $PDATA['bill_tel1'] ?>-<?= $PDATA['bill_tel2'] ?>-<?= $PDATA['bill_tel3'] ?></dd>
												<?php endif; ?>

												<dt>決済方法</dt>
												<dd><?= $PDATA['settlement_method'] == '1' ? '振込' : '口座引落' ?></dd>

												<?php if( $PDATA['settlement_method'] == '1' ): ?>
													<dt>振込み名義</dt>
													<dd><?= $PDATA['transfer_name'] ?></dd>
												<?php else: ?>
													<dt>金融機関名</dt>
													<dd><?= $PDATA['bank_name'] ?></dd>
												<?php endif; ?>
											</dl>
										</div>
									</div> <!-- end of .card -->
								</div>
							<?php endif; ?>

							<div class="col-4">
								<div class="card card-primary">
									<div class="card-header">
										<h4>運営教室</h4>
									</div>
									<div class="card-body">
										<?= $CLASSROOM ?>
									</div>
								</div> <!-- end of .card -->
							</div>
						</div> <!-- end of .row -->

						<?php echo form_open('admin/owner/complete', array('id' => 'frm_owner_confirm')); ?>
							<?php echo form_hidden($PDATA); ?>

							<div class="row justify-content-center">
								<div class="col-1 text-center">
									<?php echo form_button(array(
										'name'		=> 'btn_back',
										'content'	=> '戻る',
										'class'		=> 'btn btn-light btn-lg note-btn',
										'onclick'	=> 'do_submit(1, \'' . $PDATA['kind'] . '\', \'' . $PDATA['owner_id'] . '\');'
									)); ?>
								</div>

								<div class="col-1 text-center">
									<?php echo form_button(array(
										'name'		=> 'btn_submit',
										'content'	=> '登録',
										'class'		=> 'btn btn-primary btn-lg note-btn',
										'onclick'	=> 'do_submit(2, \'\', \'\');'
									)); ?>
								</div>
							</div> <!-- end of .row -->
						<?php echo form_close(); ?>
					</div> <!-- end of .section-body -->
				</section>
			</div> <!-- end of .main-content -->

			<?php $this->load->view('inc/admin/footer'); ?>
		</div> <!-- end of .main-wrapper -->
	</div> <!-- end of #app -->

	<?php $this->load->view('inc/admin/_foot'); ?>

	<script src="<?= base_url('js/admin/owner_confirm.js')?>?var=<?= CACHES_CLEAR_VERSION ?>"></script>
</body>
</html>
