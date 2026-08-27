<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class update_sppt_model extends CI_Model
{
    public function update_sppt($nop, $thn_pajak_sppt, $data)
    {
        $this->db->where('(KD_PROPINSI||KD_DATI2||KD_KECAMATAN||KD_KELURAHAN||KD_BLOK||NO_URUT||KD_JNS_OP)', $nop);
        $this->db->where('thn_pajak_sppt', $thn_pajak_sppt);
        $result = $this->db->update_oen_ora('SPPT', $data);
        return $result;
    }

    public function apdet_sppt($kd_propinsi, $kd_dati2, $kd_kecamatan, $kd_kelurahan, $kd_blok, $no_urut, $kd_jns_op, $tahun, $status)
    {
        $this->db->where('KD_PROPINSI', $kd_propinsi);
        $this->db->where('KD_DATI2', $kd_dati2);
        $this->db->where('KD_KECAMATAN', $kd_kecamatan);
        $this->db->where('KD_KELURAHAN', $kd_kelurahan);
        $this->db->where('KD_BLOK', $kd_blok);
        $this->db->where('NO_URUT', $no_urut);
        $this->db->where('KD_JNS_OP', $kd_jns_op);
        $this->db->where('THN_PAJAK_SPPT', $tahun);

        $existing_data = $this->db->get('SPPT')->row_array();

        $exist_data = array(
            'STATUS_PEMBAYARAN_SPPT' => $existing_data['STATUS_PEMBAYARAN_SPPT']
        );

        $data = array(
            'STATUS_PEMBAYARAN_SPPT' => $status
        );

        // var_dump($data);die;

        $this->db->where('KD_PROPINSI', $kd_propinsi);
        $this->db->where('KD_DATI2', $kd_dati2);
        $this->db->where('KD_KECAMATAN', $kd_kecamatan);
        $this->db->where('KD_KELURAHAN', $kd_kelurahan);
        $this->db->where('KD_BLOK', $kd_blok);
        $this->db->where('NO_URUT', $no_urut);
        $this->db->where('KD_JNS_OP', $kd_jns_op);
        $this->db->where('THN_PAJAK_SPPT', $tahun);
        $this->db->update('SPPT', $data);

        // var_dump($data);die;
        // echo $this->db->last_query();

        if ($data == $exist_data) {
            return 0;
        } elseif ($this->db->affected_rows() > 0) {
            return 1; // Tidak ada perubahan data
        } else {
            // var_dump('hehee');die;
            return 500; // Ada error
        }
    }
}
