<?php
class kecModel extends CI_Model {

    var $tables ='ref_kecamatan';
    var $keys   ='username';
    private $db_pbbm;

    function __construct() {
        parent::__construct();
        // $this->db_pbbm = $this->load->database('pad', TRUE);
    }

    function getRecord($kec='000')
    {
        $sql="select * from ref_kecamatan
            where kd_propinsi='".KD_PROPINSI."' and kd_dati2='".KD_DATI2."'";
        if ($kec!='000')
            $sql.=" and kd_kecamatan='$kec'";

        $qry=$this->db->query($sql);
        return $qry->result();
    }

    // new
    function get_kec_for_select($selected_kd = '') {
        $ret   = "";
        $where = "where kd_propinsi='".KD_PROPINSI."' and kd_dati2='".KD_DATI2."' ";
        $kec_kodes = get_kec_kodes();

        if(!$kec_kodes) $kec_kodes = "'000'";
        if (strpos($kec_kodes,'000') === false)
            $where .= " and kd_kecamatan in ({$kec_kodes})";
        else
            $ret = "<option value=\"000\">SEMUA KECAMATAN</option>\n";

        $sql = "select kd_kecamatan, nm_kecamatan from ref_kecamatan {$where}";
        $qry = $this->db->query($sql);
        $kec = $qry->result();
        foreach ($kec as $row)
        {
            $selected='';
            if ($row->KD_KECAMATAN==$selected_kd) $selected=" selected";
            $ret .= "<option value=\"".$row->KD_KECAMATAN ."\" $selected>".$row->NM_KECAMATAN."</option>\n";
        }
        return $ret;
    }
}
