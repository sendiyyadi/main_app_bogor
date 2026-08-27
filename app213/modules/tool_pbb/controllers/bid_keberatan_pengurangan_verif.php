<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class bid_keberatan_pengurangan_verif extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!is_login()) {
            echo "<script>window.location.replace('" . base_url() . "');</script>";
            exit;
        }

        $module = 'bid_keberatan_pengurangan_verif';
        $this->load->library('module_auth', array(
            'module' => $module
        ));

        $this->load->model(array(
            'apps_model', 'permohonan_online_upt_model'
        ));

        $this->load->helper(active_module());
    }

    public function index() {
        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect('tool_pbb');
        }

        $data['page_menu'] = 'bid_keberatan';
        $data['current'] = 'bid_keberatan_pengurangan_verif';
        $data['apps']    = $this->apps_model->get_active_only();
        $option = array( 
            '1' => 'Belum Proses',
            'B' => 'Approve PKP',
            'D' => 'Tolak PKP',);
        $js  = 'id="status_kd" class="form-control" ';
        $select = form_dropdown('status_kd', $option, '' , $js);
        $data['select_status_kd'] = $select;
        //------------------------------------------------------------------
        $select_data  = $this->permohonan_online_upt_model->get_jns_ply();
        $options     = array();
        $options = [
            '999999' => 'SILAKAN PILIH'
        ];
        if ($select_data) {
            foreach ($select_data as $row) {
                $options[$row->KD_JNS_PELAYANAN] = $row->NM_JENIS_PELAYANAN;
            }
        } else {
            $options['0'] = 'Data not found';
        }
        $js     = 'class="form-control" id="jns_ply" ';
        $select = form_dropdown('jns_ply', $options, '', $js);
        $select = preg_replace("/[\r\n]+/", "", $select);
        $data['select_jns_ply'] = $select;
        /////////////////////////////////////////////////////////////////


        $this->load->view('vbid_keberatan_pengurangan_verif', $data);
    }

    public function grid() {

        $tgl_fr = $this->input->get('tgl_fr');
        $tgl_to = $this->input->get('tgl_to');
        $jns_ply = $this->input->get('jns_ply');
        $thn_ply = $this->input->get('thn_ply');
        $bundel_ply = $this->input->get('bundel_ply');
        $urut_ply = $this->input->get('urut_ply');
        $nop = $this->input->get('nop');
        $sts_kd = $this->input->get('sts_kd');

        $this->load->library('Datatables');
        $this->datatables->select("	P.ID, P.THN_PELAYANAN||'-'||P.BUNDEL_PELAYANAN||'-'||P.NO_URUT_PELAYANAN as NOPEL,
                                    TO_CHAR(P.TGL_APR_LOKET,'DD-MM-YYYY') as TGL_APR,
                                    P.KD_PROPINSI_PEMOHON||P.KD_DATI2_PEMOHON||P.KD_KECAMATAN_PEMOHON||P.KD_KELURAHAN_PEMOHON||P.KD_BLOK_PEMOHON||P.NO_URUT_PEMOHON||P.KD_JNS_OP_PEMOHON AS NOP, 
                                    RP.NM_JENIS_PELAYANAN, 
                                    P.NAMA_PEMOHON, KEC.NM_KECAMATAN, KEL.NM_KELURAHAN,
                                    ST.KET AS STS,
									TO_CHAR(P.TGL_PERKIRAAN_SELESAI, 'DD-MM-YYYY') AS TGL_PERKIRAAN_SELESAI,
                                    P.THN_PELAYANAN||P.KD_PROPINSI_PEMOHON||P.KD_DATI2_PEMOHON||P.KD_KECAMATAN_PEMOHON||P.KD_KELURAHAN_PEMOHON||P.KD_BLOK_PEMOHON||P.NO_URUT_PEMOHON||P.KD_JNS_OP_PEMOHON||P.KD_JNS_PELAYANAN as NOPELNOP,
                                    P.STATUS_PERMOHONAN", false);
        $this->datatables->from("PST_PERMOHONAN_TOOL P");
        $this->datatables->join('REF_STATUS_PST ST', 'ST.KD = P.STATUS_PERMOHONAN');
        $this->datatables->join("TRACKING T", "P.THN_PELAYANAN=T.THN_PELAYANAN AND P.BUNDEL_PELAYANAN=T.BUNDEL_PELAYANAN AND P.NO_URUT_PELAYANAN=T.NO_URUT_PELAYANAN");
        $this->datatables->join('REF_JNS_PELAYANAN RP', 'RP.KD_JNS_PELAYANAN = P.KD_JNS_PELAYANAN', 'left');
        $this->datatables->join('REF_KECAMATAN KEC', 'KEC.KD_KECAMATAN = P.KD_KECAMATAN_PEMOHON');
        $this->datatables->join('REF_KELURAHAN KEL', 'KEL.KD_KECAMATAN = P.KD_KECAMATAN_PEMOHON AND KEL.KD_KELURAHAN = P.KD_KELURAHAN_PEMOHON');

        $this->datatables->where("P.KD_JNS_PELAYANAN", "08");
        // $this->datatables->where("P.STATUS_PERMOHONAN IN ('A', 'B', 'C', 'D')");

        $nip_login = sipkd_user_nip();
        if(!is_super_admin()) {
            $this->datatables->where("P.NIP_VER_PKP", $nip_login);
        }

        if(!empty($nop)){
            $nop = trim($nop);
            $nop = strtoupper($nop);
            $nop = str_replace('.', '', $nop);
            $nop = str_replace(' ', '', $nop);
            $nop = str_replace('-', '', $nop);
            $this->datatables->where("P.KD_PROPINSI_PEMOHON||P.KD_DATI2_PEMOHON||P.KD_KECAMATAN_PEMOHON||P.KD_KELURAHAN_PEMOHON||P.KD_BLOK_PEMOHON||P.NO_URUT_PEMOHON||P.KD_JNS_OP_PEMOHON like ('%".$nop."%')", false, false);
        }

        if(!empty($thn_ply)){
            $this->datatables->where("P.THN_PELAYANAN = '".$thn_ply."' ");
        }

        if(!empty($bundel_ply)){
            $this->datatables->where("P.BUNDEL_PELAYANAN = '".$bundel_ply."' ");
        }

        if(!empty($urut_ply)){
            $this->datatables->where("P.NO_URUT_PELAYANAN = '".$urut_ply."' ");
        }

        if(!empty($tgl_fr)){
            $this->datatables->where("TO_DATE(TO_CHAR(P.TGL_APR_LOKET,'yyyy-mm-dd'), 'yyyy-mm-dd') >= TO_DATE('".$tgl_fr."', 'dd-mm-yyyy')");
        }

        if(!empty($tgl_to)){
            $this->datatables->where("TO_DATE(TO_CHAR(P.TGL_APR_LOKET,'yyyy-mm-dd'), 'yyyy-mm-dd') <= TO_DATE('".$tgl_to."', 'dd-mm-yyyy')");
        }

        if(!empty($sts_kd)){
            if($sts_kd == '1'){
                $this->datatables->where("P.STATUS_PERMOHONAN IN ('8', 'C')");
            } else {
                $this->datatables->where("P.STATUS_PERMOHONAN", $sts_kd);
            }

        } else {
            $this->datatables->where("P.STATUS_PERMOHONAN IN ('8', 'C')");
        }

        // if(!empty($tgl_fr) && !empty($tgl_to)){
        //   $this->datatables->where("TO_DATE(TO_CHAR(P.TGL_SURAT_PERMOHONAN,'yyyy-mm-dd'), 'yyyy-mm-dd') BETWEEN TO_DATE('".$tgl_fr."', 'dd-mm-yyyy') AND TO_DATE('".$tgl_to."', 'dd-mm-yyyy')");
        // }
        
        // $this->datatables->rupiah_column('5,6,7,8,9');
        // $this->datatables->date_column('4');
        
        echo $this->datatables->generate();
    }

    private function fvalidation() {
        $this->form_validation->set_error_delimiters('<span>', '</span>');
        $this->form_validation->set_rules('nop', 'NOP', 'required|trim|callback_cek_nop');
        $this->form_validation->set_rules('thn_permohonan', 'Tahun Permohonan', 'required|trim');
    }

    private function fpost() {
        $data['id_reg_esppt'] = $this->input->post('id_reg_esppt');
        $data['nop_re'] = $this->input->post('nop_re');
        $data['nama_wp_re'] = $this->input->post('nama_wp_re');
        $data['alamat_op_re'] = $this->input->post('alamat_op_re');
        $data['nik_re'] = $this->input->post('nik_re');
        $data['no_telp_re'] = $this->input->post('no_telp_re');
        $data['nama_re'] = $this->input->post('nama_re');
        $data['email_re'] = $this->input->post('email_re');
        
        $data['id_ppo'] = post_string($this->input->post('id_ppo'));
        $data['nopel'] = $this->input->post('nopel');
        $data['nop'] = post_string($this->input->post('nop'));
        $data['nopel'] = $this->input->post('nopel');
        $data['jns_ply'] = $this->input->post('jns_ply');
        $data['no_permohonan'] = $this->input->post('no_permohonan');
        $data['thn_permohonan'] = $this->input->post('thn_permohonan');
        $data['tgl_permohonan'] = $this->input->post('tgl_permohonan');
        $data['nama_pemohon'] = $this->input->post('nama_pemohon');
        $data['alamat_pemohon'] = $this->input->post('alamat_pemohon');
        $data['telp'] = $this->input->post('telp');
        $data['keterangan'] = $this->input->post('keterangan');
        
        return $data;
    }

    public function detail() {
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_error', $this->module_auth->msg_read);
            redirect('tool_pbb');
        }

        $param     = $this->uri->segment(4);

        // //// cek heula
        // $qr_cek = "SELECT COUNT(*) AS JML FROM PST_PERMOHONAN_TOOL WHERE ID = ? AND STATUS_PERMOHONAN = 1";
        // $cek_heula = $this->db->query($qr_cek, [$param])->row()->JML;

        // if ($cek_heula > 0) {
        //     $this->session->set_flashdata('msg_info', "Data sudah dikirim. Tidak bisa edit data");
        //     redirect('tool_pbb/bid_keberatan_pengurangan_verif');
        // }

        $data['page_menu'] = 'bid_keberatan';
        $data['current'] = 'bid_keberatan_pengurangan_verif';
        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = '';
        
        $x = $this->permohonan_online_upt_model->get_ppo_by_id($param);

        if ($x){

            $dt = $this->permohonan_online_upt_model->get_dt_pengurangan($param);
        
            $data['dt'] = array(
                'nop_re' => $x->NOP_LKP, 
                'id_reg_esppt' => $x->NOPNIK, 
                'nama_wp_re' => $x->NAMA_WP_REG, 
                'alamat_op_re' => $x->ALAMAT_REG, 
                'nik_re' => $x->NIK_REG, 
                'no_telp_re' => $x->TELP_REG,
                'nama_re' => $x->NAMA_REG, 
                'email_re' => $x->EMAIL_REG,
                'ket_pst' => $x->ALASAN,

                'rowid' => $x->PPO_ID, 
                'id_ppo' => $x->PPO_ID, 
                'nopel' => $x->NOPEL, 
                'no_permohonan' => $x->NO_SRT_PERMOHONAN, 
                'thn_permohonan' => $x->THN_PAJAK_PERMOHONAN, 
                'nop' => $x->NOP_LKP, 
                'tgl_permohonan' => get_date($x->TGL_SURAT_PERMOHONAN), 
                'nama_pemohon' => $x->NAMA_PEMOHON, 
                'alamat_pemohon' => $x->ALAMAT_PEMOHON, 
                'telp' => $x->NO_HP, 
                'keterangan' => $x->KETERANGAN_PST, 
                'kd_jns_ply' => $x->KD_JNS_PELAYANAN,

                'jns_png' => $dt->NM_SUB_JENIS_PELAYANAN,
                'pct_png' => $dt->PCT_PENGURANGAN,
                'pct_png_disetujui' => $dt->PCT_PENGURANGAN_APPR,

            );

            $data['da'] = (array)$dt;

            $data['fnopnik'] = $x->NOPNIK;

            //---------------------------------------------------------------------------------------------------------
            $opt['1'] = 'DISETUJUI';
            $opt['2'] = 'DITOLAK';
            $opt['3'] = 'DITERIMA SEBAGIAN';
            // $js     = 'id="jns_ply" required style="width:90%; height:100% !important;" onchange="jns_ply_chg(this.value)" ';
            $js     = 'class="form-control" id="sts_pengurangan" ';
            $select = form_dropdown('sts_pengurangan', $opt, $dt->STS_PENGURANGAN, $js);
            $select = preg_replace("/[\r\n]+/", "", $select);
            $data['select_sts_pengurangan'] = $select;
            //---------------------------------------------------------------------------------------------------------
            $select_data  = $this->permohonan_online_upt_model->get_jns_ply($x->KD_JNS_PELAYANAN);
            if ($select_data) {
                foreach ($select_data as $row) {
                    $options[$row->KD_JNS_PELAYANAN] = $row->NM_JENIS_PELAYANAN;
                }
            } else {
                $options['0'] = 'Data not found';
            }
            $js     = 'class="form-control" id="jns_ply" readonly ';
            $select = form_dropdown('jns_ply', $options, $x->KD_JNS_PELAYANAN, $js);
            $select = preg_replace("/[\r\n]+/", "", $select);
            $data['select_jns_ply'] = $select;
            //---------------------------------------------------------------------------------------------------------
            $select_data_sub  = $this->permohonan_online_upt_model->get_sub_jns_ply($x->KD_JNS_PELAYANAN, $x->KD_SUB_JNS_PELAYANAN);
            if ($select_data_sub) {
                foreach ($select_data_sub as $row) {
                    $optionsub[$row->KD_SUB_JNS_PELAYANAN] = $row->NM_SUB_JENIS_PELAYANAN;
                }
            } else {
                $optionsub['0'] = 'Data not found';
            }
            $js     = 'class="form-control" id="sub_jns_ply" readonly ';
            $select = form_dropdown('sub_jns_ply', $optionsub, $x->KD_SUB_JNS_PELAYANAN, $js);
            $select = preg_replace("/[\r\n]+/", "", $select);
            $data['select_sub_jns_ply'] = $select;
            //---------------------------------------------------------------------------------------------------------

            $syarat_peneliti = $this->permohonan_online_upt_model->get_ref_syarat_peneliti_by_idppo($x->PPO_ID, '08');
            $data['syarat'] = $syarat_peneliti;
            $data['mode']   = 'view';

            $this->load->view('vbid_keberatan_pengurangan_verif_form', $data);

        } else {
            $this->session->set_flashdata('msg_error', 'Data tidak ditemukan..');
            redirect(active_module_url('bid_keberatan_pengurangan_verif'));
        }

    }

    public function edit() {
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_error', $this->module_auth->msg_read);
            redirect('tool_pbb');
        }

        $param     = $this->uri->segment(4);

        //// cek heula
        $qr_cek = "SELECT COUNT(*) AS JML FROM PST_PERMOHONAN_TOOL WHERE ID = ? AND STATUS_PERMOHONAN not in ('8', 'C')";
        $cek_heula = $this->db->query($qr_cek, [$param])->row()->JML;

        if ($cek_heula > 0) {
            $this->session->set_flashdata('msg_info', "Data sudah diproses. Tidak bisa edit data");
            redirect('tool_pbb/bid_keberatan_pengurangan_verif');
        }

        $data['page_menu'] = 'bid_keberatan';
        $data['current'] = 'bid_keberatan_pengurangan_verif';
        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = '';
        
        $x = $this->permohonan_online_upt_model->get_ppo_by_id($param);

        if ($x){

            $dt = $this->permohonan_online_upt_model->get_dt_pengurangan($param);
    
            $data['dt'] = array(
                'nop_re' => $x->NOP_LKP, 
                'id_reg_esppt' => $x->NOPNIK, 
                'nama_wp_re' => $x->NAMA_WP_REG, 
                'alamat_op_re' => $x->ALAMAT_REG, 
                'nik_re' => $x->NIK_REG, 
                'no_telp_re' => $x->TELP_REG,
                'nama_re' => $x->NAMA_REG, 
                'email_re' => $x->EMAIL_REG,
                'ket_pst' => $x->ALASAN,

                'rowid' => $x->PPO_ID, 
                'id_ppo' => $x->PPO_ID, 
                'nopel' => $x->NOPEL, 
                'no_permohonan' => $x->NO_SRT_PERMOHONAN, 
                'thn_permohonan' => $x->THN_PAJAK_PERMOHONAN, 
                'nop' => $x->NOP_LKP, 
                'tgl_permohonan' => get_date($x->TGL_SURAT_PERMOHONAN), 
                'nama_pemohon' => $x->NAMA_PEMOHON, 
                'alamat_pemohon' => $x->ALAMAT_PEMOHON, 
                'telp' => $x->NO_HP, 
                'keterangan' => $x->KETERANGAN_PST, 
                'kd_jns_ply' => $x->KD_JNS_PELAYANAN,

                'jns_png' => $dt->NM_SUB_JENIS_PELAYANAN,
                'pct_png' => $dt->PCT_PENGURANGAN,
                'pct_png_disetujui' => $dt->PCT_PENGURANGAN_APPR,

            );

            $data['da'] = (array)$dt;

            $data['fnopnik'] = $x->NOPNIK;

            //---------------------------------------------------------------------------------------------------------
            $opt['1'] = 'DISETUJUI';
            $opt['2'] = 'DITOLAK';
            $opt['3'] = 'DITERIMA SEBAGIAN';
            // $js     = 'id="jns_ply" required style="width:90%; height:100% !important;" onchange="jns_ply_chg(this.value)" ';
            $js     = 'class="form-control" id="sts_pengurangan" ';
            $select = form_dropdown('sts_pengurangan', $opt, $dt->STS_PENGURANGAN, $js);
            $select = preg_replace("/[\r\n]+/", "", $select);
            $data['select_sts_pengurangan'] = $select;
            //---------------------------------------------------------------------------------------------------------
            $select_data  = $this->permohonan_online_upt_model->get_jns_ply($x->KD_JNS_PELAYANAN);
            if ($select_data) {
                foreach ($select_data as $row) {
                    $options[$row->KD_JNS_PELAYANAN] = $row->NM_JENIS_PELAYANAN;
                }
            } else {
                $options['0'] = 'Data not found';
            }
            // $js     = 'id="jns_ply" required style="width:90%; height:100% !important;" onchange="jns_ply_chg(this.value)" ';
            $js     = 'class="form-control" id="jns_ply" readonly ';
            $select = form_dropdown('jns_ply', $options, $x->KD_JNS_PELAYANAN, $js);
            $select = preg_replace("/[\r\n]+/", "", $select);
            $data['select_jns_ply'] = $select;
            //---------------------------------------------------------------------------------------------------------
            $select_data_sub  = $this->permohonan_online_upt_model->get_sub_jns_ply($x->KD_JNS_PELAYANAN, $x->KD_SUB_JNS_PELAYANAN);
            if ($select_data_sub) {
                foreach ($select_data_sub as $row) {
                    $optionsub[$row->KD_SUB_JNS_PELAYANAN] = $row->NM_SUB_JENIS_PELAYANAN;
                }
            } else {
                $optionsub['0'] = 'Data not found';
            }
            $js     = 'class="form-control" id="sub_jns_ply" readonly ';
            $select = form_dropdown('sub_jns_ply', $optionsub, $x->KD_SUB_JNS_PELAYANAN, $js);
            $select = preg_replace("/[\r\n]+/", "", $select);
            $data['select_sub_jns_ply'] = $select;
            //---------------------------------------------------------------------------------------------------------

            $syarat_peneliti = $this->permohonan_online_upt_model->get_ref_syarat_peneliti_by_idppo($x->PPO_ID, '08');
            $data['syarat'] = $syarat_peneliti;
            $data['mode']   = 'add';

            $this->load->view('vbid_keberatan_pengurangan_verif_form', $data);

        } else {
            $this->session->set_flashdata('msg_error', 'Data tidak ditemukan..');
            redirect(active_module_url('bid_keberatan_pengurangan_verif'));
        }

    }

    function approve_permohonan() {
        $nop        = $this->input->post('nop');
        $nop        = str_replace(".", "", $nop);
        $nop        = str_replace("-", "", $nop);

        $prop_kd = substr($nop, 0, 2);
        $kab_kd  = substr($nop, 2, 2);
        $kec_kd  = substr($nop, 4, 3);
        $kel_kd  = substr($nop, 7, 3);
        $blok_kd = substr($nop, 10, 3);
        $urut_no = substr($nop, 13, 4);
        $jns_kd  = substr($nop, 17, 1);

        $id_ppo         = $this->input->post('id_ppo');
        $thn_awal       = $this->input->post('tahun_awal');
        $thn_akhir      = $this->input->post('tahun_akhir');

        $thn_permo      = $this->input->post('thn_permohonan');

        $tgl_sk         = $this->input->post('tgl_sk');
        $uraian_1       = strtoupper($this->input->post('uraian_1'));
        $uraian_2       = strtoupper($this->input->post('uraian_2'));

        $pct_appr       = strtoupper($this->input->post('pct_png_disetujui'));
        $sts_png        = $this->input->post('sts_pengurangan');

        $nip_pencetak   = sipkd_user_nip();
        $nip_pencetak_sk= sipkd_user_nip();

        // // validasi server-side
        // if (!preg_match('/^[0-9]{4}$/', $thn_awal) || 
        //     !preg_match('/^[0-9]{4}$/', $thn_akhir)) {

        //     echo json_encode([
        //         'result' => 400,
        //         'msg' => 'Tahun harus 4 digit angka'
        //     ]);
        //     return;
        // }

        //// cek heula
        $qr_cek = "SELECT COUNT(*) AS JML FROM PST_PERMOHONAN_TOOL WHERE ID = ? AND STATUS_PERMOHONAN <> '8'";
        $cek_heula = $this->db->query($qr_cek, [$id_ppo])->row()->JML;

        if ($cek_heula > 0) {
            $this->session->set_flashdata('msg_info', "Data sudah diproses bidang keberatan. Harap refresh halaman");

            echo json_encode([
                'result' => 302,
                'redirect' => active_module_url('bid_keberatan_pengurangan_verif')
            ]);
            return;
        }

        $dt = $this->permohonan_online_upt_model->get_ppo_by_id($id_ppo);
        if ($dt) {

            //ambil dari pst_tool -> urut_sk dan thn_sk dari thn akhir no_bap
            $new_thn_sk = $dt->THN_SK;
            $new_urut_sk = $dt->URUT_SK;

            $ins_no_bap = '977/' . str_pad($new_urut_sk, 6, "0", STR_PAD_LEFT) . '/PENGURANGAN/' . bulan_romawi(date('m')) . '/' . $new_thn_sk;
            $tgl_bap = date('Y-m-d');

            //// get nik untuk pegawai (looping)
            $id_next_pgw = 0;
            $kdjns = $dt->KD_JNS_PELAYANAN; 
            $kdsub = $dt->KD_SUB_JNS_PELAYANAN ?: null;
            $jns_bid = '2C';
            $get_dt_pegawai = $this->permohonan_online_upt_model->get_next_pegawai($jns_bid, $kdjns);
            $id_next_pgw = $get_dt_pegawai->ID;
            $nip_next_pgw = $get_dt_pegawai->NIP;

            $dt_pst = array(
                'NO_BAP_LAPANGAN' => $ins_no_bap,
                'TGL_BAP_LAPANGAN' => $tgl_bap,
                'STATUS_PERMOHONAN' => '9',
                'PCT_PENGURANGAN_APPR' => $pct_appr,
                'STS_PENGURANGAN' => $sts_png,
                'NIP_SUBID_PKP'     => $nip_next_pgw,
                'TGL_VER_PKP'       => current_time_ora(),
            );

            //// UPDATE DATA PST PERMOHONAN TOOL
            $this->permohonan_online_upt_model->update_data_permohonan_online_by_id($id_ppo, $dt_pst);

            //// update status ke pegawai baru
            $this->permohonan_online_upt_model->set_next_pegawai($id_next_pgw, $jns_bid, $kdjns);

            //// INSERT KE TBL PST_TOOL_DTL_PNLT
            $id_refs = $this->input->post('id_ref'); // kirim dari form hidden input
            $status  = $this->input->post('status'); // array
            $ket     = strtoupper($this->input->post('ket'));    // array

            $data_insert = [];

            // foreach ($status as $id_ref => $val_status) {
            foreach ($id_refs as $id_ref) {
                $val_status = isset($status[$id_ref]) ? $status[$id_ref] : null;

                $data_insert[] = [
                    'ID_PPO'         => $id_ppo,
                    'ID_REF_SYARAT'  => $id_ref,
                    'STATUS'         => $val_status, // Y / T / NULL
                    'KETERANGAN'     => $ket[$id_ref] ?? null
                ];
            }

            $this->db->insert_batch('PST_TOOL_DTL_PNLT', $data_insert);

            //// update tracking
            $sql_tracking = "UPDATE TRACKING SET KET_ARSIP=(SELECT NAMA FROM CLAPPPDN WHERE KODE='O'), 
            CL_APP_PDN='O', UPDATETIME=SYSDATE 
            WHERE THN_PELAYANAN||BUNDEL_PELAYANAN||NO_URUT_PELAYANAN IN 
            (SELECT THN_PELAYANAN||BUNDEL_PELAYANAN||NO_URUT_PELAYANAN FROM PST_PERMOHONAN_TOOL WHERE ID = {$id_ppo}) ";

            $error_msg_2 = $this->db->simple_qry_eon_ora($sql_tracking);
            $err_Msg_2 = $error_msg_2['message'];

            // $err_Msg_2 = null;
            if (!empty($err_Msg_2)) {
                $error_CRUD = $err_Msg_2 . ', Proses Approve Bidang Keberatan gagal....!!!';
                $res_msg    = $error_CRUD;
                $res_code   = 500;
            } else {
                $res_msg    = 'Data berhasil diapprove bidang keberatan';
                $res_code   = 200;
            }
                
            echo json_encode([
                'result' => $res_code,
                'msg' => $res_msg
            ]);
            return;

        }  else {
            $this->session->set_flashdata('msg_error', 'Data tidak ditemukan..');
            
            echo json_encode([
                'result' => 302,
                'redirect' => active_module_url('bid_keberatan_pengurangan_verif')
            ]);
            return;
        }

    }

    function tolak_permohonan() {
        $nop        = $this->input->post('nop');
        $nop        = str_replace(".", "", $nop);
        $nop        = str_replace("-", "", $nop);

        $prop_kd = substr($nop, 0, 2);
        $kab_kd  = substr($nop, 2, 2);
        $kec_kd  = substr($nop, 4, 3);
        $kel_kd  = substr($nop, 7, 3);
        $blok_kd = substr($nop, 10, 3);
        $urut_no = substr($nop, 13, 4);
        $jns_kd  = substr($nop, 17, 1);

        $id_ppo         = $this->input->post('id_ppo');
        $thn_awal       = $this->input->post('tahun_awal');
        $thn_akhir      = $this->input->post('tahun_akhir');

        $thn_permo      = $this->input->post('thn_permohonan');

        $tgl_sk         = $this->input->post('tgl_sk');
        $uraian_1       = strtoupper($this->input->post('uraian_1'));
        $uraian_2       = strtoupper($this->input->post('uraian_2'));
        $nip_pencetak   = sipkd_user_nip();
        $nip_pencetak_sk= sipkd_user_nip();

        //// cek heula
        $qr_cek = "SELECT COUNT(*) AS JML FROM PST_PERMOHONAN_TOOL WHERE ID = ? AND STATUS_PERMOHONAN not in ('A', 'C')";
        $cek_heula = $this->db->query($qr_cek, [$id_ppo])->row()->JML;

        if ($cek_heula > 0) {
            $this->session->set_flashdata('msg_info', "Data sudah diproses bidang keberatan. Harap refresh halaman");

            echo json_encode([
                'result' => 302,
                'redirect' => active_module_url('bid_keberatan_pengurangan_verif')
            ]);
            return;
        }

        $dt = $this->permohonan_online_upt_model->get_ppo_by_id($id_ppo);
        if ($dt) {

            //ambil dari pst_tool -> urut_sk dan thn_sk dari thn akhir no_bap
            $new_thn_sk = $dt->THN_SK;
            $new_urut_sk = $dt->URUT_SK;

            $ins_no_bap = '000.1.6/' . str_pad($new_urut_sk, 6, "0", STR_PAD_LEFT) . '/PEMBETULAN-PKP/' . bulan_romawi(date('m')) . '/' . $new_thn_sk;

            $tgl_bap = date('Y-m-d');

            $dt_pst = array(
                'NO_BAP_LAPANGAN' => $ins_no_bap,
                'TGL_BAP_LAPANGAN' => $tgl_bap,
                'STATUS_PERMOHONAN' => 'D',
                'PCT_PENGURANGAN_APPR' => null,
                'STS_PENGURANGAN' => 2,
            );

            //// UPDATE DATA PST PERMOHONAN TOOL
            $this->permohonan_online_upt_model->update_data_permohonan_online_by_id($id_ppo, $dt_pst);

            //// update tracking
            $sql_tracking = "UPDATE TRACKING SET KET_ARSIP=(SELECT NAMA FROM CLAPPPDN WHERE KODE='R'), 
            CL_APP_PDN='R', UPDATETIME=SYSDATE 
            WHERE THN_PELAYANAN||BUNDEL_PELAYANAN||NO_URUT_PELAYANAN IN 
            (SELECT THN_PELAYANAN||BUNDEL_PELAYANAN||NO_URUT_PELAYANAN FROM PST_PERMOHONAN_TOOL WHERE ID = {$id_ppo}) ";

            $error_msg_2 = $this->db->simple_qry_eon_ora($sql_tracking);
            $err_Msg_2 = $error_msg_2['message'];

            // $err_Msg_2 = null;
            if (!empty($err_Msg_2)) {
                $error_CRUD = $err_Msg_2 . ', Proses Tolak Bidang Keberatan gagal....!!!';
                $res_msg    = $error_CRUD;
                $res_code   = 500;
            } else {
                $res_msg    = 'Data berhasil ditolak bidang keberatan';
                $res_code   = 200;
            }
                
            echo json_encode([
                'result' => $res_code,
                'msg' => $res_msg
            ]);
            return;

        }  else {
            $this->session->set_flashdata('msg_error', 'Data tidak ditemukan..');
            
            echo json_encode([
                'result' => 302,
                'redirect' => active_module_url('bid_keberatan_pengurangan_verif')
            ]);
            return;
        }

    }

    function update_prm_blob($id_ppo) { 
        $im_l_verlap1 = '';
        $im_l_verlap2 = '';
        $im_l_verlap3 = '';
        $fl_blob = array();
        $tbl_field = array();
        $tbl_field_return = array();
        $return_blob = array();
        if (!empty($_FILES['im_l_verlap1']['name'])) {
            array_push($tbl_field, 'L_VERLAP11=EMPTY_BLOB()');
            array_push($fl_blob, 'L_VERLAP1=1');
            array_push($tbl_field_return, 'L_VERLAP11');
            array_push($return_blob, ':blob1');
            $im_l_verlap1 = file_get_contents($_FILES['im_l_verlap1']['tmp_name']);
        }
        if (!empty($_FILES['im_l_verlap2']['name'])) {
            array_push($tbl_field, 'L_VERLAP21=EMPTY_BLOB()');
            array_push($fl_blob, 'L_VERLAP2=1');
            array_push($tbl_field_return, 'L_VERLAP21');
            array_push($return_blob, ':blob2');
            $im_l_verlap2 = file_get_contents($_FILES['im_l_verlap2']['tmp_name']);
        }
        // if (!empty($_FILES['im_l_verlap3']['name'])) {
        //     array_push($tbl_field, 'L_VERLAP31=EMPTY_BLOB()');
        //     array_push($fl_blob, 'L_VERLAP3=1');
        //     array_push($tbl_field_return, 'L_VERLAP31');
        //     array_push($return_blob, ':blob3');
        //     $im_l_verlap3 = file_get_contents($_FILES['im_l_verlap3']['tmp_name']);
        // }

        $fl_blob_impl = implode(', ', $fl_blob);
        $tbl_field_impl = implode(', ', $tbl_field);
        $tbl_field_return_impl = implode(', ', $tbl_field_return);
        $return_blob_impl = implode(', ', $return_blob);
        $dbhost = DB_HOST;
        $dbport = DB_PORT;
        $dbname = DB_NAME;
        $dbuser = DB_USER;
        $dbpass = DB_PASS;
        $tnslistener = '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=' . $dbhost . ')(PORT=' . $dbport . '))(CONNECT_DATA=(SID=' . $dbname . ')))';
        
        $connection = oci_connect($dbuser, $dbpass, $tnslistener);
        $qq = "UPDATE PST_PERMOHONAN_TOOL SET {$fl_blob_impl}, {$tbl_field_impl} 
               WHERE ID={$id_ppo} 
               RETURNING {$tbl_field_return_impl} INTO {$return_blob_impl}";
        $result = oci_parse($connection, $qq);
        if (!empty($_FILES['im_l_verlap1']['name'])) {
            $blob1 = oci_new_descriptor($connection, OCI_D_LOB);
            oci_bind_by_name($result, ":blob1", $blob1, -1, OCI_B_BLOB);
        }
        if (!empty($_FILES['im_l_verlap2']['name'])) {
            $blob2 = oci_new_descriptor($connection, OCI_D_LOB);
            oci_bind_by_name($result, ":blob2", $blob2, -1, OCI_B_BLOB);
        }
        // if (!empty($_FILES['im_l_verlap3']['name'])) {
        //     $blob3 = oci_new_descriptor($connection, OCI_D_LOB);
        //     oci_bind_by_name($result, ":blob3", $blob3, -1, OCI_B_BLOB);
        // }

        oci_execute($result, OCI_DEFAULT) or die("Unable to execute query; <br>" . $qq . '<br> Keterangan Error: <br>' . $err);
        if (!empty($_FILES['im_l_verlap1']['name'])) {
            // $blob12 = oci_new_descriptor($connection, OCI_D_LOB);
            // oci_bind_by_name($result, ":blob12", $blob12, -1, OCI_B_BLOB);
            $blob1->save($im_l_verlap1);
        }
        if (!empty($_FILES['im_l_verlap2']['name'])) {
            // $blob13 = oci_new_descriptor($connection, OCI_D_LOB);
            // oci_bind_by_name($result, ":blob13", $blob13, -1, OCI_B_BLOB);
            $blob2->save($im_l_verlap2);
        }
        // if (!empty($_FILES['im_l_verlap3']['name'])) {
        //     // $blob14 = oci_new_descriptor($connection, OCI_D_LOB);
        //     // oci_bind_by_name($result, ":blob14", $blob14, -1, OCI_B_BLOB);
        //     $blob3->save($im_l_verlap3);
        // }
        oci_commit($connection);
    }

    public function openblob_permo() {
        $field  = $this->uri->segment(4);
        $id_ppo    = $this->uri->segment(5);
        $field  = strtoupper($field);

        $dbhost = DB_HOST;
        $dbport = DB_PORT;
        $dbname = DB_NAME;
        $dbuser = DB_USER;
        $dbpass = DB_PASS;

        $tnslistener = '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST='.DB_HOST.')(PORT='.DB_PORT.'))(CONNECT_DATA=(SERVICE_NAME='.DB_NAME.')))';

        $connection = oci_connect($dbuser, $dbpass, $tnslistener);

        $sql = "SELECT {$field} FROM PST_PERMOHONAN_TOOL
                WHERE ID = '{$id_ppo}' ";

        $stid = oci_parse($connection, $sql);

        oci_execute($stid);
        $row = oci_fetch_array($stid, OCI_RETURN_NULLS);

        // var_dump($row); 
        // echo $row[$field];
        // die();

        if (!$row) {
            // header('Status: 404 Not Found');
            echo '404 Not Found';
        } else {
            if ($row[$field]) {
                $img = $row[$field]->load();
                $pdf_cek = strpos($img, 'PDF');
                if(empty($pdf_cek)){
                    $gambar = base64_encode($img);
                    echo "<img src='data:image;base64,$gambar' width='500' height='auto' >";
                }else{
                header("Content-type: application/pdf");
                print $img;
                }
            } else {
                echo 'Data Lampiran tidak ditemukan...';
            }
        }
    }

    function btn_file($field, $id_ppo) { 
        $url = active_module_url() . 'bid_keberatan_pengurangan_verif/openblob_permo/' . $field . '/' . $id_ppo;
        $btn = '<a target="_blank" href="' . $url . '" class="btn btn-primary " data-toggle="tooltip" title="View"></i> Lihat File</a>';
        return $btn;
    }

    function cetak_sk_tolak(){
        $rpt = 'sk_tolak_pembetulan';
        $id_ppo = $this->uri->segment(4);

        $qs   = urldecode ($_SERVER['QUERY_STRING']);
        parse_str($qs, $qs_data);
        $type = 'pdf';
        
        $params = array(
            'id_ppo' => $id_ppo,
            'logo_bogor' => FCPATH . 'assets/img/img_logo.png',
        );

        // $rpt = 'catatan_pembayaran_rpt';
        // include 'query_r713.php';

        $jasper = $this->load->library('Jasper_ora');
        // echo $jasper->cetak_ora($rpt, $params, $type, false);
        echo $jasper->cetak_ora($rpt, $params, 'pdf', false);
        
    }

    function tolak_ke_pelayanan() {
        $p_id               = $this->input->post('id_ppo');
        $ket_tolak_ply      = strtoupper($this->input->post('ket_tolak_ply'));

        if ($p_id && $get = $this->permohonan_online_upt_model->get_ppo_by_id($p_id)) {
            $dt_pst = array(
                'STATUS_PERMOHONAN' => 'E',
                'ALASAN'            => $ket_tolak_ply,
            );

            //// UPDATE DATA PST PERMOHONAN TOOL
            $this->permohonan_online_upt_model->update_pst_permohonan_tool($p_id, $dt_pst);

            //// update tracking
            $sql_tracking = "UPDATE TRACKING SET KET_ARSIP=(SELECT NAMA FROM CLAPPPDN WHERE KODE='P'), 
            CL_APP_PDN='P', UPDATETIME=SYSDATE 
            WHERE THN_PELAYANAN||BUNDEL_PELAYANAN||NO_URUT_PELAYANAN IN 
            (SELECT THN_PELAYANAN||BUNDEL_PELAYANAN||NO_URUT_PELAYANAN FROM PST_PERMOHONAN_TOOL WHERE ID = {$p_id}) ";

            $error_msg_2 = $this->db->simple_qry_eon_ora($sql_tracking);
            $err_Msg_2 = $error_msg_2['message'];

            if (!empty($err_Msg_2)) {
                $error_CRUD = $err_Msg_2 . ', Proses gagal....!!!';
                echo $error_CRUD;
            } else {
                //// panggil send smtp di model wkwkwk
                $mails = $this->permohonan_online_upt_model->send_email_tolak($p_id, $ket_tolak_ply);
                if($mails) {
                    echo 'Tolak data berhasil (Berhasil Kirim email ke WP)';
                } else {
                    echo 'Tolak data berhasil (Gagal Kirim email ke WP)';
                }
            }

        } else {
            echo 'ERROR.. Data tidak ditemukan... silakan muat ulang halaman';
        }
    }


}
