<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class monitoring_pelayanan extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!is_login()) {
            echo "<script>window.location.replace('" . base_url() . "');</script>";
            exit;
        }

        $module = 'monitoring_pelayanan';
        $this->load->library('module_auth', array(
            'module' => $module
        ));

        $this->load->model(array(
            'apps_model', 'monitoring_pelayanan_model'
        ));

        $this->load->helper(active_module());
    }

    public function index() {
        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect('eadm_bogor');
        }

        $data['page_menu'] = 'monitoring_pelayanan';
        $data['current'] = '';
        $data['apps']    = $this->apps_model->get_active_only();
        $option = array( ''=> 'Semua Status','A' => 'Draft',
            '1' => 'Terima',
            '2' => 'Tolak');
        $js  = 'id="status_kd" style="width:130px;" class="form-control" ';
        $select = form_dropdown('status_kd', $option, '' , $js);
        $data['select_jns_ply'] = $select;


        $this->load->view('vmonitoring_pelayanan', $data);
    }

    public function grid() {

        $status_kd = $this->input->get('status_kd');
        $this->load->library('Datatables');
        $this->datatables->select("	P.THN_PELAYANAN||'-'||P.BUNDEL_PELAYANAN||'-'||P.NO_URUT_PELAYANAN as NOPEL,
                                    P.KD_PROPINSI_PEMOHON||P.KD_DATI2_PEMOHON||P.KD_KECAMATAN_PEMOHON||P.KD_KELURAHAN_PEMOHON||P.KD_BLOK_PEMOHON||P.NO_URUT_PEMOHON||P.KD_JNS_OP_PEMOHON AS NOP, 
                                    RP.NM_JENIS_PELAYANAN, P.NAMA_PEMOHON, KEC.NM_KECAMATAN, KEL.NM_KELURAHAN,
                                    CASE WHEN P.STATUS_PERMOHONAN = '0' THEN 'Draft' 
                                    WHEN P.STATUS_PERMOHONAN = '1' THEN 'Kirim WP'
                                    WHEN P.STATUS_PERMOHONAN = '2' THEN 'Proses'
                                    WHEN P.STATUS_PERMOHONAN = '3' THEN 'Tolak Pemda'
                                    WHEN P.STATUS_PERMOHONAN = '4' THEN 'Diterima Pemda' END AS STS,
                                    P.THN_PELAYANAN||P.KD_PROPINSI_PEMOHON||P.KD_DATI2_PEMOHON||P.KD_KECAMATAN_PEMOHON||P.KD_KELURAHAN_PEMOHON||P.KD_BLOK_PEMOHON||P.NO_URUT_PEMOHON||P.KD_JNS_OP_PEMOHON||P.KD_JNS_PELAYANAN as ID,
                                    P.STATUS_PERMOHONAN", false);
        $this->datatables->from("PST_PERMOHONAN_ONLINE P");
        $this->datatables->join('REF_JNS_PELAYANAN RP', 'RP.KD_JNS_PELAYANAN = P.KD_JNS_PELAYANAN', 'left');
        $this->datatables->join('REF_KECAMATAN KEC', 'KEC.KD_KECAMATAN = P.KD_KECAMATAN_PEMOHON');
        $this->datatables->join('REF_KELURAHAN KEL', 'KEL.KD_KECAMATAN = P.KD_KECAMATAN_PEMOHON AND KEL.KD_KELURAHAN = P.KD_KELURAHAN_PEMOHON');

        // $this->datatables->rupiah_column('5,6,7,8,9');
        // $this->datatables->date_column('4');
        
        echo $this->datatables->generate();
    }

    private function fvalidation() {
        $this->form_validation->set_error_delimiters('<span>', '</span>');
        $this->form_validation->set_rules('nop', 'NOP', 'required|trim|callback_cek_nop');
        $this->form_validation->set_rules('thn_permohonan', 'Tahun Permohonan', 'required|trim');
    }

    // public function cek_nop($value) {
    //     $nop = $this->input->post('nop');

    //     if ($this->monitoring_pelayanan_model->cek_nop($nop)) {
    //         return true;
    //     } else {
    //         $this->form_validation->set_message('cek_nop', 'NOP tidak terdaftar di DAT OBJEK PAJAK.....!');
    //         return false;
    //     }
    // }

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
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect('tool_pbb');
        }

        $param     = $this->uri->segment(4);
        // echo $param; die;

        $data['page_menu'] = 'monitoring_pelayanan';
        $data['current'] = '';
        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = active_module_url("monitoring_pelayanan/update/{$param}");
        
        $dt = $this->monitoring_pelayanan_model->get($param);

        if ($dt){
    
            $data['dt'] = array(
                'nop_re' => $dt->NOP_LKP, 
                'id_reg_esppt' => $dt->NOPNIK, 
                'nama_wp_re' => $dt->NAMA_WP_REG, 
                'alamat_op_re' => $dt->ALAMAT_REG, 
                'nik_re' => $dt->NIK_REG, 
                'no_telp_re' => $dt->TELP_REG,
                'nama_re' => $dt->NAMA_REG, 
                'email_re' => $dt->EMAIL_REG,

                'id_ppo' => $dt->PO_ID, 
                'nopel' => $dt->NOPEL, 
                'no_permohonan' => $dt->NO_SRT_PERMOHONAN, 
                'thn_permohonan' => $dt->THN_PAJAK_PERMOHONAN, 
                'nop' => $dt->NOP_LKP, 
                'tgl_permohonan' => get_date($dt->TGL_SURAT_PERMOHONAN), 
                'nama_pemohon' => $dt->NAMA_PEMOHON, 
                'alamat_pemohon' => $dt->ALAMAT_PEMOHON, 
                'telp' => $dt->NO_HP, 
                'keterangan' => $dt->KETERANGAN_PST, 
            );

            $data['da'] = (array)$dt;

            $data['fnopnik'] = $dt->NOPNIK;

            $select_data  = $this->monitoring_pelayanan_model->get_jns_ply();
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

            $this->load->view('vmonitoring_pelayanan_form', $data);

        } else {
            $this->session->set_flashdata('msg_danger', 'Data tidak ditemukan..');
            redirect(active_module_url('monitoring_pelayanan'));
        }

    }

    public function edit() {
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_danger', $this->module_auth->msg_read);
            redirect('tool_pbb');
        }

        $param     = $this->uri->segment(4);
        // echo $param; die;

        $data['page_menu'] = 'monitoring_pelayanan';
        $data['current'] = '';
        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = active_module_url("monitoring_pelayanan/update/{$param}");
        
        $dt = $this->monitoring_pelayanan_model->get($param);

        if ($dt){
    
            $data['dt'] = array(
                'nop_re' => $dt->NOP_LKP, 
                'id_reg_esppt' => $dt->NOPNIK, 
                'nama_wp_re' => $dt->NAMA_WP_REG, 
                'alamat_op_re' => $dt->ALAMAT_REG, 
                'nik_re' => $dt->NIK_REG, 
                'no_telp_re' => $dt->TELP_REG,
                'nama_re' => $dt->NAMA_REG, 
                'email_re' => $dt->EMAIL_REG,

                'id_ppo' => $dt->PO_ID, 
                'nopel' => $dt->NOPEL, 
                'no_permohonan' => $dt->NO_SRT_PERMOHONAN, 
                'thn_permohonan' => $dt->THN_PAJAK_PERMOHONAN, 
                'nop' => $dt->NOP_LKP, 
                'tgl_permohonan' => get_date($dt->TGL_SURAT_PERMOHONAN), 
                'nama_pemohon' => $dt->NAMA_PEMOHON, 
                'alamat_pemohon' => $dt->ALAMAT_PEMOHON, 
                'telp' => $dt->NO_HP, 
                'keterangan' => $dt->KETERANGAN_PST, 
            );

            $data['da'] = (array)$dt;

            $data['fnopnik'] = $dt->NOPNIK;

            $select_data  = $this->monitoring_pelayanan_model->get_jns_ply();
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

            $this->load->view('vmonitoring_pelayanan_form', $data);

        } else {
            $this->session->set_flashdata('msg_danger', 'Data tidak ditemukan..');
            redirect(active_module_url('monitoring_pelayanan'));
        }

    }

    public function update() {
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
            redirect(active_module_url('monitoring_pelayanan'));
        }

        $param     = $this->uri->segment(4);
        $post_data = $this->fpost();
        // echo $post_data['nop']; die();

        $data['page_menu'] = 'monitoring_pelayanan';
        $data['current'] = '';
        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = active_module_url("monitoring_pelayanan/update/{$param}");

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

            $nopel      = $post_data['nopel'];
            $nopel      = str_replace(".", "", $nopel);
            $nopel      = str_replace("-", "", $nopel);
            $thn_ply    = substr($nopel, 0, 4);
            $bundel_ply = substr($nopel, 4, 4);
            $urut_ply   = substr($nopel, 8, 3);

            $kd_jns_ply = $post_data['jns_ply'];

            $nip_pencetak = sipkd_user_nip();

            $tgl_permohonan = date('Y-m-d', strtotime($post_data['tgl_permohonan']));

            $dt_upd_prm_onl = array(
                "NAMA_PEMOHON" => $post_data['nama_pemohon'],
                "ALAMAT_PEMOHON" => $post_data['alamat_pemohon'],
                "NO_HP" => $post_data['telp'],
                "KETERANGAN_PST" => $post_data['keterangan'],
                "THN_PAJAK_PERMOHONAN" => $post_data['thn_permohonan'],
                // "TGL_SURAT_PERMOHONAN" => $post_data['tgl_permohonan'],
                "TGL_SURAT_PERMOHONAN" => $tgl_permohonan
            );

            $this->db->where("THN_PELAYANAN||BUNDEL_PELAYANAN||NO_URUT_PELAYANAN", "'{$nopel}'", false);
            $this->db->update('PST_PERMOHONAN_ONLINE', $dt_upd_prm_onl);
            
            $nopthnkd = $nop . $thn_ply . $kd_jns_ply;

            
            if (!empty($_FILES['im_spop']['name']) || !empty($_FILES['im_lspop']['name']) || !empty($_FILES['im_valbphtb']['name']) || 
                !empty($_FILES['im_pengantar_desa']['name']) || !empty($_FILES['im_nonsengketa']['name']) || !empty($_FILES['im_riwyt_tanah']['name']) || 
                !empty($_FILES['im_stts']['name']) || !empty($_FILES['im_ktp']['name']) || !empty($_FILES['im_sertanah']['name']) || 
                !empty($_FILES['im_imb']['name']) || !empty($_FILES['im_foto_op']['name']) || !empty($_FILES['im_sppt']['name']) || 
                !empty($_FILES['im_sk_pengurangan']['name']) || !empty($_FILES['im_other']['name'])) {
                
                    $this->update_prm_blob($nopthnkd);
            }
            ////

            $this->session->set_flashdata('msg_success', 'Data telah disimpan');
            redirect(active_module_url('monitoring_pelayanan'));
            
        }

        $get = (object)$post_data;
        $data['dt'] = $post_data;

        $select_data  = $this->monitoring_pelayanan_model->get_jns_ply();
        if ($select_data) {
            foreach ($select_data as $row) {
                $options[$row->KD_JNS_PELAYANAN] = $row->NM_JENIS_PELAYANAN;
            }
        } else {
            $options['0'] = 'Data not found';
        }
        $js     = 'class="form-control" id="jns_ply" readonly ';
        $select = form_dropdown('jns_ply', $options, $post_data['jns_ply'], $js);
        $select = preg_replace("/[\r\n]+/", "", $select);
        $data['select_jns_ply'] = $select;

        $this->load->view('vsimulasi_sppt', $data);
    }


    function update_prm_blob($param) {
        $im_spop = '';
        $im_lspop = '';
        $im_ktp = '';
        $im_sertanah = '';
        $im_imb = '';
        $im_foto_op = '';
        $im_valbphtb = '';
        $im_pengantar_desa = '';
        $im_nonsengketa = '';
        $im_riwyt_tanah = '';
        $im_sppt = '';
        $im_stts = '';
        $im_sk_pengurangan = '';
        $im_other = '';
        $fl_blob = array();
        $tbl_field = array();
        $tbl_field_return = array();
        $return_blob = array();
        if (!empty($_FILES['im_spop']['name'])) {
            array_push($tbl_field, 'L_SKKP_PBB1=EMPTY_BLOB()');
            array_push($fl_blob, 'L_SKKP_PBB=1');
            array_push($tbl_field_return, 'L_SKKP_PBB1');
            array_push($return_blob, ':blob1');
            $im_spop = file_get_contents($_FILES['im_spop']['tmp_name']);
        }
        if (!empty($_FILES['im_lspop']['name'])) {
            array_push($tbl_field, 'L_SPMKP_PBB1=EMPTY_BLOB()');
            array_push($fl_blob, 'L_SPMKP_PBB=1');
            array_push($tbl_field_return, 'L_SPMKP_PBB1');
            array_push($return_blob, ':blob2');
            $im_lspop = file_get_contents($_FILES['im_lspop']['tmp_name']);
        }
        if (!empty($_FILES['im_valbphtb']['name'])) {
            array_push($tbl_field, 'L_SURAT_KUASA1=EMPTY_BLOB()');
            array_push($tbl_field_return, 'L_SURAT_KUASA1');
            array_push($fl_blob, 'L_SURAT_KUASA=1');
            array_push($return_blob, ':blob3');
            $im_valbphtb = file_get_contents($_FILES['im_valbphtb']['tmp_name']);
        }
        if (!empty($_FILES['im_pengantar_desa']['name'])) {
            array_push($tbl_field, 'L_PERMOHONAN1=EMPTY_BLOB()');
            array_push($tbl_field_return, 'L_PERMOHONAN1');
            array_push($fl_blob, 'L_PERMOHONAN=1');
            array_push($return_blob, ':blob4');
            $im_pengantar_desa = file_get_contents($_FILES['im_pengantar_desa']['tmp_name']);
        }
        if (!empty($_FILES['im_nonsengketa']['name'])) {
            array_push($tbl_field, 'L_STTS1=EMPTY_BLOB()');
            array_push($tbl_field_return, 'L_STTS1');
            array_push($fl_blob, 'L_STTS=1');
            array_push($return_blob, ':blob5');
            $im_nonsengketa = file_get_contents($_FILES['im_nonsengketa']['tmp_name']);
        }
        if (!empty($_FILES['im_riwyt_tanah']['name'])) {
            array_push($tbl_field, 'L_SK_KEBERATAN1=EMPTY_BLOB()');
            array_push($tbl_field_return, 'L_SK_KEBERATAN1');
            array_push($fl_blob, 'L_SK_KEBERATAN=1');
            array_push($return_blob, ':blob6');
            $im_riwyt_tanah = file_get_contents($_FILES['im_riwyt_tanah']['tmp_name']);
        }
        if (!empty($_FILES['im_stts']['name'])) {
            array_push($tbl_field, 'L_SPPT_STTS1=EMPTY_BLOB()');
            array_push($tbl_field_return, 'L_SPPT_STTS1');
            array_push($fl_blob, 'L_SPPT_STTS=1');
            array_push($return_blob, ':blob7');
            $im_stts = file_get_contents($_FILES['im_stts']['tmp_name']);
        }
        if (!empty($_FILES['im_ktp']['name'])) {
            array_push($tbl_field, 'L_KTP_WP1=EMPTY_BLOB()');
            array_push($tbl_field_return, 'L_KTP_WP1');
            array_push($fl_blob, 'L_KTP_WP=1');
            array_push($return_blob, ':blob8');
            $im_ktp = file_get_contents($_FILES['im_ktp']['tmp_name']);
        }
        if (!empty($_FILES['im_sertanah']['name'])) {
            array_push($tbl_field, 'L_SERTIFIKAT_TANAH1=EMPTY_BLOB()');
            array_push($tbl_field_return, 'L_SERTIFIKAT_TANAH1');
            array_push($fl_blob, 'L_SERTIFIKAT_TANAH=1');
            array_push($return_blob, ':blob9');
            $im_sertanah = file_get_contents($_FILES['im_sertanah']['tmp_name']);
        }
        if (!empty($_FILES['im_imb']['name'])) {
            array_push($tbl_field, 'L_IMB1=EMPTY_BLOB()');
            array_push($tbl_field_return, 'L_IMB1');
            array_push($fl_blob, 'L_IMB=1');
            array_push($return_blob, ':blob10');
            $im_imb = file_get_contents($_FILES['im_imb']['tmp_name']);
        }
        if (!empty($_FILES['im_foto_op']['name'])) {
            array_push($tbl_field, 'L_AKTE_JUAL_BELI1=EMPTY_BLOB()');
            array_push($tbl_field_return, 'L_AKTE_JUAL_BELI1');
            array_push($fl_blob, 'L_AKTE_JUAL_BELI=1');
            array_push($return_blob, ':blob11');
            $im_foto_op = file_get_contents($_FILES['im_foto_op']['tmp_name']);
        }
        if (!empty($_FILES['im_sppt']['name'])) {
            array_push($tbl_field, 'L_SPPT1=EMPTY_BLOB()');
            array_push($tbl_field_return, 'L_SPPT1');
            array_push($fl_blob, 'L_SPPT=1');
            array_push($return_blob, ':blob12');
            $im_sppt = file_get_contents($_FILES['im_sppt']['tmp_name']);
        }
        if (!empty($_FILES['im_sk_pengurangan']['name'])) {
            array_push($tbl_field, 'L_SK_PENGURANGAN1=EMPTY_BLOB()');
            array_push($tbl_field_return, 'L_SK_PENGURANGAN1');
            array_push($fl_blob, 'L_SK_PENGURANGAN=1');
            array_push($return_blob, ':blob13');
            $im_sk_pengurangan = file_get_contents($_FILES['im_sk_pengurangan']['tmp_name']);
        }
        if (!empty($_FILES['im_other']['name'])) {
            array_push($tbl_field, 'L_LAIN_LAIN1=EMPTY_BLOB()');
            array_push($tbl_field_return, 'L_LAIN_LAIN1');
            array_push($fl_blob, 'L_LAIN_LAIN=1');
            array_push($return_blob, ':blob14');
            $im_other = file_get_contents($_FILES['im_other']['tmp_name']);
        }
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
        // $kd_kanwil = KD_KANWIL;
        // $kd_kantor = KD_KANTOR;
        $kd_kanwil = '22';
        $kd_kantor = '13';
        $connection = oci_connect($dbuser, $dbpass, $tnslistener);
        $qq = "UPDATE PST_PERMOHONAN_ONLINE SET {$fl_blob_impl}, {$tbl_field_impl} 
        WHERE KD_PROPINSI_PEMOHON||KD_DATI2_PEMOHON||KD_KECAMATAN_PEMOHON||KD_KELURAHAN_PEMOHON||KD_BLOK_PEMOHON||
        NO_URUT_PEMOHON||KD_JNS_OP_PEMOHON||THN_PELAYANAN||KD_JNS_PELAYANAN='{$param}' 
        RETURNING {$tbl_field_return_impl} INTO {$return_blob_impl}";
        $result = oci_parse($connection, $qq);
        if (!empty($_FILES['im_spop']['name'])) {
            $blob1 = oci_new_descriptor($connection, OCI_D_LOB);
            oci_bind_by_name($result, ":blob1", $blob1, -1, OCI_B_BLOB);
        }
        if (!empty($_FILES['im_lspop']['name'])) {
            $blob2 = oci_new_descriptor($connection, OCI_D_LOB);
            oci_bind_by_name($result, ":blob2", $blob2, -1, OCI_B_BLOB);
        }
        if (!empty($_FILES['im_valbphtb']['name'])) {
            $blob3 = oci_new_descriptor($connection, OCI_D_LOB);
            oci_bind_by_name($result, ":blob3", $blob3, -1, OCI_B_BLOB);
        }
        if (!empty($_FILES['im_pengantar_desa']['name'])) {
            $blob4 = oci_new_descriptor($connection, OCI_D_LOB);
            oci_bind_by_name($result, ":blob4", $blob4, -1, OCI_B_BLOB);
        }
        if (!empty($_FILES['im_nonsengketa']['name'])) {
            $blob5 = oci_new_descriptor($connection, OCI_D_LOB);
            oci_bind_by_name($result, ":blob5", $blob5, -1, OCI_B_BLOB);
        }
        if (!empty($_FILES['im_riwyt_tanah']['name'])) {
            $blob6 = oci_new_descriptor($connection, OCI_D_LOB);
            oci_bind_by_name($result, ":blob6", $blob6, -1, OCI_B_BLOB);
        }
        if (!empty($_FILES['im_stts']['name'])) {
            $blob7 = oci_new_descriptor($connection, OCI_D_LOB);
            oci_bind_by_name($result, ":blob7", $blob7, -1, OCI_B_BLOB);
        }
        if (!empty($_FILES['im_ktp']['name'])) {
            $blob8 = oci_new_descriptor($connection, OCI_D_LOB);
            oci_bind_by_name($result, ":blob8", $blob8, -1, OCI_B_BLOB);
        }
        if (!empty($_FILES['im_sertanah']['name'])) {
            $blob9 = oci_new_descriptor($connection, OCI_D_LOB);
            oci_bind_by_name($result, ":blob9", $blob9, -1, OCI_B_BLOB);
        }
        if (!empty($_FILES['im_imb']['name'])) {
            $blob10 = oci_new_descriptor($connection, OCI_D_LOB);
            oci_bind_by_name($result, ":blob10", $blob10, -1, OCI_B_BLOB);
        }
        if (!empty($_FILES['im_foto_op']['name'])) {
            $blob11 = oci_new_descriptor($connection, OCI_D_LOB);
            oci_bind_by_name($result, ":blob11", $blob11, -1, OCI_B_BLOB);
        }
        if (!empty($_FILES['im_sppt']['name'])) {
            $blob12 = oci_new_descriptor($connection, OCI_D_LOB);
            oci_bind_by_name($result, ":blob12", $blob12, -1, OCI_B_BLOB);
        }
        if (!empty($_FILES['im_sk_pengurangan']['name'])) {
            $blob13 = oci_new_descriptor($connection, OCI_D_LOB);
            oci_bind_by_name($result, ":blob13", $blob13, -1, OCI_B_BLOB);
        }
        if (!empty($_FILES['im_other']['name'])) {
            $blob14 = oci_new_descriptor($connection, OCI_D_LOB);
            oci_bind_by_name($result, ":blob14", $blob14, -1, OCI_B_BLOB);
        }

        $err = '';

        oci_execute($result, OCI_DEFAULT) or die("Unable to execute query; <br>" . $qq . '<br> Keterangan Error: <br>' . $err);
        if (!empty($_FILES['im_spop']['name'])) {
            $blob1->save($im_spop);
        }
        if (!empty($_FILES['im_lspop']['name'])) {
            $blob2->save($im_lspop);
        }
        if (!empty($_FILES['im_valbphtb']['name'])) {
            $blob3->save($im_valbphtb);
        }
        if (!empty($_FILES['im_pengantar_desa']['name'])) {
            $blob4->save($im_pengantar_desa);
        }
        if (!empty($_FILES['im_nonsengketa']['name'])) {
            $blob5->save($im_nonsengketa);
        }
        if (!empty($_FILES['im_riwyt_tanah']['name'])) {
            $blob6->save($im_riwyt_tanah);
        }
        if (!empty($_FILES['im_stts']['name'])) {
            $blob7->save($im_stts);
        }
        if (!empty($_FILES['im_ktp']['name'])) {
            $blob8->save($im_ktp);
        }
        if (!empty($_FILES['im_sertanah']['name'])) {
            $blob9->save($im_sertanah);
        }
        if (!empty($_FILES['im_imb']['name'])) {
            $blob10->save($im_imb);
        }
        if (!empty($_FILES['im_foto_op']['name'])) {
            $blob11->save($im_foto_op);
        }
        if (!empty($_FILES['im_sppt']['name'])) {
            $blob12->save($im_sppt);
        }
        if (!empty($_FILES['im_sk_pengurangan']['name'])) {
            $blob13->save($im_sk_pengurangan);
        }
        if (!empty($_FILES['im_other']['name'])) {
            $blob14->save($im_other);
        }
        oci_commit($connection);
    }


}
