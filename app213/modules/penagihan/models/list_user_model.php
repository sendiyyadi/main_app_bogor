<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class list_user_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function get($id)
    {
        $this->db->where(M02LOGINNAME, $id);
        $query = $this->db->get(TBL_M02USERS_DS);
        if ($query->num_rows() !== 0) {
            return $query->row();
        } else
            return FALSE;
    }

    public function getUserds()
    {
        $this->load->library('Datatables');

        $this->datatables->select(M02LOGINNAME, M02PASSWOD, M02NAMA, M02EMAIL, M02NIP, M03KETERANGAN, RKD_UPT);
        $this->dataTables->join(TBL_M03USRGROUP_DS, M03USER_GROUP . '=' . M02USER_GROUP, 'left');
        $this->datatables->join(TBL_REF_UPT, M02UPT . '=' . RKD_UPT, 'left');
        // $this->datatables->join(TBL_REF_KELURAHAN, M02KD_KEL . '=' . KD_KELURAHAN . ' and ' . M02KD_KEC . '=' . KD_KECAMATAN_KEL, 'left');
        $this->datatables->from(TBL_M02USERS_DS);

        return $this->datatables->generate();
    }

    public function tambahuserds($loginname, $passwod, $nama, $email, $nip, $user_group, $kd_kec, $kd_kel)
    {
        $sql = "INSERT INTO " . TBL_M02USERS_DS . "(LOGINNAME, PASSWOD, NAMA, EMAIL, NIP, USER_GROUP, KD_KEC, KD_KEL)
        VALUES('$loginname', '$passwod', '$nama', '$email', '$nip', '$user_group', '$kd_kec', '$kd_kel')";

        $query = $this->db->query($sql);

        $rss = $query->result();

        return $this->db->affected_rows();
    }

    public function ambilcamat()
    {
        $sql = "SELECT * FROM " . TBL_REF_KECAMATAN;
        $query = $this->db->query($sql);

        if ($query) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function ambillurah($camatan_id)
    {
        $sql = "SELECT * FROM " . TBL_REF_KELURAHAN . " WHERE " . KD_KECAMATAN_KEL . " = '$camatan_id'";
        $query = $this->db->query($sql);

        if ($query) {
            return $query->result();
        } else {
            return false;
        }
    }

    function get_select_kecamatan()
    {
        $this->db->select(KD_KECAMATAN_KEC . ', ' . NM_KECAMATAN);
        $this->db->order_by(NM_KECAMATAN);
        $query = $this->db->get(TBL_REF_KECAMATAN);
        if ($query->num_rows() !== 0) {
            return $query->result();
        } else
            return FALSE;
    }

    function get_select_kelurahan($kec_id)
    {
        $this->db->select(KD_KELURAHAN . ', ' . NM_KELURAHAN);
        $this->db->where(array(KD_KECAMATAN_KEL => $kec_id));
        $this->db->order_by(NM_KELURAHAN);
        $query = $this->db->get(TBL_REF_KELURAHAN);
        if ($query->num_rows() !== 0) {
            return $query->result();
        } else
            return FALSE;
        // return $this->db->last_query();
    }

    function save_add($data)
    {
        if ($this->db->insert(TBL_M02USERS_DS, $data)) {
            return true;
        } else {
            return false;
        }
    }

    function save_edit($data, $id)
    {
        $this->db->where(M02LOGINNAME, $id);
        if ($this->db->update(TBL_M02USERS_DS, $data)) {
            return true;
        } else {
            return false;
        }
    }

    function save_hapus($id)
    {
        $this->db->where(M02LOGINNAME, $id);
        if ($this->db->delete(TBL_M02USERS_DS)) {
            return true;
        } else {
            return false;
        }
    }
}
