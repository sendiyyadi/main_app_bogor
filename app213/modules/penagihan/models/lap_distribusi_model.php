<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class lap_distribusi_model extends CI_Model
{
    

    public function __construct()
    {
        parent::__construct();
    }

    function get_select_prd_pbb()
    {
        // $sql = "select thn_prd from sipkd_closed z1 where z1.sts='C' order by thn_prd desc";
        $sql = "select thn_prd from sipkd_closed z1 order by thn_prd desc";
        $query = $this->db->query($sql);
        if ($query->num_rows() !== 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    function get_select_kec_pbb()
    {
        $sql = "SELECT KD_KECAMATAN, NM_KECAMATAN FROM REF_KECAMATAN order by NM_KECAMATAN";
        $query = $this->db->query($sql);
        if ($query->num_rows() !== 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }
    function cek_prd($thn)
    {
        $sql = "select sts from sipkd_closed z1 where thn_prd='{$thn}' order by thn_prd desc";
        $query = $this->db->query($sql);
        if ($query->num_rows() !== 0) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    function get_select_kel_pbb($kec)
    {
        if (empty($kec)) {
            $kec = "0";
        }
        $sql = "SELECT KD_KECAMATAN, KD_KELURAHAN, NM_KELURAHAN FROM REF_KELURAHAN WHERE KD_KECAMATAN='{$kec}' order by NM_KELURAHAN";
        $query = $this->db->query($sql);
        if ($query->num_rows() !== 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    function get_select_thn_pjk_pbb($thn_prd)
    {
        if (empty($thn_prd)) {
            $thn_prd = "0";
        }else{$thn_prd ="2022";}
        //
        $sql_OLD = "SELECT SPT.THN_PAJAK_SPPT, COUNT(1) AS CTR 
        FROM SIPKD_SPPT_SA SPT 
        WHERE SPT.THN_PRD='{$thn_prd}' 
        GROUP BY SPT.THN_PAJAK_SPPT ORDER BY SPT.THN_PAJAK_SPPT ";
        //
        $sql = "SELECT DISTINCT SPT.THN_PAJAK_SPPT 
        FROM SPPT SPT 
        -- WHERE SPT.THN_PRD='{$thn_prd}' 
        ORDER BY SPT.THN_PAJAK_SPPT DESC ";
        //
        $query = $this->db->query($sql);
        // var_dump($query->result());die();
        if ($query->num_rows() !== 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    function tes(){
        var_dump('tes');die;
    }

    function query_grid_cetak($kd_kec, $kd_kel, $c_thn)
    {
        // var_dump($c_thn);die;
        $filter_thn_pjk = '';
        $kondisi_byr = '';

        if($kd_kec != 999999){
            $filter_thn_pjk .= " AND Z1.KD_KECAMATAN = '". $kd_kec ."' ";
        }

        if($kd_kel != 999999){
            $filter_thn_pjk .= " AND Z1.KD_KELURAHAN = '". $kd_kel ."' ";
        }

        if($c_thn != 0){
            $filter_thn_pjk .= " AND Z1.THN_PAJAK_SPPT = '". $c_thn ."' ";
        }

        // if($c_nop != 0){
        //     $c_nop = trim($c_nop);
        //     $c_nop = strtoupper($c_nop);
        //     $filter_thn_pjk .= " AND upper(Z1.KD_PROPINSI||Z1.KD_DATI2||Z1.KD_KECAMATAN||Z1.KD_KELURAHAN||Z1.KD_BLOK||Z1.NO_URUT||Z1.KD_JNS_OP) like ('%".$c_nop."%') ";
        // }

        $sql = "SELECT Z1.KD_KECAMATAN,
  Z1.KD_KELURAHAN,
  Z1.NM_KELURAHAN,
  KEC.NM_KECAMATAN,
  Z1.THN_PAJAK_SPPT,
  Z1.TOTAL_EKSPEKTASI,
  Z1.TOTAL_REALITA,
  ROUND((Z1.TOTAL_REALITA / Z1.TOTAL_EKSPEKTASI) * 100, 2) PERSENTASE_BUKU_1,
  Z2.TOTAL_EKSPEKTASI TOTAL_EKSPEKTASI_B2,
  Z2.TOTAL_REALITA TOTAL_REALITA_B2,
  ROUND((Z2.TOTAL_REALITA / Z2.TOTAL_EKSPEKTASI) * 100, 2) PERSENTASE_BUKU_2,
  Z3.TOTAL_EKSPEKTASI TOTAL_EKSPEKTASI_B3,
  Z3.TOTAL_REALITA TOTAL_REALITA_B3,
  ROUND((Z3.TOTAL_REALITA / Z3.TOTAL_EKSPEKTASI) * 100, 2) PERSENTASE_BUKU_3,
  Z4.TOTAL_EKSPEKTASI TOTAL_EKSPEKTASI_B4,
  Z4.TOTAL_REALITA TOTAL_REALITA_B4,
  ROUND((Z4.TOTAL_REALITA / Z4.TOTAL_EKSPEKTASI) * 100, 2) PERSENTASE_BUKU_4,
  Z5.TOTAL_EKSPEKTASI TOTAL_EKSPEKTASI_B5,
  Z5.TOTAL_REALITA TOTAL_REALITA_B5,
  ROUND((Z5.TOTAL_REALITA / Z5.TOTAL_EKSPEKTASI) * 100, 2) PERSENTASE_BUKU_5
FROM
  (SELECT TT1.KD_KECAMATAN,
    TT1.KD_KELURAHAN,
    KEL.NM_KELURAHAN,
    TT1.THN_PAJAK_SPPT,
    COUNT(1)                                   AS TOTAL_EKSPEKTASI,
    SUM(NVL(TT1.PBB_YG_HARUS_DIBAYAR_SPPT, 0)) AS NILAI_EKSPEKTASI,
    SUM((
    CASE
      WHEN TT1.TGL_TERIMA_SPPT IS NULL
      THEN 0
      ELSE 1
    END)) AS TOTAL_REALITA,
    SUM((
    CASE
      WHEN TT1.TGL_TERIMA_SPPT IS NULL
      THEN 0
      ELSE NVL(TT1.PBB_YG_HARUS_DIBAYAR_SPPT, 0)
    END)) AS NILAI_REALITA,
    SUM((
    CASE
      WHEN TT1.TGL_TERIMA_SPPT IS NULL
      THEN 1
      ELSE 0
    END)) AS TOTAL_SISA,
    SUM((
    CASE
      WHEN TT1.TGL_TERIMA_SPPT IS NULL
      THEN NVL(TT1.PBB_YG_HARUS_DIBAYAR_SPPT, 0)
      ELSE 0
    END)) AS NILAI_SISA
  FROM TTSPPT12D TT1
  JOIN REF_KELURAHAN KEL
  ON TT1.KD_KECAMATAN                  = KEL.KD_KECAMATAN
  AND TT1.KD_KELURAHAN                 = KEL.KD_KELURAHAN
  WHERE TT1.PBB_YG_HARUS_DIBAYAR_SPPT <= 100000
  AND TT1.THN_PAJAK_SPPT = '2024'
  AND KEL.NM_KELURAHAN  <> '-'
  GROUP BY TT1.KD_KECAMATAN,
    TT1.KD_KELURAHAN,
    KEL.NM_KELURAHAN,
    TT1.THN_PAJAK_SPPT
  ORDER BY TT1.KD_KECAMATAN ASC,
    TT1.KD_KELURAHAN ASC
  ) Z1
JOIN
  (SELECT TT1.KD_KECAMATAN,
    TT1.KD_KELURAHAN,
    KEL.NM_KELURAHAN,
    TT1.THN_PAJAK_SPPT,
    COUNT(1)                                   AS TOTAL_EKSPEKTASI,
    SUM(NVL(TT1.PBB_YG_HARUS_DIBAYAR_SPPT, 0)) AS NILAI_EKSPEKTASI,
    SUM((
    CASE
      WHEN TT1.TGL_TERIMA_SPPT IS NULL
      THEN 0
      ELSE 1
    END)) AS TOTAL_REALITA,
    SUM((
    CASE
      WHEN TT1.TGL_TERIMA_SPPT IS NULL
      THEN 0
      ELSE NVL(TT1.PBB_YG_HARUS_DIBAYAR_SPPT, 0)
    END)) AS NILAI_REALITA,
    SUM((
    CASE
      WHEN TT1.TGL_TERIMA_SPPT IS NULL
      THEN 1
      ELSE 0
    END)) AS TOTAL_SISA,
    SUM((
    CASE
      WHEN TT1.TGL_TERIMA_SPPT IS NULL
      THEN NVL(TT1.PBB_YG_HARUS_DIBAYAR_SPPT, 0)
      ELSE 0
    END)) AS NILAI_SISA
  FROM TTSPPT12D TT1
  JOIN REF_KELURAHAN KEL
  ON TT1.KD_KECAMATAN  = KEL.KD_KECAMATAN
  AND TT1.KD_KELURAHAN = KEL.KD_KELURAHAN
  WHERE TT1.PBB_YG_HARUS_DIBAYAR_SPPT BETWEEN 100001 AND 500000
  AND TT1.THN_PAJAK_SPPT = '2024'
  AND KEL.NM_KELURAHAN  <> '-'
  GROUP BY TT1.KD_KECAMATAN,
    TT1.KD_KELURAHAN,
    KEL.NM_KELURAHAN,
    TT1.THN_PAJAK_SPPT
  ORDER BY TT1.KD_KECAMATAN ASC,
    TT1.KD_KELURAHAN ASC
  ) Z2 ON Z2.KD_KECAMATAN = Z1.KD_KECAMATAN
AND Z2.KD_KELURAHAN       = Z1.KD_KELURAHAN 
JOIN
  (SELECT TT1.KD_KECAMATAN,
    TT1.KD_KELURAHAN,
    KEL.NM_KELURAHAN,
    TT1.THN_PAJAK_SPPT,
    COUNT(1)                                   AS TOTAL_EKSPEKTASI,
    SUM(NVL(TT1.PBB_YG_HARUS_DIBAYAR_SPPT, 0)) AS NILAI_EKSPEKTASI,
    SUM((
    CASE
      WHEN TT1.TGL_TERIMA_SPPT IS NULL
      THEN 0
      ELSE 1
    END)) AS TOTAL_REALITA,
    SUM((
    CASE
      WHEN TT1.TGL_TERIMA_SPPT IS NULL
      THEN 0
      ELSE NVL(TT1.PBB_YG_HARUS_DIBAYAR_SPPT, 0)
    END)) AS NILAI_REALITA,
    SUM((
    CASE
      WHEN TT1.TGL_TERIMA_SPPT IS NULL
      THEN 1
      ELSE 0
    END)) AS TOTAL_SISA,
    SUM((
    CASE
      WHEN TT1.TGL_TERIMA_SPPT IS NULL
      THEN NVL(TT1.PBB_YG_HARUS_DIBAYAR_SPPT, 0)
      ELSE 0
    END)) AS NILAI_SISA
  FROM TTSPPT12D TT1
  JOIN REF_KELURAHAN KEL
  ON TT1.KD_KECAMATAN  = KEL.KD_KECAMATAN
  AND TT1.KD_KELURAHAN = KEL.KD_KELURAHAN
  WHERE PBB_YG_HARUS_DIBAYAR_SPPT BETWEEN 500001 AND 2000000
  AND TT1.THN_PAJAK_SPPT = '2024'
  AND KEL.NM_KELURAHAN  <> '-'
  GROUP BY TT1.KD_KECAMATAN,
    TT1.KD_KELURAHAN,
    KEL.NM_KELURAHAN,
    TT1.THN_PAJAK_SPPT
  ORDER BY TT1.KD_KECAMATAN ASC,
    TT1.KD_KELURAHAN ASC
  ) Z3 ON Z3.KD_KECAMATAN = Z1.KD_KECAMATAN
AND Z3.KD_KELURAHAN       = Z1.KD_KELURAHAN
JOIN
  (SELECT TT1.KD_KECAMATAN,
    TT1.KD_KELURAHAN,
    KEL.NM_KELURAHAN,
    TT1.THN_PAJAK_SPPT,
    COUNT(1)                                   AS TOTAL_EKSPEKTASI,
    SUM(NVL(TT1.PBB_YG_HARUS_DIBAYAR_SPPT, 0)) AS NILAI_EKSPEKTASI,
    SUM((
    CASE
      WHEN TT1.TGL_TERIMA_SPPT IS NULL
      THEN 0
      ELSE 1
    END)) AS TOTAL_REALITA,
    SUM((
    CASE
      WHEN TT1.TGL_TERIMA_SPPT IS NULL
      THEN 0
      ELSE NVL(TT1.PBB_YG_HARUS_DIBAYAR_SPPT, 0)
    END)) AS NILAI_REALITA,
    SUM((
    CASE
      WHEN TT1.TGL_TERIMA_SPPT IS NULL
      THEN 1
      ELSE 0
    END)) AS TOTAL_SISA,
    SUM((
    CASE
      WHEN TT1.TGL_TERIMA_SPPT IS NULL
      THEN NVL(TT1.PBB_YG_HARUS_DIBAYAR_SPPT, 0)
      ELSE 0
    END)) AS NILAI_SISA
  FROM TTSPPT12D TT1
  JOIN REF_KELURAHAN KEL
  ON TT1.KD_KECAMATAN  = KEL.KD_KECAMATAN
  AND TT1.KD_KELURAHAN = KEL.KD_KELURAHAN
  WHERE PBB_YG_HARUS_DIBAYAR_SPPT BETWEEN 2000001 AND 5000000
  AND TT1.THN_PAJAK_SPPT = '2024'
  AND KEL.NM_KELURAHAN  <> '-'
  GROUP BY TT1.KD_KECAMATAN,
    TT1.KD_KELURAHAN,
    KEL.NM_KELURAHAN,
    TT1.THN_PAJAK_SPPT
  ORDER BY TT1.KD_KECAMATAN ASC,
    TT1.KD_KELURAHAN ASC
  ) Z4 ON Z4.KD_KECAMATAN = Z1.KD_KECAMATAN
AND Z4.KD_KELURAHAN       = Z1.KD_KELURAHAN
JOIN
  (SELECT TT1.KD_KECAMATAN,
    TT1.KD_KELURAHAN,
    KEL.NM_KELURAHAN,
    TT1.THN_PAJAK_SPPT,
    COUNT(1)                                   AS TOTAL_EKSPEKTASI,
    SUM(NVL(TT1.PBB_YG_HARUS_DIBAYAR_SPPT, 0)) AS NILAI_EKSPEKTASI,
    SUM((
    CASE
      WHEN TT1.TGL_TERIMA_SPPT IS NULL
      THEN 0
      ELSE 1
    END)) AS TOTAL_REALITA,
    SUM((
    CASE
      WHEN TT1.TGL_TERIMA_SPPT IS NULL
      THEN 0
      ELSE NVL(TT1.PBB_YG_HARUS_DIBAYAR_SPPT, 0)
    END)) AS NILAI_REALITA,
    SUM((
    CASE
      WHEN TT1.TGL_TERIMA_SPPT IS NULL
      THEN 1
      ELSE 0
    END)) AS TOTAL_SISA,
    SUM((
    CASE
      WHEN TT1.TGL_TERIMA_SPPT IS NULL
      THEN NVL(TT1.PBB_YG_HARUS_DIBAYAR_SPPT, 0)
      ELSE 0
    END)) AS NILAI_SISA
  FROM TTSPPT12D TT1
  JOIN REF_KELURAHAN KEL
  ON TT1.KD_KECAMATAN  = KEL.KD_KECAMATAN
  AND TT1.KD_KELURAHAN = KEL.KD_KELURAHAN
  WHERE PBB_YG_HARUS_DIBAYAR_SPPT > 5000000
  AND TT1.THN_PAJAK_SPPT = '2024'
  AND KEL.NM_KELURAHAN  <> '-'
  GROUP BY TT1.KD_KECAMATAN,
    TT1.KD_KELURAHAN,
    KEL.NM_KELURAHAN,
    TT1.THN_PAJAK_SPPT
  ORDER BY TT1.KD_KECAMATAN ASC,
    TT1.KD_KELURAHAN ASC
  ) Z5 ON Z5.KD_KECAMATAN = Z1.KD_KECAMATAN
AND Z5.KD_KELURAHAN       = Z1.KD_KELURAHAN 
join ref_kecamatan KEC on Z1.KD_KECAMATAN = KEC.KD_KECAMATAN
WHERE 1=1
{$filter_thn_pjk}
";

        return $sql;
       
    }

    function query_cetak_real($kd_kec, $kd_kel, $c_thn){

        $filter = '';
        $filter_thn = '';

        if($kd_kec != 999999){
            $filter .= " AND Z1.KD_KECAMATAN = '". $kd_kec ."' ";
        }

        if($kd_kel != 999999){
            $filter .= " AND Z1.KD_KELURAHAN = '". $kd_kel ."' ";
        }

        if($c_thn != 0){
            $filter_thn = " AND TT1.THN_PAJAK_SPPT = '". $c_thn ."' ";
        }

        $sql = "WITH CTE_SPPT AS (
  SELECT 
    TT1.KD_KECAMATAN,
    TT1.KD_KELURAHAN,
    KEL.NM_KELURAHAN,
    TT1.THN_PAJAK_SPPT,
    TT1.PBB_YG_HARUS_DIBAYAR_SPPT,
    CASE 
      WHEN TT1.TGL_TERIMA_SPPT IS NULL THEN 0 
      ELSE 1 
    END AS IS_REALIZED,
    NVL(TT1.PBB_YG_HARUS_DIBAYAR_SPPT, 0) AS NILAI_REALIZED
  FROM TTSPPT12D TT1
  JOIN REF_KELURAHAN KEL
    ON TT1.KD_KECAMATAN = KEL.KD_KECAMATAN
    AND TT1.KD_KELURAHAN = KEL.KD_KELURAHAN
  WHERE KEL.NM_KELURAHAN <> '-'
    {$filter_thn}
)

SELECT 
  Z1.KD_KECAMATAN,
  Z1.KD_KELURAHAN,
  Z1.NM_KELURAHAN,
  KEC.NM_KECAMATAN,
  Z1.THN_PAJAK_SPPT,
  COALESCE(z1.total_ekspektasi, 0) as total_ekspektasi,
  COALESCE(z1.total_realita, 0) as total_realita,
  COALESCE(round( (z1.total_realita / z1.total_ekspektasi) * 100,2), 0) AS persentase_buku_1,
  COALESCE(z2.total_ekspektasi, 0) as total_ekspektasi_b2,
  COALESCE(z2.total_realita, 0) AS total_realita_b2,
  COALESCE(round( (z2.total_realita / z2.total_ekspektasi) * 100,2), 0) AS persentase_buku_2,
  COALESCE(z3.total_ekspektasi, 0) AS total_ekspektasi_b3,
  COALESCE(z3.total_realita, 0) AS total_realita_b3,
  COALESCE(round( (z3.total_realita / z3.total_ekspektasi) * 100,2), 0) AS persentase_buku_3,
  COALESCE(z4.total_ekspektasi, 0) AS total_ekspektasi_b4,
  COALESCE(z4.total_realita, 0) AS total_realita_b4,
  COALESCE(round( (z4.total_realita / z4.total_ekspektasi) * 100,2), 0) AS persentase_buku_4,
  COALESCE(z5.total_ekspektasi, 0) AS total_ekspektasi_b5,
  COALESCE(z5.total_realita, 0) AS total_realita_b5,
  COALESCE(round( (z5.total_realita / z5.total_ekspektasi) * 100,2), 0) AS persentase_buku_5
FROM (
  SELECT 
    KD_KECAMATAN,
    KD_KELURAHAN,
    NM_KELURAHAN,
    THN_PAJAK_SPPT,
    COUNT(*) AS TOTAL_EKSPEKTASI,
    SUM(IS_REALIZED) AS TOTAL_REALITA
  FROM CTE_SPPT
  WHERE PBB_YG_HARUS_DIBAYAR_SPPT <= 100000
  GROUP BY KD_KECAMATAN, KD_KELURAHAN, NM_KELURAHAN, THN_PAJAK_SPPT
) Z1
LEFT JOIN (
  SELECT 
    KD_KECAMATAN,
    KD_KELURAHAN,
    NM_KELURAHAN,
    THN_PAJAK_SPPT,
    COUNT(*) AS TOTAL_EKSPEKTASI,
    SUM(IS_REALIZED) AS TOTAL_REALITA
  FROM CTE_SPPT
  WHERE PBB_YG_HARUS_DIBAYAR_SPPT BETWEEN 100001 AND 500000
  GROUP BY KD_KECAMATAN, KD_KELURAHAN, NM_KELURAHAN, THN_PAJAK_SPPT
) Z2 
ON Z2.KD_KECAMATAN = Z1.KD_KECAMATAN
AND Z2.KD_KELURAHAN = Z1.KD_KELURAHAN
LEFT JOIN (
  SELECT 
    KD_KECAMATAN,
    KD_KELURAHAN,
    NM_KELURAHAN,
    THN_PAJAK_SPPT,
    COUNT(*) AS TOTAL_EKSPEKTASI,
    SUM(IS_REALIZED) AS TOTAL_REALITA
  FROM CTE_SPPT
  WHERE PBB_YG_HARUS_DIBAYAR_SPPT BETWEEN 500001 AND 2000000
  GROUP BY KD_KECAMATAN, KD_KELURAHAN, NM_KELURAHAN, THN_PAJAK_SPPT
) Z3 
ON Z3.KD_KECAMATAN = Z1.KD_KECAMATAN
AND Z3.KD_KELURAHAN = Z1.KD_KELURAHAN
LEFT JOIN (
  SELECT 
    KD_KECAMATAN,
    KD_KELURAHAN,
    NM_KELURAHAN,
    THN_PAJAK_SPPT,
    COUNT(*) AS TOTAL_EKSPEKTASI,
    SUM(IS_REALIZED) AS TOTAL_REALITA
  FROM CTE_SPPT
  WHERE PBB_YG_HARUS_DIBAYAR_SPPT BETWEEN 2000001 AND 5000000
  GROUP BY KD_KECAMATAN, KD_KELURAHAN, NM_KELURAHAN, THN_PAJAK_SPPT
) Z4 
ON Z4.KD_KECAMATAN = Z1.KD_KECAMATAN
AND Z4.KD_KELURAHAN = Z1.KD_KELURAHAN
LEFT JOIN (
  SELECT 
    KD_KECAMATAN,
    KD_KELURAHAN,
    NM_KELURAHAN,
    THN_PAJAK_SPPT,
    COUNT(*) AS TOTAL_EKSPEKTASI,
    SUM(IS_REALIZED) AS TOTAL_REALITA
  FROM CTE_SPPT
  WHERE PBB_YG_HARUS_DIBAYAR_SPPT > 5000000
  GROUP BY KD_KECAMATAN, KD_KELURAHAN, NM_KELURAHAN, THN_PAJAK_SPPT
) Z5 
ON Z5.KD_KECAMATAN = Z1.KD_KECAMATAN
AND Z5.KD_KELURAHAN = Z1.KD_KELURAHAN
JOIN REF_KECAMATAN KEC
ON Z1.KD_KECAMATAN = KEC.KD_KECAMATAN
{$filter}
";

        return $sql;
    }

}

/* End of file _model.php */
