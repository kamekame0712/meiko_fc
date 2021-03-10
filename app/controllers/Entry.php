<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Entry extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		// モデルロード
		$this->load->model('m_classroom');

		// バリデーションエラー設定
		$this->form_validation->set_error_delimiters('<p class="error-msg">', '</p>');
	}

	public function index()
	{
		$post_data = $this->input->post();
		$classroom_number = isset($post_data['classroom_number']) ? $post_data['classroom_number'] : '';

		$classroom_name = '';
		if( $classroom_number != '' ) {
			$classroom_data = $this->m_classroom->get_one(array('classroom_number' => $classroom_number));
			if( !empty($classroom_data) ) {
				$classroom_name = $classroom_data['name'];
			}
		}

		$view_data = array(
			'CNAME'	=> $classroom_name
		);

		$this->load->view('front/entry/index', $view_data);
	}

	public function confirm()
	{
		$post_data = $this->input->post();
		$classroom_number = isset($post_data['classroom_number']) ? $post_data['classroom_number'] : '';

		$classroom_name = '';
		if( $classroom_number != '' ) {
			$classroom_data = $this->m_classroom->get_one(array('classroom_number' => $classroom_number));
			if( !empty($classroom_data) ) {
				$classroom_name = $classroom_data['name'];
			}
		}

		// バリデーションチェック
		if( $this->form_validation->run('entry') == FALSE ) {
			$view_data = array(
				'CNAME'	=> $classroom_name
			);

			$this->load->view('front/entry/index', $view_data);
			return;
		}

		$view_data = array(
			'PDATA'	=> $post_data,
			'CNAME'	=> $classroom_name
		);

		$this->load->view('front/entry/confirm', $view_data);
	}

	public function complete()
	{
		$post_data = $this->input->post();
		$classroom_number = isset($post_data['classroom_number']) ? $post_data['classroom_number'] : '';
		$email = isset($post_data['email']) ? $post_data['email'] : '';
		$password_hidden = isset($post_data['password_hidden']) ? $post_data['password_hidden'] : '';

		$update_data = array(
			'email'			=> $email,
			'password'		=> $this->m_classroom->get_hashed_pass($password_hidden),
			'update_time'	=> date('Y-m-d H:i:s')
		);

		$flg_commit = TRUE;
		if( !$this->m_classroom->update(array('classroom_number' => $classroom_number), $update_data) ) {
			$flg_commit = FALSE;
		}

		$view_data = array(
			'COMMIT'	=> $flg_commit
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
			'err_msg'			=> '',
			'classroom_name'	=> ''
		);

		$classroom_data = $this->m_classroom->get_one(array('classroom_number' => $classroom_number));
		if( empty($classroom_data) ) {
			$ret_val['err_msg'] = '入力された教室コードは存在しません。';
		}
		else if( empty($classroom_data['owner_id']) ) {
			$ret_val['err_msg'] = 'オーナー様のご利用申込みがお済みではありません。' . "\r\n" . 'ご利用申込み状況のご確認をお願いします。';
			$ret_val['classroom_name'] = $classroom_data['name'];
		}
		else if( empty($classroom_data['smile_code1']) && empty($classroom_data['smile_code2']) && empty($classroom_data['smile_code3']) ) {
			$ret_val['err_msg'] = 'オーナー様にご利用申込みをいただいておりますが、弊社作業中です。' . "\r\n" . 'ご利用可能になりましたら、改めてオーナー様にご連絡いたします。大変申し訳ございませんが、もうしばらくお待ちください。';
			$ret_val['classroom_name'] = $classroom_data['name'];
		}
		else if( !empty($classroom_data['email']) ) {
			$ret_val['err_msg'] = 'すでにご登録いただいております。' . "\r\n" . 'パスワードをお忘れの場合、ログイン画面にございます『パスワードをお忘れの方はこちら』からお問い合わせください。';
			$ret_val['classroom_name'] = $classroom_data['name'];
		}
		else {
			$ret_val['status'] = TRUE;
			$ret_val['classroom_name'] = $classroom_data['name'];
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
