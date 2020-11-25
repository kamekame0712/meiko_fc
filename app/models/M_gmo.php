<?php
/**
 * GMO関連クラス
 * ※特定のテーブルをアクセスするためのモデルではなく、
 *   GMOにアクセスするためのモデル
 *   helperだとconfig等にアクセスしたり、CURL使ったりが面倒臭いのでモデルで実装
 */


class M_gmo extends MY_Model
{

	public $shop_id = '';
	public $shop_pass = '';
	public $site_id = '';
	public $site_pass = '';

	function __construct()
	{
		parent::__construct();

		// 設定ファイルロード
		$this->load->config('config_gmo');
		$gmo_conf = $this->config->item('gmo');
		$this->shop_id = $gmo_conf['SHOP_ID'];
		$this->shop_pass = $gmo_conf['SHOP_PASS'];
		$this->site_id = $gmo_conf['SITE_ID'];
		$this->site_pass = $gmo_conf['SITE_PASS'];

		set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__FILE__) . '/../libraries\gmo\src');
	}

	// 取引登録
	public function entry_tran($order_id = '', $amount = '')
	{
		if( $order_id == '' || $amount == '' ) {
			return 'パラメータエラー';
		}

		require_once('com/gmo_pg/client/input/EntryTranInput.php');
		require_once('com/gmo_pg/client/tran/EntryTran.php');

		$input = new EntryTranInput();

		//各種パラメータを設定
		$input->setShopId($this->shop_id);
		$input->setShopPass($this->shop_pass);
		$input->setJobCd('CAPTURE');	// CAPTURE:即時売上 AUTH:仮売上
		$input->setOrderId($order_id);
		$input->setAmount($amount);

		$exe = new EntryTran();
		$output = $exe->exec($input);

		if( $exe->isExceptionOccured() ) { // エラー発生
			return $this->get_exe_error($exe);
		}
		else {
			if( $output->isErrorOccurred() ) { // エラー発生
				return $this->get_output_error($output);
			}
		}

		return array(
			'accessId'		=> $output->getAccessId(),
			'accessPass'	=> $output->getAccessPass()
		);

//		return $this->convert_array($output);
	}

	// 決済 カード番号入力
	public function exec_tran($order_id = '', $access_id = '', $access_pass = '', $card_num = '', $card_limit = '')
	{
		if( $order_id == '' || $access_id == '' || $access_pass == '' || $card_num == '' || $card_limit == '' ) {
			return 'パラメータエラー';
		}

		require_once('com/gmo_pg/client/input/ExecTranInput.php');
		require_once('com/gmo_pg/client/tran/ExecTran.php');

		$input = new ExecTranInput();

		//各種パラメータを設定
		$input->setAccessId($access_id);
		$input->setAccessPass($access_pass);
		$input->setOrderId($order_id);
		$input->setMethod('1');	// 1:一括
		$input->setCardNo($card_num);
		$input->setExpire($card_limit);

		$exe = new ExecTran();
		$output = $exe->exec($input);

		if( $exe->isExceptionOccured() ) { // エラー発生
			return $this->get_exe_error($exe);
		}
		else {
			if( $output->isErrorOccurred() ) { // エラー発生
				return $this->get_output_error($output);
			}
		}

		return $this->convert_array($output);
	}

	// 決済 カード番号入力 トークン決済版
	public function exec_tran_token($order_id = '', $access_id = '', $access_pass = '', $token = '')
	{
		if( $order_id == '' || $access_id == '' || $access_pass == '' || $token == '' ) {
			return 'パラメータエラー';
		}

		require_once('com/gmo_pg/client/input/ExecTranInput.php');
		require_once('com/gmo_pg/client/tran/ExecTran.php');

		$input = new ExecTranInput();

		//各種パラメータを設定
		$input->setAccessId($access_id);
		$input->setAccessPass($access_pass);
		$input->setOrderId($order_id);
		$input->setMethod('1');	// 1:一括
		$input->setToken($token);

		$exe = new ExecTran();
		$output = $exe->exec($input);

		if( $exe->isExceptionOccured() ) { // エラー発生
			return $this->get_exe_error($exe);
		}
		else {
			if( $output->isErrorOccurred() ) { // エラー発生
				return $this->get_output_error($output);
			}
		}

		return $this->convert_array($output);
	}

	// 決済 登録済みカード使用
	public function exec_tran_registered($order_id = '', $access_id = '', $access_pass = '', $member_id = '', $card_sequence = 0)
	{
		if( $order_id == '' || $access_id == '' || $access_pass == '' || $member_id == '' ) {
			return 'パラメータエラー';
		}

		require_once('com/gmo_pg/client/input/ExecTranInput.php');
		require_once('com/gmo_pg/client/tran/ExecTran.php');

		$input = new ExecTranInput();

		//各種パラメータを設定
		$input->setSiteId($this->site_id);
		$input->setSitePass($this->site_pass);
		$input->setMemberId($member_id);
		$input->setAccessId($access_id);
		$input->setAccessPass($access_pass);
		$input->setOrderId($order_id);
		$input->setMethod('1');	// 1:一括
		$input->setCardSeq($card_sequence);

		$exe = new ExecTran();
		$output = $exe->exec($input);

		if( $exe->isExceptionOccured() ) { // エラー発生
			return $this->get_exe_error($exe);
		}
		else {
			if( $output->isErrorOccurred() ) { // エラー発生
				return $this->get_output_error($output);
			}
		}

		return $this->convert_array($output);
	}

	// 会員情報登録
	public function save_member($member_id = '')
	{
		if( $member_id == '' ) {
			return 'パラメータエラー';
		}

		require_once('com/gmo_pg/client/input/SaveMemberInput.php');
		require_once('com/gmo_pg/client/tran/SaveMember.php');

		$input = new SaveMemberInput();

		//各種パラメータを設定
		$input->setSiteId($this->site_id);
		$input->setSitePass($this->site_pass);
		$input->setMemberId($member_id);

		$exe = new SaveMember();
		$output = $exe->exec($input);

		if( $exe->isExceptionOccured() ) { // エラー発生
			return $this->get_exe_error($exe);
		}
		else {
			if( $output->isErrorOccurred() ) { // エラー発生
				return $this->get_output_error($output);
			}
		}

		return $this->convert_array($output);
	}

	// カード登録
	public function save_card($member_id = '', $token = '')
	{
		if( $member_id == '' || $token == '' ) {
			return 'パラメータエラー';
		}

		require_once('com/gmo_pg/client/input/SaveCardInput.php');
		require_once('com/gmo_pg/client/tran/SaveCard.php');

		$input = new SaveCardInput();

		//各種パラメータを設定
		$input->setSiteId($this->site_id);
		$input->setSitePass($this->site_pass);
		$input->setMemberId($member_id);
		$input->setToken($token);

		$exe = new SaveCard();
		$output = $exe->exec($input);

		if( $exe->isExceptionOccured() ) { // エラー発生
			return $this->get_exe_error($exe);
		}
		else {
			if( $output->isErrorOccurred() ) { // エラー発生
				return $this->get_output_error($output);
			}
		}

		return $this->convert_array($output);
	}

	// 決済使用カードの登録
	public function traded_card($order_id = '', $member_id = '', $holder_name = '')
	{
		if( $order_id == '' || $member_id == '' ) {
			return 'パラメータエラー';
		}

		require_once('com/gmo_pg/client/input/TradedCardInput.php');
		require_once('com/gmo_pg/client/tran/TradedCard.php');

		$input = new TradedCardInput();

		//各種パラメータを設定
		$input->setShopId($this->shop_id);
		$input->setShopPass($this->shop_pass);
		$input->setOrderId($order_id);
		$input->setSiteId($this->site_id);
		$input->setSitePass($this->site_pass);
		$input->setMemberId($member_id);
		$input->setHolderName($holder_name);

		$exe = new TradedCard();
		$output = $exe->exec($input);

		if( $exe->isExceptionOccured() ) { // エラー発生
			return $this->get_exe_error($exe);
		}
		else {
			if( $output->isErrorOccurred() ) { // エラー発生
				return $this->get_output_error($output);
			}
		}

		return $this->convert_array($output);
	}

	// カード変更
	public function modify_card($member_id = '', $card_num = '', $card_limit = '')
	{
		if( $member_id == '' || $card_num == '' || $card_limit == '' ) {
			return 'パラメータエラー';
		}

		require_once('com/gmo_pg/client/input/SaveCardInput.php');
		require_once('com/gmo_pg/client/tran/SaveCard.php');

		$input = new SaveCardInput();

		//各種パラメータを設定
		$input->setSiteId($this->site_id);
		$input->setSitePass($this->site_pass);
		$input->setMemberId($member_id);
		$input->setCardNo($card_num);
		$input->setExpire($card_limit);
		$input->setSeqMode('0');	// 0:論理モード
		$input->setCardSeq(0);	// カードは１枚しか登録させない

		$exe = new SaveCard();
		$output = $exe->exec($input);

		if( $exe->isExceptionOccured() ) { // エラー発生
			return $this->get_exe_error($exe);
		}
		else {
			if( $output->isErrorOccurred() ) { // エラー発生
				return $this->get_output_error($output);
			}
		}

		return $this->convert_array($output);
	}

	// カード削除
	public function delete_card($member_id = '', $card_sequence = 0)
	{
		if( $member_id == '' ) {
			return 'パラメータエラー';
		}

		require_once('com/gmo_pg/client/input/DeleteCardInput.php');
		require_once('com/gmo_pg/client/tran/DeleteCard.php');

		$input = new DeleteCardInput();

		//各種パラメータを設定
		$input->setSiteId($this->site_id);
		$input->setSitePass($this->site_pass);
		$input->setMemberId($member_id);
		$input->setSeqMode('0');	// 0:論理モード
		$input->setCardSeq($card_sequence);

		$exe = new DeleteCard();
		$output = $exe->exec($input);

		if( $exe->isExceptionOccured() ) { // エラー発生
			return $this->get_exe_error($exe);
		}
		else {
			if( $output->isErrorOccurred() ) { // エラー発生
				return $this->get_output_error($output);
			}
		}

		return $this->convert_array($output);
	}

	// カード参照
	public function search_card($member_id = '')
	{
		if( $member_id == '' ) {
			return 'パラメータエラー';
		}

		require_once('com/gmo_pg/client/input/SearchCardInput.php');
		require_once('com/gmo_pg/client/tran/SearchCard.php');

		$input = new SearchCardInput();

		//各種パラメータを設定
		$input->setSiteId($this->site_id);
		$input->setSitePass($this->site_pass);
		$input->setMemberId($member_id);
		$input->setSeqMode('0');	// 0:論理モード

		$exe = new SearchCard();
		$output = $exe->exec($input);

		if( $exe->isExceptionOccured() ) { // エラー発生
			return $this->get_exe_error($exe);
		}
		else {
			if( $output->isErrorOccurred() ) { // エラー発生
				return $this->get_output_error($output);
			}
		}

		return $output->getCardList();
	}



	/***********************************************/
	/*               privateメソッド               */
	/***********************************************/
	// outputの戻り値（object）を配列に変換
	private function convert_array($object)
	{
		return json_decode(json_encode($object), true);
	}

	// exeエラー
	private function get_exe_error($exe)
	{
		$exception = $exe->getException();
		return $exception->getMessage();
	}

	// outputエラー
	private function get_output_error($output)
	{
		require_once('ErrorMessageHandler.php');
		$errorHandle = new ErrorHandler();
		$errorList = $output->getErrList();

		$ret_str = '';
		foreach( $errorList as $errorInfo ) {
			$ret_str .= $errorInfo->getErrCode() . '-' . $errorInfo->getErrInfo() . ':' . $errorHandle->getMessage($errorInfo->getErrInfo()) . '<br />';
		}

		return $ret_str;
	}

}
