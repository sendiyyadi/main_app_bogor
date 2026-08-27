<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pembatalan_sppt_new extends CI_Controller
{

    private $controller = 'pembatalan_sppt_new';
    public function __construct()
    {
        parent::__construct();
        if (!is_login()) {
            echo "<script>window.location.replace('" . base_url() . "');</script>";
            exit;
        }

        $module = 'pembatalan_sppt_new';
        $this->load->library('module_auth', array(
            'module' => $module
        ));

        $this->load->model(array(
            'apps_model'
        ));

        $this->load->helper(active_module());
        $this->load->model('pembatalan_sppt_new_model', 'MPembatalan_sppt_new');
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
        $select_data  = $this->MPembatalan_sppt_new->get_select_kecamatan();
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
        $kelurahan = $this->MPembatalan_sppt_new->get_select_kelurahan($kec_id);
            $select_data = $this->MPembatalan_sppt_new->get_select_kelurahan($pawal_kec);
            $options     = array();
            $options['999999'] = 'SEMUA KELURAHAN';
            if($select_data) {
            foreach ($select_data as $row) {
                $options[$row->KD_KELURAHAN] = $row->NM_KELURAHAN;
            }}
            $js                       = 'id="KD_KEL" class="form-control" required ';
            $data['select_kelurahan'] = form_dropdown('KD_KEL', $options, $pawal_kel, $js);
        //------------------------------------------------------------------
        $select_data = $this->MPembatalan_sppt_new->get_select_id_piutang();
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
        $select_data = $this->MPembatalan_sppt_new->get_select_id_piutang_all();
        // var_dump($select_data);die;
        $options     = array();
        if($select_data) {
        foreach ($select_data as $row) {
          $options[$row->KD_LOOKUP_ITEM] = $row->NM_LOOKUP_ITEM;
        }}
        $js                       = 'id="id_piutang_m" class="input select2 form-control" required ';
        $data['select_id_piutang_all'] = form_dropdown('id_piutang_m', $options, $pawal_idp, $js);
        //------------------------------------------------------------------

        //// SIMULTAN
        //------------------------------------------------------------------
        $select_data  = $this->MPembatalan_sppt_new->get_select_kecamatan();
            $options      = array();
            $kec_id = '';
            if($select_data) {
            $options['999999'] = 'SEMUA KECAMATAN';
            foreach ($select_data as $row) {
                if($kec_id == '') $kec_id = $row->KD_KECAMATAN;
                $options[$row->KD_KECAMATAN] = $row->NM_KECAMATAN;
            }}
            $js                       = 'id="KD_KEC_sim" class="form-control" onChange="get_kelurahan_sim(this.value);" required ';
            $data['select_kecamatan_sim'] = form_dropdown('KD_KEC_sim', $options, $pawal_kec, $js);
        //------------------------------------------------------------------
        $kelurahan = $this->MPembatalan_sppt_new->get_select_kelurahan($kec_id);
            $select_data = $this->MPembatalan_sppt_new->get_select_kelurahan($pawal_kec);
            $options     = array();
            $options['999999'] = 'SEMUA KELURAHAN';
            if($select_data) {
            foreach ($select_data as $row) {
                $options[$row->KD_KELURAHAN] = $row->NM_KELURAHAN;
            }}
            $js                       = 'id="KD_KEL_sim" class="form-control" required ';
            $data['select_kelurahan_sim'] = form_dropdown('KD_KEL_sim', $options, $pawal_kel, $js);
        //------------------------------------------------------------------
        $select_data = $this->MPembatalan_sppt_new->get_select_id_piutang();
        // var_dump($select_data);die;
        $options     = array();
            $options['999999'] = 'SEMUA ID PIUTANG';
        if($select_data) {
        foreach ($select_data as $row) {
          $options[$row->KD_LOOKUP_ITEM] = $row->NM_LOOKUP_ITEM;
        }}
        $js                       = 'id="id_piutang_sim" class="form-control" required ';
        $data['select_id_piutang_sim'] = form_dropdown('id_piutang_sim', $options, $pawal_idp, $js);
        //------------------------------------------------------------------
        //// END SIMULTAN

        $data['c_nop'] = $pawal_nop;
        $data['c_thn'] = $pawal_thn;

        $data['c_nop_sim'] = $pawal_nop;
        $data['c_thn_sim'] = $pawal_thn;

        $data['page_menu']  = 'pembatalan_sppt_new';
        $data['current']    = '';
        $data['controller'] = $this->controller;
        $data['apps']       = $this->apps_model->get_active_only();

        $data['hak_btn_edit']   = $this->module_auth->button1;
        $data['hak_btn_appr']   = $this->module_auth->button2;

        $this->load->view('v_pembatalan_sppt_new', $data);
    }

    function xxx() {
      $dtnya = $this->session->flashdata('dt_back_tolak');
      print_r($dtnya->mode);
      die();
    }

    function grid()
    {
        $nop         = $this->input->get('nop');
        $thn         = $this->input->get('thn');
        $kec         = $this->input->get('kec');
        $kel         = $this->input->get('kel');
        // $sts         = $this->input->get('sts');
        $idp         = $this->input->get('idp');

        $this->load->library('Datatables');

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

        if($idp <> '999999' && !empty($idp)){
          $this->datatables->where("trim(T1.ID_PIUTANG) = '".$idp."'");
        }else{
          $this->datatables->where("trim(T1.ID_PIUTANG) IN ('2','3','4','5','6','7')");
        }
        echo $this->datatables->generate();

    }

    function grid_appr_sim()
    {
        $nop         = $this->input->get('nop');
        $thn         = $this->input->get('thn');
        $kec         = $this->input->get('kec');
        $kel         = $this->input->get('kel');
        // $sts         = $this->input->get('sts');
        $idp         = $this->input->get('idp');

        $pros_id   = $this->input->get('proses_id');
        if ($pros_id == ""){
            $pros_id=999999999999999;
        }

        $model_id = $this->input->get('model_id');
        // select all
        if ($model_id == 1){
            $this->MPembatalan_sppt_new->select_prs_pdt_mobile_all($pros_id, $nop, $thn, $kec, $kel, $idp);
        }
        // reset all
        if ($model_id == 2){
            $this->MPembatalan_sppt_new->reset_cetak_pdt_mobile_all($pros_id);
        }

        $this->load->library('Datatables');

        $this->datatables->select("T1.KD_PROPINSI||T1.KD_DATI2||T1.KD_KECAMATAN||T1.KD_KELURAHAN||T1.KD_BLOK||T1.NO_URUT||T1.KD_JNS_OP||T1.THN_PAJAK_SPPT AS NOPTHN,
        CASE WHEN TMP.ID IS NULL THEN 0 ELSE 1 END AS FLAG,
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
        $this->datatables->join("TMP_TTSPPT_SIM TMP", "TMP.KD_PROPINSI=T1.KD_PROPINSI AND TMP.KD_DATI2=T1.KD_DATI2 AND TMP.KD_KECAMATAN=T1.KD_KECAMATAN AND TMP.KD_KELURAHAN=T1.KD_KELURAHAN AND TMP.KD_BLOK=T1.KD_BLOK AND TMP.NO_URUT=T1.NO_URUT AND TMP.KD_JNS_OP=T1.KD_JNS_OP AND TMP.THN_PAJAK_SPPT=T1.THN_PAJAK_SPPT AND TMP.PROSES_ID=".$pros_id, 'LEFT');
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
            // $this->datatables->where("trim(UPPER(T1.NOP)) like ('%".$nop."%')");
            $this->datatables->where("T1.KD_PROPINSI||T1.KD_DATI2||T1.KD_KECAMATAN||T1.KD_KELURAHAN||T1.KD_BLOK||T1.NO_URUT||T1.KD_JNS_OP like ('%".$nop."%')", false, false);
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

        if($idp <> '999999' && !empty($idp)){
          $this->datatables->where("trim(T1.ID_PIUTANG) = '".$idp."'");
        }else{
          $this->datatables->where("trim(T1.ID_PIUTANG) IN ('2','3','4','6','7')");
        }
        echo $this->datatables->generate();

    }

    function apprv_sim() {
        $pros_id = $this->uri->segment(4);
        
        $date= date("Y-m-d");
        $nip = sipkd_user_nip();
        // var_dump($nip);die();

        $qq = "SELECT TM.*, TM.KD_PROPINSI||TM.KD_DATI2||TM.KD_KECAMATAN||TM.KD_KELURAHAN||TM.KD_BLOK||TM.NO_URUT||TM.KD_JNS_OP as NOPLKP,
               TT.ID_PIUTANG, L.NM_LOOKUP_ITEM AS NAMA_PIUTANG
               FROM TMP_TTSPPT_SIM TM
               JOIN TTSPPT12D TT ON TT.KD_PROPINSI=TM.KD_PROPINSI AND TT.KD_DATI2=TM.KD_DATI2 AND TT.KD_KECAMATAN=TM.KD_KECAMATAN
                    AND TT.KD_KELURAHAN=TM.KD_KELURAHAN AND TT.KD_BLOK=TM.KD_BLOK AND TT.NO_URUT=TM.NO_URUT AND TT.KD_JNS_OP=TM.KD_JNS_OP
                    AND TT.THN_PAJAK_SPPT=TM.THN_PAJAK_SPPT
               JOIN LOOKUP_ITEM L ON L.KD_LOOKUP_GROUP='88' AND L.KD_LOOKUP_ITEM=TT.ID_PIUTANG
               WHERE TM.PROSES_ID ='$pros_id'";
        $ax = $this->db->query($qq);

        if($ax->num_rows() > 0){
            $bx = $ax->row();
            $kd_prop = $bx->KD_PROPINSI;
            $kd_dati2 = $bx->KD_DATI2;
            $kd_kecamatan = $bx->KD_KECAMATAN;
            $kd_kelurahan = $bx->KD_KELURAHAN;
            $kd_blok = $bx->KD_BLOK;
            $no_urut = $bx->NO_URUT;
            $kd_jns_op = $bx->KD_JNS_OP;
            $thn_pjk = $bx->THN_PAJAK_SPPT;
            $noplkp = $bx->NOPLKP;
            $id_piut = $bx->ID_PIUTANG;

            $err_Msg = '';
            //// INSERT HIST DULU 
            $this->sp_hist($kd_prop, $kd_dati2, $kd_kecamatan, $kd_kelurahan, $kd_blok, $no_urut, $kd_jns_op, $thn_pjk, $noplkp);

            $sql  = " BEGIN ";

            if ($id_piut == '2') {      ////  ID PIUTANG 2 (khusus objek pajak tidak ada)

                $sql .= " BEGIN
                            DELETE FROM DAT_OBJEK_PAJAK 
                            WHERE KD_PROPINSI = '$kd_prop'
                            AND KD_DATI2 = '$kd_dati2'
                            AND KD_KECAMATAN = '$kd_kecamatan'
                            AND KD_KELURAHAN = '$kd_kelurahan'
                            AND KD_BLOK = '$kd_blok'
                            AND NO_URUT = '$no_urut'
                            AND KD_JNS_OP = '$kd_jns_op' ;
                        EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; ";
               
            } else {                //// SELAIN ID PIUTANG 2

                //// insert or update dafnom
                $sql .= " BEGIN
                            MERGE INTO DAFNOM_OP AA
                            USING (
                                SELECT TT.KD_PROPINSI, TT.KD_DATI2, TT.KD_KECAMATAN, TT.KD_KELURAHAN, TT.KD_BLOK, TT.NO_URUT, TT.KD_JNS_OP, 
                                       OP.JALAN_OP, OP.BLOK_KAV_NO_OP, OP.RW_OP, OP.RT_OP, BM.JNS_BUMI, NULL AS KD_JPB, OP.KD_STATUS_WP, 
                                       TT.ID_PIUTANG AS KATEGORI_OP, L.NM_LOOKUP_ITEM AS KETERANGAN, OP.NO_FORMULIR_SPOP AS NO_FORMULIR, 
                                       TT.TGL_TERIMA_SPPT AS TGL_PEMBENTUKAN, '$nip' AS NIP_PEMBENTUK, SYSDATE AS TGL_PEMUTAKHIRAN, 
                                       '170000029000000000' AS NIP_PEMUTAKHIR, EXTRACT(YEAR FROM SYSDATE) AS THN_PEMBENTUKAN
                                FROM TTSPPT12D TT
                                JOIN DAT_OBJEK_PAJAK OP ON TT.KD_PROPINSI = OP.KD_PROPINSI AND TT.KD_DATI2 = OP.KD_DATI2 AND TT.KD_KECAMATAN = OP.KD_KECAMATAN
                                     AND TT.KD_KELURAHAN = OP.KD_KELURAHAN AND TT.KD_BLOK = OP.KD_BLOK AND TT.NO_URUT = OP.NO_URUT AND TT.KD_JNS_OP = OP.KD_JNS_OP
                                JOIN DAT_OP_BUMI BM ON BM.KD_PROPINSI = OP.KD_PROPINSI AND BM.KD_DATI2 = OP.KD_DATI2 AND BM.KD_KECAMATAN = OP.KD_KECAMATAN
                                     AND BM.KD_KELURAHAN = OP.KD_KELURAHAN AND BM.KD_BLOK = OP.KD_BLOK AND BM.NO_URUT = OP.NO_URUT AND BM.KD_JNS_OP = OP.KD_JNS_OP
                                JOIN LOOKUP_ITEM L ON L.KD_LOOKUP_GROUP = '88' AND L.KD_LOOKUP_ITEM = TT.ID_PIUTANG
                                WHERE TT.KD_PROPINSI = '$kd_prop'
                                AND TT.KD_DATI2 = '$kd_dati2'
                                AND TT.KD_KECAMATAN = '$kd_kecamatan'
                                AND TT.KD_KELURAHAN = '$kd_kelurahan'
                                AND TT.KD_BLOK = '$kd_blok'
                                AND TT.NO_URUT = '$no_urut'
                                AND TT.KD_JNS_OP = '$kd_jns_op'
                                AND TT.THN_PAJAK_SPPT = '$thn_pjk'
                            ) BB
                            ON (AA.KD_PROPINSI = BB.KD_PROPINSI AND AA.KD_DATI2 = BB.KD_DATI2 AND AA.KD_KECAMATAN = BB.KD_KECAMATAN
                                AND AA.KD_KELURAHAN = BB.KD_KELURAHAN AND AA.KD_BLOK = BB.KD_BLOK AND AA.NO_URUT = BB.NO_URUT
                                AND AA.KD_JNS_OP = BB.KD_JNS_OP)
                            WHEN MATCHED THEN
                                UPDATE SET
                                    AA.JALAN_OP = BB.JALAN_OP,
                                    AA.BLOK_KAV_NO_OP = BB.BLOK_KAV_NO_OP,
                                    AA.RW_OP = BB.RW_OP,
                                    AA.RT_OP = BB.RT_OP,
                                    AA.JNS_BUMI = BB.JNS_BUMI,
                                    AA.KD_JPB = BB.KD_JPB,
                                    AA.KD_STATUS_WP = BB.KD_STATUS_WP,
                                    AA.KATEGORI_OP = BB.KATEGORI_OP,
                                    AA.KETERANGAN = BB.KETERANGAN,
                                    AA.NO_FORMULIR = BB.NO_FORMULIR,
                                    AA.TGL_PEMBENTUKAN = BB.TGL_PEMBENTUKAN,
                                    AA.NIP_PEMBENTUK = BB.NIP_PEMBENTUK,
                                    AA.TGL_PEMUTAKHIRAN = BB.TGL_PEMUTAKHIRAN,
                                    AA.NIP_PEMUTAKHIR = BB.NIP_PEMUTAKHIR,
                                    AA.THN_PEMBENTUKAN = BB.THN_PEMBENTUKAN
                            WHEN NOT MATCHED THEN
                                INSERT (KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP, JALAN_OP, 
                                    BLOK_KAV_NO_OP, RW_OP, RT_OP, JNS_BUMI, KD_JPB, KD_STATUS_WP, KATEGORI_OP, KETERANGAN, 
                                    NO_FORMULIR, TGL_PEMBENTUKAN, NIP_PEMBENTUK, TGL_PEMUTAKHIRAN, NIP_PEMUTAKHIR, THN_PEMBENTUKAN)
                                VALUES (BB.KD_PROPINSI, BB.KD_DATI2, BB.KD_KECAMATAN, BB.KD_KELURAHAN, BB.KD_BLOK, BB.NO_URUT, BB.KD_JNS_OP, BB.JALAN_OP, BB.BLOK_KAV_NO_OP, BB.RW_OP, BB.RT_OP, BB.JNS_BUMI, BB.KD_JPB, BB.KD_STATUS_WP, BB.KATEGORI_OP, BB.KETERANGAN, BB.NO_FORMULIR, BB.TGL_PEMBENTUKAN, BB.NIP_PEMBENTUK, BB.TGL_PEMUTAKHIRAN, BB.NIP_PEMUTAKHIR, BB.THN_PEMBENTUKAN);
                        EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; ";

                // update dat_op_bumi jadi 8
                $sql .= " BEGIN
                            UPDATE DAT_OP_BUMI SET JNS_BUMI = '8'
                            WHERE KD_PROPINSI = '$kd_prop'
                                AND KD_DATI2 = '$kd_dati2'
                                AND KD_KECAMATAN = '$kd_kecamatan'
                                AND KD_KELURAHAN = '$kd_kelurahan'
                                AND KD_BLOK = '$kd_blok'
                                AND NO_URUT = '$no_urut'
                                AND KD_JNS_OP = '$kd_jns_op' ;
                        EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; ";

                // update status pembayaran sppt jadi 2 => khusus data yg status_pembayaran_sppt = 0 (blm bayar)
                $sql .= " BEGIN
                            UPDATE SPPT SET STATUS_PEMBAYARAN_SPPT = '2'
                            WHERE KD_PROPINSI = '$kd_prop'
                                AND KD_DATI2 = '$kd_dati2'
                                AND KD_KECAMATAN = '$kd_kecamatan'
                                AND KD_KELURAHAN = '$kd_kelurahan'
                                AND KD_BLOK = '$kd_blok'
                                AND NO_URUT = '$no_urut'
                                AND KD_JNS_OP = '$kd_jns_op'
                                AND STATUS_PEMBAYARAN_SPPT = '0' ;
                        EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; ";
                
            }

            // update TTSPPT12D STATUS = 1
            $sql .= " BEGIN
                        UPDATE TTSPPT12D SET STATUS = '1'
                        WHERE KD_PROPINSI = '$kd_prop'
                            AND KD_DATI2 = '$kd_dati2'
                            AND KD_KECAMATAN = '$kd_kecamatan'
                            AND KD_KELURAHAN = '$kd_kelurahan'
                            AND KD_BLOK = '$kd_blok'
                            AND NO_URUT = '$no_urut'
                            AND KD_JNS_OP = '$kd_jns_op'
                            AND THN_PAJAK_SPPT = '$thn_pjk' ;
                    EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; ";

            $sql .= "   COMMIT;
                          END;" ;

            // echo $sql; die;

            $error_msg = $this->db->simple_qry_eon_ora($sql);
            $err_Msg = $error_msg['message'];

            
            if (!empty($err_Msg)) {
                $error_CRUD = $err_Msg . ', Proses approve simultan gagal....!!!';
                $msg = $error_CRUD;
                echo $msg;
            } else {
                echo 'sukses';
            }
        } else {
            echo 'Data tidak ditemukan.. harap refresh halaman..';
        }

    }


    function update_tmp_appr_sim(){
        $proses_id  = $this->uri->segment(4);
        $flag         = $this->uri->segment(5);
        $nop          = $this->uri->segment(6);
        $thn          = $this->uri->segment(7);
        // var_dump($nop);die();
        $result_add = $this->MPembatalan_sppt_new->select_row_tmp_prs_sim($flag,$proses_id,$nop, $thn);

    }

    function exp_excel_csv() {
      $nop         = $this->input->get('nop');
      $thn         = $this->input->get('thn');
      $kec         = $this->input->get('kec');
      $kel         = $this->input->get('kel');
      // $sts         = $this->input->get('sts');
      $idp         = $this->input->get('idp');

      $filex    = $this->input->get('filex');

      $query = $this->MPembatalan_sppt_new->query_cetak_real($nop, $thn, $kec, $kel, $idp);

      $kd_kec = '';
      $nm_kec = '';
      $kd_kel = '';
      $nm_kel = '';

      if($kecc = $this->MPembatalan_sppt_new->get_rpt_kec($kec)){
        $kd_kec = $kecc->KD_KECAMATAN;
        $nm_kec = $kecc->NM_KECAMATAN;
      }

      if($kell = $this->MPembatalan_sppt_new->get_rpt_kel($kec, $kel)){
        $kd_kec = $kell->KD_KELURAHAN;
        $nm_kec = $kell->NM_KELURAHAN;
      }
      $params = array(
          'query' => $query,
          'thn_pajak_sppt' => $thn,
          'kd_kecamatan' => empty($kd_kec) ? '999999' : $kd_kec,
          'kd_kelurahan' => empty($kd_kel) ? '999999' : $kd_kel,
          'nm_kecamatan' => empty($nm_kec) ? '-' : $nm_kec,
          'nm_kelurahan' => empty($nm_kel) ? '-' : $nm_kel,
      );
        //var_dump($query);die;
      $rpt  = 'rpt_pembatalan_sppt_new';
      $type = $filex; //'xls';

      $jasper = $this->load->library('Jasper_ora');
      //var_dump($rpt);die;
      // echo $jasper->export($rpt, $params, $type, TRUE);
      echo $jasper->cetak_ora($rpt, $params, 'xls');
  }

    function get_kelurahan() {
        $kec_id    = $this->uri->segment(4);
        $kelurahan = $this->MPembatalan_sppt_new->get_select_kelurahan($kec_id);
        echo json_encode($kelurahan);
    }

    public function get_detail_sppt(){ 
        $nop = $this->input->post('nop');
        $nop = str_replace('.', '', $nop);
        $nop = str_replace(' ', '', $nop);
        $nop = str_replace('-', '', $nop);
        $thn = $this->input->post('thn');

        $qr = "SELECT 
                t.kd_propinsi||'.'||t.kd_dati2||'.'||t.kd_kecamatan||'.'||t.kd_kelurahan||'.'||t.kd_blok||'.'||t.no_urut||'.'||t.kd_jns_op AS nop,
                t.kd_propinsi||t.kd_dati2||t.kd_kecamatan||t.kd_kelurahan||t.kd_blok||t.no_urut||t.kd_jns_op||t.thn_pajak_sppt AS nopthn,
                t.nm_wp_sppt, t.tgl_rekam, t.loginname, t.keterangan, t.foto_sppt_baru, t.id_piutang, t.foto_pembetulan, t.foto_pembatalan,
                kec.nm_kecamatan, kel.nm_kelurahan                
            FROM ttsppt12d t
            LEFT JOIN ref_kecamatan kec ON t.kd_kecamatan = kec.kd_kecamatan
            LEFT JOIN ref_kelurahan kel ON t.kd_kecamatan = kel.kd_kecamatan 
                AND t.kd_kelurahan = kel.kd_kelurahan
            WHERE t.kd_propinsi||t.kd_dati2||t.kd_kecamatan||t.kd_kelurahan||t.kd_blok||t.no_urut||t.kd_jns_op = '$nop'
            AND t.thn_pajak_sppt = '$thn' ";
        $query = $this->db->query($qr);

        echo json_encode($query->row());
    }

    public function update_piutang() {
        $id_m = $this->input->post('id_m');
        $id_piutang_m = $this->input->post('id_piutang_m');

        // Jalankan query update
        $sql = "UPDATE ttsppt12d t
                SET t.id_piutang = ?
                WHERE t.kd_propinsi || t.kd_dati2 || t.kd_kecamatan || 
                      t.kd_kelurahan || t.kd_blok || t.no_urut || 
                      t.kd_jns_op || t.thn_pajak_sppt = ? ";

        $result = $this->db->query($sql, array($id_piutang_m, $id_m));

        if ($this->db->affected_rows() > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Data gagal disimpan atau tidak ada perubahan']);
        }
    }

    public function proxy_foto() {
        $filename = $this->input->get('id');
        // echo $filename; die;
        $url = "http://bogorkab.net/sppt_api_neo/pembatalan/" . $filename;
        $image = @file_get_contents($url);

        if ($image) {
            header("Content-Type: image/jpeg"); // atau image/png sesuai tipe
            echo $image;
        } else {
            show_404();
        }
    }

    //// EXEC STORE PROCEDURE
    function sp_hist($kd_prop, $kd_dati2, $kd_kec, $kd_kel, $kd_blok, $no_urut, $kd_jns_op, $thn_pjk_sppt, $nopel_lkp){
        $dbhost = DB_HOST;
        $dbport = DB_PORT;
        $dbname = DB_NAME;
        $dbuser = DB_USER;
        $dbpass = DB_PASS;
        $tnslistener = '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=' . $dbhost . ')(PORT=' . $dbport . '))(CONNECT_DATA=(SID=' . $dbname . ')))';
        $conn = oci_connect($dbuser, $dbpass, $tnslistener);
            
        $sql = 'BEGIN P_HIST_PROSES_ONLINE(:PARAM_1, :PARAM_2, :PARAM_3, :PARAM_4,
                :PARAM_5, :PARAM_6, :PARAM_7, :PARAM_8, :PARAM_9, :PARAM_10, :PARAM_11); END;';
        $stmt = oci_parse($conn,$sql);

        $p1    = $kd_prop;
        $p2    = $kd_dati2;
        $p3    = $kd_kec;
        $p4    = $kd_kel;
        $p5    = $kd_blok;
        $p6    = $no_urut;
        $p7    = $kd_jns_op;
        $p8    = $thn_pjk_sppt;
        $p9    = 1;
        $p10   = $nopel_lkp;

        $x = new DateTime();
        $y = (int)$x->format('YmdHis');
        $p11    = $y;

        // Bind the input parameter
        oci_bind_by_name($stmt, ':PARAM_1', $p1, 200);
        oci_bind_by_name($stmt, ':PARAM_2', $p2, 200);
        oci_bind_by_name($stmt, ':PARAM_3', $p3, 200);
        oci_bind_by_name($stmt, ':PARAM_4', $p4, 200);
        oci_bind_by_name($stmt, ':PARAM_5', $p5, 200);
        oci_bind_by_name($stmt, ':PARAM_6', $p6, 200);
        oci_bind_by_name($stmt, ':PARAM_7', $p7, 200);
        oci_bind_by_name($stmt, ':PARAM_8', $p8, 200);
        oci_bind_by_name($stmt, ':PARAM_9', $p9, 200);
        oci_bind_by_name($stmt, ':PARAM_10', $p10, 200);
        oci_bind_by_name($stmt, ':PARAM_11', $p11);

        // Execute the statement but do not commit
        oci_execute($stmt, OCI_DEFAULT);
        
        // Everything OK so commit
        oci_commit($conn);
        return TRUE;
    }


}
