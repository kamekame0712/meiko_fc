ALTER TABLE t_order ADD `exists_market` varchar(1) DEFAULT '1' COMMENT '市販教材の有無 1:無 2:有' AFTER `classroom_id`;
ALTER TABLE t_order ADD `flg_partial` varchar(1) DEFAULT '1' COMMENT '分納希望 1:全納 2:分納' AFTER `exists_market`;

ALTER TABLE t_owner ADD `flg_complete` varchar(1) DEFAULT '1' COMMENT '登録フラグ 1:未 2:完了' AFTER `payment_method3`;

ALTER TABLE t_order ADD `order_status` varchar(1) DEFAULT '0' COMMENT '対応状況 0:新規受付 8:キャンセル 9:取込済' AFTER `total_cost`;

ALTER TABLE `t_product` CHANGE `flg_market` `flg_market` VARCHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '1' COMMENT '1:塾用教材 2:市販教材';

ALTER TABLE t_classroom ADD  `en_code1` varchar(1) DEFAULT NULL COMMENT 'ENコード（掛） 1:有 2:無' AFTER `smile_code3`;
ALTER TABLE t_classroom ADD  `en_code2` varchar(1) DEFAULT NULL COMMENT 'ENコード（ｸﾚｼﾞｯﾄ） 1:有 2:無' AFTER `en_code1`;

ALTER TABLE t_order ADD `commission` int DEFAULT 0 COMMENT '代引手数料' AFTER `shipping_fee`;

