<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class permohonan_online extends CI_Controller
{
    public function __construct()
    {
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

    public function index()
    {
        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect('eadm_bogor');
        }

        $data['page_menu'] = 'permohonan_online';
        $data['current'] = '';
        $data['apps']    = $this->apps_model->get_active_only();

        $option = array( ''=> 'Semua Status',
            '1' => 'Approve WP (1)',
            '2' => 'Belum Lengkap (2)',
            '3'=> 'Tolak Pemda (3)',
            '4' => 'Approve Pemda (4)');
        $js  = 'id="status_kd" style="width:130px;" class="input form-control select2" ';
        $select = form_dropdown('status_kd', $option, '' , $js);
        $data['select_status'] = $select;
        $option1 = array('' => 'Semua Jenis Pelayanan');
        $select_ply_list = $this->permohonan_online_model->droplist_jns_pelayanan();
        foreach ($select_ply_list as $key => $aa) {
            $option1[$aa->KD_JNS_PELAYANAN] = $aa->NM_JENIS_PELAYANAN;
        }
        $js  = 'id="kd_jns_pelayanan" style="width:180px;" class="input form-control select2" onchange="reload_grid();" ';
        $select = form_dropdown('kd_jns_pelayanan', $option1, '' , $js);
        $data['select_jns_pelayanan'] = $select;

        $this->load->view('vpermohonan_online', $data);
    }

    public function grid()
    {

        //$prop = sipkd_kd_propinsi();
        //log_message('info', "BBBBBBBBBB CREATE MODULE : " .$prop );
        $status_kd = $this->input->get('status_kd');
        $jns_ply = $this->input->get('jns_ply');
        $tgl_start = date('Ymd',strtotime($this->input->get('tgl_start')));
        $tgl_end = date('Ymd',strtotime($this->input->get('tgl_end')));
        $this->load->library('Datatables');

        if (is_super_admin()) {
            $this->datatables->select("THN_PELAYANAN||'-'||BUNDEL_PELAYANAN||'-'||NO_URUT_PELAYANAN AS NOPEL, NAMA_PEMOHON,
                            KD_PROPINSI_PEMOHON||'.'||KD_DATI2_PEMOHON||'-'||KD_KECAMATAN_PEMOHON||'.'||KD_KELURAHAN_PEMOHON||'-'||KD_BLOK_PEMOHON||'.'||NO_URUT_PEMOHON||'.'||KD_JNS_OP_PEMOHON AS NOP_PEMOHON,
                            NM_JENIS_PELAYANAN, CASE WHEN STATUS_PERMOHONAN=0 then 'Draft (0)'
                                                        WHEN STATUS_PERMOHONAN=1 then 'Approve WP (1)'
                                                        WHEN STATUS_PERMOHONAN=2 then 'Belum Lengkap (2)'
                                                        WHEN STATUS_PERMOHONAN=3 then 'Tolak Pemda (3)'
                                                        WHEN STATUS_PERMOHONAN=4 then 'Approve Pemda (4)' END AS sts,
                            STATUS_PERMOHONAN, THN_PELAYANAN, BUNDEL_PELAYANAN, NO_URUT_PELAYANAN, NVL(TO_CHAR(PO.TGL_SURAT_PERMOHONAN,'DD-MM-YYYY'),'')", false);
            $this->datatables->from("PST_PERMOHONAN_ONLINE PO");
            $this->datatables->join('REF_JNS_PELAYANAN JP', 'JP.KD_JNS_PELAYANAN = PO.KD_JNS_PELAYANAN', 'left');
            $this->datatables->where("STATUS_PERMOHONAN != 0");
        } else {
            $userid =  $this->session->userdata('username');
            $this->datatables->select("THN_PELAYANAN||'-'||BUNDEL_PELAYANAN||'-'||NO_URUT_PELAYANAN AS NOPEL, NAMA_PEMOHON,
                            KD_PROPINSI_PEMOHON||'.'||KD_DATI2_PEMOHON||'-'||KD_KECAMATAN_PEMOHON||'.'||KD_KELURAHAN_PEMOHON||'-'||KD_BLOK_PEMOHON||'.'||NO_URUT_PEMOHON||'.'||KD_JNS_OP_PEMOHON AS NOP_PEMOHON,
                            NM_JENIS_PELAYANAN, CASE WHEN STATUS_PERMOHONAN=0 then 'Draft (0)'
                                                        WHEN STATUS_PERMOHONAN=1 then 'Approve WP (1)'
                                                        WHEN STATUS_PERMOHONAN=2 then 'Belum Lengkap (2)'
                                                        WHEN STATUS_PERMOHONAN=3 then 'Tolak Pemda (3)'
                                                        WHEN STATUS_PERMOHONAN=4 then 'Approve Pemda (4)' END AS sts,
                            STATUS_PERMOHONAN, THN_PELAYANAN, BUNDEL_PELAYANAN, NO_URUT_PELAYANAN, NVL(TO_CHAR(PO.TGL_SURAT_PERMOHONAN,'DD-MM-YYYY'),'')", false);
            $this->datatables->from("PST_PERMOHONAN_ONLINE PO");
            $this->datatables->join('REF_JNS_PELAYANAN JP', 'JP.KD_JNS_PELAYANAN = PO.KD_JNS_PELAYANAN', 'left');
            $this->datatables->join('PEL_PEGAWAI_ONLINE PG', 'PG.KD_PELAYANAN = PO.KD_JNS_PELAYANAN', '');
            $this->datatables->join('SEC_USERS SU', 'SU.NIP = PG.NIP_PDNL', "left");
            $this->datatables->where("SU.USERID ", $userid);
            $this->datatables->where("STATUS_PERMOHONAN != 0");
            
        }
        
        if(!empty($status_kd)){
            
            $this->datatables->where('STATUS_PERMOHONAN',$status_kd);
        }
        if(!empty($jns_ply)){
         $this->datatables->where('JP.KD_JNS_PELAYANAN',$jns_ply);   
        }
        if(!empty($this->input->get('tgl_start'))){
            $this->datatables->where("CAST((NVL(TO_CHAR(PO.TGL_SURAT_PERMOHONAN,'YYYYMMDD'),'0')) AS NUMBER) >= {$tgl_start}"); 
        }
        if(!empty($this->input->get('tgl_end'))){
            $this->datatables->where("CAST((NVL(TO_CHAR(PO.TGL_SURAT_PERMOHONAN,'YYYYMMDD'),'0')) AS NUMBER) <= {$tgl_end}"); 
        }
        echo $this->datatables->generate();
    }

    private function fvalidation($jenis_permohonan_online = null)
    {
        if ($jenis_permohonan_online == 'approve') {
            $this->form_validation->set_error_delimiters('<span>', '</span>');
        }

        if ($jenis_permohonan_online == 'tolak') {
            $this->form_validation->set_error_delimiters('<span>', '</span>');
        }
    }

    private function fpost()
    {
        $data['rowid'] = post_string($this->input->post('rowid'));
        $data['nopel'] = post_string($this->input->post('nopel'));
        $data['jns_pelayanan'] = post_string($this->input->post('jns_pelayanan'));
        $data['no_permohonan'] = post_string($this->input->post('no_permohonan'));
        $data['tgl_permohonan'] = post_string($this->input->post('tgl_permohonan'));
        $data['nop'] = post_string($this->input->post('nop'));
        $data['thn_ketetapan'] = post_string($this->input->post('thn_ketetapan'));
        $data['nama_pemohon'] = post_string($this->input->post('nama_pemohon'));
        $data['alamat_pemohon'] = post_string($this->input->post('alamat_pemohon'));
        $data['telp'] = post_string($this->input->post('telp'));
        $data['keterangan'] = post_string($this->input->post('keterangan'));
        $data['keterangan_a'] = post_string($this->input->post('keterangan_a'));
        return $data;
    }

    public function action()
    {
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
            redirect(active_module_url('permohonan_online'));
        }

        $p_id  = $this->uri->segment(4);
        // $p_id  = $this->input->get('row_id', true);
        // $p_id  = $_GET['row_id'];
        // echo $p_id;
        // die();

        $rowid = $p_id;

        $data['page_menu'] = 'permohonan_online';
        $data['current'] = '';
        $data['apps']    = $this->apps_model->get_active_only();
        // $data['faction'] = active_module_url("permohonan_online/update/{$p_id}");
        $data['faction'] = "";

        if ($p_id && $get = $this->permohonan_online_model->get_by_nopel($p_id)) {
            $data['dt']['rowid'] = $get->ID;
            $data['dt']['nopel'] = get_string($get->NOPEL);
            $data['dt']['jns_pelayanan']    = get_string($get->NM_JENIS_PELAYANAN);
            $data['dt']['no_permohonan'] = get_string($get->NO_SRT_PERMOHONAN);
            $data['dt']['tgl_permohonan'] = get_string($get->TGL_SURAT_PERMOHONAN);
            $data['dt']['nop'] = get_string($get->NOP_PEMOHON);
            $data['dt']['thn_ketetapan'] = get_string($get->THN_PAJAK_PERMOHONAN);
            $data['dt']['nama_pemohon'] = get_string($get->NAMA_PEMOHON);
            $data['dt']['alamat_pemohon'] = get_string($get->ALAMAT_PEMOHON);
            $data['dt']['telp'] = get_string($get->NO_HP);
            $data['dt']['keterangan'] = get_string($get->KETERANGAN_PST);
            $data['dt']['keterangan_a'] = '';
			$data['da'] = (array)$get;

            $this->load->view('vpermohonan_online_form', $data);
        } else {
            show_404();
        }
    }

    public function detail()
    {
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
            redirect(active_module_url('permohonan_online'));
        }

        $p_id  = $this->uri->segment(4);
        // $p_id  = $this->input->get('row_id', true);
        // $p_id  = $_GET['row_id'];
        // echo $p_id;
        // die();

        $rowid = $p_id;

        $data['page_menu'] = 'permohonan_online';
        $data['current'] = '';
        $data['apps']    = $this->apps_model->get_active_only();
        // $data['faction'] = active_module_url("permohonan_online/update/{$p_id}");
        $data['faction'] = "";

        if ($p_id && $get = $this->permohonan_online_model->get_by_nopel($p_id)) {
            $data['dt']['rowid'] = $get->ID;
            $data['dt']['nopel'] = get_string($get->NOPEL);
            $data['dt']['jns_pelayanan']    = get_string($get->NM_JENIS_PELAYANAN);
            $data['dt']['no_permohonan'] = get_string($get->NO_SRT_PERMOHONAN);
            $data['dt']['tgl_permohonan'] = get_string($get->TGL_SURAT_PERMOHONAN);
            $data['dt']['nop'] = get_string($get->NOP_PEMOHON);
            $data['dt']['thn_ketetapan'] = get_string($get->THN_PAJAK_PERMOHONAN);
            $data['dt']['nama_pemohon'] = get_string($get->NAMA_PEMOHON);
            $data['dt']['alamat_pemohon'] = get_string($get->ALAMAT_PEMOHON);
            $data['dt']['telp'] = get_string($get->NO_HP);
            $data['dt']['keterangan'] = get_string($get->KETERANGAN_PST);
            $data['da'] = (array)$get;
            $this->load->view('vpermohonan_online_form_view', $data);
        } else {
            show_404();
        }
    }

    public function approve()
    {
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
            redirect(active_module_url('permohonan_online'));
        }
        // $this->session->set_flashdata('msg_warning', 'Maintenance dulu ya');
        // redirect(active_module_url('permohonan_online'));
        $p_id       = $this->uri->segment(4);
        $post_data = $this->fpost();
        
        // $rowid  = $this->input->post('rowid');
        $nopel    = $this->input->post('nopel');
        $keterangan = $this->input->post('keterangan_a');
        if ($nopel && $get = $this->permohonan_online_model->get_by_nopel($nopel)) {
            if ($get->STATUS_PERMOHONAN == 1) {
                $data['page_menu'] = 'permohonan_online';
                $data['current'] = '';
                $data['apps']    = $this->apps_model->get_active_only();
                $data['faction'] = '';
                // $data['faction'] = active_module_url("permohonan_online/update/{$p_id}");
                $nop_pemohon = $get->NOP_PEMOHON;
                $this->fvalidation('approve');

                // if ($this->form_validation->run() == true) {
                $input_post  = $post_data;

                $update_data = array(
                        'STATUS_PERMOHONAN' => '4',
                      
                    );

                $result = $this->permohonan_online_model->update_data_permohonan_online($nopel, $update_data);
                if (!empty($result)) {
                    set_msg_db_error($result);
                } else {
                $ga = $this->permohonan_online_model->ambil_by_nopel($nopel, $nop_pemohon);
                $email_wp = $this->permohonan_online_model->ambil_reg_sppt_temp($nop_pemohon);
                $nop_a = $ga->NOP_PEMOHON;
                $nopel_a = $ga->NOPEL;
                $nm_jns_pelayanan = $ga->NM_JENIS_PELAYANAN;
                $tgl_srt_permohonan = $ga->TGL_SURAT_PERMOHONAN;
                $tgl_perkiraan_selesai = $ga->TGL_PERKIRAAN_SELESAI;
                $alasan = $ga->ALASAN;
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
                $link_login_regsppt = DOMAIN_BOGOR.'/reg_sppt_bgr/login';
                $link_mobile_app = "https://play.google.com/store/apps/details?id=com.simdadu.pbbkabbogor";
                    $message = "Selamat, permohonan PBB online dengan <br>";
                    $message .= "NO PELAYANAN : {$nopel_a} <br>";
                    $message .= "NOP : {$nop_a} <br>";
                    $message .= "JENIS PELAYANAN : {$nm_jns_pelayanan}<br>";
                    $message .= "TGL KIRIM BERKAS : {$tgl_srt_permohonan} <br>";
                    $message .= "TGL PERKIRAAN SELESAI : {$tgl_perkiraan_selesai} <br>";
                    $message .= "CATATAN : {$alasan} <br>";
                    $message .= "Telah berhasil diverifikasi. <br> Silakan unduh tanda terima pelayanan terlampir.Untuk melakukan pengecekan tracking berkas dapat dilihat pada web PBB Online dan aplikasi PBB Mobile Kab. Bogor (mobile apps android) <br>";
                    $message .= "<a href='{$link_login_regsppt}'>Aplikasi Reg Esppt</a> <br>";
                    $message .= "<a href='{$link_mobile_app}'>Aplikasi PBB Mobile</a>";
            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from(EMAIL_EADM, SMTP_UNAME);
            $this->email->to($email_wp);
            $this->email->subject('Approve Permohonan Online');
            $this->email->message($message);
            if ($this->email->send()) {
                $this->session->set_flashdata('msg_success', 'Data telah di approve');
            } else {
                $this->session->set_flashdata('msg_warning', 'Gagal Kirim Email');
                // echo $this->email->print_debugger();
            }

                    redirect(active_module_url('permohonan_online'));

                }
                // }

                $get = (object)$post_data;
                $data['dt'] = $post_data;
            } else {
                $this->session->set_flashdata('msg_success', 'ERROR... Status Dokumen Bukan Approve WP..');
                redirect(active_module_url('permohonan_online'));
            }
        } else {
            show_404();
        }

        // $this->load->view('vpermohonan_online_form', $data);
    }

    public function tolak()
    {
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
            redirect(active_module_url('permohonan_online'));
        }
        // $this->session->set_flashdata('msg_warning', 'Maintenance dulu ya');
        // redirect(active_module_url('permohonan_online'));

        $p_id       = $this->uri->segment(4);
        $post_data = $this->fpost();

        // $rowid  = $this->input->post('rowid');
        $nopel    = $this->input->post('nopel');
        $keterangan = $this->input->post('keterangan_a');
        if ($nopel && $get = $this->permohonan_online_model->get_by_nopel($nopel)) {
            if ($get->STATUS_PERMOHONAN == 1) {
                $nop_pemohon = $get->NOP_PEMOHON;
                $data['page_menu'] = 'permohonan_online';
                $data['current'] = '';
                $data['apps']    = $this->apps_model->get_active_only();
                $data['faction'] = '';
                // $data['faction'] = active_module_url("permohonan_online/update/{$p_id}");

                $this->fvalidation('tolak');

                // if ($this->form_validation->run() == true) {
                $input_post  = $post_data;

                $update_data = array(
                        'STATUS_PERMOHONAN' => '3',
                        'ALASAN' => $keterangan,
                    );

                $result = $this->permohonan_online_model->update_data_permohonan_online($nopel, $update_data);
                if (!empty($result)) {
                    set_msg_db_error($result);
                } else {
                     $email_wp = $this->permohonan_online_model->ambil_reg_sppt_temp($nop_pemohon);

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
                    $link_login_regsppt = DOMAIN_BOGOR.'/reg_sppt_bgr/login';
                    $message = "Mohon maaf permohonan PBB online anda tidak dapat diproses lebih lanjut dikarenakan {$keterangan} Silakan ajukan permohonan ulang dengan username dan password yang sama dengan melampirkan data yang lengkap. Terima kasih.";
                    // $message .= "<a href='{$link_login_regsppt}'>Aplikasi Reg Esppt</a>";
            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from(EMAIL_EADM, SMTP_UNAME);
            $this->email->to($email_wp);
            $this->email->subject('Tolak Permohonan Online');
            $this->email->message($message);
            if ($this->email->send()) {
                $this->session->set_flashdata('msg_success', 'Data telah di approve');
            } else {
                $this->session->set_flashdata('msg_warning', 'Gagal Kirim Email');
                // echo $this->email->print_debugger();
            }

                    // $this->session->set_flashdata('msg_success', 'Data telah disimpan');
                    redirect(active_module_url('permohonan_online'));
                }
                // }

                $get = (object)$post_data;
                $data['dt'] = $post_data;
            } else {
                $this->session->set_flashdata('msg_success', 'ERROR... Status Dokumen Bukan Approve WP..');
                redirect(active_module_url('permohonan_online'));
            }
        } else {
            show_404();
        }

        // $this->load->view('vpermohonan_online_form', $data);
    }

    public function openblob()
    {
        $field       = $this->uri->segment(4);
        $nopel       = $this->uri->segment(5);
        $field = strtoupper($field);

        $dbhost = DB_HOST;
        $dbport = DB_PORT;
        $dbname = DB_NAME;
        $dbuser = DB_USER;
        $dbpass = DB_PASS;

        $tnslistener = '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST='.DB_HOST.')(PORT='.DB_PORT.'))(CONNECT_DATA=(SERVICE_NAME='.DB_NAME.')))';

        // var_dump($tnslistener);die;

        $connection = oci_connect($dbuser, $dbpass, $tnslistener);

        $sql = "SELECT {$field} FROM PST_PERMOHONAN_ONLINE
                WHERE THN_PELAYANAN||'-'||BUNDEL_PELAYANAN||'-'||NO_URUT_PELAYANAN = '{$nopel}'";

        // var_dump($sql);die;

        $stid = oci_parse($connection, $sql);

        oci_execute($stid);
        $row = oci_fetch_array($stid, OCI_RETURN_NULLS);
        // var_dump($row);die;

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
