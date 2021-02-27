<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(

	// ログイン（フロント）
	'login' => array(
		array(
			'field' => 'email',
			'label' => 'メールアドレス',
			'rules' => 'required'
		),

		array(
			'field' => 'password',
			'label' => 'パスワード',
			'rules' => 'required|callback_possible_login'
		)
	),

	// ログイン（管理画面）
	'login_admin' => array(
		array(
			'field' => 'email',
			'label' => 'メールアドレス',
			'rules' => 'required'
		),

		array(
			'field' => 'password',
			'label' => 'パスワード',
			'rules' => 'required|callback_possible_admin_login'
		)
	),

	// ご利用申込み
	'application' => array(
		array(
			'field' => 'owner_name',
			'label' => 'オーナー名',
			'rules' => 'required'
		),

		array(
			'field' => 'zip1',
			'label' => '郵便番号',
			'rules' => 'callback_chk_zip'
		),

		array(
			'field' => 'pref',
			'label' => '住所',
			'rules' => 'callback_chk_address'
		),

		array(
			'field' => 'tel1',
			'label' => '電話番号',
			'rules' => 'callback_chk_tel'
		),

		array(
			'field' => 'email',
			'label' => 'メールアドレス',
			'rules' => 'required|valid_email'
		),

		array(
			'field' => 'classroom_number[]',
			'label' => '運営教室',
			'rules' => 'callback_chk_classroom_number'
		),

		array(
			'field' => 'payment_method1',
			'label' => 'お支払方法',
			'rules' => 'callback_chk_payment_method'
		)
	),

	// お客様情報登録
	'entry' => array(
		array(
			'field' => 'classroom_number',
			'label' => '教室コード',
			'rules' => 'required|callback_possible_enter_classroom_number'
		),

		array(
			'field' => 'email',
			'label' => 'メールアドレス',
			'rules' => 'required|valid_email|callback_exists_email_classroom'
		),

		array(
			'field' => 'password_show',
			'label' => 'パスワード',
			'rules' => 'required|min_length[8]'
		)
	),

	// 教室登録
	'admin/classroom' => array(
		array(
			'field' => 'name',
			'label' => '教室名',
			'rules' => 'required'
		),

		array(
			'field' => 'pref',
			'label' => '都道府県',
			'rules' => 'required'
		),

		array(
			'field' => 'classroom_number',
			'label' => '教室番号（明光側コード）',
			'rules' => 'required|callback_chk_usable_classroom_number'
		)
	),

	// 教材登録
	'admin/product' => array(
		array(
			'field' => 'name',
			'label' => '教材名',
			'rules' => 'required'
		),

		array(
			'field' => 'smile_code',
			'label' => 'SMILEコード',
			'rules' => 'callback_exists_smile_code'
		),

		array(
			'field' => 'normal_price',
			'label' => '通常価格',
			'rules' => 'numeric'
		),

		array(
			'field' => 'sales_price',
			'label' => '販売価格',
			'rules' => 'required|numeric'
		),

		array(
			'field' => 'flg_market',
			'label' => '塾用/市販',
			'rules' => 'required'
		),

		array(
			'field' => 'flg_sales',
			'label' => '発刊状況',
			'rules' => 'required'
		)
	),
);
