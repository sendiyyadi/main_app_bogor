<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class appr_bsre extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_login()) {
            echo "<script>window.location.replace('" . base_url() . "');</script>";
            exit;
        }

        $module = 'appr_bsre';
        $this->load->library('module_auth', array(
            'module' => $module
        ));

        $this->load->model(array(
            'apps_model', 'appr_bsre_model'
        ));

        $this->load->helper(active_module());
    }

    public function index()
    {
        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect('eadm_bogor');
        }

        $data['page_menu'] = 'appr_bsre';
        $data['current'] = '';
        $data['apps']    = $this->apps_model->get_active_only();
        $option = array( ''=> 'Semua Status','A' => 'Draft',
            '1' => 'File BSRE Created');
        $js  = 'id="status_kd" style="width:130px;" class="form-control" ';
        $select = form_dropdown('status_kd', $option, '' , $js);
        $data['select_status'] = $select;
        $this->load->view('vappr_bsre', $data);
    }

    public function grid()
    {

       $status_kd = $this->input->get('status_kd');
       $tgl_start = date('Ymd',strtotime($this->input->get('tgl_start')));
       $tgl_end = date('Ymd',strtotime($this->input->get('tgl_end')));
        $this->load->library('Datatables');
        $this->datatables->select("ROW_NUMBER() OVER (ORDER BY KD_PROPINSI||'.'||KD_DATI2||'-'||KD_KECAMATAN||'.'||KD_KELURAHAN||'-'||KD_BLOK||'.'||NO_URUT||'.'||KD_JNS_OP) as nomer,
                                   NIK, KD_PROPINSI||'.'||KD_DATI2||'-'||KD_KECAMATAN||'.'||KD_KELURAHAN||'-'||KD_BLOK||'.'||NO_URUT||'.'||KD_JNS_OP AS NOPS, NAMA, NO_REG,
                                   CASE WHEN FLG_SPPT_BSRE=0 then 'Draft (0)' WHEN FLG_SPPT_BSRE=1 then 'File BSRE Created' END AS sts,
                                   STATUS_VERIF, TO_CHAR(CREATED_DATE,'DD-MM-YYYY') AS TGL_PERMOHONAN, created_date, KD_OTP_EMAIL", false);
        $this->datatables->from("REG_ESPPT RS");
        $this->datatables->join("SPPT SP", "RS.KD_PROPINSI = SP.KD_PROPINSI AND RS.KD_DATI2=SP.KD_DATI2 AND RS.KD_KECAMATAN=SP.KD_KECAMATAN AND
                                 RS.KD_KELURAHAN=SP.KD_KELURAHAN AND RS.KD_BLOK=SP.KD_BLOK AND RS.NO_URUT=SP.NO_URUT AND RS.KD_JNS_OP=SP.KD_JNS_OP", "");
        if(!empty($status_kd)){
            if($status_kd == 'A'){
                $status_kd = '0';
            }
            $this->datatables->where('FLG_SPPT_BSRE',$status_kd);
        }
        if(!empty($this->input->get('tgl_start'))){
         $this->datatables->where("CAST((TO_CHAR(CREATED_DATE,'YYYYMMDD')) AS NUMBER) >= {$tgl_start}");
        }
        if(!empty($this->input->get('tgl_end'))){
         $this->datatables->where("CAST((TO_CHAR(CREATED_DATE,'YYYYMMDD')) AS NUMBER) <= {$tgl_end}");
        }

        echo $this->datatables->generate();
    }

    private function fvalidation($jenis_appr_bsre = null)
    {
        if ($jenis_appr_bsre == 'approve') {
            $this->form_validation->set_error_delimiters('<span>', '</span>');
        }

        if ($jenis_appr_bsre == 'tolak') {
            $this->form_validation->set_error_delimiters('<span>', '</span>');
        }
    }

    private function fpost()
    {
        $data['rowid'] = post_string($this->input->post('rowid'));
        $data['nik'] = post_string($this->input->post('nik'));
        $data['nm_wp_sppt'] = post_string($this->input->post('nm_wp_sppt'));
        $data['nohp'] = post_string($this->input->post('nohp'));
        $data['email'] = post_string($this->input->post('email'));
        $data['loginname'] = post_string($this->input->post('loginname'));
        // $data['jln_wp_sppt'] = post_string($this->input->post('jln_wp_sppt'));
        // $data['blok_kav_no_wp_sppt'] = post_string($this->input->post('blok_kav_no_wp_sppt'));
        // $data['rt_wp_sppt'] = post_string($this->input->post('rt_wp_sppt'));
        // $data['rw_wp_sppt'] = post_string($this->input->post('rw_wp_sppt'));
        // $data['kelurahan_wp_sppt'] = post_string($this->input->post('kelurahan_wp_sppt'));
        // $data['kota_wp_sppt'] = post_string($this->input->post('kota_wp_sppt'));
        // $data['kd_pos_wp_sppt'] = post_string($this->input->post('kd_pos_wp_sppt'));
        // $data['npwp'] = post_string($this->input->post('npwp'));
        // $data['jln_op_sppt'] = post_string($this->input->post('jln_op_sppt'));
        // $data['blok_kav_no_op_sppt'] = post_string($this->input->post('blok_kav_no_op_sppt'));
        // $data['rt_op_sppt'] = post_string($this->input->post('rt_op_sppt'));
        // $data['rw_op_sppt'] = post_string($this->input->post('rw_op_sppt'));
        // $data['nop_ttg_1'] = post_string($this->input->post('nop_ttg_1'));
        // $data['nop_ttg_2'] = post_string($this->input->post('nop_ttg_2'));
        // $data['alamat_op_1'] = post_string($this->input->post('alamat_op_1'));
        // $data['alamat_op_2'] = post_string($this->input->post('alamat_op_2'));
        $data['nop_lengkap'] = post_string($this->input->post('nop_lengkap'));
        $data['kd_propinsi'] = post_string($this->input->post('kd_propinsi'));
        $data['kd_dati2']    = post_string($this->input->post('kd_dati2'));
        $data['kd_kecamatan'] = post_string($this->input->post('kd_kecamatan'));
        $data['kd_kelurahan'] = post_string($this->input->post('kd_kelurahan'));
        $data['kd_blok'] = post_string($this->input->post('kd_blok'));
        $data['no_urut'] = post_string($this->input->post('no_urut'));
        $data['kd_jns_op'] = post_string($this->input->post('kd_jns_op'));
        $data['jln_op_sppt'] = post_string($this->input->post('jln_op_sppt'));
        $data['blok_kav_no_op_sppt'] = post_string($this->input->post('blok_kav_no_op_sppt'));
        $data['rt_op_sppt'] = post_string($this->input->post('rt_op_sppt'));
        $data['rw_op_sppt'] = post_string($this->input->post('rw_op_sppt'));
        $data['kecamatan_op_nama'] = post_string($this->input->post('kecamatan_op_nama'));
        $data['kelurahan_op_nama'] = post_string($this->input->post('kelurahan_op_nama'));
        // $data['kd_znt'] = post_string($this->input->post('kd_znt'));
        // $data['alasan'] = post_string($this->input->post('alasan'));
        $data['keterangan'] = post_string($this->input->post('keterangan'));
        return $data;
    }

    public function action()
    {
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
            redirect(active_module_url('appr_bsre'));
        }

        $p_id  = $this->uri->segment(4);
        $sts  = $this->uri->segment(5);
        // $p_id  = $this->input->get('row_id', true);
        // $p_id  = $_GET['row_id'];
        // echo $p_id;
        // die();

        $rowid = $p_id;

        $data['page_menu'] = 'appr_bsre';
        $data['current'] = '';
        $data['apps']    = $this->apps_model->get_active_only();
        // $data['faction'] = active_module_url("appr_bsre/update/{$p_id}");
        $data['faction'] = "";

        if ($p_id && $get = $this->appr_bsre_model->get_by_nik_sts($p_id, $sts)) {
            $data['dt']['rowid'] = $get->ID;
            $data['dt']['nik'] = get_string($get->NIK);
            $data['dt']['nm_wp_sppt']    = get_string($get->NM_WP_SPPT);
            $data['dt']['nohp'] = get_string($get->NOHP);
            $data['dt']['email'] = get_string($get->EMAIL);
            $data['dt']['loginname'] = get_string($get->LOGINNAME);
            $data['dt']['passwd'] = get_string($get->PASSWOD);

            $data['dt']['nop_lengkap'] = get_string($get->NOP_LKP);
            $data['dt']['kd_propinsi'] = get_string($get->KD_PROPINSI);
            $data['dt']['kd_dati2'] = get_string($get->KD_DATI2);
            $data['dt']['kd_kecamatan'] = get_string($get->KD_KECAMATAN);
            $data['dt']['kd_kelurahan'] = get_string($get->KD_KELURAHAN);
            $data['dt']['kd_blok'] = get_string($get->KD_BLOK);
            $data['dt']['no_urut'] = get_string($get->NO_URUT);
            $data['dt']['kd_jns_op'] = get_string($get->KD_JNS_OP);

            $data['dt']['jln_op_sppt'] = get_string($get->JLN_OP_SPPT);
            $data['dt']['blok_kav_no_op_sppt'] = get_string($get->BLOK_KAV_NO_OP_SPPT);
            $data['dt']['rt_op_sppt'] = get_string($get->RT_OP_SPPT);
            $data['dt']['rw_op_sppt'] = get_string($get->RW_OP_SPPT);

            $data['dt']['kecamatan_op_nama'] = get_string($get->NM_KECAMATAN);
            $data['dt']['kelurahan_op_nama'] = get_string($get->NM_KELURAHAN);
            $data['dt']['keterangan'] = get_string($get->KETERANGAN);
            $data['dt']['sts_verif'] = $get->STATUS_VERIF;
            // $data['dt']['jln_wp_sppt'] = get_string($get->JLN_WP_SPPT);
            // $data['dt']['blok_kav_no_wp_sppt'] = get_string($get->BLOK_KAV_NO_WP_SPPT);
            // $data['dt']['rt_wp_sppt'] = get_string($get->RT_WP_SPPT);
            // $data['dt']['rw_wp_sppt'] = get_string($get->RW_WP_SPPT);
            // $data['dt']['kelurahan_wp_sppt'] = get_string($get->KELURAHAN_WP_SPPT);
            // $data['dt']['kota_wp_sppt'] = get_string($get->KOTA_WP_SPPT);
            // $data['dt']['kd_pos_wp_sppt'] = get_string($get->KD_POS_WP_SPPT);
            // $data['dt']['npwp'] = get_string($get->NPWP_SPPT);

            // $data['dt']['nop_ttg_1'] = get_string($get->NOP_TTG_1);
            // $data['dt']['nop_ttg_2'] = get_string($get->NOP_TTG_2);
            // // $data['dt']['nama_wp_1'] = get_string($get->NAMA_WP_1);
            // // $data['dt']['nama_wp_2'] = get_string($get->NAMA_WP_2);
            // $data['dt']['alamat_op_1'] = get_string($get->JLN_OP_SPPT1);
            // $data['dt']['alamat_op_2'] = get_string($get->JLN_OP_SPPT2);

            // $data['dt']['im_ktp_new'] = get_string($get->IM_KTP_NEW);
            // $data['dt']['im_lamp1_new'] = get_string($get->IM_LAMP1_NEW);
            // $data['dt']['im_lamp2_new'] = get_string($get->IM_LAMP2_NEW);
            // $data['dt']['im_lamp3_new'] = get_string($get->IM_LAMP3_NEW);
            // $data['dt']['im_lamp4_new'] = get_string($get->IM_LAMP4_NEW);
            // $data['dt']['im_lamp5_new'] = get_string($get->IM_LAMP5_NEW);
            // $data['dt']['im_lamp6_new'] = get_string($get->IM_LAMP6_NEW);
            // $data['dt']['im_lamp7_new'] = get_string($get->IM_LAMP7_NEW);

            // $data['dt']['im_ktp'] = $get->IM_KTP->load();
            // $data['dt']['im_lamp1'] = $get->IM_LAMP1->load();
            // $data['dt']['im_lamp2'] = $get->IM_LAMP2->load();
            // $data['dt']['im_lamp3'] = $get->IM_LAMP3->load();
            // $data['dt']['im_lamp4'] = $get->IM_LAMP4->load();
            // $data['dt']['im_lamp5'] = $get->IM_LAMP5->load();
            // $data['dt']['im_lamp6'] = $get->IM_LAMP6->load();
            // $data['dt']['im_lamp7'] = $get->IM_LAMP7->load();

            $this->load->view('vappr_bsre_form', $data);
        } else {
            show_404();
        }
    }

    public function detail()
    {
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
            redirect(active_module_url('appr_bsre'));
        }

        $p_id  = $this->uri->segment(4);
        // $p_id  = $this->input->get('row_id', true);
        // $p_id  = $_GET['row_id'];
        // echo $p_id;
        // die();

        $rowid = $p_id;

        $data['page_menu'] = 'appr_bsre';
        $data['current'] = '';
        $data['apps']    = $this->apps_model->get_active_only();
        // $data['faction'] = active_module_url("appr_bsre/update/{$p_id}");
        $data['faction'] = "";

        if ($p_id && $get = $this->appr_bsre_model->get_by_nik($p_id)) {
            $data['dt']['rowid'] = $get->ID;
            $data['dt']['nik'] = get_string($get->NIK);
            $data['dt']['nm_wp_sppt']    = get_string($get->NM_WP_SPPT);
            $data['dt']['nohp'] = get_string($get->NOHP);
            $data['dt']['email'] = get_string($get->EMAIL);
            $data['dt']['loginname'] = get_string($get->LOGINNAME);
            $data['dt']['passwd'] = get_string($get->PASSWOD);

            $data['dt']['nop_lengkap'] = get_string($get->NOP_LKP);
            $data['dt']['kd_propinsi'] = get_string($get->KD_PROPINSI);
            $data['dt']['kd_dati2'] = get_string($get->KD_DATI2);
            $data['dt']['kd_kecamatan'] = get_string($get->KD_KECAMATAN);
            $data['dt']['kd_kelurahan'] = get_string($get->KD_KELURAHAN);
            $data['dt']['kd_blok'] = get_string($get->KD_BLOK);
            $data['dt']['no_urut'] = get_string($get->NO_URUT);
            $data['dt']['kd_jns_op'] = get_string($get->KD_JNS_OP);

            $data['dt']['jln_op_sppt'] = get_string($get->JLN_OP_SPPT);
            $data['dt']['blok_kav_no_op_sppt'] = get_string($get->BLOK_KAV_NO_OP_SPPT);
            $data['dt']['rt_op_sppt'] = get_string($get->RT_OP_SPPT);
            $data['dt']['rw_op_sppt'] = get_string($get->RW_OP_SPPT);

            $data['dt']['kecamatan_op_nama'] = get_string($get->NM_KECAMATAN);
            $data['dt']['kelurahan_op_nama'] = get_string($get->NM_KELURAHAN);

            // $data['dt']['jln_wp_sppt'] = get_string($get->JLN_WP_SPPT);
            // $data['dt']['blok_kav_no_wp_sppt'] = get_string($get->BLOK_KAV_NO_WP_SPPT);
            // $data['dt']['rt_wp_sppt'] = get_string($get->RT_WP_SPPT);
            // $data['dt']['rw_wp_sppt'] = get_string($get->RW_WP_SPPT);
            // $data['dt']['kelurahan_wp_sppt'] = get_string($get->KELURAHAN_WP_SPPT);
            // $data['dt']['kota_wp_sppt'] = get_string($get->KOTA_WP_SPPT);
            // $data['dt']['kd_pos_wp_sppt'] = get_string($get->KD_POS_WP_SPPT);
            // $data['dt']['npwp'] = get_string($get->NPWP_SPPT);

            // $data['dt']['nop_ttg_1'] = get_string($get->NOP_TTG_1);
            // $data['dt']['nop_ttg_2'] = get_string($get->NOP_TTG_2);
            // // $data['dt']['nama_wp_1'] = get_string($get->NAMA_WP_1);
            // // $data['dt']['nama_wp_2'] = get_string($get->NAMA_WP_2);
            // $data['dt']['alamat_op_1'] = get_string($get->JLN_OP_SPPT1);
            // $data['dt']['alamat_op_2'] = get_string($get->JLN_OP_SPPT2);

            // $data['dt']['im_ktp_new'] = get_string($get->IM_KTP_NEW);
            // $data['dt']['im_lamp1_new'] = get_string($get->IM_LAMP1_NEW);
            // $data['dt']['im_lamp2_new'] = get_string($get->IM_LAMP2_NEW);
            // $data['dt']['im_lamp3_new'] = get_string($get->IM_LAMP3_NEW);
            // $data['dt']['im_lamp4_new'] = get_string($get->IM_LAMP4_NEW);
            // $data['dt']['im_lamp5_new'] = get_string($get->IM_LAMP5_NEW);
            // $data['dt']['im_lamp6_new'] = get_string($get->IM_LAMP6_NEW);
            // $data['dt']['im_lamp7_new'] = get_string($get->IM_LAMP7_NEW);

            // $data['dt']['im_ktp'] = $get->IM_KTP->load();
            // $data['dt']['im_lamp1'] = $get->IM_LAMP1->load();
            // $data['dt']['im_lamp2'] = $get->IM_LAMP2->load();
            // $data['dt']['im_lamp3'] = $get->IM_LAMP3->load();
            // $data['dt']['im_lamp4'] = $get->IM_LAMP4->load();
            // $data['dt']['im_lamp5'] = $get->IM_LAMP5->load();
            // $data['dt']['im_lamp6'] = $get->IM_LAMP6->load();
            // $data['dt']['im_lamp7'] = $get->IM_LAMP7->load();

            $this->load->view('vappr_bsre_form_view', $data);
        } else {
            show_404();
        }
    }

  function cek_pbb(){
    echo current_time();
  }

    public function approve()
    {
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
            redirect(active_module_url('appr_bsre'));
        }

        $p_id       = $this->uri->segment(4);
        $post_data = $this->fpost();

        $rowid  = $this->input->post('rowid');
        $nik    = $this->input->post('nik');
        $pass   = $this->input->post('passwd');
        $namawp = $this->input->post('nm_wp_sppt');
        $nohp   = $this->input->post('nohp');
        $sts = $this->input->post('sts_verif');

        $data['page_menu'] = 'appr_bsre';
        $data['current'] = '';
        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = '';
        // $data['faction'] = active_module_url("appr_bsre/update/{$p_id}");

        $this->fvalidation('approve');

        // if ($this->form_validation->run() == true) {
            $input_post  = $post_data;

            $update_data = array(
                'STATUS_VERIF' => 1,
            );
            $get_dt = $this->appr_bsre_model->get_by_rowid($rowid);
            $cek_rsppt = $this->appr_bsre_model->cek_appr_bsre($get_dt->NIK, $get_dt->KD_PROPINSI, $get_dt->KD_DATI2, $get_dt->KD_KECAMATAN, $get_dt->KD_KELURAHAN, $get_dt->KD_KELURAHAN, $get_dt->NO_URUT, $get_dt->KD_JNS_OP);
            if($cek_rsppt == 0){
            $email_wp = get_string($get_dt->EMAIL);
            // $result = $this->appr_bsre_model->update_data_appr_bsretemp_by_nik($nik, $update_data);
            $result = $this->appr_bsre_model->update_data_appr_bsretemp($rowid, $update_data);
            if (!empty($result)) {
                set_msg_db_error($result);
            } else {
                // $result2 = $this->appr_bsre_model->insert_data_reg_sppt_by_nik($nik);
                 $result2 = $this->appr_bsre_model->insert_data_reg_sppt_by_rowid($rowid);
                if (!empty($result2)) {
                    set_msg_db_error($result2);
                } else {
                    //// INSERT USER

                    $pass_enc = $this->load->model('users_model')->encript_value($nik, $pass);
                    $id_user = $this->appr_bsre_model->nextid_user(); //dipake kok
                    // echo $id_user;

                    $user_data = array(
                      'ID'            => get_string($id_user->NEXT_ID), // dipake kok
                      'LEVEL_ID'      => 3,
                      'DISABLED'      => 0,
                      'USERID'        => $nik,
                      'PASSWD'        => get_string($pass_enc->FN_KEYLOCK),
                      'NAMA'          => $namawp,
                      'HANDPHONE'     => $nohp,
                      'NIP'           => '-',
                      'JABATAN'       => '-',
                      'CREATED_DATE'  => current_time(),
                      'CREATED_BY'    => sipkd_user_login(),
                    );

                    $user_group_data = array(
                      'USER_ID'       => get_string($id_user->NEXT_ID), // dipake kok
                      'GROUP_ID'      => 2,
                    );

                    $xxx = $this->appr_bsre_model->insert_user($user_data); // dipake kok
					$this->appr_bsre_model->insert_user_group($user_group_data);

				   /* if(empty($xxx)){
                         // dipake kok
                    }else{
                        set_msg_db_error($xxx);
                        // log_message('info','approve reg_sppt error insert user '.set_msg_db_error());
                    } */

                    $config = array(
                'protocol' => SMTP_PROTOCOL,
                'smtp_host' => SMTP_HOST, //sesuaikan dengan host pengirim
                'smtp_port' => SMTP_PORT,
                'smtp_timeout' => 20,
                'smtp_user' => EMAIL_EADM, //sesuaikan dengan email yg dipakai
                'smtp_pass' => PASSWD_EADM, //password host
                'smtp_username' => SMTP_UNAME,
                'mailtype' => SMTP_TYPE,
                'charset' => SMTP_CHARSET,
                'wordwrap' => true,
            );
                    $link_login = DOMAIN_BOGOR.'/reg_sppt_bgr/login';
                    $message = "Terima kasih, permohonan registrasi anda berhasil. Silakan login untuk melanjutkan proses pelayanan. <br>";
                    $message .= "<a href='$link_login' >Klik disini</a>";
            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from(EMAIL_EADM, SMTP_UNAME);
            $this->email->to($email_wp);
            $this->email->subject('Approve Registrasi ESPPT');
            $this->email->message($message);
                     //sending email
            if ($this->email->send()) {
                $this->session->set_flashdata('msg_success', 'Data telah di approve');
            } else {
                $this->session->set_flashdata('msg_warning', 'Gagal Kirim Email');
                // echo $this->email->print_debugger();
            }
                    // $this->session->set_flashdata('msg_success', 'Data telah disimpan');
                    redirect(active_module_url('appr_bsre'));
                }

            }
        }else{
          $this->session->set_flashdata('msg_warning', 'Approve Gagal. Data Nik dan Nop sudah ada');
          redirect(active_module_url('appr_bsre'));
        }

        // }

        $get = (object)$post_data;
        $data['dt'] = $post_data;

        $this->load->view('vappr_bsre_form', $data);
    }



    public function tolak_old20220208()
    {
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
            redirect(active_module_url('appr_bsre'));
        }

        $p_id       = $this->uri->segment(4);
        $post_data = $this->fpost();

        $rowid  = $this->input->post('rowid');
        $nik    = $this->input->post('nik');

        $data['page_menu'] = 'appr_bsre';
        $data['current'] = '';
        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = '';
        // $data['faction'] = active_module_url("appr_bsre/update/{$p_id}");

        $this->fvalidation('tolak');

        // if ($this->form_validation->run() == true) {
        $input_post  = $post_data;

        $update_data = array(
                'STATUS_VERIF' => 2,
                'KETERANGAN' => $input_post['keterangan'],
            );

        $result = $this->appr_bsre_model->update_data_appr_bsretemp_by_nik($nik, $update_data);
        if (!empty($result)) {
            set_msg_db_error($result);
        } else {
            $this->session->set_flashdata('msg_success', 'Data telah disimpan');
            redirect(active_module_url('appr_bsre'));
        }
        // }

        $get = (object)$post_data;
        $data['dt'] = $post_data;

        // $this->load->view('vappr_bsre_form', $data);
    }

    public function tolak()
    {
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
            redirect(active_module_url('appr_bsre'));
        }

        $p_id       = $this->uri->segment(4);
        $post_data = $this->fpost();

        $rowid  = $this->input->post('rowid');
        $nik    = $this->input->post('nik');

        $data['page_menu'] = 'appr_bsre';
        $data['current'] = '';
        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = '';
        // $data['faction'] = active_module_url("appr_bsre/update/{$p_id}");

        $this->fvalidation('tolak');

        // if ($this->form_validation->run() == true) {
        $input_post  = $post_data;

        $update_data = array(
                'STATUS_VERIF' => 2,
                'KETERANGAN' => $input_post['keterangan'],
            );
        //$cek = $this->appr_bsre_model->cek_tolak_data($nik);
		$cek = 0;
        if($cek == 0){
        $get_dt = $this->appr_bsre_model->get_by_rowid($rowid);
        $email_wp = get_string($get_dt->EMAIL);

        $result = $this->appr_bsre_model->update_data_appr_bsretemp($rowid, $update_data);
        $result = 1;
        if (empty($result)) {
            set_msg_db_error($result);
        } else {
            $config = array(
                'protocol' => SMTP_PROTOCOL,
                'smtp_host' => SMTP_HOST, //sesuaikan dengan host pengirim
                'smtp_port' => SMTP_PORT,
                'smtp_timeout' => 20,
                'smtp_user' => EMAIL_EADM, //sesuaikan dengan email yg dipakai
                'smtp_pass' => PASSWD_EADM, //password host
                'smtp_username' => SMTP_UNAME,
                'mailtype' => SMTP_TYPE,
                'charset' => SMTP_CHARSET,
                'wordwrap' => true,
            );
                    $link_login = DOMAIN_BOGOR.'/reg_sppt_bgr/regsppt/daftar_sppt/add/';
                  $message ="Mohon maaf permohonan registrasi anda tidak dapat diproses karena <br>".$input_post['keterangan'].".<br>";
                $message .= "Silakan lakukan proses registrasi ulang dengan mengisi data yang sesuai pada link berikut <br>";
                $message .= "<a href='{$link_login}'>Klik Disini</a>";

            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from(EMAIL_EADM, SMTP_UNAME);
            $this->email->to($email_wp);
            $this->email->subject('Tolak Registrasi ESPPT');
            $this->email->message($message);
                     //sending email
            if ($this->email->send()) {
                $this->session->set_flashdata('msg_success', 'Data berhasil di tolak');
            } else {
                $this->session->set_flashdata('msg_warning', 'Gagal Kirim Email');
                // echo $this->email->print_debugger();
            }
            $this->session->set_flashdata('msg_success', 'Data telah disimpan');
            redirect(active_module_url('appr_bsre'));
        }
    }

        // }

        $get = (object)$post_data;
        $data['dt'] = $post_data;

        // $this->load->view('vappr_bsre_form', $data);
    }

    public function openblob()
    {
        $field       = $this->uri->segment(4);
        $nik       = $this->uri->segment(5);
        $field = strtoupper($field);

        $dbhost = DB_HOST;
        $dbport = DB_PORT;
        $dbname = DB_NAME;
        $dbuser = DB_USER;
        $dbpass = DB_PASS;

        $tnslistener = '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST='.DB_HOST.')(PORT='.DB_PORT.'))(CONNECT_DATA=(SERVICE_NAME='.DB_NAME.')))';

        $connection = oci_connect($dbuser, $dbpass, $tnslistener);

        $sql = "SELECT {$field} FROM REG_ESPPT_TEMP WHERE NIK = '{$nik}' AND STATUS_VERIF='0' ";

        $stid = oci_parse($connection, $sql);

        oci_execute($stid);
        $row = oci_fetch_array($stid, OCI_RETURN_NULLS);

        if (!$row) {
            header('Status: 404 Not Found');
        } else {
            // $img = $row[$field]->load();
            // header("Content-type: application/pdf");
            // print $img;
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
}
