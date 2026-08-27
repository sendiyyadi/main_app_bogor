<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class refpropinsi_model extends CI_Model {
	private $tbl = 'ref_propinsi';
	
	function __construct() {
		parent::__construct();
	}
	
	function tambah($data) {
		$this->db->insert($this->tbl,$data);
	}
	
	function koreksi($kd_propinsi, $data) {
		$this->db->where('kd_propinsi', $kd_propinsi);
		$this->db->update($this->tbl,$data);
	}
	
	function hapus($kd_propinsi) {
		$this->db->where('kd_propinsi', $kd_propinsi);
		$this->db->delete($this->tbl);
	}

	
	function get_all_distinct($filter='')
	{
		$sql = "select distinct s.kd_propinsi||'.'||s.kd_dati2||'.'||s.kd_kecamatan||'.'||s.kd_kelurahan
		               ||'.'||s.kd_blok||'.'||s.no_urut||'.'||s.kd_jns_op nop, nm_wp_sppt, jln_wp_sppt
		    from sppt s
				where (1=1)".$filter."
				order by nop 
				limit 100";
				
		$query = $this->db->query($sql);
		if($query->num_rows()!==0)
		{
			return $query->result();
		}
		else
			return FALSE;
	}
			
	function data_grid($str_where='', $str_limit='', $str_order_by='', $filter='')
	{
    $sql     = " SELECT COUNT(*) c FROM ".$this->tbl;
    $qry  = $this->db->query($sql)->result_array();
    $tot_rows = $result['c');
    
    $sql          = " SELECT COUNT(*) c FROM ".$this->tbl.
                    " WHERE (1=1) $str_where $filter  ";
    $qry       = $this->db->query($sql)->result_array();
    $fil_rows = $result['c');
    
    $sql = " SELECT *
			       FROM ".$this->tbl.
			     " WHERE (1=1) $str_where $filter  
			       ORDER BY $str_order_by 
			       LIMIT $str_limit";

		$qry = $this->db->query($sql);

		$result['sql']      = $sql;
		$result['qry']      = $qry->result_array();
		$result['num_rows'] = $qry->num_rows();
		$result['tot_rows'] = $tot_rows;
		$result['fil_rows'] = $query->num_rows();
		
		return $result;
	}
}

/* End of file _model.php */