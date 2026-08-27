<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class tool_pbb extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (active_module()!='tool_pbb') {
            show_404();
            exit;
        }

        $this->load->model('login_model');

        if ($grp = $this->login_model->check_user_app()) {
            $this->session->set_userdata('groupid', $grp->GROUP_ID);
            $this->session->set_userdata('groupkd', $grp->GROUP_KODE);
            $this->session->set_userdata('groupname', htmlspecialchars($grp->GROUP_NAMA));
        }

        $this->load->model(array('apps_model', 'login_model'));
        $this->load->helper(active_module());
    }

    public function index() {
        redirect(active_module_url('main'));
    }

    public function main()
    {

        $user_login = sipkd_user_login();

        if ($user_login == "sa") {
            $this->create_menus_utama();
            $this->create_menus_sub();
            $this->create_menus_tran();
            $this->create_menus_btn();
        }

        $data['page_menu'] = 'beranda';
        $data['current']   = 'beranda';
        $data['lvl_2'] = '';
        $data['apps']      = $this->apps_model->get_active_only();

        $this->load->view('vmain', $data);

    }

    public function create_menus_utama()
    {
        $app_id = sipkd_app_id();
        // echo $app_id; die;
        $this->apps_model->create_modules_menu($app_id, 'MENU_LIST_USER', 'Menu List User');
        $this->apps_model->create_modules_menu($app_id, 'MENU_UPDATE_SPPT', 'Menu Update SPPT');
        $this->apps_model->create_modules_menu($app_id, 'MENU_SIMULASI_SPPT', 'Menu Simulasi SPPT');
        $this->apps_model->create_modules_menu($app_id, 'MENU_EDIT_BAYAR_SPPT', 'Menu Edit Bayar SPPT');
        $this->apps_model->create_modules_menu($app_id, 'MENU_PERMOHONAN_ONLINE', 'Menu Permohonan Online UPT');
        $this->apps_model->create_modules_menu($app_id, 'MENU_MONITORING_PELAYANAN', 'Menu Monitoring Pelayanan UPT');
        $this->apps_model->create_modules_menu($app_id, 'MENU_CEK_PEM_VIRTUAL_ACC', 'Menu Cek Pembayaran Virtual Account');
        $this->apps_model->create_modules_menu($app_id, 'MENU_DAFNOM', 'Menu Dafnom');
        $this->apps_model->create_modules_menu($app_id, 'MENU_UPDATE_DAFNOM', 'Menu Update Dafnom');
        $this->apps_model->create_modules_menu($app_id, 'MENU_REKAM_BAYAR_SPPT', 'Menu Rekam Bayar SPPT');
        $this->apps_model->create_modules_menu($app_id, 'MENU_CEK_SPPT', 'Menu Cek SPPT');
        $this->apps_model->create_modules_menu($app_id, 'MENU_SK_NJOP', 'Menu SK NJOP');
        $this->apps_model->create_modules_menu($app_id, 'MENU_SIMULASI_SPPT_DAFNOM', 'Menu Simulasi SPPT Dafnom');
        $this->apps_model->create_modules_menu($app_id, 'MENU_INFO_RINCI_PBB', 'Menu Info Rinci PBB');
        $this->apps_model->create_modules_menu($app_id, 'MENU_UPT', 'Menu UPT');
        $this->apps_model->create_modules_menu($app_id, 'MENU_LOKET', 'Menu Loket UPT');
        $this->apps_model->create_modules_menu($app_id, 'MENU_PENETAPAN_UPT', 'Menu Penetapan UPT');
        $this->apps_model->create_modules_menu($app_id, 'MENU_PENDANIL', 'Menu Pendanil UPT');
        $this->apps_model->create_modules_menu($app_id, 'MENU_BID_KEBERATAN', 'Menu Bidang Keberatan UPT');
        $this->apps_model->create_modules_menu($app_id, 'MENU_VERIFIKASI', 'Menu Verifikasi UPT');
        $this->apps_model->create_modules_menu($app_id, 'MENU_CEK_NIK', 'Menu Check NIK');
        $this->apps_model->create_modules_menu($app_id, 'MENU_CEK_BPHTB', 'Menu Check BPHTB');
        $this->apps_model->create_modules_menu($app_id, 'MENU_SPOP_LSPOP', 'Menu SPOP LSPOP');
    }

    public function create_menus_sub()
    {
        $app_id = sipkd_app_id();
    }

    public function create_menus_tran()
    {
        $app_id = sipkd_app_id();
        $this->apps_model->create_modules($app_id, 'list_user', 'List Users', 'MENU_LIST_USER');
        $this->apps_model->create_modules($app_id, 'update_sppt', 'Update SPPT', 'MENU_UPDATE_SPPT');
        $this->apps_model->create_modules($app_id, 'simulasi_sppt', 'Simulasi SPPT', 'MENU_SIMULASI_SPPT');
        $this->apps_model->create_modules($app_id, 'edit_bayar_sppt', 'Edit Bayar SPPT', 'MENU_EDIT_BAYAR_SPPT');
        $this->apps_model->create_modules($app_id, 'permohonan_online', 'Permohonan Online UPT', 'MENU_PERMOHONAN_ONLINE');
        $this->apps_model->create_modules($app_id, 'monitoring_pelayanan', 'Monitoring Pelayanan UPT', 'MENU_MONITORING_PELAYANAN');
        $this->apps_model->create_modules($app_id, 'cek_pembayaran_virtual_acc', 'Cek Pembayaran Virtual Account', 'MENU_CEK_PEM_VIRTUAL_ACC');
        $this->apps_model->create_modules($app_id, 'dafnom', 'Dafnom', 'MENU_DAFNOM');
        $this->apps_model->create_modules($app_id, 'update_dafnom', 'Update Dafnom', 'MENU_UPDATE_DAFNOM');
        $this->apps_model->create_modules($app_id, 'rekam_bayar_sppt', 'Rekam Bayar SPPT', 'MENU_REKAM_BAYAR_SPPT');
        $this->apps_model->create_modules($app_id, 'cek_sppt', 'Cek SPPT', 'MENU_CEK_SPPT');
        $this->apps_model->create_modules($app_id, 'sk_njop', 'SK NJOP', 'MENU_SK_NJOP');
        $this->apps_model->create_modules($app_id, 'simulasi_sppt_dafnom', 'Simulasi SPPT Dafnom', 'MENU_SIMULASI_SPPT_DAFNOM');
        $this->apps_model->create_modules($app_id, 'info_rinci_pbb', 'Info Rinci PBB', 'MENU_INFO_RINCI_PBB');
        $this->apps_model->create_modules($app_id, 'permohonan_online_upt', 'Permohonan Online UPT2', 'MENU_UPT');
        $this->apps_model->create_modules($app_id, 'monitoring_permo_upt', 'Monitoring Permohonan Online UPT', 'MENU_UPT');
        $this->apps_model->create_modules($app_id, 'loket_permohonan_online_upt', 'Loket Permohonan Online UPT', 'MENU_LOKET');
        $this->apps_model->create_modules($app_id, 'pnt_mutasi_habis', 'Penetapan Mutasi Habis UPT', 'MENU_PENETAPAN_UPT');
        $this->apps_model->create_modules($app_id, 'pnt_pembetulan', 'Penetapan Pembetulan UPT', 'MENU_PENETAPAN_UPT');
        $this->apps_model->create_modules($app_id, 'pdl_pembetulan', 'Pendanil Pembetulan UPT', 'MENU_PENDANIL');
        $this->apps_model->create_modules($app_id, 'bid_keberatan_pembetulan', 'Bidang Keberatan Pembetulan UPT', 'MENU_BID_KEBERATAN');
        $this->apps_model->create_modules($app_id, 'bid_keberatan_angsuran', 'Bidang Keberatan Angsuran UPT', 'MENU_BID_KEBERATAN');
        $this->apps_model->create_modules($app_id, 'pnt_angsuran', 'Penetapan Angsuran UPT', 'MENU_PENETAPAN_UPT');
        $this->apps_model->create_modules($app_id, 'bid_keberatan_pengurangan', 'Bidang Keberatan Pengurangan UPT', 'MENU_BID_KEBERATAN');
        $this->apps_model->create_modules($app_id, 'pnt_pengurangan', 'Penetapan Pengurangan UPT', 'MENU_PENETAPAN_UPT');
        $this->apps_model->create_modules($app_id, 'pnt_aktivasi_nop', 'Penetapan Aktivasi SPPT', 'MENU_PENETAPAN_UPT');
        // $this->apps_model->create_modules($app_id, 'pdl_mutasi_habis', 'Pendanil Mutasi Habis', 'MENU_PENDANIL');
        $this->apps_model->create_modules($app_id, 'pdl_mutasi_habis', 'Pendanil Mutasi Habis', 'MENU_VERIFIKASI');
        $this->apps_model->create_modules($app_id, 'monitoring_permohonan_online_upt', 'Monitoring Permo Online UPT', 'MENU_MONITORING_PELAYANAN');
        $this->apps_model->create_modules($app_id, 'pdl_pembetulan_kasubid', 'Kasubid Pendanil Pembetulan UPT', 'MENU_PENDANIL');
        $this->apps_model->create_modules($app_id, 'pdl_pembetulan_kabid', 'Kabid Pendanil Pembetulan UPT', 'MENU_PENDANIL');

        $this->apps_model->create_modules($app_id, 'bid_keberatan_pembetulan_verif', 'Verifikasi Bidang Keberatan Pembetulan UPT', 'MENU_BID_KEBERATAN');
        $this->apps_model->create_modules($app_id, 'bid_keberatan_pembetulan_kasubid', 'Kasubid Bidang Keberatan Pembetulan UPT', 'MENU_BID_KEBERATAN');
        $this->apps_model->create_modules($app_id, 'bid_keberatan_pembetulan_kabid', 'Kabid Bidang Keberatan Pembetulan UPT', 'MENU_BID_KEBERATAN');
        $this->apps_model->create_modules($app_id, 'bid_keberatan_pembetulan_kaban', 'Kepala Badan - Bid Keberatan Pembetulan UPT', 'MENU_BID_KEBERATAN');
        $this->apps_model->create_modules($app_id, 'bid_keberatan_pembetulan_sekban', 'Sekretaris Badan - Bid Keberatan Pembetulan UPT', 'MENU_BID_KEBERATAN');

        $this->apps_model->create_modules($app_id, 'pnt_pembetulan_verif', 'Verifikasi Penetapan Pembetulan UPT', 'MENU_PENETAPAN_UPT');
        $this->apps_model->create_modules($app_id, 'pnt_aktivasi_nop_verif', 'Verifikasi Penetapan Aktivasi SPPT', 'MENU_PENETAPAN_UPT');
        $this->apps_model->create_modules($app_id, 'pnt_mutasi_habis_verif', 'Verifikasi Penetapan Mutasi Habis UPT', 'MENU_PENETAPAN_UPT');

        $this->apps_model->create_modules($app_id, 'bid_keberatan_pengurangan_verif', 'Verifikasi Bidang Keberatan Pengurangan UPT', 'MENU_BID_KEBERATAN');
        $this->apps_model->create_modules($app_id, 'bid_keberatan_pengurangan_kasubid', 'Kasubid Bidang Keberatan Pengurangan UPT', 'MENU_BID_KEBERATAN');
        $this->apps_model->create_modules($app_id, 'bid_keberatan_pengurangan_kabid', 'Kabid Bidang Keberatan Pengurangan UPT', 'MENU_BID_KEBERATAN');
        $this->apps_model->create_modules($app_id, 'bid_keberatan_pengurangan_kaban', 'Kepala Badan - Bid Keberatan Pengurangan UPT', 'MENU_BID_KEBERATAN');
        $this->apps_model->create_modules($app_id, 'bid_keberatan_pengurangan_sekban', 'Sekretris Badan - Bid Keberatan Pengurangan UPT', 'MENU_BID_KEBERATAN');

        $this->apps_model->create_modules($app_id, 'pnt_pengurangan_verif', 'Verifikasi Penetapan Pengurangan UPT', 'MENU_PENETAPAN_UPT');

        $this->apps_model->create_modules($app_id, 'check_nik', 'Check NIK', 'MENU_CEK_NIK');
        $this->apps_model->create_modules($app_id, 'check_bphtb', 'Check BPHTB', 'MENU_CEK_BPHTB');
        $this->apps_model->create_modules($app_id, 'spop_lspop', 'Menu Detail SPOP LSPOP', 'MENU_SPOP_LSPOP');




    }

    public function create_menus_btn()
    {
        $app_id = sipkd_app_id();

    }

}
