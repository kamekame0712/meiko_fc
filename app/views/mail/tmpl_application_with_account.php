明光ジャパンFC専用発注システムのご利用申込みがありました。
※掛け申請有り

//////////////////////////
//     オーナー情報     //
//////////////////////////

◯オーナー名
<?= $OWNER['owner_name'] . "\r\n" ?>

<?php if( !empty($OWNER['corpo_name']) ): ?>
◯法人名
<?= $OWNER['corpo_name'] . "\r\n" ?>

<?php endif; ?>
◯住所
〒<?= $OWNER['zip1'] ?>-<?= $OWNER['zip2'] ?>
<?= $CONF['pref'][$OWNER['pref']] ?><?= $OWNER['addr1'] ?><?= $OWNER['addr2'] . "\r\n" ?>

◯電話番号
<?= $OWNER['tel1'] ?>-<?= $OWNER['tel2'] ?>-<?= $OWNER['tel3'] . "\r\n" ?>

<?php if( !empty($OWNER['fax1']) ): ?>
◯FAX番号
<?= $OWNER['fax1'] ?>-<?= $OWNER['fax2'] ?>-<?= $OWNER['fax3'] . "\r\n" ?>

<?php endif; ?>
◯メールアドレス
<?= $OWNER['email'] . "\r\n" ?>

◯運営教室
<?= $classroom_name . "\r\n" ?>

◯お支払方法
<?= $payment_method . "\r\n" ?>


//////////////////////////
//     掛け登録情報     //
//////////////////////////

◯事業形態
<?= ( $corporation == '1' ? '法人' : '非法人' ) . "\r\n" ?>

◯法人名または代表者名
<?= $corpo_name . "\r\n" ?>

◯法人代表者名
<?= $executive . "\r\n" ?>

◯住所
〒<?= $zip1 ?>-<?= $zip2 ?>
<?= $CONF['pref'][$pref] ?><?= $addr1 ?><?= $addr2 . "\r\n" ?>

◯電話番号
<?= $tel1 ?>-<?= $tel2 ?>-<?= $tel3 . "\r\n" ?>

<?php if( !empty($fax1) ): ?>
◯FAX番号
<?= $fax1 ?>-<?= $fax2 ?>-<?= $fax3 . "\r\n" ?>

<?php endif; ?>
◯請求先
<?= ( $bill_to == '1' ? '上記と同じ' : '上記とは別' ) . "\r\n" ?>

◯決済方法
<?= ( $settlement_method == '1' ? '振込' : '口座引落' ) . "\r\n" ?>

<?php if( $settlement_method == '1' ): ?>
◯お振込み名義
<?= $transfer_name . "\r\n" ?>

<?php else: ?>
◯金融機関名
<?= $bank_name . "\r\n" ?>

<?php endif; ?>


なお、このメールにお心当たりの無い方はお手数ですが、メールの削除をお願いします。

─────−- -  -　　　　　　　　　　　　-  - -−─────
　中央教育研究所株式会社

　　〒730-0013
　　広島市中区八丁堀15番6号 広島ちゅうぎんビル3階
　　TEL:082-227-3999
─────−- -  -　　　　　　　　　　　　-  - -−─────
