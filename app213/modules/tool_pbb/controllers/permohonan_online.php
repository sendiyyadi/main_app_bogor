<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class permohonan_online extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!is_login()) {
            echo "<script>window.location.replace('" . base_url() . "');</script>";
            exit;
        }

        $module = 'permohonan_online';
        $this->load->library('module_auth', array(
            'module' => $module
        ));

        $this->load->model(array(
            'apps_model', 'permohonan_online_model'
        ));

        $this->load->helper(active_module());
    }

    function ntes() {
        $data['page_menu'] = 'permohonan_online';
        $data['current'] = '';
        $data['apps']    = $this->apps_model->get_active_only();
        $this->load->view('vntes', $data);
    }

    function ntes2() {
        
        $nopnik = '3203190005022101203277070909222001';
        $data = new stdClass();
        if ($dt_reg_sppt = $this->permohonan_online_model->cek_nop_reg_esppt_bynopnik($nopnik)) {

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



        return $data;
    }

    public function cek_file_size($val) {
        $maxsize = SIZE_FILE_MAX;
        $im_spop = isset($_FILES['im_spop']['name']) ? $_FILES['im_spop']['size'] : 0;
        $im_lspop = isset($_FILES['im_lspop']['name']) ? $_FILES['im_lspop']['size'] : 0;
        $im_ktp = isset($_FILES['im_ktp']['name']) ? $_FILES['im_ktp']['size'] : 0;
        $im_sertanah = isset($_FILES['im_sertanah']['name']) ? $_FILES['im_sertanah']['size'] : 0;
        $im_imb = isset($_FILES['im_imb']['name']) ? $_FILES['im_imb']['size'] : 0;
        $im_foto_op = isset($_FILES['im_foto_op']['name']) ? $_FILES['im_foto_op']['size'] : 0;
        $im_valbphtb = isset($_FILES['im_valbphtb']['name']) ? $_FILES['im_valbphtb']['size'] : 0;
        $im_pengantar_desa = isset($_FILES['im_pengantar_desa']['name']) ? $_FILES['im_pengantar_desa']['size'] : 0;
        $im_nonsengketa = isset($_FILES['im_nonsengketa']['name']) ? $_FILES['im_nonsengketa']['size'] : 0;
        $im_riwyt_tanah = isset($_FILES['im_riwyt_tanah']['name']) ? $_FILES['im_riwyt_tanah']['size'] : 0;
        $im_sppt = isset($_FILES['im_sppt']['size']) ? $_FILES['im_sppt']['size'] : 0;
        $im_stts = isset($_FILES['im_stts']['name']) ? $_FILES['im_stts']['size'] : 0;
        $im_sk_pengurangan = isset($_FILES['im_sk_pengurangan']['name']) ? $_FILES['im_sk_pengurangan']['size'] : 0;
        $im_other = isset($_FILES['im_other']['name']) ? $_FILES['im_other']['size'] : 0;
        // $im_buktibayar = isset($_FILES['im_buktibayar']['name']) ? $_FILES['im_buktibayar']['size'] : 0;
        // $im_sppt_bnr = isset($_FILES['im_sppt_bnr']['name']) ? $_FILES['im_sppt_bnr']['size'] : 0;
        //// REG ESPPT 
        $im_ktp_re = isset($_FILES['im_ktp_re']['name']) ? $_FILES['im_ktp_re']['size'] : 0;
        $im_sppt_re = isset($_FILES['im_sppt_re']['size']) ? $_FILES['im_sppt_re']['size'] : 0;
        $im_stts_re = isset($_FILES['im_stts_re']['name']) ? $_FILES['im_stts_re']['size'] : 0;

        $ret = true;

        // if ($im_sppt_bnr > $maxsize) {
        //     $ret = false;
        // }
        // if ($im_buktibayar > $maxsize) {
        //     $ret = false;
        // }
        if ($im_spop > $maxsize) {
            $ret = false;
        }
        if ($im_lspop > $maxsize) {
            $ret = false;
        }
        if ($im_ktp > $maxsize) {
            $ret = false;
        }
        if ($im_sertanah > $maxsize) {
            $ret = false;
        }
        if ($im_imb > $maxsize) {
            $ret = false;
        }
        if ($im_foto_op > $maxsize) {
            $ret = false;
        }
        if ($im_valbphtb > $maxsize) {
            $ret = false;
        }
        if ($im_pengantar_desa > $maxsize) {
            $ret = false;
        }
        if ($im_nonsengketa > $maxsize) {
            $ret = false;
        }
        if ($im_riwyt_tanah > $maxsize) {
            $ret = false;
        }
        if ($im_sppt > $maxsize) {
            $ret = false;
        }
        if ($im_stts > $maxsize) {
            $ret = false;
        }
        if ($im_sk_pengurangan > $maxsize) {
            $ret = false;
        }
        if ($im_other > $maxsize) {
            $ret = false;
        }

        //// REG ESPPT 
        if ($im_ktp_re > $maxsize) {
            $ret = false;
        }
        if ($im_sppt_re > $maxsize) {
            $ret = false;
        }
        if ($im_stts_re > $maxsize) {
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
        $im_spop = !empty($_FILES['im_spop']['name']) ? $_FILES['im_spop']['type'] : $atx;
        $im_lspop = !empty($_FILES['im_lspop']['name']) ? $_FILES['im_lspop']['type'] : $atx;
        $im_ktp = !empty($_FILES['im_ktp']['name']) ? $_FILES['im_ktp']['type'] : $atx;
        $im_sertanah = !empty($_FILES['im_sertanah']['name']) ? $_FILES['im_sertanah']['type'] : $atx;
        $im_imb = !empty($_FILES['im_imb']['name']) ? $_FILES['im_imb']['type'] : $atx;
        $im_foto_op = !empty($_FILES['im_foto_op']['name']) ? $_FILES['im_foto_op']['type'] : $atx;
        $im_valbphtb = !empty($_FILES['im_valbphtb']['name']) ? $_FILES['im_valbphtb']['type'] : $atx;
        $im_pengantar_desa = !empty($_FILES['im_pengantar_desa']['name']) ? $_FILES['im_pengantar_desa']['type'] : $atx;
        $im_nonsengketa = !empty($_FILES['im_nonsengketa']['name']) ? $_FILES['im_nonsengketa']['type'] : $atx;
        $im_riwyt_tanah = !empty($_FILES['im_riwyt_tanah']['name']) ? $_FILES['im_riwyt_tanah']['type'] : $atx;
        $im_sppt = !empty($_FILES['im_sppt']['type']) ? $_FILES['im_sppt']['type'] : $atx;
        $im_stts = !empty($_FILES['im_stts']['name']) ? $_FILES['im_stts']['type'] : $atx;
        // $im_sppt_bnr = !empty($_FILES['im_sppt_bnr']['type']) ? $_FILES['im_sppt_bnr']['type'] : $atx;
        // $im_buktibayar = !empty($_FILES['im_bukt$im_buktibayar']['type']) ? $_FILES['im_bukt$im_buktibayar']['type'] : $atx;
        // !in_array($im_sppt_bnr, $file_ext) || !in_array($im_buktibayar, $file_ext) || 
        $im_sk_pengurangan = !empty($_FILES['im_sk_pengurangan']['name']) ? $_FILES['im_sk_pengurangan']['type'] : $atx;
        $im_other = !empty($_FILES['im_other']['name']) ? $_FILES['im_other']['type'] : $atx;

        $im_ktp_re = !empty($_FILES['im_ktp_re']['name']) ? $_FILES['im_ktp_re']['type'] : $atx;
        $im_sppt_re = !empty($_FILES['im_sppt_re']['type']) ? $_FILES['im_sppt_re']['type'] : $atx;
        $im_stts_re = !empty($_FILES['im_stts_re']['name']) ? $_FILES['im_stts_re']['type'] : $atx;

        $file_ext = array("application/pdf", "image/png", "image/jpeg", "image/jpg", $atx);
        if (!in_array($im_spop, $file_ext) || !in_array($im_lspop, $file_ext) || !in_array($im_sertanah, $file_ext) || 
            !in_array($im_ktp, $file_ext) || !in_array($im_imb, $file_ext) || !in_array($im_foto_op, $file_ext) || 
            !in_array($im_valbphtb, $file_ext) || !in_array($im_pengantar_desa, $file_ext) || !in_array($im_nonsengketa, $file_ext) || 
            !in_array($im_riwyt_tanah, $file_ext) || !in_array($im_sppt, $file_ext) || !in_array($im_stts, $file_ext) || 
            !in_array($im_sk_pengurangan, $file_ext) || !in_array($im_other, $file_ext)) {
            $ret = false;
        }
        if (!in_array($im_ktp_re, $file_ext) || !in_array($im_sppt_re, $file_ext) || !in_array($im_stts_re, $file_ext)) {
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

        $data['page_menu'] = 'permohonan_online';
        $data['current'] = '';
        $data['apps']    = $this->apps_model->get_active_only();
        
        // $option = array( ''=> 'Semua Status','A' => 'Draft',
        //     '1' => 'Terima',
        //     '2' => 'Tolak');
        // $js  = 'id="status_kd" style="width:130px;" class="form-control" ';
        // $select = form_dropdown('status_kd', $option, '' , $js);
        // $data['select_status'] = $select;

        // $data['faction'] = active_module_url("permohonan_online/proses/");
        $data['faction'] = '#';
        // $data['dt']['nop'] = get_string('');
        // $data['dt']['tahun'] = get_string('');
        // $data['dt']['jatuh_tempo'] = get_string('');

        $select_data  = $this->permohonan_online_model->get_jns_ply();
        if ($select_data) {
            foreach ($select_data as $row) {
                $options[$row->KD_JNS_PELAYANAN] = $row->NM_JENIS_PELAYANAN;
            }
        } else {
            $options['0'] = 'Data not found';
        }
        // $js     = 'id="jns_ply" required style="width:90%; height:100% !important;" onchange="jns_ply_chg(this.value)" ';
        $js     = 'class="form-control" id="jns_ply" required ';
        $select = form_dropdown('jns_ply', $options, '', $js);
        $select = preg_replace("/[\r\n]+/", "", $select);
        $data['select_jns_ply'] = $select;

        $data['dt'] = $this->fpost();

        $this->load->view('vpermohonan_online_form', $data);
    }

    public function get_nop_reg_esppt() {
        $nop = $this->uri->segment(4);
        $data = new stdClass();

        
        // var_dump($dt_reg_sppt); die();
        if ($dt_reg_sppt = $this->permohonan_online_model->cek_nop_reg_esppt($nop)) {
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
            if ($dt_op = $this->permohonan_online_model->cek_nop_dop($nop)) {
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

    public function save_reg_esppt() {

        // //// insert reg_esppt 
        // $data = 

        // //// update blob nya
        // if (!empty($_FILES['im_ktp_re']['name']) || !empty($_FILES['im_sppt_re']['name']) || !empty($_FILES['im_stts_re']['name'])) {
        //     $this->update_prm_blob_regesppt($p_id);
        // }

        $nop        = $this->input->post('nop_re');
        $nop        = str_replace(".", "", $nop);
        $nop        = str_replace("-", "", $nop);
        $kd_prop = substr($nop, 0, 2);
        $kd_dati = substr($nop, 2, 2);
        $kd_kec  = substr($nop, 4, 3);
        $kd_kel  = substr($nop, 7, 3);
        $kd_blok = substr($nop, 10, 3);
        $no_urut = substr($nop, 13, 4);
        $kd_jns_op = substr($nop, 17, 1);
        $nik        = $this->input->post('nik_re');
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

        $im_ktp         = file_get_contents($_FILES['im_ktp_re']['tmp_name']);
        $im_sppt        = file_get_contents($_FILES['im_sppt_re']['tmp_name']);
        $im_stts        = file_get_contents($_FILES['im_stts_re']['tmp_name']);

        $dbhost = DB_HOST;
        $dbport = DB_PORT;
        $dbname = DB_NAME;
        $dbuser = DB_USER;
        $dbpass = DB_PASS;

        $tnslistener = '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST='.DB_HOST.')(PORT='.DB_PORT.'))(CONNECT_DATA=(SERVICE_NAME='.DB_NAME.')))';
        $connection = oci_connect($dbuser, $dbpass, $tnslistener);

        $qry1 = "INSERT INTO REG_ESPPT(NIK, NM_WP_SPPT, JLN_WP_SPPT, BLOK_KAV_NO_WP_SPPT, RW_WP_SPPT,
                                        RT_WP_SPPT, KELURAHAN_WP_SPPT, KOTA_WP_SPPT, RW_OP_SPPT, RT_OP_SPPT, THN_PAJAK_BAYAR,
                                        LOGINNAME, PASSWOD, EMAIL,
                                        NOHP, NAMA, NO_REG, NIKNOP, USER_GROUP, STATUS, 
                                        KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN,
                                        KD_BLOK, NO_URUT, KD_JNS_OP,
                                        SUBJEK_PAJAK_ID, NM_WP_BAYAR, 
                                        JLN_OP_SPPT, BLOK_KAV_NO_OP_SPPT, 
                                        IM_KTP_BLOB, IM_SPPT_BLOB, IM_PBB_BLOB)";

        $qry2 = " VALUES ('$nik', '$namawp', '$jalanwp', '-', '00', 
                        '000', ' ', ' ', '00','000', '$i_thn_ply',
                        '$loginname', '$password', '$email',
                        '$no_hp', '$nama', '$no_reg', '$niknop', '$usergroup', '$status', 
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
        oci_execute($result, OCI_DEFAULT) or die("Unable to execute query");
        $blob->save($im_ktp);
        $blob1->save($im_sppt);
        $blob2->save($im_stts);
        oci_commit($connection);

        $data = new stdClass();

        if (!oci_commit($connection)) {
            // return 0;
            $data->result       = '400';
            $data->msg          = 'Gagal Simpan Data Registrasi ESPPT';
        } else {
            oci_free_statement($result);
            // return 1;

            //// insert ke SEC_USERS
            $pass_enc = $this->permohonan_online_model->encript_value($nik, $password);
            $id_user = $this->permohonan_online_model->nextid_user(); //dipake kok
            // echo $id_user;

            $user_data = array(
              'ID'            => get_string($id_user->NEXT_ID), // dipake kok
              'LEVEL_ID'      => 3,
              'DISABLED'      => 0,
              'USERID'        => $nik,
              'PASSWD'        => get_string($pass_enc->FN_KEYLOCK),
              'NAMA'          => $namawp,
              'HANDPHONE'     => $no_hp,
              'NIP'           => '-',
              'JABATAN'       => '-',
              'CREATED_DATE'  => current_time(),
              'CREATED_BY'    => $nik,
            );

            $user_group_data = array(
              'USER_ID'       => get_string($id_user->NEXT_ID), // dipake kok
              'GROUP_ID'      => 2,
            );

            $this->db->insert('SEC_USERS', $user_data); // dipake kok
            $this->db->insert('SEC_USER_GROUPS', $user_group_data);


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

            $message = "
                        <html>
                            <head>
                                <title>Registrasi Akun ESPPT Kab Bogor</title>
                            </head>
                            <body>
                                <h3>Hi, ".$email."</h3>
                                <h3>Terima kasih, permohonan registrasi anda berhasil. Silakan login untuk melanjutkan proses pelayanan</h3>
                                <h3>*Klik <a href='".DOMAIN_SPPT."login' >Link Ini</a> untuk login dengan Akun Anda.</h3>
                                <h3>*Terima Kasih. </h3>
                            </body>
                        </html>";


            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from(SMTP_USER, SMTP_UNAME);
            $this->email->to($email);
            $this->email->subject('Approve Registrasi ESPPT');
            $this->email->message($message);
                //sending email
            if ($this->email->send()) {
                $data->result       = '200';
                $data->msg          = 'Berhasil Simpan Data Registrasi ESPPT (Sukses Kirim Email)';
            } else {
                $data->result       = '201';
                $data->msg          = 'Berhasil Simpan Data (Gagal Kirim Email)';
                // echo $this->email->print_debugger();
            }
            
        }

        echo json_encode($data);

    }

    public function send_mail_reg_esppt() {
        $nopnik = $this->uri->segment(4);
        $data = new stdClass();
        if ($dt_reg_sppt = $this->permohonan_online_model->cek_nop_reg_esppt_bynopnik($nopnik)) {

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
        // $tgl_permohonan = $this->input->post('tgl_permohonan');
        $tgl_permohonan = date('Y-m-d',strtotime($this->input->post('tgl_permohonan')));
        $i_thn_ply = $this->permohonan_online_model->get_thn_pelayanan();
        $kd_kanwil = '22';
        $kd_kantor = '13';

        $fim_spop = empty($_FILES['im_spop']['name']) ? 0 : 1;
        $fim_lspop = empty($_FILES['im_lspop']['name']) ? 0 : 1;
        $fim_ktp = empty($_FILES['im_ktp']['name']) ? 0 : 1;
        $fim_sertanah = empty($_FILES['im_sertanah']['name']) ? 0 : 1;
        $fim_imb = empty($_FILES['im_imb']['name']) ? 0 : 1;
        $fim_foto_op = empty($_FILES['im_foto_op']['name']) ? 0 : 1;
        $fim_valbphtb = empty($_FILES['im_valbphtb']['name']) ? 0 : 1;
        $fim_pengantar_desa = empty($_FILES['im_pengantar_desa']['name']) ? 0 : 1;
        $fim_nonsengketa = empty($_FILES['im_nonsengketa']['name']) ? 0 : 1;
        $fim_riwyt_tanah = empty($_FILES['im_riwyt_tanah']['name']) ? 0 : 1;
        $fim_sppt = empty($_FILES['im_sppt']['name']) ? 0 : 1;
        $fim_stts = empty($_FILES['im_stts']['name']) ? 0 : 1;
        $fim_sk_pengurangan = empty($_FILES['im_sk_pengurangan']['name']) ? 0 : 1;
        $fim_other = empty($_FILES['im_other']['name']) ? 0 : 1;

        $im_spop = $fim_spop == 0 ? NULL : file_get_contents($_FILES['im_spop']['tmp_name']);
        $im_lspop = $fim_lspop == 0 ? NULL : file_get_contents($_FILES['im_lspop']['tmp_name']);
        $im_ktp = $fim_ktp == 0 ? NULL : file_get_contents($_FILES['im_ktp']['tmp_name']);
        $im_sertanah = $fim_sertanah == 0 ? NULL : file_get_contents($_FILES['im_sertanah']['tmp_name']);
        $im_imb = $fim_imb == 0 ? NULL : file_get_contents($_FILES['im_imb']['tmp_name']);
        $im_foto_op = $fim_foto_op == 0 ? NULL : file_get_contents($_FILES['im_foto_op']['tmp_name']);
        $im_valbphtb = $fim_valbphtb == 0 ? NULL : file_get_contents($_FILES['im_valbphtb']['tmp_name']);
        $im_pengantar_desa = $fim_pengantar_desa == 0 ? NULL : file_get_contents($_FILES['im_pengantar_desa']['tmp_name']);
        $im_nonsengketa = $fim_nonsengketa == 0 ? NULL : file_get_contents($_FILES['im_nonsengketa']['tmp_name']);
        $im_riwyt_tanah = $fim_riwyt_tanah == 0 ? NULL : file_get_contents($_FILES['im_riwyt_tanah']['tmp_name']);
        $im_sppt = $fim_sppt == 0 ? NULL : file_get_contents($_FILES['im_sppt']['tmp_name']);
        $im_stts = $fim_stts == 0 ? NULL : file_get_contents($_FILES['im_stts']['tmp_name']);
        $im_sk_pengurangan = $fim_sk_pengurangan == 0 ? NULL : file_get_contents($_FILES['im_sk_pengurangan']['tmp_name']);
        $im_other = $fim_other == 0 ? NULL : file_get_contents($_FILES['im_other']['tmp_name']);

        $dbhost = DB_HOST;
        $dbport = DB_PORT;
        $dbname = DB_NAME;
        $dbuser = DB_USER;
        $dbpass = DB_PASS;

        $tnslistener = '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST='.DB_HOST.')(PORT='.DB_PORT.'))(CONNECT_DATA=(SERVICE_NAME='.DB_NAME.')))';
        $connection = oci_connect($dbuser, $dbpass, $tnslistener);

        $qq = "INSERT INTO PST_PERMOHONAN_ONLINE(KD_KANWIL, KD_KANTOR, THN_PELAYANAN, NAMA_PEMOHON, ALAMAT_PEMOHON, 
                KD_PROPINSI_PEMOHON, KD_DATI2_PEMOHON, KD_KECAMATAN_PEMOHON, KD_KELURAHAN_PEMOHON, KD_BLOK_PEMOHON, 
                NO_URUT_PEMOHON, KD_JNS_OP_PEMOHON, KD_JNS_PELAYANAN, TGL_SURAT_PERMOHONAN, THN_PAJAK_PERMOHONAN, 
                NIK_PENGIRIM, KETERANGAN_PST, NO_SRT_PERMOHONAN, NO_HP,
                L_KTP_WP, L_SKKP_PBB, L_SPMKP_PBB, L_SURAT_KUASA, L_PERMOHONAN, L_STTS, 
                L_SK_KEBERATAN, L_SPPT_STTS, L_SERTIFIKAT_TANAH, L_IMB, L_AKTE_JUAL_BELI, L_SPPT, 
                L_SK_PENGURANGAN, L_LAIN_LAIN, 
                L_SKKP_PBB1, L_SPMKP_PBB1, L_SURAT_KUASA1, L_PERMOHONAN1, L_STTS1, L_SK_KEBERATAN1, 
                L_SPPT_STTS1, L_KTP_WP1, L_SERTIFIKAT_TANAH1, L_IMB1, L_AKTE_JUAL_BELI1, L_SPPT1, 
                L_SK_PENGURANGAN1, L_LAIN_LAIN1)";
        $qq .= " VALUES('$kd_kanwil', '$kd_kantor', '$i_thn_ply', '$nama_pemohon', '$alamat_pemohon',
                '$kd_prop', '$kd_dati', '$kd_kec', '$kd_kel', '$kd_blok',
                '$no_urut', '$kd_jns_op', '$jns_ply', TO_DATE('$tgl_permohonan','YYYY-MM-DD'), '$thn_permohonan',
                '0', '$keterangan', '$no_permohonan', '$telp', 
                {$fim_ktp}, {$fim_spop}, {$fim_lspop}, {$fim_valbphtb}, {$fim_pengantar_desa}, {$fim_nonsengketa}, 
                {$fim_riwyt_tanah}, {$fim_stts}, {$fim_sertanah}, {$fim_imb}, {$fim_foto_op}, {$fim_sppt}, 
                {$fim_sk_pengurangan}, {$fim_other},
                EMPTY_BLOB(), EMPTY_BLOB(), EMPTY_BLOB(), EMPTY_BLOB(), EMPTY_BLOB(), EMPTY_BLOB(), 
                EMPTY_BLOB(), EMPTY_BLOB(), EMPTY_BLOB(), EMPTY_BLOB(), EMPTY_BLOB(), EMPTY_BLOB(), 
                EMPTY_BLOB(), EMPTY_BLOB()) 
                RETURNING L_SKKP_PBB1, L_SPMKP_PBB1, L_SURAT_KUASA1, L_PERMOHONAN1, L_STTS1, L_SK_KEBERATAN1, L_SPPT_STTS1, L_KTP_WP1, 
                L_SERTIFIKAT_TANAH1, L_IMB1, L_AKTE_JUAL_BELI1, L_SPPT1, L_SK_PENGURANGAN1, L_LAIN_LAIN1 
                INTO :blobsatu, :blobdua, :blobtiga, :blobempat, :bloblima, :blobenam, :blobtujuh, :blobdelapan, 
                :blobsembilan, :blobsepuluh, :blobXI, :blobXII, :blobXIII, :blobXIV";

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
        $blob->save($im_spop);
        $blob1->save($im_lspop);
        $blob2->save($im_valbphtb);
        $blob3->save($im_pengantar_desa);
        $blob4->save($im_nonsengketa);
        $blob5->save($im_riwyt_tanah);
        $blob6->save($im_stts);
        $blob7->save($im_ktp);
        $blob8->save($im_sertanah);
        $blob9->save($im_imb);
        $blob10->save($im_foto_op);
        $blob11->save($im_sppt);
        $blob12->save($im_sk_pengurangan);
        $blob13->save($im_other);
        oci_commit($connection);

        $data = new stdClass();

        if (!oci_commit($connection)) {
            // return 0;
            $data->result       = '400';
            $data->msg          = 'Gagal Simpan Data Permohonan Online';
        } else {
            oci_free_statement($result);
            $qr_ply     = $this->db->query("SELECT NM_JENIS_PELAYANAN FROM REF_JNS_PELAYANAN WHERE KD_JNS_PELAYANAN = '{$jns_ply}'");
            $nm_jns_ply = $qr_ply->row()->NM_JENIS_PELAYANAN;
            // return 1;
            $data->result       = '200';
            $data->msg          = 'Berhasil Simpan Draft Permohonan Online';
            $data->dtl_nop      = $nop;
            $data->dtl_nop_tx   = $nop_lkp;
            $data->dtl_ply      = $jns_ply;
            $data->dtl_ply_tx   = $nm_jns_ply;
            $data->dtl_thn_ply  = $i_thn_ply;
        }

        echo json_encode($data);

    }

    public function appr_permo() {
        $nop        = $this->uri->segment(4);
        $thn_ply    = $this->uri->segment(5);
        $kd_ply     = $this->uri->segment(6);

        $nop_kdply = $nop.$thn_ply.$kd_ply ;
        
        $simpan = $this->permohonan_online_model->update_sts_permohonan($nop_kdply);

        $getdt      = $this->permohonan_online_model->get_prm_online($nop_kdply);
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

        $message = "<strong>BUKTI PENGIRIMAN BERKAS PERMOHONAN ONLINE PBB</strong> <br>";
        $message .= "<strong>Badan Pengelolaan Pendapatan Daerah Kabupaten Bogor</strong> <br>";
        $message .= "NO PELAYANAN : {$nopel} <br>";
        $message .= "NOP : {$nop_lkp} <br>";
        $message .= "JENIS PELAYANAN : {$jns_ply_tx} <br>";
        $message .= "TGL KIRIM BERKAS : {$tgl_kirim} <br>";
        $message .= "KETERANGAN : {$ket} <br>";
        $message .= "Cibinong, {$d_today}";


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
    //     $im_spop = '';
    //     $im_lspop = '';
    //     $im_ktp = '';
    //     $im_sertanah = '';
    //     $im_imb = '';
    //     $im_foto_op = '';
    //     $im_valbphtb = '';
    //     $im_pengantar_desa = '';
    //     $im_nonsengketa = '';
    //     $im_riwyt_tanah = '';
    //     $im_sppt = '';
    //     $im_stts = '';
    //     $im_sk_pengurangan = '';
    //     $im_other = '';
    //     $fl_blob = array();
    //     $tbl_field = array();
    //     $tbl_field_return = array();
    //     $return_blob = array();
    //     if (!empty($_FILES['im_spop']['name'])) {
    //         array_push($tbl_field, 'L_SKKP_PBB1=EMPTY_BLOB()');
    //         array_push($fl_blob, 'L_SKKP_PBB=1');
    //         array_push($tbl_field_return, 'L_SKKP_PBB1');
    //         array_push($return_blob, ':blob1');
    //         $im_spop = file_get_contents($_FILES['im_spop']['tmp_name']);
    //     }
    //     if (!empty($_FILES['im_lspop']['name'])) {
    //         array_push($tbl_field, 'L_SPMKP_PBB1=EMPTY_BLOB()');
    //         array_push($fl_blob, 'L_SPMKP_PBB=1');
    //         array_push($tbl_field_return, 'L_SPMKP_PBB1');
    //         array_push($return_blob, ':blob2');
    //         $im_lspop = file_get_contents($_FILES['im_lspop']['tmp_name']);
    //     }
    //     if (!empty($_FILES['im_valbphtb']['name'])) {
    //         array_push($tbl_field, 'L_SURAT_KUASA1=EMPTY_BLOB()');
    //         array_push($tbl_field_return, 'L_SURAT_KUASA1');
    //         array_push($fl_blob, 'L_SURAT_KUASA=1');
    //         array_push($return_blob, ':blob3');
    //         $im_valbphtb = file_get_contents($_FILES['im_valbphtb']['tmp_name']);
    //     }
    //     if (!empty($_FILES['im_pengantar_desa']['name'])) {
    //         array_push($tbl_field, 'L_PERMOHONAN1=EMPTY_BLOB()');
    //         array_push($tbl_field_return, 'L_PERMOHONAN1');
    //         array_push($fl_blob, 'L_PERMOHONAN=1');
    //         array_push($return_blob, ':blob4');
    //         $im_pengantar_desa = file_get_contents($_FILES['im_pengantar_desa']['tmp_name']);
    //     }
    //     if (!empty($_FILES['im_nonsengketa']['name'])) {
    //         array_push($tbl_field, 'L_STTS1=EMPTY_BLOB()');
    //         array_push($tbl_field_return, 'L_STTS1');
    //         array_push($fl_blob, 'L_STTS=1');
    //         array_push($return_blob, ':blob5');
    //         $im_nonsengketa = file_get_contents($_FILES['im_nonsengketa']['tmp_name']);
    //     }
    //     if (!empty($_FILES['im_riwyt_tanah']['name'])) {
    //         array_push($tbl_field, 'L_SK_KEBERATAN1=EMPTY_BLOB()');
    //         array_push($tbl_field_return, 'L_SK_KEBERATAN1');
    //         array_push($fl_blob, 'L_SK_KEBERATAN=1');
    //         array_push($return_blob, ':blob6');
    //         $im_riwyt_tanah = file_get_contents($_FILES['im_riwyt_tanah']['tmp_name']);
    //     }
    //     if (!empty($_FILES['im_stts']['name'])) {
    //         array_push($tbl_field, 'L_SPPT_STTS1=EMPTY_BLOB()');
    //         array_push($tbl_field_return, 'L_SPPT_STTS1');
    //         array_push($fl_blob, 'L_SPPT_STTS=1');
    //         array_push($return_blob, ':blob7');
    //         $im_stts = file_get_contents($_FILES['im_stts']['tmp_name']);
    //     }
    //     if (!empty($_FILES['im_ktp']['name'])) {
    //         array_push($tbl_field, 'L_KTP_WP1=EMPTY_BLOB()');
    //         array_push($tbl_field_return, 'L_KTP_WP1');
    //         array_push($fl_blob, 'L_KTP_WP=1');
    //         array_push($return_blob, ':blob8');
    //         $im_ktp = file_get_contents($_FILES['im_ktp']['tmp_name']);
    //     }
    //     if (!empty($_FILES['im_sertanah']['name'])) {
    //         array_push($tbl_field, 'L_SERTIFIKAT_TANAH1=EMPTY_BLOB()');
    //         array_push($tbl_field_return, 'L_SERTIFIKAT_TANAH1');
    //         array_push($fl_blob, 'L_SERTIFIKAT_TANAH=1');
    //         array_push($return_blob, ':blob9');
    //         $im_sertanah = file_get_contents($_FILES['im_sertanah']['tmp_name']);
    //     }
    //     if (!empty($_FILES['im_imb']['name'])) {
    //         array_push($tbl_field, 'L_IMB1=EMPTY_BLOB()');
    //         array_push($tbl_field_return, 'L_IMB1');
    //         array_push($fl_blob, 'L_IMB=1');
    //         array_push($return_blob, ':blob10');
    //         $im_imb = file_get_contents($_FILES['im_imb']['tmp_name']);
    //     }
    //     if (!empty($_FILES['im_foto_op']['name'])) {
    //         array_push($tbl_field, 'L_AKTE_JUAL_BELI1=EMPTY_BLOB()');
    //         array_push($tbl_field_return, 'L_AKTE_JUAL_BELI1');
    //         array_push($fl_blob, 'L_AKTE_JUAL_BELI=1');
    //         array_push($return_blob, ':blob11');
    //         $im_foto_op = file_get_contents($_FILES['im_foto_op']['tmp_name']);
    //     }
    //     if (!empty($_FILES['im_sppt']['name'])) {
    //         array_push($tbl_field, 'L_SPPT1=EMPTY_BLOB()');
    //         array_push($tbl_field_return, 'L_SPPT1');
    //         array_push($fl_blob, 'L_SPPT=1');
    //         array_push($return_blob, ':blob12');
    //         $im_sppt = file_get_contents($_FILES['im_sppt']['tmp_name']);
    //     }
    //     if (!empty($_FILES['im_sk_pengurangan']['name'])) {
    //         array_push($tbl_field, 'L_SK_PENGURANGAN1=EMPTY_BLOB()');
    //         array_push($tbl_field_return, 'L_SK_PENGURANGAN1');
    //         array_push($fl_blob, 'L_SK_PENGURANGAN=1');
    //         array_push($return_blob, ':blob13');
    //         $im_sk_pengurangan = file_get_contents($_FILES['im_sk_pengurangan']['tmp_name']);
    //     }
    //     if (!empty($_FILES['im_other']['name'])) {
    //         array_push($tbl_field, 'L_LAIN_LAIN1=EMPTY_BLOB()');
    //         array_push($tbl_field_return, 'L_LAIN_LAIN1');
    //         array_push($fl_blob, 'L_LAIN_LAIN=1');
    //         array_push($return_blob, ':blob14');
    //         $im_other = file_get_contents($_FILES['im_other']['tmp_name']);
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
    //     $qq = "UPDATE PST_PERMOHONAN_ONLINE SET {$fl_blob_impl}, {$tbl_field_impl} 
    //     WHERE KD_PROPINSI_PEMOHON||KD_DATI2_PEMOHON||KD_KECAMATAN_PEMOHON||KD_KELURAHAN_PEMOHON||KD_BLOK_PEMOHON||
    //     NO_URUT_PEMOHON||KD_JNS_OP_PEMOHON||THN_PELAYANAN||KD_JNS_PELAYANAN='{$param}' 
    //     RETURNING {$tbl_field_return_impl} INTO {$return_blob_impl}";
    //     $result = oci_parse($connection, $qq);
    //     if (!empty($_FILES['im_spop']['name'])) {
    //         $blob1 = oci_new_descriptor($connection, OCI_D_LOB);
    //         oci_bind_by_name($result, ":blob1", $blob1, -1, OCI_B_BLOB);
    //     }
    //     if (!empty($_FILES['im_lspop']['name'])) {
    //         $blob2 = oci_new_descriptor($connection, OCI_D_LOB);
    //         oci_bind_by_name($result, ":blob2", $blob2, -1, OCI_B_BLOB);
    //     }
    //     if (!empty($_FILES['im_valbphtb']['name'])) {
    //         $blob3 = oci_new_descriptor($connection, OCI_D_LOB);
    //         oci_bind_by_name($result, ":blob3", $blob3, -1, OCI_B_BLOB);
    //     }
    //     if (!empty($_FILES['im_pengantar_desa']['name'])) {
    //         $blob4 = oci_new_descriptor($connection, OCI_D_LOB);
    //         oci_bind_by_name($result, ":blob4", $blob4, -1, OCI_B_BLOB);
    //     }
    //     if (!empty($_FILES['im_nonsengketa']['name'])) {
    //         $blob5 = oci_new_descriptor($connection, OCI_D_LOB);
    //         oci_bind_by_name($result, ":blob5", $blob5, -1, OCI_B_BLOB);
    //     }
    //     if (!empty($_FILES['im_riwyt_tanah']['name'])) {
    //         $blob6 = oci_new_descriptor($connection, OCI_D_LOB);
    //         oci_bind_by_name($result, ":blob6", $blob6, -1, OCI_B_BLOB);
    //     }
    //     if (!empty($_FILES['im_stts']['name'])) {
    //         $blob7 = oci_new_descriptor($connection, OCI_D_LOB);
    //         oci_bind_by_name($result, ":blob7", $blob7, -1, OCI_B_BLOB);
    //     }
    //     if (!empty($_FILES['im_ktp']['name'])) {
    //         $blob8 = oci_new_descriptor($connection, OCI_D_LOB);
    //         oci_bind_by_name($result, ":blob8", $blob8, -1, OCI_B_BLOB);
    //     }
    //     if (!empty($_FILES['im_sertanah']['name'])) {
    //         $blob9 = oci_new_descriptor($connection, OCI_D_LOB);
    //         oci_bind_by_name($result, ":blob9", $blob9, -1, OCI_B_BLOB);
    //     }
    //     if (!empty($_FILES['im_imb']['name'])) {
    //         $blob10 = oci_new_descriptor($connection, OCI_D_LOB);
    //         oci_bind_by_name($result, ":blob10", $blob10, -1, OCI_B_BLOB);
    //     }
    //     if (!empty($_FILES['im_foto_op']['name'])) {
    //         $blob11 = oci_new_descriptor($connection, OCI_D_LOB);
    //         oci_bind_by_name($result, ":blob11", $blob11, -1, OCI_B_BLOB);
    //     }
    //     if (!empty($_FILES['im_sppt']['name'])) {
    //         $blob12 = oci_new_descriptor($connection, OCI_D_LOB);
    //         oci_bind_by_name($result, ":blob12", $blob12, -1, OCI_B_BLOB);
    //     }
    //     if (!empty($_FILES['im_sk_pengurangan']['name'])) {
    //         $blob13 = oci_new_descriptor($connection, OCI_D_LOB);
    //         oci_bind_by_name($result, ":blob13", $blob13, -1, OCI_B_BLOB);
    //     }
    //     if (!empty($_FILES['im_other']['name'])) {
    //         $blob14 = oci_new_descriptor($connection, OCI_D_LOB);
    //         oci_bind_by_name($result, ":blob14", $blob14, -1, OCI_B_BLOB);
    //     }

    //     $err = '';

    //     oci_execute($result, OCI_DEFAULT) or die("Unable to execute query; <br>" . $qq . '<br> Keterangan Error: <br>' . $err);
    //     if (!empty($_FILES['im_spop']['name'])) {
    //         $blob1->save($im_spop);
    //     }
    //     if (!empty($_FILES['im_lspop']['name'])) {
    //         $blob2->save($im_lspop);
    //     }
    //     if (!empty($_FILES['im_valbphtb']['name'])) {
    //         $blob3->save($im_valbphtb);
    //     }
    //     if (!empty($_FILES['im_pengantar_desa']['name'])) {
    //         $blob4->save($im_pengantar_desa);
    //     }
    //     if (!empty($_FILES['im_nonsengketa']['name'])) {
    //         $blob5->save($im_nonsengketa);
    //     }
    //     if (!empty($_FILES['im_riwyt_tanah']['name'])) {
    //         $blob6->save($im_riwyt_tanah);
    //     }
    //     if (!empty($_FILES['im_stts']['name'])) {
    //         $blob7->save($im_stts);
    //     }
    //     if (!empty($_FILES['im_ktp']['name'])) {
    //         $blob8->save($im_ktp);
    //     }
    //     if (!empty($_FILES['im_sertanah']['name'])) {
    //         $blob9->save($im_sertanah);
    //     }
    //     if (!empty($_FILES['im_imb']['name'])) {
    //         $blob10->save($im_imb);
    //     }
    //     if (!empty($_FILES['im_foto_op']['name'])) {
    //         $blob11->save($im_foto_op);
    //     }
    //     if (!empty($_FILES['im_sppt']['name'])) {
    //         $blob12->save($im_sppt);
    //     }
    //     if (!empty($_FILES['im_sk_pengurangan']['name'])) {
    //         $blob13->save($im_sk_pengurangan);
    //     }
    //     if (!empty($_FILES['im_other']['name'])) {
    //         $blob14->save($im_other);
    //     }
    //     oci_commit($connection);
    // }

    // function update_prm_blob_regesppt($param, $nik) {
    //     $im_ktp_re = '';
    //     $im_sppt_re = '';
    //     $im_stts_re = '';
    //     $fl_blob = array();
    //     $tbl_field = array();
    //     $tbl_field_return = array();
    //     $return_blob = array();
    //     if (!empty($_FILES['im_ktp_re']['name'])) {
    //         array_push($tbl_field, 'IM_KTP_BLOB=EMPTY_BLOB()');
    //         array_push($tbl_field_return, 'IM_KTP_BLOB');
    //         array_push($return_blob, ':blob1');
    //         $im_ktp_re = file_get_contents($_FILES['im_ktp_re']['tmp_name']);
    //     }
    //     if (!empty($_FILES['im_sppt_re']['name'])) {
    //         array_push($tbl_field, 'IM_SPPT_BLOB=EMPTY_BLOB()');
    //         array_push($tbl_field_return, 'IM_SPPT_BLOB');
    //         array_push($return_blob, ':blob2');
    //         $im_sppt_re = file_get_contents($_FILES['im_sppt_re']['tmp_name']);
    //     }
    //     if (!empty($_FILES['im_stts_re']['name'])) {
    //         array_push($tbl_field, 'IM_PBB_BLOB=EMPTY_BLOB()');
    //         array_push($tbl_field_return, 'IM_PBB_BLOB');
    //         array_push($return_blob, ':blob3');
    //         $im_stts_re = file_get_contents($_FILES['im_stts_re']['tmp_name']);
    //     }
        
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
    //     $qq = "UPDATE REG_ESPPT SET {$tbl_field_impl} 
    //     WHERE KD_PROPINSI||KD_DATI2||KD_KECAMATAN||KD_KELURAHAN||KD_BLOK||NO_URUT||KD_JNS_OP='{$param}' and NIK ='{$nik}'
    //     RETURNING {$tbl_field_return_impl} INTO {$return_blob_impl}";
    //     $result = oci_parse($connection, $qq);
    //     if (!empty($_FILES['im_ktp_re']['name'])) {
    //         $blob1 = oci_new_descriptor($connection, OCI_D_LOB);
    //         oci_bind_by_name($result, ":blob1", $blob1, -1, OCI_B_BLOB);
    //     }
    //     if (!empty($_FILES['im_sppt_re']['name'])) {
    //         $blob2 = oci_new_descriptor($connection, OCI_D_LOB);
    //         oci_bind_by_name($result, ":blob2", $blob2, -1, OCI_B_BLOB);
    //     }
    //     if (!empty($_FILES['im_stts_re']['name'])) {
    //         $blob3 = oci_new_descriptor($connection, OCI_D_LOB);
    //         oci_bind_by_name($result, ":blob3", $blob3, -1, OCI_B_BLOB);
    //     }

    //     $err = '';

    //     oci_execute($result, OCI_DEFAULT) or die("Unable to execute query; <br>" . $qq . '<br> Keterangan Error: <br>' . $err);
    //     if (!empty($_FILES['im_ktp_re']['name'])) {
    //         $blob1->save($im_spop);
    //     }
    //     if (!empty($_FILES['im_sppt_re']['name'])) {
    //         $blob2->save($im_sppt);
    //     }
    //     if (!empty($_FILES['im_stts_re']['name'])) {
    //         $blob3->save($im_stts);
    //     }
        
    //     oci_commit($connection);
    // }

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

        $sql = "SELECT {$field} FROM PST_PERMOHONAN_ONLINE
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
                    echo "<img src='data:image;base64,$gambar' width='500' height='500' >";
                }else{
                header("Content-type: application/pdf");
                print $img;
                }
            } else {
                echo 'Data Lampiran tidak ditemukan...';
            }
        }
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
    //         redirect(active_module_url('permohonan_online'));
    //     }

        
    //     $post_data = $this->fpost();
    //     // echo $post_data['nop']; die();

    //     $data['page_menu'] = 'permohonan_online';
    //     $data['current'] = '';
    //     $data['apps']    = $this->apps_model->get_active_only();
    //     $data['faction'] = active_module_url("permohonan_online/proses/");

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
    //             redirect(active_module_url('permohonan_online'));
    //         }
    //     }

    //     $get = (object)$post_data;
    //     $data['dt'] = $post_data;

    //     $this->load->view('vpermohonan_online', $data);
    // }

    // public function detail() {
    //     $nopthn     = $this->uri->segment(4);
    //     $nopthn     = str_replace(".", "", $nopthn);
    //     $nopthn     = str_replace("-", "", $nopthn);

    //     $dt = $this->permohonan_online_model->get($nopthn);

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

    //         $this->load->view('vpermohonan_online_detail', $data);

    //     } else {
    //         $this->session->set_flashdata('msg_success', 'Data tidak ditemukan..');
    //         redirect(active_module_url('permohonan_online'));
    //     }

    // }


}
