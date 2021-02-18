<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		// モデルロード
		$this->load->model('m_product');
		$this->load->model('m_order');
		$this->load->model('m_order_detail');
		$this->load->model('m_classroom');
		$this->load->model('m_owner');
		$this->load->model('m_gmo');

		// 設定ファイルロード
		$this->config->load('config_disp', TRUE, TRUE);
		$this->conf = $this->config->item('disp', 'config_disp');
	}

	public function index($error_message = '')
	{
		// ログイン済みチェック
		if( !$this->chk_logged_in() ) {
			redirect('index');
			return;
		}

		// リロード対策
		if( $this->input->cookie('order_complete') ) {
			delete_cookie('order_complete');
		}

		$post_data = $this->input->post();

		// 教材
		if( $this->input->cookie('product_ids') ) {
			$product_ids = unserialize($this->input->cookie('product_ids'));
		}
		else {
			$product_ids = array();
		}

		$product_list = array();
		$exists_market = FALSE;
		$exists_juku = FALSE;
		if( !empty($product_ids) ) {
			foreach( $product_ids as $wk_product_id => $val) {
				$wk_product_data = $this->m_product->get_one(array('product_id' => $wk_product_id));
				if( !empty($wk_product_data) ) {
					$product_list[$wk_product_id] = array(
						'publisher'		=> $wk_product_data['publisher'],
						'publisher_name'=> $this->conf['publisher'][$wk_product_data['publisher']],
						'product_name'	=> $wk_product_data['name'],
						'normal_price'	=> $wk_product_data['normal_price'],
						'sales_price'	=> $wk_product_data['sales_price'],
						'quantity'		=> $val,
						'sub_total'		=> intval($wk_product_data['sales_price']) * intval($val)
					);

					if( $wk_product_data['flg_market'] == '2' ) {
						$exists_market = TRUE;
					}
					else {
						$exists_juku = TRUE;
					}
				}
			}
		}

		$product_kind = 0;
		if( $exists_market == TRUE && $exists_juku == TRUE ) {
			$product_kind = 1;
		}
		else if( $exists_market == FALSE && $exists_juku == TRUE ) {
			$product_kind = 2;
		}
		else if( $exists_market == TRUE && $exists_juku == FALSE ) {
			$product_kind = 3;
		}

		$total_quantity = 0;
		$total_cost = 0;
		if( !empty($product_list) ) {
			foreach( $product_list as $val ) {
				$total_quantity += intval($val['quantity']);
				$total_cost += intval($val['sub_total']);
			}
		}

		if( isset($post_data['product_id']) ) {
			$product_id = $post_data['product_id'];
			if( array_key_exists($product_id, $product_list) ) {
				$quantity = intval($product_list[$product_id]['quantity']);
				$sales_price = intval($product_list[$product_id]['sales_price']);
				$quantity++;
				$sub_total = $quantity * $sales_price;
				$product_list[$product_id]['quantity'] = $quantity;
				$product_list[$product_id]['sub_total'] = $sub_total;
				$total_quantity++;
				$total_cost += $sales_price;
			}
			else {
				$product_data = $this->m_product->get_one(array('product_id' => $product_id));
				if( !empty($product_data) ) {
					$product_list[$product_id] = array(
						'publisher'		=> $product_data['publisher'],
						'publisher_name'=> $this->conf['publisher'][$product_data['publisher']],
						'product_name'	=> $product_data['name'],
						'normal_price'	=> $product_data['normal_price'],
						'sales_price'	=> $product_data['sales_price'],
						'quantity'		=> 1,
						'sub_total'		=> $product_data['sales_price']
					);

					$total_quantity++;
					$total_cost += intval($product_data['sales_price']);
				}
			}
		}

		if( !empty($product_list) ) {
			$product_ids = array();
			foreach( $product_list as $product_id => $val ) {
				$product_ids[$product_id] = $val['quantity'];
			}

			$cookie_save_data = array(
				'name'	=> 'product_ids',
				'value'	=> serialize($product_ids),
				'expire'=> '86400'
			);
			$this->input->set_cookie($cookie_save_data);
		}

		// その他
		$flg_partial = '1';
		if( isset($post_data['flg_partial']) ) {
			$flg_partial = $post_data['flg_partial'];

			$cookie_save_data = array(
				'name'	=> 'flg_partial',
				'value'	=> $flg_partial,
				'expire'=> '86400'
			);
			$this->input->set_cookie($cookie_save_data);
		}
		else {
			if( $this->input->cookie('flg_partial') ) {
				$flg_partial = $this->input->cookie('flg_partial');
			}
		}

		$payment_method = '';
		if( isset($post_data['payment_method']) ) {
			$payment_method = $post_data['payment_method'];

			$cookie_save_data = array(
				'name'	=> 'payment_method',
				'value'	=> $payment_method,
				'expire'=> '86400'
			);
			$this->input->set_cookie($cookie_save_data);
		}
		else {
			if( $this->input->cookie('payment_method') ) {
				$payment_method = $this->input->cookie('payment_method');
			}
		}

		$delivery_date = '';
		if( isset($post_data['delivery_date']) ) {
			$delivery_date = $post_data['delivery_date'];

			$cookie_save_data = array(
				'name'	=> 'delivery_date',
				'value'	=> $delivery_date,
				'expire'=> '86400'
			);
			$this->input->set_cookie($cookie_save_data);
		}
		else {
			if( $this->input->cookie('delivery_date') ) {
				$delivery_date = $this->input->cookie('delivery_date');
			}
		}

		$delivery_time = '';
		if( isset($post_data['delivery_time']) ) {
			$delivery_time = $post_data['delivery_time'];

			$cookie_save_data = array(
				'name'	=> 'delivery_time',
				'value'	=> $delivery_time,
				'expire'=> '86400'
			);
			$this->input->set_cookie($cookie_save_data);
		}
		else {
			if( $this->input->cookie('delivery_time') ) {
				$delivery_time = $this->input->cookie('delivery_time');
			}
		}

		// お届け日、時間（選択肢）
		$w = array('日', '月', '火', '水', '木', '金', '土');
		if( $product_kind == 2 ) {
			$base_date = date('Y-m-d', strtotime('+8 day', time()));
		}
		else {
			$base_date = date('Y-m-d', strtotime('+15 day', time()));
		}

		$select_date = array('' => '最短');
		for( $i = 1; $i <= 15; $i++ ) {
			$target_date = date('Y/m/d', strtotime('+' . $i . ' day', strtotime($base_date)));

			$month = intval(date('n', strtotime($target_date)));
			$day = intval(date('j', strtotime($target_date)));

			// 1/1～1/7は選択不可
			if( $month == 1 && ($day >= 1 && $day <= 7) ) {
				continue;
			}

			$select_date[$target_date] = $target_date . '(' . $w[date('w', strtotime($target_date))] . ')';
		}

		// 備考
		$note = '';
		if( !empty($post_data) ) {
			if( !empty($post_data['note']) ) {
				$note = $post_data['note'];

				$cookie_save_data = array(
					'name'	=> 'note',
					'value'	=> $note,
					'expire'=> '86400'
				);
				$this->input->set_cookie($cookie_save_data);
			}
		}
		else {
			if( $this->input->cookie('note') ) {
				$note = $this->input->cookie('note');
			}
		}

		if( !empty($post_data) && $error_message == '' ) {
			redirect('order');
		}

		// クレジットカード情報
		$classroom_id = $this->session->userdata('classroom_id');
		$classroom_data = $this->m_classroom->get_one(array('classroom_id' => $classroom_id));
		$gmo_member_id = isset($classroom_data['gmo_member_id']) ? $classroom_data['gmo_member_id'] : '';
		$card = array();
		if( !empty($gmo_member_id) ) {
			$card = $this->m_gmo->search_card($gmo_member_id);
			if( !is_array($card) ) {
				$card = array();
			}
		}

		// クレジットカード有効期限
		$yy = array();
		$wk_year = intval(date('y'));
		for( $i = 0; $i < 15; $i++ ) {
			$year = sprintf('%02d', $wk_year + $i);
			$yy[$year] = $year;
		}

		$mm = array();
		for( $i = 1; $i <= 12; $i++ ) {
			$month = sprintf('%02d', $i);
			$mm[$month] = $month;
		}

		// お支払方法の選択肢
		$payment_method_list = array();
		$owner_data = $this->m_owner->get_one(array('owner_id' => $classroom_data['owner_id']));
		if( !empty($owner_data) ) {
			if( $owner_data['payment_method1'] == '1' && !empty($classroom_data['smile_code1']) ) {
				$payment_method_list['1'] = '買掛';
			}

			if( $owner_data['payment_method2'] == '1' ) {
				$payment_method_list['2'] = 'クレジットカード';
			}

			if( $owner_data['payment_method3'] == '1' ) {
				$payment_method_list['3'] = '代金引換';
			}
		}

		$view_data = array(
			'ERROR_MESSAGE'	=> $error_message,
			'CONF'			=> $this->conf,
			'PLIST'			=> $product_list,
			'PAYMENT_LIST'	=> $payment_method_list,
			'SHIPPING_FEE'	=> $this->get_shipping_fee($total_cost),
			'TOTAL_QUANTITY'=> $total_quantity,
			'TOTAL_COST'	=> $total_cost,
			'PRODUCT_KIND'	=> $product_kind,
			'PARTIAL'		=> $flg_partial,
			'PAYMENT'		=> $payment_method,
			'DELIVERY_DATE'	=> $delivery_date,
			'DELIVERY_TIME'	=> $delivery_time,
			'SELECT_DATE'	=> $select_date,
			'NOTE'			=> $note,
			'CARD'			=> $card,
			'YY'			=> $yy,
			'MM'			=> $mm
		);

		$this->load->view('front/order/index', $view_data);
	}

	public function confirm()
	{
		// ログイン済みチェック
		if( !$this->chk_logged_in() ) {
			redirect('index');
			return;
		}

		// リロード対策
		if( $this->input->cookie('order_complete') ) {
			delete_cookie('order_complete');
		}

		$post_data = $this->input->post();

		$product_list = array();
		$exists_market = FALSE;
		$exists_juku = FALSE;
		if( $this->input->cookie('product_ids') ) {
			$product_ids = unserialize($this->input->cookie('product_ids'));

			if( !empty($product_ids) ) {
				foreach( $product_ids as $wk_product_id => $val) {
					if( $val != '0' ) {
						$wk_product_data = $this->m_product->get_one(array('product_id' => $wk_product_id));
						if( !empty($wk_product_data) ) {
							$product_list[$wk_product_id] = array(
								'publisher'		=> $wk_product_data['publisher'],
								'publisher_name'=> $this->conf['publisher'][$wk_product_data['publisher']],
								'product_name'	=> $wk_product_data['name'],
								'flg_market'	=> $wk_product_data['flg_market'],
								'normal_price'	=> $wk_product_data['normal_price'],
								'sales_price'	=> $wk_product_data['sales_price'],
								'quantity'		=> $val,
								'sub_total'		=> intval($wk_product_data['sales_price']) * intval($val)
							);

							if( $wk_product_data['flg_market'] == '2' ) {
								$exists_market = TRUE;
							}
							else {
								$exists_juku = TRUE;
							}
						}
					}
				}
			}
		}

		$product_kind = 0;
		if( $exists_market == TRUE && $exists_juku == TRUE ) {
			$product_kind = 1;
		}
		else if( $exists_market == FALSE && $exists_juku == TRUE ) {
			$product_kind = 2;
		}
		else if( $exists_market == TRUE && $exists_juku == FALSE ) {
			$product_kind = 3;
		}

		if( isset($post_data['flg_partial']) ) {
			$cookie_save_data = array(
				'name'	=> 'flg_partial',
				'value'	=> $post_data['flg_partial'],
				'expire'=> '86400'
			);
			$this->input->set_cookie($cookie_save_data);
		}

		$cookie_save_data = array(
			'name'	=> 'payment_method',
			'value'	=> $post_data['payment_method'],
			'expire'=> '86400'
		);
		$this->input->set_cookie($cookie_save_data);

		$cookie_save_data = array(
			'name'	=> 'delivery_date',
			'value'	=> $post_data['delivery_date'],
			'expire'=> '86400'
		);
		$this->input->set_cookie($cookie_save_data);

		$cookie_save_data = array(
			'name'	=> 'delivery_time',
			'value'	=> $post_data['delivery_time'],
			'expire'=> '86400'
		);
		$this->input->set_cookie($cookie_save_data);

		$cookie_save_data = array(
			'name'	=> 'note',
			'value'	=> $post_data['note'],
			'expire'=> '86400'
		);
		$this->input->set_cookie($cookie_save_data);

		$total_quantity = 0;
		$total_cost = 0;
		$shipping_fee = 0;
		$shipping_cnt = 0;
		if( !empty($product_list) ) {
			$flg_partial = isset($post_data['flg_partial']) && $post_data['flg_partial'] == '2' ? TRUE : FALSE;

			if( $product_kind != 1 || ( $product_kind == 1 && !$flg_partial ) ) {
				foreach( $product_list as $val ) {
					$total_quantity += intval($val['quantity']);
					$total_cost += intval($val['sub_total']);
				}
				$shipping_fee = $this->get_shipping_fee($total_cost);
				$shipping_cnt = $shipping_fee == 0 ? 0 : 1;
			}
			else {
				$market_cost = 0;
				$juku_cost = 0;

				foreach( $product_list as $val ) {
					$total_quantity += intval($val['quantity']);
					if( $val['flg_market'] == '2' ) {
						$market_cost += intval($val['sub_total']);
					}
					else {
						$juku_cost += intval($val['sub_total']);
					}
				}
				$shipping_fee_market = $this->get_shipping_fee($market_cost);
				$shipping_fee_juku = $this->get_shipping_fee($juku_cost);
				$total_cost = $market_cost + $juku_cost;
				$shipping_fee = $shipping_fee_market + $shipping_fee_juku;
				if( $shipping_fee_market == 0 && $shipping_fee_juku == 0 ) {
					$shipping_cnt = 0;
				}
				else if( ( $shipping_fee_market * $shipping_fee_juku ) == 0 ) {
					$shipping_cnt = 1;
				}
				else {
					$shipping_cnt = 2;
				}
			}
		}

		$view_data = array(
			'CONF'			=> $this->conf,
			'PDATA'			=> $post_data,
			'PLIST'			=> $product_list,
			'SHIPPING_FEE'	=> $shipping_fee,
			'SHIPPING_CNT'	=> $shipping_cnt,
			'SHIPPING_UNIT'	=> $this->get_shipping_fee(),
			'TOTAL_QUANTITY'=> $total_quantity,
			'TOTAL_COST'	=> $total_cost,
			'PRODUCT_KIND'	=> $product_kind
		);

		$this->load->view('front/order/confirm', $view_data);
	}

	public function complete()
	{
		// ログイン済みチェック
		if( !$this->chk_logged_in() ) {
			redirect('index');
			return;
		}

		// リロード対策
		if( $this->input->cookie('order_complete') ) {
			redirect('order');
		}
		else {
			$cookie_data = array(
				'name'	=> 'order_complete',
				'value'	=> '1',
				'expire'=> '86400'
			);
			$this->input->set_cookie($cookie_data);
		}

		$post_data = $this->input->post();
		$flg_partial = isset($post_data['flg_partial']) ? $post_data['flg_partial'] : '1';
		$payment_method = isset($post_data['payment_method']) ? $post_data['payment_method'] : '';
		$delivery_date = isset($post_data['delivery_date']) ? $post_data['delivery_date'] : '';
		$delivery_time = isset($post_data['delivery_time']) ? $post_data['delivery_time'] : '';
		$note = isset($post_data['note']) ? $post_data['note'] : '';
		$sub_total = isset($post_data['total_cost']) ? $post_data['total_cost'] : '';
		$shipping_fee = isset($post_data['shipping_fee']) ? $post_data['shipping_fee'] : '';
		$exists_market = isset($post_data['exists_market']) ? $post_data['exists_market'] : '1';
		$gmo_token = isset($post_data['gmo_token']) ? $post_data['gmo_token'] : '';
		$chk_register = isset($post_data['chk_register']) ? $post_data['chk_register'] : '';
		$card_type = isset($post_data['card_type']) ? $post_data['card_type'] : '';
		$holder_name = isset($post_data['holder']) ? $post_data['holder'] : '';
		$sequence = isset($post_data['registered_card']) ? $post_data['registered_card'] : '';

		$products = array();
		if( !empty($post_data) ) {
			foreach( $post_data as $key => $val ) {
				if( $val != '0' ) {
					if( strpos($key, 'num_') === 0 ) {
						$wk = explode('_', $key);
						if( !empty($wk[1]) ) {
							$wk_product = isset($post_data[$wk[1]]) ? $post_data[$wk[1]] : '';
							$products[] = array(
								'product_id'	=> $wk[1],
								'quantity'		=> $val,
								'publisher_name'=> isset($wk_product['publisher_name']) ? $wk_product['publisher_name'] : '',
								'product_name'=> isset($wk_product['product_name']) ? $wk_product['product_name'] : '',
								'sales_price'=> isset($wk_product['sales_price']) ? $wk_product['sales_price'] : '',
								'sub_total'=> isset($wk_product['sub_total']) ? $wk_product['sub_total'] : ''
							);
						}
					}
				}
			}
		}

		$this->db->trans_begin();

		$now = date('Y-m-d H:i:s');
		$classroom_id = $this->session->userdata('classroom_id');
		$classroom_data = $this->m_classroom->get_one(array('classroom_id' => $classroom_id));
		$card_error = FALSE;

		$insert_data_order = array(
			'classroom_id'		=> $classroom_id,
			'exists_market'		=> $exists_market,
			'flg_partial'		=> $flg_partial,
			'payment_method'	=> $payment_method,
			'delivery_date'		=> $delivery_date == '' ? NULL : $delivery_date,
			'delivery_time'		=> $delivery_time,
			'note'				=> $note,
			'shipping_fee'		=> $shipping_fee,
			'sub_total'			=> $sub_total,
			'total_cost'		=> intval($shipping_fee) + intval($sub_total),
			'regist_time'		=> $now,
			'update_time'		=> $now,
			'status'			=> '0'
		);
		$order_id = $this->m_order->insert($insert_data_order);

		if( !empty($order_id) && !empty($products) ) {
			foreach( $products as $val ) {
				$insert_data_detail = array(
					'order_id'			=> $order_id,
					'product_id'		=> $val['product_id'],
					'quantity'			=> $val['quantity'],
					'publisher_name'	=> $val['publisher_name'],
					'product_name'		=> $val['product_name'],
					'sales_price'		=> $val['sales_price'],
					'sub_total'			=> $val['sub_total'],
					'regist_time'		=> $now,
					'update_time'		=> $now,
					'status'			=> '0'
				);
				$this->m_order_detail->insert($insert_data_detail);
			}

			// クレジットカード処理
			if( $payment_method == '2' ) {
				$gmo_order_id = GMO_PREFIX . $order_id;
				$gmo_member_id = !empty($classroom_data['gmo_member_id']) ? $classroom_data['gmo_member_id'] : '';

				if( $card_type == '1' ) { // 登録済みカードを使用
					// 取引登録
					$ret_et_val = $this->m_gmo->entry_tran($gmo_order_id, intval($shipping_fee) + intval($sub_total), 'AUTH');	// CAPTURE:即時売上 AUTH:仮売上
					if( !is_array($ret_et_val) || empty($ret_et_val['accessId']) || empty($ret_et_val['accessPass']) ) {
						$this->db->trans_rollback();
						$this->index($ret_et_val);
						return;
					}
					else {
						// 決済
						$ret_ex_val = $this->m_gmo->exec_tran_registered($gmo_order_id, $ret_et_val['accessId'], $ret_et_val['accessPass'], $gmo_member_id, $sequence);
						if( !is_array($ret_ex_val) ) {
							$this->db->trans_rollback();
							$this->index($ret_ex_val);
							return;
						}
						else {
							if( $chk_register == '1' && $gmo_member_id != '' && $card_error == FALSE ) {
								if( $chk_register == '1' ) {
									$ret_tc_val = $this->m_gmo->traded_card($gmo_order_id, $gmo_member_id, $holder_name);
									if( !is_array($ret_tc_val) ) {
										$card_error = TRUE;
									}
								}
							}
						}
					}
				}
				else if( $card_type == '2' ) { // 新規カードを使用
					if( $chk_register == '1' ) {
						if( $gmo_member_id == '' ) {
							// 会員登録
							$gmo_member_id = GMO_PREFIX . $classroom_id;
							$ret_sm_val = $this->m_gmo->save_member($gmo_member_id);
							if( !is_array($ret_sm_val) ) {
								$card_error = TRUE;
							}
							else {
								$update_data_classroom = array(
									'gmo_member_id'	=> $gmo_member_id,
									'update_time'	=> date('Y-m-d H:i:s')
								);
								$this->m_classroom->update(array('classroom_id' => $classroom_id), $update_data_classroom);
							}
						}
					}

					// 取引登録
					$ret_et_val = $this->m_gmo->entry_tran($gmo_order_id, intval($shipping_fee) + intval($sub_total), 'AUTH');	// CAPTURE:即時売上 AUTH:仮売上
					if( !is_array($ret_et_val) || empty($ret_et_val['accessId']) || empty($ret_et_val['accessPass']) ) {
						$this->db->trans_rollback();
						$this->index($ret_et_val);
						return;
					}
					else {
						// 決済
						$ret_ex_val = $this->m_gmo->exec_tran_token($gmo_order_id, $ret_et_val['accessId'], $ret_et_val['accessPass'], $gmo_token);
						if( !is_array($ret_ex_val) ) {
							$this->db->trans_rollback();
							$this->index($ret_ex_val);
							return;
						}
						else {
							if( $chk_register == '1' && $gmo_member_id != '' && $card_error == FALSE ) {
								if( $chk_register == '1' ) {
									$ret_tc_val = $this->m_gmo->traded_card($gmo_order_id, $gmo_member_id, $holder_name);
									if( !is_array($ret_tc_val) ) {
										$card_error = TRUE;
									}
								}
							}
						}
					}
				}
				else {
					$this->db->trans_rollback();
					$this->index('クレジットカード決済に失敗しました。申し訳ございませんが、別のクレジットカードをご利用いただくか、その他のお支払方法をお願いします。');
					return;
				}
			}
		}

		if( $this->db->trans_status() === FALSE ) {
			$this->db->trans_rollback();
			$this->index('発注に失敗しました。申し訳ございませんが、しばらく時間を空け、再度ご注文ください。');
			return;
		}
		else {
			$this->db->trans_commit();
		}

		if( $this->input->cookie('product_ids') ) {
			delete_cookie('product_ids');
		}

		if( $this->input->cookie('flg_partial') ) {
			delete_cookie('flg_partial');
		}

		if( $this->input->cookie('payment_method') ) {
			delete_cookie('payment_method');
		}

		if( $this->input->cookie('delivery_date') ) {
			delete_cookie('delivery_date');
		}

		if( $this->input->cookie('delivery_time') ) {
			delete_cookie('delivery_time');
		}

		if( $this->input->cookie('note') ) {
			delete_cookie('note');
		}

		// 確認メール送信
		// モデルロード
		$this->load->model('m_mail');

		// 設定ファイルロード
		$this->config->load('config_mail', TRUE, TRUE);
		$this->conf_mail = $this->config->item('mail', 'config_mail');

		if( $delivery_date == '' ) {
			$show_delivery_date = '最短';
		}
		else {
			$w = array('日', '月', '火', '水', '木', '金', '土');
			$show_delivery_date = date('Y年n月j日', strtotime($delivery_date)) . '(' . $w[date('w', strtotime($delivery_date))] . ')';
		}

		$mail_data = array(
			'JUKU_NAME'	=> $classroom_data['name'],
			'PRODUCTS'	=> $products,
			'SUB_TOTAL'	=> $sub_total,
			'SHIPPING'	=> $shipping_fee,
			'TOTAL'		=> intval($sub_total) + intval($shipping_fee),
			'MARKET'	=> $exists_market,
			'PARTIAL'	=> $flg_partial,
			'PAYMENT'	=> $this->conf['payment_method'][$payment_method],
			'DDATE'		=> $show_delivery_date,
			'DTIME'		=> $this->conf['delivery_time'][$delivery_time],
			'NOTE'		=> empty($note) ? '（ご記入なし）' : $note
		);

		$mail_body = $this->load->view('mail/tmpl_apply_comp_to_customer', $mail_data, TRUE);
		$params = array(
			'from'		=> $this->conf_mail['apply_comp_to_customer']['from'],
			'from_name'	=> $this->conf_mail['apply_comp_to_customer']['from_name'],
			'to'		=> $classroom_data['email'],
			'subject'	=> '【教材発注システム】ご注文ありがとうございます（自動送信メール）',
			'message'	=> $mail_body
		);

		$this->m_mail->send($params);

		$view_data = array(
			'CARD_ERROR'	=> $card_error,
			'EMAIL'			=> $classroom_data['email']
		);

		$this->load->view('front/order/complete', $view_data);
	}

	public function remove_order($product_id = '')
	{
		if( $product_id != '' ) {
			if( $this->input->cookie('product_ids') ) {
				$product_ids = unserialize($this->input->cookie('product_ids'));
				if( array_key_exists($product_id, $product_ids) ) {
					unset($product_ids[$product_id]);

					$cookie_save_data = array(
						'name'	=> 'product_ids',
						'value'	=> serialize($product_ids),
						'expire'=> '86400'
					);
					$this->input->set_cookie($cookie_save_data);
				}
			}
		}

		redirect('order');
	}

	public function remove_all_order()
	{
		if( $this->input->cookie('product_ids') ) {
			delete_cookie('product_ids');
		}

		redirect('order');
	}

	public function remove_card($card_sequence = 0)
	{
		$classroom_id = $this->session->userdata('classroom_id');
		$classroom_data = $this->m_classroom->get_one(array('classroom_id' => $classroom_id));
		$gmo_member_id = isset($classroom_data['gmo_member_id']) ? $classroom_data['gmo_member_id'] : '';

		if( !empty($gmo_member_id) ) {
			$this->m_gmo->delete_card($gmo_member_id, $card_sequence);
		}

		redirect('order');
	}

	public function choose_product($page = 1)
	{
		// ログイン済みチェック
		if( !$this->chk_logged_in() ) {
			redirect('index');
			return;
		}

		$applicable_product = array();
		$total = 0;
		$pagination = '';
		$showing_record = '';
		$post_data = $this->input->post();
		if( !empty($post_data) ) {
			$conditions = array(
				'keyword'	=> isset($post_data['cond_keyword']) ? $post_data['cond_keyword'] : '',
				'recommend'	=> isset($post_data['recommend']) ? $post_data['recommend'] : '9',
				'grade_e'	=> isset($post_data['grade_e']) ? $post_data['grade_e'] : array(),
				'grade_j'	=> isset($post_data['grade_j']) ? $post_data['grade_j'] : array(),
				'grade_h'	=> isset($post_data['grade_h']) ? $post_data['grade_h'] : array(),
				'subject'	=> isset($post_data['subject']) ? $post_data['subject'] : array(),
				'period'	=> isset($post_data['period']) ? $post_data['period'] : array(),
				'publisher'	=> isset($post_data['publisher']) ? $post_data['publisher'] : array()
			);

			list($applicable_product, $total) = $this->m_product->get_applicable($conditions, $page);

			if( !empty($applicable_product) ) {
				$showing_record = ( ($page - 1) * intval(RECORD_PER_PAGE) + 1 ) . '～' . ( count($applicable_product) == intval(RECORD_PER_PAGE) ? ( $page * intval(RECORD_PER_PAGE) ) : ( $total ) ) . '（全' . $total . '件）';
				$page_block_num = ceil($total / RECORD_PER_PAGE); // ページブロック数

				$pagination .= '<ul>';
				if( $page != 1 ) {
					$pagination .= '	<li onclick="search_link(' . ($page - 1) . ')">' . '&lt;' . '</li>';
				}
				else {
					$pagination .= '	<li class="not-anchor">' . '&lt;' . '</li>';
				}

				// ページブロックの数が最大数より小さい
				if( (MAX_BEFORE_CURRENT + MAX_AFTER_CURRENT + 1) >= $page_block_num ) {
					for( $i = 1; $i <= $page_block_num; $i++ ) {
						if( $page == $i ) {
							$pagination .= '	<li class="current-page">' . ($i) . '</li>';
						}
						else {
							$pagination .= '	<li onclick="search_link(' . ($i) . ')">' . ($i) . '</li>';
						}
					}
				}
				else {
					if( $page <= MAX_BEFORE_CURRENT + 1 ) {
						for( $i = 1; $i < MAX_BEFORE_CURRENT + MAX_AFTER_CURRENT + 1; $i++ ) {
							if( $page == $i ) {
								$pagination .= '	<li class="current-page">' . ($i) . '</li>';
							}
							else {
								$pagination .= '	<li onclick="search_link(' . ($i) . ')">' . ($i) . '</li>';
							}
						}
						$pagination .= '	<li onclick="search_link(' . ($page_block_num) . ')">...</li>';
					}
					else if( $page >= $page_block_num - MAX_AFTER_CURRENT ) {
						$pagination .= '	<li onclick="search_link(1)">...</li>';
						for( $i = $page_block_num - (MAX_BEFORE_CURRENT + MAX_AFTER_CURRENT + 1) + 1; $i <= $page_block_num; $i++ ) {
							if( $page == $i ) {
								$pagination .= '	<li class="current-page">' . ($i) . '</li>';
							}
							else {
								$pagination .= '	<li onclick="search_link(' . ($i) . ')">' . ($i) . '</li>';
							}
						}
					}
					else {
						$pagination .= '	<li onclick="search_link(1)">...</li>';
						for( $i = $page - MAX_BEFORE_CURRENT; $i <= MAX_AFTER_CURRENT + $page; $i++ ) {
							if( $page == $i ) {
								$pagination .= '	<li class="current-page">' . ($i) . '</li>';
							}
							else {
								$pagination .= '	<li onclick="search_link(' . ($i) . ')">' . ($i) . '</li>';
							}
						}
						$pagination .= '	<li onclick="search_link(' . ($page_block_num) . ')">...</li>';
					}
				}

				if( $page != $page_block_num ) {
					$pagination .= '	<li onclick="search_link(' . ($page + 1) . ')">' . '&gt;' . '</li>';
				}
				else {
					$pagination .= '	<li class="not-anchor">' . '&gt;' . '</li>';
				}
				$pagination .= '</ul>';
			}
		}

		$view_data = array(
			'FLG_HIDE'	=> isset($post_data['flg_hide']) ? $post_data['flg_hide'] : '1',
			'CONF'		=> $this->conf,
			'APPLICABLE'=> $applicable_product,
			'PAGINATION'=> $pagination,
			'SHOWING'	=> $showing_record
		);

		$this->load->view('front/order/choose_product', $view_data);
	}



	/*******************************************/
	/*               private関数               */
	/*******************************************/
	// 送料計算
	private function get_shipping_fee($cost = 0)
	{
		if( $cost >= 10000 ) {
			$shipping_fee = 0;
		}
		else {
			$classroom_id = $this->session->userdata('classroom_id');
			$classroom_data = $this->m_classroom->get_one(array('classroom_id' => $classroom_id));
			if( isset($classroom_data['pref']) && $classroom_data['pref'] == '01' ) {
				$shipping_fee = 1320;
			}
			else {
				$shipping_fee = 770;
			}
		}

		return $shipping_fee;
	}



	/*******************************************/
	/*                ajax関数                 */
	/*******************************************/
	// 数量変更
	public function ajax_change_quantity()
	{
		$post_data = $this->input->post();
		$product_id = isset($post_data['product_id']) ? $post_data['product_id'] : '';
		$quantity = isset($post_data['quantity']) ? $post_data['quantity'] : '';

		$ret_val = array(
			'status'	=> FALSE,
			'err_msg'	=> ''
		);

		if( $product_id == '' || $quantity == '' ) {
			$ret_val['err_msg'] = 'パラメータエラーが発生しました。';
		}
		else {
			if( !$this->input->cookie('product_ids') ) {
				$ret_val['err_msg'] = '教材が存在しません。';
			}
			else {
				$product_ids = unserialize($this->input->cookie('product_ids'));
				if( !array_key_exists($product_id, $product_ids) ) {
					$ret_val['err_msg'] = '選択されていない教材です。';
				}
				else {
					$product_ids[$product_id] = $quantity;

					$cookie_save_data = array(
						'name'	=> 'product_ids',
						'value'	=> serialize($product_ids),
						'expire'=> '86400'
					);
					$this->input->set_cookie($cookie_save_data);

					$ret_val['status'] = TRUE;
				}
			}
		}

		$this->ajax_out(json_encode($ret_val));
	}
}
