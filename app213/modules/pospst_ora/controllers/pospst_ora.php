<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class pospst_ora extends CI_Controller
{
    //private $module = 'postransaksi';

    function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('login')) {
            $this->session->set_flashdata('msg_warning', 'Session telah kadaluarsa, silahkan login ulang.');
            redirect('login');
            exit;
        }

        if (active_module() != 'pospst_ora') {
            show_404();
            exit;
        }

        $module = 'pospst_ora';
        $this->load->library('module_auth', array('module' => $module));

        $this->load->model(array('apps_model', 'login_model', 'pos_user_model'));

        if ($grp = $this->login_model->check_user_app()) {
            $this->session->set_userdata('groupid', $grp->GROUP_ID);
            $this->session->set_userdata('groupkd', $grp->GROUP_KODE);
            $this->session->set_userdata('groupname', htmlspecialchars($grp->GROUP_NAMA));
        }

        if (!$this->pos_user_model->set_user()) {
            $this->session->set_flashdata('msg_warning', 'Area Pembayaran Tidak Valid');
        }

        //ngakalin user-pbbms link     
        $this->session->set_userdata('user_area', '0000000000');
    }

    public function index()
    {
        $data['tpnm']     = isset($this->session->userdata['tpnm']) ? $this->session->userdata['tpnm'] : '';
        $data['tes_tpnm'] = isset($this->session->userdata['tpnm']) ? $this->session->userdata['tpnm'] : 'nulll';

        $data['apps']      = $this->apps_model->get_active_only();
        $data['page_menu'] = 'beranda';
        $data['current']   = 'beranda';

        $user_login = lda_user_login();

        if ($user_login == "sa") {

            $this->create_menus_utama();
            $this->create_menus_sub();
            $this->create_menus_tran();
            $this->create_menus_btn();

            // $this->test();             

        }

        $this->load->view('vmain', $data);
    }

    function create_menus_utama()
    {

        $app_id = lda_app_id();
        //log_message('info', "BBBBBBBBBB CREATE MODULE : " .$app_id);
        //log_message('info', "CCCCCCCCCCCCCCCCCC CREATE MODULE : " .$this->session->userdata('app_id'));
        // Menu Utama Referensi
        $this->apps_model->create_modules_menu($app_id, 'm01_mn_pemby_khusus', 'Menu Pembayaran Khusus');
        $this->apps_model->create_modules_menu($app_id, 'm02_mn_stts', 'Menu STTS');
        $this->apps_model->create_modules_menu($app_id, 'm03_mn_transaksi', 'Menu Transaksi');
        $this->apps_model->create_modules_menu($app_id, 'm04_mn_laporan', 'Menu Laporan');
        $this->apps_model->create_modules_menu($app_id, 'm05_mn_users', 'Menu Users');
    }

    function create_menus_sub()
    {

        $app_id = lda_app_id();
        // Menu Sub
        $this->apps_model->create_modules_menu_sub($app_id, 'm01_sm_hapus_sanksi_admin', 'Sub Menu Penghapusan sanksi Adm.', 'm01_mn_pemby_khusus');
    }

    function create_menus_tran()
    {

        $app_id = lda_app_id();
        //$this->apps_model->create_modules($app_id,'dashboard','DASHBOARD');
        // Menu Pembayaran Khusus
        $this->apps_model->create_modules($app_id, 'pst_penghapusan_individu', 'Hapus Sanksi Adm.Individu', 'm01_sm_hapus_sanksi_admin');
        $this->apps_model->create_modules($app_id, 'pst_penghapusan_kolektif', 'Hapus Sanksi Adm.Kolektif', 'm01_sm_hapus_sanksi_admin');

        $this->apps_model->create_modules($app_id, 'pst_keberatan', 'Pembayaran Khusus - Keberatan', 'm01_mn_pemby_khusus');
        $this->apps_model->create_modules($app_id, 'pst_angsuran', 'Pembayaran Khusus - Angsuran', 'm01_mn_pemby_khusus');
        $this->apps_model->create_modules($app_id, 'pst_pembatalan', 'Pembayaran Khusus - Pembatalan', 'm01_mn_pemby_khusus');

        // Menu STTS
        $this->apps_model->create_modules($app_id, 'sts_bayar_op', 'Status Pembayaran', 'm02_mn_stts');
        $this->apps_model->create_modules($app_id, 'bayar_by_nop_thn', 'Cetak STTS', 'm02_mn_stts');
        $this->apps_model->create_modules($app_id, 'bayar_by_nop_all_thn', 'Cetak STTS Per tahun', 'm02_mn_stts');
        $this->apps_model->create_modules($app_id, 'bayar_by_range_nop_thn', 'Cetak STTS Per Range', 'm02_mn_stts');
        $this->apps_model->create_modules($app_id, 'bayar_by_blok_thn', 'Cetak STTS Per Blok', 'm02_mn_stts');
        $this->apps_model->create_modules($app_id, 'upload_nop', 'Cetak STTS Upload NOP', 'm02_mn_stts');
        $this->apps_model->create_modules($app_id, 'salinan_stts', 'Salinan STTS', 'm02_mn_stts');
        $this->apps_model->create_modules($app_id, 'batal_pembayaran', 'Pembatalan STTS', 'm02_mn_stts');

        // Menu Transaksi
        $this->apps_model->create_modules($app_id, 'rekap_bulan', 'Rekap Bulanan', 'm03_mn_transaksi');
        $this->apps_model->create_modules($app_id, 'rekap_harian', 'Rekap Harian', 'm03_mn_transaksi');
        $this->apps_model->create_modules($app_id, 'rincian_harian', 'Rincian Harian', 'm03_mn_transaksi');
        $this->apps_model->create_modules($app_id, 'rekap_user', 'Rekap User', 'm03_mn_transaksi');
        $this->apps_model->create_modules($app_id, 'rincian_user', 'Rincian User', 'm03_mn_transaksi');

        // Menu Laporan Harian
        $this->apps_model->create_modules($app_id, 'lap_trima_harian', 'Laporan Penerimaan Harian', 'm04_mn_laporan');
        $this->apps_model->create_modules($app_id, 'lap_batal', 'Laporan Pembatalan Harian', 'm04_mn_laporan');

        //Menu Users
        $this->apps_model->create_modules($app_id, 'pos_user', 'POSPBB Users', 'm05_mn_users');
        //$this->apps_model->create_modules($app_id,'pos_tp','Tempat Pembayaran','m05_mn_users');
        $this->apps_model->create_modules($app_id, 'tp_bayar', 'Tempat Pembayaran Bank', 'm05_mn_users');
    }

    function create_menus_btn()
    {

        //log_message('info', "BBBBBBBBBB CREATE MODULE : " );
        $app_id = lda_app_id();
        //$this->apps_model->create_modules_btn($app_id,'sts_bayar_op','btn_2','button TES', 2);
        /*
        $this->apps_model->create_modules_btn($app_id,'dashboard','btn_2','button 2', 2);
        $this->apps_model->create_modules_btn($app_id,'dashboard','btn_3','button 3', 3);
        $this->apps_model->create_modules_btn($app_id,'dashboard','btn_4','button 4', 4);
        $this->apps_model->create_modules_btn($app_id,'dashboard','btn_5','button 5', 5);
        $this->apps_model->create_modules_btn($app_id,'dashboard','btn_6','button 6', 6);
        $this->apps_model->create_modules_btn($app_id,'dashboard','btn_7','button 7', 7);
        $this->apps_model->create_modules_btn($app_id,'dashboard','btn_8','button 8', 8);
        $this->apps_model->create_modules_btn($app_id,'dashboard','btn_9','button 9', 9);
        */
    }


    function test()
    {

        $data_tes = array(
            'KD_PROPINSI' => 'kd_propinsi',
            'KD_DATI2' => 'kd_dati2',
            'KD_KECAMATAN' => 'kd_kecamatan',
            'KD_KELURAHAN' => 'kd_kelurahan',
            'KD_BLOK' => 'kd_blok',
            'NO_URUT' => 'no_urut',
            'KD_JNS_OP' => 'kd_jns_op',
            'THN_PAJAK_SPPT' => '2021',
            'PEMBAYARAN_SPPT_KE' => '1',
            'DENDA_SPPT' => '802000',
            'JML_SPPT_YG_DIBAYAR' => '8995959',
            'TGL_PEMBAYARAN_SPPT' => '2021-09-15',
            'TGL_REKAM_BYR_SPPT' => '2021-06-30',
            'NIP_REKAM_BYR_SPPT' => '898978978978789',
        );

        $tabel = "datax";
        $tes   = 'INSERT INTO ' . $tabel . " (" . implode(', ', array_keys($data_tes)) . ')
        select "' . implode('", "', array_values($data_tes)) . '"
        from dual 
        where not exists()';

        log_message('info', "BBBBBBBBBB TES INSERT : " . $tes);
    }
}
