<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('msg_block'))
{
    function msg_block()
    {
		$CI =& get_instance();
		
		if($CI->session->flashdata('msg_error')) {
			$ret = '<div id="msg_helper" class="alert alert-danger">';
			$ret.= $CI->session->flashdata('msg_error');
			$ret.= '</div>';
			return $ret;
		}
		
		if($CI->session->flashdata('msg_warning')) {
			$ret = '<div id="msg_helper" class="alert alert-warning">';
			$ret.= $CI->session->flashdata('msg_warning');
			$ret.= '</div>';
			
			return $ret;
		}
		
		if($CI->session->flashdata('msg_info')) {
			$ret = '<div id="msg_helper" class="alert alert-info">';
			$ret.= $CI->session->flashdata('msg_info');
			$ret.= '</div>';
			return $ret;
		}
				
		if($CI->session->flashdata('msg_success')) {
			$ret = '<div id="msg_helper" class="alert alert-success">';
			$ret.= $CI->session->flashdata('msg_success');
			$ret.= '</div>';
			return $ret;
		}

		if($CI->session->flashdata('msg_block')) {
			$ret = '<div id="msg_helper" class="alert alert-block">';
			$ret.= $CI->session->flashdata('msg_block');
			$ret.= '</div>';
			return $ret;
		}

		if(isset($_SESSION['msg_db_error'])){
			$output = $_SESSION['msg_db_error'];
			$_SESSION['msg_db_error'] = '';
	        if(!empty($output)){
	            $ret = '<div id="msg_helper" class="alert alert-error">';
	            $ret.= '<button type="button" class="close" data-dismiss="alert">&times;</button>';
	            $ret.= $output;
	            $ret.= '</div>';
	            return $ret;
	        }
		}
				
    }   
}