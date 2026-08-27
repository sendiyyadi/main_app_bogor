<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//author: 

class Module_auth {
    public $create = 0;
    public $read   = 0;
    public $update = 0;
    public $delete = 0;
    public $exec   = 0;
    public $upload = 0;
    
    public $button1 = 0;
    public $button2 = 0;
    public $button3 = 0;
    public $button4 = 0;
    public $button5 = 0;
    public $button6 = 0;
    public $button7 = 0;
    public $button8 = 0;
    public $button9 = 0;
    
    public $msg_create = 'Anda tidak memiliki hak akses untuk menambah data.';
    public $msg_read   = 'Anda tidak memiliki hak akses untuk membaca data pada modul tersebut.';
    public $msg_update = 'Anda tidak memiliki hak akses untuk mengubah data.';
    public $msg_delete = 'Anda tidak memiliki hak akses untuk menghapus data.';
    public $msg_exec   = 'Anda tidak memiliki hak akses untuk mengeksekusi.';
    public $msg_upload = 'Anda tidak memiliki hak akses untuk mengunggah dokumen.';
    
    public function __construct($params) {
        $CI =& get_instance();
        $CI->load->library('session');

        if(is_super_admin()) {
            $this->create = TRUE;
            $this->read   = TRUE;
            $this->update = TRUE;
            $this->delete = TRUE;
            $this->exec   = TRUE;
            $this->upload = TRUE;
            $this->button1 = TRUE;
            $this->button2 = TRUE;
            $this->button3 = TRUE;
            $this->button4 = TRUE;
            $this->button5 = TRUE;
            $this->button6 = TRUE;
            $this->button7 = TRUE;
            $this->button8 = TRUE;
            $this->button9 = TRUE;
        } 
        else {
            //
            $this->create = 0;
            $this->read   = 0;
            $this->update = 0;
            $this->delete = 0;
            //
            $this->button1 = 0;
            $this->button2 = 0;
            $this->button3 = 0;
            $this->button4 = 0;
            $this->button5 = 0;
            $this->button6 = 0;
            $this->button7 = 0;
            $this->button8 = 0;
            $this->button9 = 0;
            //
            $grup_id = lda_group_id();
            $user_id = lda_user_id();
            $app_id  = lda_app_id();
            $modules = $params['module'];

            if (empty($grup_id)){$grup_id = "0";}
            if (empty($user_id)){$user_id = "0";}
            if (empty($app_id)){$app_id = "0";}
            if (empty($modules)){$modules = " ";}
            //
            // modif by arig 2021-06-08 jd tidak melihat grup, tp dasar user langsung ada hak/role
            $qry_OLD = "SELECT gm.reads, gm.writes, gm.deletes, gm.inserts 
            from SEC_GROUP_MODULES gm
            join SEC_MODULES m on m.id=gm.module_id
            where ROWNUM<=1 and gm.group_id={$grup_id}
            and m.kode='{$modules}' and m.app_id={$app_id} ";   
            //log_message('info', "5555555555555555555555555555555555555555 " . $qry);
            $qry = "SELECT max(gm.reads) as READS, max(gm.writes) as WRITES, 
            max(gm.deletes) as DELETES, max(gm.inserts) as INSERTS
            from SEC_GROUPS gr
            join SEC_GROUP_MODULES gm on gm.GROUP_ID=gr.ID
            join SEC_MODULES sm on sm.id=gm.MODULE_ID
            join SEC_USER_GROUPS ug on ug.GROUP_ID=gr.ID
            where sm.kode='{$modules}' and sm.app_id={$app_id} and ug.USER_ID={$user_id} ";
            //
            $auth = $CI->db->query($qry);
            //
            if($auth->num_rows()!==0) {
                foreach ($auth->result() as $row) {
                    $this->create = $row->INSERTS; //$this->create || ($row->INSERTS == 1);
                    $this->read   = $row->READS; //$this->read   || ($row->READS   == 1);
                    $this->update = $row->WRITES; //$this->update || ($row->WRITES  == 1);
                    $this->delete =  $row->DELETES; //$this->delete || ($row->DELETES == 1);
                }
            }
            /*** Role Button Proses atau Cetak ****/
            $qry1_OLD = " SELECT distinct b1.btn_no, b1.kode_btn, nvl(b2.flg_button,0) as buttons 
            from SEC_MODULES m1
            join SEC_MODULES_BTN b1 on b1.module_id=m1.id
            join SEC_GROUP_ROLES_BTN b2 on b2.modules_id=m1.id and b2.modules_btn_id=b1.id
            where b2.flg_button=1 and b2.group_id={$grup_id}
            and m1.kode='{$modules}' and m1.app_id={$app_id}
            order by b1.btn_no ";
            //
            $qry1 = "SELECT distinct b1.btn_no, b1.kode_btn, nvl(b2.flg_button,0) as buttons 
            from SEC_GROUPS gr
            join SEC_GROUP_MODULES gm on gm.GROUP_ID=gr.ID
            join SEC_MODULES sm on sm.id=gm.MODULE_ID
            join SEC_USER_GROUPS ug on ug.GROUP_ID=gr.ID
            join SEC_MODULES_BTN b1 on b1.module_id=sm.id
            join SEC_GROUP_ROLES_BTN b2 on b2.modules_id=sm.id and b2.modules_btn_id=b1.id 
            where b2.flg_button=1 and sm.kode='{$modules}'
            and sm.app_id={$app_id} and ug.USER_ID={$user_id} 
            order by b1.btn_no ";            

            //log_message('info', "6666666666666666666666666666666666666 " . $qry1);
            $auth1 = $CI->db->query($qry1);
            if($auth1->num_rows()!==0) {
                foreach ($auth1->result() as $row) {
                    $btn = $row->BTN_NO;
                    $flg = $row->BUTTONS;
                    if ($btn == 1){$this->button1 = $flg;}
                    else if ($btn == 2){$this->button2 = $flg;}
                    else if ($btn == 3){$this->button3 = $flg;}
                    else if ($btn == 4){$this->button4 = $flg;}
                    else if ($btn == 5){$this->button5 = $flg;}
                    else if ($btn == 6){$this->button6 = $flg;}
                    else if ($btn == 7){$this->button7 = $flg;}
                    else if ($btn == 8){$this->button8 = $flg;}
                    else if ($btn == 9){$this->button9 = $flg;} 
                }
            }
            
        }
         
    }
}
?>
