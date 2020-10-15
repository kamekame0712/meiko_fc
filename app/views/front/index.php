<?php $this->load->view('inc/_head', array('TITLE' => SITE_NAME)); ?>

<body>
	<div id="wrapper">
		<div class="container">
			<div class="row">
				<h1 class="title">
					<span>明光義塾フランチャイズ教室様専用</span><br>
					CHUOHネットショップ会員登録
				</h1>
			</div> <!-- end of .row -->

			<?php echo form_open('index/confirm'); ?>
				<div class="form-group row">
					<div class="col-md-2 offset-md-3">教室名</div>
					<div class="col-md-4">
						<?php echo form_input(array(
							'name'	=> 'classroom',
							'value'	=> set_value('classroom', ''),
							'class'	=> 'form-control',
							'placeholder'	=> '八丁堀教室'
						)); ?>
						<?php echo form_error('classroom'); ?>
					</div>
				</div> <!-- end of .form-group row -->

				<div class="form-group row">
					<div class="col-md-2 offset-md-3">担当者名</div>
					<div class="col-md-4">
						<?php echo form_input(array(
							'name'	=> 'contact_name',
							'value'	=> set_value('contact_name', ''),
							'class'	=> 'form-control',
							'placeholder'	=> '中央太郎'
						)); ?>
						<?php echo form_error('contact_name'); ?>
					</div>
				</div> <!-- end of .form-group row -->

				<div class="form-group row">
					<div class="col-md-2 offset-md-3">電話番号</div>
					<div class="col-3 col-md-1">
						<?php echo form_input(array(
							'name'	=> 'tel01',
							'value'	=> set_value('tel01', ''),
							'class'	=> 'form-control',
							'placeholder'	=> '082'
						)); ?>
					</div>－
					<div class="col-3 col-md-1">
						<?php echo form_input(array(
							'name'	=> 'tel02',
							'value'	=> set_value('tel02', ''),
							'class'	=> 'form-control',
							'placeholder'	=> '227'
						)); ?>
					</div>－
					<div class="col-3 col-md-1">
						<?php echo form_input(array(
							'name'	=> 'tel03',
							'value'	=> set_value('tel03', ''),
							'class'	=> 'form-control',
							'placeholder'	=> '3999'
						)); ?>
						<?php echo form_error('tel01'); ?>
					</div>
				</div> <!-- end of .form-group row -->

				<div class="form-group row">
					<div class="col-md-2 offset-md-3">メールアドレス</div>
					<div class="col-md-4">
						<?php echo form_input(array(
							'name'	=> 'email',
							'value'	=> set_value('email', ''),
							'class'	=> 'form-control',
							'placeholder'	=> 'info@chuoh-kyouiku.co.jp'
						)); ?>
						<?php echo form_error('email'); ?>
					</div>
				</div> <!-- end of .form-group row -->

				<div class="form-group row">
					<div class="col-md-2 offset-md-3">パスワード</div>
					<div class="col-md-4">
						<?php echo form_input(array(
							'name'	=> 'password',
							'value'	=> set_value('password', ''),
							'type'	=> 'password',
							'class'	=> 'form-control'
						)); ?>
						<?php echo form_error('password'); ?>
					</div>
				</div> <!-- end of .form-group row -->

				<div class="col-md-8 offset-md-2 mt-5 mb-3">
					※これまで中央教育研究所㈱と掛け取引をされていない教室様で、
					掛け取引をご希望される場合、以下にチェックを入れ、必要事項をご入力ください。<br>
					（クレジットカードまたは、代引きでのみ購入される場合は不要です。）
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
								'class'	=> 'form-control',
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
								'class'	=> 'form-control',
								'placeholder'	=> '730'
							)); ?>
						</div>－
						<div class="col-3 col-md-1">
							<?php echo form_input(array(
								'name'	=> 'corporation_zip2',
								'value'	=> set_value('corporation_zip2', ''),
								'class'	=> 'form-control',
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
								'class'	=> 'form-control',
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
								'class'	=> 'form-control',
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
								'class'	=> 'form-control',
								'placeholder'	=> '082'
							)); ?>
						</div>－
						<div class="col-3 col-md-1">
							<?php echo form_input(array(
								'name'	=> 'corporation_tel02',
								'value'	=> set_value('corporation_tel02', ''),
								'class'	=> 'form-control',
								'placeholder'	=> '227'
							)); ?>
						</div>－
						<div class="col-3 col-md-1">
							<?php echo form_input(array(
								'name'	=> 'corporation_tel03',
								'value'	=> set_value('corporation_tel03', ''),
								'class'	=> 'form-control',
								'placeholder'	=> '3999'
							)); ?>
							<?php echo form_error('corporation_tel01'); ?>
						</div>
					</div> <!-- end of .form-group row -->

					<div class="form-group row">
						<div class="col-md-2 offset-md-3">代表者</div>
						<div class="col-md-4">
							<?php echo form_input(array(
								'name'	=> 'corporation_executive',
								'value'	=> set_value('corporation_executive', ''),
								'class'	=> 'form-control',
								'placeholder'	=> '中央花子'
							)); ?>
							<?php echo form_error('corporation_executive'); ?>
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
			<?php echo form_close(); ?>
		</div> <!-- end of .container -->
		
		<?php $this->load->view('inc/_foot'); ?>
		<?php $this->load->view('inc/footer'); ?>
	</div> <!-- end of #wrapper -->

	<script src="<?= base_url('js/front.index.js') ?>?var=<?= CACHES_CLEAR_VERSION ?>"></script>
</body>
</html>
