<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Help extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function privacy()
	{
		$this->load->view('front/help/privacy');
	}

	public function tradelaw()
	{
		$this->load->view('front/help/tradelaw');
	}
}