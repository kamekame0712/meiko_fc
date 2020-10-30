<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		// モデルロード
		$this->load->model('m_admin');
	}

	public function index()
	{
		// ログイン済みチェック
		if( !$this->chk_logged_in_admin() ) {
			$this->login();
			return;
		}

		$this->load->view('admin/index');
	}

	// ログインページ
	public function login()
	{
		// ログイン済みチェック
		if( $this->chk_logged_in_admin() ) {
			$this->index();
			return;
		}

		$this->load->view('admin/login');
	}

	// 実際のログイン処理
	public function do_login()
	{
		// ログイン済みチェック
		if( $this->chk_logged_in_admin() ) {
			$this->index();
			return;
		}

		$post_data = $this->input->post();
		$email = isset($post_data['email']) ? $post_data['email'] : '';

		if( $this->form_validation->run('login_admin') == FALSE ) {
			$this->load->view('admin/login');
			return;
		}

		$admin_data = $this->m_admin->get_one(array('email' => $email));
		if( !empty($admin_data) ) {
			// ログイン状態にするため、admin_id、nameをセッションに保存
			$this->session->set_userdata('admin_id', $admin_data['admin_id']);
			$this->session->set_userdata('admin_name', $admin_data['name']);
			redirect('admin');
		}
		else {
			$this->login();
		}
	}

	// ログアウト処理
	public function logout()
	{
		$this->session->unset_userdata('admin_id');
		$this->session->unset_userdata('admin_name');

		$this->login();
	}



	/*******************************************/
	/*                ajax関数                 */
	/*******************************************/
	// 管理者 自身のパスワードを変更
	public function ajax_password_change()
	{
		$post_data = $this->input->post();
		$old_pass = isset($post_data['old_pass']) ? $post_data['old_pass'] : '';
		$new_pass = isset($post_data['new_pass']) ? $post_data['new_pass'] : '';

		$ret_val = array(
			'status'	=> FALSE,
			'err_msg'	=> ''
		);

		if( $old_pass == '' || $new_pass == '' ) {
			$ret_val['err_msg'] = '全て必須項目です。';
		}
		else {
			$admin_id = $this->session->userdata('admin_id');
			$admin_data = $this->m_admin->get_one(array('admin_id' => $admin_id));

			if( !$this->m_admin->possible_login($admin_data['email'], $old_pass) ) {
				$ret_val['err_msg'] = '現在のパスワードが違います。';
			}
			else {
				if( strlen($new_pass) < 6 ) {
					$ret_val['err_msg'] = 'パスワードは6桁以上必要です。';
				}
				else {
					$update_data = array(
						'password'			=> $this->m_admin->get_hashed_pass($new_pass),
						'update_time'		=> date('Y-m-d H:i:s')
					);

					if( $this->m_admin->update(array('admin_id' => $admin_id), $update_data) ) {
						$ret_val['status'] = TRUE;
					}
					else {
						$ret_val['err_msg'] = 'データベースエラーが発生しました。';
					}
				}
			}
		}

		$this->ajax_out(json_encode($ret_val));
	}
}
