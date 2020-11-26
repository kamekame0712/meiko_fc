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
  `meiko_code` varchar(16) DEFAULT NULL COMMENT '明光教材コード',
  `smile_code` varchar(32) DEFAULT NULL COMMENT 'SMILEの商品コード',
  `name` varchar(128) NOT NULL COMMENT '商品名',
  `normal_price` int(5) DEFAULT 0 COMMENT '通常価格',
  `sales_price` int(5) DEFAULT 0 COMMENT '販売価格',
  `recommend` varchar(1) DEFAULT '9' COMMENT '明光本部推奨教材 1:推奨 9:非推奨',
  `grade` varchar(16) DEFAULT NULL COMMENT '学年等（config参照）',
  `subject` varchar(16) DEFAULT NULL COMMENT '教科（config参照）',
  `period` varchar(4) DEFAULT NULL COMMENT '期間講習（config参照）',
  `publisher` varchar(4) DEFAULT NULL COMMENT '出版社（config参照）',
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
  `parent_id` int(7) NOT NULL COMMENT '親教室のclassroom_id（親自身はclassroom_idと同じ）',
  `email` varchar(256) DEFAULT NULL COMMENT 'メールアドレス',
  `password` varchar(256) NOT NULL COMMENT 'パスワード',
  `gmo_member_id` varchar(64) DEFAULT NULL COMMENT 'GMO登録ID',
  `regist_time` datetime NOT NULL COMMENT '登録日',
  `update_time` datetime NOT NULL COMMENT '更新日',
  `status` varchar(1) DEFAULT '0' COMMENT '状態 0:通常 9:削除済',

  PRIMARY KEY (classroom_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `t_order` (
  `order_id` int(7) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `classroom_id` int(7) NOT NULL COMMENT 't_classroomのID',
  `payment_method` varchar(1) NOT NULL COMMENT '支払方法 1:掛け 2:クレジットカード 3:代引き',
  `delivery_date` date DEFAULT NULL COMMENT 'お届け日',
  `delivery_time` varchar(1) DEFAULT NULL COMMENT 'お届け時間 NULL:指定なし 1:午前 2:14～16時 3:16～18時 4:18～20時 5:19～21時',
  `memo` text DEFAULT '' COMMENT '備考',
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

CREATE TABLE `t_account` (
  `account_id` int(7) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `classroom_id` int(7) NOT NULL COMMENT 't_classroomのID',
  `corporation` varchar(1) NOT NULL COMMENT '事業形態 1:法人 2:非法人',
  `name` varchar(128) NOT NULL COMMENT '法人名（代表者名）',
  `zip1` varchar(3) NOT NULL COMMENT '郵便番号',
  `zip2` varchar(4) NOT NULL COMMENT '郵便番号',
  `pref` varchar(2) NOT NULL COMMENT '都道府県コード',
  `addr1` varchar(128) NOT NULL COMMENT '住所',
  `addr2` varchar(128) NOT NULL COMMENT '住所',
  `tel1` varchar(8) NOT NULL COMMENT '電話番号',
  `tel2` varchar(8) NOT NULL COMMENT '電話番号',
  `tel3` varchar(8) NOT NULL COMMENT '電話番号',
  `executive` varchar(64) DEFAULT NULL COMMENT '法人代表者名',
  `payment_method` varchar(1) NOT NULL COMMENT '支払方法 1:振込 2:口座引落',
  `transfer_name` varchar(128) DEFAULT NULL COMMENT '振込名義',
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
