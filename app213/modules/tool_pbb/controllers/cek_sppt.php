<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cek_sppt extends CI_Controller
{

  /**
   * Index Page for this controller.
   *
   * Maps to the following URL
   *        http://example.com/index.php/welcome
   *    - or -
   *        http://example.com/index.php/welcome/index
   *    - or -
   * Since this controller is set as the default controller in
   * config/routes.php, it's displayed at http://example.com/
   *
   * So any other public methods not prefixed with an underscore will
   * map to /index.php/welcome/<method_name>
   * @see https://codeigniter.com/user_guide/general/urls.html
   */

  private $controller = 'cek_sppt';
  public function __construct()
  {
    parent::__construct();
    if (!is_login()) {
      echo "<script>window.location.replace('" . base_url() . "');</script>";
      exit;
    }

    $module = 'cek_sppt';
    $this->load->library('module_auth', array(
      'module' => $module
    ));

    $this->load->model(array(
      'apps_model'
    ));

    $this->load->helper(active_module());
    $this->load->model('cek_sppt_model');
  }


  public function index()
  {
    $data['page_menu']  = 'cek_sppt';
    $data['current']    = '';
    $data['controller'] = $this->controller;
    $data['apps']       = $this->apps_model->get_active_only();

    $this->load->view('vcek_sppt', $data);
  }

  public function grid()
  {
    $nop   = $this->input->get('nop');
    $tahun = $this->input->get('tahun');
    if(empty($nop) || $nop == ''){
        $nop = '99.99.999.999.999.9999.9';
    }
    if(empty($tahun) || $tahun == ''){
        $tahun = '9999';
    }
    $nop = str_replace(['.', ',', '-'], '', $nop);

    $prop_kd = substr($nop, 0, 2);
    $kab_kd  = substr($nop, 2, 2);
    $kec_kd  = substr($nop, 4, 3);
    $kel_kd  = substr($nop, 7, 3);
    $blok_kd = substr($nop, 10, 3);
    $urut_no = substr($nop, 13, 4);
    $jns_kd  = substr($nop, 17, 1);

    $this->load->library('Datatables');
    $this->datatables->select("
        KD_PROPINSI || KD_DATI2 || KD_KECAMATAN || KD_KELURAHAN || KD_BLOK || NO_URUT || KD_JNS_OP AS NOP,
        thn_pajak_sppt AS TAHUN,
        nm_wp_sppt AS NAMA_WP,
        jln_wp_sppt || ', ' || blok_kav_no_wp_sppt || ', RW ' || rw_wp_sppt || ', RT ' || rt_wp_sppt || ', ' || kelurahan_wp_sppt || ', ' || kota_wp_sppt AS alamat_wp,
         NVL(TO_CHAR(tgl_jatuh_tempo_sppt,'DD-MM-YYYY'),'') AS jatuh_tempo,
         pbb_terhutang_sppt AS terhutang,
        faktor_pengurang_sppt AS pengurang,
        pbb_yg_harus_dibayar_sppt AS tagihan", false);
    $this->datatables->from('SPPT');

    if($nop != '99.99.999.999.999.9999.9' && $tahun == '9999') {
        $this->datatables->where('KD_PROPINSI', $prop_kd);
        $this->datatables->where('KD_DATI2', $kab_kd);
        $this->datatables->where('KD_KECAMATAN', $kec_kd);
        $this->datatables->where('KD_KELURAHAN', $kel_kd);
        $this->datatables->where('KD_BLOK', $blok_kd);
        $this->datatables->where('NO_URUT', $urut_no);
        $this->datatables->where('KD_JNS_OP', $jns_kd);
    }elseif($nop == '99.99.999.999.999.9999.9' && $tahun == '9999'){
        $this->datatables->where('KD_PROPINSI', $prop_kd);
        $this->datatables->where('KD_DATI2', $kab_kd);
        $this->datatables->where('KD_KECAMATAN', $kec_kd);
        $this->datatables->where('KD_KELURAHAN', $kel_kd);
        $this->datatables->where('KD_BLOK', $blok_kd);
        $this->datatables->where('NO_URUT', $urut_no);
        $this->datatables->where('KD_JNS_OP', $jns_kd);
        $this->datatables->where('THN_PAJAK_SPPT', $tahun);
    }elseif($nop != '99.99.999.999.999.9999.9' && $tahun != '9999') {
        $this->datatables->where('KD_PROPINSI', $prop_kd);
        $this->datatables->where('KD_DATI2', $kab_kd);
        $this->datatables->where('KD_KECAMATAN', $kec_kd);
        $this->datatables->where('KD_KELURAHAN', $kel_kd);
        $this->datatables->where('KD_BLOK', $blok_kd);
        $this->datatables->where('NO_URUT', $urut_no);
        $this->datatables->where('KD_JNS_OP', $jns_kd);
        $this->datatables->where('THN_PAJAK_SPPT', $tahun);
    }

    // if (!empty($nop) ) {
    //     $nop = trim($nop);
    //     $this->datatables->where("trim(KD_PROPINSI||KD_DATI2||KD_KECAMATAN||KD_KELURAHAN||KD_BLOK||NO_URUT||KD_JNS_OP) LIKE '%$nop%'");
    // }

    echo $this->datatables->generate();
  }

  public function detail(){
    $data['page_menu']  = 'cek_sppt_detail';
    $data['current']    = '';
    $data['controller'] = $this->controller;
    $data['apps']       = $this->apps_model->get_active_only();

    $nop = $this->uri->segment(4);
    $tahun = $this->uri->segment(5);
    $data['nop'] = $nop;
    $data['tahun'] = $tahun;

    $string_replace = array('.', '-');
    $nop = str_replace($string_replace, '', $nop);
    $prop_kd = substr($nop, 0, 2);
    $kab_kd  = substr($nop, 2, 2);
    $kec_kd  = substr($nop, 4, 3);
    $kel_kd  = substr($nop, 7, 3);
    $blok_kd = substr($nop, 10, 3);
    $urut_no = substr($nop, 13, 4);
    $jns_kd  = substr($nop, 17, 1);

    $nopleng = $prop_kd . '.' . $kab_kd . '-' . $kec_kd . '.' . $kel_kd . '-' . $blok_kd . '.' . $urut_no . '.' . $jns_kd;
    $data['nopleng'] = $nopleng;

    $this->load->view('vcek_sppt_detail', $data);
  }

  public function get()
  {
    $nop = $this->uri->segment(4);
    $thn = $this->uri->segment(5);
    $string_replace = array('.', '-');
    $nop = str_replace($string_replace, '', $nop);
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
        S.NM_WP_SPPT, S.JLN_WP_SPPT||' '||S.BLOK_KAV_NO_WP_SPPT AS ALAMAT_WP, S.RW_WP_SPPT||'/'||S.RT_WP_SPPT AS RTRW_WP, S.KELURAHAN_WP_SPPT, S.KOTA_WP_SPPT,
        DK.JALAN_OP||' '||DK.BLOK_KAV_NO_OP as ALAMAT_OP, DK.RW_OP||'/'||DK.RT_OP AS RTRW_OP, KEC.NM_KECAMATAN, KEL.NM_KELURAHAN, DT.NM_DATI2,
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
        JOIN REF_DATI2 DT ON DT.KD_PROPINSI = S.KD_PROPINSI AND DT.KD_DATI2 = S.KD_DATI2
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

    $xx = $this->db->query($qq);
    $ret = array();
    $ret['data'] = $xx->row();
    echo json_encode($ret);
  }
}
