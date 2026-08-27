<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class perubahan_sppt extends CI_Controller
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
    //     $this->load->model('MPerubahan_sppt');
    // }

    private $controller = 'perubahan_sppt';
    public function __construct()
    {
        parent::__construct();
        if (!is_login()) {
            echo "<script>window.location.replace('" . base_url() . "');</script>";
            exit;
        }

        $module = 'perubahan_sppt';
        $this->load->library('module_auth', array(
            'module' => $module
        ));

        $this->load->model(array(
            'apps_model'
        ));

        $this->load->helper(active_module());
        $this->load->model('perubahan_sppt_model', 'MPerubahan_sppt');
    }

    public function index() {

        $pawal_nop  = '';
        $pawal_thn  = '';
        $pawal_sts  = 9;
        $pawal_kec  = 999999;
        $pawal_kel  = 999999;

        $dt_back_tolak = $this->session->flashdata('dt_back_tolak');
        if(!empty($dt_back_tolak)){
          if($dt_back_tolak->mode == 'back_tolak'){
            $pawal_nop  = $dt_back_tolak->pawal_nop;
            $pawal_thn  = $dt_back_tolak->pawal_thn;
            $pawal_sts  = $dt_back_tolak->pawal_sts;
            $pawal_kec  = $dt_back_tolak->pawal_kec;
            $pawal_kel  = $dt_back_tolak->pawal_kel;
          }
        }

        $dt_back_approve = $this->session->flashdata('dt_back_approve');
        if(!empty($dt_back_approve)){
          if($dt_back_approve->mode == 'back_approve'){
            $pawal_nop  = $dt_back_approve->pawal_nop;
            $pawal_thn  = $dt_back_approve->pawal_thn;
            $pawal_sts  = $dt_back_approve->pawal_sts;
            $pawal_kec  = $dt_back_approve->pawal_kec;
            $pawal_kel  = $dt_back_approve->pawal_kel;
          }
        }

        $mode              = $this->input->get('mode');
        if ($mode == 'back'){
          $pawal_nop  = $this->input->get('pawal_nop');
          $pawal_thn  = $this->input->get('pawal_thn');
          $pawal_kec  = $this->input->get('pawal_kec');
          $pawal_kel  = $this->input->get('pawal_kel');
          $pawal_sts  = $this->input->get('pawal_sts');
        }

        //------------------------------------------------------------------
        $select_data  = $this->MPerubahan_sppt->get_select_kecamatan();
    		$options      = array();
    		$kec_id = '';
    		if($select_data) {
            $options['999999'] = 'SEMUA KECAMATAN';
    		foreach ($select_data as $row) {
    			if($kec_id == '') $kec_id = $row->KD_KECAMATAN;
    			$options[$row->KD_KECAMATAN] = $row->NM_KECAMATAN;
    		}}
    		$js                       = 'id="KD_KEC" class="form-control" onChange="get_kelurahan(this.value);" required ';
    		$data['select_kecamatan'] = form_dropdown('KD_KEC', $options, $pawal_kec, $js);
        //------------------------------------------------------------------
        $kelurahan = $this->MPerubahan_sppt->get_select_kelurahan($kec_id);
    		$select_data = $this->MPerubahan_sppt->get_select_kelurahan($pawal_kec);
    		$options     = array();
            $options['999999'] = 'SEMUA KELURAHAN';
    		if($select_data) {
    		foreach ($select_data as $row) {
    			$options[$row->KD_KELURAHAN] = $row->NM_KELURAHAN;
    		}}
    		$js                       = 'id="KD_KEL" class="form-control" required ';
    		$data['select_kelurahan'] = form_dropdown('KD_KEL', $options, $pawal_kel, $js);
        //------------------------------------------------------------------
    		$options     = array();
        $options['9'] = 'SEMUA';
        $options['0'] = 'DRAFT';
        $options['1'] = 'APPROVE';
        $options['2'] = 'TOLAK';

    		$js                       = 'id="STS" class="form-control" style="width:150px" required ';
    		$data['select_status'] = form_dropdown('STS', $options, $pawal_sts, $js);
        //------------------------------------------------------------------

        $data['c_nop'] = $pawal_nop;
        $data['c_thn'] = $pawal_thn;

        $data['page_menu']  = 'perubahan_sppt';
        $data['current']    = '';
        $data['controller'] = $this->controller;
        $data['apps']       = $this->apps_model->get_active_only();

        $this->load->view('v_perubahan_sppt', $data);
    }

    function xxx() {
      $dtnya = $this->session->flashdata('dt_back_tolak');
      print_r($dtnya->mode);
      die();
    }

    function grid()
    {
        // header('Content-Type: application/json');
        // echo $this->MPerubahan_sppt->getUserds();

        $nop         = $this->input->get('nop');
        $thn         = $this->input->get('thn');
        $kec         = $this->input->get('kec');
        $kel         = $this->input->get('kel');
        $sts         = $this->input->get('sts');

        $this->load->library('Datatables');
        // $this->datatables->select("LOGINNAME,PASSWOD,NAMA,EMAIL,NIP,USER_GROUP,KD_KEC,KD_KEL",false);
        // $this->datatables->from('M02USERS_DS');
        $this->datatables->select(ID_DSP.",".NOP_DSP.",".THN_PJK_SPPT_DSP.",".NM_KECAMATAN.",".NM_KELURAHAN.",".
        // $this->datatables->select(ID_DSP.','.NOP_DSP.','.THN_PJK_SPPT_DSP.','.KECAMATAN_OP_NM_OLD_DSP.','.KELURAHAN_OP_NM_OLD_DSP.','.
                                LOGINNAME_DSP.",".APPROVED_BY_DSP.",
                                CASE WHEN ".STATUS_DSP."=0 THEN 'Draft' WHEN ".STATUS_DSP."=1 THEN 'Approve' WHEN ".STATUS_DSP."=2 THEN 'Tolak'
                                ELSE '-' END as STATUS
                                ", false);
        $this->datatables->from(TBL_DSPSPPT);
        $this->datatables->join('DT_V_TTSPPT12D T1', 'T1.NOP = DS_PERUBAHAN_OPWP.NOP AND T1.THN_PAJAK_SPPT = DS_PERUBAHAN_OPWP.THN_PAJAK_SPPT', '');
        // $this->datatables->join('DT_V_TTSPPT12D T1', 'T1.NOP = DS_PERUBAHAN_OPWP.NOP ', 'left');
        // $this->datatables->join(TBL_REF_KECAMATAN, KECAMATAN_OP_NM_OLD_DSP.' = '.NM_KECAMATAN, 'left');
        $this->datatables->join(TBL_REF_KECAMATAN, 'T1.KD_KECAMATAN = '.KD_KECAMATAN_KEC, 'left');
        $this->datatables->join(TBL_REF_KELURAHAN, 'T1.KD_KELURAHAN = '.KD_KELURAHAN.' and T1.KD_KECAMATAN = '.KD_KECAMATAN_KEL, 'left');
        // $this->datatables->where(M02USER_GROUP.' in (6,7,8) ');
        //$this->datatables->join('REF_INSTANSI_DEPOK D1','D1.KD_INSTANSI=PT.KD_INSTANSI','left');
        //$this->datatables->join('REF_JABATAN D2','D2.KD_JABATAN=PT.KD_JABATAN','left');

        if(!empty($nop)){
            $nop = trim($nop);
            $nop = strtoupper($nop);
            $this->datatables->where("trim(UPPER(".NOP_DSP.")) like ('%".$nop."%')");
        }

        if(!empty($thn)){
            $this->datatables->where("trim(".THN_PJK_SPPT_DSP.") = '".$thn."' ");
          }

        if($kec <> '999999' && !empty($kec)){
          $this->datatables->where("trim(T1.KD_KECAMATAN) = '".$kec."' ");
        }

        if($kel <> '999999' && !empty($kec)){
          $this->datatables->where("trim(T1.KD_KELURAHAN) = '".$kel."' ");
        }
        if($sts <> '9'){
          $this->datatables->where(STATUS_DSP, $sts);
        }
        // echo $this->db->last_query();
        // die();
        // $this->datatables->checkbox_column('7');
        echo $this->datatables->generate();

    }

    private function fvalidation() {
        $this->form_validation->set_error_delimiters('<span>', '</span>');
        $this->form_validation->set_rules('id', 'ID', 'required');

    }

    private function fpost() {
    		$data[ID_DSP] = $this->input->post('id');
    		$data[NM_WP_SPPT_D] = $this->input->post('nama_wp_a');
    		$data['nama_wp'] = $this->input->post('nama_wp');
    		$data[KECAMATAN_WP_OLD_DSP] = $this->input->post('kec_wp_a');
    		$data[KELURAHAN_WP_NM_OLD_DSP] = $this->input->post('kel_wp_a');
    		$data[RT_WP_OLD_DSP] = $this->input->post('rt_wp_a');
    		$data[RW_WP_OLD_DSP] = $this->input->post('rw_wp_a');
    		$data[JALAN_WP_OLD_DSP] = $this->input->post('alamat_wp_a');

        $data[KECAMATAN_OP_NM_OLD_DSP] = $this->input->post('kec_op_a');
    		$data[KELURAHAN_OP_NM_OLD_DSP] = $this->input->post('kel_op_a');
    		$data[RT_OP_OLD_DSP] = $this->input->post('rt_op_a');
    		$data[RW_OP_OLD_DSP] = $this->input->post('rw_op_a');
    		$data[JALAN_OP_OLD_DSP] = $this->input->post('alamat_op_a');

        $data[KECAMATAN_WP_NM_NEW_DSP] = $this->input->post('kec_wp_b');
    		$data[KELURAHAN_WP_NM_NEW_DSP] = $this->input->post('kel_wp_b');
    		$data[RT_WP_NEW_DSP] = $this->input->post('rt_wp_b');
    		$data[RW_WP_NEW_DSP] = $this->input->post('rw_wp_b');
    		$data[JALAN_WP_NEW_DSP] = $this->input->post('alamat_wp_b');

        $data[KECAMATAN_OP_NM_NEW_DSP] = $this->input->post('kec_op_b');
    		$data[KELURAHAN_OP_NM_NEW_DSP] = $this->input->post('kel_op_b');
    		$data[RT_OP_NEW_DSP] = $this->input->post('rt_op_b');
    		$data[RW_OP_NEW_DSP] = $this->input->post('rw_op_b');
        $data[JALAN_OP_NEW_DSP] = $this->input->post('alamat_op_b');
        $data[STATUS_DSP] = $this->input->post('status');
        $data['prm_awal_kec'] = $this->input->post('prm_awal_kec');
        $data['prm_awal_kel'] = $this->input->post('prm_awal_kel');
        $data['prm_awal_sts'] = $this->input->post('prm_awal_sts');
        $data['prm_awal_nop'] = $this->input->post('prm_awal_nop');
        $data['prm_awal_thn'] = $this->input->post('prm_awal_thn');


        return $data;
    }

    public function detail(){

        $p_id = $this->uri->segment(4);
        // $p_id = $this->input->get('id');

        $pawal_nop         = $this->input->get('pawal_nop');
        $pawal_thn         = $this->input->get('pawal_thn');
        $pawal_kec         = $this->input->get('pawal_kec');
        $pawal_kel         = $this->input->get('pawal_kel');
        $pawal_sts         = $this->input->get('pawal_sts');

        $data['faction'] = active_module_url("Perubahan_sppt/approve/{$p_id}");

        if ($p_id && $get = $this->MPerubahan_sppt->get($p_id)) {
          $data['dt'][ID_DSP] = empty($get->ID) ? NULL : $get->ID;
          $data['dt'][NM_WP_SPPT_D] = $get->NM_WP_SPPT;
          // $data['dt']['nama_wp'] = empty($get->NM_WP_SPPT) ? NULL : $get->NM_WP_SPPT;
          $data['dt'][RT_OP_OLD_DSP] = empty($get->RT_OP_OLD) ? NULL : $get->RT_OP_OLD;
          $data['dt'][RW_OP_OLD_DSP] = empty($get->RW_OP_OLD) ? NULL : $get->RW_OP_OLD;
          $data['dt'][RT_OP_NEW_DSP] = empty($get->RT_OP_NEW) ? NULL : $get->RT_OP_NEW;
          $data['dt'][RW_OP_NEW_DSP] = empty($get->RW_OP_NEW) ? NULL : $get->RW_OP_NEW;
          $data['dt'][RT_WP_OLD_DSP] = empty($get->RT_WP_OLD) ? NULL : $get->RT_WP_OLD;
          $data['dt'][RW_WP_OLD_DSP] = empty($get->RW_WP_OLD) ? NULL : $get->RW_WP_OLD;
          $data['dt'][RT_WP_NEW_DSP] = empty($get->RT_WP_NEW) ? NULL : $get->RT_WP_NEW;
          $data['dt'][RW_WP_NEW_DSP] = empty($get->RW_WP_NEW) ? NULL : $get->RW_WP_NEW;
          $data['dt'][KECAMATAN_OP_NM_OLD_DSP] = empty($get->KECAMATAN_OP_NM_OLD) ? NULL : $get->KECAMATAN_OP_NM_OLD;
          $data['dt'][KELURAHAN_OP_NM_OLD_DSP] = empty($get->KELURAHAN_OP_NM_OLD) ? NULL : $get->KELURAHAN_OP_NM_OLD;
          $data['dt'][KECAMATAN_OP_NM_NEW_DSP] = empty($get->KECAMATAN_OP_NM_NEW) ? NULL : $get->KECAMATAN_OP_NM_NEW;
          $data['dt'][KELURAHAN_OP_NM_NEW_DSP] = empty($get->KELURAHAN_OP_NM_NEW) ? NULL : $get->KELURAHAN_OP_NM_NEW;
          $data['dt'][KECAMATAN_WP_OLD_DSP] = empty($get->KECAMATAN_WP_OLD) ? NULL : $get->KECAMATAN_WP_OLD;
          $data['dt'][KELURAHAN_WP_NM_OLD_DSP] = empty($get->KELURAHAN_WP_NM_OLD) ? NULL : $get->KELURAHAN_WP_NM_OLD;
          $data['dt'][KECAMATAN_WP_NM_NEW_DSP] = empty($get->KECAMATAN_WP_NM_NEW) ? NULL : $get->KECAMATAN_WP_NM_NEW;
          $data['dt'][KELURAHAN_WP_NM_NEW_DSP] = empty($get->KELURAHAN_WP_NM_NEW) ? NULL : $get->KELURAHAN_WP_NM_NEW;
          $data['dt'][JALAN_OP_OLD_DSP] = empty($get->JALAN_OP_OLD) ? NULL : $get->JALAN_OP_OLD;
          $data['dt'][JALAN_OP_NEW_DSP] = empty($get->JALAN_OP_NEW) ? NULL : $get->JALAN_OP_NEW;
          $data['dt'][JALAN_WP_OLD_DSP] = empty($get->JALAN_WP_OLD) ? NULL : $get->JALAN_WP_OLD;
          $data['dt'][JALAN_WP_NEW_DSP] = empty($get->JALAN_WP_NEW) ? NULL : $get->JALAN_WP_NEW;
          $data['dt'][JALAN_WP_NEW_DSP] = empty($get->JALAN_WP_NEW) ? NULL : $get->JALAN_WP_NEW;
          $data['dt'][STATUS_DSP] = empty($get->STATUS) ? NULL : $get->STATUS;

          $data['dt']['prm_awal_nop'] = $pawal_nop;
          $data['dt']['prm_awal_kec'] = $pawal_kec;
          $data['dt']['prm_awal_kel'] = $pawal_kel;
          $data['dt']['prm_awal_sts'] = $pawal_sts;
          $data['dt']['prm_awal_thn'] = $pawal_thn;

          $data['page_menu']  = 'perubahan_sppt';
          $data['current']    = '';
          $data['controller'] = $this->controller;
          $data['apps']       = $this->apps_model->get_active_only();

          $this->load->view('v_perubahan_sppt_form', $data);
          // $this->load->view('v_perubahan_sppt', $data);
        } else {
          show_404();
        }
    }

    public function approve(){

        $p_id      = $this->uri->segment(4);
        $post_data = $this->fpost();

        $data['faction'] = active_module_url("Perubahan_sppt/approve/{$p_id}");

        $this->fvalidation();
        if ($this->form_validation->run() == TRUE) {
          if ($p_id && $get = $this->MPerubahan_sppt->get($p_id)) {
            $input_post  = $post_data;
            $rw_op = $input_post[RW_OP_NEW_DSP];
            $rt_op = $input_post[RT_OP_NEW_DSP];
            $rw_wp = $input_post[RW_WP_NEW_DSP];
            $rt_wp = $input_post[RT_WP_NEW_DSP];
            $nop = $get->NOP;

            $rw_op = trim($rw_op);
            if (strlen($rw_op) == 1) $rw_op = '0'.$rw_op;
            else if (strlen($rw_op) == 2) $rw_op = $rw_op;
            else $rw_op = '000';

            $rt_op = trim($rt_op);
            if (strlen($rt_op) == 1) $rt_op = '00'.$rt_op;
            else if (strlen($rt_op) == 2) $rt_op = '0'.$rt_op;
            else if (strlen($rt_op) == 3) $rt_op = $rt_op;
            else $rt_op = '000';

            $rw_wp = trim($rw_wp);
            if (strlen($rw_wp) == 1) $rw_wp = '0'.$rw_wp;
            else if (strlen($rw_wp) == 2) $rw_wp = $rw_wp;
            else $rw_wp = '000';

            $rt_wp = trim($rt_wp);
            if (strlen($rt_wp) == 1) $rt_wp = '00'.$rt_wp;
            else if (strlen($rt_wp) == 2) $rt_wp = '0'.$rt_wp;
            else if (strlen($rt_wp) == 3) $rt_wp = $rt_wp;
            else $rt_wp = '000';


            $update_dop = array(
              'JALAN_OP' => $input_post[JALAN_OP_NEW_DSP],
              'RW_OP' => $rw_op,
              'RT_OP' => $rt_op,
            );
            $update_dsp = array(
              'JALAN_WP' => $input_post[JALAN_WP_NEW_DSP],
              'RW_WP' => $rw_wp,
              'RT_WP' => $rt_wp,
              'KELURAHAN_WP' => $input_post[KELURAHAN_WP_NM_NEW_DSP],
              'KOTA_WP' => $input_post[KECAMATAN_WP_NM_NEW_DSP],
            );

            // UPDATE DAT_SUBJEK_PAJAK
            $this->MPerubahan_sppt->update_dsp($nop, $update_dsp);
            // UPDATE DAT_OBJEK_PAJAK
            $this->MPerubahan_sppt->update_dop($nop, $update_dop);

            $update_data = array(
              'STATUS' => '1',
              'APPROVED_BY' => $this->session->userdata('nama'),
              // 'TGL_APPROVED' => date('Y-m-d'),
              'TGL_APPROVED' => date('d-m-Y'),
              // 'TGL_APPROVED' => 'SELECT SYSDATE FROM DUAL',
            );

            // $this->MPerubahan_sppt->update($p_id, $update_data);
            $this->MPerubahan_sppt->update_manuwal($p_id);

            $this->session->set_flashdata('msg_success', 'Data telah disimpan');
            // echo $this->db->last_query(); die();
            //// back to editan sebelumnya
            $pawal_nop  = $this->input->post('prm_awal_nop');
            $pawal_thn  = $this->input->post('prm_awal_thn');
            $pawal_kec  = $this->input->post('prm_awal_kec');
            $pawal_kel  = $this->input->post('prm_awal_kel');
            $pawal_sts  = $this->input->post('prm_awal_sts');
            $data_awal = new \stdClass();
            $data_awal->mode = "back_approve";
            $data_awal->pawal_nop = $pawal_nop;
            $data_awal->pawal_thn = $pawal_thn;
            $data_awal->pawal_kec = $pawal_kec;
            $data_awal->pawal_kel = $pawal_kel;
            $data_awal->pawal_sts = $pawal_sts;
            $this->session->set_flashdata('dt_back_approve',$data_awal);

            redirect(active_module_url($this->controller));
          } else {
            show_404();
          }
        }

        $get = $post_data;
        $data['dt'] = $post_data;

        $data['page_menu']  = 'perubahan_sppt';
        $data['current']    = '';
        $data['controller'] = $this->controller;
        $data['apps']       = $this->apps_model->get_active_only();
        $this->load->view('v_perubahan_sppt_form', $data);
    }

    function process_tolak(){
        $id = $this->uri->segment(4);
        $mode       = $this->input->get('mode');
        $pawal_nop  = $this->input->get('pawal_nop');
        $pawal_thn  = $this->input->get('pawal_thn');
        $pawal_kec  = $this->input->get('pawal_kec');
        $pawal_kel  = $this->input->get('pawal_kel');
        $pawal_sts  = $this->input->get('pawal_sts');

        if($id && $get = $this->MPerubahan_sppt->get($id)){
            $this->MPerubahan_sppt->process_tolak($id);

            // $data_awal = new stdObject();
            $data_awal = new stdClass();
            $data_awal->mode = "back_tolak";
            $data_awal->pawal_nop = $pawal_nop;
            $data_awal->pawal_thn = $pawal_thn;
            $data_awal->pawal_kec = $pawal_kec;
            $data_awal->pawal_kel = $pawal_kel;
            $data_awal->pawal_sts = $pawal_sts;

            $this->session->set_flashdata('dt_back_tolak',$data_awal);

            $this->session->set_flashdata('msg_success', 'Data berhasil ditolak');
            redirect(active_module_url($this->controller));
        } else {
            show_404();
        }
    }

    function get_kelurahan() {
        $kec_id    = $this->uri->segment(4);
        $kelurahan = $this->MPerubahan_sppt->get_select_kelurahan($kec_id);
        echo json_encode($kelurahan);
    }

}
