<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class users extends CI_Controller
{

	function __construct()
	{

		parent::__construct();

		if (!is_login() || !is_super_admin()) {
			$this->session->set_flashdata('msg_warning', 'Session telah kadaluarsa, silahkan login ulang.');
			redirect('login');
			exit;
		}

		$this->load->model(array('apps_model'));
		$this->load->model(array('users_model', 'groups_model', 'users_model'));
	}

	public function index()
	{

		$data['current'] = 'pengaturan';
		$data['apps']    = $this->apps_model->get_active_only();
		$this->load->view('users/vusers', $data);
	}

	function grid()
	{

		$i = 0;
		$responce = new stdClass();
		$query = $this->users_model->get_all();
		// var_dump($query); die;
		if ($query) {
			foreach ($query as $row) {
				// var_dump($row); die;
				$responce->aaData[$i][] = $row->ID;
				$responce->aaData[$i][] = $row->USERID;
				$responce->aaData[$i][] = $row->NAMA;
				$responce->aaData[$i][] = $row->NIP;
				$responce->aaData[$i][] = $row->NM_PEGAWAI;
				$responce->aaData[$i][] = $row->JABATAN;
				$responce->aaData[$i][] = $row->EMAIL_REG_USER;
				$responce->aaData[$i][] = '<input type="checkbox" onchange="disable_user(' . $row->ID . ',this.checked);" name="disabled" ' . ($row->DISABLED ? 'checked' : '') . '>';
				$responce->aaData[$i][] = date('d-m-Y', strtotime($row->CREATED_DATE));
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

	function update_unit()
	{

		$id  = $this->uri->segment(4);
		$val = $this->uri->segment(5);
		if ($id && $this->users_model->get($id)) {
			$data = array('allunit' => $val);
			$this->db->where('id', $id);
			$this->db->update('SEC_USERS', $data);
		}
	}

	function disable_user()
	{

		$id  = $this->uri->segment(4);
		$val = $this->uri->segment(5);

		if ($id && $this->users_model->get($id)) {

			$data = array('DISABLED' => $val);
			$this->db->where('ID', $id);
			$this->db->update('SEC_USERS', $data);
		}
	}

	// admin

	// state of group 
	function update_stat()
	{

		$gid = $this->uri->segment(4);
		$uid = $this->uri->segment(5);
		$val = $this->uri->segment(6);
		if ($val == 0) {
			if ($uid == lda_user_id() && $gid == lda_group_id()) {
				// ga bisa
			} else {
				$this->db->where('group_id', $gid);
				$this->db->where('user_id',  $uid);
				$this->db->delete('SEC_USER_GROUPS');
			}
		} else {
			$data = array('group_id' => $gid, 'user_id' => $uid);
			$this->db->insert('SEC_USER_GROUPS', $data);
		}
	}

	private function fvalidation($model)
	{

		$this->form_validation->set_error_delimiters('<span>', '</span>');
		$this->form_validation->set_rules('userid', 'userid', 'required|min_length[1]');
		$this->form_validation->set_rules('nama', 'Uraian', 'required');
		$this->form_validation->set_rules('handphone', 'Handphone', 'required');
		//$this->form_validation->set_rules('passwd', 'Password', 'required|matches[passconf]');
		//$this->form_validation->set_rules('passconf', 'Password (Confirm)', 'required');

		if ($model == 'add') {

			$this->form_validation->set_rules('passwd', 'Password', 'required|min_length[3]|max_length[20]');
			$this->form_validation->set_rules('passconf', 'Password (Confirm)', 'required|min_length[3]|max_length[20]|matches[passwd]');
		} else if ($model == 'edit') {

			if (!empty($this->input->post('passwd')) || !empty($this->input->post('passconf'))) {

				$this->form_validation->set_rules('passwd', 'Password', 'required|min_length[3]|max_length[20]');
				$this->form_validation->set_rules('passconf', 'Password (Confirm)', 'required|min_length[3]|max_length[20]|matches[passwd]');
			}
		}
	}

	private function fpost()
	{

		$data['id'] = $this->input->post('id');
		$data['userid'] = $this->input->post('userid');
		$data['nama'] = $this->input->post('nama');
		$data['passwd'] = $this->input->post('passwd');
		$data['passconf'] = $this->input->post('passconf');
		$data['nip'] = $this->input->post('nip');
		$data['jabatan'] = $this->input->post('jabatan');
		$data['handphone'] = $this->input->post('handphone');
		$data['disabled'] = $this->input->post('disabled') ? 'checked' : '';

		return $data;
	}

	//admin
	public function add()
	{

		$data['current'] = 'pengaturan';
		$data['apps']    = $this->apps_model->get_active_only();
		$data['faction'] = active_module_url('users/add');
		$data['model']   = 'add';
		$data['dt']      = $this->fpost();
		$pwd   	= $this->users_model->encript_value($this->input->post('userid'), $this->input->post('passwd'));

		$this->fvalidation('add');
		if ($this->form_validation->run() == TRUE) {

			$data = array(

				'USERID' => $this->input->post('userid'),
				'NAMA' => $this->input->post('nama'),
				//'passwd' => $this->input->post('passwd'),
				'PASSWD' => $pwd->FN_KEYLOCK,
				'NIP' => $this->input->post('nip'),
				'JABATAN' => $this->input->post('jabatan'),
				'HANDPHONE' => $this->input->post('handphone'),
				'DISABLED' => $this->input->post('disabled') ? 1 : 0,
				'CREATED_DATE' => current_time(),
				'CREATED_BY' => lda_user_login(),
				'UPDATED_DATE' => current_time(),
				'UPDATED_BY' => lda_user_login(),

			);
			$this->users_model->save($data);


			$this->session->set_flashdata('msg_success', 'Data telah disimpan');
			redirect(active_module_url('users'));
		}
		//-----------------------------------------------------------------------
		$select_data = $this->users_model->get_select_pgw_pbb();
		$options = array();
		$options[' '] = 'NIP PEGAWAI';
		if ($select_data) {
			foreach ($select_data as $row) {
				$options[$row->NIP] = $row->NIP . '-' . $row->NM_PEGAWAI;
			}
		}
		$js = 'id="nip" name="nip" class="input form-control select2" ';
		$data['select_nip'] = form_dropdown('nip', $options, $this->input->post('nip'), $js);
		//-----------------------------------------------------------------------		
		$this->load->view('users/vusers_form', $data);
	}

	public function edit()
	{

		$data['current'] = 'pengaturan';
		$data['apps']    = $this->apps_model->get_active_only();
		$data['faction'] = active_module_url('users/update');
		$data['model']   = 'edit';

		$id = $this->uri->segment(4);

		if ($id && $get = $this->users_model->get($id)) {

			$data['dt']['id'] = $get->ID;
			$data['dt']['userid'] = $get->USERID;
			$data['dt']['nama'] = $get->NAMA;
			$data['dt']['passwd'] = ''; //$get->PASSWD;
			$data['dt']['passconf'] = ''; //$get->PASSWD;
			$data['dt']['nip'] = $get->NIP;
			$data['dt']['jabatan'] = $get->JABATAN;
			$data['dt']['handphone'] = $get->HANDPHONE;
			$data['dt']['disabled'] = $get->DISABLED ? 'checked' : '';
			//-----------------------------------------------------------------------
			$select_data = $this->users_model->get_select_pgw_pbb();
			$options = array();
			$options[' '] = 'NIP PEGAWAI';
			if ($select_data) {
				foreach ($select_data as $row) {
					$options[$row->NIP] = $row->NIP . '-' . $row->NM_PEGAWAI;
				}
			}
			$js = 'id="nip" name="nip" class="input form-control select2" ';
			$data['select_nip'] = form_dropdown('nip', $options, $get->NIP, $js);
			//-----------------------------------------------------------------------			
			$this->load->view('users/vusers_form', $data);
		} else {
			show_404();
		}
	}

	public function update()
	{

		$data['current'] = 'pengaturan';
		$data['apps']    = $this->apps_model->get_active_only();
		$data['faction'] = active_module_url('users/update');
		$data['model']   = 'edit';
		$data['dt'] = $this->fpost();
		$cabang = $this->input->post('passwd');
		$pwd = $this->users_model->encript_value($this->input->post('userid'), $cabang);

		$this->fvalidation('edit');

		if ($this->form_validation->run() == TRUE) {

			$data = array(
				//'USERID' => $this->input->post('userid'),
				'NAMA' => $this->input->post('nama'),
				//'passwd' => $this->input->post('passwd'),
				//'PASSWD' => $pwd->FN_KEYLOCK,
				'NIP' => $this->input->post('nip'),
				'JABATAN' => $this->input->post('jabatan'),
				'HANDPHONE' => $this->input->post('handphone'),
				'DISABLED' => $this->input->post('disabled') ? 1 : 0,
				'UPDATED_DATE' => current_time(),
				'UPDATED_BY' => lda_user_login(),
			);

			if (!empty($cabang)) {
				$data = array_merge($data, array('PASSWD' => $pwd->FN_KEYLOCK));
			}

			$this->users_model->update($this->input->post('id'), $data);

			$this->session->set_flashdata('msg_success', 'Data telah disimpan');
			redirect(active_module_url('users'));
		}
		//-----------------------------------------------------------------------
		$select_data = $this->users_model->get_select_pgw_pbb();
		$options = array();
		$options[' '] = 'NIP PEGAWAI';
		if ($select_data) {
			foreach ($select_data as $row) {
				$options[$row->NIP] = $row->NIP . '-' . $row->NM_PEGAWAI;
			}
		}
		$js = 'id="nip" name="nip" class="input" style="width: 250px" ';
		$data['select_nip'] = form_dropdown('nip', $options, $this->input->post('nip'), $js);
		//-----------------------------------------------------------------------		
		$this->load->view('users/vusers_form', $data);
	}

	public function delete()
	{

		$id = $this->uri->segment(4);
		if ($id && $this->users_model->get($id)) {
			$this->db->delete('SEC_USER_GROUPS', array('USER_ID' => $id));

			if ($this->users_model->delete($id))
				$this->session->set_flashdata('msg_success', 'Data telah dihapus');
			else
				$this->session->set_flashdata('msg_error', 'Gagal');

			redirect(active_module_url('users'));
		} else {
			show_404();
		}
	}
}
