<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class tes_upload_nop extends CI_Controller
{

    private $tgljam = "";

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

        $module = 'tes_upload_nop';
        $this->load->library('module_auth', array('module' => $module));

        $this->load->helper('app_helper');
        $this->load->model(array('apps_model', 'login_model', 'sppt_model', 'payment_model', 'upload_nop_model'));

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
        $data['current']   = 'tes_upload_nop'; // stts

        $filter         = $this->session->userdata('pos_filter');
        $filter         = isset($filter) ? $filter : '';
        $data['filter'] = $filter;
        $data['prefix'] = KD_PROPINSI . "." . KD_DATI2;
        $data['tpnm']   = isset($this->session->userdata['tpnm']) ? $this->session->userdata['tpnm'] : '';

        $this->tgljam   = date("YmdHis");
        $data['tgljam'] = $this->tgljam;

        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = active_module_url('tes_upload_nop/unggah_try/' . $this->tgljam);
        //$data['current'] = 'stts';

        $this->load->view('tes_upload_nop/vtes_upload_nop', $data);
    }

    function simpan()
    {

        if (!$this->module_auth->create) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_insert);
            redirect('pospbb_ora');
        }

        $simpan = $_POST['data'];
        if (isset($simpan)) {

            $data = json_decode($simpan, true);

            if (count($data) > 0) {

                $saved = array();
                $cetak = array();
                foreach ($data as $row) {
                    $nop = $row[0];
                    $thn_pajak_sppt = $row[1];

                    $kd_propinsi  = substr($nop, 0, 2);
                    $kd_dati2     = substr($nop, 2, 2);
                    $kd_kecamatan = substr($nop, 4, 3);
                    $kd_kelurahan = substr($nop, 7, 3);
                    $kd_blok      = substr($nop, 10, 3);
                    $no_urut      = substr($nop, 13, 4);
                    $kd_jns_op    = substr($nop, 17, 1);

                    if ($query = $this->sppt_model->get_by_nop_thn($nop, $thn_pajak_sppt)) {

                        $pbb_yg_harus_dibayar_sppt = (float) $query->PBB_YG_HARUS_DIBAYAR_SPPT;
                        $jml_sppt_yg_dibayar       = $query->JML_SPPT_YG_DIBAYAR;
                        $denda_sppt                =  (float) $query->DENDA_SPPT;

                        $sisa  = $pbb_yg_harus_dibayar_sppt - ($jml_sppt_yg_dibayar - $denda_sppt);
                        $denda = 0;

                        if (date($query->TGL_JATUH_TEMPO_SPPT) < date('Y-m-d')) {
                            $denda = hitdenda($sisa, $query->TGL_JATUH_TEMPO_SPPT);
                        }

                        $utang = $sisa + $denda;

                        $denda_sppt          = $denda;
                        $jml_sppt_yg_dibayar = $utang;

                        $tgl_pembayaran_sppt = current_date(); //date('Y-m-d');
                        $tgl_rekam_byr_sppt  = current_time(); //date('Y-m-d h:i:sa');
                        $nip_rekam_byr_sppt  = $this->session->userdata('nip');

                        $pembayaran_sppt_ke  = $this->payment_model->get_pembayaran_ke($nop, $thn_pajak_sppt);

                        //buat history di pos pst
                        $hist_bayar_dt = array(
                            'KD_KANWIL' => $this->session->userdata('kd_kanwil'),
                            'KD_KANTOR' => $this->session->userdata('kd_kantor'),
                            'KD_TP_BAYAR' => $this->session->userdata('kd_tp'),
                            'KD_PROPINSI' => $kd_propinsi,
                            'KD_DATI2' => $kd_dati2,
                            'KD_KECAMATAN' => $kd_kecamatan,
                            'KD_KELURAHAN' => $kd_kelurahan,
                            'KD_BLOK' => $kd_blok,
                            'NO_URUT' => $no_urut,
                            'KD_JNS_OP' => $kd_jns_op,
                            'THN_PAJAK_SPPT' => $thn_pajak_sppt,
                            'TGL_BAYAR' => $tgl_pembayaran_sppt,
                            'NILAI_BAYAR' => $jml_sppt_yg_dibayar,
                            'USERID_BAYAR' => lda_user_login(),
                            'NIP_BAYAR' => $nip_rekam_byr_sppt,
                            'STS_BAYAR' => '1',
                            'UPDATED_DATE' => $tgl_rekam_byr_sppt,
                            //'CREATED_DATE' => $tgl_rekam_byr_sppt,
                            'KD_PELAYANAN' => '00',
                            'PEMBAYARAN_SPPT_KE' => $pembayaran_sppt_ke,
                            'DENDA_SPPT' => $denda_sppt,
                            'FLG_STTS' => 5,
                        );

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
                        //$resultdb = $this->payment_model->add_bayar_per_nop($data);
                        $sisa_sppt = $jml_sppt_yg_dibayar - $denda_sppt;
                        $resultdb = $this->payment_model->add_bayar_per_nop($nop, $thn_pajak_sppt, $sisa_sppt, $data);

                        if (empty($resultdb)) {
                            //set_msg_db_error($resultdb);
                            $success = "1";
                            $this->payment_model->add_bayar_hist_stts($hist_bayar_dt);
                            /****star****************************************************************/

                            $prints  = array(
                                'nop' => $nop,
                                'thn' => $thn_pajak_sppt,
                                'ke' => $pembayaran_sppt_ke
                            );
                            $saved[] = $prints;

                            //buat cetak
                            //32.10.030.011.000-5327.7 
                            $nopp = $kd_propinsi . "." . $kd_dati2 . "." . $kd_kecamatan . "." . $kd_kelurahan . ".";
                            $nopp .= $kd_blok . "-" . $no_urut . "." . $kd_jns_op;
                            $dctk = array();
                            if ($qctk = $this->payment_model->get_by_nop_thn_ke($nop, $thn_pajak_sppt, $pembayaran_sppt_ke)) {
                                //$dctk = array();
                                $dctk[8] =  $qctk->NM_TP;
                                $dctk[9] =  $qctk->THN_PAJAK_SPPT;
                                $dctk[10] = $qctk->NM_WP_SPPT;
                                $dctk[11] = $qctk->NM_KECAMATAN;
                                $dctk[12] = $qctk->NM_KELURAHAN;
                                $dctk[13] = $nopp; //kode;//x
                                $dctk[14] = $qctk->JML_SPPT_YG_DIBAYAR;
                                $dctk[15] = $qctk->DENDA_SPPT;
                                $dctk[16] = $qctk->TGL_JATUH_TEMPO_SPPT;
                                $dctk[17] = $qctk->TGL_PEMBAYARAN_SPPT;
                                $dctk[18] = $qctk->JML_SPPT_YG_DIBAYAR;
                                $dctk[19] = $qctk->LUAS_BUMI_SPPT;
                                $dctk[20] = $qctk->LUAS_BNG_SPPT;

                                $dctk[40] = $qctk->JLN_WP_SPPT;
                                $dctk[41] = $qctk->BLOK_KAV_NO_WP_SPPT;
                                $dctk[42] = $qctk->NM_PROPINSI;
                                $dctk[43] = $qctk->NM_DATI2;
                            }
                            $cetak[] = $dctk;
                            /****end****************************************************************/
                        } else {

                            $success = "0"; // alias gagal save
                            /****star****************************************************************/
                            $prints  = array(
                                'nop' => $nop,
                                'thn' => $thn_pajak_sppt,
                                'ke' => $pembayaran_sppt_ke
                            );
                            $saved[] = $prints;

                            //buat cetak
                            //32.10.030.011.000-5327.7 
                            $nopp = $kd_propinsi . "." . $kd_dati2 . "." . $kd_kecamatan . "." . $kd_kelurahan . ".";
                            $nopp .= $kd_blok . "-" . $no_urut . "." . $kd_jns_op;

                            $dctk = array();
                            $dctk[8]  = "gagal";
                            $dctk[9]  = $thn_pajak_sppt;
                            $dctk[10] = "ERROR - GAGAL SIMPAN"; //$qctk->NM_WP_SPPT;
                            $dctk[11] = $kd_kecamatan; //$qctk->NM_KECAMATAN;
                            $dctk[12] = $kd_kelurahan; //$qctk->NM_KELURAHAN;
                            $dctk[13] = $nopp; //kode;//x
                            $dctk[14] = $jml_sppt_yg_dibayar; //$qctk->JML_SPPT_YG_DIBAYAR;
                            $dctk[15] = $denda_sppt; //$qctk->DENDA_SPPT;
                            $dctk[16] = "-"; //$qctk->TGL_JATUH_TEMPO_SPPT;
                            $dctk[17] = $tgl_pembayaran_sppt; //$qctk->TGL_PEMBAYARAN_SPPT;
                            $dctk[18] = $jml_sppt_yg_dibayar; //$qctk->JML_SPPT_YG_DIBAYAR;
                            $dctk[19] = "0"; //$qctk->LUAS_BUMI_SPPT;
                            $dctk[20] = "0"; //$qctk->LUAS_BNG_SPPT;
                            $dctk[40] = "-"; //$qctk->JLN_WP_SPPT;
                            $dctk[41] = "-"; //$qctk->BLOK_KAV_NO_WP_SPPT;
                            $dctk[42] = $kd_propinsi; //$qctk->NM_PROPINSI;
                            $dctk[43] = $kd_dati2; //$qctk->NM_DATI2;
                            $cetak[]  = $dctk;

                            /****end****************************************************************/
                        }
                    }
                } //end loop foreach

                $ret           = array();
                $ret['simpan'] = 'sukses';
                $ret['saved']  = $saved;
                $ret['cetak']  = $cetak;
                echo json_encode($ret);
                exit;
            }
        }

        $ret = array();
        $ret['simpan'] = 'gagal';
        echo json_encode($ret);
    }

    function simpan_dev()
    {

        if (!$this->module_auth->create) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_insert);
            redirect('pospbb_ora');
        }

        $simpan = $_POST['data'];
        if (isset($simpan)) {

            $data = json_decode($simpan, true);

            if (count($data) > 0) {

                $saved = array();
                $cetak = array();
                foreach ($data as $row) {
                    $nop = $row[0];
                    $thn_pajak_sppt = $row[1];

                    $kd_propinsi  = substr($nop, 0, 2);
                    $kd_dati2     = substr($nop, 2, 2);
                    $kd_kecamatan = substr($nop, 4, 3);
                    $kd_kelurahan = substr($nop, 7, 3);
                    $kd_blok      = substr($nop, 10, 3);
                    $no_urut      = substr($nop, 13, 4);
                    $kd_jns_op    = substr($nop, 17, 1);

                    if ($query = $this->sppt_model->get_by_nop_thn($nop, $thn_pajak_sppt)) {

                        $pbb_yg_harus_dibayar_sppt = (float) $query->PBB_YG_HARUS_DIBAYAR_SPPT;
                        $jml_sppt_yg_dibayar       = $query->JML_SPPT_YG_DIBAYAR;
                        $denda_sppt                =  (float) $query->DENDA_SPPT;

                        $sisa  = $pbb_yg_harus_dibayar_sppt - ($jml_sppt_yg_dibayar - $denda_sppt);
                        $denda = 0;

                        if (date($query->TGL_JATUH_TEMPO_SPPT) < date('Y-m-d')) {
                            $denda = hitdenda($sisa, $query->TGL_JATUH_TEMPO_SPPT);
                        }

                        $utang = $sisa + $denda;

                        $denda_sppt          = $denda;
                        $jml_sppt_yg_dibayar = $utang;

                        $tgl_pembayaran_sppt = current_date(); //date('Y-m-d');
                        $tgl_rekam_byr_sppt  = current_time(); //date('Y-m-d h:i:sa');
                        $nip_rekam_byr_sppt  = $this->session->userdata('nip');

                        $pembayaran_sppt_ke  = $this->payment_model->get_pembayaran_ke($nop, $thn_pajak_sppt);

                        //buat history di pos pst
                        $hist_bayar_dt = array(
                            'KD_KANWIL' => $this->session->userdata('kd_kanwil'),
                            'KD_KANTOR' => $this->session->userdata('kd_kantor'),
                            'KD_TP_BAYAR' => $this->session->userdata('kd_tp'),
                            'KD_PROPINSI' => $kd_propinsi,
                            'KD_DATI2' => $kd_dati2,
                            'KD_KECAMATAN' => $kd_kecamatan,
                            'KD_KELURAHAN' => $kd_kelurahan,
                            'KD_BLOK' => $kd_blok,
                            'NO_URUT' => $no_urut,
                            'KD_JNS_OP' => $kd_jns_op,
                            'THN_PAJAK_SPPT' => $thn_pajak_sppt,
                            'TGL_BAYAR' => $tgl_pembayaran_sppt,
                            'NILAI_BAYAR' => $jml_sppt_yg_dibayar,
                            'USERID_BAYAR' => lda_user_login(),
                            'NIP_BAYAR' => $nip_rekam_byr_sppt,
                            'STS_BAYAR' => '1',
                            'UPDATED_DATE' => $tgl_rekam_byr_sppt,
                            //'CREATED_DATE' => $tgl_rekam_byr_sppt,
                            'KD_PELAYANAN' => '00',
                            'PEMBAYARAN_SPPT_KE' => $pembayaran_sppt_ke,
                            'DENDA_SPPT' => $denda_sppt,
                            'FLG_STTS' => 5,
                        );

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
                        $resultdb = $this->payment_model->add_bayar_per_nop($data);
                        if (empty($resultdb)) {
                            //set_msg_db_error($resultdb);
                            $success = "1";
                            $this->payment_model->add_bayar_hist_stts($hist_bayar_dt);
                            /****star****************************************************************/

                            $prints  = array(
                                'nop' => $nop,
                                'thn' => $thn_pajak_sppt,
                                'ke' => $pembayaran_sppt_ke
                            );
                            $saved[] = $prints;

                            //buat cetak
                            //32.10.030.011.000-5327.7 
                            $nopp = $kd_propinsi . "." . $kd_dati2 . "." . $kd_kecamatan . "." . $kd_kelurahan . ".";
                            $nopp .= $kd_blok . "-" . $no_urut . "." . $kd_jns_op;
                            $dctk = array();
                            if ($qctk = $this->payment_model->get_by_nop_thn_ke($nop, $thn_pajak_sppt, $pembayaran_sppt_ke)) {
                                //$dctk = array();
                                $dctk[8] =  $qctk->NM_TP;
                                $dctk[9] =  $qctk->THN_PAJAK_SPPT;
                                $dctk[10] = $qctk->NM_WP_SPPT;
                                $dctk[11] = $qctk->NM_KECAMATAN;
                                $dctk[12] = $qctk->NM_KELURAHAN;
                                $dctk[13] = $nopp; //kode;//x
                                $dctk[14] = $qctk->JML_SPPT_YG_DIBAYAR;
                                $dctk[15] = $qctk->DENDA_SPPT;
                                $dctk[16] = $qctk->TGL_JATUH_TEMPO_SPPT;
                                $dctk[17] = $qctk->TGL_PEMBAYARAN_SPPT;
                                $dctk[18] = $qctk->JML_SPPT_YG_DIBAYAR;
                                $dctk[19] = $qctk->LUAS_BUMI_SPPT;
                                $dctk[20] = $qctk->LUAS_BNG_SPPT;

                                $dctk[40] = $qctk->JLN_WP_SPPT;
                                $dctk[41] = $qctk->BLOK_KAV_NO_WP_SPPT;
                                $dctk[42] = $qctk->NM_PROPINSI;
                                $dctk[43] = $qctk->NM_DATI2;
                            }
                            $cetak[] = $dctk;
                            /****end****************************************************************/
                        } else {

                            $success = "0"; // alias gagal save
                            /****star****************************************************************/
                            $prints  = array(
                                'nop' => $nop,
                                'thn' => $thn_pajak_sppt,
                                'ke' => $pembayaran_sppt_ke
                            );
                            $saved[] = $prints;

                            //buat cetak
                            //32.10.030.011.000-5327.7 
                            $nopp = $kd_propinsi . "." . $kd_dati2 . "." . $kd_kecamatan . "." . $kd_kelurahan . ".";
                            $nopp .= $kd_blok . "-" . $no_urut . "." . $kd_jns_op;

                            $dctk = array();
                            $dctk[8]  = "gagal";
                            $dctk[9]  = $thn_pajak_sppt;
                            $dctk[10] = "ERROR - GAGAL SIMPAN"; //$qctk->NM_WP_SPPT;
                            $dctk[11] = $kd_kecamatan; //$qctk->NM_KECAMATAN;
                            $dctk[12] = $kd_kelurahan; //$qctk->NM_KELURAHAN;
                            $dctk[13] = $nopp; //kode;//x
                            $dctk[14] = $jml_sppt_yg_dibayar; //$qctk->JML_SPPT_YG_DIBAYAR;
                            $dctk[15] = $denda_sppt; //$qctk->DENDA_SPPT;
                            $dctk[16] = "-"; //$qctk->TGL_JATUH_TEMPO_SPPT;
                            $dctk[17] = $tgl_pembayaran_sppt; //$qctk->TGL_PEMBAYARAN_SPPT;
                            $dctk[18] = $jml_sppt_yg_dibayar; //$qctk->JML_SPPT_YG_DIBAYAR;
                            $dctk[19] = "0"; //$qctk->LUAS_BUMI_SPPT;
                            $dctk[20] = "0"; //$qctk->LUAS_BNG_SPPT;
                            $dctk[40] = "-"; //$qctk->JLN_WP_SPPT;
                            $dctk[41] = "-"; //$qctk->BLOK_KAV_NO_WP_SPPT;
                            $dctk[42] = $kd_propinsi; //$qctk->NM_PROPINSI;
                            $dctk[43] = $kd_dati2; //$qctk->NM_DATI2;
                            $cetak[]  = $dctk;

                            /****end****************************************************************/
                        }
                    }
                } //end loop foreach

                $ret           = array();
                $ret['simpan'] = 'sukses';
                $ret['saved']  = $saved;
                $ret['cetak']  = $cetak;
                echo json_encode($ret);
                exit;
            }
        }

        $ret = array();
        $ret['simpan'] = 'gagal';
        echo json_encode($ret);
    }

    function unggah()
    { //upload

        /* arig 2018-09-01
        konsep di rubah karena suka nyebrang saat bayar barengan dan di inetpub jg ga bisa
        */

        $tgljam_prs  = $this->uri->segment(4);
        $file_upload = $tgljam_prs;

        if (!empty($_FILES['userfile']['name'])) {

            $file_ori           = '';
            $file_upload        = '';
            $file_upload_encryp = '';

            $this->load->library('upload');

            if (!is_array($_FILES['userfile']['name'])) {

                $config['file_name'] = $tgljam_prs . md5($_FILES['userfile']['name']);
                $file_upload_encryp  = $tgljam_prs . md5($_FILES['userfile']['name']);
                $file_upload         = $tgljam_prs . $_FILES['userfile']['name'];
                $file_ori            = $_FILES['userfile']['name'];
            } else {

                $fn = array();
                //  $fn[] = $tgljam_prs;
                $file_upload_encryp  = $tgljam_prs;
                $file_upload         = $tgljam_prs;
                //
                foreach ($_FILES['userfile']['name'] as $key => $value) {
                    $fn[]                = $tgljam_prs . md5($value);
                    $file_upload_encryp .= md5($value);
                    $file_upload        .= $value;
                    $file_ori           .= $value;
                }

                $config['file_name'] = $fn;
            }

            $config['upload_path'] = 'assets/dokumen/';

            //     $config['upload_path'] = 'D:/tmp_upload_posbb/';

            $config['overwrite'] = TRUE;
            $config['encrypt_name'] = TRUE;
            $config['remove_spaces'] = TRUE;
            $config['max_size']  = 1024 * 5;
            $config['allowed_types'] = '*';
            $this->upload->initialize($config);

            if ($this->upload->do_multi_upload("userfile")) {
                $uploadinfo = $this->upload->get_multi_upload_data();

                $jml_sisa  = 0;
                $jml_denda = 0;
                $jml_utang = 0;

                $param = '';
                $adata = array();
                $file = $uploadinfo[0]['full_path'];
                $myfile = fopen($file, "r") or die("Unable to open file!");

                $ctr = 0;

                while (!feof($myfile)) {

                    if ($ctr == 0) {
                        $where = " file_upload='" . $file_upload . "'";
                        $this->upload_nop_model->delete_all_upload($where);
                        $ctr = 1;
                    }

                    // echo fgets($myfile) . "<br>";

                    $param_n = fgets($myfile);
                    $param_x = preg_replace("/[^0-9]/", "", $param_n);
                    // $param  .= "'{$param_x}',";

                    $nop = substr($param_x, 0, 18);
                    $thn = substr($param_x, 18, 4);

                    // --------------
                    if ($query = $this->sppt_model->get_by_nop_thn($nop, $thn)) {

                        $pbb_yg_harus_dibayar_sppt  = (float) $query->PBB_YG_HARUS_DIBAYAR_SPPT;
                        $jml_sppt_yg_dibayar        = $query->JML_SPPT_YG_DIBAYAR;
                        $denda_sppt                 = (float) $query->DENDA_SPPT;
                        $sisa  = $pbb_yg_harus_dibayar_sppt - ($jml_sppt_yg_dibayar - $denda_sppt);

                        $denda = 0;

                        if (date($query->TGL_JATUH_TEMPO_SPPT) < date('Y-m-d')) {
                            $denda = hitdenda($sisa, $query->TGL_JATUH_TEMPO_SPPT);
                        }

                        $utang = $sisa + $denda;

                        $nama_wp   = $query->NM_WP_SPPT;
                        $alamat_wp = $query->JLN_WP_SPPT;

                        $data = array(
                            $nop,
                            $thn,
                            number_format($sisa, 0, ',', '.'),
                            number_format($denda, 0, ',', '.'),
                            number_format($utang, 0, ',', '.'),
                            $nama_wp,
                            $alamat_wp,
                        );

                        if ($utang > 0) {
                            $jml_sisa  += $sisa;
                            $jml_denda += $denda;
                            $jml_utang += $utang;

                            $adata[] = $data;
                        }
                        // check duplicate record
                        $filter  = " kode_prs='upload_nop' and file_upload='" . $file_upload . "'";
                        $filter .= " and nop='" . $nop . "' and tahun='" . $thn . "'";

                        $add_upload_dt = array(
                            'KODE_PRS' => 'upload_nop',
                            'FILE_ORI' => $file_ori,
                            'FILE_UPLOAD' => $file_upload,
                            'FILE_UPLOAD_ENCRYP' => $file_upload_encryp,
                            'NOP' => $nop,
                            'TAHUN' => $thn,
                            'POKOK' => $sisa,
                            'DENDA' => $denda,
                            'JUMLAH' => $utang,
                            'NAMA_WP' => $nama_wp,
                            'ALAMAT_WP' => $alamat_wp,
                            'TGL_PRS' => date('Y-m-d H:i:s'),
                            'STS' => '0',
                            'USER_ID' => $this->session->userdata('userid'),
                            'USERID' => lda_user_login(),
                        );
                        $this->upload_nop_model->save_upload($add_upload_dt, $filter);
                        //
                    }
                    // --------------
                }

                // add total
                $data = array(
                    "<b>JUMLAH TOTAL</b>",
                    "-",
                    "<b>" . number_format($jml_sisa, 0, ',', '.') . "</b>",
                    "<b>" . number_format($jml_denda, 0, ',', '.') . "</b>",
                    "<b>" . number_format($jml_utang, 0, ',', '.') . "</b>",
                    "-",
                    "-",
                );
                $adata[] = $data; // $adata = array_merge($total, $adata); //sama,  di sort di view aja

                @fclose($myfile);
                $aadata["aaData"] = $adata;

                $file = 'assets/dokumen/dtsrc.xxx';
                $dtfile = fopen($file, "w");
                echo fwrite($dtfile, json_encode($aadata));
                @fclose($dtfile);

                // echo json_encode($aadata);
                // echo json_encode(array('msg' => 'ok'));
                // echo json_encode(array('status' => 'success', 'msg' => json_encode($adata)));
                echo ' - Upload sukses.!!';
            } else {
                // echo 'Upload file gagal.';
                echo strip_tags($this->upload->display_errors()) . ' - Upload file gagal.';
            }
        } else {
            echo 'File tidak ditemukan..!!';
        }
    }

    function read_upload_recs()
    {
        // ob_start("ob_gzhandler");

        $p_tgljam_prs  = $this->input->get('p_tgljam_prs');
        $p_file_upload = $this->input->get('p_file_upload');
        $filter        = " where file_upload='" . $p_tgljam_prs . $p_file_upload . "' ";

        $sql_query_r = "select nop, tahun, pokok, denda, jumlah,  nama_wp, alamat_wp
        FROM TMP_UPLOAD_NOP " . $filter;

        $qry = $this->db->query($sql_query_r);
        $responce = new stdClass();
        $i = 0;
        $jml_sisa  = 0;
        $jml_denda = 0;
        $jml_utang = 0;

        foreach ($qry->result() as $aRow) {

            $responce->aaData[$i][] = $aRow->NOP;
            $responce->aaData[$i][] = $aRow->TAHUN;
            $responce->aaData[$i][] = number_format($aRow->POKOK, 0, ',', '.');
            $responce->aaData[$i][] = number_format($aRow->DENDA, 0, ',', '.');
            $responce->aaData[$i][] = number_format($aRow->JUMLAH, 0, ',', '.');
            $responce->aaData[$i][] = $aRow->NAMA_WP;
            $responce->aaData[$i][] = $aRow->ALAMAT_WP;
            $i++;

            if ($aRow->JUMLAH > 0) {
                $jml_sisa  += $aRow->POKOK;
                $jml_denda += $aRow->DENDA;
                $jml_utang += $aRow->JUMLAH;
            }
        }

        $responce->aaData[$i][] = 'JUMLAH TOTAL';
        $responce->aaData[$i][] = '-';
        $responce->aaData[$i][] = number_format($jml_sisa, 0, ',', '.');
        $responce->aaData[$i][] = number_format($jml_denda, 0, ',', '.');
        $responce->aaData[$i][] = number_format($jml_utang, 0, ',', '.');
        $responce->aaData[$i][] = '-';
        $responce->aaData[$i][] = '-';

        echo json_encode($responce);
    }

    function unggah_try()
    { //upload

        /* arig 2018-09-01
        konsep di rubah karena suka nyebrang saat bayar barengan dan di inetpub jg ga bisa
        */

        $tgljam_prs  = $this->uri->segment(4);
        $file_upload = $tgljam_prs;

        if (!empty($_FILES['userfile']['name'])) {

            $file_ori           = '';
            $file_upload        = '';
            $file_upload_encryp = '';

            $this->load->library('upload');

            if (!is_array($_FILES['userfile']['name'])) {

                $config['file_name'] = $tgljam_prs . md5($_FILES['userfile']['name']);
                $file_upload_encryp  = $tgljam_prs . md5($_FILES['userfile']['name']);
                $file_upload         = $tgljam_prs . $_FILES['userfile']['name'];
                $file_ori            = $_FILES['userfile']['name'];
            } else {

                $fn = array();
                //  $fn[] = $tgljam_prs;
                $file_upload_encryp  = $tgljam_prs;
                $file_upload         = $tgljam_prs;
                //
                foreach ($_FILES['userfile']['name'] as $key => $value) {
                    $fn[]                = $tgljam_prs . md5($value);
                    $file_upload_encryp .= md5($value);
                    $file_upload        .= $value;
                    $file_ori           .= $value;
                }

                $config['file_name'] = $fn;
            }

            $config['upload_path'] = 'assets/dokumen/';

            //     $config['upload_path'] = 'D:/tmp_upload_posbb/';

            $config['overwrite'] = TRUE;
            $config['encrypt_name'] = TRUE;
            $config['remove_spaces'] = TRUE;
            $config['max_size']  = 1024 * 5;
            $config['allowed_types'] = '*';
            $this->upload->initialize($config);




            $jml_sisa  = 0;
            $jml_denda = 0;
            $jml_utang = 0;

            $param = '';
            $adata = array();

            $myfile = fopen($_FILES['userfile']['tmp_name'], "r") or die("Unable to open file!");

            $ctr = 0;

            while (!feof($myfile)) {

                if ($ctr == 0) {
                    $where = " file_upload='" . $file_upload . "'";
                    $this->upload_nop_model->delete_all_upload($where);
                    $ctr = 1;
                }

                // echo fgets($myfile) . "<br>";

                $param_n = fgets($myfile);
                $param_x = preg_replace("/[^0-9]/", "", $param_n);
                // $param  .= "'{$param_x}',";

                $nop = substr($param_x, 0, 18);
                $thn = substr($param_x, 18, 4);

                // --------------
                if ($query = $this->sppt_model->get_by_nop_thn($nop, $thn)) {

                    $pbb_yg_harus_dibayar_sppt  = (float) $query->PBB_YG_HARUS_DIBAYAR_SPPT;
                    $jml_sppt_yg_dibayar        = $query->JML_SPPT_YG_DIBAYAR;
                    $denda_sppt                 = (float) $query->DENDA_SPPT;
                    $sisa  = $pbb_yg_harus_dibayar_sppt - ($jml_sppt_yg_dibayar - $denda_sppt);

                    $denda = 0;

                    if (date($query->TGL_JATUH_TEMPO_SPPT) < date('Y-m-d')) {
                        $denda = hitdenda($sisa, $query->TGL_JATUH_TEMPO_SPPT);
                    }

                    $utang = $sisa + $denda;

                    $nama_wp   = $query->NM_WP_SPPT;
                    $alamat_wp = $query->JLN_WP_SPPT;

                    $data = array(
                        $nop,
                        $thn,
                        number_format($sisa, 0, ',', '.'),
                        number_format($denda, 0, ',', '.'),
                        number_format($utang, 0, ',', '.'),
                        $nama_wp,
                        $alamat_wp,
                    );

                    if ($utang > 0) {
                        $jml_sisa  += $sisa;
                        $jml_denda += $denda;
                        $jml_utang += $utang;

                        $adata[] = $data;
                    }
                    // check duplicate record
                    $filter  = " kode_prs='upload_nop' and file_upload='" . $file_upload . "'";
                    $filter .= " and nop='" . $nop . "' and tahun='" . $thn . "'";

                    $add_upload_dt = array(
                        'KODE_PRS' => 'upload_nop',
                        'FILE_ORI' => $file_ori,
                        'FILE_UPLOAD' => $file_upload,
                        'FILE_UPLOAD_ENCRYP' => $file_upload_encryp,
                        'NOP' => $nop,
                        'TAHUN' => $thn,
                        'POKOK' => $sisa,
                        'DENDA' => $denda,
                        'JUMLAH' => $utang,
                        'NAMA_WP' => $nama_wp,
                        'ALAMAT_WP' => $alamat_wp,
                        'TGL_PRS' => date('Y-m-d H:i:s'),
                        'STS' => '0',
                        'USER_ID' => $this->session->userdata('userid'),
                        'USERID' => lda_user_login(),
                    );
                    $this->upload_nop_model->save_upload($add_upload_dt, $filter);
                    //
                }
                // --------------
            }

            // add total
            $data = array(
                "<b>JUMLAH TOTAL</b>",
                "-",
                "<b>" . number_format($jml_sisa, 0, ',', '.') . "</b>",
                "<b>" . number_format($jml_denda, 0, ',', '.') . "</b>",
                "<b>" . number_format($jml_utang, 0, ',', '.') . "</b>",
                "-",
                "-",
            );
            $adata[] = $data; // $adata = array_merge($total, $adata); //sama,  di sort di view aja

            @fclose($myfile);
            $aadata["aaData"] = $adata;

            $file = 'assets/dokumen/dtsrc.xxx';
            $dtfile = fopen($file, "w");
            echo fwrite($dtfile, json_encode($aadata));
            @fclose($dtfile);

            // echo json_encode($aadata);
            // echo json_encode(array('msg' => 'ok'));
            // echo json_encode(array('status' => 'success', 'msg' => json_encode($adata)));
            echo ' - Upload sukses.!!';
        } else {
            echo 'File tidak ditemukan..!!';
        }
    }

    function cetak()
    {

        $cetak = $this->input->post('dtCetak');
        $tambahan_data2 = array();

        if (isset($cetak)) {
            $i = 1;
            $j = json_decode($cetak, true);
            if (count($j['dtCetak']) > 0)
                $this->load->view(STTS2, $j);
        }
    }

    function cetak_dev()
    {

        $cetak = $this->input->post('dtCetak');
        $tambahan_data2 = array();

        if (isset($cetak)) {
            $i = 1;
            $j = json_decode($cetak, true);
            if (count($j['dtCetak']) > 0)
                $this->load->view(STTS2, $j);
        }
    }

    function cetak_draft()
    {

        $cetak = $this->input->post('dtCetak');
        $tambahan_data2 = array();

        if (isset($cetak)) {
            $i = 1;
            $j = json_decode($cetak, true);
            if (count($j['dtCetak']) > 0)
                $this->load->view(STTS4, $j);
        }
    }

    public function cetak_bank_text()
    {
        $rpt = '';
        $data = $_POST['data'];
        $data = json_decode($data, true);

        if ($data != null) {
            $rpt .= "<html><head></head><body><pre>";

            foreach ($data as $d) {
                if ($q = $this->payment_model->get_by_nop_thn_ke($d['nop'], $d['thn'], $d['ke'])) {

                    $sn = date('dmY', strtotime($q->tgl_pembayaran_sppt));
                    $sn .= $q->kd_propinsi . $q->kd_dati2 . $q->kd_kecamatan . $q->kd_kelurahan . $q->kd_blok . $q->no_urut . $q->kd_jns_op . $q->thn_pajak_sppt;

                    $rpt .= str_repeat("&nbsp;", 2) . str_pad("SURAT TANDA TERIMA SETORAN (STTS) {$q->nm_tp}", 98, " ", STR_PAD_BOTH);
                    $rpt .= "\n";
                    $rpt .= "\n" . str_repeat("&nbsp;", 2) . "BUKTI PEMBAYARAN LUNAS {$q->nm_tp}";
                    $rpt .= "\n" . str_repeat("&nbsp;", 2) . "PAJAK PBB-P2";
                    $rpt .= "\n" . str_repeat("&nbsp;", 2) . "KODE TP : {$q->kd_tp}";
                    $rpt .= "\n" . str_repeat("&nbsp;", 2) . "TANGGAL TRANSAKSI   : " . date('d/m/Y', strtotime($q->tgl_pembayaran_sppt)) . " (DD/MM/YYYY)           "; //SN : ".md5($sn);
                    $rpt .= "\n" . str_repeat("&nbsp;", 2) . "KOTA/KABUPATEN      : {$q->nm_dati2}";
                    $rpt .= "\n" . str_repeat("&nbsp;", 2) . "NOP                 : " . $q->kd_propinsi . $q->kd_dati2 . $q->kd_kecamatan . $q->kd_kelurahan . $q->kd_blok . $q->no_urut . $q->kd_jns_op;
                    $rpt .= "\n" . str_repeat("&nbsp;", 2) . "TAHUN PAJAK         : {$q->thn_pajak_sppt}";
                    $rpt .= "\n" . str_repeat("&nbsp;", 2) . "NAMA WAJIB PAJAK    : {$q->nm_wp_sppt}";
                    $rpt .= "\n" . str_repeat("&nbsp;", 2) . "ALAMAT WAJIB PAJAK  : {$q->jln_wp_sppt}";
                    $rpt .= "\n" . str_repeat("&nbsp;", 2) . "KELURAHAN           : " . $q->jln_wp_sppt . " RT." . $q->rt_wp_sppt . " RW." . $q->rw_wp_sppt . " KEL. " . $q->kelurahan_wp_sppt;

                    $rpt .= "\n";
                    $rpt .= "\n" . str_repeat("&nbsp;", 2) . "LETAK OBJEK PAJAK   : " . str_repeat("&nbsp;", 34) .        "URAIAN PEMBAYARAN  :";
                    $rpt .= "\n" . str_repeat("&nbsp;", 2) . "KELURAHAN           : " . str_pad($q->nm_kelurahan, 34, " ") . "POKOK PAJAK PBB-P2 :" . str_pad(number_format($q->jml_sppt_yg_dibayar - $q->denda_sppt, 0, ',', '.'), 20, " ", STR_PAD_LEFT);
                    $rpt .= "\n" . str_repeat("&nbsp;", 2) . "KECAMATAN           : " . str_pad($q->nm_kecamatan, 34, " ") . "DENDA              :" . str_pad(number_format($q->denda_sppt, 0, ',', '.'), 20, " ", STR_PAD_LEFT);
                    $rpt .= "\n" . str_repeat("&nbsp;", 2) . "PROPINSI            : " . str_pad($q->nm_propinsi, 34, " ") . "                       ----------------- +";
                    $rpt .= "\n" . str_repeat("&nbsp;", 2) . "LUAS TANAH          : " . str_pad(number_format($q->luas_bumi_sppt, 0, ',', '.') . " M2", 34, " ") . "JML SETORAN PAJAK  :" . str_pad(number_format($q->jml_sppt_yg_dibayar, 0, ',', '.'), 20, " ", STR_PAD_LEFT);
                    $rpt .= "\n" . str_repeat("&nbsp;", 2) . "LUAS BANGUNAN       : " . str_pad(number_format($q->luas_bng_sppt, 0, ',', '.') . " M2", 34, " ");
                    $rpt .= "\n" . str_repeat("&nbsp;", 2) . "TERBILANG           : " . strtoupper(terbilang($q->jml_sppt_yg_dibayar)) . " RUPIAH";
                    $rpt .= "\n" . str_repeat("&nbsp;", 2) . "TGL JATUH TEMPO     : " . date('d/m/Y', strtotime($q->tgl_jatuh_tempo_sppt)) . " (DD/MM/YYYY)";

                    $rpt .= "\n";
                    $rpt .= "\n";
                    $rpt .= "\n" . str_repeat("&nbsp;", 2) . "                                                               ___________________________";
                    $rpt .= "\n" . str_repeat("&nbsp;", 2) . "                                                                       PETUGAS BANK";
                    $rpt .= "\n" . str_repeat("&nbsp;", 2) . "SELURUH PEMERINTAH KABUPATEN/KOTA PROPINSI JAWA BARAT MENYATAKAN RESI INI SEBAGAI BUKTI PEMBAYARAN";
                    $rpt .= "\n" . str_repeat("&nbsp;", 2) . "PAJAK DAERAH YANG SAH.";
                    $rpt .= "\n" . str_repeat("&nbsp;", 2) . "PEMBAYARAN PAJAK DAERAH DAPAT DILAKUKAN DI SELURUH JARINGAN KANTOR BANK TERDEKAT.";
                    $rpt .= "\n";
                    $rpt .= "\n";
                    $rpt .= "\n";
                    $rpt .= "\n";
                    $rpt .= "\n";
                    $rpt .= "\n";
                    $rpt .= "\n";
                }
            }
            $rpt .= "</pre></font></body></html>";

            echo $rpt;
        } else echo "No Data";
    }

    public function  cetak_pdf()
    {
        $data = $_POST['data'];
        $data = json_decode($data, true);
        $join = '';

        //tambahan parameter join untuk relasi tabel pembayaran sppt dgn tempat pembayaran
        if (DEF_POS_TYPE == 1) {
            $join = " ps.kd_kanwil=tp.kd_kanwil AND ps.kd_kantor=tp.kd_kantor AND ps.kd_tp=tp.kd_tp ";
        } elseif (DEF_POS_TYPE == 2) {
            $join = " ps.kd_kanwil=tp.kd_kanwil AND ps.kd_kantor=tp.kd_kantor AND ps.kd_bank_tunggal=tp.kd_bank_tunggal AND ps.kd_bank_persepsi=tp.kd_bank_persepsi AND  ps.kd_tp=tp.kd_tp ";
        }

        $rpt   = "stts_nop";
        $sttsno = $_POST['sttsno'];
        $rpt  .= $sttsno;

        if (count($data) > 0) {
            $param = '';
            foreach ($data as $d) {
                $param_n = "{$d['nop']}{$d['thn']}{$d['ke']}";
                $param_x = preg_replace("/[^0-9]/", "", $param_n);
                $param_x = " ('" . substr($param_x, 0, 2) . "','" . substr($param_x, 2, 2) . "','" .
                    substr($param_x, 4, 3) . "','" . substr($param_x, 7, 3) . "','" .
                    substr($param_x, 10, 3) . "','" . substr($param_x, 13, 4) . "','" .
                    substr($param_x, 17, 1) . "','" . substr($param_x, 18, 4) . "'," .
                    substr($param_x, 22, 1) . ") ";
                $param  .= "{$param_x},";
            }
            $param = substr($param, 0, -1);

            $params = array(
                "daerah" => LICENSE_TO,
                "dinas" => LICENSE_TO_SUB,
                "logo" => base_url("assets/img/logorpt__.jpg"),

                "param" => $param,
                "join" => $join,
            );

            $jasper = $this->load->library('Jasper');
            echo $jasper->cetak(POS_WIL . "/{$rpt}", $params, "pdf", false);
        } else {
            echo "No Data";
        }
    }

    public function  cetak_bank()
    {

        $data = $_POST['data'];
        $data = json_decode($data, true);
        $join = '';

        //tambahan parameter join untuk relasi tabel pembayaran sppt dgn tempat pembayaran
        if (DEF_POS_TYPE == 1) {
            $join = " ps.kd_kanwil=tp.kd_kanwil AND ps.kd_kantor=tp.kd_kantor AND ps.kd_tp=tp.kd_tp ";
        } elseif (DEF_POS_TYPE == 2) {
            $join = " ps.kd_kanwil=tp.kd_kanwil AND ps.kd_kantor=tp.kd_kantor AND ps.kd_bank_tunggal=tp.kd_bank_tunggal AND ps.kd_bank_persepsi=tp.kd_bank_persepsi AND  ps.kd_tp=tp.kd_tp ";
        }

        if (count($data) > 0) {
            $param = '';
            foreach ($data as $d) {
                $param_n = "{$d['nop']}{$d['thn']}{$d['ke']}";
                $param_x = preg_replace("/[^0-9]/", "", $param_n);
                $param_x = " ('" . substr($param_x, 0, 2) . "','" . substr($param_x, 2, 2) . "','" .
                    substr($param_x, 4, 3) . "','" . substr($param_x, 7, 3) . "','" .
                    substr($param_x, 10, 3) . "','" . substr($param_x, 13, 4) . "','" .
                    substr($param_x, 17, 1) . "','" . substr($param_x, 18, 4) . "'," .
                    substr($param_x, 22, 1) . ") ";
                $param  .= "{$param_x},";
            }
            $param = substr($param, 0, -1);

            $params = array(
                "daerah" => LICENSE_TO,
                "dinas" => LICENSE_TO_SUB,
                "logo" => base_url("assets/img/logorpt__.jpg"),

                "param" => $param,
                "join" => $join,
            );

            $jasper = $this->load->library('Jasper');
            echo $jasper->cetak(POS_WIL . "/stts_nop_bank", $params, "pdf", false);
        } else {
            echo "No Data";
        }
    }
}
