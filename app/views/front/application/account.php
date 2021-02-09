<?php $this->load->view('inc/_head', array('TITLE' => SITE_NAME)); ?>

<body>
	<div id="wrapper">
		<?php $this->load->view('inc/header', array('MENU' => FALSE)); ?>

		<div class="container">
			<p class="lead-title">掛け取り引き申請</p>

			<?php if( empty($OID) ): ?>
				掛け取り引き申請はご利用申込みの際、お支払方法で【掛け】を選ばれた方のみ行えます。
			<?php else: ?>
				<?php echo form_open('application/account_confirm'); ?>
					<?php echo form_hidden('owner_id', $OID); ?>

					<div class="form-group row">
						<div class="col-md-2 offset-md-3 entry-required">事業形態</div>
						<div class="col-md-4">
							<?php echo form_radio(array(
								'name'	=> 'corporation',
								'id'	=> 'corporation1',
								'value'	=> '1',
								'checked'	=> set_radio('corporation', '1', FALSE)
							)); ?>
							<?php echo form_label('法人', 'corporation1'); ?>&nbsp;&nbsp;&nbsp;

							<?php echo form_radio(array(
								'name'	=> 'corporation',
								'id'	=> 'corporation2',
								'value'	=> '2',
								'checked'	=> set_radio('corporation', '2', FALSE)
							)); ?>
							<?php echo form_label('非法人', 'corporation2'); ?>
						</div>
					</div> <!-- end of .form-group row -->

					<section id="corporation_detail" style="display:none;">
						<div class="text-center my-5">
							<?php echo form_button(array(
								'name'		=> 'btn_load_info',
								'content'	=> 'ご利用申込みの際に登録したデータを使用する',
								'class'		=> 'btn btn-outline-primary',
								'onclick'	=> 'get_owner_data(\'' . $OID . '\');'
							)); ?>
						</div>
						<div class="form-group row">
							<div class="col-md-2 offset-md-3 entry-required" id="cd_corporation_name">法人名</div>
							<div class="col-md-4">
								<?php echo form_input(array(
									'name'	=> 'corpo_name',
									'id'	=> 'corpo_name',
									'value'	=> set_value('corpo_name', ''),
									'class'	=> 'form-control entry-input',
									'placeholder'	=> '中央教育研究所株式会社'
								)); ?>
								<?php echo form_error('corpo_name'); ?>
							</div>
						</div> <!-- end of .form-group row -->

						<div class="form-group row" id="executive_box">
							<div class="col-md-2 offset-md-3 entry-required">代表者名</div>
							<div class="col-md-4">
								<?php echo form_input(array(
									'name'	=> 'executive',
									'id'	=> 'executive',
									'value'	=> set_value('executive', ''),
									'class'	=> 'form-control entry-input',
									'placeholder'	=> '山田 太郎'
								)); ?>
								<?php echo form_error('executive'); ?>
							</div>
						</div> <!-- end of .form-group row -->

						<div class="form-group row">
							<div class="col-md-2 offset-md-3 entry-required" id="cd_zip">法人郵便番号</div>
							<div class="col-md-4">
								<?php echo form_input(array(
									'name'	=> 'zip1',
									'id'	=> 'zip1',
									'value'	=> set_value('zip1', ''),
									'class'	=> 'form-control entry-input entry-input-small',
									'placeholder'	=> '730'
								)); ?>&nbsp;-&nbsp;
								<?php echo form_input(array(
									'name'	=> 'zip2',
									'id'	=> 'zip2',
									'value'	=> set_value('zip2', ''),
									'class'	=> 'form-control entry-input entry-input-small',
									'placeholder'	=> '0013'
								)); ?>
								<?php echo form_error('zip1'); ?>
							</div>
						</div> <!-- end of .form-group row -->

						<div class="form-group row">
							<div class="col-md-2 offset-md-3 entry-required" id="cd_address">法人住所</div>
							<div class="col-md-4">
								<div class="container-fluid">
									<div class="form-group row">
										<?php echo form_dropdown('pref', $CONF['pref'], set_value('pref', ''), 'id="pref" class="form-control entry-input"'); ?>
									</div> <!-- end of .form-group row -->

									<div class="form-group row">
										<?php echo form_input(array(
											'name'	=> 'addr1',
											'id'	=> 'addr1',
											'value'	=> set_value('addr1', ''),
											'class'	=> 'form-control entry-input',
											'placeholder'	=> '広島市中区八丁堀15-6'
										)); ?>
									</div> <!-- end of .form-group row -->

									<div class="form-group row">
										<?php echo form_input(array(
											'name'	=> 'addr2',
											'id'	=> 'addr2',
											'value'	=> set_value('addr2', ''),
											'class'	=> 'form-control entry-input',
											'placeholder'	=> '広島ちゅうぎんビル３階'
										)); ?>
									</div> <!-- end of .form-group row -->
								</div>
								<?php echo form_error('pref'); ?>
							</div>
						</div> <!-- end of .form-group row -->

						<div class="form-group row">
							<div class="col-md-2 offset-md-3 entry-required" id="cd_tel">代表電話番号</div>
							<div class="col-md-4">
								<?php echo form_input(array(
									'name'	=> 'tel1',
									'id'	=> 'tel1',
									'value'	=> set_value('tel1', ''),
									'class'	=> 'form-control entry-input entry-input-small',
									'placeholder'	=> '082'
								)); ?>&nbsp;-&nbsp;
								<?php echo form_input(array(
									'name'	=> 'tel2',
									'id'	=> 'tel2',
									'value'	=> set_value('tel2', ''),
									'class'	=> 'form-control entry-input entry-input-small',
									'placeholder'	=> '227'
								)); ?>&nbsp;-&nbsp;
								<?php echo form_input(array(
									'name'	=> 'tel3',
									'id'	=> 'tel3',
									'value'	=> set_value('tel3', ''),
									'class'	=> 'form-control entry-input entry-input-small',
									'placeholder'	=> '3999'
								)); ?>
								<?php echo form_error('tel1'); ?>
							</div>
						</div> <!-- end of .form-group row -->

						<div class="form-group row">
							<div class="col-md-2 offset-md-3">FAX番号</div>
							<div class="col-md-4">
								<?php echo form_input(array(
									'name'	=> 'fax1',
									'id'	=> 'fax1',
									'value'	=> set_value('fax1', ''),
									'class'	=> 'form-control entry-input entry-input-small',
									'placeholder'	=> '082'
								)); ?>&nbsp;-&nbsp;
								<?php echo form_input(array(
									'name'	=> 'fax2',
									'id'	=> 'fax2',
									'value'	=> set_value('fax2', ''),
									'class'	=> 'form-control entry-input entry-input-small',
									'placeholder'	=> '227'
								)); ?>&nbsp;-&nbsp;
								<?php echo form_input(array(
									'name'	=> 'fax3',
									'id'	=> 'fax3',
									'value'	=> set_value('fax3', ''),
									'class'	=> 'form-control entry-input entry-input-small',
									'placeholder'	=> '4000'
								)); ?>
							</div>
						</div> <!-- end of .form-group row -->

						<div class="form-group row">
							<div class="col-md-2 offset-md-3 entry-required">ご請求先</div>
							<div class="col-md-4">
								<?php echo form_radio(array(
									'name'	=> 'bill_to',
									'id'	=> 'bill_to1',
									'value'	=> '1',
									'checked'	=> set_radio('bill_to', '1', FALSE)
								)); ?>
								<?php echo form_label('上記と同じ', 'bill_to1'); ?><br>

								<?php echo form_radio(array(
									'name'	=> 'bill_to',
									'id'	=> 'bill_to2',
									'value'	=> '2',
									'checked'	=> set_radio('bill_to', '2', FALSE)
								)); ?>
								<?php echo form_label('上記とは別', 'bill_to2'); ?>
								<?php echo form_error('bill_to'); ?>
							</div>
						</div>

						<div id="bill-other" style="display:none;">
							<div class="form-group row">
								<div class="col-md-2 offset-md-3 entry-required">ご請求先名</div>
								<div class="col-md-4">
									<?php echo form_input(array(
										'name'	=> 'bill_name',
										'id'	=> 'bill_name',
										'value'	=> set_value('bill_name', ''),
										'class'	=> 'form-control entry-input',
										'placeholder'	=> '中央教育研究所株式会社 事業開発本部'
									)); ?>
									<?php echo form_error('bill_name'); ?>
								</div>
							</div> <!-- end of .form-group row -->

							<div class="form-group row">
								<div class="col-md-2 offset-md-3 entry-required">ご請求先郵便番号</div>
								<div class="col-md-4">
									<?php echo form_input(array(
										'name'	=> 'bill_zip1',
										'id'	=> 'bill_zip1',
										'value'	=> set_value('bill_zip1', ''),
										'class'	=> 'form-control entry-input entry-input-small',
										'placeholder'	=> '101'
									)); ?>&nbsp;-&nbsp;
									<?php echo form_input(array(
										'name'	=> 'bill_zip2',
										'id'	=> 'bill_zip2',
										'value'	=> set_value('bill_zip2', ''),
										'class'	=> 'form-control entry-input entry-input-small',
										'placeholder'	=> '0054'
									)); ?>
									<?php echo form_error('bill_zip1'); ?>
								</div>
							</div> <!-- end of .form-group row -->

							<div class="form-group row">
								<div class="col-md-2 offset-md-3 entry-required">ご請求先住所</div>
								<div class="col-md-4">
									<div class="container-fluid">
										<div class="form-group row">
											<?php echo form_dropdown('bill_pref', $CONF['pref'], set_value('bill_pref', ''), 'id="bill_pref" class="form-control entry-input"'); ?>
										</div> <!-- end of .form-group row -->

										<div class="form-group row">
											<?php echo form_input(array(
												'name'	=> 'bill_addr1',
												'id'	=> 'bill_addr1',
												'value'	=> set_value('bill_addr1', ''),
												'class'	=> 'form-control entry-input',
												'placeholder'	=> '千代田区神田錦町3丁目19-4'
											)); ?>
										</div> <!-- end of .form-group row -->

										<div class="form-group row">
											<?php echo form_input(array(
												'name'	=> 'bill_addr2',
												'id'	=> 'bill_addr2',
												'value'	=> set_value('bill_addr2', ''),
												'class'	=> 'form-control entry-input',
												'placeholder'	=> 'ACN神田錦町ビル5階'
											)); ?>
										</div> <!-- end of .form-group row -->
									</div>
									<?php echo form_error('bill_pref'); ?>
								</div>
							</div> <!-- end of .form-group row -->

							<div class="form-group row">
								<div class="col-md-2 offset-md-3 entry-required">ご請求先電話番号</div>
								<div class="col-md-4">
									<?php echo form_input(array(
										'name'	=> 'bill_tel1',
										'id'	=> 'bill_tel1',
										'value'	=> set_value('bill_tel1', ''),
										'class'	=> 'form-control entry-input entry-input-small',
										'placeholder'	=> '03'
									)); ?>&nbsp;-&nbsp;
									<?php echo form_input(array(
										'name'	=> 'bill_tel2',
										'id'	=> 'bill_tel2',
										'value'	=> set_value('bill_tel2', ''),
										'class'	=> 'form-control entry-input entry-input-small',
										'placeholder'	=> '5283'
									)); ?>&nbsp;-&nbsp;
									<?php echo form_input(array(
										'name'	=> 'bill_tel3',
										'id'	=> 'bill_tel3',
										'value'	=> set_value('bill_tel3', ''),
										'class'	=> 'form-control entry-input entry-input-small',
										'placeholder'	=> '5677'
									)); ?>
									<?php echo form_error('bill_tel1'); ?>
								</div>
							</div> <!-- end of .form-group row -->

							<div class="form-group row">
								<div class="col-md-2 offset-md-3">備考</div>
								<div class="col-md-4">
									<?php echo form_textarea(array(
										'name'	=> 'bill_note',
										'id'	=> 'bill_note',
										'value'	=> set_value('bill_note', ''),
										'class'	=> 'form-control entry-input',
										'placeholder'	=> '請求先が複数に分かれる等、上記内容では申請できない場合にご記入ください。'
									)); ?>
								</div>
							</div> <!-- end of .form-group row -->
						</div> <!-- end of #bill-other -->

						<div class="form-group row">
							<div class="col-md-2 offset-md-3 entry-required">決済方法</div>
							<div class="col-md-4">
								<?php echo form_radio(array(
									'name'	=> 'settlement_method',
									'id'	=> 'settlement_method1',
									'value'	=> '1',
									'checked'	=> set_radio('settlement_method', '1', FALSE)
								)); ?>
								<?php echo form_label('振込（月末締め、翌月２０日払い）', 'settlement_method1'); ?><br>

								<?php echo form_radio(array(
									'name'	=> 'settlement_method',
									'id'	=> 'settlement_method2',
									'value'	=> '2',
									'checked'	=> set_radio('settlement_method', '2', FALSE)
								)); ?>
								<?php echo form_label('口座引落（２０日締め、翌月１３日引落）', 'settlement_method2'); ?>
								<?php echo form_error('settlement_method'); ?>
							</div>
						</div> <!-- end of .form-group row -->

						<div class="form-group row" id="transfer" style="display:none;">
							<div class="col-md-2 offset-md-3 entry-required">お振込み名義</div>
							<div class="col-md-4">
								<?php echo form_input(array(
									'name'	=> 'transfer_name',
									'id'	=> 'transfer_name',
									'value'	=> set_value('transfer_name', ''),
									'class'	=> 'form-control entry-input',
									'placeholder'	=> '中央教育研究所株式会社'
								)); ?>
								<?php echo form_error('transfer_name'); ?>
							</div>
						</div> <!-- end of .form-group row -->

						<div class="form-group row" id="debit" style="display:none;">
							<div class="col-md-2 offset-md-3 entry-required">金融機関名</div>
							<div class="col-md-4">
								<?php echo form_input(array(
									'name'	=> 'bank_name',
									'id'	=> 'bank_name',
									'value'	=> set_value('bank_name', ''),
									'class'	=> 'form-control entry-input',
									'placeholder'	=> '東京中央銀行'
								)); ?>
								<?php echo form_error('bank_name'); ?>
								※ご指定の金融機関の口座引落に関する書類を送付させていただきます。<br>
								※手続き完了まで約１ヶ月かかります。その間はお振込みにてご対応をお願いいたします。
							</div>
						</div>

						<div id="btn_confirm" class="text-center my-5">
							<?php echo form_submit(array(
								'name'	=> 'btn_submit',
								'class'	=> 'btn btn-success',
								'value'	=> '　確認　'
							)); ?>
						</div>
					</section> <!-- end of #corporation_detail -->
				<?php echo form_close(); ?>
			<?php endif;?>
		</div> <!-- end of .container -->

		<?php $this->load->view('inc/_foot'); ?>
		<?php $this->load->view('inc/footer'); ?>
	</div> <!-- end of #wrapper -->

	<script src="//ajaxzip3.github.io/ajaxzip3.js"></script>
	<script src="<?= base_url('js/front.account.js') ?>?var=<?= CACHES_CLEAR_VERSION ?>"></script>
</body>
</html>
