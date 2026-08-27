<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class dafnom_model extends CI_Model
{
	public function __construct()
    {
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

  	// function get_k($nop, $tahun, $kec, $kel)
  	// {
  	// 	// $this->db->select();
  	// 	$this->load->library('Datatables');
   //        $this->datatables->select("
   //        DOP.KD_PROPINSI || DOP.KD_DATI2 || DOP.KD_KECAMATAN || DOP.KD_KELURAHAN || DOP.KD_BLOK || DOP.NO_URUT || DOP.KD_JNS_OP AS NOP,
   //        DOP.THN_PEMBENTUKAN AS TAHUN,
   //        DAS.NM_WP AS NAMA_WP,
   //        DOP.JALAN_OP || ', ' || DOP.BLOK_KAV_NO_OP || ', RW ' || DOP.RW_OP || ', RT ' || DOP.RT_OP AS ALAMAT_OP,
   //        LM1.NM_LOOKUP_ITEM AS JENIS_BUMI,
   //        RJ.NM_JPB AS JPB_BANGUNAN,
   //        LM2.NM_LOOKUP_ITEM AS STATUS_WP,
   //        DOP.KATEGORI_OP AS KATEGORI_OP,
   //        DOP.KETERANGAN AS KETERANGAN,
   //        DOP.TGL_PEMBENTUKAN AS TGL_PEMBUATAN,
   //        DOP.NIP_PEMBENTUK AS NIP_PEREKAM", false);
   //    $this->datatables->from('DAFNOM_OP DOP', false);
   //    $this->datatables->join("DAT_OBJEK_PAJAK DAP", "DOP.KD_PROPINSI = DAP.KD_PROPINSI AND DOP.KD_DATI2 = DAP.KD_DATI2 AND DOP.KD_KECAMATAN = DAP.KD_KECAMATAN AND DOP.KD_KELURAHAN = DAP.KD_KELURAHAN AND DOP.KD_BLOK = DAP.KD_BLOK AND DOP.NO_URUT = DAP.NO_URUT AND DOP.KD_JNS_OP = DAP.KD_JNS_OP", 'left');
   //    $this->datatables->join("DAT_SUBJEK_PAJAK DAS", "DAP.SUBJEK_PAJAK_ID = DAS.SUBJEK_PAJAK_ID", 'left');

   //    $this->datatables->join("LOOKUP_ITEM LM1", "DOP.JNS_BUMI = LM1.KD_LOOKUP_ITEM AND LM1.KD_LOOKUP_GROUP = '$one'", 'left');
   //    $this->datatables->join("LOOKUP_ITEM LM2", "DOP.KD_STATUS_WP = LM2.KD_LOOKUP_ITEM AND LM2.KD_LOOKUP_GROUP = '$two'", 'left');
   //    $this->datatables->join('REF_JPB RJ', 'DOP.KD_JPB = RJ.KD_JPB', 'left', false);
  	// }

  	function query_cetak($kd_kec, $kd_kel, $c_thn, $nop){
  		$filter = '';
  		if($kd_kec != 999999){
            $filter .= " AND OP.KD_KECAMATAN = '". $kd_kec ."' ";
        }

        if($kd_kel != 999999){
            $filter .= " AND OP.KD_KELURAHAN = '". $kd_kel ."' ";
        }

        if(!empty($c_thn)){
            $filter .= " AND OP.THN_PEMBENTUKAN = '". $c_thn ."' ";
        }

        if(!empty($nop)){
            $filter .= " AND OP.KD_PROPINSI||OP.KD_DATI2||OP.KD_KECAMATAN||OP.KD_KELURAHAN||OP.KD_BLOK||OP.NO_URUT||OP.KD_JNS_OP = '". $nop ."' ";
        }

  		$sql = "SELECT OP.*, CASE
    WHEN OP.KATEGORI_OP = '1' THEN 'Tidak ada Objek'
    WHEN OP.KATEGORI_OP = '2' THEN 'Double'
    WHEN OP.KATEGORI_OP = '3' THEN 'Tidak ada Subjek'
    WHEN OP.KATEGORI_OP = '4' THEN 'Normal'
    ELSE '-' END AS KATEGORI_OPP,
    KEC.NM_KECAMATAN,
    KEL.NM_KELURAHAN,
    ROW_NUMBER() OVER (ORDER BY OP.KD_KECAMATAN, OP.KD_KELURAHAN, OP.KD_BLOK, OP.NO_URUT, OP.KD_JNS_OP, OP.THN_PEMBENTUKAN) AS NOMOR,
    FMT_TGL_TEKS(OP.TGL_PEMBENTUKAN) AS TGL_PEMBENTUKANN,
    FMT_TGL_TEKS(OP.TGL_PEMUTAKHIRAN) AS TGL_PEMUTAKHIRANN
    FROM DAFNOM_OP OP
    JOIN REF_KECAMATAN KEC ON OP.KD_KECAMATAN = KEC.KD_KECAMATAN
    JOIN REF_KELURAHAN KEL ON OP.KD_KECAMATAN = KEL.KD_KECAMATAN AND OP.KD_KELURAHAN = KEL.KD_KELURAHAN
    WHERE 1=1 
    {$filter}";

    return $sql;

  	}
}
