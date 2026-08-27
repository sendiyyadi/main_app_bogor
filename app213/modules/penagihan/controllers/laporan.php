<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class laporan extends CI_Controller
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

    private $controller = 'laporan';
    public function __construct()
    {
        parent::__construct();
        if (!is_login()) {
            echo "<script>window.location.replace('" . base_url() . "');</script>";
            exit;
        }

        $module = 'laporan';
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
            $select_data  = $this->MSppt_bermasalah->get_select_kecamatan();
        		$options      = array();
        		$kec_id = '';
        		if($select_data) {
        		foreach ($select_data as $row) {
              $options['999999'] = 'SEMUA KECAMATAN';
        			if($kec_id == '') $kec_id = $row->KD_KECAMATAN;
        			$options[$row->KD_KECAMATAN] = $row->NM_KECAMATAN;
        		}}
        		$js                       = 'id="KD_KEC" class="form-control" onChange="get_kelurahan(this.value);" required ';
        		$data['select_kecamatan'] = form_dropdown('KD_KEC', $options, '999999', $js);
            //------------------------------------------------------------------
        		$select_data = $this->MSppt_bermasalah->get_select_kelurahan($kec_id);
        		$options     = array();
        		if($select_data) {
              $options['999999'] = 'SEMUA KELURAHAN';
        		foreach ($select_data as $row) {
        			$options[$row->KD_KELURAHAN] = $row->NM_KELURAHAN;
        		}}
        		$js                       = 'id="KD_KEL" class="form-control" required ';
        		$data['select_kelurahan'] = form_dropdown('KD_KEL', $options, '999999', $js);
          //   //------------------------------------------------------------------
          $options     = array();
          $options['9'] = 'SEMUA STATUS';
          $options['1'] = 'APROVE';
          $options['2'] = 'TOLAK';

          $js                       = 'id="STS" class="form-control" required ';
          $data['select_status'] = form_dropdown('STS', $options, '9', $js);

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

          $data['page_menu']  = 'laporan';
          $data['current']    = '';
          $data['controller'] = $this->controller;
          $data['apps']       = $this->apps_model->get_active_only();

        $this->load->view('v_laporan', $data);
    }

    public function detail(){

        $nop = $this->uri->segment(4);
        $thn = $this->uri->segment(5);
        $kec = $this->uri->segment(6);
        $kel = $this->uri->segment(7);

        $data['faction'] = '';

        if ($get = $this->MSppt_bermasalah->get_detail($nop, $thn, $kec, $kel)) {
          // $data['dt']['id'] = empty($get->ID) ? NULL : $get->ID;
          $nopthn = $get->NOP_2.' - '.$get->THN_PAJAK_SPPT;
          $link = URL_API_DISTRIBUSI.'gambar/spptbaru/'.$get->FOTO_SPPT_BARU;

          $data['dt']['nop'] = $nopthn;
          $data['dt']['tahun_sppt'] = empty($get->THN_PAJAK_SPPT) ? NULL : $get->THN_PAJAK_SPPT;
          $data['dt']['nama_wp'] = empty($get->NM_WP_SPPT) ? NULL : $get->NM_WP_SPPT;
          $data['dt']['kecamatan'] = empty($get->KOTA_WP_SPPT) ? NULL : $get->KOTA_WP_SPPT;
          $data['dt']['kelurahan'] = empty($get->KELURAHAN_WP_SPPT) ? NULL : $get->KELURAHAN_WP_SPPT;
          $data['dt']['tgl_penyerahan'] = empty($get->TGL_TERIMA_SPPT) ? NULL : $get->TGL_TERIMA_SPPT;
          $data['dt']['loginname'] = empty($get->LOGINNAME) ? NULL : $get->LOGINNAME;
          $data['dt']['foto'] = empty($get->FOTO_SPPT_BARU) ? NULL : $get->FOTO_SPPT_BARU;
          $data['dt']['link_foto'] = $link;

          $data['page_menu']  = 'laporan';
          $data['current']    = '';
          $data['controller'] = $this->controller;
          $data['apps']       = $this->apps_model->get_active_only();

          $this->load->view('v_laporan_detail', $data);
          // $this->load->view('v_perubahan_sppt', $data);
        } else {
          show_404();
        }
    }


    function get_kelurahan() {
          $kd_kec    = $this->uri->segment(4);
  		//if ($kec_id != 99999){
          $kelurahan = $this->MSppt_bermasalah->get_select_kelurahan($kd_kec);
          echo json_encode($kelurahan);
  		//}
      }


}
