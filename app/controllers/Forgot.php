<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forgot extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		// モデルロード
		$this->load->model('m_classroom');
		$this->load->model('m_forgot');
	}

	public function index()
	{
		$this->load->view('front/forgot/index');
	}

	public function reissue()
	{
		$post_data = $this->input->post();
		$email = isset($post_data['email']) ? $post_data['email'] : '';
		$classroom_data = $this->m_classroom->get_one(array('email' => $email));

		$flg_exists = TRUE;
		if( !empty($classroom_data) ) {
			$param = $this->m_forgot->create_param();
			$now = date('Y-m-d H:i:s');

			$insert_data = array(
				'classroom_id'	=> $classroom_data['classroom_id'],
				'param'			=> $param,
				'limit_time'	=> date('Y-m-d H:i:s', strtotime($now . '+30 minute')),
				'regist_time'	=> $now,
				'update_time'	=> $now,
				'status'		=> '0'
			);
			$this->m_forgot->insert($insert_data);

			// メールで案内
			// モデルロード
			$this->load->model('m_mail');

			// 設定ファイルロード
			$this->config->load('config_mail', TRUE, TRUE);
			$this->conf_mail = $this->config->item('mail', 'config_mail');

			$mail_data = array(
				'JUKU_NAME'	=> $classroom_data['name'],
				'PARAM'		=> $param
			);

			$mail_body = $this->load->view('mail/tmpl_password_reissue', $mail_data, TRUE);
			$params = array(
				'from'		=> $this->conf_mail['apply_comp_to_customer']['from'],
				'from_name'	=> $this->conf_mail['apply_comp_to_customer']['from_name'],
				'to'		=> $email,
				'subject'	=> 'パスワード再発行の確認',
				'message'	=> $mail_body
			);

			$this->m_mail->send($params);
		}
		else {
			$flg_exists = FALSE;
		}

		$view_data = array(
			'EXISTS'	=> $flg_exists
		);

		$this->load->view('front/forgot/reissue', $view_data);
	}

	public function reset($param = '')
	{
		$forgot_data = $this->m_forgot->get_one(array('param' => $param));

		$err_msg = '';
		if( empty($forgot_data) ) {
			$err_msg = 'パスワード再発行のURLが正しくありません。<br>※すでに再発行済みのURLは使用できません。';
		}
		else {
			$now = date('Y-m-d H:i:s');
			$update_data_forgot = array(
				'update_time'	=> $now,
				'status'		=> '9'
			);
			$this->m_forgot->update(array('forgot_id' => $forgot_data['forgot_id']), $update_data_forgot);

			if( strtotime(date('Y-m-d H:i:s')) > strtotime($forgot_data['limit_time']) ) {
				$err_msg = 'パスワード再発行の有効期限が過ぎています。';
			}
			else {
				$classroom_data = $this->m_classroom->get_one(array('classroom_id' => $forgot_data['classroom_id']));
				if( empty($classroom_data) ) {
					$err_msg = '教室情報がありません。';
				}
				else {
					$new_pass = $this->m_classroom->create_password();
					$update_data_classroom = array(
						'password'		=> $this->m_classroom->get_hashed_pass($new_pass),
						'update_time'	=> $now
					);
					$this->m_classroom->update(array('classroom_id' => $forgot_data['classroom_id']), $update_data_classroom);

					// 再発行されたパスワードをメールでお知らせ
					// モデルロード
					$this->load->model('m_mail');

					// 設定ファイルロード
					$this->config->load('config_mail', TRUE, TRUE);
					$this->conf_mail = $this->config->item('mail', 'config_mail');

					$mail_data = array(
						'JUKU_NAME'	=> $classroom_data['name'],
						'PASSWORD'	=> $new_pass
					);

					$mail_body = $this->load->view('mail/tmpl_password_reset', $mail_data, TRUE);

					$params = array(
						'from'		=> $this->conf_mail['apply_comp_to_customer']['from'],
						'from_name'	=> $this->conf_mail['apply_comp_to_customer']['from_name'],
						'to'		=> $classroom_data['email'],
						'subject'	=> 'パスワード再発行のお知らせ',
						'message'	=> $mail_body
					);

					$this->m_mail->send($params);
				}
			}
		}

		$view_data = array(
			'ERR_MSG'	=> $err_msg
		);

		$this->load->view('front/forgot/reset', $view_data);
	}
}