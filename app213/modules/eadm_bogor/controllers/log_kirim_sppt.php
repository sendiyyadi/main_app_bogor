<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class log_kirim_sppt extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!is_login()) {
            echo "<script>window.location.replace('" . base_url() . "');</script>";
            exit;
        }

        $module = 'log_kirim_sppt';
        $this->load->library('module_auth', array(
            'module' => $module
        ));

        $this->load->model(array(
            'apps_model'
        ));

        $this->load->helper(active_module());
    }

    public function index()
    {
        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect('eadm_bogor');
        }

        $data['page_menu'] = 'log_kirim_sppt';
        $data['current'] = 'log_kirim_sppt';
        $data['apps']    = $this->apps_model->get_active_only();
        
        $this->load->view('vlog_kirim_sppt', $data);
    }

    public function grid()
    {

        // $status = $this->input->get('status');
        $tahun = $this->input->get('tahun');
        $nop = $this->input->get('nop');
        $nop = trim(str_replace(['.', '-'], '', $nop));

        $this->load->library('Datatables');
        $this->datatables->select("NIK, NOP, TAHUN, EMAIL, STATUS, TGL_KIRIM", false);
        $this->datatables->from("LOG_EMAIL_SPPT");
    
        if(!empty($nop)){
            $this->datatables->where("NOP",$nop);
        }
        if(!empty($tahun)){
            $this->datatables->where("TAHUN",$tahun);
        }
        // if(!empty($jns_ply) && $jns_ply != '9999'){
        //     $this->datatables->where("PL.KD_JNS_PELAYANAN",$jns_ply);
        // }

        echo $this->datatables->generate();
    }
}
