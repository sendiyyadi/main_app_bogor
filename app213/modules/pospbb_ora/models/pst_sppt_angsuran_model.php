<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class pst_sppt_angsuran_model extends CI_Model
{
    private $tbl = 'SPPT';
    private $schema_pbb = SCHEMA_PBB . ".";

    function __construct()
    {
        parent::__construct();
    }

    function get_angs_bayar_ke($nop, $thn)
    {

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
        FROM PEMBAYARAN_SPPT ps
        where ps.kd_propinsi='$kd_propinsi' and ps.kd_dati2='$kd_dati2' and ps.kd_kecamatan='$kd_kecamatan' and
        ps.kd_kelurahan='$kd_kelurahan' and ps.kd_blok='$kd_blok' and ps.no_urut='$no_urut' and ps.kd_jns_op = '$kd_jns_op'
        and ps.thn_pajak_sppt = '$thn'";
        $query = $this->db->query($sql);
        $nval = $query->row();
        $nva = $nval->JML;
        return $nva;
    }

    function get_nop_angsuran($nop, $thn, $thn_p, $bundel_p, $urut_p, $angs_p)
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

        $sql = "select q1.nm_wp_sppt, q1.jln_wp_sppt, q1.rt_wp_sppt, q1.rw_wp_sppt, q1.kelurahan_wp_sppt, 
		q1.kota_wp_sppt, q1.npwp_sppt, q1.pbb_terhutang_sppt, q1.faktor_pengurang_sppt, 
		q1.pbb_yg_harus_dibayar_sppt, q1.tgl_jatuh_tempo_sppt, q1.denda_sppt, q1.jml_sppt_yg_dibayar,
		q2.nilai_cicilan, q2.nilai_cicilan, q2.kd_cicil, q2.id_p, q2.jt_tempo_cicilan
		from 
		(
            select s.kd_propinsi, s.kd_dati2, s.kd_kecamatan, s.kd_kelurahan, s.kd_blok, s.no_urut, s.kd_jns_op, 
    		s.thn_pajak_sppt, s.nm_wp_sppt, s.jln_wp_sppt, s.rt_wp_sppt, s.rw_wp_sppt, 
    		s.kelurahan_wp_sppt, s.kota_wp_sppt, s.npwp_sppt, s.pbb_terhutang_sppt, s.faktor_pengurang_sppt, 
    		s.pbb_yg_harus_dibayar_sppt, to_char(s.tgl_jatuh_tempo_sppt,'yyyy-mm-dd') as tgl_jatuh_tempo_sppt, 
    		coalesce(sum(ps.denda_sppt),0) as denda_sppt, 
    		coalesce(sum(ps.jml_sppt_yg_dibayar),0) as jml_sppt_yg_dibayar
    		from SPPT s
    		left join PEMBAYARAN_SPPT ps on
    		s.kd_propinsi=ps.kd_propinsi and s.kd_dati2=ps.kd_dati2 and s.kd_kecamatan=ps.kd_kecamatan and 
    		s.kd_kelurahan=ps.kd_kelurahan and s.kd_blok=ps.kd_blok and s.no_urut=ps.no_urut and 
    		s.kd_jns_op = ps.kd_jns_op and s.thn_pajak_sppt = ps.thn_pajak_sppt  
    		where s.kd_propinsi='$kd_propinsi' and s.kd_dati2='$kd_dati2' and s.kd_kecamatan='$kd_kecamatan' 
    		and s.kd_kelurahan='$kd_kelurahan' and s.kd_blok='$kd_blok' and s.no_urut='$no_urut' 
    		and s.kd_jns_op = '$kd_jns_op' and s.thn_pajak_sppt = '$thn' and s.status_pembayaran_sppt='9'
    		group by s.kd_propinsi, s.kd_dati2, s.kd_kecamatan, s.kd_kelurahan, s.kd_blok, s.no_urut, s.kd_jns_op, 
    		s.thn_pajak_sppt, s.nm_wp_sppt, s.jln_wp_sppt, s.rt_wp_sppt, s.rw_wp_sppt, s.kelurahan_wp_sppt, 
    		s.kota_wp_sppt, s.npwp_sppt, s.pbb_terhutang_sppt, s.faktor_pengurang_sppt, 
    		s.pbb_yg_harus_dibayar_sppt, s.tgl_jatuh_tempo_sppt
            having 
            s.pbb_yg_harus_dibayar_sppt-(sum(nvl(ps.jml_sppt_yg_dibayar,0))-sum(nvl(ps.denda_sppt,0)))>0
        ) q1
		join 
		(select pst.kd_propinsi_pemohon, pst.kd_dati2_pemohon, pst.kd_kecamatan_pemohon, pst.kd_kelurahan_pemohon, 
		pst.kd_blok_pemohon, pst.no_urut_pemohon, pst.kd_jns_op_pemohon, pst.thn_pajak_sppt_pemohon, 
		pst.thn_pelayanan, pst.bundel_pelayanan, pst.no_urut_pelayanan, $angs_p as kd_cicil, 
		case when $angs_p = 1 then coalesce(pst.cicilan_i,0)
		when $angs_p = 2 then coalesce(pst.cicilan_ii,0)
		when $angs_p = 3 then coalesce(pst.cicilan_iii,0)
		when $angs_p = 4 then coalesce(pst.cicilan_iv,0)
		else 0 end as nilai_cicilan, 
		case when $angs_p = 1 then tgl_c_i
		when $angs_p = 2 then tgl_c_ii
		when $angs_p = 3 then tgl_c_iii
		when $angs_p = 4 then tgl_c_iv
		else null end as jt_tempo_cicilan, 
		-- pst.dummy_id as id_p
        0 as id_p
		from pst_permohonan_angsuran pst 
		where pst.kd_propinsi_pemohon='$kd_propinsi' and pst.kd_dati2_pemohon='$kd_dati2' 
		and pst.kd_kecamatan_pemohon='$kd_kecamatan' and pst.kd_kelurahan_pemohon='$kd_kelurahan' 
		and pst.kd_blok_pemohon='$kd_blok' and pst.no_urut_pemohon='$no_urut' 
		and pst.kd_jns_op_pemohon = '$kd_jns_op' and pst.thn_pajak_sppt_pemohon = '$thn' 
		and pst.thn_pelayanan = '$thn_p' and pst.bundel_pelayanan = '$bundel_p' 
		and pst.no_urut_pelayanan = '$urut_p' 
		and (($angs_p = 1 and nvl(pst.cicilan_i,0) > 0)
		or	 ($angs_p = 2 and nvl(pst.cicilan_ii,0) > 0) 
		or	 ($angs_p = 3 and nvl(pst.cicilan_iii,0) > 0)
		or	 ($angs_p = 4 and nvl(pst.cicilan_iv,0) > 0) )
		) q2 on 
		q1.kd_propinsi=q2.kd_propinsi_pemohon and q1.kd_dati2=q2.kd_dati2_pemohon and 
		q1.kd_kecamatan=q2.kd_kecamatan_pemohon and q1.kd_kelurahan=q2.kd_kelurahan_pemohon and 
		q1.kd_blok=q2.kd_blok_pemohon and q1.no_urut=q2.no_urut_pemohon and 
		q1.kd_jns_op = q2.kd_jns_op_pemohon and q1.thn_pajak_sppt = q2.thn_pajak_sppt_pemohon 
    where 
    not exists(select 1 from HIST_PEMBAYARAN_SPPT byr 
    where byr.kd_propinsi='$kd_propinsi' and byr.kd_dati2='$kd_dati2' and byr.KD_PELAYANAN='15'
    and byr.kd_kecamatan='$kd_kecamatan' and byr.kd_kelurahan='$kd_kelurahan' 
    and byr.kd_blok='$kd_blok' and byr.no_urut='$no_urut' 
    and byr.kd_jns_op = '$kd_jns_op' and byr.thn_pajak_sppt = '$thn' 
    and byr.thn_pelayanan = '$thn_p' and byr.bundel_pelayanan = '$bundel_p' 
    and byr.no_urut_pelayanan = '$urut_p' and byr.cicilan_ke=$angs_p and byr.sts_bayar=1) ";

        $query = $this->db->query($sql);
        if ($query->num_rows() !== 0) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    function get_permohonan_angsuran($nop, $thn, $thn_p, $bundel_p, $urut_p)
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

        $sql = " SELECT pst.KD_KANWIL,pst.KD_KANTOR,pst.THN_PELAYANAN,pst.BUNDEL_PELAYANAN,
        pst.NO_URUT_PELAYANAN,pst.KD_PROPINSI_PEMOHON,pst.KD_DATI2_PEMOHON,
        pst.KD_KECAMATAN_PEMOHON,pst.KD_KELURAHAN_PEMOHON,pst.KD_BLOK_PEMOHON,
        pst.NO_URUT_PEMOHON,pst.KD_JNS_OP_PEMOHON,pst.TGL_C_I,pst.CICILAN_I,
        pst.TGL_C_II,pst.CICILAN_II, pst.TGL_C_III,pst.CICILAN_III,
        pst.TGL_C_IV,pst.CICILAN_IV, pst.THN_PAJAK_SPPT_PEMOHON,
        s.PBB_TERHUTANG_SPPT, s.FAKTOR_PENGURANG_SPPT, s.PBB_YG_HARUS_DIBAYAR_SPPT
        FROM PST_PERMOHONAN_ANGSURAN pst
        JOIN SPPT s on s.kd_propinsi=pst.KD_PROPINSI_PEMOHON and s.kd_dati2=pst.KD_DATI2_PEMOHON 
        and s.kd_kecamatan=pst.KD_KECAMATAN_PEMOHON and s.kd_kelurahan=pst.KD_KELURAHAN_PEMOHON 
        and s.kd_blok=pst.KD_BLOK_PEMOHON and s.no_urut=pst.NO_URUT_PEMOHON and s.kd_jns_op = pst.KD_JNS_OP_PEMOHON
        and s.thn_pajak_sppt = pst.THN_PAJAK_SPPT_PEMOHON  
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

    function add_pemby_angsuran($nop, $thn, $nil_angsuran, $data)
    {

        // $schema_pbb = $this->schema_pbb;
        // $tabel      = $schema_pbb . ".PEMBAYARAN_SPPT";
        $tabel      = "PEMBAYARAN_SPPT";

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
        from SPPT s
        left join PEMBAYARAN_SPPT ps on
        s.kd_propinsi=ps.kd_propinsi and s.kd_dati2=ps.kd_dati2 
        and s.kd_kecamatan=ps.kd_kecamatan and s.kd_kelurahan=ps.kd_kelurahan 
        and s.kd_blok=ps.kd_blok and s.no_urut=ps.no_urut and s.kd_jns_op = ps.kd_jns_op
        and s.thn_pajak_sppt = ps.thn_pajak_sppt  
        where s.kd_propinsi='$kd_propinsi' and s.kd_dati2='$kd_dati2' and 
        s.kd_kecamatan='$kd_kecamatan' and 
        s.kd_kelurahan='$kd_kelurahan' and s.kd_blok='$kd_blok' and s.no_urut='$no_urut' and s.kd_jns_op='$kd_jns_op'
        and s.thn_pajak_sppt = '$thn' -- and s.status_pembayaran_sppt='0'
        and $nil_angsuran>0
        group by s.pbb_yg_harus_dibayar_sppt
        having 
        s.pbb_yg_harus_dibayar_sppt-(sum(nvl(ps.jml_sppt_yg_dibayar,0))-sum(nvl(ps.denda_sppt,0)))>=$nil_angsuran )";
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

    function add_pemby_hist_angsuran($data)
    {
        $result = $this->db->insert_eon_ora('HIST_PEMBAYARAN_SPPT', $data);
        return $result;
    }

    function add_pemby_sppt($data)
    {
        $result = $this->db->insert_eon_ora('PEMBAYARAN_SPPT', $data);
        return $result;
    }

    function cek_angs_terakhir($nop, $thn, $thn_p, $bundel_p, $urut_p)
    {

        $schema_pbb = $this->schema_pbb;
        // cek pembayaran terakhir cicilan ke berapa
        $nop = urldecode($nop);
        $nop = str_replace('.', '', $nop);
        $nop = str_replace(' ', '', $nop);
        $nop = str_replace('-', '', $nop);
        $nop = preg_replace('/[^0-9]/', '', $nop);

        $kd_propinsi  = substr($nop, 0, 2);
        $kd_dati2     = substr($nop, 2, 2);
        $kd_kecamatan = substr($nop, 4, 3);
        $kd_kelurahan = substr($nop, 7, 3);
        $kd_blok      = substr($nop, 10, 3);
        $no_urut      = substr($nop, 13, 4);
        $kd_jns_op    = substr($nop, 17, 1);

        $sql = "with detil as (
        select STS_BAYAR, CICILAN_KE, PEMBAYARAN_SPPT_KE
        FROM HIST_PEMBAYARAN_SPPT pst
        WHERE pst.KD_PROPINSI='$kd_propinsi' and pst.KD_DATI2='$kd_dati2'  and pst.KD_PELAYANAN='15'
        and pst.KD_KECAMATAN='$kd_kecamatan' and pst.KD_KELURAHAN='$kd_kelurahan' 
        and pst.KD_BLOK='$kd_blok' and pst.NO_URUT='$no_urut' 
        and pst.KD_JNS_OP = '$kd_jns_op' and pst.THN_PAJAK_SPPT = '$thn' 
        and pst.THN_PELAYANAN = '$thn_p' and pst.BUNDEL_PELAYANAN = '$bundel_p' 
        and pst.NO_URUT_PELAYANAN = '$urut_p' )
        select nvl(max(CICILAN_KE),0) as CICILAN_KE from detil WHERE detil.STS_BAYAR=1";
        $query = $this->db->query($sql);
        if ($query->num_rows() !== 0) {
            return $query->row()->CICILAN_KE;
        } else {
            return 0;
        }
    }

    public function total_hist($nop, $thn, $thn_p, $bundel_p, $urut_p)
    {
        $nop = urldecode($nop);
        $nop = str_replace('.', '', $nop);
        $nop = str_replace(' ', '', $nop);
        $nop = str_replace('-', '', $nop);
        $nop = preg_replace('/[^0-9]/', '', $nop);

        $kd_propinsi  = substr($nop, 0, 2);
        $kd_dati2     = substr($nop, 2, 2);
        $kd_kecamatan = substr($nop, 4, 3);
        $kd_kelurahan = substr($nop, 7, 3);
        $kd_blok      = substr($nop, 10, 3);
        $no_urut      = substr($nop, 13, 4);
        $kd_jns_op    = substr($nop, 17, 1);

        $sql = "select NVL(sum(NILAI_BAYAR - DENDA_SPPT),0) as ttl_pokok, 
                NVL(sum(NILAI_BAYAR), 0) as ttl_byr,
                NVL(sum(DENDA_SPPT), 0) as ttl_denda
                from HIST_PEMBAYARAN_SPPT his
                WHERE his.KD_PROPINSI='$kd_propinsi' and his.KD_DATI2='$kd_dati2'  and his.KD_PELAYANAN='15'
                and his.KD_KECAMATAN='$kd_kecamatan' and his.KD_KELURAHAN='$kd_kelurahan' 
                and his.KD_BLOK='$kd_blok' and his.NO_URUT='$no_urut' 
                and his.KD_JNS_OP = '$kd_jns_op' and his.THN_PAJAK_SPPT = '$thn' 
                and his.THN_PELAYANAN = '$thn_p' and his.BUNDEL_PELAYANAN = '$bundel_p' 
                and his.NO_URUT_PELAYANAN = '$urut_p' ";
        $query = $this->db->query($sql);
        if ($query->num_rows() !== 0) {
            return $query->row();
        } else {
            return 0;
        }
    }
}

/* End of file _model.php */
