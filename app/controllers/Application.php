<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Application extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		// モデルロード
		$this->load->model('m_classroom');
		$this->load->model('m_owner');
		$this->load->model('m_account');

		// 設定ファイルロード
		$this->config->load('config_disp', TRUE, TRUE);
		$this->conf = $this->config->item('disp', 'config_disp');

		// バリデーションエラー設定
		$this->form_validation->set_error_delimiters('<p class="error-msg">', '</p>');
	}

	// ご利用申込み
	public function index()
	{
		$post_data = $this->input->post();
		$classroom_number = !empty($post_data['classroom_number']) ? $post_data['classroom_number'] : array('', '', '', '', '');

		$view_data = array(
			'CONF'	=> $this->conf,
			'LINES'	=> count($classroom_number) > 5 ? count($classroom_number) : 5,
			'CM'	=> $classroom_number
		);

		$this->load->view('front/application/index', $view_data);
	}

	// ご利用申込み 確認
	public function confirm()
	{
		$post_data = $this->input->post();
		$classroom_number = !empty($post_data['classroom_number']) ? $post_data['classroom_number'] : array('', '', '', '', '');

		// バリデーションチェック
		if( $this->form_validation->run('application') == FALSE ) {
			$view_data = array(
				'CONF'	=> $this->conf,
				'LINES'	=> count($classroom_number) > 5 ? count($classroom_number) : 5,
				'CM'	=> $classroom_number
			);

			$this->load->view('front/application/index', $view_data);
			return;
		}

		$cm_data = array();
		foreach( $classroom_number as $val ) {
			$classroom_data = $this->m_classroom->get_one(array('classroom_number' => $val));
			if( !empty($classroom_data) ) {
				$cm_data[] = $classroom_data;
			}
		}

		$view_data = array(
			'CONF'	=> $this->conf,
			'PDATA'	=> $post_data,
			'CDATA'	=> $cm_data
		);

		$this->load->view('front/application/confirm', $view_data);
	}

	// ご利用申込み 登録
	public function complete()
	{
		$post_data = $this->input->post();
		$classroom_number = !empty($post_data['classroom_number']) ? $post_data['classroom_number'] : array();
		$payment_method1 = isset($post_data['payment_method1']) ? $post_data['payment_method1'] : '0';
		$payment_method2 = isset($post_data['payment_method2']) ? $post_data['payment_method2'] : '0';
		$payment_method3 = isset($post_data['payment_method3']) ? $post_data['payment_method3'] : '0';

		$now = date('Y-m-d H:i:s');

		$this->db->trans_start();

		$insert_data = array(
			'owner_name'		=> isset($post_data['owner_name']) ? $post_data['owner_name'] : '',
			'corpo_name'		=> isset($post_data['corpo_name']) ? $post_data['corpo_name'] : '',
			'zip1'				=> isset($post_data['zip1']) ? $post_data['zip1'] : '',
			'zip2'				=> isset($post_data['zip2']) ? $post_data['zip2'] : '',
			'pref'				=> isset($post_data['pref']) ? $post_data['pref'] : '',
			'addr1'				=> isset($post_data['addr1']) ? $post_data['addr1'] : '',
			'addr2'				=> isset($post_data['addr2']) ? $post_data['addr2'] : '',
			'tel1'				=> isset($post_data['tel1']) ? $post_data['tel1'] : '',
			'tel2'				=> isset($post_data['tel2']) ? $post_data['tel2'] : '',
			'tel3'				=> isset($post_data['tel3']) ? $post_data['tel3'] : '',
			'fax1'				=> !empty($post_data['fax1']) ? $post_data['fax1'] : NULL,
			'fax2'				=> !empty($post_data['fax2']) ? $post_data['fax2'] : NULL,
			'fax3'				=> !empty($post_data['fax3']) ? $post_data['fax3'] : NULL,
			'email'				=> isset($post_data['email']) ? $post_data['email'] : '',
			'payment_method1'	=> $payment_method1,
			'payment_method2'	=> $payment_method2,
			'payment_method3'	=> $payment_method3,
			'flg_complete'		=> '1',
			'regist_time'		=> $now,
			'update_time'		=> $now,
			'status'			=> '0'
		);

		$owner_id = $this->m_owner->insert($insert_data);
		$classroom_name = array();

		if( !empty($owner_id) ) {
			foreach( $classroom_number as $val ) {
				$classroom_data = $this->m_classroom->get_one(array('classroom_number' => $val));

				if( !empty($classroom_data) ) {
					$update_data = array(
						'owner_id'		=> $owner_id,
						'update_time'	=> $now
					);
					$this->m_classroom->update(array('classroom_id' => $classroom_data['classroom_id']), $update_data);

					$classroom_name[] = $classroom_data['name'];
				}
			}
		}

		$this->db->trans_complete();

		$flg_error = FALSE;
		if( $this->db->trans_status() === FALSE ) {
			$flg_error = TRUE;
		}

		if( !$flg_error ) {
			if( $payment_method1 == '1' ) {
				$_POST = array();
				$this->account($owner_id);
				return;
			}
			else { // 登録完了（掛け無し）
				// モデルロード
				$this->load->model('m_mail');

				// 設定ファイルロード
				$this->config->load('config_mail', TRUE, TRUE);
				$this->conf_mail = $this->config->item('mail', 'config_mail');

				$payment_method = array();
				if( $payment_method1 == '1' ) {
					$payment_method[] = '買掛';
				}

				if( $payment_method2 == '1' ) {
					$payment_method[] = 'クレジットカード';
				}

				if( $payment_method3 == '1' ) {
					$payment_method[] = '代金引換';
				}

				$mail_data = $insert_data;
				$mail_data['CONF'] = $this->conf;
				$mail_data['classroom_name'] = implode(',', $classroom_name);
				$mail_data['payment_method'] = implode(',', $payment_method);

				$mail_body = $this->load->view('mail/tmpl_application_without_account', $mail_data, TRUE);
				$params = array(
					'from'		=> $this->conf_mail['entry_to_admin']['from'],
					'from_name'	=> $this->conf_mail['entry_to_admin']['from_name'],
					'to'		=> $this->conf_mail['entry_to_admin']['to'],
					'subject'	=> '明光ジャパンFC 利用申込み（掛け無）',
					'message'	=> $mail_body
				);

				$this->m_mail->send($params);
			}
		}

		$view_data = array(
			'ERROR'	=> $flg_error
		);

		$this->load->view('front/application/complete', $view_data);
	}

	// 掛け取り引き申請
	public function account($owner_id = '')
	{
		$owner_data = $this->m_owner->get_one(array('owner_id' => $owner_id, 'payment_method1' => '1'));

		$view_data = array(
			'CONF'	=> $this->conf,
			'OID'	=> isset($owner_data['owner_id']) ? $owner_data['owner_id'] : NULL
		);

		$this->load->view('front/application/account', $view_data);
	}

	// 掛け取り引き申請 確認
	public function account_confirm()
	{
		$post_data = $this->input->post();
		$owner_id = isset($post_data['owner_id']) ? $post_data['owner_id'] : '';
		$corporation = isset($post_data['corporation']) ? $post_data['corporation'] : '';
		$bill_to = isset($post_data['bill_to']) ? $post_data['bill_to'] : '';
		$settlement_method = isset($post_data['settlement_method']) ? $post_data['settlement_method'] : '';

		// バリデーションチェック
		$this->form_validation->set_rules('settlement_method', '決済方法', 'required');
		$this->form_validation->set_rules('bill_to', 'ご請求先', 'required');

		if( $corporation == '1' ) { // 法人
			$this->form_validation->set_rules('corpo_name', '法人名', 'required');
			$this->form_validation->set_rules('executive', '代表者名', 'required');
			$this->form_validation->set_rules('zip1', '法人郵便番号', 'callback_chk_zip');
			$this->form_validation->set_rules('pref', '法人住所', 'callback_chk_address');
			$this->form_validation->set_rules('tel1', '代表電話番号', 'callback_chk_tel');
		}
		else { // 非法人
			$this->form_validation->set_rules('corpo_name', '代表者名', 'required');
			$this->form_validation->set_rules('zip1', '代表者自宅郵便番号', 'callback_chk_zip');
			$this->form_validation->set_rules('pref', '代表者自宅住所', 'callback_chk_address');
			$this->form_validation->set_rules('tel1', '代表者電話番号', 'callback_chk_tel');
		}

		if( $bill_to == '2' ) {
			$this->form_validation->set_rules('bill_name', 'ご請求先名', 'required');
			$this->form_validation->set_rules('bill_zip1', 'ご請求先郵便番号', 'callback_chk_bill_zip');
			$this->form_validation->set_rules('bill_pref', 'ご請求先住所', 'callback_chk_bill_address');
			$this->form_validation->set_rules('bill_tel1', 'ご請求先電話番号', 'callback_chk_bill_tel');
		}

		if( $settlement_method == '1' ) {
			$this->form_validation->set_rules('transfer_name', 'お振込み名義', 'required');
		}
		else {
			$this->form_validation->set_rules('bank_name', '金融機関名', 'required');
		}

		if( $this->form_validation->run() == FALSE ) {
			$view_data = array(
				'CONF'	=> $this->conf,
				'OID'	=> $owner_id
			);

			$this->load->view('front/application/account', $view_data);
			return;
		}

		$view_data = array(
			'CONF'	=> $this->conf,
			'PDATA'	=> $post_data
		);

		$this->load->view('front/application/account_confirm', $view_data);
	}

	// 掛け取り引き申請 登録
	public function account_complete()
	{
		$post_data = $this->input->post();
		$owner_id = isset($post_data['owner_id']) ? $post_data['owner_id'] : '';

		$now = date('Y-m-d H:i:s');

		$insert_data = array(
			'owner_id'			=> $owner_id,
			'corporation'		=> isset($post_data['corporation']) ? $post_data['corporation'] : '',
			'corpo_name'		=> isset($post_data['corpo_name']) ? $post_data['corpo_name'] : '',
			'executive'			=> !empty($post_data['executive']) ? $post_data['executive'] : NULL,
			'zip1'				=> isset($post_data['zip1']) ? $post_data['zip1'] : '',
			'zip2'				=> isset($post_data['zip2']) ? $post_data['zip2'] : '',
			'pref'				=> isset($post_data['pref']) ? $post_data['pref'] : '',
			'addr1'				=> isset($post_data['addr1']) ? $post_data['addr1'] : '',
			'addr2'				=> isset($post_data['addr2']) ? $post_data['addr2'] : '',
			'tel1'				=> isset($post_data['tel1']) ? $post_data['tel1'] : '',
			'tel2'				=> isset($post_data['tel2']) ? $post_data['tel2'] : '',
			'tel3'				=> isset($post_data['tel3']) ? $post_data['tel3'] : '',
			'fax1'				=> !empty($post_data['fax1']) ? $post_data['fax1'] : NULL,
			'fax2'				=> !empty($post_data['fax2']) ? $post_data['fax2'] : NULL,
			'fax3'				=> !empty($post_data['fax3']) ? $post_data['fax3'] : NULL,
			'bill_to'			=> isset($post_data['bill_to']) ? $post_data['bill_to'] : '',
			'bill_name'			=> isset($post_data['bill_name']) ? $post_data['bill_name'] : '',
			'bill_zip1'			=> isset($post_data['bill_zip1']) ? $post_data['bill_zip1'] : '',
			'bill_zip2'			=> isset($post_data['bill_zip2']) ? $post_data['bill_zip2'] : '',
			'bill_pref'			=> isset($post_data['bill_pref']) ? $post_data['bill_pref'] : '',
			'bill_addr1'		=> isset($post_data['bill_addr1']) ? $post_data['bill_addr1'] : '',
			'bill_addr2'		=> isset($post_data['bill_addr2']) ? $post_data['bill_addr2'] : '',
			'bill_tel1'			=> isset($post_data['bill_tel1']) ? $post_data['bill_tel1'] : '',
			'bill_tel2'			=> isset($post_data['bill_tel2']) ? $post_data['bill_tel2'] : '',
			'bill_tel3'			=> isset($post_data['bill_tel3']) ? $post_data['bill_tel3'] : '',
			'bill_note'			=> !empty($post_data['bill_note']) ? $post_data['bill_note'] : '',
			'settlement_method'	=> isset($post_data['settlement_method']) ? $post_data['settlement_method'] : '',
			'transfer_name'		=> !empty($post_data['transfer_name']) ? $post_data['transfer_name'] : NULL,
			'bank_name'			=> !empty($post_data['bank_name']) ? $post_data['bank_name'] : NULL,
			'regist_time'		=> $now,
			'update_time'		=> $now,
			'status'			=> '0'
		);

		$flg_error = FALSE;
		if( !$this->m_account->insert($insert_data) ) {
			$update_data = array(
				'update_time'	=> $now,
				'status'		=> '9'
			);
			$this->m_owner->update(array('owner_id' => $owner_id), $update_data);
			$flg_error = TRUE;
		}
		else {
			// 登録完了（掛け有り）
			// モデルロード
			$this->load->model('m_mail');

			// 設定ファイルロード
			$this->config->load('config_mail', TRUE, TRUE);
			$this->conf_mail = $this->config->item('mail', 'config_mail');

			$owner_data = $this->m_owner->get_one(array('owner_id' => $owner_id));

			if( !empty($owner_data) ) {
				$payment_method = array();
				if( $owner_data['payment_method1'] == '1' ) {
					$payment_method[] = '買掛';
				}

				if( $owner_data['payment_method2'] == '1' ) {
					$payment_method[] = 'クレジットカード';
				}

				if( $owner_data['payment_method3'] == '1' ) {
					$payment_method[] = '代金引換';
				}

				$classroom_data = $this->m_classroom->get_list(array('owner_id' => $owner_id));
				$classroom_name = array();
				if( !empty($classroom_data) ) {
					foreach( $classroom_data as $val ) {
						$classroom_name[] = $val['name'];
					}
				}

				$mail_data = $insert_data;
				$mail_data['CONF'] = $this->conf;
				$mail_data['OWNER'] = $owner_data;
				$mail_data['classroom_name'] = implode(',', $classroom_name);
				$mail_data['payment_method'] = implode(',', $payment_method);

				$mail_body = $this->load->view('mail/tmpl_application_with_account', $mail_data, TRUE);
				$params = array(
					'from'		=> $this->conf_mail['entry_to_admin']['from'],
					'from_name'	=> $this->conf_mail['entry_to_admin']['from_name'],
					'to'		=> $this->conf_mail['entry_to_admin']['to'],
					'subject'	=> '明光ジャパンFC 利用申込み（掛け有）',
					'message'	=> $mail_body
				);

				$this->m_mail->send($params);
			}
		}

		$view_data = array(
			'ERROR'	=> $flg_error
		);

		$this->load->view('front/application/complete', $view_data);
	}



	/*******************************************/
	/*                ajax関数                 */
	/*******************************************/
	// 教室コードから教室名取得
	public function ajax_get_classroom()
	{
		$post_data = $this->input->post();
		$classroom_number = isset($post_data['classroom_number']) ? $post_data['classroom_number'] : '';

		$ret_val = array(
			'status'			=> FALSE,
			'err_msg'			=> '',
			'classroom_name'	=> ''
		);

		$classroom_data = $this->m_classroom->get_one(array('classroom_number' => $classroom_number));
		if( !empty($classroom_data) ) {
			$ret_val['status'] = TRUE;
			$ret_val['classroom_name'] = $classroom_data['name'];
		}
		else {
			$ret_val['err_msg'] = '教室コードに該当する教室が存在しません。';
		}

		$this->ajax_out(json_encode($ret_val));
	}

	// オーナー情報取得
	public function ajax_get_owner()
	{
		$post_data = $this->input->post();
		$owner_id = isset($post_data['owner_id']) ? $post_data['owner_id'] : '';

		$ret_val = array(
			'status'		=> FALSE,
			'err_msg'		=> '',
			'owner_data'	=> array()
		);

		$owner_data = $this->m_owner->get_one(array('owner_id' => $owner_id));
		if( !empty($owner_data) ) {
			$ret_val['status'] = TRUE;
			$ret_val['owner_data'] = $owner_data;
		}
		else {
			$ret_val['err_msg'] = 'ご利用申込みの登録データがありません。';
		}

		$this->ajax_out(json_encode($ret_val));
	}
}
