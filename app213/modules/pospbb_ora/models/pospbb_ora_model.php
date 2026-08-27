<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class pospbb_ora_model extends CI_Model {

    private $tbluser = 'USER_PBB';
    public $rangebuku;
    private $schema_pbb = SCHEMA_PBB.".";

    function __construct() {

        parent::__construct();
        
        $this->rangebuku = array(
            1 => array(
                0 => 0,
                1 => 100000
            ),
            2 => array(
                0 => 100001,
                1 => 500000
            ),
            3 => array(
                0 => 500001,
                1 => 2000000
            ),
            4 => array(
                0 => 2000001,
                1 => 5000000
            ),
            5 => array(
                0 => 5000001,
                1 => 99999999999
            )
        );
    }

    function get_select_buku(){
      $options = array(
        '11' => 'Buku 1',
        '12' => 'Buku 1,2',
        '13' => 'Buku 1,2,3',
        '14' => 'Buku 1,2,3,4',
        '15' => 'Buku 1,2,3,4,5',
        '22' => 'Buku 2',
        '23' => 'Buku 2,3',
        '24' => 'Buku 2,3,4',
        '25' => 'Buku 2,3,4,5',
        '33' => 'Buku 3',
        '34' => 'Buku 3,4',
        '35' => 'Buku 3,4,5',
        '44' => 'Buku 4',
        '45' => 'Buku 4,5',
        '55' => 'Buku 5',
      );
      return $options;
    }

    function get_select_book(){
      $options = array(
        '1' => 'Buku 1',
        '2' => 'Buku 1,2',
        '3' => 'Buku 1,2,3',
        '4' => 'Buku 1,2,3,4',
        '5' => 'Buku 1,2,3,4,5',
        '6' => 'Buku 2',
        '7' => 'Buku 2,3',
        '8' => 'Buku 2,3,4',
        '9' => 'Buku 2,3,4,5',
        '10' => 'Buku 3',
        '11' => 'Buku 3,4',
        '12' => 'Buku 3,4,5',
        '13' => 'Buku 4',
        '14' => 'Buku 4,5',
        '15' => 'Buku 5',
      );
      return $options;
    }

    function get_select_bulan(){
      $options = array(
        '1' => 'Januari',
        '2' => 'Februari',
        '3' => 'Maret',
        '4' => 'April',
        '5' => 'Mei',
        '6' => 'Juni',
        '7' => 'Juli',
        '8' => 'Agustus',
        '9' => 'September',
        '10' => 'Oktober',
        '11' => 'Nopember',
        '12' => 'Desember',
      );
      return $options;
    }

    function getKodeBlok()
    {
        return $this->kode_blok;
    }
    function setKodeBlok($kode_blok)
    {
        $this->kode_blok = $kode_blok;
    }
    function getKodePropinsi()
    {
        return $this->kode_propinsi;
    }
    function setKodePropinsi($kode_propinsi)
    {
        $this->kode_propinsi = $kode_propinsi;
    }
    function getKodeDati2()
    {
        return $this->kode_dati2;
    }
    function setKodeDati2($kode_dati2)
    {
        $this->kode_dati2 = $kode_dati2;
    }
    function getKodeJenisOP()
    {
        return $this->kode_jenis_op;
    }
    function setKodeJenisOP($kode_jenis_op)
    {
        $this->kode_jenis_op = $kode_jenis_op;
    }
    function getKodeKecamatan()
    {
        return $this->kode_kecamatan;
    }
    function setKodeKecamatan($kode_kecamatan)
    {
        $this->kode_kecamatan = $kode_kecamatan;
    }
    function getKodeKelurahan()
    {
        return $this->kode_kelurahan;
    }
    function setKodeKelurahan($kode_kelurahan)
    {
        $this->kode_kelurahan = $kode_kelurahan;
    }
    function getNOP()
    {
        return $this->nop;
    }
    function setNOP($nop)
    {
        $this->nop = $nop;
    }
    function getNoUrut()
    {
        return $this->no_urut;
    }
    function setNoUrut($no_urut)
    {
        $this->no_urut = $no_urut;
    }
    function getNamaWP()
    {
        return $this->nama_wp;
    }
    function setNamaWP($nama_wp)
    {
        $this->nama_wp = $nama_wp;
    }
    function getTahun()
    {
        return $this->tahun;
    }
    function setTahun($tahun)
    {
        $this->tahun = $tahun;
    }
    
    function set_userarea(){

        $userlogin = lda_user_login();
        $this->db->where('USERID', $userlogin);
        $query = $this->db->get('V_USER_PBB');
        if ($row = $query->row()){
            $userarea = KD_PROPINSI . KD_DATI2 . $row->KD_KECAMATAN . $row->KD_KELURAHAN;
          }
        else{
            $userarea = KD_PROPINSI . KD_DATI2 . '000000';
        }
        
        $this->session->set_userdata('user_area', $userarea);
        return $userarea;
    }

    function informasi_objek_pajak($nop)
    {
        $schema_pbb = $this->schema_pbb;
        /*
        // Get Data Parameter
        $kel_kd = $this->getKodeKecamatan();
        $kel_kd = $this->getKodeKelurahan();
        $blok_kd = $this->getKodeBlok();
        $urut_no = $this->getNoUrut();
        $jns_kd = $this->getKodeJenisOP();
        */
        $prop_kd = substr($nop, 0, 2);
        $kab_kd  = substr($nop, 2, 2);
        $kec_kd  = substr($nop, 4, 3);
        $kel_kd  = substr($nop, 7, 3);
        $blok_kd = substr($nop, 10, 3);
        $urut_no = substr($nop, 13, 4);
        $jns_kd  = substr($nop, 17, 1);

        $min_thn_sppt = mintahun_sppt();
        $max_thn_sppt = date('Y');
        //
        $prop_kd = KD_PROPINSI;
        $kab_kd  = KD_DATI2;
        //        
        $sql = "SELECT 
        spt.kd_propinsi||'.'||spt.kd_dati2||'-'||spt.kd_kecamatan||'.'||spt.kd_kelurahan ||'-'||
        spt.kd_blok ||'.'||spt.no_urut||'.'|| spt.kd_jns_op nop,
        coalesce(dop.jalan_op,'')||coalesce(', '||dop.blok_kav_no_op,'') alamat_op,
        dop.rt_op || ' / ' || dop.rw_op rt_rw_op, kel.nm_kelurahan kelurahan_op, kec.nm_kecamatan kecamatan_op,
        spt.luas_bumi_sppt, spt.luas_bng_sppt,
        spt.nm_wp_sppt, max(coalesce(ps.pembayaran_sppt_ke,0)) pembayaran_sppt_ke, 
        coalesce(spt.jln_wp_sppt,'')||coalesce(', '||spt.blok_kav_no_wp_sppt,'') alamat_wp,
        spt.rt_wp_sppt || ' / ' || spt.rw_wp_sppt rt_rw_wp,
        spt.kelurahan_wp_sppt kelurahan_wp, spt.kota_wp_sppt kota_wp,
        spt.thn_pajak_sppt,
        spt.luas_bumi_sppt luas_tanah, 
        spt.njop_bumi_sppt njop_tanah, 
        spt.luas_bng_sppt luas_bng, 
        spt.njop_bng_sppt njop_bng,
        spt.pbb_yg_harus_dibayar_sppt ketetapan,
        spt.status_pembayaran_sppt status_bayar,
        sum(ps.jml_sppt_yg_dibayar) jml_bayar,
        case when cast(spt.status_pembayaran_sppt as int)=0 then 0
        else sum(ps.denda_sppt) end as jml_denda,
        to_char(max(ps.tgl_pembayaran_sppt),'dd-mm-yyyy') tgl_bayar
        FROM S_SPPT spt
        LEFT JOIN S_DAT_OBJEK_PAJAK dop
        ON dop.kd_propinsi = spt.kd_propinsi 
        AND dop.kd_dati2 = spt.kd_dati2
        AND dop.kd_kecamatan = spt.kd_kecamatan
        AND dop.kd_kelurahan = spt.kd_kelurahan
        AND dop.kd_blok = spt.kd_blok
        AND dop.no_urut = spt.no_urut
        AND dop.kd_jns_op = spt.kd_jns_op
        LEFT JOIN S_PEMBAYARAN_SPPT ps
        ON ps.kd_propinsi = spt.kd_propinsi 
        AND ps.kd_dati2 = spt.kd_dati2
        AND ps.kd_kecamatan = spt.kd_kecamatan
        AND ps.kd_kelurahan = spt.kd_kelurahan
        AND ps.kd_blok = spt.kd_blok
        AND ps.no_urut = spt.no_urut
        AND ps.kd_jns_op = spt.kd_jns_op
        AND ps.thn_pajak_sppt = spt.thn_pajak_sppt
        LEFT JOIN S_REF_KELURAHAN kel ON kel.kd_kecamatan=spt.kd_kecamatan AND kel.kd_kelurahan=spt.kd_kelurahan
        LEFT JOIN S_REF_KECAMATAN kec ON kec.kd_kecamatan = spt.kd_kecamatan 
        WHERE spt.status_pembayaran_sppt != '2' and 
        (cast(spt.thn_pajak_sppt as int) BETWEEN {$min_thn_sppt} AND {$max_thn_sppt})
        AND spt.kd_propinsi = '{$prop_kd}'
        AND spt.kd_dati2 = '{$kab_kd}'
        AND spt.kd_kecamatan = '{$kec_kd}'
        AND spt.kd_kelurahan = '{$kel_kd}'
        AND spt.kd_blok = '{$blok_kd}'
        AND spt.no_urut = '{$urut_no}'
        AND spt.kd_jns_op = '{$jns_kd}'
        GROUP BY spt.kd_propinsi, spt.kd_dati2, spt.kd_kecamatan, spt.kd_kelurahan, 
        spt.kd_blok, spt.no_urut, spt.kd_jns_op, dop.jalan_op, dop.blok_kav_no_op,
        dop.rt_op, dop.rw_op, dop.total_luas_bumi, dop.total_luas_bng, spt.nm_wp_sppt,
        spt.jln_wp_sppt, spt.blok_kav_no_wp_sppt, spt.rt_wp_sppt, spt.rw_wp_sppt, spt.kelurahan_wp_sppt, spt.kota_wp_sppt, 
        spt.thn_pajak_sppt, spt.luas_bumi_sppt, spt.njop_bumi_sppt, 
        spt.luas_bng_sppt, spt.njop_bng_sppt, spt.pbb_yg_harus_dibayar_sppt,
        spt.status_pembayaran_sppt ,
        kel.nm_kelurahan, kec.nm_kecamatan 
        ORDER BY spt.kd_propinsi, spt.kd_dati2, spt.kd_kecamatan, spt.kd_kelurahan, 
        spt.kd_blok, spt.no_urut, spt.kd_jns_op, spt.thn_pajak_sppt ";
        $query = $this->db->query($sql);
        log_message('info', " ZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZ informasi_objek_pajak : " . $sql );
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return NULL;
        }
    }
     
}
/* End of file _model.php */
