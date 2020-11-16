<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Classroom extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		// モデルロード
//		$this->load->model('m_classroom');
	}

	public function index()
	{
		// ログイン済みチェック
		if( !$this->chk_logged_in_admin() ) {
			redirect('admin');
			return;
		}

		$this->load->view('admin/classroom/index');
	}



	/*******************************************/
	/*                ajax関数                 */
	/*******************************************/



	/*******************************************/
	/*          ajax関数(bootgrid用)           */
	/*******************************************/
	public function get_bootgrid()
	{
		$post_data = $this->input->post();
		$current = isset($post_data['current']) ? intval($post_data['current']) : 1;
		$rowCount = isset($post_data['rowCount']) ? intval($post_data['rowCount']) : 10;
		$searchPhrase = isset($post_data['searchPhrase']) ? $post_data['searchPhrase'] : '';
		$sort = isset($post_data['sort']) ? $post_data['sort'] : array();

		$sort_str = '';
		foreach( $sort as $sort_key => $sort_val ) {
			$sort_str .= $sort_key . ' ' . $sort_val;
		}

		if( $rowCount != -1 ) {
			$limit_array = array($rowCount, ($current - 1) * $rowCount);
		}
		else {
			$limit_array = '';
		}

		if( $searchPhrase != '' ) {
			$where = 'name LIKE "%' . $searchPhrase . '%"';
		}
		else {
			$where = '';
		}

		$admin_data = $this->m_admin->get_list($where, $sort_str, $limit_array);
		$admin_all_data = $this->m_admin->get_list($where);

		$row_val = array();

		if( !empty($admin_data) ) {
			foreach( $admin_data as $val ) {
				$row_val[] = array(
					'admin_id'	=> $val['admin_id'],
					'name'		=> $val['name'],
					'email'		=> $val['email']
				);
			}
		}

		$ret_val = array(
			'current'	=> $current,
			'rowCount'	=> $rowCount,
			'total'		=> count($admin_all_data),
			'rows'		=> $row_val
		);

		$this->ajax_out(json_encode($ret_val));
	}
}
