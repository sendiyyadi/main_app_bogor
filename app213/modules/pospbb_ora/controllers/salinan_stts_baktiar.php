<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class salinan_stts extends CI_Controller 
{
	function __construct() 
    {
		parent::__construct();
		if(!$this->session->userdata('login')) {
			$this->session->set_flashdata('msg_warning', 'Session telah kadaluarsa, silahkan login ulang.');
			redirect('login');
			exit;
		}
        
        if(!is_super_admin() && !isset($this->session->userdata['tpnm'])) {
            show_404();
            exit;
        }

        $module = 'salinan_stts';
        $this->load->library('module_auth', array('module' => $module));

        $this->load->helper('app_helper');
        $this->load->model(array( 'apps_model', 'login_model', 'payment_model' ));
 
        if ($grp = $this->login_model->check_user_app()) {            
            $this->session->set_userdata('groupid'  , $grp->GROUP_ID);
            $this->session->set_userdata('groupkd'  , $grp->GROUP_KODE);
            $this->session->set_userdata('groupname', htmlspecialchars($grp->GROUP_NAMA));
        } 
	}
		
	public function index() 
    {
		if(!$this->module_auth->read) {
			$this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
			redirect('pospbb_ora');
		}

        $data['page_menu'] = 'm02_mn_stts';
        $data['current']   = 'salinan_stts'; // stts

		$filter = $this->session->userdata('pos_filter');
		$filter = isset($filter) ? $filter : '';
		$data['filter']  = $filter;
        $data['tpnm'] = isset($this->session->userdata['tpnm']) ? $this->session->userdata['tpnm'] : '';

		$data['apps']    = $this->apps_model->get_active_only();
		//$data['current'] = 'stts';
        
		$this->load->view('vsalinan_stts', $data);
	}
	
	public function cari() {

		if(!$this->module_auth->read) {
			$this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
			redirect('pospbb_ora');
		}

		$nop = $this->uri->segment(4);
		$thn = $this->uri->segment(5);
		$ke  = $this->uri->segment(6);
     
		if($nop && $thn && $ke && $query = $this->payment_model->get_by_nop_thn_ke($nop, $thn, $ke)) 
        {
            if(is_super_admin() || $query->NIP_REKAM_BYR_SPPT == $this->session->userdata('userid')) 
            {                
                $terbilang=terbilang($query->JML_SPPT_YG_DIBAYAR);
                $query =  (object) array_merge((array)$query, array('found'=>1, 'terbilang'=>$terbilang));
                echo json_encode($query);
                exit;
            }
        }
        
        $result['found'] = 0;
        echo json_encode($result);
	}

	public function cetak_draft() {

		$nop = $this->uri->segment(4);
		$thn = $this->uri->segment(5);
        $ke  = $this->uri->segment(6);
        
        $this->load->model(array('payment_model'));

		if($nop && $thn && $query = $this->payment_model->get_by_nop_thn_ke($nop, $thn,$ke)) {
        $this->load->view("vstts1_dpk",$query);
		} 
	}
  
    public function  cetak_bank_draft() {

	   $nop = $this->uri->segment(4);
	   $thn = $this->uri->segment(5);
        $ke  = $this->uri->segment(6);
        $this->load->model(array('payment_model'));
		if($nop && $thn && $query = $this->payment_model->get_by_nop_thn_ke($nop, $thn,$ke)) {
            $this->load->view("vstts3_dpk",$query);
        }
    }

}
