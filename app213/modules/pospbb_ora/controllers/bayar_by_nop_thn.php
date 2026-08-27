<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class bayar_by_nop_thn extends CI_Controller
{

    private $module = 'bayar_by_nop_thn';

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

        //$module = 'bayar_by_nop_thn';
        $this->load->library('module_auth', array('module' => $this->module));

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
        $data['current']   = $this->module; // stts

        $filter         = $this->session->userdata('pos_filter');
        $filter         = isset($filter) ? $filter : '';
        $data['filter'] = $filter;
        $data['prefix'] = KD_PROPINSI . "." . KD_DATI2;
        $data['tpnm']   = isset($this->session->userdata['tpnm']) ? $this->session->userdata['tpnm'] : '';

        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = active_module_url('bayar_by_nop_thn/update_pmd');
        //$data['current'] = 'stts';

        $this->load->view('bayar_by_nop_thn/vbayar_by_nop_thn', $data);
    }

    public function cari()
    {

        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect('pospbb_ora');
        }

        $nop = $this->uri->segment(4);
        $thn = $this->uri->segment(5);

        if ($nop && $thn && $query = $this->sppt_model->get_by_nop_thn($nop, $thn)) {
            //
            $nil_pengurang = 0;
            $denda_baru = 0;
            $denda = 0;
            $today = date('Ymd');
            $sisa = (float) $query->PBB_YG_HARUS_DIBAYAR_SPPT - ($query->JML_SPPT_YG_DIBAYAR - (float) $query->DENDA_SPPT);

            $jtempo   = date('Y-m-d', strtotime($query->TGL_JATUH_TEMPO_SPPT));

            if ($jtempo && $jtempo < date('Y-m-d')) {

                $xx = date('Y-m-d', strtotime('2024-08-31'));   
                $yy = date('Y-m-d', strtotime($jtempo));

                if($xx == $yy){
                    $jt = "2024-09-02 00:00:00";
                }

                $denda = hitdenda($sisa, $jtempo);

                // Penghapusan denda u. periode tertentu
                if (KD_PROPINSI == '32' && KD_DATI2 == '03') {
                    // jika Thn Pajak di bawah 2015 dan pemby di dlm range 01-02-2020 sd 30-06-2020
                    if ((int)$thn <= 2021 && $today <= 20210630 && $today >= 20210401) {
                        $denda = 0;
                    }

                    //relaksasi 04062025 rican
                    if ((int)$thn == 2025 && $today <= 20250831 && $today >= 20200201 && $query->FAKTOR_PENGURANG_SPPT == 0 && $sisa > 0) {
                        $denda = 0;
                    }

                    if ((int)$thn >= 2020 && (int)$thn <= 2024 && $query->FAKTOR_PENGURANG_SPPT == 0 && $today <= 20250630 && $today >= 20250603 && $sisa > 0) {
                        $denda = 0;
                    }

                    if ((int)$thn >= 2020 && (int)$thn <= 2024 && $query->FAKTOR_PENGURANG_SPPT == 0 && $today <= 20250731 && $today >= 20250701 && $sisa > 0) {
                        $denda = 0;
                    }

                    if ((int)$thn >= 2020 && (int)$thn <= 2024 && $query->FAKTOR_PENGURANG_SPPT == 0 && $today <= 20250831 && $today >= 20250801 && $sisa > 0) {
                        $denda = 0;
                    }

                    if ((int)$thn >= 2012 && (int)$thn <= 2019 && $query->FAKTOR_PENGURANG_SPPT == 0 && $today <= 20250630 && $today >= 20250603 && $sisa > 0) {
                        $denda = 0;
                    }

                    if ((int)$thn >= 2012 && (int)$thn <= 2019 && $query->FAKTOR_PENGURANG_SPPT == 0 && $today <= 20250731 && $today >= 20250701 && $sisa > 0) {
                        $denda = 0;
                    }

                    if ((int)$thn >= 2012 && (int)$thn <= 2019 && $query->FAKTOR_PENGURANG_SPPT == 0 && $today <= 20250831 && $today >= 20250801 && $sisa > 0) {
                        $denda = 0;
                    }

                }
            }

            // TAMBAHAN RELAKSASI syarat inti faktor pengurang harus 0
            // if (KD_PROPINSI == '32' && KD_DATI2 == '171' && $thn == 2020 && $query->FAKTOR_PENGURANG_SPPT == 0 && $today <= 20210630 && $today >= 20210401) {

            //     $denda         = $denda + $denda_baru;
            //     $utang         = $sisa + $denda;
            //     $nil_pengurang = intval($utang * 5 / 100); // pengurang 5%
            //     $utang         = $utang - $nil_pengurang;
            //     $terbilang     = terbilang($utang);
            //     // Denda setelah dikurangi relaksasi seharusnya ???
            //     //$denda       = $denda - intval($denda * 5/100);

            // } else {
            //     $denda     = $denda + $denda_baru;
            //     $utang     = $sisa + $denda;
            //     $terbilang = terbilang($utang);
            //     $nil_pengurang = 0;
            // }

            //relaksasi 04062025 rican
            //2025, 02 jan 25 - 31 agus 25
            if ($thn == 2025 && $query->FAKTOR_PENGURANG_SPPT == 0 && $today <= 20250831 && $today >= 20250102 && $sisa > 0) {

                $faktor_pengurang_lama = $query->FAKTOR_PENGURANG_SPPT;
                $denda = $denda + $denda_baru;
                $utang = $sisa + $denda;

                $nil_pengurang = round($utang * 5/100);

                $faktor_pengurang_baru = $faktor_pengurang_lama + $nil_pengurang;

                $denda = round($denda * 5/100);

                $utang = $utang - $nil_pengurang;

                $terbilang = terbilang($utang);

                $sisa = $sisa - $nil_pengurang;
            }
            //2020-2024, 03 juni 25 - 30 juni 25
            elseif ($thn >= 2020 && $thn <= 2024 && $query->FAKTOR_PENGURANG_SPPT == 0 && $today <= 20250630 && $today >= 20250603 && $sisa > 0) {

                $denda = $denda + $denda_baru;
                $utang     = $sisa + $denda;

                $nil_pengurang = round($utang * 30/100);

                $denda = round($denda * 30/100);

                $utang = $utang - $nil_pengurang;

                $terbilang = terbilang($utang);

                $sisa = $sisa - $nil_pengurang;

            }
            //2020-2024, 01 juli 25 - 31 juli 25
            elseif ($thn >= 2020 && $thn <= 2024 && $query->FAKTOR_PENGURANG_SPPT == 0 && $today <= 20250731 && $today >= 20250701 && $sisa > 0) {

                $denda = $denda + $denda_baru;
                $utang     = $sisa + $denda;
                //var_dump($denda_baru);die;
                $nil_pengurang = round($utang * 20/100);

                $denda = round($denda * 20/100);

                $utang = $utang - $nil_pengurang;

                $terbilang = terbilang($utang);

                $sisa = $sisa - $nil_pengurang;
            }
            //2020-2024, 01 agus 25 - 31 agus 25
            elseif ($thn >= 2020 && $thn <= 2024 && $query->FAKTOR_PENGURANG_SPPT == 0 && $today <= 20250831 && $today >= 20250801 && $sisa > 0) {

                $denda = $denda + $denda_baru;
                $utang     = $sisa + $denda;

                $nil_pengurang = round($utang * 10/100);

                $denda = round($denda * 10/100);

                $utang = $utang - $nil_pengurang;

                $terbilang = terbilang($utang);

                $sisa = $sisa - $nil_pengurang;
            }
            //2012-2019, 03 jun 25 - 30 jun 25
            elseif ($thn >= 2012 && $thn <= 2019 && $query->FAKTOR_PENGURANG_SPPT == 0 && $today <= 20250630 && $today >= 20250603 && $sisa > 0) {

                $denda = $denda + $denda_baru;
                $utang     = $sisa + $denda;

                $nil_pengurang = round($utang * 50/100);

                $denda = round($denda * 50/100);

                $utang = $utang - $nil_pengurang;

                $terbilang = terbilang($utang);

                $sisa = $sisa - $nil_pengurang;
            }
            //2012-2019, 01 jul 25 - 31 jul 25
            elseif ($thn >= 2012 && $thn <= 2019 && $query->FAKTOR_PENGURANG_SPPT == 0 && $today <= 20250731 && $today >= 20250701 && $sisa > 0) {

                $denda = $denda + $denda_baru;
                $utang     = $sisa + $denda;

                $nil_pengurang = round($utang * 40/100);

                $denda = round($denda * 40/100);

                $utang = $utang - $nil_pengurang;

                $terbilang = terbilang($utang);

                $sisa = $sisa - $nil_pengurang;
            }
            //2012-2019, 01 agus 25 - 31 agus 25
            elseif ($thn >= 2012 && $thn <= 2019 && $query->FAKTOR_PENGURANG_SPPT == 0 && $today <= 20250831 && $today >= 20250801 && $sisa > 0) {

                $denda = $denda + $denda_baru;
                $utang     = $sisa + $denda;

                $nil_pengurang = round($utang * 30/100);

                $denda = round($denda * 30/100);

                $utang = $utang - $nil_pengurang;

                $terbilang = terbilang($utang);

                $sisa = $sisa - $nil_pengurang;
            }
            else {
                $denda = $denda + $denda_baru;
                $denda = 0;

                $utang     = $sisa + $denda;
                $terbilang = terbilang($utang);
                // $nil_pengurang = $query->FAKTOR_PENGURANG_SPPT;
                $nil_pengurang = 0;
                //$sisa = $sisa - $nil_pengurang - $denda;

            }

            if ($thn == 2025 && $query->FAKTOR_PENGURANG_SPPT == 0 && $today <= 20250831 && $today >= 20250102) {
            // if ($thn == 2025 && $today <= 20250331 && $today >= 20250102) {
                $query     = (object) array_merge((array) $query, array(
                    'found' => 1,
                    'sisa' => $sisa,
                    'denda' => $denda,
                    'utang' => $utang,
                    'terbilang' => $terbilang,
                    'nilai_pengurang' => $faktor_pengurang_baru,
                ));
            } else {
                $query     = (object) array_merge((array) $query, array(
                    'found' => 1,
                    'sisa' => $sisa,
                    'denda' => $denda,
                    'utang' => $utang,
                    'terbilang' => $terbilang,
                    'nilai_pengurang' => $nil_pengurang,
                ));
            }

            // $query = (object) array_merge((array) $query, array(
            //     'found' => 1,
            //     'sisa' => $sisa,
            //     'denda' => $denda,
            //     'utang' => $utang,
            //     'terbilang' => $terbilang,
            //     'nilai_pengurang' => $nil_pengurang,
            // ));
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
            redirect('pospbb_ora');
        }

        $data['faction'] = active_module_url('bayar_by_nop_thn/update_pmd');
        //$data['current'] = 'stts';
        $data['page_menu'] = 'm02_mn_stts';
        $data['current']   = $this->module;

        $this->fvalidation();

        if ($this->form_validation->run() == TRUE) {

            $nop = trim($this->input->post('prefix')) . trim($this->input->post('nop'));
            $nop1 = urldecode($nop);
            $nop = preg_replace('/[^0-9]/', '', $nop1);
            $thn = $this->input->post('tahun');
			$today = date('Ymd');

            $kd_propinsi    = substr($nop, 0, 2);
            $kd_dati2       = substr($nop, 2, 2);
            $kd_kecamatan   = substr($nop, 4, 3);
            $kd_kelurahan   = substr($nop, 7, 3);
            $kd_blok        = substr($nop, 10, 3);
            $no_urut        = substr($nop, 13, 4);
            $kd_jns_op      = substr($nop, -1);
            $thn_pajak_sppt = $thn;

            $denda_sppt          = (float) preg_replace('/[^0-9]/', '', $this->input->post('denda'));
            $jml_sppt_yg_dibayar = (float) preg_replace('/[^0-9]/', '', $this->input->post('utang'));
			$udh_bayar = (float) preg_replace('/[^0-9]/', '', $this->input->post('pembayaran'));

            $kd_pelayanan = '00'; // default awal kode pelayanan 00=umum pembayaran normal

            if ($nop && $thn && $query = $this->sppt_model->get_by_nop_thn($nop, $thn)) {

                $sisa  = (float) $query->PBB_YG_HARUS_DIBAYAR_SPPT - ($query->JML_SPPT_YG_DIBAYAR - (float) $query->DENDA_SPPT);

                $sisa_sppt = $sisa;
                $denda = 0;
                $denda_baru = 0;
                $nil_pengurang = 0;
                $jtempo = date('Y-m-d', strtotime($query->TGL_JATUH_TEMPO_SPPT));

                if ($jtempo < date('Y-m-d')) {

                    $denda = hitdenda($sisa, $jtempo);

                    if (KD_PROPINSI == '32' && KD_DATI2 == '03') {
                        // jika Thn Pajak di bawah 2015 dan pemby di dlm range 01-02-2020 sd 30-06-2020
                        if ((int)$thn <= 2099 && $today <= 20210630 && $today >= 20210401) {
                            $denda = 0;
                        }
						
						//relaksasi 04062025 rican
						if ((int)$thn == 2025 && $today <= 20250831 && $today >= 20200201 && $query->FAKTOR_PENGURANG_SPPT == 0 && $sisa > 0) {
							$denda = 0;
						}

						if ((int)$thn >= 2020 && (int)$thn <= 2024 && $query->FAKTOR_PENGURANG_SPPT == 0 && $today <= 20250630 && $today >= 20250603 && $sisa > 0) {
							$denda = 0;
						}

						if ((int)$thn >= 2020 && (int)$thn <= 2024 && $query->FAKTOR_PENGURANG_SPPT == 0 && $today <= 20250731 && $today >= 20250701 && $sisa > 0) {
							$denda = 0;
						}

						if ((int)$thn >= 2020 && (int)$thn <= 2024 && $query->FAKTOR_PENGURANG_SPPT == 0 && $today <= 20250831 && $today >= 20250801 && $sisa > 0) {
							$denda = 0;
						}

						if ((int)$thn >= 2012 && (int)$thn <= 2019 && $query->FAKTOR_PENGURANG_SPPT == 0 && $today <= 20250630 && $today >= 20250603 && $sisa > 0) {
							$denda = 0;
						}

						if ((int)$thn >= 2012 && (int)$thn <= 2019 && $query->FAKTOR_PENGURANG_SPPT == 0 && $today <= 20250731 && $today >= 20250701 && $sisa > 0) {
							$denda = 0;
						}

						if ((int)$thn >= 2012 && (int)$thn <= 2019 && $query->FAKTOR_PENGURANG_SPPT == 0 && $today <= 20250831 && $today >= 20250801 && $sisa > 0) {
							$denda = 0;
						}
                    }
                }

                // PENGURANGAN BARU _edSen 31032021
                if (KD_PROPINSI == '32' && KD_DATI2 == '171' && $thn == 2020 && $query->FAKTOR_PENGURANG_SPPT == 0 && $today <= 20210630 && $today >= 20210401) {
                    // TGL PEMB 1 Jan 2021 - 31 mar 2021
                    $denda         = $denda + $denda_baru;
                    $utang         = $sisa + $denda;
                    $nil_pengurang = intval($utang * 5 / 100);  // pengurang 5%
                    $utang         = $utang - $nil_pengurang;
                    $terbilang     = terbilang($utang);
                    $kd_pelayanan = '01'; // kode pelayanan 01=Dapat Program Pengurangan karena Covid 19
                } else {
                    $denda = $denda + $denda_baru;
                    $utang = $sisa + $denda;
                    $terbilang = terbilang($utang);
                    $nil_pengurang = 0;
                }
				
				//relaksasi 04062025 rican
				//2025, 02 jan 25 - 31 agus 25
				if ($thn == 2025 && $query->FAKTOR_PENGURANG_SPPT == 0 && $today <= 20250831 && $today >= 20250102 && $sisa > 0) {

					$faktor_pengurang_lama = $query->FAKTOR_PENGURANG_SPPT;
					$denda = $denda + $denda_baru;
					$utang = $sisa + $denda;

					$nil_pengurang = round($utang * 5/100);

					$faktor_pengurang_baru = $faktor_pengurang_lama + $nil_pengurang;

					$denda = round($denda * 5/100);

					$utang = $utang - $nil_pengurang;

					$terbilang = terbilang($utang);

					$sisa = $sisa - $nil_pengurang;
				}
				//2020-2024, 03 juni 25 - 30 juni 25
				elseif ($thn >= 2020 && $thn <= 2024 && $query->FAKTOR_PENGURANG_SPPT == 0 && $today <= 20250630 && $today >= 20250603 && $sisa > 0) {

					$denda = $denda + $denda_baru;
					$utang     = $sisa + $denda;

					$nil_pengurang = round($utang * 30/100);

					$denda = round($denda * 30/100);

					$utang = $utang - $nil_pengurang;

					$terbilang = terbilang($utang);

					$sisa = $sisa - $nil_pengurang;

				}
				//2020-2024, 01 juli 25 - 31 juli 25
				elseif ($thn >= 2020 && $thn <= 2024 && $query->FAKTOR_PENGURANG_SPPT == 0 && $today <= 20250731 && $today >= 20250701 && $sisa > 0) {

					$denda = $denda + $denda_baru;
					$utang     = $sisa + $denda;
					//var_dump($denda_baru);die;
					$nil_pengurang = round($utang * 20/100);

					$denda = round($denda * 20/100);

					$utang = $utang - $nil_pengurang;

					$terbilang = terbilang($utang);

					$sisa = $sisa - $nil_pengurang;
				}
				//2020-2024, 01 agus 25 - 31 agus 25
				elseif ($thn >= 2020 && $thn <= 2024 && $query->FAKTOR_PENGURANG_SPPT == 0 && $today <= 20250831 && $today >= 20250801 && $sisa > 0) {

					$denda = $denda + $denda_baru;
					$utang     = $sisa + $denda;

					$nil_pengurang = round($utang * 10/100);

					$denda = round($denda * 10/100);

					$utang = $utang - $nil_pengurang;

					$terbilang = terbilang($utang);

					$sisa = $sisa - $nil_pengurang;
				}
				//2012-2019, 03 jun 25 - 30 jun 25
				elseif ($thn >= 2012 && $thn <= 2019 && $query->FAKTOR_PENGURANG_SPPT == 0 && $today <= 20250630 && $today >= 20250603 && $sisa > 0) {

					$denda = $denda + $denda_baru;
					$utang     = $sisa + $denda;

					$nil_pengurang = round($utang * 50/100);

					$denda = round($denda * 50/100);

					$utang = $utang - $nil_pengurang;

					$terbilang = terbilang($utang);

					$sisa = $sisa - $nil_pengurang;
				}
				//2012-2019, 01 jul 25 - 31 jul 25
				elseif ($thn >= 2012 && $thn <= 2019 && $query->FAKTOR_PENGURANG_SPPT == 0 && $today <= 20250731 && $today >= 20250701 && $sisa > 0) {

					$denda = $denda + $denda_baru;
					$utang     = $sisa + $denda;

					$nil_pengurang = round($utang * 40/100);

					$denda = round($denda * 40/100);

					$utang = $utang - $nil_pengurang;

					$terbilang = terbilang($utang);

					$sisa = $sisa - $nil_pengurang;
				}
				//2012-2019, 01 agus 25 - 31 agus 25
				elseif ($thn >= 2012 && $thn <= 2019 && $query->FAKTOR_PENGURANG_SPPT == 0 && $today <= 20250831 && $today >= 20250801 && $sisa > 0) {

					$denda = $denda + $denda_baru;
					$utang     = $sisa + $denda;

					$nil_pengurang = round($utang * 30/100);

					$denda = round($denda * 30/100);

					$utang = $utang - $nil_pengurang;

					$terbilang = terbilang($utang);

					$sisa = $sisa - $nil_pengurang;
				}
				else {
					$denda = $denda + $denda_baru;
					$denda = 0;

					$utang     = $sisa + $denda;
					$terbilang = terbilang($utang);
					// $nil_pengurang = $query->FAKTOR_PENGURANG_SPPT;
					$nil_pengurang = 0;
					//$sisa = $sisa - $nil_pengurang - $denda;

				}

                $data['sisa'] = $denda_sppt;

                //if ($sisa < 1 or (float)$jml_sppt_yg_dibayar <> (float)($sisa + $denda - $nil_pengurang) or (float) $denda <> (float)$denda_sppt) {
                //    //if ($sisa < 1 or (float)$jml_sppt_yg_dibayar<> (float)($sisa + $denda) or (float) $denda <> (float)$denda_sppt) {
                //    $data['yes'] = "no";
                //    echo json_encode($data);
                //    exit;
                //}

                $tgl_pembayaran_sppt = current_date(); //date('Y-m-d');
                $tgl_rekam_byr_sppt  = current_time(); //date('Y-m-d h:i:sa');
                $nip_rekam_byr_sppt  = $this->session->userdata('nip');
                $pembayaran_sppt_ke  = $this->payment_model->get_pembayaran_ke($nop, $thn);

                //buat history di pos pst HIST_PEMBAYARAN_SPPT
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
                    // 'CREATED_DATE' => NULL,
                    'PEMBAYARAN_SPPT_KE' => $pembayaran_sppt_ke,
                    'DENDA_SPPT' => $denda_sppt,
                    'FLG_STTS' => 1,
                    'PBB_TERHUTANG_SPPT' => $query->PBB_TERHUTANG_SPPT,
                    'FAKTOR_PENGURANG_SPPT' => $query->FAKTOR_PENGURANG_SPPT,
                    'PBB_YG_HARUS_DIBAYAR_SPPT' => $query->PBB_YG_HARUS_DIBAYAR_SPPT,
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
                // catatan : u. sppt tdk perlu di update sdh di cover di trigger pembayaran termasuk nilai pengurangan jika ada
                $resultdb = $this->payment_model->add_bayar_per_nop($nop, $thn, $sisa_sppt, $data, $hist_bayar_dt);
				$res_hist = $this->payment_model->add_hist_bayar($hist_bayar_dt);
                //log_message('info', "AAAAAAAAAAAAAAAAAA  resultdb : ".$resultdb);
				
                if (!empty($resultdb) && !empty($res_hist)) {
                    set_msg_db_error($resultdb);
					set_msg_db_error($res_hist);
                    $data['yes'] = "no";
                    echo json_encode($data);
                } else {
                    //ga perlu sdh di handle di pembayaran trigger
                    //if($nil_pengurang > 0){
                    //    $this->payment_model->upd_sppt_faktor_pengurang($nop, $thn, $nil_pengurang);
                    //}

                    // $this->payment_model->add_bayar_hist_stts($hist_bayar_dt);
					
					$data['nop'] = $nop;
					$data['thn'] = $thn;
					$data['ke']  = $pembayaran_sppt_ke;
					$data['yes'] = "yes";
					echo json_encode($data);
					
                }
                /*
                $data['nop'] = $nop;
                $data['thn'] = $thn;
                $data['ke']  = $pembayaran_sppt_ke;
                $data['yes'] = "yes";
                echo json_encode($data);
                */
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

            $sn = date('dmY', strtotime($query->tgl_pembayaran_sppt));
            $sn .= $kdprop . $kddati . $kdkec . $kdkel . $kdblok . $nourut . $jns . $thn;

            //tambahan terbilang
            $terbilang = terbilang($query->jml_sppt_yg_dibayar);

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
