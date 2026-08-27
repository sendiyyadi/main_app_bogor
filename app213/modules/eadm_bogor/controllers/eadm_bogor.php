<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class eadm_bogor extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (active_module()!='eadm_bogor') {
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

        $user_login = sipkd_user_login();

        if ($user_login == "sa") {
            $this->create_menus_utama();
            $this->create_menus_sub();
            $this->create_menus_tran();
            $this->create_menus_btn();
        }
        /*
        $model = $this->load->model('pad_model');
        if($row = $model->get_pemda()) {
            $ta = date('Y');
            $bl = date('m');  // arig
            $sess_data = array(
                'pad_tahun_anggaran' => $ta,
                'pad_bulan_anggaran' => $bl,

                'pad_propinsi_id' => $row->propinsi_id,
                'pad_kabupaten_id' => $row->kabupaten_id,

                'pad_pemda_daerah' => $row->daerah,
                'pad_pemda_alamat' => $row->alamat,
                'pad_pemda_alamat_lengkap' => $row->alamat_lengkap,
                'pad_pemda_telp' => $row->telp,
                'pad_pemda_fax' => $row->fax,
                'pad_pemda_website' => $row->website,
                'pad_pemda_email' => $row->email,
                'pad_pemda_nama' => $row->pemdanm,
                'pad_pemda_singkatan' => $row->pemdanmskt,
                'pad_pemda_type' => $row->type,
                'pad_pemda_kepala' => $row->kepalanm,
                'pad_pemda_jabatan' => $row->jabatan,
                'pad_pemda_ibukota' => $row->ibukota,
                'pad_pemda_unitid' => $row->ppkd_id, // ini hrusnya id pemda ato ppkd yah? // ini link ke spt (unit_id), *seharusnya jg sama buat lookup persen bunga di penerimaan..

                'pad_hotel_id' => $row->hotel_id,
                'pad_restoran_id' => $row->restoran_id,
                'pad_hiburan_id' => $row->hiburan_id,
                'pad_reklame_id' => $row->reklame_id,
                'pad_air_tanah_id' => $row->airtanah_id,
                'pad_parkir_id' => $row->parkir_id,
                'pad_ppj_id' => $row->ppj_id,
                'pad_mineral_id' => $row->mineral_id,
                'pad_menara_id' => $row->menara_id,

                'pad_dok_self_id' => $row->self_dok_id,
                'pad_dok_office_id' => $row->office_dok_id,

                'pad_spt_date' => $row->tgl_spt,
                'pad_spt_due_date' => $row->tgl_jatuhtempo_self,

                'pad_spt_denda' => $row->spt_denda,
                'pad_bunga' => $row->pad_bunga,
            );
            $this->session->set_userdata($sess_data);
        }
        */

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
        $this->apps_model->create_modules_menu($app_id, 'MENU_REFERENSI', 'Menu Referensi');
        $this->apps_model->create_modules_menu($app_id, 'MENU_PENETAPAN', 'Menu Penetapan');
        $this->apps_model->create_modules_menu($app_id, 'MENU_PENERIMAAN', 'Menu Penerimaan');
        $this->apps_model->create_modules_menu($app_id, 'MENU_PENAGIHAN', 'Menu Penagihan');
        $this->apps_model->create_modules_menu($app_id, 'MENU_DAFTAR_NOP', 'Menu Daftar NOP');
        $this->apps_model->create_modules_menu($app_id, 'MENU_REG_ESPPT', 'Menu Registrasi ESPPT');
        $this->apps_model->create_modules_menu($app_id, 'MENU_PRM_ONLINE', 'Menu Permohonan Online');
        $this->apps_model->create_modules_menu($app_id, 'MENU_SPPT_BSRE', 'Menu Approve SPPT Bsre');
        $this->apps_model->create_modules_menu($app_id, 'MENU_NOP_PROGRESSIVE', 'Menu Nop Progressive');
        $this->apps_model->create_modules_menu($app_id, 'MENU_KIRIM_SPPT', 'Menu Kirim SPPT');
        $this->apps_model->create_modules_menu($app_id, 'MENU_UPDATE_REG', 'Menu Update Registrasi');
        $this->apps_model->create_modules_menu($app_id, 'MENU_LAP_PENGURANGAN_STIMULUS', 'Menu Laporan Pengurangan Stimulus');
    }

    public function create_menus_sub()
    {

        //log_message('info', "BBBBBBBBBB CREATE MODULE : " );
        $app_id = sipkd_app_id();
        // Menu Sub
        //$this->apps_model->create_modules_menu_sub($app_id,'m01_tes','Sub Menu Ref. TES','MENU_TES');
    }

    public function create_menus_tran()
    {

        //log_message('info', "BBBBBBBBBB CREATE MODULE : " );
        $app_id = sipkd_app_id();
        //$this->apps_model->create_modules($app_id,'dashboard','DASHBOARD');
        $this->apps_model->create_modules($app_id, 'menu_kecamatan', 'Referensi Kecamatan', 'MENU_REFERENSI');
        $this->apps_model->create_modules($app_id, 'menu_kelurahan', 'Referensi Kelurahan', 'MENU_REFERENSI');
        $this->apps_model->create_modules($app_id, 'menu_lampiran_pelayanan', 'Referensi Lampiran Pelayanan', 'MENU_REFERENSI');
        $this->apps_model->create_modules($app_id, 'nop_prog', 'Nop Progressive', 'MENU_NOP_PROGRESSIVE');

        $this->apps_model->create_modules($app_id, 'daftar_nop', 'Daftar NOP', 'MENU_DAFTAR_NOP');
        $this->apps_model->create_modules($app_id, 'reg_esppt', 'Registrasi ESPPT', 'MENU_REG_ESPPT');
        $this->apps_model->create_modules($app_id, 'permohonan_online', 'Permohonan Online', 'MENU_PRM_ONLINE');
        $this->apps_model->create_modules($app_id, 'sppt_bsre', 'Approve BSRE', 'MENU_SPPT_BSRE');

        $this->apps_model->create_modules($app_id, 'kirim_sppt', 'Kirim SPPT', 'MENU_KIRIM_SPPT');
        $this->apps_model->create_modules($app_id, 'update_reg', 'Update Registrasi', 'MENU_UPDATE_REG');
        $this->apps_model->create_modules($app_id, 'lap_pengurangan_stimulus', 'Laporan Pengurangan Stimulus', 'MENU_LAP_PENGURANGAN_STIMULUS');
        /*
        $this->apps_model->create_modules($app_id,'menu_pejabat','Referensi Pejabat','MENU_REFERENSI');
        $this->apps_model->create_modules($app_id,'menu_rekening','Referensi Rekening','MENU_REFERENSI');
        $this->apps_model->create_modules($app_id,'menu_jenis_pajak','Referensi Jenis Pajak','MENU_REFERENSI');
        $this->apps_model->create_modules($app_id,'menu_jenis_usaha','Referensi Jenis Usaha','MENU_REFERENSI');
        $this->apps_model->create_modules($app_id,'menu_sarana_ret_tarif','Referensi Sarana Retribusi dan Tarif','MENU_REFERENSI');
        $this->apps_model->create_modules($app_id,'menu_parameter','Parameter Retribusi','MENU_REFERENSI');
        $this->apps_model->create_modules($app_id,'menu_anggaran','Referensi Anggaran','MENU_REFERENSI');
        $this->apps_model->create_modules($app_id,'menu_tarif_fasilitas','Tarif Fasilitas Pasar','MENU_REFERENSI');
        */
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
