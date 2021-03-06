<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta name="description" content="納品書">
	<title>納品書</title>
	<link type="text/css" rel="stylesheet" href="<?= base_url('css/style.pdf.css') ?>">
</head>

<body>
	<div style="position:absolute; top:10px; right:10px;">
		<img src="<?= base_url('img/common/logo-meiko.png') ?>" alt="明光義塾" class="logo-meiko">
	</div>

	<table class="title-box">
		<tr>
			<td class="dummy">&nbsp;</td>
			<td class="title"><?= $TITLE ?></td>
			<td class="dummy">&nbsp;</td>
		</tr>
	</table>

	<p class="classroom-name"><?= $NAME ?></p>

	<table class="info">
		<tr>
			<td class="juku-info">
				<p>〒<?= $ZIP ?></p>
				<p><?= $ADDRESS ?></p>
				<p><?= $TEL ?></p><br><br>
				<p style="font-size: 1.5rem; font-weight: bold; border-bottom: 1px solid #404040; text-align: right;">　総合計金額　　<?= number_format($TOTAL) ?>円　</p>
			</td>
			<td class="other-info">
				<p>ENコード（掛）：<?= $EN_CODE1 ?></p>
				<p>ENコード（ｸﾚｼﾞｯﾄ）：<?= $EN_CODE2 ?></p><br>
				<p>前回の注文：<?= $PREV ?></p><br>
				<p>注文日：<?= $REGIST ?></p>
				<p>注文番号：<?= $ORDER_ID ?></p>
			</td>
		</tr>
	</table>

	<table class="detail">
		<thead>
			<tr>
				<th>出版社名&nbsp;/&nbsp;商品名&nbsp;/&nbsp;商品コード</th>
				<th>数量</th>
				<th>単価</th>
				<th>金額（税込）</th>
			</tr>
		</thead>

		<tbody>
			<?php foreach( $DETAIL as $val ): ?>
				<tr>
					<td><?= $val['publisher_name'] ?>&nbsp;/&nbsp;<?= $val['product_name'] ?>&nbsp;/&nbsp;<?= $val['smile_code'] ?></td>
					<td style="text-align:right;"><?= $val['quantity'] ?></td>
					<td style="text-align:right;"><?= number_format($val['sales_price']) ?>円</td>
					<td style="text-align:right;"><?= number_format($val['sub_total']) ?>円</td>
				</tr>
			<?php endforeach; ?>

			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>

			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td style="text-align:right;">商品合計</td>
				<td style="text-align:right;"><?= number_format($SUB_TOTAL) ?>円</td>
			</tr>

			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td style="text-align:right;">送料</td>
				<td style="text-align:right;"><?= number_format($SHIPPING) ?>円</td>
			</tr>

			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td style="text-align:right;">手数料</td>
				<td style="text-align:right;"><?= number_format($COMMISSION) ?>円</td>
			</tr>

			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td style="text-align:right;">請求金額</td>
				<td style="text-align:right;"><?= number_format($TOTAL) ?>円</td>
			</tr>
		</tbody>

	</table>

	<table class="note-box">
		<tr>
			<td class="dummy">&nbsp;</td>
			<td class="note">備考：<br><br><?= nl2br($NOTE) ?></td>
			<td class="dummy">&nbsp;</td>
		</tr>
	</table>
</body>
</html>
