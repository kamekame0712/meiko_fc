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
	// ログイン済みチェック（管理画面）
	protected function chk_logged_in()
	{
		if( $this->session->userdata('admin_id') == FALSE ) {
			return FALSE;
		}
		else {
			return TRUE;
		}
	}

	// ファイルアップロード
	protected function do_upload($config, $field_name='filename')
	{
		$this->load->library('upload');
		$this->upload->initialize($config);

		$ret = array(
			'status'	=> TRUE,
			'data'		=> array(),
			'msg'		=> ''
		);
		if( !$this->upload->do_upload($field_name) ) {
			$ret['status'] = FALSE;
			$ret['msg'] = $this->upload->display_errors('<p class="text-danger">', '</p>');
		}
		else {
			$ret['data'] = $this->upload->data();
		}

		return $ret;
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
		$this->load->model('m_juku');

		$login_id = isset($_POST['login_id']) ? $_POST['login_id'] : '';
		$password = isset($_POST['password']) ? $_POST['password'] : '';

		$login_flg = $this->m_juku->possible_login($login_id, $password);
		if( $login_flg == FALSE ) {
			$this->form_validation->set_message('possible_login', '入力内容に誤りがあります。');
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

	// テキスト管理 ⇒ SMILEコード
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
}
