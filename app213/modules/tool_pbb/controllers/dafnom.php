<?php
defined('BASEPATH') or exit('No direct script access allowed');

class dafnom extends CI_Controller
{

  private $controller = 'dafnom';
  public function __construct()
  {
    parent::__construct();
    if (!is_login()) {
      echo "<script>window.location.replace('" . base_url() . "');</script>";
      exit;
    }

    $module = 'dafnom';
    $this->load->library('module_auth', array(
      'module' => $module
    ));

    $this->load->model(array(
      'apps_model'
    ));

    $this->load->helper(active_module());
    $this->load->model('dafnom_model');
  }


  public function index()
  {
    $data['page_menu']  = 'dafnom';
    $data['current']    = '';
    $data['controller'] = $this->controller;
    $data['apps']       = $this->apps_model->get_active_only();

    $pawal_kec  = 999999;
    $pawal_kel  = 999999;

    //------------------------------------------------------------------
        $select_data  = $this->dafnom_model->get_select_kecamatan();
        $options      = array();
        $kec_id = '';
        if($select_data) {
            $options['999999'] = 'SEMUA KECAMATAN';
        foreach ($select_data as $row) {
          if($kec_id == '') $kec_id = $row->KD_KECAMATAN;
          $options[$row->KD_KECAMATAN] = $row->NM_KECAMATAN;
        }}
        $js                       = 'id="KD_KEC" class="form-control" onChange="get_kelurahan(this.value);" required ';
        $data['select_kecamatan'] = form_dropdown('KD_KEC', $options, $pawal_kec, $js);
        //------------------------------------------------------------------
        $select_data = $this->dafnom_model->get_select_kelurahan($pawal_kec);
        $options     = array();
            $options['999999'] = 'SEMUA KELURAHAN';
        if($select_data) {
        foreach ($select_data as $row) {
          $options[$row->KD_KELURAHAN] = $row->NM_KELURAHAN;
        }}
        $js                       = 'id="KD_KEL" class="form-control" required ';
        $data['select_kelurahan'] = form_dropdown('KD_KEL', $options, $pawal_kel, $js);
        //------------------------------------------------------------------

    $this->load->view('vdafnom', $data);
  }

  public function grid()
  {
    $nop   = $this->input->get('nop');
    $tahun   = $this->input->get('tahun');
    $kec   = $this->input->get('kec');
    $kel   = $this->input->get('kel');

    // if(empty($nop) || $nop == ''){
    //     $nop = '99.99.999.999.999.9999.9';
    // }
    if(empty($tahun) || $tahun == ''){
        $tahun = '9999';
    }
    if(empty($kec) || $kec == ''){
        $kec = '999999';
    }
    if(empty($kel) || $kel == ''){
        $kel = '999999';
    }

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
          CASE
          WHEN DOP.KATEGORI_OP = '1' THEN 'Tidak ada Objek'
          WHEN DOP.KATEGORI_OP = '2' THEN 'Double'
          WHEN DOP.KATEGORI_OP = '3' THEN 'Tidak ada Subjek'
          WHEN DOP.KATEGORI_OP = '4' THEN 'Normal'
          ELSE '-' END AS KATEGORI_OP,
          DOP.KETERANGAN AS KETERANGAN,
          DOP.TGL_PEMBENTUKAN AS TGL_PEMBUATAN,
          DOP.NIP_PEMBENTUK AS NIP_PEREKAM,
          DOP.KD_PROPINSI || DOP.KD_DATI2 || DOP.KD_KECAMATAN || DOP.KD_KELURAHAN || DOP.KD_BLOK || DOP.NO_URUT || DOP.KD_JNS_OP || DOP.THN_PEMBENTUKAN AS NOPTHN", false);
      $this->datatables->from('DAFNOM_OP DOP', false);
      $this->datatables->join("DAT_OBJEK_PAJAK DAP", "DOP.KD_PROPINSI = DAP.KD_PROPINSI AND DOP.KD_DATI2 = DAP.KD_DATI2 AND DOP.KD_KECAMATAN = DAP.KD_KECAMATAN AND DOP.KD_KELURAHAN = DAP.KD_KELURAHAN AND DOP.KD_BLOK = DAP.KD_BLOK AND DOP.NO_URUT = DAP.NO_URUT AND DOP.KD_JNS_OP = DAP.KD_JNS_OP", 'left');
      $this->datatables->join("DAT_SUBJEK_PAJAK DAS", "DAP.SUBJEK_PAJAK_ID = DAS.SUBJEK_PAJAK_ID", 'left');

      $this->datatables->join("LOOKUP_ITEM LM1", "DOP.JNS_BUMI = LM1.KD_LOOKUP_ITEM AND LM1.KD_LOOKUP_GROUP = '$one'", 'left');
      $this->datatables->join("LOOKUP_ITEM LM2", "DOP.KD_STATUS_WP = LM2.KD_LOOKUP_ITEM AND LM2.KD_LOOKUP_GROUP = '$two'", 'left');
      $this->datatables->join('REF_JPB RJ', 'DOP.KD_JPB = RJ.KD_JPB', 'left', false);

      if($nop){
        $nop = str_replace(['.', ',', '-'], '', $nop);
        $prop_kd = substr($nop, 0, 2);
        $kab_kd  = substr($nop, 2, 2);
        $kec_kd  = substr($nop, 4, 3);
        $kel_kd  = substr($nop, 7, 3);
        $blok_kd = substr($nop, 10, 3);
        $urut_no = substr($nop, 13, 4);
        $jns_kd  = substr($nop, 17, 1);

        $this->datatables->where('DOP.KD_PROPINSI', $prop_kd);
        $this->datatables->where('DOP.KD_DATI2', $kab_kd);
        $this->datatables->where('DOP.KD_KECAMATAN', $kec_kd);
        $this->datatables->where('DOP.KD_KELURAHAN', $kel_kd);
        $this->datatables->where('DOP.KD_BLOK', $blok_kd);
        $this->datatables->where('DOP.NO_URUT', $urut_no);
        $this->datatables->where('DOP.KD_JNS_OP', $jns_kd);
      }
        

        if ($tahun != '9999') {
            $this->datatables->where('DOP.THN_PEMBENTUKAN', $tahun);
        }

        if ($kec != '999999'){
            $this->datatables->where('DOP.KD_KECAMATAN', $kec);
        }

        if ($kel != '999999'){
            $this->datatables->where('DOP.KD_KELURAHAN', $kel);
        }

      $result = $this->datatables->generate();

      echo $result;
  }

  public function search(){
    $nop   = $this->input->get('nop');
    $tahun   = $this->input->get('tahun');
    $kec   = $this->input->get('kec');
    $kel   = $this->input->get('kel');

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

    $select1  = $this->dafnom_model->get_k($nop, $tahun, $kec, $kel);

    if(!$select1){
      echo json_encode(['code' => '200', 'msg' => 'Berhasil']);
    }

  }

  function exp_excel_csv(){
    $kd_kec = $this->input->get('kec');
    $kd_kel = $this->input->get('kel');
    $c_thn = $this->input->get('tahun');
    $nop = $this->input->get('nop');
    $filex    = $this->input->get('filex');

    $nop = str_replace(['.', ',', '-'], '', $nop);

    // if (empty($c_thn)) {
    //   $c_thn = "2024";
    // }

    $query = $this->dafnom_model->query_cetak($kd_kec, $kd_kel, $c_thn, $nop);

    // var_dump($query);die;

    $params = array(
      'query' => $query,
    );

    $rpt  = 'rpt_rekap_dafnom';
    $type = $filex; //'xls';

    $jasper = $this->load->library('Jasper_ora');
        
    echo $jasper->export($rpt, $params, $type, TRUE);
  }

  function get_kelurahan() {
        $kec_id    = $this->uri->segment(4);
        $kelurahan = $this->dafnom_model->get_select_kelurahan($kec_id);
        echo json_encode($kelurahan);
    }
} 
