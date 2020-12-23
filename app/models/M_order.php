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
}
