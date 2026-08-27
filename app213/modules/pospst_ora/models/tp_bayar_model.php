<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class tp_bayar_model extends CI_Model
{

	private $tbl = 'TEMPAT_PEMBAYARAN';
	private $schema_pbb = SCHEMA_PBB . ".";

	function __construct()
	{
		parent::__construct();
	}

	function pos_field()
	{
		return pos_join("up", "tp");
	}

	function get_all()
	{
		$schema_pbb = $this->schema_pbb;
		//$sql = "select ID,KD_KANWIL,KD_KANTOR,KD_TP,NM_TP,ALAMAT_TP,NO_REK_TP
		$sql = "SELECT DUMMY_ID, KD_KANWIL, KD_KANTOR, KD_TP, NM_TP, ALAMAT_TP, NO_REK_TP
        FROM V_TEMPAT_PEMBAYARAN TP order by NM_TP ";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	function get($id)
	{
		$schema_pbb = $this->schema_pbb;
		$sql = "select *
        from V_TEMPAT_PEMBAYARAN 
        where dummy_id = '$id'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}

	function save($data)
	{
		$this->db->trans_start();
		// $this->db->insert($this->tbl, $data);
		$this->db->insert('V_TEMPAT_PEMBAYARAN', $data);
		$this->db->trans_complete();
		if ($this->db->trans_status())
			return true;
		else
			return false;
	}

	function update($id, $data)
	{
		$this->db->trans_start();
		$this->db->where('DUMMY_ID', $id);
		$this->db->update('V_TEMPAT_PEMBAYARAN', $data);
		// $this->db->update($this->tbl, $data);
		$this->db->trans_complete();

		if ($this->db->trans_status())
			return true;
		else
			return false;
	}

	function delete($data)
	{
		$this->db->trans_start();
		$this->db->where('DUMMY_ID', $data);
		// $this->db->delete($this->tbl);
		$this->db->delete('V_TEMPAT_PEMBAYARAN');
		$this->db->trans_complete();
		if ($this->db->trans_status())
			return true;
		else
			return false;
	}

	function data_grid($str_where = '', $str_limit = '', $str_order_by = '', $filter = '')
	{
		$schema_pbb = $this->schema_pbb;
		$sql     = " SELECT COUNT(*) c FROM " . $this->tbl;
		$qry  = $this->db->query($sql)->row(0);
		$tot_rows = $qry->c;
		if ($str_order_by == '')
			$str_order_by = 'order by kode';

		$sql          = " SELECT COUNT(*) c FROM " . $this->tbl .
			" WHERE (1=1) $str_where $filter  ";
		$qry       = $this->db->query($sql)->row(0);
		$fil_rows = $qry->c;

		$sql = " SELECT kd_propinsi||'.'||kd_dati2||'.'||kd_kecamatan||'.'||kd_kelurahan as kode, nm_kelurahan as uraian
			       FROM " . $this->tbl .
			" WHERE (1=1) $str_where $filter  
			       $str_order_by 
			       $str_limit";

		$qry = $this->db->query($sql);

		$result['sql']      = $sql;
		$result['query']      = $qry->result_array();
		$result['num_rows'] = $fil_rows;
		$result['tot_rows'] = $tot_rows['c'];
		$result['fil_rows'] = $fil_rows;

		return $result;
	}

	function get_array($kec_kd = '')
	{
		$schema_pbb = $this->schema_pbb;
		if ($kec_kd != '') {
			$where = "AND (kd_kecamatan='$kec_kd')";
		} else $where = '';

		$sql     = " SELECT * FROM " . $this->tbl .
			" WHERE (1=1) $where
					 ORDER BY kd_propinsi, kd_dati2, kd_kecamatan, kd_kelurahan";
		$qry  = $this->db->query($sql);
		if ($qry->num_rows() > 0) {
			return $qry->result_array();
		} else {
			return false;
		}
	}

	function get_nama($kd_kanwil, $kd_kantor, $kd_tp = '')
	{
		$schema_pbb = $this->schema_pbb;
		if ($kd_kanwil && $kd_kantor && $kd_tp) {
			$sql = " SELECT * FROM " . $this->tbl .
				" WHERE kd_kanwil='$kd_kanwil' 
				           and kd_kantor='$kd_kantor'
						   and kd_tp='$kd_tp'";
			$qry  = $this->db->query($sql);
			if ($qry->num_rows() > 0) {
				$result = $qry->row(0);
				return $result->nm_tp;
			} else {
				return false;
			}
		}
	}

	function get_tp_bayar_pbb()
	{

		$schema_pbb = $this->schema_pbb;
		if (DEF_POS_TYPE == 1) {
			$pos_kode = "tp.KD_KANWIL||tp.KD_KANTOR||tp.KD_TP ";
		} else {
			$pos_kode = "tp.KD_BANK_TUNGGAL||tp.KD_BANK_PERSEPSI||tp.KD_KANWIL||tp.KD_KANTOR||tp.KD_TP ";
		}

		if (is_super_admin() == false) {
			//
			$usr_login = lda_user_login();
			$sql = "select z1.* from (
	        select {$pos_kode} as kode, tp.KD_TP, tp.nm_tp 
	        from S_TEMPAT_PEMBAYARAN tp 
	        where exists(select * from V_USER_PBB ub where ub.USERID='{$usr_login}' and 
			ub.KD_KANTOR=tp.KD_KANTOR and ub.KD_KANWIL=tp.KD_KANWIL and ub.KD_TP=tp.KD_TP) 
			union all
			select '999999' as kode, '0' as KD_TP, 'Tidak Hak TP' as nm_tp from dual
			where not exists (
			select 1 as tes from S_TEMPAT_PEMBAYARAN tp 
			join V_USER_PBB ub on ub.KD_KANTOR=tp.KD_KANTOR and ub.KD_KANWIL=tp.KD_KANWIL and ub.KD_TP=tp.KD_TP
			where ub.USERID='{$usr_login}' and rownum<=1) 
	        ) z1 order by nm_tp";
		} else {
			$sql = "select z1.* from (
	        select '0' as kode, '0' as KD_TP, ' Semua TP' as nm_tp from dual union all
	        select {$pos_kode} as kode, tp.KD_TP, tp.nm_tp from S_TEMPAT_PEMBAYARAN tp 
	        ) z1 order by nm_tp";
		}
		$query = $this->db->query($sql);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}

	function get_select_tp_bayar()
	{

		$schema_pbb = $this->schema_pbb;
		if (DEF_POS_TYPE == 1) {
			$pos_kode = "tp.KD_KANWIL||tp.KD_KANTOR||tp.KD_TP ";
		} else {
			$pos_kode = "tp.KD_BANK_TUNGGAL||tp.KD_BANK_PERSEPSI||tp.KD_KANWIL||tp.KD_KANTOR||tp.KD_TP ";
		}

		$sql   = "select {$pos_kode} as kode, tp.KD_TP, tp.nm_tp from S_TEMPAT_PEMBAYARAN tp";
		$query = $this->db->query($sql);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}
}

/* End of file _model.php */