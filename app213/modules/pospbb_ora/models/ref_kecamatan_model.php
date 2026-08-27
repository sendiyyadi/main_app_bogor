<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ref_kecamatan_model extends CI_Model {
	private $tbl = 'REF_KECAMATAN';
	private $schema_pbb = SCHEMA_PBB.".";
	
	function __construct() {
		parent::__construct();
	}
	
	function get_select_kec(){

		$schema_pbb = $this->schema_pbb;
		$kd_kec = get_user_kec_kd();
		$filter = '';
		if($kd_kec != '000'){ $filter = " and kd_kecamatan='$kd_kec'"; }
	  	$sql="select * from S_REF_KECAMATAN 
 		where kd_propinsi='".KD_PROPINSI."' and kd_dati2='".KD_DATI2."'".$filter;
 		$qry=$this->db->query($sql);
  		return $qry->result();
	}

	function getRecord($kec='000'){

		$schema_pbb = $this->schema_pbb;
		$sql="select * from S_REF_KECAMATAN 
 		where kd_propinsi='".KD_PROPINSI."' and kd_dati2='".KD_DATI2."'";
 		if ($kec!='000')
 		    $sql.=" and kd_kecamatan='$kec'";
		//    die($sql);
 		$qry=$this->db->query($sql);
  		return $qry->result();
	}

}

/* End of file _model.php */