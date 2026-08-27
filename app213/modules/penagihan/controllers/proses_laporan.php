<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class proses_laporan extends CI_Controller
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

    private $controller = 'proses_laporan';
    public function __construct()
    {
        parent::__construct();
        if (!is_login()) {
            echo "<script>window.location.replace('" . base_url() . "');</script>";
            exit;
        }

        $module = 'proses_laporan';
        $this->load->library('module_auth', array(
            'module' => $module
        ));

        $this->load->model(array(
            'apps_model'
        ));

        $this->load->helper(active_module());
        $this->load->model('proses_laporan_model', 'MProses_laporan');
    }

    public function index() {

        $pawal_nop  = '';
        $pawal_ptgs = '';
        $pawal_tg_fr = '';
        $pawal_tg_to = '';
        $pawal_thn  = date('Y');
        $pawal_sts  = 9;
        $pawal_kec  = 999999;
        $pawal_kel  = 999999;
        $psts_verif = 9;

        $dt_back_proslap = $this->session->flashdata('dt_back_proslap');
        if(!empty($dt_back_proslap)){
          if($dt_back_proslap->mode == 'back_approve'){
            $pawal_nop    = $dt_back_proslap->pawal_nop;
            $pawal_thn    = $dt_back_proslap->pawal_thn;
            $pawal_sts    = $dt_back_proslap->pawal_sts;
            $pawal_kec    = $dt_back_proslap->pawal_kec;
            $pawal_kel    = $dt_back_proslap->pawal_kel;
            $pawal_ptgs   = $dt_back_proslap->pawal_ptgs;
            $pawal_tg_fr  = $dt_back_proslap->pawal_tg_fr;
            $pawal_tg_to  = $dt_back_proslap->pawal_tg_to;
            $psts_verif   = $dt_back_proslap->psts_verif;
          }
        }

        $mode = $this->input->get('mode');
        if ($mode == 'back'){
          $pawal_nop  = $this->input->get('pawal_nop');
          $pawal_ptgs = $this->input->get('pawal_ptgs');
          $pawal_tg_fr = $this->input->get('pawal_tg_fr');
          $pawal_tg_to = $this->input->get('pawal_tg_to');
          $pawal_thn  = $this->input->get('pawal_thn');
          $pawal_kec  = $this->input->get('pawal_kec');
          $pawal_kel  = $this->input->get('pawal_kel');
          $pawal_sts  = $this->input->get('pawal_sts');
          $psts_verif = $this->input->get('psts_verif');
        }

        //------------------------------------------------------------------
        $select_data  = $this->MProses_laporan->get_select_kecamatan();
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
        $kelurahan = $this->MProses_laporan->get_select_kelurahan($kec_id);
    		$select_data = $this->MProses_laporan->get_select_kelurahan($pawal_kec);
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
        $options['9'] = 'SEMUA STS VERIF';
        $options['0'] = 'DRAFT';
        $options['1'] = 'APPROVE';
        $options['2'] = 'TOLAK';

    		$js                       = 'id="STS" class="form-control" style="width:150px" required ';
    		$data['select_status'] = form_dropdown('STS', $options, $pawal_sts, $js);
        //------------------------------------------------------------------
        $options_ver     = array();
        $options_ver['9'] = 'SEMUA STS SPPT';
        $options_ver['8'] = 'DRAFT (BLM DISERAHKAN)';
        $options_ver['1'] = 'BATAL NOP SPPT';
        $options_ver['2'] = 'SPPT TIDAK TERSAMPAIKAN';
        $options_ver['3'] = 'BATAL NOP STP';
        $options_ver['4'] = 'SPPT TERSAMPAIKAN';

    		$js                       = 'id="STS_VER" class="form-control" style="width:150px" required ';
    		$data['select_status_verif'] = form_dropdown('STS_VER', $options_ver, $psts_verif, $js);
        //------------------------------------------------------------------

        $data['c_nop'] = $pawal_nop;
        $data['c_thn'] = $pawal_thn;
        $data['c_ptgs'] = $pawal_ptgs;
        $data['c_tg_fr'] = $pawal_tg_fr;
        $data['c_tg_to'] = $pawal_tg_to;

        $data['page_menu']  = 'proses_laporan';
        $data['current']    = '';
        $data['controller'] = $this->controller;
        $data['apps']       = $this->apps_model->get_active_only();

        $this->load->view('v_proses_laporan', $data);
    }

    function xxx() {
      $dtnya = $this->session->flashdata('dt_back_tolak');
      print_r($dtnya->mode);
      die();
    }

    function grid()
    {
        // header('Content-Type: application/json');
        // echo $this->MProses_laporan->getUserds();

      // echo 'runing';
      // die();

        $nop         = $this->input->get('nop');
        $thn         = $this->input->get('thn');
        $kec         = $this->input->get('kec');
        $kel         = $this->input->get('kel');
        $sts         = $this->input->get('sts');
        $ptgs        = $this->input->get('ptgs');
        $tgl_fr      = $this->input->get('tgl_fr');
        $tgl_to      = $this->input->get('tgl_to');
        $sts_verif   = $this->input->get('sts_verif');

        // $options['9'] = 'SEMUA STS VERIF';
        // $options['0'] = 'DRAFT';
        // $options['1'] = 'APPROVE';
        // $options['2'] = 'TOLAK';

        // $options_ver['9'] = 'SEMUA STS SPPT';
        // $options_ver['0'] = 'DRAFT (BLM DISERAHKAN)';
        // $options_ver['1'] = 'BATAL NOP SPPT';
        // $options_ver['2'] = 'SPPT TIDAK TERSAMPAIKAN';
        // $options_ver['3'] = 'BATAL NOP STP';
        // $options_ver['4'] = 'SPPT TERSAMPAIKAN';

        // WHEN STATUS_BATAL_NOP = 0 THEN 'Draft (blm diserahkan)

        $this->load->library('Datatables');
        $this->datatables->select("T1.NOP||T1.THN_PAJAK_SPPT AS NOP, T1.NOP as CHK, T1.NOP_2, KEC.NM_KECAMATAN, KEL.NM_KELURAHAN, 
                                   T1.THN_PAJAK_SPPT, T1.LOGINNAME, T1.TGL_TERIMA_SPPT, 
                                   CASE WHEN STA_VERIF = 1 THEN 'Approve' WHEN STA_VERIF = 2 THEN 'Tolak' ELSE 'Draft' END AS ST_VER,
                                   CASE WHEN STATUS_BATAL_NOP = 0 THEN 'Draft (blm diserahkan)'
                                   WHEN STATUS_BATAL_NOP = 1 THEN 'Batal NOP SPPT'
                                   WHEN STATUS_BATAL_NOP = 2 THEN 'SPPT tdk tersampaikan'
                                   WHEN STATUS_BATAL_NOP = 3 THEN 'Batal NOP STP'
                                   WHEN STATUS_BATAL_NOP = 4 THEN 'SPPT tersampaikan'
                                   ELSE 'Draft (blm disampaikan)' END AS ST_SPPT,
                                   T1.STA_VERIF,
                                   T1.NOP||T1.THN_PAJAK_SPPT AS NOP_ACTION, T1.STATUS_BATAL_NOP, 
                                   BN.FILENAME_1, T1.FOTO_SPPT_BARU", false);
        $this->datatables->from('DT_V_TTSPPT12D T1');
        $this->datatables->join('BATAL_NOP BN', 'T1.NOP = BN.NOP AND T1.THN_PAJAK_SPPT = BN.THN AND BN.STATUS <> 3', 'LEFT');
        $this->datatables->join('REF_KECAMATAN KEC', 'T1.KD_KECAMATAN = KEC.KD_KECAMATAN', '');
        $this->datatables->join('REF_KELURAHAN KEL', 'T1.KD_KELURAHAN = KEL.KD_KELURAHAN and T1.KD_KECAMATAN = KEL.KD_KECAMATAN', '');
        $this->datatables->where('T1.TGL_TERIMA_SPPT IS NOT NULL');
        // $this->datatables->where('T1.LOGINNAME IS NOT NULL');
        // $this->datatables->where('T1.KETERANGAN IS NOT NULL');
        $this->datatables->where('(T1.LOGINNAME IS NOT NULL OR T1.KETERANGAN IS NOT NULL)');

        if(!empty($nop)){
            $nop = trim($nop);
            $nop = strtoupper($nop);
            $nop = str_replace('.', '', $nop);
            $nop = str_replace(' ', '', $nop);
            $nop = str_replace('-', '', $nop);
            $this->datatables->where("trim(UPPER(T1.NOP)) like ('%".$nop."%')");
        }

        if(!empty($ptgs)){
            $ptgs = trim($ptgs);
            $ptgs = strtoupper($ptgs);
            $this->datatables->where("trim(UPPER(T1.LOGINNAME)) like ('%".$ptgs."%')");
        }

        if(!empty($tgl_fr) && !empty($tgl_to)){
          // $tgfr = 
          $this->datatables->where("TO_DATE(TO_CHAR(T1.TGL_TERIMA_SPPT,'yyyy-mm-dd'), 'yyyy-mm-dd') BETWEEN TO_DATE('".$tgl_fr."', 'dd-mm-yyyy') AND TO_DATE('".$tgl_to."', 'dd-mm-yyyy')");
        }

        if(!empty($thn)){
            $this->datatables->where("trim(T1.THN_PAJAK_SPPT) = '".$thn."' ");
        } else {
            $thn_now = date('Y');
            $this->datatables->where("trim(".THN_PJK_SPPT_DSP.") = '".$thn_now."' ");
        }

        if($kec <> '999999' && !empty($kec)){
          $this->datatables->where("trim(T1.KD_KECAMATAN) = '".$kec."' ");
        }

        if($kel <> '999999' && !empty($kel)){
          $this->datatables->where("trim(T1.KD_KELURAHAN) = '".$kel."' ");
        }
        
        if($sts <> '9' && !empty($sts)){
          if($sts == '0'){
            $this->datatables->where('T1.STA_VERIF IS NULL');
          } else {
            $this->datatables->where('T1.STA_VERIF', $sts);
          }
        }

        if ($sts_verif !== '9' && !empty($sts_verif)) {
          if($sts_verif == '8'){
            $this->datatables->where('T1.STATUS_BATAL_NOP', '0');
          }else{
          $this->datatables->where('T1.STATUS_BATAL_NOP', $sts_verif);
          }
        }

        // echo $this->db->last_query();
        // die();
        $this->datatables->date_column('7');
        echo $this->datatables->generate();

    }

    public function terima() {
      $p_id = $this->uri->segment(4);

      if ($p_id && $get = $this->MProses_laporan->get_dt_komplit_by_nopthn($p_id)) {
        $prs = $this->MProses_laporan->proses_terima($p_id);
        if ($prs) {
          $this->session->set_flashdata('msg_success', 'Data telah diproses Terima');
        } else {
          $this->session->set_flashdata('msg_success', 'Data gagal diproses Terima');
        }
      } else {
        show_404();
      }

      //// back to editan sebelumnya
      $pawal_nop  = $this->input->get('prm_awal_nop');
      $pawal_thn  = $this->input->get('prm_awal_thn');
      $pawal_kec  = $this->input->get('prm_awal_kec');
      $pawal_kel  = $this->input->get('prm_awal_kel');
      $pawal_sts  = $this->input->get('prm_awal_sts');
      $psts_verif = $this->input->get('prm_awal_sts_verif');
      $pawal_ptgs = $this->input->get('prm_awal_ptgs');
      $pawal_tg_fr= $this->input->get('prm_awal_tgl_fr');
      $pawal_tg_to= $this->input->get('prm_awal_tgl_to');
      $data_awal = new \stdClass();
      $data_awal->mode = "back_approve";
      $data_awal->pawal_nop   = $pawal_nop;
      $data_awal->pawal_thn   = $pawal_thn;
      $data_awal->pawal_kec   = $pawal_kec;
      $data_awal->pawal_kel   = $pawal_kel;
      $data_awal->pawal_sts   = $pawal_sts;
      $data_awal->psts_verif  = $psts_verif;
      $data_awal->pawal_ptgs  = $pawal_ptgs;
      $data_awal->pawal_tg_fr = $pawal_tg_fr;
      $data_awal->pawal_tg_to = $pawal_tg_to;
      $this->session->set_flashdata('dt_back_proslap',$data_awal);

      redirect(active_module_url($this->controller));
  }

  public function tolak() {
    $p_id = $this->uri->segment(4);

    if ($p_id && $get = $this->MProses_laporan->get_dt_komplit_by_nopthn($p_id)) {
      $prs = $this->MProses_laporan->proses_tolak($p_id);
      if ($prs) {
        $this->session->set_flashdata('msg_success', 'Data telah diproses Tolak');
      } else {
        $this->session->set_flashdata('msg_success', 'Data gagal diproses Tolak');
      }
    } else {
      show_404();
    }

    //// back to editan sebelumnya
    $pawal_nop  = $this->input->get('prm_awal_nop');
    $pawal_thn  = $this->input->get('prm_awal_thn');
    $pawal_kec  = $this->input->get('prm_awal_kec');
    $pawal_kel  = $this->input->get('prm_awal_kel');
    $pawal_sts  = $this->input->get('prm_awal_sts');
    $psts_verif = $this->input->get('prm_awal_sts_verif');
    $pawal_ptgs = $this->input->get('prm_awal_ptgs');
    $pawal_tg_fr= $this->input->get('prm_awal_tgl_fr');
    $pawal_tg_to= $this->input->get('prm_awal_tgl_to');
    $data_awal = new \stdClass();
    $data_awal->mode = "back_approve";
    $data_awal->pawal_nop   = $pawal_nop;
    $data_awal->pawal_thn   = $pawal_thn;
    $data_awal->pawal_kec   = $pawal_kec;
    $data_awal->pawal_kel   = $pawal_kel;
    $data_awal->pawal_sts   = $pawal_sts;
    $data_awal->psts_verif  = $psts_verif;
    $data_awal->pawal_ptgs  = $pawal_ptgs;
    $data_awal->pawal_tg_fr = $pawal_tg_fr;
    $data_awal->pawal_tg_to = $pawal_tg_to;
    $this->session->set_flashdata('dt_back_proslap',$data_awal);

    redirect(active_module_url($this->controller));
}

  public function terima_sim() {
        $nop_all = $this->input->post('id_prf_terima');
        $nop = explode(",",$nop_all);
        // echo json_encode($nop); die();
        $not_sts4 = 0;
        $fail_paraf = 0;
        for ($i=0; $i < count($nop); $i++) { 
            $nop_id = $nop[$i];
            // echo $nop_id; die();
            if ($nop_id && $data = $this->MProses_laporan->get_by_nopthn($nop_id)) {
                // echo $data->STSVER; die();
                if ($data->STSVER == '0') {
                    $this->MProses_laporan->proses_terima($nop_id);
                } else {
                    $not_sts4 += 1;
                }
            } else {
                $fail_paraf += 1;
            }
        }
        if($not_sts4 > 0 || $fail_paraf > 0){
            $not_sts4_msg = $not_sts4 > 0 ? 'Jenis dokumen bukan Draft : '.$not_sts4.' data' : '';
            $failparaf_msg = $fail_paraf > 0 ? 'Data Gagal Proses Terima : '.$fail_paraf.' data' : '';
           $this->session->set_flashdata('msg_warning', "Data Gagal diproses Terima. {$not_sts4_msg}; {$failparaf_msg}");
        }else{
             $this->session->set_flashdata('msg_success', 'Data telah diproses Terima');
            
        }

        //// back to editan sebelumnya
        $pawal_nop  = $this->input->post('prm_awal_nop_trm');
        $pawal_thn  = $this->input->post('prm_awal_thn_trm');
        $pawal_kec  = $this->input->post('prm_awal_kec_trm');
        $pawal_kel  = $this->input->post('prm_awal_kel_trm');
        $pawal_sts  = $this->input->post('prm_awal_sts_trm');
        $pawal_ptgs = $this->input->post('prm_awal_ptgs_trm');
        $pawal_tg_fr= $this->input->post('prm_awal_tgl_fr_trm');
        $pawal_tg_to= $this->input->post('prm_awal_tgl_to_trm');
        $psts_verif = $this->input->post('prm_awal_sts_verif_trm');
        $data_awal = new \stdClass();
        $data_awal->mode = "back_approve";
        $data_awal->pawal_nop   = $pawal_nop;
        $data_awal->pawal_thn   = $pawal_thn;
        $data_awal->pawal_kec   = $pawal_kec;
        $data_awal->pawal_kel   = $pawal_kel;
        $data_awal->pawal_sts   = $pawal_sts;
        $data_awal->pawal_ptgs  = $pawal_ptgs;
        $data_awal->pawal_tg_fr = $pawal_tg_fr;
        $data_awal->pawal_tg_to = $pawal_tg_to;
        $data_awal->psts_verif  = $psts_verif;
        $this->session->set_flashdata('dt_back_proslap',$data_awal);

        redirect(active_module_url($this->controller));
  }

  public function tolak_sim() {
      $nop_all = $this->input->post('id_prf_tolak');
      $nop = explode(",",$nop_all);
      $not_sts4 = 0;
      $fail_paraf = 0;
      for ($i=0; $i < count($nop); $i++) { 
          $nop_id = $nop[$i];
          if ($nop_id && $data = $this->MProses_laporan->get_by_nopthn($nop_id)) {
          if ($data->STSVER == '0') {
              $this->MProses_laporan->proses_tolak($nop_id);
          } else {
              $not_sts4 += 1;
          }
      } else {
          $fail_paraf += 1;
      }
      }
      if($not_sts4 > 0 || $fail_paraf > 0){
          $not_sts4_msg = $not_sts4 > 0 ? 'Jenis dokumen bukan Draft : '.$not_sts4.' data' : '';
          $failparaf_msg = $fail_paraf > 0 ? 'Data Gagal Proses Tolak : '.$fail_paraf.' data' : '';
         $this->session->set_flashdata('msg_success', "Data Gagal diproses Tolak. {$not_sts4_msg}; {$failparaf_msg}");
      }else{
           $this->session->set_flashdata('msg_success', 'Data telah diproses Tolak');
          
      }

      //// back to editan sebelumnya
      $pawal_nop  = $this->input->post('prm_awal_nop_tlk');
      $pawal_thn  = $this->input->post('prm_awal_thn_tlk');
      $pawal_kec  = $this->input->post('prm_awal_kec_tlk');
      $pawal_kel  = $this->input->post('prm_awal_kel_tlk');
      $pawal_sts  = $this->input->post('prm_awal_sts_tlk');
      $pawal_ptgs = $this->input->post('prm_awal_ptgs_tlk');
      $pawal_tg_fr= $this->input->post('prm_awal_tgl_fr_tlk');
      $pawal_tg_to= $this->input->post('prm_awal_tgl_to_tlk');
      $psts_verif = $this->input->post('prm_awal_sts_verif_tlk');
      $data_awal = new \stdClass();
      $data_awal->mode = "back_approve";
      $data_awal->pawal_nop   = $pawal_nop;
      $data_awal->pawal_thn   = $pawal_thn;
      $data_awal->pawal_kec   = $pawal_kec;
      $data_awal->pawal_kel   = $pawal_kel;
      $data_awal->pawal_sts   = $pawal_sts;
      $data_awal->pawal_ptgs  = $pawal_ptgs;
      $data_awal->pawal_tg_fr = $pawal_tg_fr;
      $data_awal->pawal_tg_to = $pawal_tg_to;
      $data_awal->psts_verif  = $psts_verif;
      $this->session->set_flashdata('dt_back_proslap',$data_awal);

      redirect(active_module_url($this->controller));
  }

  public function detail(){

      $p_id = $this->uri->segment(4);
      // $p_id = $this->input->get('id');

      $pawal_nop         = $this->input->get('pawal_nop');
      $pawal_thn         = $this->input->get('pawal_thn');
      $pawal_ptgs        = $this->input->get('pawal_ptgs');
      $pawal_tgl_fr      = $this->input->get('pawal_tgl_fr');
      $pawal_tgl_to      = $this->input->get('pawal_tgl_to');
      $pawal_kec         = $this->input->get('pawal_kec');
      $pawal_kel         = $this->input->get('pawal_kel');
      $pawal_sts         = $this->input->get('pawal_sts');
      $psts_verif        = $this->input->get('pawal_sts_ver');

      $data['faction'] = '';

      if ($p_id && $get = $this->MProses_laporan->get_dt_komplit_by_nopthn($p_id)) {
        $data['dt']['nop'] = empty($get->NOP_2) ? NULL : $get->NOP_2 . ' - ' . $get->THN_PAJAK_SPPT;
        $data['dt']['nama_wp'] = empty($get->NM_WP_SPPT) ? NULL : $get->NM_WP_SPPT;
        $data['dt']['kecamatan'] = empty($get->NM_KECAMATAN) ? NULL : $get->NM_KECAMATAN;
        $data['dt']['kelurahan'] = empty($get->NM_KELURAHAN) ? NULL : $get->NM_KELURAHAN;
        $data['dt']['tgl_penyerahan'] = empty($get->TGL_TERIMA_SPPT) ? NULL : $get->TGL_TERIMA_SPPT;
        $data['dt']['user_penyerahan'] = empty($get->LOGINNAME) ? NULL : $get->LOGINNAME;
        $data['dt']['txt_ket'] = empty($get->TXT_KETERANGAN) ? NULL : $get->TXT_KETERANGAN;

        // if ($get->STATUS_BATAL_NOP == 1 ){
        if ($get->STATUS_BATAL_NOP == 1 || $get->STATUS_BATAL_NOP == 2 || $get->STATUS_BATAL_NOP == 3){
          $get_btl = $this->MProses_laporan->get_dt_btl($p_id);
          $data['dt']['file'] = empty($get_btl->FILENAME_1) ? NULL : $get_btl->FILENAME_1;
          $file = $get_btl->FILENAME_1;
        } else {
          $data['dt']['file'] = empty($get->FOTO_SPPT_BARU) ? NULL : $get->FOTO_SPPT_BARU;
          $file = $get->FOTO_SPPT_BARU;
        }
        
        if (empty($file)) {
          $link = '01';
        } else {
          if ($get->STATUS_BATAL_NOP == 1 || $get->STATUS_BATAL_NOP == 2 || $get->STATUS_BATAL_NOP == 3){
            $cek_url = URL_API_ANDROID.'pembatalan/'.$file;
          } else {
            $cek_url = URL_API_DISTRIBUSI.'gambar/spptbaru/'.$file;
          }
          
          $ch = curl_init($cek_url);
          curl_setopt($ch, CURLOPT_NOBODY, true);
          curl_exec($ch);
          $returncode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

          if ($returncode == 200) {
              $link = $cek_url;
          } else {
              $link = '02';
          } 
        }
        
        $data['dt']['link_foto'] = $link;

        $data['dt']['prm_awal_nop'] = $pawal_nop;
        $data['dt']['prm_awal_kec'] = $pawal_kec;
        $data['dt']['prm_awal_kel'] = $pawal_kel;
        $data['dt']['prm_awal_sts'] = $pawal_sts;
        $data['dt']['prm_awal_thn'] = $pawal_thn;
        $data['dt']['prm_awal_ptgs'] = $pawal_ptgs;
        $data['dt']['prm_awal_tgl_fr'] = $pawal_tgl_fr;
        $data['dt']['prm_awal_tgl_to'] = $pawal_tgl_to;
        $data['dt']['prm_awal_sts_verif'] = $psts_verif;
        
        $data['page_menu']  = 'proses_laporan';
        $data['current']    = '';
        $data['controller'] = $this->controller;
        $data['apps']       = $this->apps_model->get_active_only();

        $this->load->view('v_proses_laporan_form', $data);
        // $this->load->view('v_proses_laporan', $data);
      } else {
        show_404();
      }
  }


  function get_kelurahan() {
      $kec_id    = $this->uri->segment(4);
      $kelurahan = $this->MProses_laporan->get_select_kelurahan($kec_id);
      echo json_encode($kelurahan);
  }

}
