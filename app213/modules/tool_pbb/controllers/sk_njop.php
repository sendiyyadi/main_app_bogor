<?php
defined('BASEPATH') or exit('No direct script access allowed');

class sk_njop extends CI_Controller
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

  private $controller = 'sk_njop';
  public function __construct()
  {
    parent::__construct();
    if (!is_login()) {
      echo "<script>window.location.replace('" . base_url() . "');</script>";
      exit;
    }

    $module = 'sk_njop';
    $this->load->library('module_auth', array(
      'module' => $module
    ));

    $this->load->model(array(
      'apps_model'
    ));

    $this->load->helper(active_module());
    $this->load->model('sk_njop_model');
  }


  public function index()
  {
    $data['page_menu']  = 'sk_njop';
    $data['current']    = '';
    $data['controller'] = $this->controller;
    $data['apps']       = $this->apps_model->get_active_only();

    $this->load->view('vsk_njop', $data);
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

        $this->load->library('Datatables');
        $this->datatables->select("
            O.KD_PROPINSI || O.KD_DATI2 || O.KD_KECAMATAN || O.KD_KELURAHAN || O.KD_BLOK || O.NO_URUT || O.KD_JNS_OP AS NOP,
            S.NM_WP AS NAMA_WP,
            O.JALAN_OP||', '||O.BLOK_KAV_NO_OP||', '||O.RW_OP||', '||O.RT_OP AS ALAMAT_OP,
            S.JALAN_WP||', '||S.BLOK_KAV_NO_WP||', '||S.RW_WP||', '||S.RT_WP||', '||S.KELURAHAN_WP||', '||S.KOTA_WP AS ALAMAT_WP
            ", false);
        $this->datatables->from('DAT_OBJEK_PAJAK O');
        $this->datatables->join("DAT_SUBJEK_PAJAK S", "O.SUBJEK_PAJAK_ID = S.SUBJEK_PAJAK_ID", "INNER");

        $select = '';

       if($nop != '99.99.999.999.999.9999.9' && $tahun == '9999') {
            $this->datatables->where('O.KD_PROPINSI', $prop_kd);
            $this->datatables->where('O.KD_DATI2', $kab_kd);
            $this->datatables->where('O.KD_KECAMATAN', $kec_kd);
            $this->datatables->where('O.KD_KELURAHAN', $kel_kd);
            $this->datatables->where('O.KD_BLOK', $blok_kd);
            $this->datatables->where('O.NO_URUT', $urut_no);
            $this->datatables->where('O.KD_JNS_OP', $jns_kd);
        }elseif($nop == '99.99.999.999.999.9999.9' && $tahun == '9999'){
            $this->datatables->where('O.KD_PROPINSI', $prop_kd);
            $this->datatables->where('O.KD_DATI2', $kab_kd);
            $this->datatables->where('O.KD_KECAMATAN', $kec_kd);
            $this->datatables->where('O.KD_KELURAHAN', $kel_kd);
            $this->datatables->where('O.KD_BLOK', $blok_kd);
            $this->datatables->where('O.NO_URUT', $urut_no);
            $this->datatables->where('O.KD_JNS_OP', $jns_kd);
            $this->datatables->where('O.THN_PAJAK_SPPT', $tahun);
        }elseif($nop != '99.99.999.999.999.9999.9' && $tahun != '9999') {
            $this->datatables->where('O.KD_PROPINSI', $prop_kd);
            $this->datatables->where('O.KD_DATI2', $kab_kd);
            $this->datatables->where('O.KD_KECAMATAN', $kec_kd);
            $this->datatables->where('O.KD_KELURAHAN', $kel_kd);
            $this->datatables->where('O.KD_BLOK', $blok_kd);
            $this->datatables->where('O.NO_URUT', $urut_no);
            $this->datatables->where('O.KD_JNS_OP', $jns_kd);
            $this->datatables->where('O.THN_PAJAK_SPPT', $tahun);
        }
        // if (!empty($nop) ) {
        //     $nop = trim($nop);
        //     $this->datatables->where("trim(KD_PROPINSI||KD_DATI2||KD_KECAMATAN||KD_KELURAHAN||KD_BLOK||NO_URUT||KD_JNS_OP) LIKE '%$nop%'");
        // }

        echo $this->datatables->generate();
  }

  // public function tes()
  // {
  //   $kode_kanwil = $this->input->post('kode_kanwil');
  //   $kode_kantor = $this->input->post('kode_kantor');

  //   var_dump($kode_kanwil);die;

  // }

  public function insert_sk()
  {
    $no_sk = $this->input->post('no_sk');
    $nop = $this->input->post('nop');
    $tahun = $this->input->post('tahun');
    //p

    $kd_propinsi = substr($nop, 0, 2);
    $kd_dati2 = substr($nop, 2, 2);
    $kd_kecamatan = substr($nop, 4, 3);
    $kd_kelurahan = substr($nop, 7, 3);
    $kd_blok = substr($nop, 10, 3);
    $no_urut = substr($nop, 13, 4);
    $kd_jns_op = substr($nop, 17, 1);

    $same_sk = $this->sk_njop_model->check_no_sk($no_sk);

    if($same_sk == true){
      $this->session->set_flashdata('msg_error', 'Data Gagal');
      echo json_encode(['code' => '500', 'msg' => 'NO SK sudah ada']);die;
    }

    $z = $this->sk_njop_model->check_id($kd_propinsi, $kd_dati2, $kd_kecamatan, $kd_kelurahan, $kd_blok, $no_urut, $kd_jns_op);

    $data_in = array(
      'KD_PROPINSI'  => $kd_propinsi,
      'KD_DATI2' => $kd_dati2,
      'KD_KECAMATAN' => $kd_kecamatan,
      'KD_KELURAHAN' => $kd_kelurahan,
      'KD_BLOK' => $kd_blok,
      'NO_URUT' => $no_urut,
      'KD_JNS_OP' => $kd_jns_op,
      'NO_SK' => $no_sk,
      'TAHUN' => $tahun,
      'ID_NOP' => $z
    );

    $insert_result = $this->db->insert('TEMP_SKNJOP_EADM', $data_in);

    //var_dump($insert_result);die;

    if($insert_result == true){
      $this->session->set_flashdata('msg_success', 'Data Berhasil');
      echo json_encode(['code' => '200', 'msg' => 'Berhasil']);
    }else{
      $this->session->set_flashdata('msg_error', 'Data Gagal');
      echo json_encode(['code' => '500', 'msg' => 'Gagal']);
    }

  }

  public function cetak_sk_njop(){
    $nop = $this->uri->segment(4);
    $tahun = $this->uri->segment(5);

    $kd_prop = substr($nop, 0, 2);
    $kd_dati2  = substr($nop, 2, 2);
    $kd_kec  = substr($nop, 4, 3);
    $kd_kel  = substr($nop, 7, 3);
    $kd_blok = substr($nop, 10, 3);
    $no_urut = substr($nop, 13, 4);
    $kd_jns_op  = substr($nop, 17, 1);

    $z = $this->sk_njop_model->check_queque($kd_prop, $kd_dati2, $kd_kec, $kd_kel, $kd_blok, $no_urut, $kd_jns_op);
    $qq = $z->QQ;
    //var_dump($z);die;
    // $z = strval($z);
    // var_dump($qq);die;

    $qs   = urldecode($_SERVER['QUERY_STRING']);
    parse_str($qs, $qs_data);
    $type = 'pdf';
    $rpt = 'sk_njop';
    
    $params = array(
            'kd_prop' => $kd_prop,
            'kd_dati2' => $kd_dati2,
            'kd_kec' => $kd_kec,
            'kd_kel' => $kd_kel,
            'kd_blok' => $kd_blok,
            'no_urut' => $no_urut,
            'kd_jns_op' => $kd_jns_op,
            'tahun' => $tahun,
            'id_nop' =>$qq,
            'logo_bogor' => FCPATH . 'assets/img/img_logo.png',
            'adi' => FCPATH . 'assets/img/qr_adi.png',
        );

    // var_dump($params);die;

    $jasper = $this->load->library('Jasper_ora');
    // var_dump($rpt,$params);die();
    // echo $jasper->cetak_ora($rpt, $params, $type, false);
    echo $jasper->cetak_ora($rpt, $params, 'pdf', false);
    // var_dump('ok');die;
  }
}
