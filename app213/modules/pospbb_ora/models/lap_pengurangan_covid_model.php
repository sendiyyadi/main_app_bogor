<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class lap_pengurangan_covid_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }


    function get_select_kec()
    {
        // arig

        $sql = " select * from (
                select null as kd_kecamatan,  ' Semua' as nm_kecamatan from dual
                union all
                select kd_kecamatan,  nm_kecamatan
                from s_ref_kecamatan where kd_propinsi='32' and kd_dati2='03'
                ) z1 order by nm_kecamatan  ";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
            return $query->result();
        else
            return false;
    }

    function get_select_kel($kec)
    {
        // arig
        //log_message('info', "KKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK");
        if (empty($kec)) {
            $kec = ' ';
        }
        $sql = " select * from (
        select null as kd_kelurahan,  ' Semua' as nm_kelurahan from dual 
        union all
        select kd_kelurahan, nm_kelurahan
        from s_ref_kelurahan where kd_propinsi='32' and kd_dati2='03' and kd_kecamatan='{$kec}'
        ) z1 order by nm_kelurahan  ";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
            return $query->result();
        else
            return false;
    }

    function get_select_tp()
    {
        // arig
        $sql = " select * from (
                select null as kd_tp, ' Semua' as nm_tp from dual  
                union all
                select kd_tp, nm_tp from s_tempat_pembayaran
                ) z1 order by nm_tp  ";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
            return $query->result();
        else
            return false;
    }

    function get_select_buku()
    {

        $sql = " select id as buku_id,nama as buku_nm from ref_buku order by nama  ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
            return $query->result();
        else
            return false;
    }
}

/* End of file _model.php */
