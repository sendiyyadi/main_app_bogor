<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class payment_model extends CI_Model {

    private $tbl = 'SPPT';
    private $schema_pbb = SCHEMA_PBB.".";

    function __construct() {
        parent::__construct();
    }

    function xget_by_nop_thn_ke($nop, $thn, $ke) 
    {
        $schema_pbb = $this->schema_pbb;
        $nop=urldecode($nop);
        $nop=preg_replace( '/[^0-9]/', '', $nop );
        $kd_propinsi=substr($nop,0,2);
        $kd_dati2=substr($nop,2,2);
        $kd_kecamatan=substr($nop,4,3);
        $kd_kelurahan=substr($nop,7,3);
        $kd_blok=substr($nop,10,3);
        $no_urut=substr($nop,13,4);
        $kd_jns_op=substr($nop,17,1);

        $userid = $this->session->userdata('userid');

        $field = pos_kolom("ps");
        $join  = pos_join("ps","tp"); 
        $tgl_now = current_date();
        //$tgl_now = "2016-07-27";  //ARIG TEST NANTI DI REMARK

        $userlogin = lda_user_login();
        $isgrup_admin = $this->load->model('user_pbb_model')->get_isgrup_admin($userlogin);
        // cek jika bukan grup admin
        $filter_tgl = ""; 
        $kd_kanwil = $this->session->userdata('kd_kanwil');
        $kd_kantor = $this->session->userdata('kd_kantor');
        $kd_tp     = $this->session->userdata('kd_tp');

        if($isgrup_admin == FALSE) {
            $filter_tgl = " and trunc(ps.tgl_pembayaran_sppt)=to_date('$tgl_now','yyyy-mm-dd') and
            ps.KD_KANWIL='{$kd_kanwil}' and ps.KD_KANTOR='{$kd_kantor}' and ps.KD_TP='{$kd_tp}' ";
        }
        // 
        $sql = "SELECT s.kd_propinsi, s.kd_dati2, s.kd_kecamatan, s.kd_kelurahan, s.kd_blok, s.no_urut, s.kd_jns_op ,
        s.thn_pajak_sppt, ps.pembayaran_sppt_ke, s.nm_wp_sppt, s.jln_wp_sppt, s.rt_wp_sppt, s.rw_wp_sppt,
        s.kelurahan_wp_sppt, s.kota_wp_sppt, s.npwp_sppt, ps.tgl_pembayaran_sppt, ps.denda_sppt,
        s.pbb_terhutang_sppt, s.faktor_pengurang_sppt, s.pbb_yg_harus_dibayar_sppt, s.tgl_jatuh_tempo_sppt,
        ps.jml_sppt_yg_dibayar,  kec.nm_kecamatan, kel.nm_kelurahan, s.luas_bumi_sppt, s.luas_bng_sppt,
        dt2.nm_dati2,prop.nm_propinsi, s.blok_kav_no_wp_sppt, ps.NIP_REKAM_BYR_SPPT, $field , tp.nm_tp,
        nvl(cvd.FAKTOR_PENGURANG_BAYAR,0) as FAKTOR_PENGURANG_BAYAR
        from S_SPPT s
        join S_PEMBAYARAN_SPPT ps on s.kd_propinsi=ps.kd_propinsi and s.kd_dati2=ps.kd_dati2 
        and s.kd_kecamatan=ps.kd_kecamatan and s.kd_kelurahan=ps.kd_kelurahan and s.kd_blok=ps.kd_blok 
        and s.no_urut=ps.no_urut and s.kd_jns_op = ps.kd_jns_op and s.thn_pajak_sppt = ps.thn_pajak_sppt
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
        where 1=1 ".$filter_tgl."  
        and s.kd_propinsi='$kd_propinsi' and s.kd_dati2='$kd_dati2' and s.kd_kecamatan='$kd_kecamatan' and
        s.kd_kelurahan='$kd_kelurahan' and s.kd_blok='$kd_blok' and s.no_urut='$no_urut' and s.kd_jns_op = '$kd_jns_op'
        and s.thn_pajak_sppt = '$thn' and ps.pembayaran_sppt_ke='$ke' ";
        $query = $this->db->query($sql);

        if($query->num_rows()!=0){ return $query->row();}
        else{return FALSE;}
    }

}

/* End of file _model.php */
