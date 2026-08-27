<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class simulasi_sppt_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }


    public function cek_nop($nop) {
        $nop     = str_replace(".", "", $nop);
        $nop     = str_replace("-", "", $nop);
        $kd_prop = substr($nop, 0, 2);
        $kd_dati = substr($nop, 2, 2);
        $kd_kec  = substr($nop, 4, 3);
        $kd_kel  = substr($nop, 7, 3);
        $kd_blok = substr($nop, 10, 3);
        $no_urut = substr($nop, 13, 4);
        $kd_jns_op = substr($nop, 17, 1);

        $qry = "SELECT KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP 
                FROM DAT_OBJEK_PAJAK
                WHERE KD_PROPINSI = '{$kd_prop}' AND KD_DATI2 = '{$kd_dati}' AND KD_KECAMATAN = '{$kd_kec}'
                AND KD_KELURAHAN = '{$kd_kel}' AND KD_BLOK = '{$kd_blok}' AND NO_URUT = '{$no_urut}' 
                AND KD_JNS_OP = '{$kd_jns_op}'";
        //AND lower(trim(KC.KD_KECAMATAN)) = lower(trim('{$kec}'))
        //log_message('info', "KKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK  ". $qry);
        $query = $this->db->query($qry);
        if ($query->num_rows()!==0) {
            return true;
        } else {
            return false;
        }
    }

    public function get($nopthn) {
        $kd_prop    = substr($nopthn, 0, 2);
        $kd_dati    = substr($nopthn, 2, 2);
        $kd_kec     = substr($nopthn, 4, 3);
        $kd_kel     = substr($nopthn, 7, 3);
        $kd_blok    = substr($nopthn, 10, 3);
        $no_urut    = substr($nopthn, 13, 4);
        $kd_jns_op  = substr($nopthn, 17, 1);
        $thn_pjk    = substr($nopthn, 18, 4);

        $qry = "SELECT S.*,
                S.KD_PROPINSI||'.'||S.KD_DATI2||'-'||S.KD_KECAMATAN||'.'||S.KD_KELURAHAN||'-'||S.KD_BLOK||'.'||S.NO_URUT||'.'||S.KD_JNS_OP AS NOP_LKP,
                CASE WHEN S.LUAS_BUMI_SPPT = 0 THEN 0 ELSE (S.NJOP_BUMI_SPPT/S.LUAS_BUMI_SPPT) END AS NJOP_BUMI_PERM,
                CASE WHEN S.LUAS_BNG_SPPT = 0 THEN 0 ELSE (S.NJOP_BNG_SPPT/S.LUAS_BNG_SPPT) END AS NJOP_BNG_PERM, 
                (SELECT NILAI_NJKP FROM NJKP WHERE KD_PROPINSI = S.KD_PROPINSI AND KD_DATI2 = S.KD_DATI2 
                AND S.THN_PAJAK_SPPT BETWEEN THN_AWAL AND THN_AKHIR AND S.NJOP_SPPT BETWEEN NJOP_MIN AND NJOP_MAX) AS NIL_NJKP,
                (SELECT TO_CHAR(NILAI_TARIF, '0.999') FROM TARIF WHERE KD_PROPINSI = S.KD_PROPINSI AND KD_DATI2 = S.KD_DATI2 
                AND S.THN_PAJAK_SPPT BETWEEN THN_AWAL AND THN_AKHIR AND S.NJOP_SPPT BETWEEN NJOP_MIN AND NJOP_MAX) AS NIL_TARIF,
                NVL(SP.BAYAR_DENDA,0) AS BAYAR_DENDA, NVL(SP.JML_BAYAR,0) AS JML_BAYAR, 
                TO_CHAR(S.TGL_JATUH_TEMPO_SPPT, 'DD-MM-YYYY') as TGL_JTTEMPO,
                TO_CHAR(S.TGL_TERBIT_SPPT, 'DD-MM-YYYY') as TGL_TERBIT,
                TO_CHAR(S.TGL_CETAK_SPPT, 'DD-MM-YYYY') as TGL_CETAK,
                DK.JALAN_OP, DK.BLOK_KAV_NO_OP, DK.RW_OP, DK.RT_OP,
                KEC.NM_KECAMATAN, KEL.NM_KELURAHAN,
                '-' as LUAS_BUMI_BERSAMA, '-' as LUAS_BNG_BERSAMA, '-' as NJOP_BUMI_BERSAMA, '-' as NJOP_BNG_BERSAMA,
                '-' as NJOP_BUMI_BERSAMA_PERM, '-' as NJOP_BNG_BERSAMA_PERM,
                '-' as KD_KLS_TANAH_BERSAMA, '-' as KD_KLS_BNG_BERSAMA,
                S.NJOP_BUMI_SPPT + 0 AS TTL_NJOP_BUMI, S.NJOP_BNG_SPPT + 0 AS TTL_NJOP_BNG


                /* BANGUNAN BERSAMA GA DIPAKE DULU.. SEMENTARA PANTEXXX
                NVL(SOB.LUAS_BUMI_BEBAN_SPPT,0) AS LUAS_BUMI_BERSAMA, NVL(SOB.LUAS_BNG_BEBAN_SPPT,0) AS LUAS_BNG_BERSAMA, 
                NVL(SOB.NJOP_BUMI_BEBAN_SPPT,0) AS NJOP_BUMI_BERSAMA, NVL(SOB.NJOP_BNG_BEBAN_SPPT,0) AS NJOP_BNG_BERSAMA,
                CASE WHEN (SOB.LUAS_BUMI_BEBAN_SPPT IS NULL OR SOB.LUAS_BUMI_BEBAN_SPPT<= 0) THEN 0 
                    ELSE ROUND(SOB.NJOP_BUMI_BEBAN_SPPT/SOB.LUAS_BUMI_BEBAN_SPPT) END AS NJOP_BUMI_BERSAMA_PERM,
                CASE WHEN (SOB.LUAS_BNG_BEBAN_SPPT IS NULL OR SOB.LUAS_BNG_BEBAN_SPPT<= 0) THEN 0 
                    ELSE ROUND(SOB.NJOP_BNG_BEBAN_SPPT/SOB.LUAS_BNG_BEBAN_SPPT) END AS NJOP_BNG_BERSAMA_PERM,
                KD_KLS_TANAH_BERSAMA, KD_KLS_BNG_BERSAMA

                LEFT JOIN SPPT_OP_BERSAMA SOB ON (S.KD_PROPINSI = SOB.KD_PROPINSI AND S.KD_DATI2=SOB.KD_DATI2 AND S.KD_KECAMATAN=SOB.KD_KECAMATAN 
            AND S.KD_KELURAHAN =SOB.KD_KELURAHAN AND S.KD_BLOK = SOB.KD_BLOK AND S.NO_URUT = SOB.NO_URUT AND S.KD_JNS_OP = SOB.KD_JNS_OP 
            AND S.THN_PAJAK_SPPT = SOB.THN_PAJAK_SPPT)
                */
                FROM SPPT_SIMULASI_TMP S
                JOIN DAT_OBJEK_PAJAK DK ON S.KD_PROPINSI = DK.KD_PROPINSI AND S.KD_DATI2 = DK.KD_DATI2 
                    AND S.KD_KECAMATAN = DK.KD_KECAMATAN AND S.KD_KELURAHAN = DK.KD_KELURAHAN 
                    AND S.KD_BLOK = DK.KD_BLOK AND S.NO_URUT = DK.NO_URUT AND S.KD_JNS_OP = DK.KD_JNS_OP
                JOIN REF_KECAMATAN KEC ON KEC.KD_PROPINSI = S.KD_PROPINSI AND KEC.KD_DATI2 = S.KD_DATI2 
                    AND KEC.KD_KECAMATAN = S.KD_KECAMATAN
                JOIN REF_KELURAHAN KEL ON KEL.KD_PROPINSI = S.KD_PROPINSI AND KEL.KD_DATI2 = S.KD_DATI2 
                    AND KEL.KD_KECAMATAN = S.KD_KECAMATAN AND KEL.KD_KELURAHAN = S.KD_KELURAHAN
                LEFT JOIN (SELECT SUM(DENDA_SPPT) AS BAYAR_DENDA, SUM(JML_SPPT_YG_DIBAYAR) AS JML_BAYAR
                    FROM PEMBAYARAN_SPPT 
                    WHERE KD_PROPINSI='$kd_prop' AND KD_DATI2='$kd_dati' AND KD_KECAMATAN='$kd_kec' AND KD_KELURAHAN='$kd_kel' 
                    AND KD_BLOK='$kd_blok' AND NO_URUT='$no_urut' AND KD_JNS_OP='$kd_jns_op' AND THN_PAJAK_SPPT='$thn_pjk'
                ) SP ON 1=1
                WHERE S.KD_PROPINSI = '{$kd_prop}' AND S.KD_DATI2 = '{$kd_dati}' AND S.KD_KECAMATAN = '{$kd_kec}'
                AND S.KD_KELURAHAN = '{$kd_kel}' AND S.KD_BLOK = '{$kd_blok}' AND S.NO_URUT = '{$no_urut}' 
                AND S.KD_JNS_OP = '{$kd_jns_op}' AND S.THN_PAJAK_SPPT = '{$thn_pjk}' ";
        //log_message('info', "KKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK  ". $qry);
        $query = $this->db->query($qry);
        if ($query->num_rows()!==0) {
            return $query->row();
        } else {
            return false;
        }
    }

    
}

/* End of file _model.php */
