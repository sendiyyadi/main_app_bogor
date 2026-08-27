<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class sk_njop_model extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }

    public function check_id($kd_propinsi, $kd_dati2, $kd_kecamatan, $kd_kelurahan, $kd_blok, $no_urut, $kd_jns_op){
        $this->db->where('KD_PROPINSI', $kd_propinsi);
        $this->db->where('KD_DATI2', $kd_dati2);
        $this->db->where('KD_KECAMATAN', $kd_kecamatan);
        $this->db->where('KD_KELURAHAN', $kd_kelurahan);
        $this->db->where('KD_BLOK', $kd_blok);
        $this->db->where('NO_URUT', $no_urut);
        $this->db->where('KD_JNS_OP', $kd_jns_op);
        $this->db->where('TAHUN', '2025');
        
        $query = $this->db->get('TEMP_SKNJOP_EADM');
        $count = $query->num_rows();

        // var_dump($count);die;

        return $count + 1;
    }

    public function check_queque($kd_prop, $kd_dati2, $kd_kec, $kd_kel, $kd_blok, $no_urut, $kd_jns_op){
        // $this->db->where('KD_PROPINSI', $kd_prop);
        // $this->db->where('KD_DATI2', $kd_dati2);
        // $this->db->where('KD_KECAMATAN', $kd_kec);
        // $this->db->where('KD_KELURAHAN', $kd_kel);
        // $this->db->where('KD_BLOK', $kd_blok);
        // $this->db->where('NO_URUT', $no_urut);
        // $this->db->where('KD_JNS_OP', $kd_jns_op);
        // $this->db->where('TAHUN', '2025');
        
        // $query = $this->db->get('TEMP_SKNJOP_EADM');
        // $count = $query->num_rows();

        $sql = "SELECT MAX(ID_NOP) AS QQ FROM TEMP_SKNJOP_EADM WHERE KD_PROPINSI ='{$kd_prop}' AND KD_DATI2 = '{$kd_dati2}' AND KD_KECAMATAN ='{$kd_kec}' AND KD_KELURAHAN = '{$kd_kel}' AND KD_BLOK = '{$kd_blok}' AND NO_URUT = '{$no_urut}' AND KD_JNS_OP = '{$kd_jns_op}' AND TAHUN = '2025'";

        // var_dump($sql);die;
        // return $count;
        $query = $this->db->query($sql);
        if ($query->num_rows()!==0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function check_no_sk($no_sk){
        $sql = "SELECT NO_SK FROM TEMP_SKNJOP_EADM WHERE NO_SK='{$no_sk}'";
        $query = $this->db->query($sql);
        if ($query->num_rows()!==0) {
            return true;
        } else {
            return false;
        }
    }

}
