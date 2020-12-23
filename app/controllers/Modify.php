<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modify extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		// モデルロード
		$this->load->model('m_classroom');
	}

	public function index($err_msg = '')
	{
		// ログイン済みチェック
		if( !$this->chk_logged_in() ) {
			redirect('index');
			return;
		}

		// リロード対策
		if( $this->input->cookie('modify_complete') ) {
			delete_cookie('modify_complete');
		}

		$classroom_id = $this->session->userdata('classroom_id');
		$classroom_data = $this->m_classroom->get_one(array('classroom_id' => $classroom_id));

		$view_data = array(
			'DATA'	=> $classroom_data,
			'ERRMSG'=> $err_msg
		);

		$this->load->view('front/modify/index', $view_data);
	}

	public function complete()
	{
		// ログイン済みチェック
		if( !$this->chk_logged_in() ) {
			redirect('index');
			return;
		}

		// リロード対策
		if( $this->input->cookie('modify_complete') ) {
			redirect('modify');
		}
		else {
			$cookie_data = array(
				'name'	=> 'modify_complete',
				'value'	=> '1',
				'expire'=> '86400'
			);
			$this->input->set_cookie($cookie_data);
		}

		$post_data = $this->input->post();
		$email = isset($post_data['email']) ? $post_data['email'] : '';
		$password = isset($post_data['password']) ? $post_data['password'] : '';

		$classroom_id = $this->session->userdata('classroom_id');

		$update_data = array(
			'email'			=> $email,
			'update_time'	=> date('Y-m-d H:i:s')
		);

		if( !empty($password) ) {
			$update_data['password'] = $this->m_classroom->get_hashed_pass($password);
		}

		$err_msg = 'OK';
		if( !$this->m_classroom->update(array('classroom_id' => $classroom_id), $update_data) ) {
			$err_msg = 'データベースエラーが発生しました。';
		}

		$this->index($err_msg);
		return;
	}



	/*******************************************/
	/*                ajax関数                 */
	/*******************************************/
	// メールアドレスが登録できるかチェック
	public function ajax_check_email()
	{
		$post_data = $this->input->post();
		$email = isset($post_data['email']) ? $post_data['email'] : '';

		$ret_val = array(
			'status'	=> FALSE,
			'err_msg'	=> ''
		);

		if( $email == '' ) {
			$ret_val['err_msg'] = 'メールアドレス は必須です。';
		}
		else {
			$this->load->helper('email');
			if( !valid_email($email) ) {
				$ret_val['err_msg'] = 'メールアドレス が正しくありません。';
			}
			else {
				$classroom_id = $this->session->userdata('classroom_id');
				$classroom_data = $this->m_classroom->get_one(array('email' => $email));
				if( !empty($classroom_data) && $classroom_data['classroom_id'] != $classroom_id ) {
					$ret_val['err_msg'] = 'メールアドレス はすでに登録されています。';
				}
				else {
					$ret_val['status'] = TRUE;
				}
			}
		}

		$this->ajax_out(json_encode($ret_val));
	}
}