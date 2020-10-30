<?php $this->load->view('inc/admin/_head', array('TITLE' => 'TOP | ' . SITE_NAME)); ?>

<body>
	<div id="app">
		<div class="main-wrapper main-wrapper-1">
			<?php $this->load->view('inc/admin/header'); ?>
			<?php $this->load->view('inc/admin/sidebar', array('current' => 'top')); ?>

			<div class="main-content">
				<section class="section">
					<div class="section-header">
						<h1>TOP</h1>
					</div>

					<div class="section-body">
						<div class="row">
							<div class="col-12">
								<div class="card card-primary">
									<div class="card-body">
										<div class="table-responsive">
											<table class="table table-striped table-sm">
												<thead>
													<tr>
														<th>機能</th>
														<th>説明</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td><a href="<?= site_url('admin/manage') ?>"><i class="fas fa-user-tie"></i>&nbsp;管理者管理</a></td>
														<td>
															管理者の登録、修正、削除が行えます。
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div> <!-- end of .card -->
							</div>
						</div> <!-- end of .row -->
					</div> <!-- end of .section-body -->
				</section>
			</div>

			<?php $this->load->view('inc/admin/footer'); ?>
		</div> <!-- end of .main-wrapper -->
	</div> <!-- end of #app -->

	<?php $this->load->view('inc/admin/_foot'); ?>
</body>
</html>
