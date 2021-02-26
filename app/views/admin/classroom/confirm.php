<?php $this->load->view('inc/admin/_head', array('TITLE' => '教室管理 | ' . SITE_NAME)); ?>

<body>
	<div id="app">
		<div class="main-wrapper main-wrapper-1">
			<?php $this->load->view('inc/admin/header'); ?>
			<?php $this->load->view('inc/admin/sidebar', array('current' => 'classroom')); ?>

			<div class="main-content">
				<section class="section">
					<div class="section-header">
						<h1>教室管理 <?= $PDATA['kind'] == 'add' ? '新規追加' : '修正' ?> 確認</h1>
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
											<dt>教室名</dt>
											<dd><?= $PDATA['name'] ?></dd>

											<dt>郵便番号</dt>
											<dd><?= !empty($PDATA['zip']) ? $PDATA['zip'] : '設定なし' ?></dd>

											<dt>都道府県</dt>
											<dd><?= $CONF['pref'][$PDATA['pref']] ?></dd>

											<dt>住所</dt>
											<dd><?= !empty($PDATA['address']) ? $PDATA['address'] : '設定なし' ?></dd>

											<dt>電話番号</dt>
											<dd><?= !empty($PDATA['tel']) ? $PDATA['tel'] : '設定なし' ?></dd>

											<dt>メールアドレス</dt>
											<dd><?= !empty($PDATA['email']) ? $PDATA['email'] : '設定なし' ?></dd>

											<dt>パスワード</dt>
											<dd><?= !empty($PDATA['password']) ? $PDATA['password'] : '設定なし' ?></dd>
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
											<dt>教室番号（明光側コード）</dt>
											<dd><?= $PDATA['classroom_number'] ?></dd>

											<dt>SMILEコード（掛）</dt>
											<dd><?= !empty($PDATA['smile_code1']) ? $PDATA['smile_code1'] : '設定なし' ?></dd>

											<dt>SMILEコード（クレジット）</dt>
											<dd><?= !empty($PDATA['smile_code2']) ? $PDATA['smile_code2'] : '設定なし' ?></dd>

											<dt>SMILEコード（代引）</dt>
											<dd><?= !empty($PDATA['smile_code3']) ? $PDATA['smile_code1'] : '設定なし' ?></dd>

											<dt>ENコード（掛）</dt>
											<dd><?= !empty($PDATA['en_code1']) ? ( $PDATA['en_code1'] == '1' ? '有' : '無' ) : '設定なし' ?></dd>

											<dt>ENコード（クレジット）</dt>
											<dd><?= !empty($PDATA['en_code2']) ? ( $PDATA['en_code2'] == '1' ? '有' : '無' ) : '設定なし' ?></dd>
										</dl>
									</div>
								</div> <!-- end of .card -->
							</div>
						</div> <!-- end of .row -->

						<?php echo form_open('admin/classroom/complete', array('id' => 'frm_classroom_confirm')); ?>
							<?php echo form_hidden($PDATA); ?>

							<div class="row justify-content-center">
								<div class="col-1 text-center">
									<?php echo form_button(array(
										'name'		=> 'btn_back',
										'content'	=> '戻る',
										'class'		=> 'btn btn-light btn-lg note-btn',
										'onclick'	=> 'do_submit(1, \'' . $PDATA['kind'] . '\', \'' . $PDATA['classroom_id'] . '\');'
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

	<script src="<?= base_url('js/admin/classroom_confirm.js')?>?var=<?= CACHES_CLEAR_VERSION ?>"></script>
</body>
</html>
