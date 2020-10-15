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

			<div class="form-group row">
				<div class="col-md-2 offset-md-3">教室名</div>
				<div class="col-md-4">
					<?php echo form_input(array(
						'name'	=> 'classroom',
						'value'	=> set_value('classroom', ''),
						'class'	=> 'form-control'
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
						'class'	=> 'form-control'
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
						'class'	=> 'form-control'
					)); ?>
				</div>－
				<div class="col-3 col-md-1">
					<?php echo form_input(array(
						'name'	=> 'tel02',
						'value'	=> set_value('tel02', ''),
						'class'	=> 'form-control'
					)); ?>
				</div>－
				<div class="col-3 col-md-1">
					<?php echo form_input(array(
						'name'	=> 'tel03',
						'value'	=> set_value('tel03', ''),
						'class'	=> 'form-control'
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
						'class'	=> 'form-control'
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

			<div id="register_credit">
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
							'class'	=> 'form-control'
						)); ?>
						<?php echo form_error('corporation_name'); ?>
					</div>
				</div> <!-- end of .form-group row -->

				<div class="form-group row">
					<div class="col-md-2 offset-md-3">法人名</div>
					<div class="col-md-4">
						<?php echo form_input(array(
							'name'	=> 'corporation_name',
							'value'	=> set_value('corporation_name', ''),
							'class'	=> 'form-control'
						)); ?>
						<?php echo form_error('corporation_name'); ?>
					</div>
				</div> <!-- end of .form-group row -->









			</div> <!-- end of #register_credit -->
		</div> <!-- end of .container -->
		
		<?php $this->load->view('inc/_foot'); ?>
		<?php $this->load->view('inc/footer'); ?>
	</div> <!-- end of #wrapper -->

	<script src="<?= base_url('js/front.index.js') ?>?var=<?= CACHES_CLEAR_VERSION ?>"></script>
</body>
</html>
