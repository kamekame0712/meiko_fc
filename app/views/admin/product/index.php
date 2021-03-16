<?php $this->load->view('inc/admin/_head', array('TITLE' => '教材管理 | ' . SITE_NAME)); ?>

<body>
	<div id="app">
		<div class="main-wrapper main-wrapper-1">
			<?php $this->load->view('inc/admin/header'); ?>
			<?php $this->load->view('inc/admin/sidebar', array('current' => 'product')); ?>

			<div class="main-content">
				<section class="section">
					<div class="section-header">
						<h1>教材管理</h1>
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
												<?php echo form_label('教材名'); ?>
												<?php echo form_input(array(
													'name'	=> 'product_name',
													'id'	=> 'product_name',
													'value'	=> set_value('product_name', ( isset($CONDITION['product_name']) ? $CONDITION['product_name'] : '' )),
													'class'	=> 'form-control'
												)); ?>
											</div>
										</div>

										<div class="col-4">
											<div class="form-group">
												<?php echo form_label('SMILEコード', '', array('class' => 'd-block')); ?>
												<?php echo form_input(array(
													'name'	=> 'smile_code_from',
													'id'	=> 'smile_code_from',
													'value'	=> set_value('smile_code_from', ( isset($CONDITION['smile_code_from']) ? $CONDITION['smile_code_from'] : '' )),
													'class'	=> 'form-control d-inline-block mw-200'
												)); ?>～
												<?php echo form_input(array(
													'name'	=> 'smile_code_to',
													'id'	=> 'smile_code_to',
													'value'	=> set_value('smile_code_to', ( isset($CONDITION['smile_code_to']) ? $CONDITION['smile_code_to'] : '' )),
													'class'	=> 'form-control d-inline-block mw-200'
												)); ?>
											</div>
										</div>

										<div class="col-4">
											<div class="form-group">
												<?php echo form_label('出版社'); ?>
												<?php echo form_dropdown('publisher', array('' => '選択してください') + $CONF['publisher'], set_value('publisher', ( isset($CONDITION['publisher']) ? $CONDITION['publisher'] : '0' )), 'class="form-control" id="publisher"'); ?>
											</div>
										</div>
									</div> <!-- end of .row -->

									<div class="row">
										<div class="col-4">
											<div class="form-group">
												<?php
													$fm1 = !empty($CONDITION['flg_market']) && !in_array('1', $CONDITION['flg_market']) ? FALSE : TRUE;
													$fm2 = !empty($CONDITION['flg_market']) && !in_array('2', $CONDITION['flg_market']) ? FALSE : TRUE;
												?>

												<?php echo form_label('塾用/市販', '', array('class' => 'd-block')); ?>

												<?php echo form_checkbox(array(
													'name'	=> 'flg_market[]',
													'id'	=> 'flg_market1',
													'value'	=> '1',
													'checked'	=> set_checkbox('flg_market[]', '1', $fm1)
												)); ?>
												<?php echo form_label('塾用', 'flg_market1', array('class' => 'font-weight-normal')); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

												<?php echo form_checkbox(array(
													'name'	=> 'flg_market[]',
													'id'	=> 'flg_market2',
													'value'	=> '2',
													'checked'	=> set_checkbox('flg_market[]', '2', $fm2)
												)); ?>
												<?php echo form_label('市販', 'flg_market2', array('class' => 'font-weight-normal')); ?>
											</div>
										</div>

										<div class="col-4">
											<div class="form-group">
												<?php
													$fs1 = !empty($CONDITION['flg_sales']) && !in_array('1', $CONDITION['flg_sales']) ? FALSE : TRUE;
													$fs2 = !empty($CONDITION['flg_sales']) && !in_array('2', $CONDITION['flg_sales']) ? FALSE : TRUE;
													$fs3 = !empty($CONDITION['flg_sales']) && !in_array('3', $CONDITION['flg_sales']) ? FALSE : TRUE;
												?>

												<?php echo form_label('発刊状況', '', array('class' => 'd-block')); ?>

												<?php echo form_checkbox(array(
													'name'	=> 'flg_sales[]',
													'id'	=> 'flg_sales1',
													'value'	=> '1',
													'checked'	=> set_checkbox('flg_sales[]', '1', $fs1)
												)); ?>
												<?php echo form_label('通常', 'flg_sales1', array('class' => 'font-weight-normal')); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

												<?php echo form_checkbox(array(
													'name'	=> 'flg_sales[]',
													'id'	=> 'flg_sales2',
													'value'	=> '2',
													'checked'	=> set_checkbox('flg_sales[]', '2', $fs2)
												)); ?>
												<?php echo form_label('売切', 'flg_sales2', array('class' => 'font-weight-normal')); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

												<?php echo form_checkbox(array(
													'name'	=> 'flg_sales[]',
													'id'	=> 'flg_sales3',
													'value'	=> '3',
													'checked'	=> set_checkbox('flg_sales[]', '3', $fs3)
												)); ?>
												<?php echo form_label('未発刊', 'flg_sales3', array('class' => 'font-weight-normal')); ?>
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
									'style'		=> 'margin-right:80px;',
									'onclick'	=> 'location.href=\'' . site_url('admin/product/add') . '\''
								)); ?>

								<?php echo form_button(array(
									'name'		=> 'btn_add',
									'content'	=> '教材データダウンロード',
									'class'		=> 'btn btn-info note-btn',
									'onclick'	=> 'product_dl();'
								)); ?>&nbsp;&nbsp;&nbsp;
								<?php echo form_button(array(
									'name'		=> 'btn_add',
									'content'	=> '設定値リストダウンロード',
									'class'		=> 'btn btn-info note-btn',
									'style'		=> 'margin-right:80px;',
									'onclick'	=> 'location.href=\'' . site_url('admin/product/config_dl') . '\''
								)); ?>

								<?php echo form_button(array(
									'name'		=> 'btn_add',
									'content'	=> '教材データアップロード',
									'class'		=> 'btn btn-warning note-btn',
									'onclick'	=> 'product_ul();'
								)); ?>
							</div> <!-- end of .card-header -->

							<div class="of-scroll-x">
								<div class="card-body">
									<table id="tbl_product"  class="table table-sm table-striped table-bordered">
										<thead>
											<tr>
												<th data-column-id="col_proc" data-formatter="col_proc" data-sortable="false"  data-width="130px">処理</th>
												<th data-column-id="name" data-width="280px" data-order="asc">教材名</th>
												<th data-column-id="smile_code" data-width="190px">SMILEコード</th>
												<th data-column-id="publisher" data-width="100px">出版社</th>
												<th data-column-id="flg_market" data-width="100px">塾用/市販</th>
												<th data-column-id="grade" data-width="120px">学年</th>
												<th data-column-id="subject" data-width="120px">教科</th>
												<th data-column-id="period" data-width="100px">期間講習</th>
												<th data-column-id="flg_sales" data-width="110px">発刊状況</th>
												<th data-column-id="normal_price" data-width="80px" data-align="right">通常価格</th>
												<th data-column-id="sales_price" data-width="80px" data-align="right">販売価格</th>
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
	<div class="modal" id="modal_product" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true" data-show="true" data-keyboard="false">
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
							教材名
						</div>
						<div class="col-sm-8">
							<?php echo form_input(array(
								'name'		=> 'dlg_product_name',
								'id'		=> 'dlg_product_name',
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
	<script src="<?= base_url('js/admin/product.js')?>?var=<?= CACHES_CLEAR_VERSION ?>"></script>
</body>
</html>
