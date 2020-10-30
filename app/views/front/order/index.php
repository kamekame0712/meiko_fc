<?php $this->load->view('inc/_head', array('TITLE' => SITE_NAME)); ?>

<body>
	<div id="wrapper">
		<?php $this->load->view('inc/header'); ?>

		<div class="container">
			<p class="lead-title">発注内容</p>

			<?php echo form_button(array(
				'name'		=> 'btn-add-product',
				'content'	=> '商品選択',
				'class'		=> 'btn btn-primary',
				'onclick'	=> 'choose_product();'
			)); ?>

			<table class="table table-striped tbl-order">
				<thead>
					<tr>
						<th>教材コード</th>
						<th>出版社</th>
						<th>教材名</th>
						<th>価格</th>
						<th>数量</th>
						<th>金額</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>CNK11001801</td>
						<td>EN</td>
						<td>標準新演習　小５英語</td>
						<td>\1,628</td>
						<td>
							<?php echo form_input(array(
								'name'	=> 'num',
								'type'	=> 'number',
								'min'	=> 0,
								'value'	=> 1,
								'class'	=> 'input-num'
							)); ?>
						</td>
						<td>\1,628</td>
					</tr>
					<tr>
						<td>CNK11001108</td>
						<td>学書</td>
						<td>教科書計算ドリル　小５（東書）2020改</td>
						<td>\715</td>
						<td>
							<?php echo form_input(array(
								'name'	=> 'num',
								'type'	=> 'number',
								'min'	=> 0,
								'value'	=> 1,
								'class'	=> 'input-num'
							)); ?>
						</td>
						<td>\715</td>
					</tr>
					<tr>
						<td>NK45010406</td>
						<td>漢検</td>
						<td>改訂四版 漢検 漢字学習ステップ 6級</td>
						<td>\990</td>
						<td>
							<?php echo form_input(array(
								'name'	=> 'num',
								'type'	=> 'number',
								'min'	=> 0,
								'value'	=> 3,
								'class'	=> 'input-num'
							)); ?>
						</td>
						<td>\2,970</td>
					</tr>
					<tr>
						<td>CNK11001303</td>
						<td>学研Plus</td>
						<td>作文力ドリル 作文の基本編 小学高学年用</td>
						<td>\1,100</td>
						<td>
							<?php echo form_input(array(
								'name'	=> 'num',
								'type'	=> 'number',
								'min'	=> 0,
								'value'	=> 2,
								'class'	=> 'input-num'
							)); ?>
						</td>
						<td>\2,200</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>合計</td>
						<td class="text-right" style="padding:0.75rem;">7</td>
						<td>\7,513</td>
					</tr>
				</tbody>
			</table>

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
									'value'	=> 1
								)); ?>
								<?php echo form_label('掛け', 'pm1'); ?>
							</div>

							<div class="col-md-2 pl-0">
								<?php echo form_radio(array(
									'name'	=> 'payment_method',
									'id'	=> 'pm2',
									'value'	=> 2
								)); ?>
								<?php echo form_label('クレジット', 'pm2'); ?>
							</div>

							<div class="col-md-2 pl-0">
								<?php echo form_radio(array(
									'name'	=> 'payment_method',
									'id'	=> 'pm3',
									'value'	=> 3
								)); ?>
								<?php echo form_label('代引き', 'pm3'); ?>
							</div>
						</div> <!-- end of .row -->
					</div>
				</dd>

				<dt>お届け日</dt>
				<dd>
					<?php echo form_dropdown(
						'delivery_date',
						array(
							'最短',
							'2020/11/1(日)'
						),
						'',
						'class="select-other"'
					); ?>
				</dd>

				<dt>お届け時間</dt>
				<dd>
					<?php echo form_dropdown(
						'delivery_time',
						array(
							'指定なし',
							'午前'
						),
						'',
						'class="select-other"'
					); ?>
				</dd>

				<dt>備考</dt>
				<dd>
					<?php echo form_textarea(array(
						'name'	=> 'note',
						'class'	=> 'textarea-other'
					)); ?>
				</dd>
			</dl>

			<div class="text-center mt-5 mb-5">
				<?php echo form_button(array(
					'name'		=> 'btn-submit',
					'content'	=> '　確認　',
					'class'		=> 'btn btn-success mt-5'
				)); ?>
			</div>
		</div> <!-- end of .container -->
		
		<?php $this->load->view('inc/_foot'); ?>
		<?php $this->load->view('inc/footer'); ?>
	</div> <!-- end of #wrapper -->

	<script src="<?= base_url('js/front.order.js') ?>?var=<?= CACHES_CLEAR_VERSION ?>"></script>
</body>
</html>
