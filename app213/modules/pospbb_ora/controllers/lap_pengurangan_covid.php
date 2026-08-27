<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class lap_pengurangan_covid extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('login')) {
            $this->session->set_flashdata('msg_warning', 'Session telah kadaluarsa, silahkan login ulang.');
            redirect('login');
            exit;
        }

        if (!is_super_admin() && !isset($this->session->userdata['tpnm'])) {
            show_404();
            exit;
        }

        $module = 'POSPNGCVD';  // POS PENGURANGAN COVID 19
        $this->load->library('module_auth', array(
            'module' => $module
        ));

        $this->load->model(array(
            'apps_model'
        ));
        $this->load->model(array(
            'pbb/refkelurahan_model',
            'pbb/tp_model',
            'rpt_model',
            'pos_user_model'
        ));
    }

    public function index()
    {

        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect('info');
        }

        $data['current'] = 'lap_pengurangan_covid';
        $data['apps']    = $this->apps_model->get_active_only();

        //------------------------------------------------------------------
        /*
        $select_data = $this->load->model('lap_hapus_denda_model')->get_select_buku();
        $options     = array();
        foreach ($select_data as $row) {
            $options[$row->buku_id] = $row->buku_nm;
        }
        $js  = 'id="buku_id" class="input"  style="width:300px;" ';
        $select = form_dropdown('buku_id', $options, ' ', $js);
        $select = preg_replace("/[\r\n]+/", "", $select);
        $data['select_buku'] = $select;
	*/
        //------------------------------------------------------------------
        $select_data = $this->load->model('lap_pengurangan_covid_model')->get_select_tp();
        $options     = array();
        foreach ($select_data as $row) {
            $options[$row->KD_TP] = $row->NM_TP;
        }
        $js  = 'id="kd_tp" class="input"  style="width:300px;" ';
        $select = form_dropdown('kd_tp', $options, ' ', $js);
        $select = preg_replace("/[\r\n]+/", "", $select);
        $data['select_tp'] = $select;
        //------------------------------------------------------------------
        $select_data = $this->load->model('lap_pengurangan_covid_model')->get_select_kec();
        $options     = array();

        foreach ($select_data as $row) {
            $options[$row->KD_KECAMATAN] = $row->NM_KECAMATAN;
        }
        $js  = 'id="kd_kecamatan" class="input form-control select2" onChange="search_kelurahan(this.value);" ';
        $data['select_kecamatan'] = form_dropdown('kd_kecamatan', $options, '', $js);
        //------------------------------------------------------------------
        $select_data = $this->load->model('lap_pengurangan_covid_model')->get_select_kel(' ');
        $options     = array();
        if ($select_data) {
            foreach ($select_data as $rows) {
                $options[$rows->KD_KELURAHAN] = $rows->NM_KELURAHAN;
            }
        }
        $js = 'id="kd_kelurahan" class="input" style="width:300px;" ';
        $data['select_kelurahan'] = form_dropdown('kd_kelurahan', $options, '', $js);
        //------------------------------------------------------------------

        $this->load->view('lap_pengurangan_covid/vlap_pengurangan_covid', $data);
    }

    function get_kelurahan()
    {
        //log_message('info', "sssssssssssssssssssssssssssssssss");
        $kec_id    = $this->uri->segment(4);
        $kelurahan = $this->load->model('lap_pengurangan_covid_model')->get_select_kel($kec_id);
        echo json_encode($kelurahan);
    }

    function cetak()
    {

        $type = $this->uri->segment(4);

        $qs   = urldecode($_SERVER['QUERY_STRING']);
        parse_str($qs, $qs_data);

        $params = array();

        // foreach ($qs_data as $key => $val)
        // $params[$key] = $val;

        $tglawal  = date('d-m-Y', strtotime($this->input->get('tglawal')));
        $tglakhir = date('d-m-Y', strtotime($this->input->get('tglakhir')));

        $kd_kecamatan = $this->input->get('kd_kecamatan');
        // $pilih_dok = $this->input->get('pilih_dok');

        $filter = ' ';
        if ($kd_kecamatan == " ") {
            $filter = ' ';
        } else if (!empty($kd_kecamatan)) {
            $filter = " and spp.kd_kecamatan='" . $kd_kecamatan . "' ";
        }

        $tglawal_  = date('Ymd', strtotime($this->input->get('tglawal')));
        $tglakhir_ = date('Ymd', strtotime($this->input->get('tglakhir')));
        //
        //$filter .= " and (to_char(byr.tgl_pembayaran_sppt,'YYYYMMDD') between '{$tglawal_}' and '{$tglakhir_}')";
        $filter .= " AND byr.tgl_pembayaran_sppt BETWEEN TO_DATE('{$tglawal_}', 'YYYYMMDD') AND TO_DATE('{$tglakhir_}', 'YYYYMMDD')";
        //$filter = ' ';
        //
        $rpt = $this->input->get('rpt');
        $ignore_html_pg = TRUE;

        switch ($rpt) {
            case 'peng_cvd':

                $rpt = "lap_pengurangan_covid";

                $params = array(
                    'kd_kecamatan' => $kd_kecamatan,
                    'tglawal' => $tglawal,
                    'tglakhir' => $tglakhir,
                    'filter' => $filter,
                );

                break;
        }

        $ignore_html_pg = FALSE; //paging aja semua

        $rpt = $rpt;
        //var_dump($filter);die;
        // $P!{filter}
        // $jasper = $this->load->library('Jasper');
        // echo $jasper->cetak($rpt, $params, "pdf", false);

        $jasper = $this->load->library('Jasper_Ora');
        echo $jasper->cetak_ora($rpt, $params, "pdf", false);
    }
}
