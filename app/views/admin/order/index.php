<?php $this->load->view('inc/admin/_head', array('TITLE' => '受注管理 | ' . SITE_NAME)); ?>

<body>
	<div id="app">
		<div class="main-wrapper main-wrapper-1">
			<?php $this->load->view('inc/admin/header'); ?>
			<?php $this->load->view('inc/admin/sidebar', array('current' => 'order')); ?>

			<div class="main-content">
				<section class="section">
					<div class="section-header">
						<h1>受注管理</h1>
					</div>

					<div class="section-body">
						<div class="row">









						</div> <!-- end of .row -->
					</div> <!-- end of .section-body -->
				</section>
			</div> <!-- end of .main-content -->

			<?php $this->load->view('inc/admin/footer'); ?>
		</div> <!-- end of .main-wrapper -->
	</div> <!-- end of #app -->

	<?php $this->load->view('inc/admin/_foot'); ?>
	<script src="<?= base_url('js/admin/order.js')?>?var=<?= CACHES_CLEAR_VERSION ?>"></script>
</body>
</html>
