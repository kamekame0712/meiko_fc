<?php

class M_forgot extends MY_Model
{
	// テーブル名
	const TBL  = 't_forgot';

	// パラメーターに使う文字列
	private $param_str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_';

	function __construct()
	{
		parent::__construct();
	}

	public function create_param($length = 32)
	{
		return substr(str_shuffle($this->param_str), 0, $length);
	}
}
