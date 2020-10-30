<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		// モデルロード
		$this->load->model('m_admin');
		$this->load->model('m_mail');
	}

	public function index()
	{
		// ログイン済みチェック
		if( !$this->chk_logged_in_admin() ) {
			redirect('admin');
			return;
		}

		$this->load->view('admin/manage/index');
	}



	/*******************************************/
	/*                ajax関数                 */
	/*******************************************/
	// 新規追加
	public function ajax_add()
	{
		$post_data = $this->input->post();
		$name = isset($post_data['name']) ? $post_data['name'] : '';
		$email = isset($post_data['email']) ? $post_data['email'] : '';

		$ret_val = array(
			'status'	=> FALSE,
			'err_msg'	=> ''
		);

		if( $name == '' || $email == '' ) {
			$ret_val['err_msg'] = '全て必須項目です。';
		}
		else {
			$wk_admin_data = $this->m_admin->get_list(array('email' => $email));

			if( !empty($wk_admin_data) ) {
				$ret_val['err_msg'] = '入力されたメールアドレスはすでに登録されています。';
			}
			else {
				// パスワード生成
				$password = $this->m_admin->create_password();

				$now = date('Y-m-d H:i:s');
				$insert_data = array(
					'email'			=> $email,
					'password'		=> $this->m_admin->get_hashed_pass($password),
					'name'			=> $name,
					'regist_time'	=> $now,
					'update_time'	=> $now,
					'status'		=> '0'
				);

				if( $this->m_admin->insert($insert_data) ) {
					// パスワードを追加された管理者にメールでお知らせ

					// 設定ファイルロード
					$this->config->load('config_mail', TRUE, TRUE);
					$conf_mail_admin = $this->config->item('mail', 'config_mail');

					$view_data = array(
						'NAME'		=> $name,
						'PASSWORD'	=> $password
					);
					$mail_body = $this->load->view('mail/tmpl_admin_register', $view_data, TRUE);

					$params = array(
						'from'		=> $conf_mail_admin['management_to_admin']['from'],
						'from_name'	=> $conf_mail_admin['management_to_admin']['from_name'],
						'to'		=> $email,
						'subject'	=> SITE_NAME . ' 管理画面のパスワード',
						'message'	=> $mail_body
					);

					$this->m_mail->send($params);
					$ret_val['status'] = TRUE;
				}
				else {
					$ret_val['err_msg'] = 'データベースエラーが発生しました。';
				}
			}
		}

		$this->ajax_out(json_encode($ret_val));
	}

	// 修正
	public function ajax_mod()
	{
		$post_data = $this->input->post();
		$admin_id = isset($post_data['admin_id']) ? $post_data['admin_id'] : '';
		$name = isset($post_data['name']) ? $post_data['name'] : '';
		$email = isset($post_data['email']) ? $post_data['email'] : '';

		$ret_val = array(
			'status'	=> FALSE,
			'err_msg'	=> ''
		);

		if( $admin_id == '' || $name == '' || $email == '' ) {
			$ret_val['err_msg'] = '全て必須項目です。';
		}
		else {
			$wk_admin_data = $this->m_admin->get_list(array('email' => $email, 'admin_id !=' => $admin_id));

			if( !empty($wk_admin_data) ) {
				$ret_val['err_msg'] = '入力されたメールアドレスはすでに登録されています。';
			}
			else {
				$flg = TRUE;
				$wk_admin_data = $this->m_admin->get_one(array('admin_id' => $admin_id));

				$update_data = array(
					'email'			=> $email,
					'name'			=> $name,
					'update_time'	=> date('Y-m-d H:i:s')
				);

				if( $this->m_admin->update(array('admin_id' => $admin_id), $update_data) ) {
					$ret_val['status'] = TRUE;
				}
				else {
					$ret_val['err_msg'] = 'データベースエラーが発生しました。';
				}
			}
		}

		$this->ajax_out(json_encode($ret_val));
	}

	// 削除
	public function ajax_del()
	{
		$post_data = $this->input->post();
		$admin_id = isset($post_data['admin_id']) ? $post_data['admin_id'] : '';

		$ret_val = array(
			'status'	=> FALSE,
			'err_msg'	=> ''
		);

		if( $admin_id == '' ) {
			$ret_val['err_msg'] = 'パラメータエラーが発生しました。';
		}
		else {
			$update_data = array(
				'status'		=> '9',
				'update_time'	=> date('Y-m-d H:i:s')
			);

			if( $this->m_admin->update(array('admin_id' => $admin_id), $update_data) ) {
				$ret_val['status'] = TRUE;
			}
			else {
				$ret_val['err_msg'] = 'データベースエラーが発生しました。';
			}
		}

		$this->ajax_out(json_encode($ret_val));
	}

	// パスワードリセット
	public function ajax_reset_password()
	{
		$post_data = $this->input->post();
		$admin_id = isset($post_data['admin_id']) ? $post_data['admin_id'] : '';

		$ret_val = array(
			'status'	=> FALSE,
			'err_msg'	=> ''
		);

		if( $admin_id == '' ) {
			$ret_val['err_msg'] = 'パラメータエラーが発生しました。';
		}
		else {
			$admin_data = $this->m_admin->get_one(array('admin_id' => $admin_id));

			if( empty($admin_data) ) {
				$ret_val['err_msg'] = '該当の管理者が存在しません。';
			}
			else {
				// パスワード生成
				$password = $this->m_admin->create_password();

				$update_data = array(
					'password'			=> $this->m_admin->get_hashed_pass($password),
					'update_time'		=> date('Y-m-d H:i:s')
				);

				if( $this->m_admin->update(array('admin_id' => $admin_id), $update_data) ) {
					// パスワードを管理者にメールでお知らせ

					// 設定ファイルロード
					$this->config->load('config_mail', TRUE, TRUE);
					$conf_mail_admin = $this->config->item('mail', 'config_mail');

					$view_data = array(
						'NAME'		=> $admin_data['name'],
						'PASSWORD'	=> $password
					);
					$mail_body = $this->load->view('mail/tmpl_admin_reset_password', $view_data, TRUE);

					$params = array(
						'from'		=> $conf_mail_admin['management_to_admin']['from'],
						'from_name'	=> $conf_mail_admin['management_to_admin']['from_name'],
						'to'		=> $admin_data['email'],
						'subject'	=> SITE_NAME . ' 管理画面のパスワード',
						'message'	=> $mail_body
					);

					$this->m_mail->send($params);
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
