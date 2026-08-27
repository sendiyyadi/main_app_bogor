<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class pos_user extends CI_Controller
{

	// MAPPING 
	// kd_kanwil: kd_kanwil
	// kd_kantor: kd_kppbb
	private $module = 'pos_user';

	function __construct()
	{

		parent::__construct();

		if (!is_login() || !is_super_admin()) {
			$this->session->set_flashdata('msg_warning', 'Session telah kadaluarsa, silahkan login ulang.');
			redirect('login');
			exit;
		}

		//$module = 'pos_user';
		$this->load->library('module_auth', array('module' => $this->module));

		//$this->load->helper(active_module());
		$this->load->helper('app_helper');
		$this->load->model(array('apps_model', 'login_model', 'pos_user_model', 'tp_bayar_model'));

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

		$data['page_menu'] = 'm05_mn_users';
		$data['current']   = $this->module;

		$data['apps']   = $this->apps_model->get_active_only();
		$data['tpnm']   = isset($this->session->userdata['tpnm']) ? $this->session->userdata['tpnm'] : '';

		$data['hak_add']    = $this->module_auth->create;
		$data['hak_edit']   = $this->module_auth->update;
		$data['hak_delete'] = $this->module_auth->delete;
		$data['hak_view']   = $this->module_auth->read;

		$this->load->view('pos_user/vpos_user', $data);
	}

	function grid()
	{

		$i = 0;
		$responce = "";
		$query = $this->pos_user_model->get_all_pos_user(); // arig

		if ($query) {
			foreach ($query as $row) {
				$responce->aaData[$i][] = $row->ID;
				$responce->aaData[$i][] = $row->USERID;
				$responce->aaData[$i][] = $row->NAMA;
				$responce->aaData[$i][] = $row->NIP;
				$responce->aaData[$i][] = $row->NM_PEGAWAI;
				$responce->aaData[$i][] = $row->JABATAN;
				$responce->aaData[$i][] = $row->NM_TP;
				$responce->aaData[$i][] = $row->ALAMAT_TP;
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
		$this->form_validation->set_rules('grp_tp', 'Tempat Pembayaran', 'trim|required');
	}

	private function fpost()
	{

		$data['id'] = $this->input->post('id');
		$data['userid'] = $this->input->post('userid');
		$data['nama'] = $this->input->post('nama');
		$data['grp_tp'] = $this->input->post('grp_tp');
		$data['nip'] = $this->input->post('nip');
		$data['jabatan'] = $this->input->post('jabatan');
		$data['passwd'] = $this->input->post('passwd');
		$data['disabled'] = $this->input->post('disabled');
		return $data;
	}

	public function add()
	{
		$data['current']     = 'master';
		$data['apps']   	 = $this->apps_model->get_active_only();
		$data['faction']     = active_module_url('pos_user/add');
		$data['dt']          = $this->fpost();

		// $tp = '';
		// $select_data  = $this->pos_user_model->get_all();
		// if ($select_data)
		$select_data = $this->load->model('tp_bayar_model')->get_select_tp_bayar();
		$options     = array();
		$options['0'] = 'Pilih Tmp.Pembayaran';
		foreach ($select_data as $row) {
			$options[$row->KODE] = $row->NM_TP;
		}
		$js = 'id="grp_tp" name="grp_tp" class="input form-control select2" ';
		$data['select_grp_tp_bayar'] = form_dropdown('grp_tp', $options, '0', $js);

		$this->fvalidation();
		if ($this->form_validation->run() == TRUE) {
			$cabang = $this->pos_user_model->encript_value($this->input->post('userid'), $this->input->post('passwd'));
			$kunci  = $cabang->FN_KEYLOCK;
			$kun = (string)$this->input->post('userid');
			$data = array(
				'USERID' => $this->input->post('userid'),
				'NAMA' => $this->input->post('nama'),
				// grp_tp
				// 'passwd' => $this->input->post('passwd'),
				'PASSWD' => $kunci,
				'NIP' => $this->input->post('nip'),
				'JABATAN' => $this->input->post('jabatan'),
				'DISABLED' => $this->input->post('disabled') ? 1 : 0,
				// 'updated' => date('Y-m-d')
				'CREATED_DATE' => date('Y-m-d'),
			);

			$uss = $this->pos_user_model->save($data);

			if ($uss) {
				// var_dump('ok');die;
				$user_id = $this->pos_user_model->get_k($kun);
				$aa = $user_id->ID;
				$bb = $user_id->USERID;

				$group_id = $this->db->query("SELECT id FROM SEC_GROUPS WHERE kode='POSPBB'")->row()->ID;  // grp "pospbb" <---------------------------

				// $query = $this->db->query("SELECT id FROM SEC_GROUPSb WHERE kode='POSPBB'");
				// $result = $query->row();

				// var_dump($result);die;

				if (!empty($group_id)) {
					$data = array(
						'USER_ID'  => $aa,
						'GROUP_ID' => $group_id,
					);
					$this->db->insert('SEC_USERS', $data);
				}

				// masukin ke user pbb
				$tpp = $this->input->post('grp_tp');

				$KD_KANWIL = substr($tpp, 0, 2);
				$KD_KANTOR  = substr($tpp, 2, 2);
				$KD_TP  = substr($tpp, 4, 2);
				// var_dump($tpp);die;
				// $tp = explode('|',$this->input->post('tp'));
				// var_dump($tp);die;
				$data = array(
					'USERID' => $bb,
					'KD_KANWIL'  => $KD_KANWIL,
					'KD_KANTOR' => $KD_KANTOR,
					'KD_TP' => $KD_TP,
					'DISABLED' => $this->input->post('disabled') ? 1 : 0,
					'CREATED_DATE' => date('Y-m-d'),
				);

				// $fields = explode(',', $this->pos_field());
				// $data = array(); $i=0;

				// foreach ($fields as $f) {
				//     $data[$f] = $tp[$i];
				//     $i++;
				// }

				// $data['user_id'] = $user_id;

				// var_dump($data);die;

				$this->db->insert('USER_PBB', $data);
			}

			$this->session->set_flashdata('msg_success', 'Data telah disimpan');
			redirect(active_module_url('pos_user'));
		}
		$this->load->view('pos_user/vpos_user_form', $data);
	}

	public function edit()
	{

		if (!$this->module_auth->update) {
			$this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
			redirect(active_module_url('pos_user'));
		}

		$data['apps']    = $this->apps_model->get_active_only();
		$data['faction']   = active_module_url('pos_user/update');

		$data['page_menu'] = 'm05_mn_users';
		$data['current']   = $this->module;
		$data['tpnm']   = isset($this->session->userdata['tpnm']) ? $this->session->userdata['tpnm'] : '';

		$id = $this->uri->segment(4);

		if ($id && $get = $this->pos_user_model->get_user_pbb($id)) {

			$data['dt']['id'] = $get->ID;
			$data['dt']['userid'] = $get->USERID;
			$data['dt']['nama'] = $get->NAMA;
			$data['dt']['grp_tp'] = $get->GRP_TP;
			$data['dt']['nip'] = $get->NIP;
			$data['dt']['jabatan'] = $get->JABATAN;

			$data['dt']['passwd'] = $get->PASSWD;
			$data['dt']['disabled'] = $get->DISABLED ? 'checked' : '';
			//-----------------------------------------------------------------------
			$grp_tp = (isset($_GET['grp_tp']) ? $_GET['grp_tp'] : '');
			$select_data = $this->load->model('tp_bayar_model')->get_select_tp_bayar();
			$options     = array();
			$options['0'] = 'Pilih Tmp.Pembayaran';
			foreach ($select_data as $row) {
				$options[$row->KODE] = $row->NM_TP;
			}
			$js = 'id="grp_tp" name="grp_tp" class="input form-control select2" ';
			$data['select_grp_tp_bayar'] = form_dropdown('grp_tp', $options, $get->GRP_TP, $js);
			//-----------------------------------------------------------------------
			$this->load->view('pos_user/vpos_user_form', $data);
		} else {
			show_404();
		}
	}

	public function update()
	{

		if (!$this->module_auth->update) {
			$this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
			redirect(active_module_url('pos_user'));
		}

		$data['page_menu'] = 'm05_mn_users';
		$data['current']   = $this->module;
		$data['tpnm']   = isset($this->session->userdata['tpnm']) ? $this->session->userdata['tpnm'] : '';

		$data['apps']    = $this->apps_model->get_active_only();
		$data['faction'] = active_module_url('pos_user/update');
		$data['dt'] = $this->fpost();
		//
		//-----------------------------------------------------------------------
		$grp_tp = (isset($_GET['grp_tp']) ? $_GET['grp_tp'] : '');
		$select_data = $this->load->model('tp_bayar_model')->get_select_tp_bayar();
		$options     = array();
		$options['0'] = 'Pilih Tmp.Pembayaran';
		foreach ($select_data as $row) {
			$options[$row->KODE] = $row->NM_TP;
		}
		$js = 'id="grp_tp" name="grp_tp" class="input form-control select2" ';
		$data['select_grp_tp_bayar'] = form_dropdown('grp_tp', $options, $this->input->post('grp_tp'), $js);
		//-----------------------------------------------------------------------

		$this->fvalidation();
		if ($this->form_validation->run() == TRUE) {

			$userid = $this->input->post('userid');

			if ($this->pos_user_model->get_exists_user_pbb($userid)) {
				// update ke user pbb
				$grp_tp = $this->input->post('grp_tp');
				$data = array();
				if (DEF_POS_TYPE == 1) {

					$kd_kanwil = substr($grp_tp, 0, 2);
					$kd_kantor = substr($grp_tp, 2, 2);
					$kd_tp     = substr($grp_tp, 4, 2);

					$data['KD_KANWIL'] = $kd_kanwil;
					$data['KD_KANTOR'] = $kd_kantor;
					$data['KD_TP']     = $kd_tp;
					$data['UPDATED_BY']   = lda_user_login();
					$data['UPDATED_DATE'] = current_time();
				} else {
					$kd_bank_tunggal  = substr($grp_tp, 0, 2);
					$kd_bank_persepsi = substr($grp_tp, 2, 2);
					$kd_kanwil = substr($grp_tp, 4, 2);
					$kd_kantor = substr($grp_tp, 6, 2);
					$kd_tp     = substr($grp_tp, 8, 2);

					$data['KD_BANK_TUNGGAL']  = $kd_bank_tunggal;
					$data['KD_BANK_PERSEPSI'] = $kd_bank_persepsi;
					$data['KD_KANWIL']        = $kd_kanwil;
					$data['KD_KANTOR']        = $kd_kantor;
					$data['KD_TP']            = $kd_tp;
					$data['UPDATED_BY']       = lda_user_login();
					$data['UPDATED_DATE']     = current_time();
				}
				$this->pos_user_model->update($userid, $data);
			} else {
				// masukin ke user pbb
				$grp_tp = $this->input->post('grp_tp');
				$user_id = $this->input->post('id');

				$data = array();
				$data['USERID'] = $userid;

				if (DEF_POS_TYPE == 1) {

					$kd_kanwil = substr($grp_tp, 0, 2);
					$kd_kantor = substr($grp_tp, 2, 2);
					$kd_tp     = substr($grp_tp, 4, 2);

					$data['KD_KANWIL'] = $kd_kanwil;
					$data['KD_KANTOR'] = $kd_kantor;
					$data['KD_TP']     = $kd_tp;
					$data['DISABLED']  = 0;
					$data['UPDATED_BY']   = lda_user_login();
					$data['UPDATED_DATE'] = current_time();
				} else {
					$kd_bank_tunggal  = substr($grp_tp, 0, 2);
					$kd_bank_persepsi = substr($grp_tp, 2, 2);
					$kd_kanwil = substr($grp_tp, 4, 2);
					$kd_kantor = substr($grp_tp, 6, 2);
					$kd_tp     = substr($grp_tp, 8, 2);

					$data['KD_BANK_TUNGGAL']  = $kd_bank_tunggal;
					$data['KD_BANK_PERSEPSI'] = $kd_bank_persepsi;
					$data['KD_KANWIL']        = $kd_kanwil;
					$data['KD_KANTOR']        = $kd_kantor;
					$data['KD_TP']            = $kd_tp;
					$data['DISABLED']         = 0;
					$data['UPDATED_BY']       = lda_user_login();
					$data['UPDATED_DATE']     = current_time();
				}
				$this->pos_user_model->save($data);
			}
			$this->session->set_flashdata('msg_success', 'Data telah disimpan');
			redirect(active_module_url('pos_user'));
		}
		$this->load->view('pos_user/vpos_user_form', $data);
	}

	public function delete()
	{
		$id = $this->uri->segment(4);
		if ($id) {
			if ($id == 1) return;

			$idd = $this->pos_user_model->get_q($id);
			$iddx = $idd->USERID;

			$this->db->delete('USER_PBB', array('USERID' => $iddx));
			$this->db->delete('SEC_USER_GROUPS', array('USER_ID' => $id));
			// $this->db->delete('user_groups', array('user_id' => $id));

			// if ($this->pos_user_model->delete($id))
			if ($this->pos_user_model->delete($id))
				$this->session->set_flashdata('msg_success', 'Data telah dihapus');
			else
				$this->session->set_flashdata('msg_error', 'Gagal');

			redirect(active_module_url('pos_user'));
		} else {
			show_404();
		}
	}

	public function delete_old()
	{

		$id = $this->uri->segment(4);
		if ($id && $row = $this->pos_user_model->get($id)) {
			if ($id == 1) return;

			$this->db->delete('USER_PBB', array('USER_ID' => $row->USERID));
			$this->db->delete('SEC_USER_GROUPS', array('USER_ID' => $id));

			if ($this->pos_user_model->delete($id))
				$this->session->set_flashdata('msg_success', 'Data telah dihapus');
			else
				$this->session->set_flashdata('msg_error', 'Gagal');

			redirect(active_module_url('pos_user'));
		} else {
			show_404();
		}
	}

	function cetak_draft()
	{

		$qs   = urldecode($_SERVER['QUERY_STRING']);
		parse_str($qs, $qs_data);
		$type = $this->uri->segment(4);

		$params = array();

		$id = $this->input->get('id');
		$nip = '0';
		$jns = '0';
		$sub_jns = '0';
		$flg_ctk = '0';
		$rpt = 'ref_cursor';
		$rpt = 'ref_cursor_plsql';  // tes_nodb
		$type = 'pdf';

		$params = array(
			"P_TAHUN" => "2019", //  base_url('assets/img/app/garuda.png'),
		);

		$jasper = $this->load->library('Jasper');
		echo $jasper->cetak_ora($rpt, $params, $type, false);
		//   echo $jasper->cetak_byjasper($rpt, $params, $type, false);

	}
}
