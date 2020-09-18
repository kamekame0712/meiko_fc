<?php

class M_admin extends MY_Model
{
	// テーブル名
	const TBL  = 't_admin';

	// パスワードに使う文字列
	private $pass_str = '23456789abcdefghjmnqrstuvyABCDEFGHJMNQRSTUVY';

	function __construct()
	{
		parent::__construct();
	}

	public function possible_login($email = '', $password = '')
	{
		if( $email == '' || $password == '' ) {
			return FALSE;
		}

		$admin_data = $this->get_list(array('email' => $email));
		if( empty($admin_data) || count($admin_data) > 1 ) {
			return FALSE;
		}

		$hashedPassword = $admin_data[0]['password'];
		if( empty($hashedPassword) ) {
			return FALSE;
		}

		if( password_verify($password, $hashedPassword) ) {
			return TRUE;
		}
		return FALSE;
	}

	function get_hashed_pass($plane_password)
	{
		return password_hash($plane_password, PASSWORD_DEFAULT);
	}

	public function create_password($length = 8)
	{
		return substr(str_shuffle($this->pass_str), 0, $length);
	}
}
