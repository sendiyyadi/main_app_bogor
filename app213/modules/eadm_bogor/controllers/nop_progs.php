<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class nop_progs extends CI_Controller
{
    private $controller = 'nop_prog';
    public function __construct()
    {
        parent::__construct();
        if (!is_login()) {
            echo "<script>window.location.replace('" . base_url() . "');</script>";
            exit;
        }

        $module = 'nop_prog';
        $this->load->library('module_auth', array(
            'module' => $module
        ));

        $this->load->model(array(
            'apps_model', 'nop_prog_model'
        ));

        $this->load->helper(active_module());
    }

    public function index()
    {
        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect('eadm_bogor');
        }

        $data['page_menu'] = 'nop_prog';
        $data['current'] = '';
        $data['controller'] = $this->controller;
        $data['apps']    = $this->apps_model->get_active_only();
        $option = array( ''=> 'Semua Status','A' => 'Draft',
            '1' => 'Terima',
            '2' => 'Tolak');
        $js  = 'id="status_kd" style="width:130px;" class="form-control" ';
        $select = form_dropdown('status_kd', $option, '' , $js);
        $data['select_status'] = $select;
        $this->load->view('vnop_prog', $data);
    }

    public function grid()
    {

       $status_kd = $this->input->get('status_kd');
       $tgl_start = date('Ymd',strtotime($this->input->get('tgl_start')));
       $tgl_end = date('Ymd',strtotime($this->input->get('tgl_end')));
        $this->load->library('Datatables');
        $this->datatables->select(" RD.KD_PROPINSI||RD.KD_DATI2||RD.KD_KECAMATAN||RD.KD_KELURAHAN||RD.KD_BLOK||RD.NO_URUT||RD.KD_JNS_OP||TRIM(RD.NIK) AS IDX ,ROW_NUMBER() OVER (ORDER BY RS.KD_PROPINSI||'.'||RS.KD_DATI2||'-'||RS.KD_KECAMATAN||'.'||RS.KD_KELURAHAN||'-'||RS.KD_BLOK||'.'||RS.NO_URUT||'.'||RS.KD_JNS_OP) as nomer, RS.NIK, RS.KD_PROPINSI||'.'||RS.KD_DATI2||'-'||RS.KD_KECAMATAN||'.'||RS.KD_KELURAHAN||'-'||RS.KD_BLOK||'.'||RS.NO_URUT||'.'||RS.KD_JNS_OP AS NOPS, RS.NAMA, RD.NO_PERMOHONAN, CASE WHEN RS.STATUS=0 then 'Draft (0)' WHEN RS.STATUS=1 then 'Terima (1)' WHEN RS.STATUS=2 then 'Tolak (2)' END AS sts, RS.STATUS, TO_CHAR(RS.CREATE_TIME,'DD-MM-YYYY') AS TGL_PERMOHONAN, TO_CHAR(RS.CREATE_TIME, 'YYYYMMDDHH24MISSFF') AS CREA", false);
        $this->datatables->from("REG_ESPPT RS");
        $this->datatables->join('REG_ESPPT_D RD','RD.KD_PROPINSI=RS.KD_PROPINSI AND RD.KD_DATI2=RS.KD_DATI2 AND RD.KD_KECAMATAN=RS.KD_KECAMATAN AND RD.KD_KELURAHAN=RS.KD_KELURAHAN AND RD.KD_BLOK=RS.KD_BLOK AND RD.NO_URUT=RS.NO_URUT AND RD.KD_JNS_OP=RS.KD_JNS_OP','INNER');
        // $this->datatables->join("WILAYAH_PEGAWAI WL","WL.KD_KECAMATAN=RS.KD_KECAMATAN",'LEFT');
        if(!empty($this->input->get('tgl_start'))){
         $this->datatables->where("CAST((TO_CHAR(RS.CREATE_TIME,'YYYYMMDD')) AS NUMBER) >= {$tgl_start}");
        }
        if(!empty($this->input->get('tgl_end'))){
         $this->datatables->where("CAST((TO_CHAR(RS.CREATE_TIME,'YYYYMMDD')) AS NUMBER) <= {$tgl_end}");
        }
        if(!empty($status_kd)){
            if($status_kd == 'A'){
                $status_kd = '0';
            }
            $this->datatables->where('RS.STATUS',$status_kd);
        }

        echo $this->datatables->generate();
    }

    private function fvalidation($jenis_nop_prog = null)
    {
        if ($jenis_nop_prog == 'approve') {
            $this->form_validation->set_error_delimiters('<span>', '</span>');
        }

        if ($jenis_nop_prog == 'tolak') {
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
            redirect(active_module_url('nop_prog'));
        }
        $p_id  = $this->uri->segment(4);
        $data['page_menu'] = 'nop_prog';
        $data['current'] = '';
        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = active_module_url().$this->controller."/approve";
        $data['controller'] = $this->controller;
        if ($p_id && $get = $this->nop_prog_model->get_view($p_id)) {
            $data['dt']['f_nop'] = $get->KD_PROPINSI.'.'.$get->KD_DATI2.'.'.$get->KD_KECAMATAN.'.'.$get->KD_KELURAHAN.'.'.$get->KD_BLOK.'.'.$get->NO_URUT.'.'.$get->KD_JNS_OP;
            $data['dt']['no_prm'] = $get->NO_PERMOHONAN;
            $data['dt']['nama_wp'] = $get->NAMA;
            $data['dt']['alamat_op'] = $get->JALAN_OP.' '.$get->BLOK_KAV_NO_OP.' Rt.'.$get->RT_OP.' Rw.'.$get->RW_OP;
            $data['dt']['kel_top'] = $get->NM_KELURAHAN;
            $data['dt']['kec_top'] = $get->NM_KECAMATAN;
            $data['dt']['rt_op'] = $get->RT_OP;
            $data['dt']['rw_op'] = $get->RW_OP;
            $data['dt']['niknop'] = $get->NIKNOP;
            $data['dt']['p_id'] = $p_id;
            $data['p_id'] = $p_id;
            $data['dt']['ket_tolak'] = '';
            $tidak_ada = '<p class="teks_red">File Tidak Ada</p>';
            $im_sppt_blob  = $get->IM_SPPT_BLOB > 0 ? $this->btn_file('IM_SPPT_BLOB',$p_id) : $tidak_ada;
            $im_pbb_blob  = $get->IM_PBB_BLOB > 0 ? $this->btn_file('IM_PBB_BLOB',$p_id) : $tidak_ada;
             $data['dt']['IM_SPPT_BLOB'] = $im_sppt_blob;
             $data['dt']['IM_PBB_BLOB'] = $im_pbb_blob;
            $this->load->view('vnop_prog_form', $data);
        }
    }

     public function detail()
    {
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
            redirect(active_module_url('nop_prog'));
        }
        $p_id  = $this->uri->segment(4);
        $data['page_menu'] = 'nop_prog';
        $data['current'] = '';
        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = active_module_url().$this->controller."/approve";
        $data['controller'] = $this->controller;
        if ($p_id && $get = $this->nop_prog_model->get_view($p_id)) {
            $data['dt']['f_nop'] = $get->KD_PROPINSI.'.'.$get->KD_DATI2.'.'.$get->KD_KECAMATAN.'.'.$get->KD_KELURAHAN.'.'.$get->KD_BLOK.'.'.$get->NO_URUT.'.'.$get->KD_JNS_OP;
            $data['dt']['no_prm'] = $get->NO_PERMOHONAN;
            $data['dt']['nama_wp'] = $get->NAMA;
            $data['dt']['alamat_op'] = $get->JALAN_OP.' '.$get->BLOK_KAV_NO_OP.' Rt.'.$get->RT_OP.' Rw.'.$get->RW_OP;
            $data['dt']['kel_top'] = $get->NM_KELURAHAN;
            $data['dt']['kec_top'] = $get->NM_KECAMATAN;
            $data['dt']['rt_op'] = $get->RT_OP;
            $data['dt']['rw_op'] = $get->RW_OP;
            $data['dt']['niknop'] = $get->NIKNOP;
            $data['dt']['p_id'] = $p_id;
            $data['p_id'] = $p_id;
            $data['dt']['ket_tolak'] = '';
            $tidak_ada = '<p class="teks_red">File Tidak Ada</p>';
            $im_sppt_blob  = $get->IM_SPPT_BLOB > 0 ? $this->btn_file('IM_SPPT_BLOB',$p_id) : $tidak_ada;
            $im_pbb_blob  = $get->IM_PBB_BLOB > 0 ? $this->btn_file('IM_PBB_BLOB',$p_id) : $tidak_ada;
             $data['dt']['IM_SPPT_BLOB'] = $im_sppt_blob;
             $data['dt']['IM_PBB_BLOB'] = $im_pbb_blob;
            $this->load->view('vnop_prog_form', $data);
        }
    }

 function btn_file($field, $p_id){
        $url = active_module_url().$this->controller.'/openblob/'.$field.'/'.$p_id;
        $btn = '<a target="_blank" href="'.$url.'" class="btn btn-primary " data-toggle="tooltip" title="View"></i> Lihat File</a>';
        return $btn;
    }
    public function approve()
    {
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
            redirect(active_module_url('nop_prog'));
        }

        $p_id       = $this->uri->segment(4);
        $po_id       = $this->input->post('p_id');

        $data['page_menu'] = 'nop_prog';
        $data['current'] = '';
        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = '';
        // $data['faction'] = active_module_url("nop_prog/update/{$p_id}");
        if($p_id == $po_id){
        $q1 = "UPDATE REG_ESPPT SET STATUS='1' WHERE KD_PROPINSI||KD_DATI2||KD_KECAMATAN||KD_KELURAHAN||KD_BLOK||NO_URUT||KD_JNS_OP||TRIM(NIK)='$po_id' ";
        $this->db->query($q1);

        $q2 = "UPDATE REG_ESPPT_D SET STATUS='1' WHERE KD_PROPINSI||KD_DATI2||KD_KECAMATAN||KD_KELURAHAN||KD_BLOK||NO_URUT||KD_JNS_OP||TRIM(NIK)='$po_id' ";
        $this->db->query($q2);

        $this->session->set_flashdata('msg_success', 'Data Berhasil Approve');
        redirect(active_module_url($this->controller));
        }else{
        $this->session->set_flashdata('msg_warning', 'Data Tidak Valid');
        redirect(active_module_url($this->controller));
        }

    }

   public function tolak()
    {
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
            redirect(active_module_url('nop_prog'));
        }

        $p_id         = $this->uri->segment(4);
        $po_id        = $this->input->post('p_id');
        $ket_tolak    = $this->input->post('ket_tolak');
        $nop_pemohon  = $this->input->post('f_nop');
        $string_replace = array('.','-');
        $nop_pemohon   = str_replace($string_replace, '',$nop_pemohon);
        $data['page_menu'] = 'nop_prog';
        $data['current'] = '';
        $data['apps']    = $this->apps_model->get_active_only();
        if($p_id == $po_id){
            // $q1 = "UPDATE REG_ESPPT SET STATUS='2' WHERE KD_PROPINSI||KD_DATI2||KD_KECAMATAN||KD_KELURAHAN||KD_BLOK||NO_URUT||KD_JNS_OP||TRIM(NIK)='$po_id' ";
            // $this->db->query($q1);
            //
            // $q2 = "UPDATE REG_ESPPT_D SET STATUS='2', KETERANGAN='$ket_tolak' WHERE KD_PROPINSI||KD_DATI2||KD_KECAMATAN||KD_KELURAHAN||KD_BLOK||NO_URUT||KD_JNS_OP||TRIM(NIK)='$po_id' ";
            // $this->db->query($q2);

            //// PAKE YG BARU LANGUNG HAPUS REGSPPT dan REGSPPT_D _edSen 01092022
            $q1 = "DELETE REG_ESPPT WHERE KD_PROPINSI||KD_DATI2||KD_KECAMATAN||KD_KELURAHAN||KD_BLOK||NO_URUT||KD_JNS_OP||TRIM(NIK)='$po_id' ";
            $this->db->query($q1);

            $q2 = "DELETE REG_ESPPT_D WHERE KD_PROPINSI||KD_DATI2||KD_KECAMATAN||KD_KELURAHAN||KD_BLOK||NO_URUT||KD_JNS_OP||TRIM(NIK)='$po_id' ";
            $this->db->query($q2);

            $email_wp = $this->nop_prog_model->get_email($nop_pemohon);

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

            $message = "Mohon maaf Pengajuan NOP Progressive PBB Online anda tidak dapat diproses lebih lanjut dikarenakan {$ket_tolak} Silakan ajukan permohonan ulang. Terima kasih.";

            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from(EMAIL_EADM, SMTP_UNAME);
            $this->email->to($email_wp);
            $this->email->subject('Tolak Permohonan Online');
            $this->email->message($message);
            if ($this->email->send()) {
                $this->session->set_flashdata('msg_success', 'Data Berhasil di Tolak');
            } else {
                $this->session->set_flashdata('msg_warning', 'Gagal Kirim Email');
                // echo $this->email->print_debugger();
            }

            redirect(active_module_url($this->controller));
        } else {
            $this->session->set_flashdata('msg_warning', 'Data Tidak Valid');
            redirect(active_module_url($this->controller));
        }

    }

    public function openblob()
    {
        $field   = $this->uri->segment(4);
        $p_id = $this->uri->segment(5);
        $field = strtoupper($field);

        $dbhost = DB_HOST;
        $dbport = DB_PORT;
        $dbname = DB_NAME;
        $dbuser = DB_USER;
        $dbpass = DB_PASS;

        $tnslistener = '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST='.DB_HOST.')(PORT='.DB_PORT.'))(CONNECT_DATA=(SERVICE_NAME='.DB_NAME.')))';

        $connection = oci_connect($dbuser, $dbpass, $tnslistener);

        $sql = "SELECT {$field} FROM REG_ESPPT RD WHERE RD.KD_PROPINSI||RD.KD_DATI2||RD.KD_KECAMATAN||RD.KD_KELURAHAN||RD.KD_BLOK||RD.NO_URUT||RD.KD_JNS_OP||TRIM(RD.NIK)='$p_id' ";

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
    function openblob_pan(){

        $field       = $this->uri->segment(4);
        $nik       = $this->uri->segment(5);
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

        $sql = "SELECT IM_PBB_BLOB FROM nop_prog_TEMP WHERE ROWIDTOCHAR(ROWID)='AAAk7IAAEAAAsDWAAG' ";

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
}
