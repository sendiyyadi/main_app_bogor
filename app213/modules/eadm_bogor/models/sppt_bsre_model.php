<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class sppt_bsre_model extends CI_Model
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
        if ($query->num_rows() !== 0) {
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
        if ($query->num_rows() !== 0) {
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
        if ($query->num_rows() !== 0) {
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
        if ($query->num_rows() !== 0) {
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
        if ($query->num_rows() !== 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function get_by_niknop($nik)
    {
        $qry = "SELECT ROWIDTOCHAR(R.ROWID) AS ID, R.*,
                                 R.KD_PROPINSI||'.'||R.KD_DATI2||'-'||R.KD_KECAMATAN||'.'||R.KD_KELURAHAN||'-'||R.KD_BLOK||'.'||R.NO_URUT||'.'||R.KD_JNS_OP AS NOP_LENGKAP, KEC.NM_KECAMATAN, KEL.NM_KELURAHAN
                                FROM REG_ESPPT R
                                LEFT JOIN REF_KECAMATAN KEC on R.KD_KECAMATAN = KEC.KD_KECAMATAN
                                 LEFT JOIN REF_KELURAHAN KEL on R.KD_KECAMATAN = KEL.KD_KECAMATAN and R.KD_KELURAHAN = KEL.KD_KELURAHAN
                                WHERE TRIM(R.NIK)||R.KD_PROPINSI||R.KD_DATI2||R.KD_KECAMATAN||R.KD_KELURAHAN||R.KD_BLOK||R.NO_URUT||R.KD_JNS_OP  = '{$nik}' ";
        //log_message('info', "KKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK  ". $qry);
        $query = $this->db->query($qry);
        if ($query->num_rows() !== 0) {
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
    function get_pejabat_ttd($kd_jabatan)
    {
        $qq = "SELECT P.NM_PEGAWAI, P.NIP FROM POSISI_PEGAWAI PP JOIN PEGAWAI P ON P.NIP=PP.NIP WHERE PP.KD_JABATAN={$kd_jabatan}";
        return $this->db->query($qq)->row();
    }

    function q_cetak_sppt($tahun, $kd_prop, $kd_dati2, $kd_kecamatan, $kd_kelurahan, $kd_blok, $no_urut, $kd_jns_op)
    {
        $qq = "SELECT S.PBB_YG_HARUS_DIBAYAR_SPPT, S.THN_PAJAK_SPPT, S.NJOP_SPPT
 FROM SPPT S
JOIN PEMBAYARAN_SPPT PS ON (S.THN_PAJAK_SPPT=PS.THN_PAJAK_SPPT AND S.KD_KECAMATAN=PS.KD_KECAMATAN AND S.KD_KELURAHAN =PS.KD_KELURAHAN AND S.KD_BLOK = PS.KD_BLOK AND S.NO_URUT=PS.NO_URUT AND S.KD_JNS_OP=PS.KD_JNS_OP)
JOIN DAT_OBJEK_PAJAK OP ON (S.KD_PROPINSI=OP.KD_PROPINSI AND S.KD_DATI2=OP.KD_DATI2 AND S.KD_KECAMATAN=OP.KD_KECAMATAN AND S.KD_KELURAHAN =OP.KD_KELURAHAN AND S.KD_BLOK = OP.KD_BLOK AND S.NO_URUT=OP.NO_URUT AND S.KD_JNS_OP=OP.KD_JNS_OP)
JOIN REF_KECAMATAN KEC ON (S.KD_PROPINSI=KEC.KD_PROPINSI AND S.KD_DATI2=KEC.KD_DATI2 AND S.KD_KECAMATAN=KEC.KD_KECAMATAN)
JOIN REF_KELURAHAN KEL ON (S.KD_PROPINSI=KEL.KD_PROPINSI AND S.KD_DATI2=KEL.KD_DATI2 AND S.KD_KECAMATAN=KEL.KD_KECAMATAN AND S.KD_KELURAHAN=KEL.KD_KELURAHAN)
LEFT JOIN REF_DATI2 DT ON (S.KD_PROPINSI=DT.KD_PROPINSI AND S.KD_DATI2=DT.KD_DATI2)
WHERE S.KD_PROPINSI = '{$kd_prop}' AND S.KD_DATI2 = '{$kd_dati2}' AND S.KD_KECAMATAN='{$kd_kecamatan}' AND S.KD_KELURAHAN = '{$kd_kelurahan}' AND S.KD_BLOK = '{$kd_blok}' AND S.NO_URUT='{$no_urut}' AND S.KD_JNS_OP='{$kd_jns_op}' AND S.THN_PAJAK_SPPT = '{$tahun}' ";
        $xx = $this->db->query($qq)->row();
        return $xx;
    }

    function droplist_kecamatan()
    {
        $sql  = " SELECT KD_KECAMATAN, NM_KECAMATAN FROM REF_KECAMATAN";
        $query = $this->db->query($sql);
        if ($query->num_rows() !== 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    function droplist_tahun()
    {
        $sql  = " SELECT DISTINCT(THN_PAJAK_BAYAR) FROM REG_ESPPT WHERE THN_PAJAK_BAYAR != '-   ' ORDER BY THN_PAJAK_BAYAR DESC ";
        $query = $this->db->query($sql);
        if ($query->num_rows() !== 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    function droplist_kelurahan($kec_id)
    {
        $kec_id = empty($kec_id) ? '999999' : $kec_id;
        $sql  = " SELECT KD_KELURAHAN, NM_KELURAHAN FROM REF_KELURAHAN WHERE KD_KECAMATAN = '" . $kec_id . "' ";
        $query = $this->db->query($sql);
        if ($query->num_rows() !== 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    function droplist_kelurahan_all($kec_id)
    {
        $kec_id = empty($kec_id) ? '999999' : $kec_id;
        $sql  = " SELECT '999999' AS KD_KELURAHAN, 'Semua Kel' AS NM_KELURAHAN FROM DUAL
                  UNION ALL
                  SELECT KD_KELURAHAN, NM_KELURAHAN FROM REF_KELURAHAN WHERE KD_KECAMATAN = '" . $kec_id . "' ";
        $query = $this->db->query($sql);
        if ($query->num_rows() !== 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }
}

/* End of file _model.php */
