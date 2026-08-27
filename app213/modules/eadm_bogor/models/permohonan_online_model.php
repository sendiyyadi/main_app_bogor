<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class permohonan_online_model extends CI_Model
{
    private $tbl = 'PST_PERMOHONAN_ONLINE';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all()
    {
        $sql = "SELECT * FROM PST_PERMOHONAN_ONLINE ";
        $query = $this->db->query($sql);
        if ($query->num_rows()!==0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function get($rowid)
    {
        $qry = "SELECT ROWIDTOCHAR(ROWID) AS ID, PO.*, JP.NM_JENIS_PELAYANAN
								FROM PST_PERMOHONAN_ONLINE PO
                LEFT JOIN REF_JNS_PELAYANAN JP ON JP.KD_JNS_PELAYANAN = PO.KD_JNS_PELAYANAN
								WHERE ROWID = '{$rowid}' ";
        //log_message('info', "KKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK  ". $qry);
        $query = $this->db->query($qry);
        if ($query->num_rows()!==0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function get_by_nopel($nopel)
    {
        $qry = "SELECT ROWIDTOCHAR(PO.ROWID) AS ID, PO.*,
                THN_PELAYANAN||'-'||BUNDEL_PELAYANAN||'-'||NO_URUT_PELAYANAN AS NOPEL,
                KD_PROPINSI_PEMOHON||'.'||KD_DATI2_PEMOHON||'-'||KD_KECAMATAN_PEMOHON||'.'||KD_KELURAHAN_PEMOHON||'-'||KD_BLOK_PEMOHON||'.'||NO_URUT_PEMOHON||'.'||KD_JNS_OP_PEMOHON AS NOP_PEMOHON,
                JP.NM_JENIS_PELAYANAN, L_KTP_WP, L_SKKP_PBB, L_SPMKP_PBB, L_SURAT_KUASA, L_PERMOHONAN, L_STTS, L_SK_KEBERATAN, L_SPPT_STTS, L_SERTIFIKAT_TANAH, L_IMB, L_AKTE_JUAL_BELI, L_SPPT, L_SK_PENGURANGAN, L_LAIN_LAIN
								FROM PST_PERMOHONAN_ONLINE PO
                LEFT JOIN REF_JNS_PELAYANAN JP ON JP.KD_JNS_PELAYANAN = PO.KD_JNS_PELAYANAN
								WHERE THN_PELAYANAN||'-'||BUNDEL_PELAYANAN||'-'||NO_URUT_PELAYANAN = '{$nopel}' ";
        //log_message('info', "KKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK  ". $qry);
        $query = $this->db->query($qry);
        if ($query->num_rows()!==0) {
            return $query->row();
        } else {
            return false;
        }
    }

    function ambil_reg_sppt_temp($nop){
        $qry = "select EMAIL FROM REG_ESPPT_TEMP WHERE (KD_PROPINSI||'.'||KD_DATI2||'-'||KD_KECAMATAN||'.'||KD_KELURAHAN||'-'||KD_BLOK||'.'||NO_URUT||'.'||KD_JNS_OP) = '{$nop}' AND STATUS_VERIF = '2' ";
        return $this->db->query($qry)->row()->EMAIL;
    }

    public function ambil_by_nopel($nopel, $nop)
    {
        $qry = "SELECT ROWIDTOCHAR(PO.ROWID) AS ID, PO.*,
                THN_PELAYANAN||'-'||BUNDEL_PELAYANAN||'-'||NO_URUT_PELAYANAN AS NOPEL,
                KD_PROPINSI_PEMOHON||KD_DATI2_PEMOHON||KD_KECAMATAN_PEMOHON||KD_KELURAHAN_PEMOHON||KD_BLOK_PEMOHON||NO_URUT_PEMOHON||KD_JNS_OP_PEMOHON AS NOP_PEMOHON2, KD_PROPINSI_PEMOHON||'.'||KD_DATI2_PEMOHON||'-'||KD_KECAMATAN_PEMOHON||'.'||KD_KELURAHAN_PEMOHON||'-'||KD_BLOK_PEMOHON||'.'||NO_URUT_PEMOHON||'.'||KD_JNS_OP_PEMOHON AS NOP_PEMOHON,
                JP.NM_JENIS_PELAYANAN, L_KTP_WP, L_SKKP_PBB, L_SPMKP_PBB, L_SURAT_KUASA, L_PERMOHONAN, L_STTS, L_SK_KEBERATAN, L_SPPT_STTS, L_SERTIFIKAT_TANAH, L_IMB, L_AKTE_JUAL_BELI, L_SPPT, L_SK_PENGURANGAN, L_LAIN_LAIN, JP.NM_JENIS_PELAYANAN, TO_CHAR(PO.TGL_SURAT_PERMOHONAN,'DD-MM-YYYY') AS TGL_SURAT_PERMOHONAN, TO_CHAR(PO.TGL_PERKIRAAN_SELESAI,'DD-MM-YYYY') AS TGL_PERKIRAAN_SELESAI, PO.ALASAN
                                FROM PST_PERMOHONAN_ONLINE PO
                LEFT JOIN REF_JNS_PELAYANAN JP ON JP.KD_JNS_PELAYANAN = PO.KD_JNS_PELAYANAN
                                WHERE THN_PELAYANAN||'-'||BUNDEL_PELAYANAN||'-'||NO_URUT_PELAYANAN = '{$nopel}' ";
        
        $query = $this->db->query($qry);
        if ($query->num_rows()!==0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function update_data_permohonan_online($nopel, $data)
    {
        $this->db->where("THN_PELAYANAN||'-'||BUNDEL_PELAYANAN||'-'||NO_URUT_PELAYANAN", "'{$nopel}'", false);
        $result = $this->db->update_oen_ora($this->tbl, $data);
        // $result = $this->db->update($this->tbl, $data);

        // echo $result;
        // die();

        return $result;
    }
    function droplist_jns_pelayanan($kode = null){
        $qq = "select * from ref_jns_pelayanan";
        if(!empty($kode)){
            $qq = "select * from ref_jns_pelayanan where KD_JNS_PELAYANAN='{$kode}'";
        }
        $xx = $this->db->query($qq)->result();
        
        return $xx;
    }
}

/* End of file _model.php */
