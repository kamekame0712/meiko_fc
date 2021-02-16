<?php $this->load->view('inc/admin/_head', array('TITLE' => 'オーナー管理 | ' . SITE_NAME)); ?>

<body>
	<div id="app">
		<div class="main-wrapper main-wrapper-1">
			<?php $this->load->view('inc/admin/header'); ?>
			<?php $this->load->view('inc/admin/sidebar', array('current' => 'owner')); ?>

			<div class="main-content">
				<section class="section">
					<div class="section-header">
						<h1>オーナー管理</h1>
					</div>

					<div class="section-body">
						<div class="row">
							<div class="col-12">
								<div class="card card-primary">
									<div class="card-header">
										<?php echo form_button(array(
											'name'		=> 'btn_add',
											'content'	=> '新規追加',
											'class'		=> 'btn btn-primary note-btn',
											'onclick'	=> 'location.href=\'' . site_url('admin/owner/add') . '\''
										)); ?>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table id="tbl_owner" class="table table-striped table-sm">
												<thead>
													<tr>
														<th data-column-id="col_proc" data-formatter="col_proc" data-sortable="false" data-width="190px">処理</th>
														<th data-column-id="flg_complete" data-formatter="flg_complete_proc" data-width="100px" data-order="asc">登録</th>
														<th data-column-id="regist_time" data-width="170px">申請日時</th>
														<th data-column-id="owner_name" data-width="150px">オーナー名</th>
														<th data-column-id="corpo_name">法人名</th>
														<th data-column-id="classroom" data-width="400px" data-sortable="false">運営教室</th>
														<th data-column-id="payment_method" data-sortable="false" data-width="220px">支払方法</th>
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
	<div class="modal" id="modal_owner" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true" data-show="true" data-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">削除</h4>
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&#215;</span><span class="sr-only">閉じる</span>
					</button>
				</div><!-- /modal-header -->

				<div class="modal-body">
					<div class="row">
						<div class="col-sm-4">
							オーナー名
						</div>
						<div class="col-sm-8">
							<?php echo form_input(array(
								'name'		=> 'owner_name',
								'id'		=> 'owner_name',
								'type'		=> 'text',
								'value'		=> '',
								'disabled'	=> TRUE,
								'maxlength'	=> 255
							)); ?>
						</div>
					</div><br />
					<div class="row">
						<div class="col-sm-4">
							法人名
						</div>
						<div class="col-sm-8">
							<?php echo form_input(array(
								'name'		=> 'corpo_name',
								'id'		=> 'corpo_name',
								'type'		=> 'text',
								'value'		=> '',
								'disabled'	=> TRUE,
								'maxlength'	=> 255
							)); ?>
						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
					<button type="button" class="btn btn-primary" onclick="do_submit();">削除</button>
				</div>
			</div> <!-- /.modal-content -->
		</div> <!-- /.modal-dialog -->
	</div> <!-- /.modal -->

	<?php $this->load->view('inc/admin/_foot'); ?>

	<script>
		var result = '<?= $RESULT ?>';
	</script>
	<script src="<?= base_url('js/admin/owner.js')?>?var=<?= CACHES_CLEAR_VERSION ?>"></script>
</body>
</html>
