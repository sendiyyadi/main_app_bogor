<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class batal_pembayaran_model extends CI_Model
{
    private $tbl = 'PEMBAYARAN_SPPT';
    private $schema_pbb = SCHEMA_PBB.".";
    
    function __construct() {

        parent::__construct();
    }

    function cek_byr_by_stts($nop, $thn, $ke) {

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
        //
        $userlogin = lda_user_login();
        $isgrup_admin = $this->load->model('user_pbb_model')->get_isgrup_admin($userlogin);
        // cek jika bukan grup admin
        $filter_tgl = ""; 
        $kd_kanwil = $this->session->userdata('kd_kanwil');
        $kd_kantor = $this->session->userdata('kd_kantor');
        $kd_tp     = $this->session->userdata('kd_tp');

        if($isgrup_admin == FALSE) {
            $filter_tgl = " and (trunc(pst.TGL_BAYAR)=to_date('$tgl_now','yyyy-mm-dd') )
            and pst.KD_KANWIL='{$kd_kanwil}' and pst.KD_KANTOR='{$kd_kantor}' and pst.KD_TP_BAYAR='{$kd_tp}' ";
        }

        //$usop = " 1=1 and "; // buat tes arig
        $sql = "select pst.*
        from HIST_PEMBAYARAN_SPPT pst 
        where pst.FLG_STTS in (1,2,3,4,5) and pst.STS_BAYAR=1 ".$filter_tgl."  
        and pst.kd_propinsi='$kd_propinsi' and pst.kd_dati2='$kd_dati2' and pst.kd_kecamatan='$kd_kecamatan' 
        and pst.kd_kelurahan='$kd_kelurahan' and pst.kd_blok='$kd_blok' and pst.no_urut='$no_urut' 
        and pst.kd_jns_op = '$kd_jns_op' and pst.thn_pajak_sppt = '$thn' and pst.pembayaran_sppt_ke='$ke' ";
        $query = $this->db->query($sql);
        if($query->num_rows()!=0){ return $query->row();}
        else{return FALSE;}
    }

    function batal_pembayaran_ke($nop, $thn, $ke, $byr_id) 
    {
        $schema_pbb = $this->schema_pbb;
        $nop=urldecode($nop);
        $nop=preg_replace( '/[^0-9]/', '', $nop );
        //
        $kd_propinsi=substr($nop,0,2);
        $kd_dati2=substr($nop,2,2);
        $kd_kecamatan=substr($nop,4,3);
        $kd_kelurahan=substr($nop,7,3);
        $kd_blok=substr($nop,10,3);
        $no_urut=substr($nop,13,4);
        $kd_jns_op=substr($nop,17,1);
        //
        //
        $siuser     = lda_user_id();
        $user_batal = lda_user_login();
        $nip_batal  = $this->session->userdata('nip');
        $tgl_batal  = current_date(); //date('Y-m-d');
        $jam_batal  = current_time(); //date('Y-m-d h:i:sa');
        //
        $tgl_btl  = "TO_DATE('".$tgl_batal."', 'YYYY-MM-DD')";
        $jam_btl  = "TO_DATE('".$jam_batal."', 'YYYY-MM-DD HH24:MI:SS')";
        //
        $kd_kanwil = $this->session->userdata('kd_kanwil');
        $kd_kantor = $this->session->userdata('kd_kantor');
        $kd_tp     = $this->session->userdata('kd_tp');
        //        
        $userid = $this->session->userdata('userid');
        //
        $nil_pengurang = 0;
        if($hist = $this->get_hist_bayar_stts($byr_id)){
            $nil_pengurang = floatval($hist->FAKTOR_PENGURANG_BAYAR);
        }
         /*
        $userlogin = lda_user_login();
        $isgrup_admin = $this->load->model('user_pbb_model')->get_isgrup_admin($userlogin);
        // cek jika bukan grup admin
        $filter_tgl = ""; 
        if($isgrup_admin == FALSE) {
            $filter_tgl = " trunc(ps.tgl_pembayaran_sppt)=to_date('$tgl_now','yyyy-mm-dd') and
            ps.KD_KANWIL='{$kd_kanwil}' and ps.KD_KANTOR='{$kd_kantor}' and ps.KD_TP_BAYAR='{$kd_tp}' and ";
        }
        */
        //
        $upd_spt = " 
        BEGIN
        UPDATE {$schema_pbb}SPPT S 
        SET FAKTOR_PENGURANG_SPPT = 0, PBB_YG_HARUS_DIBAYAR_SPPT = s.PBB_TERHUTANG_SPPT, STATUS_PEMBAYARAN_SPPT = '0'
        where s.kd_propinsi='$kd_propinsi' and s.kd_dati2='$kd_dati2' and s.kd_kecamatan='$kd_kecamatan' 
        and  s.kd_kelurahan='$kd_kelurahan' and s.kd_blok='$kd_blok' and s.no_urut='$no_urut' and s.kd_jns_op='$kd_jns_op'
        and s.thn_pajak_sppt = '$thn' and s.FAKTOR_PENGURANG_SPPT = $nil_pengurang and $nil_pengurang > 0 ;
        EXCEPTION WHEN OTHERS THEN RAISE_APPLICATION_ERROR(-20005,SQLCODE||' error : UPDATE SPPT GAGAL ...!'); 
        END;
        ";
        //
        if($nil_pengurang < 1){ $upd_spt = " ";}
        $upd_spt = " "; // ga jadi perubahan faktor pengurang sdh di handle di trigger pembayaran
        //
        $qry = "BEGIN
            BEGIN
            UPDATE {$schema_pbb}SPPT S 
            SET STATUS_PEMBAYARAN_SPPT = '0'
            where s.kd_propinsi='$kd_propinsi' and s.kd_dati2='$kd_dati2' and s.kd_kecamatan='$kd_kecamatan' 
            and  s.kd_kelurahan='$kd_kelurahan' and s.kd_blok='$kd_blok' and s.no_urut='$no_urut' and s.kd_jns_op='$kd_jns_op'
            and s.thn_pajak_sppt = '$thn' and s.FAKTOR_PENGURANG_SPPT = $nil_pengurang and $nil_pengurang > 0 ;
            EXCEPTION WHEN OTHERS THEN RAISE_APPLICATION_ERROR(-20005,SQLCODE||' error : UPDATE SPPT GAGAL ...!'); 
            END;

            BEGIN
            UPDATE {$schema_pbb}PEMBAYARAN_SPPT set denda_sppt=0, jml_sppt_yg_dibayar=0
            WHERE kd_propinsi='$kd_propinsi' and kd_dati2='$kd_dati2' and kd_kecamatan='$kd_kecamatan' and
            kd_kelurahan='$kd_kelurahan' and kd_blok='$kd_blok' and no_urut='$no_urut' and kd_jns_op = '$kd_jns_op'
            and thn_pajak_sppt = '$thn' and pembayaran_sppt_ke='$ke' and jml_sppt_yg_dibayar != 0 ;
            EXCEPTION WHEN OTHERS THEN RAISE_APPLICATION_ERROR(-20005,SQLCODE||' error : UPDATE BATAL PEMBAYARAN GAGAL...!'); 
            END;

            BEGIN
            UPDATE HIST_PEMBAYARAN_SPPT SET 
            NILAI_BAYAR_BTL=HIST_PEMBAYARAN_SPPT.NILAI_BAYAR, DENDA_SPPT_BTL=HIST_PEMBAYARAN_SPPT.DENDA_SPPT,
            DENDA_SPPT=0, NILAI_BAYAR=0, TGL_BATAL=".$tgl_btl.", UPDATED_DATE=".$jam_btl.", 
            USERID_BATAL='$user_batal', NIP_BATAL='$nip_batal', KD_TP_BATAL='$kd_tp', STS_BAYAR=2       
            WHERE 
            STS_BAYAR=1 and KD_PROPINSI='$kd_propinsi' and KD_DATI2='$kd_dati2' 
            and KD_KECAMATAN='$kd_kecamatan' and FLG_STTS in (1,2,3,4,5) and KD_KELURAHAN='$kd_kelurahan' 
            and KD_BLOK='$kd_blok' and NO_URUT='$no_urut' and KD_JNS_OP= '$kd_jns_op'
            and THN_PAJAK_SPPT = '$thn' and PEMBAYARAN_SPPT_KE='$ke' and ID=$byr_id;
            EXCEPTION WHEN OTHERS THEN RAISE_APPLICATION_ERROR(-20005,SQLCODE||' error : UPDATE HISTORY BATAL PEMBAYARAN GAGAL...!'); 
            END;

        COMMIT; 
        END;
        ";
        //log_message('info', " QQQQQQQQQQQQQQQQQQQQQQQQQQ  qry : ".$qry );
        // $query = $this->db->query($sql);
        $result = 'default error';
        $result = $this->db->simple_qry_eon_ora($qry);
        //
        $Msg = $result['message'];
        //log_message('info', " WWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWW  Msg : ".$Msg );
        return $Msg;
    } 

    function get_hist_bayar_stts($bayar_id) {
        $schema_pbb = $this->schema_pbb;
        $sql = "select pst.*
        from HIST_PEMBAYARAN_SPPT pst 
        where pst.FLG_STTS in (1,2,3,4,5) and pst.id=$bayar_id ";
        $query = $this->db->query($sql);
        if($query->num_rows()!=0){ return $query->row();}
        else{return FALSE;}
    }

}

/* End of file _model.php */
