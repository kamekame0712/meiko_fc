ALTER TABLE t_order ADD `exists_market` varchar(1) DEFAULT '1' COMMENT '市販教材の有無 1:無 2:有' AFTER `classroom_id`;
ALTER TABLE t_order ADD `flg_partial` varchar(1) DEFAULT '1' COMMENT '分納希望 1:全納 2:分納' AFTER `exists_market`;
