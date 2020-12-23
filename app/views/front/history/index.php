<?php $this->load->view('inc/_head', array('TITLE' => SITE_NAME)); ?>

<body>
	<div id="wrapper">
		<?php $this->load->view('inc/header', array('MENU' => TRUE)); ?>

		<div class="container">
			<p class="lead-title">発注履歴</p>

			<?php if( empty($HISTORY) ): ?>
				発注履歴はありません。
			<?php else: ?>
				<?= $TOTAL ?>件の履歴があります。

				<div class="history-box mb-5">
					<?php foreach( $HISTORY as $val ): ?>
						<div class="item-box">
							<div class="box-left">
								<?php echo form_button(array(
									'name'		=> 'btn_show_detail',
									'content'	=> '詳細表示',
									'class'		=> 'btn btn-primary',
									'onclick'	=> 'location.href=\'' . site_url('history/detail') . '/' . $val['order_id'] . '\''
								)); ?>
							</div>
							<div class="box-right">
								<p class="order-date"><?= date('Y/m/d　H:i:s', strtotime($val['regist_time'])) ?></p>
								<dl>
									<dt>金額合計</dt>
									<dd>&yen;<?= number_format($val['total_cost']) ?></dd>
									<dt>お支払方法</dt>
									<dd><?= $CONF['payment_method'][$val['payment_method']] ?></dd>
								</dl>
							</div>
						</div> <!-- end of .item-box -->
					<?php endforeach; ?>
				</div>
				<div class="pagination"><?= $PAGINATION ?><?= $SHOWING ?></div>
			<?php endif; ?>
		</div> <!-- end of .container -->

		<?php $this->load->view('inc/_foot'); ?>
		<?php $this->load->view('inc/footer'); ?>
		<script src="<?= site_url('js/front.history.js') ?>?var=<?= CACHES_CLEAR_VERSION ?>"></script>
	</div> <!-- end of #wrapper -->
</body>
</html>
