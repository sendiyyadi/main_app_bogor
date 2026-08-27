<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class sts_bayar_op extends CI_Controller
{
    private $module = 'sts_bayar_op';

    function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('login')) {
            $this->session->set_flashdata('msg_warning', 'Session telah kadaluarsa, silahkan login ulang.');
            redirect('login');
            exit;
        }

        if (active_module() != 'pospbb_ora') {
            show_404();
            exit;
        }

        //$module = 'sts_bayar_op';
        $this->load->library('module_auth', array('module' => $this->module));

        $this->load->model(array('apps_model', 'login_model', 'pos_user_model', 'pospbb_ora_model'));

        if ($grp = $this->login_model->check_user_app()) {
            $this->session->set_userdata('groupid', $grp->GROUP_ID);
            $this->session->set_userdata('groupkd', $grp->GROUP_KODE);
            $this->session->set_userdata('groupname', htmlspecialchars($grp->GROUP_NAMA));
        }

        if (!$this->pos_user_model->set_user())
            $this->session->set_flashdata('msg_warning', 'Area Pembayaran Tidak Valid');

        //ngakalin user-pbbms link     
        $this->session->set_userdata('user_area', '0000000000');
    }

    public function index()
    {

        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect("pospbb_ora");
        }

        $data['page_menu'] = 'm02_mn_stts';
        $data['current']   = $this->module;

        $data['iDisplayLength'] = (isset($_GET['iDisplayLength']) && is_numeric($_GET['iDisplayLength'])) ? $_GET['iDisplayLength'] : 15;
        $data['iDisplayStart']  = (isset($_GET['iDisplayStart']) && is_numeric($_GET['iDisplayStart'])) ? $_GET['iDisplayStart'] : 0;
        $data['iSortCol_0']     = (isset($_GET['iSortCol_0']) && is_numeric($_GET['iSortCol_0'])) ? $_GET['iSortCol_0'] : 0;
        $data['iSortingCols']   = (isset($_GET['iSortingCols']) && is_numeric($_GET['iSortingCols'])) ? $_GET['iSortingCols'] : 1;
        $data['sEcho']          = (isset($_GET['sEcho']) && is_numeric($_GET['sEcho'])) ? $_GET['sEcho'] : 1;
        $data['sSearch']        = (isset($_GET['sSearch'])) ? $_GET['sSearch'] : "";
        $data['sSearch_0']      = (isset($_GET['sSearch_0'])) ? $_GET['sSearch_0'] : "";
        $data['sSearch_1']      = (isset($_GET['sSearch_1'])) ? $_GET['sSearch_1'] : "";
        $data['sSearch_2']      = (isset($_GET['sSearch_2'])) ? $_GET['sSearch_2'] : "";
        $data['sSearch_3']      = (isset($_GET['sSearch_3'])) ? $_GET['sSearch_3'] : "";
        $data['sSearch_4']      = (isset($_GET['sSearch_4'])) ? $_GET['sSearch_4'] : "";
        $data['sSortDir_0']     = (isset($_GET['sSortDir_0'])) ? $_GET['sSortDir_0'] : "asc";

        $data['user_kec_kd'] = get_user_kec_kd();
        $data['user_kel_kd'] = get_user_kel_kd();

        $tahun             = (isset($_GET['tahun']) ? $_GET['tahun'] : date('Y'));
        $data['pagetitle'] = 'PosPbbBogor';
        $data['title']     = 'PBB Dashboard';

        $data['SEC_content'] = '';

        /* Mencari Kode NOP */
        if (isset($_POST['nop_kd'])) {
            $nop_kd = $_POST['nop_kd'];
        } else if (isset($_GET['nop_kd'])) {
            $nop_kd = $_GET['nop_kd'];
        } else {
            $nop_kd = 0;
        }

        // log_message('info', "FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF nop_kd : " . $nop_kd );
        $data['tahun']   = $tahun;
        $data['nop_kd']  = $nop_kd;
        /* Explode NOP untuk mendapatkan Kode Blok, No Urut, dan Kode Jenis Objek Pajak */
        $kec_kd          = 0;
        $kel_kd          = 0;
        $blok_kd         = 0;
        $urut_no         = 0;
        $jns_kd          = 0;
        $nop             = str_replace('.', '', $nop_kd);
        $nop             = str_replace('-', '', $nop);

        $data_source = array();
        if ($nop_kd != 0 && strlen($nop) == 18 && $nop_kd != '') {
            $prop_kd = substr($nop, 0, 2);
            $kab_kd  = substr($nop, 2, 2);
            $kec_kd  = substr($nop, 4, 3);
            $kel_kd  = substr($nop, 7, 3);
            $blok_kd = substr($nop, 10, 3);
            $urut_no = substr($nop, 13, 4);
            $jns_kd  = substr($nop, 17, 1);

            ## Set data ##
            /*
            $this->pospbb_ora_model->setTahun($tahun);
            $this->pospbb_ora_model->setKodeKecamatan($kec_kd);
            $this->pospbb_ora_model->setKodeKelurahan($kel_kd);
            $this->pospbb_ora_model->setKodeBlok($blok_kd);
            $this->pospbb_ora_model->setNoUrut($urut_no);
            $this->pospbb_ora_model->setKodeJenisOP($jns_kd);
            */
            $data_source    = $this->pospbb_ora_model->informasi_objek_pajak($nop_kd);
            //
        }
        //
        $data['data_source'] = $data_source;

        $data['tpnm'] = isset($this->session->userdata['tpnm']) ? $this->session->userdata['tpnm'] : '';
        $data['s']    = 'stts';
        $data['apps'] = $this->apps_model->get_active_only();
        $this->load->view('sts_bayar_op/vsts_bayar_op', $data);
    }

    function show_rpt()
    {

        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect("pospbb_ora");
        }

        $cls_mtd_html = $this->router->fetch_class() . "/cetak/html/";
        $cls_mtd_pdf  = $this->router->fetch_class() . "/cetak/pdf/";
        $data['rpt_html'] = active_module_url($cls_mtd_html . $_SERVER['QUERY_STRING']);;
        $data['rpt_pdf']  = active_module_url($cls_mtd_pdf . $_SERVER['QUERY_STRING']);;
        $this->load->view('vjasper_viewer', $data);
    }

    function cetak()
    {

        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect("pospbb_ora");
        }

        $type  = $this->uri->segment(4);
        $rptx  = 'sts_bayar_op';
        $nopkd = $this->uri->segment(5);

        $nop   = str_replace('.', '', $nopkd);
        $nop   = str_replace('-', '', $nop);

        $kec_kd  = substr($nop, 4, 3);
        $kel_kd  = substr($nop, 7, 3);
        $blok_kd = substr($nop, 10, 3);
        $urut_no = substr($nop, 13, 4);
        $jns_kd  = substr($nop, 17, 1);

        $jasper = $this->load->library('Jasper_Ora');
        $params = array(
            "daerah" => LICENSE_TO,
            "kd_propinsi" => KD_PROPINSI,
            "kd_dati2" => KD_DATI2,
            "kd_kecamatan" => $kec_kd,
            "kd_kelurahan" => $kel_kd,
            "kd_blok" => $blok_kd,
            "no_urut" => $urut_no,
            "kd_jns_op" => $jns_kd,
            "logo" => base_url("assets/img/logorpt__.jpg"),
            "dinas" => LICENSE_TO_SUB,
        );
        echo $jasper->cetak_ora($rptx, $params, $type, false);
    }
}
