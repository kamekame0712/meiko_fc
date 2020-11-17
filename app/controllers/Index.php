<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		// モデルロード
		$this->load->model('m_classroom');

		// 設定ファイルロード
		$this->config->load('config_disp', TRUE, TRUE);
		$this->conf = $this->config->item('disp', 'config_disp');

		// バリデーションエラー設定
		$this->form_validation->set_error_delimiters('<p class="login-error">', '</p>');
	}

	public function index()
	{
		// ログイン済みチェック
		if( !$this->chk_logged_in() ) {
			$this->login();
			return;
		}

		redirect('order');
		return;
	}

	public function login()
	{
		// ログイン済みチェック
		if( $this->chk_logged_in() ) {
			redirect('order');
			return;
		}

		$this->load->view('front/login');
	}

	public function do_login()
	{
		// ログイン済みチェック
		if( $this->chk_logged_in() ) {
			redirect('order');
			return;
		}

		if( $this->form_validation->run('login') == FALSE ) {
			$this->load->view('front/login');
			return;
		}

		$post_data = $this->input->post();
		$email = isset($post_data['email']) ? $post_data['email'] : '';
		$classroom_data = $this->m_classroom->get_one(array('email' => $email));

		if( !empty($classroom_data) ) {
			$this->session->set_userdata('classroom_id', $classroom_data['classroom_id']);
			$this->session->set_userdata('classroom_name', $classroom_data['name']);

			redirect('order');
		}
		else {
			$this->login();
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('classroom_id');
		$this->session->unset_userdata('classroom_name');

		if( $this->input->cookie('order_complete') ) {
			delete_cookie('order_complete');
		}

		if( $this->input->cookie('product_list') ) {
			delete_cookie('product_list');
		}

		if( $this->input->cookie('payment_method') ) {
			delete_cookie('payment_method');
		}

		if( $this->input->cookie('delivery_date') ) {
			delete_cookie('delivery_date');
		}

		if( $this->input->cookie('delivery_time') ) {
			delete_cookie('delivery_time');
		}

		if( $this->input->cookie('note') ) {
			delete_cookie('note');
		}

		redirect('index');
	}
}
