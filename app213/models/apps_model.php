<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class apps_model extends CI_Model
{

	private $tbl           = 'SEC_APPS';
	private $modul_apps_kd = SEC_APPS_KD;

	function __construct()
	{
		parent::__construct();
	}

	function get_all()
	{
		$sql = "select * from SEC_APPS order by APP_PATH";

		$query = $this->db->query($sql);
		if ($query->num_rows() !== 0) {
			return $query->result();
		} else
			return FALSE;
	}

	function get_active_only()
	{
		/*
        if (!$this->session->userdata('login')) {
            $this->session->set_flashdata('msg_warning', 'Session telah kadaluarsa, silahkan login ulang.');
            redirect('login');
            exit;
        }
		*/
		$user_id    = lda_user_id();
		$modul_apps = $this->modul_apps_kd;

		$sql = "select distinct a1.*
		from SEC_USER_GROUPS ug 
		join SEC_GROUPS g on g.id=ug.group_id 
		join SEC_GROUP_MODULES gm on g.id=gm.group_id
		join SEC_MODULES m on gm.module_id=m.id
		join SEC_APPS a1 on m.app_id=a1.id  
		where ug.user_id={$user_id} and (gm.reads=1 or gm.writes=1 or gm.deletes=1 or gm.inserts=1)
		and a1.disabled != 1 AND a1.APP_PATH in {$modul_apps}
		order by a1.APP_PATH";

		if (is_super_admin()) {
			$sql = "select * from SEC_APPS a1 where disabled != 1 AND a1.APP_PATH in{$modul_apps} order by id";
		}

		$query = $this->db->query($sql);
		if ($query->num_rows() !== 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}

	function get($id)
	{
		$this->db->where('ID', $id);
		$query = $this->db->get($this->tbl);
		if ($query->num_rows() !== 0) {
			return $query->row();
		} else
			return FALSE;
	}

	//-- admin
	function save($data)
	{
		$this->db->insert($this->tbl, $data);
		//return $this->db->insert_id();
	}

	function update($id, $data)
	{
		$this->db->where('ID', $id);
		$this->db->update($this->tbl, $data);
	}

	function delete($id)
	{
		$this->db->where('ID', $id);
		$this->db->delete($this->tbl);
	}

	function create_modules_menu($app_id, $kode, $nama, $no_urut = "0")
	{
		//$app_id = ipad_app_id();
		$qry = " begin 
		insert into SEC_MODULES(app_id, kode, nama, tp_modul,no_urut)
        select {$app_id} as app_id, trim('{$kode}') as kode, trim('{$nama}') as nama, 'M' as tp_modul, {$no_urut} as no_urut
		from dual 
		where not exists(select 1 from SEC_MODULES 
		where app_id={$app_id} and (lower(kode) = lower(trim('{$kode}')) or lower(nama) = lower(trim('{$nama}'))) );
		commit; end;";
		// echo $qry;
		//$query = $this->db->query($qry);
		$query = $this->db->simple_query($qry);
	}

	function create_modules_menu_sub($app_id, $kode, $nama, $kd_hdr = "", $no_urut = "0")
	{
		//$app_id = ipad_app_id();
		if (empty($kd_hdr)) {
			$kd_hdr = "0";
		}
		// 
		$qry = " begin 
		insert into SEC_MODULES(app_id, kode, nama, tp_modul, parent_kd, doch_id, no_urut)
        select {$app_id} as app_id, trim('{$kode}') as kode, trim('{$nama}') as nama,
        'S' as tp_modul, trim('{$kd_hdr}') as parent_kd,
        nvl((select id from SEC_MODULES where tp_modul in ('M','S') and kode=trim('{$kd_hdr}') and app_id={$app_id}),0) as doch_id,
        {$no_urut} as no_urut
		from dual 
		where not exists(select 1 from SEC_MODULES 
		where app_id={$app_id} and (lower(kode) = lower(trim('{$kode}')) or lower(nama) = lower(trim('{$nama}'))) );
		commit; end;";
		//log_message('info', "BBBBBBBBBBBBBBBB create_modules_menu_sub : ".$qry);
		$query = $this->db->simple_query($qry);
	}

	function create_modules($app_id, $kode, $nama, $kd_hdr = "", $no_urut = "0")
	{
		//$app_id = ipad_app_id();
		if (empty($kd_hdr)) {
			$kd_hdr = "0";
		}
		//nvl((select id from SEC_MODULES where tp_modul in ('M','S') and kode='{$kd_hdr}' and app_id={$app_id}),0) as doch_id,
		$qry = " begin
		insert into SEC_MODULES(app_id, kode, nama, tp_modul, parent_kd, doch_id,no_urut)
        select {$app_id} as app_id, trim('{$kode}') as kode, trim('{$nama}') as nama,
        'T' as tp_modul, '{$kd_hdr}' as parent_kd,
        nvl((select id from SEC_MODULES where tp_modul in ('M','S') and kode='{$kd_hdr}' and app_id={$app_id}),0) as doch_id,
        {$no_urut} as no_urut
		from dual 
		where not exists(select 1 from SEC_MODULES 
		where app_id={$app_id} and (lower(kode) = lower(trim('{$kode}')) or lower(nama) = lower(trim('{$nama}'))) );
		commit; end;";
		// log_message('info', "CCCCCCCCCCCCCC create_modules : ".$qry);
		$query = $this->db->simple_query($qry);
	}

	function create_modules_btn($app_id, $kd_mod, $kd_btn, $nm_btn, $no_btn)
	{
		//$app_id = ipad_app_id();
		$qry = " begin
		insert into SEC_MODULES_BTN(nama_btn, module_id, kode_btn, btn_no)
        select trim('{$nm_btn}') as nama_btn, md.id as module_id, trim('{$kd_btn}') as kode_btn, {$no_btn} as btn_no
		from SEC_MODULES md
		where rownum<=1 and md.app_id={$app_id} and md.kode='{$kd_mod}' 
		and not exists(select 1 from SEC_MODULES_btn btn 
		where btn.module_id=md.id
		and (lower(btn.nama_btn) = lower(trim('{$nm_btn}')) or btn.btn_no = {$no_btn} or lower(btn.kode_btn) = lower(trim('{$kd_btn}'))  ) );
		commit; end;";
		//log_message('info', "5555555555555555555555555555555555555555 : " . $qry);
		//$query = $this->db->query($qry);
		$query = $this->db->simple_query($qry);
	}

	function get_app_role_tran_01($kd_tran)
	{

		$userid = lda_user_id();
		$app_id = lda_app_id();
		//
		$is_super_admin = is_super_admin();  // groupname = Sys Admin
		$is_admin       = is_admin();        // groupname = Administrator
		if (empty($kd_tran)) {
			$kd_tran = ' ';
		}
		//
		if (is_super_admin() == true) {

			$qry  = " select mo.kode as kdmenu_tran   
			from SEC_GROUPS gr 
			join SEC_USER_GROUPS ug on ug.group_id=gr.id  
			join SEC_USERS us on us.id=ug.user_id 
			join SEC_MODULES mo on nvl(mo.tp_modul,'T')='T'
			where gr.kode='sa' and us.id={$userid}  and mo.app_id={$app_id} 
			and mo.kode='{$kd_tran}'  ";
		} else {

			$qry  = " select mo.kode as kdmenu_tran
			from SEC_MODULES mo
			join SEC_GROUP_modules gm on gm.module_id=mo.id
			join SEC_GROUPs gr on gr.id=gm.group_id
			join SEC_USER_GROUPS ug on ug.group_id=gr.id
			join SEC_USERS us on us.id=ug.user_id
			where gm.reads=1 and nvl(mo.tp_modul,'T')='T'
			and mo.app_id={$app_id} and us.id={$userid} 
 			and mo.kode='{$kd_tran}' and rownum<=1 ";
		}
		//log_message('info', "xxxxxxxxxxxxxxxxxxxxxxxx : " . $qry);
		$query = $this->db->query($qry);
		if ($query->num_rows() !== 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function get_app_role_menu_01($kd_menu)
	{

		$userid = lda_user_id();
		$app_id = lda_app_id();
		$is_super_admin = is_super_admin();  // groupname = Sys Admin
		$is_admin       = is_admin();        // groupname = Administrator
		if (empty($kd_menu)) {
			$kd_menu = ' ';
		}
		//
		if (is_super_admin() == true) {

			$qry  = " select mo.kode as kdmenu_utama   
			from SEC_GROUPs gr 
			join SEC_USER_GROUPS ug on ug.group_id=gr.id  
			join SEC_USERS us on us.id=ug.user_id 
			join SEC_MODULES mo on nvl(mo.tp_modul,'T') in ('M','S')
			where gr.kode='sa' and us.id={$userid}  and mo.app_id={$app_id} 
			and mo.kode='{$kd_menu}' ";
		} else {
			$qry  = " select mo.kode as kdmenu_utama
			from SEC_MODULES mo
			join SEC_GROUP_modules gm on gm.module_id=mo.id
			join SEC_GROUPs gr on gr.id=gm.group_id
			join SEC_USER_GROUPS ug on ug.group_id=gr.id
			join SEC_USERS us on us.id=ug.user_id
			where gm.reads=1 and nvl(mo.tp_modul,'T') in ('M','S')
			and mo.app_id={$app_id} and us.id={$userid} 
	 		and mo.kode='{$kd_menu}' and rownum<=1 ";
		}
		//log_message('info', "zzzzzzzzzzzzzzzzzzzzzzzzzz : " . $qry);
		$query = $this->db->query($qry);
		if ($query->num_rows() !== 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file _model.php */