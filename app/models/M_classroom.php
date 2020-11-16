<?php

class M_classroom extends MY_Model
{
	// テーブル名
	const TBL  = 't_classroom';

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
}
