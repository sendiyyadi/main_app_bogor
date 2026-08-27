<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class groups_model extends CI_Model {
	private $tbl = 'SEC_GROUPS';
	
	function __construct() {
		parent::__construct();
	}
		
	function get_all()	{	
		$sql = "select * from SEC_GROUPS order by id";				
		$query = $this->db->query($sql);
		if($query->num_rows()!==0) { return $query->result(); }
		else{ return FALSE; }
	}
	
	function get($id) {
		$this->db->where('ID',$id);
		$query = $this->db->get($this->tbl);
		if($query->num_rows()!==0)
		{
			return $query->row();
		}
		else
			return FALSE;
	}
	
	function is_locked($id)
	{
		$this->db->where('ID',$id);
		$this->db->where('LOCKED',1);
		$query = $this->db->get($this->tbl);
		if($query->num_rows()!==0)
		{
			return TRUE;
		}
		else
			return FALSE;
	}

	function get_select_users_in_group($group_id, $level_id,$in_group=0,$disabled_id,$userlogin,$user_nama) {	

        $filter = " ";
        if ($level_id < 9){	$filter = " LEVEL_ID={$level_id} and ";}
        //
        $filter_2 = "where 1=1 ";
        if ($in_group == 1)   { $filter_2 .= " and gu.in_group=1 ";} 
        if ($disabled_id == 1){ $filter_2 .= " and gu.disabled=1 ";}
        if ($disabled_id == 2){ $filter_2 .= " and gu.disabled=0 ";}
        if (!empty($userlogin)){
			$userlogin = trim($userlogin);
			$userlogin = strtoupper($userlogin);
			$filter_2 .= "and upper(gu.userid) like '%".$userlogin."%'";
        }
        if (!empty($user_nama)){
			$user_nama = trim($user_nama);
			$user_nama = strtoupper($user_nama);
			$filter_2 .= "and upper(gu.nama) like '%".$user_nama."%'";
        }        
        //
        $sql = "select gu.in_group, gu.id, gu.userid, gu.nama, gu.disabled, gu.CREATED_DATE, 
        gu.LEVEL_ID, gu.group_id,
        (case when gu.LEVEL_ID=1 then 'PEMDA' 
              when gu.LEVEL_ID=2 then 'WR' 
		      when gu.LEVEL_ID=3 then 'OR' 
		      when gu.LEVEL_ID=4 then 'PASAR' else '' end) as level_nama
        from (
		select 1 in_group, u.id, u.userid, u.nama, coalesce(u.disabled,0) as disabled, u.CREATED_DATE, u.LEVEL_ID, 
		".$group_id." group_id
		from SEC_USERS u
		join SEC_USER_GROUPS ug on ug.user_id=u.id
		where {$filter} group_id=".$group_id."
		union
		select 0 as in_group, u.id, u.userid, u.nama, coalesce(u.disabled,0) as disabled, u.CREATED_DATE, u.LEVEL_ID, 
		".$group_id." group_id
		from SEC_USERS u
		where {$filter} u.id not in (select z1.user_id from SEC_USER_GROUPS z1 where z1.group_id=".$group_id.")
		) gu
		".$filter_2."
		order by gu.in_group desc, gu.disabled desc, gu.nama";
		// var_dump($sql);die;
		//log_message('info', "AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA   : ".$sql);
		$query = $this->db->query($sql);
        if($query->num_rows()>0){return $query->result();}
        else {return false;}
	}

	function leave_one_super_admin() {
		$this->db->where('GROUP_ID',1);  //--> id super admin
		$query = $this->db->get('SEC_USERS');
		if($query->num_rows==1)
		{
			return TRUE;
		}
		else
			return FALSE;
	}

	function cek_role_user($user_id, $group_id){

		if(empty($user_id)){$user_id = '0';}
		if(empty($group_id)){$group_id = '0';}

		$this->db->where('USER_ID',$user_id);
		$this->db->where('GROUP_ID',$group_id);
		$query = $this->db->get('SEC_USERS');
		if($query->num_rows()!==0){	return $query->row();}
		else {return FALSE;}
	}

	//-- admin
	function insert_data($data) {
		// insert  data ok
		$result = $this->db->insert_eon_ora($this->tbl, $data);
		return $result;
	}
	function update_data($id,$data) {
		$this->db->where('ID', $id);
		$result = $this->db->update_eon_ora($this->tbl, $data);
		return $result;
	}
	function delete_data($id) {
		//
		$this->db->where('ID', $id);
		$result = $this->db->delete_eon_ora($this->tbl);
		//log_message('info', "kkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkk : " . $result);
		return $result;
	}
	//-----------------------------------------------------
 
}

/* End of file _model.php */