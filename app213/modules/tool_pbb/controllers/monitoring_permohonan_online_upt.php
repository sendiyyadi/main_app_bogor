<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class monitoring_permohonan_online_upt extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!is_login()) {
            echo "<script>window.location.replace('" . base_url() . "');</script>";
            exit;
        }

        $module = 'monitoring_permohonan_online_upt';
        $this->load->library('module_auth', array(
            'module' => $module
        ));

        $this->load->model(array(
            'apps_model', 'permohonan_online_upt_model', 'pembetulan_model'
        ));

        $this->load->helper(active_module());
    }

    public function index() {
        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect('tool_pbb');
        }

        $data['page_menu'] = 'monitoring_permohonan_online_upt';
        $data['current'] = '';
        $data['apps']    = $this->apps_model->get_active_only();

        //------------------------------------------------------------------
        $select_data  = $this->permohonan_online_upt_model->get_ref_sts();
        $options     = array();
        $options = [
            '999' => 'Semua Status'
        ];
        if ($select_data) {
            foreach ($select_data as $row) {
                $options[$row->KD] = $row->KET;
            }
        }
        // $option = array( '999'=> 'Semua Status',
        //                 '1' => 'Kirim WP',
        //                 '4' => 'Berkas dikirim ke Verifikasi',
        //                 '3' => 'Berkas ditolak Loket',
        //                 '5' => 'Berkas selesai ditetapkan',
        //                 'A' => 'Berkas dikirim ke PKP',
        //                 'B' => 'Berkas dikirim ke Penetapan',
        //                 'C' => 'Berkas ditolak Verifikasi',
        //                 'D' => 'Berkas ditolak PKP',
        //             );
        $js  = 'id="status_kd" class="form-control" ';
        $select = form_dropdown('status_kd', $options, '' , $js);
        $data['select_status_kd'] = $select;
        //------------------------------------------------------------------
        $select_data  = $this->permohonan_online_upt_model->get_jns_ply();
        $options     = array();
        $options = [
            '999999' => 'SEMUA PELAYANAN'
        ];
        if ($select_data) {
            foreach ($select_data as $row) {
                $options[$row->KD_JNS_PELAYANAN] = $row->NM_JENIS_PELAYANAN;
            }
        } else {
            $options['0'] = 'Data not found';
        }
        $js     = 'class="form-control" id="jns_ply" onChange="search_sub_jns(this.value);" ';
        $select = form_dropdown('jns_ply', $options, '', $js);
        $select = preg_replace("/[\r\n]+/", "", $select);
        $data['select_jns_ply'] = $select;
        /////////////////////////////////////////////////////////////////
        $select_data = $this->permohonan_online_upt_model->get_sub_jns_ply_r('99999');
        $options     = array();
        if ($select_data) {
            foreach ($select_data as $rows) {
                $options[$rows->ID] = $rows->NM_SUB_JENIS_PELAYANAN;
            }
        }
        $js      = 'id="sub_jns_ply" class="form-control"';
        $select  = form_dropdown('sub_jns_ply', $options, 99999, $js);
        $select  = preg_replace("/[\r\n]+/", "", $select);
        $data['select_sub_jns_ply'] = $select;

        // $select_data  = $this->permohonan_online_upt_model->get_jns_bidang();
        // $options     = array();
        // $options = [
        //     '999999' => 'SEMUA JENIS BIDANG'
        // ];
        // if ($select_data) {
        //     foreach ($select_data as $row) {
        //         $options[$row->ID] = $row->NM_JENIS_PELAYANAN;
        //     }
        // } else {
        //     $options['0'] = 'Data not found';
        // }
        // $js     = 'class="form-control" id="jns_ply" onChange="search_sub_jns(this.value);" ';
        // $select = form_dropdown('jns_ply', $options, '', $js);
        // $select = preg_replace("/[\r\n]+/", "", $select);
        // $data['select_jns_ply'] = $select;

        $select_data  = $this->permohonan_online_upt_model->get_kecamatan();
        $options     = array();
        $options = [
            '999999' => 'SEMUA KECAMATAN'
        ];
        if ($select_data) {
            foreach ($select_data as $row) {
                $options[$row->KD_KECAMATAN] = $row->NM_KECAMATAN;
            }
        } else {
            $options['0'] = 'Data not found';
        }
        $js     = 'class="form-control" id="kd_kecamatan" onChange="search_kelurahan(this.value);" ';
        $select = form_dropdown('kd_kecamatan', $options, '', $js);
        $select = preg_replace("/[\r\n]+/", "", $select);
        $data['select_kecamatan'] = $select;

        /////////////////////////////////////////////////////////////////

        $select_data = $this->permohonan_online_upt_model->get_kelurahan('99999');
        $options     = array();
        if ($select_data) {
            foreach ($select_data as $rows) {
                $options[$rows->KD_KELURAHAN] = $rows->NM_KELURAHAN;
            }
        }
        $js      = 'id="kd_kelurahan" class="form-control"';
        $select  = form_dropdown('kd_kelurahan', $options, 99999, $js);
        $select  = preg_replace("/[\r\n]+/", "", $select);
        $data['select_kelurahan'] = $select;

        $this->load->view('vmonitoring_permohonan_online_upt', $data);
    }

    public function grid() {

        $tgl_fr = $this->input->get('tgl_fr');
        $tgl_to = $this->input->get('tgl_to');
        $jns_ply = $this->input->get('jns_ply');
        $sub_jns_ply = $this->input->get('sub_jns_ply');
        $thn_ply = $this->input->get('thn_ply');
        $bundel_ply = $this->input->get('bundel_ply');
        $urut_ply = $this->input->get('urut_ply');
        $nop = $this->input->get('nop');
        $sts_kd = $this->input->get('sts_kd');
        $kec_id = $this->input->get('kec_id');
        $kel_id = $this->input->get('kel_id');

        $this->load->library('Datatables');
        $this->datatables->select(" P.ID, P.THN_PELAYANAN||'-'||P.BUNDEL_PELAYANAN||'-'||P.NO_URUT_PELAYANAN as NOPEL,
                                    P.KD_PROPINSI_PEMOHON||P.KD_DATI2_PEMOHON||P.KD_KECAMATAN_PEMOHON||P.KD_KELURAHAN_PEMOHON||P.KD_BLOK_PEMOHON||P.NO_URUT_PEMOHON||P.KD_JNS_OP_PEMOHON AS NOP,
                                    CASE WHEN P.KD_JNS_PELAYANAN = '03' THEN
                                    RP.NM_JENIS_PELAYANAN||'<br> SUB '||RSP.NM_SUB_JENIS_PELAYANAN
                                    ELSE RP.NM_JENIS_PELAYANAN END AS NM_JENIS_PELAYANAN, 
                                    P.NAMA_PEMOHON, KEC.NM_KECAMATAN, KEL.NM_KELURAHAN,
                                    ST.KET AS STS,
                                    TO_CHAR(P.TGL_PERKIRAAN_SELESAI, 'DD-MM-YYYY') AS TGL_PERKIRAAN_SELESAI,
                                    P.THN_PELAYANAN||P.KD_PROPINSI_PEMOHON||P.KD_DATI2_PEMOHON||P.KD_KECAMATAN_PEMOHON||P.KD_KELURAHAN_PEMOHON||P.KD_BLOK_PEMOHON||P.NO_URUT_PEMOHON||P.KD_JNS_OP_PEMOHON||P.KD_JNS_PELAYANAN as NOPELNOP,
                                    P.STATUS_PERMOHONAN", false);
        $this->datatables->from("PST_PERMOHONAN_TOOL P");
        $this->datatables->join('REF_STATUS_PST ST', 'ST.KD = P.STATUS_PERMOHONAN');
        $this->datatables->join('REF_JNS_PELAYANAN RP', 'RP.KD_JNS_PELAYANAN = P.KD_JNS_PELAYANAN', 'left');
        $this->datatables->join('REF_SUB_JNS_PELAYANAN RSP', 'RSP.KD_JNS_PELAYANAN = P.KD_JNS_PELAYANAN AND RSP.KD_SUB_JNS_PELAYANAN = P.KD_SUB_JNS_PELAYANAN', 'left');
        $this->datatables->join('REF_KECAMATAN KEC', 'KEC.KD_KECAMATAN = P.KD_KECAMATAN_PEMOHON');
        $this->datatables->join('REF_KELURAHAN KEL', 'KEL.KD_KECAMATAN = P.KD_KECAMATAN_PEMOHON AND KEL.KD_KELURAHAN = P.KD_KELURAHAN_PEMOHON');

        if($jns_ply <> '999999' && !empty($jns_ply)){
            $this->datatables->where('P.KD_JNS_PELAYANAN', $jns_ply);
        }else{
            $this->datatables->where("P.KD_JNS_PELAYANAN IN ('02', '03', '15', '08','19','22')");
        }

        if($sub_jns_ply <> 99999 && !empty($sub_jns_ply)){
            $this->datatables->where('RSP.ID', $sub_jns_ply);
        }

        if($kec_id <> '99999' && !empty($kec_id)){
            $this->datatables->where('P.KD_KECAMATAN_PEMOHON', $kec_id);
        }

        if($kel_id <> '99999' && !empty($kel_id)){
            $this->datatables->where('P.KD_KELURAHAN_PEMOHON', $kel_id);
        }

        $this->datatables->where('P.ID_REGUSER IS NOT NULL');

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
            $this->datatables->where("TO_DATE(TO_CHAR(P.TGL_SURAT_PERMOHONAN,'yyyy-mm-dd'), 'yyyy-mm-dd') >= TO_DATE('".$tgl_fr."', 'dd-mm-yyyy')");
        }

        if(!empty($tgl_to)){
            $this->datatables->where("TO_DATE(TO_CHAR(P.TGL_SURAT_PERMOHONAN,'yyyy-mm-dd'), 'yyyy-mm-dd') <= TO_DATE('".$tgl_to."', 'dd-mm-yyyy')");
        }

        if($sts_kd != '999' && strlen($sts_kd) > 0) {
            $this->datatables->where('P.STATUS_PERMOHONAN', $sts_kd);
        }
        
        echo $this->datatables->generate();
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
        $data['ket_pst'] = $this->input->post('ket_pst');
        
        return $data;
    }

    public function detail() {
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_danger', $this->module_auth->msg_read);
            redirect('tool_pbb');
        }

        $param     = $this->uri->segment(4);

        $data['page_menu'] = 'monitoring_permohonan_online_upt';
        $data['current'] = '';
        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = '';
        
        $x = $this->permohonan_online_upt_model->get_ppo_by_id($param);
        $y = $this->permohonan_online_upt_model->get_tracking_by_id($param);

        $data['tracking'] = array(
            'nip_apr_loket' => $y->NIP_APR_LOKET,
            'nama_apr_loket' => $y->NAMA_APR_LOKET,
            'tgl_apr_loket' => $y->TGL_APR_LOKET,
            'nip_ver_pdl' => $y->NIP_VER_PDL,
            'nama_ver_pdl' => $y->NAMA_VER_PDL,
            'tgl_ver_pdl' => $y->TGL_VER_PDL,
            'nip_subid_pdl' => $y->NIP_SUBID_PDL,
            'nama_subid_pdl' => $y->NAMA_SUBID_PDL,
            'tgl_subid_pdl' => $y->TGL_SUBID_PDL,
            'nip_bid_pdl' => $y->NIP_BID_PDL,
            'nama_bid_pdl' => $y->NAMA_BID_PDL,
            'tgl_bid_pdl' => $y->TGL_BID_PDL,
            'nip_koor_pkp' => $y->NIP_KOOR_PKP,
            'nama_koor_pkp' => $y->NAMA_KOOR_PKP,
            'tgl_koor_pkp' => $y->TGL_KOOR_PKP,
            'nip_ver_pkp' => $y->NIP_VER_PKP,
            'nama_ver_pkp' => $y->NAMA_VER_PKP,
            'tgl_ver_pkp' => $y->TGL_VER_PKP,
            'nip_subid_pkp' => $y->NIP_SUBID_PKP,
            'nama_subid_pkp' => $y->NAMA_SUBID_PKP,
            'tgl_subid_pkp' => $y->TGL_SUBID_PKP,
            'nip_bid_pkp' => $y->NIP_BID_PKP,
            'nama_bid_pkp' => $y->NAMA_BID_PKP,
            'tgl_bid_pkp' => $y->TGL_BID_PKP,
            'nip_ver_pntp' => $y->NIP_VER_PNTP,
            'nama_ver_pntp' => $y->NAMA_VER_PNTP,
            'tgl_ver_pntp' => $y->TGL_VER_PNTP,
            'nip_bid_pntp' => $y->NIP_BID_PNPT,
            'nama_bid_pntp' => $y->NAMA_BID_PNPT,
            'tgl_bid_pntp' => $y->TGL_BID_PNTP,
			'nip_kaban' => $y->NIP_KABAN,
            'nama_kaban' => $y->NAMA_KABAN,
            'tgl_kaban' => $y->TGL_KABAN
        );

        if ($x){
            if ($x->KD_JNS_PELAYANAN == '02' || $x->KD_JNS_PELAYANAN == '03') {
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
                    'ket_pst' => $dt->ALASAN,

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
                    'kd_jns_ply' => $dt->KD_JNS_PELAYANAN,

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
                $get_select_pekerjaan_wp = $this->permohonan_online_upt_model->pekerjaan_wp_droplist(NULL);
                $select_pekerjaan_wp = '<select id="pekerjaan_wp" name="pekerjaan_wp" class="form-control" readonly>';
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
                $get_select_sts_op = $this->permohonan_online_upt_model->lookup_item_droplist(10, NULL);
                $select_sts_op = '<select id="sts_op" name="sts_op" class="form-control" readonly>';
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
                $get_select_jns_tanah = $this->permohonan_online_upt_model->lookup_item_droplist(20, NULL);
                $select_jns_tanah = '<select id="jns_tanah_op" required name="jns_tanah_op" class="form-control" readonly>';
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

                $this->load->view('vmonitoring_permohonan_online_upt_form', $data);  

            } else if ($x->KD_JNS_PELAYANAN == '15') {
                $dt = $this->permohonan_online_upt_model->get_dt_angsuran($param);
                $pst_angs = $this->permohonan_online_upt_model->get_pst_angsuran($param);
        
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

                    'nama_wp_sppt' => $dt->NM_WP_SPPT, 
                    'alamat_op_sppt' => $dt->ALAMAT_OP_SPPT, 
                    'pbb_yg_harus_dibayar' => $dt->PBB_YG_HARUS_DIBAYAR_SPPT, 

                    'jatuh_tempo_1' => app_date($pst_angs->TGL_C_I),
                    'nominal_1' => $pst_angs->CICILAN_I,
                    'jatuh_tempo_2' => app_date($pst_angs->TGL_C_II),
                    'nominal_2' => $pst_angs->CICILAN_II,
                    'jatuh_tempo_3' => app_date($pst_angs->TGL_C_III),
                    'nominal_3' => $pst_angs->CICILAN_III,
                    'jatuh_tempo_4' => app_date($pst_angs->TGL_C_IV),
                    'nominal_4' => $pst_angs->CICILAN_IV,

                );

                $data['da'] = (array)$dt;

                $data['fnopnik'] = $x->NOPNIK;

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

                $this->load->view('vmonitoring_permohonan_online_upt_angs_form', $data);  
            } else if ($x->KD_JNS_PELAYANAN == '08') {
                $dt = $this->permohonan_online_upt_model->get_dt_pengurangan($param);
        
                $data['dt'] = array(
                    'nop_re' => $x->NOP_LKP, 
                    'id_reg_esppt' => $x->NOPNIK, 
                    'rowid' => $x->PPO_ID, 
                    'id_ppo' => $x->PPO_ID, 
                    'nopel' => $x->NOPEL, 
                    'nop' => $x->NOP_LKP, 
                    'ket_pst' => $x->ALASAN,

                    'nama_wp_re' => $x->NAMA_WP_REG, 
                    'alamat_op_re' => $x->ALAMAT_REG, 
                    'nik_re' => $x->NIK_REG, 
                    'no_telp_re' => $x->TELP_REG,
                    'nama_re' => $x->NAMA_REG, 
                    'email_re' => $x->EMAIL_REG,
                    'kd_jns_ply' => $x->KD_JNS_PELAYANAN,
                    'kd_sub_jns_ply' => $x->KD_SUB_JNS_PELAYANAN,

                    'no_permohonan' => $x->NO_SRT_PERMOHONAN, 
                    'thn_permohonan' => $x->THN_PAJAK_PERMOHONAN, 
                    'tgl_permohonan' => get_date($x->TGL_SURAT_PERMOHONAN), 
                    'nama_pemohon' => $x->NAMA_PEMOHON, 
                    'alamat_pemohon' => $x->ALAMAT_PEMOHON, 
                    'telp' => $x->NO_HP, 
                    'keterangan' => $x->KETERANGAN_PST, 

                    // 'nama_wp_sppt' => $dt->NM_WP_SPPT, 
                    // 'alamat_op_sppt' => $dt->ALAMAT_OP_SPPT, 
                    // 'pbb_yg_harus_dibayar' => $dt->PBB_YG_HARUS_DIBAYAR_SPPT, 

                    'jns_png' => $dt->NM_SUB_JENIS_PELAYANAN,
                    'pct_png' => $dt->PCT_PENGURANGAN,
                    'pct_png_disetujui' => $dt->NM_SUB_JENIS_PELAYANAN,
                    // 'sts_png' => $dt->STS_PENGURANGAN,

                );

                $data['da'] = (array)$dt;

                $data['fnopnik'] = $x->NOPNIK;

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

                $this->load->view('vmonitoring_permohonan_online_upt_08_form', $data);

            } else if ($x->KD_JNS_PELAYANAN == '22') {
                $dt = $this->permohonan_online_upt_model->get_dt_sismiop_asli($param);
                $data['dt'] = array(
                    'nop_re' => $x->NOP_LKP, 
                    'id_reg_esppt' => $x->NOPNIK, 
                    'rowid' => $x->PPO_ID, 
                    'id_ppo' => $x->PPO_ID, 
                    'nopel' => $x->NOPEL, 
                    'nop' => $x->NOP_LKP, 
                    'ket_pst' => $x->ALASAN,

                    'nama_wp_re' => $x->NAMA_WP_REG, 
                    'alamat_op_re' => $x->ALAMAT_REG, 
                    'nik_re' => $x->NIK_REG, 
                    'no_telp_re' => $x->TELP_REG,
                    'nama_re' => $x->NAMA_REG, 
                    'email_re' => $x->EMAIL_REG,
                    'kd_jns_ply' => $x->KD_JNS_PELAYANAN,
                    'kd_sub_jns_ply' => $x->KD_SUB_JNS_PELAYANAN,

                    'no_permohonan' => $x->NO_SRT_PERMOHONAN, 
                    'thn_permohonan' => $x->THN_PAJAK_PERMOHONAN, 
                    'tgl_permohonan' => get_date($x->TGL_SURAT_PERMOHONAN), 
                    'nama_pemohon' => $x->NAMA_PEMOHON, 
                    'alamat_pemohon' => $x->ALAMAT_PEMOHON, 
                    'telp' => $x->NO_HP, 
                    'keterangan' => $x->KETERANGAN_PST, 

                    'nama_wp_sppt' => $dt->NM_WP, 
                    'alamat_op_sppt' => $dt->JALAN_OP, 
                    'subjek_pajak_id' => $dt->SUBJEK_PAJAK_ID, 
                    'blok_op' => $dt->BLOK_KAV_NO_OP, 
                    'luas_bumi' => $dt->TOTAL_LUAS_BUMI, 
                    'luas_bangunan' => $dt->TOTAL_LUAS_BNG, 
                    'rt_op' => $dt->RT_OP, 
                    'rw_op' => $dt->RW_OP, 

                );

                $data['nm_jns_pelayanan'] = strtoupper($dt->NM_JENIS_PELAYANAN);
                $data['fnopnik'] = $x->NOPNIK;

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
                $js     = 'class="form-select" id="jns_ply" readonly ';
                $select = form_dropdown('jns_ply', $options, $x->KD_JNS_PELAYANAN, $js);
                $select = preg_replace("/[\r\n]+/", "", $select);
                $data['select_jns_ply'] = $select;
                //---------------------------------------------------------------------------------------------------------

                $this->load->view('vmonitoring_permohonan_online_upt_default_form', $data);
            }
            

        } else {
            $this->session->set_flashdata('msg_success', 'Data tidak ditemukan.');
            redirect(active_module_url('monitoring_permohonan_online_upt'));
        }

    }

    function get_dtl_bng() {
        $id_dtl = $this->uri->segment(4);
        $data = $this->permohonan_online_upt_model->get_dtl_bng($id_dtl);
        echo json_encode($data);
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
        $kdsub = $this->input->post('sub_jns_ply'); // KD_SUB_JNS_PELAYANAN
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

    function cetak() {  

        $type = $this->uri->segment(4);

        $qs   = urldecode ($_SERVER['QUERY_STRING']);
        parse_str($qs, $qs_data);
            
        $params = array();             
        $p_kec_id = $this->input->get('kec_id') ?: '0';
        $p_kel_id = $this->input->get('kel_id') ?: '0';
        $p_pjk_kd = $this->input->get('pjk_kd') ?: '99';
        $tgl_1_raw = $this->input->get('tgl_1') ?: '01-01-2025';
        $tgl_2_raw = $this->input->get('tgl_2') ?: '01-01-2027';

        $tgl_1 = DateTime::createFromFormat('d-m-Y', $tgl_1_raw);
        $tgl_2 = DateTime::createFromFormat('d-m-Y', $tgl_2_raw);
        $tgl_1 = $tgl_1 ? $tgl_1->format('Y-m-d') : '2025-01-01';
        $tgl_2 = $tgl_2 ? $tgl_2->format('Y-m-d') : '2027-01-01';

        $kondisi = '';

        ($p_kec_id != "0" ? $kondisi .= ' and mk.kd_kecamatan ='.$p_kec_id : '');
        ($p_kel_id != "0" ? $kondisi .= ' and mk2.kd_kelurahan ='.$p_kel_id : '');
        ($p_pjk_kd != "99" ? $kondisi .= ' and vu.jenis_pajakkd ='.$p_pjk_kd : '');

        $params = array(
            'kondisi' => $kondisi,
            'p_tgl_1' => $tgl_1,
            'p_tgl_2' => $tgl_2,
        );

        $params = array_merge($params, array(
            "l_scParam" => "Y",
            "l_companyName" => pad_pemda_nama(), 
            "l_userName" => ipad_user_login(),
            "l_userid" => ipad_user_login(),            
        ));
 
        $rpt = 'lap_potensi';
        // var_dump($rpt);var_dump($params);die;
            
        $jasper = $this->load->library('Jasper');

        $tipelaporan = $this->uri->segment(5);
        $jasper = $this->load->library('Jasper');
        if ($tipelaporan != 'export')
            echo $jasper->cetak($rpt, $params, $type, FALSE);
        else
            echo $jasper->export($rpt, $params, $type, TRUE);
        // echo $jasper->cetak($rpt, $params, $type, false);
    }

    function search_sub_jns()
    {
        $jns_id = $this->uri->segment(4);
        $sub_jns = $this->permohonan_online_upt_model->get_sub_jns_ply_r($jns_id);
        echo json_encode($sub_jns);
    }

    function search_kelurahan()
    {
        $kec_id = $this->uri->segment(4);
        $kel_id = $this->permohonan_online_upt_model->get_kelurahan($kec_id);
        echo json_encode($kel_id);
    }

}
