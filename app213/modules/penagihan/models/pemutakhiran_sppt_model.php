<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class pemutakhiran_sppt_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function get($id)
    {
    
      $sql = "SELECT * FROM DS_PERUBAHAN_OPWP Q1
        JOIN DT_V_TTSPPT12D T1 ON T1.NOP = Q1.NOP AND T1.THN_PAJAK_SPPT = Q1.THN_PAJAK_SPPT
        WHERE Q1.ID = {$id}";
    
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
      AND KD_LOOKUP_ITEM IN ('5', '8')";
      // var_dump($sql);die;
      $query = $this->db->query($sql);
      // var_dump($query);die;
      if ($query->num_rows()!==0) {
        return $query->result();
      } else {
        return false;
      }
    }

    function get_select_id_piutang_all() {
        $sql = "SELECT KD_LOOKUP_ITEM, NM_LOOKUP_ITEM
        FROM LOOKUP_ITEM
        WHERE KD_LOOKUP_GROUP = '88'";
        // var_dump($sql);die;
        $query = $this->db->query($sql);
        // var_dump($query);die;
        if ($query->num_rows()!==0) {
          return $query->result();
        } else {
          return false;
        }
    }

    function get_laporan($c_nop, $thn, $kel, $kec, $sts){
      
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

    function get_rpt_kec($kec){
      $sql = "select kd_kecamatan, nm_kecamatan from ref_kecamatan where kd_kecamatan ='{$kec}'";
      $query = $this->db->query($sql);
      if ($query->num_rows() !== 0) {
        return $query->row();
      } else {
        return false;
      }
    }

    function get_rpt_kel($kec, $kel){
      $sql = "select kd_kelurahan, nm_kelurahan from ref_kelurahan where kd_kecamatan = '{$kec}' and kd_kelurahan = '{$kel}'";
      $query = $this->db->query($sql);
      if ($query->num_rows() !== 0) {
        return $query->row();
      } else {
        return false;
      }
    }

    function query_cetak_real($nop, $thn, $kec, $kel, $sts, $idp){

      $filter = 'WHERE 1=1';

      if(!empty($nop)){
        $filter .= " AND trim(UPPER(DS.NOP)) like ('%". $nop ."%') ";
      }

      if(!empty($thn)){
        $filter .= " AND DS.THN_PAJAK_SPPT = '". $thn ."' ";
      }

      if($kec <> '999999' && !empty($kec)){
        $filter .= " AND trim(T1.KD_KECAMATAN) = '". $kec ."' ";
      }

      if($kel <> '999999' && !empty($kel)){
        $filter .= " AND trim(T1.KD_KELURAHAN) = '". $kel ."' ";
      }

      if($sts <> '9'){
        $filter .= " AND DS.STATUS = ". $sts ." ";
      }

      if($idp <> '999999' && !empty($idp)){
        $filter .= " AND trim(T1.ID_PIUTANG) = ". $idp ." ";
      }else{
        $filter .= " AND trim(T1.ID_PIUTANG) IN (5, 8) ";
      }

      $sql = "
      SELECT T1.NOP, 
      T1.NM_WP_SPPT, 
      T1.LUAS_BUMI_SPPT, 
      TRIM(DS.JALAN_OP_OLD)||' RT '||TRIM(DS.RT_OP_OLD)||' RW '||TRIM(DS.RW_OP_OLD)||' KEC '||TRIM(DS.KECAMATAN_OP_NM_OLD)||' KEL '||TRIM(DS.KELURAHAN_OP_NM_OLD) AS SEBELUM_OP,
      TRIM(DS.JALAN_WP_OLD)||' RT '||TRIM(DS.RT_WP_OLD)||' RW '||TRIM(DS.RW_WP_OLD)||' KEC '||TRIM(DS.KECAMATAN_WP_OLD)||' KEL '||TRIM(DS.KELURAHAN_WP_NM_OLD) AS SEBELUM_WP,
      COALESCE(DS.LUAS_BNG_OLD, '-') AS LUAS_BNG_OLD,
      TRIM(DS.JALAN_OP_NEW)||' RT '||TRIM(DS.RT_OP_NEW)||' RW '||TRIM(DS.RW_OP_NEW)||' KEC '||TRIM(DS.KECAMATAN_OP_NM_NEW)||' KEL '||TRIM(DS.KELURAHAN_OP_NM_NEW) AS SESUDAH_OP,
      TRIM(DS.JALAN_WP_NEW)||' RT '||TRIM(DS.RT_WP_NEW)||' RW '||TRIM(DS.RW_WP_NEW)||' KEC '||TRIM(DS.KECAMATAN_WP_NM_NEW)||' KEL '||TRIM(DS.KELURAHAN_WP_NM_NEW) AS SESUDAH_WP,
      COALESCE(DS.LUAS_BNG_NEW, '-') as LUAS_BNG_NEW,
      CASE WHEN DS.KD_KONDISI_BNG = '2' THEN 'BAIK' WHEN DS.KD_KONDISI_BNG = '3' THEN 'SEDANG' ELSE '-' END AS KONDISI_BNG,
      CASE WHEN T1.ID_PIUTANG = '5' THEN 'SUBJEK PAJAK TIDAK SESUAI DENGAN VERLAP' WHEN T1.ID_PIUTANG = '8' THEN 'OBJEK PAJAK TIDAK SESUAI DENGAN VERLAP' ELSE '-' END AS IDENTIFIKASI,
      COALESCE(TO_CHAR(DS.TGL_APPROVED, 'DD-MM-YYYY'), '-') AS TGL_APPROVED,
      COALESCE(TRIM(T1.KETERANGAN), '-') AS KETERANGAN, T1.ID_PIUTANG
      FROM DS_PERUBAHAN_OPWP DS
      JOIN DT_V_TTSPPT12D T1 ON T1.NOP = DS.NOP AND T1.THN_PAJAK_SPPT = DS.THN_PAJAK_SPPT 
      LEFT JOIN REF_KECAMATAN KEC ON T1.KD_KECAMATAN = KEC.KD_KECAMATAN 
      LEFT JOIN REF_KELURAHAN KEL ON T1.KD_KELURAHAN = KEL.KD_KELURAHAN AND T1.KD_KECAMATAN = KEL.KD_KECAMATAN 
        {$filter}
      ";

      return $sql;
    }


}
