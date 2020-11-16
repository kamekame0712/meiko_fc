<?php $this->load->view('inc/_head', array('TITLE' => SITE_NAME)); ?>

<body>
	<div id="wrapper">
		<?php $this->load->view('inc/header'); ?>

		<div class="container">
			<?php echo form_open('order/confirm', array('id' => 'frm_order')); ?>
				<p class="lead-title">発注内容</p>

				<div class="order-buttons">
					<?php echo form_button(array(
						'name'		=> 'btn-add-product',
						'content'	=> '商品選択',
						'class'		=> 'btn btn-primary float-left ',
						'onclick'	=> 'choose_product();'
					)); ?>

					<?php if( !empty($PLIST) ): ?>
						<a href="<?= site_url('order/remove_all_order') ?>" class="btn btn-danger float-right">全商品削除</a>
					<?php endif; ?>
				</div>

				<?php $i = 1; ?>
				<?php if( !empty($PLIST) ): ?>
					<table class="table table-striped tbl-order">
						<thead>
							<tr>
								<th>削除</th>
								<th>出版社</th>
								<th>教材名</th>
								<th>単価</th>
								<th>数量</th>
								<th>金額</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach( $PLIST as $product_id => $val ): ?>
								<tr>
									<td>
										<a href="<?= site_url('order/remove_order/' . $product_id) ?>">
											<i class="fas fa-times"></i>
										</a>
									</td>
									<td><?= $val['publisher_name'] ?></td>
									<td><?= $val['product_name'] ?></td>
									<td>\<?= number_format($val['sales_price']) ?></td>
									<td>
										<?php echo form_input(array(
											'name'		=> 'num_' . $product_id,
											'data-id'	=> $product_id,
											'type'		=> 'number',
											'min'		=> 0,
											'value'		=> $val['quantity'],
											'class'		=> 'input-num',
											'tabindex'	=> $i
										)); ?>
									</td>
									<td>\<?= number_format($val['sub_total']) ?></td>
								</tr>

								<?php $i++; ?>
							<?php endforeach; ?>

							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>合計</td>
								<td class="text-right" style="padding:0.75rem;"><?= $TOTAL_QUANTITY ?></td>
								<td>\<?= number_format($TOTAL_COST) ?></td>
							</tr>
						</tbody>
					</table>
				<?php endif; ?>

				<p class="lead-title mt-5">その他</p>

				<dl class="others">
					<dt>お支払方法</dt>
					<dd>
						<div class="container-fluid">
							<div class="row">
								<div class="col-md-2 pl-0">
									<?php echo form_radio(array(
										'name'	=> 'payment_method',
										'id'	=> 'pm1',
										'value'	=> 1,
										'checked'	=> $PAYMENT == '1' ? TRUE : FALSE,
										'tabindex'	=> $i++
									)); ?>
									<?php echo form_label('掛け', 'pm1'); ?>
								</div>

								<div class="col-md-2 pl-0">
									<?php echo form_radio(array(
										'name'	=> 'payment_method',
										'id'	=> 'pm2',
										'value'	=> 2,
										'checked'	=> $PAYMENT == '2' ? TRUE : FALSE,
										'tabindex'	=> $i++
									)); ?>
									<?php echo form_label('クレジット', 'pm2'); ?>
								</div>

								<div class="col-md-2 pl-0">
									<?php echo form_radio(array(
										'name'	=> 'payment_method',
										'id'	=> 'pm3',
										'value'	=> 3,
										'checked'	=> $PAYMENT == '3' ? TRUE : FALSE,
										'tabindex'	=> $i++
									)); ?>
									<?php echo form_label('代引き', 'pm3'); ?>
								</div>
							</div> <!-- end of .row -->
						</div>
					</dd>

					<dt>お届け日</dt>
					<dd>
						<?php echo form_dropdown('delivery_date', $SELECT_DATE, $DELIVERY_DATE, 'class="select-other" tabindex="' . $i++ . '"'); ?>
					</dd>

					<dt>お届け時間</dt>
					<dd>
						<?php echo form_dropdown('delivery_time', $SELECT_TIME, $DELIVERY_TIME, 'class="select-other" tabindex="' . $i++ . '"'); ?>
					</dd>
<?php /* ?>
					<dt>備考</dt>
					<dd>
						<?php echo form_textarea(array(
							'name'	=> 'note',
							'class'	=> 'textarea-other'
						)); ?>
					</dd>
<?php */ ?>
				</dl>

				<div class="text-center mt-5 mb-5">
					<?php echo form_button(array(
						'name'		=> 'btn-submit',
						'content'	=> '　確認　',
						'class'		=> 'btn btn-success mt-5',
						'onclick'	=> 'do_submit()'
					)); ?>
				</div>
			<?php echo form_close(); ?>
		</div> <!-- end of .container -->
		
		<?php $this->load->view('inc/_foot'); ?>
		<?php $this->load->view('inc/footer'); ?>
	</div> <!-- end of #wrapper -->

	<script src="<?= base_url('js/front.order.js') ?>?var=<?= CACHES_CLEAR_VERSION ?>"></script>
</body>
</html>
