<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class check_bphtb extends CI_Controller {

    private $controller = 'check_bphtb';

    public function __construct() {
        parent::__construct();
        if (!is_login()) {
            echo "<script>window.location.replace('" . base_url() . "');</script>";
            exit;
        }

        $module = 'check_bphtb';
        $this->load->library('module_auth', array(
            'module' => $module
        ));

        $this->load->model(array(
            'apps_model', 
        ));

        $this->load->helper(active_module());
    }

    public function index() {
        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect('eadm_depok');
        }

        $data['page_menu'] = 'check_bphtb';
        $data['current'] = '';
        $data['apps']    = $this->apps_model->get_active_only();
        
        $this->load->view('vcheck_bphtb', $data);
    }

    public function grid() {
        $nop   = $this->input->get('nop');
        

        $this->load->library('Datatables_bphtb');
        $this->datatables_bphtb->select("ISNULL(CONVERT(VARCHAR(15), tgl_booking, 105), '-') as tgl_booking, 
                                    kd_ppat+th_booking+no_booking as no_booking,
                                    nop_dt1+nop_dt2+nop_camat+nop_lurah+nop_blok+nop_urut+nop_kode as nop,
                                    nama_wp+'<br>'+alamat_wp+' RT/RW '+rtrw_wp+'<br>'+lurah_wp+'<br>'+camat_wp+'<br>'+kota_wp+' '+kodepos+'<br>'+npwp_wp as subjek_pajak,
                                    alamat_op+' RT/RW '+rtrw_op+'<br>'+lurah_op+'<br>'+camat_op+'<br>'+kota_op as objek_pajak,
                                    'Luas Tanah: ' + CAST(luas_tanah AS VARCHAR(50)) + ' | NJOP: ' + CAST(njop_tanah AS VARCHAR(50)) + 
                                    ' | Nilai: ' + CAST(nil_tanah AS VARCHAR(50)) + 
                                    '<br>' + 
                                    'Luas Bng: ' + CAST(luas_bang AS VARCHAR(50)) + ' | NJOP: ' + CAST(njop_bang AS VARCHAR(50)) + 
                                    ' | Nilai: ' + CAST(nilai_bang AS VARCHAR(50)) + 
                                    '<br>' + 
                                    'Total NJOP: ' + CAST(njop_pbb AS VARCHAR(50)) AS nilai,
                                    'Tgl Setor: '+ISNULL(CONVERT(VARCHAR(15), tanggal, 105), '-')+
                                    '<br>Kd Bayar: '+kd_bayar+
                                    '<br>Nilai Setor: '+nil_setor as setor, 
                                    Status,
                                    'Tgl Terima: ' + ISNULL(CONVERT(VARCHAR(15), tgl_terima_berkas, 105), '-') +
                                    '<br>Tgl Retreive: ' + ISNULL(CONVERT(VARCHAR(15), tgl_retrieve, 105), '-') +
                                    '<br>Tgl Validasi: ' + ISNULL(CONVERT(VARCHAR(15), tgl_validasi, 105), '-') +
                                    '<br>Tgl Serah: ' + ISNULL(CONVERT(VARCHAR(15), tgl_diserahkan, 105), '-') +
                                    '<br>Tgl Apr BPN: ' + ISNULL(CONVERT(VARCHAR(15), tgl_approve_bpn, 105), '-') +
                                    '<br>Tgl Slsai: ' + ISNULL(CONVERT(VARCHAR(15), tgl_selesai_bpn, 105), '-') AS tgl,
                                    keterangan",
                                  false);
        $this->datatables_bphtb->from('bookppat');

        if(!empty($nop)){
            $nop     = str_replace(".", "", $nop);
            $nop     = str_replace("-", "", $nop);
            $kd_prop = substr($nop, 0, 2);
            $kd_dati = substr($nop, 2, 2);
            $kd_kec  = substr($nop, 4, 3);
            $kd_kel  = substr($nop, 7, 3);
            $kd_blok = substr($nop, 10, 3);
            $no_urut = substr($nop, 13, 4);
            $kd_jns_op = substr($nop, 17, 1);

            $this->datatables_bphtb->where("nop_dt1", $kd_prop);
            $this->datatables_bphtb->where("nop_dt2", $kd_dati);
            $this->datatables_bphtb->where("nop_camat", $kd_kec);
            $this->datatables_bphtb->where("nop_lurah", $kd_kel);
            $this->datatables_bphtb->where("nop_blok", $kd_blok);
            $this->datatables_bphtb->where("nop_urut", $no_urut);
            $this->datatables_bphtb->where("nop_kode", $kd_jns_op);
        }

        echo $this->datatables_bphtb->generate();
    }


}