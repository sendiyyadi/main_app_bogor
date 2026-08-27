<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class salinan_stts extends CI_Controller
{

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

        $module = 'salinan_stts';
        $this->load->library('module_auth', array('module' => $module));

        $this->load->helper('app_helper');
        $this->load->model(array('apps_model', 'login_model', 'payment_model'));

        if ($grp = $this->login_model->check_user_app()) {
            $this->session->set_userdata('groupid', $grp->GROUP_ID);
            $this->session->set_userdata('groupkd', $grp->GROUP_KODE);
            $this->session->set_userdata('groupname', htmlspecialchars($grp->GROUP_NAMA));
        }
    }

    public function index()
    {

        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect('pospbb_ora');
        }

        $data['page_menu'] = 'm02_mn_stts';
        $data['current']   = 'salinan_stts'; // stts

        $filter = $this->session->userdata('pos_filter');
        $filter = isset($filter) ? $filter : '';
        $data['filter']  = $filter;
        $data['tpnm'] = isset($this->session->userdata['tpnm']) ? $this->session->userdata['tpnm'] : '';

        $data['apps']    = $this->apps_model->get_active_only();
        //$data['current'] = 'stts';

        $this->load->view('salinan_stts/vsalinan_stts', $data);
    }

    public function cari()
    {

        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect('pospbb_ora');
        }

        $nop = $this->uri->segment(4);
        $thn = $this->uri->segment(5);
        $ke  = $this->uri->segment(6);

        if ($nop && $thn && $ke && $query = $this->payment_model->get_by_nop_thn_ke($nop, $thn, $ke)) {

            if (is_super_admin() || $query->NIP_REKAM_BYR_SPPT == $this->session->userdata('userid')) {

                $terbilang = terbilang($query->JML_SPPT_YG_DIBAYAR);
                $query =  (object) array_merge((array)$query, array('found' => 1, 'terbilang' => $terbilang));
                echo json_encode($query);
                exit;
            }
        }

        $result['found'] = 0;
        echo json_encode($result);
    }

    public function cetak_draft()
    {

        $nop = $this->uri->segment(4);
        $thn = $this->uri->segment(5);
        $ke  = $this->uri->segment(6);

        $this->load->model(array('payment_model'));

        if ($nop && $thn && $query = $this->payment_model->get_by_nop_thn_ke($nop, $thn, $ke)) {
            $this->load->view(STTS1, $query);
        }
    }

    public function  cetak_bank_draft()
    {

        $nop = $this->uri->segment(4);
        $thn = $this->uri->segment(5);
        $ke  = $this->uri->segment(6);
        $this->load->model(array('payment_model'));
        if ($nop && $thn && $query = $this->payment_model->get_by_nop_thn_ke($nop, $thn, $ke)) {
            $this->load->view(STTS3, $query);
        }
    }

    public function  cetak_pdf()
    {
        $nop = $this->uri->segment(4);
        $thn = $this->uri->segment(5);
        $ke  = $this->uri->segment(6);

        $this->load->model(array('payment_model'));
        if ($nop && $thn && $query = $this->payment_model->get_by_nop_thn_ke($nop, $thn, $ke)) {
            $kdprop = '';
            $kddati = '';
            $kdkec = '';
            $kdkel = '';
            $kdblok = '';
            $nourut = '';
            $jns = '';
            $join = '';
            $nop_num = preg_replace("/[^0-9]/", "", $nop);
            $nop_dot = preg_replace("/([0-9]{2})([0-9]{2})([0-9]{3})([0-9]{3})([0-9]{3})([0-9]{4})([0-9]{1})/", "$1.$2.$3.$4.$5.$6.$7", $nop_num);

            $kode = explode(".", $nop_dot);
            list($kdprop, $kddati, $kdkec, $kdkel, $kdblok, $nourut, $jns) = $kode;

            //tambahan parameter join untuk relasi tabel pembayaran sppt dgn tempat pembayaran 
            if (DEF_POS_TYPE == 1) {
                $join = " ps.kd_kanwil=tp.kd_kanwil AND ps.kd_kantor=tp.kd_kantor AND ps.kd_tp=tp.kd_tp ";
            } elseif (DEF_POS_TYPE == 2) {
                $join = " ps.kd_kanwil=tp.kd_kanwil AND ps.kd_kantor=tp.kd_kantor AND ps.kd_bank_tunggal=tp.kd_bank_tunggal AND ps.kd_bank_persepsi=tp.kd_bank_persepsi AND  ps.kd_tp=tp.kd_tp ";
            }

            //versi report pertama ngirim SN - versi selanjutnya ga perlu
            $sn = date('dmY', strtotime($query->tgl_pembayaran_sppt));
            $sn .= $kdprop . $kddati . $kdkec . $kdkel . $kdblok . $nourut . $jns . $thn;

            $params = array(
                "daerah" => LICENSE_TO,
                "dinas" => LICENSE_TO_SUB,
                "logo" => base_url("assets/img/logorpt__.jpg"),

                "kd_propinsi" => $kdprop,
                "kd_dati2" => $kddati,
                "kd_kecamatan" => $kdkec,
                "kd_kelurahan" => $kdkel,
                "kd_blok" => $kdblok,
                "no_urut" => $nourut,
                "kd_jns_op" => $jns,
                "thn_pajak_sppt" => $thn,
                "pembayaran_sppt_ke" => $ke,
                "sn" => $sn,
                "join" => $join,
            );

            $jasper = $this->load->library('Jasper');
            echo $jasper->cetak(POS_WIL . "/stts", $params, "pdf", false);
        }
    }
    public function cetak_bank()
    {
        $nop = $this->uri->segment(4);
        $thn = $this->uri->segment(5);
        $ke  = $this->uri->segment(6);

        $this->load->model(array(
            'payment_model'
        ));
        if ($nop && $thn && $query = $this->payment_model->get_by_nop_thn_ke($nop, $thn, $ke)) {
            $kdprop  = '';
            $kddati  = '';
            $kdkec   = '';
            $kdkel   = '';
            $kdblok  = '';
            $nourut  = '';
            $jns     = '';
            $join    = '';
            $nop_num = preg_replace("/[^0-9]/", "", $nop);
            $nop_dot = preg_replace("/([0-9]{2})([0-9]{2})([0-9]{3})([0-9]{3})([0-9]{3})([0-9]{4})([0-9]{1})/", "$1.$2.$3.$4.$5.$6.$7", $nop_num);

            $kode = explode(".", $nop_dot);
            list($kdprop, $kddati, $kdkec, $kdkel, $kdblok, $nourut, $jns) = $kode;

            //tambahan parameter join untuk relasi tabel pembayaran sppt dgn tempat pembayaran
            if (DEF_POS_TYPE == 1) {
                $join = " ps.kd_kanwil=tp.kd_kanwil AND ps.kd_kantor=tp.kd_kantor AND ps.kd_tp=tp.kd_tp ";
            } elseif (DEF_POS_TYPE == 2) {
                $join = " ps.kd_kanwil=tp.kd_kanwil AND ps.kd_kantor=tp.kd_kantor AND ps.kd_bank_tunggal=tp.kd_bank_tunggal AND ps.kd_bank_persepsi=tp.kd_bank_persepsi AND  ps.kd_tp=tp.kd_tp ";
            }

            $sn = date('dmY', strtotime($query->TGL_PEMBAYARAN_SPPT));
            $sn .= $kdprop . $kddati . $kdkec . $kdkel . $kdblok . $nourut . $jns . $thn;

            //tambahan terbilang
            $terbilang = terbilang($query->JML_SPPT_YG_DIBAYAR);

            $params = array(
                "daerah" => LICENSE_TO,
                "dinas" => LICENSE_TO_SUB,
                "logo" => base_url("assets/img/logorpt__.jpg"),

                "kd_propinsi" => $kdprop,
                "kd_dati2" => $kddati,
                "kd_kecamatan" => $kdkec,
                "kd_kelurahan" => $kdkel,
                "kd_blok" => $kdblok,
                "no_urut" => $nourut,
                "kd_jns_op" => $jns,
                "thn_pajak_sppt" => $thn,
                "pembayaran_sppt_ke" => $ke,
                "sn" => $sn,
                "join" => $join,
                "terbilang" => $terbilang,
            );

            $jasper = $this->load->library('Jasper');
            echo $jasper->cetak(POS_WIL . "/stts_bank", $params, "pdf", false);
        }
    }
}
