<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class users_model extends CI_Model {
	private $tbl = 'SEC_USERS';
	
	function __construct() {
		parent::__construct();
	}
		
	function get_all() {

        $sql = "select US.* , PG.NM_PEGAWAI, RU.EMAIL as EMAIL_REG_USER
		from SEC_USERS US 
		LEFT JOIN V_PEGAWAI PG ON RTRIM(PG.NIP)=RTRIM(US.NIP)
		LEFT JOIN REG_USERS RU ON TRIM(USERID) = TRIM(RU.NIK) AND RU.STA_OTP_EMAIL = 1
		order by US.NAMA";
		$query = $this->db->query($sql);
        if($query->num_rows()>0)
            return $query->result();
        else
            return false;
	}

	function get_select_pgw_pbb() {

        $sql = "SELECT RTRIM(PG.NIP) AS NIP,PG.NM_PEGAWAI FROM V_PEGAWAI PG order by NM_PEGAWAI";
		$query = $this->db->query($sql);
        if($query->num_rows()>0){
            return $query->result();
        }
        else{
            return false;
        }
	}

	function get_by_group($group_id, $in_group=false) {	

		$sql = "select * from (
		select 1 in_group, u.*, ".$group_id." group_id
		from SEC_USERS u
		inner join SEC_USER_GROUPS ug on ug.user_id=u.id
		where group_id=".$group_id."
		union
		select 0 as in_group, u.*,".$group_id." group_id
		from SEC_USERS u
		where u.id not in (select user_id from SEC_USER_GROUPS where group_id=".$group_id.")
		) as gu ".($in_group? " where in_group=1 ": "")." order by in_group desc, disabled desc, nama";
				
		$query = $this->db->query($sql);
        if($query->num_rows()>0){ return $query->result(); }
        else{ return false; }
	}
	
	function get($id)
	{

		$this->db->where('ID',$id);
		$query = $this->db->get($this->tbl);
        if($query->num_rows()>0){ return $query->row(); }
        else{ return false; }
	}
	
	//-- admin
	function save($data) {

		return $this->db->insert_eon_ora($this->tbl,$data);

	}
	
	function update($id, $data) {

		$this->db->where('ID', $id);
		return $this->db->update($this->tbl,$data); 
	}
	
	function delete($id) {

        $this->db->where('ID', $id);
        return $this->db->delete($this->tbl);

	}
	
	function encript_value($val_user, $val_pwd){
		$qry = 	"select fn_keylock('{$val_user}','{$val_pwd}') as FN_KEYLOCK from dual";
		$query = $this->db->query($qry);
		return $query->row();
	}
	
}

/* End of file _model.php */