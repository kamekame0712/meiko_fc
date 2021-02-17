<?php
/**
 * 共通コントローラ
 */
class MY_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// 言語ヘルパー
		$this->load->helper(array('language'));

		date_default_timezone_set('Asia/Tokyo');
	}



	/*****************************************/
	/*                                       */
	/*    各コントローラー共通の関数         */
	/*                                       */
	/*****************************************/
	// ログイン済みチェック（フロント）
	protected function chk_logged_in()
	{
		if( $this->session->userdata('classroom_id') == FALSE ) {
			return FALSE;
		}
		else {
			return TRUE;
		}
	}

	// ログイン済みチェック（管理画面）
	protected function chk_logged_in_admin()
	{
		if( $this->session->userdata('admin_id') == FALSE ) {
			return FALSE;
		}
		else {
			return TRUE;
		}
	}

	// Ajax出力
	protected function ajax_out($data)
	{
		$this->output
			->set_content_type('json','utf-8')
			->set_header('Cache-Control: no-cache, must-revalidate')
			->set_header('Pragma: no-cache')
			->set_output($data);
	}



	/*****************************************/
	/*                                       */
	/*    バリデーション コールバック関数    */
	/*                                       */
	/*****************************************/
	// ログイン
	public function possible_login()
	{
		// モデルロード
		$this->load->model('m_classroom');

		$email = isset($_POST['email']) ? $_POST['email'] : '';
		$password = isset($_POST['password']) ? $_POST['password'] : '';

		$login_flg = $this->m_classroom->possible_login($email, $password);
		if( $login_flg == FALSE ) {
			$this->form_validation->set_message('possible_login', 'ご入力の内容ではログインできません。');
			return FALSE;
		}

		return TRUE;
	}

	// ログイン（管理画面）
	public function possible_admin_login()
	{
		// モデルロード
		$this->load->model('m_admin');

		$email = isset($_POST['email']) ? $_POST['email'] : '';
		$password = isset($_POST['password']) ? $_POST['password'] : '';

		$login_flg = $this->m_admin->possible_login($email, $password);
		if( $login_flg == FALSE ) {
			$this->form_validation->set_message('possible_admin_login', '入力内容に誤りがあります。');
			return FALSE;
		}

		return TRUE;
	}

	// 郵便番号
	public function chk_zip()
	{
		$zip1 = isset($_POST['zip1']) ? $_POST['zip1'] : '';
		$zip2 = isset($_POST['zip2']) ? $_POST['zip2'] : '';

		if( $zip1 == '' || $zip2 == '' ) {
			$this->form_validation->set_message('chk_zip', '%s 欄は必須です。');
			return FALSE;
		}

		if( !preg_match('/^[0-9]{3}$/', $zip1) || !preg_match('/^[0-9]{4}$/', $zip2) ) {
			$this->form_validation->set_message('chk_zip', '%s 欄が正しくありません。');
			return FALSE;
		}

		return TRUE;
	}

	// 住所
	public function chk_address()
	{
		$pref = isset($_POST['pref']) ? $_POST['pref'] : '';
		$addr1 = isset($_POST['addr1']) ? $_POST['addr1'] : '';

		if( $pref == '' || $addr1 == '' ) {
			$this->form_validation->set_message('chk_address', '%s 欄は必須です。');
			return FALSE;
		}

		return TRUE;
	}

	// 電話番号
	public function chk_tel()
	{
		$tel1 = isset($_POST['tel1']) ? $_POST['tel1'] : '';
		$tel2 = isset($_POST['tel2']) ? $_POST['tel2'] : '';
		$tel3 = isset($_POST['tel3']) ? $_POST['tel3'] : '';

		if( $tel1 == '' || $tel2 == '' || $tel3 == '' ) {
			$this->form_validation->set_message('chk_tel', '%s 欄は必須です。');
			return FALSE;
		}

		if( !preg_match('/^[0-9]{2,5}$/', $tel1) || !preg_match('/^[0-9]{1,4}$/', $tel2) || !preg_match('/^[0-9]{4}$/', $tel3) ) {
			$this->form_validation->set_message('chk_tel', '%s 欄が正しくありません。');
			return FALSE;
		}

		return TRUE;
	}

	// 運営教室
	public function chk_classroom_number()
	{
		// モデルロード
		$this->load->model('m_classroom');

		$classroom_number = !empty($_POST['classroom_number']) ? $_POST['classroom_number'] : array();

		$flg_empty = TRUE;
		$flg_incorrect = FALSE;
		$flg_already = FALSE;
		foreach( $classroom_number as $val ) {
			if( !empty($val) ) {
				$classroom_data = $this->m_classroom->get_one(array('classroom_number' => $val));
				if( !empty($classroom_data) ) {
					$flg_empty = FALSE;

					if( !empty($classroom_data['owner_id']) ) {
						$flg_already = TRUE;
					}
				}
				else {
					$flg_incorrect = TRUE;
				}
			}
		}

		if( $flg_empty ) {
			$this->form_validation->set_message('chk_classroom_number', '%s 欄は少なくとも１教室以上は必須です。');
			return FALSE;
		}

		if( $flg_incorrect ) {
			$this->form_validation->set_message('chk_classroom_number', '%s 欄に正しくない教室コードが入力されています。');
			return FALSE;
		}

		if( $flg_already ) {
			$this->form_validation->set_message('chk_classroom_number', '%s 欄に他のオーナーが運営している教室の教室コードが入力されています。');
			return FALSE;
		}

		$value_count = array_count_values($classroom_number);
		unset($value_count['']);
		if( max($value_count) > 1 ) {
			$this->form_validation->set_message('chk_classroom_number', '%s 欄に重複した教室コードが入力されています。');
			return FALSE;
		}

		return TRUE;
	}

	// お支払方法
	public function chk_payment_method()
	{
		$payment_method1 = isset($_POST['payment_method1']) ? $_POST['payment_method1'] : '';
		$payment_method2 = isset($_POST['payment_method2']) ? $_POST['payment_method2'] : '';
		$payment_method3 = isset($_POST['payment_method3']) ? $_POST['payment_method3'] : '';

		if( $payment_method1 == '' && $payment_method2 == '' && $payment_method3 == '' ) {
			$this->form_validation->set_message('chk_payment_method', '%s 欄は必須です。');
			return FALSE;
		}

		return TRUE;
	}

	// 掛け登録先郵便番号
	public function chk_account_zip()
	{
		$account_zip1 = isset($_POST['account_zip1']) ? $_POST['account_zip1'] : '';
		$account_zip2 = isset($_POST['account_zip2']) ? $_POST['account_zip2'] : '';

		if( $account_zip1 == '' || $account_zip2 == '' ) {
			$this->form_validation->set_message('chk_account_zip', '%s 欄は必須です。');
			return FALSE;
		}

		if( !preg_match('/^[0-9]{3}$/', $account_zip1) || !preg_match('/^[0-9]{4}$/', $account_zip2) ) {
			$this->form_validation->set_message('chk_account_zip', '%s 欄が正しくありません。');
			return FALSE;
		}

		return TRUE;
	}

	// 掛け登録先住所
	public function chk_account_address()
	{
		$account_pref = isset($_POST['account_pref']) ? $_POST['account_pref'] : '';
		$account_addr1 = isset($_POST['account_addr1']) ? $_POST['account_addr1'] : '';

		if( $account_pref == '' || $account_addr1 == '' ) {
			$this->form_validation->set_message('chk_account_address', '%s 欄は必須です。');
			return FALSE;
		}

		return TRUE;
	}

	// 掛け登録先電話番号
	public function chk_account_tel()
	{
		$account_tel1 = isset($_POST['account_tel1']) ? $_POST['account_tel1'] : '';
		$account_tel2 = isset($_POST['account_tel2']) ? $_POST['account_tel2'] : '';
		$account_tel3 = isset($_POST['account_tel3']) ? $_POST['account_tel3'] : '';

		if( $account_tel1 == '' || $account_tel2 == '' || $account_tel3 == '' ) {
			$this->form_validation->set_message('chk_account_tel', '%s 欄は必須です。');
			return FALSE;
		}

		if( !preg_match('/^[0-9]{2,5}$/', $account_tel1) || !preg_match('/^[0-9]{1,4}$/', $account_tel2) || !preg_match('/^[0-9]{4}$/', $account_tel3) ) {
			$this->form_validation->set_message('chk_account_tel', '%s 欄が正しくありません。');
			return FALSE;
		}

		return TRUE;
	}

	// ご請求先郵便番号
	public function chk_bill_zip()
	{
		$bill_zip1 = isset($_POST['bill_zip1']) ? $_POST['bill_zip1'] : '';
		$bill_zip2 = isset($_POST['bill_zip2']) ? $_POST['bill_zip2'] : '';

		if( $bill_zip1 == '' || $bill_zip2 == '' ) {
			$this->form_validation->set_message('chk_bill_zip', '%s 欄は必須です。');
			return FALSE;
		}

		if( !preg_match('/^[0-9]{3}$/', $bill_zip1) || !preg_match('/^[0-9]{4}$/', $bill_zip2) ) {
			$this->form_validation->set_message('chk_bill_zip', '%s 欄が正しくありません。');
			return FALSE;
		}

		return TRUE;
	}

	// ご請求先住所
	public function chk_bill_address()
	{
		$bill_pref = isset($_POST['bill_pref']) ? $_POST['bill_pref'] : '';
		$bill_addr1 = isset($_POST['bill_addr1']) ? $_POST['bill_addr1'] : '';

		if( $bill_pref == '' || $bill_addr1 == '' ) {
			$this->form_validation->set_message('chk_bill_address', '%s 欄は必須です。');
			return FALSE;
		}

		return TRUE;
	}

	// ご請求先電話番号
	public function chk_bill_tel()
	{
		$bill_tel1 = isset($_POST['bill_tel1']) ? $_POST['bill_tel1'] : '';
		$bill_tel2 = isset($_POST['bill_tel2']) ? $_POST['bill_tel2'] : '';
		$bill_tel3 = isset($_POST['bill_tel3']) ? $_POST['bill_tel3'] : '';

		if( $bill_tel1 == '' || $bill_tel2 == '' || $bill_tel3 == '' ) {
			$this->form_validation->set_message('chk_bill_tel', '%s 欄は必須です。');
			return FALSE;
		}

		if( !preg_match('/^[0-9]{2,5}$/', $bill_tel1) || !preg_match('/^[0-9]{1,4}$/', $bill_tel2) || !preg_match('/^[0-9]{4}$/', $bill_tel3) ) {
			$this->form_validation->set_message('chk_bill_tel', '%s 欄が正しくありません。');
			return FALSE;
		}

		return TRUE;
	}

	// お客様情報登録で登録可能な教室コードか確認
	public function possible_enter_classroom_number($classroom_number = '')
	{
		// モデルロード
		$this->load->model('m_classroom');

		if( empty($classroom_number) ) {
			$this->form_validation->set_message('possible_enter_classroom_number', '%s 欄は必須です。');
			return FALSE;
		}

		$classroom_data = $this->m_classroom->get_one(array('classroom_number' => $classroom_number));

		if( empty($classroom_data) ) {
			$this->form_validation->set_message('possible_enter_classroom_number', '入力された教室コードは存在しません。');
			return FALSE;
		}

		if( empty($classroom_data['owner_id']) ) {
			$this->form_validation->set_message('possible_enter_classroom_number', 'オーナー様のご利用申込みがお済みではありません。');
			return FALSE;
		}

		if( empty($classroom_data['smile_code1']) && empty($classroom_data['smile_code2']) && empty($classroom_data['smile_code3']) ) {
			$this->form_validation->set_message('possible_enter_classroom_number', '弊社作業中の教室です。');
			return FALSE;
		}

		if( !empty($classroom_data['email']) ) {
			$this->form_validation->set_message('possible_enter_classroom_number', 'すでにご登録いただいております。');
			return FALSE;
		}

		return TRUE;
	}

	// お客様情報登録で登録可能なメールアドレスか確認
	public function exists_email_classroom($email = '')
	{
		// モデルロード
		$this->load->model('m_classroom');

		$classroom_data = $this->m_classroom->get_one(array('email' => $email));

		if( !empty($classroom_data) ) {
			$this->form_validation->set_message('exists_email_classroom', '入力されたメールアドレはすでに使われています。');
			return FALSE;
		}

		return TRUE;
	}

/*
	// 教材管理 ⇒ SMILEコード
	public function exists_smilecode($code_smile)
	{
		// モデルロード
		$this->load->model('m_product');

		$mode = isset($_POST['mode']) ? $_POST['mode'] : '';
		$product_id = isset($_POST['product_id']) ? $_POST['product_id'] : '';

		if( $mode == '' ) {
			$this->form_validation->set_message('exists_smilecode', 'パラメータエラーが発生しました。');
			return FALSE;
		}

		if( $mode == 'mod' && $product_id == '' ) {
			$this->form_validation->set_message('exists_smilecode', 'パラメータエラーが発生しました。');
			return FALSE;
		}

		if( $mode == 'add' ) {
			$product_data = $this->m_product->get_list(array('code_smile' => $code_smile));
			if( !empty($product_data) ) {
				$this->form_validation->set_message('exists_smilecode', '入力されたSMILEコードはすでに存在しています。');
				return FALSE;
			}
		}
		else {
			$product_data = $this->m_product->get_list(array('code_smile' => $code_smile, 'product_id !=' => $product_id));
			if( !empty($product_data) ) {
				$this->form_validation->set_message('exists_smilecode', '入力されたSMILEコードはすでに存在しています。');
				return FALSE;
			}
		}

		return TRUE;
	}

	// 日付チェック
	public function chk_date($date)
	{
		if( empty($date) ) {
			$this->form_validation->set_message('chk_date', '%s 欄は必須です。');
			return FALSE;
		}

		if( !preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $date) ) {
			$this->form_validation->set_message('chk_date', '%s 欄はyyyy-mm-ddで指定してください。');
			return FALSE;
		}

		$date_array = explode('-', $date);
		$y = intval($date_array[0]);
		$m = intval($date_array[1]);
		$d = intval($date_array[2]);

		if( !checkdate($m, $d, $y) ) {
			$this->form_validation->set_message('chk_date', '%s 欄に存在しない日付が指定されました。');
			return FALSE;
		}

		return TRUE;
	}
*/
}
