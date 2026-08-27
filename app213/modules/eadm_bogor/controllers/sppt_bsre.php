<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require FCPATH . FOLDER_GUZZLE;

use GuzzleHttp\Psr7;
use \GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

class sppt_bsre extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_login()) {
            echo "<script>window.location.replace('" . base_url() . "');</script>";
            exit;
        }

        $module = 'sppt_bsre';
        $this->load->library('module_auth', array(
            'module' => $module
        ));

        $this->load->model(array(
            'apps_model', 'sppt_bsre_model'
        ));

        $this->load->helper(active_module());
    }


    public function tes_bsre()
    {
        echo '111';
        // $file_name = 'SPPT_2022_789320302000500503700';
        $file_name = 'tes_bsre_2';
        // $esign = $this->esign_doc($file_name, '3271052307750012', 'BappendaJuara1!!', '530', '60', '470', '125', 1, 'sppt_rpt_esign', '#');

        // esign_doc($namafile, $nik_esign, $pass_esign, $xAxis, $yAxis, $width, $height, $page, $rpt, $tag = null)

        //3271052307750012      BappendaJuara1!!

        $namafile = $file_name;
        // $nik_esign = '0803202100007062';
        // $pass_esign = '!Bsre1221*';
        $nik_esign = '3271052307750012';
        $pass_esign = 'BappendaJuara1!!';
        $xAxis = '530';
        $yAxis = '60';
        $width = '470';
        $height = '125';
        $page = 1;
        $rpt = 'sppt_rpt_esign';
        $tag = '#';

        // $this->cek_koneksi($nik_esign);
        $base_uri = IP_KOMINFO . 'api/';
        $_client = new Client([
            'base_uri' => $base_uri,
            'http_errors' => false
        ]);



        $api_sign = 'sign/pdf';
        $auth = [AUTH_USER_ESIGN, AUTH_PASS_ESIGN];

        $aa = "SELECT FN_KEYLOCK('{$auth[0]}','{$auth[1]}') AS PASS_AUTH FROM DUAL";
        $ab = $this->db->query($aa)->row();

        $auth_b = array('auth' => [$auth[0], $ab->PASS_AUTH]);
        
        $req_mode = array('inq' => 'tes', 'mode' => ['create_sppt', $rpt]);
        $tag_koordinat = ['name' => 'tag_koordinat', 'contents' => $tag];

        $req_body = array('api' => $base_uri, 'nik' => $nik_esign, 'passphrase' => $pass_esign, 'tampilan' => 'true', 'page' => $page, 'image' => 'true', 'xAxis' => $xAxis, 'yAxis' => $yAxis, 'width' => $width, 'height' => $height);
       
        $response = $_client->request('POST', $api_sign, [
            'auth' => $auth,
            'multipart' => [
                ['name' => 'nik', 'contents' => $nik_esign],
                ['name' => 'passphrase', 'contents' => $pass_esign],
                ['name' => 'tampilan', 'contents' => 'visible'],
                ['name' => 'page', 'contents' => $page],
                ['name' => 'image', 'contents' => 'true'],
                ['name' => 'xAxis', 'contents' => '450'],
                ['name' => 'yAxis', 'contents' => '60'],
                ['name' => 'width', 'contents' => '520'],
                ['name' => 'height', 'contents' => '250'],
                ['name' => 'file', 'contents' =>  Psr7\Utils::tryFopen(FOLDER_DRAFT_ESIGN . $namafile . '.pdf', 'r')],
                ['name' => 'imageTTD', 'contents' => Psr7\Utils::tryFopen(FOLDER_QR . $namafile . '.png', 'r')]
            ]
        ]);
        // var_dump($response);die();

        $sts_code = $response->getStatusCode();
        $ret = array();
        $insert = array('STATUS_CODE' => $response->getStatusCode(), 'USERID' => sipkd_user_login(), 'CREATED_DATE' => date('Y-m-d H:i:s'));
        if (empty($sts_code)) {
            $get_body = 'Request API Error';
            // $resp = json_decode($get_body);
            $ret['sts_code'] = 500;
            $ret['error'] = 'Request API Error';
            $insert['RESP_BODY'] = "{$get_body}";
        } else {
            if ($sts_code == 200) {
                if ($response->hasHeader('id_dokumen')) {
                    $id_dokumen = $response->getHeader('id_dokumen')[0];
                    file_put_contents(FOLDER_ESIGN . $namafile . SIGNED_MARK . '.pdf', $response->getBody(), FILE_APPEND);
                }
                $ret['sts_code'] = $sts_code;
                $insert['RESP_BODY'] = 'SUCCESS';
            } elseif ($sts_code == 400) {
                $get_body = $response->getBody();
                $resp = json_decode($get_body);
                $ret['sts_code'] = $sts_code;
                $ret['error'] = $resp->error;
                $insert['RESP_BODY'] = "{$get_body}";
            } elseif ($sts_code == 500) {
                $ret['sts_code'] = $sts_code;
            } else {
                $get_body = $response->getBody();
                $resp = json_decode($get_body);
                $ret['sts_code'] = $sts_code;
                $ret['error'] = $resp->error;
                $insert['RESP_BODY'] = "{$get_body}";
            }
        }

        $req_body_enc = json_encode($req_body);
        $req_head_enc = json_encode($auth_b);
        $req_mode = json_encode($req_mode);
        $insert['REQ_BODY'] = "{$req_body_enc}";
        $insert['REQ_HEADER'] = "{$req_head_enc}";
        $insert['SIGN_MODE'] = "{$req_mode}";
        $this->db->insert('LOG_REQ_ESIGN_HIST', $insert);
        return $ret;
    }

    public function tes_pdf()
    {

        // $rowid = '320314000300901480';
        // $rowid = '320316000601814510';
        //// APART
        // $rowid = '320314000403417700';
        $rowid = '320319101203602700';



        // echo $rowid;

        $qq = "SELECT TRIM(R.NIK)||R.KD_PROPINSI||R.KD_DATI2||R.KD_KECAMATAN||R.KD_KELURAHAN||R.KD_BLOK||R.NO_URUT||R.KD_JNS_OP as NIKNOP, R.FLG_SPPT_BSRE, TRIM(R.NIK) AS NIK,
             R.KD_PROPINSI, R.KD_DATI2, R.KD_KECAMATAN, R.KD_KELURAHAN, R.KD_BLOK, R.NO_URUT, R.KD_JNS_OP, R.THN_PAJAK_BAYAR
             FROM REG_ESPPT R
             WHERE R.KD_PROPINSI||R.KD_DATI2||R.KD_KECAMATAN||R.KD_KELURAHAN||R.KD_BLOK||R.NO_URUT||R.KD_JNS_OP = '$rowid'";
        $aa = $this->db->query($qq)->row();
        // echo json_encode($aa);
        //var_dump($aa);die();
        //
        $this->create_pdf($aa->NIK, $aa->NIKNOP, $aa->KD_PROPINSI, $aa->KD_DATI2, $aa->KD_KECAMATAN, $aa->KD_KELURAHAN, $aa->KD_BLOK, $aa->NO_URUT, $aa->KD_JNS_OP, date('Y'));
    }

    public function index()
    {
        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect('eadm_bogor');
        }

        $data['page_menu'] = 'sppt_bsre';
        $data['current'] = '';
        $data['apps']    = $this->apps_model->get_active_only();
        $option = array(
            '0' => 'Belum Approve BSRE',
            '999' => 'Semua Status', 
            '1' => 'Sudah Approve BSRE'
        );
        $js  = 'id="status_kd" style="width:130px;" class="input select2 form-control" ';
        $select = form_dropdown('status_kd', $option, '', $js);
        $data['select_status'] = $select;

        ////////////////////////////////////////////////////////////////////////
        $select_kec = $this->sppt_bsre_model->droplist_kecamatan();
        $optionkec = array('999999'  => 'Semua Kec');
        foreach ($select_kec as $key => $aa) {
            $optionkec[$aa->KD_KECAMATAN] = $aa->NM_KECAMATAN;
        }
        $js  = 'id="kd_kecamatan" style="width:130px;" class="input select2 form-control" onChange="f_chg_kec_all(this.value)" ';
        $select = form_dropdown('kd_kecamatan', $optionkec, '', $js);
        $data['select_kecamatan'] = $select;
        ////////////////////////////////////////////////////////////////////////
        $select_thn = $this->sppt_bsre_model->droplist_tahun();
        $optionthn = array('999999'  => 'Semua Tahun');
        foreach ($select_thn as $key => $aa) {
            $optionthn[$aa->THN_PAJAK_BAYAR] = $aa->THN_PAJAK_BAYAR;
        }
        $js  = 'id="thn_pajak" style="width:100px;" class="input select2 form-control" ';
        $select = form_dropdown('thn_pajak', $optionthn, '', $js);
        $data['select_tahun'] = $select;
        ////////////////////////////////////////////////////////////////////////
        $select_kel = $this->sppt_bsre_model->droplist_kelurahan_all('999999');
        // $optionkel = array( '999999'  => 'Semua Kel' );
        if ($select_kel) {
            foreach ($select_kel as $key => $aa) {
                $optionkel[$aa->KD_KELURAHAN] = $aa->NM_KELURAHAN;
            }
        }
        $js  = 'id="kd_kelurahan" style="width:130px;" class="input select2 form-control" ';
        $select = form_dropdown('kd_kelurahan', $optionkel, '', $js);
        $data['select_kelurahan'] = $select;
        ////////////////////////////////////////////////////////////////////////
        // $datas=$this->session->userdata('username');
        // var_dump($datas);die();
        $this->load->view('vsppt_bsre', $data);
    }
    function f_chg_kec_all()
    {

        $kec_id    = $this->uri->segment(4);
        $kelurahan = $this->sppt_bsre_model->droplist_kelurahan_all($kec_id);
        echo json_encode($kelurahan);
    }
    function f_chg_kec_all_sim()
    {

        $kec_id    = $this->uri->segment(4);
        $kelurahan = $this->sppt_bsre_model->droplist_kelurahan_all($kec_id);
        echo json_encode($kelurahan);
    }

    public function grid()
    {

        //$prop = sipkd_kd_propinsi();
        //log_message('info', "BBBBBBBBBB CREATE MODULE : " .$prop );
        $status_kd = $this->input->get('status_kd');
        $thn_pajak = $this->input->get('thn_pajak');
        $kecamatan = $this->input->get('kec');
        $kelurahan = $this->input->get('kel');
        $c_nop     = $this->input->get('c_nop');
        $c_nop     = str_replace(".", "", $c_nop);
        $c_nop     = str_replace("-", "", $c_nop);
        $select = "ROWIDTOCHAR(R.ROWID) AS ID, CASE WHEN R.KD_PROPINSI IS NULL THEN '' ELSE TRIM(R.NIK)||R.KD_PROPINSI||R.KD_DATI2||R.KD_KECAMATAN||R.KD_KELURAHAN||R.KD_BLOK||R.NO_URUT||R.KD_JNS_OP END AS IDD,
          CASE WHEN R.KD_PROPINSI IS NULL THEN '' ELSE R.KD_PROPINSI||'.'||R.KD_DATI2||'-'||R.KD_KECAMATAN||'.'||R.KD_KELURAHAN||'-'||R.KD_BLOK||'.'||R.NO_URUT||'.'||R.KD_JNS_OP END AS NOP,
          R.JLN_OP_SPPT||' '||R.BLOK_KAV_NO_OP_SPPT AS ALAMAT_OP, R.NIK, R.NM_WP_SPPT, R.JLN_WP_SPPT||' '||R.BLOK_KAV_NO_WP_SPPT AS ALAMAT_WP, R.KELURAHAN_WP_SPPT, R.KOTA_WP_SPPT,
          CASE WHEN R.FLG_SPPT_BSRE=0 then 'Belum di approve (0)' WHEN R.FLG_SPPT_BSRE=1 then 'Sudah di Approve (1)' WHEN R.FLG_SPPT_BSRE=2 then 'Tolak (2)' END AS sts, STATUS,
          CASE WHEN R.KD_PROPINSI IS NULL THEN '' ELSE TRIM(R.NIK)||R.KD_PROPINSI||R.KD_DATI2||R.KD_KECAMATAN||R.KD_KELURAHAN||R.KD_BLOK||R.NO_URUT||R.KD_JNS_OP END AS NIKNOP,
          R.FLG_SPPT_BSRE";
        $this->load->library('Datatables');
        $this->datatables->select($select, false);
        $this->datatables->from('REG_ESPPT R', false);
        // if(!empty($status_kd) && $status_kd !='999'){
        //     if($status_kd == 'A'){
        //         $status_kd = '0';
        //     }
        //     $this->datatables->where('R.FLG_SPPT_BSRE',$status_kd);
    
        //     }
        if (!empty($kecamatan) && $kecamatan != '999999') {
            
            $this->datatables->where('R.KD_KECAMATAN', $kecamatan);
        }
        if ($status_kd != '999') {
            $this->datatables->where('R.FLG_SPPT_BSRE', $status_kd);
        }
        if (!empty($kelurahan) && $kelurahan != '999999') {

            $this->datatables->where('R.KD_KELURAHAN', $kelurahan);
        }
        if (!empty($c_nop) && $c_nop != '999') {
            $this->datatables->where("R.KD_PROPINSI||R.KD_DATI2||R.KD_KECAMATAN||R.KD_KELURAHAN||R.KD_BLOK||R.NO_URUT||R.KD_JNS_OP like '%{$c_nop}%'", false, false);
        }

        if (!empty($thn_pajak) && $thn_pajak != '999999') {

            $this->datatables->where('R.THN_PAJAK_BAYAR', $thn_pajak);
        }
        // if(empty($status)){
        $this->datatables->where('STATUS', 1);

        // }
        echo $this->datatables->generate();
        // var_dump(last_query());
    }


    private function fpost()
    {
        $data['rowid'] = post_string($this->input->post('rowid'));
        $data['nik'] = post_string($this->input->post('nik'));
        $data['passwd'] = post_string($this->input->post('passwd'));
        $data['nm_wp_sppt'] = post_string($this->input->post('nm_wp_sppt'));
        $data['jln_wp_sppt'] = post_string($this->input->post('jln_wp_sppt'));
        $data['blok_kav_no_wp_sppt'] = post_string($this->input->post('blok_kav_no_wp_sppt'));
        $data['rt_wp_sppt'] = post_string($this->input->post('rt_wp_sppt'));
        $data['rw_wp_sppt'] = post_string($this->input->post('rw_wp_sppt'));
        $data['kelurahan_wp_sppt'] = post_string($this->input->post('kelurahan_wp_sppt'));
        $data['kota_wp_sppt'] = post_string($this->input->post('kota_wp_sppt'));
        $data['kd_pos_wp_sppt'] = post_string($this->input->post('kd_pos_wp_sppt'));
        $data['npwp'] = post_string($this->input->post('npwp'));
        $data['nohp'] = post_string($this->input->post('nohp'));
        $data['email'] = post_string($this->input->post('email'));
        $data['jln_op_sppt'] = post_string($this->input->post('jln_op_sppt'));
        $data['blok_kav_no_op_sppt'] = post_string($this->input->post('blok_kav_no_op_sppt'));
        $data['rt_op_sppt'] = post_string($this->input->post('rt_op_sppt'));
        $data['rw_op_sppt'] = post_string($this->input->post('rw_op_sppt'));
        $data['nop_ttg_1'] = post_string($this->input->post('nop_ttg_1'));
        $data['nop_ttg_2'] = post_string($this->input->post('nop_ttg_2'));
        $data['alamat_op_1'] = post_string($this->input->post('alamat_op_1'));
        $data['alamat_op_2'] = post_string($this->input->post('alamat_op_2'));
        $data['kd_propinsi'] = post_string($this->input->post('kd_propinsi'));
        $data['kd_dati2']    = post_string($this->input->post('kd_dati2'));
        $data['kd_kecamatan'] = post_string($this->input->post('kd_kecamatan'));
        $data['kd_kelurahan'] = post_string($this->input->post('kd_kelurahan'));
        $data['kd_blok'] = post_string($this->input->post('kd_blok'));
        $data['no_urut'] = post_string($this->input->post('no_urut'));
        $data['kd_jns_op'] = post_string($this->input->post('kd_jns_op'));
        $data['kd_znt'] = post_string($this->input->post('kd_znt'));
        $data['alasan'] = post_string($this->input->post('alasan'));
        return $data;
    }


    public function action()
    {
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
            redirect(active_module_url('sppt_bsre'));
        }

        $p_id  = $this->uri->segment(4);
        // $p_id  = $this->input->get('row_id', true);
        // $p_id  = $_GET['row_id'];
        // echo $p_id;
        // die();

        $rowid = $p_id;

        $data['page_menu'] = 'sppt_bsre';
        $data['current'] = '';
        $data['apps']    = $this->apps_model->get_active_only();
        // $data['faction'] = active_module_url("sppt_bsre/update/{$p_id}");
        $data['faction'] = "";

        if ($p_id && $get = $this->sppt_bsre_model->get_by_nik($p_id)) {
            $data['dt']['rowid'] = $get->ID;
            $data['dt']['nik'] = get_string($get->NIK);
            $data['dt']['passwd'] = get_string($get->PASSWOD);
            $data['dt']['nm_wp_sppt']    = get_string($get->NM_WP_SPPT);
            $data['dt']['jln_wp_sppt'] = get_string($get->JLN_WP_SPPT);
            $data['dt']['blok_kav_no_wp_sppt'] = get_string($get->BLOK_KAV_NO_WP_SPPT);
            $data['dt']['rt_wp_sppt'] = get_string($get->RT_WP_SPPT);
            $data['dt']['rw_wp_sppt'] = get_string($get->RW_WP_SPPT);
            $data['dt']['kelurahan_wp_sppt'] = get_string($get->KELURAHAN_WP_SPPT);
            $data['dt']['kota_wp_sppt'] = get_string($get->KOTA_WP_SPPT);
            $data['dt']['kd_pos_wp_sppt'] = get_string($get->KD_POS_WP_SPPT);
            $data['dt']['npwp'] = get_string($get->NPWP_SPPT);
            $data['dt']['nohp'] = get_string($get->NOHP);
            $data['dt']['email'] = get_string($get->EMAIL);

            $data['dt']['jln_op_sppt'] = get_string($get->JLN_OP_SPPT);
            $data['dt']['blok_kav_no_op_sppt'] = get_string($get->BLOK_KAV_NO_OP_SPPT);
            $data['dt']['rt_op_sppt'] = get_string($get->RT_OP_SPPT);
            $data['dt']['rw_op_sppt'] = get_string($get->RW_OP_SPPT);
            $data['dt']['nop_ttg_1'] = get_string($get->NOP_TTG_1);
            $data['dt']['nop_ttg_2'] = get_string($get->NOP_TTG_2);
            // $data['dt']['nama_wp_1'] = get_string($get->NAMA_WP_1);
            // $data['dt']['nama_wp_2'] = get_string($get->NAMA_WP_2);
            $data['dt']['alamat_op_1'] = get_string($get->JLN_OP_SPPT1);
            $data['dt']['alamat_op_2'] = get_string($get->JLN_OP_SPPT2);

            // $data['dt']['im_ktp_new'] = get_string($get->IM_KTP_NEW);
            // $data['dt']['im_lamp1_new'] = get_string($get->IM_LAMP1_NEW);
            // $data['dt']['im_lamp2_new'] = get_string($get->IM_LAMP2_NEW);
            // $data['dt']['im_lamp3_new'] = get_string($get->IM_LAMP3_NEW);
            // $data['dt']['im_lamp4_new'] = get_string($get->IM_LAMP4_NEW);
            // $data['dt']['im_lamp5_new'] = get_string($get->IM_LAMP5_NEW);
            // $data['dt']['im_lamp6_new'] = get_string($get->IM_LAMP6_NEW);
            // $data['dt']['im_lamp7_new'] = get_string($get->IM_LAMP7_NEW);

            // $data['dt']['im_ktp'] = $get->IM_KTP->load();
            // $data['dt']['im_lamp1'] = $get->IM_LAMP1->load();
            // $data['dt']['im_lamp2'] = $get->IM_LAMP2->load();
            // $data['dt']['im_lamp3'] = $get->IM_LAMP3->load();
            // $data['dt']['im_lamp4'] = $get->IM_LAMP4->load();
            // $data['dt']['im_lamp5'] = $get->IM_LAMP5->load();
            // $data['dt']['im_lamp6'] = $get->IM_LAMP6->load();
            // $data['dt']['im_lamp7'] = $get->IM_LAMP7->load();

            $this->load->view('vsppt_bsre_form', $data);
        } else {
            show_404();
        }
    }

    public function detail()
    {
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
            redirect(active_module_url('sppt_bsre'));
        }

        $p_id  = $this->uri->segment(4);
        $rowid = $p_id;

        $data['page_menu'] = 'sppt_bsre';
        $data['current'] = '';
        $data['apps']    = $this->apps_model->get_active_only();
        // $data['faction'] = active_module_url("sppt_bsre/update/{$p_id}");
        $data['faction'] = "";

        if ($p_id && $get = $this->sppt_bsre_model->get_by_niknop($p_id)) {
            $data['dt']['rowid'] = $get->ID;
            $data['dt']['nik'] = get_string($get->NIK);
            $data['dt']['passwd'] = get_string($get->PASSWOD);
            $data['dt']['nm_wp_sppt']    = get_string($get->NM_WP_SPPT);
            $data['dt']['jln_wp_sppt'] = get_string($get->JLN_WP_SPPT);
            $data['dt']['blok_kav_no_wp_sppt'] = get_string($get->BLOK_KAV_NO_WP_SPPT);
            $data['dt']['rt_wp_sppt'] = get_string($get->RT_WP_SPPT);
            $data['dt']['rw_wp_sppt'] = get_string($get->RW_WP_SPPT);
            $data['dt']['kelurahan_wp_sppt'] = get_string($get->KELURAHAN_WP_SPPT);
            $data['dt']['kota_wp_sppt'] = get_string($get->KOTA_WP_SPPT);
            $data['dt']['kd_pos_wp_sppt'] = get_string($get->KD_POS_WP_SPPT);
            $data['dt']['npwp'] = get_string($get->NPWP_SPPT);
            $data['dt']['nohp'] = get_string($get->NOHP);
            $data['dt']['email'] = get_string($get->EMAIL);
            $data['dt']['nop_lengkap'] = $get->NOP_LENGKAP;
            $data['dt']['jln_op_sppt'] = get_string($get->JLN_OP_SPPT);
            $data['dt']['blok_kav_no_op_sppt'] = get_string($get->BLOK_KAV_NO_OP_SPPT);
            $data['dt']['rt_op_sppt'] = get_string($get->RT_OP_SPPT);
            $data['dt']['rw_op_sppt'] = get_string($get->RW_OP_SPPT);
            $data['dt']['nop_ttg_1'] = '';
            $data['dt']['nop_ttg_2'] = '';
            $data['dt']['loginname'] = get_string($get->LOGINNAME);
            $data['dt']['kecamatan_op_nama'] = get_string($get->NM_KECAMATAN);
            $data['dt']['kelurahan_op_nama'] = get_string($get->NM_KELURAHAN);

            // $data['dt']['im_ktp_new'] = get_string($get->IM_KTP_NEW);
            // $data['dt']['im_lamp1_new'] = get_string($get->IM_LAMP1_NEW);
            // $data['dt']['im_lamp2_new'] = get_string($get->IM_LAMP2_NEW);
            // $data['dt']['im_lamp3_new'] = get_string($get->IM_LAMP3_NEW);
            // $data['dt']['im_lamp4_new'] = get_string($get->IM_LAMP4_NEW);
            // $data['dt']['im_lamp5_new'] = get_string($get->IM_LAMP5_NEW);
            // $data['dt']['im_lamp6_new'] = get_string($get->IM_LAMP6_NEW);
            // $data['dt']['im_lamp7_new'] = get_string($get->IM_LAMP7_NEW);

            // $data['dt']['im_ktp'] = $get->IM_KTP->load();
            // $data['dt']['im_lamp1'] = $get->IM_LAMP1->load();
            // $data['dt']['im_lamp2'] = $get->IM_LAMP2->load();
            // $data['dt']['im_lamp3'] = $get->IM_LAMP3->load();
            // $data['dt']['im_lamp4'] = $get->IM_LAMP4->load();
            // $data['dt']['im_lamp5'] = $get->IM_LAMP5->load();
            // $data['dt']['im_lamp6'] = $get->IM_LAMP6->load();
            // $data['dt']['im_lamp7'] = $get->IM_LAMP7->load();

            $this->load->view('vsppt_bsre_form_view', $data);
        } else {
            echo 'Data tidak ada';
        }
    }

    function buat_sppt_sim()
    {
        // $nik_esign = NIK_ESIGN_DEV;
        $id_user = sipkd_user_id();
        $qr1 = "SELECT U.*
                FROM SEC_USERS U WHERE U.ID='$id_user'";
        $zzz = $this->db->query($qr1)->row();

        if ($zzz){
            $nik_esign = $zzz->NIK;

            if ($zzz->FLG_TTD_BSRE == 1){
                $passphrase = $this->input->post('passphrase');
                $tahun_now = date('Y-m-d');
                if (isset($_POST['rowidd'])) {
                    if (count($_POST) > 0) {
                        $fail = 0;
                        $msg = '';
                        for ($i = 0; $i < count($_POST['rowidd']); $i++) {
                            $rowid = $_POST['rowidd'][$i];
                            $qq = "SELECT TRIM(R.NIK)||R.KD_PROPINSI||R.KD_DATI2||R.KD_KECAMATAN||R.KD_KELURAHAN||R.KD_BLOK||R.NO_URUT||R.KD_JNS_OP as NIKNOP,
                            R.KD_PROPINSI||R.KD_DATI2||R.KD_KECAMATAN||R.KD_KELURAHAN||R.KD_BLOK||R.NO_URUT||R.KD_JNS_OP as NOP, R.FLG_SPPT_BSRE,
                            TRIM(R.NIK) AS NIK, R.KD_PROPINSI, R.KD_DATI2, R.KD_KECAMATAN, R.KD_KELURAHAN, R.KD_BLOK, R.NO_URUT, R.KD_JNS_OP, R.THN_PAJAK_BAYAR
                            FROM REG_ESPPT R WHERE ROWID='$rowid'";
                            // var_dump($qq);die;
                            $aa = $this->db->query($qq)->row();
                            if ($aa->FLG_SPPT_BSRE != 1) {
                                $nop = $aa->NOP;
                                $get_thn_terahir_sppt = "SELECT MAX(THN_PAJAK_SPPT) AS THN_TERAKHIR_SPPT FROM SPPT
                                                WHERE KD_PROPINSI||KD_DATI2||KD_KECAMATAN||KD_KELURAHAN||KD_BLOK||NO_URUT||KD_JNS_OP='{$nop}'";
                                $res_thn = $this->db->query($get_thn_terahir_sppt)->row();
                                $thn_terakhir = $res_thn->THN_TERAKHIR_SPPT;
                                $niknop = $aa->NIKNOP;
                                $file_name = 'SPPT_' . $thn_terakhir . '_' . $niknop;
                                $file_name_sign = $file_name . SIGNED_MARK;
                                $usercreated = $this->session->userdata('username');
                                $tahun = date("Y-m-d");
                                $img_qr = $file_name . '.png';
                                $qa = "UPDATE REG_ESPPT SET FILE_SPPT='{$file_name}', IMG_QR='{$img_qr}'
                            WHERE TRIM(NIK)||KD_PROPINSI||KD_DATI2||KD_KECAMATAN||KD_KELURAHAN||KD_BLOK||NO_URUT||KD_JNS_OP='{$niknop}'";
    
    
                                $this->build_qr($niknop, $file_name);
                                $this->create_pdf($aa->NIK, $aa->NIKNOP, $aa->KD_PROPINSI, $aa->KD_DATI2, $aa->KD_KECAMATAN, $aa->KD_KELURAHAN, $aa->KD_BLOK, $aa->NO_URUT, $aa->KD_JNS_OP, $thn_terakhir);
                                $this->db->query($qa);
                                $esign = $this->esign_doc($file_name, $nik_esign, $passphrase, '530', '60', '470', '125', 1, 'sppt_rpt_esign', '#');
                                // var_dump($esign);die();
                                if ($esign['sts_code'] == 200) {
                                    $qb = "UPDATE REG_ESPPT SET FILE_SPPT_BSRE='{$file_name_sign}', FLG_SPPT_BSRE='1',FLG_KIRIM_SPPT ='0', THN_APPROVE_ESPPT='{$thn_terakhir}',USR_SPPT='{$usercreated}',CREATE_TIME='{$tahun}' WHERE TRIM(NIK)||KD_PROPINSI||KD_DATI2||KD_KECAMATAN||KD_KELURAHAN||KD_BLOK||NO_URUT||KD_JNS_OP='{$niknop}'";
                                    $this->db->query($qb);
                                } else {
                                    $msg = $esign['error'];
                                    $fail += 1;
                                }
                            }
                        }
                        if ($fail > 0) {
                            $this->session->set_flashdata('msg_warning', $msg);
                        } else {
                            $this->session->set_flashdata('msg_success', "Berhasil Kirim ke BSRE");
                        }
    
                        redirect(active_module_url() . 'sppt_bsre');
                    }
                }
            } else {
                $this->session->set_flashdata('msg_warning', 'Data User Tidak Memiliki Hak Akses TTD BSRE');
                redirect(active_module_url() . 'sppt_bsre');
            }

            
        } else {
            $this->session->set_flashdata('msg_warning', 'Data User BSRE Tidak Ditemukan');
            redirect(active_module_url() . 'sppt_bsre');
        }

        
    }

    function cetak_orc()
    {
        $p_id = $this->uri->segment(4);
        $qq = "SELECT TRIM(R.NIK)||R.KD_PROPINSI||R.KD_DATI2||R.KD_KECAMATAN||R.KD_KELURAHAN||R.KD_BLOK||R.NO_URUT||R.KD_JNS_OP as NIKNOP, R.FLG_SPPT_BSRE, TRIM(R.NIK) AS NIK, R.KD_PROPINSI, R.KD_DATI2, R.KD_KECAMATAN, R.KD_KELURAHAN, R.KD_BLOK, R.NO_URUT, R.KD_JNS_OP, R.THN_PAJAK_BAYAR FROM REG_ESPPT R WHERE TRIM(R.NIK)||R.KD_PROPINSI||R.KD_DATI2||R.KD_KECAMATAN||R.KD_KELURAHAN||R.KD_BLOK||R.NO_URUT||R.KD_JNS_OP='$p_id'";
        $aa = $this->db->query($qq)->row();
        // $tahun = empty
        $this->show_pdf($aa->NIK, $aa->NIKNOP, $aa->KD_PROPINSI, $aa->KD_DATI2, $aa->KD_KECAMATAN, $aa->KD_KELURAHAN, $aa->KD_BLOK, $aa->NO_URUT, $aa->KD_JNS_OP, date('Y'));
    }


    function create_pdf_old_190922($nik, $niknop, $kd_prop, $kd_dati2, $kd_kec, $kd_kel, $kd_blok, $no_urut, $kd_jns_op, $tahun_sppt)
    {
        $pjb = $this->sppt_bsre_model->get_pejabat_ttd(10);
        $params = array(
            'background_img' => FCPATH . 'assets/img/blanko_sppt_bgr.jpeg',
            'tahun_sppt' => $tahun_sppt,
            'kd_prop' => $kd_prop,
            'kd_dati2' => $kd_dati2,
            'kd_kecamatan' => $kd_kec,
            'kd_kelurahan' => $kd_kel,
            'kd_blok' => $kd_blok,
            'no_urut' => $no_urut,
            'kd_jns_op' => $kd_jns_op,
            'nm_pejabat' => $pjb->NM_PEGAWAI,
            'nip_pejabat' => $pjb->NIP,
            'logo_bsre' => FCPATH . 'assets/img/logo-bsre_1.png',
            'blanko_back2' => FCPATH . 'assets/img/palingbawah.png',
            'blanko_back' => FCPATH . 'assets/img/blanko_sppt_back.jpg'
        );
        $rpt = 'sppt_rpt_esign';
        $file_name =  'SPPT_' . $tahun_sppt . '_' . $niknop;
        $jasper = $this->load->library('Jasper_ora');
        // echo $jasper->cetak_ora($rpt, $params, $type, false);
        echo $jasper->export_pdf_jrx($rpt, $params, 'pdf', false, FOLDER_DRAFT_ESIGN, $file_name);
    }

    function create_pdf($nik, $niknop, $kd_prop, $kd_dati2, $kd_kec, $kd_kel, $kd_blok, $no_urut, $kd_jns_op, $tahun_sppt)
    {
        $pjb = $this->sppt_bsre_model->get_pejabat_ttd(10);
        $params = array(
            'background_img' => FCPATH . 'assets/img/blanko_sppt_bgr.jpeg',
            'tahun_sppt' => $tahun_sppt,
            'tahun_sppt_1' => $tahun_sppt - 1,
            'tahun_sppt_2' => $tahun_sppt - 2,
            'tahun_sppt_3' => $tahun_sppt - 3,
            'tahun_sppt_4' => $tahun_sppt - 4,
            'tahun_sppt_5' => $tahun_sppt - 5,
            'tahun_sppt_6' => $tahun_sppt - 6,
            'kd_prop' => $kd_prop,
            'kd_dati2' => $kd_dati2,
            'kd_kecamatan' => $kd_kec,
            'kd_kelurahan' => $kd_kel,
            'kd_blok' => $kd_blok,
            'no_urut' => $no_urut,
            'kd_jns_op' => $kd_jns_op,
            'nm_pejabat' => $pjb->NM_PEGAWAI,
            'nip_pejabat' => $pjb->NIP,
            'logo_bsre' => FCPATH . 'assets/img/logo-bsre_1.png',
            'background_img2' => FCPATH . 'assets/img/palingbawah.jpg',
            'blanko_back' => FCPATH . 'assets/img/blanko_sppt_back.jpg'
        );
        // var_dump($pjb);die();
        $rpt = 'sppt_rpt_esign';
        $file_name =  'SPPT_' . $tahun_sppt . '_' . $niknop;
        $jasper = $this->load->library('Jasper_ora');
        //var_dump($jasper);die();
         //echo $jasper->cetak_ora($rpt, $params, 'pdf', false);
        echo $jasper->export_pdf_jrx($rpt, $params, 'pdf', false, FOLDER_DRAFT_ESIGN, $file_name);
    }

    function show_pdf($nik, $niknop, $kd_prop, $kd_dati2, $kd_kec, $kd_kel, $kd_blok, $no_urut, $kd_jns_op, $thn_pajak_bayar)
    {
        $pjb = $this->sppt_bsre_model->get_pejabat_ttd(10);
        $pbb_p = $this->sppt_bsre_model->q_cetak_sppt($thn_pajak_bayar, $kd_prop, $kd_dati2, $kd_kec, $kd_kel, $kd_blok, $no_urut, $kd_jns_op);
        $params = array(
            'background_img' => FCPATH . 'assets/img/blanko_sppt_bgr.jpeg',
            'tahun_sppt' => $thn_pajak_bayar,
            'terbilang_bayarpbb' => terbilang($pbb_p->PBB_YG_HARUS_DIBAYAR_SPPT),
            'kd_prop' => $kd_prop,
            'kd_dati2' => $kd_dati2,
            'kd_kecamatan' => $kd_kec,
            'kd_kelurahan' => $kd_kel,
            'kd_blok' => $kd_blok,
            'no_urut' => $no_urut,
            'kd_jns_op' => $kd_jns_op,
            'nm_pejabat' => $pjb->NM_PEGAWAI,
            'nip_pejabat' => $pjb->NIP,
            'logo_bsre' => FCPATH . 'assets/img/logo-bsre_1.png',
            'background_img2' => FCPATH . 'assets/img/palingbawah.jpg',
            'blanko_back' => FCPATH . 'assets/img/blanko_sppt_back.jpg'
        );
        $tahun_sppt = $params['tahun_sppt'];
        $kd_kecamatan = $params['kd_kecamatan'];
        $kd_kelurahan = $params['kd_kelurahan'];
        $nm_pejabat = $params['nm_pejabat'];
        include 'query_sppt.php';
        $rpt = 'sppt_rpt_esign';
        // $rpt = 'test_rep';
        $file_name =  'SPPT_' . $niknop;
        $jasper = $this->load->library('Jasper_ora');
        echo $jasper->cetak_ora($rpt, $params, 'pdf', false);
    }

    function esign_doc($namafile, $nik_esign, $pass_esign, $xAxis, $yAxis, $width, $height, $page, $rpt, $tag = null)
    {
        // $this->cek_koneksi($nik_esign);
        $base_uri = IP_KOMINFO . 'api/';
        $_client = new Client([
            'base_uri' => $base_uri,
            'http_errors' => false
        ]);


        $api_sign = 'sign/pdf';
        $auth = [AUTH_USER_ESIGN, AUTH_PASS_ESIGN];
        $aa = "SELECT FN_KEYLOCK('{$auth[0]}','{$auth[1]}') AS PASS_AUTH FROM DUAL";
        $ab = $this->db->query($aa)->row();
        // var_dump(last_query());die();
        $ba = "SELECT FN_KEYLOCK('{$nik_esign}','{$pass_esign}') AS PASSPHRASE FROM DUAL";
        $bb = $this->db->query($ba)->row();
        $auth_a = new stdClass();
        $auth_a->username = $auth[0];
        $auth_a->password = $ab->PASS_AUTH;
        $auth_b = array('auth' => [$auth[0], $ab->PASS_AUTH]);
        $req_mode = array('mode' => ['create_sppt', $rpt]);
        $tag_koordinat = ['name' => 'tag_koordinat', 'contents' => $tag];
        // $req_body = array('api'=>$base_uri,'nik'=>$nik_esign, 'passphrase'=>$bb->PASSPHRASE, 'tampilan'=>'true','page'=>$page,'image'=>'true', 'xAxis'=>$xAxis, 'yAxis'=>$yAxis,'width'=>$width,'height'=>$height);
        // $req_body = array('url'=> $base_uri.$api_sign);

        $req_body = array('api' => $base_uri, 'nik' => $nik_esign, 'passphrase' => $pass_esign, 'tampilan' => 'true', 'page' => $page, 'image' => 'true', 'xAxis' => $xAxis, 'yAxis' => $yAxis, 'width' => $width, 'height' => $height);
        // $req_body = array('api'=>$base_uri,'nik'=>$nik_esign, 'passphrase'=>$pass_esign, 'tampilan'=>'true','page'=>$page,'image'=>'true', 'tag_koordinat'=>'^^^^','width'=>$width,'height'=>$height);
        $response = $_client->request('POST', $api_sign, [
            'auth' => $auth,
            'multipart' => [
                ['name' => 'nik', 'contents' => $nik_esign],
                ['name' => 'passphrase', 'contents' => $pass_esign],
                ['name' => 'tampilan', 'contents' => 'visible'],
                ['name' => 'page', 'contents' => $page],
                ['name' => 'image', 'contents' => 'true'],
                // ['name'=>'xAxis','contents'=> '530'],
                // ['name'=>'yAxis','contents'=> '60'],
                // ['name'=>'width','contents'=> '470'],
                // ['name'=>'height','contents'=> '125'],

                ['name' => 'xAxis', 'contents' => '450'],
                ['name' => 'yAxis', 'contents' => '60'],
                ['name' => 'width', 'contents' => '520'],
                ['name' => 'height', 'contents' => '250'],
                // ['name'=>'tag_koordinat','contents'=>'^^^^'],
                ['name' => 'file', 'contents' =>  Psr7\Utils::tryFopen(FOLDER_DRAFT_ESIGN . $namafile . '.pdf', 'r')],
                ['name' => 'imageTTD', 'contents' => Psr7\Utils::tryFopen(FOLDER_QR . $namafile . '.png', 'r')]
            ]
        ]);
        // var_dump($response);die();

        $sts_code = $response->getStatusCode();
        $ret = array();
        $insert = array('STATUS_CODE' => $response->getStatusCode(), 'USERID' => sipkd_user_login(), 'CREATED_DATE' => date('Y-m-d H:i:s'));
        if (empty($sts_code)) {
            $get_body = 'Request API Error';
            // $resp = json_decode($get_body);
            $ret['sts_code'] = 500;
            $ret['error'] = 'Request API Error';
            $insert['RESP_BODY'] = "{$get_body}";
        } else {
            if ($sts_code == 200) {
                if ($response->hasHeader('id_dokumen')) {
                    $id_dokumen = $response->getHeader('id_dokumen')[0];
                    file_put_contents(FOLDER_ESIGN . $namafile . SIGNED_MARK . '.pdf', $response->getBody(), FILE_APPEND);
                }
                $ret['sts_code'] = $sts_code;
                $insert['RESP_BODY'] = 'SUCCESS';
            } elseif ($sts_code == 400) {
                $get_body = $response->getBody();
                $resp = json_decode($get_body);
                $ret['sts_code'] = $sts_code;
                $ret['error'] = $resp->error;
                $insert['RESP_BODY'] = "{$get_body}";
            } elseif ($sts_code == 500) {
                $ret['sts_code'] = $sts_code;
            } else {
                $get_body = $response->getBody();
                $resp = json_decode($get_body);
                $ret['sts_code'] = $sts_code;
                $ret['error'] = $resp->error;
                $insert['RESP_BODY'] = "{$get_body}";
            }
        }

        $req_body_enc = json_encode($req_body);
        $req_head_enc = json_encode($auth_b);
        $req_mode = json_encode($req_mode);
        $insert['REQ_BODY'] = "{$req_body_enc}";
        $insert['REQ_HEADER'] = "{$req_head_enc}";
        $insert['SIGN_MODE'] = "{$req_mode}";
        $this->db->insert('LOG_REQ_ESIGN_HIST', $insert);
        return $ret;
    }

    public function build_qr($data_qr, $file_pdf)
    {
        $folder_qrcode = FOLDER_QR;
        if (!file_exists($folder_qrcode)) {
            mkdir($folder_qrcode, 0777);
            exit;
        }
        $this->load->library('ciqrcode');
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './' . $folder_qrcode; //string, the default is application/cache/
        $config['errorlog']     = './' . $folder_qrcode; //string, the default is application/logs/
        $config['imagedir']     = './' . $folder_qrcode; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224, 255, 255); // array, default is array(255,255,255)
        $config['white']        = array(0, 0, 0); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);

        $image_name = $file_pdf . '.png'; //buat name dari qr code sesuai dengan url file pdf
        $isiqr = base_url() . 'wp_sppt/ctk_sppt/' . $data_qr;
        $params['data'] = $isiqr; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH . $config['imagedir'] . '/' . $image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params);
        // $this->qr_code_logo($image_name);
    }

    function test_simultan()
    {
        for ($i = 0; $i < count($_POST['rowidd']); $i++) {
            $rowid = $_POST['rowidd'][$i];
        }
    }

    function cetak_draft()
    {

        $qs   = urldecode($_SERVER['QUERY_STRING']);
        parse_str($qs, $qs_data);
        $type = 'pdf';
        $params = array(
            'background_img' => FCPATH . 'assets/img/blanko_sppt_bgr.jpeg',
            'tahun_sppt' => $tahun,
            'terbilang_bayarpbb' => terbilang($pbb_p),
            'kd_prop' => '32',
            'kd_dati2' => '03',
            'kd_kecamatan' => '140',
            'kd_kelurahan' => '001',
            'kd_blok' => '001',
            'no_urut' => '0001',
            'kd_jns_op' => '0',
            'nm_pejabat' => $pjb->NM_PEGAWAI,
            'nip_pejabat' => $pjb->NIP
        );

        //$rpt = $nm_rpt;
        $rpt = 'sppt_rpt_bogor';

        $jasper = $this->load->library('Jasper_ora');
        echo $jasper->cetak_ora($rpt, $params, $type, false);
        // echo $jasper->cetak_byjasper($rpt, $params, $type, false);
    }

    function pdf_look()
    {
        $p_id = $this->uri->segment(4);
        $qq = "SELECT FILE_SPPT_BSRE FROM REG_ESPPT WHERE TRIM(NIK)||KD_PROPINSI||KD_DATI2||KD_KECAMATAN||KD_KELURAHAN||KD_BLOK||NO_URUT||KD_JNS_OP='{$p_id}'";
        $xx = $this->db->query($qq)->row();
        // var_dump($xx);die;        
        $file = FCPATH . FOLDER_ESIGN . $xx->FILE_SPPT_BSRE . '.pdf';
        // var_dump($file);die();
        if (file_exists($file)) {
            //
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: private');
            header('Pragma: private');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
        } else {
            echo "Dokumen tersebut tidak ada...!";
        }
    }

    public function openblob()
    {
        $field       = $this->uri->segment(4);
        $nik       = $this->uri->segment(5);
        $field = strtoupper($field);

        $dbhost = DB_HOST;
        $dbport = DB_PORT;
        $dbname = DB_NAME;
        $dbuser = DB_USER;
        $dbpass = DB_PASS;

        $tnslistener = '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=' . DB_HOST . ')(PORT=' . DB_PORT . '))(CONNECT_DATA=(SERVICE_NAME=' . DB_NAME . ')))';

        $connection = oci_connect($dbuser, $dbpass, $tnslistener);

        $sql = "SELECT {$field} FROM REG_ESPPTDB WHERE NIK = '{$nik}'";

        $stid = oci_parse($connection, $sql);

        oci_execute($stid);
        $row = oci_fetch_array($stid, OCI_RETURN_NULLS);

        if (!$row) {
            header('Status: 404 Not Found');
        } else {
            $img = $row[$field]->load();
            header("Content-type: application/pdf");
            print $img;
        }
    }
}
