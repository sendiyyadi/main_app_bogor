<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class pembatalan_sppt_new_model extends CI_Model
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

    function query_cetak_real($nop, $thn, $kec, $kel, $idp){

      $filter = '';
      $thn_sppt = date('Y');

      if(!empty($nop)){
        $filter .= " AND trim(UPPER(DS.NOP)) like ('%". $nop ."%') ";
      }

      if(!empty($thn)){
        $filter .= " AND T1.THN_PAJAK_SPPT = '". $thn ."' ";

        $thn_sppt = $thn;
      }

      if($kec <> '999999' && !empty($kec)){
        $filter .= " AND trim(T1.KD_KECAMATAN) = '". $kec ."' ";
      }

      if($kel <> '999999' && !empty($kel)){
        $filter .= " AND trim(T1.KD_KELURAHAN) = '". $kel ."' ";
      }

      if($idp <> '999999' && !empty($idp)){
        $filter .= " AND trim(T1.ID_PIUTANG) = ". $idp ." ";
      }else{
        $filter .= " AND trim(T1.ID_PIUTANG) IN ('2','3','4','6','7') ";
      }

      $sql = "
      SELECT 
        T1.KD_PROPINSI||T1.KD_DATI2||T1.KD_KECAMATAN||T1.KD_KELURAHAN|| T1.KD_BLOK||T1.NO_URUT||T1.KD_JNS_OP AS NOP,
        T1.NM_WP_SPPT,
        T1.LUAS_BUMI_SPPT,
        T1.LUAS_BNG_SPPT,
        TRIM(T1.JLN_WP_SPPT)||' '||TRIM(T1.BLOK_KAV_NO_WP_SPPT)||' RT '||TRIM(T1.RT_WP_SPPT)||' RW '||TRIM(T1.RW_WP_SPPT)||' KEL '||TRIM(T1.KELURAHAN_WP_SPPT)||' KOTA '||TRIM(T1.KOTA_WP_SPPT)||' '||TRIM(T1.KD_POS_WP_SPPT) AS ALAMAT_WP,
        TRIM(DOP.JALAN_OP)||' '||TRIM(DOP.BLOK_KAV_NO_OP)||' '||TRIM(DOP.RT_OP)||' '||TRIM(DOP.RW_OP) AS ALAMAT_OP,
        CASE 
            WHEN T1.ID_PIUTANG = 2 THEN 'Objek Pajak tidak ada'
            WHEN T1.ID_PIUTANG = 3 THEN 'SPPT Double'
            WHEN T1.ID_PIUTANG = 4 THEN 'Tidak Jelas / Nama atau Alamat Subjek Pajak'
            WHEN T1.ID_PIUTANG = 6 THEN 'Objek Pajak Di kecualikan'
            WHEN T1.ID_PIUTANG = 7 THEN 'Objek Pajak Bermasalah / Sengketa'
            ELSE 'Draft'
        END AS IDENTIFIKASI,
        COALESCE(TO_CHAR(T1.TGL_SERAH, 'DD-MM-YYYY'), '-') AS TGL_APPROVED,
        COALESCE(TRIM(T1.KETERANGAN), '-') AS KETERANGAN,
        T1.ID_PIUTANG,
        S.SISA AS PIUTANG_THN_BERJALAN, SA.SISA AS TTL_PIUTANG
      FROM TTSPPT12D T1
      LEFT JOIN DAT_OBJEK_PAJAK DOP ON
        T1.KD_PROPINSI = DOP.KD_PROPINSI AND
        T1.KD_DATI2 = DOP.KD_DATI2 AND 
        T1.KD_KECAMATAN = DOP.KD_KECAMATAN AND 
        T1.KD_KELURAHAN = DOP.KD_KELURAHAN AND
        T1.KD_BLOK = DOP.KD_BLOK AND 
        T1.NO_URUT = DOP.NO_URUT AND
        T1.KD_JNS_OP = DOP.KD_JNS_OP
      LEFT JOIN (
        SELECT A.KD_PROPINSI, A.KD_DATI2, A.KD_KECAMATAN, A.KD_KELURAHAN, A.KD_BLOK, A.NO_URUT, A.KD_JNS_OP, A.THN_PAJAK_SPPT, 
        CASE WHEN (A.PBB_YG_HARUS_DIBAYAR_SPPT - (NVL(B.BAYAR,0)-NVL(B.BYR_DENDA,0))) < 0 THEN 0 ELSE (A.PBB_YG_HARUS_DIBAYAR_SPPT - (NVL(B.BAYAR,0)-NVL(B.BYR_DENDA,0))) END AS SISA
        FROM SPPT A 
        LEFT JOIN vsumpay B on
            A.kd_propinsi       = B.kd_propinsi AND
            A.kd_dati2          = B.kd_dati2 AND
            A.kd_kecamatan      = B.kd_kecamatan AND
            A.kd_kelurahan      = B.kd_kelurahan AND
            A.kd_blok           = B.kd_blok AND
            A.no_urut           = B.no_urut AND
            A.kd_jns_op         = B.kd_jns_op AND
            A.thn_pajak_sppt    = B.thn_pajak_sppt
      ) S ON
        T1.KD_PROPINSI = S.KD_PROPINSI AND
        T1.KD_DATI2 = S.KD_DATI2 AND 
        T1.KD_KECAMATAN = S.KD_KECAMATAN AND 
        T1.KD_KELURAHAN = S.KD_KELURAHAN AND
        T1.KD_BLOK = S.KD_BLOK AND 
        T1.NO_URUT = S.NO_URUT AND
        T1.KD_JNS_OP = S.KD_JNS_OP AND
        T1.THN_PAJAK_SPPT = S.THN_PAJAK_SPPT AND S.THN_PAJAK_SPPT = '{$thn_sppt}'
      LEFT JOIN ( SELECT KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP, SUM(SISA) AS SISA FROM (
            SELECT A.KD_PROPINSI, A.KD_DATI2, A.KD_KECAMATAN, A.KD_KELURAHAN, A.KD_BLOK, A.NO_URUT, A.KD_JNS_OP, A.THN_PAJAK_SPPT, 
            CASE WHEN (A.PBB_YG_HARUS_DIBAYAR_SPPT - (NVL(B.BAYAR,0)-NVL(B.BYR_DENDA,0))) < 0 THEN 0 ELSE (A.PBB_YG_HARUS_DIBAYAR_SPPT - (NVL(B.BAYAR,0)-NVL(B.BYR_DENDA,0))) END AS SISA
            FROM SPPT A 
            LEFT JOIN vsumpay B on
                A.kd_propinsi       = B.kd_propinsi AND
                A.kd_dati2          = B.kd_dati2 AND
                A.kd_kecamatan      = B.kd_kecamatan AND
                A.kd_kelurahan      = B.kd_kelurahan AND
                A.kd_blok           = B.kd_blok AND
                A.no_urut           = B.no_urut AND
                A.kd_jns_op         = B.kd_jns_op and
                A.thn_pajak_sppt    = B.thn_pajak_sppt
            ) XX
            GROUP BY KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP
      ) SA ON
        T1.KD_PROPINSI = SA.KD_PROPINSI AND
        T1.KD_DATI2 = SA.KD_DATI2 AND 
        T1.KD_KECAMATAN = SA.KD_KECAMATAN AND 
        T1.KD_KELURAHAN = SA.KD_KELURAHAN AND
        T1.KD_BLOK = SA.KD_BLOK AND 
        T1.NO_URUT = SA.NO_URUT AND
        T1.KD_JNS_OP = SA.KD_JNS_OP
      WHERE T1.STATUS IS NULL
        {$filter}
      ";

      return $sql;
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

    function select_row_tmp_prs_sim($flag, $proses_id, $nop, $thn) {
        // select check or unchek
        $nop     = str_replace(".", "", $nop);
        $nop     = str_replace("-", "", $nop);

        $kd_propinsi    = substr($nop, 0, 2);
        $kd_dati2       = substr($nop, 2, 2);
        $kd_kecamatan   = substr($nop, 4, 3);
        $kd_kelurahan   = substr($nop, 7, 3);
        $kd_blok        = substr($nop, 10, 3);
        $no_urut        = substr($nop, 13, 4);
        $kd_jns_op      = substr($nop, 17, 1);

        if ($flag == 1) {
            $sql = "INSERT INTO TMP_TTSPPT_SIM (PROSES_ID, KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP, THN_PAJAK_SPPT)
                    SELECT " . $proses_id . ", '" . $kd_propinsi . "', '" . $kd_dati2 . "', '" . $kd_kecamatan . "', '" . $kd_kelurahan . "', '" . $kd_blok . "', '" . $no_urut . "', '" . $kd_jns_op . "', '".$thn."'
                    FROM DUAL ";
        } else {
            $sql = "DELETE FROM TMP_TTSPPT_SIM WHERE PROSES_ID = " . $proses_id . " AND KD_PROPINSI = '" . $kd_propinsi . "' AND KD_DATI2 = '" . $kd_dati2 . "' 
                    AND KD_KECAMATAN = '" . $kd_kecamatan . "' AND KD_KELURAHAN = '" . $kd_kelurahan . "' AND KD_BLOK = '" . $kd_blok . "' AND NO_URUT = '" . $no_urut . "'
                    AND KD_JNS_OP = '" . $kd_jns_op . "' AND THN_PAJAK_SPPT = '".$thn."'  ";
        }
        $query = $this->db->query($sql);
    }

    function select_prs_pdt_mobile_all($pros_id, $nop, $thn, $kec, $kel, $idp) {

        $sql    = "DELETE FROM TMP_TTSPPT_SIM TMP WHERE TMP.PROSES_ID = " . $pros_id;
        $query  = $this->db->query($sql);

        $sql  = "INSERT INTO TMP_TTSPPT_SIM (KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP, THN_PAJAK_SPPT, PROSES_ID)  ";
        $sql .= " SELECT DISTINCT T1.KD_PROPINSI, T1.KD_DATI2, T1.KD_KECAMATAN, T1.KD_KELURAHAN, T1.KD_BLOK, T1.NO_URUT, T1.KD_JNS_OP, T1.THN_PAJAK_SPPT, ";
        $sql .= $pros_id;
        $sql .= " FROM TTSPPT12D T1 
                JOIN REF_KECAMATAN KEC ON T1.KD_KECAMATAN = KEC.KD_KECAMATAN
                JOIN REF_KELURAHAN KEL ON T1.KD_KELURAHAN = KEL.KD_KELURAHAN and T1.KD_KECAMATAN = KEL.KD_KECAMATAN
                WHERE T1.STATUS IS NULL";

        if(!empty($nop)) {
            $nop = trim($nop);
            $nop = strtoupper($nop);
            $nop = str_replace('.', '', $nop);
            $nop = str_replace(' ', '', $nop);
            $nop = str_replace('-', '', $nop);

            $sql .= " AND T1.KD_PROPINSI||T1.KD_DATI2||T1.KD_KECAMATAN||T1.KD_KELURAHAN||T1.KD_BLOK||T1.NO_URUT||T1.KD_JNS_OP like ('%".$nop."%') ";
        }

        if(!empty($thn)){
            $sql .= " AND trim(T1.THN_PAJAK_SPPT) = '".$thn."' ";
        }

        if($kec <> '999999' && !empty($kec)){
          $sql .= " AND trim(T1.KD_KECAMATAN) = '".$kec."' ";
        }

        if($kel <> '999999' && !empty($kec)){
          $sql .= " AND trim(T1.KD_KELURAHAN) = '".$kel."' ";
        }

        if($idp <> '999999' && !empty($idp)){
          $sql .= " AND trim(T1.ID_PIUTANG) = '".$idp."'";
        }else{
          $sql .= " AND trim(T1.ID_PIUTANG) IN ('2','3','4','6','7')";
        }

        // echo $sql;
        // echo '--------------';

        //log_message('info', "KKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK".$sql);
        $query = $this->db->query($sql);
        // var_dump($query);die;
    }

    function reset_cetak_pdt_mobile_all($proses_id) {
        $sql = "DELETE FROM TMP_TTSPPT_SIM TMP WHERE TMP.PROSES_ID = " . $proses_id;
        $query = $this->db->query($sql);
    }


}
