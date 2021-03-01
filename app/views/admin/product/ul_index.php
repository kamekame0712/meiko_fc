<?php $this->load->view('inc/admin/_head', array('TITLE' => '教材管理 | ' . SITE_NAME)); ?>

<body>
	<section class="section">
		<div class="section-header">
			<h1 class="title">教材アップロード</h1>
		</div>

		<div class="section-body">
			<div class="card card-primary">
				<div class="card-body px-0">
					<ul>
						<li>アップロードできるのはCSV形式のファイルのみです。</li>
						<li>『教材データダウンロード』でダウンロードしたファイルの項目に合わせてください。</li>
						<li>1行目は項目名にしてください。</li>
						<li>新規追加の商品は【商品ID】を空欄にしてください。</li>
						<li>【商品ID】が入っている場合、該当の商品を更新します。</li>
					</ul>

					<?php echo form_open_multipart('admin/product/ul_confirm'); ?>
						<div class="form-group px-5 mt-2">
							<?php echo form_label('ファイル選択', '', array('class' => 'required-label', 'style' => 'display:block;')); ?>

							<?php echo form_upload(array(
								'name'	=> 'import_file',
								'accept'=> '.csv'
							)); ?>
							<?php if( !empty($MESSAGE) ): ?>
								<?= $MESSAGE ?>
							<?php endif; ?>
						</div>

						<div class="container-fluid">
							<div class="row justify-content-center mb-3">
								<div class="text-center">
									<?php echo form_submit(array(
										'name'		=> 'btn_submit',
										'value'		=> '登録する',
										'class'		=> 'btn btn-primary btn-lg note-btn'
									)); ?>
									<p class="text-danger">※確認はありません。そのまま登録されます。</p>
								</div>
							</div> <!-- end of .row -->
						</div>
					<?php echo form_close(); ?>
				</div> <!-- end of .card-body -->
			</div> <!-- end of .card -->
		</div><!-- end of .section-body -->
	</section>
</body>
</html>
