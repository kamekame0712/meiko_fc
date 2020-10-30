<?php $this->load->view('inc/_head', array('TITLE' => '商品選択/' . SITE_NAME)); ?>

<body>
	<div class="choose-product-window">
		<p class="lead-title">商品選択</p>

		<?php echo form_open('order/choose_product'); ?>
			<div class="conditions">
				<div class="container-fluid" id="product_conditions">
					<div class="row">
						<div class="col-9">
							<p>
								検索条件を入力し、『検索』ボタンをクリックしてください。
							</p>
						</div>

						<div class="col-3 align-right">
							<?php echo form_button(array(
								'name'		=> 'btn-reset-condition',
								'content'	=> '検索条件のクリア',
								'class'		=> 'btn btn-sm btn-danger',
								'onclick'	=> 'reset_conditions();'
							)); ?>
						</div>
					</div> <!-- end of .row -->

					<dl>
						<dt>教材名または<br>教材コード</dt>
						<dd>
							<?php echo form_input(array(
								'name'	=> 'cond_keyword',
								'id'	=> 'cond_keyword',
								'value'	=> set_value('cond_keyword', '' )
							)); ?><br>
							※『教材名』・『教材コード』は一部だけでも検索できます。<br />
						</dd>

						<dt>学年</dt>
						<dd>
							<?php echo form_checkbox(array(
								'name'	=> 'all_elementary',
								'id'	=> 'all_elementary',
								'value'	=> '01',
								'style'	=> 'margin-left:-2rem;'
							)); ?>
							<?php echo form_label('小学生', 'all_elementary'); ?>

							<div class="container-fluid" style="padding:0;">
								<div class="row">
									<?php foreach( $CONF['grade_e'] as $key => $val ): ?>
										<div class="col-3">
											<?php echo form_checkbox(array(
												'name'	=> 'grade_e[]',
												'id'	=> 'grade_e_' . $key,
												'value'	=> $key,
												'checked'	=> set_checkbox('grade_e[]', $key)
											)); ?>
											<?php echo form_label($val, 'grade_e_' . $key); ?>
										</div>
									<?php endforeach; ?>
								</div>
							</div>

							<?php echo form_checkbox(array(
								'name'	=> 'all_junior',
								'id'	=> 'all_junior',
								'value'	=> '02',
								'style'	=> 'margin-left:-2rem;'
							)); ?>
							<?php echo form_label('中学生', 'all_junior'); ?>

							<div class="container-fluid" style="padding:0;">
								<div class="row">
									<?php foreach( $CONF['grade_j'] as $key => $val ): ?>
										<div class="col-3">
											<?php echo form_checkbox(array(
												'name'	=> 'grade_j[]',
												'id'	=> 'grade_j_' . $key,
												'value'	=> $key,
												'checked'	=> set_checkbox('grade_j[]', $key)
											)); ?>
											<?php echo form_label($val, 'grade_j_' . $key); ?>
										</div>
									<?php endforeach; ?>
								</div>
							</div>

							<?php echo form_checkbox(array(
								'name'	=> 'all_high',
								'id'	=> 'all_high',
								'value'	=> '03',
								'style'	=> 'margin-left:-2rem;'
							)); ?>
							<?php echo form_label('高校生', 'all_high'); ?>

							<div class="container-fluid" style="padding:0;">
								<div class="row">
									<?php foreach( $CONF['grade_h'] as $key => $val ): ?>
										<div class="col-3">
											<?php echo form_checkbox(array(
												'name'	=> 'grade_h[]',
												'id'	=> 'grade_h_' . $key,
												'value'	=> $key,
												'checked'	=> set_checkbox('grade_h[]', $key)
											)); ?>
											<?php echo form_label($val, 'grade_h_' . $key); ?>
										</div>
									<?php endforeach; ?>
								</div>
							</div>
						</dd>

						<dt>教科</dt>
						<dd>
							<div class="container-fluid" style="padding:0;">
								<div class="row">
									<?php foreach( $CONF['subject'] as $key => $val ): ?>
										<div class="col-3">
											<?php echo form_checkbox(array(
												'name'	=> 'subject[]',
												'id'	=> 'subject_' . $key,
												'value'	=> $key,
												'checked'	=> set_checkbox('subject[]', $key)
											)); ?>
											<?php echo form_label($val, 'subject_' . $key); ?>
										</div>
									<?php endforeach; ?>
								</div>
							</div>
						</dd>

						<dt>期間講習</dt>
						<dd>
							<div class="container-fluid" style="padding:0;">
								<div class="row">
									<?php foreach( $CONF['period'] as $key => $val ): ?>
										<div class="col-3">
											<?php echo form_checkbox(array(
												'name'	=> 'period[]',
												'id'	=> 'period_' . $key,
												'value'	=> $key,
												'checked'	=> set_checkbox('period[]', $key)
											)); ?>
											<?php echo form_label($val, 'period_' . $key); ?>
										</div>
									<?php endforeach; ?>
								</div>
							</div>
						</dd>

						<dt>出版社</dt>
						<dd>
							<div class="container-fluid" style="padding:0;">
								<div class="row">
									<?php foreach( $CONF['publisher'] as $key => $val ): ?>
										<div class="col-3">
											<?php echo form_checkbox(array(
												'name'	=> 'publisher[]',
												'id'	=> 'publisher_' . $key,
												'value'	=> $key,
												'checked'	=> set_checkbox('publisher[]', $key)
											)); ?>
											<?php echo form_label($val, 'publisher_' . $key); ?>
										</div>
									<?php endforeach; ?>
								</div>
							</div>
						</dd>
					</dl>

					<div class="row">
						<div class="col-3 offset-9 align-right">
							<?php echo form_submit(array(
								'value'	=> '検索',
								'class'	=> 'btn btn-primary float-right'
							)); ?>
						</div>
					</div>
				</div> <!-- end of .container-fluid -->
			</div> <!-- end of .conditions -->
		<?php echo form_close(); ?>

		<div class="product-list">
			該当数：2件
			<table class="table table-striped">
				<thead>
					<tr>
						<th>&nbsp;</th>
						<th>教材コード</th>
						<th>出版社</th>
						<th>教材名</th>
						<th>価格</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<?php echo form_checkbox(array(
								'name'	=> 'chk_p1'
							)); ?>
						</td>
						<td>CNK11001801</td>
						<td>EN</td>
						<td>標準新演習　小５英語</td>
						<td>\1,628</td>
					</tr>
					<tr>
						<td>
							<?php echo form_checkbox(array(
								'name'	=> 'chk_p1'
							)); ?>
						</td>
						<td>CNK11001802</td>
						<td>EN</td>
						<td>標準新演習　小６英語</td>
						<td>\1,628</td>
					</tr>
				</tbody>
			</table>
		</div> <!-- end of .product-list -->
	</div> <!-- end of .choose-product-window -->

	<script src="<?= site_url('js/choose_product.js') ?>?var=<?= CACHES_CLEAR_VERSION ?>"></script>
</body>
</html>
