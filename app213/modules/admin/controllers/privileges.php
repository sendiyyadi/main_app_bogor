<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class privileges extends CI_Controller
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
		$this->load->model(array('privileges_model', 'modules_model'));
	}

	public function index()
	{

		$data['current'] = 'pengaturan';
		$data['apps']    = $this->apps_model->get_active_only();

		$select_app = '';
		$rows   = $this->apps_model->get_active_only();

		if ($rows) {
			foreach ($rows as $row) {
				if ($this->session->userdata('selected_app') == $row->ID)
					$select_app .= '<option value="' . $row->ID . '" selected="selected">' . $row->NAMA . '</option>';
				else
					$select_app .= '<option value="' . $row->ID . '">' . $row->NAMA . '</option>';
			}
		} else {
			$select_app = '<option value="">Tidak ada data!</option>';
		}
		$data['select_app_modul'] = $select_app;
		//----------------------------------------------------------------------------------------------------------
		$app_id = '10';
		$select_data = $this->privileges_model->get_select_menu_utama($app_id);
		// var_dump($select_data);die;
		$options     = array();
		if ($select_data) {
			foreach ($select_data as $row) {
				$options[$row->ROOT_ID] = $row->NAMA;
			}
		} else {
			$options['0'] = 'Data not found';
		}
		$js = 'id="root_id" name="root_id" class="input form-control select2" style="width:185px;" ';
		$data['select_menu_utama'] = preg_replace("/[\r\n]+/", "", form_dropdown('root_id', $options, '0', $js));

		//----------------------------------------------------------------------------------------------------------        
		$this->load->view('privileges/vprivileges', $data);
	}

	function grid_grup_users()
	{
		$i = 0;
		if ($query = $this->privileges_model->get_grup_users()) {
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

	function grid_go()
	{

		$app_id   = $this->input->get('app_id');
		$grup_id  = $this->input->get('grup_id');
		$tp_modul = $this->input->get('tp_modul');
		//$modul_id = $this->input->get('modul_id');
		$root_id  = $this->input->get('root_id');
		//
		$this->session->set_userdata('selected_app', $app_id);
		//
		$i = 0;
		$responce = new stdClass();
		if ($app_id && $grup_id && $query = $this->privileges_model->get_by_app($app_id, $grup_id, $tp_modul, $root_id)) {
			foreach ($query as $row) {

				//log_message('info', " GGGGGGGGGGGGGGGGGGGGGGG CREATE MODULE : ".$row->MODULE_NM );

				$responce->aaData[$i][] = $row->MODULE_ID;
				$responce->aaData[$i][] = $row->KODE;
				$responce->aaData[$i][] = $row->MODULE_NM;
				$responce->aaData[$i][] = '<input type="checkbox" onchange="update_stat(' . $row->GROUP_ID . ',' . $row->MODULE_ID . ',\'reads\', this.checked);"   ' . ($row->READS ? 'checked' : '') . ' name="a">';
				$responce->aaData[$i][] = '<input type="checkbox" onchange="update_stat(' . $row->GROUP_ID . ',' . $row->MODULE_ID . ',\'inserts\', this.checked);" ' . ($row->INSERTS ? 'checked' : '') . ' name="b">';
				$responce->aaData[$i][] = '<input type="checkbox" onchange="update_stat(' . $row->GROUP_ID . ',' . $row->MODULE_ID . ',\'writes\', this.checked);"  ' . ($row->WRITES ? 'checked' : '') . ' name="c">';
				$responce->aaData[$i][] = '<input type="checkbox" onchange="update_stat(' . $row->GROUP_ID . ',' . $row->MODULE_ID . ',\'deletes\', this.checked);" ' . ($row->DELETES ? 'checked' : '') . ' name="d">';
				$responce->aaData[$i][] = $row->PATH_LEVEL;
				$responce->aaData[$i][] = $row->PATH_MENU;
				$responce->aaData[$i][] = $row->ROOT_ID;
				$i++;
			}
			//$responce->iDisplayLength		= "5";
			$responce->sPaginationType		= "full_numbers";
		} else {
			$responce->sEcho = 1;
			$responce->iTotalRecords = "0";
			$responce->iTotalDisplayRecords = "0";
			$responce->aaData = array();
		}
		echo json_encode($responce);
	}

	function grid_btn_go()
	{

		$app_id   = $this->input->get('app_id');
		$grup_id  = $this->input->get('grup_id');
		//$tp_modul = $this->input->get('tp_modul');
		$modul_id = $this->input->get('modul_id');
		//$root_id  = $this->input->get('root_id');

		$this->session->set_userdata('selected_app', $app_id);

		$i = 0;
		$responce = new stdClass();
		if ($app_id && $grup_id && $query = $this->privileges_model->get_by_app_btn($app_id, $grup_id, $modul_id)) {
			foreach ($query as $row) {
				$responce->aaData[$i][] = $row->MODUL_BTN_ID;
				$responce->aaData[$i][] = $row->BTN_NO;
				$responce->aaData[$i][] = $row->KODE_BTN;
				$responce->aaData[$i][] = '<input type="checkbox" onchange="update_stat_role_btn(' . $row->GROUP_ID . ',' . $row->MODULE_ID . ',' . $row->MODUL_BTN_ID . ', this.checked);" ' . ($row->BUTTONS ? 'checked' : '') . ' name="e">';
				$responce->aaData[$i][] = $row->NAMA_BTN;
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

	function get_menu_utama()
	{

		$app_id = $this->uri->segment(4);
		$hasil = $this->privileges_model->get_select_menu_utama($app_id);
		echo json_encode($hasil);
	}

	function update_stat()
	{
		$gid = $this->uri->segment(4);
		$mid = $this->uri->segment(5);
		$fld = $this->uri->segment(6);
		$val = $this->uri->segment(7);
		if ($gid && $mid && $fld) {
			$this->privileges_model->upd_auth($gid, $mid, $fld, $val);
		}
	}

	function upd_stat_role_btn()
	{

		$group_id       = $this->uri->segment(4);
		$modules_id     = $this->uri->segment(5);
		$modules_btn_id = $this->uri->segment(6);
		$flg            = $this->uri->segment(7);

		if ($group_id && $modules_id && $modules_btn_id) {
			$this->privileges_model->upd_auth_role_btn($group_id, $modules_id, $modules_btn_id, $flg);
		}
	}

	//admin - modules
	private function fvalidation($model)
	{
		$this->form_validation->set_error_delimiters('<span>', '</span>');
		$this->form_validation->set_rules('nama', 'Nama Module', 'required');
		$this->form_validation->set_rules('kode', 'Kode', 'required');
		$this->form_validation->set_rules('cek_doubles', 'Data Double', 'callback_cek_double[' . "x" . ']');

		//$tmp_app_id = $tmp_app_id;
		//	$this->form_validation->set_rules('cek_test', 'Data tes', 'callback_cek_tes['.$tmp_app_id.']');

	}

	function cek_double($ver_old, $id)
	{
		$id     = $this->input->post('id');
		$nama   = $this->input->post('nama');
		$kode   = $this->input->post('kode');
		$app_id = $this->input->post('app_id');

		if (empty($nama)) {
			$nama = '';
		}
		if (empty($kode)) {
			$kode = '';
		}
		if (empty($app_id)) {
			$app_id = '0';
		}
		if (empty($id)) {
			$id = '0';
		}

		$filter = "APP_ID =" . $app_id . " and (NAMA ='" . $nama . "' or KODE ='" . $kode . "') and ID<>" . $id;
		//
		$result = $this->db->select('APP_ID')->from('SEC_MODULES')->where($filter, NULL, false)->limit(1)->get()->row();
		//$result = empty ($result->app_id) ? 0 : $result->app_id;
		if (!empty($result)) {
			$this->form_validation->set_message('cek_double', 'Data tersebut sudah ada..!');
			return false;
		} else {
			return true;
		}
	}

	function cek_tes($ver_old, $id)
	{
		$app_id = $this->input->post('app_id');
		$this->form_validation->set_message('cek_tes', ' xxxxxxx app_id : ' . $app_id);
		return false;
	}

	private function fpost()
	{

		$data['id']     = $this->input->post('id');
		$data['kode']   = $this->input->post('kode');
		$data['nama']   = $this->input->post('nama');
		$data['app_id'] = $this->input->post('app_id');

		return $data;
	}

	public function add()
	{

		$tmp_app_id = $this->uri->segment(4);
		$modul_nm   = $this->uri->segment(5); //$this->input->get('modul_nm');
		$post_data  = $this->fpost();
		//
		$data['current']      = 'pengaturan';
		$data['lvl_2'] = 'privileges';
		$data['apps']         = $this->apps_model->get_active_only();
		$data['modul_nm']     = $modul_nm;
		$data['faction']      = active_module_url("privileges/add/{$tmp_app_id}");
		$data['model_form']   = '1'; // add record
		$data['dt']           = $post_data;

		$this->fvalidation('add');
		if ($this->form_validation->run() == TRUE) {
			$data = array(
				'KODE' => $this->input->post('kode'),
				'NAMA' => $this->input->post('nama'),
				'APP_ID' => $this->input->post('app_id'),
			);
			$this->modules_model->save($data);

			$this->session->set_flashdata('msg_success', 'Data telah disimpan');
			redirect(active_module_url('privileges'));
		}
		//
		$data['dt'] = $post_data;
		$get        = (object) $post_data;
		$data['dt']['app_id'] = $tmp_app_id;

		$this->load->view('privileges/vmodules_form', $data);
	}

	public function edit()
	{

		$id = $this->uri->segment(4);
		$modul_nm = $this->uri->segment(5); //$this->input->get('modul_nm');

		$data['current']    = 'pengaturan';
		$data['lvl_2'] = 'privileges';
		$data['apps']       = $this->apps_model->get_active_only();
		$data['modul_nm']   = $modul_nm;
		$data['faction']    = active_module_url('privileges/update');
		$data['model_form'] = '2'; // edit record

		if ($id && $get = $this->modules_model->get($id)) {
			$data['dt']['id'] = $get->id;
			$data['dt']['kode'] = $get->kode;
			$data['dt']['nama'] = $get->nama;
			$data['dt']['app_id'] = $get->app_id;

			$this->load->view('privileges/vmodules_form', $data);
		} else {
			show_404();
		}
	}

	public function update()
	{

		$id = $this->uri->segment(4);
		$modul_nm = $this->uri->segment(5); //$this->input->get('modul_nm');

		$data['current']    = 'pengaturan';
		$data['lvl_2'] = 'privileges';
		$data['apps']       = $this->apps_model->get_active_only();
		$modul_nm           = $this->uri->segment(5); //$this->input->get('modul_nm');
		$data['faction']    = active_module_url('privileges/update');
		$data['model_form'] = '2'; // edit record
		$data['dt'] = $this->fpost();

		$this->fvalidation('edit');
		if ($this->form_validation->run() == TRUE) {
			$data = array(
				//'kode' => $this->input->post('kode'),
				'NAMA' => $this->input->post('nama'),
				//	'app_id' => $this->input->post('app_id'),
			);
			$this->modules_model->update($this->input->post('id'), $data);

			$this->session->set_flashdata('msg_success', 'Data telah disimpan');
			redirect(active_module_url('privileges'));
		}
		$this->load->view('privileges/vmodules_form', $data);
	}

	public function delete()
	{
		$id = $this->uri->segment(4);
		if ($id && $this->modules_model->get($id)) {
			$this->modules_model->delete($id);
			$this->session->set_flashdata('msg_success', 'Data telah dihapus');
			redirect(active_module_url('privileges'));
		} else {
			show_404();
		}
	}

	function tambah_btn_detil()
	{

		$nama      = $this->input->get('nama');
		$module_id = $this->input->get('module_id');
		$kode      = $this->input->get('kode');
		$btn_no      = $this->input->get('btn_no');

		$model    = $this->load->model('privileges_model');
		$usaha_id = $model->tambah_btn_detil($nama, $kode, $module_id, $btn_no);
		echo "sukses";
	}

	function hapus_btn_detil()
	{

		$modules_btn_id = $this->uri->segment(4);
		$model    = $this->load->model('privileges_model');
		$usaha_id = $model->delete_btn_detil($modules_btn_id);
		//echo "sukses";
	}
}
