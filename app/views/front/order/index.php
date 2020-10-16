<?php $this->load->view('inc/_head', array('TITLE' => SITE_NAME)); ?>

<body>
	<div id="wrapper">
		<div class="container">
			<div class="row">

			</div> <!-- end of .row -->



		</div> <!-- end of .container -->
		
		<?php $this->load->view('inc/_foot'); ?>
		<?php $this->load->view('inc/footer'); ?>
	</div> <!-- end of #wrapper -->

	<script src="<?= base_url('js/front.order.js') ?>?var=<?= CACHES_CLEAR_VERSION ?>"></script>
</body>
</html>
