<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//****** メール関連config ******

$config['mail'] = array(

	// 管理画面から管理者へ
	'management_to_admin' => array(
		'from'		=> 'info@kyouzai.info',
		'from_name'	=> '明光FC専用受注管理'
	),

	// システムから顧客へ
	'apply_comp_to_customer' => array(
		'from'		=> 'meiko-fc@kyouzai.info',
		'from_name'	=> '明光FC専用発注システム'
	),

	// 顧客登録から管理者へ
	'entry_to_admin' => array(
		'from'		=> 'info@kyouzai.info',
		'from_name'	=> '明光FC専用受注管理',
		'to'		=> 's-kamei@chuoh-kyouiku.co.jp'
	),

);
