<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class pst_penghapusan_kolektif extends CI_Controller
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

        $module = 'pst_penghapusan_kolektif';
        $this->load->library('module_auth', array('module' => $module));

        $this->load->helper('app_helper');
        $this->load->model(array('apps_model', 'login_model', 'pst_sppt_pengurangan_model', 'payment_model'));

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
        $data['current']   = 'pst_penghapusan_kolektif';

        $filter         = $this->session->userdata('pos_filter');
        $filter         = isset($filter) ? $filter : '';
        $data['filter'] = $filter;
        $data['prefix'] = KD_PROPINSI . "." . KD_DATI2;
        $data['tpnm']   = isset($this->session->userdata['tpnm']) ? $this->session->userdata['tpnm'] : '';

        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = active_module_url('pst_penghapusan_kolektif/simpan');

        $this->load->view('pst_penghapusan_kolektif/vpst_penghapusan_kolektif', $data);
    }

    public function cari()
    {
        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect('pospbb_ora');
        }

        $tahun    = $this->uri->segment(4);
        $bundel    = $this->uri->segment(5);
        $urut    = $this->uri->segment(6);
        //
        if ($tahun && $bundel && $urut && $result = $this->pst_sppt_pengurangan_model->get_pelayanan_kolektif($tahun, $bundel, $urut)) {

            $output = array(
                'found' => 1,
                //'sEcho' => intval($sEcho),
                'iTotalRecords' => $result['tot_rows'] + 1,
                'iTotalDisplayRecords' => $result['num_rows'] + 1,
                //'sql' => $result['sql'],
                'aaData' => array()
            );

            $sisatot  = 0;
            $dendatot = 0;
            $denda_pengurangan_tot = 0;
            $utangtot = 0;

            foreach ($result['query'] as $data) {

                $sisa  = (float) $data['PBB_YG_HARUS_DIBAYAR_SPPT'] - ($data['JML_SPPT_YG_DIBAYAR'] - (float) $data['DENDA_SPPT']);

                $denda = 0;
                $jtempo = date('Y-m-d', strtotime($data['TGL_JATUH_TEMPO_SPPT']));

                if ($jtempo < date('Y-m-d')) {

                    $denda = hitdenda($sisa, $jtempo);
                }

                // PENGURANGAN denda 
                $pct_pengurangan   = (float) $data['PCT_PERMOHONAN_PENGURANGAN'];
                $denda_pengurangan = round($denda - ($denda * $pct_pengurangan / 100));

                //$utang = $sisa + $denda;
                $utang = $sisa + $denda_pengurangan;

                $row = array();

                $row[] = $data['KODE'];
                $row[] = $data['THN_PAJAK_SPPT'];
                $row[] = number_format($sisa, 0, ',', '.');
                $row[] = number_format($denda, 0, ',', '.');
                $row[] = (float) $data['PCT_PERMOHONAN_PENGURANGAN'];
                $row[] = number_format($denda_pengurangan, 0, ',', '.');
                $row[] = number_format($utang, 0, ',', '.');
                $row[] = $data['NM_WP_SPPT'];
                $row[] = $data['JLN_WP_SPPT'];
                $row[] = '<a class="btn btn-danger delete" href="javascript:void();">Batal</a>';
                $output['aaData'][] = $row;

                $sisatot += $sisa;
                $dendatot += $denda;
                $denda_pengurangan_tot += $denda_pengurangan;
                $utangtot += $utang;
            }
            $row   = array();
            $row[] = 'TOTAL';
            $row[] = '';
            $row[] = number_format($sisatot, 0, ',', '.');
            $row[] = number_format($dendatot, 0, ',', '.');
            $row[] = '';
            $row[] = number_format($denda_pengurangan_tot, 0, ',', '.');
            $row[] = number_format($utangtot, 0, ',', '.');
            $row[] = '';
            $row[] = '';
            $row[] = '';
            // $output['aaData'][] = $row;

            /*$output['iSisa']= number_format($sisatot,0,',','.');
            $output['iDenda']= number_format($dendatot,0,',','.');
            $output['iUtang']= number_format($utangtot,0,',','.');
            */
            echo json_encode($output);
            //  'terbilang'=>$terbilang
            //$terbilang=terbilang($utang);

        } else {
            $output = array(
                'found' => 0,
                //'sEcho' => intval($sEcho),
                'iTotalRecords' => 0,
                'iTotalDisplayRecords' => 0,
                //'sql' => $result['sql'],
                'aaData' => array()
            );
            echo json_encode($output);
        }
    }

    private function fvalidation()
    {
        $this->form_validation->set_error_delimiters('<span>', '</span>');
        $this->form_validation->set_rules('nop', 'NOP', 'required');
        $this->form_validation->set_rules('tahun', 'Tahun', 'required|numeric');
    }

    function simpan_tes()
    {
        $thn_p = $this->uri->segment(4);
        $bundel_p = $this->uri->segment(5);
        $urut_p  = $this->uri->segment(6);
        //$thn_p  = $this->input->post('blok_tahun');
        // $thn_p  = $this->input->post('blok_tahun');
    }
    function simpan()
    {
        if (!$this->module_auth->create) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_insert);
            redirect('pospbb_ora');
        }

        $simpan = $_POST['data'];

        $thn_p = $this->uri->segment(4);
        $bundel_p = $this->uri->segment(5);
        $urut_p  = $this->uri->segment(6);

        if (isset($simpan)) {
            $data = json_decode($simpan, true);

            if (count($data) > 0) {

                $saved = array();
                $cetak = array();

                foreach ($data as $row) {

                    $nop = $row[0];
                    $nop = preg_replace('/[^0-9]/', '', $nop);
                    $thn_pajak_sppt = $row[1];

                    $kd_propinsi  = substr($nop, 0, 2);
                    $kd_dati2     = substr($nop, 2, 2);
                    $kd_kecamatan = substr($nop, 4, 3);
                    $kd_kelurahan = substr($nop, 7, 3);
                    $kd_blok      = substr($nop, 10, 3);
                    $no_urut      = substr($nop, 13, 4);
                    $kd_jns_op    = substr($nop, 17, 1);

                    //$thn_p 		= $this->input->post('blok_tahun');
                    //$bundel_p 	= $this->input->post('blok_bundel');
                    //$urut_p 	= $this->input->post('blok_urut');
                    //
                    if ($query = $this->pst_sppt_pengurangan_model->get_by_nop_thn($nop, $thn_pajak_sppt)) {
                        //if ($query = $this->pst_sppt_pengurangan_model->get_no_pelayanan($tahun, $bundel, $urut)) {

                        $sisa  = (float) $query->PBB_YG_HARUS_DIBAYAR_SPPT - ($query->JML_SPPT_YG_DIBAYAR - (float) $query->DENDA_SPPT);

                        $denda = 0;
                        $jtempo = date('Y-m-d', strtotime($query->TGL_JATUH_TEMPO_SPPT));

                        if ($jtempo < date('Y-m-d')) {

                            $denda = hitdenda($sisa, $jtempo);
                        }

                        // PENGURANGAN denda 
                        $pct_pengurangan   = (float) $query->PCT_PERMOHONAN_PENGURANGAN;
                        $denda_pengurangan = round($denda - ($denda * $pct_pengurangan / 100));

                        //$utang     = $sisa + $denda;
                        $utang     = $sisa + $denda_pengurangan;

                        $denda_sppt          = $denda_pengurangan;   //$denda;
                        $jml_sppt_yg_dibayar = $utang;

                        $tgl_pembayaran_sppt = current_date();
                        $tgl_rekam_byr_sppt  = current_time();
                        $nip_rekam_byr_sppt  = $this->session->userdata('nip');

                        $thn_pjk = $thn_pajak_sppt;
                        $pembayaran_sppt_ke  = $this->pst_sppt_pengurangan_model->get_pengurangan_bayar_ke($nop, $thn_pjk);
                        $mohon = $this->pst_sppt_pengurangan_model->get_permohonan_pengurangan($nop, $thn_pjk, $thn_p, $bundel_p, $urut_p);

                        $pengurangan_dt = array(
                            'KD_KANWIL' => $mohon->KD_KANWIL,
                            'KD_KANTOR' => $mohon->KD_KANTOR,
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
                            'JNS_PENGURANGAN' => $mohon->JNS_PENGURANGAN,
                            'PCT_PENGURANGAN' => $mohon->PCT_PERMOHONAN_PENGURANGAN,
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
                            'KD_PELAYANAN' => '10',
                            'PEMBAYARAN_SPPT_KE' => $pembayaran_sppt_ke,
                            'DENDA_SPPT' => $denda_sppt,
                            'KD_TP_BAYAR' => $this->session->userdata('kd_tp'),
                            'KD_TP_BATAL' => NULL,
                            'FLG_STTS' => 0,

                            'PBB_TERHUTANG_SPPT' => $mohon->PBB_TERHUTANG_SPPT,
                            'FAKTOR_PENGURANG_SPPT' => $mohon->FAKTOR_PENGURANG_SPPT,
                            'PBB_YG_HARUS_DIBAYAR_SPPT' => $mohon->PBB_YG_HARUS_DIBAYAR_SPPT,
                            'FAKTOR_PENGURANG_BAYAR' => 0,

                        );
                        //
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
                            //'jns_pelayanan' => 'P'
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
                            $this->pst_sppt_pengurangan_model->add_bayar_hist_tanpa_denda($pengurangan_dt);
                            /*******************************************************************************************/

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
                            /*******************************************************************************************/
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
                            $dctk[8]  = "gagal";  // $qctk->NM_TP;
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
                }

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

    public function cetak()
    {
        $nop = $this->uri->segment(4);
        $thn = $this->uri->segment(5);
        $ke  = $this->uri->segment(6);
        $this->load->model(array(
            'payment_model'
        ));
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
        $this->load->model(array(
            'payment_model'
        ));
        if ($nop && $thn && $ke && $query = $this->payment_model->get_by_nop_thn_ke($nop, $thn, $ke)) {
            $this->load->view(STTS3, $query);
        }
    }

    public function cetak_pdf()
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
