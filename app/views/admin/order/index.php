<?php $this->load->view('inc/admin/_head', array('TITLE' => '受注管理 | ' . SITE_NAME)); ?>

<body>
	<div id="app">
		<div class="main-wrapper main-wrapper-1">
			<?php $this->load->view('inc/admin/header'); ?>
			<?php $this->load->view('inc/admin/sidebar', array('current' => 'order')); ?>

			<div class="main-content">
				<section class="section">
					<div class="section-header">
						<h1>受注管理</h1>
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
												<?php echo form_label('受注番号', '', array('class' => 'd-block')); ?>
												<?php echo form_input(array(
													'name'	=> 'order_id_from',
													'id'	=> 'order_id_from',
													'value'	=> set_value('order_id_from', ''),
													'class'	=> 'form-control d-inline-block mw-200'
												)); ?>～
												<?php echo form_input(array(
													'name'	=> 'order_id_to',
													'id'	=> 'order_id_to',
													'value'	=> set_value('order_id_to', ''),
													'class'	=> 'form-control d-inline-block mw-200'
												)); ?>
											</div>
										</div>

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
												<?php echo form_label('顧客コード（SMILEコード）'); ?>
												<?php echo form_input(array(
													'name'	=> 'smile_code',
													'id'	=> 'smile_code',
													'value'	=> set_value('smile_code', ''),
													'class'	=> 'form-control'
												)); ?>
											</div>
										</div>
									</div> <!-- end of .row -->

									<div class="row">
										<div class="col-4">
											<div class="form-group">
												<?php echo form_label('対応状況'); ?>
												<?php echo form_dropdown('order_status', $CONF['order_status'], set_value('order_status', '0'), 'class="form-control" id="order_status"'); ?>
											</div>
										</div>

										<div class="col-4">
											<div class="form-group">
												<?php echo form_label('支払方法', '', array('class' => 'd-block')); ?>

												<?php echo form_checkbox(array(
													'name'	=> 'payment_method1',
													'id'	=> 'payment_method1',
													'value'	=> '1',
													'checked'	=> set_checkbox('payment_method1', '1', TRUE)
												)); ?>
												<?php echo form_label('買掛', 'payment_method1', array('class' => 'font-weight-normal')); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

												<?php echo form_checkbox(array(
													'name'	=> 'payment_method2',
													'id'	=> 'payment_method2',
													'value'	=> '1',
													'checked'	=> set_checkbox('payment_method2', '1', TRUE)
												)); ?>
												<?php echo form_label('クレジットカード', 'payment_method2', array('class' => 'font-weight-normal')); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

												<?php echo form_checkbox(array(
													'name'	=> 'payment_method3',
													'id'	=> 'payment_method3',
													'value'	=> '1',
													'checked'	=> set_checkbox('payment_method3', '1', TRUE)
												)); ?>
												<?php echo form_label('代金引換', 'payment_method3', array('class' => 'font-weight-normal')); ?>
											</div>
										</div>

										<div class="col-4">
											<div class="form-group">
												<?php echo form_label('受注日', '', array('class' => 'd-block')); ?>
												<?php echo form_input(array(
													'name'	=> 'regist_time_from',
													'id'	=> 'regist_time_from',
													'value'	=> set_value('regist_time_from', ( !empty($COND['regist_time_from']) ? $COND['regist_time_from'] : '' )),
													'class'	=> 'form-control d-inline-block mw-200'
												)); ?>～
												<?php echo form_input(array(
													'name'	=> 'regist_time_to',
													'id'	=> 'regist_time_to',
													'value'	=> set_value('regist_time_to', ( !empty($COND['regist_time_to']) ? $COND['regist_time_to'] : '' )),
													'class'	=> 'form-control d-inline-block mw-200'
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
								<div class="container-fluid">
									<div class="row">
										<div class="col-3">
											<?php echo form_button(array(
												'name'		=> 'btn_check_all',
												'content'	=> '全て選択',
												'class'		=> 'btn btn-info note-btn',
												'onclick'	=> 'check_all();'
											)); ?>&nbsp;&nbsp;&nbsp;
											<?php echo form_button(array(
												'name'		=> 'btn_check_all',
												'content'	=> '全て解除',
												'class'		=> 'btn btn-info note-btn',
												'onclick'	=> 'uncheck_all();'
											)); ?>
										</div>

										<div class="col-4">
											<?php echo form_button(array(
												'name'		=> 'btn_check_all',
												'content'	=> 'SMILEデータダウンロード',
												'class'		=> 'btn btn-success note-btn',
												'onclick'	=> 'dl_order(1);'
											)); ?>&nbsp;&nbsp;&nbsp;

											<?php echo form_button(array(
												'name'		=> 'btn_check_all',
												'content'	=> '帳票PDFダウンロード',
												'class'		=> 'btn btn-success note-btn',
												'onclick'	=> 'dl_order(2);'
											)); ?>
										</div>

										<div class="col-3">
											<?php echo form_button(array(
												'name'		=> 'btn_check_all',
												'content'	=> '『取込済』に変更',
												'class'		=> 'btn btn-warning note-btn',
												'onclick'	=> 'change_status();'
											)); ?>
										</div>
									</div>
								</div>
							</div> <!-- end of .card-header -->

							<div class="of-scroll-x">
								<div class="card-body">
									<table id="tbl_order"  class="table table-sm table-striped table-bordered">
										<thead>
											<tr>
												<th data-column-id="col_checkbox" data-formatter="col_checkbox" data-sortable="false" data-width="30px" data-align="center">&nbsp;</th>
												<th data-column-id="col_proc" data-formatter="col_proc" data-sortable="false"  data-width="150px">処理</th>
												<th data-column-id="regist_time" data-width="170px" data-order="desc">受注日</th>
												<th data-column-id="order_id" data-width="90px" data-align="center">注文番号</th>
												<th data-column-id="order_status" data-width="100px">対応状況</th>
												<th data-column-id="classroom_name" data-width="180px">教室名</th>
												<th data-column-id="payment_method" data-width="140px">支払方法</th>
												<th data-column-id="total_cost" data-width="100px" data-align="right">合計金額</th>
												<th data-column-id="exists_market" data-width="90px">市販教材</th>
												<th data-column-id="delivery_date" data-width="110px">希望日</th>
												<th data-column-id="delivery_time" data-width="90px">希望時間</th>
												<th data-column-id="note" data-width="200px">備考</th>
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
	<div class="modal" id="modal_order" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true" data-show="true" data-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">キャンセル</h4>
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&#215;</span><span class="sr-only">閉じる</span>
					</button>
				</div><!-- /modal-header -->

				<div class="modal-body">
					<div class="row">
						<div class="col-sm-4">教室名</div>
						<div class="col-sm-8">
							<?php echo form_input(array(
								'name'		=> 'modal_classroom',
								'id'		=> 'modal_classroom',
								'disabled'	=> TRUE
							)); ?>
						</div>
					</div><br />
					<div class="row">
						<div class="col-sm-4">受注日</div>
						<div class="col-sm-8">
							<?php echo form_input(array(
								'name'		=> 'modal_regist_time',
								'id'		=> 'modal_regist_time',
								'disabled'	=> TRUE
							)); ?>
						</div>
					</div><br />
					<div class="row">
						<div class="col-sm-4">購入金額</div>
						<div class="col-sm-8">
							<?php echo form_input(array(
								'name'		=> 'modal_total_cost',
								'id'		=> 'modal_total_cost',
								'disabled'	=> TRUE
							)); ?>
						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
					<button type="button" class="btn btn-primary" onclick="do_submit();">キャンセル</button>
				</div>
			</div> <!-- /.modal-content -->
		</div> <!-- /.modal-dialog -->
	</div> <!-- /.modal -->

	<?php $this->load->view('inc/admin/_foot'); ?>
	<script src="<?= base_url('js/admin/order.js')?>?var=<?= CACHES_CLEAR_VERSION ?>"></script>
</body>
</html>
