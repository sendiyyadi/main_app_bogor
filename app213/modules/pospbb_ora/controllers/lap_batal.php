<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class lap_batal extends CI_Controller
{
    private $module = 'lap_batal';

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

        //$module = 'lap_batal';
        $this->load->library('module_auth', array('module' => $this->module));

        $this->load->model(array('apps_model', 'tp_bayar_model', 'rpt_model', 'pos_user_model'));
    }

    public function index()
    {
        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect('pospbb_ora');
        }

        $data['page_menu'] = 'm04_mn_laporan';
        $data['current']   = $this->module;
        $data['apps']      = $this->apps_model->get_active_only();
        $data['faction'] = active_module_url('lap_batal/batal');

        $data['tpnm']    = isset($this->session->userdata['tpnm']) ? $this->session->userdata['tpnm'] : '';
        //$data['users']   =  $this->pos_user_model->get_tp_user();        
        //-----------------------------------------------------------------------
        $select_data = $this->pos_user_model->get_select_tp_users();
        $options = array();
        if ($select_data) {
            if (count($select_data) > 1) {
                $options['0'] = 'SELURUH USER';
            }
            foreach ($select_data as $row) {
                $options[$row->ID] = $row->NAMA;
            }
        } else {
            $options['9999777'] = 'USER TDK ADA HAK';
        }
        //
        $js = 'id="user_id" name="user_id" class="input form-control select2" ';
        $data['select_tp_users'] = form_dropdown('user_id', $options, '0', $js);
        //-----------------------------------------------------------------------        

        //print_r($data['users']);
        $this->fvalidation();
        $this->load->view('lap_batal/vlap_batal', $data);
    }

    private function fvalidation()
    {
        $this->form_validation->set_error_delimiters('<span>', '</span>');
        $this->form_validation->set_rules('tgl_fr', 'Tanggal', 'required');
        $this->form_validation->set_rules('tgl2', 'Tanggal', 'required');
    }

    public function batal()
    {
        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect('info');
        }

        $this->fvalidation();

        $tgl_fr = '';
        if (isset($_POST['tgl_fr'])) {
            if ($_POST['tgl_fr'] != '')
                $tgl_fr = date('Y-m-d', strtotime($_POST['tgl_fr']));
        }
        if ($tgl_fr == '') {
            $tgl_fr = date('Y-m-d');
        }
        //
        $tgl_to = '';
        if (isset($_POST['tgl_to'])) {
            if ($_POST['tgl_to'] != '')
                $tgl_to = date('Y-m-d', strtotime($_POST['tgl_to']));
        }
        if ($tgl_to == '') {
            $tgl_to = date('Y-m-d');
        }

        $user_id = $_POST['user_id'];
        $data['user_id'] = $user_id;
        $tanggal_fr  = date('d-m-Y', strtotime($tgl_fr));
        $tanggal_to  = date('d-m-Y', strtotime($tgl_to));

        $data['tanggal_fr'] = $tanggal_fr;
        $data['tanggal_to'] = $tanggal_to;
        $data['tanggal']    = $tanggal_fr . ' sd ' . $tanggal_to;

        $r = $this->rpt_model->get_lap_pembatalan($user_id, $tgl_fr, $tgl_to);
        $data['rows'] = $r;

        $this->load->view('vrpt_lap_batal', $data);
    }

    public function csv_download()
    {

        $tgl_fr = date('Y-m-d', strtotime($_POST['tgl_fr']));
        $tgl_to = date('Y-m-d', strtotime($_POST['tgl_to']));

        $tanggal_fr  = date('d-m-Y', strtotime($tgl_fr));
        $tanggal_to  = date('d-m-Y', strtotime($tgl_to));

        header("Content-type: text/plain");
        header("Cache-Control: no-store, no-cache");
        header('Content-Disposition: attachment; filename="Laporan Pembatalan ' . $tanggal_fr . ' s.d.' . $tanggal_to . '.csv"');

        if ($rows = $this->rpt_model->get_lap_pembatalan_csv($tgl_fr, $tgl_to)) {
            $title = array('TANGGAL', 'NOP', 'NILAI');
            $this->csv_encode($rows, $title);
        } else {
            echo "Tidak ada data";
        }
        exit;
    }

    function csv_encode($aaData, $aHeaders = NULL)
    {
        // output headers
        if ($aHeaders) echo implode('|', $aHeaders) . "\r\n";

        foreach ($aaData as $aRow) {
            echo implode('|', $aRow) . "\r\n";
        }
    }
}
