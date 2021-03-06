<?php $this->load->view('inc/admin/_head', array('TITLE' => '受注管理 | ' . SITE_NAME)); ?>

<body>
	<div id="app">
		<div class="main-wrapper main-wrapper-1">
			<?php $this->load->view('inc/admin/header'); ?>
			<?php $this->load->view('inc/admin/sidebar', array('current' => 'order')); ?>

			<div class="main-content">
				<section class="section">
					<div class="section-header">
						<h1>受注管理 詳細</h1>
					</div>

					<div class="section-body">
						<div class="row">
							<div class="col-8">
								<div class="container-fluid">
									<div class="row">
										<div class="col-6">
											<div class="card card-primary">
												<div class="card-header">
													<h4>発注者情報</h4>
												</div>
												<div class="card-body">
													<dl class="confirm-list">
														<dt>教室名</dt>
														<dd><?= $DETAIL[0]['classroom_name'] ?></dd>

														<dt>明光教室コード</dt>
														<dd><?= $DETAIL[0]['classroom_number'] ?></dd>

														<dt>オーナー名</dt>
														<dd><?= $DETAIL[0]['owner_name'] ?></dd>

														<dt>法人名</dt>
														<?php if( !empty($DETAIL[0]['corpo_name']) ): ?>
															<dd><?= $DETAIL[0]['corpo_name'] ?></dd>
														<?php else: ?>
															<dd>（入力なし）</dd>
														<?php endif; ?>

														<dt>SMILEコード（買掛）</dt>
														<dd>
															<?php
																if( $DETAIL[0]['payment_method1'] == '1' ) {
																	$smile_code1 = empty($DETAIL[0]['smile_code1']) ? '（未登録）' : $DETAIL[0]['smile_code1'];
																}
																else {
																	$smile_code1 = '-----';
																}
															?>
															<?= $smile_code1 ?>
														</dd>

														<dt>SMILEコード（クレカ）</dt>
														<dd>
															<?php
																if( $DETAIL[0]['payment_method2'] == '1' ) {
																	$smile_code2 = empty($DETAIL[0]['smile_code2']) ? '（未登録）' : $DETAIL[0]['smile_code2'];
																}
																else {
																	$smile_code2 = '-----';
																}
															?>
															<?= $smile_code2 ?>
														</dd>

														<dt>SMILEコード（代引）</dt>
														<dd>
															<?php
																if( $DETAIL[0]['payment_method3'] == '1' ) {
																	$smile_code3 = empty($DETAIL[0]['smile_code3']) ? '（未登録）' : $DETAIL[0]['smile_code3'];
																}
																else {
																	$smile_code3 = '-----';
																}
															?>
															<?= $smile_code3 ?>
														</dd>

														<dt>ENコード（買掛）</dt>
														<dd>
															<?php if( empty($DETAIL[0]['en_code1']) ): ?>
																（未登録）
															<?php else: ?>
																<?= $DETAIL[0]['en_code1'] == '1' ? 'あり' : 'なし' ?>
															<?php endif; ?>
														</dd>

														<dt>ENコード（クレカ）</dt>
														<dd>
															<?php if( empty($DETAIL[0]['en_code2']) ): ?>
																（未登録）
															<?php else: ?>
																<?= $DETAIL[0]['en_code2'] == '1' ? 'あり' : 'なし' ?>
															<?php endif; ?>
														</dd>
													</dl>
												</div> <!-- end of .card-body -->
											</div> <!-- end of .card -->
										</div>

										<div class="col-6">
											<div class="card card-primary">
												<div class="card-header">
													<h4>注文情報</h4>
												</div>
												<div class="card-body">
													<dl class="confirm-list">
														<dt>注文日</dt>
														<dd><?= $DETAIL[0]['regist_time'] ?></dd>

														<dt>注文番号</dt>
														<dd><?= $DETAIL[0]['order_id'] ?></dd>

														<dt>対応状況</dt>
														<dd><?= $CONF['order_status'][$DETAIL[0]['order_status']] ?></dd>

														<dt>支払方法</dt>
														<dd><?= $CONF['payment_method'][$DETAIL[0]['payment_method']] ?></dd>

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

														<dt>合計金額</dt>
														<dd>\<?= number_format($DETAIL[0]['total_cost']) ?></dd>

														<dt>備考</dt>
														<dd><?= empty($DETAIL[0]['note']) ? '（未記入）' : nl2br($DETAIL[0]['note']) ?></dd>
													</dl>
												</div> <!-- end of .card-body -->
											</div> <!-- end of .card -->
										</div>
									</div> <!-- end of .row -->

									<div class="row">
										<div class="col-12">
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
																<th class="align-center">商品コード</th>
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
																	<td><?= $val['smile_code'] ?></td>
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
																<td>&nbsp;</td>
															</tr>

															<tr>
																<td>&nbsp;</td>
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
																<td>&nbsp;</td>
																<td class="align-right">送料</td>
																<td class="align-right">\<?= number_format($DETAIL[0]['shipping_fee']) ?></td>
															</tr>

															<tr>
																<td>&nbsp;</td>
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
								</div> <!-- end of .container-fluid -->
							</div>

							<div class="col-4 pl-0">
								<?php if( $DETAIL[0]['flg_send_mail'] == '2' ): ?>
									<div class="card card-warning">
										<div class="card-header">
											<h4>メール履歴</h4>
										</div>
										<div class="card-body">
											<?php if( !empty($MAIL) ): ?>
												<?php foreach( $MAIL as $val ): ?>
													<dl class="confirm-list">
														<dt><?= $val['regist_time'] ?></dt>
														<dd>
															<p>件名：<?= $val['title'] ?></p>
															内容：<br>
															<?= nl2br($val['content']) ?>
														</dd>
													</dl>
												<?php endforeach; ?>
											<?php endif; ?>
										</div> <!-- end of .card-body -->
									</div> <!-- end of .card -->
								<?php endif; ?>

								<div class="card card-success">
									<div class="card-header">
										<h4>注文履歴</h4>
									</div>
									<div class="card-body">
										<?php if( !empty($HISTORY) ): ?>
											<?php foreach( $HISTORY as $val ): ?>
												<?php
													if( $DETAIL[0]['order_id'] == $val['order_id'] ) {
														$dl_class = 'confirm-list history-dl-bg';
													}
													else {
														$dl_class = 'confirm-list';
													}
												?>

												<dl class="<?= $dl_class ?>">
													<dt>
														<a href="<?= site_url('admin/order/detail/' . $val['order_id']) ?>"><?= $val['order_id'] ?>&nbsp;&nbsp;<?= $val['regist_time'] ?></a>
													</dt>
													<dd>合計金額：\<?= number_format($val['total_cost']) ?></dd>
												</dl>
											<?php endforeach; ?>
										<?php endif; ?>
									</div> <!-- end of .card-body -->
								</div> <!-- end of .card -->
							</div>
						</td> <!-- end of .row -->
					</div> <!-- end of .section-body -->
				</section>
			</div> <!-- end of .main-content -->

			<?php $this->load->view('inc/admin/footer'); ?>
		</div> <!-- end of .main-wrapper -->
	</div> <!-- end of #app -->

	<?php $this->load->view('inc/admin/_foot'); ?>
</body>
</html>
