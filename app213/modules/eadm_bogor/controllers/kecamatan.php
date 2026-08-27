<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class kecamatan extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!is_login()) {
            echo "<script>window.location.replace('" . base_url() . "');</script>";
            exit;
        }

        $module = 'menu_kecamatan';
        $this->load->library('module_auth', array(
            'module' => $module
        ));

        $this->load->model(array(
            'apps_model', 'kecamatan_model'
        ));

        $this->load->helper(active_module());
    }

    public function index()
    {
        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect('eadm_bogor');
        }

        $data['page_menu'] = 'referensi';
        $data['current'] = 'menu_kecamatan';
        $data['apps']    = $this->apps_model->get_active_only();

        $this->load->view('vkecamatan', $data);
    }

    function grid(){

        //$prop = sipkd_kd_propinsi();
        //log_message('info', "BBBBBBBBBB CREATE MODULE : " .$prop );
        $this->load->library('Datatables');
        $this->datatables->select("ROWIDTOCHAR(KC.ROWID) AS ID, KC.KD_PROPINSI, KC.KD_DATI2, KC.KD_KECAMATAN, KC.NM_KECAMATAN");
        $this->datatables->from("REF_KECAMATAN KC");
        echo $this->datatables->generate();

    }

    private function fvalidation($jenis_kecamatan = null)
    {
        $this->form_validation->set_error_delimiters('<span>', '</span>');
        $this->form_validation->set_rules('kd_kecamatan','Kode','required|trim|max_length[3]|min_length[3]');
        $this->form_validation->set_rules('nm_kecamatan','Nama','required|trim|max_length[30]');
        $this->form_validation->set_rules('kd_propinsi','Kode Duplicate','required|callback_cek_uniqkey['."uniqkey".']');
    }

    private function fpost(){

        $data['rowid'] = post_string($this->input->post('rowid'));
        $data['kd_propinsi'] = post_string($this->input->post('kd_propinsi'));
        $data['kd_dati2']    = post_string($this->input->post('kd_dati2'));
        $data['kd_kecamatan'] = post_string($this->input->post('kd_kecamatan'));
        $data['nm_kecamatan'] = post_string($this->input->post('nm_kecamatan'));
        return $data;
    }

    function cek_uniqkey ($value, $field) {

        $rowid = $this->input->post('rowid');
        $kd_propinsi = $this->input->post('kd_propinsi');
        $kd_dati2 = $this->input->post('kd_dati2');
        $kd_kecamatan = $this->input->post('kd_kecamatan');

        if(empty($rowid)) {$rowid ="0";}
        //
        if($this->kecamatan_model->cek_uniq_key($rowid, $kd_kecamatan)) {
            $this->form_validation->set_message('cek_uniqkey','Kode tsb sudah ada.....!');
            return false;
        }
        else {return true;}
    }

    public function add()
    {
        if (!$this->module_auth->create) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_create);
            redirect(active_module_url('kecamatan'));
        }

        $post_data  = $this->fpost();

        $this->fvalidation();

        if ($this->form_validation->run() == TRUE) {

            $input_post = $post_data;

            $update_data = array(

                'KD_PROPINSI' => pad_propinsi_id(),
                'KD_DATI2' => pad_kabupaten_id(),
                'KD_KECAMATAN' => app_string($input_post['kd_kecamatan']),
                'NM_KECAMATAN' => app_string($input_post['nm_kecamatan']),

            );
            $result = $this->kecamatan_model->insert_data($update_data);
            if(!empty($result)){
                set_msg_db_error($result);
            }else{
            $this->session->set_flashdata('msg_success', 'Data telah disimpan');
            redirect(active_module_url('kecamatan'));
            }
           
        }

        $data['page_menu'] = 'referensi';
        $data['current'] = 'menu_kecamatan';
        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = active_module_url('kecamatan/add');

        $data['dt'] = $post_data;
        $data['dt']['kd_propinsi'] = pad_propinsi_id();
        $data['dt']['kd_dati2'] = pad_kabupaten_id();

        $this->load->view('vkecamatan_form', $data);

    }

    public function edit(){

        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
            redirect(active_module_url('kecamatan'));
        }

        $p_id = $this->uri->segment(4);
        $rowid = $p_id;

        $data['page_menu'] = 'referensi';
        $data['current'] = 'menu_kecamatan';
        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = active_module_url("kecamatan/update/{$p_id}");

        if ($p_id && $get = $this->kecamatan_model->get($p_id)) {

            $data['dt']['rowid'] = $get->ID;
            $data['dt']['kd_propinsi'] = get_string($get->KD_PROPINSI);
            $data['dt']['kd_dati2']    = get_string($get->KD_DATI2);
            $data['dt']['kd_kecamatan'] = get_string($get->KD_KECAMATAN);
            $data['dt']['nm_kecamatan'] = get_string($get->NM_KECAMATAN);

            $this->load->view('vkecamatan_form', $data);
        } 
        else {
            show_404();
        }
    }

    public function update(){

        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
            redirect(active_module_url('kecamatan'));
        }

        $p_id       = $this->uri->segment(4);
        $post_data = $this->fpost();

        $rowid = $this->input->post('rowid');

        $data['page_menu'] = 'referensi';
        $data['current'] = 'menu_kecamatan';
        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = active_module_url("kecamatan/update/{$p_id}");

        $this->fvalidation();

        if ($this->form_validation->run() == TRUE) {

            $input_post  = $post_data;

            $update_data = array(
                'NM_KECAMATAN' => app_string($input_post['nm_kecamatan']),
            );

            $result = $this->kecamatan_model->update_data($rowid, $update_data);
            if(!empty($result)){
                set_msg_db_error($result);
            }else{
            $this->session->set_flashdata('msg_success', 'Data telah disimpan');
            redirect(active_module_url('kecamatan'));
            }
        }

        $get = (object)$post_data;
        $data['dt'] = $post_data;

        $this->load->view('vkecamatan_form', $data);
    }

    public function delete(){

        if (!$this->module_auth->delete) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_delete);
            redirect(active_module_url('kecamatan'));
        }

        $id = $this->uri->segment(4);

        if ($id && $this->kecamatan_model->get($id)) {

            $result = $this->kecamatan_model->delete_data($id);

            if(!empty($result)){
                set_msg_db_error($result);
            }else{
                   $this->session->set_flashdata('msg_success', 'Data telah dihapus');
            redirect(active_module_url('kecamatan')); 
            }
        
        } else {
            show_404();
        }
    }

}
