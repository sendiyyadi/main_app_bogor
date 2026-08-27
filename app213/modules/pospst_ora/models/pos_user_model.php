<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class pos_user_model extends CI_Model
{
    private $tbl = 'USER_PBB';
    private $schema_pbb = SCHEMA_PBB . ".";

    function __construct()
    {
        parent::__construct();
    }

    function get_all_pos_user()
    {
        // arig
        $schema_pbb = $this->schema_pbb;
        $kolom = pos_kolom("tp");
        $join  = pos_join("up", "tp");
        // 
        $sql = "SELECT US.ID, US.USERID, US.NAMA, US.NIP,PG.NM_PEGAWAI, US.JABATAN, TP.NM_TP, TP.ALAMAT_TP
        from SEC_USERS US
        left join V_USER_PBB up on UP.USERID=US.USERID
        LEFT JOIN S_PEGAWAI PG ON RTRIM(PG.NIP)=RTRIM(US.NIP)
        left join S_TEMPAT_PEMBAYARAN tp on {$join}
        order by US.NAMA";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function get_all()
    {
        // ini orinya arig
        $schema_pbb = $this->schema_pbb;
        $kolom = pos_kolom("tp");
        $join  = pos_join("up", "tp");
        //
        $sql = "select u.*,{$kolom} , tp.NM_TP
        from SEC_USERS as u
        inner join V_USER_PBB up on up.user_id=u.id
        inner join S_TEMPAT_PEMBAYARAN tp on {$join}
        order by .nama";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
            return $query->result();
        else
            return false;
    }

    function get_user_pbb($id)
    {

        $schema_pbb = $this->schema_pbb;
        $kolom = pos_kolom("tp");
        $join  = pos_join("up", "tp");

        $sql = "select US.ID, US.USERID, US.NAMA, US.NIP, US.JABATAN, 
        (tp.KD_KANWIL||tp.KD_KANTOR||tp.KD_TP) as GRP_TP, tp.NM_TP
        from SEC_USERS us
        left join V_USER_PBB up on up.USERID=us.USERID
        left join S_TEMPAT_PEMBAYARAN tp on {$join}
        where us.id={$id} ";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    function get_exists_user_pbb($usrlgn)
    {

        $schema_pbb = $this->schema_pbb;
        $sql = "select up.USERID from V_USER_PBB up where up.USERID='{$usrlgn}' ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    //-- admin
    function save($data)
    {

        $this->db->insert($this->tbl, $data);
        //if($this->db->trans_status())
        //    return $this->db->insert_id();
        //else
        //return false;
    }

    function update($userid, $data)
    {

        $this->db->where('USERID', $userid);
        $this->db->update($this->tbl, $data);
    }

    function delete($id)
    {

        $this->db->where('ID', $id);
        $this->db->delete($this->tbl);
        /*            
        if($this->db->trans_status())
            return true;
        else
            return false;
        */
    }

    function get_nm_user_rekam_pospbb($user_id)
    {
        //      
        $schema_pbb = $this->schema_pbb;
        $sql = "select us.id, us.nama, UP.KD_TP, TP.NM_TP
        FROM SEC_USERS us
        LEFT JOIN V_USER_PBB up on up.userid=us.userid
        LEFT JOIN S_TEMPAT_PEMBAYARAN TP ON TP.KD_KANWIL=UP.KD_KANWIL 
        AND TP.KD_KANTOR=UP.KD_KANTOR AND TP.KD_TP=UP.KD_TP        
        where us.id={$user_id} ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->row()->NAMA;
        } else {
            return "TIDAK TERDAFTAR";
        }
    }

    function get_select_tp_users()
    {

        $schema_pbb = $this->schema_pbb;
        $filter = ' ';
        $userlogin = lda_user_login();
        $isgrup_admin = $this->load->model('user_pbb_model')->get_isgrup_admin($userlogin);

        // cek jika bukan grup admin
        if ($isgrup_admin == FALSE) {
            $filter = "and up.KD_KANWIL is not null and up.KD_KANTOR is not null 
            and up.KD_TP is not null and up.USERID='" . $userlogin . "'";
        }
        //      
        $sql = "select us.id, us.nama
        FROM SEC_USERS us
        LEFT JOIN V_USER_PBB up on up.userid=us.userid
        where 1=1 {$filter}
        order by us.nama";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function get_tp_user()
    {

        $schema_pbb = $this->schema_pbb;
        $filter = '';
        $sql = "SELECT up.* FROM V_USER_PBB up WHERE UP.USERID='" . lda_user_login() . "'";
        $row = $this->db->query($sql);

        if ($row->num_rows() > 0) {

            $result = $row->row();
            if (DEF_POS_TYPE == 1) {
                $filter .= "up.KD_KANWIL='{$result->KD_KANWIL}' and ";
                $filter .= "up.KD_KANTOR='{$result->KD_KANTOR}' and ";
                $filter .= "up.KD_TP='{$result->KD_TP}' ";
            } else {
                $filter .= "up.KD_BANK_TUNGGAL='{$result->KD_BANK_TUNGGAL}' and ";
                $filter .= "up.KD_BANK_PERSEPSI='{$result->KD_BANK_PERSEPSI}' and ";
                $filter .= "up.KD_KANWIL='{$result->KD_KANWIL}' and ";
                $filter .= "up.KD_KANTOR='{$result->KD_KANTOR}' and ";
                $filter .= "up.KD_TP='{$result->KD_TP}' ";
            }
            //		
            $sql = "select us.id, us.nama
			from SEC_USERS us
			join V_USER_PBB up on up.userid=us.userid
			where         
			{$filter}
			order by us.nama";
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                return $query->result_array();
            } else {
                return false;
            }
        }
        return false;
    }

    function set_user()
    {
        $schema_pbb = $this->schema_pbb;
        $userlogin = lda_user_login();
        $userbank = '';
        //
        $qry = "SELECT UP.KD_KANTOR, UP.KD_KANWIL, UP.KD_TP, SU.NIP,
        TP.NM_TP, TP.ALAMAT_TP, TP.NO_REK_TP, NVL(TP.KD_TP,'0') AS FLG_TP
        FROM V_USER_PBB UP
        JOIN SEC_USERS SU ON SU.USERID=UP.USERID
        LEFT JOIN S_TEMPAT_PEMBAYARAN TP ON TP.KD_KANWIL=UP.KD_KANWIL
        AND TP.KD_KANTOR=UP.KD_KANTOR AND TP.KD_TP=UP.KD_TP
        WHERE coalesce(UP.DISABLED,0) = 0 AND UP.USERID='{$userlogin}'";
        //
        if ($row = $this->db->query($qry)->row()) {

            $this->session->set_userdata('kd_kanwil', $row->KD_KANWIL);
            $this->session->set_userdata('kd_kantor', $row->KD_KANTOR);
            $this->session->set_userdata('kd_tp', $row->KD_TP);
            $this->session->set_userdata('nip', $row->NIP);

            //log_message('info', "ssssssssssssssssssssssss  dt_rekap_bln : ". $where);
            $this->session->set_userdata('tpnm', $row->NM_TP);
            $this->session->set_userdata('tpkd', $userbank);

            /*
                $this->session->set_userdata('kd_bank_tunggal', $result->KD_BANK_TUNGGAL);
                $this->session->set_userdata('kd_bank_persepsi', $result->KD_BANK_PERSEPSI);
                $this->session->set_userdata('kd_kanwil', $result->KD_KANWIL);
                $this->session->set_userdata('kd_kantor', $result->KD_KANTOR);
                $this->session->set_userdata('kd_tp', $result->KD_TP);
            */
            if ($row->FLG_TP == '0') {
                return false;
            } else {
                return true;
            }
        } else {

            $this->session->set_userdata('kd_kanwil', '');
            $this->session->set_userdata('kd_kantor', '');
            $this->session->set_userdata('kd_tp', '');
            $this->session->set_userdata('tpnm', '');
            $this->session->set_userdata('tpkd', '');
            $this->session->set_userdata('nip', '');

            return false;
        }
    }

    function encript_value($val_user, $val_pwd)
    {
        $schema_pbb = $this->schema_pbb;
        $qry =     "select fn_keylock('{$val_user}','{$val_pwd}') as FN_KEYLOCK from dual";
        $query = $this->db->query($qry);
        return $query->row();
    }
}

/* End of file _model.php */
