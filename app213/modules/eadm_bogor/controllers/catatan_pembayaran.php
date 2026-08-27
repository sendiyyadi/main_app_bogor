<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class catatan_pembayaran extends CI_Controller
{
    private $controller = 'catatan_pembayaran';
    
    public function __construct()
    {
        parent::__construct();
        if (!is_login()) {
            echo "<script>window.location.replace('" . base_url() . "');</script>";
            exit;
        }

        $module = 'catatan_pembayaran';
        $this->load->library('module_auth', array(
            'module' => $module
        ));

        $this->load->model(array(
            'apps_model', 'catatan_pembayaran_model'
        ));

        $this->load->helper(active_module());
    }

    public function index()
    {
        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect('eadm_bogor');
        }

        $data['page_menu'] = 'catatan_pembayaran';
        $data['current'] = 'catatan_pembayaran';
        $data['apps']    = $this->apps_model->get_active_only();

        $this->load->view('vcatatan_pembayaran', $data);
    }

    public function grid()
    {

        $fnop   = $this->input->get('nop');
        if(empty($fnop) || $fnop == ''){
            $fnop = '99.99.999.999.999.9999.9';
        }
        $string_replace = array('.', '-');
        $nop   = str_replace($string_replace, '', $fnop);
        $prop_kd = substr($nop, 0, 2);
        $kab_kd  = substr($nop, 2, 2);
        $kec_kd  = substr($nop, 4, 3);
        $kel_kd  = substr($nop, 7, 3);
        $blok_kd = substr($nop, 10, 3);
        $urut_no = substr($nop, 13, 4);
        $jns_kd  = substr($nop, 17, 1);

        $this->load->library('Datatables');
        $this->datatables->select("THN_PAJAK_SPPT, NM_WP_SPPT, LUAS_TANAH, NJOP_TANAH, LUAS_BNG, NJOP_BNG, KETETAPAN, 
        JML_BAYAR, JML_DENDA, CASE WHEN NBLN < 0 THEN 0 WHEN NBLN > 24 THEN 24 ELSE NBLN END AS BLN_TELAT,
        CASE WHEN tgl_jatuh_tempo_sppt < TO_DATE('2024-01-01', 'YYYY-MM-DD') THEN NVL(hit_denda2(ketetapan, 2, tgl_jatuh_tempo_sppt), 0) ELSE NVL(hit_denda2(ketetapan, 1, tgl_jatuh_tempo_sppt), 0) END as denda_berjalan,
        CASE WHEN (KETETAPAN <= (JML_BAYAR - JML_DENDA) ) THEN 0 
        ELSE (KETETAPAN - (JML_BAYAR - JML_DENDA) + CASE WHEN tgl_jatuh_tempo_sppt < TO_DATE('2024-01-01', 'YYYY-MM-DD') THEN NVL(hit_denda2(ketetapan, 2, tgl_jatuh_tempo_sppt), 0) ELSE NVL(hit_denda2(ketetapan, 1, tgl_jatuh_tempo_sppt), 0) END) END AS SISA_2, 
        TGL_BAYAR, 
        CASE WHEN (KETETAPAN < (JML_BAYAR - JML_DENDA) ) THEN 0 ELSE (KETETAPAN - (JML_BAYAR - JML_DENDA) ) END AS SISA, STATUS_TAGIHAN, TERHUTANG_SPPT, PENGURANG_SPPT", false);
        
        $this->datatables->from("V_CTT_PMB");
        
        $this->datatables->where('KD_PROPINSI', $prop_kd);
        $this->datatables->where('KD_DATI2', $kab_kd);
        $this->datatables->where('KD_KECAMATAN', $kec_kd);
        $this->datatables->where('KD_KELURAHAN', $kel_kd);
        $this->datatables->where('KD_BLOK', $blok_kd);
        $this->datatables->where('NO_URUT', $urut_no);
        $this->datatables->where('KD_JNS_OP', $jns_kd);

       //$this->datatables->rupiah_column('2, 3, 4, 5, 6, 7, 8, 10, 11, 13, 15, 16');

        echo $this->datatables->generate();
    }

    function cek_lunas(){
        $fnop   = $this->input->post('nop');
        $string_replace = array('.', '-');
        $nop   = str_replace($string_replace, '', $fnop);

        $spt_lnss = $this->catatan_pembayaran_model->cek_lunas($nop, "2025");

        $result = empty($spt_lnss); // TRUE artinya lunas

        echo json_encode(['lunas' => $result]);
    }

    function cetak_rpt(){
        $rpt = $this->uri->segment(4);
        $nop = $this->uri->segment(5);
        $string_replace = array('.', '-');
        $nop   = str_replace($string_replace, '', $nop);
        $prop_kd = substr($nop, 0, 2);
        $kab_kd  = substr($nop, 2, 2);
        $kec_kd  = substr($nop, 4, 3);
        $kel_kd  = substr($nop, 7, 3);
        $blok_kd = substr($nop, 10, 3);
        $urut_no = substr($nop, 13, 4);
        $jns_kd  = substr($nop, 17, 1);
        $qs   = urldecode ($_SERVER['QUERY_STRING']);
        parse_str($qs, $qs_data);
        $type = 'pdf';
        
        $params = array(
            'prop_kd' => $prop_kd,
            'kab_kd' => $kab_kd,
            'kec_kd' => $kec_kd,
            'kel_kd' => $kel_kd,
            'blok_kd' => $blok_kd,
            'urut_no' => $urut_no,
            'jns_kd' => $jns_kd,
            'nip_login' => sipkd_user_nip(),
            'nama_login' => sipkd_user_name(),

        );

        // $rpt = 'catatan_pembayaran_rpt';
        // include 'query_r713.php';

        $jasper = $this->load->library('Jasper_ora');
        // echo $jasper->cetak_ora($rpt, $params, $type, false);
        echo $jasper->cetak_ora($rpt, $params, 'pdf', false);
        // echo $qq;
    }

    function cetak_rpt_new(){
        $rpt = $this->uri->segment(4);
        $nop = $this->uri->segment(5);
        $string_replace = array('.', '-');
        $nop   = str_replace($string_replace, '', $nop);
        $prop_kd = substr($nop, 0, 2);
        $kab_kd  = substr($nop, 2, 2);
        $kec_kd  = substr($nop, 4, 3);
        $kel_kd  = substr($nop, 7, 3);
        $blok_kd = substr($nop, 10, 3);
        $urut_no = substr($nop, 13, 4);
        $jns_kd  = substr($nop, 17, 1);
        $qs   = urldecode ($_SERVER['QUERY_STRING']);
        parse_str($qs, $qs_data);
        $type = 'pdf';
        $today = date('Ymd');

        $query = $this->catatan_pembayaran_model->query_rpt($nop);

        $spt_lns = $this->catatan_pembayaran_model->cek_lunas($nop, "2025");
        if (empty($spt_lns)) {
            $spt_lunas = "1";  //lunas
        } else {
            $spt_lunas = "0";  // blm lunas
        }
        
        $params = array(
            'query' => $query,
            'spt_lunas' => $spt_lunas,
            'nip_login' => sipkd_user_nip(),
            'nama_login' => sipkd_user_name(),
            'today' => $today,
        );

        $jasper = $this->load->library('Jasper_ora');
        echo $jasper->cetak_ora($rpt, $params, 'pdf', false);
    }

}
