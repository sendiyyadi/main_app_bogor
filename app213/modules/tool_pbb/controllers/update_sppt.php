<?php
defined('BASEPATH') or exit('No direct script access allowed');

class update_sppt extends CI_Controller
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

  private $controller = 'update_sppt';
  public function __construct()
  {
    parent::__construct();
    if (!is_login()) {
      echo "<script>window.location.replace('" . base_url() . "');</script>";
      exit;
    }

    $module = 'update_sppt';
    $this->load->library('module_auth', array(
      'module' => $module
    ));

    $this->load->model(array(
      'apps_model'
    ));

    $this->load->helper(active_module());
    $this->load->model('update_sppt_model');
  }

  private function fvalidation() 
  {
    $this->form_validation->set_error_delimiters('<span>', '</span>');
    $this->form_validation->set_rules('status', 'Status Pembayaran SPPT', 'required|numeric');
  }

  public function index()
  {
    $data['page_menu']  = 'update_sppt';
    $data['current']    = '';
    $data['controller'] = $this->controller;
    $data['apps']       = $this->apps_model->get_active_only();

    $this->fvalidation();

    if ($this->form_validation->run() == TRUE) {
        $nop = $this->input->post('nop');
        $tahun = $this->input->post('tahun');
        $status = $this->input->post('status');

        $kd_propinsi = substr($nop, 0, 2);
        $kd_dati2 = substr($nop, 2, 2);
        $kd_kecamatan = substr($nop, 4, 3);
        $kd_kelurahan = substr($nop, 7, 3);
        $kd_blok = substr($nop, 10, 3);
        $no_urut = substr($nop, 13, 4);
        $kd_jns_op = substr($nop, 17, 1);

        // var_dump($nop);die;

        $update = $this->load->model('update_sppt_model')->apdet_sppt($kd_propinsi, $kd_dati2, $kd_kecamatan, $kd_kelurahan, $kd_blok, $no_urut, $kd_jns_op, $tahun, $status);

        // var_dump($update);die;

        if($update > 0){
            $this->session->set_flashdata('msg_success', 'Data telah diubah');
            redirect(active_module_url('update_sppt'));
          }elseif ($update === 0) {
            $this->session->set_flashdata('msg_warning', 'Tidak ada perubahan data');
            redirect(active_module_url('update_sppt'));
          } else {
            $this->session->set_flashdata('msg_error', 'Data gagal diubah');
            redirect(active_module_url('update_sppt'));
          }
    }

    $this->load->view('vupdate_sppt', $data);
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
            S.KD_PROPINSI || S.KD_DATI2 || S.KD_KECAMATAN || S.KD_KELURAHAN || S.KD_BLOK || S.NO_URUT || S.KD_JNS_OP AS NOP,
            S.thn_pajak_sppt AS TAHUN,
            S.nm_wp_sppt AS NAMA_WP,
            S.jln_wp_sppt || ', ' || S.blok_kav_no_wp_sppt || ', RW ' || S.rw_wp_sppt || ', RT ' || S.rt_wp_sppt || ', ' || S.kelurahan_wp_sppt || ', ' || S.kota_wp_sppt AS alamat_wp,
            NVL(TO_CHAR(S.tgl_jatuh_tempo_sppt,'DD-MM-YYYY'),'') AS jatuh_tempo,
            S.pbb_terhutang_sppt AS terhutang,
            S.faktor_pengurang_sppt AS pengurang,
            S.pbb_yg_harus_dibayar_sppt AS tagihan,
            S.status_pembayaran_sppt AS status,
            P.pembayaran_sppt_ke", false);
        $this->datatables->from('SPPT S');
        $this->datatables->join('PEMBAYARAN_SPPT P','S.KD_PROPINSI = P.KD_PROPINSI AND S.KD_DATI2 = P.KD_DATI2 AND S.KD_KECAMATAN = P.KD_KECAMATAN AND S.KD_KELURAHAN = P.KD_KELURAHAN AND S.KD_BLOK = P.KD_BLOK AND S.NO_URUT = P.NO_URUT AND S.KD_JNS_OP = P.KD_JNS_OP AND S.THN_PAJAK_SPPT = P.THN_PAJAK_SPPT','left');
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


  public function status_sppt()
  {
    $nop = $this->input->post('nop');
    $tahun = $this->input->post('tahun');
    $status = $this->input->post('status');

    $data['page_menu']  = 'update_sppt';
    $data['current']    = '';
    $data['controller'] = $this->controller;
    $data['apps']       = $this->apps_model->get_active_only();

    $this->load->view('vstatus_sppt', $data);
  }

  public function update_status()
  {
    $nop = $this->input->post('nop');
    $tahun = $this->input->post('tahun');
    $status = $this->input->post('status');

    $kd_propinsi = substr($nop, 0, 2);
    $kd_dati2 = substr($nop, 2, 2);
    $kd_kecamatan = substr($nop, 4, 3);
    $kd_kelurahan = substr($nop, 7, 3);
    $kd_blok = substr($nop, 10, 3);
    $no_urut = substr($nop, 13, 4);
    $kd_jns_op = substr($nop, 17, 1);

    $update = $this->load->model('update_sppt_model')->apdet_sppt($kd_propinsi, $kd_dati2, $kd_kecamatan, $kd_kelurahan, $kd_blok, $no_urut, $kd_jns_op, $tahun, $status);

    if($update > 0){
        // var_dump('halo');die;
        $this->session->set_flashdata('msg_success', 'Data telah diubah');
        // $response = array('status' => 'success', 'message' => 'Data telah diubah');
        // redirect(active_module_url('update_sppt'));
        // echo "success";
            echo json_encode(['code' => '200', 'msg' => 'Berhasil']);
      }elseif ($update === 0) {
        $this->session->set_flashdata('msg_warning', 'Tidak ada perubahan data');
        // $response = array('status' => 'warning', 'message' => 'Tidak ada perubahan data');
        // redirect(active_module_url('update_sppt'));
        // echo "warning";
            echo json_encode(['code' => '404', 'msg' => 'Tidak ada perubahan data']);

      } else {
        $this->session->set_flashdata('msg_error', 'Data gagal diubah');
        // $response = array('status' => 'error', 'message' => 'Data gagal diubah');
        // redirect(active_module_url('update_sppt'));
        // echo "error";
            echo json_encode(['code' => '500', 'msg' => 'Data gagal diubah']);

      }

    // echo json_encode($response);

    // $sql = "UPDATE SPPT SET STATUS_PEMBAYARAN_SPPT = '".$status."'  WHERE KD_PROPINSI||KD_DATI2||KD_KECAMATAN||KD_KELURAHAN||KD_BLOK||NO_URUT||KD_JNS_OP = '".$nop."' AND thn_pajak_sppt = '".$tahun."' ";


        // $this->db->simple_qry_eon_ora($sql);


    // $nama_wp = $this->input->post('nama_wp');
    // $alamat_wp = $this->input->post('alamat_wp');
    // $jatuh_tempo = $this->input->post('jatuh_tempo');
    // $terhutang = $this->input->post('terhutang');
    // $pengurang = $this->input->post('pengurang');
    // $tagihan = $this->input->post('tagihan');


    // $data = array('STATUS_PEMBAYARAN_SPPT' => $status)

    // $result = $this->update_sppt_model->update_sppt($nop, $tahun, $data);
    // if (!empty($result)) {
    //     set_msg_db_error($result);
    // } else {
    //    return true;
    // }

    // $kd_propinsi = substr($nop, 0, 2);
    // $kd_dati2 = substr($nop, 2, 2);
    // $kd_kecamatan = substr($nop, 4, 3);
    // $kd_kelurahan = substr($nop, 7, 3);
    // $kd_blok = substr($nop, 10, 3);
    // $no_urut = substr($nop, 13, 4);
    // $kd_jns_op = substr($nop, 17, 1);

    // $where = array(
    //         'KD_PROPINSI' => $kd_propinsi,
    //         'KD_DATI2' => $kd_dati2,
    //         'KD_KECAMATAN' => $kd_kecamatan,
    //         'KD_KELURAHAN' => $kd_kelurahan,
    //         'KD_BLOK' => $kd_blok,
    //         'NO_URUT' => $no_urut,
    //         'KD_JNS_OP' => $kd_jns_op,
    //         'THN_PAJAK_SPPT' => $tahun,
    //         'NM_WP_SPPT' => $nama_wp,
    //         'JLN_WP_SPPT' => $alamat_wp,
    //         'TGL_JATUH_TEMPO_SPPT' => $jatuh_tempo,
    //         'PBB_TERHUTANG_SPPT' => $terhutang,
    //         'FAKTOR_PENGURANG_SPPT' => $pengurang,
    //         'PBB_YG_HARUS_DIBAYAR_SPPT' => $tagihan
    //     );

    //     $this->db->where($where)
    //              ->update('SPPT', array('STATUS_PEMBAYARAN_SPPT' => $status));

        // $where = "KD_PROPINSI || KD_DATI2 || KD_KECAMATAN || KD_KELURAHAN || KD_BLOK || NO_URUT || KD_JNS_OP = '$nop' AND 
        //       THN_PAJAK_SPPT = '$tahun' AND 
        //       NM_WP_SPPT = '$nama_wp' AND 
        //       JLN_WP_SPPT || ', ' || BLOK_KAV_NO_WP_SPPT || ', RW ' || RW_WP_SPPT || ', RT ' || RT_WP_SPPT || ', ' || KELURAHAN_WP_SPPT || ', ' || KOTA_WP_SPPT = '$alamat_wp' AND 
        //       TGL_JATUH_TEMPO_SPPT = '$jatuh_tempo' AND 
        //       PBB_TERHUTANG_SPPT = '$terhutang' AND 
        //       FAKTOR_PENGURANG_SPPT = '$pengurang' AND 
        //       PBB_YG_HARUS_DIBAYAR_SPPT = '$tagihan'";
        // $query = "UPDATE SPPT SET STATUS_PEMBAYARAN_SPPT = '$status' WHERE $where";

        // $where = "KD_PROPINSI = '$kd_propinsi' AND 
        //           KD_DATI2 = '$kd_dati2' AND 
        //           KD_KECAMATAN = '$kd_kecamatan' AND 
        //           KD_KELURAHAN = '$kd_kelurahan' AND 
        //           KD_BLOK = '$kd_blok' AND 
        //           NO_URUT = '$no_urut' AND 
        //           KD_JNS_OP = '$kd_jns_op' AND 
        //           THN_PAJAK_SPPT = '$tahun' AND 
        //           NM_WP_SPPT = '$nama_wp' AND 
        //           JLN_WP_SPPT = '$alamat_wp' AND 
        //           TGL_JATUH_TEMPO_SPPT = '$jatuh_tempo' AND 
        //           PBB_TERHUTANG_SPPT = '$terhutang' AND 
        //           FAKTOR_PENGURANG_SPPT = '$pengurang' AND 
        //           PBB_YG_HARUS_DIBAYAR_SPPT = '$tagihan'";

        // $query = "UPDATE SPPT SET STATUS_PEMBAYARAN_SPPT = '$status' WHERE $where";

        // var_dump($query);

        // $this->db->where('(KD_PROPINSI||KD_DATI2||KD_KECAMATAN||KD_KELURAHAN||KD_BLOK||NO_URUT||KD_JNS_OP)', $nop, false);
        // $this->db->where('thn_pajak_sppt', $tahun, false);
        // $get = $this->db->update_oen_ora('SPPT', ['STATUS_PEMBAYARAN_SPPT' => $status]);

        // return $get;

        // var_dump($get->num_rows());

    // if (!empty($status)) {
    // $this->load->library('Datatables');

        // $this->db->query($query);

    // } else {
    //     echo json_encode(array('status' => 'error', 'message' => 'Invalid input'));
    // }
  }

}
