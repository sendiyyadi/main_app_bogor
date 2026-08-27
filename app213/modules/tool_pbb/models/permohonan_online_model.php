<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class permohonan_online_model extends CI_Model {

    public function get_by_id($id) {
        $this->db->where('ID', $id);
        $result = $this->db->update_oen_ora('SPPT', $data);
        return $result;
    }

    public function get_by_nop($nop) {
        $nop     = str_replace(".", "", $nop);
        $nop     = str_replace("-", "", $nop);
        $kd_prop = substr($nop, 0, 2);
        $kd_dati = substr($nop, 2, 2);
        $kd_kec  = substr($nop, 4, 3);
        $kd_kel  = substr($nop, 7, 3);
        $kd_blok = substr($nop, 10, 3);
        $no_urut = substr($nop, 13, 4);
        $kd_jns_op = substr($nop, 17, 1);

        $this->db->where('KD_PROPINSI', $kd_prop);
        $this->db->where('KD_DATI2', $kd_dati);
        $this->db->where('KD_KECAMATAN', $kd_kec);
        $this->db->where('KD_KELURAHAN', $kd_kel);
        $this->db->where('KD_BLOK', $kd_blok);
        $this->db->where('NO_URUT', $no_urut);
        $this->db->where('KD_JNS_OP', $kd_jns_op);
        
        $result = $this->db->update_oen_ora('SPPT', $data);
        return $result;
    }

    function get_jns_ply() {
        $in_array = "('08','09','15','16','04','03','21')";
        // $qq = "SELECT * FROM REF_JNS_PELAYANAN WHERE KD_JNS_PELAYANAN IN {$in_array} ";        
        $qq = "SELECT * FROM REF_JNS_PELAYANAN  ";        
        return $this->db->query($qq)->result();
    }

    function cek_nop_reg_esppt($nop) {
        $nop     = str_replace(".", "", $nop);
        $nop     = str_replace("-", "", $nop);
        $kd_prop = substr($nop, 0, 2);
        $kd_dati = substr($nop, 2, 2);
        $kd_kec  = substr($nop, 4, 3);
        $kd_kel  = substr($nop, 7, 3);
        $kd_blok = substr($nop, 10, 3);
        $no_urut = substr($nop, 13, 4);
        $kd_jns_op = substr($nop, 17, 1);

        // $this->db->where('KD_PROPINSI', $kd_prop);
        // $this->db->where('KD_DATI2', $kd_dati);
        // $this->db->where('KD_KECAMATAN', $kd_kec);
        // $this->db->where('KD_KELURAHAN', $kd_kel);
        // $this->db->where('KD_BLOK', $kd_blok);
        // $this->db->where('NO_URUT', $no_urut);
        // $this->db->where('KD_JNS_OP', $kd_jns_op);
        
        // $result = $this->db->get('REG_ESPPT');
        // return $result;

        $sql = "SELECT REG_ESPPT.*, KD_PROPINSI||KD_DATI2||KD_KECAMATAN||KD_KELURAHAN||KD_BLOK||NO_URUT||KD_JNS_OP as NOPLKP,
                KD_PROPINSI||KD_DATI2||KD_KECAMATAN||KD_KELURAHAN||KD_BLOK||NO_URUT||KD_JNS_OP||TRIM(NIK) as NOPNIK
                FROM REG_ESPPT 
                WHERE KD_PROPINSI = '{$kd_prop}' AND KD_DATI2 = '{$kd_dati}' AND KD_KECAMATAN = '{$kd_kec}' 
                AND KD_KELURAHAN = '{$kd_kel}' AND KD_BLOK = '{$kd_blok}' AND NO_URUT = '{$no_urut}'
                AND KD_JNS_OP = '{$kd_jns_op}' ";
        
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0){
            return $query->row();
        } else { 
            return FALSE;
        }
    }

    function cek_nop_reg_esppt_bynopnik($nopnik) {

        $sql = "SELECT REG_ESPPT.*, KD_PROPINSI||KD_DATI2||KD_KECAMATAN||KD_KELURAHAN||KD_BLOK||NO_URUT||KD_JNS_OP as NOPLKP,
                KD_PROPINSI||KD_DATI2||KD_KECAMATAN||KD_KELURAHAN||KD_BLOK||NO_URUT||KD_JNS_OP||TRIM(NIK) as NOPNIK
                FROM REG_ESPPT 
                WHERE KD_PROPINSI||KD_DATI2||KD_KECAMATAN||KD_KELURAHAN||KD_BLOK||NO_URUT||KD_JNS_OP||TRIM(NIK) = '{$nopnik}' ";
        
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0){
            return $query->row();
        } else { 
            return FALSE;
        }
    }

    function cek_nop_dop($nop) {
        $nop     = str_replace(".", "", $nop);
        $nop     = str_replace("-", "", $nop);
        $kd_prop = substr($nop, 0, 2);
        $kd_dati = substr($nop, 2, 2);
        $kd_kec  = substr($nop, 4, 3);
        $kd_kel  = substr($nop, 7, 3);
        $kd_blok = substr($nop, 10, 3);
        $no_urut = substr($nop, 13, 4);
        $kd_jns_op = substr($nop, 17, 1);

        $sql = "SELECT DSP.*, TRIM(DOP.SUBJEK_PAJAK_ID) as NIK,
                DOP.KD_PROPINSI||DOP.KD_DATI2||DOP.KD_KECAMATAN||DOP.KD_KELURAHAN||DOP.KD_BLOK||DOP.NO_URUT||DOP.KD_JNS_OP||TRIM(DOP.SUBJEK_PAJAK_ID) as NOPNIK
                FROM DAT_SUBJEK_PAJAK DSP
                JOIN DAT_OBJEK_PAJAK DOP ON DSP.SUBJEK_PAJAK_ID = DOP.SUBJEK_PAJAK_ID
                WHERE DOP.KD_PROPINSI = '{$kd_prop}' AND DOP.KD_DATI2 = '{$kd_dati}' AND DOP.KD_KECAMATAN = '{$kd_kec}' 
                AND DOP.KD_KELURAHAN = '{$kd_kel}' AND DOP.KD_BLOK = '{$kd_blok}' AND DOP.NO_URUT = '{$no_urut}'
                AND DOP.KD_JNS_OP = '{$kd_jns_op}' ";
        //var_dump($sql);die;
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0){
            return $query->row();
        } else { 
            return FALSE;
        }
    }

    function get_thn_pelayanan(){
        $qq = "select thn_pelayanan from max_urut_pst 
                where thn_pelayanan=(select max(cast(thn_pelayanan as number)) as thn_pelayanan from max_urut_pst)";
        $q1 = $this->db->query($qq)->row();
        $thn_pelayanan = $q1->THN_PELAYANAN;
        return $thn_pelayanan;
    }

    function update_sts_permohonan($param){
        $qq = "UPDATE PST_PERMOHONAN_ONLINE 
                SET STATUS_PERMOHONAN = '1' 
                WHERE KD_PROPINSI_PEMOHON||KD_DATI2_PEMOHON||KD_KECAMATAN_PEMOHON||KD_KELURAHAN_PEMOHON||KD_BLOK_PEMOHON||
                NO_URUT_PEMOHON||KD_JNS_OP_PEMOHON||THN_PELAYANAN||KD_JNS_PELAYANAN ='{$param}'";
        $this->db->query($qq);
        return true;
    }

    function get_prm_online($nop_kdply){
        // $prop_kd = substr($nop_kdply, 0, 2);
        // $kab_kd  = substr($nop_kdply, 2, 2);
        // $kec_kd  = substr($nop_kdply, 4, 3);
        // $kel_kd  = substr($nop_kdply, 7, 3);
        // $blok_kd = substr($nop_kdply, 10, 3);
        // $urut_no = substr($nop_kdply, 13, 4);
        // $jns_kd  = substr($nop_kdply, 17, 1);
        $qq = "SELECT P.NO_SRT_PERMOHONAN, P.NAMA_PEMOHON, P.ALAMAT_PEMOHON, P.KETERANGAN_PST, 
                TO_CHAR(P.TGL_SURAT_PERMOHONAN, 'DD-MM-YYYY') AS TGL_SURAT_PERMOHONAN, P.KD_JNS_PELAYANAN, 
                P.THN_PELAYANAN||P.BUNDEL_PELAYANAN||P.NO_URUT_PELAYANAN AS NO_PLY, 
                SP.KD_PROPINSI||SP.kd_dati2||SP.KD_KECAMATAN||SP.KD_KELURAHAN||SP.KD_BLOK||SP.NO_URUT||SP.KD_JNS_OP AS NOP, 
                SP.KD_PROPINSI||'.'||SP.kd_dati2||'-'||SP.KD_KECAMATAN||'.'||SP.KD_KELURAHAN||'-'||SP.KD_BLOK||'.'||SP.NO_URUT||'.'||SP.KD_JNS_OP AS NOP_LKP, 
                P.STATUS_PERMOHONAN AS STS_FLG, PL.NM_JENIS_PELAYANAN, P.ALASAN, SP.EMAIL, P.L_SKKP_PBB, P.L_SPMKP_PBB, 
                P.L_KTP_WP, P.L_SERTIFIKAT_TANAH, P.L_IMB, P.L_AKTE_JUAL_BELI, P.L_SURAT_KUASA, P.L_PERMOHONAN, P.L_STTS, 
                P.L_SK_KEBERATAN, P.L_SPPT, P.L_SPPT_STTS, P.L_SK_PENGURANGAN, P.L_LAIN_LAIN 
                FROM PST_PERMOHONAN_ONLINE P 
                JOIN REG_ESPPT SP ON (SP.KD_PROPINSI=P.KD_PROPINSI_PEMOHON AND SP.KD_DATI2=p.kd_dati2_pemohon 
                AND sp.kd_kecamatan=p.kd_kecamatan_pemohon AND p.kd_kelurahan_pemohon=sp.kd_kelurahan AND p.kd_blok_pemohon=SP.KD_BLOK 
                AND sp.no_urut=p.no_urut_pemohon AND sp.kd_jns_op=p.kd_jns_op_pemohon) 
                LEFT JOIN REF_JNS_PELAYANAN PL ON PL.KD_JNS_PELAYANAN=P.KD_JNS_PELAYANAN 
                WHERE P.KD_PROPINSI_PEMOHON||P.kd_dati2_pemohon||P.KD_KECAMATAN_PEMOHON||P.KD_KELURAHAN_PEMOHON||P.KD_BLOK_PEMOHON||
                P.NO_URUT_PEMOHON||P.KD_JNS_OP_PEMOHON||P.THN_PELAYANAN||P.KD_JNS_PELAYANAN ='{$nop_kdply}'";
        return $this->db->query($qq)->row();
    }

    function encript_value($login, $value) {
        $qry   = "SELECT FN_KEYLOCK('{$login}','{$value}') as FN_KEYLOCK from DUAL";
        $query = $this->db->query($qry);
        return $query->row();
    }

    public function nextid_user() {
        $qry = "SELECT PBB.sec_users_seq.NEXTVAL as NEXT_ID FROM DUAL";
        //log_message('info', "KKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK  ". $qry);
        $query = $this->db->query($qry);
        return $query->row();
    }


}
