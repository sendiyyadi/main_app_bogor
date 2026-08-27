<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class lap_distribusi extends CI_Controller
{
    private $controller = 'lap_distribusi';
    public function __construct()
    {
        parent::__construct();
        if (!is_login()) {
            echo "<script>window.location.replace('" . base_url() . "');</script>";
            exit;
        }

        $module = 'lap_distribusi';
        $this->load->library('module_auth', array(
            'module' => $module
        ));

        $this->load->model(array(
            'apps_model', 'lap_distribusi_model'
        ));

        $this->load->helper(active_module());
        $this->load->model('perubahan_sppt_model', 'MPerubahan_sppt');
    }

    public function index()
    {
        //------------------------------------------------------------------
            $select_data  = $this->MPerubahan_sppt->get_select_kecamatan();
        		$options      = array();
        		$kec_id = '';
        		if($select_data) {
        		foreach ($select_data as $row) {
                    $options['999999'] = 'SEMUA KECAMATAN';
        			if($kec_id == '') $kec_id = $row->KD_KECAMATAN;
        			$options[$row->KD_KECAMATAN] = $row->NM_KECAMATAN;
        		}}
        		$js                       = 'id="KD_KEC" class="form-control" onChange="get_kelurahan(this.value);" required ';
        		$data['select_kecamatan'] = form_dropdown('KD_KEC', $options, '', $js);
            //------------------------------------------------------------------
        		$select_data = $this->MPerubahan_sppt->get_select_kelurahan($kec_id);
        		$options     = array();
        		if($select_data) {
                $options['999999'] = 'SEMUA KELURAHAN';
        		foreach ($select_data as $row) {
        			$options[$row->KD_KELURAHAN] = $row->NM_KELURAHAN;
        		}}
        		$js                       = 'id="KD_KEL" class="form-control" required ';
        		$data['select_kelurahan'] = form_dropdown('KD_KEL', $options, '', $js);
            //------------------------------------------------------------------
            $options     = array();
            $options['1'] = 'Sudah Approve';
        		$options['0'] = 'Belum Approve';
        		$js                       = 'id="STS" class="form-control" required ';
        		$data['select_sts'] = form_dropdown('STS', $options, '', $js);
        //   //------------------------------------------------------------------

        $data['page_menu']  = 'lap_distribusi';
        $data['current']    = '';
        $data['controller'] = $this->controller;
        $data['apps']       = $this->apps_model->get_active_only();

        $this->load->view('v_lap_distribusi', $data);
    }


    function get_kelurahan() {
          $kd_kec    = $this->uri->segment(4);
  		      //if ($kec_id != 99999){
          $kelurahan = $this->MPerubahan_sppt->get_select_kelurahan($kd_kec);
          echo json_encode($kelurahan);
  		      //}
    }

    function exp_excel_csv() {
        $kd_kec = $this->input->get('kd_kec');
        $kd_kel = $this->input->get('kd_kel');
        $c_thn = $this->input->get('c_thn');
        // $c_nop = $this->input->get('c_nop');
        $filex    = $this->input->get('filex');

        if (empty($c_thn)) {
            $c_thn = "2024";
        }

        // if (empty($kd_kec)) {
        //     $kd_kec = "0";
        // }

        // if (empty($kd_kel)) {
        //     $kd_kel = "0";
        // }

        // if (empty($c_nop)) {
        //     $c_nop = "0";
        // }

        $query = $this->lap_distribusi_model->query_cetak_real($kd_kec, $kd_kel, $c_thn);

        //var_dump($query);die;

        $params = array(
            'query' => $query,
        );

        $rpt  = 'rpt_lap_distribusi';
        $type = $filex; //'xls';

        $jasper = $this->load->library('Jasper_ora');
        
        echo $jasper->export($rpt, $params, $type, TRUE);

    }

}
