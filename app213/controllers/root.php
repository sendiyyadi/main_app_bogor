<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class root extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'apps_model',
            'login_model',
			'users_model'
        ));
    }
    
    public function index()
    {
        if (is_login()) {
            redirect(active_module_url());
        } else {
            redirect('login');
        }
    }
    
    function login()
    {        
        $this->session->set_userdata('login', FALSE);
        $this->session->set_userdata('canchangemod', FALSE);
        $this->session->unset_userdata('groupname');
        
        $data['current'] = 'login';
        $data['faction'] = site_url('login');
        
        $data['app_id']      = DEF_MODULE; // from config
        $data['app_enabled'] = SELECT_MODULE; // from config
        
        $this->form_validation->set_error_delimiters('<span>', '</span>');
        $this->form_validation->set_rules('userid', 'User ID', 'required');
        $this->form_validation->set_rules('passwd', 'Password', 'required');
        //$this->form_validation->set_rules('app_id', 'Module', 'required');
        
        $data['dt']['userid'] = $this->input->post('userid');
        $data['dt']['passwd'] = $this->input->post('passwd');
		
        //////////////
        $teks1 = ($this->input->post('userid'));
        $teks2 = ($this->input->post('passwd'));
        //log_activity("login", " userid ".$teks1);
        //
        //*************************************************************************
        $kosong = "x";
        $errMsg = "";
        // 
        $ctr1 = strlen($teks1);
        $ctr2 = strlen($teks2);
        //
        if($ctr1 > 30){
            $errMsg = "User ID max 30 character .....!"; 
        }
        else if($ctr2 > 30){
            $errMsg = "Password max 30 character .....!"; 
        }
        else if (cek_ascii($teks1) == TRUE){
            $errMsg = "User ID tidak valid .....!"; 
        }         
        else if (cek_injek($teks1) == TRUE){
            $errMsg = "User ID tidak valid .....!!"; 
        }
        else if (cek_ascii($teks2) == TRUE){
            $errMsg = "Password tidak valid .....!"; 
        }
        else if (cek_injek($teks2) == TRUE){
            $errMsg = "Password tidak valid .....!!"; 
        }
        else{
            $kosong = ""; 
        }
        //
        if (!empty($kosong))
        {
            $kata = " ";
            //if(cek_injek($teks1) == TRUE){$kata .= $teks1;}
            //if(cek_injek($teks2) == TRUE){$kata .= $teks2;}
            //log_activity("injek", $kata);
                        
            $this->session->set_flashdata('msg_error', $errMsg);
            redirect('login');
        } 
        //********************************************************************************

        if (empty($kosong)) 
        {            
			if ($this->form_validation->run() == TRUE) {
				$uid   = $this->input->post('userid');
				//$pwd   = $this->input->post('passwd');
				//Cek Enkripsi Pwd 21-02-2019
				$pwd   = $this->users_model->encript_value($this->input->post('userid'),$this->input->post('passwd'));
				$login = $this->login_model->check_user($uid);
				//log_message('info', "SSSSSSSSSSSSSSSSSSSSSSSSSSSS SCRIPT ADA : ". $pwd->FN_KEYLOCK );
				if ($login) {

					//if ($login->passwd == $pwd) {
					if ($login->PASSWD == $pwd->FN_KEYLOCK) {
						$this->session->set_userdata('uid', $uid);
						$this->session->set_userdata('userid', $login->USERID);
                        $this->session->set_userdata('userlogin', $login->USERLOGIN);
						$this->session->set_userdata('username', htmlspecialchars($login->USERNAME));
						$this->session->set_userdata('nip', $login->NIP);
						$this->session->set_userdata('login', TRUE);

						$rs = $this->login_model->check_group($login->USERID);

						if ($rs) {
							$this->session->set_userdata('groupid', $rs->ID);
							$this->session->set_userdata('groupkd', $rs->KODE);
							$this->session->set_userdata('groupname', $rs->NAMA);
							
							
							if (is_super_admin()) {
								$this->session->set_userdata('active_module', 'admin');
								$this->session->set_userdata('app_id', $this->login_model->get_appid('admin'));
                                $this->session->set_userdata('app_name', 'ADMIN');
								
							} else {
								if ($uapp = $this->login_model->check_user_app()) {
									$this->session->set_userdata('app_id', $uapp->APP_ID);
                                    $this->session->set_userdata('app_name', $uapp->APP_NAMA);
									$this->session->set_userdata('active_module', $uapp->APP_PATH);
									//$this->session->set_userdata('')
									
									$this->session->set_userdata('groupid', $uapp->GROUP_ID);
									$this->session->set_userdata('groupkd', $uapp->GROUP_KODE);
									$this->session->set_userdata('groupname', htmlspecialchars($uapp->GROUP_NAMA));
									
									if($uapp->modcnt > 1)
										$this->session->set_userdata('canchangemod', true);
	
								} else {
									$this->session->set_flashdata('msg_error', 'No privileges allowed for this user!');
									$this->session->set_userdata('login', FALSE);
								}
							}
							
							if ($this->session->userdata('login') == TRUE) {
								$this->session->set_flashdata('msg_success', 'Selamat datang, ' . htmlspecialchars($login->USERNAME) . '.');
								redirect(active_module_url());
							}
						}
					} else 
						$this->session->set_flashdata('msg_error', 'User ID atau Password salah!');
				} else 
					$this->session->set_flashdata('msg_error', 'User ID tidak terdaftar atau dimatikan!');
				
				redirect('login');
				
			} else {
				$this->session->set_flashdata('msg_warning', 'Harap melengkapi isian!');
				//redirect('login');
			
			} 
		}else {
            $this->session->set_flashdata('msg_warning', 'Harap mengisi user dan password dengan benar (Jangan ada dusta diantara kita)');
			redirect('login');
        }
		
        
        $this->load->view('page_login', $data);
    }
    
    function dologout()
    {
        $this->session->sess_destroy();
        
        $this->session->set_flashdata('msg_info', 'Anda telah logout. Terimakasih.');
        redirect('login');
    }
    
    function info()
    {
        $data['current'] = '';
        $this->load->view('page_info', $data);
    }
    
    function change_module()
    {
        $m = $this->uri->segment(2);

        $this->session->set_userdata('active_module', 'admin');

        $id = $this->login_model->get_appid('admin');
        if ($id) {
            $this->session->set_userdata('app_id', $id->APP_ID);
            $this->session->set_userdata('app_name', 'ADMIN');
        }

        if ($m) {
            $id = $this->login_model->get_appid($m);
            if ($id) {
                $this->session->set_userdata('active_module', $m);
                $this->session->set_userdata('app_id', $id->APP_ID);
                $this->session->set_userdata('app_name', $id->APP_NAMA);
            }
        }
        redirect(active_module_url());
    }

}

/* End of file */
