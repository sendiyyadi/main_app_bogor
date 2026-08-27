<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class spop_lspop extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!is_login()) {
            echo "<script>window.location.replace('" . base_url() . "');</script>";
            exit;
        }

        $module = 'spop_lspop';
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

        $data['page_menu'] = 'penetapan';
        $data['current'] = 'spop_lspop';
        $data['apps']    = $this->apps_model->get_active_only();
        $option = array( 
            'H' => 'Belum Proses',
            'B' => 'Approve Verifikasi Penetapan',);
        $js  = 'id="status_kd" class="form-control" ';
        $select = form_dropdown('status_kd', $option, '' , $js);
        $data['select_status_kd'] = $select;
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


        $this->load->view('vspop_lspop', $data);
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

        $data['page_menu'] = 'penetapan';
        $data['current'] = 'spop_lspop';
        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = '';
        
        $dt = $this->permohonan_online_upt_model->get_dt_spop_lspop($param);

        if ($dt){

            $kd_prop    = $dt->KD_PROPINSI;
            $kd_dati2   = $dt->KD_DATI2;
            $kd_kec     = $dt->KD_KECAMATAN;
            $kd_kel     = $dt->KD_KELURAHAN;
            $kd_blok    = $dt->KD_BLOK;
            $no_urut    = $dt->NO_URUT;
            $kd_jns_op  = $dt->KD_JNS_OP;

            $data['dt'] = array(
                'rowid' => $dt->NOP, 
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
                'no_formulir' => $dt->NO_FORMULIR_SPOP,
                'no_persil' => $dt->NO_PERSIL,

                'kec_op' => $dt->KECAMATAN_OP,
                'kel_op' => $dt->KELURAHAN_OP,

                //// IDENTITAS PENDATA OP
                'nip_pendata' => $dt->NIP_PENDATA,
                'nip_pemeriksa' => $dt->NIP_PEMERIKSA_OP,
                'nip_perekam' => $dt->NIP_PEREKAM_OP,
                'tgl_pendata' => $dt->TGL_PENDATAAN_OP,
                'tgl_pemeriksa' => $dt->TGL_PEMERIKSAAN_OP,
                'tgl_perekam' => $dt->TGL_PEREKAMAN_OP,

            );

            $data['da'] = (array)$dt;

            $data['fnopnik'] = $dt->NOPNIK;

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

            $this->load->view('vspop_lspop_form', $data);

        } else {
            $this->session->set_flashdata('msg_error', 'Data tidak ditemukan..');
            redirect(active_module_url('spop_lspop'));
        }

    }

    function get_dtl_bng() {
        $id_dtl = $this->uri->segment(4);
        $data = $this->permohonan_online_upt_model->get_dtl_bng($id_dtl);
        echo json_encode($data);
    }


}
