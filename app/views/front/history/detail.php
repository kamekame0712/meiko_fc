<?php $this->load->view('inc/_head', array('TITLE' => SITE_NAME)); ?>

<body>
	<div id="wrapper">
		<?php $this->load->view('inc/header', array('MENU' => TRUE)); ?>

		<div class="container">
			<?php if( get_instruction() ): ?>
				<div class="row justify-content-center">
					<div class="col-md-9">
						<div class="instruction" name="instruction">
							<h1>
								注意事項
								<a href="javascript:void();"><i class="fas fa-window-close"></i></a>
							</h1>

							<section>
								<ul>
									<li>
										市販教材を別送した場合、送料の関係により、合計金額に差異が発生している可能性がございます。
									</li>
									<li>
										履歴と同じ教材をそのまま発注することが可能です。<br>
										発注詳細の下にある【同じ教材を発注する】ボタンをクリックしてください。<br>
										※発注処理の画面に遷移しますので、数量やその他項目をご確認の上、発注をお願いします。<br>
										※廃刊、教材名変更、価格改定等により、全ての教材を発注できないことがあります。ご注意ください。
									</li>
								</ul>
							</section>

							<div class="instruction-footer">
								※この注意事項は【メニュー】より常に非表示にすることができます。
							</div>
						</div> <!-- end of .instruction -->
					</div>
				</div> <!-- end of .row -->
			<?php endif; ?>

			<p class="lead-title">発注詳細</p>

			<?php if( empty($DETAIL) ): ?>
				発注詳細はありません。<br>

				<?php echo form_button(array(
					'name'		=> 'btn_back',
					'content'	=> '戻る',
					'class'		=> 'btn btn-primary my-5',
					'onclick'	=> 'location.href=\'' . site_url('history') . '\''
				)); ?>
			<?php else: ?>
				<p class="sub-title">発注内容</p>

				<table class="table table-striped tbl-detail">
					<thead>
						<tr>
							<th>出版社</th>
							<th>教材名</th>
							<th>単価</th>
							<th>数量</th>
							<th>金額</th>
						</tr>
					</thead>
					<tbody>
						<?php $cnt = 0; ?>
						<?php foreach( $DETAIL as $val ): ?>
							<tr>
								<td><?= $val['publisher_name'] ?></td>
								<td><?= $val['product_name'] ?></td>
								<td>\<?= number_format($val['sales_price']) ?></td>
								<td><?= $val['quantity'] ?></td>
								<td>\<?= number_format($val['sub_total']) ?></td>
							</tr>

							<?php $cnt += intval($val['quantity']); ?>
						<?php endforeach; ?>

						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>送料</td>
							<td>&nbsp;</td>
							<td>\<?= number_format($DETAIL[0]['shipping_fee']) ?></td>
						</tr>

						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>合計</td>
							<td class="text-right" style="padding:0.75rem;"><?= $cnt ?></td>
							<td>\<?= number_format(intval($DETAIL[0]['total_cost'])) ?></td>
						</tr>
					</tbody>
				</table>

				<p class="sub-title mt-5">その他</p>

				<dl class="others">
					<dt>お支払方法</dt>
					<dd><?= $CONF['payment_method'][$DETAIL[0]['payment_method']] ?></dd>
				</dl>

				<dl class="others">
					<?php
						$w = array('日', '月', '火', '水', '木', '金', '土');
						if( !empty($DETAIL[0]['delivery_date']) ) {
							$delivery_date = date('Y/m/d', strtotime($DETAIL[0]['delivery_date'])). '(' . $w[date('w', strtotime($DETAIL[0]['delivery_date']))] . ')';
						}
						else {
							$delivery_date = '最短';
						}
					?>
					<dt>お届け日</dt>
					<dd><?= $delivery_date ?></dd>
				</dl>

				<dl class="others">
					<dt>お届け時間</dt>
					<dd><?= $CONF['delivery_time'][$DETAIL[0]['delivery_time']] ?></dd>
				</dl>

				<dl class="others">
					<dt>備考</dt>
					<dd><?= nl2br($DETAIL[0]['note']) ?></dd>
				</dl>

				<div class="row my-5">
					<div class="col-6 text-center">
						<?php echo form_button(array(
							'name'		=> 'btn_back',
							'content'	=> '戻る',
							'class'		=> 'btn btn-primary',
							'onclick'	=> 'location.href=\'' . site_url('history') . '\''
						)); ?>
					</div>
					<div class="col-6 text-center">
						<?php echo form_button(array(
							'name'		=> 'btn_reorder',
							'content'	=> '同じ教材を発注する',
							'class'		=> 'btn btn-danger',
							'onclick'	=> 'reorder(' . $DETAIL[0]['order_id'] . ');'
						)); ?>
					</div>
				</div>
			<?php endif; ?>
		</div> <!-- end of .container -->

		<?php $this->load->view('inc/_foot'); ?>
		<?php $this->load->view('inc/footer'); ?>
	</div> <!-- end of #wrapper -->

	<script src="<?= base_url('js/front.history_detail.js') ?>?var=<?= CACHES_CLEAR_VERSION ?>"></script>
</body>
</html>
