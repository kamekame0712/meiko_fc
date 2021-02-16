<?php

class M_classroom extends MY_Model
{
	// テーブル名
	const TBL  = 't_classroom';

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

		$classroom_data = $this->get_list(array('email' => $email));
		if( empty($classroom_data) || count($classroom_data) > 1 ) {
			return FALSE;
		}

		if( empty($classroom_data[0]['owner_id']) ) {
			return FALSE;
		}

		if( empty($classroom_data[0]['smile_code1']) && empty($classroom_data[0]['smile_code2']) && empty($classroom_data[0]['smile_code3']) ) {
			return FALSE;
		}

		$hashedPassword = $classroom_data[0]['password'];
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
