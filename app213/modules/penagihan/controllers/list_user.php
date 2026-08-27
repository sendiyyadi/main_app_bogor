<?php
defined('BASEPATH') or exit('No direct script access allowed');

class list_user extends CI_Controller
{

  /**
   * Index Page for this controller.
   *
   * Maps to the following URL
   *        http://example.com/index.php/welcome
   *    - or -
   *        http://example.com/index.php/welcome/index
   *    - or -
   * Since this controller is set as the default controller in
   * config/routes.php, it's displayed at http://example.com/
   *
   * So any other public methods not prefixed with an underscore will
   * map to /index.php/welcome/<method_name>
   * @see https://codeigniter.com/user_guide/general/urls.html
   */

  private $controller = 'list_user';
  public function __construct()
  {
    parent::__construct();
    if (!is_login()) {
      echo "<script>window.location.replace('" . base_url() . "');</script>";
      exit;
    }

    $module = 'list_user';
    $this->load->library('module_auth', array(
      'module' => $module
    ));

    $this->load->model(array(
      'apps_model'
    ));

    $this->load->helper(active_module());
    $this->load->model('list_user_model', 'MMain');
  }


  public function index()
  {

    //------------------------------------------------------------------
    $select_data  = $this->MMain->get_select_kecamatan();
    $options      = array();
    $kec_id = '';
    if ($select_data) {
      foreach ($select_data as $row) {
        if ($kec_id == '') $kec_id = $row->KD_KECAMATAN;
        $options[$row->KD_KECAMATAN] = $row->NM_KECAMATAN;
      }
    }
    $js                       = 'id="KD_KEC" class="form-control" onChange="get_kelurahan(this.value);" required ';
    $data['select_kecamatan'] = form_dropdown('KD_KEC', $options, '', $js);
    //------------------------------------------------------------------
    $select_data = $this->MMain->get_select_kelurahan($kec_id);
    $options     = array();
    if ($select_data) {
      foreach ($select_data as $row) {
        $options[$row->KD_KELURAHAN] = $row->NM_KELURAHAN;
      }
    }
    $js                       = 'id="KD_KEL" class="form-control" required ';
    $data['select_kelurahan'] = form_dropdown('KD_KEL', $options, '', $js);
    //------------------------------------------------------------------

    //------------------------------------------------------------------
    $select_data  = $this->MMain->get_select_kecamatan();
    $options      = array();
    $kec_id = '';
    if ($select_data) {
      foreach ($select_data as $row) {
        if ($kec_id == '') $kec_id = $row->KD_KECAMATAN;
        $options[$row->KD_KECAMATAN] = $row->NM_KECAMATAN;
      }
    }
    $js                       = 'id="KD_KEC_E" class="form-control" onChange="get_kelurahan_e(this.value);" required ';
    $data['select_kecamatan_e'] = form_dropdown('KD_KEC_E', $options, '', $js);
    //------------------------------------------------------------------
    $select_data = $this->MMain->get_select_kelurahan($kec_id);
    $options     = array();
    if ($select_data) {
      foreach ($select_data as $row) {
        $options[$row->KD_KELURAHAN] = $row->NM_KELURAHAN;
      }
    }
    $js                       = 'id="KD_KEL_E" class="form-control" required ';
    $data['select_kelurahan_e'] = form_dropdown('KD_KEL_E', $options, '', $js);
    //------------------------------------------------------------------
    $select_data  = $this->MMain->get_select_kecamatan();
    $options      = array();
    $kec_id = '';
    if ($select_data) {
      $options['999999'] = 'SEMUA KECAMATAN';
      foreach ($select_data as $row) {
        if ($kec_id == '') $kec_id = $row->KD_KECAMATAN;
        $options[$row->KD_KECAMATAN] = $row->NM_KECAMATAN;
      }
    }
    $js                       = 'id="C_KD_KEC" class="input select2 form-control" style="display:inline; width:200px; margin-left:50px;" required ';
    $data['c_select_kecamatan'] = form_dropdown('C_KD_KEC', $options, '', $js);
    //------------------------------------------------------------------

    // $data['current'] = 'user';
    // $this->load->view('v_dashboard', $data);

    $data['page_menu']  = 'list_user';
    $data['current']    = '';
    $data['controller'] = $this->controller;
    $data['apps']       = $this->apps_model->get_active_only();

    $this->load->view('vlist_user', $data);
  }

  function get_userdsjson()
  {
    // header('Content-Type: application/json');
    // echo $this->MMain->getUserds();

    $loginname   = $this->input->get('loginname');
    $kec         = $this->input->get('kec');
    // $kel         = $this->input->get('kel');

    $this->load->library('Datatables');
    // $this->datatables->select("LOGINNAME,PASSWOD,NAMA,EMAIL,NIP,USER_GROUP,KD_KEC,KD_KEL",false);
    // $this->datatables->from('M02USERS_DS');
    //$this->datatables->select('trim(' . M02LOGINNAME . '), trim(' . M02PASSWOD . '), trim(' . M02NAMA . '), trim(' . M02EMAIL . '), trim(' . M02NIP . '), ' . M03KETERANGAN . ', ' . NM_KECAMATAN . ', ' . NM_KELURAHAN . ',' .
    //  M02USER_GROUP . ',' . M02KD_KEC . ',' . M02KD_KEL . '', false);

    //meh?
    // $this->datatables->select('trim(' . M02LOGINNAME . '), trim(' . M02PASSWOD . '), trim(' . M02NAMA . '), trim(' . M02EMAIL . '), trim(' . M02NIP . '), ' . M03KETERANGAN . ', ' . M02USER_GROUP . ', ' . M02UPT . '', false);

    // $this->datatables->join(TBL_M03USRGROUP_DS, M03USER_GROUP . '=' . M02USER_GROUP, 'left');
    // $this->datatables->join(TBL_REF_UPT, M02UPT . '=' . RKD_UPT, 'left');
    // //$this->datatables->join(TBL_REF_KECAMATAN, M02KD_KEC . '=' . KD_KECAMATAN_KEC, 'left');
    // //$this->datatables->join(TBL_REF_KELURAHAN, M02KD_KEL . '=' . KD_KELURAHAN . ' and ' . M02KD_KEC . '=' . KD_KECAMATAN_KEL, 'left');
    // $this->datatables->from(TBL_M02USERS_DS);
    // $this->datatables->where(M02USER_GROUP . ' in (1,2,3) ');

    $this->datatables->select('trim('.M02LOGINNAME.'), trim('.M02PASSWOD.'), trim('.M02NAMA.'), trim('.M02EMAIL.'), trim('.M02NIP.'), '.M03KETERANGAN.', '.NM_KECAMATAN.', '.NM_KELURAHAN.','.
                                  M02USER_GROUP.','.M02KD_KEC.','.M02KD_KEL.'', false);
        $this->datatables->join(TBL_M03USRGROUP_DS, M03USER_GROUP.'='.M02USER_GROUP, 'left');
        $this->datatables->join(TBL_REF_KECAMATAN, M02KD_KEC.'='.KD_KECAMATAN_KEC, 'left');
        $this->datatables->join(TBL_REF_KELURAHAN, M02KD_KEL.'='.KD_KELURAHAN.' and '.M02KD_KEC.'='.KD_KECAMATAN_KEL, 'left');
        $this->datatables->from(TBL_M02USERS_DS);
        
        // $this->datatables->where(M02USER_GROUP.' in (6,7,8) ');

    //$this->datatables->join('REF_INSTANSI_DEPOK D1','D1.KD_INSTANSI=PT.KD_INSTANSI','left');
    //$this->datatables->join('REF_JABATAN D2','D2.KD_JABATAN=PT.KD_JABATAN','left');

    if (!empty($loginname)) {
      $loginname = trim($loginname);
      $loginname = strtoupper($loginname);
      $this->datatables->where("trim(UPPER(" . M02LOGINNAME . ")) like ('%" . $loginname . "%')");
    }

    if ($kec <> '999999' && !empty($kec)) {
      $this->datatables->where("trim(" . M02KD_KEC . ") = '" . $kec . "' ");
    }

    // if($kel <> '999999'){
    //   $this->datatables->where("trim(".M02KD_KEL.") = '".$kel."%' ");
    // }

    //  $this->datatables->checkbox_column('8');
    echo $this->datatables->generate();
  }

  private function fvalidation($model)
  {
    $this->form_validation->set_error_delimiters('<span>', '</span>');
    if ($model == 'add') {
      $this->form_validation->set_rules('LOGIN_NAME', 'Login Name', 'required|max_length[30]');
      $this->form_validation->set_rules('PASSWOD', 'Password', 'required|max_length[20]');
      $this->form_validation->set_rules('NAMA', 'Nama', 'required|max_length[50]');
      $this->form_validation->set_rules('EMAIL', 'Email', 'max_length[10]');
      $this->form_validation->set_rules('NIP', 'NIP', 'max_length[19]');
      // $this->form_validation->set_rules('KD_KEC', 'Kecamatan', '');
      // $this->form_validation->set_rules('KD_KEL', 'Kelurahan', '');
    } else {
      $this->form_validation->set_rules('LOGIN_NAME_E', 'Login Name', 'required|max_length[30]');
      // $this->form_validation->set_rules('PASSWOD_E','Password','required|max_length[20]');
      $this->form_validation->set_rules('NAMA_E', 'Nama', 'required|max_length[50]');
      $this->form_validation->set_rules('EMAIL_E', 'Email', 'max_length[10]');
      $this->form_validation->set_rules('NIP_E', 'NIP', 'max_length[19]');
      // $this->form_validation->set_rules('KD_KEC', 'Kecamatan', '');
      // $this->form_validation->set_rules('KD_KEL', 'Kelurahan', '');

    }
  }

  private function fpost()
  {
    $data['LOGIN_NAME'] = $this->input->post('LOGIN_NAME');
    $data['PASSWOD'] = $this->input->post('PASSWOD');
    $data['NAMA'] = $this->input->post('NAMA');
    $data['EMAIL'] = $this->input->post('EMAIL');
    $data['NIP'] = $this->input->post('NIP');
    $data['USER_GROUP'] = $this->input->post('USER_GROUP');
    $data['KD_KEC'] = $this->input->post('KD_KEC');
    $data['KD_KEL'] = $this->input->post('KD_KEL');

    $data['LOGIN_NAME_E'] = $this->input->post('LOGIN_NAME_E');
    $data['PASSWOD_E'] = $this->input->post('PASSWOD_E');
    $data['NAMA_E'] = $this->input->post('NAMA_E');
    $data['EMAIL_E'] = $this->input->post('EMAIL_E');
    $data['NIP_E'] = $this->input->post('NIP_E');
    $data['USER_GROUP_E'] = $this->input->post('USER_GROUP_E');
    $data['KD_KEC_E'] = $this->input->post('KD_KEC_E');
    $data['KD_KEL_E'] = $this->input->post('KD_KEL_E');

    return $data;
  }

  public function add()
  {

    // $data['current'] = 'user';

    $this->fvalidation('add');
    if ($this->form_validation->run() == TRUE) {
      $input_post = $this->fpost();

      $post_data  = array(
        'LOGINNAME' => $input_post['LOGIN_NAME'],
        'PASSWOD' => $input_post['PASSWOD'],
        'NAMA' => $input_post['NAMA'],
        'EMAIL' => $input_post['EMAIL'],
        'NIP' => $input_post['NIP'],
        'USER_GROUP' => $input_post['USER_GROUP'],
        // 'KD_KECAMATAN' => $input_post['USER_GROUP'] == '8' ? $input_post['KD_KEC'] : NULL,
        'KD_KECAMATAN' => $input_post['KD_KEC'],
        'KD_KELURAHAN' => $input_post['KD_KEL'],
      );
      // echo $post_data;
      if ($this->MMain->save_add($post_data) == TRUE) {
        $this->session->set_flashdata('msg_success', 'Data user baru berhasil disimpan');
      } else {
        $this->session->set_flashdata('msg_info', 'Data user baru gagal disimpan');
      }
      //redirect(active_module_url('subjek_pajak'));

    } else {
      // echo '<blockquote><strong>Harap melengkapi data berikut :</strong>';
      // echo validation_errors('<small>','</small>');
      // echo '</blockquote>';
      $this->session->set_flashdata('msg_warning', 'Error...!');
    }
    redirect(base_url('penagihan/list_user'));
  }

  public function edit()
  {

    $this->fvalidation('edit');
    if ($this->form_validation->run() == TRUE) {
      $input_post = $this->fpost();

      $id = $input_post['LOGIN_NAME_E'];
      if ($input_post['PASSWOD_E'] == '') {  // simpan tanpa ganti password
        $post_data  = array(
          // 'LOGINNAME' => $input_post['LOGIN_NAME_E'],
          // 'PASSWOD' => $input_post['PASSWOD_E'],
          'NAMA' => $input_post['NAMA_E'],
          'EMAIL' => $input_post['EMAIL_E'],
          'NIP' => $input_post['NIP_E'],
          'USER_GROUP' => $input_post['USER_GROUP_E'],
          // 'KD_KECAMATAN' => $input_post['USER_GROUP_E'] == '8' ? $input_post['KD_KEC_E'] : NULL,
          'KD_KECAMATAN' => $input_post['KD_KEC_E'],
          // 'KD_KELURAHAN' => $input_post['USER_GROUP_E'] == '8' ? $input_post['KD_KEL_E'] : NULL,
          'KD_KELURAHAN' => $input_post['KD_KEL_E'],
        );
      } else {                        // simpan dengan password
        $post_data  = array(
          // 'LOGINNAME' => $input_post['LOGIN_NAME_E'],
          'PASSWOD' => $input_post['PASSWOD_E'],
          'NAMA' => $input_post['NAMA_E'],
          'EMAIL' => $input_post['EMAIL_E'],
          'NIP' => $input_post['NIP_E'],
          'USER_GROUP' => $input_post['USER_GROUP_E'],
          // 'KD_KECAMATAN' => $input_post['USER_GROUP_E'] == '8' ? $input_post['KD_KEC_E'] : NULL,
          'KD_KECAMATAN' => $input_post['KD_KEC_E'],
          // 'KD_KELURAHAN' => $input_post['USER_GROUP_E'] == '8' ? $input_post['KD_KEL_E'] : NULL,
          'KD_KELURAHAN' =>$input_post['KD_KEL_E'],
        );
      }

      // echo $post_data;
      if ($this->MMain->save_edit($post_data, $id) == TRUE) {
        $this->session->set_flashdata('msg_success', 'Data user berhasil diedit');
      } else {
        $this->session->set_flashdata('msg_info', 'Data user gagal diedit');
      }
      //redirect(active_module_url('subjek_pajak'));

    } else {
      // echo '<blockquote><strong>Harap melengkapi data berikut :</strong>';
      // echo validation_errors('<small>','</small>');
      // echo '</blockquote>';
      $this->session->set_flashdata('msg_warning', 'Error...!');
    }
    redirect(base_url('penagihan/list_user'));
  }

  public function hapus()
  {

    $id = $this->uri->segment(4);
    if ($id && $this->MMain->get($id)) {
      $this->MMain->save_hapus($id);
      $this->session->set_flashdata('msg_success', 'Data telah dihapus');
      redirect(base_url('penagihan/list_user'));
    } else {
      show_404();
    }

    // $id = $this->input->post('LOGIN_NAME_H');
    //
    //   // echo $post_data;
    // if($this->MMain->save_hapus($id) == TRUE) {
    //       echo $this->session->set_flashdata('msg_success', 'Data user berhasil dihapus');
    // } else {
    //       echo $this->session->set_flashdata('msg_info', 'Data user gagal dihapus');
    // }
    //redirect(active_module_url('subjek_pajak'));

    // redirect(base_url('Main'));

  }

  function tambahuserds()
  {
    $result = array();

    $loginame = $this->input->post(LOGINNAME);
    $pass = $this->input->post(PASSWOD);
    $nama = $this->input->post(NAMA);
    $mail = $this->input->post(EMAIL);
    $nip = $this->input->post(NIP);
    $usrgroup = $this->input->post(USER_GROUP);
    $kec = $this->input->post(KD_KEC);
    $kel = $this->input->post(KD_KEL);

    if (
      $loginame != '' && $pass != '' && $nama != '' && $mail != '' && $nip != ''
      && $usrgroup != '' && $kec != '' & $kel != ''
    ) {

      $res = $this->MMain->tambahuserds($loginame, $pass, $nama, $mail, $nip, $usrgroup, $kec, $kel);

      if ($res > 0) {
        $result[SUCCESS] = true;
        $result[CODE] = RESP_OK;
        $result[MESSAGE] = RESP_200;
        $result[REQUEST] = $_REQUEST;
      } else {
        $result[SUCCESS] = false;
        $result[CODE] =  RESP_INTERNALSERVERERROR;
        $result[MESSAGE] = RESP_500;
        $result[REQUEST] = $_REQUEST;
      }
    } else {
      $result[SUCCESS] = false;
      $result[CODE] =  RESP_BADREQ;
      $result[MESSAGE] = RESP_400;
      $result[REQUEST] = $_REQUEST;
    }

    json_output($result);
  }

  function ambilcamat()
  {
    $result = array();

    $rss = $this->MMain->ambilcamat();

    if ($rss) {
      $result[SUCCESS] = true;
      $result[CODE] = RESP_OK;
      $result[MESSAGE] = RESP_200;
      $result[DATA] = $rss;
      $result[REQUEST] = $_REQUEST;
    } else {
      $result[SUCCESS] = false;
      $result[CODE] =  RESP_INTERNALSERVERERROR;
      $result[MESSAGE] = RESP_500;
      $result[REQUEST] = $_REQUEST;
    }

    json_output($result);
  }

  function ambillurah()
  {
    $camatid = $this->input->post(ID_KECPOST);

    $rss = $this->MMain->ambillurah($camatid);

    if ($rss) {
      $result[SUCCESS] = true;
      $result[CODE] = RESP_OK;
      $result[MESSAGE] = RESP_200;
      $result[DATA] = $rss;
      $result[REQUEST] = $_REQUEST;
    } else {
      $result[SUCCESS] = false;
      $result[CODE] =  RESP_INTERNALSERVERERROR;
      $result[MESSAGE] = RESP_500;
      $result[REQUEST] = $_REQUEST;
    }

    json_output($result);
  }

  function get_kelurahan()
  {
    $kec_id    = $this->uri->segment(4);
    $kelurahan = $this->MMain->get_select_kelurahan($kec_id);
    echo json_encode($kelurahan);
  }
}
