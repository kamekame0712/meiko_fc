<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		// モデルロード
		$this->load->model('m_order');

		// 設定ファイルロード
		$this->config->load('config_disp', TRUE, TRUE);
		$this->conf = $this->config->item('disp', 'config_disp');
	}

	public function index()
	{
		// ログイン済みチェック
		if( !$this->chk_logged_in_admin() ) {
			redirect('admin');
			return;
		}

		$view_data = array(
			'CONF'	=> $this->conf
		);

		$this->load->view('admin/order/index', $view_data);
	}

	public function dl_smile()
	{
		// ログイン済みチェック
		if( !$this->chk_logged_in_admin() ) {
			redirect('admin');
			return;
		}

		$post_data = $this->input->post();
		$order_ids = isset($post_data['order_ids']) ? explode(',', $post_data['order_ids']) : array();

		// タイムアウトさせない
		set_time_limit(0);

		$fp = fopen('php://output', 'w');
//		stream_filter_append($fp, 'convert.iconv.UTF-8/CP932', STREAM_FILTER_WRITE);
		stream_filter_append($fp, 'convert.iconv.UTF-8/CP932//TRANSLIT', STREAM_FILTER_WRITE);

		header("Content-Type: application/octet-stream");
		header("Content-Disposition: attachment; filename=" . 'smile_data' . date('YmdHis') . '.csv');

		if( empty($order_ids) ) {
			fputs($fp, 'no data');
		}
		else {
			$csv_array = array(
				'受注日付',
				'得意先コード',
				'得意先名1',
				'担当者名',
				'納品先名',
				'お届け先名2',
				'お届け先郵便番号',
				'お届け先住所',
				'お届け先TEL',
				'支払方法',
				'納期',
				'オーダーNo',
				'商品コード',
				'商品名',
				'規格1',
				'規格2',
				'数量',
				'単価',
				'金額',
				'備考'
			);
			fputcsv($fp, $csv_array);

			foreach( $order_ids as $order_id ) {
				$order_data = $this->m_order->get_one_for_download($order_id);
				if( !empty($order_data) ) {
					foreach( $order_data as $val ) {
						$customer_code = '';
						$payment_code = '';
						switch( $val['payment_method'] ) {
							case '1':
								$customer_code = $val['smile_code1'];
								$payment_code = '5';
								break;
							case '2':
								$customer_code = $val['smile_code2'];
								$payment_code = '6';
								break;
							case '3':
								$customer_code = $val['smile_code3'];
								$payment_code = '4';
								break;
						}

						$order_no = '';
						if( $val['exists_market'] == '1' ) {
							$order_no = $val['order_id'];
						}
						else {
							if( $val['flg_partial'] == '1' ) {
								$order_no = $val['order_id'];
							}
							else {
								$order_no = $val['order_id'] . '_' . $val['flg_market'];
							}
						}

						$csv_array = array(
							date('Y/m/d', strtotime($val['regist_time'])),
							$customer_code,
							$val['classroom_name'],
							'',
							$val['classroom_name'],
							'',
							$val['zip'],
							$this->conf['pref'][$val['pref']] . $val['address'],
							$val['tel'],
							$payment_code,
							'',
							$order_no,
							$val['smile_code'],
							$val['product_name'],
							'',
							'',
							$val['quantity'],
							$val['sales_price'],
							$val['sub_total'],
							''
						);
						fputcsv($fp, $csv_array);
					}
				}
			}
		}

		fclose($fp);
	}

	public function dl_pdf()
	{
		// ログイン済みチェック
		if( !$this->chk_logged_in_admin() ) {
			redirect('admin');
			return;
		}

		$post_data = $this->input->post();

echo '<pre>';
print_r($post_data);
echo '</pre>';

	}



	/*******************************************/
	/*                ajax関数                 */
	/*******************************************/



	/*******************************************/
	/*          ajax関数(bootgrid用)           */
	/*******************************************/
	public function get_bootgrid()
	{
		$post_data = $this->input->post();
		$current = isset($post_data['current']) ? intval($post_data['current']) : 1;
		$rowCount = isset($post_data['rowCount']) ? intval($post_data['rowCount']) : 10;
		$sort = isset($post_data['sort']) ? $post_data['sort'] : array();

		$conditions = array(
			'order_id_from'		=> isset($post_data['order_id_from']) ? $post_data['order_id_from'] : '',
			'order_id_to'		=> isset($post_data['order_id_to']) ? $post_data['order_id_to'] : '',
			'classroom_name'	=> isset($post_data['classroom_name']) ? $post_data['classroom_name'] : '',
			'smile_code'		=> isset($post_data['smile_code']) ? $post_data['smile_code'] : '',
			'order_status'		=> isset($post_data['order_status']) ? $post_data['order_status'] : '',
			'payment_method1'	=> isset($post_data['payment_method1']) ? $post_data['payment_method1'] : '',
			'payment_method2'	=> isset($post_data['payment_method2']) ? $post_data['payment_method2'] : '',
			'payment_method3'	=> isset($post_data['payment_method3']) ? $post_data['payment_method3'] : '',
			'regist_time_from'	=> isset($post_data['regist_time_from']) ? $post_data['regist_time_from'] : '',
			'regist_time_to'	=> isset($post_data['regist_time_to']) ? $post_data['regist_time_to'] : '',
		);

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

		list($order_data, $order_cnt) = $this->m_order->get_list_bootgrid($conditions, $sort_str, $limit_array);
		$row_val = array();

		if( !empty($order_data) ) {
			foreach( $order_data as $val ) {
				$market = $val['exists_market'] == '1' ? '無' : '有';
				if( $val['exists_market'] == '2' ) {
					$market .= '（' . ( $val['flg_partial'] == '1' ? '全納' : '分納' ) . '）';
				}

				$row_val[] = array(
					'order_id'			=> $val['order_id'],
					'regist_time'		=> $val['regist_time'],
					'classroom_name'	=> $val['classroom_name'],
					'payment_method'	=> $this->conf['payment_method'][$val['payment_method']],
					'total_cost'		=> '\\' . number_format($val['total_cost']),
					'exists_market'		=> $market,
					'delivery_date'		=> $val['delivery_date'],
					'delivery_time'		=> $this->conf['delivery_time'][$val['delivery_time']],
					'note'				=> $val['note'],
					'order_status'		=> $this->conf['order_status'][$val['order_status']]
				);
			}
		}

		$ret_val = array(
			'current'	=> $current,
			'rowCount'	=> $rowCount,
			'total'		=> $order_cnt,
			'rows'		=> $row_val
		);

		$this->ajax_out(json_encode($ret_val));
	}
}
