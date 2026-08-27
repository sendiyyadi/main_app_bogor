<?php
defined('BASEPATH') or exit('No direct script access allowed');

class rekam_bayar_sppt extends CI_Controller
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

  private $controller = 'rekam_bayar_sppt';
  public function __construct()
  {
    parent::__construct();
    if (!is_login()) {
      echo "<script>window.location.replace('" . base_url() . "');</script>";
      exit;
    }

    $module = 'rekam_bayar_sppt';
    $this->load->library('module_auth', array(
      'module' => $module
    ));

    $this->load->model(array(
      'apps_model'
    ));

    $this->load->helper(active_module());
    $this->load->model('rekam_bayar_sppt_model');
  }


  public function index()
  {
    $data['page_menu']  = 'rekam_bayar_sppt';
    $data['current']    = '';
    $data['controller'] = $this->controller;
    $data['apps']       = $this->apps_model->get_active_only();

    $this->load->view('vrekam_bayar_sppt', $data);
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
            KD_PROPINSI || KD_DATI2 || KD_KECAMATAN || KD_KELURAHAN || KD_BLOK || NO_URUT || KD_JNS_OP AS NOP,
            thn_pajak_sppt AS TAHUN,
            nm_wp_sppt AS NAMA_WP,
            jln_wp_sppt || ', ' || blok_kav_no_wp_sppt AS alamat_wp,
            NVL(TO_CHAR(tgl_jatuh_tempo_sppt,'DD-MM-YYYY'),'') AS jatuh_tempo,
            pbb_terhutang_sppt AS terhutang,
            faktor_pengurang_sppt AS pengurang,
            pbb_yg_harus_dibayar_sppt AS tagihan,
            status_pembayaran_sppt AS status,
            rt_wp_sppt,
            rw_wp_sppt,
            kelurahan_wp_sppt,
            kota_wp_sppt,
            npwp_sppt", false);
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

  private function fvalidation() 
  {
    $this->form_validation->set_error_delimiters('<span>', '</span>');
    $this->form_validation->set_rules('kode_tp', 'KODE TP', 'required');
    $this->form_validation->set_rules('denda_sppt', 'Denda SPPT', 'required|numeric');
    $this->form_validation->set_rules('sppt_bayar', 'Jumlah SPPT yang dibayar', 'required|numeric');
    $this->form_validation->set_rules('pembayaran', 'pembayaran SPPT ke', 'required|numeric');
    $this->form_validation->set_rules('tanggal_bayar_sppt', 'Tanggal Bayar SPPT', 'required');
    $this->form_validation->set_rules('tanggal_rekam_bayar', 'Tanggal Rekam Bayar', 'required');
    $this->form_validation->set_rules('nip_bayar_sppt', 'NIP Bayar SPPT', 'required');
  }

  public function detail()
  {
    $nop = $this->uri->segment(4);
    $tahun = $this->uri->segment(5);
    $nama = urldecode($this->uri->segment(6) ?: $this->input->post('nama'));
    $nama = str_replace('-', '/', $nama);
    $alamat = urldecode($this->uri->segment(7) ?: $this->input->post('alamat'));
    $alamat = str_replace('-', '/', $alamat);
    $rt = $this->uri->segment(8);
    $rw = $this->uri->segment(9);
    $kelurahan = $this->uri->segment(10);
    $kota = $this->uri->segment(11);
    $npwp = $this->uri->segment(12);

    // var_dump($alamat);die;

    $data['nop'] = $nop;
    $data['tahun'] = $tahun;
    $data['nama'] = $nama;
    $data['alamat'] = $alamat;
    $data['rt'] = $rt;
    $data['rw'] = $rw;
    $data['kelurahan'] = $kelurahan;
    $data['kota'] = $kota;
    $data['npwp'] = $npwp;

    $jumlah = $this->rekam_bayar_sppt_model->jumlah_pembayaran($nop, $tahun);
    $jumlah = $jumlah->JUMLAH_BARIS;
    $jumlah = (int) $jumlah;
    $jumlah = $jumlah+1;

    // var_dump($jumlah);die;

    $data['pembayaran'] = $jumlah;

    $data['page_menu']  = 'rekam_bayar_sppt_detail';
    $data['current']    = '';
    $data['controller'] = $this->controller;
    $data['apps']       = $this->apps_model->get_active_only();

    $this->fvalidation();

    if ($this->form_validation->run() == TRUE) {

      $nop = $this->input->post('nop');
      $tahun = $this->input->post('tahun');
      $kode_kanwil = $this->input->post('kode_kanwil');
      $kode_kantor = $this->input->post('kode_kantor');
      $kode_tp = $this->input->post('kode_tp');
      $denda_sppt = $this->input->post('denda_sppt');
      $sppt_bayar = $this->input->post('sppt_bayar');
      $pembayaran = $this->input->post('pembayaran');
      $tanggal_bayar_sppt = $this->input->post('tanggal_bayar_sppt');
      $tanggal_rekam_bayar = $this->input->post('tanggal_rekam_bayar');
      $nip_bayar_sppt = $this->input->post('nip_bayar_sppt');

      $tanggal_bayar_sppt = date('Y-m-d', strtotime($this->input->post('tanggal_bayar_sppt')));
      $tanggal_rekam_bayar = date('Y-m-d', strtotime($this->input->post('tanggal_rekam_bayar')));

      $kd_propinsi = substr($nop, 0, 2);
      $kd_dati2 = substr($nop, 2, 2);
      $kd_kecamatan = substr($nop, 4, 3);
      $kd_kelurahan = substr($nop, 7, 3);
      $kd_blok = substr($nop, 10, 3);
      $no_urut = substr($nop, 13, 4);
      $kd_jns_op = substr($nop, 17, 1);

      $pembayaran = (int) $pembayaran;
      $denda_sppt = (int) $denda_sppt;
      $sppt_bayar = (int) $sppt_bayar;

      $data_in = array(
        'KD_PROPINSI'  => $kd_propinsi,
        'KD_DATI2' => $kd_dati2,
        'KD_KECAMATAN' => $kd_kecamatan,
        'KD_KELURAHAN' => $kd_kelurahan,
        'KD_BLOK' => $kd_blok,
        'NO_URUT' => $no_urut,
        'KD_JNS_OP' => $kd_jns_op,
        'THN_PAJAK_SPPT' => $tahun,
        'PEMBAYARAN_SPPT_KE' => $pembayaran,
        'KD_KANWIL' => $kode_kanwil,
        'KD_KANTOR' => $kode_kantor,
        'KD_TP' => $kode_tp,
        'DENDA_SPPT' => $denda_sppt,
        'JML_SPPT_YG_DIBAYAR' => $sppt_bayar,
        'TGL_PEMBAYARAN_SPPT' => $tanggal_bayar_sppt,
        'TGL_REKAM_BYR_SPPT' => $tanggal_rekam_bayar,
        'NIP_REKAM_BYR_SPPT' => $nip_bayar_sppt,
        'NIP_REKAM_BYR_OLD' => null
      );

      $insert_result = $this->db->insert('PEMBAYARAN_SPPT', $data_in);

      // var_dump($insert_result);die;

      if($insert_result == true){
        $this->session->set_flashdata('msg_success', 'Berhasil');
        redirect(active_module_url('rekam_bayar_sppt'));

      }else{
        $this->session->set_flashdata('msg_error', 'Gagal');
        redirect(active_module_url('rekam_bayar_sppt'));
      }

      // $update = $this->load->model('edit_bayar_sppt_model')->update_bayar($kd_propinsi, $kd_dati2, $kd_kecamatan, $kd_kelurahan, $kd_blok, $no_urut, $kd_jns_op, $tahun, $denda_sppt, $sppt_bayar, $pembayaran);

      // if($update > 0){
      //   $this->session->set_flashdata('msg_success', 'Data telah diubah');
      //   redirect(active_module_url('edit_bayar_sppt'));
      // }elseif ($update === 0) {
      //   $this->session->set_flashdata('msg_warning', 'Tidak ada perubahan data');
      //   redirect(active_module_url('edit_bayar_sppt'));
      // } else {
      //   $this->session->set_flashdata('msg_error', 'Data gagal diubah');
      //   redirect(active_module_url('edit_bayar_sppt'));
      // }
    }

    

    $this->load->view('vrekam_bayar_sppt_detail', $data);
  }

  // public function tes()
  // {
  //   $kode_kanwil = $this->input->post('kode_kanwil');
  //   $kode_kantor = $this->input->post('kode_kantor');

  //   var_dump($kode_kanwil);die;

  // }

  public function insert_sppt()
  {
    $nop = $this->input->post('nop');
    $tahun = $this->input->post('tahun');
    // $nama = $this->input->post('nama');
    // $alamat = $this->input->post('alamat');
    // $rt = $this->input->post('rt');
    // $rw = $this->input->post('rw');
    // $kelurahan = $this->input->post('kelurahan');
    // $kota = $this->input->post('kota');
    // $npwp = $this->input->post('npwp');
    $kode_kanwil = $this->input->post('kode_kanwil');
    $kode_kantor = $this->input->post('kode_kantor');
    $kode_tp = $this->input->post('kode_tp');
    $denda_sppt = $this->input->post('denda_sppt');
    $sppt_bayar = $this->input->post('sppt_bayar');
    $pembayaran = $this->input->post('pembayaran');
    $tanggal_bayar_sppt = $this->input->post('tanggal_bayar_sppt');
    $tanggal_rekam_bayar = $this->input->post('tanggal_rekam_bayar');
    $nip_bayar_sppt = $this->input->post('nip_bayar_sppt');

    $tanggal_bayar_sppt = date('Y-m-d', strtotime($this->input->post('tanggal_bayar_sppt')));
    $tanggal_rekam_bayar = date('Y-m-d', strtotime($this->input->post('tanggal_rekam_bayar')));
    //p

    $kd_propinsi = substr($nop, 0, 2);
    $kd_dati2 = substr($nop, 2, 2);
    $kd_kecamatan = substr($nop, 4, 3);
    $kd_kelurahan = substr($nop, 7, 3);
    $kd_blok = substr($nop, 10, 3);
    $no_urut = substr($nop, 13, 4);
    $kd_jns_op = substr($nop, 17, 1);

    // var_dump($kode_kanwil);die;

    $pembayaran = (int) $pembayaran;
    $denda_sppt = (int) $denda_sppt;
    $sppt_bayar = (int) $sppt_bayar;

    $data_in = array(
      'KD_PROPINSI'  => $kd_propinsi,
      'KD_DATI2' => $kd_dati2,
      'KD_KECAMATAN' => $kd_kecamatan,
      'KD_KELURAHAN' => $kd_kelurahan,
      'KD_BLOK' => $kd_blok,
      'NO_URUT' => $no_urut,
      'KD_JNS_OP' => $kd_jns_op,
      'THN_PAJAK_SPPT' => $tahun,
      'PEMBAYARAN_SPPT_KE' => $pembayaran,
      'KD_KANWIL' => $kode_kanwil,
      'KD_KANTOR' => $kode_kantor,
      'KD_TP' => $kode_tp,
      'DENDA_SPPT' => $denda_sppt,
      'JML_SPPT_YG_DIBAYAR' => $sppt_bayar,
      'TGL_PEMBAYARAN_SPPT' => $tanggal_bayar_sppt,
      'TGL_REKAM_BYR_SPPT' => $tanggal_rekam_bayar,
      'NIP_REKAM_BYR_SPPT' => $nip_bayar_sppt,
      'NIP_REKAM_BYR_OLD' => null
    );

    $insert_result = $this->db->insert('PEMBAYARAN_SPPT', $data_in);

    // if ($insert_result == true) {
    //   $this->session->set_flashdata('msg_success', 'Berhasil');
    // } else {
    //   $this->session->set_flashdata('msg_warning', 'Gagal');
    // }

    // redirect(active_module_url('rekam_bayar_sppt'));

    // Mulai transaksi
    // $this->db->trans_begin();

    // $this->db->insert('PEMBAYARAN_SPPT', $data_in);

    // // Periksa status transaksi
    // if ($this->db->trans_status() === FALSE) {
    //     // Jika ada kesalahan, rollback transaksi
    //     $this->db->trans_rollback();
    //     $error = $this->db->error();
    //     $this->session->set_flashdata('msg_warning', 'Gagal: ' . $error['message']);
    // } else {
    //     // Jika berhasil, commit transaksi
    //     $this->db->trans_commit();
    //     $this->session->set_flashdata('msg_success', 'Berhasil');
    // }

    // // Redirect selalu dilakukan di luar blok if-else agar selalu dieksekusi
    // redirect(active_module_url('rekam_bayar_sppt'));



    if($insert_result == true){
      $this->session->set_flashdata('msg_success', 'Berhasil');
      // redirect(base_url('tool_pbb/rekam_bayar_sppt'));
    }else{
      $this->session->set_flashdata('msg_success', 'Gagal');
      // redirect(base_url('tool_pbb/rekam_bayar_sppt'));
    }

    // $columns = implode(", ", array_keys($data_in));
    // $values = implode(", ", array_map(array($this->db, 'escape'), array_values($data_in)));

    // $sql = "INSERT INTO PEMBAYARAN_SPPT ($columns) VALUES ($values)";
    // $this->db->error();
    // $this->db->query($sql);

    // $this->db->insert('PEMBAYARAN_SPPT',$data_in);
    // var_dump($this->db->last_query()); die();

    // redirect(base_url('tool_pbb/rekam_bayar_sppt/'));

    // $this->load->library('Datatables');
    // $this->datatables->select("
    //           SP.KD_PROPINSI || SP.KD_DATI2 || SP.KD_KECAMATAN || SP.KD_KELURAHAN || SP.KD_BLOK || SP.NO_URUT || SP.KD_JNS_OP AS NOP,
    //           SP.thn_pajak_sppt AS TAHUN,
    //           SP.nm_wp_sppt AS NAMA_WP,
    //           SP.jln_wp_sppt || ', ' || SP.blok_kav_no_wp_sppt || ', RW ' || SP.rw_wp_sppt || ', RT ' || SP.rt_wp_sppt || ', ' || SP.kelurahan_wp_sppt || ', ' || SP.kota_wp_sppt AS alamat_wp,
    //           SP.rt_wp_sppt AS RT,
    //           SP.rw_wp_sppt AS RW,
    //           SP.kelurahan_wp_sppt AS kelurahan,
    //           SP.kota_wp_sppt AS kota,
    //           SP.npwp_sppt AS npwp,
    //           PS.kd_kanwil AS kode_kanwil,
    //           PS.kd_kantor AS kode_kantor,
    //           PS.kd_tp AS kode_tp,
    //           PS.denda_sppt AS denda_sppt,
    //           PS.jml_sppt_yg_dibayar AS sppt_yg_dibayar,
    //           PS.tgl_pembayaran_sppt AS tanggal_bayar_sppt,
    //           PS.tgl_rekam_byr_sppt AS tanggal_rekam_bayar,
    //           PS.nip_rekam_byr_sppt", false);
    // $this->datatables->from('SPPT SP');
    // $this->datatables->join('PEMBAYARAN_SPPT PS', 'SP.KD_PROPINSI || SP.KD_DATI2 || SP.KD_KECAMATAN || SP.KD_KELURAHAN || SP.KD_BLOK || SP.NO_URUT || SP.KD_JNS_OP = PS.KD_PROPINSI || PS.KD_DATI2 || PS.KD_KECAMATAN || PS.KD_KELURAHAN || PS.KD_BLOK || PS.NO_URUT || PS.KD_JNS_OP AND SP.THN_PAJAK_SPPT = PS.THN_PAJAK_SPPT', 'inner', false);

    // $this->datatables->where("trim(trim(KD_PROPINSI||KD_DATI2||KD_KECAMATAN||KD_KELURAHAN||KD_BLOK||NO_URUT||KD_JNS_OP) LIKE '%" .$this->db->escape_like_str($nop). "%'");
    // $this->datatables->where("trim(THN_PAJAK_SPPT) LIKE '%" .$this->db->escape_like_str($tahun). "%'");
    // echo $this->datatables->generate();
  }
}
