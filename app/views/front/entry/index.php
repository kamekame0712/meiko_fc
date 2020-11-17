<?php $this->load->view('inc/_head', array('TITLE' => SITE_NAME)); ?>

<body>
	<div id="wrapper">
		<?php $this->load->view('inc/header', array('MENU' => TRUE)); ?>

		<div class="container">
			<p class="lead-title">お客様情報登録</p>

			<?php echo form_open('entry/confirm'); ?>
				<div class="col-md-8 offset-md-2">
					<p class="favor">１．お電話番号を入力してください。</p>
				</div>

				<div class="form-group row">
					<div class="col-md-2 offset-md-3">電話番号</div>
					<div class="col-3 col-md-1">
						<?php echo form_input(array(
							'name'	=> 'tel01',
							'id'	=> 'tel01',
							'value'	=> set_value('tel01', ''),
							'class'	=> 'form-control entry-input',
							'placeholder'	=> '082'
						)); ?>
					</div>－
					<div class="col-3 col-md-1">
						<?php echo form_input(array(
							'name'	=> 'tel02',
							'id'	=> 'tel02',
							'value'	=> set_value('tel02', ''),
							'class'	=> 'form-control entry-input',
							'placeholder'	=> '227'
						)); ?>
					</div>－
					<div class="col-3 col-md-1">
						<?php echo form_input(array(
							'name'	=> 'tel03',
							'id'	=> 'tel03',
							'value'	=> set_value('tel03', ''),
							'class'	=> 'form-control entry-input',
							'placeholder'	=> '3999'
						)); ?>
						<?php echo form_error('tel01'); ?>
					</div>
				</div> <!-- end of .form-group row -->

				<div id="required_item1" class="mt-5">
					<div class="col-md-8 offset-md-2">
						<p class="favor">２．登録に必要な項目を入力してください。</p>
					</div>

					<div class="form-group row">
						<div class="col-md-2 offset-md-3">教室名</div>
						<div class="col-md-4">
							八丁堀教室
						</div>
					</div> <!-- end of .form-group row -->

					<div class="form-group row">
						<div class="col-md-2 offset-md-3">担当者名</div>
						<div class="col-md-4">
							<?php echo form_input(array(
								'name'	=> 'contact_name',
								'id'	=> 'contact_name',
								'value'	=> set_value('contact_name', ''),
								'class'	=> 'form-control entry-input',
								'placeholder'	=> '中央太郎'
							)); ?>
							<?php echo form_error('contact_name'); ?>
						</div>
					</div> <!-- end of .form-group row -->

					<div class="form-group row">
						<div class="col-md-2 offset-md-3">メールアドレス</div>
						<div class="col-md-4">
							<?php echo form_input(array(
								'name'	=> 'email',
								'id'	=> 'email',
								'value'	=> set_value('email', ''),
								'class'	=> 'form-control entry-input',
								'placeholder'	=> 'info@chuoh-kyouiku.co.jp'
							)); ?>
							<?php echo form_error('email'); ?>
						</div>
					</div> <!-- end of .form-group row -->

					<div class="form-group row">
						<div class="col-md-2 offset-md-3">パスワード</div>
						<div class="col-md-4">
							<?php echo form_input(array(
								'name'	=> 'password_hidden',
								'id'	=> 'password_hidden',
								'value'	=> set_value('password_hidden', ''),
								'type'	=> 'password',
								'class'	=> 'form-control entry-input'
							)); ?>


							<?php echo form_input(array(
								'name'	=> 'password_show',
								'id'	=> 'password_show',
								'value'	=> set_value('password_show', ''),
								'class'	=> 'form-control entry-input',
								'style'	=> 'display:none;'
							)); ?>
							<?php echo form_error('password_hidden'); ?>
						</div>
						<div class="col-md-3">
							<?php echo form_checkbox(array(
								'name'	=> 'chk_pw',
								'id'	=> 'chk_pw'
							)); ?>
							<?php echo form_label('パスワードを表示する', 'chk_pw'); ?>
						</div>
					</div> <!-- end of .form-group row -->
				</div> <!-- end of #required_item1 -->

				<div id="required_item2" class="mt-5">
					<div class="col-md-8 offset-md-2 mt-5 mb-3">
						<p class="favor">３．これまで中央教育研究所㈱と掛け取引をされていない教室様で、
						掛け取引をご希望される場合、以下にチェックを入れ、必要事項をご入力ください。</p>
						　　※クレジットカードまたは、代引きでのみ購入される場合は不要です。<br>
						　　　そのまま【確認】ボタンをクリックしてください。
					</div>

					<div class="form-group row">
						<div class="col-md-6 offset-md-3">
							<?php echo form_checkbox(array(
								'name'	=> 'apply_credit',
								'id'	=> 'apply_credit',
								'value'	=> '1'
							)); ?>
							<?php echo form_label('『掛け』でのお取引を合わせてご登録', 'apply_credit'); ?><br>
						</div>
					</div>

					<div id="register_credit" style="display:none;">
						<div class="form-group row">
							<div class="col-md-2 offset-md-3">事業形態</div>
							<div class="col-md-4">
								<?php echo form_radio(array(
									'name'	=> 'corporation',
									'id'	=> 'corporation1',
									'value'	=> '1'
								)); ?>
								<?php echo form_label('法人', 'corporation1'); ?>&nbsp;&nbsp;&nbsp;

								<?php echo form_radio(array(
									'name'	=> 'corporation',
									'id'	=> 'corporation2',
									'value'	=> '2'
								)); ?>
								<?php echo form_label('非法人', 'corporation2'); ?>

								<?php echo form_error('corporation'); ?>
							</div>
						</div> <!-- end of .form-group row -->

						<div class="form-group row">
							<div class="col-md-2 offset-md-3">法人名</div>
							<div class="col-md-4">
								<?php echo form_input(array(
									'name'	=> 'corporation_name',
									'value'	=> set_value('corporation_name', ''),
									'class'	=> 'form-control entry-input',
									'placeholder'	=> '中央教育研究所株式会社'
								)); ?>
								<?php echo form_error('corporation_name'); ?>
							</div>
						</div> <!-- end of .form-group row -->

						<div class="form-group row">
							<div class="col-md-2 offset-md-3">法人住所</div>
							<div class="col-3 col-md-1">
								<?php echo form_input(array(
									'name'	=> 'corporation_zip1',
									'value'	=> set_value('corporation_zip1', ''),
									'class'	=> 'form-control entry-input',
									'placeholder'	=> '730'
								)); ?>
							</div>－
							<div class="col-3 col-md-1">
								<?php echo form_input(array(
									'name'	=> 'corporation_zip2',
									'value'	=> set_value('corporation_zip2', ''),
									'class'	=> 'form-control entry-input',
									'placeholder'	=> '0013'
								)); ?>
								<?php echo form_error('corporation_zip1'); ?>
							</div>
						</div> <!-- end of .form-group row -->

						<div class="form-group row">
							<div class="col-md-2 offset-md-3">&nbsp;</div>
							<div class="col-md-4">
								<?php echo form_dropdown('corporation_pref', $CONF['pref']); ?>
								<?php echo form_error('corporation_pref'); ?>
							</div>
						</div> <!-- end of .form-group row -->

						<div class="form-group row">
							<div class="col-md-2 offset-md-3">&nbsp;</div>
							<div class="col-md-4">
								<?php echo form_input(array(
									'name'	=> 'corporation_addr1',
									'value'	=> set_value('corporation_addr1', ''),
									'class'	=> 'form-control entry-input',
									'placeholder'	=> '広島市中区八丁堀15-6'
								)); ?>
								<?php echo form_error('corporation_addr1'); ?>
							</div>
						</div> <!-- end of .form-group row -->

						<div class="form-group row">
							<div class="col-md-2 offset-md-3">&nbsp;</div>
							<div class="col-md-4">
								<?php echo form_input(array(
									'name'	=> 'corporation_addr2',
									'value'	=> set_value('corporation_addr2', ''),
									'class'	=> 'form-control entry-input',
									'placeholder'	=> '広島ちゅうぎんビル3階'
								)); ?>
								<?php echo form_error('corporation_addr2'); ?>
							</div>
						</div> <!-- end of .form-group row -->

						<div class="form-group row">
							<div class="col-md-2 offset-md-3">代表電話番号</div>
							<div class="col-3 col-md-1">
								<?php echo form_input(array(
									'name'	=> 'corporation_tel01',
									'value'	=> set_value('corporation_tel01', ''),
									'class'	=> 'form-control entry-input',
									'placeholder'	=> '082'
								)); ?>
							</div>－
							<div class="col-3 col-md-1">
								<?php echo form_input(array(
									'name'	=> 'corporation_tel02',
									'value'	=> set_value('corporation_tel02', ''),
									'class'	=> 'form-control entry-input',
									'placeholder'	=> '227'
								)); ?>
							</div>－
							<div class="col-3 col-md-1">
								<?php echo form_input(array(
									'name'	=> 'corporation_tel03',
									'value'	=> set_value('corporation_tel03', ''),
									'class'	=> 'form-control entry-input',
									'placeholder'	=> '3999'
								)); ?>
								<?php echo form_error('corporation_tel01'); ?>
							</div>
						</div> <!-- end of .form-group row -->

						<div class="form-group row">
							<div class="col-md-2 offset-md-3">代表者名</div>
							<div class="col-md-4">
								<?php echo form_input(array(
									'name'	=> 'corporation_executive',
									'value'	=> set_value('corporation_executive', ''),
									'class'	=> 'form-control entry-input',
									'placeholder'	=> '中央花子'
								)); ?>
								<?php echo form_error('corporation_executive'); ?>
							</div>
						</div> <!-- end of .form-group row -->

						<div class="form-group row">
							<div class="col-md-2 offset-md-3">お支払い方法</div>
							<div class="col-md-4">
								<?php echo form_radio(array(
									'name'	=> 'payment_method',
									'id'	=> 'payment_method1',
									'value'	=> '1'
								)); ?>
								<?php echo form_label('振込（月末締め、翌月末払い）', 'payment_method1'); ?><br>

								<?php echo form_radio(array(
									'name'	=> 'payment_method',
									'id'	=> 'payment_method2',
									'value'	=> '2'
								)); ?>
								<?php echo form_label('口座引落（２０日締め、翌月１３日引落）', 'payment_method2'); ?>

								<?php echo form_error('payment_method'); ?>
							</div>
						</div> <!-- end of .form-group row -->
					</div> <!-- end of #register_credit -->

					<div class="text-center mt-5 mb-5">
						<?php echo form_submit(array(
							'name'	=> 'btn_submit',
							'class'	=> 'btn btn-success mt-5',
							'value'	=> '　確認　'
						)); ?>
					</div>
				</div> <!-- end of #required_item2 -->
			<?php echo form_close(); ?>







		</div> <!-- end of .container -->
		
		<?php $this->load->view('inc/_foot'); ?>
		<?php $this->load->view('inc/footer'); ?>
	</div> <!-- end of #wrapper -->

	<script src="<?= base_url('js/front.entry.js') ?>?var=<?= CACHES_CLEAR_VERSION ?>"></script>
</body>
</html>
