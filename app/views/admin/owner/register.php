<?php $this->load->view('inc/admin/_head', array('TITLE' => 'オーナー管理 | ' . SITE_NAME)); ?>

<body>
	<div id="app">
		<div class="main-wrapper main-wrapper-1">
			<?php $this->load->view('inc/admin/header'); ?>
			<?php $this->load->view('inc/admin/sidebar', array('current' => 'owner')); ?>

			<div class="main-content">
				<section class="section">
					<div class="section-header">
						<h1>オーナー管理 登録</h1>
					</div>

					<div class="section-body">
						<div class="row">
							<div class="col-4">
								<div class="card card-primary">
									<div class="card-header">
										オーナー情報
									</div>
									<div class="card-body">
										<dl class="owner-confirm">
											<dt>オーナー名</dt>
											<dd><?= $ODATA['owner_name'] ?></dd>

											<dt>法人名</dt>
											<?php if( !empty($ODATA['corpo_name']) ): ?>
												<dd><?= $ODATA['corpo_name'] ?></dd>
											<?php else: ?>
												<dd>（入力なし）</dd>
											<?php endif; ?>

											<dt>郵便番号</dt>
											<dd><?= $ODATA['zip1'] ?>-<?= $ODATA['zip2'] ?></dd>

											<dt>住所</dt>
											<dd><?= $CONF['pref'][$ODATA['pref']] ?><?= $ODATA['addr1'] ?><?= $ODATA['addr2'] ?></dd>

											<dt>電話番号</dt>
											<dd><?= $ODATA['tel1'] ?>-<?= $ODATA['tel2'] ?>-<?= $ODATA['tel3'] ?></dd>

											<dt>FAX番号</dt>
											<?php if( !empty($ODATA['fax1']) && !empty($ODATA['fax2']) && !empty($ODATA['fax3']) ): ?>
												<dd><?= $ODATA['fax1'] ?>-<?= $ODATA['fax2'] ?>-<?= $ODATA['fax3'] ?></dd>
											<?php else: ?>
												<dd>（入力なし）</dd>
											<?php endif; ?>

											<dt>メールアドレス</dt>
											<dd><?= $ODATA['email'] ?></dd>

											<dt>お支払方法</dt>
											<dd><?= $PAYMENT ?></dd>
										</dl>
									</div>
								</div> <!-- end of .card -->
							</div>

							<?php if( !empty($ODATA['payment_method1']) && $ODATA['payment_method1'] == '1' ): ?>
								<div class="col-4">
									<div class="card card-primary">
										<div class="card-header">
											買掛情報
										</div>
										<div class="card-body">
											<dl class="owner-confirm">
												<dt>事業形態</dt>
												<dd><?= $ADATA['corporation'] == '1' ? '法人' : '非法人' ?></dd>

												<dt><?= $ADATA['corporation'] == '1' ? '法人名' : '代表者名' ?></dt>
												<dd><?= $ADATA['corpo_name'] ?></dd>

												<?php if( $ADATA['corporation'] == '1' ): ?>
													<dt>代表者名</dt>
													<dd><?= $ADATA['executive'] ?></dd>
												<?php endif; ?>

												<dt><?= $ADATA['corporation'] == '1' ? '法人郵便番号' : '代表者自宅郵便番号' ?></dt>
												<dd><?= $ADATA['zip1'] ?>-<?= $ADATA['zip2'] ?></dd>

												<dt><?= $ADATA['corporation'] == '1' ? '法人住所' : '代表者自宅住所' ?></dt>
												<dd><?= $CONF['pref'][$ADATA['pref']] ?><?= $ADATA['addr1'] ?><?= $ADATA['addr2'] ?></dd>

												<dt><?= $ADATA['corporation'] == '1' ? '代表電話番号' : '代表者電話番号' ?></dt>
												<dd><?= $ADATA['tel1'] ?>-<?= $ADATA['tel2'] ?>-<?= $ADATA['tel3'] ?></dd>

												<dt>FAX番号</dt>
												<?php if( !empty($ADATA['fax1']) && !empty($ADATA['fax2']) && !empty($ADATA['fax3']) ): ?>
													<dd><?= $ADATA['fax1'] ?>-<?= $ADATA['fax2'] ?>-<?= $ADATA['fax3'] ?></dd>
												<?php else: ?>
													<dd>（入力なし）</dd>
												<?php endif; ?>

												<dt>ご請求先</dt>
												<dd><?= $ADATA['bill_to'] == '1' ? '上記と同じ' : '上記とは別' ?></dd>

												<?php if( $ADATA['bill_to'] == '2' ): ?>
													<dt>ご請求先名</dt>
													<dd><?= $ADATA['bill_name'] ?></dd>

													<dt>ご請求先郵便番号</dt>
													<dd><?= $ADATA['bill_zip1'] ?>-<?= $ADATA['bill_zip2'] ?></dd>

													<dt>ご請求先住所</dt>
													<dd><?= $CONF['pref'][$ADATA['bill_pref']] ?><?= $ADATA['bill_addr1'] ?><?= $ADATA['bill_addr2'] ?></dd>

													<dt>ご請求先電話番号</dt>
													<dd><?= $ADATA['bill_tel1'] ?>-<?= $ADATA['bill_tel2'] ?>-<?= $ADATA['bill_tel3'] ?></dd>
												<?php endif; ?>

												<dt>決済方法</dt>
												<dd><?= $ADATA['settlement_method'] == '1' ? '振込' : '口座引落' ?></dd>

												<?php if( $ADATA['settlement_method'] == '1' ): ?>
													<dt>振込み名義</dt>
													<dd><?= $ADATA['transfer_name'] ?></dd>
												<?php else: ?>
													<dt>金融機関名</dt>
													<dd><?= $ADATA['bank_name'] ?></dd>
												<?php endif; ?>
											</dl>
										</div>
									</div> <!-- end of .card -->
								</div>
							<?php endif; ?>

							<div class="col-4">
								<div class="card card-primary">
									<div class="card-header">
										運営教室
									</div>
									<div class="card-body">
										<ul class="classroom-list">
											<?php if( !empty($CDATA) ): ?>
												<?php foreach( $CDATA as $classroom ): ?>
													<li>
														<?= $classroom['name'] ?>

														<dl>
															<dt>買掛</dt>
															<dd>
																<?php if( $ODATA['payment_method1'] == '1' ): ?>
																	<?php echo form_input(array(
																		'name'	=> 'smile_code1',
																		'id'	=> 'smile_code1_' . $classroom['classroom_id'],
																		'value'	=> $classroom['smile_code1']
																	)); ?>
																<?php else: ?>
																	-----
																<?php endif; ?>
															</dd>

															<dt>クレカ</dt>
															<dd>
																<?php if( $ODATA['payment_method2'] == '1' ): ?>
																	<?php echo form_input(array(
																		'name'	=> 'smile_code2',
																		'id'	=> 'smile_code2_' . $classroom['classroom_id'],
																		'value'	=> $classroom['smile_code2']
																	)); ?>
																<?php else: ?>
																	-----
																<?php endif; ?>
															</dd>

															<dt>代引</dt>
															<dd>
															<?php if( $ODATA['payment_method3'] == '1' ): ?>
																	<?php echo form_input(array(
																		'name'	=> 'smile_code3',
																		'id'	=> 'smile_code3_' . $classroom['classroom_id'],
																		'value'	=> $classroom['smile_code3']
																	)); ?>
																<?php else: ?>
																	-----
																<?php endif; ?>
															</dd>
														</dl>

														<div class="text-right mt-2 mb-3">
															<a href="javascript:void(0);" onclick="register_smile_code('<?= $classroom['classroom_id'] ?>')" class="btn btn-sm btn-danger">SMILEコード登録</a>
														</div>
													</li>
												<?php endforeach; ?>
											<?php endif; ?>
										</ul>
									</div>
								</div> <!-- end of .card -->
							</div>
						</div> <!-- end of .row -->

						<div class="row justify-content-center">
							<div class="col-1 text-center">
								<a href="<?= site_url('admin/owner') ?>" class="btn btn-light btn-lg note-btn">戻る</a>
							</div>

							<div class="col-1 text-center">
								<a href="<?= site_url('admin/owner/do_register/' . $ODATA['owner_id']) ?>" class="btn btn-primary btn-lg note-btn">登録完了</a>
							</div>
						</div> <!-- end of .row -->
						<div class="row justify-content-center">
							<p>
								<span class="text-danger">※『登録完了』をクリックするとオーナーに登録完了メールが送信されます。</span><br>
								※各教室のSMILEコードはそれぞれの『SMILEコード登録』ボタンをクリックして登録してください。<br>
								<span class="text-danger">（『登録完了』ボタンをクリックしてもSMILEコードは登録されません。）</span>
							</p>
						</div> <!-- end of .row -->
					</div> <!-- end of .section-body -->
				</section>
			</div> <!-- end of .main-content -->

			<?php $this->load->view('inc/admin/footer'); ?>
		</div> <!-- end of .main-wrapper -->
	</div> <!-- end of #app -->

	<?php $this->load->view('inc/admin/_foot'); ?>

	<script src="<?= base_url('js/admin/owner_register.js')?>?var=<?= CACHES_CLEAR_VERSION ?>"></script>
</body>
</html>
