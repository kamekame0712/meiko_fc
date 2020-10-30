<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Email extends CI_Email {

	public function __construct()
	{
		parent::__construct();
	}

	private function _set_header($header, $value)
	{
		$this->_headers[$header] = $value;
	}

	public function subject($subject)
	{
		$this->set_header('Subject', $subject);
		return $this;
	}

	public function message($body)
	{
		$this->_body = $body;
		return $this;
	}
}

