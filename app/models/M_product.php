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
			foreach( explode(' ', $keyword) as $val ) {
				$where_array[] = '( name LIKE "%' . $val . '%" OR keyword LIKE "%' . $val . '%" )';
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
		$db_total->distinct()->from(SELF::TBL)->where($where);
		$query_total = $db_total->get();
		$total = $query_total->num_rows();

		// データ取得
		$this->db->distinct()->from(SELF::TBL)->where($where)->order_by('product_id ASC');

		// $pageに0を入れるとページネーションなし（全てのデータを返す）
		if( $page != 0 ) {
			$this->db->limit(RECORD_PER_PAGE, ($page - 1) * intval(RECORD_PER_PAGE));
		}

		$query = $this->db->get();
		$course_data = ($query->num_rows() > 0) ? $query->result_array() : NULL;

		return array($course_data, $total);
	}
}
