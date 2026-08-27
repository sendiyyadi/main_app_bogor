<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ref_kelurahan_model extends CI_Model {

	private $tbl = 'REF_KELURAHAN';
	private $schema_pbb = SCHEMA_PBB.".";
	
	function __construct() {
		parent::__construct();
	}

	function get_select_kel($kd_kecamatan="0"){

		$schema_pbb = $this->schema_pbb;
		if(empty($kd_kecamatan)){ $kd_kecamatan = " "; }

		$kd_kec = get_user_kec_kd();
		$kd_kel = get_user_kel_kd();
		$filter = '';
		if($kd_kec != '000'){ $filter .= " and kl.kd_kecamatan='$kd_kec'"; $kd_kecamatan = "$kd_kec"; }
		if($kd_kel != '000'){ $filter .= " and kl.kd_kelurahan='$kd_kel'"; }
		 
	  	$sql="select kl.* from S_REF_KELURAHAN kl
 		where kl.kd_propinsi='".KD_PROPINSI."' and kl.kd_dati2='".KD_DATI2."' and kl.kd_kecamatan='$kd_kecamatan' ".$filter;
 		//log_message('info', "WWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWW  get_select_kel : ". $sql);
 		$qry=$this->db->query($sql);
  		return $qry->result();
	}	

	function get_select_nm_kel_all(){

		$schema_pbb = $this->schema_pbb;
		$kd_kec = get_user_kec_kd();
		$kd_kel = get_user_kel_kd();
		$filter = '';
		if($kd_kec != '000'){ $filter .= " and kl.KD_KECAMATAN='$kd_kec'"; }
		if($kd_kel != '000'){ $filter .= " and kl.KD_KELURAHAN='$kd_kel'"; }

	  	$sql="SELECT KD_KECAMATAN,KD_KELURAHAN,NM_KELURAHAN
 		FROM S_REF_KELURAHAN KL 
 		WHERE 1=1 $filter
 		ORDER BY KD_KECAMATAN,NM_KELURAHAN";
 		$qry=$this->db->query($sql);
  		return $qry->result();
	}
 
	function get_nm_kel_by_kec($kode){

		$schema_pbb = $this->schema_pbb;
		if ($kode == '000.000') { return '000.000 SELURUH KELURAHAN';}
		//
		$kd_kec = substr($kode,0,3);
		$kd_kel = substr($kode,3,3);
	  	$sql="SELECT (KD_KECAMATAN||'.'||KD_KELURAHAN||' '||NM_KELURAHAN) AS NAMA
 		FROM S_REF_KELURAHAN KL 
 		WHERE kl.KD_KECAMATAN='$kd_kec' and kl.KD_KELURAHAN='$kd_kel' ";
 		$query=$this->db->query($sql);
        if ($query->num_rows() !== 0) { return $query->row()->NAMA; } 
        else{ return 'KODE KELURAHAN TIDAK TERDAFTAR'; }
	}

}

/* End of file _model.php */