<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class update_reg extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_login()) {
            echo "<script>window.location.replace('" . base_url() . "');</script>";
            exit;
        }

        $module = 'update_reg';
        $this->load->library('module_auth', array(
            'module' => $module
        ));

        $this->load->model(array(
            'apps_model', 'update_reg_model'
        ));

        $this->load->helper(active_module());
    }

    public function index()
    {
        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect('eadm_bogor');
        }

        $data['page_menu'] = 'update_reg';
        $data['current'] = '';
        $data['apps']    = $this->apps_model->get_active_only();
        $option = array( 
            ''=> 'Semua Status','A' => 'Draft',
            '1' => 'Terima',
            '2' => 'Tolak');
        $js  = 'id="status_kd" style="width:130px;" class="input select2 form-control" ';
        $select = form_dropdown('status_kd', $option, '' , $js);
        $data['select_status'] = $select;
        $this->load->view('vupdate_reg', $data);
    }

    public function grid()
    {

       $status_kd = $this->input->get('status_kd');
       $tgl_start = date('Ymd',strtotime($this->input->get('tgl_start')));
       $tgl_end = date('Ymd',strtotime($this->input->get('tgl_end')));
        $this->load->library('Datatables');
        $this->datatables->select("ROW_NUMBER() OVER (ORDER BY KD_PROPINSI||'.'||KD_DATI2||'-'||RS.KD_KECAMATAN||'.'||KD_KELURAHAN||'-'||KD_BLOK||'.'||NO_URUT||'.'||KD_JNS_OP) as nomer, NIK, KD_PROPINSI||'.'||KD_DATI2||'-'||RS.KD_KECAMATAN||'.'||KD_KELURAHAN||'-'||KD_BLOK||'.'||NO_URUT||'.'||KD_JNS_OP AS NOPS, NAMA, NO_REG, CASE WHEN STATUS_VERIF=0 then 'Draft (0)' WHEN STATUS_VERIF=1 then 'Terima (1)' WHEN STATUS_VERIF=2 then 'Tolak (2)' END AS sts, STATUS_VERIF, TO_CHAR(CREATED_DATE,'DD-MM-YYYY') AS TGL_PERMOHONAN, TO_CHAR(CREATED_DATE, 'YYYYMMDDHH24MISSFF') AS CREA", false);
        $this->datatables->from("REG_ESPPT_TEMP RS");
        if(!empty($status_kd)){
            if($status_kd == 'A'){
                $status_kd = '0';
            }
            $this->datatables->where('STATUS_VERIF',$status_kd);
        }
        if(!empty($this->input->get('tgl_start'))){
         $this->datatables->where("CAST((TO_CHAR(CREATED_DATE,'YYYYMMDD')) AS NUMBER) >= {$tgl_start}");   
        }
        if(!empty($this->input->get('tgl_end'))){
         $this->datatables->where("CAST((TO_CHAR(CREATED_DATE,'YYYYMMDD')) AS NUMBER) <= {$tgl_end}");   
        }
        // $this->datatables->where("STA_OTP_EMAIL",'1');
        // $this->datatables->where("WL.NIP_VER_LOK",sipkd_user_nip());
        echo $this->datatables->generate();
    }

    public function action()
    {
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
            redirect(active_module_url('update_reg'));
        }

        $p_id  = $this->uri->segment(4);
        $sts  = $this->uri->segment(5);
        $crea_date  = $this->uri->segment(6);

        $rowid = $p_id;

        $data['page_menu'] = 'update_reg';
        $data['current'] = '';
        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = "";

        if ($p_id && $get = $this->update_reg_model->get_by_nik_sts($p_id,$sts, $crea_date)) {
            $data['dt']['rowid'] = $get->ID;
            $data['dt']['nik'] = get_string($get->NIK);
            $data['dt']['nm_wp_sppt']    = get_string($get->NM_WP_SPPT);
            $data['dt']['nohp'] = get_string($get->NOHP);
            $data['dt']['email'] = get_string($get->EMAIL);
            $data['dt']['loginname'] = get_string($get->LOGINNAME);
            $data['dt']['passwd'] = get_string($get->PASSWOD);
            $data['dt']['passen'] = get_string($get->PWD);

            // $passen = $data['dt']['passen'];
            // var_dump($passen);die;

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
            $data['dt']['crea_date'] = $get->CREA_DATE;

            $this->load->view('vupdate_reg_form', $data);
        } else {
            show_404();
        }
    }

    public function detail()
    {
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
            redirect(active_module_url('update_reg'));
        }

        $p_id  = $this->uri->segment(4);
        $sts  = $this->uri->segment(5);
        $crea_date = $this->uri->segment(6);

        $rowid = $p_id;

        $data['page_menu'] = 'update_reg';
        $data['current'] = '';
        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = "";

        if ($p_id && $get = $this->update_reg_model->get_by_nik_sts($p_id, $sts, $crea_date)) {
            $data['dt']['rowid'] = $get->ID;
            $data['dt']['nik'] = get_string($get->NIK);
            $data['dt']['nm_wp_sppt'] = get_string($get->NM_WP_SPPT);
            $data['dt']['nohp'] = get_string($get->NOHP);
            $data['dt']['email'] = get_string($get->EMAIL);
            $data['dt']['loginname'] = get_string($get->LOGINNAME);
            $data['dt']['passwd'] = get_string($get->PD);
            $data['dt']['passen'] = get_string($get->PWD);

            // $passen = $data['dt']['passen'];
            // var_dump($passen);die;

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
            $data['dt']['crea_date'] = $get->CREA_DATE;
            $data['dt']['status_verif'] = $get->STATUS_VERIF;

            $this->load->view('vupdate_reg_form_view', $data);
        } else {
            show_404();
        }
    }

    public function openblob()
    {
        $field   = $this->uri->segment(4);
        $nik    = $this->uri->segment(5);
        $sts_verif = $this->uri->segment(6);
        $crea_date = $this->uri->segment(7);
        $field = strtoupper($field);

        $dbhost = DB_HOST;
        $dbport = DB_PORT;
        $dbname = DB_NAME;
        $dbuser = DB_USER;
        $dbpass = DB_PASS;

        $tnslistener = '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST='.DB_HOST.')(PORT='.DB_PORT.'))(CONNECT_DATA=(SERVICE_NAME='.DB_NAME.')))';

        $connection = oci_connect($dbuser, $dbpass, $tnslistener);

        $sql = "SELECT {$field} FROM REG_ESPPT_TEMP WHERE NIK = '{$nik}' AND STATUS_VERIF='$sts_verif' AND TO_CHAR(CREATED_DATE, 'YYYYMMDDHH24MISSFF')='$crea_date'";

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

    public function simpan()
    {
        // $nik  = $this->uri->segment(4);
        // $sts  = $this->uri->segment(5);
        // $crea_date = $this->uri->segment(6);

        // $nop = str_replace(['.', ',', '-'], '', $nop);
        // $prop_kd = substr($nop, 0, 2);
        // $kab_kd  = substr($nop, 2, 2);
        // $kec_kd  = substr($nop, 4, 3);
        // $kel_kd  = substr($nop, 7, 3);
        // $blok_kd = substr($nop, 10, 3);
        // $urut_no = substr($nop, 13, 4);
        // $jns_kd  = substr($nop, 17, 1);

        $sts = $this->input->post('status_verif');
        $crea_date = $this->input->post('crea_date');

        $nop = $this->input->post('nop_lengkap');
        $jalan = $this->input->post('jln_op_sppt');
        $blok = $this->input->post('blok_kav_no_op_sppt');
        $kec = $this->input->post('kecamatan_op_nama');
        $kel = $this->input->post('kelurahan_op_nama');
        $rt = $this->input->post('rt_op_sppt');
        $rw = $this->input->post('rw_op_sppt');

        $nik = $this->input->post('nik');
        $nama = $this->input->post('nm_wp_sppt');
        $nohp = $this->input->post('nohp');
        $email = $this->input->post('email');
        $loginname = $this->input->post('loginname');
        $pass = $this->input->post('passwd');

        $pass_enc = $this->load->model('users_model')->encript_value($nik, $pass);
        $pass_enc = get_string($pass_enc->FN_KEYLOCK);

        // var_dump($pass_enc);
        // die();

        // $qq = "START TRANSACTION;

        // UPDATE REG_ESPPT_TEMP
        // SET JLN_OP_SPPT = '{$jalan}',
        // BLOK_KAV_NO_OP_SPPT = '{$blok}',
        // RW_OP_SPPT = '{$rw}',
        // RT_OP_SPPT = '{$rt}',
        // NM_WP_SPPT = '{$nama}',
        // NOHP = '{$nohp}',
        // EMAIL = '{$email}',
        // PASSWOD = '{$pass}'
        // WHERE NIK = '{$nik}'
        // AND STA_OTP_EMAIL = '{$sts}'
        // AND TO_CHAR(CREATED_DATE, 'YYYYMMDDHH24MISSFF') = '{$crea_date}';

        // UPDATE SEC_USERS
        // SET NAMA = '{$nama}',
        // HANDPHONE = '{$nohp}',
        // PASSWD = '{$pass}'
        // WHERE USERID = '{$nik}';

        // COMMIT;";

        // $insert_result = $this->db->query($qq);
        // if($insert_result == true){
        //   $this->session->set_flashdata('msg_success', 'Berhasil');
        //   redirect(base_url('eadm_depok/update_reg'));
        // }else{
        //   $this->session->set_flashdata('msg_success', 'Gagal');
        //   redirect(base_url('eadm_depok/update_reg'));
        // }

        $this->db->trans_start();

        // Query update REG_ESPPT_TEMP
        $query1 = "
            UPDATE REG_ESPPT_TEMP
            SET JLN_OP_SPPT = ?,
                BLOK_KAV_NO_OP_SPPT = ?,
                RW_OP_SPPT = ?,
                RT_OP_SPPT = ?,
                NM_WP_SPPT = ?,
                NOHP = ?,
                EMAIL = ?,
                PASSWOD = ?,
                NAMA = ?
            WHERE NIK = ?
              AND STA_OTP_EMAIL = ?
              AND TO_CHAR(CREATED_DATE, 'YYYYMMDDHH24MISSFF') = ?";

        $this->db->query($query1, array(
            $jalan, $blok, $rw, $rt, $nama, $nohp, $email, $pass, $nama, $nik, $sts, $crea_date
        ));

        // Query update SEC_USERS
        $query2 = "
            UPDATE SEC_USERS
            SET NAMA = ?,
                HANDPHONE = ?,
                PASSWD = ?
            WHERE USERID = ?";

        $this->db->query($query2, array(
            $nama, $nohp, $pass_enc, $nik
        ));

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            // Gagal
            $this->session->set_flashdata('msg_warning', 'Gagal');
            $this->db->trans_rollback();
        } else {
            // Berhasil
            $this->session->set_flashdata('msg_success', 'Berhasil');
        }

        redirect(base_url('eadm_bogor/update_reg'));
    }
}
