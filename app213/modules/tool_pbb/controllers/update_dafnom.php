<?php
defined('BASEPATH') or exit('No direct script access allowed');

class update_dafnom extends CI_Controller
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

  private $controller = 'update_dafnom';
  public function __construct()
  {
    parent::__construct();
    if (!is_login()) {
      echo "<script>window.location.replace('" . base_url() . "');</script>";
      exit;
    }

    $module = 'update_dafnom';
    $this->load->library('module_auth', array(
      'module' => $module
    ));

    $this->load->model(array(
      'apps_model'
    ));

    $this->load->helper(active_module());
    $this->load->model('update_dafnom_model');
  }


  public function index()
  {
    $data['page_menu']  = 'update_dafnom';
    $data['current']    = '';
    $data['controller'] = $this->controller;
    $data['apps']       = $this->apps_model->get_active_only();

    $this->load->view('vupdate_dafnom', $data);
  }

  public function grid()
  {
    $nop   = $this->input->get('nop');
    $tahun   = $this->input->get('tahun');
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

    $one = 20;
    $two = 10;

    $this->load->library('Datatables');
          $this->datatables->select("
          DOP.KD_PROPINSI || DOP.KD_DATI2 || DOP.KD_KECAMATAN || DOP.KD_KELURAHAN || DOP.KD_BLOK || DOP.NO_URUT || DOP.KD_JNS_OP AS NOP,
          DOP.THN_PEMBENTUKAN AS TAHUN,
          DAS.NM_WP AS NAMA_WP,
          DOP.JALAN_OP || ', ' || DOP.BLOK_KAV_NO_OP || ', RW ' || DOP.RW_OP || ', RT ' || DOP.RT_OP AS ALAMAT_OP,
          LM1.NM_LOOKUP_ITEM AS JENIS_BUMI,
          RJ.NM_JPB AS JPB_BANGUNAN,
          LM2.NM_LOOKUP_ITEM AS STATUS_WP,
          DOP.KATEGORI_OP AS KATEGORI_OP,
          DOP.KETERANGAN AS KETERANGAN,
          DOP.TGL_PEMBENTUKAN AS TGL_PEMBUATAN,
          DOP.NIP_PEMBENTUK AS NIP_PEREKAM", false);
      $this->datatables->from('DAFNOM_OP DOP', false);
      // $this->datatables->join('(SELECT 
      //         KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP, 
      //         NM_WP_SPPT, MAX(THN_PAJAK_SPPT) AS THN
      //     FROM SPPT 
      //     GROUP BY 
      //         KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP, NM_WP_SPPT) ST', 
      //     'DOP.KD_PROPINSI = ST.KD_PROPINSI AND DOP.KD_DATI2 = ST.KD_DATI2 AND DOP.KD_KECAMATAN = ST.KD_KECAMATAN AND DOP.KD_KELURAHAN = ST.KD_KELURAHAN AND DOP.KD_BLOK = ST.KD_BLOK AND DOP.NO_URUT = ST.NO_URUT AND DOP.KD_JNS_OP = ST.KD_JNS_OP', 'inner');
      $this->datatables->join("DAT_OBJEK_PAJAK DAP", "DOP.KD_PROPINSI = DAP.KD_PROPINSI AND DOP.KD_DATI2 = DAP.KD_DATI2 AND DOP.KD_KECAMATAN = DAP.KD_KECAMATAN AND DOP.KD_KELURAHAN = DAP.KD_KELURAHAN AND DOP.KD_BLOK = DAP.KD_BLOK AND DOP.NO_URUT = DAP.NO_URUT AND DOP.KD_JNS_OP = DAP.KD_JNS_OP", 'left');
      $this->datatables->join("DAT_SUBJEK_PAJAK DAS", "DAP.SUBJEK_PAJAK_ID = DAS.SUBJEK_PAJAK_ID", 'left');

      $this->datatables->join("LOOKUP_ITEM LM1", "DOP.JNS_BUMI = LM1.KD_LOOKUP_ITEM AND LM1.KD_LOOKUP_GROUP = '$one'", 'left');
      $this->datatables->join("LOOKUP_ITEM LM2", "DOP.KD_STATUS_WP = LM2.KD_LOOKUP_ITEM AND LM2.KD_LOOKUP_GROUP = '$two'", 'left');
      $this->datatables->join('REF_JPB RJ', 'DOP.KD_JPB = RJ.KD_JPB', 'left', false);

        if($nop != '99.99.999.999.999.9999.9' && $tahun == '9999') {
            $this->datatables->where('DOP.KD_PROPINSI', $prop_kd);
            $this->datatables->where('DOP.KD_DATI2', $kab_kd);
            $this->datatables->where('DOP.KD_KECAMATAN', $kec_kd);
            $this->datatables->where('DOP.KD_KELURAHAN', $kel_kd);
            $this->datatables->where('DOP.KD_BLOK', $blok_kd);
            $this->datatables->where('DOP.NO_URUT', $urut_no);
            $this->datatables->where('DOP.KD_JNS_OP', $jns_kd);
        }elseif($nop == '99.99.999.999.999.9999.9' && $tahun == '9999'){
            $this->datatables->where('DOP.KD_PROPINSI', $prop_kd);
            $this->datatables->where('DOP.KD_DATI2', $kab_kd);
            $this->datatables->where('DOP.KD_KECAMATAN', $kec_kd);
            $this->datatables->where('DOP.KD_KELURAHAN', $kel_kd);
            $this->datatables->where('DOP.KD_BLOK', $blok_kd);
            $this->datatables->where('DOP.NO_URUT', $urut_no);
            $this->datatables->where('DOP.KD_JNS_OP', $jns_kd);
            $this->datatables->where('DOP.THN_PEMBENTUKAN', $tahun);
        }elseif($nop != '99.99.999.999.999.9999.9' && $tahun != '9999') {
            $this->datatables->where('DOP.KD_PROPINSI', $prop_kd);
            $this->datatables->where('DOP.KD_DATI2', $kab_kd);
            $this->datatables->where('DOP.KD_KECAMATAN', $kec_kd);
            $this->datatables->where('DOP.KD_KELURAHAN', $kel_kd);
            $this->datatables->where('DOP.KD_BLOK', $blok_kd);
            $this->datatables->where('DOP.NO_URUT', $urut_no);
            $this->datatables->where('DOP.KD_JNS_OP', $jns_kd);
            $this->datatables->where('DOP.THN_PEMBENTUKAN', $tahun);
        }

    echo $this->datatables->generate();

    // $query = "SELECT 
    //             DOP.KD_PROPINSI || DOP.KD_DATI2 || DOP.KD_KECAMATAN || DOP.KD_KELURAHAN || DOP.KD_BLOK || DOP.NO_URUT || DOP.KD_JNS_OP AS NOP,
    //             DOP.THN_PEMBENTUKAN AS TAHUN,
    //             ST.NM_WP_SPPT AS NAMA_WP,
    //             DOP.JALAN_OP || ', ' || DOP.BLOK_KAV_NO_OP || ', RW ' || DOP.RW_OP || ', RT ' || DOP.RT_OP AS ALAMAT_OP,
    //             LM1.NM_LOOKUP_ITEM AS JENIS_BUMI,
    //             RJ.NM_JPB AS JPB_BANGUNAN,
    //             LM2.NM_LOOKUP_ITEM AS STATUS_WP,
    //             DOP.KATEGORI_OP AS KATEGORI_OP,
    //             DOP.KETERANGAN AS KETERANGAN,
    //             DOP.TGL_PEMBENTUKAN AS TGL_PEMBUATAN,
    //             DOP.NIP_PEMBENTUK AS NIP_PEREKAM
    //         FROM 
    //             DAFNOM_OP DOP
    //         INNER JOIN 
    //             (SELECT 
    //                 KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP, 
    //                 NM_WP_SPPT, MAX(THN_PAJAK_SPPT) AS THN
    //             FROM 
    //                 SPPT 
    //             GROUP BY 
    //                 KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP, NM_WP_SPPT) ST 
    //         ON 
    //             DOP.KD_PROPINSI = ST.KD_PROPINSI AND 
    //             DOP.KD_DATI2 = ST.KD_DATI2 AND 
    //             DOP.KD_KECAMATAN = ST.KD_KECAMATAN AND 
    //             DOP.KD_KELURAHAN = ST.KD_KELURAHAN AND 
    //             DOP.KD_BLOK = ST.KD_BLOK AND 
    //             DOP.NO_URUT = ST.NO_URUT AND 
    //             DOP.KD_JNS_OP = ST.KD_JNS_OP
    //         INNER JOIN 
    //             LOOKUP_ITEM LM1 
    //         ON 
    //             DOP.JNS_BUMI = LM1.KD_LOOKUP_ITEM AND 
    //             LM1.KD_LOOKUP_GROUP = '20'
    //         INNER JOIN 
    //             LOOKUP_ITEM LM2 
    //         ON 
    //             DOP.KD_STATUS_WP = LM2.KD_LOOKUP_ITEM AND 
    //             LM2.KD_LOOKUP_GROUP = '10'
    //         INNER JOIN 
    //             REF_JPB RJ 
    //         ON 
    //             DOP.KD_JPB = RJ.KD_JPB";
  }

  public function update_kategori()
  {
    $nop = $this->input->post('nop');
    $tahun = $this->input->post('tahun');
    $kategori = $this->input->post('kategori');
    // $nama = $this->input->post('nama');

    $sql = "UPDATE DAFNOM_OP SET KATEGORI_OP = '".$kategori."' WHERE KD_PROPINSI||KD_DATI2||KD_KECAMATAN||KD_KELURAHAN||KD_BLOK||NO_URUT||KD_JNS_OP = '".$nop."' AND THN_PEMBENTUKAN = '".$tahun."' ";

    $this->db->simple_qry_eon_ora($sql);
        // $this->db->query($sql);

    echo json_encode(['code' => '200', 'msg' => 'Berhasil']);
  }
} 
