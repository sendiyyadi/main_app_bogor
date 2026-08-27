<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class pemda extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
        if (!is_login()) {
            echo "<script>window.location.replace('" . base_url() . "');</script>";
            exit;
        }
        
        $module = 'referensi';
        $this->load->library('module_auth', array(
            'module' => $module
        ));
        
        $this->load->model(array(
            'apps_model', 'pemda_model'
        ));
		
		$this->load->helper(active_module());
    }
    
    public function index() 
    {
        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect('pasar/pasar');
        }
        
		$this->edit();
    }
    
    private function fvalidation()
    {
        $this->form_validation->set_error_delimiters('<span>', '</span>');
		$this->form_validation->set_rules('type','type','required|trim');
		$this->form_validation->set_rules('kepalanm','kepalanm','required|trim');
		$this->form_validation->set_rules('alamat','alamat','required|trim');
		$this->form_validation->set_rules('daerah','daerah','required|trim');
		$this->form_validation->set_rules('pemdanm','pemdanm','required|trim');
		$this->form_validation->set_rules('ibukota','ibukota','required|trim');
		$this->form_validation->set_rules('jabatan','jabatan','required|trim');
		$this->form_validation->set_rules('ppkd_id','ppkd_id','required|numeric');
    }
    
    private function fpost()
    {
		$data['id'] = $this->input->post('id');
		$data['type'] = $this->input->post('type');
		$data['pemdanm'] = $this->input->post('pemdanm');
		$data['pemdanmskt'] = $this->input->post('pemdanmskt');
		$data['kepalanm'] = $this->input->post('kepalanm');
		$data['jabatan'] = $this->input->post('jabatan');
		$data['alamat'] = $this->input->post('alamat');
		$data['ibukota'] = $this->input->post('ibukota');
		$data['telp'] = $this->input->post('telp');
		$data['ppkd_id'] = $this->input->post('ppkd_id');
		$data['tmt'] = $this->input->post('tmt');
        
		$data['alamat_lengkap'] = $this->input->post('alamat_lengkap');
		$data['daerah'] = $this->input->post('daerah');
		$data['fax'] = $this->input->post('fax');
		$data['website'] = $this->input->post('website');
		$data['email'] = $this->input->post('email');
		
		$data['reklame_id'] = post_decimal($this->input->post('reklame_id'));
		$data['airtanah_id'] = post_decimal($this->input->post('airtanah_id'));
		$data['self_dok_id'] = post_decimal($this->input->post('self_dok_id'));
		$data['office_dok_id'] = post_decimal($this->input->post('office_dok_id'));
		
		$data['tgl_jatuhtempo_self'] = post_decimal($this->input->post('tgl_jatuhtempo_self'));
		$data['spt_denda'] = post_decimal($this->input->post('spt_denda'));
		$data['tgl_spt'] = post_decimal($this->input->post('tgl_spt'));
		$data['pad_bunga'] = post_decimal($this->input->post('pad_bunga'));
        
		$data['thn_ang'] = post_decimal($this->input->post('thn_ang'));
		$data['bln_ang'] = post_decimal($this->input->post('bln_ang'));
		
		$data['mineral_id'] = $this->input->post('mineral_id');
		$data['ppj_id']     = $this->input->post('ppj_id');

		/* 
		$data['enabled'] = $this->input->post('enabled');
		$data['hda'] = post_decimal($this->input->post('hda'));
		$data['mineral_id'] = post_decimal($this->input->post('mineral_id'));
		$data['pendapatan_id'] = post_decimal($this->input->post('pendapatan_id'));
		$data['sptyearly'] = post_decimal($this->input->post('sptyearly'));
		$data['sspdyearly'] = post_decimal($this->input->post('sspdyearly'));
		$data['skpdyearly'] = post_decimal($this->input->post('skpdyearly'));
		$data['kasiryearly'] = post_decimal($this->input->post('kasiryearly'));
		$data['create_date'] = $this->input->post('create_date');
		$data['create_uid'] = $this->input->post('create_uid');
		$data['write_date'] = $this->input->post('write_date');
		$data['write_uid'] = $this->input->post('write_uid');
		 */
        return $data;
    }
    
    public function edit()
    {
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
            redirect(active_module_url('pemda'));
        }
        
        $data['current'] = 'referensi';
        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = active_module_url("pemda/update");
        
        if ($get = $this->pemda_model->get_one()) {		
			$data['dt']['id'] = empty($get->id) ? NULL : $get->id;
			$data['dt']['ppkd_id'] = empty($get->ppkd_id) ? NULL : $get->ppkd_id;
			$data['dt']['pemdanm'] = empty($get->pemdanm) ? NULL : $get->pemdanm;
			$data['dt']['pemdanmskt'] = empty($get->pemdanmskt) ? NULL : $get->pemdanmskt;
			$data['dt']['type'] = empty($get->type) ? NULL : $get->type;
			$data['dt']['kepalanm'] = empty($get->kepalanm) ? NULL : $get->kepalanm;
			$data['dt']['jabatan'] = empty($get->jabatan) ? NULL : $get->jabatan;
			$data['dt']['alamat'] = empty($get->alamat) ? NULL : $get->alamat;
			$data['dt']['ibukota'] = empty($get->ibukota) ? NULL : $get->ibukota;
			$data['dt']['telp'] = empty($get->telp) ? NULL : $get->telp;
			$data['dt']['tmt'] = empty($get->tmt) ? NULL : date('d-m-Y', strtotime($get->tmt));
			
			$data['dt']['alamat_lengkap'] = empty($get->alamat_lengkap) ? NULL : $get->alamat_lengkap;
			$data['dt']['daerah'] = empty($get->daerah) ? NULL : $get->daerah;
			$data['dt']['fax'] = empty($get->fax) ? NULL : $get->fax;
			$data['dt']['website'] = empty($get->website) ? NULL : $get->website;
			$data['dt']['email'] = empty($get->email) ? NULL : $get->email;
            
            $data['dt']['ppj_id'] = $get->ppj_id;    
			$data['dt']['mineral_id'] = $get->mineral_id;    
			$data['dt']['reklame_id'] = $get->reklame_id;
			$data['dt']['airtanah_id'] = $get->airtanah_id;
			$data['dt']['self_dok_id'] = $get->self_dok_id;
			$data['dt']['office_dok_id'] = $get->office_dok_id;
			
			$data['dt']['tgl_spt'] = $get->tgl_spt;
			$data['dt']['tgl_jatuhtempo_self'] = $get->tgl_jatuhtempo_self;
			$data['dt']['spt_denda'] = $get->spt_denda;
			$data['dt']['pad_bunga'] = $get->pad_bunga;
            
			$data['dt']['thn_ang'] = pad_tahun_anggaran();
			$data['dt']['bln_ang'] = pad_bulan_anggaran();

			/* 
			$data['dt']['sptyearly'] = empty($get->sptyearly) ? NULL : $get->sptyearly;
			$data['dt']['sspdyearly'] = empty($get->sspdyearly) ? NULL : $get->sspdyearly;
			$data['dt']['skpdyearly'] = empty($get->skpdyearly) ? NULL : $get->skpdyearly;
			$data['dt']['kasiryearly'] = empty($get->kasiryearly) ? NULL : $get->kasiryearly;
			$data['dt']['pendapatan_id'] = empty($get->pendapatan_id) ? NULL : $get->pendapatan_id;
			$data['dt']['hda'] = empty($get->hda) ? NULL : $get->hda;
			$data['dt']['enabled'] = empty($get->enabled) ? NULL : $get->enabled;
			$data['dt']['create_date'] = empty($get->create_date) ? NULL : date('d-m-Y', strtotime($get->create_date));
			$data['dt']['create_uid'] = empty($get->create_uid) ? NULL : $get->create_uid;
			$data['dt']['write_date'] = empty($get->write_date) ? NULL : date('d-m-Y', strtotime($get->write_date));
			$data['dt']['write_uid'] = empty($get->write_uid) ? NULL : $get->write_uid;
			 */
			
			$this->load->view('vpemda_form', $data);
        } else {
            show_404();
        }
    }
    
    public function update()
    {
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
            redirect(active_module_url('pemda'));
        }
        
        $post_data = $this->fpost();
        $p_id       = $post_data['id'];
        
        $data['current'] = 'referensi';
        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = active_module_url("pemda/update/{$p_id}");
        
        $this->fvalidation();
        if ($this->form_validation->run() == TRUE) {
            $input_post  = $post_data;
            $update_data = array(
				'ppkd_id' => empty($input_post['ppkd_id']) ? NULL : $input_post['ppkd_id'],
				'pemdanm' => empty($input_post['pemdanm']) ? NULL : $input_post['pemdanm'],
				'pemdanmskt' => empty($input_post['pemdanmskt']) ? NULL : $input_post['pemdanmskt'],
				'type' => empty($input_post['type']) ? NULL : $input_post['type'],
				'kepalanm' => empty($input_post['kepalanm']) ? NULL : $input_post['kepalanm'],
				'jabatan' => empty($input_post['jabatan']) ? NULL : $input_post['jabatan'],
				'alamat' => empty($input_post['alamat']) ? NULL : $input_post['alamat'],
				'ibukota' => empty($input_post['ibukota']) ? NULL : $input_post['ibukota'],
				'telp' => empty($input_post['telp']) ? NULL : $input_post['telp'],
				'tmt' => empty($input_post['tmt']) ? NULL : date('Y-m-d', strtotime($input_post['tmt'])),
                
				'alamat_lengkap' => empty($input_post['alamat_lengkap']) ? NULL : $input_post['alamat_lengkap'],
				'daerah' => empty($input_post['daerah']) ? NULL : $input_post['daerah'],
				'fax' => empty($input_post['fax']) ? NULL : $input_post['fax'],
				'email' => empty($input_post['email']) ? NULL : $input_post['email'],
				'website' => empty($input_post['website']) ? NULL : $input_post['website'],

				'reklame_id' => empty($input_post['reklame_id']) ? NULL : $input_post['reklame_id'],
				'airtanah_id' => empty($input_post['airtanah_id']) ? NULL : $input_post['airtanah_id'],
				'self_dok_id' => empty($input_post['self_dok_id']) ? NULL : $input_post['self_dok_id'],
				'office_dok_id' => empty($input_post['office_dok_id']) ? NULL : $input_post['office_dok_id'],

				'tgl_spt' => empty($input_post['tgl_spt']) ? NULL : $input_post['tgl_spt'],
				'tgl_jatuhtempo_self' => empty($input_post['tgl_jatuhtempo_self']) ? NULL : $input_post['tgl_jatuhtempo_self'],
				'spt_denda' => empty($input_post['spt_denda']) ? NULL : $input_post['spt_denda'],
				'pad_bunga' => empty($input_post['pad_bunga']) ? NULL : $input_post['pad_bunga'],
			
				'mineral_id' => empty($input_post['mineral_id']) ? NULL : $input_post['mineral_id'],
				'ppj_id' => empty($input_post['ppj_id']) ? NULL : $input_post['ppj_id'],

				/* 
				'mineral_id' => empty($input_post['mineral_id']) ? NULL : $input_post['mineral_id'],
				'sptyearly' => empty($input_post['sptyearly']) ? NULL : $input_post['sptyearly'],
				'sspdyearly' => empty($input_post['sspdyearly']) ? NULL : $input_post['sspdyearly'],
				'skpdyearly' => empty($input_post['skpdyearly']) ? NULL : $input_post['skpdyearly'],
				'kasiryearly' => empty($input_post['kasiryearly']) ? NULL : $input_post['kasiryearly'],
				'pendapatan_id' => empty($input_post['pendapatan_id']) ? NULL : $input_post['pendapatan_id'],
				'hda' => empty($input_post['hda']) ? NULL : $input_post['hda'],
				
				'enabled' => empty($input_post['enabled']) ? NULL : $input_post['enabled'],
				'create_date' => empty($input_post['create_date']) ? NULL : date('Y-m-d', strtotime($input_post['create_date'])),
				'create_uid' => empty($input_post['create_uid']) ? NULL : $input_post['create_uid'],
				'write_date' => empty($input_post['write_date']) ? NULL : date('Y-m-d', strtotime($input_post['write_date'])),
				'write_uid' => empty($input_post['write_uid']) ? NULL : $input_post['write_uid'],
				*/
            );
            
            $this->pemda_model->update($p_id, $update_data);
            $this->update_session();
			
            $this->session->set_flashdata('msg_success', 'Data telah disimpan');
            redirect(active_module_url('pemda'));
        }
        
        $data['dt'] = $post_data;		
		$this->load->view('vpemda_form', $data);
    }
	
	
	function update_session() {
		$row = (object) $this->fpost();
        $sess_data = array(
            'pad_pemda_nama' => $row->pemdanm,
            'pad_pemda_type' => $row->type,
            'pad_pemda_kepala' => $row->kepalanm,
            'pad_pemda_jabatan' => $row->jabatan,
            'pad_pemda_ibukota' => $row->ibukota,
            'pad_pemda_unitid' => $row->ppkd_id,

            'pad_pemda_daerah' => $row->daerah,
            'pad_pemda_alamat' => $row->alamat,
            'pad_pemda_alamat_lengkap' => $row->alamat_lengkap,
            'pad_pemda_telp' => $row->telp,
            'pad_pemda_fax' => $row->fax,
            'pad_pemda_website' => $row->website,
            'pad_pemda_email' => $row->email,
            'pad_pemda_singkatan' => $row->pemdanmskt,

            'pad_reklame_id' => $row->reklame_id,
            'pad_air_tanah_id' => $row->airtanah_id,
            'pad_dok_self_id' => $row->self_dok_id,
            'pad_dok_office_id' => $row->office_dok_id,

            'pad_spt_date' => $row->tgl_spt,
            'pad_spt_due_date' => $row->tgl_jatuhtempo_self,

            'pad_spt_denda' => $row->spt_denda,
            'pad_bunga' => $row->pad_bunga,

            'pad_tahun_anggaran' => $row->thn_ang,
            'pad_bulan_anggaran' => $row->bln_ang,
        );
        		
        $this->unset_session();
        $this->session->set_userdata($sess_data);
	}
    
	function unset_session() {		
        $sess_data = array(
            'pad_pemda_nama' => '',
            'pad_pemda_type' => '',
            'pad_pemda_kepala' => '',
            'pad_pemda_jabatan' => '',
            'pad_pemda_ibukota' => '',
            'pad_pemda_unitid' => '',

            'pad_pemda_daerah' => '',
            'pad_pemda_alamat' => '',
            'pad_pemda_alamat_lengkap' => '',
            'pad_pemda_telp' => '',
            'pad_pemda_fax' => '',
            'pad_pemda_website' => '',
            'pad_pemda_email' => '',
            'pad_pemda_singkatan' => '',

            'pad_reklame_id' => '',
            'pad_air_tanah_id' => '',
            'pad_dok_self_id' => '',
            'pad_dok_office_id' => '',

            'pad_spt_date' => '',
            'pad_spt_due_date' => '',

            'pad_spt_denda' => '',
            'pad_bunga' => '',

            'pad_tahun_anggaran' => '',
            'pad_bulan_anggaran' => '',
        );
        
        $this->session->unset_userdata($sess_data);
	}
}