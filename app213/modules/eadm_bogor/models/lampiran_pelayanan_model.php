<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class lampiran_pelayanan_model extends CI_Model {
	private $tbl = 'REF_LAMPIRAN_PLY';

	function __construct() {
		parent::__construct();
	}

	function get_by_id($id) {
        $sql = "SELECT * FROM REF_LAMPIRAN_PLY WHERE ID = '{$id}' ";
		$query = $this->db->query($sql);
		if($query->num_rows()!==0){return $query->row();}
		else{return FALSE;}
	}

	function get_jns_ply($id) {
        $sql = "SELECT * FROM REF_JNS_PELAYANAN WHERE KD_JNS_PELAYANAN = '{$id}' ";
		$query = $this->db->query($sql);
		if($query->num_rows()!==0){return $query->row();}
		else{return FALSE;}
	}

	function get_by_kd_ply($rowid){

		$qry = "SELECT RL.*, RJ.NM_JENIS_PELAYANAN
				FROM REF_LAMPIRAN_PLY RL 
				JOIN REF_JNS_PELAYANAN RJ on RL.KD_JNS_PELAYANAN=RJ.KD_JNS_PELAYANAN
				WHEREs RL.KD_JNS_PELAYANAN = '{$rowid}' ";
        $query = $this->db->query($qry);
        if($query->num_rows()!==0){return $query->result();}
		else { return FALSE; } 	 
	}

	function get_select_sub($kd_ply){

		$qry = "SELECT KD_SUB_JNS_PELAYANAN AS KD_SUB, NM_SUB_JENIS_PELAYANAN AS NM_SUB 
				FROM REF_SUB_JNS_PELAYANAN KC
				WHERE KD_JNS_PELAYANAN = '$kd_ply' ";
		//log_message('info', "KKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK  ". $qry);
        $query = $this->db->query($qry);
        if($query->num_rows()!==0){return $query->result();}
		else { return FALSE; } 	 
	}

	function insert_data($data) {
		// insert  data ok
		$result = $this->db->insert_oen_ora($this->tbl, $data);
		return $result;
	}

	function update_data($rowid, $data) {

		$this->db->where('ID', $rowid);
		$result = $this->db->update_oen_ora($this->tbl, $data);
		return $result;
	}

	function delete_data($rowid) {
		//
		$this->db->where('ID', $rowid);
		$result = $this->db->delete_oen_ora($this->tbl);
		//log_message('info', "kkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkk : " . $result);
		return $result;
	}

}

/* End of file _model.php */
