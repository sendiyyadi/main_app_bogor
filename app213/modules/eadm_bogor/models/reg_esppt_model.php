<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class reg_esppt_model extends CI_Model
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

    function cek_tolak_data($nik){
        $qq = "SELECT COUNT(*) AS CTR
                FROM REG_ESPPT_TEMP
                WHERE NIK = '{$nik}' AND STATUS_VERIF=2";
        $xx = $this->db->query($qq)->row()->CTR;
        return $xx;
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

     public function get_by_nik_sts($nik, $sts)
    {
        $qry = "SELECT ROWIDTOCHAR(TM.ROWID) AS ID, TM.*, KEC.NM_KECAMATAN, KEL.NM_KELURAHAN, 
                                TM.KD_PROPINSI||'.'||TM.KD_DATI2||'-'||TM.KD_KECAMATAN||'.'||TM.KD_KELURAHAN||'-'||TM.KD_BLOK||'.'||TM.NO_URUT||'.'||TM.KD_JNS_OP AS NOP_LKP
                                FROM REG_ESPPT_TEMP TM
                LEFT JOIN REF_KECAMATAN KEC on TM.KD_KECAMATAN = KEC.KD_KECAMATAN
                LEFT JOIN REF_KELURAHAN KEL on TM.KD_KECAMATAN = KEL.KD_KECAMATAN and TM.KD_KELURAHAN = KEL.KD_KELURAHAN
                                WHERE NIK = '{$nik}' AND STATUS_VERIF= '{$sts}' ";
        //log_message('info', "KKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK  ". $qry);
        $query = $this->db->query($qry);
        if ($query->num_rows()!==0) {
            return $query->row();
        } else {
            return false;
        }
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
                                       USER_GROUP, STATUS, NIKNOP, THN_PAJAK_BAYAR, IM_KTP, IM_SPPT, IM_STTS)
                SELECT KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP,
                       NIK, NM_WP_SPPT, COALESCE(JLN_WP_SPPT, '-'), COALESCE(BLOK_KAV_NO_WP_SPPT, '-'), COALESCE(RW_WP_SPPT, '00'), COALESCE(RT_WP_SPPT, '000'), 
                       COALESCE(KELURAHAN_WP_SPPT, '-'), COALESCE(KOTA_WP_SPPT, '-'), COALESCE(KD_POS_WP_SPPT, '-'), COALESCE(NPWP_SPPT, '-'), 
                       COALESCE(JLN_OP_SPPT, '-'), COALESCE(BLOK_KAV_NO_OP_SPPT, '-'), COALESCE(RW_OP_SPPT, '00'), COALESCE(RT_OP_SPPT, '000'),
                       COALESCE(NM_WP_BAYAR, '-'), LOGINNAME, PASSWOD, NAMA, EMAIL, NOHP, NO_REG,
                       USER_GROUP, STATUS_VERIF, NIKNOP, '-', IM_KTP_BLOB, IM_SPPT_BLOB, IM_PBB_BLOB
                FROM REG_ESPPT_TEMP
                WHERE NIK = '{$nik}' AND STATUS_VERIF=0 ";
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
                                       USER_GROUP, STATUS, NIKNOP, THN_PAJAK_BAYAR, IM_KTP, IM_SPPT, IM_STTS)
                SELECT KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP,
                       NIK, NM_WP_SPPT, COALESCE(JLN_WP_SPPT, '-'), COALESCE(BLOK_KAV_NO_WP_SPPT, '-'), COALESCE(RW_WP_SPPT, '00'), COALESCE(RT_WP_SPPT, '000'), 
                       COALESCE(KELURAHAN_WP_SPPT, '-'), COALESCE(KOTA_WP_SPPT, '-'), COALESCE(KD_POS_WP_SPPT, '-'), COALESCE(NPWP_SPPT, '-'), 
                       COALESCE(JLN_OP_SPPT, '-'), COALESCE(BLOK_KAV_NO_OP_SPPT, '-'), COALESCE(RW_OP_SPPT, '00'), COALESCE(RT_OP_SPPT, '000'),
                       COALESCE(NM_WP_BAYAR, '-'), LOGINNAME, PASSWOD, NAMA, EMAIL, NOHP, NO_REG,
                       USER_GROUP, STATUS_VERIF, TRIM(NIK) || KD_PROPINSI || KD_DATI2 || KD_KECAMATAN || KD_KELURAHAN || KD_BLOK||NO_URUT||KD_JNS_OP, '-', IM_KTP_BLOB, IM_SPPT_BLOB, IM_PBB_BLOB
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

    public function insert_user($data)
    {
        // insert  data ok
        //$pbbwp = $this->load->database('pbbwp', true);
        // $result = $pbbwp->insert_oen_ora($this->tbl_user, $data);
        $qq = "INSERT INTO SEC_USERS (ID, LEVEL_ID, DISABLED, USERID, PASSWD, NAMA, HANDPHONE, NIP, JABATAN, CREATED_DATE, CREATED_BY) VALUES ('".$data['ID']."', ".$data['LEVEL_ID'].", ".$data['DISABLED'].", '".$data['USERID']."', '".$data['PASSWD']."', '".$data['NAMA']."', '".$data['HANDPHONE']."', '".$data['NIP']."', '".$data['JABATAN']."', TO_TIMESTAMP('".$data['CREATED_DATE']."','YYYY-MM-DD HH24:MI:SS.FF'), '".$data['CREATED_BY']."')";
        $this->db->query($qq);
        return true;
    }

    public function insert_user_group($data)
    {
        // insert  data ok
        $pbbwp = $this->load->database('pbbwp', true);
        $result = $pbbwp->insert($this->tbl_user_group, $data);
        return $result;
    }
     function cek_reg_esppt($nik, $kd_prop, $kd_dati2, $kd_kecamatan, $kd_kelurahan, $kd_blok,$no_urut, $kd_jns_op){
    $qq = "SELECT COUNT(*) AS CTR FROM REG_ESPPT R WHERE R.NIK='$nik' AND R.KD_PROPINSI='$kd_prop' AND R.KD_DATI2='$kd_dati2' AND R.KD_KECAMATAN='$kd_kecamatan' AND R.KD_KELURAHAN='$kd_kelurahan' AND R.KD_BLOK='$kd_blok' AND R.NO_URUT='$no_urut' AND R.KD_JNS_OP='$kd_jns_op' ";
    $xx=$this->db->query($qq);
    return $xx->row()->CTR;
    }

    function get_select_kecamatan()
    {
        $this->db->select(KD_KECAMATAN_KEC.', '.NM_KECAMATAN);
        $this->db->order_by(NM_KECAMATAN);
        $query = $this->db->get(TBL_REF_KECAMATAN);
        if($query->num_rows()!==0)
        {
            return $query->result();
        }
        else
            return FALSE;
    }

    function get_select_kelurahan($kec_id)
    {
        $this->db->select(KD_KELURAHAN.', '.NM_KELURAHAN);
        $this->db->where(array(KD_KECAMATAN_KEL=>$kec_id));
        $this->db->order_by(NM_KELURAHAN);
        $query = $this->db->get(TBL_REF_KELURAHAN);
        if($query->num_rows()!==0)
        {
            return $query->result();
        }
        else
            return FALSE;
        // return $this->db->last_query();
    }

}

/* End of file _model.php */
