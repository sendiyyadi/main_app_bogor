<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class pst_pembatalan extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('login')) {
            $this->session->set_flashdata('msg_warning', 'Session telah kadaluarsa, silahkan login ulang.');
            redirect('login');
            exit;
        }

        if (!is_super_admin() && !isset($this->session->userdata['tpnm'])) {
            show_404();
            exit;
        }

        $module = 'pst_pembatalan';
        $this->load->library('module_auth', array('module' => $module));

        $this->load->helper('app_helper');
        $this->load->model(array('apps_model', 'login_model', 'pst_sppt_pembatalan_model'));

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

        $data['page_menu'] = 'm01_mn_pemby_khusus';
        $data['current']   = 'pst_pembatalan';

        $filter         = $this->session->userdata('pos_filter');
        $filter         = isset($filter) ? $filter : '';
        $data['filter'] = $filter;
        $data['prefix'] = KD_PROPINSI . "." . KD_DATI2;
        $data['tpnm']   = isset($this->session->userdata['tpnm']) ? $this->session->userdata['tpnm'] : '';

        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = active_module_url('pst_pembatalan/update_pmd');

        //-----------------------------------------------------------------------
        $options = array(
            '1' => 'Penghapusan',
            '2' => 'Keberatan',
            '3' => 'Angsuran',
        );
        $js = 'id="jns_pel_id" name="jns_pel_id" class="input form-control select2" onchange="chgPel()" required ';
        $data['select_jns_pel'] = form_dropdown('jns_pel_id', $options, '1', $js);
        //-----------------------------------------------------------------------
        $options = array(
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
        );
        $js = 'id="angs_id" name="angs_id" class="input form-control select2" required ';
        $data['select_angsuran'] = form_dropdown('angs_id', $options, '1', $js);
        //-----------------------------------------------------------------------
        $this->load->view('pst_pembatalan/vpst_pembatalan', $data);
    }

    public function cari()
    {

        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect('pospbb_ora');
        }

        $nop      = get_string($this->input->get('nopd'));
        $thn      = get_string($this->input->get('thn'));
        $thn_p    = get_string($this->input->get('thn_p'));
        $bundel_p = get_string($this->input->get('bdl_p'));
        $urut_p   = get_string($this->input->get('urt_p'));
        $jns_p    = get_string($this->input->get('jns_p'));
        $angs_p   = get_string($this->input->get('angs_p'));
        $pmb_ke   = get_string($this->input->get('pmbke'));

        $nop_tmp = substr($nop, 5, 10);
        if (empty($thn_p) or empty($bundel_p) or empty($urut_p) or empty($nop_tmp) or empty($thn) or empty($pmb_ke)) {
            $result['found'] = 0;
            echo json_encode($result);
            exit;
        }
        //
        $bayar_id = 0;
        if ($query = $this->pst_sppt_pembatalan_model->cek_nopel_pembayaran($nop, $thn, $thn_p, $bundel_p, $urut_p, $pmb_ke, $angs_p, $jns_p)) {
            $bayar_id = $query->BAYAR_ID;
        } else {
            $result['found'] = 0;
            echo json_encode($result);
            exit;
        }
        //
        if ($jns_p == '1') {
            if ($query = $this->pst_sppt_pembatalan_model->get_nopel_hapus_btl($nop, $thn, $thn_p, $bundel_p, $urut_p, $pmb_ke)) {
                $terbilang = terbilang($query->JML_SPPT_YG_DIBAYAR);
                $query =  (object) array_merge((array)$query, array('found' => 1, 'terbilang' => $terbilang, 'bayar_id' => $bayar_id));
                echo json_encode($query);
                exit;
            }
        }
        if ($jns_p == '2') {
            if ($query = $this->pst_sppt_pembatalan_model->get_nopel_berat_btl($nop, $thn, $thn_p, $bundel_p, $urut_p, $pmb_ke)) {
                $terbilang = terbilang($query->JML_SPPT_YG_DIBAYAR);
                $query =  (object) array_merge((array)$query, array('found' => 1, 'terbilang' => $terbilang, 'bayar_id' => $bayar_id));
                echo json_encode($query);
                exit;
            }
        }
        if ($jns_p == '3') {
            if ($query = $this->pst_sppt_pembatalan_model->get_nopel_angsur_btl($nop, $thn, $thn_p, $bundel_p, $urut_p, $angs_p, $pmb_ke)) {
                $terbilang = terbilang($query->JML_SPPT_YG_DIBAYAR);
                $query =  (object) array_merge((array)$query, array('found' => 1, 'terbilang' => $terbilang, 'bayar_id' => $bayar_id));
                echo json_encode($query);
                exit;
            }
        }

        $result['found'] = 0;
        echo json_encode($result);
    }

    public function proses()
    {

        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
            redirect('pospbb_ora');
        }

        $nop      = get_string($this->input->get('nop'));
        $thn      = get_string($this->input->get('thn'));
        $thn_p    = get_string($this->input->get('thn_p'));
        $bundel_p = get_string($this->input->get('bdl_p'));
        $urut_p   = get_string($this->input->get('urt_p'));
        $jns_p    = get_string($this->input->get('jns_p'));
        $angs_p   = get_string($this->input->get('angs_p'));
        $pmb_ke   = get_string($this->input->get('pmbke'));
        $byr_id   = get_string($this->input->get('byr_id'));
        $bayar_id = 0;
        //log_message('info', " bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb  byr_id : ".$byr_id);
        $nop_tmp = substr($nop, 5, 10);
        if (empty($thn_p) or empty($bundel_p) or empty($urut_p) or empty($nop_tmp) or empty($thn) or empty($pmb_ke)) {
            echo 'No.Pelayanan / No. Objek Pajak / Tahun / Pemb Ke, harus di isi..!';
            exit;
        }
        //
        if ($query = $this->pst_sppt_pembatalan_model->cek_nopel_pembayaran($nop, $thn, $thn_p, $bundel_p, $urut_p, $pmb_ke, $angs_p, $jns_p)) {
            $bayar_id = $query->BAYAR_ID;
            if ($byr_id !== $bayar_id) {
                echo 'Data sudah tidak valid, silahkan Cari / Cek Ulang....!';
                exit;
            }
        } else {
            echo 'Data Tidak ditemukan, silahkan Cari / Cek Ulang....!';
            exit;
        }
        //cek pembayaran/pelunasan jenis pelayanan Penghapusan msh aktif/ada.
        if ($jns_p == '1') {
            if (!$this->pst_sppt_pembatalan_model->get_nopel_hapus_btl($nop, $thn, $thn_p, $bundel_p, $urut_p, $pmb_ke)) {
                echo 'Data pelayanan Penghapusan Tidak ditemukan, silahkan Cari Ulang..!';
                exit;
            }
        }
        //cek pembayaran/pelunasan jenis pelayanan Keberatan msh aktif/ada.
        if ($jns_p == '2') {
            if (!$this->pst_sppt_pembatalan_model->get_nopel_berat_btl($nop, $thn, $thn_p, $bundel_p, $urut_p, $pmb_ke)) {
                echo 'Data pelayanan Keberatan Tidak ditemukan, silahkan Cari Ulang..!';
                exit;
            }
        }
        //cek pembayaran/pelunasan jenis pelayanan Angsuran msh aktif/ada.
        if ($jns_p == '3') {
            if (!$this->pst_sppt_pembatalan_model->get_nopel_angsur_btl($nop, $thn, $thn_p, $bundel_p, $urut_p, $angs_p, $pmb_ke)) {
                echo 'Data pelayanan Angsuran Tidak ditemukan, silahkan Cari Ulang..!';
                exit;
            }
        }

        //cek pembayaran/pelunasan semua jenis pelayanan,bahwa sdh tidak ada lg pelunasan berikutnya yg aktif.
        if ($this->pst_sppt_pembatalan_model->cek_pmb_di_tengah($nop, $thn, $pmb_ke)) {
            echo 'no1';
            exit;
        }
        //Cek Jika Pembayaran u. Angsuran, cek angsuran berikutnya memang sdh dibatalkan atau tdk ada pembayaran/pelunasan
        if ($jns_p == '3' && $this->pst_sppt_pembatalan_model->cek_pmb_angs_di_tengah($thn_p, $bundel_p, $urut_p, $nop, $thn, $pmb_ke, $angs_p)) {
            echo 'no2';
            exit;
        }

        // blocking buat testing
        //echo 'Data di block buat testing ....!';
        //exit;

        //Proses u. Pemabayaran u. Penghapusan/Pengurangan.
        if ($jns_p == '1') {
            $query = $this->pst_sppt_pembatalan_model->cancel_nop_penghapusan($thn_p, $bundel_p, $urut_p, $nop, $thn, $pmb_ke, $byr_id);
            echo 'yes';
            exit;
        }
        //Proses Pembatalan u.Pembayaran Jns Penghapusan/Pengurangan.
        if ($jns_p == '2') {
            $query = $this->pst_sppt_pembatalan_model->cancel_nop_keberatan($thn_p, $bundel_p, $urut_p, $nop, $thn, $pmb_ke, $byr_id);
            echo 'yes';
            exit;
        }
        //Proses Pembatalan u.Pembayaran Jns Angsuran
        if ($jns_p == '3') {
            $query = $this->pst_sppt_pembatalan_model->cancel_nop_angsuran($thn_p, $bundel_p, $urut_p, $nop, $thn, $pmb_ke, $angs_p, $byr_id);
            echo 'yes';
            exit;
        }
    }
}
