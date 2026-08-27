<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class edit_bayar_sppt_model extends CI_Model
{
	function get_bayar_detail($kd_propinsi, $kd_dati2, $kd_kecamatan, $kd_kelurahan, $kd_blok, $no_urut, $kd_jns_op, $thn_pajak_sppt, $pembayaran)
    {
    	$qry = "select * from pembayaran_sppt where KD_PROPINSI = '{$kd_propinsi}' and KD_DATI2 = '{$kd_dati2}' and KD_KECAMATAN = '{$kd_kecamatan}' and KD_KELURAHAN = '{$kd_kelurahan}' and KD_BLOK = '{$kd_blok}' and NO_URUT = '{$no_urut}' and KD_JNS_OP = '{$kd_jns_op}' and THN_PAJAK_SPPT = '{$thn_pajak_sppt}' and PEMBAYARAN_SPPT_KE = '{$pembayaran}'";
    	// var_dump($pembayaran);die;
    	$query = $this->db->query($qry);
    	if ($query->num_rows() !== 0) {
            return $query->row();
        } else
            return FALSE;
    }

    function update_bayar($kd_propinsi, $kd_dati2, $kd_kecamatan, $kd_kelurahan, $kd_blok, $no_urut, $kd_jns_op, $thn_pajak_sppt, $denda_sppt, $sppt_bayar, $pembayaran) {

    	// var_dump($pembayaran);die;

    	$this->db->where('KD_PROPINSI', $kd_propinsi);
		$this->db->where('KD_DATI2', $kd_dati2);
		$this->db->where('KD_KECAMATAN', $kd_kecamatan);
		$this->db->where('KD_KELURAHAN', $kd_kelurahan);
		$this->db->where('KD_BLOK', $kd_blok);
		$this->db->where('NO_URUT', $no_urut);
		$this->db->where('KD_JNS_OP', $kd_jns_op);
		$this->db->where('THN_PAJAK_SPPT', $thn_pajak_sppt);
		$this->db->where('PEMBAYARAN_SPPT_KE', $pembayaran);

		$existing_data = $this->db->get('PEMBAYARAN_SPPT')->row_array();

		$exist_data = array(
            'DENDA_SPPT' => $existing_data['DENDA_SPPT'],
            'JML_SPPT_YG_DIBAYAR' => $existing_data['JML_SPPT_YG_DIBAYAR']
        );

    	$data = array(
            'DENDA_SPPT' => $denda_sppt,
            'JML_SPPT_YG_DIBAYAR' => $sppt_bayar,
      	);

		$this->db->where('KD_PROPINSI', $kd_propinsi);
		$this->db->where('KD_DATI2', $kd_dati2);
		$this->db->where('KD_KECAMATAN', $kd_kecamatan);
		$this->db->where('KD_KELURAHAN', $kd_kelurahan);
		$this->db->where('KD_BLOK', $kd_blok);
		$this->db->where('NO_URUT', $no_urut);
		$this->db->where('KD_JNS_OP', $kd_jns_op);
		$this->db->where('THN_PAJAK_SPPT', $thn_pajak_sppt);
		$this->db->where('PEMBAYARAN_SPPT_KE', $pembayaran);

		$this->db->update('PEMBAYARAN_SPPT', $data);

		if ($data == $exist_data) {
	        return 0;
	    } elseif ($this->db->affected_rows() > 0) {
	        return 1; // Tidak ada perubahan data
	    } else {
	        return 500; // Ada error
	    }
		
	}
}
