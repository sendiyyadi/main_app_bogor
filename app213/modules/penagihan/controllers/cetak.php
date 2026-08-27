<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cetak extends CI_Controller
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

    private $controller = 'cetak';
    public function __construct()
    {
        parent::__construct();
        if (!is_login()) {
            echo "<script>window.location.replace('" . base_url() . "');</script>";
            exit;
        }

        $module = 'cetak';
        $this->load->library('module_auth', array(
            'module' => $module
        ));

        $this->load->model(array(
            'apps_model'
        ));

        $this->load->helper(active_module());
        $this->load->library('datatables');
        $this->load->model('cetak_model', 'MLaporan');
    }

    public function index(){
    
      $mukalele   = $this->input->get('MUKALELE');
      // echo $mukalele;
      // die();
        if (empty($mukalele)) {
            if (!$this->session->userdata('login')) {
                echo "<script>window.location.replace('" . base_url() . "');</script>";
                exit;
            }
        }
      $c_nop   = $this->input->get('C_NOP');
      $c_thn   = $this->input->get('C_THN');
      $kel   = $this->input->get('KD_KEL');
      $kec   = $this->input->get('KD_KEC');
      $sts   = $this->input->get('STS');
      $login   = $this->input->get('LOGINNAME');
      // $thn = date('Y');
      $thn = '';

      $data = array( 'title' => 'View Laporan',
					   // 'user' => $this->MLaporan->get_laporan($thn, $kec, $kel, $c_nop, $login),
             'c_nop' => $c_nop,
             'kel' => $kel,
             'kec' => $kec,
             'login' => $login,
             'thn' => $c_thn,
             'sts' => $sts,
				);

      // $this->load->view('v_laporan_nop',$data);
		  $this->load->view('vcetak',$data);

    }

    function grid_cetak(){

      $nop   = $this->input->get('C_NOP');
      $thn   = $this->input->get('THN');
      $kel   = $this->input->get('KD_KEL');
      $kec   = $this->input->get('KD_KEC');
      $login = $this->input->get('LOGINNAME');
      $sts   = $this->input->get('STS');
      // $tahun_berjalan = date('Y');
      // $tahun_berjalan = '';

      $i=0;
      $responce = new stdClass();
      if($query = $this->MLaporan->get_by_thn($nop, $kel, $kec, $login, $thn, $sts)) {
  			foreach($query as $row) {
  				$responce->aaData[$i][]=$row->URUT;
  				$responce->aaData[$i][]=$row->NOP;
  				$responce->aaData[$i][]=$row->TGL_PENYERAHAN;
          $responce->aaData[$i][]=$row->NM_KECAMATAN;
          $responce->aaData[$i][]=$row->NM_KELURAHAN;
          $responce->aaData[$i][]=$row->THN_PAJAK_SPPT;
  				$responce->aaData[$i][]=$row->LOGINNAME;
  				$i++;
  			}
  		} else {
  			$responce->sEcho=1;
  			$responce->iTotalRecords="0";
  			$responce->iTotalDisplayRecords="0";
  			$responce->aaData=array();
  		}
  		echo json_encode($responce);

    }

    function grid_cetak_old(){

      $nop   = $this->input->get('C_NOP');
      $kel   = $this->input->get('KD_KEL');
      $kec   = $this->input->get('KD_KEC');
      $login   = $this->input->get('LOGINNAME');
      // $tahun_berjalan = date('Y');
      $tahun_berjalan = '';

      $this->load->library('Datatables');
      // $this->datatables->select("LOGINNAME,PASSWOD,NAMA,EMAIL,NIP,USER_GROUP,KD_KEC,KD_KEL",false);
      // $this->datatables->from('M02USERS_DS');
      $this->datatables->select("rownum as URUT, NOP, TGL_PENYERAHAN, NM_KECAMATAN, NM_KELURAHAN, LOGINNAME", false);
      $this->datatables->from("DT_TTSPPT_CETAK_BY_THN");

      $this->datatables->where("trim(KD_KECAMATAN) like '%".$kec."%' ");
      $this->datatables->where("trim(KD_KELURAHAN) like '%".$kel."%' ");
      $this->datatables->where("upper(LOGINNAME) like upper('%".$login."%') ");
      if(!empty($thn)){
        $this->datatables->where("THN_PAJAK_SPPT = '".$tahun_berjalan."' ");
      }

    //  $this->datatables->checkbox_column('8');
      echo $this->datatables->generate();

    }

    function to_excel(){
      $c_nop   = $this->input->get('nop');
      $kel   = $this->input->get('kel');
      $kec   = $this->input->get('kec');
      $login   = $this->input->get('login');
      $thn = $this->input->get('thn');
      $sts = $this->input->get('sts');
      // $thn = '';

      $data = array( 'title' => 'View Laporan',
					   'user' => $this->MLaporan->get_laporan($thn, $kec, $kel, $c_nop, $login, $sts)
				);

      // $this->load->view('v_laporan_nop',$data);
		  $this->load->view('vcetak_excel',$data);

    }

}
