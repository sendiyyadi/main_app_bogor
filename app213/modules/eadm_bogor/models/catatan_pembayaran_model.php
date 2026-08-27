<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class catatan_pembayaran_model extends CI_Model
{
    private $tbl = 'SPPT';

    public function __construct()
    {
        parent::__construct();
    }

    function cek_lunas($nop,$thn){

        $nop          = urldecode($nop);
        $nop          = str_replace('.', '', $nop);
        $nop          = str_replace(' ', '', $nop);
        $nop          = str_replace('-', '', $nop);
        $nop          = preg_replace( '/[^0-9]/', '', $nop);

        $kd_propinsi  = substr($nop, 0, 2);
        $kd_dati2     = substr($nop, 2, 2);
        $kd_kecamatan = substr($nop, 4, 3);
        $kd_kelurahan = substr($nop, 7, 3);
        $kd_blok      = substr($nop, 10, 3);
        $no_urut      = substr($nop, 13, 4);
        $kd_jns_op    = substr($nop, 17, 1);

        //lunas ga dapat hasil

        $qry = "
            SELECT qq.*
    FROM (
        SELECT 
            kd_propinsi,
            kd_dati2,
            kd_kecamatan,
            kd_kelurahan,
            kd_blok,
            no_urut,
            kd_jns_op,
            kd_propinsi || kd_dati2 || kd_kecamatan || kd_kelurahan || kd_blok || no_urut || kd_jns_op AS nop,
            thn_pajak_sppt AS tahun,
            'ada' AS status
        FROM sppt
        WHERE status_pembayaran_sppt = '0'
          AND kd_propinsi = '{$kd_propinsi}'
          AND kd_dati2 = '{$kd_dati2}'
          AND kd_kecamatan = '{$kd_kecamatan}'
          AND kd_kelurahan = '{$kd_kelurahan}'
          AND kd_blok = '{$kd_blok}'
          AND no_urut = '{$no_urut}'
          AND kd_jns_op = '{$kd_jns_op}'
          AND thn_pajak_sppt < '{$thn}'
        ORDER BY thn_pajak_sppt DESC
    ) qq
    WHERE ROWNUM <= 1";

    $query = $this->db->query($qry);
    if ($query->num_rows() !== 0){return $query->row();}
    else{return FALSE;}

    }

    function query_rpt($nop){
        $nop          = urldecode($nop);
        $nop          = str_replace('.', '', $nop);
        $nop          = str_replace(' ', '', $nop);
        $nop          = str_replace('-', '', $nop);
        $nop          = preg_replace( '/[^0-9]/', '', $nop);

        $kd_propinsi  = substr($nop, 0, 2);
        $kd_dati2     = substr($nop, 2, 2);
        $kd_kecamatan = substr($nop, 4, 3);
        $kd_kelurahan = substr($nop, 7, 3);
        $kd_blok      = substr($nop, 10, 3);
        $no_urut      = substr($nop, 13, 4);
        $kd_jns_op    = substr($nop, 17, 1);

        $sql = "SELECT V_CTT_PMB.*, SYSDATE as TGL_CETAK,
                HIT_DENDA_2(KETETAPAN, TGL_JATUH_TEMPO_SPPT, SYSDATE, THN_PAJAK_SPPT) AS DENDA_BERJALAN,
                (KETETAPAN - (JML_BAYAR - JML_DENDA) + HIT_DENDA_2(KETETAPAN, TGL_JATUH_TEMPO_SPPT, SYSDATE, THN_PAJAK_SPPT)) AS SISA_2
                FROM V_CTT_PMB
                WHERE KETETAPAN > (JML_BAYAR - JML_DENDA)
                AND KD_PROPINSI = '{$kd_propinsi}' AND KD_DATI2 = '{$kd_dati2}'
                AND KD_KECAMATAN = '{$kd_kecamatan}' AND KD_KELURAHAN = '{$kd_kelurahan}'
                AND KD_BLOK = '{$kd_blok}' AND NO_URUT = '{$no_urut}'
                AND KD_JNS_OP = '{$kd_jns_op}' ";

        return $sql;

    }

    function get_res_query_rpt($sql){
        $query = $this->db->query($sql);

        $result['sql']      = $sql;
        $result['query']    = $query->result_array();
        $result['num_rows'] = $query->num_rows();
        $result['tot_rows'] = $query->num_rows();

        return $result;
    }

}

/* End of file _model.php */
