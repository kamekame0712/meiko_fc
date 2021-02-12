<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *  サービス共通ユーティリティ関数
 */


/**
 * 操作方法を表示するかしないかを返す
 */
function get_instruction()
{
	$CI =& get_instance();

	if( $CI->session->userdata('classroom_id') == FALSE ) {
		return TRUE;
	}
	else {
		$classroom_id = $CI->session->userdata('classroom_id');

		// モデルロード
		$CI->load->model('m_classroom');
		$classroom_data = $CI->m_classroom->get_one(array('classroom_id' => $classroom_id));
		if( empty($classroom_data) ) {
			return TRUE;
		}
		else {
			if( $classroom_data['flg_instruction'] == '1' ) {
				return TRUE;
			}
			else {
				return FALSE;
			}
		}
	}

	return TRUE;
}
