<?php $this->load->view('inc/_head', array('TITLE' => SITE_NAME)); ?>

<body>
	<div id="wrapper">
		<?php $this->load->view('inc/header', array('MENU' => TRUE)); ?>

		<div class="container">
			<ul class="breadcrumb-list">
				<li>発注内容の選択</li>
				<li class="current">発注内容の確認</li>
				<li>完了</li>
			</ul>

			<p class="lead-title">発注内容</p>

			<?php if( !empty($PLIST) ): ?>
				<table class="table table-striped tbl-order-confirm">
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
						<?php foreach( $PLIST as $val ): ?>
							<tr>
								<td><?= $val['publisher_name'] ?></td>
								<td><?= $val['product_name'] ?></td>
								<td>\<?= number_format($val['sales_price']) ?></td>
								<td><?= number_format($val['quantity']) ?></td>
								<td>\<?= number_format($val['sub_total']) ?></td>
							</tr>
						<?php endforeach; ?>

						<tr>
							<td>&nbsp;</td>
							<td class="text-right">送料</td>
							<td>\<?= number_format($SHIPPING_UNIT) ?></td>
							<td><?= $SHIPPING_CNT ?></td>
							<td>\<?= number_format($SHIPPING_FEE) ?></td>
						</tr>

						<?php if( $PDATA['payment_method'] == '3' ): ?>
							<?php if( $COMMISSION_FULL != 0 ): ?>
								<tr>
									<td>&nbsp;</td>
									<td class="text-right">代金引換手数料</td>
									<td>\<?= number_format($COMMISSION_FULL) ?></td>
									<td>1</td>
									<td>\<?= number_format($COMMISSION_FULL) ?></td>
								</tr>
							<?php elseif( $COMMISSION_MARKET == $COMMISSION_JUKU ): ?>
								<tr>
									<td>&nbsp;</td>
									<td class="text-right">代金引換手数料</td>
									<td>\<?= number_format($COMMISSION_MARKET) ?></td>
									<td>2</td>
									<td>\<?= number_format($COMMISSION_MARKET * 2) ?></td>
								</tr>
							<?php else: ?>
								<tr>
									<td>&nbsp;</td>
									<td class="text-right">代金引換手数料（『塾用教材』）</td>
									<td>\<?= number_format($COMMISSION_JUKU) ?></td>
									<td>1</td>
									<td>\<?= number_format($COMMISSION_JUKU) ?></td>
								</tr>

								<tr>
									<td>&nbsp;</td>
									<td class="text-right">代金引換手数料（『市販教材』）</td>
									<td>\<?= number_format($COMMISSION_MARKET) ?></td>
									<td>1</td>
									<td>\<?= number_format($COMMISSION_MARKET) ?></td>
								</tr>
							<?php endif; ?>
						<?php endif; ?>

						<tr>
							<td>&nbsp;</td>
							<td class="text-right">合計</td>
							<td>&nbsp;</td>
							<td class="text-right" style="padding:0.75rem;"><?= $TOTAL_QUANTITY ?></td>
							<td>\<?= number_format($TOTAL_COST + $SHIPPING_FEE + $COMMISSION_FULL + $COMMISSION_MARKET + $COMMISSION_JUKU) ?></td>
						</tr>
					</tbody>
				</table>
			<?php endif; ?>

			<p class="lead-title mt-5">その他</p>

			<?php if( $PRODUCT_KIND == 1 ): ?>
				<dl class="others">
					<dt>市販教材</dt>
					<dd>
						<?php if( $PDATA['flg_partial'] == '1' ): ?>
							『塾用教材』と一緒にお届け
						<?php else: ?>
							『塾用教材』とは別々でお届け
						<?php endif; ?>
					</dd>
				</dl>
			<?php endif; ?>

			<dl class="others">
				<dt>お支払方法</dt>
				<dd><?= $CONF['payment_method'][$PDATA['payment_method']] ?></dd>
			</dl>

			<?php if( $PDATA['payment_method'] == '2' ): ?>
				<dl class="others">
					<dt>カード番号</dt>
					<dd>
						<?= $PDATA['gmo_maskedCardNo'] ?>
						<?php if( $PDATA['card_type'] == '2' ): ?>
							（クレジットカード情報を登録<?= ( isset($PDATA['chk_register']) && $PDATA['chk_register'] == '1' ) ? 'する' : 'しない' ?>）
						<?php endif; ?>
					</dd>
				</dl>
			<?php endif; ?>

			<dl class="others">
				<dt>お届け日</dt>
				<dd>
					<?php
						$delivery_date = '最短';
						if( !empty($PDATA['delivery_date']) ) {
							$w = array('日', '月', '火', '水', '木', '金', '土');
							$delivery_date = date('Y/m/d', strtotime($PDATA['delivery_date'])) . '(' . $w[date('w', strtotime($PDATA['delivery_date']))] . ')';
						}
					?>

					<?= $delivery_date ?>
				</dd>
			</dl>

			<dl class="others">
				<dt>お届け時間</dt>
				<dd><?= $CONF['delivery_time'][$PDATA['delivery_time']] ?></dd>
			</dl>

			<dl class="others">
				<dt>備考</dt>
				<dd><?= nl2br($PDATA['note']) ?></dd>
			</dl>

			<div class="text-center mt-5 mb-5">
				<?php echo form_open('order/complete'); ?>
					<?php echo form_hidden($PDATA); ?>
					<?php echo form_hidden($PLIST); ?>
					<?php echo form_hidden(array('total_cost' => $TOTAL_COST)); ?>
					<?php echo form_hidden(array('shipping_fee' => $SHIPPING_FEE)); ?>
					<?php echo form_hidden(array('commission' => ( $COMMISSION_FULL + $COMMISSION_MARKET + $COMMISSION_JUKU ))); ?>
					<?php echo form_hidden(array('exists_market' => ( $PRODUCT_KIND == 2 ? '1' : '2') )); ?>

					<?php echo form_button(array(
						'name'		=> 'btn-back',
						'content'	=> '　戻る　',
						'class'		=> 'btn btn-secondary',
						'onclick'	=> 'location.href=\'' . site_url('order') . '\''
					)); ?>&nbsp;&nbsp;

					<?php echo form_submit(array(
						'name'		=> 'btn-submit',
						'value'		=> '　発注　',
						'class'		=> 'btn btn-success'
					)); ?>
				<?php echo form_close(); ?>
			</div>
		</div> <!-- end of .container -->

		<?php $this->load->view('inc/_foot'); ?>
		<?php $this->load->view('inc/footer'); ?>
	</div> <!-- end of #wrapper -->
</body>
</html>
