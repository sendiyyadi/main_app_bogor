<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class rpt_model extends CI_Model
{
    private $tbl = 'sppt';
    private $schema_pbb = SCHEMA_PBB.".";

    function __construct()
    {
        parent::__construct();
    }

    function get_lap_harian($tgl,$buku_id,$urut_id,$kel_id,$user_id)
    {
        $schema_pbb = $this->schema_pbb;
        $order_by = "";
        $urut  = "";
        if ($urut_id == 1){ $order_by = " order by  a.tgl_rekam_byr_sppt"; }
        elseif ($urut_id == 2){
            $order_by = " order by  a.kd_propinsi, a.kd_dati2, a.kd_kecamatan, a.kd_kelurahan,
            a.kd_blok, a.no_urut, a.kd_jns_op";
        }
        else if ($urut_id == 3){ $order_by = " order by  a.thn_pajak_sppt"; }
        else { $order_by = " order by a.jml_sppt_yg_dibayar"; }

        $where = '';

        if ($buku_id != '5') {
            $b_awal  = buku_bawah($buku_id);
            $b_akhir = buku_atas($buku_id);
            $where .= " and a.jml_sppt_yg_dibayar-a.denda_sppt between $b_awal and $b_akhir ";
        }
        $kel_id = substr($kel_id, 0, 7);
        if ($kel_id != '000.000') {
            $where .= " and a.kd_kecamatan='" . substr($kel_id, 0, 3) . "'
            and a.kd_kelurahan='" . substr($kel_id, -3) . "'";
        }
        //
        if (!empty($user_id)) {
            $user_info = $this->load->model('user_pbb_model')->get_users_by_id($user_id); 

            $tp_bayar  = $user_info->KD_TP;
            $nip_rekam = $user_info->NIP;

            $kd_kanwil = $user_info->KD_KANWIL;
            $kd_kantor = $user_info->KD_KANTOR;

            $where .= " and a.NIP_REKAM_BYR_SPPT='" . $nip_rekam."' and a.KD_TP='".$tp_bayar."' ";
        }
        if ($user_id == '9999777') {
            // USER TIDAK ADA HAK JD NIP NOT DEFIND
            $where .= " and a.NIP_REKAM_BYR_SPPT='98989898989898'";
        }
        //
        /*
        //------------------------------------------------------------------------------
        // cek user admin bukan
        $userlogin = lda_user_login();
        $isgrup_admin = $this->load->model('user_pbb_model')->get_isgrup_admin($userlogin);
        //------------------------------------------------------------------------------
        // cek jika bukan grup admin
        $filter_tgl = ""; 
        $kd_kanwil = $this->session->userdata('kd_kanwil');
        $kd_kantor = $this->session->userdata('kd_kantor');
        $kd_tp     = $this->session->userdata('kd_tp');
        $nip_rekam = $this->session->userdata('nip');

        if($isgrup_admin == FALSE) {
            $filter_tgl  = " AND (trunc(TGL_BAYAR) between trunc(sysdate-1) and trunc(sysdate) )
            and KD_KANWIL='{$kd_kanwil}' and KD_KANTOR='{$kd_kantor}' and KD_TP_BAYAR='{$kd_tp}' ";
            //
            $join_byr = "JOIN HIST_PEMBAYARAN_SPPT BYR ON A.KD_PROPINSI=BYR.KD_PROPINSI 
            AND A.KD_DATI2=BYR.KD_DATI2 AND A.KD_KECAMATAN=BYR.KD_KECAMATAN 
            AND A.KD_KELURAHAN=BYR.KD_KELURAHAN AND A.KD_BLOK=BYR.KD_BLOK 
            AND A.NO_URUT=BYR.NO_URUT AND A.KD_JNS_OP=BYR.KD_JNS_OP
            AND A.THN_PAJAK_SPPT=BYR.THN_PAJAK_SPPT  
            AND A.PEMBAYARAN_SPPT_KE=BYR.PEMBAYARAN_SPPT_KE
            AND A.KD_KANWIL=BYR.KD_KANWIL AND A.KD_KANTOR=BYR.KD_KANTOR
            AND A.KD_TP=BYR.KD_TP_BAYAR AND BYR.STS_BAYAR=1
            AND TRUNC(A.TGL_PEMBAYARAN_SPPT)=BYR.TGL_BAYAR
            AND BYR.NIP_BAYAR=''   
            AND BYR.KD_KANWIL=BYR.KD_KANWIL AND BYR.KD_KANTOR=BYR.KD_KANTOR
            AND BYR.KD_TP_BAYAR=BYR.KD_TP_BAYAR
            ";
        }
        else{
            if (!empty($user_id)) {
                $user_info = $this->load->model('user_pbb_model')->get_users_by_id($user_id); 
                $tp_bayar  = $user_info->KD_TP;
                $nip_rekam = $user_info->NIP;
                $where .= " and a.NIP_REKAM_BYR_SPPT='" . $nip_rekam."' and a.KD_TP='".$tp_bayar."' ";
            }
            if ($user_id == '9999777') {
                // USER TIDAK ADA HAK JD NIP NOT DEFIND
                $where .= " and a.NIP_REKAM_BYR_SPPT='98989898989898'";
            }
        }
        */
        //
        $sql_bck = "select to_char(a.tgl_rekam_byr_sppt,'HH24:MI:SS') as jam, a.kd_propinsi, a.kd_dati2, 
        a.kd_kecamatan, a.kd_kelurahan, a.kd_blok, a.no_urut, a.kd_jns_op, a.thn_pajak_sppt, a.pembayaran_sppt_ke,
        a.denda_sppt, a.jml_sppt_yg_dibayar, a.tgl_pembayaran_sppt,
        SUBSTR(b.nm_wp_sppt,1,22) as nm_wp_sppt, a.jml_sppt_yg_dibayar-a.denda_sppt pbb_yg_harus_dibayar_sppt
        from S_PEMBAYARAN_SPPT a
        join S_SPPT b on a.kd_propinsi = b.kd_propinsi and a.kd_dati2 = b.kd_dati2
        and a.kd_kecamatan = b.kd_kecamatan and a.kd_kelurahan = b.kd_kelurahan
        and a.kd_blok = b.kd_blok and a.no_urut = b.no_urut and a.kd_jns_op = b.kd_jns_op
        and a.thn_pajak_sppt = b.thn_pajak_sppt
        JOIN HIST_PEMBAYARAN_SPPT H1 ON
        A.KD_PROPINSI=H1.KD_PROPINSI AND A.KD_DATI2=H1.KD_DATI2
        AND A.KD_KECAMATAN=H1.KD_KECAMATAN AND A.KD_KELURAHAN=H1.KD_KELURAHAN
        AND A.KD_BLOK=H1.KD_BLOK AND A.NO_URUT=H1.NO_URUT AND A.KD_JNS_OP=H1.KD_JNS_OP
        AND A.THN_PAJAK_SPPT=H1.THN_PAJAK_SPPT
        AND A.PEMBAYARAN_SPPT_KE=H1.PEMBAYARAN_SPPT_KE
        AND A.TGL_PEMBAYARAN_SPPT=H1.TGL_BAYAR
        AND H1.STS_BAYAR=1        
        where to_char(a.tgl_pembayaran_sppt,'YYYY-MM-DD') = '$tgl' and a.jml_sppt_yg_dibayar>0
        $where
        $order_by ";

        $sql = "select to_char(a.tgl_rekam_byr_sppt,'HH24:MI:SS') as jam, a.kd_propinsi, a.kd_dati2, 
        a.kd_kecamatan, a.kd_kelurahan, a.kd_blok, a.no_urut, a.kd_jns_op, a.thn_pajak_sppt, a.pembayaran_sppt_ke,
        a.denda_sppt, a.jml_sppt_yg_dibayar, a.tgl_pembayaran_sppt,
        SUBSTR(b.nm_wp_sppt,1,22) as nm_wp_sppt, a.jml_sppt_yg_dibayar-a.denda_sppt pbb_yg_harus_dibayar_sppt
        from S_PEMBAYARAN_SPPT a
        join S_SPPT b on a.kd_propinsi = b.kd_propinsi and a.kd_dati2 = b.kd_dati2
        and a.kd_kecamatan = b.kd_kecamatan and a.kd_kelurahan = b.kd_kelurahan
        and a.kd_blok = b.kd_blok and a.no_urut = b.no_urut and a.kd_jns_op = b.kd_jns_op
        and a.thn_pajak_sppt = b.thn_pajak_sppt      
        where to_char(a.tgl_pembayaran_sppt,'YYYY-MM-DD') = '$tgl' and a.jml_sppt_yg_dibayar>0
        $where
        $order_by ";

        //var_dump($sql);die;
        $query = $this->db->query($sql);

        if ($query->num_rows() !== 0) {
            return $query->result_array();
        } else
            return FALSE;
    }

    function get_lap_harian_csv($tgl,$buku_id,$urut_id,$kel_id,$user_id) //csv
    {
        $schema_pbb = $this->schema_pbb;
        $order_by = "";
        if ($urut_id == 1){
            $order_by = " order by  b.nm_wp_sppt";
        }
        elseif ($urut_id == 2){
            $order_by = " order by  a.kd_propinsi, a.kd_dati2, a.kd_kecamatan, a.kd_kelurahan,
            a.kd_blok, a.no_urut, a.kd_jns_op";
        }

        else if ($urut_id == 3){
            $order_by = " order by  a.thn_pajak_sppt";
        }
        else{
            $order_by = " order by  a.jml_sppt_yg_dibayar";
        }

        $where = '';
        if ($buku_id != 5) {
            $b_awal  = buku_bawah($buku_id);
            $b_akhir = buku_atas($buku_id);
            $where .= " and a.jml_sppt_yg_dibayar-a.denda_sppt between $b_awal and $b_akhir ";
        }
        $kel = substr($kel_id,0,7);
        if ($kel != '000.000') {
            $where .= " and a.kd_kecamatan='" . substr($kel, 0,3)."'
            and a.kd_kelurahan='" . substr($kel,-3)."'";
        }

        if (!empty($user_id)) {
            $user_info = $this->load->model('user_pbb_model')->get_users_by_id($user_id); 
            $tp_bayar  = $user_info->KD_TP;
            $nip_rekam = $user_info->NIP;
            $where .= " and a.NIP_REKAM_BYR_SPPT='" . $nip_rekam."' and a.KD_TP='".$tp_bayar."' ";
        }
        if ($user_id == '9999777') {
            // USER TIDAK ADA HAK JD NIP NOT DEFIND
            $where .= " and a.NIP_REKAM_BYR_SPPT='98989898989898'";
        }
        //
        /*
        if (DEF_POS_TYPE==1){
            $where .= " and a.KD_KANWIL='".$this->session->userdata('kd_kanwil')."' ";
            $where .= "and a.KD_KANTOR='".$this->session->userdata('kd_kantor')."' ";
            $where .= "and a.KD_TP='".$this->session->userdata('kd_tp')."' ";
        }
        else{
            $where .= " and a.KD_BANK_TUNGGAL='".$this->session->userdata('kd_bank_tunggal')."' ";
            $where .= "and a.KD_BANK_PERSEPSI='".$this->session->userdata('kd_bank_persepsi')."' ";
            $where .= "and a.KD_KANWIL='".$this->session->userdata('kd_kanwil')."' ";
            $where .= "and a.KD_KANTOR='".$this->session->userdata('kd_kantor')."' ";
            $where .= "and a.KD_TP='".$this->session->userdata('kd_tp')."' ";
        }
        */
        //
        $sql_bck = "select to_char(a.tgl_rekam_byr_sppt,'HH24:MI:SS') as jam,
            a.kd_propinsi||'.'||a.kd_dati2||'.'||a.kd_kecamatan||'.'||a.kd_kelurahan||'.'||a.kd_blok||'.'
            ||a.no_urut||'.'||a.kd_jns_op nop, a.thn_pajak_sppt thn_sppt,
            SUBSTR(b.nm_wp_sppt,1,22) as  nm_wp,
            --a.jml_sppt_yg_dibayar-a.denda_sppt pbb_yg_harus_dibayar_sppt,
			b.pbb_yg_harus_dibayar_sppt, a.denda_sppt, a.jml_sppt_yg_dibayar,
            a.pembayaran_sppt_ke, to_char(a.tgl_pembayaran_sppt,'DD-MM-YYYY') as tgl_pembayaran_sppt
            from S_PEMBAYARAN_SPPT a
            join S_SPPT b on a.kd_propinsi = b.kd_propinsi and a.kd_dati2 = b.kd_dati2
            and a.kd_kecamatan = b.kd_kecamatan and a.kd_kelurahan = b.kd_kelurahan
            and a.kd_blok = b.kd_blok and a.no_urut = b.no_urut
            and a.kd_jns_op = b.kd_jns_op and a.thn_pajak_sppt = b.thn_pajak_sppt
            JOIN HIST_PEMBAYARAN_SPPT H1 ON
            A.KD_PROPINSI=H1.KD_PROPINSI AND A.KD_DATI2=H1.KD_DATI2
            AND A.KD_KECAMATAN=H1.KD_KECAMATAN AND A.KD_KELURAHAN=H1.KD_KELURAHAN
            AND A.KD_BLOK=H1.KD_BLOK AND A.NO_URUT=H1.NO_URUT AND A.KD_JNS_OP=H1.KD_JNS_OP
            AND A.THN_PAJAK_SPPT=H1.THN_PAJAK_SPPT
            AND A.PEMBAYARAN_SPPT_KE=H1.PEMBAYARAN_SPPT_KE
            AND A.TGL_PEMBAYARAN_SPPT=H1.TGL_BAYAR
            AND H1.STS_BAYAR=1             
            where to_char(a.tgl_pembayaran_sppt,'YYYY-MM-DD') = '$tgl' $where 
            $order_by  ";

        $sql = "select to_char(a.tgl_rekam_byr_sppt,'HH24:MI:SS') as jam,
            a.kd_propinsi||'.'||a.kd_dati2||'.'||a.kd_kecamatan||'.'||a.kd_kelurahan||'.'||a.kd_blok||'.'
            ||a.no_urut||'.'||a.kd_jns_op nop, a.thn_pajak_sppt thn_sppt,
            SUBSTR(b.nm_wp_sppt,1,22) as  nm_wp,
            --a.jml_sppt_yg_dibayar-a.denda_sppt pbb_yg_harus_dibayar_sppt,
            b.pbb_yg_harus_dibayar_sppt, a.denda_sppt, a.jml_sppt_yg_dibayar,
            a.pembayaran_sppt_ke, to_char(a.tgl_pembayaran_sppt,'DD-MM-YYYY') as tgl_pembayaran_sppt
            from S_PEMBAYARAN_SPPT a
            join S_SPPT b on a.kd_propinsi = b.kd_propinsi and a.kd_dati2 = b.kd_dati2
            and a.kd_kecamatan = b.kd_kecamatan and a.kd_kelurahan = b.kd_kelurahan
            and a.kd_blok = b.kd_blok and a.no_urut = b.no_urut
            and a.kd_jns_op = b.kd_jns_op and a.thn_pajak_sppt = b.thn_pajak_sppt          
            where to_char(a.tgl_pembayaran_sppt,'YYYY-MM-DD') = '$tgl' $where 
            $order_by  ";

        $query = $this->db->query($sql);

        if ($query->num_rows() !== 0) {
            return $query->result_array();
        } else
            return FALSE;
    }


    function get_lap_pembatalan($user_id, $tgl, $tgl2) {

        $schema_pbb = $this->schema_pbb;
        $where = '';
        if (!empty($user_id)) {
            $user_info = $this->load->model('user_pbb_model')->get_users_by_id($user_id); 
            $tp_bayar  = $user_info->KD_TP;
            $nip_rekam = $user_info->NIP;
            $where .= " AND BYR.NIP_REKAM_BTL_SPPT='" . $nip_rekam."' ";
        }    
 
        $sql_bck = "SELECT BYR.KD_PROPINSI, BYR.KD_DATI2, BYR.KD_KECAMATAN, BYR.KD_KELURAHAN,
        BYR.KD_BLOK, BYR.NO_URUT, BYR.KD_JNS_OP, BYR.THN_PAJAK_SPPT, BYR.PEMBAYARAN_SPPT_KE,
        BYR.DENDA_SPPT, BYR.JML_SPPT_YG_DIBAYAR, BYR.TGL_PEMBAYARAN_SPPT,SPT.NM_WP_SPPT, 
        (BTL.NILAI_BAYAR_BTL-BTL.DENDA_SPPT_BTL) AS PBB_YG_HARUS_DIBAYAR_SPPT,
        BTL.NILAI_BAYAR_BTL AS JML_BATAL, BTL.TGL_BATAL
        FROM S_PEMBAYARAN_SPPT BYR
        JOIN S_SPPT SPT ON BYR.KD_PROPINSI=SPT.KD_PROPINSI
        AND BYR.KD_DATI2 = SPT.KD_DATI2
        AND BYR.KD_KECAMATAN = SPT.KD_KECAMATAN
        AND BYR.KD_KELURAHAN = SPT.KD_KELURAHAN
        AND BYR.KD_BLOK = SPT.KD_BLOK
        AND BYR.NO_URUT = SPT.NO_URUT
        AND BYR.KD_JNS_OP = SPT.KD_JNS_OP
        AND BYR.THN_PAJAK_SPPT = SPT.THN_PAJAK_SPPT
        JOIN HIST_PEMBAYARAN_SPPT BTL ON
        BYR.KD_PROPINSI=BTL.KD_PROPINSI AND BYR.KD_DATI2=BTL.KD_DATI2
        AND BYR.KD_KECAMATAN=BTL.KD_KECAMATAN AND BYR.KD_KELURAHAN=BTL.KD_KELURAHAN
        AND BYR.KD_BLOK=BTL.KD_BLOK AND BYR.NO_URUT=BTL.NO_URUT AND BYR.KD_JNS_OP=BTL.KD_JNS_OP
        AND BYR.THN_PAJAK_SPPT=BTL.THN_PAJAK_SPPT
        AND BYR.PEMBAYARAN_SPPT_KE=BTL.PEMBAYARAN_SPPT_KE
        AND BYR.TGL_PEMBAYARAN_SPPT=BTL.TGL_BAYAR
        AND BTL.STS_BAYAR=2        
        WHERE
        BTL.TGL_BATAL BETWEEN TO_DATE('{$tgl}','YYYY-MM-DD') AND TO_DATE('{$tgl2}','YYYY-MM-DD')
        AND BTL.NILAI_BAYAR_BTL>0 AND BYR.JML_SPPT_YG_DIBAYAR=0
        $where
        order by BTL.TGL_BATAL, SPT.THN_PAJAK_SPPT,SPT.KD_KECAMATAN, 
        SPT.KD_KELURAHAN, SPT.KD_BLOK, SPT.NO_URUT, SPT.KD_JNS_OP
        ";

        $sql = "
        SELECT
        byr.kd_propinsi,
        byr.kd_dati2,
        byr.kd_kecamatan,
        byr.kd_kelurahan,
        byr.kd_blok,
        byr.no_urut,
        byr.kd_jns_op,
        byr.thn_pajak_sppt,
        byr.pembatalan_sppt_ke,
        byr.denda_sppt,
        spt.nm_wp_sppt,
        (byr.jml_sppt_yg_dibatalkan - byr.denda_sppt) AS pbb_yg_harus_dibayar_sppt,
        byr.jml_sppt_yg_dibatalkan AS jml_batal,
        byr.tgl_pembatalan_sppt
    FROM
        pembatalan_sppt byr
    JOIN
        s_sppt spt ON
            byr.kd_propinsi       = spt.kd_propinsi AND
            byr.kd_dati2          = spt.kd_dati2 AND
            byr.kd_kecamatan      = spt.kd_kecamatan AND
            byr.kd_kelurahan      = spt.kd_kelurahan AND
            byr.kd_blok           = spt.kd_blok AND
            byr.no_urut           = spt.no_urut AND
            byr.kd_jns_op         = spt.kd_jns_op AND
            byr.thn_pajak_sppt    = spt.thn_pajak_sppt
    WHERE 
        byr.tgl_pembatalan_sppt BETWEEN TO_DATE('{$tgl}', 'YYYY-MM-DD') 
                         AND TO_DATE('{$tgl2}', 'YYYY-MM-DD') AND
        byr.jml_sppt_yg_dibatalkan  > 0
        $where
    ORDER BY
        byr.tgl_pembatalan_sppt,
        spt.thn_pajak_sppt,
        spt.kd_kecamatan,
        spt.kd_kelurahan,
        spt.kd_blok,
        spt.no_urut,
        spt.kd_jns_op";

        //var_dump($sql);die;
        $query = $this->db->query($sql);
        if ($query->num_rows() !== 0) {
            return $query->result_array();
        } else{
            return FALSE;
        }
    }

    function get_lap_pembatalan_csv($tgl, $tgl2) {
        
        $schema_pbb = $this->schema_pbb;
        $where = '';
        if (!empty($user_id)) {
            $user_info = $this->load->model('user_pbb_model')->get_users_by_id($user_id); 
            $tp_bayar  = $user_info->KD_TP;
            $nip_rekam = $user_info->NIP;
            $where .= " AND BYR.NIP_REKAM_BTL_SPPT='" . $nip_rekam."' ";
        }  

        $sql_bck = "SELECT (BYR.KD_PROPINSI||'.'||BYR.KD_DATI2||'.'||BYR.KD_KECAMATAN||'.'||BYR.KD_KELURAHAN||'.'||
        BYR.KD_BLOK||'.'||BYR.NO_URUT||'.'||BYR.KD_JNS_OP||'.'||BYR.THN_PAJAK_SPPT) AS NOP, 
        BYR.PEMBAYARAN_SPPT_KE, BYR.DENDA_SPPT, BYR.JML_SPPT_YG_DIBAYAR, BYR.TGL_PEMBAYARAN_SPPT,
        SPT.NM_WP_SPPT, (BTL.NILAI_BAYAR_BTL-BTL.DENDA_SPPT_BTL) AS PBB_YG_HARUS_DIBAYAR_SPPT,
        BTL.NILAI_BAYAR_BTL AS JML_BATAL, BTL.TGL_BATAL
        FROM S_PEMBAYARAN_SPPT BYR
        JOIN S_SPPT SPT ON BYR.KD_PROPINSI=SPT.KD_PROPINSI
        AND BYR.KD_DATI2 = SPT.KD_DATI2
        AND BYR.KD_KECAMATAN = SPT.KD_KECAMATAN
        AND BYR.KD_KELURAHAN = SPT.KD_KELURAHAN
        AND BYR.KD_BLOK = SPT.KD_BLOK
        AND BYR.NO_URUT = SPT.NO_URUT
        AND BYR.KD_JNS_OP = SPT.KD_JNS_OP
        AND BYR.THN_PAJAK_SPPT = SPT.THN_PAJAK_SPPT
        JOIN S_HIST_BYR_PELAYANAN_BATAL BTL ON BTL.KD_PROPINSI=SPT.KD_PROPINSI
        AND BTL.KD_DATI2 = SPT.KD_DATI2
        AND BTL.KD_KECAMATAN = SPT.KD_KECAMATAN
        AND BTL.KD_KELURAHAN = SPT.KD_KELURAHAN
        AND BTL.KD_BLOK = SPT.KD_BLOK
        AND BTL.NO_URUT = SPT.NO_URUT
        AND BTL.KD_JNS_OP = SPT.KD_JNS_OP
        AND BTL.THN_PAJAK_SPPT = SPT.THN_PAJAK_SPPT
        AND BTL.PEMBAYARAN_SPPT_KE = BYR.PEMBAYARAN_SPPT_KE
        --AND BTL.CTR_DOK=1
        WHERE
        BTL.TGL_BATAL BETWEEN TO_DATE('{$tgl}','YYYY-MM-DD') AND TO_DATE('{$tgl2}','YYYY-MM-DD')
        AND BTL.NILAI_BAYAR_BTL>0 AND BYR.JML_SPPT_YG_DIBAYAR=0
        $where
        order by BTL.TGL_BATAL, SPT.THN_PAJAK_SPPT,SPT.KD_KECAMATAN, 
        SPT.KD_KELURAHAN, SPT.KD_BLOK, SPT.NO_URUT, SPT.KD_JNS_OP
        ";

        $sql = "
        SELECT
        byr.kd_propinsi,
        byr.kd_dati2,
        byr.kd_kecamatan,
        byr.kd_kelurahan,
        byr.kd_blok,
        byr.no_urut,
        byr.kd_jns_op,
        byr.thn_pajak_sppt,
        byr.pembatalan_sppt_ke,
        byr.denda_sppt,
        spt.nm_wp_sppt,
        (byr.jml_sppt_yg_dibatalkan - byr.denda_sppt) AS pbb_yg_harus_dibayar_sppt,
        byr.jml_sppt_yg_dibatalkan AS jml_batal,
        byr.tgl_pembatalan_sppt
    FROM
        pembatalan_sppt byr
    JOIN
        s_sppt spt ON
            byr.kd_propinsi       = spt.kd_propinsi AND
            byr.kd_dati2          = spt.kd_dati2 AND
            byr.kd_kecamatan      = spt.kd_kecamatan AND
            byr.kd_kelurahan      = spt.kd_kelurahan AND
            byr.kd_blok           = spt.kd_blok AND
            byr.no_urut           = spt.no_urut AND
            byr.kd_jns_op         = spt.kd_jns_op AND
            byr.thn_pajak_sppt    = spt.thn_pajak_sppt
    WHERE 
        byr.tgl_pembatalan_sppt BETWEEN TO_DATE('{$tgl}', 'YYYY-MM-DD') 
                         AND TO_DATE('{$tgl2}', 'YYYY-MM-DD') AND
        byr.jml_sppt_yg_dibatalkan  > 0
        $where
    ORDER BY
        byr.tgl_pembatalan_sppt,
        spt.thn_pajak_sppt,
        spt.kd_kecamatan,
        spt.kd_kelurahan,
        spt.kd_blok,
        spt.no_urut,
        spt.kd_jns_op";

        //var_dump($sql);die;

        $query = $this->db->query($sql);

        if ($query->num_rows() !== 0) {
            return $query->result_array();
        } else{
            return FALSE;
        }
    }
}

/* End of file _model.php */
