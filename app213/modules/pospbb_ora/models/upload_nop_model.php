<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class upload_nop_model extends CI_Model
{
    private $tbl = 'TMP_UPLOAD_NOP';
    
    function __construct()
    {
        parent::__construct();
    }
       
    function save_upload($data, $filter) {

        $sql = " select 1 as ctr from TMP_UPLOAD_NOP where ".$filter;
        $query = $this->db->query($sql);
        if ($query->num_rows()!==0) { return FALSE; }
        else { 
            $this->db->insert($this->tbl, $data);
        } 
        
    }
    
    function delete_all_upload($filter) {

        $sql = " delete from TMP_UPLOAD_NOP where ".$filter;
        $query = $this->db->query($sql);
 
    }

}

/* End of file _model.php */
