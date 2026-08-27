<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class groups extends CI_Controller
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
		$this->load->model(array('groups_model'));
	}

	public function index()
	{

		$data['current'] = 'pengaturan';
		$data['lvl_2'] = 'groups';
		$data['apps']    = $this->apps_model->get_active_only();

		$options = array(
			'9' => 'SEMUA',
			'1' => 'PEMDA',
			'2' => 'WR',
			'3' => 'OR',
			'4' => 'PASAR',
		);
		$js = 'id="level_id" class="form-control select2 w-auto" ';
		$select = form_dropdown('level_id', $options, 9, $js);
		$select = preg_replace("/[\r\n]+/", "", $select);
		$data['select_level_id'] = $select;
		//----------------------------------------------------------------------------------------------------------
		$options = array(
			'0' => 'Semua',
			'1' => 'Disabled',
			'2' => 'Enabled',
		);
		$js = 'id="disabled_id" class="form-control select2 w-auto" ';
		$data['select_disabled'] = preg_replace("/[\r\n]+/", "", form_dropdown('disabled_id', $options, '0', $js));
		//----------------------------------------------------------------------------------------------------------		
		$this->load->view('groups/vgroups', $data);
	}

	function grid()
	{

		$i = 0;
		$responce = new stdClass();
		if ($query = $this->groups_model->get_all()) {
			foreach ($query as $row) {
				$responce->aaData[$i][] = $row->ID;
				$responce->aaData[$i][] = $row->KODE;
				$responce->aaData[$i][] = $row->NAMA;
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

	function grid_users_in_grup()
	{

		$group_id       = $this->input->get('group_id');
		$in_group_only  = $this->input->get('in_grup');
		$disabled_id    = $this->input->get('sts_disabled');
		$userlogin      = $this->input->get('usr_login');
		$user_nama      = $this->input->get('nama');
		$level_id       = $this->input->get('lvl_id');

		if (empty($group_id)) {
			$group_id = '0';
		}
		if (empty($in_group_only)) {
			$in_group_only = '0';
		}
		if (empty($disabled_id)) {
			$disabled_id = '0';
		}
		if (empty($userlogin)) {
			$userlogin = '0';
		}
		if (empty($user_nama)) {
			$user_nama = '0';
		}
		//
		if (empty($level_id)) {
			$level_id = 9;
		}

		$i = 0;
		$responce = new stdClass();

		if ($group_id && $query = $this->groups_model->get_select_users_in_group($group_id, $level_id, $in_group_only, $disabled_id, $userlogin, $user_nama)) {

			// var_dump($query); die;

			foreach ($query as $row) {

				$responce->aaData[$i][] = $row->ID;
				$responce->aaData[$i][] = '<input type="checkbox" onchange="update_stat(' . $row->GROUP_ID . ',' . $row->ID . ',this.checked);" name="ingroup" ' . ($row->IN_GROUP ? 'checked' : '') . '>';
				$responce->aaData[$i][] = $row->USERID;
				$responce->aaData[$i][] = $row->NAMA;
				$responce->aaData[$i][] = $row->LEVEL_NAMA;
				$responce->aaData[$i][] = '<input type="checkbox" disabled="disabled" name="disabled" ' . ($row->DISABLED ? 'checked' : '') . '>';
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

	//admin
	private function fvalidation()
	{
		$this->form_validation->set_error_delimiters('<span>', '</span>');
		$this->form_validation->set_rules('nama', 'Nama Group', 'required');
		$this->form_validation->set_rules('kode', 'Kode', 'required');
	}

	private function fpost()
	{
		$data['id'] = $this->input->post('id');
		$data['kode'] = $this->input->post('kode');
		$data['nama'] = $this->input->post('nama');
		$data['locked'] = $this->input->post('locked');

		return $data;
	}

	public function add()
	{
		$data['current'] = 'pengaturan';
		$data['apps']    = $this->apps_model->get_active_only();
		$data['faction'] = active_module_url('groups/add');
		$data['dt']      = $this->fpost();

		$this->fvalidation();
		if ($this->form_validation->run() == TRUE) {

			$data_add = array(
				//'KODE' => $this->input->post('kode'),
				'NAMA' => $this->input->post('nama'),
				'KODE' => $this->input->post('kode'),
				'LOCKED' => $this->input->post('locked')
			);

			$result = $this->groups_model->insert_data($data_add);
			if (!empty($result)) {
				set_msg_db_error($result);
			} else {
				$this->session->set_flashdata('msg_success', 'Data telah disimpan');
				redirect(active_module_url('groups'));
			}
		}
		$this->load->view('groups/vgroups_form', $data);
	}

	public function edit()
	{

		$data['current'] = 'pengaturan';
		$data['apps']    = $this->apps_model->get_active_only();
		$data['faction'] = active_module_url('groups/update');

		$id = $this->uri->segment(4);

		if ($id && $this->groups_model->is_locked($id)) {
			$this->session->set_flashdata('msg_warning', 'Data terkunci, tidak dapat diedit atau dihapus');
			redirect(active_module_url('groups'));
		}

		if ($id && $get = $this->groups_model->get($id)) {
			$data['dt']['id'] = $get->ID;
			$data['dt']['kode'] = $get->KODE;
			$data['dt']['nama'] = $get->NAMA;
			$data['dt']['locked'] = $get->LOCKED;

			$this->load->view('groups/vgroups_form', $data);
		} else {
			show_404();
		}
	}

	public function update()
	{

		$data['current'] = 'pengaturan';
		$data['lvl_2'] = 'groups';
		$data['apps']    = $this->apps_model->get_active_only();
		$data['faction'] = active_module_url('groups/update');
		$data['dt'] = $this->fpost();

		$this->fvalidation();
		if ($this->form_validation->run() == TRUE) {

			$update_data = array(
				//'kode' => $this->input->post('kode'),
				'NAMA' => $this->input->post('nama'),
				'KODE' => $this->input->post('kode'),
				'LOCKED' => $this->input->post('locked')
			);

			$result = $this->groups_model->update_data($this->input->post('id'), $update_data);
			if (!empty($result)) {
				set_msg_db_error($result);
			} else {
				$this->session->set_flashdata('msg_success', 'update Data telah disimpan');
				redirect(active_module_url('groups'));
			}
		}
		$this->load->view('groups/vgroups_form', $data);
	}

	public function delete()
	{

		$id = $this->uri->segment(4);

		if ($id && $this->groups_model->is_locked($id)) {
			$this->session->set_flashdata('msg_warning', 'Data terkunci, tidak dapat diedit atau dihapus');
			redirect(active_module_url('groups'));
		}

		if ($id && $this->groups_model->get($id)) {

			$this->db->delete('SEC_GROUP_MODULES', array('GROUP_ID' => $id));

			$result = $this->groups_model->delete_data($id);

			if (!empty($result)) {
				$this->session->set_flashdata('msg_error', $result);
			} else {
				$this->session->set_flashdata('msg_success', 'Delete Data telah dihapus');
			}
			redirect(active_module_url('groups'));
		} else {
			show_404();
		}
	}

	// state of group
	function update_stat_users_in_grup()
	{

		$gid = $this->uri->segment(4);
		$uid = $this->uri->segment(5);
		$val = $this->uri->segment(6);
		if ($val == 0) {
			if ($uid == lda_user_id() && $gid == lda_group_id()) {
				// ga bisa
			} else {
				$this->db->where('GROUP_ID', $gid);
				$this->db->where('USER_ID',  $uid);
				$this->db->delete('SEC_USER_GROUPS');
			}
		} else {
			$data = array('GROUP_ID' => $gid, 'USER_ID' => $uid);
			$this->db->insert('SEC_USER_GROUPS', $data);
		}
	}
}
