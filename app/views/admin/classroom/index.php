<?php $this->load->view('inc/admin/_head', array('TITLE' => '教室管理 | ' . SITE_NAME)); ?>

<body>
	<div id="app">
		<div class="main-wrapper main-wrapper-1">
			<?php $this->load->view('inc/admin/header'); ?>
			<?php $this->load->view('inc/admin/sidebar', array('current' => 'classroom')); ?>

			<div class="main-content">
				<section class="section">
					<div class="section-header">
						<h1>教室管理</h1>
					</div>

					<div class="section-body">
						<div class="card card-primary">
							<div class="card-header">
								<h4>検索条件</h4>

								<div class="card-header-action">
									<a data-collapse="#conditions" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
								</div>
							</div> <!-- end of .card-header -->

							<section id="conditions" class="collapse show">
								<div class="card-body">
									<div class="row">
										<div class="col-4">
											<div class="form-group">
												<?php echo form_label('教室名'); ?>
												<?php echo form_input(array(
													'name'	=> 'classroom_name',
													'id'	=> 'classroom_name',
													'value'	=> set_value('classroom_name', ''),
													'class'	=> 'form-control'
												)); ?>
											</div>
										</div>

										<div class="col-4">
											<div class="form-group">
												<?php echo form_label('オーナー名'); ?>
												<?php echo form_input(array(
													'name'	=> 'owner_name',
													'id'	=> 'owner_name',
													'value'	=> set_value('owner_name', ''),
													'class'	=> 'form-control'
												)); ?>
											</div>
										</div>

										<div class="col-4">
											<div class="form-group">
												<?php echo form_label('法人名'); ?>
												<?php echo form_input(array(
													'name'	=> 'corpo_name',
													'id'	=> 'corpo_name',
													'value'	=> set_value('corpo_name', ''),
													'class'	=> 'form-control'
												)); ?>
											</div>
										</div>
									</div> <!-- end of .row -->

									<div class="row">
										<div class="col-4">
											<div class="form-group">
												<?php echo form_label('SMILEコード'); ?>
												<?php echo form_input(array(
													'name'	=> 'smile_code',
													'id'	=> 'smile_code',
													'value'	=> set_value('smile_code', ''),
													'class'	=> 'form-control'
												)); ?>
											</div>
										</div>

										<div class="col-4">
											<div class="form-group">
												<?php echo form_label('都道府県'); ?>
												<?php echo form_dropdown('pref', $CONF['pref'], set_value('pref', '0'), 'class="form-control" id="pref"'); ?>
											</div>
										</div>

										<div class="col-4">
											<div class="form-group">
												<?php echo form_label('電話番号'); ?>
												<?php echo form_input(array(
													'name'	=> 'tel',
													'id'	=> 'tel',
													'value'	=> set_value('tel', ''),
													'class'	=> 'form-control'
												)); ?>
											</div>
										</div>
									</div> <!-- end of .row -->
								</div> <!-- end of .card-body -->

								<div class="card-footer text-right">
									<?php echo form_button(array(
										'name' 		=> 'btn_search',
										'content'	=> '　検索　',
										'class'		=> 'btn btn-primary mr-3',
										'onclick'	=> 'do_search();'
									)); ?>

									<?php echo form_button(array(
										'name' 		=> 'btn_search',
										'content'	=> '条件をクリア',
										'class'		=> 'btn btn-danger',
										'onclick'	=> 'clear_conditions();'
									)); ?>
								</div> <!-- end of .card-footer -->
							</section>
						</div> <!-- end of .card -->

						<div class="card card-success">
							<div class="card-header">
								<?php echo form_button(array(
									'name'		=> 'btn_add',
									'content'	=> '新規追加',
									'class'		=> 'btn btn-primary note-btn',
									'onclick'	=> 'location.href=\'' . site_url('admin/classroom/add') . '\''
								)); ?>
							</div> <!-- end of .card-header -->

							<div class="of-scroll-x">
								<div class="card-body">
									<table id="tbl_classroom"  class="table table-sm table-striped table-bordered">
										<thead>
											<tr>
												<th data-column-id="col_proc" data-formatter="col_proc" data-sortable="false"  data-width="130px">処理</th>
												<th data-column-id="name" data-width="180px" data-order="asc">教室名</th>
												<th data-column-id="owner_name" data-width="180px">オーナー名</th>
												<th data-column-id="corpo_name" data-width="200px">法人名</th>
												<th data-column-id="address" data-width="250px">住所</th>
												<th data-column-id="tel" data-width="140px">電話番号</th>
												<th data-column-id="email" data-width="250px">メールアドレス</th>
												<th data-column-id="smile_code1" data-width="140px">SMILE（掛）</th>
												<th data-column-id="smile_code2" data-width="140px">SMILE（クレカ）</th>
												<th data-column-id="smile_code3" data-width="140px">SMILE（代引）</th>
												<th data-column-id="en_code1" data-width="140px">EN（掛）</th>
												<th data-column-id="en_code2" data-width="140px">EN（クレカ）</th>
											</tr>
										</thead>
									</table>
								</div> <!-- end of .card-body -->
							</div>
						</div> <!-- end of .card -->
					</div> <!-- end of .section-body -->
				</section>
			</div> <!-- end of .main-content -->

			<?php $this->load->view('inc/admin/footer'); ?>
		</div> <!-- end of .main-wrapper -->
	</div> <!-- end of #app -->

	<?php /* ダイアログ */ ?>
	<div class="modal" id="modal_classroom" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true" data-show="true" data-keyboard="false">
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
							教室名
						</div>
						<div class="col-sm-8">
							<?php echo form_input(array(
								'name'		=> 'dlg_classroom_name',
								'id'		=> 'dlg_classroom_name',
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
	<script src="<?= base_url('js/admin/classroom.js')?>?var=<?= CACHES_CLEAR_VERSION ?>"></script>
</body>
</html>
