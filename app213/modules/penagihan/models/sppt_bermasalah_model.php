<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class sppt_bermasalah_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function get($id)
  	{
  		$this->db->where(ID_BN,$id);
  		$query = $this->db->get(TBL_BATALNOP);
  		if($query->num_rows()!==0)
  		{
  			return $query->row();
  		}
  		else
  			return FALSE;
  	}


    function approve($id, $user_id) {
        $sql = "UPDATE ".TBL_BATALNOP." set ".APPROVED_BN." = 1, ".UPDATED_DATE_BN."=SYSTIMESTAMP, ".APPROVED_BY_BN."='".$user_id."' where ".ID_BN."=".$id." ";
        $query = $this->db->query($sql);
        if($query) return true;
        else return false;
    }

    function tolak($id, $user_id) {
        $sql = "UPDATE ".TBL_BATALNOP." set ".APPROVED_BN." = 2, ".UPDATED_DATE_BN."=SYSTIMESTAMP, ".APPROVED_BY_BN."='".$user_id."' where ".ID_BN."=".$id." ";
        $query = $this->db->query($sql);
        if($query) return true;
        else return false;
    }

    function batal($id, $user_id) {
        $sql = "UPDATE ".TBL_BATALNOP." set ".APPROVED_BN." = 0, ".UPDATED_DATE_BN."=SYSTIMESTAMP, ".APPROVED_BY_BN."='".$user_id."' where ".ID_BN."=".$id." ";
        $query = $this->db->query($sql);
        if($query) return true;
        else return false;
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
      // echo $this->db->last_query();
  		if($query->num_rows()!==0)
  		{
  			return $query->result();
  		}
  		else
  			return FALSE;
        // return $this->db->last_query();
  	}

    function get_detail($nop, $thn, $kec, $kel)
  	{
        $nop          = urldecode($nop);
		$nop          = str_replace('.', '', $nop);
		$nop          = str_replace(' ', '', $nop);
		$nop          = str_replace('-', '', $nop);
		$nop          = preg_replace( '/[^0-9]/', '', $nop);
  		//   $sql = "SELECT * FROM DT_V_TTSPPT12D T1
  		// 		    WHERE T1.NOP = '{$nop}'
        //       AND T1.THN_PAJAK_SPPT = '{$thn}'
        //       AND T1.KD_KECAMATAN = '{$kec}'
        //       AND T1.KD_KELURAHAN = '{$kel}' ";

		$sql = "SELECT * FROM DT_V_TTSPPT12D T1
				WHERE T1.NOP = '{$nop}'
				AND T1.THN_PAJAK_SPPT = '{$thn}' ";
    		// echo $sql; die();
    		$query = $this->db->query($sql);
    		if($query->num_rows()!==0){
    			return $query->row();
  			//   echo json_encode($query->row()); die();
    		}
    		else
    			return FALSE;
  	}

}
