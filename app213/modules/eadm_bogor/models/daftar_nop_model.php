<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class daftar_nop_model extends CI_Model
{
    private $tbl = 'REG_ESPPTDB';
    private $tbl_dop = 'DAT_OBJEK_PAJAK';
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


    public function cek_nop_avail($kd_propinsi, $kd_dati2, $kd_kecamatan, $kd_kelurahan, $kd_blok, $no_urut, $kd_jns_op)
    {
        $qry = "SELECT Z1.KD_KECAMATAN FROM
                ( SELECT KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP FROM DAT_OBJEK_PAJAK
                    UNION ALL
                  SELECT KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP FROM REG_ESPPT
                ) Z1
								WHERE Z1.KD_PROPINSI = '{$kd_propinsi}' AND Z1.KD_DATI2 = '{$kd_dati2}' AND Z1.KD_KECAMATAN = '{$kd_kecamatan}'
								AND Z1.KD_KELURAHAN = '{$kd_kelurahan}' AND Z1.KD_BLOK = '{$kd_blok}' AND Z1.NO_URUT = '{$no_urut}' AND Z1.KD_JNS_OP = '{$kd_jns_op}'
								AND ROWNUM <= 1";
        //AND lower(trim(KC.KD_KECAMATAN)) = lower(trim('{$kec}'))
        //log_message('info', "KKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK  ". $qry);
        $query = $this->db->query($qry);
        if ($query->num_rows()!==0) {
            return true;
        } else {
            return false;
        }
    }

    public function cek_kec($kd_kecamatan)
    {
        $qry = "SELECT KD_KECAMATAN FROM REF_KECAMATAN
								WHERE KD_KECAMATAN = '{$kd_kecamatan}' AND ROWNUM <= 1";
        //log_message('info', "KKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK  ". $qry);
        $query = $this->db->query($qry);
        if ($query->num_rows()!==0) {
            return false;
        } else {
            return true;
        }
    }

    public function cek_kel($kd_kecamatan, $kd_kelurahan)
    {
        $qry = "SELECT KD_KELURAHAN FROM REF_KELURAHAN
								WHERE KD_KECAMATAN = '{$kd_kecamatan}' AND KD_KELURAHAN = '{$kd_kelurahan}' AND ROWNUM <= 1";
        //log_message('info', "KKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK  ". $qry);
        $query = $this->db->query($qry);
        if ($query->num_rows()!==0) {
            return false;
        } else {
            return true;
        }
    }

    public function cek_znt($kd_kecamatan, $kd_kelurahan, $kd_blok, $kd_znt)
    {
        $qry = "SELECT KD_ZNT FROM DAT_PETA_ZNT
								WHERE KD_KECAMATAN = '{$kd_kecamatan}' AND KD_KELURAHAN = '{$kd_kelurahan}' AND KD_BLOK = '{$kd_blok}' AND KD_ZNT = '{$kd_znt}' AND ROWNUM <= 1";
        //log_message('info', "KKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK  ". $qry);
        $query = $this->db->query($qry);
        if ($query->num_rows()!==0) {
            return false;
        } else {
            return true;
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
        $qry = "SELECT ROWIDTOCHAR(ROWID) AS ID, REG_ESPPTDB.*,
								KD_PROPINSI1||'.'||KD_DATI21||'-'||KD_KECAMATAN1||'.'||KD_KELURAHAN1||'-'||KD_BLOK1||'.'||NO_URUT1||'.'||KD_JNS_OP1 AS NOP_TTG_1,
								KD_PROPINSI2||'.'||KD_DATI22||'-'||KD_KECAMATAN2||'.'||KD_KELURAHAN2||'-'||KD_BLOK2||'.'||NO_URUT2||'.'||KD_JNS_OP2 AS NOP_TTG_2
								FROM REG_ESPPTDB
								WHERE NIK = '{$nik}' ";
        //log_message('info', "KKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK  ". $qry);
        $query = $this->db->query($qry);
        if ($query->num_rows()!==0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function nextid_user()
    {
        $qry = "SELECT PBB.sec_users_seq.NEXTVAL as NEXT_ID FROM DUAL";
        //log_message('info', "KKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK  ". $qry);
        $query = $this->db->query($qry);
        return $query->row();
    }

    public function insert_data_dop($data)
    {
        // insert  data ok
        $result = $this->db->insert_oen_ora($this->tbl_dop, $data);
        return $result;
    }

    public function insert_user($data)
    {
        // insert  data ok
        $pbbwp = $this->load->database('pbbwp', true);
        $result = $pbbwp->insert_oen_ora($this->tbl_user, $data);
        return $result;
    }

    public function insert_user_group($data)
    {
        // insert  data ok
        $pbbwp = $this->load->database('pbbwp', true);
        $result = $pbbwp->insert_oen_ora($this->tbl_user_group, $data);
        return $result;
    }

    public function update_data_reg_espptdb($rowid, $data)
    {
        $this->db->where('ROWID', $rowid);
        $result = $this->db->update_oen_ora($this->tbl, $data);
        return $result;
    }

    public function update_data_reg_espptdb_by_nik($nik, $data)
    {
        $this->db->where('NIK', $nik);
        $result = $this->db->update_oen_ora($this->tbl, $data);
        return $result;
    }
}

/* End of file _model.php */
