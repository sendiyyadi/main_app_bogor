<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class pnt_mutasi_habis extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!is_login()) {
            echo "<script>window.location.replace('" . base_url() . "');</script>";
            exit;
        }

        $module = 'pnt_mutasi_habis';
        $this->load->library('module_auth', array(
            'module' => $module
        ));

        $this->load->model(array(
            'apps_model', 'mutasi_habis_model', 'permohonan_online_upt_model'
        ));

        $this->load->helper(active_module());
    }

    public function index() {
        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect('tool_pbb');
        }

        $data['page_menu'] = 'penetapan';
        $data['current'] = 'pnt_mutasi_habis';
        $data['apps']    = $this->apps_model->get_active_only();
        $option = array( 
            'B' => 'Belum Proses',
            '5' => 'Approve Penetapan',);
        $js  = 'id="status_kd" class="form-control" ';
        $select = form_dropdown('status_kd', $option, '' , $js);
        $data['select_status_kd'] = $select;
        //------------------------------------------------------------------
        $select_data  = $this->mutasi_habis_model->get_jns_ply();
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


        $this->load->view('vpnt_mutasi_habis', $data);
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
                                    TO_CHAR(P.TGL_VER_PNTP,'DD-MM-YYYY') as TGL_APR,
                                    P.KD_PROPINSI_PEMOHON||P.KD_DATI2_PEMOHON||P.KD_KECAMATAN_PEMOHON||P.KD_KELURAHAN_PEMOHON||P.KD_BLOK_PEMOHON||P.NO_URUT_PEMOHON||P.KD_JNS_OP_PEMOHON AS NOP, 
                                    RP.NM_JENIS_PELAYANAN, P.NAMA_PEMOHON, KEC.NM_KECAMATAN, KEL.NM_KELURAHAN,
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

        $this->datatables->where("P.KD_JNS_PELAYANAN", "02");
        // $this->datatables->where("P.STATUS_PERMOHONAN IN ('A', '5')");

        $nip_login = sipkd_user_nip();
        if(!is_super_admin()) {
            $this->datatables->where("P.NIP_BID_PNPT", $nip_login);
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
            $this->datatables->where("TO_DATE(TO_CHAR(P.TGL_VER_PNTP,'yyyy-mm-dd'), 'yyyy-mm-dd') >= TO_DATE('".$tgl_fr."', 'dd-mm-yyyy')");
        }

        if(!empty($tgl_to)){
            $this->datatables->where("TO_DATE(TO_CHAR(P.TGL_VER_PNTP,'yyyy-mm-dd'), 'yyyy-mm-dd') <= TO_DATE('".$tgl_to."', 'dd-mm-yyyy')");
        }

        if(!empty($sts_kd)){
            $this->datatables->where("P.STATUS_PERMOHONAN", $sts_kd);
        } else {
            $this->datatables->where("P.STATUS_PERMOHONAN IN ('B')");
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

    //     if ($this->mutasi_habis_model->cek_nop($nop)) {
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
        $param     = $this->uri->segment(4);

        $data['page_menu'] = 'penetapan';
        $data['current'] = 'pnt_mutasi_habis';
        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = active_module_url("permohonan_online_upt/update/{$param}");
        
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
            $get_select_kd_znt = $this->mutasi_habis_model->select_znt($dt->KD_PROPINSI, $dt->KD_DATI2, $dt->KD_KECAMATAN, $dt->KD_KELURAHAN, $dt->KD_BLOK);
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

            $dt_thn = $this->permohonan_online_upt_model->get_dt_thn_ol($dt->PPO_ID, 1);
            $data['dt']['tahun_awal'] = !empty($dt_thn->TAHUN_MIN) ? get_string($dt_thn->TAHUN_MIN) : date('Y');
            $data['dt']['tahun_akhir'] = !empty($dt_thn->TAHUN_MAX) ? get_string($dt_thn->TAHUN_MAX) : date('Y');

            $this->load->view('vpnt_mutasi_habis_form', $data);

        } else {
            $this->session->set_flashdata('msg_error', 'Data tidak ditemukan..');
            redirect(active_module_url('pnt_mutasi_habis'));
        }

    }

    public function edit() {
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_error', $this->module_auth->msg_read);
            redirect('tool_pbb');
        }

        $param     = $this->uri->segment(4);

        //// cek heula
        $qr_cek = "SELECT COUNT(*) AS JML FROM PST_PERMOHONAN_TOOL WHERE ID = ? AND STATUS_PERMOHONAN <> 'B'";
        $cek_heula = $this->db->query($qr_cek, [$param])->row()->JML;

        if ($cek_heula > 0) {
            $this->session->set_flashdata('msg_info', "Data sudah ditetapkan. Tidak bisa edit data");
            redirect('tool_pbb/pnt_mutasi_habis');
        }

        $data['page_menu'] = 'penetapan';
        $data['current'] = 'pnt_mutasi_habis';
        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = active_module_url("permohonan_online_upt/update/{$param}");
        
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
            $get_select_kd_znt = $this->mutasi_habis_model->select_znt($dt->KD_PROPINSI, $dt->KD_DATI2, $dt->KD_KECAMATAN, $dt->KD_KELURAHAN, $dt->KD_BLOK);
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

            $dt_thn = $this->permohonan_online_upt_model->get_dt_thn_ol($dt->PPO_ID, 1);
            $data['dt']['tahun_awal'] = !empty($dt_thn->TAHUN_MIN) ? get_string($dt_thn->TAHUN_MIN) : date('Y');
            $data['dt']['tahun_akhir'] = !empty($dt_thn->TAHUN_MAX) ? get_string($dt_thn->TAHUN_MAX) : date('Y');

            $this->load->view('vpnt_mutasi_habis_form', $data);

        } else {
            $this->session->set_flashdata('msg_error', 'Data tidak ditemukan..');
            redirect(active_module_url('pnt_mutasi_habis'));
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
        $nip_pencetak   = sipkd_user_nip();

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
        $qr_cek = "SELECT COUNT(*) AS JML FROM PST_PERMOHONAN_TOOL WHERE ID = ? AND STATUS_PERMOHONAN <> 'B'";
        $cek_heula = $this->db->query($qr_cek, [$id_ppo])->row()->JML;

        if ($cek_heula > 0) {
            $this->session->set_flashdata('msg_info', "Data sudah diaprove. Harap refresh halaman");

            echo json_encode([
                'result' => 302,
                'redirect' => active_module_url('pnt_mutasi_habis')
            ]);
            return;
        }

        $dt = $this->permohonan_online_upt_model->get_by_id($id_ppo);
        if ($dt){
            $nopel_lkp = $dt->NO_PLY;
            //// delete tahun dulu takut nyangkut wkwk
            $this->db->delete('PST_THN_TOOL_OL', ['DOC_ID' => $id_ppo]);
            //// insert tahun 
            for($i=$thn_awal; $i<=$thn_akhir; $i++) {
                $dt_thn_mutasi = array(
                    'DOC_ID' => $id_ppo,
                    'TAHUN' => $i,
                    'JENIS' => 1
                );

                $this->mutasi_habis_model->insert_thn_online($dt_thn_mutasi);
            }

            //// insert history phist
            $this->sp_hist($prop_kd, $kab_kd, $kec_kd, $kel_kd, $blok_kd, $urut_no, $jns_kd, $thn_permo, $nopel_lkp);

            //// CALL SP PENETAPAN TO INSERT DATA OBJEK PAJAK 
            $qry1 = "CALL SP_PNT_MH_OL({$id_ppo}, '{$nip_pencetak}') ";
            $error_1 = $this->db->simple_qry_eon_ora($qry1);
            $err_Msg_1 = $error_1['message'];

            // $err_Msg_1 = null;
            if (!empty($err_Msg_1)) {
                $error_CRUD = $err_Msg_1 . ', Proses Penetapan gagal....!!!';
                $res_msg    = $error_CRUD;
                $res_code   = 500;
            } else {

                //// update tracking
                $sql_tracking = "UPDATE TRACKING SET TGL_VER_KEB=SYSDATE, KET_ARSIP=(SELECT NAMA FROM CLAPPPDN WHERE KODE='L'), 
                CL_APP_PDN='L', UPDATETIME=SYSDATE 
                WHERE THN_PELAYANAN||BUNDEL_PELAYANAN||NO_URUT_PELAYANAN IN 
                (SELECT THN_PELAYANAN||BUNDEL_PELAYANAN||NO_URUT_PELAYANAN FROM PST_PERMOHONAN_TOOL WHERE ID = {$id_ppo}) ";

                $error_msg_2 = $this->db->simple_qry_eon_ora($sql_tracking);
                $err_Msg_2 = $error_msg_2['message'];

                // $err_Msg_2 = null;
                if (!empty($err_Msg_2)) {
                    $error_CRUD = $err_Msg_2 . ', Proses Penetapan gagal....!!!';
                    $res_msg    = $error_CRUD;
                    $res_code   = 500;
                } else {
                    //// Kirim Email
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
                        'smtp_crypto' => SMTP_CRYPTO,
                    );  

                    $d_today        = date('d-m-Y');
                    $d_ket          = strtoupper($this->input->post('keterangan'));
                    $d_nik          = $this->input->post('nik_wp_sppt');
                    $d_nm_wp_sppt   = strtoupper($this->input->post('nm_wp_sppt'));
                    $d_no_ply       = $this->input->post('nopel');
                    $d_tgl_kirim    = $this->input->post('tgl_permohonan');
                    $d_email        = $dt->EMAIL_REG;
                    $d_nm_jns_ply   = $dt->NM_JENIS_PELAYANAN;

                    $message = '
                            <html>
                            <head>
                                <title>Pemberitahuan Penetapan Permohonan PBB Online - Kabupaten Bogor</title>
                            </head>
                            <body style="font-family: Arial, sans-serif; background-color: #f6f9fc; margin: 0; padding: 20px;">
                                <table align="center" cellpadding="0" cellspacing="0" width="600"
                                    style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                                    
                                    <!-- Header -->
                                    <tr>
                                        <td style="background-color: #2b8a3e; padding: 16px; border-radius: 8px 8px 0 0; text-align: center; color: #ffffff;">
                                            <h2 style="margin: 0;">PEMBERITAHUAN PENETAPAN PERMOHONAN PBB ONLINE</h2>
                                            <p style="margin: 6px 0 0 0; font-size: 14px;">Badan Pendapatan Daerah Kabupaten Bogor</p>
                                        </td>
                                    </tr>

                                    <!-- Content -->
                                    <tr>
                                        <td style="padding: 30px; color: #555; font-size: 15px;">
                                            <p>Hi, <strong>'.$d_nm_wp_sppt.'</strong></p>

                                            <p>
                                                Selamat, permohonan <strong>PBB Online</strong> Anda dengan rincian sebagai berikut:
                                            </p>

                                            <table cellpadding="0" cellspacing="0" width="100%" style="margin-top: 15px;">
                                                <tr>
                                                    <td width="35%">No Pelayanan</td>
                                                    <td width="5%">:</td>
                                                    <td><strong>'.$d_no_ply.'</strong></td>
                                                </tr>
                                                <tr>
                                                    <td width="35%">Jenis Pelayanan</td>
                                                    <td width="5%">:</td>
                                                    <td><strong>'.$d_nm_jns_ply.'</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>NIK</td>
                                                    <td>:</td>
                                                    <td>'.$d_nik.'</td>
                                                </tr>
                                                <tr>
                                                    <td>Tanggal Kirim Berkas</td>
                                                    <td>:</td>
                                                    <td>'.$d_tgl_kirim.'</td>
                                                </tr>
                                                <tr>
                                                    <td>Catatan</td>
                                                    <td>:</td>
                                                    <td>'.$d_ket.'</td>
                                                </tr>
                                            </table>

                                            <p style="margin-top: 20px;">
                                                <strong>Telah selesai ditetapkan.</strong>
                                            </p>

                                            <p>
                                                Untuk mendapatkan salinan <strong>SPPT</strong>, silakan download melalui Aplikasi
                                                <strong>E-PBB</strong> pada link berikut:
                                            </p>

                                            <p style="text-align: center; margin: 20px 0;">
                                                <a href="https://pbb.bogorkab.go.id/"
                                                   style="background-color: #2b8a3e; color: #ffffff; text-decoration: none;
                                                          padding: 12px 20px; border-radius: 5px; display: inline-block;">
                                                    Download SPPT E-PBB
                                                </a>
                                            </p>

                                            <p>
                                                Silakan login menggunakan <strong>user</strong> dan <strong>password</strong>
                                                yang sebelumnya telah didaftarkan.
                                            </p>

                                            <p>
                                                Terima kasih atas kepercayaan Anda menggunakan layanan PBB Online Kabupaten Bogor.
                                            </p>
                                        </td>
                                    </tr>

                                    <!-- Footer -->
                                    <tr>
                                        <td style="padding: 20px; text-align: center; font-size: 14px; color: #555;">
                                            <p style="margin: 0;">Cibinong, '.$d_today.'</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #f0f0f0; text-align: center; padding: 15px;
                                                   font-size: 13px; color: #999; border-radius: 0 0 8px 8px;">
                                            '.date('Y').' © Bappenda Kabupaten Bogor
                                        </td>
                                    </tr>

                                </table>
                            </body>
                            </html>';

                    $this->load->library('email', $config);
                    $this->email->set_newline("\r\n");
                    $this->email->from(SMTP_USER, SMTP_UNAME);
                    $this->email->to($d_email);
                    $this->email->subject('PENETAPAN PERMOHONAN NOMOR PELAYANAN '.$d_no_ply);
                    $this->email->message($message);
                        //sending email
                    if ($this->email->send()) {
                        $res_msg    = 'Data berhasil ditetapkan (Sukses Kirim Email)';
                        $res_code   = 200;
                    } else {
                        $res_msg    = 'Data berhasil ditetapkan (Gagal Kirim Email)';
                        $res_code   = 201;
                        // echo $this->email->print_debugger();
                    }

                }

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
                'redirect' => active_module_url('pnt_mutasi_habis')
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

        if ($id_ppo && $get = $this->mutasi_habis_model->getdt_tbl_mutasi_habis($id_ppo, 'DAT_SUBJEK_PAJAK_ONLINE')) {

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
                            UPDATE DAT_OBJEK_PAJAK_ONLINE SET SUBJEK_PAJAK_ID = '{$ktp_wp}', KD_STATUS_WP = '{$kd_sts_op}'
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
        if ($id_ppo && $get = $this->mutasi_habis_model->getdt_tbl_mutasi_habis($id_ppo, 'DAT_OBJEK_PAJAK_ONLINE')) {

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
            if ($this->mutasi_habis_model->getdt_tbl_mutasi_habis($id_ppo, 'DAT_OP_BUMI_ONLINE')) {

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
        $data = $this->mutasi_habis_model->get_njop_online_by_idppo($id_ppo);
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

        $data = $this->mutasi_habis_model->get_njop_online_by_idppo($id_ppo);
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
        $p9    = '02';
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
        $p9    = '02';
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

    function delete_dtl_bng() {
        $id_op_bng = $this->uri->segment(4);
        if ($id_op_bng && $get = $this->mutasi_habis_model->get_dtl_bng_ol($id_op_bng)) {
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
            'smtp_crypto' => SMTP_CRYPTO,
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

    function tolak_ke_pelayanan() {
        $p_id               = $this->input->post('id_ppo');
        $ket_tolak_ply      = strtoupper($this->input->post('ket_tolak_ply'));

        if ($p_id && $get = $this->permohonan_online_upt_model->get_ppo_by_id($p_id)) {
            $dt_pst = array(
                'STATUS_PERMOHONAN' => '4',
                'ALASAN'            => $ket_tolak_ply,
            );

            //// UPDATE DATA PST PERMOHONAN TOOL
            $this->permohonan_online_upt_model->update_pst_permohonan_tool($p_id, $dt_pst);

            //// update tracking
            $sql_tracking = "UPDATE TRACKING SET KET_ARSIP=(SELECT NAMA FROM CLAPPPDN WHERE KODE='M'), 
            CL_APP_PDN='M', UPDATETIME=SYSDATE 
            WHERE THN_PELAYANAN||BUNDEL_PELAYANAN||NO_URUT_PELAYANAN IN 
            (SELECT THN_PELAYANAN||BUNDEL_PELAYANAN||NO_URUT_PELAYANAN FROM PST_PERMOHONAN_TOOL WHERE ID = {$p_id}) ";

            $error_msg_2 = $this->db->simple_qry_eon_ora($sql_tracking);
            $err_Msg_2 = $error_msg_2['message'];

            if (!empty($err_Msg_2)) {
                $error_CRUD = $err_Msg_2 . ', Proses gagal....!!!';
                echo $error_CRUD;
            } else {
                echo 'Penelitian Ulang dokumen berhasil dikirim ke verifikasi';
                // //// panggil send smtp di model wkwkwk
                // $mails = $this->permohonan_online_upt_model->send_email_tolak($p_id, $ket_tolak_ply);
                // if($mails) {
                //     echo 'Tolak data berhasil (Berhasil Kirim email ke WP)';
                // } else {
                //     echo 'Tolak data berhasil (Gagal Kirim email ke WP)';
                // }
            }

        } else {
            echo 'ERROR.. Data tidak ditemukan... silakan muat ulang halaman';
        }
    }


}
