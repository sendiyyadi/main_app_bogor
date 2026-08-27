<?php
class loaddata extends CI_Controller
{
    private $db_pbbm;

    function __construct()
    {
        parent::__construct();
        $this->db_pbbm = $this->load->database('default', TRUE);

        if (!$this->session->userdata('login')) {
            $this->session->set_flashdata('msg_warning', 'Session telah kadaluarsa, silahkan login ulang.');
            redirect('login');
            exit;
        }

        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        $this->load->model('pbbm_model');
    }

    function index() {}

    function transaksi1()
    {
        // ob_start("ob_gzhandler");

        $kec_kd = (isset($_GET['kec_kd']) ? $_GET['kec_kd'] : ($this->session->userdata('user_def_kec') ? $this->session->userdata('user_def_kec') : '000'));
        $kel_kd = (isset($_GET['kel_kd']) ? $_GET['kel_kd'] : ($this->session->userdata('user_def_kel_' . $kec_kd) ? $this->session->userdata('user_def_kel_' . $kec_kd) : '000'));

        $buku    = (isset($_GET['buku'])) ? $_GET['buku'] : '11';
        $bukumin = $this->pbbm_model->rangebuku[substr($buku, 0, 1)][0];
        $bukumax = $this->pbbm_model->rangebuku[substr($buku, 1, 1)][1];

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

        //      TRUNC(p.tgl_pembayaran_sppt) >= TO_DATE('2013-07-01', 'YYYY-MM-DD') 
        // AND TRUNC(p.tgl_pembayaran_sppt) <= TO_DATE('2013-07-01', 'YYYY-MM-DD')

        $where = "WHERE TRUNC(p.tgl_pembayaran_sppt) >= TO_DATE('$tglm', 'YYYY-MM-DD') AND TRUNC(p.tgl_pembayaran_sppt) <= TO_DATE('$tgls', 'YYYY-MM-DD')
            AND k.kd_propinsi='" . KD_PROPINSI . "'
            AND k.kd_dati2='" . KD_DATI2 . "'
            AND p.thn_pajak_sppt BETWEEN '$tahun_sppt1' AND '$tahun_sppt2'
            AND k.pbb_yg_harus_dibayar_sppt between $bukumin AND $bukumax ";

        //die($where);
        if ($kec_kd != "000") {
            $where .= " AND k.kd_kecamatan='$kec_kd'";
            if ($kel_kd != "000")
                $where .= " AND k.kd_kelurahan='$kel_kd'";
        }

        $search = '';
        if ($sSearch)
            $search .= " AND k.nm_wp_sppt ilike '%$sSearch%'";

        $iTotal    = 0;
        $iFiltered = 0;

        /*
         * Output
         */

        /// -- DARI SINI ..
        $fields     = explode(',', POS_FIELD);
        $pos_fld    = '';
        $pos_join   = '';
        $pos_uraian = '';
        $fs = '';
        foreach ($fields as $f) {
            $fs = $f;
            if ($f == 'kd_kanwil_bank')
                $fs = 'kd_kanwil';
            else if ($f == 'kd_kppbb_bank')
                $fs = 'kd_kppbb';

            $pos_fld .= "p.{$f}, ";
            $pos_join .= "p.{$f}=tp.{$fs} and ";
            $pos_uraian .= "tp.{$fs}||";
        }
        $pos_fld = substr($pos_fld, 0, -2);
        $pos_join = substr($pos_join, 0, -4);
        $pos_uraian = substr($pos_uraian, 0, -2);

        $tp_kd = (isset($_GET['tp_kd'])) ? $_GET['tp_kd'] : '';
        if ($tp_kd != "")
            $where .= " AND {$pos_uraian} = '{$tp_kd}'";

        $sql_query_r = "SELECT
            k.kd_propinsi||'.'||k.kd_dati2||'-'||k.kd_kecamatan||'.'||k.kd_kelurahan ||'-'|| k.kd_blok ||'.'||k.no_urut||'.'|| k.kd_jns_op ||' '|| k.thn_pajak_sppt kode,
            k.nm_wp_sppt uraian, {$pos_uraian}||':'||tp.nm_tp nm_tp, p.thn_pajak_sppt,
            (p.jml_sppt_yg_dibayar - p.denda_sppt) pokok, p.denda_sppt denda, p.jml_sppt_yg_dibayar bayar, to_char(p.tgl_pembayaran_sppt,'dd-mm-yyyy') tanggal
            FROM sppt k
            INNER JOIN pembayaran_sppt p
            ON k.kd_propinsi = p.kd_propinsi
            AND k.kd_dati2 = p.kd_dati2
            AND k.kd_kecamatan = p.kd_kecamatan
            AND k.kd_kelurahan = p.kd_kelurahan
            AND k.kd_blok = p.kd_blok
            AND k.no_urut = p.no_urut
            AND k.kd_jns_op = p.kd_jns_op
            AND k.thn_pajak_sppt = p.thn_pajak_sppt
            LEFT JOIN tempat_pembayaran tp ON {$pos_join}
            $where $search
            ORDER BY 1,2,3 ";

        $sql_query_r .= "$sOrder $sLimit";


        $qry = $this->db->query($sql_query_r);

        $output = array(
            "sEcho" => $sEcho,
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iFiltered,
            "iDisplayStart" => $iDisplayStart,
            "iDisplayLength" => $iDisplayLength,

            "SQL Query" => $sql_query_r,
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
            /*
            $pg_pokok += $aRow->$aColumns[3];
            $pg_denda += $aRow->$aColumns[4];
            $pg_total += $aRow->$aColumns[5];
            */
            $pg_pokok += $aRow->POKOK;
            $pg_denda += $aRow->DENDA;
            $pg_total += $aRow->BAYAR;
        }

        $output['pokok'] = number_format($pg_pokok, 0, ',', '.');
        $output['denda'] = number_format($pg_denda, 0, ',', '.');
        $output['total'] = number_format($pg_total, 0, ',', '.');

        echo json_encode($output);
    }

    function transaksi2()
    {
        // ob_start("ob_gzhandler");

        $buku        = (isset($_GET['buku'])) ? $_GET['buku'] : '11';
        $bukumin     = $this->pbbm_model->rangebuku[substr($buku, 0, 1)][0];
        $bukumax     = $this->pbbm_model->rangebuku[substr($buku, 1, 1)][1];
        $tahun_sppt1 = (isset($_GET['tahun_sppt1'])) ? $_GET['tahun_sppt1'] : date('Y');
        $tahun_sppt2 = (isset($_GET['tahun_sppt2'])) ? $_GET['tahun_sppt2'] : date('Y');

        $kec_kd = (isset($_GET['kec_kd']) ? $_GET['kec_kd'] : ($this->session->userdata('user_def_kec') ? $this->session->userdata('user_def_kec') : '000'));
        $kel_kd = (isset($_GET['kel_kd']) ? $_GET['kel_kd'] : ($this->session->userdata('user_def_kel_' . $kec_kd) ? $this->session->userdata('user_def_kel_' . $kec_kd) : '000'));

        $path_to_root = active_module_url();

        $aColumns     = array(
            'kode',
            'uraian',
            'thn_pajak_sppt',
            'pokok',
            'denda',
            'bayar'
        );
        $sIndexColumn = "kode";

        $iDisplayLength = (isset($_GET['iDisplayLength']) && is_numeric($_GET['iDisplayLength'])) ? $_GET['iDisplayLength'] : 15;
        $iDisplayStart  = (isset($_GET['iDisplayStart']) && is_numeric($_GET['iDisplayStart'])) ? $_GET['iDisplayStart'] : 0;

        $iSortCol_0   = (isset($_GET['iSortCol_0']) && is_numeric($_GET['iSortCol_0'])) ? $_GET['iSortCol_0'] : 0;
        $iSortingCols = (isset($_GET['iSortingCols']) && is_numeric($_GET['iSortingCols'])) ? $_GET['iSortingCols'] : 1;
        $sSortDir_0   = (isset($_GET['sSortDir_0'])) ? $_GET['sSortDir_0'] : "asc";

        $sEcho = (isset($_GET['sEcho']) && is_numeric($_GET['sEcho'])) ? $_GET['sEcho'] : 1;

        $sSearch   = (isset($_GET['sSearch'])) ? $_GET['sSearch'] : "";
        $sSearch_0 = (isset($_GET['sSearch_0'])) ? $_GET['sSearch_0'] : "";
        $sSearch_1 = (isset($_GET['sSearch_1'])) ? $_GET['sSearch_1'] : "";
        $sSearch_2 = (isset($_GET['sSearch_2'])) ? $_GET['sSearch_2'] : "";
        $sSearch_3 = (isset($_GET['sSearch_3'])) ? $_GET['sSearch_3'] : "";
        $sSearch_4 = (isset($_GET['sSearch_4'])) ? $_GET['sSearch_4'] : "";

        $tglm = (isset($_GET['tglawal'])) ? $_GET['tglawal'] : date('d-m-Y');
        $tgls = (isset($_GET['tglakhir'])) ? $_GET['tglakhir'] : date('d-m-Y');

        $tglm = substr($tglm, 6, 4) . '-' . substr($tglm, 3, 2) . '-' . substr($tglm, 0, 2);
        $tgls = substr($tgls, 6, 4) . '-' . substr($tgls, 3, 2) . '-' . substr($tgls, 0, 2);

        /*
         * Limit
         */

        $sLimit = "";
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            // $sLimit = "LIMIT " . $_GET['iDisplayLength'] . " OFFSET " . $_GET['iDisplayStart'];
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

        // $where  = " WHERE p.tgl_pembayaran_sppt BETWEEN '$tglm' AND '$tgls' ";

        // $where  = " WHERE TO_CHAR(p.tgl_pembayaran_sppt,'YYYY-MM-DD') >= '$tglm' AND TO_CHAR(p.tgl_pembayaran_sppt,'YYYY-MM-DD') <= '$tgls' ";
        $where = " WHERE TRUNC(p.tgl_pembayaran_sppt) >= TO_DATE('$tglm', 'YYYY-MM-DD') AND TRUNC(p.tgl_pembayaran_sppt) <= TO_DATE('$tgls', 'YYYY-MM-DD') ";
        // TO_CHAR(p.tgl_pembayaran_sppt,'YYYY-MM-DD') >= '2013-07-01' and
        // TO_CHAR(p.tgl_pembayaran_sppt,'YYYY-MM-DD') <= '2013-07-30'
        // TRUNC(p.tgl_pembayaran_sppt) >= TO_CHAR('2013-07-01', 'YYYY-MM-DD') 
        // AND TRUNC(p.tgl_pembayaran_sppt) <= TO_DATE('2013-07-01', 'YYYY-MM-DD') 
        $where .= " AND p.kd_propinsi='" . KD_PROPINSI . "' AND p.kd_dati2='" . KD_DATI2 . "' ";
        $where .= " AND p.thn_pajak_sppt BETWEEN '$tahun_sppt1' AND '$tahun_sppt2' ";
        $where .= " AND k.pbb_yg_harus_dibayar_sppt between $bukumin AND $bukumax ";

        if ($kec_kd != "000")
            $where .= " AND p.kd_kecamatan='$kec_kd'";
        if ($kel_kd != "000")
            $where .= " AND p.kd_kelurahan='$kel_kd'";

        $search = '';
        if ($sSearch)
            $search .= " AND tp.nm_tp ilike '%$sSearch%'";

        $iTotal    = 0;
        $iFiltered = 0;

        /// -- DARI SINI ..
        $fields     = explode(',', POS_FIELD);
        $pos_fld    = '';
        $pos_join   = '';
        $pos_uraian = '';
        $fs = '';
        foreach ($fields as $f) {
            $fs = $f;
            if ($f == 'kd_kanwil_bank')
                $fs = 'kd_kanwil';
            else if ($f == 'kd_kppbb_bank')
                $fs = 'kd_kppbb';

            $pos_fld .= "p.{$f}, ";
            $pos_join .= "p.{$f}=tp.{$fs} and ";
            $pos_uraian .= "tp.{$fs}||";
        }
        $pos_fld = substr($pos_fld, 0, -2);
        $pos_join = substr($pos_join, 0, -4);
        $pos_uraian = substr($pos_uraian, 0, -2);

        $tp_kd = (isset($_GET['tp_kd'])) ? $_GET['tp_kd'] : '';
        if ($tp_kd != "")
            $where .= " AND {$pos_uraian} = '{$tp_kd}'";

        /*
         * Output
         */
        // $sql_query_r = "SELECT  tgl_pembayaran_sppt kode,tp.kd_kanwil||tp.kd_kantor||tp.kd_tp||':'||tp.nm_tp uraian,
        $sql_query_r = "SELECT  TRUNC(tgl_pembayaran_sppt) kode,{$pos_uraian}||':'||tp.nm_tp uraian, p.thn_pajak_sppt,
            sum(p.jml_sppt_yg_dibayar - p.denda_sppt)  pokok, sum(p.denda_sppt) denda,
            sum(p.jml_sppt_yg_dibayar) bayar
            FROM sppt k
            INNER JOIN pembayaran_sppt p
            ON k.kd_propinsi = p.kd_propinsi
            AND k.kd_dati2 = p.kd_dati2
            AND k.kd_kecamatan = p.kd_kecamatan
            AND k.kd_kelurahan = p.kd_kelurahan
            AND k.kd_blok = p.kd_blok
            AND k.no_urut = p.no_urut
            AND k.kd_jns_op = p.kd_jns_op
            AND k.thn_pajak_sppt = p.thn_pajak_sppt
            LEFT JOIN tempat_pembayaran tp ON {$pos_join}
            $where $search
            GROUP BY 1, TRUNC(tgl_pembayaran_sppt), 2, tp.kd_kanwil || tp.kd_kantor || tp.kd_tp || ':' || tp.nm_tp, p.thn_pajak_sppt
            ORDER BY 1, TRUNC(tgl_pembayaran_sppt), 2, tp.kd_kanwil || tp.kd_kantor || tp.kd_tp || ':' || tp.nm_tp, p.thn_pajak_sppt ";
        $sql_query_r .= "$sOrder $sLimit";

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

        $qry = $this->db->query($sql_query_r);
        foreach ($qry->result() as $aRow) {
            $row = array();
            for ($i = 0; $i < count($aColumns); $i++) {

                if ($aColumns[$i] == 'kode') {
                    $row[] = date('d-m-Y', strtotime($aRow->KODE)); //$aRow->kode;
                } else if ($aColumns[$i] == 'thn_pajak_sppt') {
                    $row[] = $aRow->THN_PAJAK_SPPT;
                } else if ($aColumns[$i] == 'pokok') {
                    $row[] = number_format($aRow->POKOK, 0, ',', '.'); // $aRow->pokok;
                } else if ($aColumns[$i] == 'denda') {
                    $row[] = number_format($aRow->DENDA, 0, ',', '.'); // $aRow->denda;
                } else if ($aColumns[$i] == 'bayar') {
                    $row[] = number_format($aRow->BAYAR, 0, ',', '.'); // $aRow->bayar;
                } else {
                    $row[] = $aRow->URAIAN;
                }
                /*
                if ($i > 2)
                    $row[] = number_format($aRow->$aColumns[$i], 0, ',', '.');
                elseif($i == 0)
                    $row[] = date('d-m-Y', strtotime($aRow->$aColumns[$i]));
                else
                    $row[] = $aRow->$aColumns[$i];
*/
            }

            /*
            $pg_pokok += $aRow->$aColumns[3];
            $pg_denda += $aRow->$aColumns[4];
            $pg_total += $aRow->$aColumns[5];
            */
            $pg_pokok += $aRow->POKOK;
            $pg_denda += $aRow->DENDA;
            $pg_total += $aRow->BAYAR;



            $output['aaData'][] = $row;
        }

        $output['pokok'] = number_format($pg_pokok, 0, ',', '.');
        $output['denda'] = number_format($pg_denda, 0, ',', '.');
        $output['total'] = number_format($pg_total, 0, ',', '.');

        echo json_encode($output);
    }

    function tranmonths()
    {
        // ob_start("ob_gzhandler");


        $buku        = (isset($_GET['buku'])) ? $_GET['buku'] : '11';
        $bukumin     = $this->pbbm_model->rangebuku[substr($buku, 0, 1)][0];
        $bukumax     = $this->pbbm_model->rangebuku[substr($buku, 1, 1)][1];
        $tahun       = (isset($_GET['tahun'])) ? $_GET['tahun'] : date('Y');
        $tahun_sppt1 = (isset($_GET['tahun_sppt1'])) ? $_GET['tahun_sppt1'] : date('Y');
        $tahun_sppt2 = (isset($_GET['tahun_sppt2'])) ? $_GET['tahun_sppt2'] : date('Y');

        $kec_kd = (isset($_GET['kec_kd']) ? $_GET['kec_kd'] : ($this->session->userdata('user_def_kec') ? $this->session->userdata('user_def_kec') : '000'));
        $kel_kd = (isset($_GET['kel_kd']) ? $_GET['kel_kd'] : ($this->session->userdata('user_def_kel_' . $kec_kd) ? $this->session->userdata('user_def_kel_' . $kec_kd) : '000'));

        $path_to_root = active_module_url();

        $aColumns     = array(
            'kode',
            'uraian',
            'thn_pajak_sppt',
            'pokok',
            'denda',
            'bayar'
        );
        $sIndexColumn = "kode";

        $iDisplayLength = (isset($_GET['iDisplayLength']) && is_numeric($_GET['iDisplayLength'])) ? $_GET['iDisplayLength'] : 15;
        $iDisplayStart  = (isset($_GET['iDisplayStart']) && is_numeric($_GET['iDisplayStart'])) ? $_GET['iDisplayStart'] : 0;

        $iSortCol_0   = (isset($_GET['iSortCol_0']) && is_numeric($_GET['iSortCol_0'])) ? $_GET['iSortCol_0'] : 0;
        $iSortingCols = (isset($_GET['iSortingCols']) && is_numeric($_GET['iSortingCols'])) ? $_GET['iSortingCols'] : 1;
        $sSortDir_0   = (isset($_GET['sSortDir_0'])) ? $_GET['sSortDir_0'] : "asc";

        $sEcho = (isset($_GET['sEcho']) && is_numeric($_GET['sEcho'])) ? $_GET['sEcho'] : 1;

        $sSearch   = (isset($_GET['sSearch'])) ? $_GET['sSearch'] : "";
        $sSearch_0 = (isset($_GET['sSearch_0'])) ? $_GET['sSearch_0'] : "";
        $sSearch_1 = (isset($_GET['sSearch_1'])) ? $_GET['sSearch_1'] : "";
        $sSearch_2 = (isset($_GET['sSearch_2'])) ? $_GET['sSearch_2'] : "";
        $sSearch_3 = (isset($_GET['sSearch_3'])) ? $_GET['sSearch_3'] : "";
        $sSearch_4 = (isset($_GET['sSearch_4'])) ? $_GET['sSearch_4'] : "";

        /*
         * Limit
         */

        $sLimit = "";
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            // $sLimit = "LIMIT " . $_GET['iDisplayLength'] . " OFFSET " . $_GET['iDisplayStart'];
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

            $sOrder = substr_replace($sOrder, "", -2) . ", kode";
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

        $search = '';
        if ($sSearch)
            $search .= " AND tp.nm_tp ilike '%$sSearch%'";

        $where = "WHERE extract(year FROM p.tgl_pembayaran_sppt)= $tahun
            AND k.pbb_yg_harus_dibayar_sppt between $bukumin AND $bukumax
            AND p.thn_pajak_sppt between '$tahun_sppt1' AND '$tahun_sppt2' ";
        // AND p.kd_propinsi='" . KD_PROPINSI . "' AND p.kd_dati2='" . KD_DATI2 . "' ";

        if ($kec_kd != "000")
            $where .= " AND p.kd_kecamatan='$kec_kd'";
        if ($kel_kd != "000")
            $where .= " AND p.kd_kelurahan='$kel_kd'";

        // POS_FIELD
        $fields     = explode(',', POS_FIELD);
        $pos_fld    = '';
        $pos_join   = '';
        $pos_uraian = '';
        $fs = '';
        foreach ($fields as $f) {
            $fs = $f;
            if ($f == 'kd_kanwil_bank')
                $fs = 'kd_kanwil';
            else if ($f == 'kd_kppbb_bank')
                $fs = 'kd_kppbb';

            $pos_fld .= "p.{$f}, ";
            $pos_join .= "p.{$f}=tp.{$fs} and ";
            $pos_uraian .= "tp.{$fs}||";
        }
        $pos_fld = substr($pos_fld, 0, -2);
        $pos_join = substr($pos_join, 0, -4);
        $pos_uraian = substr($pos_uraian, 0, -2);

        $tp_kd = (isset($_GET['tp_kd'])) ? $_GET['tp_kd'] : '';
        if ($tp_kd != "") {
            $where .= " AND {$pos_uraian} = '{$tp_kd}'";
        }

        /*
         * Output
         */
        $sql_query_r = "SELECT  Extract(month FROM tgl_pembayaran_sppt) kode,
            {$pos_uraian}||':'||tp.nm_tp uraian, p.thn_pajak_sppt,
            sum(p.jml_sppt_yg_dibayar - p.denda_sppt)  pokok,
            sum(p.denda_sppt) denda, sum(p.jml_sppt_yg_dibayar) bayar
            FROM sppt k
            INNER JOIN pembayaran_sppt p
            ON k.kd_propinsi = p.kd_propinsi
            AND k.kd_dati2 = p.kd_dati2
            AND k.kd_kecamatan = p.kd_kecamatan
            AND k.kd_kelurahan = p.kd_kelurahan
            AND k.kd_blok = p.kd_blok
            AND k.no_urut = p.no_urut
            AND k.kd_jns_op = p.kd_jns_op
            AND k.thn_pajak_sppt = p.thn_pajak_sppt
            LEFT JOIN tempat_pembayaran tp ON {$pos_join}
            $where $search
            GROUP BY 1,EXTRACT(MONTH FROM tgl_pembayaran_sppt), 2, 3, tp.kd_kanwil || tp.kd_kantor || tp.kd_tp || ':' || tp.nm_tp, p.thn_pajak_sppt
            ORDER BY 1,2,3 ";
        $sql_query_r .= "$sOrder $sLimit";

        $output = array(
            "sEcho" => $sEcho,
            // "iTotalRecords" => $iTotal,
            // "iTotalDisplayRecords" => $iFiltered,
            // "SQL Query" => $sql_query_r,
            "aaData" => array()
        );

        $qry      = $this->db->query($sql_query_r);
        $pg_pokok = 0;
        $pg_denda = 0;
        $pg_total = 0;
        foreach ($qry->result() as $aRow) {

            $row = array();
            for ($i = 0; $i < count($aColumns); $i++) {

                if ($aColumns[$i] == 'kode') {
                    $row[] =  $aRow->KODE . ':' . namabulan($aRow->KODE); // $aRow->kode;
                } else if ($aColumns[$i] == 'thn_pajak_sppt') {
                    $row[] = $aRow->THN_PAJAK_SPPT;
                } else if ($aColumns[$i] == 'pokok') {
                    $row[] = number_format($aRow->POKOK, 0, ',', '.'); // $aRow->pokok;
                } else if ($aColumns[$i] == 'denda') {
                    $row[] = number_format($aRow->DENDA, 0, ',', '.'); // $aRow->denda;
                } else if ($aColumns[$i] == 'bayar') {
                    $row[] = number_format($aRow->BAYAR, 0, ',', '.'); // $aRow->bayar;
                } else {
                    $row[] = $aRow->URAIAN;
                }

                /*
                if ($i == 0) {
                    $row[] = $aRow->$aColumns[$i] . ':' . namabulan($aRow->$aColumns[$i]);
                } else if ($i > 2) {
                    $row[] = number_format($aRow->$aColumns[$i], 0, ',', '.');
                } else
                    $row[] = $aRow->$aColumns[$i];
                */
            }

            /*
            $pg_pokok += $aRow->$aColumns[3];
            $pg_denda += $aRow->$aColumns[4];
            $pg_total += $aRow->$aColumns[5];
            */
            $pg_pokok += $aRow->POKOK;
            $pg_denda += $aRow->DENDA;
            $pg_total += $aRow->BAYAR;

            $output['aaData'][] = $row;
        }

        $output['pokok'] = number_format($pg_pokok, 0, ',', '.');
        $output['denda'] = number_format($pg_denda, 0, ',', '.');
        $output['total'] = number_format($pg_total, 0, ',', '.');

        echo json_encode($output);
    }

    function realisasi_ori()
    {
        ob_start("ob_gzhandler");

        $path_to_root = active_module_url();

        $aColumns     = array(
            'kode',
            'uraian',
            'sppt1',
            'amount1',
            'sppt2',
            'amount2',
            'sppt3',
            'amount3',
            'sppt4',
            'amount4',
            'prsn1',
            'sppt5',
            'amount5',
            'prsn2'
        );
        $sIndexColumn = "kode";

        $iDisplayLength = (isset($_GET['iDisplayLength']) && is_numeric($_GET['iDisplayLength'])) ? $_GET['iDisplayLength'] : 15;
        $iDisplayStart  = (isset($_GET['iDisplayStart']) && is_numeric($_GET['iDisplayStart'])) ? $_GET['iDisplayStart'] : 0;
        $iSortCol_0     = (isset($_GET['iSortCol_0']) && is_numeric($_GET['iSortCol_0'])) ? $_GET['iSortCol_0'] : 0;
        $iSortingCols   = (isset($_GET['iSortingCols']) && is_numeric($_GET['iSortingCols'])) ? $_GET['iSortingCols'] : 1;
        $sEcho          = (isset($_GET['sEcho']) && is_numeric($_GET['sEcho'])) ? $_GET['sEcho'] : 1;
        $sSearch        = (isset($_GET['sSearch'])) ? $_GET['sSearch'] : "";
        $sSearch_0      = (isset($_GET['sSearch_0'])) ? $_GET['sSearch_0'] : "";
        $sSearch_1      = (isset($_GET['sSearch_1'])) ? $_GET['sSearch_1'] : "";
        $sSearch_2      = (isset($_GET['sSearch_2'])) ? $_GET['sSearch_2'] : "";
        $sSearch_3      = (isset($_GET['sSearch_3'])) ? $_GET['sSearch_3'] : "";
        $sSearch_4      = (isset($_GET['sSearch_4'])) ? $_GET['sSearch_4'] : "";
        $sSortDir_0     = (isset($_GET['sSortDir_0'])) ? $_GET['sSortDir_0'] : "asc";

        /*
         * Limit
         */

        $sLimit  = "";
        $sSearch = "";
        $search  = '';
        /*
         * Ordering
         */
        $sOrder  = "";

        /* Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        $sWhere = "";

        $tahun    = (isset($_GET['tahun'])) ? $_GET['tahun'] : date('Y');
        $buku     = (isset($_GET['buku'])) ? $_GET['buku'] : '11';
        $nop_kd   = (isset($_GET['nop_kd']) && is_numeric($_GET['nop_kd'])) ? $_GET['kel_kd'] : '000000000000000000';
        $tglawal  = (isset($_GET['tglawal'])) ? $_GET['tglawal'] : date('d-m-Y');
        $tglakhir = (isset($_GET['tglakhir'])) ? $_GET['tglakhir'] : date('d-m-Y');

        $tglm = substr($tglawal, 6, 4) . '-' . substr($tglawal, 3, 2) . '-' . substr($tglawal, 0, 2);
        $tgls = substr($tglakhir, 6, 4) . '-' . substr($tglakhir, 3, 2) . '-' . substr($tglakhir, 0, 2);

        $kec_kd = (isset($_GET['kec_kd']) ? $_GET['kec_kd'] : ($this->session->userdata('user_def_kec') ? $this->session->userdata('user_def_kec') : '000'));
        $kel_kd = (isset($_GET['kel_kd']) ? $_GET['kel_kd'] : ($this->session->userdata('user_def_kel_' . $kec_kd) ? $this->session->userdata('user_def_kel_' . $kec_kd) : '000'));

        /*
         * SQL queries
         * Get data to display
         */

        if ($kec_kd == '000') {
            $iDisplayLength = 0;
            $sql_query_c = "SELECT COUNT(*) AS c FROM ref_kecamatan ";
            $sql_query_r = $this->pbbm_model->qry_realisasi_kec($tahun, $tglm, $tgls, $buku);
        } else if ($kel_kd == '000') {
            $iDisplayLength = 0;
            $sql_query_c = "SELECT COUNT(*) AS c FROM ref_kelurahan k
                WHERE k.kd_propinsi='" . KD_PROPINSI . "'
                AND k.kd_dati2='" . KD_DATI2 . "'
                AND k.kd_kecamatan='$kec_kd'";
            $sql_query_r = $this->pbbm_model->qry_realisasi_kel($tahun, $tglm, $tgls, $kec_kd, $buku);
        } else if ($nop_kd = '000000000000000000') {
            //$sLimit  = "LIMIT  $iDisplayLength OFFSET $iDisplayStart";
            $sSearch = (isset($_GET['sSearch'])) ? $_GET['sSearch'] : "";
            if ($sSearch)
                $search .= " AND a.nm_wp_sppt ilike '%$sSearch%' ";
            $bukumin = $this->pbbm_model->rangebuku[substr($buku, 0, 1)][0];
            $bukumax = $this->pbbm_model->rangebuku[substr($buku, 1, 1)][1];
            $search .= " AND a.pbb_yg_harus_dibayar_sppt between $bukumin AND $bukumax";
            $sql_query_c = "
                SELECT COUNT(*) AS c
                FROM sppt a
                WHERE a.kd_propinsi='" . KD_PROPINSI . "'
                AND a.kd_dati2='" . KD_DATI2 . "'
                AND a.kd_kecamatan='$kec_kd'
                AND a.kd_kelurahan='$kel_kd'
                AND a.thn_pajak_sppt='$tahun' ";

            $sql_query_r = $this->pbbm_model->qry_realisasi_op($tahun, $tglm, $tgls, $kec_kd, $kel_kd, $buku);

            if ($search) {
                $sql_query_r = str_replace('AND (1=1)', $search, $sql_query_r);
            }
        }

        /*
         * Output
         */
        $output = array(
            "sEcho" => $sEcho,
            "iTotalRecords" => 0, //$iTotal,
            "iTotalDisplayRecords" => 0, //$iFilteredTotal,
            "SQL Query" => $sql_query_r,
            "aaData" => array()
        );
        $nsppt1 = 0;
        $nsppt2 = 0;
        $nsppt3 = 0;
        $nsppt4 = 0;
        $nsppt5 = 0;
        $amount1 = 0;
        $amount2 = 0;
        $amount3 = 0;
        $amount4 = 0;
        $amount5 = 0;

        $qry = $this->db_pbbm->query($sql_query_r . " $sOrder $sLimit");
        foreach ($qry->result() as $aRow) {
            $row = array();
            for ($i = 0; $i < count($aColumns); $i++) {
                if ($i == 1) {
                    if ($kec_kd == '000')
                        $row[] = "<a href=\"" . active_module_url() . "realisasi?tahun=$tahun&buku=$buku&tgawal=$tglawal&tglakhir=$tglakhir&kec_kd=" . substr($aRow->kode, -3) . "\">" . $aRow->$aColumns[$i] . "</a>";
                    else if ($kel_kd == '000')
                        $row[] = "<a href=\"" . active_module_url() . "realisasi?tahun=$tahun&buku=$buku&tgawal=$tglawal&tglakhir=$tglakhir&kec_kd=$kec_kd&kel_kd=" . substr($aRow->kode, -3) . "\">" . $aRow->$aColumns[$i] . "</a>";
                    else if ($nop_kd == '000000000000000000')
                        $row[] = "<a href=\"" . active_module_url() . "op?&nop_kd=" . $aRow->kode . "\">" . $aRow->$aColumns[$i] . "</a>";
                } else if ($aColumns[$i] == 'sppt4') {
                    $row[] = number_format($aRow->sppt2 + $aRow->sppt3, 0, ',', '.');
                    $nsppt4 += $aRow->sppt2 + $aRow->sppt3;
                } else if ($aColumns[$i] == 'amount4') {
                    $row[] = number_format($aRow->amount2 + $aRow->amount3, 0, ',', '.');
                    $amount4 += $aRow->amount2 + $aRow->amount3;
                } else if ($aColumns[$i] == 'prsn1') {
                    if ($aRow->amount1 > 0)
                        $row[] = number_format(($aRow->amount2 + $aRow->amount3) / $aRow->amount1 * 100, 2, ',', '.');
                    else
                        $row[] = number_format(0, 0, ',', '.');
                } else if ($aColumns[$i] == 'sppt5') {

                    $row[] = number_format($aRow->sppt1 - $aRow->sppt2 - $aRow->sppt3, 0, ',', '.');
                    $nsppt5 += $aRow->sppt1 - $aRow->sppt2 - $aRow->sppt3;
                } else if ($aColumns[$i] == 'amount5') {
                    $row[] = number_format($aRow->amount1 - $aRow->amount2 - $aRow->amount3, 0, ',', '.');
                    $amount5 += $aRow->amount1 - $aRow->amount2 - $aRow->amount3;
                } else if ($aColumns[$i] == 'prsn2') {
                    if ($aRow->amount1 > 0)
                        $row[] = number_format(($aRow->amount1 - $aRow->amount2 - $aRow->amount3) / $aRow->amount1 * 100, 2, ',', '.');
                    else
                        $row[] = number_format(0, 0, ',', '.');
                } else if ($i > 1)
                    $row[] = number_format($aRow->$aColumns[$i], 0, ',', '.');
                else {
                    $row[] = $aRow->$aColumns[$i];
                }
            }
            $nsppt1 += $aRow->sppt1;
            $nsppt2 += $aRow->sppt2;
            $nsppt3 += $aRow->sppt3;
            $amount1 += $aRow->amount1;
            $amount2 += $aRow->amount2;
            $amount3 += $aRow->amount3;

            $output['aaData'][] = $row;
        }

        $output['nsppt1'] = number_format($nsppt1, 0, ',', '.');
        $output['amount1'] = number_format($amount1, 0, ',', '.');
        $output['nsppt2'] = number_format($nsppt2, 0, ',', '.');
        $output['amount2'] = number_format($amount2, 0, ',', '.');
        $output['nsppt3'] = number_format($nsppt3, 0, ',', '.');
        $output['amount3'] = number_format($amount3, 0, ',', '.');
        $output['nsppt4'] = number_format($nsppt4, 0, ',', '.');
        $output['amount4'] = number_format($amount4, 0, ',', '.');
        $output['persen1'] = number_format(($amount1 > 0 ? $amount4 / $amount1 * 100 : 0), 2, ',', '.');
        $output['nsppt5'] = number_format($nsppt5, 0, ',', '.');
        $output['amount5'] = number_format($amount5, 0, ',', '.');
        $output['persen2'] = number_format(($amount1 > 0 ? $amount5 / $amount1 * 100 : 0), 2, ',', '.');

        echo json_encode($output);
    }

    function realisasi()
    {
        // ini_set('max_execution_time', 300); // 5 menit
        // ini_set('memory_limit', '512M');

        ob_start("ob_gzhandler");

        $path_to_root = active_module_url();

            // 'kode',
            // 'uraian',
            // 'sppt1',
            // 'amount1',
            // 'sppt2',
            // 'amount2',
            // 'sppt3',
            // 'amount3',
            // 'sppt4',
            // 'amount4',
            // 'prsn1',
            // 'sppt5',
            // 'amount5',
            // 'prsn2'

        $aColumns     = array(
            'KODE',
            'URAIAN',
            'SPPT1',
            'AMOUNT1',
            'SPPT2',
            'AMOUNT2',
            'SPPT3',
            'AMOUNT3',
            'SPPT4',
            'AMOUNT4',
            'PRSN1',
            'SPPT5',
            'AMOUNT5',
            'PRSN2'
        );

        $sIndexColumn = "kode";

        $iDisplayLength = (isset($_GET['iDisplayLength']) && is_numeric($_GET['iDisplayLength'])) ? $_GET['iDisplayLength'] : 15;
        $iDisplayStart  = (isset($_GET['iDisplayStart']) && is_numeric($_GET['iDisplayStart'])) ? $_GET['iDisplayStart'] : 0;
        $iSortCol_0     = (isset($_GET['iSortCol_0']) && is_numeric($_GET['iSortCol_0'])) ? $_GET['iSortCol_0'] : 0;
        $iSortingCols   = (isset($_GET['iSortingCols']) && is_numeric($_GET['iSortingCols'])) ? $_GET['iSortingCols'] : 1;
        $sEcho          = (isset($_GET['sEcho']) && is_numeric($_GET['sEcho'])) ? $_GET['sEcho'] : 1;
        $sSearch        = (isset($_GET['sSearch'])) ? $_GET['sSearch'] : "";
        $sSearch_0      = (isset($_GET['sSearch_0'])) ? $_GET['sSearch_0'] : "";
        $sSearch_1      = (isset($_GET['sSearch_1'])) ? $_GET['sSearch_1'] : "";
        $sSearch_2      = (isset($_GET['sSearch_2'])) ? $_GET['sSearch_2'] : "";
        $sSearch_3      = (isset($_GET['sSearch_3'])) ? $_GET['sSearch_3'] : "";
        $sSearch_4      = (isset($_GET['sSearch_4'])) ? $_GET['sSearch_4'] : "";
        $sSortDir_0     = (isset($_GET['sSortDir_0'])) ? $_GET['sSortDir_0'] : "asc";

        /*
         * Limit
         */

        $sLimit  = "";
        $sSearch = "";
        $search  = '';
        /*
         * Ordering
         */
        $sOrder  = "";

        /* Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        $sWhere = "";

        $tahun    = (isset($_GET['tahun'])) ? $_GET['tahun'] : date('Y');
        $buku     = (isset($_GET['buku'])) ? $_GET['buku'] : '11';
        $nop_kd   = (isset($_GET['nop_kd']) && is_numeric($_GET['nop_kd'])) ? $_GET['kel_kd'] : '000000000000000000';
        $tglawal  = (isset($_GET['tglawal'])) ? $_GET['tglawal'] : date('d-m-Y');
        $tglakhir = (isset($_GET['tglakhir'])) ? $_GET['tglakhir'] : date('d-m-Y');

        $tglm = substr($tglawal, 6, 4) . '-' . substr($tglawal, 3, 2) . '-' . substr($tglawal, 0, 2);
        $tgls = substr($tglakhir, 6, 4) . '-' . substr($tglakhir, 3, 2) . '-' . substr($tglakhir, 0, 2);

        $kec_kd = (isset($_GET['kec_kd']) ? $_GET['kec_kd'] : ($this->session->userdata('user_def_kec') ? $this->session->userdata('user_def_kec') : '000'));
        $kel_kd = (isset($_GET['kel_kd']) ? $_GET['kel_kd'] : ($this->session->userdata('user_def_kel_' . $kec_kd) ? $this->session->userdata('user_def_kel_' . $kec_kd) : '000'));

        /*
         * SQL queries
         * Get data to display
         */

        if ($kec_kd == '000') {
            $iDisplayLength = 0;
            $sql_query_c = "SELECT COUNT(*) AS c FROM ref_kecamatan ";
            $sql_query_r = $this->pbbm_model->qry_realisasi_kec($tahun, $tglm, $tgls, $buku);
        } else if ($kel_kd == '000') {
            $iDisplayLength = 0;
            $sql_query_c = "SELECT COUNT(*) AS c FROM ref_kelurahan k
                WHERE k.kd_propinsi='" . KD_PROPINSI . "'
                AND k.kd_dati2='" . KD_DATI2 . "'
                AND k.kd_kecamatan='$kec_kd'";
            $sql_query_r = $this->pbbm_model->qry_realisasi_kel($tahun, $tglm, $tgls, $kec_kd, $buku);
        } else if ($nop_kd == '000000000000000000') {
            //$sLimit  = "LIMIT  $iDisplayLength OFFSET $iDisplayStart";
            $sSearch = (isset($_GET['sSearch'])) ? $_GET['sSearch'] : "";
            if ($sSearch)
                $search .= " AND a.nm_wp_sppt ilike '%$sSearch%' ";
            $bukumin = $this->pbbm_model->rangebuku[substr($buku, 0, 1)][0];
            $bukumax = $this->pbbm_model->rangebuku[substr($buku, 1, 1)][1];
            $search .= " AND a.pbb_yg_harus_dibayar_sppt between $bukumin AND $bukumax";
            $sql_query_c = "
                SELECT COUNT(*) AS c
                FROM sppt a
                WHERE a.kd_propinsi='" . KD_PROPINSI . "'
                AND a.kd_dati2='" . KD_DATI2 . "'
                AND a.kd_kecamatan='$kec_kd'
                AND a.kd_kelurahan='$kel_kd'
                AND a.thn_pajak_sppt='$tahun' ";

            $sql_query_r = $this->pbbm_model->qry_realisasi_op($tahun, $tglm, $tgls, $kec_kd, $kel_kd, $buku);

            if ($search) {
                $sql_query_r = str_replace('AND (1=1)', $search, $sql_query_r);
            }
        }

        /*
         * Output
         */
        $output = array(
            "sEcho" => $sEcho,
            "iTotalRecords" => 0, //$iTotal,
            "iTotalDisplayRecords" => 0, //$iFilteredTotal,
            "SQL Query" => $sql_query_r,
            "aaData" => array()
        );
        $nsppt1 = 0;
        $nsppt2 = 0;
        $nsppt3 = 0;
        $nsppt4 = 0;
        $nsppt5 = 0;
        $amount1 = 0;
        $amount2 = 0;
        $amount3 = 0;
        $amount4 = 0;
        $amount5 = 0;

        // var_dump($sql_query_r . " $sOrder $sLimit");
        // die;

        $query_full = $sql_query_r;
        if (!empty($sOrder)) $query_full .= " $sOrder";
        if (!empty($sLimit)) $query_full .= " $sLimit";

        $qry = $this->db->query($query_full);

        //var_dump($qry->result());die;

        //$qry = $this->db->query($sql_query_r . " $sOrder $sLimit");

        // var_dump($sql_query_r . " $sOrder $sLimit"); die;
        foreach ($qry->result() as $aRow) {

            $row = array();

            for ($i = 0; $i < count($aColumns); $i++) {

                //if ($i == 1) {
                if ($aColumns[$i] == 'KODE') {
                    if ($kec_kd == '000'){
                        $row[] = "<a href=\"" . active_module_url() . "realisasi?tahun=$tahun&buku=$buku&tgawal=$tglawal&tglakhir=$tglakhir&kec_kd=" . substr($aRow->KODE, -3) . "\">" . $aRow->KODE . "</a>";
                    }
                    else if ($kel_kd == '000'){
                        $row[] = "<a href=\"" . active_module_url() . "realisasi?tahun=$tahun&buku=$buku&tgawal=$tglawal&tglakhir=$tglakhir&kec_kd=$kec_kd&kel_kd=" . substr($aRow->KODE, -3) . "\">" . $aRow->KODE . "</a>";
                    }
                    else if ($nop_kd == '000000000000000000'){
                        $row[] = "<a href=\"" . active_module_url() . "op?&nop_kd=" . $aRow->KODE . "\">" . $aRow->KODE . "</a>";
                    }
                } else if ($aColumns[$i] == 'SPPT4') {
                    $row[] = number_format($aRow->SPPT2 + $aRow->SPPT3, 0, ',', '.');
                    $nsppt4 += $aRow->SPPT2 + $aRow->SPPT3;
                } else if ($aColumns[$i] == 'AMOUNT4') {
                    $row[] = number_format($aRow->AMOUNT2 + $aRow->AMOUNT3, 0, ',', '.');
                    $amount4 += $aRow->AMOUNT2 + $aRow->AMOUNT3;
                } else if ($aColumns[$i] == 'PRSN1') {
                    if ($aRow->AMOUNT1 > 0) {
                        $row[] = number_format(($aRow->AMOUNT2 + $aRow->AMOUNT3) / $aRow->AMOUNT1 * 100, 2, ',', '.');
                    } else {
                        $row[] = number_format(0, 0, ',', '.');
                    }
                } else if ($aColumns[$i] == 'SPPT5') {
                    $row[] = number_format($aRow->SPPT1 - $aRow->SPPT2 - $aRow->SPPT3, 0, ',', '.');
                    $nsppt5 += $aRow->SPPT1 - $aRow->SPPT2 - $aRow->SPPT3;
                } else if ($aColumns[$i] == 'AMOUNT5') {
                    $row[] = number_format($aRow->AMOUNT1 - $aRow->AMOUNT2 - $aRow->AMOUNT3, 0, ',', '.');
                    $amount5 += $aRow->AMOUNT1 - $aRow->AMOUNT2 - $aRow->AMOUNT3;
                } else if ($aColumns[$i] == 'PRSN2') {
                    if ($aRow->AMOUNT1 > 0) {
                        $row[] = number_format(($aRow->AMOUNT1 - $aRow->AMOUNT2 - $aRow->AMOUNT3) / $aRow->AMOUNT1 * 100, 2, ',', '.');
                    } else {
                        $row[] = number_format(0, 0, ',', '.');
                    }
                } else if ($aColumns[$i] == 'URAIAN') {
                    $row[] = $aRow->URAIAN;
                } else {
                    // 'sppt1','amount1','sppt2','amount2','sppt3','amount3'
                    $field = $aColumns[$i];
                    
                    $row[] = number_format($aRow->$field, 0, ',', '.');
                }
            }

            $nsppt1 += $aRow->SPPT1;
            $nsppt2 += $aRow->SPPT2;
            $nsppt3 += $aRow->SPPT3;
            $amount1 += $aRow->AMOUNT1;
            $amount2 += $aRow->AMOUNT2;
            $amount3 += $aRow->AMOUNT3;

            $output['aaData'][] = $row;
        }

        $output['nsppt1'] = number_format($nsppt1, 0, ',', '.');
        $output['amount1'] = number_format($amount1, 0, ',', '.');
        $output['nsppt2'] = number_format($nsppt2, 0, ',', '.');
        $output['amount2'] = number_format($amount2, 0, ',', '.');
        $output['nsppt3'] = number_format($nsppt3, 0, ',', '.');
        $output['amount3'] = number_format($amount3, 0, ',', '.');
        $output['nsppt4'] = number_format($nsppt4, 0, ',', '.');
        $output['amount4'] = number_format($amount4, 0, ',', '.');
        $output['persen1'] = number_format(($amount1 > 0 ? $amount4 / $amount1 * 100 : 0), 2, ',', '.');
        $output['nsppt5'] = number_format($nsppt5, 0, ',', '.');
        $output['amount5'] = number_format($amount5, 0, ',', '.');
        $output['persen2'] = number_format(($amount1 > 0 ? $amount5 / $amount1 * 100 : 0), 2, ',', '.');

        echo json_encode($output);
    }

    function lb_ori()
    {
        // ob_start("ob_gzhandler");
        //$this->load->model("pbbm_model");

        $path_to_root = active_module_url();

        $aColumns     = array(
            'kode',
            'uraian',
            'sppt1',
            'amount1',
            'amount2',
            'amount3'
        );
        $sIndexColumn = "kode";

        $iDisplayLength = (isset($_GET['iDisplayLength']) && is_numeric($_GET['iDisplayLength'])) ? $_GET['iDisplayLength'] : 15;
        $iDisplayStart  = (isset($_GET['iDisplayStart']) && is_numeric($_GET['iDisplayStart'])) ? $_GET['iDisplayStart'] : 0;
        $iSortCol_0     = (isset($_GET['iSortCol_0']) && is_numeric($_GET['iSortCol_0'])) ? $_GET['iSortCol_0'] : 0;
        $iSortingCols   = (isset($_GET['iSortingCols']) && is_numeric($_GET['iSortingCols'])) ? $_GET['iSortingCols'] : 1;
        $sEcho          = (isset($_GET['sEcho']) && is_numeric($_GET['sEcho'])) ? $_GET['sEcho'] : 1;
        $sSearch        = (isset($_GET['sSearch'])) ? $_GET['sSearch'] : "";
        $sSearch_0      = (isset($_GET['sSearch_0'])) ? $_GET['sSearch_0'] : "";
        $sSearch_1      = (isset($_GET['sSearch_1'])) ? $_GET['sSearch_1'] : "";
        $sSearch_2      = (isset($_GET['sSearch_2'])) ? $_GET['sSearch_2'] : "";
        $sSearch_3      = (isset($_GET['sSearch_3'])) ? $_GET['sSearch_3'] : "";
        $sSearch_4      = (isset($_GET['sSearch_4'])) ? $_GET['sSearch_4'] : "";
        $sSortDir_0     = (isset($_GET['sSortDir_0'])) ? $_GET['sSortDir_0'] : "asc";

        /*
         * Limit
         */

        $sLimit  = "";
        $sSearch = "";
        $search  = '';
        /*
         * Ordering
         */
        $sOrder  = "";

        /* Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        $sWhere = "";

        $tahun  = (isset($_GET['tahun'])) ? $_GET['tahun'] : date('Y');
        $nop_kd = (isset($_GET['nop_kd']) && is_numeric($_GET['nop_kd'])) ? $_GET['kel_kd'] : '000000000000000000';

        $kec_kd = (isset($_GET['kec_kd']) ? $_GET['kec_kd'] : ($this->session->userdata('user_def_kec') ? $this->session->userdata('user_def_kec') : '000'));
        $kel_kd = (isset($_GET['kel_kd']) ? $_GET['kel_kd'] : ($this->session->userdata('user_def_kel_' . $kec_kd) ? $this->session->userdata('user_def_kel_' . $kec_kd) : '000'));

        /*
         * SQL queries
         * Get data to display
         */

        if ($kec_kd == '000') {
            $sql_query_c = "SELECT COUNT(*) AS c FROM ref_kecamatan ";
            $sql_query_r = $this->pbbm_model->qry_realisasi_lb_kec($tahun);
        } else if ($kel_kd == '000') {
            $sql_query_c = "SELECT COUNT(*) AS c FROM ref_kelurahan k
                WHERE k.kd_propinsi='" . KD_PROPINSI . "'
                AND k.kd_dati2='" . KD_DATI2 . "'
                AND k.kd_kecamatan='$kec_kd'";
            $sql_query_r = $this->pbbm_model->qry_realisasi_lb_kel($tahun, $kec_kd);
        } else if ($nop_kd = '000000000000000000') {
            // $sLimit  = "LIMIT  $iDisplayLength OFFSET $iDisplayStart";
            $sSearch = (isset($_GET['sSearch'])) ? $_GET['sSearch'] : "";
            if ($sSearch)
                $search .= " AND a.nm_wp_sppt ilike '%$sSearch%' ";

            $sql_query_r = $this->pbbm_model->qry_realisasi_lb_op($tahun, $kec_kd, $kel_kd);

            if ($search) {
                $sql_query_r = str_replace('AND (1=1)', $search, $sql_query_r);
            }
        }

        $sql_query_c = "SELECT COUNT(*) AS c FROM ($sql_query_r) z";

        /*
         * Output
         */

        $output   = array(
            "sEcho" => $sEcho,
            "iTotalRecords" => 0, //$iTotal,
            "iTotalDisplayRecords" => 0, //$iFilteredTotal,
            "iDisplayStart" => 0, //$iDisplayStart,
            // "SQL Query" => $sql_query_r,
            "aaData" => array()
        );
        //die($sql_query_r." $sOrder $sLimit");
        $qry      = $this->db_pbbm->query($sql_query_r . " $sOrder $sLimit");
        $pg_sppt  = 0;
        $pg_pokok = 0;
        $pg_denda = 0;
        $pg_total = 0;

        foreach ($qry->result() as $aRow) {
            $row = array();
            for ($i = 0; $i < count($aColumns); $i++) {
                if ($i == 1) {
                    if ($kec_kd == '000')
                        $row[] = "<a href=\"" . active_module_url() . "lb?tahun=$tahun&kec_kd=" . substr($aRow->kode, -3) . "\">" . $aRow->$aColumns[$i] . "</a>";
                    else if ($kel_kd == '000')
                        $row[] = "<a href=\"" . active_module_url() . "lb?tahun=$tahun&kec_kd=$kec_kd&kel_kd=" . substr($aRow->kode, -3) . "\">" . $aRow->$aColumns[$i] . "</a>";
                    else if ($nop_kd == '000000000000000000')
                        $row[] = "<a href=\"" . active_module_url() . "op?&nop_kd=" . $aRow->kode . "\">" . $aRow->$aColumns[$i] . "</a>";
                } else if ($aColumns[$i] == 'amount3') {
                    $row[] = number_format($aRow->amount1 - $aRow->amount2, 0, ',', '.');
                } else if ($i > 1)
                    $row[] = number_format($aRow->$aColumns[$i], 0, ',', '.');
                else
                    $row[] = $aRow->$aColumns[$i];
            }
            $pg_sppt += $aRow->$aColumns[2];
            $pg_pokok += $aRow->$aColumns[3];
            $pg_denda += $aRow->$aColumns[4];
            $pg_total += $aRow->$aColumns[5];
            $output['aaData'][] = $row;
        }

        $output['sppt']  = number_format($pg_sppt, 0, ',', '.');
        $output['pokok'] = number_format($pg_pokok, 0, ',', '.');
        $output['denda'] = number_format($pg_denda, 0, ',', '.');
        $output['total'] = number_format($pg_total, 0, ',', '.');

        echo json_encode($output);
    }

    function lb()
    {
        // ob_start("ob_gzhandler");
        //$this->load->model("pbbm_model");

        $path_to_root = active_module_url();

        $aColumns     = array(
            'kode',
            'uraian',
            'sppt1',
            'amount1',
            'amount2',
            'amount3'
        );
        $sIndexColumn = "kode";

        $iDisplayLength = (isset($_GET['iDisplayLength']) && is_numeric($_GET['iDisplayLength'])) ? $_GET['iDisplayLength'] : 15;
        $iDisplayStart  = (isset($_GET['iDisplayStart']) && is_numeric($_GET['iDisplayStart'])) ? $_GET['iDisplayStart'] : 0;
        $iSortCol_0     = (isset($_GET['iSortCol_0']) && is_numeric($_GET['iSortCol_0'])) ? $_GET['iSortCol_0'] : 0;
        $iSortingCols   = (isset($_GET['iSortingCols']) && is_numeric($_GET['iSortingCols'])) ? $_GET['iSortingCols'] : 1;
        $sEcho          = (isset($_GET['sEcho']) && is_numeric($_GET['sEcho'])) ? $_GET['sEcho'] : 1;
        $sSearch        = (isset($_GET['sSearch'])) ? $_GET['sSearch'] : "";
        $sSearch_0      = (isset($_GET['sSearch_0'])) ? $_GET['sSearch_0'] : "";
        $sSearch_1      = (isset($_GET['sSearch_1'])) ? $_GET['sSearch_1'] : "";
        $sSearch_2      = (isset($_GET['sSearch_2'])) ? $_GET['sSearch_2'] : "";
        $sSearch_3      = (isset($_GET['sSearch_3'])) ? $_GET['sSearch_3'] : "";
        $sSearch_4      = (isset($_GET['sSearch_4'])) ? $_GET['sSearch_4'] : "";
        $sSortDir_0     = (isset($_GET['sSortDir_0'])) ? $_GET['sSortDir_0'] : "asc";

        /*
         * Limit
         */

        $sLimit  = "";
        $sSearch = "";
        $search  = '';
        /*
         * Ordering
         */
        $sOrder  = "";

        /* Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        $sWhere = "";

        $tahun  = (isset($_GET['tahun'])) ? $_GET['tahun'] : date('Y');
        $nop_kd = (isset($_GET['nop_kd']) && is_numeric($_GET['nop_kd'])) ? $_GET['kel_kd'] : '000000000000000000';

        $kec_kd = (isset($_GET['kec_kd']) ? $_GET['kec_kd'] : ($this->session->userdata('user_def_kec') ? $this->session->userdata('user_def_kec') : '000'));
        $kel_kd = (isset($_GET['kel_kd']) ? $_GET['kel_kd'] : ($this->session->userdata('user_def_kel_' . $kec_kd) ? $this->session->userdata('user_def_kel_' . $kec_kd) : '000'));

        /*
         * SQL queries
         * Get data to display
         */

        if ($kec_kd == '000') {
            $sql_query_c = "SELECT COUNT(*) AS c FROM ref_kecamatan ";
            $sql_query_r = $this->pbbm_model->qry_realisasi_lb_kec($tahun);
        } else if ($kel_kd == '000') {
            $sql_query_c = "SELECT COUNT(*) AS c FROM ref_kelurahan k
                WHERE k.kd_propinsi='" . KD_PROPINSI . "'
                AND k.kd_dati2='" . KD_DATI2 . "'
                AND k.kd_kecamatan='$kec_kd'";
            $sql_query_r = $this->pbbm_model->qry_realisasi_lb_kel($tahun, $kec_kd);
        } else if ($nop_kd = '000000000000000000') {
            // $sLimit  = "LIMIT  $iDisplayLength OFFSET $iDisplayStart";
            $sSearch = (isset($_GET['sSearch'])) ? $_GET['sSearch'] : "";
            if ($sSearch)
                $search .= " AND a.nm_wp_sppt ilike '%$sSearch%' ";

            $sql_query_r = $this->pbbm_model->qry_realisasi_lb_op($tahun, $kec_kd, $kel_kd);

            if ($search) {
                $sql_query_r = str_replace('AND (1=1)', $search, $sql_query_r);
            }
        }

        $sql_query_c = "SELECT COUNT(*) AS c FROM ($sql_query_r) z";

        /*
         * Output
         */

        $output   = array(
            "sEcho" => $sEcho,
            "iTotalRecords" => 0, //$iTotal,
            "iTotalDisplayRecords" => 0, //$iFilteredTotal,
            "iDisplayStart" => 0, //$iDisplayStart,
            // "SQL Query" => $sql_query_r,
            "aaData" => array()
        );

        //die($sql_query_r." $sOrder $sLimit");
        $qry      = $this->db->query($sql_query_r . " $sOrder $sLimit");
        $pg_sppt  = 0;
        $pg_pokok = 0;
        $pg_denda = 0;
        $pg_total = 0;

        foreach ($qry->result() as $aRow) {
            $row = array();
            for ($i = 0; $i < count($aColumns); $i++) {
                //if ($i == 1) {
                if ($aColumns[$i] == 'kode') {
                    if ($kec_kd == '000')
                        $row[] = "<a href=\"" . active_module_url() . "lb?tahun=$tahun&kec_kd=" . substr($aRow->KODE, -3) . "\">" . $aRow->KODE . "</a>";
                    else if ($kel_kd == '000')
                        $row[] = "<a href=\"" . active_module_url() . "lb?tahun=$tahun&kec_kd=$kec_kd&kel_kd=" . substr($aRow->KODE, -3) . "\">" . $aRow->KODE . "</a>";
                    else if ($nop_kd == '000000000000000000')
                        $row[] = "<a href=\"" . active_module_url() . "op?&nop_kd=" . $aRow->KODE . "\">" . $aRow->KODE . "</a>";
                } else if ($aColumns[$i] == 'amount3') {
                    $row[] = number_format($aRow->AMOUNT1 - $aRow->AMOUNT2, 0, ',', '.');
                } else if ($aColumns[$i] == 'amount1') {
                    $row[] = number_format($aRow->AMOUNT1, 0, ',', '.');
                } else if ($aColumns[$i] == 'amount2') {
                    $row[] = number_format($aRow->AMOUNT2, 0, ',', '.');
                } else if ($aColumns[$i] == 'sppt1') {
                    $row[] = number_format($aRow->SPPT1, 0, ',', '.');
                } else {
                    $row[] = $aRow->URAIAN;
                }
            }

            // 'kode', 'uraian', 'sppt1', 'amount1', 'amount2', 'amount3'

            $pg_sppt  += $aRow->SPPT1;
            $pg_pokok += $aRow->AMOUNT1;
            $pg_denda += $aRow->AMOUNT2;
            //$pg_total += $aRow->$aColumns[5];
            $pg_total += ($aRow->AMOUNT1 - $aRow->AMOUNT2);
            $output['aaData'][] = $row;
        }

        $output['sppt']  = number_format($pg_sppt, 0, ',', '.');
        $output['pokok'] = number_format($pg_pokok, 0, ',', '.');
        $output['denda'] = number_format($pg_denda, 0, ',', '.');
        $output['total'] = number_format($pg_total, 0, ',', '.');

        echo json_encode($output);
    }

    function kb_ori()
    {
        ob_start("ob_gzhandler");
        //$this->load->model("pbbm_model");

        $path_to_root = active_module_url();

        $aColumns     = array(
            'kode',
            'uraian',
            'sppt1',
            'amount1',
            'amount2',
            'amount3'
        );
        $sIndexColumn = "kode";

        $iDisplayLength = (isset($_GET['iDisplayLength']) && is_numeric($_GET['iDisplayLength'])) ? $_GET['iDisplayLength'] : 15;
        $iDisplayStart  = (isset($_GET['iDisplayStart']) && is_numeric($_GET['iDisplayStart'])) ? $_GET['iDisplayStart'] : 0;
        $iSortCol_0     = (isset($_GET['iSortCol_0']) && is_numeric($_GET['iSortCol_0'])) ? $_GET['iSortCol_0'] : 0;
        $iSortingCols   = (isset($_GET['iSortingCols']) && is_numeric($_GET['iSortingCols'])) ? $_GET['iSortingCols'] : 1;
        $sEcho          = (isset($_GET['sEcho']) && is_numeric($_GET['sEcho'])) ? $_GET['sEcho'] : 1;
        $sSearch        = (isset($_GET['sSearch'])) ? $_GET['sSearch'] : "";
        $sSearch_0      = (isset($_GET['sSearch_0'])) ? $_GET['sSearch_0'] : "";
        $sSearch_1      = (isset($_GET['sSearch_1'])) ? $_GET['sSearch_1'] : "";
        $sSearch_2      = (isset($_GET['sSearch_2'])) ? $_GET['sSearch_2'] : "";
        $sSearch_3      = (isset($_GET['sSearch_3'])) ? $_GET['sSearch_3'] : "";
        $sSearch_4      = (isset($_GET['sSearch_4'])) ? $_GET['sSearch_4'] : "";
        $sSortDir_0     = (isset($_GET['sSortDir_0'])) ? $_GET['sSortDir_0'] : "asc";

        /*
         * Limit
         */

        $sLimit  = "";
        $sSearch = "";
        $search  = '';
        /*
         * Ordering
         */
        $sOrder  = "";

        /* Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        $sWhere = "";

        $tahun  = (isset($_GET['tahun'])) ? $_GET['tahun'] : date('Y');
        $nop_kd = (isset($_GET['nop_kd']) && is_numeric($_GET['nop_kd'])) ? $_GET['kel_kd'] : '000000000000000000';

        $kec_kd = (isset($_GET['kec_kd']) ? $_GET['kec_kd'] : ($this->session->userdata('user_def_kec') ? $this->session->userdata('user_def_kec') : '000'));
        $kel_kd = (isset($_GET['kel_kd']) ? $_GET['kel_kd'] : ($this->session->userdata('user_def_kel_' . $kec_kd) ? $this->session->userdata('user_def_kel_' . $kec_kd) : '000'));

        /*
         * SQL queries
         * Get data to display
         */

        if ($kec_kd == '000') {
            $sql_query_c = "SELECT COUNT(*) AS c FROM ref_kecamatan ";
            $sql_query_r = $this->pbbm_model->qry_realisasi_kb_kec($tahun);
        } else if ($kel_kd == '000') {
            $sql_query_c = "SELECT COUNT(*) AS c FROM ref_kelurahan k
                WHERE k.kd_propinsi='" . KD_PROPINSI . "'
                AND k.kd_dati2='" . KD_DATI2 . "'
                AND k.kd_kecamatan='$kec_kd'";
            $sql_query_r = $this->pbbm_model->qry_realisasi_kb_kel($tahun, $kec_kd);
        } else if ($nop_kd = '000000000000000000') {
            // $sLimit  = "LIMIT  $iDisplayLength OFFSET $iDisplayStart";
            $sSearch = (isset($_GET['sSearch'])) ? $_GET['sSearch'] : "";
            if ($sSearch)
                $search .= " AND a.nm_wp_sppt ilike '%$sSearch%' ";

            $sql_query_r = $this->pbbm_model->qry_realisasi_kb_op($tahun, $kec_kd, $kel_kd);

            if ($search) {
                $sql_query_r = str_replace('AND (1=1)', $search, $sql_query_r);
            }
        }

        $output   = array(
            "sEcho" => $sEcho,
            "iTotalRecords" => 0, //$iTotal,
            "iTotalDisplayRecords" => 0, //$iFilteredTotal,
            "iDisplayStart" => 0, //$iDisplayStart,
            // "SQL Query" => $sql_query_r,
            "aaData" => array()
        );

        $qry      = $this->db_pbbm->query($sql_query_r . " $sOrder $sLimit");
        $pg_sppt  = 0;
        $pg_pokok = 0;
        $pg_denda = 0;
        $pg_total = 0;

        foreach ($qry->result() as $aRow) {

            $row = array();
            for ($i = 0; $i < count($aColumns); $i++) {
                if ($i == 1) {
                    if ($kec_kd == '000') {
                        $row[] = "<a href=\"" . active_module_url() . "kb?tahun=$tahun&kec_kd=" . substr($aRow->kode, -3) . "\">" . $aRow->$aColumns[$i] . "</a>"; //xx
                    } else if ($kel_kd == '000') {
                        $row[] = "<a href=\"" . active_module_url() . "kb?tahun=$tahun&kec_kd=$kec_kd&kel_kd=" . substr($aRow->kode, -3) . "\">" . $aRow->$aColumns[$i] . "</a>";
                    } else if ($nop_kd == '000000000000000000') {
                        $row[] = "<a href=\"" . active_module_url() . "op?&nop_kd=" . $aRow->kode . "\">" . $aRow->$aColumns[$i] . "</a>";
                    }
                } else if ($aColumns[$i] == 'amount3') {
                    $row[] = number_format($aRow->amount1 - $aRow->amount2, 0, ',', '.');
                } else if ($i > 1) {
                    $row[] = number_format($aRow->$aColumns[$i], 0, ',', '.');  //xx
                } else {
                    $row[] = $aRow->$aColumns[$i]; //xx
                }
            }

            $pg_sppt  += $aRow->$aColumns[2]; //xx
            $pg_pokok += $aRow->$aColumns[3]; //xx
            $pg_denda += $aRow->$aColumns[4]; //xx
            $pg_total += $aRow->$aColumns[5]; //xx
            $output['aaData'][] = $row;
        }

        $output['sppt']  = number_format($pg_sppt, 0, ',', '.');
        $output['pokok'] = number_format($pg_pokok, 0, ',', '.');
        $output['denda'] = number_format($pg_denda, 0, ',', '.');
        $output['total'] = number_format($pg_total, 0, ',', '.');

        echo json_encode($output);
    }

    function kb()
    {
        ob_start("ob_gzhandler");
        //$this->load->model("pbbm_model");

        $path_to_root = active_module_url();

        $aColumns     = array(
            'kode',
            'uraian',
            'sppt1',
            'amount1',
            'amount2',
            'amount3'
        );
        $sIndexColumn = "kode";

        $iDisplayLength = (isset($_GET['iDisplayLength']) && is_numeric($_GET['iDisplayLength'])) ? $_GET['iDisplayLength'] : 15;
        $iDisplayStart  = (isset($_GET['iDisplayStart']) && is_numeric($_GET['iDisplayStart'])) ? $_GET['iDisplayStart'] : 0;
        $iSortCol_0     = (isset($_GET['iSortCol_0']) && is_numeric($_GET['iSortCol_0'])) ? $_GET['iSortCol_0'] : 0;
        $iSortingCols   = (isset($_GET['iSortingCols']) && is_numeric($_GET['iSortingCols'])) ? $_GET['iSortingCols'] : 1;
        $sEcho          = (isset($_GET['sEcho']) && is_numeric($_GET['sEcho'])) ? $_GET['sEcho'] : 1;
        $sSearch        = (isset($_GET['sSearch'])) ? $_GET['sSearch'] : "";
        $sSearch_0      = (isset($_GET['sSearch_0'])) ? $_GET['sSearch_0'] : "";
        $sSearch_1      = (isset($_GET['sSearch_1'])) ? $_GET['sSearch_1'] : "";
        $sSearch_2      = (isset($_GET['sSearch_2'])) ? $_GET['sSearch_2'] : "";
        $sSearch_3      = (isset($_GET['sSearch_3'])) ? $_GET['sSearch_3'] : "";
        $sSearch_4      = (isset($_GET['sSearch_4'])) ? $_GET['sSearch_4'] : "";
        $sSortDir_0     = (isset($_GET['sSortDir_0'])) ? $_GET['sSortDir_0'] : "asc";

        /*
         * Limit
         */

        $sLimit  = "";
        $sSearch = "";
        $search  = '';
        /*
         * Ordering
         */
        $sOrder  = "";

        /* Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        $sWhere = "";

        $tahun  = (isset($_GET['tahun'])) ? $_GET['tahun'] : date('Y');
        $nop_kd = (isset($_GET['nop_kd']) && is_numeric($_GET['nop_kd'])) ? $_GET['kel_kd'] : '000000000000000000';

        $kec_kd = (isset($_GET['kec_kd']) ? $_GET['kec_kd'] : ($this->session->userdata('user_def_kec') ? $this->session->userdata('user_def_kec') : '000'));
        $kel_kd = (isset($_GET['kel_kd']) ? $_GET['kel_kd'] : ($this->session->userdata('user_def_kel_' . $kec_kd) ? $this->session->userdata('user_def_kel_' . $kec_kd) : '000'));

        /*
         * SQL queries
         * Get data to display
         */

        if ($kec_kd == '000') {
            $sql_query_c = "SELECT COUNT(*) AS c FROM ref_kecamatan ";
            $sql_query_r = $this->pbbm_model->qry_realisasi_kb_kec($tahun);
        } else if ($kel_kd == '000') {
            $sql_query_c = "SELECT COUNT(*) AS c FROM ref_kelurahan k
                WHERE k.kd_propinsi='" . KD_PROPINSI . "'
                AND k.kd_dati2='" . KD_DATI2 . "'
                AND k.kd_kecamatan='$kec_kd'";
            $sql_query_r = $this->pbbm_model->qry_realisasi_kb_kel($tahun, $kec_kd);
        } else if ($nop_kd = '000000000000000000') {
            // $sLimit  = "LIMIT  $iDisplayLength OFFSET $iDisplayStart";
            $sSearch = (isset($_GET['sSearch'])) ? $_GET['sSearch'] : "";
            if ($sSearch)
                $search .= " AND a.nm_wp_sppt ilike '%$sSearch%' ";

            $sql_query_r = $this->pbbm_model->qry_realisasi_kb_op($tahun, $kec_kd, $kel_kd);

            if ($search) {
                $sql_query_r = str_replace('AND (1=1)', $search, $sql_query_r);
            }
        }

        $output   = array(
            "sEcho" => $sEcho,
            "iTotalRecords" => 0, //$iTotal,
            "iTotalDisplayRecords" => 0, //$iFilteredTotal,
            "iDisplayStart" => 0, //$iDisplayStart,
            // "SQL Query" => $sql_query_r,
            "aaData" => array()
        );

        $qry      = $this->db->query($sql_query_r . " $sOrder $sLimit");
        $pg_sppt  = 0;
        $pg_pokok = 0;
        $pg_denda = 0;
        $pg_total = 0;

        foreach ($qry->result() as $aRow) {

            $row = array();
            for ($i = 0; $i < count($aColumns); $i++) {
                if ($aColumns[$i] == 'kode') {
                    if ($kec_kd == '000') {
                        $row[] = "<a href=\"" . active_module_url() . "kb?tahun=$tahun&kec_kd=" . substr($aRow->KODE, -3) . "\">" . $aRow->KODE . "</a>"; //xx
                    } else if ($kel_kd == '000') {
                        $row[] = "<a href=\"" . active_module_url() . "kb?tahun=$tahun&kec_kd=$kec_kd&kel_kd=" . substr($aRow->KODE, -3) . "\">" . $aRow->KODE . "</a>";
                    } else if ($nop_kd == '000000000000000000') {
                        $row[] = "<a href=\"" . active_module_url() . "op?&nop_kd=" . $aRow->KODE . "\">" . $aRow->KODE . "</a>";
                    }
                } else if ($aColumns[$i] == 'amount3') {
                    $row[] = number_format($aRow->AMOUNT1 - $aRow->AMOUNT2, 0, ',', '.');
                } else if ($aColumns[$i] == 'amount1') {
                    $row[] = number_format($aRow->AMOUNT1, 0, ',', '.');
                } else if ($aColumns[$i] == 'amount2') {
                    $row[] = number_format($aRow->AMOUNT2, 0, ',', '.');
                } else if ($aColumns[$i] == 'sppt1') {
                    $row[] = number_format($aRow->SPPT1, 0, ',', '.');
                } else {
                    $row[] = $aRow->URAIAN; //xx
                }
            }

            $pg_sppt  += $aRow->SPPT1; //xx
            $pg_pokok += $aRow->AMOUNT1; //xx
            $pg_denda += $aRow->AMOUNT2; //xx
            // $pg_total += $aRow->amount3; //xx
            $pg_total += ($aRow->AMOUNT1 - $aRow->AMOUNT2); //xx
            $output['aaData'][] = $row;
        }

        $output['sppt']  = number_format($pg_sppt, 0, ',', '.');
        $output['pokok'] = number_format($pg_pokok, 0, ',', '.');
        $output['denda'] = number_format($pg_denda, 0, ',', '.');
        $output['total'] = number_format($pg_total, 0, ',', '.');

        echo json_encode($output);
    }

    function piutang_ori()
    {
        // ob_start("ob_gzhandler");
        //$this->load->model("pbbm_model");
        $tahun  = (isset($_GET['tahun']) && is_numeric($_GET['tahun'])) ? $_GET['tahun'] : date('Y');
        $tahun2 = (isset($_GET['tahun2']) && is_numeric($_GET['tahun2'])) ? $_GET['tahun2'] : date('Y');
        $buku   = (isset($_GET['buku'])) ? $_GET['buku'] : '44';
        $nop_kd = (isset($_GET['nop_kd']) && is_numeric($_GET['nop_kd'])) ? $_GET['nop_kd'] : '000000000000000000';

        $bukumin = $this->pbbm_model->rangebuku[substr($buku, 0, 1)][0];
        $bukumax = $this->pbbm_model->rangebuku[substr($buku, 1, 1)][1];
        //      $search.=" AND a.pbb_yg_harus_dibayar_sppt between $bukumin AND $bukumax";

        $kec_kd = (isset($_GET['kec_kd']) ? $_GET['kec_kd'] : ($this->session->userdata('user_def_kec') ? $this->session->userdata('user_def_kec') : '000'));
        $kel_kd = (isset($_GET['kel_kd']) ? $_GET['kel_kd'] : ($this->session->userdata('user_def_kel_' . $kec_kd) ? $this->session->userdata('user_def_kel_' . $kec_kd) : '000'));

        $path_to_root = active_module_url();

        $aColumns     = array(
            'kode',
            'uraian',
            'transaksi',
            'amount'
        );
        $sIndexColumn = "kode";

        $pageSize   = (isset($_GET['iDisplayLength']) && $_GET['iDisplayLength'] != '-1' ? $_GET['iDisplayLength'] : 15);
        $pageNumber = (isset($_GET['iDisplayStart']) && $_GET['iDisplayStart'] != '-1' ? $_GET['iDisplayStart'] : 0);

        $iSortCol_0   = (isset($_GET['iSortCol_0']) && is_numeric($_GET['iSortCol_0'])) ? $_GET['iSortCol_0'] : 0;
        $iSortingCols = (isset($_GET['iSortingCols']) && is_numeric($_GET['iSortingCols'])) ? $_GET['iSortingCols'] : 1;
        $sEcho        = (isset($_GET['sEcho']) && is_numeric($_GET['sEcho'])) ? $_GET['sEcho'] : 1;
        $sSearch      = (isset($_GET['sSearch'])) ? $_GET['sSearch'] : "";

        /*
         * Limit
         */
        $sLimit = "";
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            // $sLimit = "LIMIT $pageSize OFFSET $pageNumber";
        }


        /* Ordering
         */
        $sOrder = "";

        /* Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        $sWhere = "";

        /* Individual column filtering */


        /*
         * SQL queries
         * Get data to display
         */

        if ($kec_kd == '000') {
            $sql_query_c = "SELECT COUNT(*) AS C FROM ref_kecamatan ";
            $sql_query_r = $this->pbbm_model->qry_piutang_kec($tahun, $tahun2, $buku);
        } else if ($kel_kd == '000') {
            $sql_query_c = "SELECT COUNT(*) AS c
                FROM ref_kelurahan k
                WHERE k.kd_propinsi='" . KD_PROPINSI . "'
                AND k.kd_dati2='" . KD_DATI2 . "'
                AND k.kd_kecamatan='$kec_kd'";
            $sql_query_r = $this->pbbm_model->qry_piutang_kel($tahun, $tahun2, $buku, $kec_kd);
        } else if ($nop_kd = '000000000000000000') {
            $sql_query_c = "SELECT COUNT(*) AS c
                FROM (SELECT k.kd_propinsi, k.kd_dati2, k.kd_kecamatan, k.kd_kelurahan, k.kd_blok, k.no_urut
                ,k.kd_jns_op, k.thn_pajak_sppt, k.pbb_yg_harus_dibayar_sppt
                FROM    sppt k
                LEFT JOIN pembayaran_sppt p
                ON k.kd_propinsi = p.kd_propinsi
                AND k.kd_dati2 = p.kd_dati2
                AND k.kd_kecamatan = p.kd_kecamatan
                AND k.kd_kelurahan = p.kd_kelurahan
                AND k.kd_blok = p.kd_blok
                AND k.no_urut = p.no_urut
                AND k.kd_jns_op = p.kd_jns_op
                AND k.thn_pajak_sppt = p.thn_pajak_sppt

                WHERE k.kd_propinsi='" . KD_PROPINSI . "'
                AND k.kd_dati2='" . KD_DATI2 . "'
                AND k.kd_kecamatan='$kec_kd'
                AND k.kd_kelurahan='$kel_kd'
                AND k.thn_pajak_sppt BETWEEN '$tahun' AND  '$tahun2'
                AND k.pbb_yg_harus_dibayar_sppt BETWEEN $bukumin AND $bukumax
                GROUP BY k.kd_propinsi, k.kd_dati2, k.kd_kecamatan, k.kd_kelurahan, k.kd_blok, k.no_urut
                ,k.kd_jns_op, k.thn_pajak_sppt, k.pbb_yg_harus_dibayar_sppt
                HAVING k.pbb_yg_harus_dibayar_sppt > SUM(coalesce(p.jml_sppt_yg_dibayar,0)-coalesce(p.denda_sppt,0))
                )a";
            $sql_query_r = $this->pbbm_model->qry_piutang_op($tahun, $tahun2, $buku, $kec_kd, $kel_kd);
        }

        /*
         * Output
         */
        $output = array(
            "sEcho" => $sEcho,
            "iTotalRecords" => 0, //$iTotal,
            "iTotalDisplayRecords" => 0, //$iFilteredTotal,
            // "SQL Query" => $sql_query_r,
            "aaData" => array()
        );

        $qry = $this->db_pbbm->query("$sql_query_r $sLimit");
        $pg_sppt = 0;
        $pg_pokok = 0;

        foreach ($qry->result() as $aRow) {
            $row = array();
            for ($i = 0; $i < count($aColumns); $i++) {
                if ($i == 1) {
                    if ($kec_kd == '000')
                        $row[] = "<a href=\"" . active_module_url() . "piutang?tahun=$tahun&buku=$buku&kec_kd=" . substr($aRow->kode, -3) . "\">" . $aRow->$aColumns[$i] . "</a>";
                    else if ($kel_kd == '000')
                        $row[] = "<a href=\"" . active_module_url() . "piutang?tahun=$tahun&buku=$buku&kec_kd=$kec_kd&kel_kd=" . substr($aRow->kode, -3) . "\">" . $aRow->$aColumns[$i] . "</a>";
                    else if ($nop_kd == '000000000000000000')
                        $row[] = "<a href=\"" . active_module_url() . "op?&nop_kd=" . substr($aRow->kode, 0, 24) . "\">" . $aRow->$aColumns[$i] . "</a>";
                } else if ($i > 1)
                    $row[] = number_format($aRow->$aColumns[$i], 0, ',', '.');
                else
                    $row[] = $aRow->$aColumns[$i];
            }
            $pg_sppt += $aRow->$aColumns[2];
            $pg_pokok += $aRow->$aColumns[3];

            $output['aaData'][] = $row;
        }

        $output['sppt']  = number_format($pg_sppt, 0, ',', '.');
        $output['pokok'] = number_format($pg_pokok, 0, ',', '.');

        echo json_encode($output);
    }

    function piutang()
    {
        // ob_start("ob_gzhandler");
        //$this->load->model("pbbm_model");
        $tahun  = (isset($_GET['tahun']) && is_numeric($_GET['tahun'])) ? $_GET['tahun'] : date('Y');
        $tahun2 = (isset($_GET['tahun2']) && is_numeric($_GET['tahun2'])) ? $_GET['tahun2'] : date('Y');
        $buku   = (isset($_GET['buku'])) ? $_GET['buku'] : '44';
        $nop_kd = (isset($_GET['nop_kd']) && is_numeric($_GET['nop_kd'])) ? $_GET['nop_kd'] : '000000000000000000';

        $bukumin = $this->pbbm_model->rangebuku[substr($buku, 0, 1)][0];
        $bukumax = $this->pbbm_model->rangebuku[substr($buku, 1, 1)][1];
        //      $search.=" AND a.pbb_yg_harus_dibayar_sppt between $bukumin AND $bukumax";

        $kec_kd = (isset($_GET['kec_kd']) ? $_GET['kec_kd'] : ($this->session->userdata('user_def_kec') ? $this->session->userdata('user_def_kec') : '000'));
        $kel_kd = (isset($_GET['kel_kd']) ? $_GET['kel_kd'] : ($this->session->userdata('user_def_kel_' . $kec_kd) ? $this->session->userdata('user_def_kel_' . $kec_kd) : '000'));

        $path_to_root = active_module_url();

        $aColumns     = array(
            'kode',
            'uraian',
            'transaksi',
            'amount'
        );
        $sIndexColumn = "kode";

        $pageSize   = (isset($_GET['iDisplayLength']) && $_GET['iDisplayLength'] != '-1' ? $_GET['iDisplayLength'] : 15);
        $pageNumber = (isset($_GET['iDisplayStart']) && $_GET['iDisplayStart'] != '-1' ? $_GET['iDisplayStart'] : 0);

        $iSortCol_0   = (isset($_GET['iSortCol_0']) && is_numeric($_GET['iSortCol_0'])) ? $_GET['iSortCol_0'] : 0;
        $iSortingCols = (isset($_GET['iSortingCols']) && is_numeric($_GET['iSortingCols'])) ? $_GET['iSortingCols'] : 1;
        $sEcho        = (isset($_GET['sEcho']) && is_numeric($_GET['sEcho'])) ? $_GET['sEcho'] : 1;
        $sSearch      = (isset($_GET['sSearch'])) ? $_GET['sSearch'] : "";

        /*
         * Limit
         */
        $sLimit = "";
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            // $sLimit = "LIMIT $pageSize OFFSET $pageNumber";
        }


        /* Ordering
         */
        $sOrder = "";

        /* Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        $sWhere = "";

        /* Individual column filtering */


        /*
         * SQL queries
         * Get data to display
         */

        if ($kec_kd == '000') {
            $sql_query_c = "SELECT COUNT(*) AS C FROM ref_kecamatan ";
            $sql_query_r = $this->pbbm_model->qry_piutang_kec($tahun, $tahun2, $buku);
        } else if ($kel_kd == '000') {
            $sql_query_c = "SELECT COUNT(*) AS c
                FROM ref_kelurahan k
                WHERE k.kd_propinsi='" . KD_PROPINSI . "'
                AND k.kd_dati2='" . KD_DATI2 . "'
                AND k.kd_kecamatan='$kec_kd'";
            $sql_query_r = $this->pbbm_model->qry_piutang_kel($tahun, $tahun2, $buku, $kec_kd);
        } else if ($nop_kd = '000000000000000000') {
            $sql_query_c = "SELECT COUNT(*) AS c
                FROM (SELECT k.kd_propinsi, k.kd_dati2, k.kd_kecamatan, k.kd_kelurahan, k.kd_blok, k.no_urut
                ,k.kd_jns_op, k.thn_pajak_sppt, k.pbb_yg_harus_dibayar_sppt
                FROM    sppt k
                LEFT JOIN pembayaran_sppt p
                ON k.kd_propinsi = p.kd_propinsi
                AND k.kd_dati2 = p.kd_dati2
                AND k.kd_kecamatan = p.kd_kecamatan
                AND k.kd_kelurahan = p.kd_kelurahan
                AND k.kd_blok = p.kd_blok
                AND k.no_urut = p.no_urut
                AND k.kd_jns_op = p.kd_jns_op
                AND k.thn_pajak_sppt = p.thn_pajak_sppt

                WHERE k.kd_propinsi='" . KD_PROPINSI . "'
                AND k.kd_dati2='" . KD_DATI2 . "'
                AND k.kd_kecamatan='$kec_kd'
                AND k.kd_kelurahan='$kel_kd'
                AND k.thn_pajak_sppt BETWEEN '$tahun' AND  '$tahun2'
                AND k.pbb_yg_harus_dibayar_sppt BETWEEN $bukumin AND $bukumax
                GROUP BY k.kd_propinsi, k.kd_dati2, k.kd_kecamatan, k.kd_kelurahan, k.kd_blok, k.no_urut
                ,k.kd_jns_op, k.thn_pajak_sppt, k.pbb_yg_harus_dibayar_sppt
                HAVING k.pbb_yg_harus_dibayar_sppt > SUM(coalesce(p.jml_sppt_yg_dibayar,0)-coalesce(p.denda_sppt,0))
                )a";

            //log_message('info', "KKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK");

            $sql_query_r = $this->pbbm_model->qry_piutang_op($tahun, $tahun2, $buku, $kec_kd, $kel_kd);
        }

        /*
         * Output
         */
        $output = array(
            "sEcho" => $sEcho,
            "iTotalRecords" => 0, //$iTotal,
            "iTotalDisplayRecords" => 0, //$iFilteredTotal,
            // "SQL Query" => $sql_query_r,
            "aaData" => array()
        );

        $qry = $this->db->query("$sql_query_r $sLimit");
        $pg_sppt = 0;
        $pg_pokok = 0;

        foreach ($qry->result() as $aRow) {
            $row = array();
            for ($i = 0; $i < count($aColumns); $i++) {

                //if ($i == 1) {
                if ($aColumns[$i] == 'kode') {

                    if ($kec_kd == '000') {
                        $row[] = "<a href=\"" . active_module_url() . "piutang?tahun=$tahun&buku=$buku&kec_kd=" . substr($aRow->KODE, -3) . "\">" . $aRow->KODE . "</a>";
                    } else if ($kel_kd == '000') {
                        $row[] = "<a href=\"" . active_module_url() . "piutang?tahun=$tahun&buku=$buku&kec_kd=$kec_kd&kel_kd=" . substr($aRow->KODE, -3) . "\">" . $aRow->KODE . "</a>";
                    } else if ($nop_kd == '000000000000000000') {
                        $row[] = "<a href=\"" . active_module_url() . "op?&nop_kd=" . substr($aRow->KODE, 0, 24) . "\">" . $aRow->KODE . "</a>";
                    }
                } else if ($aColumns[$i] == 'transaksi') {
                    $row[] = number_format($aRow->TRANSAKSI, 0, ',', '.');
                } else if ($aColumns[$i] == 'amount') {
                    $row[] = number_format($aRow->AMOUNT, 0, ',', '.');
                } else {
                    $row[] = $aRow->URAIAN;
                }
            }

            $pg_sppt  += $aRow->TRANSAKSI;
            $pg_pokok += $aRow->AMOUNT;

            $output['aaData'][] = $row;
        }

        $output['sppt']  = number_format($pg_sppt, 0, ',', '.');
        $output['pokok'] = number_format($pg_pokok, 0, ',', '.');

        echo json_encode($output);
    }
}
