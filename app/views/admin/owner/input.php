<?php $this->load->view('inc/admin/_head', array('TITLE' => 'オーナー管理 | ' . SITE_NAME)); ?>

<body>
	<div id="app">
		<div class="main-wrapper main-wrapper-1">
			<?php $this->load->view('inc/admin/header'); ?>
			<?php $this->load->view('inc/admin/sidebar', array('current' => 'owner')); ?>

			<div class="main-content">
				<section class="section">
					<div class="section-header">
						<h1>オーナー管理 <?= $KIND == 'add' ? '新規追加' : '修正' ?></h1>
					</div>

					<div class="section-body">
						<?php echo form_open('admin/owner/confirm'); ?>
							<?php echo form_hidden('kind', $KIND) ?>
							<?php echo form_hidden('owner_id', $OID) ?>

							<div class="row">
								<div class="col-4">
									<div class="card card-primary">
										<div class="card-header">
											オーナー情報
										</div>
										<div class="card-body">
											<div class="form-group">
												<?php echo form_label('オーナー名', '', array('class' => 'required-label')); ?>
												<?php echo form_input(array(
													'name'	=> 'owner_name',
													'value'	=> set_value('owner_name', ( isset($ODATA['owner_name']) ? $ODATA['owner_name'] : '' )),
													'class'	=> 'form-control'
												)); ?>
												<?php echo form_error('owner_name'); ?>
											</div>

											<div class="form-group">
												<?php echo form_label('法人名'); ?>
												<?php echo form_input(array(
													'name'	=> 'corpo_name',
													'value'	=> set_value('corpo_name', ( isset($ODATA['corpo_name']) ? $ODATA['corpo_name'] : '' )),
													'class'	=> 'form-control'
												)); ?>
												<?php echo form_error('corpo_name'); ?>
											</div>

											<div class="form-group">
												<?php echo form_label('郵便番号', '', array('class' => 'required-label d-block')); ?>
												<?php echo form_input(array(
													'name'	=> 'zip1',
													'id'	=> 'zip1',
													'value'	=> set_value('zip1', ( isset($ODATA['zip1']) ? $ODATA['zip1'] : '' )),
													'class'	=> 'form-control d-inline-block mw-100'
												)); ?>-
												<?php echo form_input(array(
													'name'	=> 'zip2',
													'id'	=> 'zip2',
													'value'	=> set_value('zip2', ( isset($ODATA['zip2']) ? $ODATA['zip2'] : '' )),
													'class'	=> 'form-control d-inline-block mw-100'
												)); ?>
												<?php echo form_error('zip1'); ?>
											</div>

											<div class="form-group">
												<?php echo form_label('都道府県', '', array('class' => 'required-label')); ?>
												<?php echo form_dropdown('pref', $CONF['pref'], set_value('pref', ( isset($ODATA['pref']) ? $ODATA['pref'] : '' )), 'class="form-control"'); ?>
											</div>

											<div class="form-group">
												<?php echo form_label('住所', '', array('class' => 'required-label')); ?>
												<?php echo form_input(array(
													'name'	=> 'addr1',
													'value'	=> set_value('addr1', ( isset($ODATA['addr1']) ? $ODATA['addr1'] : '' )),
													'class'	=> 'form-control'
												)); ?><br>
												<?php echo form_input(array(
													'name'	=> 'addr2',
													'value'	=> set_value('addr2', ( isset($ODATA['addr2']) ? $ODATA['addr2'] : '' )),
													'class'	=> 'form-control'
												)); ?>
												<?php echo form_error('pref'); ?>
											</div>

											<div class="form-group">
												<?php echo form_label('電話番号', '', array('class' => 'required-label d-block')); ?>
												<?php echo form_input(array(
													'name'	=> 'tel1',
													'id'	=> 'tel1',
													'value'	=> set_value('tel1', ( isset($ODATA['tel1']) ? $ODATA['tel1'] : '' )),
													'class'	=> 'form-control d-inline-block mw-100'
												)); ?>-
												<?php echo form_input(array(
													'name'	=> 'tel2',
													'id'	=> 'tel2',
													'value'	=> set_value('tel2', ( isset($ODATA['tel2']) ? $ODATA['tel2'] : '' )),
													'class'	=> 'form-control d-inline-block mw-100'
												)); ?>-
												<?php echo form_input(array(
													'name'	=> 'tel3',
													'id'	=> 'tel3',
													'value'	=> set_value('tel3', ( isset($ODATA['tel3']) ? $ODATA['tel3'] : '' )),
													'class'	=> 'form-control d-inline-block mw-100'
												)); ?>
												<?php echo form_error('tel1'); ?>
											</div>

											<div class="form-group">
												<?php echo form_label('FAX番号', '', array('class' => 'd-block')); ?>
												<?php echo form_input(array(
													'name'	=> 'fax1',
													'id'	=> 'fax1',
													'value'	=> set_value('fax1', ( isset($ODATA['fax1']) ? $ODATA['fax1'] : '' )),
													'class'	=> 'form-control d-inline-block mw-100'
												)); ?>-
												<?php echo form_input(array(
													'name'	=> 'fax2',
													'id'	=> 'fax2',
													'value'	=> set_value('fax2', ( isset($ODATA['fax2']) ? $ODATA['fax2'] : '' )),
													'class'	=> 'form-control d-inline-block mw-100'
												)); ?>-
												<?php echo form_input(array(
													'name'	=> 'fax3',
													'id'	=> 'fax3',
													'value'	=> set_value('fax3', ( isset($ODATA['fax3']) ? $ODATA['fax3'] : '' )),
													'class'	=> 'form-control d-inline-block mw-100'
												)); ?>
												<?php echo form_error('fax1'); ?>
											</div>

											<div class="form-group">
												<?php echo form_label('メールアドレス', '', array('class' => 'required-label')); ?>
												<?php echo form_input(array(
													'name'	=> 'email',
													'value'	=> set_value('email', ( isset($ODATA['email']) ? $ODATA['email'] : '' )),
													'class'	=> 'form-control'
												)); ?>
												<?php echo form_error('email'); ?>
											</div>

											<div class="form-group">
												<?php echo form_label('お支払方法', '', array('class' => 'required-label d-block')); ?>

												<?php echo form_checkbox(array(
													'name'	=> 'payment_method1',
													'id'	=> 'payment_method1',
													'value'	=> '1',
													'checked'	=> set_checkbox('payment_method1', '1', ( isset($ODATA['payment_method1']) && $ODATA['payment_method1'] == '1' ? TRUE : FALSE ))
												)); ?>
												<?php echo form_label('買掛', 'payment_method1', array('class' => 'font-weight-normal')); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

												<?php echo form_checkbox(array(
													'name'	=> 'payment_method2',
													'id'	=> 'payment_method2',
													'value'	=> '1',
													'checked'	=> set_checkbox('payment_method2', '1', ( isset($ODATA['payment_method2']) && $ODATA['payment_method2'] == '1' ? TRUE : FALSE ))
												)); ?>
												<?php echo form_label('クレジットカード', 'payment_method2', array('class' => 'font-weight-normal')); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

												<?php echo form_checkbox(array(
													'name'	=> 'payment_method3',
													'id'	=> 'payment_method3',
													'value'	=> '1',
													'checked'	=> set_checkbox('payment_method3', '1', ( isset($ODATA['payment_method3']) && $ODATA['payment_method3'] == '1' ? TRUE : FALSE ))
												)); ?>
												<?php echo form_label('代金引換', 'payment_method3', array('class' => 'font-weight-normal')); ?>

												<?php echo form_error('payment_method1'); ?>
											</div>
										</div>
									</div> <!-- end of .card -->
								</div>

								<div class="col-4" id="account_box" style="display:none;">
									<div class="card card-primary">
										<div class="card-header">
											買掛情報
										</div>
										<div class="card-body">
											<div class="form-group">
												<?php echo form_label('事業形態', '', array('class' => 'required-label d-block')); ?>

												<?php echo form_radio(array(
													'name'	=> 'corporation',
													'id'	=> 'corporation1',
													'value'	=> '1',
													'checked'	=> set_radio('corporation', '1', ( isset($ADATA['corporation']) && $ADATA['corporation'] == '1' ? TRUE : FALSE ))
												)); ?>
												<?php echo form_label('法人', 'corporation1', array('class' => 'font-weight-normal')); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

												<?php echo form_radio(array(
													'name'	=> 'corporation',
													'id'	=> 'corporation2',
													'value'	=> '2',
													'checked'	=> set_radio('corporation', '2', ( isset($ADATA['corporation']) && $ADATA['corporation'] == '2' ? TRUE : FALSE ))
												)); ?>
												<?php echo form_label('非法人', 'corporation2', array('class' => 'font-weight-normal')); ?>

												<?php echo form_error('corporation'); ?>
											</div>

											<section id="corporation_detail" style="display:none;">
												<div class="form-group">
													<?php echo form_label('法人名', '', array('class' => 'required-label', 'id' => 'cd_corporation_name')); ?>
													<?php echo form_input(array(
														'name'	=> 'account_corpo_name',
														'value'	=> set_value('account_corpo_name', ( isset($ADATA['corpo_name']) ? $ADATA['corpo_name'] : '' )),
														'class'	=> 'form-control'
													)); ?>
													<?php echo form_error('account_corpo_name'); ?>
												</div>

												<div class="form-group" id="executive_box">
													<?php echo form_label('代表者名', '', array('class' => 'required-label')); ?>
													<?php echo form_input(array(
														'name'	=> 'account_executive',
														'value'	=> set_value('account_executive', ( isset($ADATA['executive']) ? $ADATA['executive'] : '' )),
														'class'	=> 'form-control'
													)); ?>
													<?php echo form_error('account_executive'); ?>
												</div>

												<div class="form-group">
													<?php echo form_label('法人郵便番号', '', array('class' => 'required-label d-block', 'id' => 'cd_zip')); ?>
													<?php echo form_input(array(
														'name'	=> 'account_zip1',
														'id'	=> 'account_zip1',
														'value'	=> set_value('account_zip1', ( isset($ADATA['zip1']) ? $ADATA['zip1'] : '' )),
														'class'	=> 'form-control d-inline-block mw-100'
													)); ?>-
													<?php echo form_input(array(
														'name'	=> 'account_zip2',
														'id'	=> 'account_zip2',
														'value'	=> set_value('account_zip2', ( isset($ADATA['zip2']) ? $ADATA['zip2'] : '' )),
														'class'	=> 'form-control d-inline-block mw-100'
													)); ?>
													<?php echo form_error('account_zip1'); ?>
												</div>

												<div class="form-group">
													<?php echo form_label('法人都道府県', '', array('class' => 'required-label', 'id' => 'cd_pref')); ?>
													<?php echo form_dropdown('account_pref', $CONF['pref'], set_value('account_pref', ( isset($ADATA['pref']) ? $ADATA['pref'] : '' )), 'class="form-control"'); ?>
												</div>

												<div class="form-group">
													<?php echo form_label('法人住所', '', array('class' => 'required-label', 'id' => 'cd_address')); ?>
													<?php echo form_input(array(
														'name'	=> 'account_addr1',
														'value'	=> set_value('account_addr1', ( isset($ADATA['addr1']) ? $ADATA['addr1'] : '' )),
														'class'	=> 'form-control'
													)); ?><br>
													<?php echo form_input(array(
														'name'	=> 'account_addr2',
														'value'	=> set_value('account_addr2', ( isset($ADATA['addr2']) ? $ADATA['addr2'] : '' )),
														'class'	=> 'form-control'
													)); ?>
													<?php echo form_error('account_pref'); ?>
												</div>

												<div class="form-group">
													<?php echo form_label('代表電話番号', '', array('class' => 'required-label d-block', 'id' => 'cd_tel')); ?>
													<?php echo form_input(array(
														'name'	=> 'account_tel1',
														'id'	=> 'account_tel1',
														'value'	=> set_value('account_tel1', ( isset($ADATA['tel1']) ? $ADATA['tel1'] : '' )),
														'class'	=> 'form-control d-inline-block mw-100'
													)); ?>-
													<?php echo form_input(array(
														'name'	=> 'account_tel2',
														'id'	=> 'account_tel2',
														'value'	=> set_value('account_tel2', ( isset($ADATA['tel2']) ? $ADATA['tel2'] : '' )),
														'class'	=> 'form-control d-inline-block mw-100'
													)); ?>-
													<?php echo form_input(array(
														'name'	=> 'account_tel3',
														'id'	=> 'account_tel3',
														'value'	=> set_value('account_tel3', ( isset($ADATA['tel3']) ? $ADATA['tel3'] : '' )),
														'class'	=> 'form-control d-inline-block mw-100'
													)); ?>
													<?php echo form_error('account_tel1'); ?>
												</div>

												<div class="form-group">
													<?php echo form_label('FAX番号', '', array('class' => 'd-block')); ?>
													<?php echo form_input(array(
														'name'	=> 'account_fax1',
														'id'	=> 'account_fax1',
														'value'	=> set_value('account_fax1', ( isset($ADATA['fax1']) ? $ADATA['fax1'] : '' )),
														'class'	=> 'form-control d-inline-block mw-100'
													)); ?>-
													<?php echo form_input(array(
														'name'	=> 'account_fax2',
														'id'	=> 'account_fax2',
														'value'	=> set_value('account_fax2', ( isset($ADATA['fax2']) ? $ADATA['fax2'] : '' )),
														'class'	=> 'form-control d-inline-block mw-100'
													)); ?>-
													<?php echo form_input(array(
														'name'	=> 'account_fax3',
														'id'	=> 'account_fax3',
														'value'	=> set_value('account_fax3', ( isset($ADATA['fax3']) ? $ADATA['fax3'] : '' )),
														'class'	=> 'form-control d-inline-block mw-100'
													)); ?>
												</div>

												<div class="form-group">
													<?php echo form_label('ご請求先', '', array('class' => 'required-label d-block')); ?>

													<?php echo form_radio(array(
														'name'	=> 'bill_to',
														'id'	=> 'bill_to1',
														'value'	=> '1',
														'checked'	=> set_radio('bill_to', '1', ( isset($ADATA['bill_to']) && $ADATA['bill_to'] == '1' ? TRUE : FALSE ))
													)); ?>
													<?php echo form_label('上記と同じ', 'bill_to1', array('class' => 'font-weight-normal')); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

													<?php echo form_radio(array(
														'name'	=> 'bill_to',
														'id'	=> 'bill_to2',
														'value'	=> '2',
														'checked'	=> set_radio('bill_to', '2', ( isset($ADATA['bill_to']) && $ADATA['bill_to'] == '2' ? TRUE : FALSE ))
													)); ?>
													<?php echo form_label('上記とは別', 'bill_to2', array('class' => 'font-weight-normal')); ?>

													<?php echo form_error('bill_to'); ?>
												</div>

												<div id="bill-other" style="display:none;" ?>
													<div class="form-group">
														<?php echo form_label('ご請求先名', '', array('class' => 'required-label')); ?>
														<?php echo form_input(array(
															'name'	=> 'bill_name',
															'value'	=> set_value('bill_name', ( isset($ADATA['bill_name']) ? $ADATA['bill_name'] : '' )),
															'class'	=> 'form-control'
														)); ?>
														<?php echo form_error('bill_name'); ?>
													</div>

													<div class="form-group">
														<?php echo form_label('ご請求先郵便番号', '', array('class' => 'required-label d-block')); ?>
														<?php echo form_input(array(
															'name'	=> 'bill_zip1',
															'id'	=> 'bill_zip1',
															'value'	=> set_value('bill_zip1', ( isset($ADATA['bill_zip1']) ? $ADATA['bill_zip1'] : '' )),
															'class'	=> 'form-control d-inline-block mw-100'
														)); ?>-
														<?php echo form_input(array(
															'name'	=> 'bill_zip2',
															'id'	=> 'bill_zip2',
															'value'	=> set_value('bill_zip2', ( isset($ADATA['bill_zip2']) ? $ADATA['bill_zip2'] : '' )),
															'class'	=> 'form-control d-inline-block mw-100'
														)); ?>
														<?php echo form_error('bill_zip1'); ?>
													</div>

													<div class="form-group">
														<?php echo form_label('ご請求先都道府県', '', array('class' => 'required-label')); ?>
														<?php echo form_dropdown('bill_pref', $CONF['pref'], set_value('bill_pref', ( isset($ADATA['bill_pref']) ? $ADATA['bill_pref'] : '' )), 'class="form-control"'); ?>
													</div>

													<div class="form-group">
														<?php echo form_label('ご請求先住所', '', array('class' => 'required-label')); ?>
														<?php echo form_input(array(
															'name'	=> 'bill_addr1',
															'value'	=> set_value('bill_addr1', ( isset($ADATA['bill_addr1']) ? $ADATA['bill_addr1'] : '' )),
															'class'	=> 'form-control'
														)); ?><br>
														<?php echo form_input(array(
															'name'	=> 'bill_addr2',
															'value'	=> set_value('bill_addr2', ( isset($ADATA['bill_addr2']) ? $ADATA['bill_addr2'] : '' )),
															'class'	=> 'form-control'
														)); ?>
														<?php echo form_error('bill_pref'); ?>
													</div>

													<div class="form-group">
														<?php echo form_label('ご請求先電話番号', '', array('class' => 'required-label d-block', 'id' => 'cd_tel')); ?>
														<?php echo form_input(array(
															'name'	=> 'bill_tel1',
															'id'	=> 'bill_tel1',
															'value'	=> set_value('bill_tel1', ( isset($ADATA['bill_tel1']) ? $ADATA['bill_tel1'] : '' )),
															'class'	=> 'form-control d-inline-block mw-100'
														)); ?>-
														<?php echo form_input(array(
															'name'	=> 'bill_tel2',
															'id'	=> 'bill_tel2',
															'value'	=> set_value('bill_tel2', ( isset($ADATA['bill_tel2']) ? $ADATA['bill_tel2'] : '' )),
															'class'	=> 'form-control d-inline-block mw-100'
														)); ?>-
														<?php echo form_input(array(
															'name'	=> 'bill_tel3',
															'id'	=> 'bill_tel3',
															'value'	=> set_value('bill_tel3', ( isset($ADATA['bill_tel3']) ? $ADATA['bill_tel3'] : '' )),
															'class'	=> 'form-control d-inline-block mw-100'
														)); ?>
														<?php echo form_error('bill_tel1'); ?>
													</div>
												</div> <!-- end of #bill-other -->

												<div class="form-group">
													<?php echo form_label('決済方法', '', array('class' => 'required-label d-block')); ?>

													<?php echo form_radio(array(
														'name'	=> 'settlement_method',
														'id'	=> 'settlement_method1',
														'value'	=> '1',
														'checked'	=> set_radio('settlement_method', '1', ( isset($ADATA['settlement_method']) && $ADATA['settlement_method'] == '1' ? TRUE : FALSE ))
													)); ?>
													<?php echo form_label('振込', 'settlement_method1', array('class' => 'font-weight-normal')); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

													<?php echo form_radio(array(
														'name'	=> 'settlement_method',
														'id'	=> 'settlement_method2',
														'value'	=> '2',
														'checked'	=> set_radio('settlement_method', '2', ( isset($ADATA['settlement_method']) && $ADATA['settlement_method'] == '2' ? TRUE : FALSE ))
													)); ?>
													<?php echo form_label('口座引落', 'settlement_method2', array('class' => 'font-weight-normal')); ?>

													<?php echo form_error('settlement_method'); ?>
												</div>

												<div class="form-group row" id="transfer" style="display:none;">
													<div class="form-group">
														<?php echo form_label('振込み名義', '', array('class' => 'required-label')); ?>
														<?php echo form_input(array(
															'name'	=> 'transfer_name',
															'value'	=> set_value('transfer_name', ( isset($ADATA['transfer_name']) ? $ADATA['transfer_name'] : '' )),
															'class'	=> 'form-control'
														)); ?>
														<?php echo form_error('transfer_name'); ?>
													</div>
												</div> <!-- end of .#transfer -->

												<div class="form-group row" id="debit" style="display:none;">
													<div class="form-group">
														<?php echo form_label('金融機関名', '', array('class' => 'required-label')); ?>
														<?php echo form_input(array(
															'name'	=> 'bank_name',
															'value'	=> set_value('bank_name', ( isset($ADATA['bank_name']) ? $ADATA['bank_name'] : '' )),
															'class'	=> 'form-control'
														)); ?>
														<?php echo form_error('bank_name'); ?>
													</div>
												<!-- end of #debit -->
											</section>
										</div>
									</div> <!-- end of .card -->
								</div>

								<div class="col-4">
									<div class="card card-primary">
										<div class="card-header">
											運営教室
										</div>
										<div class="card-body">
											<a href="#modal_classroom" data-toggle="modal" class="btn btn-sm btn-primary">
												<i class="fas fa-plus"></i>&nbsp;追加
											</a>

											<ul class="classroom-list" id="classroom_list">
												<?php if( !empty($CDATA) ): ?>
													<?php foreach( $CDATA as $classroom ): ?>
														<?php echo form_input(array(
															'type'		=> 'hidden',
															'name'		=> 'classroom_ids[]',
															'id'		=> 'hidden_' . $classroom['classroom_id'],
															'value'		=> $classroom['classroom_id']
														)); ?>

														<li id="li_<?= $classroom['classroom_id'] ?>">
															<?= $classroom['name'] ?>

															<?php echo form_button(array(
																'name'		=> 'btn_remove_classroom',
																'content'	=> '<i class="fas fa-minus"></i>&nbsp;削除',
																'class'		=> 'btn btn-sm btn-warning',
																'onclick'	=> 'remove_classroom(\'' . $classroom['classroom_id'] . '\')'
															)); ?>
														</li>
													<?php endforeach; ?>
												<?php endif; ?>
											</ul>

											<?php echo form_error('classroom_ids[]'); ?>
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
										'onclick'	=> 'location.href=\'' . site_url('admin/owner') . '\''
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

	<?php /* ダイアログ */ ?>
	<div class="modal" id="modal_classroom" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true" data-show="true" data-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">運営教室の追加</h4>
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&#215;</span><span class="sr-only">閉じる</span>
					</button>
				</div><!-- /modal-header -->

				<div class="modal-body">
					<div class="row">
						<div class="col-sm-3">教室名で検索</div>
						<div class="col-sm-7">
							<?php echo form_input(array(
								'name'		=> 'cond_classroom',
								'id'		=> 'cond_classroom',
								'value'		=> '',
								'maxlength'	=> 255,
								'style'		=> 'width:100%;'
							)); ?>
						</div>
						<div class="col-sm-2">
							<?php echo form_button(array(
								'name'		=> 'btn_search',
								'content'	=> '検索',
								'class'		=> 'btn btn-sm btn-info',
								'onclick'	=> 'search_classroom();'
							)); ?>
						</div>
					</div><br>

					<div class="row">
						<div class="col-sm-3">教室名</div>
						<div class="col-sm-9">
							<?php echo form_dropdown('select_classroom', array('' => '選択してください'), '', 'id="select_classroom"'); ?><br>
							※オーナーに紐づけられていない教室のみ表示されます。
						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
					<button type="button" class="btn btn-primary" onclick="do_submit();">追加</button>
				</div>
			</div> <!-- /.modal-content -->
		</div> <!-- /.modal-dialog -->
	</div> <!-- /.modal -->

	<?php $this->load->view('inc/admin/_foot'); ?>

	<script src="//ajaxzip3.github.io/ajaxzip3.js"></script>
	<script src="<?= base_url('js/admin/owner_input.js')?>?var=<?= CACHES_CLEAR_VERSION ?>"></script>
</body>
</html>
