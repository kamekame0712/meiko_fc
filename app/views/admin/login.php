<?php $this->load->view('inc/admin/_head', array('TITLE' => SITE_NAME)); ?>

<body>
	<div id="app">
		<section class="section">
			<div class="container mt-5">
				<div class="row">
					<div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
						<div class="login-brand">明光義塾FC専用受注管理</div>

						<div class="card card-primary">
							<div class="card-header"><h4>Login</h4></div>

							<div class="card-body">
								<?php if( !empty(validation_errors()) ): ?>
									<div class="alert alert-danger alert-dismissible show fade">
										<div class="alert-body">
											<button class="close" data-dismiss="alert">
												<span>×</span>
											</button>
											<?= validation_errors(); ?>
										</div>
									</div>
								<?php endif; ?>

								<?php echo form_open('admin/index/do_login'); ?>
									<div class="form-group">
										<?php echo form_label('メールアドレス', 'email', 'class="control-label"'); ?>
										<?php echo form_input(array(
											'name'	=> 'email',
											'id'	=> 'email',
											'type'	=> 'email',
											'value'	=> set_value('email'),
											'class'	=> 'form-control',
											'tabindex'	=> '1'
										)); ?>
									</div>

									<div class="form-group">
										<?php echo form_label('パスワード', 'password'); ?>
										<?php echo form_input(array(
											'name'	=> 'password',
											'id'	=> 'password',
											'type'	=> 'password',
											'class'	=> 'form-control',
											'tabindex'	=> '2'
										)); ?>
									</div>

									<div class="form-group">
										<?php echo form_submit(array(
											'name'	=> 'btn_submit',
											'value'	=> 'ログイン',
											'class'	=> 'btn btn-primary btn-lg btn-block',
											'tabindex'	=> '3'
										)); ?>
									</div>
								</form>
							</div> <!-- end of .card-body -->
						</div> <!-- end of .card -->
					</div>
				</div> <!-- end of .row -->
			</div> <!-- end of .container -->
		</section>
	</div> <!-- end of #app -->

	<?php $this->load->view('inc/_foot'); ?>
</body>
</html>
