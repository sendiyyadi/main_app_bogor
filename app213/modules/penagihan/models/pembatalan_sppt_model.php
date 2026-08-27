<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class pembatalan_sppt_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function get($id)
  	{
  		// $this->db->where(ID_DSP,$id);
  		// $query = $this->db->get(TBL_DSPSPPT);
		// Q1.*, T1.NM_WP_SPPT AS NM_WP_SPPT
		$sql = "SELECT * FROM DS_PERUBAHAN_OPWP Q1
				JOIN DT_V_TTSPPT12D T1 ON T1.NOP = Q1.NOP AND T1.THN_PAJAK_SPPT = Q1.THN_PAJAK_SPPT
				WHERE Q1.ID = {$id}";
		// echo $sql; die();
		$query = $this->db->query($sql);
  		if($query->num_rows()!==0)
  		{
  			return $query->row();
			//   echo json_encode($query->row()); die();
  		}
  		else
  			return FALSE;
  	}

    function get_dt_komplit_by_nopthn_real($nopthn)
    {
    $sql = "SELECT NVL(T1.STA_VERIF, '0') AS STSVER, KEC.NM_KECAMATAN, KEL.NM_KELURAHAN, T1.*, LM.NM_LOOKUP_ITEM,
        CASE WHEN T1.STATUS_BATAL_NOP = 4 THEN 'SPPT TERSAMPAIKAN'
        WHEN T1.STATUS_BATAL_NOP = 0 THEN 'DRAFT'
        ELSE BN.ALASAN END AS TXT_KETERANGAN
        FROM TTSPPT12D T1
        LEFT JOIN BATAL_NOP BN ON T1.KD_PROPINSI = BN.KD_PROPINSI AND T1.KD_DATI2 = BN.KD_DATI2 AND T1.KD_KECAMATAN = BN.KD_KECAMATAN AND T1.KD_KELURAHAN   = BN.KD_KELURAHAN AND T1.KD_BLOK = BN.KD_BLOK AND T1.NO_URUT = BN.NO_URUT AND T1.KD_JNS_OP = BN.KD_JNS_OP AND T1.THN_PAJAK_SPPT = BN.THN
        LEFT JOIN LOOKUP_ITEM LM ON T1.ID_PIUTANG = LM.KD_LOOKUP_ITEM AND LM.KD_LOOKUP_GROUP = '88'
        JOIN REF_KECAMATAN KEC ON T1.KD_KECAMATAN = KEC.KD_KECAMATAN
        JOIN REF_KELURAHAN KEL ON T1.KD_KELURAHAN = KEL.KD_KELURAHAN and T1.KD_KECAMATAN = KEL.KD_KECAMATAN
        WHERE T1.KD_PROPINSI||T1.KD_DATI2||T1.KD_KECAMATAN||T1.KD_KELURAHAN||T1.KD_BLOK||T1.NO_URUT||T1.KD_JNS_OP||T1.THN_PAJAK_SPPT = '{$nopthn}'";
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

    function get_select_id_piutang()
    {
      $sql = "SELECT KD_LOOKUP_ITEM, NM_LOOKUP_ITEM
      FROM LOOKUP_ITEM
      WHERE KD_LOOKUP_GROUP = '88'
      AND KD_LOOKUP_ITEM IN ('2', '3', '4', '6', '7')";
      // var_dump($sql);die;
      $query = $this->db->query($sql);
      // var_dump($query);die;
      if ($query->num_rows()!==0) {
        return $query->result();
      } else {
        return false;
      }
    }

    function update($id, $data) {
  		$this->db->where('ID', $id);
  		if ($this->db->update('DS_PERUBAHAN_OPWP',$data)) {
          return true;
  		//   echo $this->db->last_query(); die();
  		} else {
  		  return false;
  		//   echo $this->db->last_query(); die();
  		}
  	}

    function process_tolak($id) {
  		$usernya = $this->session->userdata('nama');
  		$sql = "UPDATE DS_PERUBAHAN_OPWP SET STATUS=2, APPROVED_BY='{$usernya}', TGL_APPROVED=SYSDATE
  				WHERE ID = {$id}";

  		if ($this->db->query($sql)) {
  			return true;
  		} else {
  			return false;
  		}
  	}

  	function update_manuwal($id) {
  		$usernya = $this->session->userdata('nama');
  		$sql = "UPDATE DS_PERUBAHAN_OPWP SET STATUS=1, APPROVED_BY='{$usernya}', TGL_APPROVED=SYSDATE
  				WHERE ID = {$id}";

  		if ($this->db->query($sql)) {
  			return true;
  		//   echo $this->db->last_query(); die();
  		} else {
  			return false;
  		//   echo $this->db->last_query(); die();
  		}
  	}

    function update_status($nop, $thn) {
      $sql = "UPDATE TTSPPT12D SET STATUS=1 WHERE KD_PROPINSI||KD_DATI2||KD_KECAMATAN||KD_KELURAHAN||KD_BLOK||NO_URUT||KD_JNS_OP = {$nop} AND THN_PAJAK_SPPT = {$thn}";

      if ($this->db->query($sql)) {
        return true;
      //   echo $this->db->last_query(); die();
      } else {
        return false;
      //   echo $this->db->last_query(); die();
      }
    }


  	function update_dsp($nop, $data) {
  		$this->db->where('SUBJEK_PAJAK_ID', $nop);
  		if ($this->db->update('DAT_SUBJEK_PAJAK',$data)) {
  			return true;
  		} else {
  			return false;
  		}
  	}

  	function update_dop($nop, $data) {
  		$this->db->where('SUBJEK_PAJAK_ID', $nop);
  		if ($this->db->update('DAT_OBJEK_PAJAK',$data)) {
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

    function gambar($nop, $thn){
      $sql = "SELECT T.FOTO_PEMBETULAN FROM TTSPPT12D T JOIN DS_PERUBAHAN_OPWP D ON T.KD_PROPINSI||T.KD_DATI2||T.KD_KECAMATAN||T.KD_KELURAHAN||T.KD_BLOK||T.NO_URUT||T.KD_JNS_OP = D.NOP AND T.THN_PAJAK_SPPT = D.THN_PAJAK_SPPT WHERE T.KD_PROPINSI||T.KD_DATI2||T.KD_KECAMATAN||T.KD_KELURAHAN||T.KD_BLOK||T.NO_URUT||T.KD_JNS_OP = $nop AND T.THN_PAJAK_SPPT = $thn";

      if ($this->db->query($sql)) {
        return true;
      } else {
        return false;
      }
    }

    function load_gambar($nop, $thn){
      $sql = "SELECT T.FOTO_PEMBETULAN FROM TTSPPT12D T JOIN DS_PERUBAHAN_OPWP D ON T.KD_PROPINSI||T.KD_DATI2||T.KD_KECAMATAN||T.KD_KELURAHAN||T.KD_BLOK||T.NO_URUT||T.KD_JNS_OP = D.NOP AND T.THN_PAJAK_SPPT = D.THN_PAJAK_SPPT WHERE T.KD_PROPINSI||T.KD_DATI2||T.KD_KECAMATAN||T.KD_KELURAHAN||T.KD_BLOK||T.NO_URUT||T.KD_JNS_OP = $nop AND T.THN_PAJAK_SPPT = $thn";
      // var_dump($sql);die;

      $aa = $this->db->query($sql);
      // var_dump($aa);die;
      if ($aa->num_rows() !== 0) {
        return $aa->row();
      } else {
        return false;
      }
    }


}
