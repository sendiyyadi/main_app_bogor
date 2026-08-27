<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class user_pbb_model extends CI_Model {

	private $tbl = 'SEC_USERS';
	private $schema_pbb = SCHEMA_PBB.".";
	
	function __construct() {
		parent::__construct();
	}
		
	function get_all()
	{	
		$schema_pbb = $this->schema_pbb;
		$sql = "select u.*
				from SEC_USERS u
				order by u.disabled desc, u.nama";
				
		$query = $this->db->query($sql);
		if($query->num_rows()!==0)
		{
			return $query->result();
		}
		else
			return FALSE;
	}

	function get_users_pospbb() {	

		$schema_pbb = $this->schema_pbb;
        $userlogin = lda_user_login();
        $isgrup_admin = $this->load->model('user_pbb_model')->get_isgrup_admin($userlogin);
        //var_dump($isgrup_admin);die;
        // cek jika bukan grup admin
        if($isgrup_admin == FALSE) {
	        $sql = "select us.id, us.nama
	        FROM SEC_USERS us
	        JOIN V_USER_PBB up on up.userid=us.userid
	        where up.KD_KANWIL is not null and up.KD_KANTOR is not null 
            and up.KD_TP is not null and up.USERID='".$userlogin."'";
        }
        else{
			$sql = " select id, nama from (
			select -99999 as id, 'Semua User' as nama from dual union all
			select -88888 as id, 'User H2H' as nama from dual union all
			select -77777 as id, 'User POSPBB' as nama from dual union all
			select * from (
			select u.id, u.nama as nama 
			from SEC_USERS u	
			order by u.userid) z1
			) z2";
        }
        //      
		$query = $this->db->query($sql);
		if($query->num_rows()!==0) {return $query->result();}
		else{return FALSE;}		
	}

	function get($id)
	{
		$schema_pbb = $this->schema_pbb;
		$this->db->where('ID',$id);
		$query = $this->db->get($this->tbl);
		if($query->num_rows()!==0)
		{
			return $query->row();
		}
		else
			return FALSE;
	}

	function get_users_by_id($id){

		$schema_pbb = $this->schema_pbb;
		if(empty($id)){$id = '0';}
		$sql = "SELECT US.USERID, US.NAMA, US.ID, US.NIP, 
		UP.KD_KANTOR, UP.KD_KANWIL, UP.KD_TP, UP.KD_KANWIL_BANK,
		UP.KD_BANK_TUNGGAL, UP.KD_BANK_PERSEPSI, TP.NM_TP
		FROM SEC_USERS US
		LEFT JOIN V_USER_PBB UP ON UP.USERID=US.USERID
		LEFT JOIN S_TEMPAT_PEMBAYARAN TP ON TP.KD_KANWIL=UP.KD_KANWIL 
		AND TP.KD_KANTOR=UP.KD_KANTOR AND TP.KD_TP=UP.KD_TP
		WHERE US.ID='{$id}' ";
		$query = $this->db->query($sql);
		if($query->num_rows()!==0){	return $query->row();}
		else{return FALSE;}
	}

	function get_users_by_userid($userlogin){

		$schema_pbb = $this->schema_pbb;
		if(empty($userlogin)){$userlogin = ' ';}
		$sql = "SELECT US.USERID, US.NAMA, US.ID, US.NIP,
		UP.KD_KANTOR, UP.KD_KANWIL, UP.KD_TP, UP.KD_KANWIL_BANK,
		UP.KD_BANK_TUNGGAL, UP.KD_BANK_PERSEPSI, TP.NM_TP
		FROM SEC_USERS US
		LEFT JOIN V_USER_PBB UP ON UP.USERID=US.USERID
		LEFT JOIN S_TEMPAT_PEMBAYARAN TP ON TP.KD_KANWIL=UP.KD_KANWIL 
		AND TP.KD_KANTOR=UP.KD_KANTOR AND TP.KD_TP=UP.KD_TP		
		WHERE US.USERID='{$userlogin}' ";
		$query = $this->db->query($sql);
		if($query->num_rows()!==0){	return $query->row();}
		else{return FALSE;}
	}

	function get_isgrup_admin($userlogin){

		$schema_pbb = $this->schema_pbb;
		// cek grup admin pos pbb 
		if(empty($userlogin)){$userlogin = ' ';}
		$sql = "SELECT SG.KODE,SG.NAMA AS NM_GRUP
		FROM SEC_GROUPS SG
		JOIN SEC_USER_GROUPS SUG ON SUG.GROUP_ID=SG.ID
		JOIN SEC_USERS SU ON SU.ID=SUG.USER_ID
		WHERE SG.KODE='pbbm' AND SU.USERID='{$userlogin}' ";
		//var_dump($sql);die;
		$query = $this->db->query($sql);
		if($query->num_rows()!==0){	return TRUE;}
		else{return FALSE;}
	}

}

/* End of file _model.php */