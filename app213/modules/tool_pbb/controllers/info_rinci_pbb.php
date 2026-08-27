<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class info_rinci_pbb extends CI_Controller
{
    private $controller = 'info_rinci_pbb';
    public function __construct()
    {
        parent::__construct();
        if (!is_login()) {
            echo "<script>window.location.replace('" . base_url() . "');</script>";
            exit;
        }

        $module = 'info_rinci_pbb';
        $this->load->library('module_auth', array(
            'module' => $module
        ));

        $this->load->model(array(
            'apps_model', 'info_rinci_pbb_model'
        ));

        $this->load->helper(active_module());
    }

    public function index()
    {
        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect('tool_pbb');
        }

        $data['page_menu']  = 'info_rinci_pbb';
        $data['current']    = '';
        $data['controller'] = $this->controller;
        $data['apps']       = $this->apps_model->get_active_only();

        $this->load->view('vinfo_rinci_pbb', $data);
    }

    public function grid()
    {
        $nop   = $this->input->get('nop');
        $tahun   = $this->input->get('tahun');
        $nop = str_replace(['.', ',', '-'], '', $nop);

        if(empty($nop) || $nop == ''){
            $nop = '99.99.999.999.999.9999.9';
        }
        if(empty($tahun) || $tahun == ''){
            $tahun = '9999';
        }
        // $prop_kd = substr($nop, 0, 2);
        // $kab_kd  = substr($nop, 2, 2);
        // $kec_kd  = substr($nop, 4, 3);
        // $kel_kd  = substr($nop, 7, 3);
        // $blok_kd = substr($nop, 10, 3);
        // $urut_no = substr($nop, 13, 4);
        // $jns_kd  = substr($nop, 17, 1);

        $this->load->library('Datatables');
          $this->datatables->select("
          S.KD_PROPINSI || S.KD_DATI2 || S.KD_KECAMATAN || S.KD_KELURAHAN || S.KD_BLOK || S.NO_URUT || S.KD_JNS_OP AS NOP,
          S.THN_PAJAK_SPPT AS TAHUN,
          DAS.NM_WP AS NAMA_WP,
          DAP.JALAN_OP || ', ' || DAP.BLOK_KAV_NO_OP || ', RW ' || DAP.RW_OP || ', RT ' || DAP.RT_OP AS ALAMAT_OP, S.KD_PROPINSI||S.KD_DATI2||S.KD_KECAMATAN||S.KD_KELURAHAN||S.KD_BLOK||S.NO_URUT||S.KD_JNS_OP||S.THN_PAJAK_SPPT AS NOPTHN,
        CASE WHEN S1.KD_PROPINSI IS NULL THEN '0' ELSE '1' END AS S1,
        CASE WHEN S2.KD_PROPINSI IS NULL THEN '0' ELSE '1' END AS S2
          ", false);
      $this->datatables->from('SPPT S', false);
      $this->datatables->join("SPPT_SIMULASI S1", "S.KD_PROPINSI = S1.KD_PROPINSI AND S.KD_DATI2 = S1.KD_DATI2 AND S.KD_KECAMATAN = S1.KD_KECAMATAN AND S.KD_KELURAHAN = S1.KD_KELURAHAN AND S.KD_BLOK = S1.KD_BLOK AND S.NO_URUT = S1.NO_URUT AND S.KD_JNS_OP = S1.KD_JNS_OP AND S.THN_PAJAK_SPPT = S1.THN_PAJAK_SPPT", 'left');
      $this->datatables->join("SPPT_SIMULASI_TMP S2", "S.KD_PROPINSI = S2.KD_PROPINSI AND S.KD_DATI2 = S2.KD_DATI2 AND S.KD_KECAMATAN = S2.KD_KECAMATAN AND S.KD_KELURAHAN = S2.KD_KELURAHAN AND S.KD_BLOK = S2.KD_BLOK AND S.NO_URUT = S2.NO_URUT AND S.KD_JNS_OP = S2.KD_JNS_OP AND S.THN_PAJAK_SPPT = S2.THN_PAJAK_SPPT", 'left');
      $this->datatables->join("DAT_OBJEK_PAJAK DAP", "S.KD_PROPINSI = DAP.KD_PROPINSI AND S.KD_DATI2 = DAP.KD_DATI2 AND S.KD_KECAMATAN = DAP.KD_KECAMATAN AND S.KD_KELURAHAN = DAP.KD_KELURAHAN AND S.KD_BLOK = DAP.KD_BLOK AND S.NO_URUT = DAP.NO_URUT AND S.KD_JNS_OP = DAP.KD_JNS_OP", 'left');
      $this->datatables->join("DAT_SUBJEK_PAJAK DAS", "DAP.SUBJEK_PAJAK_ID = DAS.SUBJEK_PAJAK_ID", 'left');

      if (!empty($nop)) {
            $this->datatables->where("S.KD_PROPINSI||S.KD_DATI2||S.KD_KECAMATAN||S.KD_KELURAHAN||S.KD_BLOK||S.NO_URUT||S.KD_JNS_OP like '%{$nop}%'", false, false);
        }

        if (!empty($tahun)) {
            $this->datatables->where('S.THN_PAJAK_SPPT', $tahun);
        }

        echo $this->datatables->generate();

    }

    function get_sppt()
    {
        $fnop   = $this->uri->segment(4);
        $thn    = $this->uri->segment(5);
        $string_replace = array('.', '-');
        $nop = str_replace($string_replace, '', $fnop);
        $prop_kd = substr($nop, 0, 2);
        $kab_kd  = substr($nop, 2, 2);
        $kec_kd  = substr($nop, 4, 3);
        $kel_kd  = substr($nop, 7, 3);
        $blok_kd = substr($nop, 10, 3);
        $urut_no = substr($nop, 13, 4);
        $jns_kd  = substr($nop, 17, 1);

        $qq = "SELECT S.LUAS_BUMI_SPPT, S.LUAS_BNG_SPPT, 
        CASE WHEN S.LUAS_BUMI_SPPT = 0 THEN 0 ELSE (S.NJOP_BUMI_SPPT/S.LUAS_BUMI_SPPT) END AS NJOP_BUMI_PERM,
        CASE WHEN S.LUAS_BNG_SPPT = 0 THEN 0 ELSE (S.NJOP_BNG_SPPT/S.LUAS_BNG_SPPT) END AS NJOP_BNG_PERM, 
        S.NJOP_BUMI_SPPT, S.NJOP_BNG_SPPT, S.NJOPTKP_SPPT,  S.NJOP_SPPT, 
        S.PBB_YG_HARUS_DIBAYAR_SPPT, S.PBB_TERHUTANG_SPPT, S.FAKTOR_PENGURANG_SPPT,
        S.KD_KLS_BNG, S.KD_KLS_TANAH,
        CASE WHEN S.THN_PAJAK_SPPT < 2024 THEN 100 ELSE 
        (SELECT NILAI_NJKP FROM NJKP WHERE KD_PROPINSI = S.KD_PROPINSI AND KD_DATI2 = S.KD_DATI2 
        AND S.THN_PAJAK_SPPT BETWEEN THN_AWAL AND THN_AKHIR AND S.NJOP_SPPT BETWEEN NJOP_MIN AND NJOP_MAX) END AS NIL_NJKP,
        (SELECT TO_CHAR(NILAI_TARIF, '0.999') FROM TARIF WHERE KD_PROPINSI = S.KD_PROPINSI AND KD_DATI2 = S.KD_DATI2 
        AND S.THN_PAJAK_SPPT BETWEEN THN_AWAL AND THN_AKHIR AND S.NJOP_SPPT BETWEEN NJOP_MIN AND NJOP_MAX) AS NIL_TARIF,
        ': '||UPPER(FMT_TGL_TEKS(S.TGL_JATUH_TEMPO_SPPT)) AS TGL_JTTEMPO,
        ': '||UPPER(FMT_TGL_TEKS(S.TGL_TERBIT_SPPT)) AS TGL_TERBIT,
        ': '||UPPER(FMT_TGL_TEKS(S.TGL_CETAK_SPPT)) AS TGL_CETAK,
        DS.NM_WP, DS.JALAN_WP||' '||DS.BLOK_KAV_NO_WP AS ALAMAT_WP, DS.RT_WP||'/'||DS.RW_WP AS RTRW_WP, DS.KELURAHAN_WP, DS.KOTA_WP,
        DK.JALAN_OP||' '||DK.BLOK_KAV_NO_OP as ALAMAT_OP, DK.RT_OP||'/'||DK.RW_OP AS RTRW_OP, KEC.NM_KECAMATAN, KEL.NM_KELURAHAN,
        NVL(SP.BAYAR_DENDA,0) AS BAYAR_DENDA, NVL(SP.JML_BAYAR,0) AS JML_BAYAR, 
        NVL(SOB.LUAS_BUMI_BEBAN_SPPT,0) AS LUAS_BUMI_BERSAMA, NVL(SOB.LUAS_BNG_BEBAN_SPPT,0) AS LUAS_BNG_BERSAMA, 
        NVL(SOB.NJOP_BUMI_BEBAN_SPPT,0) AS NJOP_BUMI_BERSAMA, NVL(SOB.NJOP_BNG_BEBAN_SPPT,0) AS NJOP_BNG_BERSAMA,
        CASE WHEN (SOB.LUAS_BUMI_BEBAN_SPPT IS NULL OR SOB.LUAS_BUMI_BEBAN_SPPT<= 0) THEN 0 
            ELSE ROUND(SOB.NJOP_BUMI_BEBAN_SPPT/SOB.LUAS_BUMI_BEBAN_SPPT) END AS NJOP_BUMI_BERSAMA_PERM,
        CASE WHEN (SOB.LUAS_BNG_BEBAN_SPPT IS NULL OR SOB.LUAS_BNG_BEBAN_SPPT<= 0) THEN 0 
            ELSE ROUND(SOB.NJOP_BNG_BEBAN_SPPT/SOB.LUAS_BNG_BEBAN_SPPT) END AS NJOP_BNG_BERSAMA_PERM
        FROM SPPT S
        JOIN DAT_OBJEK_PAJAK DK ON S.KD_PROPINSI = DK.KD_PROPINSI AND S.KD_DATI2 = DK.KD_DATI2 
            AND S.KD_KECAMATAN = DK.KD_KECAMATAN AND S.KD_KELURAHAN = DK.KD_KELURAHAN 
            AND S.KD_BLOK = DK.KD_BLOK AND S.NO_URUT = DK.NO_URUT AND S.KD_JNS_OP = DK.KD_JNS_OP
        JOIN DAT_SUBJEK_PAJAK DS ON DS.SUBJEK_PAJAK_ID = DK.SUBJEK_PAJAK_ID
        JOIN REF_KECAMATAN KEC ON KEC.KD_PROPINSI = S.KD_PROPINSI AND KEC.KD_DATI2 = S.KD_DATI2 AND KEC.KD_KECAMATAN = S.KD_KECAMATAN
        JOIN REF_KELURAHAN KEL ON KEL.KD_PROPINSI = S.KD_PROPINSI AND KEL.KD_DATI2 = S.KD_DATI2 
            AND KEL.KD_KECAMATAN = S.KD_KECAMATAN AND KEL.KD_KELURAHAN = S.KD_KELURAHAN
        LEFT JOIN SPPT_OP_BERSAMA SOB ON (S.KD_PROPINSI = SOB.KD_PROPINSI AND S.KD_DATI2=SOB.KD_DATI2 AND S.KD_KECAMATAN=SOB.KD_KECAMATAN 
            AND S.KD_KELURAHAN =SOB.KD_KELURAHAN AND S.KD_BLOK = SOB.KD_BLOK AND S.NO_URUT = SOB.NO_URUT AND S.KD_JNS_OP = SOB.KD_JNS_OP 
            AND S.THN_PAJAK_SPPT = SOB.THN_PAJAK_SPPT)
        LEFT JOIN (SELECT SUM(DENDA_SPPT) AS BAYAR_DENDA, SUM(JML_SPPT_YG_DIBAYAR) AS JML_BAYAR
        		   FROM PEMBAYARAN_SPPT 
        		   WHERE KD_PROPINSI='$prop_kd' AND KD_DATI2='$kab_kd' AND KD_KECAMATAN='$kec_kd' AND KD_KELURAHAN='$kel_kd' 
                   AND KD_BLOK='$blok_kd' AND NO_URUT='$urut_no' AND KD_JNS_OP='$jns_kd' AND THN_PAJAK_SPPT='$thn'
        	) SP ON 1=1
        WHERE S.KD_PROPINSI='$prop_kd' AND S.KD_DATI2='$kab_kd' AND S.KD_KECAMATAN='$kec_kd' AND S.KD_KELURAHAN='$kel_kd' 
        AND S.KD_BLOK='$blok_kd' AND S.NO_URUT='$urut_no' AND S.KD_JNS_OP='$jns_kd' AND S.THN_PAJAK_SPPT='$thn' ";
        //
        $xx = $this->db->query($qq);
        $ret = array();
        // $aa = $xx->row();
        $ret['data'] = $xx->row();
        echo json_encode($ret);
    }

    public function detail() {
        $nopthn     = $this->uri->segment(4);
        $nopthn     = str_replace(".", "", $nopthn);
        $nopthn     = str_replace("-", "", $nopthn);

        $dt = $this->info_rinci_pbb_model->getsppt($nopthn);

        // var_dump($dt);die;

        if ($dt){
            // $njopkp         = (int)$dt->NJOP_SPPT - (int)$dt->NJOPTKP_SPPT;
            // $njopkp_njkp    = $dt->NIL_NJKP/100*$njopkp;
            $selisih        = (int)$dt->PBB_YG_HARUS_DIBAYAR_SPPT - (int)$dt->JML_BAYAR;
            if($selisih < 0) {
                $selisih = 0;
            }
            $jml_njop_bumi = ((int)$dt->NJOP_BUMI_SPPT + (int)$dt->NJOP_BUMI_BERSAMA);
            $jml_njop_bng = ((int)$dt->NJOP_BNG_SPPT + (int)$dt->NJOP_BNG_BERSAMA);
            $ttl_njop = ((int)$jml_njop_bumi + (int)$jml_njop_bng);
            $njopkp = ($ttl_njop - (int)$dt->NJOPTKP_SPPT);

            $njkp_pcnt = (int)$dt->NIL_NJKP;
            $tarif_pcnt = (int)$dt->NIL_TARIF;

            $njopkp_njkp = $njkp_pcnt/100*$njopkp;

            // $pbb_terhutang = (int)$dt->PBB_TERHUTANG_SPPT;
    
            $data['dt'] = array(
                'nop' => $dt->NOP_LKP, 
                'thn_pajak' => $dt->TAHUN, 
                'alamat_op' => $dt->ALAMAT_OP, 
                'rtrw_op' => $dt->RTRW_OP, 
                'kel_op' => $dt->NM_KELURAHAN, 
                'kec_op' => $dt->NM_KECAMATAN, 
                'kota_op' => 'BOGOR', 
                'nama_wp' => $dt->NM_WP, 
                'alamat_wp' => $dt->ALAMAT_WP, 
                'rtrw_wp' => $dt->RTRW_WP, 
                'kel_wp' => $dt->KELURAHAN_WP, 
                'kota_wp' => $dt->KOTA_WP, 
                'luas_bumi' => fmt_number($dt->LUAS_BUMI_SPPT), 
                'kelas_bumi' => $dt->KD_KLS_TANAH, 
                'njop_bumi_perm' => fmt_number($dt->NJOP_BUMI_PERM), 
                'njop_bumi' => fmt_number($dt->NJOP_BUMI_SPPT), 
                'luas_bng' => fmt_number($dt->LUAS_BNG_SPPT), 
                'kelas_bng' => $dt->KD_KLS_BNG, 
                'njop_bng_perm' => fmt_number($dt->NJOP_BNG_PERM), 
                'njop_bng' => fmt_number($dt->NJOP_BNG_SPPT), 
                'luas_bumi_bersama' => fmt_number($dt->LUAS_BUMI_BERSAMA), 
                'kelas_bumi_bersama' => $dt->KD_KLS_TANAH_BERSAMA, //
                'njop_bumi_perm_bersama' => fmt_number($dt->NJOP_BUMI_BERSAMA_PERM), 
                'njop_bumi_bersama' => fmt_number($dt->NJOP_BUMI_BERSAMA), 
                'luas_bng_bersama' => fmt_number($dt->LUAS_BNG_BERSAMA), 
                'kelas_bng_bersama' => $dt->KD_KLS_BNG_BERSAMA, //
                'njop_bng_perm_bersama' => fmt_number($dt->NJOP_BNG_BERSAMA_PERM), 
                'njop_bng_bersama' => fmt_number($dt->NJOP_BNG_BERSAMA), 
                'jml_njop_bumi' => fmt_number($jml_njop_bumi),
                // 'jml_njop_bumi' => fmt_number($dt->TTL_NJOP_BUMI), 
                'jml_njop_bng' => fmt_number($jml_njop_bng),
                // 'jml_njop_bng' => fmt_number($dt->TTL_NJOP_BNG), 
                'ttl_njop' => fmt_number($ttl_njop),
                // 'ttl_njop' => fmt_number($dt->NJOP_SPPT), 
                'njoptkp' => fmt_number($dt->NJOPTKP_SPPT),
                'njopkp' => fmt_number($njopkp),
                'txt_c' => '(' . $dt->NIL_NJKP . ' % x ' . fmt_number($njopkp) . ' )' ,
                // var txt_c           = '(' + njkp_pcnt + ' % x ' + fmt_number(njopkp) + ')' ;
                // 'njopkp' => fmt_number($njopkp_njkp), 
                'tarif' => $dt->NIL_TARIF . ' %', 
                'txt_e' => '(' . $dt->NIL_TARIF . ' % x ' . fmt_number($njopkp_njkp) . ' )' ,
                'pbb_terhutang' => fmt_number($dt->PBB_TERHUTANG_SPPT), 
                'faktor_pengurang' => fmt_number($dt->FAKTOR_PENGURANG_SPPT), 
                'txt_g' => '(' . fmt_number($dt->PBB_YG_HARUS_DIBAYAR_SPPT) . ' - ' . fmt_number($dt->FAKTOR_PENGURANG_SPPT) . ' )' ,
                'pbb_yg_harus_dibayar' => fmt_number($dt->PBB_YG_HARUS_DIBAYAR_SPPT), 
                'denda_yg_sudah_dibayar' => fmt_number($dt->BAYAR_DENDA), 
                'pbb_yg_sudah_dibayar' => fmt_number($dt->JML_BAYAR), 
                'selisih' => fmt_number($selisih), 
                'tgl_jttempo' => $dt->TGL_JTTEMPO, 
                'tgl_terbit' => $dt->TGL_TERBIT, 
                'tgl_cetak' => $dt->TGL_CETAK
            );

            $this->load->view('vinfo_rinci_pbb_detail', $data);

        } else {
            $this->session->set_flashdata('msg_success', 'Data tidak ditemukan..');
            redirect(active_module_url('info_rinci_pbb'));
        }
    }

    public function detail_2() {
        $nopthn     = $this->uri->segment(4);
        $nopthn     = str_replace(".", "", $nopthn);
        $nopthn     = str_replace("-", "", $nopthn);

        $dt = $this->info_rinci_pbb_model->getspptsim($nopthn);

        // var_dump($dt);die;

        if ($dt){
            // $njopkp         = (int)$dt->NJOP_SPPT - (int)$dt->NJOPTKP_SPPT;
            // $njopkp_njkp    = $dt->NIL_NJKP/100*$njopkp;
            $selisih        = (int)$dt->PBB_YG_HARUS_DIBAYAR_SPPT - (int)$dt->JML_BAYAR;
            if($selisih < 0) {
                $selisih = 0;
            }
            $jml_njop_bumi = ((int)$dt->NJOP_BUMI_SPPT + (int)$dt->NJOP_BUMI_BERSAMA);
            $jml_njop_bng = ((int)$dt->NJOP_BNG_SPPT + (int)$dt->NJOP_BNG_BERSAMA);
            $ttl_njop = ((int)$jml_njop_bumi + (int)$jml_njop_bng);
            $njopkp = ($ttl_njop - (int)$dt->NJOPTKP_SPPT);

            $njkp_pcnt = (int)$dt->NIL_NJKP;
            $tarif_pcnt = (int)$dt->NIL_TARIF;

            $njopkp_njkp = $njkp_pcnt/100*$njopkp;

            // $pbb_terhutang = (int)$dt->PBB_TERHUTANG_SPPT;
    
            $data['dt'] = array(
                'nop' => $dt->NOP_LKP, 
                'thn_pajak' => $dt->TAHUN, 
                'alamat_op' => $dt->ALAMAT_OP, 
                'rtrw_op' => $dt->RTRW_OP, 
                'kel_op' => $dt->NM_KELURAHAN, 
                'kec_op' => $dt->NM_KECAMATAN, 
                'kota_op' => 'BOGOR', 
                'nama_wp' => $dt->NM_WP, 
                'alamat_wp' => $dt->ALAMAT_WP, 
                'rtrw_wp' => $dt->RTRW_WP, 
                'kel_wp' => $dt->KELURAHAN_WP, 
                'kota_wp' => $dt->KOTA_WP, 
                'luas_bumi' => fmt_number($dt->LUAS_BUMI_SPPT), 
                'kelas_bumi' => $dt->KD_KLS_TANAH, 
                'njop_bumi_perm' => fmt_number($dt->NJOP_BUMI_PERM), 
                'njop_bumi' => fmt_number($dt->NJOP_BUMI_SPPT), 
                'luas_bng' => fmt_number($dt->LUAS_BNG_SPPT), 
                'kelas_bng' => $dt->KD_KLS_BNG, 
                'njop_bng_perm' => fmt_number($dt->NJOP_BNG_PERM), 
                'njop_bng' => fmt_number($dt->NJOP_BNG_SPPT), 
                'luas_bumi_bersama' => fmt_number($dt->LUAS_BUMI_BERSAMA), 
                'kelas_bumi_bersama' => $dt->KD_KLS_TANAH_BERSAMA, //
                'njop_bumi_perm_bersama' => fmt_number($dt->NJOP_BUMI_BERSAMA_PERM), 
                'njop_bumi_bersama' => fmt_number($dt->NJOP_BUMI_BERSAMA), 
                'luas_bng_bersama' => fmt_number($dt->LUAS_BNG_BERSAMA), 
                'kelas_bng_bersama' => $dt->KD_KLS_BNG_BERSAMA, //
                'njop_bng_perm_bersama' => fmt_number($dt->NJOP_BNG_BERSAMA_PERM), 
                'njop_bng_bersama' => fmt_number($dt->NJOP_BNG_BERSAMA), 
                'jml_njop_bumi' => fmt_number($jml_njop_bumi),
                // 'jml_njop_bumi' => fmt_number($dt->TTL_NJOP_BUMI), 
                'jml_njop_bng' => fmt_number($jml_njop_bng),
                // 'jml_njop_bng' => fmt_number($dt->TTL_NJOP_BNG), 
                'ttl_njop' => fmt_number($ttl_njop),
                // 'ttl_njop' => fmt_number($dt->NJOP_SPPT), 
                'njoptkp' => fmt_number($dt->NJOPTKP_SPPT),
                'njopkp' => fmt_number($njopkp),
                'txt_c' => '(' . $dt->NIL_NJKP . ' % x ' . fmt_number($njopkp) . ' )' ,
                // var txt_c           = '(' + njkp_pcnt + ' % x ' + fmt_number(njopkp) + ')' ;
                // 'njopkp' => fmt_number($njopkp_njkp), 
                'tarif' => $dt->NIL_TARIF . ' %', 
                'txt_e' => '(' . $dt->NIL_TARIF . ' % x ' . fmt_number($njopkp_njkp) . ' )' ,
                'pbb_terhutang' => fmt_number($dt->PBB_TERHUTANG_SPPT), 
                'faktor_pengurang' => fmt_number($dt->FAKTOR_PENGURANG_SPPT), 
                'txt_g' => '(' . fmt_number($dt->PBB_YG_HARUS_DIBAYAR_SPPT) . ' - ' . fmt_number($dt->FAKTOR_PENGURANG_SPPT) . ' )' ,
                'pbb_yg_harus_dibayar' => fmt_number($dt->PBB_YG_HARUS_DIBAYAR_SPPT), 
                'denda_yg_sudah_dibayar' => fmt_number($dt->BAYAR_DENDA), 
                'pbb_yg_sudah_dibayar' => fmt_number($dt->JML_BAYAR), 
                'selisih' => fmt_number($selisih), 
                'tgl_jttempo' => $dt->TGL_JTTEMPO, 
                'tgl_terbit' => $dt->TGL_TERBIT, 
                'tgl_cetak' => $dt->TGL_CETAK
            );

            $this->load->view('vinfo_rinci_pbb_detail', $data);

        } else {
            $this->session->set_flashdata('msg_success', 'Data tidak ditemukan..');
            redirect(active_module_url('info_rinci_pbb'));
        }
    }

    public function detail_3() {
        $nopthn     = $this->uri->segment(4);
        $nopthn     = str_replace(".", "", $nopthn);
        $nopthn     = str_replace("-", "", $nopthn);

        $dt = $this->info_rinci_pbb_model->getspptsimtmp($nopthn);

        // var_dump($dt);die;

        if ($dt){
            // $njopkp         = (int)$dt->NJOP_SPPT - (int)$dt->NJOPTKP_SPPT;
            // $njopkp_njkp    = $dt->NIL_NJKP/100*$njopkp;
            $selisih        = (int)$dt->PBB_YG_HARUS_DIBAYAR_SPPT - (int)$dt->JML_BAYAR;
            if($selisih < 0) {
                $selisih = 0;
            }
            $jml_njop_bumi = ((int)$dt->NJOP_BUMI_SPPT + (int)$dt->NJOP_BUMI_BERSAMA);
            $jml_njop_bng = ((int)$dt->NJOP_BNG_SPPT + (int)$dt->NJOP_BNG_BERSAMA);
            $ttl_njop = ((int)$jml_njop_bumi + (int)$jml_njop_bng);
            $njopkp = ($ttl_njop - (int)$dt->NJOPTKP_SPPT);

            $njkp_pcnt = (int)$dt->NIL_NJKP;
            $tarif_pcnt = (int)$dt->NIL_TARIF;

            $njopkp_njkp = $njkp_pcnt/100*$njopkp;

            // $pbb_terhutang = (int)$dt->PBB_TERHUTANG_SPPT;
    
            $data['dt'] = array(
                'nop' => $dt->NOP_LKP, 
                'thn_pajak' => $dt->TAHUN, 
                'alamat_op' => $dt->ALAMAT_OP, 
                'rtrw_op' => $dt->RTRW_OP, 
                'kel_op' => $dt->NM_KELURAHAN, 
                'kec_op' => $dt->NM_KECAMATAN, 
                'kota_op' => 'BOGOR', 
                'nama_wp' => $dt->NM_WP, 
                'alamat_wp' => $dt->ALAMAT_WP, 
                'rtrw_wp' => $dt->RTRW_WP, 
                'kel_wp' => $dt->KELURAHAN_WP, 
                'kota_wp' => $dt->KOTA_WP, 
                'luas_bumi' => fmt_number($dt->LUAS_BUMI_SPPT), 
                'kelas_bumi' => $dt->KD_KLS_TANAH, 
                'njop_bumi_perm' => fmt_number($dt->NJOP_BUMI_PERM), 
                'njop_bumi' => fmt_number($dt->NJOP_BUMI_SPPT), 
                'luas_bng' => fmt_number($dt->LUAS_BNG_SPPT), 
                'kelas_bng' => $dt->KD_KLS_BNG, 
                'njop_bng_perm' => fmt_number($dt->NJOP_BNG_PERM), 
                'njop_bng' => fmt_number($dt->NJOP_BNG_SPPT), 
                'luas_bumi_bersama' => fmt_number($dt->LUAS_BUMI_BERSAMA), 
                'kelas_bumi_bersama' => $dt->KD_KLS_TANAH_BERSAMA, //
                'njop_bumi_perm_bersama' => fmt_number($dt->NJOP_BUMI_BERSAMA_PERM), 
                'njop_bumi_bersama' => fmt_number($dt->NJOP_BUMI_BERSAMA), 
                'luas_bng_bersama' => fmt_number($dt->LUAS_BNG_BERSAMA), 
                'kelas_bng_bersama' => $dt->KD_KLS_BNG_BERSAMA, //
                'njop_bng_perm_bersama' => fmt_number($dt->NJOP_BNG_BERSAMA_PERM), 
                'njop_bng_bersama' => fmt_number($dt->NJOP_BNG_BERSAMA), 
                'jml_njop_bumi' => fmt_number($jml_njop_bumi),
                // 'jml_njop_bumi' => fmt_number($dt->TTL_NJOP_BUMI), 
                'jml_njop_bng' => fmt_number($jml_njop_bng),
                // 'jml_njop_bng' => fmt_number($dt->TTL_NJOP_BNG), 
                'ttl_njop' => fmt_number($ttl_njop),
                // 'ttl_njop' => fmt_number($dt->NJOP_SPPT), 
                'njoptkp' => fmt_number($dt->NJOPTKP_SPPT),
                'njopkp' => fmt_number($njopkp),
                'txt_c' => '(' . $dt->NIL_NJKP . ' % x ' . fmt_number($njopkp) . ' )' ,
                // var txt_c           = '(' + njkp_pcnt + ' % x ' + fmt_number(njopkp) + ')' ;
                // 'njopkp' => fmt_number($njopkp_njkp), 
                'tarif' => $dt->NIL_TARIF . ' %', 
                'txt_e' => '(' . $dt->NIL_TARIF . ' % x ' . fmt_number($njopkp_njkp) . ' )' ,
                'pbb_terhutang' => fmt_number($dt->PBB_TERHUTANG_SPPT), 
                'faktor_pengurang' => fmt_number($dt->FAKTOR_PENGURANG_SPPT), 
                'txt_g' => '(' . fmt_number($dt->PBB_YG_HARUS_DIBAYAR_SPPT) . ' - ' . fmt_number($dt->FAKTOR_PENGURANG_SPPT) . ' )' ,
                'pbb_yg_harus_dibayar' => fmt_number($dt->PBB_YG_HARUS_DIBAYAR_SPPT), 
                'denda_yg_sudah_dibayar' => fmt_number($dt->BAYAR_DENDA), 
                'pbb_yg_sudah_dibayar' => fmt_number($dt->JML_BAYAR), 
                'selisih' => fmt_number($selisih), 
                'tgl_jttempo' => $dt->TGL_JTTEMPO, 
                'tgl_terbit' => $dt->TGL_TERBIT, 
                'tgl_cetak' => $dt->TGL_CETAK
            );

            $this->load->view('vinfo_rinci_pbb_detail', $data);

        } else {
            $this->session->set_flashdata('msg_success', 'Data tidak ditemukan..');
            redirect(active_module_url('info_rinci_pbb'));
        }
    }

}
