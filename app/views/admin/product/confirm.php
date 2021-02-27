<?php $this->load->view('inc/admin/_head', array('TITLE' => '教材管理 | ' . SITE_NAME)); ?>

<body>
	<div id="app">
		<div class="main-wrapper main-wrapper-1">
			<?php $this->load->view('inc/admin/header'); ?>
			<?php $this->load->view('inc/admin/sidebar', array('current' => 'product')); ?>

			<div class="main-content">
				<section class="section">
					<div class="section-header">
						<h1>教材管理 <?= $PDATA['kind'] == 'add' ? '新規追加' : '修正' ?> 確認</h1>
					</div>

					<div class="section-body">
						<div class="row">
							<div class="col-4">
								<div class="card card-primary">
									<div class="card-header">
										<h4>基本情報</h4>
									</div>
									<div class="card-body">
										<dl class="confirm-list">
											<dt>教材名</dt>
											<dd><?= $PDATA['name'] ?></dd>

											<dt>SMILEコード</dt>
											<dd><?= !empty($PDATA['smile_code']) ? $PDATA['smile_code'] : '（設定なし）' ?></dd>

											<dt>検索用キーワード</dt>
											<dd><?= !empty($PDATA['keyword']) ? $PDATA['keyword'] : '（設定なし）' ?></dd>

											<dt>出版社</dt>
											<dd><?= !empty($PDATA['publisher']) ? $CONF['publisher'][$PDATA['publisher']] : '（設定なし）' ?></dd>

											<dt>通常価格</dt>
											<dd><?= ( isset($PDATA['normal_price']) && $PDATA['normal_price'] != '' ) ? '\\' . number_format($PDATA['normal_price']) : '（設定なし）' ?></dd>

											<dt>販売価格</dt>
											<dd>\<?= number_format($PDATA['sales_price']) ?></dd>
										</dl>
									</div>
								</div> <!-- end of .card -->
							</div>

							<div class="col-4">
								<div class="card card-primary">
									<div class="card-header">
										<h4>補足情報</h4>
									</div>
									<div class="card-body">
										<dl class="confirm-list">
											<dt>明光本部推奨</dt>
											<dd><?= ( isset($PDATA['recommend']) && $PDATA['recommend'] == '1' ) ? '推奨教材' : '推奨教材ではない' ?></dd>

											<dt>塾用/市販</dt>
											<dd><?= ( isset($PDATA['flg_market']) && $PDATA['flg_market'] == '1' ) ? '塾用教材' : '市販教材' ?></dd>

											<dt>発刊状況</dt>
											<dd>
												<?php
													$sales = '（設定なし）';
													switch( $PDATA['flg_sales'] ) {
														case '1': $sales = '通常（販売可）';	break;
														case '2': $sales = '売切';				break;
														case '3': $sales = '未発刊';			break;
													}
												?>
												<?= $sales ?>
											</dd>
										</dl>
									</div>
								</div> <!-- end of .card -->
							</div>

							<div class="col-4">
								<div class="card card-primary">
									<div class="card-header">
										<h4>追加情報</h4>
									</div>
									<div class="card-body">
										<dl class="confirm-list">
											<dt>学年等</dt>
											<dd><?= $GRADE ?></dd>

											<dt>教科</dt>
											<dd><?= $SUBJECT ?></dd>

											<dt>期間講習</dt>
											<dd><?= $PERIOD ?></dd>
										</dl>
									</div>
								</div> <!-- end of .card -->
							</div>
						</div> <!-- end of .row -->

						<?php echo form_open('admin/product/complete', array('id' => 'frm_product_confirm')); ?>
							<?php echo form_hidden($PDATA); ?>

							<div class="row justify-content-center">
								<div class="col-1 text-center">
									<?php echo form_button(array(
										'name'		=> 'btn_back',
										'content'	=> '戻る',
										'class'		=> 'btn btn-light btn-lg note-btn',
										'onclick'	=> 'do_submit(1, \'' . $PDATA['kind'] . '\', \'' . $PDATA['product_id'] . '\');'
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

	<script src="<?= base_url('js/admin/product_confirm.js')?>?var=<?= CACHES_CLEAR_VERSION ?>"></script>
</body>
</html>
