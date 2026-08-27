<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class pembetulan_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function get($param) {

        $sql = "SELECT P.THN_PELAYANAN||P.KD_PROPINSI_PEMOHON||P.KD_DATI2_PEMOHON||P.KD_KECAMATAN_PEMOHON||P.KD_KELURAHAN_PEMOHON
                ||P.KD_BLOK_PEMOHON||P.NO_URUT_PEMOHON||P.KD_JNS_OP_PEMOHON||P.KD_JNS_PELAYANAN AS PO_ID,
                SP.KD_PROPINSI||SP.KD_DATI2||SP.KD_KECAMATAN||SP.KD_KELURAHAN||SP.KD_BLOK||SP.NO_URUT||SP.KD_JNS_OP||TRIM(SP.NIK) AS NOPNIK,
                SP.KD_PROPINSI||'.'||SP.KD_DATI2||'-'||SP.KD_KECAMATAN||'.'||SP.KD_KELURAHAN||'-'||SP.KD_BLOK||'.'||SP.NO_URUT||'.'||SP.KD_JNS_OP AS NOP_LKP,
                SP.KD_PROPINSI||SP.KD_DATI2||SP.KD_KECAMATAN||SP.KD_KELURAHAN||SP.KD_BLOK||SP.NO_URUT||SP.KD_JNS_OP AS NOP,
                SP.NIK AS NIK_REG, SP.NM_WP_SPPT AS NAMA_WP_REG, SP.JLN_WP_SPPT AS ALAMAT_REG, SP.NOHP AS TELP_REG,
                SP.NAMA AS NAMA_REG, SP.EMAIL AS EMAIL_REG,
                P.THN_PELAYANAN||'-'||P.BUNDEL_PELAYANAN||'-'||P.NO_URUT_PELAYANAN as NOPEL,
                P.THN_PELAYANAN, P.BUNDEL_PELAYANAN, P.NO_URUT_PELAYANAN,
                P.NAMA_PEMOHON, P.ALAMAT_PEMOHON, P.KETERANGAN_PST, P.TGL_SURAT_PERMOHONAN, 
                P.THN_PAJAK_PERMOHONAN, P.NO_HP, P.KD_JNS_PELAYANAN, P.NO_SRT_PERMOHONAN,
                L_PERMOHONAN, L_SURAT_KUASA, L_KTP_WP, L_SERTIFIKAT_TANAH, L_SPPT, L_IMB, L_AKTE_JUAL_BELI, L_SK_PENSIUN, 
                L_SPPT_STTS, L_STTS, L_SK_PENGURANGAN, L_SK_KEBERATAN, L_SKKP_PBB, L_SPMKP_PBB, L_LAIN_LAIN, 
                L_PERMOHONAN1, L_SURAT_KUASA1, L_KTP_WP1, L_SERTIFIKAT_TANAH1, L_SPPT1, L_IMB1, L_AKTE_JUAL_BELI1, L_SK_PENSIUN1, 
                L_SPPT_STTS1, L_STTS1, L_SK_PENGURANGAN1, L_SK_KEBERATAN1, L_SKKP_PBB1, L_SPMKP_PBB1, L_LAIN_LAIN1
                FROM PST_PERMOHONAN_TOOL P
                JOIN REG_ESPPT SP ON SP.KD_PROPINSI=P.KD_PROPINSI_PEMOHON AND SP.KD_DATI2=P.KD_DATI2_PEMOHON 
                AND SP.KD_KECAMATAN=P.KD_KECAMATAN_PEMOHON AND P.KD_KELURAHAN_PEMOHON=SP.KD_KELURAHAN AND P.KD_BLOK_PEMOHON=SP.KD_BLOK 
                AND SP.NO_URUT=P.NO_URUT_PEMOHON AND SP.KD_JNS_OP=P.KD_JNS_OP_PEMOHON
                WHERE P.THN_PELAYANAN||P.KD_PROPINSI_PEMOHON||P.KD_DATI2_PEMOHON||P.KD_KECAMATAN_PEMOHON||P.KD_KELURAHAN_PEMOHON
                ||P.KD_BLOK_PEMOHON||P.NO_URUT_PEMOHON||P.KD_JNS_OP_PEMOHON||P.KD_JNS_PELAYANAN = '{$param}' ";
        
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0){
            return $query->row();
        } else { 
            return FALSE;
        }
    }

    function get_by_id($id) {

        $sql = "SELECT P.ID as PPO_ID, P.THN_PELAYANAN||P.KD_PROPINSI_PEMOHON||P.KD_DATI2_PEMOHON||P.KD_KECAMATAN_PEMOHON||P.KD_KELURAHAN_PEMOHON
                ||P.KD_BLOK_PEMOHON||P.NO_URUT_PEMOHON||P.KD_JNS_OP_PEMOHON||P.KD_JNS_PELAYANAN AS PO_ID,
                SP.KD_PROPINSI||SP.KD_DATI2||SP.KD_KECAMATAN||SP.KD_KELURAHAN||SP.KD_BLOK||SP.NO_URUT||SP.KD_JNS_OP||TRIM(SP.NIK) AS NOPNIK,
                SP.KD_PROPINSI||'.'||SP.KD_DATI2||'-'||SP.KD_KECAMATAN||'.'||SP.KD_KELURAHAN||'-'||SP.KD_BLOK||'.'||SP.NO_URUT||'.'||SP.KD_JNS_OP AS NOP_LKP,
                SP.KD_PROPINSI||SP.KD_DATI2||SP.KD_KECAMATAN||SP.KD_KELURAHAN||SP.KD_BLOK||SP.NO_URUT||SP.KD_JNS_OP AS NOP,
                SP.NIK AS NIK_REG, SP.NM_WP_SPPT AS NAMA_WP_REG, SP.JLN_WP_SPPT AS ALAMAT_REG, SP.NOHP AS TELP_REG,
                SP.NAMA AS NAMA_REG, SP.EMAIL AS EMAIL_REG,
                P.THN_PELAYANAN||'-'||P.BUNDEL_PELAYANAN||'-'||P.NO_URUT_PELAYANAN as NOPEL,
                P.THN_PELAYANAN, P.BUNDEL_PELAYANAN, P.NO_URUT_PELAYANAN,
                P.NAMA_PEMOHON, P.ALAMAT_PEMOHON, P.KETERANGAN_PST, P.TGL_SURAT_PERMOHONAN, 
                P.THN_PAJAK_PERMOHONAN, P.NO_HP, P.KD_JNS_PELAYANAN, P.NO_SRT_PERMOHONAN,
                L_PERMOHONAN, L_SURAT_KUASA, L_KTP_WP, L_SERTIFIKAT_TANAH, L_SPPT, L_IMB, L_AKTE_JUAL_BELI, L_SK_PENSIUN, 
                L_SPPT_STTS, L_STTS, L_SK_PENGURANGAN, L_SK_KEBERATAN, L_SKKP_PBB, L_SPMKP_PBB, L_LAIN_LAIN, 
                L_PERMOHONAN1, L_SURAT_KUASA1, L_KTP_WP1, L_SERTIFIKAT_TANAH1, L_SPPT1, L_IMB1, L_AKTE_JUAL_BELI1, L_SK_PENSIUN1, 
                L_SPPT_STTS1, L_STTS1, L_SK_PENGURANGAN1, L_SK_KEBERATAN1, L_SKKP_PBB1, L_SPMKP_PBB1, L_LAIN_LAIN1
                FROM PST_PERMOHONAN_TOOL P
                JOIN REG_ESPPT SP ON SP.KD_PROPINSI=P.KD_PROPINSI_PEMOHON AND SP.KD_DATI2=P.KD_DATI2_PEMOHON 
                AND SP.KD_KECAMATAN=P.KD_KECAMATAN_PEMOHON AND P.KD_KELURAHAN_PEMOHON=SP.KD_KELURAHAN AND P.KD_BLOK_PEMOHON=SP.KD_BLOK 
                AND SP.NO_URUT=P.NO_URUT_PEMOHON AND SP.KD_JNS_OP=P.KD_JNS_OP_PEMOHON
                WHERE P.ID = '{$id}' ";
        
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0){
            return $query->row();
        } else { 
            return FALSE;
        }
    }

    function get_jns_ply() {
        $in_array = "('02','03')";
        $qq = "SELECT * FROM REF_JNS_PELAYANAN WHERE KD_JNS_PELAYANAN IN {$in_array} ";        
        return $this->db->query($qq)->result();
    }

    function select_znt($kd_prop, $kd_dati2, $kd_kec, $kd_kel, $kd_blok){
        $qq = "SELECT * FROM DAT_PETA_ZNT WHERE KD_PROPINSI='$kd_prop' AND KD_DATI2='$kd_dati2'
                AND KD_KECAMATAN='$kd_kec' AND KD_KELURAHAN='$kd_kel' AND KD_BLOK='$kd_blok' ";
        
        $xx=$this->db->query($qq);
        return $xx->result();
    }

    function getdt_tbl_mutasi_habis($id_ppo, $tbl) {
        $qq="SELECT * FROM $tbl
             WHERE DOCH_ID = $id_ppo";
        
        return $this->db->query($qq)->row();
    }

    function get_njop_online_by_nop($prop_kd,$kab_kd,$kec_kd,$kel_kd,$blok_kd,$urut_no,$jns_kd) {
        $qq="SELECT DOP.NJOP_BNG, DOP.NJOP_BUMI,
        CASE WHEN DOP.TOTAL_LUAS_BNG > 0 THEN DOP.NJOP_BNG / DOP.TOTAL_LUAS_BNG ELSE 0 END AS NJOP_BNG_PERM,
        CASE WHEN DOP.TOTAL_LUAS_BUMI > 0 THEN DOP.NJOP_BUMI / DOP.TOTAL_LUAS_BUMI ELSE 0 END AS NJOP_BUMI_PERM
        FROM DAT_OBJEK_PAJAK_ONLINE DOP 
        WHERE DOP.KD_PROPINSI = '{$prop_kd}' AND DOP.KD_DATI2 = '{$kab_kd}' AND DOP.KD_KECAMATAN = '{$kec_kd}' 
        AND DOP.KD_KELURAHAN = '{$kel_kd}' AND DOP.KD_BLOK = '{$blok_kd}' AND DOP.NO_URUT = '{$urut_no}' AND DOP.KD_JNS_OP = '{$jns_kd}'  ";
        $xx = $this->db->query($qq);
        return $xx->row();
    }

    function get_njop_online_by_idppo($id_ppo) {
        $qq="SELECT DOP.NJOP_BNG, DOP.NJOP_BUMI,
        CASE WHEN DOP.TOTAL_LUAS_BNG > 0 THEN DOP.NJOP_BNG / DOP.TOTAL_LUAS_BNG ELSE 0 END AS NJOP_BNG_PERM,
        CASE WHEN DOP.TOTAL_LUAS_BUMI > 0 THEN DOP.NJOP_BUMI / DOP.TOTAL_LUAS_BUMI ELSE 0 END AS NJOP_BUMI_PERM
        FROM DAT_OBJEK_PAJAK_ONLINE DOP 
        WHERE DOP.DOCH_ID = {$id_ppo}  ";
        $xx = $this->db->query($qq);
        return $xx->row();
    }

    function get_dtl_bng_ol($id_dtl) {
        $qry = "SELECT DOB.*, KLS_JPB02, 
                TING_KOLOM_JPB3, DAYA_DUKUNG_LANTAI_JPB3, LBR_BENT_JPB3, KELILING_DINDING_JPB3, LUAS_MEZZANINE_JPB3, J03.TYPE_KONSTRUKSI AS TYPE_KONSTRUKSI_JPB3,
                KLS_JPB4, KLS_JPB05, LUAS_KMR_JPB05_DGN_AC_SENT, LUAS_RNG_LAIN_JPB5_DGN_AC_SENT, KLS_JPB06,
                JNS_JPB7, BINTANG_JPB7, JML_KMR_JPB7, LUAS_KMR_JPB7_DGN_AC_SENT, LUAS_KMR_LAIN_JPB7_DGN_AC_SENT,
                TING_KOLOM_JPB8, DAYA_DUKUNG_LANTAI_JPB8, LBR_BENT_JPB8, KELILING_DINDING_JPB8, LUAS_MEZZANINE_JPB8, J08.TYPE_KONSTRUKSI AS TYPE_KONSTRUKSI_JPB8,
                KLS_JPB09, TYPE_JPB12, KLS_JPB13, JML_JPB13, LUAS_JPB13_DGN_AC_SENT, LUAS_JPB13_LAIN_DGN_AC_SENT,
                LUAS_KANOPI_JPB14, LETAK_TANGKI_JPB15, KAPASITAS_TANGKI_JPB15, KLS_JPB16
                FROM DAT_OP_BANGUNAN_ONLINE DOB
                LEFT JOIN DAT_JPB02_ONLINE J02 ON DOB.ID = J02.DOCD_ID 
                LEFT JOIN DAT_JPB03_ONLINE J03 ON DOB.ID = J03.DOCD_ID 
                LEFT JOIN DAT_JPB04_ONLINE J04 ON DOB.ID = J04.DOCD_ID 
                LEFT JOIN DAT_JPB05_ONLINE J05 ON DOB.ID = J05.DOCD_ID 
                LEFT JOIN DAT_JPB06_ONLINE J06 ON DOB.ID = J06.DOCD_ID 
                LEFT JOIN DAT_JPB07_ONLINE J07 ON DOB.ID = J07.DOCD_ID 
                LEFT JOIN DAT_JPB08_ONLINE J08 ON DOB.ID = J08.DOCD_ID 
                LEFT JOIN DAT_JPB09_ONLINE J09 ON DOB.ID = J09.DOCD_ID 
                LEFT JOIN DAT_JPB12_ONLINE J12 ON DOB.ID = J12.DOCD_ID 
                LEFT JOIN DAT_JPB13_ONLINE J13 ON DOB.ID = J13.DOCD_ID 
                LEFT JOIN DAT_JPB14_ONLINE J14 ON DOB.ID = J14.DOCD_ID 
                LEFT JOIN DAT_JPB15_ONLINE J15 ON DOB.ID = J15.DOCD_ID 
                LEFT JOIN DAT_JPB16_ONLINE J16 ON DOB.ID = J16.DOCD_ID 
                WHERE DOB.ID = {$id_dtl}";
        return $this->db->query($qry)->row();
    }

    public function insert_thn_online($data) {
        $result = $this->db->insert('PST_THN_TOOL_OL', $data);
        return $result;
    }

    function select_max_no_sk(){
        $year_now = date('Y');
        $ret = array();
        $qq = $this->db->query("SELECT THN_SURAT, NO_URUT_SK 
                                FROM MAX_NO_SK 
                                WHERE THN_SURAT='{$year_now}' AND ID=1 ");
                                //// ID 3 UNTUK NO SK PEMBETULAN
        if($qq->num_rows() > 0){
            $ret= $qq->row_array();
            $ret['NEW_YEAR'] = 0;
        }else{
            $ret = array('THN_SURAT'=> $year_now,
                'NO_URUT_SK' => 0,
                'NEW_YEAR' => 1);
        }
        return $ret;
    }

    function update_max_no_sk($tahun, $no_urut){
        $thn_exists = $this->thnsurat_max_no_sk();
        $year_now = date('Y');
        if($thn_exists == $year_now){
            $qq = "UPDATE MAX_NO_SK SET NO_URUT_SK='$no_urut', UPDATE_TIME=SYSTIMESTAMP WHERE ID=1";
        }else{
            $qq = "UPDATE MAX_NO_SK SET THN_SURAT='{$tahun}', NO_URUT_SK={$no_urut}, UPDATE_TIME=SYSTIMESTAMP WHERE ID=1";
        }
        $this->db->query($qq);
    }

    function thnsurat_max_no_sk(){
        $year_now = date('Y');
        $qq = $this->db->query("SELECT THN_SURAT AS TAHUN FROM MAX_NO_SK WHERE ID=1 ");
        return $qq->row()->TAHUN;
    }

    function update_pst_permohonan_tool($id, $data){
        $this->db->where('ID', $id);
        $this->db->update('PST_PERMOHONAN_TOOL',$data);
    }

    function get_ref_syarat_peneliti_by_idppo($id_ppo) {
        $qq = "SELECT R.ID, R.KET, P.STATUS, P.KETERANGAN FROM REF_SYARAT_PENELITI R 
                LEFT JOIN PST_TOOL_DTL_PNLT P ON P.ID_REF_SYARAT = R.ID AND P.ID_PPO = $id_ppo
                WHERE R.STATUS = 1 AND R.KD_JNS_PLY = '03' ORDER BY R.ID";
        $xx=$this->db->query($qq);
        return $xx->result();
    }
    
}

/* End of file _model.php */
