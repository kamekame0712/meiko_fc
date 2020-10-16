<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		// モデルロード
//		$this->load->model('m_admin');

		// 設定ファイルロード
		$this->config->load('config_disp', TRUE, TRUE);
		$this->conf = $this->config->item('disp', 'config_disp');
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













}
