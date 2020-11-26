<?php $this->load->view('inc/_head', array('TITLE' => SITE_NAME)); ?>

<body>
	<div id="wrapper">
		<?php $this->load->view('inc/header', array('MENU' => FALSE)); ?>

		<div class="container">
			<p class="lead-title">お客様情報登録</p>

			<div class="text-right">
				<a href="<?= site_url('') ?>" class="btn btn-sm btn-secondary">ログイン画面に戻る</a>
			</div>

			<?php echo form_open('entry/confirm', array('id' => 'frm_entry')); ?>
				<?php echo form_input(array(
					'type'	=> 'hidden',
					'id'	=> 'classroom_id',
					'name'	=> 'classroom_id',
					'value'	=> set_value('classroom_id', '')
				)); ?>

				<?php echo form_input(array(
					'type'	=> 'hidden',
					'id'	=> 'classroom_name',
					'name'	=> 'classroom_name',
					'value'	=> set_value('classroom_name', '')
				)); ?>

				<?php echo form_input(array(
					'type'	=> 'hidden',
					'id'	=> 'flg_parent',
					'name'	=> 'flg_parent',
					'value'	=> set_value('flg_parent', '9')
				)); ?>

				<div class="col-md-8 offset-md-2">
					<p class="favor">１．教室コードを入力してください。</p>
				</div>

				<div class="form-group row">
					<div class="col-md-2 offset-md-3">教室コード</div>
					<div class="col-md-4">
						<?php echo form_input(array(
							'name'	=> 'classroom_number',
							'id'	=> 'classroom_number',
							'value'	=> set_value('classroom_number', ''),
							'class'	=> 'form-control entry-input',
							'placeholder'	=> '00000000'
						)); ?>
					</div>
				</div> <!-- end of .form-group row -->

				<div id="registered" class="mt-5" style="display:none;">
					<div class="col-md-8 offset-md-2">
						<p class="already-registered">すでに登録済みです。</p>
					</div>
					<div class="row justify-content-center">
						<div class="col-6 text-center">
							<?php echo form_button(array(
								'name'		=> 'btn_submit',
								'class'		=> 'btn btn-success mt-5',
								'content'	=> '　ログイン画面へ　',
								'onclick'	=> 'location.href=\'' . site_url('') . '\''
							)); ?>
						</div>
					</div>
				</div>

				<div id="required_item1" class="mt-5" style="display:none;">
					<div class="col-md-8 offset-md-2">
						<p class="favor">２．登録に必要な項目を入力してください。</p>
					</div>

					<div class="form-group row">
						<div class="col-md-2 offset-md-3">教室名</div>
						<div class="col-md-4">
							<span class="registered-classroom-name" id="show_classroom_name"><?= !empty($PDATA['classroom_name']) ? $PDATA['classroom_name'] : '' ?></span>
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
						</div>
						<div class="col-md-3">
							<?php echo form_checkbox(array(
								'name'	=> 'chk_pw',
								'id'	=> 'chk_pw',
								'checked'	=> FALSE
							)); ?>
							<?php echo form_label('パスワードを表示する', 'chk_pw'); ?>
						</div>
					</div> <!-- end of .form-group row -->

					<div class="form-group row">
						<div class="col-md-7 offset-md-5">
							※パスワードは8文字以上を指定してください。<br>
							※ここで登録したメールアドレスとパスワードでログインを行います。
						</div>
					</div> <!-- end of .form-group row -->
				</div> <!-- end of #required_item1 -->

				<div id="required_item2" class="mt-5" style="display:none;">
					<div class="col-md-8 offset-md-2 mt-5 mb-3">
						<p class="favor">３．これまで中央教育研究所㈱と掛け取引をされていない教室様で、
						掛け取引をご希望される場合、以下にチェックを入れ、必要事項をご入力ください。</p>
						　　※クレジットカードまたは、代引きでのみ購入される場合は不要です。<br>
						　　　そのまま【確認】ボタンをクリックしてください。
					</div>

					<div class="form-group row">
						<div class="col-md-6 offset-md-3">
							<?php echo form_checkbox(array(
								'name'	=> 'apply_account',
								'id'	=> 'apply_account',
								'value'	=> '1',
								'checked'	=> set_checkbox('apply_account', '1', FALSE)
							)); ?>
							<?php echo form_label('『掛け』でのお取引を合わせてご登録', 'apply_account'); ?><br>
						</div>
					</div>

					<div id="register_account" style="display:none;">
						<div class="form-group row">
							<div class="col-md-2 offset-md-3">事業形態</div>
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
					</div> <!-- end of #register_account -->

					<div id="corporation_detail" style="display:none;">
						<div class="form-group row">
							<div class="col-md-2 offset-md-3" id="cd_corporation_name">法人名</div>
							<div class="col-md-4">
								<?php echo form_input(array(
									'name'	=> 'corporation_name',
									'id'	=> 'corporation_name',
									'value'	=> set_value('corporation_name', ''),
									'class'	=> 'form-control entry-input',
									'placeholder'	=> '中央教育研究所株式会社'
								)); ?>
							</div>
						</div> <!-- end of .form-group row -->

						<div class="form-group row">
							<div class="col-md-2 offset-md-3" id="cd_corporation_address">法人住所</div>
							<div class="col-3 col-md-1">
								<?php echo form_input(array(
									'name'	=> 'corporation_zip1',
									'id'	=> 'corporation_zip1',
									'value'	=> set_value('corporation_zip1', ''),
									'class'	=> 'form-control entry-input',
									'placeholder'	=> '730'
								)); ?>
							</div>－
							<div class="col-3 col-md-1">
								<?php echo form_input(array(
									'name'	=> 'corporation_zip2',
									'id'	=> 'corporation_zip2',
									'value'	=> set_value('corporation_zip2', ''),
									'class'	=> 'form-control entry-input',
									'placeholder'	=> '0013'
								)); ?>
							</div>
						</div> <!-- end of .form-group row -->

						<div class="form-group row">
							<div class="col-md-2 offset-md-3">&nbsp;</div>
							<div class="col-md-4">
								<?php echo form_dropdown('corporation_pref', $CONF['pref'], set_value('corporation_pref', ''), 'id="corporation_pref"'); ?>
							</div>
						</div> <!-- end of .form-group row -->

						<div class="form-group row">
							<div class="col-md-2 offset-md-3">&nbsp;</div>
							<div class="col-md-4">
								<?php echo form_input(array(
									'name'	=> 'corporation_addr1',
									'id'	=> 'corporation_addr1',
									'value'	=> set_value('corporation_addr1', ''),
									'class'	=> 'form-control entry-input',
									'placeholder'	=> '広島市中区八丁堀15-6'
								)); ?>
							</div>
						</div> <!-- end of .form-group row -->

						<div class="form-group row">
							<div class="col-md-2 offset-md-3">&nbsp;</div>
							<div class="col-md-4">
								<?php echo form_input(array(
									'name'	=> 'corporation_addr2',
									'id'	=> 'corporation_addr2',
									'value'	=> set_value('corporation_addr2', ''),
									'class'	=> 'form-control entry-input',
									'placeholder'	=> '広島ちゅうぎんビル3階'
								)); ?>
							</div>
						</div> <!-- end of .form-group row -->

						<div class="form-group row">
							<div class="col-md-2 offset-md-3" id="cd_corporation_tel">代表電話番号</div>
							<div class="col-3 col-md-1">
								<?php echo form_input(array(
									'name'	=> 'corporation_tel01',
									'id'	=> 'corporation_tel01',
									'value'	=> set_value('corporation_tel01', ''),
									'class'	=> 'form-control entry-input',
									'placeholder'	=> '082'
								)); ?>
							</div>－
							<div class="col-3 col-md-1">
								<?php echo form_input(array(
									'name'	=> 'corporation_tel02',
									'id'	=> 'corporation_tel02',
									'value'	=> set_value('corporation_tel02', ''),
									'class'	=> 'form-control entry-input',
									'placeholder'	=> '227'
								)); ?>
							</div>－
							<div class="col-3 col-md-1">
								<?php echo form_input(array(
									'name'	=> 'corporation_tel03',
									'id'	=> 'corporation_tel03',
									'value'	=> set_value('corporation_tel03', ''),
									'class'	=> 'form-control entry-input',
									'placeholder'	=> '3999'
								)); ?>
							</div>
						</div> <!-- end of .form-group row -->

						<div class="form-group row" id="executive">
							<div class="col-md-2 offset-md-3">代表者名</div>
							<div class="col-md-4">
								<?php echo form_input(array(
									'name'	=> 'corporation_executive',
									'id'	=> 'corporation_executive',
									'value'	=> set_value('corporation_executive', ''),
									'class'	=> 'form-control entry-input',
									'placeholder'	=> '中央花子'
								)); ?>
							</div>
						</div> <!-- end of .form-group row -->

						<div class="form-group row">
							<div class="col-md-2 offset-md-3">お支払い方法</div>
							<div class="col-md-4">
								<?php echo form_radio(array(
									'name'	=> 'payment_method',
									'id'	=> 'payment_method1',
									'value'	=> '1',
									'checked'	=> set_radio('payment_method', '1', FALSE)
								)); ?>
								<?php echo form_label('振込（月末締め、翌月末払い）', 'payment_method1'); ?><br>

								<?php echo form_radio(array(
									'name'	=> 'payment_method',
									'id'	=> 'payment_method2',
									'value'	=> '2',
									'checked'	=> set_radio('payment_method', '2', FALSE)
								)); ?>
								<?php echo form_label('口座引落（２０日締め、翌月１３日引落）', 'payment_method2'); ?>
							</div>
						</div> <!-- end of .form-group row -->

						<div class="form-group row" id="transfer" style="display:none;">
							<div class="col-md-2 offset-md-3">お振込み名義</div>
							<div class="col-md-4">
								<?php echo form_input(array(
									'name'	=> 'transfer_name',
									'id'	=> 'transfer_name',
									'value'	=> set_value('transfer_name', ''),
									'class'	=> 'form-control entry-input',
									'placeholder'	=> '中央教育研究所株式会社'
								)); ?>
							</div>
						</div> <!-- end of .form-group row -->
					</div> <!-- end of #corporation_detail -->
				</div> <!-- end of #required_item2 -->

				<div id="btn_confirm" class="mt-5" style="display:none;">
					<div class="text-center mb-5">
						<?php echo form_submit(array(
							'name'	=> 'btn_submit',
							'class'	=> 'btn btn-success mt-5',
							'value'	=> '　確認　'
						)); ?>
					</div>
				</div>
			<?php echo form_close(); ?>
		</div> <!-- end of .container -->

		<?php $this->load->view('inc/_foot'); ?>
		<?php $this->load->view('inc/footer'); ?>
	</div> <!-- end of #wrapper -->

	<script src="//ajaxzip3.github.io/ajaxzip3.js"></script>
	<script src="<?= base_url('js/front.entry.js') ?>?var=<?= CACHES_CLEAR_VERSION ?>"></script>
</body>
</html>
