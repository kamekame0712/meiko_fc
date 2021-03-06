<?php $this->load->view('inc/admin/_head', array('TITLE' => '受注管理 | ' . SITE_NAME)); ?>

<body>
	<div id="app">
		<div class="main-wrapper main-wrapper-1">
			<?php $this->load->view('inc/admin/header'); ?>
			<?php $this->load->view('inc/admin/sidebar', array('current' => 'order')); ?>

			<div class="main-content">
				<section class="section">
					<div class="section-header">
						<h1>受注管理 メール送信 確認</h1>
					</div>

					<div class="section-body">
						<div class="row">
							<div class="col-6">
								<div class="card card-primary">
									<div class="card-header">
										<h4>メール</h4>
									</div>
									<div class="card-body">
										<dl class="confirm-list">
											<dt>宛先</dt>
											<dd><?= !empty($JUKU)? $JUKU : '' ?></dd>

											<dt>件名</dt>
											<dd><?= !empty($PDATA['title']) ? $PDATA['title'] : '' ?></dd>

											<dt>本文</dt>
											<dd><?= !empty($PDATA['content']) ? nl2br($PDATA['content']) : '' ?></dd>
										</dl>
									</div> <!-- end of .card-body -->
								</div> <!-- end of .card -->
							</div>
						</div> <!-- end of .row -->

						<?php echo form_open('admin/order/mail_complete', array('id' => 'frm_send_mail')); ?>
							<?php echo form_hidden($PDATA); ?>

							<div class="row">
								<div class="col-6">
									<div class="container-fluid">
										<div class="row justify-content-center">
											<div class="col-2 text-center">
												<?php echo form_button(array(
													'name'		=> 'btn_back',
													'content'	=> '戻る',
													'class'		=> 'btn btn-light btn-lg',
													'onclick'	=> 'do_submit(1, \'' . $PDATA['order_id'] . '\');'
												)); ?>
											</div>

											<div class="col-2 text-center">
												<?php echo form_button(array(
													'name'		=> 'btn_submit',
													'content'	=> '登録',
													'class'		=> 'btn btn-primary btn-lg note-btn',
													'onclick'	=> 'do_submit(2, \'\');'
												)); ?>
											</div>
										</div>
									</div>
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
	<script src="<?= base_url('js/admin/order_send_mail_confirm.js')?>?var=<?= CACHES_CLEAR_VERSION ?>"></script>
</body>
</html>
