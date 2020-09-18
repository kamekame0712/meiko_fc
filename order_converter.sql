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

CREATE TABLE `t_publisher` (
  `publisher_id` int(7) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(128) NOT NULL COMMENT '出版社名',
  `handling` varchar(1) NOT NULL COMMENT '取扱い 1:塾用 2:市販',
  `regist_time` datetime NOT NULL COMMENT '登録日',
  `update_time` datetime NOT NULL COMMENT '更新日',
  `status` varchar(1) DEFAULT '0' COMMENT '状態 0:通常 9:削除済',

  PRIMARY KEY (publisher_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `t_product` (
  `product_id` int(7) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `code_smile` varchar(32) NOT NULL COMMENT 'SMILEコード',
  `name` varchar(128) NOT NULL COMMENT 'テキスト名',
  `publisher_id` int(7) NOT NULL COMMENT 't_publisherのID',
  `code_juku01` varchar(32) DEFAULT NULL COMMENT '塾専用の商品コード1',
  `code_juku02` varchar(32) DEFAULT NULL COMMENT '塾専用の商品コード2',
  `code_juku03` varchar(32) DEFAULT NULL COMMENT '塾専用の商品コード3',
  `code_juku04` varchar(32) DEFAULT NULL COMMENT '塾専用の商品コード4',
  `code_juku05` varchar(32) DEFAULT NULL COMMENT '塾専用の商品コード5',
  `code_juku06` varchar(32) DEFAULT NULL COMMENT '塾専用の商品コード6',
  `code_juku07` varchar(32) DEFAULT NULL COMMENT '塾専用の商品コード7',
  `code_juku08` varchar(32) DEFAULT NULL COMMENT '塾専用の商品コード8',
  `code_juku09` varchar(32) DEFAULT NULL COMMENT '塾専用の商品コード9',
  `code_juku10` varchar(32) DEFAULT NULL COMMENT '塾専用の商品コード10',
  `regist_time` datetime NOT NULL COMMENT '登録日',
  `update_time` datetime NOT NULL COMMENT '更新日',
  `status` varchar(1) DEFAULT '0' COMMENT '状態 0:通常 9:削除済',

  PRIMARY KEY (product_id),
  FOREIGN KEY publisher_id(`publisher_id`) REFERENCES t_publisher(`publisher_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `t_seigakusha` (
  `order_id` int(7) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `classification` varchar(8) DEFAULT NULL COMMENT '通年／講習',
  `classroom_seigakusha` varchar(8) DEFAULT NULL COMMENT '成学社教室コード',
  `classroom` varchar(64) DEFAULT NULL COMMENT '教室名',
  `subject` varchar(8) DEFAULT NULL COMMENT '教科',
  `price` int DEFAULT 0 COMMENT '卸値',
  `classroom_chuoh` varchar(16) DEFAULT NULL COMMENT '業者教室ｺｰﾄﾞ',
  `code_smile` varchar(32) DEFAULT NULL COMMENT '業者教材ｺｰﾄﾞ',
  `order_num` varchar(16) DEFAULT NULL COMMENT '申込番号',
  `report_num` varchar(32) DEFAULT NULL COMMENT '申込書番号',
  `apply_date` varchar(16) DEFAULT NULL COMMENT '申込登録日',
  `charge` varchar(32) DEFAULT NULL COMMENT '教室担当者',
  `student_num` varchar(16) DEFAULT NULL COMMENT '学籍番号',
  `student_name` varchar(32) DEFAULT NULL COMMENT '生徒氏名',
  `grade` varchar(8) DEFAULT NULL COMMENT '学年',
  `product_code` varchar(8) DEFAULT NULL COMMENT '成学社教材ｺｰﾄﾞ',
  `product_name` varchar(128) DEFAULT NULL COMMENT '教材名',
  `publisher` varchar(32) DEFAULT NULL COMMENT '出版社',
  `quantity` int DEFAULT 0 COMMENT '冊数',
  `publisher_id` int(7) DEFAULT NULL COMMENT 't_publisherのID',
  `order_date` date NOT NULL COMMENT '受注日',
  `shipping_date` date NOT NULL COMMENT '出荷日',
  `regist_time` datetime NOT NULL COMMENT '登録日',
  `update_time` datetime NOT NULL COMMENT '更新日',
  `status` varchar(1) DEFAULT '0' COMMENT '状態 0:通常 9:削除済',

  PRIMARY KEY (order_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `t_seigakusha_stock` (
  `stock_id` int(7) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `product_id` int(7) NOT NULL COMMENT 't_productのID',
  `stock` int DEFAULT 0 COMMENT '在庫数',
  `regist_time` datetime NOT NULL COMMENT '登録日',
  `update_time` datetime NOT NULL COMMENT '更新日',
  `status` varchar(1) DEFAULT '0' COMMENT '状態 0:通常 9:削除済',

  PRIMARY KEY (stock_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
