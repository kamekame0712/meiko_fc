<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		// モデルロード
		$this->load->model('m_order');
		$this->load->model('m_send_mail');

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
			'CONF'	=> $this->conf,
			'RESULT'	=> $result
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
		stream_filter_append($fp, 'convert.iconv.UTF-8/CP932//TRANSLIT', STREAM_FILTER_WRITE);

		header("Content-Type: application/octet-stream");
		header("Content-Disposition: attachment; filename=" . 'smile_data' . date('YmdHis') . '.csv');

		if( empty($order_ids) ) {
			fputs($fp, 'no data');
		}
		else {
			$csv_array = array(
				'受注日付', '得意先コード', '得意先名1', '担当者名',
				'納品先名', 'お届け先名2', 'お届け先郵便番号', 'お届け先住所', 'お届け先TEL',
				'支払方法', '納期',	'オーダーNo', '商品コード', '商品名', '規格1', '規格2',
				'数量', '単価', '金額', '備考'
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

						if( !empty($customer_code) ) {
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
								date('Y/m/d', strtotime($val['regist_time'])), $customer_code, $val['classroom_name'], '',
								$val['classroom_name'], '', $val['zip'], $this->conf['pref'][$val['pref']] . $val['address'], $val['tel'],
								$payment_code, '', $order_no, $val['smile_code'], $val['product_name'], '', '',
								$val['quantity'], $val['sales_price'], $val['sub_total'], ''
							);
							fputcsv($fp, $csv_array);
						}
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
		$order_ids = isset($post_data['order_ids']) ? explode(',', $post_data['order_ids']) : array();

		// タイムアウトさせない
		set_time_limit(0);

		require_once APPPATH.'libraries/mpdf/autoload.php';
		$mpdf = new \Mpdf\Mpdf(
			array(
				'mode'				=> 'ja',
				'format'			=> 'A4',
				'default_font_size'	=> 10,
				'autoScriptToLang'	=> TRUE,
				'autoLangToFont'	=> TRUE,
				'fontdata'			=> array(
					'ipa' => array(
						'R' => 'ipam.ttf'
					)
				)
			)
		);

		$mpdf->setTitle("MyPDF.pdf");
		$mpdf->ignore_invalid_utf8 = true;

		$stylesheet = file_get_contents(base_url('css/style.pdf.css'));
		$mpdf->WriteHTML($stylesheet,1);

		$first_page_flg = TRUE;
		foreach( $order_ids as $order_id ) {
			$order_data = $this->m_order->get_one_for_download($order_id);
			if( !empty($order_data) ) {
				$title = $this->conf['payment_method'][$order_data[0]['payment_method']];
				if( !empty($order_data[0]['delivery_date']) && !empty($order_data[0]['delivery_time']) ) {
					$title .= ' ' . date('Y年n月j日', strtotime($order_data[0]['delivery_date'])) . '（' . $this->conf['delivery_time'][$order_data[0]['delivery_time']] . '）指定';
				}
				else if( !empty($order_data[0]['delivery_date']) && empty($order_data[0]['delivery_time']) ) {
					$title .= ' ' . date('Y年n月j日', strtotime($order_data[0]['delivery_date'])) . '指定';
				}
				else if( empty($order_data[0]['delivery_date']) && !empty($order_data[0]['delivery_time']) ) {
					$title .= ' ' . $this->conf['delivery_time'][$order_data[0]['delivery_time']] . '指定';
				}

				$customer_code = '';
				switch( $order_data[0]['payment_method'] ) {
					case '1': $customer_code = empty($order_data[0]['smile_code1']) ? 'SMILE未登録' : $order_data[0]['smile_code1'];	break;
					case '2': $customer_code = empty($order_data[0]['smile_code2']) ? 'SMILE未登録' : $order_data[0]['smile_code2'];	break;
					case '3': $customer_code = empty($order_data[0]['smile_code3']) ? 'SMILE未登録' : $order_data[0]['smile_code3'];	break;
				}

				$select_data = array(
					'order_id <'	=> $order_data[0]['order_id'],
					'classroom_id'	=> $order_data[0]['classroom_id']
				);
				$wk_order_data = $this->m_order->get_list($select_data, 'regist_time DESC');

				$order_detail_full = array();
				$order_detail_juku = array();
				$order_detail_market = array();
				$total_cost_full = 0;
				$total_cost_juku = 0;
				$total_cost_market = 0;

				foreach( $order_data as $val ) {
					if( $val['exists_market'] == '1' || ( $val['exists_market'] == '2' && $val['flg_partial'] == '1' ) ) {
						$order_detail_full[] = array(
							'publisher_name'	=> $val['publisher_name'],
							'product_name'		=> $val['product_name'],
							'smile_code'		=> $val['smile_code'],
							'quantity'			=> $val['quantity'],
							'sales_price'		=> $val['sales_price'],
							'sub_total'			=> $val['sub_total']
						);
						$total_cost_full += intval($val['sub_total']);
					}
					else {
						if( $val['flg_market'] == '1' ) {	// 塾用
							$order_detail_juku[] = array(
								'publisher_name'	=> $val['publisher_name'],
								'product_name'		=> $val['product_name'],
								'smile_code'		=> $val['smile_code'],
								'quantity'			=> $val['quantity'],
								'sales_price'		=> $val['sales_price'],
								'sub_total'			=> $val['sub_total']
							);
							$total_cost_juku += intval($val['sub_total']);
						}
						else {
							$order_detail_market[] = array(
								'publisher_name'	=> $val['publisher_name'],
								'product_name'		=> $val['product_name'],
								'smile_code'		=> $val['smile_code'],
								'quantity'			=> $val['quantity'],
								'sales_price'		=> $val['sales_price'],
								'sub_total'			=> $val['sub_total']
							);
							$total_cost_market += intval($val['sub_total']);
						}
					}
				}

				if( $val['exists_market'] == '1' || ( $val['exists_market'] == '2' && $val['flg_partial'] == '1' ) ) {
					$shipping_fee = $this->get_shipping_fee($total_cost_full, $order_data[0]['pref']);
					$commission = $order_data[0]['payment_method'] == '3' ? $this->get_commission($total_cost_full) : 0;

					if( $val['exists_market'] == '2' && $val['flg_partial'] == '1' ) {
						$title .= ' ' . '市販あり（全納）';
					}

					$view_data = array(
						'TITLE'		=> $title,
						'NAME'		=> $order_data[0]['classroom_name'] . '（' . $customer_code . '）',
						'ZIP'		=> $order_data[0]['zip'],
						'ADDRESS'	=> $this->conf['pref'][$order_data[0]['pref']] . $order_data[0]['address'],
						'TEL'		=> $order_data[0]['tel'],
						'EN_CODE1'	=> empty($order_data[0]['en_code1']) ? '（未登録）' : ( $order_data[0]['en_code1'] == '1' ? 'あり' : 'なし' ),
						'EN_CODE2'	=> empty($order_data[0]['en_code2']) ? '（未登録）' : ( $order_data[0]['en_code2'] == '1' ? 'あり' : 'なし' ),
						'PREV'		=> empty($wk_order_data) ? '初めてのご注文' : $wk_order_data[0]['regist_time'],
						'NOTE'		=> $order_data[0]['note'],
						'ORDER_ID'	=> $order_data[0]['order_id'],
						'REGIST'	=> $order_data[0]['regist_time'],
						'DETAIL'	=> $order_detail_full,
						'SUB_TOTAL'	=> $total_cost_full,
						'SHIPPING'	=> $shipping_fee,
						'COMMISSION'=> $commission,
						'TOTAL'		=> $total_cost_full + $shipping_fee + $commission
					);

					if( $first_page_flg ) {
						$first_page_flg = FALSE;
					}
					else {
						$mpdf->AddPage();
					}

					$html = $this->load->view('admin/order/delivery_note', $view_data, TRUE);
					$mpdf->WriteHTML($html);
				}
				else {
					// 塾用
					$shipping_fee_juku = $this->get_shipping_fee($total_cost_juku, $order_data[0]['pref']);
					$commission_juku = $order_data[0]['payment_method'] == '3' ? $this->get_commission($total_cost_juku) : 0;

					$view_data = array(
						'TITLE'		=> $title . ' ' . '市販あり（分納-塾用）',
						'NAME'		=> $order_data[0]['classroom_name'] . '（' . $customer_code . '）',
						'ZIP'		=> $order_data[0]['zip'],
						'ADDRESS'	=> $this->conf['pref'][$order_data[0]['pref']] . $order_data[0]['address'],
						'TEL'		=> $order_data[0]['tel'],
						'EN_CODE1'	=> empty($order_data[0]['en_code1']) ? '（未登録）' : ( $order_data[0]['en_code1'] == '1' ? 'あり' : 'なし' ),
						'EN_CODE2'	=> empty($order_data[0]['en_code2']) ? '（未登録）' : ( $order_data[0]['en_code2'] == '1' ? 'あり' : 'なし' ),
						'PREV'		=> empty($wk_order_data) ? '初めてのご注文' : $wk_order_data[0]['regist_time'],
						'NOTE'		=> $order_data[0]['note'],
						'ORDER_ID'	=> $order_data[0]['order_id'] . '_1',
						'REGIST'	=> $order_data[0]['regist_time'],
						'DETAIL'	=> $order_detail_juku,
						'SUB_TOTAL'	=> $total_cost_juku,
						'SHIPPING'	=> $shipping_fee_juku,
						'COMMISSION'=> $commission_juku,
						'TOTAL'		=> $total_cost_juku + $shipping_fee_juku + $commission_juku
					);

					if( $first_page_flg ) {
						$first_page_flg = FALSE;
					}
					else {
						$mpdf->AddPage();
					}

					$html = $this->load->view('admin/order/delivery_note', $view_data, TRUE);
					$mpdf->WriteHTML($html);

					// 市販
					$shipping_fee_market = $this->get_shipping_fee($total_cost_market, $order_data[0]['pref']);
					$commission_market = $order_data[0]['payment_method'] == '3' ? $this->get_commission($total_cost_market) : 0;

					$view_data = array(
						'TITLE'		=> $title . ' ' . '市販あり（分納-市販）',
						'NAME'		=> $order_data[0]['classroom_name'] . '（' . $customer_code . '）',
						'ZIP'		=> $order_data[0]['zip'],
						'ADDRESS'	=> $this->conf['pref'][$order_data[0]['pref']] . $order_data[0]['address'],
						'TEL'		=> $order_data[0]['tel'],
						'EN_CODE1'	=> empty($order_data[0]['en_code1']) ? '（未登録）' : ( $order_data[0]['en_code1'] == '1' ? 'あり' : 'なし' ),
						'EN_CODE2'	=> empty($order_data[0]['en_code2']) ? '（未登録）' : ( $order_data[0]['en_code2'] == '1' ? 'あり' : 'なし' ),
						'PREV'		=> empty($wk_order_data) ? '初めてのご注文' : $wk_order_data[0]['regist_time'],
						'NOTE'		=> $order_data[0]['note'],
						'ORDER_ID'	=> $order_data[0]['order_id'] . '_2',
						'REGIST'	=> $order_data[0]['regist_time'],
						'DETAIL'	=> $order_detail_market,
						'SUB_TOTAL'	=> $total_cost_market,
						'SHIPPING'	=> $shipping_fee_market,
						'COMMISSION'=> $commission_market,
						'TOTAL'		=> $total_cost_market + $shipping_fee_market + $commission_market
					);

					if( $first_page_flg ) {
						$first_page_flg = FALSE;
					}
					else {
						$mpdf->AddPage();
					}

					$html = $this->load->view('admin/order/delivery_note', $view_data, TRUE);
					$mpdf->WriteHTML($html);
				}
			}
		}

		$mpdf->Output('delivery_note' . date('YmdHis') . '.pdf', 'D');
	}

	public function detail($order_id = '')
	{
		// ログイン済みチェック
		if( !$this->chk_logged_in_admin() ) {
			redirect('admin');
			return;
		}

		$order_data = $this->m_order->get_one_with_detail_for_admin($order_id);
		$order_history = $this->m_order->get_list(array('classroom_id' => $order_data[0]['classroom_id']), 'regist_time DESC');

		if( $order_data[0]['flg_send_mail'] == '2' ) {
			$send_mail_data = $this->m_send_mail->get_list(array('order_id' => $order_id), 'regist_time DESC');
		}
		else {
			$send_mail_data = array();
		}

		$view_data = array(
			'CONF'		=> $this->conf,
			'DETAIL'	=> $order_data,
			'HISTORY'	=> $order_history,
			'MAIL'		=> $send_mail_data
		);

		$this->load->view('admin/order/detail', $view_data);
	}

	public function send_mail($order_id = '')
	{
		// ログイン済みチェック
		if( !$this->chk_logged_in_admin() ) {
			redirect('admin');
			return;
		}

		$order_data = $this->m_order->get_one_with_detail_for_admin($order_id);

		$view_data = array(
			'CONF'		=> $this->conf,
			'DETAIL'	=> $order_data
		);

		$this->load->view('admin/order/send_mail', $view_data);
	}

	public function mail_confirm()
	{
		// ログイン済みチェック
		if( !$this->chk_logged_in_admin() ) {
			redirect('admin');
			return;
		}

		$post_data = $this->input->post();
		$order_id = isset($post_data['order_id']) ? $post_data['order_id'] : '';
		$order_data = $this->m_order->get_one_with_detail_for_admin($order_id);

		// バリデーションチェック
		if( $this->form_validation->run('admin/send_mail') == FALSE ) {
			$view_data = array(
				'CONF'		=> $this->conf,
				'DETAIL'	=> $order_data
			);

			$this->load->view('admin/order/send_mail', $view_data);
			return;
		}

		$view_data = array(
			'PDATA'	=> $post_data,
			'JUKU'	=> $order_data[0]['classroom_name'] . '（' . $order_data[0]['email']  . '）'
		);

		$this->load->view('admin/order/mail_confirm', $view_data);
	}

	public function mail_complete()
	{
		// ログイン済みチェック
		if( !$this->chk_logged_in_admin() ) {
			redirect('admin');
			return;
		}

		$post_data = $this->input->post();
		$order_id = isset($post_data['order_id']) ? $post_data['order_id'] : '';
		$title = isset($post_data['title']) ? $post_data['title'] : '';
		$content = isset($post_data['content']) ? $post_data['content'] : '';

		$order_data = $this->m_order->get_one_with_detail_for_admin($order_id);
		$now = date('Y-m-d H:i:s');

		$this->db->trans_start();

		$insert_data = array(
			'order_id'		=> $order_id,
			'classroom_id'	=> $order_data[0]['classroom_id'],
			'title'			=> $title,
			'content'		=> $content,
			'regist_time'	=> $now,
			'update_time'	=> $now,
			'status'		=> '0'
		);
		$this->m_send_mail->insert($insert_data);

		$update_data = array(
			'flg_send_mail'	=> '2',
			'update_time'	=> $now
		);
		$this->m_order->update(array('order_id', $order_id), $update_data);

		$this->db->trans_complete();

		if( $this->db->trans_status() !== FALSE ) {
			// モデルロード
			$this->load->model('m_mail');

			// 設定ファイルロード
			$this->config->load('config_mail', TRUE, TRUE);
			$conf_mail = $this->config->item('mail', 'config_mail');

			$params = array(
				'from'		=> $conf_mail['apply_comp_to_customer']['from'],
				'from_name'	=> $conf_mail['apply_comp_to_customer']['from_name'],
				'to'		=> $order_data[0]['email'],
				'subject'	=> $title,
				'message'	=> $content
			);

			if( !$this->m_mail->send($params) ) {
				redirect('admin/order/index/mail_err1');
				return;
			}
		}
		else {
			redirect('admin/order/index/mail_err2');
			return;
		}

		redirect('admin/order/index/ok');
		return;
	}



	/*******************************************/
	/*               private関数               */
	/*******************************************/
	// 送料計算
	private function get_shipping_fee($cost = 0, $pref = '01')
	{
		if( $cost >= 10000 ) {
			$shipping_fee = 0;
		}
		else {
			if( $pref == '01' ) {
				$shipping_fee = SHIPPING_FEE_HOKKAIDO;
			}
			else {
				$shipping_fee = SHIPPING_FEE_COMMON;
			}
		}

		return $shipping_fee;
	}

	// 代引手数料計算
	private function get_commission($cost = 0)
	{
		if( $cost >= 100000 ) {
			$commission = 1100;
		}
		else if( $cost >= 30000 ) {
			$commission = 660;
		}
		else if( $cost >= 10000 ) {
			$commission = 440;
		}
		else {
			$commission = 330;
		}

		return $commission;
	}



	/*******************************************/
	/*                ajax関数                 */
	/*******************************************/
	public function ajax_change_status()
	{
		$post_data = $this->input->post();
		$order_ids = isset($post_data['order_ids']) ? $post_data['order_ids'] : '';
		$order_status = isset($post_data['order_status']) ? $post_data['order_status'] : '';

		$ret_val = array(
			'status'			=> FALSE,
			'err_msg'			=> ''
		);

		if( $order_ids == '' ) {
			$ret_val['err_msg'] = '対象の受注にチェックを付けてください。';
		}
		else {
			$where = 'order_id IN (' . $order_ids . ') AND status = "0"';

			$update_data = array(
				'order_status'	=> $order_status,
				'update_time'	=> date('Y-m-d H:i:s')
			);

			if( $this->m_order->update($where, $update_data) ) {
				$ret_val['status'] = TRUE;
			}
			else {
				$ret_val['err_msg'] = 'データベースエラーが発生しました。';
			}
		}

		$this->ajax_out(json_encode($ret_val));
	}

	public function ajax_cancel()
	{
		$post_data = $this->input->post();
		$order_id = isset($post_data['order_id']) ? $post_data['order_id'] : '';

		$ret_val = array(
			'status'			=> FALSE,
			'err_msg'			=> ''
		);

		$order_data = $this->m_order->get_one(array('order_id' => $order_id));
		if( empty($order_data) ) {
			$ret_val['err_msg'] = '対象の受注が存在しません。';
		}
		else {
			$update_data = array(
				'order_status'	=> '8',
				'update_time'	=> date('Y-m-d H:i:s')
			);

			if( $this->m_order->update(array('order_id' => $order_id), $update_data) ) {
				$ret_val['status'] = TRUE;
			}
			else {
				$ret_val['err_msg'] = 'データベースエラーが発生しました。';
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
					'order_status'		=> $this->conf['order_status'][$val['order_status']],
					'order_status_val'	=> $val['order_status'],
					'flg_send_mail'		=> $val['flg_send_mail'] == '1' ? '無' : '有'
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
