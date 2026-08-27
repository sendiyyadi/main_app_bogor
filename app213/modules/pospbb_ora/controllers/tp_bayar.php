<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class tp_bayar extends CI_Controller
{
	// MAPPING 
	// kd_kanwil: kd_kanwil
	// kd_kantor: kd_kppbb
	private $module = 'tp_bayar';

	private function pos_field()
	{
		return pos_klm();
	}

	function __construct()
	{

		parent::__construct();

		if (!is_login() || !is_super_admin()) {
			$this->session->set_flashdata('msg_warning', 'Session telah kadaluarsa, silahkan login ulang.');
			redirect('login');
			exit;
		}

		//$module = 'tp_bayar';
		$this->load->library('module_auth', array('module' => $this->module));
		$this->load->model(array('apps_model', 'tp_bayar_model', 'login_model'));

		if ($grp = $this->login_model->check_user_app()) {
			$this->session->set_userdata('groupid', $grp->GROUP_ID);
			$this->session->set_userdata('groupkd', $grp->GROUP_KODE);
			$this->session->set_userdata('groupname', htmlspecialchars($grp->GROUP_NAMA));
		}
	}

	public function index()
	{

		if (!$this->module_auth->read) {
			$this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
			redirect('pospbb_ora');
		}

		$data['apps']      = $this->apps_model->get_active_only();
		$data['page_menu'] = 'm05_mn_users';
		$data['current']   = $this->module;
		$data['tpnm']   = isset($this->session->userdata['tpnm']) ? $this->session->userdata['tpnm'] : '';

		$data['hak_add']    = $this->module_auth->create;
		$data['hak_edit']   = $this->module_auth->update;
		$data['hak_delete'] = $this->module_auth->delete;
		$data['hak_view']   = $this->module_auth->read;

		$this->load->view('tp_bayar/vtp_bayar', $data);
	}

	function grid()
	{

		$i = 0;
		$responce = "";
		$query = $this->tp_bayar_model->get_all();
		if ($query) {
			foreach ($query as $row) {

				//$responce->aaData[$i][] = $row->DUMMY_ID;
				/*
	        	if (DEF_POS_TYPE == 1){
	            	$responce->aaData[$i][]=$row->KD_KANWIL.$row->KD_KANTOR.$row->KD_TP;
	        	}
	        	else {
	            	$responce->aaData[$i][]= $row->KD_BANK_TUNGGAL.$row->KD_BANK_PERSEPSI.$row->KD_KANWIL.$row->KD_KANTOR.$row->KD_TP;
				}
				*/
				$responce->aaData[$i][] = $row->KODE;
				$responce->aaData[$i][] = $row->KD_KANWIL;
				$responce->aaData[$i][] = $row->KD_KANTOR;
				$responce->aaData[$i][] = $row->KD_TP;
				$responce->aaData[$i][] = $row->NM_TP;
				$responce->aaData[$i][] = $row->ALAMAT_TP;
				$responce->aaData[$i][] = $row->NO_REK_TP;
				$i++;
			}
		} else {
			$responce->sEcho = 1;
			$responce->iTotalRecords = "0";
			$responce->iTotalDisplayRecords = "0";
			$responce->aaData = array();
		}
		echo json_encode($responce);
	}

	// admin
	private function fvalidation()
	{

		$this->form_validation->set_error_delimiters('<span>', '</span>');

		if (DEF_POS_TYPE == 1) {
			$this->form_validation->set_rules('kd_kantor', 'Kode', 'trim|required');
		} else {
			$this->form_validation->set_rules('kd_bank_tunggal', 'Kode', 'trim|required');
			$this->form_validation->set_rules('kd_bank_persepsi', 'Kode', 'trim|required');
			$this->form_validation->set_rules('kd_kantor', 'Kode', 'trim|required');
		}
		$this->form_validation->set_rules('kd_kanwil', 'Kode', 'trim|required');
		$this->form_validation->set_rules('kd_tp', 'Kode', 'trim|required');

		$this->form_validation->set_rules('nm_tp', 'Nama', 'trim|required');
		$this->form_validation->set_rules('alamat_tp', 'Alamat', 'trim|required');
	}

	private function fpost()
	{

		$data = array(
			'id' => $this->input->post('id'),
			'kd_kanwil' => $this->input->post('kd_kanwil'),
			'kd_tp' => $this->input->post('kd_tp'),
			'nm_tp' => $this->input->post('nm_tp'),
			'alamat_tp' => $this->input->post('alamat_tp'),
			'no_rek_tp' => $this->input->post('no_rek_tp'),
		);
		if (DEF_POS_TYPE == 2) {
			$data['kd_bank_tunggal'] = $this->input->post('kd_bank_tunggal');
			$data['kd_bank_persepsi'] = $this->input->post('kd_bank_persepsi');
			$data['kd_kantor'] = $this->input->post('kd_kantor');
		} else {
			$data['kd_kantor'] = $this->input->post('kd_kantor');
		}
		return $data;
	}

	public function add()
	{
		$data['current']     = 'master';
		$data['apps']   	 = $this->apps_model->get_active_only();
		$data['faction']     = active_module_url('tp_bayar/add');
		$data['dt']          = $this->fpost();

		$this->fvalidation();
		if ($this->form_validation->run() == TRUE) {
			$data = array(
				//'id' => $this->input->post('id'),
				'KD_KANWIL' => $this->input->post('kd_kanwil'),
				'KD_TP' => $this->input->post('kd_tp'),
				'NM_TP' => $this->input->post('nm_tp'),
				'ALAMAT_TP' => $this->input->post('alamat_tp'),
				'NO_REK_TP' => $this->input->post('no_rek_tp'),
			);
			if (DEF_POS_TYPE == 2) {
				$data['KD_BANK_TUNGGAL'] = $this->input->post('kd_bank_tunggal');
				$data['KD_BANK_PERSEPSI'] = $this->input->post('kd_bank_persepsi');
				$data['KD_KANTOR'] = $this->input->post('kd_kantor');
			} else {
				$data['KD_KANTOR'] = $this->input->post('kd_kantor');
			}
			$user_id = $this->tp_bayar_model->save($data);

			$this->session->set_flashdata('msg_success', 'Data telah disimpan');
			redirect(active_module_url('tp_bayar'));
		}
		$this->load->view('tp_bayar/vtp_bayar_form', $data);
	}

	public function edit()
	{

		if (!$this->module_auth->update) {
			$this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
			redirect(active_module_url('pospbb_ora'));
		}

		$data['page_menu']   = "m05_mn_users";
		$data['current']     = $this->module;
		$data['apps']    = $this->apps_model->get_active_only();
		$data['faction']   = active_module_url('tp_bayar/update');

		$id = $this->uri->segment(4);

		if ($id && $get = $this->tp_bayar_model->get($id)) {

			$data['dt']['id'] = $get->KODE;

			if (DEF_POS_TYPE == 2) {
				$data['dt']['kd_bank_tunggal'] = $get->KD_BANK_TUNGGAL;
				$data['dt']['kd_bank_persepsi'] = $get->KD_BANK_PERSEPSI;
				$data['dt']['kd_kantor'] = $get->KD_KANTOR;
			} else {
				$data['dt']['kd_kantor'] = $get->KD_KANTOR;
			}
			$data['dt']['kd_kanwil'] = $get->KD_KANWIL;
			$data['dt']['kd_tp'] = $get->KD_TP;

			$data['dt']['nm_tp'] = $get->NM_TP;
			$data['dt']['alamat_tp'] = $get->ALAMAT_TP;
			$data['dt']['no_rek_tp'] = $get->NO_REK_TP;

			$this->load->view('tp_bayar/vtp_bayar_form', $data);
		} else {
			show_404();
		}
	}

	public function update()
	{
		$data['current'] = 'master';
		$data['apps']    = $this->apps_model->get_active_only();
		$data['faction'] = active_module_url('tp_bayar/update');
		$data['dt'] = $this->fpost();
		$this->fvalidation();
		if ($this->form_validation->run() == TRUE) {
			$data = array(
				// 'DUMMY_ID' => $this->input->post('id'),
				'KD_KANWIL' => $this->input->post('kd_kanwil'),
				'KD_TP' => $this->input->post('kd_tp'),
				'NM_TP' => $this->input->post('nm_tp'),
				'ALAMAT_TP' => $this->input->post('alamat_tp'),
				'NO_REK_TP' => $this->input->post('no_rek_tp'),
			);
			if (DEF_POS_TYPE == 2) {
				$data['KD_BANK_TUNGGAL'] = $this->input->post('kd_bank_tunggal');
				$data['KD_BANK_PERSEPSI'] = $this->input->post('kd_bank_persepsi');
				$data['KD_KANTOR'] = $this->input->post('kd_kantor');
			} else {
				$data['KD_KANTOR'] = $this->input->post('kd_kantor');
			}

			$user_id = $this->tp_bayar_model->update($this->input->post('id'), $data);

			$this->session->set_flashdata('msg_success', 'Data telah disimpan');
			redirect(active_module_url('tp_bayar'));
		}
		$this->load->view('tp_bayar/vtp_bayar_form', $data);
	}

	public function delete()
	{
		$id = $this->uri->segment(4);
		if ($id && $this->tp_bayar_model->get($id)) {
			if ($id == 1) return;

			if ($this->tp_bayar_model->delete($id))
				$this->session->set_flashdata('msg_success', 'Data telah dihapus');
			else
				$this->session->set_flashdata('msg_error', 'Gagal');

			redirect(active_module_url('tp_bayar'));
		} else {
			show_404();
		}
	}
}
