<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Entry extends MY_Controller
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
		$view_data = array(
			'CONF'	=> $this->conf
		);

		$this->load->view('front/entry/index', $view_data);
	}

	public function confirm()
	{
		$post_data = $this->input->post();



echo '<pre>';
print_r($post_data);
echo '</pre>';

	}



}
