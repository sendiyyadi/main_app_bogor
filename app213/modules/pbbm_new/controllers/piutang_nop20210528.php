<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class piutang_nop extends CI_Controller
{
    private $module = 'pbbmr';
    private $db_pbbm;

    function __construct() {
        parent::__construct();
        $this->db_pbbm = $this->load->database('pad', TRUE);

        if (!$this->session->userdata('login')) {
            $this->session->set_flashdata('msg_warning', 'Session telah kadaluarsa, silahkan login ulang.');
            redirect('login');
            exit;
        }

        $this->load->model('login_model');
        if ($grp = $this->login_model->check_user_app()) {
            $this->session->set_userdata('groupid', $grp->group_id);
            $this->session->set_userdata('groupkd', $grp->group_kode);
            $this->session->set_userdata('groupname', $grp->group_nama);
        }

        $this->load->model(array(
            'apps_model', 'login_model', 'pbbm_model'
        ));
        //$this->pbbm_model->set_userarea();
    }

    function load_auth()
    {
        $this->load->library('module_auth', array(
            'module' => $this->module
        ));
    }

    public function index()
    {
        $this->load_auth();
        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect(active_module_url());
        }

        ob_start("ob_gzhandler");

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

        $nama_wp   = (isset($_GET['nama_wp']) ? $_GET['nama_wp'] : '');
        $alamat_op = (isset($_GET['alamat_op']) ? $_GET['alamat_op'] : '');
        $nop_pbb   = (isset($_GET['nop_pbb']) ? $_GET['nop_pbb'] : '');

        $data['nama_wp']   = $nama_wp;
        $data['alamat_op'] = $alamat_op;
        $data['nop_pbb']   = $nop_pbb;
        //-----------------------------------------------------------------------
        // load
        $data['current'] = 'piutang';
        $data['apps']    = $this->apps_model->get_active_only();
        $data['title']   = 'Piutang per NOP';

        $data['data_source'] = active_module_url() . "piutang_nop/grid?nama_wp={$nama_wp}&alamat_op={$alamat_op}&nop_pbb={$nop_pbb}";
        $this->load->view('vpiutang_nop', $data);
    }

    function grid()
    {
        ob_start("ob_gzhandler");
        $aColumns     = array(
            'nop',
            'nm_wp',
            'nm_kec_op',
            'nm_kel_op',
            'alamat_op',
            'thn_pajak_sppt',
            'ketetapan',
            'pokok',
            'pengurangan',
            'denda',
            'bayar',
            'sisa_ar'
        );
        $sIndexColumn = "nop";

        $iDisplayLength = (isset($_GET['iDisplayLength']) && is_numeric($_GET['iDisplayLength'])) ? $_GET['iDisplayLength'] : 15;
        $iDisplayStart  = (isset($_GET['iDisplayStart']) && is_numeric($_GET['iDisplayStart'])) ? $_GET['iDisplayStart'] : 0;
        $iSortCol_0     = (isset($_GET['iSortCol_0']) && is_numeric($_GET['iSortCol_0'])) ? $_GET['iSortCol_0'] : 0;
        $iSortingCols   = (isset($_GET['iSortingCols']) && is_numeric($_GET['iSortingCols'])) ? $_GET['iSortingCols'] : 1;
        $sSortDir_0     = (isset($_GET['sSortDir_0'])) ? $_GET['sSortDir_0'] : "asc";
        $sEcho          = (isset($_GET['sEcho']) && is_numeric($_GET['sEcho'])) ? $_GET['sEcho'] : 1;

        $sSearch   = (isset($_GET['sSearch'])) ? $_GET['sSearch'] : "";
        $sSearch_0 = (isset($_GET['sSearch_0'])) ? $_GET['sSearch_0'] : "";
        $sSearch_1 = (isset($_GET['sSearch_1'])) ? $_GET['sSearch_1'] : "";
        $sSearch_2 = (isset($_GET['sSearch_2'])) ? $_GET['sSearch_2'] : "";
        $sSearch_3 = (isset($_GET['sSearch_3'])) ? $_GET['sSearch_3'] : "";
        $sSearch_4 = (isset($_GET['sSearch_4'])) ? $_GET['sSearch_4'] : "";

        // Get params
        $nama_wp   = (isset($_GET['nama_wp']) ? $_GET['nama_wp'] : '');
        $alamat_op = (isset($_GET['alamat_op']) ? $_GET['alamat_op'] : '');
        $nop_pbb   = (isset($_GET['nop_pbb']) ? $_GET['nop_pbb'] : '');

        // Limit
        $sLimit = "";
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $sLimit = " AND ROWNUM = " . $_GET['iDisplayLength'] . " OFFSET " . $_GET['iDisplayStart'];
        }

        // Ordering
        $sOrder = "";
        if (isset($_GET['iSortCol_0'])) {
            $sOrder = "ORDER BY ";
            for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                    if ($aColumns[intval($_GET['iSortCol_' . $i])] == "bphtbno" || $aColumns[intval($_GET['iSortCol_' . $i])] == "nop") {
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

        // Filtering
        $filter = "";
        // nama min 5 digit
        //$nama_wp = 'samsu';
        $nama_wp   = trim($nama_wp);
        if (strlen($nama_wp)> 4){
            $nama_wp = strtolower($nama_wp);
            $filter .= "and lower(s.nm_wp_sppt) like '%{$nama_wp}%' ";
        }
        // alamat op min 5 digit
        $alamat_op = trim($alamat_op);
        if (strlen($alamat_op)> 4){
            $alamat_op = strtolower($alamat_op);
            $filter .= "and lower(coalesce(dop.jalan_op,'')) like '%{$alamat_op}%' ";
        }
        //
        $nop_pbb = trim($nop_pbb);
        $nop_kd  = str_replace('.', '', $nop_pbb);
        $nop_kd  = str_replace('-', '', $nop_kd);
        $nop     = str_replace(' ', '', $nop_kd);

        if (strlen($nop) == 18) {

            $prop_kd = substr($nop, 0, 2);
            $kab_kd  = substr($nop, 2, 2);
            $kec_kd  = substr($nop, 4, 3);
            $kel_kd  = substr($nop, 7, 3);
            $blok_kd = substr($nop, 10, 3);
            $urut_no = substr($nop, 13, 4);
            $jns_kd  = substr($nop, 17, 1);

            $filter .= "and s.kd_kecamatan = '{$kec_kd}'
            and s.kd_kelurahan = '{$kel_kd}'
            and s.kd_blok = '{$blok_kd}'
            and s.no_urut = '{$urut_no}'
            and s.kd_jns_op = '{$jns_kd}'";
        }        
        
        // jika nop isi dan jml bukan 18 , maka filter batal semua
        if (!empty($nop) && strlen($nop) != 18) {
            $filter = "";
        } 

        $iTotal    = 0;
        $iFiltered = 0;

        // Output

        $sql_query_r = "SELECT 
        s.kd_propinsi||'.'||s.kd_dati2||'-'||s.kd_kecamatan||'.'||s.kd_kelurahan ||'-'||
        s.kd_blok ||'.'||s.no_urut||'.'|| s.kd_jns_op as nop,
        s.nm_wp_sppt as nm_wp, 
        kec_op.nm_kecamatan as nm_kec_op,
        kel_op.nm_kelurahan as nm_kel_op, 
        coalesce(dop.jalan_op,'')||coalesce(', '||dop.blok_kav_no_op,'') as alamat_op,
        dop.rt_op || ' / ' || dop.rw_op as rt_rw_op, 
        s.thn_pajak_sppt,
        to_char(max(ps.tgl_pembayaran_sppt),'dd-mm-yyyy') as tgl_bayar_terakhir,
        s.pbb_yg_harus_dibayar_sppt as ketetapan,
        sum((coalesce(ps.jml_sppt_yg_dibayar,0) - coalesce(ps.denda_sppt,0)) + coalesce(h.faktor_pengurang_covid19,0)) as pokok,
        sum(coalesce(h.faktor_pengurang_covid19,0)) as pengurangan,
        sum(coalesce(ps.denda_sppt,0)) as denda, 
        sum(coalesce(ps.jml_sppt_yg_dibayar,0)) as jml_bayar
        FROM SPPT s
        LEFT JOIN DAT_OBJEK_PAJAK dop
        ON dop.kd_propinsi = s.kd_propinsi 
        AND dop.kd_dati2 = s.kd_dati2
        AND dop.kd_kecamatan = s.kd_kecamatan
        AND dop.kd_kelurahan = s.kd_kelurahan
        AND dop.kd_blok = s.kd_blok
        AND dop.no_urut = s.no_urut
        AND dop.kd_jns_op = s.kd_jns_op
        LEFT JOIN PEMBAYARAN_SPPT ps
        ON ps.kd_propinsi = s.kd_propinsi 
        AND ps.kd_dati2 = s.kd_dati2
        AND ps.kd_kecamatan = s.kd_kecamatan
        AND ps.kd_kelurahan = s.kd_kelurahan
        AND ps.kd_blok = s.kd_blok
        AND ps.no_urut = s.no_urut
        AND ps.kd_jns_op = s.kd_jns_op
        AND ps.thn_pajak_sppt = s.thn_pajak_sppt
        LEFT JOIN hist_bayar_sppt_covid19 h
        ON s.kd_propinsi = h.kd_propinsi
        AND s.kd_dati2 = h.kd_dati2
        AND s.kd_kecamatan = h.kd_kecamatan
        AND s.kd_kelurahan = h.kd_kelurahan
        AND s.kd_blok = h.kd_blok
        AND s.no_urut = h.no_urut
        AND s.kd_jns_op = h.kd_jns_op
        AND s.thn_pajak_sppt = h.thn_pajak_sppt
        AND h.flg_batal is null AND ps.jml_batal is null
        LEFT JOIN REF_KELURAHAN kel_op ON kel_op.kd_kecamatan=s.kd_kecamatan AND kel_op.kd_kelurahan=s.kd_kelurahan
        LEFT JOIN REF_KECAMATAN kec_op ON kec_op.kd_kecamatan = s.kd_kecamatan 
        WHERE 1=1
        {$filter}
        GROUP BY 
        s.kd_propinsi,s.kd_dati2,s.kd_kecamatan,s.kd_kelurahan,s.kd_blok ,s.no_urut, s.kd_jns_op,s.nm_wp_sppt, 
        kec_op.nm_kecamatan,kel_op.nm_kelurahan, dop.jalan_op,dop.blok_kav_no_op,dop.rt_op ,dop.rw_op,
        s.thn_pajak_sppt,s.pbb_yg_harus_dibayar_sppt,s.status_pembayaran_sppt
        HAVING s.pbb_yg_harus_dibayar_sppt>sum((coalesce(ps.jml_sppt_yg_dibayar,0) - coalesce(ps.denda_sppt,0)) + coalesce(h.faktor_pengurang_covid19,0))
        ORDER BY s.kd_kecamatan, s.kd_kelurahan, s.kd_blok, s.no_urut, s.kd_jns_op, s.thn_pajak_sppt 
        limit 20000";

        //"select * from zz_tes where 1=1 limit 100";

        //Jika tdk filter yg keluar record blank
        if(empty($filter)){$sql_query_r = "select 1 as ctr where 1=2";}
        //
        $output = array(
            "sEcho" => $sEcho,
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iFiltered,
            "iDisplayStart" => $iDisplayStart,
            "iDisplayLength" => $iDisplayLength,
            // "SQL Query" => $sql_query_r,
            "aaData" => array()
        );

        $pg_ketetapan = 0;
        $pg_pokok = 0;
        $pg_pengurang = 0;
        $pg_denda = 0;
        $pg_bayar = 0;
        $pg_sisa_ar = 0;

        //$qry = $this->piutang_model->qry_result($sql_query_r);
        //log_message('info', "BBBBBBBBBB    sql_query_r : " . $sql_query_r);
        $qry = $this->db_pbbm->query($sql_query_r)->result();

        if(!empty($qry)){
                foreach ($qry as $aRow) {
                    $row = array();

                    $sisa_ar = $aRow->ketetapan - $aRow->pokok - $aRow->pengurangan;

                    for ($i = 0; $i < count($aColumns); $i++) {

                        if ($aColumns[$i] == 'nop'){$row[] = $aRow->nop;}
                        else if ($aColumns[$i] == 'nm_wp'){ 
                            $row[] = $aRow->nm_wp;
                          /* 
                        $row[] = "ON dop.kd_propinsi = s.kd_propinsi AND dop.kdp.kd_kecamatan = s.kd_kecamatan ON ps.kd_propinsi = s.kd_propinsi
                        ON dop.kd_propinsi = s.kd_propinsi AND d54645656 camatan = s.kd_kecamatan ON ps.kd_propinsi = s.kd_propinsi
                        ON dop.kd_propinsi = s.kd_propinsi AND dop.kdp.kd_kecamatan = s.kd_kecamdgfhgfhgfh456456ps.kd_propinsi = s.kd_propinsi
                        ";
                        */
                        }
                        else if ($aColumns[$i] == 'nm_kec_op'){$row[] = $aRow->nm_kec_op;}
                        else if ($aColumns[$i] == 'nm_kel_op'){$row[] = $aRow->nm_kel_op;}
                        else if ($aColumns[$i] == 'thn_pajak_sppt'){$row[] = $aRow->thn_pajak_sppt;}
                        else if ($aColumns[$i] == 'alamat_op'){$row[] = $aRow->alamat_op;}
                        else if ($aColumns[$i] == 'ketetapan'){$row[] = number_format($aRow->ketetapan, 0, ',', '.');}
                        else if ($aColumns[$i] == 'pokok'){$row[] = number_format($aRow->pokok, 0, ',', '.');}
                        else if ($aColumns[$i] == 'pengurangan'){$row[] = number_format($aRow->pengurangan, 0, ',', '.');}
                        else if ($aColumns[$i] == 'denda'){$row[] = number_format($aRow->denda, 0, ',', '.');}
                        else if ($aColumns[$i] == 'bayar'){$row[] = number_format($aRow->jml_bayar, 0, ',', '.');}
                        else {$row[] = number_format($sisa_ar, 0, ',', '.');} // sisa ar / piutang
                       // else {$row[] = $aRow->alamat_op;} 

                    }

                    $pg_ketetapan += $aRow->ketetapan;
                    $pg_pokok += $aRow->pokok;
                    $pg_pengurang += $aRow->pengurangan;
                    $pg_denda += $aRow->denda;
                    $pg_bayar += $aRow->jml_bayar;            
                    $pg_sisa_ar += $sisa_ar; 

                    $output['aaData'][] = $row;
                }
        }

        $output['tetapan'] = number_format($pg_ketetapan, 0, ',', '.');
        $output['kurang'] = number_format($pg_pengurang, 0, ',', '.');
        $output['pokok'] = number_format($pg_pokok, 0, ',', '.');
        $output['denda'] = number_format($pg_denda, 0, ',', '.');
        $output['bayar'] = number_format($pg_bayar, 0, ',', '.');
        $output['sisa_ar'] = number_format($pg_sisa_ar, 0, ',', '.');
        //$output['sisa_ar'] = number_format(9999999999999, 0, ',', '.');

        echo json_encode($output);
    }

}
