CREATE TABLE `t_admin` (
  `admin_id` int(7) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `email` varchar(256) DEFAULT NULL COMMENT 'メールアドレス',
  `password` varchar(256) NOT NULL COMMENT 'パスワード',
  `name` varchar(128) NOT NULL COMMENT '管理者名',
  `regist_time` datetime NOT NULL COMMENT '登録日',
  `update_time` datetime NOT NULL COMMENT '更新日',
  `status` varchar(1) DEFAULT '0' COMMENT '状態 0:通常 9:削除済',

  PRIMARY KEY (admin_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `t_product` (
  `product_id` int(7) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `smile_code` varchar(32) DEFAULT NULL COMMENT 'SMILEの商品コード',
  `name` varchar(128) NOT NULL COMMENT '商品名',
  `keyword` varchar(256) DEFAULT NULL COMMENT '検索用キーワード',
  `normal_price` int(5) DEFAULT 0 COMMENT '通常価格',
  `sales_price` int(5) DEFAULT 0 COMMENT '販売価格',
  `recommend` varchar(1) DEFAULT '9' COMMENT '明光本部推奨教材 1:推奨 9:非推奨',
  `grade` varchar(16) DEFAULT NULL COMMENT '学年等（config参照）',
  `subject` varchar(16) DEFAULT NULL COMMENT '教科（config参照）',
  `period` varchar(4) DEFAULT NULL COMMENT '期間講習（config参照）',
  `publisher` varchar(4) DEFAULT NULL COMMENT '出版社（config参照）',
  `flg_market` varchar(1) DEFAULT '1' COMMENT '1:市販教材 2:塾用教材',
  `flg_sales` varchar(1) DEFAULT '1' COMMENT '販売フラグ 1:通常（販売可） 2:売切 3:未発刊',
  `regist_time` datetime NOT NULL COMMENT '登録日',
  `update_time` datetime NOT NULL COMMENT '更新日',
  `status` varchar(1) DEFAULT '0' COMMENT '状態 0:通常 9:削除済',

  PRIMARY KEY (product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `t_classroom` (
  `classroom_id` int(7) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `classroom_number` varchar(16) DEFAULT NULL COMMENT '明光教室コード',
  `smile_code1` varchar(16) DEFAULT NULL COMMENT 'SMILEの顧客コード（掛）',
  `smile_code2` varchar(16) DEFAULT NULL COMMENT 'SMILEの顧客コード（ｸﾚｼﾞｯﾄ）',
  `smile_code3` varchar(16) DEFAULT NULL COMMENT 'SMILEの顧客コード（代引）',
  `name` varchar(64) NOT NULL COMMENT '教室名',
  `zip` varchar(8) DEFAULT NULL COMMENT '郵便番号',
  `pref` varchar(2) NOT NULL COMMENT '都道府県コード',
  `address` varchar(256) DEFAULT NULL COMMENT '住所',
  `tel` varchar(16) DEFAULT NULL COMMENT '電話番号',
  `owner_id` int(7) DEFAULT NULL COMMENT 't_ownerのID',
  `email` varchar(256) DEFAULT NULL COMMENT 'メールアドレス',
  `password` varchar(256) NOT NULL COMMENT 'パスワード',
  `gmo_member_id` varchar(64) DEFAULT NULL COMMENT 'GMO登録ID',
  `flg_instruction` varchar(1) DEFAULT '1' COMMENT '操作方法の表示 1:表示 2:非表示',
  `regist_time` datetime NOT NULL COMMENT '登録日',
  `update_time` datetime NOT NULL COMMENT '更新日',
  `status` varchar(1) DEFAULT '0' COMMENT '状態 0:通常 9:削除済',

  PRIMARY KEY (classroom_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `t_order` (
  `order_id` int(7) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `classroom_id` int(7) NOT NULL COMMENT 't_classroomのID',
  `exists_market` varchar(1) DEFAULT '0' COMMENT '市販教材の有無 0:無 1:有',
  `flg_partial` varchar(1) DEFAULT '0' COMMENT '分納希望 0:全納 1:分納',
  `payment_method` varchar(1) NOT NULL COMMENT '支払方法 1:掛け 2:クレジットカード 3:代引き',
  `delivery_date` date DEFAULT NULL COMMENT 'お届け日',
  `delivery_time` varchar(1) DEFAULT NULL COMMENT 'お届け時間 NULL:指定なし 1:午前 2:14～16時 3:16～18時 4:18～20時 5:19～21時',
  `note` text DEFAULT '' COMMENT '備考',
  `shipping_fee` int DEFAULT 0 COMMENT '送料',
  `sub_total` int DEFAULT 0 COMMENT '小計',
  `total_cost` int DEFAULT 0 COMMENT '合計金額',
  `regist_time` datetime NOT NULL COMMENT '登録日',
  `update_time` datetime NOT NULL COMMENT '更新日',
  `status` varchar(1) DEFAULT '0' COMMENT '状態 0:通常 9:削除済',

  PRIMARY KEY (order_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `t_order_detail` (
  `order_detail_id` int(7) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `order_id` int(7) NOT NULL COMMENT 't_orderのID',
  `product_id` int(7) NOT NULL COMMENT 't_productのID',
  `quantity` int DEFAULT 0 COMMENT '数量',
  `publisher_name` varchar(64) NOT NULL COMMENT '出版社名',
  `product_name` varchar(128) NOT NULL COMMENT '商品名',
  `sales_price` int(5) DEFAULT 0 COMMENT '販売価格',
  `sub_total` int DEFAULT 0 COMMENT '小計',
  `regist_time` datetime NOT NULL COMMENT '登録日',
  `update_time` datetime NOT NULL COMMENT '更新日',
  `status` varchar(1) DEFAULT '0' COMMENT '状態 0:通常 9:削除済',

  PRIMARY KEY (order_detail_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `t_owner` (
  `owner_id` int(7) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `owner_name` varchar(64) NOT NULL COMMENT 'オーナー名',
  `corpo_name` varchar(128) DEFAULT NULL COMMENT '法人名',
  `zip1` varchar(3) NOT NULL COMMENT '郵便番号',
  `zip2` varchar(4) NOT NULL COMMENT '郵便番号',
  `pref` varchar(2) NOT NULL COMMENT '都道府県コード',
  `addr1` varchar(128) NOT NULL COMMENT '住所',
  `addr2` varchar(128) NOT NULL COMMENT '住所',
  `tel1` varchar(8) NOT NULL COMMENT '電話番号',
  `tel2` varchar(8) NOT NULL COMMENT '電話番号',
  `tel3` varchar(8) NOT NULL COMMENT '電話番号',
  `fax1` varchar(8) DEFAULT NULL COMMENT 'FAX番号',
  `fax2` varchar(8) DEFAULT NULL COMMENT 'FAX番号',
  `fax3` varchar(8) DEFAULT NULL COMMENT 'FAX番号',
  `email` varchar(256) DEFAULT NULL COMMENT 'メールアドレス',
  `payment_method1` varchar(1) DEFAULT '0' COMMENT '掛け 0:利用しない 1:利用する',
  `payment_method2` varchar(1) DEFAULT '0' COMMENT 'クレジットカード 0:利用しない 1:利用する',
  `payment_method3` varchar(1) DEFAULT '0' COMMENT '代引き 0:利用しない 1:利用する',
  `regist_time` datetime NOT NULL COMMENT '登録日',
  `update_time` datetime NOT NULL COMMENT '更新日',
  `status` varchar(1) DEFAULT '0' COMMENT '状態 0:通常 9:削除済',

  PRIMARY KEY (owner_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `t_account` (
  `account_id` int(7) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `owner_id` int(7) NOT NULL COMMENT 't_ownerのID',
  `corporation` varchar(1) NOT NULL COMMENT '事業形態 1:法人 2:非法人',
  `corpo_name` varchar(128) NOT NULL COMMENT '法人名（非法人の場合は代表者名）',
  `executive` varchar(64) DEFAULT NULL COMMENT '法人の場合の代表者名',
  `zip1` varchar(3) NOT NULL COMMENT '郵便番号',
  `zip2` varchar(4) NOT NULL COMMENT '郵便番号',
  `pref` varchar(2) NOT NULL COMMENT '都道府県コード',
  `addr1` varchar(128) NOT NULL COMMENT '住所',
  `addr2` varchar(128) NOT NULL COMMENT '住所',
  `tel1` varchar(8) NOT NULL COMMENT '電話番号',
  `tel2` varchar(8) NOT NULL COMMENT '電話番号',
  `tel3` varchar(8) NOT NULL COMMENT '電話番号',
  `fax1` varchar(8) DEFAULT NULL COMMENT 'FAX番号',
  `fax2` varchar(8) DEFAULT NULL COMMENT 'FAX番号',
  `fax3` varchar(8) DEFAULT NULL COMMENT 'FAX番号',
  `bill_to` varchar(1) DEFAULT NULL COMMENT '請求先 1:申請先と同じ 2:申請先とは別',
  `bill_name` varchar(128) NOT NULL COMMENT '請求先名',
  `bill_zip1` varchar(3) NOT NULL COMMENT '請求先郵便番号',
  `bill_zip2` varchar(4) NOT NULL COMMENT '請求先郵便番号',
  `bill_pref` varchar(2) NOT NULL COMMENT '請求先都道府県コード',
  `bill_addr1` varchar(128) NOT NULL COMMENT '請求先住所',
  `bill_addr2` varchar(128) NOT NULL COMMENT '請求先住所',
  `bill_tel1` varchar(8) NOT NULL COMMENT '請求先電話番号',
  `bill_tel2` varchar(8) NOT NULL COMMENT '請求先電話番号',
  `bill_tel3` varchar(8) NOT NULL COMMENT '請求先電話番号',
  `bill_note` text DEFAULT '' COMMENT '備考',
  `settlement_method` varchar(1) NOT NULL COMMENT '決済方法 1:振込 2:口座引落',
  `transfer_name` varchar(128) DEFAULT NULL COMMENT '振込名義',
  `bank_name` varchar(128) DEFAULT NULL COMMENT '引落金融機関名',
  `regist_time` datetime NOT NULL COMMENT '登録日',
  `update_time` datetime NOT NULL COMMENT '更新日',
  `status` varchar(1) DEFAULT '0' COMMENT '状態 0:通常 9:削除済',

  PRIMARY KEY (account_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `t_forgot` (
  `forgot_id` int(7) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `classroom_id` int(7) NOT NULL COMMENT 't_classroomのID',
  `param` varchar(64) NOT NULL COMMENT 'パラメーター',
  `limit_time` datetime NOT NULL COMMENT '更新期限',
  `regist_time` datetime NOT NULL COMMENT '登録日',
  `update_time` datetime NOT NULL COMMENT '更新日',
  `status` varchar(1) DEFAULT '0' COMMENT '状態 0:通常 9:削除済',

  PRIMARY KEY (forgot_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

