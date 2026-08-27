<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class eadm_model extends CI_Model{
	 public function __construct()
    {
        parent::__construct();
    }

    function select_max_no_sk(){
    	$year_now = date('Y');
    	$ret = array();
    	$qq = $this->db->query("SELECT THN_SURAT, NO_URUT_SK FROM MAX_NO_SK WHERE THN_SURAT='{$year_now}' AND ID=1 ");
    	if($qq->num_rows() > 0){
    		$ret= $qq->row_array();
    		$ret['NEW_YEAR'] = 0;
    	}else{
    		$ret = array('THN_SURAT'=> $year_now,
    			'NO_URUT_SK' => 0,
    			'NEW_YEAR' => 1);
    		
    	}
    	return $ret;
    }

    function thnsurat_max_no_sk(){
        $year_now = date('Y');
    	$qq = $this->db->query("SELECT THN_SURAT AS TAHUN FROM MAX_NO_SK WHERE THN_SURAT='{$year_now}' AND ID=1 ");
    	return $qq->row()->TAHUN;
    }

    function update_max_no_sk($tahun, $no_urut){
    	$thn_exists = $this->thnsurat_max_no_sk();
    	$year_now = date('Y');
    	if($thn_exists == $year_now){
    		$qq = "UPDATE MAX_NO_SK SET NO_URUT_SK='$no_urut', UPDATE_TIME=SYSTIMESTAMP WHERE ID=1";
    	}else{
    		$qq = "UPDATE MAX_NO_SK SET THN_SURAT='{$tahun}', NO_URUT_SK={$no_urut}, UPDATE_TIME=SYSTIMESTAMP WHERE ID=1";
    	}
    	$this->db->query($qq);
    }

    function select_max_nosk_kepwal66(){
        $year_now = date('Y');
        $ret = array();
        $qq = $this->db->query("SELECT THN_SURAT, NO_URUT_SK FROM MAX_NOSK_KEPWAL66 WHERE THN_SURAT='{$year_now}' AND ID=1 ");
        if($qq->num_rows() > 0){
            $ret= $qq->row_array();
            $ret['NEW_YEAR'] = 0;
        }else{
            $ret = array('THN_SURAT'=> $year_now,
                'NO_URUT_SK' => 0,
                'NEW_YEAR' => 1);
            
        }
        return $ret;
    }

    function thnsurat_max_nosk_kepwal66(){
        $year_now = date('Y');
        $qq = $this->db->query("SELECT THN_SURAT AS TAHUN FROM MAX_NOSK_KEPWAL66 WHERE THN_SURAT='{$year_now}' AND ID=1 ");
        return $qq->row()->TAHUN;
    }

    function update_max_nosk_kepwal66($tahun, $no_urut){
        $thn_exists = $this->thnsurat_max_nosk_kepwal66();
        $year_now = date('Y');
        if($thn_exists == $year_now){
            $qq = "UPDATE MAX_NOSK_KEPWAL66 SET NO_URUT_SK='$no_urut', UPDATE_TIME=SYSTIMESTAMP WHERE ID=1";
        }else{
            $qq = "UPDATE MAX_NOSK_KEPWAL66 SET THN_SURAT='{$tahun}', NO_URUT_SK={$no_urut}, UPDATE_TIME=SYSTIMESTAMP WHERE ID=1";
        }
        $this->db->query($qq);
    }

    function pekerjaan_wp_droplist($kode_item = null){
        $qq = "SELECT * FROM LOOKUP_ITEM WHERE KD_LOOKUP_GROUP='08' AND KD_LOOKUP_ITEM != '0' ";
        if(!empty($kode_item)){
            $qq .= " AND KD_LOOKUP_ITEM='$kode_item' ";
        }
        $xx=$this->db->query($qq);
        return $xx->result();
    }

    function lookup_item_droplist($kdgrup,$kode = null){
        $qq = "SELECT * FROM LOOKUP_ITEM WHERE KD_LOOKUP_GROUP='{$kdgrup}' ";
        if(!empty($kode)){
            $qq .= " AND KD_LOOKUP_ITEM='{$kode}' ";
        }
        $xx = $this->db->query($qq);
        return $xx->result();
    }

    function jpb_jpt_droplist($kode = null)
    {
        $qq = "SELECT * FROM JPB_JPT";
        if(!empty($kode)){
            $qq .= " WHERE KD_JPB_JPT='{$kode}' ";
        }
        $xx = $this->db->query($qq);
        return $xx->result();
    }

    function ref_jbp_droplist($kode = null)
    {
        $qq = "SELECT * FROM REF_JPB";
        if(!empty($kode)){
            $qq .= " WHERE KD_JPB='{$kode}' ";
        }
        $xx = $this->db->query($qq);
        return $xx->result();
    }

    function ref_fasilitas_droplist($kode = null)
    {
        $qq = "SELECT * FROM FASILITAS";
        if(!empty($kode)){
            $qq .= " WHERE KD_FASILITAS='{$kode}' ";
        }
        $xx = $this->db->query($qq);
        return $xx->result();
    }

}