<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class sppt_bermasalah extends CI_Controller
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
    // function __construct()
    // {
    //     parent::__construct();
    //     if (!$this->session->userdata('login')) {
    //         echo "<script>window.location.replace('" . base_url() . "');</script>";
    //         exit;
    //     }

    //     $this->load->helper('url');
    //     $this->load->library('datatables');
    //     $this->load->model('MSppt_bermasalah');
    // }

    private $controller = 'sppt_bermasalah';
    public function __construct()
    {
        parent::__construct();
        if (!is_login()) {
            echo "<script>window.location.replace('" . base_url() . "');</script>";
            exit;
        }

        $module = 'sppt_bermasalah';
        $this->load->library('module_auth', array(
            'module' => $module
        ));

        $this->load->model(array(
            'apps_model'
        ));

        $this->load->helper(active_module());
        $this->load->model('sppt_bermasalah_model', 'MSppt_bermasalah');
    }


    public function index()
    {
        //------------------------------------------------------------------
          //   $select_data  = $this->MSppt_bermasalah->get_select_kecamatan();
        		// $options      = array();
        		// $kec_id = '';
        		// if($select_data) {
        		// foreach ($select_data as $row) {
        		// 	if($kec_id == '') $kec_id = $row->KD_KECAMATAN;
        		// 	$options[$row->KD_KECAMATAN] = $row->NM_KECAMATAN;
        		// }}
        		// $js                       = 'id="KD_KEC" class="form-control" onChange="get_kelurahan(this.value);" required ';
        		// $data['select_kecamatan'] = form_dropdown('KD_KEC', $options, '', $js);
          //   //------------------------------------------------------------------
        		// $select_data = $this->MSppt_bermasalah->get_select_kelurahan($kec_id);
        		// $options     = array();
        		// if($select_data) {
        		// foreach ($select_data as $row) {
        		// 	$options[$row->KD_KELURAHAN] = $row->NM_KELURAHAN;
        		// }}
        		// $js                       = 'id="KD_KEL" class="form-control" required ';
        		// $data['select_kelurahan'] = form_dropdown('KD_KEL', $options, '', $js);
          //   //------------------------------------------------------------------

          //   //------------------------------------------------------------------
          //   $select_data  = $this->MSppt_bermasalah->get_select_kecamatan();
        		// $options      = array();
        		// $kec_id = '';
        		// if($select_data) {
        		// foreach ($select_data as $row) {
        		// 	if($kec_id == '') $kec_id = $row->KD_KECAMATAN;
        		// 	$options[$row->KD_KECAMATAN] = $row->NM_KECAMATAN;
        		// }}
        		// $js                       = 'id="KD_KEC_E" class="form-control" onChange="get_kelurahan_e(this.value);" required ';
        		// $data['select_kecamatan_e'] = form_dropdown('KD_KEC_E', $options, '', $js);
          //   //------------------------------------------------------------------
        		// $select_data = $this->MSppt_bermasalah->get_select_kelurahan($kec_id);
        		// $options     = array();
        		// if($select_data) {
        		// foreach ($select_data as $row) {
        		// 	$options[$row->KD_KELURAHAN] = $row->NM_KELURAHAN;
        		// }}
        		// $js                       = 'id="KD_KEL_E" class="form-control" required ';
        		// $data['select_kelurahan_e'] = form_dropdown('KD_KEL_E', $options, '', $js);
          //   //------------------------------------------------------------------

        // $data['current'] = 'sppt_bermasalah';

        $data['page_menu']  = 'sppt_bermasalah';
        $data['current']    = '';
        $data['controller'] = $this->controller;
        $data['apps']       = $this->apps_model->get_active_only();

        $this->load->view('v_sppt_bermasalah', $data);
    }

    function get_nop_bermasalah()
    {
        // header('Content-Type: application/json');
        // echo $this->MSppt_bermasalah->getUserds();

        $nop   = $this->input->get('nop');
        $kel   = $this->input->get('kel');
        $kec   = $this->input->get('kec');

        $this->load->library('Datatables');
        // $this->datatables->select("LOGINNAME,PASSWOD,NAMA,EMAIL,NIP,USER_GROUP,KD_KEC,KD_KEL",false);
        // $this->datatables->from('M02USERS_DS');
        $this->datatables->select("".ID_BN.", trim(".NOP_BN."), trim(".THN_BN."), trim(".NM_KELURAHAN."), trim(".NM_KECAMATAN."), trim(".ALASAN_BN."), ".LOGINNAME_BN.", ".
            APPROVED_BY_BN.", CASE WHEN ".APPROVED_BN."=0 THEN 'OPEN' WHEN ".APPROVED_BN."=1 THEN 'APPROVE' WHEN ".APPROVED_BN."=2 THEN 'DECLINE' ELSE '#NOTFOUND' END as STTS, ".
            APPROVED_BN, false);
        $this->datatables->from(TBL_BATALNOP);
        // $this->datatables->join(TBL_M03USRGROUP_DS, M03USER_GROUP.'='.M02USER_GROUP, 'left');
        $this->datatables->join(TBL_REF_KECAMATAN, 'REF_KECAMATAN.KD_KECAMATAN = SUBSTR(BATAL_NOP.NOP,5,3)', 'left', false);
        $this->datatables->join(TBL_REF_KELURAHAN, 'REF_KELURAHAN.KD_KELURAHAN = SUBSTR(BATAL_NOP.NOP,8,3) and SUBSTR(BATAL_NOP.NOP,5,3) = REF_KELURAHAN.KD_KECAMATAN', 'left', false);

        if(!empty($nop)){
            $nop = trim($nop);
            $nop = strtoupper($nop);
            $this->datatables->where("trim(".NOP_BN.") like ('%".$nop."%')");
        }

        //$this->datatables->join('REF_INSTANSI_DEPOK D1','D1.KD_INSTANSI=PT.KD_INSTANSI','left');
        //$this->datatables->join('REF_JABATAN D2','D2.KD_JABATAN=PT.KD_JABATAN','left');

      //  $this->datatables->checkbox_column('8');
        echo $this->datatables->generate();
    }

    private function fvalidation($model) {
        $this->form_validation->set_error_delimiters('<span>', '</span>');
        if ($model == 'add'){
            $this->form_validation->set_rules('LOGIN_NAME', 'Login Name', 'required|max_length[30]');
            $this->form_validation->set_rules('PASSWOD','Password','required|max_length[20]');
            $this->form_validation->set_rules('NAMA', 'Nama', 'required|max_length[50]');
            $this->form_validation->set_rules('EMAIL', 'Email', 'max_length[10]');
            $this->form_validation->set_rules('NIP', 'NIP', 'max_length[19]');
            // $this->form_validation->set_rules('KD_KEC', 'Kecamatan', '');
            // $this->form_validation->set_rules('KD_KEL', 'Kelurahan', '');
        } else {
            $this->form_validation->set_rules('LOGIN_NAME_E', 'Login Name', 'required|max_length[30]');
            // $this->form_validation->set_rules('PASSWOD_E','Password','required|max_length[20]');
            $this->form_validation->set_rules('NAMA_E', 'Nama', 'required|max_length[50]');
            $this->form_validation->set_rules('EMAIL_E', 'Email', 'max_length[10]');
            $this->form_validation->set_rules('NIP_E', 'NIP', 'max_length[19]');
            // $this->form_validation->set_rules('KD_KEC', 'Kecamatan', '');
            // $this->form_validation->set_rules('KD_KEL', 'Kelurahan', '');

        }

    }

    public function approve() {   // PROSES APPROVE

        $id   = $this->uri->segment(4);
        $user_id  = $this->session->userdata('nama');

        $result   = $this->MSppt_bermasalah->approve($id,$user_id);

        if ($result){
            $this->session->set_flashdata('msg_info', 'Data berhasil di approve');
            redirect(active_module_url($this->controller));
        } else {
            $this->session->set_flashdata('msg_info', 'Data gagal di approve');
            redirect(active_module_url($this->controller));
        }

        $data['page_menu']  = 'sppt_bermasalah';
        $data['current']    = '';
        $data['controller'] = $this->controller;
        $data['apps']       = $this->apps_model->get_active_only();

        $this->load->view('v_sppt_bermasalah', $data);

    }

    public function tolak() {   // PROSES APPROVE

        $id   = $this->uri->segment(4);
        $user_id  = $this->session->userdata('nama');

        $result   = $this->MSppt_bermasalah->tolak($id,$user_id);

        if ($result){
            $this->session->set_flashdata('msg_info', 'Data berhasil di Tolak');
            redirect(active_module_url($this->controller));
        } else {
            $this->session->set_flashdata('msg_info', 'Data gagal di Tolak');
            redirect(active_module_url($this->controller));
        }

        $data['page_menu']  = 'sppt_bermasalah';
        $data['current']    = '';
        $data['controller'] = $this->controller;
        $data['apps']       = $this->apps_model->get_active_only();
        $this->load->view('v_sppt_bermasalah', $data);

    }

    public function batal() {   // PROSES APPROVE

        $id   = $this->uri->segment(4);
        $user_id  = $this->session->userdata('nama');

        $result   = $this->MSppt_bermasalah->batal($id,$user_id);

        if ($result){
            $this->session->set_flashdata('msg_info', 'Data berhasil di Batalkan');
            redirect(active_module_url($this->controller));
        } else {
            $this->session->set_flashdata('msg_info', 'Data gagal di Batalkan');
            redirect(active_module_url($this->controller));
        }

        $data['page_menu']  = 'sppt_bermasalah';
        $data['current']    = '';
        $data['controller'] = $this->controller;
        $data['apps']       = $this->apps_model->get_active_only();
        $this->load->view('v_sppt_bermasalah', $data);

    }


}
