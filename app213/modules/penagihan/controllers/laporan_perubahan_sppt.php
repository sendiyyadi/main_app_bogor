<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_perubahan_sppt extends CI_Controller
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

    private $controller = 'laporan_perubahan_sppt';
    public function __construct()
    {
        parent::__construct();
        if (!is_login()) {
            echo "<script>window.location.replace('" . base_url() . "');</script>";
            exit;
        }

        $module = 'laporan_perubahan_sppt';
        $this->load->library('module_auth', array(
            'module' => $module
        ));

        $this->load->model(array(
            'apps_model'
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
        			if($kec_id == '') $kec_id = $row->KD_KECAMATAN;
        			$options[$row->KD_KECAMATAN] = $row->NM_KECAMATAN;
        		}}
        		$js                       = 'id="KD_KEC" class="form-control" onChange="get_kelurahan(this.value);" required ';
        		$data['select_kecamatan'] = form_dropdown('KD_KEC', $options, '', $js);
            //------------------------------------------------------------------
        		$select_data = $this->MPerubahan_sppt->get_select_kelurahan($kec_id);
        		$options     = array();
        		if($select_data) {
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

        $data['page_menu']  = 'laporan_perubahan_sppt';
        $data['current']    = '';
        $data['controller'] = $this->controller;
        $data['apps']       = $this->apps_model->get_active_only();

        $this->load->view('v_laporan_perubahan_sppt', $data);
    }


    function get_kelurahan() {
          $kd_kec    = $this->uri->segment(4);
  		      //if ($kec_id != 99999){
          $kelurahan = $this->MPerubahan_sppt->get_select_kelurahan($kd_kec);
          echo json_encode($kelurahan);
  		      //}
      }


}
