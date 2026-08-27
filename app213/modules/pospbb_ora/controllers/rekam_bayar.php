<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class rekam_bayar extends CI_Controller
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

        $module = 'POSBYR_BND';
        $this->load->library('module_auth', array(
            'module' => $module
        ));
        $this->load->helper('sipkd_helper');

        $this->load->model(array(
            'apps_model'
        ));
        $this->load->model(array(
            'sppt_model',
            'payment_model'
        ));
    }

    public function index()
    {
        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect('info');
        }

        $filter         = $this->session->userdata('pos_filter');
        $filter         = isset($filter) ? $filter : '';
        $data['filter'] = $filter;
        $data['prefix'] = KD_PROPINSI . "." . KD_DATI2;
        $data['tpnm']   = isset($this->session->userdata['tpnm']) ? $this->session->userdata['tpnm'] : '';

        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = active_module_url('rekam_bayar/update_pmd');
        $data['current'] = 'stts';

        $this->load->view('rekam_bayar/rekam_bayarv', $data);
    }

    public function cari()
    {
        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect('info');
        }

        $nop = $this->uri->segment(4);
        $thn = $this->uri->segment(5);
        $tgl_byr = $this->uri->segment(6);

        if ($nop && $thn && $query = $this->sppt_model->get_by_nop_thn($nop, $thn)) {
            //

            $sisa  = (float) $query->PBB_YG_HARUS_DIBAYAR_SPPT - ($query->JML_SPPT_YG_DIBAYAR - (float) $query->DENDA_SPPT);

            $denda_baru = 0;

            $nil_pengurang = 0;

            // if ($nop && $thn && $sql = $this->sppt_model->get_denda($nop, $thn)) {
            //     $denda_baru = (float) $sql->DENDA_BARU;
            // }

            // var_dump('ok');die;

            $denda = 0;
            $today = date('Ymd');
            $tgl_byr = date('Y-m-d', strtotime($tgl_byr));
            $jt = $query->TGL_JATUH_TEMPO_SPPT;

            $jtempo   = date('Y-m-d', strtotime($query->TGL_JATUH_TEMPO_SPPT));
            if ($jt && date($jt) < $tgl_byr) {

                //// PENGHAPUSAN DENDA SPPT 2024 JT TEMPO TGL 31 AGUSTUS 2024 
                //// JT TEMPO TGL 31-08-2024 diubah jadi 02-09-2024 REQ BANG JO _edSen 28082024
                $xx = date('Y-m-d', strtotime('2024-08-31'));
                $yy = date('Y-m-d', strtotime($jt));

                if ($xx == $yy) {
                    $jt = "2024-09-02 00:00:00";
                }

                // $denda = hitdenda_manual($sisa, $jt, $tgl_byr);

                $denda = hitdenda($sisa, $jtempo);

                //// nilai denda terbaru HKPD 2024
                //// pake query aja hitung di postgres (di php masih eror)
                // $denda = $this->sppt_model->hit_denda_hkpd($sisa, date($jt), date('Y-m-d'), 'n')->result;
                // tetep pake yg lama.. dirubah di helpernya ajah...

                //Pemda Bogor arig 26/02/2019
                //// GAK PAKE PENGECEKAN PENGHAPUSAN DENDA _edSen 16092021
                //// UJUNGNYA PAKE JUGA hohoho... (REQ tgl 28092021)
                if (KD_PROPINSI == '32' && KD_DATI2 == '03') {


                    // // jika Thn Pajak di bawah 2012 dan pemby di dlm range 01-03-2019 sd 30-06-2019
                    // // if((int)$thn <= 2011 && $today <= 20190630 && $today >= 20190301) {
                    // //     $denda = 0;
                    // // }
                    // // jika Thn Pajak di bawah 2015 dan pemby di dlm range 01-02-2020 sd 30-06-2020
                    // if((int)$thn <= 2015 && $today <= 20200630 && $today >= 20200201) {
                    //     $denda = 0;
                    // }
                    //
                    // if((int)$thn <= 2019 && $today <= 20200831 && $today >= 20200701) {
                    //     $denda = 0;
                    // }
                    //
                    // if( ( (int)$thn >= 2012 || (int)$thn <= 2020 ) && $today <= 20210331 && $today >= 20210104) {
                    //     $denda = 0;
                    // }
                    //
                    // // if( (int)$thn < 2012 && $today <= 20211231 && $today >= 20210104) {
                    // //     $denda = 0;
                    // // }
                    //
                    // //// PENGHAPUSAN DENDA BARU _edSen 31032021
                    // if( ( (int)$thn >= 2017 || (int)$thn <= 2020 ) && $today <= 20210831 && $today >= 20210401) {
                    //     $denda = 0;
                    // }
                    if (((int)$thn >= 2017 || (int)$thn <= 2021) && $today <= 20211031 && $today >= 20210901) {
                        $denda = 0;
                    }

                    if ((int)$thn <= 2016 && $today <= 20211231 && $today >= 20210401) {
                        $denda = 0;
                    }
                }
            }


            //// TAMBAHAN RELAKSASI _edSen 31032021
            // GAK PAKE PENGECEKAN PENGURANGAN COVID _edSen 16092021
            //// UJUNGNYA PAKE JUGA hohoho... (REQ tgl 28092021)
            // if($thn == 2021 && $query->faktor_pengurang_sppt == 0 && $today <= 20210831 && $today >= 20210401 ){
            //     $denda = $denda + $denda_baru;
            //     $utang     = $sisa + $denda;
            //     $nil_pengurang = intval($utang * 5/100);
            //     $denda = intval($denda * 5/100);
            //     $utang = $utang - $nil_pengurang;
            //     $terbilang = terbilang($utang);
            // }
            // else

            //// TAMBAHAN RELAKSASI _edSen 23122024
            //// CASE KHUSUS 2025 PENGURANGAN AMBIL SEMUA DATA (TIDAK AMBIL FAKTOR PENGURANG YANG 0) 
            //// NANTI FAKTOR PENGURANG BARU DITAMBAHIN DENGAN FAKTOR PENGURANG LAMA
            //// FAKTOR PENGURANG 5% dari pbb_yg_hrs_dibayar_sppt
            //// _edSen REQ PAK EKI 24122024
            if ($thn == 2025 && $today <= 20250331 && $today >= 20250102) {
                // TGL PEMB 2 Jan 2025 - 31 mar 2025
                $faktor_pengurang_lama = $query->FAKTOR_PENGURANG_SPPT;

                $denda = $denda + $denda_baru;
                $utang     = $sisa + $denda;
                $nil_pengurang = intval($utang * 5 / 100);
                $denda = intval($denda * 5 / 100);
                $utang = $utang - $nil_pengurang;
                $terbilang = terbilang($utang);

                $faktor_pengurang_baru = $faktor_pengurang_lama + $nil_pengurang;
            } elseif ($thn <= 2016 && $query->FAKTOR_PENGURANG_SPPT == 0 && $today <= 20211231 && $today >= 20210401) {
                $denda = $denda + $denda_baru;
                $utang     = $sisa + $denda;
                $nil_pengurang = intval($utang * 20 / 100);
                $denda = intval($denda * 20 / 100);
                $utang = $utang - $nil_pengurang;
                $terbilang = terbilang($utang);
            } else {
                $denda = $denda + $denda_baru;
                $utang     = $sisa + $denda;
                $terbilang = terbilang($utang);
                // $nil_pengurang = $query->faktor_pengurang_sppt;
                $nil_pengurang = 0;
            }

            // $denda = $denda + $denda_baru;
            // $utang     = $sisa + $denda;
            // $terbilang = terbilang($utang);

            if ($thn == 2025 && $today <= 20250331 && $today >= 20250102) {
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

            // var_dump($query);die;

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

        $data['faction'] = active_module_url('rekam_bayar/update_pmd');
        $data['current'] = 'stts';


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
            $jml_byr             = (float) preg_replace('/[^0-9]/', '', $this->input->post('jml_byr'));
            $tgl_byr             = date('Y-m-d', strtotime($this->input->post('tgl_byr')));


            if ($nop && $thn && $query = $this->sppt_model->get_by_nop_thn($nop, $thn)) {
                $sisa  = (float) $query->PBB_YG_HARUS_DIBAYAR_SPPT - ($query->JML_SPPT_YG_DIBAYAR - (float) $query->DENDA_SPPT);

                $denda_baru = 0;

                $nil_pengurang = 0;



                if ($nop && $thn && $sql = $this->sppt_model->get_denda($nop, $thn)) {
                    $denda_baru = (float) $sql->DENDA_BARU;
                }
                $denda = 0;
                if (date($query->TGL_JATUH_TEMPO_SPPT) < $tgl_byr) {

                    //// PENGHAPUSAN DENDA SPPT 2024 JT TEMPO TGL 31 AGUSTUS 2024 
                    //// JT TEMPO TGL 31-08-2024 diubah jadi 02-09-2024 REQ BANG JO _edSen 28082024
                    $jt = $query->TGL_JATUH_TEMPO_SPPT;
                    $xx = date('Y-m-d', strtotime('2024-08-31'));
                    $yy = date('Y-m-d', strtotime($jt));


                    if ($xx == $yy) {
                        $jt = "2024-09-02 00:00:00";
                    }

                    $denda = hitdenda_manual($sisa, $jt, $tgl_byr);

                    //// nilai denda terbaru HKPD 2024
                    //// pake query aja hitung di postgres (di php masih eror)
                    // $denda = $this->sppt_model->hit_denda_hkpd($sisa, date($query->tgl_jatuh_tempo_sppt), date('Y-m-d'), 'n')->result;
                    // tetep pake yg lama.. dirubah di helpernya ajah...

                    //Pemda Bogor arig 26/02/2019
                    //// GAK PAKE PENGECEKAN PENGHAPUSAN DENDA _edSen 16092021
                    //// UJUNGNYA PAKE JUGA hohoho... (REQ tgl 28092021)
                    if (KD_PROPINSI == '32' && KD_DATI2 == '03') {

                        // // jika Thn Pajak di bawa 2012 dan pemby di dlm range 01-03-2019 sd 30-06-2019
                        // // if((int)$thn <= 2011 && $today <= 20190630 && $today >= 20190301) {
                        // //     $denda = 0;
                        // // }
                        // // jika Thn Pajak di bawah 2015 dan pemby di dlm range 01-02-2020 sd 30-06-2020
                        // if((int)$thn <= 2015 && $today <= 20200630 && $today >= 20200201) {
                        //     $denda = 0;
                        // }
                        //
                        // if((int)$thn <= 2019 && $today <= 20200831 && $today >= 20200701) {
                        //     $denda = 0;
                        // }
                        //
                        // if( ( (int)$thn >= 2012 || (int)$thn <= 2020 ) && $today <= 20210331 && $today >= 20210104) {
                        //     $denda = 0;
                        // }
                        //
                        // // if( (int)$thn < 2012 && $today <= 20211231 && $today >= 20210104) {
                        // //     $denda = 0;
                        // // }
                        //
                        // ////// PENGHAPUSAN DENDA BARU _edSen 31032021
                        // if( ( (int)$thn >= 2017 || (int)$thn <= 2020 ) && $today <= 20210831 && $today >= 20210401) {
                        //     $denda = 0;
                        // }
                        if (((int)$thn >= 2017 || (int)$thn <= 2021) && $today <= 20211031 && $today >= 20210901) {
                            $denda = 0;
                            $denda_sppt = 0;
                        }

                        if ((int)$thn <= 2016 && $today <= 20211231 && $today >= 20210401) {
                            $denda = 0;
                            $denda_sppt = 0;
                        }
                    }
                }

                //// PENGURANGAN BARU _edSen 31032021
                //// GAK PAKE PENGECEKAN PENGURANGAN COVID _edSen 16092021
                //// UJUNGNYA PAKE JUGA hohoho... (REQ tgl 28092021)
                // if($thn == 2021 && $query->faktor_pengurang_sppt == 0 && $today <= 20210831 && $today >= 20210401 ){
                //     // TGL PEMB 1 Jan 2021 - 31 mar 2021
                //     $denda = $denda + $denda_baru;
                //     $utang = $sisa+$denda;
                //     // $terbilang = terbilang($utang);
                //     $nil_pengurang = intval($utang * 5/100);
                //     $denda = intval($denda * 5/100);
                //     $utang = $utang - $nil_pengurang;
                //     $terbilang = terbilang($utang);
                // } else

                //// PENGURANGAN BARU _edSen 23122024
                if ($thn == 2025 && $today <= 20250331 && $today >= 20250102) {
                    // TGL PEMB 2 Jan 2025 - 31 mar 2025
                    $faktor_pengurang_lama = $query->FAKTOR_PENGURANG_SPPT;

                    $denda = $denda_sppt + $denda_baru;
                    $utang = $sisa + $denda;
                    // $terbilang = terbilang($utang);
                    $nil_pengurang = intval($utang * 5 / 100);
                    $denda = intval($denda * 5 / 100);
                    $utang = $utang - $nil_pengurang;
                    $terbilang = terbilang($utang);

                    $faktor_pengurang_baru = $faktor_pengurang_lama + $nil_pengurang;
                } elseif ($thn <= 2016 && $query->FAKTOR_PENGURANG_SPPT == 0 && $today <= 20211231 && $today >= 20210401) {
                    // TGL PEMB 1 Jan 2021 - 31 mar 2021
                    // $denda = $denda + $denda_baru;
                    $denda = $denda_sppt + $denda_baru;
                    $utang = $sisa + $denda;
                    // $terbilang = terbilang($utang);
                    $nil_pengurang = intval($utang * 20 / 100);
                    $denda = intval($denda * 20 / 100);
                    $utang = $utang - $nil_pengurang;
                    $terbilang = terbilang($utang);
                } else {
                    // $denda = $denda + $denda_baru;
                    $denda = $denda_sppt + $denda_baru;
                    $utang = $sisa + $denda;
                    $terbilang = terbilang($utang);
                    // $nil_pengurang = $query->faktor_pengurang_sppt;
                    $nil_pengurang = 0;
                }

                // $denda = $denda + $denda_baru;
                // $utang = $sisa+$denda;
                // $terbilang = terbilang($utang);


                // $data['sisa'] = $sisa ." || ".$jml_sppt_yg_dibayar." || ".(float)($sisa + $denda - $nil_pengurang);
                $data['sisa'] = $denda_sppt;

                // echo 'jml bayar : ' . (float)$jml_byr . ' -- sisa: ' . (float)$sisa .' -- denda: '. (float)$denda_sppt .' -- nil_pengurang: '. (float)$nil_pengurang;
                // die();

                $tgl_pembayaran_sppt = date('Y-m-d');
                $tgl_rekam_byr_sppt  = date('Y-m-d h:i:sa');
                $nip_rekam_byr_sppt  = $this->session->userdata('nip');
                $pembayaran_sppt_ke  = $this->payment_model->get_pembayaran_ke($nop, $thn);

                $data = array(
                    'kd_propinsi' => $kd_propinsi,
                    'kd_dati2' => $kd_dati2,
                    'kd_kecamatan' => $kd_kecamatan,
                    'kd_kelurahan' => $kd_kelurahan,
                    'kd_blok' => $kd_blok,
                    'no_urut' => $no_urut,
                    'kd_jns_op' => $kd_jns_op,
                    'thn_pajak_sppt' => $thn_pajak_sppt,
                    'pembayaran_sppt_ke' => $pembayaran_sppt_ke,
                    'denda_sppt' => $denda_sppt,
                    'tgl_rekam_byr_sppt' => $tgl_rekam_byr_sppt,
                    'nip_rekam_byr_sppt' => $nip_rekam_byr_sppt,
                    'user_id' => $this->session->userdata('userid'),

                    'jml_sppt_yg_dibayar' => $jml_byr,
                    'tgl_pembayaran_sppt' => $tgl_byr,
                    'kd_tp' => $this->input->post('kdtp')
                );

                $fields = explode(',', POS_FIELD_BND);
                foreach ($fields as $f) {
                    $f    = trim($f);
                    $data = array_merge($data, array(
                        trim($f) => $this->session->userdata[$f]
                    ));
                }

                // $ins_pmb = $this->payment_model->update_pmb($data);
                $ins_pmb = $this->payment_model->update_pmb($nop, $thn, $data);

                // CEK insert pembayaran if true jalankeun insert yang lain
                // $data['yesss'] = $ins_pmb;// die();
                if ($ins_pmb) {


                    //// UNTUK PENGURANGAN COVID BARU _edSen 31032021
                    //// UJUNGNYA PAKE JUGA hohoho... (REQ tgl 28092021)
                    if (($thn <= 2025 && $today <= 20250331 && $today >= 20250102) ||
                        ($thn <= 2016 && $query->FAKTOR_PENGURANG_SPPT == 0 && $today <= 20211231 && $today >= 20210401)
                    ) {
                        if ($thn == 2025 && $today <= 20250331 && $today >= 20250102) {
                            $data_his = array(
                                'kd_propinsi' => $kd_propinsi,
                                'kd_dati2' => $kd_dati2,
                                'kd_kecamatan' => $kd_kecamatan,
                                'kd_kelurahan' => $kd_kelurahan,
                                'kd_blok' => $kd_blok,
                                'no_urut' => $no_urut,
                                'kd_jns_op' => $kd_jns_op,
                                'thn_pajak_sppt' => $thn_pajak_sppt,
                                'pembayaran_sppt_ke' => $pembayaran_sppt_ke,
                                'denda_sppt' => $denda_sppt,
                                'jml_sppt_yg_dibayar' => $jml_sppt_yg_dibayar,
                                'tgl_pembayaran_sppt' => $tgl_pembayaran_sppt,
                                'tgl_rekam_byr_sppt' => $tgl_rekam_byr_sppt,
                                'nip_rekam_byr_sppt' => $nip_rekam_byr_sppt,
                                'create_user' => $this->session->userdata('userid'),
                                'create_date' => date('Y-m-d H:i:s'),
                                'pbb_terhutang_sppt' => $query->PBB_TERHUTANG_SPPT,
                                'faktor_pengurang_sppt' => $query->FAKTOR_PENGURANG_SPPT,
                                'faktor_pengurang_covid19' => $faktor_pengurang_baru,
                                'pbb_yg_harus_dibayar_sppt' => $query->PBB_YG_HARUS_DIBAYAR_SPPT,
                                'kd_tp' => $this->input->post('kdtp')
                            );
                        } else {
                            $data_his = array(
                                'kd_propinsi' => $kd_propinsi,
                                'kd_dati2' => $kd_dati2,
                                'kd_kecamatan' => $kd_kecamatan,
                                'kd_kelurahan' => $kd_kelurahan,
                                'kd_blok' => $kd_blok,
                                'no_urut' => $no_urut,
                                'kd_jns_op' => $kd_jns_op,
                                'thn_pajak_sppt' => $thn_pajak_sppt,
                                'pembayaran_sppt_ke' => $pembayaran_sppt_ke,
                                'denda_sppt' => $denda_sppt,
                                'jml_sppt_yg_dibayar' => $jml_sppt_yg_dibayar,
                                'tgl_pembayaran_sppt' => $tgl_pembayaran_sppt,
                                'tgl_rekam_byr_sppt' => $tgl_rekam_byr_sppt,
                                'nip_rekam_byr_sppt' => $nip_rekam_byr_sppt,
                                'create_user' => $this->session->userdata('userid'),
                                'create_date' => date('Y-m-d H:i:s'),
                                'pbb_terhutang_sppt' => $query->PBB_TERHUTANG_SPPT,
                                'faktor_pengurang_sppt' => $query->FAKTOR_PENGURANG_SPPT,
                                'faktor_pengurang_covid19' => $nil_pengurang,
                                'pbb_yg_harus_dibayar_sppt' => $query->PBB_YG_HARUS_DIBAYAR_SPPT,
                                'kd_tp' => $this->input->post('kdtp')
                            );
                        }



                        foreach ($fields as $f) {
                            $f    = trim($f);
                            $data_his = array_merge($data_his, array(
                                trim($f) => $this->session->userdata[$f]
                            ));
                        }
                        $this->payment_model->ins_hist_cvd($data_his);



                        // $this->sppt_model->ins_hist_cvd($nop,$thn);
                        // $this->sppt_model->update_sppt_cvd($nop,$thn, $nil_pengurang, $utang);
                        if ($thn == 2025 && $today <= 20250331 && $today >= 20250102) {
                            $this->sppt_model->update_sppt_cvd($nop, $thn, $faktor_pengurang_baru, $utang);
                        } else {
                            $this->sppt_model->update_sppt_cvd($nop, $thn, $nil_pengurang, $utang);
                        }
                    } else {
                        $this->sppt_model->update_spptdenda($nop, $thn);
                    }

                    if ((float)$jml_byr >= (float)($sisa + $denda_sppt - $nil_pengurang)) {
                        $this->sppt_model->update_sppt_bendahara($nop, $thn);
                    }
                }

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
        $this->load->model(array(
            'payment_model'
        ));
        //testing
        // $query = "..";
        // $this->load->view(STTS1, $query);

        if ($nop && $thn && $ke && $query = $this->payment_model->get_by_nop_thn_ke_cetak($nop, $thn, $ke)) {
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
