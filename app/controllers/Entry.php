<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Entry extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		// モデルロード
		$this->load->model('m_classroom');
		$this->load->model('m_account');

		// 設定ファイルロード
		$this->config->load('config_disp', TRUE, TRUE);
		$this->conf = $this->config->item('disp', 'config_disp');
	}

	public function index()
	{
		$post_data = $this->input->post();

		$view_data = array(
			'CONF'	=> $this->conf,
			'PDATA'	=> $post_data
		);

		$this->load->view('front/entry/index', $view_data);
	}

	public function confirm()
	{
		$post_data = $this->input->post();

		$view_data = array(
			'CONF'	=> $this->conf,
			'PDATA'	=> $post_data
		);

		$this->load->view('front/entry/confirm', $view_data);
	}

	public function complete()
	{
		$post_data = $this->input->post();
		$classroom_id = isset($post_data['classroom_id']) ? $post_data['classroom_id'] : '';
		$classroom_name = isset($post_data['classroom_name']) ? $post_data['classroom_name'] : '';
		$flg_parent = isset($post_data['flg_parent']) ? $post_data['flg_parent'] : '';
		$email = isset($post_data['email']) ? $post_data['email'] : '';
		$password_hidden = isset($post_data['password_hidden']) ? $post_data['password_hidden'] : '';
		$apply_account = isset($post_data['apply_account']) ? $post_data['apply_account'] : '';
		$corporation = isset($post_data['corporation']) ? $post_data['corporation'] : '';
		$corporation_name = isset($post_data['corporation_name']) ? $post_data['corporation_name'] : '';
		$corporation_zip1 = isset($post_data['corporation_zip1']) ? $post_data['corporation_zip1'] : '';
		$corporation_zip2 = isset($post_data['corporation_zip2']) ? $post_data['corporation_zip2'] : '';
		$corporation_pref = isset($post_data['corporation_pref']) ? $post_data['corporation_pref'] : '';
		$corporation_addr1 = isset($post_data['corporation_addr1']) ? $post_data['corporation_addr1'] : '';
		$corporation_addr2 = isset($post_data['corporation_addr2']) ? $post_data['corporation_addr2'] : '';
		$corporation_tel01 = isset($post_data['corporation_tel01']) ? $post_data['corporation_tel01'] : '';
		$corporation_tel02 = isset($post_data['corporation_tel02']) ? $post_data['corporation_tel02'] : '';
		$corporation_tel03 = isset($post_data['corporation_tel03']) ? $post_data['corporation_tel03'] : '';
		$corporation_executive = isset($post_data['corporation_executive']) ? $post_data['corporation_executive'] : '';
		$payment_method = isset($post_data['payment_method']) ? $post_data['payment_method'] : '';
		$transfer_name = isset($post_data['transfer_name']) ? $post_data['transfer_name'] : '';

		$this->db->trans_start();

		$now = date('Y-m-d H:i:s');
		$update_data = array(
			'email'			=> $email,
			'password'		=> $this->m_classroom->get_hashed_pass($password_hidden),
			'update_time'	=> $now
		);

		$this->m_classroom->update(array('classroom_id' => $classroom_id), $update_data);

		if( $flg_parent == '1' && $apply_account == '1' ) {
			$insert_data = array(
				'classroom_id'	=> $classroom_id,
				'corporation'	=> $corporation,
				'name'			=> $corporation_name,
				'zip1'			=> $corporation_zip1,
				'zip2'			=> $corporation_zip2,
				'pref'			=> $corporation_pref,
				'addr1'			=> $corporation_addr1,
				'addr2'			=> $corporation_addr2,
				'tel1'			=> $corporation_tel01,
				'tel2'			=> $corporation_tel02,
				'tel3'			=> $corporation_tel03,
				'executive'		=> $corporation_executive,
				'payment_method'=> $payment_method,
				'transfer_name'	=> $transfer_name,
				'regist_time'	=> $now,
				'update_time'	=> $now,
				'status'		=> '0'
			);

			$this->m_account->insert($insert_data);

			// 受発注課にメール
			// モデルロード
			$this->load->model('m_mail');

			// 設定ファイルロード
			$this->config->load('config_mail', TRUE, TRUE);
			$this->conf_mail = $this->config->item('mail', 'config_mail');

			$mail_data = array(
				'classroom_name'	=> $classroom_name,
				'corporation'		=> $corporation == '1' ? '法人' : '非法人',
				'payment_method'	=> $payment_method == '1' ? '振込' : '口座引落'
			);

			$mail_body = $this->load->view('mail/tmpl_entry_to_admin', $mail_data, TRUE);
			$params = array(
				'from'		=> $this->conf_mail['entry_to_admin']['from'],
				'from_name'	=> $this->conf_mail['entry_to_admin']['from_name'],
				'to'		=> $this->conf_mail['entry_to_admin']['to'],
				'subject'	=> '掛け登録の希望があります',
				'message'	=> $mail_body
			);

			$this->m_mail->send($params);
		}

		$this->db->trans_complete();

		$flg_commit = TRUE;
		if( $this->db->trans_status() === FALSE ) {
			$flg_commit = FALSE;
		}

		$view_data = array(
			'COMMIT'	=> $flg_commit,
			'PARENT'	=> $flg_parent
		);

		$this->load->view('front/entry/complete', $view_data);
	}



	/*******************************************/
	/*                ajax関数                 */
	/*******************************************/
	// 教室コードから教室情報取得
	public function ajax_get_classroom()
	{
		$post_data = $this->input->post();
		$classroom_number = isset($post_data['classroom_number']) ? $post_data['classroom_number'] : '';

		$ret_val = array(
			'status'			=> FALSE,
			'classroom_id'		=> '',
			'classroom_name'	=> '',
			'flg_parent'		=> FALSE,
			'flg_registered'	=> FALSE
		);

		$classroom_data = $this->m_classroom->get_one(array('classroom_number' => $classroom_number));
		if( !empty($classroom_data) ) {
			$ret_val['status'] = TRUE;
			$ret_val['classroom_id'] = $classroom_data['classroom_id'];
			$ret_val['classroom_name'] = $classroom_data['name'];
			$ret_val['flg_parent'] = ( $classroom_data['parent_id'] == $classroom_data['classroom_id'] ) ? TRUE : FALSE;
			$ret_val['flg_registered'] = ( !empty($classroom_data['email']) ) ? TRUE : FALSE;
		}

		$this->ajax_out(json_encode($ret_val));
	}

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
				$classroom_data = $this->m_classroom->get_one(array('email' => $email));
				if( !empty($classroom_data) ) {
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
