<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class pst_sppt_pembatalan_model extends CI_Model
{
    private $tbl = 'SPPT';
    private $schema_pbb = SCHEMA_PBB . ".";

    function __construct()
    {
        parent::__construct();
    }

    function cek_nopel_pembayaran($nop, $thn, $tahun_p, $bundel_p, $urut_p, $pmb_ke, $angs_p, $jns_ply)
    {

        $schema_pbb = $this->schema_pbb;
        // cari ada no bayar di dok. pengurang
        // get_by_nopel_peng
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

        $filter = " ";
        if ($jns_ply == '1') {
            $filter = " AND KD_PELAYANAN='10' ";
        } else if ($jns_ply == '2') {
            $filter = " AND KD_PELAYANAN='07' ";
        } else if ($jns_ply == '3') {
            $filter = " AND KD_PELAYANAN='15' AND CICILAN_KE=" . $angs_p;
        }
        //
        $field = pos_kolom("ps");
        $join  = pos_join("ps", "tp");
        $tgl_now = current_date();

        $userlogin = lda_user_login();
        $isgrup_admin = $this->load->model('user_pbb_model')->get_isgrup_admin($userlogin);
        // cek jika bukan grup admin
        $filter_tgl = "";
        $kd_kanwil = $this->session->userdata('kd_kanwil');
        $kd_kantor = $this->session->userdata('kd_kantor');
        $kd_tp     = $this->session->userdata('kd_tp');

        if ($isgrup_admin == FALSE) {
            $filter_tgl  = " AND (trunc(TGL_BAYAR) between trunc(sysdate-1) and trunc(sysdate) )
          and KD_KANWIL='{$kd_kanwil}' and KD_KANTOR='{$kd_kantor}' and KD_TP_BAYAR='{$kd_tp}' ";
        }
        //
        $sql = "SELECT ID as BAYAR_ID
      FROM HIST_PEMBAYARAN_SPPT
      WHERE THN_PELAYANAN='$tahun_p' AND BUNDEL_PELAYANAN='$bundel_p' AND NO_URUT_PELAYANAN='$urut_p' and
      KD_PROPINSI='$kd_propinsi' and KD_DATI2='$kd_dati2' and KD_KECAMATAN='$kd_kecamatan' and
      KD_KELURAHAN='$kd_kelurahan' and KD_BLOK='$kd_blok' and NO_URUT='$no_urut' and KD_JNS_OP='$kd_jns_op' AND
      THN_PAJAK_SPPT='$thn' AND PEMBAYARAN_SPPT_KE='$pmb_ke' AND STS_BAYAR=1 AND NILAI_BAYAR>0  
      $filter_tgl AND ROWNUM<=1 $filter ";
        $query = $this->db->query($sql);
        if ($query->num_rows() != 0) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    function get_nopel_hapus_btl($nop, $thn, $tahun_p, $bundel_p, $urut_p, $pmb_ke)
    {

        $schema_pbb = $this->schema_pbb;
        // get_by_nopel_peng
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

        $userlogin = lda_user_login();
        $isgrup_admin = $this->load->model('user_pbb_model')->get_isgrup_admin($userlogin);
        // cek jika bukan grup admin
        $filter_tgl = "";
        if ($isgrup_admin == FALSE) {
            $filter_tgl  = " (trunc(ps.tgl_pembayaran_sppt) between trunc(sysdate-1) and trunc(sysdate)) and ";
        }
        //
        $sql = "select s.kd_propinsi, s.kd_dati2, s.kd_kecamatan, s.kd_kelurahan, s.kd_blok, s.no_urut, s.kd_jns_op ,
      s.thn_pajak_sppt, ps.pembayaran_sppt_ke, s.nm_wp_sppt, s.jln_wp_sppt, s.rt_wp_sppt, s.rw_wp_sppt,
      s.kelurahan_wp_sppt, s.kota_wp_sppt, s.npwp_sppt, ps.tgl_pembayaran_sppt, ps.denda_sppt,
      s.pbb_terhutang_sppt, s.faktor_pengurang_sppt, s.pbb_yg_harus_dibayar_sppt, s.tgl_jatuh_tempo_sppt,
      ps.denda_sppt  denda_sppt, ps.jml_sppt_yg_dibayar  jml_sppt_yg_dibayar,  kec.nm_kecamatan, kel.nm_kelurahan,
      s.tgl_jatuh_tempo_sppt, s.luas_bumi_sppt, s.luas_bng_sppt, dt2.nm_dati2,prop.nm_propinsi, 
      s.blok_kav_no_wp_sppt, ps.NIP_REKAM_BYR_SPPT,
      $field , tp.nm_tp, pst.dummy_id as id_p, ps.pembayaran_sppt_ke as pmbke
      from S_SPPT s
      join S_PEMBAYARAN_SPPT ps on s.kd_propinsi=ps.kd_propinsi and s.kd_dati2=ps.kd_dati2 
          and s.kd_kecamatan=ps.kd_kecamatan and s.kd_kelurahan=ps.kd_kelurahan and s.kd_blok=ps.kd_blok 
          and s.no_urut=ps.no_urut and s.kd_jns_op = ps.kd_jns_op and s.thn_pajak_sppt = ps.thn_pajak_sppt
      join S_pst_permohonan_pengurangan pst on s.kd_propinsi=pst.kd_propinsi_pemohon and s.kd_dati2=pst.kd_dati2_pemohon 
          and s.kd_kecamatan=pst.kd_kecamatan_pemohon and s.kd_kelurahan=pst.kd_kelurahan_pemohon 
          and s.kd_blok=pst.kd_blok_pemohon and s.no_urut=pst.no_urut_pemohon and s.kd_jns_op = pst.kd_jns_op_pemohon
      left join S_REF_PROPINSI prop on s.kd_propinsi=prop.kd_propinsi
      left join S_REF_DATI2 dt2 on s.kd_propinsi=dt2.kd_propinsi and s.kd_dati2=dt2.kd_dati2
      left join S_REF_KECAMATAN kec on s.kd_propinsi=kec.kd_propinsi and s.kd_dati2=kec.kd_dati2 and s.kd_kecamatan=kec.kd_kecamatan
      left join S_REF_KELURAHAN kel on s.kd_propinsi=kel.kd_propinsi and s.kd_dati2=kel.kd_dati2 
          and s.kd_kecamatan=kel.kd_kecamatan and s.kd_kelurahan=kel.kd_kelurahan
      left join S_TEMPAT_PEMBAYARAN tp on $join
      where " . $filter_tgl . "  
      s.kd_propinsi='$kd_propinsi' and s.kd_dati2='$kd_dati2' and s.kd_kecamatan='$kd_kecamatan' and
      s.kd_kelurahan='$kd_kelurahan' and s.kd_blok='$kd_blok' and s.no_urut='$no_urut' and s.kd_jns_op = '$kd_jns_op'
      and s.thn_pajak_sppt = '$thn' 
      and pst.thn_pelayanan = '$tahun_p' and pst.bundel_pelayanan = '$bundel_p' 
      and pst.no_urut_pelayanan = '$urut_p' and ps.pembayaran_sppt_ke='$pmb_ke' 
      and ps.jml_sppt_yg_dibayar != '0' ";

        $query = $this->db->query($sql);
        if ($query->num_rows() != 0) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    function get_nopel_berat_btl($nop, $thn, $tahun_p, $bundel_p, $urut_p, $pmb_ke)
    {

        $schema_pbb = $this->schema_pbb;
        //get_by_nopel_keb
        // batal keberatan
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

        $userlogin = lda_user_login();
        $isgrup_admin = $this->load->model('user_pbb_model')->get_isgrup_admin($userlogin);
        // cek jika bukan grup admin
        $filter_tgl = "";
        if ($isgrup_admin == FALSE) {
            $filter_tgl  = " (trunc(ps.tgl_pembayaran_sppt) between trunc(sysdate-1) and trunc(sysdate)) and ";
        }

        $sql = "select s.kd_propinsi, s.kd_dati2, s.kd_kecamatan, s.kd_kelurahan, s.kd_blok, s.no_urut, s.kd_jns_op ,
      s.thn_pajak_sppt, ps.pembayaran_sppt_ke, s.nm_wp_sppt, s.jln_wp_sppt, s.rt_wp_sppt, s.rw_wp_sppt,
      s.kelurahan_wp_sppt, s.kota_wp_sppt, s.npwp_sppt, ps.tgl_pembayaran_sppt, ps.denda_sppt,
      s.pbb_terhutang_sppt, s.faktor_pengurang_sppt, s.pbb_yg_harus_dibayar_sppt, s.tgl_jatuh_tempo_sppt,
      ps.denda_sppt  denda_sppt, ps.jml_sppt_yg_dibayar  jml_sppt_yg_dibayar,  kec.nm_kecamatan, kel.nm_kelurahan,
      s.tgl_jatuh_tempo_sppt, s.luas_bumi_sppt, s.luas_bng_sppt, 
      dt2.nm_dati2,prop.nm_propinsi, s.blok_kav_no_wp_sppt, ps.NIP_REKAM_BYR_SPPT,
      $field , tp.nm_tp, pst.dummy_id as id_p, ps.pembayaran_sppt_ke as pmbke
      from S_SPPT s
      inner join S_PEMBAYARAN_SPPT ps on
      s.kd_propinsi=ps.kd_propinsi and s.kd_dati2=ps.kd_dati2 and s.kd_kecamatan=ps.kd_kecamatan 
      and s.kd_kelurahan=ps.kd_kelurahan and s.kd_blok=ps.kd_blok and s.no_urut=ps.no_urut 
      and s.kd_jns_op = ps.kd_jns_op and s.thn_pajak_sppt = ps.thn_pajak_sppt
      join S_pst_permohonan_keberatan pst on
      s.kd_propinsi=pst.kd_propinsi_pemohon and s.kd_dati2=pst.kd_dati2_pemohon and 
      s.kd_kecamatan=pst.kd_kecamatan_pemohon and s.kd_kelurahan=pst.kd_kelurahan_pemohon and 
      s.kd_blok=pst.kd_blok_pemohon and s.no_urut=pst.no_urut_pemohon and s.kd_jns_op = pst.kd_jns_op_pemohon
      inner join S_REF_PROPINSI prop on s.kd_propinsi=prop.kd_propinsi
      inner join S_REF_DATI2 dt2 on s.kd_propinsi=dt2.kd_propinsi and s.kd_dati2=dt2.kd_dati2
      inner join S_REF_KECAMATAN kec on
      s.kd_propinsi=kec.kd_propinsi and s.kd_dati2=kec.kd_dati2 and s.kd_kecamatan=kec.kd_kecamatan
      inner join S_REF_KELURAHAN kel on
      s.kd_propinsi=kel.kd_propinsi and s.kd_dati2=kel.kd_dati2 and s.kd_kecamatan=kel.kd_kecamatan
      and s.kd_kelurahan=kel.kd_kelurahan
      left join S_TEMPAT_PEMBAYARAN tp on $join
      where " . $filter_tgl . "  
      s.kd_propinsi='$kd_propinsi' and s.kd_dati2='$kd_dati2' and s.kd_kecamatan='$kd_kecamatan' and
      s.kd_kelurahan='$kd_kelurahan' and s.kd_blok='$kd_blok' and s.no_urut='$no_urut' and s.kd_jns_op = '$kd_jns_op'
      and s.thn_pajak_sppt = '$thn' 
      and pst.thn_pelayanan = '$tahun_p' and pst.bundel_pelayanan = '$bundel_p' 
      and pst.no_urut_pelayanan = '$urut_p' and ps.pembayaran_sppt_ke='$pmb_ke' 
      and ps.jml_sppt_yg_dibayar != '0' ";
        $query = $this->db->query($sql);
        if ($query->num_rows() != 0) {
            return $query->row();
        } else {
            return FALSE;
        }
    }


    function get_nopel_angsur_btl($nop, $thn, $tahun_p, $bundel_p, $urut_p, $angs_p, $pmb_ke)
    {

        $schema_pbb = $this->schema_pbb;
        //get_by_nopel_angs
        //  batal pembayaran angsuran
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

        $userlogin = lda_user_login();
        $isgrup_admin = $this->load->model('user_pbb_model')->get_isgrup_admin($userlogin);
        // cek jika bukan grup admin
        $filter_tgl = "";
        if ($isgrup_admin == FALSE) {
            $filter_tgl  = " (trunc(ps.tgl_pembayaran_sppt) between trunc(sysdate-1) and trunc(sysdate)) and ";
        }
        //
        $sql = " select q1.* from (
      select s.kd_propinsi, s.kd_dati2, s.kd_kecamatan, s.kd_kelurahan, s.kd_blok, s.no_urut, s.kd_jns_op ,
      s.thn_pajak_sppt, ps.pembayaran_sppt_ke, s.nm_wp_sppt, s.jln_wp_sppt, s.rt_wp_sppt, s.rw_wp_sppt,
      s.kelurahan_wp_sppt, s.kota_wp_sppt, s.npwp_sppt, ps.tgl_pembayaran_sppt, ps.denda_sppt,
      s.pbb_terhutang_sppt, s.faktor_pengurang_sppt, s.pbb_yg_harus_dibayar_sppt, s.tgl_jatuh_tempo_sppt,
      ps.jml_sppt_yg_dibayar  jml_sppt_yg_dibayar,  kec.nm_kecamatan, kel.nm_kelurahan,
      s.luas_bumi_sppt, s.luas_bng_sppt, dt2.nm_dati2,prop.nm_propinsi, s.blok_kav_no_wp_sppt, ps.NIP_REKAM_BYR_SPPT,
      $field , tp.nm_tp, pst.dummy_id as id_p, ps.pembayaran_sppt_ke as pmbke, pba.CICILAN_KE as angske 
      from S_SPPT s
      inner join S_PEMBAYARAN_SPPT ps on
      s.kd_propinsi=ps.kd_propinsi and s.kd_dati2=ps.kd_dati2 and s.kd_kecamatan=ps.kd_kecamatan 
      and s.kd_kelurahan=ps.kd_kelurahan and s.kd_blok=ps.kd_blok and s.no_urut=ps.no_urut 
      and s.kd_jns_op = ps.kd_jns_op
      and s.thn_pajak_sppt = ps.thn_pajak_sppt
      join S_pst_permohonan_angsuran pst on s.kd_propinsi=pst.kd_propinsi_pemohon and s.kd_dati2=pst.kd_dati2_pemohon 
      and s.kd_kecamatan=pst.kd_kecamatan_pemohon and s.kd_kelurahan=pst.kd_kelurahan_pemohon 
      and s.kd_blok=pst.kd_blok_pemohon and s.no_urut=pst.no_urut_pemohon and s.kd_jns_op = pst.kd_jns_op_pemohon
      join HIST_PEMBAYARAN_SPPT pba on s.kd_propinsi=pba.kd_propinsi and s.kd_dati2=pba.kd_dati2 
      and s.kd_kecamatan=pba.kd_kecamatan and s.kd_kelurahan=pba.kd_kelurahan 
      and s.kd_blok=pba.kd_blok and s.no_urut=pba.no_urut 
      and s.kd_jns_op=pba.kd_jns_op and s.thn_pajak_sppt=pba.thn_pajak_sppt        
      and pst.thn_pelayanan=pba.thn_pelayanan and pst.bundel_pelayanan=pba.bundel_pelayanan
      and pst.no_urut_pelayanan=pba.no_urut_pelayanan
      join S_REF_PROPINSI prop on s.kd_propinsi=prop.kd_propinsi
      join S_REF_DATI2 dt2 on s.kd_propinsi=dt2.kd_propinsi and s.kd_dati2=dt2.kd_dati2
      join S_REF_KECAMATAN kec on s.kd_propinsi=kec.kd_propinsi and s.kd_dati2=kec.kd_dati2 and s.kd_kecamatan=kec.kd_kecamatan
      join S_REF_KELURAHAN kel on s.kd_propinsi=kel.kd_propinsi and s.kd_dati2=kel.kd_dati2 and s.kd_kecamatan=kel.kd_kecamatan
      and s.kd_kelurahan=kel.kd_kelurahan
      left join S_TEMPAT_PEMBAYARAN tp on $join
      where " . $filter_tgl . "  
      pba.KD_PELAYANAN='15' and
      s.kd_propinsi='$kd_propinsi' and s.kd_dati2='$kd_dati2' and s.kd_kecamatan='$kd_kecamatan' and
      s.kd_kelurahan='$kd_kelurahan' and s.kd_blok='$kd_blok' and s.no_urut='$no_urut' and s.kd_jns_op = '$kd_jns_op'
      and s.thn_pajak_sppt = '$thn' 
      and pst.thn_pelayanan = '$tahun_p' and pst.bundel_pelayanan = '$bundel_p' 
      and pst.no_urut_pelayanan = '$urut_p' 
      and ps.jml_sppt_yg_dibayar != '0'
      and pba.CICILAN_KE=$angs_p and pba.STS_BAYAR=1
      and pba.PEMBAYARAN_SPPT_KE=$pmb_ke
      ) q1 where rownum<=1 and q1.pmbke='$pmb_ke' ";
        $query = $this->db->query($sql);
        if ($query->num_rows() != 0) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    // BATAL PEMBAYARAN
    function cancel_nop_penghapusan($thn_p, $bundel_p, $urt_p, $nop, $thn, $ke, $byr_id)
    {

        $schema_pbb = $this->schema_pbb;
        //$tabel      = $schema_pbb.".PEMBAYARAN_SPPT";

        $nop = urldecode($nop);
        $nop = preg_replace('/[^0-9]/', '', $nop);

        $kd_propinsi = substr($nop, 0, 2);
        $kd_dati2 = substr($nop, 2, 2);
        $kd_kecamatan = substr($nop, 4, 3);
        $kd_kelurahan = substr($nop, 7, 3);
        $kd_blok = substr($nop, 10, 3);
        $no_urut = substr($nop, 13, 4);
        $kd_jns_op = substr($nop, 17, 1);
        //
        $siuser = lda_user_id();
        $user_batal = lda_user_login();
        $nip_batal  = $this->session->userdata('nip');
        $tgl_batal  = current_date(); //date('Y-m-d');
        $jam_batal  = current_time(); //date('Y-m-d h:i:sa');
        //
        $tgl_batal  = "TO_DATE('" . $tgl_batal . "', 'YYYY-MM-DD')";
        $jam_batal  = "TO_DATE('" . $jam_batal . "', 'YYYY-MM-DD HH24:MI:SS')";
        //
        $kd_kanwil = $this->session->userdata('kd_kanwil');
        $kd_kantor = $this->session->userdata('kd_kantor');
        $kd_tp     = $this->session->userdata('kd_tp');
        //
        $userid = $this->session->userdata('userid');
        //
        $sql_01 = "UPDATE S_PEMBAYARAN_SPPT set denda_sppt=0, jml_sppt_yg_dibayar=0
        where KD_PROPINSI='$kd_propinsi' and KD_DATI2='$kd_dati2' and KD_KECAMATAN='$kd_kecamatan' and
        KD_KELURAHAN='$kd_kelurahan' and KD_BLOK='$kd_blok' and NO_URUT='$no_urut' and KD_JNS_OP = '$kd_jns_op'
        and THN_PAJAK_SPPT = '$thn' and PEMBAYARAN_SPPT_KE='$ke' ";
        //$query = $this->db->query($sql);
        $result_01 = 'default error';
        $result_01 = $this->db->simple_qry_eon_ora($sql_01);

        //PST_BYR_PENGURANGAN
        $sql_02 = "UPDATE HIST_PEMBAYARAN_SPPT SET 
        NILAI_BAYAR_BTL=HIST_PEMBAYARAN_SPPT.NILAI_BAYAR, DENDA_SPPT_BTL=HIST_PEMBAYARAN_SPPT.DENDA_SPPT,
        DENDA_SPPT=0, NILAI_BAYAR=0, TGL_BATAL=" . $tgl_batal . ", UPDATED_DATE=" . $jam_batal . ", 
        USERID_BATAL='$user_batal', NIP_BATAL='$nip_batal', KD_TP_BATAL='$kd_tp', STS_BAYAR=2       
        WHERE STS_BAYAR=1 and THN_PELAYANAN='$thn_p' and BUNDEL_PELAYANAN='$bundel_p' and NO_URUT_PELAYANAN='$urt_p' and
        KD_PROPINSI='$kd_propinsi' and KD_DATI2='$kd_dati2' and KD_KECAMATAN='$kd_kecamatan' and KD_PELAYANAN='10' and
        KD_KELURAHAN='$kd_kelurahan' and KD_BLOK='$kd_blok' and NO_URUT='$no_urut' and KD_JNS_OP= '$kd_jns_op'
        and THN_PAJAK_SPPT = '$thn' and PEMBAYARAN_SPPT_KE='$ke' and ID=$byr_id";
        //$query = $this->db->query($sql); 
        $result_02 = 'default error';
        if (empty($result_01)) {
            $result_02 = $this->db->simple_qry_eon_ora($sql_02);
        }
        //
    }

    function cancel_nop_keberatan($thn_p, $bundel_p, $urt_p, $nop, $thn, $ke, $byr_id)
    {

        $schema_pbb = $this->schema_pbb;
        //$tabel      = $schema_pbb.".PEMBAYARAN_SPPT";

        $nop = urldecode($nop);
        $nop = preg_replace('/[^0-9]/', '', $nop);

        $kd_propinsi = substr($nop, 0, 2);
        $kd_dati2 = substr($nop, 2, 2);
        $kd_kecamatan = substr($nop, 4, 3);
        $kd_kelurahan = substr($nop, 7, 3);
        $kd_blok = substr($nop, 10, 3);
        $no_urut = substr($nop, 13, 4);
        $kd_jns_op = substr($nop, 17, 1);
        //
        $siuser = lda_user_id();
        $user_batal = lda_user_login();
        $nip_batal  = $this->session->userdata('nip');
        $tgl_batal  = current_date(); //date('Y-m-d');
        $jam_batal  = current_time(); //date('Y-m-d h:i:sa');
        //
        $tgl_batal  = "TO_DATE('" . $tgl_batal . "', 'YYYY-MM-DD')";
        $jam_batal  = "TO_DATE('" . $jam_batal . "', 'YYYY-MM-DD HH24:MI:SS')";
        //
        $kd_kanwil = $this->session->userdata('kd_kanwil');
        $kd_kantor = $this->session->userdata('kd_kantor');
        $kd_tp     = $this->session->userdata('kd_tp');
        //
        $userid = $this->session->userdata('userid');
        //
        $sql_01 = "UPDATE S_PEMBAYARAN_SPPT set denda_sppt=0, jml_sppt_yg_dibayar=0
        where KD_PROPINSI='$kd_propinsi' and KD_DATI2='$kd_dati2' and KD_KECAMATAN='$kd_kecamatan' and
        KD_KELURAHAN='$kd_kelurahan' and KD_BLOK='$kd_blok' and NO_URUT='$no_urut' and KD_JNS_OP = '$kd_jns_op'
        and THN_PAJAK_SPPT = '$thn' and PEMBAYARAN_SPPT_KE='$ke' ";
        //$query = $this->db->query($sql);
        $result_01 = 'default error';
        $result_01 = $this->db->simple_qry_eon_ora($sql_01);

        //PST_BYR_KEBERATAN
        $sql_02 = "UPDATE HIST_PEMBAYARAN_SPPT SET 
        NILAI_BAYAR_BTL=HIST_PEMBAYARAN_SPPT.NILAI_BAYAR, DENDA_SPPT_BTL=HIST_PEMBAYARAN_SPPT.DENDA_SPPT,
        DENDA_SPPT=0, NILAI_BAYAR=0, TGL_BATAL=" . $tgl_batal . ", UPDATED_DATE=" . $jam_batal . ", 
        USERID_BATAL='$user_batal', NIP_BATAL='$nip_batal', KD_TP_BATAL='$kd_tp', STS_BAYAR=2       
        WHERE STS_BAYAR=1 and THN_PELAYANAN='$thn_p' and BUNDEL_PELAYANAN='$bundel_p' and NO_URUT_PELAYANAN='$urt_p' and
        KD_PROPINSI='$kd_propinsi' and KD_DATI2='$kd_dati2' and KD_KECAMATAN='$kd_kecamatan' and KD_PELAYANAN='07' and
        KD_KELURAHAN='$kd_kelurahan' and KD_BLOK='$kd_blok' and NO_URUT='$no_urut' and KD_JNS_OP = '$kd_jns_op'
        and THN_PAJAK_SPPT = '$thn' and PEMBAYARAN_SPPT_KE='$ke' and ID=$byr_id";
        //$query = $this->db->query($sql);
        $result_02 = 'default error';
        if (empty($result_01)) {
            $result_02 = $this->db->simple_qry_eon_ora($sql_02);
        }
        //
    }

    function cancel_nop_angsuran($thn_p, $bundel_p, $urt_p, $nop, $thn, $ke, $angs_p, $byr_id)
    {

        $schema_pbb = $this->schema_pbb;
        //$tabel      = $schema_pbb.".PEMBAYARAN_SPPT";

        $nop = urldecode($nop);
        $nop = preg_replace('/[^0-9]/', '', $nop);

        $kd_propinsi = substr($nop, 0, 2);
        $kd_dati2 = substr($nop, 2, 2);
        $kd_kecamatan = substr($nop, 4, 3);
        $kd_kelurahan = substr($nop, 7, 3);
        $kd_blok = substr($nop, 10, 3);
        $no_urut = substr($nop, 13, 4);
        $kd_jns_op = substr($nop, 17, 1);
        //
        $siuser = lda_user_id();
        $user_batal = lda_user_login();
        $nip_batal  = $this->session->userdata('nip');
        $tgl_batal  = current_date(); //date('Y-m-d');
        $jam_batal  = current_time(); //date('Y-m-d h:i:sa');
        //
        $tgl_batal  = "TO_DATE('" . $tgl_batal . "', 'YYYY-MM-DD')";
        $jam_batal  = "TO_DATE('" . $jam_batal . "', 'YYYY-MM-DD HH24:MI:SS')";
        //
        $kd_kanwil = $this->session->userdata('kd_kanwil');
        $kd_kantor = $this->session->userdata('kd_kantor');
        $kd_tp     = $this->session->userdata('kd_tp');
        //
        $userid = $this->session->userdata('userid');
        //
        $sql_01 = "UPDATE S_PEMBAYARAN_SPPT set denda_sppt=0, jml_sppt_yg_dibayar=0
        where KD_PROPINSI='$kd_propinsi' and KD_DATI2='$kd_dati2' and KD_KECAMATAN='$kd_kecamatan' and
        KD_KELURAHAN='$kd_kelurahan' and KD_BLOK='$kd_blok' and NO_URUT='$no_urut' and KD_JNS_OP = '$kd_jns_op'
        and THN_PAJAK_SPPT = '$thn' and PEMBAYARAN_SPPT_KE='$ke' ";
        //$query = $this->db->query($sql);
        $result_01 = 'default error';
        //log_message('info', " dddddddddddddddddddddddddddddddddddddddddddddddddd   : ".$sql_01);
        $result_01 = $this->db->simple_qry_eon_ora($sql_01);

        // update sts batal
        $sql_02 = "UPDATE HIST_PEMBAYARAN_SPPT SET 
        NILAI_BAYAR_BTL=HIST_PEMBAYARAN_SPPT.NILAI_BAYAR, DENDA_SPPT_BTL=HIST_PEMBAYARAN_SPPT.DENDA_SPPT,
        DENDA_SPPT=0, NILAI_BAYAR=0, TGL_BATAL=" . $tgl_batal . ", UPDATED_DATE=" . $jam_batal . ", 
        USERID_BATAL='$user_batal', NIP_BATAL='$nip_batal', KD_TP_BATAL='$kd_tp', STS_BAYAR=2       
        WHERE STS_BAYAR=1 and THN_PELAYANAN='$thn_p' and BUNDEL_PELAYANAN='$bundel_p' and NO_URUT_PELAYANAN='$urt_p' and
        KD_PROPINSI='$kd_propinsi' and KD_DATI2='$kd_dati2' and KD_KECAMATAN='$kd_kecamatan' and KD_PELAYANAN='15' and
        KD_KELURAHAN='$kd_kelurahan' and KD_BLOK='$kd_blok' and NO_URUT='$no_urut' and KD_JNS_OP = '$kd_jns_op'
        and THN_PAJAK_SPPT = '$thn' and PEMBAYARAN_SPPT_KE='$ke' and CICILAN_KE=$angs_p and ID=$byr_id";
        //$query = $this->db->query($sql); 
        $result_02 = 'default error';
        //log_message('info', " eeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee   : ".$sql_02);
        if (empty($result_01)) {
            $result_02 = $this->db->simple_qry_eon_ora($sql_02);
        }
    }

    function cek_pmb_di_tengah($nop, $thn, $ke)
    {
        //
        // cek apakah pembayaran yg akan di batalkan , merupakan pembayaran terakhir
        $schema_pbb = $this->schema_pbb;
        //$tabel      = $schema_pbb.".PEMBAYARAN_SPPT";

        $nop = urldecode($nop);
        $nop = preg_replace('/[^0-9]/', '', $nop);

        $kd_propinsi = substr($nop, 0, 2);
        $kd_dati2 = substr($nop, 2, 2);
        $kd_kecamatan = substr($nop, 4, 3);
        $kd_kelurahan = substr($nop, 7, 3);
        $kd_blok = substr($nop, 10, 3);
        $no_urut = substr($nop, 13, 4);
        $kd_jns_op = substr($nop, 17, 1);
        //
        //cek pembatalan Pembayaran Pengurangan , berada di posisi Pembayaran ke terakhir
        $sql = "WITH detil AS (
        select PEMBAYARAN_SPPT_KE, JML_SPPT_YG_DIBAYAR
        FROM S_PEMBAYARAN_SPPT pmb
        WHERE 
        KD_PROPINSI='$kd_propinsi' and KD_DATI2='$kd_dati2' and KD_KECAMATAN='$kd_kecamatan' and
        KD_KELURAHAN='$kd_kelurahan' and KD_BLOK='$kd_blok' and NO_URUT='$no_urut' and 
        KD_JNS_OP = '$kd_jns_op' and THN_PAJAK_SPPT = '$thn' )
        select * from detil 
        WHERE detil.PEMBAYARAN_SPPT_KE > '$ke' and detil.JML_SPPT_YG_DIBAYAR > 0 and rownum<=1";
        $query = $this->db->query($sql);
        if ($query->num_rows() != 0) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    function cek_pmb_angs_di_tengah($thn_p, $bundel_p, $urt_p, $nop, $thn, $ke, $angs_p)
    {
        //
        // cek apakah pembayaran yg akan di batalkan , merupakan pembayaran terakhir
        $schema_pbb = $this->schema_pbb;
        //$tabel      = $schema_pbb.".PEMBAYARAN_SPPT";

        $nop = urldecode($nop);
        $nop = preg_replace('/[^0-9]/', '', $nop);

        $kd_propinsi = substr($nop, 0, 2);
        $kd_dati2 = substr($nop, 2, 2);
        $kd_kecamatan = substr($nop, 4, 3);
        $kd_kelurahan = substr($nop, 7, 3);
        $kd_blok = substr($nop, 10, 3);
        $no_urut = substr($nop, 13, 4);
        $kd_jns_op = substr($nop, 17, 1);
        //
        //cek pembatalan Pembayaran Angsuran , hrs berada di posisi Pembayaran ke terakhir 
        $sql = "with detil as (
        select STS_BAYAR, CICILAN_KE, PEMBAYARAN_SPPT_KE
        FROM HIST_PEMBAYARAN_SPPT pmb
        WHERE KD_PELAYANAN='15' and THN_PELAYANAN='$thn_p' and BUNDEL_PELAYANAN='$bundel_p' and NO_URUT_PELAYANAN='$urt_p' 
        and KD_PROPINSI='$kd_propinsi' and KD_DATI2='$kd_dati2' and KD_KECAMATAN='$kd_kecamatan' and
        KD_KELURAHAN='$kd_kelurahan' and KD_BLOK='$kd_blok' and NO_URUT='$no_urut' and 
        KD_JNS_OP = '$kd_jns_op' and THN_PAJAK_SPPT = '$thn' )
        select * from detil 
        WHERE detil.STS_BAYAR=1 and detil.CICILAN_KE > '$angs_p' and rownum<=1";
        $query = $this->db->query($sql);
        if ($query->num_rows() != 0) {
            return $query->row();
        } else {
            return FALSE;
        }
    }
}

/* End of file _model.php */
