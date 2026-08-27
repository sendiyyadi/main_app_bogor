<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class tp_model extends CI_Model {
    private $tbl = 'tempat_pembayaran';
    private $db_pbbm;

    function __construct() {
        parent::__construct();
        $this->db_pbbm = $this->load->database('default', TRUE);
    }

    function get_all() {
        $this->db_pbbm->trans_start();
        $query = $this->db_pbbm->get($this->tbl);
        $this->db_pbbm->trans_complete();

        if($this->db_pbbm->trans_status() && $query->num_rows()>0)
            return $query->result();
        else
            return false;
    }

    function get($id)
    {
        $this->db_pbbm->trans_start();
        $this->db_pbbm->where('id',$id);
        $query = $this->db_pbbm->get($this->tbl);
        $this->db_pbbm->trans_complete();

        if($this->db_pbbm->trans_status() && $query->num_rows()>0)
            return $query->row();
        else
            return false;
    }

    function get_select() {
        $fields     = explode(',', POS_FIELD);
        $pos_kode = '';
        $fs = '';
        foreach ($fields as $f) {
            $fs = $f;
            if ($f == 'kd_kanwil_bank')
                $fs = 'kd_kanwil';
            else if ($f == 'kd_kppbb_bank')
                $fs = 'kd_kppbb';

            $pos_kode .= "tp.{$fs}||";
        }
        $pos_kode = substr($pos_kode, 0, -2);


        $sql   = "select {$pos_kode} kode, tp.nm_tp from tempat_pembayaran tp";
        $query = $this->db_pbbm->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    //-- admin
    function save($data) {
        $this->db_pbbm->trans_start();
        $this->db_pbbm->insert($this->tbl,$data);
        $this->db_pbbm->trans_complete();

        if($this->db_pbbm->trans_status())
            return $this->db_pbbm->insert_id();
        else
            return false;
    }

    function update($id, $data) {
        $this->db_pbbm->trans_start();
        $this->db_pbbm->where('id', $id);
        $this->db_pbbm->update($this->tbl,$data);
        $this->db_pbbm->trans_complete();

        if($this->db_pbbm->trans_status())
            return true;
        else
            return false;
    }

    function delete($id) {
        $this->db_pbbm->trans_start();
        $this->db_pbbm->where('id', $id);
        $this->db_pbbm->delete($this->tbl);
        $this->db_pbbm->trans_complete();

        if($this->db_pbbm->trans_status())
            return true;
        else
            return false;
    }
}

/* End of file _model.php */