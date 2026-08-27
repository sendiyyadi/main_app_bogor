<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class check_nik extends CI_Controller
{

    private $controller = 'check_nik';

    public function __construct()
    {
        parent::__construct();
        if (!is_login()) {
            echo "<script>window.location.replace('" . base_url() . "');</script>";
            exit;
        }

        $module = 'check_nik';
        $this->load->library('module_auth', array(
            'module' => $module
        ));

        $this->load->model(array(
            'apps_model', 'check_nik_model'
        ));

        $this->load->helper(active_module());
    }

    public function index()
    {
        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect('eadm_depok');
        }

        $data['page_menu'] = 'check_nik';
        $data['current'] = '';
        $data['apps']    = $this->apps_model->get_active_only();
        
        $this->load->view('vcheck_nik', $data);
    }

    public function grid()
    {
        $nik   = $this->input->get('nik');

        //        $this->datatables->select("ROW_NUMBER() OVER (ORDER BY DOP.KD_PROPINSI||'.'||DOP.KD_DATI2||'-'||DOP.KD_KECAMATAN||'.'||DOP.KD_KELURAHAN||'-'||DOP.KD_BLOK||'.'||DOP.NO_URUT||'.'||DOP.KD_JNS_OP) as nomer,
        //                            DSP.SUBJEK_PAJAK_ID AS NIK,
        //                            DSP.NM_WP AS NAMA_WP,
        //                            DOP.KD_PROPINSI||DOP.KD_DATI2||DOP.KD_KECAMATAN||DOP.KD_KELURAHAN||DOP.KD_BLOK||DOP.NO_URUT||DOP.KD_JNS_OP AS NOP,
        //                            DSP.JALAN_WP||','||DSP.BLOK_KAV_NO_WP||', RW '||DSP.RW_WP||', RT '||DSP.RT_WP||','||DSP.KELURAHAN_WP||','||DSP.KOTA_WP AS ALAMAT_WP,
        //                            DOP.JALAN_OP||','||DOP.BLOK_KAV_NO_OP||', RW '||DOP.RW_OP||', RT '||DOP.RT_OP||','||RL.NM_KELURAHAN||','||RC.NM_KECAMATAN AS ALAMAT_OP", false);
        // $this->datatables->from('DAT_SUBJEK_PAJAK DSP');
        // $this->datatables->join('DAT_OBJEK_PAJAK DOP', 'DOP.SUBJEK_PAJAK_ID = DSP.SUBJEK_PAJAK_ID', 'inner');
        // $this->datatables->join('REF_KELURAHAN RL', 'RL.KD_KELURAHAN = DOP.KD_KELURAHAN', 'inner');
        // $this->datatables->join('REF_KECAMATAN RC', 'RC.KD_KECAMATAN = DOP.KD_KECAMATAN', 'inner');

        $this->load->library('Datatables');
        $this->datatables->select("DSP.SUBJEK_PAJAK_ID,
                                   DSP.NM_WP,
                                   DOP.KD_PROPINSI||DOP.KD_DATI2||DOP.KD_KECAMATAN||DOP.KD_KELURAHAN||DOP.KD_BLOK||DOP.NO_URUT||DOP.KD_JNS_OP AS NOP,
                                   DSP.JALAN_WP||','||DSP.BLOK_KAV_NO_WP||', RW '||DSP.RW_WP||', RT '||DSP.RT_WP||','||DSP.KELURAHAN_WP||','||DSP.KOTA_WP AS ALAMAT_WP,
                                   DOP.JALAN_OP||','||DOP.BLOK_KAV_NO_OP||', RW '||DOP.RW_OP||', RT '||DOP.RT_OP||','||RL.NM_KELURAHAN||','||RC.NM_KECAMATAN AS ALAMAT_OP",
                                  false);
        $this->datatables->from('DAT_SUBJEK_PAJAK DSP');
        $this->datatables->join('DAT_OBJEK_PAJAK DOP', 'DOP.SUBJEK_PAJAK_ID = DSP.SUBJEK_PAJAK_ID', 'inner');
        $this->datatables->join('REF_KECAMATAN RC', 'RC.KD_PROPINSI = DOP.KD_PROPINSI AND RC.KD_DATI2 = DOP.KD_DATI2 AND RC.KD_KECAMATAN = DOP.KD_KECAMATAN', 'inner');
        $this->datatables->join('REF_KELURAHAN RL', 'RL.KD_PROPINSI = DOP.KD_PROPINSI AND RL.KD_DATI2 = DOP.KD_DATI2 AND RL.KD_KECAMATAN = DOP.KD_KECAMATAN AND RL.KD_KELURAHAN = DOP.KD_KELURAHAN', 'inner');

    //     $this->datatables->group_by("DSP.SUBJEK_PAJAK_ID,
    //                                DSP.NM_WP,
    //                                DOP.KD_PROPINSI,DOP.KD_DATI2,DOP.KD_KECAMATAN,DOP.KD_KELURAHAN,DOP.KD_BLOK,DOP.NO_URUT,DOP.KD_JNS_OP,
    // DSP.JALAN_WP, DSP.BLOK_KAV_NO_WP, DSP.RW_WP, DSP.RT_WP, DSP.KELURAHAN_WP, DSP.KOTA_WP,
    // DOP.JALAN_OP, DOP.BLOK_KAV_NO_OP, DOP.RW_OP, DOP.RT_OP, RL.NM_KELURAHAN, RC.NM_KECAMATAN");

        // $this->datatables->group_by('DSP.SUBJEK_PAJAK_ID');
        // $this->datatables->group_by("DOP.KD_PROPINSI, DOP.KD_DATI2, DOP.KD_KECAMATAN, DOP.KD_KELURAHAN, DOP.KD_BLOK, DOP.NO_URUT, DOP.KD_JNS_OP");

        //bawah ini bisa
        // $this->datatables->group_by("DSP.SUBJEK_PAJAK_ID,
        //                      DSP.NM_WP,
        //                      DOP.KD_PROPINSI || DOP.KD_DATI2 || DOP.KD_KECAMATAN || DOP.KD_KELURAHAN || DOP.KD_BLOK || DOP.NO_URUT || DOP.KD_JNS_OP,
        //                      DSP.JALAN_WP || ', ' || DSP.BLOK_KAV_NO_WP || ', ' || DSP.RW_WP || ', RT ' || DSP.RT_WP || ', ' || DSP.KELURAHAN_WP || ', ' || DSP.KOTA_WP,
        //                      DOP.JALAN_OP || ', ' || DOP.BLOK_KAV_NO_OP || ', RW ' || DOP.RW_OP || ', RT ' || DOP.RT_OP || ', ' || RL.NM_KELURAHAN || ', ' || RC.NM_KECAMATAN");
        // $this->datatables->group_by("DOP.KD_PROPINSI || DOP.KD_DATI2 || DOP.KD_KECAMATAN || DOP.KD_KELURAHAN || DOP.KD_BLOK || DOP.NO_URUT || DOP.KD_JNS_OP");
        if(!empty($nik)){
            $nik = trim($nik);
            // $this->datatables->where("trim('DSP.SUBJEK_PAJAK_ID') like ('%".$nik."%')");
            $this->datatables->where("trim(DSP.SUBJEK_PAJAK_ID) LIKE '%$nik%'");
        }

        echo $this->datatables->generate();
    }

    public function detail(){

        $p_nik = $this->uri->segment(4);
        $p_peps = $this->uri->segment(5);
        $data['nik'] = $p_nik;
        $data['peps'] = $p_peps;

        $data['page_menu']  = 'check_detail_nik';
        $data['current']    = '';
        $data['controller'] = $this->controller;
        $data['apps']       = $this->apps_model->get_active_only();

        $this->load->view('v_check_nik_detail', $data);
    }

    public function detail_nik($p_nik, $p_peps){
        $p_peps = $this->uri->segment(5);

        $this->load->library('Datatables');
        $this->datatables->select("THN_PAJAK_SPPT AS TAHUN,
                               NM_WP_SPPT AS NAMA_WP,
                               LUAS_BUMI_SPPT AS LUAS_TANAH,
                               NJOP_BUMI_SPPT AS NJOP_TANAH,
                               LUAS_BNG_SPPT AS LUAS_BNG,
                               NJOP_BNG_SPPT AS NJOP_BNG,
                               PBB_TERHUTANG_SPPT AS PBB_TERHUTANG,
                               FAKTOR_PENGURANG_SPPT AS FAKTOR_PENGURANG,
                               PBB_YG_HARUS_DIBAYAR_SPPT AS PBB_YG_HARUS_DIBAYAR,
                               CASE WHEN STATUS_PEMBAYARAN_SPPT = 0 THEN 'BELUM' WHEN STATUS_PEMBAYARAN_SPPT = 1 THEN 'LUNAS' ELSE 'UNKNOWN' END AS STATUS_PEMBAYARAN", false);
        $this->datatables->from('SPPT');
        $this->datatables->where("trim(NM_WP_SPPT) LIKE '%" .$this->db->escape_like_str($p_peps). "%'");
        echo $this->datatables->generate();
    }
}