<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class real_rpt extends CI_Controller {
  private $module = 'pbbmt';
    private $db_pbbm;

    function __construct() {
        parent::__construct();
        $this->db_pbbm = $this->load->database('default', TRUE);

        if (!$this->session->userdata('login')) {
            $this->session->set_flashdata('msg_warning', 'Session telah kadaluarsa, silahkan login ulang.');
            redirect('login');
            exit;
        }

    $this->load->model(array('apps_model', 'login_model', 'pbbm_model'));
    $this->pbbm_model->set_userarea();
    $this->load->model(array('kecModel','kelModel'));

  }

  function utang(){
    $buku    = (isset($_GET['buku'])) ? $_GET['buku'] : '11';
    $bukumin = $this->pbbm_model->rangebuku[substr($buku, 0, 1)][0];
    $bukumax = $this->pbbm_model->rangebuku[substr($buku, 1, 1)][1];
    $tahun = (isset($_GET['tahun'])) ? $_GET['tahun'] : date('Y');
    $tahun2 = (isset($_GET['tahun2'])) ? $_GET['tahun2'] : date('Y');

    $kec_kd = (isset($_GET['kec_kd']) ? $_GET['kec_kd'] : ($this->session->userdata('user_def_kec')? $this->session->userdata('user_def_kec') : '000'));
    $kel_kd = (isset($_GET['kel_kd']) ? $_GET['kel_kd'] : ($this->session->userdata('user_def_kel_'.$kec_kd)? $this->session->userdata('user_def_kel_'.$kec_kd) : '000'));

    if ($kec_kd=="000")
        $qry       = $this->db_pbbm->query($this->pbbm_model->qry_piutang_kec($tahun,$tahun2,$buku));
    elseif ($kel_kd=="000")
        $qry       = $this->db_pbbm->query($this->pbbm_model->qry_piutang_kel($tahun,$tahun2,$buku,$kec_kd));
    else
        $qry       = $this->db_pbbm->query($this->pbbm_model->qry_piutang_op($tahun,$tahun2,$buku,$kec_kd,$kel_kd));


    $data['detail'] = $qry->result();
    for ($i=1; $i<=5; $i++){
      for ($j=$i;$j<=5;$j++){
          $r="";
          for ($k=$i;$k<=$j;$k++) $r.="$k,";
          $r=substr($r,0,strlen($r)-1);
          if ($buku=="$i$j") $data['buku']= "$r";
        }
      }
    if ($kec_kd=='000') $kec_kd='999';
    $data['kec_nm'] = $this->kecModel->getrecord($kec_kd);
    if ($kel_kd=='000') $kel_kd='999';
    $data['kel_nm'] = $this->kelModel->getrecord($kec_kd,$kel_kd);

    $data['tahun'] = $tahun;
    $data['tahun2'] = $tahun2;

    $this->load->view('rpt_utang', $data);
  }

    // report
    function show_rpt() {
        $cls_mtd_html = $this->router->fetch_class()."/cetak/html/";
        $cls_mtd_pdf  = $this->router->fetch_class()."/cetak/pdf/";
        $data['rpt_html'] = active_module_url($cls_mtd_html. $_SERVER['QUERY_STRING']);;
        $data['rpt_pdf']  = active_module_url($cls_mtd_pdf . $_SERVER['QUERY_STRING']);;
        $this->load->view('vjasper_viewer', $data);
    }

    function cetak() {
        $kec_kd=NULL;
        $kel_kd=NULL;
        $tahun=NULL;
        $tahun2=NULL;
        $bukumin=NULL;
        $bukumax=NULL;
        $buku=NULL;
        $tglawal=NULL;
        $tglakhir=NULL;

        $type = $this->uri->segment(4);
        $jenis = $this->uri->segment(5);

        $kec_kd = $this->uri->segment(6);
        $kel_kd = $this->uri->segment(7);

        if ($jenis == 1) {
            $tahun = $this->uri->segment(8);
            $buku = $this->uri->segment(9);
            $bukumin = $this->pbbm_model->rangebuku[substr($buku, 0, 1)][0];
            $bukumax = $this->pbbm_model->rangebuku[substr($buku, 1, 1)][1];
            $tglawal = $this->uri->segment(10);
            $tglakhir = $this->uri->segment(11);
           }
        elseif ($jenis == 2) {
           $tahun = $this->uri->segment(8);
           }
        elseif ($jenis == 3) {
           $tahun = $this->uri->segment(8);
           }
        elseif ($jenis == 4) {
           $tahun = $this->uri->segment(8);
           $tahun2 = $this->uri->segment(9);
           $buku = $this->uri->segment(10);
           $bukumin = $this->pbbm_model->rangebuku[substr($buku, 0, 1)][0];
           $bukumax = $this->pbbm_model->rangebuku[substr($buku, 1, 1)][1];
           }

        if ($kec_kd == '000' && $kel_kd == '000') {
           if ( $jenis==1 ) {$rptx = 'real_nb_kec';}
           elseif ( $jenis==2 ) {$rptx = 'real_lb_kec';}
           elseif ( $jenis==3 ) {$rptx = 'real_kb_kec';}
           elseif ( $jenis==4 ) {$rptx = 'utang_kec';}
           }
        if ($kec_kd != '000' && $kel_kd == '000') {
           if ( $jenis==1 ) {$rptx = 'real_nb_kel';}
           elseif ( $jenis==2 ) {$rptx = 'real_lb_kel';}
           elseif ( $jenis==3 ) {$rptx = 'real_kb_kel';}
           elseif ( $jenis==4 ) {$rptx = 'utang_kel';}
           }

        if ($kec_kd != '000' && $kel_kd != '000')  {
           if ( $jenis==1 ) {$rptx = 'real_nb_op';}
           elseif ( $jenis==2 ) {$rptx = 'real_lb_op';}
           elseif ( $jenis==3 ) {$rptx = 'real_kb_op';}
           elseif ( $jenis==4 ) {$rptx = 'utang_op';}
           }

        // report
        // $db_pad = $this->load->database('pad', TRUE);
        // $jasper = $this->load->library('Jasper');
        // $jasper->db   = $db_pad->database;
        // $jasper->usr  = $db_pad->username;
        // $jasper->pwd  = $db_pad->password;
        // $jasper->port = $db_pad->port;

        $jasper = $this->load->library('Jasper_ora');

        $params = array(
            "daerah" => LICENSE_TO,
            "kd_propinsi" => KD_PROPINSI,
            "kd_dati2" => KD_DATI2,
            "kd_kecamatan" => $kec_kd,
            "kd_kelurahan" => $kel_kd,
            "tahun" => $tahun,
            "tahun2" => $tahun2,
            "bukumin" => $bukumin."",
            "bukumax" => $bukumax."",
            "buku" => $buku,
            "tglawal" => date('Y-m-d', strtotime($tglawal)),
            "tglakhir" => date('Y-m-d', strtotime($tglakhir)),
            "logo" => base_url("assets/img/logorpt__.jpg"),
            "dinas" => LICENSE_TO_SUB
        );
        // echo $jasper->cetak($rptx, $params, $type, false);
        echo $jasper->cetak_ora($rptx, $params, $type, false);
    }
}