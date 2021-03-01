<?php $this->load->view('inc/admin/_head', array('TITLE' => '教材管理 | ' . SITE_NAME)); ?>

<body>
	<section class="section">
		<div class="section-header">
			<h1 class="title">教材アップロード</h1>
		</div>

		<div class="section-body">
			<div class="card card-primary">
				<div class="card-header">
					<h4>登録結果</h4>
				</div>

				<div class="card-body">
					<dl class="ul-result">
						<dt>新規追加件数</dt>
						<dd><?= number_format($INSERT) ?>&nbsp;件</dd>
						<dt>更新件数</dt>
						<dd><?= number_format($UPDATA) ?>&nbsp;件</dd>
						<dt>エラー件数</dt>
						<dd><?= number_format(count($ERRORS)) ?>&nbsp;件</dd>
					</dl>

					<?php if( !empty($ERRORS) ): ?>
						<div class="error-ul-box">
							<h5>エラー内容</h5>

							<table class="table table-striped">
								<thead>
									<tr>
										<th>行番号</th>
										<th>商品ID</th>
										<th>SMILEコード</th>
										<th>商品名</th>
										<th>詳細</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach( $ERRORS as $err_val ): ?>
									<tr>
										<td><?= $err_val['data_cnt'] ?></td>
										<td><?= $err_val['product_id'] ?></td>
										<td><?= $err_val['smile_code'] ?></td>
										<td><?= $err_val['name'] ?></td>
										<td><?= $err_val['comment'] ?></td>
									</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					<?php endif; ?>
				</div> <!-- end of .card-body -->
			</div> <!-- end of .card -->
		</div><!-- end of .section-body -->
	</section>
</body>
</html>
