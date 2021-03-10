<?php

class M_product extends MY_Model
{
	// テーブル名
	const TBL  = 't_product';

	function __construct()
	{
		parent::__construct();
	}

	public function get_applicable($conditions, $page)
	{
		$where_array = array();
		$where_array[] = 'status = "0"';

		if( !empty($conditions['keyword']) ) {
			$keyword = str_replace('　', ' ', $conditions['keyword']);
			$keyword = mb_convert_kana($keyword, 'HV');

			foreach( explode(' ', $keyword) as $val ) {
				$where_array[] = '( name collate utf8_unicode_ci LIKE "%' . $val . '%" OR keyword collate utf8_unicode_ci LIKE "%' . $val . '%" )';
			}
		}

		if( $conditions['recommend'] == '1' ) {
			$where_array[] = 'recommend = "1"';
		}

		$where_grade = array();
		if( !empty($conditions['grade_e']) ) {
			foreach( $conditions['grade_e'] as $grade ) {
				$where_grade[] = 'grade LIKE "%' . $grade . '%"';
			}
		}

		if( !empty($conditions['grade_j']) ) {
			foreach( $conditions['grade_j'] as $grade ) {
				$where_grade[] = 'grade LIKE "%' . $grade . '%"';
			}
		}

		if( !empty($conditions['grade_h']) ) {
			foreach( $conditions['grade_h'] as $grade ) {
				$where_grade[] = 'grade LIKE "%' . $grade . '%"';
			}
		}

		if( !empty($where_grade) ) {
			$where_array[] = '(' . implode(' OR ', $where_grade) . ')';
		}

		$where_subject = array();
		if( !empty($conditions['subject']) ) {
			foreach( $conditions['subject'] as $subject ) {
				$where_subject[] = 'subject LIKE "%' . $subject . '%"';
			}
		}

		if( !empty($where_subject) ) {
			$where_array[] = '(' . implode(' OR ', $where_subject) . ')';
		}

		$where_period = array();
		if( !empty($conditions['period']) ) {
			foreach( $conditions['period'] as $period ) {
				$where_period[] = 'period LIKE "%' . $period . '%"';
			}
		}

		if( !empty($where_period) ) {
			$where_array[] = '(' . implode(' OR ', $where_period) . ')';
		}

		$where_publisher = array();
		if( !empty($conditions['publisher']) ) {
			foreach( $conditions['publisher'] as $publisher ) {
				$where_publisher[] = 'publisher = "' . $publisher . '"';
			}
		}

		if( !empty($where_publisher) ) {
			$where_array[] = '(' . implode(' OR ', $where_publisher) . ')';
		}

		$where = implode(' AND ', $where_array);

		// データの総数取得
		$db_total = $this->db;
		$db_total->distinct()->from(SELF::TBL)->where($where, '', FALSE);
		$query_total = $db_total->get();
		$total = $query_total->num_rows();

		// データ取得
		$this->db->distinct()->from(SELF::TBL)->where($where, '', FALSE)->order_by('product_id ASC');

		// $pageに0を入れるとページネーションなし（全てのデータを返す）
		if( $page != 0 ) {
			$this->db->limit(RECORD_PER_PAGE, ($page - 1) * intval(RECORD_PER_PAGE));
		}

		$query = $this->db->get();
		$course_data = ($query->num_rows() > 0) ? $query->result_array() : NULL;

		return array($course_data, $total);
	}

	public function get_list_bootgrid($conditions = array(), $sort_str = '', $limit_array = '')
	{
		$where_array = $this->get_where($conditions);
		$where = implode(' AND ', $where_array);

		$this->db->from(SELF::TBL)->distinct()
			 ->where($where)->order_by($sort_str);

		if( is_array($limit_array) && !empty($limit_array) ) {
			$this->db->limit($limit_array[0], $limit_array[1]);
		}

		$query = $this->db->get();
		$data = ($query->num_rows() > 0) ? $query->result_array() : FALSE;

		$this->db->from(SELF::TBL)->distinct()
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

	public function get_list_for_download($conditions = array())
	{
		$where_array = $this->get_where($conditions);
		$where = implode(' AND ', $where_array);

		$this->db->from(SELF::TBL)->distinct()
			 ->where($where)->order_by('smile_code ASC');

		$query = $this->db->get();
		return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
	}

	private function get_where($conditions)
	{
		 $ret_array = array();
		 $ret_array[] = 'status = "0"';

		 if( $conditions['product_name'] != '' ) {
			$ret_array[] = 'name LIKE "%' . $conditions['product_name'] . '%"';
		}

		if( $conditions['smile_code_from'] != '' ) {
			$ret_array[] = 'smile_code >= "' . $conditions['smile_code_from'] . '"';
		}

		if( $conditions['smile_code_to'] != '' ) {
			$ret_array[] = 'smile_code <= "' . $conditions['smile_code_to'] . '"';
		}

		if( $conditions['publisher'] != '' ) {
			$ret_array[] = 'publisher = "' . $conditions['publisher'] . '"';
		}

		if( !empty($conditions['flg_market']) ) {
			$where_flg_market = array();
			foreach( $conditions['flg_market'] as $val ) {
				$where_flg_market[] = 'flg_market = "' . $val . '"';
			}

			$ret_array[] = '( ' . implode(' OR ', $where_flg_market) . ')';
		}

		if( !empty($conditions['flg_sales']) ) {
			$where_flg_sales = array();
			foreach( $conditions['flg_sales'] as $val ) {
				$where_flg_sales[] = 'flg_sales = "' . $val . '"';
			}

			$ret_array[] = '( ' . implode(' OR ', $where_flg_sales) . ')';
		}

		return $ret_array;
	}
}
