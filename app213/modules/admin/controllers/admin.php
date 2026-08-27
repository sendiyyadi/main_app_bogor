<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
        if (!$this->session->userdata('login')) {
            $this->session->set_flashdata('msg_warning', 'Session telah kadaluarsa, silahkan login ulang.');
            redirect('login');
            exit;
        }

		if(active_module()!='admin') { 
		  if(!is_super_admin()) {
			    redirect('logout');
			}
		}
		$this->load->model(array('apps_model','admin_model'));
	}
	
	public function index()
	{
		$data['current'] = 'beranda';
		$data['apps']    = $this->apps_model->get_active_only();

        $user_login = lda_user_login(); 
        if ($user_login == "sa") {
           $this->grup_app();
            
        }

		$this->load->view('vmain', $data);
	}

    function grup_app() {

        //log_message('info', "BBBBBBBBBB CREATE MODULE : " );
        //$app_id = lda_app_id();
        // Create grup Menu Utama Referensi
        $this->admin_model->add_grup_menu('POSPBB','Group Pos PBB Admin');

    }

}
