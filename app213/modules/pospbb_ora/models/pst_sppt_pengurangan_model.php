<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class pst_sppt_pengurangan_model extends CI_Model
{

    private $tbl = 'sppt';
    private $schema_pbb = SCHEMA_PBB . ".";

    function __construct()
    {
        parent::__construct();
    }

    function get_all_distinct($filter = '')
    {
        $schema_pbb = $this->schema_pbb;
        $sql = " select z1.* from (
        select distinct s.kd_propinsi||'.'||s.kd_dati2||'.'||s.kd_kecamatan||'.'||s.kd_kelurahan||'.'||s.kd_blok||'.'||s.no_urut||'.'||s.kd_jns_op as nop, nm_wp_sppt, jln_wp_sppt
		    from S_SPPT s
				where (1=1)" . $filter . "
        ) z1 where rownum<=100 order by nop ";

        $query = $this->db->query($sql);
        if ($query->num_rows() !== 0) {
            return $query->result();
        } else
            return FALSE;
    }

    function get_pengurangan_bayar_ke($nop, $thn)
    {

        $schema_pbb = $this->schema_pbb;

        $nop = preg_replace('/[^0-9]/', '', $nop);
        $kd_propinsi = substr($nop, 0, 2);
        $kd_dati2 = substr($nop, 2, 2);
        $kd_kecamatan = substr($nop, 4, 3);
        $kd_kelurahan = substr($nop, 7, 3);
        $kd_blok = substr($nop, 10, 3);
        $no_urut = substr($nop, 13, 4);
        $kd_jns_op = substr($nop, 17, 1);

        $sql = "select (nvl(max(pembayaran_sppt_ke),0)+1) as jml
        FROM S_PEMBAYARAN_SPPT ps
        where ps.kd_propinsi='$kd_propinsi' and ps.kd_dati2='$kd_dati2' and ps.kd_kecamatan='$kd_kecamatan' and
        ps.kd_kelurahan='$kd_kelurahan' and ps.kd_blok='$kd_blok' and ps.no_urut='$no_urut' and ps.kd_jns_op = '$kd_jns_op'
        and ps.thn_pajak_sppt = '$thn'";
        $query = $this->db->query($sql);
        $nval = $query->row();
        $nva = $nval->JML;
        return $nva;
    }

    function data_grid($str_where = '', $str_limit = '', $str_order_by = '', $filter = '')
    {
        $schema_pbb = $this->schema_pbb;
        $sql = "select count(*) c
              from S_SPPT s ";
        $rows = $this->db->query($sql)->row(1);
        $tot_rows = $rows->c;
        $sql = "select count(*) c
              from S_SPPT s 
			        where (1=1) 
              $str_where ";

        $rows = $this->db->query($sql)->row(1);
        $num_rows = $rows->c;

        $sql = "select s.kd_propinsi||'.'||s.kd_dati2||'.'||s.kd_kecamatan||'.'||s.kd_kelurahan||'.'||s.kd_blok||'.'||s.no_urut||'.'||s.kd_jns_op nop, 
                     thn_pajak_sppt, nm_wp_sppt, pbb_yg_harus_dibayar_sppt, status_pembayaran_sppt
			        from S_SPPT s
			        where (1=1) 
			        $str_where 
			        $filter  
			        $str_order_by 
			        $str_limit ";

        $query              = $this->db->query($sql);
        $result['sql']      = $sql;
        $result['query']    = $query->result_array();
        $result['num_rows'] = $str_where != '' ? $num_rows : $tot_rows;
        $result['tot_rows'] = $tot_rows;

        return $result;
    }

    function data_grid_pmb($nop)
    {
        $schema_pbb = $this->schema_pbb;
        $nop          = urldecode($nop);
        $nop          = str_replace('.', '', $nop);
        $nop          = str_replace(' ', '', $nop);
        $nop          = str_replace('-', '', $nop);
        $nop          = preg_replace('/[^0-9]/', '', $nop);
        $kd_propinsi  = substr($nop, 0, 2);
        $kd_dati2     = substr($nop, 2, 2);
        $kd_kecamatan = substr($nop, 4, 3);
        $kd_kelurahan = substr($nop, 7, 3);
        $kd_blok      = substr($nop, 10, 3);
        $no_urut      = substr($nop, 13, 4);
        $kd_jns_op    = substr($nop, 17, 1);

        $sql = "select thn_pajak_sppt, pbb_yg_harus_dibayar_sppt, case when status_pembayaran_sppt = '1' then 'Sudah' else 'Belum' end status_pembayaran_sppt
			from S_SPPT s
			where s.kd_propinsi='$kd_propinsi' and s.kd_dati2='$kd_dati2' and s.kd_kecamatan='$kd_kecamatan' and 
			      s.kd_kelurahan='$kd_kelurahan' and s.kd_blok='$kd_blok' and s.no_urut='$no_urut' and s.kd_jns_op = '$kd_jns_op'
			group by thn_pajak_sppt, pbb_yg_harus_dibayar_sppt, status_pembayaran_sppt
			order by 1 ";

        $query = $this->db->query($sql);
        if ($query->num_rows() !== 0) {
            return $query->result();
        } else
            return FALSE;
    }

    function get_by_nop_thn_plyn($nop, $thn, $thn_p, $bundel_p, $urut_p)
    {

        $schema_pbb = $this->schema_pbb;
        $nop          = urldecode($nop);
        $nop          = str_replace('.', '', $nop);
        $nop          = str_replace(' ', '', $nop);
        $nop          = str_replace('-', '', $nop);
        $nop          = preg_replace('/[^0-9]/', '', $nop);

        $kd_propinsi  = substr($nop, 0, 2);
        $kd_dati2     = substr($nop, 2, 2);
        $kd_kecamatan = substr($nop, 4, 3);
        $kd_kelurahan = substr($nop, 7, 3);
        $kd_blok      = substr($nop, 10, 3);
        $no_urut      = substr($nop, 13, 4);
        $kd_jns_op    = substr($nop, 17, 1);
        //
        $sql = "select s.nm_wp_sppt, s.jln_wp_sppt, s.rt_wp_sppt, s.rw_wp_sppt, s.kelurahan_wp_sppt, s.kota_wp_sppt, 
        s.npwp_sppt, s.pbb_terhutang_sppt, s.faktor_pengurang_sppt, s.pbb_yg_harus_dibayar_sppt, 
        to_char(s.tgl_jatuh_tempo_sppt,'yyyy-mm-dd') as tgl_jatuh_tempo_sppt, 
        SUM(NVL(ps.denda_sppt,0)) AS denda_sppt, 
        SUM(NVL(jml_sppt_yg_dibayar,0)) AS jml_sppt_yg_dibayar, pst.pct_permohonan_pengurangan, pst.DUMMY_ID as id_p
        from S_SPPT s
        left join S_PEMBAYARAN_SPPT ps on
        s.kd_propinsi=ps.kd_propinsi and s.kd_dati2=ps.kd_dati2 and s.kd_kecamatan=ps.kd_kecamatan and 
        s.kd_kelurahan=ps.kd_kelurahan and s.kd_blok=ps.kd_blok and s.no_urut=ps.no_urut and 
        s.kd_jns_op = ps.kd_jns_op and s.thn_pajak_sppt = ps.thn_pajak_sppt  
        join V_PST_PERMOHONAN_PENGURANGAN pst on
        s.kd_propinsi=pst.kd_propinsi_PEMOHON and s.kd_dati2=pst.kd_dati2_PEMOHON and 
        s.kd_kecamatan=pst.kd_kecamatan_PEMOHON and s.kd_kelurahan=pst.kd_kelurahan_PEMOHON and 
        s.kd_blok=pst.kd_blok_PEMOHON and s.no_urut=pst.no_urut_PEMOHON and 
        s.kd_jns_op = pst.kd_jns_op_PEMOHON and s.thn_pajak_sppt=pst.THN_PAJAK_SPPT_PEMOHON
        where s.kd_propinsi='$kd_propinsi' and s.kd_dati2='$kd_dati2' and s.kd_kecamatan='$kd_kecamatan' 
        and s.kd_kelurahan='$kd_kelurahan' and s.kd_blok='$kd_blok' and s.no_urut='$no_urut' 
        and s.kd_jns_op = '$kd_jns_op' and s.thn_pajak_sppt = '$thn' and s.status_pembayaran_sppt='0'
        and pst.thn_pelayanan = '$thn_p' and pst.bundel_pelayanan = '$bundel_p' 
        and pst.no_urut_pelayanan = '$urut_p' 
        group by s.nm_wp_sppt, s.jln_wp_sppt, s.rt_wp_sppt, s.rw_wp_sppt, s.kelurahan_wp_sppt, s.kota_wp_sppt, 
        s.npwp_sppt, s.pbb_terhutang_sppt, s.faktor_pengurang_sppt, s.pbb_yg_harus_dibayar_sppt, 
        s.tgl_jatuh_tempo_sppt, pst.pct_permohonan_pengurangan, pst.DUMMY_ID 
        HAVING
        (s.pbb_yg_harus_dibayar_sppt - (SUM(NVL(jml_sppt_yg_dibayar,0)) - SUM(NVL(ps.denda_sppt,0)))) > 0 ";
        //
        $query = $this->db->query($sql);

        if ($query->num_rows() !== 0) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    function get_by_nop_thn($nop, $thn)
    {
        $schema_pbb = $this->schema_pbb;
        $nop          = urldecode($nop);
        $nop          = str_replace('.', '', $nop);
        $nop          = str_replace(' ', '', $nop);
        $nop          = str_replace('-', '', $nop);
        $nop          = preg_replace('/[^0-9]/', '', $nop);

        $kd_propinsi  = substr($nop, 0, 2);
        $kd_dati2     = substr($nop, 2, 2);
        $kd_kecamatan = substr($nop, 4, 3);
        $kd_kelurahan = substr($nop, 7, 3);
        $kd_blok      = substr($nop, 10, 3);
        $no_urut      = substr($nop, 13, 4);
        $kd_jns_op    = substr($nop, 17, 1);
        //
        $sql = "select s.nm_wp_sppt, s.jln_wp_sppt, s.rt_wp_sppt, s.rw_wp_sppt, s.kelurahan_wp_sppt, s.kota_wp_sppt, s.npwp_sppt,
        s.pbb_terhutang_sppt, s.faktor_pengurang_sppt, s.pbb_yg_harus_dibayar_sppt, s.tgl_jatuh_tempo_sppt,
        sum(nvl(ps.denda_sppt,0)) AS denda_sppt,
        sum(nvl(ps.jml_sppt_yg_dibayar,0)) AS jml_sppt_yg_dibayar,
        pst.pct_permohonan_pengurangan, pst.dummy_id as id_p
        from S_SPPT s
        left join S_PEMBAYARAN_SPPT ps on
        s.kd_propinsi=ps.kd_propinsi and s.kd_dati2=ps.kd_dati2 and s.kd_kecamatan=ps.kd_kecamatan and 
        s.kd_kelurahan=ps.kd_kelurahan and s.kd_blok=ps.kd_blok and s.no_urut=ps.no_urut and s.kd_jns_op = ps.kd_jns_op
        and s.thn_pajak_sppt = ps.thn_pajak_sppt  
        join S_pst_permohonan_pengurangan pst on
        s.kd_propinsi=pst.kd_propinsi_pemohon and s.kd_dati2=pst.kd_dati2_pemohon and 
        s.kd_kecamatan=pst.kd_kecamatan_pemohon and s.kd_kelurahan=pst.kd_kelurahan_pemohon and 
        s.kd_blok=pst.kd_blok_pemohon and s.no_urut=pst.no_urut_pemohon and 
        s.kd_jns_op = pst.kd_jns_op_pemohon and s.thn_pajak_sppt = pst.thn_pajak_sppt_pemohon 
        where s.kd_propinsi='$kd_propinsi' and s.kd_dati2='$kd_dati2' and s.kd_kecamatan='$kd_kecamatan' and 
        s.kd_kelurahan='$kd_kelurahan' and s.kd_blok='$kd_blok' and s.no_urut='$no_urut' and s.kd_jns_op = '$kd_jns_op'
        and s.thn_pajak_sppt = '$thn' and s.status_pembayaran_sppt='0'
        group  by s.nm_wp_sppt, s.jln_wp_sppt, s.rt_wp_sppt, s.rw_wp_sppt, s.kelurahan_wp_sppt, s.kota_wp_sppt, 
        s.npwp_sppt, s.pbb_terhutang_sppt, s.faktor_pengurang_sppt, s.pbb_yg_harus_dibayar_sppt, 
        s.tgl_jatuh_tempo_sppt, pst.pct_permohonan_pengurangan, pst.dummy_id
        having 
        s.pbb_yg_harus_dibayar_sppt-(sum(nvl(ps.jml_sppt_yg_dibayar,0))-sum(nvl(ps.denda_sppt,0)))>0 ";
        $query = $this->db->query($sql);
        if ($query->num_rows() !== 0) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    function get_pelayanan_kolektif($tahun, $bundel, $urut)
    {

        $schema_pbb = $this->schema_pbb;
        $sql = "select s.kd_propinsi||'.'|| s.kd_dati2||'.'||s.kd_kecamatan||'.'|| s.kd_kelurahan||'-'
      ||s.kd_blok||'.'|| s.no_urut||'.'||s.kd_jns_op as kode, s.thn_pajak_sppt, 
      s.nm_wp_sppt, s.jln_wp_sppt, s.rt_wp_sppt, s.rw_wp_sppt, 
      s.kelurahan_wp_sppt, s.kota_wp_sppt, s.npwp_sppt,  s.pbb_terhutang_sppt, s.faktor_pengurang_sppt, 
      s.pbb_yg_harus_dibayar_sppt, s.tgl_jatuh_tempo_sppt,
      sum(nvl(ps.denda_sppt,0)) as denda_sppt,
      sum(nvl(jml_sppt_yg_dibayar,0)) as jml_sppt_yg_dibayar, s.no_urut, s.kd_jns_op,
      pst.pct_permohonan_pengurangan
      from S_PST_PERMOHONAN_PENGURANGAN pst
      join S_SPPT s on
      s.kd_propinsi=pst.kd_propinsi_pemohon and s.kd_dati2=pst.kd_dati2_pemohon and 
      s.kd_kecamatan=pst.kd_kecamatan_pemohon and s.kd_kelurahan=pst.kd_kelurahan_pemohon and 
      s.kd_blok=pst.kd_blok_pemohon and s.no_urut=pst.no_urut_pemohon and 
      s.kd_jns_op = pst.kd_jns_op_pemohon and s.thn_pajak_sppt = pst.thn_pajak_sppt_pemohon 
      left join S_PEMBAYARAN_SPPT ps on
      s.kd_propinsi=ps.kd_propinsi and s.kd_dati2=ps.kd_dati2 and s.kd_kecamatan=ps.kd_kecamatan and 
      s.kd_kelurahan=ps.kd_kelurahan and s.kd_blok=ps.kd_blok and s.no_urut=ps.no_urut and 
      s.kd_jns_op = ps.kd_jns_op  and s.thn_pajak_sppt = ps.thn_pajak_sppt
      where pst.thn_pelayanan = '$tahun' and pst.bundel_pelayanan = '$bundel' 
      and pst.no_urut_pelayanan = '$urut'
      and s.status_pembayaran_sppt='0'
      group  by  s.kd_propinsi, s.kd_dati2, s.kd_kecamatan, s.kd_kelurahan, s.kd_blok, s.no_urut, 
      s.kd_jns_op, s.thn_pajak_sppt, s.nm_wp_sppt, s.jln_wp_sppt, s.rt_wp_sppt, s.rw_wp_sppt, 
      s.kelurahan_wp_sppt, s.kota_wp_sppt, s.npwp_sppt, s.pbb_terhutang_sppt, s.faktor_pengurang_sppt, 
      s.pbb_yg_harus_dibayar_sppt, s.tgl_jatuh_tempo_sppt, pst.pct_permohonan_pengurangan 
      having 
      s.pbb_yg_harus_dibayar_sppt-(sum(nvl(jml_sppt_yg_dibayar,0))-sum(nvl(ps.denda_sppt,0)))>0
      order by s.thn_pajak_sppt ";
        // die($sql);
        $query = $this->db->query($sql);

        $result['sql']      = $sql;
        $result['query']    = $query->result_array();
        $result['num_rows'] = $query->num_rows();
        $result['tot_rows'] = $query->num_rows();

        return $result;
    }

    function get_by_blok_thn($blok, $thn)
    {
        $schema_pbb = $this->schema_pbb;
        $blok          = urldecode($blok);
        $blok          = str_replace('.', '', $blok);
        $blok          = str_replace(' ', '', $blok);
        $blok          = str_replace('-', '', $blok);
        $blok          = preg_replace('/[^0-9]/', '', $blok);

        $kd_propinsi  = substr($blok, 0, 2);
        $kd_dati2     = substr($blok, 2, 2);
        $kd_kecamatan = substr($blok, 4, 3);
        $kd_kelurahan = substr($blok, 7, 3);
        $kd_blok      = substr($blok, 10, 3);

        $sql = "select s.kd_propinsi||'.'|| s.kd_dati2||'.'||s.kd_kecamatan||'.'|| s.kd_kelurahan||'-'
         ||s.kd_blok||'.'|| s.no_urut||'.'||s.kd_jns_op as kode, s.thn_pajak_sppt, 
         s.nm_wp_sppt, s.jln_wp_sppt, s.rt_wp_sppt, s.rw_wp_sppt, 
         s.kelurahan_wp_sppt, s.kota_wp_sppt, s.npwp_sppt,  s.pbb_terhutang_sppt, s.faktor_pengurang_sppt, 
         s.pbb_yg_harus_dibayar_sppt, s.tgl_jatuh_tempo_sppt,  coalesce(sum(ps.denda_sppt),0) denda_sppt,
           coalesce(sum(jml_sppt_yg_dibayar),0) jml_sppt_yg_dibayar, s.no_urut, s.kd_jns_op 
        from S_SPPT s
           left join S_PEMBAYARAN_SPPT ps on
              s.kd_propinsi=ps.kd_propinsi and s.kd_dati2=ps.kd_dati2 and s.kd_kecamatan=ps.kd_kecamatan and 
              s.kd_kelurahan=ps.kd_kelurahan and s.kd_blok=ps.kd_blok and s.no_urut=ps.no_urut and 
              s.kd_jns_op = ps.kd_jns_op  and s.thn_pajak_sppt = ps.thn_pajak_sppt  
        where s.kd_propinsi='$kd_propinsi' and s.kd_dati2='$kd_dati2' and s.kd_kecamatan='$kd_kecamatan' and 
              s.kd_kelurahan='$kd_kelurahan' and s.kd_blok='$kd_blok' 
              and s.thn_pajak_sppt = '$thn' and s.status_pembayaran_sppt='0'
          
        group  by  s.kd_propinsi, s.kd_dati2, s.kd_kecamatan, s.kd_kelurahan, s.kd_blok, s.no_urut, 
              s.kd_jns_op, s.thn_pajak_sppt, s.nm_wp_sppt, s.jln_wp_sppt, s.rt_wp_sppt, s.rw_wp_sppt, 
              s.kelurahan_wp_sppt, s.kota_wp_sppt, s.npwp_sppt, s.pbb_terhutang_sppt, s.faktor_pengurang_sppt, 
              s.pbb_yg_harus_dibayar_sppt, s.tgl_jatuh_tempo_sppt 
        having 
              s.pbb_yg_harus_dibayar_sppt-(coalesce(sum(jml_sppt_yg_dibayar),0)-coalesce(sum(ps.denda_sppt),0))>0
      ";
        //die($sql);
        $query = $this->db->query($sql);

        $result['sql']      = $sql;
        $result['query']    = $query->result_array();
        $result['num_rows'] = $query->num_rows();
        $result['tot_rows'] = $query->num_rows();

        return $result;
    }

    function get_by_range_thn($blok, $blok2, $thn)
    {
        $schema_pbb = $this->schema_pbb;
        $blok          = urldecode($blok);
        $blok          = str_replace('.', '', $blok);
        $blok          = str_replace(' ', '', $blok);
        $blok          = str_replace('-', '', $blok);
        $blok          = preg_replace('/[^0-9]/', '', $blok);

        $kd_propinsi  = substr($blok, 0, 2);
        $kd_dati2     = substr($blok, 2, 2);
        $kd_kecamatan = substr($blok, 4, 3);
        $kd_kelurahan = substr($blok, 7, 3);
        $kd_blok      = substr($blok, 10, 3);
        $no_urut      = substr($blok, 13, 4);
        $kd_jenis      = substr($blok, 17, 1);

        $blok2          = urldecode($blok2);
        $blok2          = str_replace('.', '', $blok2);
        $blok2          = str_replace(' ', '', $blok2);
        $blok2          = str_replace('-', '', $blok2);
        $blok2          = preg_replace('/[^0-9]/', '', $blok2);

        $no_urut_2      = substr($blok2, 0, 4);
        $kd_jenis_2     = substr($blok2, 4, 1);

        $sql = "select s.kd_propinsi||'.'|| s.kd_dati2||'.'||s.kd_kecamatan||'.'|| s.kd_kelurahan||'-'
         ||s.kd_blok||'.'|| s.no_urut||'.'||s.kd_jns_op as kode, s.thn_pajak_sppt, 
         s.nm_wp_sppt, s.jln_wp_sppt, s.rt_wp_sppt, s.rw_wp_sppt, 
         s.kelurahan_wp_sppt, s.kota_wp_sppt, s.npwp_sppt,  s.pbb_terhutang_sppt, s.faktor_pengurang_sppt, 
         s.pbb_yg_harus_dibayar_sppt, s.tgl_jatuh_tempo_sppt,  coalesce(sum(ps.denda_sppt),0) denda_sppt,
           coalesce(sum(jml_sppt_yg_dibayar),0) jml_sppt_yg_dibayar, s.no_urut, s.kd_jns_op 
        from S_SPPT s
           left join S_PEMBAYARAN_SPPT ps on
              s.kd_propinsi=ps.kd_propinsi and s.kd_dati2=ps.kd_dati2 and s.kd_kecamatan=ps.kd_kecamatan and 
              s.kd_kelurahan=ps.kd_kelurahan and s.kd_blok=ps.kd_blok and s.no_urut=ps.no_urut and 
              s.kd_jns_op = ps.kd_jns_op  and s.thn_pajak_sppt = ps.thn_pajak_sppt  
        where s.kd_propinsi='$kd_propinsi' and s.kd_dati2='$kd_dati2' and s.kd_kecamatan='$kd_kecamatan' and 
              s.kd_kelurahan='$kd_kelurahan' and s.kd_blok='$kd_blok' and s.no_urut BETWEEN '$no_urut' AND '$no_urut_2' 
              and s.thn_pajak_sppt = '$thn' and s.status_pembayaran_sppt='0'
        group  by  s.kd_propinsi, s.kd_dati2, s.kd_kecamatan, s.kd_kelurahan, s.kd_blok, s.no_urut, 
              s.kd_jns_op, s.thn_pajak_sppt, s.nm_wp_sppt, s.jln_wp_sppt, s.rt_wp_sppt, s.rw_wp_sppt, 
              s.kelurahan_wp_sppt, s.kota_wp_sppt, s.npwp_sppt, s.pbb_terhutang_sppt, s.faktor_pengurang_sppt, 
              s.pbb_yg_harus_dibayar_sppt, s.tgl_jatuh_tempo_sppt 
        having 
              s.pbb_yg_harus_dibayar_sppt-(coalesce(sum(jml_sppt_yg_dibayar),0)-coalesce(sum(ps.denda_sppt),0))>0
      ";
        $query = $this->db->query($sql);

        $result['sql']      = $sql;
        $result['query']    = $query->result_array();
        $result['num_rows'] = $query->num_rows();
        $result['tot_rows'] = $query->num_rows();

        return $result;
    }

    function add_bayar_tanpa_denda_OLD($data)
    {
        // sama dgn  
        //log_message('info', "WWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWW  add_bayar_tanpa_denda : ");
        $schema_pbb = $this->schema_pbb;
        $tabel      = $schema_pbb . "PEMBAYARAN_SPPT";
        $result = $this->db->insert_eon_ora($tabel, $data);
        return $result;
    }

    function add_bayar_tanpa_denda($nop, $thn, $sisa_sppt, $data)
    {
        // sama dgn  
        //log_message('info', "WWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWW  add_bayar_tanpa_denda : ");
        $schema_pbb = $this->schema_pbb;
        $tabel      = $schema_pbb . "PEMBAYARAN_SPPT";
        //
        $nop          = urldecode($nop);
        $nop          = str_replace('.', '', $nop);
        $nop          = str_replace(' ', '', $nop);
        $nop          = str_replace('-', '', $nop);
        $nop          = preg_replace('/[^0-9]/', '', $nop);

        $kd_propinsi  = substr($nop, 0, 2);
        $kd_dati2     = substr($nop, 2, 2);
        $kd_kecamatan = substr($nop, 4, 3);
        $kd_kelurahan = substr($nop, 7, 3);
        $kd_blok      = substr($nop, 10, 3);
        $no_urut      = substr($nop, 13, 4);
        $kd_jns_op    = substr($nop, 17, 1);

        $exists = "(select s.pbb_yg_harus_dibayar_sppt,
      sum(nvl(ps.denda_sppt,0)) as denda_sppt,
      sum(nvl(ps.jml_sppt_yg_dibayar,0)) as jml_sppt_yg_dibayar
      from S_SPPT s
      left join S_PEMBAYARAN_SPPT ps on
      s.kd_propinsi=ps.kd_propinsi and s.kd_dati2=ps.kd_dati2 
      and s.kd_kecamatan=ps.kd_kecamatan and s.kd_kelurahan=ps.kd_kelurahan 
      and s.kd_blok=ps.kd_blok and s.no_urut=ps.no_urut and s.kd_jns_op = ps.kd_jns_op
      and s.thn_pajak_sppt = ps.thn_pajak_sppt  
      where s.kd_propinsi='$kd_propinsi' and s.kd_dati2='$kd_dati2' and 
      s.kd_kecamatan='$kd_kecamatan' and 
      s.kd_kelurahan='$kd_kelurahan' and s.kd_blok='$kd_blok' and s.no_urut='$no_urut' and s.kd_jns_op='$kd_jns_op'
      and s.thn_pajak_sppt = '$thn' and s.status_pembayaran_sppt='0'
      and $sisa_sppt>0
      group by s.pbb_yg_harus_dibayar_sppt
      having 
      s.pbb_yg_harus_dibayar_sppt-(sum(nvl(ps.jml_sppt_yg_dibayar,0))-sum(nvl(ps.denda_sppt,0)))=$sisa_sppt)";
        //
        //$keys   = implode(', ', array_keys($data));
        //$values = implode("', '", array_values($data));

        $keys   = array_keys($data);
        $values = array_values($data);
        //
        $keys   = implode(', ', $keys);
        $values = "'" . implode("', '", $values) . "'";
        //
        $sql = " begin
      INSERT INTO " . $tabel . " (" . $keys . ")
      select " . $values . " from dual 
      where exists(" . $exists . ");
      IF sql%rowcount = 0 THEN
          RAISE_APPLICATION_ERROR (-20054, 'Tidak ada Penambahan Data....');
      END IF;
      commit;
      end;";
        // cek juga jika tdk ada hasil error data
        $result = $this->db->simple_qry_eon_ora($sql);
        // hasil dari simple_qry_eon_ora bentuk array
        return $result['message'];
    }

    function add_bayar_hist_tanpa_denda($data)
    {
        $schema_pbb = $this->schema_pbb;
        // sama dgn  
        //log_message('info', "WWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWW  add_bayar_hist_tanpa_denda : ");
        //PST_BYR_PENGURANGAN
        $result = $this->db->insert_eon_ora('HIST_PEMBAYARAN_SPPT', $data);
        return $result;
    }

    function get_permohonan_pengurangan($nop, $thn, $thn_p, $bundel_p, $urut_p)
    {

        $schema_pbb = $this->schema_pbb;
        $nop          = urldecode($nop);
        $nop          = str_replace('.', '', $nop);
        $nop          = str_replace(' ', '', $nop);
        $nop          = str_replace('-', '', $nop);
        $nop          = preg_replace('/[^0-9]/', '', $nop);

        $kd_propinsi  = substr($nop, 0, 2);
        $kd_dati2     = substr($nop, 2, 2);
        $kd_kecamatan = substr($nop, 4, 3);
        $kd_kelurahan = substr($nop, 7, 3);
        $kd_blok      = substr($nop, 10, 3);
        $no_urut      = substr($nop, 13, 4);
        $kd_jns_op    = substr($nop, 17, 1);

        $sql = "SELECT pst.KD_KANWIL,pst.KD_KANTOR,pst.THN_PELAYANAN,pst.BUNDEL_PELAYANAN,pst.NO_URUT_PELAYANAN,
        pst.KD_PROPINSI_PEMOHON,pst.KD_DATI2_PEMOHON,pst.KD_KECAMATAN_PEMOHON,pst.KD_KELURAHAN_PEMOHON,
        pst.KD_BLOK_PEMOHON,pst.NO_URUT_PEMOHON,pst.KD_JNS_OP_PEMOHON,pst.JNS_PENGURANGAN,
        pst.PCT_PERMOHONAN_PENGURANGAN,pst.THN_PAJAK_SPPT_PEMOHON,
        s.PBB_TERHUTANG_SPPT, s.FAKTOR_PENGURANG_SPPT, s.PBB_YG_HARUS_DIBAYAR_SPPT
        FROM S_PST_PERMOHONAN_PENGURANGAN pst
        join S_SPPT s on
        s.kd_propinsi=pst.kd_propinsi_pemohon and s.kd_dati2=pst.kd_dati2_pemohon and 
        s.kd_kecamatan=pst.kd_kecamatan_pemohon and s.kd_kelurahan=pst.kd_kelurahan_pemohon and 
        s.kd_blok=pst.kd_blok_pemohon and s.no_urut=pst.no_urut_pemohon and 
        s.kd_jns_op = pst.kd_jns_op_pemohon and s.thn_pajak_sppt = pst.thn_pajak_sppt_pemohon 
        where pst.KD_PROPINSI_PEMOHON='$kd_propinsi' and pst.KD_DATI2_PEMOHON='$kd_dati2' 
        and pst.KD_KECAMATAN_PEMOHON='$kd_kecamatan' and pst.KD_KELURAHAN_PEMOHON='$kd_kelurahan' 
        and pst.KD_BLOK_PEMOHON='$kd_blok' and pst.NO_URUT_PEMOHON='$no_urut' 
        and pst.KD_JNS_OP_PEMOHON = '$kd_jns_op' and pst.THN_PAJAK_SPPT_PEMOHON = '$thn' 
        and pst.THN_PELAYANAN = '$thn_p' and pst.BUNDEL_PELAYANAN = '$bundel_p' 
        and pst.NO_URUT_PELAYANAN = '$urut_p' and rownum<=1 ";
        $query = $this->db->query($sql);
        if ($query->num_rows() !== 0) {
            return $query->row();
        } else {
            return FALSE;
        }
    }
}

/* End of file _model.php */
