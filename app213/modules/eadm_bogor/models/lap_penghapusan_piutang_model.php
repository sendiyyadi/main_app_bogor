<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class lap_penghapusan_piutang_model extends CI_Model {

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
        CASE WHEN s.tgl_jatuh_tempo_sppt < TO_DATE('2024-01-01', 'YYYY-MM-DD') 
        THEN NVL(hit_denda2(s.pbb_terhutang_sppt, 2, s.tgl_jatuh_tempo_sppt), 0) 
        ELSE NVL(hit_denda2(s.pbb_terhutang_sppt, 1, s.tgl_jatuh_tempo_sppt), 0) END as nil_denda
        from sppt s
        join ( select * from sppt where thn_pajak_sppt = '2025' and status_pembayaran_sppt = '1' ) p
            on s.kd_propinsi = p.kd_propinsi
            and s.kd_dati2 = p.kd_dati2
            and s.kd_kecamatan = p.kd_kecamatan
            and s.kd_kelurahan = p.kd_kelurahan
            and s.kd_blok = p.kd_blok
            and s.no_urut = p.no_urut
            and s.kd_jns_op = p.kd_jns_op
        where s.status_pembayaran_sppt = '1'
        and s.status_tagihan_sppt = 'W'
         {$filter}
        ";

        return $sql;
    }

}

/* End of file _model.php */
