<?php $this->load->view('inc/_head', array('TITLE' => 'TOP | ' . SITE_NAME)); ?>

<body>
	<div id="app">
		<div class="main-wrapper main-wrapper-1">
			<?php $this->load->view('inc/header'); ?>
			<?php $this->load->view('inc/sidebar', array('current' => 'top')); ?>

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
														<th colspan="2">機能</th>
														<th>説明</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td rowspan="7">成学社</td>
														<td><a href="<?= site_url('seigaku/upload_data') ?>"><i class="fas fa-upload"></i>&nbsp;受取データUL</a></td>
														<td>
															成学社から送られて来たExcelデータのアップロードが行えます。
														</td>
													</tr>
													<tr>
														<td><a href="<?= site_url('seigaku/smile') ?>"><i class="far fa-smile"></i>&nbsp;SMILEデータDL</a></td>
														<td>
															SMILEに登録するCSVデータ、チェックリスト、市販教材・CKTの受注一覧のダウンロードが行えます。
														</td>
													</tr>
													<tr>
														<td><a href="<?= site_url('seigaku/sending') ?>"><i class="fas fa-share-square"></i>&nbsp;送付状況レポートDL</a></td>
														<td>
															送付状況レポート（送付明細）のダウンロードが行えます。
														</td>
													</tr>
													<tr>
														<td><a href="<?= site_url('seigaku/demand') ?>"><i class="far fa-list-alt"></i>&nbsp;請求明細データDL</a></td>
														<td>
															請求明細を作成するためのCSVデータのダウンロードが行えます。<br>
															（実際の請求明細は先方の指定書式のため、Excelで作成してください。）
														</td>
													</tr>
													<tr>
														<td><a href="<?= site_url('seigaku/send_list') ?>"><i class="fas fa-envelope-open-text"></i>&nbsp;教材送付リストDL</a></td>
														<td>
															教材送付リスト（QR付きの納品書）のダウンロードが行えます。
														</td>
													</tr>
													<tr>
														<td><a href="<?= site_url('seigaku/order') ?>"><i class="fas fa-database"></i>&nbsp;受注データ確認</a></td>
														<td>
															アップロードされた受注データの確認が行えます。<br>
															また、アップロード時に設定した出荷日の変更も行えます。
														</td>
													</tr>
													<tr>
														<td><a href="<?= site_url('seigaku/stock') ?>"><i class="fas fa-tasks"></i>&nbsp;在庫管理</a></td>
														<td>
															成学社オリジナルテキストの在庫状況の確認、入荷等の管理が行えます。
														</td>
													</tr>

													<tr>
														<td rowspan="2">全体</td>
														<td><a href="<?= site_url('publisher') ?>"><i class="fas fa-print"></i>&nbsp;出版社管理</a></td>
														<td>
															出版社の登録、修正、削除が行えます。
														</td>
													</tr>
													<tr>
														<td><a href="<?= site_url('product') ?>"><i class="fas fa-book"></i>&nbsp;テキスト管理</a></td>
														<td>
															テキストの登録、修正、削除が行えます。<br>
															塾ごとの商品コードの設定も行えます。
														</td>
													</tr>

													<tr>
														<td>その他</td>
														<td><a href="<?= site_url('manage') ?>"><i class="fas fa-user-tie"></i>&nbsp;管理者管理</a></td>
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

			<?php $this->load->view('inc/footer'); ?>
		</div> <!-- end of .main-wrapper -->
	</div> <!-- end of #app -->

	<?php $this->load->view('inc/_foot'); ?>
</body>
</html>
