<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class cek_pembayaran_virtual_acc extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!is_login()) {
            echo "<script>window.location.replace('" . base_url() . "');</script>";
            exit;
        }

        $module = 'cek_pembayaran_virtual_acc';
        $this->load->library('module_auth', array(
            'module' => $module
        ));

        $this->load->model(array(
            'apps_model'
        ));

        $this->load->helper(active_module());
    }

    public function index() {
        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect('tool_pbb');
        }

        $data['page_menu'] = 'cek_pembayaran_virtual_acc';
        $data['current'] = '';
        $data['apps']    = $this->apps_model->get_active_only();

        $this->load->view('vcek_pembayaran_virtual_acc', $data);
    }

    public function grid() {
        $this->db = $this->load->database('va', TRUE);
        $this->load->library('Datatables_pgs');
        $this->datatables_pgs->select("i.id, i.va, i.inv_no, i.bjb_customer_name, i.paid_on, i.tax_base, i.fine, i.amount, c.name as product_name", false);
        $this->datatables_pgs->from("bjbva.invoice i", false);
        $this->datatables_pgs->join("bjbva.clients c", "c.id = i.client_id", false);
        $this->datatables_pgs->where("i.status", '1');
        $this->datatables_pgs->order_by("i.id", 'desc');

        $this->datatables_pgs->rupiah_column('5,6,7');

        echo $this->datatables_pgs->generate();
    }

    // public function test_query() {
    //     $this->db = $this->load->database('va', TRUE);
    //     echo $this->db->database . ' @ ' . $this->db->hostname . '<br>';
    //     $query = $this->db->query("SELECT COUNT(*) as total FROM bjb_va.invoice");
    //     echo "<pre>"; print_r($query->result()); echo "</pre>";
    // }

}
