<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Classroom extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		// モデルロード
		$this->load->model('m_classroom');
		$this->load->model('m_owner');

		// 設定ファイルロード
		$this->config->load('config_disp', TRUE, TRUE);
		$this->conf = $this->config->item('disp', 'config_disp');

		// バリデーションエラー設定
		$this->form_validation->set_error_delimiters('<p class="error-msg">', '</p>');

		// cookieの削除
		$this->delete_conditions('classroom');
	}

	public function index($result = '')
	{
		// ログイン済みチェック
		if( !$this->chk_logged_in_admin() ) {
			redirect('admin');
			return;
		}

		$conditions = array();
		$wk_conditions = $this->input->cookie('conditions_classroom');
		if( !empty($wk_conditions) ) {
			$conditions = unserialize(base64_decode(str_rot13($wk_conditions)));
		}

		$view_data = array(
			'CONF'		=> $this->conf,
			'RESULT'	=> $result,
			'CONDITION'	=> $conditions
		);

		$this->load->view('admin/classroom/index', $view_data);
	}

	public function add()
	{
		// ログイン済みチェック
		if( !$this->chk_logged_in_admin() ) {
			redirect('admin');
			return;
		}

		$view_data = array(
			'KIND'	=> 'add',
			'CID'	=> '',
			'CONF'	=> $this->conf,
			'CDATA'	=> array(),
			'OWNER'	=> ''
		);

		$this->load->view('admin/classroom/input', $view_data);
	}

	public function modify($classroom_id = '')
	{
		// ログイン済みチェック
		if( !$this->chk_logged_in_admin() ) {
			redirect('admin');
			return;
		}

		$classroom_data = $this->m_classroom->get_one(array('classroom_id' => $classroom_id));

		$owner = '未設定';
		if( !empty($classroom_data['owner_id']) ) {
			$owner_data = $this->m_owner->get_one(array('owner_id' => $classroom_data['owner_id']));
			if( !empty($owner_data) ) {
				$owner = $owner_data['owner_name'];
				if( !empty($owner_data['corpo_name']) ) {
					$owner .= '（' . $owner_data['corpo_name'] . '）';
				}
			}
		}

		$view_data = array(
			'KIND'	=> 'modify',
			'CID'	=> $classroom_id,
			'CONF'	=> $this->conf,
			'CDATA'	=> $classroom_data,
			'OWNER'	=> $owner
		);

		$this->load->view('admin/classroom/input', $view_data);
	}

	public function confirm()
	{
		// ログイン済みチェック
		if( !$this->chk_logged_in_admin() ) {
			redirect('admin');
			return;
		}

		$post_data = $this->input->post();

		// バリデーションチェック
		if( $this->form_validation->run('admin/classroom') == FALSE ) {
			$classroom_id = isset($post_data['classroom_id']) ? $post_data['classroom_id'] : '';
			$owner = '未設定';

			if( $classroom_id != '' ) {
				$classroom_data = $this->m_classroom->get_one(array('classroom_id' => $classroom_id));
				if( !empty($classroom_data['owner_id']) ) {
					$owner_data = $this->m_owner->get_one(array('owner_id' => $classroom_data['owner_id']));
					if( !empty($owner_data) ) {
						$owner = $owner_data['owner_name'];
						if( !empty($owner_data['corpo_name']) ) {
							$owner .= '（' . $owner_data['corpo_name'] . '）';
						}
					}
				}
			}

			$view_data = array(
				'KIND'	=> isset($post_data['kind']) ? $post_data['kind'] : 'add',
				'CID'	=> $classroom_id,
				'CONF'	=> $this->conf,
				'CDATA'	=> array(),
				'OWNER'	=> $owner
			);

			$this->load->view('admin/classroom/input', $view_data);
			return;
		}

		$view_data = array(
			'CONF'	=> $this->conf,
			'PDATA'	=> $post_data
		);

		$this->load->view('admin/classroom/confirm', $view_data);
	}

	public function complete()
	{
		// ログイン済みチェック
		if( !$this->chk_logged_in_admin() ) {
			redirect('admin');
			return;
		}

		$post_data = $this->input->post();
		$now = date('Y-m-d H:i:s');

		if( $post_data['kind'] == 'add' ) {
			$password = '';
			if( !empty($post_data['password']) ) {
				$password = $this->m_classroom->get_hashed_pass($post_data['password']);
			}

			$insert_data = array(
				'classroom_number'	=> isset($post_data['classroom_number']) ? $post_data['classroom_number'] : '',
				'smile_code1'		=> !empty($post_data['smile_code1']) ? $post_data['smile_code1'] : NULL,
				'smile_code2'		=> !empty($post_data['smile_code2']) ? $post_data['smile_code2'] : NULL,
				'smile_code3'		=> !empty($post_data['smile_code3']) ? $post_data['smile_code3'] : NULL,
				'en_code1'			=> !empty($post_data['en_code1']) ? $post_data['en_code1'] : NULL,
				'en_code2'			=> !empty($post_data['en_code2']) ? $post_data['en_code2'] : NULL,
				'name'				=> isset($post_data['name']) ? $post_data['name'] : '',
				'zip'				=> !empty($post_data['zip']) ? $post_data['zip'] : NULL,
				'pref'				=> isset($post_data['pref']) ? $post_data['pref'] : '',
				'address'			=> !empty($post_data['address']) ? $post_data['address'] : NULL,
				'tel'				=> !empty($post_data['tel']) ? $post_data['tel'] : NULL,
				'owner_id'			=> NULL,
				'email'				=> !empty($post_data['email']) ? $post_data['email'] : NULL,
				'password'			=> $password,
				'gmo_member_id'		=> NULL,
				'flg_instruction'	=> '1',
				'regist_time'		=> $now,
				'update_time'		=> $now,
				'status'			=> '0'
			);

			if( !$this->m_classroom->insert($insert_data) ) {
				redirect('admin/classroom/index/err1');
				return;
			}
		}
		else {
			$classroom_id = isset($post_data['classroom_id']) ? $post_data['classroom_id'] : '';
			$classroom_data = $this->m_classroom->get_one(array('classroom_id' => $classroom_id));

			if( !empty($classroom_data) ) {
				$update_data = array(
					'classroom_number'	=> isset($post_data['classroom_number']) ? $post_data['classroom_number'] : '',
					'smile_code1'		=> !empty($post_data['smile_code1']) ? $post_data['smile_code1'] : NULL,
					'smile_code2'		=> !empty($post_data['smile_code2']) ? $post_data['smile_code2'] : NULL,
					'smile_code3'		=> !empty($post_data['smile_code3']) ? $post_data['smile_code3'] : NULL,
					'en_code1'			=> !empty($post_data['en_code1']) ? $post_data['en_code1'] : NULL,
					'en_code2'			=> !empty($post_data['en_code2']) ? $post_data['en_code2'] : NULL,
					'name'				=> isset($post_data['name']) ? $post_data['name'] : '',
					'zip'				=> !empty($post_data['zip']) ? $post_data['zip'] : NULL,
					'pref'				=> isset($post_data['pref']) ? $post_data['pref'] : '',
					'address'			=> !empty($post_data['address']) ? $post_data['address'] : NULL,
					'tel'				=> !empty($post_data['tel']) ? $post_data['tel'] : NULL,
					'email'				=> !empty($post_data['email']) ? $post_data['email'] : NULL,
					'update_time'		=> $now
				);

				if( !empty($post_data['password']) ) {
					$update_data['password'] = $this->m_classroom->get_hashed_pass($post_data['password']);
				}

				if( !$this->m_classroom->update(array('classroom_id' => $classroom_id), $update_data) ) {
					redirect('admin/classroom/index/err1');
					return;
				}
			}
			else {
				redirect('admin/classroom/index/err2');
				return;
			}
		}

		redirect('admin/classroom/index/ok');
		return;
	}



	/*******************************************/
	/*                ajax関数                 */
	/*******************************************/
	public function ajax_del()
	{
		$post_data = $this->input->post();
		$classroom_id = isset($post_data['classroom_id']) ? $post_data['classroom_id'] : '';

		$ret_val = array(
			'status'			=> FALSE,
			'err_msg'			=> ''
		);

		if( $classroom_id == '' ) {
			$ret_val['err_msg'] = 'パラメータエラーが発生しました。';
		}
		else {
			$classroom_data = $this->m_classroom->get_one(array('classroom_id' => $classroom_id));
			if( empty($classroom_data) ) {
				$ret_val['err_msg'] = '削除する教室情報が存在しません。';
			}
			else {
				$update_data = array(
					'update_time'	=> date('Y-m-d H:i:s'),
					'status'		=> '9'
				);

				if( $this->m_classroom->update(array('classroom_id' => $classroom_id), $update_data) ) {
					$ret_val['status'] = TRUE;
				}
				else {
					$ret_val['err_msg'] = 'データベースエラーが発生しました。';
				}
			}
		}

		$this->ajax_out(json_encode($ret_val));
	}



	/*******************************************/
	/*          ajax関数(bootgrid用)           */
	/*******************************************/
	public function get_bootgrid()
	{
		$post_data = $this->input->post();
		$current = isset($post_data['current']) ? intval($post_data['current']) : 1;
		$rowCount = isset($post_data['rowCount']) ? intval($post_data['rowCount']) : 10;
		$sort = isset($post_data['sort']) ? $post_data['sort'] : array();

		$conditions = array(
			'classroom_name'	=> isset($post_data['classroom_name']) ? $post_data['classroom_name'] : '',
			'owner_name'		=> isset($post_data['owner_name']) ? $post_data['owner_name'] : '',
			'corpo_name'		=> isset($post_data['corpo_name']) ? $post_data['corpo_name'] : '',
			'smile_code'		=> isset($post_data['smile_code']) ? $post_data['smile_code'] : '',
			'pref'				=> isset($post_data['pref']) ? $post_data['pref'] : '',
			'tel'				=> isset($post_data['tel']) ? $post_data['tel'] : '',
		);

		// 検索条件をクッキー登録
		$encoded_post_data = str_rot13(base64_encode(serialize($conditions)));
		$cookie_data = array(
			'name'	=> 'conditions_classroom',
			'value'	=> $encoded_post_data,
			'expire'=> '3600'
		);
		$this->input->set_cookie($cookie_data);

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

		list($classroom_data, $classroom_cnt) = $this->m_classroom->get_list_bootgrid($conditions, $sort_str, $limit_array);
		$row_val = array();

		if( !empty($classroom_data) ) {
			foreach( $classroom_data as $val ) {
				$row_val[] = array(
					'classroom_id'	=> $val['classroom_id'],
					'name'			=> $val['name'],
					'owner_name'	=> empty($val['owner_name']) ? '未設定' : $val['owner_name'],
					'corpo_name'	=> empty($val['corpo_name']) ? '未設定' : $val['corpo_name'],
					'address'		=> $this->conf['pref'][$val['pref']] . $val['address'],
					'tel'			=> $val['tel'],
					'email'			=> $val['email'],
					'smile_code1'	=> empty($val['smile_code1']) ? '未設定' : $val['smile_code1'],
					'smile_code2'	=> empty($val['smile_code2']) ? '未設定' : $val['smile_code2'],
					'smile_code3'	=> empty($val['smile_code3']) ? '未設定' : $val['smile_code3'],
					'en_code1'		=> empty($val['en_code1']) ? '未設定' : ( $val['en_code1'] == '1' ? '有' : '無' ),
					'en_code2'		=> empty($val['en_code2']) ? '未設定' : ( $val['en_code2'] == '1' ? '有' : '無' )
				);
			}
		}

		$ret_val = array(
			'current'	=> $current,
			'rowCount'	=> $rowCount,
			'total'		=> $classroom_cnt,
			'rows'		=> $row_val
		);

		$this->ajax_out(json_encode($ret_val));
	}
}
