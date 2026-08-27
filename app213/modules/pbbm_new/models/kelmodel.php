<?php
class kelModel extends CI_Model {

  var $tables ='ref_kecamatan';
    private $db_pbbm;

    function __construct() {
        parent::__construct();
        // $this->db_pbbm = $this->load->database('pad', TRUE);
    }

    function getRecord($kec='000',$kel='000')
    {
      $sql="select * from ref_kelurahan
              where kd_propinsi='".KD_PROPINSI."' and kd_dati2='".KD_DATI2."' and kd_kecamatan='$kec' ";
        if ($kel!='000')
            $sql.=" and kd_kelurahan='$kel'";
        // var_dump($sql);die;
        $qry=$this->db->query($sql);
        // var_dump($qry);die;
    return $qry->result();
    }

    // new
    function get_kel_for_select($kec_kode = '000', $selected_kd = '') {
        $ret   = "";
        $where = "where kd_propinsi='".KD_PROPINSI."' and kd_dati2='".KD_DATI2."' and kd_kecamatan='{$kec_kode}' ";
        $kel_kodes = get_kel_kodes();

        if($kel_kodes){
            /*
            log_message('info', "KKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK  : " . $kel_kodes);
            if (empty($kel_kodes)){ // tambahan kondisi by arig
                $kel_kodes = "'000'";
            }
            else{
                $kel_kodes = $kel_kodes[$kec_kode];
            }
            */
            // orinya
            $kel_kodes = $kel_kodes[$kec_kode];
        }
        else {
            $kel_kodes = "'000'";
        }

        if (strpos($kel_kodes,'000') === false){
            
            if (empty($kel_kodes)){
                //log_message('info', "KKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK  : " . $kel_kodes);
                // tambahan kondisi by arig
                $ret = "<option value=\"000\">SEMUA KELURAHAN</option>\n";
                return $ret;
            }
            else{
                $where .= " and kd_kelurahan in ({$kel_kodes})";
            }
            // orinya
            // $where .= " and kd_kelurahan in ({$kel_kodes})";
        }
        else{
            $ret = "<option value=\"000\">SEMUA KELURAHAN</option>\n";
        }

        $sql = "select kd_kelurahan, nm_kelurahan from ref_kelurahan {$where}";
        $qry = $this->db->query($sql);
        $kec = $qry->result();
        foreach ($kec as $row)
        {
            $selected='';
            if ($row->KD_KELURAHAN==$selected_kd) $selected=" selected";
            $ret .= "<option value=\"".$row->KD_KELURAHAN ."\" $selected>".$row->NM_KELURAHAN."</option>\n";
        }
        return $ret;
    }
}
