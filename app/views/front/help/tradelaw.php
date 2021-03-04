<?php $this->load->view('inc/_head', array('TITLE' => SITE_NAME)); ?>

<body>
	<div id="wrapper">
		<?php $this->load->view('inc/header', array('MENU' => TRUE)); ?>

		<div class="container">
			<p class="lead-title">特定商取引法に基づく表記</p>

			<table class="confirm-table mb-5">
				<tr>
					<th>販売業者</th>
					<td>中央教育研究所株式会社</td>
				</tr>

				<tr>
					<th>運営責任者</th>
					<td>梶浦真平</td>
				</tr>

				<tr>
					<th>本社所在地</th>
					<td>〒730-0013<br>広島県広島市中区八丁堀15番6号 広島ちゅうぎんビル3階 </td>
				</tr>

				<tr>
					<th>電話番号</th>
					<td>082-227-3999</td>
				</tr>

				<tr>
					<th>FAX番号</th>
					<td>082-227-4000</td>
				</tr>

				<tr>
					<th>メールアドレス</th>
					<td><a href="mailto:info@chuoh-kyouiku.co.jp">info@chuoh-kyouiku.co.jp</a></td>
				</tr>

				<tr>
					<th>URL</th>
					<td><a href="http://www.chuoh-kyouiku.com/" target="_blank">http://www.chuoh-kyouiku.com/></a></td>
				</tr>

				<tr>
					<th>商品以外の必要代金</th>
					<td>
						◯代金引換でご購入の際の代金引換手数料<br>
						◯郵送・運送にかかわらず、送料実費<br>
						※お買い上げ額10,000円以上（送料・手数料除く）で送料無料になります。
					</td>
				</tr>

				<tr>
					<th>支払方法</th>
					<td>
						オーナー様の設定により【買掛】【クレジットカード】【代金引換】のいずれかが選択できます。<br><br>
						※クレジットカードでのお支払いには、クレジットカード決済代行のGMOペイメントゲートウェイ株式会社の決済代行サービスを利用しております。<br>
						　安心してお支払いをしていただくために、お客様の情報がGMOペイメントゲートウェイ株式会社経由で送信される際には、
						SSLによる暗号化通信で行い、クレジットカード情報は当サイトでは保有せず、同社で厳重に管理しております。
					</td>
				</tr>

				<tr>
					<th>支払期限</th>
					<td>
						<dl>
							<dt class="font-weight-normal">◯買掛でのお取引</dt>
							<dd class="pl-5">オーナー様との契約により『月末締め、翌月20日払い』または『20日締め、翌月13日引落』</dd>
							<dt class="font-weight-normal">◯クレジットカードでのお取引</dt>
							<dd class="pl-5">ご利用になるクレジットカード会社との契約をご確認ください。</dd>
							<dt class="font-weight-normal">◯代金引換でのお取引</dt>
							<dd class="pl-5">商品と引き換えに代金を配送業者へお支払い下さい。（現金のみの取扱いとなります。）</dd>
						</dl>
					</td>
				</tr>

				<tr>
					<th>引渡し時期</th>
					<td>
						目安として<br>
						　塾用教材：4～5営業日<br>
						　市販教材：2週間程度
					</td>
				</tr>

				<tr>
					<th>返品・交換について</th>
					<td>
						<dl>
							<dt class="font-weight-normal">◯不良品</dt>
							<dd class="pl-5">商品に落丁、乱丁等が生じていた場合は当社にご連絡の上、着払いでお送り下さい。返品送料は当社が負担いたします。</dd>
							<dt class="font-weight-normal">◯返品期限</dt>
							<dd class="pl-5">商品到着後8日以内<br>（但し、お客様のご都合による返品はお受けできません。）</dd>
						</dl>
					</td>
				</tr>
			</table>
		</div> <!-- end of .container -->

		<?php $this->load->view('inc/_foot'); ?>
		<?php $this->load->view('inc/footer'); ?>
	</div> <!-- end of #wrapper -->
</body>
</html>
