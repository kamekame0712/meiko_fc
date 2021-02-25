<?php

class M_order extends MY_Model
{
	// テーブル名
	const TBL  = 't_order';

	function __construct()
	{
		parent::__construct();
	}

	public function get_one_with_detail($order_id = '')
	{
		$select = 'o.*, od.product_id, od.quantity, od.publisher_name, od.product_name, od.sales_price, od.sub_total';
		$where = array(
			'o.order_id'	=> $order_id,
			'o.status'		=> "0"
		);

		$this->db->from(SELF::TBL . ' o')->select($select)->where($where)
			 ->join('t_order_detail od', 'od.order_id = o.order_id AND od.status = "0"', 'left')
			 ->order_by('od.product_id ASC');

		$query = $this->db->get();
		$this->cnt = $query->num_rows();

		return ($this->cnt > 0) ? $query->result_array() : FALSE;
	}

	public function get_one_for_download($order_id = '')
	{
		$select = '
			o.*, p.smile_code, p.flg_market,
			c.smile_code1, c.smile_code2, c.smile_code3, c.en_code1, c.en_code2,
			c.name AS classroom_name, c.zip, c.pref, c.address, c.tel,
			od.product_id, od.quantity, od.publisher_name, od.product_name, od.sales_price, od.sub_total
		';

		$where = array(
			'o.order_id'	=> $order_id,
			'o.status'		=> "0"
		);

		$this->db->from(SELF::TBL . ' o')->select($select)->where($where)
			 ->join('t_classroom c', 'c.classroom_id = o.classroom_id AND c.status = "0"', 'left')
			 ->join('t_order_detail od', 'od.order_id = o.order_id AND od.status = "0"', 'left')
			 ->join('t_product p', 'p.product_id = od.product_id AND p.status = "0"', 'left')
			 ->order_by('p.smile_code ASC');

		$query = $this->db->get();
		$this->cnt = $query->num_rows();

		return ($this->cnt > 0) ? $query->result_array() : FALSE;
	}

	public function get_list_bootgrid($conditions = array(), $sort_str = '', $limit_array = '')
	{
		$where_array = $this->get_where($conditions);
		$where = implode(' AND ', $where_array);
		$select = 'o.*, c.smile_code1, c.smile_code2, c.smile_code3, c.name AS classroom_name';

		$this->db->from(SELF::TBL . ' o')->select($select)->distinct()
			 ->join('t_classroom c', 'c.classroom_id = o.classroom_id AND c.status = "0"', 'left')
			 ->where($where)->order_by($sort_str);

		if( is_array($limit_array) && !empty($limit_array) ) {
			$this->db->limit($limit_array[0], $limit_array[1]);
		}

		$query = $this->db->get();
		$data = ($query->num_rows() > 0) ? $query->result_array() : FALSE;

		$this->db->from(SELF::TBL . ' o')->select($select)->distinct()
			 ->join('t_classroom c', 'c.classroom_id = o.classroom_id AND c.status = "0"', 'left')
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
		 $ret_array[] = 'o.status = "0"';

		if( $conditions['order_id_from'] != '' ) {
			$ret_array[] = 'o.order_id >= ' . $conditions['order_id_from'];
		}

		if( $conditions['order_id_to'] != '' ) {
			$ret_array[] = 'o.order_id <= ' . $conditions['order_id_to'];
		}

		if( $conditions['classroom_name'] != '' ) {
			$ret_array[] = 'c.name LIKE "%' . $conditions['classroom_name'] . '%"';
		}

		if( $conditions['smile_code'] != '' ) {
			$ret_array[] = '( c.smile_code1 = "' . $conditions['smile_code'] . '" OR ' . 'c.smile_code2 = "' . $conditions['smile_code'] . '" OR ' . 'c.smile_code3 = "' . $conditions['smile_code'] . '" )';
		}

		if( $conditions['order_status'] != '' ) {
			$ret_array[] = 'o.order_status = ' . $conditions['order_status'];
		}

		$wk_payment_method_array = array();
		if( $conditions['payment_method1'] == '1' ) {
			$wk_payment_method_array[] = 'o.payment_method = "1"';
		}

		if( $conditions['payment_method2'] == '1' ) {
			$wk_payment_method_array[] = 'o.payment_method = "2"';
		}

		if( $conditions['payment_method3'] == '1' ) {
			$wk_payment_method_array[] = 'o.payment_method = "3"';
		}

		if( !empty($wk_payment_method_array) ) {
			$ret_array[] = '(' . implode(' OR ', $wk_payment_method_array) . ')';
		}

		if( $conditions['regist_time_from'] != '' ) {
			$ret_array[] = 'o.regist_time >= "' . $conditions['regist_time_from'] . ' 00:00:00"';
		}

		if( $conditions['regist_time_to'] != '' ) {
			$ret_array[] = 'o.regist_time <= "' . $conditions['regist_time_to'] . ' 23:59:59"';
		}

		return $ret_array;
	}

	public function get_one_with_detail_for_admin($order_id = '')
	{
		$select = '
			o.*,
			od.product_id, od.quantity, od.publisher_name, od.product_name, od.sales_price, od.sub_total, p.smile_code,
			c.classroom_number, c.smile_code1, c.smile_code2, c.smile_code3, c.en_code1, c.en_code2,
			c.name AS classroom_name, on.owner_name, on.corpo_name, on.payment_method1, on.payment_method2, on.payment_method3
		';

		$where = array(
			'o.order_id'	=> $order_id,
			'o.status'		=> "0"
		);

		$this->db->from(SELF::TBL . ' o')->select($select)->where($where)
			 ->join('t_order_detail od', 'od.order_id = o.order_id AND od.status = "0"', 'left')
			 ->join('t_classroom c', 'c.classroom_id = o.classroom_id AND c.status = "0"', 'left')
			 ->join('t_owner on', 'on.owner_id = c.owner_id AND on.status = "0"', 'left')
			 ->join('t_product p', 'od.product_id = p.product_id AND p.status = "0"', 'left')
			 ->order_by('od.product_id ASC');

		$query = $this->db->get();
		$this->cnt = $query->num_rows();

		return ($this->cnt > 0) ? $query->result_array() : FALSE;
	}
}
