<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class login_model extends CI_Model
{
    private $modul_apps_kd = SEC_APPS_KD;

    function __construct()
    {
        parent::__construct();
    }
    
    function check_user($uid) 
    {
        $qry  = "select u.id userid, u.nama username, u.nip, u.passwd, u.userid as userlogin
        from SEC_USERS u 
        where u.userid='$uid' and disabled != 1 and rownum <=1 ";
        $rows = $this->db->query($qry);
        if ($rows->num_rows() > 0) {
            return $rows->row();
        } else {
            return FALSE;
        }
    }
    
    function check_group($uid)
    {
        $qry = "select g.*
        from SEC_GROUPS g inner join SEC_USER_GROUPS ug on g.id=ug.group_id
        where ug.user_id='$uid' and rownum <=1
        order by g.id "; // dioreder berd id (id pertama seharusnya [harus] Sys Admin)
        
        $rows = $this->db->query($qry);
        if ($rows->num_rows() > 0) {
            return $rows->row();
        } else {
            return FALSE;
        }
    }

    function check_user_app()
    {
        //20140418 -- tambal disini aja dah, jadi kalo ada user sbg admin tapi sbg user biasa jg 
        if(is_super_admin()) return false;
        
        $uid  = lda_user_id();
        $mid  = lda_app_id(); 
        $modul_apps = $this->modul_apps_kd;

        if($mid <> ''){$mid = ' and m.app_id=' . $mid ;}

        $qry  = "select distinct a1.id app_id, a1.app_path, g.id as group_id, 
        g.kode as group_kode, g.nama as group_nama, a1.nama as app_nama
        from SEC_USER_GROUPS ug 
        join SEC_GROUPS g on g.id=ug.group_id 
        join SEC_GROUP_MODULES gm on g.id=gm.group_id
        join SEC_MODULES m on gm.module_id=m.id
        join SEC_APPS a1 on m.app_id=a1.id
        where ug.user_id={$uid} {$mid} and (gm.reads=1 or gm.writes=1 or gm.deletes=1 or gm.inserts=1)
        and a1.APP_PATH in {$modul_apps}
        order by a1.APP_PATH";
        //log_message('info', " 333333333333333333333333333 check_user_app MODULE : " .$qry);
        $rows = $this->db->query($qry);
        if ($rows->num_rows() > 0) {
            //20140120 -- biar nanti bisa pilih module kalo usernya ada di lebih dari 1 module
            $ret = new stdClass();
            $ret = $rows->row();
            $ret->modcnt = $rows->num_rows();
            return $ret;            
        } 
        else {return FALSE;}
    }
     
    function get_module($app_id){

        $modul_apps = $this->modul_apps_kd;
        $qry = "select a1.* from SEC_APPS a1 where a1.id=$app_id and a1.APP_PATH in {$modul_apps} and rownum <= 1";
        $rows = $this->db->query($qry);
        if ($rows->num_rows() > 0) {return $rows->row();} 
        else {return FALSE;}
    }  

    function aktif_tahun($app_id)
    {
        $qry = "select * 
        from SEC_APPS a1
        inner join pst_app_status s on a1.id=s.app_id
        where s.step != 'closing' and a1.id=$app_id and rownum <=1
        order by a1.id, s.tahun";
        
        $rows = $this->db->query($qry);
        if ($rows->num_rows() > 0) {
            return $rows->row();
        } else {
            return FALSE;
        }
    }
    
    function inaktif_tahun($app_id)
    {
        $qry = "select max(tahun) as tahun, step
        from SEC_APPS a1
        inner pst_join app_status s on a1.id=s.app_id
        where s.step='closing' and a1.id=$app_id and rownum <=1
        group by s.step ";
        
        $rows = $this->db->query($qry);
        if ($rows->num_rows() > 0) {
            return $rows->row();
        } else {
            return FALSE;
        }
    }
    
    function get_appid($m)
    {   
        $modul_apps = $this->modul_apps_kd;
        $qry  = "select a1.id as app_id,  a1.nama as app_nama, a1.app_path
        from SEC_APPS a1 where a1.app_path='$m' and a1.APP_PATH in {$modul_apps} and rownum <=1";
        $rows = $this->db->query($qry);
        if ($rows->num_rows() > 0) {return $rows->row();} 
        else {return FALSE;}
    }

}
