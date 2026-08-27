<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class privileges_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function get_grup_users() {	
		$sql = "select id, nama, locked, kode from SEC_GROUPS order by id";				
		$query = $this->db->query($sql);
		if($query->num_rows()!==0){return $query->result();}
		else{return FALSE;}
	}

	function get_select_menu_utama($app_id) {

		if (empty($app_id)){$app_id = "0";}		
		$sql = "select 0 as ROOT_ID, 'Pilih Menu Utama' as NAMA FROM DUAL union all
		select ROOT_ID, NAMA from V_SEC_MODULES_PATH where PATH_LEVEL=1 and APP_ID={$app_id}";
		$query = $this->db->query($sql);
		if($query->num_rows()!==0){return $query->result();}
		else{return FALSE;}
	}
 
	function get_by_app($app_id, $grp_id, $tp_modul, $root_id) {

		$filter = " ";
		if (!empty($tp_modul)){
			$filter .= " and m.tp_modul=UPPER('{$tp_modul}') ";
		}

		if (empty($app_id)){$app_id = "0";}
		if (empty($grp_id)){$grp_id = "0";}

		if (!empty($root_id)){
			$filter .= " and m.root_id={$root_id} ";
		}
		
		$sql = "select z1.*
		from (
		select a.id app_id, a.nama app_nm, m.id as module_id, m.kode, m.nama as module_nm, gm.group_id, 
		gm.reads, gm.inserts, gm.writes, gm.deletes, m.NAMA_MENU, m.PATH_MENU, m.path_level, m.root_id
		from V_SEC_MODULES_PATH m 
		inner join SEC_APPS a on a.id=m.app_id
		inner join SEC_GROUP_MODULES gm on gm.module_id=m.id 
		where a.id=".$app_id." and gm.group_id=".$grp_id.$filter." 
		union all
		select a.id app_id, a.nama app_nm, m.id as module_id, m.kode, m.nama as modulenm, 
		".$grp_id.", null, null, null, null, m.NAMA_MENU, m.PATH_MENU, m.path_level, m.root_id
		from V_SEC_MODULES_PATH m 
		inner join SEC_APPS a on a.id=m.app_id
		where a.id=".$app_id.$filter." 
		and m.id not in (select module_id from SEC_GROUP_MODULES where group_id=".$grp_id.")
		) z1 order by root_id, path_level, module_id ";

		// var_dump($sql);die;
		//log_message('info', "BBBBBBBBBBBBBBBBBBBBBBBBBBBBBB : ".$sql);
		$query = $this->db->query($sql);
		if($query->num_rows()!==0){return $query->result();}
		else{return FALSE;}
	}
		
	function get_by_app_btn($app_id, $grp_id,$modul_id) {

		if($app_id == ''){$app_id = '0';}
		if($grp_id == ''){$grp_id = '0';}
		if($modul_id == ''){$modul_id = '0';}
		// button yg sdh di alokasi
		$sql  = " select app_id, group_id, module_id, modul_btn_id, kode_btn, btn_no, buttons, nama_btn 
		from (
		select app.id as app_id,  b2.group_id, mdl.id as module_id,
		btn.id as modul_btn_id, btn.kode_btn, btn.btn_no, btn.nama_btn, b2.flg_button as buttons
		from SEC_MODULES mdl
		join SEC_APPS app on app.id=mdl.app_id
		join SEC_MODULES_BTN btn on btn.module_id=mdl.id
		join SEC_GROUP_ROLES_BTN b2 on b2.modules_btn_id=btn.id and b2.modules_id=mdl.id
		where app.id=".$app_id." and b2.group_id=".$grp_id." and b2.modules_id=".$modul_id."
		union
		select app.id as app_id, ".$grp_id." as group_id, mdl.id as module_id,
		btn.id as modul_btn_id, btn.kode_btn, btn.btn_no, btn.nama_btn, null as buttons
		from SEC_MODULES mdl
		join SEC_MODULES_BTN btn on btn.module_id=mdl.id
		join SEC_APPS app on app.id=mdl.app_id
		where app.id=".$app_id." and mdl.id=".$modul_id."and btn.id not in (select d1.modules_btn_id
		from SEC_GROUP_ROLES_BTN d1 where d1.group_id=".$grp_id." and d1.modules_id=mdl.id and d1.modules_btn_id=btn.id)
		) z1 order by btn_no ";
		// var_dump($sql);die;
//log_message('info', "CCCCCCCCCCCCCCCCCCCCCCCCCC : ".$sql);
		$query = $this->db->query($sql);
 		return $query->result();
	}
		
	function upd_auth($a,$b,$c,$d){

		$c = strtoupper($c); 
		//log_message('info', "555555555555555555555555555555555555555VVVVVVVVV 5");
		$group = $this->db->query("select count(group_id) as jml 
		from SEC_GROUP_MODULES where group_id=$a and module_id=$b")->row();
		
		if($group->JML > 0) {
			$this->db->where('GROUP_ID', $a);
			$this->db->where('MODULE_ID', $b);
			$this->db->update('SEC_GROUP_MODULES',array($c=>$d));
		} else {
			$this->db->insert('SEC_GROUP_MODULES',array('GROUP_ID'=>$a, 'MODULE_ID'=>$b, $c=>$d));
		}
		//log_message('info', "66666666666666666666666666666666666 5");
	}
	
	function upd_auth_role_btn($group_id,$modules_id,$modules_btn_id,$flg) {

		if($group_id == ''){$group_id = '0';}
		if($modules_id == ''){$modules_id = '0';}
		if($modules_btn_id == ''){$modules_btn_id = '0';}

		if($group_id == '0' || $modules_id == '0' || $modules_btn_id == '0'){
			// nothing to do
		}
		else {
		$role_btn = $this->db->query("select count(modules_btn_id) as jml 
		from SEC_GROUP_ROLES_BTN where group_id=$group_id and modules_id=$modules_id and modules_btn_id=$modules_btn_id")->row();

			if($role_btn->JML > 0) {
				$this->db->where('GROUP_ID', $group_id);
				$this->db->where('MODULES_ID', $modules_id);
				$this->db->where('MODULES_BTN_ID', $modules_btn_id);
				$this->db->update('SEC_GROUP_ROLES_BTN',array('FLG_BUTTON'=>$flg));
			} else {
				$this->db->insert('SEC_GROUP_ROLES_BTN',array('GROUP_ID'=>$group_id, 'MODULES_ID'=>$modules_id,
					'MODULES_BTN_ID'=>$modules_btn_id, 'FLG_BUTTON'=>$flg));
			}
		}
	}

	function tambah_btn_detil($a,$b,$c,$d){	 
		$this->db->insert('SEC_MODULES_BTN',array('NAMA_BTN'=>$a, 'KODE_BTN'=>$b, 'MODULE_ID'=>$c, 'BTN_NO'=>$d));
	}

	function delete_btn_detil($modules_btn_id){	 

		$this->db->where('ID', $modules_btn_id);
		$this->db->delete('SEC_MODULES_BTN');
 
	}
}

/* End of file _model.php */