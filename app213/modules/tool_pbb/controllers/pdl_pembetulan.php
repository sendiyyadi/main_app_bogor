<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class pdl_pembetulan extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!is_login()) {
            echo "<script>window.location.replace('" . base_url() . "');</script>";
            exit;
        }

        $module = 'pdl_pembetulan';
        $this->load->library('module_auth', array(
            'module' => $module
        ));

        $this->load->model(array(
            'apps_model', 'pembetulan_model', 'permohonan_online_upt_model'
        ));

        $this->load->helper(active_module());
    }

    public function index() {
        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect('tool_pbb');
        }

        $data['page_menu'] = 'pendanil';
        $data['current'] = 'pdl_pembetulan';
        $data['apps']    = $this->apps_model->get_active_only();
        $option = array( ''=> 'Semua Status','888' => 'Belum diproses',
            '999' => 'Sudah diproses');
        $js  = 'id="status_kd" style="width:130px;" class="form-control" ';
        $select = form_dropdown('status_kd', $option, '' , $js);
        $data['select_sts'] = $select;
        //------------------------------------------------------------------
        $select_data  = $this->pembetulan_model->get_jns_ply();
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


        $this->load->view('vpdl_pembetulan', $data);
    }

    public function grid() {

        $tgl_fr = $this->input->get('tgl_fr');
        $tgl_to = $this->input->get('tgl_to');
        $jns_ply = $this->input->get('jns_ply');
        $thn_ply = $this->input->get('thn_ply');
        $bundel_ply = $this->input->get('bundel_ply');
        $urut_ply = $this->input->get('urut_ply');
        $nop = $this->input->get('nop');
        $sts_kd = $this->input->get('status_kd');

        $this->load->library('Datatables');
        $this->datatables->select("	P.ID, P.THN_PELAYANAN||'-'||P.BUNDEL_PELAYANAN||'-'||P.NO_URUT_PELAYANAN as NOPEL,
                                    TO_CHAR(P.TGL_APR_LOKET,'DD-MM-YYYY') as TGL_APR,
                                    P.KD_PROPINSI_PEMOHON||P.KD_DATI2_PEMOHON||P.KD_KECAMATAN_PEMOHON||P.KD_KELURAHAN_PEMOHON||P.KD_BLOK_PEMOHON||P.NO_URUT_PEMOHON||P.KD_JNS_OP_PEMOHON AS NOP, 
                                    RSP.NM_SUB_JENIS_PELAYANAN as NM_JENIS_PELAYANAN, 
                                    P.NAMA_PEMOHON, KEC.NM_KECAMATAN, KEL.NM_KELURAHAN,
                                    ST.KET AS STS,
									TO_CHAR(P.TGL_PERKIRAAN_SELESAI, 'DD-MM-YYYY') AS TGL_PERKIRAAN_SELESAI,
                                    P.THN_PELAYANAN||P.KD_PROPINSI_PEMOHON||P.KD_DATI2_PEMOHON||P.KD_KECAMATAN_PEMOHON||P.KD_KELURAHAN_PEMOHON||P.KD_BLOK_PEMOHON||P.NO_URUT_PEMOHON||P.KD_JNS_OP_PEMOHON||P.KD_JNS_PELAYANAN as NOPELNOP,
                                    P.STATUS_PERMOHONAN", false);
        $this->datatables->from("PST_PERMOHONAN_TOOL P");
        $this->datatables->join('REF_STATUS_PST ST', 'ST.KD = P.STATUS_PERMOHONAN');
        $this->datatables->join("TRACKING T", "P.THN_PELAYANAN=T.THN_PELAYANAN AND P.BUNDEL_PELAYANAN=T.BUNDEL_PELAYANAN AND P.NO_URUT_PELAYANAN=T.NO_URUT_PELAYANAN AND P.KD_PROPINSI_PEMOHON = T.KD_PROPINSI AND P.KD_DATI2_PEMOHON = T.KD_DATI2 AND P.KD_KECAMATAN_PEMOHON = T.KD_KECAMATAN AND P.KD_KELURAHAN_PEMOHON = T.KD_KELURAHAN AND P.KD_BLOK_PEMOHON = T.KD_BLOK AND P.NO_URUT_PEMOHON = T.NO_URUT");
        $this->datatables->join('REF_JNS_PELAYANAN RP', 'RP.KD_JNS_PELAYANAN = P.KD_JNS_PELAYANAN', 'left');
        $this->datatables->join('REF_SUB_JNS_PELAYANAN RSP', 'RSP.KD_JNS_PELAYANAN = P.KD_JNS_PELAYANAN AND RSP.KD_SUB_JNS_PELAYANAN = P.KD_SUB_JNS_PELAYANAN', 'left');
        $this->datatables->join('REF_KECAMATAN KEC', 'KEC.KD_KECAMATAN = P.KD_KECAMATAN_PEMOHON');
        $this->datatables->join('REF_KELURAHAN KEL', 'KEL.KD_KECAMATAN = P.KD_KECAMATAN_PEMOHON AND KEL.KD_KELURAHAN = P.KD_KELURAHAN_PEMOHON');

        $this->datatables->where("P.KD_JNS_PELAYANAN", "03");
        $this->datatables->where("P.KD_SUB_JNS_PELAYANAN in ('01','02')", null, false);
        // $this->datatables->where("P.STATUS_PERMOHONAN IN ('4', 'A', 'C')");

        if($sts_kd <> '888' && !empty($sts_kd)){
            $this->datatables->where("P.STATUS_PERMOHONAN NOT IN ('0','1','2','3','4')");
            $this->datatables->where("P.TGL_VER_PDL IS NOT NULL", NULL, FALSE);
        } else{
            $this->datatables->where("P.STATUS_PERMOHONAN IN ('4')");
        }

        // $this->datatables->where("P.STATUS_PERMOHONAN IN ('4')");

        $nip_login = sipkd_user_nip();
        if(!is_super_admin()) {
            $this->datatables->where("P.NIP_VER_PDL", $nip_login);
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

        // if(!empty($tgl_fr) && !empty($tgl_to)){
        //   $this->datatables->where("TO_DATE(TO_CHAR(P.TGL_SURAT_PERMOHONAN,'yyyy-mm-dd'), 'yyyy-mm-dd') BETWEEN TO_DATE('".$tgl_fr."', 'dd-mm-yyyy') AND TO_DATE('".$tgl_to."', 'dd-mm-yyyy')");
        // }
        
        // $this->datatables->rupiah_column('5,6,7,8,9');
        // $this->datatables->date_column('2');
        
        echo $this->datatables->generate();
    }

    private function fvalidation() {
        $this->form_validation->set_error_delimiters('<span>', '</span>');
        $this->form_validation->set_rules('nop', 'NOP', 'required|trim|callback_cek_nop');
        $this->form_validation->set_rules('thn_permohonan', 'Tahun Permohonan', 'required|trim');
    }

    // public function cek_nop($value) {
    //     $nop = $this->input->post('nop');

    //     if ($this->pembetulan_model->cek_nop($nop)) {
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

        $data['dasar_penilaian'] = $this->input->post('dasar_penilaian');
        $data['penggunaan_bng_pdl'] = $this->input->post('penggunaan_bng_pdl');
        $data['objek_bng_pdl'] = $this->input->post('objek_bng_pdl');
        $data['ket_bumi_pdl'] = $this->input->post('ket_bumi_pdl');
        $data['ket_bng_pdl'] = $this->input->post('ket_bng_pdl');

        
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
        //     redirect('tool_pbb/pdl_pembetulan');
        // }

        $data['page_menu'] = 'pendanil';
        $data['current'] = 'pdl_pembetulan';
        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = '';
        
        $dt = $this->permohonan_online_upt_model->get_by_id($param);

        if ($dt){
    
            $data['dt'] = array(
                'nop_re' => $dt->NOP_LKP, 
                'nop_t' => $dt->NOP, 
                'id_reg_esppt' => $dt->NOPNIK, 
                'nama_wp_re' => $dt->NAMA_WP_REG, 
                'alamat_op_re' => $dt->ALAMAT_REG, 
                'nik_re' => $dt->NIK_REG, 
                'no_telp_re' => $dt->TELP_REG,
                'nama_re' => $dt->NAMA_REG, 
                'email_re' => $dt->EMAIL_REG,
                'kd_jns_ply' => $dt->KD_JNS_PELAYANAN,

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

                'uraian_1' => $dt->URAIAN_1,
                'uraian_2' => $dt->URAIAN_2,
                'no_sk' => $dt->NO_SK,
                'tgl_sk' => empty($dt->TGL_SK) ? NULL : date('d-m-Y', strtotime($dt->TGL_SK)),
                'no_bap' => $dt->NO_BAP_LAPANGAN,
                'tgl_bap' => empty($dt->TGL_BAP_LAPANGAN) ? NULL : date('d-m-Y', strtotime($dt->TGL_BAP_LAPANGAN)),
                'ket_verlap' => $dt->KET_VERLAP,
                'rekom_verlap' => $dt->REKOM_VERLAP,

                'proses_pk' => $dt->PROSES_PK,
                'analisa_pk' => $dt->ANALISA_PK,
                'keterangan_pk' => $dt->KETERANGAN_PK,
                'proses_pl' => $dt->PROSES_PL,
                'analisa_pl' => $dt->ANALISA_PL,
                'keterangan_pl' => $dt->KETERANGAN_PL,
                'kd_sub_jns_ply' => $dt->KD_SUB_JNS_PELAYANAN,
                'latitude' => $dt->LATITUDE,
                'longitude' => $dt->LONGITUDE,

                'dasar_penilaian' => $dt->DASAR_PENILAIAN,
                'penggunaan_bng_pdl' => $dt->PENGGUNAAN_BNG_PDL,
                'objek_bng_pdl' => $dt->OBJEK_BNG_PDL,
                'ket_bumi_pdl' => $dt->KET_BUMI_PDL,
                'ket_bng_pdl' => $dt->KET_BNG_PDL,

            );

            $data['da'] = (array)$dt;

            $data['fnopnik'] = $dt->NOPNIK;

            /// lampiran 
            $tidak_ada = '<p class="teks_red">File Tidak Ada</p>';
            $L_VERLAP1 = $dt->L_VERLAP1 == 1 ? $this->btn_file('L_VERLAP11', $param) : $tidak_ada;
            $L_VERLAP2 = $dt->L_VERLAP2 == 1 ? $this->btn_file('L_VERLAP21', $param) : $tidak_ada;

            $data['dl'] = array(
                'L_VERLAP1' => $dt->L_VERLAP1,
                'L_VERLAP2' => $dt->L_VERLAP2,
                'L_VERLAP11' => $L_VERLAP1,
                'L_VERLAP21' => $L_VERLAP2
            );

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
            $get_select_kd_znt = $this->pembetulan_model->select_znt($dt->KD_PROPINSI, $dt->KD_DATI2, $dt->KD_KECAMATAN, $dt->KD_KELURAHAN, $dt->KD_BLOK);
            $select_kd_znt = '<select id="kd_znt_op" required name="kd_znt_op" class="form-control">';
            // $select_kd_znt .= '<option value="">-Silahkan Pilih-</option>';
            foreach ($get_select_kd_znt as $key => $va) {
                $selected = '';
                if ($dt->KD_ZNT == $va->KD_ZNT) {
                    $selected = 'selected';
                }
                $select_kd_znt .= '<option ' . $selected . ' value="' . $va->KD_ZNT . '">' . $va->KD_ZNT . '</option>';
            }
            $select_kd_znt .= '</select>';
            $data['select_kd_znt'] = $select_kd_znt;
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

            //// njop 
            $data['dt']['njop_bumi_perm_op'] = $dt->NJOP_BUMI_PERM;
            $data['dt']['njop_bumi_op'] = $dt->NJOP_BUMI;
            $data['dt']['njop_bng_perm_op'] = $dt->NJOP_BNG_PERM;
            $data['dt']['njop_bng_op'] = $dt->NJOP_BNG;

            $dt_thn = $this->permohonan_online_upt_model->get_dt_thn_ol($dt->PPO_ID, 2);
            $data['dt']['tahun_awal'] = !empty($dt_thn->TAHUN_MIN) ? get_string($dt_thn->TAHUN_MIN) : date('Y');
            $data['dt']['tahun_akhir'] = !empty($dt_thn->TAHUN_MAX) ? get_string($dt_thn->TAHUN_MAX) : date('Y');

            $syarat_peneliti = $this->pembetulan_model->get_ref_syarat_peneliti_by_idppo($dt->PPO_ID);
            $data['syarat'] = $syarat_peneliti;
            $data['mode']   = 'view';

            $this->load->view('vpdl_pembetulan_form', $data);

        } else {
            $this->session->set_flashdata('msg_error', 'Data tidak ditemukan..');
            redirect(active_module_url('pdl_pembetulan'));
        }

    }

    public function edit() {
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_error', $this->module_auth->msg_read);
            redirect('tool_pbb');
        }

        $param     = $this->uri->segment(4);

        //// cek heula
        $qr_cek = "SELECT COUNT(*) AS JML FROM PST_PERMOHONAN_TOOL WHERE ID = ? AND STATUS_PERMOHONAN <> '4'";
        $cek_heula = $this->db->query($qr_cek, [$param])->row()->JML;

        if ($cek_heula > 0) {
            $this->session->set_flashdata('msg_info', "Data sudah diproses. Tidak bisa edit data");
            redirect('tool_pbb/pdl_pembetulan');
        }

        $data['page_menu'] = 'pendanil';
        $data['current'] = 'pdl_pembetulan';
        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = '';
        
        $dt = $this->permohonan_online_upt_model->get_by_id($param);

        if ($dt){

            if ($dt->STATUS_PERMOHONAN != '4') {
                $this->session->set_flashdata('msg_error', 'Tidak bisa edit data.');
                redirect(active_module_url('pdl_pembetulan'));
            }
    
            $data['dt'] = array(
                'nop_re' => $dt->NOP_LKP, 
                'nop_t' => $dt->NOP, 
                'id_reg_esppt' => $dt->NOPNIK, 
                'nama_wp_re' => $dt->NAMA_WP_REG, 
                'alamat_op_re' => $dt->ALAMAT_REG, 
                'nik_re' => $dt->NIK_REG, 
                'no_telp_re' => $dt->TELP_REG,
                'nama_re' => $dt->NAMA_REG, 
                'email_re' => $dt->EMAIL_REG,
                'kd_jns_ply' => $dt->KD_JNS_PELAYANAN,

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

                'uraian_1' => $dt->URAIAN_1,
                'uraian_2' => $dt->URAIAN_2,
                'no_sk' => $dt->NO_SK,
                'tgl_sk' => empty($dt->TGL_SK) ? NULL : date('d-m-Y', strtotime($dt->TGL_SK)),
                'no_bap' => $dt->NO_BAP_LAPANGAN,
                'tgl_bap' => empty($dt->TGL_BAP_LAPANGAN) ? NULL : date('d-m-Y', strtotime($dt->TGL_BAP_LAPANGAN)),
                'ket_verlap' => $dt->KET_VERLAP,
                'rekom_verlap' => $dt->REKOM_VERLAP,

                'proses_pk' => $dt->PROSES_PK,
                'analisa_pk' => $dt->ANALISA_PK,
                'keterangan_pk' => $dt->KETERANGAN_PK,
                'proses_pl' => $dt->PROSES_PL,
                'analisa_pl' => $dt->ANALISA_PL,
                'keterangan_pl' => $dt->KETERANGAN_PL,
                'kd_sub_jns_ply' => $dt->KD_SUB_JNS_PELAYANAN,
                'latitude' => $dt->LATITUDE,
                'longitude' => $dt->LONGITUDE,

                'dasar_penilaian' => $dt->DASAR_PENILAIAN,
                'penggunaan_bng_pdl' => $dt->PENGGUNAAN_BNG_PDL,
                'objek_bng_pdl' => $dt->OBJEK_BNG_PDL,
                'ket_bumi_pdl' => $dt->KET_BUMI_PDL,
                'ket_bng_pdl' => $dt->KET_BNG_PDL,

            );

            $data['da'] = (array)$dt;

            $data['fnopnik'] = $dt->NOPNIK;

            /// lampiran 
            $tidak_ada = '<p class="teks_red">File Tidak Ada</p>';
            $L_VERLAP1 = $dt->L_VERLAP1 == 1 ? $this->btn_file('L_VERLAP11', $param) : $tidak_ada;
            $L_VERLAP2 = $dt->L_VERLAP2 == 1 ? $this->btn_file('L_VERLAP21', $param) : $tidak_ada;

            $data['dl'] = array(
                'L_VERLAP1' => $dt->L_VERLAP1,
                'L_VERLAP2' => $dt->L_VERLAP2,
                'L_VERLAP11' => $L_VERLAP1,
                'L_VERLAP21' => $L_VERLAP2
            );

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
            $select_pekerjaan_wp = '<select id="pekerjaan_wp" name="pekerjaan_wp" class="form-control">';
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
            $select_sts_op = '<select id="sts_op" name="sts_op" class="form-control">';
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
            $select_jns_tanah = '<select id="jns_tanah_op" required name="jns_tanah_op" class="form-control">';
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
            $get_select_kd_znt = $this->pembetulan_model->select_znt($dt->KD_PROPINSI, $dt->KD_DATI2, $dt->KD_KECAMATAN, $dt->KD_KELURAHAN, $dt->KD_BLOK);
            $select_kd_znt = '<select id="kd_znt_op" required name="kd_znt_op" class="form-control">';
            // $select_kd_znt .= '<option value="">-Silahkan Pilih-</option>';
            foreach ($get_select_kd_znt as $key => $va) {
                $selected = '';
                if ($dt->KD_ZNT == $va->KD_ZNT) {
                    $selected = 'selected';
                }
                $select_kd_znt .= '<option ' . $selected . ' value="' . $va->KD_ZNT . '">' . $va->KD_ZNT . '</option>';
            }
            $select_kd_znt .= '</select>';
            $data['select_kd_znt'] = $select_kd_znt;
            
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

            //// njop 
            $data['dt']['njop_bumi_perm_op'] = $dt->NJOP_BUMI_PERM;
            $data['dt']['njop_bumi_op'] = $dt->NJOP_BUMI;
            $data['dt']['njop_bng_perm_op'] = $dt->NJOP_BNG_PERM;
            $data['dt']['njop_bng_op'] = $dt->NJOP_BNG;

            $dt_thn = $this->permohonan_online_upt_model->get_dt_thn_ol($dt->PPO_ID, 2);
            $data['dt']['tahun_awal'] = !empty($dt_thn->TAHUN_MIN) ? get_string($dt_thn->TAHUN_MIN) : date('Y');
            $data['dt']['tahun_akhir'] = !empty($dt_thn->TAHUN_MAX) ? get_string($dt_thn->TAHUN_MAX) : date('Y');

            $syarat_peneliti = $this->pembetulan_model->get_ref_syarat_peneliti_by_idppo($dt->PPO_ID);
            $data['syarat'] = $syarat_peneliti;
            $data['mode']   = 'add';

            $this->load->view('vpdl_pembetulan_form', $data);

        } else {
            $this->session->set_flashdata('msg_error', 'Data tidak ditemukan..');
            redirect(active_module_url('pdl_pembetulan'));
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

        $ket_verlap     = strtoupper($this->input->post('ket_verlap'));
        $rekom_verlap   = strtoupper($this->input->post('rekom_verlap'));

        $proses_pk      = strtoupper($this->input->post('proses_pk'));
        $analisa_pk     = strtoupper($this->input->post('analisa_pk'));
        $keterangan_pk  = strtoupper($this->input->post('keterangan_pk'));
        $proses_pl      = strtoupper($this->input->post('proses_pl'));
        $analisa_pl     = strtoupper($this->input->post('analisa_pl'));
        $keterangan_pl  = strtoupper($this->input->post('keterangan_pl'));

        $dasar_penilaian  = strtoupper($this->input->post('dasar_penilaian'));
        $penggunaan_bng_pdl  = strtoupper($this->input->post('penggunaan_bng_pdl'));
        $objek_bng_pdl  = strtoupper($this->input->post('objek_bng_pdl'));
        $ket_bumi_pdl  = strtoupper($this->input->post('ket_bumi_pdl'));
        $ket_bng_pdl  = strtoupper($this->input->post('ket_bng_pdl'));

        $nip_pencetak   = sipkd_user_nip();
        $nip_pencetak_sk= sipkd_user_nip();

        // validasi server-side
        if (!preg_match('/^[0-9]{4}$/', $thn_awal) || 
            !preg_match('/^[0-9]{4}$/', $thn_akhir)) {

            echo json_encode([
                'result' => 400,
                'msg' => 'Tahun harus 4 digit angka'
            ]);
            return;
        }

        //// cek heula
        $qr_cek = "SELECT COUNT(*) AS JML FROM PST_PERMOHONAN_TOOL WHERE ID = ? AND STATUS_PERMOHONAN <> '4'";
        $cek_heula = $this->db->query($qr_cek, [$id_ppo])->row()->JML;

        if ($cek_heula > 0) {
            $this->session->set_flashdata('msg_info', "Data sudah diproses pendanil. Harap refresh halaman");

            echo json_encode([
                'result' => 302,
                'redirect' => active_module_url('pdl_pembetulan')
            ]);
            return;
        }

        $dt = $this->permohonan_online_upt_model->get_by_id($id_ppo);
        if ($dt){
            $fim_l_verlap1 = empty($_FILES['im_l_verlap1']['name']) ? 0 : 1;
            $fim_l_verlap2 = empty($_FILES['im_l_verlap2']['name']) ? 0 : 1;

            $im_l_verlap1 = $fim_l_verlap1 == 0 ? NULL : file_get_contents($_FILES['im_l_verlap1']['tmp_name']);
            $im_l_verlap2 = $fim_l_verlap2 == 0 ? NULL : file_get_contents($_FILES['im_l_verlap2']['tmp_name']);

            if (!empty($_FILES['im_l_verlap1']['name']) || !empty($_FILES['im_l_verlap2']['name']) ) {
                $this->update_prm_blob($id_ppo);
            }

            //paket generate nomer SK
            $get_no_sk = $this->pembetulan_model->select_max_no_sk();
            $new_thn_sk = $get_no_sk['THN_SURAT'];
            $new_urut_sk = intval($get_no_sk['NO_URUT_SK']) + 1;
            $this->pembetulan_model->update_max_no_sk($new_thn_sk, $new_urut_sk);
            // closed paket generate nomer SK

            $ins_no_sk = '900.1.13/' . str_pad($new_urut_sk, 6, "0", STR_PAD_LEFT) . '/KPTS-PKP/' . bulan_romawi(date('m')) . '/' . $new_thn_sk;
            // $ins_no_lhp = '973/' . str_pad($new_urut_sk, 6, "0", STR_PAD_LEFT) . '/PD-II/LHP/PembetulanPBBIntenEksten/' . bulan_romawi(date('m')) . '/' . $new_thn_sk;
            // $ins_no_bap = 'BA/' . str_pad($new_urut_sk, 6, "0", STR_PAD_LEFT) . '/PD-II/BKD/' . bulan_romawi(date('m')) . '/' . $new_thn_sk;

            // $tgl_sk = empty($ppost['tgl_sk']) ? NULL : date('Y-m-d', strtotime($ppost['tgl_sk']));
            // $tgl_lhp = empty($ppost['tgl_lhp']) ? NULL : date('Y-m-d', strtotime($ppost['tgl_lhp']));
            $tgl_sk = date('Y-m-d');

            //// get nik untuk pegawai (looping)
            $id_next_pgw = 0;
            $kdjns = $dt->KD_JNS_PELAYANAN; 
            $kdsub = $dt->KD_SUB_JNS_PELAYANAN ?: null;
            $jns_bid = '1B';
            $get_dt_pegawai = $this->permohonan_online_upt_model->get_next_pegawai($jns_bid, $kdjns, $kdsub);
            $id_next_pgw = $get_dt_pegawai->ID;
            $nip_next_pgw = $get_dt_pegawai->NIP;

            $dt_pst = array(
                'KET_VERLAP'        => $ket_verlap,
                'REKOM_VERLAP'      => $rekom_verlap,
                'NO_SK'             => $ins_no_sk,
                'TGL_SK'            => $tgl_sk,
                'STATUS_PERMOHONAN' => '6',
                'URUT_SK'           => $new_urut_sk,
                'PROSES_PK'         => $proses_pk,
                'ANALISA_PK'        => $analisa_pk,
                'KETERANGAN_PK'     => $keterangan_pk,
                'PROSES_PL'         => $proses_pl,
                'ANALISA_PL'        => $analisa_pl,
                'KETERANGAN_PL'     => $keterangan_pl,
                'NIP_SUBID_PDL'     => $nip_next_pgw,
                'TGL_VER_PDL'       => current_time_ora(),

                'DASAR_PENILAIAN'   => $dasar_penilaian,
                'PENGGUNAAN_BNG_PDL'=> $penggunaan_bng_pdl,
                'OBJEK_BNG_PDL'     => $objek_bng_pdl,
                'KET_BUMI_PDL'      => $ket_bumi_pdl,
                'KET_BNG_PDL'       => $ket_bng_pdl,
            );

            //// UPDATE DATA PST PERMOHONAN TOOL
            $this->pembetulan_model->update_pst_permohonan_tool($id_ppo, $dt_pst);

            //// update status ke pegawai baru
            $this->permohonan_online_upt_model->set_next_pegawai($id_next_pgw, $jns_bid, $kdjns, $kdsub);

            //// INSERT KE TBL PST_TOOL_DTL_PNLT
            $id_refs = $this->input->post('id_ref'); // kirim dari form hidden input
            $status  = $this->input->post('status'); // array
            $ket     = $this->input->post('ket');    // array

            if (!empty($id_refs) && is_array($id_refs)) {

                $data_insert = [];

                // foreach ($status as $id_ref => $val_status) {
                foreach ($id_refs as $id_ref) {
                    $val_status = isset($status[$id_ref]) ? $status[$id_ref] : null;
                    $val_ket    = trim($ket[$id_ref] ?? '');

                    if ($val_status === null && $val_ket === '') {
                        continue;
                    }

                    $data_insert[] = [
                        'ID_PPO'         => $id_ppo,
                        'ID_REF_SYARAT'  => $id_ref,
                        'STATUS'         => $val_status, // Y / T / NULL
                        // 'KETERANGAN'     => $ket[$id_ref] ?? null
                        'KETERANGAN'    => $val_ket
                    ];
                }

                if (!empty($data_insert)) {
                    $this->db->insert_batch('PST_TOOL_DTL_PNLT', $data_insert);
                }
            }


            //// delete tahun dulu takut nyangkut wkwk
            $this->db->delete('PST_THN_TOOL_OL', ['DOC_ID' => $id_ppo]);
            //// insert tahun 
            for($i=$thn_awal; $i<=$thn_akhir; $i++) {
                $dt_thn_mutasi = array(
                    'DOC_ID' => $id_ppo,
                    'TAHUN' => $i,
                    'JENIS' => 2
                );

                $this->pembetulan_model->insert_thn_online($dt_thn_mutasi);
            }

            //// update tracking
            $sql_tracking = "UPDATE TRACKING SET KET_ARSIP=(SELECT NAMA FROM CLAPPPDN WHERE KODE='N'), 
            CL_APP_PDN='N', UPDATETIME=SYSDATE 
            WHERE THN_PELAYANAN||BUNDEL_PELAYANAN||NO_URUT_PELAYANAN IN 
            (SELECT THN_PELAYANAN||BUNDEL_PELAYANAN||NO_URUT_PELAYANAN FROM PST_PERMOHONAN_TOOL WHERE ID = {$id_ppo}) ";

            $error_msg_2 = $this->db->simple_qry_eon_ora($sql_tracking);
            $err_Msg_2 = $error_msg_2['message'];

            // $err_Msg_2 = null;
            if (!empty($err_Msg_2)) {
                $error_CRUD = $err_Msg_2 . ', Proses Approve Pendanil gagal....!!!';
                $res_msg    = $error_CRUD;
                $res_code   = 500;
            } else {
                $res_msg    = 'Data berhasil diapprove pendanil';
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
                'redirect' => active_module_url('pdl_pembetulan')
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

        $ket_verlap     = strtoupper($this->input->post('ket_verlap'));
        $rekom_verlap   = strtoupper($this->input->post('rekom_verlap'));

        $proses_pk      = strtoupper($this->input->post('proses_pk'));
        $analisa_pk     = strtoupper($this->input->post('analisa_pk'));
        $keterangan_pk  = strtoupper($this->input->post('keterangan_pk'));
        $proses_pl      = strtoupper($this->input->post('proses_pl'));
        $analisa_pl     = strtoupper($this->input->post('analisa_pl'));
        $keterangan_pl  = strtoupper($this->input->post('keterangan_pl'));

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
        $qr_cek = "SELECT COUNT(*) AS JML FROM PST_PERMOHONAN_TOOL WHERE ID = ? AND STATUS_PERMOHONAN <> '4'";
        $cek_heula = $this->db->query($qr_cek, [$id_ppo])->row()->JML;

        if ($cek_heula > 0) {
            $this->session->set_flashdata('msg_info', "Data sudah diproses pendanil. Harap refresh halaman");

            echo json_encode([
                'result' => 302,
                'redirect' => active_module_url('pdl_pembetulan')
            ]);
            return;
        }

        $dt = $this->permohonan_online_upt_model->get_by_id($id_ppo);
        if ($dt){
            // $fim_l_verlap1 = empty($_FILES['im_l_verlap1']['name']) ? 0 : 1;
            // $fim_l_verlap2 = empty($_FILES['im_l_verlap2']['name']) ? 0 : 1;

            // $im_l_verlap1 = $fim_l_verlap1 == 0 ? NULL : file_get_contents($_FILES['im_l_verlap1']['tmp_name']);
            // $im_l_verlap2 = $fim_l_verlap2 == 0 ? NULL : file_get_contents($_FILES['im_l_verlap2']['tmp_name']);

            // if (!empty($_FILES['im_l_verlap1']['name']) || !empty($_FILES['im_l_verlap2']['name']) ) {
            //     $this->update_prm_blob($id_ppo);
            // }

            //paket generate nomer SK
            $tgl_sk = date('Y-m-d');
            $get_no_sk = $this->pembetulan_model->select_max_no_sk();
            $new_thn_sk = $get_no_sk['THN_SURAT'];
            $new_urut_sk = intval($get_no_sk['NO_URUT_SK']) + 1;
            $this->pembetulan_model->update_max_no_sk($new_thn_sk, $new_urut_sk);
            // closed paket generate nomer SK

            $ins_no_sk = '900.1.13/' . str_pad($new_urut_sk, 6, "0", STR_PAD_LEFT) . '/KPTS-PKP/' . bulan_romawi(date('m')) . '/' . $new_thn_sk;

            $dt_pst = array(
                'KET_VERLAP'        => $ket_verlap,
                'REKOM_VERLAP'      => $rekom_verlap,
                'NO_SK'             => $ins_no_sk,
                'TGL_SK'            => $tgl_sk,
                'URUT_SK'           => $new_urut_sk,
                'STATUS_PERMOHONAN' => 'C',
                'PROSES_PK'         => $proses_pk,
                'ANALISA_PK'        => $analisa_pk,
                'KETERANGAN_PK'     => $keterangan_pk,
                'PROSES_PL'         => $proses_pl,
                'ANALISA_PL'        => $analisa_pl,
                'KETERANGAN_PL'     => $keterangan_pl,
            );

            //// UPDATE DATA PST PERMOHONAN TOOL
            $this->pembetulan_model->update_pst_permohonan_tool($id_ppo, $dt_pst);

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


            //// delete tahun dulu takut nyangkut wkwk
            $this->db->delete('PST_THN_TOOL_OL', ['DOC_ID' => $id_ppo]);
            //// insert tahun 
            for($i=$thn_awal; $i<=$thn_akhir; $i++) {
                $dt_thn_mutasi = array(
                    'DOC_ID' => $id_ppo,
                    'TAHUN' => $i,
                    'JENIS' => 2
                );

                $this->pembetulan_model->insert_thn_online($dt_thn_mutasi);
            }

            //// update tracking
            $sql_tracking = "UPDATE TRACKING SET KET_ARSIP=(SELECT NAMA FROM CLAPPPDN WHERE KODE='Q'), 
            CL_APP_PDN='Q', UPDATETIME=SYSDATE 
            WHERE THN_PELAYANAN||BUNDEL_PELAYANAN||NO_URUT_PELAYANAN IN 
            (SELECT THN_PELAYANAN||BUNDEL_PELAYANAN||NO_URUT_PELAYANAN FROM PST_PERMOHONAN_TOOL WHERE ID = {$id_ppo}) ";

            $error_msg_2 = $this->db->simple_qry_eon_ora($sql_tracking);
            $err_Msg_2 = $error_msg_2['message'];

            // $err_Msg_2 = null;
            if (!empty($err_Msg_2)) {
                $error_CRUD = $err_Msg_2 . ', Proses Tolak Pendanil gagal....!!!';
                $res_msg    = $error_CRUD;
                $res_code   = 500;
            } else {
                $res_msg    = 'Data berhasil ditolak pendanil';
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
                'redirect' => active_module_url('pdl_pembetulan')
            ]);
            return;
        }

    }

    function save_data_subjek_pajak() {

        $id_ppo         = $this->input->post('id_ppo');
        $ktp_wp         = $this->input->post('ktp_wp');
        $nama_wp        = $this->input->post('nama_wp');
        $jalan_wp       = $this->input->post('jalan_wp');
        $blok_wp        = $this->input->post('blok_wp');
        $rt_wp          = $this->input->post('rt_wp');
        $rw_wp          = $this->input->post('rw_wp');
        $kelurahan_wp   = $this->input->post('kelurahan_wp');
        $kota_wp        = $this->input->post('kota_wp');
        $kodepos_wp     = $this->input->post('kodepos_wp');
        $hp_wp          = $this->input->post('hp_wp');
        $pekerjaan_wp   = $this->input->post('pekerjaan_wp');
        $email_wp       = $this->input->post('email_wp');
        $kd_sts_op      = $this->input->post('kd_sts_op');
        // $np_wp          = $this->input->post('np_wp');

        if ($id_ppo && $get = $this->pembetulan_model->getdt_tbl_mutasi_habis($id_ppo, 'DAT_SUBJEK_PAJAK_ONLINE')) {

            // update data MUT_DAT_SUBJEK_PAJAK_OL
            $sql = " BEGIN
                        begin 
                            UPDATE DAT_SUBJEK_PAJAK_ONLINE SET  
                                SUBJEK_PAJAK_ID = '{$ktp_wp}', NM_WP = '{$nama_wp}', JALAN_WP = '{$jalan_wp}', BLOK_KAV_NO_WP = '{$blok_wp}', 
                                RW_WP = '{$rw_wp}', RT_WP = '{$rt_wp}', KELURAHAN_WP = '{$kelurahan_wp}', KOTA_WP = '{$kota_wp}', 
                                KD_POS_WP = '{$kodepos_wp}', HP_WP = '{$hp_wp}',
                                STATUS_PEKERJAAN_WP = '{$pekerjaan_wp}', EMAIL_WP = '{$email_wp}'
                            WHERE DOCH_ID = {$id_ppo} ; 
                            EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                        end; 
                        begin 
                            UPDATE DAT_OBJEK_PAJAK_ONLINE SET KD_STATUS_WP = '{$kd_sts_op}'
                            WHERE DOCH_ID = {$id_ppo} ; 
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
                echo 'Berhasil Simpan Data Subjek Pajak';
            }

        } else {
            echo 'ERROR.. Data tidak ditemukan... silakan muat ulang halaman';
        }

    }

    function save_data_objek_pajak() {

        $id_ppo         = $this->input->post('id_ppo');
        $ktp_wp         = $this->input->post('ktp_wp');
        $jalan_op       = $this->input->post('jalan_op');
        $blok_op        = $this->input->post('blok_op');
        $rt_op          = $this->input->post('rt_op');
        $rw_op          = $this->input->post('rw_op');
        $jns_tanah_op   = $this->input->post('jns_tanah_op');
        $luas_bumi      = $this->input->post('luas_bumi');
        $kd_znt_op      = $this->input->post('kd_znt_op');

        //// CEK DAT OP BUMI
        if ($id_ppo && $get = $this->pembetulan_model->getdt_tbl_mutasi_habis($id_ppo, 'DAT_OBJEK_PAJAK_ONLINE')) {

            $dtppo = $this->permohonan_online_upt_model->get_by_id($id_ppo);

            $spop = $dtppo->NO_PLY;
            $nip_pencetak = sipkd_user_nip();

            // update data MUT_DAT_OBJEK_PAJAK_OL
            $sql = " BEGIN
                        begin 
                        UPDATE DAT_OBJEK_PAJAK_ONLINE SET  
                            SUBJEK_PAJAK_ID = '{$ktp_wp}', JALAN_OP = '{$jalan_op}', BLOK_KAV_NO_OP = '{$blok_op}', RW_OP = '{$rw_op}', 
                            RT_OP = '{$rt_op}', TOTAL_LUAS_BUMI = {$luas_bumi},
                            NO_FORMULIR_SPOP = '$spop', TGL_PENDATAAN_OP = SYSDATE, NIP_PENDATA =  '$nip_pencetak',
                            TGL_PEMERIKSAAN_OP = SYSDATE, NIP_PEMERIKSA_OP = '$nip_pencetak',
                            TGL_PEREKAMAN_OP = SYSDATE, NIP_PEREKAM_OP = '$nip_pencetak'
                        WHERE DOCH_ID = {$id_ppo} ; 
                        EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                        end; ";
            
            //// CEK DAT OP BUMI
            if ($this->pembetulan_model->getdt_tbl_mutasi_habis($id_ppo, 'DAT_OP_BUMI_ONLINE')) {

                // update data MUT_DAT_OP_BUMI_OL
                $sql .= " 
                        begin 
                        UPDATE DAT_OP_BUMI_ONLINE SET  
                            KD_ZNT = '{$kd_znt_op}', LUAS_BUMI = {$luas_bumi}, JNS_BUMI = '{$jns_tanah_op}'
                        WHERE DOCH_ID = {$id_ppo} ; 
                        EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                        end; ";
            }
               
            $sql .= " COMMIT;
                      END; ";
            // echo $sql; die();
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

    function hitung_njop_bumi() {
        $id_ppo             = $this->input->post('id_ppo');
        $luas_bumi          = $this->input->post('luas_bumi');
        $jns_bumi           = $this->input->post('jns_bumi');
        $kd_znt             = $this->input->post('kd_znt');
        $paramm             = $this->input->post('paramm');
        $thn_ply            = $this->input->post('thn_ply');

        $prop_kd = substr($paramm, 0, 2);
        $kab_kd  = substr($paramm, 2, 2);
        $kec_kd  = substr($paramm, 4, 3);
        $kel_kd  = substr($paramm, 7, 3);
        $blok_kd = substr($paramm, 10, 3);
        $urut_no = substr($paramm, 13, 4);
        $jns_kd  = substr($paramm, 17, 1);

        $usr = sipkd_user_id();

        // //HIST DOP
        // $this->sp_hist('DAT_OBJEK_PAJAK_ONLINE', $id_ppo, $usr, 2);

        // //HIST DOB
        // $this->sp_hist('DAT_OP_BUMI_ONLINE', $id_ppo, $usr, 2);
        // // $this->db->query($qry2);

        $qry3 = "UPDATE MUT_DAT_OP_BUMI_OL SET LUAS_BUMI = {$luas_bumi},
                 KD_ZNT = '{$kd_znt}', JNS_BUMI = '{$jns_bumi}'
                 WHERE DOCH_ID = {$id_ppo} AND KD_PROPINSI = '{$prop_kd}' AND KD_DATI2 = '{$kab_kd}' AND KD_KECAMATAN = '{$kec_kd}'
                 AND KD_KELURAHAN = '{$kel_kd}' AND KD_BLOK = '{$blok_kd}' AND NO_URUT = '{$urut_no}' AND KD_JNS_OP = '{$jns_kd}' ";
        $this->db->simple_qry_eon_ora($qry3);

        //// CALL SP 
        $data_sp = $this->sp_penentuan_njop_bumi($prop_kd,$kab_kd,$kec_kd,$kel_kd,$blok_kd,$urut_no,$jns_kd,$thn_ply,$id_ppo);

        // echo $data_sp; die();
        $data = $this->pembetulan_model->get_njop_online_by_idppo($id_ppo);
        echo json_encode($data);
    }

    function hitung_njop_bng() {
        $id_ppo             = $this->input->post('id_ppo');
        $paramm             = $this->input->post('paramm');
        $thn_ply            = $this->input->post('thn_ply');

        $prop_kd = substr($paramm, 0, 2);
        $kab_kd  = substr($paramm, 2, 2);
        $kec_kd  = substr($paramm, 4, 3);
        $kel_kd  = substr($paramm, 7, 3);
        $blok_kd = substr($paramm, 10, 3);
        $urut_no = substr($paramm, 13, 4);
        $jns_kd  = substr($paramm, 17, 1);

        $usr = sipkd_user_id();

        //HIST DOP
        // $this->sp_hist('DAT_OBJEK_PAJAK_ONLINE', $id_ppo, $usr, 2);

        /// CALL SP 
        $data_sp = $this->sp_penentuan_njop_bng($prop_kd,$kab_kd,$kec_kd,$kel_kd,$blok_kd,$urut_no,$jns_kd,$thn_ply,$id_ppo);

        // log_message('error', 'zzzzzzzzzzzzzz : '.$data_sp);  

        $data = $this->pembetulan_model->get_njop_online_by_idppo($id_ppo);
        echo json_encode($data);
    }

    function sp_penentuan_njop_bumi($prop_kd,$kab_kd,$kec_kd,$kel_kd,$blok_kd,$urut_no,$jns_kd,$thn_ply,$id_ppo){
        $dbhost = DB_HOST;
        $dbport = DB_PORT;
        $dbname = DB_NAME;
        $dbuser = DB_USER;
        $dbpass = DB_PASS;
        $tnslistener = '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=' . $dbhost . ')(PORT=' . $dbport . '))(CONNECT_DATA=(SID=' . $dbname . ')))';
        $conn = oci_connect($dbuser, $dbpass, $tnslistener);
            
        // $conn = oci_connect('SCOTT','TIGER') or die;
 
        $sql = 'BEGIN PENENTUAN_NJOP_BUMI_OL(:PARAM_0, :PARAM_1, :PARAM_2, :PARAM_3, :PARAM_4, :PARAM_5, :PARAM_6, :PARAM_7, :PARAM_8, :PARAM_9, :PARAM_10, :NILAI_OUT); END;';
        
        $stmt = oci_parse($conn,$sql);

        $p1    = $prop_kd;
        $p2    = $kab_kd;
        $p3    = $kec_kd;
        $p4    = $kel_kd;
        $p5    = $blok_kd;
        $p6    = $urut_no;
        $p7    = $jns_kd;
        $p8    = $thn_ply;
        $p9    = '03';
        $p10   = 1;

        // Bind the input parameter
        oci_bind_by_name($stmt, ':PARAM_0', $id_ppo, 200);
        oci_bind_by_name($stmt, ':PARAM_1', $p1, 200);
        oci_bind_by_name($stmt, ':PARAM_2', $p2, 200);
        oci_bind_by_name($stmt, ':PARAM_3', $p3, 200);
        oci_bind_by_name($stmt, ':PARAM_4', $p4, 200);
        oci_bind_by_name($stmt, ':PARAM_5', $p5, 200);
        oci_bind_by_name($stmt, ':PARAM_6', $p6, 200);
        oci_bind_by_name($stmt, ':PARAM_7', $p7, 200);
        oci_bind_by_name($stmt, ':PARAM_8', $p8, 200);
        oci_bind_by_name($stmt, ':PARAM_9', $p9, 200);
        oci_bind_by_name($stmt, ':PARAM_10',$p10, 200);

        // Bind the output parameter
        oci_bind_by_name($stmt,':NILAI_OUT',$message,32);
        
        // Execute the statement but do not commit
        oci_execute($stmt, OCI_DEFAULT);
        
        // Everything OK so commit
        oci_commit($conn);
        return $message;
    }

    function sp_penentuan_njop_bng($prop_kd,$kab_kd,$kec_kd,$kel_kd,$blok_kd,$urut_no,$jns_kd,$thn_ply,$id_ppo){
        $dbhost = DB_HOST;
        $dbport = DB_PORT;
        $dbname = DB_NAME;
        $dbuser = DB_USER;
        $dbpass = DB_PASS;
        $tnslistener = '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=' . $dbhost . ')(PORT=' . $dbport . '))(CONNECT_DATA=(SID=' . $dbname . ')))';
        $conn = oci_connect($dbuser, $dbpass, $tnslistener);
            
        // $conn = oci_connect('SCOTT','TIGER') or die;
 
        $sql = 'BEGIN PENENTUAN_NJOP_BNG_OL(:PARAM_0, :PARAM_1, :PARAM_2, :PARAM_3, :PARAM_4, :PARAM_5, :PARAM_6, :PARAM_7, :PARAM_8, :PARAM_9, :PARAM_10, :NILAI_OUT); END;';

        $stmt = oci_parse($conn,$sql);

        $p1    = $prop_kd;
        $p2    = $kab_kd;
        $p3    = $kec_kd;
        $p4    = $kel_kd;
        $p5    = $blok_kd;
        $p6    = $urut_no;
        $p7    = $jns_kd;
        $p8    = $thn_ply;
        $p9    = '03';
        $p10   = 1;

        // Bikin string untuk log dengan memunculkan nilai dari parameternya
        $log_query = "BEGIN PENENTUAN_NJOP_BNG_OL('$id_ppo', '$p1', '$p2', '$p3', '$p4', '$p5', '$p6', '$p7', '$p8', '$p9', $p10, :NILAI_OUT); END;";
        
        // Eksekusi penulisan log (Sesuaikan dengan fungsi framework, misalnya log_message di CI atau Log::info di Laravel)
        log_message('info', 'Eksekusi SP Penentuan NJOP BNG: ' . $log_query);

        // Bind the input parameter
        oci_bind_by_name($stmt, ':PARAM_0', $id_ppo, 200);
        oci_bind_by_name($stmt, ':PARAM_1', $p1, 200);
        oci_bind_by_name($stmt, ':PARAM_2', $p2, 200);
        oci_bind_by_name($stmt, ':PARAM_3', $p3, 200);
        oci_bind_by_name($stmt, ':PARAM_4', $p4, 200);
        oci_bind_by_name($stmt, ':PARAM_5', $p5, 200);
        oci_bind_by_name($stmt, ':PARAM_6', $p6, 200);
        oci_bind_by_name($stmt, ':PARAM_7', $p7, 200);
        oci_bind_by_name($stmt, ':PARAM_8', $p8, 200);
        oci_bind_by_name($stmt, ':PARAM_9', $p9, 200);
        oci_bind_by_name($stmt, ':PARAM_10',$p10, 200);

        // Bind the output parameter
        oci_bind_by_name($stmt,':NILAI_OUT',$message,32);
        
        // Execute the statement but do not commit
        oci_execute($stmt, OCI_DEFAULT);
        
        // Everything OK so commit
        oci_commit($conn);
        return $message;
    }

    function delete_dtl_bng() {
        $id_op_bng = $this->uri->segment(4);
        if ($id_op_bng && $get = $this->pembetulan_model->get_dtl_bng_ol($id_op_bng)) {
            $sql = " BEGIN ";

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
            
            $sql .= "
                    begin 
                    DELETE FROM DAT_FASILITAS_BANGUNAN_ONLINE WHERE DOCD_ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; ";
            
            $sql .= "
                    begin 
                    DELETE FROM DAT_NILAI_INDIVIDU_ONLINE WHERE DOCD_ID = {$id_op_bng}
                    ; EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); end; ";
            
            $sql .= "   
                    begin 
                    DELETE FROM DAT_OP_BANGUNAN_ONLINE WHERE ID = {$id_op_bng}
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

    function delete_dtl_fas_bng() {
        $id_fasilitas = $this->uri->segment(4);
        if ($id_fasilitas ) {
            $sql = " BEGIN ";

            $sql .= "
                    begin 
                        DELETE FROM DAT_FASILITAS_BANGUNAN_ONLINE WHERE ID = {$id_fasilitas} ; 
                        EXCEPTION WHEN OTHERS THEN Raise_application_error(-20005,SQLCODE||' error '||SQLERRM); 
                    end; ";
            
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

    function get_dtl_bng() {
        $id_dtl = $this->uri->segment(4);
        $data = $this->permohonan_online_upt_model->get_dtl_bng($id_dtl);
        echo json_encode($data);
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

    function sp_hist($kd_prop, $kd_dati2, $kd_kec, $kd_kel, $kd_blok, $no_urut, $kd_jns_op, $thn_pjk_sppt, $nopel_lkp) {
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
        $p9    = 2;
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

    function btn_file($field, $id_ppo) { 
        $url = active_module_url() . 'pdl_pembetulan/openblob_permo/' . $field . '/' . $id_ppo;
        $btn = '<a target="_blank" href="' . $url . '" class="btn btn-primary " data-toggle="tooltip" title="View"></i> Lihat File</a>';
        return $btn;
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

    function cetak_analisa_pembetulan(){
        $rpt = 'sk_pembetulan_pendanil';
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


}
