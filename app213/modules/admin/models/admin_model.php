<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function add_grup_menu($kode, $nama) {

		$qry = " INSERT INTO SEC_GROUPS (KODE, NAMA, LOCKED) 
		select '{$kode}', '{$nama}', 0 from dual
		where not exists(select 1 from SEC_GROUPS where lower(KODE)=lower('{$kode}') OR lower(NAMA)=lower('{$nama}'))";
		//$query = $this->db->query($qry);
		$query = $this->db->simple_qry_eon_ora($qry);
	}
 
}

/* End of file _model.php */