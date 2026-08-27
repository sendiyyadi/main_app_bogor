<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class pst_sppt_keberatan_model extends CI_Model
{
    private $tbl = 'SPPT';
    private $schema_pbb = SCHEMA_PBB . ".";

    function __construct()
    {
        parent::__construct();
    }

    function get_keberatan_pemby_ke($nop, $thn)
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
        where ps.kd_propinsi='$kd_propinsi' and ps.kd_dati2='$kd_dati2' and ps.kd_kecamatan='$kd_kecamatan' and
        ps.kd_kelurahan='$kd_kelurahan' and ps.kd_blok='$kd_blok' and ps.no_urut='$no_urut' and ps.kd_jns_op = '$kd_jns_op'
        and ps.thn_pajak_sppt = '$thn'";
        $query = $this->db->query($sql);
        $nval = $query->row();
        $nva = $nval->JML;
        return $nva;
    }

    function get_by_nop_thn_plyn($nop, $thn, $thn_p, $bundel_p, $urut_p)
    {

        $schema_pbb = $this->schema_pbb;
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

        $sql = "select s.nm_wp_sppt, s.jln_wp_sppt, s.rt_wp_sppt, s.rw_wp_sppt, s.kelurahan_wp_sppt, s.kota_wp_sppt, 
        s.npwp_sppt, s.pbb_terhutang_sppt, s.faktor_pengurang_sppt, s.pbb_yg_harus_dibayar_sppt, 
        to_char(s.tgl_jatuh_tempo_sppt,'yyyy-mm-dd') as tgl_jatuh_tempo_sppt, 
        sum(nvl(ps.denda_sppt,0)) as denda_sppt, 
        sum(nvl(ps.jml_sppt_yg_dibayar,0)) as jml_sppt_yg_dibayar, pst.nilai_atas_wp, pst.dummy_id as id_p
        from S_SPPT s
        left join S_PEMBAYARAN_SPPT ps on
        s.kd_propinsi=ps.kd_propinsi and s.kd_dati2=ps.kd_dati2 and s.kd_kecamatan=ps.kd_kecamatan and 
        s.kd_kelurahan=ps.kd_kelurahan and s.kd_blok=ps.kd_blok and s.no_urut=ps.no_urut and 
        s.kd_jns_op = ps.kd_jns_op and s.thn_pajak_sppt = ps.thn_pajak_sppt  
        join V_pst_permohonan_keberatan pst on
        s.kd_propinsi=pst.kd_propinsi_pemohon and s.kd_dati2=pst.kd_dati2_pemohon and 
        s.kd_kecamatan=pst.kd_kecamatan_pemohon and s.kd_kelurahan=pst.kd_kelurahan_pemohon and 
        s.kd_blok=pst.kd_blok_pemohon and s.no_urut=pst.no_urut_pemohon and 
        s.kd_jns_op = pst.kd_jns_op_pemohon and s.thn_pajak_sppt = pst.thn_pajak_sppt_pemohon  
        where s.kd_propinsi='$kd_propinsi' and s.kd_dati2='$kd_dati2' and s.kd_kecamatan='$kd_kecamatan' 
        and s.kd_kelurahan='$kd_kelurahan' and s.kd_blok='$kd_blok' and s.no_urut='$no_urut' 
        and s.kd_jns_op = '$kd_jns_op' and s.thn_pajak_sppt = '$thn' and s.status_pembayaran_sppt='0'
        and pst.thn_pelayanan = '$thn_p' and pst.bundel_pelayanan = '$bundel_p' 
        and pst.no_urut_pelayanan = '$urut_p' 
        -- and pst.sts_bayar='0'
        group by s.nm_wp_sppt, s.jln_wp_sppt, s.rt_wp_sppt, s.rw_wp_sppt, s.kelurahan_wp_sppt, s.kota_wp_sppt, 
        s.npwp_sppt, s.pbb_terhutang_sppt, s.faktor_pengurang_sppt, s.pbb_yg_harus_dibayar_sppt, 
        s.tgl_jatuh_tempo_sppt, pst.nilai_atas_wp, pst.dummy_id 
        having 
        s.pbb_yg_harus_dibayar_sppt-(sum(nvl(ps.jml_sppt_yg_dibayar,0))-sum(nvl(ps.denda_sppt,0)))>0 ";
        $query = $this->db->query($sql);

        if ($query->num_rows() !== 0) {
            return $query->row();
        } else
            return FALSE;
    }

    function get_permohonan_keberatan($nop, $thn, $thn_p, $bundel_p, $urut_p)
    {

        $schema_pbb = $this->schema_pbb;
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

        $sql = "SELECT pst.KD_KANWIL,pst.KD_KANTOR,pst.THN_PELAYANAN,pst.BUNDEL_PELAYANAN,
        pst.NO_URUT_PELAYANAN,pst.KD_PROPINSI_PEMOHON,pst.KD_DATI2_PEMOHON,pst.KD_KECAMATAN_PEMOHON,
        pst.KD_KELURAHAN_PEMOHON,pst.KD_BLOK_PEMOHON,pst.NO_URUT_PEMOHON,pst.KD_JNS_OP_PEMOHON,pst.NILAI_ATAS_WP,
        pst.THN_PAJAK_SPPT_PEMOHON, s.PBB_TERHUTANG_SPPT, s.FAKTOR_PENGURANG_SPPT, s.PBB_YG_HARUS_DIBAYAR_SPPT
        from S_PST_PERMOHONAN_KEBERATAN pst 
        join S_SPPT s on
        s.kd_propinsi=pst.kd_propinsi_pemohon and s.kd_dati2=pst.kd_dati2_pemohon and 
        s.kd_kecamatan=pst.kd_kecamatan_pemohon and s.kd_kelurahan=pst.kd_kelurahan_pemohon and 
        s.kd_blok=pst.kd_blok_pemohon and s.no_urut=pst.no_urut_pemohon and 
        s.kd_jns_op = pst.kd_jns_op_pemohon and s.thn_pajak_sppt = pst.thn_pajak_sppt_pemohon 
        where pst.KD_PROPINSI_PEMOHON='$kd_propinsi' and pst.KD_DATI2_PEMOHON='$kd_dati2' 
        and pst.KD_KECAMATAN_PEMOHON='$kd_kecamatan' and pst.KD_KELURAHAN_PEMOHON='$kd_kelurahan' 
        and pst.KD_BLOK_PEMOHON='$kd_blok' and pst.NO_URUT_PEMOHON='$no_urut' 
        and pst.KD_JNS_OP_PEMOHON = '$kd_jns_op' and pst.THN_PAJAK_SPPT_PEMOHON = '$thn' 
        and pst.THN_PELAYANAN = '$thn_p' and pst.BUNDEL_PELAYANAN = '$bundel_p' 
        and pst.NO_URUT_PELAYANAN = '$urut_p' and rownum<=1 ";
        $query = $this->db->query($sql);
        if ($query->num_rows() !== 0) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    function add_pemby_keberatan_OLD($data, $id)
    {

        $schema_pbb = $this->schema_pbb;
        $tabel      = $schema_pbb . ".PEMBAYARAN_SPPT";
        $result = $this->db->insert_eon_ora($tabel, $data);
        return $result;
        /*
        $data_kb = array(
            
            'tgl_bayar' => current_time(),
            'user_id_bayar' => lda_user_id(),
            'sts_bayar' => '1',
        );
        
        $this->db->where('id', $id);
        $this->db->update('pst_permohonan_keberatan',$data_kb);
        */
    }

    function add_pemby_keberatan($nop, $thn, $sisa_sppt, $data)
    {

        $schema_pbb = $this->schema_pbb;
        $tabel      = $schema_pbb . ".PEMBAYARAN_SPPT";
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
        //
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
        s.pbb_yg_harus_dibayar_sppt-(sum(nvl(ps.jml_sppt_yg_dibayar,0))-sum(nvl(ps.denda_sppt,0)))>=$sisa_sppt )";
        //
        $keys   = array_keys($data);
        $values = array_values($data);
        //
        $keys   = implode(', ', $keys);
        $values = "'" . implode("', '", $values) . "'";
        //
        $sql = " begin
        INSERT INTO " . $tabel . " (" . $keys . ")
        select " . $values . " from dual 
        where exists(" . $exists . ");
        IF sql%rowcount = 0 THEN
        RAISE_APPLICATION_ERROR (-20054, 'Tidak ada Penambahan Data....');
        END IF;
        commit;
        end;";
        // cek juga jika tdk ada hasil error data
        $result = $this->db->simple_qry_eon_ora($sql);
        // hasil dari simple_qry_eon_ora bentuk array
        return $result['message'];
    }

    function add_pemby_hist_keberatan($data)
    {
        //PST_BYR_KEBERATAN
        $result = $this->db->insert_eon_ora('HIST_PEMBAYARAN_SPPT', $data);
        return $result;
    }
}

/* End of file _model.php */
