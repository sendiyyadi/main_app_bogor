<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class permohonan_online_upt_model extends CI_Model {

    function get_ppo_by_id($id) {

        $sql = "SELECT P.*, P.ID as PPO_ID, 
                P.THN_PELAYANAN||P.KD_PROPINSI_PEMOHON||P.KD_DATI2_PEMOHON||P.KD_KECAMATAN_PEMOHON||P.KD_KELURAHAN_PEMOHON
                ||P.KD_BLOK_PEMOHON||P.NO_URUT_PEMOHON||P.KD_JNS_OP_PEMOHON||P.KD_JNS_PELAYANAN AS PO_ID,
                SP.KD_PROPINSI||SP.KD_DATI2||SP.KD_KECAMATAN||SP.KD_KELURAHAN||SP.KD_BLOK||SP.NO_URUT||SP.KD_JNS_OP||TRIM(SP.NIK) AS NOPNIK,
                P.KD_PROPINSI_PEMOHON||'.'||P.KD_DATI2_PEMOHON||'-'||P.KD_KECAMATAN_PEMOHON||'.'||P.KD_KELURAHAN_PEMOHON||'-'||P.KD_BLOK_PEMOHON||'.'||P.NO_URUT_PEMOHON||'.'||P.KD_JNS_OP_PEMOHON AS NOP_LKP,
                P.KD_PROPINSI_PEMOHON||P.KD_DATI2_PEMOHON||P.KD_KECAMATAN_PEMOHON||P.KD_KELURAHAN_PEMOHON||P.KD_BLOK_PEMOHON||P.NO_URUT_PEMOHON||P.KD_JNS_OP_PEMOHON AS NOP,
                P.THN_PELAYANAN||'-'||P.BUNDEL_PELAYANAN||'-'||P.NO_URUT_PELAYANAN as NOPEL,
                P.THN_PELAYANAN||P.BUNDEL_PELAYANAN||P.NO_URUT_PELAYANAN as NO_PLY,
                P.KD_PROPINSI_PEMOHON KD_PROPINSI, P.KD_DATI2_PEMOHON KD_DATI2, P.KD_KECAMATAN_PEMOHON KD_KECAMATAN, 
                P.KD_KELURAHAN_PEMOHON KD_KELURAHAN, P.KD_BLOK_PEMOHON KD_BLOK, P.NO_URUT_PEMOHON NO_URUT, P.KD_JNS_OP_PEMOHON KD_JNS_OP,
                SP.NIK AS NIK_REG, SP.NAMA AS NAMA_WP_REG, SP.ALAMAT AS ALAMAT_REG, SP.NOHP AS TELP_REG,
                SP.NAMA AS NAMA_REG, SP.EMAIL AS EMAIL_REG,
                P.KD_JNS_PELAYANAN, TRIM(P.KD_SUB_JNS_PELAYANAN) as KD_SUB_JNS_PELAYANAN, P.STATUS_PERMOHONAN, RJP.NM_JENIS_PELAYANAN,
                P.TGL_SURAT_PERMOHONAN, P.TGL_PERKIRAAN_SELESAI, P.THN_PAJAK_PERMOHONAN,
                REGEXP_SUBSTR(P.NO_SK, '[0-9]{4}$') AS THN_SK, P.URUT_SK, P.JML_MUTASI, P.THN_PELAYANAN
                FROM PST_PERMOHONAN_TOOL P
                JOIN REG_USERS SP ON SP.ID = P.ID_REGUSER
                JOIN REF_JNS_PELAYANAN RJP ON RJP.KD_JNS_PELAYANAN = P.KD_JNS_PELAYANAN
                WHERE P.ID = '{$id}' ";
        
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
                P.KD_PROPINSI_PEMOHON||'.'||P.KD_DATI2_PEMOHON||'-'||P.KD_KECAMATAN_PEMOHON||'.'||P.KD_KELURAHAN_PEMOHON||'-'||P.KD_BLOK_PEMOHON||'.'||P.NO_URUT_PEMOHON||'.'||P.KD_JNS_OP_PEMOHON AS NOP_LKP,
                P.KD_PROPINSI_PEMOHON||P.KD_DATI2_PEMOHON||P.KD_KECAMATAN_PEMOHON||P.KD_KELURAHAN_PEMOHON||P.KD_BLOK_PEMOHON||P.NO_URUT_PEMOHON||P.KD_JNS_OP_PEMOHON AS NOP,
                P.KD_PROPINSI_PEMOHON KD_PROPINSI, P.KD_DATI2_PEMOHON KD_DATI2, P.KD_KECAMATAN_PEMOHON KD_KECAMATAN, 
                P.KD_KELURAHAN_PEMOHON KD_KELURAHAN, P.KD_BLOK_PEMOHON KD_BLOK, P.NO_URUT_PEMOHON NO_URUT, P.KD_JNS_OP_PEMOHON KD_JNS_OP,
                SP.NIK AS NIK_REG, SP.NAMA AS NAMA_WP_REG, SP.ALAMAT AS ALAMAT_REG, TRIM(SP.NOHP) AS TELP_REG,
                SP.NAMA AS NAMA_REG, SP.EMAIL AS EMAIL_REG, P.ALASAN, P.STATUS_PERMOHONAN, P.TGL_PERKIRAAN_SELESAI,
                P.THN_PELAYANAN||'-'||P.BUNDEL_PELAYANAN||'-'||P.NO_URUT_PELAYANAN as NOPEL,
                P.THN_PELAYANAN||P.BUNDEL_PELAYANAN||P.NO_URUT_PELAYANAN as NO_PLY,
                P.THN_PELAYANAN, P.BUNDEL_PELAYANAN, P.NO_URUT_PELAYANAN, RJP.NM_JENIS_PELAYANAN,
                P.NAMA_PEMOHON, P.ALAMAT_PEMOHON, P.KETERANGAN_PST, P.TGL_SURAT_PERMOHONAN, 
                P.THN_PAJAK_PERMOHONAN, TRIM(P.NO_HP) as NO_HP, P.KD_JNS_PELAYANAN, P.NO_SRT_PERMOHONAN,
                L_PERMOHONAN, L_SURAT_KUASA, L_KTP_WP, L_SERTIFIKAT_TANAH, L_SPPT, L_IMB, L_AKTE_JUAL_BELI, L_SK_PENSIUN, 
                L_SPPT_STTS, L_STTS, L_SK_PENGURANGAN, L_SK_KEBERATAN, L_SKKP_PBB, L_SPMKP_PBB, L_LAIN_LAIN, 
                L_PERMOHONAN1, L_SURAT_KUASA1, L_KTP_WP1, L_SERTIFIKAT_TANAH1, L_SPPT1, L_IMB1, L_AKTE_JUAL_BELI1, L_SK_PENSIUN1, 
                L_SPPT_STTS1, L_STTS1, L_SK_PENGURANGAN1, L_SK_KEBERATAN1, L_SKKP_PBB1, L_SPMKP_PBB1, L_LAIN_LAIN1,
                DSP.SUBJEK_PAJAK_ID AS NIK_WP_SPPT, DSP.NM_WP AS NM_WP_SPPT, DSP.JALAN_WP AS JLN_WP_SPPT, TRIM(DSP.HP_WP) AS NOHP,
                DSP.BLOK_KAV_NO_WP AS BLOK_KAV_NO_WP_SPPT, DSP.RW_WP AS RW_WP_SPPT, DSP.RT_WP AS RT_WP_SPPT,
                DSP.KELURAHAN_WP AS KELURAHAN_WP_SPPT, DSP.KOTA_WP AS KOTA_WP_SPPT, DSP.KD_POS_WP AS KD_POS_WP_SPPT,
                DSP.TELP_WP AS TELP_WP_SPPT, DSP.NPWP, DSP.STATUS_PEKERJAAN_WP, DSP.EMAIL_WP AS EMAIL_WP_SPPT,
                DOP.JALAN_OP as JLN_OP_SPPT, DOP.BLOK_KAV_NO_OP AS BLOK_KAV_NO_OP_SPPT, DOP.RW_OP AS RW_OP_SPPT,
                DOP.RT_OP AS RT_OP_SPPT, DOP.KD_STATUS_WP, DOP.TOTAL_LUAS_BUMI, DOP.TOTAL_LUAS_BNG,
                CASE WHEN DOP.TOTAL_LUAS_BNG > 0 THEN DOP.NJOP_BNG / DOP.TOTAL_LUAS_BNG ELSE 0 END AS NJOP_BNG_PERM,
                CASE WHEN DOP.TOTAL_LUAS_BUMI > 0 THEN DOP.NJOP_BUMI / DOP.TOTAL_LUAS_BUMI ELSE 0 END AS NJOP_BUMI_PERM,
                DOP.NJOP_BNG, DOP.NJOP_BUMI,
                DOBM.JNS_BUMI, DOBM.KD_ZNT,
                P.KET_VERLAP, P.REKOM_VERLAP, P.NO_SK, P.TGL_SK, P.NO_BAP_LAPANGAN, P.TGL_BAP_LAPANGAN,
                P.URAIAN_1, P.URAIAN_2, P.JML_MUTASI, P.JENIS_KEBERATAN,
                P.L_VERLAP1, P.L_VERLAP11, P.L_VERLAP2, P.L_VERLAP21,
                REGEXP_SUBSTR(P.NO_SK, '[0-9]{4}$') AS THN_SK, P.URUT_SK,
                TRIM(P.KD_SUB_JNS_PELAYANAN) as KD_SUB_JNS_PELAYANAN,
                P.PROSES_PK, P.ANALISA_PK, P.KETERANGAN_PK, P.PROSES_PL, P.ANALISA_PL, P.KETERANGAN_PL,
                P.LATITUDE, P.LONGITUDE, P.L_PKP1, P.L_PKP2, P.L_PKP11, P.L_PKP21,
                P.DASAR_PENILAIAN, P.PENGGUNAAN_BNG_PDL, P.OBJEK_BNG_PDL, P.KET_BUMI_PDL, P.KET_BNG_PDL
                FROM PST_PERMOHONAN_TOOL P
                JOIN REG_USERS SP ON SP.ID = P.ID_REGUSER
                JOIN DAT_OBJEK_PAJAK_ONLINE DOP ON DOP.DOCH_ID = P.ID
                JOIN DAT_SUBJEK_PAJAK_ONLINE DSP ON DSP.DOCH_ID = P.ID
                JOIN DAT_OP_BUMI_ONLINE DOBM ON DOBM.DOCH_ID = P.ID
                JOIN REF_JNS_PELAYANAN RJP ON RJP.KD_JNS_PELAYANAN = P.KD_JNS_PELAYANAN
                WHERE P.ID = '{$id}' ";
        
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0){
            return $query->row();
        } else { 
            return FALSE;
        }
    }

    function get_dt_sismiop_asli($id) {

        $sql = "SELECT 
                DOP.*, DSP.NM_WP, DSP.JALAN_WP, DSP.BLOK_KAV_NO_WP, DSP.RW_WP, DSP.RT_WP, DSP.KELURAHAN_WP, DSP.KOTA_WP, 
                DSP.KD_POS_WP, DSP.TELP_WP, DSP.NPWP, DSP.STATUS_PEKERJAAN_WP, DSP.HP_WP, DSP.EMAIL_WP,
                INITCAP(RJP.NM_JENIS_PELAYANAN) as NM_JENIS_PELAYANAN
                FROM PST_PERMOHONAN_TOOL P
                JOIN DAT_OBJEK_PAJAK DOP ON DOP.KD_PROPINSI=P.KD_PROPINSI_PEMOHON AND DOP.KD_DATI2=P.KD_DATI2_PEMOHON 
                AND DOP.KD_KECAMATAN=P.KD_KECAMATAN_PEMOHON AND P.KD_KELURAHAN_PEMOHON=DOP.KD_KELURAHAN AND P.KD_BLOK_PEMOHON=DOP.KD_BLOK 
                AND DOP.NO_URUT=P.NO_URUT_PEMOHON AND DOP.KD_JNS_OP=P.KD_JNS_OP_PEMOHON 
                JOIN DAT_SUBJEK_PAJAK DSP ON DSP.SUBJEK_PAJAK_ID=DOP.SUBJEK_PAJAK_ID
                JOIN REF_JNS_PELAYANAN RJP ON RJP.KD_JNS_PELAYANAN = P.KD_JNS_PELAYANAN
                WHERE P.ID = '{$id}' ";
        
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0){
            return $query->row();
        } else { 
            return FALSE;
        }
    }

    function get_dt_angsuran($id) {

        $sql = "SELECT 
                SP.NM_WP_SPPT, 
                DOP.JALAN_OP||' '||NVL(DOP.BLOK_KAV_NO_OP,'-')||' RT.'||NVL(DOP.RT_OP,'-')||' RW.'||NVL(DOP.RW_OP,'-') as ALAMAT_OP_SPPT,
                SP.PBB_YG_HARUS_DIBAYAR_SPPT
                FROM PST_PERMOHONAN_TOOL P
                JOIN SPPT SP ON SP.KD_PROPINSI=P.KD_PROPINSI_PEMOHON AND SP.KD_DATI2=P.KD_DATI2_PEMOHON 
                AND SP.KD_KECAMATAN=P.KD_KECAMATAN_PEMOHON AND P.KD_KELURAHAN_PEMOHON=SP.KD_KELURAHAN AND P.KD_BLOK_PEMOHON=SP.KD_BLOK 
                AND SP.NO_URUT=P.NO_URUT_PEMOHON AND SP.KD_JNS_OP=P.KD_JNS_OP_PEMOHON AND SP.THN_PAJAK_SPPT = P.THN_PAJAK_PERMOHONAN
                JOIN DAT_OBJEK_PAJAK DOP ON SP.KD_PROPINSI=DOP.KD_PROPINSI AND SP.KD_DATI2=DOP.KD_DATI2 
                AND SP.KD_KECAMATAN=DOP.KD_KECAMATAN AND DOP.KD_KELURAHAN=SP.KD_KELURAHAN AND DOP.KD_BLOK=SP.KD_BLOK 
                AND SP.NO_URUT=DOP.NO_URUT AND SP.KD_JNS_OP=DOP.KD_JNS_OP 
                JOIN REF_JNS_PELAYANAN RJP ON RJP.KD_JNS_PELAYANAN = P.KD_JNS_PELAYANAN
                WHERE P.ID = '{$id}' ";
        
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0){
            return $query->row();
        } else { 
            return FALSE;
        }
    }

    function get_dt_pengurangan($id) {

        $sql = "SELECT RSJP.NM_SUB_JENIS_PELAYANAN, P.PCT_PENGURANGAN, P.PCT_PENGURANGAN_APPR, P.STS_PENGURANGAN
                FROM PST_PERMOHONAN_TOOL P
                JOIN REF_JNS_PELAYANAN RJP ON RJP.KD_JNS_PELAYANAN = P.KD_JNS_PELAYANAN
                JOIN REF_SUB_JNS_PELAYANAN RSJP ON RSJP.KD_JNS_PELAYANAN = P.KD_JNS_PELAYANAN AND TRIM(RSJP.KD_SUB_JNS_PELAYANAN)=TRIM(P.KD_SUB_JNS_PELAYANAN)
                WHERE P.ID = '{$id}' ";
        
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0){
            return $query->row();
        } else { 
            return FALSE;
        }
    }

    function get_pst_angsuran($id) {

        $sql = "SELECT 
                TGL_C_I, CICILAN_I,
                TGL_C_II, CICILAN_II,
                TGL_C_III, CICILAN_III,
                TGL_C_IV, CICILAN_IV
                FROM PST_PERMOHONAN_TOOL P
                JOIN PST_PERMOHONAN_ANGSURAN SP ON SP.KD_PROPINSI_PEMOHON=P.KD_PROPINSI_PEMOHON AND SP.KD_DATI2_PEMOHON=P.KD_DATI2_PEMOHON 
                AND SP.KD_KECAMATAN_PEMOHON=P.KD_KECAMATAN_PEMOHON AND P.KD_KELURAHAN_PEMOHON=SP.KD_KELURAHAN_PEMOHON 
                AND P.KD_BLOK_PEMOHON=SP.KD_BLOK_PEMOHON AND SP.NO_URUT_PEMOHON=P.NO_URUT_PEMOHON 
                AND SP.KD_JNS_OP_PEMOHON=P.KD_JNS_OP_PEMOHON AND SP.THN_PAJAK_SPPT_PEMOHON = P.THN_PAJAK_PERMOHONAN
                AND SP.THN_PELAYANAN=P.THN_PELAYANAN AND SP.BUNDEL_PELAYANAN=P.BUNDEL_PELAYANAN
                AND SP.NO_URUT_PELAYANAN=P.NO_URUT_PELAYANAN
                WHERE P.ID = '{$id}' ";
        
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0){
            return $query->row();
        } else { 
            return FALSE;
        }
    }


    function pekerjaan_wp_droplist($kode_item = null) {
        $qq = "SELECT * FROM LOOKUP_ITEM WHERE KD_LOOKUP_GROUP='08' AND KD_LOOKUP_ITEM != '0' ";
        if(!empty($kode_item)){
            $qq .= " AND KD_LOOKUP_ITEM='$kode_item' ";
        }
        $xx=$this->db->query($qq);
        return $xx->result();
    }

    function lookup_item_droplist($kdgrup,$kode = null) {
        $qq = "SELECT * FROM LOOKUP_ITEM WHERE KD_LOOKUP_GROUP='{$kdgrup}' ";
        if(!empty($kode)){
            $qq .= " AND KD_LOOKUP_ITEM='{$kode}' ";
        }
        $xx = $this->db->query($qq);
        return $xx->result();
    }

    function ref_jbp_droplist($kode = null) {
        $qq = "SELECT * FROM REF_JPB";
        if(!empty($kode)){
            $qq .= " WHERE KD_JPB='{$kode}' ";
        }
        $xx = $this->db->query($qq);
        return $xx->result();
    }

    function ref_fasilitas_droplist($kode = null) {
        $qq = "SELECT * FROM FASILITAS";
        if(!empty($kode)){
            $qq .= " WHERE KD_FASILITAS='{$kode}' ";
        }
        $xx = $this->db->query($qq);
        return $xx->result();
    }

    function get_dtl_bng($id_dtl) {
        $qry = "SELECT DOB.*, KLS_JPB02, 
                TING_KOLOM_JPB3, DAYA_DUKUNG_LANTAI_JPB3, LBR_BENT_JPB3, KELILING_DINDING_JPB3, LUAS_MEZZANINE_JPB3, J03.TYPE_KONSTRUKSI AS TYPE_KONSTRUKSI_JPB3,
                KLS_JPB4, KLS_JPB05, LUAS_KMR_JPB05_DGN_AC_SENT, LUAS_RNG_LAIN_JPB5_DGN_AC_SENT, KLS_JPB06,
                JNS_JPB7, BINTANG_JPB7, JML_KMR_JPB7, LUAS_KMR_JPB7_DGN_AC_SENT, LUAS_KMR_LAIN_JPB7_DGN_AC_SENT,
                TING_KOLOM_JPB8, DAYA_DUKUNG_LANTAI_JPB8, LBR_BENT_JPB8, KELILING_DINDING_JPB8, LUAS_MEZZANINE_JPB8, J08.TYPE_KONSTRUKSI AS TYPE_KONSTRUKSI_JPB8,
                KLS_JPB09, TYPE_JPB12, KLS_JPB13, JML_JPB13, LUAS_JPB13_DGN_AC_SENT, LUAS_JPB13_LAIN_DGN_AC_SENT,
                LUAS_KANOPI_JPB14, LETAK_TANGKI_JPB15, KAPASITAS_TANGKI_JPB15, KLS_JPB16,
                IND.NILAI_INDIVIDU
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
                LEFT JOIN DAT_NILAI_INDIVIDU_ONLINE IND ON DOB.ID = IND.DOCD_ID
                WHERE DOB.ID = {$id_dtl}";
        return $this->db->query($qry)->row();
    }

    function get_ref_sts($kd = null) {
        $qq = "SELECT * FROM REF_STATUS_PST WHERE 1=1 ";

        if ($kd) {
            $qq .= " AND KD = '$kd' ";
        }
        // $qq = "SELECT * FROM REF_JNS_PELAYANAN  ";
        return $this->db->query($qq)->result();
    }

    function get_jns_ply($kd_ply = null) {
        $in_array = "('02','03','15','08','19','22')";
        $qq = "SELECT * FROM REF_JNS_PELAYANAN WHERE KD_JNS_PELAYANAN IN {$in_array} ";

        if ($kd_ply) {
            $qq .= " AND KD_JNS_PELAYANAN = '$kd_ply' ";
        }
        // $qq = "SELECT * FROM REF_JNS_PELAYANAN  ";
        return $this->db->query($qq)->result();
    }

    function get_kecamatan() {
        $qq = "SELECT KD_KECAMATAN, NM_KECAMATAN FROM REF_KECAMATAN ";

        return $this->db->query($qq)->result();
    }

    function get_kelurahan($kec_id)
    {
        $kec_id = empty($kec_id) ? '99999' : $kec_id;
        $sql  = " SELECT '99999' AS KD_KELURAHAN, 'SEMUA KELURAHAN' AS NM_KELURAHAN FROM DUAL UNION ALL ";
        $sql .= " SELECT z1.* FROM ( ";
        $sql .= " SELECT KD_KELURAHAN, NM_KELURAHAN from REF_KELURAHAN WHERE KD_KECAMATAN=".$kec_id." ORDER BY NM_KELURAHAN) z1";
        $query = $this->db->query($sql);
        if($query->num_rows()!==0)
            { return $query->result();}
        else { return FALSE; }
    }

    function get_sub_jns_ply_r($jns_id)
    {
        $jns_id = empty($jns_id) ? 99999 : $jns_id;
        $sql  = " SELECT 99999 AS ID, 'SEMUA SUB JNS PELAYANAN' AS NM_SUB_JENIS_PELAYANAN FROM DUAL UNION ALL ";
        $sql .= " SELECT z1.* FROM ( ";
        $sql .= " SELECT ID, NM_SUB_JENIS_PELAYANAN from REF_SUB_JNS_PELAYANAN WHERE KD_JNS_PELAYANAN=".$jns_id." ORDER BY NM_SUB_JENIS_PELAYANAN) z1";
        $query = $this->db->query($sql);
        if($query->num_rows()!==0)
            { return $query->result();}
        else { return FALSE; }
    }

    function get_sub_jns_ply($kd_ply, $kd_sub = null) {
        $qq = "SELECT '999999' AS KD_SUB_JNS_PELAYANAN, 'SILAKAN PILIH' AS NM_SUB_JENIS_PELAYANAN FROM DUAL UNION ALL 
               SELECT TRIM(KD_SUB_JNS_PELAYANAN), NM_SUB_JENIS_PELAYANAN FROM REF_SUB_JNS_PELAYANAN WHERE KD_JNS_PELAYANAN IN {$kd_ply} ";

        // if ($kd_ply == '08'){
        //     $qq = "SELECT '999999' AS KD_SUB_JNS_PELAYANAN, 'SILAKAN PILIH' AS NM_SUB_JENIS_PELAYANAN FROM DUAL UNION ALL 
        //             SELECT KD_LOOKUP_ITEM as KD_SUB_JNS_PELAYANAN, 
        //             NM_LOOKUP_ITEM as NM_SUB_JENIS_PELAYANAN FROM LOOKUP_ITEM 
        //             WHERE KD_LOOKUP_GROUP = '90' ";
        // }

        if ($kd_sub) {
            // if ($kd_ply == '03') {
                $qq = "SELECT TRIM(KD_SUB_JNS_PELAYANAN) as KD_SUB_JNS_PELAYANAN, NM_SUB_JENIS_PELAYANAN FROM REF_SUB_JNS_PELAYANAN 
                    WHERE KD_JNS_PELAYANAN IN {$kd_ply} AND KD_SUB_JNS_PELAYANAN = '$kd_sub' ";
            // } else if ($kd_ply == '08') {
            //     $qq = "SELECT KD_LOOKUP_ITEM as KD_SUB_JNS_PELAYANAN, 
            //         NM_LOOKUP_ITEM as NM_SUB_JENIS_PELAYANAN FROM LOOKUP_ITEM 
            //         WHERE KD_LOOKUP_GROUP = '90' AND KD_LOOKUP_ITEM = '$kd_sub' ";
            // }
            
        }
        // $qq = "SELECT * FROM REF_JNS_PELAYANAN  ";
        return $this->db->query($qq)->result();
    }

    function get_lookup_item($group = null) {     
        $qq = "SELECT * FROM LOOKUP_ITEM  ";       
        if ($group != null) {
            $qq .= " WHERE KD_LOOKUP_GROUP = '{$group}'";
        } 
        return $this->db->query($qq)->result();
    }

    function cek_nop_reg_esppt($nop) {
        $nop     = str_replace(".", "", $nop);
        $nop     = str_replace("-", "", $nop);
        $kd_prop = substr($nop, 0, 2);
        $kd_dati = substr($nop, 2, 2);
        $kd_kec  = substr($nop, 4, 3);
        $kd_kel  = substr($nop, 7, 3);
        $kd_blok = substr($nop, 10, 3);
        $no_urut = substr($nop, 13, 4);
        $kd_jns_op = substr($nop, 17, 1);

        $sql = "SELECT REG_USERS.*, KD_PROPINSI||KD_DATI2||KD_KECAMATAN||KD_KELURAHAN||KD_BLOK||NO_URUT||KD_JNS_OP as NOPLKP,
                KD_PROPINSI||KD_DATI2||KD_KECAMATAN||KD_KELURAHAN||KD_BLOK||NO_URUT||KD_JNS_OP||TRIM(NIK) as NOPNIK
                FROM REG_USERS 
                WHERE KD_PROPINSI = '{$kd_prop}' AND KD_DATI2 = '{$kd_dati}' AND KD_KECAMATAN = '{$kd_kec}' 
                AND KD_KELURAHAN = '{$kd_kel}' AND KD_BLOK = '{$kd_blok}' AND NO_URUT = '{$no_urut}'
                AND KD_JNS_OP = '{$kd_jns_op}' ";
        
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0){
            return $query->row();
        } else { 
            return FALSE;
        }
    }

    function cek_nop_reg_esppt_bynopnik($nopnik) {

        $sql = "SELECT REG_USERS.*, KD_PROPINSI||KD_DATI2||KD_KECAMATAN||KD_KELURAHAN||KD_BLOK||NO_URUT||KD_JNS_OP as NOPLKP,
                KD_PROPINSI||KD_DATI2||KD_KECAMATAN||KD_KELURAHAN||KD_BLOK||NO_URUT||KD_JNS_OP||TRIM(NIK) as NOPNIK
                FROM REG_USERS 
                WHERE KD_PROPINSI||KD_DATI2||KD_KECAMATAN||KD_KELURAHAN||KD_BLOK||NO_URUT||KD_JNS_OP||TRIM(NIK) = '{$nopnik}' ";
        
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0){
            return $query->row();
        } else { 
            return FALSE;
        }
    }

    function update_reg_esppt_bynopnik($data, $nopnik) {

        $this->db->where("KD_PROPINSI||KD_DATI2||KD_KECAMATAN||KD_KELURAHAN||KD_BLOK||NO_URUT||KD_JNS_OP||TRIM(NIK)=", $nopnik, FALSE);
        $this->db->update('REG_USERS', $data);

        return $this->db->affected_rows() > 0;
    }

    function cek_secuser($nik) {

        $sql = "SELECT *
                FROM SEC_USERS 
                WHERE USERID = '{$nik}' ";
        
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0){
            return $query->row();
        } else { 
            return FALSE;
        }
    }

    function cek_nop_dop($nop) {
        $nop     = str_replace(".", "", $nop);
        $nop     = str_replace("-", "", $nop);
        $kd_prop = substr($nop, 0, 2);
        $kd_dati = substr($nop, 2, 2);
        $kd_kec  = substr($nop, 4, 3);
        $kd_kel  = substr($nop, 7, 3);
        $kd_blok = substr($nop, 10, 3);
        $no_urut = substr($nop, 13, 4);
        $kd_jns_op = substr($nop, 17, 1);

        $sql = "SELECT DSP.*, TRIM(DOP.SUBJEK_PAJAK_ID) as NIK,
                DOP.KD_PROPINSI||DOP.KD_DATI2||DOP.KD_KECAMATAN||DOP.KD_KELURAHAN||DOP.KD_BLOK||DOP.NO_URUT||DOP.KD_JNS_OP||TRIM(DOP.SUBJEK_PAJAK_ID) as NOPNIK,
                DOP.KD_PROPINSI||'.'||DOP.KD_DATI2||'.'||DOP.KD_KECAMATAN||'.'||DOP.KD_KELURAHAN||'.'||DOP.KD_BLOK||'.'||DOP.NO_URUT||'.'||DOP.KD_JNS_OP as NOP_LKP, 
                DOP.JALAN_OP, DOP.BLOK_KAV_NO_OP, DOP.RW_OP, DOP.RT_OP,
                DOP.KD_STATUS_CABANG, DOP.KD_STATUS_WP,
                DOP.TOTAL_LUAS_BUMI, DOP.TOTAL_LUAS_BNG,
                DOP.NJOP_BUMI, DOP.NJOP_BNG 
                FROM DAT_SUBJEK_PAJAK DSP
                JOIN DAT_OBJEK_PAJAK DOP ON DSP.SUBJEK_PAJAK_ID = DOP.SUBJEK_PAJAK_ID
                WHERE DOP.KD_PROPINSI = '{$kd_prop}' AND DOP.KD_DATI2 = '{$kd_dati}' AND DOP.KD_KECAMATAN = '{$kd_kec}' 
                AND DOP.KD_KELURAHAN = '{$kd_kel}' AND DOP.KD_BLOK = '{$kd_blok}' AND DOP.NO_URUT = '{$no_urut}'
                AND DOP.KD_JNS_OP = '{$kd_jns_op}' ";
        //var_dump($sql);die;
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0){
            return $query->row();
        } else { 
            return FALSE;
        }
    }

    function get_objek_pajak($nop) {
        $nop     = str_replace(".", "", $nop);
        $nop     = str_replace("-", "", $nop);
        $kd_prop = substr($nop, 0, 2);
        $kd_dati = substr($nop, 2, 2);
        $kd_kec  = substr($nop, 4, 3);
        $kd_kel  = substr($nop, 7, 3);
        $kd_blok = substr($nop, 10, 3);
        $no_urut = substr($nop, 13, 4);
        $kd_jns_op = substr($nop, 17, 1);

        $sql = "SELECT DSP.*, TRIM(DOP.SUBJEK_PAJAK_ID) as NIK,
                DOP.KD_PROPINSI||DOP.KD_DATI2||DOP.KD_KECAMATAN||DOP.KD_KELURAHAN||DOP.KD_BLOK||DOP.NO_URUT||DOP.KD_JNS_OP||TRIM(DOP.SUBJEK_PAJAK_ID) as NOPNIK,
                DOP.KD_PROPINSI||'.'||DOP.KD_DATI2||'.'||DOP.KD_KECAMATAN||'.'||DOP.KD_KELURAHAN||'.'||DOP.KD_BLOK||'.'||DOP.NO_URUT||'.'||DOP.KD_JNS_OP as NOP_LKP, 
                DOP.JALAN_OP, DOP.BLOK_KAV_NO_OP, DOP.RW_OP, DOP.RT_OP,
                DOP.KD_STATUS_CABANG, DOP.KD_STATUS_WP,
                DOP.TOTAL_LUAS_BUMI, DOP.TOTAL_LUAS_BNG,
                DOP.NJOP_BUMI, DOP.NJOP_BNG, BM.KD_ZNT, BM.LUAS_BUMI, BM.JNS_BUMI
                FROM DAT_SUBJEK_PAJAK DSP
                JOIN DAT_OBJEK_PAJAK DOP ON DSP.SUBJEK_PAJAK_ID = DOP.SUBJEK_PAJAK_ID
                JOIN DAT_OP_BUMI BM ON BM.KD_PROPINSI=DOP.KD_PROPINSI AND BM.KD_DATI2=DOP.KD_DATI2 AND BM.KD_KECAMATAN=DOP.KD_KECAMATAN AND BM.KD_KELURAHAN=DOP.KD_KELURAHAN 
                    AND BM.KD_BLOK=DOP.KD_BLOK AND BM.NO_URUT=DOP.NO_URUT AND BM.KD_JNS_OP=DOP.KD_JNS_OP
                WHERE DOP.KD_PROPINSI = '{$kd_prop}' AND DOP.KD_DATI2 = '{$kd_dati}' AND DOP.KD_KECAMATAN = '{$kd_kec}' 
                AND DOP.KD_KELURAHAN = '{$kd_kel}' AND DOP.KD_BLOK = '{$kd_blok}' AND DOP.NO_URUT = '{$no_urut}'
                AND DOP.KD_JNS_OP = '{$kd_jns_op}' ";
        //var_dump($sql);die;
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0){
            return $query->row();
        } else { 
            return FALSE;
        }
    }

    function get_thn_pelayanan(){
        $qq = "select thn_pelayanan from max_urut_pst 
                where thn_pelayanan=(select max(cast(thn_pelayanan as number)) as thn_pelayanan from max_urut_pst)";
        $q1 = $this->db->query($qq)->row();
        $thn_pelayanan = $q1->THN_PELAYANAN;
        return $thn_pelayanan;
    }

    function update_sts_permohonan($param){
        $qq = "UPDATE PST_PERMOHONAN_TOOL 
                SET STATUS_PERMOHONAN = '1' 
                WHERE ID ='{$param}'";
        $this->db->query($qq);
        return true;
    }

    function get_prm_online($id){
        // $prop_kd = substr($nop_kdply, 0, 2);
        // $kab_kd  = substr($nop_kdply, 2, 2);
        // $kec_kd  = substr($nop_kdply, 4, 3);
        // $kel_kd  = substr($nop_kdply, 7, 3);
        // $blok_kd = substr($nop_kdply, 10, 3);
        // $urut_no = substr($nop_kdply, 13, 4);
        // $jns_kd  = substr($nop_kdply, 17, 1);
        $qq = "SELECT P.NO_SRT_PERMOHONAN, P.NAMA_PEMOHON, P.ALAMAT_PEMOHON, P.KETERANGAN_PST, 
                TO_CHAR(P.TGL_SURAT_PERMOHONAN, 'DD-MM-YYYY') AS TGL_SURAT_PERMOHONAN, P.KD_JNS_PELAYANAN, P.KD_SUB_JNS_PELAYANAN,
                P.THN_PELAYANAN||P.BUNDEL_PELAYANAN||P.NO_URUT_PELAYANAN AS NO_PLY, 
                P.KD_PROPINSI_PEMOHON||P.kd_dati2_PEMOHON||P.KD_KECAMATAN_PEMOHON||P.KD_KELURAHAN_PEMOHON||P.KD_BLOK_PEMOHON||P.NO_URUT_PEMOHON||P.KD_JNS_OP_PEMOHON AS NOP, 
                P.KD_PROPINSI_PEMOHON||'.'||P.kd_dati2_PEMOHON||'-'||P.KD_KECAMATAN_PEMOHON||'.'||P.KD_KELURAHAN_PEMOHON||'-'||P.KD_BLOK_PEMOHON||'.'||P.NO_URUT_PEMOHON||'.'||P.KD_JNS_OP_PEMOHON AS NOP_LKP, 
                P.STATUS_PERMOHONAN AS STS_FLG, PL.NM_JENIS_PELAYANAN, P.ALASAN, SP.EMAIL, P.L_SKKP_PBB, P.L_SPMKP_PBB, 
                P.L_KTP_WP, P.L_SERTIFIKAT_TANAH, P.L_IMB, P.L_AKTE_JUAL_BELI, P.L_SURAT_KUASA, P.L_PERMOHONAN, P.L_STTS, 
                P.L_SK_KEBERATAN, P.L_SPPT, P.L_SPPT_STTS, P.L_SK_PENGURANGAN, P.L_LAIN_LAIN, 
                TO_CHAR(P.TGL_PERKIRAAN_SELESAI, 'DD-MM-YYYY') AS TGL_PERKIRAAN_SELESAI, 
                P.PCT_PENGURANGAN, P.PCT_PENGURANGAN_APPR, P.STS_PENGURANGAN
                FROM PST_PERMOHONAN_TOOL P 
                JOIN REG_USERS SP ON SP.ID = P.ID_REGUSER 
                AND sp.kd_kecamatan=p.kd_kecamatan_pemohon AND p.kd_kelurahan_pemohon=sp.kd_kelurahan AND p.kd_blok_pemohon=SP.KD_BLOK 
                AND sp.no_urut=p.no_urut_pemohon AND sp.kd_jns_op=p.kd_jns_op_pemohon) 
                LEFT JOIN REF_JNS_PELAYANAN PL ON PL.KD_JNS_PELAYANAN=P.KD_JNS_PELAYANAN 
                WHERE P.ID ='{$id}'";
        return $this->db->query($qq)->row();
    }

    function encript_value($login, $value) {
        $qry   = "SELECT FN_KEYLOCK('{$login}','{$value}') as FN_KEYLOCK from DUAL";
        $query = $this->db->query($qry);
        return $query->row();
    }

    public function nextid_user() {
        $qry = "SELECT PBB.sec_users_seq.NEXTVAL as NEXT_ID FROM DUAL";
        //log_message('info', "KKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK  ". $qry);
        $query = $this->db->query($qry);
        return $query->row();
    }

    public function getLampiran($kd) {
        return $this->db
            ->select("REF_LAMPIRAN_PLY.*, CASE WHEN STS_LAMPIRAN = '1' THEN 'required' ELSE ' ' END AS STS, 
                    CASE WHEN STS_LAMPIRAN = '1' THEN '<font color=\"red\"> *</font>' ELSE ' ' END AS TX_REQ", false)
            ->where('KD_JNS_PELAYANAN', $kd)
            ->get('REF_LAMPIRAN_PLY')
            ->result();
    }

    public function getLampiranSub($kd, $kdsub) {
        return $this->db
            ->select("REF_LAMPIRAN_PLY.*, CASE WHEN STS_LAMPIRAN = '1' THEN 'required' ELSE ' ' END AS STS,
                    CASE WHEN STS_LAMPIRAN = '1' THEN '<font color=\"red\"> *</font>' ELSE ' ' END AS TX_REQ", false)
            ->where('KD_JNS_PELAYANAN', $kd)
            ->where('TRIM(KD_SUB_PELAYANAN)', $kdsub)
            ->get('REF_LAMPIRAN_PLY')
            ->result();
    }

    public function update_data_permohonan_online_by_id($id, $data) {
        $this->db->where("ID", "{$id}");
        $result = $this->db->update("PST_PERMOHONAN_TOOL", $data);
        return $result;
    }

    //// detail 
    function get_bng_new($id_ppo) {
        $qry = "SELECT DAT_OP_BANGUNAN_ONLINE_SEQ.NEXTVAL AS NEXT_ID_BNG, 
                (SELECT NVL(MAX(NO_BNG),0) FROM DAT_OP_BANGUNAN_ONLINE 
                    WHERE DOCH_ID = $id_ppo) + 1 AS NEXT_NO_BNG 
                FROM DUAL";
        return $this->db->query($qry)->row();
    }


    public function get_dt_thn_ol($id_ppo, $jns) {
        $qry = "SELECT MIN(TAHUN) AS TAHUN_MIN, MAX(TAHUN) AS TAHUN_MAX
                FROM PST_THN_TOOL_OL
                WHERE DOC_ID = '{$id_ppo}' AND JENIS = {$jns}";
        $query = $this->db->query($qry);
        if ($query->num_rows()!==0) {
            return $query->row();
        } else {
            return false;
        }
    }

    function get_data_pembanding($kd_prop, $kd_dati2, $kd_kec, $kd_kel, $kd_blok, $no_urut, $kd_jns_op) {

        $sql = "SELECT 
                DSP.SUBJEK_PAJAK_ID AS NIK_WP_SPPT, DSP.NM_WP AS NM_WP_SPPT, DSP.JALAN_WP AS JLN_WP_SPPT, DSP.HP_WP AS NOHP,
                DSP.BLOK_KAV_NO_WP AS BLOK_KAV_NO_WP_SPPT, DSP.RW_WP AS RW_WP_SPPT, DSP.RT_WP AS RT_WP_SPPT,
                DSP.KELURAHAN_WP AS KELURAHAN_WP_SPPT, DSP.KOTA_WP AS KOTA_WP_SPPT, DSP.KD_POS_WP AS KD_POS_WP_SPPT,
                DSP.TELP_WP AS TELP_WP_SPPT, DSP.NPWP, DSP.STATUS_PEKERJAAN_WP, DSP.EMAIL_WP AS EMAIL_WP_SPPT,
                DOP.JALAN_OP as JLN_OP_SPPT, DOP.BLOK_KAV_NO_OP AS BLOK_KAV_NO_OP_SPPT, DOP.RW_OP AS RW_OP_SPPT,
                DOP.RT_OP AS RT_OP_SPPT, DOP.KD_STATUS_WP, DOP.TOTAL_LUAS_BUMI, DOP.TOTAL_LUAS_BNG,
                CASE WHEN DOP.TOTAL_LUAS_BNG > 0 THEN DOP.NJOP_BNG / DOP.TOTAL_LUAS_BNG ELSE 0 END AS NJOP_BNG_PERM,
                CASE WHEN DOP.TOTAL_LUAS_BUMI > 0 THEN DOP.NJOP_BUMI / DOP.TOTAL_LUAS_BUMI ELSE 0 END AS NJOP_BUMI_PERM,
                DOP.NJOP_BNG, DOP.NJOP_BUMI,
                DOBM.JNS_BUMI, DOBM.KD_ZNT
                FROM DAT_OBJEK_PAJAK DOP 
                JOIN DAT_SUBJEK_PAJAK DSP ON DSP.SUBJEK_PAJAK_ID = DOP.SUBJEK_PAJAK_ID
                JOIN DAT_OP_BUMI DOBM ON DOP.KD_PROPINSI=DOBM.KD_PROPINSI AND DOP.KD_DATI2=DOBM.KD_DATI2 AND DOP.KD_KECAMATAN=DOBM.KD_KECAMATAN
                    AND DOP.KD_KELURAHAN=DOBM.KD_KELURAHAN AND DOP.KD_BLOK=DOBM.KD_BLOK AND DOP.NO_URUT=DOBM.NO_URUT
                    AND DOP.KD_JNS_OP=DOBM.KD_JNS_OP
                WHERE DOP.KD_PROPINSI = '$kd_prop' AND DOP.KD_DATI2 = '$kd_dati2' AND DOP.KD_KECAMATAN = '$kd_kec' AND DOP.KD_KELURAHAN = '$kd_kel' 
                AND DOP.KD_BLOK = '$kd_blok' AND DOP.NO_URUT = '$no_urut' AND DOP.KD_JNS_OP = '$kd_jns_op' ";
        
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0){
            return $query->row();
        } else { 
            return FALSE;
        }
    }

    function insert_tolak($id){
        $qry = "INSERT INTO PST_PERMOHONAN_ONLINE_TOLAK (KD_KANWIL, KD_KANTOR, THN_PELAYANAN, BUNDEL_PELAYANAN, NO_URUT_PELAYANAN, 
                NO_SRT_PERMOHONAN, TGL_SURAT_PERMOHONAN, NAMA_PEMOHON, ALAMAT_PEMOHON, KETERANGAN_PST, CATATAN_PST, STATUS_KOLEKTIF, 
                TGL_TERIMA_DOKUMEN_WP, TGL_PERKIRAAN_SELESAI, NIP_PENERIMA, KD_PROPINSI_PEMOHON, KD_DATI2_PEMOHON, KD_KECAMATAN_PEMOHON, 
                KD_KELURAHAN_PEMOHON, KD_BLOK_PEMOHON, NO_URUT_PEMOHON, KD_JNS_OP_PEMOHON, KD_JNS_PELAYANAN, THN_PAJAK_PERMOHONAN, 
                NAMA_PENERIMA, CATATAN_PENYERAHAN, STATUS_SELESAI, TGL_SELESAI, KD_SEKSI_BERKAS, TGL_PENYERAHAN, NIP_PENYERAH, 
                STATUS_PERMOHONAN, NIK_PENGIRIM, HPPEMOHON, ALASAN)";
        $qry .= " SELECT KD_KANWIL, KD_KANTOR, THN_PELAYANAN, BUNDEL_PELAYANAN, NO_URUT_PELAYANAN, 
                  NO_SRT_PERMOHONAN, TGL_SURAT_PERMOHONAN, NAMA_PEMOHON, ALAMAT_PEMOHON, KETERANGAN_PST, CATATAN_PST, STATUS_KOLEKTIF, 
                  TGL_TERIMA_DOKUMEN_WP, TGL_PERKIRAAN_SELESAI, NIP_PENERIMA, KD_PROPINSI_PEMOHON, KD_DATI2_PEMOHON, KD_KECAMATAN_PEMOHON, 
                  KD_KELURAHAN_PEMOHON, KD_BLOK_PEMOHON, NO_URUT_PEMOHON, KD_JNS_OP_PEMOHON, KD_JNS_PELAYANAN, THN_PAJAK_PERMOHONAN, 
                  NAMA_PENERIMA, CATATAN_PENYERAHAN, STATUS_SELESAI, TGL_SELESAI, KD_SEKSI_BERKAS, TGL_PENYERAHAN, NIP_PENYERAH, 
                  STATUS_PERMOHONAN, NIK_PENGIRIM, NO_HP, ALASAN 
                  FROM PST_PERMOHONAN_TOOL 
                  WHERE ID='{$id}' ";
        $this->db->query($qry);
    }
    function delete_tolak($id){
        $qq = "DELETE FROM PST_PERMOHONAN_TOOl WHERE ID='{$id}' ";
        $this->db->query($qq);
    }

    //// pengurangan
    public function get_ref_pengurangan($kd) {
        return $this->db
            ->select("NM_LOOKUP_ITEM, PCT_PENGURANGAN", false)
            ->where('KD_LOOKUP_ITEM', $kd)
            ->get('LOOKUP_PCT_PENGURANGAN')
            ->row();
    }

    function get_ref_syarat_peneliti_by_idppo($id_ppo, $kd_jns_ply) {
        $qq = "SELECT R.ID, R.KET, P.STATUS, P.KETERANGAN FROM REF_SYARAT_PENELITI R 
                LEFT JOIN PST_TOOL_DTL_PNLT P ON P.ID_REF_SYARAT = R.ID AND P.ID_PPO = $id_ppo
                WHERE R.STATUS = 1 AND R.KD_JNS_PLY = '{$kd_jns_ply}' ORDER BY R.ID ";

        $xx=$this->db->query($qq);
        return $xx->result();
    }

    //// END PENGURANGAN


    //// MUTASI SEBAGIAN
    function insert_pst_mutasi_sebagian_online_head($data) {
        $va = $data;
        // var_dump($va);die();
        $kd_kanwil = $va['KD_KANWIL'];
        $kd_kantor = $va['KD_KANTOR'];
        $thn_ply = $va['THN_PELAYANAN'];
        $tahun = date('Y');
        // $kd_jpb =$va['KD_JPB'];
        // var_dump($va['JNS_BUMI']);die();
        $tgl_srt_permohonan = empty($va['TGL_SURAT_PERMOHONAN']) ? 'NULL' : "TO_DATE('" . $va['TGL_SURAT_PERMOHONAN'] . "','YYYY-MM-DD')";

        ////////////////////
        $sql = "
            BEGIN
                begin 
                    INSERT INTO MUT_DAT_SUBJEK_PAJAK_OL (DOCH_ID,NO_URUT_MUTASI,SUBJEK_PAJAK_ID,NM_WP,JALAN_WP,BLOK_KAV_NO_WP,RW_WP,RT_WP,
                    KELURAHAN_WP,KOTA_WP,KD_POS_WP,TELP_WP,NPWP,STATUS_PEKERJAAN_WP,HP_WP,EMAIL_WP)
                    SELECT " . $va['ID_PPO'] . ", 1, SP.SUBJEK_PAJAK_ID,NM_WP,JALAN_WP,BLOK_KAV_NO_WP,RW_WP,RT_WP,
                    KELURAHAN_WP,KOTA_WP,KD_POS_WP,TELP_WP,NPWP,STATUS_PEKERJAAN_WP,HP_WP,EMAIL_WP
                    FROM DAT_SUBJEK_PAJAK SP
                    JOIN DAT_OBJEK_PAJAK OP ON OP.SUBJEK_PAJAK_ID = SP.SUBJEK_PAJAK_ID 
                    WHERE OP.KD_PROPINSI||OP.KD_DATI2||OP.KD_KECAMATAN||OP.KD_KELURAHAN||OP.KD_BLOK||OP.NO_URUT||OP.KD_JNS_OP = '".$va['NOP_LKP']."'
                    ;
                    EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM);
                end;
                begin 
                    INSERT INTO MUT_DAT_OP_BANGUNAN_OL (DOCH_ID,NO_URUT_MUTASI,KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,
                    NO_BNG,KD_JPB,NO_FORMULIR_LSPOP,THN_DIBANGUN_BNG,THN_RENOVASI_BNG,LUAS_BNG,JML_LANTAI_BNG,KONDISI_BNG,JNS_KONSTRUKSI_BNG,
                    JNS_ATAP_BNG,KD_DINDING,KD_LANTAI,KD_LANGIT_LANGIT,NILAI_SISTEM_BNG,JNS_TRANSAKSI_BNG,TGL_PENDATAAN_BNG,NIP_PENDATA_BNG,
                    TGL_PEMERIKSAAN_BNG,NIP_PEMERIKSA_BNG,TGL_PEREKAMAN_BNG,NIP_PEREKAM_BNG)
                    SELECT " . $va['ID_PPO'] . ", 1, A1.*  FROM DAT_OP_BANGUNAN A1
                    WHERE A1.KD_PROPINSI||A1.KD_DATI2||A1.KD_KECAMATAN||A1.KD_KELURAHAN||A1.KD_BLOK||A1.NO_URUT||A1.KD_JNS_OP = '".$va['NOP_LKP']."'
                    ;
                    EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM);
                end;    
                begin 
                    INSERT INTO MUT_DAT_OP_BUMI_OL (DOCH_ID,NO_URUT_MUTASI,KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,
                    NO_BUMI,KD_ZNT,LUAS_BUMI,JNS_BUMI,NILAI_SISTEM_BUMI)
                    SELECT " . $va['ID_PPO'] . ", 1, A2.* FROM DAT_OP_BUMI A2
                    WHERE A2.KD_PROPINSI||A2.KD_DATI2||A2.KD_KECAMATAN||A2.KD_KELURAHAN||A2.KD_BLOK||A2.NO_URUT||A2.KD_JNS_OP = '".$va['NOP_LKP']."' 
                    ;
                    EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM);
                end;
                begin 
                    INSERT INTO MUT_DAT_OBJEK_PAJAK_OL (DOCH_ID, NO_URUT_MUTASI, KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP, 
                        SUBJEK_PAJAK_ID, NO_FORMULIR_SPOP, NO_PERSIL, JALAN_OP, BLOK_KAV_NO_OP, RW_OP, RT_OP, KD_STATUS_CABANG, KD_STATUS_WP, 
                        TOTAL_LUAS_BUMI, TOTAL_LUAS_BNG, NJOP_BUMI, NJOP_BNG, STATUS_PETA_OP, JNS_TRANSAKSI_OP, TGL_PENDATAAN_OP, NIP_PENDATA, 
                        TGL_PEMERIKSAAN_OP, NIP_PEMERIKSA_OP, TGL_PEREKAMAN_OP, NIP_PEREKAM_OP)
                    SELECT " . $va['ID_PPO'] . ", 1, A3.* FROM DAT_OBJEK_PAJAK A3
                    WHERE A3.KD_PROPINSI||A3.KD_DATI2||A3.KD_KECAMATAN||A3.KD_KELURAHAN||A3.KD_BLOK||A3.NO_URUT||A3.KD_JNS_OP = '".$va['NOP_LKP']."'
                    ;
                    EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM);
                end;
                begin 
                    INSERT INTO MUT_DAT_FASILITAS_BANGUNAN_OL (KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,
                    NO_BNG,KD_FASILITAS,JML_SATUAN,DOCD_ID)
                    SELECT A4.*, B4.ID FROM DAT_FASILITAS_BANGUNAN A4
                    LEFT JOIN MUT_DAT_OP_BANGUNAN_OL B4 ON A4.KD_PROPINSI = B4.KD_PROPINSI AND A4.KD_DATI2 = B4.KD_DATI2
                        AND A4.KD_KECAMATAN = B4.KD_KECAMATAN AND A4.KD_KELURAHAN = B4.KD_KELURAHAN AND A4.KD_BLOK = B4.KD_BLOK 
                        AND A4.NO_URUT = B4.NO_URUT AND A4.KD_JNS_OP = B4.KD_JNS_OP AND A4.NO_BNG = B4.NO_BNG  AND B4.DOCH_ID = ".$va['ID_PPO']."
                    WHERE  A4.KD_PROPINSI||A4.KD_DATI2||A4.KD_KECAMATAN||A4.KD_KELURAHAN||A4.KD_BLOK||A4.NO_URUT||A4.KD_JNS_OP = '".$va['NOP_LKP']."'
                    ;
                    EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM);
                end; 

                begin 
                    INSERT INTO MUT_DAT_NILAI_INDIVIDU_OL (DOCD_ID,KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,
                    NO_BNG,NO_FORMULIR_INDIVIDU,NILAI_INDIVIDU,TGL_PENILAIAN_INDIVIDU,NIP_PENILAI_INDIVIDU,TGL_PEMERIKSAAN_INDIVIDU,
                    NIP_PEMERIKSA_INDIVIDU,TGL_REKAM_NILAI_INDIVIDU,NIP_PEREKAM_INDIVIDU)
                    SELECT B4.ID, A4.* FROM DAT_NILAI_INDIVIDU A4
                    LEFT JOIN MUT_DAT_OP_BANGUNAN_OL B4 ON A4.KD_PROPINSI = B4.KD_PROPINSI AND A4.KD_DATI2 = B4.KD_DATI2
                        AND A4.KD_KECAMATAN = B4.KD_KECAMATAN AND A4.KD_KELURAHAN = B4.KD_KELURAHAN AND A4.KD_BLOK = B4.KD_BLOK 
                        AND A4.NO_URUT = B4.NO_URUT AND A4.KD_JNS_OP = B4.KD_JNS_OP AND A4.NO_BNG = B4.NO_BNG  AND B4.DOCH_ID = ".$va['ID_PPO']." 
                    WHERE  A4.KD_PROPINSI||A4.KD_DATI2||A4.KD_KECAMATAN||A4.KD_KELURAHAN||A4.KD_BLOK||A4.NO_URUT||A4.KD_JNS_OP = '".$va['NOP_LKP']."'
                    ;
                    EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM);
                end; 

                begin 
                    INSERT INTO MUT_DAT_JPB2_OL (KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP, NO_BNG, KLS_JPB2, DOCD_ID)
                    SELECT A4.*, B4.ID FROM DAT_JPB2 A4
                    LEFT JOIN MUT_DAT_OP_BANGUNAN_OL B4 ON A4.KD_PROPINSI = B4.KD_PROPINSI AND A4.KD_DATI2 = B4.KD_DATI2
                        AND A4.KD_KECAMATAN = B4.KD_KECAMATAN AND A4.KD_KELURAHAN = B4.KD_KELURAHAN AND A4.KD_BLOK = B4.KD_BLOK 
                        AND A4.NO_URUT = B4.NO_URUT AND A4.KD_JNS_OP = B4.KD_JNS_OP AND A4.NO_BNG = B4.NO_BNG  AND B4.DOCH_ID = ".$va['ID_PPO']." 
                    WHERE  A4.KD_PROPINSI||A4.KD_DATI2||A4.KD_KECAMATAN||A4.KD_KELURAHAN||A4.KD_BLOK||A4.NO_URUT||A4.KD_JNS_OP = '".$va['NOP_LKP']."'
                    ;
                    EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM);
                end; 

                begin 
                    INSERT INTO MUT_DAT_JPB3_OL (KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP, NO_BNG, 
                        TYPE_KONSTRUKSI, TING_KOLOM_JPB3, LBR_BENT_JPB3, LUAS_MEZZANINE_JPB3, KELILING_DINDING_JPB3, DAYA_DUKUNG_LANTAI_JPB3, DOCD_ID)
                    SELECT A4.*, B4.ID FROM DAT_JPB3 A4
                    LEFT JOIN MUT_DAT_OP_BANGUNAN_OL B4 ON A4.KD_PROPINSI = B4.KD_PROPINSI AND A4.KD_DATI2 = B4.KD_DATI2
                        AND A4.KD_KECAMATAN = B4.KD_KECAMATAN AND A4.KD_KELURAHAN = B4.KD_KELURAHAN AND A4.KD_BLOK = B4.KD_BLOK 
                        AND A4.NO_URUT = B4.NO_URUT AND A4.KD_JNS_OP = B4.KD_JNS_OP AND A4.NO_BNG = B4.NO_BNG  AND B4.DOCH_ID = ".$va['ID_PPO']." 
                    WHERE  A4.KD_PROPINSI||A4.KD_DATI2||A4.KD_KECAMATAN||A4.KD_KELURAHAN||A4.KD_BLOK||A4.NO_URUT||A4.KD_JNS_OP = '".$va['NOP_LKP']."'
                    ;
                    EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM);
                end; 

                begin 
                    INSERT INTO MUT_DAT_JPB4_OL (KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP, NO_BNG, KLS_JPB4, DOCD_ID)
                    SELECT A4.*, B4.ID FROM DAT_JPB4 A4
                    LEFT JOIN MUT_DAT_OP_BANGUNAN_OL B4 ON A4.KD_PROPINSI = B4.KD_PROPINSI AND A4.KD_DATI2 = B4.KD_DATI2
                        AND A4.KD_KECAMATAN = B4.KD_KECAMATAN AND A4.KD_KELURAHAN = B4.KD_KELURAHAN AND A4.KD_BLOK = B4.KD_BLOK 
                        AND A4.NO_URUT = B4.NO_URUT AND A4.KD_JNS_OP = B4.KD_JNS_OP AND A4.NO_BNG = B4.NO_BNG  AND B4.DOCH_ID = ".$va['ID_PPO']." 
                    WHERE  A4.KD_PROPINSI||A4.KD_DATI2||A4.KD_KECAMATAN||A4.KD_KELURAHAN||A4.KD_BLOK||A4.NO_URUT||A4.KD_JNS_OP = '".$va['NOP_LKP']."'
                    ;
                    EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM);
                end; 

                begin 
                    INSERT INTO MUT_DAT_JPB5_OL (KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP, NO_BNG, 
                        KLS_JPB5, LUAS_KMR_JPB5_DGN_AC_SENT, LUAS_RNG_LAIN_JPB5_DGN_AC_SENT, DOCD_ID)
                    SELECT A4.*, B4.ID FROM DAT_JPB5 A4
                    LEFT JOIN MUT_DAT_OP_BANGUNAN_OL B4 ON A4.KD_PROPINSI = B4.KD_PROPINSI AND A4.KD_DATI2 = B4.KD_DATI2
                        AND A4.KD_KECAMATAN = B4.KD_KECAMATAN AND A4.KD_KELURAHAN = B4.KD_KELURAHAN AND A4.KD_BLOK = B4.KD_BLOK 
                        AND A4.NO_URUT = B4.NO_URUT AND A4.KD_JNS_OP = B4.KD_JNS_OP AND A4.NO_BNG = B4.NO_BNG  AND B4.DOCH_ID = ".$va['ID_PPO']." 
                    WHERE  A4.KD_PROPINSI||A4.KD_DATI2||A4.KD_KECAMATAN||A4.KD_KELURAHAN||A4.KD_BLOK||A4.NO_URUT||A4.KD_JNS_OP = '".$va['NOP_LKP']."'
                    ;
                    EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM);
                end; 
                
                begin 
                    INSERT INTO MUT_DAT_JPB6_OL (KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP, NO_BNG, 
                        KLS_JPB6, DOCD_ID)
                    SELECT A4.*, B4.ID FROM DAT_JPB6 A4
                    LEFT JOIN MUT_DAT_OP_BANGUNAN_OL B4 ON A4.KD_PROPINSI = B4.KD_PROPINSI AND A4.KD_DATI2 = B4.KD_DATI2
                        AND A4.KD_KECAMATAN = B4.KD_KECAMATAN AND A4.KD_KELURAHAN = B4.KD_KELURAHAN AND A4.KD_BLOK = B4.KD_BLOK 
                        AND A4.NO_URUT = B4.NO_URUT AND A4.KD_JNS_OP = B4.KD_JNS_OP AND A4.NO_BNG = B4.NO_BNG  AND B4.DOCH_ID = ".$va['ID_PPO']." 
                    WHERE  A4.KD_PROPINSI||A4.KD_DATI2||A4.KD_KECAMATAN||A4.KD_KELURAHAN||A4.KD_BLOK||A4.NO_URUT||A4.KD_JNS_OP = '".$va['NOP_LKP']."'
                    ;
                    EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM);
                end; 

                begin 
                    INSERT INTO MUT_DAT_JPB7_OL (KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP, NO_BNG, 
                        JNS_JPB7, BINTANG_JPB7, JML_KMR_JPB7, LUAS_KMR_JPB7_DGN_AC_SENT, LUAS_KMR_LAIN_JPB7_DGN_AC_SENT, DOCD_ID)
                    SELECT A4.*, B4.ID FROM DAT_JPB7 A4
                    LEFT JOIN MUT_DAT_OP_BANGUNAN_OL B4 ON A4.KD_PROPINSI = B4.KD_PROPINSI AND A4.KD_DATI2 = B4.KD_DATI2
                        AND A4.KD_KECAMATAN = B4.KD_KECAMATAN AND A4.KD_KELURAHAN = B4.KD_KELURAHAN AND A4.KD_BLOK = B4.KD_BLOK 
                        AND A4.NO_URUT = B4.NO_URUT AND A4.KD_JNS_OP = B4.KD_JNS_OP AND A4.NO_BNG = B4.NO_BNG  AND B4.DOCH_ID = ".$va['ID_PPO']." 
                    WHERE  A4.KD_PROPINSI||A4.KD_DATI2||A4.KD_KECAMATAN||A4.KD_KELURAHAN||A4.KD_BLOK||A4.NO_URUT||A4.KD_JNS_OP = '".$va['NOP_LKP']."'
                    ;
                    EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM);
                end; 

                begin 
                    INSERT INTO MUT_DAT_JPB8_OL (KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP, NO_BNG, 
                        TYPE_KONSTRUKSI, TING_KOLOM_JPB8, LBR_BENT_JPB8, LUAS_MEZZANINE_JPB8, KELILING_DINDING_JPB8, DAYA_DUKUNG_LANTAI_JPB8, DOCD_ID)
                    SELECT A4.*, B4.ID FROM DAT_JPB8 A4
                    LEFT JOIN MUT_DAT_OP_BANGUNAN_OL B4 ON A4.KD_PROPINSI = B4.KD_PROPINSI AND A4.KD_DATI2 = B4.KD_DATI2
                        AND A4.KD_KECAMATAN = B4.KD_KECAMATAN AND A4.KD_KELURAHAN = B4.KD_KELURAHAN AND A4.KD_BLOK = B4.KD_BLOK 
                        AND A4.NO_URUT = B4.NO_URUT AND A4.KD_JNS_OP = B4.KD_JNS_OP AND A4.NO_BNG = B4.NO_BNG  AND B4.DOCH_ID = ".$va['ID_PPO']." 
                    WHERE  A4.KD_PROPINSI||A4.KD_DATI2||A4.KD_KECAMATAN||A4.KD_KELURAHAN||A4.KD_BLOK||A4.NO_URUT||A4.KD_JNS_OP = '".$va['NOP_LKP']."'
                    ;
                    EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM);
                end; 

                begin 
                    INSERT INTO MUT_DAT_JPB9_OL (KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP, NO_BNG, KLS_JPB9, DOCD_ID)
                    SELECT A4.*, B4.ID FROM DAT_JPB9 A4
                    LEFT JOIN MUT_DAT_OP_BANGUNAN_OL B4 ON A4.KD_PROPINSI = B4.KD_PROPINSI AND A4.KD_DATI2 = B4.KD_DATI2
                        AND A4.KD_KECAMATAN = B4.KD_KECAMATAN AND A4.KD_KELURAHAN = B4.KD_KELURAHAN AND A4.KD_BLOK = B4.KD_BLOK 
                        AND A4.NO_URUT = B4.NO_URUT AND A4.KD_JNS_OP = B4.KD_JNS_OP AND A4.NO_BNG = B4.NO_BNG  AND B4.DOCH_ID = ".$va['ID_PPO']." 
                    WHERE  A4.KD_PROPINSI||A4.KD_DATI2||A4.KD_KECAMATAN||A4.KD_KELURAHAN||A4.KD_BLOK||A4.NO_URUT||A4.KD_JNS_OP = '".$va['NOP_LKP']."'
                    ;
                    EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM);
                end; 

                begin 
                    INSERT INTO MUT_DAT_JPB12_OL (KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP, NO_BNG, TYPE_JPB12, DOCD_ID)
                    SELECT A4.*, B4.ID FROM DAT_JPB12 A4
                    LEFT JOIN MUT_DAT_OP_BANGUNAN_OL B4 ON A4.KD_PROPINSI = B4.KD_PROPINSI AND A4.KD_DATI2 = B4.KD_DATI2
                        AND A4.KD_KECAMATAN = B4.KD_KECAMATAN AND A4.KD_KELURAHAN = B4.KD_KELURAHAN AND A4.KD_BLOK = B4.KD_BLOK 
                        AND A4.NO_URUT = B4.NO_URUT AND A4.KD_JNS_OP = B4.KD_JNS_OP AND A4.NO_BNG = B4.NO_BNG  AND B4.DOCH_ID = ".$va['ID_PPO']." 
                    WHERE  A4.KD_PROPINSI||A4.KD_DATI2||A4.KD_KECAMATAN||A4.KD_KELURAHAN||A4.KD_BLOK||A4.NO_URUT||A4.KD_JNS_OP = '".$va['NOP_LKP']."'
                    ;
                    EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM);
                end; 

                begin 
                    INSERT INTO MUT_DAT_JPB13_OL (KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP, NO_BNG, 
                        KLS_JPB13, JML_JPB13, LUAS_JPB13_DGN_AC_SENT, LUAS_JPB13_LAIN_DGN_AC_SENT, DOCD_ID)
                    SELECT A4.*, B4.ID FROM DAT_JPB13 A4
                    LEFT JOIN MUT_DAT_OP_BANGUNAN_OL B4 ON A4.KD_PROPINSI = B4.KD_PROPINSI AND A4.KD_DATI2 = B4.KD_DATI2
                        AND A4.KD_KECAMATAN = B4.KD_KECAMATAN AND A4.KD_KELURAHAN = B4.KD_KELURAHAN AND A4.KD_BLOK = B4.KD_BLOK 
                        AND A4.NO_URUT = B4.NO_URUT AND A4.KD_JNS_OP = B4.KD_JNS_OP AND A4.NO_BNG = B4.NO_BNG  AND B4.DOCH_ID = ".$va['ID_PPO']." 
                    WHERE  A4.KD_PROPINSI||A4.KD_DATI2||A4.KD_KECAMATAN||A4.KD_KELURAHAN||A4.KD_BLOK||A4.NO_URUT||A4.KD_JNS_OP = '".$va['NOP_LKP']."'
                    ;
                    EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM);
                end; 

                begin 
                    INSERT INTO MUT_DAT_JPB14_OL (KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP, NO_BNG, 
                        LUAS_KANOPI_JPB14, DOCD_ID)
                    SELECT A4.*, B4.ID FROM DAT_JPB14 A4
                    LEFT JOIN MUT_DAT_OP_BANGUNAN_OL B4 ON A4.KD_PROPINSI = B4.KD_PROPINSI AND A4.KD_DATI2 = B4.KD_DATI2
                        AND A4.KD_KECAMATAN = B4.KD_KECAMATAN AND A4.KD_KELURAHAN = B4.KD_KELURAHAN AND A4.KD_BLOK = B4.KD_BLOK 
                        AND A4.NO_URUT = B4.NO_URUT AND A4.KD_JNS_OP = B4.KD_JNS_OP AND A4.NO_BNG = B4.NO_BNG  AND B4.DOCH_ID = ".$va['ID_PPO']." 
                    WHERE  A4.KD_PROPINSI||A4.KD_DATI2||A4.KD_KECAMATAN||A4.KD_KELURAHAN||A4.KD_BLOK||A4.NO_URUT||A4.KD_JNS_OP = '".$va['NOP_LKP']."'
                    ;
                    EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM);
                end; 

                begin 
                    INSERT INTO MUT_DAT_JPB15_OL (KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP, NO_BNG, 
                        LETAK_TANGKI_JPB15, KAPASITAS_TANGKI_JPB15, DOCD_ID)
                    SELECT A4.*, B4.ID FROM DAT_JPB15 A4
                    LEFT JOIN MUT_DAT_OP_BANGUNAN_OL B4 ON A4.KD_PROPINSI = B4.KD_PROPINSI AND A4.KD_DATI2 = B4.KD_DATI2
                        AND A4.KD_KECAMATAN = B4.KD_KECAMATAN AND A4.KD_KELURAHAN = B4.KD_KELURAHAN AND A4.KD_BLOK = B4.KD_BLOK 
                        AND A4.NO_URUT = B4.NO_URUT AND A4.KD_JNS_OP = B4.KD_JNS_OP AND A4.NO_BNG = B4.NO_BNG  AND B4.DOCH_ID = ".$va['ID_PPO']." 
                    WHERE  A4.KD_PROPINSI||A4.KD_DATI2||A4.KD_KECAMATAN||A4.KD_KELURAHAN||A4.KD_BLOK||A4.NO_URUT||A4.KD_JNS_OP = '".$va['NOP_LKP']."'
                    ;
                    EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM);
                end; 

                begin 
                    INSERT INTO MUT_DAT_JPB16_OL (KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP, NO_BNG, 
                        KLS_JPB16, DOCD_ID)
                    SELECT A4.*, B4.ID FROM DAT_JPB16 A4
                    LEFT JOIN MUT_DAT_OP_BANGUNAN_OL B4 ON A4.KD_PROPINSI = B4.KD_PROPINSI AND A4.KD_DATI2 = B4.KD_DATI2
                        AND A4.KD_KECAMATAN = B4.KD_KECAMATAN AND A4.KD_KELURAHAN = B4.KD_KELURAHAN AND A4.KD_BLOK = B4.KD_BLOK 
                        AND A4.NO_URUT = B4.NO_URUT AND A4.KD_JNS_OP = B4.KD_JNS_OP AND A4.NO_BNG = B4.NO_BNG  AND B4.DOCH_ID = ".$va['ID_PPO']." 
                    WHERE  A4.KD_PROPINSI||A4.KD_DATI2||A4.KD_KECAMATAN||A4.KD_KELURAHAN||A4.KD_BLOK||A4.NO_URUT||A4.KD_JNS_OP = '".$va['NOP_LKP']."'
                    ;
                    EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM);
                end; 

                COMMIT; 
            END; ";


        // var_dump($sql);die();
        $result = $this->db->simple_qry_eon_ora($sql);
        
        //
        // log_message('error', 'querynya ZZZZZZZZZZZZZZZZZZ : '.$sql);
        return $result['message'];
    }

    function insert_pst_mutasi_sebagian_online_daftar_baru($data, $urut) {
        $va = $data;
        
        $sql = "
            BEGIN
                begin 
                    INSERT INTO MUT_DAT_SUBJEK_PAJAK_OL (DOCH_ID, NO_URUT_MUTASI)
                    VALUES (" . $va['ID_PPO'] . ", " . $urut . ") ;
                    EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM);
                end;
                 
                begin 
                    INSERT INTO MUT_DAT_OP_BUMI_OL (DOCH_ID, NO_URUT_MUTASI, KD_PROPINSI, KD_DATI2)
                    VALUES (" . $va['ID_PPO'] . ", " . $urut . ", '" . $va['KD_PROPINSI'] . "', '" . $va['KD_DATI2'] . "') ;
                    EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM);
                end;
                begin 
                    INSERT INTO MUT_DAT_OBJEK_PAJAK_OL (DOCH_ID, NO_URUT_MUTASI, KD_PROPINSI, KD_DATI2)
                    VALUES (" . $va['ID_PPO'] . ", " . $urut . ", '" . $va['KD_PROPINSI'] . "', '" . $va['KD_DATI2'] . "') ;
                    EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM);
                end;

                COMMIT; 
            END; ";

        $result = $this->db->simple_qry_eon_ora($sql);
        
        return $result['message'];
    }

    function get_edit_mutasi_sebagian($p_id) {

        $qq="SELECT ROWIDTOCHAR(P.ROWID) AS ID, P.ID as ID_PPO, P.KD_KANWIL, P.KD_KANTOR, P.NO_SRT_PERMOHONAN, P.NAMA_PEMOHON, P.ALAMAT_PEMOHON, P.KETERANGAN_PST, TO_CHAR(P.TGL_SURAT_PERMOHONAN ,'DD-MM-YYYY') AS TGL_SURAT_PERMOHONAN,
        P.THN_PAJAK_PERMOHONAN,P.KD_JNS_PELAYANAN, P.THN_PELAYANAN||P.BUNDEL_PELAYANAN||P.NO_URUT_PELAYANAN AS NO_PLY, P.THN_PELAYANAN, P.BUNDEL_PELAYANAN, P.NO_URUT_PELAYANAN,
        P.KD_PROPINSI_PEMOHON||P.KD_DATI2_PEMOHON||P.KD_KECAMATAN_PEMOHON||P.KD_KELURAHAN_PEMOHON||P.KD_BLOK_PEMOHON||P.NO_URUT_PEMOHON||P.KD_JNS_OP_PEMOHON AS NOP, P.JML_MUTASI,
        P.STATUS_PERMOHONAN AS STS_FLG, PL.NM_JENIS_PELAYANAN, P.ALASAN, SP.EMAIL, P.L_SKKP_PBB, P.L_SPMKP_PBB, P.L_KTP_WP, P.L_SERTIFIKAT_TANAH, P.L_IMB, P.L_AKTE_JUAL_BELI, P.L_SURAT_KUASA, P.L_PERMOHONAN,
        P.L_STTS, P.L_SK_KEBERATAN, P.L_SPPT, P.L_SPPT_STTS, P.L_SK_PENGURANGAN, P.L_LAIN_LAIN, trim(P.KD_SUB_PELAYANAN) as JENIS_PENGURANGAN, 
        P.PCT_PENGURANGAN, P.STATUS_PERMOHONAN,P.ALASAN, P.NO_HP as HPPEMOHON,
        P.KD_PROPINSI_PEMOHON KD_PROPINSI, P.KD_DATI2_PEMOHON KD_DATI2, P.KD_KECAMATAN_PEMOHON KD_KECAMATAN, P.KD_KELURAHAN_PEMOHON KD_KELURAHAN, 
        P.KD_BLOK_PEMOHON KD_BLOK, P.NO_URUT_PEMOHON NO_URUT, P.KD_JNS_OP_PEMOHON KD_JNS_OP,
        P.KD_SUB_JNS_PELAYANAN
        FROM PST_PERMOHONAN_TOOL P
        JOIN REG_USERS SP ON SP.ID = P.ID_REGUSER
        LEFT JOIN REF_JNS_PELAYANAN PL ON PL.KD_JNS_PELAYANAN=P.KD_JNS_PELAYANAN
        WHERE P.ID ='$p_id'";
       
        return $this->db->query($qq)->row();
    }

    function get_mutasi_sebagian_online_perurut($nop, $thn_permohonan, $urut) {
        $qq="SELECT DOP.KD_PROPINSI||'.'||DOP.KD_DATI2||'.'||DOP.KD_KECAMATAN||'.'||DOP.KD_KELURAHAN||'.'||DOP.KD_BLOK||'.'||DOP.NO_URUT||'.'||DOP.KD_JNS_OP as FNOP,
        DOP.KD_KECAMATAN, DOP.JALAN_OP,RK.NM_KECAMATAN ,DOP.RT_OP ,DOP.RW_OP ,RK2.NM_KELURAHAN,DSP.NM_WP,DSP.JALAN_WP,DSP.RT_WP ,DSP.RW_WP,
        DSP.TELP_WP,DSP.KOTA_WP,DSP.EMAIL_WP, DSP.HP_WP, DSP.BLOK_KAV_NO_WP, DSP.KELURAHAN_WP, DSP.KD_POS_WP, DSP.STATUS_PEKERJAAN_WP, DSP.NPWP,
        DOB.LUAS_BUMI ,DOB.KD_ZNT,DOB.JNS_BUMI ,DOC.NO_BNG ,DOC.LUAS_BNG ,DOC.JML_LANTAI_BNG, DOP.BLOK_KAV_NO_OP,
        DOC.THN_DIBANGUN_BNG ,DOC.THN_RENOVASI_BNG ,DOC.KONDISI_BNG ,DSP.SUBJEK_PAJAK_ID, DOC.KD_JPB,
        DOC.JNS_KONSTRUKSI_BNG ,DOC.KD_LANTAI ,DOC.KD_LANGIT_LANGIT ,DOC.KD_DINDING ,DOC.JNS_ATAP_BNG , DOP.KD_STATUS_WP,
        DSP.ID ID_MUT_DSP, DOP.ID ID_MUT_DOP, DOB.ID ID_MUT_DOB
        FROM PST_PERMOHONAN_TOOL re
        JOIN MUT_DAT_OBJEK_PAJAK_OL DOP ON DOP.DOCH_ID = RE.ID AND DOP.NO_URUT_MUTASI = $urut
        JOIN MUT_DAT_SUBJEK_PAJAK_OL DSP ON DSP.DOCH_ID = RE.ID AND DSP.NO_URUT_MUTASI = $urut
        JOIN MUT_DAT_OP_BUMI_OL DOB ON DOB.DOCH_ID = RE.ID AND DOB.NO_URUT_MUTASI = $urut
        LEFT JOIN MUT_DAT_OP_BANGUNAN_OL DOC ON DOC.DOCH_ID = RE.ID AND DOC.NO_URUT_MUTASI = $urut 
        LEFT JOIN REF_KECAMATAN rk ON DOP.KD_KECAMATAN =RK.KD_KECAMATAN 
        LEFT JOIN REF_KELURAHAN rk2 ON DOP.KD_KELURAHAN =RK2.KD_KELURAHAN  AND DOP.KD_KECAMATAN =RK2.KD_KECAMATAN
        WHERE RE.KD_PROPINSI_PEMOHON||RE.KD_DATI2_PEMOHON||RE.KD_KECAMATAN_PEMOHON||RE.KD_KELURAHAN_PEMOHON||RE.KD_BLOK_PEMOHON||RE.NO_URUT_PEMOHON||RE.KD_JNS_OP_PEMOHON='$nop' 
        AND RE.THN_PELAYANAN='$thn_permohonan' AND RE.KD_JNS_PELAYANAN='19' ";
        // $qq = "SELECT * FROM PST_PEMBETULAN_ONLINE WHERE KD_PROPINSI||KD_DATI2||KD_KECAMATAN||KD_KELURAHAN||KD_BLOK||NO_URUT||KD_JNS_OP='$nop' AND THN_PERMOHONAN='$thn_permohonan' ";
        $xx = $this->db->query($qq);
        return $xx->row();
    }

    function select_znt($kd_prop, $kd_dati2, $kd_kec, $kd_kel, $kd_blok){
        $qq = "SELECT * FROM DAT_PETA_ZNT WHERE KD_PROPINSI='$kd_prop' AND KD_DATI2='$kd_dati2'
                AND KD_KECAMATAN='$kd_kec' AND KD_KELURAHAN='$kd_kel' AND KD_BLOK='$kd_blok' ";
        
        $xx=$this->db->query($qq);
        return $xx->result();
    }

    function get_select_by_nop($nop) {
        $sql = "SELECT DISTINCT
        REG.kd_propinsi||'.'||REG.kd_dati2||'-'||REG.kd_kecamatan||'.'||REG.kd_kelurahan ||'-'||
        REG.kd_blok ||'.'||REG.no_urut||'.'|| REG.kd_jns_op as NOP, REG.kd_propinsi||REG.kd_dati2||REG.kd_kecamatan||REG.kd_kelurahan||REG.kd_blok||REG.no_urut||REG.kd_jns_op as NOP_VAL
        FROM REG_USERS REG WHERE REG.STATUS='1' 
        AND REG.kd_propinsi||REG.kd_dati2||REG.kd_kecamatan||REG.kd_kelurahan||REG.kd_blok||REG.no_urut||REG.kd_jns_op = '{$nop}'";
        

        // $query = $this->db->query($sql); //200
        $query = $this->db->query($sql);///ORIII//
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    function getdt_tbl_mutasi_sebagian($id_ppo, $id_mut_dsp, $tbl) {
        $qq="SELECT * FROM $tbl
             WHERE ID = $id_mut_dsp AND DOCH_ID = $id_ppo";
        
        return $this->db->query($qq)->row();
    }

    function get_dtl_bng_mutasi_sebagian($id_dtl) {
        $qry = "SELECT DOB.*, KLS_JPB2, 
                TING_KOLOM_JPB3, DAYA_DUKUNG_LANTAI_JPB3, LBR_BENT_JPB3, KELILING_DINDING_JPB3, LUAS_MEZZANINE_JPB3, J03.TYPE_KONSTRUKSI AS TYPE_KONSTRUKSI_JPB3,
                KLS_JPB4, KLS_JPB5, LUAS_KMR_JPB5_DGN_AC_SENT, LUAS_RNG_LAIN_JPB5_DGN_AC_SENT, KLS_JPB6,
                JNS_JPB7, BINTANG_JPB7, JML_KMR_JPB7, LUAS_KMR_JPB7_DGN_AC_SENT, LUAS_KMR_LAIN_JPB7_DGN_AC_SENT,
                TING_KOLOM_JPB8, DAYA_DUKUNG_LANTAI_JPB8, LBR_BENT_JPB8, KELILING_DINDING_JPB8, LUAS_MEZZANINE_JPB8, J08.TYPE_KONSTRUKSI AS TYPE_KONSTRUKSI_JPB8,
                KLS_JPB9, TYPE_JPB12, KLS_JPB13, JML_JPB13, LUAS_JPB13_DGN_AC_SENT, LUAS_JPB13_LAIN_DGN_AC_SENT,
                LUAS_KANOPI_JPB14, LETAK_TANGKI_JPB15, KAPASITAS_TANGKI_JPB15, KLS_JPB16
                FROM MUT_DAT_OP_BANGUNAN_OL DOB
                LEFT JOIN MUT_DAT_JPB2_OL J02 ON DOB.ID = J02.DOCD_ID 
                LEFT JOIN MUT_DAT_JPB3_OL J03 ON DOB.ID = J03.DOCD_ID 
                LEFT JOIN MUT_DAT_JPB4_OL J04 ON DOB.ID = J04.DOCD_ID 
                LEFT JOIN MUT_DAT_JPB5_OL J05 ON DOB.ID = J05.DOCD_ID 
                LEFT JOIN MUT_DAT_JPB6_OL J06 ON DOB.ID = J06.DOCD_ID 
                LEFT JOIN MUT_DAT_JPB7_OL J07 ON DOB.ID = J07.DOCD_ID 
                LEFT JOIN MUT_DAT_JPB8_OL J08 ON DOB.ID = J08.DOCD_ID 
                LEFT JOIN MUT_DAT_JPB9_OL J09 ON DOB.ID = J09.DOCD_ID 
                LEFT JOIN MUT_DAT_JPB12_OL J12 ON DOB.ID = J12.DOCD_ID 
                LEFT JOIN MUT_DAT_JPB13_OL J13 ON DOB.ID = J13.DOCD_ID 
                LEFT JOIN MUT_DAT_JPB14_OL J14 ON DOB.ID = J14.DOCD_ID 
                LEFT JOIN MUT_DAT_JPB15_OL J15 ON DOB.ID = J15.DOCD_ID 
                LEFT JOIN MUT_DAT_JPB16_OL J16 ON DOB.ID = J16.DOCD_ID 
                WHERE DOB.ID = {$id_dtl}";
        return $this->db->query($qry)->row();
    }

    function get_bng_new_mutasi_sebagian($id_ppo, $urut_mutasi) {

        $qry = "SELECT MUT_DAT_OP_BANGUNAN_OL_SEQ.NEXTVAL AS NEXT_ID_BNG, 
                (SELECT NVL(MAX(NO_BNG),0) FROM MUT_DAT_OP_BANGUNAN_OL 
                    WHERE DOCH_ID = $id_ppo
                    AND NO_URUT_MUTASI = $urut_mutasi) + 1 AS NEXT_NO_BNG 
                FROM DUAL";
                
        return $this->db->query($qry)->row();
    }




    //// END MUTASI SEBAGIAN

    function update_pst_permohonan_tool($id, $data){
        $this->db->where('ID', $id);
        $this->db->update('PST_PERMOHONAN_TOOL',$data);
    }


    //// send email tolak... taro sini ajah biar bisa dipangggil dimana mana wkkwwk
    public function send_email_tolak($id_ppo, $keterangan) {
        if ($get = $this->load->model('permohonan_online_upt_model')->get_ppo_by_id($id_ppo)) {
            $nopel = $get->NOPEL;
            $nama_pemohon = $get->NAMA_WP_REG;
            $email_wp = $get->EMAIL_REG;

            $config = array(
                'protocol' => SMTP_PROTOCOL,
                'smtp_host' => SMTP_HOST, //sesuaikan dengan host pengirim
                'smtp_port' => SMTP_PORT,
                'smtp_timeout' => 20,
                'smtp_user' => SMTP_USER, //sesuaikan dengan email yg dipakai
                'smtp_pass' => SMTP_PASS, //password host
                'smtp_username' => SMTP_UNAME,
                'mailtype' => SMTP_TYPE,
                'charset' => SMTP_CHARSET,
                'wordwrap' => true,
                'smtp_crypto' => SMTP_CRYPTO,
            );
            
            $message = '
                    <html>
                    <head>
                        <title>Pemberitahuan Permohonan PBB Online</title>
                    </head>
                    <body style="font-family: Arial, sans-serif; background-color: #f6f9fc; margin: 0; padding: 20px;">
                        <table align="center" cellpadding="0" cellspacing="0" width="600" 
                               style="background-color: #ffffff; border-radius: 8px; 
                                      box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                            <tr>
                                <td style="background-color: #d9534f; padding: 16px; 
                                           border-radius: 8px 8px 0 0; 
                                           text-align: center; color: #ffffff;">
                                    <h2 style="margin: 0;">PERMOHONAN PBB ONLINE TIDAK DAPAT DIPROSES</h2>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 30px; font-size: 15px; color: #444;">
                                    <p>Hai <strong>'.$nama_pemohon.'</strong>,</p>

                                    <p style="line-height: 1.6;">
                                        Mohon maaf, permohonan PBB Online Anda dengan 
                                        <strong>Nomor Pelayanan: '.$nopel.'</strong> 
                                        perlu perbaikan sebagai berikut:
                                    </p>

                                    <blockquote style="background: #f9e2e2; padding: 12px 18px; 
                                                       border-left: 4px solid #d9534f; 
                                                       color: #b52b27; border-radius: 4px;">
                                        '.$keterangan.'
                                    </blockquote>

                                    <p style="line-height: 1.6;">
                                        Silakan lakukan perbaikan data dan pastikan seluruh berkas yang dilampirkan telah lengkap.
                                    </p>
                                    <p style="line-height: 1.6;">
                                        Akses url berikut ini <a href="https://pbb.bogorkab.go.id">pbb.bogorkab.go.id</a>
                                    </p>

                                    <p>Terima kasih.</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="background-color: #f0f0f0; text-align: center; 
                                           padding: 15px; font-size: 13px; color: #999; 
                                           border-radius: 0 0 8px 8px;">
                                    &copy; '.date('Y').' Bappenda Kabupaten Bogor
                                </td>
                            </tr>

                        </table>
                    </body>
                    </html>';

            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from(SMTP_USER, SMTP_UNAME);
            $this->email->to($email_wp);
            $this->email->subject('Tolak Permohonan Online ('.$nopel.')');
            $this->email->message($message);

            if ($this->email->send()) {
                return true;
            } else {
                return false;
            }
        }

        return false;
    }


    //// GET NEXT PEGAWAI LOOPING
    function get_next_pegawai($jns_bidang, $jns_ply = null, $sub_jns_ply = null) {
        $wh_jns_ply     = "";
        $wh_sub_jns_ply = "";

        if ($jns_ply) {
            $wh_jns_ply = " AND KD_JNS_PELAYANAN = '{$jns_ply}' ";
        }

        if ($sub_jns_ply) {
            $wh_sub_jns_ply = " AND KD_SUB_JNS_PELAYANAN = '{$sub_jns_ply}' ";
        }

        $qry  = " SELECT NVL(X1.ID, X2.ID) ID, NVL(X1.NIP, X2.NIP) NIP, NVL(X1.NAMA_PEGAWAI, X2.NAMA_PEGAWAI) NAMA_PEGAWAI
                    FROM (
                        SELECT PO1.* FROM REF_PENELITI_PEGAWAI PO1 
                        WHERE ENABLE = 1 AND JNS_BIDANG = '{$jns_bidang}' 
                        $wh_jns_ply
                        $wh_sub_jns_ply 
                        AND ROWNUM = 1 ORDER BY ID ASC
                    ) X2
                    LEFT JOIN (
                        SELECT PO.*
                        FROM REF_PENELITI_PEGAWAI PO
                        WHERE ID > (SELECT ID
                                    FROM REF_PENELITI_PEGAWAI
                                    WHERE ENABLE = 1 AND STS = 1 AND JNS_BIDANG = '{$jns_bidang}' 
                                    $wh_jns_ply
                                    $wh_sub_jns_ply
                                    )
                        AND ENABLE = 1  AND STS = 0 AND JNS_BIDANG = '{$jns_bidang}' 
                        $wh_jns_ply
                        $wh_sub_jns_ply
                        AND ROWNUM = 1
                        ORDER BY ID ASC
                    ) X1 ON 1=1";

        $query = $this->db->query($qry);
        if ($query->num_rows()!==0) {
            return $query->row();
        } else {
            return (object) [
                'ID'           => null,
                'NIP'          => null,
                'NAMA_PEGAWAI' => null
            ];
        }
    }

    function set_next_pegawai($id_ref_pgw, $jns_bidang, $jns_ply = null, $sub_jns_ply = null) {
        $wh_jns_ply     = "";
        $wh_sub_jns_ply = "";

        if ($jns_ply) {
            $wh_jns_ply = " AND KD_JNS_PELAYANAN = '{$jns_ply}' ";
        }

        if ($sub_jns_ply) {
            $wh_sub_jns_ply = " AND KD_SUB_JNS_PELAYANAN = '{$sub_jns_ply}' ";
        }

        $sql1 = "UPDATE REF_PENELITI_PEGAWAI SET STS = 0 
                 WHERE JNS_BIDANG = '{$jns_bidang}' 
                 $wh_jns_ply
                 $wh_sub_jns_ply ";

        $trans1 = $this->db->query($sql1);

        $sql2 = "UPDATE REF_PENELITI_PEGAWAI SET STS = 1 
                 WHERE ID = {$id_ref_pgw} ";
        $trans2 = $this->db->query($sql2);

        // return $trans2;

        return true;
    }

    //// khusus untuk penetapan
    function get_next_pegawai_penetapan($jns_bidang, $jns_ply = null, $sub_jns_ply = null) {
        $wh_jns_ply     = "";
        $wh_sub_jns_ply = "";

        if ($jns_ply) {
            $wh_jns_ply = " AND KD_JNS_PELAYANAN = '{$jns_ply}' ";
        }

        if ($sub_jns_ply) {
            $wh_sub_jns_ply = " AND KD_SUB_JNS_PELAYANAN = '{$sub_jns_ply}' ";
        }

        $qry  = " SELECT A.ID, A.NIP, A.NAMA_PEGAWAI, B.ID AS ID_ATASAN, B.NIP AS NIP_ATASAN, B.NAMA_PEGAWAI AS NAMA_ATASAN
                  FROM (
                      SELECT NVL(X1.ID, X2.ID) ID, NVL(X1.NIP, X2.NIP) NIP, NVL(X1.ID_ROOT, X2.ID_ROOT) ID_ROOT,
                      NVL(X1.NAMA_PEGAWAI, X2.NAMA_PEGAWAI) NAMA_PEGAWAI
                        FROM (
                            SELECT PO1.* FROM REF_PENELITI_PEGAWAI PO1 
                            WHERE ENABLE = 1 AND JNS_BIDANG = '{$jns_bidang}' 
                            $wh_jns_ply
                            $wh_sub_jns_ply 
                            AND ROWNUM = 1 ORDER BY ID ASC
                        ) X2
                        LEFT JOIN (
                            SELECT PO.*
                            FROM REF_PENELITI_PEGAWAI PO
                            WHERE ID > (SELECT ID
                                        FROM REF_PENELITI_PEGAWAI
                                        WHERE ENABLE = 1 AND STS = 1 AND JNS_BIDANG = '{$jns_bidang}' 
                                        $wh_jns_ply
                                        $wh_sub_jns_ply
                                        )
                            AND ENABLE = 1  AND STS = 0 AND JNS_BIDANG = '{$jns_bidang}' 
                            $wh_jns_ply
                            $wh_sub_jns_ply
                            AND ROWNUM = 1
                            ORDER BY ID ASC
                        ) X1 ON 1=1
                    ) A 
                    JOIN REF_PENELITI_PEGAWAI B ON A.ID_ROOT = B.ID";

        $query = $this->db->query($qry);
        if ($query->num_rows()!==0) {
            return $query->row();
        } else {
            return (object) [
                'ID'           => null,
                'NIP'          => null,
                'NAMA_PEGAWAI' => null,
                'ID_ATASAN'    => null,
                'NIP_ATASAN'   => null,
                'NAMA_ATASAN'  => null
            ];
        }
    }

    //// GET NEXT PEGAWAI LOOPING

    //// punya ican
    
    function get_tracking_by_id($id) {

        $sql = "SELECT 
                A.NIP_APR_LOKET,
                B.NAMA        AS NAMA_APR_LOKET,
                A.NIP_VER_PDL,
                C.NAMA        AS NAMA_VER_PDL,
                A.NIP_SUBID_PDL,
                D.NAMA        AS NAMA_SUBID_PDL,
                A.NIP_BID_PDL,
                E.NAMA        AS NAMA_BID_PDL,
                A.NIP_KOOR_PKP,
                F.NAMA        AS NAMA_KOOR_PKP,
                A.NIP_VER_PKP,
                G.NAMA        AS NAMA_VER_PKP,
                A.NIP_SUBID_PKP,
                H.NAMA        AS NAMA_SUBID_PKP,
                A.NIP_BID_PKP,
                I.NAMA        AS NAMA_BID_PKP,
                A.NIP_VER_PNTP,
                J.NAMA        AS NAMA_VER_PNTP,
                A.NIP_BID_PNPT,
                K.NAMA        AS NAMA_BID_PNPT,
				A.NIP_KABAN,
                L.NAMA        AS NAMA_KABAN,
                TO_CHAR(TO_TIMESTAMP(A.TGL_APR_LOKET,  'DD-MM-YYYY HH24.MI.SS,FF6'), 'DD fmMonth YYYY') AS TGL_APR_LOKET,
                TO_CHAR(TO_TIMESTAMP(A.TGL_VER_PDL,    'DD-MM-YYYY HH24.MI.SS,FF6'), 'DD fmMonth YYYY') AS TGL_VER_PDL,
                TO_CHAR(TO_TIMESTAMP(A.TGL_SUBID_PDL,  'DD-MM-YYYY HH24.MI.SS,FF6'), 'DD fmMonth YYYY') AS TGL_SUBID_PDL,
                TO_CHAR(TO_TIMESTAMP(A.TGL_BID_PDL,    'DD-MM-YYYY HH24.MI.SS,FF6'), 'DD fmMonth YYYY') AS TGL_BID_PDL,
                TO_CHAR(TO_TIMESTAMP(A.TGL_KOOR_PKP,   'DD-MM-YYYY HH24.MI.SS,FF6'), 'DD fmMonth YYYY') AS TGL_KOOR_PKP,
                TO_CHAR(TO_TIMESTAMP(A.TGL_VER_PKP,    'DD-MM-YYYY HH24.MI.SS,FF6'), 'DD fmMonth YYYY') AS TGL_VER_PKP,
                TO_CHAR(TO_TIMESTAMP(A.TGL_SUBID_PKP,  'DD-MM-YYYY HH24.MI.SS,FF6'), 'DD fmMonth YYYY') AS TGL_SUBID_PKP,
                TO_CHAR(TO_TIMESTAMP(A.TGL_BID_PKP,    'DD-MM-YYYY HH24.MI.SS,FF6'), 'DD fmMonth YYYY') AS TGL_BID_PKP,
                TO_CHAR(TO_TIMESTAMP(A.TGL_VER_PNTP,   'DD-MM-YYYY HH24.MI.SS,FF6'), 'DD fmMonth YYYY') AS TGL_VER_PNTP,
                TO_CHAR(TO_TIMESTAMP(A.TGL_BID_PNTP,   'DD-MM-YYYY HH24.MI.SS,FF6'), 'DD fmMonth YYYY') AS TGL_BID_PNTP,
				TO_CHAR(TO_TIMESTAMP(A.TGL_KABAN,      'DD-MM-YYYY HH24.MI.SS,FF6'), 'DD fmMonth YYYY') AS TGL_KABAN
                FROM PST_PERMOHONAN_TOOL A
                LEFT JOIN SEC_USERS B ON TRIM(B.NIP) = TRIM(A.NIP_APR_LOKET)
                LEFT JOIN SEC_USERS C ON TRIM(C.NIP) = TRIM(A.NIP_VER_PDL)
                LEFT JOIN SEC_USERS D ON TRIM(D.NIP) = TRIM(A.NIP_SUBID_PDL)
                LEFT JOIN SEC_USERS E ON TRIM(E.NIP) = TRIM(A.NIP_BID_PDL)
                LEFT JOIN SEC_USERS F ON TRIM(F.NIP) = TRIM(A.NIP_KOOR_PKP)
                LEFT JOIN SEC_USERS G ON TRIM(G.NIP) = TRIM(A.NIP_VER_PKP)
                LEFT JOIN SEC_USERS H ON TRIM(H.NIP) = TRIM(A.NIP_SUBID_PKP)
                LEFT JOIN SEC_USERS I ON TRIM(I.NIP) = TRIM(A.NIP_BID_PKP)
                LEFT JOIN SEC_USERS J ON TRIM(J.NIP) = TRIM(A.NIP_VER_PNTP)
                LEFT JOIN SEC_USERS K ON TRIM(K.NIP) = TRIM(A.NIP_BID_PNPT)
				LEFT JOIN SEC_USERS L ON TRIM(L.NIP) = TRIM(A.NIP_KABAN)
                WHERE A.ID = '{$id}' ";
        
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0){
            return $query->row();
        } else { 
            return FALSE;
        }
    }

    function get_dt_spop_lspop($nop) {
        $nop     = str_replace(".", "", $nop);
        $nop     = str_replace("-", "", $nop);
        $kd_prop = substr($nop, 0, 2);
        $kd_dati = substr($nop, 2, 2);
        $kd_kec  = substr($nop, 4, 3);
        $kd_kel  = substr($nop, 7, 3);
        $kd_blok = substr($nop, 10, 3);
        $no_urut = substr($nop, 13, 4);
        $kd_jns_op = substr($nop, 17, 1);

        $sql = "SELECT 
                DOP.KD_PROPINSI||'.'||DOP.KD_DATI2||'-'||DOP.KD_KECAMATAN||'.'||DOP.KD_KELURAHAN||'-'||DOP.KD_BLOK||'.'||DOP.NO_URUT||'.'||DOP.KD_JNS_OP AS NOP_LKP,
                DOP.KD_PROPINSI||DOP.KD_DATI2||DOP.KD_KECAMATAN||DOP.KD_KELURAHAN||DOP.KD_BLOK||DOP.NO_URUT||DOP.KD_JNS_OP AS NOP,
                DOP.KD_PROPINSI, DOP.KD_DATI2, DOP.KD_KECAMATAN, DOP.KD_KELURAHAN, DOP.KD_BLOK, DOP.NO_URUT, DOP.KD_JNS_OP,
                TRIM(DSP.SUBJEK_PAJAK_ID) AS NIK_WP_SPPT, DSP.NM_WP AS NM_WP_SPPT, DSP.JALAN_WP AS JLN_WP_SPPT, TRIM(DSP.HP_WP) AS NOHP,
                DSP.BLOK_KAV_NO_WP AS BLOK_KAV_NO_WP_SPPT, DSP.RW_WP AS RW_WP_SPPT, DSP.RT_WP AS RT_WP_SPPT,
                DSP.KELURAHAN_WP AS KELURAHAN_WP_SPPT, DSP.KOTA_WP AS KOTA_WP_SPPT, DSP.KD_POS_WP AS KD_POS_WP_SPPT,
                DSP.TELP_WP AS TELP_WP_SPPT, DSP.NPWP, DSP.STATUS_PEKERJAAN_WP, DSP.EMAIL_WP AS EMAIL_WP_SPPT,
                DOP.JALAN_OP as JLN_OP_SPPT, DOP.BLOK_KAV_NO_OP AS BLOK_KAV_NO_OP_SPPT, DOP.RW_OP AS RW_OP_SPPT,
                DOP.RT_OP AS RT_OP_SPPT, DOP.KD_STATUS_WP, DOP.TOTAL_LUAS_BUMI, DOP.TOTAL_LUAS_BNG,
                CASE WHEN DOP.TOTAL_LUAS_BNG > 0 THEN DOP.NJOP_BNG / DOP.TOTAL_LUAS_BNG ELSE 0 END AS NJOP_BNG_PERM,
                CASE WHEN DOP.TOTAL_LUAS_BUMI > 0 THEN DOP.NJOP_BUMI / DOP.TOTAL_LUAS_BUMI ELSE 0 END AS NJOP_BUMI_PERM,
                DOP.NJOP_BNG, DOP.NJOP_BUMI,
                DOBM.JNS_BUMI, DOBM.KD_ZNT,
                DOP.NO_FORMULIR_SPOP, DOP.NO_PERSIL,
                DOP.NIP_PENDATA, TO_CHAR(DOP.TGL_PENDATAAN_OP, 'DD-MM-YYYY') AS TGL_PENDATAAN_OP,
                DOP.NIP_PEMERIKSA_OP, TO_CHAR(DOP.TGL_PEMERIKSAAN_OP, 'DD-MM-YYYY') AS TGL_PEMERIKSAAN_OP,
                DOP.NIP_PEREKAM_OP, TO_CHAR(DOP.TGL_PEREKAMAN_OP, 'DD-MM-YYYY') AS TGL_PEREKAMAN_OP,
                KEC.NM_KECAMATAN AS KECAMATAN_OP, KEL.NM_KELURAHAN AS KELURAHAN_OP
                FROM DAT_OBJEK_PAJAK DOP
                JOIN DAT_SUBJEK_PAJAK DSP ON TRIM(DSP.SUBJEK_PAJAK_ID) = TRIM(DOP.SUBJEK_PAJAK_ID)
                JOIN DAT_OP_BUMI DOBM ON DOP.KD_PROPINSI = DOBM.KD_PROPINSI AND DOP.KD_DATI2 = DOBM.KD_DATI2 AND DOP.KD_KECAMATAN = DOBM.KD_KECAMATAN 
                    AND DOP.KD_KELURAHAN = DOBM.KD_KELURAHAN AND DOP.KD_BLOK = DOBM.KD_BLOK AND DOP.NO_URUT = DOBM.NO_URUT 
                    AND DOP.KD_JNS_OP = DOBM.KD_JNS_OP
                JOIN REF_KECAMATAN KEC ON KEC.KD_PROPINSI = DOP.KD_PROPINSI AND KEC.KD_DATI2 = DOP.KD_DATI2 AND KEC.KD_KECAMATAN = DOP.KD_KECAMATAN
                JOIN REF_KELURAHAN KEL ON KEL.KD_PROPINSI = DOP.KD_PROPINSI AND KEL.KD_DATI2 = DOP.KD_DATI2 AND KEL.KD_KECAMATAN = DOP.KD_KECAMATAN
                    AND KEL.KD_KELURAHAN = DOP.KD_KELURAHAN
                WHERE DOP.KD_PROPINSI = '{$kd_prop}'
                AND DOP.KD_DATI2 = '{$kd_dati}'
                AND DOP.KD_KECAMATAN = '{$kd_kec}' 
                AND DOP.KD_KELURAHAN = '{$kd_kel}' 
                AND DOP.KD_BLOK = '{$kd_blok}' 
                AND DOP.NO_URUT = '{$no_urut}'  
                AND DOP.KD_JNS_OP = '{$kd_jns_op}' ";
        
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0){
            return $query->row();
        } else { 
            return FALSE;
        }
    }

    function get_dtl_bng_sismiop($id_dtl) {
        $nop     = str_replace(".", "", $id_dtl);
        $nop     = str_replace("-", "", $nop);
        $kd_prop = substr($nop, 0, 2);
        $kd_dati = substr($nop, 2, 2);
        $kd_kec  = substr($nop, 4, 3);
        $kd_kel  = substr($nop, 7, 3);
        $kd_blok = substr($nop, 10, 3);
        $no_urut = substr($nop, 13, 4);
        $kd_jns_op = substr($nop, 17, 1);
        $no_bng = substr($nop, 18, 1);

        $qry = "SELECT DOB.*, KLS_JPB2, TING_KOLOM_JPB3, DAYA_DUKUNG_LANTAI_JPB3, LBR_BENT_JPB3, KELILING_DINDING_JPB3, LUAS_MEZZANINE_JPB3, 
                J03.TYPE_KONSTRUKSI AS TYPE_KONSTRUKSI_JPB3, KLS_JPB4, KLS_JPB5, LUAS_KMR_JPB5_DGN_AC_SENT, LUAS_RNG_LAIN_JPB5_DGN_AC_SENT, 
                KLS_JPB6, JNS_JPB7, BINTANG_JPB7, JML_KMR_JPB7, LUAS_KMR_JPB7_DGN_AC_SENT, LUAS_KMR_LAIN_JPB7_DGN_AC_SENT,
                TING_KOLOM_JPB8, DAYA_DUKUNG_LANTAI_JPB8, LBR_BENT_JPB8, KELILING_DINDING_JPB8, LUAS_MEZZANINE_JPB8, 
                J08.TYPE_KONSTRUKSI AS TYPE_KONSTRUKSI_JPB8, KLS_JPB9, TYPE_JPB12, KLS_JPB13, JML_JPB13, 
                LUAS_JPB13_DGN_AC_SENT, LUAS_JPB13_LAIN_DGN_AC_SENT, LUAS_KANOPI_JPB14, LETAK_TANGKI_JPB15, KAPASITAS_TANGKI_JPB15, 
                KLS_JPB16, IND.NILAI_INDIVIDU,
                DOB.NIP_PENDATA_BNG, TO_CHAR(DOB.TGL_PENDATAAN_BNG, 'DD-MM-YYYY') AS TGL_PENDATAAN_BNG,
                DOB.NIP_PEMERIKSA_BNG, TO_CHAR(DOB.TGL_PEMERIKSAAN_BNG, 'DD-MM-YYYY') AS TGL_PEMERIKSAAN_BNG,
                DOB.NIP_PEREKAM_BNG, TO_CHAR(DOB.TGL_PEREKAMAN_BNG, 'DD-MM-YYYY') AS TGL_PEREKAMAN_BNG
                FROM DAT_OP_BANGUNAN DOB
                LEFT JOIN DAT_JPB2 J02 ON DOB.KD_PROPINSI = J02.KD_PROPINSI AND DOB.KD_DATI2 = J02.KD_DATI2 AND DOB.KD_KECAMATAN = J02.KD_KECAMATAN 
                    AND DOB.KD_KELURAHAN = J02.KD_KELURAHAN AND DOB.KD_BLOK = J02.KD_BLOK AND DOB.NO_URUT = J02.NO_URUT 
                    AND DOB.KD_JNS_OP = J02.KD_JNS_OP AND DOB.NO_BNG = J02.NO_BNG
                LEFT JOIN DAT_JPB3 J03 ON DOB.KD_PROPINSI = J03.KD_PROPINSI AND DOB.KD_DATI2 = J03.KD_DATI2 AND DOB.KD_KECAMATAN = J03.KD_KECAMATAN 
                    AND DOB.KD_KELURAHAN = J03.KD_KELURAHAN AND DOB.KD_BLOK = J03.KD_BLOK AND DOB.NO_URUT = J03.NO_URUT 
                    AND DOB.KD_JNS_OP = J03.KD_JNS_OP AND DOB.NO_BNG = J03.NO_BNG
                LEFT JOIN DAT_JPB4 J04 ON DOB.KD_PROPINSI = J04.KD_PROPINSI AND DOB.KD_DATI2 = J04.KD_DATI2 AND DOB.KD_KECAMATAN = J04.KD_KECAMATAN 
                    AND DOB.KD_KELURAHAN = J04.KD_KELURAHAN AND DOB.KD_BLOK = J04.KD_BLOK AND DOB.NO_URUT = J04.NO_URUT 
                    AND DOB.KD_JNS_OP = J04.KD_JNS_OP AND DOB.NO_BNG = J04.NO_BNG
                LEFT JOIN DAT_JPB5 J05 ON DOB.KD_PROPINSI = J05.KD_PROPINSI AND DOB.KD_DATI2 = J05.KD_DATI2 AND DOB.KD_KECAMATAN = J05.KD_KECAMATAN 
                    AND DOB.KD_KELURAHAN = J05.KD_KELURAHAN AND DOB.KD_BLOK = J05.KD_BLOK AND DOB.NO_URUT = J05.NO_URUT 
                    AND DOB.KD_JNS_OP = J05.KD_JNS_OP AND DOB.NO_BNG = J05.NO_BNG
                LEFT JOIN DAT_JPB6 J06 ON DOB.KD_PROPINSI = J06.KD_PROPINSI AND DOB.KD_DATI2 = J06.KD_DATI2 AND DOB.KD_KECAMATAN = J06.KD_KECAMATAN 
                    AND DOB.KD_KELURAHAN = J06.KD_KELURAHAN AND DOB.KD_BLOK = J06.KD_BLOK AND DOB.NO_URUT = J06.NO_URUT 
                    AND DOB.KD_JNS_OP = J06.KD_JNS_OP AND DOB.NO_BNG = J06.NO_BNG
                LEFT JOIN DAT_JPB7 J07 ON DOB.KD_PROPINSI = J07.KD_PROPINSI AND DOB.KD_DATI2 = J07.KD_DATI2 AND DOB.KD_KECAMATAN = J07.KD_KECAMATAN 
                    AND DOB.KD_KELURAHAN = J07.KD_KELURAHAN AND DOB.KD_BLOK = J07.KD_BLOK AND DOB.NO_URUT = J07.NO_URUT 
                    AND DOB.KD_JNS_OP = J07.KD_JNS_OP AND DOB.NO_BNG = J07.NO_BNG
                LEFT JOIN DAT_JPB8 J08 ON DOB.KD_PROPINSI = J08.KD_PROPINSI AND DOB.KD_DATI2 = J08.KD_DATI2 AND DOB.KD_KECAMATAN = J08.KD_KECAMATAN 
                    AND DOB.KD_KELURAHAN = J08.KD_KELURAHAN AND DOB.KD_BLOK = J08.KD_BLOK AND DOB.NO_URUT = J08.NO_URUT 
                    AND DOB.KD_JNS_OP = J08.KD_JNS_OP AND DOB.NO_BNG = J08.NO_BNG
                LEFT JOIN DAT_JPB9 J09 ON DOB.KD_PROPINSI = J09.KD_PROPINSI AND DOB.KD_DATI2 = J09.KD_DATI2 AND DOB.KD_KECAMATAN = J09.KD_KECAMATAN 
                    AND DOB.KD_KELURAHAN = J09.KD_KELURAHAN AND DOB.KD_BLOK = J09.KD_BLOK AND DOB.NO_URUT = J09.NO_URUT 
                    AND DOB.KD_JNS_OP = J09.KD_JNS_OP AND DOB.NO_BNG = J09.NO_BNG
                LEFT JOIN DAT_JPB12 J12 ON DOB.KD_PROPINSI = J12.KD_PROPINSI AND DOB.KD_DATI2 = J12.KD_DATI2 AND DOB.KD_KECAMATAN = J12.KD_KECAMATAN 
                    AND DOB.KD_KELURAHAN = J12.KD_KELURAHAN AND DOB.KD_BLOK = J12.KD_BLOK AND DOB.NO_URUT = J12.NO_URUT 
                    AND DOB.KD_JNS_OP = J12.KD_JNS_OP AND DOB.NO_BNG = J12.NO_BNG
                LEFT JOIN DAT_JPB13 J13 ON DOB.KD_PROPINSI = J13.KD_PROPINSI AND DOB.KD_DATI2 = J13.KD_DATI2 AND DOB.KD_KECAMATAN = J13.KD_KECAMATAN 
                    AND DOB.KD_KELURAHAN = J13.KD_KELURAHAN AND DOB.KD_BLOK = J13.KD_BLOK AND DOB.NO_URUT = J13.NO_URUT 
                    AND DOB.KD_JNS_OP = J13.KD_JNS_OP AND DOB.NO_BNG = J13.NO_BNG
                LEFT JOIN DAT_JPB14 J14 ON DOB.KD_PROPINSI = J14.KD_PROPINSI AND DOB.KD_DATI2 = J14.KD_DATI2 AND DOB.KD_KECAMATAN = J14.KD_KECAMATAN 
                    AND DOB.KD_KELURAHAN = J14.KD_KELURAHAN AND DOB.KD_BLOK = J14.KD_BLOK AND DOB.NO_URUT = J14.NO_URUT 
                    AND DOB.KD_JNS_OP = J14.KD_JNS_OP AND DOB.NO_BNG = J14.NO_BNG
                LEFT JOIN DAT_JPB15 J15 ON DOB.KD_PROPINSI = J15.KD_PROPINSI AND DOB.KD_DATI2 = J15.KD_DATI2 AND DOB.KD_KECAMATAN = J15.KD_KECAMATAN 
                    AND DOB.KD_KELURAHAN = J15.KD_KELURAHAN AND DOB.KD_BLOK = J15.KD_BLOK AND DOB.NO_URUT = J15.NO_URUT 
                    AND DOB.KD_JNS_OP = J15.KD_JNS_OP AND DOB.NO_BNG = J15.NO_BNG
                LEFT JOIN DAT_JPB16 J16 ON DOB.KD_PROPINSI = J16.KD_PROPINSI AND DOB.KD_DATI2 = J16.KD_DATI2 AND DOB.KD_KECAMATAN = J16.KD_KECAMATAN 
                    AND DOB.KD_KELURAHAN = J16.KD_KELURAHAN AND DOB.KD_BLOK = J16.KD_BLOK AND DOB.NO_URUT = J16.NO_URUT 
                    AND DOB.KD_JNS_OP = J16.KD_JNS_OP AND DOB.NO_BNG = J16.NO_BNG
                LEFT JOIN DAT_NILAI_INDIVIDU IND ON DOB.KD_PROPINSI = IND.KD_PROPINSI AND DOB.KD_DATI2 = IND.KD_DATI2 
                    AND DOB.KD_KECAMATAN = IND.KD_KECAMATAN AND DOB.KD_KELURAHAN = IND.KD_KELURAHAN AND DOB.KD_BLOK = IND.KD_BLOK 
                    AND DOB.NO_URUT = IND.NO_URUT AND DOB.KD_JNS_OP = IND.KD_JNS_OP AND DOB.NO_BNG = IND.NO_BNG
                WHERE DOB.KD_PROPINSI = '{$kd_prop}'
                    AND DOB.KD_DATI2 = '{$kd_dati}'
                    AND DOB.KD_KECAMATAN = '{$kd_kec}' 
                    AND DOB.KD_KELURAHAN = '{$kd_kel}' 
                    AND DOB.KD_BLOK = '{$kd_blok}' 
                    AND DOB.NO_URUT = '{$no_urut}'  
                    AND DOB.KD_JNS_OP = '{$kd_jns_op}'
                    AND DOB.NO_BNG = '{$no_bng}' ";

        return $this->db->query($qry)->row();
    }


}
