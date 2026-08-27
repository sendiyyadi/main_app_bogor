<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class permohonan_online_upt extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!is_login()) {
            echo "<script>window.location.replace('" . base_url() . "');</script>";
            exit;
        }

        $module = 'permohonan_online_upt';
        $this->load->library('module_auth', array(
            'module' => $module
        ));

        $this->load->model(array(
            'apps_model', 'permohonan_online_upt_model'
        ));

        $this->load->helper(active_module());
    }

    function fpost() {
        $data['nopel'] = trim_quotes($this->input->post('nopel'));
        $data['jns_ply'] = trim_quotes($this->input->post('jns_ply'));
        $data['no_permohonan'] = trim_quotes($this->input->post('no_permohonan'));
        $data['tgl_permohonan'] = empty($this->input->post('tgl_permohonan')) ? date('d-m-Y') : $this->input->post('tgl_permohonan');
        $data['thn_permohonan'] = trim_quotes($this->input->post('thn_permohonan'));
        $data['nop'] = trim_quotes($this->input->post('nop'));
        $data['nama_pemohon'] = trim_quotes($this->input->post('nama_pemohon'));
        $data['alamat_pemohon'] = trim_quotes($this->input->post('alamat_pemohon'));
        $data['telp'] = $this->input->post('telp');
        $data['keterangan'] = trim_quotes($this->input->post('keterangan'));
        
        $data['id_reg_esppt'] = trim_quotes($this->input->post('id_reg_esppt'));
        $data['nop_re'] = trim_quotes($this->input->post('nop_re'));
        $data['nama_wp_re'] = trim_quotes($this->input->post('nama_wp_re'));
        $data['alamat_op_re'] = trim_quotes($this->input->post('alamat_op_re'));
        $data['nik_re'] = trim_quotes($this->input->post('nik_re'));
        $data['no_telp_re'] = trim_quotes($this->input->post('no_telp_re'));
        $data['nama_re'] = trim_quotes($this->input->post('nama_re'));
        $data['email_re'] = trim_quotes($this->input->post('email_re'));

        $data['jln_op_sppt'] = trim_quotes($this->input->post('jln_op_sppt'));
        $data['blok_kav_no_op_sppt'] = trim_quotes($this->input->post('blok_kav_no_op_sppt'));
        $data['kecamatan_op_nama'] = trim_quotes($this->input->post('kecamatan_op_nama'));
        $data['kelurahan_op_nama'] = trim_quotes($this->input->post('kelurahan_op_nama'));
        $data['rt_op_sppt'] = trim_quotes($this->input->post('rt_op_sppt'));
        $data['rw_op_sppt'] = trim_quotes($this->input->post('rw_op_sppt'));
        $data['nop_lengkap'] = trim_quotes($this->input->post('nop_lengkap'));
        $data['kd_znt'] = trim_quotes($this->input->post('kd_znt'));

        $data['loginname'] = trim_quotes($this->input->post('loginname'));
        $data['passwd'] = trim_quotes($this->input->post('passwd'));

        $data['nik'] = trim_quotes($this->input->post('nik'));
        $data['nik_wp_sppt'] = trim_quotes($this->input->post('nik_wp_sppt'));
        $data['nm_wp_sppt'] = trim_quotes($this->input->post('nm_wp_sppt'));
        $data['jln_wp_sppt'] = trim_quotes($this->input->post('jln_wp_sppt'));
        $data['blok_kav_no_op_sppt'] = trim_quotes($this->input->post('blok_kav_no_op_sppt'));
        $data['rt_wp_sppt'] = trim_quotes($this->input->post('rt_wp_sppt'));
        $data['rw_wp_sppt'] = trim_quotes($this->input->post('rw_wp_sppt'));
        $data['kelurahan_wp_sppt'] = trim_quotes($this->input->post('kelurahan_wp_sppt'));
        $data['kota_wp_sppt'] = trim_quotes($this->input->post('kota_wp_sppt'));
        $data['kodepos_wp_sppt'] = trim_quotes($this->input->post('kodepos_wp_sppt'));
        $data['npwp_wp_sppt'] = trim_quotes($this->input->post('npwp_wp_sppt'));
        $data['nohp_wp_sppt'] = trim_quotes($this->input->post('nohp_wp_sppt'));
        $data['email_wp_sppt'] = trim_quotes($this->input->post('email_wp_sppt'));
        $data['pekerjaan_wp_sppt'] = trim_quotes($this->input->post('pekerjaan_wp_sppt'));

        $data['nops'] = trim_quotes($this->input->post('nops'));
        $data['jln_op_sppt'] = trim_quotes($this->input->post('jln_op_sppt'));
        $data['blok_kav_no_op_sppt'] = trim_quotes($this->input->post('blok_kav_no_op_sppt'));
        $data['rt_op_sppt'] = trim_quotes($this->input->post('rt_op_sppt'));
        $data['rw_op_sppt'] = trim_quotes($this->input->post('rw_op_sppt'));
        $data['luas_tanah'] = $this->input->post('luas_tanah');
        $data['jns_tanah_op'] = $this->input->post('jns_tanah_op');


        $data['luas_bumi'] = $this->input->post('luas_bumi');
        $data['jns_bumi'] = $this->input->post('jns_bumi');

        $data['jns_png'] = $this->input->post('jns_png');
        $data['pct_png'] = $this->input->post('pct_png');

        $data['jml_mutasi'] = $this->input->post('jml_mutasi');


        return $data;
    }

    public function cek_file_size($val) {
        $maxsize = SIZE_FILE_MAX;
        $L_SPMKP_PBB1 = isset($_FILES['L_SPMKP_PBB1']['name']) ? $_FILES['L_SPMKP_PBB1']['size'] : 0;
        $L_SURAT_KUASA1 = isset($_FILES['L_SURAT_KUASA1']['name']) ? $_FILES['L_SURAT_KUASA1']['size'] : 0;
        $L_SKKP_PBB1 = isset($_FILES['L_SKKP_PBB1']['name']) ? $_FILES['L_SKKP_PBB1']['size'] : 0;
        $L_SERTIFIKAT_TANAH1 = isset($_FILES['L_SERTIFIKAT_TANAH1']['name']) ? $_FILES['L_SERTIFIKAT_TANAH1']['size'] : 0;
        $L_IMB1 = isset($_FILES['L_IMB1']['name']) ? $_FILES['L_IMB1']['size'] : 0;
        $L_AKTE_JUAL_BELI1 = isset($_FILES['L_AKTE_JUAL_BELI1']['name']) ? $_FILES['L_AKTE_JUAL_BELI1']['size'] : 0;
        $L_PERMOHONAN1 = isset($_FILES['L_PERMOHONAN1']['name']) ? $_FILES['L_PERMOHONAN1']['size'] : 0;
        $L_STTS1 = isset($_FILES['L_STTS1']['name']) ? $_FILES['L_STTS1']['size'] : 0;
        $L_SK_KEBERATAN1 = isset($_FILES['L_SK_KEBERATAN1']['name']) ? $_FILES['L_SK_KEBERATAN1']['size'] : 0;
        $L_SPPT_STTS1 = isset($_FILES['L_SPPT_STTS1']['name']) ? $_FILES['L_SPPT_STTS1']['size'] : 0;
        $L_SPPT1 = isset($_FILES['L_SPPT1']['size']) ? $_FILES['L_SPPT1']['size'] : 0;
        $L_KTP_WP1 = isset($_FILES['L_KTP_WP1']['name']) ? $_FILES['L_KTP_WP1']['size'] : 0;
        $L_SK_PENGURANGAN1 = isset($_FILES['L_SK_PENGURANGAN1']['name']) ? $_FILES['L_SK_PENGURANGAN1']['size'] : 0;
        $L_LAIN_LAIN1 = isset($_FILES['L_LAIN_LAIN1']['name']) ? $_FILES['L_LAIN_LAIN1']['size'] : 0;
        // $im_buktibayar = isset($_FILES['im_buktibayar']['name']) ? $_FILES['im_buktibayar']['size'] : 0;
        // $L_SPPT1_bnr = isset($_FILES['L_SPPT1_bnr']['name']) ? $_FILES['L_SPPT1_bnr']['size'] : 0;
        //// REG ESPPT 
        $L_SKKP_PBB1_re = isset($_FILES['L_SKKP_PBB1_re']['name']) ? $_FILES['L_SKKP_PBB1_re']['size'] : 0;
        $L_SPPT1_re = isset($_FILES['L_SPPT1_re']['size']) ? $_FILES['L_SPPT1_re']['size'] : 0;
        $L_KTP_WP1_re = isset($_FILES['L_KTP_WP1_re']['name']) ? $_FILES['L_KTP_WP1_re']['size'] : 0;

        $ret = true;

        // if ($L_SPPT1_bnr > $maxsize) {
        //     $ret = false;
        // }
        // if ($im_buktibayar > $maxsize) {
        //     $ret = false;
        // }
        if ($L_SPMKP_PBB1 > $maxsize) {
            $ret = false;
        }
        if ($L_SURAT_KUASA1 > $maxsize) {
            $ret = false;
        }
        if ($L_SKKP_PBB1 > $maxsize) {
            $ret = false;
        }
        if ($L_SERTIFIKAT_TANAH1 > $maxsize) {
            $ret = false;
        }
        if ($L_IMB1 > $maxsize) {
            $ret = false;
        }
        if ($L_AKTE_JUAL_BELI1 > $maxsize) {
            $ret = false;
        }
        if ($L_PERMOHONAN1 > $maxsize) {
            $ret = false;
        }
        if ($L_STTS1 > $maxsize) {
            $ret = false;
        }
        if ($L_SK_KEBERATAN1 > $maxsize) {
            $ret = false;
        }
        if ($L_SPPT_STTS1 > $maxsize) {
            $ret = false;
        }
        if ($L_SPPT1 > $maxsize) {
            $ret = false;
        }
        if ($L_KTP_WP1 > $maxsize) {
            $ret = false;
        }
        if ($L_SK_PENGURANGAN1 > $maxsize) {
            $ret = false;
        }
        if ($L_LAIN_LAIN1 > $maxsize) {
            $ret = false;
        }

        //// REG ESPPT 
        if ($L_SKKP_PBB1_re > $maxsize) {
            $ret = false;
        }
        if ($L_SPPT1_re > $maxsize) {
            $ret = false;
        }
        if ($L_KTP_WP1_re > $maxsize) {
            $ret = false;
        }

        if ($ret == false) {
            $this->form_validation->set_message('cek_file_size', 'File Maksimal 3MB');
        }
        return $ret;
    }

    function cek_file_tipe($val) {
        $ret = true;
        $atx = 'kosong';
        $L_SPMKP_PBB1 = !empty($_FILES['L_SPMKP_PBB1']['name']) ? $_FILES['L_SPMKP_PBB1']['type'] : $atx;
        $L_SURAT_KUASA1 = !empty($_FILES['L_SURAT_KUASA1']['name']) ? $_FILES['L_SURAT_KUASA1']['type'] : $atx;
        $L_SKKP_PBB1 = !empty($_FILES['L_SKKP_PBB1']['name']) ? $_FILES['L_SKKP_PBB1']['type'] : $atx;
        $L_SERTIFIKAT_TANAH1 = !empty($_FILES['L_SERTIFIKAT_TANAH1']['name']) ? $_FILES['L_SERTIFIKAT_TANAH1']['type'] : $atx;
        $L_IMB1 = !empty($_FILES['L_IMB1']['name']) ? $_FILES['L_IMB1']['type'] : $atx;
        $L_AKTE_JUAL_BELI1 = !empty($_FILES['L_AKTE_JUAL_BELI1']['name']) ? $_FILES['L_AKTE_JUAL_BELI1']['type'] : $atx;
        $L_PERMOHONAN1 = !empty($_FILES['L_PERMOHONAN1']['name']) ? $_FILES['L_PERMOHONAN1']['type'] : $atx;
        $L_STTS1 = !empty($_FILES['L_STTS1']['name']) ? $_FILES['L_STTS1']['type'] : $atx;
        $L_SK_KEBERATAN1 = !empty($_FILES['L_SK_KEBERATAN1']['name']) ? $_FILES['L_SK_KEBERATAN1']['type'] : $atx;
        $L_SPPT_STTS1 = !empty($_FILES['L_SPPT_STTS1']['name']) ? $_FILES['L_SPPT_STTS1']['type'] : $atx;
        $L_SPPT1 = !empty($_FILES['L_SPPT1']['type']) ? $_FILES['L_SPPT1']['type'] : $atx;
        $L_KTP_WP1 = !empty($_FILES['L_KTP_WP1']['name']) ? $_FILES['L_KTP_WP1']['type'] : $atx;
        // $L_SPPT1_bnr = !empty($_FILES['L_SPPT1_bnr']['type']) ? $_FILES['L_SPPT1_bnr']['type'] : $atx;
        // $im_buktibayar = !empty($_FILES['im_bukt$im_buktibayar']['type']) ? $_FILES['im_bukt$im_buktibayar']['type'] : $atx;
        // !in_array($L_SPPT1_bnr, $file_ext) || !in_array($im_buktibayar, $file_ext) || 
        $L_SK_PENGURANGAN1 = !empty($_FILES['L_SK_PENGURANGAN1']['name']) ? $_FILES['L_SK_PENGURANGAN1']['type'] : $atx;
        $L_LAIN_LAIN1 = !empty($_FILES['L_LAIN_LAIN1']['name']) ? $_FILES['L_LAIN_LAIN1']['type'] : $atx;

        $L_SKKP_PBB1_re = !empty($_FILES['L_SKKP_PBB1_re']['name']) ? $_FILES['L_SKKP_PBB1_re']['type'] : $atx;
        $L_SPPT1_re = !empty($_FILES['L_SPPT1_re']['type']) ? $_FILES['L_SPPT1_re']['type'] : $atx;
        $L_KTP_WP1_re = !empty($_FILES['L_KTP_WP1_re']['name']) ? $_FILES['L_KTP_WP1_re']['type'] : $atx;

        $file_ext = array("application/pdf", "image/png", "image/jpeg", "image/jpg", $atx);
        if (!in_array($L_SPMKP_PBB1, $file_ext) || !in_array($L_SURAT_KUASA1, $file_ext) || !in_array($L_SERTIFIKAT_TANAH1, $file_ext) || 
            !in_array($L_SKKP_PBB1, $file_ext) || !in_array($L_IMB1, $file_ext) || !in_array($L_AKTE_JUAL_BELI1, $file_ext) || 
            !in_array($L_PERMOHONAN1, $file_ext) || !in_array($L_STTS1, $file_ext) || !in_array($L_SK_KEBERATAN1, $file_ext) || 
            !in_array($L_SPPT_STTS1, $file_ext) || !in_array($L_SPPT1, $file_ext) || !in_array($L_KTP_WP1, $file_ext) || 
            !in_array($L_SK_PENGURANGAN1, $file_ext) || !in_array($L_LAIN_LAIN1, $file_ext)) {
            $ret = false;
        }
        if (!in_array($L_SKKP_PBB1_re, $file_ext) || !in_array($L_SPPT1_re, $file_ext) || !in_array($L_KTP_WP1_re, $file_ext)) {
            $ret = false;
        }
        if ($ret == false) {
            $this->form_validation->set_message('cek_file_tipe', 'Harap hanya upload dokumen dengan format .jpg, .jpeg, .png, .pdf');
        }
        return $ret;
    }


    public function index() {
        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect('tool_pbb');
        }

        $data['page_menu'] = 'upt';
        $data['current'] = 'permohonan_online_upt';
        $data['apps']    = $this->apps_model->get_active_only();
        
        // $option = array( ''=> 'Semua Status','A' => 'Draft',
        //     '1' => 'Terima',
        //     '2' => 'Tolak');
        // $js  = 'id="status_kd" style="width:130px;" class="form-control" ';
        // $select = form_dropdown('status_kd', $option, '' , $js);
        // $data['select_status'] = $select;

        // $data['faction'] = active_module_url("permohonan_online_upt/proses/");
        $data['faction'] = '#';
        // $data['dt']['nop'] = get_string('');
        // $data['dt']['tahun'] = get_string('');
        // $data['dt']['jatuh_tempo'] = get_string('');

        $select_data  = $this->permohonan_online_upt_model->get_jns_ply();
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
        // $js     = 'id="jns_ply" required style="width:90%; height:100% !important;" onchange="jns_ply_chg(this.value)" ';
        $js     = 'class="form-control" id="jns_ply" required onchange="jns_ply_chg(this.value)" ';
        $select = form_dropdown('jns_ply', $options, '', $js);
        $select = preg_replace("/[\r\n]+/", "", $select);
        $data['select_jns_ply'] = $select;
        /////////////////////////////////////////////////////////////////
        $select_data1  = $this->permohonan_online_upt_model->get_sub_jns_ply('999999');
        $options1 = [];
        if ($select_data1) {
            foreach ($select_data1 as $row) {
                $options1[$row->KD_SUB_JNS_PELAYANAN] = $row->NM_SUB_JENIS_PELAYANAN;
            }
        } else {
            $options1['0'] = 'Data not found';
        }
        $js     = 'class="form-control" id="sub_jns_ply" ';
        $select = form_dropdown('sub_jns_ply', $options1, '', $js);
        $select = preg_replace("/[\r\n]+/", "", $select);
        $data['select_sub_jns_ply'] = $select;
        /////////////////////////////////////////////////////////////////
        $select_data2  = $this->permohonan_online_upt_model->get_lookup_item('20');
        if ($select_data2) {
            foreach ($select_data2 as $row) {
                $options2[$row->KD_LOOKUP_ITEM] = $row->NM_LOOKUP_ITEM;
            }
        } else {
            $options2['0'] = 'Data not found';
        }
        $js     = 'class="form-control" id="jns_bumi" required ';
        $select = form_dropdown('jns_bumi', $options2, '', $js);
        $select = preg_replace("/[\r\n]+/", "", $select);
        $data['select_jns_bumi'] = $select;
        /////////////////////////////////////////////////////////////////
        $select_data3  = $this->permohonan_online_upt_model->get_lookup_item('08');
        if ($select_data3) {
            foreach ($select_data3 as $row) {
                $options3[$row->KD_LOOKUP_ITEM] = $row->NM_LOOKUP_ITEM;
            }
        } else {
            $options3['0'] = 'Data not found';
        }
        $js     = 'class="form-control" id="pekerjaan_wp_sppt" required ';
        $select = form_dropdown('pekerjaan_wp_sppt', $options3, '', $js);
        $select = preg_replace("/[\r\n]+/", "", $select);
        $data['select_pekerjaan_wp'] = $select;
        /////////////////////////////////////////////////////////////////

        $data['dt'] = $this->fpost();

        $data['dt']['tgl_permohonan'] = date('d-m-Y');
        $data['dt']['thn_permohonan'] = date('Y');

        $this->load->view('vpermohonan_online_upt_form', $data);
    }

    function jns_ply_chg() {
        $kd_ply    = $this->uri->segment(4);
        $sub_ply = $this->permohonan_online_upt_model->get_sub_jns_ply($kd_ply);
        echo json_encode($sub_ply);
    }

    public function get_nop_reg_esppt() {
        $nop = $this->uri->segment(4);
        $data = new stdClass();

        
        // var_dump($dt_reg_sppt); die();
        if ($dt_reg_sppt = $this->permohonan_online_upt_model->cek_nop_reg_esppt($nop)) {
            $data->result       = '201';
            $data->msg          = 'Sukses mendapatkan data REGISTRASI ESPPT';
            $data->nama_wp_re   = $dt_reg_sppt->NM_WP_SPPT;
            // $data->alamat_wp_re = $dt_reg_sppt->JLN_WP_SPPT . ' ' . $dt_reg_sppt->BLOK_KAV_NO_WP_SPPT;
            $data->alamat_wp_re = $dt_reg_sppt->JLN_WP_SPPT;
            $data->nik_re       = $dt_reg_sppt->NIK;
            $data->no_telp_re   = $dt_reg_sppt->NOHP;
            $data->nama_re      = $dt_reg_sppt->NAMA;
            $data->email_re     = $dt_reg_sppt->EMAIL;
            $data->nop          = $dt_reg_sppt->NOPLKP;
            $data->id_re        = $dt_reg_sppt->NOPNIK;
            
        } else {
            if ($dt_op = $this->permohonan_online_upt_model->cek_nop_dop($nop)) {
                // var_dump($dt_op); die();
                $data->result       = '202';
                $data->msg          = 'Sukses mendapatkan data DAT OBJEK PAJAK';
                $data->nama_wp_re   = $dt_op->NM_WP;
                // $data->alamat_wp_re = $dt_op->JALAN_WP . ' ' . $dt_op->BLOK_KAV_NO_WP;
                $data->alamat_wp_re = $dt_op->JALAN_WP;
                $data->nik_re       = $dt_op->NIK;
                $data->no_telp_re   = $dt_op->TELP_WP ? $dt_op->TELP_WP : $dt_op->HP_WP;
                $data->nama_re      = $dt_op->NM_WP;
                $data->email_re     = $dt_op->EMAIL_WP;
                $data->id_re        = $dt_op->NOPNIK;
            } else {
                $data->result       = '400';
                $data->msg          = 'Data NOP tidak ditemukan di REG ESPPT dan DAT OBJEK PAJAK...';
            }
            
        }

        echo json_encode($data);
    }

    public function get_dat_objek_pajak() {
        $nop = $this->uri->segment(4);
        $data = new stdClass();

        if ($dt_op = $this->permohonan_online_upt_model->get_objek_pajak($nop)) {
            // var_dump($dt_op); die();
            $data->result       = '200';
            $data->msg          = 'Sukses mendapatkan data DAT OBJEK PAJAK';
            $data->data_op      = $dt_op; 
        } else {
            $data->result       = '400';
            $data->msg          = 'Data NOP tidak ditemukan di DAT OBJEK PAJAK...';
            $data->data_op      = null;
        }

        echo json_encode($data);
    }

    public function save_reg_esppt() {
        $nopnik = trim($this->input->post('id_reg_esppt'));
        $nop        = trim($this->input->post('nop_re'));
        $nop        = str_replace(".", "", $nop);
        $nop        = str_replace("-", "", $nop);
        $kd_prop = substr($nop, 0, 2);
        $kd_dati = substr($nop, 2, 2);
        $kd_kec  = substr($nop, 4, 3);
        $kd_kel  = substr($nop, 7, 3);
        $kd_blok = substr($nop, 10, 3);
        $no_urut = substr($nop, 13, 4);
        $kd_jns_op = substr($nop, 17, 1);
        $nik        = trim($this->input->post('nik_re'));
        $namawp     = $this->input->post('nama_wp_re');
        $jalanwp    = $this->input->post('alamat_op_re');
        $loginname  = $this->input->post('nik_re');
        $email      = $this->input->post('email_re');
        $no_hp      = $this->input->post('no_telp_re');
        $nama       = $this->input->post('nama_re');
        $password   = '12345678';
        $niknop     = $nik.$nop;
        $no_reg     = $kd_kec.$kd_kel.$kd_blok.$no_urut.$kd_jns_op;
        $usergroup  = '4';
        $status     = '1';
        $i_thn_ply  = date('Y');

        $max_size = 3 * 1024 * 1024; // 3 MB

        if (!empty($_FILES['im_ktp_re']['name']) && $_FILES['im_ktp_re']['size'] > $max_size) {
            echo json_encode([
                "result" => 400,
                "msg" => "Ukuran file KTP tidak boleh lebih dari 3 MB"
            ]);
            return;
        }

        if (!empty($_FILES['im_sppt_re']['name']) && $_FILES['im_sppt_re']['size'] > $max_size) {
            echo json_encode([
                "result" => 400,
                "msg" => "Ukuran file SPPT tidak boleh lebih dari 3 MB"
            ]);
            return;
        }

        if (!empty($_FILES['im_stts_re']['name']) && $_FILES['im_stts_re']['size'] > $max_size) {
            echo json_encode([
                "result" => 400,
                "msg" => "Ukuran file STTS tidak boleh lebih dari 3 MB"
            ]);
            return;
        }

        $im_ktp     = empty($_FILES['im_ktp_re']['name']) ? NULL : file_get_contents($_FILES['im_ktp_re']['tmp_name']);
        $im_sppt    = empty($_FILES['im_sppt_re']['name']) ? NULL : file_get_contents($_FILES['im_sppt_re']['tmp_name']);
        $im_stts    = empty($_FILES['im_stts_re']['name']) ? NULL : file_get_contents($_FILES['im_stts_re']['tmp_name']);

        // $im_ktp         = file_get_contents($_FILES['im_ktp_re']['tmp_name']);
        // $im_sppt        = file_get_contents($_FILES['im_sppt_re']['tmp_name']);
        // $im_stts        = file_get_contents($_FILES['im_stts_re']['tmp_name']);

        $otp = $this->generate_otp();
        $code = 0;
        $msg  = '';

        //// cek data reg_esppt
        $dt = $this->permohonan_online_upt_model->cek_nop_reg_esppt_bynopnik($nopnik);

        $dbhost = DB_HOST;
        $dbport = DB_PORT;
        $dbname = DB_NAME;
        $dbuser = DB_USER;
        $dbpass = DB_PASS;
        $tnslistener = '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=' . $dbhost . ')(PORT=' . $dbport . '))(CONNECT_DATA=(SID=' . $dbname . ')))';
        $connection = oci_connect($dbuser, $dbpass, $tnslistener);

        $data = new stdClass();

        if ($dt) {  //// data ada updateeee
            $upd_re = array(
                            "EMAIL" => $email,
                            "NOHP" => $no_hp,
                            "KODE_OTP_EMAIL" => $otp
                    );

            // if ($this->permohonan_online_upt_model->update_reg_esppt_bynopnik($upd_re, $nopnik)) {
                //// update blob
                // if (!empty($_FILES['im_ktp_re']['name']) || !empty($_FILES['im_sppt_re']['name']) || !empty($_FILES['im_stts_re']['name'])) {
                    // $this->update_prm_blob_regesppt($nop, $nik);


                    ////////
                    // $qq = "UPDATE REG_ESPPT SET EMAIL = '$email', NOHP = '$no_hp', KODE_OTP_EMAIL = '$otp',
                    //     IM_KTP_BLOB=EMPTY_BLOB(), IM_SPPT_BLOB=EMPTY_BLOB(), IM_PBB_BLOB=EMPTY_BLOB()
                    //     WHERE KD_PROPINSI||KD_DATI2||KD_KECAMATAN||KD_KELURAHAN||KD_BLOK||NO_URUT||KD_JNS_OP='{$nop}' and trim(NIK) ='{$nik}'
                    //     RETURNING IM_KTP_BLOB, IM_SPPT_BLOB, IM_PBB_BLOB
                    //     INTO :blobsatu, :blobdua, :blobtiga";

                    //// pake versi baru ketika gak ada upload, gak usah update
                    $set_fields = " EMAIL = '$email', NOHP = '$no_hp', KODE_OTP_EMAIL = '$otp' ";
                    $returning = [];
                    $bindings = [];

                    if (!empty($_FILES['im_ktp_re']['name'])) {
                        $set_fields .= ", IM_KTP_BLOB = EMPTY_BLOB()";
                        $returning[] = "IM_KTP_BLOB";
                    }

                    if (!empty($_FILES['im_sppt_re']['name'])) {
                        $set_fields .= ", IM_SPPT_BLOB = EMPTY_BLOB()";
                        $returning[] = "IM_SPPT_BLOB";
                    }

                    if (!empty($_FILES['im_stts_re']['name'])) {
                        $set_fields .= ", IM_PBB_BLOB = EMPTY_BLOB()";
                        $returning[] = "IM_PBB_BLOB";
                    }

                    $qq = "UPDATE REG_ESPPT SET $set_fields
                            WHERE KD_PROPINSI = '{$kd_prop}' AND KD_DATI2 = '{$kd_dati}' AND KD_KECAMATAN = '{$kd_kec}' 
                            AND KD_KELURAHAN = '{$kd_kel}' AND KD_BLOK = '{$kd_blok}' AND NO_URUT = '{$no_urut}' 
                            AND KD_JNS_OP='{$kd_jns_op}' AND trim(NIK) ='{$nik}' ";

                    if (!empty($returning)) {
                        $into = [];
                        if (in_array("IM_KTP_BLOB", $returning))
                            $into[] = ":im_ktp_blob";

                        if (in_array("IM_SPPT_BLOB", $returning))
                            $into[] = ":im_sppt_blob";

                        if (in_array("IM_PBB_BLOB", $returning))
                            $into[] = ":im_pbb_blob";

                        $qq .= " RETURNING " . implode(",", $returning)
                             . " INTO " . implode(",", $into);
                    }

                    // echo "<pre>QUERY:\n$qq</pre>"; exit;
                    
                    $result = oci_parse($connection, $qq);
                    // $blob = oci_new_descriptor($connection, OCI_D_LOB);
                    // $blob1 = oci_new_descriptor($connection, OCI_D_LOB);
                    // $blob2 = oci_new_descriptor($connection, OCI_D_LOB);

                    // // var_dump($blob, $blob1, $blob2); exit;
                    // // var_dump(strlen($L_SKKP_PBB1), strlen($L_SPPT1), strlen($L_KTP_WP1)); exit;
                    // // $affected = oci_num_rows($result);
                    // // var_dump($affected); exit;

                    // oci_bind_by_name($result, ":blobsatu", $blob, -1, OCI_B_BLOB);
                    // oci_bind_by_name($result, ":blobdua", $blob1, -1, OCI_B_BLOB);
                    // oci_bind_by_name($result, ":blobtiga", $blob2, -1, OCI_B_BLOB);
                    if (!empty($_FILES['im_ktp_re']['name'])) {
                        $blob_ktp = oci_new_descriptor($connection, OCI_D_LOB);
                        oci_bind_by_name($result, ":im_ktp_blob", $blob_ktp, -1, OCI_B_BLOB);
                    }

                    if (!empty($_FILES['im_sppt_re']['name'])) {
                        $blob_sppt = oci_new_descriptor($connection, OCI_D_LOB);
                        oci_bind_by_name($result, ":im_sppt_blob", $blob_sppt, -1, OCI_B_BLOB);
                    }

                    if (!empty($_FILES['im_stts_re']['name'])) {
                        $blob_stts = oci_new_descriptor($connection, OCI_D_LOB);
                        oci_bind_by_name($result, ":im_pbb_blob", $blob_stts, -1, OCI_B_BLOB);
                    }

                    oci_execute($result, OCI_DEFAULT) or die("Unable to execute query");
                    // $blob->save($im_ktp);
                    // $blob1->save($im_sppt);
                    // $blob2->save($im_stts);
                    if (!empty($_FILES['im_ktp_re']['name'])) {
                        $blob_ktp->save($im_ktp);
                    }

                    if (!empty($_FILES['im_sppt_re']['name'])) {
                        $blob_sppt->save($im_sppt);
                    }

                    if (!empty($_FILES['im_stts_re']['name'])) {
                        $blob_stts->save($im_stts);
                    }

                    oci_commit($connection);

                    $code = 200;
                    $msg  = "Sukses Simpan data dan kirim OTP. Silakan cek email Anda.";
                // } else {
                //     $code = 400;
                //     $msg  = "Lampiran gagal diupload. harap refresh halaman.";
                // }

            // } else {
            //     $code = 400;
            //     $msg  = "Gagal update atau data Reg SPPT tidak ditemukan.";
            // }

        } else {    //// data tidak ada, bikin baru

            $qry1 = "INSERT INTO REG_ESPPT(KODE_OTP_EMAIL, NIK, NM_WP_SPPT, JLN_WP_SPPT, BLOK_KAV_NO_WP_SPPT, RW_WP_SPPT,
                                            RT_WP_SPPT, KELURAHAN_WP_SPPT, KOTA_WP_SPPT, RW_OP_SPPT, RT_OP_SPPT, THN_PAJAK_BAYAR,
                                            LOGINNAME, PASSWOD, EMAIL,
                                            NOHP, NAMA, NO_REG, NIKNOP, USER_GROUP, STATUS, 
                                            KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN,
                                            KD_BLOK, NO_URUT, KD_JNS_OP,
                                            SUBJEK_PAJAK_ID, NM_WP_BAYAR, 
                                            JLN_OP_SPPT, BLOK_KAV_NO_OP_SPPT, 
                                            IM_KTP_BLOB, IM_SPPT_BLOB, IM_PBB_BLOB)";

            $qry2 = " VALUES ('$otp', '$nik', :namawp, :jalanwp, '-', '00', 
                            '000', ' ', ' ', '00','000', '$i_thn_ply',
                            '$loginname', '$password', :email,
                            :no_hp, :nama, '$no_reg', '$niknop', '$usergroup', '$status', 
                            '$kd_prop', '$kd_dati', '$kd_kec',  '$kd_kel',
                            '$kd_blok','$no_urut', '$kd_jns_op', 
                            '$nik', ' ', ' ', ' ',
                            EMPTY_BLOB(), EMPTY_BLOB(), EMPTY_BLOB() )
                      RETURNING IM_KTP_BLOB, IM_SPPT_BLOB, IM_PBB_BLOB
                      INTO :blobsatu, :blobdua, :blobtiga";

            $sql = $qry1 . $qry2;
            // echo $qry2;
            $result = oci_parse($connection, $sql);
            $blob = oci_new_descriptor($connection, OCI_D_LOB);
            $blob1 = oci_new_descriptor($connection, OCI_D_LOB);
            $blob2 = oci_new_descriptor($connection, OCI_D_LOB);
            oci_bind_by_name($result, ":blobsatu", $blob, -1, OCI_B_BLOB);
            oci_bind_by_name($result, ":blobdua", $blob1, -1, OCI_B_BLOB);
            oci_bind_by_name($result, ":blobtiga", $blob2, -1, OCI_B_BLOB);
            oci_bind_by_name($result, ":namawp", $namawp);
            oci_bind_by_name($result, ":jalanwp", $jalanwp);
            oci_bind_by_name($result, ":email", $email);
            oci_bind_by_name($result, ":no_hp", $no_hp);
            oci_bind_by_name($result, ":nama", $nama);
            oci_execute($result, OCI_DEFAULT) or die("Unable to execute query");
            $blob->save($im_ktp);
            $blob1->save($im_sppt);
            $blob2->save($im_stts);
            oci_commit($connection);

            $data = new stdClass();

            if (!oci_commit($connection)) {
                $code = 400;
                $msg  = "Gagal simpan data Registrasi ESPPT";
            } else {
                oci_free_statement($result);
                $code = 200;
                $msg  = "Sukses simpan data dan kirim OTP Registrasi ESPPT. Silakan cek email Anda.";
            }

        }

        if ($code == 200) {
            //// cek user di SEC_USERS
            $user_dt = $this->permohonan_online_upt_model->cek_secuser($nik);
            if(!$user_dt) {
                $pass_enc = $this->permohonan_online_upt_model->encript_value($nik, $password);
                $id_user = $this->permohonan_online_upt_model->nextid_user(); //dipake kok
                // echo $id_user;

                $user_data = array(
                  'ID'            => get_string($id_user->NEXT_ID), // dipake kok
                  'LEVEL_ID'      => 3,
                  'DISABLED'      => 0,
                  'USERID'        => $nik,
                  'PASSWD'        => get_string($pass_enc->FN_KEYLOCK),
                  'NAMA'          => str_replace("'", "''", $namawp), 
                  'HANDPHONE'     => $no_hp,
                  'NIP'           => '-',
                  'JABATAN'       => '-',
                  'CREATED_DATE'  => current_time(),
                  'CREATED_BY'    => $nik,
                );

                $user_group_data = array(
                  // 'USER_ID'       => get_string($id_user->NEXT_ID), // dipake kok
                  'USER_ID'       => $id_user->NEXT_ID, // dipake kok
                  'GROUP_ID'      => 2,
                );

                $this->db->insert('SEC_USERS', $user_data); // dipake kok
                $this->db->insert('SEC_USER_GROUPS', $user_group_data);
            } 

            // kirim email otp
            $config = array(
                'protocol' => SMTP_PROTOCOL,
                'smtp_host' => SMTP_HOST, //sesuaikan dengan host pengirim
                'smtp_port' => SMTP_PORT,
                'smtp_timeout' => 20,
                'smtp_user' => SMTP_USER, //sesuaikan dengan email yg dipakai
                'smtp_pass' => SMTP_PASS, //password host
                'smtp_username' => SMTP_UNAME,
                'mailtype' => SMTP_TYPE,
                'charset' => SMTP_CHARSET,
                'wordwrap' => true,
            );  

            $message = '
                    <html>
                    <head>
                        <title>Verifikasi Kode OTP ESPPT Kab. Bogor</title>
                    </head>
                    <body style="font-family: Arial, sans-serif; background-color: #f6f9fc; margin: 0; padding: 20px;">
                        <table align="center" cellpadding="0" cellspacing="0" width="600" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                            <tr>
                                <td style="background-color: #2b8a3e; padding: 16px; border-radius: 8px 8px 0 0; text-align: center; color: #ffffff;">
                                    <h2 style="margin: 0;">ESPPT Kabupaten Bogor</h2>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 30px; text-align: center;">
                                    <h3 style="color: #333;">Halo, '.$email.'</h3>
                                    <p style="font-size: 16px; color: #555;">Berikut adalah kode OTP Anda untuk verifikasi:</p>
                                    <h1 style="background-color: #f3f3f3; display: inline-block; padding: 12px 24px; border-radius: 6px; letter-spacing: 3px; color: #2b8a3e; font-size: 28px; margin: 16px 0;">
                                        '.$otp.'
                                    </h1>
                                    <p style="color: #777; font-size: 14px;">Jangan bagikan kode ini ke siapa pun.<br>
                                    Jika Anda tidak meminta kode ini, abaikan email ini.</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="background-color: #f0f0f0; text-align: center; padding: 15px; font-size: 13px; color: #999; border-radius: 0 0 8px 8px;">
                                     '.date('Y').' Bappenda Kabupaten Bogor
                                </td>
                            </tr>
                        </table>
                    </body>
                    </html>';



            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from(SMTP_USER, SMTP_UNAME);
            $this->email->to($email);
            $this->email->subject('Approve Registrasi ESPPT');
            $this->email->message($message);
            ////sending email
            if ($this->email->send()) {
                $data->result       = '200';
                $data->msg          = $msg;
            } else {
                $data->result       = '201';
                $data->msg          = 'Gagal kirim email. Harap refresh halaman.';
                // echo $this->email->print_debugger();
            }

            // // buat tes tanpa kirim email.. komen kirim email diatas..
            // $data->result       = '200';
            // $data->msg          = $msg;
            
        } else {
            $data->result       = $code;
            $data->msg          = $msg;
        }

        echo json_encode($data);

    }

    function verify_otp() {
        $otp   = $this->input->post('otp');
        $email = $this->input->post('email');
        $nik   = $this->input->post('nik');
        $nop   = $this->input->post('nop');
        $nopnik = trim($this->input->post('nopnik'));

        $data = $this->permohonan_online_upt_model->cek_nop_reg_esppt_bynopnik($nopnik);

        if ($data) {
            if ($data->KODE_OTP_EMAIL === $otp) {
                // Update status verifikasi
                $this->permohonan_online_upt_model->update_reg_esppt_bynopnik(
                    ['STS_OTP_EMAIL' => '1'],
                    $nopnik
                );

                echo json_encode(['status' => 'ok']);
            } else {
                echo json_encode(['status' => 'error', 'msg' => 'Kode OTP salah.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Data tidak ditemukan.']);
        }
    }


    public function send_mail_reg_esppt() {
        $nopnik = $this->uri->segment(4);
        $data = new stdClass();
        if ($dt_reg_sppt = $this->permohonan_online_upt_model->cek_nop_reg_esppt_bynopnik($nopnik)) {

            $config = array(
                'protocol' => SMTP_PROTOCOL,
                'smtp_host' => SMTP_HOST, //sesuaikan dengan host pengirim
                'smtp_port' => SMTP_PORT,
                'smtp_timeout' => 20,
                'smtp_user' => SMTP_USER, //sesuaikan dengan email yg dipakai
                'smtp_pass' => SMTP_PASS, //password host
                'smtp_username' => SMTP_UNAME,
                'mailtype' => SMTP_TYPE,
                'charset' => SMTP_CHARSET,
                'wordwrap' => true,
            );  

            $message = "
                        <html>
                            <head>
                                <title>Registrasi Akun ESPPT Kab Bogor</title>
                            </head>
                            <body>
                                <h3>Hi, ".$dt_reg_sppt->EMAIL."</h3>
                                <h3>Terima kasih, permohonan registrasi anda berhasil. Silakan login untuk melanjutkan proses pelayanan</h3>
                                <h3>*Klik <a href='".DOMAIN_SPPT."login' >Link Ini</a> untuk login dengan Akun Anda.</h3>
                                <h3>*Terima Kasih. </h3>
                            </body>
                        </html>";


            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from(SMTP_USER, SMTP_UNAME);
            $this->email->to($dt_reg_sppt->EMAIL);
            $this->email->subject('Approve Registrasi ESPPT');
            $this->email->message($message);
                //sending email
            if ($this->email->send()) {
                $data->result       = '200';
                $data->msg          = 'Berhasil Kirim Email Registrasi ESPPT';
            } else {
                $data->result       = '400';
                $data->msg          = 'Gagal Kirim Email';
                // echo $this->email->print_debugger();
            }
        } else {
            $data->result       = '400';
            $data->msg          = 'Data tidak akurat.. Harap refresh browser Anda..';
        }

        echo json_encode($data);

    }

    private function cek_max_size($file, $max_mb = 5) {
        if (empty($_FILES[$file]['name'])) return true; // ga ada file = aman

        $max_bytes = $max_mb * 1024 * 1024;
        return ($_FILES[$file]['size'] <= $max_bytes);
    }


    public function save_permo() {
        $nop_lkp    = $this->input->post('nop');
        $nop        = $this->input->post('nop');
        $nop        = str_replace(".", "", $nop);
        $nop        = str_replace("-", "", $nop);
        $kd_prop = substr($nop, 0, 2);
        $kd_dati = substr($nop, 2, 2);
        $kd_kec  = substr($nop, 4, 3);
        $kd_kel  = substr($nop, 7, 3);
        $kd_blok = substr($nop, 10, 3);
        $no_urut = substr($nop, 13, 4);
        $kd_jns_op = substr($nop, 17, 1);
        $nik            = $this->input->post('nik_re');
        $email          = $this->input->post('email_re');
        $no_permohonan  = $this->input->post('no_permohonan');
        $nopel          = $this->input->post('nopel');
        $telp           = $this->input->post('telp');
        $nama_pemohon   = $this->input->post('nama_pemohon');
        $thn_permohonan = $this->input->post('thn_permohonan');
        $alamat_pemohon = $this->input->post('alamat_pemohon');
        $keterangan     = $this->input->post('keterangan');
        $jns_ply        = $this->input->post('jns_ply');
        $sub_jns_ply    = $this->input->post('sub_jns_ply');
        $pct_png        = $this->input->post('pct_png');
        $flg_dikuasakan = $this->input->post('chk_dikuasakan');
        $jml_mutasi = $this->input->post('jml_mutasi');
        // $tgl_permohonan = $this->input->post('tgl_permohonan');
        $tgl_permohonan = date('Y-m-d',strtotime($this->input->post('tgl_permohonan')));
        $i_thn_ply = $this->permohonan_online_upt_model->get_thn_pelayanan();
        $kd_kanwil = '22';
        $kd_kantor = '13';

        //// cek constrain nop + tahun + jns_ply + tgl
        $cek_heula = $this->db->query("
                        SELECT COUNT(*) AS JML
                        FROM PST_PERMOHONAN_TOOL
                        WHERE KD_PROPINSI_PEMOHON = ? AND KD_DATI2_PEMOHON = ? AND KD_KECAMATAN_PEMOHON = ? AND KD_KELURAHAN_PEMOHON = ?
                          AND KD_BLOK_PEMOHON = ? AND NO_URUT_PEMOHON = ? AND KD_JNS_OP_PEMOHON = ? AND THN_PAJAK_PERMOHONAN = ?
                          AND KD_JNS_PELAYANAN = ? AND TGL_SURAT_PERMOHONAN = TO_DATE(?, 'YYYY-MM-DD')", 
                      [$kd_prop, $kd_dati, $kd_kec, $kd_kel,
                        $kd_blok, $no_urut, $kd_jns_op, $thn_permohonan,
                        $jns_ply, $tgl_permohonan])->row()->JML;

        if ($cek_heula > 0) {
            echo json_encode([
                'result' => 409,
                'msg' => 'Permohonan Pelayanan sudah ada dengan NOP, Jenis Pelayanan, dan Tanggal Permohonan yang sama. Silakan Ajukan Permohonan pada tanggal yang berbeda.'
            ]);
            return;
        }

        //// cek pelayanan pengurangan (08)
        if ($jns_ply == '08') {
            //// Cek sppt tahun dipilih belum bayar dan faktor pengurang = 0
            $cek_heula = $this->db->query("SELECT COUNT(*) AS JML 
                              FROM SPPT WHERE KD_PROPINSI = ? AND KD_DATI2 = ? AND KD_KECAMATAN = ? AND KD_KELURAHAN = ?
                              AND KD_BLOK = ? AND NO_URUT = ? AND KD_JNS_OP = ? AND THN_PAJAK_SPPT = ? AND FAKTOR_PENGURANG_SPPT = 0
                              AND STATUS_PEMBAYARAN_SPPT = '0' ",
                              [$kd_prop, $kd_dati, $kd_kec, $kd_kel, $kd_blok, $no_urut, $kd_jns_op, $thn_permohonan]
                          )->row()->JML;
            if ($cek_heula == 0) {
                echo json_encode([
                    'result' => 409,
                    'msg' => 'NOP ada Faktor Pengurang SPPT atau sudah lunas. Tidak dapat mengajukan Permohonan Pengurangan'
                ]);
                return;
            }
        }

        if ($jns_ply == '19') {
            if($jml_mutasi < 2 || $jml_mutasi > 51){
                $code_1 = 400;
                $msg_1 = 'GAGAL.. Jumlah Mutasi minimal 2... atau Jumlah Mutasi maksimal 51...';

                if($jml_mutasi > 51){
                    $code_1 = 400;
                    $msg_1 = 'GAGAL.. Jumlah Mutasi maksimal 51...';
                }

                echo json_encode([
                    'result' => $code_1,
                    'msg' => $msg_1
                ]);
                return;

            }
        } else {
            $jml_mutasi = 0;
        }

        $fL_SPMKP_PBB1 = empty($_FILES['L_SPMKP_PBB1']['name']) ? 0 : 1;
        $fL_SURAT_KUASA1 = empty($_FILES['L_SURAT_KUASA1']['name']) ? 0 : 1;
        $fL_SKKP_PBB1 = empty($_FILES['L_SKKP_PBB1']['name']) ? 0 : 1;
        $fL_SERTIFIKAT_TANAH1 = empty($_FILES['L_SERTIFIKAT_TANAH1']['name']) ? 0 : 1;
        $fL_IMB1 = empty($_FILES['L_IMB1']['name']) ? 0 : 1;
        $fL_AKTE_JUAL_BELI1 = empty($_FILES['L_AKTE_JUAL_BELI1']['name']) ? 0 : 1;
        $fL_PERMOHONAN1 = empty($_FILES['L_PERMOHONAN1']['name']) ? 0 : 1;
        $fL_STTS1 = empty($_FILES['L_STTS1']['name']) ? 0 : 1;
        $fL_SK_KEBERATAN1 = empty($_FILES['L_SK_KEBERATAN1']['name']) ? 0 : 1;
        $fL_SPPT_STTS1 = empty($_FILES['L_SPPT_STTS1']['name']) ? 0 : 1;
        $fL_SPPT1 = empty($_FILES['L_SPPT1']['name']) ? 0 : 1;
        $fL_KTP_WP1 = empty($_FILES['L_KTP_WP1']['name']) ? 0 : 1;
        $fL_SK_PENGURANGAN1 = empty($_FILES['L_SK_PENGURANGAN1']['name']) ? 0 : 1;
        $fL_LAIN_LAIN1 = empty($_FILES['L_LAIN_LAIN1']['name']) ? 0 : 1;

        $L_SPMKP_PBB1 = $fL_SPMKP_PBB1 == 0 ? NULL : file_get_contents($_FILES['L_SPMKP_PBB1']['tmp_name']);
        $L_SURAT_KUASA1 = $fL_SURAT_KUASA1 == 0 ? NULL : file_get_contents($_FILES['L_SURAT_KUASA1']['tmp_name']);
        $L_SKKP_PBB1 = $fL_SKKP_PBB1 == 0 ? NULL : file_get_contents($_FILES['L_SKKP_PBB1']['tmp_name']);
        $L_SERTIFIKAT_TANAH1 = $fL_SERTIFIKAT_TANAH1 == 0 ? NULL : file_get_contents($_FILES['L_SERTIFIKAT_TANAH1']['tmp_name']);
        $L_IMB1 = $fL_IMB1 == 0 ? NULL : file_get_contents($_FILES['L_IMB1']['tmp_name']);
        $L_AKTE_JUAL_BELI1 = $fL_AKTE_JUAL_BELI1 == 0 ? NULL : file_get_contents($_FILES['L_AKTE_JUAL_BELI1']['tmp_name']);
        $L_PERMOHONAN1 = $fL_PERMOHONAN1 == 0 ? NULL : file_get_contents($_FILES['L_PERMOHONAN1']['tmp_name']);
        $L_STTS1 = $fL_STTS1 == 0 ? NULL : file_get_contents($_FILES['L_STTS1']['tmp_name']);
        $L_SK_KEBERATAN1 = $fL_SK_KEBERATAN1 == 0 ? NULL : file_get_contents($_FILES['L_SK_KEBERATAN1']['tmp_name']);
        $L_SPPT_STTS1 = $fL_SPPT_STTS1 == 0 ? NULL : file_get_contents($_FILES['L_SPPT_STTS1']['tmp_name']);
        $L_SPPT1 = $fL_SPPT1 == 0 ? NULL : file_get_contents($_FILES['L_SPPT1']['tmp_name']);
        $L_KTP_WP1 = $fL_KTP_WP1 == 0 ? NULL : file_get_contents($_FILES['L_KTP_WP1']['tmp_name']);
        $L_SK_PENGURANGAN1 = $fL_SK_PENGURANGAN1 == 0 ? NULL : file_get_contents($_FILES['L_SK_PENGURANGAN1']['tmp_name']);
        $L_LAIN_LAIN1 = $fL_LAIN_LAIN1 == 0 ? NULL : file_get_contents($_FILES['L_LAIN_LAIN1']['tmp_name']);

        //// cek max size
        $max_size_error = [];
        $fields = [
            'L_SPMKP_PBB1',
            'L_SURAT_KUASA1',
            'L_SKKP_PBB1',
            'L_SERTIFIKAT_TANAH1',
            'L_IMB1',
            'L_AKTE_JUAL_BELI1',
            'L_PERMOHONAN1',
            'L_STTS1',
            'L_SK_KEBERATAN1',
            'L_SPPT_STTS1',
            'L_SPPT1',
            'L_KTP_WP1',
            'L_SK_PENGURANGAN1',
            'L_LAIN_LAIN1'
        ];

        foreach ($fields as $f) {
            if (!$this->cek_max_size($f, 3)) {
                $max_size_error[] = $f;
            }
        }

        if (!empty($max_size_error)) {
            echo json_encode([
                'result' => 400,
                'msg' => 'Ukuran file terlalu besar (maksimal 3MB)'
                // 'msg' => 'Ukuran file terlalu besar (maksimal 3MB): ' . implode(', ', $max_size_error)
            ]);
            return;
        }

        $dbhost = DB_HOST;
        $dbport = DB_PORT;
        $dbname = DB_NAME;
        $dbuser = DB_USER;
        $dbpass = DB_PASS;

        $has_spmkp      = !empty($L_SPMKP_PBB1);
        $has_srt_kuasa  = !empty($L_SURAT_KUASA1);
        $has_skkp       = !empty($L_SKKP_PBB1);
        $has_serti      = !empty($L_SERTIFIKAT_TANAH1);
        $has_imb        = !empty($L_IMB1);
        $has_ajb        = !empty($L_AKTE_JUAL_BELI1);
        $has_permo      = !empty($L_PERMOHONAN1);
        $has_stts       = !empty($L_STTS1);
        $has_keberatan  = !empty($L_SK_KEBERATAN1);
        $has_sppt_stts  = !empty($L_SPPT_STTS1);
        $has_sppt       = !empty($L_SPPT1);
        $has_ktp        = !empty($L_KTP_WP1);
        $has_sk_png     = !empty($L_SK_PENGURANGAN1);
        $has_lain       = !empty($L_LAIN_LAIN1);

        $tnslistener = '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST='.DB_HOST.')(PORT='.DB_PORT.'))(CONNECT_DATA=(SERVICE_NAME='.DB_NAME.')))';
        $connection = oci_connect($dbuser, $dbpass, $tnslistener);

        $ppo_id = $this->db->query("SELECT PST_PERMOHONAN_TOOL_SEQ.NEXTVAL as NEXT_ID FROM DUAL")->row()->NEXT_ID;

        $qq = "INSERT INTO PST_PERMOHONAN_TOOL(ID, KD_KANWIL, KD_KANTOR, THN_PELAYANAN, NAMA_PEMOHON, ALAMAT_PEMOHON, 
                KD_PROPINSI_PEMOHON, KD_DATI2_PEMOHON, KD_KECAMATAN_PEMOHON, KD_KELURAHAN_PEMOHON, KD_BLOK_PEMOHON, 
                NO_URUT_PEMOHON, KD_JNS_OP_PEMOHON, KD_JNS_PELAYANAN, TGL_SURAT_PERMOHONAN, THN_PAJAK_PERMOHONAN, 
                NIK_PENGIRIM, KETERANGAN_PST, NO_SRT_PERMOHONAN, NO_HP, FLG_DIKUASAKAN, JML_MUTASI, ";
        
        //// tambahan khusus jns pelayanan 03 insert juga id_sub_jns_pelayanan
        if ($jns_ply == '03' || $jns_ply == '08') {
            $qq .= " KD_SUB_JNS_PELAYANAN, ";
        }
        if ($jns_ply == '08') {
            $qq .= " PCT_PENGURANGAN, ";
        }
        
        $qq .= "L_KTP_WP, L_SKKP_PBB, L_SPMKP_PBB, L_SURAT_KUASA, L_PERMOHONAN, L_STTS, 
                L_SK_KEBERATAN, L_SPPT_STTS, L_SERTIFIKAT_TANAH, L_IMB, L_AKTE_JUAL_BELI, L_SPPT, 
                L_SK_PENGURANGAN, L_LAIN_LAIN, 
                L_SKKP_PBB1, L_SPMKP_PBB1, L_SURAT_KUASA1, L_PERMOHONAN1, L_STTS1, L_SK_KEBERATAN1, 
                L_SPPT_STTS1, L_KTP_WP1, L_SERTIFIKAT_TANAH1, L_IMB1, L_AKTE_JUAL_BELI1, L_SPPT1, 
                L_SK_PENGURANGAN1, L_LAIN_LAIN1)";
        $qq .= " VALUES( $ppo_id, '$kd_kanwil', '$kd_kantor', '$i_thn_ply', '$nama_pemohon', '$alamat_pemohon',
                '$kd_prop', '$kd_dati', '$kd_kec', '$kd_kel', '$kd_blok',
                '$no_urut', '$kd_jns_op', '$jns_ply', TO_DATE('$tgl_permohonan','YYYY-MM-DD'), '$thn_permohonan',
                '0', '$keterangan', '$no_permohonan', '$telp', $flg_dikuasakan, $jml_mutasi, ";

        if ($jns_ply == '03' || $jns_ply == '08') {
            $qq .= " '$sub_jns_ply', ";
        }
        if ($jns_ply == '08') {
            $qq .= " '$pct_png', ";
        }

        $qq .= "{$fL_SKKP_PBB1}, {$fL_SPMKP_PBB1}, {$fL_SURAT_KUASA1}, {$fL_PERMOHONAN1}, {$fL_STTS1}, {$fL_SK_KEBERATAN1}, 
                {$fL_SPPT_STTS1}, {$fL_KTP_WP1}, {$fL_SERTIFIKAT_TANAH1}, {$fL_IMB1}, {$fL_AKTE_JUAL_BELI1}, {$fL_SPPT1}, 
                {$fL_SK_PENGURANGAN1}, {$fL_LAIN_LAIN1},
                ".($has_skkp ? "EMPTY_BLOB()" : "NULL").",
                ".($has_spmkp ? "EMPTY_BLOB()" : "NULL").",
                ".($has_srt_kuasa ? "EMPTY_BLOB()" : "NULL").",
                ".($has_permo ? "EMPTY_BLOB()" : "NULL").",
                ".($has_stts ? "EMPTY_BLOB()" : "NULL").",
                ".($has_keberatan ? "EMPTY_BLOB()" : "NULL").",
                ".($has_sppt_stts ? "EMPTY_BLOB()" : "NULL").",
                ".($has_ktp ? "EMPTY_BLOB()" : "NULL").",
                ".($has_serti ? "EMPTY_BLOB()" : "NULL").",
                ".($has_imb ? "EMPTY_BLOB()" : "NULL").",
                ".($has_ajb ? "EMPTY_BLOB()" : "NULL").",
                ".($has_sppt ? "EMPTY_BLOB()" : "NULL").",
                ".($has_sk_png ? "EMPTY_BLOB()" : "NULL").",
                ".($has_lain ? "EMPTY_BLOB()" : "NULL")."
                ) 
                RETURNING 
                L_SKKP_PBB1, L_SPMKP_PBB1, L_SURAT_KUASA1, L_PERMOHONAN1, L_STTS1, L_SK_KEBERATAN1, 
                L_SPPT_STTS1, L_KTP_WP1, L_SERTIFIKAT_TANAH1, L_IMB1, L_AKTE_JUAL_BELI1, L_SPPT1, 
                L_SK_PENGURANGAN1, L_LAIN_LAIN1 
                INTO 
                :blobsatu, :blobdua, :blobtiga, :blobempat, :bloblima, :blobenam, 
                :blobtujuh, :blobdelapan, :blobsembilan, :blobsepuluh, :blobXI, :blobXII, 
                :blobXIII, :blobXIV";

            // $db_pbb->query($qq);
        $result = oci_parse($connection, $qq);
        $blob = oci_new_descriptor($connection, OCI_D_LOB);
        $blob1 = oci_new_descriptor($connection, OCI_D_LOB);
        $blob2 = oci_new_descriptor($connection, OCI_D_LOB);
        $blob3 = oci_new_descriptor($connection, OCI_D_LOB);
        $blob4 = oci_new_descriptor($connection, OCI_D_LOB);
        $blob5 = oci_new_descriptor($connection, OCI_D_LOB);
        $blob6 = oci_new_descriptor($connection, OCI_D_LOB);
        $blob7 = oci_new_descriptor($connection, OCI_D_LOB);
        $blob8 = oci_new_descriptor($connection, OCI_D_LOB);
        $blob9 = oci_new_descriptor($connection, OCI_D_LOB);
        $blob10 = oci_new_descriptor($connection, OCI_D_LOB);
        $blob11 = oci_new_descriptor($connection, OCI_D_LOB);
        $blob12 = oci_new_descriptor($connection, OCI_D_LOB);
        $blob13 = oci_new_descriptor($connection, OCI_D_LOB);
        oci_bind_by_name($result, ":blobsatu", $blob, -1, OCI_B_BLOB);
        oci_bind_by_name($result, ":blobdua", $blob1, -1, OCI_B_BLOB);
        oci_bind_by_name($result, ":blobtiga", $blob2, -1, OCI_B_BLOB);
        oci_bind_by_name($result, ":blobempat", $blob3, -1, OCI_B_BLOB);
        oci_bind_by_name($result, ":bloblima", $blob4, -1, OCI_B_BLOB);
        oci_bind_by_name($result, ":blobenam", $blob5, -1, OCI_B_BLOB);
        oci_bind_by_name($result, ":blobtujuh", $blob6, -1, OCI_B_BLOB);
        oci_bind_by_name($result, ":blobdelapan", $blob7, -1, OCI_B_BLOB);
        oci_bind_by_name($result, ":blobsembilan", $blob8, -1, OCI_B_BLOB);
        oci_bind_by_name($result, ":blobsepuluh", $blob9, -1, OCI_B_BLOB);
        oci_bind_by_name($result, ":blobXI", $blob10, -1, OCI_B_BLOB);
        oci_bind_by_name($result, ":blobXII", $blob11, -1, OCI_B_BLOB);
        oci_bind_by_name($result, ":blobXIII", $blob12, -1, OCI_B_BLOB);
        oci_bind_by_name($result, ":blobXIV", $blob13, -1, OCI_B_BLOB);
        $err = oci_error($result);
        oci_execute($result, OCI_DEFAULT) or die("Unable to execute query; <br>".$qq.'<br> Keterangan Error: <br>'.$err);
        // $blob->save($L_SPMKP_PBB1);
        // $blob1->save($L_SURAT_KUASA1);
        // $blob2->save($L_PERMOHONAN1);
        // $blob3->save($L_STTS1);
        // $blob4->save($L_SK_KEBERATAN1);
        // $blob5->save($L_SPPT_STTS1);
        // $blob6->save($L_KTP_WP1);
        // $blob7->save($L_SKKP_PBB1);
        // $blob8->save($L_SERTIFIKAT_TANAH1);
        // $blob9->save($L_IMB1);
        // $blob10->save($L_AKTE_JUAL_BELI1);
        // $blob11->save($L_SPPT1);
        // $blob12->save($L_SK_PENGURANGAN1);
        // $blob13->save($L_LAIN_LAIN1);
        if ($has_skkp)       $blob->save($L_SKKP_PBB1);
        if ($has_spmkp)      $blob1->save($L_SPMKP_PBB1);
        if ($has_srt_kuasa)  $blob2->save($L_SURAT_KUASA1);
        if ($has_permo)      $blob3->save($L_PERMOHONAN1);
        if ($has_stts)       $blob4->save($L_STTS1);
        if ($has_keberatan)  $blob5->save($L_SK_KEBERATAN1);
        if ($has_sppt_stts)  $blob6->save($L_SPPT_STTS1);
        if ($has_ktp)        $blob7->save($L_KTP_WP1);
        if ($has_serti)      $blob8->save($L_SERTIFIKAT_TANAH1);
        if ($has_imb)        $blob9->save($L_IMB1);
        if ($has_ajb)        $blob10->save($L_AKTE_JUAL_BELI1);
        if ($has_sppt)       $blob11->save($L_SPPT1);
        if ($has_sk_png)     $blob12->save($L_SK_PENGURANGAN1);
        if ($has_lain)       $blob13->save($L_LAIN_LAIN1);
        oci_commit($connection);

        $data = new stdClass();

        if (!oci_commit($connection)) {
            // return 0;
            $data->result       = '400';
            $data->msg          = 'Gagal Simpan Data Permohonan Online';
        } else {
            oci_free_statement($result);

            $error_CRUD = "";
            //// insert ke data online
            if ($jns_ply == '02' || $jns_ply == '03') {     // MUTASI HABIS

                //// DAT OBJEK PAJAK ONLINE
                $sql1 = " BEGIN
                INSERT INTO DAT_OBJEK_PAJAK_ONLINE (DOCH_ID, THN_PELAYANAN, TAHUN,
                KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP, SUBJEK_PAJAK_ID, NO_FORMULIR_SPOP, NO_PERSIL, 
                JALAN_OP, BLOK_KAV_NO_OP, RW_OP, RT_OP, KD_STATUS_CABANG, KD_STATUS_WP, TOTAL_LUAS_BUMI, TOTAL_LUAS_BNG, NJOP_BUMI, NJOP_BNG, 
                STATUS_PETA_OP, JNS_TRANSAKSI_OP, TGL_PENDATAAN_OP, NIP_PENDATA, TGL_PEMERIKSAAN_OP, NIP_PEMERIKSA_OP, TGL_PEREKAMAN_OP, NIP_PEREKAM_OP)
                SELECT $ppo_id as DOCH_ID, $i_thn_ply as THN_PELAYANAN, $i_thn_ply as TAHUN, DAT_OBJEK_PAJAK.*
                FROM DAT_OBJEK_PAJAK 
                WHERE KD_PROPINSI||KD_DATI2||KD_KECAMATAN||KD_KELURAHAN||KD_BLOK||NO_URUT||KD_JNS_OP = '".$nop."' 
                ;
                EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                END; ";
                //
                //// DAT SUBJEK PAJAK ONLINE
                $sql2 = " BEGIN
                INSERT INTO DAT_SUBJEK_PAJAK_ONLINE (DOCH_ID, THN_PELAYANAN, TAHUN, 
                    SUBJEK_PAJAK_ID, NM_WP, JALAN_WP, BLOK_KAV_NO_WP, RW_WP, RT_WP, KELURAHAN_WP, KOTA_WP, KD_POS_WP, TELP_WP, NPWP, 
                    STATUS_PEKERJAAN_WP, HP_WP, EMAIL_WP)
                SELECT $ppo_id as DOCH_ID, $i_thn_ply as THN_PELAYANAN, $i_thn_ply as TAHUN, DSP.*
                FROM DAT_OBJEK_PAJAK DOP
                JOIN DAT_SUBJEK_PAJAK DSP ON TRIM(DSP.SUBJEK_PAJAK_ID) = TRIM(DOP.SUBJEK_PAJAK_ID)
                WHERE DOP.KD_PROPINSI||DOP.KD_DATI2||DOP.KD_KECAMATAN||DOP.KD_KELURAHAN||DOP.KD_BLOK||DOP.NO_URUT||DOP.KD_JNS_OP = '".$nop."' 
                ;
                EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                END; ";
                //

                //// DAT OP BUMI ONLINE
                $sql3 = " BEGIN 
                            INSERT INTO DAT_OP_BUMI_ONLINE (THN_PELAYANAN,KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,
                            NO_BUMI,KD_ZNT,LUAS_BUMI,JNS_BUMI,NILAI_SISTEM_BUMI,DOCH_ID)
                            SELECT '" . $i_thn_ply . "', A2.*, " . $ppo_id . " FROM DAT_OP_BUMI A2
                            WHERE A2.KD_PROPINSI||A2.KD_DATI2||A2.KD_KECAMATAN||A2.KD_KELURAHAN||A2.KD_BLOK||A2.NO_URUT||A2.KD_JNS_OP = '".$nop."' 
                            ;
                            EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM);
                        END;";

                //// DAT OP BANGUNAN ONLINE
                $sql4 = " BEGIN 
                            INSERT INTO DAT_OP_BANGUNAN_ONLINE (THN_PELAYANAN,KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,
                            NO_BNG,KD_JPB,NO_FORMULIR_LSPOP,THN_DIBANGUN_BNG,THN_RENOVASI_BNG,LUAS_BNG,JML_LANTAI_BNG,KONDISI_BNG,JNS_KONSTRUKSI_BNG,
                            JNS_ATAP_BNG,KD_DINDING,KD_LANTAI,KD_LANGIT_LANGIT,NILAI_SISTEM_BNG,JNS_TRANSAKSI_BNG,TGL_PENDATAAN_BNG,NIP_PENDATA_BNG,
                            TGL_PEMERIKSAAN_BNG,NIP_PEMERIKSA_BNG,TGL_PEREKAMAN_BNG,NIP_PEREKAM_BNG,TAHUN,DOCH_ID)
                            SELECT '" . $i_thn_ply . "' AS THN_PELAYANAN, A1.*, '" . $i_thn_ply . "' AS TAHUN, " . $ppo_id . "  FROM DAT_OP_BANGUNAN A1
                            WHERE A1.KD_PROPINSI||A1.KD_DATI2||A1.KD_KECAMATAN||A1.KD_KELURAHAN||A1.KD_BLOK||A1.NO_URUT||A1.KD_JNS_OP = '".$nop."'
                            ;
                            EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM);
                        end;

                        BEGIN 
                            INSERT INTO DAT_FASILITAS_BANGUNAN_ONLINE (THN_PELAYANAN,KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,
                            NO_BNG,KD_FASILITAS,JML_SATUAN,DOCD_ID)
                            SELECT '" . $i_thn_ply . "', A4.*, B4.ID FROM DAT_FASILITAS_BANGUNAN A4
                            LEFT JOIN DAT_OP_BANGUNAN_ONLINE B4 ON A4.KD_PROPINSI = B4.KD_PROPINSI AND A4.KD_DATI2 = B4.KD_DATI2
                                AND A4.KD_KECAMATAN = B4.KD_KECAMATAN AND A4.KD_KELURAHAN = B4.KD_KELURAHAN AND A4.KD_BLOK = B4.KD_BLOK 
                                AND A4.NO_URUT = B4.NO_URUT AND A4.KD_JNS_OP = B4.KD_JNS_OP AND A4.NO_BNG = B4.NO_BNG AND B4.DOCH_ID = ".$ppo_id."
                            WHERE  A4.KD_PROPINSI||A4.KD_DATI2||A4.KD_KECAMATAN||A4.KD_KELURAHAN||A4.KD_BLOK||A4.NO_URUT||A4.KD_JNS_OP = '".$nop."'
                            ;
                            EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM);
                        END; 

                        BEGIN 
                            INSERT INTO DAT_NILAI_INDIVIDU_ONLINE (DOCD_ID,KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,
                            NO_BNG,NO_FORMULIR_INDIVIDU,NILAI_INDIVIDU,TGL_PENILAIAN_INDIVIDU,NIP_PENILAI_INDIVIDU,TGL_PEMERIKSAAN_INDIVIDU,
                            NIP_PEMERIKSA_INDIVIDU,TGL_REKAM_NILAI_INDIVIDU,NIP_PEREKAM_INDIVIDU)
                            SELECT B4.ID, A4.* FROM DAT_NILAI_INDIVIDU A4
                            LEFT JOIN DAT_OP_BANGUNAN_ONLINE B4 ON A4.KD_PROPINSI = B4.KD_PROPINSI AND A4.KD_DATI2 = B4.KD_DATI2
                                AND A4.KD_KECAMATAN = B4.KD_KECAMATAN AND A4.KD_KELURAHAN = B4.KD_KELURAHAN AND A4.KD_BLOK = B4.KD_BLOK 
                                AND A4.NO_URUT = B4.NO_URUT AND A4.KD_JNS_OP = B4.KD_JNS_OP AND A4.NO_BNG = B4.NO_BNG AND B4.DOCH_ID = ".$ppo_id."
                            WHERE  A4.KD_PROPINSI||A4.KD_DATI2||A4.KD_KECAMATAN||A4.KD_KELURAHAN||A4.KD_BLOK||A4.NO_URUT||A4.KD_JNS_OP = '".$nop."'
                            ;
                            EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM);
                        END; 

                        ";

                $sql5 = " BEGIN 
                            INSERT INTO DAT_JPB02_ONLINE (KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP, NO_BNG, KLS_JPB02, DOCD_ID)
                            SELECT A4.*, B4.ID
                            FROM DAT_JPB2 A4
                            LEFT JOIN DAT_OP_BANGUNAN_ONLINE B4 ON A4.KD_PROPINSI = B4.KD_PROPINSI AND A4.KD_DATI2 = B4.KD_DATI2
                                AND A4.KD_KECAMATAN = B4.KD_KECAMATAN AND A4.KD_KELURAHAN = B4.KD_KELURAHAN AND A4.KD_BLOK = B4.KD_BLOK 
                                AND A4.NO_URUT = B4.NO_URUT AND A4.KD_JNS_OP = B4.KD_JNS_OP AND A4.NO_BNG = B4.NO_BNG AND B4.DOCH_ID = ".$ppo_id."
                            WHERE  A4.KD_PROPINSI||A4.KD_DATI2||A4.KD_KECAMATAN||A4.KD_KELURAHAN||A4.KD_BLOK||A4.NO_URUT||A4.KD_JNS_OP = '".$nop."'
                            ;
                            EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM);
                        end; 

                        begin 
                            INSERT INTO DAT_JPB03_ONLINE (KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP, NO_BNG, 
                                TYPE_KONSTRUKSI, TING_KOLOM_JPB3, LBR_BENT_JPB3, LUAS_MEZZANINE_JPB3, KELILING_DINDING_JPB3, DAYA_DUKUNG_LANTAI_JPB3, DOCD_ID)
                            SELECT A4.*, B4.ID
                            FROM DAT_JPB3 A4
                            LEFT JOIN DAT_OP_BANGUNAN_ONLINE B4 ON A4.KD_PROPINSI = B4.KD_PROPINSI AND A4.KD_DATI2 = B4.KD_DATI2
                                AND A4.KD_KECAMATAN = B4.KD_KECAMATAN AND A4.KD_KELURAHAN = B4.KD_KELURAHAN AND A4.KD_BLOK = B4.KD_BLOK 
                                AND A4.NO_URUT = B4.NO_URUT AND A4.KD_JNS_OP = B4.KD_JNS_OP AND A4.NO_BNG = B4.NO_BNG AND B4.DOCH_ID = ".$ppo_id."
                            WHERE  A4.KD_PROPINSI||A4.KD_DATI2||A4.KD_KECAMATAN||A4.KD_KELURAHAN||A4.KD_BLOK||A4.NO_URUT||A4.KD_JNS_OP = '".$nop."'
                            ;
                            EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM);
                        end; 

                        begin 
                            INSERT INTO DAT_JPB04_ONLINE (KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP, NO_BNG, KLS_JPB4, DOCD_ID)
                            SELECT A4.*, B4.ID
                            FROM DAT_JPB4 A4
                            LEFT JOIN DAT_OP_BANGUNAN_ONLINE B4 ON A4.KD_PROPINSI = B4.KD_PROPINSI AND A4.KD_DATI2 = B4.KD_DATI2
                                AND A4.KD_KECAMATAN = B4.KD_KECAMATAN AND A4.KD_KELURAHAN = B4.KD_KELURAHAN AND A4.KD_BLOK = B4.KD_BLOK 
                                AND A4.NO_URUT = B4.NO_URUT AND A4.KD_JNS_OP = B4.KD_JNS_OP AND A4.NO_BNG = B4.NO_BNG AND B4.DOCH_ID = ".$ppo_id."
                            WHERE  A4.KD_PROPINSI||A4.KD_DATI2||A4.KD_KECAMATAN||A4.KD_KELURAHAN||A4.KD_BLOK||A4.NO_URUT||A4.KD_JNS_OP = '".$nop."'
                            ;
                            EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM);
                        end; 

                        begin 
                            INSERT INTO DAT_JPB05_ONLINE (KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP, NO_BNG, 
                                KLS_JPB05, LUAS_KMR_JPB05_DGN_AC_SENT, LUAS_RNG_LAIN_JPB5_DGN_AC_SENT, DOCD_ID)
                            SELECT A4.*, B4.ID
                            FROM DAT_JPB5 A4
                            LEFT JOIN DAT_OP_BANGUNAN_ONLINE B4 ON A4.KD_PROPINSI = B4.KD_PROPINSI AND A4.KD_DATI2 = B4.KD_DATI2
                                AND A4.KD_KECAMATAN = B4.KD_KECAMATAN AND A4.KD_KELURAHAN = B4.KD_KELURAHAN AND A4.KD_BLOK = B4.KD_BLOK 
                                AND A4.NO_URUT = B4.NO_URUT AND A4.KD_JNS_OP = B4.KD_JNS_OP AND A4.NO_BNG = B4.NO_BNG AND B4.DOCH_ID = ".$ppo_id."
                            WHERE  A4.KD_PROPINSI||A4.KD_DATI2||A4.KD_KECAMATAN||A4.KD_KELURAHAN||A4.KD_BLOK||A4.NO_URUT||A4.KD_JNS_OP = '".$nop."'
                            ;
                            EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM);
                        end; 
                        
                        begin 
                            INSERT INTO DAT_JPB06_ONLINE (KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP, NO_BNG, 
                                KLS_JPB06, DOCD_ID)
                            SELECT A4.*, B4.ID
                            FROM DAT_JPB6 A4
                            LEFT JOIN DAT_OP_BANGUNAN_ONLINE B4 ON A4.KD_PROPINSI = B4.KD_PROPINSI AND A4.KD_DATI2 = B4.KD_DATI2
                                AND A4.KD_KECAMATAN = B4.KD_KECAMATAN AND A4.KD_KELURAHAN = B4.KD_KELURAHAN AND A4.KD_BLOK = B4.KD_BLOK 
                                AND A4.NO_URUT = B4.NO_URUT AND A4.KD_JNS_OP = B4.KD_JNS_OP AND A4.NO_BNG = B4.NO_BNG AND B4.DOCH_ID = ".$ppo_id."
                            WHERE  A4.KD_PROPINSI||A4.KD_DATI2||A4.KD_KECAMATAN||A4.KD_KELURAHAN||A4.KD_BLOK||A4.NO_URUT||A4.KD_JNS_OP = '".$nop."'
                            ;
                            EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM);
                        end; 

                        begin 
                            INSERT INTO DAT_JPB07_ONLINE (KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP, NO_BNG, 
                                JNS_JPB7, BINTANG_JPB7, JML_KMR_JPB7, LUAS_KMR_JPB7_DGN_AC_SENT, LUAS_KMR_LAIN_JPB7_DGN_AC_SENT, DOCD_ID)
                            SELECT A4.*, B4.ID
                            FROM DAT_JPB7 A4
                            LEFT JOIN DAT_OP_BANGUNAN_ONLINE B4 ON A4.KD_PROPINSI = B4.KD_PROPINSI AND A4.KD_DATI2 = B4.KD_DATI2
                                AND A4.KD_KECAMATAN = B4.KD_KECAMATAN AND A4.KD_KELURAHAN = B4.KD_KELURAHAN AND A4.KD_BLOK = B4.KD_BLOK 
                                AND A4.NO_URUT = B4.NO_URUT AND A4.KD_JNS_OP = B4.KD_JNS_OP AND A4.NO_BNG = B4.NO_BNG AND B4.DOCH_ID = ".$ppo_id."
                            WHERE  A4.KD_PROPINSI||A4.KD_DATI2||A4.KD_KECAMATAN||A4.KD_KELURAHAN||A4.KD_BLOK||A4.NO_URUT||A4.KD_JNS_OP = '".$nop."'
                            ;
                            EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM);
                        end; 

                        begin 
                            INSERT INTO DAT_JPB08_ONLINE (KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP, NO_BNG, 
                                TYPE_KONSTRUKSI, TING_KOLOM_JPB8, LBR_BENT_JPB8, LUAS_MEZZANINE_JPB8, KELILING_DINDING_JPB8, DAYA_DUKUNG_LANTAI_JPB8, DOCD_ID)
                            SELECT A4.*, B4.ID
                            FROM DAT_JPB8 A4
                            LEFT JOIN DAT_OP_BANGUNAN_ONLINE B4 ON A4.KD_PROPINSI = B4.KD_PROPINSI AND A4.KD_DATI2 = B4.KD_DATI2
                                AND A4.KD_KECAMATAN = B4.KD_KECAMATAN AND A4.KD_KELURAHAN = B4.KD_KELURAHAN AND A4.KD_BLOK = B4.KD_BLOK 
                                AND A4.NO_URUT = B4.NO_URUT AND A4.KD_JNS_OP = B4.KD_JNS_OP AND A4.NO_BNG = B4.NO_BNG AND B4.DOCH_ID = ".$ppo_id."
                            WHERE  A4.KD_PROPINSI||A4.KD_DATI2||A4.KD_KECAMATAN||A4.KD_KELURAHAN||A4.KD_BLOK||A4.NO_URUT||A4.KD_JNS_OP = '".$nop."'
                            ;
                            EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM);
                        end; 

                        begin 
                            INSERT INTO DAT_JPB09_ONLINE (KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP, NO_BNG, KLS_JPB09, DOCD_ID)
                            SELECT A4.*, B4.ID
                            FROM DAT_JPB9 A4
                            LEFT JOIN DAT_OP_BANGUNAN_ONLINE B4 ON A4.KD_PROPINSI = B4.KD_PROPINSI AND A4.KD_DATI2 = B4.KD_DATI2
                                AND A4.KD_KECAMATAN = B4.KD_KECAMATAN AND A4.KD_KELURAHAN = B4.KD_KELURAHAN AND A4.KD_BLOK = B4.KD_BLOK 
                                AND A4.NO_URUT = B4.NO_URUT AND A4.KD_JNS_OP = B4.KD_JNS_OP AND A4.NO_BNG = B4.NO_BNG AND B4.DOCH_ID = ".$ppo_id."
                            WHERE  A4.KD_PROPINSI||A4.KD_DATI2||A4.KD_KECAMATAN||A4.KD_KELURAHAN||A4.KD_BLOK||A4.NO_URUT||A4.KD_JNS_OP = '".$nop."'
                            ;
                            EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM);
                        end; 

                        begin 
                            INSERT INTO DAT_JPB12_ONLINE (KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP, NO_BNG, TYPE_JPB12, DOCD_ID)
                            SELECT A4.*, B4.ID
                            FROM DAT_JPB12 A4
                            LEFT JOIN DAT_OP_BANGUNAN_ONLINE B4 ON A4.KD_PROPINSI = B4.KD_PROPINSI AND A4.KD_DATI2 = B4.KD_DATI2
                                AND A4.KD_KECAMATAN = B4.KD_KECAMATAN AND A4.KD_KELURAHAN = B4.KD_KELURAHAN AND A4.KD_BLOK = B4.KD_BLOK 
                                AND A4.NO_URUT = B4.NO_URUT AND A4.KD_JNS_OP = B4.KD_JNS_OP AND A4.NO_BNG = B4.NO_BNG AND B4.DOCH_ID = ".$ppo_id."
                            WHERE  A4.KD_PROPINSI||A4.KD_DATI2||A4.KD_KECAMATAN||A4.KD_KELURAHAN||A4.KD_BLOK||A4.NO_URUT||A4.KD_JNS_OP = '".$nop."'
                            ;
                            EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM);
                        end; 

                        begin 
                            INSERT INTO DAT_JPB13_ONLINE (KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP, NO_BNG, 
                                KLS_JPB13, JML_JPB13, LUAS_JPB13_DGN_AC_SENT, LUAS_JPB13_LAIN_DGN_AC_SENT, DOCD_ID)
                            SELECT A4.*, B4.ID
                            FROM DAT_JPB13 A4
                            LEFT JOIN DAT_OP_BANGUNAN_ONLINE B4 ON A4.KD_PROPINSI = B4.KD_PROPINSI AND A4.KD_DATI2 = B4.KD_DATI2
                                AND A4.KD_KECAMATAN = B4.KD_KECAMATAN AND A4.KD_KELURAHAN = B4.KD_KELURAHAN AND A4.KD_BLOK = B4.KD_BLOK 
                                AND A4.NO_URUT = B4.NO_URUT AND A4.KD_JNS_OP = B4.KD_JNS_OP AND A4.NO_BNG = B4.NO_BNG AND B4.DOCH_ID = ".$ppo_id."
                            WHERE  A4.KD_PROPINSI||A4.KD_DATI2||A4.KD_KECAMATAN||A4.KD_KELURAHAN||A4.KD_BLOK||A4.NO_URUT||A4.KD_JNS_OP = '".$nop."'
                            ;
                            EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM);
                        end; 

                        begin 
                            INSERT INTO DAT_JPB14_ONLINE (KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP, NO_BNG, 
                                LUAS_KANOPI_JPB14, DOCD_ID)
                            SELECT A4.*, B4.ID
                            FROM DAT_JPB14 A4
                            LEFT JOIN DAT_OP_BANGUNAN_ONLINE B4 ON A4.KD_PROPINSI = B4.KD_PROPINSI AND A4.KD_DATI2 = B4.KD_DATI2
                                AND A4.KD_KECAMATAN = B4.KD_KECAMATAN AND A4.KD_KELURAHAN = B4.KD_KELURAHAN AND A4.KD_BLOK = B4.KD_BLOK 
                                AND A4.NO_URUT = B4.NO_URUT AND A4.KD_JNS_OP = B4.KD_JNS_OP AND A4.NO_BNG = B4.NO_BNG AND B4.DOCH_ID = ".$ppo_id."
                            WHERE  A4.KD_PROPINSI||A4.KD_DATI2||A4.KD_KECAMATAN||A4.KD_KELURAHAN||A4.KD_BLOK||A4.NO_URUT||A4.KD_JNS_OP = '".$nop."'
                            ;
                            EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM);
                        end; 

                        begin 
                            INSERT INTO DAT_JPB15_ONLINE (KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP, NO_BNG, 
                                LETAK_TANGKI_JPB15, KAPASITAS_TANGKI_JPB15, DOCD_ID)
                            SELECT A4.*, B4.ID
                            FROM DAT_JPB15 A4
                            LEFT JOIN DAT_OP_BANGUNAN_ONLINE B4 ON A4.KD_PROPINSI = B4.KD_PROPINSI AND A4.KD_DATI2 = B4.KD_DATI2
                                AND A4.KD_KECAMATAN = B4.KD_KECAMATAN AND A4.KD_KELURAHAN = B4.KD_KELURAHAN AND A4.KD_BLOK = B4.KD_BLOK 
                                AND A4.NO_URUT = B4.NO_URUT AND A4.KD_JNS_OP = B4.KD_JNS_OP AND A4.NO_BNG = B4.NO_BNG AND B4.DOCH_ID = ".$ppo_id."
                            WHERE  A4.KD_PROPINSI||A4.KD_DATI2||A4.KD_KECAMATAN||A4.KD_KELURAHAN||A4.KD_BLOK||A4.NO_URUT||A4.KD_JNS_OP = '".$nop."'
                            ;
                            EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM);
                        end; 

                        begin 
                            INSERT INTO DAT_JPB16_ONLINE (KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP, NO_BNG, 
                                KLS_JPB16, DOCD_ID)
                            SELECT A4.*, B4.ID
                            FROM DAT_JPB16 A4
                            LEFT JOIN DAT_OP_BANGUNAN_ONLINE B4 ON A4.KD_PROPINSI = B4.KD_PROPINSI AND A4.KD_DATI2 = B4.KD_DATI2
                                AND A4.KD_KECAMATAN = B4.KD_KECAMATAN AND A4.KD_KELURAHAN = B4.KD_KELURAHAN AND A4.KD_BLOK = B4.KD_BLOK 
                                AND A4.NO_URUT = B4.NO_URUT AND A4.KD_JNS_OP = B4.KD_JNS_OP AND A4.NO_BNG = B4.NO_BNG AND B4.DOCH_ID = ".$ppo_id."
                            WHERE  A4.KD_PROPINSI||A4.KD_DATI2||A4.KD_KECAMATAN||A4.KD_KELURAHAN||A4.KD_BLOK||A4.NO_URUT||A4.KD_JNS_OP = '".$nop."'
                            ;
                            EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM);
                        end; ";

                $sql = "BEGIN " . $sql1 . $sql2 . $sql3 . $sql4 . $sql5 . " COMMIT; END; ";
                // log_message('info', " XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX query : " . $sql);
                $error_msg = $this->db->simple_qry_eon_ora($sql);
                $err_Msg = $error_msg['message'];
                if (!empty($err_Msg)) {
                    $error_CRUD = $err_Msg;
                }
            } else if ($jns_ply == '19') {
                $dt_mutsb = array(
                    'ID_PPO' => $ppo_id,
                    'KD_KANWIL' => $kd_kanwil,
                    'KD_KANTOR' => $kd_kantor,
                    'NOP_LKP' => $nop,
                    'THN_PELAYANAN' => $i_thn_ply,
                    'JNS_PELAYANAN' => $jns_ply,
                    'KD_PROPINSI' => $kd_prop,
                    'KD_DATI2' => $kd_dati,
                    'KD_KECAMATAN' => $kd_kec,
                    'KD_KELURAHAN' => $kd_kel,
                    'KD_BLOK' => $kd_blok,
                    'NO_URUT' => $no_urut,
                    'KD_JNS_OP' => $kd_jns_op,
                    'URUT' => $jml_mutasi,
                );

                //// INSERT HEADER NYA DULU 
                $this->permohonan_online_upt_model->insert_pst_mutasi_sebagian_online_head($dt_mutsb);
                for($urut = 1; $urut < $jml_mutasi; $urut++){
                    $err_Msg = $this->permohonan_online_upt_model->insert_pst_mutasi_sebagian_online_daftar_baru($dt_mutsb, $urut+1);
                    
                }

                if (!empty($err_Msg)) {
                    // var_dump($err_Msg);die();
                    $error_CRUD = $err_Msg;

                    // echo $error_CRUD ;
                    // die();
                }
            }

            if (empty($error_CRUD)) {
                $qr_ply     = $this->db->query("SELECT NM_JENIS_PELAYANAN FROM REF_JNS_PELAYANAN WHERE KD_JNS_PELAYANAN = '{$jns_ply}'");
                $nm_jns_ply = $qr_ply->row()->NM_JENIS_PELAYANAN;
                // return 1;
                $data->result       = 200;
                $data->msg          = 'Berhasil Simpan Draft Permohonan Online';
                $data->dtl_nop      = $nop;
                $data->dtl_nop_tx   = $nop_lkp;
                $data->dtl_ply      = $jns_ply;
                $data->dtl_ply_tx   = $nm_jns_ply;
                $data->dtl_thn_ply  = $i_thn_ply;
                $data->dtl_id_ppo   = $ppo_id;
            } else {
                $query = "
                BEGIN
                    DELETE PST_PERMOHONAN_TOOL WHERE ID = $ppo_id;
                    COMMIT;
                END ;";
                $this->db->simple_qry_eon_ora($query);

                $data->result       = 400;
                $data->msg          = 'Data gagal disimpan / Data Objek Pajak tidak ditemukan.';

            }
            
        }

        echo json_encode($data);

    }

    public function edit() {
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_danger', $this->module_auth->msg_read);
            redirect('tool_pbb');
        }

        $param     = $this->uri->segment(4);

        //// cek heula
        $qr_cek = "SELECT COUNT(*) AS JML FROM PST_PERMOHONAN_TOOL WHERE ID = ? AND STATUS_PERMOHONAN <> '0'";
        $cek_heula = $this->db->query($qr_cek, [$param])->row()->JML;

        if ($cek_heula > 0) {
            $this->session->set_flashdata('msg_info', "Data sudah dikirim. Tidak bisa edit data");
            redirect('tool_pbb/permohonan_online_upt');
        }

        $data['page_menu'] = 'upt';
        $data['current'] = 'permohonan_online_upt';
        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = active_module_url("permohonan_online_upt/update/{$param}");
        
        $ppo = $this->permohonan_online_upt_model->get_ppo_by_id($param);

        

        if ($ppo){
            if ($ppo->KD_JNS_PELAYANAN == '02' || $ppo->KD_JNS_PELAYANAN == '03') {

                $dt = $this->permohonan_online_upt_model->get_by_id($param);

        
                $data['dt'] = array(
                    'nop_re' => $dt->NOP_LKP, 
                    'id_reg_esppt' => $dt->NOPNIK, 
                    'nama_wp_re' => $dt->NAMA_WP_REG, 
                    'alamat_op_re' => $dt->ALAMAT_REG, 
                    'nik_re' => $dt->NIK_REG, 
                    'no_telp_re' => $dt->TELP_REG,
                    'nama_re' => $dt->NAMA_REG, 
                    'email_re' => $dt->EMAIL_REG,
                    'kd_jns_ply' => $dt->KD_JNS_PELAYANAN,
                    'kd_sub_jns_ply' => $dt->KD_SUB_JNS_PELAYANAN,

                    'rowid' => $dt->PPO_ID, 
                    'id_ppo' => $dt->PPO_ID, 
                    'nopel' => $dt->NOPEL, 
                    'no_permohonan' => $dt->NO_SRT_PERMOHONAN, 
                    'thn_permohonan' => $dt->THN_PAJAK_PERMOHONAN, 
                    'nop' => $dt->NOP_LKP, 
                    'tgl_permohonan' => get_date($dt->TGL_SURAT_PERMOHONAN), 
                    'nama_pemohon' => $dt->NAMA_PEMOHON, 
                    'alamat_pemohon' => $dt->ALAMAT_PEMOHON, 
                    'telp' => $dt->NO_HP, 
                    'keterangan' => $dt->KETERANGAN_PST, 

                    'nik_wp_sppt' => $dt->NIK_WP_SPPT,
                    'nm_wp_sppt' => $dt->NM_WP_SPPT,
                    'jln_wp_sppt' => $dt->JLN_WP_SPPT,
                    'blok_kav_no_wp_sppt' => $dt->BLOK_KAV_NO_WP_SPPT,
                    'rt_wp_sppt' => $dt->RT_WP_SPPT,
                    'rw_wp_sppt' => $dt->RW_WP_SPPT,
                    'kelurahan_wp_sppt' => $dt->KELURAHAN_WP_SPPT,
                    'kota_wp_sppt' => $dt->KOTA_WP_SPPT,
                    'kd_pos_wp_sppt' => $dt->KD_POS_WP_SPPT,
                    'nohp' => $dt->NOHP,
                    'email_wp_sppt' => $dt->EMAIL_WP_SPPT,

                    'nops' => $dt->NOP_LKP,
                    'luas_tanah' => $dt->TOTAL_LUAS_BUMI,
                    'jln_op_sppt' => $dt->JLN_OP_SPPT,
                    'blok_kav_no_op_sppt' => $dt->BLOK_KAV_NO_OP_SPPT,
                    'rt_op_sppt' => $dt->RT_OP_SPPT,
                    'rw_op_sppt' => $dt->RW_OP_SPPT,

                );

                $data['da'] = (array)$dt;

                $data['fnopnik'] = $dt->NOPNIK;

                //---------------------------------------------------------------------------------------------------------
                $select_data  = $this->permohonan_online_upt_model->get_jns_ply($dt->KD_JNS_PELAYANAN);
                if ($select_data) {
                    foreach ($select_data as $row) {
                        $options[$row->KD_JNS_PELAYANAN] = $row->NM_JENIS_PELAYANAN;
                    }
                } else {
                    $options['0'] = 'Data not found';
                }
                // $js     = 'id="jns_ply" required style="width:90%; height:100% !important;" onchange="jns_ply_chg(this.value)" ';
                $js     = 'class="form-control" id="jns_ply" readonly ';
                $select = form_dropdown('jns_ply', $options, $dt->KD_JNS_PELAYANAN, $js);
                $select = preg_replace("/[\r\n]+/", "", $select);
                $data['select_jns_ply'] = $select;
                //---------------------------------------------------------------------------------------------------------
                $select_data_sub  = $this->permohonan_online_upt_model->get_sub_jns_ply($dt->KD_JNS_PELAYANAN, $dt->KD_SUB_JNS_PELAYANAN);
                if ($select_data_sub) {
                    foreach ($select_data_sub as $row) {
                        $optionsub[$row->KD_SUB_JNS_PELAYANAN] = $row->NM_SUB_JENIS_PELAYANAN;
                    }
                } else {
                    $optionsub['0'] = 'Data not found';
                }
                $js     = 'class="form-control" id="sub_jns_ply" readonly ';
                $select = form_dropdown('sub_jns_ply', $optionsub, $dt->KD_SUB_JNS_PELAYANAN, $js);
                $select = preg_replace("/[\r\n]+/", "", $select);
                $data['select_sub_jns_ply'] = $select;
                //---------------------------------------------------------------------------------------------------------
                if ($dt->KD_JNS_PELAYANAN == '02') {
                    $pekerjaan_wp = '';
                } else {
                    $pekerjaan_wp = '';
                }
                $get_select_pekerjaan_wp = $this->permohonan_online_upt_model->pekerjaan_wp_droplist(NULL);
                $select_pekerjaan_wp = '<select id="pekerjaan_wp" name="pekerjaan_wp" class="form-control" '.$pekerjaan_wp.'>';
                foreach ($get_select_pekerjaan_wp as $key => $va) {
                    $selected = '';
                    if ($dt->STATUS_PEKERJAAN_WP == $va->KD_LOOKUP_ITEM) {
                        $selected = 'selected';
                    }
                    $select_pekerjaan_wp .= '<option ' . $selected . ' value="' . $va->KD_LOOKUP_ITEM . '">' . $va->NM_LOOKUP_ITEM . '</option>';
                }
                $select_pekerjaan_wp .= '</select>';
                $data['select_pekerjaan_wp'] = $select_pekerjaan_wp;
                //---------------------------------------------------------------------------------------------------------
                if ($dt->KD_JNS_PELAYANAN == '02') {
                    $sts_op = '';
                } else {
                    $sts_op = '';
                }
                $get_select_sts_op = $this->permohonan_online_upt_model->lookup_item_droplist(10, NULL);
                $select_sts_op = '<select id="sts_op" name="sts_op" class="form-control" '.$sts_op.'>';
                foreach ($get_select_sts_op as $key => $va) {
                    $selected = '';
                    if ($dt->KD_STATUS_WP == $va->KD_LOOKUP_ITEM) {
                        $selected = 'selected';
                    }
                    $select_sts_op .= '<option ' . $selected . ' value="' . $va->KD_LOOKUP_ITEM . '">' . $va->NM_LOOKUP_ITEM . '</option>';
                }
                $select_sts_op .= '</select>';
                $data['select_sts_op'] = $select_sts_op;
                //---------------------------------------------------------------------------------------------------------
                if ($dt->KD_JNS_PELAYANAN == '02') {
                    $jns_tnh = 'readonly';
                } else {
                    $jns_tnh = '';
                }
                $get_select_jns_tanah = $this->permohonan_online_upt_model->lookup_item_droplist(20, NULL);
                $select_jns_tanah = '<select id="jns_tanah_op" required name="jns_tanah_op" class="form-control" '.$jns_tnh.'>';
                // $select_jns_tanah .= '<option value="">-Silahkan Pilih-</option>';
                foreach ($get_select_jns_tanah as $key => $va) {
                    $selected = '';
                    if ($dt->JNS_BUMI == $va->KD_LOOKUP_ITEM) {
                        $selected = 'selected';
                    }
                    $select_jns_tanah .= '<option ' . $selected . ' value="' . $va->KD_LOOKUP_ITEM . '">' . $va->NM_LOOKUP_ITEM . '</option>';
                }
                $select_jns_tanah .= '</select>';
                $data['select_jns_tanah'] = $select_jns_tanah;
                //---------------------------------------------------------------------------------------------------------
                //---------------------------------------------------------------------------------------------------------
                $get_select_kondisi_bng = $this->permohonan_online_upt_model->lookup_item_droplist(21, NULL);
                $select_kondisi_bng = '<select id="dtl_kondisi_bng" required name="dtl_kondisi_bng" class="form-control">';
                $select_kondisi_bng .= '<option value="">-Silahkan Pilih-</option>';
                foreach ($get_select_kondisi_bng as $key => $va) {
                    $selected = '';
                    // if ($ppost['dtl_kondisi_bng'] == $va->KD_LOOKUP_ITEM) {
                    //     $selected = 'selected';
                    // }
                    $select_kondisi_bng .= '<option ' . $selected . ' value="' . $va->KD_LOOKUP_ITEM . '">' . $va->NM_LOOKUP_ITEM . '</option>';
                }
                $select_kondisi_bng .= '</select>';
                $data['select_kondisi_bng'] = $select_kondisi_bng;
                //---------------------------------------------------------------------------------------------------------
                $get_select_dinding_bng = $this->permohonan_online_upt_model->lookup_item_droplist(42, NULL);
                $select_dinding_bng = '<select id="dtl_jns_dinding" required name="dtl_jns_dinding" class="form-control">';
                $select_dinding_bng .= '<option value="">-Silahkan Pilih-</option>';
                foreach ($get_select_dinding_bng as $key => $va) {
                    $selected = '';
                    // if ($ppost['dtl_jns_dinding'] == $va->KD_LOOKUP_ITEM) {
                    //     $selected = 'selected';
                    // }
                    $select_dinding_bng .= '<option ' . $selected . ' value="' . $va->KD_LOOKUP_ITEM . '">' . $va->NM_LOOKUP_ITEM . '</option>';
                }
                $select_dinding_bng .= '</select>';
                $data['select_dinding_bng'] = $select_dinding_bng;
                //---------------------------------------------------------------------------------------------------------
                $get_select_konstr_bng = $this->permohonan_online_upt_model->lookup_item_droplist(22, NULL);
                $select_konstr_bng = '<select id="dtl_jns_konstr" required name="dtl_jns_konstr" class="form-control">';
                $select_konstr_bng .= '<option value="">-Silahkan Pilih-</option>';
                foreach ($get_select_konstr_bng as $key => $va) {
                    $selected = '';
                    // if ($ppost['dtl_jns_konstr'] == $va->KD_LOOKUP_ITEM) {
                    //     $selected = 'selected';
                    // }
                    $select_konstr_bng .= '<option ' . $selected . ' value="' . $va->KD_LOOKUP_ITEM . '">' . $va->NM_LOOKUP_ITEM . '</option>';
                }
                $select_konstr_bng .= '</select>';
                $data['select_konstr_bng'] = $select_konstr_bng;
                //---------------------------------------------------------------------------------------------------------
                $get_select_atap_bng = $this->permohonan_online_upt_model->lookup_item_droplist(41, NULL);
                $select_atap_bng = '<select id="dtl_jns_atap" required name="dtl_jns_atap" class="form-control">';
                $select_atap_bng .= '<option value="">-Silahkan Pilih-</option>';
                foreach ($get_select_atap_bng as $key => $va) {
                    $selected = '';
                    // if ($ppost['dtl_jns_atap'] == $va->KD_LOOKUP_ITEM) {
                    //     $selected = 'selected';
                    // }
                    $select_atap_bng .= '<option ' . $selected . ' value="' . $va->KD_LOOKUP_ITEM . '">' . $va->NM_LOOKUP_ITEM . '</option>';
                }
                $select_atap_bng .= '</select>';
                $data['select_atap_bng'] = $select_atap_bng;
                //---------------------------------------------------------------------------------------------------------
                $get_select_jns_lantai = $this->permohonan_online_upt_model->lookup_item_droplist(43, NULL);
                $select_jns_lantai = '<select id="dtl_jns_lantai" required name="dtl_jns_lantai" class="form-control">';
                $select_jns_lantai .= '<option value="">-Silahkan Pilih-</option>';
                foreach ($get_select_jns_lantai as $key => $va) {
                    $selected = '';
                    // if ($ppost['dtl_jns_lantai'] == $va->KD_LOOKUP_ITEM) {
                    //     $selected = 'selected';
                    // }
                    $select_jns_lantai .= '<option ' . $selected . ' value="' . $va->KD_LOOKUP_ITEM . '">' . $va->NM_LOOKUP_ITEM . '</option>';
                }
                $select_jns_lantai .= '</select>';
                $data['select_jns_lantai'] = $select_jns_lantai;
                //---------------------------------------------------------------------------------------------------------
                $get_select_langit = $this->permohonan_online_upt_model->lookup_item_droplist(44, NULL);
                $select_langit = '<select id="dtl_jns_langit" required name="dtl_jns_langit" class="form-control">';
                $select_langit .= '<option value="">-Silahkan Pilih-</option>';
                foreach ($get_select_langit as $key => $va) {
                    $selected = '';
                    // if ($ppost['dtl_jns_lantai'] == $va->KD_LOOKUP_ITEM) {
                    //     $selected = 'selected';
                    // }
                    $select_langit .= '<option ' . $selected . ' value="' . $va->KD_LOOKUP_ITEM . '">' . $va->NM_LOOKUP_ITEM . '</option>';
                }
                $select_langit .= '</select>';
                $data['select_langit'] = $select_langit;
                //---------------------------------------------------------------------------------------------------------
                $get_select_sts_guna = $this->permohonan_online_upt_model->ref_jbp_droplist(NULL);
                $select_sts_guna = '<select id="dtl_guna_bng" required name="dtl_guna_bng" onchange="f_guna_bng(this.value)" class="form-control">';
                $select_sts_guna .= '<option value="">-Silahkan Pilih-</option>';
                foreach ($get_select_sts_guna as $key => $va) {
                    $selected = '';
                    // if ($ppost['dtl_guna_bng'] == $va->KD_JPB) {
                    //     $selected = 'selected';
                    // }
                    $select_sts_guna .= '<option ' . $selected . ' value="' . $va->KD_JPB . '">' . $va->NM_JPB . '</option>';
                }
                $select_sts_guna .= '</select>';
                $data['select_guna_bng'] = $select_sts_guna;

                // //////////////////////////////////////////////////////////////////////////////////////////////////////////
                $list_jpbjpt = $this->permohonan_online_upt_model->lookup_item_droplist(45);
                $opsi_jpbjpt = array('' => 'Silahkan Piih');
                foreach ($list_jpbjpt as $key => $aa) {
                    $opsi_jpbjpt[$aa->KD_LOOKUP_ITEM] = $aa->NM_LOOKUP_ITEM;
                }
                $js  = 'id="jpb02_kls_bng" style="width:100%" class="form-control"';
                $data['select_jpb02_kls_bng'] = form_dropdown('jpb02_kls_bng', $opsi_jpbjpt, '', $js);
                //---------------------------------------------------------------------------------------------------------
                $list_jpbjpt = $this->permohonan_online_upt_model->lookup_item_droplist(46);
                $opsi_jpbjpt = array('' => 'Silahkan Piih');
                foreach ($list_jpbjpt as $key => $aa) {
                    $opsi_jpbjpt[$aa->KD_LOOKUP_ITEM] = $aa->NM_LOOKUP_ITEM;
                }
                $js  = 'id="jpb04_kls_bng" style="width:100%" class="form-control"';
                $data['select_jpb04_kls_bng'] = form_dropdown('jpb04_kls_bng', $opsi_jpbjpt, '', $js);
                //---------------------------------------------------------------------------------------------------------
                $list_jpbjpt = $this->permohonan_online_upt_model->lookup_item_droplist(50);
                $opsi_jpbjpt = array('' => 'Silahkan Piih');
                foreach ($list_jpbjpt as $key => $aa) {
                    $opsi_jpbjpt[$aa->KD_LOOKUP_ITEM] = $aa->NM_LOOKUP_ITEM;
                }
                $js  = 'id="jpb05_kls_bng" style="width:100%" class="form-control"';
                $data['select_jpb05_kls_bng'] = form_dropdown('jpb05_kls_bng', $opsi_jpbjpt, '', $js);
                //---------------------------------------------------------------------------------------------------------
                $list_jpbjpt = $this->permohonan_online_upt_model->lookup_item_droplist(47);
                $opsi_jpbjpt = array('' => 'Silahkan Piih');
                foreach ($list_jpbjpt as $key => $aa) {
                    $opsi_jpbjpt[$aa->KD_LOOKUP_ITEM] = $aa->NM_LOOKUP_ITEM;
                }
                $js  = 'id="jpb06_kls_bng" style="width:100%" class="form-control"';
                $data['select_jpb06_kls_bng'] = form_dropdown('jpb06_kls_bng', $opsi_jpbjpt, '', $js);
                //---------------------------------------------------------------------------------------------------------
                $list_jpbjpt = $this->permohonan_online_upt_model->lookup_item_droplist(28);
                $opsi_jpbjpt = array('' => 'Silahkan Piih');
                foreach ($list_jpbjpt as $key => $aa) {
                    $opsi_jpbjpt[$aa->KD_LOOKUP_ITEM] = $aa->NM_LOOKUP_ITEM;
                }
                $js  = 'id="jpb07_jns_hotel" style="width:100%" class="form-control"';
                $data['select_jpb07_jns_hotel'] = form_dropdown('jpb07_jns_hotel', $opsi_jpbjpt, '', $js);
                //---------------------------------------------------------------------------------------------------------
                $list_jpbjpt = $this->permohonan_online_upt_model->lookup_item_droplist('05');
                $opsi_jpbjpt = array('' => 'Silahkan Piih');
                foreach ($list_jpbjpt as $key => $aa) { 
                    $opsi_jpbjpt[$aa->KD_LOOKUP_ITEM] = $aa->NM_LOOKUP_ITEM;
                }
                $js  = 'id="jpb07_bintang" style="width:100%" class="form-control"';
                $data['select_jpb07_bintang'] = form_dropdown('jpb07_bintang', $opsi_jpbjpt, '', $js);
                //---------------------------------------------------------------------------------------------------------
                $list_jpbjpt = $this->permohonan_online_upt_model->lookup_item_droplist(22);
                $opsi_jpbjpt = array('' => 'Silahkan Piih');
                foreach ($list_jpbjpt as $key => $aa) {
                    $opsi_jpbjpt[$aa->KD_LOOKUP_ITEM] = $aa->NM_LOOKUP_ITEM;
                }
                $js  = 'id="jpb03_konstruksi" style="width:100%" class="form-control"';
                $data['select_jpb03_kons'] = form_dropdown('jpb03_konstruksi', $opsi_jpbjpt, '', $js);
                //---------------------------------------------------------------------------------------------------------
                $list_jpbjpt = $this->permohonan_online_upt_model->lookup_item_droplist(22);
                $opsi_jpbjpt = array('' => 'Silahkan Piih');
                foreach ($list_jpbjpt as $key => $aa) {
                    $opsi_jpbjpt[$aa->KD_LOOKUP_ITEM] = $aa->NM_LOOKUP_ITEM;
                }
                $js  = 'id="jpb08_konstruksi" style="width:100%" class="form-control"';
                $data['select_jpb08_kons'] = form_dropdown('jpb08_konstruksi', $opsi_jpbjpt, '', $js);
                //---------------------------------------------------------------------------------------------------------
                $list_jpbjpt = $this->permohonan_online_upt_model->lookup_item_droplist(45);
                $opsi_jpbjpt = array('' => 'Silahkan Piih');
                foreach ($list_jpbjpt as $key => $aa) {
                    $opsi_jpbjpt[$aa->KD_LOOKUP_ITEM] = $aa->NM_LOOKUP_ITEM;
                }
                $js  = 'id="jpb09_kls_bng" style="width:100%" class="form-control"';
                $data['select_jpb09_kls_bng'] = form_dropdown('jpb09_kls_bng', $opsi_jpbjpt, '', $js);
                //---------------------------------------------------------------------------------------------------------
                $list_jpbjpt = $this->permohonan_online_upt_model->lookup_item_droplist(49);
                $opsi_jpbjpt = array('' => 'Silahkan Piih');
                foreach ($list_jpbjpt as $key => $aa) {
                    $opsi_jpbjpt[$aa->KD_LOOKUP_ITEM] = $aa->NM_LOOKUP_ITEM;
                }
                $js  = 'id="jpb12_kls_bng" style="width:100%" class="form-control"';
                $data['select_jpb12_kls_bng'] = form_dropdown('jpb12_kls_bng', $opsi_jpbjpt, '', $js);
                //---------------------------------------------------------------------------------------------------------
                $list_jpbjpt = $this->permohonan_online_upt_model->lookup_item_droplist(52);
                $opsi_jpbjpt = array('' => 'Silahkan Piih');
                foreach ($list_jpbjpt as $key => $aa) {
                    $opsi_jpbjpt[$aa->KD_LOOKUP_ITEM] = $aa->NM_LOOKUP_ITEM;
                }
                $js  = 'id="jpb13_kls_bng" style="width:100%" class="form-control"';
                $data['select_jpb13_kls_bng'] = form_dropdown('jpb13_kls_bng', $opsi_jpbjpt, '', $js);
                //---------------------------------------------------------------------------------------------------------
                $list_jpbjpt = $this->permohonan_online_upt_model->lookup_item_droplist('09');
                $opsi_jpbjpt = array('' => 'Silahkan Piih');
                foreach ($list_jpbjpt as $key => $aa) {
                    $opsi_jpbjpt[$aa->KD_LOOKUP_ITEM] = $aa->NM_LOOKUP_ITEM;
                }
                $js  = 'id="jpb15_letak_tangki" style="width:100%" class="form-control"';
                $data['select_jpb15_letak_tangki'] = form_dropdown('jpb15_letak_tangki', $opsi_jpbjpt, '', $js);
                //---------------------------------------------------------------------------------------------------------
                $list_jpbjpt = $this->permohonan_online_upt_model->lookup_item_droplist(48);
                $opsi_jpbjpt = array('' => 'Silahkan Piih');
                foreach ($list_jpbjpt as $key => $aa) {
                    $opsi_jpbjpt[$aa->KD_LOOKUP_ITEM] = $aa->NM_LOOKUP_ITEM;
                }
                $js  = 'id="jpb16_kls_bng" style="width:100%" class="form-control"';
                $data['select_jpb16_kls_bng'] = form_dropdown('jpb16_kls_bng', $opsi_jpbjpt, '', $js);
                //---------------------------------------------------------------------------------------------------------
                $list_lookup = $this->permohonan_online_upt_model->lookup_item_droplist(21);
                $opsi_lookup = array('' => 'Silahkan Piih');
                foreach ($list_lookup as $key => $aa) {
                    $opsi_lookup[$aa->KD_LOOKUP_ITEM] = $aa->NM_LOOKUP_ITEM;
                }
                $js  = 'id="l_knd_bng"  style="width:100%" class="form-control"';
                $data['select_knd_bng'] = form_dropdown('l_knd_bng', $opsi_lookup, '', $js);
                //---------------------------------------------------------------------------------------------------------
                $list_lookup = $this->permohonan_online_upt_model->lookup_item_droplist(42);
                $opsi_lookup = array('' => 'Silahkan Piih');
                foreach ($list_lookup as $key => $aa) {
                    $opsi_lookup[$aa->KD_LOOKUP_ITEM] = $aa->NM_LOOKUP_ITEM;
                }
                $js  = 'id="l_dinding"  style="width:100%" class="form-control"';
                $data['select_dinding'] = form_dropdown('l_dinding', $opsi_lookup, '', $js);
                //---------------------------------------------------------------------------------------------------------
                $list_lookup = $this->permohonan_online_upt_model->lookup_item_droplist(43);
                $opsi_lookup = array('' => 'Silahkan Piih');
                foreach ($list_lookup as $key => $aa) {
                    $opsi_lookup[$aa->KD_LOOKUP_ITEM] = $aa->NM_LOOKUP_ITEM;
                }
                $js  = 'id="l_lantai"  style="width:100%" class="form-control"';
                $data['select_llantai'] = form_dropdown('l_lantai', $opsi_lookup, '', $js);
                //---------------------------------------------------------------------------------------------------------
                $list_lookup = $this->permohonan_online_upt_model->lookup_item_droplist(44);
                $opsi_lookup = array('' => 'Silahkan Pilih');
                foreach ($list_lookup as $key => $aa) {
                    $opsi_lookup[$aa->KD_LOOKUP_ITEM] = $aa->NM_LOOKUP_ITEM;
                }
                $js  = 'id="l_langit2"  style="width:100%" class="form-control"';
                $data['select_llangit2'] = form_dropdown('l_langit2', $opsi_lookup, '', $js);
                //---------------------------------------------------------------------------------------------------------
                $list_lookup = $this->permohonan_online_upt_model->lookup_item_droplist(22);
                $opsi_lookup = array('' => 'Silahkan Piih');
                foreach ($list_lookup as $key => $aa) {
                    $opsi_lookup[$aa->KD_LOOKUP_ITEM] = $aa->NM_LOOKUP_ITEM;
                }
                $js  = 'id="jns_konst"  style="width:100%" class="form-control"';
                $data['select_jns_konst'] = form_dropdown('jns_konst', $opsi_lookup, '', $js);
                //---------------------------------------------------------------------------------------------------------
                $list_lookup = $this->permohonan_online_upt_model->lookup_item_droplist(41);
                $opsi_lookup = array('' => 'Silahkan Piih');
                foreach ($list_lookup as $key => $aa) {
                    $opsi_lookup[$aa->KD_LOOKUP_ITEM] = $aa->NM_LOOKUP_ITEM;
                }
                $js  = 'id="jns_atap"  style="width:100%" class="form-control"';
                $data['select_jns_atap'] = form_dropdown('jns_atap', $opsi_lookup, '', $js);
                //---------------------------------------------------------------------------------------------------------
                $list_lookup = $this->permohonan_online_upt_model->ref_fasilitas_droplist();
                $opsi_lookup = array('' => 'Silahkan Piih');
                foreach ($list_lookup as $key => $aa) {
                    $opsi_lookup[$aa->KD_FASILITAS] = $aa->NM_FASILITAS;
                }
                $js  = 'id="dtlfas_kd_fasilitas"  style="width:100%" class="form-control"';
                $data['select_dtl_fas'] = form_dropdown('dtlfas_kd_fasilitas', $opsi_lookup, '', $js);
                //////////////////////////////////////////////////////////////////////////////////////////////////////////

                $this->load->view('vpermohonan_online_upt_edform', $data);
            } else if ($ppo->KD_JNS_PELAYANAN == '15') {
                $dt = $this->permohonan_online_upt_model->get_dt_angsuran($param);
        
                $data['dt'] = array(
                    'nop_re' => $ppo->NOP_LKP, 
                    'id_reg_esppt' => $ppo->NOPNIK, 
                    'rowid' => $ppo->PPO_ID, 
                    'id_ppo' => $ppo->PPO_ID, 
                    'nopel' => $ppo->NOPEL, 
                    'nop' => $ppo->NOP_LKP, 

                    'nama_wp_re' => $ppo->NAMA_WP_REG, 
                    'alamat_op_re' => $ppo->ALAMAT_REG, 
                    'nik_re' => $ppo->NIK_REG, 
                    'no_telp_re' => $ppo->TELP_REG,
                    'nama_re' => $ppo->NAMA_REG, 
                    'email_re' => $ppo->EMAIL_REG,
                    'kd_jns_ply' => $ppo->KD_JNS_PELAYANAN,
                    'no_permohonan' => $ppo->NO_SRT_PERMOHONAN, 
                    'thn_permohonan' => $ppo->THN_PAJAK_PERMOHONAN, 
                    'tgl_permohonan' => get_date($ppo->TGL_SURAT_PERMOHONAN), 
                    'nama_pemohon' => $ppo->NAMA_PEMOHON, 
                    'alamat_pemohon' => $ppo->ALAMAT_PEMOHON, 
                    'telp' => $ppo->NO_HP, 
                    'keterangan' => $ppo->KETERANGAN_PST, 

                    'nama_wp_sppt' => $dt->NM_WP_SPPT, 
                    'alamat_op_sppt' => $dt->ALAMAT_OP_SPPT, 
                    'pbb_yg_harus_dibayar' => $dt->PBB_YG_HARUS_DIBAYAR_SPPT, 

                    
                    


                );

                $data['da'] = (array)$dt;

                $data['fnopnik'] = $ppo->NOPNIK;

                //---------------------------------------------------------------------------------------------------------
                $select_data  = $this->permohonan_online_upt_model->get_jns_ply($ppo->KD_JNS_PELAYANAN);
                if ($select_data) {
                    foreach ($select_data as $row) {
                        $options[$row->KD_JNS_PELAYANAN] = $row->NM_JENIS_PELAYANAN;
                    }
                } else {
                    $options['0'] = 'Data not found';
                }
                // $js     = 'id="jns_ply" required style="width:90%; height:100% !important;" onchange="jns_ply_chg(this.value)" ';
                $js     = 'class="form-control" id="jns_ply" readonly ';
                $select = form_dropdown('jns_ply', $options, $ppo->KD_JNS_PELAYANAN, $js);
                $select = preg_replace("/[\r\n]+/", "", $select);
                $data['select_jns_ply'] = $select;
                //---------------------------------------------------------------------------------------------------------

                $this->load->view('vpermohonan_online_upt_angs_form', $data);
            } else if ($ppo->KD_JNS_PELAYANAN == '08') {
                $dt = $this->permohonan_online_upt_model->get_dt_pengurangan($param);
        
                $data['dt'] = array(
                    'nop_re' => $ppo->NOP_LKP, 
                    'id_reg_esppt' => $ppo->NOPNIK, 
                    'rowid' => $ppo->PPO_ID, 
                    'id_ppo' => $ppo->PPO_ID, 
                    'nopel' => $ppo->NOPEL, 
                    'nop' => $ppo->NOP_LKP, 

                    'nama_wp_re' => $ppo->NAMA_WP_REG, 
                    'alamat_op_re' => $ppo->ALAMAT_REG, 
                    'nik_re' => $ppo->NIK_REG, 
                    'no_telp_re' => $ppo->TELP_REG,
                    'nama_re' => $ppo->NAMA_REG, 
                    'email_re' => $ppo->EMAIL_REG,
                    'kd_jns_ply' => $ppo->KD_JNS_PELAYANAN,
                    'kd_sub_jns_ply' => $ppo->KD_SUB_JNS_PELAYANAN,

                    'no_permohonan' => $ppo->NO_SRT_PERMOHONAN, 
                    'thn_permohonan' => $ppo->THN_PAJAK_PERMOHONAN, 
                    'tgl_permohonan' => get_date($ppo->TGL_SURAT_PERMOHONAN), 
                    'nama_pemohon' => $ppo->NAMA_PEMOHON, 
                    'alamat_pemohon' => $ppo->ALAMAT_PEMOHON, 
                    'telp' => $ppo->NO_HP, 
                    'keterangan' => $ppo->KETERANGAN_PST, 

                    // 'nama_wp_sppt' => $dt->NM_WP_SPPT, 
                    // 'alamat_op_sppt' => $dt->ALAMAT_OP_SPPT, 
                    // 'pbb_yg_harus_dibayar' => $dt->PBB_YG_HARUS_DIBAYAR_SPPT, 

                    'jns_png' => $dt->NM_SUB_JENIS_PELAYANAN,
                    'pct_png' => $dt->PCT_PENGURANGAN,
                    'pct_png_disetujui' => $dt->NM_SUB_JENIS_PELAYANAN,
                    // 'sts_png' => $dt->STS_PENGURANGAN,

                );

                $data['da'] = (array)$dt;

                $data['fnopnik'] = $ppo->NOPNIK;

                //---------------------------------------------------------------------------------------------------------
                $select_data  = $this->permohonan_online_upt_model->get_jns_ply($ppo->KD_JNS_PELAYANAN);
                if ($select_data) {
                    foreach ($select_data as $row) {
                        $options[$row->KD_JNS_PELAYANAN] = $row->NM_JENIS_PELAYANAN;
                    }
                } else {
                    $options['0'] = 'Data not found';
                }
                // $js     = 'id="jns_ply" required style="width:90%; height:100% !important;" onchange="jns_ply_chg(this.value)" ';
                $js     = 'class="form-control" id="jns_ply" readonly ';
                $select = form_dropdown('jns_ply', $options, $ppo->KD_JNS_PELAYANAN, $js);
                $select = preg_replace("/[\r\n]+/", "", $select);
                $data['select_jns_ply'] = $select;
                //---------------------------------------------------------------------------------------------------------
                $select_data_sub  = $this->permohonan_online_upt_model->get_sub_jns_ply($ppo->KD_JNS_PELAYANAN, $ppo->KD_SUB_JNS_PELAYANAN);
                if ($select_data_sub) {
                    foreach ($select_data_sub as $row) {
                        $optionsub[$row->KD_SUB_JNS_PELAYANAN] = $row->NM_SUB_JENIS_PELAYANAN;
                    }
                } else {
                    $optionsub['0'] = 'Data not found';
                }
                $js     = 'class="form-control" id="sub_jns_ply" readonly ';
                $select = form_dropdown('sub_jns_ply', $optionsub, $ppo->KD_SUB_JNS_PELAYANAN, $js);
                $select = preg_replace("/[\r\n]+/", "", $select);
                $data['select_sub_jns_ply'] = $select;
                //---------------------------------------------------------------------------------------------------------

                $this->load->view('vpermohonan_online_upt_08_form', $data);
            } else if ($ppo->KD_JNS_PELAYANAN == '19') {
                
                $data['dt'] = array(
                    'nop_re' => $ppo->NOP_LKP, 
                    'id_reg_esppt' => $ppo->NOPNIK, 
                    'rowid' => $ppo->PPO_ID, 
                    'id_ppo' => $ppo->PPO_ID, 
                    'nopel' => $ppo->NOPEL, 
                    'nop' => $ppo->NOP_LKP, 

                    'nama_wp_re' => $ppo->NAMA_WP_REG, 
                    'alamat_op_re' => $ppo->ALAMAT_REG, 
                    'nik_re' => $ppo->NIK_REG, 
                    'no_telp_re' => $ppo->TELP_REG,
                    'nama_re' => $ppo->NAMA_REG, 
                    'email_re' => $ppo->EMAIL_REG,
                    'kd_jns_ply' => $ppo->KD_JNS_PELAYANAN,
                    'kd_sub_jns_ply' => $ppo->KD_SUB_JNS_PELAYANAN,

                    'no_permohonan' => $ppo->NO_SRT_PERMOHONAN, 
                    'thn_permohonan' => $ppo->THN_PAJAK_PERMOHONAN, 
                    'tgl_permohonan' => get_date($ppo->TGL_SURAT_PERMOHONAN), 
                    'nama_pemohon' => $ppo->NAMA_PEMOHON, 
                    'alamat_pemohon' => $ppo->ALAMAT_PEMOHON, 
                    'telp' => $ppo->NO_HP, 
                    'keterangan' => $ppo->KETERANGAN_PST, 

                    'jml_mutasi' => $ppo->JML_MUTASI,

                );

                $data['fnopnik'] = $ppo->NOPNIK;

                //---------------------------------------------------------------------------------------------------------
                $select_data  = $this->permohonan_online_upt_model->get_jns_ply($ppo->KD_JNS_PELAYANAN);
                if ($select_data) {
                    foreach ($select_data as $row) {
                        $options[$row->KD_JNS_PELAYANAN] = $row->NM_JENIS_PELAYANAN;
                    }
                } else {
                    $options['0'] = 'Data not found';
                }
                // $js     = 'id="jns_ply" required style="width:90%; height:100% !important;" onchange="jns_ply_chg(this.value)" ';
                $js     = 'class="form-control" id="jns_ply" readonly ';
                $select = form_dropdown('jns_ply', $options, $ppo->KD_JNS_PELAYANAN, $js);
                $select = preg_replace("/[\r\n]+/", "", $select);
                $data['select_jns_ply'] = $select;
                //---------------------------------------------------------------------------------------------------------

                $this->load->view('vpermohonan_online_upt_19_form', $data);
            }

        } else {
            $this->session->set_flashdata('msg_danger', 'Data tidak ditemukan..');
            redirect(active_module_url('permohonan_online_upt'));
        }

    }

    function update() {
        $nop_lkp    = $this->input->post('nop');
        $nop        = $this->input->post('nop');
        $nop        = str_replace(".", "", $nop);
        $nop        = str_replace("-", "", $nop);

        $id_ppo         = $this->input->post('id_ppo');

        //// cek heula
        $qr_cek = "SELECT COUNT(*) AS JML FROM PST_PERMOHONAN_TOOL WHERE ID = ? AND STATUS_PERMOHONAN = '1'";
        $cek_heula = $this->db->query($qr_cek, [$id_ppo])->row()->JML;

        if ($cek_heula > 0) {
            $this->session->set_flashdata('msg_info', "Data sudah dikirim. Tidak bisa edit data");
            redirect('tool_pbb/permohonan_online_upt');
        }


        $nama_pemohon   = $this->input->post('nama_pemohon');
        $alamat_pemohon = $this->input->post('alamat_pemohon');
        $telp           = $this->input->post('telp');
        $keterangan     = $this->input->post('keterangan');
        $jns_ply        = $this->input->post('jns_ply');
        $thn_permohonan = $this->input->post('thn_permohonan');

        $nik_wp_sppt            = $this->input->post('nik_wp_sppt');
        $nm_wp_sppt             = $this->input->post('nm_wp_sppt');
        $jln_wp_sppt            = $this->input->post('jln_wp_sppt');
        $blok_kav_no_wp_sppt    = $this->input->post('blok_kav_no_wp_sppt');
        $rt_wp_sppt             = $this->input->post('rt_wp_sppt');
        $rw_wp_sppt             = $this->input->post('rw_wp_sppt');
        $kelurahan_wp_sppt      = $this->input->post('kelurahan_wp_sppt');
        $kota_wp_sppt           = $this->input->post('kota_wp_sppt');
        $kd_pos_wp_sppt         = $this->input->post('kd_pos_wp_sppt');
        $nohp                   = $this->input->post('nohp');
        $email_wp_sppt          = $this->input->post('email_wp_sppt');
        $sts_op                 = $this->input->post('sts_op');
        $pekerjaan_wp           = $this->input->post('pekerjaan_wp');

        $luas_tanah             = $this->input->post('luas_tanah');
        $jln_op_sppt            = $this->input->post('jln_op_sppt');
        $blok_kav_no_op_sppt    = $this->input->post('blok_kav_no_op_sppt');
        $rt_op_sppt             = $this->input->post('rt_op_sppt');
        $rw_op_sppt             = $this->input->post('rw_op_sppt');
        $jns_tanah_op           = $this->input->post('jns_tanah_op');

        $return_date = new stdClass();

        //// update pst_permohonan_tool
        $fL_SPMKP_PBB1 = empty($_FILES['L_SPMKP_PBB1']['name']) ? 0 : 1;
        $fL_SURAT_KUASA1 = empty($_FILES['L_SURAT_KUASA1']['name']) ? 0 : 1;
        $fL_SKKP_PBB1 = empty($_FILES['L_SKKP_PBB1']['name']) ? 0 : 1;
        $fL_SERTIFIKAT_TANAH1 = empty($_FILES['L_SERTIFIKAT_TANAH1']['name']) ? 0 : 1;
        $fL_IMB1 = empty($_FILES['L_IMB1']['name']) ? 0 : 1;
        $fL_AKTE_JUAL_BELI1 = empty($_FILES['L_AKTE_JUAL_BELI1']['name']) ? 0 : 1;
        $fL_PERMOHONAN1 = empty($_FILES['L_PERMOHONAN1']['name']) ? 0 : 1;
        $fL_STTS1 = empty($_FILES['L_STTS1']['name']) ? 0 : 1;
        $fL_SK_KEBERATAN1 = empty($_FILES['L_SK_KEBERATAN1']['name']) ? 0 : 1;
        $fL_SPPT_STTS1 = empty($_FILES['L_SPPT_STTS1']['name']) ? 0 : 1;
        $fL_SPPT1 = empty($_FILES['L_SPPT1']['name']) ? 0 : 1;
        $fL_KTP_WP1 = empty($_FILES['L_KTP_WP1']['name']) ? 0 : 1;
        $fL_SK_PENGURANGAN1 = empty($_FILES['L_SK_PENGURANGAN1']['name']) ? 0 : 1;
        $fL_LAIN_LAIN1 = empty($_FILES['L_LAIN_LAIN1']['name']) ? 0 : 1;

        $L_SPMKP_PBB1 = $fL_SPMKP_PBB1 == 0 ? NULL : file_get_contents($_FILES['L_SPMKP_PBB1']['tmp_name']);
        $L_SURAT_KUASA1 = $fL_SURAT_KUASA1 == 0 ? NULL : file_get_contents($_FILES['L_SURAT_KUASA1']['tmp_name']);
        $L_SKKP_PBB1 = $fL_SKKP_PBB1 == 0 ? NULL : file_get_contents($_FILES['L_SKKP_PBB1']['tmp_name']);
        $L_SERTIFIKAT_TANAH1 = $fL_SERTIFIKAT_TANAH1 == 0 ? NULL : file_get_contents($_FILES['L_SERTIFIKAT_TANAH1']['tmp_name']);
        $L_IMB1 = $fL_IMB1 == 0 ? NULL : file_get_contents($_FILES['L_IMB1']['tmp_name']);
        $L_AKTE_JUAL_BELI1 = $fL_AKTE_JUAL_BELI1 == 0 ? NULL : file_get_contents($_FILES['L_AKTE_JUAL_BELI1']['tmp_name']);
        $L_PERMOHONAN1 = $fL_PERMOHONAN1 == 0 ? NULL : file_get_contents($_FILES['L_PERMOHONAN1']['tmp_name']);
        $L_STTS1 = $fL_STTS1 == 0 ? NULL : file_get_contents($_FILES['L_STTS1']['tmp_name']);
        $L_SK_KEBERATAN1 = $fL_SK_KEBERATAN1 == 0 ? NULL : file_get_contents($_FILES['L_SK_KEBERATAN1']['tmp_name']);
        $L_SPPT_STTS1 = $fL_SPPT_STTS1 == 0 ? NULL : file_get_contents($_FILES['L_SPPT_STTS1']['tmp_name']);
        $L_SPPT1 = $fL_SPPT1 == 0 ? NULL : file_get_contents($_FILES['L_SPPT1']['tmp_name']);
        $L_KTP_WP1 = $fL_KTP_WP1 == 0 ? NULL : file_get_contents($_FILES['L_KTP_WP1']['tmp_name']);
        $L_SK_PENGURANGAN1 = $fL_SK_PENGURANGAN1 == 0 ? NULL : file_get_contents($_FILES['L_SK_PENGURANGAN1']['tmp_name']);
        $L_LAIN_LAIN1 = $fL_LAIN_LAIN1 == 0 ? NULL : file_get_contents($_FILES['L_LAIN_LAIN1']['tmp_name']);

        //// cek max size
        $max_size_error = [];
        $fields = [
            'L_SPMKP_PBB1',
            'L_SURAT_KUASA1',
            'L_SKKP_PBB1',
            'L_SERTIFIKAT_TANAH1',
            'L_IMB1',
            'L_AKTE_JUAL_BELI1',
            'L_PERMOHONAN1',
            'L_STTS1',
            'L_SK_KEBERATAN1',
            'L_SPPT_STTS1',
            'L_SPPT1',
            'L_KTP_WP1',
            'L_SK_PENGURANGAN1',
            'L_LAIN_LAIN1'
        ];

        foreach ($fields as $f) {
            if (!$this->cek_max_size($f, 3)) {
                $max_size_error[] = $f;
            }
        }

        if (!empty($max_size_error)) {
            echo json_encode([
                'result' => 400,
                'msg' => 'Ukuran file terlalu besar (maksimal 3MB)'
                // 'msg' => 'Ukuran file terlalu besar (maksimal 3MB): ' . implode(', ', $max_size_error)
            ]);
            return;
        }

        $set_blob = "";

        if ($fL_SKKP_PBB1 == 1) $set_blob .= " , L_SKKP_PBB1 = EMPTY_BLOB()";
        if ($fL_SPMKP_PBB1 == 1) $set_blob .= " , L_SPMKP_PBB1 = EMPTY_BLOB()";
        if ($fL_SURAT_KUASA1 == 1) $set_blob .= " , L_SURAT_KUASA1 = EMPTY_BLOB()";
        if ($fL_PERMOHONAN1 == 1) $set_blob .= " , L_PERMOHONAN1 = EMPTY_BLOB()";
        if ($fL_STTS1 == 1) $set_blob .= " , L_STTS1 = EMPTY_BLOB()";
        if ($fL_SK_KEBERATAN1 == 1) $set_blob .= " , L_SK_KEBERATAN1 = EMPTY_BLOB()";
        if ($fL_SPPT_STTS1 == 1) $set_blob .= " , L_SPPT_STTS1 = EMPTY_BLOB()";
        if ($fL_KTP_WP1 == 1) $set_blob .= " , L_KTP_WP1 = EMPTY_BLOB()";
        if ($fL_SERTIFIKAT_TANAH1 == 1) $set_blob .= " , L_SERTIFIKAT_TANAH1 = EMPTY_BLOB()";
        if ($fL_IMB1 == 1) $set_blob .= " , L_IMB1 = EMPTY_BLOB()";
        if ($fL_AKTE_JUAL_BELI1 == 1) $set_blob .= " , L_AKTE_JUAL_BELI1 = EMPTY_BLOB()";
        if ($fL_SPPT1 == 1) $set_blob .= " , L_SPPT1 = EMPTY_BLOB()";
        if ($fL_SK_PENGURANGAN1 == 1) $set_blob .= " , L_SK_PENGURANGAN1 = EMPTY_BLOB()";
        if ($fL_LAIN_LAIN1 == 1) $set_blob .= " , L_LAIN_LAIN1 = EMPTY_BLOB()";

        $dbhost = DB_HOST;
        $dbport = DB_PORT;
        $dbname = DB_NAME;
        $dbuser = DB_USER;
        $dbpass = DB_PASS;

        $tnslistener = '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST='.DB_HOST.')(PORT='.DB_PORT.'))(CONNECT_DATA=(SERVICE_NAME='.DB_NAME.')))';
        $connection = oci_connect($dbuser, $dbpass, $tnslistener);

        $qq = "
            UPDATE PST_PERMOHONAN_TOOL
            SET 
                NAMA_PEMOHON     = '$nama_pemohon',
                ALAMAT_PEMOHON   = '$alamat_pemohon',
                NO_HP            = '$telp',
                KETERANGAN_PST   = '$keterangan',
                STATUS_PERMOHONAN = '1'
                $set_blob
            WHERE ID = {$id_ppo}
            RETURNING
                L_SKKP_PBB1, L_SPMKP_PBB1, L_SURAT_KUASA1, L_PERMOHONAN1, L_STTS1, L_SK_KEBERATAN1,
                L_SPPT_STTS1, L_KTP_WP1, L_SERTIFIKAT_TANAH1, L_IMB1, L_AKTE_JUAL_BELI1, L_SPPT1,
                L_SK_PENGURANGAN1, L_LAIN_LAIN1
            INTO
                :blob1, :blob2, :blob3, :blob4, :blob5, :blob6,
                :blob7, :blob8, :blob9, :blob10, :blob11, :blob12,
                :blob13, :blob14";

        $result = oci_parse($connection, $qq);

        $blob1  = oci_new_descriptor($connection, OCI_D_LOB);
        $blob2  = oci_new_descriptor($connection, OCI_D_LOB);
        $blob3  = oci_new_descriptor($connection, OCI_D_LOB);
        $blob4  = oci_new_descriptor($connection, OCI_D_LOB);
        $blob5  = oci_new_descriptor($connection, OCI_D_LOB);
        $blob6  = oci_new_descriptor($connection, OCI_D_LOB);
        $blob7  = oci_new_descriptor($connection, OCI_D_LOB);
        $blob8  = oci_new_descriptor($connection, OCI_D_LOB);
        $blob9  = oci_new_descriptor($connection, OCI_D_LOB);
        $blob10 = oci_new_descriptor($connection, OCI_D_LOB);
        $blob11 = oci_new_descriptor($connection, OCI_D_LOB);
        $blob12 = oci_new_descriptor($connection, OCI_D_LOB);
        $blob13 = oci_new_descriptor($connection, OCI_D_LOB);
        $blob14 = oci_new_descriptor($connection, OCI_D_LOB);

        oci_bind_by_name($result, ":blob1",  $blob1,  -1, OCI_B_BLOB);
        oci_bind_by_name($result, ":blob2",  $blob2,  -1, OCI_B_BLOB);
        oci_bind_by_name($result, ":blob3",  $blob3,  -1, OCI_B_BLOB);
        oci_bind_by_name($result, ":blob4",  $blob4,  -1, OCI_B_BLOB);
        oci_bind_by_name($result, ":blob5",  $blob5,  -1, OCI_B_BLOB);
        oci_bind_by_name($result, ":blob6",  $blob6,  -1, OCI_B_BLOB);
        oci_bind_by_name($result, ":blob7",  $blob7,  -1, OCI_B_BLOB);
        oci_bind_by_name($result, ":blob8",  $blob8,  -1, OCI_B_BLOB);
        oci_bind_by_name($result, ":blob9",  $blob9,  -1, OCI_B_BLOB);
        oci_bind_by_name($result, ":blob10", $blob10, -1, OCI_B_BLOB);
        oci_bind_by_name($result, ":blob11", $blob11, -1, OCI_B_BLOB);
        oci_bind_by_name($result, ":blob12", $blob12, -1, OCI_B_BLOB);
        oci_bind_by_name($result, ":blob13", $blob13, -1, OCI_B_BLOB);
        oci_bind_by_name($result, ":blob14", $blob14, -1, OCI_B_BLOB);

        oci_execute($result, OCI_DEFAULT);

        // SAVE BLOB DATA
        if ($fL_SKKP_PBB1 == 1) $blob1->save($L_SKKP_PBB1);
        if ($fL_SPMKP_PBB1 == 1) $blob2->save($L_SPMKP_PBB1);
        if ($fL_SURAT_KUASA1 == 1) $blob3->save($L_SURAT_KUASA1);
        if ($fL_PERMOHONAN1 == 1) $blob4->save($L_PERMOHONAN1);
        if ($fL_STTS1 == 1) $blob5->save($L_STTS1);
        if ($fL_SK_KEBERATAN1 == 1) $blob6->save($L_SK_KEBERATAN1);
        if ($fL_SPPT_STTS1 == 1) $blob7->save($L_SPPT_STTS1);
        if ($fL_KTP_WP1 == 1) $blob8->save($L_KTP_WP1);
        if ($fL_SERTIFIKAT_TANAH1 == 1) $blob9->save($L_SERTIFIKAT_TANAH1);
        if ($fL_IMB1 == 1) $blob10->save($L_IMB1);
        if ($fL_AKTE_JUAL_BELI1 == 1) $blob11->save($L_AKTE_JUAL_BELI1);
        if ($fL_SPPT1 == 1) $blob12->save($L_SPPT1);
        if ($fL_SK_PENGURANGAN1 == 1) $blob13->save($L_SK_PENGURANGAN1);
        if ($fL_LAIN_LAIN1 == 1) $blob14->save($L_LAIN_LAIN1);

        oci_commit($connection);

        if (!oci_commit($connection)) {
            // return 0;
            $data->result       = '400';
            $data->msg          = 'Gagal Simpan Data Permohonan Online';
        } else {
            $error_CRUD = "";

            if ($jns_ply == '02') {                 //// MUTASI HABIS
                $sql = " BEGIN
                            BEGIN
                            UPDATE DAT_SUBJEK_PAJAK_ONLINE
                            SET SUBJEK_PAJAK_ID = '$nik_wp_sppt',
                            NM_WP = '$nm_wp_sppt',
                            JALAN_WP = '$jln_wp_sppt',
                            BLOK_KAV_NO_WP = '$blok_kav_no_wp_sppt',
                            RT_WP = '$rt_wp_sppt',
                            RW_WP = '$rw_wp_sppt',
                            KELURAHAN_WP = '$kelurahan_wp_sppt',
                            KOTA_WP = '$kota_wp_sppt',
                            KD_POS_WP = '$kd_pos_wp_sppt',
                            TELP_WP = '$nohp',
                            HP_WP = '$nohp',
                            EMAIL_WP = '$email_wp_sppt',
                            STATUS_PEKERJAAN_WP = '$pekerjaan_wp'
                            WHERE DOCH_ID = $id_ppo ;
                            EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                            END; 

                            BEGIN
                            UPDATE DAT_OBJEK_PAJAK_ONLINE
                            SET KD_STATUS_WP = '$sts_op'
                            WHERE DOCH_ID = $id_ppo ;
                            EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                            END; 
                        COMMIT; END;";

                $error_msg = $this->db->simple_qry_eon_ora($sql);
                $err_Msg = $error_msg['message'];
                if (!empty($err_Msg)) {
                    $error_CRUD = $err_Msg;
                }

            } else if ($jns_ply == '03') {          //// PEMBETULAN
                $sql = " BEGIN
                            BEGIN
                            UPDATE DAT_SUBJEK_PAJAK_ONLINE
                            SET NM_WP = '$nm_wp_sppt',
                            JALAN_WP = '$jln_wp_sppt',
                            BLOK_KAV_NO_WP = '$blok_kav_no_wp_sppt',
                            RT_WP = '$rt_wp_sppt',
                            RW_WP = '$rw_wp_sppt',
                            KELURAHAN_WP = '$kelurahan_wp_sppt',
                            KOTA_WP = '$kota_wp_sppt',
                            KD_POS_WP = '$kd_pos_wp_sppt',
                            TELP_WP = '$nohp',
                            HP_WP = '$nohp',
                            EMAIL_WP = '$email_wp_sppt',
                            STATUS_PEKERJAAN_WP = '$pekerjaan_wp'
                            WHERE DOCH_ID = $id_ppo ;
                            EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                            END; 

                            BEGIN
                            UPDATE DAT_OBJEK_PAJAK_ONLINE
                            SET KD_STATUS_WP = '$sts_op',
                            TOTAL_LUAS_BUMI = $luas_tanah,
                            JALAN_OP = '$jln_op_sppt', 
                            BLOK_KAV_NO_OP = '$blok_kav_no_op_sppt', 
                            RT_OP = '$rt_op_sppt', 
                            RW_OP = '$rw_op_sppt'
                            WHERE DOCH_ID = $id_ppo ;
                            EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                            END; 

                            BEGIN
                            UPDATE DAT_OP_BUMI_ONLINE
                            SET LUAS_BUMI = $luas_tanah,
                            JNS_BUMI = '$jns_tanah_op'
                            WHERE DOCH_ID = $id_ppo ;
                            EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                            END; 
                        COMMIT; END;";

                $error_msg = $this->db->simple_qry_eon_ora($sql);
                $err_Msg = $error_msg['message'];
                if (!empty($err_Msg)) {
                    $error_CRUD = $err_Msg;
                }
            } else if ($jns_ply == '15') {          //// ANGSURAN
                $tm1 = $this->input->post('jatuh_tempo_1');
                $tm2 = $this->input->post('jatuh_tempo_2');
                $tm3 = $this->input->post('jatuh_tempo_3');
                $tm4 = $this->input->post('jatuh_tempo_4');
                $jt1 = empty($tm1) ? '' : date('d-m-Y', strtotime($tm1));
                $jt2 = empty($tm2) ? '' : date('d-m-Y', strtotime($tm2));
                $jt3 = empty($tm3) ? '' : date('d-m-Y', strtotime($tm3));
                $jt4 = empty($tm4) ? '' : date('d-m-Y', strtotime($tm4));
                
                $ccl_1 = post_decimal($this->input->post('nominal_1'));
                $ccl_2 = post_decimal($this->input->post('nominal_2'));
                $ccl_3 = post_decimal($this->input->post('nominal_3'));
                $ccl_4 = post_decimal($this->input->post('nominal_4'));

                $cicilan_1  = $ccl_1 == 0 ? 'NULL' : (int)$ccl_1;
                $jt_tempo_1 = $ccl_1 == 0 ? 'NULL' : "TO_DATE('$jt1','DD-MM-YYYY')";
                $cicilan_2  = $ccl_2 == 0 ? 'NULL' : (int)$ccl_2;
                $jt_tempo_2 = $ccl_2 == 0 ? 'NULL' : "TO_DATE('$jt2','DD-MM-YYYY')";
                $cicilan_3  = $ccl_3 == 0 ? 'NULL' : (int)$ccl_3;
                $jt_tempo_3 = $ccl_3 == 0 ? 'NULL' : "TO_DATE('$jt3','DD-MM-YYYY')";
                $cicilan_4  = $ccl_4 == 0 ? 'NULL' : (int)$ccl_4;
                $jt_tempo_4 = $ccl_4 == 0 ? 'NULL' : "TO_DATE('$jt4','DD-MM-YYYY')";

                $sql = " BEGIN
                            BEGIN
                                INSERT INTO PST_PERMOHONAN_ANGSURAN
                                SELECT KD_KANWIL, KD_KANTOR, THN_PELAYANAN, BUNDEL_PELAYANAN, NO_URUT_PELAYANAN, KD_PROPINSI_PEMOHON,
                                KD_DATI2_PEMOHON, KD_KECAMATAN_PEMOHON, KD_KELURAHAN_PEMOHON, KD_BLOK_PEMOHON, NO_URUT_PEMOHON,
                                KD_JNS_OP_PEMOHON,
                                $jt_tempo_1, $cicilan_1,
                                $jt_tempo_2, $cicilan_2,
                                $jt_tempo_3, $cicilan_3,
                                $jt_tempo_4, $cicilan_4,
                                THN_PAJAK_PERMOHONAN
                                FROM PST_PERMOHONAN_TOOL WHERE ID = $id_ppo ;
                            EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                            END; 
                        COMMIT; END;";

                // var_dump($sql); die;

                $error_msg = $this->db->simple_qry_eon_ora($sql);
                $err_Msg = $error_msg['message'];
                if (!empty($err_Msg)) {
                    $error_CRUD = $err_Msg;
                }
            }

            if (empty($error_CRUD)) {
                // $qr_ply     = $this->db->query("SELECT NM_JENIS_PELAYANAN FROM REF_JNS_PELAYANAN WHERE KD_JNS_PELAYANAN = '{$jns_ply}'");
                // $nm_jns_ply = $qr_ply->row()->NM_JENIS_PELAYANAN;
                // return 1;
                // $return_date->result       = 200;
                // $return_date->msg          = 'Berhasil Kirim Data Permohonan Online';
                // $return_date->dtl_nop      = $nop;
                // $return_date->dtl_nop_tx   = $nop_lkp;
                // $return_date->dtl_ply      = $jns_ply;
                // $return_date->dtl_ply_tx   = $nm_jns_ply;
                // $return_date->dtl_thn_ply  = $thn_permohonan;
                // $return_date->dtl_id_ppo   = $id_ppo;

                //// kirim email
                $getdt      = $this->permohonan_online_upt_model->get_prm_online($id_ppo);
                $nopel      = $getdt->NO_PLY;
                $nop_lkp    = $getdt->NOP_LKP;
                $jns_ply_tx = $getdt->NM_JENIS_PELAYANAN;
                $tgl_kirim  = $getdt->TGL_SURAT_PERMOHONAN;
                $ket        = $getdt->ALASAN;
                $email      = $getdt->EMAIL;
                $pct_png    = $getdt->PCT_PENGURANGAN;
                $tgl_perkiraan_selesai  = $getdt->TGL_PERKIRAAN_SELESAI;

                $kd_jns_ply = $getdt->KD_JNS_PELAYANAN;
                $kd_sub_jns_ply = $getdt->KD_SUB_JNS_PELAYANAN;

                $d_today = date('d-m-Y');


                $data = new stdClass();

                //// KIRIM EMAIL

                $config = array(
                    'protocol' => SMTP_PROTOCOL,
                    'smtp_host' => SMTP_HOST, //sesuaikan dengan host pengirim
                    'smtp_port' => SMTP_PORT,
                    'smtp_timeout' => 20,
                    'smtp_user' => SMTP_USER, //sesuaikan dengan email yg dipakai
                    'smtp_pass' => SMTP_PASS, //password host
                    'smtp_username' => SMTP_UNAME,
                    'mailtype' => SMTP_TYPE,
                    'charset' => SMTP_CHARSET,
                    'wordwrap' => true,
                );  

                $message = '
                            <html>
                            <head>
                                <title>Bukti Pengiriman Berkas Permohonan Online E-SPPT Kab. Bogor</title>
                            </head>
                            <body style="font-family: Arial, sans-serif; background-color: #f6f9fc; margin: 0; padding: 20px;">
                                <table align="center" cellpadding="0" cellspacing="0" width="600" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                                    <tr>
                                        <td style="background-color: #2b8a3e; padding: 16px; border-radius: 8px 8px 0 0; text-align: center; color: #ffffff;">
                                            <h2 style="margin: 0;">BUKTI PENGIRIMAN BERKAS PERMOHONAN ONLINE PBB KABUPATEN BOGOR</h2>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 30px;">
                                            <p style="font-size: 16px; color: #555;">NO PELAYANAN : '.$nopel.'</p>
                                            <p style="font-size: 16px; color: #555;">NOP : '.$nop_lkp.' </p>
                                            <p style="font-size: 16px; color: #555;">JENIS PELAYANAN : '.$jns_ply_tx.' </p>
                            ';
                if ($kd_jns_ply == '03') {
                    $nm_sub = $this->db->query("SELECT NM_SUB_JENIS_PELAYANAN FROM REF_SUB_JNS_PELAYANAN 
                                                WHERE KD_JNS_PELAYANAN = '$kd_jns_ply' AND KD_SUB_JNS_PELAYANAN = '$kd_sub_jns_ply' ")
                                        ->row()->NM_SUB_JENIS_PELAYANAN;

                    $message .= '           <p style="font-size: 16px; color: #555;">SUB JENIS PELAYANAN : '.$nm_sub.' </p>';
                }
                if ($kd_jns_ply == '15') {
                    if ($ccl_1 > 0 ){
                        $message .= '           <p style="font-size: 16px; color: #555;">ANGSURAN 1 : '.fmt_number($ccl_1).' </p>';
                        $message .= '           <p style="font-size: 16px; color: #555;">JATUH TEMPO ANGSURAN 1 : '.$jt1.' </p>';
                    }
                    if ($ccl_2 > 0 ){
                        $message .= '           <p style="font-size: 16px; color: #555;">ANGSURAN 2 : '.fmt_number($ccl_2).' </p>';
                        $message .= '           <p style="font-size: 16px; color: #555;">JATUH TEMPO ANGSURAN 2 : '.$jt2.' </p>';
                    }
                    if ($ccl_3 > 0 ){
                        $message .= '           <p style="font-size: 16px; color: #555;">ANGSURAN 3 : '.fmt_number($ccl_3).' </p>';
                        $message .= '           <p style="font-size: 16px; color: #555;">JATUH TEMPO ANGSURAN 3 : '.$jt3.' </p>';
                    }
                    if ($ccl_4 > 0 ){
                        $message .= '           <p style="font-size: 16px; color: #555;">ANGSURAN 4 : '.fmt_number($ccl_4).' </p>';
                        $message .= '           <p style="font-size: 16px; color: #555;">JATUH TEMPO ANGSURAN 4 : '.$jt4.' </p>';
                    }
                }
                if ($kd_jns_ply == '08') {
                    $nm_sub = $this->db->query("SELECT NM_SUB_JENIS_PELAYANAN FROM REF_SUB_JNS_PELAYANAN 
                                                WHERE KD_JNS_PELAYANAN = '$kd_jns_ply' AND TRIM(KD_SUB_JNS_PELAYANAN) = TRIM('$kd_sub_jns_ply') ")
                                        ->row()->NM_SUB_JENIS_PELAYANAN;

                    $message .= '           <p style="font-size: 16px; color: #555;">JENIS PENGURANGAN : '.$nm_sub.' </p>';
                    $message .= '           <p style="font-size: 16px; color: #555;">PERSENTASE PENGURANGAN : '.$pct_png.' % </p>';
                }
                $message .= '
                                            <p style="font-size: 16px; color: #555;">TGL KIRIM BERKAS : '.$tgl_kirim.' </p>
                                            <p style="font-size: 16px; color: #555;">TGL PERKIRAAN SELESAI : '.$tgl_perkiraan_selesai.' </p>
                                            <p style="font-size: 16px; color: #555;">KETERANGAN : '.$ket.' </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 30px; text-align: center;">
                                            <p style="font-size: 16px; color: #555;">Cibinong, '.$d_today.'</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #f0f0f0; text-align: center; padding: 15px; font-size: 13px; color: #999; border-radius: 0 0 8px 8px;">
                                             '.date('Y').' Bappenda Kabupaten Bogor
                                        </td>
                                    </tr>
                                </table>
                            </body>
                            </html>';


                $this->load->library('email', $config);
                $this->email->set_newline("\r\n");
                $this->email->from(SMTP_USER, SMTP_UNAME);
                $this->email->to($email);
                $this->email->subject('BUKTI PENGIRIMAN BERKAS NOMOR PELAYANAN '.$nopel);
                $this->email->message($message);
                ////sending email
                if ($this->email->send()) {
                    $return_date->result       = 200;
                    $return_date->msg          = 'Berhasil Kirim Data Permohonan Online (Sukses Kirim Email)';
                } else {
                    $data->result       = 201;
                    $data->msg          = 'Berhasil Kirim Data Permohonan Online (Gagal Kirim Email)';
                    // echo $this->email->print_debugger();
                }
            } else {
                $qr_gagal = $this->db->query("UPDATE PST_PERMOHONAN_TOOL SET STATUS_PERMOHONAN = '4' WHERE ID = {$id_ppo}");
                $return_date->result       = 400;
                $return_date->msg          = 'Data gagal disimpan Silahkan refresh halaman.';
            }
        }

        echo json_encode($return_date);

    }

    function get_dtl_bng() {
        $id_dtl = $this->uri->segment(4);
        $data = $this->permohonan_online_upt_model->get_dtl_bng($id_dtl);
        echo json_encode($data);
    }

    function save_dtl_bangunan() {
        $p_id               = $this->input->post('id_ppo');
        $id_dop             = $this->input->post('id_dop');
        $urut_mutasi        = $this->input->post('urut_mutasi');
        $paramm             = $this->input->post('paramm');
        $dtl_id             = $this->input->post('dtl_id');
        $dtl_model          = $this->input->post('dtl_model');
        $dtl_no_bng         = $this->input->post('dtl_no_bng');
        $dtl_luas_bng       = $this->input->post('dtl_luas_bng');
        $dtl_guna_bng       = $this->input->post('dtl_guna_bng');
        $dtl_thn_bng        = $this->input->post('dtl_thn_bng');
        $dtl_thn_renov      = $this->input->post('dtl_thn_renov');
        $dtl_jml_lantai     = $this->input->post('dtl_jml_lantai');
        $dtl_kondisi_bng    = $this->input->post('dtl_kondisi_bng');
        $dtl_jns_konstr     = $this->input->post('dtl_jns_konstr');
        $dtl_jns_atap       = $this->input->post('dtl_jns_atap');
        $dtl_jns_dinding    = $this->input->post('dtl_jns_dinding');
        $dtl_jns_lantai     = $this->input->post('dtl_jns_lantai');
        $dtl_jns_langit     = $this->input->post('dtl_jns_langit');
        $dtl_nil_individu   = post_decimal($this->input->post('dtl_nil_individu'));
        $jpb02_kls_bng      = $this->input->post('jpb02_kls_bng');
        $jpb03_tinggi       = $this->input->post('jpb03_tinggi');
        $jpb03_daya         = $this->input->post('jpb03_daya');
        $jpb03_lebar        = $this->input->post('jpb03_lebar');
        $jpb03_keliling     = $this->input->post('jpb03_keliling');
        $jpb03_luas         = $this->input->post('jpb03_luas');
        $jpb03_konstruksi   = $this->input->post('jpb03_konstruksi');
        $jpb04_kls_bng      = $this->input->post('jpb04_kls_bng');
        $jpb05_kls_bng      = $this->input->post('jpb05_kls_bng');
        $jpb05_ruang_ac     = $this->input->post('jpb05_ruang_ac');
        $jpb05_ruang_lain   = $this->input->post('jpb05_ruang_lain');
        $jpb06_kls_bng      = $this->input->post('jpb06_kls_bng');
        $jpb07_jns_hotel    = $this->input->post('jpb07_jns_hotel');
        $jpb07_bintang      = $this->input->post('jpb07_bintang');
        $jpb07_jml_kamar    = $this->input->post('jpb07_jml_kamar');
        $jpb07_ruang_ac     = $this->input->post('jpb07_ruang_ac');
        $jpb07_ruang_lain   = $this->input->post('jpb07_ruang_lain');
        $jpb08_tinggi       = $this->input->post('jpb08_tinggi');
        $jpb08_daya         = $this->input->post('jpb08_daya');
        $jpb08_lebar        = $this->input->post('jpb08_lebar');
        $jpb08_keliling     = $this->input->post('jpb08_keliling');
        $jpb08_luas         = $this->input->post('jpb08_luas');
        $jpb08_konstruksi   = $this->input->post('jpb08_konstruksi');
        $jpb09_kls_bng      = $this->input->post('jpb09_kls_bng');
        $jpb12_kls_bng      = $this->input->post('jpb12_kls_bng');
        $jpb13_kls_bng      = $this->input->post('jpb13_kls_bng');
        $jpb13_jml_apart    = $this->input->post('jpb13_jml_apart');
        $jpb13_ruang_ac     = $this->input->post('jpb13_ruang_ac');
        $jpb13_ruang_lain   = $this->input->post('jpb13_ruang_lain');
        $jpb14_luas         = $this->input->post('jpb14_luas');
        $jpb15_letak_tangki = $this->input->post('jpb15_letak_tangki');
        $jpb15_kapasitas    = $this->input->post('jpb15_kapasitas');
        $jpb16_kls_bng      = $this->input->post('jpb16_kls_bng');

        $prop_kd = substr($paramm, 0, 2);
        $kab_kd  = substr($paramm, 2, 2);
        $kec_kd  = substr($paramm, 4, 3);
        $kel_kd  = substr($paramm, 7, 3);
        $blok_kd = substr($paramm, 10, 3);
        $urut_no = substr($paramm, 13, 4);
        $jns_kd  = substr($paramm, 17, 1);
        $thn_ply = substr($paramm, 18, 4);
        $kd_ply  = substr($paramm, 22, 2);
        $no_bng = '';
        $id_op_bng = '';
        $nip = sipkd_user_nip();

        if ($p_id && $get = $this->permohonan_online_upt_model->get_by_id($p_id)) {
            $prop_kd  = $get->KD_PROPINSI;
            $kab_kd  = $get->KD_DATI2;
            $kec_kd  = $get->KD_KECAMATAN;
            $kel_kd  = $get->KD_KELURAHAN;
            $blok_kd = $get->KD_BLOK;
            $urut_no = $get->NO_URUT;
            $jns_kd  = $get->KD_JNS_OP;
            $no_form_individu = $get->NO_PLY;

            $sql = " BEGIN ";

            if ($dtl_model == 'add') { //// simpan baru
                // get id dob
                $dt_dob_new = $this->permohonan_online_upt_model->get_bng_new($p_id);
                $next_id_op_bangunan    = $dt_dob_new->NEXT_ID_BNG;
                $next_no_bangunan       = $dt_dob_new->NEXT_NO_BNG;
                $no_bng                 = $next_no_bangunan;
                $id_op_bng              = $next_id_op_bangunan;
                // insert data MUT_DAT_OP_BANGUNAN_OL
                $sql .= " 
                    begin 
                    INSERT INTO DAT_OP_BANGUNAN_ONLINE(KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP, NO_BNG, 
                    KD_JPB, THN_DIBANGUN_BNG, THN_RENOVASI_BNG, LUAS_BNG, JML_LANTAI_BNG, 
                    KONDISI_BNG, JNS_KONSTRUKSI_BNG, JNS_ATAP_BNG, KD_DINDING, KD_LANTAI, KD_LANGIT_LANGIT, 
                    ID, DOCH_ID)
                    VALUES ('{$prop_kd}', '{$kab_kd}', '{$kec_kd}', '{$kel_kd}', '{$blok_kd}', '{$urut_no}', '{$jns_kd}', {$next_no_bangunan}, 
                    '{$dtl_guna_bng}', '{$dtl_thn_bng}', '{$dtl_thn_renov}', {$dtl_luas_bng}, {$dtl_jml_lantai}, 
                    '{$dtl_kondisi_bng}', '{$dtl_jns_konstr}', '{$dtl_jns_atap}', '{$dtl_jns_dinding}', '{$dtl_jns_lantai}', '{$dtl_jns_langit}', 
                    {$next_id_op_bangunan}, {$p_id}) ; 
                    EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                    end; ";

                if ($dtl_nil_individu != '') {
                    $sql .= " 
                        begin 
                            INSERT INTO DAT_NILAI_INDIVIDU_ONLINE(DOCD_ID, KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, 
                            KD_BLOK, NO_URUT, KD_JNS_OP, NO_BNG, 
                            NO_FORMULIR_INDIVIDU, NILAI_INDIVIDU, TGL_PENILAIAN_INDIVIDU, NIP_PENILAI_INDIVIDU,
                            TGL_PEMERIKSAAN_INDIVIDU, NIP_PEMERIKSA_INDIVIDU, TGL_REKAM_NILAI_INDIVIDU, NIP_PEREKAM_INDIVIDU)
                            VALUES ({$next_id_op_bangunan}, '{$prop_kd}', '{$kab_kd}', '{$kec_kd}', '{$kel_kd}', 
                            '{$blok_kd}', '{$urut_no}', '{$jns_kd}', {$next_no_bangunan}, 
                            '{$no_form_individu}', {$dtl_nil_individu}, SYSDATE, '{$nip}',
                            SYSDATE, '{$nip}',  SYSDATE, '{$nip}'
                            )
                        ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                        end; ";
                }
    
            } else if ($dtl_model == 'edit') { //// update 
                $dt_o      = $this->permohonan_online_upt_model->get_dtl_bng($dtl_id);
                $no_bng    = $dt_o->NO_BNG;
                $id_op_bng = $dtl_id;
                // update data MUT_DAT_OP_BANGUNAN_ONLINE
                $sql .= " 
                    begin 
                    UPDATE DAT_OP_BANGUNAN_ONLINE SET  
                    KD_JPB = '{$dtl_guna_bng}', THN_DIBANGUN_BNG = '{$dtl_thn_bng}', THN_RENOVASI_BNG = '{$dtl_thn_renov}', 
                    LUAS_BNG = {$dtl_luas_bng}, JML_LANTAI_BNG = {$dtl_jml_lantai}, 
                    KONDISI_BNG = '{$dtl_kondisi_bng}', JNS_KONSTRUKSI_BNG = '{$dtl_jns_konstr}', JNS_ATAP_BNG = '{$dtl_jns_atap}', 
                    KD_DINDING = '{$dtl_jns_dinding}', KD_LANTAI = '{$dtl_jns_lantai}', KD_LANGIT_LANGIT = '{$dtl_jns_langit}' 
                    WHERE ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                    end; ";

                //// INSERT OR UPDATE KE DAT_NILAI_INDIVIDU_ONLINE kalo ada nilainya 
                if ($dtl_nil_individu != '') {
                    $sql .= "
                    begin 
                        MERGE INTO DAT_NILAI_INDIVIDU_ONLINE USING dual ON (DOCD_ID = {$id_op_bng} )
                        WHEN MATCHED THEN UPDATE SET NO_FORMULIR_INDIVIDU = '{$no_form_individu}', NILAI_INDIVIDU = {$dtl_nil_individu}, 
                            TGL_PENILAIAN_INDIVIDU = SYSDATE, NIP_PENILAI_INDIVIDU = '{$nip}',
                            TGL_PEMERIKSAAN_INDIVIDU = SYSDATE, NIP_PEMERIKSA_INDIVIDU = '{$nip}', 
                            TGL_REKAM_NILAI_INDIVIDU = SYSDATE, NIP_PEREKAM_INDIVIDU = '{$nip}'
                        WHEN NOT MATCHED THEN INSERT (DOCD_ID, KD_PROPINSI, KD_DATI2, KD_KECAMATAN, 
                            KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP, NO_BNG, NO_FORMULIR_INDIVIDU, 
                            NILAI_INDIVIDU, TGL_PENILAIAN_INDIVIDU, NIP_PENILAI_INDIVIDU, 
                            TGL_PEMERIKSAAN_INDIVIDU, NIP_PEMERIKSA_INDIVIDU, TGL_REKAM_NILAI_INDIVIDU, 
                            NIP_PEREKAM_INDIVIDU)
                        VALUES ({$id_op_bng}, '{$prop_kd}', '{$kab_kd}', '{$kec_kd}', '{$kel_kd}', '{$blok_kd}', 
                            '{$urut_no}', '{$jns_kd}', {$no_bng}, '{$no_form_individu}', 
                            {$dtl_nil_individu}, SYSDATE, '{$nip}', 
                            SYSDATE, '{$nip}', SYSDATE, '{$nip}' );
                    end; ";
                } else {
                    $sql .= "
                        begin 
                            DELETE FROM DAT_NILAI_INDIVIDU_ONLINE WHERE DOCD_ID = {$id_op_bng} ;
                            EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM);
                        end;
                    ";
                }

                //// hapus dulu data jpb jpb yang sudah ada by id header (id MUT_DAT_OP_BANGUNAN_ONLINE)
                $sql .= "   
                    begin 
                    DELETE FROM DAT_JPB02_ONLINE WHERE DOCD_ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; 
                    begin 
                    DELETE FROM DAT_JPB03_ONLINE WHERE DOCD_ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; 
                    begin 
                    DELETE FROM DAT_JPB04_ONLINE WHERE DOCD_ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; 
                    begin 
                    DELETE FROM DAT_JPB05_ONLINE WHERE DOCD_ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; 
                    begin 
                    DELETE FROM DAT_JPB06_ONLINE WHERE DOCD_ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; 
                    begin 
                    DELETE FROM DAT_JPB07_ONLINE WHERE DOCD_ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; 
                    begin 
                    DELETE FROM DAT_JPB08_ONLINE WHERE DOCD_ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; 
                    begin 
                    DELETE FROM DAT_JPB09_ONLINE WHERE DOCD_ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; 
                    begin 
                    DELETE FROM DAT_JPB12_ONLINE WHERE DOCD_ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; 
                    begin 
                    DELETE FROM DAT_JPB13_ONLINE WHERE DOCD_ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; 
                    begin 
                    DELETE FROM DAT_JPB14_ONLINE WHERE DOCD_ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; 
                    begin 
                    DELETE FROM DAT_JPB15_ONLINE WHERE DOCD_ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; 
                    begin 
                    DELETE FROM DAT_JPB16_ONLINE WHERE DOCD_ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; ";
    
            }

            //// INSERT KE JPB SESUAI PENGGUNAAN BANGUNAN (KD_JPB)
            if ($dtl_guna_bng == '02') {
                $sql .= " 
                    begin 
                    INSERT INTO DAT_JPB02_ONLINE(KLS_JPB02, DOCD_ID, KD_PROPINSI, KD_DATI2, KD_KECAMATAN, 
                    KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP, NO_BNG)
                    VALUES ('{$jpb02_kls_bng}', {$id_op_bng}, '{$prop_kd}', '{$kab_kd}', '{$kec_kd}', 
                    '{$kel_kd}', '{$blok_kd}', '{$urut_no}', '{$jns_kd}', {$no_bng}
                    )
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                    end; ";
            } else if ($dtl_guna_bng == '03') {
                $sql .= " 
                    begin 
                    INSERT INTO DAT_JPB03_ONLINE(KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, 
                    KD_JNS_OP, NO_BNG, TYPE_KONSTRUKSI, TING_KOLOM_JPB3, LBR_BENT_JPB3, LUAS_MEZZANINE_JPB3, 
                    KELILING_DINDING_JPB3, DAYA_DUKUNG_LANTAI_JPB3, DOCD_ID)
                    VALUES ('{$prop_kd}', '{$kab_kd}', '{$kec_kd}', '{$kel_kd}', '{$blok_kd}', '{$urut_no}', 
                    '{$jns_kd}', {$no_bng}, '{$jpb03_konstruksi}', {$jpb03_tinggi}, {$jpb03_lebar}, {$jpb03_luas},
                    {$jpb03_keliling}, {$jpb03_daya}, {$id_op_bng}
                    )
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                    end; ";
            } else if ($dtl_guna_bng == '04') {
                $sql .= " 
                    begin 
                    INSERT INTO DAT_JPB04_ONLINE(KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, 
                    KD_JNS_OP, NO_BNG, KLS_JPB4, DOCD_ID)
                    VALUES ('{$prop_kd}', '{$kab_kd}', '{$kec_kd}', '{$kel_kd}', '{$blok_kd}', '{$urut_no}', 
                    '{$jns_kd}', {$no_bng}, '{$jpb04_kls_bng}', {$id_op_bng}
                    )
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                    end; ";
            } else if ($dtl_guna_bng == '05') {
                $sql .= " 
                    begin 
                    INSERT INTO DAT_JPB05_ONLINE(KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, 
                    KD_JNS_OP, NO_BNG, KLS_JPB05, LUAS_KMR_JPB05_DGN_AC_SENT, LUAS_RNG_LAIN_JPB5_DGN_AC_SENT, DOCD_ID)
                    VALUES ('{$prop_kd}', '{$kab_kd}', '{$kec_kd}', '{$kel_kd}', '{$blok_kd}', '{$urut_no}', 
                    '{$jns_kd}', {$no_bng}, '{$jpb05_kls_bng}', {$jpb05_ruang_ac}, {$jpb05_ruang_lain}, {$id_op_bng}
                    )
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                    end; ";
            } else if ($dtl_guna_bng == '06') {
                $sql .= " 
                    begin 
                    INSERT INTO DAT_JPB06_ONLINE(KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, 
                    KD_JNS_OP, NO_BNG, KLS_JPB06, DOCD_ID)
                    VALUES ('{$prop_kd}', '{$kab_kd}', '{$kec_kd}', '{$kel_kd}', '{$blok_kd}', '{$urut_no}', 
                    '{$jns_kd}', {$no_bng}, '{$jpb06_kls_bng}', {$id_op_bng}
                    )
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                    end; ";
            } else if ($dtl_guna_bng == '07') {
                $sql .= " 
                    begin 
                    INSERT INTO DAT_JPB07_ONLINE(KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, 
                    KD_JNS_OP, NO_BNG, JNS_JPB7, BINTANG_JPB7, JML_KMR_JPB7, 
                    LUAS_KMR_JPB7_DGN_AC_SENT, LUAS_KMR_LAIN_JPB7_DGN_AC_SENT, DOCD_ID)
                    VALUES ('{$prop_kd}', '{$kab_kd}', '{$kec_kd}', '{$kel_kd}', '{$blok_kd}', '{$urut_no}', 
                    '{$jns_kd}', {$no_bng}, '{$jpb07_jns_hotel}', '{$jpb07_bintang}', {$jpb07_jml_kamar}, 
                    {$jpb07_ruang_ac}, {$jpb07_ruang_lain}, {$id_op_bng}
                    )
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                    end; ";
            } else if ($dtl_guna_bng == '08') {
                $sql .= " 
                    begin 
                    INSERT INTO DAT_JPB08_ONLINE(KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, 
                    KD_JNS_OP, NO_BNG, TYPE_KONSTRUKSI, TING_KOLOM_JPB8, LBR_BENT_JPB8, LUAS_MEZZANINE_JPB8, 
                    KELILING_DINDING_JPB8, DAYA_DUKUNG_LANTAI_JPB8, DOCD_ID)
                    VALUES ('{$prop_kd}', '{$kab_kd}', '{$kec_kd}', '{$kel_kd}', '{$blok_kd}', '{$urut_no}', 
                    '{$jns_kd}', {$no_bng}, '{$jpb08_konstruksi}', {$jpb08_tinggi}, {$jpb08_lebar}, {$jpb08_luas}, 
                    {$jpb08_keliling}, {$jpb08_daya}, {$id_op_bng}
                    )
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                    end; ";
            } else if ($dtl_guna_bng == '09') {
                $sql .= " 
                    begin 
                    INSERT INTO DAT_JPB09_ONLINE(KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, 
                    KD_JNS_OP, NO_BNG, KLS_JPB09, DOCD_ID)
                    VALUES ('{$prop_kd}', '{$kab_kd}', '{$kec_kd}', '{$kel_kd}', '{$blok_kd}', '{$urut_no}', 
                    '{$jns_kd}', {$no_bng}, '{$jpb09_kls_bng}', {$id_op_bng}
                    )
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                    end; ";
            } else if ($dtl_guna_bng == '12') {
                $sql .= " 
                    begin 
                    INSERT INTO DAT_JPB12_ONLINE(KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, 
                    KD_JNS_OP, NO_BNG, TYPE_JPB12, DOCD_ID)
                    VALUES ('{$prop_kd}', '{$kab_kd}', '{$kec_kd}', '{$kel_kd}', '{$blok_kd}', '{$urut_no}', 
                    '{$jns_kd}', {$no_bng}, '{$jpb12_kls_bng}', {$id_op_bng}
                    )
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                    end; ";
            } else if ($dtl_guna_bng == '13') {
                $sql .= " 
                    begin 
                    INSERT INTO DAT_JPB13_ONLINE(KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, 
                    KD_JNS_OP, NO_BNG, KLS_JPB13, JML_JPB13, 
                    LUAS_JPB13_DGN_AC_SENT, LUAS_JPB13_LAIN_DGN_AC_SENT, DOCD_ID)
                    VALUES ('{$prop_kd}', '{$kab_kd}', '{$kec_kd}', '{$kel_kd}', '{$blok_kd}', '{$urut_no}', 
                    '{$jns_kd}', {$no_bng}, '{$jpb13_kls_bng}', {$jpb13_jml_apart},  
                    {$jpb13_ruang_ac}, {$jpb13_ruang_lain}, {$id_op_bng}
                    )
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                    end; ";
            } else if ($dtl_guna_bng == '14') {
                $sql .= " 
                    begin 
                    INSERT INTO DAT_JPB14_ONLINE(KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, 
                    KD_JNS_OP, NO_BNG, LUAS_KANOPI_JPB14, DOCD_ID)
                    VALUES ('{$prop_kd}', '{$kab_kd}', '{$kec_kd}', '{$kel_kd}', '{$blok_kd}', '{$urut_no}', 
                    '{$jns_kd}', {$no_bng}, {$jpb14_luas}, {$id_op_bng}
                    )
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                    end; ";
            } else if ($dtl_guna_bng == '15') {
                $sql .= " 
                    begin 
                    INSERT INTO DAT_JPB15_ONLINE(KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, 
                    KD_JNS_OP, NO_BNG, LETAK_TANGKI_JPB15, KAPASITAS_TANGKI_JPB15, DOCD_ID)
                    VALUES ('{$prop_kd}', '{$kab_kd}', '{$kec_kd}', '{$kel_kd}', '{$blok_kd}', '{$urut_no}', 
                    '{$jns_kd}', {$no_bng}, '{$jpb15_letak_tangki}', {$jpb15_kapasitas}, {$id_op_bng}
                    )
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                    end; ";
            } else if ($dtl_guna_bng == '16') {
                $sql .= " 
                    begin 
                    INSERT INTO DAT_JPB16_ONLINE(KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, 
                    KD_JNS_OP, NO_BNG, KLS_JPB16, DOCD_ID)
                    VALUES ('{$prop_kd}', '{$kab_kd}', '{$kec_kd}', '{$kel_kd}', '{$blok_kd}', '{$urut_no}', 
                    '{$jns_kd}', {$no_bng}, '{$jpb16_kls_bng}', {$id_op_bng}
                    )
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                    end; ";
            } 

            $sql .= " COMMIT;
                      END; ";
            //
            // log_message('info', " XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX data_simpan_dtl PEMBETULAN ONLINE: " . $sql);
            // echo $sql; die;
            $error_msg = $this->db->simple_qry_eon_ora($sql);
            $err_Msg = $error_msg['message'];
            if (!empty($err_Msg)) {
                $error_CRUD = $err_Msg . ', Proses gagal....!!!';
                echo $error_CRUD;
            } else {
                echo 'Simpan Data Bangunan Berhasil';
            }

        } else {
            echo 'ERROR.. Data tidak ditemukan... silakan muat ulang halaman';
        }

    }

    function save_dtl_fasilitas_bangunan() {
        $p_id               = $this->input->post('id_ppo');
        $paramm             = $this->input->post('paramm');
        $id_dobng           = $this->input->post('id_head');
        $dtl_kd_fas         = $this->input->post('dtlfas_kd_fas');
        $dtl_satuan         = $this->input->post('dtlfas_satuan');

        if ($p_id && $get = $this->permohonan_online_upt_model->get_by_id($p_id)) {
            $dt_o      = $this->permohonan_online_upt_model->get_dtl_bng($id_dobng);
            $no_bng    = $dt_o->NO_BNG;
            $sql = " BEGIN ";

            // insert data DAT_FASILITAS_BANGUNAN_ONLINE
            $sql .= " 
                begin 
                INSERT INTO DAT_FASILITAS_BANGUNAN_ONLINE(KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP,
                NO_BNG, KD_FASILITAS, JML_SATUAN, DOCD_ID)
                VALUES ('{$dt_o->KD_PROPINSI}', '{$dt_o->KD_DATI2}', '{$dt_o->KD_KECAMATAN}', '{$dt_o->KD_KELURAHAN}', '{$dt_o->KD_BLOK}', '{$dt_o->NO_URUT}', '{$dt_o->KD_JNS_OP}',  
                {$no_bng}, '{$dtl_kd_fas}', {$dtl_satuan}, {$id_dobng}); 
                EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                end; ";

            $sql .= " COMMIT;
                      END; ";
            //
            // log_message('info', " XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX data_simpan_dtl PEMBETULAN ONLINE: " . $sql);
            $error_msg = $this->db->simple_qry_eon_ora($sql);
            $err_Msg = $error_msg['message'];
            if (!empty($err_Msg)) {
                $error_CRUD = $err_Msg . ', Proses gagal....!!!';
                echo $error_CRUD;
            } else {
                echo 'Simpan Data Fasilitas Bangunan Berhasil';
            }

        } else {
            echo 'ERROR.. Data tidak ditemukan... silakan muat ulang halaman';
        }

    }

    function delete_dtl_fas_bng() {
        $id_fasilitas = $this->uri->segment(4);
        if ($id_fasilitas ) {
            $sql = " BEGIN ";

            $sql .= "
                    begin 
                    DELETE FROM DAT_FASILITAS_BANGUNAN_ONLINE WHERE ID = {$id_fasilitas} ; 
                    EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; ";
            
            $sql .= "COMMIT;
                    END; ";
            //
            // log_message('info', " XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX data_delete_bng_ol : " . $sql);
            $error_msg = $this->db->simple_qry_eon_ora($sql);
            $err_Msg = $error_msg['message'];
            if (!empty($err_Msg)) {
                $error_CRUD = $err_Msg . ', Proses hapus gagal....!!!';
                $msg = $error_CRUD;
            } else {
                $msg = 'Hapus Data Fasilitas Bangunan Berhasil';
            }

        } else {
            $msg = 'Data tidak ditemukan..';
        }

        echo $msg;
    }


    public function appr_permo() {
        // $nop        = $this->uri->segment(4);
        // $thn_ply    = $this->uri->segment(5);
        // $kd_ply     = $this->uri->segment(6);
        $id_ppo     = $this->uri->segment(4);

        // $nop_kdply = $nop.$thn_ply.$kd_ply ;
        
        $simpan = $this->permohonan_online_upt_model->update_sts_permohonan($id_ppo);

        $getdt      = $this->permohonan_online_upt_model->get_prm_online($id_ppo);
        $nopel      = $getdt->NO_PLY;
        $nop_lkp    = $getdt->NOP_LKP;
        $jns_ply_tx = $getdt->NM_JENIS_PELAYANAN;
        $tgl_kirim  = $getdt->TGL_SURAT_PERMOHONAN;
        $ket        = $getdt->ALASAN;
        $email      = $getdt->EMAIL;

        $kd_jns_ply = $getdt->KD_JNS_PELAYANAN;
        $kd_sub_jns_ply = $getdt->KD_SUB_JNS_PELAYANAN;

        $d_today = date('d-m-Y');


        $data = new stdClass();

        //// KIRIM EMAIL

        $config = array(
            'protocol' => SMTP_PROTOCOL,
            'smtp_host' => SMTP_HOST, //sesuaikan dengan host pengirim
            'smtp_port' => SMTP_PORT,
            'smtp_timeout' => 20,
            'smtp_user' => SMTP_USER, //sesuaikan dengan email yg dipakai
            'smtp_pass' => SMTP_PASS, //password host
            'smtp_username' => SMTP_UNAME,
            'mailtype' => SMTP_TYPE,
            'charset' => SMTP_CHARSET,
            'wordwrap' => true,
        );  

        // $message = "<strong>BUKTI PENGIRIMAN BERKAS PERMOHONAN ONLINE PBB</strong> <br>";
        // $message .= "<strong>Badan Pengelolaan Pendapatan Daerah Kabupaten Bogor</strong> <br>";
        // $message .= "NO PELAYANAN : {$nopel} <br>";
        // $message .= "NOP : {$nop_lkp} <br>";
        // $message .= "JENIS PELAYANAN : {$jns_ply_tx} <br>";
        // $message .= "TGL KIRIM BERKAS : {$tgl_kirim} <br>";
        // $message .= "KETERANGAN : {$ket} <br>";
        // $message .= "Cibinong, {$d_today}";

        $message = '
                    <html>
                    <head>
                        <title>Bukti Pengiriman Berkas Permohonan Online E-SPPT Kab. Bogor</title>
                    </head>
                    <body style="font-family: Arial, sans-serif; background-color: #f6f9fc; margin: 0; padding: 20px;">
                        <table align="center" cellpadding="0" cellspacing="0" width="600" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                            <tr>
                                <td style="background-color: #2b8a3e; padding: 16px; border-radius: 8px 8px 0 0; text-align: center; color: #ffffff;">
                                    <h2 style="margin: 0;">BUKTI PENGIRIMAN BERKAS PERMOHONAN ONLINE PBB Kabupaten Bogor</h2>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 30px;">
                                    <p style="font-size: 16px; color: #555;">NO PELAYANAN : '.$nopel.'</p>
                                    <p style="font-size: 16px; color: #555;">NOP : '.$nop_lkp.' </p>
                                    <p style="font-size: 16px; color: #555;">JENIS PELAYANAN : '.$jns_ply_tx.' </p>
                    ';
        if ($kd_jns_ply == '03') {
            $nm_sub = $this->db->query("SELECT NM_SUB_JENIS_PELAYANAN FROM REF_SUB_JNS_PELAYANAN 
                                        WHERE KD_JNS_PELAYANAN = '$kd_jns_ply' AND KD_SUB_JNS_PELAYANAN = '$kd_sub_jns_ply' ")
                                ->row()->NM_SUB_JENIS_PELAYANAN;

            $message .= '           <p style="font-size: 16px; color: #555;">SUB JENIS PELAYANAN : '.$nm_sub.' </p>';
        }
        $message .= '
                                    <p style="font-size: 16px; color: #555;">TGL KIRIM BERKAS : '.$tgl_kirim.' </p>
                                    <p style="font-size: 16px; color: #555;">KETERANGAN : '.$ket.' </p>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 30px; text-align: center;">
                                    <p style="font-size: 16px; color: #555;">Cibinong, '.$d_today.'</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="background-color: #f0f0f0; text-align: center; padding: 15px; font-size: 13px; color: #999; border-radius: 0 0 8px 8px;">
                                     '.date('Y').' Bappenda Kabupaten Bogor
                                </td>
                            </tr>
                        </table>
                    </body>
                    </html>';


        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from(SMTP_USER, SMTP_UNAME);
        $this->email->to($email);
        $this->email->subject('BUKTI PENGIRIMAN BERKAS NOMOR PELAYANAN '.$nopel);
        $this->email->message($message);
            //sending email
        if ($this->email->send()) {
            $data->result       = '200';
            $data->msg          = 'Berhasil Kirim Data Permohonan Online (Sukses Kirim Email)';
        } else {
            $data->result       = '201';
            $data->msg          = 'Berhasil Kirim Data (Gagal Kirim Email)';
            // echo $this->email->print_debugger();
        }

        echo json_encode($data);

    }

    // function update_prm_blob($param) {
    //     $L_SPMKP_PBB1 = '';
    //     $L_SURAT_KUASA1 = '';
    //     $L_SKKP_PBB1 = '';
    //     $L_SERTIFIKAT_TANAH1 = '';
    //     $L_IMB1 = '';
    //     $L_AKTE_JUAL_BELI1 = '';
    //     $L_PERMOHONAN1 = '';
    //     $L_STTS1 = '';
    //     $L_SK_KEBERATAN1 = '';
    //     $L_SPPT_STTS1 = '';
    //     $L_SPPT1 = '';
    //     $L_KTP_WP1 = '';
    //     $L_SK_PENGURANGAN1 = '';
    //     $L_LAIN_LAIN1 = '';
    //     $fl_blob = array();
    //     $tbl_field = array();
    //     $tbl_field_return = array();
    //     $return_blob = array();
    //     if (!empty($_FILES['L_SPMKP_PBB1']['name'])) {
    //         array_push($tbl_field, 'L_SKKP_PBB1=EMPTY_BLOB()');
    //         array_push($fl_blob, 'L_SKKP_PBB=1');
    //         array_push($tbl_field_return, 'L_SKKP_PBB1');
    //         array_push($return_blob, ':blob1');
    //         $L_SPMKP_PBB1 = file_get_contents($_FILES['L_SPMKP_PBB1']['tmp_name']);
    //     }
    //     if (!empty($_FILES['L_SURAT_KUASA1']['name'])) {
    //         array_push($tbl_field, 'L_SPMKP_PBB1=EMPTY_BLOB()');
    //         array_push($fl_blob, 'L_SPMKP_PBB=1');
    //         array_push($tbl_field_return, 'L_SPMKP_PBB1');
    //         array_push($return_blob, ':blob2');
    //         $L_SURAT_KUASA1 = file_get_contents($_FILES['L_SURAT_KUASA1']['tmp_name']);
    //     }
    //     if (!empty($_FILES['L_PERMOHONAN1']['name'])) {
    //         array_push($tbl_field, 'L_SURAT_KUASA1=EMPTY_BLOB()');
    //         array_push($tbl_field_return, 'L_SURAT_KUASA1');
    //         array_push($fl_blob, 'L_SURAT_KUASA=1');
    //         array_push($return_blob, ':blob3');
    //         $L_PERMOHONAN1 = file_get_contents($_FILES['L_PERMOHONAN1']['tmp_name']);
    //     }
    //     if (!empty($_FILES['L_STTS1']['name'])) {
    //         array_push($tbl_field, 'L_PERMOHONAN1=EMPTY_BLOB()');
    //         array_push($tbl_field_return, 'L_PERMOHONAN1');
    //         array_push($fl_blob, 'L_PERMOHONAN=1');
    //         array_push($return_blob, ':blob4');
    //         $L_STTS1 = file_get_contents($_FILES['L_STTS1']['tmp_name']);
    //     }
    //     if (!empty($_FILES['L_SK_KEBERATAN1']['name'])) {
    //         array_push($tbl_field, 'L_STTS1=EMPTY_BLOB()');
    //         array_push($tbl_field_return, 'L_STTS1');
    //         array_push($fl_blob, 'L_STTS=1');
    //         array_push($return_blob, ':blob5');
    //         $L_SK_KEBERATAN1 = file_get_contents($_FILES['L_SK_KEBERATAN1']['tmp_name']);
    //     }
    //     if (!empty($_FILES['L_SPPT_STTS1']['name'])) {
    //         array_push($tbl_field, 'L_SK_KEBERATAN1=EMPTY_BLOB()');
    //         array_push($tbl_field_return, 'L_SK_KEBERATAN1');
    //         array_push($fl_blob, 'L_SK_KEBERATAN=1');
    //         array_push($return_blob, ':blob6');
    //         $L_SPPT_STTS1 = file_get_contents($_FILES['L_SPPT_STTS1']['tmp_name']);
    //     }
    //     if (!empty($_FILES['L_KTP_WP1']['name'])) {
    //         array_push($tbl_field, 'L_SPPT_STTS1=EMPTY_BLOB()');
    //         array_push($tbl_field_return, 'L_SPPT_STTS1');
    //         array_push($fl_blob, 'L_SPPT_STTS=1');
    //         array_push($return_blob, ':blob7');
    //         $L_KTP_WP1 = file_get_contents($_FILES['L_KTP_WP1']['tmp_name']);
    //     }
    //     if (!empty($_FILES['L_SKKP_PBB1']['name'])) {
    //         array_push($tbl_field, 'L_KTP_WP1=EMPTY_BLOB()');
    //         array_push($tbl_field_return, 'L_KTP_WP1');
    //         array_push($fl_blob, 'L_KTP_WP=1');
    //         array_push($return_blob, ':blob8');
    //         $L_SKKP_PBB1 = file_get_contents($_FILES['L_SKKP_PBB1']['tmp_name']);
    //     }
    //     if (!empty($_FILES['L_SERTIFIKAT_TANAH1']['name'])) {
    //         array_push($tbl_field, 'L_SERTIFIKAT_TANAH1=EMPTY_BLOB()');
    //         array_push($tbl_field_return, 'L_SERTIFIKAT_TANAH1');
    //         array_push($fl_blob, 'L_SERTIFIKAT_TANAH=1');
    //         array_push($return_blob, ':blob9');
    //         $L_SERTIFIKAT_TANAH1 = file_get_contents($_FILES['L_SERTIFIKAT_TANAH1']['tmp_name']);
    //     }
    //     if (!empty($_FILES['L_IMB1']['name'])) {
    //         array_push($tbl_field, 'L_IMB1=EMPTY_BLOB()');
    //         array_push($tbl_field_return, 'L_IMB1');
    //         array_push($fl_blob, 'L_IMB=1');
    //         array_push($return_blob, ':blob10');
    //         $L_IMB1 = file_get_contents($_FILES['L_IMB1']['tmp_name']);
    //     }
    //     if (!empty($_FILES['L_AKTE_JUAL_BELI1']['name'])) {
    //         array_push($tbl_field, 'L_AKTE_JUAL_BELI1=EMPTY_BLOB()');
    //         array_push($tbl_field_return, 'L_AKTE_JUAL_BELI1');
    //         array_push($fl_blob, 'L_AKTE_JUAL_BELI=1');
    //         array_push($return_blob, ':blob11');
    //         $L_AKTE_JUAL_BELI1 = file_get_contents($_FILES['L_AKTE_JUAL_BELI1']['tmp_name']);
    //     }
    //     if (!empty($_FILES['L_SPPT1']['name'])) {
    //         array_push($tbl_field, 'L_SPPT1=EMPTY_BLOB()');
    //         array_push($tbl_field_return, 'L_SPPT1');
    //         array_push($fl_blob, 'L_SPPT=1');
    //         array_push($return_blob, ':blob12');
    //         $L_SPPT1 = file_get_contents($_FILES['L_SPPT1']['tmp_name']);
    //     }
    //     if (!empty($_FILES['L_SK_PENGURANGAN1']['name'])) {
    //         array_push($tbl_field, 'L_SK_PENGURANGAN1=EMPTY_BLOB()');
    //         array_push($tbl_field_return, 'L_SK_PENGURANGAN1');
    //         array_push($fl_blob, 'L_SK_PENGURANGAN=1');
    //         array_push($return_blob, ':blob13');
    //         $L_SK_PENGURANGAN1 = file_get_contents($_FILES['L_SK_PENGURANGAN1']['tmp_name']);
    //     }
    //     if (!empty($_FILES['L_LAIN_LAIN1']['name'])) {
    //         array_push($tbl_field, 'L_LAIN_LAIN1=EMPTY_BLOB()');
    //         array_push($tbl_field_return, 'L_LAIN_LAIN1');
    //         array_push($fl_blob, 'L_LAIN_LAIN=1');
    //         array_push($return_blob, ':blob14');
    //         $L_LAIN_LAIN1 = file_get_contents($_FILES['L_LAIN_LAIN1']['tmp_name']);
    //     }
    //     $fl_blob_impl = implode(', ', $fl_blob);
    //     $tbl_field_impl = implode(', ', $tbl_field);
    //     $tbl_field_return_impl = implode(', ', $tbl_field_return);
    //     $return_blob_impl = implode(', ', $return_blob);
    //     $dbhost = DB_HOST;
    //     $dbport = DB_PORT;
    //     $dbname = DB_NAME;
    //     $dbuser = DB_PBB_USER;
    //     $dbpass = DB_PBB_PASS;
    //     $tnslistener = '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=' . $dbhost . ')(PORT=' . $dbport . '))(CONNECT_DATA=(SID=' . $dbname . ')))';
    //     $kd_kanwil = KD_KANWIL;
    //     $kd_kantor = KD_KANTOR;
    //     $connection = oci_connect($dbuser, $dbpass, $tnslistener);
    //     $qq = "UPDATE PST_PERMOHONAN_TOOL SET {$fl_blob_impl}, {$tbl_field_impl} 
    //     WHERE KD_PROPINSI_PEMOHON||KD_DATI2_PEMOHON||KD_KECAMATAN_PEMOHON||KD_KELURAHAN_PEMOHON||KD_BLOK_PEMOHON||
    //     NO_URUT_PEMOHON||KD_JNS_OP_PEMOHON||THN_PELAYANAN||KD_JNS_PELAYANAN='{$param}' 
    //     RETURNING {$tbl_field_return_impl} INTO {$return_blob_impl}";
    //     $result = oci_parse($connection, $qq);
    //     if (!empty($_FILES['L_SPMKP_PBB1']['name'])) {
    //         $blob1 = oci_new_descriptor($connection, OCI_D_LOB);
    //         oci_bind_by_name($result, ":blob1", $blob1, -1, OCI_B_BLOB);
    //     }
    //     if (!empty($_FILES['L_SURAT_KUASA1']['name'])) {
    //         $blob2 = oci_new_descriptor($connection, OCI_D_LOB);
    //         oci_bind_by_name($result, ":blob2", $blob2, -1, OCI_B_BLOB);
    //     }
    //     if (!empty($_FILES['L_PERMOHONAN1']['name'])) {
    //         $blob3 = oci_new_descriptor($connection, OCI_D_LOB);
    //         oci_bind_by_name($result, ":blob3", $blob3, -1, OCI_B_BLOB);
    //     }
    //     if (!empty($_FILES['L_STTS1']['name'])) {
    //         $blob4 = oci_new_descriptor($connection, OCI_D_LOB);
    //         oci_bind_by_name($result, ":blob4", $blob4, -1, OCI_B_BLOB);
    //     }
    //     if (!empty($_FILES['L_SK_KEBERATAN1']['name'])) {
    //         $blob5 = oci_new_descriptor($connection, OCI_D_LOB);
    //         oci_bind_by_name($result, ":blob5", $blob5, -1, OCI_B_BLOB);
    //     }
    //     if (!empty($_FILES['L_SPPT_STTS1']['name'])) {
    //         $blob6 = oci_new_descriptor($connection, OCI_D_LOB);
    //         oci_bind_by_name($result, ":blob6", $blob6, -1, OCI_B_BLOB);
    //     }
    //     if (!empty($_FILES['L_KTP_WP1']['name'])) {
    //         $blob7 = oci_new_descriptor($connection, OCI_D_LOB);
    //         oci_bind_by_name($result, ":blob7", $blob7, -1, OCI_B_BLOB);
    //     }
    //     if (!empty($_FILES['L_SKKP_PBB1']['name'])) {
    //         $blob8 = oci_new_descriptor($connection, OCI_D_LOB);
    //         oci_bind_by_name($result, ":blob8", $blob8, -1, OCI_B_BLOB);
    //     }
    //     if (!empty($_FILES['L_SERTIFIKAT_TANAH1']['name'])) {
    //         $blob9 = oci_new_descriptor($connection, OCI_D_LOB);
    //         oci_bind_by_name($result, ":blob9", $blob9, -1, OCI_B_BLOB);
    //     }
    //     if (!empty($_FILES['L_IMB1']['name'])) {
    //         $blob10 = oci_new_descriptor($connection, OCI_D_LOB);
    //         oci_bind_by_name($result, ":blob10", $blob10, -1, OCI_B_BLOB);
    //     }
    //     if (!empty($_FILES['L_AKTE_JUAL_BELI1']['name'])) {
    //         $blob11 = oci_new_descriptor($connection, OCI_D_LOB);
    //         oci_bind_by_name($result, ":blob11", $blob11, -1, OCI_B_BLOB);
    //     }
    //     if (!empty($_FILES['L_SPPT1']['name'])) {
    //         $blob12 = oci_new_descriptor($connection, OCI_D_LOB);
    //         oci_bind_by_name($result, ":blob12", $blob12, -1, OCI_B_BLOB);
    //     }
    //     if (!empty($_FILES['L_SK_PENGURANGAN1']['name'])) {
    //         $blob13 = oci_new_descriptor($connection, OCI_D_LOB);
    //         oci_bind_by_name($result, ":blob13", $blob13, -1, OCI_B_BLOB);
    //     }
    //     if (!empty($_FILES['L_LAIN_LAIN1']['name'])) {
    //         $blob14 = oci_new_descriptor($connection, OCI_D_LOB);
    //         oci_bind_by_name($result, ":blob14", $blob14, -1, OCI_B_BLOB);
    //     }

    //     $err = '';

    //     oci_execute($result, OCI_DEFAULT) or die("Unable to execute query; <br>" . $qq . '<br> Keterangan Error: <br>' . $err);
    //     if (!empty($_FILES['L_SPMKP_PBB1']['name'])) {
    //         $blob1->save($L_SPMKP_PBB1);
    //     }
    //     if (!empty($_FILES['L_SURAT_KUASA1']['name'])) {
    //         $blob2->save($L_SURAT_KUASA1);
    //     }
    //     if (!empty($_FILES['L_PERMOHONAN1']['name'])) {
    //         $blob3->save($L_PERMOHONAN1);
    //     }
    //     if (!empty($_FILES['L_STTS1']['name'])) {
    //         $blob4->save($L_STTS1);
    //     }
    //     if (!empty($_FILES['L_SK_KEBERATAN1']['name'])) {
    //         $blob5->save($L_SK_KEBERATAN1);
    //     }
    //     if (!empty($_FILES['L_SPPT_STTS1']['name'])) {
    //         $blob6->save($L_SPPT_STTS1);
    //     }
    //     if (!empty($_FILES['L_KTP_WP1']['name'])) {
    //         $blob7->save($L_KTP_WP1);
    //     }
    //     if (!empty($_FILES['L_SKKP_PBB1']['name'])) {
    //         $blob8->save($L_SKKP_PBB1);
    //     }
    //     if (!empty($_FILES['L_SERTIFIKAT_TANAH1']['name'])) {
    //         $blob9->save($L_SERTIFIKAT_TANAH1);
    //     }
    //     if (!empty($_FILES['L_IMB1']['name'])) {
    //         $blob10->save($L_IMB1);
    //     }
    //     if (!empty($_FILES['L_AKTE_JUAL_BELI1']['name'])) {
    //         $blob11->save($L_AKTE_JUAL_BELI1);
    //     }
    //     if (!empty($_FILES['L_SPPT1']['name'])) {
    //         $blob12->save($L_SPPT1);
    //     }
    //     if (!empty($_FILES['L_SK_PENGURANGAN1']['name'])) {
    //         $blob13->save($L_SK_PENGURANGAN1);
    //     }
    //     if (!empty($_FILES['L_LAIN_LAIN1']['name'])) {
    //         $blob14->save($L_LAIN_LAIN1);
    //     }
    //     oci_commit($connection);
    // }

    function update_prm_blob_regesppt($param, $nik) {
        // $L_SKKP_PBB1_re = '';
        // $L_SPPT1_re = '';
        // $L_KTP_WP1_re = '';
        // $fl_blob = array();
        // $tbl_field = array();
        // $tbl_field_return = array();
        // $return_blob = array();
        // if (!empty($_FILES['L_SKKP_PBB1_re']['name'])) {
        //     array_push($tbl_field, 'L_SKKP_PBB1_BLOB=EMPTY_BLOB()');
        //     array_push($tbl_field_return, 'L_SKKP_PBB1_BLOB');
        //     array_push($return_blob, ':blob1');
        //     $L_SKKP_PBB1_re = file_get_contents($_FILES['L_SKKP_PBB1_re']['tmp_name']);
        // }
        // if (!empty($_FILES['L_SPPT1_re']['name'])) {
        //     array_push($tbl_field, 'L_SPPT1_BLOB=EMPTY_BLOB()');
        //     array_push($tbl_field_return, 'L_SPPT1_BLOB');
        //     array_push($return_blob, ':blob2');
        //     $L_SPPT1_re = file_get_contents($_FILES['L_SPPT1_re']['tmp_name']);
        // }
        // if (!empty($_FILES['L_KTP_WP1_re']['name'])) {
        //     array_push($tbl_field, 'IM_PBB_BLOB=EMPTY_BLOB()');
        //     array_push($tbl_field_return, 'IM_PBB_BLOB');
        //     array_push($return_blob, ':blob3');
        //     $L_KTP_WP1_re = file_get_contents($_FILES['L_KTP_WP1_re']['tmp_name']);
        // }
        
        // $tbl_field_impl = implode(', ', $tbl_field);
        // $tbl_field_return_impl = implode(', ', $tbl_field_return);
        // $return_blob_impl = implode(', ', $return_blob);
        $dbhost = DB_HOST;
        $dbport = DB_PORT;
        $dbname = DB_NAME;
        $dbuser = DB_USER;
        $dbpass = DB_PASS;
        $tnslistener = '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=' . $dbhost . ')(PORT=' . $dbport . '))(CONNECT_DATA=(SID=' . $dbname . ')))';
        $connection = oci_connect($dbuser, $dbpass, $tnslistener);

        ////////
        $qq = "UPDATE REG_ESPPT SET L_SKKP_PBB1_BLOB=EMPTY_BLOB(), L_SPPT1_BLOB=EMPTY_BLOB(), IM_PBB_BLOB=EMPTY_BLOB()
            WHERE KD_PROPINSI||KD_DATI2||KD_KECAMATAN||KD_KELURAHAN||KD_BLOK||NO_URUT||KD_JNS_OP='{$param}' and trim(NIK) ='{$nik}'
            RETURNING L_SKKP_PBB1_BLOB, L_SPPT1_BLOB, IM_PBB_BLOB 
            INTO :blob1, :blob2, :blob3";
        $result = oci_parse($connection, $qq);

        // $blob = oci_new_descriptor($connection, OCI_D_LOB);
        // oci_bind_by_name($result, ":blobsatu", $blob, -1, OCI_B_BLOB);
        // oci_execute($result, OCI_DEFAULT) or die("Unable to execute query");
        // $blob->save($ppost['L_LAIN_LAIN1']);
        // oci_commit($connection);

        $blob1 = oci_new_descriptor($connection, OCI_D_LOB);
        $blob2 = oci_new_descriptor($connection, OCI_D_LOB);
        $blob3 = oci_new_descriptor($connection, OCI_D_LOB);
        oci_bind_by_name($result, ":blob1", $blob1, -1, OCI_B_BLOB);
        oci_bind_by_name($result, ":blob2", $blob2, -1, OCI_B_BLOB);
        oci_bind_by_name($result, ":blob3", $blob3, -1, OCI_B_BLOB);
        oci_execute($result, OCI_DEFAULT) or die("Unable to execute query");

        $blob1->save($_FILES['L_SKKP_PBB1_re']);
        $blob2->save($_FILES['L_SPPT1_re']);
        $blob3->save($_FILES['L_KTP_WP1_re']);
        oci_commit($connection);

        // ////////
        // $qq = "UPDATE REG_ESPPT SET {$tbl_field_impl} 
        // WHERE KD_PROPINSI||KD_DATI2||KD_KECAMATAN||KD_KELURAHAN||KD_BLOK||NO_URUT||KD_JNS_OP='{$param}' and trim(NIK) ='{$nik}'
        // RETURNING {$tbl_field_return_impl} INTO {$return_blob_impl}";
        // $result = oci_parse($connection, $qq);
        // if (!empty($_FILES['L_SKKP_PBB1_re']['name'])) {
        //     $blob1 = oci_new_descriptor($connection, OCI_D_LOB);
        //     oci_bind_by_name($result, ":blob1", $blob1, -1, OCI_B_BLOB);
        // }
        // if (!empty($_FILES['L_SPPT1_re']['name'])) {
        //     $blob2 = oci_new_descriptor($connection, OCI_D_LOB);
        //     oci_bind_by_name($result, ":blob2", $blob2, -1, OCI_B_BLOB);
        // }
        // if (!empty($_FILES['L_KTP_WP1_re']['name'])) {
        //     $blob3 = oci_new_descriptor($connection, OCI_D_LOB);
        //     oci_bind_by_name($result, ":blob3", $blob3, -1, OCI_B_BLOB);
        // }

        // $err = '';

        // oci_execute($result, OCI_DEFAULT) or die("Unable to execute query; <br>" . $qq . '<br> Keterangan Error: <br>' . $err);
        // if (!empty($_FILES['L_SKKP_PBB1_re']['name'])) {
        //     $blob1->save($L_SKKP_PBB1_re);
        // }
        // if (!empty($_FILES['L_SPPT1_re']['name'])) {
        //     $blob2->save($L_SPPT1_re);
        // }
        // if (!empty($_FILES['L_KTP_WP1_re']['name'])) {
        //     $blob3->save($L_KTP_WP1_re);
        // }
        
        // oci_commit($connection);
    }

    public function openblob() {
        $field       = $this->uri->segment(4);
        $nopel       = $this->uri->segment(5);
        $field = strtoupper($field);

        $dbhost = DB_HOST;
        $dbport = DB_PORT;
        $dbname = DB_NAME;
        $dbuser = DB_USER;
        $dbpass = DB_PASS;

        $tnslistener = '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST='.DB_HOST.')(PORT='.DB_PORT.'))(CONNECT_DATA=(SERVICE_NAME='.DB_NAME.')))';

        $connection = oci_connect($dbuser, $dbpass, $tnslistener);

        $sql = "SELECT {$field} FROM PST_PERMOHONAN_TOOL
                WHERE THN_PELAYANAN||'-'||BUNDEL_PELAYANAN||'-'||NO_URUT_PELAYANAN = '{$nopel}'";

        $stid = oci_parse($connection, $sql);

        oci_execute($stid);
        $row = oci_fetch_array($stid, OCI_RETURN_NULLS);

        if (!$row) {
            header('Status: 404 Not Found');
        } else {
             $img = $row[$field]->load();
            $pdf_cek = strpos($img, 'PDF');
            if(empty($pdf_cek)){
                $gambar = base64_encode($img);
                echo "<img src='data:image;base64,$gambar' width='500' height='500' >";
            }else{
            header("Content-type: application/pdf");
            print $img;
            }
        }
    }

    public function openblob_reg_esppt() {
        $field  = $this->uri->segment(4);
        $nop    = $this->uri->segment(5);
        $nik    = $this->uri->segment(6);
        $field  = strtoupper($field);

        $nop        = str_replace(".", "", $nop);
        $nop        = str_replace("-", "", $nop);

        $dbhost = DB_HOST;
        $dbport = DB_PORT;
        $dbname = DB_NAME;
        $dbuser = DB_USER;
        $dbpass = DB_PASS;

        $tnslistener = '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST='.DB_HOST.')(PORT='.DB_PORT.'))(CONNECT_DATA=(SERVICE_NAME='.DB_NAME.')))';

        $connection = oci_connect($dbuser, $dbpass, $tnslistener);

        $sql = "SELECT {$field} FROM REG_ESPPT
                WHERE KD_PROPINSI||KD_DATI2||KD_KECAMATAN||KD_KELURAHAN||KD_BLOK||NO_URUT||KD_JNS_OP = '{$nop}'
                AND NIK = '{$nik}' ";

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

    function grid_dtl_bng_ol() {
        $id_head        = $this->uri->segment(4);

        $this->load->library('Datatables');
        $this->datatables->select("DOB.ID, 'edit' as MODEL, DOB.NO_BNG, RJ.NM_JPB, DOB.LUAS_BNG, DOB.KD_JPB, 
            '' as edit, '' as hapus, '' as fas", false);
        $this->datatables->from('PST_PERMOHONAN_TOOL SP');
        $this->datatables->join('DAT_OP_BANGUNAN_ONLINE DOB', 'SP.ID = DOB.DOCH_ID');
        $this->datatables->join('REF_JPB RJ', 'RJ.KD_JPB = DOB.KD_JPB');
        $this->datatables->where('SP.ID', $id_head);

        // $this->datatables->rupiah_column('4');

        echo $this->datatables->generate();
    }

    function grid_dtl_fas_ol() {
        $id_head = $this->uri->segment(4);

        // $btn_edt = '<a class="btn_edit_detail" data-toggle="modal" data-target="#cuDialogDetail" href="">Ubah</a>';
        $this->load->library('Datatables');
        $this->datatables->select("FAS.ID, 'edit' as MODEL, RF.NM_FASILITAS, FAS.JML_SATUAN, FAS.KD_FASILITAS", false);
        $this->datatables->from('DAT_FASILITAS_BANGUNAN_ONLINE FAS');
        $this->datatables->join('FASILITAS RF', 'RF.KD_FASILITAS = FAS.KD_FASILITAS');
        $this->datatables->where('FAS.DOCD_ID', $id_head);

        // $this->datatables->rupiah_column('4');

        echo $this->datatables->generate();
    }

    // public function grid() {

    //     $status_kd = $this->input->get('status_kd');
    //     $this->load->library('Datatables');
    //     $this->datatables->select("KD_PROPINSI||'.'||KD_DATI2||'.'||KD_KECAMATAN||'.'||KD_KELURAHAN||'.'||KD_BLOK||'.'||NO_URUT||'.'||KD_JNS_OP AS NOP, 
    //                                 THN_PAJAK_SPPT, NM_WP_SPPT, JLN_WP_SPPT, TGL_JATUH_TEMPO_SPPT, 
    //                                 PBB_TERHUTANG_SPPT, FAKTOR_PENGURANG_SPPT, PBB_YG_HARUS_DIBAYAR_SPPT,
    //                                 FN_HIT_HKPD_ALL(PBB_YG_HARUS_DIBAYAR_SPPT,TGL_JATUH_TEMPO_SPPT,SYSDATE,'n') AS DENDA,
    //                                 PBB_YG_HARUS_DIBAYAR_SPPT + FN_HIT_HKPD_ALL(PBB_YG_HARUS_DIBAYAR_SPPT,TGL_JATUH_TEMPO_SPPT,SYSDATE,'n') AS TTL_BAYAR,
    //                                 KD_PROPINSI||KD_DATI2||KD_KECAMATAN||KD_KELURAHAN||KD_BLOK||NO_URUT||KD_JNS_OP||THN_PAJAK_SPPT AS NOPTHN", false);
    //     $this->datatables->from("SPPT_SIMULASI_TMP");

    //     $this->datatables->rupiah_column('5,6,7,8,9');
    //     $this->datatables->date_column('4');
        
    //     echo $this->datatables->generate();
    // }

    // private function fvalidation() {
    //     $this->form_validation->set_error_delimiters('<span>', '</span>');
    //     $this->form_validation->set_rules('nop', 'NOPX', 'required|trim|callback_cek_nop');
    //     $this->form_validation->set_rules('tahun', 'Tahun Pajak SPPT', 'required|trim');
    //     $this->form_validation->set_rules('jatuh_tempo', 'Jatuh Tempo SPPT', 'required');
    // }

    // private function fpost() {
    //     $data['rowid'] = post_string($this->input->post('rowid'));
    //     $data['nop'] = post_string($this->input->post('nop'));
    //     $data['tahun'] = post_string($this->input->post('tahun'));
    //     $data['jatuh_tempo'] = post_date($this->input->post('jatuh_tempo'));
    //     return $data;
    // }

    // public function proses() {
    //     if (!$this->module_auth->update) {
    //         $this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
    //         redirect(active_module_url('permohonan_online_upt'));
    //     }

        
    //     $post_data = $this->fpost();
    //     // echo $post_data['nop']; die();

    //     $data['page_menu'] = 'upt';
    //     $data['current'] = 'permohonan_online_upt';
    //     $data['apps']    = $this->apps_model->get_active_only();
    //     $data['faction'] = active_module_url("permohonan_online_upt/proses/");

    //     $this->fvalidation();

    //     if ($this->form_validation->run() == true) {
    //         $nop        = $post_data['nop'];
    //         $nop        = str_replace(".", "", $nop);
    //         $nop        = str_replace("-", "", $nop);
    //         $kd_prop    = substr($nop, 0, 2);
    //         $kd_dati    = substr($nop, 2, 2);
    //         $kd_kec     = substr($nop, 4, 3);
    //         $kd_kel     = substr($nop, 7, 3);
    //         $kd_blok    = substr($nop, 10, 3);
    //         $no_urut    = substr($nop, 13, 4);
    //         $kd_jns_op  = substr($nop, 17, 1);

    //         $tahun      = $post_data['tahun'];
    //         $jttempo    = $post_data['jatuh_tempo'];
    //         $nip_pencetak = sipkd_user_nip();

    //         $qry_manuwal = "CALL SP_SIMULASI_SPPT('{$kd_prop}', '{$kd_dati}', '{$kd_kec}', '{$kd_kel}', '{$kd_blok}', '{$no_urut}', 
    //                     '{$kd_jns_op}', '{$tahun}', '{$jttempo}', '{$nip_pencetak}') ";

    //         // echo $qry_manuwal; die();
    //         $result = $this->db->simple_qry_eon_ora($qry_manuwal);

    //         // $result = '';
    //         if (!empty($result)) {
    //             set_msg_db_error($result);
    //         } else {

    //             $this->session->set_flashdata('msg_success', 'Data telah disimpan');
    //             redirect(active_module_url('permohonan_online_upt'));
    //         }
    //     }

    //     $get = (object)$post_data;
    //     $data['dt'] = $post_data;

    //     $this->load->view('vpermohonan_online_upt', $data);
    // }

    // public function detail() {
    //     $nopthn     = $this->uri->segment(4);
    //     $nopthn     = str_replace(".", "", $nopthn);
    //     $nopthn     = str_replace("-", "", $nopthn);

    //     $dt = $this->permohonan_online_upt_model->get($nopthn);

    //     if ($dt){
    //         $njopkp         = (int)$dt->NJOP_SPPT - (int)$dt->NJOPTKP_SPPT;
    //         $njopkp_njkp    = $dt->NIL_NJKP/100*$njopkp;
    //         $selisih        = (int)$dt->PBB_YG_HARUS_DIBAYAR_SPPT - (int)$dt->JML_BAYAR;
    //         if($selisih < 0) {
    //             $selisih = 0;
    //         }
    
    //         $data['dt'] = array(
    //             'nop' => $dt->NOP_LKP, 
    //             'thn_pajak' => $dt->THN_PAJAK_SPPT, 
    //             'alamat_op' => $dt->JALAN_OP . ' ' . $dt->BLOK_KAV_NO_OP, 
    //             'rtrw_op' => $dt->RT_OP . '/' . $dt->RW_OP, 
    //             'kel_op' => $dt->NM_KELURAHAN, 
    //             'kec_op' => $dt->NM_KECAMATAN, 
    //             'kota_op' => 'DEPOK', 
    //             'nama_wp' => $dt->NM_WP_SPPT, 
    //             'alamat_wp' => $dt->JLN_WP_SPPT . ' ' . $dt->BLOK_KAV_NO_WP_SPPT, 
    //             'rtrw_wp' => $dt->RT_WP_SPPT . '/' . $dt->RW_WP_SPPT, 
    //             'kel_wp' => $dt->KELURAHAN_WP_SPPT, 
    //             'kota_wp' => $dt->KOTA_WP_SPPT, 
    //             'luas_bumi' => fmt_number($dt->LUAS_BUMI_SPPT), 
    //             'kelas_bumi' => $dt->KD_KLS_TANAH, 
    //             'njop_bumi_perm' => fmt_number($dt->NJOP_BUMI_PERM), 
    //             'njop_bumi' => fmt_number($dt->NJOP_BUMI_SPPT), 
    //             'luas_bng' => fmt_number($dt->LUAS_BNG_SPPT), 
    //             'kelas_bng' => $dt->KD_KLS_BNG, 
    //             'njop_bng_perm' => fmt_number($dt->NJOP_BNG_PERM), 
    //             'njop_bng' => fmt_number($dt->NJOP_BNG_SPPT), 
    //             'luas_bumi_bersama' => fmt_number($dt->LUAS_BUMI_BERSAMA), 
    //             'kelas_bumi_bersama' => $dt->KD_KLS_TANAH_BERSAMA, 
    //             'njop_bumi_perm_bersama' => fmt_number($dt->NJOP_BUMI_BERSAMA_PERM), 
    //             'njop_bumi_bersama' => fmt_number($dt->NJOP_BUMI_BERSAMA), 
    //             'luas_bng_bersama' => fmt_number($dt->LUAS_BNG_BERSAMA), 
    //             'kelas_bng_bersama' => $dt->KD_KLS_BNG_BERSAMA, 
    //             'njop_bng_perm_bersama' => fmt_number($dt->NJOP_BNG_BERSAMA_PERM), 
    //             'njop_bng_bersama' => fmt_number($dt->NJOP_BNG_BERSAMA), 
    //             'jml_njop_bumi' => fmt_number($dt->TTL_NJOP_BUMI), 
    //             'jml_njop_bng' => fmt_number($dt->TTL_NJOP_BNG), 
    //             'ttl_njop' => fmt_number($dt->NJOP_SPPT), 
    //             'njoptkp' => fmt_number($dt->NJOPTKP_SPPT), 
    //             'txt_c' => '(' . $dt->NIL_NJKP . ' % x ' . fmt_number($njopkp) . ' )' , 
    //             'njopkp' => fmt_number($njopkp_njkp), 
    //             'tarif' => $dt->NIL_TARIF . ' %', 
    //             'txt_e' => '(' . $dt->NIL_TARIF . ' % x ' . fmt_number($njopkp_njkp) . ' )' , 
    //             'pbb_terhutang' => fmt_number($dt->PBB_TERHUTANG_SPPT), 
    //             'faktor_pengurang' => fmt_number($dt->FAKTOR_PENGURANG_SPPT), 
    //             'txt_g' => '(' . fmt_number($dt->PBB_TERHUTANG_SPPT) . ' - ' . fmt_number($dt->FAKTOR_PENGURANG_SPPT) . ' )' , 
    //             'pbb_yg_harus_dibayar' => fmt_number($dt->PBB_YG_HARUS_DIBAYAR_SPPT), 
    //             'denda_yg_sudah_dibayar' => fmt_number($dt->BAYAR_DENDA), 
    //             'pbb_yg_sudah_dibayar' => fmt_number($dt->JML_BAYAR), 
    //             'selisih' => fmt_number($selisih), 
    //             'tgl_jttempo' => $dt->TGL_JTTEMPO, 
    //             'tgl_terbit' => $dt->TGL_TERBIT, 
    //             'tgl_cetak' => $dt->TGL_CETAK
    //         );

    //         $this->load->view('vpermohonan_online_upt_detail', $data);

    //     } else {
    //         $this->session->set_flashdata('msg_success', 'Data tidak ditemukan..');
    //         redirect(active_module_url('permohonan_online_upt'));
    //     }

    // }

    function generate_otp($length = 6) {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $otp = '';
        for ($i = 0; $i < $length; $i++) {
            $otp .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $otp;
    }

    public function get_lampiran_by_pelayanan() {
        $kd = $this->input->post('jns_ply'); // KD_JNS_PELAYANAN
        $data = new stdClass();

        $lampiran = $this->permohonan_online_upt_model->getLampiran($kd);

        if ($lampiran) {
            $data->result = "200";
            $data->lampiran = $lampiran;
        } else {
            $data->result = "400";
            $data->lampiran = [];
        }

        echo json_encode($data);
    }

    public function get_lampiran_by_pelayanan_and_sub() {
        $kd = $this->input->post('jns_ply'); // KD_JNS_PELAYANAN
        $kdsub = trim($this->input->post('sub_jns_ply')); // KD_SUB_JNS_PELAYANAN
        $data = new stdClass();

        if ($kdsub != '999999') {
            $lampiran = $this->permohonan_online_upt_model->getLampiranSub($kd, $kdsub);
        } else {
            $lampiran = $this->permohonan_online_upt_model->getLampiran($kd);
        }
        

        if ($lampiran) {
            $data->result = "200";
            $data->lampiran = $lampiran;
        } else {
            $data->result = "400";
            $data->lampiran = [];
        }

        echo json_encode($data);
    }

    public function get_ref_pengurangan() {
        $kdsub = trim($this->input->post('sub_jns_ply')); // KD_SUB_JNS_PELAYANAN
        $data = new stdClass();

        $dt_png = $this->permohonan_online_upt_model->get_ref_pengurangan($kdsub);
        
        

        if ($dt_png) {
            $data->result = "200";
            $data->jns_png = $dt_png->NM_LOOKUP_ITEM;
            $data->pct_png = $dt_png->PCT_PENGURANGAN;
        } else {
            $data->result = "400";
            $data->dt_png = [];
        }

        echo json_encode($data);
    }

    /// MUTASI SEBAGIAN
    function grid_dtl_nop() {
        $id_ppo = $this->uri->segment(4);

        // $btn_edt = '<a class="btn_edit_detail" data-toggle="modal" data-target="#cuDialogDetail" href="">Ubah</a>';
        $this->load->library('Datatables');
        // A1.THN_PELAYANAN||'-'||A1.BUNDEL_PELAYANAN||'-'||A1.NO_URUT_PELAYANAN AS DTLID
        // A3.ID AS ID_DTL

        // CASE WHEN MOP.NO_URUT_MUTASI = 1 THEN RP.NM_JENIS_PELAYANAN ELSE RPB.NM_JENIS_PELAYANAN END AS NM_JENIS_PELAYANAN,
        $this->datatables->select("PO.ID as DTLID, MOP.NO_URUT_MUTASI,
        CASE WHEN MOP.KD_KECAMATAN IS NULL THEN 
        MOP.KD_PROPINSI||'.'||MOP.KD_DATI2||'.'||'XXX'||'.'||'XXX'||'.'||'XXX'||'.'||'XXXX'||'.'||'X'
        ELSE MOP.KD_PROPINSI||'.'||MOP.KD_DATI2||'.'||MOP.KD_KECAMATAN||'.'||MOP.KD_KELURAHAN||'.'||MOP.KD_BLOK||'.'||MOP.NO_URUT||'.'||MOP.KD_JNS_OP END AS NOP,
        CASE WHEN MOP.NO_URUT_MUTASI = 1 THEN 'MUTASI SEBAGIAN' ELSE 'PENDAFTARAN DATA BARU' END AS NM_JENIS_PELAYANAN,
        'edit' AS EDIT, 'hapus' AS HAPUS", false);
        $this->datatables->from('PST_PERMOHONAN_TOOL PO', false);
        $this->datatables->join('MUT_DAT_OBJEK_PAJAK_OL MOP', 'PO.ID = MOP.DOCH_ID');
        // $this->datatables->join('REF_JNS_PELAYANAN RP', 'PO.KD_JNS_PELAYANAN = RP.KD_JNS_PELAYANAN');
        // $this->datatables->join('REF_JNS_PELAYANAN RPB', 'RPB.KD_JNS_PELAYANAN="01"', "left", false);
        $this->datatables->where('PO.ID', $id_ppo);
        // $this->datatables->where('PO.ID', $id_ppo);

        // $this->datatables->rupiah_column('4');

        echo $this->datatables->generate();
    }

    function grid_dtl_bng_mutsb() {
        $fnop           = $this->uri->segment(4);
        $urut_mutasi    = $this->uri->segment(5);
        // $fnop   = $this->input->get('nop');
        // $string_replace = array('.', '-');
        // $nop   = str_replace($string_replace, '', $fnop);
        // $prop_kd = substr($nop, 0, 2);
        // $kab_kd  = substr($nop, 2, 2);
        // $kec_kd  = substr($nop, 4, 3);
        // $kel_kd  = substr($nop, 7, 3);
        // $blok_kd = substr($nop, 10, 3);
        // $urut_no = substr($nop, 13, 4);
        // $jns_kd  = substr($nop, 17, 1);
        // $thn_ply = substr($nop, 18, 4);
        // $kd_ply  = substr($nop, 22, 2);


        // $btn_edt = '<a class="btn_edit_detail" data-toggle="modal" data-target="#cuDialogDetail" href="">Ubah</a>';
        $this->load->library('Datatables');
        $this->datatables->select("DOB.ID, 'edit' as MODEL, DOB.NO_BNG, RJ.NM_JPB, DOB.LUAS_BNG, DOB.KD_JPB", false);
        $this->datatables->from('PST_PERMOHONAN_TOOL SP');
        $this->datatables->join('MUT_DAT_OP_BANGUNAN_OL DOB', 'SP.ID = DOB.DOCH_ID');
        $this->datatables->join('REF_JPB RJ', 'RJ.KD_JPB = DOB.KD_JPB');
        // $this->datatables->where('SP.KD_PROPINSI_PEMOHON', $prop_kd);
        // $this->datatables->where('SP.KD_DATI2_PEMOHON', $kab_kd);
        // $this->datatables->where('SP.KD_KECAMATAN_PEMOHON', $kec_kd);
        // $this->datatables->where('SP.KD_KELURAHAN_PEMOHON', $kel_kd);
        // $this->datatables->where('SP.KD_BLOK_PEMOHON', $blok_kd);
        // $this->datatables->where('SP.NO_URUT_PEMOHON', $urut_no);
        // $this->datatables->where('SP.KD_JNS_OP_PEMOHON', $jns_kd);
        // $this->datatables->where('SP.THN_PELAYANAN', $thn_ply);
        // $this->datatables->where('SP.KD_JNS_PELAYANAN', $kd_ply);
        $this->datatables->where('SP.ID', $fnop);
        $this->datatables->where('DOB.NO_URUT_MUTASI', $urut_mutasi);
        
        // $this->datatables->rupiah_column('4');

        echo $this->datatables->generate();
    }

    function grid_dtl_fas_mutsb() {
        $id_head = $this->uri->segment(4);

        // $btn_edt = '<a class="btn_edit_detail" data-toggle="modal" data-target="#cuDialogDetail" href="">Ubah</a>';
        $this->load->library('Datatables');
        $this->datatables->select("FAS.ID, 'edit' as MODEL, RF.NM_FASILITAS, FAS.JML_SATUAN, FAS.KD_FASILITAS", false);
        $this->datatables->from('MUT_DAT_FASILITAS_BANGUNAN_OL FAS');
        $this->datatables->join('FASILITAS RF', 'RF.KD_FASILITAS = FAS.KD_FASILITAS');
        $this->datatables->where('FAS.DOCD_ID', $id_head);

        // $this->datatables->rupiah_column('4');

        echo $this->datatables->generate();
    }

    public function changenop() {
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_danger', $this->module_auth->msg_read);
            redirect('tool_pbb');
        }

        $param = $this->uri->segment(4);
        $urut = $this->uri->segment(5);

        $data['page_menu'] = 'upt';
        $data['current'] = 'permohonan_online_upt';
        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = '';
        
        $ppo = $this->permohonan_online_upt_model->get_ppo_by_id($param);

        

        if ($ppo){
           
                // $dt = $this->permohonan_online_upt_model->get_by_id($param);
                $get = $this->permohonan_online_upt_model->get_edit_mutasi_sebagian($param);
                // $get = $this->permohonan_online_upt_model->get_mutasi_sebagian_online_perurut($ppo->NOP, $ppo->THN_PELAYANAN, $urut);

        
                $data['dt'] = array(
                    'id_ppo' => $get->ID_PPO,
                    'paramm' => $param,
                    'no_prm' => $get->NO_SRT_PERMOHONAN,
                    'tgl_pm' => date('d-m-Y', strtotime($get->TGL_SURAT_PERMOHONAN)),
                    'nm_pemohon' => $get->NAMA_PEMOHON,
                    'telp' => $get->HPPEMOHON,
                    'keterangan' => $get->KETERANGAN_PST,
                    'thn_permohonan' => $get->THN_PAJAK_PERMOHONAN,
                    'alamat_pm' => $get->ALAMAT_PEMOHON,
                    'L_SKKP_PBB' => $get->L_SKKP_PBB,
                    'L_SPMKP_PBB' => $get->L_SPMKP_PBB,
                    'L_KTP_WP' => $get->L_KTP_WP,
                    'L_SERTIFIKAT_TANAH' => $get->L_SERTIFIKAT_TANAH,
                    'L_IMB' => $get->L_IMB,
                    'L_AKTE_JUAL_BELI' => $get->L_AKTE_JUAL_BELI,
                    'L_SURAT_KUASA' => $get->L_SURAT_KUASA,
                    'L_PERMOHONAN' => $get->L_PERMOHONAN,
                    'L_STTS' => $get->L_STTS,
                    'L_SK_KEBERATAN' => $get->L_SK_KEBERATAN,
                    'L_SPPT' => $get->L_SPPT,
                    'L_SPPT_STTS' => $get->L_SPPT_STTS,
                    'L_SK_PENGURANGAN' => $get->L_SK_PENGURANGAN,
                    'L_LAIN_LAIN' => $get->L_LAIN_LAIN,
                    'pct_pengurangan' => $get->PCT_PENGURANGAN,
                    'jml_mutasi' => $get->JML_MUTASI,
                    'kd_jns_pelayanan' => $get->KD_JNS_PELAYANAN,
                    'kd_jns_ply' => $get->KD_JNS_PELAYANAN,
                    'kd_sub_jns_ply' => $get->KD_SUB_JNS_PELAYANAN,

                );

                $pbo = $this->permohonan_online_upt_model->get_mutasi_sebagian_online_perurut($ppo->NOP, $ppo->THN_PELAYANAN, $urut);
                $data['id_mut_dsp'] = trim($pbo->ID_MUT_DSP);
                $data['id_mut_dop'] = trim($pbo->ID_MUT_DOP);  
                $data['id_mut_dob'] = trim($pbo->ID_MUT_DOB);  
                $data['ktp_wp'] = trim($pbo->SUBJEK_PAJAK_ID);
                $data['nama_wp'] = trim($pbo->NM_WP);
                // $data['np_wp'] = trim($pbo->NPWP);
                $data['hp_wp'] = $pbo->HP_WP;
                $data['email_wp'] = $pbo->EMAIL_WP;
                $data['jalan_wp'] = $pbo->JALAN_WP;
                $data['blok_wp'] = $pbo->BLOK_KAV_NO_WP;
                $data['kelurahan_wp'] = $pbo->KELURAHAN_WP;
                $data['kota_wp'] = $pbo->KOTA_WP;
                $data['kodepos_wp'] = $pbo->KD_POS_WP;
                $data['rt_wp'] = $pbo->RT_WP;
                $data['rw_wp'] = $pbo->RW_WP;
                $data['np_wp'] = $pbo->NPWP;
                // $data['dt']['kec_twp'] = '';
                $data['dt']['rt_op'] = $pbo->RT_OP;
                $data['dt']['rw_op'] = $pbo->RW_OP;
                $data['dt']['jalan_op'] = $pbo->JALAN_OP;
                $data['dt']['jalan_wp'] = $pbo->JALAN_WP;
                $data['dt']['blok_op'] = $pbo->BLOK_KAV_NO_OP;
                $data['dt']['kd_znt_op'] = $pbo->KD_ZNT;
                $data['dt']['luas_bumi'] = $pbo->LUAS_BUMI;
                $data['dt']['kec_top'] = '';
                $data['dt']['kel_top'] = '';
                $data['dt']['kodepos_op'] = '';

                $fnop = $pbo->KD_KECAMATAN ? $pbo->FNOP : '32.78.XXX.XXX.XXX.XXXX.X';
                $data['dt']['f_nop'] = trim($fnop);
                $data['dt']['urut_mutasi'] = $urut;

                //---------------------------------------------------------------------------------------------------------
                $get_select_pekerjaan_wp = $this->permohonan_online_upt_model->pekerjaan_wp_droplist(NULL);
                $select_pekerjaan_wp = '<select class="form-control" id="pekerjaan_wp" name="pekerjaan_wp" style="width:90%; height:100% !important;">';
                foreach ($get_select_pekerjaan_wp as $key => $va) {
                    $selected = '';
                    if ($pbo->STATUS_PEKERJAAN_WP == $va->KD_LOOKUP_ITEM) {
                        $selected = 'selected';
                    }
                    $select_pekerjaan_wp .= '<option ' . $selected . ' value="' . $va->KD_LOOKUP_ITEM . '">' . $va->NM_LOOKUP_ITEM . '</option>';
                }
                $select_pekerjaan_wp .= '</select>';
                $data['select_pekerjaan_wp'] = $select_pekerjaan_wp;
                //---------------------------------------------------------------------------------------------------------
                $get_select_znt = $this->permohonan_online_upt_model->select_znt($get->KD_PROPINSI, $get->KD_DATI2, $get->KD_KECAMATAN, $get->KD_KELURAHAN, $get->KD_BLOK);
                $select_kd_znt = '<select class="form-control" id="kd_znt_op" name="kd_znt_op" style="width:90%; height:100% !important;">';
                foreach ($get_select_znt as $key => $va) {
                    $selected = '';
                    if ($pbo->KD_ZNT == $va->KD_ZNT) {
                        $selected = 'selected';
                    }
                    $select_kd_znt .= '<option ' . $selected . ' value="' . $va->KD_ZNT . '">' . $va->KD_ZNT . '</option>';
                }
                $select_kd_znt .= '</select>';
                $data['select_kode_znt'] = $select_kd_znt;

                //---------------------------------------------------------------------------------------------------------
                $select_data = $this->permohonan_online_upt_model->get_select_by_nop($get->NOP);
                $options     = array();
                if ($select_data) {
                    foreach ($select_data as $row) {

                        if (empty($nop_kd)) {
                            $nop_kd = $row->NOP;
                        };
                        $options[$row->NOP_VAL] = $row->NOP;
                    }
                } else {
                    $options['0'] = 'Data not found';
                }
                $js = 'id="f_nop" class="form-control" style="width:200px" onchange="nop(this.value)" ';
                $data['select_nop_kd'] = preg_replace("/[\r\n]+/", "", form_dropdown('f_nop', $options, $get->NOP, $js));
                //---------------------------------------------------------------------------------------------------------
                $get_select_jns_tanah = $this->permohonan_online_upt_model->lookup_item_droplist(20, NULL);
                $select_jns_tanah = '<select class="form-control" id="jns_tanah_op" required name="jns_tanah_op" style="width:100%; height:100% !important;">';
                // $select_jns_tanah .= '<option value="">-Silahkan Pilih-</option>';
                foreach ($get_select_jns_tanah as $key => $va) {
                    $selected = '';
                    if ($pbo->JNS_BUMI == $va->KD_LOOKUP_ITEM) {
                        $selected = 'selected';
                        // $selected = $pbo->JNS_BUMI;
                    }
                    $select_jns_tanah .= '<option ' . $selected . ' value="' . $va->KD_LOOKUP_ITEM . '">' . $va->NM_LOOKUP_ITEM . '</option>';
                }
                $select_jns_tanah .= '</select>';
                $data['select_jns_tanah'] = $select_jns_tanah;
                //---------------------------------------------------------------------------------------------------------
                // $get_select_jns_tanah = $this->permohonan_online_upt_model->lookup_item_droplist(20, NULL);
                // $select_jns_tanah = '<select class="form-control" id="jns_tanah_op" reqget_select_kec_opuired name="jns_tanah_op" onChange="dat_objek_bangunan02(this.value)" style="width:100%; height:100% !important;">';
                // $select_jns_tanah .= '<option value="">-Silahkan Pilih-</option>';
                // foreach ($get_select_jns_tanah as $key => $va) {
                //     $selected = '';
                //     if ($ppost['jns_tanah_op'] == $va->KD_LOOKUP_ITEM) {
                //         $selected = 'selected';
                //     }
                //     $select_jns_tanah .= '<option ' . $selected . ' value="' . $va->KD_LOOKUP_ITEM . '">' . $va->NM_LOOKUP_ITEM . '</option>';
                // }
                // $select_jns_tanah .= '</select>';
                // $data['select_jns_tanah02'] = $select_jns_tanah;
                //---------------------------------------------------------------------------------------------------------
                $get_select_status_objek_pajak = $this->permohonan_online_upt_model->lookup_item_droplist('10', NULL);
                $select_status_objek_pajak = '<select class="form-control" id="status_op" required name="status_op" style="width:100%; height:100% !important;">';
                $select_status_objek_pajak .= '<option value="">-Silahkan Pilih-</option>';
                foreach ($get_select_status_objek_pajak as $key => $va) {
                    $selected = '';
                    if ($pbo->KD_STATUS_WP == $va->KD_LOOKUP_ITEM) {
                        $selected = 'selected';
                    }
                    $select_status_objek_pajak .= '<option ' . $selected . ' value="' . $va->KD_LOOKUP_ITEM . '">' . $va->NM_LOOKUP_ITEM . '</option>';
                }
                $select_status_objek_pajak .= '</select>';
                $data['select_status_objek_pajak'] = $select_status_objek_pajak;
                //---------------------------------------------------------------------------------------------------------
                $get_select_kondisi_bng = $this->permohonan_online_upt_model->lookup_item_droplist(21, NULL);
                $select_kondisi_bng = '<select class="form-control" id="dtl_kondisi_bng" required name="dtl_kondisi_bng" style="width:100%; height:100% !important;">';
                $select_kondisi_bng .= '<option value="">-Silahkan Pilih-</option>';
                foreach ($get_select_kondisi_bng as $key => $va) {
                    $selected = '';
                    // if ($ppost['dtl_kondisi_bng'] == $va->KD_LOOKUP_ITEM) {
                    //     $selected = 'selected';
                    // }
                    $select_kondisi_bng .= '<option ' . $selected . ' value="' . $va->KD_LOOKUP_ITEM . '">' . $va->NM_LOOKUP_ITEM . '</option>';
                }
                $select_kondisi_bng .= '</select>';
                $data['select_kondisi_bng'] = $select_kondisi_bng;
                //---------------------------------------------------------------------------------------------------------
                $get_select_dinding_bng = $this->permohonan_online_upt_model->lookup_item_droplist(42, NULL);
                $select_dinding_bng = '<select class="form-control" id="dtl_jns_dinding" required name="dtl_jns_dinding" style="width:100%; height:100% !important;">';
                $select_dinding_bng .= '<option value="">-Silahkan Pilih-</option>';
                foreach ($get_select_dinding_bng as $key => $va) {
                    $selected = '';
                    // if ($ppost['dtl_jns_dinding'] == $va->KD_LOOKUP_ITEM) {
                    //     $selected = 'selected';
                    // }
                    $select_dinding_bng .= '<option ' . $selected . ' value="' . $va->KD_LOOKUP_ITEM . '">' . $va->NM_LOOKUP_ITEM . '</option>';
                }
                $select_dinding_bng .= '</select>';
                $data['select_dinding_bng'] = $select_dinding_bng;
                //---------------------------------------------------------------------------------------------------------
                $get_select_konstr_bng = $this->permohonan_online_upt_model->lookup_item_droplist(22, NULL);
                $select_konstr_bng = '<select class="form-control" id="dtl_jns_konstr" required name="dtl_jns_konstr" style="width:100%; height:100% !important;">';
                $select_konstr_bng .= '<option value="">-Silahkan Pilih-</option>';
                foreach ($get_select_konstr_bng as $key => $va) {
                    $selected = '';
                    // if ($ppost['dtl_jns_konstr'] == $va->KD_LOOKUP_ITEM) {
                    //     $selected = 'selected';
                    // }
                    $select_konstr_bng .= '<option ' . $selected . ' value="' . $va->KD_LOOKUP_ITEM . '">' . $va->NM_LOOKUP_ITEM . '</option>';
                }
                $select_konstr_bng .= '</select>';
                $data['select_konstr_bng'] = $select_konstr_bng;
                //---------------------------------------------------------------------------------------------------------
                $get_select_atap_bng = $this->permohonan_online_upt_model->lookup_item_droplist(41, NULL);
                $select_atap_bng = '<select class="form-control" id="dtl_jns_atap" required name="dtl_jns_atap" style="width:100%; height:100% !important;">';
                $select_atap_bng .= '<option value="">-Silahkan Pilih-</option>';
                foreach ($get_select_atap_bng as $key => $va) {
                    $selected = '';
                    // if ($ppost['dtl_jns_atap'] == $va->KD_LOOKUP_ITEM) {
                    //     $selected = 'selected';
                    // }
                    $select_atap_bng .= '<option ' . $selected . ' value="' . $va->KD_LOOKUP_ITEM . '">' . $va->NM_LOOKUP_ITEM . '</option>';
                }
                $select_atap_bng .= '</select>';
                $data['select_atap_bng'] = $select_atap_bng;
                //---------------------------------------------------------------------------------------------------------
                $get_select_jns_lantai = $this->permohonan_online_upt_model->lookup_item_droplist(43, NULL);
                $select_jns_lantai = '<select class="form-control" id="dtl_jns_lantai" required name="dtl_jns_lantai" style="width:100%; height:100% !important;">';
                $select_jns_lantai .= '<option value="">-Silahkan Pilih-</option>';
                foreach ($get_select_jns_lantai as $key => $va) {
                    $selected = '';
                    // if ($ppost['dtl_jns_lantai'] == $va->KD_LOOKUP_ITEM) {
                    //     $selected = 'selected';
                    // }
                    $select_jns_lantai .= '<option ' . $selected . ' value="' . $va->KD_LOOKUP_ITEM . '">' . $va->NM_LOOKUP_ITEM . '</option>';
                }
                $select_jns_lantai .= '</select>';
                $data['select_jns_lantai'] = $select_jns_lantai;
                //---------------------------------------------------------------------------------------------------------
                $get_select_langit = $this->permohonan_online_upt_model->lookup_item_droplist(44, NULL);
                $select_langit = '<select class="form-control" id="dtl_jns_langit" required name="dtl_jns_langit" style="width:100%; height:100% !important;">';
                $select_langit .= '<option value="">-Silahkan Pilih-</option>';
                foreach ($get_select_langit as $key => $va) {
                    $selected = '';
                    // if ($ppost['dtl_jns_lantai'] == $va->KD_LOOKUP_ITEM) {
                    //     $selected = 'selected';
                    // }
                    $select_langit .= '<option ' . $selected . ' value="' . $va->KD_LOOKUP_ITEM . '">' . $va->NM_LOOKUP_ITEM . '</option>';
                }
                $select_langit .= '</select>';
                $data['select_langit'] = $select_langit;
                //---------------------------------------------------------------------------------------------------------
                $get_select_sts_guna = $this->permohonan_online_upt_model->ref_jbp_droplist(NULL);
                $select_sts_guna = '<select class="form-control" id="dtl_guna_bng" required name="dtl_guna_bng" onchange="f_guna_bng(this.value)" style="width:100%; height:100% !important;">';
                $select_sts_guna .= '<option value="">-Silahkan Pilih-</option>';
                foreach ($get_select_sts_guna as $key => $va) {
                    $selected = '';
                    // if ($ppost['dtl_guna_bng'] == $va->KD_JPB) {
                    //     $selected = 'selected';
                    // }
                    $select_sts_guna .= '<option ' . $selected . ' value="' . $va->KD_JPB . '">' . $va->NM_JPB . '</option>';
                }
                $select_sts_guna .= '</select>';
                $data['select_guna_bng'] = $select_sts_guna;

                // //---------------------------------------------------------------------------------------------------------
                // $get_select_sts_guna = $this->permohonan_online_upt_model->jpb_jpt_droplist(NULL);
                // $select_sts_guna = '<select class="form-control" id="dtl_sts_guna" required name="dtl_sts_guna" style="width:100%; height:100% !important;">';
                // $select_sts_guna .= '<option value="">-Silahkan Pilih-</option>';
                // foreach ($get_select_sts_guna as $key => $va) {
                //     $selected = '';
                //     // if ($ppost['dtl_sts_guna'] == $va->KD_JPB_JPT) {
                //     //     $selected = 'selected';
                //     // }
                //     $select_sts_guna .= '<option ' . $selected . ' value="' . $va->KD_JPB_JPT . '">' . $va->NM_JPB_JPT . '</option>';
                // }
                // $select_sts_guna .= '</select>';
                // $data['select_sts_guna'] = $select_sts_guna;
                // //---------------------------------------------------------------------------------------------------------

                // //////////////////////////////////////////////////////////////////////////////////////////////////////////
                $list_jpbjpt = $this->permohonan_online_upt_model->lookup_item_droplist(45);
                $opsi_jpbjpt = array('' => 'Silahkan Piih');
                foreach ($list_jpbjpt as $key => $aa) {
                    $opsi_jpbjpt[$aa->KD_LOOKUP_ITEM] = $aa->NM_LOOKUP_ITEM;
                }
                $js  = 'class="form-control" id="jpb02_kls_bng" style="width:100%" ';
                $data['select_jpb02_kls_bng'] = form_dropdown('jpb02_kls_bng', $opsi_jpbjpt, '', $js);
                //---------------------------------------------------------------------------------------------------------
                $list_jpbjpt = $this->permohonan_online_upt_model->lookup_item_droplist(46);
                $opsi_jpbjpt = array('' => 'Silahkan Piih');
                foreach ($list_jpbjpt as $key => $aa) {
                    $opsi_jpbjpt[$aa->KD_LOOKUP_ITEM] = $aa->NM_LOOKUP_ITEM;
                }
                $js  = 'class="form-control" id="jpb04_kls_bng" style="width:100%" ';
                $data['select_jpb04_kls_bng'] = form_dropdown('jpb04_kls_bng', $opsi_jpbjpt, '', $js);
                //---------------------------------------------------------------------------------------------------------
                $list_jpbjpt = $this->permohonan_online_upt_model->lookup_item_droplist(50);
                $opsi_jpbjpt = array('' => 'Silahkan Piih');
                foreach ($list_jpbjpt as $key => $aa) {
                    $opsi_jpbjpt[$aa->KD_LOOKUP_ITEM] = $aa->NM_LOOKUP_ITEM;
                }
                $js  = 'class="form-control" id="jpb05_kls_bng" style="width:100%" ';
                $data['select_jpb05_kls_bng'] = form_dropdown('jpb05_kls_bng', $opsi_jpbjpt, '', $js);
                //---------------------------------------------------------------------------------------------------------
                $list_jpbjpt = $this->permohonan_online_upt_model->lookup_item_droplist(47);
                $opsi_jpbjpt = array('' => 'Silahkan Piih');
                foreach ($list_jpbjpt as $key => $aa) {
                    $opsi_jpbjpt[$aa->KD_LOOKUP_ITEM] = $aa->NM_LOOKUP_ITEM;
                }
                $js  = 'class="form-control" id="jpb06_kls_bng" style="width:100%" ';
                $data['select_jpb06_kls_bng'] = form_dropdown('jpb06_kls_bng', $opsi_jpbjpt, '', $js);
                //---------------------------------------------------------------------------------------------------------
                $list_jpbjpt = $this->permohonan_online_upt_model->lookup_item_droplist(28);
                $opsi_jpbjpt = array('' => 'Silahkan Piih');
                foreach ($list_jpbjpt as $key => $aa) {
                    $opsi_jpbjpt[$aa->KD_LOOKUP_ITEM] = $aa->NM_LOOKUP_ITEM;
                }
                $js  = 'class="form-control" id="jpb07_jns_hotel" style="width:100%" ';
                $data['select_jpb07_jns_hotel'] = form_dropdown('jpb07_jns_hotel', $opsi_jpbjpt, '', $js);
                //---------------------------------------------------------------------------------------------------------
                $list_jpbjpt = $this->permohonan_online_upt_model->lookup_item_droplist('05');
                $opsi_jpbjpt = array('' => 'Silahkan Piih');
                foreach ($list_jpbjpt as $key => $aa) { 
                    $opsi_jpbjpt[$aa->KD_LOOKUP_ITEM] = $aa->NM_LOOKUP_ITEM;
                }
                $js  = 'class="form-control" id="jpb07_bintang" style="width:100%" ';
                $data['select_jpb07_bintang'] = form_dropdown('jpb07_bintang', $opsi_jpbjpt, '', $js);
                //---------------------------------------------------------------------------------------------------------
                $list_jpbjpt = $this->permohonan_online_upt_model->lookup_item_droplist(22);
                $opsi_jpbjpt = array('' => 'Silahkan Piih');
                foreach ($list_jpbjpt as $key => $aa) {
                    $opsi_jpbjpt[$aa->KD_LOOKUP_ITEM] = $aa->NM_LOOKUP_ITEM;
                }
                $js  = 'class="form-control" id="jpb03_konstruksi" style="width:100%" ';
                $data['select_jpb03_kons'] = form_dropdown('jpb03_konstruksi', $opsi_jpbjpt, '', $js);
                //---------------------------------------------------------------------------------------------------------
                $list_jpbjpt = $this->permohonan_online_upt_model->lookup_item_droplist(22);
                $opsi_jpbjpt = array('' => 'Silahkan Piih');
                foreach ($list_jpbjpt as $key => $aa) {
                    $opsi_jpbjpt[$aa->KD_LOOKUP_ITEM] = $aa->NM_LOOKUP_ITEM;
                }
                $js  = 'class="form-control" id="jpb08_konstruksi" style="width:100%" ';
                $data['select_jpb08_kons'] = form_dropdown('jpb08_konstruksi', $opsi_jpbjpt, '', $js);
                //---------------------------------------------------------------------------------------------------------
                $list_jpbjpt = $this->permohonan_online_upt_model->lookup_item_droplist(45);
                $opsi_jpbjpt = array('' => 'Silahkan Piih');
                foreach ($list_jpbjpt as $key => $aa) {
                    $opsi_jpbjpt[$aa->KD_LOOKUP_ITEM] = $aa->NM_LOOKUP_ITEM;
                }
                $js  = 'class="form-control" id="jpb09_kls_bng" style="width:100%" ';
                $data['select_jpb09_kls_bng'] = form_dropdown('jpb09_kls_bng', $opsi_jpbjpt, '', $js);
                //---------------------------------------------------------------------------------------------------------
                $list_jpbjpt = $this->permohonan_online_upt_model->lookup_item_droplist(49);
                $opsi_jpbjpt = array('' => 'Silahkan Piih');
                foreach ($list_jpbjpt as $key => $aa) {
                    $opsi_jpbjpt[$aa->KD_LOOKUP_ITEM] = $aa->NM_LOOKUP_ITEM;
                }
                $js  = 'class="form-control" id="jpb12_kls_bng" style="width:100%" ';
                $data['select_jpb12_kls_bng'] = form_dropdown('jpb12_kls_bng', $opsi_jpbjpt, '', $js);
                //---------------------------------------------------------------------------------------------------------
                $list_jpbjpt = $this->permohonan_online_upt_model->lookup_item_droplist(52);
                $opsi_jpbjpt = array('' => 'Silahkan Piih');
                foreach ($list_jpbjpt as $key => $aa) {
                    $opsi_jpbjpt[$aa->KD_LOOKUP_ITEM] = $aa->NM_LOOKUP_ITEM;
                }
                $js  = 'class="form-control" id="jpb13_kls_bng" style="width:100%" ';
                $data['select_jpb13_kls_bng'] = form_dropdown('jpb13_kls_bng', $opsi_jpbjpt, '', $js);
                //---------------------------------------------------------------------------------------------------------
                $list_jpbjpt = $this->permohonan_online_upt_model->lookup_item_droplist('09');
                $opsi_jpbjpt = array('' => 'Silahkan Piih');
                foreach ($list_jpbjpt as $key => $aa) {
                    $opsi_jpbjpt[$aa->KD_LOOKUP_ITEM] = $aa->NM_LOOKUP_ITEM;
                }
                $js  = 'class="form-control" id="jpb15_letak_tangki" style="width:100%" ';
                $data['select_jpb15_letak_tangki'] = form_dropdown('jpb15_letak_tangki', $opsi_jpbjpt, '', $js);
                //---------------------------------------------------------------------------------------------------------
                $list_jpbjpt = $this->permohonan_online_upt_model->lookup_item_droplist(48);
                $opsi_jpbjpt = array('' => 'Silahkan Piih');
                foreach ($list_jpbjpt as $key => $aa) {
                    $opsi_jpbjpt[$aa->KD_LOOKUP_ITEM] = $aa->NM_LOOKUP_ITEM;
                }
                $js  = 'class="form-control" id="jpb16_kls_bng" style="width:100%" ';
                $data['select_jpb16_kls_bng'] = form_dropdown('jpb16_kls_bng', $opsi_jpbjpt, '', $js);
                //---------------------------------------------------------------------------------------------------------
                // //////
                // $list_jpbjpt = $this->permohonan_online_upt_model->jpb_jpt_droplist();
                // $opsi_jpbjpt = array('' => 'Silahkan Piih');
                // foreach ($list_jpbjpt as $key => $aa) {
                //     $opsi_jpbjpt[$aa->KD_JPB_JPT] = $aa->NM_JPB_JPT;
                // }
                // $js  = 'class="form-control" id="l_png_op" style="width:100%" onchange="update_jpb(this.checked,this.value)" disabled ';
                // $data['select_jpbjpt'] = form_dropdown('l_png_op', $opsi_jpbjpt, '', $js);
                //---------------------------------------------------------------------------------------------------------
                $list_lookup = $this->permohonan_online_upt_model->lookup_item_droplist(21);
                $opsi_lookup = array('' => 'Silahkan Piih');
                foreach ($list_lookup as $key => $aa) {
                    $opsi_lookup[$aa->KD_LOOKUP_ITEM] = $aa->NM_LOOKUP_ITEM;
                }
                $js  = 'class="form-control" id="l_knd_bng"  style="width:100%" ';
                $data['select_knd_bng'] = form_dropdown('l_knd_bng', $opsi_lookup, '', $js);
                //---------------------------------------------------------------------------------------------------------
                $list_lookup = $this->permohonan_online_upt_model->lookup_item_droplist(42);
                $opsi_lookup = array('' => 'Silahkan Piih');
                foreach ($list_lookup as $key => $aa) {
                    $opsi_lookup[$aa->KD_LOOKUP_ITEM] = $aa->NM_LOOKUP_ITEM;
                }
                $js  = 'class="form-control" id="l_dinding"  style="width:100%" ';
                $data['select_dinding'] = form_dropdown('l_dinding', $opsi_lookup, '', $js);
                //---------------------------------------------------------------------------------------------------------
                $list_lookup = $this->permohonan_online_upt_model->lookup_item_droplist(43);
                $opsi_lookup = array('' => 'Silahkan Piih');
                foreach ($list_lookup as $key => $aa) {
                    $opsi_lookup[$aa->KD_LOOKUP_ITEM] = $aa->NM_LOOKUP_ITEM;
                }
                $js  = 'class="form-control" id="l_lantai"  style="width:100%" ';
                $data['select_llantai'] = form_dropdown('l_lantai', $opsi_lookup, '', $js);
                //---------------------------------------------------------------------------------------------------------
                $list_lookup = $this->permohonan_online_upt_model->lookup_item_droplist(44);
                $opsi_lookup = array('' => 'Silahkan Pilih');
                foreach ($list_lookup as $key => $aa) {
                    $opsi_lookup[$aa->KD_LOOKUP_ITEM] = $aa->NM_LOOKUP_ITEM;
                }
                $js  = 'class="form-control" id="l_langit2"  style="width:100%" ';
                $data['select_llangit2'] = form_dropdown('l_langit2', $opsi_lookup, '', $js);
                //---------------------------------------------------------------------------------------------------------
                $list_lookup = $this->permohonan_online_upt_model->lookup_item_droplist(22);
                $opsi_lookup = array('' => 'Silahkan Piih');
                foreach ($list_lookup as $key => $aa) {
                    $opsi_lookup[$aa->KD_LOOKUP_ITEM] = $aa->NM_LOOKUP_ITEM;
                }
                $js  = 'class="form-control" id="jns_konst"  style="width:100%" ';
                $data['select_jns_konst'] = form_dropdown('jns_konst', $opsi_lookup, '', $js);
                //---------------------------------------------------------------------------------------------------------
                $list_lookup = $this->permohonan_online_upt_model->lookup_item_droplist(41);
                $opsi_lookup = array('' => 'Silahkan Piih');
                foreach ($list_lookup as $key => $aa) {
                    $opsi_lookup[$aa->KD_LOOKUP_ITEM] = $aa->NM_LOOKUP_ITEM;
                }
                $js  = 'class="form-control" id="jns_atap"  style="width:100%" ';
                $data['select_jns_atap'] = form_dropdown('jns_atap', $opsi_lookup, '', $js);
                //---------------------------------------------------------------------------------------------------------
                $list_lookup = $this->permohonan_online_upt_model->ref_fasilitas_droplist();
                $opsi_lookup = array('' => 'Silahkan Piih');
                foreach ($list_lookup as $key => $aa) {
                    $opsi_lookup[$aa->KD_FASILITAS] = $aa->NM_FASILITAS;
                }
                $js  = 'class="form-control" id="dtlfas_kd_fasilitas"  style="width:100%" ';
                $data['select_dtl_fas'] = form_dropdown('dtlfas_kd_fasilitas', $opsi_lookup, '', $js);
                //////////////////////////////////////////////////////////////////////////////////////////////////////////
                
                // //---------------------------------------------------------------------------------------------------------
                $select_data  = $this->permohonan_online_upt_model->get_jns_ply($get->KD_JNS_PELAYANAN);
                $options      = array();
                foreach ($select_data as $row) {
                    $options[$row->KD_JNS_PELAYANAN] = $row->NM_JENIS_PELAYANAN;
                }
                $js                   = 'class="form-control" id="jns_ply" disabled style="width:90%; height:100% !important;" ';
                $select               = form_dropdown('jns_ply', $options, $get->KD_JNS_PELAYANAN, $js);
                $select               = preg_replace("/[\r\n]+/", "", $select);
                $data['select_jnsply'] = $select;
                //////////////////////////////////////////////////////////////////////////////////////////////////////////

                $this->load->view('vpermohonan_online_upt_19_nop_form', $data);

                

        } else {
            $this->session->set_flashdata('msg_danger', 'Data tidak ditemukan..');
            redirect(active_module_url('permohonan_online_upt'));
        }
    }

    function save_edit_mutasi_sebagian() {
        $p_id = $this->uri->segment(4);
        $this->session->set_flashdata('msg_success', 'Data NOP Berhasil disimpan');
        redirect(active_module_url() . 'permohonan_online_upt/edit/' . $p_id);
    }

    function save_data_subjek_pajak() {

        $id_ppo         = $this->input->post('id_ppo');
        $id_mut_dsp     = $this->input->post('id_mut_dsp');
        $ktp_wp         = $this->input->post('ktp_wp');
        $nama_wp        = strtoupper($this->input->post('nama_wp'));
        $jalan_wp       = strtoupper($this->input->post('jalan_wp'));
        $blok_wp        = strtoupper($this->input->post('blok_wp'));
        $rt_wp          = $this->input->post('rt_wp');
        $rw_wp          = $this->input->post('rw_wp');
        $kelurahan_wp   = strtoupper($this->input->post('kelurahan_wp'));
        $kota_wp        = strtoupper($this->input->post('kota_wp'));
        $kodepos_wp     = $this->input->post('kodepos_wp');
        $hp_wp          = $this->input->post('hp_wp');
        $np_wp          = $this->input->post('np_wp');
        $pekerjaan_wp   = $this->input->post('pekerjaan_wp');
        $email_wp       = strtoupper($this->input->post('email_wp'));

        if ($id_ppo && $get = $this->permohonan_online_upt_model->getdt_tbl_mutasi_sebagian($id_ppo, $id_mut_dsp, 'MUT_DAT_SUBJEK_PAJAK_OL')) {

            // update data MUT_DAT_SUBJEK_PAJAK_OL
            $sql = " BEGIN
                        begin 
                        UPDATE MUT_DAT_SUBJEK_PAJAK_OL SET  
                            SUBJEK_PAJAK_ID = '{$ktp_wp}', NM_WP = '{$nama_wp}', JALAN_WP = '{$jalan_wp}', BLOK_KAV_NO_WP = '{$blok_wp}', 
                            RW_WP = '{$rw_wp}', RT_WP = '{$rt_wp}', KELURAHAN_WP = '{$kelurahan_wp}', KOTA_WP = '{$kota_wp}', 
                            KD_POS_WP = '{$kodepos_wp}', HP_WP = '{$hp_wp}', NPWP = '{$np_wp}', 
                            STATUS_PEKERJAAN_WP = '{$pekerjaan_wp}', EMAIL_WP = '{$email_wp}'
                        WHERE ID = {$id_mut_dsp} AND DOCH_ID = {$id_ppo}
                        ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                        end; ";
               
            $sql .= " COMMIT;
                      END; ";
            //
            // log_message('info', " XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX data_simpan_dtl PEMBETULAN ONLINE: " . $sql);
            $error_msg = $this->db->simple_qry_eon_ora($sql);
            $err_Msg = $error_msg['message'];
            if (!empty($err_Msg)) {
                $error_CRUD = $err_Msg . ', Proses gagal....!!!';
                echo $error_CRUD;
            } else {
                echo 'Berhasil Simpan Data Subjek Pajak';
            }

        } else {
            echo 'ERROR.. Data tidak ditemukan... silakan muat ulang halaman';
        }

    }

    function save_data_objek_pajak() {

        $id_ppo         = $this->input->post('id_ppo');
        $id_mut_dop     = $this->input->post('id_mut_dop');
        $id_mut_dob     = $this->input->post('id_mut_dob');
        $ktp_wp         = $this->input->post('ktp_wp');
        $jalan_op       = strtoupper($this->input->post('jalan_op'));
        $blok_op        = strtoupper($this->input->post('blok_op'));
        $rt_op          = $this->input->post('rt_op');
        $rw_op          = $this->input->post('rw_op');
        $jns_tanah_op   = $this->input->post('jns_tanah_op');
        $luas_bumi      = strtoupper($this->input->post('luas_bumi'));
        $kd_znt_op      = $this->input->post('kd_znt_op');
        $status_op      = $this->input->post('status_op');

        //// CEK DAT OP BUMI
        if ($id_ppo && $get = $this->permohonan_online_upt_model->getdt_tbl_mutasi_sebagian($id_ppo, $id_mut_dop, 'MUT_DAT_OBJEK_PAJAK_OL')) {

            // update data MUT_DAT_OBJEK_PAJAK_OL
            $sql = " BEGIN
                        begin 
                        UPDATE MUT_DAT_OBJEK_PAJAK_OL SET  
                            SUBJEK_PAJAK_ID = '{$ktp_wp}', JALAN_OP = '{$jalan_op}', BLOK_KAV_NO_OP = '{$blok_op}', RW_OP = '{$rw_op}', 
                            RT_OP = '{$rt_op}', TOTAL_LUAS_BUMI = {$luas_bumi}, KD_STATUS_WP = '{$status_op}'
                        WHERE ID = {$id_mut_dop} AND DOCH_ID = {$id_ppo}
                        ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                        end; ";
            
            //// CEK DAT OP BUMI
            if ($this->permohonan_online_upt_model->getdt_tbl_mutasi_sebagian($id_ppo, $id_mut_dob, 'MUT_DAT_OP_BUMI_OL')) {

                // update data MUT_DAT_OP_BUMI_OL
                $sql .= " 
                        begin 
                        UPDATE MUT_DAT_OP_BUMI_OL SET  
                            KD_ZNT = '{$kd_znt_op}', LUAS_BUMI = {$luas_bumi}, JNS_BUMI = '{$jns_tanah_op}'
                        WHERE ID = {$id_mut_dob} AND DOCH_ID = {$id_ppo}
                        ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                        end; ";
            }

               
            $sql .= " COMMIT;
                      END; ";
            //
            // log_message('info', " XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX data_simpan_dtl PEMBETULAN ONLINE: " . $sql);
            $error_msg = $this->db->simple_qry_eon_ora($sql);
            $err_Msg = $error_msg['message'];
            if (!empty($err_Msg)) {
                $error_CRUD = $err_Msg . ', Proses gagal....!!!';
                echo $error_CRUD;
            } else {
                echo 'Berhasil Simpan Data Objek Pajak';
            }

        } else {
            echo 'ERROR.. Data tidak ditemukan... silakan muat ulang halaman';
        }
    }

    ////
    function get_dtl_bng_mutsbg() {
        $id_dtl = $this->uri->segment(4);
        $data = $this->permohonan_online_upt_model->get_dtl_bng_mutasi_sebagian($id_dtl);
        echo json_encode($data);
    }

    function delete_dtl_bng_mutsbg() {
        $id_op_bng = $this->uri->segment(4);
        if ($id_op_bng && $get = $this->permohonan_online_upt_model->get_dtl_bng_mutasi_sebagian($id_op_bng)) {
            $sql = " BEGIN ";

            $sql .= "   
                    begin 
                    DELETE FROM MUT_DAT_JPB2_OL WHERE DOCD_ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; 
                    begin 
                    DELETE FROM MUT_DAT_JPB3_OL WHERE DOCD_ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; 
                    begin 
                    DELETE FROM MUT_DAT_JPB4_OL WHERE DOCD_ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; 
                    begin 
                    DELETE FROM MUT_DAT_JPB5_OL WHERE DOCD_ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; 
                    begin 
                    DELETE FROM MUT_DAT_JPB6_OL WHERE DOCD_ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; 
                    begin 
                    DELETE FROM MUT_DAT_JPB7_OL WHERE DOCD_ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; 
                    begin 
                    DELETE FROM MUT_DAT_JPB8_OL WHERE DOCD_ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; 
                    begin 
                    DELETE FROM MUT_DAT_JPB9_OL WHERE DOCD_ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; 
                    begin 
                    DELETE FROM MUT_DAT_JPB12_OL WHERE DOCD_ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; 
                    begin 
                    DELETE FROM MUT_DAT_JPB13_OL WHERE DOCD_ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; 
                    begin 
                    DELETE FROM MUT_DAT_JPB14_OL WHERE DOCD_ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; 
                    begin 
                    DELETE FROM MUT_DAT_JPB15_OL WHERE DOCD_ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; 
                    begin 
                    DELETE FROM MUT_DAT_JPB16_OL WHERE DOCD_ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; ";
            
            $sql .= "
                    begin 
                    DELETE FROM MUT_DAT_FASILITAS_BANGUNAN_OL WHERE DOCD_ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; ";
            
            $sql .= "
                    begin 
                    DELETE FROM MUT_DAT_NILAI_INDIVIDU_OL WHERE DOCD_ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; ";
            
            $sql .= "   
                    begin 
                    DELETE FROM MUT_DAT_OP_BANGUNAN_OL WHERE ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; ";
            
            $sql .= "COMMIT;
                    END; ";
            //
            // log_message('info', " XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX data_delete_bng_ol : " . $sql);
            $error_msg = $this->db->simple_qry_eon_ora($sql);
            $err_Msg = $error_msg['message'];
            if (!empty($err_Msg)) {
                $error_CRUD = $err_Msg . ', Proses hapus gagal....!!!';
                $msg = $error_CRUD;
            } else {
                $msg = 'Hapus Data Bangunan Berhasil';
            }

        } else {
            $msg = 'Data tidak ditemukan..';
        }

        echo $msg;
    }

    function delete_dtl_fas_bng_mutsbg() {
        $id_fasilitas = $this->uri->segment(4);
        if ($id_fasilitas ) {
            $sql = " BEGIN ";

            $sql .= "
                    begin 
                    DELETE FROM MUT_DAT_FASILITAS_BANGUNAN_OL WHERE ID = {$id_fasilitas}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; ";
            
            $sql .= "COMMIT;
                    END; ";
            //
            // log_message('info', " XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX data_delete_bng_ol : " . $sql);
            $error_msg = $this->db->simple_qry_eon_ora($sql);
            $err_Msg = $error_msg['message'];
            if (!empty($err_Msg)) {
                $error_CRUD = $err_Msg . ', Proses hapus gagal....!!!';
                $msg = $error_CRUD;
            } else {
                $msg = 'Hapus Data Fasilitas Bangunan Berhasil';
            }

        } else {
            $msg = 'Data tidak ditemukan..';
        }

        echo $msg;
    }

    function save_dtl_bangunan_mutsbg() {
        $p_id               = $this->input->post('id_ppo');
        $id_dop             = $this->input->post('id_dop');
        $urut_mutasi        = $this->input->post('urut_mutasi');
        $paramm             = $this->input->post('paramm');
        $dtl_id             = $this->input->post('dtl_id');
        $dtl_model          = $this->input->post('dtl_model');
        $dtl_no_bng         = $this->input->post('dtl_no_bng');
        $dtl_luas_bng       = $this->input->post('dtl_luas_bng');
        $dtl_guna_bng       = $this->input->post('dtl_guna_bng');
        $dtl_thn_bng        = $this->input->post('dtl_thn_bng');
        $dtl_thn_renov      = $this->input->post('dtl_thn_renov');
        $dtl_jml_lantai     = $this->input->post('dtl_jml_lantai');
        $dtl_kondisi_bng    = $this->input->post('dtl_kondisi_bng');
        $dtl_jns_konstr     = $this->input->post('dtl_jns_konstr');
        $dtl_jns_atap       = $this->input->post('dtl_jns_atap');
        $dtl_jns_dinding    = $this->input->post('dtl_jns_dinding');
        $dtl_jns_lantai     = $this->input->post('dtl_jns_lantai');
        $dtl_jns_langit     = $this->input->post('dtl_jns_langit');
        $jpb02_kls_bng      = $this->input->post('jpb02_kls_bng');
        $jpb03_tinggi       = $this->input->post('jpb03_tinggi');
        $jpb03_daya         = $this->input->post('jpb03_daya');
        $jpb03_lebar        = $this->input->post('jpb03_lebar');
        $jpb03_keliling     = $this->input->post('jpb03_keliling');
        $jpb03_luas         = $this->input->post('jpb03_luas');
        $jpb03_konstruksi   = $this->input->post('jpb03_konstruksi');
        $jpb04_kls_bng      = $this->input->post('jpb04_kls_bng');
        $jpb05_kls_bng      = $this->input->post('jpb05_kls_bng');
        $jpb05_ruang_ac     = $this->input->post('jpb05_ruang_ac');
        $jpb05_ruang_lain   = $this->input->post('jpb05_ruang_lain');
        $jpb06_kls_bng      = $this->input->post('jpb06_kls_bng');
        $jpb07_jns_hotel    = $this->input->post('jpb07_jns_hotel');
        $jpb07_bintang      = $this->input->post('jpb07_bintang');
        $jpb07_jml_kamar    = $this->input->post('jpb07_jml_kamar');
        $jpb07_ruang_ac     = $this->input->post('jpb07_ruang_ac');
        $jpb07_ruang_lain   = $this->input->post('jpb07_ruang_lain');
        $jpb08_tinggi       = $this->input->post('jpb08_tinggi');
        $jpb08_daya         = $this->input->post('jpb08_daya');
        $jpb08_lebar        = $this->input->post('jpb08_lebar');
        $jpb08_keliling     = $this->input->post('jpb08_keliling');
        $jpb08_luas         = $this->input->post('jpb08_luas');
        $jpb08_konstruksi   = $this->input->post('jpb08_konstruksi');
        $jpb09_kls_bng      = $this->input->post('jpb09_kls_bng');
        $jpb12_kls_bng      = $this->input->post('jpb12_kls_bng');
        $jpb13_kls_bng      = $this->input->post('jpb13_kls_bng');
        $jpb13_jml_apart    = $this->input->post('jpb13_jml_apart');
        $jpb13_ruang_ac     = $this->input->post('jpb13_ruang_ac');
        $jpb13_ruang_lain   = $this->input->post('jpb13_ruang_lain');
        $jpb14_luas         = $this->input->post('jpb14_luas');
        $jpb15_letak_tangki = $this->input->post('jpb15_letak_tangki');
        $jpb15_kapasitas    = $this->input->post('jpb15_kapasitas');
        $jpb16_kls_bng      = $this->input->post('jpb16_kls_bng');

        $prop_kd = substr($paramm, 0, 2);
        $kab_kd  = substr($paramm, 2, 2);
        $kec_kd  = substr($paramm, 4, 3);
        $kel_kd  = substr($paramm, 7, 3);
        $blok_kd = substr($paramm, 10, 3);
        $urut_no = substr($paramm, 13, 4);
        $jns_kd  = substr($paramm, 17, 1);
        $thn_ply = substr($paramm, 18, 4);
        $kd_ply  = substr($paramm, 22, 2);
        $no_bng = '';
        $id_op_bng = '';

        if ($p_id && $get = $this->permohonan_online_upt_model->get_ppo_by_id($p_id)) {

            $sql = " BEGIN ";

            if ($dtl_model == 'add') { //// simpan baru
                // get id dob
                $dt_dob_new = $this->permohonan_online_upt_model->get_bng_new_mutasi_sebagian($p_id, $urut_mutasi);
                $next_id_op_bangunan    = $dt_dob_new->NEXT_ID_BNG;
                $next_no_bangunan       = $dt_dob_new->NEXT_NO_BNG;
                $no_bng                 = $next_no_bangunan;
                $id_op_bng              = $next_id_op_bangunan;
                //// id dop ambil dari id baru
                $id_dop                 = $next_id_op_bangunan;
                // insert data MUT_DAT_OP_BANGUNAN_OL
                $qry_insert = " 
                    INSERT INTO MUT_DAT_OP_BANGUNAN_OL(KD_PROPINSI, KD_DATI2, NO_BNG, 
                    KD_JPB, THN_DIBANGUN_BNG, THN_RENOVASI_BNG, LUAS_BNG, JML_LANTAI_BNG, 
                    KONDISI_BNG, JNS_KONSTRUKSI_BNG, JNS_ATAP_BNG, KD_DINDING, KD_LANTAI, KD_LANGIT_LANGIT, 
                    ID, DOCH_ID, NO_URUT_MUTASI)
                    VALUES ('{$prop_kd}', '{$kab_kd}', {$next_no_bangunan}, 
                    '{$dtl_guna_bng}', '{$dtl_thn_bng}', '{$dtl_thn_renov}', {$dtl_luas_bng}, {$dtl_jml_lantai}, 
                    '{$dtl_kondisi_bng}', '{$dtl_jns_konstr}', '{$dtl_jns_atap}', '{$dtl_jns_dinding}', '{$dtl_jns_lantai}', '{$dtl_jns_langit}', 
                    {$next_id_op_bangunan}, {$p_id}, {$urut_mutasi}) ";
                $this->db->simple_qry_eon_ora($qry_insert);
    
            } else if ($dtl_model == 'edit') { //// update 
                $dt_o      = $this->permohonan_online_upt_model->get_dtl_bng_mutasi_sebagian($id_dop);
                $no_bng    = $dt_o->NO_BNG;
                $id_op_bng = $dtl_id;
                // update data MUT_DAT_OP_BANGUNAN_OL
                $sql .= " 
                    begin 
                    UPDATE MUT_DAT_OP_BANGUNAN_OL SET  
                    KD_JPB = '{$dtl_guna_bng}', THN_DIBANGUN_BNG = '{$dtl_thn_bng}', THN_RENOVASI_BNG = '{$dtl_thn_renov}', 
                    LUAS_BNG = {$dtl_luas_bng}, JML_LANTAI_BNG = {$dtl_jml_lantai}, 
                    KONDISI_BNG = '{$dtl_kondisi_bng}', JNS_KONSTRUKSI_BNG = '{$dtl_jns_konstr}', JNS_ATAP_BNG = '{$dtl_jns_atap}', 
                    KD_DINDING = '{$dtl_jns_dinding}', KD_LANTAI = '{$dtl_jns_lantai}', KD_LANGIT_LANGIT = '{$dtl_jns_langit}' 
                    WHERE ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                    end; ";
                //// hapus dulu data jpb jpb yang sudah ada by id header (id MUT_DAT_OP_BANGUNAN_OL)
                $sql .= "   
                    begin 
                    DELETE FROM MUT_DAT_JPB2_OL WHERE DOCD_ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; 
                    begin 
                    DELETE FROM MUT_DAT_JPB3_OL WHERE DOCD_ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; 
                    begin 
                    DELETE FROM MUT_DAT_JPB4_OL WHERE DOCD_ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; 
                    begin 
                    DELETE FROM MUT_DAT_JPB5_OL WHERE DOCD_ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; 
                    begin 
                    DELETE FROM MUT_DAT_JPB6_OL WHERE DOCD_ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; 
                    begin 
                    DELETE FROM MUT_DAT_JPB7_OL WHERE DOCD_ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; 
                    begin 
                    DELETE FROM MUT_DAT_JPB8_OL WHERE DOCD_ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; 
                    begin 
                    DELETE FROM MUT_DAT_JPB9_OL WHERE DOCD_ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; 
                    begin 
                    DELETE FROM MUT_DAT_JPB12_OL WHERE DOCD_ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; 
                    begin 
                    DELETE FROM MUT_DAT_JPB13_OL WHERE DOCD_ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; 
                    begin 
                    DELETE FROM MUT_DAT_JPB14_OL WHERE DOCD_ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; 
                    begin 
                    DELETE FROM MUT_DAT_JPB15_OL WHERE DOCD_ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; 
                    begin 
                    DELETE FROM MUT_DAT_JPB16_OL WHERE DOCD_ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; ";
    
            }

            $dt_o2  = $this->permohonan_online_upt_model->get_dtl_bng_mutasi_sebagian($id_dop);
            $kec_kd  = $dt_o2->KD_KECAMATAN;
            $kel_kd  = $dt_o2->KD_KELURAHAN;
            $blok_kd = $dt_o2->KD_BLOK;
            $urut_no = $dt_o2->NO_URUT;
            $jns_kd  = $dt_o2->KD_JNS_OP;


            //// INSERT KE JPB SESUAI PENGGUNAAN BANGUNAN (KD_JPB)
            if ($dtl_guna_bng == '02') {
                $sql .= " 
                    begin 
                    INSERT INTO MUT_DAT_JPB2_OL(KLS_JPB2, DOCD_ID, KD_PROPINSI, KD_DATI2, KD_KECAMATAN, 
                    KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP, NO_BNG)
                    VALUES ('{$jpb02_kls_bng}', {$id_op_bng}, '{$prop_kd}', '{$kab_kd}', '{$kec_kd}', 
                    '{$kel_kd}', '{$blok_kd}', '{$urut_no}', '{$jns_kd}', {$no_bng}
                    )
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                    end; ";
            } else if ($dtl_guna_bng == '03') {
                $sql .= " 
                    begin 
                    INSERT INTO MUT_DAT_JPB3_OL(KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, 
                    KD_JNS_OP, NO_BNG, TYPE_KONSTRUKSI, TING_KOLOM_JPB3, LBR_BENT_JPB3, LUAS_MEZZANINE_JPB3, 
                    KELILING_DINDING_JPB3, DAYA_DUKUNG_LANTAI_JPB3, DOCD_ID)
                    VALUES ('{$prop_kd}', '{$kab_kd}', '{$kec_kd}', '{$kel_kd}', '{$blok_kd}', '{$urut_no}', 
                    '{$jns_kd}', {$no_bng}, '{$jpb03_konstruksi}', {$jpb03_tinggi}, {$jpb03_lebar}, {$jpb03_luas},
                    {$jpb03_keliling}, {$jpb03_daya}, {$id_op_bng}
                    )
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                    end; ";
            } else if ($dtl_guna_bng == '04') {
                $sql .= " 
                    begin 
                    INSERT INTO MUT_DAT_JPB4_OL(KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, 
                    KD_JNS_OP, NO_BNG, KLS_JPB4, DOCD_ID)
                    VALUES ('{$prop_kd}', '{$kab_kd}', '{$kec_kd}', '{$kel_kd}', '{$blok_kd}', '{$urut_no}', 
                    '{$jns_kd}', {$no_bng}, '{$jpb04_kls_bng}', {$id_op_bng}
                    )
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                    end; ";
            } else if ($dtl_guna_bng == '05') {
                $sql .= " 
                    begin 
                    INSERT INTO MUT_DAT_JPB5_OL(KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, 
                    KD_JNS_OP, NO_BNG, KLS_JPB5, LUAS_KMR_JPB5_DGN_AC_SENT, LUAS_RNG_LAIN_JPB5_DGN_AC_SENT, DOCD_ID)
                    VALUES ('{$prop_kd}', '{$kab_kd}', '{$kec_kd}', '{$kel_kd}', '{$blok_kd}', '{$urut_no}', 
                    '{$jns_kd}', {$no_bng}, '{$jpb05_kls_bng}', {$jpb05_ruang_ac}, {$jpb05_ruang_lain}, {$id_op_bng}
                    )
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                    end; ";
            } else if ($dtl_guna_bng == '06') {
                $sql .= " 
                    begin 
                    INSERT INTO MUT_DAT_JPB6_OL(KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, 
                    KD_JNS_OP, NO_BNG, KLS_JPB6, DOCD_ID)
                    VALUES ('{$prop_kd}', '{$kab_kd}', '{$kec_kd}', '{$kel_kd}', '{$blok_kd}', '{$urut_no}', 
                    '{$jns_kd}', {$no_bng}, '{$jpb06_kls_bng}', {$id_op_bng}
                    )
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                    end; ";
            } else if ($dtl_guna_bng == '07') {
                $sql .= " 
                    begin 
                    INSERT INTO MUT_DAT_JPB7_OL(KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, 
                    KD_JNS_OP, NO_BNG, JNS_JPB7, BINTANG_JPB7, JML_KMR_JPB7, 
                    LUAS_KMR_JPB7_DGN_AC_SENT, LUAS_KMR_LAIN_JPB7_DGN_AC_SENT, DOCD_ID)
                    VALUES ('{$prop_kd}', '{$kab_kd}', '{$kec_kd}', '{$kel_kd}', '{$blok_kd}', '{$urut_no}', 
                    '{$jns_kd}', {$no_bng}, '{$jpb07_jns_hotel}', '{$jpb07_bintang}', {$jpb07_jml_kamar}, 
                    {$jpb07_ruang_ac}, {$jpb07_ruang_lain}, {$id_op_bng}
                    )
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                    end; ";
            } else if ($dtl_guna_bng == '08') {
                $sql .= " 
                    begin 
                    INSERT INTO MUT_DAT_JPB8_OL(KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, 
                    KD_JNS_OP, NO_BNG, TYPE_KONSTRUKSI, TING_KOLOM_JPB8, LBR_BENT_JPB8, LUAS_MEZZANINE_JPB8, 
                    KELILING_DINDING_JPB8, DAYA_DUKUNG_LANTAI_JPB8, DOCD_ID)
                    VALUES ('{$prop_kd}', '{$kab_kd}', '{$kec_kd}', '{$kel_kd}', '{$blok_kd}', '{$urut_no}', 
                    '{$jns_kd}', {$no_bng}, '{$jpb08_konstruksi}', {$jpb08_tinggi}, {$jpb08_lebar}, {$jpb08_luas}, 
                    {$jpb08_keliling}, {$jpb08_daya}, {$id_op_bng}
                    )
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                    end; ";
            } else if ($dtl_guna_bng == '09') {
                $sql .= " 
                    begin 
                    INSERT INTO MUT_DAT_JPB9_OL(KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, 
                    KD_JNS_OP, NO_BNG, KLS_JPB9, DOCD_ID)
                    VALUES ('{$prop_kd}', '{$kab_kd}', '{$kec_kd}', '{$kel_kd}', '{$blok_kd}', '{$urut_no}', 
                    '{$jns_kd}', {$no_bng}, '{$jpb09_kls_bng}', {$id_op_bng}
                    )
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                    end; ";
            } else if ($dtl_guna_bng == '12') {
                $sql .= " 
                    begin 
                    INSERT INTO MUT_DAT_JPB12_OL(KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, 
                    KD_JNS_OP, NO_BNG, TYPE_JPB12, DOCD_ID)
                    VALUES ('{$prop_kd}', '{$kab_kd}', '{$kec_kd}', '{$kel_kd}', '{$blok_kd}', '{$urut_no}', 
                    '{$jns_kd}', {$no_bng}, '{$jpb12_kls_bng}', {$id_op_bng}
                    )
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                    end; ";
            } else if ($dtl_guna_bng == '13') {
                $sql .= " 
                    begin 
                    INSERT INTO MUT_DAT_JPB13_OL(KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, 
                    KD_JNS_OP, NO_BNG, KLS_JPB13, JML_JPB13, 
                    LUAS_JPB13_DGN_AC_SENT, LUAS_JPB13_LAIN_DGN_AC_SENT, DOCD_ID)
                    VALUES ('{$prop_kd}', '{$kab_kd}', '{$kec_kd}', '{$kel_kd}', '{$blok_kd}', '{$urut_no}', 
                    '{$jns_kd}', {$no_bng}, '{$jpb13_kls_bng}', {$jpb13_jml_apart},  
                    {$jpb13_ruang_ac}, {$jpb13_ruang_lain}, {$id_op_bng}
                    )
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                    end; ";
            } else if ($dtl_guna_bng == '14') {
                $sql .= " 
                    begin 
                    INSERT INTO MUT_DAT_JPB14_OL(KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, 
                    KD_JNS_OP, NO_BNG, LUAS_KANOPI_JPB14, DOCD_ID)
                    VALUES ('{$prop_kd}', '{$kab_kd}', '{$kec_kd}', '{$kel_kd}', '{$blok_kd}', '{$urut_no}', 
                    '{$jns_kd}', {$no_bng}, {$jpb14_luas}, {$id_op_bng}
                    )
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                    end; ";
            } else if ($dtl_guna_bng == '15') {
                $sql .= " 
                    begin 
                    INSERT INTO MUT_DAT_JPB15_OL(KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, 
                    KD_JNS_OP, NO_BNG, LETAK_TANGKI_JPB15, KAPASITAS_TANGKI_JPB15, DOCD_ID)
                    VALUES ('{$prop_kd}', '{$kab_kd}', '{$kec_kd}', '{$kel_kd}', '{$blok_kd}', '{$urut_no}', 
                    '{$jns_kd}', {$no_bng}, '{$jpb15_letak_tangki}', {$jpb15_kapasitas}, {$id_op_bng}
                    )
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                    end; ";
            } else if ($dtl_guna_bng == '16') {
                $sql .= " 
                    begin 
                    INSERT INTO MUT_DAT_JPB16_OL(KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, 
                    KD_JNS_OP, NO_BNG, KLS_JPB16, DOCD_ID)
                    VALUES ('{$prop_kd}', '{$kab_kd}', '{$kec_kd}', '{$kel_kd}', '{$blok_kd}', '{$urut_no}', 
                    '{$jns_kd}', {$no_bng}, '{$jpb16_kls_bng}', {$id_op_bng}
                    )
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                    end; ";
            } 

            $sql .= " COMMIT;
                      END; ";
            //
            // log_message('info', " XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX data_simpan_dtl PEMBETULAN ONLINE: " . $sql);
            $error_msg = $this->db->simple_qry_eon_ora($sql);
            $err_Msg = $error_msg['message'];
            if (!empty($err_Msg)) {
                $error_CRUD = $err_Msg . ', Proses gagal....!!!';
                echo $error_CRUD;
            } else {
                echo 'Simpan Data Bangunan Berhasil';
            }

        } else {
            echo 'ERROR.. Data tidak ditemukan... silakan muat ulang halaman';
        }

    }

    function save_dtl_fasilitas_bangunan_mutsbg() {
        $p_id               = $this->input->post('id_ppo');
        $paramm             = $this->input->post('paramm');
        $id_dobng           = $this->input->post('id_head');
        $dtl_kd_fas         = $this->input->post('dtlfas_kd_fas');
        $dtl_satuan         = $this->input->post('dtlfas_satuan');

        $prop_kd = substr($paramm, 0, 2);
        $kab_kd  = substr($paramm, 2, 2);
        $kec_kd  = substr($paramm, 4, 3);
        $kel_kd  = substr($paramm, 7, 3);
        $blok_kd = substr($paramm, 10, 3);
        $urut_no = substr($paramm, 13, 4);
        $jns_kd  = substr($paramm, 17, 1);
        $thn_ply = substr($paramm, 18, 4);
        $kd_ply  = substr($paramm, 22, 2);

        if ($p_id && $get = $this->permohonan_online_upt_model->get_ppo_by_id($p_id)) {
            $dt_o      = $this->permohonan_online_upt_model->get_dtl_bng_mutasi_sebagian($id_dobng);
            $no_bng    = $dt_o->NO_BNG;
            $sql = " BEGIN ";

            // insert data DAT_FASILITAS_BANGUNAN_ONLINE
            $sql .= " 
                begin 
                INSERT INTO MUT_DAT_FASILITAS_BANGUNAN_OL(KD_PROPINSI, KD_DATI2, NO_BNG, KD_FASILITAS, JML_SATUAN, DOCD_ID)
                VALUES ('{$prop_kd}', '{$kab_kd}', {$no_bng}, '{$dtl_kd_fas}', {$dtl_satuan}, {$id_dobng})
                ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                end; ";

            $sql .= " COMMIT;
                      END; ";
            //
            // log_message('info', " XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX data_simpan_dtl PEMBETULAN ONLINE: " . $sql);
            $error_msg = $this->db->simple_qry_eon_ora($sql);
            $err_Msg = $error_msg['message'];
            if (!empty($err_Msg)) {
                $error_CRUD = $err_Msg . ', Proses gagal....!!!';
                echo $error_CRUD;
            } else {
                echo 'Simpan Data Fasilitas Bangunan Berhasil';
            }

        } else {
            echo 'ERROR.. Data tidak ditemukan... silakan muat ulang halaman';
        }

    }

    //// END MUTASI SEBAGIAN


    //// SPOP LSPOP
    function grid_dtl_bng_sismiop() {
        $nop        = $this->uri->segment(4);
        $nop     = str_replace(".", "", $nop);
        $nop     = str_replace("-", "", $nop);
        $kd_prop = substr($nop, 0, 2);
        $kd_dati = substr($nop, 2, 2);
        $kd_kec  = substr($nop, 4, 3);
        $kd_kel  = substr($nop, 7, 3);
        $kd_blok = substr($nop, 10, 3);
        $no_urut = substr($nop, 13, 4);
        $kd_jns_op = substr($nop, 17, 1);

        $this->load->library('Datatables');
        $this->datatables->select("KD_PROPINSI||KD_DATI2||KD_KECAMATAN||KD_KELURAHAN||KD_BLOK||NO_URUT||KD_JNS_OP||NO_BNG as ID, 
                                'edit' as MODEL, DOB.NO_BNG, RJ.NM_JPB, DOB.LUAS_BNG, DOB.KD_JPB, 
                                '' as edit, '' as hapus, '' as fas", false);
        $this->datatables->from('DAT_OP_BANGUNAN DOB');
        $this->datatables->join('REF_JPB RJ', 'RJ.KD_JPB = DOB.KD_JPB');
        $this->datatables->where('DOB.KD_PROPINSI', $kd_prop);
        $this->datatables->where('DOB.KD_DATI2', $kd_dati);
        $this->datatables->where('DOB.KD_KECAMATAN', $kd_kec);
        $this->datatables->where('DOB.KD_KELURAHAN', $kd_kel);
        $this->datatables->where('DOB.KD_BLOK', $kd_blok);
        $this->datatables->where('DOB.NO_URUT', $no_urut);
        $this->datatables->where('DOB.KD_JNS_OP', $kd_jns_op);

        echo $this->datatables->generate();
    }

    function grid_dtl_fas_sismiop() {
        $id_head = $this->uri->segment(4);
        $id_head     = str_replace(".", "", $id_head);
        $id_head     = str_replace("-", "", $id_head);
        $kd_prop = substr($id_head, 0, 2);
        $kd_dati = substr($id_head, 2, 2);
        $kd_kec  = substr($id_head, 4, 3);
        $kd_kel  = substr($id_head, 7, 3);
        $kd_blok = substr($id_head, 10, 3);
        $no_urut = substr($id_head, 13, 4);
        $kd_jns_op = substr($id_head, 17, 1);
        $no_bng = substr($id_head, 18, 1);

        $this->load->library('Datatables');
        $this->datatables->select("FAS.KD_FASILITAS AS ID, 'edit' as MODEL, RF.NM_FASILITAS, FAS.JML_SATUAN, FAS.KD_FASILITAS", false);
        $this->datatables->from('DAT_FASILITAS_BANGUNAN FAS');
        $this->datatables->join('FASILITAS RF', 'RF.KD_FASILITAS = FAS.KD_FASILITAS');
        $this->datatables->where('FAS.KD_PROPINSI', $kd_prop);
        $this->datatables->where('FAS.KD_DATI2', $kd_dati);
        $this->datatables->where('FAS.KD_KECAMATAN', $kd_kec);
        $this->datatables->where('FAS.KD_KELURAHAN', $kd_kel);
        $this->datatables->where('FAS.KD_BLOK', $kd_blok);
        $this->datatables->where('FAS.NO_URUT', $no_urut);
        $this->datatables->where('FAS.KD_JNS_OP', $kd_jns_op);
        $this->datatables->where('FAS.NO_BNG', $no_bng);

        echo $this->datatables->generate();
    }

    function get_dtl_bng_sismiop() {
        $id_dtl = $this->uri->segment(4);
        $data = $this->permohonan_online_upt_model->get_dtl_bng_sismiop($id_dtl);
        echo json_encode($data);
    }


    //// END SPOP LSPOP



}
