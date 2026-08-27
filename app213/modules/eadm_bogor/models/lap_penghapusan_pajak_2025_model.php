<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class lap_penghapusan_pajak_2025_model extends CI_Model {

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

    function get_select_tp() {
        // arig
        $sql = " select * from (
                select ' ' as kd_tp, ' Semua' as nm_tp  union all
                select kd_tp, nm_tp from tempat_pembayaran
                ) z1 order by nm_tp  ";

        $query = $this->db->query($sql);
        if($query->num_rows()>0)
            return $query->result();
        else
            return false;
    }

    function get_select_buku() {

        $sql = " select id as buku_id,nama as buku_nm from ref_buku order by nama  ";
        $query = $this->db->query($sql);
        if($query->num_rows()>0)
            return $query->result();
        else
            return false;
    }

    function query_rpt($filter){
        $sql = "
        select 
            ROW_NUMBER() OVER (ORDER BY 
            s.kd_propinsi, s.kd_dati2, s.kd_kecamatan, 
            s.kd_kelurahan, s.kd_blok, s.no_urut, s.kd_jns_op
        ) AS nomor,
        s.kd_propinsi||'.'||s.kd_dati2||'-'||s.kd_kecamatan||'.'||s.kd_kelurahan||'-'||s.kd_blok||'.'||s.no_urut||'.'||s.kd_jns_op AS nop,
        s.thn_pajak_sppt as thn_pajak_sppt,
        s.faktor_pengurang_sppt as faktor_pengurang_sppt,
        s.pbb_terhutang_sppt as pbb_terhutang_sppt,
        CASE WHEN s.tgl_jatuh_tempo_sppt < TO_DATE('2024-01-01', 'YYYY-MM-DD') 
        THEN NVL(hit_denda2(s.pbb_yg_harus_dibayar_sppt, 2, s.tgl_jatuh_tempo_sppt), 0) 
        ELSE NVL(hit_denda2(s.pbb_yg_harus_dibayar_sppt, 1, s.tgl_jatuh_tempo_sppt), 0) END as nil_denda
        from sppt s
        join vsumpay v on
            s.kd_propinsi       = v.kd_propinsi AND
            s.kd_dati2          = v.kd_dati2 AND
            s.kd_kecamatan      = v.kd_kecamatan AND
            s.kd_kelurahan      = v.kd_kelurahan AND
            s.kd_blok           = v.kd_blok AND
            s.no_urut           = v.no_urut AND
            s.kd_jns_op         = v.kd_jns_op AND
            s.thn_pajak_sppt    = v.thn_pajak_sppt
        where s.status_pembayaran_sppt = '1'
        and s.status_tagihan_sppt = 'W'
        and s.pbb_terhutang_sppt <= 100000
         {$filter}
        ";

        return $sql;
    }

    function query_rpt_2($filter){
        $sql = "
        select 
            ROW_NUMBER() OVER (ORDER BY 
            s.kd_propinsi, s.kd_dati2, s.kd_kecamatan, 
            s.kd_kelurahan, s.kd_blok, s.no_urut, s.kd_jns_op
        ) AS nomor,
        s.kd_propinsi||'.'||s.kd_dati2||'-'||s.kd_kecamatan||'.'||s.kd_kelurahan||'-'||s.kd_blok||'.'||s.no_urut||'.'||s.kd_jns_op AS nop,
        s.thn_pajak_sppt as thn_pajak_sppt,
        s.faktor_pengurang_sppt as faktor_pengurang_sppt,
        s.pbb_terhutang_sppt as pbb_terhutang_sppt,
        CASE WHEN s.tgl_jatuh_tempo_sppt < TO_DATE('2024-01-01', 'YYYY-MM-DD') 
        THEN NVL(hit_denda2(s.pbb_yg_harus_dibayar_sppt, 2, s.tgl_jatuh_tempo_sppt), 0) 
        ELSE NVL(hit_denda2(s.pbb_yg_harus_dibayar_sppt, 1, s.tgl_jatuh_tempo_sppt), 0) END as nil_denda
        from sppt s
        where s.status_pembayaran_sppt = '1'
        and s.status_cetak_sppt = '9'
        and s.pbb_terhutang_sppt <= 100001
         {$filter}
        ";

        return $sql;
    }

}

/* End of file _model.php */
