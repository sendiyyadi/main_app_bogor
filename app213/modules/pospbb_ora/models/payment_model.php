<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class payment_model extends CI_Model
{

  private $tbl = 'SPPT';
  //private $schema_pbb = SCHEMA_PBB . ".";
  private $schema_pbb = "";

  function __construct()
  {
    parent::__construct();
  }

  function get_pembayaran_ke($nop, $thn)
  {

    // get info pembayaran ke

    $schema_pbb = $this->schema_pbb;

    $nop = preg_replace('/[^0-9]/', '', $nop);
    $kd_propinsi = substr($nop, 0, 2);
    $kd_dati2 = substr($nop, 2, 2);
    $kd_kecamatan = substr($nop, 4, 3);
    $kd_kelurahan = substr($nop, 7, 3);
    $kd_blok = substr($nop, 10, 3);
    $no_urut = substr($nop, 13, 4);
    $kd_jns_op = substr($nop, 17, 1);

    $sql = "select (nvl(max(pembayaran_sppt_ke),0)+1) as jml
        FROM S_PEMBAYARAN_SPPT ps
        where ps.kd_propinsi='$kd_propinsi' and ps.kd_dati2='$kd_dati2' and ps.kd_kecamatan='$kd_kecamatan' 
        and ps.kd_kelurahan='$kd_kelurahan' and ps.kd_blok='$kd_blok' and ps.no_urut='$no_urut' 
        and ps.kd_jns_op = '$kd_jns_op' and ps.thn_pajak_sppt = '$thn'";
    $query = $this->db->query($sql);
    $nval  = $query->row();
    $nva   = $nval->JML;
    return $nva;
  }
  
  function add_hist_bayar($hist_bayar){
	/* Create History Bayar */
    $histkeys   = array_keys($hist_bayar);
    $histvalues = array_values($hist_bayar);
    $histkeys   = implode(', ', $histkeys);
    $histvalues = "'" . implode("', '", $histvalues) . "'";
	
	$sql =
      "BEGIN 

      BEGIN
      INSERT INTO HIST_PEMBAYARAN_SPPT (" . $histkeys . ")
      select " . $histvalues . " from dual;
      EXCEPTION WHEN OTHERS THEN 
	  RAISE_APPLICATION_ERROR(-20006, SQLCODE || ' HIST ERROR: ' || SQLERRM);
      END;

      COMMIT;
      END;";
    
    $result = $this->db->simple_qry_eon_ora($sql);
    
    return $result['message'];
  }

  function add_bayar_per_nop($nop, $thn, $sisa_sppt, $data, $hist_bayar)
  {
    // dulu update_pmb
    $schema_pbb = $this->schema_pbb;
    $tabel      = $schema_pbb . "PEMBAYARAN_SPPT";
    //
    $nop          = urldecode($nop);
    $nop          = str_replace('.', '', $nop);
    $nop          = str_replace(' ', '', $nop);
    $nop          = str_replace('-', '', $nop);
    $nop          = preg_replace('/[^0-9]/', '', $nop);

    $kd_propinsi  = substr($nop, 0, 2);
    $kd_dati2     = substr($nop, 2, 2);
    $kd_kecamatan = substr($nop, 4, 3);
    $kd_kelurahan = substr($nop, 7, 3);
    $kd_blok      = substr($nop, 10, 3);
    $no_urut      = substr($nop, 13, 4);
    $kd_jns_op    = substr($nop, 17, 1);

    $exists = "(select s.pbb_yg_harus_dibayar_sppt,
      sum(nvl(ps.denda_sppt,0)) as denda_sppt,
      sum(nvl(ps.jml_sppt_yg_dibayar,0)) as jml_sppt_yg_dibayar
      from S_SPPT s
      left join S_PEMBAYARAN_SPPT ps on
      s.kd_propinsi=ps.kd_propinsi and s.kd_dati2=ps.kd_dati2 
      and s.kd_kecamatan=ps.kd_kecamatan and s.kd_kelurahan=ps.kd_kelurahan 
      and s.kd_blok=ps.kd_blok and s.no_urut=ps.no_urut and s.kd_jns_op = ps.kd_jns_op
      and s.thn_pajak_sppt = ps.thn_pajak_sppt  
      where s.kd_propinsi='$kd_propinsi' and s.kd_dati2='$kd_dati2' and 
      s.kd_kecamatan='$kd_kecamatan' and 
      s.kd_kelurahan='$kd_kelurahan' and s.kd_blok='$kd_blok' and s.no_urut='$no_urut' and s.kd_jns_op='$kd_jns_op'
      and s.thn_pajak_sppt = '$thn' and s.status_pembayaran_sppt='0'
      and $sisa_sppt>0
      group by s.pbb_yg_harus_dibayar_sppt
      having 
      s.pbb_yg_harus_dibayar_sppt-(sum(nvl(ps.jml_sppt_yg_dibayar,0))-sum(nvl(ps.denda_sppt,0)))=$sisa_sppt)";
    //
    //$keys   = implode(', ', array_keys($data));
    //$values = implode("', '", array_values($data));

    $keys   = array_keys($data);
    $values = array_values($data);
    //
    $keys   = implode(', ', $keys);
    $values = "'" . implode("', '", $values) . "'";

    //
    $sql =
      "BEGIN 
      BEGIN
      INSERT INTO " . $tabel . " (" . $keys . ")
      select " . $values . " from dual 
      where exists(" . $exists . ");
      EXCEPTION WHEN OTHERS THEN RAISE_APPLICATION_ERROR(-20005,SQLCODE||' error : Cetak STTS GAGAL ...!'); 
      IF sql%rowcount = 0 THEN
          RAISE_APPLICATION_ERROR (-20054, 'Tidak ada Penambahan Data....');
      END IF;
      END;

      COMMIT;
      END;";
    // log_message('info', " AAAAAAAAAAAAAAAAAA  sql : ".$sql);
    // cek juga jika tdk ada hasil error data
    $result = $this->db->simple_qry_eon_ora($sql);
    // hasil dari simple_qry_eon_ora bentuk array
    return $result['message'];
    /*
      buat testing
      $sql = "
      begin
      insert into USER_PBB
      SELECT 0 as ID, USER_ID,CREATED,DISABLED,KD_KANTOR,KD_KANWIL,KD_TP,KD_KANWIL_BANK,KD_KPPBB,KD_BANK_TUNGGAL,KD_BANK_PERSEPSI,
      'tesdf' USERID
      FROM V_USER_PBB  where id=8;
      IF sql%rowcount = 0 THEN
      RAISE_APPLICATION_ERROR (-20054, 'Tidak ada Penambahan Data....');
      END IF;
      commit;
      end;   ";
      $result = $this->db->simple_qry_eon_ora($sql);
      log_message('info', "AAAAAAAAAAAAAAAAAA  add_bayar_per_nop : ".$result['message']);
      return 'tes EROR' ;
      */
  }

  function upd_sppt_faktor_pengurang($nop, $thn, $nil_pengurang)
  {
    // dulu update_pmb
    $schema_pbb = $this->schema_pbb;
    $tabel      = $schema_pbb . "SPPT";
    //
    $nop          = urldecode($nop);
    $nop          = str_replace('.', '', $nop);
    $nop          = str_replace(' ', '', $nop);
    $nop          = str_replace('-', '', $nop);
    $nop          = preg_replace('/[^0-9]/', '', $nop);

    $kd_propinsi  = substr($nop, 0, 2);
    $kd_dati2     = substr($nop, 2, 2);
    $kd_kecamatan = substr($nop, 4, 3);
    $kd_kelurahan = substr($nop, 7, 3);
    $kd_blok      = substr($nop, 10, 3);
    $no_urut      = substr($nop, 13, 4);
    $kd_jns_op    = substr($nop, 17, 1);

    $sql = "BEGIN
      UPDATE {$schema_pbb}SPPT s set 
      FAKTOR_PENGURANG_SPPT = {$nil_pengurang}, 
      PBB_YG_HARUS_DIBAYAR_SPPT = (s.PBB_TERHUTANG_SPPT - {$nil_pengurang})
      where s.kd_propinsi='$kd_propinsi' and s.kd_dati2='$kd_dati2' and s.kd_kecamatan='$kd_kecamatan' 
      and  s.kd_kelurahan='$kd_kelurahan' and s.kd_blok='$kd_blok' and s.no_urut='$no_urut' and s.kd_jns_op='$kd_jns_op'
      and s.thn_pajak_sppt = '$thn' and s.status_pembayaran_sppt='0' and s.FAKTOR_PENGURANG_SPPT = 0
      and $nil_pengurang > 0 ;
      EXCEPTION WHEN OTHERS THEN RAISE_APPLICATION_ERROR(-20005,SQLCODE||' error : UPDATE SPPT GAGAL ...!'); 
      COMMIT; 
      END; ";
    // cek juga jika tdk ada hasil error data
    $result = $this->db->simple_qry_eon_ora($sql);
    // hasil dari simple_qry_eon_ora bentuk array
    return $result['message'];
  }

  function add_bayar_hist_stts($data)
  {
    // dulu update_pmb
    $result = $this->db->insert_eon_ora("HIST_PEMBAYARAN_SPPT", $data);
    return $result;
  }

  function get_by_nop_thn_ke_bendahara($nop, $thn, $ke)
  {

    $nop = urldecode($nop);
    $nop = preg_replace('/[^0-9]/', '', $nop);
    $kd_propinsi = substr($nop, 0, 2);
    $kd_dati2 = substr($nop, 2, 2);
    $kd_kecamatan = substr($nop, 4, 3);
    $kd_kelurahan = substr($nop, 7, 3);
    $kd_blok = substr($nop, 10, 3);
    $no_urut = substr($nop, 13, 4);
    $kd_jns_op = substr($nop, 17, 1);
    $fields = explode(',', POS_FIELD);
    $field = "";
    $join = "";
    $userid = $this->session->userdata('userid');

    foreach ($fields as $f) {
      $f = trim($f);
      $join .= " AND ps.$f=tp.$f ";
      $field .= "ps.$f ,";
    };
    $join = str_replace('tp.kd_kppbb', 'tp.kd_kantor', $join);
    $join = str_replace('tp.kd_kanwil', 'tp.kd_kanwil', $join);
    if ($userid == 299) {
      $usop = "";
    } else {
      $usop = " to_char(ps.tgl_pembayaran_sppt,'yyyy') = to_char(now(),'yyyy') and ";
    }
    //$usop = " 1=1 and "; // buat tes arig
    $sql = "select s.kd_propinsi, s.kd_dati2, s.kd_kecamatan, s.kd_kelurahan, s.kd_blok, s.no_urut, s.kd_jns_op ,
                       s.thn_pajak_sppt, ps.pembayaran_sppt_ke, s.nm_wp_sppt, s.jln_wp_sppt, s.rt_wp_sppt, s.rw_wp_sppt,
                       s.kelurahan_wp_sppt, s.kota_wp_sppt, s.npwp_sppt, ps.tgl_pembayaran_sppt, ps.denda_sppt,
                 s.pbb_terhutang_sppt, coalesce(b.faktor_pengurang_covid19,0) as faktor_pengurang_sppt, s.pbb_yg_harus_dibayar_sppt, s.tgl_jatuh_tempo_sppt,
                 ps.denda_sppt  denda_sppt, ps.jml_sppt_yg_dibayar  jml_sppt_yg_dibayar,  kec.nm_kecamatan, kel.nm_kelurahan,
                 s.tgl_jatuh_tempo_sppt, s.luas_bumi_sppt, s.luas_bng_sppt,
                 dt2.nm_dati2,prop.nm_propinsi,
                 s.blok_kav_no_wp_sppt, ps.user_id,
                 $field tp.nm_tp
            from sppt s

            left join (SELECT cvd.* FROM hist_bayar_sppt_covid19 cvd
                  join sppt sppt
                  on sppt.kd_propinsi=cvd.kd_propinsi and sppt.kd_dati2=cvd.kd_dati2 and sppt.kd_kecamatan=cvd.kd_kecamatan
                  and sppt.kd_kelurahan=cvd.kd_kelurahan and sppt.kd_blok=cvd.kd_blok and sppt.no_urut=cvd.no_urut
                  and sppt.kd_jns_op=cvd.kd_jns_op and sppt.thn_pajak_sppt=cvd.thn_pajak_sppt
                  where sppt.kd_propinsi='$kd_propinsi' and sppt.kd_dati2='$kd_dati2' and sppt.kd_kecamatan='$kd_kecamatan' and
                  sppt.kd_kelurahan='$kd_kelurahan' and sppt.kd_blok='$kd_blok' and sppt.no_urut='$no_urut' and sppt.kd_jns_op = '$kd_jns_op'
                  and sppt.thn_pajak_sppt = '$thn' and cvd.flg_batal is null
                  order by cvd.create_date desc limit 1
                ) b on
              s.kd_propinsi=b.kd_propinsi and s.kd_dati2=b.kd_dati2 and s.kd_kecamatan=b.kd_kecamatan
              and s.kd_kelurahan=b.kd_kelurahan and s.kd_blok=b.kd_blok and s.no_urut=b.no_urut
              and s.kd_jns_op=b.kd_jns_op and s.thn_pajak_sppt=b.thn_pajak_sppt and b.flg_batal is null

                 inner join pembayaran_sppt ps on
                    s.kd_propinsi=ps.kd_propinsi and s.kd_dati2=ps.kd_dati2 and s.kd_kecamatan=ps.kd_kecamatan and
                    s.kd_kelurahan=ps.kd_kelurahan and s.kd_blok=ps.kd_blok and s.no_urut=ps.no_urut and s.kd_jns_op = ps.kd_jns_op
                    and s.thn_pajak_sppt = ps.thn_pajak_sppt

                inner join ref_propinsi prop on s.kd_propinsi=prop.kd_propinsi
                inner join ref_dati2 dt2 on s.kd_propinsi=dt2.kd_propinsi and s.kd_dati2=dt2.kd_dati2

                 inner join ref_kecamatan kec on
                    s.kd_propinsi=kec.kd_propinsi and s.kd_dati2=kec.kd_dati2 and s.kd_kecamatan=kec.kd_kecamatan
               inner join ref_kelurahan kel on
                    s.kd_propinsi=kel.kd_propinsi and s.kd_dati2=kel.kd_dati2 and s.kd_kecamatan=kel.kd_kecamatan
                    and s.kd_kelurahan=kel.kd_kelurahan
                 left join tempat_pembayaran tp on 1=1 $join
                 where " . $usop . "
                s.kd_propinsi='$kd_propinsi' and s.kd_dati2='$kd_dati2' and s.kd_kecamatan='$kd_kecamatan' and
                  s.kd_kelurahan='$kd_kelurahan' and s.kd_blok='$kd_blok' and s.no_urut='$no_urut' and s.kd_jns_op = '$kd_jns_op'
                  and s.thn_pajak_sppt = '$thn' and ps.pembayaran_sppt_ke='$ke' and ps.nip_rekam_byr_sppt='888888888' ";
    $query = $this->db->query($sql);

    if ($query->num_rows() != 0) {
      return $query->row();
    } else
      return FALSE;
  }

  function get_by_nop_thn_ke($nop, $thn, $ke)
  {

    $schema_pbb = $this->schema_pbb;
    $nop = urldecode($nop);
    $nop = preg_replace('/[^0-9]/', '', $nop);
    $kd_propinsi = substr($nop, 0, 2);
    $kd_dati2 = substr($nop, 2, 2);
    $kd_kecamatan = substr($nop, 4, 3);
    $kd_kelurahan = substr($nop, 7, 3);
    $kd_blok = substr($nop, 10, 3);
    $no_urut = substr($nop, 13, 4);
    $kd_jns_op = substr($nop, 17, 1);

    $userid = $this->session->userdata('userid');

    $field = pos_kolom("ps");
    $join  = pos_join("ps", "tp");
    $tgl_now = current_date();
    //$tgl_now = "2016-07-27";  //ARIG TEST NANTI DI REMARK

    $userlogin = lda_user_login();
    $isgrup_admin = $this->load->model('user_pbb_model')->get_isgrup_admin($userlogin);
    // cek jika bukan grup admin
    $filter_tgl = "";
    $kd_kanwil = $this->session->userdata('kd_kanwil');
    $kd_kantor = $this->session->userdata('kd_kantor');
    $kd_tp     = $this->session->userdata('kd_tp');

    if ($isgrup_admin == FALSE) {
      $filter_tgl = " and trunc(ps.tgl_pembayaran_sppt)=to_date('$tgl_now','yyyy-mm-dd') and
          ps.KD_KANWIL='{$kd_kanwil}' and ps.KD_KANTOR='{$kd_kantor}' and ps.KD_TP='{$kd_tp}' ";
    }
    // 
    $sql = "SELECT s.kd_propinsi, s.kd_dati2, s.kd_kecamatan, s.kd_kelurahan, s.kd_blok, s.no_urut, s.kd_jns_op ,
      s.thn_pajak_sppt, ps.pembayaran_sppt_ke, s.nm_wp_sppt, s.jln_wp_sppt, s.rt_wp_sppt, s.rw_wp_sppt,
      s.kelurahan_wp_sppt, s.kota_wp_sppt, s.npwp_sppt, ps.tgl_pembayaran_sppt, ps.denda_sppt,
      s.pbb_terhutang_sppt, s.faktor_pengurang_sppt, s.pbb_yg_harus_dibayar_sppt, s.tgl_jatuh_tempo_sppt,
      ps.jml_sppt_yg_dibayar,  kec.nm_kecamatan, kel.nm_kelurahan, s.luas_bumi_sppt, s.luas_bng_sppt,
      dt2.nm_dati2,prop.nm_propinsi, s.blok_kav_no_wp_sppt, ps.NIP_REKAM_BYR_SPPT, $field , tp.nm_tp, coalesce(dop.jalan_op, '-') as jalan_op, coalesce(dop.blok_kav_no_op, '-') as blok_kav_no_op,
      nvl(cvd.FAKTOR_PENGURANG_BAYAR,0) as FAKTOR_PENGURANG_BAYAR
      from S_SPPT s
      join S_PEMBAYARAN_SPPT ps on s.kd_propinsi=ps.kd_propinsi and s.kd_dati2=ps.kd_dati2 
      and s.kd_kecamatan=ps.kd_kecamatan and s.kd_kelurahan=ps.kd_kelurahan and s.kd_blok=ps.kd_blok 
      and s.no_urut=ps.no_urut and s.kd_jns_op = ps.kd_jns_op and s.thn_pajak_sppt = ps.thn_pajak_sppt
      left join dat_objek_pajak dop on
      s.kd_propinsi=dop.kd_propinsi and s.kd_dati2=dop.kd_dati2 and s.kd_kecamatan=dop.kd_kecamatan and
      s.kd_kelurahan=dop.kd_kelurahan and s.kd_blok=dop.kd_blok and s.no_urut=dop.no_urut and s.kd_jns_op = dop.kd_jns_op
      join S_REF_PROPINSI prop on s.kd_propinsi=prop.kd_propinsi
      join S_REF_DATI2 dt2 on s.kd_propinsi=dt2.kd_propinsi and s.kd_dati2=dt2.kd_dati2
      join S_REF_KECAMATAN kec on s.kd_propinsi=kec.kd_propinsi and s.kd_dati2=kec.kd_dati2 
      and s.kd_kecamatan=kec.kd_kecamatan
      join S_REF_KELURAHAN kel on s.kd_propinsi=kel.kd_propinsi and s.kd_dati2=kel.kd_dati2 
      and s.kd_kecamatan=kel.kd_kecamatan and s.kd_kelurahan=kel.kd_kelurahan
      left join (SELECT hist.ID, hist.FAKTOR_PENGURANG_BAYAR
      FROM HIST_PEMBAYARAN_SPPT hist
      WHERE hist.KD_PROPINSI='$kd_propinsi' AND hist.KD_DATI2='$kd_dati2' AND 
      hist.KD_KECAMATAN='$kd_kecamatan' AND hist.KD_KELURAHAN='$kd_kelurahan' AND 
      hist.KD_BLOK='$kd_blok' AND hist.NO_URUT='$no_urut' AND 
      hist.KD_JNS_OP='$kd_jns_op' AND hist.THN_PAJAK_SPPT='$thn' AND 
      hist.PEMBAYARAN_SPPT_KE='$ke' AND hist.STS_BAYAR=1 AND ROWNUM<=1
      ) cvd on 1=1
      left join S_TEMPAT_PEMBAYARAN tp on $join
      where 1=1 " . $filter_tgl . "  
      and s.kd_propinsi='$kd_propinsi' and s.kd_dati2='$kd_dati2' and s.kd_kecamatan='$kd_kecamatan' and
      s.kd_kelurahan='$kd_kelurahan' and s.kd_blok='$kd_blok' and s.no_urut='$no_urut' and s.kd_jns_op = '$kd_jns_op'
      and s.thn_pajak_sppt = '$thn' and ps.pembayaran_sppt_ke='$ke' ";
    $query = $this->db->query($sql);

    if ($query->num_rows() != 0) {
      return $query->row();
    } else {
      return FALSE;
    }
  }

  function cancel_nop_thn_ke_OLD($nop, $thn, $ke)
  {

    $schema_pbb = $this->schema_pbb;
    $nop = urldecode($nop);
    $nop = preg_replace('/[^0-9]/', '', $nop);

    $kd_propinsi = substr($nop, 0, 2);
    $kd_dati2 = substr($nop, 2, 2);
    $kd_kecamatan = substr($nop, 4, 3);
    $kd_kelurahan = substr($nop, 7, 3);
    $kd_blok = substr($nop, 10, 3);
    $no_urut = substr($nop, 13, 4);
    $kd_jns_op = substr($nop, 17, 1);

    $tgl_now = current_date();
    //$tgl_now = "2016-07-27";  //ARIG TEST NANTI DI REMARK

    $userid = $this->session->userdata('userid');

    $sql = "UPDATE S_PEMBAYARAN_SPPT set 
        jml_batal=jml_sppt_yg_dibayar, 
        tgl_batal=date(now()), 
        user_id_batal='$userid'
        where kd_propinsi='$kd_propinsi' and kd_dati2='$kd_dati2' and kd_kecamatan='$kd_kecamatan' and
        kd_kelurahan='$kd_kelurahan' and kd_blok='$kd_blok' and no_urut='$no_urut' and kd_jns_op = '$kd_jns_op'
        and thn_pajak_sppt = '$thn' and pembayaran_sppt_ke='$ke' ";
    $query = $this->db->query($sql);
    //
    $sql = "UPDATE S_PEMBAYARAN_SPPT set 
        denda_sppt=0, 
        jml_sppt_yg_dibayar=0
        where kd_propinsi='$kd_propinsi' and kd_dati2='$kd_dati2' and kd_kecamatan='$kd_kecamatan' and
        kd_kelurahan='$kd_kelurahan' and kd_blok='$kd_blok' and no_urut='$no_urut' and kd_jns_op = '$kd_jns_op'
        and thn_pajak_sppt = '$thn' and pembayaran_sppt_ke='$ke' ";
    $query = $this->db->query($sql);
    //
    $sql = "UPDATE S_SPPT set 
        status_pembayaran_sppt='0'
        where kd_propinsi='$kd_propinsi' and kd_dati2='$kd_dati2' and kd_kecamatan='$kd_kecamatan' and
        kd_kelurahan='$kd_kelurahan' and kd_blok='$kd_blok' and no_urut='$no_urut' and kd_jns_op = '$kd_jns_op'
        and thn_pajak_sppt = '$thn' ";
    $query = $this->db->query($sql);
    //
  }

  function get_salinan($nop, $thn)
  {

    $schema_pbb = $this->schema_pbb;
    $nop = preg_replace('/[^0-9]/', '', $nop);

    $kd_propinsi  = substr($nop, 0, 2);
    $kd_dati2     = substr($nop, 2, 2);
    $kd_kecamatan = substr($nop, 4, 3);
    $kd_kelurahan = substr($nop, 7, 3);
    $kd_blok      = substr($nop, 10, 3);
    $no_urut      = substr($nop, 13, 4);
    $kd_jns_op    = substr($nop, 17, 1);

    $sql   = "select ps.pembayaran_sppt_ke, s.nm_wp_sppt, s.jln_wp_sppt, s.rt_wp_sppt, s.rw_wp_sppt, s.kelurahan_wp_sppt,
        s.kota_wp_sppt, s.npwp_sppt, s.pbb_terhutang_sppt, s.faktor_pengurang_sppt, s.pbb_yg_harus_dibayar_sppt
        from S_PEMBAYARAN_SPPT ps
        inner join S_SPPT s on
        ps.kd_propinsi||ps.kd_dati2||ps.kd_kecamatan||ps.kd_kelurahan||ps.kd_blok||ps.no_urut||ps.kd_jns_op||ps.thn_pajak_sppt = s.kd_propinsi||s.kd_dati2||s.kd_kecamatan||s.kd_kelurahan||s.kd_blok||s.no_urut||s.kd_jns_op||s.thn_pajak_sppt
        where ps.kd_propinsi||ps.kd_dati2||ps.kd_kecamatan||ps.kd_kelurahan||ps.kd_blok||ps.no_urut||ps.kd_jns_op = '$nop'
        and ps.thn_pajak_sppt = '$thn' AND ROWNUM <= 1
        order by ps.pembayaran_sppt_ke desc ";
    $query = $this->db->query($sql);
    if ($query->num_rows() !== 0) {
      return $query->row();
    } else
      return FALSE;
  }

  function get_salinan_masal_by_nop($blok, $blok2, $thn)
  {

    $schema_pbb = $this->schema_pbb;
    $field = pos_kolom("ps");
    $join  = pos_join("ps", "tp");

    $blok = urldecode($blok);
    $blok = preg_replace('/[^0-9]/', '', $blok);

    $kd_propinsi   = substr($blok, 0, 2);
    $kd_dati2      = substr($blok, 2, 2);
    $kd_kecamatan  = substr($blok, 4, 3);
    $kd_kelurahan  = substr($blok, 7, 3);
    $kd_blok       = substr($blok, 10, 3);
    $no_urut       = substr($blok, 13, 4);
    $kd_jenis      = substr($blok, 17, 1);

    $blok2          = urldecode($blok2);
    $blok2          = preg_replace('/[^0-9]/', '', $blok2);

    $no_urut_2      = substr($blok2, 0, 4);
    $kd_jenis_2     = substr($blok2, 4, 1);

    $sql = "select s.kd_propinsi||'.'|| s.kd_dati2||'.'||s.kd_kecamatan||'.'|| s.kd_kelurahan||'-'||s.kd_blok||'.'|| s.no_urut||'.'||s.kd_jns_op as kode, 
      s.thn_pajak_sppt, s.nm_wp_sppt, s.jln_wp_sppt, s.rt_wp_sppt, s.rw_wp_sppt, 
      s.kelurahan_wp_sppt, s.kota_wp_sppt, s.npwp_sppt, s.pbb_terhutang_sppt, s.faktor_pengurang_sppt,
      s.pbb_yg_harus_dibayar_sppt, jml_sppt_yg_dibayar, s.tgl_jatuh_tempo_sppt, ps.pembayaran_sppt_ke,
      ps.tgl_pembayaran_sppt, kec.nm_kecamatan, kel.nm_kelurahan, ps.denda_sppt, s.luas_bumi_sppt, 
      s.luas_bng_sppt,s.blok_kav_no_wp_sppt, prop.nm_propinsi, dt2.nm_dati2, ps.user_id, {$field}, tp.nm_tp
      from S_PEMBAYARAN_SPPT ps
      inner join S_SPPT s on ps.kd_propinsi=s.kd_propinsi and ps.kd_dati2=s.kd_dati2 and ps.kd_kecamatan=s.kd_kecamatan 
      and ps.kd_kelurahan=s.kd_kelurahan and ps.kd_blok=s.kd_blok and ps.no_urut=s.no_urut 
      and ps.kd_jns_op=s.kd_jns_op and ps.thn_pajak_sppt=s.thn_pajak_sppt
      inner join S_REF_KECAMATAN kec on s.kd_propinsi=kec.kd_propinsi and s.kd_dati2=kec.kd_dati2 and s.kd_kecamatan=kec.kd_kecamatan
      inner join S_REF_KELURAHAN kel on s.kd_propinsi=kel.kd_propinsi and s.kd_dati2=kel.kd_dati2 
      and s.kd_kecamatan=kel.kd_kecamatan and s.kd_kelurahan=kel.kd_kelurahan
      left join S_TEMPAT_PEMBAYARAN tp on {$join}
      inner join S_REF_PROPINSI prop on s.kd_propinsi=prop.kd_propinsi
      inner join S_REF_DATI2 dt2 on s.kd_propinsi=dt2.kd_propinsi and s.kd_dati2=dt2.kd_dati2
      where 
      ps.kd_propinsi='{$kd_propinsi}' and ps.kd_dati2='{$kd_dati2}' and ps.kd_kecamatan='{$kd_kecamatan}' and
      ps.kd_kelurahan='{$kd_kelurahan}' and ps.kd_blok='{$kd_blok}' and ps.no_urut BETWEEN '{$no_urut}' AND '{$no_urut_2}'
      and ps.thn_pajak_sppt = '{$thn}'
      order by ps.pembayaran_sppt_ke desc";

    $query = $this->db->query($sql);

    $result['sql']      = $sql;
    $result['query']    = $query->result_array();
    $result['num_rows'] = $query->num_rows();
    $result['tot_rows'] = $query->num_rows();
    return $result;
  }

  function get_salinan_masal_by_tgl($tgl1, $tgl2)
  {

    $schema_pbb = $this->schema_pbb;
    $field = pos_kolom("ps");
    $join = pos_join("ps", "tp");
    //
    $sql = "select s.kd_propinsi||'.'|| s.kd_dati2||'.'||s.kd_kecamatan||'.'|| s.kd_kelurahan||'-'||s.kd_blok||'.'|| s.no_urut||'.'||s.kd_jns_op as kode, s.thn_pajak_sppt,
        s.nm_wp_sppt, s.jln_wp_sppt, s.rt_wp_sppt, s.rw_wp_sppt, s.kelurahan_wp_sppt, s.kota_wp_sppt, s.npwp_sppt,
        s.pbb_terhutang_sppt, s.faktor_pengurang_sppt, s.pbb_yg_harus_dibayar_sppt, jml_sppt_yg_dibayar, s.tgl_jatuh_tempo_sppt,
        ps.pembayaran_sppt_ke, ps.tgl_pembayaran_sppt,
        kec.nm_kecamatan, kel.nm_kelurahan, ps.denda_sppt, s.luas_bumi_sppt, s.luas_bng_sppt,
        s.blok_kav_no_wp_sppt, prop.nm_propinsi, dt2.nm_dati2, ps.user_id, {$field}, tp.nm_tp
        from S_PEMBAYARAN_SPPT ps
        inner join S_SPPT s on ps.kd_propinsi=s.kd_propinsi and ps.kd_dati2=s.kd_dati2 
        and ps.kd_kecamatan=s.kd_kecamatan and ps.kd_kelurahan=s.kd_kelurahan and ps.kd_blok=s.kd_blok 
        and ps.no_urut=s.no_urut and ps.kd_jns_op=s.kd_jns_op and ps.thn_pajak_sppt=s.thn_pajak_sppt
        inner join S_REF_KECAMATAN kec on s.kd_propinsi=kec.kd_propinsi and s.kd_dati2=kec.kd_dati2 
        and s.kd_kecamatan=kec.kd_kecamatan
        inner join S_REF_KELURAHAN kel on s.kd_propinsi=kel.kd_propinsi and s.kd_dati2=kel.kd_dati2 
        and s.kd_kecamatan=kel.kd_kecamatan and s.kd_kelurahan=kel.kd_kelurahan
        left join S_TEMPAT_PEMBAYARAN tp on {$join}
        inner join S_REF_PROPINSI prop on s.kd_propinsi=prop.kd_propinsi
        inner join S_REF_DATI2 dt2 on s.kd_propinsi=dt2.kd_propinsi and s.kd_dati2=dt2.kd_dati2
        where 
        ps.tgl_pembayaran_sppt between '{$tgl1}' and '{$tgl2}'
        order by tgl_pembayaran_sppt, ps.pembayaran_sppt_ke desc";
    $query = $this->db->query($sql);;

    $result['sql']      = $sql;
    $result['query']    = $query->result_array();
    $result['num_rows'] = $query->num_rows();
    $result['tot_rows'] = $query->num_rows();

    return $result;
  }
}

/* End of file _model.php */
