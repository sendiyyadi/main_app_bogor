<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class penagihan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (active_module() != 'penagihan') {
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

        // log_message('info', " BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB  : " .buku_name(2));
        //pp

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
        //
        //if(!wp_login())
        $this->load->view('vmain', $data);
        //else
        //	$this->load->view('wp/vmenu', $data);
    }

    public function create_menus_utama()
    {

        //log_message('info', "BBBBBBBBBB CREATE MODULE : " );
        $app_id = sipkd_app_id();
        $this->apps_model->create_modules_menu($app_id, 'MENU_LIST_USER', 'Menu List User');
        $this->apps_model->create_modules_menu($app_id, 'MENU_SPPT_BERMASALAH', 'Menu SPPT Bermasalah');
        $this->apps_model->create_modules_menu($app_id, 'MENU_PERUBAHAN_SPPT', 'Menu Perubahan SPPT');
        $this->apps_model->create_modules_menu($app_id, 'MENU_PROSES_LAPORAN', 'Menu Proses Laporan');
        $this->apps_model->create_modules_menu($app_id, 'MENU_LAPORAN', 'Menu Laporan');
        $this->apps_model->create_modules_menu($app_id, 'MENU_LAP_PERUBAHAN_SPPT', 'Menu Laporan Perubahan SPPT');
        $this->apps_model->create_modules_menu($app_id, 'MENU_PEMBETULAN_SPPT', 'Menu Pembetulan SPPT');
        $this->apps_model->create_modules_menu($app_id, 'MENU_LAP_DISTRIBUSI', 'Menu Laporan Distribusi');
        $this->apps_model->create_modules_menu($app_id, 'MENU_LAP_SPPT', 'Menu Laporan SPPT');
        $this->apps_model->create_modules_menu($app_id, 'MENU_PEMBATALAN_SPPT_NEW', 'Menu Laporan Pembatalan SPPT');
        $this->apps_model->create_modules_menu($app_id, 'MENU_PEMUTAKHIRAN_SPPT', 'Menu Laporan Pemutakhiran SPPT');

    }

    public function create_menus_sub()
    {

        //log_message('info', "BBBBBBBBBB CREATE MODULE : " );
        $app_id = sipkd_app_id();
        // Menu Sub
        //$this->apps_model->create_modules_menu_sub($app_id,'m01_tes','Sub Menu Ref. TES','MENU_TES');
        // $this->apps_model->create_modules_menu_sub($app_id,'m_verlap','Sub Menu Verlap','MENU_VERLAP');
    }

    public function create_menus_tran()
    {

        //log_message('info', "BBBBBBBBBB CREATE MODULE : " );
        $app_id = sipkd_app_id();
        //$this->apps_model->create_modules($app_id,'dashboard','DASHBOARD');
        $this->apps_model->create_modules($app_id, 'list_user', 'List Users', 'MENU_LIST_USER');
        $this->apps_model->create_modules($app_id, 'sppt_bermasalah', 'SPPT Bermasalah', 'MENU_SPPT_BERMASALAH');
        $this->apps_model->create_modules($app_id, 'perubahan_sppt', 'Perubahan SPPT', 'MENU_PERUBAHAN_SPPT');
        $this->apps_model->create_modules($app_id, 'proses_laporan', 'Proses Laporan', 'MENU_PROSES_LAPORAN');
        $this->apps_model->create_modules($app_id, 'laporan', 'Laporan', 'MENU_LAPORAN');
        $this->apps_model->create_modules($app_id, 'pembetulan_sppt', 'Pembetulan SPPT', 'MENU_PEMBETULAN_SPPT');
        $this->apps_model->create_modules($app_id, 'laporan_perubahan_sppt', 'Laporan Perubahan SPPT', 'MENU_LAP_PERUBAHAN_SPPT');
        $this->apps_model->create_modules($app_id, 'lap_distribusi', 'Laporan Distribusi', 'MENU_LAP_DISTRIBUSI');
        $this->apps_model->create_modules($app_id, 'lap_sppt', 'Laporan SPPT', 'MENU_LAP_SPPT');
        $this->apps_model->create_modules($app_id, 'pembatalan_sppt_new', 'Laporan Pembatalan SPPT', 'MENU_PEMBATALAN_SPPT_NEW');
        $this->apps_model->create_modules($app_id, 'pemutakhiran_sppt', 'Laporan Pemutakhiran SPPT', 'MENU_PEMUTAKHIRAN_SPPT');
    }

    public function create_menus_btn()
    {

        //log_message('info', "BBBBBBBBBB CREATE MODULE : " );
        $app_id = sipkd_app_id();
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
}
