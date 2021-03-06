<?php $this->load->view('inc/admin/_head', array('TITLE' => '受注管理 | ' . SITE_NAME)); ?>

<body>
	<div id="app">
		<div class="main-wrapper main-wrapper-1">
			<?php $this->load->view('inc/admin/header'); ?>
			<?php $this->load->view('inc/admin/sidebar', array('current' => 'order')); ?>

			<div class="main-content">
				<section class="section">
					<div class="section-header">
						<h1>受注管理 メール送信</h1>
					</div>

					<div class="section-body">
						<div class="row">
							<div class="col-6">
								<div class="card card-primary">
									<div class="card-header">
										<h4>メール</h4>
									</div>
									<div class="card-body">
										<?php echo form_open('admin/order/mail_confirm'); ?>
											<?php echo form_hidden(array('order_id' => $DETAIL[0]['order_id'])); ?>

											<div class="form-group">
												<?php echo form_label('宛先', ''); ?>
												<p class="form-control">
													<?= $DETAIL[0]['classroom_name'] ?>（<?= $DETAIL[0]['email'] ?>）
												</p>
											</div>

											<div class="form-group">
												<?php echo form_label('件名', '', array('class' => 'required-label')); ?>
												<?php echo form_input(array(
													'name'	=> 'title',
													'value'	=> set_value('title', ''),
													'class'	=> 'form-control'
												)); ?>
												<?php echo form_error('title'); ?>
											</div>

											<div class="form-group">
												<?php echo form_label('本文', '', array('class' => 'required-label')); ?>
												<?php echo form_textarea(array(
													'name'	=> 'content',
													'value'	=> set_value('content', '明光義塾 ' . $DETAIL[0]['classroom_name'] . "\r\n" . 'ご担当者様'),
													'class'	=> 'form-control mail-content'
												)); ?>
												<?php echo form_error('content'); ?>
											</div>

											<div class="row justify-content-center">
												<div class="col-2 text-center">
													<?php echo form_button(array(
														'name'		=> 'btn_back',
														'content'	=> '戻る',
														'class'		=> 'btn btn-light btn-lg note-btn',
														'onclick'	=> 'location.href=\'' . site_url('admin/order') . '\''
													)); ?>
												</div>

												<div class="col-2 text-center">
													<?php echo form_submit(array(
														'name'		=> 'btn_submit',
														'value'		=> '確認',
														'class'		=> 'btn btn-primary btn-lg note-btn'
													)); ?>
												</div>
											</div> <!-- end of .row -->
										<?php echo form_close(); ?>
									</div> <!-- end of .card-body -->
								</div> <!-- end of .card -->
							</div>

							<div class="col-6">
								<div class="card card-primary">
									<div class="card-header">
										<h4>注文情報</h4>
									</div>
									<div class="card-body">
										<div class="container-fluid">
											<div class="row">
												<div class="col-6">
													<dl class="confirm-list">
														<dt>注文日</dt>
														<dd><?= $DETAIL[0]['regist_time'] ?></dd>

														<dt>注文番号</dt>
														<dd><?= $DETAIL[0]['order_id'] ?></dd>

														<dt>対応状況</dt>
														<dd><?= $CONF['order_status'][$DETAIL[0]['order_status']] ?></dd>

														<dt>支払方法</dt>
														<dd><?= $CONF['payment_method'][$DETAIL[0]['payment_method']] ?></dd>
													</dl>
												</div>

												<div class="col-6">
													<dl class="confirm-list">
														<dt>市販教材</dt>
														<dd>
															<?php
																$market = $DETAIL[0]['exists_market'] == '1' ? '無' : '有';
																if( $DETAIL[0]['exists_market'] == '2' ) {
																	$market .= '（' . ( $DETAIL[0]['flg_partial'] == '1' ? '全納' : '分納' ) . '）';
																}
															?>
															<?= $market ?>
														</dd>

														<dt>お届け希望日</dt>
														<dd><?= !empty($DETAIL[0]['delivery_date']) ? $DETAIL[0]['delivery_date'] : '指定なし' ?></dd>

														<dt>お届け希望時間</dt>
														<dd><?= $CONF['delivery_time'][$DETAIL[0]['delivery_time']] ?></dd>

														<dt>備考</dt>
														<dd><?= empty($DETAIL[0]['note']) ? '（未記入）' : nl2br($DETAIL[0]['note']) ?></dd>
													</dl>
												</div>
											</div> <!-- end of .row -->
										</div> <!-- end of .container-fluid -->
									</div> <!-- end of .card-body -->
								</div> <!-- end of .card -->

								<div class="card card-primary">
									<div class="card-header">
										<h4>注文明細</h4>
									</div>
									<div class="card-body">
										<table class="table table-sm table-striped">
											<thead>
												<tr>
													<th class="align-center">出版社名</th>
													<th class="align-center">商品名</th>
													<th class="align-center">数量</th>
													<th class="align-center">単価</th>
													<th class="align-center">金額（税込）</th>
												</tr>
											</thead>

											<tbody>
												<?php foreach( $DETAIL as $val ): ?>
													<tr>
														<td><?= $val['publisher_name'] ?></td>
														<td><?= $val['product_name'] ?></td>
														<td class="align-right"><?= $val['quantity'] ?></td>
														<td class="align-right">\<?= number_format($val['sales_price']) ?></td>
														<td class="align-right">\<?= number_format($val['sub_total']) ?></td>
													</tr>
												<?php endforeach; ?>

												<tr>
													<td>&nbsp;</td>
													<td>&nbsp;</td>
													<td>&nbsp;</td>
													<td>&nbsp;</td>
													<td>&nbsp;</td>
												</tr>

												<tr>
													<td>&nbsp;</td>
													<td>&nbsp;</td>
													<td>&nbsp;</td>
													<td class="align-right">商品合計</td>
													<td class="align-right">\<?= number_format($DETAIL[0]['product_cost']) ?></td>
												</tr>

												<tr>
													<td>&nbsp;</td>
													<td>&nbsp;</td>
													<td>&nbsp;</td>
													<td class="align-right">送料</td>
													<td class="align-right">\<?= number_format($DETAIL[0]['shipping_fee']) ?></td>
												</tr>

												<tr>
													<td>&nbsp;</td>
													<td>&nbsp;</td>
													<td>&nbsp;</td>
													<td class="align-right">手数料</td>
													<td class="align-right">\<?= number_format($DETAIL[0]['commission']) ?></td>
												</tr>

												<tr>
													<td>&nbsp;</td>
													<td>&nbsp;</td>
													<td>&nbsp;</td>
													<td class="align-right">合計金額</td>
													<td class="align-right">\<?= number_format($DETAIL[0]['total_cost']) ?></td>
												</tr>
											</tbody>
										</table>
									</div> <!-- end of .card-body -->
								</div> <!-- end of .card -->
							</div>
						</div> <!-- end of .row -->
					</div> <!-- end of .section-body -->
				</section>
			</div> <!-- end of .main-content -->

			<?php $this->load->view('inc/admin/footer'); ?>
		</div> <!-- end of .main-wrapper -->
	</div> <!-- end of #app -->

	<?php $this->load->view('inc/admin/_foot'); ?>
</body>
</html>
