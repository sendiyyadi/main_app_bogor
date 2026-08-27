<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('pad_propinsi_id'))
{
	function pad_propinsi_id($i=0)
	{
		return '32';
	}
	function pad_kabupaten_id($i=0)
	{
		return '78';
	}
}
if ( ! function_exists('kd_kanwil_kantor'))
{
    function kd_kanwil_kantor(){
    	$CI  =& get_instance();
        $qq = "SELECT KD_KANWIL, KD_KANTOR FROM REF_KANTOR WHERE ROWNUM <= 1";
        return $CI->db->query($qq)->row();
    }
}
if ( ! function_exists('kd_mutasi_habis'))
{
    function kd_mutasi_habis(){
        return '16';
    }
}

if ( ! function_exists('kd_kepwal66'))
{
    function kd_kepwal66(){
        return '15';
    }
}