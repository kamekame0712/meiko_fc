<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Owner extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		// モデルロード
		$this->load->model('m_owner');
		$this->load->model('m_account');
		$this->load->model('m_classroom');

		// 設定ファイルロード
		$this->config->load('config_disp', TRUE, TRUE);
		$this->conf = $this->config->item('disp', 'config_disp');

		// バリデーションエラー設定
		$this->form_validation->set_error_delimiters('<p class="error-msg">', '</p>');
	}

	public function index($result = '')
	{
		// ログイン済みチェック
		if( !$this->chk_logged_in_admin() ) {
			redirect('admin');
			return;
		}

		$view_data = array(
			'RESULT'	=> $result
		);

		$this->load->view('admin/owner/index', $view_data);
	}

	public function add()
	{
		// ログイン済みチェック
		if( !$this->chk_logged_in_admin() ) {
			redirect('admin');
			return;
		}

		$post_data = $this->input->post();
		$classroom_ids = isset($post_data['classroom_ids']) ? $post_data['classroom_ids'] : array();
		$classroom_data = array();

		if( !empty($classroom_ids) ) {
			foreach( $classroom_ids as $c_id ) {
				$wk_classroom_data = $this->m_classroom->get_one(array('classroom_id' => $c_id));
				if( !empty($wk_classroom_data) ) {
					$classroom_data[] = $wk_classroom_data;
				}
			}
		}

		$view_data = array(
			'KIND'	=> 'add',
			'OID'	=> '',
			'CONF'	=> $this->conf,
			'ODATA'	=> array(),
			'ADATA'	=> array(),
			'CDATA'	=> $classroom_data
		);

		$this->load->view('admin/owner/input', $view_data);
	}

	public function modify($owner_id = '')
	{
		// ログイン済みチェック
		if( !$this->chk_logged_in_admin() ) {
			redirect('admin');
			return;
		}

		$owner_data = $this->m_owner->get_one(array('owner_id' => $owner_id));
		$account_data = $this->m_account->get_one(array('owner_id' => $owner_id));

		$post_data = $this->input->post();
		$classroom_ids = isset($post_data['classroom_ids']) ? $post_data['classroom_ids'] : array();

		if( empty($classroom_ids) ) {
			$classroom_data = $this->m_classroom->get_list(array('owner_id' => $owner_id));
		}
		else {
			$classroom_data = array();
			foreach( $classroom_ids as $c_id ) {
				$wk_classroom_data = $this->m_classroom->get_one(array('classroom_id' => $c_id));
				if( !empty($wk_classroom_data) ) {
					$classroom_data[] = $wk_classroom_data;
				}
			}
		}

		$view_data = array(
			'KIND'	=> 'modify',
			'OID'	=> $owner_id,
			'CONF'	=> $this->conf,
			'ODATA'	=> $owner_data,
			'ADATA'	=> $account_data,
			'CDATA'	=> $classroom_data
		);

		$this->load->view('admin/owner/input', $view_data);
	}

	public function confirm()
	{
		// ログイン済みチェック
		if( !$this->chk_logged_in_admin() ) {
			redirect('admin');
			return;
		}

		$post_data = $this->input->post();
		$kind = isset($post_data['kind']) ? $post_data['kind'] : '1';
		$owner_id = isset($post_data['owner_id']) ? $post_data['owner_id'] : '';
		$payment_method1 = isset($post_data['payment_method1']) ? $post_data['payment_method1'] : '';
		$payment_method2 = isset($post_data['payment_method2']) ? $post_data['payment_method2'] : '';
		$payment_method3 = isset($post_data['payment_method3']) ? $post_data['payment_method3'] : '';
		$classroom_ids = isset($post_data['classroom_ids']) ? $post_data['classroom_ids'] : array();
		$corporation = isset($post_data['corporation']) ? $post_data['corporation'] : '';
		$bill_to = isset($post_data['bill_to']) ? $post_data['bill_to'] : '';
		$settlement_method = isset($post_data['settlement_method']) ? $post_data['settlement_method'] : '';

		// バリデーションチェック
		$this->form_validation->set_rules('owner_name', 'オーナー名', 'required');
		$this->form_validation->set_rules('zip1', '郵便番号', 'callback_chk_zip');
		$this->form_validation->set_rules('pref', '住所', 'callback_chk_address');
		$this->form_validation->set_rules('tel1', '電話番号', 'callback_chk_tel');
		$this->form_validation->set_rules('email', 'メールアドレス', 'required|valid_email');
		$this->form_validation->set_rules('payment_method1', 'お支払方法', 'callback_chk_payment_method');
		$this->form_validation->set_rules('classroom_ids[]', '運営教室', 'required');

		if( $payment_method1 == '1' ) {
			$this->form_validation->set_rules('settlement_method', '決済方法', 'required');
			$this->form_validation->set_rules('bill_to', 'ご請求先', 'required');
			$this->form_validation->set_rules('corporation', '事業形態', 'required');

			if( $corporation == '1' ) { // 法人
				$this->form_validation->set_rules('account_corpo_name', '法人名', 'required');
				$this->form_validation->set_rules('account_executive', '代表者名', 'required');
				$this->form_validation->set_rules('account_zip1', '法人郵便番号', 'callback_chk_account_zip');
				$this->form_validation->set_rules('account_pref', '法人住所', 'callback_chk_account_address');
				$this->form_validation->set_rules('account_tel1', '代表電話番号', 'callback_chk_account_tel');
			}
			else { // 非法人
				$this->form_validation->set_rules('account_corpo_name', '代表者名', 'required');
				$this->form_validation->set_rules('account_zip1', '代表者自宅郵便番号', 'callback_chk_account_zip');
				$this->form_validation->set_rules('account_pref', '代表者自宅住所', 'callback_chk_account_address');
				$this->form_validation->set_rules('account_tel1', '代表者電話番号', 'callback_chk_account_tel');
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
		}

		if( $this->form_validation->run() == FALSE ) {
			if( $kind == 'add' ) {
				$owner_data = array();
				$account_data = array();
				$classroom_data = array();
			}
			else {
				$owner_data = $this->m_owner->get_one(array('owner_id' => $owner_id));
				$account_data = $this->m_account->get_one(array('owner_id' => $owner_id));
				$classroom_data = array();
			}

			if( !empty($classroom_ids) ) {
				foreach( $classroom_ids as $c_id ) {
					$wk_classroom_data = $this->m_classroom->get_one(array('classroom_id' => $c_id));
					if( !empty($wk_classroom_data) ) {
						$classroom_data[] = $wk_classroom_data;
					}
				}
			}

			$view_data = array(
				'KIND'	=> $kind,
				'OID'	=> $owner_id,
				'CONF'	=> $this->conf,
				'ODATA'	=> $owner_data,
				'ADATA'	=> $account_data,
				'CDATA'	=> $classroom_data
			);

			$this->load->view('admin/owner/input', $view_data);
			return;
		}

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

		$classroom = array();
		if( !empty($classroom_ids) ) {
			foreach( $classroom_ids as $c_id ) {
				$wk_classroom_data = $this->m_classroom->get_one(array('classroom_id' => $c_id));
				if( !empty($wk_classroom_data) ) {
					$classroom[] = $wk_classroom_data['name'];
				}
			}
		}

		$view_data = array(
			'CONF'		=> $this->conf,
			'PDATA'		=> $post_data,
			'PAYMENT'	=> implode(',', $payment_method),
			'CLASSROOM'	=> implode(',', $classroom)
		);

		$this->load->view('admin/owner/confirm', $view_data);
	}

	public function complete()
	{
		// ログイン済みチェック
		if( !$this->chk_logged_in_admin() ) {
			redirect('admin');
			return;
		}

		$post_data = $this->input->post();
		$payment_method1 = isset($post_data['payment_method1']) ? $post_data['payment_method1'] : '0';
		$owner_id = isset($post_data['owner_id']) ? $post_data['owner_id'] : '';
		$classroom_ids = isset($post_data['classroom_ids']) ? $post_data['classroom_ids'] : array();

		$now = date('Y-m-d H:i:s');

		$this->db->trans_start();

		if( $post_data['kind'] == 'add' ) {
			$insert_data_owner = array(
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
				'payment_method2'	=> isset($post_data['payment_method2']) ? $post_data['payment_method2'] : '0',
				'payment_method3'	=> isset($post_data['payment_method3']) ? $post_data['payment_method3'] : '0',
				'flg_complete'		=> '1',
				'regist_time'		=> $now,
				'update_time'		=> $now,
				'status'			=> '0'
			);

			$insert_owner_id = $this->m_owner->insert($insert_data_owner);
			if( !empty($insert_owner_id) ) {
				foreach( $classroom_ids as $val ) {
					$classroom_data = $this->m_classroom->get_one(array('classroom_id' => $val));

					if( !empty($classroom_data) ) {
						$update_data_classroom = array(
							'owner_id'		=> $insert_owner_id,
							'update_time'	=> $now
						);
						$this->m_classroom->update(array('classroom_id' => $val), $update_data_classroom);
					}
				}
			}

			if( $payment_method1 == '1' ) {
				$insert_data_account = array(
					'owner_id'			=> $insert_owner_id,
					'corporation'		=> isset($post_data['corporation']) ? $post_data['corporation'] : '',
					'corpo_name'		=> isset($post_data['account_corpo_name']) ? $post_data['account_corpo_name'] : '',
					'executive'			=> !empty($post_data['account_executive']) ? $post_data['account_executive'] : NULL,
					'zip1'				=> isset($post_data['account_zip1']) ? $post_data['account_zip1'] : '',
					'zip2'				=> isset($post_data['account_zip2']) ? $post_data['account_zip2'] : '',
					'pref'				=> isset($post_data['account_pref']) ? $post_data['account_pref'] : '',
					'addr1'				=> isset($post_data['account_addr1']) ? $post_data['account_addr1'] : '',
					'addr2'				=> isset($post_data['account_addr2']) ? $post_data['account_addr2'] : '',
					'tel1'				=> isset($post_data['account_tel1']) ? $post_data['account_tel1'] : '',
					'tel2'				=> isset($post_data['account_tel2']) ? $post_data['account_tel2'] : '',
					'tel3'				=> isset($post_data['account_tel3']) ? $post_data['account_tel3'] : '',
					'fax1'				=> !empty($post_data['account_fax1']) ? $post_data['account_fax1'] : NULL,
					'fax2'				=> !empty($post_data['account_fax2']) ? $post_data['account_fax2'] : NULL,
					'fax3'				=> !empty($post_data['account_fax3']) ? $post_data['account_fax3'] : NULL,
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
				$this->m_account->insert($insert_data_account);
			}
		}
		else {
			$update_data_owner = array(
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
				'payment_method2'	=> isset($post_data['payment_method2']) ? $post_data['payment_method2'] : '0',
				'payment_method3'	=> isset($post_data['payment_method3']) ? $post_data['payment_method3'] : '0',
				'update_time'		=> $now
			);

			$this->m_owner->update(array('owner_id' => $owner_id), $update_data_owner);

			$before_classroom = $this->m_classroom->get_list(array('owner_id' => $owner_id));
			if( !empty($before_classroom) ) {
				foreach( $before_classroom as $val ) {
					if( !in_array($val['classroom_id'], $classroom_ids, TRUE) ) {	// 削除された
						$update_data_classroom = array(
							'smile_code1'	=> NULL,
							'smile_code2'	=> NULL,
							'smile_code3'	=> NULL,
							'owner_id'		=> NULL,
							'email'			=> NULL,
							'password'		=> NULL,
							'gmo_member_id'	=> NULL,
							'flg_instruction'	=> '1',
							'update_time'	=> $now
						);
						$this->m_classroom->update(array('classroom_id' => $val['classroom_id']), $update_data_classroom);
					}
				}
			}

			foreach( $classroom_ids as $val ) {
				$wk_classroom_data = $this->m_classroom->get_one(array('classroom_id' => $val));
				if( !empty($wk_classroom_data) ) {
					$update_data_classroom = array(
						'owner_id'		=> $owner_id,
						'update_time'	=> $now
					);
					$this->m_classroom->update(array('classroom_id' => $val), $update_data_classroom);
				}
			}

			if( $payment_method1 == '1' ) {
				// オーナー登録（買掛有）だけして買掛登録していない場合はinsert、ちゃんと登録してある場合はupdate
				$wk_account_data = $this->m_account->get_one(array('owner_id' => $owner_id));

				if( !empty($wk_account_data) ) {
					$update_data_account = array(
						'owner_id'			=> $owner_id,
						'corporation'		=> isset($post_data['corporation']) ? $post_data['corporation'] : '',
						'corpo_name'		=> isset($post_data['account_corpo_name']) ? $post_data['account_corpo_name'] : '',
						'executive'			=> !empty($post_data['account_executive']) ? $post_data['account_executive'] : NULL,
						'zip1'				=> isset($post_data['account_zip1']) ? $post_data['account_zip1'] : '',
						'zip2'				=> isset($post_data['account_zip2']) ? $post_data['account_zip2'] : '',
						'pref'				=> isset($post_data['account_pref']) ? $post_data['account_pref'] : '',
						'addr1'				=> isset($post_data['account_addr1']) ? $post_data['account_addr1'] : '',
						'addr2'				=> isset($post_data['account_addr2']) ? $post_data['account_addr2'] : '',
						'tel1'				=> isset($post_data['account_tel1']) ? $post_data['account_tel1'] : '',
						'tel2'				=> isset($post_data['account_tel2']) ? $post_data['account_tel2'] : '',
						'tel3'				=> isset($post_data['account_tel3']) ? $post_data['account_tel3'] : '',
						'fax1'				=> !empty($post_data['account_fax1']) ? $post_data['account_fax1'] : NULL,
						'fax2'				=> !empty($post_data['account_fax2']) ? $post_data['account_fax2'] : NULL,
						'fax3'				=> !empty($post_data['account_fax3']) ? $post_data['account_fax3'] : NULL,
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
						'update_time'		=> $now
					);
					$this->m_account->update(array('owner_id' => $owner_id), $update_data_account);
				}
				else {
					$insert_data_account = array(
						'owner_id'			=> $owner_id,
						'corporation'		=> isset($post_data['corporation']) ? $post_data['corporation'] : '',
						'corpo_name'		=> isset($post_data['account_corpo_name']) ? $post_data['account_corpo_name'] : '',
						'executive'			=> !empty($post_data['account_executive']) ? $post_data['account_executive'] : NULL,
						'zip1'				=> isset($post_data['account_zip1']) ? $post_data['account_zip1'] : '',
						'zip2'				=> isset($post_data['account_zip2']) ? $post_data['account_zip2'] : '',
						'pref'				=> isset($post_data['account_pref']) ? $post_data['account_pref'] : '',
						'addr1'				=> isset($post_data['account_addr1']) ? $post_data['account_addr1'] : '',
						'addr2'				=> isset($post_data['account_addr2']) ? $post_data['account_addr2'] : '',
						'tel1'				=> isset($post_data['account_tel1']) ? $post_data['account_tel1'] : '',
						'tel2'				=> isset($post_data['account_tel2']) ? $post_data['account_tel2'] : '',
						'tel3'				=> isset($post_data['account_tel3']) ? $post_data['account_tel3'] : '',
						'fax1'				=> !empty($post_data['account_fax1']) ? $post_data['account_fax1'] : NULL,
						'fax2'				=> !empty($post_data['account_fax2']) ? $post_data['account_fax2'] : NULL,
						'fax3'				=> !empty($post_data['account_fax3']) ? $post_data['account_fax3'] : NULL,
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
					$this->m_account->insert($insert_data_account);
				}
			}
		}

		$this->db->trans_complete();

		$flg_error = FALSE;
		if( $this->db->trans_status() === FALSE ) {
			$flg_error = TRUE;
		}

		redirect('admin/owner/index/ok');
		return;
	}

	public function detail($owner_id = '')
	{
		// ログイン済みチェック
		if( !$this->chk_logged_in_admin() ) {
			redirect('admin');
			return;
		}

		$owner_data = $this->m_owner->get_one(array('owner_id' => $owner_id));
		$account_data = $this->m_account->get_one(array('owner_id' => $owner_id));
		$classroom_data = $this->m_classroom->get_list(array('owner_id' => $owner_id));

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

		$view_data = array(
			'CONF'	=> $this->conf,
			'ODATA'	=> $owner_data,
			'ADATA'	=> $account_data,
			'CDATA'	=> $classroom_data,
			'PAYMENT'	=> implode(',', $payment_method),
		);

		$this->load->view('admin/owner/detail', $view_data);
	}

	public function register($owner_id = '')
	{
		// ログイン済みチェック
		if( !$this->chk_logged_in_admin() ) {
			redirect('admin');
			return;
		}

		$owner_data = $this->m_owner->get_one(array('owner_id' => $owner_id));
		$account_data = $this->m_account->get_one(array('owner_id' => $owner_id));
		$classroom_data = $this->m_classroom->get_list(array('owner_id' => $owner_id));

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

		$view_data = array(
			'CONF'	=> $this->conf,
			'ODATA'	=> $owner_data,
			'ADATA'	=> $account_data,
			'CDATA'	=> $classroom_data,
			'PAYMENT'	=> implode(',', $payment_method),
		);

		$this->load->view('admin/owner/register', $view_data);
	}

	public function dl_classroom($owner_id = '')
	{
		// ログイン済みチェック
		if( !$this->chk_logged_in_admin() ) {
			redirect('admin');
			return;
		}

		$classroom_data = $this->m_classroom->get_list(array('owner_id' => $owner_id));

		// タイムアウトさせない
		set_time_limit(0);

		$fp = fopen('php://output', 'w');
		stream_filter_append($fp, 'convert.iconv.UTF-8/CP932//TRANSLIT', STREAM_FILTER_WRITE);

		header("Content-Type: application/octet-stream");
		header("Content-Disposition: attachment; filename=" . 'classroom' . $owner_id . '_' . date('YmdHis') . '.csv');

		if( empty($classroom_data) ) {
			fputs($fp, 'no data');
		}
		else {
			$csv_array = array(
				'教室名',
				'郵便番号',
				'都道府県コード',
				'都道府県',
				'住所',
				'電話番号'
			);
			fputcsv($fp, $csv_array);

			foreach( $classroom_data as $val ) {
				$csv_array = array(
					$val['name'],
					$val['zip'],
					$val['pref'],
					$this->conf['pref'][$val['pref']],
					$val['address'],
					$val['tel']
				);
				fputcsv($fp, $csv_array);
			}
		}

		fclose($fp);
	}

	public function do_register($owner_id = '')
	{
		// ログイン済みチェック
		if( !$this->chk_logged_in_admin() ) {
			redirect('admin');
			return;
		}

		$owner_data = $this->m_owner->get_one(array('owner_id' => $owner_id));
		if( empty($owner_data) ) {
			redirect('admin/owner/index/err1');
			return;
		}
		else {
			if( $owner_data['flg_complete'] != '1' ) {
				redirect('admin/owner/index/err2');
				return;
			}
			else {
				$update_data = array(
					'flg_complete'	=> '2',
					'update_time'	=> date('Y-m-d H:i:s')
				);

				if( $this->m_owner->update(array('owner_id' => $owner_id), $update_data) ) {
					// モデルロード
					$this->load->model('m_mail');

					// 設定ファイルロード
					$this->config->load('config_mail', TRUE, TRUE);
					$this->conf_mail = $this->config->item('mail', 'config_mail');

					$mail_body = $this->load->view('mail/tmpl_register_complete', $owner_data, TRUE);
					$params = array(
						'from'		=> $this->conf_mail['apply_comp_to_customer']['from'],
						'from_name'	=> $this->conf_mail['apply_comp_to_customer']['from_name'],
						'to'		=> $owner_data['email'],
						'subject'	=> '【教材発注システム】登録完了 ※まだご注文いただけません',
						'message'	=> $mail_body
					);

					$this->m_mail->send($params);
				}
				else {
					redirect('admin/owner/index/err3');
					return;
				}
			}
		}

		redirect('admin/owner/index/ok');
		return;
	}



	/*******************************************/
	/*                ajax関数                 */
	/*******************************************/
	public function ajax_del()
	{
		$post_data = $this->input->post();
		$owner_id = isset($post_data['owner_id']) ? $post_data['owner_id'] : '';

		$ret_val = array(
			'status'			=> FALSE,
			'err_msg'			=> ''
		);

		if( $owner_id == '' ) {
			$ret_val['err_msg'] = 'パラメータエラーが発生しました。';
		}
		else {
			$owner_data = $this->m_owner->get_one(array('owner_id' => $owner_id));
			if( empty($owner_data) ) {
				$ret_val['err_msg'] = '削除するオーナー情報が存在しません。';
			}
			else {
				$this->db->trans_start();

				$now = date('Y-m-d H:i:s');

				// オーナー情報に紐づく掛け情報削除
				$update_account = array(
					'update_time'	=> $now,
					'status'		=> '9'
				);
				$this->m_account->update(array('owner_id' => $owner_id), $update_account);

				// オーナー情報に紐づく教室の紐づけ削除、初期化
				$update_classroom = array(
					'smile_code1'	=> NULL,
					'smile_code2'	=> NULL,
					'smile_code3'	=> NULL,
					'owner_id'		=> NULL,
					'email'			=> NULL,
					'password'		=> NULL,
					'gmo_member_id'	=> NULL,
					'flg_instruction'	=> '1',
					'update_time'	=> $now
				);
				$this->m_classroom->update(array('owner_id' => $owner_id), $update_classroom);

				// オーナー情報削除
				$update_owner = array(
					'update_time'	=> $now,
					'status'		=> '9'
				);
				$this->m_owner->update(array('owner_id' => $owner_id), $update_owner);

				$this->db->trans_complete();

				if( $this->db->trans_status() === FALSE ) {
					$ret_val['err_msg'] = 'データベースエラーが発生しました。';
				}
				else {
					$ret_val['status'] = TRUE;
				}
			}
		}

		$this->ajax_out(json_encode($ret_val));
	}

	public function ajax_search_classroom()
	{
		$post_data = $this->input->post();
		$classroom_name = isset($post_data['classroom_name']) ? $post_data['classroom_name'] : '';

		$ret_val = array(
			'status'	=> FALSE,
			'err_msg'	=> '',
			'classroom'	=> array()
		);

		$classroom_data = $this->m_classroom->get_list('name LIKE "%' . $classroom_name . '%"');
		$classroom = array();

		if( !empty($classroom_data) ) {
			foreach( $classroom_data as $val ) {
				if( empty($val['owner_id']) ) {
					$classroom[$val['classroom_id']] = $val['name'];
				}
			}
		}

		if( empty($classroom) ) {
			$ret_val['err_msg'] = '該当の教室はありません。';
		}
		else {
			$ret_val['status'] = TRUE;
			$ret_val['classroom'] = $classroom;
		}

		$this->ajax_out(json_encode($ret_val));
	}

	public function ajax_register_smile_code()
	{
		$post_data = $this->input->post();
		$classroom_id = isset($post_data['classroom_id']) ? $post_data['classroom_id'] : '';
		$smile_code1 = !empty($post_data['smile_code1']) ? $post_data['smile_code1'] : NULL;
		$smile_code2 = !empty($post_data['smile_code2']) ? $post_data['smile_code2'] : NULL;
		$smile_code3 = !empty($post_data['smile_code3']) ? $post_data['smile_code3'] : NULL;
		$en_code1 = !empty($post_data['en_code1']) ? $post_data['en_code1'] : NULL;
		$en_code2 = !empty($post_data['en_code2']) ? $post_data['en_code2'] : NULL;

		$ret_val = array(
			'status'	=> FALSE,
			'err_msg'	=> ''
		);

		if( $classroom_id == '' ) {
			$ret_val['err_msg'] = 'パラメータエラーが発生しました。';
		}
		else {
			$wk_classroom_data = $this->m_classroom->get_one(array('classroom_id' => $classroom_id));
			if( empty($wk_classroom_data) ) {
				$ret_val['err_msg'] = '該当の教室が存在しません。';
			}
			else {
				$update_data = array(
					'smile_code1'	=> $smile_code1,
					'smile_code2'	=> $smile_code2,
					'smile_code3'	=> $smile_code3,
					'en_code1'		=> $en_code1,
					'en_code2'		=> $en_code2,
					'update_time'	=> date('Y-m-d H:i:s')
				);

				if( $this->m_classroom->update(array('classroom_id' => $classroom_id), $update_data) ) {
					$ret_val['status'] = TRUE;
				}
				else {
					$ret_val['err_msg'] = 'データベースエラーが発生しました。';
				}
			}
		}

		$this->ajax_out(json_encode($ret_val));
	}



	/*******************************************/
	/*          ajax関数(bootgrid用)           */
	/*******************************************/
	public function get_bootgrid()
	{
		$post_data = $this->input->post();
		$current = isset($post_data['current']) ? intval($post_data['current']) : 1;
		$rowCount = isset($post_data['rowCount']) ? intval($post_data['rowCount']) : 10;
		$searchPhrase = isset($post_data['searchPhrase']) ? $post_data['searchPhrase'] : '';
		$sort = isset($post_data['sort']) ? $post_data['sort'] : array();

		$sort_str = '';
		foreach( $sort as $sort_key => $sort_val ) {
			$sort_str .= $sort_key . ' ' . $sort_val;
		}

		if( $rowCount != -1 ) {
			$limit_array = array($rowCount, ($current - 1) * $rowCount);
		}
		else {
			$limit_array = '';
		}

		if( $searchPhrase != '' ) {
			$where = 'owner_name LIKE "%' . $searchPhrase . '%" OR corpo_name LIKE "%' . $searchPhrase . '%"';
		}
		else {
			$where = '';
		}

		$owner_data = $this->m_owner->get_list($where, $sort_str, $limit_array);
		$owner_all_data = $this->m_owner->get_list($where);

		$row_val = array();

		if( !empty($owner_data) ) {
			foreach( $owner_data as $val ) {
				$classroom_array = array();
				$classroom_data = $this->m_classroom->get_list(array('owner_id' => $val['owner_id']));
				if( !empty($classroom_data) ) {
					foreach( $classroom_data as $classroom_val ) {
						$classroom_array[] = $classroom_val['name'];
					}
				}

				$payment_array = array();
				if( $val['payment_method1'] == '1' ) {
					$payment_array[] = '買掛';
				}

				if( $val['payment_method2'] == '1' ) {
					$payment_array[] = 'クレジットカード';
				}

				if( $val['payment_method3'] == '1' ) {
					$payment_array[] = '代金引換';
				}

				$row_val[] = array(
					'owner_id'		=> $val['owner_id'],
					'flg_complete'	=> $val['flg_complete'],
					'regist_time'	=> $val['regist_time'],
					'owner_name'	=> $val['owner_name'],
					'corpo_name'	=> $val['corpo_name'],
					'classroom'		=> implode(',', $classroom_array) . '（' . count($classroom_array) . '教室）',
					'payment_method'=> implode(',', $payment_array)
				);
			}
		}

		$ret_val = array(
			'current'	=> $current,
			'rowCount'	=> $rowCount,
			'total'		=> count($owner_all_data),
			'rows'		=> $row_val
		);

		$this->ajax_out(json_encode($ret_val));
	}
}
