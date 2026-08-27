<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class lampiran_pelayanan extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!is_login()) {
            echo "<script>window.location.replace('" . base_url() . "');</script>";
            exit;
        }

        $module = 'menu_lampiran_pelayanan';
        $this->load->library('module_auth', array(
            'module' => $module
        ));

        $this->load->model(array(
            'apps_model', 'lampiran_pelayanan_model'
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
        $data['current'] = 'menu_lampiran_pelayanan';
        $data['apps']    = $this->apps_model->get_active_only();

        $this->load->view('vlampiran_pelayanan', $data);
    }

    function grid(){

        //$prop = sipkd_kd_propinsi();
        //log_message('info', "BBBBBBBBBB CREATE MODULE : " .$prop );
        $this->load->library('Datatables');
        $this->datatables->select("KD_JNS_PELAYANAN as ID, KD_JNS_PELAYANAN, NM_JENIS_PELAYANAN");
        $this->datatables->from("REF_JNS_PELAYANAN");
        echo $this->datatables->generate();

    }

    function grid_lamp(){

        $kd_jns_ply = $this->uri->segment(4);
        $sub_ply = $this->uri->segment(5);

        $this->load->library('Datatables');
        $this->datatables->select("RL.ID, RL.NM_FIELD, RL.NM_LAMPIRAN, RL.STS_LAMPIRAN");
        $this->datatables->from("REF_LAMPIRAN_PLY RL");
        $this->datatables->where('RL.KD_JNS_PELAYANAN', $kd_jns_ply);

        if ($sub_ply) {
            $this->datatables->where('RL.KD_SUB_PELAYANAN', $sub_ply);
        }

        echo $this->datatables->generate();

    }

    private function fvalidation()
    {
        $this->form_validation->set_error_delimiters('<span>', '</span>');
        $this->form_validation->set_rules('kd_jns_pelayanan','Kode Jenis Pelayanan','required|trim|max_length[2]|min_length[2]');
        $this->form_validation->set_rules('nm_field','Nama Field','required|trim|max_length[20]');
        $this->form_validation->set_rules('nm_lampiran','Nama Lampiran','required|max_length[50]');
        $this->form_validation->set_rules('sts_lampiran','Status','required|max_length[1]');    //// mandatory or not
    }

    private function fpost(){

        $data['id'] = $this->input->post('id');
        $data['kd_jns_pelayanan'] = post_string($this->input->post('kd_jns_pelayanan'));
        $data['nm_field']    = post_string($this->input->post('nm_field'));
        $data['nm_lampiran'] = post_string($this->input->post('nm_lampiran'));
        $data['sts_lampiran'] = post_string($this->input->post('sts_lampiran'));
        $data['sub_ply'] = post_string($this->input->post('sub_ply'));
        return $data;
    }

    public function edit(){

        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
            redirect(active_module_url('lampiran_pelayanan'));
        }

        $p_id = $this->uri->segment(4);
        $rowid = $p_id;

        $data['page_menu'] = 'referensi';
        $data['current'] = 'menu_lampiran_pelayanan';
        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = active_module_url("lampiran_pelayanan/update/{$p_id}");

        if ($p_id && $get = $this->lampiran_pelayanan_model->get_jns_ply($p_id)) {

            // $data['dt']['id'] = $get->ID;
            $data['dt']['kd_jns_pelayanan'] = get_string($get->KD_JNS_PELAYANAN);
            $data['dt']['nm_pelayanan'] = get_string($get->NM_JENIS_PELAYANAN);
            // $data['dt']['nm_field']    = get_string($get->NM_FIELD);
            // $data['dt']['nm_lampiran'] = get_string($get->NM_LAMPIRAN);
            // $data['dt']['sts_lampiran'] = $get->STS_LAMPIRAN;

            $jns_ply_insub = array('08', '03');

            if(in_array($get->KD_JNS_PELAYANAN, $jns_ply_insub)) {

                //////////////////////////////////////////////////////////////////////////////////////////////////////
                $select_data = $this->lampiran_pelayanan_model->get_select_sub($get->KD_JNS_PELAYANAN);
                $options     = array();
                if($select_data) {
                    foreach ($select_data as $row) {
                        $options[$row->KD_SUB] = $row->NM_SUB;
                    }
                }
                $js                       = 'id="sub_ply" class="input select2 form-control" onChange="f_chg_sub(this.value)" ';
                $data['select_sub_ply'] = form_dropdown('sub_ply', $options, '', $js);
                //////////////////////////////////////////////////////////////////////////////////////////////////////

                $this->load->view('vlampiran_pelayanan_sub_form', $data);
            } else {
                $this->load->view('vlampiran_pelayanan_form', $data);
            }
            
        } 
        else {
            show_404();
        }
    }

    public function update($id) {
        //// buat balikin ke menu awal ajah.. gak ada action disini wkwkwk
        $this->session->set_flashdata('msg_success', 'Update Data Berhasil.');
        redirect(active_module_url('lampiran_pelayanan'));
    }

    public function insert_lampiran() {
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
            redirect(active_module_url('lampiran_pelayanan'));
        }

        // Set validation rules
        $this->form_validation->set_rules('nm_field', 'Field', 'required');
        $this->form_validation->set_rules('nm_lampiran', 'Nama Lampiran', 'required');
        $this->form_validation->set_rules('kd_jns_pelayanan_m', 'Kode Jenis Pelayanan', 'required');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 'error', 'message' => validation_errors()]);
            return;
        }

        $nm_field = strtoupper(trim($this->input->post('nm_field')));
        $nm_lampiran = $this->input->post('nm_lampiran');
        $kd_jns_pelayanan = trim($this->input->post('kd_jns_pelayanan_m'));

        // 🔎 Cek duplikasi NM_FIELD (case-insensitive)
        $this->db->where('UPPER(NM_FIELD)', $nm_field);
        $this->db->where('KD_JNS_PELAYANAN', $kd_jns_pelayanan);
        $exists = $this->db->get('REF_LAMPIRAN_PLY')->num_rows();

        if ($exists > 0) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Nama Field yang dipilih sudah ada untuk jenis pelayanan ini.'
            ]);
            return;
        }

        // Get POST data
        $data = [
            'NM_FIELD' => $nm_field,
            'NM_LAMPIRAN' => $nm_lampiran,
            'STS_LAMPIRAN' => $this->input->post('sts_lampiran') ? 1 : 0,  // Checkbox: 1 if checked, 0 otherwise
            'KD_JNS_PELAYANAN' => $kd_jns_pelayanan
        ];

        // Insert into Oracle table
        if ($this->db->insert('REF_LAMPIRAN_PLY', $data)) {
            echo json_encode(['status' => 'success', 'message' => 'Data inserted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to insert data']);
        }
    }

    public function insert_lampiran_sub() {
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
            redirect(active_module_url('lampiran_pelayanan'));
        }

        // Set validation rules
        $this->form_validation->set_rules('nm_field', 'Field', 'required');
        $this->form_validation->set_rules('nm_lampiran', 'Nama Lampiran', 'required');
        $this->form_validation->set_rules('kd_jns_pelayanan_m', 'Kode Jenis Pelayanan', 'required');
        $this->form_validation->set_rules('sub_jns_pelayanan_m', 'Sub Jenis Pelayanan', 'required');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 'error', 'message' => validation_errors()]);
            return;
        }

        $nm_field = strtoupper(trim($this->input->post('nm_field')));
        $nm_lampiran = $this->input->post('nm_lampiran');
        $kd_jns_pelayanan = trim($this->input->post('kd_jns_pelayanan_m'));
        $sub_jns_pelayanan = trim($this->input->post('sub_jns_pelayanan_m'));

        // 🔎 Cek duplikasi NM_FIELD (case-insensitive)
        $this->db->where('UPPER(NM_FIELD)', $nm_field);
        $this->db->where('KD_JNS_PELAYANAN', $kd_jns_pelayanan);
        $this->db->where('KD_SUB_PELAYANAN', $sub_jns_pelayanan);
        $exists = $this->db->get('REF_LAMPIRAN_PLY')->num_rows();

        if ($exists > 0) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Nama Field yang dipilih sudah ada untuk jenis dan sub pelayanan ini.'
            ]);
            return;
        }

        // Get POST data
        $data = [
            'NM_FIELD' => $nm_field,
            'NM_LAMPIRAN' => $nm_lampiran,
            'STS_LAMPIRAN' => $this->input->post('sts_lampiran') ? 1 : 0,  // Checkbox: 1 if checked, 0 otherwise
            'KD_JNS_PELAYANAN' => $kd_jns_pelayanan,
            'KD_SUB_PELAYANAN' => $sub_jns_pelayanan,
        ];

        // Insert into Oracle table
        if ($this->db->insert('REF_LAMPIRAN_PLY', $data)) {
            echo json_encode(['status' => 'success', 'message' => 'Data inserted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to insert data']);
        }
    }

    public function update_lampiran() {
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
            redirect(active_module_url('lampiran_pelayanan'));
        }

        $this->form_validation->set_rules('id', 'ID', 'required|integer');
        $this->form_validation->set_rules('column', 'Kolom', 'required');
        $this->form_validation->set_rules('value', 'Nilai', 'required');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 'error', 'message' => validation_errors()]);
            return;
        }

        // Dapatkan data POST
        $id = $this->input->post('id');
        $column = $this->input->post('column'); 
        $value = $this->input->post('value');

        // Pastikan kolom yang diizinkan (untuk keamanan)
        $allowed_columns = ['NM_LAMPIRAN', 'NM_FIELD'];  // Tambahkan kolom lain jika perlu
        if (!in_array($column, $allowed_columns)) {
            echo json_encode(['status' => 'error', 'message' => 'Kolom tidak diizinkan']);
            return;
        }

        // Update database
        $this->db->where('ID', $id);  // Asumsikan kolom ID adalah 'id' (sesuaikan dengan skema tabel Anda)
        if ($this->db->update('REF_LAMPIRAN_PLY', [$column => $value])) {
            echo json_encode(['status' => 'success', 'message' => 'Data diperbarui']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui data']);
        }
    }

    public function update_status() {
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
            redirect(active_module_url('lampiran_pelayanan'));
        }
      
        $this->form_validation->set_rules('id', 'ID', 'required|integer');
        $this->form_validation->set_rules('sts_lampiran', 'Status Lampiran', 'required|in_list[0,1]');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 'error', 'message' => validation_errors()]);
            return;
        }

        $id = $this->input->post('id');
        $sts_lampiran = $this->input->post('sts_lampiran');

        // Update database
        $this->db->where('ID', $id); 
        if ($this->db->update('REF_LAMPIRAN_PLY', ['STS_LAMPIRAN' => $sts_lampiran])) {
            echo json_encode(['status' => 'success', 'message' => 'Status diperbarui']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui status']);
        }
    }

    public function delete_detail_lamp() {
        if (!$this->module_auth->delete) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
            redirect(active_module_url('lampiran_pelayanan'));
        }
      
        $this->form_validation->set_rules('id', 'ID', 'required|integer');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 'error', 'message' => validation_errors()]);
            return;
        }

        $id = $this->input->post('id');

        // Update database
        $this->db->where('ID', $id); 
        if ($this->db->delete('REF_LAMPIRAN_PLY')) {
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil dihapus']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus data']);
        }
    }



}


