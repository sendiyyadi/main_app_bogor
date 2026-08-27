<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class daftar_nop extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_login()) {
            echo "<script>window.location.replace('" . base_url() . "');</script>";
            exit;
        }

        $module = 'daftar_nop';
        $this->load->library('module_auth', array(
            'module' => $module
        ));

        $this->load->model(array(
            'apps_model', 'daftar_nop_model'
        ));

        $this->load->helper(active_module());
    }

    public function index()
    {
        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect('eadm_bogor');
        }

        $data['page_menu'] = 'daftar_nop';
        $data['current'] = '';
        $data['apps']    = $this->apps_model->get_active_only();
        $option = array( ''=> 'Semua Status','A' => 'Draft',
            '1' => 'Terima',
            '2' => 'Tolak');
        $js  = 'id="status_kd" style="width:130px;" class="input form-control select2" ';
        $select = form_dropdown('status_kd', $option, '' , $js);
        $data['select_status'] = $select;
        $this->load->view('vdaftar_nop', $data);
    }

    public function grid()
    {

        //$prop = sipkd_kd_propinsi();
        //log_message('info', "BBBBBBBBBB CREATE MODULE : " .$prop );
        $status_kd = $this->input->get('status_kd');
        $this->load->library('Datatables');
        $this->datatables->select("ID, NOP, ALAMAT_OP, NIK, NM_WP_SPPT, ALAMAT_WP, KELURAHAN_WP_SPPT, KOTA_WP_SPPT,
                                  CASE WHEN STATUS_REGISTRASI=0 then 'Draft (0)'
                                  WHEN STATUS_REGISTRASI=1 then 'Terima (1)'
                                  WHEN STATUS_REGISTRASI=2 then 'Tolak (2)' END AS sts, STATUS_REGISTRASI", false);
        $this->datatables->from("V_EADM_NEW");
        if(!empty($status_kd)){
            if($status_kd == 'A'){
                $status_kd = '0';
            }
            $this->datatables->where('STATUS_REGISTRASI',$status_kd);
        }
        echo $this->datatables->generate();
    }

    private function fvalidation($jenis_daftar_nop = null)
    {
        if ($jenis_daftar_nop == 'approve') {
            $this->form_validation->set_error_delimiters('<span>', '</span>');
            $this->form_validation->set_rules('kd_kecamatan', 'Kode Kecamatan', 'required|trim|max_length[3]|min_length[3]|regex_match[/^[0-9]{3}$/]|callback_cek_nop_avail[]|callback_cek_kec[]');
            $this->form_validation->set_rules('kd_kelurahan', 'Kode Kelurahan', 'required|trim|max_length[3]|min_length[3]|regex_match[/^[0-9]{3}$/]|callback_cek_kel[]');
            $this->form_validation->set_rules('kd_blok', 'Kode Blok', 'required|trim|max_length[3]|min_length[3]|regex_match[/^[0-9]{3}$/]');
            $this->form_validation->set_rules('no_urut', 'No Urut', 'required|trim|max_length[4]|min_length[4]|regex_match[/^[0-9]{4}$/]');
            $this->form_validation->set_rules('kd_jns_op', 'Kode Jenis OP', 'required|trim|max_length[1]|min_length[1]|regex_match[/^[0-9]{1}$/]');
            $this->form_validation->set_rules('kd_znt', 'Kode ZNT', 'required|trim|max_length[2]|min_length[2]|regex_match[/^[A-Z0-9]{2}$/]|callback_cek_znt[]');
        }

        if ($jenis_daftar_nop == 'tolak') {
            $this->form_validation->set_error_delimiters('<span>', '</span>');
        }
    }

    private function fpost()
    {
        $data['rowid'] = post_string($this->input->post('rowid'));
        $data['nik'] = post_string($this->input->post('nik'));
        $data['passwd'] = post_string($this->input->post('passwd'));
        $data['nm_wp_sppt'] = post_string($this->input->post('nm_wp_sppt'));
        $data['jln_wp_sppt'] = post_string($this->input->post('jln_wp_sppt'));
        $data['blok_kav_no_wp_sppt'] = post_string($this->input->post('blok_kav_no_wp_sppt'));
        $data['rt_wp_sppt'] = post_string($this->input->post('rt_wp_sppt'));
        $data['rw_wp_sppt'] = post_string($this->input->post('rw_wp_sppt'));
        $data['kelurahan_wp_sppt'] = post_string($this->input->post('kelurahan_wp_sppt'));
        $data['kota_wp_sppt'] = post_string($this->input->post('kota_wp_sppt'));
        $data['kd_pos_wp_sppt'] = post_string($this->input->post('kd_pos_wp_sppt'));
        $data['npwp'] = post_string($this->input->post('npwp'));
        $data['nohp'] = post_string($this->input->post('nohp'));
        $data['email'] = post_string($this->input->post('email'));
        $data['jln_op_sppt'] = post_string($this->input->post('jln_op_sppt'));
        $data['blok_kav_no_op_sppt'] = post_string($this->input->post('blok_kav_no_op_sppt'));
        $data['rt_op_sppt'] = post_string($this->input->post('rt_op_sppt'));
        $data['rw_op_sppt'] = post_string($this->input->post('rw_op_sppt'));
        $data['nop_ttg_1'] = post_string($this->input->post('nop_ttg_1'));
        $data['nop_ttg_2'] = post_string($this->input->post('nop_ttg_2'));
        $data['alamat_op_1'] = post_string($this->input->post('alamat_op_1'));
        $data['alamat_op_2'] = post_string($this->input->post('alamat_op_2'));
        $data['kd_propinsi'] = post_string($this->input->post('kd_propinsi'));
        $data['kd_dati2']    = post_string($this->input->post('kd_dati2'));
        $data['kd_kecamatan'] = post_string($this->input->post('kd_kecamatan'));
        $data['kd_kelurahan'] = post_string($this->input->post('kd_kelurahan'));
        $data['kd_blok'] = post_string($this->input->post('kd_blok'));
        $data['no_urut'] = post_string($this->input->post('no_urut'));
        $data['kd_jns_op'] = post_string($this->input->post('kd_jns_op'));
        $data['kd_znt'] = post_string($this->input->post('kd_znt'));
        $data['alasan'] = post_string($this->input->post('alasan'));
        return $data;
    }

    public function cek_nop_avail($value)
    {
        $rowid = $this->input->post('rowid');
        $kd_propinsi = $this->input->post('kd_propinsi');
        $kd_dati2 = $this->input->post('kd_dati2');
        $kd_kecamatan = $this->input->post('kd_kecamatan');
        $kd_kelurahan = $this->input->post('kd_kelurahan');
        $kd_blok = $this->input->post('kd_blok');
        $no_urut = $this->input->post('no_urut');
        $kd_jns_op = $this->input->post('kd_jns_op');

        // if(empty($rowid)) {$rowid ="0";}
        //
        if ($this->daftar_nop_model->cek_nop_avail($kd_propinsi, $kd_dati2, $kd_kecamatan, $kd_kelurahan, $kd_blok, $no_urut, $kd_jns_op)) {
            $this->form_validation->set_message('cek_nop_avail', 'NOP tsb sudah ada.....!');
            return false;
        } else {
            return true;
        }
    }

    public function cek_kec($value)
    {
        $kd_kecamatan = $this->input->post('kd_kecamatan');
        if ($this->daftar_nop_model->cek_kec($kd_kecamatan)) {
            $this->form_validation->set_message('cek_kec', 'Kode Kecamatan tidak ada di Tabel Referensi.....!');
            return false;
        } else {
            return true;
        }
    }

    public function cek_kel($value)
    {
        $kd_kelurahan = $this->input->post('kd_kelurahan');
        $kd_kecamatan = $this->input->post('kd_kecamatan');
        if ($this->daftar_nop_model->cek_kel($kd_kecamatan, $kd_kelurahan)) {
            $this->form_validation->set_message('cek_kel', 'Kode Kelurahan tidak ada di Tabel Referensi.....!');
            return false;
        } else {
            return true;
        }
    }

    public function cek_znt($value)
    {
        $kd_znt = $this->input->post('kd_znt');
        $kd_kelurahan = $this->input->post('kd_kelurahan');
        $kd_kecamatan = $this->input->post('kd_kecamatan');
        $kd_blok = $this->input->post('kd_blok');
        if ($this->daftar_nop_model->cek_znt($kd_kecamatan, $kd_kelurahan, $kd_blok, $kd_znt)) {
            $this->form_validation->set_message('cek_znt', 'Kode ZNT tidak ada di Tabel Referensi.....!');
            return false;
        } else {
            return true;
        }
    }

    public function action()
    {
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
            redirect(active_module_url('daftar_nop'));
        }

        $p_id  = $this->uri->segment(4);
        // $p_id  = $this->input->get('row_id', true);
        // $p_id  = $_GET['row_id'];
        // echo $p_id;
        // die();

        $rowid = $p_id;

        $data['page_menu'] = 'daftar_nop';
        $data['current'] = '';
        $data['apps']    = $this->apps_model->get_active_only();
        // $data['faction'] = active_module_url("daftar_nop/update/{$p_id}");
        $data['faction'] = "";

        if ($p_id && $get = $this->daftar_nop_model->get_by_nik($p_id)) {
            $data['dt']['rowid'] = $get->ID;
            $data['dt']['nik'] = get_string($get->NIK);
            $data['dt']['passwd'] = get_string($get->PASSWOD);
            $data['dt']['nm_wp_sppt']    = get_string($get->NM_WP_SPPT);
            $data['dt']['jln_wp_sppt'] = get_string($get->JLN_WP_SPPT);
            $data['dt']['blok_kav_no_wp_sppt'] = get_string($get->BLOK_KAV_NO_WP_SPPT);
            $data['dt']['rt_wp_sppt'] = get_string($get->RT_WP_SPPT);
            $data['dt']['rw_wp_sppt'] = get_string($get->RW_WP_SPPT);
            $data['dt']['kelurahan_wp_sppt'] = get_string($get->KELURAHAN_WP_SPPT);
            $data['dt']['kota_wp_sppt'] = get_string($get->KOTA_WP_SPPT);
            $data['dt']['kd_pos_wp_sppt'] = get_string($get->KD_POS_WP_SPPT);
            $data['dt']['npwp'] = get_string($get->NPWP_SPPT);
            $data['dt']['nohp'] = get_string($get->NOHP);
            $data['dt']['email'] = get_string($get->EMAIL);

            $data['dt']['jln_op_sppt'] = get_string($get->JLN_OP_SPPT);
            $data['dt']['blok_kav_no_op_sppt'] = get_string($get->BLOK_KAV_NO_OP_SPPT);
            $data['dt']['rt_op_sppt'] = get_string($get->RT_OP_SPPT);
            $data['dt']['rw_op_sppt'] = get_string($get->RW_OP_SPPT);
            $data['dt']['nop_ttg_1'] = get_string($get->NOP_TTG_1);
            $data['dt']['nop_ttg_2'] = get_string($get->NOP_TTG_2);
            // $data['dt']['nama_wp_1'] = get_string($get->NAMA_WP_1);
            // $data['dt']['nama_wp_2'] = get_string($get->NAMA_WP_2);
            $data['dt']['alamat_op_1'] = get_string($get->JLN_OP_SPPT1);
            $data['dt']['alamat_op_2'] = get_string($get->JLN_OP_SPPT2);

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

            $this->load->view('vdaftar_nop_form', $data);
        } else {
            show_404();
        }
    }

    public function detail()
    {
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
            redirect(active_module_url('daftar_nop'));
        }

        $p_id  = $this->uri->segment(4);
        // $p_id  = $this->input->get('row_id', true);
        // $p_id  = $_GET['row_id'];
        // echo $p_id;
        // die();

        $rowid = $p_id;

        $data['page_menu'] = 'daftar_nop';
        $data['current'] = '';
        $data['apps']    = $this->apps_model->get_active_only();
        // $data['faction'] = active_module_url("daftar_nop/update/{$p_id}");
        $data['faction'] = "";

        if ($p_id && $get = $this->daftar_nop_model->get_by_nik($p_id)) {
            $data['dt']['rowid'] = $get->ID;
            $data['dt']['nik'] = get_string($get->NIK);
            $data['dt']['passwd'] = get_string($get->PASSWOD);
            $data['dt']['nm_wp_sppt']    = get_string($get->NM_WP_SPPT);
            $data['dt']['jln_wp_sppt'] = get_string($get->JLN_WP_SPPT);
            $data['dt']['blok_kav_no_wp_sppt'] = get_string($get->BLOK_KAV_NO_WP_SPPT);
            $data['dt']['rt_wp_sppt'] = get_string($get->RT_WP_SPPT);
            $data['dt']['rw_wp_sppt'] = get_string($get->RW_WP_SPPT);
            $data['dt']['kelurahan_wp_sppt'] = get_string($get->KELURAHAN_WP_SPPT);
            $data['dt']['kota_wp_sppt'] = get_string($get->KOTA_WP_SPPT);
            $data['dt']['kd_pos_wp_sppt'] = get_string($get->KD_POS_WP_SPPT);
            $data['dt']['npwp'] = get_string($get->NPWP_SPPT);
            $data['dt']['nohp'] = get_string($get->NOHP);
            $data['dt']['email'] = get_string($get->EMAIL);

            $data['dt']['jln_op_sppt'] = get_string($get->JLN_OP_SPPT);
            $data['dt']['blok_kav_no_op_sppt'] = get_string($get->BLOK_KAV_NO_OP_SPPT);
            $data['dt']['rt_op_sppt'] = get_string($get->RT_OP_SPPT);
            $data['dt']['rw_op_sppt'] = get_string($get->RW_OP_SPPT);
            $data['dt']['nop_ttg_1'] = get_string($get->NOP_TTG_1);
            $data['dt']['nop_ttg_2'] = get_string($get->NOP_TTG_2);
            // $data['dt']['nama_wp_1'] = get_string($get->NAMA_WP_1);
            // $data['dt']['nama_wp_2'] = get_string($get->NAMA_WP_2);
            $data['dt']['alamat_op_1'] = get_string($get->JLN_OP_SPPT1);
            $data['dt']['alamat_op_2'] = get_string($get->JLN_OP_SPPT2);

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

            $this->load->view('vdaftar_nop_form_view', $data);
        } else {
            show_404();
        }
    }

    public function approve()
    {
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
            redirect(active_module_url('daftar_nop'));
        }

        $p_id       = $this->uri->segment(4);
        $post_data = $this->fpost();

        $rowid  = $this->input->post('rowid');
        $nik    = $this->input->post('nik');
        $pass   = $this->input->post('passwd');
        $namawp = $this->input->post('nm_wp_sppt');
        $nohp   = $this->input->post('nohp');

        $data['page_menu'] = 'daftar_nop';
        $data['current'] = '';
        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = '';
        // $data['faction'] = active_module_url("daftar_nop/update/{$p_id}");

        $this->fvalidation('approve');

        if ($this->form_validation->run() == true) {
            $input_post  = $post_data;

            $update_data = array(
                'STATUS_REGISTRASI' => 1,
                'USER_GROUP' => 4,
                'KD_PROPINSI'   => $this->input->post('kd_propinsi'),
                'KD_DATI2'      => $this->input->post('kd_dati2'),
                'KD_KECAMATAN'  => $this->input->post('kd_kecamatan'),
                'KD_KELURAHAN'  => $this->input->post('kd_kelurahan'),
                'KD_BLOK'       => $this->input->post('kd_blok'),
                'NO_URUT'       => $this->input->post('no_urut'),
                'KD_JNS_OP'     => $this->input->post('kd_jns_op'),
                'KD_ZNT'        => $this->input->post('kd_znt'),
                'ALASAN'        => $this->input->post('alasan'),
                'NIP_REKAM'     => $this->session->userdata('nip'),
            );

            $result = $this->daftar_nop_model->update_data_reg_espptdb_by_nik($nik, $update_data);
            // $result = '';
            if (!empty($result)) {
                set_msg_db_error($result);
            } else {
                $pass_enc = $this->load->model('users_model')->encript_value($nik, $pass);
                $id_user = $this->daftar_nop_model->nextid_user();
                // echo $id_user;

                $user_data = array(
                  'ID'            => get_string($id_user->NEXT_ID),
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
                  'USER_ID'       => get_string($id_user->NEXT_ID),
                  'GROUP_ID'      => 2,
                );

                // echo json_encode($user_data);
                // die();

                $xxx = $this->daftar_nop_model->insert_user($user_data);
                $this->daftar_nop_model->insert_user_group($user_group_data);

                $this->session->set_flashdata('msg_success', 'Data telah disimpan');
                // echo $xxx;
                // die();
                redirect(active_module_url('daftar_nop'));
            }
        }

        $get = (object)$post_data;
        $data['dt'] = $post_data;

        $this->load->view('vdaftar_nop_form', $data);
    }

    public function tolak()
    {
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
            redirect(active_module_url('daftar_nop'));
        }

        $p_id       = $this->uri->segment(4);
        $post_data = $this->fpost();

        $rowid  = $this->input->post('rowid');
        $nik    = $this->input->post('nik');

        $data['page_menu'] = 'daftar_nop';
        $data['current'] = '';
        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = '';
        // $data['faction'] = active_module_url("daftar_nop/update/{$p_id}");

        $this->fvalidation('tolak');

        // if ($this->form_validation->run() == true) {
        $input_post  = $post_data;

        $update_data = array(
                'STATUS_REGISTRASI' => 2,
                'USER_GROUP' => 3,
            );

        $result = $this->daftar_nop_model->update_data_reg_espptdb_by_nik($nik, $update_data);
        if (!empty($result)) {
            set_msg_db_error($result);
        } else {
            $this->session->set_flashdata('msg_success', 'Data telah disimpan');
            redirect(active_module_url('daftar_nop'));
        }
        // }

        $get = (object)$post_data;
        $data['dt'] = $post_data;

        // $this->load->view('vdaftar_nop_form', $data);
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

        $sql = "SELECT {$field} FROM REG_ESPPTDB WHERE NIK = '{$nik}'";

        $stid = oci_parse($connection, $sql);

        oci_execute($stid);
        $row = oci_fetch_array($stid, OCI_RETURN_NULLS);

        if (!$row) {
            header('Status: 404 Not Found');
        } else {
            $img = $row[$field]->load();
            header("Content-type: application/pdf");
            print $img;
        }
    }
}
