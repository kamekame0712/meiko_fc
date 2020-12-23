<?php $this->load->view('inc/_head', array('TITLE' => SITE_NAME)); ?>

<body>
	<div id="wrapper">
		<?php $this->load->view('inc/header', array('MENU' => TRUE)); ?>

		<div class="container">
			<p class="lead-title">発注詳細</p>

			<?php if( empty($DETAIL) ): ?>
				発注詳細はありません。
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

				<?php echo form_button(array(
					'name'		=> 'btn_reorder',
					'content'	=> '同じ商品を発注する',
					'class'		=> 'btn btn-danger mb-5',
					'onclick'	=> 'reorder(' . $DETAIL[0]['order_id'] . ');'
				)); ?>

				<p class="sub-title">その他</p>

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
					<dt>お支払方法</dt>
					<dd><?= $CONF['delivery_time'][$DETAIL[0]['delivery_time']] ?></dd>
				</dl>
			<?php endif; ?>

			<?php echo form_button(array(
				'name'		=> 'btn_back',
				'content'	=> '戻る',
				'class'		=> 'btn btn-primary my-5',
				'onclick'	=> 'location.href=\'' . site_url('history') . '\''
			)); ?>
		</div> <!-- end of .container -->

		<?php $this->load->view('inc/_foot'); ?>
		<?php $this->load->view('inc/footer'); ?>
	</div> <!-- end of #wrapper -->

	<script src="<?= base_url('js/front.history_detail.js') ?>?var=<?= CACHES_CLEAR_VERSION ?>"></script>
</body>
</html>
