<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class batal_pembayaran extends CI_Controller
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

        $module = 'batal_pembayaran';
        $this->load->library('module_auth', array('module' => $module));

        $this->load->helper('app_helper');
        $this->load->model(array('apps_model', 'login_model', 'batal_pembayaran_model', 'payment_model'));

        if ($grp = $this->login_model->check_user_app()) {
            $this->session->set_userdata('groupid', $grp->GROUP_ID);
            $this->session->set_userdata('groupkd', $grp->GROUP_KODE);
            $this->session->set_userdata('groupname', htmlspecialchars($grp->GROUP_NAMA));
        }
    }

    public function index()
    {

        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect('pospbb_ora');
        }

        $data['page_menu'] = 'm02_mn_stts';
        $data['current']   = 'batal_pembayaran'; // stts

        $filter = $this->session->userdata('pos_filter');
        $filter = isset($filter) ? $filter : '';
        $data['filter']  = $filter;
        $data['tpnm'] = isset($this->session->userdata['tpnm']) ? $this->session->userdata['tpnm'] : '';

        $data['apps']    = $this->apps_model->get_active_only();
        //$data['current'] = 'stts';
        $this->load->view('batal_pembayaran/vbatal_pembayaran', $data);
    }

    public function cari()
    {

        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect('pospbb_ora');
        }
        /*
        $nop = $this->uri->segment(4);
        $thn = $this->uri->segment(5);
        $ke  = $this->uri->segment(6);
        */
        $nop = $this->input->get('nopd');
        $thn = $this->input->get('thn');
        $ke  = $this->input->get('byr_ke');
        //
        $bayar_id = 0;
        $pengurang_bayar = 0;

        if ($nop && $thn && $ke && $query = $this->batal_pembayaran_model->cek_byr_by_stts($nop, $thn, $ke)) {

            $bayar_id = $query->ID;
            $nil_pengurang = floatval($query->FAKTOR_PENGURANG_BAYAR);
            //log_message('info', " 222222222222222222222  floatval PBB_YG_HARUS_DIBAYAR_SPPT : ". floatval($query->NILAI_ATAS_WP));
        } else {
            $result['found'] = 0;
            echo json_encode($result);
            exit;
        }

        if ($nop && $thn && $ke && $query = $this->payment_model->get_by_nop_thn_ke($nop, $thn, $ke)) {

            //if(is_super_admin() || $this->session->userdata('groupkd')=='posspv') {
            $terbilang = terbilang($query->JML_SPPT_YG_DIBAYAR);
            $tmp = floatval($query->FAKTOR_PENGURANG_SPPT);
            if ($tmp > 0) {
                $nil_pengurang = $tmp;
            }

            $query = (object) array_merge((array)$query, array('found' => 1, 'terbilang' => $terbilang, 'bayar_id' => $bayar_id, 'nil_pengurang' => $nil_pengurang));
            echo json_encode($query);
            exit;
            //}

        }

        $result['found'] = '0';
        echo json_encode($result);
    }

    public function proses_batal()
    {
        //log_message('info', "WWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWW  gggggggggggg : ");
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
            redirect('pospbb_ora');
        }
        /*
        $nop = $this->uri->segment(4);
        $thn = $this->uri->segment(5);
        $ke  = $this->uri->segment(6);
        */
        $nop = $this->input->get('nopd');
        $thn = $this->input->get('thn');
        $ke  = $this->input->get('byr_ke');
        $bayar_id  = $this->input->get('byr_id');

        //log_message('info', "WWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWW  dt_rekap_bln : ");
        if ($nop && $thn && $ke) {
            $resultdb = $this->batal_pembayaran_model->batal_pembayaran_ke($nop, $thn, $ke, $bayar_id);
            //echo 'yes';
            if (!empty($resultdb)) {
                set_msg_db_error($resultdb);
                echo 'no';
            } else {
                echo 'yes';
            }
        } else {
            echo 'no';
        }
    }
}
