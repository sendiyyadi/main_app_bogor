<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pembatalan_sppt extends CI_Controller
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
    //     $this->load->model('MPembatalan_sppt');
    // }

    private $controller = 'pembatalan_sppt';
    public function __construct()
    {
        parent::__construct();
        if (!is_login()) {
            echo "<script>window.location.replace('" . base_url() . "');</script>";
            exit;
        }

        $module = 'pembatalan_sppt';
        $this->load->library('module_auth', array(
            'module' => $module
        ));

        $this->load->model(array(
            'apps_model'
        ));

        $this->load->helper(active_module());
        $this->load->model('pembatalan_sppt_model', 'MPembatalan_sppt');
    }

    public function index() {

        $pawal_nop  = '';
        $pawal_thn  = date('Y');
        $pawal_sts  = 9;
        $pawal_idp  = 999999;
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
            $pawal_idp  = $dt_back_tolak->pawal_idp;
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
            $pawal_idp  = $dt_back_approve->pawal_idp;
          }
        }

        $mode              = $this->input->get('mode');
        if ($mode == 'back'){
          $pawal_nop  = $this->input->get('pawal_nop');
          $pawal_thn  = $this->input->get('pawal_thn');
          $pawal_kec  = $this->input->get('pawal_kec');
          $pawal_kel  = $this->input->get('pawal_kel');
          $pawal_sts  = $this->input->get('pawal_sts');
          $pawal_idp  = $this->input->get('pawal_idp');
        }

        //------------------------------------------------------------------
        $select_data  = $this->MPembatalan_sppt->get_select_kecamatan();
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
        $kelurahan = $this->MPembatalan_sppt->get_select_kelurahan($kec_id);
    		$select_data = $this->MPembatalan_sppt->get_select_kelurahan($pawal_kec);
    		$options     = array();
            $options['999999'] = 'SEMUA KELURAHAN';
    		if($select_data) {
    		foreach ($select_data as $row) {
    			$options[$row->KD_KELURAHAN] = $row->NM_KELURAHAN;
    		}}
    		$js                       = 'id="KD_KEL" class="form-control" required ';
    		$data['select_kelurahan'] = form_dropdown('KD_KEL', $options, $pawal_kel, $js);
        //------------------------------------------------------------------
        $select_data = $this->MPembatalan_sppt->get_select_id_piutang();
        // var_dump($select_data);die;
        $options     = array();
            $options['999999'] = 'SEMUA ID PIUTANG';
        if($select_data) {
        foreach ($select_data as $row) {
          $options[$row->KD_LOOKUP_ITEM] = $row->NM_LOOKUP_ITEM;
        }}
        $js                       = 'id="id_piutang" class="form-control" required ';
        $data['select_id_piutang'] = form_dropdown('id_piutang', $options, $pawal_idp, $js);
        //------------------------------------------------------------------
    		$options     = array();
        $options['9'] = 'SEMUA';
        $options['1'] = 'BATAL NOP SPPT';
        $options['2'] = 'SPPT TIDAK TERSAMPAIKAN';
        $options['3'] = 'BATAL NOP STP';
        $options['4'] = 'SPPT TERSAMPAIKAN';

    		$js                       = 'id="STS" class="form-control" required ';
    		$data['select_status'] = form_dropdown('STS', $options, $pawal_sts, $js);
        //------------------------------------------------------------------

        $data['c_nop'] = $pawal_nop;
        $data['c_thn'] = $pawal_thn;

        $data['page_menu']  = 'pembatalan_sppt';
        $data['current']    = '';
        $data['controller'] = $this->controller;
        $data['apps']       = $this->apps_model->get_active_only();

        $this->load->view('v_pembatalan_sppt', $data);
    }

    function xxx() {
      $dtnya = $this->session->flashdata('dt_back_tolak');
      print_r($dtnya->mode);
      die();
    }

    function grid()
    {
        // header('Content-Type: application/json');
        // echo $this->MPembatalan_sppt->getUserds();

        $nop         = $this->input->get('nop');
        $thn         = $this->input->get('thn');
        $kec         = $this->input->get('kec');
        $kel         = $this->input->get('kel');
        // $sts         = $this->input->get('sts');
        $idp         = $this->input->get('idp');

        // echo $idp;die;

        $this->load->library('Datatables');
        // $this->datatables->select("LOGINNAME,PASSWOD,NAMA,EMAIL,NIP,USER_GROUP,KD_KEC,KD_KEL",false);
        // $this->datatables->from('M02USERS_DS');
        // $this->datatables->select(ID_DSP.",".NOP_DSP.",".THN_PJK_SPPT_DSP.",".NM_KECAMATAN.",".NM_KELURAHAN.",".
        // // $this->datatables->select(ID_DSP.','.NOP_DSP.','.THN_PJK_SPPT_DSP.','.KECAMATAN_OP_NM_OLD_DSP.','.KELURAHAN_OP_NM_OLD_DSP.','.
        //                         LOGINNAME_DSP.",".APPROVED_BY_DSP.",
        //                         CASE WHEN ".STATUS_DSP."=0 THEN 'Draft' WHEN ".STATUS_DSP."=1 THEN 'Approve' WHEN ".STATUS_DSP."=2 THEN 'Tolak'
        //                         ELSE '-' END as STATUS
        //                         ", false);
        // $this->datatables->from(TBL_DSPSPPT);
        // $this->datatables->join('DT_V_TTSPPT12D T1', 'T1.NOP = DS_PERUBAHAN_OPWP.NOP AND T1.THN_PAJAK_SPPT = DS_PERUBAHAN_OPWP.THN_PAJAK_SPPT', '');
        // // $this->datatables->join('DT_V_TTSPPT12D T1', 'T1.NOP = DS_PERUBAHAN_OPWP.NOP ', 'left');
        // // $this->datatables->join(TBL_REF_KECAMATAN, KECAMATAN_OP_NM_OLD_DSP.' = '.NM_KECAMATAN, 'left');
        // $this->datatables->join(TBL_REF_KECAMATAN, 'T1.KD_KECAMATAN = '.KD_KECAMATAN_KEC, 'left');
        // $this->datatables->join(TBL_REF_KELURAHAN, 'T1.KD_KELURAHAN = '.KD_KELURAHAN.' and T1.KD_KECAMATAN = '.KD_KECAMATAN_KEL, 'left');
        // $this->datatables->where(M02USER_GROUP.' in (6,7,8) ');
        //$this->datatables->join('REF_INSTANSI_DEPOK D1','D1.KD_INSTANSI=PT.KD_INSTANSI','left');
        //$this->datatables->join('REF_JABATAN D2','D2.KD_JABATAN=PT.KD_JABATAN','left');

        // $this->datatables->select("T1.NOP||T1.THN_PAJAK_SPPT AS NOP, T1.NOP as CHK, T1.NOP_2, KEC.NM_KECAMATAN, KEL.NM_KELURAHAN, 
        //                            T1.THN_PAJAK_SPPT, T1.LOGINNAME, T1.STATUS, 
        //                            CASE WHEN ID_PIUTANG = 2 THEN 'Objek Pajak tidak ada' WHEN ID_PIUTANG = 3 THEN 'SPPT Double' WHEN ID_PIUTANG = 4 THEN 'Tidak Jelas / Nama atau Alamat Subjek Pajak' WHEN ID_PIUTANG = 5 THEN 'Subjek Pajak tidak sesuai dengan verlap' WHEN ID_PIUTANG = 6 THEN 'Objek Pajak Di kecualikan' WHEN ID_PIUTANG = 7 THEN 'Objek Pajak Bermasalah / Sengketa' ELSE 'Draft' END AS ST_VER,
        //                            CASE WHEN STATUS_BATAL_NOP = 1 THEN 'Batal NOP SPPT'
        //                            WHEN STATUS_BATAL_NOP = 2 THEN 'SPPT tdk tersampaikan'
        //                            WHEN STATUS_BATAL_NOP = 3 THEN 'Batal NOP STP'
        //                            WHEN STATUS_BATAL_NOP = 4 THEN 'SPPT tersampaikan'
        //                            ELSE 'Draft (blm disampaikan)' END AS ST_SPPT,
        //                            T1.STA_VERIF,
        //                            T1.NOP||T1.THN_PAJAK_SPPT AS NOP_ACTION, T1.STATUS_BATAL_NOP, 
        //                            BN.FILENAME_1, T1.FOTO_SPPT_BARU", false);
        // $this->datatables->from('DT_V_TTSPPT12D T1');
        // $this->datatables->join('BATAL_NOP BN', 'T1.NOP = BN.NOP AND T1.THN_PAJAK_SPPT = BN.THN AND BN.STATUS <> 3', 'LEFT');
        // $this->datatables->join('REF_KECAMATAN KEC', 'T1.KD_KECAMATAN = KEC.KD_KECAMATAN', '');
        // $this->datatables->join('REF_KELURAHAN KEL', 'T1.KD_KELURAHAN = KEL.KD_KELURAHAN and T1.KD_KECAMATAN = KEL.KD_KECAMATAN', '');
        // $this->datatables->where('T1.STATUS IS NULL');

        $this->datatables->select("T1.KD_PROPINSI||T1.KD_DATI2||T1.KD_KECAMATAN||T1.KD_KELURAHAN||T1.KD_BLOK||T1.NO_URUT||T1.KD_JNS_OP||T1.THN_PAJAK_SPPT AS NOPTHN,
        T1.KD_PROPINSI||T1.KD_DATI2||T1.KD_KECAMATAN||T1.KD_KELURAHAN||T1.KD_BLOK||T1.NO_URUT||T1.KD_JNS_OP AS NOP,
        T1.KD_PROPINSI||'.'||T1.KD_DATI2||'.'||T1.KD_KECAMATAN||'.'||T1.KD_KELURAHAN||'.'||T1.KD_BLOK||'.'||T1.NO_URUT||'.'||T1.KD_JNS_OP AS NOP_FORMAT,
        KEC.NM_KECAMATAN, 
        KEL.NM_KELURAHAN,
        T1.THN_PAJAK_SPPT, 
        T1.LOGINNAME, 
        T1.STATUS,
        CASE WHEN T1.ID_PIUTANG = 2 THEN 'Objek Pajak tidak ada' 
        WHEN T1.ID_PIUTANG = 3 THEN 'SPPT Double' 
        WHEN T1.ID_PIUTANG = 4 THEN 'Tidak Jelas / Nama atau Alamat Subjek Pajak' 
        WHEN T1.ID_PIUTANG = 5 THEN 'Subjek Pajak tidak sesuai dengan verlap' 
        WHEN T1.ID_PIUTANG = 6 THEN 'Objek Pajak Di kecualikan' 
        WHEN T1.ID_PIUTANG = 7 THEN 'Objek Pajak Bermasalah / Sengketa' ELSE 'Draft' END AS ST_VER,
        CASE WHEN T1.STATUS_BATAL_NOP = 1 THEN 'Batal NOP SPPT'
        WHEN T1.STATUS_BATAL_NOP = 2 THEN 'SPPT tdk tersampaikan'
        WHEN T1.STATUS_BATAL_NOP = 3 THEN 'Batal NOP STP'
        WHEN T1.STATUS_BATAL_NOP = 4 THEN 'SPPT tersampaikan'
        ELSE 'Draft (blm disampaikan)' END AS ST_SPPT,
        T1.STA_VERIF,
        T1.KD_PROPINSI||T1.KD_DATI2||T1.KD_KECAMATAN||T1.KD_KELURAHAN||T1.KD_BLOK||T1.NO_URUT||T1.KD_JNS_OP||T1.THN_PAJAK_SPPT AS NOP_ACTION, 
        T1.STATUS_BATAL_NOP, 
        T1.FOTO_SPPT_BARU", false);
        $this->datatables->from('TTSPPT12D T1');
        //$this->datatables->join('BATAL_NOP BN', 'T1.KD_PROPINSI = BN.KD_PROPINSI AND T1.KD_DATI2 = BN.KD_DATI2 AND T1.KD_KECAMATAN = BN.KD_KECAMATAN AND T1.KD_KELURAHAN = BN.KD_KELURAHAN AND T1.KD_BLOK = BN.KD_BLOK AND T1.NO_URUT = BN.NO_URUT AND T1.KD_JNS_OP = BN.KD_JNS_OP AND T1.THN_PAJAK_SPPT = BN.THN', 'LEFT');
        $this->datatables->join('REF_KECAMATAN KEC', 'T1.KD_KECAMATAN = KEC.KD_KECAMATAN', '');
        $this->datatables->join('REF_KELURAHAN KEL', 'T1.KD_KELURAHAN = KEL.KD_KELURAHAN and T1.KD_KECAMATAN = KEL.KD_KECAMATAN', '');
        $this->datatables->where('T1.STATUS IS NULL');
        //$this->datatables->where('BN.STATUS <> 3');

        if(!empty($nop)){
            $nop = trim($nop);
            $nop = strtoupper($nop);
            $nop = str_replace('.', '', $nop);
            $nop = str_replace(' ', '', $nop);
            $nop = str_replace('-', '', $nop);
            $this->datatables->where("trim(UPPER(T1.NOP)) like ('%".$nop."%')");
            // $this->datatables->where("trim(UPPER(".NOP_DSP.")) like ('%".$nop."%')");
        }

        if(!empty($thn)){
            // $this->datatables->where("trim(".THN_PJK_SPPT_DSP.") = '".$thn."' ");
            $this->datatables->where("trim(T1.THN_PAJAK_SPPT) = '".$thn."' ");
        }

        if($kec <> '999999' && !empty($kec)){
          $this->datatables->where("trim(T1.KD_KECAMATAN) = '".$kec."' ");
        }

        if($kel <> '999999' && !empty($kec)){
          $this->datatables->where("trim(T1.KD_KELURAHAN) = '".$kel."' ");
        }

        // if($sts <> '9'){
        //   // $this->datatables->where(STATUS_DSP, $sts);
        //   $this->datatables->where('T1.STATUS_BATAL_NOP', $sts_verif);
        // }

        if($idp <> '999999' && !empty($idp)){
          $this->datatables->where("trim(T1.ID_PIUTANG) = '".$idp."'");
        }else{
          $this->datatables->where("trim(T1.ID_PIUTANG) IN ('2','3','4','5','6','7')");
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
        $data['prm_awal_kec'] = $this->input->post('prm_awal_kec');
        $data['prm_awal_kel'] = $this->input->post('prm_awal_kel');
        $data['prm_awal_sts'] = $this->input->post('prm_awal_sts');
        $data['prm_awal_nop'] = $this->input->post('prm_awal_nop');
        $data['prm_awal_thn'] = $this->input->post('prm_awal_thn');
        $data['prm_awal_idp'] = $this->input->post('prm_awal_idp');

        $data['nop'] = $this->input->post('nop');
        $data['nama_wp'] = $this->input->post('nama_wp');
        $data['kecamatan'] = $this->input->post('kecamatan');
        $data['kelurahan'] = $this->input->post('kelurahan');
        $data['tgl_penyerahan'] = $this->input->post('tgl_penyerahan');
        $data['user_penyerahan'] = $this->input->post('user_penyerahan');
        $data['txt_ket'] = $this->input->post('txt_ket');
        $data['idp'] = $this->input->post('idp');

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
        $pawal_idp         = $this->input->get('pawal_idp');


        $data['faction'] = active_module_url("pembatalan_sppt/approve/{$p_id}");

        if ($p_id && $get = $this->MPembatalan_sppt->get_dt_komplit_by_nopthn_real($p_id)) {
            $data['dt']['nop'] = empty($get->KD_PROPINSI) ? NULL : $get->KD_PROPINSI . '.' . $get->KD_DATI2 . '.' . $get->KD_KECAMATAN . '.' . $get->KD_KELURAHAN . '.' . $get->KD_BLOK . '.' . $get->NO_URUT . '.' . $get->KD_JNS_OP . ' - ' . $get->THN_PAJAK_SPPT;
            $data['dt']['nama_wp'] = empty($get->NM_WP_SPPT) ? NULL : $get->NM_WP_SPPT;
            $data['dt']['kecamatan'] = empty($get->NM_KECAMATAN) ? NULL : $get->NM_KECAMATAN;
            $data['dt']['kelurahan'] = empty($get->NM_KELURAHAN) ? NULL : $get->NM_KELURAHAN;
            $data['dt']['tgl_penyerahan'] = empty($get->TGL_TERIMA_SPPT) ? NULL : $get->TGL_TERIMA_SPPT;
            $data['dt']['user_penyerahan'] = empty($get->LOGINNAME) ? NULL : $get->LOGINNAME;
            $data['dt']['txt_ket'] = empty($get->TXT_KETERANGAN) ? NULL : $get->TXT_KETERANGAN;
            $data['dt']['idp'] = empty($get->NM_LOOKUP_ITEM) ? NULL : $get->NM_LOOKUP_ITEM;
            $data['dt']['lampiran'] = empty($get->FOTO_PEMBATALAN) ? NULL : $get->FOTO_PEMBATALAN;  
            if($data['dt']['lampiran']){
                $file = $get->FOTO_PEMBATALAN;
                $cek_url = URL_API_SPPT_NEO_R.'pembatalan/'.$file;
                $ch = curl_init($cek_url);
                curl_setopt($ch, CURLOPT_NOBODY, true);
                curl_exec($ch);
                $returncode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                if ($returncode == 200) {
                    $link = $cek_url;
                } else {
                    $link = '02';
                }
            }else{
                $link = '01';
            }
        
          $data['dt']['link_foto'] = $link;

          $data['dt']['prm_awal_nop'] = $pawal_nop;
          $data['dt']['prm_awal_kec'] = $pawal_kec;
          $data['dt']['prm_awal_kel'] = $pawal_kel;
          $data['dt']['prm_awal_sts'] = $pawal_sts;
          $data['dt']['prm_awal_thn'] = $pawal_thn;
          $data['dt']['prm_awal_idp'] = $pawal_idp;

          $data['page_menu']  = 'pembatalan_sppt';
          $data['current']    = '';
          $data['controller'] = $this->controller;
          $data['apps']       = $this->apps_model->get_active_only();

          $this->load->view('v_pembatalan_sppt_form', $data);
          // $this->load->view('v_pembatalan_sppt', $data);
        } else {
          show_404();
        }
    }

    public function approve(){

        $p_id      = $this->uri->segment(4);
        $nop = substr($p_id, 0, 18);
        $thn = substr($p_id, 18, 4);

        $post_data = $this->fpost();

        $data['faction'] = active_module_url("pembatalan_sppt/approve/{$p_id}");

        // $this->fvalidation();
        // if ($this->form_validation->run() == TRUE) {
            $input_post  = $post_data;

            $update_data = array(
              'STATUS' => '1'
            );

            // $this->MPembatalan_sppt->update($p_id, $update_data);
            $this->MPembatalan_sppt->update_status($nop, $thn);

            $this->session->set_flashdata('msg_success', 'Data telah disimpan');
            // echo $this->db->last_query(); die();
            //// back to editan sebelumnya
            // $pawal_nop  = $this->input->post('prm_awal_nop');
            // $pawal_thn  = $this->input->post('prm_awal_thn');
            // $pawal_kec  = $this->input->post('prm_awal_kec');
            // $pawal_kel  = $this->input->post('prm_awal_kel');
            // $pawal_sts  = $this->input->post('prm_awal_sts');
            // $data_awal = new \stdClass();
            // $data_awal->mode = "back_approve";
            // $data_awal->pawal_nop = $pawal_nop;
            // $data_awal->pawal_thn = $pawal_thn;
            // $data_awal->pawal_kec = $pawal_kec;
            // $data_awal->pawal_kel = $pawal_kel;
            // $data_awal->pawal_sts = $pawal_sts;
            // $this->session->set_flashdata('dt_back_approve',$data_awal);

            redirect(active_module_url($this->controller));
        // }else{
        //     show_404();
        // }

        $get = $post_data;
        $data['dt'] = $post_data;

        $data['page_menu']  = 'pembatalan_sppt';
        $data['current']    = '';
        $data['controller'] = $this->controller;
        $data['apps']       = $this->apps_model->get_active_only();
        $this->load->view('v_pembatalan_sppt_form', $data);
    }

    function process_tolak(){
        $id = $this->uri->segment(4);
        $mode       = $this->input->get('mode');
        $pawal_nop  = $this->input->get('pawal_nop');
        $pawal_thn  = $this->input->get('pawal_thn');
        $pawal_kec  = $this->input->get('pawal_kec');
        $pawal_kel  = $this->input->get('pawal_kel');
        $pawal_sts  = $this->input->get('pawal_sts');
        $pawal_idp  = $this->input->get('pawal_idp');

        if($id && $get = $this->MPembatalan_sppt->get($id)){
            $this->MPembatalan_sppt->process_tolak($id);

            // $data_awal = new stdObject();
            $data_awal = new stdClass();
            $data_awal->mode = "back_tolak";
            $data_awal->pawal_nop = $pawal_nop;
            $data_awal->pawal_thn = $pawal_thn;
            $data_awal->pawal_kec = $pawal_kec;
            $data_awal->pawal_kel = $pawal_kel;
            $data_awal->pawal_sts = $pawal_sts;
            $data_awal->pawal_idp = $pawal_idp;

            $this->session->set_flashdata('dt_back_tolak',$data_awal);

            $this->session->set_flashdata('msg_success', 'Data berhasil ditolak');
            redirect(active_module_url($this->controller));
        } else {
            show_404();
        }
    }

    function get_kelurahan() {
        $kec_id    = $this->uri->segment(4);
        $kelurahan = $this->MPembatalan_sppt->get_select_kelurahan($kec_id);
        echo json_encode($kelurahan);
    }

}
