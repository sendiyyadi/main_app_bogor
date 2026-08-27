<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class lap_trima_harian extends CI_Controller
{

    private $module = 'lap_trima_harian';

    function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('login')) {
            $this->session->set_flashdata('msg_warning', 'Session telah kadaluarsa, silahkan login ulang.');
            redirect('login');
            exit;
        }

        if (!is_super_admin() && !isset($this->session->userdata['tpnm'])) {
            show_404();
            exit;
        }

        //$module = 'lap_trima_harian';
        $this->load->library('module_auth', array('module' => $this->module));

        $this->load->model(array('apps_model', 'tp_bayar_model', 'rpt_model', 'pos_user_model'));
    }

    public function index()
    {

        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect('pospbb_ora');
        }

        $data['page_menu'] = 'm04_mn_laporan';
        $data['current']   = $this->module;
        $data['apps']      = $this->apps_model->get_active_only();

        $data['faction'] = active_module_url('lap_trima_harian/harian');
        $data['tpnm']    = isset($this->session->userdata['tpnm']) ? $this->session->userdata['tpnm'] : '';
        //$data['users']   =  $this->pos_user_model->get_tp_user();
        //print_r($data['users']);
        // $this->fvalidation();
        //-----------------------------------------------------------------------
        $buku = '11';
        $options = $this->load->model('pospbb_ora_model')->get_select_book();
        //
        $js = 'id="buku_id" name="buku_id" class="input form-control select2" ';
        $data['select_buku'] = form_dropdown('buku_id', $options, $buku, $js);
        //-----------------------------------------------------------------------
        $options = array(
            '1' => 'Nama Wajib Pajak',
            '2' => 'NOP',
            '3' => 'Tahun',
            '4' => 'Jumlah Pembayaran'
        );
        $js = 'id="urut_id" name="urut_id" class="input form-control select2" required ';
        $data['select_urut'] = form_dropdown('urut_id', $options, '1', $js);
        //-----------------------------------------------------------------------
        $select_data = $this->pos_user_model->get_select_tp_users();
        $options = array();
        if ($select_data) {
            if (count($select_data) > 1) {
                $options['0'] = 'SELURUH USER';
            }
            foreach ($select_data as $row) {
                $options[$row->ID] = $row->NAMA;
            }
        } else {
            $options['9999777'] = 'USER TDK ADA HAK';
        }
        //
        $js = 'id="user_id" name="user_id" class="input form-control select2" ';
        $data['select_tp_users'] = form_dropdown('user_id', $options, '0', $js);
        //-----------------------------------------------------------------------
        //if(empty($kec_kd){ $kel_kd = '000'; }
        $select_data = $this->load->model('ref_kelurahan_model')->get_select_nm_kel_all();
        $options = array();
        //
        $kd_kec = get_user_kec_kd();
        $kd_kel = get_user_kel_kd();
        if ($kd_kec == '000' && $kd_kel == '000') {
            $options['000.000'] = '000.000 SELURUH KELURAHAN';
        }
        foreach ($select_data as $row) {
            $options[$row->KD_KECAMATAN . '.' . $row->KD_KELURAHAN] = $row->KD_KECAMATAN . '.' . $row->KD_KELURAHAN . '-' . $row->NM_KELURAHAN;
        }
        $js = 'id="kel_id" name="kel_id" class="input form-control select2" ';
        $data['select_kelurahan'] = form_dropdown('kel_id', $options, 0, $js);
        //-----------------------------------------------------------------------        
        $this->load->view('lap_trima_harian/vlap_trima_harian', $data);
    }

    private function fvalidation()
    {
        $this->form_validation->set_error_delimiters('<span>', '</span>');
        $this->form_validation->set_rules('tgl', 'Tanggal', 'required');
        $this->form_validation->set_rules('buku', 'Jenis Buku', 'required');
        $this->form_validation->set_rules('buku', 'Jenis Buku', 'required');
    }

    public function harian()
    {
        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect('pospbb_ora');
        }
        //$this->fvalidation();
        $tgl     = $_POST['tgl'];
        $buku_id = $_POST['buku_id'];
        $urut_id = $_POST['urut_id'];
        $kel_id  = $_POST['kel_id'];
        $user_id = $_POST['user_id'];
        //$tgl     = date('Y-m-d', strtotime($tgl));
        //        
        if (isset($tgl)) {
            if ($tgl != '') {
                $tgl = date('Y-m-d', strtotime($tgl));
            }
        }
        if ($tgl == '') {
            $tgl = date('Y-m-d');
        }
        //
        $data['tanggal'] = date('d-m-Y', strtotime($tgl));
        $data['kel_nm']  = $this->load->model('ref_kelurahan_model')->get_nm_kel_by_kec($kel_id);
        $data['buku_nm'] = buku_name($buku_id);
        //$data['bank_nm'] = isset($this->session->userdata['tpnm']) ? $this->session->userdata['tpnm'] : 'TP Tidak Valid';

        if (!empty($user_id)) {
            $row = $this->load->model('user_pbb_model')->get_users_by_id($user_id);
            $data['bank_nm'] = $row->NM_TP;
            $data['user_nm'] = $row->NAMA;;
        } else {
            $data['bank_nm'] = 'SEMUA TEMPAT PEMBAYARAN';
            $data['user_nm'] = 'SELURUH USER';
        }
        //  
        $rpt_dt = $this->rpt_model->get_lap_harian($tgl, $buku_id, $urut_id, $kel_id, $user_id);
        //
        //var_dump($rpt_dt);die;
        $data['rows'] = $rpt_dt;
        $this->load->view('lap_trima_harian/vrpt_lap_harian', $data);
    }

    public function  cetak_pdf()
    {

        $tgl  = $_GET['tgl'];
        $buku = $_GET['buku'];
        $urut = $_GET['urut'];
        $kel  = $_GET['kel'];

        $b_awal  = buku_bawah($buku);
        $b_akhir = buku_atas($buku);

        //tambahan parameter join untuk relasi tabel pembayaran sppt dgn tempat pembayaran 
        $join = '';
        if (DEF_POS_TYPE == 1) {
            $join = " AND a.kd_kanwil=tp.kd_kanwil AND a.kd_kantor=tp.kd_kantor AND a.kd_tp=tp.kd_tp 
				AND tp.nm_tp= '" . $this->session->userdata['tpnm'] . "' ";
        } elseif (DEF_POS_TYPE == 2) {
            $join = " AND a.kd_kanwil=tp.kd_kanwil AND a.kd_kantor=tp.kd_kantor AND a.kd_bank_tunggal=tp.kd_bank_tunggal AND a.kd_bank_persepsi=tp.kd_bank_persepsi AND  a.kd_tp=tp.kd_tp 
				AND tp.nm_tp= '" . $this->session->userdata['tpnm'] . "' ";
        }

        $where = '';
        $kel = substr($kel, 0, 7);
        if ($kel != '000.000') {
            $where .= " and a.kd_kecamatan='" . substr($kel, 0, 3) . "' and a.kd_kelurahan='" . substr($kel, -3) . "' ";
        }

        $uid = $_GET['user'];

        if ($uid != '') {
            $where .= " and a.user_id=" . $uid;
        }

        $order = "";
        if ($urut == 1)
            $order = " order by  b.nm_wp_sppt";
        elseif ($urut == 2)
            $order = " order by  a.kd_propinsi, a.kd_dati2, a.kd_kecamatan, a.kd_kelurahan, a.kd_blok, a.no_urut, a.kd_jns_op";
        else if ($urut == 3)
            $order = " order by  a.thn_pajak_sppt";
        else
            $order = " order by  a.jml_sppt_yg_dibayar";


        $params = array(
            "daerah" => LICENSE_TO,
            "dinas" => LICENSE_TO_SUB,
            "logo" => base_url("assets/img/logorpt__.jpg"),

            "kd_propinsi" => KD_PROPINSI,
            "kd_dati2" => KD_DATI2,

            "tanggal" => date('Y-m-d', strtotime($tgl)),
            "bukumin" => $b_awal,
            "bukumax" => $b_akhir,
            "buku"    => $buku,
            "join"    => $join,
            "kondisi" => $where . $order,
        );

        $jasper = $this->load->library('Jasper');
        echo $jasper->cetak("harian", $params, "pdf", false);
    }

    public function csv_download()
    {

        $tgl     = $_POST['tgl'];
        $buku_id = $_POST['buku_id'];
        $urut_id = $_POST['urut_id'];
        $kel_id  = $_POST['kel_id'];
        $user_id = $_POST['user_id'];
        //$tgl     = date('Y-m-d', strtotime($tgl));
        //        
        if (isset($tgl)) {
            if ($tgl != '') {
                $tgl = date('Y-m-d', strtotime($tgl));
            }
        }
        if ($tgl == '') {
            $tgl = date('Y-m-d');
        }
        //
        $tanggal = date('d-m-Y', strtotime($tgl));
        $kel_nm  = $this->load->model('ref_kelurahan_model')->get_nm_kel_by_kec($kel_id);
        $buku_nm = buku_name($buku_id);
        //$data['bank_nm'] = isset($this->session->userdata['tpnm']) ? $this->session->userdata['tpnm'] : 'TP Tidak Valid';

        if (!empty($user_id)) {
            $row = $this->load->model('user_pbb_model')->get_users_by_id($user_id);
            $data['bank_nm'] = $row->NM_TP;
            $data['user_nm'] = $row->NAMA;;
        } else {
            $data['bank_nm'] = 'SEMUA TEMPAT PEMBAYARAN';
            $data['user_nm'] = 'SELURUH USER';
        }
        //  
        header("Content-type: text/plain");
        header("Cache-Control: no-store, no-cache");
        header('Content-Disposition: attachment; filename="Laporan Harian ' . $tanggal . ' ' . $kel_nm . ' - Buku ' . $buku_nm . '.csv"');

        if ($rows = $this->rpt_model->get_lap_harian_csv($tgl, $buku_id, $urut_id, $kel_id, $user_id)) {

            $title = array('JAM', 'NOP', 'THN', 'NAMA WP', 'PBB', 'DENDA', 'TOTAL', 'USER', 'TGL.BAYAR');
            $this->csv_encode($rows, $title);
        } else {
            echo "Tidak ada data";
        }
        exit;
    }

    function csv_encode($aaData, $aHeaders = NULL)
    {
        // output headers
        if ($aHeaders) echo implode('|', $aHeaders) . "\r\n";

        foreach ($aaData as $aRow) {
            echo implode('|', $aRow) . "\r\n";
        }
    }
}
