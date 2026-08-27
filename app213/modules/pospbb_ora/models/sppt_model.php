<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class sppt_model extends CI_Model
{
    private $tbl    = 'SPPT';
    private $schema_pbb = SCHEMA_PBB.".";
    
    function __construct()
    {
        parent::__construct();
    }
    
    function get_all_distinct($filter = '')
    {
        $schema_pbb = $this->schema_pbb;
        $sql = " select z1.* from (
        select distinct s.kd_propinsi||'.'||s.kd_dati2||'.'||s.kd_kecamatan||'.'||s.kd_kelurahan||'.'||s.kd_blok||'.'||s.no_urut||'.'||s.kd_jns_op as nop,
        nm_wp_sppt, jln_wp_sppt
		    from S_SPPT s
				where (1=1)" . $filter . "
        ) z1 where rownum<=100 order by nop ";
        
        $query = $this->db->query($sql);
        if ($query->num_rows() !== 0) {
            return $query->result();
        } else
            return FALSE;
    }
    
    function data_grid($str_where = '', $str_limit = '', $str_order_by = '', $filter = '')
    {
      $schema_pbb = $this->schema_pbb;
      $sql = "select count(*) c
              from  S_SPPT s ";
      $rows= $this->db->query($sql)->row(1);
      $tot_rows = $rows->c;  
      $sql = "select count(*) c
              from  S_SPPT s 
			        where (1=1) 
              $str_where ";
      
      $rows= $this->db->query($sql)->row(1);
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
        $nop          = preg_replace( '/[^0-9]/', '', $nop);
        $kd_propinsi  = substr($nop, 0, 2);
        $kd_dati2     = substr($nop, 2, 2);
        $kd_kecamatan = substr($nop, 4, 3);
        $kd_kelurahan = substr($nop, 7, 3);
        $kd_blok      = substr($nop, 10, 3);
        $no_urut      = substr($nop, 13, 4);
        $kd_jns_op    = substr($nop, 17, 1);
        
        $sql = "select thn_pajak_sppt, pbb_yg_harus_dibayar_sppt, 
        case when status_pembayaran_sppt = '1' then 'Sudah' else 'Belum' end status_pembayaran_sppt
        from  S_SPPT s
        where s.kd_propinsi='$kd_propinsi' and s.kd_dati2='$kd_dati2' and s.kd_kecamatan='$kd_kecamatan' and 
        s.kd_kelurahan='$kd_kelurahan' and s.kd_blok='$kd_blok' and s.no_urut='$no_urut' and s.kd_jns_op = '$kd_jns_op'
        group by thn_pajak_sppt, pbb_yg_harus_dibayar_sppt, status_pembayaran_sppt
        order by thn_pajak_sppt ";
        
        $query = $this->db->query($sql);
        if ($query->num_rows() !== 0) {
            return $query->result();
        } else
            return FALSE;
    }
        
    function get_by_nop_thn($nop, $thn)
    {
        $schema_pbb = $this->schema_pbb;
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

        $sql = "select spt.nm_wp_sppt, spt.jln_wp_sppt, spt.rt_wp_sppt, spt.rw_wp_sppt, 
        spt.kelurahan_wp_sppt, spt.kota_wp_sppt, spt.npwp_sppt,
        spt.pbb_terhutang_sppt, spt.faktor_pengurang_sppt, 
        spt.pbb_yg_harus_dibayar_sppt, spt.tgl_jatuh_tempo_sppt,
        sum(nvl(ps.denda_sppt,0)) as denda_sppt,
        sum(nvl(ps.jml_sppt_yg_dibayar,0)) as jml_sppt_yg_dibayar
        from  S_SPPT spt
        left join S_PEMBAYARAN_SPPT ps on
        spt.kd_propinsi=ps.kd_propinsi and spt.kd_dati2=ps.kd_dati2 
        and spt.kd_kecamatan=ps.kd_kecamatan and spt.kd_kelurahan=ps.kd_kelurahan 
        and spt.kd_blok=ps.kd_blok and spt.no_urut=ps.no_urut and spt.kd_jns_op = ps.kd_jns_op
        and spt.thn_pajak_sppt = ps.thn_pajak_sppt  
        where spt.kd_propinsi='$kd_propinsi' and spt.kd_dati2='$kd_dati2' and 
        spt.kd_kecamatan='$kd_kecamatan' and 
        spt.kd_kelurahan='$kd_kelurahan' and spt.kd_blok='$kd_blok' and spt.no_urut='$no_urut' and spt.kd_jns_op = '$kd_jns_op'
        and spt.thn_pajak_sppt = '$thn' and spt.status_pembayaran_sppt='0'
        group  by spt.nm_wp_sppt, spt.jln_wp_sppt, spt.rt_wp_sppt, spt.rw_wp_sppt, 
        spt.kelurahan_wp_sppt, spt.kota_wp_sppt, spt.npwp_sppt,
        spt.pbb_terhutang_sppt, spt.faktor_pengurang_sppt, 
        spt.pbb_yg_harus_dibayar_sppt, spt.tgl_jatuh_tempo_sppt 
        having 
        spt.pbb_yg_harus_dibayar_sppt-(sum(nvl(ps.jml_sppt_yg_dibayar,0))-sum(nvl(ps.denda_sppt,0)))>0";
        $query = $this->db->query($sql);
        
        if ($query->num_rows() !== 0) {
            return $query->row();
            
        } else
            return FALSE;
    }
    
    function get_by_blok_thn($blok, $thn)
    {
      $schema_pbb = $this->schema_pbb;
      $blok = urldecode($blok);
      $blok = str_replace('.', '', $blok);
      $blok = str_replace(' ', '', $blok);
      $blok = str_replace('-', '', $blok);
      $blok = preg_replace( '/[^0-9]/', '', $blok);

      $kd_propinsi  = substr($blok, 0, 2);
      $kd_dati2     = substr($blok, 2, 2);
      $kd_kecamatan = substr($blok, 4, 3);
      $kd_kelurahan = substr($blok, 7, 3);
      $kd_blok      = substr($blok, 10, 3);
      //
      $sql = "select z1.* from (
      select spt.kd_propinsi||'.'|| spt.kd_dati2||'.'||spt.kd_kecamatan||'.'|| spt.kd_kelurahan||'-'
      ||spt.kd_blok||'.'|| spt.no_urut||'.'||spt.kd_jns_op as kode, spt.thn_pajak_sppt, 
      spt.nm_wp_sppt, spt.jln_wp_sppt, spt.rt_wp_sppt, spt.rw_wp_sppt, 
      spt.kelurahan_wp_sppt, spt.kota_wp_sppt, spt.npwp_sppt,  spt.pbb_terhutang_sppt, spt.faktor_pengurang_sppt, 
      spt.pbb_yg_harus_dibayar_sppt, spt.tgl_jatuh_tempo_sppt,  
      sum(nvl(ps.denda_sppt,0)) as denda_sppt,
      sum(nvl(ps.jml_sppt_yg_dibayar,0)) as jml_sppt_yg_dibayar, spt.no_urut, spt.kd_jns_op 
      from  S_SPPT spt
      left join S_PEMBAYARAN_SPPT ps on
      spt.kd_propinsi=ps.kd_propinsi and spt.kd_dati2=ps.kd_dati2 and spt.kd_kecamatan=ps.kd_kecamatan and 
      spt.kd_kelurahan=ps.kd_kelurahan and spt.kd_blok=ps.kd_blok and spt.no_urut=ps.no_urut and 
      spt.kd_jns_op = ps.kd_jns_op  and spt.thn_pajak_sppt = ps.thn_pajak_sppt  
      where spt.kd_propinsi='$kd_propinsi' and spt.kd_dati2='$kd_dati2' and spt.kd_kecamatan='$kd_kecamatan' and 
      spt.kd_kelurahan='$kd_kelurahan' and spt.kd_blok='$kd_blok' 
      and spt.thn_pajak_sppt = '$thn' and spt.status_pembayaran_sppt='0'
      group  by  spt.kd_propinsi, spt.kd_dati2, spt.kd_kecamatan, spt.kd_kelurahan, spt.kd_blok, spt.no_urut, 
      spt.kd_jns_op, spt.thn_pajak_sppt, spt.nm_wp_sppt, spt.jln_wp_sppt, spt.rt_wp_sppt, spt.rw_wp_sppt, 
      spt.kelurahan_wp_sppt, spt.kota_wp_sppt, spt.npwp_sppt, spt.pbb_terhutang_sppt, spt.faktor_pengurang_sppt, 
      spt.pbb_yg_harus_dibayar_sppt, spt.tgl_jatuh_tempo_sppt 
      having 
      spt.pbb_yg_harus_dibayar_sppt - (sum(nvl(ps.jml_sppt_yg_dibayar,0)) - sum(nvl(ps.denda_sppt,0)))>0
      ) z1 
      order by kode";
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
      $blok          = preg_replace( '/[^0-9]/', '', $blok);

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
      $blok2          = preg_replace( '/[^0-9]/', '', $blok2);

      $no_urut_2      = substr($blok2, 0, 4);
      $kd_jenis_2     = substr($blok2, 4, 1);

      $sql = "select z1.* from (
      select spt.kd_propinsi||'.'|| spt.kd_dati2||'.'||spt.kd_kecamatan||'.'|| spt.kd_kelurahan||'-'
      ||spt.kd_blok||'.'|| spt.no_urut||'.'||spt.kd_jns_op as kode, spt.thn_pajak_sppt, 
      spt.nm_wp_sppt, spt.jln_wp_sppt, spt.rt_wp_sppt, spt.rw_wp_sppt, 
      spt.kelurahan_wp_sppt, spt.kota_wp_sppt, spt.npwp_sppt,  spt.pbb_terhutang_sppt, spt.faktor_pengurang_sppt, 
      spt.pbb_yg_harus_dibayar_sppt, spt.tgl_jatuh_tempo_sppt,  sum(nvl(ps.denda_sppt,0)) as denda_sppt,
      sum(nvl(ps.jml_sppt_yg_dibayar,0)) as jml_sppt_yg_dibayar, spt.no_urut, spt.kd_jns_op 
      from  S_SPPT spt
      left join S_PEMBAYARAN_SPPT ps on
      spt.kd_propinsi=ps.kd_propinsi and spt.kd_dati2=ps.kd_dati2 and spt.kd_kecamatan=ps.kd_kecamatan and 
      spt.kd_kelurahan=ps.kd_kelurahan and spt.kd_blok=ps.kd_blok and spt.no_urut=ps.no_urut and 
      spt.kd_jns_op = ps.kd_jns_op  and spt.thn_pajak_sppt = ps.thn_pajak_sppt  
      where spt.kd_propinsi='$kd_propinsi' and spt.kd_dati2='$kd_dati2' and spt.kd_kecamatan='$kd_kecamatan' and 
      spt.kd_kelurahan='$kd_kelurahan' and spt.kd_blok='$kd_blok' and spt.no_urut BETWEEN '$no_urut' AND '$no_urut_2' 
      and spt.thn_pajak_sppt = '$thn' and spt.status_pembayaran_sppt='0'
      group  by  spt.kd_propinsi, spt.kd_dati2, spt.kd_kecamatan, spt.kd_kelurahan, spt.kd_blok, spt.no_urut, 
      spt.kd_jns_op, spt.thn_pajak_sppt, spt.nm_wp_sppt, spt.jln_wp_sppt, spt.rt_wp_sppt, spt.rw_wp_sppt, 
      spt.kelurahan_wp_sppt, spt.kota_wp_sppt, spt.npwp_sppt, spt.pbb_terhutang_sppt, spt.faktor_pengurang_sppt, 
      spt.pbb_yg_harus_dibayar_sppt, spt.tgl_jatuh_tempo_sppt 
      having 
      spt.pbb_yg_harus_dibayar_sppt-(sum(nvl(ps.jml_sppt_yg_dibayar,0))-sum(nvl(ps.denda_sppt,0)))>0 
      ) z1 order by z1.kode";
      $query = $this->db->query($sql);

      $result['sql']      = $sql;
      $result['query']    = $query->result_array();
      $result['num_rows'] = $query->num_rows();
      $result['tot_rows'] = $query->num_rows();
		
      return $result;
    }

    function get_by_nop($nop)
    {
        $schema_pbb = $this->schema_pbb;
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

      $sql = "select z1.* from (
      select spt.kd_propinsi||'.'|| spt.kd_dati2||'.'||spt.kd_kecamatan||'.'|| spt.kd_kelurahan||'-'
      ||spt.kd_blok||'.'|| spt.no_urut||'.'||spt.kd_jns_op as kode, spt.thn_pajak_sppt, 
      spt.nm_wp_sppt, spt.jln_wp_sppt, spt.rt_wp_sppt, spt.rw_wp_sppt, 
      spt.kelurahan_wp_sppt, spt.kota_wp_sppt, spt.npwp_sppt, spt.pbb_terhutang_sppt, spt.faktor_pengurang_sppt, 
      spt.pbb_yg_harus_dibayar_sppt, spt.tgl_jatuh_tempo_sppt,  
      sum(nvl(ps.denda_sppt,0)) as denda_sppt,
      sum(nvl(ps.jml_sppt_yg_dibayar,0)) as jml_sppt_yg_dibayar, spt.no_urut, spt.kd_jns_op 
      from  S_SPPT spt
      left join S_PEMBAYARAN_SPPT ps on
      spt.kd_propinsi=ps.kd_propinsi and spt.kd_dati2=ps.kd_dati2 and spt.kd_kecamatan=ps.kd_kecamatan and 
      spt.kd_kelurahan=ps.kd_kelurahan and spt.kd_blok=ps.kd_blok and spt.no_urut=ps.no_urut and 
      spt.kd_jns_op = ps.kd_jns_op  and spt.thn_pajak_sppt = ps.thn_pajak_sppt  
      where spt.kd_propinsi='$kd_propinsi' and spt.kd_dati2='$kd_dati2' and spt.kd_kecamatan='$kd_kecamatan' and 
      spt.kd_kelurahan='$kd_kelurahan' and spt.kd_blok='$kd_blok' and spt.no_urut='$no_urut' and spt.kd_jns_op = '$kd_jns_op'
      and spt.status_pembayaran_sppt='0'
      group  by  spt.kd_propinsi, spt.kd_dati2, spt.kd_kecamatan, spt.kd_kelurahan, spt.kd_blok, spt.no_urut, 
      spt.kd_jns_op, spt.thn_pajak_sppt, spt.nm_wp_sppt, spt.jln_wp_sppt, spt.rt_wp_sppt, spt.rw_wp_sppt, 
      spt.kelurahan_wp_sppt, spt.kota_wp_sppt, spt.npwp_sppt, spt.pbb_terhutang_sppt, spt.faktor_pengurang_sppt, 
      spt.pbb_yg_harus_dibayar_sppt, spt.tgl_jatuh_tempo_sppt 
      having 
      spt.pbb_yg_harus_dibayar_sppt - (sum(nvl(ps.jml_sppt_yg_dibayar,0)) - sum(nvl(ps.denda_sppt,0)))>0
      ) z1 order by thn_pajak_sppt";
      // die($sql);
      //log_message('info', "6666666666666666666666666666666  get_by_nop : ". $sql);
      $query = $this->db->query($sql);

      $result['sql']      = $sql;
      $result['query']    = $query->result_array();
      $result['num_rows'] = $query->num_rows();
      $result['tot_rows'] = $query->num_rows();
		
      return $result;
    }

    function range_thn_sppt() 
    {
        $schema_pbb = $this->schema_pbb;
        $maxtahun = date('Y');
        $data = [];
        //
        $sql = "select nvl((select min(thn_pajak_sppt) from S_SPPT), to_char(sysdate,'YYYY') ) as mintahun from dual";
        $query = $this->db->query($sql);
        $mintahun = $query->row()->MINTAHUN;
        //
        $thncnt = $maxtahun - $mintahun;
        for ($i=$maxtahun; $i>=$maxtahun-$thncnt; $i--){
            $tahun = $i;
            $data += [ "$tahun" => $tahun ];
        }
        return $data;
    }

    /*
    function save($data)
    {
        $this->db->insert($this->tbl, $data);
    }
    
    function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update($this->tbl, $data);
    }
    
    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->tbl);
    }
    */
}

/* End of file _model.php */
