<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class pst_keberatan extends CI_Controller
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

        $module = 'pst_keberatan';
        $this->load->library('module_auth', array('module' => $module));

        $this->load->helper('app_helper');
        $this->load->model(array('apps_model', 'login_model', 'pst_sppt_keberatan_model'));

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

        $data['page_menu'] = 'm01_mn_pemby_khusus';
        $data['current']   = 'pst_keberatan';

        $filter         = $this->session->userdata('pos_filter');
        $filter         = isset($filter) ? $filter : '';
        $data['filter'] = $filter;
        $data['prefix'] = KD_PROPINSI . "." . KD_DATI2;
        $data['tpnm']   = isset($this->session->userdata['tpnm']) ? $this->session->userdata['tpnm'] : '';

        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = active_module_url('pst_keberatan/update_pmd');
        //$data['current'] = 'pst_pembayaran_khusus';

        $this->load->view('pst_keberatan/vpst_keberatan', $data);
    }

    public function cari()
    {
        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect('pospbb_ora');
        }

        $nop = $this->uri->segment(4);
        $thn = $this->uri->segment(5);
        $thn_p = $this->uri->segment(6);
        $bundel_p = $this->uri->segment(7);
        $urut_p = $this->uri->segment(8);

        if ($nop && $thn && $query = $this->pst_sppt_keberatan_model->get_by_nop_thn_plyn($nop, $thn, $thn_p, $bundel_p, $urut_p)) {
            //
            $sisa  = (float) $query->PBB_YG_HARUS_DIBAYAR_SPPT - ($query->JML_SPPT_YG_DIBAYAR - (float) $query->DENDA_SPPT);

            $denda  = 0;
            $jtempo = date('Y-m-d', strtotime($query->TGL_JATUH_TEMPO_SPPT));
            //$jt = $query->TGL_JATUH_TEMPO_SPPT;

            if ($jtempo && $jtempo < date('Y-m-d')) {

                $denda = hitdenda($sisa, $jtempo);
            }

            $utang = (float) $query->NILAI_ATAS_WP;
            $keberatan = $sisa + $denda - $utang;
            $terbilang = terbilang($utang);

            //$terbilang = terbilang($keberatan);
            $query     = (object) array_merge((array) $query, array(
                'found' => 1,
                'sisa' => $sisa,
                'denda' => $denda,
                'keberatan'    => $keberatan,
                'utang' => $utang,
                'terbilang' => $terbilang
            ));

            echo json_encode($query);
        } else {
            $result['found'] = 0;
            echo json_encode($result);
        }
    }

    private function fvalidation()
    {
        $this->form_validation->set_error_delimiters('<span>', '</span>');
        $this->form_validation->set_rules('nop', 'NOP', 'required');
        $this->form_validation->set_rules('tahun', 'Tahun', 'required|numeric');
    }

    function update_pmd()
    {
        if (!$this->module_auth->create) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_insert);
            redirect('info');
        }

        $data['page_menu'] = 'm01_mn_pemby_khusus';
        $data['current']   = 'pst_keberatan';
        $data['faction'] = active_module_url('pst_keberatan/update_pmd');

        $this->fvalidation();

        if ($this->form_validation->run() == TRUE) {

            $nop  = trim($this->input->post('prefix')) . trim($this->input->post('nop'));
            $nop1 = urldecode($nop);
            $nop  = preg_replace('/[^0-9]/', '', $nop1);
            $thn  = $this->input->post('tahun');

            $thn_p    = $this->input->post('thn_pelayanan');
            $bundel_p = $this->input->post('bundel_pelayanan');
            $urut_p   = $this->input->post('no_urut_pelayanan');
            $id_p     = $this->input->post('id_p');

            $kd_propinsi    = substr($nop, 0, 2);
            $kd_dati2       = substr($nop, 2, 2);
            $kd_kecamatan   = substr($nop, 4, 3);
            $kd_kelurahan   = substr($nop, 7, 3);
            $kd_blok        = substr($nop, 10, 3);
            $no_urut        = substr($nop, 13, 4);
            $kd_jns_op      = substr($nop, -1);
            $thn_pajak_sppt = $thn;

            //$denda_sppt          = (float) preg_replace( '/[^0-9]/', '', $this->input->post('denda'));
            //$jml_sppt_yg_dibayar = (float) preg_replace( '/[^0-9]/', '', $this->input->post('utang'));
            //
            if ($nop && $thn && $query = $this->pst_sppt_keberatan_model->get_by_nop_thn_plyn($nop, $thn, $thn_p, $bundel_p, $urut_p)) {
                //
                $sisa  = (float) $query->PBB_YG_HARUS_DIBAYAR_SPPT - ($query->JML_SPPT_YG_DIBAYAR - (float) $query->DENDA_SPPT);

                $denda  = 0;
                $jtempo = date('Y-m-d', strtotime($query->TGL_JATUH_TEMPO_SPPT));

                if ($jtempo && $jtempo < date('Y-m-d')) {
                    $denda = hitdenda($sisa, $jtempo);
                }

                $utang = (float) $query->NILAI_ATAS_WP;
                $keberatan = $sisa + $denda - $utang;
            } else {
                $data['yes'] = "no";
                echo json_encode($data);
                exit;
            }

            $denda_sppt          = $denda;
            $jml_sppt_yg_dibayar = $utang;

            $tgl_pembayaran_sppt = current_date(); //date('Y-m-d');
            $tgl_rekam_byr_sppt  = current_time(); //date('Y-m-d h:i:sa');
            $nip_rekam_byr_sppt  = $this->session->userdata('nip');

            $pembayaran_sppt_ke  = $this->pst_sppt_keberatan_model->get_keberatan_pemby_ke($nop, $thn);
            $permohonan = $this->pst_sppt_keberatan_model->get_permohonan_keberatan($nop, $thn, $thn_p, $bundel_p, $urut_p);
            //
            $keberatan_dt = array(
                'KD_KANWIL' => $permohonan->KD_KANWIL,
                'KD_KANTOR' => $permohonan->KD_KANTOR,
                'THN_PELAYANAN' => $thn_p,
                'BUNDEL_PELAYANAN' => $bundel_p,
                'NO_URUT_PELAYANAN' => $urut_p,
                'KD_PROPINSI' => $kd_propinsi,
                'KD_DATI2' => $kd_dati2,
                'KD_KECAMATAN' => $kd_kecamatan,
                'KD_KELURAHAN' => $kd_kelurahan,
                'KD_BLOK' => $kd_blok,
                'NO_URUT' => $no_urut,
                'KD_JNS_OP' => $kd_jns_op,
                'THN_PAJAK_SPPT' => $thn_pajak_sppt,
                'NILAI_ATAS_WP' => $permohonan->NILAI_ATAS_WP,
                'TGL_BAYAR' => $tgl_pembayaran_sppt,
                'NILAI_BAYAR' => $jml_sppt_yg_dibayar,
                'USERID_BAYAR' => lda_user_login(),
                'NIP_BAYAR' => $nip_rekam_byr_sppt,
                'STS_BAYAR' => '1',
                'TGL_BATAL' => NULL,
                'USERID_BATAL' => NULL,
                'NIP_BATAL' => NULL,
                'UPDATED_DATE' => $tgl_rekam_byr_sppt,
                //'CREATED_DATE' => $tgl_rekam_byr_sppt,
                'KD_PELAYANAN' => '07',
                'PEMBAYARAN_SPPT_KE' => $pembayaran_sppt_ke,
                'DENDA_SPPT' => $denda_sppt,
                'KD_TP_BAYAR' => $this->session->userdata('kd_tp'),
                'KD_TP_BATAL' => NULL,
                'FLG_STTS' => 0,

                'PBB_TERHUTANG_SPPT' => $permohonan->PBB_TERHUTANG_SPPT,
                'FAKTOR_PENGURANG_SPPT' => $permohonan->FAKTOR_PENGURANG_SPPT,
                'PBB_YG_HARUS_DIBAYAR_SPPT' => $permohonan->PBB_YG_HARUS_DIBAYAR_SPPT,
                'FAKTOR_PENGURANG_BAYAR' => 0,

            );
            //
            $sisa_sppt = $permohonan->NILAI_ATAS_WP;

            $data = array(

                'KD_PROPINSI' => $kd_propinsi,
                'KD_DATI2' => $kd_dati2,
                'KD_KECAMATAN' => $kd_kecamatan,
                'KD_KELURAHAN' => $kd_kelurahan,
                'KD_BLOK' => $kd_blok,
                'NO_URUT' => $no_urut,
                'KD_JNS_OP' => $kd_jns_op,
                'THN_PAJAK_SPPT' => $thn_pajak_sppt,
                'PEMBAYARAN_SPPT_KE' => $pembayaran_sppt_ke,
                'DENDA_SPPT' => $denda_sppt,
                'JML_SPPT_YG_DIBAYAR' => $jml_sppt_yg_dibayar,
                'TGL_PEMBAYARAN_SPPT' => $tgl_pembayaran_sppt,
                'TGL_REKAM_BYR_SPPT' => $tgl_rekam_byr_sppt,
                'NIP_REKAM_BYR_SPPT' => $nip_rekam_byr_sppt,
                //'jns_pelayanan' => 'K'
            );
            //
            if (DEF_POS_TYPE == 1) {
                $data = array_merge($data, array('KD_KANWIL' => $this->session->userdata('kd_kanwil')));
                $data = array_merge($data, array('KD_KANTOR' => $this->session->userdata('kd_kantor')));
                $data = array_merge($data, array('KD_TP' => $this->session->userdata('kd_tp')));
            } else {
                $data = array_merge($data, array('KD_BANK_TUNGGAL' => $this->session->userdata('kd_bank_tunggal')));
                $data = array_merge($data, array('KD_BANK_PERSEPSI' => $this->session->userdata('kd_bank_persepsi')));
                $data = array_merge($data, array('KD_KANWIL' => $this->session->userdata('kd_kanwil')));
                $data = array_merge($data, array('KD_KANTOR' => $this->session->userdata('kd_kantor')));
                $data = array_merge($data, array('KD_TP' => $this->session->userdata('kd_tp')));
            }
            //
            //$resultdb = $this->pst_sppt_keberatan_model->add_pemby_keberatan($data, $id_p);
            $resultdb = $this->pst_sppt_keberatan_model->add_pemby_keberatan($nop, $thn, $sisa_sppt, $data);

            if (empty($resultdb)) {

                $this->pst_sppt_keberatan_model->add_pemby_hist_keberatan($keberatan_dt);
                $data['nop'] = $nop;
                $data['thn'] = $thn;
                $data['ke']  = $pembayaran_sppt_ke;
                $data['yes'] = "yes";
                echo json_encode($data);
            } else {
                $data['yes'] = "no";
                echo json_encode($data);
            }
        } else {
            $data['yes'] = "no";
            echo json_encode($data);
        }
    }

    public function cetak()
    {
        $nop = $this->uri->segment(4);
        $thn = $this->uri->segment(5);
        $ke  = $this->uri->segment(6);
        $this->load->model(array('payment_model'));
        //testing
        // $query = "..";
        // $this->load->view(STTS1, $query);

        if ($nop && $thn && $ke && $query = $this->payment_model->get_by_nop_thn_ke($nop, $thn, $ke)) {
            $this->load->view(STTS1, $query);
        }
    }

    public function cetak_draft()
    {
        $nop = $this->uri->segment(4);
        $thn = $this->uri->segment(5);
        $ke  = $this->uri->segment(6);
        $this->load->model(array('payment_model'));
        if ($nop && $thn && $ke && $query = $this->payment_model->get_by_nop_thn_ke($nop, $thn, $ke)) {
            $this->load->view(STTS3, $query);
        }
    }

    public function cetak_pdf()
    {
        $nop = $this->uri->segment(4);
        $thn = $this->uri->segment(5);
        $ke  = $this->uri->segment(6);

        $this->load->model(array('payment_model'));
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
                "join" => $join
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
