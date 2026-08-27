<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class simulasi_sppt extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!is_login()) {
            echo "<script>window.location.replace('" . base_url() . "');</script>";
            exit;
        }

        $module = 'simulasi_sppt';
        $this->load->library('module_auth', array(
            'module' => $module
        ));

        $this->load->model(array(
            'apps_model', 'simulasi_sppt_model'
        ));

        $this->load->helper(active_module());
    }

    public function index() {
        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect('eadm_bogor');
        }

        $data['page_menu'] = 'simulasi_sppt';
        $data['current'] = '';
        $data['apps']    = $this->apps_model->get_active_only();
        $option = array( ''=> 'Semua Status','A' => 'Draft',
            '1' => 'Terima',
            '2' => 'Tolak');
        $js  = 'id="status_kd" style="width:130px;" class="form-control" ';
        $select = form_dropdown('status_kd', $option, '' , $js);
        $data['select_status'] = $select;

        $data['faction'] = active_module_url("simulasi_sppt/proses/");
        $data['dt']['nop'] = get_string('');
        $data['dt']['tahun'] = get_string('');
        $data['dt']['jatuh_tempo'] = get_string('');

        $this->load->view('vsimulasi_sppt', $data);
    }

    public function grid() {

        $status_kd = $this->input->get('status_kd');
        $this->load->library('Datatables');
        $this->datatables->select("KD_PROPINSI||'.'||KD_DATI2||'.'||KD_KECAMATAN||'.'||KD_KELURAHAN||'.'||KD_BLOK||'.'||NO_URUT||'.'||KD_JNS_OP AS NOP, 
                                    THN_PAJAK_SPPT, NM_WP_SPPT, JLN_WP_SPPT, TGL_JATUH_TEMPO_SPPT, 
                                    PBB_TERHUTANG_SPPT, FAKTOR_PENGURANG_SPPT, PBB_YG_HARUS_DIBAYAR_SPPT,
                                    FN_HIT_HKPD_ALL(PBB_YG_HARUS_DIBAYAR_SPPT,TGL_JATUH_TEMPO_SPPT,SYSDATE,'n') AS DENDA,
                                    PBB_YG_HARUS_DIBAYAR_SPPT + FN_HIT_HKPD_ALL(PBB_YG_HARUS_DIBAYAR_SPPT,TGL_JATUH_TEMPO_SPPT,SYSDATE,'n') AS TTL_BAYAR,
                                    KD_PROPINSI||KD_DATI2||KD_KECAMATAN||KD_KELURAHAN||KD_BLOK||NO_URUT||KD_JNS_OP||THN_PAJAK_SPPT AS NOPTHN", false);
        $this->datatables->from("SPPT_SIMULASI_TMP");

        $this->datatables->rupiah_column('5,6,7,8,9');
        $this->datatables->date_column('4');
        
        echo $this->datatables->generate();
    }

    private function fvalidation() {
        $this->form_validation->set_error_delimiters('<span>', '</span>');
        $this->form_validation->set_rules('nop', 'NOPX', 'required|trim|callback_cek_nop');
        $this->form_validation->set_rules('tahun', 'Tahun Pajak SPPT', 'required|trim');
        $this->form_validation->set_rules('jatuh_tempo', 'Jatuh Tempo SPPT', 'required');
    }

    public function cek_nop($value) {
        $nop = $this->input->post('nop');

        if ($this->simulasi_sppt_model->cek_nop($nop)) {
            return true;
        } else {
            $this->form_validation->set_message('cek_nop', 'NOP tidak terdaftar di DAT OBJEK PAJAK.....!');
            return false;
        }
    }

    private function fpost() {
        $data['rowid'] = post_string($this->input->post('rowid'));
        $data['nop'] = post_string($this->input->post('nop'));
        $data['tahun'] = post_string($this->input->post('tahun'));
        $data['jatuh_tempo'] = post_date($this->input->post('jatuh_tempo'));
        return $data;
    }

    public function proses() {
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
            redirect(active_module_url('simulasi_sppt'));
        }

        
        $post_data = $this->fpost();
        // echo $post_data['nop']; die();

        $data['page_menu'] = 'simulasi_sppt';
        $data['current'] = '';
        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = active_module_url("simulasi_sppt/proses/");

        $this->fvalidation();

        if ($this->form_validation->run() == true) {
            $nop        = $post_data['nop'];
            $nop        = str_replace(".", "", $nop);
            $nop        = str_replace("-", "", $nop);
            $kd_prop    = substr($nop, 0, 2);
            $kd_dati    = substr($nop, 2, 2);
            $kd_kec     = substr($nop, 4, 3);
            $kd_kel     = substr($nop, 7, 3);
            $kd_blok    = substr($nop, 10, 3);
            $no_urut    = substr($nop, 13, 4);
            $kd_jns_op  = substr($nop, 17, 1);

            $tahun      = $post_data['tahun'];
            $jttempo    = $post_data['jatuh_tempo'];
            $nip_pencetak = sipkd_user_nip();

            $qry_manuwal = "CALL SP_SIMULASI_SPPT('{$kd_prop}', '{$kd_dati}', '{$kd_kec}', '{$kd_kel}', '{$kd_blok}', '{$no_urut}', 
                        '{$kd_jns_op}', '{$tahun}', '{$jttempo}', '{$nip_pencetak}') ";

            // echo $qry_manuwal; die();
            $result = $this->db->simple_qry_eon_ora($qry_manuwal);

            // $result = '';
            if (!empty($result)) {
                set_msg_db_error($result);
            } else {

                $this->session->set_flashdata('msg_success', 'Data telah disimpan');
                redirect(active_module_url('simulasi_sppt'));
            }
        }

        $get = (object)$post_data;
        $data['dt'] = $post_data;

        $this->load->view('vsimulasi_sppt', $data);
    }

    public function detail() {
        $nopthn     = $this->uri->segment(4);
        $nopthn     = str_replace(".", "", $nopthn);
        $nopthn     = str_replace("-", "", $nopthn);

        $dt = $this->simulasi_sppt_model->get($nopthn);

        if ($dt){
            $njopkp         = (int)$dt->NJOP_SPPT - (int)$dt->NJOPTKP_SPPT;
            $njopkp_njkp    = $dt->NIL_NJKP/100*$njopkp;
            $selisih        = (int)$dt->PBB_YG_HARUS_DIBAYAR_SPPT - (int)$dt->JML_BAYAR;
            if($selisih < 0) {
                $selisih = 0;
            }
    
            $data['dt'] = array(
                'nop' => $dt->NOP_LKP, 
                'thn_pajak' => $dt->THN_PAJAK_SPPT, 
                'alamat_op' => $dt->JALAN_OP . ' ' . $dt->BLOK_KAV_NO_OP, 
                'rtrw_op' => $dt->RT_OP . '/' . $dt->RW_OP, 
                'kel_op' => $dt->NM_KELURAHAN, 
                'kec_op' => $dt->NM_KECAMATAN, 
                'kota_op' => 'DEPOK', 
                'nama_wp' => $dt->NM_WP_SPPT, 
                'alamat_wp' => $dt->JLN_WP_SPPT . ' ' . $dt->BLOK_KAV_NO_WP_SPPT, 
                'rtrw_wp' => $dt->RT_WP_SPPT . '/' . $dt->RW_WP_SPPT, 
                'kel_wp' => $dt->KELURAHAN_WP_SPPT, 
                'kota_wp' => $dt->KOTA_WP_SPPT, 
                'luas_bumi' => fmt_number($dt->LUAS_BUMI_SPPT), 
                'kelas_bumi' => $dt->KD_KLS_TANAH, 
                'njop_bumi_perm' => fmt_number($dt->NJOP_BUMI_PERM), 
                'njop_bumi' => fmt_number($dt->NJOP_BUMI_SPPT), 
                'luas_bng' => fmt_number($dt->LUAS_BNG_SPPT), 
                'kelas_bng' => $dt->KD_KLS_BNG, 
                'njop_bng_perm' => fmt_number($dt->NJOP_BNG_PERM), 
                'njop_bng' => fmt_number($dt->NJOP_BNG_SPPT), 
                'luas_bumi_bersama' => fmt_number($dt->LUAS_BUMI_BERSAMA), 
                'kelas_bumi_bersama' => $dt->KD_KLS_TANAH_BERSAMA, 
                'njop_bumi_perm_bersama' => fmt_number($dt->NJOP_BUMI_BERSAMA_PERM), 
                'njop_bumi_bersama' => fmt_number($dt->NJOP_BUMI_BERSAMA), 
                'luas_bng_bersama' => fmt_number($dt->LUAS_BNG_BERSAMA), 
                'kelas_bng_bersama' => $dt->KD_KLS_BNG_BERSAMA, 
                'njop_bng_perm_bersama' => fmt_number($dt->NJOP_BNG_BERSAMA_PERM), 
                'njop_bng_bersama' => fmt_number($dt->NJOP_BNG_BERSAMA), 
                'jml_njop_bumi' => fmt_number($dt->TTL_NJOP_BUMI), 
                'jml_njop_bng' => fmt_number($dt->TTL_NJOP_BNG), 
                'ttl_njop' => fmt_number($dt->NJOP_SPPT), 
                'njoptkp' => fmt_number($dt->NJOPTKP_SPPT), 
                'txt_c' => '(' . $dt->NIL_NJKP . ' % x ' . fmt_number($njopkp) . ' )' , 
                'njopkp' => fmt_number($njopkp_njkp), 
                'tarif' => $dt->NIL_TARIF . ' %', 
                'txt_e' => '(' . $dt->NIL_TARIF . ' % x ' . fmt_number($njopkp_njkp) . ' )' , 
                'pbb_terhutang' => fmt_number($dt->PBB_TERHUTANG_SPPT), 
                'faktor_pengurang' => fmt_number($dt->FAKTOR_PENGURANG_SPPT), 
                'txt_g' => '(' . fmt_number($dt->PBB_TERHUTANG_SPPT) . ' - ' . fmt_number($dt->FAKTOR_PENGURANG_SPPT) . ' )' , 
                'pbb_yg_harus_dibayar' => fmt_number($dt->PBB_YG_HARUS_DIBAYAR_SPPT), 
                'denda_yg_sudah_dibayar' => fmt_number($dt->BAYAR_DENDA), 
                'pbb_yg_sudah_dibayar' => fmt_number($dt->JML_BAYAR), 
                'selisih' => fmt_number($selisih), 
                'tgl_jttempo' => $dt->TGL_JTTEMPO, 
                'tgl_terbit' => $dt->TGL_TERBIT, 
                'tgl_cetak' => $dt->TGL_CETAK
            );

            $this->load->view('vsimulasi_sppt_detail', $data);

        } else {
            $this->session->set_flashdata('msg_success', 'Data tidak ditemukan..');
            redirect(active_module_url('simulasi_sppt'));
        }

    }


}
