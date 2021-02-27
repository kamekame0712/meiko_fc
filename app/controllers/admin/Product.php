<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		// モデルロード
		$this->load->model('m_product');

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
			'CONF'		=> $this->conf,
			'RESULT'	=> $result
		);

		$this->load->view('admin/product/index', $view_data);
	}

	public function add()
	{
		// ログイン済みチェック
		if( !$this->chk_logged_in_admin() ) {
			redirect('admin');
			return;
		}

		$view_data = array(
			'KIND'	=> 'add',
			'PID'	=> '',
			'CONF'	=> $this->conf,
			'PDATA'	=> array()
		);

		$this->load->view('admin/product/input', $view_data);
	}

	public function modify($product_id = '')
	{
		// ログイン済みチェック
		if( !$this->chk_logged_in_admin() ) {
			redirect('admin');
			return;
		}

		$product_data = $this->m_product->get_one(array('product_id' => $product_id));

		$view_data = array(
			'KIND'	=> 'modify',
			'PID'	=> $product_id,
			'CONF'	=> $this->conf,
			'PDATA'	=> $product_data
		);

		$this->load->view('admin/product/input', $view_data);
	}

	public function confirm()
	{
		// ログイン済みチェック
		if( !$this->chk_logged_in_admin() ) {
			redirect('admin');
			return;
		}

		$post_data = $this->input->post();
		$grade = isset($post_data['grade']) ? $post_data['grade'] : array();
		$subject = isset($post_data['subject']) ? $post_data['subject'] : array();
		$period = isset($post_data['period']) ? $post_data['period'] : array();

		// バリデーションチェック
		if( $this->form_validation->run('admin/product') == FALSE ) {
			$view_data = array(
				'KIND'	=> isset($post_data['kind']) ? $post_data['kind'] : 'add',
				'PID'	=> isset($post_data['product_id']) ? $post_data['product_id'] : '',
				'CONF'	=> $this->conf,
				'PDATA'	=> array()
			);

			$this->load->view('admin/product/input', $view_data);
			return;
		}

		$grade_array = array();
		if( !empty($grade) ) {
			foreach( $grade as $val ) {
				$wk_grade = intval($val);
				if( $wk_grade >= 10 && $wk_grade <= 19 ) {
					if( isset($this->conf['grade_e'][$val]) ) {
						$grade_array[] = $this->conf['grade_e'][$val];
					}
				}
				else if( $wk_grade >= 20 && $wk_grade <= 29 ) {
					if( isset($this->conf['grade_j'][$val]) ) {
						$grade_array[] = $this->conf['grade_j'][$val];
					}
				}
				else if( $wk_grade >= 30 && $wk_grade <= 39 ) {
					if( isset($this->conf['grade_h'][$val]) ) {
						$grade_array[] = $this->conf['grade_h'][$val];
					}
				}
				else if( $wk_grade >= 40 && $wk_grade <= 49 ) {
					if( isset($this->conf['grade_o'][$val]) ) {
						$grade_array[] = $this->conf['grade_o'][$val];
					}
				}
			}
		}

		$subject_array = array();
		if( !empty($subject) ) {
			foreach( $subject as $val ) {
				if( isset($this->conf['subject'][$val]) ) {
					$subject_array[] = $this->conf['subject'][$val];
				}
			}
		}

		$period_array = array();
		if( !empty($period) ) {
			foreach( $period as $val ) {
				if( isset($this->conf['period'][$val]) ) {
					$period_array[] = $this->conf['period'][$val];
				}
			}
		}

		$view_data = array(
			'CONF'		=> $this->conf,
			'PDATA'		=> $post_data,
			'GRADE'		=> !empty($grade_array) ? implode(',', $grade_array) : '（設定なし）',
			'SUBJECT'	=> !empty($subject_array) ? implode(',', $subject_array) : '（設定なし）',
			'PERIOD'	=> !empty($period_array) ? implode(',', $period_array) : '（設定なし）'
		);

		$this->load->view('admin/product/confirm', $view_data);
	}

	public function complete()
	{
		// ログイン済みチェック
		if( !$this->chk_logged_in_admin() ) {
			redirect('admin');
			return;
		}

		$post_data = $this->input->post();
		$now = date('Y-m-d H:i:s');

		if( $post_data['kind'] == 'add' ) {
			$insert_data = array(
				'smile_code'	=> !empty($post_data['smile_code']) ? $post_data['smile_code'] : NULL,
				'name'			=> isset($post_data['name']) ? $post_data['name'] : '',
				'keyword'		=> !empty($post_data['keyword']) ? $post_data['keyword'] : NULL,
				'normal_price'	=> isset($post_data['normal_price']) ? $post_data['normal_price'] : 0,
				'sales_price'	=> isset($post_data['sales_price']) ? $post_data['sales_price'] : 0,
				'recommend'		=> isset($post_data['recommend']) && $post_data['recommend'] == '1' ? '1' : '9',
				'grade'			=> !empty($post_data['grade']) ? implode(',', $post_data['grade']) : NULL,
				'subject'		=> !empty($post_data['subject']) ? implode(',', $post_data['subject']) : NULL,
				'period'		=> !empty($post_data['period']) ? implode(',', $post_data['period']) : NULL,
				'publisher'		=> !empty($post_data['publisher']) ? $post_data['publisher'] : NULL,
				'flg_market'	=> !empty($post_data['flg_market']) ? $post_data['flg_market'] : '1',
				'flg_sales'		=> !empty($post_data['flg_sales']) ? $post_data['flg_sales'] : '1',
				'regist_time'		=> $now,
				'update_time'		=> $now,
				'status'			=> '0'
			);

			if( !$this->m_product->insert($insert_data) ) {
				redirect('admin/product/index/err1');
				return;
			}
		}
		else {
			$product_id = isset($post_data['product_id']) ? $post_data['product_id'] : '';
			$product_data = $this->m_product->get_one(array('product_id' => $product_id));

			if( !empty($product_data) ) {
				$update_data = array(
					'smile_code'	=> !empty($post_data['smile_code']) ? $post_data['smile_code'] : NULL,
					'name'			=> isset($post_data['name']) ? $post_data['name'] : '',
					'keyword'		=> !empty($post_data['keyword']) ? $post_data['keyword'] : NULL,
					'normal_price'	=> isset($post_data['normal_price']) ? $post_data['normal_price'] : 0,
					'sales_price'	=> isset($post_data['sales_price']) ? $post_data['sales_price'] : 0,
					'recommend'		=> isset($post_data['recommend']) && $post_data['recommend'] == '1' ? '1' : '9',
					'grade'			=> !empty($post_data['grade']) ? implode(',', $post_data['grade']) : NULL,
					'subject'		=> !empty($post_data['subject']) ? implode(',', $post_data['subject']) : NULL,
					'period'		=> !empty($post_data['period']) ? implode(',', $post_data['period']) : NULL,
					'publisher'		=> !empty($post_data['publisher']) ? $post_data['publisher'] : NULL,
					'flg_market'	=> !empty($post_data['flg_market']) ? $post_data['flg_market'] : '1',
					'flg_sales'		=> !empty($post_data['flg_sales']) ? $post_data['flg_sales'] : '1',
					'update_time'		=> $now
				);

				if( !$this->m_product->update(array('product_id' => $product_id), $update_data) ) {
					redirect('admin/product/index/err1');
					return;
				}
			}
			else {
				redirect('admin/product/index/err2');
				return;
			}
		}

		redirect('admin/product/index/ok');
		return;
	}

	public function dl()
	{
		// ログイン済みチェック
		if( !$this->chk_logged_in_admin() ) {
			redirect('admin');
			return;
		}

		$post_data = $this->input->post();

		$conditions = array(
			'product_name'		=> isset($post_data['product_name']) ? $post_data['product_name'] : '',
			'smile_code_from'	=> isset($post_data['smile_code_from']) ? $post_data['smile_code_from'] : '',
			'smile_code_to'		=> isset($post_data['smile_code_to']) ? $post_data['smile_code_to'] : '',
			'publisher'			=> isset($post_data['publisher']) ? $post_data['publisher'] : '',
			'flg_market'		=> !empty($post_data['flg_market']) ? explode(',', $post_data['flg_market']) : array(),
			'flg_sales'			=> !empty($post_data['flg_sales']) ? explode(',', $post_data['flg_sales']) : array()
		);

		$product_data = $this->m_product->get_list_for_download($conditions);

		// タイムアウトさせない
		set_time_limit(0);

		$fp = fopen('php://output', 'w');
		stream_filter_append($fp, 'convert.iconv.UTF-8/CP932//TRANSLIT', STREAM_FILTER_WRITE);

		header("Content-Type: application/octet-stream");
		header("Content-Disposition: attachment; filename=" . 'product' . date('YmdHis') . '.csv');

		if( empty($product_data) ) {
			fputs($fp, 'no data');
		}
		else {
			$csv_array = array(
				'ID', 'SMILEコード', '商品名', '検索キーワード',
				'通常価格', '販売価格', '明光本部推奨',
				'学年', '教科', '期間講習', '出版社',
				'1:塾用 2:市販', '1:通常 2:売上 3:未発刊'
			);
			fputcsv($fp, $csv_array);

			foreach( $product_data as $val ) {
				$csv_array = array(
					$val['product_id'], $val['smile_code'], $val['name'], $val['keyword'],
					$val['normal_price'], $val['sales_price'], $val['recommend'] == '1' ? '1' : '',
					$val['grade'], $val['subject'], $val['period'], $val['publisher'],
					$val['flg_market'], $val['flg_sales']
				);
				fputcsv($fp, $csv_array);
			}
		}

		fclose($fp);
	}

	public function config_dl()
	{
		// ログイン済みチェック
		if( !$this->chk_logged_in_admin() ) {
			redirect('admin');
			return;
		}

		// タイムアウトさせない
		set_time_limit(0);

		$fp = fopen('php://output', 'w');
		stream_filter_append($fp, 'convert.iconv.UTF-8/CP932//TRANSLIT', STREAM_FILTER_WRITE);

		header("Content-Type: application/octet-stream");
		header("Content-Disposition: attachment; filename=" . 'config.csv');

		$csv_array = array('コード', '学年等');
		fputcsv($fp, $csv_array);

		$csv_array = array();
		foreach( $this->conf['grade_e'] as $key => $val ) {
			$csv_array = array($key, $val);
			fputcsv($fp, $csv_array);
		}
		foreach( $this->conf['grade_j'] as $key => $val ) {
			$csv_array = array($key, $val);
			fputcsv($fp, $csv_array);
		}
		foreach( $this->conf['grade_h'] as $key => $val ) {
			$csv_array = array($key, $val);
			fputcsv($fp, $csv_array);
		}
		foreach( $this->conf['grade_o'] as $key => $val ) {
			$csv_array = array($key, $val);
			fputcsv($fp, $csv_array);
		}

		$csv_array = array('コード', '教科');
		fputcsv($fp, $csv_array);

		$csv_array = array();
		foreach( $this->conf['subject'] as $key => $val ) {
			$csv_array = array($key, $val);
			fputcsv($fp, $csv_array);
		}

		$csv_array = array('コード', '期間講習');
		fputcsv($fp, $csv_array);

		$csv_array = array();
		foreach( $this->conf['period'] as $key => $val ) {
			$csv_array = array($key, $val);
			fputcsv($fp, $csv_array);
		}

		$csv_array = array('コード', '出版社');
		fputcsv($fp, $csv_array);

		$csv_array = array();
		foreach( $this->conf['publisher'] as $key => $val ) {
			$csv_array = array($key, $val);
			fputcsv($fp, $csv_array);
		}

		fclose($fp);
	}









	/*******************************************/
	/*                ajax関数                 */
	/*******************************************/
	public function ajax_del()
	{
		$post_data = $this->input->post();
		$product_id = isset($post_data['product_id']) ? $post_data['product_id'] : '';

		$ret_val = array(
			'status'			=> FALSE,
			'err_msg'			=> ''
		);

		if( $product_id == '' ) {
			$ret_val['err_msg'] = 'パラメータエラーが発生しました。';
		}
		else {
			$product_data = $this->m_product->get_one(array('product_id' => $product_id));
			if( empty($product_data) ) {
				$ret_val['err_msg'] = '削除する教材情報が存在しません。';
			}
			else {
				$update_data = array(
					'update_time'	=> date('Y-m-d H:i:s'),
					'status'		=> '9'
				);

				if( $this->m_product->update(array('product_id' => $product_id), $update_data) ) {
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
		$sort = isset($post_data['sort']) ? $post_data['sort'] : array();

		$conditions = array(
			'product_name'		=> isset($post_data['product_name']) ? $post_data['product_name'] : '',
			'smile_code_from'	=> isset($post_data['smile_code_from']) ? $post_data['smile_code_from'] : '',
			'smile_code_to'		=> isset($post_data['smile_code_to']) ? $post_data['smile_code_to'] : '',
			'publisher'			=> isset($post_data['publisher']) ? $post_data['publisher'] : '',
			'flg_market'		=> isset($post_data['flg_market']) ? $post_data['flg_market'] : array(),
			'flg_sales'			=> isset($post_data['flg_sales']) ? $post_data['flg_sales'] : array()
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

		list($product_data, $product_cnt) = $this->m_product->get_list_bootgrid($conditions, $sort_str, $limit_array);
		$row_val = array();

		if( !empty($product_data) ) {
			foreach( $product_data as $val ) {
				$grade = '';
				if( !empty($val['grade']) ) {
					$grade_array = array();
					foreach( explode(',', $val['grade']) as $grade_val ) {
						$wk_grade = intval($grade_val);

						if( $wk_grade >= 10 && $wk_grade <= 19 ) {
							if( isset($this->conf['grade_e'][$grade_val]) ) {
								$grade_array[] = $this->conf['grade_e'][$grade_val];
							}
						}
						else if( $wk_grade >= 20 && $wk_grade <= 29 ) {
							if( isset($this->conf['grade_j'][$grade_val]) ) {
								$grade_array[] = $this->conf['grade_j'][$grade_val];
							}
						}
						else if( $wk_grade >= 30 && $wk_grade <= 39 ) {
							if( isset($this->conf['grade_h'][$grade_val]) ) {
								$grade_array[] = $this->conf['grade_h'][$grade_val];
							}
						}
						else if( $wk_grade >= 40 && $wk_grade <= 49 ) {
							if( isset($this->conf['grade_o'][$grade_val]) ) {
								$grade_array[] = $this->conf['grade_o'][$grade_val];
							}
						}
					}
					$grade = implode(',', $grade_array);
				}

				$subject = '';
				if( !empty($val['subject']) ) {
					$subject_array = array();
					foreach( explode(',', $val['subject']) as $subject_val ) {
						if( isset($this->conf['subject'][$subject_val]) ) {
							$subject_array[] = $this->conf['subject'][$subject_val];
						}
					}
					$subject = implode(',', $subject_array);
				}

				$period = '';
				if( !empty($val['period']) ) {
					$period_array = array();
					foreach( explode(',', $val['period']) as $period_val ) {
						if( isset($this->conf['period'][$period_val]) ) {
							$period_array[] = $this->conf['period'][$period_val];
						}
					}
					$period = implode(',', $period_array);
				}

				$row_val[] = array(
					'product_id'	=> $val['product_id'],
					'name'			=> $val['name'],
					'smile_code'	=> $val['smile_code'],
					'publisher'		=> isset($this->conf['publisher'][$val['publisher']]) ? $this->conf['publisher'][$val['publisher']] : '',
					'flg_market'	=> $val['flg_market'] == '1' ? '塾用教材' : '市販教材',
					'grade'			=> $grade,
					'subject'		=> $subject,
					'period'		=> $period,
					'flg_sales'		=> $this->conf['flg_sales'][$val['flg_sales']],
					'normal_price'	=> '\\' . number_format($val['normal_price']),
					'sales_price'	=> '\\' . number_format($val['sales_price'])
				);
			}
		}

		$ret_val = array(
			'current'	=> $current,
			'rowCount'	=> $rowCount,
			'total'		=> $product_cnt,
			'rows'		=> $row_val
		);

		$this->ajax_out(json_encode($ret_val));
	}
}
