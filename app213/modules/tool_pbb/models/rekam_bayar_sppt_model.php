<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class rekam_bayar_sppt_model extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }

    public function jumlah_pembayaran($nop, $tahun)
    {
    	$sql = "SELECT COUNT(*) AS jumlah_baris
			FROM PEMBAYARAN_SPPT
			WHERE 
			    KD_PROPINSI || KD_DATI2 || KD_KECAMATAN || KD_KELURAHAN || KD_BLOK || NO_URUT || KD_JNS_OP = '{$nop}'
			    AND THN_PAJAK_SPPT = '{$tahun}'";
        $query = $this->db->query($sql);
        if ($query->num_rows() !== 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    // public function insert_pembayaran()
}
