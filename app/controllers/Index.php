<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		// モデルロード
//		$this->load->model('m_admin');
	}

	public function index()
	{
echo '明光！';
	}

}
