<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class monitoring_permo_upt extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!is_login()) {
            echo "<script>window.location.replace('" . base_url() . "');</script>";
            exit;
        }

        $module = 'monitoring_permo_upt';
        $this->load->library('module_auth', array(
            'module' => $module
        ));

        $this->load->model(array(
            'apps_model', 'monitoring_permo_upt_model', 'permohonan_online_upt_model'
        ));

        $this->load->helper(active_module());
    }

    public function index() {
        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect('tool_pbb');
        }

        $data['page_menu'] = 'upt';
        $data['current'] = 'monitoring_permo_upt';
        $data['apps']    = $this->apps_model->get_active_only();
        $option = array( ''=> 'Semua Status','A' => 'Draft',
            '1' => 'Terima',
            '2' => 'Tolak');
        $js  = 'id="status_kd" style="width:130px;" class="form-control" ';
        $select = form_dropdown('status_kd', $option, '' , $js);
        $data['select_jns_ply'] = $select;
        //------------------------------------------------------------------
        $select_data  = $this->monitoring_permo_upt_model->get_jns_ply();
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


        $this->load->view('vmonitoring_permo_upt', $data);
    }

    public function grid() {

        $tgl_fr = $this->input->get('tgl_fr');
        $tgl_to = $this->input->get('tgl_to');
        $jns_ply = $this->input->get('jns_ply');
        $thn_ply = $this->input->get('thn_ply');
        $bundel_ply = $this->input->get('bundel_ply');
        $urut_ply = $this->input->get('urut_ply');
        $nop = $this->input->get('nop');

        $this->load->library('Datatables');
        $this->datatables->select("	P.ID, P.THN_PELAYANAN||'-'||P.BUNDEL_PELAYANAN||'-'||P.NO_URUT_PELAYANAN as NOPEL,
                                    P.KD_PROPINSI_PEMOHON||P.KD_DATI2_PEMOHON||P.KD_KECAMATAN_PEMOHON||P.KD_KELURAHAN_PEMOHON||P.KD_BLOK_PEMOHON||P.NO_URUT_PEMOHON||P.KD_JNS_OP_PEMOHON AS NOP, 
                                    RP.NM_JENIS_PELAYANAN, P.NAMA_PEMOHON, KEC.NM_KECAMATAN, KEL.NM_KELURAHAN,
                                    CASE WHEN P.STATUS_PERMOHONAN = '0' THEN 'Draft' 
                                    WHEN P.STATUS_PERMOHONAN = '1' THEN 'Kirim WP'
                                    WHEN P.STATUS_PERMOHONAN = '2' THEN 'Proses'
                                    WHEN P.STATUS_PERMOHONAN = '3' THEN 'Tolak Pemda'
                                    WHEN P.STATUS_PERMOHONAN = '4' THEN 'Diterima Pemda' END AS STS,
                                    P.THN_PELAYANAN||P.KD_PROPINSI_PEMOHON||P.KD_DATI2_PEMOHON||P.KD_KECAMATAN_PEMOHON||P.KD_KELURAHAN_PEMOHON||P.KD_BLOK_PEMOHON||P.NO_URUT_PEMOHON||P.KD_JNS_OP_PEMOHON||P.KD_JNS_PELAYANAN as NOPELNOP,
                                    P.STATUS_PERMOHONAN", false);
        $this->datatables->from("PST_PERMOHONAN_TOOL P");
        $this->datatables->join('REF_JNS_PELAYANAN RP', 'RP.KD_JNS_PELAYANAN = P.KD_JNS_PELAYANAN', 'left');
        $this->datatables->join('REF_KECAMATAN KEC', 'KEC.KD_KECAMATAN = P.KD_KECAMATAN_PEMOHON');
        $this->datatables->join('REF_KELURAHAN KEL', 'KEL.KD_KECAMATAN = P.KD_KECAMATAN_PEMOHON AND KEL.KD_KELURAHAN = P.KD_KELURAHAN_PEMOHON');

        if($jns_ply <> '999999' && !empty($jns_ply)){
            $this->datatables->where('P.KD_JNS_PELAYANAN', $jns_ply);
        }else{
            $this->datatables->where("P.KD_JNS_PELAYANAN IN ('02', '03')");
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
            $this->datatables->where("TO_DATE(TO_CHAR(P.TGL_SURAT_PERMOHONAN,'yyyy-mm-dd'), 'yyyy-mm-dd') >= TO_DATE('".$tgl_fr."', 'dd-mm-yyyy')");
        }

        if(!empty($tgl_to)){
            $this->datatables->where("TO_DATE(TO_CHAR(P.TGL_SURAT_PERMOHONAN,'yyyy-mm-dd'), 'yyyy-mm-dd') <= TO_DATE('".$tgl_to."', 'dd-mm-yyyy')");
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

    // public function cek_nop($value) {
    //     $nop = $this->input->post('nop');

    //     if ($this->monitoring_permo_upt_model->cek_nop($nop)) {
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
            $this->session->set_flashdata('msg_danger', $this->module_auth->msg_read);
            redirect('tool_pbb');
        }

        $param     = $this->uri->segment(4);

        // //// cek heula
        // $qr_cek = "SELECT COUNT(*) AS JML FROM PST_PERMOHONAN_TOOL WHERE ID = ? AND STATUS_PERMOHONAN = 1";
        // $cek_heula = $this->db->query($qr_cek, [$param])->row()->JML;

        // if ($cek_heula > 0) {
        //     $this->session->set_flashdata('msg_info', "Data sudah dikirim. Tidak bisa edit data");
        //     redirect('tool_pbb/monitoring_permo_upt');
        // }

        $data['page_menu'] = 'upt';
        $data['current'] = 'monitoring_permo_upt';
        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = '';
        
        $dt = $this->permohonan_online_upt_model->get_by_id($param);

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

            $this->load->view('vpermohonan_online_upt_dtlform', $data);

        } else {
            $this->session->set_flashdata('msg_danger', 'Data tidak ditemukan..');
            redirect(active_module_url('permohonan_online_upt'));
        }

    }

    public function edit() {
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_danger', $this->module_auth->msg_read);
            redirect('tool_pbb');
        }

        $param     = $this->uri->segment(4);

        //// cek heula
        $qr_cek = "SELECT COUNT(*) AS JML FROM PST_PERMOHONAN_TOOL WHERE ID = ? AND STATUS_PERMOHONAN = 1";
        $cek_heula = $this->db->query($qr_cek, [$param])->row()->JML;

        if ($cek_heula > 0) {
            $this->session->set_flashdata('msg_info', "Data sudah dikirim. Tidak bisa edit data");
            redirect('tool_pbb/monitoring_permo_upt');
        }

        $data['page_menu'] = 'upt';
        $data['current'] = 'monitoring_permo_upt';
        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = active_module_url("permohonan_online_upt/update/{$param}");
        
        $dt = $this->permohonan_online_upt_model->get_by_id($param);

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
            if ($dt->KD_JNS_PELAYANAN == '02') {
                $pekerjaan_wp = '';
            } else {
                $pekerjaan_wp = 'readonly';
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
                $sts_op = 'readonly';
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
        $qr_cek = "SELECT COUNT(*) AS JML FROM PST_PERMOHONAN_TOOL WHERE ID = ? AND STATUS_PERMOHONAN = 1";
        $cek_heula = $this->db->query($qr_cek, [$id_ppo])->row()->JML;

        if ($cek_heula > 0) {
            $this->session->set_flashdata('msg_info', "Data sudah dikirim. Tidak bisa edit data");
            redirect('tool_pbb/monitoring_permo_upt');
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
                L_SKKP_PBB1      = EMPTY_BLOB(),
                L_SPMKP_PBB1     = EMPTY_BLOB(),
                L_SURAT_KUASA1   = EMPTY_BLOB(),
                L_PERMOHONAN1    = EMPTY_BLOB(),
                L_STTS1          = EMPTY_BLOB(),
                L_SK_KEBERATAN1  = EMPTY_BLOB(),
                L_SPPT_STTS1     = EMPTY_BLOB(),
                L_KTP_WP1        = EMPTY_BLOB(),
                L_SERTIFIKAT_TANAH1 = EMPTY_BLOB(),
                L_IMB1           = EMPTY_BLOB(),
                L_AKTE_JUAL_BELI1 = EMPTY_BLOB(),
                L_SPPT1          = EMPTY_BLOB(),
                L_SK_PENGURANGAN1 = EMPTY_BLOB(),
                L_LAIN_LAIN1      = EMPTY_BLOB()
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
        $blob1->save($L_SKKP_PBB1);
        $blob2->save($L_SPMKP_PBB1);
        $blob3->save($L_SURAT_KUASA1);
        $blob4->save($L_PERMOHONAN1);
        $blob5->save($L_STTS1);
        $blob6->save($L_SK_KEBERATAN1);
        $blob7->save($L_SPPT_STTS1);
        $blob8->save($L_KTP_WP1);
        $blob9->save($L_SERTIFIKAT_TANAH1);
        $blob10->save($L_IMB1);
        $blob11->save($L_AKTE_JUAL_BELI1);
        $blob12->save($L_SPPT1);
        $blob13->save($L_SK_PENGURANGAN1);
        $blob14->save($L_LAIN_LAIN1);

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
            }

            if (empty($error_CRUD)) {
                $qr_ply     = $this->db->query("SELECT NM_JENIS_PELAYANAN FROM REF_JNS_PELAYANAN WHERE KD_JNS_PELAYANAN = '{$jns_ply}'");
                $nm_jns_ply = $qr_ply->row()->NM_JENIS_PELAYANAN;
                // return 1;
                $return_date->result       = 200;
                $return_date->msg          = 'Berhasil Simpan Draft Permohonan Online';
                $return_date->dtl_nop      = $nop;
                $return_date->dtl_nop_tx   = $nop_lkp;
                $return_date->dtl_ply      = $jns_ply;
                $return_date->dtl_ply_tx   = $nm_jns_ply;
                $return_date->dtl_thn_ply  = $thn_permohonan;
                $return_date->dtl_id_ppo   = $id_ppo;
            } else {
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

    public function appr_permo() {
        $id_ppo     = $this->uri->segment(4);

        $nop_kdply = $nop.$thn_ply.$kd_ply ;
        
        $simpan = $this->permohonan_online_upt_model->update_sts_permohonan($id_ppo);

        $getdt      = $this->permohonan_online_upt_model->get_prm_online($id_ppo);
        $nopel      = $getdt->NO_PLY;
        $nop_lkp    = $getdt->NOP_LKP;
        $jns_ply_tx = $getdt->NM_JENIS_PELAYANAN;
        $tgl_kirim  = $getdt->TGL_SURAT_PERMOHONAN;
        $ket        = $getdt->ALASAN;
        $email      = $getdt->EMAIL;
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
        $qq = "UPDATE PST_PERMOHONAN_TOOL SET {$fl_blob_impl}, {$tbl_field_impl} 
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


}
