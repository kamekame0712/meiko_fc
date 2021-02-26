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

	public function get_list_bootgrid($conditions = array(), $sort_str = '', $limit_array = '')
	{
		$where_array = $this->get_where($conditions);
		$where = implode(' AND ', $where_array);
		$select = 'c.*, o.owner_name, o.corpo_name';

		$this->db->from(SELF::TBL . ' c')->select($select)->distinct()
			 ->join('t_owner o', 'o.owner_id = c.owner_id AND o.status = "0"', 'left')
			 ->where($where)->order_by($sort_str);

		if( is_array($limit_array) && !empty($limit_array) ) {
			$this->db->limit($limit_array[0], $limit_array[1]);
		}

		$query = $this->db->get();
		$data = ($query->num_rows() > 0) ? $query->result_array() : FALSE;

		$this->db->from(SELF::TBL . ' c')->select($select)->distinct()
			 ->join('t_owner o', 'o.owner_id = c.owner_id AND o.status = "0"', 'left')
			 ->where($where);

		$cnt = 0;
		$query = $this->db->get();
		if( $query->num_rows() > 0 ) {
			$wk = $query->result_array();
			if( !empty($wk) ) {
				$cnt = count($wk);
			}
		}

		return array($data, $cnt);
	}

	private function get_where($conditions)
	{
		 $ret_array = array();
		 $ret_array[] = 'c.status = "0"';

		 if( $conditions['classroom_name'] != '' ) {
			$ret_array[] = 'c.name LIKE "%' . $conditions['classroom_name'] . '%"';
		}

		if( $conditions['owner_name'] != '' ) {
			$ret_array[] = 'o.owner_name LIKE "%' . $conditions['owner_name'] . '%"';
		}

		if( $conditions['corpo_name'] != '' ) {
			$ret_array[] = 'o.corpo_name LIKE "%' . $conditions['corpo_name'] . '%"';
		}

		if( $conditions['smile_code'] != '' ) {
			$ret_array[] = '( c.smile_code1 = "' . $conditions['smile_code'] . '" OR c.smile_code2 = "' . $conditions['smile_code'] . '" OR c.smile_code3 = "' . $conditions['smile_code'] . '" )';
		}

		if( $conditions['pref'] != '' ) {
			$ret_array[] = 'c.pref = "' . $conditions['pref'] . '"';
		}

		if( $conditions['tel'] != '' ) {
			$ret_array[] = 'c.tel LIKE "%' . $conditions['tel'] . '%"';
		}

		return $ret_array;
	}
}
