<?php $this->load->view('inc/_head', array('TITLE' => '教材選択/' . SITE_NAME)); ?>

<body>
	<div class="choose-product-window">
		<p class="lead-title">
			教材選択
			<?php if( $FLG_HIDE == '1' ): ?>
				<a href="javascript:void(0);" class="hide-conditions" id="hide_conditions" onclick="hide_conditions();"><i class="fas fa-angle-double-up"></i>&nbsp;検索条件を隠す</a>
			<?php else: ?>
				<a href="javascript:void(0);" class="hide-conditions" id="hide_conditions" onclick="hide_conditions();"><i class="fas fa-angle-double-down"></i>&nbsp;検索条件を表示する</a>
			<?php endif; ?>
		</p>

		<?php echo form_open('order/choose_product', array('id' => 'frm_choose_product')); ?>
			<?php echo form_input(array(
				'name'	=> 'flg_hide',
				'id'	=> 'flg_hide',
				'value'	=> set_value('flg_hide', '1'),
				'type'	=> 'hidden'
			)); ?>

			<div class="conditions">
				<?php
					if( $FLG_HIDE == '1' ) {
						$display = 'block';
					}
					else {
						$display = 'none';
					}
				?>

				<div class="container-fluid" id="product_conditions" style="display:<?= $display ?>">
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
						<dt>教材名/<br>キーワード</dt>
						<dd>
							<?php echo form_input(array(
								'name'	=> 'cond_keyword',
								'id'	=> 'cond_keyword',
								'value'	=> set_value('cond_keyword', '' )
							)); ?><br>
							※『教材名』『キーワード』は一部だけでも検索できます。<br />
						</dd>

						<dt>対象</dt>
						<dd>
							<?php echo form_checkbox(array(
								'name'	=> 'recommend',
								'id'	=> 'recommend',
								'value'	=> '1',
								'checked'	=> set_checkbox('recommend', '1', TRUE)
							)); ?>
							<?php echo form_label('明光本部推奨教材のみ表示する', 'recommend'); ?>
						</dd>

						<dt>学年</dt>
						<dd>
							<?php echo form_checkbox(array(
								'name'	=> 'all_elementary',
								'id'	=> 'all_elementary',
								'value'	=> '01',
								'checked'	=> set_checkbox('all_elementary', '01', FALSE),
								'style'	=> 'margin-left:-2rem;'
							)); ?>
							<?php echo form_label('小学生', 'all_elementary'); ?>

							<div class="container-fluid" style="padding:0;">
								<div class="row">
									<?php foreach( $CONF['grade_e'] as $key => $val ): ?>
										<div class="col-2">
											<?php echo form_checkbox(array(
												'name'	=> 'grade_e[]',
												'id'	=> 'grade_e_' . $key,
												'value'	=> $key,
												'checked'	=> set_checkbox('grade_e[]', $key, FALSE)
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
								'checked'	=> set_checkbox('all_junior', '02', FALSE),
								'style'	=> 'margin-left:-2rem;'
							)); ?>
							<?php echo form_label('中学生', 'all_junior'); ?>

							<div class="container-fluid" style="padding:0;">
								<div class="row">
									<?php foreach( $CONF['grade_j'] as $key => $val ): ?>
										<div class="col-2">
											<?php echo form_checkbox(array(
												'name'	=> 'grade_j[]',
												'id'	=> 'grade_j_' . $key,
												'value'	=> $key,
												'checked'	=> set_checkbox('grade_j[]', $key, FALSE)
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
								'checked'	=> set_checkbox('all_high', '03', FALSE),
								'style'	=> 'margin-left:-2rem;'
							)); ?>
							<?php echo form_label('高校生', 'all_high'); ?>

							<div class="container-fluid" style="padding:0;">
								<div class="row">
									<?php foreach( $CONF['grade_h'] as $key => $val ): ?>
										<div class="col-2">
											<?php echo form_checkbox(array(
												'name'	=> 'grade_h[]',
												'id'	=> 'grade_h_' . $key,
												'value'	=> $key,
												'checked'	=> set_checkbox('grade_h[]', $key, FALSE)
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
										<div class="col-2">
											<?php echo form_checkbox(array(
												'name'	=> 'subject[]',
												'id'	=> 'subject_' . $key,
												'value'	=> $key,
												'checked'	=> set_checkbox('subject[]', $key, FALSE)
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
										<div class="col-2">
											<?php echo form_checkbox(array(
												'name'	=> 'period[]',
												'id'	=> 'period_' . $key,
												'value'	=> $key,
												'checked'	=> set_checkbox('period[]', $key, FALSE)
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
										<div class="col-2">
											<?php echo form_checkbox(array(
												'name'	=> 'publisher[]',
												'id'	=> 'publisher_' . $key,
												'value'	=> $key,
												'checked'	=> set_checkbox('publisher[]', $key, FALSE)
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

		<?php if( is_null($APPLICABLE) ): ?>
			ご指定の条件では該当する教材が存在しません。
		<?php elseif( !empty($APPLICABLE) ): ?>
			<div class="product-list">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>&nbsp;</th>
							<th>出版社</th>
							<th>教材名</th>
							<th>価格</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach( $APPLICABLE as $val ): ?>
							<tr>
								<td>
									<?php if( $val['flg_sales'] == '1' ): ?>
										<?php echo form_button(array(
											'name'		=> 'btn_choose',
											'content'	=> '選択',
											'class'		=> 'btn-choose',
											'onclick'	=> 'choose(\'' . $val['product_id'] . '\');'
										)); ?>
									<?php else: ?>
										<span class="not-for-sale"><?= $CONF['flg_sales'][$val['flg_sales']] ?></span>
									<?php endif; ?>
								</td>
								<td><?= $CONF['publisher'][$val['publisher']] ?></td>
								<td><?= $val['name'] ?></td>
								<td>\<?= number_format($val['sales_price']) ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>

				<div class="pagination"><?= $PAGINATION ?><?= $SHOWING ?></div>
			</div> <!-- end of .product-list -->
		<?php endif; ?>
	</div> <!-- end of .choose-product-window -->

	<?php $this->load->view('inc/_foot'); ?>
	<script src="<?= site_url('js/choose_product.js') ?>?var=<?= CACHES_CLEAR_VERSION ?>"></script>
</body>
</html>
