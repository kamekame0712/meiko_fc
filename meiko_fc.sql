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

