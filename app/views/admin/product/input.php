<?php $this->load->view('inc/admin/_head', array('TITLE' => '教材管理 | ' . SITE_NAME)); ?>

<body>
	<div id="app">
		<div class="main-wrapper main-wrapper-1">
			<?php $this->load->view('inc/admin/header'); ?>
			<?php $this->load->view('inc/admin/sidebar', array('current' => 'product')); ?>

			<div class="main-content">
				<section class="section">
					<div class="section-header">
						<h1>教材管理 <?= $KIND == 'add' ? '新規追加' : '修正' ?></h1>
					</div>

					<div class="section-body">
						<?php echo form_open('admin/product/confirm'); ?>
							<?php echo form_hidden('kind', $KIND) ?>
							<?php echo form_hidden('product_id', $PID) ?>

							<div class="row">
								<div class="col-4">
									<div class="card card-primary">
										<div class="card-header">
											<h4>基本情報</h4>
										</div>
										<div class="card-body">
											<div class="form-group">
												<?php echo form_label('教材名', '', array('class' => 'required-label')); ?>
												<?php echo form_input(array(
													'name'	=> 'name',
													'value'	=> set_value('name', ( !empty($PDATA['name']) ? $PDATA['name'] : '' )),
													'class'	=> 'form-control'
												)); ?>
												<?php echo form_error('name'); ?>
											</div>

											<div class="form-group">
												<?php echo form_label('SMILEコード', ''); ?>
												<?php echo form_input(array(
													'name'	=> 'smile_code',
													'value'	=> set_value('smile_code', ( !empty($PDATA['smile_code']) ? $PDATA['smile_code'] : '' )),
													'class'	=> 'form-control'
												)); ?>
												<?php echo form_error('smile_code'); ?>
											</div>

											<div class="form-group">
												<?php echo form_label('検索用キーワード', ''); ?>
												<?php echo form_input(array(
													'name'	=> 'keyword',
													'id'	=> 'keyword',
													'value'	=> set_value('keyword', ( !empty($PDATA['keyword']) ? $PDATA['keyword'] : '' )),
													'class'	=> 'form-control'
												)); ?>
											</div>

											<div class="form-group">
												<?php echo form_label('出版社', ''); ?>
												<?php echo form_dropdown('publisher', array('' => '選択してください') + $CONF['publisher'], set_value('publisher', ( !empty($PDATA['publisher']) ? $PDATA['publisher'] : '' )), 'class="form-control"'); ?>
											</div>

											<div class="form-group">
												<?php echo form_label('通常価格', ''); ?>
												<?php echo form_input(array(
													'name'	=> 'normal_price',
													'value'	=> set_value('normal_price', ( isset($PDATA['normal_price']) ? $PDATA['normal_price'] : '' )),
													'class'	=> 'form-control'
												)); ?>
												<?php echo form_error('normal_price'); ?>
											</div>

											<div class="form-group">
												<?php echo form_label('販売価格', '', array('class' => 'required-label')); ?>
												<?php echo form_input(array(
													'name'	=> 'sales_price',
													'value'	=> set_value('sales_price', ( isset($PDATA['sales_price']) ? $PDATA['sales_price'] : '' )),
													'class'	=> 'form-control'
												)); ?>
												<?php echo form_error('sales_price'); ?>
											</div>
										</div>
									</div> <!-- end of .card -->
								</div>

								<div class="col-4">
									<div class="card card-primary">
										<div class="card-header">
											<h4>補足情報</h4>
										</div>
										<div class="card-body">
											<div class="form-group">
												<?php echo form_label('明光本部推奨', '', array('class' => 'd-block')); ?>

												<?php echo form_checkbox(array(
													'name'	=> 'recommend',
													'id'	=> 'recommend',
													'value'	=> '1',
													'checked'	=> set_radio('recommend', '1', ( isset($PDATA['recommend']) && $PDATA['recommend'] == '1' ? TRUE : FALSE ))
												)); ?>
												<?php echo form_label('推奨教材', 'recommend', array('class' => 'font-weight-normal')); ?>
											</div>

											<div class="form-group">
												<?php echo form_label('塾用/市販', '', array('class' => 'd-block required-label')); ?>

												<?php echo form_radio(array(
													'name'	=> 'flg_market',
													'id'	=> 'flg_market_1',
													'value'	=> '1',
													'checked'	=> set_radio('flg_market', '1', ( isset($PDATA['flg_market']) && $PDATA['flg_market'] == '1' ? TRUE : FALSE ))
												)); ?>
												<?php echo form_label('塾用教材', 'flg_market_1', array('class' => 'font-weight-normal')); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

												<?php echo form_radio(array(
													'name'	=> 'flg_market',
													'id'	=> 'flg_market_2',
													'value'	=> '2',
													'checked'	=> set_radio('flg_market', '2', ( isset($PDATA['flg_market']) && $PDATA['flg_market'] == '2' ? TRUE : FALSE ))
												)); ?>
												<?php echo form_label('市販教材', 'flg_market_2', array('class' => 'font-weight-normal')); ?>

												<?php echo form_error('flg_market'); ?>
											</div>

											<div class="form-group">
												<?php echo form_label('発刊状況', '', array('class' => 'd-block required-label')); ?>

												<?php echo form_radio(array(
													'name'	=> 'flg_sales',
													'id'	=> 'flg_sales_1',
													'value'	=> '1',
													'checked'	=> set_radio('flg_sales', '1', ( isset($PDATA['flg_sales']) && $PDATA['flg_sales'] == '1' ? TRUE : FALSE ))
												)); ?>
												<?php echo form_label('通常（販売可）', 'flg_sales_1', array('class' => 'font-weight-normal')); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

												<?php echo form_radio(array(
													'name'	=> 'flg_sales',
													'id'	=> 'flg_sales_2',
													'value'	=> '2',
													'checked'	=> set_radio('flg_sales', '2', ( isset($PDATA['flg_sales']) && $PDATA['flg_sales'] == '2' ? TRUE : FALSE ))
												)); ?>
												<?php echo form_label('売切', 'flg_sales_2', array('class' => 'font-weight-normal')); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

												<?php echo form_radio(array(
													'name'	=> 'flg_sales',
													'id'	=> 'flg_sales_3',
													'value'	=> '3',
													'checked'	=> set_radio('flg_sales', '3', ( isset($PDATA['flg_sales']) && $PDATA['flg_sales'] == '3' ? TRUE : FALSE ))
												)); ?>
												<?php echo form_label('未発刊', 'flg_sales_3', array('class' => 'font-weight-normal')); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

												<?php echo form_error('flg_sales'); ?>
											</div>
										</div>
									</div> <!-- end of .card -->
								</div>

								<div class="col-4">
									<div class="card card-primary">
										<div class="card-header">
											<h4>追加情報</h4>
										</div>
										<div class="card-body">
											<div class="form-group">
												<?php echo form_label('学年等', '', array('class' => 'd-block')); ?>

												<div class="container-fluid">
													<div class="row">
														<?php foreach( $CONF['grade_e'] as $key => $val ): ?>
															<div class="col-4">
																<?php echo form_checkbox(array(
																	'name'	=> 'grade[]',
																	'id'	=> 'grade_' . $key,
																	'value'	=> $key,
																	'checked'	=> set_radio('grade[]', $key, ( isset($PDATA['grade']) && in_array($key, explode(',', $PDATA['grade'])) ? TRUE : FALSE ))
																)); ?>
																<?php echo form_label($val, 'grade_' . $key, array('class' => 'font-weight-normal')); ?>
															</div>
														<?php endforeach; ?>
													</div> <!-- end of .row -->

													<div class="row">
														<?php foreach( $CONF['grade_j'] as $key => $val ): ?>
															<div class="col-4">
																<?php echo form_checkbox(array(
																	'name'	=> 'grade[]',
																	'id'	=> 'grade_' . $key,
																	'value'	=> $key,
																	'checked'	=> set_radio('grade[]', $key, ( isset($PDATA['grade']) && in_array($key, explode(',', $PDATA['grade'])) ? TRUE : FALSE ))
																)); ?>
																<?php echo form_label($val, 'grade_' . $key, array('class' => 'font-weight-normal')); ?>
															</div>
														<?php endforeach; ?>
													</div> <!-- end of .row -->

													<div class="row">
														<?php foreach( $CONF['grade_h'] as $key => $val ): ?>
															<div class="col-4">
																<?php echo form_checkbox(array(
																	'name'	=> 'grade[]',
																	'id'	=> 'grade_' . $key,
																	'value'	=> $key,
																	'checked'	=> set_radio('grade[]', $key, ( isset($PDATA['grade']) && in_array($key, explode(',', $PDATA['grade'])) ? TRUE : FALSE ))
																)); ?>
																<?php echo form_label($val, 'grade_' . $key, array('class' => 'font-weight-normal')); ?>
															</div>
														<?php endforeach; ?>
													</div> <!-- end of .row -->

													<div class="row">
														<?php foreach( $CONF['grade_o'] as $key => $val ): ?>
															<div class="col-4">
																<?php echo form_checkbox(array(
																	'name'	=> 'grade[]',
																	'id'	=> 'grade_' . $key,
																	'value'	=> $key,
																	'checked'	=> set_radio('grade[]', $key, ( isset($PDATA['grade']) && in_array($key, explode(',', $PDATA['grade'])) ? TRUE : FALSE ))
																)); ?>
																<?php echo form_label($val, 'grade_' . $key, array('class' => 'font-weight-normal')); ?>
															</div>
														<?php endforeach; ?>
													</div> <!-- end of .row -->
												</div> <!-- end of .container-fluid -->
											</div>

											<div class="form-group">
												<?php echo form_label('教科', '', array('class' => 'd-block')); ?>

												<div class="container-fluid">
													<div class="row">
														<?php foreach( $CONF['subject'] as $key => $val ): ?>
															<div class="col-4">
																<?php echo form_checkbox(array(
																	'name'	=> 'subject[]',
																	'id'	=> 'subject_' . $key,
																	'value'	=> $key,
																	'checked'	=> set_radio('subject[]', $key, ( isset($PDATA['subject']) && in_array($key, explode(',', $PDATA['subject'])) ? TRUE : FALSE ))
																)); ?>
																<?php echo form_label($val, 'subject_' . $key, array('class' => 'font-weight-normal')); ?>
															</div>
														<?php endforeach; ?>
													</div> <!-- end of .row -->
												</div> <!-- end of .container-fluid -->
											</div>

											<div class="form-group">
												<?php echo form_label('期間講習', '', array('class' => 'd-block')); ?>

												<div class="container-fluid">
													<div class="row">
														<?php foreach( $CONF['period'] as $key => $val ): ?>
															<div class="col-4">
																<?php echo form_checkbox(array(
																	'name'	=> 'period[]',
																	'id'	=> 'period_' . $key,
																	'value'	=> $key,
																	'checked'	=> set_radio('period[]', $key, ( isset($PDATA['period']) && in_array($key, explode(',', $PDATA['period'])) ? TRUE : FALSE ))
																)); ?>
																<?php echo form_label($val, 'period_' . $key, array('class' => 'font-weight-normal')); ?>
															</div>
														<?php endforeach; ?>
													</div> <!-- end of .row -->
												</div> <!-- end of .container-fluid -->
											</div>
										</div>
									</div> <!-- end of .card -->
								</div>
							</div> <!-- end of .row -->

							<div class="row justify-content-center">
								<div class="col-1 text-center">
									<?php echo form_button(array(
										'name'		=> 'btn_back',
										'content'	=> '戻る',
										'class'		=> 'btn btn-light btn-lg note-btn',
										'onclick'	=> 'location.href=\'' . site_url('admin/product') . '\''
									)); ?>
								</div>

								<div class="col-1 text-center">
									<?php echo form_submit(array(
										'name'		=> 'btn_submit',
										'value'		=> '確認',
										'class'		=> 'btn btn-primary btn-lg note-btn'
									)); ?>
								</div>
							</div> <!-- end of .row -->
						<?php echo form_close(); ?>
					</div> <!-- end of .section-body -->
				</section>
			</div> <!-- end of .main-content -->

			<?php $this->load->view('inc/admin/footer'); ?>
		</div> <!-- end of .main-wrapper -->
	</div> <!-- end of #app -->

	<?php $this->load->view('inc/admin/_foot'); ?>
</body>
</html>
