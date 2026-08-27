<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class lap_penghapusan_denda_adm_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_select_kecamatan()
    {
        $this->db->select(KD_KECAMATAN_KEC.', '.NM_KECAMATAN);
        $this->db->order_by(NM_KECAMATAN);
        $query = $this->db->get(TBL_REF_KECAMATAN);
        if($query->num_rows()!==0)
        {
            return $query->result();
        }
        else
            return FALSE;
    }

    function get_select_kec() {
        // arig

        $sql = " select * from (
                select ' ' as kd_kecamatan,  ' Semua' as nm_kecamatan union all
                select kd_kecamatan,  nm_kecamatan
                from ref_kecamatan where kd_propinsi='32' and kd_dati2='03'
                ) z1 order by nm_kecamatan  ";

        $query = $this->db->query($sql);
        if($query->num_rows()>0)
            return $query->result();
        else
            return false;
    }

    function get_select_kel($kec) {
        // arig
        //log_message('info', "KKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK");
        if (empty($kec)){$kec = ' ';}
        $sql = " select * from (
        select ' ' as kd_kelurahan,  ' Semua' as nm_kelurahan union all
        select kd_kelurahan, nm_kelurahan
        from ref_kelurahan where kd_propinsi='32' and kd_dati2='03' and kd_kecamatan='{$kec}'
        ) z1 order by nm_kelurahan  ";

        $query = $this->db->query($sql);
        if($query->num_rows()>0)
            return $query->result();
        else
            return false;
    }

    function query_rpt($filter){
        $sql = "
        select
        z1.thn_pajak_sppt, z1.tgl_pembayaran_sppt, z1.tgl_jatuh_tempo_sppt, z1.tgl_cetak_sppt,
        z1.dati2||'.'||z1.nopd as nopd, z1.nm_wp_sppt, z1.nm_kecamatan, z1.nm_kelurahan,
        z1.pembayaran_sppt_ke,
        z1.pbb_terhutang_sppt,
        z1.pbb_yg_harus_dibayar_sppt,
        z1.nil_denda_normal,
        z1.denda_yg_dibayar,
        z1.nil_denda_normal - z1.denda_yg_dibayar as nil_denda_yg_dihapus,
        z1.jml_sppt_yg_dibayar, z1.faktor_pengurang_covid
        
        from (
        select
        byr.thn_pajak_sppt, byr.tgl_pembayaran_sppt, spp.tgl_jatuh_tempo_sppt, spp.tgl_cetak_sppt,
        byr.kd_propinsi||'.'||byr.kd_dati2 as dati2,
        byr.kd_kecamatan||'.'||byr.kd_kelurahan||'.'||byr.kd_blok||'.'||byr.no_urut||'.'||byr.kd_jns_op as nopd,
        SUBSTR(spp.nm_wp_sppt, 1, 22) AS nm_wp_sppt, kec.nm_kecamatan, kel.nm_kelurahan,
        
        byr.pembayaran_sppt_ke,
        spp.pbb_terhutang_sppt,
        spp.faktor_pengurang_sppt,
        spp.pbb_yg_harus_dibayar_sppt,
        CASE WHEN spp.tgl_jatuh_tempo_sppt < TO_DATE('2024-01-01', 'YYYY-MM-DD') THEN NVL(hit_denda2(spp.pbb_yg_harus_dibayar_sppt, 2, spp.tgl_jatuh_tempo_sppt), 0) ELSE NVL(hit_denda2(spp.pbb_yg_harus_dibayar_sppt, 1, spp.tgl_jatuh_tempo_sppt), 0) END as nil_denda_normal,
        byr.denda_sppt as denda_yg_dibayar,
        byr.jml_sppt_yg_dibayar,  h.faktor_pengurang_covid
        
        from pembayaran_sppt byr
        join sppt spp on byr.kd_propinsi = spp.kd_propinsi
        and byr.kd_dati2 = spp.kd_dati2
        and byr.kd_kecamatan = spp.kd_kecamatan
        and byr.kd_kelurahan = spp.kd_kelurahan
        and byr.kd_blok = spp.kd_blok
        and byr.no_urut = spp.no_urut
        and byr.kd_jns_op = spp.kd_jns_op
        and byr.thn_pajak_sppt = spp.thn_pajak_sppt
        LEFT JOIN ref_kecamatan kec ON kec.kd_propinsi=spp.kd_propinsi AND kec.kd_dati2=spp.kd_dati2 AND kec.kd_kecamatan=spp.kd_kecamatan
        left JOIN ref_kelurahan kel ON kel.kd_propinsi=spp.kd_propinsi AND kel.kd_dati2=spp.kd_dati2 AND kel.kd_kecamatan=spp.kd_kecamatan
            AND kel.kd_kelurahan=spp.kd_kelurahan
        JOIN pembayaran_sppt_covid h ON byr.kd_propinsi = h.kd_propinsi AND byr.kd_dati2 = h.kd_dati2
            AND byr.kd_kecamatan = h.kd_kecamatan AND byr.kd_kelurahan = h.kd_kelurahan AND byr.kd_blok = h.kd_blok
            AND byr.no_urut = h.no_urut AND byr.kd_jns_op = h.kd_jns_op AND byr.thn_pajak_sppt = h.thn_pajak_sppt
            AND (h.flg_batal is null or h.flg_batal = '')
        where
        byr.jml_sppt_yg_dibayar > 0 and
        byr.jml_sppt_yg_dibayar = spp.pbb_yg_harus_dibayar_sppt
         {$filter}
        ) z1
        ";

        return $sql;
    }

}

/* End of file _model.php */
