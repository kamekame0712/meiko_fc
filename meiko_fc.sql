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
  `parent_id` int(7) NOT NULL COMMENT '親教室のclassroom_id（親自身はclassroom_idと同じ）',
  `email` varchar(256) DEFAULT NULL COMMENT 'メールアドレス',
  `password` varchar(256) NOT NULL COMMENT 'パスワード',
  `gmo_member_id` varchar(64) DEFAULT NULL COMMENT 'GMO登録ID',
  `regist_time` datetime NOT NULL COMMENT '登録日',
  `update_time` datetime NOT NULL COMMENT '更新日',
  `status` varchar(1) DEFAULT '0' COMMENT '状態 0:通常 9:削除済',

  PRIMARY KEY (classroom_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

