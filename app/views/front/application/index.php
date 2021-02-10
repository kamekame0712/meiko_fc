<?php $this->load->view('inc/_head', array('TITLE' => SITE_NAME)); ?>

<body>
	<div id="wrapper">
		<?php $this->load->view('inc/header', array('MENU' => FALSE)); ?>

		<div class="container">
			<?php echo form_open('application/confirm'); ?>
				<p class="lead-title">ご利用申込み</p>

				<div class="form-group row">
					<div class="col-md-2 offset-md-3 entry-required">オーナー名</div>
					<div class="col-md-4">
						<?php echo form_input(array(
							'name'	=> 'owner_name',
							'value'	=> set_value('owner_name', ''),
							'class'	=> 'form-control entry-input',
							'placeholder'	=> '山田 太郎'
						)); ?>
						<?php echo form_error('owner_name'); ?>
					</div>
				</div> <!-- end of .form-group row -->

				<div class="form-group row">
					<div class="col-md-2 offset-md-3">法人名</div>
					<div class="col-md-4">
						<?php echo form_input(array(
							'name'	=> 'corpo_name',
							'value'	=> set_value('corpo_name', ''),
							'class'	=> 'form-control entry-input',
							'placeholder'	=> '中央教育研究所株式会社'
						)); ?>
					</div>
				</div> <!-- end of .form-group row -->

				<div class="form-group row">
					<div class="col-md-2 offset-md-3 entry-required">郵便番号</div>
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
					<div class="col-md-2 offset-md-3 entry-required">住所</div>
					<div class="col-md-4">
						<div class="container-fluid">
							<div class="form-group row">
								<?php echo form_dropdown('pref', $CONF['pref'], set_value('pref', ''), 'class="form-control entry-input"'); ?>
							</div> <!-- end of .form-group row -->

							<div class="form-group row">
								<?php echo form_input(array(
									'name'	=> 'addr1',
									'value'	=> set_value('addr1', ''),
									'class'	=> 'form-control entry-input',
									'placeholder'	=> '広島市中区八丁堀15-6'
								)); ?>
							</div> <!-- end of .form-group row -->

							<div class="form-group row">
								<?php echo form_input(array(
									'name'	=> 'addr2',
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
					<div class="col-md-2 offset-md-3 entry-required">電話番号</div>
					<div class="col-md-4">
						<?php echo form_input(array(
							'name'	=> 'tel1',
							'value'	=> set_value('tel1', ''),
							'class'	=> 'form-control entry-input entry-input-small',
							'placeholder'	=> '082'
						)); ?>&nbsp;-&nbsp;
						<?php echo form_input(array(
							'name'	=> 'tel2',
							'value'	=> set_value('tel2', ''),
							'class'	=> 'form-control entry-input entry-input-small',
							'placeholder'	=> '227'
						)); ?>&nbsp;-&nbsp;
						<?php echo form_input(array(
							'name'	=> 'tel3',
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
							'value'	=> set_value('fax1', ''),
							'class'	=> 'form-control entry-input entry-input-small',
							'placeholder'	=> '082'
						)); ?>&nbsp;-&nbsp;
						<?php echo form_input(array(
							'name'	=> 'fax2',
							'value'	=> set_value('fax2', ''),
							'class'	=> 'form-control entry-input entry-input-small',
							'placeholder'	=> '227'
						)); ?>&nbsp;-&nbsp;
						<?php echo form_input(array(
							'name'	=> 'fax3',
							'value'	=> set_value('fax3', ''),
							'class'	=> 'form-control entry-input entry-input-small',
							'placeholder'	=> '4000'
						)); ?>
					</div>
				</div> <!-- end of .form-group row -->

				<div class="form-group row">
					<div class="col-md-2 offset-md-3 entry-required">メールアドレス</div>
					<div class="col-md-4">
						<?php echo form_input(array(
							'name'	=> 'email',
							'value'	=> set_value('email', ''),
							'class'	=> 'form-control entry-input',
							'placeholder'	=> 'info@chuoh-kyouiku.co.jp'
						)); ?>
						<?php echo form_error('email'); ?>
					</div>
				</div> <!-- end of .form-group row -->

				<div class="form-group row">
					<div class="col-md-2 offset-md-3 entry-required">
						運営教室<br>
						<?php echo form_button(array(
							'name'		=> 'btn-add',
							'content'	=> '<i class="fas fa-plus-circle"></i>&nbsp;入力欄追加',
							'class'		=> 'btn btn-sm btn-outline-info mt-3',
							'onclick'	=> 'add_classroom();'
						)); ?>
					</div>
					<div class="col-md-7">
						<table class="classroom-list" id="classroom_list">
							<thead>
								<tr>
									<th>教室コード</th>
									<th>教室名</th>
								</tr>
							</thead>
							<tbody>
								<?php for( $i = 0; $i < $LINES; $i++ ): ?>
									<tr>
										<td>
											<?php echo form_input(array(
												'name'		=> 'classroom_number[]',
												'value'		=> $CM[$i],
												'data-num'	=> $i,
												'class'		=> 'form-control entry-input'
											)); ?>
										</td>
										<td id="classroom_name<?= sprintf('%03d', $i) ?>"></td>
									</tr>
								<?php endfor; ?>
							</tbody>
						</table>
						<span class="attention-msg">※教室コードを入力していただくと、教室名は自動的に表示されます。</span>
						<?php echo form_error('classroom_number[]'); ?>
					</div>
				</div> <!-- end of .form-group row -->

				<div class="form-group row">
					<div class="col-md-2 offset-md-3 entry-required">お支払方法</div>
					<div class="col-md-4">
						<?php echo form_checkbox(array(
							'name'	=> 'payment_method1',
							'id'	=> 'payment_method1',
							'value'	=> '1',
							'checked'	=> set_checkbox('payment_method1', '1', FALSE)
						)); ?>
						<?php echo form_label('掛け', 'payment_method1'); ?>&nbsp;&nbsp;

						<?php echo form_checkbox(array(
							'name'	=> 'payment_method2',
							'id'	=> 'payment_method2',
							'value'	=> '1',
							'checked'	=> set_checkbox('payment_method2', '1', FALSE)
						)); ?>
						<?php echo form_label('クレジットカード', 'payment_method2'); ?>&nbsp;&nbsp;

						<?php echo form_checkbox(array(
							'name'	=> 'payment_method3',
							'id'	=> 'payment_method3',
							'value'	=> '1',
							'checked'	=> set_checkbox('payment_method3', '1', FALSE)
						)); ?>
						<?php echo form_label('代引き', 'payment_method3'); ?>
						<?php echo form_error('payment_method1'); ?>
					</div>
				</div> <!-- end of .form-group row -->

				<div class="text-center my-5">
					<?php echo form_submit(array(
						'name'	=> 'btn_submit',
						'class'	=> 'btn btn-success',
						'value'	=> '　確認　'
					)); ?>
				</div>
			<?php echo form_close(); ?>
		</div> <!-- end of .container -->

		<?php $this->load->view('inc/_foot'); ?>
		<?php $this->load->view('inc/footer'); ?>
	</div> <!-- end of #wrapper -->

	<script src="//ajaxzip3.github.io/ajaxzip3.js"></script>
	<script src="<?= base_url('js/front.application.js') ?>?var=<?= CACHES_CLEAR_VERSION ?>"></script>
</body>
</html>