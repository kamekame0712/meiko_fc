<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class History extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		// モデルロード
		$this->load->model('m_order');
		$this->load->model('m_order_detail');
		$this->load->model('m_product');

		// 設定ファイルロード
		$this->config->load('config_disp', TRUE, TRUE);
		$this->conf = $this->config->item('disp', 'config_disp');
	}

	public function index($page = 1)
	{
		// ログイン済みチェック
		if( !$this->chk_logged_in() ) {
			redirect('index');
			return;
		}

		$classroom_id = $this->session->userdata('classroom_id');

		$limit = array(RECORD_PER_PAGE_HISTORY , ($page - 1) * intval(RECORD_PER_PAGE_HISTORY));
		$order_data = $this->m_order->get_list(array('classroom_id' => $classroom_id), 'regist_time DESC', $limit);
		$total = $this->m_order->get_count(array('classroom_id' => $classroom_id));
		$pagination = '';
		$showing_record = '';

		if( !empty($order_data) ) {
			$showing_record = ( ($page - 1) * intval(RECORD_PER_PAGE_HISTORY) + 1 ) . '～' . ( count($order_data) == intval(RECORD_PER_PAGE_HISTORY) ? ( $page * intval(RECORD_PER_PAGE_HISTORY) ) : ( $total ) ) . '（全' . $total . '件）';
			$page_block_num = ceil($total / RECORD_PER_PAGE_HISTORY); // ページブロック数

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
			'CONF'		=> $this->conf,
			'HISTORY'	=> $order_data,
			'TOTAL'		=> $total,
			'PAGINATION'=> $pagination,
			'SHOWING'	=> $showing_record
		);

		$this->load->view('front/history/index', $view_data);
	}

	public function detail($order_id = '')
	{
		// ログイン済みチェック
		if( !$this->chk_logged_in() ) {
			redirect('index');
			return;
		}

		$order_data = $this->m_order->get_one_with_detail($order_id);

		$view_data = array(
			'CONF'		=> $this->conf,
			'DETAIL'	=> $order_data
		);

		$this->load->view('front/history/detail', $view_data);
	}

	public function reorder($order_id = '')
	{
		// 発注内容の削除
		if( $this->input->cookie('product_ids') ) {
			delete_cookie('product_ids');
		}

		$product_ids = array();
		$order_detail_data = $this->m_order_detail->get_list(array('order_id' => $order_id));
		if( !empty($order_detail_data) ) {
			foreach( $order_detail_data as $val ) {
				$product_ids[$val['product_id']] = 1;
			}

			$cookie_save_data = array(
				'name'	=> 'product_ids',
				'value'	=> serialize($product_ids),
				'expire'=> '86400'
			);
			$this->input->set_cookie($cookie_save_data);
		}

		redirect('order');
	}



	/*******************************************/
	/*                ajax関数                 */
	/*******************************************/
	// 履歴から発注できるかどうかチェック
	public function ajax_check_reorder()
	{
		$post_data = $this->input->post();
		$order_id = isset($post_data['order_id']) ? $post_data['order_id'] : '';

		$ret_val = array(
			'status'	=> '3',	// 1:問題無し 2:変更あり 3:エラー
			'err_msg'	=> ''
		);

		if( $order_id == '' ) {
			$ret_val['err_msg'] = 'パラメータエラーが発生しました。';
		}
		else {
			$order_data = $this->m_order->get_one_with_detail($order_id);
			if( empty($order_data) ) {
				$ret_val['err_msg'] = '発注情報が存在しません。';
			}
			else {
				$err_flg = FALSE;
				$err_array = array(FALSE, FALSE, FALSE);
				foreach( $order_data as $val ) {
					$product_data = $this->m_product->get_one(array('product_id' => $val['product_id']));
					if( empty($product_data) ) {
						$err_array[0] = TRUE;
						$err_flg = TRUE;
					}

					if( $product_data['name'] != $val['product_name'] ) {
						$err_array[1] = TRUE;
						$err_flg = TRUE;
					}

					if( $product_data['sales_price'] != $val['sales_price'] ) {
						$err_array[2] = TRUE;
						$err_flg = TRUE;
					}
				}

				if( !$err_flg ) {
					$ret_val['status'] = '1';
				}
				else {
					$ret_val['status'] = '2';
					$err_msg = array();
					if( $err_array[0] ) {
						$err_msg[] = '廃刊等により、取扱いが出来なくなった教材が含まれています。';
					}

					if( $err_array[1] ) {
						$err_msg[] = '教材名の変更になった教材が含まれています。';
					}

					if( $err_array[2] ) {
						$err_msg[] = '販売価格の変更になった教材が含まれています。';
					}

					$ret_val['err_msg'] = implode('___', $err_msg);
				}
			}
		}

		$this->ajax_out(json_encode($ret_val));
	}
}