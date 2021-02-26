<?php $this->load->view('inc/admin/_head', array('TITLE' => '教室管理 | ' . SITE_NAME)); ?>

<body>
	<div id="app">
		<div class="main-wrapper main-wrapper-1">
			<?php $this->load->view('inc/admin/header'); ?>
			<?php $this->load->view('inc/admin/sidebar', array('current' => 'classroom')); ?>

			<div class="main-content">
				<section class="section">
					<div class="section-header">
						<h1>教室管理 <?= $KIND == 'add' ? '新規追加' : '修正' ?></h1>
					</div>

					<div class="section-body">
						<?php echo form_open('admin/classroom/confirm'); ?>
							<?php echo form_hidden('kind', $KIND) ?>
							<?php echo form_hidden('classroom_id', $CID) ?>

							<div class="row">
								<div class="col-4">
									<div class="card card-primary">
										<div class="card-header">
											<h4>基本情報</h4>
										</div>
										<div class="card-body">
											<div class="form-group">
												<?php echo form_label('教室名', '', array('class' => 'required-label')); ?>
												<?php echo form_input(array(
													'name'	=> 'name',
													'value'	=> set_value('name', ( isset($CDATA['name']) ? $CDATA['name'] : '' )),
													'class'	=> 'form-control'
												)); ?>
												<?php echo form_error('name'); ?>
											</div>

											<div class="form-group">
												<?php echo form_label('郵便番号', ''); ?>
												<?php echo form_input(array(
													'name'	=> 'zip',
													'id'	=> 'zip',
													'value'	=> set_value('zip', ( isset($CDATA['zip']) ? $CDATA['zip'] : '' )),
													'class'	=> 'form-control'
												)); ?>
											</div>

											<div class="form-group">
												<?php echo form_label('都道府県', '', array('class' => 'required-label')); ?>
												<?php echo form_dropdown('pref', $CONF['pref'], set_value('pref', ( isset($CDATA['pref']) ? $CDATA['pref'] : '' )), 'class="form-control"'); ?>
												<?php echo form_error('pref'); ?>
											</div>

											<div class="form-group">
												<?php echo form_label('住所', ''); ?>
												<?php echo form_input(array(
													'name'	=> 'address',
													'value'	=> set_value('address', ( isset($CDATA['address']) ? $CDATA['address'] : '' )),
													'class'	=> 'form-control'
												)); ?>
											</div>

											<div class="form-group">
												<?php echo form_label('電話番号', ''); ?>
												<?php echo form_input(array(
													'name'	=> 'tel',
													'id'	=> 'tel',
													'value'	=> set_value('tel', ( isset($CDATA['tel']) ? $CDATA['tel'] : '' )),
													'class'	=> 'form-control'
												)); ?>
											</div>

											<div class="form-group">
												<?php echo form_label('メールアドレス', ''); ?>
												<?php echo form_input(array(
													'name'	=> 'email',
													'id'	=> 'email',
													'value'	=> set_value('email', ( isset($CDATA['email']) ? $CDATA['email'] : '' )),
													'class'	=> 'form-control'
												)); ?>
											</div>

											<div class="form-group">
												<?php echo form_label('パスワード', ''); ?>
												<?php echo form_input(array(
													'name'	=> 'password',
													'id'	=> 'password',
													'value'	=> set_value('password', ''),
													'class'	=> 'form-control'
												)); ?>
												<?php if( $KIND == 'modify' ): ?>
													<span class="text-danger">※パスワードは変更する場合のみ入力してください。</span>
												<?php endif; ?>
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
											<?php if( $KIND == 'modify' ): ?>
												<div class="form-group">
													<?php echo form_label('オーナー', ''); ?>
													<?php echo form_input(array(
														'name'	=> 'owner',
														'value'	=> $OWNER,
														'class'	=> 'form-control',
														'disabled'	=> TRUE
													)); ?>
													<span class="text-danger">※オーナー情報は変更できません。<a href="<?= site_url('admin/owner') ?>">オーナー管理</a>からお願いします。</span>
												</div>
											<?php endif; ?>

											<div class="form-group">
												<?php echo form_label('教室番号（明光側コード）', '', array('class' => 'required-label')); ?>
												<?php echo form_input(array(
													'name'	=> 'classroom_number',
													'value'	=> set_value('classroom_number', ( isset($CDATA['classroom_number']) ? $CDATA['classroom_number'] : '' )),
													'class'	=> 'form-control'
												)); ?>
												<?php echo form_error('classroom_number'); ?>
											</div>

											<div class="form-group">
												<?php echo form_label('SMILEコード（掛）', ''); ?>
												<?php echo form_input(array(
													'name'	=> 'smile_code1',
													'id'	=> 'smile_code1',
													'value'	=> set_value('smile_code1', ( isset($CDATA['smile_code1']) ? $CDATA['smile_code1'] : '' )),
													'class'	=> 'form-control'
												)); ?>
											</div>

											<div class="form-group">
												<?php echo form_label('SMILEコード（クレジット）', ''); ?>
												<?php echo form_input(array(
													'name'	=> 'smile_code2',
													'id'	=> 'smile_code2',
													'value'	=> set_value('smile_code2', ( isset($CDATA['smile_code2']) ? $CDATA['smile_code2'] : '' )),
													'class'	=> 'form-control'
												)); ?>
											</div>

											<div class="form-group">
												<?php echo form_label('SMILEコード（代引）', ''); ?>
												<?php echo form_input(array(
													'name'	=> 'smile_code3',
													'id'	=> 'smile_code3',
													'value'	=> set_value('smile_code3', ( isset($CDATA['smile_code3']) ? $CDATA['smile_code3'] : '' )),
													'class'	=> 'form-control'
												)); ?>
											</div>

											<div class="form-group">
												<?php echo form_label('ENコード（掛）', '', array('class' => 'd-block')); ?>

												<?php echo form_radio(array(
													'name'	=> 'en_code1',
													'id'	=> 'en_code1_1',
													'value'	=> '1',
													'checked'	=> set_radio('en_code1', '1', ( isset($CDATA['en_code1']) && $CDATA['en_code1'] == '1' ? TRUE : FALSE ))
												)); ?>
												<?php echo form_label('有', 'en_code1_1', array('class' => 'font-weight-normal')); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

												<?php echo form_radio(array(
													'name'	=> 'en_code1',
													'id'	=> 'en_code1_2',
													'value'	=> '2',
													'checked'	=> set_radio('en_code1', '2', ( isset($CDATA['en_code1']) && $CDATA['en_code1'] == '2' ? TRUE : FALSE ))
												)); ?>
												<?php echo form_label('無', 'en_code1_2', array('class' => 'font-weight-normal')); ?>
											</div>

											<div class="form-group">
												<?php echo form_label('ENコード（クレジット）', '', array('class' => 'd-block')); ?>

												<?php echo form_radio(array(
													'name'	=> 'en_code2',
													'id'	=> 'en_code2_1',
													'value'	=> '1',
													'checked'	=> set_radio('en_code2', '1', ( isset($CDATA['en_code2']) && $CDATA['en_code2'] == '1' ? TRUE : FALSE ))
												)); ?>
												<?php echo form_label('有', 'en_code2_1', array('class' => 'font-weight-normal')); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

												<?php echo form_radio(array(
													'name'	=> 'en_code2',
													'id'	=> 'en_code2_2',
													'value'	=> '2',
													'checked'	=> set_radio('en_code2', '2', ( isset($CDATA['en_code2']) && $CDATA['en_code2'] == '2' ? TRUE : FALSE ))
												)); ?>
												<?php echo form_label('無', 'en_code2_2', array('class' => 'font-weight-normal')); ?>
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
										'onclick'	=> 'location.href=\'' . site_url('admin/classroom') . '\''
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

	<script src="//ajaxzip3.github.io/ajaxzip3.js"></script>
	<script src="<?= base_url('js/admin/classroom_input.js')?>?var=<?= CACHES_CLEAR_VERSION ?>"></script>
</body>
</html>
