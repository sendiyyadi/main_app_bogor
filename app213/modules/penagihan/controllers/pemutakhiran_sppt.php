<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pemutakhiran_sppt extends CI_Controller
{
    private $controller = 'pemutakhiran_sppt';
    public function __construct()
    {
        parent::__construct();
        if (!is_login()) {
            echo "<script>window.location.replace('" . base_url() . "');</script>";
            exit;
        }

        $module = 'pemutakhiran_sppt';
        $this->load->library('module_auth', array(
            'module' => $module
        ));

        $this->load->model(array(
            'apps_model'
        ));

        $this->load->helper(active_module());
        $this->load->model('pemutakhiran_sppt_model', 'MPemutakhiran_sppt');
    }

    public function index() {

        $pawal_nop  = '';
        $pawal_thn  = '';
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
        $select_data  = $this->MPemutakhiran_sppt->get_select_kecamatan();
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
        $kelurahan = $this->MPemutakhiran_sppt->get_select_kelurahan($kec_id);
            $select_data = $this->MPemutakhiran_sppt->get_select_kelurahan($pawal_kec);
            $options     = array();
            $options['999999'] = 'SEMUA KELURAHAN';
            if($select_data) {
            foreach ($select_data as $row) {
                $options[$row->KD_KELURAHAN] = $row->NM_KELURAHAN;
            }}
            $js                       = 'id="KD_KEL" class="form-control" required ';
            $data['select_kelurahan'] = form_dropdown('KD_KEL', $options, $pawal_kel, $js);
        //------------------------------------------------------------------
        $select_data = $this->MPemutakhiran_sppt->get_select_id_piutang();
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
        $options['0'] = 'DRAFT';
        $options['1'] = 'APPROVE';
        $options['2'] = 'TOLAK';

            $js                       = 'id="STS" class="form-control" required ';
            $data['select_status'] = form_dropdown('STS', $options, $pawal_sts, $js);
        //------------------------------------------------------------------
        $select_data = $this->MPemutakhiran_sppt->get_select_id_piutang_all();
        // var_dump($select_data);die;
        $options     = array();
        if($select_data) {
        foreach ($select_data as $row) {
          $options[$row->KD_LOOKUP_ITEM] = $row->NM_LOOKUP_ITEM;
        }}
        $js                       = 'id="id_piutang_m" class="form-control" required ';
        $data['select_id_piutang_all'] = form_dropdown('id_piutang_m', $options, $pawal_idp, $js);
        //------------------------------------------------------------------

        $data['c_nop'] = $pawal_nop;
        $data['c_thn'] = $pawal_thn;

        $data['page_menu']  = 'pemutakhiran_sppt';
        $data['current']    = '';
        $data['controller'] = $this->controller;
        $data['apps']       = $this->apps_model->get_active_only();

        $data['hak_btn_edit']   = $this->module_auth->button1;

        $this->load->view('v_pemutakhiran_sppt', $data);
    }

    function xxx() {
      $dtnya = $this->session->flashdata('dt_back_tolak');
      print_r($dtnya->mode);
      die();
    }

    function grid_old()
    {

        $nop         = $this->input->get('nop');
        $thn         = $this->input->get('thn');
        $kec         = $this->input->get('kec');
        $kel         = $this->input->get('kel');
        $sts         = $this->input->get('sts');
        $idp         = $this->input->get('idp');

        if ( ($kec == '999999' || empty($kec)) && empty($nop) ) {
            echo json_encode([
                // "draw" => intval($this->input->get("draw")),
                // "recordsTotal" => 0,
                // "recordsFiltered" => 0,
                // "data" => [],
                // "error" => "Harap pilih kecamatan"

                "aaData" => [],
                "iTotalDisplayRecords" => 0,
                "iTotalRecords" => 0,
                "sEcho" => 1,
                "error" => "Harap pilih kecamatan"
            ]);
            return;
        }

        // echo $idp;die;

        $this->load->library('Datatables');
        // $this->datatables->select("LOGINNAME,PASSWOD,NAMA,EMAIL,NIP,USER_GROUP,KD_KEC,KD_KEL",false);
        // $this->datatables->from('M02USERS_DS');
        // $this->datatables->select(ID_DSP.','.NOP_DSP.','.THN_PJK_SPPT_DSP.','.KECAMATAN_OP_NM_OLD_DSP.','.KELURAHAN_OP_NM_OLD_DSP.','.
        $this->datatables->select(ID_DSP.",".NOP_DSP.",".THN_PJK_SPPT_DSP.",".NM_KECAMATAN.",".NM_KELURAHAN.",".
                                LOGINNAME_DSP.",".APPROVED_BY_DSP.",
                                CASE WHEN ".STATUS_DSP."=0 THEN 'Draft' WHEN ".STATUS_DSP."=1 THEN 'Approve' WHEN ".STATUS_DSP."=2 THEN 'Tolak'
                                ELSE '-' END as STATUS
                                ", false);
        $this->datatables->from(TBL_DSPSPPT);
        $this->datatables->join('DT_V_TTSPPT12D T1', 'T1.NOP = DS_PERUBAHAN_OPWP.NOP AND T1.THN_PAJAK_SPPT = DS_PERUBAHAN_OPWP.THN_PAJAK_SPPT', '');
        // $this->datatables->join('TTSPPT12D T1', 'T1.THN_PAJAK_SPPT = DS_PERUBAHAN_OPWP.THN_PAJAK_SPPT AND DS_PERUBAHAN_OPWP.NOP = T1.KD_PROPINSI||T1.KD_DATI2||T1.KD_KECAMATAN||T1.KD_KELURAHAN||T1.KD_BLOK||T1.NO_URUT||T1.KD_JNS_OP');
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

        if($kel <> '999999' && !empty($kel)){
          $this->datatables->where("trim(T1.KD_KELURAHAN) = '".$kel."' ");
        }

        if($sts <> '9'){
          $this->datatables->where(STATUS_DSP, $sts);
        }

        if($idp <> '999999' && !empty($idp)){
          $this->datatables->where("trim(T1.ID_PIUTANG) = '".$idp."'");
        }else{
          $this->datatables->where("T1.ID_PIUTANG IN (5, 8)");
        }
        // echo $this->db->last_query();
        // die();
        // $this->datatables->checkbox_column('7');
        echo $this->datatables->generate();
    }

    function grid()
    {

        $nop         = $this->input->get('nop');
        $thn         = $this->input->get('thn');
        $kec         = $this->input->get('kec');
        $kel         = $this->input->get('kel');
        $sts         = $this->input->get('sts');
        $idp         = $this->input->get('idp');

        if ( ($kec == '999999' || empty($kec)) && empty($nop) ) {
            echo json_encode([

                "aaData" => [],
                "iTotalDisplayRecords" => 0,
                "iTotalRecords" => 0,
                "sEcho" => 1,
                "error" => "Harap pilih kecamatan"
            ]);
            return;
        }

        $this->load->library('Datatables');
        $this->datatables->select("DS.ID, DS.NOP, DS.THN_PAJAK_SPPT, KEC.NM_KECAMATAN, KEL.NM_KELURAHAN, DS.LOGINNAME, DS.APPROVED_BY,
                                CASE WHEN DS.STATUS = 0 THEN 'Draft' WHEN DS.STATUS = 1 THEN 'Approve' WHEN DS.STATUS = 2 THEN 'Tolak'
                                ELSE '-' END as STATUS", false);
        $this->datatables->from("DS_PERUBAHAN_OPWP DS");
        $this->datatables->join("TTSPPT12D T1", "T1.KD_PROPINSI = SUBSTR(DS.NOP, 1, 2) AND T1.KD_DATI2 = SUBSTR(DS.NOP, 3, 2) AND T1.KD_KECAMATAN = SUBSTR(DS.NOP, 5, 3) AND T1.KD_KELURAHAN = SUBSTR(DS.NOP, 8, 3) AND T1.KD_BLOK = SUBSTR(DS.NOP, 11, 3) AND T1.NO_URUT = SUBSTR(DS.NOP, 14, 4) AND T1.KD_JNS_OP = SUBSTR(DS.NOP, 18, 1) AND T1.THN_PAJAK_SPPT = DS.THN_PAJAK_SPPT", "");
        $this->datatables->join("REF_KECAMATAN KEC", "T1.KD_KECAMATAN = KEC.KD_KECAMATAN", "left");
        $this->datatables->join("REF_KELURAHAN KEL", "T1.KD_KELURAHAN = KEL.KD_KELURAHAN and T1.KD_KECAMATAN = KEL.KD_KECAMATAN", "left");

        if(!empty($nop)){
            $nop = trim($nop);
            $nop = strtoupper($nop);
            $this->datatables->where("trim(UPPER(DS.NOP)) like ('%".$nop."%')");
        }

        if(!empty($thn)){
            $this->datatables->where("trim(DS.THN_PAJAK_SPPT) = '".$thn."' ");
          }

        if($kec <> '999999' && !empty($kec)){
          $this->datatables->where("trim(T1.KD_KECAMATAN) = '".$kec."' ");
        }

        if($kel <> '999999' && !empty($kel)){
          $this->datatables->where("trim(T1.KD_KELURAHAN) = '".$kel."' ");
        }

        if($sts <> '9'){
          $this->datatables->where("DS.STATUS", $sts);
        }

        if($idp <> '999999' && !empty($idp)){
          $this->datatables->where("trim(T1.ID_PIUTANG) = '".$idp."'");
        }else{
          $this->datatables->where("T1.ID_PIUTANG IN (5, 8)");
        }
        
        echo $this->datatables->generate();
    }

    function exp_excel_csv() {
        $nop         = $this->input->get('nop');
        $thn         = $this->input->get('thn');
        $kec         = $this->input->get('kec');
        $kel         = $this->input->get('kel');
        $sts         = $this->input->get('sts');
        $idp         = $this->input->get('idp');

        $filex    = $this->input->get('filex');

        $query = $this->MPemutakhiran_sppt->query_cetak_real($nop, $thn, $kec, $kel, $sts, $idp);

        $kd_kec = '';
        $nm_kec = '';
        $kd_kel = '';
        $nm_kel = '';

        if($kecc = $this->MPemutakhiran_sppt->get_rpt_kec($kec)){
            $kd_kec = $kecc->KD_KECAMATAN;
            $nm_kec = $kecc->NM_KECAMATAN;
        }

        if($kell = $this->MPemutakhiran_sppt->get_rpt_kel($kec, $kel)){
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
        //var_dump($params);die;
        $rpt  = 'rpt_pemutakhiran_sppt';
        $type = $filex; //'xls';

        $jasper = $this->load->library('Jasper_ora');
        echo $jasper->export($rpt, $params, $type, TRUE);
    }

    function get_kelurahan() {
        $kec_id    = $this->uri->segment(4);
        $kelurahan = $this->MPemutakhiran_sppt->get_select_kelurahan($kec_id);
        echo json_encode($kelurahan);
    }

    public function get_detail_sppt(){ 
        $nop = $this->input->post('nop');
        $thn = $this->input->post('thn');

        $qr = "SELECT 
                t.kd_propinsi||'.'||t.kd_dati2||'.'||t.kd_kecamatan||'.'||t.kd_kelurahan||'.'||t.kd_blok||'.'||t.no_urut||'.'||t.kd_jns_op AS nop,
                t.kd_propinsi||t.kd_dati2||t.kd_kecamatan||t.kd_kelurahan||t.kd_blok||t.no_urut||t.kd_jns_op||t.thn_pajak_sppt AS nopthn,
                t.nm_wp_sppt, t.tgl_rekam, t.loginname, t.keterangan, t.foto_sppt_baru, t.id_piutang, t.foto_pembetulan,
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

}
