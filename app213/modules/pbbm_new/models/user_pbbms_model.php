<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class user_pbbms_model extends CI_Model
{
    private $tbl = 'user_pbbms';
    private $db_pbbm;

    function __construct()
    {
        parent::__construct();
        $this->db_pbbm = $this->load->database('default', TRUE);
    }

    function get_user($id)
    {
        $this->db->where('ID', $id);
        $query = $this->db->get('USERS_M');
        if ($query->num_rows() !== 0) {
            return $query->row();
        } else
            return FALSE;
    }

    function get_user_pbbm()
    {
        $sql = "select u.* from users_m u
            inner join user_groups_m ug on ug.user_id=u.id
            inner join groups_m g on g.id=ug.group_id
            where g.kode = 'pbbm'
            order by u.nama";

        $query = $this->db->query($sql);
        if ($query->num_rows() !== 0) {
            return $query->result();
        } else
            return FALSE;
    }

    //----------------------------------------------------------------------------------------------------------------------------------

    function get_all()
    {
        $sql = "select up.id, 'x' nama, 0 disabled, null as created, up.user_id, up.kd_propinsi, up.kd_dati2, up.kd_kecamatan, up.kd_kelurahan, kel.nm_kelurahan, kec.nm_kecamatan
            from user_pbbms up
            left join ref_kecamatan kec on up.kd_propinsi=kec.kd_propinsi and up.kd_dati2=kec.kd_dati2 and up.kd_kecamatan=kec.kd_kecamatan
            left join ref_kelurahan kel on up.kd_propinsi=kel.kd_propinsi and up.kd_dati2=kel.kd_dati2 and up.kd_kecamatan=kel.kd_kecamatan and up.kd_kelurahan=kel.kd_kelurahan
            order by up.kd_propinsi, up.kd_dati2, up.kd_kecamatan, up.kd_kelurahan";

        $query = $this->db->query($sql);
        $rows  = $query->num_rows();
        if ($rows !== 0) {
            $data = $query->result_array();
            for ($i = 0; $i < $rows; $i++) {
                $user = $this->get_user($data[$i]['user_id']);
                if ($user) {
                    $data[$i]['nama'] = $user->NAMA;
                    $data[$i]['disabled'] = $user->DISABLED;
                    $data[$i]['created'] = $user->CREATED;
                }
            }
            $ret = $data;
            return $ret;
        } else
            return FALSE;
    }

    function get($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get($this->tbl);
        if ($query->num_rows() !== 0) {
            return $query->row();
        } else
            return FALSE;
    }

    function get_by_kec_kel($kec_kd = '000', $kel_kd = '000')
    {
        $sql = "SELECT u.*
            FROM users_m u
            INNER JOIN user_pbbms up ON u.id=up.user_id
            WHERE 1=1 ";
        if ($kec_kd != '000')
            $sql .= " AND up.kd_kecamatan='{$kec_kd}' ";
        if ($kel_kd != '000')
            $sql .= " AND up.kd_kelurahan='{$kel_kd}' ";

        $query = $this->db->query($sql);
        if ($query->num_rows() !== 0) {
            return $query->result();
        } else
            return FALSE;
    }

    //-- admin
    function save($data)
    {
        $this->db->insert($this->tbl, $data);
        // return $this->db->insert_id();
    }

    function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update($this->tbl, $data);
    }

    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->tbl);
    }
}

/* End of file _model.php */