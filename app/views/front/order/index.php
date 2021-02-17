<?php $this->load->view('inc/_head', array('TITLE' => SITE_NAME)); ?>

<body>
	<div id="wrapper">
		<?php $this->load->view('inc/header', array('MENU' => TRUE)); ?>

		<div class="container">
			<ul class="breadcrumb-list">
				<li class="current">発注内容の選択</li>
				<li>発注内容の確認</li>
				<li>完了</li>
			</ul>

			<?php if( !empty($ERROR_MESSAGE) ): ?>
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<?= $ERROR_MESSAGE ?>
					<button type="button" class="close" data-dismiss="alert" aria-label="閉じる">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			<?php endif; ?>

			<?php if( empty($PAYMENT_LIST) ): ?>
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					オーナー様がお支払方法を選択されていません。<br>
					現在ご注文いただけません。
					<button type="button" class="close" data-dismiss="alert" aria-label="閉じる">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			<?php endif; ?>

			<?php if( !empty($PAYMENT_LIST) ): ?>
				<?php if( get_instruction() ): ?>
					<div class="row justify-content-center">
						<div class="col-md-6">
							<div class="instruction" name="instruction">
								<h1>
									操作方法
									<a href="javascript:void();"><i class="fas fa-window-close"></i></a>
								</h1>

								<section>
									<ol>
										<li>
											教材を選択してください。<br>
											※詳細は【教材の選択方法】をご覧ください。
										</li>
										<li>
											数量を入力してください。
										</li>
										<li>
											その他項目を選択、入力してください。<br>
											※<span class="attention-msg">お支払方法は必須です</span>。
										</li>
										<li>
											【確認】ボタンをクリックしてください。<br>
											※確認画面へ遷移します。
										</li>
									</ol>
								</section>

								<div class="instruction-footer">
									※この注意事項は【メニュー】より常に非表示にすることができます。
								</div>
							</div> <!-- end of .instruction -->
						</div>

						<div class="col-md-6">
							<div class="instruction" name="instruction">
								<h1>
									教材の選択方法
									<a href="javascript:void();"><i class="fas fa-window-close"></i></a>
								</h1>

								<section>
									<ol>
										<li>
											【教材選択】ボタンをクリックしてください。<br>
											※教材選択ウィンドウが表示されます。<br>
											（<span class="attention-msg">以下、手順２，３は教材選択ウィンドウでの処理です</span>。）
										</li>
										<li>
											検索条件を指定し【検索】ボタンをクリックしてください。
										</li>
										<li>
											表示される教材の一覧左端にある【選択】ボタンをクリックしてください。<br>
											※教材選択ウィンドウは必要に応じ、閉じてください。
										</li>
									</ol>
									※間違った教材を選択した場合、削除欄にある【&nbsp;<i class="fas fa-times"></i>&nbsp;】をクリックしてください。
								</section>

								<div class="instruction-footer">
									※この注意事項は【メニュー】より常に非表示にすることができます。
								</div>
							</div> <!-- end of .instruction -->
						</div>
					</div> <!-- end of .row -->
				<?php endif; ?>

				<?php echo form_open('order/confirm', array('id' => 'frm_order')); ?>
					<?php echo form_input(array(
						'type'	=> 'hidden',
						'name'	=> 'gmo_token',
						'id'	=> 'gmo_token',
						'value'	=> ''
					)); ?>

					<?php echo form_input(array(
						'type'	=> 'hidden',
						'name'	=> 'gmo_maskedCardNo',
						'id'	=> 'gmo_maskedCardNo',
						'value'	=> ''
					)); ?>

					<?php echo form_input(array(
						'type'	=> 'hidden',
						'name'	=> 'card_type',
						'id'	=> 'card_type',
						'value'	=> ''
					)); ?>

					<p class="lead-title">発注内容</p>

					<div class="order-buttons">
						<?php echo form_button(array(
							'name'		=> 'btn-add-product',
							'content'	=> '教材選択',
							'class'		=> 'btn btn-primary float-left ',
							'onclick'	=> 'choose_product();'
						)); ?>

						<?php if( !empty($PLIST) ): ?>
							<a href="<?= site_url('order/remove_all_order') ?>" class="btn btn-danger float-right">全教材削除</a>
						<?php endif; ?>
					</div>

					<?php $i = 1; ?>
					<?php if( !empty($PLIST) ): ?>
						<table class="table table-striped tbl-order">
							<thead>
								<tr>
									<th>削除</th>
									<th>出版社</th>
									<th>教材名</th>
									<th>単価</th>
									<th>数量</th>
									<th>金額</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach( $PLIST as $product_id => $val ): ?>
									<tr>
										<td>
											<a href="<?= site_url('order/remove_order/' . $product_id) ?>">
												<i class="fas fa-times"></i>
											</a>
										</td>
										<td><?= $val['publisher_name'] ?></td>
										<td><?= $val['product_name'] ?></td>
										<td>\<?= number_format($val['sales_price']) ?></td>
										<td>
											<?php echo form_input(array(
												'name'		=> 'num_' . $product_id,
												'data-id'	=> $product_id,
												'type'		=> 'number',
												'min'		=> 0,
												'value'		=> $val['quantity'],
												'class'		=> 'input-num',
												'tabindex'	=> $i
											)); ?>
										</td>
										<td>\<?= number_format($val['sub_total']) ?></td>
									</tr>

									<?php $i++; ?>
								<?php endforeach; ?>

								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>送料</td>
									<td>&nbsp;</td>
									<td>\<?= number_format($SHIPPING_FEE) ?></td>
								</tr>

								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>合計</td>
									<td class="text-right" style="padding:0.75rem;"><?= $TOTAL_QUANTITY ?></td>
									<td>\<?= number_format($TOTAL_COST + $SHIPPING_FEE) ?></td>
								</tr>
							</tbody>
						</table>
					<?php endif; ?>

					<p class="lead-title mt-5">その他</p>

					<?php if( $PRODUCT_KIND == 1 ): ?>
						<dl class="others">
							<dt>市販教材</dt>
							<dd>
								発注内容に『市販教材』と『塾用教材』が含まれています。<br>
								『市販教材』と『塾用教材』を一緒にお届けするか、別々でお届けするかお選びください。

								<div class="container-fluid">
									<div class="row">
										<div class="col-md-3 pl-0">
											<?php echo form_radio(array(
												'name'	=> 'flg_partial',
												'id'	=> 'flg_partial1',
												'value'	=> '1',
												'checked'	=> $PARTIAL == '1' ? TRUE : FALSE
											)); ?>
											<?php echo form_label('一緒にお届け', 'flg_partial1'); ?>
										</div>

										<div class="col-md-3 pl-0">
											<?php echo form_radio(array(
												'name'	=> 'flg_partial',
												'id'	=> 'flg_partial2',
												'value'	=> '2',
												'checked'	=> $PARTIAL == '2' ? TRUE : FALSE
											)); ?>
											<?php echo form_label('別々でお届け', 'flg_partial2'); ?>
										</div>
									</div> <!-- end of .row -->
								</div> <!-- end of .container-fluid -->

								<div class="attention-box">
									<h3>『市販教材』は<span class="attention-msg">お届けまで2週間程度かかります</span>。</h3>
									一緒にお届する場合、お届け日は『市販教材』に合わせます。<br>
									別々でお届けする場合、『塾用教材』は早くお届けできますが、<span class="attention-msg">発注金額によっては送料がそれぞれにかかってしまいます</span>。<br>
									※送料につきましては、次ページ（発注内容の確認）でご確認ください。
								</div>
							</dd>
						</dl>
					<?php elseif( $PRODUCT_KIND == 3 ): ?>
						<dl class="others">
							<dt>&nbsp;</dt>
							<dd>
								<div class="attention-box">
									<h3>『市販教材』は<span class="attention-msg">お届けまで2週間程度かかります</span>。</h3>
								</div>
							</dd>
						</dl>
					<?php endif; ?>

					<dl class="others">
						<dt>お支払方法</dt>
						<dd>
							<div class="container-fluid">
								<div class="row">
									<?php for( $j = 1; $j <= 3; $j++ ): ?>
										<?php if( isset($PAYMENT_LIST[$j]) ): ?>
											<div class="col-md-3 pl-0">
												<?php echo form_radio(array(
													'name'	=> 'payment_method',
													'id'	=> 'pm' . $j,
													'value'	=> $j,
													'checked'	=> $PAYMENT == $j ? TRUE : FALSE,
													'tabindex'	=> $i++
												)); ?>
												<?php echo form_label($PAYMENT_LIST[$j], 'pm' . $j); ?>
											</div>
										<?php else: ?>
											<?php echo form_radio(array(
												'name'	=> 'payment_method',
												'id'	=> 'pm' . $j,
												'value'	=> $j,
												'checked'	=> FALSE,
												'tabindex'	=> $i++,
												'style'		=> 'display:none;'
											)); ?>
										<?php endif; ?>
									<?php endfor; ?>
								</div> <!-- end of .row -->
							</div> <!-- end of .container-fluid -->
						</dd>
					</dl>

					<?php
						if( $PAYMENT == '2' ) {
							$show_dl = 'block';
						}
						else {
							$show_dl = 'none';
						}
					?>
					<dl class="others" id="credit" style="display:<?= $show_dl ?>">
						<dt>&nbsp;</dt>
						<dd>
							<?php echo form_fieldset('クレジットカード情報', array('class' => 'fs-credit')); ?>
								<p>※お支払いは一括払いのみです。</p>

								<?php
									if( !empty($CARD) ) {
										$registered = 'display:block';
										$newly = 'display:none';
									}
									else {
										$registered = 'display:none';
										$newly = 'display:block';
									}
								?>

								<div id="registered" style="<?= $registered ?>">
									<table class="table table-striped tbl-card">
										<thead>
											<tr>
												<th>削除</th>
												<th>選択</th>
												<th>カード番号</th>
												<th>有効期限</th>
												<th>名義人</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach( $CARD as $card_val ): ?>
												<tr>
													<td>
														<a href="<?= site_url('order/remove_card/' . $card_val['CardSeq']) ?>">
															<i class="fas fa-times"></i>
														</a>
													</td>
													<td>
														<?php echo form_radio(array(
															'name'			=> 'registered_card',
															'value'			=> $card_val['CardSeq'],
															'data-cardno'	=> $card_val['CardNo']
														)); ?>
													</td>
													<td><?= $card_val['CardNo'] ?></td>
													<td>
														<?= substr($card_val['Expire'], 2, 2) ?>月&nbsp;/&nbsp;
														<?= substr($card_val['Expire'], 0, 2) ?>年
													</td>
													<td><?= $card_val['HolderName'] ?></td>
												</tr>
											<?php endforeach; ?>
										</tbody>
									</table>

									<?php echo form_button(array(
										'name'		=> 'btn-other-card',
										'content'	=> 'その他のカードでお支払い',
										'class'		=> 'btn btn-info mt-3',
										'onclick'	=> 'change_card(1);'
									)); ?>
								</div> <!-- end of #registered -->

								<div id="newly" style="<?= $newly ?>">
									<dl class="dl-credit">
										<dt>カード番号</dt>
										<dd>
											<?php echo form_input(array(
												'name'			=> 'number',
												'id'			=> 'number',
												'placeholder'	=> '1111222233334444'
											)); ?>
										</dd>

										<dt>ｾｷｭﾘﾃｨｺｰﾄﾞ</dt>
										<dd>
											<?php echo form_input(array(
												'name'			=> 'security_code',
												'id'			=> 'security_code',
												'placeholder'	=> '123'
											)); ?>
											※主にカード裏面にある３～４桁の数字をご入力ください。
										</dd>

										<dt>有効期限</dt>
										<dd>
											<?php echo form_dropdown('limit_m', $MM, '', 'id="limit_m"'); ?>月&nbsp;/&nbsp;
											20<?php echo form_dropdown('limit_y', $YY, '', 'id="limit_y"'); ?>年
										</dd>

										<dt>名義人</dt>
										<dd>
											<?php echo form_input(array(
												'name'			=> 'holder',
												'id'			=> 'holder',
												'placeholder'	=> 'TARO YAMADA'
											)); ?>
										</dd>

										<dt>カード情報登録</dt>
										<dd>
											<?php echo form_checkbox(array(
												'name'	=> 'chk_register',
												'id'	=> 'chk_register',
												'value'	=> '1'
											)); ?>
											<?php echo form_label('このクレジットカード情報を登録する', 'chk_register'); ?><br>
											※クレジットカード情報を登録すると、次回購入時にクレジットカード情報を入力する必要がありません。
										</dd>
									</dl>

									<?php if( !empty($CARD) ): ?>
										<?php echo form_button(array(
											'name'		=> 'btn-other-card',
											'content'	=> '登録済みカードでお支払い',
											'class'		=> 'btn btn-info mt-3',
											'onclick'	=> 'change_card(2);'
										)); ?>
									<?php endif; ?>
								</div> <!-- end of #newly -->

								<div class="attention-box">
									クレジットカード決済は、クレジットカード決済代行のGMOペイメントゲートウェイ株式会社の決済代行サービスを利用しております。<br>
									安心してお支払いをしていただくために、お客様の情報は暗号化して送信し、クレジットカード情報は当サイトでは保有せず、同社で厳重に管理しております。
								</div>
							<?php echo form_fieldset_close(); ?>
						</dd>
					</dl>

					<dl class="others">
						<dt>お届け日</dt>
						<dd>
							<?php echo form_dropdown('delivery_date', $SELECT_DATE, $DELIVERY_DATE, 'class="select-other" tabindex="' . $i++ . '"'); ?>
						</dd>
					</dl>

					<dl class="others">
						<dt>お届け時間</dt>
						<dd>
							<?php echo form_dropdown('delivery_time', $CONF['delivery_time'], $DELIVERY_TIME, 'class="select-other" tabindex="' . $i++ . '"'); ?>
						</dd>
					</dl>

					<dl class="others">
						<dt>備考</dt>
						<dd>
							<?php echo form_textarea(array(
								'name'	=> 'note',
								'class'	=> 'textarea-other',
								'value'	=> $NOTE,
								'placeholder'	=> 'その他ご要望がございましたら、ご記入ください。'
							)); ?><br>
							※登録のない市販教材をご注文いただく際は、<span class="attention-msg">必ずISBNコードを合わせてご記入ください</span>。<br>
							　ISBNコードのご記入が無い場合、受注できないことがございます。
						</dd>
					</dl>

					<div class="text-center mt-5 mb-5">
						<?php echo form_button(array(
							'name'		=> 'btn-submit',
							'content'	=> '　確認　',
							'class'		=> 'btn btn-success mt-5',
							'onclick'	=> 'do_submit()'
						)); ?>
					</div>
				<?php echo form_close(); ?>
			<?php endif; ?>
		</div> <!-- end of .container -->

		<?php $this->load->view('inc/_foot'); ?>
		<?php $this->load->view('inc/footer'); ?>
	</div> <!-- end of #wrapper -->

	<script src="https://stg.static.mul-pay.jp/ext/js/token.js"></script>
	<script src="<?= base_url('js/front.order.js') ?>?var=<?= CACHES_CLEAR_VERSION ?>"></script>
</body>
</html>
