<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class kelurahan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!is_login()) {
            echo "<script>window.location.replace('" . base_url() . "');</script>";
            exit;
        }

        $module = 'menu_kelurahan';
        $this->load->library('module_auth', array(
            'module' => $module
        ));

        $this->load->model(array(
            'apps_model', 'kelurahan_model'
        ));

        $this->load->helper(active_module());
    }

    public function index()
    {
        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect('pasar/pasar');
        }

        $data['page_menu'] = 'referensi';
        $data['current'] = 'menu_kelurahan';
        $data['apps']    = $this->apps_model->get_active_only();

        $this->load->view('vkelurahan', $data);
    }

    function grid()
    {
        $this->load->library('Datatables');
        $this->datatables->select("ROWIDTOCHAR(KEL.ROWID) AS ID, KEL.KD_PROPINSI, KEL.KD_DATI2, 
                                    KEL.KD_KECAMATAN||'.'||KEL.KD_KELURAHAN AS KODE, NM_KELURAHAN AS KELURAHANNM, 
                                    NM_KECAMATAN AS KECAMATANNM", false);
        $this->datatables->from('REF_KELURAHAN KEL');
        $this->datatables->join('REF_KECAMATAN KEC', 'KEL.KD_KECAMATAN = KEC.KD_KECAMATAN AND KEL.KD_DATI2 = KEC.KD_DATI2 AND KEL.KD_PROPINSI = KEC.KD_PROPINSI');
        $this->datatables->where('KEL.KD_PROPINSI', pad_propinsi_id());
        $this->datatables->where('KEL.KD_DATI2', pad_kabupaten_id());
        // $this->datatables->checkbox_column('4');
        echo $this->datatables->generate();
    }

    private function fvalidation($jenis_kelurahan = null)
    {
        $this->form_validation->set_error_delimiters('<span>', '</span>');
        $this->form_validation->set_rules('kelurahankd','Kode','required|trim|min_length[3]|max_length[3]');
        $this->form_validation->set_rules('kelurahannm','Nama','required|trim|max_length[50]');
        $this->form_validation->set_rules('kecamatan_id','Kecamatan','required|numeric');

        $this->form_validation->set_rules('kelurahankd','Kode Duplicate','required|callback_cek_uniqkey['."uniqkey".']');
    }

    private function fpost()
    {
        $data['id'] = $this->input->post('id');
        $data['kelurahankd'] = $this->input->post('kelurahankd');
        $data['kelurahannm'] = $this->input->post('kelurahannm');
        $data['kecamatan_id'] = $this->input->post('kecamatan_id');
        $data['tmt'] = $this->input->post('tmt');
        $data['enabled'] = $this->input->post('enabled');

        return $data;
    }

    function cek_uniqkey ($value, $field) {

        // $kd_sewa_va  = "1";
        $id          = $this->input->post('id');
        $kelurahankd  = $this->input->post('kelurahankd');
        $kec_id = $this->input->post('kecamatan_id');
        if(empty($id)) {$id ="0";}
        //
        if($this->kelurahan_model->cek_uniq_key($id, $kelurahankd, $kec_id)) {
            $this->form_validation->set_message('cek_uniqkey','Kode tsb sudah ada.....!');
            return false;
        }
        else{return true;}
    }

    public function add()
    {
        if (!$this->module_auth->create) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_create);
            redirect(active_module_url('kelurahan'));
        }

        $post_data  = $this->fpost();

        $this->fvalidation();
        if ($this->form_validation->run() == TRUE) {
            $input_post = $post_data;
            $update_data = array(
                'KD_PROPINSI' => pad_propinsi_id(),
                'KD_DATI2' => pad_kabupaten_id(),
                'KD_KELURAHAN' => empty($input_post['kelurahankd']) ? NULL : $input_post['kelurahankd'],
                'NM_KELURAHAN' => empty($input_post['kelurahannm']) ? NULL : $input_post['kelurahannm'],
                'KD_KECAMATAN' => empty($input_post['kecamatan_id']) ? NULL : $input_post['kecamatan_id'],
            );
            $result = $this->kelurahan_model->insert_data($update_data);
            if(!empty($result)){
                set_msg_db_error($result);
            }else{
             $this->session->set_flashdata('msg_success', 'Data telah disimpan');
            redirect(active_module_url('kelurahan'));  
            }
            
        }

        $select_data = $this->load->model('kecamatan_model')->get_select();
        $options     = array();
        foreach ($select_data as $row) {
            $options[$row->KD_KECAMATAN] = $row->NM_KECAMATAN;
        }
        $js                        = 'id="kecamatan_id" class="input select2 form-control" required ';
        $data['select_kecamatan'] = form_dropdown('kecamatan_id', $options, $post_data['kecamatan_id'], $js);
        $data['page_menu'] = 'referensi';
        $data['current'] = 'menu_kelurahan';
        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = active_module_url('kelurahan/add');
        $data['dt'] = $post_data;
        // $data['dt']['enabled'] = $post_data['enabled'] == 1 ? 'checked' : '';
        $data['dt']['kd_propinsi'] = pad_propinsi_id();
        $data['dt']['kd_dati2'] = pad_kabupaten_id();
        
        $this->load->view('vkelurahan_form', $data);
    }

    public function edit()
    {
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
            redirect(active_module_url('kelurahan'));
        }

        // $p_id = $this->uri->segment(4);
        $p_id = $this->input->get('id');

        $data['page_menu'] = 'referensi';
        $data['current'] = 'menu_kelurahan';
        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = active_module_url("kelurahan/update/{$p_id}");

        if ($p_id && $get = $this->kelurahan_model->get($p_id)) {
            $data['dt']['id'] = empty($get->ID) ? NULL : $get->ID;
            $data['dt']['kelurahankd'] = empty($get->KD_KELURAHAN) ? NULL : $get->KD_KELURAHAN;
            $data['dt']['kelurahannm'] = empty($get->NM_KELURAHAN) ? NULL : $get->NM_KELURAHAN;
            $data['dt']['kecamatan_id'] = empty($get->KD_KECAMATAN) ? NULL : $get->KD_KECAMATAN;
            $data['dt']['kd_propinsi'] = get_string($get->KD_PROPINSI);
            $data['dt']['kd_dati2']    = get_string($get->KD_DATI2);
            // $data['dt']['enabled'] = $get->enabled == 1 ? 'checked' : '';

            $select_data = $this->load->model('kecamatan_model')->get_select();
            $options     = array();
            foreach ($select_data as $row) {
                $options[$row->KD_KECAMATAN] = $row->NM_KECAMATAN;
            }
            $js                        = 'id="kecamatan_id" class="input select2 form-control" required ';
            $data['select_kecamatan'] = form_dropdown('kecamatan_id', $options, $get->KD_KECAMATAN, $js);

            $this->load->view('vkelurahan_form', $data);
        } else {
            show_404();
        }
    }

    public function update()
    {
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
            redirect(active_module_url('kelurahan'));
        }

        $p_id       = $this->uri->segment(4);
        $post_data = $this->fpost();

        $data['page_menu'] = 'referensi';
        $data['current'] = 'menu_kelurahan';
        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = active_module_url("kelurahan/update/{$p_id}");

        $this->fvalidation();
        if ($this->form_validation->run() == TRUE) {
            $input_post  = $post_data;
            $update_data = array(
                'KD_KELURAHAN' => empty($input_post['kelurahankd']) ? NULL : $input_post['kelurahankd'],
                'NM_KELURAHAN' => empty($input_post['kelurahannm']) ? NULL : $input_post['kelurahannm'],
                'KD_KECAMATAN' => empty($input_post['kecamatan_id']) ? NULL : $input_post['kecamatan_id'],
                // 'enabled' => empty($input_post['enabled']) ? 0 : 1,
            );

            $result = $this->kelurahan_model->update_data($p_id, $update_data);
            if(!empty($result)){
                set_msg_db_error($result);
            }else{
            $this->session->set_flashdata('msg_success', 'Data telah disimpan');
            redirect(active_module_url('kelurahan'));
            }
            
        }

        $get = (object)$post_data;
        $select_data = $this->load->model('kecamatan_model')->get_select();
        $options     = array();
        foreach ($select_data as $row) {
            $options[$row->KD_KECAMATAN] = $row->NM_KECAMATAN;
        }
        $js                        = 'id="kecamatan_id" class="form-control" required ';
        $data['select_kecamatan'] = form_dropdown('kecamatan_id', $options, $get->kecamatan_id, $js);

        $data['dt'] = $post_data;
        $data['dt']['enabled'] = $post_data['enabled'] == 1 ? 'checked' : '';

        $this->load->view('vkelurahan_form', $data);
    }

    public function delete()
    {
        if (!$this->module_auth->delete) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_delete);
            redirect(active_module_url('kelurahan'));
        }

        $id = $this->uri->segment(4);
        if ($id && $this->kelurahan_model->get($id)) {
            $result = $this->kelurahan_model->delete_data($id);
            if(!empty($result)){
                set_msg_db_error($result);
            }else{
               $this->session->set_flashdata('msg_success', 'Data telah dihapus');
            redirect(active_module_url('kelurahan')); 
            }
            
        } else {
            show_404();
        }
    }

}
