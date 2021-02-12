<?php $this->load->view('inc/_head', array('TITLE' => SITE_NAME)); ?>

<body>
	<div id="wrapper">
		<?php $this->load->view('inc/header', array('MENU' => TRUE)); ?>

		<div class="container">
			<?php if( get_instruction() ): ?>
				<div class="row justify-content-center">
					<div class="col-md-9">
						<div class="instruction" name="instruction">
							<h1>
								注意事項
								<a href="javascript:void();"><i class="fas fa-window-close"></i></a>
							</h1>

							<section>
								<ul>
									<li>
										市販教材を別送した場合、送料の関係により、合計金額に差異が発生している可能性がございます。
									</li>
								</ul>
							</section>

							<div class="instruction-footer">
								※この注意事項は【メニュー】より常に非表示にすることができます。
							</div>
						</div> <!-- end of .instruction -->
					</div>
				</div> <!-- end of .row -->
			<?php endif; ?>

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
