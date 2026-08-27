<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class update_reg_model extends CI_Model
{
    private $tbl = 'REG_ESPPT_TEMP';
    private $tbl_reg_sppt = 'REG_ESPPT';
    private $tbl_user = 'SEC_USERS';
    private $tbl_user_group = 'SEC_USER_GROUPS';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all()
    {
        $sql = "SELECT * FROM REG_ESPPTDB ";
        $query = $this->db->query($sql);
        if ($query->num_rows()!==0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function get($rowid)
    {
        $qry = "SELECT ROWIDTOCHAR(ROWID) AS ID, REG_ESPPTDB.*,
                                KD_PROPINSI1||'.'||KD_DATI21||'-'||KD_KECAMATAN1||'.'||KD_KELURAHAN1||'-'||KD_BLOK1||'.'||NO_URUT1||'.'||KD_JNS_OP1 AS NOP_TTG_1,
                                KD_PROPINSI2||'.'||KD_DATI22||'-'||KD_KECAMATAN2||'.'||KD_KELURAHAN2||'-'||KD_BLOK2||'.'||NO_URUT2||'.'||KD_JNS_OP2 AS NOP_TTG_2
                                FROM REG_ESPPTDB
                                WHERE ROWID = '{$rowid}' ";
        //log_message('info', "KKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK  ". $qry);
        $query = $this->db->query($qry);
        if ($query->num_rows()!==0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function get_by_nik($nik)
    {
        $qry = "SELECT ROWIDTOCHAR(TM.ROWID) AS ID, TM.*, KEC.NM_KECAMATAN, KEL.NM_KELURAHAN, 
                                TM.KD_PROPINSI||'.'||TM.KD_DATI2||'-'||TM.KD_KECAMATAN||'.'||TM.KD_KELURAHAN||'-'||TM.KD_BLOK||'.'||TM.NO_URUT||'.'||TM.KD_JNS_OP AS NOP_LKP
                                FROM REG_ESPPT_TEMP TM
                LEFT JOIN REF_KECAMATAN KEC on TM.KD_KECAMATAN = KEC.KD_KECAMATAN
                LEFT JOIN REF_KELURAHAN KEL on TM.KD_KECAMATAN = KEL.KD_KECAMATAN and TM.KD_KELURAHAN = KEL.KD_KELURAHAN
                                WHERE NIK = '{$nik}' ";
        //log_message('info', "KKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK  ". $qry);
        $query = $this->db->query($qry);
        if ($query->num_rows()!==0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function get_by_nik_sts($nik, $sts, $crea_date = null)
    {
        //TO_CHAR(CREATED_DATE, 'YYYYMMDDHH24MISSFF') AS CREA
        $qry = "SELECT ROWIDTOCHAR(TM.ROWID) AS ID, TM.*, KEC.NM_KECAMATAN, KEL.NM_KELURAHAN, 
                                TM.KD_PROPINSI||'.'||TM.KD_DATI2||'-'||TM.KD_KECAMATAN||'.'||TM.KD_KELURAHAN||'-'||TM.KD_BLOK||'.'||TM.NO_URUT||'.'||TM.KD_JNS_OP AS NOP_LKP, TO_CHAR(TM.CREATED_DATE, 'YYYYMMDDHH24MISSFF') AS CREA_DATE,fn_keyopen(SS.USERID, SS.PASSWD) AS PD, SS.PASSWD AS PWD          
                                FROM REG_ESPPT_TEMP TM
                LEFT JOIN REF_KECAMATAN KEC on TM.KD_KECAMATAN = KEC.KD_KECAMATAN
                LEFT JOIN REF_KELURAHAN KEL on TM.KD_KECAMATAN = KEL.KD_KECAMATAN and TM.KD_KELURAHAN = KEL.KD_KELURAHAN
                LEFT JOIN SEC_USERS SS ON TM.NIK=SS.USERID
                                WHERE TM.NIK = '{$nik}' AND TM.STATUS_VERIF= '{$sts}' AND TO_CHAR(TM.CREATED_DATE, 'YYYYMMDDHH24MISSFF')='$crea_date'";
        // $qq = "select * from sec_users";
        //log_message('info', "KKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK  ". $qry);
        $query = $this->db->query($qry);
        // var_dump($query);die;
        if ($query->num_rows()!==0) {
            return $query->row();
        } else {
            return false;
        }
    }

    function encript_value($login, $value){
        $qry   = "SELECT FN_KEYLOCK('{$login}','{$value}') as FN_KEYLOCK from DUAL";
        $query = $this->db->query($qry);
        return $query->row();
    }

    function cek_tolak_data($nik){
        $qq = "SELECT COUNT(*) AS CTR
                FROM REG_ESPPT_TEMP
                WHERE NIK = '{$nik}' AND STATUS_VERIF=2";
        $xx = $this->db->query($qq)->row()->CTR;
        return $xx;
    }

    public function get_by_rowid($rowid)
    {
        $qry = "SELECT ROWIDTOCHAR(TM.ROWID) AS ID, TM.*, KEC.NM_KECAMATAN, KEL.NM_KELURAHAN, 
                                TM.KD_PROPINSI||'.'||TM.KD_DATI2||'-'||TM.KD_KECAMATAN||'.'||TM.KD_KELURAHAN||'-'||TM.KD_BLOK||'.'||TM.NO_URUT||'.'||TM.KD_JNS_OP AS NOP_LKP
                                FROM REG_ESPPT_TEMP TM
                LEFT JOIN REF_KECAMATAN KEC on TM.KD_KECAMATAN = KEC.KD_KECAMATAN
                LEFT JOIN REF_KELURAHAN KEL on TM.KD_KECAMATAN = KEL.KD_KECAMATAN and TM.KD_KELURAHAN = KEL.KD_KELURAHAN
                                WHERE ROWIDTOCHAR(TM.ROWID)='{$rowid}' ";
        //log_message('info', "KKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK  ". $qry);
        $query = $this->db->query($qry);
        if ($query->num_rows()!==0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function insert_data_reg_sppt_by_nik($nik)
    {
        $qry = "INSERT INTO REG_ESPPT (KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP,
                                       NIK, NM_WP_SPPT, JLN_WP_SPPT, BLOK_KAV_NO_WP_SPPT, RW_WP_SPPT, RT_WP_SPPT, 
                                       KELURAHAN_WP_SPPT, KOTA_WP_SPPT, KD_POS_WP_SPPT, NPWP_SPPT, 
                                       JLN_OP_SPPT, BLOK_KAV_NO_OP_SPPT, RW_OP_SPPT, RT_OP_SPPT,
                                       NM_WP_BAYAR, LOGINNAME, PASSWOD, NAMA, EMAIL, NOHP, NO_REG,
                                       USER_GROUP, STATUS, NIKNOP, THN_PAJAK_BAYAR, IM_KTP_BLOB, IM_SPPT_BLOB,IM_PBB_BLOB)
                SELECT KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP,
                       NIK, NM_WP_SPPT, COALESCE(JLN_WP_SPPT, '-'), COALESCE(BLOK_KAV_NO_WP_SPPT, '-'), COALESCE(RW_WP_SPPT, '00'), COALESCE(RT_WP_SPPT, '000'), 
                       COALESCE(KELURAHAN_WP_SPPT, '-'), COALESCE(KOTA_WP_SPPT, '-'), COALESCE(KD_POS_WP_SPPT, '-'), COALESCE(NPWP_SPPT, '-'), 
                       COALESCE(JLN_OP_SPPT, '-'), COALESCE(BLOK_KAV_NO_OP_SPPT, '-'), COALESCE(RW_OP_SPPT, '00'), COALESCE(RT_OP_SPPT, '000'),
                       COALESCE(NM_WP_BAYAR, '-'), LOGINNAME, PASSWOD, NAMA, EMAIL, NOHP, NO_REG,
                       USER_GROUP, STATUS_VERIF, NIKNOP, '-', IM_KTP_BLOB, IM_SPPT_BLOB, IM_PBB_BLOB
                FROM REG_ESPPT_TEMP
                WHERE NIK = '{$nik}' ";
        //log_message('info', "KKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK  ". $qry);
        $query = $this->db->query($qry);
        // return $result;
    }

    public function insert_data_reg_sppt_by_rowid($rowid)
    {
        $qry = "INSERT INTO REG_ESPPT (KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP,
                                       NIK, NM_WP_SPPT, JLN_WP_SPPT, BLOK_KAV_NO_WP_SPPT, RW_WP_SPPT, RT_WP_SPPT, 
                                       KELURAHAN_WP_SPPT, KOTA_WP_SPPT, KD_POS_WP_SPPT, NPWP_SPPT, 
                                       JLN_OP_SPPT, BLOK_KAV_NO_OP_SPPT, RW_OP_SPPT, RT_OP_SPPT,
                                       NM_WP_BAYAR, LOGINNAME, PASSWOD, NAMA, EMAIL, NOHP, NO_REG,
                                       USER_GROUP, STATUS, NIKNOP, THN_PAJAK_BAYAR, IM_KTP_BLOB, IM_SPPT_BLOB,IM_PBB_BLOB)
                SELECT KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP,
                       NIK, NM_WP_SPPT, COALESCE(JLN_WP_SPPT, '-'), COALESCE(BLOK_KAV_NO_WP_SPPT, '-'), COALESCE(RW_WP_SPPT, '00'), COALESCE(RT_WP_SPPT, '000'), 
                       COALESCE(KELURAHAN_WP_SPPT, '-'), COALESCE(KOTA_WP_SPPT, '-'), COALESCE(KD_POS_WP_SPPT, '-'), COALESCE(NPWP_SPPT, '-'), 
                       COALESCE(JLN_OP_SPPT, '-'), COALESCE(BLOK_KAV_NO_OP_SPPT, '-'), COALESCE(RW_OP_SPPT, '00'), COALESCE(RT_OP_SPPT, '000'),
                       COALESCE(NM_WP_BAYAR, '-'), LOGINNAME, PASSWOD, NAMA, EMAIL, NOHP, NO_REG,
                       USER_GROUP, STATUS_VERIF, NIKNOP, '-', IM_KTP_BLOB, IM_SPPT_BLOB, IM_PBB_BLOB
                FROM REG_ESPPT_TEMP
                WHERE ROWIDTOCHAR(ROWID)='{$rowid}' ";
        //log_message('info', "KKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK  ". $qry);
        $query = $this->db->query($qry);
        // return $result;
    }

    public function update_data_reg_esppttemp($rowid, $data)
    {
        $this->db->where('ROWID', $rowid);
        $result = $this->db->update_oen_ora($this->tbl, $data);
        return $result;
    }

    public function update_data_reg_esppttemp_by_nik($nik, $data)
    {
        $this->db->where('NIK', $nik);
        $result = $this->db->update_oen_ora($this->tbl, $data);
        return $result;
    }

    public function nextid_user()
    {
        $qry = "SELECT PBB.sec_users_seq.NEXTVAL as NEXT_ID FROM DUAL";
        //log_message('info', "KKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK  ". $qry);
        $query = $this->db->query($qry);
        return $query->row();
    }

    public function insert_user_n($data)
    {
        // insert  data ok
        $pbbwp = $this->load->database('pbbwp', true);
        $result = $pbbwp->insert_oen_ora($this->tbl_user, $data);
        return $result;
    }

    public function insert_user($data)
    {
        // insert  data ok
        $d = $data;
        $id = $d['ID'];
        $level_id = empty($d['LEVEL_ID']) ? 'NULL' : $d['LEVEL_ID'];
        $disabled = $d['DISABLED'];
        $userid = $d['USERID'];
        $passwd = $d['PASSWD'];
        $nama = $d['NAMA'];
        $hp = $d['HANDPHONE'];
        $nip = $d['NIP'];
        $jabatan = $d['JABATAN'];
        $create_date = empty($d['CREATED_DATE']) ? 'NULL' : "TO_TIMESTAMP('".$d['CREATED_DATE']."','YYYY-MM-DD HH24:MI:SS')";
        $created_by = $d['CREATED_BY'];
        $qq = "INSERT INTO SEC_USERS (ID, LEVEL_ID, DISABLED, USERID, PASSWD, NAMA, HANDPHONE, NIP, JABATAN, CREATED_DATE, CREATED_BY) VALUES ({$id}, {$level_id}, {$disabled}, '{$userid}', '{$passwd}', '{$nama}', '{$hp}', '{$nip}', '{$jabatan}', {$create_date}, '{$created_by}')";
        // return $result;
        $this->db->query($qq);
        return true;
    }

    public function insert_user_group($data)
    {
        // insert  data ok
        // $pbbwp = $this->load->database('pbbwp', true);
        // $result = $pbbwp->insert_oen_ora($this->tbl_user_group, $data);
        $this->db->insert($this->tbl_user_group, $data);
        return true;
    }

}

/* End of file _model.php */