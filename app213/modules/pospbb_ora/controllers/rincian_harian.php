<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class rincian_harian extends CI_Controller
{
    private $module = 'rincian_harian';

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

        //$module = 'rincian_harian';
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

        $data['page_menu'] = 'm03_mn_transaksi';
        $data['current']   = $this->module;

        //ob_start("ob_gzhandler");
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

        $tglawal     = date('d-m-Y');
        $tglakhir    = date('d-m-Y');
        $tahun_sppt1 = '1999'; //minta tahun berjalan, kasih dahh
        $tahun_sppt2 = date('Y');

        $kec_kd      = (isset($_GET['kec_kd']) ? $_GET['kec_kd'] : $data['user_kec_kd']);
        $kel_kd      = (isset($_GET['kel_kd']) ? $_GET['kel_kd'] : $data['user_kel_kd']);
        $tahun_sppt1 = (isset($_GET['tahun_sppt1']) ? $_GET['tahun_sppt1'] : $tahun_sppt1);
        $tahun_sppt2 = (isset($_GET['tahun_sppt2']) ? $_GET['tahun_sppt2'] : $tahun_sppt2);

        $buku = (isset($_GET['buku']) ? $_GET['buku'] : '15');

        if (isset($_GET['tglawal']) && $_GET['tglawal']) {
            $tglawal = $_GET['tglawal'];
        }

        if (isset($_GET['tglakhir']) && $_GET['tglakhir']) {
            $tglakhir = $_GET['tglakhir'];
        }

        $trantypes         = '2'; //$this->uri->segment(3, 1);
        $data['buku']      = $buku;
        $data['trantypes'] = $trantypes;
        $data['tglawal']   = $tglawal;
        $data['tglakhir']  = $tglakhir;
        $data['kec_kd']    = $kec_kd;
        $data['kel_kd']    = $kel_kd;

        $data['tahun_sppt1'] = $tahun_sppt1;
        $data['tahun_sppt2'] = $tahun_sppt2;

        //-----------------------------------------------------------------------
        $range_tahun_sppt = $this->load->model('sppt_model')->range_thn_sppt();
        //-----------------------------------------------------------------------
        $options = $range_tahun_sppt;
        $js = 'id="tahun_sppt1" name="tahun_sppt1" class="input form-control select2" style="width: 90px" ';
        $data['select_thn_sppt1'] = form_dropdown('tahun_sppt1', $options, $tahun_sppt1, $js);
        //-----------------------------------------------------------------------
        $options = $range_tahun_sppt;
        $js = 'id="tahun_sppt2" name="tahun_sppt2" class="input form-control select2" style="width: 90px" ';
        $data['select_thn_sppt2'] = form_dropdown('tahun_sppt2', $options, $tahun_sppt2, $js);
        //-----------------------------------------------------------------------
        //if(empty($kec_kd){ $kel_kd = '000'; }
        $select_data = $this->load->model('ref_kecamatan_model')->get_select_kec();
        $options     = array();
        //
        if (get_user_kec_kd() == '000') {
            $options['000'] = 'Semua';
        } else {
            $kec_kd = get_user_kec_kd();
        }
        foreach ($select_data as $row) {
            $options[$row->KD_KECAMATAN] = $row->NM_KECAMATAN;
        }
        $js = 'id="kec_kd" name="kec_kd" class="input form-control select2" style="width: 250px" ';
        $data['select_kecamatan'] = form_dropdown('kec_kd', $options, $kec_kd, $js);
        //-----------------------------------------------------------------------
        //if(empty($kel_kd)){ $kel_kd = '000'; }
        $select_data = $this->load->model('ref_kelurahan_model')->get_select_kel($kec_kd);
        $options     = array();
        if (get_user_kel_kd() == '000') {
            $options['000'] = 'Semua';
        } else {
            $kel_kd = get_user_kel_kd();
        }
        foreach ($select_data as $row) {
            $options[$row->KD_KELURAHAN] = $row->NM_KELURAHAN;
        }
        $js = 'id="kel_kd" name="kel_kd" class="input form-control select2" style="width: 250px" ';
        $data['select_kelurahan'] = form_dropdown('kel_kd', $options, $kel_kd, $js);
        //-----------------------------------------------------------------------
        $options = $this->load->model('pospbb_ora_model')->get_select_buku();
        //
        $js = 'id="buku" name="buku" class="input form-control select2" style="width: 150px" ';
        $data['select_buku'] = form_dropdown('buku', $options, $buku, $js);
        //-----------------------------------------------------------------------
        $tp_kd = (isset($_GET['tp_kd']) ? $_GET['tp_kd'] : '');
        $select_data = $this->load->model('tp_bayar_model')->get_tp_bayar_pbb();
        $options     = array();
        //$options['0'] = 'Semua TP';
        foreach ($select_data as $row) {
            $options[$row->KODE] = $row->NM_TP;
        }
        $js = 'id="tp_kd" name="tp_kd" class="input form-control select2" style="width: 250px" ';
        $data['select_tp_bayar'] = form_dropdown('tp_kd', $options, $tp_kd, $js);
        //-----------------------------------------------------------------------         
        $data['pagetitle']    = 'PosPbbBogor';
        $data['title']        = 'Transaksi Pembayaran';
        $data['SEC_content'] = '';

        $data['data_source'] = active_module_url() . "rincian_harian/grid?buku=$buku&tahun_sppt1=$tahun_sppt1&tahun_sppt2=$tahun_sppt2&tglawal=$tglawal&tglakhir=$tglakhir&kec_kd=$kec_kd&kel_kd=$kel_kd&tp_kd=$tp_kd";

        $data['tpnm']    = isset($this->session->userdata['tpnm']) ? $this->session->userdata['tpnm'] : '';

        $data['current'] = $this->module;
        $data['apps']    = $this->apps_model->get_active_only();

        $this->load->view('rincian_harian/vrincian_harian', $data);
    }

    function grid()
    {

        $schema_pbb = SCHEMA_PBB . ".";
        $userlogin = lda_user_login();
        $nip_rekam = $this->session->userdata('nip');
        $isgrup_admin = $this->load->model('user_pbb_model')->get_isgrup_admin($userlogin);
        //

        $kec_kd = (isset($_GET['kec_kd']) && is_numeric($_GET['kec_kd'])) ? $_GET['kec_kd'] : '000';
        if (get_user_kec_kd() != '000' && get_user_kec_kd() != $kec_kd) {
            $kec_kd = get_user_kec_kd();
        }

        $kel_kd = (isset($_GET['kel_kd']) && is_numeric($_GET['kel_kd'])) ? $_GET['kel_kd'] : '000';
        if (get_user_kel_kd() != '000' && get_user_kel_kd() != $kel_kd) {
            $kec_kd = get_user_kel_kd();
        }

        $buku    = (isset($_GET['buku'])) ? $_GET['buku'] : '11';
        $bukumin = $this->pospbb_ora_model->rangebuku[substr($buku, 0, 1)][0];
        $bukumax = $this->pospbb_ora_model->rangebuku[substr($buku, 1, 1)][1];

        $tglm = (isset($_GET['tglawal'])) ? $_GET['tglawal'] : date('d-m-Y');
        $tgls = (isset($_GET['tglakhir'])) ? $_GET['tglakhir'] : date('d-m-Y');
        $tglm = substr($tglm, 6, 4) . '-' . substr($tglm, 3, 2) . '-' . substr($tglm, 0, 2);
        $tgls = substr($tgls, 6, 4) . '-' . substr($tgls, 3, 2) . '-' . substr($tgls, 0, 2);

        $tahun_sppt1 = (isset($_GET['tahun_sppt1'])) ? $_GET['tahun_sppt1'] : date('Y');
        $tahun_sppt2 = (isset($_GET['tahun_sppt2'])) ? $_GET['tahun_sppt2'] : date('Y');

        $path_to_root = active_module_url();

        $aColumns     = array(
            'kode',
            'uraian',
            'thn_pajak_sppt',
            'pokok',
            'denda',
            'bayar',
            'tanggal',
            'nm_tp',
        );
        $sIndexColumn = "kode";

        $iDisplayLength = (isset($_GET['iDisplayLength']) && is_numeric($_GET['iDisplayLength'])) ? $_GET['iDisplayLength'] : 15;
        $iDisplayStart  = (isset($_GET['iDisplayStart']) && is_numeric($_GET['iDisplayStart'])) ? $_GET['iDisplayStart'] : 0;
        $iSortCol_0     = (isset($_GET['iSortCol_0']) && is_numeric($_GET['iSortCol_0'])) ? $_GET['iSortCol_0'] : 0;
        $iSortingCols   = (isset($_GET['iSortingCols']) && is_numeric($_GET['iSortingCols'])) ? $_GET['iSortingCols'] : 1;
        $sSortDir_0     = (isset($_GET['sSortDir_0'])) ? $_GET['sSortDir_0'] : "asc";
        $sEcho          = (isset($_GET['sEcho']) && is_numeric($_GET['sEcho'])) ? $_GET['sEcho'] : 1;
        $sSearch        = (isset($_GET['sSearch'])) ? $_GET['sSearch'] : "";
        $sSearch_0      = (isset($_GET['sSearch_0'])) ? $_GET['sSearch_0'] : "";
        $sSearch_1      = (isset($_GET['sSearch_1'])) ? $_GET['sSearch_1'] : "";
        $sSearch_2      = (isset($_GET['sSearch_2'])) ? $_GET['sSearch_2'] : "";
        $sSearch_3      = (isset($_GET['sSearch_3'])) ? $_GET['sSearch_3'] : "";
        $sSearch_4      = (isset($_GET['sSearch_4'])) ? $_GET['sSearch_4'] : "";

        /*
         * Limit
         */

        $sLimit     = "";
        $pageSize   = (isset($_GET['iDisplayLength']) && $_GET['iDisplayLength'] != '-1' ? $_GET['iDisplayLength'] : 15);
        $pageNumber = (isset($_GET['iDisplayStart']) && $_GET['iDisplayStart'] != '-1' ? $_GET['iDisplayStart'] : 1);
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            // $sLimit = "LIMIT $pageSize OFFSET $pageNumber";
        }

        /*
         * Ordering
         */
        $sOrder = "";
        if (isset($_GET['iSortCol_0'])) {
            $sOrder = "ORDER BY ";
            for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                    if ($aColumns[intval($_GET['iSortCol_' . $i])] == "bphtbno" || $aColumns[intval($_GET['iSortCol_' . $i])] == "tanggal") {
                        $sOrder .= $aColumns[intval($_GET['iSortCol_' . $i])] . " " . $_GET['sSortDir_' . $i] . ", ";
                    } else {
                        $sOrder .= $aColumns[intval($_GET['iSortCol_' . $i])] . ' ' . $_GET['sSortDir_' . $i] . ", ";
                    }
                }
            }

            $sOrder = substr_replace($sOrder, "", -2);
            if ($sOrder == "ORDER BY ") {
                $sOrder = "";
            }
        }


        /* 
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        //AND spt.kd_propinsi='" . KD_PROPINSI . "' AND spt.kd_dati2='" . KD_DATI2 . "' 
        $where = "WHERE ps.tgl_pembayaran_sppt BETWEEN to_date('$tglm','YYYY-MM-DD') AND to_date('$tgls','YYYY-MM-DD')   
        AND ps.thn_pajak_sppt BETWEEN '$tahun_sppt1' AND '$tahun_sppt2'
        AND spt.pbb_yg_harus_dibayar_sppt between $bukumin AND $bukumax ";

        //die($where);    
        if ($kec_kd != "000") {
            $where .= " AND spt.kd_kecamatan='$kec_kd'";
            if ($kel_kd != "000")
                $where .= " AND spt.kd_kelurahan='$kel_kd'";
        }

        // cek jika bukan grup admin
        if ($isgrup_admin == FALSE) {
            $where .= " and ps.NIP_REKAM_BYR_SPPT='$nip_rekam' ";
        }

        $search = '';
        if ($sSearch)
            $search .= " AND spt.nm_wp_sppt ilike '%$sSearch%'";

        $iTotal    = 0;
        $iFiltered = 0;

        /*
         * Output
         */

        /// -- DARI SINI ..
        $pos_fld    = '';
        $pos_join   = '';
        $pos_uraian = '';
        //
        if (DEF_POS_TYPE == 1) {
            $pos_fld    = "ps.KD_KANWIL, ps.KD_KANTOR,ps.KD_TP ";
            $pos_join   = "ps.KD_KANWIL=tp.KD_KANWIL and ps.KD_KANTOR=tp.KD_KANTOR and ps.KD_TP=tp.KD_TP ";
            $pos_uraian = "tp.KD_KANWIL||tp.KD_KANTOR||tp.KD_TP ";
        } else {
            $pos_fld    = "ps.KD_BANK_TUNGGAL,ps.KD_BANK_PERSEPSI,ps.KD_KANWIL, ps.KD_KANTOR,ps.KD_TP ";
            $pos_join   = "ps.KD_BANK_TUNGGAL=tp.KD_BANK_TUNGGAL and ps.KD_BANK_PERSEPSI=tp.KD_BANK_PERSEPSI ";
            $pos_join  .= " and ps.KD_KANWIL=tp.KD_KANWIL and ps.KD_KANTOR=tp.KD_KANTOR and ps.KD_TP=tp.KD_TP ";
            $pos_uraian = "tp.KD_BANK_TUNGGAL||tp.KD_BANK_PERSEPSI||tp.KD_KANWIL||tp.KD_KANTOR||tp.KD_TP ";
        }

        $tp_kd = (isset($_GET['tp_kd'])) ? $_GET['tp_kd'] : '';
        if (!empty($tp_kd)) {
            $where .= " AND {$pos_uraian} = '{$tp_kd}'";
        }

        $sql_query_r = "SELECT  
            (spt.kd_propinsi||'.'||spt.kd_dati2||'-'||spt.kd_kecamatan||'.'||spt.kd_kelurahan ||'-'|| spt.kd_blok 
            ||'.'||spt.no_urut||'.'|| spt.kd_jns_op) as kode, 
            spt.nm_wp_sppt as uraian, ({$pos_uraian}||':'||tp.nm_tp) as nm_tp, ps.thn_pajak_sppt,
            (nvl(ps.jml_sppt_yg_dibayar,0) - nvl(ps.denda_sppt,0)) as pokok, 
            ps.denda_sppt as denda, ps.jml_sppt_yg_dibayar as bayar, to_char(ps.tgl_pembayaran_sppt,'DD-MM-YYYY') as tanggal
            FROM S_SPPT spt
            INNER JOIN S_PEMBAYARAN_SPPT ps
            ON spt.kd_propinsi = ps.kd_propinsi
            AND spt.kd_dati2 = ps.kd_dati2 
            AND spt.kd_kecamatan = ps.kd_kecamatan 
            AND spt.kd_kelurahan = ps.kd_kelurahan 
            AND spt.kd_blok = ps.kd_blok 
            AND spt.no_urut = ps.no_urut 
            AND spt.kd_jns_op = ps.kd_jns_op 
            AND spt.thn_pajak_sppt = ps.thn_pajak_sppt 
            LEFT JOIN S_TEMPAT_PEMBAYARAN tp ON {$pos_join}
            $where $search 
            ORDER BY 
            (spt.kd_propinsi||spt.kd_dati2||spt.kd_kecamatan||spt.kd_kelurahan||spt.kd_blok||spt.no_urut||spt.kd_jns_op), 
            spt.nm_wp_sppt, ({$pos_uraian}||':'||tp.nm_tp)";

        $sql_query_r .= "$sOrder $sLimit";
        // log_message('info', " ZZZZZZZZZZZZZZZZZZZ loaddata dt_rincian_harian: " . $sql_query_r);
        $qry = $this->db->query($sql_query_r);

        $output = array(
            "sEcho" => $sEcho,
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iFiltered,
            "iDisplayStart" => $iDisplayStart,
            "iDisplayLength" => $iDisplayLength,

            // "SQL Query" => $sql_query_r,
            "aaData" => array()
        );

        $pg_pokok = 0;
        $pg_denda = 0;
        $pg_total = 0;
        foreach ($qry->result() as $aRow) {
            $row = array();
            for ($i = 0; $i < count($aColumns); $i++) {

                if ($aColumns[$i] == 'kode') {
                    $row[] = $aRow->KODE;
                } else if ($aColumns[$i] == 'thn_pajak_sppt') {
                    $row[] = $aRow->THN_PAJAK_SPPT;
                } else if ($aColumns[$i] == 'pokok') {
                    $row[] = number_format($aRow->POKOK, 0, ',', '.'); // $aRow->pokok;
                } else if ($aColumns[$i] == 'denda') {
                    $row[] = number_format($aRow->DENDA, 0, ',', '.'); // $aRow->denda;
                } else if ($aColumns[$i] == 'bayar') {
                    $row[] = number_format($aRow->BAYAR, 0, ',', '.'); // $aRow->bayar;
                } else if ($aColumns[$i] == 'tanggal') {
                    $row[] = $aRow->TANGGAL;
                } else if ($aColumns[$i] == 'nm_tp') {
                    $row[] = $aRow->NM_TP;
                } else {
                    $row[] = $aRow->URAIAN;
                }

                //if ($i > 2 && $i < 5){ $row[] = number_format($aRow->$aColumns[$i], 0, ',', '.'); }
                //else { $row[] = $aRow->$aColumns[$i]; }

            }

            $output['aaData'][] = $row;

            $pg_pokok += $aRow->POKOK;
            $pg_denda += $aRow->DENDA;
            $pg_total += $aRow->BAYAR;
        }

        $output['pokok'] = number_format($pg_pokok, 0, ',', '.');
        $output['denda'] = number_format($pg_denda, 0, ',', '.');
        $output['total'] = number_format($pg_total, 0, ',', '.');

        echo json_encode($output);
    }
}
