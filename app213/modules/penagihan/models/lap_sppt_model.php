<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class lap_sppt_model extends CI_Model
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

  	function get_dt_komplit_by_nopthn_real($nopthn)
  	{
		$sql = "SELECT NVL(T1.STA_VERIF, '0') AS STSVER, KEC.NM_KECAMATAN, KEL.NM_KELURAHAN, T1.*, RL.NM_REF_LISTRIK, LM.NM_LOOKUP_ITEM,
				CASE WHEN T1.STATUS_BATAL_NOP = 4 THEN 'SPPT TERSAMPAIKAN'
				WHEN T1.STATUS_BATAL_NOP = 0 THEN 'DRAFT'
				ELSE BN.ALASAN END AS TXT_KETERANGAN,
				TRIM(T1.NAMA_PENERIMA_SPPT) AS NAMA_PENERIMA_SPPT,
				CASE WHEN T1.STATUS_PENERIMA = 1 THEN 'WAJIB PAJAK (PEMILIK)' WHEN T1.STATUS_PENERIMA = 2 THEN 'KUASA WAJIB PAJAK (KELUARGA / PENGELOLA)' WHEN T1.STATUS_PENERIMA = 3 THEN 'LAINNYA...' ELSE '' END AS STATUS_PENERIMA
				FROM TTSPPT12D T1
        LEFT JOIN BATAL_NOP BN ON T1.KD_PROPINSI = BN.KD_PROPINSI AND T1.KD_DATI2 = BN.KD_DATI2 AND T1.KD_KECAMATAN = BN.KD_KECAMATAN AND T1.KD_KELURAHAN   = BN.KD_KELURAHAN AND T1.KD_BLOK = BN.KD_BLOK AND T1.NO_URUT = BN.NO_URUT AND T1.KD_JNS_OP = BN.KD_JNS_OP AND T1.THN_PAJAK_SPPT = BN.THN
        LEFT JOIN REF_LISTRIK RL ON T1.ID_LISTRIK = RL.KD_REF_LISTRIK
		LEFT JOIN LOOKUP_ITEM LM ON RL.KD_LOOKUPGROUP = LM.KD_LOOKUP_GROUP AND RL.KD_LOOKUP_ITEM = LM.KD_LOOKUP_ITEM
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

    function query_cetak_real($kd_kec, $kd_kel, $c_thn, $c_nop){

      $filter = '';
      if($kd_kec != 999999){
        $filter .= " AND tt.kd_kecamatan = '". $kd_kec ."' ";
      }
      if($kd_kel != 999999){
        $filter .= " AND tt.kd_kelurahan = '". $kd_kel ."' ";
      }
      if($c_thn != 0){
        $filter .= " AND tt.thn_pajak_sppt = '". $c_thn ."' ";
      }
      if($c_nop != 0){
        $filter .= " AND tt.kd_propinsi||tt.kd_dati2||tt.kd_kecamatan||tt.kd_kelurahan||tt.kd_blok||tt.no_urut||tt.kd_jns_op = '". $c_nop ."' ";
      }

//       <!--  tt.kd_kecamatan
// tt.kd_kelurahan
// tt.kd_blok
// tt.no_urut
// tt.kd_jns_op
// ds.nm_wp
// kel.nm_kelurahan
// kec.nm_kecamatan
// do.jalan_op + do.blok_kav_no_op + do.rw_op + do.rt_op
// do.total_luas_bumi
// do.total_luas_bng
// tt.pbb_yg_harus_dibayar_sppt
// tt.id_piutang
// li.nm_lookup_item -->

      $sql = "select
    ROW_NUMBER() OVER (ORDER BY tt.kd_kecamatan, tt.kd_kelurahan, tt.kd_blok, tt.no_urut, tt.kd_jns_op) AS nomor,
    tt.kd_kecamatan,
    tt.kd_kelurahan,
    tt.kd_blok,
    tt.no_urut,
    tt.kd_jns_op,
    ds.nm_wp,
    kel.nm_kelurahan,
    kec.nm_kecamatan,
    do.jalan_op,
    nvl(do.blok_kav_no_op, '-') as blok_kav_no_op,
    do.rw_op,
    do.rt_op,
    do.total_luas_bumi,
    do.total_luas_bng,
    tt.pbb_yg_harus_dibayar_sppt,
    tt.id_piutang,
    li.nm_lookup_item
from ttsppt12d tt
join dat_objek_pajak do
    on tt.kd_propinsi = do.kd_propinsi
    and tt.kd_dati2 = do.kd_dati2
    and tt.kd_kecamatan = do.kd_kecamatan
    and tt.kd_kelurahan = do.kd_kelurahan
    and tt.kd_blok = do.kd_blok
    and tt.no_urut = do.no_urut
    and tt.kd_jns_op = do.kd_jns_op
join dat_subjek_pajak ds
    on do.subjek_pajak_id = ds.subjek_pajak_id
left join lookup_item li
    on tt.id_piutang = li.kd_lookup_item
    and li.kd_lookup_group = '88'
join ref_kecamatan kec
    ON tt.kd_kecamatan = kec.kd_kecamatan
join ref_kelurahan kel 
    ON tt.kd_kelurahan = kel.kd_kelurahan 
    AND tt.kd_kecamatan = kel.kd_kecamatan
where tt.tgl_terima_sppt IS NOT NULL
    and tt.loginname IS NOT NULL
    and tt.id_piutang = 1
    {$filter}";

    return $sql;

    }
}
