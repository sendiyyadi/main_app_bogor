<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class kecamatan_model extends CI_Model {
	private $tbl = 'REF_KECAMATAN';

	function __construct() {
		parent::__construct();
	}

	function get_all()
	{
        $sql = "select KD_PROPINSI,KD_DATI2,KD_KECAMATAN,NM_KECAMATAN FROM REF_KECAMATAN kec ";
		$query = $this->db->query($sql);
		if($query->num_rows()!==0){return $query->result();}
		else{return FALSE;}
	}


	function cek_uniq_key($rowid, $kec) {

		$qry = "SELECT KD_KECAMATAN FROM REF_KECAMATAN KC
		WHERE KC.ROWID != '{$rowid}'
		AND lower(trim(KC.KD_KECAMATAN)) = lower(trim('{$kec}')) AND ROWNUM <= 1";
		//log_message('info', "KKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK  ". $qry);
        $query = $this->db->query($qry);
        if($query->num_rows()!==0) {return TRUE; }
				else { return FALSE; }    
	}

	function get($rowid){

		$qry = "SELECT ROWIDTOCHAR(KC.ROWID) AS ID, KC.KD_PROPINSI, KC.KD_DATI2, KC.KD_KECAMATAN, KC.NM_KECAMATAN 
		FROM REF_KECAMATAN KC
		WHERE KC.ROWID = '{$rowid}' ";
		//log_message('info', "KKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK  ". $qry);
        $query = $this->db->query($qry);
        if($query->num_rows()!==0){return $query->row();}
		else { return FALSE; } 	 
	}

	function get_select(){

		$qry = "SELECT KC.KD_PROPINSI, KC.KD_DATI2, KC.KD_KECAMATAN, KC.NM_KECAMATAN 
		FROM REF_KECAMATAN KC";
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

		$this->db->where('ROWID', $rowid);
		$result = $this->db->update_oen_ora($this->tbl, $data);
		return $result;
	}

	function update_data_OLD($prop, $dati, $kec,$data) {

		$this->db->where('KD_PROPINSI', $prop);
		$this->db->where('KD_DATI2', $dati);
		$this->db->where('KD_KECAMATAN', $kec);

		$result = $this->db->update_oen_ora($this->tbl, $data);
		return $result;
	}

	function delete_data($prop, $dati, $kec) {
		//
		$this->db->where('KD_PROPINSI', $prop);
		$this->db->where('KD_DATI2', $dati);
		$this->db->where('KD_KECAMATAN', $kec);
		$result = $this->db->delete_oen_ora($this->tbl);
		//log_message('info', "kkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkk : " . $result);
		return $result;
	}

	//-- admin
	function save($data) {
		$this->db->insert($this->tbl,$data);
		return $this->db->insert_id();
	}

	function update($prop, $dati, $kec, $data) {

		$this->db->where('KD_PROPINSI', $prop);
		$this->db->where('KD_DATI2', $dati);
		$this->db->where('KD_KECAMATAN', $kec);

		$this->db->update($this->tbl,$data);
	}

	function delete($prop, $dati, $kec) {

		$this->db->where('KD_PROPINSI', $prop);
		$this->db->where('KD_DATI2', $dati);
		$this->db->where('KD_KECAMATAN', $kec);

		$this->db->delete($this->tbl);
	}
}

/* End of file _model.php */
