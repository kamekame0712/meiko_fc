<?php $this->load->view('inc/admin/_head', array('TITLE' => '管理者管理 | ' . SITE_NAME)); ?>

<body>
	<div id="app">
		<div class="main-wrapper main-wrapper-1">
			<?php $this->load->view('inc/admin/header'); ?>
			<?php $this->load->view('inc/admin/sidebar', array('current' => 'manage')); ?>

			<div class="main-content">
				<section class="section">
					<div class="section-header">
						<h1>管理者管理</h1>
					</div>

					<div class="section-body">
						<div class="row">
							<div class="col-12 col-md-7">
								<div class="card card-primary">
									<div class="card-header">
										<?php echo form_button(array(
											'name'		=> 'btn_add',
											'content'	=> '新規追加',
											'class'		=> 'btn btn-primary note-btn',
											'onclick'	=> 'add_manage();'
										)); ?>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table id="tbl_manage" class="table table-striped table-sm">
												<thead>
													<tr>
														<th data-column-id="col_proc" data-formatter="col_proc" data-sortable="false" data-width="290px">処理</th>
														<th data-column-id="name" data-width="150px" data-order="asc">管理者名</th>
														<th data-column-id="email">メールアドレス</th>
													</tr>
												</thead>
											</table>
										</div>
									</div>
								</div> <!-- end of .card -->
							</div>
						</div> <!-- end of .row -->
					</div> <!-- end of .section-body -->
				</section>
			</div> <!-- end of .main-content -->

			<?php $this->load->view('inc/admin/footer'); ?>
		</div> <!-- end of .main-wrapper -->
	</div> <!-- end of #app -->

	<?php /* ダイアログ */ ?>
	<div class="modal" id="modal_manage" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true" data-show="true" data-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="modal_manage_title"></h4>
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&#215;</span><span class="sr-only">閉じる</span>
					</button>
				</div><!-- /modal-header -->

				<div class="modal-body">
					<div class="row">
						<div class="col-sm-4">
							管理者名
						</div>
						<div class="col-sm-8">
							<?php echo form_input(array(
								'name'		=> 'name',
								'id'		=> 'name',
								'type'		=> 'text',
								'value'		=> '',
								'maxlength'	=> 255
							)); ?>
						</div>
					</div><br />
					<div class="row">
						<div class="col-sm-4">
							メールアドレス
						</div>
						<div class="col-sm-8">
							<?php echo form_input(array(
								'name'		=> 'email',
								'id'		=> 'email',
								'type'		=> 'text',
								'value'		=> '',
								'maxlength'	=> 255
							)); ?>
						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
					<button type="button" class="btn btn-primary" id="btn_submit" onclick="do_submit();"></button>
				</div>
			</div> <!-- /.modal-content -->
		</div> <!-- /.modal-dialog -->
	</div> <!-- /.modal -->

	<?php $this->load->view('inc/admin/_foot'); ?>
	<script src="<?= base_url('js/admin/manage.js')?>?var=<?= CACHES_CLEAR_VERSION ?>"></script>
</body>
</html>
