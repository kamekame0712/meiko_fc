<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(

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


);
