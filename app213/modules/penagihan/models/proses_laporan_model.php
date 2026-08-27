<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class proses_laporan_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function get($id)
  	{
		$sql = "SELECT * FROM DT_V_TTSPPT12D T1 
				WHERE T1.ID = {$id}";
		$query = $this->db->query($sql);
  		if($query->num_rows()!==0)
  		{
  			return $query->row();
  		}
  		else
  			return FALSE;
  	}

	function get_by_nopthn($nopthn)
  	{
		$sql = "SELECT NVL(T1.STA_VERIF, '0') AS STSVER FROM DT_V_TTSPPT12D T1 
				WHERE T1.NOP||T1.THN_PAJAK_SPPT = '{$nopthn}'";
				// echo $sql; die();
		$query = $this->db->query($sql);
  		if($query->num_rows()!==0)
  		{
  			return $query->row();
  		}
  		else
  			return FALSE;
  	}

	function get_dt_btl($nopthn)
  	{
		$sql = "SELECT * FROM BATAL_NOP 
				WHERE NOP||THN = '{$nopthn}'";
				// echo $sql; die();
		$query = $this->db->query($sql);
  		if($query->num_rows()!==0)
  		{
  			return $query->row();
  		}
  		else
  			return FALSE;
  	}

	function get_dt_komplit_by_nopthn($nopthn)
  	{
		$sql = "SELECT NVL(T1.STA_VERIF, '0') AS STSVER, KEC.NM_KECAMATAN, KEL.NM_KELURAHAN, T1.*,
				CASE WHEN T1.STATUS_BATAL_NOP = 4 THEN 'SPPT TERSAMPAIKAN'
				WHEN T1.STATUS_BATAL_NOP = 0 THEN 'DRAFT'
				ELSE BN.ALASAN END AS TXT_KETERANGAN
				FROM DT_V_TTSPPT12D T1 
				LEFT JOIN BATAL_NOP BN ON T1.NOP = BN.NOP AND T1.THN_PAJAK_SPPT = BN.THN
				JOIN REF_KECAMATAN KEC ON T1.KD_KECAMATAN = KEC.KD_KECAMATAN
				JOIN REF_KELURAHAN KEL ON T1.KD_KELURAHAN = KEL.KD_KELURAHAN and T1.KD_KECAMATAN = KEL.KD_KECAMATAN
				WHERE T1.NOP||T1.THN_PAJAK_SPPT = '{$nopthn}'";
				// echo $sql; die();
		$query = $this->db->query($sql);
  		if($query->num_rows()!==0)
  		{
  			return $query->row();
  		}
  		else
  			return FALSE;
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

    function get_select_kelurahan($kec_id)
  	{
  		$this->db->select(KD_KELURAHAN.', '.NM_KELURAHAN);
  		$this->db->where(array(KD_KECAMATAN_KEL=>$kec_id));
  		$this->db->order_by(NM_KELURAHAN);
  		$query = $this->db->get(TBL_REF_KELURAHAN);
  		if($query->num_rows()!==0)
  		{
  			return $query->result();
  		}
  		else
  			return FALSE;
        // return $this->db->last_query();
  	}


	function proses_terima($nop) {
		$nop          = urldecode($nop);
		$nop          = str_replace('.', '', $nop);
		$nop          = str_replace(' ', '', $nop);
		$nop          = str_replace('-', '', $nop);
		$nop          = preg_replace( '/[^0-9]/', '', $nop);
		$kd_prop      = substr($nop, 0, 2);
		$kd_dati2     = substr($nop, 2, 2);
		$kd_kec       = substr($nop, 4, 3);
		$kd_kel       = substr($nop, 7, 3);
		$kd_blok      = substr($nop, 10, 3);
		$no_urut      = substr($nop, 13, 4);
		$kd_jns_op    = substr($nop, 17, 1);
		$thn		  = substr($nop, 18,4);

		$usernya = $this->session->userdata('nama');

		$sql = "UPDATE TTSPPT12D SET STA_VERIF = 1, USR_VERIF = '{$usernya}', TGL_VERIF = SYSDATE
				WHERE KD_PROPINSI = '{$kd_prop}' AND KD_DATI2 = '{$kd_dati2}' AND KD_KECAMATAN = '{$kd_kec}' 
				AND KD_KELURAHAN = '{$kd_kel}' AND KD_BLOK = '{$kd_blok}' AND NO_URUT = '{$no_urut}' 
				AND KD_JNS_OP = '{$kd_jns_op}' AND THN_PAJAK_SPPT = '{$thn}'";

		if ($this->db->query($sql)) {
			return true;
		} else {
			return false;
		}
	}

	function proses_tolak($nop) {
		$nop          = urldecode($nop);
		$nop          = str_replace('.', '', $nop);
		$nop          = str_replace(' ', '', $nop);
		$nop          = str_replace('-', '', $nop);
		$nop          = preg_replace( '/[^0-9]/', '', $nop);
		$kd_prop      = substr($nop, 0, 2);
		$kd_dati2     = substr($nop, 2, 2);
		$kd_kec       = substr($nop, 4, 3);
		$kd_kel       = substr($nop, 7, 3);
		$kd_blok      = substr($nop, 10, 3);
		$no_urut      = substr($nop, 13, 4);
		$kd_jns_op    = substr($nop, 17, 1);
		$thn		  = substr($nop, 18,4);

		$usernya = $this->session->userdata('nama');

		$sql = "UPDATE TTSPPT12D SET STA_VERIF = 2, USR_VERIF = '{$usernya}', TGL_VERIF = SYSDATE
				-- LOGINNAME = NULL, TGL_TERIMA_SPPT = NULL, NAMA_PENERIMA_SPPT = NULL, FOTO_SPPT_BARU = NULL
				WHERE KD_PROPINSI = '{$kd_prop}' AND KD_DATI2 = '{$kd_dati2}' AND KD_KECAMATAN = '{$kd_kec}' 
				AND KD_KELURAHAN = '{$kd_kel}' AND KD_BLOK = '{$kd_blok}' AND NO_URUT = '{$no_urut}' 
				AND KD_JNS_OP = '{$kd_jns_op}' AND THN_PAJAK_SPPT = '{$thn}'";

		if ($this->db->query($sql)) {
			return true;
		} else {
			return false;
		}
	}


    function get_laporan($c_nop, $thn, $kel, $kec, $sts){
  		// $this->db->where(ID_DSP,$id);
  		// $query = $this->db->get(TBL_DSPSPPT);
		  // Q1.*, T1.NM_WP_SPPT AS NM_WP_SPPT


  		$sql = "SELECT * FROM DS_PERUBAHAN_OPWP Q1
                  JOIN DT_V_TTSPPT12D T1 ON T1.NOP = Q1.NOP AND T1.THN_PAJAK_SPPT = Q1.THN_PAJAK_SPPT
  				WHERE STATUS=$sts";

      if(!empty($thn)){
          $sql .= " AND Q1.THN_PAJAK_SPPT = '".$thn."' ";
      }

      if(!empty($c_nop)){
          $c_nop = trim($c_nop);
          $c_nop = strtoupper($c_nop);
          $sql .= " AND upper(Q1.NOP) like ('%".$c_nop."%') ";
      }

      if(!empty($kec)){
          $sql .= " AND trim(KD_KECAMATAN) like '%".$kec."%' ";
      }

      if(!empty($kel)){
          $sql .= " AND trim(KD_KELURAHAN) like '%".$kel."%' ";
      }

  		$query = $this->db->query($sql);
          return $query->result();

  	}


}
