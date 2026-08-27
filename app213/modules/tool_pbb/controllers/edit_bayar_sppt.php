<?php
defined('BASEPATH') or exit('No direct script access allowed');

class edit_bayar_sppt extends CI_Controller
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

  private $controller = 'edit_bayar_sppt';
  public function __construct()
  {
    parent::__construct();
    if (!is_login()) {
      echo "<script>window.location.replace('" . base_url() . "');</script>";
      exit;
    }

    $module = 'edit_bayar_sppt';
    $this->load->library('module_auth', array(
      'module' => $module
    ));

    $this->load->model(array(
      'apps_model'
    ));

    $this->load->helper(active_module());
    $this->load->model('edit_bayar_sppt_model');
  }


  public function index()
  {
    $data['page_menu']  = 'edit_bayar_sppt';
    $data['current']    = '';
    $data['controller'] = $this->controller;
    $data['apps']       = $this->apps_model->get_active_only();

    $this->load->view('vedit_bayar_sppt', $data);
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
        // var_dump($tahun);die;

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
            S.KD_PROPINSI || S.KD_DATI2 || S.KD_KECAMATAN || S.KD_KELURAHAN || S.KD_BLOK || S.NO_URUT || S.KD_JNS_OP AS NOP,
            S.thn_pajak_sppt AS TAHUN,
            S.nm_wp_sppt AS NAMA_WP,
            S.jln_wp_sppt || ', ' || S.blok_kav_no_wp_sppt AS alamat_wp,
            NVL(TO_CHAR(S.tgl_jatuh_tempo_sppt,'DD-MM-YYYY'),'') AS jatuh_tempo,
            S.pbb_terhutang_sppt AS terhutang,
            S.faktor_pengurang_sppt AS pengurang,
            S.pbb_yg_harus_dibayar_sppt AS tagihan,
            S.status_pembayaran_sppt AS status,
            S.rt_wp_sppt,
            S.rw_wp_sppt,
            S.kelurahan_wp_sppt,
            S.kota_wp_sppt,
            S.npwp_sppt,
            P.pembayaran_sppt_ke", false);
        $this->datatables->from('SPPT S');
        $this->datatables->join('PEMBAYARAN_SPPT P','S.KD_PROPINSI = P.KD_PROPINSI AND S.KD_DATI2 = P.KD_DATI2 AND S.KD_KECAMATAN = P.KD_KECAMATAN AND S.KD_KELURAHAN = P.KD_KELURAHAN AND S.KD_BLOK = P.KD_BLOK AND S.NO_URUT = P.NO_URUT AND S.KD_JNS_OP = P.KD_JNS_OP AND S.THN_PAJAK_SPPT = P.THN_PAJAK_SPPT','inner');
        if($nop != '99.99.999.999.999.9999.9' && $tahun == '9999') {
            $this->datatables->where('S.KD_PROPINSI', $prop_kd);
            $this->datatables->where('S.KD_DATI2', $kab_kd);
            $this->datatables->where('S.KD_KECAMATAN', $kec_kd);
            $this->datatables->where('S.KD_KELURAHAN', $kel_kd);
            $this->datatables->where('S.KD_BLOK', $blok_kd);
            $this->datatables->where('S.NO_URUT', $urut_no);
            $this->datatables->where('S.KD_JNS_OP', $jns_kd);
        }elseif($nop == '99.99.999.999.999.9999.9' && $tahun == '9999'){
            $this->datatables->where('S.KD_PROPINSI', $prop_kd);
            $this->datatables->where('S.KD_DATI2', $kab_kd);
            $this->datatables->where('S.KD_KECAMATAN', $kec_kd);
            $this->datatables->where('S.KD_KELURAHAN', $kel_kd);
            $this->datatables->where('S.KD_BLOK', $blok_kd);
            $this->datatables->where('S.NO_URUT', $urut_no);
            $this->datatables->where('S.KD_JNS_OP', $jns_kd);
            $this->datatables->where('S.THN_PAJAK_SPPT', $tahun);
        }elseif($nop != '99.99.999.999.999.9999.9' && $tahun != '9999') {
            $this->datatables->where('S.KD_PROPINSI', $prop_kd);
            $this->datatables->where('S.KD_DATI2', $kab_kd);
            $this->datatables->where('S.KD_KECAMATAN', $kec_kd);
            $this->datatables->where('S.KD_KELURAHAN', $kel_kd);
            $this->datatables->where('S.KD_BLOK', $blok_kd);
            $this->datatables->where('S.NO_URUT', $urut_no);
            $this->datatables->where('S.KD_JNS_OP', $jns_kd);
            $this->datatables->where('S.THN_PAJAK_SPPT', $tahun);
        }

        echo $this->datatables->generate();
  }

  private function fvalidation() 
  {
    $this->form_validation->set_error_delimiters('<span>', '</span>');
    $this->form_validation->set_rules('denda_sppt', 'Denda SPPT', 'required|numeric');
    $this->form_validation->set_rules('sppt_bayar', 'SPPT yang dibayar', 'required|numeric');
  }

  public function detail()
  {
    // $nama = urldecode($this->uri->segment(6)); // Ambil nama yang telah terencode
    // $nama = str_replace('-', '/', $nama);
    // var_dump($nama);die;

    // $q = $this->uri->segment(13);
    // var_dump($q);die;

    // $p = urldecode($this->uri->segment(6));

    $nop = $this->uri->segment(4) ?: $this->input->post('nop');
    $tahun = $this->uri->segment(5) ?: $this->input->post('tahun');
    $nama = urldecode($this->uri->segment(6) ?: $this->input->post('nama'));
    $nama = str_replace('-', '/', $nama);
    $alamat = urldecode($this->uri->segment(7) ?: $this->input->post('alamat'));
    $alamat = str_replace('-', '/', $alamat);
    $rt = $this->uri->segment(8) ?: $this->input->post('rt');
    $rw = $this->uri->segment(9) ?: $this->input->post('rw');
    $kelurahan = $this->uri->segment(10) ?: $this->input->post('kelurahan');
    $kota = $this->uri->segment(11) ?: $this->input->post('kota');
    $npwp = $this->uri->segment(12) ?: $this->input->post('npwp');
    $pembayaran = $this->uri->segment(13) ?: $this->input->post('pembayaran');

    // var_dump($pembayaran);die;

    $kd_propinsi = substr($nop, 0, 2);
    $kd_dati2 = substr($nop, 2, 2);
    $kd_kecamatan = substr($nop, 4, 3);
    $kd_kelurahan = substr($nop, 7, 3);
    $kd_blok = substr($nop, 10, 3);
    $no_urut = substr($nop, 13, 4);
    $kd_jns_op = substr($nop, 17, 1);
    $pembayaran = (int) $pembayaran;

    // var_dump($pembayaran);die;

    // var_dump($alamat);die;

    $this->fvalidation();

    if ($this->form_validation->run() == TRUE) {

      // $pembayaran = $this->input->post('pembayaran');

      // var_dump($pembayaran);die;

      $denda_sppt = $this->input->post('denda_sppt');
      $sppt_bayar = $this->input->post('sppt_bayar');

      // var_dump();die;

      $update = $this->load->model('edit_bayar_sppt_model')->update_bayar($kd_propinsi, $kd_dati2, $kd_kecamatan, $kd_kelurahan, $kd_blok, $no_urut, $kd_jns_op, $tahun, $denda_sppt, $sppt_bayar, $pembayaran);

      // var_dump($update);die;

      if($update > 0){
        $this->session->set_flashdata('msg_success', 'Data telah diubah');
        redirect(active_module_url('edit_bayar_sppt'));
      }elseif ($update === 0) {
        $this->session->set_flashdata('msg_warning', 'Tidak ada perubahan data');
        redirect(active_module_url('edit_bayar_sppt'));
      } else {
        $this->session->set_flashdata('msg_error', 'Data gagal diubah');
        redirect(active_module_url('edit_bayar_sppt'));
      }
    }

    //real view detail

    // var_dump($alamat);die;

    //send data to input value
    $data['nop'] = $nop;
    $data['tahun'] = $tahun;
    $data['nama'] = $nama;
    $data['alamat'] = $alamat;
    $data['rt'] = $rt;
    $data['rw'] = $rw;
    $data['kelurahan'] = $kelurahan;
    $data['kota'] = $kota;
    $data['npwp'] = $npwp;
    $data['pembayaran'] = $pembayaran;

    //for missing data
    $bayar_detail = $this->load->model('edit_bayar_sppt_model')->get_bayar_detail($kd_propinsi, $kd_dati2, $kd_kecamatan, $kd_kelurahan, $kd_blok, $no_urut, $kd_jns_op, $tahun, $pembayaran);

    if($bayar_detail){
        $kd_kanwil = $bayar_detail->KD_KANWIL;
        $kd_kantor = $bayar_detail->KD_KANTOR;
        $kode_tp = $bayar_detail->KD_TP;
        $denda_sppt = $bayar_detail->DENDA_SPPT;
        $sppt_bayar = $bayar_detail->JML_SPPT_YG_DIBAYAR;
        // $pembayaran = $bayar_detail->PEMBAYARAN_SPPT_KE;
        $tanggal_bayar_sppt = date('Y-m-d', strtotime($bayar_detail->TGL_PEMBAYARAN_SPPT));
        $tanggal_rekam_bayar = date('Y-m-d', strtotime($bayar_detail->TGL_REKAM_BYR_SPPT));
        $nip_bayar_sppt = $bayar_detail->NIP_REKAM_BYR_SPPT;
    }

    //data yang kurang diambil dari tabel pembayaran berdasarkan nop dan tahun
    $data['kd_kanwil'] = $kd_kanwil;
    $data['kd_kantor'] = $kd_kantor;
    $data['kode_tp'] = $kode_tp;
    $data['denda_sppt'] = $denda_sppt;
    $data['sppt_bayar'] = $sppt_bayar;
    // $data['pembayaran'] = $pembayaran;
    $data['tanggal_bayar_sppt'] = $tanggal_bayar_sppt;
    $data['tanggal_rekam_bayar'] = $tanggal_rekam_bayar;
    $data['nip_bayar_sppt'] = $nip_bayar_sppt ;

    $data['page_menu']  = 'edit_bayar_sppt_detail';
    $data['current']    = '';
    $data['controller'] = $this->controller;
    $data['apps']       = $this->apps_model->get_active_only();

    $this->load->view('vedit_bayar_sppt_detail', $data);
  }

  // public function update_bayar_sppt()
  // {
  //   $nop = $this->input->post('nop');
  //   $tahun = $this->input->post('tahun');
  //   $nama = $this->input->post('nama');
  //   $alamat = $this->input->post('alamat');
  //   $rt = $this->input->post('rt');
  //   $rw =$this->input->post('rw');
  //   $kelurahan =$this->input->post('kelurahan');
  //   $kota =$this->input->post('kota');
  //   $npwp =$this->input->post('npwp');

  //   $denda_sppt = $this->input->post('denda_sppt');
  //   $sppt_bayar = $this->input->post('sppt_bayar');

  //   $kd_propinsi = substr($nop, 0, 2);
  //   $kd_dati2 = substr($nop, 2, 2);
  //   $kd_kecamatan = substr($nop, 4, 3);
  //   $kd_kelurahan = substr($nop, 7, 3);
  //   $kd_blok = substr($nop, 10, 3);
  //   $no_urut = substr($nop, 13, 4);
  //   $kd_jns_op = substr($nop, 17, 1);

  //   $denda_sppt = (int) $denda_sppt;
  //   $sppt_bayar = (int) $sppt_bayar;

  //   $data_in = array(
  //     'DENDA_SPPT' => $denda_sppt,
  //     'JML_SPPT_YG_DIBAYAR' => $sppt_bayar,
  //   );

  //   $this->fvalidation();

  //   // var_dump($this->form_validation->run());die;

  //   if ($this->form_validation->run() == TRUE) {

  //     $update = $this->load->model('edit_bayar_sppt_model')->update_bayar($kd_propinsi, $kd_dati2, $kd_kecamatan, $kd_kelurahan, $kd_blok, $no_urut, $kd_jns_op, $tahun, $denda_sppt, $sppt_bayar);

  //     // if($update === TRUE || $update === 1){
  //     //   $this->session->set_flashdata('msg_success', 'Berhasil');
  //     //   // redirect(base_url('tool_pbb/edit_bayar_sppt'));
  //     // }else{
  //     //   $this->session->set_flashdata('msg_error', 'Gagal');
  //     //   // redirect(base_url('tool_pbb/edit_bayar_sppt'));
  //     // }

  //     if($update > 0){
  //       $this->session->set_flashdata('msg_success', 'Data telah diubah');
  //     }elseif ($update === 0) {
  //       $this->session->set_flashdata('msg_warning', 'Tidak ada perubahan data');
  //     } else {
  //       $this->session->set_flashdata('msg_error', 'Data gagal diubah');
  //     }
  //   }

  // }
}
