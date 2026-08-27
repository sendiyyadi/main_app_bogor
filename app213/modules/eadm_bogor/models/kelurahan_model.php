<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class kelurahan_model extends CI_Model {
	private $tbl = 'REF_KELURAHAN';

	function __construct() {
		parent::__construct();
	}

	function get_all() {
        $sql = "select kel.KD_PROPINSI, kel.KD_DATI2, kel.KD_KECAMATAN, kel.KD_KELURAHAN, kel.NM_KELURAHAN
            from REF_KELURAHAN kel
            inner join REF_KECAMATAN KEC ON KEL.KD_KECAMATAN = KEC.KD_KECAMATAN AND KEL.KD_DATI2 = KEC.KD_DATI2 AND KEL.KD_PROPINSI = KEC.KD_PROPINSI
            where prop.id=? and kab.id=?
            order by NM_KECAMATAN, NM_KELURAHAN";

		$query = $this->db->query($sql, array(pad_KD_PROPINSI(), pad_KD_DATI2()));
		if($query->num_rows()!==0) {
			return $query->result();
		}
		else
			return FALSE;
	}

    function get_select($kec_id)
    {
        $sql = "select kel.KD_PROPINSI, kel.KD_DATI2, kel.KD_KECAMATAN, kel.KD_KELURAHAN, kel.NM_KELURAHAN
            from REF_KELURAHAN kel
            inner join REF_KECAMATAN kec on KEL.KD_KECAMATAN = KEC.KD_KECAMATAN AND KEL.KD_DATI2 = KEC.KD_DATI2 AND KEL.KD_PROPINSI = KEC.KD_PROPINSI
            where kel.KD_KECAMATAN=?
            order by NM_KECAMATAN, NM_KELURAHAN";
        $query = $this->db->query($sql, array($kec_id));
        if($query->num_rows()!==0)
        {
            return $query->result();
        }
        else
            return FALSE;
    }

    function get_select_kel_pemda($kec_id)
    {
        $sql = "select kel.KD_PROPINSI, kel.KD_DATI2, kel.KD_KECAMATAN, kel.KD_KELURAHAN, kel.NM_KELURAHAN
        from REF_KELURAHAN kel
        inner join REF_KECAMATAN kec on KEL.KD_KECAMATAN = KEC.KD_KECAMATAN AND KEL.KD_DATI2 = KEC.KD_DATI2 AND KEL.KD_PROPINSI = KEC.KD_PROPINSI
        where kel.KD_KECAMATAN=?
        order by NM_KECAMATAN, NM_KELURAHAN";
        $query = $this->db->query($sql, array($kec_id));
        if($query->num_rows()!==0)
        {
            return $query->result();
        }
        else
            return FALSE;
    }

	function cek_uniq_key($id, $kelurahankd, $kec_id) {

		$qry  = " select kel.id, 1 as ada from tblkelurahan kel
							where kel.id != {$id} and kel.KD_KECAMATAN=$kec_id
							and lower(trim(kel.KD_KELURAHAN))=lower(trim('{$kelurahankd}'))
							limit 1 ";
		//log_message('info', "KKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK  ". $qry);
        $query = $this->db->query($qry);
        if($query->num_rows()!==0) {return TRUE; }
				else { return FALSE; }
	}

	function get($id) {
		$qry = "SELECT ROWIDTOCHAR(KL.ROWID) AS ID, KL.*
		FROM REF_KELURAHAN KL
		WHERE KL.ROWID = '{$id}' ";
		//log_message('info', "KKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK  ". $qry);
        $query = $this->db->query($qry);
		if($query->num_rows()!==0) {
			return $query->row();
		}
		else
			return FALSE;
	}

	function insert_data($data) {
		// insert  data ok
		$result = $this->db->insert_oen_pgs($this->tbl, $data);
		return $result;
	}

	function update_data($kec, $kel, $data) {
		// $this->db->where('id', $id);
		$this->db->where('KD_PROPINSI', pad_propinsi_id());
		$this->db->where('KD_DATI2', pad_kabupaten_id());
		$this->db->where('KD_KECAMATAN', $kec);
		$this->db->where('KD_KELURAHAN', $kel);
		$result = $this->db->update_oen_pgs($this->tbl, $data);
		return $result;
	}

	function delete_data($kec, $kel) {
		//
		// $this->db->where('id', $id);
		$this->db->where('KD_PROPINSI', pad_propinsi_id());
		$this->db->where('KD_DATI2', pad_kabupaten_id());
		$this->db->where('KD_KECAMATAN', $kec);
		$this->db->where('KD_KELURAHAN', $kel);
		$result = $this->db->delete_oen_pgs($this->tbl);
		//log_message('info', "kkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkk : " . $result);
		return $result;
	}

	//-- admin
	function save($data) {
		$this->db->insert($this->tbl,$data);
		return $this->db->insert_id();
	}

	function update($id, $data) {
		$this->db->where('id', $id);
		$this->db->update($this->tbl,$data);
	}

	function delete($id) {
		$this->db->where('id', $id);
		$this->db->delete($this->tbl);
	}
}

/* End of file _model.php */
