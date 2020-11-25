<?php

/**
 * メール送信model
 * ※特定のテーブルをアクセスするためのモデルではなく、
 *   メール送信のためのモデル
 */
class M_mail extends CI_Model {

	public function __construct()
	{
		parent::__construct();

		$config = array(
			'_encoding' => '7bit',
			'charset'  => 'ISO-2022-JP',
			'newline'  => '\r\n',
			'mailtype'  => 'text',
			'validation' => FALSE,
			'wordwrap' => FALSE,
			'send_multipart' => FALSE
		);

//		$config['wordwrap'] = FALSE;
//		$config['charset'] = 'iso-2022-jp';
//		$config['crlf'] = '\r\n';
		$this->email->initialize($config);
	}

	/**
	 * send メール送信
	 *
	 * @param array $params
	 */
	public function send($params)
	{
		mb_internal_encoding("UTF-8");

		$from      = (array_key_exists('from',     $params)) ? $params['from'] : MAIL_FROM;
		$from_name = (array_key_exists('from_name',$params)) ? $params['from_name'] : MAIL_FROM_NAME;
		$from_name_enc = mb_encode_mimeheader($from_name, 'ISO-2022-JP', 'UTF-8');

		$this->email->from($from, $from_name_enc);
		$this->email->to($params['to']);
		$this->email->reply_to($from, $from_name_enc);

		// Subjectをエンコード
//		$subject = mb_convert_encoding($params['subject'], 'ISO-2022-JP', 'UTF-8');
//		$this->email->subject($subject);

//		$this->email->subject($params['subject']);

		$subject = '=?iso-2022-jp?B?' . base64_encode(mb_convert_encoding($params['subject'], 'JIS', 'UTF-8')) . '?=';
		$this->email->subject($subject);


		$this->email->message(mb_convert_encoding($params['message'], 'ISO-2022-JP', 'UTF-8'));
		$ret = $this->email->send();

		return $ret;
	}
}
