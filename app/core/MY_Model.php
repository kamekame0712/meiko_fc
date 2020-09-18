<?php
/**
 * モデル共通クラス
 */
class MY_model extends CI_Model
{
	const TBL = '';

	// 取得件数
	protected $cnt = 0;

	// インサートID
	protected $insert_id = 0;

	function __construct()
	{
		parent::__construct();
	}

	/**
	 * レコード登録
	 */
	public function insert( $params=array() )
	{
		if( empty($params) ) {
			$params = $this->inprm;
		}

		$ret = $this->db->insert(static::TBL, $params);
		$this->insert_id = $this->db->insert_id();
		return $this->insert_id;
	}

	/**
	 * レコードインサートID取得
	 */
	public function get_insert_id()
	{
		return $this->insert_id;
	}

	/**
	 * レコード更新
	 * 
	 * @param string $where    : 更新条件の連想配列
	 * @param string $params   : 更新情報の連想配列
	 * @access public
	 * @return boolean
	 */
	public function update($where, $params=array())
	{
		$this->db->where($where);
		return $this->db->update(static::TBL, $params);
	}

	/**
	 * レコード一覧取得
	 *
	 *	@param	params		検索条件
	 *	@param	order		並び順
	 *	@param	limit		配列で指定する場合：array(取得件数, 0オリジンのオフセット)
	 *						数字で指定する場合：取得件数
	 *	@param	is_status	TRUE:status='0'を条件に付加
	 *	@param	select		抽出カラム名
	 *
	 *	@return				複数レコードの連想配列
	 *
	 */
	public function get_list($params = '', $order = '', $limit = '', $is_status = TRUE, $select = '')
	{
		$this->db->from(static::TBL);

		if( !empty($params) ) {
			$this->db->where($params);
		}

		if( !empty($order) ) {
			$this->db->order_by($order);
		}

		if( is_array($limit) && !empty($limit) ) {
			$this->db->limit($limit[0], $limit[1]);
		}
		else {
			if( !empty($limit) ) {
				$this->db->limit($limit);
			}
		}

		if( ( !isset($params['status']) && !isset($params['status !=']) && !isset($params['status <']) && !isset($params['status <=']) && !isset($params['status >']) && !isset($params['status >=']) ) && $is_status ) {
			// statusがある時のみ実行
			if( $this->db->field_exists('status', static::TBL) ) {
				$this->db->where('status', '0');
			}
		}

		if( !empty($select) ) {
			$this->db->select($select);
		}

		$query = $this->db->get();
		$this->cnt = $query->num_rows();

		return ($this->cnt > 0) ? $query->result_array() : FALSE;
	}

	/**
	 * レコード単一取得
	 * 
	 * @param	$where		検索条件
	 * @return				単一レコードの連想配列
	 */
	public function get_one($where = '', $order = '', $is_status = TRUE, $select = '')
	{
		$result = $this->get_list($where, $order, '', $is_status, $select);
		return (is_array($result)) ? $result[0] : FALSE;
	}

	/**
	 * レコード件数取得
	 * 
	 * @param	$params		検索条件
	 * @param	is_status	TRUE:status='0'を条件に付加
	 *
	 * @return				レコード件数
	 */
	public function get_count($params = '', $is_status = TRUE)
	{
		$this->db->from(static::TBL);

		if( !empty($params) ) {
			$this->db->where($params);
		}

		if( ( !isset($params['status']) && !isset($params['status !=']) && !isset($params['status <']) && !isset($params['status <=']) && !isset($params['status >']) && !isset($params['status >=']) ) && $is_status ) {
			// statusがある時のみ実行
			if( $this->db->field_exists('status', static::TBL) ) {
				$this->db->where('status', '0');
			}
		}

		$query = $this->db->get();
		return $query->num_rows();
	}

	/**
	 * 最大値取得
	 * 
	 * @param	$col		最大値を求めるカラム名
	 * @param	$params		検索条件
	 * @param	is_status	TRUE:status='0'を条件に付加
	 *
	 * @return				最大値
	 */
	public function get_max($col = '', $params = '', $is_status = TRUE)
	{
		if( $col == '' ) {
			return FALSE;
		}

		$this->db->from(static::TBL)->select_max($col, 'max');

		if( !empty($params) ) {
			$this->db->where($params);
		}

		if( ( !isset($params['status']) && !isset($params['status !=']) && !isset($params['status <']) && !isset($params['status <=']) && !isset($params['status >']) && !isset($params['status >=']) ) && $is_status ) {
			// statusがある時のみ実行
			if( $this->db->field_exists('status', static::TBL) ) {
				$this->db->where('status', '0');
			}
		}

		$query = $this->db->get();
		$query->num_rows();

		if( $query->num_rows() > 0 ) {
			$wk = $query->row_array();
			return $wk['max'];
		}
		else {
			return '0';
		}
	}

	/**
	 * 最小値取得
	 * 
	 * @param	$col		最小値を求めるカラム名
	 * @param	$params		検索条件
	 * @param	is_status	TRUE:status='0'を条件に付加
	 *
	 * @return				最小値
	 */
	public function get_min($col = '', $params = '', $is_status = TRUE)
	{
		if( $col == '' ) {
			return FALSE;
		}

		$this->db->from(static::TBL)->select_min($col, 'min');

		if( !empty($params) ) {
			$this->db->where($params);
		}

		if( ( !isset($params['status']) && !isset($params['status !=']) && !isset($params['status <']) && !isset($params['status <=']) && !isset($params['status >']) && !isset($params['status >=']) ) && $is_status ) {
			// statusがある時のみ実行
			if( $this->db->field_exists('status', static::TBL) ) {
				$this->db->where('status', '0');
			}
		}

		$query = $this->db->get();
		$query->num_rows();

		if( $query->num_rows() > 0 ) {
			$wk = $query->row_array();
			return $wk['min'];
		}
		else {
			return '0';
		}
	}
}
