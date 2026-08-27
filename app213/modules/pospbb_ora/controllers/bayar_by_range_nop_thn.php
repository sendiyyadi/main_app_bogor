<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class bayar_by_range_nop_thn extends CI_Controller
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

        $module = 'bayar_by_range_nop_thn';
        $this->load->library('module_auth', array('module' => $module));

        $this->load->helper('app_helper');
        $this->load->model(array('apps_model', 'login_model', 'sppt_model', 'payment_model'));

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
        $data['current']   = 'bayar_by_range_nop_thn'; // stts

        $filter         = $this->session->userdata('pos_filter');
        $filter         = isset($filter) ? $filter : '';
        $data['prefix'] = KD_PROPINSI . "." . KD_DATI2;
        $data['tpnm']   = isset($this->session->userdata['tpnm']) ? $this->session->userdata['tpnm'] : '';

        $data['filter'] = $filter;

        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = active_module_url('bayar_by_range_nop_thn/simpan');
        //$data['current'] = 'stts';

        $this->load->view('bayar_by_range_nop_thn/vbayar_by_range_nop_thn', $data);
    }

    public function cari()
    {
        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect('pospbb_ora');
        }

        $range1 = $this->uri->segment(4);
        $range2 = $this->uri->segment(5);
        $thn    = $this->uri->segment(6);

        if ($range1 && $range2 && $thn && $result = $this->sppt_model->get_by_range_thn($range1, $range2, $thn)) {
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
            $nil_pengurangtot = 0;
            $utangtot = 0;

            foreach ($result['query'] as $data) {

                $sisa  = (float) $data['PBB_YG_HARUS_DIBAYAR_SPPT'] - ($data['JML_SPPT_YG_DIBAYAR'] - (float) $data['DENDA_SPPT']);

                $nil_pengurang = 0;
                $denda_baru    = 0;
                $denda         = 0;
                $jtempo        = date('Y-m-d', strtotime($data['TGL_JATUH_TEMPO_SPPT']));
                $thn_pjk       = $data['THN_PAJAK_SPPT'];
                $faktor_pengurang_sppt = $data['FAKTOR_PENGURANG_SPPT'];
                $today         = date('Ymd');

                if ($jtempo < date('Y-m-d')) {

                    $denda = hitdenda($sisa, $jtempo);

                    // Penghapusan denda u. periode tertentu
                    if (KD_PROPINSI == '32' && KD_DATI2 == '03') {
                        // jika Thn Pajak di bawah 2015 dan pemby di dlm range 01-02-2020 sd 30-06-2020
                        // if ((int)$thn_pjk <= 2020 && $today <= 20210630 && $today >= 20210401) {
                        //     $denda = 0;
                        // }

                        //relaksasi 04062025 rican
                        if ((int)$thn_pjk == 2025 && $today <= 20250831 && $today >= 20200201 && (int)$faktor_pengurang_sppt == 0 && $sisa > 0) {
                            $denda = 0;
                        }

                        if ((int)$thn_pjk >= 2020 && (int)$thn_pjk <= 2024 && (int)$faktor_pengurang_sppt == 0 && $today <= 20250630 && $today >= 20250603 && $sisa > 0) {
                            $denda = 0;
                        }

                        if ((int)$thn_pjk >= 2020 && (int)$thn_pjk <= 2024 && (int)$faktor_pengurang_sppt == 0 && $today <= 20250731 && $today >= 20250701 && $sisa > 0) {
                            $denda = 0;
                        }

                        if ((int)$thn_pjk >= 2020 && (int)$thn_pjk <= 2024 && (int)$faktor_pengurang_sppt == 0 && $today <= 20250831 && $today >= 20250801 && $sisa > 0) {
                            $denda = 0;
                        }

                        if ((int)$thn_pjk >= 2012 && (int)$thn_pjk <= 2019 && (int)$faktor_pengurang_sppt == 0 && $today <= 20250630 && $today >= 20250603 && $sisa > 0) {
                            $denda = 0;
                        }

                        if ((int)$thn_pjk >= 2012 && (int)$thn_pjk <= 2019 && (int)$faktor_pengurang_sppt == 0 && $today <= 20250731 && $today >= 20250701 && $sisa > 0) {
                            $denda = 0;
                        }

                        if ((int)$thn_pjk >= 2012 && (int)$thn_pjk <= 2019 && (int)$faktor_pengurang_sppt == 0 && $today <= 20250831 && $today >= 20250801 && $sisa > 0) {
                            $denda = 0;
                        }
                    }
                }

                // TAMBAHAN RELAKSASI syarat inti faktor pengurang harus 0
                // if (KD_PROPINSI == '32' && KD_DATI2 == '17' && $thn_pjk == 2020 && $faktor_pengurang_sppt == 0 && $today <= 20210630 && $today >= 20210401) {

                //     $denda         = $denda + $denda_baru;
                //     $utang         = $sisa + $denda;
                //     $nil_pengurang = intval($utang * 5 / 100); // pengurang 5%
                //     $utang         = $utang - $nil_pengurang;
                // } else {
                //     $denda     = $denda + $denda_baru;
                //     $utang     = $sisa + $denda;
                //     $nil_pengurang = 0;
                // }

                //2025, 02 jan 25 - 31 agus 25
            if ($thn_pjk == 2025 && $faktor_pengurang_sppt == 0 && $today <= 20250831 && $today >= 20250102 && $sisa > 0) {

                $faktor_pengurang_lama = $faktor_pengurang_sppt;
                $denda = $denda + $denda_baru;
                $utang = $sisa + $denda;

                $nil_pengurang = round($utang * 5/100);

                $faktor_pengurang_baru = $faktor_pengurang_lama + $nil_pengurang;

                $denda = round($denda * 5/100);

                $utang = $utang - $nil_pengurang;
            }
            //2020-2024, 03 juni 25 - 30 juni 25
            elseif ($thn_pjk >= 2020 && $thn_pjk <= 2024 && $faktor_pengurang_sppt == 0 && $today <= 20250630 && $today >= 20250603 && $sisa > 0) {

                $denda = $denda + $denda_baru;
                $utang     = $sisa + $denda;

                $nil_pengurang = round($utang * 30/100);

                $denda = round($denda * 30/100);

                $utang = $utang - $nil_pengurang;

            }
            //2020-2024, 01 juli 25 - 31 juli 25
            elseif ($thn_pjk >= 2020 && $thn_pjk <= 2024 && $faktor_pengurang_sppt == 0 && $today <= 20250731 && $today >= 20250701 && $sisa > 0) {

                $denda = $denda + $denda_baru;
                $utang     = $sisa + $denda;

                $nil_pengurang = round($utang * 20/100);

                $denda = round($denda * 20/100);

                $utang = $utang - $nil_pengurang;
            }
            //2020-2024, 01 agus 25 - 31 agus 25
            elseif ($thn_pjk >= 2020 && $thn_pjk <= 2024 && $faktor_pengurang_sppt == 0 && $today <= 20250831 && $today >= 20250801 && $sisa > 0) {

                $denda = $denda + $denda_baru;
                $utang     = $sisa + $denda;

                $nil_pengurang = round($utang * 10/100);

                $denda = round($denda * 10/100);

                $utang = $utang - $nil_pengurang;
            }
            //2012-2019, 03 jun 25 - 30 jun 25
            elseif ($thn_pjk >= 2012 && $thn_pjk <= 2019 && $faktor_pengurang_sppt == 0 && $today <= 20250630 && $today >= 20250603 && $sisa > 0) {

                $denda = $denda + $denda_baru;
                $utang     = $sisa + $denda;

                $nil_pengurang = round($utang * 50/100);

                $denda = round($denda * 50/100);

                $utang = $utang - $nil_pengurang;
            }
            //2012-2019, 01 jul 25 - 31 jul 25
            elseif ($thn_pjk >= 2012 && $thn_pjk <= 2019 && $faktor_pengurang_sppt == 0 && $today <= 20250731 && $today >= 20250701 && $sisa > 0) {

                $denda = $denda + $denda_baru;
                $utang     = $sisa + $denda;

                $nil_pengurang = round($utang * 40/100);

                $denda = round($denda * 40/100);

                $utang = $utang - $nil_pengurang;
            }
            //2012-2019, 01 agus 25 - 31 agus 25
            elseif ($thn_pjk >= 2012 && $thn_pjk <= 2019 && $faktor_pengurang_sppt == 0 && $today <= 20250831 && $today >= 20250801 && $sisa > 0) {

                $denda = $denda + $denda_baru;
                $utang     = $sisa + $denda;

                $nil_pengurang = round($utang * 30/100);

                $denda = round($denda * 30/100);

                $utang = $utang - $nil_pengurang;
            }
            else {
                $denda = $denda + $denda_baru;
                $denda = 0;

                $utang     = $sisa + $denda;
                $terbilang = terbilang($utang);
                // $nil_pengurang = $query->faktor_pengurang_sppt;
                $nil_pengurang = 0;
                //$sisa = $sisa - $nil_pengurang - $denda;
                $utang = $utang - $nil_pengurang;

            }

                $row = array();
                $row[]              = $data['KODE'];
                $row[]              = $data['THN_PAJAK_SPPT'];
                $row[]              = number_format($sisa, 0, ',', '.');
                $row[]              = number_format($denda, 0, ',', '.');
                //$row[]              = number_format($nil_pengurang, 0, ',', '.');
                if ($thn_pjk == 2025 && $faktor_pengurang_sppt == 0 && $today <= 20250831 && $today >= 20250102) {
                    $row[]              = number_format($faktor_pengurang_baru, 0, ',', '.');
                } else {
                    $row[]              = number_format($nil_pengurang, 0, ',', '.');
                }
                $row[]              = number_format($utang, 0, ',', '.');
                $row[]              = $data['NM_WP_SPPT'];
                $row[]              = $data['JLN_WP_SPPT'];
                $output['aaData'][] = $row;

                $sisatot += $sisa;
                $dendatot += $denda;
                if ($thn_pjk == 2025 && $faktor_pengurang_sppt == 0 && $today <= 20250831 && $today >= 20250102) {
                    $nil_pengurangtot += $faktor_pengurang_baru;
                } else {
                    $nil_pengurangtot += $nil_pengurang;
                }
                //$nil_pengurangtot += $nil_pengurang;
                $utangtot += $utang;
            }

            $row   = array();
            $row[] = 'TOTAL';
            $row[] = '';
            $row[] = number_format($sisatot, 0, ',', '.');
            $row[] = number_format($dendatot, 0, ',', '.');
            $row[] = number_format($nil_pengurangtot, 0, ',', '.');
            $row[] = number_format($utangtot, 0, ',', '.');
            $row[] = '';
            $row[] = '';

            $output['aaData'][] = $row;

            echo json_encode($output);
            //	'terbilang'=>$terbilang
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
        $this->form_validation->set_rules('range1', 'NOP Awal', 'required|numeric');
        $this->form_validation->set_rules('range1', 'NOP Akhir', 'required|numeric');
        $this->form_validation->set_rules('tahun', 'Tahun', 'required|numeric');
    }

    function simpan()
    {
        if (!$this->module_auth->create) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_insert);
            redirect('pospbb_ora');
        }

        $data['faction'] = active_module_url('bayar_by_range_nop_thn/simpan');
        //$data['current'] = 'stts';
        $data['page_menu'] = 'm02_mn_stts';
        $data['current']   = 'bayar_by_range_nop_thn'; // stts        

        $nop = trim($this->input->post('prefix')) . trim($this->input->post('blok'));
        $nop = urldecode($nop);
        $nop = str_replace('.', '', $nop);
        $nop = str_replace(' ', '', $nop);
        $nop = str_replace('-', '', $nop);
        $nop = preg_replace('/[^0-9]/', '', $nop);

        $nop2 = trim($this->input->post('blok2')); // ini no urut
        $nop2 = urldecode($nop2);
        $nop2 = str_replace('.', '', $nop2);
        $nop2 = str_replace(' ', '', $nop2);
        $nop2 = str_replace('-', '', $nop2);
        $nop2 = preg_replace('/[^0-9]/', '', $nop2);

        $thn = $this->input->post('tahun');

        $kd_propinsi  = substr($nop, 0, 2);
        $kd_dati2     = substr($nop, 2, 2);
        $kd_kecamatan = substr($nop, 4, 3);
        $kd_kelurahan = substr($nop, 7, 3);
        $kd_blok      = substr($nop, 10, 3);
        $no_urut      = substr($nop, 13, 4);
        $kd_jns       = substr($nop, 17, 1);

        $no_urut_2 = substr($nop2, 0, 4);
        $kd_jns_2  = substr($nop2, 4, 1);

        $thn_pajak_sppt = $thn;

        if ($nop && $thn && $qry = $this->sppt_model->get_by_range_thn($nop, $nop2, $thn)) {

            $saved = array();
            $cetak = array();

            foreach ($qry['query'] as $row) {

                $kd_pelayanan = '00'; // default awal kode pelayanan 00=umum pembayaran normal
                $today = date('Ymd');
                $sisa_sppt  = 0;
                $denda      = 0;
                $denda_baru = 0;
                $nil_pengurang = 0;

                $sisa = (float) $row['PBB_YG_HARUS_DIBAYAR_SPPT'] - ($row['JML_SPPT_YG_DIBAYAR'] - (float) $row['DENDA_SPPT']);

                $sisa_sppt = $sisa;
                $jtempo    = date('Y-m-d', strtotime($row['TGL_JATUH_TEMPO_SPPT']));
                $faktor_pengurang_sppt = $row['FAKTOR_PENGURANG_SPPT'];

                // jika masih ada sisa piutang
                if ($sisa > 0) {

                    if ($jtempo < date('Y-m-d')) {

                        $denda = hitdenda($sisa, $jtempo);

                        if (KD_PROPINSI == '32' && KD_DATI2 == '03') {
                            // if ((int)$thn_pajak_sppt <= 2020 && $today <= 20210630 && $today >= 20210401) {
                            //     $denda = 0;
                            // }

                            //relaksasi 04062025 rican
                            if ((int)$thn_pajak_sppt == 2025 && $today <= 20250831 && $today >= 20200201 && $faktor_pengurang_sppt == 0 && $sisa > 0) {
                                $denda = 0;
                            }

                            if ((int)$thn_pajak_sppt >= 2020 && (int)$thn_pajak_sppt <= 2024 && $faktor_pengurang_sppt == 0 && $today <= 20250630 && $today >= 20250603 && $sisa > 0) {
                                $denda = 0;
                            }

                            if ((int)$thn_pajak_sppt >= 2020 && (int)$thn_pajak_sppt <= 2024 && $faktor_pengurang_sppt == 0 && $today <= 20250731 && $today >= 20250701 && $sisa > 0) {
                                $denda = 0;
                            }

                            if ((int)$thn_pajak_sppt >= 2020 && (int)$thn_pajak_sppt <= 2024 && $faktor_pengurang_sppt == 0 && $today <= 20250831 && $today >= 20250801 && $sisa > 0) {
                                $denda = 0;
                            }

                            if ((int)$thn_pajak_sppt >= 2012 && (int)$thn_pajak_sppt <= 2019 && $faktor_pengurang_sppt == 0 && $today <= 20250630 && $today >= 20250603 && $sisa > 0) {
                                $denda = 0;
                            }

                            if ((int)$thn_pajak_sppt >= 2012 && (int)$thn_pajak_sppt <= 2019 && $faktor_pengurang_sppt == 0 && $today <= 20250731 && $today >= 20250701 && $sisa > 0) {
                                $denda = 0;
                            }

                            if ((int)$thn_pajak_sppt >= 2012 && (int)$thn_pajak_sppt <= 2019 && $faktor_pengurang_sppt == 0 && $today <= 20250831 && $today >= 20250801 && $sisa > 0) {
                                $denda = 0;
                            }
                        }
                    }


                    // if (KD_PROPINSI == '32' && KD_DATI2 == '17' && $thn_pajak_sppt == 2020 && $faktor_pengurang_sppt == 0 && $today <= 20210630 && $today >= 20210401) {

                    //     $denda         = $denda + $denda_baru;
                    //     $utang         = $sisa + $denda;
                    //     $nil_pengurang = intval($utang * 5 / 100);
                    //     $utang         = $utang - $nil_pengurang;
                    //     $kd_pelayanan  = '01'; // kode pelayanan 01=Dapat Program Pengurangan karena Covid 19

                    // } else {
                    //     $denda = $denda + $denda_baru;
                    //     $utang = $sisa + $denda;
                    //     // $nil_pengurang = $query->faktor_pengurang_sppt;
                    //     $nil_pengurang = 0;
                    //     $utang         = $utang - $nil_pengurang;
                    // }

                    if ($thn_pajak_sppt == 2025 && $faktor_pengurang_sppt == 0 && $today <= 20250831 && $today >= 20250102 && $sisa > 0) {

                            $faktor_pengurang_lama = $faktor_pengurang_sppt;
                            $denda = $denda + $denda_baru;
                            $utang = $sisa + $denda;

                            $nil_pengurang = round($utang * 5/100);

                            $faktor_pengurang_baru = $faktor_pengurang_lama + $nil_pengurang;

                            $denda = round($denda * 5/100);

                            $utang = $utang - $nil_pengurang;
                        }
                        //2020-2024, 03 juni 25 - 30 juni 25
                        elseif ($thn_pajak_sppt >= 2020 && $thn_pajak_sppt <= 2024 && $faktor_pengurang_sppt == 0 && $today <= 20250630 && $today >= 20250603 && $sisa > 0) {

                            $denda = $denda + $denda_baru;
                            $utang     = $sisa + $denda;

                            $nil_pengurang = round($utang * 30/100);

                            $denda = round($denda * 30/100);

                            $utang = $utang - $nil_pengurang;

                        }
                        //2020-2024, 01 juli 25 - 31 juli 25
                        elseif ($thn_pajak_sppt >= 2020 && $thn_pajak_sppt <= 2024 && $faktor_pengurang_sppt == 0 && $today <= 20250731 && $today >= 20250701 && $sisa > 0) {

                            $denda = $denda + $denda_baru;
                            $utang     = $sisa + $denda;

                            $nil_pengurang = round($utang * 20/100);

                            $denda = round($denda * 20/100);

                            $utang = $utang - $nil_pengurang;
                        }
                        //2020-2024, 01 agus 25 - 31 agus 25
                        elseif ($thn_pajak_sppt >= 2020 && $thn_pajak_sppt <= 2024 && $faktor_pengurang_sppt == 0 && $today <= 20250831 && $today >= 20250801 && $sisa > 0) {

                            $denda = $denda + $denda_baru;
                            $utang     = $sisa + $denda;

                            $nil_pengurang = round($utang * 10/100);

                            $denda = round($denda * 10/100);

                            $utang = $utang - $nil_pengurang;
                        }
                        //2012-2019, 03 jun 25 - 30 jun 25
                        elseif ($thn_pajak_sppt >= 2012 && $thn_pajak_sppt <= 2019 && $faktor_pengurang_sppt == 0 && $today <= 20250630 && $today >= 20250603 && $sisa > 0) {

                            $denda = $denda + $denda_baru;
                            $utang     = $sisa + $denda;

                            $nil_pengurang = round($utang * 50/100);

                            $denda = round($denda * 50/100);

                            $utang = $utang - $nil_pengurang;
                        }
                        //2012-2019, 01 jul 25 - 31 jul 25
                        elseif ($thn_pajak_sppt >= 2012 && $thn_pajak_sppt <= 2019 && $faktor_pengurang_sppt == 0 && $today <= 20250731 && $today >= 20250701 && $sisa > 0) {

                            $denda = $denda + $denda_baru;
                            $utang     = $sisa + $denda;

                            $nil_pengurang = round($utang * 40/100);

                            $denda = round($denda * 40/100);

                            $utang = $utang - $nil_pengurang;
                        }
                        //2012-2019, 01 agus 25 - 31 agus 25
                        elseif ($thn_pajak_sppt >= 2012 && $thn_pajak_sppt <= 2019 && $faktor_pengurang_sppt == 0 && $today <= 20250831 && $today >= 20250801 && $sisa > 0) {

                            $denda = $denda + $denda_baru;
                            $utang     = $sisa + $denda;

                            $nil_pengurang = round($utang * 30/100);

                            $denda = round($denda * 30/100);

                            $utang = $utang - $nil_pengurang;
                        }
                        else {
                            $denda = $denda + $denda_baru;
                            $denda = 0;

                            $utang     = $sisa + $denda;
                            $terbilang = terbilang($utang);
                            // $nil_pengurang = $row['faktor_pengurang_sppt'];
                            $nil_pengurang = 0;
                            $utang = $utang - $nil_pengurang;
                            //$sisa = $sisa - $nil_pengurang - $denda;

                        }
                    //
                    $denda_sppt          = $denda;
                    $jml_sppt_yg_dibayar = $utang;
                    $tgl_pembayaran_sppt = current_date();
                    $tgl_rekam_byr_sppt  = current_time();

                    $nip_rekam_byr_sppt  = $this->session->userdata('nip');
                    $nopb                = $row['KODE']; // atau nopd
                    $no_urut             = $row['NO_URUT'];
                    $kd_jns_op           = $row['KD_JNS_OP'];

                    $pembayaran_sppt_ke = $this->payment_model->get_pembayaran_ke($nopb, $thn);

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
                        //'KD_PELAYANAN' => '00',
                        'PEMBAYARAN_SPPT_KE' => $pembayaran_sppt_ke,
                        'DENDA_SPPT' => $denda_sppt,
                        'FLG_STTS' => 3,

                        'PBB_TERHUTANG_SPPT' => $row['PBB_TERHUTANG_SPPT'],
                        'FAKTOR_PENGURANG_SPPT' => $row['FAKTOR_PENGURANG_SPPT'],
                        'PBB_YG_HARUS_DIBAYAR_SPPT' => $row['PBB_YG_HARUS_DIBAYAR_SPPT'],
                        'FAKTOR_PENGURANG_BAYAR' => $nil_pengurang,
                        'KD_PELAYANAN' => $kd_pelayanan,

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
                    $resultdb = $this->payment_model->add_bayar_per_nop($nopb, $thn, $sisa_sppt, $data, $hist_bayar_dt);
                    $res_hist = $this->payment_model->add_hist_bayar($hist_bayar_dt);

                    if (empty($resultdb) || empty($res_hist)) {
                        //set_msg_db_error($resultdb);
                        $success = "1";
                        // $this->payment_model->add_bayar_hist_stts($hist_bayar_dt);
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
                        if ($qctk = $this->payment_model->get_by_nop_thn_ke($nopb, $thn_pajak_sppt, $pembayaran_sppt_ke)) {
                            //$dctk = array();

                            $faktor_pengurang_bayar = $qctk->FAKTOR_PENGURANG_BAYAR; // blm diarahkan ke cetakan

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
            }
            $ret = array();
            $ret['simpan'] = 'sukses';
            $ret['saved']  = $saved;
            $ret['cetak']  = $cetak;
            echo json_encode($ret);

            // $this->cetak($saved);
        } else
            echo json_encode(array('simpan' => 'gagal'));
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
    public function cetak_pdf()
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
                    substr($param_x, 22, 1) . ")";
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

    public function cetak_bank()
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
                    substr($param_x, 22, 1) . ")";
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
