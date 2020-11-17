<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		// モデルロード
		$this->load->model('m_product');

		// 設定ファイルロード
		$this->config->load('config_disp', TRUE, TRUE);
		$this->conf = $this->config->item('disp', 'config_disp');
	}

	public function index()
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

		// 商品
		if( $this->input->cookie('product_list') ) {
			$product_list = unserialize($this->input->cookie('product_list'));
		}
		else {
			$product_list = array();
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
			$cookie_save_data = array(
				'name'	=> 'product_list',
				'value'	=> serialize($product_list),
				'expire'=> '3600'
			);
			$this->input->set_cookie($cookie_save_data);
		}

		// その他
		$payment_method = '';
		if( isset($post_data['payment_method']) ) {
			$payment_method = $post_data['payment_method'];

			$cookie_save_data = array(
				'name'	=> 'payment_method',
				'value'	=> $payment_method,
				'expire'=> '3600'
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
				'expire'=> '3600'
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
				'expire'=> '3600'
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
		$base_date = date('Y-m-d', strtotime('+6 day', time()));
		$select_date = array('' => '最短');

		for( $i = 1; $i <= 15; $i++ ) {
			$target_date = date('Y-m-d', strtotime('+' . $i . ' day', strtotime($base_date)));

			$month = intval(date('n', strtotime($target_date)));
			$day = intval(date('j', strtotime($target_date)));

			// 1/1～1/7は選択不可
			if( $month == 1 && ($day >= 1 && $day <= 7) ) {
				continue;
			}

			$select_date[$target_date] = $target_date . '(' . $w[date('w', strtotime($target_date))] . ')';
		}

		$select_time = array(
			''	=> '指定なし',
			'1'	=> '午前',
			'2'	=> '14～16時',
			'3'	=> '16～18時',
			'4'	=> '18～20時',
			'5'	=> '19～21時'
		);

/*
		// 備考
		$note = '';
		if( !empty($post_data) ) {
			if( !empty($post_data['note']) ) {
				$note = $post_data['note'];

				$cookie_save_data = array(
					'name'	=> 'note',
					'value'	=> $note,
					'expire'=> '3600'
				);
				$this->input->set_cookie($cookie_save_data);
			}
		}
		else {
			if( $this->input->cookie('note') ) {
				$note = $this->input->cookie('note');
			}
		}
*/

		if( !empty($post_data) ) {
			redirect('order');
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

		$view_data = array(
			'PLIST'			=> $product_list,
			'TOTAL_QUANTITY'=> $total_quantity,
			'TOTAL_COST'	=> $total_cost,
			'PAYMENT'		=> $payment_method,
			'DELIVERY_DATE'	=> $delivery_date,
			'DELIVERY_TIME'	=> $delivery_time,
			'SELECT_DATE'	=> $select_date,
			'SELECT_TIME'	=> $select_time,
//			'NOTE'			=> $note,
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


echo '<pre>';
print_r($post_data);
echo '</pre>';





	}

	public function remove_order($product_id = '')
	{
		if( $product_id != '' ) {
			if( $this->input->cookie('product_list') ) {
				$product_list = unserialize($this->input->cookie('product_list'));
				if( array_key_exists($product_id, $product_list) ) {
					unset($product_list[$product_id]);

					$cookie_save_data = array(
						'name'	=> 'product_list',
						'value'	=> serialize($product_list),
						'expire'=> '3600'
					);
					$this->input->set_cookie($cookie_save_data);		
				}
			}
		}

		redirect('order');
	}

	public function remove_all_order()
	{
		if( $this->input->cookie('product_list') ) {
			delete_cookie('product_list');
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
			if( !$this->input->cookie('product_list') ) {
				$ret_val['err_msg'] = '商品が存在しません。';
			}
			else {
				$product_list = unserialize($this->input->cookie('product_list'));
				if( !array_key_exists($product_id, $product_list) ) {
					$ret_val['err_msg'] = '選択されていない商品です。';
				}
				else {
					$sub_total = intval($product_list[$product_id]['sales_price']) * intval($quantity);

					$product_list[$product_id]['quantity'] = $quantity;
					$product_list[$product_id]['sub_total'] = $sub_total;

					$cookie_save_data = array(
						'name'	=> 'product_list',
						'value'	=> serialize($product_list),
						'expire'=> '3600'
					);
					$this->input->set_cookie($cookie_save_data);		

					$ret_val['status'] = TRUE;
				}
			}
		}

		$this->ajax_out(json_encode($ret_val));
	}
}
