<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class loket_permohonan_online_upt extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!is_login()) {
            echo "<script>window.location.replace('" . base_url() . "');</script>";
            exit;
        }

        $module = 'loket_permohonan_online_upt';
        $this->load->library('module_auth', array(
            'module' => $module
        ));

        $this->load->model(array(
            'apps_model', 'permohonan_online_upt_model', 'pembetulan_model'
        ));

        $this->load->helper(active_module());
    }

    function tes_email2() {
        $nama_pemohon = 'sendi.yadi@gmail.com';
        $nopel = '0000-0000-0000';

        $message = '
                <html>
                <head>
                    <title>Pemberitahuan Permohonan PBB Online</title>
                </head>
                <body style="font-family: Arial, sans-serif; background-color: #f6f9fc; margin: 0; padding: 20px;">
                    <table align="center" cellpadding="0" cellspacing="0" width="600" 
                           style="background-color: #ffffff; border-radius: 8px; 
                                  box-shadow: 0 2px 6px rgba(0,0,0,0.1);">

                        <!-- Header Hijau -->
                        <tr>
                            <td style="background-color: #d9534f; padding: 16px; 
                                       border-radius: 8px 8px 0 0; 
                                       text-align: center; color: #ffffff;">
                                <h2 style="margin: 0;">PERMOHONAN PBB ONLINE TIDAK DAPAT DIPROSES</h2>
                            </td>
                        </tr>

                        <!-- Isi Pesan -->
                        <tr>
                            <td style="padding: 30px; font-size: 15px; color: #444;">
                                <p>Hai <strong>'.$nama_pemohon.'</strong>,</p>

                                <p style="line-height: 1.6;">
                                    Mohon maaf, permohonan PBB Online Anda dengan 
                                    <strong>Nomor Pelayanan: '.$nopel.'</strong> 
                                    tidak dapat diproses lebih lanjut karena:
                                </p>

                                <blockquote style="background: #f9e2e2; padding: 12px 18px; 
                                                   border-left: 4px solid #d9534f; 
                                                   color: #b52b27; border-radius: 4px;">
                                    keterangan alasan
                                </blockquote>

                                <p style="line-height: 1.6;">
                                    Silakan ajukan permohonan ulang menggunakan akun yang sama 
                                    dan pastikan seluruh data serta berkas yang dilampirkan telah lengkap.
                                </p>

                                <p>Terima kasih.</p>
                            </td>
                        </tr>

                        <!-- Footer -->
                        <tr>
                            <td style="background-color: #f0f0f0; text-align: center; 
                                       padding: 15px; font-size: 13px; color: #999; 
                                       border-radius: 0 0 8px 8px;">
                                &copy; '.date('Y').' Bappenda Kabupaten Bogor
                            </td>
                        </tr>

                    </table>
                </body>
                </html>';

        echo $message;

    }

    function tes_email() {
        // stream_socket_enable_crypto(
        //     $this->_smtp_connect,
        //     true,
        //     STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT
        // );
        // exit;die;
        $nm_jns_pelayanan = 'Tes Jenis Pelayanan';
        $tgl_srt_permohonan = '01-01-2025';
        $tgl_perkiraan_selesai = '01-02-2025';
        $email_wp = 'sendi.yadi@gmail.com';
        $nopel = '0000-0000-0000';
        $nop_pemohon = '32.03.191.012.036.0270.0';
        $d_today = date('d-m-Y');

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

        $message = '
            <html>
            <head>
                <title>Permohonan PBB Online Anda Telah Diverifikasi</title>
            </head>
            <body style="font-family: Arial, sans-serif; background-color: #f6f9fc; margin:0; padding:20px;">
                <table align="center" cellpadding="0" cellspacing="0" width="600" 
                       style="background-color:#ffffff; border-radius:8px; 
                              box-shadow:0 2px 6px rgba(0,0,0,0.1);">
                    <tr>
                        <td style="background-color:#2b8a3e; padding:16px; 
                                   border-radius:8px 8px 0 0; 
                                   text-align:center; color:#ffffff;">
                            <h2 style="margin:0;">Permohonan PBB Online Anda Telah Diverifikasi</h2>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:30px; color:#555; font-size:15px;">
                            <p style="font-size:16px;">Selamat, permohonan PBB Online Anda telah berhasil diverifikasi. Berikut detail permohonan:</p>

                            <table cellpadding="5" cellspacing="0" width="100%" style="font-size:15px; color:#555;">
                                <tr>
                                    <td width="180"><strong>No Pelayanan</strong></td>
                                    <td>: '.$nopel.'</td>
                                </tr>
                                <tr>
                                    <td><strong>NOP</strong></td>
                                    <td>: '.$nop_pemohon.'</td>
                                </tr>
                                <tr>
                                    <td><strong>Jenis Pelayanan</strong></td>
                                    <td>: '.$nm_jns_pelayanan.'</td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal Kirim Berkas</strong></td>
                                    <td>: '.$tgl_srt_permohonan.'</td>
                                </tr>
                                <tr>
                                    <td><strong>Perkiraan Selesai</strong></td>
                                    <td>: '.$tgl_perkiraan_selesai.'</td>
                                </tr>
                                <tr>
                                    <td><strong>Catatan</strong></td>
                                    <td>: tes email</td>
                                </tr>
                            </table>

                            <br>

                            <p>Silakan unduh Tanda Terima Pelayanan yang terlampir pada email ini.</p>

                            <p>
                                Silakan cek status berkas Anda melalui menu <strong>Permohonan Online</strong> pada website 
                                <strong>PBB Online Kabupaten Bogor</strong>.
                            </p>

                            <p style="margin-top:50px; text-align:center;">Cibinong, '.$d_today.'</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color:#f0f0f0; text-align:center; padding:15px;
                                   font-size:13px; color:#999; border-radius:0 0 8px 8px;">
                            Email ini dikirim otomatis oleh sistem. Mohon tidak membalas email ini.<br>
                            &copy; '.date('Y').' Bappenda Kabupaten Bogor
                        </td>
                    </tr>

                </table>
            </body>
            </html>';

            // echo $message;


        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from(SMTP_USER, SMTP_UNAME);
        $this->email->to($email_wp);
        $this->email->subject('Approve Permohonan Online ('.$nopel.')');
        $this->email->message($message);
        if ($this->email->send()) {
            echo 'berhasil';
        } else {
            echo $this->email->print_debugger(); die();
        }
    }

    public function index() {
        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect('tool_pbb');
        }

        $data['page_menu'] = 'loket_permohonan_online_upt';
        $data['current'] = '';
        $data['apps']    = $this->apps_model->get_active_only();
        $option = array( 'A'=> 'Semua Status',
                        '1' => 'Kirim WP',
                        '4' => 'Terima Pemda',
                        '3' => 'Tolak Pemda',
                        'E' => 'Tolak Peneliti',
                        'F' => 'Pembetulan Ulang');
        $js  = 'id="status_kd" class="form-control" ';
        $select = form_dropdown('status_kd', $option, '' , $js);
        $data['select_status_kd'] = $select;
        //------------------------------------------------------------------
        $select_data  = $this->permohonan_online_upt_model->get_jns_ply();
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


        $this->load->view('vloket_permohonan_online_upt', $data);
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
                                    P.KD_PROPINSI_PEMOHON||P.KD_DATI2_PEMOHON||P.KD_KECAMATAN_PEMOHON||P.KD_KELURAHAN_PEMOHON||P.KD_BLOK_PEMOHON||P.NO_URUT_PEMOHON||P.KD_JNS_OP_PEMOHON AS NOP,
                                    CASE WHEN P.KD_JNS_PELAYANAN = '03' THEN
                                    RP.NM_JENIS_PELAYANAN||'<br> SUB '||RSP.NM_SUB_JENIS_PELAYANAN
                                    ELSE RP.NM_JENIS_PELAYANAN END AS NM_JENIS_PELAYANAN, 
                                    P.NAMA_PEMOHON, KEC.NM_KECAMATAN, KEL.NM_KELURAHAN,
                                    CASE WHEN P.STATUS_PERMOHONAN = '0' THEN 'Draft' 
                                    WHEN P.STATUS_PERMOHONAN = '1' THEN 'Kirim WP'
                                    WHEN P.STATUS_PERMOHONAN = '2' THEN 'Proses'
                                    WHEN P.STATUS_PERMOHONAN = '3' THEN 'Tolak Pemda'
                                    WHEN P.STATUS_PERMOHONAN = '4' THEN 'Diterima Pemda'
                                    WHEN P.STATUS_PERMOHONAN = 'E' THEN 'Tolak Peneliti'
                                    WHEN P.STATUS_PERMOHONAN = 'F' THEN 'Pembetulan Ulang' END AS STS,
									TO_CHAR(P.TGL_PERKIRAAN_SELESAI, 'DD-MM-YYYY') AS TGL_PERKIRAAN_SELESAI,
                                    P.THN_PELAYANAN||P.KD_PROPINSI_PEMOHON||P.KD_DATI2_PEMOHON||P.KD_KECAMATAN_PEMOHON||P.KD_KELURAHAN_PEMOHON||P.KD_BLOK_PEMOHON||P.NO_URUT_PEMOHON||P.KD_JNS_OP_PEMOHON||P.KD_JNS_PELAYANAN as NOPELNOP,
                                    P.STATUS_PERMOHONAN", false);
        $this->datatables->from("PST_PERMOHONAN_TOOL P");
        $this->datatables->join('REF_JNS_PELAYANAN RP', 'RP.KD_JNS_PELAYANAN = P.KD_JNS_PELAYANAN', 'left');
        $this->datatables->join('REF_SUB_JNS_PELAYANAN RSP', 'RSP.KD_JNS_PELAYANAN = P.KD_JNS_PELAYANAN AND RSP.KD_SUB_JNS_PELAYANAN = P.KD_SUB_JNS_PELAYANAN', 'left');
        $this->datatables->join('REF_KECAMATAN KEC', 'KEC.KD_KECAMATAN = P.KD_KECAMATAN_PEMOHON');
        $this->datatables->join('REF_KELURAHAN KEL', 'KEL.KD_KECAMATAN = P.KD_KECAMATAN_PEMOHON AND KEL.KD_KELURAHAN = P.KD_KELURAHAN_PEMOHON');

        if($jns_ply <> '999999' && !empty($jns_ply)){
            $this->datatables->where('P.KD_JNS_PELAYANAN', $jns_ply);
        }else{
            $this->datatables->where("P.KD_JNS_PELAYANAN IN ('02', '03', '15', '08','19','22')");
        }

        $this->datatables->where('P.ID_REGUSER IS NOT NULL');

        $nip_login = sipkd_user_nip();
        if(!is_super_admin()) {
            $this->datatables->where("P.NIP_APR_LOKET", $nip_login);
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

        if($sts_kd <> 'A' && !empty($sts_kd)){
            $this->datatables->where("P.STATUS_PERMOHONAN = '".$sts_kd."'");
        } else{
            $this->datatables->where("P.STATUS_PERMOHONAN IN ('1', '3', '4', 'F')");
        }
        
        echo $this->datatables->generate();
    }

    function grid_dtl_bng_ol() {
        $id_head        = $this->uri->segment(4);

        $this->load->library('Datatables');
        $this->datatables->select("DOB.ID, 'edit' as MODEL, DOB.NO_BNG, RJ.NM_JPB, DOB.LUAS_BNG, DOB.KD_JPB, 
            '' as edit, '' as hapus, '' as fas", false);
        $this->datatables->from('PST_PERMOHONAN_TOOL SP');
        $this->datatables->join('DAT_OP_BANGUNAN_ONLINE DOB', 'SP.ID = DOB.DOCH_ID');
        $this->datatables->join('REF_JPB RJ', 'RJ.KD_JPB = DOB.KD_JPB');
        $this->datatables->where('SP.ID', $id_head);

        // $this->datatables->rupiah_column('4');

        echo $this->datatables->generate();
    }

    function grid_dtl_fas_ol() {
        $id_head = $this->uri->segment(4);

        // $btn_edt = '<a class="btn_edit_detail" data-toggle="modal" data-target="#cuDialogDetail" href="">Ubah</a>';
        $this->load->library('Datatables');
        $this->datatables->select("FAS.ID, 'edit' as MODEL, RF.NM_FASILITAS, FAS.JML_SATUAN, FAS.KD_FASILITAS", false);
        $this->datatables->from('DAT_FASILITAS_BANGUNAN_ONLINE FAS');
        $this->datatables->join('FASILITAS RF', 'RF.KD_FASILITAS = FAS.KD_FASILITAS');
        $this->datatables->where('FAS.DOCD_ID', $id_head);

        // $this->datatables->rupiah_column('4');

        echo $this->datatables->generate();
    }

    private function fvalidation() {
        $this->form_validation->set_error_delimiters('<span>', '</span>');
        $this->form_validation->set_rules('nop', 'NOP', 'required|trim|callback_cek_nop');
        $this->form_validation->set_rules('thn_permohonan', 'Tahun Permohonan', 'required|trim');
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
        $data['ket_pst'] = $this->input->post('ket_pst');
        
        return $data;
    }

    public function detail() {
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_danger', $this->module_auth->msg_read);
            redirect('tool_pbb');
        }

        $param     = $this->uri->segment(4);

        $data['page_menu'] = 'loket_permohonan_online_upt';
        $data['current'] = '';
        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = '';
        
        $x = $this->permohonan_online_upt_model->get_ppo_by_id($param);

        if ($x){
            if ($x->KD_JNS_PELAYANAN == '02' || $x->KD_JNS_PELAYANAN == '03') {
                $dt = $this->permohonan_online_upt_model->get_by_id($param);
        
                $data['dt'] = array(
                    'nop_re' => $dt->NOP_LKP, 
                    'id_reg_esppt' => $dt->NOPNIK, 
                    'nama_wp_re' => $dt->NAMA_WP_REG, 
                    'alamat_op_re' => $dt->ALAMAT_REG, 
                    'nik_re' => $dt->NIK_REG, 
                    'no_telp_re' => $dt->TELP_REG,
                    'nama_re' => $dt->NAMA_REG, 
                    'email_re' => $dt->EMAIL_REG,
                    'ket_pst' => $dt->ALASAN,

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
                    'kd_jns_ply' => $dt->KD_JNS_PELAYANAN,
                    'kd_sub_jns_ply' => $dt->KD_SUB_JNS_PELAYANAN,

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
                    'latitude' => $x->LATITUDE,
                    'longitude' => $x->LONGITUDE,

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

                $this->load->view('vloket_permohonan_online_upt_form', $data);  

            } else if ($x->KD_JNS_PELAYANAN == '15') {
                $dt = $this->permohonan_online_upt_model->get_dt_angsuran($param);
                $pst_angs = $this->permohonan_online_upt_model->get_pst_angsuran($param);
        
                $data['dt'] = array(
                    'nop_re' => $x->NOP_LKP, 
                    'id_reg_esppt' => $x->NOPNIK, 
                    'nama_wp_re' => $x->NAMA_WP_REG, 
                    'alamat_op_re' => $x->ALAMAT_REG, 
                    'nik_re' => $x->NIK_REG, 
                    'no_telp_re' => $x->TELP_REG,
                    'nama_re' => $x->NAMA_REG, 
                    'email_re' => $x->EMAIL_REG,
                    'ket_pst' => $x->ALASAN,

                    'rowid' => $x->PPO_ID, 
                    'id_ppo' => $x->PPO_ID, 
                    'nopel' => $x->NOPEL, 
                    'no_permohonan' => $x->NO_SRT_PERMOHONAN, 
                    'thn_permohonan' => $x->THN_PAJAK_PERMOHONAN, 
                    'nop' => $x->NOP_LKP, 
                    'tgl_permohonan' => get_date($x->TGL_SURAT_PERMOHONAN), 
                    'nama_pemohon' => $x->NAMA_PEMOHON, 
                    'alamat_pemohon' => $x->ALAMAT_PEMOHON, 
                    'telp' => $x->NO_HP, 
                    'keterangan' => $x->KETERANGAN_PST, 
                    'kd_jns_ply' => $x->KD_JNS_PELAYANAN,

                    'nama_wp_sppt' => $dt->NM_WP_SPPT, 
                    'alamat_op_sppt' => $dt->ALAMAT_OP_SPPT, 
                    'pbb_yg_harus_dibayar' => $dt->PBB_YG_HARUS_DIBAYAR_SPPT, 

                    'jatuh_tempo_1' => app_date($pst_angs->TGL_C_I),
                    'nominal_1' => $pst_angs->CICILAN_I,
                    'jatuh_tempo_2' => app_date($pst_angs->TGL_C_II),
                    'nominal_2' => $pst_angs->CICILAN_II,
                    'jatuh_tempo_3' => app_date($pst_angs->TGL_C_III),
                    'nominal_3' => $pst_angs->CICILAN_III,
                    'jatuh_tempo_4' => app_date($pst_angs->TGL_C_IV),
                    'nominal_4' => $pst_angs->CICILAN_IV,

                );

                $data['da'] = (array)$dt;

                $data['fnopnik'] = $x->NOPNIK;

                //---------------------------------------------------------------------------------------------------------
                $select_data  = $this->permohonan_online_upt_model->get_jns_ply($x->KD_JNS_PELAYANAN);
                if ($select_data) {
                    foreach ($select_data as $row) {
                        $options[$row->KD_JNS_PELAYANAN] = $row->NM_JENIS_PELAYANAN;
                    }
                } else {
                    $options['0'] = 'Data not found';
                }
                // $js     = 'id="jns_ply" required style="width:90%; height:100% !important;" onchange="jns_ply_chg(this.value)" ';
                $js     = 'class="form-control" id="jns_ply" readonly ';
                $select = form_dropdown('jns_ply', $options, $x->KD_JNS_PELAYANAN, $js);
                $select = preg_replace("/[\r\n]+/", "", $select);
                $data['select_jns_ply'] = $select;
                //---------------------------------------------------------------------------------------------------------

                $this->load->view('vloket_permohonan_online_upt_angs_form', $data);  
            } else if ($x->KD_JNS_PELAYANAN == '08') {
                $dt = $this->permohonan_online_upt_model->get_dt_pengurangan($param);
        
                $data['dt'] = array(
                    'nop_re' => $x->NOP_LKP, 
                    'id_reg_esppt' => $x->NOPNIK, 
                    'rowid' => $x->PPO_ID, 
                    'id_ppo' => $x->PPO_ID, 
                    'nopel' => $x->NOPEL, 
                    'nop' => $x->NOP_LKP, 
                    'ket_pst' => $x->ALASAN,

                    'nama_wp_re' => $x->NAMA_WP_REG, 
                    'alamat_op_re' => $x->ALAMAT_REG, 
                    'nik_re' => $x->NIK_REG, 
                    'no_telp_re' => $x->TELP_REG,
                    'nama_re' => $x->NAMA_REG, 
                    'email_re' => $x->EMAIL_REG,
                    'kd_jns_ply' => $x->KD_JNS_PELAYANAN,
                    'kd_sub_jns_ply' => $x->KD_SUB_JNS_PELAYANAN,

                    'no_permohonan' => $x->NO_SRT_PERMOHONAN, 
                    'thn_permohonan' => $x->THN_PAJAK_PERMOHONAN, 
                    'tgl_permohonan' => get_date($x->TGL_SURAT_PERMOHONAN), 
                    'nama_pemohon' => $x->NAMA_PEMOHON, 
                    'alamat_pemohon' => $x->ALAMAT_PEMOHON, 
                    'telp' => $x->NO_HP, 
                    'keterangan' => $x->KETERANGAN_PST, 

                    // 'nama_wp_sppt' => $dt->NM_WP_SPPT, 
                    // 'alamat_op_sppt' => $dt->ALAMAT_OP_SPPT, 
                    // 'pbb_yg_harus_dibayar' => $dt->PBB_YG_HARUS_DIBAYAR_SPPT, 

                    'jns_png' => $dt->NM_SUB_JENIS_PELAYANAN,
                    'pct_png' => $dt->PCT_PENGURANGAN,
                    'pct_png_disetujui' => $dt->NM_SUB_JENIS_PELAYANAN,
                    // 'sts_png' => $dt->STS_PENGURANGAN,

                );

                $data['da'] = (array)$dt;

                $data['fnopnik'] = $x->NOPNIK;

                //---------------------------------------------------------------------------------------------------------
                $select_data  = $this->permohonan_online_upt_model->get_jns_ply($x->KD_JNS_PELAYANAN);
                if ($select_data) {
                    foreach ($select_data as $row) {
                        $options[$row->KD_JNS_PELAYANAN] = $row->NM_JENIS_PELAYANAN;
                    }
                } else {
                    $options['0'] = 'Data not found';
                }
                // $js     = 'id="jns_ply" required style="width:90%; height:100% !important;" onchange="jns_ply_chg(this.value)" ';
                $js     = 'class="form-control" id="jns_ply" readonly ';
                $select = form_dropdown('jns_ply', $options, $x->KD_JNS_PELAYANAN, $js);
                $select = preg_replace("/[\r\n]+/", "", $select);
                $data['select_jns_ply'] = $select;
                //---------------------------------------------------------------------------------------------------------
                $select_data_sub  = $this->permohonan_online_upt_model->get_sub_jns_ply($x->KD_JNS_PELAYANAN, $x->KD_SUB_JNS_PELAYANAN);
                if ($select_data_sub) {
                    foreach ($select_data_sub as $row) {
                        $optionsub[$row->KD_SUB_JNS_PELAYANAN] = $row->NM_SUB_JENIS_PELAYANAN;
                    }
                } else {
                    $optionsub['0'] = 'Data not found';
                }
                $js     = 'class="form-control" id="sub_jns_ply" readonly ';
                $select = form_dropdown('sub_jns_ply', $optionsub, $x->KD_SUB_JNS_PELAYANAN, $js);
                $select = preg_replace("/[\r\n]+/", "", $select);
                $data['select_sub_jns_ply'] = $select;
                //---------------------------------------------------------------------------------------------------------

                $this->load->view('vloket_permohonan_online_upt_08_form', $data);

            } else if ($x->KD_JNS_PELAYANAN == '22') {
                $dt = $this->permohonan_online_upt_model->get_dt_sismiop_asli($param);
                $data['dt'] = array(
                    'nop_re' => $x->NOP_LKP, 
                    'id_reg_esppt' => $x->NOPNIK, 
                    'rowid' => $x->PPO_ID, 
                    'id_ppo' => $x->PPO_ID, 
                    'nopel' => $x->NOPEL, 
                    'nop' => $x->NOP_LKP, 
                    'ket_pst' => $x->ALASAN,

                    'nama_wp_re' => $x->NAMA_WP_REG, 
                    'alamat_op_re' => $x->ALAMAT_REG, 
                    'nik_re' => $x->NIK_REG, 
                    'no_telp_re' => $x->TELP_REG,
                    'nama_re' => $x->NAMA_REG, 
                    'email_re' => $x->EMAIL_REG,
                    'kd_jns_ply' => $x->KD_JNS_PELAYANAN,
                    'kd_sub_jns_ply' => $x->KD_SUB_JNS_PELAYANAN,

                    'no_permohonan' => $x->NO_SRT_PERMOHONAN, 
                    'thn_permohonan' => $x->THN_PAJAK_PERMOHONAN, 
                    'tgl_permohonan' => get_date($x->TGL_SURAT_PERMOHONAN), 
                    'nama_pemohon' => $x->NAMA_PEMOHON, 
                    'alamat_pemohon' => $x->ALAMAT_PEMOHON, 
                    'telp' => $x->NO_HP, 
                    'keterangan' => $x->KETERANGAN_PST, 

                    'nama_wp_sppt' => $dt->NM_WP, 
                    'alamat_op_sppt' => $dt->JALAN_OP, 
                    'subjek_pajak_id' => $dt->SUBJEK_PAJAK_ID, 
                    'blok_op' => $dt->BLOK_KAV_NO_OP, 
                    'luas_bumi' => $dt->TOTAL_LUAS_BUMI, 
                    'luas_bangunan' => $dt->TOTAL_LUAS_BNG, 
                    'rt_op' => $dt->RT_OP, 
                    'rw_op' => $dt->RW_OP, 

                );

                $data['nm_jns_pelayanan'] = strtoupper($dt->NM_JENIS_PELAYANAN);
                $data['fnopnik'] = $x->NOPNIK;

                //---------------------------------------------------------------------------------------------------------
                $select_data  = $this->permohonan_online_upt_model->get_jns_ply($x->KD_JNS_PELAYANAN);
                if ($select_data) {
                    foreach ($select_data as $row) {
                        $options[$row->KD_JNS_PELAYANAN] = $row->NM_JENIS_PELAYANAN;
                    }
                } else {
                    $options['0'] = 'Data not found';
                }
                // $js     = 'id="jns_ply" required style="width:90%; height:100% !important;" onchange="jns_ply_chg(this.value)" ';
                $js     = 'class="form-select" id="jns_ply" readonly ';
                $select = form_dropdown('jns_ply', $options, $x->KD_JNS_PELAYANAN, $js);
                $select = preg_replace("/[\r\n]+/", "", $select);
                $data['select_jns_ply'] = $select;
                //---------------------------------------------------------------------------------------------------------

                $this->load->view('vloket_permohonan_online_upt_default_form', $data);
            }
            

        } else {
            $this->session->set_flashdata('msg_success', 'Data tidak ditemukan.');
            redirect(active_module_url('loket_permohonan_online_upt'));
        }

    }

    public function edit() {
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_danger', $this->module_auth->msg_read);
            redirect('tool_pbb');
        }

        $param     = $this->uri->segment(4);

        $data['page_menu'] = 'loket_permohonan_online_upt';
        $data['current'] = '';
        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = active_module_url("loket_permohonan_online_upt/update/{$param}");
        
        $x = $this->permohonan_online_upt_model->get_ppo_by_id($param);

        if ($x){
            if (!in_array($x->STATUS_PERMOHONAN, ['1', 'E', 'F'])) {
                $this->session->set_flashdata('msg_warning', 'Tidak bisa edit data.');
                redirect(active_module_url('loket_permohonan_online_upt'));
            }

            if ($x->KD_JNS_PELAYANAN == '02' || $x->KD_JNS_PELAYANAN == '03') {
                $dt = $this->permohonan_online_upt_model->get_by_id($param);
        
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
                    'kd_sub_jns_ply' => $dt->KD_SUB_JNS_PELAYANAN,
                    'ket_pst' => $dt->ALASAN,

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
                    'latitude' => $x->LATITUDE,
                    'longitude' => $x->LONGITUDE,

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

                $this->load->view('vloket_permohonan_online_upt_form', $data);
            } else if ($x->KD_JNS_PELAYANAN == '15') {
                $dt = $this->permohonan_online_upt_model->get_dt_angsuran($param);
                $pst_angs = $this->permohonan_online_upt_model->get_pst_angsuran($param);
        
                $data['dt'] = array(
                    'nop_re' => $x->NOP_LKP, 
                    'id_reg_esppt' => $x->NOPNIK, 
                    'nama_wp_re' => $x->NAMA_WP_REG, 
                    'alamat_op_re' => $x->ALAMAT_REG, 
                    'nik_re' => $x->NIK_REG, 
                    'no_telp_re' => $x->TELP_REG,
                    'nama_re' => $x->NAMA_REG, 
                    'email_re' => $x->EMAIL_REG,
                    'ket_pst' => $x->ALASAN,

                    'rowid' => $x->PPO_ID, 
                    'id_ppo' => $x->PPO_ID, 
                    'nopel' => $x->NOPEL, 
                    'no_permohonan' => $x->NO_SRT_PERMOHONAN, 
                    'thn_permohonan' => $x->THN_PAJAK_PERMOHONAN, 
                    'nop' => $x->NOP_LKP, 
                    'tgl_permohonan' => get_date($x->TGL_SURAT_PERMOHONAN), 
                    'nama_pemohon' => $x->NAMA_PEMOHON, 
                    'alamat_pemohon' => $x->ALAMAT_PEMOHON, 
                    'telp' => $x->NO_HP, 
                    'keterangan' => $x->KETERANGAN_PST, 
                    'kd_jns_ply' => $x->KD_JNS_PELAYANAN,

                    'nama_wp_sppt' => $dt->NM_WP_SPPT, 
                    'alamat_op_sppt' => $dt->ALAMAT_OP_SPPT, 
                    'pbb_yg_harus_dibayar' => $dt->PBB_YG_HARUS_DIBAYAR_SPPT, 

                    'jatuh_tempo_1' => app_date($pst_angs->TGL_C_I),
                    'nominal_1' => $pst_angs->CICILAN_I,
                    'jatuh_tempo_2' => app_date($pst_angs->TGL_C_II),
                    'nominal_2' => $pst_angs->CICILAN_II,
                    'jatuh_tempo_3' => app_date($pst_angs->TGL_C_III),
                    'nominal_3' => $pst_angs->CICILAN_III,
                    'jatuh_tempo_4' => app_date($pst_angs->TGL_C_IV),
                    'nominal_4' => $pst_angs->CICILAN_IV,

                );

                $data['da'] = (array)$dt;

                $data['fnopnik'] = $x->NOPNIK;

                //---------------------------------------------------------------------------------------------------------
                $select_data  = $this->permohonan_online_upt_model->get_jns_ply($x->KD_JNS_PELAYANAN);
                if ($select_data) {
                    foreach ($select_data as $row) {
                        $options[$row->KD_JNS_PELAYANAN] = $row->NM_JENIS_PELAYANAN;
                    }
                } else {
                    $options['0'] = 'Data not found';
                }
                // $js     = 'id="jns_ply" required style="width:90%; height:100% !important;" onchange="jns_ply_chg(this.value)" ';
                $js     = 'class="form-control" id="jns_ply" readonly ';
                $select = form_dropdown('jns_ply', $options, $x->KD_JNS_PELAYANAN, $js);
                $select = preg_replace("/[\r\n]+/", "", $select);
                $data['select_jns_ply'] = $select;
                //---------------------------------------------------------------------------------------------------------

                $this->load->view('vloket_permohonan_online_upt_angs_form', $data); 
            } else if ($x->KD_JNS_PELAYANAN == '08') {
                $dt = $this->permohonan_online_upt_model->get_dt_pengurangan($param);
        
                $data['dt'] = array(
                    'nop_re' => $x->NOP_LKP, 
                    'id_reg_esppt' => $x->NOPNIK, 
                    'rowid' => $x->PPO_ID, 
                    'id_ppo' => $x->PPO_ID, 
                    'nopel' => $x->NOPEL, 
                    'nop' => $x->NOP_LKP, 
                    'ket_pst' => $x->ALASAN,

                    'nama_wp_re' => $x->NAMA_WP_REG, 
                    'alamat_op_re' => $x->ALAMAT_REG, 
                    'nik_re' => $x->NIK_REG, 
                    'no_telp_re' => $x->TELP_REG,
                    'nama_re' => $x->NAMA_REG, 
                    'email_re' => $x->EMAIL_REG,
                    'kd_jns_ply' => $x->KD_JNS_PELAYANAN,
                    'kd_sub_jns_ply' => $x->KD_SUB_JNS_PELAYANAN,

                    'no_permohonan' => $x->NO_SRT_PERMOHONAN, 
                    'thn_permohonan' => $x->THN_PAJAK_PERMOHONAN, 
                    'tgl_permohonan' => get_date($x->TGL_SURAT_PERMOHONAN), 
                    'nama_pemohon' => $x->NAMA_PEMOHON, 
                    'alamat_pemohon' => $x->ALAMAT_PEMOHON, 
                    'telp' => $x->NO_HP, 
                    'keterangan' => $x->KETERANGAN_PST, 

                    // 'nama_wp_sppt' => $dt->NM_WP_SPPT, 
                    // 'alamat_op_sppt' => $dt->ALAMAT_OP_SPPT, 
                    // 'pbb_yg_harus_dibayar' => $dt->PBB_YG_HARUS_DIBAYAR_SPPT, 

                    'jns_png' => $dt->NM_SUB_JENIS_PELAYANAN,
                    'pct_png' => $dt->PCT_PENGURANGAN,
                    'pct_png_disetujui' => $dt->NM_SUB_JENIS_PELAYANAN,
                    // 'sts_png' => $dt->STS_PENGURANGAN,

                );

                $data['da'] = (array)$dt;

                $data['fnopnik'] = $x->NOPNIK;

                //---------------------------------------------------------------------------------------------------------
                $select_data  = $this->permohonan_online_upt_model->get_jns_ply($x->KD_JNS_PELAYANAN);
                if ($select_data) {
                    foreach ($select_data as $row) {
                        $options[$row->KD_JNS_PELAYANAN] = $row->NM_JENIS_PELAYANAN;
                    }
                } else {
                    $options['0'] = 'Data not found';
                }
                // $js     = 'id="jns_ply" required style="width:90%; height:100% !important;" onchange="jns_ply_chg(this.value)" ';
                $js     = 'class="form-control" id="jns_ply" readonly ';
                $select = form_dropdown('jns_ply', $options, $x->KD_JNS_PELAYANAN, $js);
                $select = preg_replace("/[\r\n]+/", "", $select);
                $data['select_jns_ply'] = $select;
                //---------------------------------------------------------------------------------------------------------
                $select_data_sub  = $this->permohonan_online_upt_model->get_sub_jns_ply($x->KD_JNS_PELAYANAN, $x->KD_SUB_JNS_PELAYANAN);
                if ($select_data_sub) {
                    foreach ($select_data_sub as $row) {
                        $optionsub[$row->KD_SUB_JNS_PELAYANAN] = $row->NM_SUB_JENIS_PELAYANAN;
                    }
                } else {
                    $optionsub['0'] = 'Data not found';
                }
                $js     = 'class="form-control" id="sub_jns_ply" readonly ';
                $select = form_dropdown('sub_jns_ply', $optionsub, $x->KD_SUB_JNS_PELAYANAN, $js);
                $select = preg_replace("/[\r\n]+/", "", $select);
                $data['select_sub_jns_ply'] = $select;
                //---------------------------------------------------------------------------------------------------------

                $this->load->view('vloket_permohonan_online_upt_08_form', $data);

            } else if ($x->KD_JNS_PELAYANAN == '22') {
                $dt = $this->permohonan_online_upt_model->get_dt_sismiop_asli($param);
                $data['dt'] = array(
                    'nop_re' => $x->NOP_LKP, 
                    'id_reg_esppt' => $x->NOPNIK, 
                    'rowid' => $x->PPO_ID, 
                    'id_ppo' => $x->PPO_ID, 
                    'nopel' => $x->NOPEL, 
                    'nop' => $x->NOP_LKP, 
                    'ket_pst' => $x->ALASAN,

                    'nama_wp_re' => $x->NAMA_WP_REG, 
                    'alamat_op_re' => $x->ALAMAT_REG, 
                    'nik_re' => $x->NIK_REG, 
                    'no_telp_re' => $x->TELP_REG,
                    'nama_re' => $x->NAMA_REG, 
                    'email_re' => $x->EMAIL_REG,
                    'kd_jns_ply' => $x->KD_JNS_PELAYANAN,
                    'kd_sub_jns_ply' => $x->KD_SUB_JNS_PELAYANAN,

                    'no_permohonan' => $x->NO_SRT_PERMOHONAN, 
                    'thn_permohonan' => $x->THN_PAJAK_PERMOHONAN, 
                    'tgl_permohonan' => get_date($x->TGL_SURAT_PERMOHONAN), 
                    'nama_pemohon' => $x->NAMA_PEMOHON, 
                    'alamat_pemohon' => $x->ALAMAT_PEMOHON, 
                    'telp' => $x->NO_HP, 
                    'keterangan' => $x->KETERANGAN_PST, 

                    'nama_wp_sppt' => $dt->NM_WP, 
                    'alamat_op_sppt' => $dt->JALAN_OP, 
                    'subjek_pajak_id' => $dt->SUBJEK_PAJAK_ID, 
                    'blok_op' => $dt->BLOK_KAV_NO_OP, 
                    'luas_bumi' => $dt->TOTAL_LUAS_BUMI, 
                    'luas_bangunan' => $dt->TOTAL_LUAS_BNG, 
                    'rt_op' => $dt->RT_OP, 
                    'rw_op' => $dt->RW_OP, 

                );

                $data['nm_jns_ply'] = $dt->NM_JENIS_PELAYANAN;
                $data['fnopnik'] = $x->NOPNIK;
                $data['nm_jns_pelayanan'] = $x->NM_JENIS_PELAYANAN;

                //---------------------------------------------------------------------------------------------------------
                $select_data  = $this->permohonan_online_upt_model->get_jns_ply($x->KD_JNS_PELAYANAN);
                if ($select_data) {
                    foreach ($select_data as $row) {
                        $options[$row->KD_JNS_PELAYANAN] = $row->NM_JENIS_PELAYANAN;
                    }
                } else {
                    $options['0'] = 'Data not found';
                }
                // $js     = 'id="jns_ply" required style="width:90%; height:100% !important;" onchange="jns_ply_chg(this.value)" ';
                $js     = 'class="form-control" id="jns_ply" readonly ';
                $select = form_dropdown('jns_ply', $options, $x->KD_JNS_PELAYANAN, $js);
                $select = preg_replace("/[\r\n]+/", "", $select);
                $data['select_jns_ply'] = $select;
                //---------------------------------------------------------------------------------------------------------

                $this->load->view('vloket_permohonan_online_upt_default_form', $data);
            }

        } else {
            $this->session->set_flashdata('msg_danger', 'Data tidak ditemukan..');
            redirect(active_module_url('loket_permohonan_online_upt'));
        }

    }

    public function approve() { 
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
            redirect(active_module_url('tool_pbb'));
        }
       
        $p_id       = $this->uri->segment(4);
        $post_data = $this->fpost();

        $nopel    = $this->input->post('nopel');
        $keterangan = $this->input->post('ket_pst');
        $id_ppo = $this->input->post('id_ppo');

        if ($nopel && $get = $this->permohonan_online_upt_model->get_ppo_by_id($id_ppo)) {
            if (in_array($get->STATUS_PERMOHONAN, ['1', 'E', 'F']) ) {
                
                $nop_pemohon = $get->NOP_LKP;
                $nop_pemohon2 = $get->NOP;

                $this->db->trans_start();
                $this->db->where("ID", $id_ppo);
                $this->db->update("PST_PERMOHONAN_TOOL", array(
                    'STATUS_PERMOHONAN' => '4'
                ));
                $this->db->trans_complete(); // COMMIT

                $kd_cl = 'P';
                $sts_permo = '4';
                $tambahan_update = array();
                $id_next_pgw = 0;
                $kdjns = $get->KD_JNS_PELAYANAN; 
                $kdsub = $get->KD_SUB_JNS_PELAYANAN ?: null;

                if ($get->KD_JNS_PELAYANAN == '03') {
                    // if ($get->KD_SUB_JNS_PELAYANAN == '02') {
                    //     $kd_cl = 'N';
                    //     $sts_permo = 'A';

                    //     //paket generate nomer SK
                    //     $get_no_sk = $this->pembetulan_model->select_max_no_sk();
                    //     $new_thn_sk = $get_no_sk['THN_SURAT'];
                    //     $new_urut_sk = intval($get_no_sk['NO_URUT_SK']) + 1;
                    //     $this->pembetulan_model->update_max_no_sk($new_thn_sk, $new_urut_sk);
                    //     // closed paket generate nomer SK

                    //     $tgl_sk = date('Y-m-d');
                    //     $ins_no_sk = '900.1.13/' . str_pad($new_urut_sk, 6, "0", STR_PAD_LEFT) . '/KPTS-PKP/' . bulan_romawi(date('m')) . '/' . $new_thn_sk;

                    //     $tambahan_update = array(
                    //         'NO_SK'             => $ins_no_sk,
                    //         'TGL_SK'            => $tgl_sk,
                    //         'URUT_SK'           => $new_urut_sk,
                    //     );
                    // } else 
                    if ($get->KD_SUB_JNS_PELAYANAN == '03') {
                        $kd_cl = 'O';
                        $sts_permo = 'H';

                        //paket generate nomer SK
                        $get_no_sk = $this->pembetulan_model->select_max_no_sk();
                        $new_thn_sk = $get_no_sk['THN_SURAT'];
                        $new_urut_sk = intval($get_no_sk['NO_URUT_SK']) + 1;
                        $this->pembetulan_model->update_max_no_sk($new_thn_sk, $new_urut_sk);
                        // closed paket generate nomer SK

                        $tgl_sk = date('Y-m-d');
                        $tgl_bap = date('Y-m-d');
                        $ins_no_sk = '900.1.13/' . str_pad($new_urut_sk, 6, "0", STR_PAD_LEFT) . '/KPTS-PKP/' . bulan_romawi(date('m')) . '/' . $new_thn_sk;
                        $ins_no_bap = '000.1.6/' . str_pad($new_urut_sk, 6, "0", STR_PAD_LEFT) . '/PEMBETULAN-PKP/' . bulan_romawi(date('m')) . '/' . $new_thn_sk;

                        //// get nik untuk pegawai (looping)
                        $jns_bid = '3B';
                        $get_dt_pegawai = $this->permohonan_online_upt_model->get_next_pegawai_penetapan($jns_bid, $kdjns, $kdsub);
                        $id_next_pgw = $get_dt_pegawai->ID;
                        $nip_next_pgw = $get_dt_pegawai->NIP;
                        $nip_next_atsn  = $get_dt_pegawai->NIP_ATASAN;

                        $tambahan_update = array(
                            'NO_SK'             => $ins_no_sk,
                            'TGL_SK'            => $tgl_sk,
                            'NO_BAP_LAPANGAN'   => $ins_no_bap,
                            'TGL_BAP_LAPANGAN'  => $tgl_bap,
                            'URUT_SK'           => $new_urut_sk,
                            'NIP_VER_PNTP'      => $nip_next_pgw,
                            'NIP_BID_PNPT'      => $nip_next_atsn,
                        );
                    } else {
                        $kd_cl = 'M';
                        $sts_permo = '4';

                        //// get nik untuk pegawai (looping)
                        $jns_bid = '1A';
                        $get_dt_pegawai = $this->permohonan_online_upt_model->get_next_pegawai($jns_bid, $kdjns, $kdsub);
                        $id_next_pgw = $get_dt_pegawai->ID;
                        $nip_next_pgw = $get_dt_pegawai->NIP;

                        $tambahan_update = array(
                            'NIP_VER_PDL'  => $nip_next_pgw
                        );
                    }
                } else if ($get->KD_JNS_PELAYANAN == '15') { // angsuran
                    $kd_cl = 'N';
                    $sts_permo = 'A';

                    //// get nik untuk pegawai (looping)
                    $jns_bid = '2A';
                    $get_dt_pegawai = $this->permohonan_online_upt_model->get_next_pegawai($jns_bid, $kdjns, $kdsub);
                    $id_next_pgw = $get_dt_pegawai->ID;
                    $nip_next_pgw = $get_dt_pegawai->NIP;

                    $tambahan_update = array(
                        'NIP_KOOR_PKP'  => $nip_next_pgw
                    );
                } else if ($get->KD_JNS_PELAYANAN == '08') { // pengurangan
                    $kd_cl = 'N';
                    $sts_permo = '8';

                    //paket generate nomer SK
                    $get_no_sk = $this->pembetulan_model->select_max_no_sk();
                    $new_thn_sk = $get_no_sk['THN_SURAT'];
                    $new_urut_sk = intval($get_no_sk['NO_URUT_SK']) + 1;
                    $this->pembetulan_model->update_max_no_sk($new_thn_sk, $new_urut_sk);
                    // closed paket generate nomer SK

                    $tgl_sk = date('Y-m-d');
                    $ins_no_sk = '900.1.13/' . str_pad($new_urut_sk, 6, "0", STR_PAD_LEFT) . '/KPTS-PKP/' . bulan_romawi(date('m')) . '/' . $new_thn_sk;

                    //// get nik untuk pegawai (looping)
                    $jns_bid = '2B';
                    $kdsub = null;
                    $get_dt_pegawai = $this->permohonan_online_upt_model->get_next_pegawai($jns_bid, $kdjns, null);
                    $id_next_pgw = $get_dt_pegawai->ID;
                    $nip_next_pgw = $get_dt_pegawai->NIP;

                    $tambahan_update = array(
                        'NO_SK'             => $ins_no_sk,
                        'TGL_SK'            => $tgl_sk,
                        'URUT_SK'           => $new_urut_sk,
                        'NIP_VER_PKP'      => $nip_next_pgw
                    );
                } else if ($get->KD_JNS_PELAYANAN == '22') { // aktivasi nop
                    $kd_cl = 'O';
                    $sts_permo = 'H';

                    $qrr = "SELECT MAX(S.THN_PAJAK_SPPT) AS THN_PAJAK_SPPT 
                            FROM SPPT S
                            JOIN PST_PERMOHONAN_TOOL P ON S.KD_PROPINSI=P.KD_PROPINSI_PEMOHON AND S.KD_DATI2=P.KD_DATI2_PEMOHON
                                AND S.KD_KECAMATAN=P.KD_KECAMATAN_PEMOHON AND S.KD_KELURAHAN=P.KD_KELURAHAN_PEMOHON
                                AND S.KD_BLOK=P.KD_BLOK_PEMOHON AND S.NO_URUT=P.NO_URUT_PEMOHON AND S.KD_JNS_OP=P.KD_JNS_OP_PEMOHON
                            WHERE P.ID = {$id_ppo}";
                    
                    $row_thn = $this->db->query($qrr)->row(); 
                    $max_thn = $row_thn ? $row_thn->THN_PAJAK_SPPT : date('Y');

                    $thn_awal  = (int)$max_thn + 1;
                    $thn_akhir = (int)date('Y');

                    for($i=$thn_awal; $i<=$thn_akhir; $i++) {
                        $dt_thn_mutasi = array(
                            'DOC_ID' => $id_ppo,
                            'TAHUN' => $i,
                            'JENIS' => 3
                        );

                        $this->pembetulan_model->insert_thn_online($dt_thn_mutasi);
                    }

                    //// get nik untuk pegawai (looping)
                    $jns_bid = '3B';
                    $get_dt_pegawai = $this->permohonan_online_upt_model->get_next_pegawai_penetapan($jns_bid, $kdjns, $kdsub);
                    $id_next_pgw = $get_dt_pegawai->ID;
                    $nip_next_pgw = $get_dt_pegawai->NIP;
                    $nip_next_atsn  = $get_dt_pegawai->NIP_ATASAN;

                    $tambahan_update = array(
                        'NIP_VER_PNTP'  => $nip_next_pgw,
                        'NIP_BID_PNPT'      => $nip_next_atsn,
                    );
                } else if ($get->KD_JNS_PELAYANAN == '02') { // MUTASI HABIS
                    $kd_cl = 'M';
                    $sts_permo = '4';

                    //// get nik untuk pegawai (looping)
                    $jns_bid = '5A';
                    $get_dt_pegawai = $this->permohonan_online_upt_model->get_next_pegawai($jns_bid, $kdjns, $kdsub);
                    $id_next_pgw = $get_dt_pegawai->ID;
                    $nip_next_pgw = $get_dt_pegawai->NIP;

                    $tambahan_update = array(
                        'NIP_VER_PDL'  => $nip_next_pgw
                    );
                } 

                $update_data = array(
                    'STATUS_PERMOHONAN' => $sts_permo,
                    'KETERANGAN_PST' => $keterangan,
                    // 'NIP_PENERIMA' => sipkd_user_nip(),
                    'TGL_APR_LOKET' => current_time_ora(),
                );

                $update_data = array_merge($update_data, $tambahan_update);

                $result = $this->permohonan_online_upt_model->update_data_permohonan_online_by_id($id_ppo, $update_data);
                if ($result) {
                    // if ($get->KD_JNS_PELAYANAN == '03') {
                    //     $aq = "UPDATE TRACKING SET TGL_VER_PDN=SYSDATE, KET_ARSIP=(SELECT NAMA FROM CLAPPPDN WHERE KODE='9'), CL_APP_PDN='9' 
                    //         WHERE THN_PELAYANAN||'-'||BUNDEL_PELAYANAN||'-'||NO_URUT_PELAYANAN='$nopel' AND KD_PROPINSI||KD_DATI2||KD_KECAMATAN||KD_KELURAHAN||KD_BLOK||NO_URUT||KD_JNS_OP='$nop_pemohon2' ";
                    // } 
                    // else if ($get->KD_JNS_PELAYANAN == '18') {
                    //     $aq = "UPDATE TRACKING SET TGL_VER_PDN=SYSDATE, KET_ARSIP=(SELECT NAMA FROM CLAPPPDN WHERE KODE='9'), CL_APP_PDN='9' 
                    //         WHERE THN_PELAYANAN||'-'||BUNDEL_PELAYANAN||'-'||NO_URUT_PELAYANAN='$nopel' AND KD_PROPINSI||KD_DATI2||KD_KECAMATAN||KD_KELURAHAN||KD_BLOK||NO_URUT||KD_JNS_OP='$nop_pemohon2' ";
                    // } else if ($get->KD_JNS_PELAYANAN == '07') {
                    //     $aq = "UPDATE TRACKING SET TGL_VER_PDN=SYSDATE, KET_ARSIP=(SELECT NAMA FROM CLAPPPDN WHERE KODE='9'), CL_APP_PDN='9' 
                    //         WHERE THN_PELAYANAN||'-'||BUNDEL_PELAYANAN||'-'||NO_URUT_PELAYANAN='$nopel' AND KD_PROPINSI||KD_DATI2||KD_KECAMATAN||KD_KELURAHAN||KD_BLOK||NO_URUT||KD_JNS_OP='$nop_pemohon2' ";
                    // } 
                    // else {
                    //    $aq = "UPDATE TRACKING SET KET_ARSIP=(SELECT NAMA FROM CLAPPPDN WHERE KODE='P'), CL_APP_PDN='P' 
                    //        WHERE THN_PELAYANAN||'-'||BUNDEL_PELAYANAN||'-'||NO_URUT_PELAYANAN='$nopel' ";
                    // }

                    $aq = "UPDATE TRACKING SET KET_ARSIP=(SELECT NAMA FROM CLAPPPDN WHERE KODE='$kd_cl'), CL_APP_PDN='$kd_cl' 
                            WHERE THN_PELAYANAN||'-'||BUNDEL_PELAYANAN||'-'||NO_URUT_PELAYANAN='$nopel' ";

                    // if ($get->KD_JNS_PELAYANAN == '03') {
                    //     if ($get->KD_SUB_JNS_PELAYANAN == '02') {
                    //         $aq = "UPDATE TRACKING SET KET_ARSIP=(SELECT NAMA FROM CLAPPPDN WHERE KODE='N'), CL_APP_PDN='N' 
                    //             WHERE THN_PELAYANAN||'-'||BUNDEL_PELAYANAN||'-'||NO_URUT_PELAYANAN='$nopel' ";
                    //     } else {
                    //         $aq = "UPDATE TRACKING SET KET_ARSIP=(SELECT NAMA FROM CLAPPPDN WHERE KODE='M'), CL_APP_PDN='M' 
                    //             WHERE THN_PELAYANAN||'-'||BUNDEL_PELAYANAN||'-'||NO_URUT_PELAYANAN='$nopel' ";
                    //     }
                    // } else {
                    //     $aq = "UPDATE TRACKING SET KET_ARSIP=(SELECT NAMA FROM CLAPPPDN WHERE KODE='P'), CL_APP_PDN='P' 
                    //         WHERE THN_PELAYANAN||'-'||BUNDEL_PELAYANAN||'-'||NO_URUT_PELAYANAN='$nopel' ";
                    // }

                    //// update status ke pegawai baru
                    $xx = $this->permohonan_online_upt_model->set_next_pegawai($id_next_pgw, $jns_bid, $kdjns, $kdsub);

                    
                    $this->db->query($aq);
                    
                    $nm_jns_pelayanan = $get->NM_JENIS_PELAYANAN;
                    $tgl_srt_permohonan = post_date($get->TGL_SURAT_PERMOHONAN);
                    $tgl_perkiraan_selesai = post_date($get->TGL_PERKIRAAN_SELESAI);
                    $email_wp = $get->EMAIL_REG;
                    $d_today = date('d-m-Y');

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

                    $message = '
                        <html>
                        <head>
                            <title>Permohonan PBB Online Anda Telah Diverifikasi</title>
                        </head>
                        <body style="font-family: Arial, sans-serif; background-color: #f6f9fc; margin:0; padding:20px;">
                            <table align="center" cellpadding="0" cellspacing="0" width="600" 
                                   style="background-color:#ffffff; border-radius:8px; 
                                          box-shadow:0 2px 6px rgba(0,0,0,0.1);">
                                <tr>
                                    <td style="background-color:#2b8a3e; padding:16px; 
                                               border-radius:8px 8px 0 0; 
                                               text-align:center; color:#ffffff;">
                                        <h2 style="margin:0;">Permohonan PBB Online Anda Telah Diverifikasi</h2>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:30px; color:#555; font-size:15px;">
                                        <p style="font-size:16px;">Selamat, permohonan PBB Online Anda telah berhasil diverifikasi. Berikut detail permohonan:</p>

                                        <table cellpadding="5" cellspacing="0" width="100%" style="font-size:15px; color:#555;">
                                            <tr>
                                                <td width="180"><strong>No Pelayanan</strong></td>
                                                <td>: '.$nopel.'</td>
                                            </tr>
                                            <tr>
                                                <td><strong>NOP</strong></td>
                                                <td>: '.$nop_pemohon.'</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Jenis Pelayanan</strong></td>
                                                <td>: '.$nm_jns_pelayanan.'</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Tanggal Kirim Berkas</strong></td>
                                                <td>: '.$tgl_srt_permohonan.'</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Perkiraan Selesai</strong></td>
                                                <td>: '.$tgl_perkiraan_selesai.'</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Catatan</strong></td>
                                                <td>: '.$keterangan.'</td>
                                            </tr>
                                        </table>

                                        <br>

                                        <p>
                                            Silakan cek status berkas Anda melalui menu <strong>Permohonan Online</strong> pada website 
                                            <strong>PBB Online Kabupaten Bogor</strong>.
                                        </p>

                                        <p style="margin-top:50px; text-align:center;">Cibinong, '.$d_today.'</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="background-color:#f0f0f0; text-align:center; padding:15px;
                                               font-size:13px; color:#999; border-radius:0 0 8px 8px;">
                                        Email ini dikirim otomatis oleh sistem. Mohon tidak membalas email ini.<br>
                                        &copy; '.date('Y').' Bappenda Kabupaten Bogor
                                    </td>
                                </tr>

                            </table>
                        </body>
                        </html>';

                    $this->load->library('email', $config);
                    $this->email->set_newline("\r\n");
                    $this->email->from(SMTP_USER, SMTP_UNAME);
                    $this->email->to($email_wp);
                    $this->email->subject('Approve Permohonan Online ('.$nopel.')');
                    $this->email->message($message);

                    if ($this->email->send()) {
                        $this->session->set_flashdata('msg_success', 'Data telah di approve (Berhasil Kirim Email ke WP)');
                        // echo 'berhasil';
                    } else {
                        $this->session->set_flashdata('msg_warning', 'Data telah di approve (Gagal Kirim Email ke WP)');
                        // echo $this->email->print_debugger(); die();
                    }
                    // die();
                    // $this->session->set_flashdata('msg_success', 'Data telah di approve');
                    redirect(active_module_url('loket_permohonan_online_upt'));
                } else {
                    $this->session->set_flashdata('msg_warning', 'Gagal update data status permohonan');
                    // echo 'ERROR... Status Dokumen Bukan Kirim WP..';
                    redirect(active_module_url('loket_permohonan_online_upt'));
                }

            } else {
                $this->session->set_flashdata('msg_warning', 'ERROR... Status Dokumen Bukan Kirim WP..');
                // echo 'ERROR... Status Dokumen Bukan Kirim WP..';
                redirect(active_module_url('loket_permohonan_online_upt'));
            }
        } else {
            show_404();
        }

        // $this->load->view('vloket_permohonan_online_upt_form', $data);
    }

    public function kirim_ke_pkp() { 
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
            redirect(active_module_url('tool_pbb'));
        }
       
        $p_id       = $this->uri->segment(4);
        $post_data = $this->fpost();

        $nopel    = $this->input->post('nopel');
        $keterangan = $this->input->post('ket_pst');
        $id_ppo = $this->input->post('id_ppo');

        if ($nopel && $get = $this->permohonan_online_upt_model->get_ppo_by_id($id_ppo)) {
            if (in_array($get->STATUS_PERMOHONAN, ['1', 'E', 'F']) ) {
                
                $nop_pemohon = $get->NOP_LKP;
                $nop_pemohon2 = $get->NOP;

                $this->db->trans_start();
                $this->db->where("ID", $id_ppo);
                $this->db->update("PST_PERMOHONAN_TOOL", array(
                    'STATUS_PERMOHONAN' => '4'
                ));
                $this->db->trans_complete(); // COMMIT

                //// Langsung kirim ke Verif PKP

                $kd_cl = 'N';
                $sts_permo = '8';
                $tambahan_update = array();
                $id_next_pgw = 0;
                $kdjns = $get->KD_JNS_PELAYANAN; 
                $kdsub = $get->KD_SUB_JNS_PELAYANAN ?: null;

                if ($kdjns == '03' && $kdsub == '02') {
                    //// get nik untuk pegawai (looping)
                    $jns_bid = '2B';
                    $get_dt_pegawai = $this->permohonan_online_upt_model->get_next_pegawai($jns_bid, $kdjns, $kdsub);
                    $id_next_pgw = $get_dt_pegawai->ID;
                    $nip_next_pgw = $get_dt_pegawai->NIP;

                    $update_data = array(
                        'STATUS_PERMOHONAN' => $sts_permo,
                        'KETERANGAN_PST' => $keterangan,
                        'TGL_APR_LOKET' => current_time_ora(),
                        'NIP_VER_PKP'  => $nip_next_pgw
                    );

                    $result = $this->permohonan_online_upt_model->update_data_permohonan_online_by_id($id_ppo, $update_data);
                    if ($result) {

                        $aq = "UPDATE TRACKING SET KET_ARSIP=(SELECT NAMA FROM CLAPPPDN WHERE KODE='$kd_cl'), CL_APP_PDN='$kd_cl' 
                                WHERE THN_PELAYANAN||'-'||BUNDEL_PELAYANAN||'-'||NO_URUT_PELAYANAN='$nopel' ";

                        //// update status ke pegawai baru
                        $xx = $this->permohonan_online_upt_model->set_next_pegawai($id_next_pgw, $jns_bid, $kdjns, $kdsub);

                        
                        $this->db->query($aq);
                        
                        $nm_jns_pelayanan = $get->NM_JENIS_PELAYANAN;
                        $tgl_srt_permohonan = post_date($get->TGL_SURAT_PERMOHONAN);
                        $tgl_perkiraan_selesai = post_date($get->TGL_PERKIRAAN_SELESAI);
                        $email_wp = $get->EMAIL_REG;
                        $d_today = date('d-m-Y');

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

                        $message = '
                            <html>
                            <head>
                                <title>Permohonan PBB Online Anda Telah Diverifikasi</title>
                            </head>
                            <body style="font-family: Arial, sans-serif; background-color: #f6f9fc; margin:0; padding:20px;">
                                <table align="center" cellpadding="0" cellspacing="0" width="600" 
                                       style="background-color:#ffffff; border-radius:8px; 
                                              box-shadow:0 2px 6px rgba(0,0,0,0.1);">
                                    <tr>
                                        <td style="background-color:#2b8a3e; padding:16px; 
                                                   border-radius:8px 8px 0 0; 
                                                   text-align:center; color:#ffffff;">
                                            <h2 style="margin:0;">Permohonan PBB Online Anda Telah Diverifikasi</h2>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding:30px; color:#555; font-size:15px;">
                                            <p style="font-size:16px;">Selamat, permohonan PBB Online Anda telah berhasil diverifikasi. Berikut detail permohonan:</p>

                                            <table cellpadding="5" cellspacing="0" width="100%" style="font-size:15px; color:#555;">
                                                <tr>
                                                    <td width="180"><strong>No Pelayanan</strong></td>
                                                    <td>: '.$nopel.'</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>NOP</strong></td>
                                                    <td>: '.$nop_pemohon.'</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Jenis Pelayanan</strong></td>
                                                    <td>: '.$nm_jns_pelayanan.'</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Tanggal Kirim Berkas</strong></td>
                                                    <td>: '.$tgl_srt_permohonan.'</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Perkiraan Selesai</strong></td>
                                                    <td>: '.$tgl_perkiraan_selesai.'</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Catatan</strong></td>
                                                    <td>: '.$keterangan.'</td>
                                                </tr>
                                            </table>

                                            <br>

                                            <p>
                                                Silakan cek status berkas Anda melalui menu <strong>Permohonan Online</strong> pada website 
                                                <strong>PBB Online Kabupaten Bogor</strong>.
                                            </p>

                                            <p style="margin-top:50px; text-align:center;">Cibinong, '.$d_today.'</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="background-color:#f0f0f0; text-align:center; padding:15px;
                                                   font-size:13px; color:#999; border-radius:0 0 8px 8px;">
                                            Email ini dikirim otomatis oleh sistem. Mohon tidak membalas email ini.<br>
                                            &copy; '.date('Y').' Bappenda Kabupaten Bogor
                                        </td>
                                    </tr>

                                </table>
                            </body>
                            </html>';

                        $this->load->library('email', $config);
                        $this->email->set_newline("\r\n");
                        $this->email->from(SMTP_USER, SMTP_UNAME);
                        $this->email->to($email_wp);
                        $this->email->subject('Approve Permohonan Online ('.$nopel.')');
                        $this->email->message($message);

                        if ($this->email->send()) {
                            $this->session->set_flashdata('msg_success', 'Data telah dikirim ke PKP (Berhasil Kirim Email ke WP)');
                            // echo 'berhasil';
                        } else {
                            $this->session->set_flashdata('msg_warning', 'Data telah dikirim ke PKP (Gagal Kirim Email ke WP)');
                            // echo $this->email->print_debugger(); die();
                        }
                        // die();
                        // $this->session->set_flashdata('msg_success', 'Data telah di approve');
                        redirect(active_module_url('loket_permohonan_online_upt'));
                    } else {
                        $this->session->set_flashdata('msg_warning', 'Gagal update data status permohonan');
                        // echo 'ERROR... Status Dokumen Bukan Kirim WP..';
                        redirect(active_module_url('loket_permohonan_online_upt'));
                    }
                } else {
                    $this->session->set_flashdata('msg_warning', 'ERROR... Hanya dokumen Sub Pembetulan Luas Bumi/Bangunan yang bisa dikirim ke PKP..');
                    // echo 'ERROR... Status Dokumen Bukan Kirim WP..';
                    redirect(active_module_url('loket_permohonan_online_upt'));
                }

                

            } else {
                $this->session->set_flashdata('msg_warning', 'ERROR... Status Dokumen Bukan Kirim WP..');
                // echo 'ERROR... Status Dokumen Bukan Kirim WP..';
                redirect(active_module_url('loket_permohonan_online_upt'));
            }
        } else {
            show_404();
        }

        // $this->load->view('vloket_permohonan_online_upt_form', $data);
    }

    public function tolak() { 
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
            redirect(active_module_url('loket_permohonan_online_upt'));
        }

        $p_id       = $this->uri->segment(4);

        $id_ppo = $this->input->post('id_ppo');
        $nopel    = $this->input->post('nopel');
        $keterangan = $this->input->post('ket_pst');
        if ($nopel && $get = $this->permohonan_online_upt_model->get_ppo_by_id($id_ppo)) {
            // if (intval($get->STATUS_PERMOHONAN) == '1') {
            if (in_array(intval($get->STATUS_PERMOHONAN), ['1', 'E', 'F'])) {
                $nop_pemohon = $get->NOP_LKP;
                $nop_pemohon2 = $get->NOP;
                $nama_pemohon = $get->NAMA_WP_REG;
                $email_wp = $get->EMAIL_REG;
                
                $update_data = array(
                    'STATUS_PERMOHONAN' => '3',
                    'ALASAN' => $keterangan,
                );
                $this->permohonan_online_upt_model->update_data_permohonan_online_by_id($id_ppo, $update_data);
                // var_dump($keterangan);
                // die();

                $this->permohonan_online_upt_model->insert_tolak($id_ppo);
                // $this->permohonan_online_upt_model->delete_tolak($id_ppo);
                
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
                
                $message = '
                        <html>
                        <head>
                            <title>Pemberitahuan Permohonan PBB Online</title>
                        </head>
                        <body style="font-family: Arial, sans-serif; background-color: #f6f9fc; margin: 0; padding: 20px;">
                            <table align="center" cellpadding="0" cellspacing="0" width="600" 
                                   style="background-color: #ffffff; border-radius: 8px; 
                                          box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                                <tr>
                                    <td style="background-color: #d9534f; padding: 16px; 
                                               border-radius: 8px 8px 0 0; 
                                               text-align: center; color: #ffffff;">
                                        <h2 style="margin: 0;">PERMOHONAN PBB ONLINE TIDAK DAPAT DIPROSES</h2>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 30px; font-size: 15px; color: #444;">
                                        <p>Hai <strong>'.$nama_pemohon.'</strong>,</p>

                                        <p style="line-height: 1.6;">
                                            Mohon maaf, permohonan PBB Online Anda dengan 
                                            <strong>Nomor Pelayanan: '.$nopel.'</strong> 
                                            tidak dapat diproses lebih lanjut karena:
                                        </p>

                                        <blockquote style="background: #f9e2e2; padding: 12px 18px; 
                                                           border-left: 4px solid #d9534f; 
                                                           color: #b52b27; border-radius: 4px;">
                                            '.$keterangan.'
                                        </blockquote>

                                        <p style="line-height: 1.6;">
                                            Silakan ajukan permohonan ulang menggunakan akun yang sama 
                                            dan pastikan seluruh data serta berkas yang dilampirkan telah lengkap.
                                        </p>

                                        <p>Terima kasih.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f0f0f0; text-align: center; 
                                               padding: 15px; font-size: 13px; color: #999; 
                                               border-radius: 0 0 8px 8px;">
                                        &copy; '.date('Y').' Bappenda Kabupaten Bogor
                                    </td>
                                </tr>

                            </table>
                        </body>
                        </html>';

                $this->load->library('email', $config);
                $this->email->set_newline("\r\n");
                $this->email->from(SMTP_USER, SMTP_UNAME);
                $this->email->to($email_wp);
                $this->email->subject('Tolak Permohonan Online ('.$nopel.')');
                $this->email->message($message);

                if ($this->email->send()) {

                    $this->session->set_flashdata('msg_success', 'Data berhasil di tolak');
                    redirect(active_module_url('loket_permohonan_online_upt'));
                } else {
                    // echo $this->email->print_debugger();
                    $this->session->set_flashdata('msg_warning', 'Gagal Kirim Email');
                    redirect(active_module_url('loket_permohonan_online_upt'));
                }
                
            } else {
                $this->session->set_flashdata('msg_success', 'ERROR... Status Dokumen Bukan Approve WP..');
                redirect(active_module_url('loket_permohonan_online_upt'));
            }
            
        } else {
            show_404();
        }

    }

    public function tolak_kelengkapan() { 
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
            redirect(active_module_url('loket_permohonan_online_upt'));
        }

        $p_id       = $this->uri->segment(4);

        $id_ppo = $this->input->post('id_ppo');
        $nopel    = $this->input->post('nopel');
        $keterangan = $this->input->post('ket_pst');
        if ($nopel && $get = $this->permohonan_online_upt_model->get_ppo_by_id($id_ppo)) {
            // if (intval($get->STATUS_PERMOHONAN) == '1') {
            if (in_array(intval($get->STATUS_PERMOHONAN), ['1', 'E', 'F'])) {
                $nop_pemohon = $get->NOP_LKP;
                $nop_pemohon2 = $get->NOP;
                $nama_pemohon = $get->NAMA_WP_REG;
                $email_wp = $get->EMAIL_REG;
                // if($id_ppo == 10002220) {
                //     $email_wp = 'sendi.yadi@gmail.com';
                // }
                
                $update_data = array(
                    'STATUS_PERMOHONAN' => 'E',
                    'ALASAN' => $keterangan,
                );
                $this->permohonan_online_upt_model->update_data_permohonan_online_by_id($id_ppo, $update_data);
                // var_dump($keterangan);
                // die();

                $this->permohonan_online_upt_model->insert_tolak($id_ppo);
                // $this->permohonan_online_upt_model->delete_tolak($id_ppo);
                
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
                
                $message = '
                        <html>
                        <head>
                            <title>Pemberitahuan Permohonan PBB Online</title>
                        </head>
                        <body style="font-family: Arial, sans-serif; background-color: #f6f9fc; margin: 0; padding: 20px;">
                            <table align="center" cellpadding="0" cellspacing="0" width="600" 
                                   style="background-color: #ffffff; border-radius: 8px; 
                                          box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                                <tr>
                                    <td style="background-color: #d9534f; padding: 16px; 
                                               border-radius: 8px 8px 0 0; 
                                               text-align: center; color: #ffffff;">
                                        <h2 style="margin: 0;">PERMOHONAN PBB ONLINE TIDAK DAPAT DIPROSES</h2>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 30px; font-size: 15px; color: #444;">
                                        <p>Hai <strong>'.$nama_pemohon.'</strong>,</p>

                                        <p style="line-height: 1.6;">
                                            Mohon maaf, permohonan PBB Online Anda dengan 
                                            <strong>Nomor Pelayanan: '.$nopel.'</strong> 
                                            tidak dapat diproses lebih lanjut karena:
                                        </p>

                                        <blockquote style="background: #f9e2e2; padding: 12px 18px; 
                                                           border-left: 4px solid #d9534f; 
                                                           color: #b52b27; border-radius: 4px;">
                                            '.$keterangan.'
                                        </blockquote>

                                        <p style="line-height: 1.6;">
                                            Silakan ajukan usulan perbaikan data pada Nomer Pelayanan yang sama 
                                            dan pastikan seluruh data serta berkas yang dilampirkan telah lengkap.
                                        </p>

                                        <p>Terima kasih.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f0f0f0; text-align: center; 
                                               padding: 15px; font-size: 13px; color: #999; 
                                               border-radius: 0 0 8px 8px;">
                                        &copy; '.date('Y').' Bappenda Kabupaten Bogor
                                    </td>
                                </tr>

                            </table>
                        </body>
                        </html>';

                $this->load->library('email', $config);
                $this->email->set_newline("\r\n");
                $this->email->from(SMTP_USER, SMTP_UNAME);
                $this->email->to($email_wp);
                $this->email->subject('Tolak Permohonan Online ('.$nopel.')');
                $this->email->message($message);

                if ($this->email->send()) {

                    $this->session->set_flashdata('msg_success', 'Data berhasil di tolak');
                    redirect(active_module_url('loket_permohonan_online_upt'));
                } else {
                    // echo $this->email->print_debugger();
                    $this->session->set_flashdata('msg_warning', 'Gagal Kirim Email');
                    redirect(active_module_url('loket_permohonan_online_upt'));
                }
                
            } else {
                $this->session->set_flashdata('msg_success', 'ERROR... Status Dokumen Bukan Approve WP..');
                redirect(active_module_url('loket_permohonan_online_upt'));
            }
            
        } else {
            show_404();
        }

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

    public function get_lampiran_by_pelayanan() {
        $kd = $this->input->post('jns_ply'); // KD_JNS_PELAYANAN
        $data = new stdClass();

        $lampiran = $this->permohonan_online_upt_model->getLampiran($kd);

        if ($lampiran) {
            $data->result = "200";
            $data->lampiran = $lampiran;
        } else {
            $data->result = "400";
            $data->lampiran = [];
        }

        echo json_encode($data);
    }

    public function get_lampiran_by_pelayanan_and_sub() {
        $kd = $this->input->post('jns_ply'); // KD_JNS_PELAYANAN
        $kdsub = $this->input->post('sub_jns_ply'); // KD_SUB_JNS_PELAYANAN
        $data = new stdClass();

        if ($kdsub != '999999') {
            $lampiran = $this->permohonan_online_upt_model->getLampiranSub($kd, $kdsub);
        } else {
            $lampiran = $this->permohonan_online_upt_model->getLampiran($kd);
        }
        

        if ($lampiran) {
            $data->result = "200";
            $data->lampiran = $lampiran;
        } else {
            $data->result = "400";
            $data->lampiran = [];
        }

        echo json_encode($data);
    }


}
