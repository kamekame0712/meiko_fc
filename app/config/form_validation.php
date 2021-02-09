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

);
