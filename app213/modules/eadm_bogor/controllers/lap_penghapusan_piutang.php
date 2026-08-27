<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class lap_penghapusan_piutang extends CI_Controller
{
    private $controller = 'lap_penghapusan_piutang';

    function __construct()
    {
        parent::__construct();
        if (!is_login()) {
            echo "<script>window.location.replace('" . base_url() . "');</script>";
            exit;
        }

        $module = 'lap_penghapusan_piutang';
        $this->load->library('module_auth', array(
            'module' => $module
        ));

        $this->load->model(array(
            'apps_model', 'lap_penghapusan_piutang_model'
        ));

        $this->load->helper(active_module());
        
    }

    public function index()  {

        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect('eadm_bogor');
        }

        $data['page_menu'] = 'lap_penghapusan_piutang';
        $data['current'] = 'lap_penghapusan_piutang';
        $data['apps']    = $this->apps_model->get_active_only();

        $select_data  = $this->load->model('lap_penghapusan_piutang_model')->get_select_kecamatan();
                $options      = array();
                $kec_id = '';
                if($select_data) {
                foreach ($select_data as $row) {
              $options['999999'] = 'SEMUA KECAMATAN';
                    if($kec_id == '') $kec_id = $row->KD_KECAMATAN;
                    $options[$row->KD_KECAMATAN] = $row->NM_KECAMATAN;
                }}
                $js                       = 'id="kd_kecamatan" class="input select2 form-control" style="width:200px" required ';
                $data['select_kecamatan'] = form_dropdown('kd_kecamatan', $options, '999999', $js);
        //------------------------------------------------------------------

        $this->load->view('vlap_penghapusan_piutang', $data);
    }

    function get_kelurahan() {
        //log_message('info', "sssssssssssssssssssssssssssssssss");
        $kec_id    = $this->uri->segment(4);
        $kelurahan = $this->load->model('lap_penghapusan_piutang_model')->get_select_kel($kec_id);
        echo json_encode($kelurahan);
    }

    function cetak() {

        $type = $this->uri->segment(4);

        $qs   = urldecode ($_SERVER['QUERY_STRING']);
        parse_str($qs, $qs_data);

        $params = array();

        // $tglawal  = date('d-m-Y', strtotime($this->input->get('tglawal')));
        // $tglakhir = date('d-m-Y', strtotime($this->input->get('tglakhir')));

        $kd_kecamatan = $this->input->get('kd_kecamatan');

        $thn_awal = $this->input->get('thn_awal');
        $thn_akhir = $this->input->get('thn_akhir');

        $filter = ' ';
        
        if ($kd_kecamatan == "999999"){
            $filter = ' ';
        }
        else if (!empty($kd_kecamatan)){
            $filter = " and s.kd_kecamatan='".$kd_kecamatan."' ";
        }

        // $tglawal_  = date('Ymd', strtotime($this->input->get('tglawal')));
        // $tglakhir_ = date('Ymd', strtotime($this->input->get('tglakhir')));
        // //
        // $filter .= " and (to_char(v.tgl_byr,'YYYYMMDD') between '{$tglawal_}' and '{$tglakhir_}')";

        // FILTER TAHUN SPPT
        $filter .= " and s.thn_pajak_sppt between '{$thn_awal}' and '{$thn_akhir}'";

        $ignore_html_pg = TRUE;

        $rpt = "lap_penghapusan_piutang";

        $query = $this->load->model('lap_penghapusan_piutang_model')->query_rpt($filter);

        //var_dump($query);die;

        $params = array(
            // 'kd_kecamatan' => $kd_kecamatan,
            'tglawal' => $tglawal,
            'tglakhir' => $tglakhir,
            'thn_pjk_awal' => $thn_awal,
            'thn_pjk_akhir' => $thn_akhir,
            // 'filter' => $filter,
            'query' => $query
        );

        $ignore_html_pg = FALSE; //paging aja semua

        $rpt = $rpt;
        // $jasper = $this->load->library('Jasper');
        // echo $jasper->cetak($rpt, $params, "pdf", false);

        $jasper = $this->load->library('Jasper_ora');
        echo $jasper->cetak_ora($rpt, $params, 'pdf', false);

    }

}
